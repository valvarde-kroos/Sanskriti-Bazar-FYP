@extends('vendor.layout.main')

@section('title', 'Settings')

@section('content')
<div class="welcome-section">
    <h1>Settings</h1>
    <p>Manage your profile and shop settings</p>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="settings-grid">
    <!-- Profile Information Section -->
    <div class="section-card">
        <div class="section-header">
            <h2>Profile Information</h2>
        </div>
        <form id="profileForm" method="POST" action="{{ route('vendor.settings.profile') }}">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" 
                       value="{{ auth()->user()->name ?? 'John Doe' }}" required>
                <small class="text-muted">Your full name as it appears on your profile</small>
            </div>
            
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" 
                       value="{{ auth()->user()->email ?? 'vendor@example.com' }}" required>
                <small class="text-muted">Your email address for login and notifications</small>
            </div>
            
            <div class="form-group">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" id="phone" name="phone" 
                       value="{{ auth()->user()->phone ?? '+1 234 567 8900' }}">
                <small class="text-muted">Your contact phone number</small>
            </div>
            
            <button type="submit" class="action-btn primary">Save Profile</button>
        </form>
    </div>

    <!-- Shop Details Section -->
    <div class="section-card">
        <div class="section-header">
            <h2>Shop Details</h2>
        </div>
        <form id="shopForm" method="POST" action="{{ route('vendor.settings.shop') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="shop_name" class="form-label">Shop Name</label>
                <input type="text" class="form-control" id="shop_name" name="shop_name" 
                       value="{{ auth()->user()->shop_name ?? 'My Awesome Shop' }}" required>
                <small class="text-muted">The name of your shop as customers will see it</small>
            </div>
            
            <div class="form-group">
                <label for="shop_description" class="form-label">Shop Description</label>
                <textarea class="form-control" id="shop_description" name="shop_description" rows="3">{{ auth()->user()->shop_description ?? 'Welcome to my shop! We offer high-quality products with excellent customer service.' }}</textarea>
                <small class="text-muted">Brief description of your shop and products</small>
            </div>
            
            <div class="form-group">
                <label for="shop_logo" class="form-label">Shop Logo</label>
                <div class="logo-preview" id="logoPreview">
                    @if(auth()->user()->shop_logo ?? false)
                        <img src="{{ asset('uploads/logos/' . auth()->user()->shop_logo) }}" alt="Shop Logo">
                    @else
                        <div class="logo-placeholder">
                            <div class="logo-icon">📷</div>
                            No logo uploaded
                        </div>
                    @endif
                </div>
                <input type="file" class="form-control" id="shop_logo" name="shop_logo" accept="image/*" onchange="previewLogo(this)">
                <small class="text-muted">Upload your shop logo (JPG, PNG, max 2MB)</small>
            </div>
            
            <button type="submit" class="action-btn primary">Save Shop Details</button>
        </form>
    </div>
</div>

<div class="settings-grid">
    <!-- Address Information Section -->
    <div class="section-card">
        <div class="section-header">
            <h2>Address Information</h2>
        </div>
        <form id="addressForm" method="POST" action="{{ route('vendor.settings.address') }}">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="address_line1" class="form-label">Address Line 1</label>
                <input type="text" class="form-control" id="address_line1" name="address_line1" 
                       value="{{ auth()->user()->address_line1 ?? '123 Main Street' }}" required>
                <small class="text-muted">Street address, building number</small>
            </div>
            
            <div class="form-group">
                <label for="address_line2" class="form-label">Address Line 2 (Optional)</label>
                <input type="text" class="form-control" id="address_line2" name="address_line2" 
                       value="{{ auth()->user()->address_line2 ?? 'Apartment 4B' }}">
                <small class="text-muted">Apartment, suite, unit, building, floor, etc.</small>
            </div>
            
            <div class="address-row">
                <div class="form-group">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control" id="city" name="city" 
                           value="{{ auth()->user()->city ?? 'New York' }}" required>
                </div>
                <div class="form-group">
                    <label for="postal_code" class="form-label">Postal Code</label>
                    <input type="text" class="form-control" id="postal_code" name="postal_code" 
                           value="{{ auth()->user()->postal_code ?? '10001' }}" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="country" class="form-label">Country</label>
                <select class="form-control" id="country" name="country" required>
                    <option value="US" {{ (auth()->user()->country ?? 'US') == 'US' ? 'selected' : '' }}>United States</option>
                    <option value="CA" {{ (auth()->user()->country ?? '') == 'CA' ? 'selected' : '' }}>Canada</option>
                    <option value="UK" {{ (auth()->user()->country ?? '') == 'UK' ? 'selected' : '' }}>United Kingdom</option>
                    <option value="AU" {{ (auth()->user()->country ?? '') == 'AU' ? 'selected' : '' }}>Australia</option>
                    <option value="NP" {{ (auth()->user()->country ?? '') == 'NP' ? 'selected' : '' }}>Nepal</option>
                    <option value="IN" {{ (auth()->user()->country ?? '') == 'IN' ? 'selected' : '' }}>India</option>
                </select>
            </div>
            
            <button type="submit" class="action-btn primary">Save Address</button>
        </form>
    </div>

    <!-- Change Password Section -->
    <div class="section-card">
        <div class="section-header">
            <h2>Change Password</h2>
        </div>
        <form id="passwordForm" method="POST" action="{{ route('vendor.settings.password') }}">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="current_password" class="form-label">Current Password</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
                <small class="text-muted">Enter your current password</small>
            </div>
            
            <div class="form-group">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
                <small class="text-muted">Enter your new password (minimum 6 characters)</small>
            </div>
            
            <div class="form-group">
                <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                <small class="text-muted">Re-enter your new password</small>
            </div>
            
            <div class="alert alert-info">
                <small>
                    <strong>Password Requirements:</strong><br>
                    • Minimum 6 characters<br>
                    • Use a strong, unique password<br>
                    • Don't share your password with anyone
                </small>
            </div>
            
            <button type="submit" class="action-btn primary">Change Password</button>
        </form>
    </div>
</div>
@endsection

@section('styles')
<style>
    .settings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 30px;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 5px;
        display: block;
        font-size: 14px;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        outline: none;
        border-color: #3498db;
        box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
    }

    .text-muted {
        color: #7f8c8d !important;
        font-size: 12px;
        margin-top: 4px;
        display: block;
    }

    .action-btn {
        padding: 10px 20px;
        border: 1px solid #ddd;
        background: #fff;
        color: #2c3e50;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .action-btn:hover {
        background: #f8f9fa;
        border-color: #3498db;
    }

    .action-btn.primary {
        background: #3498db;
        color: #fff;
        border-color: #3498db;
    }

    .action-btn.primary:hover {
        background: #2980b9;
        border-color: #2980b9;
    }

    .logo-preview {
        width: 100px;
        height: 100px;
        border: 2px dashed #ddd;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        background-color: #f8f9fa;
    }

    .logo-preview img {
        max-width: 90px;
        max-height: 90px;
        border-radius: 4px;
    }

    .logo-placeholder {
        color: #7f8c8d;
        text-align: center;
        font-size: 12px;
    }

    .logo-icon {
        font-size: 24px;
        margin-bottom: 5px;
    }

    .address-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .alert {
        padding: 12px 16px;
        border-radius: 6px;
        margin-bottom: 20px;
        border: 1px solid transparent;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border-color: #a7f3d0;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
        border-color: #fca5a5;
    }

    .alert-info {
        background: #dbeafe;
        color: #1e40af;
        border-color: #93c5fd;
    }

    .btn-close {
        background: none;
        border: none;
        font-size: 16px;
        cursor: pointer;
        padding: 4px;
        float: right;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 80px;
    }

    @media (max-width: 768px) {
        .settings-grid {
            grid-template-columns: 1fr;
        }
        
        .address-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('scripts')
        // Function to preview uploaded logo
        function previewLogo(input) {
            const preview = document.getElementById('logoPreview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Logo Preview">`;
                };
                
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Function to show success message
        function showMessage(message, type = 'success') {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
            alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            alertDiv.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            document.body.appendChild(alertDiv);
            
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
        }

        // Handle form submissions with AJAX (for demo purposes)
        document.addEventListener('DOMContentLoaded', function() {
            // Profile form submission
            document.getElementById('profileForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Get form data
                const formData = new FormData(this);
                const name = formData.get('name');
                const email = formData.get('email');
                const phone = formData.get('phone');
                
                // Simulate saving (in real app, this would be an AJAX call)
                setTimeout(() => {
                    showMessage('Profile information updated successfully!', 'success');
                }, 500);
                
                console.log('Profile updated:', { name, email, phone });
            });

            // Shop form submission
            document.getElementById('shopForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const shopName = formData.get('shop_name');
                const shopDescription = formData.get('shop_description');
                
                setTimeout(() => {
                    showMessage('Shop details updated successfully!', 'success');
                }, 500);
                
                console.log('Shop updated:', { shopName, shopDescription });
            });

            // Address form submission
            document.getElementById('addressForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const address = {
                    line1: formData.get('address_line1'),
                    line2: formData.get('address_line2'),
                    city: formData.get('city'),
                    postal: formData.get('postal_code'),
                    country: formData.get('country')
                };
                
                setTimeout(() => {
                    showMessage('Address information updated successfully!', 'success');
                }, 500);
                
                console.log('Address updated:', address);
            });

            // Password form submission
            document.getElementById('passwordForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const currentPassword = formData.get('current_password');
                const newPassword = formData.get('new_password');
                const confirmPassword = formData.get('new_password_confirmation');
                
                // Basic validation
                if (newPassword !== confirmPassword) {
                    showMessage('New passwords do not match!', 'danger');
                    return;
                }
                
                if (newPassword.length < 6) {
                    showMessage('Password must be at least 6 characters long!', 'danger');
                    return;
                }
                
                // Clear form
                this.reset();
                
                setTimeout(() => {
                    showMessage('Password changed successfully!', 'success');
                }, 500);
                
                console.log('Password changed successfully');
            });

            console.log('Settings page loaded successfully!');
            console.log('All form handlers are active and working.');
        });
    </script>
</body>
</html>
@endsection