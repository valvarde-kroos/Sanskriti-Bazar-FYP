<nav class="vendor-navbar">
    <div class="navbar-left">
        <button class="mobile-menu-btn" id="mobileMenuBtn">☰</button>
        <button class="mobile-search-btn" id="mobileSearchBtn" style="display: none;">🔍</button>
        <h1 class="navbar-title">Sanskriti Bazar Vendor Panel</h1>
    </div>

    <div class="navbar-center">
        <div class="search-container">
            <input type="text" class="search-input" id="searchInput" placeholder="Search products, orders..." onkeyup="performSearch()" oninput="performSearch()">
            <div class="search-results" id="searchResults"></div>
        </div>
    </div>

    <div class="navbar-right">
        <!-- Notifications -->
        <div class="notification-container">
            <button class="notification-btn" onclick="toggleNotifications()" id="notificationBtn">
                <i class="fas fa-bell"></i>
                <span class="notification-badge" id="notificationBadge"></span>
            </button>
            
            <div class="notification-dropdown" id="notificationDropdown">
                <div class="notification-header">
                    <h4>Notifications</h4>
                    <button class="mark-all-read" onclick="markAllAsRead()" style="display: none;">Mark all as read</button>
                </div>
                <div class="notification-list" id="notificationList">
                    <div class="notification-item">
                        <div class="notification-content">
                            <p class="notification-title">No notifications</p>
                            <p class="notification-desc">You're all caught up!</p>
                        </div>
                    </div>
                </div>
                <div class="notification-footer" style="display: none;">
                    <a href="#" class="view-all-notifications">View all notifications</a>
                </div>
            </div>
        </div>

        <!-- Profile Dropdown -->
        <div class="vendor-profile" id="vendorProfile">
            <span class="vendor-name">{{ Auth::user()->name ?? 'Vendor' }}</span>
            <span class="dropdown-arrow">▼</span>
            
            <div class="profile-dropdown" id="profileDropdown">
                <button type="button" class="dropdown-item" onclick="window.location.href='/vendor/settings'; console.log('Navigating to settings');">Settings</button>
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="dropdown-item logout-btn" onclick="console.log('Logout clicked');">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<style>
    .vendor-navbar {
        background: #fff;
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        border-bottom: 1px solid #e0e0e0;
    }

    .navbar-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .mobile-menu-btn {
        display: none;
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #2c3e50;
        padding: 5px 10px;
    }

    .mobile-search-btn {
        display: none;
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
        color: #2c3e50;
        padding: 5px 10px;
        margin-left: 10px;
    }

    .navbar-title {
        font-size: 18px;
        font-weight: 700;
        color: #2c3e50;
    }

    .navbar-center {
        flex: 1;
        max-width: 500px;
        margin: 0 30px;
        position: relative;
    }

    .search-container {
        width: 100%;
        position: relative;
    }

    .search-input {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        outline: none;
        transition: border-color 0.3s;
    }

    .search-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .search-results {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        max-height: 300px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
    }

    .search-results.show {
        display: block;
    }

    .search-result-item {
        padding: 12px 16px;
        border-bottom: 1px solid #f1f3f5;
        cursor: pointer;
        transition: all 0.3s;
        position: relative;
    }

    .search-result-item:hover {
        background: #f8f9fa;
        transform: translateX(4px);
        border-left: 3px solid #667eea;
    }

    .search-result-item:last-child {
        border-bottom: none;
    }

    .search-result-item:active {
        background: #e9ecef;
        transform: translateX(2px);
    }

    .search-result-title {
        font-weight: 600;
        color: #2c3e50;
        font-size: 14px;
        margin-bottom: 4px;
    }

    .search-result-desc {
        font-size: 12px;
        color: #7f8c8d;
    }

    .navbar-right {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    /* Notification Styles */
    .notification-container {
        position: relative;
    }

    .notification-btn {
        position: relative;
        background: none;
        border: none;
        padding: 10px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s;
        color: #7f8c8d;
        font-size: 18px;
    }

    .notification-btn:hover {
        background: #f8f9fa;
        color: #667eea;
    }

    .notification-badge {
        position: absolute;
        top: 5px;
        right: 5px;
        background: #e74c3c;
        color: white;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        font-size: 10px;
        font-weight: 600;
        display: none;
        align-items: center;
        justify-content: center;
    }

    .notification-badge.show {
        display: flex;
    }

    .notification-dropdown {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        margin-top: 10px;
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        width: 350px;
        z-index: 1000;
    }

    .notification-dropdown.show {
        display: block;
    }

    .notification-header {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f3f5;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f8f9fa;
        border-radius: 8px 8px 0 0;
    }

    .notification-header h4 {
        font-size: 16px;
        font-weight: 600;
        color: #2c3e50;
        margin: 0;
    }

    .mark-all-read {
        background: none;
        border: none;
        color: #667eea;
        font-size: 12px;
        cursor: pointer;
        font-weight: 500;
    }

    .mark-all-read:hover {
        text-decoration: underline;
    }

    .notification-list {
        max-height: 300px;
        overflow-y: auto;
    }

    .notification-item {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f3f5;
        display: flex;
        gap: 12px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .notification-item:hover {
        background: #f8f9fa;
    }

    .notification-item:last-child {
        border-bottom: none;
    }

    .notification-item.unread {
        background: rgba(102, 126, 234, 0.05);
        border-left: 3px solid #667eea;
    }

    .notification-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: white;
        flex-shrink: 0;
    }

    .notification-icon.order {
        background: #667eea;
    }

    .notification-icon.product {
        background: #f39c12;
    }

    .notification-icon.success {
        background: #27ae60;
    }

    .notification-content {
        flex: 1;
    }

    .notification-title {
        font-weight: 600;
        color: #2c3e50;
        font-size: 14px;
        margin: 0 0 4px 0;
    }

    .notification-desc {
        font-size: 13px;
        color: #7f8c8d;
        margin: 0 0 6px 0;
    }

    .notification-time {
        font-size: 11px;
        color: #95a5a6;
    }

    .notification-footer {
        padding: 12px 20px;
        border-top: 1px solid #f1f3f5;
        text-align: center;
        background: #f8f9fa;
        border-radius: 0 0 8px 8px;
    }

    .view-all-notifications {
        color: #667eea;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
    }

    .view-all-notifications:hover {
        text-decoration: underline;
    }

    /* Profile Dropdown */
    .vendor-profile {
        position: relative;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .vendor-profile:hover {
        background: #f8f9fa;
        border-color: #667eea;
    }

    .vendor-name {
        font-size: 14px;
        font-weight: 600;
        color: #2c3e50;
    }

    .dropdown-arrow {
        font-size: 10px;
        color: #95a5a6;
    }

    .profile-dropdown {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        margin-top: 10px;
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        min-width: 160px;
        z-index: 1000;
        opacity: 0;
        transform: translateY(-10px);
        transition: all 0.3s ease;
    }

    .profile-dropdown.show {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }

    .dropdown-item {
        display: block;
        padding: 12px 16px;
        color: #2c3e50;
        text-decoration: none;
        font-size: 14px;
        transition: background 0.3s;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
    }

    .dropdown-item:hover {
        background: #f8f9fa;
    }

    .dropdown-divider {
        height: 1px;
        background: #e0e0e0;
        margin: 5px 0;
    }

    .logout-btn {
        color: #e74c3c;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .vendor-navbar {
            padding: 15px;
        }

        .mobile-menu-btn {
            display: block;
        }

        .mobile-search-btn {
            display: block;
        }

        .navbar-title {
            font-size: 16px;
        }

        .navbar-center {
            display: none;
            position: absolute;
            top: 100%;
            left: 15px;
            right: 15px;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .navbar-center.mobile-show {
            display: block;
        }

        .notification-dropdown {
            width: 300px;
            right: -50px;
        }

        .search-results {
            position: fixed;
            top: auto;
            left: 15px;
            right: 15px;
        }
    }
</style>

<script>
    let searchTimeout;

    function toggleNotifications() {
        const dropdown = document.getElementById('notificationDropdown');
        dropdown.classList.toggle('show');
        
        if (dropdown.classList.contains('show')) {
            loadNotifications();
        }
    }

    function performSearch() {
        const query = document.getElementById('searchInput').value.trim();
        const resultsContainer = document.getElementById('searchResults');
        
        console.log('Search triggered with query:', query); // Debug log
        
        // Clear previous timeout
        if (searchTimeout) {
            clearTimeout(searchTimeout);
        }
        
        if (query.length < 2) {
            resultsContainer.classList.remove('show');
            return;
        }
        
        // Debounce search
        searchTimeout = setTimeout(() => {
            console.log('Making search request...'); // Debug log
            fetch(`{{ route('vendor.search') }}?query=${encodeURIComponent(query)}`)
                .then(response => {
                    console.log('Search response status:', response.status); // Debug log
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Search results:', data); // Debug log
                    displaySearchResults(data);
                })
                .catch(error => {
                    console.error('Search error:', error);
                    resultsContainer.innerHTML = '<div class="search-result-item"><div class="search-result-title">Search error occurred</div><div class="search-result-desc">Please try again</div></div>';
                    resultsContainer.classList.add('show');
                });
        }, 300);
    }

    function displaySearchResults(results) {
        const resultsContainer = document.getElementById('searchResults');
        
        if (results.length === 0) {
            resultsContainer.innerHTML = '<div class="search-result-item"><div class="search-result-title">No results found</div></div>';
        } else {
            resultsContainer.innerHTML = results.map(result => `
                <div class="search-result-item" onclick="navigateToResult('${result.url}', '${result.type}')">
                    <div class="search-result-title">${result.title}</div>
                    <div class="search-result-desc">${result.description}</div>
                </div>
            `).join('');
        }
        
        resultsContainer.classList.add('show');
    }

    function navigateToResult(url, type) {
        console.log('Navigating to:', url, 'Type:', type); // Debug log
        
        // Close search results
        const resultsContainer = document.getElementById('searchResults');
        resultsContainer.classList.remove('show');
        
        // Clear search input
        document.getElementById('searchInput').value = '';
        
        // Navigate to the URL
        if (url && url !== '#') {
            window.location.href = url;
        } else {
            console.error('Invalid URL:', url);
        }
    }

    function loadNotifications() {
        console.log('Loading vendor notifications...'); // Debug log
        
        fetch('{{ route('vendor.notifications') }}')
            .then(response => {
                console.log('Notifications response status:', response.status); // Debug log
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Notifications data:', data); // Debug log
                displayNotifications(data.notifications || []);
                updateNotificationBadge(data.unread_count || 0);
            })
            .catch(error => {
                console.error('Notifications error:', error);
                displayNotifications([]);
                updateNotificationBadge(0);
            });
    }

    function displayNotifications(notifications) {
        const notificationList = document.getElementById('notificationList');
        const markAllBtn = document.querySelector('.mark-all-read');
        const notificationFooter = document.querySelector('.notification-footer');
        
        if (notifications.length === 0) {
            notificationList.innerHTML = '<div class="notification-item"><div class="notification-content"><p class="notification-title">No notifications</p><p class="notification-desc">You\'re all caught up!</p></div></div>';
            markAllBtn.style.display = 'none';
            notificationFooter.style.display = 'none';
        } else {
            notificationList.innerHTML = notifications.map(notification => `
                <div class="notification-item ${notification.unread ? 'unread' : ''}">
                    <div class="notification-icon ${notification.type}">
                        <i class="${notification.icon}"></i>
                    </div>
                    <div class="notification-content">
                        <p class="notification-title">${notification.title}</p>
                        <p class="notification-desc">${notification.description}</p>
                        <span class="notification-time">${notification.time}</span>
                    </div>
                </div>
            `).join('');
            markAllBtn.style.display = 'block';
            notificationFooter.style.display = 'block';
        }
    }

    function updateNotificationBadge(count) {
        const badge = document.getElementById('notificationBadge');
        if (count > 0) {
            badge.textContent = count > 99 ? '99+' : count;
            badge.classList.add('show');
        } else {
            badge.classList.remove('show');
        }
    }

    function markAllAsRead() {
        // In a real implementation, you would make an API call here
        const notificationItems = document.querySelectorAll('.notification-item.unread');
        notificationItems.forEach(item => {
            item.classList.remove('unread');
        });
        updateNotificationBadge(0);
    }

    // Close dropdowns when clicking outside
    window.addEventListener('click', function(e) {
        if (!e.target.closest('#vendorProfile')) {
            const profileDropdown = document.getElementById('profileDropdown');
            if (profileDropdown) {
                profileDropdown.classList.remove('show');
                console.log('Profile dropdown closed by outside click'); // Debug log
            }
        }
        
        if (!e.target.closest('.notification-container')) {
            const notificationDropdown = document.getElementById('notificationDropdown');
            if (notificationDropdown) notificationDropdown.classList.remove('show');
        }
        
        if (!e.target.closest('.search-container')) {
            const searchResults = document.getElementById('searchResults');
            if (searchResults) searchResults.classList.remove('show');
        }
    });

    // Mobile menu functionality
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Vendor navbar loaded'); // Debug log
        
        // Profile dropdown functionality - Simplified approach
        const vendorProfile = document.getElementById('vendorProfile');
        const profileDropdown = document.getElementById('profileDropdown');
        
        if (vendorProfile && profileDropdown) {
            // Toggle dropdown when clicking on the profile area (but not the dropdown itself)
            vendorProfile.addEventListener('click', function(e) {
                // If click is on dropdown content, don't toggle
                if (e.target.closest('.profile-dropdown')) {
                    console.log('Click on dropdown content, not toggling');
                    return;
                }
                
                console.log('Profile area clicked, toggling dropdown');
                profileDropdown.classList.toggle('show');
            });
        } else {
            console.error('Profile dropdown elements not found!');
        }
        
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileSearchBtn = document.getElementById('mobileSearchBtn');
        const sidebar = document.getElementById('vendorSidebar');
        const searchContainer = document.querySelector('.navbar-center');
        const searchInput = document.getElementById('searchInput');

        // Test search input
        if (searchInput) {
            console.log('Search input found'); // Debug log
            searchInput.addEventListener('input', function() {
                console.log('Search input changed:', this.value); // Debug log
            });
            
            // Add click event to test
            searchInput.addEventListener('click', function() {
                console.log('Search input clicked'); // Debug log
            });
        } else {
            console.error('Search input not found!'); // Debug log
        }

        if (mobileMenuBtn && sidebar) {
            mobileMenuBtn.addEventListener('click', function() {
                sidebar.classList.toggle('mobile-open');
            });
        }

        if (mobileSearchBtn && searchContainer) {
            mobileSearchBtn.addEventListener('click', function() {
                searchContainer.classList.toggle('mobile-show');
                if (searchContainer.classList.contains('mobile-show')) {
                    document.getElementById('searchInput').focus();
                }
            });
        }

        // Initialize with notifications from backend
        loadNotifications();
        
        // Refresh notifications every 30 seconds
        setInterval(loadNotifications, 30000);
    });
</script>
