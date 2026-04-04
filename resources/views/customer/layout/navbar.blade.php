<nav class="customer-navbar">
    <div class="navbar-left">
        <button class="mobile-menu-btn" id="mobileMenuBtn">☰</button>
        <h1 class="navbar-title">Sanskriti Bazar Customer Panel</h1>
    </div>

    <div class="navbar-center">
        <div class="search-container">
            <input type="text" class="search-input" placeholder="Search products, orders...">
        </div>
    </div>

    <div class="navbar-right">
        <div class="customer-profile" onclick="toggleProfileDropdown()">
            <span class="customer-name">{{ Auth::user()->name ?? 'Customer' }}</span>
            <span class="dropdown-arrow">▼</span>
            
            <div class="profile-dropdown" id="profileDropdown">
                <a href="{{ route('customer.profile') }}" class="dropdown-item">Profile</a>
                <a href="{{ route('customer.orders') }}" class="dropdown-item">My Orders</a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="dropdown-item logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<style>
    .customer-navbar {
        background: #fff;
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        border-bottom: 1px solid #e0e0e0;
    }

    .navbar-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .mobile-menu-btn {
        display: none;
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #2c3e50;
        padding: 5px 10px;
    }

    .navbar-title {
        font-size: 18px;
        font-weight: 700;
        color: #2c3e50;
    }

    .navbar-center {
        flex: 1;
        max-width: 500px;
        margin: 0 30px;
    }

    .search-container {
        width: 100%;
    }

    .search-input {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        outline: none;
        transition: border-color 0.3s;
    }

    .search-input:focus {
        border-color: #3498db;
    }

    .navbar-right {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .customer-profile {
        position: relative;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .customer-profile:hover {
        background: #f8f9fa;
        border-color: #3498db;
    }

    .customer-name {
        font-size: 14px;
        font-weight: 600;
        color: #2c3e50;
    }

    .dropdown-arrow {
        font-size: 10px;
        color: #95a5a6;
    }

    .profile-dropdown {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        margin-top: 10px;
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        min-width: 160px;
        z-index: 1000;
    }

    .profile-dropdown.show {
        display: block;
    }

    .dropdown-item {
        display: block;
        padding: 12px 16px;
        color: #2c3e50;
        text-decoration: none;
        font-size: 14px;
        transition: background 0.3s;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
    }

    .dropdown-item:hover {
        background: #f8f9fa;
        text-decoration: none;
        color: #2c3e50;
    }

    .dropdown-divider {
        height: 1px;
        background: #e0e0e0;
        margin: 5px 0;
    }

    .logout-btn {
        color: #3498db;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .customer-navbar {
            padding: 15px;
        }

        .mobile-menu-btn {
            display: block;
        }

        .navbar-title {
            font-size: 16px;
        }

        .navbar-center {
            display: none;
        }
    }
</style>

<script>
    function toggleProfileDropdown() {
        const dropdown = document.getElementById('profileDropdown');
        dropdown.classList.toggle('show');
    }

    window.addEventListener('click', function(e) {
        if (!e.target.closest('.customer-profile')) {
            const dropdown = document.getElementById('profileDropdown');
            if (dropdown) dropdown.classList.remove('show');
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebar = document.getElementById('customerSidebar');

        if (mobileMenuBtn && sidebar) {
            mobileMenuBtn.addEventListener('click', function() {
                sidebar.classList.toggle('mobile-open');
            });
        }
    });
</script>