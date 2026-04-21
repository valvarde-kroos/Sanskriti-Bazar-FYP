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
                <label for="province" class="form-label">Province</label>
                <select class="form-control" id="province" name="province" required>
                    <option value="">Select Province</option>
                    @foreach(['Koshi','Madhesh','Bagmati','Gandaki','Lumbini','Karnali','Sudurpashchim'] as $p)
                        <option value="{{ $p }}" {{ (auth()->user()->province ?? '') == $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="district" class="form-label">District</label>
                <input type="text" class="form-control" id="district" name="district" 
                       value="{{ auth()->user()->district ?? '' }}" placeholder="e.g. Kathmandu" required>
            </div>
            
            <div class="form-group">
                <label for="city" class="form-label">City / Municipality</label>
                <input type="text" class="form-control" id="city" name="city" 
                       value="{{ auth()->user()->city ?? '' }}" placeholder="e.g. Kathmandu Metropolitan City" required>
            </div>
            
            <div class="form-group">
                <label for="address_line1" class="form-label">Street / Tole</label>
                <input type="text" class="form-control" id="address_line1" name="address_line1" 
                       value="{{ auth()->user()->address_line1 ?? '' }}" placeholder="e.g. Thamel, Ward No. 26" required>
                <small class="text-muted">Street address, ward number</small>
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
