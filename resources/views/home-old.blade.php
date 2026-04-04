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
            <div class="hero-text">
                <h1 class="hero-title">Welcome to Sanskriti Bazar</h1>
                <p class="hero-subtitle">Discover Authentic Nepali Handicrafts & Cultural Treasures</p>
                <p class="hero-description">
                    Your one-stop destination for traditional Nepali musical instruments, handcrafted artifacts, 
                    and cultural items. Supporting local artisans and preserving Nepal's rich heritage.
                </p>
                <div class="hero-buttons">
                    <a href="{{ route('shop.index') }}" class="btn-primary">Explore Products</a>
                    <a href="{{ route('about') }}" class="btn-secondary">Learn More</a>
                </div>
            </div>
            <div class="hero-image">
                <div class="image-placeholder">
                    <i class="fas fa-music"></i>
                    <p>Traditional Nepali Instruments</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES SECTION -->
<section class="features-section">
    <div class="container">
        <h2 class="section-title">Why Choose Sanskriti Bazar</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-certificate"></i>
                </div>
                <h3>100% Authentic</h3>
                <p>Genuine Nepali handicrafts sourced directly from local artisans and traditional craftsmen.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Support Local Vendors</h3>
                <p>Every purchase directly supports local Nepali vendors and helps preserve traditional crafts.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <h3>Fast Delivery</h3>
                <p>Quick and reliable delivery across Nepal with secure packaging to protect your items.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Secure Shopping</h3>
                <p>Safe and secure payment methods with buyer protection and satisfaction guarantee.</p>
            </div>
        </div>
    </div>
</section>

<!-- PRODUCTS PREVIEW SECTION -->
<section class="products-preview-section">
    <div class="container">
        <h2 class="section-title">Featured Products</h2>
        <div class="products-grid">
            @forelse($products ?? [] as $product)
            <div class="product-card">
                <div class="product-image">
                    @if($product->image)
                        <img src="{{ asset('uploads/' . $product->image) }}" alt="{{ $product->post_title }}">
                    @else
                        <div class="no-image">
                            <i class="fas fa-image"></i>
                            <span>No Image</span>
                        </div>
                    @endif
                </div>
                <div class="product-info">
                    <h3 class="product-name">{{ $product->post_title }}</h3>
                    <p class="product-vendor">by {{ $product->user->name ?? 'Unknown Vendor' }}</p>
                    <div class="product-price">Rs. {{ number_format($product->price ?? 0, 2) }}</div>
                    <div class="product-actions">
                        <button class="add-to-cart-btn" onclick="addToCart({{ $product->id }})">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                        <a href="{{ route('shop.product', $product->id) }}" class="view-details-btn">View Details</a>
                    </div>
                </div>
            </div>
            @empty
            <!-- Sample Products for Demo -->
            <div class="product-card">
                <div class="product-image">
                    <div class="no-image">
                        <i class="fas fa-drum"></i>
                        <span>Madal</span>
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Traditional Madal</h3>
                    <p class="product-vendor">by Himalayan Music Store</p>
                    <div class="product-price">Rs. 5,000.00</div>
                    <div class="product-actions">
                        <button class="add-to-cart-btn" onclick="loginRequired()">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                        <a href="{{ route('shop.index') }}" class="view-details-btn">View Details</a>
                    </div>
                </div>
            </div>
            
            <div class="product-card">
                <div class="product-image">
                    <div class="no-image">
                        <i class="fas fa-guitar"></i>
                        <span>Sarangi</span>
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Nepali Sarangi</h3>
                    <p class="product-vendor">by Traditional Crafts Nepal</p>
                    <div class="product-price">Rs. 8,500.00</div>
                    <div class="product-actions">
                        <button class="add-to-cart-btn" onclick="loginRequired()">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                        <a href="{{ route('shop.index') }}" class="view-details-btn">View Details</a>
                    </div>
                </div>
            </div>
            
            <div class="product-card">
                <div class="product-image">
                    <div class="no-image">
                        <i class="fas fa-wind"></i>
                        <span>Bansuri</span>
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Bamboo Bansuri</h3>
                    <p class="product-vendor">by Kathmandu Folk Instruments</p>
                    <div class="product-price">Rs. 2,500.00</div>
                    <div class="product-actions">
                        <button class="add-to-cart-btn" onclick="loginRequired()">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                        <a href="{{ route('shop.index') }}" class="view-details-btn">View Details</a>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
        
        <div class="view-all-section">
            <a href="{{ route('shop.index') }}" class="view-all-btn">View All Products</a>
        </div>
    </div>
</section>

<!-- CALL TO ACTION SECTION -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title">Start Your Cultural Journey Today</h2>
            <p class="cta-description">
                Join thousands of customers who trust Sanskriti Bazar for authentic Nepali handicrafts. 
                Discover unique products and support local artisans.
            </p>
            <div class="cta-buttons">
                <a href="{{ route('shop.index') }}" class="btn-primary">Browse Products</a>
                <a href="{{ route('contact') }}" class="btn-secondary">Contact Us</a>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    /* SIMPLE HOME PAGE STYLES */
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

    .section-title {
        font-size: 2rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 2rem;
        color: #2c3e50;
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 80px 0;
        min-height: 500px;
        display: flex;
        align-items: center;
    }

    .hero-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }

    .hero-title {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .hero-subtitle {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
        opacity: 0.9;
    }

    .hero-description {
        font-size: 1.1rem;
        margin-bottom: 2rem;
        opacity: 0.8;
        line-height: 1.6;
    }

    .hero-buttons {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .btn-primary, .btn-secondary {
        padding: 15px 30px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        display: inline-block;
        text-align: center;
    }

    .btn-primary {
        background: #ff4757;
        color: white;
        border: 2px solid #ff4757;
    }

    .btn-primary:hover {
        background: #ff3742;
        border-color: #ff3742;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: transparent;
        color: white;
        border: 2px solid white;
    }

    .btn-secondary:hover {
        background: white;
        color: #667eea;
    }

    .hero-image {
        text-align: center;
    }

    .image-placeholder {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        padding: 60px 40px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .image-placeholder i {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.8;
    }

    .image-placeholder p {
        font-size: 1.2rem;
        font-weight: 600;
    }

    /* FEATURES SECTION */
    .features-section {
        padding: 80px 0;
        background: #f8f9fa;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
    }

    .feature-card {
        background: white;
        padding: 40px 30px;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease;
    }

    .feature-card:hover {
        transform: translateY(-10px);
    }

    .feature-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
    }

    .feature-card h3 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 15px;
        color: #2c3e50;
    }

    .feature-card p {
        color: #666;
        line-height: 1.6;
    }

    /* PRODUCTS PREVIEW SECTION */
    .products-preview-section {
        padding: 80px 0;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }

    .product-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
    }

    .product-image {
        height: 200px;
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
        gap: 10px;
    }

    .no-image i {
        font-size: 3rem;
    }

    .no-image span {
        font-weight: 600;
        font-size: 1.1rem;
    }

    .product-info {
        padding: 20px;
    }

    .product-name {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 5px;
        color: #2c3e50;
    }

    .product-vendor {
        font-size: 0.9rem;
        color: #7f8c8d;
        margin-bottom: 10px;
    }

    .product-price {
        font-size: 1.25rem;
        font-weight: 700;
        color: #ff4757;
        margin-bottom: 15px;
    }

    .product-actions {
        display: flex;
        gap: 10px;
    }

    .add-to-cart-btn, .view-details-btn {
        flex: 1;
        padding: 10px;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        font-size: 0.9rem;
    }

    .add-to-cart-btn {
        background: #ff4757;
        color: white;
    }

    .add-to-cart-btn:hover {
        background: #ff3742;
    }

    .view-details-btn {
        background: #f8f9fa;
        color: #333;
        border: 1px solid #ddd;
    }

    .view-details-btn:hover {
        background: #e9ecef;
    }

    .view-all-section {
        text-align: center;
    }

    .view-all-btn {
        display: inline-block;
        padding: 15px 40px;
        background: #667eea;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .view-all-btn:hover {
        background: #5a67d8;
        transform: translateY(-2px);
    }

    /* CTA SECTION */
    .cta-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white;
        text-align: center;
    }

    .cta-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .cta-description {
        font-size: 1.2rem;
        margin-bottom: 2rem;
        opacity: 0.9;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .cta-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
    }

    /* RESPONSIVE DESIGN */
    @media (max-width: 768px) {
        .hero-content {
            grid-template-columns: 1fr;
            gap: 40px;
            text-align: center;
        }

        .hero-title {
            font-size: 2.5rem;
        }

        .hero-subtitle {
            font-size: 1.25rem;
        }

        .section-title {
            font-size: 1.75rem;
        }

        .features-grid,
        .products-grid {
            grid-template-columns: 1fr;
        }

        .hero-buttons,
        .cta-buttons {
            flex-direction: column;
            align-items: center;
        }

        .btn-primary, .btn-secondary {
            width: 200px;
        }

        .cta-title {
            font-size: 2rem;
        }

        .product-actions {
            flex-direction: column;
        }
    }

    @media (max-width: 480px) {
        .hero-title {
            font-size: 2rem;
        }

        .section-title {
            font-size: 1.5rem;
        }

        .cta-title {
            font-size: 1.75rem;
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
                    // Update cart count if needed
                    updateCartCount();
                } else {
                    alert('Error adding product to cart: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error adding product to cart. Please try again.');
            });
        @else
            // Redirect to login if not authenticated
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

    // Load cart count on page load
    document.addEventListener('DOMContentLoaded', function() {
        @auth
            @if(!auth()->user()->isAdmin())
                updateCartCount();
            @endif
        @endauth
    });
</script>
@endsection