@extends('layout.main')

@section('hyasabicontentauncha')

<!-- SUCCESS MESSAGE -->
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<!-- HERO SLIDER SECTION -->
<section class="hero-slider">
    <div class="slider-container">
        <!-- Slide 1 -->
        <div class="slide active" id="slide1">
            <div class="slide-content">
                <div class="hero-text">
                    <h1 class="hero-title">Sale 20% Off</h1>
                    <h2 class="hero-subtitle">On Nepali Cultural Products</h2>
                    <p class="hero-description">Discover authentic handcrafted items from local Nepali artisans. Traditional instruments, handicrafts, and cultural treasures await you.</p>
                    <a href="{{ route('shop.index') }}" class="shop-now-btn">Shop Now</a>
                </div>
                <div class="hero-image">
                    <img src="{{ asset('assets/images/hero-model-1.jpg') }}" alt="Nepali Cultural Products" class="model-image">
                </div>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="slide" id="slide2">
            <div class="slide-content">
                <div class="hero-text">
                    <h1 class="hero-title">New Arrivals</h1>
                    <h2 class="hero-subtitle">Traditional Instruments</h2>
                    <p class="hero-description">Explore our latest collection of authentic Nepali musical instruments crafted by master artisans from the Himalayas.</p>
                    <a href="{{ route('shop.index') }}" class="shop-now-btn">Explore Now</a>
                </div>
                <div class="hero-image">
                    <img src="{{ asset('assets/images/hero-model-2.jpg') }}" alt="Traditional Instruments" class="model-image">
                </div>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="slide" id="slide3">
            <div class="slide-content">
                <div class="hero-text">
                    <h1 class="hero-title">Summer Collection</h1>
                    <h2 class="hero-subtitle">Handmade Crafts</h2>
                    <p class="hero-description">Beautiful handcrafted items perfect for summer. Support local vendors while adding authentic Nepali culture to your home.</p>
                    <a href="{{ route('shop.index') }}" class="shop-now-btn">Shop Collection</a>
                </div>
                <div class="hero-image">
                    <img src="{{ asset('assets/images/hero-model-3.jpg') }}" alt="Handmade Crafts" class="model-image">
                </div>
            </div>
        </div>
    </div>

    <!-- Slider Navigation Dots -->
    <div class="slider-dots">
        <span class="dot active" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
    </div>
</section>

<!-- CATEGORIES SECTION -->
<section class="categories-section">
    <div class="container">
        <h2 class="section-title">Musical Instruments</h2>
        <div class="categories-grid">
            <div class="category-card">
                <div class="category-image">
                    <img src="{{ asset('assets/images/madal.jpg') }}" alt="Madal">
                    <div class="category-overlay">
                        <span class="view-category">View Category</span>
                    </div>
                </div>
                <h3 class="category-name">Madal</h3>
            </div>
            <div class="category-card">
                <div class="category-image">
                    <img src="{{ asset('assets/images/sarangi.jpg') }}" alt="Sarangi">
                    <div class="category-overlay">
                        <span class="view-category">View Category</span>
                    </div>
                </div>
                <h3 class="category-name">Sarangi</h3>
            </div>
            <div class="category-card">
                <div class="category-image">
                    <img src="{{ asset('assets/images/bansuri.jpg') }}" alt="Bansuri">
                    <div class="category-overlay">
                        <span class="view-category">View Category</span>
                    </div>
                </div>
                <h3 class="category-name">Bansuri</h3>
            </div>
            <div class="category-card">
                <div class="category-image">
                    <img src="{{ asset('assets/images/damphu.jpg') }}" alt="Damphu">
                    <div class="category-overlay">
                        <span class="view-category">View Category</span>
                    </div>
                </div>
                <h3 class="category-name">Damphu</h3>
            </div>
            <div class="category-card">
                <div class="category-image">
                    <img src="{{ asset('assets/images/tungna.jpg') }}" alt="Tungna">
                    <div class="category-overlay">
                        <span class="view-category">View Category</span>
                    </div>
                </div>
                <h3 class="category-name">Tungna</h3>
            </div>
            <div class="category-card">
                <div class="category-image">
                    <img src="{{ asset('assets/images/dholak.jpg') }}" alt="Dholak">
                    <div class="category-overlay">
                        <span class="view-category">View Category</span>
                    </div>
                </div>
                <h3 class="category-name">Dholak</h3>
            </div>
            <div class="category-card">
                <div class="category-image">
                    <img src="{{ asset('assets/images/panche-baja.jpg') }}" alt="Panche Baja">
                    <div class="category-overlay">
                        <span class="view-category">View Category</span>
                    </div>
                </div>
                <h3 class="category-name">Panche Baja</h3>
            </div>
        </div>
    </div>
</section>

<!-- FEATURED PRODUCTS SECTION -->
<section class="featured-products-section">
    <div class="container">
        <h2 class="section-title">Featured Products</h2>
        <div class="products-grid">
            @forelse($products ?? [] as $product)
            <div class="product-card">
                <div class="product-image">
                    @if($product->image)
                        <img src="{{ asset('uploads/' . $product->image) }}" alt="{{ $product->post_title }}">
                    @else
                        <img src="{{ asset('assets/images/no-image.jpg') }}" alt="No Image">
                    @endif
                    <div class="product-overlay">
                        <button class="quick-view-btn">Quick View</button>
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">{{ $product->post_title }}</h3>
                    <p class="product-vendor">by {{ $product->user->name ?? 'Unknown Vendor' }}</p>
                    <div class="product-price">Rs. {{ number_format($product->price ?? 0, 2) }}</div>
                    <div class="product-actions">
                        <button class="add-to-cart-btn" onclick="addToCart({{ $product->id }})">Add to Cart</button>
                        <a href="{{ route('shop.product', $product->id) }}" class="view-details-btn">View Details</a>
                    </div>
                </div>
            </div>
            @empty
            <!-- Sample Products for Demo -->
            <div class="product-card">
                <div class="product-image">
                    <img src="{{ asset('assets/images/madal.jpg') }}" alt="Traditional Madal">
                    <div class="product-overlay">
                        <button class="quick-view-btn">Quick View</button>
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Traditional Madal</h3>
                    <p class="product-vendor">by Himalayan Music Store</p>
                    <div class="product-price">Rs. 5,000.00</div>
                    <div class="product-actions">
                        <button class="add-to-cart-btn">Add to Cart</button>
                        <a href="#" class="view-details-btn">View Details</a>
                    </div>
                </div>
            </div>
            <div class="product-card">
                <div class="product-image">
                    <img src="{{ asset('assets/images/sarangi.jpg') }}" alt="Nepali Sarangi">
                    <div class="product-overlay">
                        <button class="quick-view-btn">Quick View</button>
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Nepali Sarangi</h3>
                    <p class="product-vendor">by Kathmandu Folk Instruments</p>
                    <div class="product-price">Rs. 8,500.00</div>
                    <div class="product-actions">
                        <button class="add-to-cart-btn">Add to Cart</button>
                        <a href="#" class="view-details-btn">View Details</a>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- TOP VENDORS SECTION -->
<section class="top-vendors-section">
    <div class="container">
        <h2 class="section-title">Top Vendors</h2>
        <div class="vendors-grid">
            <div class="vendor-card">
                <div class="vendor-logo">
                    <img src="{{ asset('assets/images/vendor1.jpg') }}" alt="Himalayan Music Store">
                </div>
                <div class="vendor-info">
                    <h3 class="vendor-name">Himalayan Music Store</h3>
                    <p class="vendor-products">45 Products</p>
                    <a href="#" class="visit-shop-btn">Visit Shop</a>
                </div>
            </div>
            <div class="vendor-card">
                <div class="vendor-logo">
                    <img src="{{ asset('assets/images/vendor2.jpg') }}" alt="Kathmandu Folk Instruments">
                </div>
                <div class="vendor-info">
                    <h3 class="vendor-name">Kathmandu Folk Instruments</h3>
                    <p class="vendor-products">32 Products</p>
                    <a href="#" class="visit-shop-btn">Visit Shop</a>
                </div>
            </div>
            <div class="vendor-card">
                <div class="vendor-logo">
                    <img src="{{ asset('assets/images/vendor3.jpg') }}" alt="Gurung Handmade Instruments">
                </div>
                <div class="vendor-info">
                    <h3 class="vendor-name">Gurung Handmade Instruments</h3>
                    <p class="vendor-products">28 Products</p>
                    <a href="#" class="visit-shop-btn">Visit Shop</a>
                </div>
            </div>
            <div class="vendor-card">
                <div class="vendor-logo">
                    <img src="{{ asset('assets/images/vendor4.jpg') }}" alt="Newari Crafts">
                </div>
                <div class="vendor-info">
                    <h3 class="vendor-name">Newari Crafts</h3>
                    <p class="vendor-products">38 Products</p>
                    <a href="#" class="visit-shop-btn">Visit Shop</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- WHY CHOOSE US SECTION -->
<section class="why-choose-us-section">
    <div class="container">
        <h2 class="section-title">Why Choose Sanskriti Bazar</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 12l2 2 4-4"></path>
                        <path d="M21 12c-1 0-3-1-3-3s2-3 3-3 3 1 3 3-2 3-3 3"></path>
                        <path d="M3 12c1 0 3-1 3-3s-2-3-3-3-3 1-3 3 2 3 3 3"></path>
                        <path d="M12 3c0 1-1 3-3 3s-3-2-3-3 1-3 3-3 3 2 3 3"></path>
                        <path d="M12 21c0-1 1-3 3-3s3 2 3 3-1 3-3 3-3-2-3-3"></path>
                    </svg>
                </div>
                <h3 class="feature-title">Authentic Products</h3>
                <p class="feature-description">100% genuine Nepali handicrafts and traditional items sourced directly from local artisans.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <h3 class="feature-title">Support Local Vendors</h3>
                <p class="feature-description">Directly support local Nepali vendors and artisans by purchasing their handcrafted products.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="1" y="3" width="15" height="13"></rect>
                        <polygon points="16,3 19,7 21,7 21,13 16,13"></polygon>
                        <circle cx="5.5" cy="18.5" r="2.5"></circle>
                        <circle cx="18.5" cy="18.5" r="2.5"></circle>
                    </svg>
                </div>
                <h3 class="feature-title">Fast Delivery</h3>
                <p class="feature-description">Quick and reliable delivery across Nepal with secure packaging to protect your items.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                        <line x1="1" y1="10" x2="23" y2="10"></line>
                    </svg>
                </div>
                <h3 class="feature-title">Secure Payment</h3>
                <p class="feature-description">Safe and secure payment options with multiple payment methods for your convenience.</p>
            </div>
        </div>
    </div>
</section>
<!-- TESTIMONIALS SECTION -->
<section class="testimonials-section">
    <div class="container">
        <h2 class="section-title">What Our Customers Say</h2>
        <div class="testimonials-slider">
            <div class="testimonial-card active">
                <div class="testimonial-content">
                    <p class="testimonial-text">"Amazing quality products! I bought a traditional Madal and it sounds incredible. The craftsmanship is outstanding and delivery was very fast."</p>
                    <div class="testimonial-author">
                        <img src="{{ asset('assets/images/customer1.jpg') }}" alt="Ram Sharma" class="author-image">
                        <div class="author-info">
                            <h4 class="author-name">Ram Sharma</h4>
                            <p class="author-location">Kathmandu</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <p class="testimonial-text">"Sanskriti Bazar is the best place to find authentic Nepali handicrafts. I've ordered multiple items and each one exceeded my expectations."</p>
                    <div class="testimonial-author">
                        <img src="{{ asset('assets/images/customer2.jpg') }}" alt="Sita Rai" class="author-image">
                        <div class="author-info">
                            <h4 class="author-name">Sita Rai</h4>
                            <p class="author-location">Pokhara</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <p class="testimonial-text">"Great platform to support local vendors. The variety of products is impressive and the quality is always top-notch."</p>
                    <div class="testimonial-author">
                        <img src="{{ asset('assets/images/customer3.jpg') }}" alt="Hari Gurung" class="author-image">
                        <div class="author-info">
                            <h4 class="author-name">Hari Gurung</h4>
                            <p class="author-location">Chitwan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="testimonial-dots">
            <span class="dot active" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
        </div>
    </div>
</section>

@endsection
@section('styles')
<style>
    /* GLOBAL STYLES */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        line-height: 1.6;
        color: #333;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 3rem;
        color: #2c3e50;
    }

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

    /* HERO SLIDER SECTION */
    .hero-slider {
        position: relative;
        height: 600px;
        overflow: hidden;
        background: linear-gradient(135deg, #ff4757 0%, #ff3742 100%);
    }

    .slider-container {
        position: relative;
        height: 100%;
    }

    .slide {
        display: none;
        height: 100%;
        align-items: center;
        padding: 0 50px;
    }

    .slide.active {
        display: flex;
    }
    .slide-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
        max-width: 1200px;
        margin: 0 auto;
        width: 100%;
    }

    .hero-text {
        color: white;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 1rem;
    }

    .hero-subtitle {
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        opacity: 0.9;
    }

    .hero-description {
        font-size: 1.1rem;
        margin-bottom: 2rem;
        opacity: 0.8;
        line-height: 1.6;
    }

    .shop-now-btn {
        display: inline-block;
        background: white;
        color: #ff4757;
        padding: 15px 40px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        text-transform: uppercase;
    }

    .shop-now-btn:hover {
        background: #f8f9fa;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }

    .hero-image {
        text-align: center;
    }

    .model-image {
        width: 100%;
        max-width: 500px;
        height: auto;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }

    .slider-dots {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 10px;
    }

    .dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .dot.active, .dot:hover {
        background: white;
    }
    /* CATEGORIES SECTION */
    .categories-section {
        padding: 80px 0;
        background: #f8f9fa;
    }

    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 30px;
    }

    .category-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .category-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }

    .category-image {
        height: 200px;
        overflow: hidden;
        position: relative;
    }

    .category-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .category-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 71, 87, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .category-card:hover .category-overlay {
        opacity: 1;
    }

    .category-card:hover .category-image img {
        transform: scale(1.1);
    }

    .view-category {
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .category-name {
        font-size: 1.25rem;
        font-weight: 600;
        padding: 20px;
        color: #2c3e50;
        text-align: center;
    }
    /* FEATURED PRODUCTS SECTION */
    .featured-products-section {
        padding: 80px 0;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
    }

    .product-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }

    .product-image {
        position: relative;
        height: 250px;
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .product-card:hover .product-overlay {
        opacity: 1;
    }

    .quick-view-btn {
        background: white;
        color: #333;
        border: none;
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .quick-view-btn:hover {
        background: #ff4757;
        color: white;
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
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        text-decoration: none;
        display: block;
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

    /* TOP VENDORS SECTION */
    .top-vendors-section {
        padding: 80px 0;
        background: #f8f9fa;
    }

    .vendors-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
    }

    .vendor-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .vendor-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }

    .vendor-logo {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid #ff4757;
    }

    .vendor-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .vendor-name {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: #2c3e50;
    }
    .vendor-products {
        color: #7f8c8d;
        margin-bottom: 20px;
    }

    .visit-shop-btn {
        background: #ff4757;
        color: white;
        padding: 10px 25px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .visit-shop-btn:hover {
        background: #ff3742;
        transform: translateY(-2px);
    }

    /* WHY CHOOSE US SECTION */
    .why-choose-us-section {
        padding: 80px 0;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 40px;
    }

    .feature-card {
        text-align: center;
        padding: 30px 20px;
    }

    .feature-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, #ff4757 0%, #ff3742 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .feature-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 15px;
        color: #2c3e50;
    }

    .feature-description {
        color: #7f8c8d;
        line-height: 1.6;
    }

    /* TESTIMONIALS SECTION */
    .testimonials-section {
        padding: 80px 0;
        background: #f8f9fa;
    }

    .testimonials-slider {
        max-width: 800px;
        margin: 0 auto;
        position: relative;
    }

    .testimonial-card {
        display: none;
        background: white;
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .testimonial-card.active {
        display: block;
    }
    .testimonial-text {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #2c3e50;
        margin-bottom: 30px;
        font-style: italic;
    }

    .testimonial-author {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .author-image {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
    }

    .author-name {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .author-location {
        color: #7f8c8d;
        font-size: 0.9rem;
    }

    .testimonial-dots {
        text-align: center;
        margin-top: 30px;
    }

    .testimonial-dots .dot {
        height: 12px;
        width: 12px;
        margin: 0 5px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .testimonial-dots .dot.active, .testimonial-dots .dot:hover {
        background-color: #ff4757;
    }

    /* RESPONSIVE DESIGN */
    @media (max-width: 768px) {
        .slide-content {
            grid-template-columns: 1fr;
            gap: 40px;
            text-align: center;
        }

        .hero-title {
            font-size: 2.5rem;
        }

        .hero-subtitle {
            font-size: 1.5rem;
        }

        .section-title {
            font-size: 2rem;
        }

        .categories-grid,
        .products-grid,
        .vendors-grid,
        .features-grid {
            grid-template-columns: 1fr;
        }

        .product-actions {
            flex-direction: column;
        }

        .testimonial-card {
            padding: 30px 20px;
        }
    }

    @media (max-width: 480px) {
        .hero-title {
            font-size: 2rem;
        }

        .hero-subtitle {
            font-size: 1.25rem;
        }

        .section-title {
            font-size: 1.75rem;
        }
    }
</style>
@endsection
@section('scripts')
<script>
    let slideIndex = 1;
    let testimonialIndex = 1;

    // Hero Slider Functions
    function currentSlide(n) {
        showSlide(slideIndex = n);
    }

    function showSlide(n) {
        let slides = document.getElementsByClassName("slide");
        let dots = document.getElementsByClassName("dot");
        
        if (n > slides.length) { slideIndex = 1 }
        if (n < 1) { slideIndex = slides.length }
        
        for (let i = 0; i < slides.length; i++) {
            slides[i].classList.remove("active");
        }
        
        for (let i = 0; i < dots.length; i++) {
            dots[i].classList.remove("active");
        }
        
        slides[slideIndex - 1].classList.add("active");
        dots[slideIndex - 1].classList.add("active");
    }

    // Auto slide hero
    setInterval(function() {
        slideIndex++;
        if (slideIndex > 3) slideIndex = 1;
        showSlide(slideIndex);
    }, 5000);

    // Testimonial Functions
    function currentTestimonial(n) {
        showTestimonial(testimonialIndex = n);
    }

    function showTestimonial(n) {
        let testimonials = document.getElementsByClassName("testimonial-card");
        let testimonialDots = document.querySelectorAll(".testimonial-dots .dot");
        
        if (n > testimonials.length) { testimonialIndex = 1 }
        if (n < 1) { testimonialIndex = testimonials.length }
        
        for (let i = 0; i < testimonials.length; i++) {
            testimonials[i].classList.remove("active");
        }
        
        for (let i = 0; i < testimonialDots.length; i++) {
            testimonialDots[i].classList.remove("active");
        }
        
        testimonials[testimonialIndex - 1].classList.add("active");
        testimonialDots[testimonialIndex - 1].classList.add("active");
    }

    // Auto slide testimonials
    setInterval(function() {
        testimonialIndex++;
        if (testimonialIndex > 3) testimonialIndex = 1;
        showTestimonial(testimonialIndex);
    }, 6000);

    // Add to cart function
    function addToCart(productId) {
        alert('Product added to cart!');
    }

    // Initialize sliders when page loads
    document.addEventListener('DOMContentLoaded', function() {
        showSlide(1);
        showTestimonial(1);
    });
</script>
@endsection