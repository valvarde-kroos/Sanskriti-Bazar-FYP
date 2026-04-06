@extends('layout.main')

@section('hyasabicontentauncha')
<div class="checkout-page">
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 class="page-title">Checkout</h1>
            <p class="page-subtitle">Complete your order with shipping details</p>
        </div>
    </section>

    <!-- Checkout Content -->
    <section class="checkout-content">
        <div class="container">
            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div class="checkout-layout">
                <!-- Checkout Form -->
                <div class="checkout-form-section">
                    <div class="form-container">
                        <h2 class="form-title">Shipping Information</h2>
                        
                        <form action="{{ route('order.place') }}" method="POST" id="checkoutForm">
                            @csrf
                            
                            <div class="form-group">
                                <label for="shipping_name">Full Name *</label>
                                <input type="text" 
                                       id="shipping_name" 
                                       name="shipping_name" 
                                       value="{{ old('shipping_name', auth()->user()->name) }}" 
                                       required>
                                @error('shipping_name')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="shipping_address">Complete Address *</label>
                                <textarea id="shipping_address" 
                                          name="shipping_address" 
                                          rows="3" 
                                          placeholder="Enter your complete address including city, area, and landmarks"
                                          required>{{ old('shipping_address') }}</textarea>
                                @error('shipping_address')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="shipping_phone">Phone Number *</label>
                                <input type="tel" 
                                       id="shipping_phone" 
                                       name="shipping_phone" 
                                       value="{{ old('shipping_phone', auth()->user()->phone) }}" 
                                       placeholder="Enter your phone number"
                                       required>
                                @error('shipping_phone')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="payment_method">Payment Method *</label>
                                <select id="payment_method" name="payment_method" required onchange="togglePaymentInfo()">
                                    <option value="">Select Payment Method</option>
                                    <option value="cash_on_delivery" {{ old('payment_method') == 'cash_on_delivery' ? 'selected' : '' }}>Cash on Delivery</option>
                                    <option value="esewa" {{ old('payment_method') == 'esewa' ? 'selected' : '' }}>eSewa</option>
                                </select>
                                @error('payment_method')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-actions">
                                <a href="{{ route('cart') }}" class="btn-back">
                                    <i class="fas fa-arrow-left"></i>
                                    Back to Cart
                                </a>
                                <button type="submit" class="btn-place-order">
                                    <i class="fas fa-check"></i>
                                    Place Order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="order-summary-section">
                    <div class="order-summary">
                        <h3 class="summary-title">Order Summary</h3>
                        
                        <div class="order-items">
                            @foreach($cartItems as $item)
                                <div class="order-item">
                                    <div class="item-image">
                                        @if($item->product->image)
                                            <img src="{{ asset('uploads/' . $item->product->image) }}" alt="{{ $item->product->post_title }}">
                                        @else
                                            <div class="no-image">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="item-details">
                                        <h4>{{ $item->product->post_title }}</h4>
                                        <p class="item-vendor">by {{ $item->product->user->name }}</p>
                                        <div class="item-pricing">
                                            <span class="quantity">Qty: {{ $item->quantity }}</span>
                                            <span class="price">Rs. {{ number_format(($item->product->price ?? 0) * $item->quantity, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="summary-totals">
                            <div class="total-row">
                                <span class="total-label">Subtotal:</span>
                                <span class="total-value">Rs. {{ number_format($cartItems->sum(function($item) { return ($item->product->price ?? 0) * $item->quantity; }), 2) }}</span>
                            </div>
                            <div class="total-row">
                                <span class="total-label">Shipping:</span>
                                <span class="total-value">Free</span>
                            </div>
                            <div class="total-row final-total">
                                <span class="total-label">Total:</span>
                                <span class="total-value">Rs. {{ number_format($cartItems->sum(function($item) { return ($item->product->price ?? 0) * $item->quantity; }), 2) }}</span>
                            </div>
                        </div>

                        <div class="payment-info" id="paymentInfo" style="display: none;">
                            <div class="payment-method" id="paymentMethodDisplay">
                                <i class="fas fa-money-bill-wave" id="paymentIcon"></i>
                                <span id="paymentText">Select a payment method</span>
                            </div>
                            <p class="payment-note" id="paymentNote">Choose your preferred payment option above</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
/* CHECKOUT PAGE STYLES */
.checkout-page {
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
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

/* Alert */
.alert-error {
    background: #fee2e2;
    color: #dc2626;
    border: 1px solid #fca5a5;
    padding: 15px 20px;
    margin: 20px 0;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Checkout Content */
.checkout-content {
    padding: 40px 0;
}

.checkout-layout {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 40px;
    align-items: start;
}

/* Checkout Form Section */
.checkout-form-section {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.form-container {
    padding: 40px;
}

.form-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 2px solid #e5e7eb;
}

.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
    font-size: 0.95rem;
}

.form-group input,
.form-group textarea,
.form-group select {
    width: 100%;
    padding: 15px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #f9fafb;
}

.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus {
    outline: none;
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-group select {
    cursor: pointer;
    appearance: none;
    background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path fill="%23667eea" d="M6 9L1 4h10z"/></svg>');
    background-repeat: no-repeat;
    background-position: right 15px center;
    padding-right: 45px;
}

.form-group textarea {
    resize: vertical;
    min-height: 80px;
}

.error-message {
    color: #dc2626;
    font-size: 0.875rem;
    margin-top: 5px;
    display: block;
}

.form-actions {
    display: flex;
    gap: 15px;
    margin-top: 40px;
    padding-top: 30px;
    border-top: 1px solid #e5e7eb;
}

.btn-back {
    flex: 1;
    padding: 15px 20px;
    background: white;
    color: #6b7280;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.btn-back:hover {
    background: #f9fafb;
    border-color: #d1d5db;
    color: #374151;
}

.btn-place-order {
    flex: 2;
    padding: 15px 20px;
    background: #667eea;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-place-order:hover {
    background: #764ba2;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

/* Order Summary Section */
.order-summary-section {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    padding: 30px;
    height: fit-content;
    position: sticky;
    top: 20px;
}

.summary-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 1px solid #e5e7eb;
}

.order-items {
    margin-bottom: 25px;
}

.order-item {
    display: flex;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid #f3f4f6;
}

.order-item:last-child {
    border-bottom: none;
}

.item-image {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
    background: #f3f4f6;
    flex-shrink: 0;
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
    align-items: center;
    justify-content: center;
    color: #9ca3af;
}

.item-details {
    flex: 1;
    min-width: 0;
}

.item-details h4 {
    font-size: 0.95rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 5px;
    line-height: 1.3;
}

.item-vendor {
    font-size: 0.8rem;
    color: #6b7280;
    margin-bottom: 8px;
}

.item-pricing {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.quantity {
    font-size: 0.85rem;
    color: #6b7280;
}

.price {
    font-weight: 600;
    color: #667eea;
    font-size: 0.95rem;
}

.summary-totals {
    padding: 20px 0;
    border-top: 1px solid #e5e7eb;
    border-bottom: 1px solid #e5e7eb;
    margin-bottom: 20px;
}

.total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.total-row:last-child {
    margin-bottom: 0;
}

.total-label {
    color: #6b7280;
    font-size: 0.95rem;
}

.total-value {
    font-weight: 600;
    color: #1f2937;
}

.final-total {
    padding-top: 15px;
    border-top: 1px solid #e5e7eb;
    margin-top: 15px;
}

.final-total .total-label {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
}

.final-total .total-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: #667eea;
}

.payment-info {
    background: #f0f4ff;
    border: 1px solid #c7d2fe;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
}

.payment-method {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    font-weight: 600;
    color: #4338ca;
    margin-bottom: 8px;
}

.payment-method i {
    font-size: 1.2rem;
}

.payment-note {
    color: #4338ca;
    font-size: 0.9rem;
    margin: 0;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .checkout-layout {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .order-summary-section {
        position: static;
    }
}

@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .form-container {
        padding: 30px 20px;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn-back,
    .btn-place-order {
        flex: none;
    }
}
</style>

<script>
function togglePaymentInfo() {
    const paymentMethod = document.getElementById('payment_method').value;
    const paymentInfo = document.getElementById('paymentInfo');
    const paymentIcon = document.getElementById('paymentIcon');
    const paymentText = document.getElementById('paymentText');
    const paymentNote = document.getElementById('paymentNote');
    
    if (paymentMethod) {
        paymentInfo.style.display = 'block';
        
        if (paymentMethod === 'cash_on_delivery') {
            paymentIcon.className = 'fas fa-money-bill-wave';
            paymentText.textContent = 'Cash on Delivery';
            paymentNote.textContent = 'Pay when your order is delivered to your doorstep';
            paymentInfo.style.background = '#f0f4ff';
            paymentInfo.style.borderColor = '#c7d2fe';
        } else if (paymentMethod === 'esewa') {
            paymentIcon.className = 'fas fa-mobile-alt';
            paymentText.textContent = 'eSewa Digital Payment';
            paymentNote.textContent = 'Pay securely using your eSewa wallet';
            paymentInfo.style.background = '#f0fdf4';
            paymentInfo.style.borderColor = '#bbf7d0';
        }
    } else {
        paymentInfo.style.display = 'none';
    }
}

// Initialize payment info on page load if payment method is already selected
document.addEventListener('DOMContentLoaded', function() {
    togglePaymentInfo();
});
</script>
@endsection