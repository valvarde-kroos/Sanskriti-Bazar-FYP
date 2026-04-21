<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display all wishlist items for the authenticated user
     * This method shows the wishlist page in customer dashboard
     */
    public function index()
    {
        // Get the currently logged-in user
        $user = Auth::user();
        
        // Get all wishlist items for this user with product details
        // We use 'with' to eager load the product and its category to avoid N+1 queries
        $wishlistItems = Wishlist::where('user_id', $user->id)
            ->with(['product', 'product.category'])
            ->latest() // Order by newest first
            ->get();
        
        // Count total wishlist items for display
        $totalItems = $wishlistItems->count();
        
        // Return the wishlist view with data
        return view('customer.wishlist', compact('wishlistItems', 'totalItems'));
    }

    /**
     * Add a product to the user's wishlist
     * This method handles AJAX requests from the heart toggle button
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $user = Auth::user();
        $productId = $request->product_id;

        // Check if the product is already in the wishlist
        $existingWishlist = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($existingWishlist) {
            // If already in wishlist, return error message
            return response()->json([
                'success' => false,
                'message' => 'Product is already in your wishlist!',
                'in_wishlist' => true
            ], 400);
        }

        // Add product to wishlist
        $wishlist = Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $productId
        ]);

        // Get the product name for the success message
        $product = Product::find($productId);

        if ($wishlist) {
            return response()->json([
                'success' => true,
                'message' => $product->post_title . ' added to your wishlist!',
                'in_wishlist' => true,
                'wishlist_count' => Wishlist::where('user_id', $user->id)->count()
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to add product to wishlist. Please try again.',
            'in_wishlist' => false
        ], 500);
    }

    /**
     * Remove a product from the user's wishlist
     * This method handles both AJAX requests and direct removal
     */
    public function destroy(Request $request, $productId = null)
    {
        $user = Auth::user();
        
        // Get product ID from route parameter or request
        $productId = $productId ?? $request->product_id;
        
        // Validate product ID
        if (!$productId) {
            return response()->json([
                'success' => false,
                'message' => 'Product ID is required.'
            ], 400);
        }

        // Find and delete the wishlist item
        $deleted = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->delete();

        if ($deleted) {
            // Get the product name for the success message
            $product = Product::find($productId);
            
            return response()->json([
                'success' => true,
                'message' => ($product ? $product->post_title : 'Product') . ' removed from your wishlist!',
                'in_wishlist' => false,
                'wishlist_count' => Wishlist::where('user_id', $user->id)->count()
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product not found in your wishlist.',
            'in_wishlist' => false
        ], 404);
    }

    /**
     * Move a product from wishlist to cart
     * This method adds the product to cart and removes it from wishlist
     */
    public function moveToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $user = Auth::user();
        $productId = $request->product_id;

        // Check if product is in wishlist
        $wishlistItem = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if (!$wishlistItem) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found in your wishlist.'
            ], 404);
        }

        // Check if product is already in cart
        $existingCartItem = Cart::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($existingCartItem) {
            // If already in cart, just increment quantity
            $existingCartItem->increment('quantity');
        } else {
            // Add new item to cart
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }

        // Remove from wishlist
        $wishlistItem->delete();

        // Get product name for success message
        $product = Product::find($productId);

        return response()->json([
            'success' => true,
            'message' => ($product ? $product->post_title : 'Product') . ' moved to cart successfully!',
            'wishlist_count' => Wishlist::where('user_id', $user->id)->count(),
            'cart_count' => Cart::where('user_id', $user->id)->sum('quantity')
        ]);
    }

    /**
     * Toggle wishlist status (add/remove)
     * This method handles the heart button toggle functionality
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $user = Auth::user();
        $productId = $request->product_id;

        // Check if product is already in wishlist
        $wishlistItem = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($wishlistItem) {
            // Remove from wishlist
            $wishlistItem->delete();
            $product = Product::find($productId);
            
            return response()->json([
                'success' => true,
                'action' => 'removed',
                'message' => ($product ? $product->post_title : 'Product') . ' removed from wishlist!',
                'in_wishlist' => false,
                'wishlist_count' => Wishlist::where('user_id', $user->id)->count()
            ]);
        } else {
            // Add to wishlist
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $productId
            ]);
            
            $product = Product::find($productId);
            
            return response()->json([
                'success' => true,
                'action' => 'added',
                'message' => ($product ? $product->post_title : 'Product') . ' added to wishlist!',
                'in_wishlist' => true,
                'wishlist_count' => Wishlist::where('user_id', $user->id)->count()
            ]);
        }
    }

    /**
     * Get wishlist count for the authenticated user
     * This method is used to update the wishlist counter in the navigation
     */
    public function getCount()
    {
        $user = Auth::user();
        $count = Wishlist::where('user_id', $user->id)->count();
        
        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }
}