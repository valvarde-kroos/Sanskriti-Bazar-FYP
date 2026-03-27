<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Like;
use App\Models\Review;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $customer = auth()->user();
        
        // Get customer's orders
        $orders = Order::where('user_id', $customer->id)
            ->with('product.user')
            ->latest()
            ->get();
        
        // Get customer's cart items
        $cartItems = Cart::where('user_id', $customer->id)
            ->with('product.category')
            ->get();
        
        // Get customer's wishlist (liked products)
        $wishlist = Like::where('user_id', $customer->id)
            ->with('product.category')
            ->latest()
            ->get();
        
        // Get products that customer has ordered (for review form)
        $orderedProducts = $orders->pluck('product')->unique('id');
        
        // Calculate statistics
        $totalOrders = $orders->count();
        $pendingOrders = $orders->where('status', 'pending')->count();
        $processingOrders = $orders->where('status', 'processing')->count();
        $completedOrders = $orders->where('status', 'completed')->count();
        $totalSpent = $orders->where('status', 'completed')->sum('total_price');
        $cartTotal = $cartItems->sum(function($item) {
            return $item->quantity * ($item->product->price ?? 0);
        });
        
        // Get recent orders for dashboard (limit to 3)
        $recentOrders = $orders->take(3);
        $wishlistCount = $wishlist->count();
        
        return view('customer.dashboard', compact(
            'customer',
            'orders',
            'recentOrders',
            'cartItems',
            'wishlist',
            'orderedProducts',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'totalSpent',
            'cartTotal',
            'wishlistCount'
        ));
    }
    
    public function updateProfile(Request $request)
    {
        $customer = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
        ]);
        
        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
        
        return back()->with('success', 'Profile updated successfully');
    }
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);
        
        $customer = auth()->user();
        
        if (!Hash::check($request->current_password, $customer->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }
        
        $customer->update([
            'password' => Hash::make($request->new_password),
        ]);
        
        return back()->with('success', 'Password updated successfully');
    }
    
    public function removeFromWishlist($id)
    {
        $like = Like::where('user_id', auth()->id())
            ->where('product_id', $id)
            ->first();
        
        if ($like) {
            $like->delete();
            return back()->with('success', 'Removed from wishlist');
        }
        
        return back()->withErrors(['error' => 'Item not found in wishlist']);
    }
    
    public function storeReview(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);
        
        // Check if customer has already reviewed this product
        $existingReview = Review::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();
        
        if ($existingReview) {
            return back()->withErrors(['error' => 'You have already reviewed this product']);
        }
        
        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);
        
        return back()->with('success', 'Review submitted successfully');
    }
}
