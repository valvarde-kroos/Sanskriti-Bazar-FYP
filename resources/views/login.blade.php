@extends('layout.main')

@section('hyasabicontentauncha')
<div class="signup-wrapper">
    <div class="signup-card">
        <div class="signup-left">
            <h1 id="leftTitle">Welcome Back!</h1>
            <p id="leftDescription">Login to access your account and explore traditional Nepali musical instruments.</p>
            <div class="left-illustration">
                <i class="fas fa-music"></i>
            </div>
        </div>

        <div class="signup-right">
            <h2>Login to Sanskriti Bazar</h2>

            @if(session('success'))
                <p class="success-msg">{{ session('success') }}</p>
            @endif

            @if(session('message'))
                <p class="info-msg">{{ session('message') }}</p>
            @endif

            @if(session('error'))
                <p class="error-msg">{{ session('error') }}</p>
            @endif

            <form method="POST" action="{{ route('login.post') }}" id="loginForm">
                @csrf

                <!-- Role Selection -->
                <div class="form-group">
                    <label>Login As</label>
                    <div class="role-selector">
                        <div class="role-option" data-role="customer">
                            <input type="radio" name="role" value="customer" id="role-customer" checked>
                            <label for="role-customer">
                                <i class="fas fa-user"></i>
                                <span>Customer</span>
                            </label>
                        </div>
                        <div class="role-option" data-role="vendor">
                            <input type="radio" name="role" value="vendor" id="role-vendor">
                            <label for="role-vendor">
                                <i class="fas fa-store"></i>
                                <span>Vendor</span>
                            </label>
                        </div>
                        <div class="role-option" data-role="admin">
                            <input type="radio" name="role" value="admin" id="role-admin">
                            <label for="role-admin">
                                <i class="fas fa-user-shield"></i>
                                <span>Admin</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required>
                    @error('email')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter your password" required>
                    @error('password')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="signup-submit">Login</button>
            </form>

            <p class="forgot-password-link">
                <a href="{{ route('forgot-password') }}">Forgot Password?</a>
            </p>

            <p>Don't have an account? <a href="{{ route('signup') }}">Sign Up</a></p>
        </div>
    </div>
</div>

<style>
    .info-msg {
        background: #dbeafe;
        color: #1e40af;
        padding: 12px 15px;
        border-radius: 6px;
        margin-bottom: 20px;
        border: 1px solid #93c5fd;
        font-size: 14px;
        text-align: center;
    }

    .error-msg {
        background: #fee2e2;
        color: #991b1b;
        padding: 12px 15px;
        border-radius: 6px;
        margin-bottom: 20px;
        border: 1px solid #fca5a5;
        font-size: 14px;
        text-align: center;
    }

    .forgot-password-link {
        text-align: center;
        margin: 15px 0 20px 0;
        font-size: 14px;
    }

    .forgot-password-link a {
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s;
    }

    .forgot-password-link a:hover {
        color: #764ba2;
        text-decoration: underline;
    }

    /* Role Selector Styles */
    .role-selector {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-bottom: 10px;
    }

    .role-option {
        position: relative;
    }

    .role-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .role-option label {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 16px 8px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #f9fafb;
        text-align: center;
    }

    .role-option label i {
        font-size: 24px;
        margin-bottom: 8px;
        color: #6b7280;
        transition: all 0.3s ease;
    }

    .role-option label span {
        font-size: 13px;
        font-weight: 500;
        color: #374151;
        transition: all 0.3s ease;
    }

    .role-option input[type="radio"]:checked + label {
        border-color: #667eea;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    }

    .role-option input[type="radio"]:checked + label i {
        color: #667eea;
    }

    .role-option input[type="radio"]:checked + label span {
        color: #667eea;
        font-weight: 600;
    }

    .role-option label:hover {
        border-color: #667eea;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
    }

    .left-illustration {
        margin-top: 40px;
        text-align: center;
    }

    .left-illustration i {
        font-size: 80px;
        color: rgba(255, 255, 255, 0.3);
    }

    @media (max-width: 768px) {
        .role-selector {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .role-option label {
            flex-direction: row;
            justify-content: flex-start;
            padding: 12px 16px;
        }

        .role-option label i {
            margin-bottom: 0;
            margin-right: 12px;
            font-size: 20px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleOptions = document.querySelectorAll('.role-option input[type="radio"]');
        const leftTitle = document.getElementById('leftTitle');
        const leftDescription = document.getElementById('leftDescription');

        const roleContent = {
            customer: {
                title: 'Welcome Back!',
                description: 'Login to access your account and explore traditional Nepali musical instruments.'
            },
            vendor: {
                title: 'Vendor Panel',
                description: 'Login to manage your products, orders and grow your business with Sanskriti Bazar.'
            },
            admin: {
                title: 'Admin Portal',
                description: 'Access your administrative dashboard and manage the entire marketplace.'
            }
        };

        roleOptions.forEach(option => {
            option.addEventListener('change', function() {
                const role = this.value;
                const content = roleContent[role];
                
                leftTitle.textContent = content.title;
                leftDescription.textContent = content.description;
            });
        });
    });
</script>
@endsection
