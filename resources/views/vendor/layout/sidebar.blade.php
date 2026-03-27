<aside class="vendor-sidebar" id="vendorSidebar">
    <div class="sidebar-header">
        <h2>Sanskriti Bazar</h2>
        <p class="sidebar-subtitle">VENDOR PANEL</p>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav-list">
            <li class="nav-item {{ request()->routeIs('vendor.dashboard') ? 'active' : '' }}">
                <a href="{{ route('vendor.dashboard') }}" class="nav-link">Dashboard</a>
            </li>
            <li class="nav-item {{ request()->routeIs('vendor.products') ? 'active' : '' }}">
                <a href="{{ route('vendor.products') }}" class="nav-link">Products</a>
            </li>
            <li class="nav-item {{ request()->routeIs('vendor.orders') ? 'active' : '' }}">
                <a href="{{ route('vendor.orders') }}" class="nav-link">Orders</a>
            </li>
            <li class="nav-item {{ request()->routeIs('vendor.sales') ? 'active' : '' }}">
                <a href="{{ route('vendor.sales') }}" class="nav-link">Sales</a>
            </li>
            <li class="nav-item {{ request()->routeIs('vendor.reviews') ? 'active' : '' }}">
                <a href="{{ route('vendor.reviews') }}" class="nav-link">Reviews</a>
            </li>
            <li class="nav-item {{ request()->routeIs('vendor.settings') ? 'active' : '' }}">
                <a href="{{ route('vendor.settings') }}" class="nav-link">Settings</a>
            </li>
            <li class="nav-item logout-item">
                <form action="{{ route('logout') }}" method="POST" id="vendorLogoutForm" style="margin: 0;">
                    @csrf
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('vendorLogoutForm').submit();">Logout</a>
                </form>
            </li>
        </ul>
    </nav>
</aside>

<style>
    .vendor-sidebar {
        position: fixed;
        left: 0;
        top: 0;
        width: 220px;
        height: 100vh;
        background: #34495e;
        color: #fff;
        z-index: 1000;
        overflow-y: auto;
    }

    .sidebar-header {
        padding: 25px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        text-align: center;
    }

    .sidebar-header h2 {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 5px;
    }

    .sidebar-subtitle {
        font-size: 11px;
        color: #95a5a6;
        font-weight: 600;
        letter-spacing: 1px;
    }

    .sidebar-nav {
        padding: 20px 0;
    }

    .nav-list {
        list-style: none;
    }

    .nav-item {
        margin: 3px 12px;
    }

    .nav-link {
        display: block;
        padding: 12px 15px;
        color: #bdc3c7;
        text-decoration: none;
        border-radius: 6px;
        transition: all 0.3s;
        font-size: 14px;
    }

    .nav-link:hover {
        background: rgba(52, 152, 219, 0.2);
        color: #3498db;
    }

    .nav-item.active .nav-link {
        background: #3498db;
        color: #fff;
    }

    .logout-item {
        margin-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 15px;
    }

    @media (max-width: 768px) {
        .vendor-sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s;
        }

        .vendor-sidebar.mobile-open {
            transform: translateX(0);
        }
    }
</style>
