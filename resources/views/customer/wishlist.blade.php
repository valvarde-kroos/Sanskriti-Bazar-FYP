@extends('customer.layout.main')

@section('title', 'My Wishlist')

@section('content')
<div class="welcome-section">
    <h1>My Wishlist</h1>
    <p>Your favorite products saved for later</p>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
</div>
@endif

<!-- Wishlist Stats -->
<div class="dashboard-cards">
    <div class="stat-card">
        <div class="card-header">
            <h3>Total Items</h3>
        </div>
        <div class="card-body">
            <div class="card-value">{{ $wishlistItems->count() }}</div>
            <div class="card-subtitle">Products in wishlist</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="card-header">
            <h3>Total Value</h3>
        </div>
        <div class="card-body">
            <div class="card-value">Rs. {{ number_format($wishlistItems->sum('product.price'), 2) }}</div>
            <div class="card-subtitle">Combined value</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="card-header">
            <h3>Categories</h3>
        </div>
        <div class="card-body">
            <div class="card-value">{{ $wishlistItems->pluck('product.category.categoryName')->unique()->count() }}</div>
            <div class="card-subtitle">Different categories</div>
        </div>
    </div>
</div>

<!-- Wishlist Items -->
<div class="section-card">
    <div class="section-header">
        <h2>Wishlist Items</h2>
        @if($wishlistItems->count() > 0)
            <div class="header-actions">
                <button class="action-btn" onclick="clearWishlist()">Clear All</button>
            </div>
        @endif
    </div>
    
    @if($wishlistItems->count() > 0)
        <div class="wishlist-grid">
            @foreach($wishlistItems as $item)
                <div class="wishlist-item" data-item-id="{{ $item->id }}">
                    <div class="item-image">
                        @if($item->product->image)
                            <img src="{{ asset('uploads/' . $item->product->image) }}" alt="{{ $item->product->post_title }}">
                        @else
                            <div class="placeholder-image">
                                <i class="fas fa-music"></i>
                            </div>
                        @endif
                        <button class="remove-btn" onclick="removeFromWishlist({{ $item->product_id }})">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <div class="item-details">
                        <h3 class="item-name">{{ $item->product->post_title }}</h3>
                        <p class="item-category">{{ $item->product->category->categoryName ?? 'Uncategorized' }}</p>
                        <p class="item-vendor">by {{ $item->product->user->name ?? 'Unknown Vendor' }}</p>
                        <div class="item-price">Rs. {{ number_format($item->product->price, 2) }}</div>
                        
                        <div class="item-actions">
                            <a href="{{ route('product.detail', $item->product->id) }}" class="btn-view">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                            <form method="POST" action="{{ route('cart.add') }}" style="display: inline;">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn-cart">
                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-wishlist">
            <div class="empty-icon">
                <i class="fas fa-heart"></i>
            </div>
            <h3>Your wishlist is empty</h3>
            <p>Start adding products you love to your wishlist!</p>
            <a href="{{ route('shop') }}" class="action-btn primary">
                <i class="fas fa-shopping-bag"></i> Browse Products
            </a>
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    .wishlist-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .wishlist-item {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border: 1px solid #f1f3f5;
    }

    .wishlist-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .item-image {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .placeholder-image {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
    }

    .remove-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 30px;
        height: 30px;
        background: rgba(220, 53, 69, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        transition: all 0.3s ease;
    }

    .remove-btn:hover {
        background: #dc3545;
        transform: scale(1.1);
    }

    .item-details {
        padding: 20px;
    }

    .item-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3e50;
        margin: 0 0 8px 0;
        line-height: 1.3;
    }

    .item-category {
        font-size: 0.85rem;
        color: #667eea;
        margin: 0 0 4px 0;
        font-weight: 500;
    }

    .item-vendor {
        font-size: 0.8rem;
        color: #7f8c8d;
        margin: 0 0 12px 0;
    }

    .item-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: #e74c3c;
        margin: 0 0 15px 0;
    }

    .item-actions {
        display: flex;
        gap: 10px;
    }

    .btn-view, .btn-cart {
        flex: 1;
        padding: 8px 12px;
        border: none;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-view {
        background: #f8f9fa;
        color: #495057;
        border: 1px solid #e9ecef;
    }

    .btn-view:hover {
        background: #667eea;
        color: white;
        border-color: #667eea;
        text-decoration: none;
    }

    .btn-cart {
        background: #667eea;
        color: white;
    }

    .btn-cart:hover {
        background: #5a67d8;
        transform: translateY(-1px);
    }

    .empty-wishlist {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon {
        font-size: 4rem;
        color: #e9ecef;
        margin-bottom: 20px;
    }

    .empty-wishlist h3 {
        font-size: 1.5rem;
        color: #2c3e50;
        margin: 0 0 10px 0;
    }

    .empty-wishlist p {
        color: #7f8c8d;
        margin: 0 0 25px 0;
    }

    @media (max-width: 768px) {
        .wishlist-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
        }

        .item-details {
            padding: 15px;
        }

        .item-actions {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    function removeFromWishlist(productId) {
        if (confirm('Are you sure you want to remove this item from your wishlist?')) {
            window.location.href = `/customer/wishlist/remove/${productId}`;
        }
    }

    function clearWishlist() {
        if (confirm('Are you sure you want to clear your entire wishlist?')) {
            // You can implement this functionality later
            alert('Clear wishlist functionality will be implemented soon!');
        }
    }

    // Show success message for cart additions
    document.addEventListener('DOMContentLoaded', function() {
        const cartForms = document.querySelectorAll('form[action*="cart/add"]');
        cartForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                setTimeout(() => {
                    showMessage('Product added to cart successfully!', 'success');
                }, 100);
            });
        });
    });

    function showMessage(message, type = 'success') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
        `;
        
        document.body.appendChild(alertDiv);
        
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 3000);
    }
</script>
@endsection