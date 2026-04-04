@extends('customer.layout.main')

@section('title', 'Shopping Cart')

@section('content')
<div class="welcome-section">
    <h1>Shopping Cart</h1>
    <p>Review your selected items before checkout</p>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if(session('delete'))
    <div class="alert alert-info">
        {{ session('delete') }}
    </div>
@endif

@if($cartItems->count() > 0)
    <div class="cart-layout">
        <!-- Cart Items -->
        <div class="section-card">
            <div class="section-header">
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
                            <span class="total-value">Rs. {{ number_format(($item->product->price ?? 0) * $item->quantity, 2) }}</span>
                        </div>

                        <div class="item-actions">
                            <a href="{{ route('cart.remove', $item->product_id) }}" 
                               class="action-btn small" 
                               style="background: #fee2e2; color: #dc2626; border-color: #fca5a5;"
                               onclick="return confirm('Are you sure you want to remove this item from your cart?')">
                                Remove
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Cart Summary -->
        <div class="section-card">
            <div class="section-header">
                <h2>Order Summary</h2>
            </div>
            
            <div class="summary-details">
                <div class="summary-row">
                    <span class="summary-label">Items ({{ $cartItems->count() }}):</span>
                    <span class="summary-value">Rs. {{ number_format($cartItems->sum(function($item) { return ($item->product->price ?? 0) * $item->quantity; }), 2) }}</span>
                </div>
                
                <div class="summary-row">
                    <span class="summary-label">Shipping:</span>
                    <span class="summary-value">Free</span>
                </div>
                
                <div class="summary-divider"></div>
                
                <div class="summary-row total-row">
                    <span class="summary-label">Total:</span>
                    <span class="summary-value">Rs. {{ number_format($cartItems->sum(function($item) { return ($item->product->price ?? 0) * $item->quantity; }), 2) }}</span>
                </div>
            </div>

            <div class="checkout-section">
                <a href="{{ route('checkout') }}" class="action-btn primary" style="width: 100%; text-align: center; margin-bottom: 10px;">
                    Proceed to Checkout
                </a>
                
                <a href="{{ route('shop.index') }}" class="action-btn" style="width: 100%; text-align: center;">
                    Continue Shopping
                </a>
            </div>

            <!-- Security Info -->
            <div class="security-info">
                <div class="security-item">
                    <span>🛡️ Secure Checkout</span>
                </div>
                <div class="security-item">
                    <span>🚚 Free Shipping</span>
                </div>
                <div class="security-item">
                    <span>↩️ Easy Returns</span>
                </div>
            </div>
        </div>
    </div>
@else
    <!-- Empty Cart -->
    <div class="section-card" style="text-align: center; padding: 60px 40px;">
        <div class="empty-cart-icon" style="font-size: 4rem; color: #d1d5db; margin-bottom: 20px;">
            🛒
        </div>
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937; margin-bottom: 10px;">Your Cart is Empty</h2>
        <p style="color: #6b7280; margin-bottom: 30px;">Looks like you haven't added any items to your cart yet.</p>
        <a href="{{ route('shop.index') }}" class="action-btn primary">
            Start Shopping
        </a>
    </div>
@endif
@endsection

@section('styles')
<style>
    .cart-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
        align-items: start;
    }

    .cart-items {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .cart-item {
        display: grid;
        grid-template-columns: 120px 1fr auto auto auto;
        gap: 20px;
        padding: 20px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        align-items: center;
        background: #f9fafb;
    }

    .item-image {
        width: 120px;
        height: 120px;
        border-radius: 8px;
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
        color: #3498db;
        font-size: 1rem;
    }

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

    .summary-details {
        margin-bottom: 25px;
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
        color: #3498db;
    }

    .checkout-section {
        margin-bottom: 25px;
    }

    .security-info {
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 8px;
        padding: 15px;
    }

    .security-item {
        padding: 5px 0;
        color: #0369a1;
        font-size: 0.9rem;
        text-align: center;
    }

    @media (max-width: 1024px) {
        .cart-layout {
            grid-template-columns: 1fr;
            gap: 20px;
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
        .cart-item {
            grid-template-columns: 80px 1fr;
            padding: 15px;
        }

        .item-image {
            width: 80px;
            height: 80px;
        }
    }
</style>
@endsection