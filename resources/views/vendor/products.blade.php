@extends('vendor.layout.main')

@section('title', 'Products')

@section('content')
<div class="page-header">
    <div>
        <h1>Manage Products</h1>
        <p>View and manage all your products</p>
    </div>
    <button class="btn btn-add" onclick="openAddModal()">Add Product</button>
</div>

@if(session('success'))
<div class="alert alert-success" id="successAlert">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-error">
    {{ session('error') }}
</div>
@endif

<div class="table-container">
    <table class="products-table" id="productsTable">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Image</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr id="product-{{ $product->id }}">
                <td>{{ $product->id }}</td>
                <td>
                    @if($product->image)
                        <img src="{{ asset('uploads/' . $product->image) }}" alt="{{ $product->post_title }}" class="product-image">
                    @else
                        <div class="no-image">No Image</div>
                    @endif
                </td>
                <td>{{ $product->post_title }}</td>
                <td>{{ $product->category->categoryName ?? 'N/A' }}</td>
                <td>Rs. {{ number_format($product->price, 2) }}</td>
                <td>{{ $product->quantity }}</td>
                <td>
                    <button class="action-btn edit-btn" onclick="openEditModal({{ $product->id }})">Edit</button>
                    <button class="action-btn delete-btn" onclick="confirmDelete({{ $product->id }})">Delete</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="no-data">No products found. Click "Add Product" to add your first product.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Add Product Modal -->
<div id="addProductModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Add New Product</h2>
            <span class="close" onclick="closeAddModal()">&times;</span>
        </div>
        <form action="{{ route('vendor.product.store') }}" method="POST" enctype="multipart/form-data" id="addProductForm">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="add_post_title">Product Name <span class="required">*</span></label>
                    <input type="text" id="add_post_title" name="post_title" class="form-control" 
                           placeholder="Enter product name" required>
                </div>

                <div class="form-group">
                    <label for="add_category_id">Category <span class="required">*</span></label>
                    <select id="add_category_id" name="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->categoryName }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="add_price">Price (Rs.) <span class="required">*</span></label>
                        <input type="number" id="add_price" name="price" class="form-control" 
                               placeholder="Enter price" min="0" step="0.01" required>
                    </div>

                    <div class="form-group">
                        <label for="add_quantity">Quantity <span class="required">*</span></label>
                        <input type="number" id="add_quantity" name="quantity" class="form-control" 
                               placeholder="Enter quantity" min="0" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="add_post_description">Description <span class="required">*</span></label>
                    <textarea id="add_post_description" name="post_description" class="form-control" 
                              rows="4" placeholder="Enter product description" required></textarea>
                </div>

                <div class="form-group">
                    <label for="add_image">Product Image</label>
                    <input type="file" id="add_image" name="image" class="form-control" accept="image/*" onchange="previewAddImage(event)">
                    <small class="form-text">Maximum file size: 2MB</small>
                    <div id="addImagePreview" class="image-preview"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" onclick="closeAddModal()">Cancel</button>
                <button type="submit" class="btn btn-submit">Add Product</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Product Modal -->
<div id="editProductModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Product</h2>
            <span class="close" onclick="closeEditModal()">&times;</span>
        </div>
        <form id="editProductForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <input type="hidden" id="edit_product_id" name="product_id">
                
                <div class="form-group">
                    <label for="edit_post_title">Product Name <span class="required">*</span></label>
                    <input type="text" id="edit_post_title" name="post_title" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="edit_category_id">Category <span class="required">*</span></label>
                    <select id="edit_category_id" name="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->categoryName }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_price">Price (Rs.) <span class="required">*</span></label>
                        <input type="number" id="edit_price" name="price" class="form-control" 
                               min="0" step="0.01" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_quantity">Quantity <span class="required">*</span></label>
                        <input type="number" id="edit_quantity" name="quantity" class="form-control" 
                               min="0" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_post_description">Description <span class="required">*</span></label>
                    <textarea id="edit_post_description" name="post_description" class="form-control" 
                              rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label for="edit_image">Product Image</label>
                    <div id="currentImageContainer" class="current-image-container" style="margin-bottom: 10px;"></div>
                    <input type="file" id="edit_image" name="image" class="form-control" accept="image/*" onchange="previewEditImage(event)">
                    <small class="form-text">Leave empty to keep current image</small>
                    <div id="editImagePreview" class="image-preview"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="btn btn-submit">Update Product</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content modal-small">
        <div class="modal-header">
            <h2>Confirm Delete</h2>
            <span class="close" onclick="closeDeleteModal()">&times;</span>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this product? This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-cancel" onclick="closeDeleteModal()">Cancel</button>
            <form id="deleteForm" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-delete">Delete</button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .page-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .page-header p {
        font-size: 14px;
        color: #7f8c8d;
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-add {
        background: #3498db;
        color: #fff;
    }

    .btn-add:hover {
        background: #2980b9;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 6px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #6ee7b7;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }

    .table-container {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .products-table {
        width: 100%;
        border-collapse: collapse;
    }

    .products-table thead {
        background: #f8f9fa;
    }

    .products-table th {
        padding: 15px;
        text-align: left;
        font-size: 13px;
        font-weight: 600;
        color: #7f8c8d;
        text-transform: uppercase;
        border-bottom: 2px solid #e0e0e0;
    }

    .products-table td {
        padding: 15px;
        border-bottom: 1px solid #f1f3f5;
        font-size: 14px;
        color: #2c3e50;
    }

    .products-table tbody tr:hover {
        background: #f8f9fa;
    }

    .product-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
        border: 2px solid #e0e0e0;
    }

    .no-image {
        width: 60px;
        height: 60px;
        background: #f8f9fa;
        border: 2px dashed #ddd;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        color: #7f8c8d;
        text-align: center;
    }

    .no-data {
        text-align: center;
        color: #7f8c8d;
        padding: 40px !important;
    }

    .action-btn {
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        margin-right: 5px;
        transition: all 0.3s;
    }

    .edit-btn {
        background: #3498db;
        color: #fff;
    }

    .edit-btn:hover {
        background: #2980b9;
    }

    .delete-btn {
        background: #e74c3c;
        color: #fff;
    }

    .delete-btn:hover {
        background: #c0392b;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 2000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        overflow-y: auto;
    }

    .modal-content {
        background: #fff;
        margin: 50px auto;
        width: 90%;
        max-width: 600px;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .modal-small {
        max-width: 400px;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        border-bottom: 1px solid #e0e0e0;
    }

    .modal-header h2 {
        font-size: 20px;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
    }

    .close {
        font-size: 28px;
        font-weight: 700;
        color: #95a5a6;
        cursor: pointer;
        line-height: 1;
    }

    .close:hover {
        color: #2c3e50;
    }

    .modal-body {
        padding: 25px;
    }

    .modal-footer {
        padding: 20px 25px;
        border-top: 1px solid #e0e0e0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
    }

    .required {
        color: #e74c3c;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        color: #2c3e50;
        outline: none;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        border-color: #3498db;
    }

    textarea.form-control {
        resize: vertical;
        font-family: inherit;
    }

    .form-text {
        font-size: 12px;
        color: #7f8c8d;
        margin-top: 5px;
        display: block;
    }

    .current-image-container img {
        max-width: 100px;
        max-height: 100px;
        border-radius: 6px;
        border: 2px solid #ddd;
    }

    .image-preview {
        margin-top: 10px;
        display: none;
    }

    .image-preview img {
        max-width: 100px;
        max-height: 100px;
        border-radius: 6px;
        border: 2px solid #ddd;
    }

    .btn-submit {
        background: #27ae60;
        color: #fff;
    }

    .btn-submit:hover {
        background: #229954;
    }

    .btn-cancel {
        background: #95a5a6;
        color: #fff;
    }

    .btn-cancel:hover {
        background: #7f8c8d;
    }

    .btn-delete {
        background: #e74c3c;
        color: #fff;
    }

    .btn-delete:hover {
        background: #c0392b;
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .btn-add {
            width: 100%;
        }

        .table-container {
            overflow-x: auto;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .modal-content {
            width: 95%;
            margin: 20px auto;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    // Product data for editing
    const products = @json($products);

    // Add Product Modal
    function openAddModal() {
        document.getElementById('addProductModal').style.display = 'block';
    }

    function closeAddModal() {
        document.getElementById('addProductModal').style.display = 'none';
        document.getElementById('addProductForm').reset();
        document.getElementById('addImagePreview').innerHTML = '';
        document.getElementById('addImagePreview').style.display = 'none';
    }

    // Image preview for add modal
    function previewAddImage(event) {
        const preview = document.getElementById('addImagePreview');
        const file = event.target.files[0];
        
        if (file) {
            // Check file size (2MB = 2097152 bytes)
            if (file.size > 2097152) {
                alert('File size must be less than 2MB');
                event.target.value = '';
                preview.style.display = 'none';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `
                    <label style="font-size: 12px; color: #7f8c8d; margin-bottom: 5px; display: block;">Image Preview:</label>
                    <img src="${e.target.result}" alt="Preview">
                `;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = '';
            preview.style.display = 'none';
        }
    }

    // Edit Product Modal
    function openEditModal(productId) {
        const product = products.find(p => p.id === productId);
        if (!product) return;

        document.getElementById('edit_product_id').value = product.id;
        document.getElementById('edit_post_title').value = product.post_title;
        document.getElementById('edit_category_id').value = product.category_id;
        document.getElementById('edit_price').value = product.price;
        document.getElementById('edit_quantity').value = product.quantity;
        document.getElementById('edit_post_description').value = product.post_description;

        // Show current image if exists
        const currentImageContainer = document.getElementById('currentImageContainer');
        if (product.image) {
            currentImageContainer.innerHTML = `
                <div style="margin-bottom: 10px;">
                    <label style="font-size: 12px; color: #7f8c8d; margin-bottom: 5px; display: block;">Current Image:</label>
                    <img src="/uploads/${product.image}" alt="Current Image" style="max-width: 100px; max-height: 100px; border-radius: 6px; border: 2px solid #ddd;">
                </div>
            `;
        } else {
            currentImageContainer.innerHTML = '';
        }

        // Clear preview
        document.getElementById('editImagePreview').innerHTML = '';
        document.getElementById('editImagePreview').style.display = 'none';

        const form = document.getElementById('editProductForm');
        form.action = `/vendor/product/${productId}/update`;

        document.getElementById('editProductModal').style.display = 'block';
    }

    function closeEditModal() {
        document.getElementById('editProductModal').style.display = 'none';
        document.getElementById('editProductForm').reset();
        document.getElementById('currentImageContainer').innerHTML = '';
        document.getElementById('editImagePreview').innerHTML = '';
        document.getElementById('editImagePreview').style.display = 'none';
    }

    // Image preview for edit modal
    function previewEditImage(event) {
        const preview = document.getElementById('editImagePreview');
        const file = event.target.files[0];
        
        if (file) {
            // Check file size (2MB = 2097152 bytes)
            if (file.size > 2097152) {
                alert('File size must be less than 2MB');
                event.target.value = '';
                preview.style.display = 'none';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `
                    <label style="font-size: 12px; color: #7f8c8d; margin-bottom: 5px; display: block;">New Image Preview:</label>
                    <img src="${e.target.result}" alt="Preview">
                `;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = '';
            preview.style.display = 'none';
        }
    }

    // Delete Product Modal
    function confirmDelete(productId) {
        const form = document.getElementById('deleteForm');
        form.action = `/vendor/product/${productId}/delete`;
        document.getElementById('deleteModal').style.display = 'block';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    // Close modals when clicking outside
    window.onclick = function(event) {
        const addModal = document.getElementById('addProductModal');
        const editModal = document.getElementById('editProductModal');
        const deleteModal = document.getElementById('deleteModal');

        if (event.target === addModal) {
            closeAddModal();
        }
        if (event.target === editModal) {
            closeEditModal();
        }
        if (event.target === deleteModal) {
            closeDeleteModal();
        }
    }

    // Auto-hide success alert
    document.addEventListener('DOMContentLoaded', function() {
        const successAlert = document.getElementById('successAlert');
        if (successAlert) {
            setTimeout(function() {
                successAlert.style.display = 'none';
            }, 3000);
        }
    });
</script>
@endsection
