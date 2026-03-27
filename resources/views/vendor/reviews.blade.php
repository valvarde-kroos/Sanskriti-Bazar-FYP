@extends('vendor.layout.main')

@section('title', 'Reviews Management')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews Management - Vendor Dashboard</title>
    <!-- Bootstrap CSS for easy styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Custom CSS for better appearance */
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        
        /* Page header styling */
        .page-header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        /* Filter section styling */
        .filter-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        /* Reviews table styling */
        .reviews-table {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        /* Star rating styling */
        .star-rating {
            color: #ffc107;
            font-size: 1.2rem;
        }
        
        .star-empty {
            color: #e0e0e0;
        }
        
        /* Action buttons styling - All white buttons */
        .btn-view, .btn-edit, .btn-delete {
            background-color: white;
            border: 1px solid #dee2e6;
            color: #495057;
            padding: 5px 10px;
            border-radius: 5px;
            margin-right: 5px;
            font-size: 0.875rem;
        }
        
        .btn-view:hover, .btn-edit:hover, .btn-delete:hover {
            background-color: #f8f9fa;
            color: #495057;
            border-color: #adb5bd;
        }
        
        /* Modal styling */
        .modal-header {
            background-color: #007bff;
            color: white;
        }
        
        /* Comment styling */
        .review-comment {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        /* Table row hover effect */
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">Reviews Management</h2>
                    <p class="text-muted mb-0">Manage customer reviews for your products</p>
                </div>
                <div>
                    <span class="badge bg-primary fs-6">Total Reviews: <span id="totalReviews">5</span></span>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label for="ratingFilter" class="form-label">Filter by Rating:</label>
                    <select class="form-select" id="ratingFilter" onchange="filterReviews()">
                        <option value="">All Ratings</option>
                        <option value="5">5 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="2">2 Stars</option>
                        <option value="1">1 Star</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-secondary" onclick="clearFilter()">
                        <i class="fas fa-refresh"></i> Clear Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- Reviews Table -->
        <div class="reviews-table">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="reviewsTable">
                    <thead class="table-light">
                        <tr>
                            <th>Review ID</th>
                            <th>Product Name</th>
                            <th>Customer Name</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sample Review 1 -->
                        <tr data-rating="5">
                            <td><strong>#REV001</strong></td>
                            <td>Traditional Handicraft Set</td>
                            <td>John Smith</td>
                            <td>
                                <div class="star-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </td>
                            <td>
                                <span class="review-comment" title="Excellent product! Amazing quality and fast delivery. Highly recommend to everyone.">
                                    Excellent product! Amazing quality...
                                </span>
                            </td>
                            <td>April 27, 2024</td>
                            <td>
                                <button class="btn btn-view btn-sm" onclick="viewReview('REV001')">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <button class="btn btn-edit btn-sm" onclick="editReview('REV001')">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-delete btn-sm" onclick="deleteReview('REV001')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                        
                        <!-- Sample Review 2 -->
                        <tr data-rating="4">
                            <td><strong>#REV002</strong></td>
                            <td>Handwoven Textile</td>
                            <td>Sarah Johnson</td>
                            <td>
                                <div class="star-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star star-empty"></i>
                                </div>
                            </td>
                            <td>
                                <span class="review-comment" title="Good quality fabric and nice design. Will order again soon.">
                                    Good quality fabric and nice design...
                                </span>
                            </td>
                            <td>April 26, 2024</td>
                            <td>
                                <button class="btn btn-view btn-sm" onclick="viewReview('REV002')">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <button class="btn btn-edit btn-sm" onclick="editReview('REV002')">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-delete btn-sm" onclick="deleteReview('REV002')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                        
                        <!-- Sample Review 3 -->
                        <tr data-rating="3">
                            <td><strong>#REV003</strong></td>
                            <td>Cultural Artifacts</td>
                            <td>Mike Wilson</td>
                            <td>
                                <div class="star-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star star-empty"></i>
                                    <i class="fas fa-star star-empty"></i>
                                </div>
                            </td>
                            <td>
                                <span class="review-comment" title="Average product. Could be better for the price. Delivery was okay.">
                                    Average product. Could be better...
                                </span>
                            </td>
                            <td>April 25, 2024</td>
                            <td>
                                <button class="btn btn-view btn-sm" onclick="viewReview('REV003')">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <button class="btn btn-edit btn-sm" onclick="editReview('REV003')">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-delete btn-sm" onclick="deleteReview('REV003')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                        
                        <!-- Sample Review 4 -->
                        <tr data-rating="5">
                            <td><strong>#REV004</strong></td>
                            <td>Decorative Items</td>
                            <td>Emma Brown</td>
                            <td>
                                <div class="star-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </td>
                            <td>
                                <span class="review-comment" title="Beautiful decorative items! Perfect for my home. Great craftsmanship.">
                                    Beautiful decorative items! Perfect...
                                </span>
                            </td>
                            <td>April 24, 2024</td>
                            <td>
                                <button class="btn btn-view btn-sm" onclick="viewReview('REV004')">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <button class="btn btn-edit btn-sm" onclick="editReview('REV004')">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-delete btn-sm" onclick="deleteReview('REV004')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                        
                        <!-- Sample Review 5 -->
                        <tr data-rating="2">
                            <td><strong>#REV005</strong></td>
                            <td>Premium Craft Collection</td>
                            <td>Alex Davis</td>
                            <td>
                                <div class="star-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star star-empty"></i>
                                    <i class="fas fa-star star-empty"></i>
                                    <i class="fas fa-star star-empty"></i>
                                </div>
                            </td>
                            <td>
                                <span class="review-comment" title="Not satisfied with the quality. Product arrived damaged. Poor packaging.">
                                    Not satisfied with the quality...
                                </span>
                            </td>
                            <td>April 23, 2024</td>
                            <td>
                                <button class="btn btn-view btn-sm" onclick="viewReview('REV005')">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <button class="btn btn-edit btn-sm" onclick="editReview('REV005')">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-delete btn-sm" onclick="deleteReview('REV005')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Review Details Modal -->
    <div class="modal fade" id="reviewModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Review Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="reviewDetails">
                    <!-- Review details will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Review Modal -->
    <div class="modal fade" id="editReviewModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Review</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editReviewForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><strong>Review ID:</strong></label>
                                    <input type="text" class="form-control" id="editReviewId" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><strong>Product:</strong></label>
                                    <input type="text" class="form-control" id="editProductName" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><strong>Customer:</strong></label>
                                    <input type="text" class="form-control" id="editCustomerName" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editRating" class="form-label"><strong>Rating:</strong></label>
                                    <select class="form-select" id="editRating" required>
                                        <option value="1">1 Star - Poor</option>
                                        <option value="2">2 Stars - Fair</option>
                                        <option value="3">3 Stars - Good</option>
                                        <option value="4">4 Stars - Very Good</option>
                                        <option value="5">5 Stars - Excellent</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><strong>Review Date:</strong></label>
                                    <input type="text" class="form-control" id="editReviewDate" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editComment" class="form-label"><strong>Customer Comment:</strong></label>
                            <textarea class="form-control" id="editComment" rows="4" required></textarea>
                        </div>
                        <div class="alert alert-info">
                            <small><strong>Note:</strong> You can edit the rating and comment. Customer and product information cannot be changed.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sample reviews data for JavaScript operations
        const reviewsData = {
            'REV001': {
                id: 'REV001',
                productName: 'Traditional Handicraft Set',
                customerName: 'John Smith',
                customerEmail: 'john.smith@email.com',
                rating: 5,
                comment: 'Excellent product! Amazing quality and fast delivery. Highly recommend to everyone. The craftsmanship is outstanding and the packaging was perfect.',
                date: 'April 27, 2024',
                orderDate: 'April 20, 2024'
            },
            'REV002': {
                id: 'REV002',
                productName: 'Handwoven Textile',
                customerName: 'Sarah Johnson',
                customerEmail: 'sarah.johnson@email.com',
                rating: 4,
                comment: 'Good quality fabric and nice design. Will order again soon. The colors are vibrant and the texture is soft.',
                date: 'April 26, 2024',
                orderDate: 'April 18, 2024'
            },
            'REV003': {
                id: 'REV003',
                productName: 'Cultural Artifacts',
                customerName: 'Mike Wilson',
                customerEmail: 'mike.wilson@email.com',
                rating: 3,
                comment: 'Average product. Could be better for the price. Delivery was okay but expected more from the description.',
                date: 'April 25, 2024',
                orderDate: 'April 15, 2024'
            },
            'REV004': {
                id: 'REV004',
                productName: 'Decorative Items',
                customerName: 'Emma Brown',
                customerEmail: 'emma.brown@email.com',
                rating: 5,
                comment: 'Beautiful decorative items! Perfect for my home. Great craftsmanship and attention to detail. Exceeded my expectations.',
                date: 'April 24, 2024',
                orderDate: 'April 16, 2024'
            },
            'REV005': {
                id: 'REV005',
                productName: 'Premium Craft Collection',
                customerName: 'Alex Davis',
                customerEmail: 'alex.davis@email.com',
                rating: 2,
                comment: 'Not satisfied with the quality. Product arrived damaged. Poor packaging and the item did not match the description.',
                date: 'April 23, 2024',
                orderDate: 'April 12, 2024'
            }
        };

        // Function to view full review details
        function viewReview(reviewId) {
            console.log('View Review called for:', reviewId);
            const review = reviewsData[reviewId];
            
            if (!review) {
                alert('Review not found!');
                return;
            }

            // Generate star display for modal
            let starsHtml = '';
            for (let i = 1; i <= 5; i++) {
                if (i <= review.rating) {
                    starsHtml += '<i class="fas fa-star text-warning"></i>';
                } else {
                    starsHtml += '<i class="fas fa-star text-muted"></i>';
                }
            }

            // Create detailed review HTML
            const reviewDetailsHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">Review Information</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td><strong>Review ID:</strong></td>
                                <td>#${review.id}</td>
                            </tr>
                            <tr>
                                <td><strong>Product:</strong></td>
                                <td>${review.productName}</td>
                            </tr>
                            <tr>
                                <td><strong>Rating:</strong></td>
                                <td>${starsHtml} (${review.rating}/5)</td>
                            </tr>
                            <tr>
                                <td><strong>Review Date:</strong></td>
                                <td>${review.date}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">Customer Information</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td><strong>Customer:</strong></td>
                                <td>${review.customerName}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>${review.customerEmail}</td>
                            </tr>
                            <tr>
                                <td><strong>Order Date:</strong></td>
                                <td>${review.orderDate}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <h6 class="text-muted mb-3">Customer Comment</h6>
                        <div class="p-3 bg-light rounded">
                            <p class="mb-0">"${review.comment}"</p>
                        </div>
                    </div>
                </div>
            `;

            // Show the modal with review details
            document.getElementById('reviewDetails').innerHTML = reviewDetailsHTML;
            const viewModal = new bootstrap.Modal(document.getElementById('reviewModal'));
            viewModal.show();
        }

        // Function to edit a review
        function editReview(reviewId) {
            console.log('Edit Review called for:', reviewId);
            const review = reviewsData[reviewId];
            
            if (!review) {
                alert('Review not found!');
                return;
            }

            // Populate the edit form with current review data
            document.getElementById('editReviewId').value = '#' + review.id;
            document.getElementById('editProductName').value = review.productName;
            document.getElementById('editCustomerName').value = review.customerName;
            document.getElementById('editRating').value = review.rating;
            document.getElementById('editComment').value = review.comment;
            document.getElementById('editReviewDate').value = review.date;

            // Show the edit modal
            const editModal = new bootstrap.Modal(document.getElementById('editReviewModal'));
            editModal.show();
        }

        // Function to delete a review
        function deleteReview(reviewId) {
            console.log('Delete Review called for:', reviewId);
            const review = reviewsData[reviewId];
            
            if (!review) {
                alert('Review not found!');
                return;
            }

            // Confirm deletion
            const confirmDelete = confirm(
                `Are you sure you want to delete this review?\n\n` +
                `Review ID: #${reviewId}\n` +
                `Product: ${review.productName}\n` +
                `Customer: ${review.customerName}\n\n` +
                `This action cannot be undone!`
            );

            if (confirmDelete) {
                // Find and remove the table row
                const rows = document.querySelectorAll('#reviewsTable tbody tr');
                rows.forEach(row => {
                    const reviewIdCell = row.querySelector('td:first-child strong');
                    if (reviewIdCell && reviewIdCell.textContent === `#${reviewId}`) {
                        // Add fade out effect
                        row.style.transition = 'opacity 0.3s';
                        row.style.opacity = '0';
                        
                        // Remove row after animation
                        setTimeout(() => {
                            row.remove();
                            updateReviewCount();
                            showMessage(`Review #${reviewId} has been deleted successfully!`, 'success');
                        }, 300);
                    }
                });

                // Remove from data object
                delete reviewsData[reviewId];
            }
        }

        // Function to filter reviews by rating
        function filterReviews() {
            console.log('Filter Reviews called');
            const selectedRating = document.getElementById('ratingFilter').value;
            const rows = document.querySelectorAll('#reviewsTable tbody tr');
            
            let visibleCount = 0;

            rows.forEach(row => {
                const rowRating = row.getAttribute('data-rating');
                
                if (selectedRating === '' || rowRating === selectedRating) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Update the total count display
            document.getElementById('totalReviews').textContent = visibleCount;
            
            // Show filter message
            if (selectedRating) {
                showMessage(`Showing ${visibleCount} reviews with ${selectedRating} star(s)`, 'info');
            }
        }

        // Function to clear filter and show all reviews
        function clearFilter() {
            console.log('Clear Filter called');
            document.getElementById('ratingFilter').value = '';
            const rows = document.querySelectorAll('#reviewsTable tbody tr');
            
            rows.forEach(row => {
                row.style.display = '';
            });

            updateReviewCount();
            showMessage('Filter cleared. Showing all reviews.', 'info');
        }

        // Function to update review count
        function updateReviewCount() {
            const visibleRows = document.querySelectorAll('#reviewsTable tbody tr[style=""], #reviewsTable tbody tr:not([style*="display: none"])');
            document.getElementById('totalReviews').textContent = visibleRows.length;
        }

        // Function to show messages to user
        function showMessage(message, type = 'success') {
            // Create alert element
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
            alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            alertDiv.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            // Add to page
            document.body.appendChild(alertDiv);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 3000);
        }

        // Function to update table row after edit
        function updateTableRow(reviewId, newRating, newComment) {
            const rows = document.querySelectorAll('#reviewsTable tbody tr');
            rows.forEach(row => {
                const reviewIdCell = row.querySelector('td:first-child strong');
                if (reviewIdCell && reviewIdCell.textContent === `#${reviewId}`) {
                    // Update rating stars
                    const ratingCell = row.querySelector('.star-rating');
                    let starsHtml = '';
                    for (let i = 1; i <= 5; i++) {
                        if (i <= newRating) {
                            starsHtml += '<i class="fas fa-star"></i>';
                        } else {
                            starsHtml += '<i class="fas fa-star star-empty"></i>';
                        }
                    }
                    ratingCell.innerHTML = starsHtml;
                    
                    // Update comment
                    const commentCell = row.querySelector('.review-comment');
                    const truncatedComment = newComment.length > 30 ? newComment.substring(0, 30) + '...' : newComment;
                    commentCell.textContent = truncatedComment;
                    commentCell.setAttribute('title', newComment);
                    
                    // Update data attribute for filtering
                    row.setAttribute('data-rating', newRating);
                    
                    // Add visual feedback
                    row.style.backgroundColor = '#d4edda';
                    setTimeout(() => {
                        row.style.backgroundColor = '';
                    }, 2000);
                }
            });
        }

        // Initialize the page when it loads
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Reviews Management page loaded successfully!');
            console.log('Available functions:');
            console.log('- viewReview(id): View full review details');
            console.log('- editReview(id): Edit a review');
            console.log('- deleteReview(id): Delete a review');
            console.log('- filterReviews(): Filter reviews by rating');
            console.log('- clearFilter(): Clear all filters');
            
            // Set initial review count
            updateReviewCount();

            // Handle edit form submission
            const editForm = document.getElementById('editReviewForm');
            if (editForm) {
                editForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    console.log('Edit form submitted');
                    
                    const reviewId = document.getElementById('editReviewId').value.replace('#', '');
                    const newRating = parseInt(document.getElementById('editRating').value);
                    const newComment = document.getElementById('editComment').value.trim();
                    
                    if (!newComment) {
                        alert('Comment cannot be empty!');
                        return;
                    }
                    
                    // Update the review data
                    if (reviewsData[reviewId]) {
                        reviewsData[reviewId].rating = newRating;
                        reviewsData[reviewId].comment = newComment;
                        
                        // Update the table row
                        updateTableRow(reviewId, newRating, newComment);
                        
                        // Close modal
                        const editModal = bootstrap.Modal.getInstance(document.getElementById('editReviewModal'));
                        if (editModal) {
                            editModal.hide();
                        }
                        
                        // Show success message
                        showMessage(`Review #${reviewId} updated successfully!`, 'success');
                    }
                });
            }

            // Test all functions on page load
            console.log('Testing function availability:');
            console.log('viewReview function:', typeof viewReview);
            console.log('editReview function:', typeof editReview);
            console.log('deleteReview function:', typeof deleteReview);
            console.log('filterReviews function:', typeof filterReviews);
            console.log('clearFilter function:', typeof clearFilter);
        });
    </script>
</body>
</html>
@endsection