@extends('customer.layout.main')

@section('title', 'My Profile')

@section('content')
<div class="welcome-section">
    <h1>My Profile</h1>
    <p>Update your personal information</p>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
    <strong>Please fix the following errors:</strong><br>
    @foreach($errors->all() as $error)
        • {{ $error }}<br>
    @endforeach
</div>
@endif

<!-- Personal Information -->
<div class="section-card">
    <div class="section-header">
        <h2>Personal Information</h2>
    </div>
    <form method="POST" action="{{ route('customer.profile.update') }}" id="profileForm">
        @csrf
        
        <div class="form-group">
            <label for="name" class="form-label">Full Name *</label>
            <input type="text" class="form-control" id="name" name="name" 
                   value="{{ auth()->user()->name ?? '' }}" 
                   placeholder="Enter your full name" required>
        </div>
        
        <div class="form-group">
            <label for="email" class="form-label">Email Address *</label>
            <input type="email" class="form-control" id="email" name="email" 
                   value="{{ auth()->user()->email ?? '' }}" 
                   placeholder="Enter your email address" required>
        </div>
        
        <div class="form-group">
            <label for="phone" class="form-label">Phone Number *</label>
            <input type="tel" class="form-control" id="phone" name="phone" 
                   value="{{ auth()->user()->phone ?? '' }}" 
                   placeholder="Enter your phone number (e.g., 9841234567)" required>
        </div>
        
        <button type="submit" class="action-btn primary">Save Personal Info</button>
    </form>
</div>

<!-- Address Information -->
<div class="section-card">
    <div class="section-header">
        <h2>Delivery Address</h2>
    </div>
    <form method="POST" action="{{ route('customer.address.update') }}" id="addressForm">
        @csrf
        
        <div class="form-group">
            <label for="address_line1" class="form-label">Street Address *</label>
            <input type="text" class="form-control" id="address_line1" name="address_line1" 
                   value="{{ auth()->user()->address_line1 ?? '' }}" 
                   placeholder="Enter your street address" required>
            <small class="text-muted">Example: Thamel, Ward No. 26</small>
        </div>
        
        <div class="form-group">
            <label for="address_line2" class="form-label">Area/Landmark (Optional)</label>
            <input type="text" class="form-control" id="address_line2" name="address_line2" 
                   value="{{ auth()->user()->address_line2 ?? '' }}" 
                   placeholder="Near landmark or area details">
            <small class="text-muted">Example: Near Kathmandu Durbar Square</small>
        </div>
        
        <div class="form-group">
            <label for="city" class="form-label">City *</label>
            <input type="text" class="form-control" id="city" name="city" 
                   value="{{ auth()->user()->city ?? '' }}" 
                   placeholder="Enter your city" required>
            <small class="text-muted">Example: Kathmandu, Pokhara, Lalitpur</small>
        </div>
        
        <button type="submit" class="action-btn primary">Save Address</button>
    </form>
</div>

<!-- Change Password -->
<div class="section-card">
    <div class="section-header">
        <h2>Change Password</h2>
    </div>
    <form method="POST" action="{{ route('customer.password.update') }}" id="passwordForm">
        @csrf
        
        <div class="form-group">
            <label for="current_password" class="form-label">Current Password *</label>
            <input type="password" class="form-control" id="current_password" name="current_password" 
                   placeholder="Enter your current password" required>
        </div>
        
        <div class="form-group">
            <label for="new_password" class="form-label">New Password *</label>
            <input type="password" class="form-control" id="new_password" name="new_password" 
                   placeholder="Enter new password (minimum 6 characters)" required>
        </div>
        
        <div class="form-group">
            <label for="new_password_confirmation" class="form-label">Confirm New Password *</label>
            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" 
                   placeholder="Enter new password again" required>
        </div>
        
        <div class="password-tips">
            <h4>Password Tips:</h4>
            <ul>
                <li>Use at least 6 characters</li>
                <li>Mix letters and numbers</li>
                <li>Don't share your password</li>
            </ul>
        </div>
        
        <button type="submit" class="action-btn primary">Change Password</button>
    </form>
</div>
@endsection

@section('styles')
<style>
    .password-tips {
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 8px;
        padding: 15px;
        margin: 15px 0;
    }

    .password-tips h4 {
        margin: 0 0 10px 0;
        color: #0369a1;
        font-size: 14px;
    }

    .password-tips ul {
        margin: 0;
        padding-left: 20px;
        color: #0369a1;
        font-size: 13px;
    }

    .password-tips li {
        margin-bottom: 5px;
    }

    .form-control {
        font-size: 16px;
        padding: 12px 15px;
    }

    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    }

    .text-muted {
        color: #6b7280;
        font-size: 12px;
        margin-top: 5px;
        display: block;
    }

    .section-header h2 {
        font-size: 18px;
        margin-bottom: 15px;
    }

    .alert {
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        font-weight: 500;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }

    .action-btn {
        margin-top: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .action-btn:hover {
        transform: translateY(-1px);
    }

    .action-btn:active {
        transform: translateY(0);
    }

    @media (max-width: 768px) {
        .form-control {
            font-size: 16px; /* Prevents zoom on iOS */
        }
    }
</style>
@endsection

@section('scripts')
<script>
    // Password confirmation check - only for password form
    document.getElementById('passwordForm').addEventListener('submit', function(e) {
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('new_password_confirmation').value;
        
        if (newPassword !== confirmPassword) {
            e.preventDefault();
            alert('New passwords do not match! Please try again.');
            return false;
        }
        
        if (newPassword.length < 6) {
            e.preventDefault();
            alert('Password must be at least 6 characters long!');
            return false;
        }
        
        // Allow form to submit normally
        return true;
    });

    // Phone number formatting for Nepal
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
            if (value.length > 10) {
                value = value.substring(0, 10);
            }
            e.target.value = value;
        });
    }

    // Simple validation for required fields - but don't prevent submission if filled
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('input[required]');
            let hasError = false;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    hasError = true;
                    field.style.borderColor = '#dc2626';
                    field.focus();
                } else {
                    field.style.borderColor = '#d1d5db';
                }
            });
            
            if (hasError) {
                e.preventDefault();
                alert('Please fill in all required fields (marked with *)');
                return false;
            }
            
            // If no errors, allow form to submit
            return true;
        });
    });

    // Debug: Log form submissions
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        console.log('Profile form submitting...');
    });

    document.getElementById('addressForm').addEventListener('submit', function(e) {
        console.log('Address form submitting...');
    });

    document.getElementById('passwordForm').addEventListener('submit', function(e) {
        console.log('Password form submitting...');
    });
</script>
@endsection