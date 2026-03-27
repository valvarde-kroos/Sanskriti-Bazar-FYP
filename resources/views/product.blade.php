@extends('layout.main')

@section('content')

<h2>Add New Instrument</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="name" placeholder="Instrument Name"><br><br>
    <textarea name="description" placeholder="Description"></textarea><br><br>
    <input type="number" name="price" placeholder="Price"><br><br>

    <select name="category_id">
        <option>Select Category</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select><br><br>

    <input type="file" name="image"><br><br>

    <button>Add Product</button>
</form>

@endsection
