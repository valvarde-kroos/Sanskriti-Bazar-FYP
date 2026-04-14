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
// Add to cart function
function addToCart(productId) {
    // Check if user is authenticated
    @auth
        // Show loading state
        event.target.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
        event.target.disabled = true;
        
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
                event.target.innerHTML = '<i class="fas fa-check"></i> Added!';
                
                // Reset button after 2 seconds
                setTimeout(() => {
                    event.target.innerHTML = '<i class="fas fa-shopping-cart"></i> Add to Cart';
                    event.target.disabled = false;
                }, 2000);
            } else {
                alert('Error adding product to cart: ' + (data.message || 'Unknown error'));
                event.target.innerHTML = '<i class="fas fa-shopping-cart"></i> Add to Cart';
                event.target.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error adding product to cart. Please try again.');
            event.target.innerHTML = '<i class="fas fa-shopping-cart"></i> Add to Cart';
            event.target.disabled = false;
        });
    @else
        // Redirect to login if not authenticated
        if (confirm('Please login to add products to cart. Would you like to go to the login page?')) {
            window.location.href = '{{ route("login") }}';
        }
    @endauth
}

// Login required function for demo products
function loginRequired() {
    if (confirm('Please login to add products to cart. Would you like to go to the login page?')) {
        window.location.href = '{{ route("login") }}';
    }
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