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
        <div class="table-container">
            <div class="table-wrapper">
                <table class="orders-table">
                <thead>
                    <tr>
                        <th>ORDER</th>
                        <th>CUSTOMER NAME</th>
                        <th>PRODUCT</th>
                        <th>QUANTITY</th>
                        <th>TOTAL PRICE</th>
                        <th>STATUS</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>
                            <div class="order-cell">
                                <span class="order-id">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                                <span class="order-date">{{ $order->created_at->format('M d, Y') }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="customer-cell">
                                <span class="customer-name">{{ $order->user->name }}</span>
                                <span class="customer-email">{{ $order->user->email }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="product-name">{{ $order->product->post_title }}</span>
                        </td>
                        <td>
                            <span class="quantity">{{ $order->quantity }} pieces</span>
                        </td>
                        <td>
                            <span class="total-price">Rs. {{ number_format($order->total_price, 2) }}</span>
                        </td>
                        <td>
                            <span class="status-badge status-{{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            @if($order->status === 'pending')
                                <div class="action-dropdown">
                                    <button class="dropdown-btn" onclick="toggleDropdown({{ $order->id }})">
                                        <span class="dots">⋮</span>
                                    </button>
                                    <div class="dropdown-menu" id="dropdown-{{ $order->id }}">
                                        <form action="{{ route('vendor.order.update', $order->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="accepted">
                                            <button type="submit" class="dropdown-item accept">Accept Order</button>
                                        </form>
                                        <form action="{{ route('vendor.order.update', $order->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="dropdown-item reject">Reject Order</button>
                                        </form>
                                    </div>
                                </div>
                            @elseif($order->status === 'accepted' || $order->status === 'processing')
                                <div class="action-dropdown">
                                    <button class="dropdown-btn" onclick="toggleDropdown({{ $order->id }})">
                                        <span class="dots">⋮</span>
                                    </button>
                                    <div class="dropdown-menu" id="dropdown-{{ $order->id }}">
                                        <form action="{{ route('vendor.order.update', $order->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="dropdown-item deliver">Mark as Delivered</button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <span class="status-final">{{ ucfirst($order->status) }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
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

    /* Table Container */
    .table-container {
        background: #ffffff;
        border-radius: 8px;
        overflow: visible; /* Changed from hidden to visible */
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    /* Wrapper for horizontal scroll on mobile */
    .table-wrapper {
        overflow-x: auto;
        overflow-y: visible;
    }

    /* Orders Table */
    .orders-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
        table-layout: fixed;
    }

    .orders-table thead {
        background: #f8f9fa;
    }

    .orders-table th {
        padding: 16px 20px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e5e7eb;
    }

    /* Column widths */
    .orders-table th:nth-child(1) { width: 12%; } /* ORDER */
    .orders-table th:nth-child(2) { width: 18%; } /* CUSTOMER NAME */
    .orders-table th:nth-child(3) { width: 15%; } /* PRODUCT */
    .orders-table th:nth-child(4) { width: 10%; } /* QUANTITY */
    .orders-table th:nth-child(5) { width: 12%; } /* TOTAL PRICE */
    .orders-table th:nth-child(6) { width: 13%; } /* STATUS */
    .orders-table th:nth-child(7) { width: 20%; } /* ACTIONS */

    .orders-table tbody tr {
        border-bottom: 1px solid #f3f4f6;
        transition: background-color 0.2s ease;
    }

    .orders-table tbody tr:hover {
        background: #f9fafb;
    }

    .orders-table tbody tr:last-child {
        border-bottom: none;
    }

    .orders-table td {
        padding: 16px 20px;
        vertical-align: middle;
        word-wrap: break-word;
    }

    /* Actions column specific styling */
    .orders-table td:last-child {
        position: relative;
        text-align: center;
    }

    /* Order Cell */
    .order-cell {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .order-id {
        font-size: 14px;
        font-weight: 600;
        color: #1f2937;
    }

    .order-date {
        font-size: 12px;
        color: #6b7280;
    }

    /* Customer Cell */
    .customer-cell {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .customer-name {
        font-size: 14px;
        font-weight: 500;
        color: #1f2937;
    }

    .customer-email {
        font-size: 12px;
        color: #6b7280;
    }

    /* Product Name */
    .product-name {
        font-size: 14px;
        font-weight: 500;
        color: #1f2937;
    }

    /* Quantity */
    .quantity {
        font-size: 14px;
        color: #1f2937;
    }

    /* Total Price */
    .total-price {
        font-size: 14px;
        font-weight: 600;
        color: #3498db;
    }

    /* Status Badge */
    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 16px;
        font-size: 11px;
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

    .status-processing {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-completed {
        background: #d1ecf1;
        color: #0c5460;
    }

    .status-cancelled {
        background: #fee2e2;
        color: #991b1b;
    }

    /* Action Dropdown */
    .action-dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-btn {
        background: #f8f9fa;
        border: 1px solid #e5e7eb;
        padding: 8px 12px;
        cursor: pointer;
        border-radius: 6px;
        transition: all 0.2s ease;
        font-size: 18px;
        color: #6b7280;
        min-width: 40px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .dropdown-btn:hover {
        background: #e5e7eb;
        color: #374151;
        border-color: #d1d5db;
    }

    .dropdown-btn:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
    }

    .dots {
        font-weight: bold;
        line-height: 1;
        font-size: 16px;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        right: 0;
        top: calc(100% + 4px);
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        z-index: 9999;
        min-width: 180px;
        overflow: hidden;
        animation: dropdownFadeIn 0.15s ease-out;
    }

    @keyframes dropdownFadeIn {
        from {
            opacity: 0;
            transform: translateY(-5px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
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
        color: #374151;
        text-decoration: none;
    }

    .dropdown-item:last-child {
        border-bottom: none;
    }

    .dropdown-item:hover {
        background: #f9fafb;
    }

    .dropdown-item.accept {
        color: #10b981;
    }

    .dropdown-item.accept:hover {
        background: #ecfdf5;
        color: #059669;
    }

    .dropdown-item.reject {
        color: #ef4444;
    }

    .dropdown-item.reject:hover {
        background: #fef2f2;
        color: #dc2626;
    }

    .dropdown-item.deliver {
        color: #3498db;
    }

    .dropdown-item.deliver:hover {
        background: #eff6ff;
        color: #2563eb;
    }

    .status-final {
        color: #6b7280;
        font-style: italic;
        font-size: 13px;
        font-weight: 500;
    }

    /* No Orders */
    .no-orders {
        text-align: center;
        padding: 60px 20px;
        color: #6b7280;
    }

    .no-orders h3 {
        font-size: 20px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .no-orders p {
        font-size: 14px;
        margin-bottom: 0;
    }

    /* Mobile Responsive */
    @media (max-width: 1024px) {
        .table-wrapper {
            overflow-x: auto;
        }

        .orders-table {
            min-width: 800px;
        }

        .orders-table th,
        .orders-table td {
            padding: 12px 16px;
        }

        /* Adjust column widths for tablet */
        .orders-table th:nth-child(1) { width: 100px; }
        .orders-table th:nth-child(2) { width: 150px; }
        .orders-table th:nth-child(3) { width: 120px; }
        .orders-table th:nth-child(4) { width: 80px; }
        .orders-table th:nth-child(5) { width: 100px; }
        .orders-table th:nth-child(6) { width: 100px; }
        .orders-table th:nth-child(7) { width: 150px; }
    }

    @media (max-width: 768px) {
        .orders-table {
            min-width: 700px;
        }

        .orders-table th,
        .orders-table td {
            padding: 10px 12px;
        }

        .orders-table th {
            font-size: 11px;
        }

        .order-id,
        .customer-name,
        .product-name,
        .quantity,
        .total-price {
            font-size: 13px;
        }

        .order-date,
        .customer-email {
            font-size: 11px;
        }

        .status-badge {
            font-size: 10px;
            padding: 4px 8px;
        }

        .dropdown-btn {
            padding: 6px 10px;
            min-width: 36px;
            height: 32px;
        }

        .dropdown-menu {
            min-width: 160px;
        }

        .dropdown-item {
            padding: 10px 14px;
            font-size: 13px;
        }
    }

    @media (max-width: 480px) {
        .section-card {
            padding: 15px;
        }

        .orders-table {
            min-width: 600px;
        }

        .orders-table th,
        .orders-table td {
            padding: 8px 10px;
        }

        .dropdown-btn {
            padding: 4px 8px;
            min-width: 32px;
            height: 28px;
        }

        .dropdown-menu {
            min-width: 140px;
        }

        .dropdown-item {
            padding: 8px 12px;
            font-size: 12px;
        }
    }
</style>
@endsection

@section('scripts')
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
    const deliverButtons = document.querySelectorAll('.dropdown-item.deliver');
    
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

    deliverButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Mark this order as delivered? Customer will be notified.')) {
                e.preventDefault();
            }
        });
    });
});

console.log('Vendor Orders page loaded successfully!');
</script>
@endsection