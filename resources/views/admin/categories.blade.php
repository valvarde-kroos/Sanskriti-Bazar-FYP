@extends('admin.layout.main')

@section('title', 'Categories Management')

@section('content')
<!-- Success/Error Messages -->
@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-error">
    <i class="fas fa-exclamation-circle"></i>
    {{ session('error') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-error">
    <i class="fas fa-exclamation-triangle"></i>
    <ul style="margin: 0; padding-left: 1.5rem;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Page Header -->
<div class="page-header">
    <div class="header-content">
        <h1>Categories Management</h1>
        <p class="page-subtitle">Organize your products into categories for easy browsing</p>
    </div>
    <div class="header-actions">
        <button class="btn btn-secondary" onclick="exportCategories()">
            <i class="fas fa-download"></i>
            Export List
        </button>
        <button class="btn btn-primary" onclick="showAddForm()">
            <i class="fas fa-plus"></i>
            Add New Category
        </button>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-row grid grid-cols-4">
    <div class="stat-card">
        <div class="stat-icon total">
            <i class="fas fa-tags"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $categories->count() }}</h3>
            <p>Total Categories</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon active">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $categories->count() }}</h3>
            <p>Active Categories</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon products">
            <i class="fas fa-box"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $categories->sum('products_count') }}</h3>
            <p>Total Products</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon popular">
            <i class="fas fa-star"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $categories->sortByDesc('products_count')->first()->categoryName ?? 'None' }}</h3>
            <p>Most Popular</p>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="filters-section card">
    <div class="filters-content">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="categorySearch" placeholder="Search categories by name...">
        </div>
        <div class="filter-controls">
            <select id="statusFilter">
                <option value="">All Categories</option>
                <option value="active">Active Only</option>
                <option value="inactive">Inactive Only</option>
            </select>
            <button class="btn btn-secondary" onclick="resetFilters()">
                <i class="fas fa-refresh"></i>
                Reset
            </button>
        </div>
    </div>
</div>

<!-- Categories Table -->
<div class="table-section card">
    <div class="table-header">
        <h3>All Categories</h3>
        <div class="table-info">
            <span>Showing {{ $categories->count() }} categories</span>
        </div>
    </div>
    <div class="table-container">
        @if($categories->count() > 0)
            <table class="data-table" id="categoriesTable">
                <thead>
                    <tr>
                        <th>Category Image</th>
                        <th>Category Name</th>
                        <th>Products Count</th>
                        <th>Status</th>
                        <th>Created Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>
                            <div class="category-image">
                                @if($category->image)
                                    <img src="{{ asset('uploads/' . $category->image) }}" alt="{{ $category->categoryName }}" class="category-thumb">
                                @else
                                    <img src="https://via.placeholder.com/50x50/3b82f6/ffffff?text={{ substr($category->categoryName, 0, 2) }}" alt="{{ $category->categoryName }}" class="category-thumb">
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="category-info">
                                <div class="category-name">{{ $category->categoryName }}</div>
                                <div class="category-id">#CAT{{ str_pad($category->id, 3, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </td>
                        <td><span class="product-count">{{ $category->products_count ?? 0 }}</span></td>
                        <td><span class="status-badge active">Active</span></td>
                        <td>{{ $category->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="dropdown-container">
                                <button class="dropdown-toggle" onclick="toggleDropdown({{ $category->id }})">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <div class="dropdown-menu" id="dropdown-{{ $category->id }}">
                                    <button class="dropdown-item" onclick="viewCategory({{ $category->id }})">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    <button class="dropdown-item" onclick="editCategory({{ $category->id }})">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="dropdown-item danger" onclick="deleteCategory({{ $category->id }})">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <h4>No Categories Found</h4>
                <p>Start by adding your first product category to organize your inventory.</p>
                <button class="btn btn-primary" onclick="showAddForm()">
                    <i class="fas fa-plus"></i>
                    Add First Category
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Add Category Modal -->
<div id="addCategoryModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add New Category</h3>
            <button class="modal-close" onclick="closeModal('addCategoryModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="addCategoryForm" class="category-form" action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="categoryName">Category Name *</label>
                    <input type="text" id="categoryName" name="categoryName" placeholder="Enter category name" required>
                    <small>Example: Electronics, Clothing, Books</small>
                </div>
                
                <div class="form-group">
                    <label for="categoryImage">Category Image</label>
                    <input type="file" id="categoryImage" name="image" accept="image/*">
                    <small>Upload an image to represent this category (optional)</small>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-outline" onclick="closeModal('addCategoryModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div id="editCategoryModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Category</h3>
            <button class="modal-close" onclick="closeModal('editCategoryModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="editCategoryForm" class="category-form" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="editCategoryName">Category Name *</label>
                    <input type="text" id="editCategoryName" name="categoryName" required>
                </div>
                
                <div class="form-group">
                    <label for="editCategoryImage">Category Image</label>
                    <input type="file" id="editCategoryImage" name="image" accept="image/*">
                    <div class="current-image" id="currentImage">
                        <!-- Current image will be shown here -->
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-outline" onclick="closeModal('editCategoryModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Category Modal -->
<div id="viewCategoryModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Category Details</h3>
            <button class="modal-close" onclick="closeModal('viewCategoryModal')">&times;</button>
        </div>
        <div class="modal-body" id="categoryDetails">
            <!-- Category details will be loaded here -->
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteCategoryModal" class="modal">
    <div class="modal-content small">
        <div class="modal-header">
            <h3>Delete Category</h3>
            <button class="modal-close" onclick="closeModal('deleteCategoryModal')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="delete-warning">
                <div class="warning-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="warning-content">
                    <h4>Are you sure?</h4>
                    <p>This will permanently delete the category "<span id="deleteCategoryName"></span>" and all its associated data.</p>
                    <p><strong>This action cannot be undone!</strong></p>
                </div>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-outline" onclick="closeModal('deleteCategoryModal')">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                    <i class="fas fa-trash"></i>
                    Yes, Delete Category
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Alert Messages */
    .alert {
        padding: 1rem 1.25rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 500;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        color: #065f46;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.1);
        color: #991b1b;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    /* Page Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2rem;
        gap: 2rem;
    }

    .header-content h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--gray-800);
        margin: 0 0 0.5rem 0;
    }

    .page-subtitle {
        color: var(--gray-600);
        font-size: 1rem;
        margin: 0;
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
        flex-shrink: 0;
    }

    /* Stats Cards */
    .stats-row {
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--white);
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: var(--shadow);
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-2px);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }

    .stat-icon.total { background: var(--primary-color); }
    .stat-icon.active { background: var(--success-color); }
    .stat-icon.products { background: var(--warning-color); }
    .stat-icon.popular { background: #8b5cf6; }

    .stat-info h3 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--gray-800);
        margin: 0 0 0.25rem 0;
    }

    .stat-info p {
        font-size: 0.875rem;
        color: var(--gray-600);
        margin: 0;
    }

    /* Filters Section */
    .filters-section {
        margin-bottom: 1.5rem;
    }

    .filters-content {
        padding: 1.5rem;
        display: flex;
        gap: 1.5rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .search-box {
        position: relative;
        flex: 1;
        min-width: 300px;
    }

    .search-box i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-400);
    }

    .search-box input {
        width: 100%;
        padding: 10px 16px 10px 40px;
        border: 1px solid var(--gray-300);
        border-radius: 6px;
        font-size: 0.875rem;
        outline: none;
        transition: all 0.2s ease;
    }

    .search-box input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .filter-controls {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .filter-controls select {
        padding: 8px 12px;
        border: 1px solid var(--gray-300);
        border-radius: 6px;
        font-size: 0.875rem;
        background: var(--white);
        color: var(--gray-700);
        min-width: 150px;
    }

    /* Table Section */
    .table-section {
        overflow: hidden;
    }

    .table-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-header h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--gray-800);
        margin: 0;
    }

    .table-info span {
        font-size: 0.875rem;
        color: var(--gray-600);
    }

    .table-container {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th {
        padding: 1rem;
        text-align: left;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray-600);
        background: var(--gray-50);
        border-bottom: 2px solid var(--gray-200);
        white-space: nowrap;
    }

    .data-table td {
        padding: 1rem;
        border-bottom: 1px solid var(--gray-100);
        font-size: 0.875rem;
        color: var(--gray-700);
        vertical-align: middle;
    }

    .data-table tbody tr:hover {
        background: var(--gray-50);
    }

    /* Category Image */
    .category-image {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .category-thumb {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid var(--gray-200);
    }

    /* Category Info */
    .category-info {
        display: flex;
        flex-direction: column;
    }

    .category-name {
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: 0.25rem;
    }

    .category-id {
        font-size: 0.75rem;
        color: var(--gray-500);
    }

    /* Product Count */
    .product-count {
        font-weight: 600;
        color: var(--primary-color);
        background: rgba(59, 130, 246, 0.1);
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.8125rem;
    }

    /* Status Badges */
    .status-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-badge.active {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }

    .status-badge.inactive {
        background: rgba(107, 114, 128, 0.1);
        color: var(--gray-600);
    }

    /* Dropdown Actions */
    .dropdown-container {
        position: relative;
        display: inline-block;
    }

    .dropdown-toggle {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        padding: 8px 10px;
        cursor: pointer;
        color: #6c757d;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .dropdown-toggle:hover {
        background: #e9ecef;
        color: #495057;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        min-width: 120px;
        z-index: 1000;
        display: none;
        padding: 4px 0;
    }

    .dropdown-menu.show {
        display: block;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 8px;
        width: 100%;
        padding: 8px 12px;
        background: none;
        border: none;
        color: #495057;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: left;
    }

    .dropdown-item:hover {
        background: #f8f9fa;
        color: #667eea;
    }

    .dropdown-item.danger {
        color: #dc3545;
    }

    .dropdown-item.danger:hover {
        background: #f8d7da;
        color: #721c24;
    }

    .dropdown-item i {
        width: 14px;
        text-align: center;
    }

    /* Modal Styles */
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
        background: var(--white);
        border-radius: 8px;
        box-shadow: var(--shadow-lg);
        max-width: 600px;
        width: 90%;
        max-height: 80vh;
        overflow-y: auto;
    }

    .modal-content.small {
        max-width: 400px;
    }

    .modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--gray-800);
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: var(--gray-400);
        cursor: pointer;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
    }

    .modal-close:hover {
        background: var(--gray-100);
        color: var(--gray-600);
    }

    .modal-body {
        padding: 1.5rem;
    }

    /* Form Styles */
    .category-form {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-group label {
        font-weight: 600;
        color: var(--gray-700);
        font-size: 0.875rem;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        padding: 0.75rem;
        border: 1px solid var(--gray-300);
        border-radius: 6px;
        font-size: 0.875rem;
        outline: none;
        transition: all 0.2s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-group small {
        font-size: 0.75rem;
        color: var(--gray-500);
    }

    .form-actions {
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
        padding-top: 1rem;
        border-top: 1px solid var(--gray-200);
    }

    /* Delete Warning */
    .delete-warning {
        display: flex;
        gap: 1rem;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }

    .warning-icon {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .warning-content h4 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray-800);
        margin: 0 0 0.5rem 0;
    }

    .warning-content p {
        font-size: 0.875rem;
        color: var(--gray-600);
        margin: 0 0 0.5rem 0;
    }

    /* Button Styles */
    .btn-outline {
        background: transparent;
        border: 1px solid var(--gray-300);
        color: var(--gray-700);
    }

    .btn-outline:hover {
        background: var(--gray-50);
    }

    .btn-secondary {
        background: var(--gray-600);
        color: white;
    }

    .btn-secondary:hover {
        background: var(--gray-700);
    }

    .btn-danger {
        background: var(--danger-color);
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--gray-600);
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        background: var(--gray-100);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: var(--gray-400);
    }

    .empty-state h4 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        font-size: 1rem;
        margin-bottom: 1.5rem;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Category Details */
    .category-detail-grid {
        margin-bottom: 2rem;
    }

    .detail-section h4 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray-800);
        margin: 0 0 1rem 0;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid var(--gray-200);
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--gray-100);
    }

    .detail-item:last-child {
        border-bottom: none;
    }

    .detail-item label {
        font-weight: 500;
        color: var(--gray-600);
        min-width: 120px;
    }

    .detail-item span {
        color: var(--gray-800);
        text-align: right;
    }

    .modal-actions {
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
        padding-top: 1rem;
        border-top: 1px solid var(--gray-200);
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .page-header {
            flex-direction: column;
            align-items: stretch;
        }

        .stats-row {
            grid-template-columns: repeat(2, 1fr);
        }

        .filters-content {
            flex-direction: column;
            align-items: stretch;
        }

        .search-box {
            min-width: auto;
        }
    }

    @media (max-width: 768px) {
        .stats-row {
            grid-template-columns: 1fr;
        }

        .table-header {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .action-buttons {
            flex-wrap: wrap;
        }

        .modal-content {
            width: 95%;
            margin: 1rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .delete-warning {
            flex-direction: column;
            text-align: center;
        }

        .detail-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }

        .detail-item label {
            min-width: auto;
        }

        .detail-item span {
            text-align: left;
        }

        .modal-actions {
            flex-direction: column;
        }
    }
</style>
@endsection
@section('scripts')
<script>
    // Dropdown functionality
    function toggleDropdown(categoryId) {
        // Close all other dropdowns
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            if (menu.id !== `dropdown-${categoryId}`) {
                menu.classList.remove('show');
            }
        });
        
        // Toggle current dropdown
        const dropdown = document.getElementById(`dropdown-${categoryId}`);
        dropdown.classList.toggle('show');
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown-container')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('show');
            });
        }
    });

    // Categories data from Laravel
    const categories = @json($categories);
    let currentCategoryId = null;

    // Wait for page to load
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Categories page loaded with', categories.length, 'categories');
        
        // Setup search functionality
        setupSearch();
        
        // Setup form submissions
        setupForms();
        
        // Auto-hide alerts
        hideAlertsAfterDelay();
    });

    // SEARCH AND FILTER FUNCTIONS
    function setupSearch() {
        const searchInput = document.getElementById('categorySearch');
        const statusFilter = document.getElementById('statusFilter');
        
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                filterTable();
            });
        }
        
        if (statusFilter) {
            statusFilter.addEventListener('change', function() {
                filterTable();
            });
        }
    }

    function filterTable() {
        const searchTerm = document.getElementById('categorySearch').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
        const rows = document.querySelectorAll('#categoriesTable tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const statusBadge = row.querySelector('.status-badge');
            const status = statusBadge ? statusBadge.textContent.toLowerCase() : '';
            
            let showRow = true;
            
            // Search filter
            if (searchTerm && !text.includes(searchTerm)) {
                showRow = false;
            }
            
            // Status filter
            if (statusFilter && !status.includes(statusFilter)) {
                showRow = false;
            }
            
            row.style.display = showRow ? '' : 'none';
        });
    }

    function resetFilters() {
        document.getElementById('categorySearch').value = '';
        document.getElementById('statusFilter').value = '';
        filterTable();
    }

    // MODAL FUNCTIONS
    function showAddForm() {
        const modal = document.getElementById('addCategoryModal');
        const form = document.getElementById('addCategoryForm');
        
        if (form) {
            form.reset();
        }
        
        if (modal) {
            modal.style.display = 'block';
        }
    }

    function viewCategory(id) {
        const category = categories.find(c => c.id == id);
        if (!category) {
            alert('Category not found!');
            return;
        }
        
        const detailsHtml = `
            <div class="category-detail-grid">
                <div class="detail-section">
                    <h4>Category Information</h4>
                    <div class="detail-item">
                        <label>Category Name:</label>
                        <span>${category.categoryName}</span>
                    </div>
                    <div class="detail-item">
                        <label>Category ID:</label>
                        <span>#CAT${String(category.id).padStart(3, '0')}</span>
                    </div>
                    <div class="detail-item">
                        <label>Products Count:</label>
                        <span>${category.products_count || 0}</span>
                    </div>
                    <div class="detail-item">
                        <label>Status:</label>
                        <span class="status-badge active">Active</span>
                    </div>
                    <div class="detail-item">
                        <label>Created Date:</label>
                        <span>${new Date(category.created_at).toLocaleDateString()}</span>
                    </div>
                    ${category.image ? `
                    <div class="detail-item">
                        <label>Category Image:</label>
                        <img src="/uploads/${category.image}" alt="${category.categoryName}" style="max-width: 100px; border-radius: 6px;">
                    </div>
                    ` : ''}
                </div>
            </div>
            <div class="modal-actions">
                <button class="btn btn-primary" onclick="editCategory(${id})">Edit Category</button>
                <button class="btn btn-outline" onclick="closeModal('viewCategoryModal')">Close</button>
            </div>
        `;
        
        document.getElementById('categoryDetails').innerHTML = detailsHtml;
        document.getElementById('viewCategoryModal').style.display = 'block';
    }

    function editCategory(id) {
        const category = categories.find(c => c.id == id);
        if (!category) {
            alert('Category not found!');
            return;
        }
        
        currentCategoryId = id;
        
        // Close view modal if open
        closeModal('viewCategoryModal');
        
        // Fill form with current data
        document.getElementById('editCategoryName').value = category.categoryName;
        
        // Show current image
        const currentImageDiv = document.getElementById('currentImage');
        if (category.image) {
            currentImageDiv.innerHTML = `<img src="/uploads/${category.image}" alt="${category.categoryName}" style="max-width: 100px; margin-top: 10px; border-radius: 6px;">`;
        } else {
            currentImageDiv.innerHTML = '<p style="color: #6b7280; font-size: 0.875rem; margin-top: 10px;">No image uploaded</p>';
        }
        
        // Set form action
        const form = document.getElementById('editCategoryForm');
        form.action = `/category/update/${id}`;
        
        // Show modal
        document.getElementById('editCategoryModal').style.display = 'block';
    }

    function deleteCategory(id) {
        const category = categories.find(c => c.id == id);
        if (!category) {
            alert('Category not found!');
            return;
        }
        
        currentCategoryId = id;
        document.getElementById('deleteCategoryName').textContent = category.categoryName;
        document.getElementById('deleteCategoryModal').style.display = 'block';
    }

    function confirmDelete() {
        if (!currentCategoryId) return;
        
        // Create and submit delete form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/category/delete/${currentCategoryId}`;
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.appendChild(csrfToken);
        
        // Add method override
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);
        
        // Submit form
        document.body.appendChild(form);
        form.submit();
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
        }
        currentCategoryId = null;
    }

    // FORM SETUP
    function setupForms() {
        // Add form submission
        const addForm = document.getElementById('addCategoryForm');
        if (addForm) {
            addForm.addEventListener('submit', function(e) {
                // Let the form submit normally to Laravel
                showLoadingMessage('Adding category...');
            });
        }
        
        // Edit form submission
        const editForm = document.getElementById('editCategoryForm');
        if (editForm) {
            editForm.addEventListener('submit', function(e) {
                // Let the form submit normally to Laravel
                showLoadingMessage('Updating category...');
            });
        }
    }

    // UTILITY FUNCTIONS
    function exportCategories() {
        if (categories.length === 0) {
            alert('No categories to export!');
            return;
        }
        
        const csvContent = "data:text/csv;charset=utf-8," 
            + "Category Name,Products Count,Created Date\n"
            + categories.map(cat => 
                `"${cat.categoryName}","${cat.products_count || 0}","${new Date(cat.created_at).toLocaleDateString()}"`
            ).join("\n");
        
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "categories_export.csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        showSuccessMessage('Categories exported successfully!');
    }

    function showSuccessMessage(message) {
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #10b981;
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 9999;
            font-weight: 500;
        `;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 3000);
    }

    function showLoadingMessage(message) {
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #3b82f6;
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 9999;
            font-weight: 500;
        `;
        notification.textContent = message;
        document.body.appendChild(notification);
    }

    function hideAlertsAfterDelay() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 300);
            }, 5000);
        });
    }

    // Close modals when clicking outside
    window.addEventListener('click', function(e) {
        const modals = ['addCategoryModal', 'editCategoryModal', 'viewCategoryModal', 'deleteCategoryModal'];
        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (modal && e.target === modal) {
                closeModal(modalId);
            }
        });
    });

    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modals = ['addCategoryModal', 'editCategoryModal', 'viewCategoryModal', 'deleteCategoryModal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (modal && modal.style.display === 'block') {
                    closeModal(modalId);
                }
            });
        }
    });
</script>
@endsection