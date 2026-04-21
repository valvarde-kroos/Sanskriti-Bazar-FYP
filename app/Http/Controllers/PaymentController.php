<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\VendorNewOrderNotification;
use Xentixar\EsewaSdk\Esewa;

class PaymentController extends Controller
{

    public function pay(Request $request)
    {
        $request->validate([
            'shipping_name' => 'required',
            'shipping_address' => 'required',
            'shipping_phone' => 'required',
            'payment_method' => 'required',
        ]);

        $user = auth()->user();

        $carts = Cart::where('user_id', $user->id)->with('product')->get();

        if ($carts->isEmpty()) {
            return back()->with('error', 'Cart is empty');
        }

        $totalAmount = 0;

        foreach ($carts as $cart) {
            $totalAmount += $cart->quantity * $cart->product->price;
        }

        $transaction_uuid = strtoupper(bin2hex(random_bytes(10)));

        // storing in session
        session([
            'transaction_uuid' => $transaction_uuid,
            'amount' => $totalAmount,
            'shipping_name' => $request->shipping_name,
            'shipping_address' => $request->shipping_address,
            'shipping_phone' => $request->shipping_phone,
        ]);

        if ($request->payment_method === 'cash_on_delivery') {
            return $this->handleCODOrder($user, $carts, $totalAmount);
        }

        $esewa = new Esewa();

        $esewa->config(
            route('esewa.check'),
            route('payment.failure'),
            $totalAmount,
            $transaction_uuid
        );

        $esewa->init();
    }

    public function check(Request $request)
    {
        $esewa = new Esewa();
        $data = $esewa->decode();

        if ($data && $data["status"] === 'COMPLETE') {

            $user = auth()->user();
            $carts = Cart::where('user_id', $user->id)->with('product')->get();

            if ($carts->isEmpty()) {
                return redirect()->route('home')->with('error', 'Cart empty');
            }

            DB::beginTransaction();

            try {
                $totalAmount = session('amount');

                // Creating Order
                $order = Order::create([
                    'user_id' => $user->id,
                    'product_id' => $carts->first()->product_id,
                    'quantity' => $carts->sum('quantity'),
                    'total_price' => $totalAmount,
                    'status' => 'completed',
                    'shipping_name' => session('shipping_name'),
                    'shipping_address' => session('shipping_address'),
                    'shipping_phone' => session('shipping_phone'),
                ]);

                // Saving Payment
                Payment::create([
                    'order_id' => $order->id,
                    'customer_id' => $user->id,
                    'amount' => str_replace(',', '', $data['total_amount']),
                    'total_amount' => str_replace(',', '', $data['total_amount']),
                    'transaction_uuid' => $data['transaction_code'],
                    'status' => 'success',
                    'payment_method' => 'esewa',
                ]);

                // Send email notification to vendor
                try {
                    $product = $order->product;
                    if ($product && $product->user) {
                        $vendor = $product->user;
                        if ($vendor->email) {
                            Mail::to($vendor->email)->send(new VendorNewOrderNotification($order, $vendor));
                            Log::info("Vendor email sent to {$vendor->email} for order #{$order->id}");
                        }
                    }
                } catch (\Exception $e) {
                    Log::error("Failed to send vendor email for order #{$order->id}: " . $e->getMessage());
                }

                // clearing Cart
                Cart::where('user_id', $user->id)->delete();

                DB::commit();

                return redirect()->route('payment.success');

            } catch (\Exception $e) {
                DB::rollBack();

                return redirect()->route('payment.failure')
                    ->with('error_message', 'Something went wrong');
            }
        }

        return redirect()->route('payment.failure')
            ->with('error_message', 'Payment failed');
    }

    private function handleCODOrder($user, $carts, $totalAmount)
    {
        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => $user->id,
                'product_id' => $carts->first()->product_id,
                'quantity' => $carts->sum('quantity'),
                'total_price' => $totalAmount,
                'status' => 'pending',
                'shipping_name' => session('shipping_name'),
                'shipping_address' => session('shipping_address'),
                'shipping_phone' => session('shipping_phone'),
            ]);

            // Send email notification to vendor for COD orders
            try {
                $product = $order->product;
                if ($product && $product->user) {
                    $vendor = $product->user;
                    if ($vendor->email) {
                        Mail::to($vendor->email)->send(new VendorNewOrderNotification($order, $vendor));
                        Log::info("Vendor email sent to {$vendor->email} for order #{$order->id}");
                    }
                }
            } catch (\Exception $e) {
                Log::error("Failed to send vendor email for order #{$order->id}: " . $e->getMessage());
            }

            Cart::where('user_id', $user->id)->delete();

            DB::commit();

            return redirect()->route('order.success');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Order failed');
        }
    }

    public function paymentFailure(Request $request)
    {
        $errorMessage = session('error_message', 'Payment failed. Please try again.');

        return view('payment-failure', compact('errorMessage'));
    }

    public function paymentSuccess()
    {
        $payment = Payment::latest()->where('customer_id', auth()->id())->first();

        return view('payment-success', [
            'transaction' => $payment->transaction_uuid ?? null,
            'amount' => $payment->total_amount ?? 0
        ]);
    }
}