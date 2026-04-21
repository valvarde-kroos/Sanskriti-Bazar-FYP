<aside class="admin-sidebar" id="adminSidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <div class="brand-container">
            <div class="brand-icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div class="brand-text">
                <h2>Sanskriti Bazar</h2>
                <p class="sidebar-subtitle">Admin</p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="sidebar-nav">
        <ul class="nav-list">
            <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="fas fa-chart-pie nav-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            
            <li class="nav-item {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                <a href="{{ route('admin.categories') }}" class="nav-link">
                    <i class="fas fa-tags nav-icon"></i>
                    <span class="nav-text">Categories</span>
                </a>
            </li>
            
            <li class="nav-item {{ request()->routeIs('admin.vendors*') ? 'active' : '' }}">
                <a href="{{ route('admin.vendors') }}" class="nav-link">
                    <i class="fas fa-store nav-icon"></i>
                    <span class="nav-text">Vendors</span>
                </a>
            </li>
            
            <li class="nav-item {{ request()->routeIs('admin.customers*') ? 'active' : '' }}">
                <a href="{{ route('admin.customers') }}" class="nav-link">
                    <i class="fas fa-users nav-icon"></i>
                    <span class="nav-text">Customers</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('admin.user.role.management') ? 'active' : '' }}">
                <a href="{{ route('admin.user.role.management') }}" class="nav-link">
                    <i class="fas fa-user-cog nav-icon"></i>
                    <span class="nav-text">User & Role</span>
                </a>
            </li>
        </ul>
        
        <div class="sidebar-footer">
            <div class="nav-item logout-item">
                <form action="{{ route('logout') }}" method="POST" id="adminLogoutForm" style="margin: 0;">
                    @csrf
                    <a href="#" class="nav-link logout-link" onclick="event.preventDefault(); document.getElementById('adminLogoutForm').submit();">
                        <i class="fas fa-sign-out-alt nav-icon"></i>
                        <span class="nav-text">Logout</span>
                    </a>
                </form>
            </div>
        </div>
    </nav>
</aside>

<style>
    .admin-sidebar {
        position: fixed;
        left: 0;
        top: 0;
        width: 280px;
        height: 100vh;
        background: #ffffff;
        border-right: 1px solid #e5e7eb;
        z-index: 1000;
        overflow-y: auto;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        animation: slideInLeft 0.3s ease-out;
    }

    @keyframes slideInLeft {
        from {
            transform: translateX(-100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .sidebar-header {
        padding: 24px 20px;
        border-bottom: 1px solid #f3f4f6;
        background: #f8fafc;
    }

    .brand-container {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .brand-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
        flex-shrink: 0;
    }

    .brand-text h2 {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 2px 0;
        line-height: 1.2;
    }

    .sidebar-subtitle {
        font-size: 12px;
        color: #6b7280;
        font-weight: 500;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .sidebar-nav {
        padding: 16px 0;
        display: flex;
        flex-direction: column;
        height: calc(100vh - 120px);
    }

    .nav-list {
        list-style: none;
        flex: 1;
        margin: 0;
        padding: 0;
    }

    .nav-item {
        margin: 2px 12px;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        color: #6b7280;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.2s ease;
        font-size: 14px;
        font-weight: 500;
        position: relative;
    }

    .nav-link:hover {
        background: #f3f4f6;
        color: #374151;
        transform: translateX(2px);
    }

    .nav-item.active .nav-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #ffffff;
        box-shadow: 0 2px 4px rgba(102, 126, 234, 0.3);
    }

    .nav-item.active .nav-link:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #ffffff;
        transform: translateX(0);
    }

    .nav-item.active .nav-link::before {
        content: '';
        position: absolute;
        left: -12px;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 24px;
        background: #667eea;
        border-radius: 0 2px 2px 0;
    }

    .nav-icon {
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .nav-text {
        flex: 1;
    }

    .sidebar-footer {
        margin-top: auto;
        padding: 16px 0;
        border-top: 1px solid #f3f4f6;
    }

    .logout-item {
        margin: 2px 12px;
    }

    .logout-link {
        color: #dc2626 !important;
    }

    .logout-link:hover {
        background: #fef2f2 !important;
        color: #b91c1c !important;
        transform: translateX(2px) !important;
    }

    /* Mobile Responsive */
    @media (max-width: 1024px) {
        .admin-sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            width: 280px;
            animation: none;
        }

        .admin-sidebar.mobile-open {
            transform: translateX(0);
            animation: slideInLeft 0.3s ease-out;
        }

        /* Overlay for mobile */
        .admin-sidebar.mobile-open::after {
            content: '';
            position: fixed;
            top: 0;
            left: 280px;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: -1;
            animation: fadeIn 0.3s ease-out;
        }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @media (max-width: 480px) {
        .admin-sidebar {
            width: 260px;
        }
        
        .brand-text h2 {
            font-size: 16px;
        }
        
        .nav-link {
            padding: 10px 14px;
            font-size: 13px;
        }
        
        .nav-icon {
            font-size: 14px;
        }
    }

    /* Scrollbar Styling */
    .admin-sidebar::-webkit-scrollbar {
        width: 4px;
    }

    .admin-sidebar::-webkit-scrollbar-track {
        background: #f1f5f9;
    }

    .admin-sidebar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 2px;
    }

    .admin-sidebar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
