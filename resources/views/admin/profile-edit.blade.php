@extends('admin.layout.main')

@section('title', 'Edit Profile')

@section('content')
<div class="profile-edit-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">Edit Profile</h1>
            <p class="page-subtitle">Update your personal information and profile picture</p>
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

    <!-- Edit Profile Form -->
    <div class="form-card">
        <div class="form-header">
            <h2>Personal Information</h2>
            <p>Update your basic profile information</p>
        </div>

        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="profile-form">
            @csrf
            @method('PUT')

            <!-- Profile Picture Section -->
            <div class="profile-picture-section">
                <div class="current-avatar">
                    <img id="avatarPreview" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=7C3AED&color=fff&size=120" alt="Current Avatar">
                    <div class="avatar-overlay">
                        <i class="fas fa-camera"></i>
                    </div>
                </div>
                <div class="avatar-controls">
                    <label for="profilePicture" class="btn btn-primary">
                        <i class="fas fa-upload"></i>
                        Upload New Picture
                    </label>
                    <input type="file" id="profilePicture" name="profile_picture" accept="image/*" style="display: none;" onchange="previewImage(this)">
                    <p class="upload-hint">JPG, PNG or GIF. Max size 2MB.</p>
                </div>
            </div>

            <!-- Form Fields -->
            <div class="form-grid">
                <div class="form-group">
                    <label for="name" class="form-label">
                        <i class="fas fa-user"></i>
                        Full Name
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        class="form-input" 
                        value="{{ old('name', Auth::user()->name ?? '') }}" 
                        required
                        placeholder="Enter your full name"
                    >
                    <span class="form-hint">This name will be displayed across the admin dashboard</span>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope"></i>
                        Email Address
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-input" 
                        value="{{ old('email', Auth::user()->email ?? '') }}" 
                        required
                        placeholder="Enter your email address"
                    >
                    <span class="form-hint">Used for login and important notifications</span>
                </div>

                <div class="form-group">
                    <label for="role" class="form-label">
                        <i class="fas fa-shield-alt"></i>
                        Role
                    </label>
                    <input 
                        type="text" 
                        id="role" 
                        name="role" 
                        class="form-input" 
                        value="Administrator" 
                        readonly
                        disabled
                    >
                    <span class="form-hint">Your role cannot be changed</span>
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">
                        <i class="fas fa-phone"></i>
                        Phone Number (Optional)
                    </label>
                    <input 
                        type="tel" 
                        id="phone" 
                        name="phone" 
                        class="form-input" 
                        value="{{ old('phone', Auth::user()->phone ?? '') }}" 
                        placeholder="Enter your phone number"
                    >
                    <span class="form-hint">For account recovery and notifications</span>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="resetForm()">
                    <i class="fas fa-undo"></i>
                    Reset Changes
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- Account Information -->
    <div class="info-card">
        <div class="info-header">
            <h3>Account Information</h3>
            <p>Read-only account details</p>
        </div>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Account Created</span>
                <span class="info-value">{{ Auth::user()->created_at ? Auth::user()->created_at->format('M d, Y') : 'Jan 1, 2024' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Last Updated</span>
                <span class="info-value">{{ Auth::user()->updated_at ? Auth::user()->updated_at->format('M d, Y') : 'Today' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Account Status</span>
                <span class="info-value status-active">Active</span>
            </div>
            <div class="info-item">
                <span class="info-label">User ID</span>
                <span class="info-value">#{{ Auth::user()->id ?? '1' }}</span>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .profile-edit-container {
        max-width: 800px;
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

    /* Form Card */
    .form-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
        border: 1px solid var(--gray-200);
    }

    .form-header {
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--gray-200);
    }

    .form-header h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--gray-800);
        margin: 0 0 0.5rem 0;
    }

    .form-header p {
        color: var(--gray-600);
        margin: 0;
    }

    /* Profile Picture Section */
    .profile-picture-section {
        display: flex;
        align-items: center;
        gap: 2rem;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: var(--gray-50);
        border-radius: 12px;
        border: 1px solid var(--gray-200);
    }

    .current-avatar {
        position: relative;
        width: 120px;
        height: 120px;
        border-radius: 20px;
        overflow: hidden;
        flex-shrink: 0;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .current-avatar:hover {
        transform: scale(1.05);
    }

    .current-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(124, 58, 237, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .current-avatar:hover .avatar-overlay {
        opacity: 1;
    }

    .avatar-controls {
        flex: 1;
    }

    .upload-hint {
        font-size: 0.875rem;
        color: var(--gray-500);
        margin: 0.5rem 0 0 0;
    }

    /* Form Grid */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
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

    .form-input {
        padding: 0.75rem 1rem;
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

    .form-input:disabled {
        background: var(--gray-100);
        color: var(--gray-500);
        cursor: not-allowed;
    }

    .form-hint {
        font-size: 0.75rem;
        color: var(--gray-500);
        margin-top: 0.25rem;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        padding-top: 1rem;
        border-top: 1px solid var(--gray-200);
    }

    /* Info Card */
    .info-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--gray-200);
    }

    .info-header {
        margin-bottom: 1.5rem;
    }

    .info-header h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--gray-800);
        margin: 0 0 0.25rem 0;
    }

    .info-header p {
        color: var(--gray-600);
        margin: 0;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        padding: 1rem;
        background: var(--gray-50);
        border-radius: 8px;
    }

    .info-label {
        font-size: 0.75rem;
        color: var(--gray-500);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 0.875rem;
        color: var(--gray-800);
        font-weight: 600;
    }

    .status-active {
        color: #10b981 !important;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .profile-picture-section {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .form-card,
        .info-card {
            padding: 1.5rem;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    // Preview uploaded image
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                document.getElementById('avatarPreview').src = e.target.result;
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Reset form to original values
    function resetForm() {
        if (confirm('Are you sure you want to reset all changes?')) {
            document.querySelector('.profile-form').reset();
            // Reset avatar preview
            document.getElementById('avatarPreview').src = "https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=7C3AED&color=fff&size=120";
        }
    }

    // Form validation
    document.querySelector('.profile-form').addEventListener('submit', function(e) {
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        
        if (!name) {
            e.preventDefault();
            alert('Please enter your full name');
            document.getElementById('name').focus();
            return;
        }
        
        if (!email) {
            e.preventDefault();
            alert('Please enter your email address');
            document.getElementById('email').focus();
            return;
        }
        
        // Email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            e.preventDefault();
            alert('Please enter a valid email address');
            document.getElementById('email').focus();
            return;
        }
    });
</script>
@endsection