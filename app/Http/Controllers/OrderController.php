<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
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
        ]);

        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        // Check if cart is empty
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();
        
        try {
            foreach ($cartItems as $item) {
                $product = $item->product;
                
                // Check stock availability
                if ($item->quantity > $product->quantity) {
                    DB::rollBack();
                    return redirect()->route('cart')->with('error', "Insufficient stock for {$product->post_title}. Only {$product->quantity} available.");
                }

                // Create order
                Order::create([
                    'user_id' => Auth::id(),
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'total_price' => ($product->price ?? 0) * $item->quantity,
                    'status' => 'pending',
                    'shipping_name' => $request->shipping_name,
                    'shipping_address' => $request->shipping_address,
                    'shipping_phone' => $request->shipping_phone,
                ]);

                // Update product stock
                $product->decrement('quantity', $item->quantity);

                // Remove from cart
                $item->delete();
            }

            DB::commit();

            return redirect()->route('order.success')->with('success', 'Order placed successfully! We will contact you soon for delivery.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout')->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function orderSuccess()
    {
        return view('order-success');
    }
}
