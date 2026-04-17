@extends('layout.main')

@section('hyasabicontentauncha')
<div class="signup-wrapper">
    <div class="signup-card">
        <div class="signup-left">
            <h1>Forgot Password?</h1>
            <p>Don't worry! It happens to the best of us. Enter your email and we'll help you reset your password.</p>
        </div>

        <div class="signup-right">
            <h2>Forgot Password?</h2>
            <p class="subtitle">Enter your email and we'll send you a reset link</p>

            @if(session('success'))
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    <div>
                        <strong>Email Sent Successfully!</strong>
                        <p style="margin: 5px 0 0 0; font-size: 13px;">We've sent a password reset link to your email address. Please check your inbox and spam folder.</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('forgot-password.post') }}">
                @csrf

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="Enter your email address" value="{{ old('email') }}" required>
                    @error('email')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="signup-submit">Send Reset Link</button>
            </form>

            <p class="back-to-login">
                <a href="{{ route('login') }}">← Back to Login</a>
            </p>
        </div>
    </div>
</div>

<style>
    .subtitle {
        color: #718096;
        font-size: 16px;
        margin-bottom: 30px;
        text-align: center;
    }

    .success-message {
        background: #d4edda;
        color: #155724;
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 25px;
        border: 1px solid #c3e6cb;
        display: flex;
        align-items: flex-start;
        gap: 15px;
        font-size: 14px;
        font-weight: 500;
    }

    .success-message i {
        color: #28a745;
        font-size: 20px;
        margin-top: 2px;
        flex-shrink: 0;
    }

    .success-message div {
        flex: 1;
    }

    .success-message strong {
        display: block;
        margin-bottom: 5px;
    }

    .error-message {
        background: #f8d7da;
        color: #721c24;
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 25px;
        border: 1px solid #f5c6cb;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        font-weight: 500;
    }

    .error-message i {
        color: #dc3545;
        font-size: 16px;
    }

    .back-to-login {
        text-align: center;
        margin-top: 25px;
        font-size: 14px;
    }

    .back-to-login a {
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .back-to-login a:hover {
        color: #764ba2;
        text-decoration: underline;
    }
</style>
@endsection