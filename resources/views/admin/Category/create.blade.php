@extends('admin.layout.main')

@section('container')

<div class="page-header">
    <h2>Add Category</h2>
    <a href="{{ route('category.index') }}" class="btn-delete">Back</a>
</div>

<div class="table-wrapper">

<form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <table class="category-table">

        <tr>
            <td>Category Name</td>
            <td>
                <input type="text" name="categoryName"
                       placeholder="Enter category name"
                       style="width:100%; padding:8px;">
            </td>
        </tr>

        <tr>
            <td>Category Image</td>
            <td>
                <input type="file" name="image">
            </td>
        </tr>

        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn-add">Save Category</button>
            </td>
        </tr>

    </table>

</form>

</div>

@endsection
