<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Vendor Dashboard') - Sanskriti Bazar</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f5f6fa;
            color: #2c3e50;
        }

        .vendor-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            margin-left: 220px;
        }

        .content-area {
            padding: 30px;
        }

        /* Shared styles for all vendor pages */
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
            margin-bottom: 20px;
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
            .main-content {
                margin-left: 0;
            }
            
            .content-area {
                padding: 15px;
            }

            .dashboard-cards {
                grid-template-columns: 1fr;
            }

            .table-responsive {
                overflow-x: scroll;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="vendor-wrapper">
        @include('vendor.layout.sidebar')
        
        <div class="main-content" id="mainContent">
            @include('vendor.layout.navbar')
            
            <div class="content-area">
                @yield('content')
            </div>
        </div>
    </div>

    @yield('scripts')
</body>
</html>
