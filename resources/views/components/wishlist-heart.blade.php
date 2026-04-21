@props(['productId', 'inWishlist' => false, 'size' => 'md'])

@php
    // Determine size classes
    $sizeClasses = [
        'sm' => 'wishlist-heart-sm',
        'md' => 'wishlist-heart-md', 
        'lg' => 'wishlist-heart-lg'
    ];
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

<button class="wishlist-heart-btn {{ $sizeClass }} {{ $inWishlist ? 'active' : '' }}" 
        data-product-id="{{ $productId }}"
        onclick="toggleWishlist({{ $productId }}, this)"
        title="{{ $inWishlist ? 'Remove from wishlist' : 'Add to wishlist' }}">
    <i class="fas fa-heart"></i>
    <span class="wishlist-tooltip">{{ $inWishlist ? 'Remove from wishlist' : 'Add to wishlist' }}</span>
</button>

<style>
    /* Wishlist Heart Button Styles */
    .wishlist-heart-btn {
        position: relative;
        background: rgba(255, 255, 255, 0.9);
        border: 2px solid #e9ecef;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
        z-index: 10;
    }

    .wishlist-heart-btn:hover {
        background: white;
        border-color: #8b5cf6;
        transform: scale(1.1);
        box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
    }

    .wishlist-heart-btn i {
        transition: all 0.3s ease;
        color: #6c757d;
    }

    .wishlist-heart-btn:hover i {
        color: #8b5cf6;
    }

    .wishlist-heart-btn.active {
        background: #8b5cf6;
        border-color: #8b5cf6;
        animation: heartBeat 0.6s ease;
    }

    .wishlist-heart-btn.active i {
        color: white;
    }

    .wishlist-heart-btn.active:hover {
        background: #7c3aed;
        border-color: #7c3aed;
    }

    /* Size Variations */
    .wishlist-heart-sm {
        width: 35px;
        height: 35px;
        font-size: 14px;
    }

    .wishlist-heart-md {
        width: 45px;
        height: 45px;
        font-size: 16px;
    }

    .wishlist-heart-lg {
        width: 55px;
        height: 55px;
        font-size: 20px;
    }

    /* Tooltip */
    .wishlist-tooltip {
        position: absolute;
        bottom: -35px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        pointer-events: none;
        z-index: 1000;
    }

    .wishlist-tooltip::before {
        content: '';
        position: absolute;
        top: -5px;
        left: 50%;
        transform: translateX(-50%);
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-bottom: 5px solid rgba(0, 0, 0, 0.8);
    }

    .wishlist-heart-btn:hover .wishlist-tooltip {
        opacity: 1;
        visibility: visible;
        bottom: -40px;
    }

    /* Loading State */
    .wishlist-heart-btn.loading {
        pointer-events: none;
        opacity: 0.7;
    }

    .wishlist-heart-btn.loading i {
        animation: spin 1s linear infinite;
    }

    /* Animations */
    @keyframes heartBeat {
        0% { transform: scale(1); }
        25% { transform: scale(1.2); }
        50% { transform: scale(1); }
        75% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .wishlist-heart-md {
            width: 40px;
            height: 40px;
            font-size: 14px;
        }
        
        .wishlist-heart-lg {
            width: 50px;
            height: 50px;
            font-size: 18px;
        }
        
        .wishlist-tooltip {
            font-size: 11px;
            padding: 4px 8px;
        }
    }
</style>

<script>
    // Global wishlist toggle function
    function toggleWishlist(productId, button) {
        // Check if user is authenticated
        @guest
            // Redirect to login if not authenticated
            window.location.href = '{{ route("login") }}';
            return;
        @endguest

        // Add loading state
        button.classList.add('loading');
        const icon = button.querySelector('i');
        const tooltip = button.querySelector('.wishlist-tooltip');
        const originalIcon = icon.className;

        // Change to loading spinner
        icon.className = 'fas fa-spinner fa-spin';

        // Make AJAX request
        fetch('/wishlist/toggle', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                product_id: productId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update button state
                if (data.action === 'added') {
                    button.classList.add('active');
                    tooltip.textContent = 'Remove from wishlist';
                    button.setAttribute('title', 'Remove from wishlist');
                } else {
                    button.classList.remove('active');
                    tooltip.textContent = 'Add to wishlist';
                    button.setAttribute('title', 'Add to wishlist');
                }

                // Update wishlist counter in navigation
                updateWishlistCounter(data.wishlist_count);

                // Show success message (if toast function exists)
                if (typeof showToast === 'function') {
                    showToast(data.message, 'success');
                }
            } else {
                // Show error message
                if (typeof showToast === 'function') {
                    showToast(data.message, 'error');
                } else {
                    alert(data.message);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (typeof showToast === 'function') {
                showToast('An error occurred. Please try again.', 'error');
            } else {
                alert('An error occurred. Please try again.');
            }
        })
        .finally(() => {
            // Remove loading state
            button.classList.remove('loading');
            icon.className = originalIcon;
        });
    }

    // Update wishlist counter in navigation
    function updateWishlistCounter(count) {
        const counters = document.querySelectorAll('.wishlist-counter, .wishlist-count');
        counters.forEach(counter => {
            if (count > 0) {
                counter.textContent = count;
                counter.style.display = 'flex';
                
                // Add animation
                counter.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    counter.style.transform = 'scale(1)';
                }, 200);
            } else {
                counter.style.display = 'none';
            }
        });
    }

    // Initialize wishlist buttons on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Add smooth transition to all wishlist buttons
        const wishlistButtons = document.querySelectorAll('.wishlist-heart-btn');
        wishlistButtons.forEach(button => {
            button.style.transition = 'all 0.3s ease';
        });
    });
</script>