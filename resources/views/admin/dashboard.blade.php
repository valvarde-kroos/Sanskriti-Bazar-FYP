@extends('admin.layout.main')

@section('title', 'Dashboard')

@section('content')
<!-- Simple Dashboard Header -->
<div class="dashboard-header">
    <h1>Welcome to Sanskriti Bazar Admin</h1>
    <p class="dashboard-subtitle">Manage your traditional marketplace with ease</p>
</div>

<!-- Simple Summary Cards -->
<div class="summary-cards">
    <!-- Customers Card -->
    <div class="summary-card customers-card">
        <div class="card-icon">
            <i class="fas fa-users"></i>
        </div>
        <div class="card-content">
            <h3>1,247</h3>
            <p>Total Customers</p>
            <span class="card-trend">+8% this month</span>
        </div>
    </div>

    <!-- Vendors Card -->
    <div class="summary-card vendors-card">
        <div class="card-icon">
            <i class="fas fa-store"></i>
        </div>
        <div class="card-content">
            <h3>156</h3>
            <p>Total Vendors</p>
            <span class="card-trend">+12% this month</span>
        </div>
    </div>

    <!-- Categories Card -->
    <div class="summary-card categories-card">
        <div class="card-icon">
            <i class="fas fa-tags"></i>
        </div>
        <div class="card-content">
            <h3>24</h3>
            <p>Total Categories</p>
            <span class="card-trend">2 new added</span>
        </div>
    </div>

    <!-- Reviews Card -->
    <div class="summary-card reviews-card">
        <div class="card-icon">
            <i class="fas fa-star"></i>
        </div>
        <div class="card-content">
            <h3>3,892</h3>
            <p>Total Reviews</p>
            <span class="card-trend">+15% this month</span>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="quick-actions-section">
    <h3>Quick Actions</h3>
    <div class="actions-grid">
        <a href="{{ route('admin.customers') }}" class="action-card">
            <i class="fas fa-users"></i>
            <span>Manage Customers</span>
        </a>
        <a href="{{ route('admin.vendors') }}" class="action-card">
            <i class="fas fa-store"></i>
            <span>Manage Vendors</span>
        </a>
        <a href="{{ route('admin.categories') }}" class="action-card">
            <i class="fas fa-tags"></i>
            <span>Manage Categories</span>
        </a>
        <a href="#" class="action-card">
            <i class="fas fa-star"></i>
            <span>View Reviews</span>
        </a>
    </div>
</div>

<!-- Recent Activity -->
<div class="recent-activity">
    <h3>Recent Activity</h3>
    <div class="activity-list">
        <div class="activity-item">
            <div class="activity-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="activity-content">
                <p><strong>New Customer Registered</strong></p>
                <p>Rajesh Kumar joined Sanskriti Bazar</p>
                <span>2 minutes ago</span>
            </div>
        </div>
        
        <div class="activity-item">
            <div class="activity-icon">
                <i class="fas fa-store"></i>
            </div>
            <div class="activity-content">
                <p><strong>Vendor Application</strong></p>
                <p>Traditional Crafts Store applied for approval</p>
                <span>15 minutes ago</span>
            </div>
        </div>
        
        <div class="activity-item">
            <div class="activity-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="activity-content">
                <p><strong>New Review</strong></p>
                <p>5-star review for Handmade Pottery</p>
                <span>1 hour ago</span>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Simple Dashboard Styles for Sanskriti Bazar */
    
    /* Dashboard Header */
    .dashboard-header {
        text-align: center;
        margin-bottom: 2rem;
        padding: 2rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        color: white;
    }

    .dashboard-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
    }

    .dashboard-subtitle {
        font-size: 1.1rem;
        margin: 0;
        opacity: 0.9;
    }

    /* Summary Cards */
    .summary-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .summary-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
        border-left: 4px solid;
    }

    .summary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    /* Card Colors */
    .customers-card { border-left-color: #10b981; }
    .vendors-card { border-left-color: #3b82f6; }
    .categories-card { border-left-color: #f59e0b; }
    .reviews-card { border-left-color: #8b5cf6; }

    .card-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }

    .customers-card .card-icon { background: #10b981; }
    .vendors-card .card-icon { background: #3b82f6; }
    .categories-card .card-icon { background: #f59e0b; }
    .reviews-card .card-icon { background: #8b5cf6; }

    .card-content h3 {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 0.25rem 0;
    }

    .card-content p {
        font-size: 0.875rem;
        color: #6b7280;
        margin: 0 0 0.5rem 0;
        font-weight: 500;
    }

    .card-trend {
        font-size: 0.75rem;
        color: #10b981;
        font-weight: 600;
        background: rgba(16, 185, 129, 0.1);
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
    }

    /* Quick Actions Section */
    .quick-actions-section {
        margin-bottom: 3rem;
    }

    .quick-actions-section h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1f2937;
        margin: 0 0 1rem 0;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .action-card {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        text-decoration: none;
        color: #374151;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
    }

    .action-card:hover {
        border-color: #3b82f6;
        background: #f8fafc;
        transform: translateY(-2px);
        color: #3b82f6;
    }

    .action-card i {
        font-size: 2rem;
    }

    .action-card span {
        font-weight: 500;
    }

    /* Recent Activity */
    .recent-activity {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .recent-activity h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin: 0 0 1rem 0;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .activity-item {
        display: flex;
        gap: 1rem;
        padding: 1rem;
        background: #f9fafb;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .activity-item:hover {
        background: #f3f4f6;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: #3b82f6;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .activity-content p {
        margin: 0 0 0.25rem 0;
        font-size: 0.875rem;
    }

    .activity-content p:first-child {
        font-weight: 600;
        color: #1f2937;
    }

    .activity-content p:nth-child(2) {
        color: #6b7280;
    }

    .activity-content span {
        font-size: 0.75rem;
        color: #9ca3af;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .dashboard-header {
            padding: 1.5rem;
        }

        .dashboard-header h1 {
            font-size: 2rem;
        }

        .summary-cards {
            grid-template-columns: 1fr;
        }

        .actions-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .card-content h3 {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .actions-grid {
            grid-template-columns: 1fr;
        }

        .summary-card {
            flex-direction: column;
            text-align: center;
        }

        .activity-item {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
@endsection