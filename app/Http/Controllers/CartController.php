<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            // Store the intended URL (cart page) in session
            session(['url.intended' => route('cart')]);
            // Redirect to login with a message
            return redirect()->route('login')->with('message', 'Please login to view your cart.');
        }

        $cartItems = Cart::where('user_id', Auth::id())
            ->with(['product.user', 'product.category'])
            ->get();
        
        // If user is a customer, use the customer dashboard layout
        if (Auth::user()->isCustomer()) {
            return view('customer.cart', compact('cartItems'));
        }
        
        // Otherwise use the regular cart view
        return view('cart', compact('cartItems'));
    }

    public function add($id)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            // Store the intended URL (cart page) in session
            session(['url.intended' => route('cart')]);
            // If it's an AJAX request, return JSON response
            if (request()->ajax() || request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login to add products to cart.',
                    'redirect' => route('login')
                ], 401);
            }
            // Redirect to login with a message
            return redirect()->route('login')->with('message', 'Please login to add products to cart.');
        }

        $product = Product::findOrFail($id);

        // Check if product has stock
        if ($product->quantity <= 0) {
            if (request()->ajax() || request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This product is out of stock.'
                ], 400);
            }
            return back()->with('error', 'This product is out of stock.');
        }

        // Check if item already exists in cart
        $existingCart = Cart::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->first();

        if ($existingCart) {
            // Check if we can increment quantity
            if ($existingCart->quantity >= $product->quantity) {
                if (request()->ajax() || request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => "Only {$product->quantity} items available in stock."
                    ], 400);
                }
                return back()->with('error', "Only {$product->quantity} items available in stock.");
            }
            // If item exists, increment quantity
            $existingCart->increment('quantity');
        } else {
            // If item doesn't exist, create new cart item
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $id,
                'quantity' => 1,
            ]);
        }

        // If it's an AJAX request, return JSON response
        if (request()->ajax() || request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully!',
                'cart_count' => Cart::where('user_id', Auth::id())->count()
            ]);
        }

        return back()->with('success', 'Product added to cart.');
    }

    public function remove($id)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Please login to manage your cart.');
        }

        $cart = Cart::where('user_id', Auth::id())->where('product_id', $id)->firstOrFail();
        $cart->delete();
        return back()->with('delete', 'Product removed from cart.');
    }

    public function updateQuantity(Request $request, $id)
    {
        // Debug logging
        \Log::info('Cart quantity update requested', [
            'cart_id' => $id,
            'request_data' => $request->all(),
            'user_id' => Auth::id()
        ]);

        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Please login to manage your cart.');
        }

        $cart = Cart::where('user_id', Auth::id())->where('id', $id)->first();
        
        if (!$cart) {
            return back()->with('error', 'Cart item not found.');
        }

        $product = $cart->product;
        $newQuantity = $request->input('quantity');

        // Validate quantity
        if ($newQuantity < 1) {
            return back()->with('error', 'Quantity must be at least 1.');
        }

        // Check stock availability
        if ($newQuantity > $product->quantity) {
            return back()->with('error', "Only {$product->quantity} items available in stock.");
        }

        // Update quantity
        $cart->quantity = $newQuantity;
        $cart->save();

        return back()->with('success', 'Quantity updated successfully!');
    }

    public function count()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }

        $count = Cart::where('user_id', Auth::id())->count();
        return response()->json(['count' => $count]);
    }
}
