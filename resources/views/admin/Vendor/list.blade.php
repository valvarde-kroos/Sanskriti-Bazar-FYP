@extends('admin.layout.main')

@section('container')

<div class="page-header">
    <h2>Vendor List</h2>
</div>

<div class="table-wrapper">
<table class="category-table">

    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Registered Date</th>
        </tr>
    </thead>

    <tbody>

        @foreach($vendors as $vendor)

        <tr>
            <td>{{ $vendor->id }}</td>
            <td>{{ $vendor->name }}</td>
            <td>{{ $vendor->email }}</td>
            <td>{{ $vendor->phone ?? 'N/A' }}</td>
            <td>{{ $vendor->created_at->format('d M Y') }}</td>
        </tr>

        @endforeach

    </tbody>

</table>
</div>

@endsection
