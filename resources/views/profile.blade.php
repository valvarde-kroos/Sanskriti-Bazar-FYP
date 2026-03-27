@extends('layout.main')

@section('hyasabicontentauncha')
<div class="profile-wrapper">
    <div class="profile-card">
        <div class="profile-avatar">
            <img src="{{ asset('uploads/default-avatar.png') }}" alt="Profile">
        </div>

        <h3 class="profile-name">{{ $user->name }}</h3>
        <p class="profile-email">{{ $user->email }}</p>
        <p class="profile-posts">Total Products: <strong>{{ $products->count() }}</strong></p>
    </div>
</div>

<h2 class="category-title">Add New Product</h2>

@if(session('success'))
    <p style="color: green; padding-bottom: 10px;">{{ session('success') }}</p>
@endif

<form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" class="product-form">
    @csrf
    <div class="form-row">
        <input type="text" name="post_title" placeholder="Product Title" required>
        @error('post_title')
            <p style="color:red;">{{ $message }}</p>
        @enderror

        <textarea name="post_description" placeholder="Product Description" required></textarea>
        @error('post_description')
            <p style="color:red;">{{ $message }}</p>
        @enderror

        <select name="category_id" required>
            <option value="">Select Category</option>
            @foreach(\App\Models\Category::all() as $category)
                <option value="{{ $category->id }}">{{ $category->categoryName }}</option>
            @endforeach
        </select>
        @error('category_id')
            <p style="color:red;">{{ $message }}</p>
        @enderror

        <input type="file" name="image">
        @error('image')
            <p style="color:red;">{{ $message }}</p>
        @enderror

        <button type="submit">Add Product</button>
    </div>
</form>

<h2 class="category-title">My Products</h2>

@if($products->isEmpty())
    <p style="text-align:center;">You haven’t added any products yet.</p>
@else
<div class="my-post-grid">
    @foreach($products as $product)
        <div class="post-card">
            <img src="{{ asset('uploads/' . ($product->image ?? 'default-category.png')) }}" alt="product">

            <div class="post-info">
                <h3>{{ $product->post_title }}</h3>
                <p class="post-desc">{{ $product->post_description }}</p>
                <p class="post-meta">
                    <span class="category">{{ $product->category->categoryName ?? 'No Category' }}</span>
                    <span class="date">{{ $product->created_at->format('d M Y') }}</span>
                </p>
            </div>

            <div class="post-actions">
                <a href="{{ route('product.delete', $product->id) }}" class="delete-btn">Delete</a>
            </div>
        </div>
    @endforeach
</div>
@endif
@endsection
