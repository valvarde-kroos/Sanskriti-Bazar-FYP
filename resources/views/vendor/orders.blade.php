@extends('vendor.layout.main')

@section('title', 'Order Management')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Order Management - Vendor Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container-fluid py-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-1">Order Management</h2>
                        <p class="text-muted mb-0">Manage your customer orders efficiently</p>
                    </div>
                    <div>
                        <button class="btn btn-outline-primary me-2" onclick="exportOrders()">
                            <i class="fas fa-download"></i> Export Orders
                        </button>
                        <button class="btn btn-primary" onclick="refreshOrders()">
                            <i class="fas fa-refresh"></i> Refresh
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Orders Table -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0">Customer Orders</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="ordersTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Total</th>
                                        <th>Earning</th>
                                        <th>Status</th>
                                        <th>Customer</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                    <tr>
                                        <td>
                                            <strong class="text-primary">Order {{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</strong>
                                        </td>
                                        <td>
                                            <strong>Rs. {{ number_format($order->total_price, 2) }}</strong>
                                        </td>
                                        <td>
                                            <strong class="text-success">Rs. {{ number_format($order->total_price * 0.9, 2) }}</strong>
                                            <small class="text-muted d-block">90% commission</small>
                                        </td>
                                        <td>
                                            @switch($order->status)
                                                @case('pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                    @break
                                                @case('processing')
                                                    <span class="badge bg-info">Processing</span>
                                                    @break
                                                @case('shipped')
                                                    <span class="badge bg-primary">Shipped</span>
                                                    @break
                                                @case('delivered')
                                                    <span class="badge bg-success">Delivered</span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="badge bg-danger">Cancelled</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                            @endswitch
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ $order->user->name ?? 'Unknown Customer' }}</strong>
                                                <small class="text-muted d-block">{{ $order->user->email ?? 'No email' }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span>{{ $order->created_at->format('M d, Y') }}</span>
                                            <small class="text-muted d-block">{{ $order->created_at->format('h:i A') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewOrder({{ $order->id }})" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-success" onclick="updateStatus({{ $order->id }})" title="Update Status">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <!-- Dummy Data for Demo -->
                                    <tr>
                                        <td><strong class="text-primary">Order 2330</strong></td>
                                        <td><strong>Rs. 2,500.00</strong></td>
                                        <td>
                                            <strong class="text-success">Rs. 2,250.00</strong>
                                            <small class="text-muted d-block">90% commission</small>
                                        </td>
                                        <td><span class="badge bg-info">Processing</span></td>
                                        <td>
                                            <div>
                                                <strong>Alex Davis</strong>
                                                <small class="text-muted d-block">alex.davis@email.com</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span>Apr 27, 2024</span>
                                            <small class="text-muted d-block">2:30 PM</small>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewOrder(2330)" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-success" onclick="updateStatus(2330)" title="Update Status">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong class="text-primary">Order 2329</strong></td>
                                        <td><strong>Rs. 1,800.00</strong></td>
                                        <td>
                                            <strong class="text-success">Rs. 1,620.00</strong>
                                            <small class="text-muted d-block">90% commission</small>
                                        </td>
                                        <td><span class="badge bg-warning text-dark">Pending</span></td>
                                        <td>
                                            <div>
                                                <strong>Sarah Johnson</strong>
                                                <small class="text-muted d-block">sarah.j@email.com</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span>Apr 26, 2024</span>
                                            <small class="text-muted d-block">11:15 AM</small>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewOrder(2329)" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-success" onclick="updateStatus(2329)" title="Update Status">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong class="text-primary">Order 2328</strong></td>
                                        <td><strong>Rs. 3,200.00</strong></td>
                                        <td>
                                            <strong class="text-success">Rs. 2,880.00</strong>
                                            <small class="text-muted d-block">90% commission</small>
                                        </td>
                                        <td><span class="badge bg-success">Delivered</span></td>
                                        <td>
                                            <div>
                                                <strong>Mike Wilson</strong>
                                                <small class="text-muted d-block">mike.wilson@email.com</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span>Apr 25, 2024</span>
                                            <small class="text-muted d-block">4:45 PM</small>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewOrder(2328)" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-success" onclick="updateStatus(2328)" title="Update Status">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong class="text-primary">Order 2327</strong></td>
                                        <td><strong>Rs. 950.00</strong></td>
                                        <td>
                                            <strong class="text-success">Rs. 855.00</strong>
                                            <small class="text-muted d-block">90% commission</small>
                                        </td>
                                        <td><span class="badge bg-primary">Shipped</span></td>
                                        <td>
                                            <div>
                                                <strong>Emma Brown</strong>
                                                <small class="text-muted d-block">emma.brown@email.com</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span>Apr 24, 2024</span>
                                            <small class="text-muted d-block">9:20 AM</small>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewOrder(2327)" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-success" onclick="updateStatus(2327)" title="Update Status">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong class="text-primary">Order 2326</strong></td>
                                        <td><strong>Rs. 1,450.00</strong></td>
                                        <td>
                                            <strong class="text-success">Rs. 1,305.00</strong>
                                            <small class="text-muted d-block">90% commission</small>
                                        </td>
                                        <td><span class="badge bg-danger">Cancelled</span></td>
                                        <td>
                                            <div>
                                                <strong>John Smith</strong>
                                                <small class="text-muted d-block">john.smith@email.com</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span>Apr 23, 2024</span>
                                            <small class="text-muted d-block">1:10 PM</small>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewOrder(2326)" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-success" onclick="updateStatus(2326)" title="Update Status">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
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

    <!-- Update Status Modal -->
    <div class="modal fade" id="updateStatusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Order Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="updateStatusForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="orderStatus" class="form-label">Select New Status:</label>
                            <select class="form-select" id="orderStatus" name="status" required>
                                <option value="pending">Pending - Order received, waiting to process</option>
                                <option value="processing">Processing - Preparing the order</option>
                                <option value="shipped">Shipped - Order is on the way</option>
                                <option value="delivered">Delivered - Customer received the order</option>
                                <option value="cancelled">Cancelled - Order was cancelled</option>
                            </select>
                        </div>
                        <div class="alert alert-info">
                            <small>
                                <strong>Status Guide:</strong><br>
                                • <strong>Pending:</strong> New order, needs your attention<br>
                                • <strong>Processing:</strong> You're preparing the order<br>
                                • <strong>Shipped:</strong> Order sent to customer<br>
                                • <strong>Delivered:</strong> Customer received the order<br>
                                • <strong>Cancelled:</strong> Order was cancelled
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        // Sample order data for demonstration
        const sampleOrders = {
            2330: {
                id: 2330,
                total: 2500.00,
                earning: 2250.00,
                status: 'processing',
                customer: 'Alex Davis',
                email: 'alex.davis@email.com',
                date: 'Apr 27, 2024',
                time: '2:30 PM',
                product: 'Traditional Handicraft Set',
                quantity: 2,
                address: '123 Main Street, City, State 12345'
            },
            2329: {
                id: 2329,
                total: 1800.00,
                earning: 1620.00,
                status: 'pending',
                customer: 'Sarah Johnson',
                email: 'sarah.j@email.com',
                date: 'Apr 26, 2024',
                time: '11:15 AM',
                product: 'Handwoven Textile',
                quantity: 1,
                address: '456 Oak Avenue, City, State 67890'
            },
            2328: {
                id: 2328,
                total: 3200.00,
                earning: 2880.00,
                status: 'delivered',
                customer: 'Mike Wilson',
                email: 'mike.wilson@email.com',
                date: 'Apr 25, 2024',
                time: '4:45 PM',
                product: 'Premium Craft Collection',
                quantity: 1,
                address: '789 Pine Road, City, State 54321'
            },
            2327: {
                id: 2327,
                total: 950.00,
                earning: 855.00,
                status: 'shipped',
                customer: 'Emma Brown',
                email: 'emma.brown@email.com',
                date: 'Apr 24, 2024',
                time: '9:20 AM',
                product: 'Decorative Items',
                quantity: 3,
                address: '321 Elm Street, City, State 98765'
            },
            2326: {
                id: 2326,
                total: 1450.00,
                earning: 1305.00,
                status: 'cancelled',
                customer: 'John Smith',
                email: 'john.smith@email.com',
                date: 'Apr 23, 2024',
                time: '1:10 PM',
                product: 'Cultural Artifacts',
                quantity: 1,
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
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted">Order Information</h6>
                        <table class="table table-sm">
                            <tr><td><strong>Order ID:</strong></td><td>Order ${order.id}</td></tr>
                            <tr><td><strong>Status:</strong></td><td>${statusBadge}</td></tr>
                            <tr><td><strong>Order Date:</strong></td><td>${order.date} at ${order.time}</td></tr>
                            <tr><td><strong>Total Amount:</strong></td><td><strong>Rs. ${order.total.toFixed(2)}</strong></td></tr>
                            <tr><td><strong>Your Earning:</strong></td><td><strong class="text-success">Rs. ${order.earning.toFixed(2)}</strong></td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Customer Information</h6>
                        <table class="table table-sm">
                            <tr><td><strong>Name:</strong></td><td>${order.customer}</td></tr>
                            <tr><td><strong>Email:</strong></td><td>${order.email}</td></tr>
                            <tr><td><strong>Address:</strong></td><td>${order.address}</td></tr>
                        </table>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <h6 class="text-muted">Product Information</h6>
                        <table class="table table-sm">
                            <tr><td><strong>Product:</strong></td><td>${order.product}</td></tr>
                            <tr><td><strong>Quantity:</strong></td><td>${order.quantity} piece(s)</td></tr>
                            <tr><td><strong>Unit Price:</strong></td><td>Rs. ${(order.total / order.quantity).toFixed(2)}</td></tr>
                        </table>
                    </div>
                </div>
            `;

            document.getElementById('orderDetails').innerHTML = orderDetailsHTML;
            new bootstrap.Modal(document.getElementById('viewOrderModal')).show();
        }

        // Update Status Function
        function updateStatus(orderId) {
            const order = sampleOrders[orderId];
            if (!order) {
                alert('Order not found!');
                return;
            }

            // Set current status in the select dropdown
            document.getElementById('orderStatus').value = order.status;
            
            // Set form action (in real app, this would be the actual route)
            document.getElementById('updateStatusForm').action = `/vendor/order/${orderId}/update`;
            
            // Show modal
            new bootstrap.Modal(document.getElementById('updateStatusModal')).show();
        }

        // Get Status Badge HTML
        function getStatusBadge(status) {
            const badges = {
                'pending': '<span class="badge bg-warning text-dark">Pending</span>',
                'processing': '<span class="badge bg-info">Processing</span>',
                'shipped': '<span class="badge bg-primary">Shipped</span>',
                'delivered': '<span class="badge bg-success">Delivered</span>',
                'cancelled': '<span class="badge bg-danger">Cancelled</span>'
            };
            return badges[status] || `<span class="badge bg-secondary">${status}</span>`;
        }

        // Export Orders Function
        function exportOrders() {
            // Create CSV content
            let csvContent = "Order ID,Total,Earning,Status,Customer,Email,Date,Product,Quantity\n";
            
            Object.values(sampleOrders).forEach(order => {
                csvContent += `${order.id},${order.total},${order.earning},${order.status},"${order.customer}","${order.email}","${order.date}","${order.product}",${order.quantity}\n`;
            });

            // Create and download file
            const blob = new Blob([csvContent], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'orders_export.csv';
            a.click();
            window.URL.revokeObjectURL(url);

            // Show success message
            showAlert('Orders exported successfully!', 'success');
        }

        // Refresh Orders Function
        function refreshOrders() {
            // In a real app, this would reload data from server
            showAlert('Orders refreshed!', 'info');
            setTimeout(() => {
                location.reload();
            }, 1000);
        }

        // Show Alert Function
        function showAlert(message, type = 'success') {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
            alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            alertDiv.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(alertDiv);

            // Auto remove after 3 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 3000);
        }

        // Handle form submission for status update
        document.getElementById('updateStatusForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const newStatus = formData.get('status');
            
            // In a real app, this would send data to server
            // For demo, we'll just show success message
            showAlert(`Order status updated to ${newStatus.toUpperCase()}!`, 'success');
            
            // Close modal
            bootstrap.Modal.getInstance(document.getElementById('updateStatusModal')).hide();
            
            // In a real app, you would reload the page or update the table row
            setTimeout(() => {
                location.reload();
            }, 1500);
        });

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Order Management page loaded successfully!');
            console.log('Available functions:');
            console.log('- viewOrder(id): View order details');
            console.log('- updateStatus(id): Update order status');
            console.log('- exportOrders(): Export orders to CSV');
            console.log('- refreshOrders(): Refresh the page');
        });
    </script>
</body>
</html>
@endsection