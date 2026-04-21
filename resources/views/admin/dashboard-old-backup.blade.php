@extends('admin.layout.main')

@section('title', 'Admin Dashboard')

@section('content')
<!-- Dashboard Header -->
<div class="dashboard-header">
    <div class="header-content">
        <div class="header-text">
            <h1>Admin Management Center</h1>
            <p class="dashboard-subtitle">Manage categories, vendors, customers and oversee Sanskriti Bazar operations</p>
        </div>
        <div class="header-badge">
            <span class="admin-badge">Admin Portal</span>
            <span class="feature-text">Management Dashboard</span>
        </div>
    </div>
</div>

<!-- Management Overview Cards -->
<div class="management-grid">
    <!-- Categories Management Card -->
    <div class="management-card categories-card">
        <div class="card-header">
            <div class="card-icon">
                <i class="fas fa-tags"></i>
            </div>
            <div class="card-actions">
                <a href="{{ route('admin.categories') }}" class="action-link">
                    <i class="fas fa-cog"></i>
                </a>
            </div>
        </div>
        <div class="card-content">
            <h3>{{ number_format($totalCategories) }}</h3>
            <p>Product Categories</p>
            <div class="card-stats">
                <div class="stat-item">
                    <span class="stat-label">Active:</span>
                    <span class="stat-value">{{ $totalCategories }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Products:</span>
                    <span class="stat-value">{{ $totalProducts }}</span>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.categories') }}" class="manage-btn">
                <i class="fas fa-edit"></i> Manage Categories
            </a>
        </div>
    </div>

    <!-- Vendors Management Card -->
    <div class="management-card vendors-card">
        <div class="card-header">
            <div class="card-icon">
                <i class="fas fa-store"></i>
            </div>
            <div class="card-actions">
                <a href="{{ route('admin.vendors') }}" class="action-link">
                    <i class="fas fa-cog"></i>
                </a>
            </div>
        </div>
        <div class="card-content">
            <h3>{{ number_format($totalVendors) }}</h3>
            <p>Registered Vendors</p>
            <div class="card-stats">
                <div class="stat-item">
                    <span class="stat-label">Active:</span>
                    <span class="stat-value">{{ $totalVendors }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Products:</span>
                    <span class="stat-value">{{ $totalProducts }}</span>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.vendors') }}" class="manage-btn">
                <i class="fas fa-users-cog"></i> Manage Vendors
            </a>
        </div>
    </div>

    <!-- Customers Management Card -->
    <div class="management-card customers-card">
        <div class="card-header">
            <div class="card-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="card-actions">
                <a href="{{ route('admin.customers') }}" class="action-link">
                    <i class="fas fa-cog"></i>
                </a>
            </div>
        </div>
        <div class="card-content">
            <h3>{{ number_format($totalCustomers) }}</h3>
            <p>Registered Customers</p>
            <div class="card-stats">
                <div class="stat-item">
                    <span class="stat-label">Active:</span>
                    <span class="stat-value">{{ $totalCustomers }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Orders:</span>
                    <span class="stat-value">{{ $totalOrders }}</span>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.customers') }}" class="manage-btn">
                <i class="fas fa-user-friends"></i> Manage Customers
            </a>
        </div>
    </div>

    <!-- Revenue Overview Card -->
    <div class="management-card revenue-card">
        <div class="card-header">
            <div class="card-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="card-actions">
                <span class="growth-indicator {{ $revenueGrowth >= 0 ? 'positive' : 'negative' }}">
                    <i class="fas fa-arrow-{{ $revenueGrowth >= 0 ? 'up' : 'down' }}"></i>
                    {{ number_format(abs($revenueGrowth), 1) }}%
                </span>
            </div>
        </div>
        <div class="card-content">
            <h3>Rs. {{ number_format($totalRevenue, 0) }}</h3>
            <p>Total Platform Revenue</p>
            <div class="card-stats">
                <div class="stat-item">
                    <span class="stat-label">This Month:</span>
                    <span class="stat-value">Rs. {{ number_format($monthlyRevenue, 0) }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Orders:</span>
                    <span class="stat-value">{{ $totalOrders }}</span>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="revenue-trend">
                <span class="trend-text">{{ $revenueGrowth >= 0 ? 'Growth' : 'Decline' }} vs last month</span>
            </div>
        </div>
    </div>
</div>

<!-- Quick Management Actions -->
<div class="quick-actions-section">
    <div class="section-header">
        <h2><i class="fas fa-bolt"></i> Quick Management Actions</h2>
        <p>Perform common administrative tasks quickly</p>
    </div>
    
    <div class="quick-actions-grid">
        <!-- Add Category -->
        <div class="quick-action-card">
            <div class="action-icon categories-icon">
                <i class="fas fa-plus"></i>
            </div>
            <div class="action-content">
                <h4>Add New Category</h4>
                <p>Create a new product category</p>
                <button class="action-btn" onclick="openAddCategoryModal()">
                    <i class="fas fa-plus"></i> Add Category
                </button>
            </div>
        </div>

        <!-- Add Vendor -->
        <div class="quick-action-card">
            <div class="action-icon vendors-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="action-content">
                <h4>Add New Vendor</h4>
                <p>Register a new vendor account</p>
                <button class="action-btn" onclick="openAddVendorModal()">
                    <i class="fas fa-user-plus"></i> Add Vendor
                </button>
            </div>
        </div>

        <!-- Add Customer -->
        <div class="quick-action-card">
            <div class="action-icon customers-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="action-content">
                <h4>Add New Customer</h4>
                <p>Create a new customer account</p>
                <button class="action-btn" onclick="openAddCustomerModal()">
                    <i class="fas fa-user-plus"></i> Add Customer
                </button>
            </div>
        </div>

        <!-- View Reports -->
        <div class="quick-action-card">
            <div class="action-icon reports-icon">
                <i class="fas fa-chart-bar"></i>
            </div>
            <div class="action-content">
                <h4>Platform Analytics</h4>
                <p>View detailed platform reports</p>
                <button class="action-btn" onclick="showAnalytics()">
                    <i class="fas fa-chart-bar"></i> View Analytics
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Management Overview Charts -->
<div class="charts-section">
    <!-- Categories Distribution -->
    <div class="chart-container">
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">
                    <h3>Categories Overview</h3>
                    <p>Products distribution across categories</p>
                </div>
                <div class="chart-actions">
                    <a href="{{ route('admin.categories') }}" class="chart-link">
                        <i class="fas fa-external-link-alt"></i> Manage
                    </a>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="categoriesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- User Growth -->
    <div class="chart-container">
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">
                    <h3>User Growth</h3>
                    <p>Vendors and customers registration trend</p>
                </div>
                <div class="chart-actions">
                    <select class="chart-filter">
                        <option>Last 6 months</option>
                        <option>Last 12 months</option>
                    </select>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="userGrowthChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Management Activity -->
<div class="activity-section">
    <div class="activity-tabs">
        <button class="tab-btn active" data-tab="recent-users">Recent Users</button>
        <button class="tab-btn" data-tab="recent-categories">Categories</button>
        <button class="tab-btn" data-tab="platform-stats">Platform Stats</button>
    </div>

    <!-- Recent Users Tab -->
    <div class="tab-content active" id="recent-users-tab">
        <div class="activity-card">
            <div class="activity-header">
                <h3>Recently Registered Users</h3>
                <div class="activity-filters">
                    <button class="filter-btn active" data-filter="all">All</button>
                    <button class="filter-btn" data-filter="vendors">Vendors</button>
                    <button class="filter-btn" data-filter="customers">Customers</button>
                </div>
            </div>
            <div class="activity-body">
                <div class="users-list">
                    @php
                        $recentUsers = collect()
                            ->merge($recentVendors ?? collect())
                            ->merge($recentCustomers ?? collect())
                            ->sortByDesc('created_at')
                            ->take(8);
                    @endphp
                    
                    @forelse($recentUsers as $user)
                    <div class="user-item" data-role="{{ $user->role }}">
                        <div class="user-avatar">
                            <i class="fas fa-{{ $user->role === 'vendor' ? 'store' : 'user' }}"></i>
                        </div>
                        <div class="user-info">
                            <h4>{{ $user->name }}</h4>
                            <p>{{ $user->email }}</p>
                            <span class="user-role role-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                        </div>
                        <div class="user-meta">
                            <span class="join-date">{{ $user->created_at->format('M d, Y') }}</span>
                            <div class="user-actions">
                                @if($user->role === 'vendor')
                                    <a href="{{ route('admin.vendors') }}" class="action-link">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @else
                                    <a href="{{ route('admin.customers') }}" class="action-link">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <i class="fas fa-users"></i>
                        <p>No recent user registrations</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Tab -->
    <div class="tab-content" id="recent-categories-tab">
        <div class="activity-card">
            <div class="activity-header">
                <h3>Product Categories</h3>
                <a href="{{ route('admin.categories') }}" class="view-all">Manage All</a>
            </div>
            <div class="activity-body">
                <div class="categories-grid">
                    @forelse($productsPerCategory->take(6) as $category)
                    <div class="category-item">
                        <div class="category-info">
                            <h4>{{ $category['name'] }}</h4>
                            <p>{{ $category['count'] }} products</p>
                        </div>
                        <div class="category-chart">
                            <div class="progress-circle" data-percentage="{{ ($category['count'] / max($totalProducts, 1)) * 100 }}">
                                <span>{{ $category['count'] }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <i class="fas fa-tags"></i>
                        <p>No categories found</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Platform Stats Tab -->
    <div class="tab-content" id="platform-stats-tab">
        <div class="activity-card">
            <div class="activity-header">
                <h3>Platform Statistics</h3>
                <span class="last-updated">Updated {{ now()->format('M d, Y H:i') }}</span>
            </div>
            <div class="activity-body">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="stat-content">
                            <h4>{{ number_format($totalOrders) }}</h4>
                            <p>Total Orders</p>
                            <span class="stat-trend positive">
                                <i class="fas fa-arrow-up"></i> {{ number_format($ordersGrowth, 1) }}%
                            </span>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stat-content">
                            <h4>{{ number_format($totalProducts) }}</h4>
                            <p>Total Products</p>
                            <span class="stat-trend positive">
                                <i class="fas fa-arrow-up"></i> {{ number_format($productsGrowth, 1) }}%
                            </span>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-rupee-sign"></i>
                        </div>
                        <div class="stat-content">
                            <h4>Rs. {{ number_format($monthlyRevenue, 0) }}</h4>
                            <p>Monthly Revenue</p>
                            <span class="stat-trend {{ $revenueGrowth >= 0 ? 'positive' : 'negative' }}">
                                <i class="fas fa-arrow-{{ $revenueGrowth >= 0 ? 'up' : 'down' }}"></i> {{ number_format(abs($revenueGrowth), 1) }}%
                            </span>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <h4>{{ number_format($totalCustomers + $totalVendors) }}</h4>
                            <p>Total Users</p>
                            <span class="stat-trend positive">
                                <i class="fas fa-arrow-up"></i> {{ number_format($usersGrowth, 1) }}%
                            </span>
                        </div>
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

    .new-badge {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
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

    /* Management Grid */
    .management-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .management-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        border: 1px solid #f1f5f9;
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
    }

    .management-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }

    .management-card .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 2rem 2rem 0 2rem;
        margin-bottom: 1.5rem;
    }

    .management-card .card-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        color: white;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }

    .categories-card .card-icon {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .vendors-card .card-icon {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .customers-card .card-icon {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .revenue-card .card-icon {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }

    .management-card .card-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .action-link {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .action-link:hover {
        background: rgba(0, 0, 0, 0.1);
        color: #334155;
        transform: scale(1.1);
    }

    .management-card .card-content {
        padding: 0 2rem;
    }

    .management-card .card-content h3 {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1e293b;
        margin: 0 0 0.5rem 0;
        line-height: 1;
    }

    .management-card .card-content p {
        color: #64748b;
        font-size: 1.1rem;
        font-weight: 500;
        margin: 0 0 1.5rem 0;
    }

    .card-stats {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }

    .stat-item {
        text-align: center;
    }

    .stat-label {
        font-size: 0.875rem;
        color: #64748b;
        font-weight: 500;
    }

    .stat-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
    }

    .management-card .card-footer {
        padding: 0 2rem 2rem 2rem;
    }

    .manage-btn {
        width: 100%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .vendors-card .manage-btn {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .customers-card .manage-btn {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .manage-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        color: white;
        text-decoration: none;
    }

    .growth-indicator {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.875rem;
        font-weight: 600;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
    }

    .growth-indicator.positive {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
    }

    .growth-indicator.negative {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
    }

    .revenue-trend {
        text-align: center;
        padding: 1rem 0;
    }

    .trend-text {
        font-size: 0.875rem;
        color: #64748b;
        font-weight: 500;
    }

    /* Quick Actions Section */
    .quick-actions-section {
        margin-bottom: 3rem;
    }

    .section-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .section-header h2 {
        font-size: 2rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }

    .section-header p {
        color: #64748b;
        font-size: 1.1rem;
    }

    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .quick-action-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        transition: all 0.3s ease;
        text-align: center;
    }

    .quick-action-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }

    .action-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        margin: 0 auto 1.5rem auto;
    }

    .categories-icon {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .vendors-icon {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .customers-icon {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .reports-icon {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }

    .action-content h4 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .action-content p {
        color: #64748b;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
    }

    .action-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }

    /* Charts Section */
    .charts-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .chart-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
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
        color: #1e293b;
        margin: 0 0 0.25rem 0;
    }

    .chart-title p {
        color: #64748b;
        font-size: 0.875rem;
        margin: 0;
    }

    .chart-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .chart-link {
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .chart-filter {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.5rem;
        font-size: 0.875rem;
        color: #374151;
        background: white;
    }

    .chart-body {
        padding: 1.5rem;
        height: 350px;
    }

    /* Activity Section */
    .activity-section {
        margin-bottom: 2rem;
    }

    .activity-tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        background: #f8fafc;
        padding: 0.5rem;
        border-radius: 12px;
    }

    .tab-btn {
        flex: 1;
        padding: 0.75rem 1rem;
        border: none;
        background: transparent;
        color: #64748b;
        font-weight: 500;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .tab-btn.active {
        background: white;
        color: #1e293b;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .activity-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }

    .activity-header {
        padding: 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .activity-header h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
    }

    .activity-filters {
        display: flex;
        gap: 0.5rem;
    }

    .filter-btn {
        padding: 0.5rem 1rem;
        border: 1px solid #e2e8f0;
        background: white;
        color: #64748b;
        border-radius: 8px;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-btn.active {
        background: #667eea;
        color: white;
        border-color: #667eea;
    }

    .view-all {
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.875rem;
    }

    .activity-body {
        padding: 1.5rem;
    }

    /* Users List */
    .users-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .user-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .user-item:hover {
        background: #f1f5f9;
        transform: translateX(4px);
    }

    .user-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
    }

    .user-info {
        flex: 1;
    }

    .user-info h4 {
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0 0 0.25rem 0;
    }

    .user-info p {
        font-size: 0.875rem;
        color: #64748b;
        margin: 0 0 0.25rem 0;
    }

    .user-role {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .role-vendor {
        background: rgba(240, 147, 251, 0.1);
        color: #f5576c;
    }

    .role-customer {
        background: rgba(79, 172, 254, 0.1);
        color: #00f2fe;
    }

    .user-meta {
        text-align: right;
    }

    .join-date {
        font-size: 0.875rem;
        color: #64748b;
        margin-bottom: 0.5rem;
        display: block;
    }

    .user-actions {
        display: flex;
        gap: 0.5rem;
    }

    /* Categories Grid */
    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .category-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .category-item:hover {
        background: #f1f5f9;
        transform: translateY(-2px);
    }

    .category-info h4 {
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0 0 0.25rem 0;
    }

    .category-info p {
        font-size: 0.875rem;
        color: #64748b;
        margin: 0;
    }

    .category-chart {
        position: relative;
        width: 40px;
        height: 40px;
    }

    .progress-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: conic-gradient(#667eea 0deg, #e2e8f0 0deg);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .progress-circle::before {
        content: '';
        position: absolute;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: white;
    }

    .progress-circle span {
        position: relative;
        z-index: 1;
        font-size: 0.75rem;
        font-weight: 600;
        color: #1e293b;
    }

    /* Platform Stats */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .stat-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        background: #f8fafc;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        background: #f1f5f9;
        transform: translateY(-2px);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: white;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .stat-content {
        flex: 1;
    }

    .stat-content h4 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 0.25rem 0;
    }

    .stat-content p {
        font-size: 0.875rem;
        color: #64748b;
        margin: 0 0 0.5rem 0;
    }

    .stat-trend {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
    }

    .stat-trend.positive {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
    }

    .stat-trend.negative {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
    }

    .last-updated {
        font-size: 0.875rem;
        color: #64748b;
    }

    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #64748b;
    }

    .empty-state i {
        font-size: 2rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-state p {
        margin: 0;
        font-size: 0.95rem;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .management-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .quick-actions-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .charts-section {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .header-text h1 {
            font-size: 2rem;
        }

        .management-grid {
            grid-template-columns: 1fr;
        }

        .quick-actions-grid {
            grid-template-columns: 1fr;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .categories-grid {
            grid-template-columns: 1fr;
        }

        .activity-tabs {
            flex-direction: column;
        }

        .tab-btn {
            text-align: center;
        }

        .user-item {
            flex-direction: column;
            text-align: center;
            gap: 0.75rem;
        }

        .user-meta {
            text-align: center;
        }
    }

    @media (max-width: 480px) {
        .management-card .card-content h3 {
            font-size: 2rem;
        }

        .section-header h2 {
            font-size: 1.5rem;
        }

        .chart-body {
            height: 250px;
        }
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

    .orders-card .card-icon {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    }

    .products-card .card-icon {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .users-card .card-icon {
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

    .trend-down {
        color: #ef4444;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .trend-text {
        color: #9ca3af;
        font-size: 0.875rem;
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

    /* Activity Section */
    .activity-section {
        margin-bottom: 2rem;
    }

    .activity-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid #f3f4f6;
        overflow: hidden;
    }

    .activity-header {
        padding: 1.5rem;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .activity-header h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin: 0;
    }

    .view-all {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.875rem;
    }

    .activity-body {
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

    .status-completed {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-cancelled {
        background: #fee2e2;
        color: #991b1b;
    }

    .order-date {
        color: #6b7280;
        font-size: 0.875rem;
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
    }
</style>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('scripts')
<script>
    // Get data from PHP
    const categoriesData = @json($productsPerCategory);
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
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#3b82f6',
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

    // Products per Category Bar Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categoryChart = new Chart(categoryCtx, {
        type: 'bar',
        data: {
            labels: categoriesData.map(item => item.name),
            datasets: [{
                label: 'Products',
                data: categoriesData.map(item => item.count),
                backgroundColor: [
                    '#3b82f6',
                    '#10b981',
                    '#f59e0b',
                    '#8b5cf6',
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

    // Categories Distribution Chart
    const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
    const categoriesChart = new Chart(categoriesCtx, {
        type: 'doughnut',
        data: {
            labels: categoriesData.map(item => item.name),
            datasets: [{
                data: categoriesData.map(item => item.count),
                backgroundColor: [
                    '#667eea',
                    '#f093fb',
                    '#4facfe',
                    '#43e97b',
                    '#ffa726',
                    '#ab47bc'
                ],
                borderWidth: 0,
                cutout: '60%'
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

    // User Growth Chart
    const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
    const userGrowthChart = new Chart(userGrowthCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Vendors',
                data: [5, 8, 12, 15, 18, {{ $totalVendors }}],
                borderColor: '#f093fb',
                backgroundColor: 'rgba(240, 147, 251, 0.1)',
                borderWidth: 3,
                fill: false,
                tension: 0.4,
                pointBackgroundColor: '#f093fb',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
            }, {
                label: 'Customers',
                data: [10, 25, 40, 60, 85, {{ $totalCustomers }}],
                borderColor: '#4facfe',
                backgroundColor: 'rgba(79, 172, 254, 0.1)',
                borderWidth: 3,
                fill: false,
                tension: 0.4,
                pointBackgroundColor: '#4facfe',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
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

    // Add animation on page load
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.management-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });

        // Tab functionality
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const targetTab = btn.getAttribute('data-tab');
                
                // Remove active class from all tabs and contents
                tabBtns.forEach(b => b.classList.remove('active'));
                tabContents.forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked tab and corresponding content
                btn.classList.add('active');
                document.getElementById(targetTab + '-tab').classList.add('active');
            });
        });

        // Filter functionality
        const filterBtns = document.querySelectorAll('.filter-btn');
        const userItems = document.querySelectorAll('.user-item');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const filter = btn.getAttribute('data-filter');
                
                // Remove active class from all filter buttons
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                // Show/hide user items based on filter
                userItems.forEach(item => {
                    const userRole = item.getAttribute('data-role');
                    if (filter === 'all' || filter === userRole) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    });

    // Modal functions for quick actions
    function openAddCategoryModal() {
        // Redirect to categories management page
        window.location.href = '{{ route("admin.categories") }}';
    }

    function openAddVendorModal() {
        // Redirect to vendors management page
        window.location.href = '{{ route("admin.vendors") }}';
    }

    function openAddCustomerModal() {
        // Redirect to customers management page
        window.location.href = '{{ route("admin.customers") }}';
    }

    function showAnalytics() {
        // Show analytics modal or redirect to analytics page
        alert('Analytics feature coming soon!');
    }
</script>
@endsection