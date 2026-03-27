<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Vendor Dashboard') - Sanskriti Bazar</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
            
            .content-area {
                padding: 15px;
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
