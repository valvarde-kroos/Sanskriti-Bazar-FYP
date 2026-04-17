@extends('layout.main')

@section('hyasabicontentauncha')
<div class="signup-wrapper">
    <div class="signup-card">
        <div class="signup-left">
            @php
                $role = request()->get('role', 'customer');
                $leftPanelText = [
                    'admin' => ['title' => 'Admin Portal', 'description' => 'Access your administrative dashboard and manage the marketplace.'],
                    'vendor' => ['title' => 'Vendor Panel', 'description' => 'Login to manage your products, orders and grow your business.'],
                    'customer' => ['title' => 'Welcome Back!', 'description' => 'Login to access your account and explore products.']
                ];
                $currentText = $leftPanelText[$role] ?? $leftPanelText['customer'];
            @endphp
            <h1>{{ $currentText['title'] }}</h1>
            <p>{{ $currentText['description'] }}</p>
        </div>

        <div class="signup-right">
            <h2>Login</h2>

            @if(session('success'))
                <p class="success-msg">{{ session('success') }}</p>
            @endif

            @if(session('message'))
                <p class="info-msg">{{ session('message') }}</p>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Enter your email" value="{{ old('email') }}">
                    @error('email')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter your password">
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
</style>
@endsection
