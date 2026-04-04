@extends('customer.layout.main')

@section('title', 'My Orders')

@section('content')
<div class="welcome-section">
    <h1>My Orders</h1>
    <p>View and track all your orders</p>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Orders Section -->
<div class="section-card">
    <div class="section-header">
        <h2>All Orders</h2>
        <div class="header-actions">
            <button class="action-btn" onclick="filterOrders()">Filter Orders</button>
            <button class="action-btn primary" onclick="refreshOrders()">Refresh</button>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="data-table" id="ordersTable">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders ?? [] as $order)
                <tr>
                    <td>
                        <strong>ORD-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</strong>
                    </td>
                    <td>{{ $order->product->post_title ?? 'Product Name' }}</td>
                    <td>{{ $order->quantity ?? 1 }}</td>
                    <td>
                        <strong>Rs. {{ number_format($order->total_price, 2) }}</strong>
                    </td>
                    <td>
                        <span class="badge {{ $order->status }}">{{ ucfirst($order->status) }}</span>
                    </td>
                    <td>
                        <span>{{ $order->created_at->format('M d, Y') }}</span>
                        <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn small" onclick="viewOrder({{ $order->id }})">View</button>
                            @if($order->status === 'pending')
                                <button class="action-btn small danger" onclick="cancelOrder({{ $order->id }})">Cancel</button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <!-- Demo Data -->
                <tr>
                    <td><strong>ORD-001</strong></td>
                    <td>Bansuri</td>
                    <td>2</td>
                    <td><strong>Rs. 2,500.00</strong></td>
                    <td><span class="badge completed">Completed</span></td>
                    <td>
                        <span>Mar 20, 2024</span>
                        <small class="text-muted">2:30 PM</small>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn small" onclick="viewOrder(1)">View</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>ORD-002</strong></td>
                    <td>Khaijhandi</td>
                    <td>1</td>
                    <td><strong>Rs. 1,800.00</strong></td>
                    <td><span class="badge pending">Pending</span></td>
                    <td>
                        <span>Mar 22, 2024</span>
                        <small class="text-muted">11:15 AM</small>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn small" onclick="viewOrder(2)">View</button>
                            <button class="action-btn small danger" onclick="cancelOrder(2)">Cancel</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>ORD-003</strong></td>
                    <td>Madal</td>
                    <td>1</td>
                    <td><strong>Rs. 3,200.00</strong></td>
                    <td><span class="badge processing">Processing</span></td>
                    <td>
                        <span>Mar 23, 2024</span>
                        <small class="text-muted">4:45 PM</small>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn small" onclick="viewOrder(3)">View</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>ORD-004</strong></td>
                    <td>Sarangi</td>
                    <td>3</td>
                    <td><strong>Rs. 950.00</strong></td>
                    <td><span class="badge completed">Completed</span></td>
                    <td>
                        <span>Mar 18, 2024</span>
                        <small class="text-muted">9:20 AM</small>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn small" onclick="viewOrder(4)">View</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>ORD-005</strong></td>
                    <td>Damphu</td>
                    <td>1</td>
                    <td><strong>Rs. 4,500.00</strong></td>
                    <td><span class="badge pending">Pending</span></td>
                    <td>
                        <span>Mar 21, 2024</span>
                        <small class="text-muted">1:10 PM</small>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn small" onclick="viewOrder(5)">View</button>
                            <button class="action-btn small danger" onclick="cancelOrder(5)">Cancel</button>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- View Order Modal -->
<div class="modal fade" id="viewOrderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="orderDetails">
                <!-- Order details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .header-actions {
        display: flex;
        gap: 10px;
    }

    .action-buttons {
        display: flex;
        gap: 5px;
    }

    .action-btn.danger {
        background: #e74c3c;
        color: #fff;
        border-color: #e74c3c;
    }

    .action-btn.danger:hover {
        background: #c0392b;
        border-color: #c0392b;
        color: #fff;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
    }

    .modal.fade.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-dialog {
        background: #fff;
        border-radius: 8px;
        max-width: 600px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-header {
        padding: 16px 20px;
        border-bottom: 1px solid #e0e0e0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        padding: 16px 20px;
        border-top: 1px solid #e0e0e0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn {
        padding: 8px 16px;
        border-radius: 6px;
        border: 1px solid;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-secondary {
        background: #6c757d;
        color: #fff;
        border-color: #6c757d;
    }

    @media (max-width: 768px) {
        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .header-actions {
            width: 100%;
            justify-content: flex-start;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    // Sample order data for demonstration
    const sampleOrders = {
        1: {
            id: 1,
            product: 'Bansuri',
            quantity: 2,
            total: 2500.00,
            status: 'completed',
            date: 'Mar 20, 2024',
            time: '2:30 PM',
            address: '123 Main Street, City, State 12345'
        },
        2: {
            id: 2,
            product: 'Khaijhandi',
            quantity: 1,
            total: 1800.00,
            status: 'pending',
            date: 'Mar 22, 2024',
            time: '11:15 AM',
            address: '456 Oak Avenue, City, State 67890'
        },
        3: {
            id: 3,
            product: 'Madal',
            quantity: 1,
            total: 3200.00,
            status: 'processing',
            date: 'Mar 23, 2024',
            time: '4:45 PM',
            address: '789 Pine Road, City, State 54321'
        },
        4: {
            id: 4,
            product: 'Sarangi',
            quantity: 3,
            total: 950.00,
            status: 'completed',
            date: 'Mar 18, 2024',
            time: '9:20 AM',
            address: '321 Elm Street, City, State 98765'
        },
        5: {
            id: 5,
            product: 'Damphu',
            quantity: 1,
            total: 4500.00,
            status: 'pending',
            date: 'Mar 21, 2024',
            time: '1:10 PM',
            address: '654 Maple Drive, City, State 13579'
        }
    };

    // View Order Function
    function viewOrder(orderId) {
        const order = sampleOrders[orderId];
        if (!order) {
            alert('Order not found!');
            return;
        }

        const statusBadge = getStatusBadge(order.status);
        
        const orderDetailsHTML = `
            <div class="order-info">
                <h6>Order Information</h6>
                <table class="table table-sm">
                    <tr><td><strong>Order ID:</strong></td><td>ORD-${String(order.id).padStart(3, '0')}</td></tr>
                    <tr><td><strong>Status:</strong></td><td>${statusBadge}</td></tr>
                    <tr><td><strong>Order Date:</strong></td><td>${order.date} at ${order.time}</td></tr>
                    <tr><td><strong>Total Amount:</strong></td><td><strong>Rs. ${order.total.toFixed(2)}</strong></td></tr>
                </table>
            </div>
            <div class="product-info" style="margin-top: 20px;">
                <h6>Product Information</h6>
                <table class="table table-sm">
                    <tr><td><strong>Product:</strong></td><td>${order.product}</td></tr>
                    <tr><td><strong>Quantity:</strong></td><td>${order.quantity} piece(s)</td></tr>
                    <tr><td><strong>Unit Price:</strong></td><td>Rs. ${(order.total / order.quantity).toFixed(2)}</td></tr>
                </table>
            </div>
            <div class="delivery-info" style="margin-top: 20px;">
                <h6>Delivery Address</h6>
                <p>${order.address}</p>
            </div>
        `;

        document.getElementById('orderDetails').innerHTML = orderDetailsHTML;
        showModal('viewOrderModal');
    }

    // Cancel Order Function
    function cancelOrder(orderId) {
        const order = sampleOrders[orderId];
        if (!order) {
            alert('Order not found!');
            return;
        }

        if (confirm(`Are you sure you want to cancel order ORD-${String(orderId).padStart(3, '0')}?`)) {
            // In a real app, this would send a request to the server
            showMessage(`Order ORD-${String(orderId).padStart(3, '0')} has been cancelled successfully!`, 'success');
            
            // Update the table row
            const rows = document.querySelectorAll('#ordersTable tbody tr');
            rows.forEach(row => {
                const orderIdCell = row.querySelector('td:first-child strong');
                if (orderIdCell && orderIdCell.textContent === `ORD-${String(orderId).padStart(3, '0')}`) {
                    const statusCell = row.querySelector('.badge');
                    statusCell.className = 'badge pending';
                    statusCell.textContent = 'Cancelled';
                    
                    // Remove cancel button
                    const cancelBtn = row.querySelector('.action-btn.danger');
                    if (cancelBtn) cancelBtn.remove();
                }
            });
        }
    }

    // Get Status Badge HTML
    function getStatusBadge(status) {
        const badges = {
            'pending': '<span class="badge pending">Pending</span>',
            'processing': '<span class="badge processing">Processing</span>',
            'completed': '<span class="badge completed">Completed</span>'
        };
        return badges[status] || `<span class="badge">${status}</span>`;
    }

    // Filter Orders Function
    function filterOrders() {
        const status = prompt('Filter by status (pending, processing, completed):');
        if (!status) return;
        
        const rows = document.querySelectorAll('#ordersTable tbody tr');
        let visibleCount = 0;
        
        rows.forEach(row => {
            const statusBadge = row.querySelector('.badge');
            const rowStatus = statusBadge.textContent.toLowerCase();
            
            if (status.toLowerCase() === 'all' || rowStatus.includes(status.toLowerCase())) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        showMessage(`Showing ${visibleCount} orders with status: ${status}`, 'info');
    }

    // Refresh Orders Function
    function refreshOrders() {
        showMessage('Orders refreshed!', 'info');
        setTimeout(() => {
            location.reload();
        }, 1000);
    }

    // Show Modal Function
    function showModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('fade', 'show');
        modal.style.display = 'flex';
    }

    // Hide Modal Function
    function hideModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.remove('show');
        setTimeout(() => {
            modal.style.display = 'none';
        }, 150);
    }

    // Show Message Function
    function showMessage(message, type = 'success') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
        `;
        
        document.body.appendChild(alertDiv);
        
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 3000);
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal')) {
            e.target.classList.remove('show');
            setTimeout(() => {
                e.target.style.display = 'none';
            }, 150);
        }
    });

    // Close modal with close button
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-close')) {
            const modal = e.target.closest('.modal');
            if (modal) {
                modal.classList.remove('show');
                setTimeout(() => {
                    modal.style.display = 'none';
                }, 150);
            }
        }
    });

    console.log('Customer Orders page loaded successfully!');
</script>
@endsection