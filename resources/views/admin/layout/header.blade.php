<header class="top-header">
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" onclick="toggleMobileSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Header Actions -->
    <div class="header-actions">
        <!-- Notifications -->
        <div class="notification-dropdown">
            <button class="notification-btn" onclick="toggleNotifications()">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">3</span>
            </button>
            <div class="notification-panel" id="notificationPanel">
                <div class="notification-header">
                    <h4>Notifications</h4>
                </div>
                <div class="notification-list">
                    <div class="notification-item">
                        <div class="notification-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="notification-content">
                            <p class="notification-title">New Order</p>
                            <p class="notification-text">Order #1234 has been placed</p>
                            <span class="notification-time">2 minutes ago</span>
                        </div>
                    </div>
                    <div class="notification-item">
                        <div class="notification-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="notification-content">
                            <p class="notification-title">New Customer</p>
                            <p class="notification-text">John Doe registered</p>
                            <span class="notification-time">5 minutes ago</span>
                        </div>
                    </div>
                    <div class="notification-item">
                        <div class="notification-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="notification-content">
                            <p class="notification-title">New Review</p>
                            <p class="notification-text">5-star review received</p>
                            <span class="notification-time">1 hour ago</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Profile -->
        <div class="admin-profile">
            <div class="profile-info">
                <span class="admin-name">{{ Auth::user()->name ?? 'Admin' }}</span>
                <span class="admin-role">Administrator</span>
            </div>
            <div class="profile-avatar">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=3b82f6&color=fff&size=40" alt="Admin Avatar">
            </div>
        </div>
    </div>
</header>

<style>
    .top-header {
        background: var(--white);
        padding: 0 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid var(--gray-200);
        height: var(--header-height);
        position: sticky;
        top: 0;
        z-index: 100;
        gap: 1rem;
    }

    /* Mobile Menu Toggle */
    .mobile-menu-toggle {
        display: none;
        background: none;
        border: none;
        color: var(--gray-600);
        font-size: 1.25rem;
        cursor: pointer;
        padding: 8px;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .mobile-menu-toggle:hover {
        background: var(--gray-100);
        color: var(--gray-800);
    }

    /* Header Actions */
    .header-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-left: auto;
    }

    /* Notifications */
    .notification-dropdown {
        position: relative;
    }

    .notification-btn {
        position: relative;
        background: none;
        border: none;
        color: var(--gray-600);
        font-size: 1.25rem;
        cursor: pointer;
        padding: 8px;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .notification-btn:hover {
        background: var(--gray-100);
        color: var(--gray-800);
    }

    .notification-badge {
        position: absolute;
        top: 4px;
        right: 4px;
        background: var(--danger-color);
        color: white;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 2px 6px;
        border-radius: 10px;
        min-width: 18px;
        text-align: center;
    }

    .notification-panel {
        position: absolute;
        top: calc(100% + 10px);
        right: 0;
        width: 320px;
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: 8px;
        box-shadow: var(--shadow-lg);
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s ease;
    }

    .notification-panel.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .notification-header {
        padding: 1rem;
        border-bottom: 1px solid var(--gray-200);
    }

    .notification-header h4 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray-800);
        margin: 0;
    }

    .notification-list {
        max-height: 300px;
        overflow-y: auto;
    }

    .notification-item {
        padding: 1rem;
        border-bottom: 1px solid var(--gray-100);
        display: flex;
        gap: 0.75rem;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .notification-item:hover {
        background: var(--gray-50);
    }

    .notification-item:last-child {
        border-bottom: none;
    }

    .notification-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
        background: var(--primary-color);
        color: white;
    }

    .notification-content {
        flex: 1;
    }

    .notification-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray-800);
        margin: 0 0 0.25rem 0;
    }

    .notification-text {
        font-size: 0.8125rem;
        color: var(--gray-600);
        margin: 0 0 0.25rem 0;
    }

    .notification-time {
        font-size: 0.75rem;
        color: var(--gray-400);
    }

    /* Admin Profile */
    .admin-profile {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 6px 12px;
        border-radius: 8px;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .admin-profile:hover {
        background: var(--gray-50);
    }

    .profile-info {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        text-align: right;
    }

    .admin-name {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray-800);
        line-height: 1.2;
    }

    .admin-role {
        font-size: 0.75rem;
        color: var(--gray-500);
        line-height: 1.2;
    }

    .profile-avatar {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        overflow: hidden;
        flex-shrink: 0;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Mobile Responsive */
    @media (max-width: 1024px) {
        .mobile-menu-toggle {
            display: block;
        }

        .profile-info {
            display: none;
        }
    }

    @media (max-width: 768px) {
        .top-header {
            padding: 0 1rem;
        }

        .notification-panel {
            width: 280px;
            right: -50px;
        }
    }

    @media (max-width: 640px) {
        .notification-panel {
            width: 260px;
            right: -80px;
        }
    }
</style>

<script>
    // Toggle Notifications
    function toggleNotifications() {
        const panel = document.getElementById('notificationPanel');
        panel.classList.toggle('show');
        
        // Close when clicking outside
        document.addEventListener('click', function closeNotifications(e) {
            if (!e.target.closest('.notification-dropdown')) {
                panel.classList.remove('show');
                document.removeEventListener('click', closeNotifications);
            }
        });
    }
</script>
