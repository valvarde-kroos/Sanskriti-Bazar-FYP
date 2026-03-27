@extends('admin.layout.main')

@section('container')

<div class="page-header">
    <h2>Edit Category</h2>
</div>

<div class="table-wrapper">

    <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <table class="category-table">
            <tr>
                <td>Category Name</td>
                <td>
                    <input type="text" name="categoryName"
                        value="{{ $category->categoryName }}"
                        style="width:100%; padding:8px;">
                </td>
            </tr>

            <tr>
                <td>Current Image</td>
                <td>
                    @if($category->image)
                        <img src="{{ asset('uploads/'.$category->image) }}" class="cat-img">
                    @else
                        <span class="no-img">No Image</span>
                    @endif
                </td>
            </tr>

            <tr>
                <td>Change Image</td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <button type="submit" class="btn-edit">Update Category</button>
                    <a href="{{ route('category.index') }}" class="btn-delete">Cancel</a>
                </td>
            </tr>

        </table>
    </form>

</div>

@endsection
