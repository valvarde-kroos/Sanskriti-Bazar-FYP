@extends('layout.main')

@section('hyasabicontentauncha')
<style>
    /* CSS Variables for consistent colors */
    :root {
        --primary-color: #3b82f6;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --info-color: #6366f1;
        --gray-800: #1f2937;
        --gray-700: #374151;
        --gray-600: #4b5563;
        --gray-500: #6b7280;
        --gray-400: #9ca3af;
        --gray-300: #d1d5db;
        --gray-200: #e5e7eb;
        --gray-100: #f3f4f6;
        --gray-50: #f9fafb;
        --white: #ffffff;
        --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --border-radius: 8px;
    }

    /* Simple Vendor Dashboard Styles */
    .vendor-dashboard {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* Dashboard Header */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    .header-left h1 {
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--gray-800);
        margin: 0 0 0.5rem 0;
    }

    .header-left p {
        color: var(--gray-600);
        margin: 0;
        font-size: 1rem;
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
        flex-shrink: 0;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        font-size: 0.875rem;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background: var(--primary-color);
        color: white;
    }

    .btn-primary:hover {
        background: #2563eb;
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: var(--gray-600);
        color: white;
    }

    .btn-secondary:hover {
        background: var(--gray-700);
        transform: translateY(-1px);
    }

    .btn-outline {
        background: transparent;
        border: 1px solid var(--gray-300);
        color: var(--gray-700);
    }

    .btn-outline:hover {
        background: var(--gray-50);
    }

    /* Alert Messages */
    .alert {
        padding: 1rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .alert-danger {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    /* Stats Cards */
    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--white);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-2px);
    }

    .stat-card.products { border-left: 4px solid var(--primary-color); }
    .stat-card.orders { border-left: 4px solid var(--info-color); }
    .stat-card.pending { border-left: 4px solid var(--warning-color); }
    .stat-card.revenue { border-left: 4px solid var(--success-color); }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        flex-shrink: 0;
    }

    .stat-card.products .stat-icon { background: var(--primary-color); }
    .stat-card.orders .stat-icon { background: var(--info-color); }
    .stat-card.pending .stat-icon { background: var(--warning-color); }
    .stat-card.revenue .stat-icon { background: var(--success-color); }

    .stat-info {
        flex: 1;
    }

    .stat-number {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--gray-800);
        margin: 0 0 0.25rem 0;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray-700);
        margin: 0 0 0.25rem 0;
    }

    .stat-desc {
        font-size: 0.75rem;
        color: var(--gray-500);
        margin: 0;
    }

    /* Quick Actions */
    .quick-actions {
        background: var(--white);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        margin-bottom: 2rem;
    }

    .quick-actions h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--gray-800);
        margin: 0 0 1rem 0;
    }

    .action-buttons {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
    }

    .action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem;
        background: var(--gray-50);
        border: 1px solid var(--gray-200);
        border-radius: var(--border-radius);
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        color: var(--gray-700);
    }

    .action-btn:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow);
    }

    .action-btn i {
        font-size: 1.5rem;
    }

    .action-btn span {
        font-size: 0.875rem;
        font-weight: 500;
    }

    /* Dashboard Sections */
    .dashboard-section {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .section-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--gray-200);
        background: var(--gray-50);
    }

    .section-header h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--gray-800);
        margin: 0 0 0.25rem 0;
    }

    .section-subtitle {
        font-size: 0.875rem;
        color: var(--gray-600);
    }

    /* Table Styles */
    .table-container {
        overflow-x: auto;
    }

    .simple-table {
        width: 100%;
        border-collapse: collapse;
    }

    .simple-table th {
        background: var(--gray-50);
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: var(--gray-700);
        font-size: 0.875rem;
        border-bottom: 2px solid var(--gray-200);
        white-space: nowrap;
    }

    .simple-table td {
        padding: 1rem;
        border-bottom: 1px solid var(--gray-100);
        vertical-align: middle;
    }

    .simple-table tbody tr:hover {
        background: var(--gray-50);
    }

    /* Order Info */
    .order-id {
        font-weight: 600;
        color: var(--primary-color);
        font-family: 'Courier New', monospace;
    }

    .customer-info {
        display: flex;
        flex-direction: column;
    }

    .customer-name {
        font-weight: 500;
        color: var(--gray-800);
        font-size: 0.875rem;
    }

    .customer-email {
        font-size: 0.75rem;
        color: var(--gray-500);
    }

    .product-info {
        display: flex;
        flex-direction: column;
    }

    .product-name {
        font-weight: 500;
        color: var(--gray-800);
        font-size: 0.875rem;
    }

    .product-qty {
        font-size: 0.75rem;
        color: var(--gray-500);
    }

    .order-amount {
        font-weight: 600;
        color: var(--success-color);
        font-size: 0.875rem;
    }

    /* Product Info */
    .product-image {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-thumb {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid var(--gray-200);
    }

    .product-thumb-placeholder {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        background: var(--gray-100);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gray-400);
        font-size: 1.25rem;
        border: 2px solid var(--gray-200);
    }

    .product-name {
        font-weight: 600;
        color: var(--gray-800);
        font-size: 0.875rem;
    }

    .product-desc {
        color: var(--gray-600);
        font-size: 0.8125rem;
        line-height: 1.4;
    }

    .category-badge {
        background: rgba(59, 130, 246, 0.1);
        color: var(--primary-color);
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    /* Status Badges */
    .status-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .status-badge.pending {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning-color);
    }

    .status-badge.processing {
        background: rgba(59, 130, 246, 0.1);
        color: var(--primary-color);
    }

    .status-badge.completed {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }

    .status-badge.cancelled {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
    }

    /* Status Select */
    .status-select {
        padding: 0.5rem 0.75rem;
        border: 1px solid var(--gray-300);
        border-radius: 4px;
        font-size: 0.75rem;
        background: var(--white);
        cursor: pointer;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        transition: all 0.2s ease;
    }

    .btn-action.view {
        background: rgba(59, 130, 246, 0.1);
        color: var(--primary-color);
    }

    .btn-action.view:hover {
        background: var(--primary-color);
        color: white;
    }

    .btn-action.edit {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning-color);
    }

    .btn-action.edit:hover {
        background: var(--warning-color);
        color: white;
    }

    .btn-action.delete {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
    }

    .btn-action.delete:hover {
        background: var(--danger-color);
        color: white;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        color: var(--gray-500);
    }

    .empty-icon {
        font-size: 4rem;
        color: var(--gray-300);
        margin-bottom: 1rem;
    }

    .empty-state h4 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--gray-700);
        margin: 0 0 0.5rem 0;
    }

    .empty-state p {
        font-size: 0.875rem;
        color: var(--gray-500);
        margin: 0 0 1.5rem 0;
    }

    /* Tips Section */
    .tips-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .tips-section .section-header {
        background: rgba(255, 255, 255, 0.1);
        border-bottom-color: rgba(255, 255, 255, 0.2);
    }

    .tips-section .section-header h3,
    .tips-section .section-header .section-subtitle {
        color: white;
    }

    .tips-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        padding: 1.5rem;
    }

    .tip-card {
        background: rgba(255, 255, 255, 0.1);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .tip-icon {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        margin-bottom: 1rem;
    }

    .tip-card h4 {
        font-size: 1rem;
        font-weight: 600;
        margin: 0 0 0.5rem 0;
    }

    .tip-card p {
        font-size: 0.875rem;
        line-height: 1.5;
        margin: 0;
        opacity: 0.9;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
    }

    .modal-content {
        background: var(--white);
        margin: 2% auto;
        border-radius: var(--border-radius);
        width: 90%;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: var(--shadow-lg);
    }

    .modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--gray-50);
    }

    .modal-header h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--gray-800);
        margin: 0;
    }

    .close-btn {
        background: none;
        border: none;
        color: var(--gray-400);
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .close-btn:hover {
        background: var(--gray-100);
        color: var(--gray-600);
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid var(--gray-200);
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
        background: var(--gray-50);
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid var(--gray-300);
        border-radius: 6px;
        font-size: 0.875rem;
        transition: all 0.2s ease;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-group small {
        display: block;
        font-size: 0.75rem;
        color: var(--gray-500);
        margin-top: 0.25rem;
    }

    .form-group .error {
        color: var(--danger-color);
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }

    .file-input {
        padding: 0.5rem !important;
    }

    /* Beginner Tips */
    .beginner-tips {
        background: rgba(59, 130, 246, 0.05);
        border: 1px solid rgba(59, 130, 246, 0.1);
        border-radius: var(--border-radius);
        padding: 1rem;
        margin-top: 1rem;
    }

    .beginner-tips h4 {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--primary-color);
        margin: 0 0 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .beginner-tips ul {
        margin: 0;
        padding-left: 1.25rem;
    }

    .beginner-tips li {
        font-size: 0.8125rem;
        color: var(--gray-600);
        margin-bottom: 0.25rem;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .dashboard-header {
            flex-direction: column;
            gap: 1rem;
        }

        .stats-cards {
            grid-template-columns: repeat(2, 1fr);
        }

        .action-buttons {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .vendor-dashboard {
            padding: 1rem 0.5rem;
        }

        .stats-cards {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            grid-template-columns: 1fr;
        }

        .tips-grid {
            grid-template-columns: 1fr;
        }

        .simple-table {
            font-size: 0.8125rem;
        }

        .simple-table th,
        .simple-table td {
            padding: 0.75rem 0.5rem;
        }

        .modal-content {
            width: 95%;
            margin: 5% auto;
        }
    }

    @media (max-width: 480px) {
        .dashboard-header {
            padding: 1rem;
        }

        .header-actions {
            flex-direction: column;
        }

        .action-buttons {
            flex-direction: column;
        }
    }
</style>

<div class="vendor-dashboard">
    <!-- Simple Page Header -->
    <div class="dashboard-header">
        <div class="header-left">
            <h1>Vendor Dashboard</h1>
            <p>Welcome back, {{ auth()->user()->name }}! Here's your business overview</p>
        </div>
        <div class="header-actions">
            <button class="btn btn-secondary" onclick="exportData()">
                <i class="fas fa-download"></i>
                Export Report
            </button>
            <button class="btn btn-primary" onclick="openAddProductModal()">
                <i class="fas fa-plus"></i>
                Add New Product
            </button>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('delete'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle"></i>
            {{ session('delete') }}
        </div>
    @endif

    <!-- Simple Statistics Cards -->
    <div class="stats-cards">
        <div class="stat-card products">
            <div class="stat-icon">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $totalProducts }}</div>
                <div class="stat-label">My Products</div>
                <div class="stat-desc">Total products in store</div>
            </div>
        </div>

        <div class="stat-card orders">
            <div class="stat-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $totalOrders }}</div>
                <div class="stat-label">Total Orders</div>
                <div class="stat-desc">All time orders received</div>
            </div>
        </div>

        <div class="stat-card pending">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $pendingOrders }}</div>
                <div class="stat-label">Pending Orders</div>
                <div class="stat-desc">Need your attention</div>
            </div>
        </div>

        <div class="stat-card revenue">
            <div class="stat-icon">
                <i class="fas fa-rupee-sign"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">Rs. {{ number_format($totalRevenue, 0) }}</div>
                <div class="stat-label">Total Revenue</div>
                <div class="stat-desc">From completed orders</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="quick-actions">
        <h3>Quick Actions</h3>
        <div class="action-buttons">
            <button class="action-btn" onclick="openAddProductModal()">
                <i class="fas fa-plus-circle"></i>
                <span>Add Product</span>
            </button>
            <button class="action-btn" onclick="scrollToSection('orders-section')">
                <i class="fas fa-list-alt"></i>
                <span>View Orders</span>
            </button>
            <button class="action-btn" onclick="scrollToSection('products-section')">
                <i class="fas fa-boxes"></i>
                <span>Manage Products</span>
            </button>
            <button class="action-btn" onclick="exportData()">
                <i class="fas fa-chart-line"></i>
                <span>View Reports</span>
            </button>
        </div>
    </div>

    <!-- Recent Orders Section -->
    <div class="dashboard-section" id="orders-section">
        <div class="section-header">
            <h3>Recent Orders</h3>
            <span class="section-subtitle">Orders that need your attention</span>
        </div>
        
        <div class="table-container">
            @if($orders->count() > 0)
                <table class="simple-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders->take(10) as $order)
                        <tr>
                            <td>
                                <div class="order-id">#ORD{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</div>
                            </td>
                            <td>
                                <div class="customer-info">
                                    <div class="customer-name">{{ $order->user->name }}</div>
                                    <div class="customer-email">{{ $order->user->email }}</div>
                                </div>
                            </td>
                            <td>
                                <div class="product-info">
                                    <div class="product-name">{{ Str::limit($order->product->post_title, 30) }}</div>
                                    <div class="product-qty">Qty: {{ $order->quantity }}</div>
                                </div>
                            </td>
                            <td>
                                <div class="order-amount">Rs. {{ number_format($order->total_price, 0) }}</div>
                            </td>
                            <td>
                                <span class="status-badge {{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>
                                <form action="{{ route('vendor.order.update', $order->id) }}" method="POST" class="status-form">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="updateOrderStatus(this)" class="status-select">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h4>No Orders Yet</h4>
                    <p>When customers order your products, they will appear here</p>
                    <button class="btn btn-primary" onclick="openAddProductModal()">Add Your First Product</button>
                </div>
            @endif
        </div>
    </div>

    <!-- My Products Section -->
    <div class="dashboard-section" id="products-section">
        <div class="section-header">
            <h3>My Products</h3>
            <span class="section-subtitle">Manage your product inventory</span>
        </div>
        
        <div class="table-container">
            @if($products->count() > 0)
                <table class="simple-table">
                    <thead>
                        <tr>
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Added Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>
                                <div class="product-image">
                                    @if($product->image)
                                        <img src="{{ asset('uploads/'.$product->image) }}" alt="{{ $product->post_title }}" class="product-thumb">
                                    @else
                                        <div class="product-thumb-placeholder">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="product-name">{{ $product->post_title }}</div>
                            </td>
                            <td>
                                <span class="category-badge">{{ $product->category->categoryName ?? 'No Category' }}</span>
                            </td>
                            <td>
                                <div class="product-desc">{{ Str::limit($product->post_description, 50) }}</div>
                            </td>
                            <td>{{ $product->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-action view" onclick="viewProduct({{ $product->id }})" title="View Product">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action edit" onclick="editProduct({{ $product->id }})" title="Edit Product">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action delete" onclick="deleteProduct({{ $product->id }})" title="Delete Product">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h4>No Products Yet</h4>
                    <p>Start selling by adding your first product to the store</p>
                    <button class="btn btn-primary" onclick="openAddProductModal()">Add Your First Product</button>
                </div>
            @endif
        </div>
    </div>

    <!-- Business Tips Section -->
    <div class="dashboard-section tips-section">
        <div class="section-header">
            <h3>Business Tips for Beginners</h3>
            <span class="section-subtitle">Simple tips to grow your business</span>
        </div>
        
        <div class="tips-grid">
            <div class="tip-card">
                <div class="tip-icon">
                    <i class="fas fa-camera"></i>
                </div>
                <h4>Add Good Photos</h4>
                <p>Use clear, bright photos of your products. Good photos help customers trust your products.</p>
            </div>
            
            <div class="tip-card">
                <div class="tip-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h4>Process Orders Quickly</h4>
                <p>Update order status promptly. Fast service makes customers happy and likely to return.</p>
            </div>
            
            <div class="tip-card">
                <div class="tip-icon">
                    <i class="fas fa-star"></i>
                </div>
                <h4>Write Clear Descriptions</h4>
                <p>Describe your products clearly. Include size, color, material, and how to use them.</p>
            </div>
            
            <div class="tip-card">
                <div class="tip-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <h4>Provide Good Service</h4>
                <p>Be polite and helpful to customers. Good service leads to positive reviews and more sales.</p>
            </div>
        </div>
    </div>
</div>

<!-- Add Product Modal -->
<div id="addProductModal" class="modal" style="display: {{ $errors->any() ? 'flex' : 'none' }};">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add New Product</h3>
            <button class="close-btn" onclick="closeAddProductModal()">&times;</button>
        </div>
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="post_title">Product Name *</label>
                    <input type="text" id="post_title" name="post_title" placeholder="Enter product name (e.g., Traditional Kurta)" value="{{ old('post_title') }}" required>
                    <small>Choose a clear, descriptive name for your product</small>
                    @error('post_title')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category_id">Category *</label>
                    <select id="category_id" name="category_id" required>
                        <option value="">Select a category for your product</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->categoryName }}
                            </option>
                        @endforeach
                    </select>
                    <small>Choose the category that best fits your product</small>
                    @error('category_id')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="post_description">Product Description *</label>
                    <textarea id="post_description" name="post_description" rows="4" placeholder="Describe your product in detail - include size, color, material, how to use it..." required>{{ old('post_description') }}</textarea>
                    <small>Write a detailed description to help customers understand your product</small>
                    @error('post_description')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="image">Product Image</label>
                    <input type="file" id="image" name="image" accept="image/*" class="file-input">
                    <small>Upload a clear, bright photo of your product (JPG, PNG formats)</small>
                    @error('image')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="beginner-tips">
                    <h4><i class="fas fa-lightbulb"></i> Tips for Success:</h4>
                    <ul>
                        <li>Use clear, bright photos</li>
                        <li>Write detailed descriptions</li>
                        <li>Choose the right category</li>
                        <li>Include size and material information</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeAddProductModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Add Product
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Simple JavaScript functions for beginners

// Open Add Product Modal
function openAddProductModal() {
    document.getElementById('addProductModal').style.display = 'flex';
}

// Close Add Product Modal
function closeAddProductModal() {
    document.getElementById('addProductModal').style.display = 'none';
}

// Scroll to specific section
function scrollToSection(sectionId) {
    const section = document.getElementById(sectionId);
    if (section) {
        section.scrollIntoView({ behavior: 'smooth' });
    }
}

// Update order status with confirmation
function updateOrderStatus(selectElement) {
    const newStatus = selectElement.value;
    const orderId = selectElement.closest('form').action.split('/').pop();
    
    const confirmMessage = `Are you sure you want to change this order status to "${newStatus.toUpperCase()}"?`;
    
    if (confirm(confirmMessage)) {
        selectElement.closest('form').submit();
    } else {
        // Reset to previous value if cancelled
        selectElement.selectedIndex = 0;
    }
}

// View product details
function viewProduct(productId) {
    alert(`View Product Feature\n\nThis would show detailed information about Product ID: ${productId}\n\nIn a real application, this would:\n• Show product details in a modal\n• Display product images\n• Show product statistics\n• Allow quick editing`);
}

// Edit product
function editProduct(productId) {
    alert(`Edit Product Feature\n\nThis would open an edit form for Product ID: ${productId}\n\nIn a real application, this would:\n• Show current product details\n• Allow updating name, description, image\n• Save changes to database\n• Update the display`);
}

// Delete product with confirmation
function deleteProduct(productId) {
    const confirmDelete = confirm(`Are you sure you want to delete this product?\n\nProduct ID: ${productId}\n\nThis action cannot be undone!\n\nThis will:\n• Remove the product from your store\n• Cancel any pending orders for this product\n• Remove all product data`);
    
    if (confirmDelete) {
        // In real application, this would make an API call
        window.location.href = `/product/delete/${productId}`;
    }
}

// Export data function
function exportData() {
    alert(`Export Data Feature\n\nThis would export your business data:\n\n• Product list with details\n• Order history and status\n• Revenue reports\n• Customer information\n\nExport formats:\n• Excel spreadsheet\n• PDF report\n• CSV file for analysis`);
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('addProductModal');
    if (event.target === modal) {
        closeAddProductModal();
    }
}

// Show success message
function showSuccessMessage(message) {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #10b981;
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 9999;
        font-weight: 500;
    `;
    notification.innerHTML = `<i class="fas fa-check-circle"></i> ${message}`;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    console.log('Vendor Dashboard loaded successfully!');
    console.log('Available functions for beginners:');
    console.log('- openAddProductModal(): Add new product');
    console.log('- viewProduct(id): View product details');
    console.log('- editProduct(id): Edit product information');
    console.log('- deleteProduct(id): Delete product');
    console.log('- exportData(): Export business data');
    console.log('- scrollToSection(id): Navigate to section');
});
</script>
@endsection
