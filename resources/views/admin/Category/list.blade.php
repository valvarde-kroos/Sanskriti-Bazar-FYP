@extends('admin.layout.main')

@section('container')

<div class="page-header">
    <h2>Category List</h2>
    <a href="{{route('category.create')}}" class="btn-add">+ Add Category</a>
</div>

<div class="table-wrapper">
    <table class="category-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Category Name</th>
                <th>Created At</th>
                <th width="180">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>

                <td>
                    @if($category->image)
                        <img src="{{ asset('uploads/'.$category->image) }}" class="cat-img">
                    @else
                        <span class="no-img">No Image</span>
                    @endif
                </td>

                <td>{{ $category->categoryName }}</td>

                <td>{{ $category->created_at->format('d M Y') }}</td>

                <td>
                    <a href="{{ route('category.edit',$category->id) }}" class="btn-edit">
                        Edit
                    </a>

                    <form action="{{ route('category.delete',$category->id) }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete"
                            onclick="return confirm('Are you sure?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
