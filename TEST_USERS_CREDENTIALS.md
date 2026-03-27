# Test User Credentials

The following test users have been created in the database. Use these credentials to test the role-based access control system.

## Admin User
- **Email:** admin@example.com
- **Password:** password
- **Phone:** 1234567890
- **Role:** admin
- **Access:** Admin dashboard, category management, all features

## Vendor User
- **Email:** vendor@example.com
- **Password:** password
- **Phone:** 9876543210
- **Role:** vendor
- **Access:** Vendor dashboard, product management, cart, orders

## Customer User
- **Email:** customer@example.com
- **Password:** password
- **Phone:** 5555555555
- **Role:** customer
- **Access:** Home page, shopping, cart, orders, likes

## How to Test

1. **Test Admin Login:**
   - Go to `/login`
   - Login with admin@example.com / password
   - Should redirect to `/admin/dashboard`
   - Try accessing `/categories` (should work)

2. **Test Vendor Login:**
   - Logout and login with vendor@example.com / password
   - Should redirect to `/vendor/dashboard`
   - Try adding products (should work)
   - Try accessing `/categories` (should get 403 error)

3. **Test Customer Login:**
   - Logout and login with customer@example.com / password
   - Should redirect to `/` (home page)
   - Try shopping and adding to cart (should work)
   - Try accessing `/categories` (should get 403 error)

## Re-running the Seeder

If you need to re-run the seeder:
```bash
php artisan db:seed --class=UserRoleSeeder
```

Or run all seeders:
```bash
php artisan db:seed
```

## Note
All test users have the same password: **password**
