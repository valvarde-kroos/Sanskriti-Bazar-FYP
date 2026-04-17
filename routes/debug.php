<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

// Debug route to test payment flow step by step
Route::get('/debug-payment', function() {
    if (!Auth::check()) {
        return 'Please login first';
    }
    
    $user = Auth::user();
    $cartItems = Cart::where('user_id', $user->id)->with('product')->get();
    
    if ($cartItems->isEmpty()) {
        return 'Cart is empty. Add some items first.';
    }
    
    $totalAmount = $cartItems->sum(function($item) {
        return ($item->product->price ?? 0) * $item->quantity;
    });
    
    // Create test orders
    $orders = [];
    foreach ($cartItems as $item) {
        $order = Order::create([
            'user_id' => $user->id,
            'product_id' => $item->product_id,
            'quantity' => $item->quantity,
            'total_price' => ($item->product->price ?? 0) * $item->quantity,
            'status' => 'pending_payment',
            'payment_method' => 'esewa',
            'payment_status' => 'pending',
            'shipping_name' => 'Test User',
            'shipping_address' => 'Test Address',
            'shipping_phone' => '1234567890',
        ]);
        $orders[] = $order;
    }
    
    // Set session data
    session([
        'pending_orders' => collect($orders)->pluck('id')->toArray(),
        'payment_total_amount' => $totalAmount
    ]);
    
    return 'Debug setup complete. Orders created: ' . count($orders) . '. Total: Rs. ' . $totalAmount . '. <a href="/payment/initiate-cart">Test Payment</a>';
})->middleware('auth');

// Simple payment test
Route::get('/simple-payment-test', function() {
    $transactionId = 'TEST-' . time();
    
    $html = '
    <!DOCTYPE html>
    <html>
    <head>
        <title>Simple eSewa Test</title>
    </head>
    <body style="font-family: Arial; padding: 50px; text-align: center;">
        <h2>Simple eSewa Payment Test</h2>
        <p>This will redirect to eSewa test environment</p>
        
        <form action="https://uat.esewa.com.np/epay/main" method="POST" id="testForm">
            <input type="hidden" name="amt" value="100">
            <input type="hidden" name="pdc" value="0">
            <input type="hidden" name="psc" value="0">
            <input type="hidden" name="txAmt" value="0">
            <input type="hidden" name="tAmt" value="100">
            <input type="hidden" name="pid" value="' . $transactionId . '">
            <input type="hidden" name="scd" value="EPAYTEST">
            <input type="hidden" name="su" value="' . url('/payment/success') . '">
            <input type="hidden" name="fu" value="' . url('/payment/failure') . '">
            
            <button type="submit" style="background: #28a745; color: white; padding: 15px 30px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer;">
                Pay Rs. 100 with eSewa
            </button>
        </form>
        
        <script>
            setTimeout(function() {
                document.getElementById("testForm").submit();
            }, 3000);
        </script>
    </body>
    </html>';
    
    return $html;
});