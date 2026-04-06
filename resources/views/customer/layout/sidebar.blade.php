<aside class="customer-sidebar" id="customerSidebar">
    <div class="sidebar-header">
        <h2>Sanskriti Bazar</h2>
        <p class="sidebar-subtitle">CUSTOMER PANEL</p>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav-list">
            <li class="nav-item {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                <a href="{{ route('customer.dashboard') }}" class="nav-link">Dashboard</a>
            </li>
            <li class="nav-item {{ request()->routeIs('customer.orders') ? 'active' : '' }}">
                <a href="{{ route('customer.orders') }}" class="nav-link">My Orders</a>
            </li>
            <li class="nav-item {{ request()->routeIs('customer.wishlist') ? 'active' : '' }}">
                <a href="{{ route('customer.wishlist') }}" class="nav-link">My Wishlist</a>
            </li>
            <li class="nav-item {{ request()->routeIs('cart') ? 'active' : '' }}">
                <a href="{{ route('cart') }}" class="nav-link">Cart</a>
            </li>
            <li class="nav-item {{ request()->routeIs('customer.profile') ? 'active' : '' }}">
                <a href="{{ route('customer.profile') }}" class="nav-link">Profile</a>
            </li>
            <li class="nav-item {{ request()->routeIs('customer.reviews') ? 'active' : '' }}">
                <a href="{{ route('customer.reviews') }}" class="nav-link">Reviews</a>
            </li>
            <li class="nav-item logout-item">
                <form action="{{ route('logout') }}" method="POST" id="customerLogoutForm" style="margin: 0;">
                    @csrf
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('customerLogoutForm').submit();">Logout</a>
                </form>
            </li>
        </ul>
    </nav>
</aside>

<style>
    .customer-sidebar {
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
        color: #bdc3c7;
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
        background: rgba(93, 173, 226, 0.2);
        color: #5dade2;
        text-decoration: none;
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
        .customer-sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s;
        }

        .customer-sidebar.mobile-open {
            transform: translateX(0);
        }
    }
</style>