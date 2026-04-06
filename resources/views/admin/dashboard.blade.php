@extends('admin.layout.main')

@section('title', 'Dashboard')

@section('content')
<!-- Dashboard Header -->
<div class="dashboard-header">
    <h1>Sanskriti Bazar Admin Dashboard</h1>
    <p class="dashboard-subtitle">Overview of your traditional instrument marketplace</p>
</div>

<!-- Overview Cards -->
<div class="overview-cards">
    <!-- Total Categories Card -->
    <div class="overview-card categories-card">
        <div class="card-content">
            <div class="card-info">
                <h3>{{ $totalCategories }}</h3>
                <p>Total Categories</p>
            </div>
            <div class="card-icon">
                <i class="fas fa-folder"></i>
            </div>
        </div>
    </div>

    <!-- Total Customers Card -->
    <div class="overview-card customers-card">
        <div class="card-content">
            <div class="card-info">
                <h3>{{ number_format($totalCustomers) }}</h3>
                <p>Total Customers</p>
            </div>
            <div class="card-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>

    <!-- Total Vendors Card -->
    <div class="overview-card vendors-card">
        <div class="card-content">
            <div class="card-info">
                <h3>{{ $totalVendors }}</h3>
                <p>Total Vendors</p>
            </div>
            <div class="card-icon">
                <i class="fas fa-store"></i>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="charts-section">
    <!-- Bar Chart - Products per Category -->
    <div class="chart-container">
        <div class="chart-card">
            <h3>Products per Category</h3>
            <canvas id="categoryChart"></canvas>
        </div>
    </div>

    <!-- Pie Chart - Vendor Status -->
    <div class="chart-container">
        <div class="chart-card">
            <h3>Vendor Status Distribution</h3>
            <canvas id="vendorChart"></canvas>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Dashboard Header */
    .dashboard-header {
        text-align: center;
        margin-bottom: 2rem;
        padding: 1.5rem 0;
    }

    .dashboard-header h1 {
        font-size: 2rem;
        font-weight: 600;
        color: #1f2937;
        margin: 0 0 0.5rem 0;
    }

    .dashboard-subtitle {
        font-size: 1rem;
        color: #6b7280;
        margin: 0;
    }

    /* Overview Cards */
    .overview-cards {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .overview-card {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border-left: 4px solid;
    }

    .overview-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    /* Card Colors */
    .categories-card {
        border-left-color: #6a0dad;
    }

    .customers-card {
        border-left-color: #4a90e2;
    }

    .vendors-card {
        border-left-color: #6a0dad;
    }

    .card-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-info h3 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 0.5rem 0;
    }

    .card-info p {
        font-size: 1rem;
        color: #6b7280;
        margin: 0;
        font-weight: 500;
    }

    .card-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: white;
    }

    .categories-card .card-icon {
        background: linear-gradient(135deg, #6a0dad 0%, #8a2be2 100%);
    }

    .customers-card .card-icon {
        background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
    }

    .vendors-card .card-icon {
        background: linear-gradient(135deg, #6a0dad 0%, #8a2be2 100%);
    }

    /* Charts Section */
    .charts-section {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .chart-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .chart-card {
        padding: 1.5rem;
    }

    .chart-card h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin: 0 0 1.5rem 0;
        text-align: center;
    }

    .chart-card canvas {
        max-height: 300px;
        width: 100% !important;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .charts-section {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .overview-cards {
            grid-template-columns: 1fr;
        }

        .dashboard-header h1 {
            font-size: 1.75rem;
        }

        .card-info h3 {
            font-size: 2rem;
        }

        .card-icon {
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
        }

        .overview-card {
            padding: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .card-content {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .dashboard-header {
            padding: 1rem 0;
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
    const vendorStatusData = @json($vendorStatusDistribution);

    // Prepare data for bar chart
    const categoryLabels = categoriesData.map(item => item.name);
    const categoryValues = categoriesData.map(item => item.count);

    // Bar Chart - Products per Category
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categoryChart = new Chart(categoryCtx, {
        type: 'bar',
        data: {
            labels: categoryLabels,
            datasets: [{
                label: 'Number of Products',
                data: categoryValues,
                backgroundColor: categoryLabels.map((_, index) => 
                    index % 2 === 0 ? '#6a0dad' : '#4a90e2'
                ),
                borderRadius: 6,
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
                    ticks: {
                        color: '#6b7280',
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        color: '#f3f4f6'
                    }
                },
                x: {
                    ticks: {
                        color: '#6b7280',
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Pie Chart - Vendor Status Distribution
    const vendorCtx = document.getElementById('vendorChart').getContext('2d');
    const vendorChart = new Chart(vendorCtx, {
        type: 'pie',
        data: {
            labels: ['Active', 'Pending', 'Suspended'],
            datasets: [{
                data: [
                    vendorStatusData.active,
                    vendorStatusData.pending,
                    vendorStatusData.suspended
                ],
                backgroundColor: [
                    '#6a0dad',
                    '#4a90e2',
                    '#c3dfff'
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
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
                        font: {
                            size: 12
                        },
                        color: '#6b7280'
                    }
                }
            }
        }
    });

    // Add some animation on page load
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.overview-card');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.5s ease';
                
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100);
            }, index * 150);
        });
    });
</script>
@endsection