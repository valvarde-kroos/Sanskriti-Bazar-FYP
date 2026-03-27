@extends('vendor.layout.main')

@section('title', 'Sales Management')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Management - Vendor Dashboard</title>
    <!-- Bootstrap CSS for easy styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Custom CSS for better appearance */
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        
        /* Summary Cards Styling */
        .summary-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
            margin-bottom: 20px;
        }
        
        .summary-card h3 {
            color: #333;
            margin-bottom: 10px;
            font-size: 2rem;
            font-weight: bold;
        }
        
        .summary-card p {
            color: #666;
            margin: 0;
            font-size: 1.1rem;
        }
        
        /* Different colors for each card */
        .total-sales { border-left: 5px solid #28a745; }
        .total-earnings { border-left: 5px solid #007bff; }
        .total-orders { border-left: 5px solid #ffc107; }
        
        /* Table styling */
        .sales-table {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        /* Status badge colors */
        .status-pending { 
            background-color: #dc3545; 
            color: white; 
            padding: 5px 10px; 
            border-radius: 15px; 
            font-size: 0.8rem;
        }
        
        .status-processing { 
            background-color: #007bff; 
            color: white; 
            padding: 5px 10px; 
            border-radius: 15px; 
            font-size: 0.8rem;
        }
        
        .status-completed { 
            background-color: #28a745; 
            color: white; 
            padding: 5px 10px; 
            border-radius: 15px; 
            font-size: 0.8rem;
        }
        
        /* Filter section styling */
        .filter-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        /* Button styling */
        .btn-export {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
        }
        
        .btn-export:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        
        .btn-filter {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
        }
        
        .btn-filter:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="mb-2">Sales Management</h1>
                <p class="text-muted">Track your sales performance and earnings</p>
            </div>
        </div>

        <!-- Summary Cards Section -->
        <div class="row mb-4">
            <!-- Total Sales Card -->
            <div class="col-md-4">
                <div class="summary-card total-sales">
                    <i class="fas fa-dollar-sign fa-2x text-success mb-2"></i>
                    <h3 id="totalSales">Rs. 15,750</h3>
                    <p>Total Sales</p>
                </div>
            </div>
            
            <!-- Total Earnings Card -->
            <div class="col-md-4">
                <div class="summary-card total-earnings">
                    <i class="fas fa-wallet fa-2x text-primary mb-2"></i>
                    <h3 id="totalEarnings">Rs. 14,175</h3>
                    <p>Total Earnings (90%)</p>
                </div>
            </div>
            
            <!-- Total Orders Card -->
            <div class="col-md-4">
                <div class="summary-card total-orders">
                    <i class="fas fa-shopping-cart fa-2x text-warning mb-2"></i>
                    <h3 id="totalOrders">5</h3>
                    <p>Total Orders</p>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="filter-section">
                    <div class="row align-items-end">
                        <div class="col-md-3">
                            <label for="startDate" class="form-label">Start Date:</label>
                            <input type="date" class="form-control" id="startDate">
                        </div>
                        <div class="col-md-3">
                            <label for="endDate" class="form-label">End Date:</label>
                            <input type="date" class="form-control" id="endDate">
                        </div>
                        <div class="col-md-3">
                            <label for="statusFilter" class="form-label">Status:</label>
                            <select class="form-select" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-filter me-2" onclick="filterSales()">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                            <button class="btn btn-export" onclick="exportSales()">
                                <i class="fas fa-download"></i> Export
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Table Section -->
        <div class="row">
            <div class="col-12">
                <div class="sales-table">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="salesTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Product Name</th>
                                    <th>Total Amount</th>
                                    <th>Earning</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Sample Data Row 1 -->
                                <tr data-status="completed" data-date="2024-04-27">
                                    <td><strong>#ORD001</strong></td>
                                    <td>Traditional Handicraft Set</td>
                                    <td><strong>Rs. 2,500</strong></td>
                                    <td><strong class="text-success">Rs. 2,250</strong></td>
                                    <td><span class="status-completed">Completed</span></td>
                                    <td>April 27, 2024</td>
                                </tr>
                                
                                <!-- Sample Data Row 2 -->
                                <tr data-status="processing" data-date="2024-04-26">
                                    <td><strong>#ORD002</strong></td>
                                    <td>Handwoven Textile</td>
                                    <td><strong>Rs. 3,200</strong></td>
                                    <td><strong class="text-success">Rs. 2,880</strong></td>
                                    <td><span class="status-processing">Processing</span></td>
                                    <td>April 26, 2024</td>
                                </tr>
                                
                                <!-- Sample Data Row 3 -->
                                <tr data-status="pending" data-date="2024-04-25">
                                    <td><strong>#ORD003</strong></td>
                                    <td>Cultural Artifacts</td>
                                    <td><strong>Rs. 4,500</strong></td>
                                    <td><strong class="text-success">Rs. 4,050</strong></td>
                                    <td><span class="status-pending">Pending</span></td>
                                    <td>April 25, 2024</td>
                                </tr>
                                
                                <!-- Sample Data Row 4 -->
                                <tr data-status="completed" data-date="2024-04-24">
                                    <td><strong>#ORD004</strong></td>
                                    <td>Decorative Items</td>
                                    <td><strong>Rs. 1,800</strong></td>
                                    <td><strong class="text-success">Rs. 1,620</strong></td>
                                    <td><span class="status-completed">Completed</span></td>
                                    <td>April 24, 2024</td>
                                </tr>
                                
                                <!-- Sample Data Row 5 -->
                                <tr data-status="processing" data-date="2024-04-23">
                                    <td><strong>#ORD005</strong></td>
                                    <td>Premium Craft Collection</td>
                                    <td><strong>Rs. 3,750</strong></td>
                                    <td><strong class="text-success">Rs. 3,375</strong></td>
                                    <td><span class="status-processing">Processing</span></td>
                                    <td>April 23, 2024</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sample sales data for JavaScript operations
        const salesData = [
            {
                orderId: '#ORD001',
                productName: 'Traditional Handicraft Set',
                totalAmount: 2500,
                earning: 2250,
                status: 'completed',
                date: '2024-04-27',
                displayDate: 'April 27, 2024'
            },
            {
                orderId: '#ORD002',
                productName: 'Handwoven Textile',
                totalAmount: 3200,
                earning: 2880,
                status: 'processing',
                date: '2024-04-26',
                displayDate: 'April 26, 2024'
            },
            {
                orderId: '#ORD003',
                productName: 'Cultural Artifacts',
                totalAmount: 4500,
                earning: 4050,
                status: 'pending',
                date: '2024-04-25',
                displayDate: 'April 25, 2024'
            },
            {
                orderId: '#ORD004',
                productName: 'Decorative Items',
                totalAmount: 1800,
                earning: 1620,
                status: 'completed',
                date: '2024-04-24',
                displayDate: 'April 24, 2024'
            },
            {
                orderId: '#ORD005',
                productName: 'Premium Craft Collection',
                totalAmount: 3750,
                earning: 3375,
                status: 'processing',
                date: '2024-04-23',
                displayDate: 'April 23, 2024'
            }
        ];

        // Function to filter sales based on date and status
        function filterSales() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            const statusFilter = document.getElementById('statusFilter').value;
            
            // Get all table rows
            const rows = document.querySelectorAll('#salesTable tbody tr');
            
            let visibleRows = 0;
            let filteredTotal = 0;
            let filteredEarnings = 0;
            
            // Loop through each row and check if it matches the filter
            rows.forEach(row => {
                const rowDate = row.getAttribute('data-date');
                const rowStatus = row.getAttribute('data-status');
                
                let showRow = true;
                
                // Check date filter
                if (startDate && rowDate < startDate) {
                    showRow = false;
                }
                if (endDate && rowDate > endDate) {
                    showRow = false;
                }
                
                // Check status filter
                if (statusFilter && rowStatus !== statusFilter) {
                    showRow = false;
                }
                
                // Show or hide the row
                if (showRow) {
                    row.style.display = '';
                    visibleRows++;
                    
                    // Calculate filtered totals
                    const salesItem = salesData.find(item => item.orderId === row.cells[0].textContent);
                    if (salesItem) {
                        filteredTotal += salesItem.totalAmount;
                        filteredEarnings += salesItem.earning;
                    }
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Update summary cards with filtered data
            if (startDate || endDate || statusFilter) {
                document.getElementById('totalSales').textContent = `Rs. ${filteredTotal.toLocaleString()}`;
                document.getElementById('totalEarnings').textContent = `Rs. ${filteredEarnings.toLocaleString()}`;
                document.getElementById('totalOrders').textContent = visibleRows;
            }
            
            // Show success message
            showMessage(`Filter applied! Showing ${visibleRows} orders.`, 'success');
        }

        // Function to export sales data (creates a CSV file)
        function exportSales() {
            // Create CSV header
            let csvContent = "Order ID,Product Name,Total Amount,Earning,Status,Date\n";
            
            // Get visible rows only
            const visibleRows = document.querySelectorAll('#salesTable tbody tr[style=""], #salesTable tbody tr:not([style])');
            
            // Add data for each visible row
            visibleRows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const orderId = cells[0].textContent.trim();
                const productName = cells[1].textContent.trim();
                const totalAmount = cells[2].textContent.trim();
                const earning = cells[3].textContent.trim();
                const status = cells[4].textContent.trim();
                const date = cells[5].textContent.trim();
                
                csvContent += `"${orderId}","${productName}","${totalAmount}","${earning}","${status}","${date}"\n`;
            });
            
            // Create and download the file
            const blob = new Blob([csvContent], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = 'sales_report.csv';
            link.click();
            window.URL.revokeObjectURL(url);
            
            // Show success message
            showMessage('Sales data exported successfully!', 'success');
        }

        // Function to show messages to the user
        function showMessage(message, type = 'success') {
            // Create alert element
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
            alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            alertDiv.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            // Add to page
            document.body.appendChild(alertDiv);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 3000);
        }

        // Function to reset all filters
        function resetFilters() {
            // Clear all filter inputs
            document.getElementById('startDate').value = '';
            document.getElementById('endDate').value = '';
            document.getElementById('statusFilter').value = '';
            
            // Show all rows
            const rows = document.querySelectorAll('#salesTable tbody tr');
            rows.forEach(row => {
                row.style.display = '';
            });
            
            // Reset summary cards to original values
            document.getElementById('totalSales').textContent = 'Rs. 15,750';
            document.getElementById('totalEarnings').textContent = 'Rs. 14,175';
            document.getElementById('totalOrders').textContent = '5';
            
            showMessage('Filters reset successfully!', 'info');
        }

        // Initialize the page when it loads
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Sales Management page loaded successfully!');
            console.log('Available functions:');
            console.log('- filterSales(): Filter sales by date and status');
            console.log('- exportSales(): Export visible sales data to CSV');
            console.log('- resetFilters(): Clear all filters and show all data');
            
            // Set default dates (last 30 days)
            const today = new Date();
            const thirtyDaysAgo = new Date(today.getTime() - (30 * 24 * 60 * 60 * 1000));
            
            document.getElementById('endDate').value = today.toISOString().split('T')[0];
            document.getElementById('startDate').value = thirtyDaysAgo.toISOString().split('T')[0];
        });

        // Add a reset button functionality (you can add this button to the HTML if needed)
        function addResetButton() {
            const resetBtn = document.createElement('button');
            resetBtn.className = 'btn btn-secondary ms-2';
            resetBtn.innerHTML = '<i class="fas fa-refresh"></i> Reset';
            resetBtn.onclick = resetFilters;
            
            // Add to the filter section
            const filterSection = document.querySelector('.col-md-3:last-child');
            filterSection.appendChild(resetBtn);
        }

        // Call this if you want to add the reset button
        // addResetButton();
    </script>
</body>
</html>
@endsection