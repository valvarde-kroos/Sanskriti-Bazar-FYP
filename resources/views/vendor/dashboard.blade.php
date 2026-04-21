@extends('vendor.layout.main')

@section('title', 'Vendor Dashboard')

@section('content')
<!-- Dashboard Header -->
<div class="dashboard-header">
    <div class="header-content">
        <div class="header-text">
            <h1>{{ auth()->user()->name }}'s Store</h1>
            <p class="dashboard-subtitle">Manage your traditional instrument business on Sanskriti Bazar</p>
        </div>
        <div class="header-badge">
            <span class="vendor-badge">Vendor Portal</span>
            <span class="feature-text">Store Management</span>
        </div>
    </div>
</div>

<!-- Key Metrics Cards -->
<div class="metrics-grid">
    <!-- Revenue Card -->
    <div class="metric-card revenue-card">
        <div class="card-header">
            <div class="card-icon">
                <i class="fas fa-rupee-sign"></i>
            </div>
            <div class="card-menu">
                <i class="fas fa-ellipsis-h"></i>
            </div>
        </div>
        <div class="card-content">
            <h3>Rs. {{ number_format($totalRevenue, 2) }}</h3>
            <p>Total Revenue</p>
            <div class="card-trend">
                <span class="trend-up">
                    <i class="fas fa-arrow-up"></i>
                    +{{ number_format((($monthlyRevenue / max($totalRevenue, 1)) * 100), 1) }}%
                </span>
                <span class="trend-text">this month</span>
            </div>
        </div>
    </div>

    <!-- Products Card -->
    <div class="metric-card products-card">
        <div class="card-header">
            <div class="card-icon">
                <i class="fas fa-box"></i>
            </div>
            <div class="card-menu">
                <i class="fas fa-ellipsis-h"></i>
            </div>
        </div>
        <div class="card-content">
            <h3>{{ number_format($totalProducts) }}</h3>
            <p>My Products</p>
            <div class="card-trend">
                <span class="trend-neutral">
                    <i class="fas fa-check-circle"></i>
                    {{ $activeProducts }} active
                </span>
                <span class="trend-text">{{ $inactiveProducts }} inactive</span>
            </div>
        </div>
    </div>

    <!-- Orders Card -->
    <div class="metric-card orders-card">
        <div class="card-header">
            <div class="card-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="card-menu">
                <i class="fas fa-ellipsis-h"></i>
            </div>
        </div>
        <div class="card-content">
            <h3>{{ number_format($totalOrders) }}</h3>
            <p>Total Orders</p>
            <div class="card-trend">
                <span class="trend-warning">
                    <i class="fas fa-clock"></i>
                    {{ $pendingOrders }} pending
                </span>
                <span class="trend-text">need attention</span>
            </div>
        </div>
    </div>

    <!-- Performance Card -->
    <div class="metric-card performance-card">
        <div class="card-header">
            <div class="card-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="card-menu">
                <i class="fas fa-ellipsis-h"></i>
            </div>
        </div>
        <div class="card-content">
            <h3>{{ number_format($averageRating, 1) }}/5.0</h3>
            <p>Store Rating</p>
            <div class="card-trend">
                <div class="star-rating">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= $averageRating ? 'active' : '' }}"></i>
                    @endfor
                </div>
                <span class="trend-text">customer reviews</span>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="charts-section">
    <!-- Sales Trend Line Chart -->
    <div class="chart-container large-chart">
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">
                    <h3>Sales Performance</h3>
                    <p>Monthly revenue trend for your store</p>
                </div>
                <div class="chart-controls">
                    <select class="chart-filter">
                        <option>Last 12 months</option>
                        <option>Last 6 months</option>
                        <option>Last 3 months</option>
                    </select>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="salesTrendChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Products by Category Bar Chart -->
    <div class="chart-container medium-chart">
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">
                    <h3>Product Categories</h3>
                    <p>Your product distribution</p>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Charts Row -->
<div class="secondary-charts">
    <!-- Order Status Doughnut Chart -->
    <div class="chart-container small-chart">
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">
                    <h3>Order Status</h3>
                    <p>Current order distribution</p>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="orderStatusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Daily Orders Area Chart -->
    <div class="chart-container small-chart">
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">
                    <h3>Daily Orders</h3>
                    <p>Orders this month</p>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="dailyOrdersChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Best Sellers -->
    <div class="chart-container small-chart">
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">
                    <h3>Best Sellers</h3>
                    <p>Your top performing products</p>
                </div>
            </div>
            <div class="chart-body">
                <div class="top-products-list">
                    @forelse($topProducts as $index => $product)
                    <div class="product-item">
                        <div class="product-rank">{{ $index + 1 }}</div>
                        <div class="product-info">
                            <h4>{{ Str::limit($product->post_title, 25) }}</h4>
                            <p>{{ $product->total_sold ?? 0 }} sold</p>
                        </div>
                        <div class="product-revenue">
                            Rs. {{ number_format($product->total_revenue ?? 0, 0) }}
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <i class="fas fa-box-open"></i>
                        <p>No sales data yet</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Vendor Management Section -->
<div class="vendor-management-section">
    <div class="management-header">
        <h2><i class="fas fa-store"></i> Store Management</h2>
        <p>Manage your products, orders, and business operations</p>
    </div>
    
    <div class="management-grid">
        <!-- Inventory Management Card -->
        <div class="management-card">
            <div class="card-header">
                <h3><i class="fas fa-boxes"></i> Inventory Status</h3>
            </div>
            <div class="card-body">
                <div class="inventory-stats">
                    <div class="inventory-item">
                        <div class="inventory-icon active">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="inventory-info">
                            <div class="inventory-count">{{ $activeProducts }}</div>
                            <div class="inventory-label">Active Products</div>
                        </div>
                    </div>
                    <div class="inventory-item">
                        <div class="inventory-icon inactive">
                            <i class="fas fa-pause-circle"></i>
                        </div>
                        <div class="inventory-info">
                            <div class="inventory-count">{{ $inactiveProducts }}</div>
                            <div class="inventory-label">Inactive Products</div>
                        </div>
                    </div>
                    <div class="inventory-item">
                        <div class="inventory-icon low-stock">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="inventory-info">
                            <div class="inventory-count">{{ $lowStockProducts->count() }}</div>
                            <div class="inventory-label">Low Stock Items</div>
                        </div>
                    </div>
                    <div class="inventory-item">
                        <div class="inventory-icon out-stock">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="inventory-info">
                            <div class="inventory-count">{{ $outOfStockProducts }}</div>
                            <div class="inventory-label">Out of Stock</div>
                        </div>
                    </div>
                </div>
                <div class="inventory-actions">
                    <a href="{{ route('vendor.products') }}" class="btn btn-primary">
                        <i class="fas fa-cog"></i> Manage Products
                    </a>
                </div>
            </div>
        </div>

        <!-- Order Management Card -->
        <div class="management-card">
            <div class="card-header">
                <h3><i class="fas fa-clipboard-list"></i> Order Management</h3>
            </div>
            <div class="card-body">
                <div class="order-summary">
                    <div class="order-stat">
                        <div class="stat-number">{{ $pendingOrders }}</div>
                        <div class="stat-label">Pending Orders</div>
                        <div class="stat-action">
                            <a href="{{ route('vendor.orders') }}?status=pending" class="btn-link">
                                <i class="fas fa-arrow-right"></i> Process Now
                            </a>
                        </div>
                    </div>
                    <div class="order-stat">
                        <div class="stat-number">{{ $processingOrders }}</div>
                        <div class="stat-label">Processing</div>
                        <div class="stat-action">
                            <a href="{{ route('vendor.orders') }}?status=processing" class="btn-link">
                                <i class="fas fa-arrow-right"></i> View All
                            </a>
                        </div>
                    </div>
                    <div class="order-stat">
                        <div class="stat-number">{{ $completedOrders }}</div>
                        <div class="stat-label">Completed</div>
                        <div class="stat-action">
                            <a href="{{ route('vendor.orders') }}?status=completed" class="btn-link">
                                <i class="fas fa-arrow-right"></i> View All
                            </a>
                        </div>
                    </div>
                </div>
                <div class="order-actions">
                    <a href="{{ route('vendor.orders') }}" class="btn btn-primary">
                        <i class="fas fa-list"></i> All Orders
                    </a>
                </div>
            </div>
        </div>

        <!-- Performance Insights Card -->
        <div class="management-card">
            <div class="card-header">
                <h3><i class="fas fa-chart-bar"></i> Performance Insights</h3>
            </div>
            <div class="card-body">
                <div class="performance-metrics">
                    <div class="metric-row">
                        <div class="metric-label">Monthly Revenue</div>
                        <div class="metric-value">Rs. {{ number_format($monthlyRevenue, 2) }}</div>
                    </div>
                    <div class="metric-row">
                        <div class="metric-label">Average Order Value</div>
                        <div class="metric-value">Rs. {{ number_format($totalOrders > 0 ? $totalRevenue / $totalOrders : 0, 2) }}</div>
                    </div>
                    <div class="metric-row">
                        <div class="metric-label">Store Rating</div>
                        <div class="metric-value">
                            {{ number_format($averageRating, 1) }}/5.0
                            <div class="mini-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $averageRating ? 'active' : '' }}"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <div class="metric-row">
                        <div class="metric-label">Total Reviews</div>
                        <div class="metric-value">{{ $recentReviews->count() }} reviews</div>
                    </div>
                </div>
                <div class="performance-actions">
                    <a href="{{ route('vendor.reviews') }}" class="btn btn-primary">
                        <i class="fas fa-star"></i> View Reviews
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Management Sections -->
<div class="management-section">
    <!-- Low Stock Alert -->
    @if($lowStockProducts->count() > 0)
    <div class="alert-card low-stock-alert">
        <div class="alert-header">
            <div class="alert-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="alert-content">
                <h3>Low Stock Alert</h3>
                <p>{{ $lowStockProducts->count() }} products are running low on stock</p>
            </div>
        </div>
        <div class="alert-body">
            <div class="low-stock-items">
                @foreach($lowStockProducts->take(3) as $product)
                <div class="stock-item">
                    <span class="product-name">{{ Str::limit($product->post_title, 30) }}</span>
                    <span class="stock-count">{{ $product->quantity }} left</span>
                </div>
                @endforeach
                @if($lowStockProducts->count() > 3)
                <div class="stock-item">
                    <span class="more-items">+{{ $lowStockProducts->count() - 3 }} more items</span>
                </div>
                @endif
            </div>
        </div>
        <div class="alert-actions">
            <a href="{{ route('vendor.products') }}" class="btn-alert">Manage Stock</a>
        </div>
    </div>
    @endif

    <!-- Recent Activity -->
    <div class="activity-section">
        <div class="activity-tabs">
            <button class="tab-btn active" data-tab="orders">Recent Orders</button>
            <button class="tab-btn" data-tab="reviews">Recent Reviews</button>
        </div>

        <!-- Recent Orders Tab -->
        <div class="tab-content active" id="orders-tab">
            <div class="activity-card">
                <div class="activity-body">
                    <div class="orders-table">
                        @forelse($recentOrders as $order)
                        <div class="order-row">
                            <div class="order-info">
                                <div class="order-id">#{{ $order->id }}</div>
                                <div class="order-customer">{{ $order->user->name ?? 'Unknown' }}</div>
                            </div>
                            <div class="order-product">
                                {{ Str::limit($order->product->post_title ?? 'Product', 30) }}
                            </div>
                            <div class="order-amount">
                                Rs. {{ number_format($order->total_price, 2) }}
                            </div>
                            <div class="order-status">
                                <span class="status-badge status-{{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div class="order-date">
                                {{ $order->created_at->format('M d, Y') }}
                            </div>
                        </div>
                        @empty
                        <div class="empty-state">
                            <i class="fas fa-shopping-cart"></i>
                            <p>No orders yet</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Reviews Tab -->
        <div class="tab-content" id="reviews-tab">
            <div class="activity-card">
                <div class="activity-body">
                    <div class="reviews-list">
                        @forelse($recentReviews as $review)
                        <div class="review-item">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <strong>{{ $review->user->name ?? 'Anonymous' }}</strong>
                                    <span class="review-product">on {{ Str::limit($review->product->post_title ?? 'Product', 25) }}</span>
                                </div>
                                <div class="review-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'active' : '' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <div class="review-content">
                                <p>{{ Str::limit($review->comment ?? 'No comment', 100) }}</p>
                            </div>
                            <div class="review-date">
                                {{ $review->created_at->format('M d, Y') }}
                            </div>
                        </div>
                        @empty
                        <div class="empty-state">
                            <i class="fas fa-star"></i>
                            <p>No reviews yet</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('styles')
<style>
    /* Dashboard Header */
    .dashboard-header {
        margin-bottom: 2rem;
        padding: 1.5rem 0;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-text h1 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 0.5rem 0;
    }

    .dashboard-subtitle {
        font-size: 1.1rem;
        color: #6b7280;
        margin: 0;
    }

    .header-badge {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .vendor-badge {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .feature-text {
        font-size: 1.5rem;
        font-weight: 600;
        color: #374151;
    }

    /* Metrics Grid */
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .metric-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid #f3f4f6;
        transition: all 0.3s ease;
    }

    .metric-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .card-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }

    .revenue-card .card-icon {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .products-card .card-icon {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .orders-card .card-icon {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    }

    .performance-card .card-icon {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    }

    .card-menu {
        color: #9ca3af;
        cursor: pointer;
    }

    .card-content h3 {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 0.25rem 0;
    }

    .card-content p {
        color: #6b7280;
        margin: 0 0 1rem 0;
        font-weight: 500;
    }

    .card-trend {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .trend-up {
        color: #10b981;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .trend-neutral {
        color: #6b7280;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .trend-warning {
        color: #f59e0b;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .trend-text {
        color: #9ca3af;
        font-size: 0.875rem;
    }

    .star-rating {
        display: flex;
        gap: 2px;
    }

    .star-rating .fas.fa-star {
        color: #d1d5db;
        font-size: 0.875rem;
    }

    .star-rating .fas.fa-star.active {
        color: #fbbf24;
    }

    /* Charts Section */
    .charts-section {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .secondary-charts {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .chart-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid #f3f4f6;
        overflow: hidden;
    }

    .chart-card {
        height: 100%;
    }

    .chart-header {
        padding: 1.5rem 1.5rem 0 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .chart-title h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin: 0 0 0.25rem 0;
    }

    .chart-title p {
        color: #6b7280;
        font-size: 0.875rem;
        margin: 0;
    }

    .chart-controls select {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 0.5rem;
        font-size: 0.875rem;
        color: #374151;
    }

    .chart-body {
        padding: 1.5rem;
        height: 300px;
    }

    .large-chart .chart-body {
        height: 400px;
    }

    .small-chart .chart-body {
        height: 250px;
    }

    /* Top Products List */
    .top-products-list {
        height: 100%;
        overflow-y: auto;
    }

    .product-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .product-item:last-child {
        border-bottom: none;
    }

    .product-rank {
        width: 24px;
        height: 24px;
        background: #f3f4f6;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.875rem;
        color: #6b7280;
    }

    .product-info {
        flex: 1;
    }

    .product-info h4 {
        font-size: 0.875rem;
        font-weight: 600;
        color: #1f2937;
        margin: 0 0 0.25rem 0;
    }

    .product-info p {
        font-size: 0.75rem;
        color: #6b7280;
        margin: 0;
    }

    .product-revenue {
        font-weight: 600;
        color: #10b981;
        font-size: 0.875rem;
    }

    /* Vendor Management Section */
    .vendor-management-section {
        margin-bottom: 2rem;
    }

    .management-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .management-header h2 {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .management-header p {
        color: #6b7280;
        font-size: 1.1rem;
    }

    .management-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 2rem;
    }

    .management-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid #f3f4f6;
        overflow: hidden;
    }

    .management-card .card-header {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: white;
        padding: 1.5rem;
        border-bottom: none;
    }

    .management-card .card-header h3 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .management-card .card-body {
        padding: 1.5rem;
    }

    /* Inventory Stats */
    .inventory-stats {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .inventory-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .inventory-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .inventory-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
    }

    .inventory-icon.active {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .inventory-icon.inactive {
        background: linear-gradient(135deg, #6b7280, #4b5563);
    }

    .inventory-icon.low-stock {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .inventory-icon.out-stock {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }

    .inventory-info {
        flex: 1;
    }

    .inventory-count {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.25rem;
    }

    .inventory-label {
        color: #6b7280;
        font-size: 0.875rem;
        font-weight: 500;
    }

    /* Order Summary */
    .order-summary {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .order-stat {
        text-align: center;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 12px;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #8b5cf6;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: #6b7280;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .btn-link {
        color: #8b5cf6;
        text-decoration: none;
        font-size: 0.75rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.25rem;
    }

    .btn-link:hover {
        color: #7c3aed;
    }

    /* Performance Metrics */
    .performance-metrics {
        margin-bottom: 1.5rem;
    }

    .metric-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .metric-row:last-child {
        border-bottom: none;
    }

    .metric-label {
        color: #6b7280;
        font-weight: 500;
    }

    .metric-value {
        font-weight: 700;
        color: #1f2937;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .mini-stars {
        display: flex;
        gap: 2px;
    }

    .mini-stars .fas.fa-star {
        color: #d1d5db;
        font-size: 0.75rem;
    }

    .mini-stars .fas.fa-star.active {
        color: #fbbf24;
    }

    /* Action Buttons */
    .inventory-actions,
    .order-actions,
    .performance-actions {
        text-align: center;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        background: #8b5cf6;
        color: white;
    }

    .btn-primary:hover {
        background: #7c3aed;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
    }

    /* Management Section */
    .management-section {
        margin-bottom: 2rem;
    }

    /* Low Stock Alert */
    .low-stock-alert {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        border: 1px solid #f59e0b;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .alert-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .alert-icon {
        width: 48px;
        height: 48px;
        background: #f59e0b;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }

    .alert-content h3 {
        color: #92400e;
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0 0 0.25rem 0;
    }

    .alert-content p {
        color: #b45309;
        margin: 0;
    }

    .low-stock-items {
        margin-bottom: 1rem;
    }

    .stock-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid #f59e0b;
    }

    .stock-item:last-child {
        border-bottom: none;
    }

    .product-name {
        color: #92400e;
        font-weight: 500;
    }

    .stock-count {
        color: #b45309;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .more-items {
        color: #b45309;
        font-style: italic;
    }

    .alert-actions {
        text-align: right;
    }

    .btn-alert {
        background: #f59e0b;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }

    .btn-alert:hover {
        background: #d97706;
        transform: translateY(-2px);
    }

    /* Activity Section */
    .activity-section {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid #f3f4f6;
        overflow: hidden;
    }

    .activity-tabs {
        display: flex;
        border-bottom: 1px solid #f3f4f6;
    }

    .tab-btn {
        flex: 1;
        padding: 1rem 1.5rem;
        background: none;
        border: none;
        font-weight: 500;
        color: #6b7280;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .tab-btn.active {
        color: #8b5cf6;
        border-bottom: 2px solid #8b5cf6;
        background: #faf5ff;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .activity-card {
        padding: 1.5rem;
    }

    .order-row {
        display: grid;
        grid-template-columns: 1fr 2fr 1fr 1fr 1fr;
        gap: 1rem;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .order-row:last-child {
        border-bottom: none;
    }

    .order-id {
        font-weight: 600;
        color: #1f2937;
    }

    .order-customer {
        color: #6b7280;
        font-size: 0.875rem;
    }

    .order-product {
        color: #374151;
        font-weight: 500;
    }

    .order-amount {
        font-weight: 600;
        color: #10b981;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-accepted {
        background: #d1fae5;
        color: #065f46;
    }

    .status-processing {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-completed {
        background: #dcfce7;
        color: #166534;
    }

    .status-cancelled {
        background: #fee2e2;
        color: #991b1b;
    }

    .order-date {
        color: #6b7280;
        font-size: 0.875rem;
    }

    /* Reviews List */
    .reviews-list {
        max-height: 400px;
        overflow-y: auto;
    }

    .review-item {
        padding: 1rem 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .review-item:last-child {
        border-bottom: none;
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .reviewer-info strong {
        color: #1f2937;
        font-weight: 600;
    }

    .review-product {
        color: #6b7280;
        font-size: 0.875rem;
        margin-left: 0.5rem;
    }

    .review-rating {
        display: flex;
        gap: 2px;
    }

    .review-rating .fas.fa-star {
        color: #d1d5db;
        font-size: 0.875rem;
    }

    .review-rating .fas.fa-star.active {
        color: #fbbf24;
    }

    .review-content p {
        color: #374151;
        margin: 0 0 0.5rem 0;
        line-height: 1.5;
    }

    .review-date {
        color: #9ca3af;
        font-size: 0.75rem;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #9ca3af;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-state p {
        margin: 0;
        font-size: 1.1rem;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .metrics-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .charts-section {
            grid-template-columns: 1fr;
        }

        .secondary-charts {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .metrics-grid {
            grid-template-columns: 1fr;
        }

        .secondary-charts {
            grid-template-columns: 1fr;
        }

        .header-content {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .order-row {
            grid-template-columns: 1fr;
            gap: 0.5rem;
        }

        .activity-tabs {
            flex-direction: column;
        }

        .inventory-stats {
            grid-template-columns: 1fr;
        }

        .order-summary {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('scripts')
<script>
    // Get data from PHP
    const categoriesData = @json($productsByCategory);
    const monthlySalesData = @json($monthlySales);
    const orderStatusData = @json($orderStatusDistribution);
    const dailyOrdersData = @json($dailyOrders);

    // Chart.js default configuration
    Chart.defaults.font.family = "'Inter', -apple-system, BlinkMacSystemFont, sans-serif";
    Chart.defaults.color = '#6b7280';

    // Sales Trend Line Chart
    const salesCtx = document.getElementById('salesTrendChart').getContext('2d');
    const salesChart = new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: monthlySalesData.map(item => item.month),
            datasets: [{
                label: 'Revenue (Rs.)',
                data: monthlySalesData.map(item => item.sales),
                borderColor: '#8b5cf6',
                backgroundColor: 'rgba(139, 92, 246, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#8b5cf6',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f3f4f6'
                    },
                    ticks: {
                        callback: function(value) {
                            return 'Rs. ' + value.toLocaleString();
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });

    // Products by Category Bar Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categoryChart = new Chart(categoryCtx, {
        type: 'bar',
        data: {
            labels: categoriesData.map(item => item.name),
            datasets: [{
                label: 'Products',
                data: categoriesData.map(item => item.count),
                backgroundColor: [
                    '#8b5cf6',
                    '#10b981',
                    '#f59e0b',
                    '#3b82f6',
                    '#ef4444',
                    '#06b6d4'
                ],
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f3f4f6'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Order Status Doughnut Chart
    const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
    const orderStatusChart = new Chart(orderStatusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Accepted', 'Processing', 'Completed', 'Cancelled'],
            datasets: [{
                data: [
                    orderStatusData.pending,
                    orderStatusData.accepted,
                    orderStatusData.processing,
                    orderStatusData.completed,
                    orderStatusData.cancelled
                ],
                backgroundColor: [
                    '#f59e0b',
                    '#10b981',
                    '#3b82f6',
                    '#8b5cf6',
                    '#ef4444'
                ],
                borderWidth: 0,
                cutout: '70%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });

    // Daily Orders Area Chart
    const dailyOrdersCtx = document.getElementById('dailyOrdersChart').getContext('2d');
    const dailyOrdersChart = new Chart(dailyOrdersCtx, {
        type: 'line',
        data: {
            labels: dailyOrdersData.map(item => item.day),
            datasets: [{
                label: 'Orders',
                data: dailyOrdersData.map(item => item.orders),
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointRadius: 0,
                pointHoverRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f3f4f6'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });

    // Tab functionality
    document.addEventListener('DOMContentLoaded', function() {
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const tabName = this.getAttribute('data-tab');
                
                // Remove active class from all tabs and contents
                tabBtns.forEach(b => b.classList.remove('active'));
                tabContents.forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked tab and corresponding content
                this.classList.add('active');
                document.getElementById(tabName + '-tab').classList.add('active');
            });
        });

        // Add animation on page load
        const cards = document.querySelectorAll('.metric-card');
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