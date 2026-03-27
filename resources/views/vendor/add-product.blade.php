@extends('vendor.layout.main')

@section('title', 'Add Product')

@section('content')
<div class="page-header">
    <h1>Add New Product</h1>
    <p>Fill in the details below to add a new product to your store</p>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-error">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="form-container">
    <form action="{{ route('vendor.product.store') }}" method="POST" enctype="multipart/form-data" id="addProductForm">
        @csrf
        
        <div class="form-row">
            <div class="form-group">
                <label for="post_title">Product Name <span class="required">*</span></label>
                <input type="text" id="post_title" name="post_title" class="form-control" 
                       placeholder="Enter product name" value="{{ old('post_title') }}" required>
            </div>

            <div class="form-group">
                <label for="category_id">Category <span class="required">*</span></label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->categoryName }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="price">Price (Rs.) <span class="required">*</span></label>
                <input type="number" id="price" name="price" class="form-control" 
                       placeholder="Enter price" value="{{ old('price') }}" min="0" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity <span class="required">*</span></label>
                <input type="number" id="quantity" name="quantity" class="form-control" 
                       placeholder="Enter quantity" value="{{ old('quantity') }}" min="0" required>
            </div>
        </div>

        <div class="form-group full-width">
            <label for="post_description">Description <span class="required">*</span></label>
            <textarea id="post_description" name="post_description" class="form-control" 
                      rows="5" placeholder="Enter product description" required>{{ old('post_description') }}</textarea>
        </div>

        <div class="form-group full-width">
            <label for="image">Product Image</label>
            <input type="file" id="image" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
            <small class="form-text">Maximum file size: 2MB. Supported formats: JPG, PNG, GIF</small>
            <div id="imagePreview" class="image-preview"></div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-submit">Add Product</button>
            <button type="reset" class="btn btn-reset" onclick="clearPreview()">Clear Form</button>
        </div>
    </form>
</div>

<!-- Sample Products Section -->
<div class="sample-section">
    <h2>Sample Products</h2>
    <div class="sample-grid">
        <div class="sample-card">
            <div class="sample-name">Madal</div>
            <div class="sample-category">Percussion</div>
            <div class="sample-price">Rs. 5,000</div>
        </div>
        <div class="sample-card">
            <div class="sample-name">Sarangi</div>
            <div class="sample-category">String</div>
            <div class="sample-price">Rs. 8,500</div>
        </div>
        <div class="sample-card">
            <div class="sample-name">Bansuri</div>
            <div class="sample-category">Wind</div>
            <div class="sample-price">Rs. 3,000</div>
        </div>
        <div class="sample-card">
            <div class="sample-name">Damphu</div>
            <div class="sample-category">Folk</div>
            <div class="sample-price">Rs. 4,500</div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .page-header {
        margin-bottom: 30px;
    }

    .page-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 8px;
    }

    .page-header p {
        font-size: 14px;
        color: #7f8c8d;
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

    .alert ul {
        margin: 0;
        padding-left: 20px;
    }

    .form-container {
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full-width {
        margin-bottom: 20px;
    }

    .form-group label {
        font-size: 14px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
    }

    .required {
        color: #e74c3c;
    }

    .form-control {
        padding: 12px 15px;
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

    .image-preview {
        margin-top: 15px;
        display: none;
    }

    .image-preview img {
        max-width: 200px;
        max-height: 200px;
        border-radius: 6px;
        border: 2px solid #ddd;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 30px;
    }

    .btn {
        padding: 12px 30px;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-submit {
        background: #27ae60;
        color: #fff;
    }

    .btn-submit:hover {
        background: #229954;
    }

    .btn-reset {
        background: #95a5a6;
        color: #fff;
    }

    .btn-reset:hover {
        background: #7f8c8d;
    }

    .sample-section {
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .sample-section h2 {
        font-size: 20px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 20px;
    }

    .sample-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .sample-card {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 6px;
        border: 1px solid #e0e0e0;
    }

    .sample-name {
        font-size: 16px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .sample-category {
        font-size: 13px;
        color: #7f8c8d;
        margin-bottom: 8px;
    }

    .sample-price {
        font-size: 15px;
        font-weight: 700;
        color: #27ae60;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    function previewImage(event) {
        const preview = document.getElementById('imagePreview');
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
                preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview">';
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    }

    function clearPreview() {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        preview.style.display = 'none';
    }

    // Show success message and hide after 3 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const successAlert = document.querySelector('.alert-success');
        if (successAlert) {
            setTimeout(function() {
                successAlert.style.display = 'none';
            }, 3000);
        }
    });
</script>
@endsection
