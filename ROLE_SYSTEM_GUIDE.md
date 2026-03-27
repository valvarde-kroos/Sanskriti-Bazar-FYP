# Role-Based Access Control System

## Overview
The application now has a complete role-based access control system with three roles: Admin, Vendor, and Customer.

## Database Changes
- Added `phone` column (nullable string) to users table
- Added `role` column (enum: admin, vendor, customer) with default value 'customer'

## Roles & Permissions

### Admin
- Access to admin dashboard (`/admin/dashboard`)
- Can manage categories (create, edit, delete)
- Can view all products
- Full system access

### Vendor
- Access to vendor dashboard (`/vendor/dashboard`)
- Can add and manage their own products
- Can view their profile and products
- Can access cart and place orders

### Customer
- Default role for new users
- Can browse products
- Can add items to cart
- Can place orders
- Can like products

## Login Redirects
After successful login, users are redirected based on their role:
- **Admin** → `/admin/dashboard`
- **Vendor** → `/vendor/dashboard`
- **Customer** → `/` (home page)

## Middleware Usage
The `role` middleware is used to protect routes:

```php
// Single role
Route::middleware('role:admin')->group(function () {
    // Admin only routes
});

// Multiple roles
Route::middleware('role:admin,vendor')->group(function () {
    // Admin and vendor routes
});
```

## User Model Helper Methods
```php
$user->isAdmin()    // Returns true if user is admin
$user->isVendor()   // Returns true if user is vendor
$user->isCustomer() // Returns true if user is customer
```

## Registration Form
The signup form now includes:
- Name
- Email
- Phone (optional)
- Role (required dropdown: Customer, Vendor, Admin)
- Password
- Password Confirmation

## Testing
1. Run migration: `php artisan migrate`
2. Register new users with different roles
3. Test login redirects for each role
4. Verify access restrictions work correctly

## Routes Protected by Role

### Admin Only
- `/categories` - Category management
- `/category/store` - Create category
- `/category/edit/{id}` - Edit category
- `/category/update/{id}` - Update category
- `/category/delete/{id}` - Delete category

### Admin & Vendor
- `/product/store` - Create product
- `/product/delete/{id}` - Delete product

### Customer & Vendor
- `/cart` - View cart
- `/cart/add/{id}` - Add to cart
- `/cart/remove/{id}` - Remove from cart
- `/order/place` - Place order

### All Authenticated Users
- `/profile` - User profile
- `/product/{id}/like` - Like/unlike product
