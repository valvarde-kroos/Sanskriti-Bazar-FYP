<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Order Notification</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .email-header p {
            margin: 10px 0 0 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .email-body {
            padding: 30px 20px;
        }
        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }
        .order-info {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .order-info h2 {
            margin: 0 0 15px 0;
            font-size: 18px;
            color: #667eea;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #555;
        }
        .info-value {
            color: #333;
            text-align: right;
        }
        .product-details {
            background: #fff;
            border: 1px solid #e0e0e0;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .product-details h3 {
            margin: 0 0 15px 0;
            font-size: 16px;
            color: #333;
        }
        .shipping-info {
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .shipping-info h3 {
            margin: 0 0 15px 0;
            font-size: 16px;
            color: #f59e0b;
        }
        .total-amount {
            background: #667eea;
            color: white;
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 5px;
            text-align: center;
            font-size: 20px;
            font-weight: 600;
        }
        .action-button {
            text-align: center;
            margin: 30px 0;
        }
        .action-button a {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 40px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            font-size: 16px;
            transition: transform 0.2s ease;
        }
        .action-button a:hover {
            transform: translateY(-2px);
        }
        .email-footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
            border-top: 1px solid #e0e0e0;
        }
        .email-footer p {
            margin: 5px 0;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }
        .status-cod {
            background: #d1fae5;
            color: #065f46;
        }
        .status-esewa {
            background: #dbeafe;
            color: #1e40af;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>🎉 New Order Received!</h1>
            <p>Sanskriti Bazar - Traditional Nepali Instruments</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <p class="greeting">Hello {{ $vendor->name }},</p>
            
            <p>Great news! You have received a new order for your product. Here are the details:</p>

            <!-- Order Information -->
            <div class="order-info">
                <h2>📦 Order Details</h2>
                <div class="info-row">
                    <span class="info-label">Order ID:</span>
                    <span class="info-value">#{{ $order->id }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Order Date:</span>
                    <span class="info-value">{{ $order->created_at->format('F d, Y h:i A') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        <span class="status-badge status-{{ $order->status }}">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Payment Method:</span>
                    <span class="info-value">
                        <span class="status-badge status-{{ $order->payment_method === 'cash_on_delivery' ? 'cod' : 'esewa' }}">
                            {{ $order->payment_method === 'cash_on_delivery' ? 'Cash on Delivery' : 'eSewa' }}
                        </span>
                    </span>
                </div>
            </div>

            <!-- Product Details -->
            <div class="product-details">
                <h3>🎵 Product Information</h3>
                <div class="info-row">
                    <span class="info-label">Product Name:</span>
                    <span class="info-value">{{ $product->post_title }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Quantity:</span>
                    <span class="info-value">{{ $order->quantity }} unit(s)</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Unit Price:</span>
                    <span class="info-value">Rs. {{ number_format($product->price ?? 0, 2) }}</span>
                </div>
            </div>

            <!-- Total Amount -->
            <div class="total-amount">
                Total Amount: Rs. {{ number_format($order->total_price, 2) }}
            </div>

            <!-- Customer & Shipping Information -->
            <div class="shipping-info">
                <h3>📍 Customer & Shipping Details</h3>
                <div class="info-row">
                    <span class="info-label">Customer Name:</span>
                    <span class="info-value">{{ $customer->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Customer Email:</span>
                    <span class="info-value">{{ $customer->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Shipping Name:</span>
                    <span class="info-value">{{ $order->shipping_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Shipping Phone:</span>
                    <span class="info-value">{{ $order->shipping_phone }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Shipping Address:</span>
                    <span class="info-value">{{ $order->shipping_address }}</span>
                </div>
            </div>

            <!-- Action Button -->
            <div class="action-button">
                <a href="{{ route('vendor.orders') }}">View Order in Dashboard</a>
            </div>

            <p style="color: #666; font-size: 14px; margin-top: 30px;">
                Please process this order as soon as possible. You can manage the order status and update shipping information from your vendor dashboard.
            </p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p><strong>Sanskriti Bazar</strong></p>
            <p>Traditional Nepali Musical Instruments</p>
            <p style="margin-top: 15px; font-size: 12px; color: #999;">
                This is an automated notification. Please do not reply to this email.
            </p>
        </div>
    </div>
</body>
</html>
