@extends('vendor.layout.app')

@section('content')
<div class="notifications-page">
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <i class="fas fa-bell"></i>
                Notifications
            </h1>
            <p class="page-subtitle">Stay updated with order alerts, stock warnings, and payout confirmations</p>
        </div>
        <div class="header-actions">
            <button class="btn-secondary" onclick="markAllAsRead()">
                <i class="fas fa-check-double"></i>
                Mark All as Read
            </button>
            <button class="btn-secondary" onclick="clearAll()">
                <i class="fas fa-trash"></i>
                Clear All
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Notification Stats -->
    <div class="notification-stats">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(102, 126, 234, 0.1); color: #667eea;">
                <i class="fas fa-bell"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ count($allNotifications) }}</div>
                <div class="stat-label">Total Notifications</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(231, 76, 60, 0.1); color: #e74c3c;">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $unreadCount }}</div>
                <div class="stat-label">Unread</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(46, 204, 113, 0.1); color: #2ecc71;">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ count(array_filter($allNotifications, fn($n) => $n['type'] === 'order')) }}</div>
                <div class="stat-label">Order Alerts</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(241, 196, 15, 0.1); color: #f1c40f;">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ count(array_filter($allNotifications, fn($n) => $n['type'] === 'payout')) }}</div>
                <div class="stat-label">Payout Confirmations</div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-tabs">
        <button class="filter-tab active" onclick="filterNotifications('all')">
            All Notifications
        </button>
        <button class="filter-tab" onclick="filterNotifications('order')">
            <i class="fas fa-shopping-cart"></i>
            Order Alerts
        </button>
        <button class="filter-tab" onclick="filterNotifications('stock')">
            <i class="fas fa-box"></i>
            Stock Warnings
        </button>
        <button class="filter-tab" onclick="filterNotifications('payout')">
            <i class="fas fa-money-bill-wave"></i>
            Payouts
        </button>
    </div>

    <!-- Notifications List -->
    <div class="notifications-container">
        @forelse($allNotifications as $notification)
            <div class="notification-card {{ $notification['unread'] ? 'unread' : '' }}" data-type="{{ $notification['type'] }}" data-id="{{ $notification['id'] }}">
                <div class="notification-icon-wrapper">
                    <div class="notification-icon {{ $notification['type'] }}">
                        <i class="{{ $notification['icon'] }}"></i>
                    </div>
                    @if($notification['unread'])
                        <span class="unread-dot"></span>
                    @endif
                </div>
                
                <div class="notification-content">
                    <div class="notification-header">
                        <h3 class="notification-title">{{ $notification['title'] }}</h3>
                        <span class="notification-time">{{ $notification['time'] }}</span>
                    </div>
                    <p class="notification-description">{{ $notification['description'] }}</p>
                    
                    @if($notification['type'] === 'order')
                        <div class="notification-status">
                            <span class="status-badge status-{{ $notification['status'] }}">
                                {{ ucfirst($notification['status']) }}
                            </span>
                        </div>
                    @endif
                </div>
                
                <div class="notification-actions">
                    @if($notification['type'] === 'order')
                        <button class="btn-action" onclick="viewOrder('{{ $notification['id'] }}')">
                            <i class="fas fa-eye"></i>
                            View Order
                        </button>
                    @elseif($notification['type'] === 'stock')
                        <button class="btn-action" onclick="viewProduct('{{ $notification['id'] }}')">
                            <i class="fas fa-box"></i>
                            View Product
                        </button>
                    @endif
                    
                    @if($notification['unread'])
                        <button class="btn-icon" onclick="markAsRead('{{ $notification['id'] }}')" title="Mark as read">
                            <i class="fas fa-check"></i>
                        </button>
                    @endif
                    
                    <button class="btn-icon" onclick="deleteNotification('{{ $notification['id'] }}')" title="Delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-bell-slash"></i>
                </div>
                <h3>No Notifications</h3>
                <p>You're all caught up! Check back later for updates.</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    .notifications-page {
        padding: 30px;
        max-width: 1400px;
        margin: 0 auto;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 30px;
        gap: 20px;
    }

    .header-content {
        flex: 1;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #2c3e50;
        margin: 0 0 8px 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title i {
        color: #667eea;
    }

    .page-subtitle {
        font-size: 14px;
        color: #7f8c8d;
        margin: 0;
    }

    .header-actions {
        display: flex;
        gap: 10px;
    }

    .btn-secondary {
        padding: 10px 20px;
        background: white;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        color: #2c3e50;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-secondary:hover {
        background: #f8f9fa;
        border-color: #667eea;
        color: #667eea;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .alert-success {
        background: rgba(46, 204, 113, 0.1);
        border: 1px solid rgba(46, 204, 113, 0.3);
        color: #27ae60;
    }

    /* Notification Stats */
    .notification-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .stat-content {
        flex: 1;
    }

    .stat-value {
        font-size: 24px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 13px;
        color: #7f8c8d;
    }

    /* Filter Tabs */
    .filter-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .filter-tab {
        padding: 10px 20px;
        background: white;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        color: #7f8c8d;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-tab:hover {
        background: #f8f9fa;
        border-color: #667eea;
        color: #667eea;
    }

    .filter-tab.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
        color: white;
    }

    /* Notifications Container */
    .notifications-container {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .notification-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        display: flex;
        gap: 20px;
        align-items: flex-start;
        transition: all 0.3s;
        border-left: 4px solid transparent;
    }

    .notification-card:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .notification-card.unread {
        background: rgba(102, 126, 234, 0.03);
        border-left-color: #667eea;
    }

    .notification-icon-wrapper {
        position: relative;
    }

    .notification-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: white;
    }

    .notification-icon.order {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .notification-icon.stock {
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
    }

    .notification-icon.payout {
        background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
    }

    .unread-dot {
        position: absolute;
        top: 0;
        right: 0;
        width: 12px;
        height: 12px;
        background: #e74c3c;
        border: 2px solid white;
        border-radius: 50%;
    }

    .notification-content {
        flex: 1;
    }

    .notification-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 8px;
        gap: 15px;
    }

    .notification-title {
        font-size: 16px;
        font-weight: 600;
        color: #2c3e50;
        margin: 0;
    }

    .notification-time {
        font-size: 12px;
        color: #95a5a6;
        white-space: nowrap;
    }

    .notification-description {
        font-size: 14px;
        color: #7f8c8d;
        margin: 0 0 10px 0;
        line-height: 1.5;
    }

    .notification-status {
        display: flex;
        gap: 8px;
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-pending {
        background: rgba(241, 196, 15, 0.1);
        color: #f39c12;
    }

    .status-accepted {
        background: rgba(52, 152, 219, 0.1);
        color: #3498db;
    }

    .status-processing {
        background: rgba(155, 89, 182, 0.1);
        color: #9b59b6;
    }

    .status-completed {
        background: rgba(46, 204, 113, 0.1);
        color: #27ae60;
    }

    .status-cancelled {
        background: rgba(231, 76, 60, 0.1);
        color: #e74c3c;
    }

    .notification-actions {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .btn-action {
        padding: 8px 16px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        color: white;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        background: white;
        border: 1px solid #ddd;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
        color: #7f8c8d;
    }

    .btn-icon:hover {
        background: #f8f9fa;
        border-color: #667eea;
        color: #667eea;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        background: rgba(102, 126, 234, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        color: #667eea;
    }

    .empty-state h3 {
        font-size: 20px;
        font-weight: 600;
        color: #2c3e50;
        margin: 0 0 8px 0;
    }

    .empty-state p {
        font-size: 14px;
        color: #7f8c8d;
        margin: 0;
    }

    @media (max-width: 768px) {
        .notifications-page {
            padding: 20px;
        }

        .page-header {
            flex-direction: column;
        }

        .header-actions {
            width: 100%;
        }

        .btn-secondary {
            flex: 1;
            justify-content: center;
        }

        .notification-card {
            flex-direction: column;
            gap: 15px;
        }

        .notification-actions {
            width: 100%;
            justify-content: flex-start;
        }

        .btn-action {
            flex: 1;
            justify-content: center;
        }
    }
</style>

<script>
    function filterNotifications(type) {
        const cards = document.querySelectorAll('.notification-card');
        const tabs = document.querySelectorAll('.filter-tab');
        
        // Update active tab
        tabs.forEach(tab => tab.classList.remove('active'));
        event.target.classList.add('active');
        
        // Filter cards
        cards.forEach(card => {
            if (type === 'all' || card.dataset.type === type) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function markAllAsRead() {
        const unreadCards = document.querySelectorAll('.notification-card.unread');
        unreadCards.forEach(card => {
            card.classList.remove('unread');
            const dot = card.querySelector('.unread-dot');
            if (dot) dot.remove();
            const markBtn = card.querySelector('.btn-icon[onclick*="markAsRead"]');
            if (markBtn) markBtn.remove();
        });
        
        // Update unread count
        document.querySelector('.notification-stats .stat-card:nth-child(2) .stat-value').textContent = '0';
        
        alert('All notifications marked as read!');
    }

    function clearAll() {
        if (confirm('Are you sure you want to clear all notifications?')) {
            document.querySelector('.notifications-container').innerHTML = `
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-bell-slash"></i>
                    </div>
                    <h3>No Notifications</h3>
                    <p>You're all caught up! Check back later for updates.</p>
                </div>
            `;
            
            // Update stats
            document.querySelectorAll('.stat-value').forEach(el => el.textContent = '0');
        }
    }

    function markAsRead(id) {
        const card = document.querySelector(`[data-id="${id}"]`);
        if (card) {
            card.classList.remove('unread');
            const dot = card.querySelector('.unread-dot');
            if (dot) dot.remove();
            const markBtn = card.querySelector('.btn-icon[onclick*="markAsRead"]');
            if (markBtn) markBtn.remove();
            
            // Update unread count
            const unreadCount = document.querySelectorAll('.notification-card.unread').length;
            document.querySelector('.notification-stats .stat-card:nth-child(2) .stat-value').textContent = unreadCount;
        }
    }

    function deleteNotification(id) {
        if (confirm('Delete this notification?')) {
            const card = document.querySelector(`[data-id="${id}"]`);
            if (card) {
                const isUnread = card.classList.contains('unread');
                const type = card.dataset.type;
                
                card.style.opacity = '0';
                card.style.transform = 'translateX(100px)';
                
                setTimeout(() => {
                    card.remove();
                    
                    // Update stats
                    const totalCount = document.querySelectorAll('.notification-card').length;
                    document.querySelector('.notification-stats .stat-card:nth-child(1) .stat-value').textContent = totalCount;
                    
                    if (isUnread) {
                        const unreadCount = document.querySelectorAll('.notification-card.unread').length;
                        document.querySelector('.notification-stats .stat-card:nth-child(2) .stat-value').textContent = unreadCount;
                    }
                    
                    // Update type-specific count
                    if (type === 'order') {
                        const orderCount = document.querySelectorAll('[data-type="order"]').length;
                        document.querySelector('.notification-stats .stat-card:nth-child(3) .stat-value').textContent = orderCount;
                    } else if (type === 'payout') {
                        const payoutCount = document.querySelectorAll('[data-type="payout"]').length;
                        document.querySelector('.notification-stats .stat-card:nth-child(4) .stat-value').textContent = payoutCount;
                    }
                    
                    // Show empty state if no notifications left
                    if (totalCount === 0) {
                        document.querySelector('.notifications-container').innerHTML = `
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-bell-slash"></i>
                                </div>
                                <h3>No Notifications</h3>
                                <p>You're all caught up! Check back later for updates.</p>
                            </div>
                        `;
                    }
                }, 300);
            }
        }
    }

    function viewOrder(id) {
        const orderId = id.replace('order-', '');
        window.location.href = '/vendor/orders#order-' + orderId;
    }

    function viewProduct(id) {
        const productId = id.replace('stock-', '');
        window.location.href = '/vendor/products#product-' + productId;
    }
</script>
@endsection
