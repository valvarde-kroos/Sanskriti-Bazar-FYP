@extends('admin.layout.main')

@section('title', 'Reviews Management')

@section('content')
<!-- Simple Page Header -->
<div class="page-header">
    <div class="header-left">
        <h1>Reviews Management</h1>
        <p>Manage customer reviews and ratings in Sanskriti Bazar</p>
    </div>
    <div class="header-right">
        <button class="btn btn-secondary" onclick="exportReviews()">
            <i class="fas fa-download"></i>
            Export Reviews
        </button>
    </div>
</div>

<!-- Simple Stats Cards -->
<div class="stats-cards">
    <div class="stat-card total">
        <div class="stat-number">{{ $reviews->count() }}</div>
        <div class="stat-label">Total Reviews</div>
        <div class="stat-icon"><i class="fas fa-star"></i></div>
    </div>
    <div class="stat-card pending">
        <div class="stat-number">{{ $reviews->where('status', 'pending')->count() }}</div>
        <div class="stat-label">Pending Approval</div>
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
    </div>
    <div class="stat-card approved">
        <div class="stat-number">{{ $reviews->where('status', 'approved')->count() }}</div>
        <div class="stat-label">Approved Reviews</div>
        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
    </div>
    <div class="stat-card rating">
        <div class="stat-number">{{ $reviews->count() > 0 ? number_format($reviews->avg('rating'), 1) : '0.0' }}</div>
        <div class="stat-label">Average Rating</div>
        <div class="stat-icon"><i class="fas fa-star-half-alt"></i></div>
    </div>
</div>

<!-- Simple Search -->
<div class="search-section">
    <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="reviewSearch" placeholder="Search reviews by product or customer...">
    </div>
    <select id="statusFilter" class="filter-select">
        <option value="">All Reviews</option>
        <option value="approved">Approved Only</option>
        <option value="pending">Pending Only</option>
        <option value="rejected">Rejected Only</option>
    </select>
    <select id="ratingFilter" class="filter-select">
        <option value="">All Ratings</option>
        <option value="5">5 Stars</option>
        <option value="4">4 Stars</option>
        <option value="3">3 Stars</option>
        <option value="2">2 Stars</option>
        <option value="1">1 Star</option>
    </select>
</div>

<!-- Simple Reviews Table -->
<div class="reviews-table">
    <div class="table-header">
        <h3>All Reviews</h3>
        <span class="review-count">Showing {{ $reviews->count() }} reviews</span>
    </div>
    
    <div class="table-container">
        <table class="simple-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Customer</th>
                    <th>Rating</th>
                    <th>Review Comment</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                <tr>
                    <td>
                        <div class="product-info">
                            <div class="product-image">
                                @if($review->product && $review->product->image)
                                    <img src="{{ asset('uploads/' . $review->product->image) }}" alt="{{ $review->product->post_title }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px;">
                                @else
                                    📦
                                @endif
                            </div>
                            <div class="product-details">
                                <div class="product-name">{{ $review->product_name }}</div>
                                <div class="product-id">#PROD{{ str_pad($review->product_id, 3, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="customer-info">
                            <div class="customer-name">{{ $review->customer_name }}</div>
                            <div class="customer-email">{{ $review->customer_email }}</div>
                        </div>
                    </td>
                    <td>
                        <div class="rating-display">
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="rating-number">{{ $review->rating }}.0</span>
                        </div>
                    </td>
                    <td>
                        <div class="review-comment">
                            "{{ Str::limit($review->comment, 100) }}"
                        </div>
                    </td>
                    <td>
                        <span class="status-badge {{ $review->status }}">{{ ucfirst($review->status) }}</span>
                    </td>
                    <td>{{ $review->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-action view" onclick="viewReview({{ $review->id }})" title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-action edit" onclick="editReview({{ $review->id }})" title="Edit Review">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-action delete" onclick="deleteReview({{ $review->id }})" title="Delete Review">
                                <i class="fas fa-trash"></i>
                            </button>
                            @if($review->status === 'pending')
                                <button class="btn-action approve" onclick="approveReview({{ $review->id }})" title="Approve Review">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="btn-action reject" onclick="rejectReview({{ $review->id }})" title="Reject Review">
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="no-data">
                        <div style="text-align: center; padding: 2rem; color: #6b7280;">
                            <i class="fas fa-star" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                            <h4 style="margin: 0 0 0.5rem 0;">No Reviews Yet</h4>
                            <p style="margin: 0;">Customer reviews will appear here when they start rating products.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Simple Review Details Modal -->
<div id="reviewModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Review Details</h3>
            <button class="close-btn" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body" id="reviewDetails">
            <!-- Review details will be loaded here -->
        </div>
    </div>
</div>

<!-- Edit Review Modal -->
<div id="editReviewModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Review</h3>
            <button class="close-btn" onclick="closeEditModal()">&times;</button>
        </div>
        <form id="editReviewForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label for="edit_rating">Rating:</label>
                    <select id="edit_rating" name="rating" class="form-control" required>
                        <option value="1">1 Star - Poor</option>
                        <option value="2">2 Stars - Fair</option>
                        <option value="3">3 Stars - Good</option>
                        <option value="4">4 Stars - Very Good</option>
                        <option value="5">5 Stars - Excellent</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="edit_comment">Review Comment:</label>
                    <textarea id="edit_comment" name="comment" class="form-control" rows="4" required placeholder="Enter review comment..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="edit_status">Status:</label>
                    <select id="edit_status" name="status" class="form-control" required>
                        <option value="pending">Pending - Waiting for approval</option>
                        <option value="approved">Approved - Visible to customers</option>
                        <option value="rejected">Rejected - Hidden from customers</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="edit_admin_response">Admin Response (Optional):</label>
                    <textarea id="edit_admin_response" name="admin_response" class="form-control" rows="3" placeholder="Optional response from admin..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="btn btn-submit">Update Review</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('styles')
<style>
    /* CSS Variables for consistent colors */
    :root {
        --primary-color: #3b82f6;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --gray-800: #1f2937;
        --gray-600: #4b5563;
        --gray-500: #6b7280;
        --gray-400: #9ca3af;
        --gray-300: #d1d5db;
        --gray-200: #e5e7eb;
        --gray-100: #f3f4f6;
        --gray-50: #f9fafb;
        --white: #ffffff;
        --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    /* Simple Reviews Management Styles */
    
    /* Page Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .header-left h1 {
        font-size: 1.8rem;
        color: #1f2937;
        margin: 0 0 0.25rem 0;
        font-weight: 600;
    }

    .header-left p {
        color: #6b7280;
        margin: 0;
        font-size: 0.9rem;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        font-size: 0.875rem;
        transition: all 0.2s ease;
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
        transform: translateY(-1px);
    }

    /* Stats Cards */
    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .stat-card.total { border-left: 4px solid #8b5cf6; }
    .stat-card.pending { border-left: 4px solid #f59e0b; }
    .stat-card.approved { border-left: 4px solid #10b981; }
    .stat-card.rating { border-left: 4px solid #3b82f6; }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
    }

    .stat-label {
        font-size: 0.8rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    .stat-icon {
        font-size: 1.5rem;
        opacity: 0.3;
    }

    .stat-card.total .stat-icon { color: #8b5cf6; }
    .stat-card.pending .stat-icon { color: #f59e0b; }
    .stat-card.approved .stat-icon { color: #10b981; }
    .stat-card.rating .stat-icon { color: #3b82f6; }

    /* Search Section */
    .search-section {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .search-box {
        flex: 1;
        position: relative;
        min-width: 250px;
    }

    .search-box i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }

    .search-box input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.5rem;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 0.875rem;
        outline: none;
        transition: all 0.2s ease;
    }

    .search-box input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .filter-select {
        padding: 0.75rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 0.875rem;
        background: white;
        min-width: 120px;
        outline: none;
    }

    /* Reviews Table */
    .reviews-table {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .table-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f9fafb;
    }

    .table-header h3 {
        margin: 0;
        font-size: 1.1rem;
        color: #1f2937;
        font-weight: 600;
    }

    .review-count {
        font-size: 0.875rem;
        color: #6b7280;
    }

    .table-container {
        overflow-x: auto;
    }

    .simple-table {
        width: 100%;
        border-collapse: collapse;
    }

    .simple-table th {
        background: #f9fafb;
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: #374151;
        font-size: 0.875rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .simple-table td {
        padding: 1rem;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }

    .simple-table tbody tr:hover {
        background: #f9fafb;
    }

    /* Product Info */
    .product-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .product-image {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .product-name {
        font-weight: 600;
        color: #1f2937;
        font-size: 0.875rem;
    }

    .product-id {
        font-size: 0.75rem;
        color: #6b7280;
    }

    /* Customer Info */
    .customer-name {
        font-weight: 500;
        color: #1f2937;
        font-size: 0.875rem;
    }

    .customer-email {
        font-size: 0.75rem;
        color: #6b7280;
    }

    /* Rating Display */
    .rating-display {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .stars {
        display: flex;
        gap: 0.125rem;
    }

    .stars i {
        color: #fbbf24;
        font-size: 0.875rem;
    }

    .rating-number {
        font-weight: 600;
        color: #1f2937;
        font-size: 0.875rem;
    }

    /* Review Comment */
    .review-comment {
        max-width: 200px;
        font-size: 0.8rem;
        color: #4b5563;
        line-height: 1.4;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    /* Status Badges */
    .status-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .status-badge.approved {
        background: #d1fae5;
        color: #065f46;
    }

    .status-badge.pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-badge.rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        transition: all 0.2s ease;
    }

    .btn-action.view {
        background: rgba(59, 130, 246, 0.1);
        color: var(--primary-color);
    }

    .btn-action.view:hover {
        background: var(--primary-color);
        color: white;
    }

    .btn-action.edit {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning-color);
    }

    .btn-action.edit:hover {
        background: var(--warning-color);
        color: white;
    }

    .btn-action.delete {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
    }

    .btn-action.delete:hover {
        background: var(--danger-color);
        color: white;
    }

    .btn-action.approve {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }

    .btn-action.approve:hover {
        background: var(--success-color);
        color: white;
    }

    .btn-action.reject {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
    }

    .btn-action.reject:hover {
        background: var(--danger-color);
        color: white;
    }

    .btn-action.respond {
        background: rgba(99, 102, 241, 0.1);
        color: #6366f1;
    }

    .btn-action.respond:hover {
        background: #6366f1;
        color: white;
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }

    .modal-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        border-radius: 8px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        max-width: 600px;
        width: 90%;
        max-height: 80vh;
        overflow-y: auto;
    }

    .modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.25rem;
        color: #1f2937;
    }

    .close-btn {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #6b7280;
        cursor: pointer;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
    }

    .close-btn:hover {
        background: #f3f4f6;
        color: #374151;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 0.875rem;
        color: #1f2937;
        background: #ffffff;
        transition: border-color 0.2s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .modal-footer {
        padding: 1.5rem;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
    }

    .btn-cancel {
        background: #6b7280;
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .btn-cancel:hover {
        background: #4b5563;
    }

    .btn-submit {
        background: #10b981;
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .btn-submit:hover {
        background: #059669;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .stats-cards {
            grid-template-columns: repeat(2, 1fr);
        }

        .search-section {
            flex-direction: column;
        }

        .action-buttons {
            flex-direction: column;
        }

        .simple-table {
            font-size: 0.8rem;
        }

        .simple-table th,
        .simple-table td {
            padding: 0.5rem;
        }

        .review-comment {
            max-width: 150px;
        }
    }

    @media (max-width: 480px) {
        .stats-cards {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
@section('scripts')
<script>
    // Simple JavaScript for Reviews Management - Beginner Friendly

    // Sample review data for demonstration - use real data from backend
    const reviews = @json($reviews ?? []);

    // Search functionality - Simple and clear
    document.getElementById('reviewSearch').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('.simple-table tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Status filter functionality
    document.getElementById('statusFilter').addEventListener('change', function(e) {
        const filterValue = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('.simple-table tbody tr');
        
        rows.forEach(row => {
            if (filterValue === '') {
                row.style.display = '';
            } else {
                const statusBadge = row.querySelector('.status-badge');
                const status = statusBadge.textContent.toLowerCase();
                if (status === filterValue) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    });

    // Rating filter functionality
    document.getElementById('ratingFilter').addEventListener('change', function(e) {
        const filterValue = e.target.value;
        const rows = document.querySelectorAll('.simple-table tbody tr');
        
        rows.forEach(row => {
            if (filterValue === '') {
                row.style.display = '';
            } else {
                const ratingNumber = row.querySelector('.rating-number');
                const rating = parseFloat(ratingNumber.textContent);
                const targetRating = parseInt(filterValue);
                
                if (rating >= targetRating && rating < targetRating + 1) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    });

    // VIEW REVIEW - Shows review details in a modal
    function viewReview(reviewId) {
        const review = reviews.find(r => r.id == reviewId) || {
            id: reviewId,
            product: 'Traditional Smartphone',
            productId: '#PROD001',
            customer: 'John Doe',
            customerEmail: 'john.doe@email.com',
            rating: 5,
            comment: 'Excellent product! Great quality and fast delivery. Highly recommended for everyone.',
            status: 'approved',
            date: 'Mar 15, 2024'
        };

        // Generate star display
        let starsHtml = '';
        for (let i = 1; i <= 5; i++) {
            if (i <= Math.floor(review.rating)) {
                starsHtml += '<i class="fas fa-star" style="color: #fbbf24;"></i>';
            } else if (i === Math.ceil(review.rating) && review.rating % 1 !== 0) {
                starsHtml += '<i class="fas fa-star-half-alt" style="color: #fbbf24;"></i>';
            } else {
                starsHtml += '<i class="far fa-star" style="color: #fbbf24;"></i>';
            }
        }

        const reviewDetails = `
            <div style="display: grid; gap: 1.5rem;">
                <div style="text-align: center; padding: 1rem; background: #f9fafb; border-radius: 8px;">
                    <h4 style="margin: 0 0 0.5rem 0; color: #1f2937;">Review Details</h4>
                    <p style="margin: 0; color: #6b7280; font-size: 0.875rem;">Review ID: #REV${review.id.toString().padStart(3, '0')}</p>
                </div>
                
                <div style="display: grid; gap: 1rem;">
                    <div style="display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                        <span style="font-weight: 500; color: #374151;">Product:</span>
                        <span style="color: #1f2937; text-align: right;">${review.product}<br><small style="color: #6b7280;">${review.productId}</small></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                        <span style="font-weight: 500; color: #374151;">Customer:</span>
                        <span style="color: #1f2937; text-align: right;">${review.customer}<br><small style="color: #6b7280;">${review.customerEmail}</small></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                        <span style="font-weight: 500; color: #374151;">Rating:</span>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <div style="display: flex; gap: 0.125rem;">${starsHtml}</div>
                            <span style="font-weight: 600; color: #1f2937;">${review.rating}/5</span>
                        </div>
                    </div>
                    <div style="padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                        <span style="font-weight: 500; color: #374151; display: block; margin-bottom: 0.5rem;">Review Comment:</span>
                        <div style="background: #f9fafb; padding: 1rem; border-radius: 6px; color: #1f2937; line-height: 1.5; font-style: italic;">
                            "${review.comment}"
                        </div>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                        <span style="font-weight: 500; color: #374151;">Status:</span>
                        <span class="status-badge ${review.status}">${review.status}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 0.75rem 0;">
                        <span style="font-weight: 500; color: #374151;">Review Date:</span>
                        <span style="color: #1f2937;">${review.date}</span>
                    </div>
                </div>
                
                <div style="display: flex; gap: 0.5rem; justify-content: flex-end; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                    <button onclick="editReview(${reviewId})" style="padding: 0.5rem 1rem; background: #f59e0b; color: white; border: none; border-radius: 4px; cursor: pointer;">Edit Review</button>
                    <button onclick="respondReview(${reviewId})" style="padding: 0.5rem 1rem; background: #6366f1; color: white; border: none; border-radius: 4px; cursor: pointer;">Respond</button>
                    <button onclick="closeModal()" style="padding: 0.5rem 1rem; background: #6b7280; color: white; border: none; border-radius: 4px; cursor: pointer;">Close</button>
                </div>
            </div>
        `;
        
        document.getElementById('reviewDetails').innerHTML = reviewDetails;
        document.getElementById('reviewModal').style.display = 'block';
    }

    // EDIT REVIEW - Opens edit form with real functionality
    function editReview(reviewId) {
        fetch(`/admin/review/edit/${reviewId}`)
            .then(response => response.json())
            .then(data => {
                const review = data.review;
                
                // Populate the edit form
                document.getElementById('edit_rating').value = review.rating;
                document.getElementById('edit_comment').value = review.comment;
                document.getElementById('edit_status').value = review.status;
                document.getElementById('edit_admin_response').value = review.admin_response || '';
                
                // Set form action
                document.getElementById('editReviewForm').action = `/admin/review/update/${reviewId}`;
                
                // Show modal
                document.getElementById('editReviewModal').style.display = 'block';
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error loading review data. Please try again.');
            });
    }

    // DELETE REVIEW - Confirms and deletes review with real functionality
    function deleteReview(reviewId) {
        const review = reviews.find(r => r.id == reviewId);
        const reviewInfo = review ? `${review.product_name || review.product} by ${review.customer_name || review.customer}` : `Review #${reviewId}`;
        
        const confirmDelete = confirm(`Are you sure you want to delete this review?\n\nReview: ${reviewInfo}\nID: ${reviewId}\n\nThis action cannot be undone!\n\nThis will permanently remove:\n• The review comment\n• The rating\n• All review data`);
        
        if (confirmDelete) {
            // Create form to submit delete request
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/review/delete/${reviewId}`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfToken);
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            form.appendChild(methodField);
            
            document.body.appendChild(form);
            form.submit();
        }
    }

    // APPROVE REVIEW - Approves pending review with real functionality
    function approveReview(reviewId) {
        const review = reviews.find(r => r.id == reviewId);
        const reviewInfo = review ? `${review.product_name || review.product} by ${review.customer_name || review.customer}` : `Review #${reviewId}`;
        
        const confirmApprove = confirm(`Approve this review?\n\nReview: ${reviewInfo}\nRating: ${review ? review.rating : 'N/A'} stars\n\nThis will make the review visible to all customers.`);
        
        if (confirmApprove) {
            // Create form to submit approval
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/review/update/${reviewId}`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfToken);
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'PUT';
            form.appendChild(methodField);
            
            const statusField = document.createElement('input');
            statusField.type = 'hidden';
            statusField.name = 'status';
            statusField.value = 'approved';
            form.appendChild(statusField);
            
            document.body.appendChild(form);
            form.submit();
        }
    }

    // REJECT REVIEW - Rejects pending review with real functionality
    function rejectReview(reviewId) {
        const review = reviews.find(r => r.id == reviewId);
        const reviewInfo = review ? `${review.product_name || review.product} by ${review.customer_name || review.customer}` : `Review #${reviewId}`;
        
        const reason = prompt(`Reject Review: ${reviewInfo}\n\nPlease provide a reason for rejecting this review:`);
        
        if (reason && reason.trim() !== '') {
            // Create form to submit rejection
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/review/update/${reviewId}`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfToken);
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'PUT';
            form.appendChild(methodField);
            
            const statusField = document.createElement('input');
            statusField.type = 'hidden';
            statusField.name = 'status';
            statusField.value = 'rejected';
            form.appendChild(statusField);
            
            const responseField = document.createElement('input');
            responseField.type = 'hidden';
            responseField.name = 'admin_response';
            responseField.value = reason;
            form.appendChild(responseField);
            
            document.body.appendChild(form);
            form.submit();
        }
    }

    // RESPOND TO REVIEW - Admin response to customer review
    function respondReview(reviewId) {
        const review = reviews.find(r => r.id == reviewId);
        const reviewInfo = review ? `${review.product} by ${review.customer}` : `Review #${reviewId}`;
        
        const response = prompt(`Respond to Review: ${reviewInfo}\n\nWrite your response to this customer review:\n\n(This will be visible to all customers)`);
        
        if (response && response.trim() !== '') {
            alert(`Response Added!\n\nYour response has been added to the review for ${reviewInfo}.\n\nResponse: "${response}"\n\nIn a real application, this would:\n• Add admin response to review\n• Display response on product page\n• Send notification to customer\n• Show "Admin Response" label`);
        }
    }

    // EXPORT REVIEWS - Export reviews data with real functionality
    function exportReviews() {
        // Create a simple CSV export
        const csvContent = "data:text/csv;charset=utf-8," 
            + "Product,Customer,Rating,Comment,Status,Date\n"
            + reviews.map(review => 
                `"${review.product_name || review.product}","${review.customer_name || review.customer}","${review.rating}","${review.comment}","${review.status}","${new Date(review.created_at || Date.now()).toLocaleDateString()}"`
            ).join("\n");
        
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "reviews_export.csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        showMessage('Reviews exported successfully!');
    }

    // CLOSE MODAL - Closes the review details modal
    function closeModal() {
        document.getElementById('reviewModal').style.display = 'none';
    }

    // CLOSE EDIT MODAL - Closes the edit review modal
    function closeEditModal() {
        document.getElementById('editReviewModal').style.display = 'none';
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('reviewModal');
        const editModal = document.getElementById('editReviewModal');
        if (e.target === modal) {
            closeModal();
        }
        if (e.target === editModal) {
            closeEditModal();
        }
    });

    // Simple success message function
    function showMessage(message, type = 'success') {
        const messageDiv = document.createElement('div');
        messageDiv.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            border-radius: 6px;
            color: white;
            font-weight: 500;
            z-index: 9999;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            background: ${type === 'success' ? '#10b981' : '#ef4444'};
        `;
        messageDiv.textContent = message;
        document.body.appendChild(messageDiv);
        
        setTimeout(() => {
            messageDiv.remove();
        }, 3000);
    }

    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Reviews Management page loaded successfully!');
        console.log('Available functions:');
        console.log('- viewReview(id): View review details');
        console.log('- editReview(id): Edit review information');
        console.log('- deleteReview(id): Delete review');
        console.log('- approveReview(id): Approve pending review');
        console.log('- rejectReview(id): Reject pending review');
        console.log('- respondReview(id): Respond to customer review');
        console.log('- exportReviews(): Export all reviews data');
    });
</script>
@endsection