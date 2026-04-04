@extends('vendor.layout.main')

@section('title', 'My Orders')

@section('content')
<div class="welcome-section">
    <h1>My Orders</h1>
    <p>Manage customer orders for your products</p>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<!-- Orders Section -->
<div class="section-card">
    <div class="section-header">
        <h2>Customer Orders ({{ $orders->count() ?? 0 }})</h2>
    </div>
    
    @if($orders->count() > 0)
        <div class="orders-grid">
            @foreach($orders as $order)
            <div class="order-card">
                <!-- Order Header -->
                <div class="order-header">
                    <div class="order-id">Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</div>
                    <div class="order-status status-{{ $order->status }}">
                        {{ ucfirst($order->status) }}
                    </div>
                </div>

                <!-- Order Information -->
                <div class="order-info">
                    <div class="info-row">
                        <span class="label">Customer:</span>
                        <span class="value">{{ $order->shipping_name ?? $order->user->name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Product:</span>
                        <span class="value">{{ $order->product->post_title }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Quantity:</span>
                        <span class="value">{{ $order->quantity }} pieces</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Total Price:</span>
                        <span class="value price">Rs. {{ number_format($order->total_price, 2) }}</span>
                    </div>
                </div>

                <!-- Order Actions -->
                <div class="order-actions">
                    @if($order->status === 'pending')
                        <button class="btn btn-accept" onclick="acceptOrder({{ $order->id }})">
                            Accept Order
                        </button>
                        <button class="btn btn-reject" onclick="rejectOrder({{ $order->id }})">
                            Reject Order
                        </button>
                    @elseif($order->status === 'accepted' || $order->status === 'processing')
                        <button class="btn btn-deliver" onclick="markDelivered({{ $order->id }})">
                            Mark as Delivered
                        </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- No Orders Message -->
        <div class="no-orders">
            <h3>No Orders Yet</h3>
            <p>When customers order your products, they will appear here.</p>
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    /* Alert Styles */
    .alert {
        padding: 15px 20px;
        margin-bottom: 25px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 500;
        border: none;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    /* Orders Grid */
    .orders-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 25px;
    }

    /* Order Card */
    .order-card {
        background: #ffffff;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 25px;
        transition: all 0.3s ease;
    }

    .order-card:hover {
        border-color: #3498db;
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.15);
    }

    /* Order Header */
    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f3f4f6;
    }

    .order-id {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
    }

    .order-status {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Status Colors */
    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-accepted {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-processing {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-delivered {
        background: #d1fae5;
        color: #065f46;
    }

    .status-cancelled {
        background: #fee2e2;
        color: #991b1b;
    }

    /* Order Information */
    .order-info {
        margin-bottom: 25px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        padding: 8px 0;
    }

    .info-row .label {
        font-size: 15px;
        font-weight: 500;
        color: #6b7280;
    }

    .info-row .value {
        font-size: 15px;
        font-weight: 600;
        color: #1f2937;
        text-align: right;
    }

    .info-row .value.price {
        color: #3498db;
        font-size: 18px;
        font-weight: 700;
    }

    /* Order Actions */
    .order-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn {
        flex: 1;
        min-width: 140px;
        padding: 14px 20px;
        border: none;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    }

    .btn-accept {
        background: #10b981;
        color: white;
        border: 2px solid #10b981;
    }

    .btn-accept:hover {
        background: #059669;
        border-color: #059669;
    }

    .btn-reject {
        background: #ef4444;
        color: white;
        border: 2px solid #ef4444;
    }

    .btn-reject:hover {
        background: #dc2626;
        border-color: #dc2626;
    }

    .btn-deliver {
        background: #3498db;
        color: white;
        border: 2px solid #3498db;
        min-width: 100%;
    }

    .btn-deliver:hover {
        background: #2980b9;
        border-color: #2980b9;
    }

    /* No Orders */
    .no-orders {
        text-align: center;
        padding: 60px 20px;
        color: #6b7280;
    }

    .no-orders h3 {
        font-size: 24px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 10px;
    }

    .no-orders p {
        font-size: 16px;
        margin-bottom: 0;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .orders-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .order-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .order-status {
            align-self: flex-end;
        }

        .info-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }

        .info-row .value {
            text-align: left;
        }

        .order-actions {
            flex-direction: column;
        }

        .btn {
            min-width: 100%;
        }
    }

    @media (max-width: 480px) {
        .order-card {
            padding: 20px;
        }

        .order-id {
            font-size: 16px;
        }

        .order-status {
            font-size: 12px;
            padding: 6px 12px;
        }

        .info-row .label,
        .info-row .value {
            font-size: 14px;
        }

        .info-row .value.price {
            font-size: 16px;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    // Accept Order Function
    function acceptOrder(orderId) {
        if (confirm('Accept this order? You will need to prepare and deliver it.')) {
            updateOrderStatus(orderId, 'accepted');
        }
    }

    // Reject Order Function
    function rejectOrder(orderId) {
        if (confirm('Reject this order? This action cannot be undone.')) {
            updateOrderStatus(orderId, 'cancelled');
        }
    }

    // Mark as Delivered Function
    function markDelivered(orderId) {
        if (confirm('Mark this order as delivered? Customer will be notified.')) {
            updateOrderStatus(orderId, 'delivered');
        }
    }

    // Update Order Status Function
    function updateOrderStatus(orderId, status) {
        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/vendor/order/${orderId}/update`;
        
        // Add CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (csrfToken) {
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken.getAttribute('content');
            form.appendChild(csrfInput);
        }
        
        // Add method override for PUT
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);
        
        // Add status
        const statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'status';
        statusInput.value = status;
        form.appendChild(statusInput);
        
        // Submit form
        document.body.appendChild(form);
        form.submit();
    }

    console.log('Vendor Orders page loaded successfully!');
</script>
@endsection