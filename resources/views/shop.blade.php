@extends('layout.main')

@section('hyasabicontentauncha')
<!-- SHOP PAGE -->
<section class="shop-hero-section">
    <div class="container">
        <div class="shop-hero-content">
            <h1 class="shop-title">Explore Traditional Nepali Instruments</h1>
            <p class="shop-subtitle">Discover handmade instruments from local artisans across Nepal</p>
        </div>
    </div>
</section>

<!-- SHOP CONTENT SECTION -->
<section class="shop-content-section">
    <div class="container">
        <!-- Clean Horizontal Filters -->
        <div class="shop-filters">
            <form method="GET" action="{{ route('shop.index') }}" class="filters-form">
                <div class="filters-row">
                    <!-- Search Box -->
                    <div class="search-container">
                        <input type="text" name="search" placeholder="Search instruments..." value="{{ request('search') }}" class="search-input">
                        <button type="submit" class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    
                    <!-- Categories Dropdown -->
                    <div class="filter-container">
                        <select name="category" class="filter-select" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            @if($categories && $categories->count() > 0)
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->categoryName }}
                                    </option>
                                @endforeach
                            @else
                                <option disabled>Loading categories...</option>
                            @endif
                        </select>
                    </div>
                    
                    <!-- Sort Dropdown -->
                    <div class="filter-container">
                        <select name="sort" class="filter-select" onchange="this.form.submit()">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <!-- Products Grid -->
        <div class="products-section">
            @if($products->count() > 0)
                <div class="products-grid">
                    @foreach($products as $product)
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
                                            <button type="submit" class="btn-add-cart">
                                                <i class="fas fa-shopping-cart"></i> Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="btn-login-to-buy">
                                            <i class="fas fa-sign-in-alt"></i> Login to Buy
                                        </a>
                                    @endauth
                                    <a href="{{ route('shop.product', $product->id) }}" class="btn-view-details">View Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="no-products-found">
                    <div class="no-products-content">
                        <i class="fas fa-search no-products-icon"></i>
                        <h3>No Products Found</h3>
                        <p>We couldn't find any products matching your criteria.</p>
                        <a href="{{ route('shop.index') }}" class="btn-reset">Reset Filters</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<style>
/* CLEAN SHOP PAGE STYLES */
.shop-hero-section {
    background: #253A4E;
    color: white;
    padding: 80px 0 60px;
    text-align: center;
}

.shop-title {
    font-size: 2.8rem;
    font-weight: 700;
    margin-bottom: 1rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.shop-subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
    font-weight: 400;
}

.shop-content-section {
    padding: 60px 0;
    background: #f8f9fa;
    min-height: 100vh;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Clean Filters */
.shop-filters {
    background: white;
    padding: 25px 30px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    margin-bottom: 40px;
}

.filters-row {
    display: flex;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
}

.search-container {
    position: relative;
    flex: 2;
    min-width: 300px;
}

.search-input {
    width: 100%;
    padding: 12px 50px 12px 16px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.search-input:focus {
    outline: none;
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.search-btn {
    position: absolute;
    right: 8px;
    top: 50%;
    transform: translateY(-50%);
    background: #667eea;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.search-btn:hover {
    background: #5a67d8;
}

.filter-container {
    flex: 1;
    min-width: 160px;
}

.filter-select {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    background: #f8f9fa;
    cursor: pointer;
    transition: all 0.3s ease;
}

.filter-select:focus {
    outline: none;
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

/* Products Grid */
.products-section {
    margin-top: 20px;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-bottom: 50px;
}

.product-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    border: 1px solid #e2e8f0;
}

.product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.product-image-container {
    height: 200px;
    overflow: hidden;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image {
    transform: scale(1.05);
}

.no-image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #cbd5e0;
    font-size: 3rem;
}

.product-details {
    padding: 20px;
}

.product-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 8px;
    line-height: 1.3;
}

.product-vendor {
    font-size: 0.9rem;
    color: #718096;
    margin-bottom: 12px;
}

.product-price {
    font-size: 1.4rem;
    font-weight: 700;
    color: #667eea;
    margin-bottom: 20px;
}

.product-buttons {
    display: flex;
    gap: 10px;
}

.add-cart-form {
    flex: 1;
}

.btn-add-cart, .btn-login-to-buy, .btn-view-details {
    width: 100%;
    padding: 10px 16px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

.btn-add-cart {
    background: #667eea;
    color: white;
    flex: 1;
}

.btn-add-cart:hover {
    background: #5a67d8;
    transform: translateY(-1px);
}

.btn-login-to-buy {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    flex: 1;
}

.btn-login-to-buy:hover {
    background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
    transform: translateY(-1px);
}

.btn-view-details {
    background: #f7fafc;
    color: #4a5568;
    border: 1px solid #e2e8f0;
    flex: 1;
}

.btn-view-details:hover {
    background: #edf2f7;
    border-color: #cbd5e0;
}

/* No Products */
.no-products-found {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 400px;
}

.no-products-content {
    text-align: center;
    padding: 60px 40px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    max-width: 400px;
}

.no-products-icon {
    font-size: 4rem;
    color: #cbd5e0;
    margin-bottom: 20px;
}

.no-products-content h3 {
    font-size: 1.5rem;
    color: #2d3748;
    margin-bottom: 12px;
    font-weight: 600;
}

.no-products-content p {
    color: #718096;
    margin-bottom: 30px;
    line-height: 1.6;
}

.btn-reset {
    background: #667eea;
    color: white;
    padding: 12px 24px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-block;
}

.btn-reset:hover {
    background: #5a67d8;
    transform: translateY(-1px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .shop-title {
        font-size: 2.2rem;
    }

    .shop-filters {
        padding: 20px;
    }

    .filters-row {
        flex-direction: column;
        gap: 15px;
        align-items: stretch;
    }

    .search-container, .filter-container {
        width: 100%;
        min-width: auto;
    }

    .products-grid {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .product-buttons {
        flex-direction: column;
        gap: 8px;
    }
}

@media (max-width: 480px) {
    .shop-hero-section {
        padding: 60px 0 40px;
    }

    .shop-content-section {
        padding: 40px 0;
    }

    .container {
        padding: 0 15px;
    }

    .products-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .product-details {
        padding: 16px;
    }
}
</style>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add to cart functionality with loading state
    const addToCartForms = document.querySelectorAll('.add-cart-form');
    
    addToCartForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const button = form.querySelector('.btn-add-cart');
            const originalText = button.innerHTML;
            
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
            button.disabled = true;
            
            // Re-enable button after 2 seconds and update cart count
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
                updateCartCount(); // Update cart count after adding item
            }, 2000);
        });
    });

    console.log('Clean shop page loaded successfully!');
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
@endsection