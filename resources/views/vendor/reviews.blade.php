@extends('vendor.layout.main')

@section('title', 'Customer Reviews')

@section('content')
<div class="welcome-section">
    <h1>Customer Reviews</h1>
    <p>View customer feedback for your products</p>
</div>

<!-- Filter Section -->
<div class="section-card">
    <div class="section-header">
        <h2>Filter Reviews</h2>
        <div class="header-actions">
            <span class="review-count">Total Reviews: {{ $reviews->count() }}</span>
        </div>
    </div>
    
    <div class="filter-row">
        <div class="filter-group">
            <label for="productFilter" class="form-label">Filter by Product:</label>
            <select class="form-control" id="productFilter" onchange="filterReviews()">
                <option value="">All Products</option>
                @foreach($reviews->groupBy('product.post_title') as $productName => $productReviews)
                    <option value="{{ $productName }}">{{ $productName }}</option>
                @endforeach
            </select>
        </div>
        <div class="filter-group">
            <label for="ratingFilter" class="form-label">Filter by Rating:</label>
            <select class="form-control" id="ratingFilter" onchange="filterReviews()">
                <option value="">All Ratings</option>
                <option value="5">5 Stars</option>
                <option value="4">4 Stars</option>
                <option value="3">3 Stars</option>
                <option value="2">2 Stars</option>
                <option value="1">1 Star</option>
            </select>
        </div>
    </div>
</div>

<!-- Reviews Cards -->
<div class="section-card">
    <div class="section-header">
        <h2>Customer Reviews</h2>
    </div>
    
    @if($reviews->count() > 0)
        <div class="reviews-grid">
            @foreach($reviews as $review)
            <div class="review-card" data-product="{{ $review->product->post_title }}" data-rating="{{ $review->rating }}">
                <!-- Review Header -->
                <div class="review-header">
                    <div class="product-name">{{ $review->product->post_title }}</div>
                    <div class="review-date">{{ $review->created_at->format('M d, Y') }}</div>
                </div>

                <!-- Customer Info -->
                <div class="customer-info">
                    <div class="customer-name">{{ $review->user->name }}</div>
                    <div class="star-rating">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                <span class="star filled">★</span>
                            @else
                                <span class="star empty">☆</span>
                            @endif
                        @endfor
                        <span class="rating-text">({{ $review->rating }}/5)</span>
                    </div>
                </div>

                <!-- Review Comment -->
                <div class="review-comment">
                    <p>{{ $review->comment }}</p>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- No Reviews Message -->
        <div class="no-reviews">
            <h3>No Reviews Yet</h3>
            <p>When customers review your products, they will appear here.</p>
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    /* Filter Section */
    .filter-row {
        display: flex;
        gap: 20px;
        margin-top: 15px;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        min-width: 200px;
        flex: 1;
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 8px;
        color: #2c3e50;
        font-size: 15px;
    }

    .form-control {
        padding: 12px 15px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 15px;
        transition: all 0.3s ease;
        background: #ffffff;
    }

    .form-control:focus {
        outline: none;
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    }

    .header-actions {
        display: flex;
        align-items: center;
    }

    .review-count {
        background: #3498db;
        color: #fff;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }

    /* Reviews Grid */
    .reviews-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
        gap: 25px;
        margin-top: 20px;
    }

    /* Review Card */
    .review-card {
        background: #ffffff;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 25px;
        transition: all 0.3s ease;
    }

    .review-card:hover {
        border-color: #3498db;
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.15);
    }

    /* Review Header */
    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f3f4f6;
    }

    .product-name {
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
    }

    .review-date {
        font-size: 14px;
        color: #6b7280;
        font-weight: 500;
    }

    /* Customer Info */
    .customer-info {
        margin-bottom: 15px;
    }

    .customer-name {
        font-size: 15px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .star-rating {
        display: flex;
        align-items: center;
        gap: 2px;
    }

    .star {
        font-size: 18px;
        color: #fbbf24;
    }

    .star.empty {
        color: #d1d5db;
    }

    .rating-text {
        margin-left: 8px;
        font-size: 14px;
        color: #6b7280;
        font-weight: 500;
    }

    /* Review Comment */
    .review-comment {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border-left: 4px solid #3498db;
    }

    .review-comment p {
        margin: 0;
        font-size: 15px;
        line-height: 1.5;
        color: #374151;
    }

    /* No Reviews */
    .no-reviews {
        text-align: center;
        padding: 60px 20px;
        color: #6b7280;
    }

    .no-reviews h3 {
        font-size: 24px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 10px;
    }

    .no-reviews p {
        font-size: 16px;
        margin-bottom: 0;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .reviews-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .filter-row {
            flex-direction: column;
            gap: 15px;
        }

        .filter-group {
            min-width: 100%;
        }

        .review-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .review-date {
            align-self: flex-end;
        }
    }

    @media (max-width: 480px) {
        .review-card {
            padding: 20px;
        }

        .product-name {
            font-size: 15px;
        }

        .star {
            font-size: 16px;
        }

        .review-comment {
            padding: 12px;
        }

        .review-comment p {
            font-size: 14px;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    // Simple filter function for reviews
    function filterReviews() {
        const productFilter = document.getElementById('productFilter').value;
        const ratingFilter = document.getElementById('ratingFilter').value;
        const cards = document.querySelectorAll('.review-card');
        
        let visibleCount = 0;
        
        cards.forEach(card => {
            const cardProduct = card.getAttribute('data-product');
            const cardRating = card.getAttribute('data-rating');
            let showCard = true;
            
            // Check product filter
            if (productFilter && cardProduct !== productFilter) {
                showCard = false;
            }
            
            // Check rating filter
            if (ratingFilter && cardRating !== ratingFilter) {
                showCard = false;
            }
            
            // Show or hide the card
            if (showCard) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        console.log(`Showing ${visibleCount} reviews`);
    }

    // Initialize the page when it loads
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Customer Reviews page loaded successfully!');
    });
</script>
@endsection