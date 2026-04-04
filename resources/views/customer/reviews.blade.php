@extends('customer.layout.main')

@section('title', 'Reviews')

@section('content')
<div class="welcome-section">
    <h1>Product Reviews</h1>
    <p>Share your experience and write reviews for products you've purchased</p>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
    <strong>Please fix the following errors:</strong><br>
    @foreach($errors->all() as $error)
        • {{ $error }}<br>
    @endforeach
</div>
@endif

<!-- Write New Review Section -->
<div class="section-card">
    <div class="section-header">
        <h2>Write a New Review</h2>
    </div>
    
    <form method="POST" action="{{ route('customer.review.store') }}" id="reviewForm">
        @csrf
        
        <div class="form-group">
            <label for="product_id" class="form-label">Select Product *</label>
            <select class="form-control" id="product_id" name="product_id" required>
                <option value="">Choose a product you purchased...</option>
                @forelse($orderedProducts ?? [] as $product)
                    <option value="{{ $product->id }}">{{ $product->post_title }}</option>
                @empty
                    <option value="1">Bansuri</option>
                    <option value="2">Khaijhandi</option>
                    <option value="3">Madal</option>
                    <option value="4">Sarangi</option>
                    <option value="5">Damphu</option>
                @endforelse
            </select>
            <small class="text-muted">You can only review products you have purchased</small>
        </div>
        
        <div class="form-group">
            <label class="form-label">Rating *</label>
            <div class="star-rating" id="starRating">
                <span class="star" data-rating="1">★</span>
                <span class="star" data-rating="2">★</span>
                <span class="star" data-rating="3">★</span>
                <span class="star" data-rating="4">★</span>
                <span class="star" data-rating="5">★</span>
            </div>
            <input type="hidden" id="rating" name="rating" value="0" required>
            <small class="text-muted">Click on stars to rate the product</small>
        </div>
        
        <div class="form-group">
            <label for="comment" class="form-label">Your Review *</label>
            <textarea class="form-control" id="comment" name="comment" rows="4" 
                      placeholder="Write your detailed review here..." required></textarea>
            <small class="text-muted">Share your experience with this product</small>
        </div>
        
        <button type="submit" class="action-btn primary">Submit Review</button>
    </form>
</div>

<!-- My Reviews Section -->
<div class="section-card">
    <div class="section-header">
        <h2>My Reviews</h2>
    </div>
    
    <div class="reviews-list">
        @forelse($myReviews ?? [] as $review)
        <div class="review-item" id="review-{{ $review->id }}">
            <div class="review-header">
                <h4>{{ $review->product->post_title ?? 'Product Name' }}</h4>
                <div class="review-rating">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="star {{ $i <= ($review->rating ?? 5) ? 'active' : '' }}">★</span>
                    @endfor
                </div>
            </div>
            <p class="review-comment">{{ $review->comment ?? 'Great product! Highly recommended.' }}</p>
            <div class="review-meta">
                <small class="text-muted">Reviewed on {{ $review->created_at->format('M d, Y') ?? 'Mar 20, 2024' }}</small>
                <div class="review-actions">
                    <button class="action-btn small" onclick="editReview({{ $review->id ?? 1 }}, '{{ $review->product->post_title ?? 'Product' }}', {{ $review->rating ?? 5 }}, '{{ addslashes($review->comment ?? 'Great product!') }}')">Edit</button>
                    <button class="action-btn small danger" onclick="deleteReview({{ $review->id ?? 1 }})">Delete</button>
                </div>
            </div>
        </div>
        @empty
        <!-- Sample Reviews for Demo -->
        <div class="review-item" id="review-1">
            <div class="review-header">
                <h4>Bansuri</h4>
                <div class="review-rating">
                    <span class="star active">★</span>
                    <span class="star active">★</span>
                    <span class="star active">★</span>
                    <span class="star active">★</span>
                    <span class="star active">★</span>
                </div>
            </div>
            <p class="review-comment">Excellent product! Amazing quality and fast delivery. The craftsmanship is outstanding and exactly as described. Highly recommend to everyone!</p>
            <div class="review-meta">
                <small class="text-muted">Reviewed on Mar 20, 2024</small>
                <div class="review-actions">
                    <button class="action-btn small" onclick="editReview(1, 'Bansuri', 5, 'Excellent product! Amazing quality and fast delivery.')">Edit</button>
                    <button class="action-btn small danger" onclick="deleteReview(1)">Delete</button>
                </div>
            </div>
        </div>
        
        <div class="review-item" id="review-2">
            <div class="review-header">
                <h4>Khaijhandi</h4>
                <div class="review-rating">
                    <span class="star active">★</span>
                    <span class="star active">★</span>
                    <span class="star active">★</span>
                    <span class="star active">★</span>
                    <span class="star">★</span>
                </div>
            </div>
            <p class="review-comment">Good quality fabric and nice design. The colors are vibrant and the texture is soft. Will order again soon.</p>
            <div class="review-meta">
                <small class="text-muted">Reviewed on Mar 18, 2024</small>
                <div class="review-actions">
                    <button class="action-btn small" onclick="editReview(2, 'Khaijhandi', 4, 'Good quality fabric and nice design.')">Edit</button>
                    <button class="action-btn small danger" onclick="deleteReview(2)">Delete</button>
                </div>
            </div>
        </div>
        
        <div class="review-item" id="review-3">
            <div class="review-header">
                <h4>Sarangi</h4>
                <div class="review-rating">
                    <span class="star active">★</span>
                    <span class="star active">★</span>
                    <span class="star active">★</span>
                    <span class="star active">★</span>
                    <span class="star active">★</span>
                </div>
            </div>
            <p class="review-comment">Beautiful decorative items! Perfect for my home. Great craftsmanship and attention to detail. Exceeded my expectations.</p>
            <div class="review-meta">
                <small class="text-muted">Reviewed on Mar 15, 2024</small>
                <div class="review-actions">
                    <button class="action-btn small" onclick="editReview(3, 'Sarangi', 5, 'Beautiful decorative items! Perfect for my home.')">Edit</button>
                    <button class="action-btn small danger" onclick="deleteReview(3)">Delete</button>
                </div>
            </div>
        </div>
        @endforelse
    </div>
</div>

<!-- Edit Review Modal -->
<div class="modal" id="editReviewModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Review</h5>
                <button type="button" class="btn-close" onclick="hideModal('editReviewModal')">×</button>
            </div>
            <form id="editReviewForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Product</label>
                        <input type="text" class="form-control" id="editProductName" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Rating *</label>
                        <div class="star-rating" id="editStarRating">
                            <span class="star" data-rating="1">★</span>
                            <span class="star" data-rating="2">★</span>
                            <span class="star" data-rating="3">★</span>
                            <span class="star" data-rating="4">★</span>
                            <span class="star" data-rating="5">★</span>
                        </div>
                        <input type="hidden" id="editRating" name="rating" value="0">
                    </div>
                    
                    <div class="form-group">
                        <label for="editComment" class="form-label">Your Review *</label>
                        <textarea class="form-control" id="editComment" name="comment" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="action-btn" onclick="hideModal('editReviewModal')">Cancel</button>
                    <button type="submit" class="action-btn primary">Update Review</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .star-rating {
        display: flex;
        gap: 5px;
        margin: 10px 0;
    }

    .star {
        font-size: 24px;
        color: #ddd;
        cursor: pointer;
        transition: color 0.2s;
    }

    .star.active,
    .star:hover {
        color: #3498db;
    }

    .reviews-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .review-item {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 20px;
        background: #f9fafb;
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .review-header h4 {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        margin: 0;
    }

    .review-rating .star {
        font-size: 16px;
        cursor: default;
    }

    .review-comment {
        color: #374151;
        line-height: 1.5;
        margin-bottom: 15px;
    }

    .review-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .review-actions {
        display: flex;
        gap: 8px;
    }

    .action-btn.danger {
        background: #fee2e2;
        color: #dc2626;
        border-color: #fca5a5;
    }

    .action-btn.danger:hover {
        background: #fecaca;
        color: #b91c1c;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        align-items: center;
        justify-content: center;
    }

    .modal.show {
        display: flex;
    }

    .modal-dialog {
        background: #fff;
        border-radius: 8px;
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-header {
        padding: 20px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-title {
        font-size: 18px;
        font-weight: 600;
        margin: 0;
    }

    .btn-close {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #6b7280;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        padding: 20px;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    @media (max-width: 768px) {
        .review-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        
        .review-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        
        .modal-dialog {
            width: 95%;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    let currentEditReviewId = null;

    // Initialize when page loads
    document.addEventListener('DOMContentLoaded', function() {
        setupStarRating('starRating', 'rating');
        setupStarRating('editStarRating', 'editRating');
        
        // Review form submission
        const reviewForm = document.getElementById('reviewForm');
        reviewForm.addEventListener('submit', function(e) {
            const rating = document.getElementById('rating').value;
            const comment = document.getElementById('comment').value.trim();
            const productId = document.getElementById('product_id').value;
            
            if (!productId) {
                e.preventDefault();
                alert('Please select a product!');
                return false;
            }
            
            if (rating == 0) {
                e.preventDefault();
                alert('Please select a rating!');
                return false;
            }
            
            if (!comment) {
                e.preventDefault();
                alert('Please write a review comment!');
                return false;
            }
            
            // Form will submit normally to server
            console.log('Review form submitting...');
        });

        // Edit review form submission
        const editForm = document.getElementById('editReviewForm');
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const rating = document.getElementById('editRating').value;
            const comment = document.getElementById('editComment').value.trim();
            
            if (rating == 0) {
                alert('Please select a rating!');
                return false;
            }
            
            if (!comment) {
                alert('Please write a review comment!');
                return false;
            }
            
            // Update the review in the list
            updateReviewInList(currentEditReviewId, rating, comment);
            
            // Hide modal
            hideModal('editReviewModal');
            
            alert('Review updated successfully!');
            console.log('Review updated:', { id: currentEditReviewId, rating, comment });
        });
    });

    // Setup star rating functionality
    function setupStarRating(containerId, inputId) {
        const container = document.getElementById(containerId);
        const input = document.getElementById(inputId);
        const stars = container.querySelectorAll('.star');
        
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-rating');
                input.value = rating;
                
                // Update star display
                stars.forEach((s, index) => {
                    if (index < rating) {
                        s.classList.add('active');
                    } else {
                        s.classList.remove('active');
                    }
                });
            });
        });
    }

    // Edit Review Function
    function editReview(reviewId, productName, rating, comment) {
        currentEditReviewId = reviewId;
        
        // Populate edit form
        document.getElementById('editProductName').value = productName;
        document.getElementById('editRating').value = rating;
        document.getElementById('editComment').value = comment;
        
        // Update star display
        const stars = document.querySelectorAll('#editStarRating .star');
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.add('active');
            } else {
                star.classList.remove('active');
            }
        });
        
        // Show modal
        showModal('editReviewModal');
    }

    // Delete Review Function
    function deleteReview(reviewId) {
        if (confirm('Are you sure you want to delete this review?')) {
            // Remove review from the list
            const reviewElement = document.getElementById('review-' + reviewId);
            if (reviewElement) {
                reviewElement.remove();
                alert('Review deleted successfully!');
            }
            
            console.log('Review deleted:', reviewId);
        }
    }

    // Update review in the list
    function updateReviewInList(reviewId, rating, comment) {
        const reviewElement = document.getElementById('review-' + reviewId);
        
        if (reviewElement) {
            // Update rating stars
            const ratingStars = reviewElement.querySelectorAll('.review-rating .star');
            ratingStars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
            });
            
            // Update comment
            const commentElement = reviewElement.querySelector('.review-comment');
            commentElement.textContent = comment;
        }
    }

    // Show Modal Function
    function showModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('show');
    }

    // Hide Modal Function
    function hideModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.remove('show');
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal')) {
            hideModal(e.target.id);
        }
    });

    console.log('Customer Reviews page loaded successfully!');
</script>
@endsection