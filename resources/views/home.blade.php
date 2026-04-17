@extends('layout.main')

@section('hyasabicontentauncha')
<!-- SUCCESS MESSAGE -->
@if (session('success'))
<div class="alert alert-success" id="successAlert">
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="alert alert-danger" id="errorAlert">
    {{ session('error') }}
</div>
@endif

<!-- HERO SECTION -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">Welcome to Sanskriti Bazar</h1>
                <p class="hero-subtitle">Traditional Instruments, Timeless Culture</p>
                <p class="hero-description">
                   Discover handmade Nepali instruments that reflect generations of culture, craftsmanship, and musical tradition.
                </p>
                <div class="hero-buttons">
                    <a href="{{ route('shop.index') }}" class="btn-primary">Explore Products</a>
                    
</section>

<!-- FEATURES SECTION -->
<section class="features-section">
    <div class="container">
        <h2 class="section-title">Why Choose Sanskriti Bazar</h2>
        <div class="features-grid">
            <div class="feature-card">
            
                <h3>100% Authentic</h3>
                <p>Genuine Nepali instruments like Madal & Sarangi.</p>
            </div>
            
            <div class="feature-card">
            
                <h3>Support Local Vendors</h3>
                <p>Helping Nepali craftsmen and preserving traditions.</p>
            </div>
            
            <div class="feature-card">
                
                <h3>Unique Cultural Collection </h3>
                <p>Wide variety of traditional instruments.</p>
            </div>
            
            <div class="feature-card">
                
                <h3>High Quality</h3>
                <p>Handmade with durable materials and authentic sound.</p>
            </div>

            <div class="feature-card">

                <h3>Easy Shopping</h3>
                <p>Simple, secure ordering with reliable delivery.</p>
            </div>

            <div class="feature-card">
                
                <h3>For Everyone</h3>
                <p>Perfect for beginners and professionals.</p>
            </div>

             <div class="feature-card">
                
                <h3>Affordable Pricing</h3>
                <p>Fair prices for high-quality traditional instruments.</p>
            </div>

             <div class="feature-card">
                
                <h3>Reliable Service</h3>
                <p>Trusted platform with smooth ordering and customer support.</p>
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
                <div class="product-image-container">
                    @if($product->image)
                        <img src="{{ asset('uploads/' . $product->image) }}" alt="{{ $product->post_title }}" class="product-image">
                    @else
                        <div class="no-image-placeholder">
                            <i class="fas fa-music"></i>
                        </div>
                    @endif
                </div>
                
                <div class="product-details">
                    <h3 class="product-title">{{ $product->post_title }}</h3>
                    <p class="product-vendor">by {{ $product->user->name ?? 'Vendor User' }}</p>
                    <div class="product-price">Rs. {{ number_format($product->price ?? 0, 2) }}</div>
                    
                    <div class="product-buttons">
                        @auth
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-cart-form">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn-add-cart-home">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn-login-to-buy-home">
                                <i class="fas fa-sign-in-alt"></i> Login to Buy
                            </a>
                        @endauth
                        <a href="{{ route('shop.product', $product->id) }}" class="btn-view-details-home">View Details</a>
                    </div>
                </div>
            </div>
            @empty
            <!-- Sample Products for Demo -->
            <div class="product-card">
                <div class="product-image-container">
                    <div class="no-image-placeholder">
                        <i class="fas fa-drum"></i>
                    </div>
                </div>
                <div class="product-details">
                    <h3 class="product-title">Traditional Madal</h3>
                    <p class="product-vendor">by Himalayan Music Store</p>
                    <div class="product-price">Rs. 5,000.00</div>
                    <div class="product-buttons">
                        @auth
                            <a href="{{ route('shop.index') }}" class="btn-add-cart-home">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-login-to-buy-home">
                                <i class="fas fa-sign-in-alt"></i> Login to Buy
                            </a>
                        @endauth
                        <a href="{{ route('shop.index') }}" class="btn-view-details-home">View Details</a>
                    </div>
                </div>
            </div>
            
            <div class="product-card">
                <div class="product-image-container">
                    <div class="no-image-placeholder">
                        <i class="fas fa-guitar"></i>
                    </div>
                </div>
                <div class="product-details">
                    <h3 class="product-title">Nepali Sarangi</h3>
                    <p class="product-vendor">by Traditional Crafts Nepal</p>
                    <div class="product-price">Rs. 8,500.00</div>
                    <div class="product-buttons">
                        @auth
                            <a href="{{ route('shop.index') }}" class="btn-add-cart-home">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-login-to-buy-home">
                                <i class="fas fa-sign-in-alt"></i> Login to Buy
                            </a>
                        @endauth
                        <a href="{{ route('shop.index') }}" class="btn-view-details-home">View Details</a>
                    </div>
                </div>
            </div>
            
            <div class="product-card">
                <div class="product-image-container">
                    <div class="no-image-placeholder">
                        <i class="fas fa-wind"></i>
                    </div>
                </div>
                <div class="product-details">
                    <h3 class="product-title">Bamboo Bansuri</h3>
                    <p class="product-vendor">by Kathmandu Folk Instruments</p>
                    <div class="product-price">Rs. 2,500.00</div>
                    <div class="product-buttons">
                        @auth
                            <a href="{{ route('shop.index') }}" class="btn-add-cart-home">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-login-to-buy-home">
                                <i class="fas fa-sign-in-alt"></i> Login to Buy
                            </a>
                        @endauth
                        <a href="{{ route('shop.index') }}" class="btn-view-details-home">View Details</a>
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
                Join thousands of customers who trust Sanskriti Bazar for authentic Nepali traditional musical instruments. 
                Discover unique products and support local vendors.
            </p>
            <div class="cta-buttons">
                <a href="{{ route('shop.index') }}" class="btn-primary">Browse Products</a>
                <a href="{{ route('contact') }}" class="btn-secondary">Contact Us</a>
            </div>
        </div>
    </div>
</section>

<script>
// Add to cart functionality with loading state
document.addEventListener('DOMContentLoaded', function() {
    const addToCartForms = document.querySelectorAll('.add-cart-form');
    
    addToCartForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const button = form.querySelector('.btn-add-cart-home');
            const originalText = button.innerHTML;
            
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
            button.disabled = true;
            
            // Re-enable button after 2 seconds
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            }, 2000);
        });
    });

    // Load cart count on page load
    @auth
        @if(!auth()->user()->isAdmin())
            updateCartCount();
        @endif
    @endauth

    // Auto-hide toast notifications
    const successAlert = document.getElementById('successAlert');
    const errorAlert = document.getElementById('errorAlert');
    
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.animation = 'slideOutRight 0.3s ease-in';
            setTimeout(() => successAlert.remove(), 300);
        }, 4000);
    }
    
    if (errorAlert) {
        setTimeout(() => {
            errorAlert.style.animation = 'slideOutRight 0.3s ease-in';
            setTimeout(() => errorAlert.remove(), 300);
        }, 5000);
    }
});

// Update cart count function
function updateCartCount() {
    @auth
        fetch('/cart/count')
            .then(response => response.json())
            .then(data => {
                const cartCountElements = document.querySelectorAll('.cart-count');
                cartCountElements.forEach(element => {
                    const count = data.count || 0;
                    if (count > 0) {
                        element.textContent = count;
                        element.style.display = 'flex';
                    } else {
                        element.style.display = 'none';
                    }
                });
            })
            .catch(error => {
                console.error('Error updating cart count:', error);
                const cartCountElements = document.querySelectorAll('.cart-count');
                cartCountElements.forEach(element => {
                    element.style.display = 'none';
                });
            });
    @endauth
}
</script>
@endsection