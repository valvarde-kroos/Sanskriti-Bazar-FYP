@extends('vendor.layout.main')

@section('title', 'Dashboard')

@section('content')
<div class="welcome-section">
    <h1>Welcome Vendor</h1>
    <p>Here's an overview of your store performance</p>
</div>

<!-- Dashboard Cards -->
<div class="dashboard-cards">
    <div class="stat-card">
        <div class="card-header">
            <h3>Total Products</h3>
        </div>
        <div class="card-body">
            <p class="card-value">{{ $totalProducts ?? 45 }}</p>
            <p class="card-subtitle">Active products in store</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="card-header">
            <h3>Total Orders</h3>
        </div>
        <div class="card-body">
            <p class="card-value">{{ $totalOrders ?? 128 }}</p>
            <p class="card-subtitle">Orders received</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="card-header">
            <h3>Total Sales</h3>
        </div>
        <div class="card-body">
            <p class="card-value">Rs. {{ number_format($totalRevenue ?? 45680) }}</p>
            <p class="card-subtitle">Revenue generated</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="card-header">
            <h3>Pending Orders</h3>
        </div>
        <div class="card-body">
            <p class="card-value">{{ $pendingOrders ?? 12 }}</p>
            <p class="card-subtitle">Awaiting processing</p>
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
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>ORD-001</td>
                    <td>Ram Sharma</td>
                    <td>Madal</td>
                    <td>Rs. 5,000</td>
                    <td><span class="badge completed">Completed</span></td>
                    <td>2024-03-10</td>
                </tr>
                <tr>
                    <td>ORD-002</td>
                    <td>Sita Rai</td>
                    <td>Sarangi</td>
                    <td>Rs. 8,500</td>
                    <td><span class="badge pending">Pending</span></td>
                    <td>2024-03-11</td>
                </tr>
                <tr>
                    <td>ORD-003</td>
                    <td>Hari Gurung</td>
                    <td>Bansuri</td>
                    <td>Rs. 3,000</td>
                    <td><span class="badge processing">Processing</span></td>
                    <td>2024-03-11</td>
                </tr>
                <tr>
                    <td>ORD-004</td>
                    <td>Maya Tamang</td>
                    <td>Damphu</td>
                    <td>Rs. 4,500</td>
                    <td><span class="badge completed">Completed</span></td>
                    <td>2024-03-12</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('styles')
<style>
    .welcome-section {
        margin-bottom: 30px;
    }

    .welcome-section h1 {
        font-size: 28px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 8px;
    }

    .welcome-section p {
        font-size: 14px;
        color: #7f8c8d;
    }

    .dashboard-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    .card-header {
        background: #3498db;
        padding: 15px 20px;
    }

    .card-header h3 {
        font-size: 14px;
        font-weight: 600;
        color: #fff;
    }

    .card-body {
        padding: 20px;
    }

    .card-value {
        font-size: 32px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .card-subtitle {
        font-size: 13px;
        color: #7f8c8d;
    }

    .section-card {
        background: #fff;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .section-header {
        margin-bottom: 20px;
    }

    .section-header h2 {
        font-size: 20px;
        font-weight: 700;
        color: #2c3e50;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead {
        background: #f8f9fa;
    }

    .data-table th {
        padding: 12px 16px;
        text-align: left;
        font-size: 13px;
        font-weight: 600;
        color: #7f8c8d;
        text-transform: uppercase;
        border-bottom: 2px solid #e0e0e0;
    }

    .data-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f3f5;
        font-size: 14px;
        color: #2c3e50;
    }

    .data-table tbody tr:hover {
        background: #f8f9fa;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .badge.completed {
        background: #d1fae5;
        color: #065f46;
    }

    .badge.pending {
        background: #fef3c7;
        color: #92400e;
    }

    .badge.processing {
        background: #dbeafe;
        color: #1e40af;
    }

    @media (max-width: 768px) {
        .dashboard-cards {
            grid-template-columns: 1fr;
        }

        .table-responsive {
            overflow-x: scroll;
        }
    }
</style>
@endsection
