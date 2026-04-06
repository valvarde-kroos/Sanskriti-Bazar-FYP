<nav class="famms-navbar">
    <div class="navbar-container">
        <!-- Logo -->
        <div class="navbar-logo">
            <a href="{{ route('home') }}" class="logo-link">
                <span class="logo-text">Sanskriti Bazar</span>
            </a>
        </div>

        <!-- Main Navigation -->
        <div class="navbar-menu" id="navbarMenu">
            <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">HOME</a>
            <a href="{{ route('shop.index') }}" class="nav-item {{ request()->routeIs('shop.*') ? 'active' : '' }}">SHOPS</a>
            <a href="#about" class="nav-item">ABOUT US</a>
            <a href="{{ route('contact') }}" class="nav-item {{ request()->routeIs('contact') ? 'active' : '' }}">CONTACT</a>
        </div>

        <!-- Right Side Icons -->
        <div class="navbar-actions">
            <!-- Wishlist Icon -->
            @auth
                @if(!auth()->user()->isAdmin())
                <a href="{{ route('customer.wishlist') }}" class="action-icon wishlist-icon">
                    <svg width="20" height="20" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                    <span class="wishlist-count">0</span>
                </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="action-icon wishlist-icon">
                    <svg width="20" height="20" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                    <span class="wishlist-count">0</span>
                </a>
            @endauth

            <!-- Cart Icon -->
            @auth
                @if(!auth()->user()->isAdmin())
                <a href="{{ route('cart') }}" class="action-icon cart-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                    </svg>
                    <span class="cart-count">0</span>
                </a>
                @endif
            @else
                <a href="{{ route('cart') }}" class="action-icon cart-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                    </svg>
                    <span class="cart-count">0</span>
                </a>
            @endauth

            <!-- Authentication -->
            @auth
                <div class="user-dropdown">
                    <button class="user-btn" onclick="toggleUserMenu()">
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div class="user-menu" id="userMenu">
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="menu-item">Admin Dashboard</a>
                        @elseif(auth()->user()->isVendor())
                            <a href="{{ route('vendor.dashboard') }}" class="menu-item">Vendor Dashboard</a>
                        @else
                            <a href="{{ route('customer.dashboard') }}" class="menu-item">My Dashboard</a>
                        @endif
                        <a href="{{ route('profile') }}" class="menu-item">Profile</a>
                        <div class="menu-divider"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="menu-item logout-item">Logout</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="auth-btn login-btn">LOGIN</a>
                <a href="{{ route('signup') }}" class="auth-btn signup-btn">SIGN UP</a>
            @endauth

            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>
        </div>
    </div>
</nav>

<script>
    // Toggle user menu
    function toggleUserMenu() {
        const userMenu = document.getElementById('userMenu');
        userMenu.classList.toggle('show');
    }

    // Toggle mobile menu
    function toggleMobileMenu() {
        const navbarMenu = document.getElementById('navbarMenu');
        navbarMenu.classList.toggle('show');
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        const userDropdown = document.querySelector('.user-dropdown');
        const userMenu = document.getElementById('userMenu');

        // Close user menu if clicking outside
        if (userDropdown && !userDropdown.contains(event.target)) {
            userMenu.classList.remove('show');
        }
    });

    // Load cart and wishlist counts on page load
    document.addEventListener('DOMContentLoaded', function() {
        @auth
            @if(!auth()->user()->isAdmin())
                loadCartCount();
                loadWishlistCount();
            @endif
        @endauth
    });

    // Load cart count function
    function loadCartCount() {
        fetch('/cart/count')
            .then(response => response.json())
            .then(data => {
                const cartCountElements = document.querySelectorAll('.cart-count');
                cartCountElements.forEach(element => {
                    element.textContent = data.count || 0;
                });
            })
            .catch(error => {
                console.error('Error loading cart count:', error);
            });
    }

    // Load wishlist count function
    function loadWishlistCount() {
        fetch('/customer/wishlist/count')
            .then(response => response.json())
            .then(data => {
                const wishlistCountElements = document.querySelectorAll('.wishlist-count');
                wishlistCountElements.forEach(element => {
                    element.textContent = data.count || 0;
                });
            })
            .catch(error => {
                console.error('Error loading wishlist count:', error);
                // Fallback to 0 if there's an error
                const wishlistCountElements = document.querySelectorAll('.wishlist-count');
                wishlistCountElements.forEach(element => {
                    element.textContent = '0';
                });
            });
    }

    // Make loadWishlistCount globally available
    window.loadWishlistCount = loadWishlistCount;
</script>