@extends('layout.main')

@section('hyasabicontentauncha')
<div class="signup-wrapper">
    <div class="signup-card">
        <div class="signup-left">
            <h1>Reset Password</h1>
            <p>Create a new secure password for your account. Make sure it's strong and unique.</p>
        </div>

        <div class="signup-right">
            <h2>Reset Password</h2>
            <p class="subtitle">Enter your new password below</p>

            @if(session('success'))
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    <span>Password reset successful!</span>
                </div>
            @endif

            @if(session('error'))
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('reset-password.post') }}" id="resetPasswordForm">
                @csrf
                <input type="hidden" name="token" value="{{ $token ?? '' }}">
                <input type="hidden" name="email" value="{{ $email ?? '' }}">

                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter new password" required>
                    @error('password')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm new password" required>
                    <div id="password-match-error" class="error" style="display: none;">
                        Passwords do not match
                    </div>
                </div>

                <button type="submit" class="signup-submit" id="resetButton">Reset Password</button>
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
        align-items: center;
        gap: 10px;
        font-size: 14px;
        font-weight: 500;
    }

    .success-message i {
        color: #28a745;
        font-size: 16px;
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

    .error {
        color: #e53e3e;
        font-size: 13px;
        margin-top: 6px;
        display: block;
        font-weight: 500;
    }
</style>

<script>
    // Password matching validation
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const errorDiv = document.getElementById('password-match-error');
        const resetButton = document.getElementById('resetButton');
        const form = document.getElementById('resetPasswordForm');

        // Function to check if passwords match
        function checkPasswordMatch() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            
            if (confirmPassword.length > 0) {
                if (password !== confirmPassword) {
                    errorDiv.style.display = 'block';
                    resetButton.disabled = true;
                    resetButton.style.opacity = '0.6';
                    resetButton.style.cursor = 'not-allowed';
                    return false;
                } else {
                    errorDiv.style.display = 'none';
                    resetButton.disabled = false;
                    resetButton.style.opacity = '1';
                    resetButton.style.cursor = 'pointer';
                    return true;
                }
            } else {
                errorDiv.style.display = 'none';
                resetButton.disabled = false;
                resetButton.style.opacity = '1';
                resetButton.style.cursor = 'pointer';
                return true;
            }
        }

        // Add event listeners for real-time validation
        passwordInput.addEventListener('input', checkPasswordMatch);
        confirmPasswordInput.addEventListener('input', checkPasswordMatch);

        // Prevent form submission if passwords don't match
        form.addEventListener('submit', function(e) {
            if (!checkPasswordMatch()) {
                e.preventDefault();
                return false;
            }
        });
    });
</script>
@endsection