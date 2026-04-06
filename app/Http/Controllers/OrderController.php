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
                    'payment_method' => $request->payment_method,
                ]);

                // Update product stock
                $product->decrement('quantity', $item->quantity);

                // Remove from cart
                $item->delete();
            }

            DB::commit();

            $successMessage = $request->payment_method === 'esewa' 
                ? 'Order placed successfully! You will be redirected to eSewa for payment.' 
                : 'Order placed successfully! We will contact you soon for delivery.';

            return redirect()->route('order.success')->with('success', $successMessage);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout')->with('error', 'Something went wrong. Please try again.');
        }
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
