@extends('customer.layout.main')

@section('title', 'My Orders')

@section('content')

@if(session('success'))
<div class="order-alert success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
@endif
@if(session('error'))
<div class="order-alert danger"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
@endif

<div class="orders-page">
    <div class="orders-header">
        <h1>My Orders</h1>
        <p>Track and manage all your orders</p>
    </div>

    @forelse($orders ?? [] as $order)
    <div class="order-card">
        <!-- Order Card Header -->
        <div class="order-card-header">
            <div class="order-meta">
                <span class="order-id">Order #{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</span>
                <span class="order-date"><i class="fas fa-calendar-alt"></i> {{ $order->created_at->format('d M Y, h:i A') }}</span>
            </div>
            <span class="order-status-badge status-{{ $order->status }}">
                @if($order->status === 'pending') <i class="fas fa-clock"></i>
                @elseif($order->status === 'accepted') <i class="fas fa-check"></i>
                @elseif($order->status === 'processing') <i class="fas fa-cog fa-spin"></i>
                @elseif($order->status === 'completed') <i class="fas fa-check-circle"></i>
                @elseif($order->status === 'cancelled') <i class="fas fa-times-circle"></i>
                @endif
                {{ ucfirst($order->status) }}
            </span>
        </div>

        <!-- Order Product Info -->
        <div class="order-card-body">
            <div class="order-product">
                @if($order->product && $order->product->image)
                    <img src="{{ asset('uploads/' . $order->product->image) }}" alt="{{ $order->product->post_title }}">
                @else
                    <div class="order-product-placeholder"><i class="fas fa-music"></i></div>
                @endif
                <div class="order-product-info">
                    <h3>{{ $order->product->post_title ?? 'Product' }}</h3>
                    <p class="order-vendor">Sold by: {{ $order->product->user->name ?? 'Vendor' }}</p>
                    <p class="order-qty">Qty: {{ $order->quantity }}</p>
                </div>
            </div>
            <div class="order-total">
                <span class="total-label">Total</span>
                <span class="total-amount">Rs. {{ number_format($order->total_price, 2) }}</span>
            </div>
        </div>

        <!-- Order Tracking -->
        <div class="order-tracking">
            <div class="tracking-step {{ in_array($order->status, ['pending','accepted','processing','completed']) ? 'done' : '' }}">
                <div class="step-icon"><i class="fas fa-shopping-bag"></i></div>
                <span>Order Placed</span>
            </div>
            <div class="tracking-line {{ in_array($order->status, ['accepted','processing','completed']) ? 'done' : '' }}"></div>
            <div class="tracking-step {{ in_array($order->status, ['accepted','processing','completed']) ? 'done' : '' }}">
                <div class="step-icon"><i class="fas fa-check"></i></div>
                <span>Accepted</span>
            </div>
            <div class="tracking-line {{ in_array($order->status, ['processing','completed']) ? 'done' : '' }}"></div>
            <div class="tracking-step {{ in_array($order->status, ['processing','completed']) ? 'done' : '' }}">
                <div class="step-icon"><i class="fas fa-box"></i></div>
                <span>Processing</span>
            </div>
            <div class="tracking-line {{ $order->status === 'completed' ? 'done' : '' }}"></div>
            <div class="tracking-step {{ $order->status === 'completed' ? 'done' : '' }}">
                <div class="step-icon"><i class="fas fa-check-circle"></i></div>
                <span>Delivered</span>
            </div>
        </div>

        <!-- Order Actions -->
        <div class="order-card-footer">
            <div class="order-payment">
                <i class="fas fa-credit-card"></i>
                {{ ucfirst(str_replace('_', ' ', $order->payment_method ?? 'cash on delivery')) }}
            </div>
            <div class="order-actions">
                @if($order->status === 'pending')
                <button class="btn-cancel-order" onclick="cancelOrder({{ $order->id }}, this)">
                    <i class="fas fa-times"></i> Cancel
                </button>
                @endif
                <button class="btn-view-order" onclick="viewOrderDetails({{ $order->id }})">
                    <i class="fas fa-eye"></i> View Details
                </button>
            </div>
        </div>
    </div>

    @empty
    <div class="orders-empty">
        <div class="empty-icon"><i class="fas fa-shopping-bag"></i></div>
        <h2>No Orders Yet</h2>
        <p>You haven't placed any orders. Start shopping to see your orders here.</p>
        <a href="{{ route('shop.index') }}" class="btn-shop-now">
            <i class="fas fa-store"></i> Browse Products
        </a>
    </div>
    @endforelse
</div>

<!-- Order Detail Modal -->
<div class="omodal-overlay" id="orderModal" onclick="closeOrderModal(event)">
    <div class="omodal">
        <div class="omodal-header">
            <h3><i class="fas fa-receipt"></i> Order Details</h3>
            <button onclick="document.getElementById('orderModal').style.display='none'">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="omodal-body" id="orderModalBody">
            <div class="loading-spinner"><i class="fas fa-spinner fa-spin"></i> Loading...</div>
        </div>
    </div>
</div>

<style>
.order-alert {
    padding: 14px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
}
.order-alert.success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.order-alert.danger  { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

.orders-page { max-width: 900px; margin: 0 auto; }

.orders-header { text-align: center; margin-bottom: 30px; }
.orders-header h1 { font-size: 28px; color: #2c3e50; margin-bottom: 6px; }
.orders-header p { color: #6c757d; }

/* Order Card */
.order-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07);
    margin-bottom: 20px;
    overflow: hidden;
    border: 1px solid #f0f0f0;
}

.order-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    background: #f8f9fa;
    border-bottom: 1px solid #f0f0f0;
}

.order-meta { display: flex; align-items: center; gap: 20px; }
.order-id { font-weight: 700; color: #2c3e50; font-size: 15px; }
.order-date { color: #6c757d; font-size: 13px; }
.order-date i { margin-right: 5px; }

.order-status-badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
}
.status-pending    { background: #fff3cd; color: #856404; }
.status-accepted   { background: #cce5ff; color: #004085; }
.status-processing { background: #d1ecf1; color: #0c5460; }
.status-completed  { background: #d4edda; color: #155724; }
.status-cancelled  { background: #f8d7da; color: #721c24; }

/* Order Body */
.order-card-body {
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
}

.order-product { display: flex; align-items: center; gap: 15px; }
.order-product img {
    width: 70px;
    height: 70px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}
.order-product-placeholder {
    width: 70px;
    height: 70px;
    background: #f0f4ff;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #667eea;
    font-size: 24px;
}
.order-product-info h3 { font-size: 16px; color: #2c3e50; margin-bottom: 4px; }
.order-vendor { color: #6c757d; font-size: 13px; margin-bottom: 3px; }
.order-qty { color: #6c757d; font-size: 13px; }

.order-total { text-align: right; flex-shrink: 0; }
.total-label { display: block; color: #6c757d; font-size: 12px; margin-bottom: 4px; }
.total-amount { font-size: 20px; font-weight: 700; color: #667eea; }

/* Tracking */
.order-tracking {
    display: flex;
    align-items: center;
    padding: 20px 30px;
    background: #fafafa;
    border-top: 1px solid #f0f0f0;
    border-bottom: 1px solid #f0f0f0;
}

.tracking-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    flex-shrink: 0;
}

.step-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #e9ecef;
    color: #aaa;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    transition: all 0.3s;
}

.tracking-step.done .step-icon {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.tracking-step span {
    font-size: 11px;
    color: #aaa;
    white-space: nowrap;
}
.tracking-step.done span { color: #667eea; font-weight: 600; }

.tracking-line {
    flex: 1;
    height: 3px;
    background: #e9ecef;
    margin: 0 5px;
    margin-bottom: 22px;
    border-radius: 2px;
    transition: background 0.3s;
}
.tracking-line.done { background: linear-gradient(90deg, #667eea, #764ba2); }

/* Footer */
.order-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 20px;
}

.order-payment { color: #6c757d; font-size: 13px; }
.order-payment i { margin-right: 6px; color: #667eea; }

.order-actions { display: flex; gap: 10px; }

.btn-view-order, .btn-cancel-order {
    padding: 8px 18px;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    border: none;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 6px;
}
.btn-view-order {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}
.btn-view-order:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(102,126,234,0.4); }
.btn-cancel-order { background: #f8d7da; color: #721c24; }
.btn-cancel-order:hover { background: #dc3545; color: white; }

/* Empty State */
.orders-empty {
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07);
}
.empty-icon { font-size: 60px; color: #dee2e6; margin-bottom: 20px; }
.orders-empty h2 { font-size: 24px; color: #2c3e50; margin-bottom: 10px; }
.orders-empty p { color: #6c757d; margin-bottom: 25px; }
.btn-shop-now {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 28px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: transform 0.2s;
}
.btn-shop-now:hover { transform: translateY(-2px); }

/* Modal */
.omodal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    z-index: 9999;
    align-items: center;
    justify-content: center;
}
.omodal-overlay.show { display: flex; }
.omodal {
    background: white;
    border-radius: 12px;
    width: 90%;
    max-width: 560px;
    max-height: 85vh;
    overflow-y: auto;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
}
.omodal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 24px;
    border-bottom: 1px solid #e9ecef;
}
.omodal-header h3 { font-size: 18px; color: #2c3e50; display: flex; align-items: center; gap: 10px; }
.omodal-header h3 i { color: #667eea; }
.omodal-header button { background: none; border: none; font-size: 18px; color: #6c757d; cursor: pointer; }
.omodal-header button:hover { color: #dc3545; }
.omodal-body { padding: 24px; }

.detail-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #f0f0f0;
    font-size: 14px;
}
.detail-row:last-child { border-bottom: none; }
.detail-row .dlabel { color: #6c757d; }
.detail-row .dvalue { font-weight: 500; color: #2c3e50; }

.loading-spinner { text-align: center; padding: 40px; color: #667eea; font-size: 16px; }

@media (max-width: 600px) {
    .order-card-header { flex-direction: column; align-items: flex-start; gap: 10px; }
    .order-card-body { flex-direction: column; align-items: flex-start; }
    .order-total { text-align: left; }
    .order-tracking { padding: 15px; overflow-x: auto; }
    .order-card-footer { flex-direction: column; gap: 12px; align-items: flex-start; }
}
</style>

<script>
function viewOrderDetails(orderId) {
    document.getElementById('orderModal').classList.add('show');
    document.getElementById('orderModalBody').innerHTML = '<div class="loading-spinner"><i class="fas fa-spinner fa-spin"></i> Loading...</div>';

    fetch(`/customer/order/${orderId}/view`, {
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            const o = data.order;
            document.getElementById('orderModalBody').innerHTML = `
                <div class="detail-row"><span class="dlabel">Order ID</span><span class="dvalue">${o.order_number}</span></div>
                <div class="detail-row"><span class="dlabel">Product</span><span class="dvalue">${o.product_name}</span></div>
                <div class="detail-row"><span class="dlabel">Quantity</span><span class="dvalue">${o.quantity}</span></div>
                <div class="detail-row"><span class="dlabel">Total Amount</span><span class="dvalue" style="color:#667eea;font-size:16px;">Rs. ${parseFloat(o.total_price).toLocaleString()}</span></div>
                <div class="detail-row"><span class="dlabel">Status</span><span class="dvalue">${o.status}</span></div>
                <div class="detail-row"><span class="dlabel">Vendor</span><span class="dvalue">${o.vendor_name}</span></div>
                <div class="detail-row"><span class="dlabel">Order Date</span><span class="dvalue">${o.created_at}</span></div>
                <div class="detail-row"><span class="dlabel">Shipping Address</span><span class="dvalue">${o.shipping_address ?? 'N/A'}</span></div>
            `;
        }
    })
    .catch(() => {
        document.getElementById('orderModalBody').innerHTML = '<p style="color:red;text-align:center;">Failed to load order details.</p>';
    });
}

function cancelOrder(orderId, btn) {
    if (!confirm('Are you sure you want to cancel this order?')) return;

    fetch(`/customer/order/${orderId}/cancel`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Could not cancel order.');
        }
    });
}

function closeOrderModal(e) {
    if (!e || e.target === document.getElementById('orderModal')) {
        document.getElementById('orderModal').classList.remove('show');
    }
}

// Auto-hide alerts
document.querySelectorAll('.order-alert').forEach(el => {
    setTimeout(() => el.remove(), 5000);
});
</script>

@endsection
