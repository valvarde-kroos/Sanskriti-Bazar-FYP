@extends('layout.main')

@section('hyasabicontentauncha')
<!-- CART PAGE -->
<div class="cart-page">
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 class="page-title">Shopping Cart</h1>
            <p class="page-subtitle">Review your selected items before checkout</p>
        </div>
    </section>

    <!-- Cart Content -->
    <section class="cart-content">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if(session('delete'))
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    {{ session('delete') }}
                </div>
            @endif

            @if($cartItems->count() > 0)
                <div class="cart-layout">
                    <!-- Cart Items -->
                    <div class="cart-items-section">
                        <div class="cart-header">
                            <h2>Cart Items ({{ $cartItems->count() }})</h2>
                        </div>

                        <div class="cart-items">
                            @foreach($cartItems as $item)
                                <div class="cart-item">
                                    <div class="item-image">
                                        @if($item->product->image)
                                            <img src="{{ asset('uploads/' . $item->product->image) }}" alt="{{ $item->product->post_title }}">
                                        @else
                                            <div class="no-image">
                                                <i class="fas fa-image"></i>
                                                <span>No Image</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="item-details">
                                        <h3 class="item-name">{{ $item->product->post_title }}</h3>
                                        <p class="item-vendor">by {{ $item->product->user->name ?? 'Unknown Vendor' }}</p>
                                        <p class="item-category">{{ $item->product->category->categoryName ?? 'Uncategorized' }}</p>
                                        
                                        <div class="item-price">
                                            <span class="price-label">Price:</span>
                                            <span class="price-value">Rs. {{ number_format($item->product->price ?? 0, 2) }}</span>
                                        </div>
                                    </div>

                                    <div class="item-quantity">
                                        <label class="quantity-label">Quantity:</label>
                                        <div class="quantity-controls">
                                            <form method="POST" action="{{ route('cart.update.quantity', $item->id) }}" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="quantity" value="{{ max(1, $item->quantity - 1) }}">
                                                <button type="submit" 
                                                        class="qty-btn minus" 
                                                        {{ $item->quantity <= 1 ? 'disabled' : '' }}>-</button>
                                            </form>
                                            
                                            <span class="qty-display">{{ $item->quantity }}</span>
                                            
                                            <form method="POST" action="{{ route('cart.update.quantity', $item->id) }}" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="quantity" value="{{ min($item->product->quantity, $item->quantity + 1) }}">
                                                <button type="submit" 
                                                        class="qty-btn plus" 
                                                        {{ $item->quantity >= $item->product->quantity ? 'disabled' : '' }}>+</button>
                                            </form>
                                        </div>
                                        <div class="stock-info">
                                            <small class="stock-text">{{ $item->product->quantity }} available</small>
                                        </div>
                                    </div>

                                    <div class="item-total">
                                        <span class="total-label">Total:</span>
                                        <span class="total-value" id="item-total-{{ $item->id }}">Rs. {{ number_format(($item->product->price ?? 0) * $item->quantity, 2) }}</span>
                                    </div>

                                    <div class="item-actions">
                                        <a href="{{ route('cart.remove', $item->product_id) }}" 
                                           class="remove-btn" 
                                           onclick="return confirm('Are you sure you want to remove this item from your cart?')">
                                            <i class="fas fa-trash"></i>
                                            Remove
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Cart Summary -->
                    <div class="cart-summary-section">
                        <div class="cart-summary">
                            <h3 class="summary-title">Order Summary</h3>
                            
                            <div class="summary-details">
                                <div class="summary-row">
                                    <span class="summary-label">Items ({{ $cartItems->count() }}):</span>
                                    <span class="summary-value" id="cart-subtotal">Rs. {{ number_format($cartItems->sum(function($item) { return ($item->product->price ?? 0) * $item->quantity; }), 2) }}</span>
                                </div>
                                
                                <div class="summary-row">
                                    <span class="summary-label">Shipping:</span>
                                    <span class="summary-value">Free</span>
                                </div>
                                
                                <div class="summary-divider"></div>
                                
                                <div class="summary-row total-row">
                                    <span class="summary-label">Total:</span>
                                    <span class="summary-value" id="cart-total">Rs. {{ number_format($cartItems->sum(function($item) { return ($item->product->price ?? 0) * $item->quantity; }), 2) }}</span>
                                </div>
                            </div>

                            <div class="checkout-section">
                                <a href="{{ route('checkout') }}" class="checkout-btn">
                                    Proceed to Checkout
                                </a>
                                
                                <a href="{{ route('shop.index') }}" class="continue-shopping-btn">
                                    Continue Shopping
                                </a>
                            </div>
                        </div>

                        <!-- Security Info -->
                        <div class="security-info">
                            <div class="security-item">
                                <i class="fas fa-shield-alt"></i>
                                <span>Secure Checkout</span>
                            </div>
                            <div class="security-item">
                                <i class="fas fa-truck"></i>
                                <span>Free Shipping</span>
                            </div>
                            <div class="security-item">
                                <i class="fas fa-undo"></i>
                                <span>Easy Returns</span>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty Cart -->
                <div class="empty-cart">
                    <div class="empty-cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h2 class="empty-cart-title">Your Cart is Empty</h2>
                    <p class="empty-cart-message">Looks like you haven't added any items to your cart yet.</p>
                    <a href="{{ route('shop.index') }}" class="shop-now-btn">
                        <i class="fas fa-shopping-bag"></i>
                        Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </section>
</div>
@endsection

@section('styles')
<style>
    /* CART PAGE STYLES */
    .cart-page {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background: #f8f9fa;
        min-height: 100vh;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, #ff4757 0%, #ff3742 100%);
        color: white;
        padding: 60px 0;
        text-align: center;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    /* Alerts */
    .alert {
        padding: 15px 20px;
        margin: 20px 0;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #6ee7b7;
    }

    .alert-info {
        background: #dbeafe;
        color: #1e40af;
        border: 1px solid #93c5fd;
    }

    /* Cart Content */
    .cart-content {
        padding: 40px 0;
    }

    .cart-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 40px;
        align-items: start;
    }

    /* Cart Items Section */
    .cart-items-section {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .cart-header {
        padding: 20px 30px;
        border-bottom: 1px solid #e5e7eb;
        background: #f9fafb;
    }

    .cart-header h2 {
        margin: 0;
        font-size: 1.5rem;
        color: #1f2937;
    }

    .cart-items {
        padding: 0;
    }

    .cart-item {
        display: grid;
        grid-template-columns: 120px 1fr auto auto auto;
        gap: 20px;
        padding: 30px;
        border-bottom: 1px solid #e5e7eb;
        align-items: center;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    /* Item Image */
    .item-image {
        width: 120px;
        height: 120px;
        border-radius: 10px;
        overflow: hidden;
        background: #f3f4f6;
    }

    .item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .no-image {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
        font-size: 0.8rem;
    }

    .no-image i {
        font-size: 2rem;
        margin-bottom: 5px;
    }

    /* Item Details */
    .item-details {
        min-width: 0;
    }

    .item-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 5px;
        line-height: 1.4;
    }

    .item-vendor {
        color: #6b7280;
        font-size: 0.9rem;
        margin-bottom: 3px;
    }

    .item-category {
        color: #9ca3af;
        font-size: 0.8rem;
        margin-bottom: 10px;
    }

    .item-price {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .price-label {
        font-size: 0.9rem;
        color: #6b7280;
    }

    .price-value {
        font-weight: 600;
        color: #ff4757;
        font-size: 1rem;
    }

    /* Quantity Controls */
    .item-quantity {
        text-align: center;
    }

    .quantity-label {
        display: block;
        font-size: 0.9rem;
        color: #6b7280;
        margin-bottom: 8px;
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        overflow: hidden;
    }

    .qty-btn {
        width: 35px;
        height: 35px;
        border: none;
        background: #f9fafb;
        color: #374151;
        cursor: pointer;
        font-weight: 600;
        transition: background 0.2s;
    }

    .qty-btn:hover:not(:disabled) {
        background: #e5e7eb;
    }

    .qty-btn:disabled {
        background: #f3f4f6;
        color: #9ca3af;
        cursor: not-allowed;
    }

    .qty-display {
        width: 50px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        background: white;
        border-left: 1px solid #d1d5db;
        border-right: 1px solid #d1d5db;
    }

    .stock-info {
        margin-top: 5px;
        text-align: center;
    }

    .stock-text {
        color: #6b7280;
        font-size: 0.75rem;
    }

    /* Item Total */
    .item-total {
        text-align: center;
    }

    .total-label {
        display: block;
        font-size: 0.9rem;
        color: #6b7280;
        margin-bottom: 5px;
    }

    .total-value {
        font-weight: 700;
        color: #1f2937;
        font-size: 1.1rem;
    }

    /* Item Actions */
    .remove-btn {
        display: flex;
        align-items: center;
        gap: 5px;
        padding: 8px 15px;
        background: #fee2e2;
        color: #dc2626;
        text-decoration: none;
        border-radius: 6px;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.2s;
    }

    .remove-btn:hover {
        background: #fecaca;
        color: #b91c1c;
    }

    /* Cart Summary Section */
    .cart-summary-section {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .cart-summary {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        padding: 30px;
    }

    .summary-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 20px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .summary-label {
        color: #6b7280;
        font-size: 0.95rem;
    }

    .summary-value {
        font-weight: 600;
        color: #1f2937;
    }

    .summary-divider {
        height: 1px;
        background: #e5e7eb;
        margin: 20px 0;
    }

    .total-row {
        margin-bottom: 0;
        padding-top: 10px;
    }

    .total-row .summary-label {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1f2937;
    }

    .total-row .summary-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: #ff4757;
    }

    /* Checkout Section */
    .checkout-section {
        margin-top: 30px;
    }

    .checkout-btn {
        width: 100%;
        padding: 18px;
        background: #ff4757;
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-decoration: none;
        display: block;
        text-align: center;
    }

    .checkout-btn:hover {
        background: #ff3742;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 71, 87, 0.3);
    }

    .continue-shopping-btn {
        width: 100%;
        padding: 15px;
        background: white;
        color: #374151;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        display: block;
        text-align: center;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .continue-shopping-btn:hover {
        background: #f9fafb;
        border-color: #d1d5db;
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    /* Security Info */
    .security-info {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        padding: 20px;
    }

    .security-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 0;
        color: #6b7280;
        font-size: 0.9rem;
    }

    .security-item i {
        color: #10b981;
        width: 20px;
    }

    /* Empty Cart */
    .empty-cart {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .empty-cart-icon {
        font-size: 4rem;
        color: #d1d5db;
        margin-bottom: 20px;
    }

    .empty-cart-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 10px;
    }

    .empty-cart-message {
        color: #6b7280;
        margin-bottom: 30px;
    }

    .shop-now-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 15px 30px;
        background: #ff4757;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        transition: background 0.3s;
    }

    .shop-now-btn:hover {
        background: #ff3742;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .cart-layout {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .cart-item {
            grid-template-columns: 100px 1fr;
            gap: 15px;
        }

        .item-quantity,
        .item-total,
        .item-actions {
            grid-column: 1 / -1;
            justify-self: start;
            margin-top: 15px;
        }

        .item-quantity {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .quantity-label {
            margin-bottom: 0;
        }
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }

        .cart-item {
            grid-template-columns: 80px 1fr;
            padding: 20px;
        }

        .item-image {
            width: 80px;
            height: 80px;
        }

        .cart-summary {
            padding: 20px;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    // Simple cart count update function
    function updateCartCount() {
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
    }

    // Page load animations and setup
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Cart page loaded - Simple version');
        
        // Add smooth animations to cart items
        const cartItems = document.querySelectorAll('.cart-item');
        cartItems.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            setTimeout(() => {
                item.style.transition = 'all 0.5s ease';
                item.style.opacity = '1';
                item.style.transform = 'translateY(0)';
            }, index * 100);
        });

        // Update cart count on page load
        updateCartCount();
        
        // Add loading state to quantity buttons
        const quantityForms = document.querySelectorAll('.quantity-controls form');
        quantityForms.forEach(form => {
            form.addEventListener('submit', function() {
                const button = this.querySelector('.qty-btn');
                button.disabled = true;
                button.textContent = '...';
                
                // Re-enable after 3 seconds as fallback
                setTimeout(() => {
                    button.disabled = false;
                    button.textContent = button.classList.contains('minus') ? '-' : '+';
                }, 3000);
            });
        });
    });
</script>

<style>
    .alert-error {
        background: #fee2e2;
        color: #dc2626;
        border: 1px solid #fca5a5;
    }
    
    /* Loading state for buttons */
    .qty-btn:disabled {
        background: #f3f4f6 !important;
        color: #9ca3af !important;
        cursor: not-allowed !important;
    }
</style>
@endsection
