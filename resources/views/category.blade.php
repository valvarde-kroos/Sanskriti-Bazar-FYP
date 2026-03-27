@extends('layout.main')

@section('hyasabicontentauncha')
<div class="category-page">

    <div class="category-form-card">
        <h2>Add Category</h2>

        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <input type="text" name="categoryName" placeholder="Category Name" required>
                @error('categoryName')
                    <p style="color:red;">{{ $message }}</p>
                @enderror

                <input type="file" name="image">
                @error('image')
                    <p style="color:red;">{{ $message }}</p>
                @enderror

                <button type="submit">Add Category</button>
            </div>
        </form>
    </div>

    <h2 class="category-title">Category List</h2>
    <div class="category-grid">
        @foreach($categories as $category)
            <div class="category-card">
                @if($category->image)
                    <img src="{{ asset('uploads/' . $category->image) }}" alt="category">
                @else
                    <img src="{{ asset('uploads/default-category.png') }}" alt="category">
                @endif

                <div class="category-info">
                    <h3>{{ $category->categoryName }}</h3>

                    <!-- Edit Button -->
                    <a href="{{ route('category.edit', $category->id) }}" class="edit-btn">Edit</a>

                    <!-- Delete Button -->
                    <form action="{{ route('category.delete', $category->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
