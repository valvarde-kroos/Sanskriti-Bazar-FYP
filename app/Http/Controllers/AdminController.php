<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\Review;

class AdminController extends Controller
{
    // Vendors Management
    public function vendors()
    {
        $vendors = User::where('role', 'vendor')->with('products')->get();
        return view('admin.vendors', compact('vendors'));
    }

    public function storeVendor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'role' => 'vendor',
        ]);

        return back()->with('success', 'Vendor added successfully.');
    }

    public function updateVendor(Request $request, $id)
    {
        $vendor = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
        ]);

        $vendor->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Vendor updated successfully.');
    }

    public function deleteVendor($id)
    {
        $vendor = User::findOrFail($id);
        $vendor->delete();
        return back()->with('success', 'Vendor deleted successfully.');
    }

    // Customers Management
    public function customers()
    {
        $customers = User::where('role', 'customer')->with('orders')->get();
        return view('admin.customers', compact('customers'));
    }

    public function storeCustomer(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'role' => 'customer',
        ]);

        return back()->with('success', 'Customer added successfully.');
    }

    public function updateCustomer(Request $request, $id)
    {
        $customer = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
        ]);

        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Customer updated successfully.');
    }

    public function deleteCustomer($id)
    {
        $customer = User::findOrFail($id);
        $customer->delete();
        return back()->with('success', 'Customer deleted successfully.');
    }

    // Reviews Management
    public function reviews()
    {
        $reviews = Review::with(['user', 'product'])
            ->latest()
            ->get();
        
        return view('admin.reviews', compact('reviews'));
    }

    public function updateReviewStatus(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'admin_response' => 'nullable|string|max:1000'
        ]);

        $review->update([
            'status' => $request->status,
            'admin_response' => $request->admin_response
        ]);

        return back()->with('success', 'Review status updated successfully.');
    }

    public function deleteReview($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        
        return back()->with('success', 'Review deleted successfully.');
    }

    public function storeReview(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        Review::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Review added successfully.');
    }

    public function editReview($id)
    {
        $review = Review::with(['user', 'product'])->findOrFail($id);
        $users = User::where('role', 'customer')->get();
        $products = Product::all();
        
        return response()->json([
            'review' => $review,
            'users' => $users,
            'products' => $products
        ]);
    }

    public function updateReview(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'status' => 'required|in:pending,approved,rejected',
            'admin_response' => 'nullable|string|max:1000'
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => $request->status,
            'admin_response' => $request->admin_response
        ]);

        return back()->with('success', 'Review updated successfully.');
    }
}