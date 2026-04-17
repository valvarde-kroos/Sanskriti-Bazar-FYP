<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    // Real eSewa payment integration
    public function initiateCartPayment(Request $request)
    {
        try {
            $orderIds = session('pending_orders', []);
            $totalAmount = session('payment_total_amount', 0);
            
            if (empty($orderIds) || $totalAmount <= 0) {
                return redirect()->route('cart')->with('error', 'Invalid payment data.');
            }

            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Please login.');
            }
            
            $customer = Auth::user();
            $transactionId = 'SB-CART-' . time() . '-' . $customer->id;
            
            // Real eSewa form that submits directly to eSewa servers
            $html = '<!DOCTYPE html>
<html>
<head>
    <title>Redirecting to eSewa...</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0; 
            padding: 50px; 
            text-align: center; 
            color: white;
        }
        .redirect-container { 
            background: white; 
            color: #333;
            max-width: 500px; 
            margin: 0 auto; 
            padding: 40px; 
            border-radius: 15px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .spinner { 
            border: 4px solid #f3f4f6; 
            border-top: 4px solid #60c060; 
            border-radius: 50%; 
            width: 50px; 
            height: 50px; 
            animation: spin 1s linear infinite; 
            margin: 0 auto 20px; 
        }
        @keyframes spin { 
            0% { transform: rotate(0deg); } 
            100% { transform: rotate(360deg); } 
        }
        .payment-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: left;
        }
        .manual-submit {
            background: #60c060;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="redirect-container">
        <div class="spinner"></div>
        <h2>🔒 Redirecting to eSewa</h2>
        <p>Please wait while we redirect you to eSewa for secure payment...</p>
        
        <div class="payment-info">
            <strong>Payment Details:</strong><br>
            Merchant: Sanskriti Bazar<br>
            Amount: Rs. ' . number_format($totalAmount, 2) . '<br>
            Transaction ID: ' . $transactionId . '<br>
            Items: ' . count($orderIds) . ' products
        </div>
        
        <form id="esewaForm" action="https://epay.esewa.com.np/api/epay/main/v2" method="POST">
            <input type="hidden" name="amt" value="' . $totalAmount . '">
            <input type="hidden" name="pdc" value="0">
            <input type="hidden" name="psc" value="0">
            <input type="hidden" name="txAmt" value="0">
            <input type="hidden" name="tAmt" value="' . $totalAmount . '">
            <input type="hidden" name="pid" value="' . $transactionId . '">
            <input type="hidden" name="scd" value="EPAYTEST">
            <input type="hidden" name="su" value="' . url('/payment/success') . '">
            <input type="hidden" name="fu" value="' . url('/payment/failure') . '">
            
            <button type="submit" class="manual-submit">Continue to eSewa</button>
        </form>
        
        <p style="font-size: 12px; color: #666; margin-top: 20px;">
            You will be redirected automatically in 3 seconds...<br>
            If not redirected, click the button above.
        </p>
    </div>
    
    <script>
        console.log("Redirecting to eSewa Payment Gateway...");
        console.log("Transaction ID: ' . $transactionId . '");
        console.log("Amount: Rs. ' . number_format($totalAmount, 2) . '");
        
        // Auto-submit to eSewa after 3 seconds
        setTimeout(function() {
            console.log("Auto-submitting to eSewa...");
            document.getElementById("esewaForm").submit();
        }, 3000);
    </script>
</body>
</html>';

            return response($html);

        } catch (\Exception $e) {
            Log::error('Payment error: ' . $e->getMessage());
            return redirect()->route('checkout')->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    public function initiatePayment(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'amount' => 'required|numeric|min:1',
            ]);

            $amount = $request->amount;
            $transactionId = 'SB-SINGLE-' . time() . '-' . Auth::id();

            // Real eSewa form for single product
            $html = '<!DOCTYPE html>
<html>
<head>
    <title>eSewa Payment</title>
    <style>
        body { font-family: Arial; background: #f5f7fa; padding: 50px; text-align: center; }
        .container { background: white; max-width: 400px; margin: 0 auto; padding: 30px; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .btn { padding: 15px 30px; background: #60c060; color: white; border: none; border-radius: 8px; font-size: 16px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <h2>🔒 eSewa Payment</h2>
        <p><strong>Amount: Rs. ' . number_format($amount, 2) . '</strong></p>
        
        <form action="https://epay.esewa.com.np/api/epay/main/v2" method="POST">
            <input type="hidden" name="amt" value="' . $amount . '">
            <input type="hidden" name="pdc" value="0">
            <input type="hidden" name="psc" value="0">
            <input type="hidden" name="txAmt" value="0">
            <input type="hidden" name="tAmt" value="' . $amount . '">
            <input type="hidden" name="pid" value="' . $transactionId . '">
            <input type="hidden" name="scd" value="EPAYTEST">
            <input type="hidden" name="su" value="' . url('/payment/success') . '">
            <input type="hidden" name="fu" value="' . url('/payment/failure') . '">
            
            <button type="submit" class="btn">Pay Rs. ' . number_format($amount, 2) . ' with eSewa</button>
        </form>
    </div>
</body>
</html>';

            return response($html);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    public function paymentSuccess(Request $request)
    {
        try {
            $refId = $request->get('refId');
            $transactionId = $request->get('oid');
            $amount = $request->get('amt');

            Log::info('eSewa payment success', [
                'refId' => $refId,
                'transactionId' => $transactionId,
                'amount' => $amount
            ]);

            // Handle cart orders
            $orderIds = session('pending_orders', []);
            if (!empty($orderIds)) {
                // Update orders
                Order::whereIn('id', $orderIds)->update([
                    'status' => 'pending',
                    'payment_status' => 'paid',
                    'esewa_ref_id' => $refId
                ]);

                // Update product stock
                foreach ($orderIds as $orderId) {
                    $order = Order::find($orderId);
                    if ($order && $order->product) {
                        $order->product->decrement('quantity', $order->quantity);
                    }
                }

                // Clear cart
                Cart::where('user_id', Auth::id())->delete();
                
                // Clear session
                session()->forget(['pending_orders', 'cart_items_for_payment', 'payment_total_amount']);
            }

            return view('payment-success', [
                'refId' => $refId,
                'amount' => $amount,
                'transactionId' => $transactionId
            ]);

        } catch (\Exception $e) {
            Log::error('Payment success error: ' . $e->getMessage());
            return redirect()->route('payment.failure');
        }
    }

    public function paymentFailure(Request $request)
    {
        try {
            Log::info('eSewa payment failure', $request->all());
            
            // Clean up pending orders
            $orderIds = session('pending_orders', []);
            if (!empty($orderIds)) {
                Order::whereIn('id', $orderIds)->delete();
                session()->forget(['pending_orders', 'cart_items_for_payment', 'payment_total_amount']);
            }

            return view('payment-failure', [
                'message' => 'Payment was cancelled or failed. Please try again.'
            ]);

        } catch (\Exception $e) {
            return view('payment-failure', [
                'message' => 'Payment processing failed.'
            ]);
        }
    }
}