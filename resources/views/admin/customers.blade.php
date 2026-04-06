@extends('admin.layout.main')

@section('title', 'Customers Management')

@section('content')
<!-- Success/Error Messages -->
@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-error">
    <i class="fas fa-exclamation-circle"></i>
    {{ session('error') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-error">
    <i class="fas fa-exclamation-triangle"></i>
    <ul style="margin: 0; padding-left: 1.5rem;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Page Header -->
<div class="page-header">
    <div class="header-left">
        <h1>Customers Management</h1>
        <p>Manage all customer accounts in Sanskriti Bazar</p>
    </div>
    <div class="header-right">
        <button class="btn btn-primary" onclick="showAddForm()">
            <i class="fas fa-plus"></i>
            Add New Customer
        </button>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-cards">
    <div class="stat-card active">
        <div class="stat-number">{{ $customers->where('role', 'customer')->count() }}</div>
        <div class="stat-label">Total Customers</div>
        <div class="stat-icon"><i class="fas fa-users"></i></div>
    </div>
    <div class="stat-card blocked">
        <div class="stat-number">{{ $customers->where('role', 'customer')->count() }}</div>
        <div class="stat-label">Active Customers</div>
        <div class="stat-icon"><i class="fas fa-user-check"></i></div>
    </div>
    <div class="stat-card new">
        <div class="stat-number">{{ $customers->where('created_at', '>=', now()->startOfMonth())->count() }}</div>
        <div class="stat-label">New This Month</div>
        <div class="stat-icon"><i class="fas fa-user-plus"></i></div>
    </div>
    <div class="stat-card orders">
        <div class="stat-number">{{ $customers->sum(function($customer) { return $customer->orders->count(); }) }}</div>
        <div class="stat-label">Total Orders</div>
        <div class="stat-icon"><i class="fas fa-shopping-bag"></i></div>
    </div>
</div>

<!-- Search Section -->
<div class="search-section">
    <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="customerSearch" placeholder="Search customers by name or email...">
    </div>
    <select id="statusFilter" class="filter-select">
        <option value="">All Customers</option>
        <option value="active">Active Only</option>
        <option value="inactive">Inactive Only</option>
    </select>
    <button class="btn btn-secondary" onclick="resetFilters()">
        <i class="fas fa-refresh"></i>
        Reset
    </button>
</div>

<!-- Customers Table -->
<div class="customers-table">
    <div class="table-header">
        <h3>All Customers</h3>
        <span class="customer-count">Showing {{ $customers->count() }} customers</span>
    </div>
    
    <div class="table-container">
        @if($customers->count() > 0)
            <table class="simple-table" id="customersTable">
                <thead>
                    <tr>
                        <th>Customer Info</th>
                        <th>Contact Details</th>
                        <th>Orders</th>
                        <th>Status</th>
                        <th>Joined Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                    <tr>
                        <td>
                            <div class="customer-info">
                                <div class="customer-avatar">{{ substr($customer->name, 0, 2) }}</div>
                                <div class="customer-details">
                                    <div class="customer-name">{{ $customer->name }}</div>
                                    <div class="customer-id">#CUST{{ str_pad($customer->id, 3, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="contact-info">
                                <div>{{ $customer->email }}</div>
                                @if($customer->phone)
                                    <div>{{ $customer->phone }}</div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="order-count">{{ $customer->orders_count ?? 0 }} Orders</span>
                        </td>
                        <td>
                            <span class="status-badge active">Active</span>
                        </td>
                        <td>{{ $customer->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="dropdown-container">
                                <button class="dropdown-toggle" onclick="toggleDropdown({{ $customer->id }})">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <div class="dropdown-menu" id="dropdown-{{ $customer->id }}">
                                    <button class="dropdown-item" onclick="viewCustomer({{ $customer->id }})">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    <button class="dropdown-item" onclick="editCustomer({{ $customer->id }})">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="dropdown-item danger" onclick="deleteCustomer({{ $customer->id }})">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h4>No Customers Found</h4>
                <p>Start by adding your first customer to the marketplace.</p>
                <button class="btn btn-primary" onclick="showAddForm()">
                    <i class="fas fa-plus"></i>
                    Add First Customer
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Add Customer Modal -->
<div id="addCustomerModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add New Customer</h3>
            <button class="modal-close" onclick="closeModal('addCustomerModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="addCustomerForm" class="customer-form" action="{{ route('admin.customer.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="customerName">Customer Name *</label>
                    <input type="text" id="customerName" name="name" placeholder="Enter customer name" required>
                    <small>Full name of the customer</small>
                </div>
                
                <div class="form-group">
                    <label for="customerEmail">Email Address *</label>
                    <input type="email" id="customerEmail" name="email" placeholder="Enter email address" required>
                    <small>This will be used for login</small>
                </div>
                
                <div class="form-group">
                    <label for="customerPhone">Phone Number</label>
                    <input type="text" id="customerPhone" name="phone" placeholder="Enter phone number">
                    <small>Contact phone number (optional)</small>
                </div>
                
                <div class="form-group">
                    <label for="customerPassword">Password *</label>
                    <input type="password" id="customerPassword" name="password" placeholder="Enter password" required>
                    <small>Minimum 6 characters</small>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-outline" onclick="closeModal('addCustomerModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Add Customer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Customer Modal -->
<div id="editCustomerModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Customer</h3>
            <button class="modal-close" onclick="closeModal('editCustomerModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="editCustomerForm" class="customer-form" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="editCustomerName">Customer Name *</label>
                    <input type="text" id="editCustomerName" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="editCustomerEmail">Email Address *</label>
                    <input type="email" id="editCustomerEmail" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="editCustomerPhone">Phone Number</label>
                    <input type="text" id="editCustomerPhone" name="phone">
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-outline" onclick="closeModal('editCustomerModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Update Customer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Customer Modal -->
<div id="viewCustomerModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Customer Details</h3>
            <button class="modal-close" onclick="closeModal('viewCustomerModal')">&times;</button>
        </div>
        <div class="modal-body" id="customerDetails">
            <!-- Customer details will be loaded here -->
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteCustomerModal" class="modal">
    <div class="modal-content small">
        <div class="modal-header">
            <h3>Delete Customer</h3>
            <button class="modal-close" onclick="closeModal('deleteCustomerModal')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="delete-warning">
                <div class="warning-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="warning-content">
                    <h4>Are you sure?</h4>
                    <p>This will permanently delete the customer "<span id="deleteCustomerName"></span>" and all associated data.</p>
                    <p><strong>This action cannot be undone!</strong></p>
                </div>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-outline" onclick="closeModal('deleteCustomerModal')">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                    <i class="fas fa-trash"></i>
                    Yes, Delete Customer
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('styles')
<style>
    /* Alert Messages */
    .alert {
        padding: 1rem 1.25rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 500;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        color: #065f46;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.1);
        color: #991b1b;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    /* Page Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .header-left h1 {
        font-size: 1.8rem;
        color: #1f2937;
        margin: 0 0 0.25rem 0;
        font-weight: 600;
    }

    .header-left p {
        color: #6b7280;
        margin: 0;
        font-size: 0.9rem;
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
        background: #3b82f6;
        color: white;
    }

    .btn-primary:hover {
        background: #2563eb;
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    .btn-outline {
        background: transparent;
        border: 1px solid #d1d5db;
        color: #374151;
    }

    .btn-outline:hover {
        background: #f9fafb;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    /* Stats Cards */
    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .stat-card.active { border-left: 4px solid #10b981; }
    .stat-card.blocked { border-left: 4px solid #ef4444; }
    .stat-card.new { border-left: 4px solid #3b82f6; }
    .stat-card.orders { border-left: 4px solid #8b5cf6; }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
    }

    .stat-label {
        font-size: 0.8rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    .stat-icon {
        font-size: 1.5rem;
        opacity: 0.3;
    }

    .stat-card.active .stat-icon { color: #10b981; }
    .stat-card.blocked .stat-icon { color: #ef4444; }
    .stat-card.new .stat-icon { color: #3b82f6; }
    .stat-card.orders .stat-icon { color: #8b5cf6; }

    /* Search Section */
    .search-section {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        align-items: center;
    }

    .search-box {
        flex: 1;
        position: relative;
    }

    .search-box i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }

    .search-box input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.5rem;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 0.875rem;
        outline: none;
        transition: all 0.2s ease;
    }

    .search-box input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .filter-select {
        padding: 0.75rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 0.875rem;
        background: white;
        min-width: 150px;
        outline: none;
    }

    /* Customers Table */
    .customers-table {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .table-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f9fafb;
    }

    .table-header h3 {
        margin: 0;
        font-size: 1.1rem;
        color: #1f2937;
        font-weight: 600;
    }

    .customer-count {
        font-size: 0.875rem;
        color: #6b7280;
    }

    .table-container {
        overflow-x: auto;
    }

    .simple-table {
        width: 100%;
        border-collapse: collapse;
    }

    .simple-table th {
        background: #f9fafb;
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: #374151;
        font-size: 0.875rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .simple-table td {
        padding: 1rem;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }

    .simple-table tbody tr:hover {
        background: #f9fafb;
    }

    /* Customer Info */
    .customer-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .customer-avatar {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: #10b981;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
    }

    .customer-name {
        font-weight: 600;
        color: #1f2937;
        font-size: 0.875rem;
    }

    .customer-id {
        font-size: 0.75rem;
        color: #6b7280;
    }

    /* Contact Info */
    .contact-info {
        font-size: 0.8rem;
        color: #4b5563;
        line-height: 1.4;
    }

    /* Order Count */
    .order-count {
        background: #dbeafe;
        color: #1e40af;
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

    .status-badge.active {
        background: #d1fae5;
        color: #065f46;
    }

    .status-badge.inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    /* Dropdown Actions */
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
        font-size: 14px;
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

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }

    .modal-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        border-radius: 8px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        max-width: 600px;
        width: 90%;
        max-height: 80vh;
        overflow-y: auto;
    }

    .modal-content.small {
        max-width: 400px;
    }

    .modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.25rem;
        color: #1f2937;
        font-weight: 600;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #6b7280;
        cursor: pointer;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
    }

    .modal-close:hover {
        background: #f3f4f6;
        color: #374151;
    }

    .modal-body {
        padding: 1.5rem;
    }

    /* Form Styles */
    .customer-form {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-group label {
        font-weight: 600;
        color: #374151;
        font-size: 0.875rem;
    }

    .form-group input,
    .form-group select {
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 0.875rem;
        outline: none;
        transition: all 0.2s ease;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-group small {
        font-size: 0.75rem;
        color: #6b7280;
    }

    .form-actions {
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }

    /* Delete Warning */
    .delete-warning {
        display: flex;
        gap: 1rem;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }

    .warning-icon {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .warning-content h4 {
        font-size: 1rem;
        font-weight: 600;
        color: #1f2937;
        margin: 0 0 0.5rem 0;
    }

    .warning-content p {
        font-size: 0.875rem;
        color: #6b7280;
        margin: 0 0 0.5rem 0;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: #6b7280;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        background: #f3f4f6;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #9ca3af;
    }

    .empty-state h4 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        font-size: 1rem;
        margin-bottom: 1.5rem;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Customer Details */
    .customer-detail-grid {
        margin-bottom: 2rem;
    }

    .detail-section h4 {
        font-size: 1rem;
        font-weight: 600;
        color: #1f2937;
        margin: 0 0 1rem 0;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .detail-item:last-child {
        border-bottom: none;
    }

    .detail-item label {
        font-weight: 500;
        color: #6b7280;
        min-width: 120px;
    }

    .detail-item span {
        color: #1f2937;
        text-align: right;
    }

    .modal-actions {
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .stats-cards {
            grid-template-columns: repeat(2, 1fr);
        }

        .search-section {
            flex-direction: column;
        }

        .action-buttons {
            flex-direction: column;
        }

        .simple-table {
            font-size: 0.8rem;
        }

        .simple-table th,
        .simple-table td {
            padding: 0.5rem;
        }

        .modal-content {
            width: 95%;
            margin: 1rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .delete-warning {
            flex-direction: column;
            text-align: center;
        }

        .detail-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }

        .detail-item label {
            min-width: auto;
        }

        .detail-item span {
            text-align: left;
        }

        .modal-actions {
            flex-direction: column;
        }
    }

    @media (max-width: 480px) {
        .stats-cards {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
@section('scripts')
<script>
    // Dropdown functionality
    function toggleDropdown(customerId) {
        // Close all other dropdowns
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            if (menu.id !== `dropdown-${customerId}`) {
                menu.classList.remove('show');
            }
        });
        
        // Toggle current dropdown
        const dropdown = document.getElementById(`dropdown-${customerId}`);
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

    // Customers data from Laravel
    const customers = @json($customers);
    let currentCustomerId = null;

    // Wait for page to load
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Customers page loaded with', customers.length, 'customers');
        
        // Setup search functionality
        setupSearch();
        
        // Setup form submissions
        setupForms();
        
        // Auto-hide alerts
        hideAlertsAfterDelay();
    });

    // SEARCH AND FILTER FUNCTIONS
    function setupSearch() {
        const searchInput = document.getElementById('customerSearch');
        const statusFilter = document.getElementById('statusFilter');
        
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                filterTable();
            });
        }
        
        if (statusFilter) {
            statusFilter.addEventListener('change', function() {
                filterTable();
            });
        }
    }

    function filterTable() {
        const searchTerm = document.getElementById('customerSearch').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
        const rows = document.querySelectorAll('#customersTable tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const statusBadge = row.querySelector('.status-badge');
            const status = statusBadge ? statusBadge.textContent.toLowerCase() : '';
            
            let showRow = true;
            
            // Search filter
            if (searchTerm && !text.includes(searchTerm)) {
                showRow = false;
            }
            
            // Status filter
            if (statusFilter && !status.includes(statusFilter)) {
                showRow = false;
            }
            
            row.style.display = showRow ? '' : 'none';
        });
    }

    function resetFilters() {
        document.getElementById('customerSearch').value = '';
        document.getElementById('statusFilter').value = '';
        filterTable();
    }

    // MODAL FUNCTIONS
    function showAddForm() {
        const modal = document.getElementById('addCustomerModal');
        const form = document.getElementById('addCustomerForm');
        
        if (form) {
            form.reset();
        }
        
        if (modal) {
            modal.style.display = 'block';
        }
    }

    function viewCustomer(id) {
        const customer = customers.find(c => c.id == id);
        if (!customer) {
            alert('Customer not found!');
            return;
        }
        
        const detailsHtml = `
            <div class="customer-detail-grid">
                <div class="detail-section">
                    <h4>Customer Information</h4>
                    <div class="detail-item">
                        <label>Customer Name:</label>
                        <span>${customer.name}</span>
                    </div>
                    <div class="detail-item">
                        <label>Customer ID:</label>
                        <span>#CUST${String(customer.id).padStart(3, '0')}</span>
                    </div>
                    <div class="detail-item">
                        <label>Email Address:</label>
                        <span>${customer.email}</span>
                    </div>
                    <div class="detail-item">
                        <label>Phone Number:</label>
                        <span>${customer.phone || 'Not provided'}</span>
                    </div>
                    <div class="detail-item">
                        <label>Orders Count:</label>
                        <span>${customer.orders_count || 0}</span>
                    </div>
                    <div class="detail-item">
                        <label>Status:</label>
                        <span class="status-badge active">Active</span>
                    </div>
                    <div class="detail-item">
                        <label>Joined Date:</label>
                        <span>${new Date(customer.created_at).toLocaleDateString()}</span>
                    </div>
                </div>
            </div>
            <div class="modal-actions">
                <button class="btn btn-primary" onclick="editCustomer(${id})">Edit Customer</button>
                <button class="btn btn-outline" onclick="closeModal('viewCustomerModal')">Close</button>
            </div>
        `;
        
        document.getElementById('customerDetails').innerHTML = detailsHtml;
        document.getElementById('viewCustomerModal').style.display = 'block';
    }

    function editCustomer(id) {
        const customer = customers.find(c => c.id == id);
        if (!customer) {
            alert('Customer not found!');
            return;
        }
        
        currentCustomerId = id;
        
        // Close view modal if open
        closeModal('viewCustomerModal');
        
        // Fill form with current data
        document.getElementById('editCustomerName').value = customer.name;
        document.getElementById('editCustomerEmail').value = customer.email;
        document.getElementById('editCustomerPhone').value = customer.phone || '';
        
        // Set form action
        const form = document.getElementById('editCustomerForm');
        form.action = `/admin/customer/update/${id}`;
        
        // Show modal
        document.getElementById('editCustomerModal').style.display = 'block';
    }

    function deleteCustomer(id) {
        const customer = customers.find(c => c.id == id);
        if (!customer) {
            alert('Customer not found!');
            return;
        }
        
        currentCustomerId = id;
        document.getElementById('deleteCustomerName').textContent = customer.name;
        document.getElementById('deleteCustomerModal').style.display = 'block';
    }

    function confirmDelete() {
        if (!currentCustomerId) return;
        
        // Create and submit delete form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/customer/delete/${currentCustomerId}`;
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.appendChild(csrfToken);
        
        // Add method override
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);
        
        // Submit form
        document.body.appendChild(form);
        form.submit();
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
        }
        currentCustomerId = null;
    }

    // FORM SETUP
    function setupForms() {
        // Add form submission
        const addForm = document.getElementById('addCustomerForm');
        if (addForm) {
            addForm.addEventListener('submit', function(e) {
                // Let the form submit normally to Laravel
                showLoadingMessage('Adding customer...');
            });
        }
        
        // Edit form submission
        const editForm = document.getElementById('editCustomerForm');
        if (editForm) {
            editForm.addEventListener('submit', function(e) {
                // Let the form submit normally to Laravel
                showLoadingMessage('Updating customer...');
            });
        }
    }

    // UTILITY FUNCTIONS
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
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 3000);
    }

    function showLoadingMessage(message) {
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #3b82f6;
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 9999;
            font-weight: 500;
        `;
        notification.textContent = message;
        document.body.appendChild(notification);
    }

    function hideAlertsAfterDelay() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 300);
            }, 5000);
        });
    }

    // Close modals when clicking outside
    window.addEventListener('click', function(e) {
        const modals = ['addCustomerModal', 'editCustomerModal', 'viewCustomerModal', 'deleteCustomerModal'];
        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (modal && e.target === modal) {
                closeModal(modalId);
            }
        });
    });

    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modals = ['addCustomerModal', 'editCustomerModal', 'viewCustomerModal', 'deleteCustomerModal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (modal && modal.style.display === 'block') {
                    closeModal(modalId);
                }
            });
        }
    });
</script>
@endsection