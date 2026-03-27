<aside class="sidebar" id="sidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <div class="logo">
            <i class="fas fa-shopping-bag"></i>
            <span class="logo-text">Sanskriti Bazar Admin</span>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="sidebar-nav">
        <ul class="nav-list">
            <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="fas fa-chart-pie"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            
            <li class="nav-item {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                <a href="{{ route('admin.categories') }}" class="nav-link">
                    <i class="fas fa-tags"></i>
                    <span class="nav-text">Categories</span>
                </a>
            </li>
            
            <li class="nav-item {{ request()->routeIs('admin.vendors*') ? 'active' : '' }}">
                <a href="{{ route('admin.vendors') }}" class="nav-link">
                    <i class="fas fa-store"></i>
                    <span class="nav-text">Vendors</span>
                </a>
            </li>
            
            <li class="nav-item {{ request()->routeIs('admin.customers*') ? 'active' : '' }}">
                <a href="{{ route('admin.customers') }}" class="nav-link">
                    <i class="fas fa-users"></i>
                    <span class="nav-text">Customers</span>
                </a>
            </li>
            
            <li class="nav-item {{ request()->routeIs('admin.reviews*') ? 'active' : '' }}">
                <a href="{{ route('admin.reviews') }}" class="nav-link">
                    <i class="fas fa-star"></i>
                    <span class="nav-text">Reviews</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST" id="logoutForm">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span class="nav-text">Logout</span>
            </button>
        </form>
    </div>
</aside>

<style>
    .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        width: var(--sidebar-width);
        height: 100vh;
        background: var(--white);
        border-right: 1px solid var(--gray-200);
        z-index: 1000;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    /* Sidebar Header */
    .sidebar-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--gray-200);
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--gray-800);
    }

    .logo i {
        width: 32px;
        height: 32px;
        background: var(--primary-color);
        color: white;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    /* Navigation */
    .sidebar-nav {
        flex: 1;
        padding: 1rem 0;
        overflow-y: auto;
    }

    .nav-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .nav-item {
        margin: 0.25rem 1rem;
    }

    .nav-link {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        color: var(--gray-600);
        text-decoration: none;
        border-radius: 6px;
        transition: all 0.2s ease;
        font-size: 0.875rem;
        font-weight: 500;
        gap: 0.75rem;
    }

    .nav-link:hover {
        background: var(--gray-50);
        color: var(--gray-800);
    }

    .nav-item.active .nav-link {
        background: var(--primary-color);
        color: white;
    }

    .nav-link i {
        width: 20px;
        text-align: center;
        flex-shrink: 0;
    }

    /* Sidebar Footer */
    .sidebar-footer {
        padding: 1rem;
        border-top: 1px solid var(--gray-200);
    }

    .logout-btn {
        width: 100%;
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        background: none;
        border: none;
        color: var(--gray-600);
        border-radius: 6px;
        transition: all 0.2s ease;
        font-size: 0.875rem;
        font-weight: 500;
        gap: 0.75rem;
        cursor: pointer;
    }

    .logout-btn:hover {
        background: var(--danger-color);
        color: white;
    }

    .logout-btn i {
        width: 20px;
        text-align: center;
    }

    /* Mobile Responsive */
    @media (max-width: 1024px) {
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .sidebar.mobile-open {
            transform: translateX(0);
        }
    }
</style>
