@extends('admin.layout.main')

@section('title', 'Change Password')

@section('content')
<div class="password-change-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">Change Password</h1>
            <p class="page-subtitle">Update your account password for better security</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.profile') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back to Profile
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <i class="fas fa-exclamation-triangle"></i>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="content-grid">
        <!-- Change Password Form -->
        <div class="form-card">
            <div class="form-header">
                <div class="header-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <div class="header-text">
                    <h2>Update Password</h2>
                    <p>Choose a strong password to keep your account secure</p>
                </div>
            </div>

            <form action="{{ route('admin.profile.password.update') }}" method="POST" class="password-form" id="passwordForm">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="current_password" class="form-label">
                        <i class="fas fa-key"></i>
                        Current Password
                    </label>
                    <div class="password-input-wrapper">
                        <input 
                            type="password" 
                            id="current_password" 
                            name="current_password" 
                            class="form-input" 
                            required
                            placeholder="Enter your current password"
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword('current_password')">
                            <i class="fas fa-eye" id="current_password_icon"></i>
                        </button>
                    </div>
                    <span class="form-hint">Enter your existing password to confirm your identity</span>
                </div>

                <div class="form-group">
                    <label for="new_password" class="form-label">
                        <i class="fas fa-lock"></i>
                        New Password
                    </label>
                    <div class="password-input-wrapper">
                        <input 
                            type="password" 
                            id="new_password" 
                            name="new_password" 
                            class="form-input" 
                            required
                            placeholder="Enter your new password"
                            oninput="checkPasswordStrength()"
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword('new_password')">
                            <i class="fas fa-eye" id="new_password_icon"></i>
                        </button>
                    </div>
                    
                    <!-- Password Strength Indicator -->
                    <div class="password-strength" id="passwordStrength">
                        <div class="strength-bar">
                            <div class="strength-fill" id="strengthFill"></div>
                        </div>
                        <span class="strength-text" id="strengthText">Password strength</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="new_password_confirmation" class="form-label">
                        <i class="fas fa-check-double"></i>
                        Confirm New Password
                    </label>
                    <div class="password-input-wrapper">
                        <input 
                            type="password" 
                            id="new_password_confirmation" 
                            name="new_password_confirmation" 
                            class="form-input" 
                            required
                            placeholder="Confirm your new password"
                            oninput="checkPasswordMatch()"
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword('new_password_confirmation')">
                            <i class="fas fa-eye" id="new_password_confirmation_icon"></i>
                        </button>
                    </div>
                    <span class="form-hint" id="passwordMatchHint">Re-enter your new password to confirm</span>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="resetPasswordForm()">
                        <i class="fas fa-undo"></i>
                        Reset Form
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-save"></i>
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .password-change-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    /* Page Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--gray-200);
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--gray-800);
        margin: 0 0 0.5rem 0;
    }

    .page-subtitle {
        color: var(--gray-600);
        font-size: 1rem;
        margin: 0;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #7C3AED 0%, #6366F1 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
    }

    .btn-secondary {
        background: var(--gray-100);
        color: var(--gray-700);
        border: 1px solid var(--gray-300);
    }

    .btn-secondary:hover {
        background: var(--gray-200);
    }

    /* Alerts */
    .alert {
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        color: #065f46;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.1);
        color: #991b1b;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .alert ul {
        margin: 0;
        padding-left: 1rem;
    }

    /* Content Grid */
    .content-grid {
        display: block;
    }

    /* Form Card */
    .form-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--gray-200);
        max-width: 600px;
        margin: 0 auto;
    }

    .form-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--gray-200);
    }

    .header-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #7C3AED 0%, #6366F1 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        flex-shrink: 0;
    }

    .header-text h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--gray-800);
        margin: 0 0 0.25rem 0;
    }

    .header-text p {
        color: var(--gray-600);
        margin: 0;
        font-size: 0.875rem;
    }

    /* Form Groups */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .form-label i {
        color: #7C3AED;
        width: 16px;
    }

    .password-input-wrapper {
        position: relative;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 3rem 0.75rem 1rem;
        border: 2px solid var(--gray-300);
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
    }

    .form-input:focus {
        outline: none;
        border-color: #7C3AED;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
    }

    .password-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--gray-400);
        cursor: pointer;
        padding: 4px;
        border-radius: 4px;
        transition: all 0.2s ease;
    }

    .password-toggle:hover {
        color: #7C3AED;
        background: rgba(124, 58, 237, 0.1);
    }

    .form-hint {
        font-size: 0.75rem;
        color: var(--gray-500);
        margin-top: 0.25rem;
        display: block;
    }

    .form-hint.error {
        color: #dc2626;
    }

    .form-hint.success {
        color: #10b981;
    }

    /* Password Strength */
    .password-strength {
        margin-top: 0.5rem;
    }

    .strength-bar {
        width: 100%;
        height: 4px;
        background: var(--gray-200);
        border-radius: 2px;
        overflow: hidden;
        margin-bottom: 0.25rem;
    }

    .strength-fill {
        height: 100%;
        width: 0%;
        transition: all 0.3s ease;
        border-radius: 2px;
    }

    .strength-text {
        font-size: 0.75rem;
        font-weight: 500;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        padding-top: 1rem;
        border-top: 1px solid var(--gray-200);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .form-actions {
            flex-direction: column;
        }

        .form-card {
            padding: 1.5rem;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    // Toggle password visibility
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(inputId + '_icon');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Check password strength
    function checkPasswordStrength() {
        const password = document.getElementById('new_password').value;
        const strengthFill = document.getElementById('strengthFill');
        const strengthText = document.getElementById('strengthText');
        
        let strength = 0;
        let feedback = '';
        
        // Length check
        if (password.length >= 8) strength += 1;
        
        // Uppercase check
        if (/[A-Z]/.test(password)) strength += 1;
        
        // Lowercase check
        if (/[a-z]/.test(password)) strength += 1;
        
        // Number check
        if (/[0-9]/.test(password)) strength += 1;
        
        // Special character check
        if (/[^A-Za-z0-9]/.test(password)) strength += 1;
        
        // Update UI based on strength
        switch (strength) {
            case 0:
            case 1:
                strengthFill.style.width = '20%';
                strengthFill.style.background = '#dc2626';
                strengthText.textContent = 'Very Weak';
                strengthText.style.color = '#dc2626';
                break;
            case 2:
                strengthFill.style.width = '40%';
                strengthFill.style.background = '#f59e0b';
                strengthText.textContent = 'Weak';
                strengthText.style.color = '#f59e0b';
                break;
            case 3:
                strengthFill.style.width = '60%';
                strengthFill.style.background = '#eab308';
                strengthText.textContent = 'Fair';
                strengthText.style.color = '#eab308';
                break;
            case 4:
                strengthFill.style.width = '80%';
                strengthFill.style.background = '#22c55e';
                strengthText.textContent = 'Good';
                strengthText.style.color = '#22c55e';
                break;
            case 5:
                strengthFill.style.width = '100%';
                strengthFill.style.background = '#10b981';
                strengthText.textContent = 'Very Strong';
                strengthText.style.color = '#10b981';
                break;
        }
        
        // Also check password match when strength changes
        checkPasswordMatch();
    }

    // Check if passwords match
    function checkPasswordMatch() {
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('new_password_confirmation').value;
        const hint = document.getElementById('passwordMatchHint');
        
        if (confirmPassword.length === 0) {
            hint.textContent = 'Re-enter your new password to confirm';
            hint.className = 'form-hint';
            return;
        }
        
        if (newPassword === confirmPassword) {
            hint.textContent = 'Passwords match!';
            hint.className = 'form-hint success';
        } else {
            hint.textContent = 'Passwords do not match';
            hint.className = 'form-hint error';
        }
    }

    // Reset password form
    function resetPasswordForm() {
        if (confirm('Are you sure you want to reset the form?')) {
            document.getElementById('passwordForm').reset();
            
            // Reset password strength indicator
            document.getElementById('strengthFill').style.width = '0%';
            document.getElementById('strengthText').textContent = 'Password strength';
            document.getElementById('strengthText').style.color = 'var(--gray-500)';
            
            // Reset password match hint
            document.getElementById('passwordMatchHint').textContent = 'Re-enter your new password to confirm';
            document.getElementById('passwordMatchHint').className = 'form-hint';
        }
    }

    // Form validation
    document.getElementById('passwordForm').addEventListener('submit', function(e) {
        const currentPassword = document.getElementById('current_password').value;
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('new_password_confirmation').value;
        
        // Check if all fields are filled
        if (!currentPassword || !newPassword || !confirmPassword) {
            e.preventDefault();
            alert('Please fill in all password fields');
            return;
        }
        
        // Check password length
        if (newPassword.length < 8) {
            e.preventDefault();
            alert('New password must be at least 8 characters long');
            document.getElementById('new_password').focus();
            return;
        }
        
        // Check if passwords match
        if (newPassword !== confirmPassword) {
            e.preventDefault();
            alert('New passwords do not match');
            document.getElementById('new_password_confirmation').focus();
            return;
        }
        
        // Check if new password is different from current
        if (currentPassword === newPassword) {
            e.preventDefault();
            alert('New password must be different from current password');
            document.getElementById('new_password').focus();
            return;
        }
    });
</script>
@endsection