@extends('layout.main')

@section('hyasabicontentauncha')
<div class="shop-page">
    <!-- Shop Header -->
    <div class="shop-header">
        <div class="shop-title">
            <h1>Sanskriti Bazar</h1>
            <p>Discover authentic Nepali products</p>
        </div>
        
        <!-- Search Bar -->
        <div class="search-container">
            <form action="{{ route('shop.index') }}" method="GET" class="search-form">
                <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}">
                <button type="submit">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <div class="shop-container">
        <!-- Sidebar Filters -->
        <aside class="shop-sidebar">
            <div class="filter-section">
                <h3>Filters</h3>
                
                <form action="{{ route('shop.index') }}" method="GET" id="filterForm">
                    <!-- Preserve search query -->
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    
                    <!-- Category Filter -->
                    <div class="filter-group">
                        <h4>Category</h4>
                        <div class="filter-options">
                            <label class="filter-option">
                                <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()">
                                <span>All Categories</span>
                            </label>
                            @foreach($categories as $category)
                                <label class="filter-option">
                                    <input type="radio" name="category" value="{{ $category->id }}" {{ request('category') == $category->id ? 'checked' : '' }} onchange="this.form.submit()">
                                    <span>{{ $category->categoryName }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Price Filter -->
                    <div class="filter-group">
                        <h4>Price Range</h4>
                        <div class="price-inputs">
                            <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}" min="0">
                            <span>-</span>
                            <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}" min="0">
                        </div>
                        <button type="submit" class="btn-apply-filter">Apply</button>
                    </div>
                    
                    <!-- Clear Filters -->
                    @if(request()->hasAny(['category', 'min_price', 'max_price', 'search']))
                        <a href="{{ route('shop.index') }}" class="btn-clear-filters">Clear All Filters</a>
                    @endif
                </form>
            </div>
        </aside>

        <!-- Products Section -->
        <div class="shop-content">
            <!-- Toolbar -->
            <div class="shop-toolbar">
                <div class="results-count">
                    <p>Showing {{ $products->count() }} of {{ $products->total() }} products</p>
                </div>
                
                <!-- Sort Options -->
                <div class="sort-options">
                    <label>Sort by:</label>
                    <select name="sort" onchange="window.location.href=updateQueryString('sort', this.value)">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                </div>
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
                <div class="products-grid">
                    @foreach($products as $product)
                        <div class="product-card">
                            <a href="{{ route('shop.product', $product->id) }}" class="product-image-link">
                                @if($product->image)
                                    <img src="{{ asset('uploads/'.$product->image) }}" alt="{{ $product->post_title }}">
                                @else
                                    <div class="no-product-image">
                                        <svg width="48" height="48" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Stock Badge -->
                                <span class="stock-badge in-stock">In Stock</span>
                            </a>
                            
                            <div class="product-info">
                                <span class="product-category">{{ $product->category->categoryName ?? 'Uncategorized' }}</span>
                                <a href="{{ route('shop.product', $product->id) }}" class="product-name">
                                    <h3>{{ $product->post_title }}</h3>
                                </a>
                                <p class="product-price">Rs. {{ number_format($product->price ?? 0, 2) }}</p>
                                
                                <div class="product-actions">
                                    @auth
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST" style="flex: 1;">
                                            @csrf
                                            <button type="submit" class="btn-add-cart">
                                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                                                </svg>
                                                Add to Cart
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('product.like', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-wishlist {{ $product->isLikedBy(auth()->user()) ? 'active' : '' }}">
                                                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="btn-add-cart">
                                            <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                                            </svg>
                                            Login to Buy
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination-container">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @else
                <div class="no-products">
                    <svg width="80" height="80" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <h3>No Products Found</h3>
                    <p>Try adjusting your filters or search terms</p>
                    <a href="{{ route('shop.index') }}" class="btn-primary">Clear Filters</a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function updateQueryString(key, value) {
    const url = new URL(window.location);
    url.searchParams.set(key, value);
    return url.toString();
}
</script>
@endsection
