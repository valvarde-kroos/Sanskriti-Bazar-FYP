@extends('vendor.layout.main')

@section('title', 'Sales Management')

@section('content')
<div class="welcome-section">
    <h1>Sales Management</h1>
    <p>View your sales and earnings</p>
</div>

<!-- Summary Cards Section -->
<div class="dashboard-cards">
    <div class="stat-card">
        <div class="card-header">
            <h3>Total Sales Amount</h3>
        </div>
        <div class="card-body">
            <p class="card-value">Rs. {{ number_format($orders->where('status', 'delivered')->sum('total_price'), 2) }}</p>
            <p class="card-subtitle">All completed sales</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="card-header">
            <h3>My Earnings</h3>
        </div>
        <div class="card-body">
            <p class="card-value">Rs. {{ number_format($orders->where('status', 'delivered')->sum('total_price') * 0.9, 2) }}</p>
            <p class="card-subtitle">Your share (90%)</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="card-header">
            <h3>Orders Completed</h3>
        </div>
        <div class="card-body">
            <p class="card-value">{{ $orders->where('status', 'delivered')->count() }}</p>
            <p class="card-subtitle">Successfully delivered</p>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="section-card">
    <div class="section-header">
        <h2>Filter Sales</h2>
    </div>
    
    <div class="filter-row">
        <div class="filter-group">
            <label for="statusFilter" class="form-label">Status:</label>
            <select class="form-control" id="statusFilter" onchange="filterSales()">
                <option value="">All Orders</option>
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
            </select>
        </div>
    </div>
</div>

<!-- Sales Table Section -->
<div class="section-card">
    <div class="section-header">
        <h2>Sales Records</h2>
    </div>
    <div class="table-responsive">
        <table class="data-table" id="salesTable">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr data-status="{{ $order->status === 'delivered' ? 'completed' : 'pending' }}">
                    <td><strong>#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                    <td>{{ $order->product->post_title }}</td>
                    <td>{{ $order->quantity }} pieces</td>
                    <td><strong>Rs. {{ number_format($order->total_price, 2) }}</strong></td>
                    <td>
                        @if($order->status === 'delivered')
                            <span class="badge completed">Completed</span>
                        @else
                            <span class="badge pending">Pending</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No sales records found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Filter Section */
    .filter-row {
        display: flex;
        gap: 20px;
        margin-top: 15px;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        min-width: 200px;
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 8px;
        color: #2c3e50;
        font-size: 15px;
    }

    .form-control {
        padding: 12px 15px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 15px;
        transition: all 0.3s ease;
        background: #ffffff;
    }

    .form-control:focus {
        outline: none;
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    }

    /* Table Styles */
    .table-responsive {
        overflow-x: auto;
        margin-top: 20px;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        background: #ffffff;
        border-radius: 8px;
        overflow: hidden;
    }

    .data-table thead {
        background: #f8f9fa;
    }

    .data-table th {
        padding: 15px 20px;
        text-align: left;
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e5e7eb;
    }

    .data-table td {
        padding: 15px 20px;
        border-bottom: 1px solid #f3f4f6;
        font-size: 15px;
        color: #1f2937;
    }

    .data-table tbody tr:hover {
        background: #f8f9fa;
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Badge Styles */
    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge.completed {
        background: #d1fae5;
        color: #065f46;
    }

    .badge.pending {
        background: #fef3c7;
        color: #92400e;
    }

    /* Text Center for Empty State */
    .text-center {
        text-align: center;
        color: #6b7280;
        font-style: italic;
        padding: 40px 20px;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .filter-row {
            flex-direction: column;
            gap: 15px;
        }
        
        .filter-group {
            min-width: 100%;
        }
        
        .data-table {
            font-size: 14px;
        }
        
        .data-table th,
        .data-table td {
            padding: 12px 15px;
        }
        
        .data-table th {
            font-size: 12px;
        }
    }

    @media (max-width: 480px) {
        .data-table th,
        .data-table td {
            padding: 10px 12px;
        }
        
        .badge {
            font-size: 11px;
            padding: 4px 8px;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    // Simple filter function for status
    function filterSales() {
        const statusFilter = document.getElementById('statusFilter').value;
        const rows = document.querySelectorAll('#salesTable tbody tr');
        
        let visibleRows = 0;
        
        rows.forEach(row => {
            // Skip empty state row
            if (row.cells.length === 1) {
                return;
            }
            
            const rowStatus = row.getAttribute('data-status');
            let showRow = true;
            
            // Check status filter
            if (statusFilter && rowStatus !== statusFilter) {
                showRow = false;
            }
            
            // Show or hide the row
            if (showRow) {
                row.style.display = '';
                visibleRows++;
            } else {
                row.style.display = 'none';
            }
        });
        
        console.log(`Showing ${visibleRows} orders`);
    }

    // Initialize the page when it loads
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Sales Management page loaded successfully!');
    });
</script>
@endsection