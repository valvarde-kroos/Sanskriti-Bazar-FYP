@extends('layout.main')

@section('hyasabicontentauncha')
<div class="order-management-page">
    <div class="welcome-section">
        <h1>Order Management</h1>
        <p>Manage customer orders and update their status</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <!-- Orders Section -->
    <div class="section-card">
        <div class="section-header">
            <h2>Customer Orders ({{ $orders->count() }})</h2>
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
                            <span class="value">{{ $order->user->name }}</span>
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
                            <div class="action-dropdown">
                                <button class="dropdown-btn" onclick="toggleDropdown({{ $order->id }})">
                                    <span class="dots">⋮</span>
                                </button>
                                <div class="dropdown-menu" id="dropdown-{{ $order->id }}">
                                    <form action="{{ route('order.update.status', $order->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="accepted">
                                        <button type="submit" class="dropdown-item accept">Accept Order</button>
                                    </form>
                                    <form action="{{ route('order.update.status', $order->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="dropdown-item reject">Reject Order</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <span class="status-final">{{ ucfirst($order->status) }}</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <!-- No Orders Message -->
            <div class="no-orders">
                <h3>No Orders Found</h3>
                <p>There are currently no orders to manage.</p>
            </div>
        @endif
    </div>
</div>

<style>
.order-management-page {
    max-width: 1400px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f8f9fa;
    min-height: 100vh;
}

.welcome-section {
    text-align: center;
    margin-bottom: 30px;
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.welcome-section h1 {
    color: #2c3e50;
    margin-bottom: 10px;
    font-size: 2.5rem;
    font-weight: 700;
}

.welcome-section p {
    color: #6c757d;
    font-size: 1.1rem;
    margin: 0;
}

.alert {
    padding: 15px 20px;
    margin-bottom: 25px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 500;
    border: none;
    text-align: center;
}

.alert-success {
    background: #d1fae5;
    color: #065f46;
}

.alert-error {
    background: #fee2e2;
    color: #991b1b;
}

.section-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    padding: 30px;
}

.section-header {
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f3f4f6;
}

.section-header h2 {
    color: #2c3e50;
    font-size: 1.8rem;
    font-weight: 600;
    margin: 0;
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
    position: relative;
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
    background: #d1fae5;
    color: #065f46;
}

.status-cancelled {
    background: #fee2e2;
    color: #991b1b;
}

.status-processing {
    background: #dbeafe;
    color: #1e40af;
}

.status-completed {
    background: #d1ecf1;
    color: #0c5460;
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
    justify-content: flex-end;
    align-items: center;
}

.action-dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-btn {
    background: #f8f9fa;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 10px 15px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 20px;
    color: #6c757d;
}

.dropdown-btn:hover {
    background: #e9ecef;
    border-color: #3498db;
    color: #3498db;
}

.dots {
    font-weight: bold;
    line-height: 1;
}

.dropdown-menu {
    display: none;
    position: absolute;
    right: 0;
    top: 100%;
    background: white;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    z-index: 1000;
    min-width: 150px;
    margin-top: 5px;
}

.dropdown-menu.show {
    display: block;
}

.dropdown-item {
    display: block;
    width: 100%;
    padding: 12px 16px;
    border: none;
    background: none;
    text-align: left;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s ease;
    border-bottom: 1px solid #f3f4f6;
}

.dropdown-item:last-child {
    border-bottom: none;
}

.dropdown-item:hover {
    background: #f8f9fa;
}

.dropdown-item.accept {
    color: #10b981;
}

.dropdown-item.accept:hover {
    background: #d1fae5;
    color: #065f46;
}

.dropdown-item.reject {
    color: #ef4444;
}

.dropdown-item.reject:hover {
    background: #fee2e2;
    color: #991b1b;
}

.status-final {
    color: #6c757d;
    font-style: italic;
    font-size: 14px;
    font-weight: 500;
}

/* No Orders */
.no-orders {
    text-align: center;
    padding: 60px 20px;
    color: #6c757d;
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
    .order-management-page {
        padding: 15px;
    }
    
    .welcome-section {
        padding: 20px;
    }
    
    .welcome-section h1 {
        font-size: 2rem;
    }
    
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

<script>
function toggleDropdown(orderId) {
    // Close all other dropdowns
    const allDropdowns = document.querySelectorAll('.dropdown-menu');
    allDropdowns.forEach(dropdown => {
        if (dropdown.id !== `dropdown-${orderId}`) {
            dropdown.classList.remove('show');
        }
    });
    
    // Toggle current dropdown
    const dropdown = document.getElementById(`dropdown-${orderId}`);
    dropdown.classList.toggle('show');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.action-dropdown')) {
        const allDropdowns = document.querySelectorAll('.dropdown-menu');
        allDropdowns.forEach(dropdown => {
            dropdown.classList.remove('show');
        });
    }
});

// Add confirmation dialogs
document.addEventListener('DOMContentLoaded', function() {
    const acceptButtons = document.querySelectorAll('.dropdown-item.accept');
    const rejectButtons = document.querySelectorAll('.dropdown-item.reject');
    
    acceptButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Accept this order? You will need to process and deliver it.')) {
                e.preventDefault();
            }
        });
    });
    
    rejectButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Reject this order? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    });
});
</script>
@endsection