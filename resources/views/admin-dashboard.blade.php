@extends('layout.main')

@section('hyasabicontentauncha')
<div class="container">
    <h1>Admin Dashboard</h1>
    <p>Welcome, {{ auth()->user()->name }}!</p>
    
    <div class="admin-actions">
        <div class="action-card">
            <h3>Manage Categories</h3>
            <p>Add, edit, or delete product categories</p>
            <a href="{{ route('category.index') }}" class="btn">Go to Categories</a>
        </div>
        
        <div class="action-card">
            <h3>View All Products</h3>
            <p>See all products from vendors</p>
            <a href="{{ route('home') }}" class="btn">View Products</a>
        </div>
        
        <div class="action-card">
            <h3>User Management</h3>
            <p>Manage users and permissions</p>
            <a href="#" class="btn">Coming Soon</a>
        </div>
    </div>
</div>
@endsection
