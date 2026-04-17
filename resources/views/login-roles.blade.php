@extends('layout.main')

@section('hyasabicontentauncha')
<div class="signup-wrapper">
    <div class="role-selection-card">
        <h1>Choose Your Login Type</h1>
        <p>Select your role to access the appropriate login page</p>
        
        <div class="role-buttons">
            <a href="{{ route('login', ['role' => 'admin']) }}" class="role-btn admin">
                <div class="role-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h3>Admin Portal</h3>
                <p>Access administrative dashboard</p>
            </a>
            
            <a href="{{ route('login', ['role' => 'vendor']) }}" class="role-btn vendor">
                <div class="role-icon">
                    <i class="fas fa-store"></i>
                </div>
                <h3>Vendor Panel</h3>
                <p>Manage your products and orders</p>
            </a>
            
            <a href="{{ route('login', ['role' => 'customer']) }}" class="role-btn customer">
                <div class="role-icon">
                    <i class="fas fa-user"></i>
                </div>
                <h3>Customer Login</h3>
                <p>Shop and explore products</p>
            </a>
        </div>
    </div>
</div>

<style>
    .role-selection-card {
        background: white;
        padding: 60px 40px;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        text-align: center;
        max-width: 800px;
        width: 100%;
    }

    .role-selection-card h1 {
        font-size: 36px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 15px;
    }

    .role-selection-card > p {
        font-size: 18px;
        color: #718096;
        margin-bottom: 50px;
    }

    .role-buttons {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }

    .role-btn {
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 15px;
        padding: 40px 30px;
        text-decoration: none;
        transition: all 0.3s ease;
        display: block;
        position: relative;
        overflow: hidden;
    }

    .role-btn:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }

    .role-btn.admin:hover {
        border-color: #667eea;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
    }

    .role-btn.vendor:hover {
        border-color: #48bb78;
        background: linear-gradient(135deg, rgba(72, 187, 120, 0.05) 0%, rgba(56, 178, 172, 0.05) 100%);
    }

    .role-btn.customer:hover {
        border-color: #ed8936;
        background: linear-gradient(135deg, rgba(237, 137, 54, 0.05) 0%, rgba(245, 101, 101, 0.05) 100%);
    }

    .role-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 32px;
        color: white;
        transition: all 0.3s ease;
    }

    .role-btn.admin .role-icon {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .role-btn.vendor .role-icon {
        background: linear-gradient(135deg, #48bb78 0%, #38b2ac 100%);
    }

    .role-btn.customer .role-icon {
        background: linear-gradient(135deg, #ed8936 0%, #f56565 100%);
    }

    .role-btn h3 {
        font-size: 22px;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 10px;
    }

    .role-btn p {
        font-size: 14px;
        color: #718096;
        margin: 0;
    }

    @media (max-width: 768px) {
        .role-selection-card {
            padding: 40px 30px;
        }
        
        .role-selection-card h1 {
            font-size: 28px;
        }
        
        .role-buttons {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .role-btn {
            padding: 30px 25px;
        }
        
        .role-icon {
            width: 60px;
            height: 60px;
            font-size: 24px;
        }
    }
</style>
@endsection