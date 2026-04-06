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
    <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
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
                        <div class="dropdown-container">
                            <button class="dropdown-toggle" onclick="toggleDropdown({{ $order->id }})">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu" id="dropdown-{{ $order->id }}">
                                <button class="dropdown-item" onclick="viewOrder({{ $order->id }})">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                @if($order->status === 'pending')
                                    <button class="dropdown-item danger" onclick="cancelOrder({{ $order->id }})">
                                        <i class="fas fa-times"></i> Cancel
                                    </button>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <!-- Demo Data - Only shown when no real orders exist -->
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
                        <div class="dropdown-container">
                            <button class="dropdown-toggle" onclick="toggleDropdown('demo-1')">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu" id="dropdown-demo-1">
                                <button class="dropdown-item" onclick="viewDemoOrder('demo-1')">
                                    <i class="fas fa-eye"></i> View
                                </button>
                            </div>
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
                        <div class="dropdown-container">
                            <button class="dropdown-toggle" onclick="toggleDropdown('demo-2')">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu" id="dropdown-demo-2">
                                <button class="dropdown-item" onclick="viewDemoOrder('demo-2')">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <button class="dropdown-item danger" onclick="cancelDemoOrder('demo-2')">
                                    <i class="fas fa-times"></i> Cancel
                                </button>
                            </div>
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
                        <div class="dropdown-container">
                            <button class="dropdown-toggle" onclick="toggleDropdown('demo-3')">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu" id="dropdown-demo-3">
                                <button class="dropdown-item" onclick="viewDemoOrder('demo-3')">
                                    <i class="fas fa-eye"></i> View
                                </button>
                            </div>
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
                        <div class="dropdown-container">
                            <button class="dropdown-toggle" onclick="toggleDropdown('demo-4')">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu" id="dropdown-demo-4">
                                <button class="dropdown-item" onclick="viewDemoOrder('demo-4')">
                                    <i class="fas fa-eye"></i> View
                                </button>
                            </div>
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
                        <div class="dropdown-container">
                            <button class="dropdown-toggle" onclick="toggleDropdown('demo-5')">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu" id="dropdown-demo-5">
                                <button class="dropdown-item" onclick="viewDemoOrder('demo-5')">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <button class="dropdown-item danger" onclick="cancelDemoOrder('demo-5')">
                                    <i class="fas fa-times"></i> Cancel
                                </button>
                            </div>
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
                <button type="button" class="btn-close" onclick="closeOrderModal()">×</button>
            </div>
            <div class="modal-body" id="orderDetails">
                <!-- Order details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeOrderModal()">Close</button>
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

    .dropdown-container {
        position: relative;
        display: inline-block;
    }

    .dropdown-toggle {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        padding: 8px 10px;
        cursor: pointer;
        color: #6c757d;
        transition: all 0.3s ease;
    }

    .dropdown-toggle:hover {
        background: #e9ecef;
        color: #495057;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        min-width: 120px;
        z-index: 1000;
        display: none;
        padding: 4px 0;
    }

    .dropdown-menu.show {
        display: block;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 8px;
        width: 100%;
        padding: 8px 12px;
        background: none;
        border: none;
        color: #495057;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: left;
    }

    .dropdown-item:hover {
        background: #f8f9fa;
        color: #667eea;
    }

    .dropdown-item.danger {
        color: #dc3545;
    }

    .dropdown-item.danger:hover {
        background: #f8d7da;
        color: #721c24;
    }

    .dropdown-item i {
        width: 14px;
        text-align: center;
    }

    .modal {
        display: none !important;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
    }

    .modal.show {
        display: flex !important;
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
        transition: all 0.3s ease;
    }

    .btn-secondary {
        background: #6c757d;
        color: #fff;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background: #5a6268;
        border-color: #545b62;
    }

    .btn-close {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        padding: 8px;
        color: #6c757d;
        line-height: 1;
        opacity: 0.8;
        transition: all 0.3s ease;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
    }

    .btn-close:hover {
        opacity: 1;
        color: #000;
        background: #f8f9fa;
    }

    .btn-close:active {
        transform: scale(0.95);
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
    // Toggle dropdown menu
    function toggleDropdown(orderId) {
        // Close all other dropdowns
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            if (menu.id !== `dropdown-${orderId}`) {
                menu.classList.remove('show');
            }
        });
        
        // Toggle current dropdown
        const dropdown = document.getElementById(`dropdown-${orderId}`);
        dropdown.classList.toggle('show');
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown-container')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('show');
            });
        }
    });

    // View Order Function - Updated to work with backend API
    function viewOrder(orderId) {
        // Close dropdown
        document.getElementById(`dropdown-${orderId}`).classList.remove('show');
        
        // Fetch order details from backend
        fetch(`/customer/order/${orderId}/view`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const order = data.order;
                const statusBadge = getStatusBadge(order.status);
                
                const orderDetailsHTML = `
                    <div class="order-info">
                        <h6>Order Information</h6>
                        <table class="table table-sm">
                            <tr><td><strong>Order ID:</strong></td><td>${order.order_number}</td></tr>
                            <tr><td><strong>Status:</strong></td><td>${statusBadge}</td></tr>
                            <tr><td><strong>Order Date:</strong></td><td>${order.created_at}</td></tr>
                            <tr><td><strong>Total Amount:</strong></td><td><strong>Rs. ${parseFloat(order.total_price).toLocaleString('en-US', {minimumFractionDigits: 2})}</strong></td></tr>
                        </table>
                    </div>
                    <div class="product-info" style="margin-top: 20px;">
                        <h6>Product Information</h6>
                        <table class="table table-sm">
                            <tr><td><strong>Product:</strong></td><td>${order.product_name}</td></tr>
                            <tr><td><strong>Quantity:</strong></td><td>${order.quantity} piece(s)</td></tr>
                            <tr><td><strong>Vendor:</strong></td><td>${order.vendor_name}</td></tr>
                        </table>
                    </div>
                    <div class="delivery-info" style="margin-top: 20px;">
                        <h6>Delivery Address</h6>
                        <p>${order.shipping_address}</p>
                    </div>
                `;

                document.getElementById('orderDetails').innerHTML = orderDetailsHTML;
                showModal('viewOrderModal');
            } else {
                showMessage(data.message || 'Failed to load order details', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('Failed to load order details. Please try again.', 'error');
        });
    }

    // Cancel Order Function - Updated to work with backend API
    function cancelOrder(orderId) {
        // Close dropdown
        document.getElementById(`dropdown-${orderId}`).classList.remove('show');
        
        // Find order data from the table for confirmation
        const orderRow = document.querySelector(`[onclick*="cancelOrder(${orderId})"]`).closest('tr');
        const orderNumber = orderRow.querySelector('td:first-child').textContent.trim();

        if (confirm(`Are you sure you want to cancel ${orderNumber}?`)) {
            fetch(`/customer/order/${orderId}/cancel`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({ _method: 'POST' })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage(data.message || `${orderNumber} has been cancelled successfully!`, 'success');
                    
                    // Update the table row
                    const statusCell = orderRow.querySelector('.badge');
                    statusCell.className = 'badge cancelled';
                    statusCell.textContent = 'Cancelled';
                    
                    // Remove cancel button from dropdown
                    const cancelBtn = document.querySelector(`#dropdown-${orderId} .dropdown-item.danger`);
                    if (cancelBtn) cancelBtn.remove();
                } else {
                    showMessage(data.message || 'Failed to cancel order. Please try again.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('Failed to cancel order. Please try again.', 'error');
            });
        }
    }

    // Get Status Badge HTML
    function getStatusBadge(status) {
        const badges = {
            'pending': '<span class="badge pending">Pending</span>',
            'processing': '<span class="badge processing">Processing</span>',
            'completed': '<span class="badge completed">Completed</span>',
            'cancelled': '<span class="badge cancelled">Cancelled</span>'
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
        console.log('Hiding modal:', modalId); // Debug log
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('show');
            modal.classList.remove('fade');
            modal.style.display = 'none';
            console.log('Modal hidden successfully'); // Debug log
        } else {
            console.error('Modal not found:', modalId); // Debug log
        }
    }

    // Simple close function specifically for order modal
    function closeOrderModal() {
        console.log('Closing order modal'); // Debug log
        const modal = document.getElementById('viewOrderModal');
        if (modal) {
            modal.style.display = 'none';
            modal.classList.remove('show');
            modal.classList.remove('fade');
            console.log('Order modal closed'); // Debug log
        }
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
        if (e.target.classList.contains('modal') && e.target.id === 'viewOrderModal') {
            closeOrderModal();
        }
    });

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeOrderModal();
        }
    });

    // Demo Order Functions (for when no real orders exist)
    function viewDemoOrder(demoId) {
        // Close dropdown
        document.getElementById(`dropdown-${demoId}`).classList.remove('show');
        
        // Demo order data
        const demoOrders = {
            'demo-1': { orderNumber: 'ORD-001', product: 'Bansuri', quantity: '2', total: 'Rs. 2,500.00', status: 'Completed', date: 'Mar 20, 2024', time: '2:30 PM' },
            'demo-2': { orderNumber: 'ORD-002', product: 'Khaijhandi', quantity: '1', total: 'Rs. 1,800.00', status: 'Pending', date: 'Mar 22, 2024', time: '11:15 AM' },
            'demo-3': { orderNumber: 'ORD-003', product: 'Madal', quantity: '1', total: 'Rs. 3,200.00', status: 'Processing', date: 'Mar 23, 2024', time: '4:45 PM' },
            'demo-4': { orderNumber: 'ORD-004', product: 'Sarangi', quantity: '3', total: 'Rs. 950.00', status: 'Completed', date: 'Mar 18, 2024', time: '9:20 AM' },
            'demo-5': { orderNumber: 'ORD-005', product: 'Damphu', quantity: '1', total: 'Rs. 4,500.00', status: 'Pending', date: 'Mar 21, 2024', time: '1:10 PM' }
        };
        
        const orderData = demoOrders[demoId];
        if (!orderData) return;
        
        const statusBadge = getStatusBadge(orderData.status.toLowerCase());
        
        const orderDetailsHTML = `
            <div class="order-info">
                <h6>Order Information (Demo)</h6>
                <table class="table table-sm">
                    <tr><td><strong>Order ID:</strong></td><td>${orderData.orderNumber}</td></tr>
                    <tr><td><strong>Status:</strong></td><td>${statusBadge}</td></tr>
                    <tr><td><strong>Order Date:</strong></td><td>${orderData.date} ${orderData.time}</td></tr>
                    <tr><td><strong>Total Amount:</strong></td><td><strong>${orderData.total}</strong></td></tr>
                </table>
            </div>
            <div class="product-info" style="margin-top: 20px;">
                <h6>Product Information</h6>
                <table class="table table-sm">
                    <tr><td><strong>Product:</strong></td><td>${orderData.product}</td></tr>
                    <tr><td><strong>Quantity:</strong></td><td>${orderData.quantity} piece(s)</td></tr>
                    <tr><td><strong>Vendor:</strong></td><td>Demo Vendor</td></tr>
                </table>
            </div>
            <div class="delivery-info" style="margin-top: 20px;">
                <h6>Delivery Address</h6>
                <p>Your registered address will be used for delivery</p>
            </div>
        `;

        document.getElementById('orderDetails').innerHTML = orderDetailsHTML;
        showModal('viewOrderModal');
    }

    function cancelDemoOrder(demoId) {
        // Close dropdown
        document.getElementById(`dropdown-${demoId}`).classList.remove('show');
        
        // Find order data from the table
        const orderRow = document.querySelector(`[onclick*="cancelDemoOrder('${demoId}')"]`).closest('tr');
        const orderNumber = orderRow.querySelector('td:first-child').textContent.trim();

        if (confirm(`Are you sure you want to cancel ${orderNumber}? (Demo)`)) {
            showMessage(`${orderNumber} has been cancelled successfully! (Demo)`, 'success');
            
            // Update the table row
            const statusCell = orderRow.querySelector('.badge');
            statusCell.className = 'badge cancelled';
            statusCell.textContent = 'Cancelled';
            
            // Remove cancel button from dropdown
            const cancelBtn = document.querySelector(`#dropdown-${demoId} .dropdown-item.danger`);
            if (cancelBtn) cancelBtn.remove();
        }
    }

    console.log('Customer Orders page loaded successfully!');
</script>
@endsection