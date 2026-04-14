@extends('layout.main')

@section('hyasabicontentauncha')
<!-- SHOP PAGE -->
<section class="shop-hero-section">
    <div class="container">
        <div class="shop-hero-content">
            <h1 class="shop-title">“Explore Traditional Nepali Instruments”</h1>
            <p class="shop-subtitle">“Discover handmade instruments from local artisans across Nepal.”</p>
        </div>
    </div>
</section>

<!-- SHOP CONTENT SECTION -->
<section class="shop-content-section">
    <div class="container">
        <!-- Horizontal One-Level Filters -->
        <div class="shop-horizontal-filters">
            <form method="GET" action="{{ route('shop.index') }}" class="one-level-form">
                <div class="one-level-row">
                    <!-- Search Box -->
                    <div class="search-box-container">
                        <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}" class="one-level-search">
                        <button type="submit" class="one-level-search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    
                    <!-- All Categories Dropdown -->
                    <div class="categories-dropdown-container">
                        <select name="category" class="one-level-categories" onchange="this.form.submit()">
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
                    <div class="sort-dropdown-container">
                        <select name="sort" class="one-level-sort" onchange="this.form.submit()">
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
            <!-- Filter Status -->
            @if(request('category') || request('search') || request('sort') != 'newest')
                <div class="filter-status">
                    <div class="filter-status-content">
                        <span class="filter-status-text">
                            @if(request('category'))
                                @php
                                    $selectedCategory = $categories->find(request('category'));
                                @endphp
                                Showing products in: <strong>{{ $selectedCategory ? $selectedCategory->categoryName : 'Unknown Category' }}</strong>
                            @endif
                            @if(request('search'))
                                @if(request('category')) | @endif
                                Search: <strong>"{{ request('search') }}"</strong>
                            @endif
                            @if(request('sort') != 'newest')
                                @if(request('category') || request('search')) | @endif
                                Sorted by: <strong>{{ ucfirst(str_replace('_', ' ', request('sort'))) }}</strong>
                            @endif
                        </span>
                        <a href="{{ route('shop.index') }}" class="clear-filters-btn">Clear All Filters</a>
                    </div>
                </div>
            @endif

            @if($products->count() > 0)
                <div class="products-grid">
                    @foreach($products as $product)
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
                                <div class="product-overlay">
                                    <a href="{{ route('shop.product', $product->id) }}" class="quick-view-btn">View Details</a>
                                </div>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name">{{ $product->post_title }}</h3>
                                <p class="product-vendor">{{ $product->user->name ?? 'Unknown Vendor' }}</p>
                                <div class="product-price">Rs. {{ number_format($product->price ?? 0, 2) }}</div>
                                <div class="product-actions">
                                    @auth
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="add-to-cart-btn">
                                                <i class="fas fa-shopping-cart"></i> Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="add-to-cart-btn">
                                            <i class="fas fa-sign-in-alt"></i> Login to Buy
                                        </a>
                                    @endauth
                                    <a href="{{ route('shop.product', $product->id) }}" class="view-details-btn">View Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                    <div class="pagination-wrapper">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="no-products">
                    <div class="no-products-content">
                        <div class="no-products-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3>No Products Found</h3>
                        <p>We couldn't find any products matching your criteria. Try adjusting your search or filters.</p>
                        <a href="{{ route('shop.index') }}" class="reset-filters-btn">Reset Filters</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<style>
/* SHOP PAGE STYLES */
.shop-hero-section {
    background: linear-gradient(135deg, rgba(102,126,234,0.8) 0%, rgba(118,75,162,0.8) 100%);
    color: white;
    padding: 100px 0 60px;
    text-align: center;
}

.shop-title {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.shop-subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
    font-weight: 500;
}

.shop-content-section {
    padding: 60px 0;
    background: transparent;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* One Level Horizontal Filters */
.shop-horizontal-filters {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    padding: 1.5rem 2rem;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    margin-bottom: 3rem;
    border: 1px solid rgba(255,255,255,0.2);
}

.one-level-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
    width: 100%;
}

.search-box-container {
    position: relative;
    flex: 2;
    max-width: 400px;
}

.one-level-search {
    width: 100%;
    padding: 15px 50px 15px 20px;
    border: 2px solid rgba(255,255,255,0.3);
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    background: rgba(255,255,255,0.9);
    color: #333;
}

.one-level-search:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102,126,234,0.2);
    background: white;
}

.one-level-search::placeholder {
    color: #999;
    font-size: 1rem;
}

.one-level-search-btn {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    background: #667eea;
    color: white;
    border: none;
    padding: 10px 14px;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s;
    font-size: 1rem;
}

.one-level-search-btn:hover {
    background: #5a67d8;
}

.categories-dropdown-container, .sort-dropdown-container {
    flex: 1;
    min-width: 180px;
}

.one-level-categories, .one-level-sort {
    width: 100%;
    padding: 15px 40px 15px 20px;
    border: 2px solid rgba(255,255,255,0.3);
    border-radius: 10px;
    font-size: 1rem;
    background: rgba(255,255,255,0.9);
    color: #333;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 12px center;
    background-repeat: no-repeat;
    background-size: 16px;
}

.one-level-categories:focus, .one-level-sort:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102,126,234,0.2);
    background-color: white;
}

.one-level-categories:hover, .one-level-sort:hover {
    border-color: #667eea;
    background-color: white;
}

/* Products Grid */
.products-section {
    margin-top: 2rem;
}

/* Filter Status */
.filter-status {
    background: rgba(102,126,234,0.1);
    border: 1px solid rgba(102,126,234,0.3);
    border-radius: 12px;
    padding: 1rem 1.5rem;
    margin-bottom: 2rem;
    backdrop-filter: blur(5px);
}

.filter-status-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.filter-status-text {
    color: #FFFFFF;
    font-size: 1rem;
    font-weight: 500;
}

.filter-status-text strong {
    color: #667eea;
    font-weight: 700;
}

.clear-filters-btn {
    background: rgba(255,255,255,0.2);
    color: #FFFFFF;
    padding: 8px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 600;
    transition: all 0.3s;
    border: 1px solid rgba(255,255,255,0.3);
}

.clear-filters-btn:hover {
    background: rgba(255,255,255,0.3);
    transform: translateY(-1px);
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 2.5rem;
    margin-bottom: 3rem;
}

.product-card {
    background: rgba(255,255,255,0.1);
    border-radius: 20px;
    overflow: hidden;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
}

.product-image {
    position: relative;
    height: 260px;
    overflow: hidden;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.product-card:hover .product-image img {
    transform: scale(1.05);
}

.no-image {
    width: 100%;
    height: 100%;
    background: rgba(255,255,255,0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #FFFFFF;
    gap: 15px;
}

.no-image i {
    font-size: 3.5rem;
    opacity: 0.7;
}

.no-image span {
    font-weight: 600;
    font-size: 1.1rem;
    text-align: center;
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s;
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.quick-view-btn {
    background: white;
    color: #333;
    padding: 12px 24px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
}

.quick-view-btn:hover {
    background: #667eea;
    color: white;
    transform: translateY(-2px);
}

.product-info {
    padding: 2rem;
}

.product-name {
    font-size: 1.4rem;
    font-weight: 700;
    color: #FFFFFF;
    margin-bottom: 0.8rem;
    line-height: 1.3;
}

.product-vendor {
    font-size: 1rem;
    color: #E2E8F0;
    margin-bottom: 1.2rem;
    opacity: 0.8;
}

.product-price {
    font-size: 1.6rem;
    font-weight: 800;
    color: #667eea;
    margin-bottom: 1.5rem;
}

.product-actions {
    display: flex;
    gap: 0.8rem;
}

.add-to-cart-form {
    flex: 1;
}

.add-to-cart-btn, .view-details-btn {
    flex: 1;
    padding: 14px 18px;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    text-align: center;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 1rem;
}

.add-to-cart-btn {
    background: #667eea;
    color: white;
    border: none;
    width: 100%;
}

.add-to-cart-btn:hover {
    background: #5a67d8;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102,126,234,0.4);
}

.view-details-btn {
    background: rgba(255,255,255,0.2);
    color: white;
    border: 1px solid rgba(255,255,255,0.3);
}

.view-details-btn:hover {
    background: rgba(255,255,255,0.3);
    transform: translateY(-2px);
}

/* No Products */
.no-products {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 400px;
}

.no-products-content {
    text-align: center;
    padding: 4rem 2rem;
    background: rgba(255,255,255,0.1);
    border-radius: 20px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
    max-width: 500px;
}

.no-products-icon {
    font-size: 4rem;
    color: rgba(255,255,255,0.6);
    margin-bottom: 1.5rem;
}

.no-products h3 {
    font-size: 1.8rem;
    color: #FFFFFF;
    margin-bottom: 1rem;
    font-weight: 700;
}

.no-products p {
    color: #E2E8F0;
    margin-bottom: 2rem;
    font-size: 1.1rem;
    line-height: 1.6;
}

.reset-filters-btn {
    background: #667eea;
    color: white;
    padding: 15px 30px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
    display: inline-block;
}

.reset-filters-btn:hover {
    background: #5a67d8;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102,126,234,0.4);
}

/* Pagination */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 3rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .shop-title {
        font-size: 2.5rem;
    }

    .shop-subtitle {
        font-size: 1.1rem;
    }

    .shop-horizontal-filters {
        padding: 1.2rem;
    }

    .one-level-row {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }

    .search-box-container, .categories-dropdown-container, .sort-dropdown-container {
        width: 100%;
        max-width: none;
        min-width: auto;
    }

    .products-grid {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
    }

    .product-actions {
        flex-direction: column;
        gap: 0.8rem;
    }
}

@media (max-width: 480px) {
    .shop-hero-section {
        padding: 80px 0 50px;
    }
    
    .shop-content-section {
        padding: 50px 0;
    }

    .shop-horizontal-filters {
        padding: 1rem;
        margin-bottom: 2rem;
    }

    .one-level-search, .one-level-categories, .one-level-sort {
        padding: 12px 35px 12px 15px;
        font-size: 0.95rem;
    }

    .one-level-search-btn {
        padding: 8px 12px;
        font-size: 0.9rem;
    }

    .products-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .product-card {
        margin: 0 auto;
        max-width: 350px;
    }

    .product-info {
        padding: 1.5rem;
    }
}
</style>

@section('scripts')
<script>
    // Enhanced shop page functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Add to cart functionality
        const addToCartForms = document.querySelectorAll('.add-to-cart-form');
        
        addToCartForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const button = form.querySelector('.add-to-cart-btn');
                const originalText = button.innerHTML;
                
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
                button.disabled = true;
                
                // Re-enable button after 2 seconds (in case of success/error)
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.disabled = false;
                }, 2000);
            });
        });

        // Enhanced dropdown functionality
        const categorySelect = document.querySelector('.one-level-categories');
        const sortSelect = document.querySelector('.one-level-sort');
        
        if (categorySelect) {
            categorySelect.addEventListener('change', function() {
                console.log('Category changed to:', this.value);
                // Form will auto-submit due to onchange attribute
            });
        }
        
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                console.log('Sort changed to:', this.value);
                // Form will auto-submit due to onchange attribute
            });
        }

        // Debug: Log categories count
        const categoryOptions = document.querySelectorAll('.one-level-categories option');
        console.log('Categories loaded in dropdown:', categoryOptions.length - 1); // -1 for "All Categories"
        
        categoryOptions.forEach((option, index) => {
            if (index > 0) { // Skip "All Categories"
                console.log('Category option:', option.value, '-', option.textContent);
            }
        });

        console.log('Shop page loaded successfully with one-level layout!');
    });
</script>
@endsection
@endsection