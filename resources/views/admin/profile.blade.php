@extends('admin.layout.main')

@section('title', 'Admin Profile')

@section('content')
<div class="profile-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">Admin Profile</h1>
            <p class="page-subtitle">Manage your account settings and preferences</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary">
                <i class="fas fa-edit"></i>
                Edit Profile
            </a>
        </div>
    </div>

    <!-- Profile Information Card -->
    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-avatar-large">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=7C3AED&color=fff&size=120" alt="Admin Avatar">
                <div class="avatar-badge">
                    <i class="fas fa-crown"></i>
                </div>
            </div>
            <div class="profile-info">
                <h2 class="profile-name">{{ Auth::user()->name ?? 'Administrator' }}</h2>
                <p class="profile-role">Administrator</p>
                <p class="profile-email">{{ Auth::user()->email ?? 'admin@sanskritibazar.com' }}</p>
            </div>
        </div>

        <div class="profile-stats">
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-label">Last Login</span>
                    <span class="stat-value">{{ Auth::user()->updated_at ? Auth::user()->updated_at->format('M d, Y') : 'Today' }}</span>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-label">Account Status</span>
                    <span class="stat-value status-active">Active</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions-grid">
        <a href="{{ route('admin.profile.edit') }}" class="action-card">
            <div class="action-icon">
                <i class="fas fa-user-edit"></i>
            </div>
            <div class="action-content">
                <h3>Edit Profile</h3>
                <p>Update your name, email, and profile picture</p>
            </div>
            <div class="action-arrow">
                <i class="fas fa-chevron-right"></i>
            </div>
        </a>

        <a href="{{ route('admin.profile.password') }}" class="action-card">
            <div class="action-icon">
                <i class="fas fa-lock"></i>
            </div>
            <div class="action-content">
                <h3>Change Password</h3>
                <p>Update your account password for security</p>
            </div>
            <div class="action-arrow">
                <i class="fas fa-chevron-right"></i>
            </div>
        </a>
    </div>
</div>
@endsection

@section('styles')
<style>
    .profile-container {
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
        background: linear-gradient(135deg, #7C3AED 0%, #6366F1 100%);
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
    }

    /* Profile Card */
    .profile-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
        border: 1px solid var(--gray-200);
    }

    .profile-header {
        display: flex;
        align-items: center;
        gap: 2rem;
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid var(--gray-200);
    }

    .profile-avatar-large {
        position: relative;
        width: 120px;
        height: 120px;
        border-radius: 20px;
        overflow: hidden;
        flex-shrink: 0;
        box-shadow: 0 8px 25px rgba(124, 58, 237, 0.3);
    }

    .profile-avatar-large img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-badge {
        position: absolute;
        bottom: -5px;
        right: -5px;
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #7C3AED 0%, #6366F1 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
        border: 3px solid white;
    }

    .profile-name {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--gray-800);
        margin: 0 0 0.5rem 0;
    }

    .profile-role {
        font-size: 1rem;
        color: #7C3AED;
        font-weight: 600;
        margin: 0 0 0.5rem 0;
    }

    .profile-email {
        font-size: 1rem;
        color: var(--gray-600);
        margin: 0;
    }

    /* Profile Stats */
    .profile-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: var(--gray-50);
        border-radius: 12px;
        border: 1px solid var(--gray-200);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #7C3AED 0%, #6366F1 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
        flex-shrink: 0;
    }

    .stat-content {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 0.875rem;
        color: var(--gray-600);
        font-weight: 500;
    }

    .stat-value {
        font-size: 1rem;
        color: var(--gray-800);
        font-weight: 600;
        margin-top: 2px;
    }

    .status-active {
        color: #10b981 !important;
    }

    /* Quick Actions Grid */
    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .action-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        background: white;
        border: 1px solid var(--gray-200);
        border-radius: 12px;
        text-decoration: none;
        color: inherit;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .action-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        border-color: #7C3AED;
    }

    .action-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #7C3AED 0%, #6366F1 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
        flex-shrink: 0;
    }

    .action-content {
        flex: 1;
    }

    .action-content h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--gray-800);
        margin: 0 0 0.25rem 0;
    }

    .action-content p {
        font-size: 0.875rem;
        color: var(--gray-600);
        margin: 0;
    }

    .action-arrow {
        color: var(--gray-400);
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .action-card:hover .action-arrow {
        color: #7C3AED;
        transform: translateX(4px);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .profile-header {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .profile-stats {
            grid-template-columns: 1fr;
        }

        .quick-actions-grid {
            grid-template-columns: 1fr;
        }

        .profile-card {
            padding: 1.5rem;
        }
    }
</style>
@endsection