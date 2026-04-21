@extends('admin.layout.main')

@section('title', 'Admin Dashboard')

@section('content')
<div class="admin-dashboard">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1>AdminDashboard</h1>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <!-- Categories Card -->
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Categories</span>
                <div class="stat-icon blue">
                    <i class="fas fa-tags"></i>
                </div>
            </div>
            <div class="stat-value">{{ $totalCategories }}</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i>
                <span>{{ number_format($productsGrowth, 1) }}% Since last week</span>
            </div>
        </div>

        <!-- Vendors Card -->
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Vendors</span>
                <div class="stat-icon purple">
                    <i class="fas fa-store"></i>
                </div>
            </div>
            <div class="stat-value">{{ $totalVendors }}</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i>
                <span>{{ number_format($usersGrowth, 1) }}% Since last week</span>
            </div>
        </div>

        <!-- Customers Card -->
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Customers</span>
                <div class="stat-icon cyan">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="stat-value">{{ $totalCustomers }}</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i>
                <span>{{ number_format($usersGrowth, 1) }}% Since last week</span>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Revenue</span>
                <div class="stat-icon green">
                    <i class="fas fa-rupee-sign"></i>
                </div>
            </div>
            <div class="stat-value">Rs. {{ number_format($totalRevenue / 1000, 1) }}K</div>
            <div class="stat-change {{ $revenueGrowth >= 0 ? 'positive' : 'negative' }}">
                <i class="fas fa-arrow-{{ $revenueGrowth >= 0 ? 'up' : 'down' }}"></i>
                <span>{{ number_format(abs($revenueGrowth), 1) }}% Since last week</span>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-row">
        <!-- Total Revenue Chart -->
        <div class="chart-card large">
            <div class="chart-header">
                <h3>Total Revenue</h3>
                <div class="chart-controls">
                    <select class="chart-select">
                        <option>2021</option>
                        <option selected>2026</option>
                    </select>
                    <input type="text" class="chart-search" placeholder="Search...">
                </div>
            </div>
            <div class="chart-body">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Categories Distribution Chart -->
        <div class="chart-card small">
            <div class="chart-header">
                <h3>Categories Distribution</h3>
                <div class="chart-controls">
                    <select class="chart-select">
                        <option selected>Jan</option>
                        <option>Feb</option>
                        <option>Mar</option>
                    </select>
                    <input type="text" class="chart-search" placeholder="Search...">
                </div>
            </div>
            <div class="chart-body">
                <canvas id="categoriesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Bottom Section -->
    <div class="bottom-row">
        <!-- Sales/Revenue Bar Chart -->
        <div class="chart-card">
            <div class="chart-header">
                <h3>Sales/Revenue</h3>
                <button class="btn-menu"><i class="fas fa-ellipsis-h"></i></button>
            </div>
            <div class="chart-body">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Recent Users Table -->
        <div class="table-card">
            <div class="chart-header">
                <h3>Recent Users</h3>
                <button class="btn-menu"><i class="fas fa-ellipsis-h"></i></button>
            </div>
            <div class="table-body">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Assigned</th>
                            <th>Orders</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $recentUsers = collect()
                                ->merge($recentVendors->take(3))
                                ->merge($recentCustomers->take(3))
                                ->sortByDesc('created_at')
                                ->take(6);
                        @endphp
                        
                        @foreach($recentUsers as $user)
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar">{{ substr($user->name, 0, 1) }}</div>
                                    <div class="user-info">
                                        <div class="user-name">{{ $user->name }}</div>
                                        <div class="user-email">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="role-badge {{ $user->role }}">{{ ucfirst($user->role) }}</span></td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                @if($user->role === 'customer')
                                    {{ $user->orders->count() ?? 0 }}
                                @else
                                    {{ $user->products->count() ?? 0 }} products
                                @endif
                            </td>
                            <td>
                                <span class="status-badge active">Active</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .admin-dashboard {
        padding: 30px;
        background: #f5f7fa;
        min-height: 100vh;
    }

    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .dashboard-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #1a202c;
        margin: 0;
    }

    .header-actions {
        display: flex;
        gap: 12px;
    }

    .btn-secondary {
        padding: 10px 20px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        color: #4a5568;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-secondary:hover {
        background: #f7fafc;
        border-color: #cbd5e0;
    }

    .btn-primary {
        padding: 10px 20px;
        background: #4299e1;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        color: white;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-primary:hover {
        background: #3182ce;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .stat-label {
        font-size: 14px;
        color: #718096;
        font-weight: 500;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: white;
    }

    .stat-icon.blue {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .stat-icon.purple {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .stat-icon.cyan {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .stat-icon.green {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 8px;
    }

    .stat-change {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 500;
    }

    .stat-change.positive {
        color: #48bb78;
    }

    .stat-change.negative {
        color: #f56565;
    }

    .stat-change i {
        font-size: 12px;
    }

    /* Charts Row */
    .charts-row {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }

    .chart-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 24px;
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .chart-header h3 {
        font-size: 18px;
        font-weight: 600;
        color: #1a202c;
        margin: 0;
    }

    .chart-controls {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .chart-select {
        padding: 6px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-size: 13px;
        color: #4a5568;
        background: white;
        cursor: pointer;
    }

    .chart-search {
        padding: 6px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-size: 13px;
        color: #4a5568;
        width: 120px;
    }

    .chart-body {
        height: 300px;
        position: relative;
    }

    .btn-menu {
        background: none;
        border: none;
        color: #a0aec0;
        font-size: 18px;
        cursor: pointer;
        padding: 4px 8px;
    }

    .btn-menu:hover {
        color: #4a5568;
    }

    /* Bottom Row */
    .bottom-row {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 20px;
    }

    /* Table */
    .table-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 24px;
    }

    .table-body {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead th {
        text-align: left;
        padding: 12px;
        font-size: 13px;
        font-weight: 600;
        color: #718096;
        border-bottom: 1px solid #e2e8f0;
    }

    .data-table tbody td {
        padding: 16px 12px;
        font-size: 14px;
        color: #4a5568;
        border-bottom: 1px solid #f7fafc;
    }

    .data-table tbody tr:hover {
        background: #f7fafc;
    }

    .user-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 16px;
    }

    .user-info {
        display: flex;
        flex-direction: column;
    }

    .user-name {
        font-weight: 600;
        color: #1a202c;
        font-size: 14px;
    }

    .user-email {
        font-size: 12px;
        color: #a0aec0;
    }

    .role-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }

    .role-badge.vendor {
        background: #fef5e7;
        color: #f39c12;
    }

    .role-badge.customer {
        background: #ebf8ff;
        color: #3182ce;
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-badge.active {
        background: #c6f6d5;
        color: #22543d;
    }

    .status-badge.pending {
        background: #fef5e7;
        color: #f39c12;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .charts-row {
            grid-template-columns: 1fr;
        }

        .bottom-row {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }
    }
</style>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get data from PHP
        const categoriesData = @json($productsPerCategory);
        const monthlySalesData = @json($monthlySales);

        // Total Revenue Line Chart
        const revenueCtx = document.getElementById('revenueChart');
        if (revenueCtx) {
            new Chart(revenueCtx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: monthlySalesData.map(item => item.month),
                    datasets: [{
                        label: 'Revenue',
                        data: monthlySalesData.map(item => item.sales),
                        borderColor: '#4299e1',
                        backgroundColor: 'rgba(66, 153, 225, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#4299e1',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: function(context) {
                                    return 'Rs. ' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f7fafc',
                                drawBorder: false
                            },
                            ticks: {
                                callback: function(value) {
                                    return 'Rs. ' + (value / 1000) + 'K';
                                },
                                color: '#a0aec0',
                                font: {
                                    size: 12
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                color: '#a0aec0',
                                font: {
                                    size: 12
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });
        }

        // Categories Distribution Doughnut Chart
        const categoriesCtx = document.getElementById('categoriesChart');
        if (categoriesCtx && categoriesData.length > 0) {
            new Chart(categoriesCtx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: categoriesData.map(item => item.name),
                    datasets: [{
                        data: categoriesData.map(item => item.count),
                        backgroundColor: [
                            '#FF6B9D',  // Pink/Red
                            '#FFA726',  // Orange
                            '#FDD835',  // Yellow
                            '#26C6DA',  // Cyan/Green
                            '#42A5F5',  // Blue
                            '#AB47BC',  // Purple
                            '#66BB6A',  // Green
                            '#EF5350'   // Red
                        ],
                        borderWidth: 3,
                        borderColor: '#ffffff',
                        cutout: '75%',
                        spacing: 2
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
                                pointStyle: 'circle',
                                font: {
                                    size: 13,
                                    family: "'Inter', sans-serif"
                                },
                                color: '#4a5568',
                                generateLabels: function(chart) {
                                    const data = chart.data;
                                    if (data.labels.length && data.datasets.length) {
                                        return data.labels.map((label, i) => {
                                            const value = data.datasets[0].data[i];
                                            const backgroundColor = data.datasets[0].backgroundColor[i];
                                            return {
                                                text: `${label} (${value})`,
                                                fillStyle: backgroundColor,
                                                hidden: false,
                                                index: i
                                            };
                                        });
                                    }
                                    return [];
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1a202c',
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            padding: 12,
                            cornerRadius: 8,
                            displayColors: true,
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return `${label}: ${value} products (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Sales Bar Chart
        const salesCtx = document.getElementById('salesChart');
        if (salesCtx) {
            new Chart(salesCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Sales',
                        data: [45, 52, 38, 65, 42, 80],
                        backgroundColor: '#4299e1',
                        borderRadius: 6,
                        barThickness: 30,
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
                                color: '#f7fafc',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#a0aec0',
                                font: {
                                    size: 12
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                color: '#a0aec0',
                                font: {
                                    size: 12
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endsection
