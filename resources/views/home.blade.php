@extends('layout.main')

@section('hyasabicontentauncha')
<!-- SUCCESS MESSAGE -->
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<!-- HERO SECTION -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">Where Every Note Tells a Nepali Story</h1>
            <p class="hero-subtitle">
                Mastery isn't always about talent. It's about practice. Consistent practice builds skill.<br>
                Greatness will come.
            </p>
            
            <!-- Search Bar -->
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Find your traditional instrument...">
                <button class="search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            
            <!-- CTA Button -->
            <div class="cta-section">
                <a href="{{ route('shop.index') }}" class="explore-btn">
                    Explore Now <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES SECTION -->
<section class="features-section">
    <div class="container">
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-music"></i>
                </div>
                <h3>Traditional Instruments</h3>
                <p>Authentic Nepali musical instruments crafted by skilled artisans</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <h3>Cultural Heritage</h3>
                <p>Preserving Nepal's rich musical traditions for future generations</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Support Artisans</h3>
                <p>Supporting local craftsmen and their traditional skills</p>
            </div>
        </div>
    </div>
</section>

<!-- PRODUCTS SECTION -->
<section class="products-section">
    <div class="container">
        <h2 class="section-title">Featured Instruments</h2>
        <div class="products-grid">
            @forelse($products ?? [] as $product)
            <div class="product-card">
                <div class="product-image">
                    @if($product->image)
                        <img src="{{ asset('uploads/' . $product->image) }}" alt="{{ $product->post_title }}">
                    @else
                        <div class="no-image">
                            <i class="fas fa-music"></i>
                            <span>{{ $product->post_title }}</span>
                        </div>
                    @endif
                </div>
                <div class="product-info">
                    <h3 class="product-name">{{ $product->post_title }}</h3>
                    <p class="product-price">Rs. {{ number_format($product->price ?? 0, 2) }}</p>
                    <div class="product-actions">
                        <button class="add-to-cart-btn" onclick="addToCart({{ $product->id }})">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <!-- Sample Products -->
            <div class="product-card">
                <div class="product-image">
                    <div class="no-image">
                        <i class="fas fa-drum"></i>
                        <span>Traditional Madal</span>
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Traditional Madal</h3>
                    <p class="product-price">Rs. 5,000.00</p>
                    <div class="product-actions">
                        <button class="add-to-cart-btn" onclick="loginRequired()">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="product-card">
                <div class="product-image">
                    <div class="no-image">
                        <i class="fas fa-guitar"></i>
                        <span>Nepali Sarangi</span>
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Nepali Sarangi</h3>
                    <p class="product-price">Rs. 8,500.00</p>
                    <div class="product-actions">
                        <button class="add-to-cart-btn" onclick="loginRequired()">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="product-card">
                <div class="product-image">
                    <div class="no-image">
                        <i class="fas fa-wind"></i>
                        <span>Bamboo Bansuri</span>
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Bamboo Bansuri</h3>
                    <p class="product-price">Rs. 2,500.00</p>
                    <div class="product-actions">
                        <button class="add-to-cart-btn" onclick="loginRequired()">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
        
        <div class="view-all-section">
            <a href="{{ route('shop.index') }}" class="view-all-btn">View All Instruments</a>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    /* SEPARATE SECTIONS HOMEPAGE STYLES */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Arial', sans-serif;
        line-height: 1.6;
        color: #333;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Alert Styles */
    .alert {
        padding: 15px 20px;
        margin: 20px auto;
        max-width: 1200px;
        border-radius: 8px;
        text-align: center;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #6ee7b7;
    }

    /* HERO SECTION */
    .hero-section {
        background: #f5f1eb;
        padding: 120px 0;
        min-height: 70vh;
        display: flex;
        align-items: center;
        text-align: center;
    }

    .hero-content {
        max-width: 900px;
        margin: 0 auto;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 2rem;
        line-height: 1.2;
        color: #2d3748;
    }

    .hero-subtitle {
        font-size: 1.2rem;
        margin-bottom: 3rem;
        color: #718096;
        line-height: 1.8;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }

    /* SEARCH SECTION */
    .search-container {
        display: flex;
        max-width: 600px;
        margin: 0 auto 2.5rem;
        background: white;
        border-radius: 50px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .search-input {
        flex: 1;
        padding: 20px 30px;
        border: none;
        outline: none;
        font-size: 1.1rem;
        background: transparent;
    }

    .search-input::placeholder {
        color: #a0aec0;
    }

    .search-btn {
        padding: 20px 30px;
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
        border: none;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1.1rem;
    }

    .search-btn:hover {
        background: linear-gradient(135deg, #ff5252 0%, #e53e3e 100%);
    }

    /* CTA SECTION */
    .cta-section {
        margin-top: 2rem;
    }

    .explore-btn {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        padding: 20px 40px;
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(255, 107, 107, 0.3);
    }

    .explore-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(255, 107, 107, 0.4);
        background: linear-gradient(135deg, #ff5252 0%, #e53e3e 100%);
    }

    /* FEATURES SECTION */
    .features-section {
        background: white;
        padding: 80px 0;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 40px;
        max-width: 1000px;
        margin: 0 auto;
    }

    .feature-card {
        text-align: center;
        padding: 40px 30px;
        border-radius: 15px;
        transition: transform 0.3s ease;
        background: #f8f9fa;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .feature-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 25px;
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
    }

    .feature-card h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 15px;
        color: #2d3748;
    }

    .feature-card p {
        color: #718096;
        line-height: 1.6;
    }

    /* PRODUCTS SECTION */
    .products-section {
        background: #f8f9fa;
        padding: 80px 0;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 3rem;
        color: #2d3748;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-bottom: 50px;
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
    }

    .product-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .product-image {
        height: 220px;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .no-image {
        text-align: center;
        color: #9ca3af;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }

    .no-image i {
        font-size: 3.5rem;
        color: #ff6b6b;
    }

    .no-image span {
        font-weight: 600;
        font-size: 1.2rem;
        color: #2d3748;
    }

    .product-info {
        padding: 30px;
    }

    .product-name {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: #2d3748;
    }

    .product-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: #ff6b6b;
        margin-bottom: 25px;
    }

    .product-actions {
        text-align: center;
    }

    .add-to-cart-btn {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-size: 1rem;
    }

    .add-to-cart-btn:hover {
        background: linear-gradient(135deg, #ff5252 0%, #e53e3e 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255, 107, 107, 0.3);
    }

    .view-all-section {
        text-align: center;
        margin-top: 50px;
    }

    .view-all-btn {
        display: inline-block;
        padding: 18px 45px;
        background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }

    .view-all-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(45, 55, 72, 0.3);
    }

    /* RESPONSIVE DESIGN */
    @media (max-width: 1200px) {
        .container {
            padding: 0 30px;
        }
        
        .products-grid {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }
        
        .features-grid {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }
    }

    @media (max-width: 768px) {
        .hero-section {
            padding: 80px 0;
        }
        
        .hero-title {
            font-size: 2.8rem;
            margin-bottom: 1.5rem;
        }

        .hero-subtitle {
            font-size: 1.1rem;
            margin-bottom: 2.5rem;
        }

        .search-container {
            max-width: 95%;
            margin: 0 auto 2rem;
        }
        
        .search-input {
            padding: 18px 25px;
            font-size: 1rem;
        }
        
        .search-btn {
            padding: 18px 25px;
            font-size: 1rem;
        }
        
        .explore-btn {
            padding: 18px 35px;
            font-size: 1rem;
        }

        .features-section {
            padding: 60px 0;
        }

        .products-section {
            padding: 60px 0;
        }

        .section-title {
            font-size: 2.2rem;
            margin-bottom: 2.5rem;
        }

        .features-grid {
            grid-template-columns: 1fr;
            gap: 25px;
        }
        
        .feature-card {
            padding: 35px 25px;
        }

        .products-grid {
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
        }
        
        .product-card {
            border-radius: 15px;
        }
        
        .product-image {
            height: 200px;
        }
        
        .product-info {
            padding: 25px;
        }
        
        .product-name {
            font-size: 1.2rem;
        }
        
        .product-price {
            font-size: 1.3rem;
        }
        
        .add-to-cart-btn {
            padding: 12px;
            font-size: 0.95rem;
        }
    }

    @media (max-width: 480px) {
        .hero-section {
            padding: 60px 0;
        }
        
        .hero-title {
            font-size: 2.2rem;
            line-height: 1.3;
        }

        .hero-subtitle {
            font-size: 1rem;
            margin-bottom: 2rem;
        }
        
        .hero-content {
            max-width: 100%;
        }

        .search-container {
            flex-direction: column;
            border-radius: 15px;
            max-width: 100%;
            margin-bottom: 1.5rem;
        }
        
        .search-input {
            padding: 15px 20px;
            border-radius: 15px 15px 0 0;
        }
        
        .search-btn {
            padding: 15px 20px;
            border-radius: 0 0 15px 15px;
        }
        
        .explore-btn {
            padding: 15px 30px;
            font-size: 0.95rem;
        }

        .features-section {
            padding: 50px 0;
        }

        .products-section {
            padding: 50px 0;
        }

        .section-title {
            font-size: 1.8rem;
            margin-bottom: 2rem;
        }

        .feature-card {
            padding: 30px 20px;
        }
        
        .feature-icon {
            width: 70px;
            height: 70px;
            font-size: 1.8rem;
        }
        
        .feature-card h3 {
            font-size: 1.3rem;
        }

        .products-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .product-image {
            height: 180px;
        }
        
        .product-info {
            padding: 20px;
        }
        
        .no-image i {
            font-size: 3rem;
        }
        
        .no-image span {
            font-size: 1.1rem;
        }
        
        .view-all-btn {
            padding: 15px 35px;
            font-size: 1rem;
        }
    }

    @media (max-width: 360px) {
        .hero-title {
            font-size: 1.9rem;
        }
        
        .section-title {
            font-size: 1.6rem;
        }
        
        .container {
            padding: 0 15px;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    // Add to cart function
    function addToCart(productId) {
        // Check if user is authenticated
        @auth
            // Make AJAX request to add product to cart
            fetch(`/cart/add/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Product added to cart successfully!');
                    updateCartCount();
                } else {
                    alert(data.message || 'Error adding product to cart');
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error adding product to cart. Please try again.');
            });
        @else
            // Store the intended action and redirect to login
            sessionStorage.setItem('intendedAction', 'addToCart');
            sessionStorage.setItem('productId', productId);
            alert('Please login to add products to cart.');
            window.location.href = '{{ route("login") }}';
        @endauth
    }

    // Login required function for demo products
    function loginRequired() {
        alert('Please login to add products to cart.');
        window.location.href = '{{ route("login") }}';
    }

    // Update cart count function
    function updateCartCount() {
        @auth
            fetch('/cart/count')
                .then(response => response.json())
                .then(data => {
                    const cartCountElements = document.querySelectorAll('.cart-count');
                    cartCountElements.forEach(element => {
                        element.textContent = data.count || 0;
                    });
                })
                .catch(error => {
                    console.error('Error updating cart count:', error);
                });
        @endauth
    }

    // Search functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('.search-input');
        const searchBtn = document.querySelector('.search-btn');
        
        function performSearch() {
            const query = searchInput.value.trim();
            if (query) {
                window.location.href = `{{ route('shop.index') }}?search=${encodeURIComponent(query)}`;
            }
        }
        
        searchBtn.addEventListener('click', performSearch);
        
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });

        // Load cart count on page load
        @auth
            @if(!auth()->user()->isAdmin())
                updateCartCount();
            @endif
        @endauth
    });
</script>
@endsection