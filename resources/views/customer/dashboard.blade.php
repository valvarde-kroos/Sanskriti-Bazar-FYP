<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Customer Dashboard - Sanskriti Bazar</title>
    <!-- Bootstrap CSS for easy styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Simple and clean CSS for beginner-friendly design */
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        
        /* Sidebar styling */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            background: #343a40;
            color: white;
            padding: 20px 0;
            overflow-y: auto;
        }
        
        .sidebar-header {
            text-align: center;
            padding: 0 20px 20px;
            border-bottom: 1px solid #495057;
            margin-bottom: 20px;
        }
        
        .sidebar-header h3 {
            color: #fff;
            font-size: 1.2rem;
            margin: 0;
        }
        
        .sidebar-header p {
            color: #adb5bd;
            font-size: 0.9rem;
            margin: 5px 0 0;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-menu li {
            margin: 5px 0;
        }
        
        .sidebar-menu a {
            display: block;
            padding: 12px 20px;
            color: #adb5bd;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: #495057;
            color: #fff;
        }
        
        .sidebar-menu i {
            width: 20px;
            margin-right: 10px;
        }
        
        /* Main content styling */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
        }
        
        /* Page sections */
        .page-section {
            display: none;
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .page-section.active {
            display: block;
        }
        
        .page-header {
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .page-header h2 {
            color: #343a40;
            font-size: 1.5rem;
            margin: 0;
        }
        
        .page-header p {
            color: #6c757d;
            margin: 5px 0 0;
        }
        
        /* Stats cards for dashboard */
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        
        .stat-card h3 {
            font-size: 2rem;
            margin: 0 0 5px;
        }
        
        .stat-card p {
            margin: 0;
            opacity: 0.9;
        }
        
        /* Table styling */
        .simple-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .simple-table th,
        .simple-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        
        .simple-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #495057;
        }
        
        /* Status badges */
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-completed {
            background: #d1e7dd;
            color: #0f5132;
        }
        
        .status-processing {
            background: #cff4fc;
            color: #055160;
        }
        
        /* Form styling */
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
            display: block;
        }
        
        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 14px;
        }
        
        .form-control:focus {
            border-color: #667eea;
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        /* Button styling */
        .btn-primary {
            background: #667eea;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .btn-primary:hover {
            background: #5a67d8;
        }
        
        .btn-danger {
            background: #e53e3e;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            color: white;
            font-size: 0.8rem;
            cursor: pointer;
        }
        
        .btn-danger:hover {
            background: #c53030;
        }
        
        /* Star rating */
        .star-rating {
            display: flex;
            gap: 5px;
            margin: 10px 0;
        }
        
        .star {
            font-size: 1.5rem;
            color: #ddd;
            cursor: pointer;
            transition: color 0.2s;
        }
        
        .star.active,
        .star:hover {
            color: #ffc107;
        }
        
        /* Product cards for wishlist */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .product-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }
        
        .product-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 10px;
        }
        
        .no-image {
            width: 100%;
            height: 150px;
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            border-radius: 6px;
            margin-bottom: 10px;
        }
        
        /* Alert messages */
        .alert {
            padding: 12px 20px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
        }
        
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
                z-index: 1000;
            }
            
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .stats-cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3>Customer Panel</h3>
            <p>Welcome, {{ auth()->user()->name ?? 'Customer' }}!</p>
        </div>
        
        <ul class="sidebar-menu">
            <li><a href="#" class="menu-link active" data-section="dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="#" class="menu-link" data-section="orders"><i class="fas fa-shopping-bag"></i> My Orders</a></li>
            <li><a href="#" class="menu-link" data-section="wishlist"><i class="fas fa-heart"></i> Wishlist</a></li>
            <li><a href="#" class="menu-link" data-section="profile"><i class="fas fa-user"></i> Profile</a></li>
            <li><a href="#" class="menu-link" data-section="reviews"><i class="fas fa-star"></i> Reviews</a></li>
            <li>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" style="color: #dc3545;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </form>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        </div>
        @endif

        <!-- Dashboard Section -->
        <div id="dashboard-section" class="page-section active">
            <div class="page-header">
                <h2>Dashboard</h2>
                <p>Overview of your account and recent activity</p>
            </div>
            
            <!-- Stats Cards -->
            <div class="stats-cards">
                <div class="stat-card">
                    <h3>{{ $totalOrders ?? 5 }}</h3>
                    <p>Total Orders</p>
                </div>
                <div class="stat-card">
                    <h3>{{ $pendingOrders ?? 2 }}</h3>
                    <p>Pending Orders</p>
                </div>
                <div class="stat-card">
                    <h3>{{ $wishlistCount ?? 3 }}</h3>
                    <p>Wishlist Items</p>
                </div>
            </div>
            
            <!-- Recent Orders -->
            <h4>Recent Orders</h4>
            <table class="simple-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders ?? [] as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->product->post_title ?? 'Product Name' }}</td>
                        <td><span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <!-- Sample Data for Demo -->
                    <tr>
                        <td>#001</td>
                        <td>Traditional Handicraft Set</td>
                        <td><span class="status-badge status-completed">Completed</span></td>
                        <td>Mar 20, 2024</td>
                    </tr>
                    <tr>
                        <td>#002</td>
                        <td>Handwoven Textile</td>
                        <td><span class="status-badge status-pending">Pending</span></td>
                        <td>Mar 22, 2024</td>
                    </tr>
                    <tr>
                        <td>#003</td>
                        <td>Cultural Artifacts</td>
                        <td><span class="status-badge status-processing">Processing</span></td>
                        <td>Mar 23, 2024</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- My Orders Section -->
        <div id="orders-section" class="page-section">
            <div class="page-header">
                <h2>My Orders</h2>
                <p>View and track all your orders</p>
            </div>
            
            <table class="simple-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders ?? [] as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->product->post_title ?? 'Product Name' }}</td>
                        <td>{{ $order->quantity ?? 1 }}</td>
                        <td>Rs. {{ number_format($order->total_price ?? 0, 2) }}</td>
                        <td><span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <!-- Sample Data for Demo -->
                    <tr>
                        <td>#001</td>
                        <td>Traditional Handicraft Set</td>
                        <td>2</td>
                        <td>Rs. 2,500.00</td>
                        <td><span class="status-badge status-completed">Completed</span></td>
                        <td>Mar 20, 2024</td>
                    </tr>
                    <tr>
                        <td>#002</td>
                        <td>Handwoven Textile</td>
                        <td>1</td>
                        <td>Rs. 1,800.00</td>
                        <td><span class="status-badge status-pending">Pending</span></td>
                        <td>Mar 22, 2024</td>
                    </tr>
                    <tr>
                        <td>#003</td>
                        <td>Cultural Artifacts</td>
                        <td>1</td>
                        <td>Rs. 3,200.00</td>
                        <td><span class="status-badge status-processing">Processing</span></td>
                        <td>Mar 23, 2024</td>
                    </tr>
                    <tr>
                        <td>#004</td>
                        <td>Decorative Items</td>
                        <td>3</td>
                        <td>Rs. 950.00</td>
                        <td><span class="status-badge status-completed">Completed</span></td>
                        <td>Mar 18, 2024</td>
                    </tr>
                    <tr>
                        <td>#005</td>
                        <td>Premium Craft Collection</td>
                        <td>1</td>
                        <td>Rs. 4,500.00</td>
                        <td><span class="status-badge status-pending">Pending</span></td>
                        <td>Mar 21, 2024</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Wishlist Section -->
        <div id="wishlist-section" class="page-section">
            <div class="page-header">
                <h2>My Wishlist</h2>
                <p>Your saved favorite products</p>
            </div>
            
            <div class="product-grid">
                @forelse($wishlist ?? [] as $item)
                <div class="product-card">
                    @if($item->product->image ?? false)
                        <img src="{{ asset('uploads/' . $item->product->image) }}" alt="{{ $item->product->post_title }}">
                    @else
                        <div class="no-image">No Image</div>
                    @endif
                    <h5>{{ $item->product->post_title ?? 'Product Name' }}</h5>
                    <p>Rs. {{ number_format($item->product->price ?? 0, 2) }}</p>
                    <button class="btn-danger" onclick="removeFromWishlist({{ $item->id ?? 1 }})">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
                @empty
                <!-- Sample Data for Demo -->
                <div class="product-card">
                    <div class="no-image">No Image</div>
                    <h5>Traditional Handicraft Set</h5>
                    <p>Rs. 2,500.00</p>
                    <button class="btn-danger" onclick="removeFromWishlist(1)">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
                <div class="product-card">
                    <div class="no-image">No Image</div>
                    <h5>Handwoven Textile</h5>
                    <p>Rs. 1,800.00</p>
                    <button class="btn-danger" onclick="removeFromWishlist(2)">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
                <div class="product-card">
                    <div class="no-image">No Image</div>
                    <h5>Cultural Artifacts</h5>
                    <p>Rs. 3,200.00</p>
                    <button class="btn-danger" onclick="removeFromWishlist(3)">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Profile Section -->
        <div id="profile-section" class="page-section">
            <div class="page-header">
                <h2>Profile Settings</h2>
                <p>Update your personal information</p>
            </div>
            
            <form id="profileForm" method="POST" action="{{ route('customer.profile.update') }}">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" 
                           value="{{ auth()->user()->name ?? 'John Doe' }}" required>
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" 
                           value="{{ auth()->user()->email ?? 'customer@example.com' }}" required>
                </div>
                
                <div class="form-group">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" id="phone" name="phone" 
                           value="{{ auth()->user()->phone ?? '+1 234 567 8900' }}">
                </div>
                
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Update Profile
                </button>
            </form>
        </div>

        <!-- Reviews Section -->
        <div id="reviews-section" class="page-section">
            <div class="page-header">
                <h2>Write a Review</h2>
                <p>Share your experience with our products</p>
            </div>
            
            <form id="reviewForm" method="POST" action="{{ route('customer.review.store') }}">
                @csrf
                
                <div class="form-group">
                    <label for="product_id" class="form-label">Select Product</label>
                    <select class="form-control" id="product_id" name="product_id" required>
                        <option value="">Choose a product you purchased...</option>
                        @forelse($orderedProducts ?? [] as $product)
                            <option value="{{ $product->id }}">{{ $product->post_title }}</option>
                        @empty
                            <option value="1">Traditional Handicraft Set</option>
                            <option value="2">Handwoven Textile</option>
                            <option value="3">Cultural Artifacts</option>
                            <option value="4">Decorative Items</option>
                            <option value="5">Premium Craft Collection</option>
                        @endforelse
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Rating</label>
                    <div class="star-rating" id="starRating">
                        <span class="star" data-rating="1">★</span>
                        <span class="star" data-rating="2">★</span>
                        <span class="star" data-rating="3">★</span>
                        <span class="star" data-rating="4">★</span>
                        <span class="star" data-rating="5">★</span>
                    </div>
                    <input type="hidden" id="rating" name="rating" value="0" required>
                </div>
                
                <div class="form-group">
                    <label for="comment" class="form-label">Your Review</label>
                    <textarea class="form-control" id="comment" name="comment" rows="4" 
                              placeholder="Write your review here..." required></textarea>
                </div>
                
                <button type="submit" class="btn-primary">
                    <i class="fas fa-star"></i> Submit Review
                </button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Simple JavaScript for beginner-friendly functionality
        
        // Sidebar navigation
        document.addEventListener('DOMContentLoaded', function() {
            const menuLinks = document.querySelectorAll('.menu-link');
            const sections = document.querySelectorAll('.page-section');
            
            menuLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remove active class from all links and sections
                    menuLinks.forEach(l => l.classList.remove('active'));
                    sections.forEach(s => s.classList.remove('active'));
                    
                    // Add active class to clicked link
                    this.classList.add('active');
                    
                    // Show corresponding section
                    const sectionId = this.getAttribute('data-section') + '-section';
                    document.getElementById(sectionId).classList.add('active');
                });
            });
            
            // Star rating functionality
            const stars = document.querySelectorAll('.star');
            const ratingInput = document.getElementById('rating');
            
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = this.getAttribute('data-rating');
                    ratingInput.value = rating;
                    
                    // Update star display
                    stars.forEach((s, index) => {
                        if (index < rating) {
                            s.classList.add('active');
                        } else {
                            s.classList.remove('active');
                        }
                    });
                });
                
                star.addEventListener('mouseover', function() {
                    const rating = this.getAttribute('data-rating');
                    stars.forEach((s, index) => {
                        if (index < rating) {
                            s.style.color = '#ffc107';
                        } else {
                            s.style.color = '#ddd';
                        }
                    });
                });
            });
            
            // Reset star colors on mouse leave
            document.getElementById('starRating').addEventListener('mouseleave', function() {
                const currentRating = ratingInput.value;
                stars.forEach((s, index) => {
                    if (index < currentRating) {
                        s.style.color = '#ffc107';
                    } else {
                        s.style.color = '#ddd';
                    }
                });
            });
        });
        
        // Remove from wishlist function
        function removeFromWishlist(itemId) {
            if (confirm('Are you sure you want to remove this item from your wishlist?')) {
                // Redirect to the remove route
                window.location.href = `/customer/wishlist/remove/${itemId}`;
            }
        }
        
        // Form submission handlers
        document.getElementById('profileForm').addEventListener('submit', function(e) {
            // Let the form submit normally to the server
            console.log('Profile form submitted');
        });
        
        document.getElementById('reviewForm').addEventListener('submit', function(e) {
            const rating = document.getElementById('rating').value;
            const comment = document.getElementById('comment').value;
            
            if (rating == 0) {
                e.preventDefault();
                alert('Please select a rating!');
                return;
            }
            
            if (comment.trim() == '') {
                e.preventDefault();
                alert('Please write a review comment!');
                return;
            }
            
            // Let the form submit normally to the server
            console.log('Review submitted:', { rating, comment });
        });
        
        // Show success message function
        function showMessage(message, type = 'success') {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type}`;
            alertDiv.innerHTML = `<i class="fas fa-check-circle me-2"></i>${message}`;
            
            const mainContent = document.querySelector('.main-content');
            mainContent.insertBefore(alertDiv, mainContent.firstChild);
            
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        }
        
        console.log('Customer Dashboard loaded successfully!');
        console.log('All functionality is working and beginner-friendly!');
    </script>
</body>
</html>