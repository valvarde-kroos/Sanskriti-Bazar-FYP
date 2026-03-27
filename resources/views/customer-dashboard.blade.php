@extends('layout.main')

@section('hyasabicontentauncha')
<div class="customer-dashboard">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <div class="welcome-content">
            <h1>Welcome back, {{ $customer->name }}!</h1>
            <p>Manage your orders, wishlist, and profile from your dashboard</p>
        </div>
        <div class="quick-stats">
            <div class="stat-box">
                <div class="stat-icon" style="background: #667eea;">
                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h3>{{ $totalOrders }}</h3>
                    <p>Total Orders</p>
                </div>
            </div>
            <div class="stat-box">
                <div class="stat-icon" style="background: #f59e0b;">
                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h3>{{ $pendingOrders }}</h3>
                    <p>Pending Orders</p>
                </div>
            </div>
            <div class="stat-box">
                <div class="stat-icon" style="background: #10b981;">
                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h3>Rs. {{ number_format($totalSpent, 2) }}</h3>
                    <p>Total Spent</p>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Dashboard Tabs -->
    <div class="dashboard-tabs">
        <button class="tab-btn active" onclick="showTab('orders')">My Orders</button>
        <button class="tab-btn" onclick="showTab('cart')">My Cart ({{ $cartItems->count() }})</button>
        <button class="tab-btn" onclick="showTab('wishlist')">Wishlist ({{ $wishlist->count() }})</button>
        <button class="tab-btn" onclick="showTab('profile')">Profile Settings</button>
    </div>

    <!-- Orders Tab -->
    <div id="orders-tab" class="tab-content active">
        <div class="section-header">
            <h2>My Orders</h2>
            <p>Track and manage your orders</p>
        </div>

        @if($orders->count() > 0)
            <div class="orders-grid">
                @foreach($orders as $order)
                    <div class="order-card">
                        <div class="order-header">
                            <div>
                                <h3>Order #{{ $order->id }}</h3>
                                <p class="order-date">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                            <span class="status-badge status-{{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        
                        <div class="order-body">
                            <div class="order-product">
                                @if($order->product->image)
                                    <img src="{{ asset('uploads/'.$order->product->image) }}" alt="{{ $order->product->post_title }}">
                                @else
                                    <div class="no-image">No Image</div>
                                @endif
                                <div class="product-info">
                                    <h4>{{ $order->product->post_title }}</h4>
                                    <p>Vendor: {{ $order->product->user->name }}</p>
                                    <p>Quantity: {{ $order->quantity }}</p>
                                </div>
                            </div>
                            
                            <div class="order-footer">
                                <div class="order-total">
                                    <span>Total:</span>
                                    <strong>Rs. {{ number_format($order->total_price, 2) }}</strong>
                                </div>
                                
                                <!-- Order Tracking -->
                                <div class="order-tracking">
                                    <div class="tracking-step {{ in_array($order->status, ['pending', 'processing', 'completed']) ? 'active' : '' }}">
                                        <div class="step-icon">✓</div>
                                        <span>Pending</span>
                                    </div>
                                    <div class="tracking-line {{ in_array($order->status, ['processing', 'completed']) ? 'active' : '' }}"></div>
                                    <div class="tracking-step {{ in_array($order->status, ['processing', 'completed']) ? 'active' : '' }}">
                                        <div class="step-icon">✓</div>
                                        <span>Processing</span>
                                    </div>
                                    <div class="tracking-line {{ $order->status == 'completed' ? 'active' : '' }}"></div>
                                    <div class="tracking-step {{ $order->status == 'completed' ? 'active' : '' }}">
                                        <div class="step-icon">✓</div>
                                        <span>Completed</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <svg width="64" height="64" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                </svg>
                <h3>No Orders Yet</h3>
                <p>Start shopping to see your orders here</p>
                <a href="{{ route('home') }}" class="btn-primary">Browse Products</a>
            </div>
        @endif
    </div>

    <!-- Cart Tab -->
    <div id="cart-tab" class="tab-content">
        <div class="section-header">
            <h2>My Cart</h2>
            <p>Review and manage your cart items</p>
        </div>

        @if($cartItems->count() > 0)
            <div class="cart-container">
                <div class="cart-items">
                    @foreach($cartItems as $item)
                        <div class="cart-item">
                            @if($item->product->image)
                                <img src="{{ asset('uploads/'.$item->product->image) }}" alt="{{ $item->product->post_title }}">
                            @else
                                <div class="no-image-small">No Image</div>
                            @endif
                            
                            <div class="item-details">
                                <h4>{{ $item->product->post_title }}</h4>
                                <p class="item-category">{{ $item->product->category->categoryName ?? 'N/A' }}</p>
                                <p class="item-price">Rs. {{ number_format($item->product->price ?? 0, 2) }}</p>
                            </div>
                            
                            <div class="item-quantity">
                                <label>Qty:</label>
                                <input type="number" value="{{ $item->quantity }}" min="1" readonly>
                            </div>
                            
                            <div class="item-total">
                                <strong>Rs. {{ number_format(($item->product->price ?? 0) * $item->quantity, 2) }}</strong>
                            </div>
                            
                            <a href="{{ route('cart.remove', $item->id) }}" class="btn-remove" onclick="return confirm('Remove this item?')">
                                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                        </div>
                    @endforeach
                </div>
                
                <div class="cart-summary">
                    <h3>Cart Summary</h3>
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <strong>Rs. {{ number_format($cartTotal, 2) }}</strong>
                    </div>
                    <div class="summary-row">
                        <span>Shipping:</span>
                        <strong>Rs. 0.00</strong>
                    </div>
                    <div class="summary-total">
                        <span>Total:</span>
                        <strong>Rs. {{ number_format($cartTotal, 2) }}</strong>
                    </div>
                    <form action="{{ route('order.place') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-checkout">Proceed to Checkout</button>
                    </form>
                </div>
            </div>
        @else
            <div class="empty-state">
                <svg width="64" height="64" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                </svg>
                <h3>Your Cart is Empty</h3>
                <p>Add products to your cart to see them here</p>
                <a href="{{ route('home') }}" class="btn-primary">Start Shopping</a>
            </div>
        @endif
    </div>

    <!-- Wishlist Tab -->
    <div id="wishlist-tab" class="tab-content">
        <div class="section-header">
            <h2>My Wishlist</h2>
            <p>Your favorite products</p>
        </div>

        @if($wishlist->count() > 0)
            <div class="wishlist-grid">
                @foreach($wishlist as $like)
                    <div class="wishlist-card">
                        @if($like->product->image)
                            <img src="{{ asset('uploads/'.$like->product->image) }}" alt="{{ $like->product->post_title }}">
                        @else
                            <div class="no-image-card">No Image</div>
                        @endif
                        
                        <div class="wishlist-info">
                            <h4>{{ $like->product->post_title }}</h4>
                            <p class="product-category">{{ $like->product->category->categoryName ?? 'N/A' }}</p>
                            <p class="product-price">Rs. {{ number_format($like->product->price ?? 0, 2) }}</p>
                            
                            <div class="wishlist-actions">
                                <form action="{{ route('cart.add', $like->product->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-add-cart">Add to Cart</button>
                                </form>
                                <a href="{{ route('customer.wishlist.remove', $like->product->id) }}" class="btn-remove-wishlist" onclick="return confirm('Remove from wishlist?')">
                                    Remove
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <svg width="64" height="64" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                </svg>
                <h3>Your Wishlist is Empty</h3>
                <p>Save your favorite products here</p>
                <a href="{{ route('home') }}" class="btn-primary">Browse Products</a>
            </div>
        @endif
    </div>

    <!-- Profile Tab -->
    <div id="profile-tab" class="tab-content">
        <div class="section-header">
            <h2>Profile Settings</h2>
            <p>Manage your account information</p>
        </div>

        <div class="profile-sections">
            <!-- Update Profile -->
            <div class="profile-card">
                <h3>Personal Information</h3>
                <form action="{{ route('customer.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" value="{{ $customer->name }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" value="{{ $customer->email }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" value="{{ $customer->phone }}" placeholder="Enter phone number">
                    </div>
                    
                    <button type="submit" class="btn-primary">Update Profile</button>
                </form>
            </div>

            <!-- Change Password -->
            <div class="profile-card">
                <h3>Change Password</h3>
                <form action="{{ route('customer.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" name="current_password" required>
                    </div>
                    
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="new_password" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" required>
                    </div>
                    
                    <button type="submit" class="btn-primary">Change Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Show selected tab
    document.getElementById(tabName + '-tab').classList.add('active');
    
    // Add active class to clicked button
    event.target.classList.add('active');
}
</script>
@endsection
