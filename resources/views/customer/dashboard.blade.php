@extends('customer.layout.main')

@section('title', 'Dashboard')

@section('content')
<div class="welcome-section">
    <h1>Welcome Customer</h1>
    <p>Here's an overview of your account and recent activity</p>
</div>

<!-- Dashboard Cards -->
<div class="dashboard-cards">
    <div class="stat-card">
        <div class="card-header">
            <h3>Total Orders</h3>
        </div>
        <div class="card-body">
            <p class="card-value">{{ $totalOrders ?? 5 }}</p>
            <p class="card-subtitle">Orders placed</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="card-header">
            <h3>Pending Orders</h3>
        </div>
        <div class="card-body">
            <p class="card-value">{{ $pendingOrders ?? 2 }}</p>
            <p class="card-subtitle">Awaiting delivery</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="card-header">
            <h3>Cart Items</h3>
        </div>
        <div class="card-body">
            <p class="card-value">{{ $cartCount ?? 3 }}</p>
            <p class="card-subtitle">Items in cart</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="card-header">
            <h3>Total Spent</h3>
        </div>
        <div class="card-body">
            <p class="card-value">Rs. {{ number_format($totalSpent ?? 12450) }}</p>
            <p class="card-subtitle">Total purchases</p>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="section-card">
    <div class="section-header">
        <h2>Recent Orders</h2>
    </div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders ?? [] as $order)
                <tr>
                    <td>ORD-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $order->product->post_title ?? 'Product Name' }}</td>
                    <td>Rs. {{ number_format($order->total_price, 2) }}</td>
                    <td><span class="badge {{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td>ORD-001</td>
                    <td>Bansuri</td>
                    <td>Rs. 2,500.00</td>
                    <td><span class="badge completed">Completed</span></td>
                    <td>Mar 20, 2024</td>
                </tr>
                <tr>
                    <td>ORD-002</td>
                    <td>Khaijhandi</td>
                    <td>Rs. 1,800.00</td>
                    <td><span class="badge pending">Pending</span></td>
                    <td>Mar 22, 2024</td>
                </tr>
                <tr>
                    <td>ORD-003</td>
                    <td>Madal</td>
                    <td>Rs. 3,200.00</td>
                    <td><span class="badge processing">Processing</span></td>
                    <td>Mar 23, 2024</td>
                </tr>
                <tr>
                    <td>ORD-004</td>
                    <td>Sarangi</td>
                    <td>Rs. 950.00</td>
                    <td><span class="badge completed">Completed</span></td>
                    <td>Mar 18, 2024</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Quick Actions -->
<div class="section-card">
    <div class="section-header">
        <h2>Quick Actions</h2>
    </div>
    <div style="display: flex; gap: 15px; flex-wrap: wrap;">
        <a href="{{ route('customer.orders') }}" class="action-btn primary">View All Orders</a>
        <a href="{{ route('cart') }}" class="action-btn">Go to Cart</a>
        <a href="{{ route('customer.profile') }}" class="action-btn">Update Profile</a>
        <a href="{{ route('home') }}" class="action-btn">Continue Shopping</a>
    </div>
</div>
@endsection