@extends('customer.layout.main')

@section('title', 'My Profile')

@section('content')

@if(session('success'))
<div class="alert-success-msg">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert-error-msg">
    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
</div>
@endif

<div class="profile-page">
    <div class="profile-page-header">
        <h1>Profile Management</h1>
        <p>Manage your account information and settings</p>
    </div>

    <!-- Tabs -->
    <div class="profile-tabs">
        <button class="ptab-btn active" data-tab="account">
            <i class="fas fa-user"></i> Account Details
        </button>
        <button class="ptab-btn" data-tab="password">
            <i class="fas fa-lock"></i> Change Password
        </button>
        <button class="ptab-btn" data-tab="address">
            <i class="fas fa-map-marker-alt"></i> Address Book
        </button>
    </div>

    <!-- Account Details -->
    <div class="ptab-content active" id="account-tab">
        <div class="pcard">
            <h2><i class="fas fa-user-circle"></i> Account Information</h2>
            <form action="{{ route('customer.profile.update') }}" method="POST" class="pform">
                @csrf
                <div class="pform-group">
                    <label>Full Name</label>
                    <input type="text" name="name" value="{{ $customer->name }}" required>
                    @error('name')<span class="perror">{{ $message }}</span>@enderror
                </div>
                <div class="pform-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="{{ $customer->email }}" required>
                    @error('email')<span class="perror">{{ $message }}</span>@enderror
                </div>
                <div class="pform-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" value="{{ $customer->phone }}" placeholder="Enter phone number">
                    @error('phone')<span class="perror">{{ $message }}</span>@enderror
                </div>
                <button type="submit" class="pbtn-save">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </form>
        </div>
    </div>

    <!-- Change Password -->
    <div class="ptab-content" id="password-tab">
        <div class="pcard">
            <h2><i class="fas fa-key"></i> Change Password</h2>
            <form action="{{ route('customer.password.update') }}" method="POST" class="pform">
                @csrf
                <div class="pform-group">
                    <label>Current Password</label>
                    <input type="password" name="current_password" required>
                    @error('current_password')<span class="perror">{{ $message }}</span>@enderror
                </div>
                <div class="pform-group">
                    <label>New Password</label>
                    <input type="password" name="new_password" required>
                    <small class="phint">Minimum 6 characters</small>
                    @error('new_password')<span class="perror">{{ $message }}</span>@enderror
                </div>
                <div class="pform-group">
                    <label>Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" required>
                </div>
                <button type="submit" class="pbtn-save">
                    <i class="fas fa-lock"></i> Update Password
                </button>
            </form>
        </div>
    </div>

    <!-- Address Book -->
    <div class="ptab-content" id="address-tab">
        <div class="pcard">
            <h2><i class="fas fa-address-book"></i> Address Book</h2>
            <form action="{{ route('customer.address.update') }}" method="POST" class="pform">
                @csrf
                <div class="pform-group">
                    <label>Province</label>
                    <select name="province">
                        <option value="">Select Province</option>
                        @foreach(['Koshi','Madhesh','Bagmati','Gandaki','Lumbini','Karnali','Sudurpashchim'] as $p)
                            <option value="{{ $p }}" {{ ($customer->province ?? '') == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="pform-group">
                    <label>District</label>
                    <input type="text" name="district" value="{{ $customer->district ?? '' }}" placeholder="e.g. Kathmandu">
                </div>
                <div class="pform-group">
                    <label>City / Municipality</label>
                    <input type="text" name="city" value="{{ $customer->city ?? '' }}" placeholder="e.g. Kathmandu Metropolitan City">
                    @error('city')<span class="perror">{{ $message }}</span>@enderror
                </div>
                <div class="pform-group">
                    <label>Street / Tole</label>
                    <input type="text" name="address_line1" value="{{ $customer->address_line1 ?? '' }}" placeholder="e.g. Thamel, Ward No. 26">
                </div>
                <button type="submit" class="pbtn-save">
                    <i class="fas fa-map-marker-alt"></i> Save Address
                </button>
            </form>
        </div>
    </div>
</div>

<style>
.alert-success-msg, .alert-error-msg {
    padding: 14px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
}
.alert-success-msg { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.alert-error-msg { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

.profile-page { max-width: 900px; margin: 0 auto; }

.profile-page-header {
    text-align: center;
    margin-bottom: 30px;
}
.profile-page-header h1 { font-size: 28px; color: #2c3e50; margin-bottom: 6px; }
.profile-page-header p { color: #6c757d; font-size: 15px; }

.profile-tabs {
    display: flex;
    gap: 5px;
    border-bottom: 2px solid #e9ecef;
    margin-bottom: 25px;
    overflow-x: auto;
}

.ptab-btn {
    padding: 12px 22px;
    background: none;
    border: none;
    border-bottom: 3px solid transparent;
    color: #6c757d;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s;
    white-space: nowrap;
}
.ptab-btn:hover { color: #667eea; }
.ptab-btn.active { color: #667eea; border-bottom-color: #667eea; font-weight: 600; }
.ptab-btn i { margin-right: 6px; }

.ptab-content { display: none; }
.ptab-content.active { display: block; animation: pfadeIn 0.3s ease; }

@keyframes pfadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}

.pcard {
    background: white;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.07);
}
.pcard h2 {
    font-size: 20px;
    color: #2c3e50;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.pcard h2 i { color: #667eea; }

.pform { max-width: 560px; }

.pform-group { margin-bottom: 18px; }
.pform-group label {
    display: block;
    margin-bottom: 7px;
    color: #2c3e50;
    font-weight: 500;
    font-size: 14px;
}
.pform-group input {
    width: 100%;
    padding: 11px 14px;
    border: 1px solid #e0e0e0;
    border-radius: 6px;
    font-size: 15px;
    transition: border-color 0.3s;
    box-sizing: border-box;
}
.pform-group input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
}
.pform-group select {
    width: 100%;
    padding: 11px 14px;
    border: 1px solid #e0e0e0;
    border-radius: 6px;
    font-size: 15px;
    background: white;
    cursor: pointer;
    transition: border-color 0.3s;
    box-sizing: border-box;
}
.pform-group select:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
}

.phint { display: block; margin-top: 5px; color: #6c757d; font-size: 13px; }
.poptional { color: #aaa; font-weight: 400; font-size: 13px; }
.perror { display: block; color: #dc3545; font-size: 13px; margin-top: 4px; }

.pbtn-save {
    margin-top: 5px;
    padding: 12px 28px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
}
.pbtn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102,126,234,0.4);
}
.pbtn-save i { margin-right: 7px; }

.paddress-note {
    background: #f0f4ff;
    border-left: 4px solid #667eea;
    padding: 12px 16px;
    border-radius: 6px;
    margin-bottom: 22px;
    color: #555;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.paddress-note i { color: #667eea; }

@media (max-width: 600px) {
    .pcard { padding: 20px; }
    .pform-row { grid-template-columns: 1fr; }
    .ptab-btn { padding: 10px 14px; font-size: 13px; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabBtns = document.querySelectorAll('.ptab-btn');
    const tabContents = document.querySelectorAll('.ptab-content');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            tabBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            document.getElementById(this.getAttribute('data-tab') + '-tab').classList.add('active');
        });
    });

    // Auto-hide alerts
    document.querySelectorAll('.alert-success-msg, .alert-error-msg').forEach(el => {
        setTimeout(() => el.remove(), 5000);
    });
});
</script>

@endsection
