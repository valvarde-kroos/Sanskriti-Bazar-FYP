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
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        return view('cart', compact('cartItems'));
    }

    public function add($id)
    {
        $product = Product::findOrFail($id);

        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $id,
        ]);

        return back()->with('success', 'Product added to cart.');
    }

    public function remove($id)
    {
        $cart = Cart::where('user_id', Auth::id())->where('product_id', $id)->firstOrFail();
        $cart->delete();
        return back()->with('delete', 'Product removed from cart.');
    }
}
