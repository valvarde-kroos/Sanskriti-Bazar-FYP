@extends('admin.layout.main')

@section('title', 'User & Role Management')

@section('content')
<div class="page-header">
    <h1 class="page-title">User & Role Management</h1>
    <p class="page-subtitle">Manage user roles and permissions</p>
</div>

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

<div class="card">
    <div class="card-header">
        <div>
            <h3>All Users</h3>
            <p>Total: {{ $users->count() }} users</p>
        </div>
        <div class="stats-row">
            <div class="stat-item">
                <span class="stat-label">Admins:</span>
                <span class="stat-value">{{ $users->where('role', 'admin')->count() }}</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Vendors:</span>
                <span class="stat-value">{{ $users->where('role', 'vendor')->count() }}</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Customers:</span>
                <span class="stat-value">{{ $users->where('role', 'customer')->count() }}</span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Current Role</th>
                        <th>Status</th>
                        <th>Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar {{ $user->role }}">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <span class="user-name">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? 'N/A' }}</td>
                            <td>
                                <span class="role-badge role-{{ $user->role }}">
                                    @if($user->role === 'admin')
                                        <i class="fas fa-user-shield"></i>
                                    @elseif($user->role === 'vendor')
                                        <i class="fas fa-store"></i>
                                    @else
                                        <i class="fas fa-user"></i>
                                    @endif
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                @if($user->is_active)
                                    <span class="status-badge status-active">
                                        <i class="fas fa-check-circle"></i> Active
                                    </span>
                                @else
                                    <span class="status-badge status-inactive">
                                        <i class="fas fa-times-circle"></i> Inactive
                                    </span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="dropdown-container">
                                    <button class="dropdown-toggle" onclick="toggleDropdown({{ $user->id }})">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu" id="dropdown-{{ $user->id }}">
                                        <button class="dropdown-item" onclick="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->role }}')">
                                            <i class="fas fa-edit"></i> Change Role
                                        </button>
                                        @if($user->id !== auth()->id())
                                            @if($user->is_active)
                                                <form action="{{ route('admin.user.toggle.status', $user->id) }}" method="POST" style="margin: 0;">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item" onclick="return confirm('Deactivate this user account?')">
                                                        <i class="fas fa-ban"></i> Deactivate
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.user.toggle.status', $user->id) }}" method="POST" style="margin: 0;">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item" style="color: #10b981;" onclick="return confirm('Activate this user account?')">
                                                        <i class="fas fa-check"></i> Activate
                                                    </button>
                                                </form>
                                            @endif
                                            <button class="dropdown-item danger" onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')">
                                                <i class="fas fa-trash"></i> Delete User
                                            </button>
                                        @else
                                            <div class="dropdown-item disabled" style="color: #9ca3af; cursor: not-allowed;">
                                                <i class="fas fa-info-circle"></i> Cannot modify own account
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Edit Role Modal -->
<div id="editRoleModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Change User Role</h3>
            <button class="modal-close" onclick="closeEditModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="editRoleForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <p class="modal-description">Change role for: <strong id="userName"></strong></p>
                
                <div class="form-group">
                    <label for="role">Select New Role</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="customer">Customer</option>
                        <option value="vendor">Vendor</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Warning:</strong> Changing user role will affect their access permissions immediately.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete User Confirmation Modal -->
<div id="deleteUserModal" class="modal">
    <div class="modal-content" style="max-width: 500px;">
        <div class="modal-header">
            <h3>Delete User</h3>
            <button class="modal-close" onclick="closeDeleteModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="deleteUserForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        <strong>Warning:</strong> This action cannot be undone!
                    </div>
                </div>
                
                <p style="margin: 20px 0; color: #374151;">
                    Are you sure you want to delete user <strong id="deleteUserName"></strong>?
                </p>
                
                <p style="margin: 10px 0; color: #6b7280; font-size: 14px;">
                    This will permanently delete:
                </p>
                <ul style="margin: 10px 0; padding-left: 20px; color: #6b7280; font-size: 14px;">
                    <li>User account and profile</li>
                    <li>All associated data</li>
                    <li>Order history (if customer)</li>
                    <li>Products (if vendor)</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i>
                    Yes, Delete User
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .page-header {
        margin-bottom: 30px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 8px;
    }

    .page-subtitle {
        color: #6b7280;
        font-size: 14px;
    }

    .alert {
        padding: 16px 20px;
        border-radius: 8px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #6ee7b7;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }

    .alert-warning {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fcd34d;
    }

    .card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .card-header {
        padding: 24px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header h3 {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .card-header p {
        color: #6b7280;
        font-size: 14px;
        margin: 0;
    }

    .stats-row {
        display: flex;
        gap: 24px;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .stat-label {
        font-size: 14px;
        color: #6b7280;
    }

    .stat-value {
        font-size: 18px;
        font-weight: 600;
        color: #667eea;
    }

    .card-body {
        padding: 24px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead {
        background: #f9fafb;
    }

    .data-table th {
        padding: 12px 16px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .data-table td {
        padding: 16px;
        border-top: 1px solid #e5e7eb;
        font-size: 14px;
        color: #374151;
    }

    .data-table tbody tr:hover {
        background: #f9fafb;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 16px;
    }

    .user-avatar.admin {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .user-avatar.vendor {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .user-avatar.customer {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .user-name {
        font-weight: 500;
        color: #1f2937;
    }

    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .role-admin {
        background: #ede9fe;
        color: #6d28d9;
    }

    .role-vendor {
        background: #fef3c7;
        color: #92400e;
    }

    .role-customer {
        background: #d1fae5;
        color: #065f46;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-active {
        background: #d1fae5;
        color: #065f46;
    }

    .status-inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    .btn {
        padding: 8px 16px;
        border-radius: 6px;
        border: none;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 12px;
    }

    .btn-primary {
        background: #667eea;
        color: white;
    }

    .btn-primary:hover {
        background: #5a67d8;
    }

    .btn-secondary {
        background: #e5e7eb;
        color: #374151;
    }

    .btn-secondary:hover {
        background: #d1d5db;
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
        min-width: 150px;
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
        padding: 10px 14px;
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

    .dropdown-item.disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .dropdown-item.disabled:hover {
        background: none;
        color: #9ca3af;
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
        align-items: center;
        justify-content: center;
    }

    .modal.show {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 12px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        padding: 24px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        margin: 0;
    }

    .modal-close {
        background: none;
        border: none;
        color: #9ca3af;
        font-size: 20px;
        cursor: pointer;
        padding: 4px;
        transition: color 0.3s ease;
    }

    .modal-close:hover {
        color: #374151;
    }

    .modal-body {
        padding: 24px;
    }

    .modal-description {
        color: #6b7280;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .modal-footer {
        padding: 16px 24px;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }
</style>

<script>
    // Dropdown functionality
    function toggleDropdown(userId) {
        // Close all other dropdowns
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            if (menu.id !== `dropdown-${userId}`) {
                menu.classList.remove('show');
            }
        });
        
        // Toggle current dropdown
        const dropdown = document.getElementById(`dropdown-${userId}`);
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

    function openEditModal(userId, userName, currentRole) {
        const modal = document.getElementById('editRoleModal');
        const form = document.getElementById('editRoleForm');
        const userNameSpan = document.getElementById('userName');
        const roleSelect = document.getElementById('role');
        
        // Set form action
        form.action = `/admin/user/${userId}/role`;
        
        // Set user name
        userNameSpan.textContent = userName;
        
        // Set current role
        roleSelect.value = currentRole;
        
        // Show modal
        modal.classList.add('show');
    }

    function closeEditModal() {
        const modal = document.getElementById('editRoleModal');
        modal.classList.remove('show');
    }

    function deleteUser(userId, userName) {
        const modal = document.getElementById('deleteUserModal');
        const form = document.getElementById('deleteUserForm');
        const userNameSpan = document.getElementById('deleteUserName');
        
        // Set form action
        form.action = `/admin/user/${userId}/delete`;
        
        // Set user name
        userNameSpan.textContent = userName;
        
        // Show modal
        modal.classList.add('show');
        
        // Close dropdown
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.classList.remove('show');
        });
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteUserModal');
        modal.classList.remove('show');
    }

    // Close modal when clicking outside
    document.getElementById('editRoleModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditModal();
        }
    });

    document.getElementById('deleteUserModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
</script>
@endsection
