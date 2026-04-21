@extends('customer.layout.main')

@section('title', 'Notifications')

@section('content')

<div class="notifications-page">
    <div class="notifications-header">
        <h1><i class="fas fa-bell"></i> Notifications</h1>
        <p>Stay updated with your order status and important updates</p>
    </div>

    <div class="notifications-actions">
        <button class="btn-mark-all-read" onclick="markAllAsRead()">
            <i class="fas fa-check-double"></i> Mark All as Read
        </button>
        <button class="btn-clear-all" onclick="clearAllNotifications()">
            <i class="fas fa-trash"></i> Clear All
        </button>
    </div>

    <div class="notifications-list">
        @php
            // Get customer's orders for notifications
            $notifications = [];
            if(isset($orders) && $orders->count() > 0) {
                foreach($orders as $order) {
                    $notifications[] = [
                        'id' => $order->id,
                        'type' => 'order_update',
                        'title' => 'Order #' . str_pad($order->id, 3, '0', STR_PAD_LEFT) . ' - ' . ucfirst($order->status),
                        'message' => 'Your order for "' . ($order->product->post_title ?? 'Product') . '" is ' . $order->status,
                        'time' => $order->updated_at,
                        'status' => $order->status,
                        'read' => false,
                        'order_id' => $order->id
                    ];
                }
            }
        @endphp

        @forelse($notifications as $notification)
        <div class="notification-item {{ $notification['read'] ? 'read' : 'unread' }}" data-id="{{ $notification['id'] }}">
            <div class="notification-icon status-{{ $notification['status'] }}">
                @if($notification['status'] === 'pending')
                    <i class="fas fa-clock"></i>
                @elseif($notification['status'] === 'accepted')
                    <i class="fas fa-check"></i>
                @elseif($notification['status'] === 'processing')
                    <i class="fas fa-cog"></i>
                @elseif($notification['status'] === 'completed')
                    <i class="fas fa-check-circle"></i>
                @elseif($notification['status'] === 'cancelled')
                    <i class="fas fa-times-circle"></i>
                @else
                    <i class="fas fa-bell"></i>
                @endif
            </div>
            <div class="notification-content">
                <h3>{{ $notification['title'] }}</h3>
                <p>{{ $notification['message'] }}</p>
                <span class="notification-time">
                    <i class="fas fa-clock"></i> {{ $notification['time']->diffForHumans() }}
                </span>
            </div>
            <div class="notification-actions">
                <button class="btn-view" onclick="viewOrder({{ $notification['order_id'] }})" title="View Order">
                    <i class="fas fa-eye"></i>
                </button>
                <button class="btn-mark-read" onclick="markAsRead({{ $notification['id'] }}, this)" title="Mark as Read">
                    <i class="fas fa-check"></i>
                </button>
                <button class="btn-delete" onclick="deleteNotification({{ $notification['id'] }}, this)" title="Delete">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
        @empty
        <div class="notifications-empty">
            <div class="empty-icon"><i class="fas fa-bell-slash"></i></div>
            <h2>No Notifications</h2>
            <p>You're all caught up! Check back later for order updates.</p>
            <a href="{{ route('shop.index') }}" class="btn-shop">
                <i class="fas fa-shopping-bag"></i> Continue Shopping
            </a>
        </div>
        @endforelse
    </div>
</div>

<style>
.notifications-page {
    max-width: 900px;
    margin: 0 auto;
}

.notifications-header {
    text-align: center;
    margin-bottom: 30px;
}

.notifications-header h1 {
    font-size: 28px;
    color: #2c3e50;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
}

.notifications-header h1 i {
    color: #667eea;
}

.notifications-header p {
    color: #6c757d;
    font-size: 15px;
}

.notifications-actions {
    display: flex;
    gap: 12px;
    margin-bottom: 25px;
    justify-content: flex-end;
}

.btn-mark-all-read,
.btn-clear-all {
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s;
}

.btn-mark-all-read {
    background: #667eea;
    color: white;
}

.btn-mark-all-read:hover {
    background: #5568d3;
    transform: translateY(-2px);
}

.btn-clear-all {
    background: #f8d7da;
    color: #721c24;
}

.btn-clear-all:hover {
    background: #dc3545;
    color: white;
}

.notifications-list {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07);
    overflow: hidden;
}

.notification-item {
    display: flex;
    align-items: center;
    gap: 18px;
    padding: 20px;
    border-bottom: 1px solid #f0f0f0;
    transition: all 0.3s;
    position: relative;
}

.notification-item:last-child {
    border-bottom: none;
}

.notification-item.unread {
    background: #f0f4ff;
}

.notification-item.unread::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: linear-gradient(135deg, #667eea, #764ba2);
}

.notification-item:hover {
    background: #fafbfc;
}

.notification-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.notification-icon.status-pending {
    background: #fff3cd;
    color: #856404;
}

.notification-icon.status-accepted {
    background: #cce5ff;
    color: #004085;
}

.notification-icon.status-processing {
    background: #d1ecf1;
    color: #0c5460;
}

.notification-icon.status-completed {
    background: #d4edda;
    color: #155724;
}

.notification-icon.status-cancelled {
    background: #f8d7da;
    color: #721c24;
}

.notification-content {
    flex: 1;
}

.notification-content h3 {
    font-size: 16px;
    color: #2c3e50;
    margin-bottom: 6px;
    font-weight: 600;
}

.notification-content p {
    color: #6c757d;
    font-size: 14px;
    margin-bottom: 8px;
    line-height: 1.5;
}

.notification-time {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    color: #adb5bd;
}

.notification-time i {
    font-size: 11px;
}

.notification-actions {
    display: flex;
    gap: 8px;
    flex-shrink: 0;
}

.btn-view,
.btn-mark-read,
.btn-delete {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
    font-size: 14px;
}

.btn-view {
    background: #e7f3ff;
    color: #0066cc;
}

.btn-view:hover {
    background: #0066cc;
    color: white;
}

.btn-mark-read {
    background: #e8f5e9;
    color: #2e7d32;
}

.btn-mark-read:hover {
    background: #4caf50;
    color: white;
}

.btn-delete {
    background: #ffebee;
    color: #c62828;
}

.btn-delete:hover {
    background: #dc3545;
    color: white;
}

.notifications-empty {
    text-align: center;
    padding: 80px 20px;
}

.empty-icon {
    font-size: 60px;
    color: #dee2e6;
    margin-bottom: 20px;
}

.notifications-empty h2 {
    font-size: 24px;
    color: #2c3e50;
    margin-bottom: 10px;
}

.notifications-empty p {
    color: #6c757d;
    margin-bottom: 25px;
}

.btn-shop {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 28px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: transform 0.2s;
}

.btn-shop:hover {
    transform: translateY(-2px);
}

@media (max-width: 600px) {
    .notification-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .notification-actions {
        width: 100%;
        justify-content: flex-end;
    }

    .notifications-actions {
        flex-direction: column;
    }

    .btn-mark-all-read,
    .btn-clear-all {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
function viewOrder(orderId) {
    window.location.href = `/customer/orders`;
}

function markAsRead(notificationId, button) {
    const notificationItem = button.closest('.notification-item');
    notificationItem.classList.remove('unread');
    notificationItem.classList.add('read');
    
    // Hide the mark as read button
    button.style.display = 'none';
    
    showToast('Notification marked as read', 'success');
}

function deleteNotification(notificationId, button) {
    if (!confirm('Delete this notification?')) return;
    
    const notificationItem = button.closest('.notification-item');
    notificationItem.style.animation = 'slideOut 0.3s ease';
    
    setTimeout(() => {
        notificationItem.remove();
        
        // Check if list is empty
        const notificationsList = document.querySelector('.notifications-list');
        if (!notificationsList.querySelector('.notification-item')) {
            notificationsList.innerHTML = `
                <div class="notifications-empty">
                    <div class="empty-icon"><i class="fas fa-bell-slash"></i></div>
                    <h2>No Notifications</h2>
                    <p>You're all caught up! Check back later for order updates.</p>
                    <a href="{{ route('shop.index') }}" class="btn-shop">
                        <i class="fas fa-shopping-bag"></i> Continue Shopping
                    </a>
                </div>
            `;
        }
        
        showToast('Notification deleted', 'success');
    }, 300);
}

function markAllAsRead() {
    const unreadItems = document.querySelectorAll('.notification-item.unread');
    
    if (unreadItems.length === 0) {
        showToast('No unread notifications', 'info');
        return;
    }
    
    unreadItems.forEach(item => {
        item.classList.remove('unread');
        item.classList.add('read');
        const markReadBtn = item.querySelector('.btn-mark-read');
        if (markReadBtn) markReadBtn.style.display = 'none';
    });
    
    showToast(`${unreadItems.length} notification(s) marked as read`, 'success');
}

function clearAllNotifications() {
    const items = document.querySelectorAll('.notification-item');
    
    if (items.length === 0) {
        showToast('No notifications to clear', 'info');
        return;
    }
    
    if (!confirm(`Clear all ${items.length} notification(s)?`)) return;
    
    items.forEach((item, index) => {
        setTimeout(() => {
            item.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => item.remove(), 300);
        }, index * 50);
    });
    
    setTimeout(() => {
        const notificationsList = document.querySelector('.notifications-list');
        notificationsList.innerHTML = `
            <div class="notifications-empty">
                <div class="empty-icon"><i class="fas fa-bell-slash"></i></div>
                <h2>No Notifications</h2>
                <p>You're all caught up! Check back later for order updates.</p>
                <a href="{{ route('shop.index') }}" class="btn-shop">
                    <i class="fas fa-shopping-bag"></i> Continue Shopping
                </a>
            </div>
        `;
        showToast('All notifications cleared', 'success');
    }, items.length * 50 + 300);
}

function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 14px 20px;
        background: ${type === 'success' ? '#d4edda' : type === 'error' ? '#f8d7da' : '#d1ecf1'};
        color: ${type === 'success' ? '#155724' : type === 'error' ? '#721c24' : '#0c5460'};
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10000;
        animation: slideInRight 0.3s ease;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    `;
    
    const icon = type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle';
    toast.innerHTML = `<i class="fas fa-${icon}"></i> ${message}`;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>

<style>
@keyframes slideOut {
    from { opacity: 1; transform: translateX(0); }
    to { opacity: 0; transform: translateX(100%); }
}

@keyframes slideInRight {
    from { opacity: 0; transform: translateX(100%); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes slideOutRight {
    from { opacity: 1; transform: translateX(0); }
    to { opacity: 0; transform: translateX(100%); }
}
</style>

@endsection
