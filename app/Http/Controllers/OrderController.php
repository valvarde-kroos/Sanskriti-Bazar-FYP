<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use App\Services\EsewaService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\VendorNewOrderNotification;

class OrderController extends Controller
{
    protected $esewaService;

    public function __construct()
    {
        $this->esewaService = new EsewaService();
    }

    public function showCheckout()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Please login to proceed with checkout.');
        }

        $cartItems = Cart::where('user_id', Auth::id())
            ->with(['product.user', 'product.category'])
            ->get();

        // Check if cart is empty
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty. Add some products before checkout.');
        }

        // Check stock availability for all items
        foreach ($cartItems as $item) {
            if ($item->quantity > $item->product->quantity) {
                return redirect()->route('cart')->with('error', "Insufficient stock for {$item->product->post_title}. Only {$item->product->quantity} available.");
            }
        }

        return view('checkout', compact('cartItems'));
    }

    public function buyNow(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Please login to buy this product.');
        }

        // Validate the request
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check if product is available
        if ($request->quantity > $product->quantity) {
            return redirect()->back()->with('error', "Only {$product->quantity} items available in stock.");
        }

        // Clear existing cart for this user (Buy Now should be immediate)
        Cart::where('user_id', Auth::id())->delete();

        // Add product to cart
        Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'quantity' => $request->quantity
        ]);

        // Redirect to checkout
        return redirect()->route('checkout');
    }

    public function placeOrder(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Please login to place an order.');
        }

        // Validate shipping information
        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_address' => 'required|string|max:1000',
            'shipping_phone' => 'required|string|max:20',
            'payment_method' => 'required|in:cash_on_delivery,esewa',
        ]);

        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        // Check if cart is empty
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        // Calculate total amount
        $totalAmount = $cartItems->sum(function($item) {
            return ($item->product->price ?? 0) * $item->quantity;
        });

        DB::beginTransaction();
        
        try {
            $orders = [];
            
            foreach ($cartItems as $item) {
                $product = $item->product;
                
                // Check stock availability
                if ($item->quantity > $product->quantity) {
                    DB::rollBack();
                    return redirect()->route('cart')->with('error', "Insufficient stock for {$product->post_title}. Only {$product->quantity} available.");
                }

                // Create order
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'total_price' => ($product->price ?? 0) * $item->quantity,
                    'status' => $request->payment_method === 'esewa' ? 'pending_payment' : 'pending',
                    'shipping_name' => $request->shipping_name,
                    'shipping_address' => $request->shipping_address,
                    'shipping_phone' => $request->shipping_phone,
                    'payment_method' => $request->payment_method,
                    'payment_status' => $request->payment_method === 'esewa' ? 'pending' : 'not_required',
                ]);

                $orders[] = $order;

                // Update product stock only for cash on delivery
                if ($request->payment_method === 'cash_on_delivery') {
                    $product->decrement('quantity', $item->quantity);
                    
                    // Send email notification to vendor for COD orders
                    try {
                        $vendor = $product->user;
                        if ($vendor && $vendor->email) {
                            Mail::to($vendor->email)->send(new VendorNewOrderNotification($order, $vendor));
                            Log::info("Vendor email sent to {$vendor->email} for order #{$order->id}");
                        }
                    } catch (\Exception $e) {
                        Log::error("Failed to send vendor email for order #{$order->id}: " . $e->getMessage());
                    }
                }
            }

            // Handle eSewa payment - DON'T clear cart yet
            if ($request->payment_method === 'esewa') {
                // Store cart items and order info in session for payment processing
                session([
                    'pending_orders' => collect($orders)->pluck('id')->toArray(),
                    'cart_items_for_payment' => $cartItems->toArray(),
                    'payment_total_amount' => $totalAmount
                ]);
                
                DB::commit();
                
                // Redirect to PaymentController for eSewa processing
                return redirect()->route('payment.initiate.cart')->with([
                    'total_amount' => $totalAmount,
                    'order_ids' => collect($orders)->pluck('id')->toArray()
                ]);
            }

            // For cash on delivery - clear cart and complete order
            foreach ($cartItems as $item) {
                $item->delete();
            }

            DB::commit();
            return redirect()->route('order.success')->with('success', 'Order placed successfully! We will contact you soon for delivery.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order placement error: ' . $e->getMessage());
            Log::error('Order placement stack trace: ' . $e->getTraceAsString());
            return redirect()->route('checkout')->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function esewaSuccess(Request $request)
    {
        try {
            $orderId = session('esewa_order_id');
            $pendingOrders = session('pending_orders', []);
            
            if (!$orderId || empty($pendingOrders)) {
                return redirect()->route('cart')->with('error', 'Invalid payment session.');
            }

            // Get payment details from eSewa response
            $refId = $request->get('refId');
            $amount = $request->get('amt');
            
            if (!$refId || !$amount) {
                return redirect()->route('checkout')->with('error', 'Payment verification failed. Please try again.');
            }

            // Verify payment with eSewa
            $isVerified = $this->esewaService->verifyPayment($orderId, $amount, $refId);
            
            if ($isVerified) {
                DB::beginTransaction();
                
                try {
                    // Update orders and reduce stock
                    foreach ($pendingOrders as $orderIdDb) {
                        $order = Order::find($orderIdDb);
                        if ($order) {
                            $order->update([
                                'status' => 'pending',
                                'payment_status' => 'paid',
                                'esewa_ref_id' => $refId
                            ]);
                            
                            // Reduce product stock
                            $order->product->decrement('quantity', $order->quantity);
                            
                            // Send email notification to vendor for eSewa orders
                            try {
                                $vendor = $order->product->user;
                                if ($vendor && $vendor->email) {
                                    Mail::to($vendor->email)->send(new VendorNewOrderNotification($order, $vendor));
                                    Log::info("Vendor email sent to {$vendor->email} for order #{$order->id}");
                                }
                            } catch (\Exception $e) {
                                Log::error("Failed to send vendor email for order #{$order->id}: " . $e->getMessage());
                            }
                        }
                    }
                    
                    DB::commit();
                    
                    // Clear session
                    session()->forget(['esewa_order_id', 'pending_orders']);
                    
                    return redirect()->route('order.success')->with('success', 'Payment successful! Your order has been confirmed.');
                    
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('eSewa success processing error: ' . $e->getMessage());
                    return redirect()->route('checkout')->with('error', 'Payment was successful but order processing failed. Please contact support.');
                }
            } else {
                return redirect()->route('checkout')->with('error', 'Payment verification failed. Please try again.');
            }
            
        } catch (\Exception $e) {
            Log::error('eSewa success error: ' . $e->getMessage());
            return redirect()->route('checkout')->with('error', 'Payment processing error. Please contact support.');
        }
    }

    public function esewaFailure(Request $request)
    {
        // Clean up pending orders if payment failed
        $pendingOrders = session('pending_orders', []);
        
        if (!empty($pendingOrders)) {
            // Delete pending orders since payment failed
            Order::whereIn('id', $pendingOrders)->delete();
        }
        
        // Clear session
        session()->forget(['esewa_order_id', 'pending_orders']);
        
        return redirect()->route('checkout')->with('error', 'Payment was cancelled or failed. Please try again.');
    }

    public function orderSuccess()
    {
        return view('order-success');
    }

    public function orderManagement()
    {
        $query = Order::with(['user', 'product']);
        
        // If user is a vendor, only show orders for their products
        if (auth()->user()->role === 'vendor') {
            $query->whereHas('product', function($q) {
                $q->where('user_id', auth()->id());
            });
        }
        
        $orders = $query->orderBy('created_at', 'desc')->get();

        return view('order-management', compact('orders'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected'
        ]);

        $order = Order::findOrFail($id);
        
        if ($request->status === 'accepted') {
            $order->status = Order::STATUS_ACCEPTED;
        } else {
            $order->status = Order::STATUS_CANCELLED; // Using cancelled for rejected
        }
        
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }
}
