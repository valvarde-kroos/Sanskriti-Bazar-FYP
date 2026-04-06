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
                    <a href="#about" class="btn-secondary">Learn More</a>
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
                <a href="#contact" class="btn-secondary">Contact Us</a>
            </div>
        </div>
    </div>
</section>
@endsection