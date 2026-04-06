<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Like;
use App\Models\Review;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
        
        // Calculate statistics
        $totalOrders = $orders->count();
        $pendingOrders = $orders->where('status', 'pending')->count();
        $cartCount = $cartItems->count();
        $totalSpent = $orders->where('status', 'completed')->sum('total_price');
        
        // Get recent orders for dashboard (limit to 4)
        $recentOrders = $orders->take(4);
        
        return view('customer.dashboard', compact(
            'customer',
            'recentOrders',
            'totalOrders',
            'pendingOrders',
            'cartCount',
            'totalSpent'
        ));
    }

    public function orders()
    {
        $customer = auth()->user();
        
        // Get all customer's orders
        $orders = Order::where('user_id', $customer->id)
            ->with('product.user')
            ->latest()
            ->get();
        
        return view('customer.orders', compact('orders'));
    }

    public function profile()
    {
        $customer = auth()->user();
        return view('customer.profile', compact('customer'));
    }

    public function reviews()
    {
        $customer = auth()->user();
        
        // Get customer's reviews
        $myReviews = Review::where('user_id', $customer->id)
            ->with('product')
            ->latest()
            ->get();
        
        // Get products that customer has ordered (for review form)
        $orderedProducts = Order::where('user_id', $customer->id)
            ->with('product')
            ->get()
            ->pluck('product')
            ->unique('id');
        
        return view('customer.reviews', compact('myReviews', 'orderedProducts'));
    }

    public function wishlist()
    {
        $customer = auth()->user();
        
        // Get customer's wishlist (liked products)
        $wishlistItems = Like::where('user_id', $customer->id)
            ->with(['product.category', 'product.user'])
            ->latest()
            ->get();
        
        return view('customer.wishlist', compact('wishlistItems'));
    }

    public function wishlistCount()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }

        $count = Like::where('user_id', Auth::id())->count();
        return response()->json(['count' => $count]);
    }
    
    public function updateProfile(Request $request)
    {
        $customer = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $customer->id,
            'phone' => 'required|string|max:20',
        ]);
        
        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
        
        return back()->with('success', 'Profile updated successfully!');
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
        
        return back()->with('success', 'Password updated successfully!');
    }

    public function updateAddress(Request $request)
    {
        $customer = auth()->user();
        
        $request->validate([
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
        ]);
        
        $customer->update([
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'city' => $request->city,
        ]);
        
        return back()->with('success', 'Address updated successfully!');
    }

    public function updatePreferences(Request $request)
    {
        $customer = auth()->user();
        
        $customer->update([
            'email_orders' => $request->has('email_orders'),
            'email_promotions' => $request->has('email_promotions'),
            'email_newsletter' => $request->has('email_newsletter'),
            'preferred_language' => $request->preferred_language ?? 'en',
        ]);
        
        return back()->with('success', 'Preferences updated successfully');
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
    
    public function cancelOrder($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();
        
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }
        
        // Only allow cancellation of pending orders
        if ($order->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Only pending orders can be cancelled'], 400);
        }
        
        $order->update(['status' => 'cancelled']);
        
        return response()->json(['success' => true, 'message' => 'Order cancelled successfully']);
    }
    
    public function viewOrder($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->with('product.user')
            ->first();
        
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }
        
        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'order_number' => 'ORD-' . str_pad($order->id, 3, '0', STR_PAD_LEFT),
                'product_name' => $order->product->post_title,
                'quantity' => $order->quantity,
                'total_price' => $order->total_price,
                'status' => $order->status,
                'created_at' => $order->created_at->format('M d, Y h:i A'),
                'vendor_name' => $order->product->user->name ?? 'N/A',
                'shipping_address' => $order->shipping_address ?? 'Default address'
            ]
        ]);
    }
}
