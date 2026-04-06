<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>About Us - Sanskriti Bazar</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: #333;
            background: #fafafa;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Navbar */
        .navbar {
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 0.8rem 0;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 2.5rem;
            align-items: center;
            margin: 0;
            padding: 0;
        }

        .nav-menu li {
            position: relative;
        }

        .nav-menu a {
            text-decoration: none;
            color: #4a5568;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.5rem 0;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .nav-menu a:hover,
        .nav-menu a.active {
            color: #e53e3e;
        }

        .nav-menu a.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            right: 0;
            height: 2px;
            background: #e53e3e;
            border-radius: 1px;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .search-icon {
            color: #718096;
            font-size: 1.2rem;
            cursor: pointer;
            transition: color 0.3s;
            padding: 0.5rem;
        }

        .search-icon:hover {
            color: #4a5568;
        }

        .cart-icon {
            position: relative;
            color: #718096;
            font-size: 1.2rem;
            cursor: pointer;
            transition: color 0.3s;
            padding: 0.5rem;
            text-decoration: none;
        }

        .cart-icon:hover {
            color: #4a5568;
        }

        .cart-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            background: #e53e3e;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .auth-buttons {
            display: flex;
            gap: 0.8rem;
            align-items: center;
        }

        .btn-login {
            background: transparent;
            color: #4a5568;
            border: 1.5px solid #e2e8f0;
            padding: 0.6rem 1.5rem;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-login:hover {
            background: #f7fafc;
            border-color: #cbd5e0;
            color: #2d3748;
        }

        .btn-signup {
            background: #e53e3e;
            color: white;
            border: 1.5px solid #e53e3e;
            padding: 0.6rem 1.5rem;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-signup:hover {
            background: #c53030;
            border-color: #c53030;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(229, 62, 62, 0.3);
        }

        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #4a5568;
            cursor: pointer;
            padding: 0.5rem;
        }

        /* Main Content */
        .main-content {
            margin-top: 100px;
            padding: 2rem 0;
        }

        .page-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 1rem;
        }

        .page-subtitle {
            text-align: center;
            font-size: 1.1rem;
            color: #7f8c8d;
            margin-bottom: 3rem;
        }

        .about-content {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        .about-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
            margin-bottom: 2rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .feature-card {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        .feature-icon {
            font-size: 3rem;
            color: #e53e3e;
            margin-bottom: 1rem;
        }

        .feature-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1rem;
        }

        .feature-description {
            color: #666;
            line-height: 1.6;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: block;
            }

            .nav-menu {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: #fff;
                flex-direction: column;
                padding: 1rem;
                box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            }

            .nav-menu.active {
                display: flex;
            }

            .page-title {
                font-size: 2rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="logo">Sanskriti Bazar</a>
            
            <ul class="nav-menu" id="navMenu">
                <li><a href="{{ route('home') }}">HOME</a></li>
                <li><a href="{{ route('shop.index') }}">SHOPS</a></li>
                <li><a href="#about" class="active">ABOUT US</a></li>
                <li><a href="#contact">CONTACT</a></li>
            </ul>
            
            <div class="nav-right">
                <div class="search-icon">
                    <i class="fas fa-search"></i>
                </div>
                
                <a href="{{ route('cart') }}" class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="cart-badge">{{ count(session('cart')) }}</span>
                    @else
                        <span class="cart-badge">0</span>
                    @endif
                </a>
                
                <div class="auth-buttons">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="btn-login">ADMIN</a>
                        @elseif(auth()->user()->role === 'vendor')
                            <a href="{{ route('vendor.dashboard') }}" class="btn-login">VENDOR</a>
                        @else
                            <a href="{{ route('customer.dashboard') }}" class="btn-login">ACCOUNT</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-signup">LOGOUT</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn-login">LOGIN</a>
                        <a href="{{ route('signup') }}" class="btn-signup">SIGN UP</a>
                    @endauth
                </div>
                
                <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <h1 class="page-title">About Sanskriti Bazar</h1>
            <p class="page-subtitle">Preserving Nepal's Rich Cultural Heritage</p>
            
            <div class="about-content">
                <p class="about-text">
                    Welcome to Sanskriti Bazar, your premier destination for authentic Nepali handicrafts, traditional musical instruments, and cultural treasures. We are dedicated to preserving and promoting Nepal's rich cultural heritage while supporting local artisans and vendors.
                </p>
                
                <p class="about-text">
                    Founded with a passion for Nepal's cultural heritage, Sanskriti Bazar began as a small initiative to connect traditional artisans with customers who appreciate authentic craftsmanship. Today, we serve as a bridge between skilled artisans from across Nepal and customers worldwide.
                </p>
                
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">🎵</div>
                        <h3 class="feature-title">Traditional Instruments</h3>
                        <p class="feature-description">Authentic Nepali musical instruments crafted by skilled artisans</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">🎨</div>
                        <h3 class="feature-title">Handcrafted Items</h3>
                        <p class="feature-description">Beautiful handicrafts showcasing Nepal's artistic traditions</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">🏺</div>
                        <h3 class="feature-title">Cultural Heritage</h3>
                        <p class="feature-description">Preserving and promoting Nepal's rich cultural legacy</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">🤝</div>
                        <h3 class="feature-title">Supporting Artisans</h3>
                        <p class="feature-description">Empowering local craftspeople and their communities</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const navMenu = document.getElementById('navMenu');
            navMenu.classList.toggle('active');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const navMenu = document.getElementById('navMenu');
            const toggleButton = document.querySelector('.mobile-menu-toggle');
            
            if (!navMenu.contains(event.target) && !toggleButton.contains(event.target)) {
                navMenu.classList.remove('active');
            }
        });

        console.log('About Us page loaded successfully!');
    </script>
</body>
</html>