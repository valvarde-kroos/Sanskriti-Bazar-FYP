@extends('customer.layout.main')

@section('title', 'My Wishlist - Sanskriti Bazar')

@section('content')
<div class="wishlist-page">
    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <div class="header-content">
                <div class="header-text">
                    <h1><i class="fas fa-heart"></i> My Wishlist</h1>
                    <p class="subtitle">Your favorite traditional musical instruments</p>
                </div>
                <div class="header-stats">
                    <span class="wishlist-badge">{{ $totalItems }} {{ Str::plural('item', $totalItems) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Wishlist Content -->
    <div class="container">
        @if($wishlistItems->count() > 0)
            <!-- Wishlist Items Grid -->
            <div class="wishlist-grid">
                @foreach($wishlistItems as $wishlistItem)
                    @php
                        $product = $wishlistItem->product;
                    @endphp
                    
                    <div class="wishlist-card" data-product-id="{{ $product->id }}">
                        <!-- Product Image -->
                        <div class="product-image">
                            <img src="{{ asset('uploads/' . $product->image) }}" 
                                 alt="{{ $product->post_title }}" 
                                 onerror="this.src='{{ asset('uploads/instruments.jpg') }}'">
                            
                            <!-- Remove from Wishlist Button -->
                            <button class="remove-wishlist-btn" 
                                    onclick="removeFromWishlist({{ $product->id }})"
                                    title="Remove from wishlist">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <!-- Product Details -->
                        <div class="product-details">
                            <div class="product-category">
                                <i class="fas fa-music"></i>
                                {{ $product->category->categoryName ?? 'Musical Instrument' }}
                            </div>
                            
                            <h3 class="product-title">
                                <a href="{{ route('shop.product', $product->id) }}">
                                    {{ $product->post_title }}
                                </a>
                            </h3>
                            
                            <p class="product-description">
                                {{ Str::limit($product->post_description, 100) }}
                            </p>
                            
                            <div class="product-price">
                                <span class="current-price">Rs. {{ number_format($product->price, 2) }}</span>
                            </div>
                            
                            <!-- Stock Status -->
                            <div class="stock-status">
                                @if($product->quantity > 0)
                                    <span class="in-stock">
                                        <i class="fas fa-check-circle"></i>
                                        In Stock ({{ $product->quantity }} available)
                                    </span>
                                @else
                                    <span class="out-of-stock">
                                        <i class="fas fa-times-circle"></i>
                                        Out of Stock
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Added Date -->
                            <div class="added-date">
                                <i class="fas fa-calendar-alt"></i>
                                Added {{ $wishlistItem->created_at->diffForHumans() }}
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="product-actions">
                            @if($product->quantity > 0)
                                <button class="btn btn-primary move-to-cart-btn" 
                                        onclick="moveToCart({{ $product->id }})">
                                    <i class="fas fa-shopping-cart"></i>
                                    Move to Cart
                                </button>
                            @else
                                <button class="btn btn-secondary" disabled>
                                    <i class="fas fa-ban"></i>
                                    Out of Stock
                                </button>
                            @endif
                            
                            <a href="{{ route('shop.product', $product->id) }}" 
                               class="btn btn-outline-primary">
                                <i class="fas fa-eye"></i>
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Bulk Actions -->
            <div class="bulk-actions">
                <div class="container">
                    <div class="bulk-actions-content">
                        <div class="bulk-info">
                            <span>{{ $totalItems }} {{ Str::plural('item', $totalItems) }} in your wishlist</span>
                        </div>
                        <div class="bulk-buttons">
                            <button class="btn btn-success" onclick="moveAllToCart()">
                                <i class="fas fa-shopping-cart"></i>
                                Move All to Cart
                            </button>
                            <button class="btn btn-outline-danger" onclick="clearWishlist()">
                                <i class="fas fa-trash"></i>
                                Clear Wishlist
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        @else
            <!-- Empty Wishlist State -->
            <div class="empty-wishlist">
                <div class="empty-content">
                    <div class="empty-icon">
                        <i class="fas fa-heart-broken"></i>
                    </div>
                    <h2>Your wishlist is empty</h2>
                    <p>Start adding your favorite traditional musical instruments to your wishlist!</p>
                    <div class="empty-actions">
                        <a href="{{ route('shop.index') }}" class="btn btn-primary">
                            <i class="fas fa-shopping-bag"></i>
                            Browse Products
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-primary">
                            <i class="fas fa-home"></i>
                            Go to Homepage
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Success/Error Messages Toast -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="wishlistToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="fas fa-heart me-2" style="color: #8b5cf6;"></i>
            <strong class="me-auto">Wishlist</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toastMessage">
            <!-- Message will be inserted here -->
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .wishlist-page {
        background: linear-gradient(135deg, #faf5ff 0%, #f8f9fa 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: white;
        padding: 3rem 0;
        margin-bottom: 3rem;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-text h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
        margin: 0;
    }

    .wishlist-badge {
        background: rgba(255, 255, 255, 0.2);
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 1.1rem;
    }

    /* Wishlist Grid */
    .wishlist-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .wishlist-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
        border-top: 3px solid #8b5cf6;
    }

    .wishlist-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(139, 92, 246, 0.15);
    }

    /* Product Image */
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

    .wishlist-card:hover .product-image img {
        transform: scale(1.05);
    }

    .remove-wishlist-btn {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(139, 92, 246, 0.9);
        color: white;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 2;
    }

    .remove-wishlist-btn:hover {
        background: #8b5cf6;
        transform: scale(1.1);
    }

    /* Product Details */
    .product-details {
        padding: 1.5rem;
    }

    .product-category {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .product-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        line-height: 1.4;
    }

    .product-title a {
        color: #333;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .product-title a:hover {
        color: #8b5cf6;
    }

    .product-description {
        color: #6c757d;
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 1rem;
    }

    .product-price {
        margin-bottom: 1rem;
    }

    .current-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: #28a745;
    }

    /* Stock Status */
    .stock-status {
        margin-bottom: 1rem;
    }

    .in-stock {
        color: #28a745;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .out-of-stock {
        color: #dc3545;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .added-date {
        color: #6c757d;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    /* Action Buttons */
    .product-actions {
        padding: 0 1.5rem 1.5rem;
        display: flex;
        gap: 0.75rem;
    }

    .btn {
        flex: 1;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: #8b5cf6;
        color: white;
        border: 1px solid #8b5cf6;
    }

    .btn-primary:hover {
        background: #7c3aed;
        border-color: #7c3aed;
        transform: translateY(-2px);
    }

    .btn-outline-primary {
        background: transparent;
        color: #8b5cf6;
        border: 1px solid #8b5cf6;
    }

    .btn-outline-primary:hover {
        background: #8b5cf6;
        color: white;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
        border: 1px solid #6c757d;
        cursor: not-allowed;
    }

    /* Bulk Actions */
    .bulk-actions {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .bulk-actions-content {
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .bulk-info {
        font-weight: 500;
        color: #333;
    }

    .bulk-buttons {
        display: flex;
        gap: 1rem;
    }

    .btn-success {
        background: #28a745;
        color: white;
        border: 1px solid #28a745;
    }

    .btn-success:hover {
        background: #218838;
        border-color: #218838;
    }

    .btn-outline-danger {
        background: transparent;
        color: #8b5cf6;
        border: 1px solid #8b5cf6;
    }

    .btn-outline-danger:hover {
        background: #8b5cf6;
        color: white;
    }

    /* Empty Wishlist */
    .empty-wishlist {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-content {
        max-width: 500px;
        margin: 0 auto;
    }

    .empty-icon {
        font-size: 5rem;
        color: #8b5cf6;
        margin-bottom: 2rem;
        opacity: 0.7;
    }

    .empty-wishlist h2 {
        font-size: 2rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 1rem;
    }

    .empty-wishlist p {
        font-size: 1.1rem;
        color: #6c757d;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    .empty-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
    }

    /* Loading States */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }

    .btn.loading {
        position: relative;
    }

    .btn.loading::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .wishlist-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .header-content {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .header-text h1 {
            font-size: 2rem;
        }

        .bulk-actions-content {
            flex-direction: column;
            gap: 1rem;
        }

        .bulk-buttons {
            width: 100%;
        }

        .bulk-buttons .btn {
            flex: 1;
        }

        .empty-actions {
            flex-direction: column;
        }

        .product-actions {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    // CSRF Token for AJAX requests
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Show toast message
    function showToast(message, type = 'success') {
        const toast = document.getElementById('wishlistToast');
        const toastMessage = document.getElementById('toastMessage');
        
        toastMessage.textContent = message;
        
        // Update toast styling based on type
        const toastHeader = toast.querySelector('.toast-header');
        if (type === 'success') {
            toastHeader.className = 'toast-header bg-purple text-white';
            toastHeader.style.background = 'linear-gradient(135deg, #8b5cf6, #7c3aed)';
        } else {
            toastHeader.className = 'toast-header bg-danger text-white';
        }
        
        // Show toast
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
    }

    // Remove product from wishlist
    function removeFromWishlist(productId) {
        const card = document.querySelector(`[data-product-id="${productId}"]`);
        card.classList.add('loading');

        fetch('/wishlist/remove', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                product_id: productId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove card with animation
                card.style.transform = 'scale(0)';
                card.style.opacity = '0';
                
                setTimeout(() => {
                    card.remove();
                    
                    // Update wishlist count
                    updateWishlistCount(data.wishlist_count);
                    
                    // Check if wishlist is empty
                    if (data.wishlist_count === 0) {
                        location.reload();
                    }
                }, 300);
                
                showToast(data.message, 'success');
            } else {
                card.classList.remove('loading');
                showToast(data.message, 'error');
            }
        })
        .catch(error => {
            card.classList.remove('loading');
            showToast('An error occurred. Please try again.', 'error');
            console.error('Error:', error);
        });
    }

    // Move product to cart
    function moveToCart(productId) {
        const button = document.querySelector(`[data-product-id="${productId}"] .move-to-cart-btn`);
        const originalText = button.innerHTML;
        
        button.classList.add('loading');
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Moving...';
        button.disabled = true;

        fetch('/wishlist/move-to-cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                product_id: productId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove card from wishlist
                const card = document.querySelector(`[data-product-id="${productId}"]`);
                card.style.transform = 'scale(0)';
                card.style.opacity = '0';
                
                setTimeout(() => {
                    card.remove();
                    
                    // Update counts
                    updateWishlistCount(data.wishlist_count);
                    updateCartCount(data.cart_count);
                    
                    // Check if wishlist is empty
                    if (data.wishlist_count === 0) {
                        location.reload();
                    }
                }, 300);
                
                showToast(data.message, 'success');
            } else {
                button.classList.remove('loading');
                button.innerHTML = originalText;
                button.disabled = false;
                showToast(data.message, 'error');
            }
        })
        .catch(error => {
            button.classList.remove('loading');
            button.innerHTML = originalText;
            button.disabled = false;
            showToast('An error occurred. Please try again.', 'error');
            console.error('Error:', error);
        });
    }

    // Move all items to cart
    function moveAllToCart() {
        if (!confirm('Are you sure you want to move all items to cart?')) {
            return;
        }

        const productIds = Array.from(document.querySelectorAll('[data-product-id]'))
            .map(card => card.getAttribute('data-product-id'));

        if (productIds.length === 0) {
            return;
        }

        // Move each product to cart
        let completed = 0;
        productIds.forEach(productId => {
            moveToCart(productId);
        });
    }

    // Clear entire wishlist
    function clearWishlist() {
        if (!confirm('Are you sure you want to clear your entire wishlist? This action cannot be undone.')) {
            return;
        }

        const productIds = Array.from(document.querySelectorAll('[data-product-id]'))
            .map(card => card.getAttribute('data-product-id'));

        if (productIds.length === 0) {
            return;
        }

        // Remove each product from wishlist
        productIds.forEach(productId => {
            removeFromWishlist(productId);
        });
    }

    // Update wishlist count in navigation
    function updateWishlistCount(count) {
        const wishlistCounters = document.querySelectorAll('.wishlist-counter');
        wishlistCounters.forEach(counter => {
            counter.textContent = count;
        });
    }

    // Update cart count in navigation
    function updateCartCount(count) {
        const cartCounters = document.querySelectorAll('.cart-counter');
        cartCounters.forEach(counter => {
            counter.textContent = count;
        });
    }

    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
        // Add smooth animations to cards
        const cards = document.querySelectorAll('.wishlist-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>
@endsection