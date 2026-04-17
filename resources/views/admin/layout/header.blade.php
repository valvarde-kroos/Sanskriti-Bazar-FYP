<header class="top-header">
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" onclick="toggleMobileSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Header Actions -->
    <div class="header-actions">
        <!-- Notifications -->
        <div class="notification-dropdown">
            <button class="notification-btn" id="notificationBtn" onclick="toggleNotifications(event)">
                <i class="fas fa-bell"></i>
                <span class="notification-badge" id="notificationBadge" style="display: none;"></span>
            </button>
            <div class="notification-panel" id="notificationPanel">
                <div class="notification-header">
                    <div class="notification-header-left">
                        <h4>Notifications</h4>
                        <span class="unread-count" id="unreadCount">0 unread</span>
                    </div>
                    <button class="mark-all-read-btn" id="markAllReadBtn" onclick="markAllAsRead(event)">
                        Mark all as read
                    </button>
                </div>
                <div class="notification-list" id="notificationList">
                    <!-- Notifications will be loaded here -->
                </div>
                <div class="notification-footer">
                    <a href="#" class="view-all-link">View All Notifications</a>
                </div>
            </div>
        </div>

        <!-- Admin Profile -->
        <div class="admin-profile" onclick="toggleProfileDropdown(event)">
            <div class="profile-info">
                <span class="admin-name">{{ Auth::user()->name ?? 'Admin' }}</span>
                <span class="admin-role">Administrator</span>
            </div>
            <div class="profile-avatar">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=3b82f6&color=fff&size=40" alt="Admin Avatar">
            </div>
            
            <!-- Profile Dropdown Menu -->
            <div class="profile-dropdown" id="profileDropdown">
                <a href="{{ route('admin.profile') }}" class="dropdown-item">
                    <i class="fas fa-user"></i>
                    <span>View Profile</span>
                </a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="dropdown-item logout-item">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<style>
    :root {
        --white: #ffffff;
        --gray-800: #1f2937;
        --gray-700: #374151;
        --gray-600: #4b5563;
        --gray-500: #6b7280;
        --gray-400: #9ca3af;
        --gray-300: #d1d5db;
        --gray-200: #e5e7eb;
        --gray-100: #f3f4f6;
        --gray-50: #f9fafb;
        --header-height: 70px;
    }

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
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
    }

    .notification-btn:hover {
        background: var(--gray-100);
        color: var(--gray-800);
    }

    .notification-btn:focus {
        outline: none;
        background: var(--gray-100);
    }

    .notification-badge {
        position: absolute;
        top: 4px;
        right: 4px;
        background: #dc2626;
        color: white;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 2px 6px;
        border-radius: 10px;
        min-width: 18px;
        text-align: center;
        line-height: 1.2;
        display: none; /* Hidden by default, shown only when there are unread notifications */
        align-items: center;
        justify-content: center;
        height: 18px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.7);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(220, 38, 38, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(220, 38, 38, 0);
        }
    }

    .notification-panel {
        position: absolute;
        top: calc(100% + 10px);
        right: 0;
        width: 380px;
        background: var(--white);
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        display: none;
        max-height: 500px;
        overflow: hidden;
    }

    .notification-panel.show {
        display: block !important;
    }

    .notification-header {
        padding: 16px 20px;
        border-bottom: 1px solid #f3f4f6;
        background: #f8fafc;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .notification-header-left h4 {
        font-size: 16px;
        font-weight: 600;
        color: var(--gray-800);
        margin: 0 0 4px 0;
    }

    .unread-count {
        font-size: 12px;
        color: #7C3AED;
        font-weight: 500;
    }

    .mark-all-read-btn {
        background: none;
        border: none;
        color: #7C3AED;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        padding: 4px 8px;
        border-radius: 4px;
        transition: all 0.2s ease;
    }

    .mark-all-read-btn:hover {
        background: rgba(124, 58, 237, 0.1);
    }

    .notification-list {
        max-height: 350px;
        overflow-y: auto;
    }

    .notification-item {
        padding: 16px 20px;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }

    .notification-item:hover {
        background: #f8fafc;
    }

    .notification-item:last-child {
        border-bottom: none;
    }

    .notification-item.unread {
        background: rgba(124, 58, 237, 0.05);
        border-left: 3px solid #7C3AED;
    }

    .notification-item.read {
        background: white;
    }

    .notification-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        flex-shrink: 0;
        margin-top: 4px;
    }

    .notification-dot.customer {
        background: #10b981; /* Green */
    }

    .notification-dot.vendor {
        background: #7C3AED; /* Purple */
    }

    .notification-dot.order {
        background: #3b82f6; /* Blue */
    }

    .notification-dot.category {
        background: #f59e0b; /* Yellow */
    }

    .notification-content {
        flex: 1;
    }

    .notification-message {
        font-size: 14px;
        color: var(--gray-800);
        margin: 0 0 4px 0;
        line-height: 1.4;
        font-weight: 500;
    }

    .notification-time {
        font-size: 12px;
        color: var(--gray-500);
        margin: 0;
    }

    .notification-footer {
        padding: 12px 20px;
        border-top: 1px solid #f3f4f6;
        background: #f8fafc;
        text-align: center;
    }

    .view-all-link {
        color: #7C3AED;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        transition: color 0.2s ease;
    }

    .view-all-link:hover {
        color: #6d28d9;
        text-decoration: underline;
    }

    .no-notifications {
        padding: 2rem 1rem;
        text-align: center;
        color: var(--gray-500);
    }

    .no-notifications i {
        font-size: 2rem;
        color: var(--gray-300);
        margin-bottom: 0.5rem;
        display: block;
    }

    .no-notifications p {
        margin: 0;
        font-size: 0.875rem;
    }

    /* Admin Profile */
    .admin-profile {
        position: relative;
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

    /* Profile Dropdown */
    .profile-dropdown {
        position: absolute;
        top: calc(100% + 10px);
        right: 0;
        min-width: 200px;
        background: white;
        border: 1px solid var(--gray-200);
        border-radius: 8px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        display: none;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        color: var(--gray-700);
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s ease;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
        position: relative;
        z-index: 1001;
    }

    .dropdown-item:hover {
        background: linear-gradient(135deg, #7C3AED 0%, #6366F1 100%);
        color: white;
    }

    .dropdown-item:focus {
        outline: 2px solid #7C3AED;
        outline-offset: -2px;
    }

    .dropdown-item i {
        width: 16px;
        text-align: center;
        font-size: 14px;
    }

    .dropdown-divider {
        height: 1px;
        background: var(--gray-200);
        margin: 8px 0;
    }

    .logout-item {
        color: #dc2626 !important;
        border-top: 1px solid var(--gray-200);
        margin-top: 4px;
        padding-top: 12px;
    }

    .logout-item:hover {
        background: none !important;
        color: #dc2626 !important;
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
            width: 320px;
            right: -20px;
        }
    }

    @media (max-width: 640px) {
        .notification-panel {
            width: 300px;
            right: -40px;
        }
        
        .notification-item {
            padding: 12px 16px;
        }
        
        .notification-message {
            font-size: 13px;
        }
    }
</style>

<script>
    // Notification system - starts empty, no dummy data
    let notifications = [];

    // Global variables for notification system
    let notificationPanelOpen = false;
    let profileDropdownOpen = false;

    // Toggle notification dropdown
    function toggleNotifications(event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        console.log('=== NOTIFICATION BUTTON CLICKED ===');
        
        const panel = document.getElementById('notificationPanel');
        const profileDropdown = document.getElementById('profileDropdown');
        
        if (!panel) {
            console.error('Notification panel not found!');
            return;
        }
        
        console.log('Panel found, current classes:', panel.className);
        
        // Close profile dropdown first
        if (profileDropdown && profileDropdownOpen) {
            profileDropdown.style.display = 'none';
            profileDropdownOpen = false;
        }
        
        // Toggle notification panel using CSS class
        if (notificationPanelOpen) {
            panel.classList.remove('show');
            notificationPanelOpen = false;
            console.log('Closed notification panel');
        } else {
            panel.classList.add('show');
            notificationPanelOpen = true;
            console.log('Opened notification panel');
        }
        
        console.log('New panel classes:', panel.className);
    }

    // Initialize when page loads
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Admin header notification system loaded!');
        console.log('Initial notifications array:', notifications);
        
        // Update notification display on page load
        updateNotificationDisplay();

        // Test if elements exist
        const badge = document.getElementById('notificationBadge');
        const panel = document.getElementById('notificationPanel');
        const btn = document.getElementById('notificationBtn');
        const profileArea = document.getElementById('adminProfile');
        
        console.log('Badge element:', badge);
        console.log('Panel element:', panel);
        console.log('Button element:', btn);
        console.log('Profile area:', profileArea);

        // Add event listeners
        if (btn) {
            btn.addEventListener('click', toggleNotifications);
            console.log('✅ Notification button event listener added');
        }

        if (profileArea) {
            profileArea.addEventListener('click', toggleProfileDropdown);
            console.log('✅ Profile area event listener added');
        }

        // Add event delegation for dropdown links
        document.addEventListener('click', function(e) {
            const dropdownItem = e.target.closest('.dropdown-item');
            if (dropdownItem) {
                console.log('🔗 Dropdown item clicked:', dropdownItem);
                console.log('🔗 Is it a link?', dropdownItem.tagName);
                console.log('🔗 Link href:', dropdownItem.href);
                
                if (dropdownItem.tagName === 'A') {
                    console.log('✅ Allowing link navigation to:', dropdownItem.href);
                    // Close the dropdown when a link is clicked
                    const dropdown = document.getElementById('profileDropdown');
                    if (dropdown) {
                        dropdown.style.display = 'none';
                        profileDropdownOpen = false;
                    }
                    // Allow the link to navigate normally
                } else if (dropdownItem.tagName === 'BUTTON') {
                    console.log('🔘 Button clicked, handling form submission');
                    // For logout button, allow form submission
                }
            }
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            const notificationDropdown = e.target.closest('.notification-dropdown');
            const profileElement = e.target.closest('.admin-profile');
            const dropdownItem = e.target.closest('.dropdown-item');
            
            // Close notification panel if clicking outside
            if (!notificationDropdown && notificationPanelOpen) {
                const panel = document.getElementById('notificationPanel');
                if (panel) {
                    panel.classList.remove('show');
                    notificationPanelOpen = false;
                }
            }
            
            // Close profile dropdown if clicking outside (but allow dropdown links to work)
            if (!profileElement && profileDropdownOpen && !dropdownItem) {
                const dropdown = document.getElementById('profileDropdown');
                if (dropdown) {
                    dropdown.style.display = 'none';
                    profileDropdownOpen = false;
                }
            }
        });
    });

    function updateNotificationDisplay() {
        const badge = document.getElementById('notificationBadge');
        const notificationList = document.getElementById('notificationList');
        const unreadCount = document.getElementById('unreadCount');
        const markAllReadBtn = document.getElementById('markAllReadBtn');
        
        if (!badge || !notificationList || !unreadCount) {
            console.log('Notification elements not found!');
            return;
        }
        
        // Count unread notifications
        const unreadNotifications = notifications.filter(n => !n.isRead);
        const unreadCountNumber = unreadNotifications.length;
        
        // Update badge - ONLY show if there are unread notifications
        if (unreadCountNumber > 0) {
            badge.style.display = 'flex';
            badge.textContent = unreadCountNumber > 99 ? '99+' : unreadCountNumber;
        } else {
            badge.style.display = 'none';
        }
        
        // Update unread count text
        unreadCount.textContent = `${unreadCountNumber} unread`;
        
        // Show/hide mark all as read button
        if (markAllReadBtn) {
            markAllReadBtn.style.display = unreadCountNumber > 0 ? 'block' : 'none';
        }
        
        // Display notifications or empty state
        if (notifications.length === 0) {
            notificationList.innerHTML = `
                <div class="no-notifications">
                    <i class="fas fa-bell-slash"></i>
                    <p>No notifications yet</p>
                </div>
            `;
        } else {
            notificationList.innerHTML = notifications
                .sort((a, b) => b.timestamp - a.timestamp) // Sort by newest first
                .map(notification => `
                    <div class="notification-item ${notification.isRead ? 'read' : 'unread'}" onclick="markAsRead(${notification.id})">
                        <div class="notification-dot ${notification.type}"></div>
                        <div class="notification-content">
                            <p class="notification-message">${notification.message}</p>
                            <p class="notification-time">${notification.time}</p>
                        </div>
                    </div>
                `).join('');
        }
    }

    // Mark all notifications as read
    function markAllAsRead(event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        console.log('Mark all as read clicked!');
        notifications.forEach(notification => {
            notification.isRead = true;
        });
        updateNotificationDisplay();
    }

    // Mark single notification as read when clicked
    function markAsRead(notificationId) {
        console.log('Notification clicked:', notificationId);
        const notification = notifications.find(n => n.id === notificationId);
        if (notification && !notification.isRead) {
            notification.isRead = true;
            updateNotificationDisplay();
        }
    }

    // Function to add a new notification
    function addNotification(type, message, customerName = '') {
        const typeMessages = {
            customer: `New customer ${customerName} just registered`,
            vendor: `New vendor ${customerName} applied for approval`,
            order: `Customer ${customerName} placed a new order`,
            category: `New category ${message} was added`
        };
        
        const notification = {
            id: Date.now(),
            type: type,
            message: typeMessages[type] || message,
            time: 'Just now',
            isRead: false,
            timestamp: Date.now()
        };
        
        notifications.unshift(notification); // Add to beginning
        updateNotificationDisplay();
        
        console.log('New notification added:', notification);
    }

    // PROFILE DROPDOWN FUNCTIONS
    function toggleProfileDropdown(event) {
        // Only prevent default if it's the profile area click, not dropdown links
        const isDropdownLink = event.target.closest('.dropdown-item');
        
        if (!isDropdownLink) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            console.log('👤 Profile area clicked!');
            
            const dropdown = document.getElementById('profileDropdown');
            const notificationPanel = document.getElementById('notificationPanel');
            
            // Close notification panel first
            if (notificationPanel && notificationPanelOpen) {
                notificationPanel.classList.remove('show');
                notificationPanelOpen = false;
            }
            
            // Toggle profile dropdown
            if (profileDropdownOpen) {
                dropdown.style.display = 'none';
                profileDropdownOpen = false;
                console.log('📁 Profile dropdown closed');
            } else {
                dropdown.style.display = 'block';
                profileDropdownOpen = true;
                console.log('📂 Profile dropdown opened');
            }
        } else {
            console.log('🔗 Dropdown link clicked, allowing navigation');
            // Allow the link to work normally
            profileDropdownOpen = false;
            const dropdown = document.getElementById('profileDropdown');
            if (dropdown) {
                dropdown.style.display = 'none';
            }
        }
    }

    // Test functions for adding notifications (for development/testing)
    function testCustomerNotification() {
        addNotification('customer', '', 'Alice Johnson');
    }

    function testVendorNotification() {
        addNotification('vendor', '', 'Bob Smith');
    }

    function testOrderNotification() {
        addNotification('order', '', 'Sarah Wilson');
    }

    function testCategoryNotification() {
        addNotification('category', 'String Instruments');
    }
</script>