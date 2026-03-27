<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function placeOrder()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();

        foreach ($cartItems as $item) {
            Order::create([
                'user_id' => Auth::id(),
                'product_id' => $item->product_id,
            ]);
            $item->delete(); // remove from cart
        }

        return back()->with('success', 'Order placed successfully.');
    }
}
