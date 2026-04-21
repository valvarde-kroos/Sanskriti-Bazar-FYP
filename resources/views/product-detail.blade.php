@extends('layout.main')

@section('hyasabicontentauncha')
<div class="product-detail-page">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('shop.index') }}">Shop</a>
        <span>/</span>
        <a href="{{ route('shop.index', ['category' => $product->category_id]) }}">{{ $product->category->categoryName ?? 'Products' }}</a>
        <span>/</span>
        <span>{{ $product->post_title }}</span>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Product Detail -->
    <div class="product-detail-container">
        <!-- Product Images -->
        <div class="product-images">
            <div class="main-image">
                @if($product->image)
                    <img src="{{ asset('uploads/'.$product->image) }}" alt="{{ $product->post_title }}" id="mainImage">
                @else
                    <div class="no-image-large">
                        <svg width="120" height="120" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                        </svg>
                        <p>No Image Available</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Product Info -->
        <div class="product-details">
            <span class="product-category-badge">{{ $product->category->categoryName ?? 'Uncategorized' }}</span>
            <h1>{{ $product->post_title }}</h1>
            
            <div class="product-meta">
                <span class="vendor-info">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                    Sold by: <strong>{{ $product->user->name }}</strong>
                </span>
                <span class="stock-status {{ $product->quantity > 0 ? 'in-stock' : 'out-of-stock' }}">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                        @if($product->quantity > 0)
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        @else
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        @endif
                    </svg>
                    @if($product->quantity > 0)
                        {{ $product->quantity }} in Stock
                    @else
                        Out of Stock
                    @endif
                </span>
            </div>

            <div class="product-price-section">
                <h2 class="product-price">Rs. {{ number_format($product->price ?? 0, 2) }}</h2>
            </div>

            <div class="product-description">
                <h3>Description</h3>
                <p>{{ $product->post_description }}</p>
            </div>

            <!-- Quantity Selector & Actions -->
            @auth
                @if($product->quantity > 0)
                    <div class="product-purchase">
                        <div class="quantity-selector">
                            <label>Quantity:</label>
                            <div class="quantity-controls">
                                <button type="button" onclick="decreaseQuantity()" id="decreaseBtn">-</button>
                                <input type="number" id="quantity" value="1" min="1" max="{{ $product->quantity }}" readonly>
                                <button type="button" onclick="increaseQuantity()" id="increaseBtn">+</button>
                            </div>
                            <span class="stock-info">Available: {{ $product->quantity }}</span>
                        </div>

                        <div class="action-buttons">
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" id="addToCartForm">
                                @csrf
                                <input type="hidden" name="quantity" id="cartQuantity" value="1">
                                <button type="submit" class="btn-add-to-cart">
                                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                                    </svg>
                                    Add to Cart
                                </button>
                            </form>

                            <form action="{{ route('buy.now') }}" method="POST" id="buyNowForm">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" id="buyQuantity" value="1">
                                <button type="submit" class="btn-buy-now">
                                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                    Buy Now
                                </button>
                            </form>

                            <button type="button" class="btn-wishlist-detail {{ $isLiked ? 'active' : '' }}" onclick="toggleWishlist({{ $product->id }}, this)">
                                <svg width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                @else
                    <div class="out-of-stock-message">
                        <p class="stock-warning">This product is currently out of stock</p>
                        <button type="button" class="btn-wishlist-detail {{ $isLiked ? 'active' : '' }}" onclick="toggleWishlist({{ $product->id }}, this)">
                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                            </svg>
                            Add to Wishlist
                        </button>
                    </div>
                @endif
            @else
                <div class="login-prompt">
                    <p>Please login to purchase this product</p>
                    <a href="{{ route('login') }}" class="btn-login">Login to Continue</a>
                </div>
            @endauth
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="related-products-section">
            <h2>Related Products</h2>
            <div class="related-products-grid">
                @foreach($relatedProducts as $related)
                    <div class="related-product-card">
                        <a href="{{ route('shop.product', $related->id) }}">
                            @if($related->image)
                                <img src="{{ asset('uploads/'.$related->image) }}" alt="{{ $related->post_title }}">
                            @else
                                <div class="no-image-small">No Image</div>
                            @endif
                            <h4>{{ $related->post_title }}</h4>
                            <p class="related-price">Rs. {{ number_format($related->price ?? 0, 2) }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
const maxStock = {{ $product->quantity }};

function increaseQuantity() {
    const input = document.getElementById('quantity');
    const increaseBtn = document.getElementById('increaseBtn');
    const currentValue = parseInt(input.value);
    
    if (currentValue < maxStock) {
        input.value = currentValue + 1;
        updateHiddenQuantities();
        
        // Disable increment button if we've reached max stock
        if (currentValue + 1 >= maxStock) {
            increaseBtn.disabled = true;
            increaseBtn.style.opacity = '0.5';
            increaseBtn.style.cursor = 'not-allowed';
        }
        
        // Enable decrease button
        const decreaseBtn = document.getElementById('decreaseBtn');
        decreaseBtn.disabled = false;
        decreaseBtn.style.opacity = '1';
        decreaseBtn.style.cursor = 'pointer';
    }
}

function decreaseQuantity() {
    const input = document.getElementById('quantity');
    const decreaseBtn = document.getElementById('decreaseBtn');
    const currentValue = parseInt(input.value);
    
    if (currentValue > 1) {
        input.value = currentValue - 1;
        updateHiddenQuantities();
        
        // Disable decrease button if we've reached minimum (1)
        if (currentValue - 1 <= 1) {
            decreaseBtn.disabled = true;
            decreaseBtn.style.opacity = '0.5';
            decreaseBtn.style.cursor = 'not-allowed';
        }
        
        // Enable increase button
        const increaseBtn = document.getElementById('increaseBtn');
        increaseBtn.disabled = false;
        increaseBtn.style.opacity = '1';
        increaseBtn.style.cursor = 'pointer';
    }
}

function updateHiddenQuantities() {
    const quantity = document.getElementById('quantity').value;
    document.getElementById('cartQuantity').value = quantity;
    document.getElementById('buyQuantity').value = quantity;
}

// Initialize button states on page load
document.addEventListener('DOMContentLoaded', function() {
    const decreaseBtn = document.getElementById('decreaseBtn');
    const increaseBtn = document.getElementById('increaseBtn');
    
    // Initially disable decrease button since we start at quantity 1
    if (decreaseBtn) {
        decreaseBtn.disabled = true;
        decreaseBtn.style.opacity = '0.5';
        decreaseBtn.style.cursor = 'not-allowed';
    }
    
    // Disable increase button if stock is 1 or less
    if (increaseBtn && maxStock <= 1) {
        increaseBtn.disabled = true;
        increaseBtn.style.opacity = '0.5';
        increaseBtn.style.cursor = 'not-allowed';
    }
});

// Wishlist toggle function
function toggleWishlist(productId, button) {
    // Get CSRF token
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    if (!token) {
        console.error('CSRF token not found');
        return;
    }

    // Disable button during request
    button.disabled = true;
    
    fetch(`/product/${productId}/like`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update button state
            if (data.isLiked) {
                button.classList.add('active');
            } else {
                button.classList.remove('active');
            }
            
            // Update wishlist count in navbar
            const wishlistCountElements = document.querySelectorAll('.wishlist-count');
            wishlistCountElements.forEach(element => {
                const count = data.wishlistCount || 0;
                if (count > 0) {
                    element.textContent = count;
                    element.style.display = 'flex';
                } else {
                    element.style.display = 'none';
                }
            });
            
            // Show success message
            showMessage(data.message, 'success');
        } else {
            showMessage('Error updating wishlist', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage('Error updating wishlist', 'error');
    })
    .finally(() => {
        // Re-enable button
        button.disabled = false;
    });
}

// Function to show messages
function showMessage(message, type) {
    // Create message element
    const messageDiv = document.createElement('div');
    messageDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'}`;
    messageDiv.textContent = message;
    messageDiv.style.position = 'fixed';
    messageDiv.style.top = '20px';
    messageDiv.style.right = '20px';
    messageDiv.style.zIndex = '9999';
    messageDiv.style.padding = '12px 20px';
    messageDiv.style.borderRadius = '8px';
    messageDiv.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
    
    // Add to page
    document.body.appendChild(messageDiv);
    
    // Remove after 3 seconds
    setTimeout(() => {
        if (messageDiv.parentNode) {
            messageDiv.parentNode.removeChild(messageDiv);
        }
    }, 3000);
}
</script>
@endsection

<script>
// JavaScript for quantity controls and eSewa payment amount update

// Function to increase quantity
function increaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const maxQuantity = parseInt(quantityInput.getAttribute('max'));
    let currentQuantity = parseInt(quantityInput.value);
    
    // Increase quantity if not at maximum
    if (currentQuantity < maxQuantity) {
        currentQuantity++;
        quantityInput.value = currentQuantity;
        
        // Update hidden quantity fields for forms
        document.getElementById('cartQuantity').value = currentQuantity;
        document.getElementById('buyQuantity').value = currentQuantity;
        
        // Update eSewa payment amount (quantity × product price)
        updateEsewaAmount();
    }
}

// Function to decrease quantity
function decreaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    let currentQuantity = parseInt(quantityInput.value);
    
    // Decrease quantity if greater than 1
    if (currentQuantity > 1) {
        currentQuantity--;
        quantityInput.value = currentQuantity;
        
        // Update hidden quantity fields for forms
        document.getElementById('cartQuantity').value = currentQuantity;
        document.getElementById('buyQuantity').value = currentQuantity;
        
        // Update eSewa payment amount (quantity × product price)
        updateEsewaAmount();
    }
}

// Function to update eSewa payment amount based on quantity
function updateEsewaAmount() {
    const quantity = parseInt(document.getElementById('quantity').value);
    const productPrice = {{ $product->price ?? 0 }}; // Get product price from PHP
    const totalAmount = quantity * productPrice;
    
    // Update the hidden eSewa amount field
    document.getElementById('esewaAmount').value = totalAmount;
    
    // Optional: Update button text to show total amount
    const esewaButton = document.querySelector('.btn-esewa-pay');
    if (esewaButton) {
        esewaButton.innerHTML = `
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
            Pay Rs. ${totalAmount.toLocaleString()} with eSewa
        `;
    }
}

// Function to toggle wishlist (existing function - keeping it)
function toggleWishlist(productId, button) {
    // Add your existing wishlist toggle code here
    console.log('Wishlist toggle for product:', productId);
}

// Initialize eSewa amount when page loads
document.addEventListener('DOMContentLoaded', function() {
    updateEsewaAmount();
});
</script>