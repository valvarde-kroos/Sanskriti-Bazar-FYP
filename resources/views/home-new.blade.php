<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sanskriti Bazaar - Traditional Nepali Musical Instruments</title>
    
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
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 1rem 0;
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
            color: #2c3e50;
            text-decoration: none;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-menu a {
            text-decoration: none;
            color: #555;
            font-weight: 500;
            transition: color 0.3s;
            padding: 0.5rem 0;
        }

        .nav-menu a:hover {
            color: #3498db;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .cart-icon {
            position: relative;
            color: #555;
            font-size: 1.5rem;
            cursor: pointer;
            transition: color 0.3s;
        }

        .cart-icon:hover {
            color: #3498db;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #e74c3c;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #555;
            cursor: pointer;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><rect fill="%23f5f1eb" width="1200" height="600"/><circle fill="%23e8dcc0" cx="200" cy="150" r="80"/><circle fill="%23d4c5a0" cx="800" cy="400" r="120"/><circle fill="%23c9b896" cx="1000" cy="200" r="60"/></svg>');
            background-size: cover;
            background-position: center;
            height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            margin-top: 80px;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .hero-content p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            max-width: 600px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }

        .btn-primary {
            background: #3498db;
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
        }

        /* Section Spacing */
        .section {
            padding: 4rem 0;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 3rem;
            color: #2c3e50;
        }

        /* Featured Products */
        .featured-products {
            background: #fff;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .product-card {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .product-image {
            height: 220px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: #bdc3c7;
            position: relative;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-info {
            padding: 1.5rem;
        }

        .product-name {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #2c3e50;
        }

        .product-price {
            font-size: 1.4rem;
            font-weight: 700;
            color: #3498db;
            margin-bottom: 1rem;
        }

        .btn-cart {
            width: 100%;
            background: #27ae60;
            color: white;
            border: none;
            padding: 0.8rem;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-cart:hover {
            background: #229954;
            transform: translateY(-1px);
        }

        /* Categories */
        .categories {
            background: #f8f9fa;
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .category-card {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: all 0.3s;
            cursor: pointer;
        }

        .category-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            background: #3498db;
            color: white;
        }

        .category-icon {
            font-size: 3rem;
            color: #3498db;
            margin-bottom: 1rem;
        }

        .category-card:hover .category-icon {
            color: white;
        }

        .category-name {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2c3e50;
        }

        .category-card:hover .category-name {
            color: white;
        }

        /* Footer */
        .footer {
            background: #2c3e50;
            color: white;
            padding: 3rem 0 1rem;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            margin-bottom: 1rem;
            font-size: 1.3rem;
            color: #ecf0f1;
        }

        .footer-section p {
            margin-bottom: 0.5rem;
            color: #bdc3c7;
        }

        .footer-section a {
            color: #bdc3c7;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-section a:hover {
            color: #3498db;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background: #34495e;
            border-radius: 50%;
            color: white;
            font-size: 1.3rem;
            transition: all 0.3s;
        }

        .social-links a:hover {
            background: #3498db;
            transform: translateY(-2px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid #34495e;
            color: #95a5a6;
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
                background: white;
                flex-direction: column;
                padding: 1rem;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            }

            .nav-menu.active {
                display: flex;
            }

            .hero-content h1 {
                font-size: 2.5rem;
            }

            .hero-content p {
                font-size: 1.1rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 1.5rem;
            }

            .categories-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1.5rem;
            }

            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .hero-content h1 {
                font-size: 2rem;
            }

            .products-grid {
                grid-template-columns: 1fr;
            }

            .categories-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="#" class="logo">Sanskriti Bazaar</a>
            
            <ul class="nav-menu" id="navMenu">
                <li><a href="#home">Home</a></li>
                <li><a href="{{ route('shop.index') }}">Shops</a></li>
                <li><a href="#about">About Us</a></li>
                <li><a href="#contact">Contacts</a></li>
            </ul>
            
            <div class="nav-right">
                <div class="cart-icon" onclick="goToCart()">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count" id="cartCount">0</span>
                </div>
                <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <h1>Sanskriti Bazaar</h1>
            <p>Explore Traditional Nepali Musical Instruments</p>
            <a href="{{ route('shop.index') }}" class="btn-primary">Shop Now</a>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="section featured-products">
        <div class="container">
            <h2 class="section-title">Featured Products</h2>
            <div class="products-grid">
                @if($products->count() > 0)
                    @foreach($products->take(4) as $product)
                    <div class="product-card">
                        <div class="product-image">
                            @if($product->image)
                                <img src="{{ asset('uploads/' . $product->image) }}" alt="{{ $product->post_title }}">
                            @else
                                <i class="fas fa-music"></i>
                            @endif
                        </div>
                        <div class="product-info">
                            <h3 class="product-name">{{ $product->post_title }}</h3>
                            <p class="product-price">Rs. {{ number_format($product->price ?? 2500, 2) }}</p>
                            <button class="btn-cart" onclick="addToCart({{ $product->id }})">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- Sample Products -->
                    <div class="product-card">
                        <div class="product-image">
                            <i class="fas fa-wind"></i>
                        </div>
                        <div class="product-info">
                            <h3 class="product-name">Traditional Bansuri</h3>
                            <p class="product-price">Rs. 2,500.00</p>
                            <button class="btn-cart" onclick="loginRequired()">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                    
                    <div class="product-card">
                        <div class="product-image">
                            <i class="fas fa-drum"></i>
                        </div>
                        <div class="product-info">
                            <h3 class="product-name">Nepali Madal</h3>
                            <p class="product-price">Rs. 4,500.00</p>
                            <button class="btn-cart" onclick="loginRequired()">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                    
                    <div class="product-card">
                        <div class="product-image">
                            <i class="fas fa-music"></i>
                        </div>
                        <div class="product-info">
                            <h3 class="product-name">Traditional Damaha</h3>
                            <p class="product-price">Rs. 3,800.00</p>
                            <button class="btn-cart" onclick="loginRequired()">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                    
                    <div class="product-card">
                        <div class="product-image">
                            <i class="fas fa-guitar"></i>
                        </div>
                        <div class="product-info">
                            <h3 class="product-name">Authentic Khaijhadi</h3>
                            <p class="product-price">Rs. 3,200.00</p>
                            <button class="btn-cart" onclick="loginRequired()">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section class="section categories">
        <div class="container">
            <h2 class="section-title">Shop by Category</h2>
            <div class="categories-grid">
                <div class="category-card" onclick="goToCategory('bansuri')">
                    <div class="category-icon">
                        <i class="fas fa-wind"></i>
                    </div>
                    <h3 class="category-name">Bansuri</h3>
                </div>
                
                <div class="category-card" onclick="goToCategory('madal')">
                    <div class="category-icon">
                        <i class="fas fa-drum"></i>
                    </div>
                    <h3 class="category-name">Madal</h3>
                </div>
                
                <div class="category-card" onclick="goToCategory('damaha')">
                    <div class="category-icon">
                        <i class="fas fa-music"></i>
                    </div>
                    <h3 class="category-name">Damaha</h3>
                </div>
                
                <div class="category-card" onclick="goToCategory('khaijhadi')">
                    <div class="category-icon">
                        <i class="fas fa-guitar"></i>
                    </div>
                    <h3 class="category-name">Khaijhadi</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contact">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Contact Details</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Kathmandu, Nepal</p>
                    <p><i class="fas fa-phone"></i> +977-1-4567890</p>
                    <p><i class="fas fa-envelope"></i> info@sanskritibazaar.com</p>
                    <p><i class="fas fa-clock"></i> Mon - Sat: 9:00 AM - 6:00 PM</p>
                </div>
                
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <p><a href="#home">Home</a></p>
                    <p><a href="{{ route('shop.index') }}">Shop</a></p>
                    <p><a href="#about">About Us</a></p>
                    <p><a href="#contact">Contact</a></p>
                </div>
                
                <div class="footer-section">
                    <h3>Follow Us</h3>
                    <p>Stay connected with us on social media</p>
                    <div class="social-links">
                        <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2024 Sanskriti Bazaar. All rights reserved. | Traditional Nepali Musical Instruments</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const navMenu = document.getElementById('navMenu');
            navMenu.classList.toggle('active');
        }

        // Add to cart functionality
        function addToCart(productId) {
            @auth
                fetch(`/cart/add/${productId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ quantity: 1 })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Product added to cart successfully!');
                        updateCartCount();
                    } else {
                        alert(data.message || 'Error adding product to cart');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error adding product to cart. Please try again.');
                });
            @else
                alert('Please login to add products to cart.');
                window.location.href = '{{ route("login") }}';
            @endauth
        }

        // Login required for demo products
        function loginRequired() {
            alert('Please login to add products to cart.');
            window.location.href = '{{ route("login") }}';
        }

        // Go to cart
        function goToCart() {
            @auth
                window.location.href = '{{ route("cart") }}';
            @else
                alert('Please login to view your cart.');
                window.location.href = '{{ route("login") }}';
            @endauth
        }

        // Go to category
        function goToCategory(category) {
            window.location.href = `{{ route('shop.index') }}?category=${category}`;
        }

        // Update cart count
        function updateCartCount() {
            @auth
                fetch('/cart/count')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('cartCount').textContent = data.count || 0;
                    })
                    .catch(error => {
                        console.error('Error updating cart count:', error);
                    });
            @endauth
        }

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            const navMenu = document.getElementById('navMenu');
            const toggleButton = document.querySelector('.mobile-menu-toggle');
            
            if (!navMenu.contains(e.target) && !toggleButton.contains(e.target)) {
                navMenu.classList.remove('active');
            }
        });

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            // Load cart count on page load
            @auth
                updateCartCount();
            @endauth
        });
    </script>
</body>
</html>