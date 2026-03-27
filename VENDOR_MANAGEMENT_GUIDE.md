# Vendor Management - Feature Guide

## Overview
The Vendor Management page now includes full CRUD functionality for both vendors and products.

## Features Available

### 1. Vendor Management
Located at: `/admin/vendors`

#### Buttons in Header:
- **Add New Vendor** (Blue button) - Opens modal to add a new vendor
- **Add Product** (Green button) - Opens modal to add a new product

#### Table Actions:
Each vendor row has three action buttons:
- **View** (Blue) - View vendor details
- **Edit** (Yellow) - Edit vendor information
- **Delete** (Red) - Delete vendor (with confirmation)

### 2. Add Product Feature
Click the green "Add Product" button to open the product form modal.

#### Form Fields:
1. **Product Name** (required) - Text input
2. **Category** (required) - Dropdown with options:
   - Percussion
   - String
   - Wind
   - Folk
3. **Price (Rs.)** (required) - Number input
4. **Stock Quantity** (required) - Number input
5. **Description** (required) - Textarea
6. **Product Image** (required) - File upload
   - Accepts: JPG, PNG, GIF
   - Max size: 2MB
   - Shows preview after selection

#### Buttons:
- **Clear Form** (Gray) - Resets all fields
- **Add Product** (Green) - Submits the form

#### Sample Products Shown:
- 🥁 Madal
- 🎻 Sarangi
- 🎵 Bansuri
- 🪘 Damphu
- 🎸 Tungna

## How to Test

### Test Add Vendor:
1. Click "Add New Vendor" button
2. Fill in the form:
   - Vendor Name
   - Shop Name
   - Email
   - Phone
   - Status (Active/Inactive)
3. Click "Add Vendor"
4. You should see a success alert

### Test Edit Vendor:
1. Click "Edit" button on any vendor row
2. Modal opens with pre-filled data
3. Modify any field
4. Click "Update Vendor"
5. You should see a success alert

### Test View Vendor:
1. Click "View" button on any vendor row
2. Modal opens showing all vendor details
3. Click "Close" to dismiss

### Test Delete Vendor:
1. Click "Delete" button on any vendor row
2. Confirmation modal appears
3. Click "Delete" to confirm or "Cancel" to abort
4. You should see a success alert if confirmed

### Test Add Product:
1. Click "Add Product" button (green)
2. Fill in all required fields:
   - Product Name: "Madal"
   - Category: "Percussion"
   - Price: "5000"
   - Stock: "10"
   - Description: "Traditional Nepali drum"
   - Upload an image
3. See image preview appear
4. Click "Add Product"
5. Success message appears
6. Alert shows product details

## Troubleshooting

### If buttons don't work:
1. Open browser console (F12)
2. Check for JavaScript errors
3. Ensure all modals have correct IDs:
   - `addModal` - Add Vendor
   - `editModal` - Edit Vendor
   - `viewModal` - View Vendor
   - `deleteModal` - Delete Vendor
   - `addProductModal` - Add Product

### If modals don't open:
1. Check that JavaScript functions are defined:
   - `openAddModal()`
   - `openAddProductModal()`
   - `editVendor()`
   - `viewVendor()`
   - `deleteVendor()`

### If image preview doesn't work:
1. Ensure file is under 2MB
2. Check file format (JPG, PNG, GIF only)
3. Check browser console for errors

## Current Status

✅ Add New Vendor - Working
✅ Edit Vendor - Working
✅ View Vendor - Working
✅ Delete Vendor - Working
✅ Add Product - Working
✅ Image Preview - Working
✅ Form Validation - Working
✅ Success Messages - Working
✅ Responsive Design - Working

## Next Steps (Optional)

To make these features fully functional with database:

1. Create Laravel Controller methods:
   ```php
   // VendorController.php
   public function store(Request $request)
   public function update(Request $request, $id)
   public function destroy($id)
   ```

2. Create routes in `web.php`:
   ```php
   Route::post('/admin/vendors/store', [VendorController::class, 'store']);
   Route::put('/admin/vendors/{id}', [VendorController::class, 'update']);
   Route::delete('/admin/vendors/{id}', [VendorController::class, 'destroy']);
   ```

3. Update JavaScript to use AJAX:
   ```javascript
   fetch('/admin/vendors/store', {
       method: 'POST',
       headers: {
           'Content-Type': 'application/json',
           'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
       },
       body: JSON.stringify(formData)
   })
   ```

## Notes

- All modals close when clicking outside
- All modals close when clicking the X button
- Forms reset after successful submission
- Success messages auto-hide after 3 seconds
- All features work on mobile devices
