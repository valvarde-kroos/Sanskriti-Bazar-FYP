@extends('layout.main')

@section('hyasabicontentauncha')
<!-- SHOP PAGE CONTENT -->
<section class="shop-section">
    <div class="container">
        <div class="shop-header">
            <h1 class="shop-title">Our Shop</h1>
            <p class="shop-subtitle">Discover authentic Nepali musical instruments and handicrafts</p>
        </div>

        <!-- Search and Filters -->
        <div class="shop-filters">
            <form method="GET" action="{{ route('shop.index') }}" class="filter-form">
                <div class="filter-row">
                    <div class="search-box">
                        <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}" class="search-input">
                        <button type="submit" class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    
                    <div class="filter-group">
                        <select name="category" class="filter-select">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <select name="sort" class="filter-select">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="filter-btn">Filter</button>
                </div>
            </form>
        </div>

        <!-- Products Grid -->
        <div class="products-section">
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
                                        <span>No Image</span>
                                    </div>
                                @endif
                                <div class="product-overlay">
                                    <a href="{{ route('shop.product', $product->id) }}" class="quick-view-btn">View Details</a>
                                </div>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name">{{ $product->post_title }}</h3>
                                <p class="product-vendor">by {{ $product->user->name ?? 'Unknown Vendor' }}</p>
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
                    <div class="no-products-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3>No Products Found</h3>
                    <p>We couldn't find any products matching your criteria. Try adjusting your search or filters.</p>
                    <a href="{{ route('shop.index') }}" class="reset-filters-btn">Reset Filters</a>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    /* SHOP PAGE STYLES */
    .shop-section {
        padding: 40px 0;
        background: #f8f9fa;
        min-height: 80vh;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Shop Header */
    .shop-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .shop-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 1rem;
    }

    .shop-subtitle {
        font-size: 1.1rem;
        color: #7f8c8d;
    }

    /* Filters */
    .shop-filters {
        background: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
    }

    .filter-row {
        display: flex;
        gap: 1rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .search-box {
        flex: 2;
        position: relative;
        min-width: 250px;
    }

    .search-input {
        width: 100%;
        padding: 12px 50px 12px 15px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.3s;
    }

    .search-input:focus {
        outline: none;
        border-color: #ff4757;
    }

    .search-btn {
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translateY(-50%);
        background: #ff4757;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .search-btn:hover {
        background: #ff3742;
    }

    .filter-group {
        flex: 1;
        min-width: 150px;
    }

    .filter-select {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 1rem;
        background: white;
        cursor: pointer;
        transition: border-color 0.3s;
    }

    .filter-select:focus {
        outline: none;
        border-color: #ff4757;
    }

    .filter-btn {
        background: #ff4757;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        white-space: nowrap;
    }

    .filter-btn:hover {
        background: #ff3742;
        transform: translateY(-1px);
    }

    /* Products Grid */
    .products-section {
        margin-top: 2rem;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .product-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }

    .product-image {
        position: relative;
        height: 220px;
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
        background: #f8f9fa;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
        gap: 10px;
    }

    .no-image i {
        font-size: 3rem;
    }

    .no-image span {
        font-weight: 600;
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
        padding: 10px 20px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
    }

    .quick-view-btn:hover {
        background: #ff4757;
        color: white;
    }

    .product-info {
        padding: 1.5rem;
    }

    .product-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .product-vendor {
        font-size: 0.9rem;
        color: #7f8c8d;
        margin-bottom: 1rem;
    }

    .product-price {
        font-size: 1.3rem;
        font-weight: 700;
        color: #ff4757;
        margin-bottom: 1rem;
    }

    .product-actions {
        display: flex;
        gap: 0.5rem;
    }

    .add-to-cart-form {
        flex: 1;
    }

    .add-to-cart-btn, .view-details-btn {
        flex: 1;
        padding: 10px 15px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
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
        border: none;
        width: 100%;
    }

    .add-to-cart-btn:hover {
        background: #ff3742;
        transform: translateY(-1px);
    }

    .view-details-btn {
        background: #f8f9fa;
        color: #333;
        border: 1px solid #e9ecef;
    }

    .view-details-btn:hover {
        background: #e9ecef;
    }

    /* No Products */
    .no-products {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .no-products-icon {
        font-size: 4rem;
        color: #e9ecef;
        margin-bottom: 1.5rem;
    }

    .no-products h3 {
        font-size: 1.5rem;
        color: #2c3e50;
        margin-bottom: 1rem;
    }

    .no-products p {
        color: #7f8c8d;
        margin-bottom: 2rem;
        font-size: 1.1rem;
    }

    .reset-filters-btn {
        background: #ff4757;
        color: white;
        padding: 12px 25px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-block;
    }

    .reset-filters-btn:hover {
        background: #ff3742;
        transform: translateY(-1px);
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
            font-size: 2rem;
        }

        .filter-row {
            flex-direction: column;
            align-items: stretch;
        }

        .search-box,
        .filter-group {
            min-width: auto;
            width: 100%;
        }

        .products-grid {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .product-actions {
            flex-direction: column;
        }
    }

    @media (max-width: 480px) {
        .shop-filters {
            padding: 1.5rem;
        }

        .products-grid {
            grid-template-columns: 1fr;
        }

        .product-card {
            margin: 0 auto;
            max-width: 300px;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    // Add to cart functionality
    document.addEventListener('DOMContentLoaded', function() {
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
    });

    console.log('Shop page loaded successfully!');
</script>
@endsection