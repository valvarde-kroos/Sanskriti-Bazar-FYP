<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    public function dashboard()
    {
        $vendor = auth()->user();

        // Get vendor's products
        $products = Product::where('user_id', $vendor->id)
            ->with('category')
            ->latest()
            ->get();

        // Get orders for vendor's products
        $orders = Order::whereHas('product', function($query) use ($vendor) {
            $query->where('user_id', $vendor->id);
        })
        ->with(['product', 'user'])
        ->latest()
        ->get();

        // Get all categories for the add product form
        $categories = Category::all();

        // Calculate statistics
        $totalProducts = $products->count();
        $totalOrders = $orders->count();
        $pendingOrders = $orders->where('status', 'pending')->count();
        $processingOrders = $orders->where('status', 'processing')->count();
        $completedOrders = $orders->where('status', 'completed')->count();
        $cancelledOrders = $orders->where('status', 'cancelled')->count();
        $totalRevenue = $orders->where('status', 'completed')->sum('total_price');

        // Revenue by month (last 6 months)
        $revenueByMonth = Order::whereHas('product', function($query) use ($vendor) {
            $query->where('user_id', $vendor->id);
        })
        ->where('status', 'completed')
        ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total_price) as revenue')
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->limit(6)
        ->get()
        ->reverse();

        // Order status distribution for chart
        $orderStatusData = [
            'pending' => $pendingOrders,
            'processing' => $processingOrders,
            'completed' => $completedOrders,
            'cancelled' => $cancelledOrders,
        ];

        return view('vendor.dashboard', compact(
            'products',
            'orders',
            'categories',
            'totalProducts',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'cancelledOrders',
            'totalRevenue',
            'revenueByMonth',
            'orderStatusData'
        ));
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);

        // Verify ownership
        if ($product->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action');
        }

        $categories = Category::all();

        return view('vendor-edit-product', compact('product', 'categories'));
    }

    public function toggleProductStatus($id)
    {
        $product = Product::findOrFail($id);

        // Verify ownership
        if ($product->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action');
        }

        $product->update([
            'status' => $product->status === 'active' ? 'inactive' : 'active'
        ]);

        return back()->with('success', 'Product status updated successfully');
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Verify the order belongs to vendor's product
        if ($order->product->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action');
        }

        $request->validate([
            'status' => 'required|in:pending,accepted,processing,delivered,cancelled'
        ]);

        // Additional validation for accepting orders (moving to accepted)
        if ($request->status === 'accepted' && $order->status === 'pending') {
            if ($order->product->quantity < $order->quantity) {
                return redirect()->route('vendor.orders')->with('error', 'Cannot accept order: Insufficient stock available!');
            }
            
            // Reduce stock when accepting the order
            $order->product->decrement('quantity', $order->quantity);
        }

        // If cancelling an accepted order, restore stock
        if ($request->status === 'cancelled' && in_array($order->status, ['accepted', 'processing'])) {
            $order->product->increment('quantity', $order->quantity);
        }

        $order->update([
            'status' => $request->status
        ]);

        $statusMessages = [
            'accepted' => 'Order accepted successfully!',
            'processing' => 'Order is now being processed!',
            'delivered' => 'Order marked as delivered!',
            'cancelled' => 'Order has been rejected.',
        ];

        $message = $statusMessages[$request->status] ?? 'Order status updated successfully!';

        return redirect()->route('vendor.orders')->with('success', $message);
    }

    public function adminVendor()
    {
        $vendors = User::where('role', 'vendor')->latest()->get();

        return view('admin.Vendor.list', compact('vendors'));
    }

    public function addProduct()
    {
        $categories = Category::all();
        return view('vendor.add-product', compact('categories'));
    }

    public function products()
    {
        $vendor = auth()->user();
        $products = Product::where('user_id', $vendor->id)
            ->with('category')
            ->latest()
            ->get();
        $categories = Category::all();

        return view('vendor.products', compact('products', 'categories'));
    }

    public function orders()
    {
        $vendor = auth()->user();
        $orders = Order::whereHas('product', function($query) use ($vendor) {
            $query->where('user_id', $vendor->id);
        })
        ->with(['product', 'user'])
        ->latest()
        ->get();

        return view('vendor.orders', compact('orders'));
    }

    public function sales()
    {
        $vendor = auth()->user();
        
        // Get orders for vendor's products for sales data
        $orders = Order::whereHas('product', function($query) use ($vendor) {
            $query->where('user_id', $vendor->id);
        })
        ->with(['product', 'user'])
        ->latest()
        ->get();

        return view('vendor.sales', compact('orders'));
    }

    public function reviews()
    {
        $vendor = auth()->user();
        
        // Get reviews for vendor's products
        $reviews = Review::whereHas('product', function($query) use ($vendor) {
            $query->where('user_id', $vendor->id);
        })
        ->with(['product', 'user'])
        ->latest()
        ->get();

        // Get all vendor's products for the filter dropdown
        $products = Product::where('user_id', $vendor->id)
            ->orderBy('post_title')
            ->get();

        return view('vendor.reviews', compact('reviews', 'products'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'post_title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'post_description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'user_id' => auth()->id(),
            'post_title' => $request->post_title,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'post_description' => $request->post_description,
            'status' => 'active',
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads'), $imageName);
            $data['image'] = $imageName;
        }

        Product::create($data);

        return redirect()->route('vendor.products')->with('success', 'Product added successfully!');
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Verify ownership
        if ($product->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action');
        }

        $request->validate([
            'post_title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'post_description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'post_title' => $request->post_title,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'post_description' => $request->post_description,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image && file_exists(public_path('uploads/'.$product->image))) {
                unlink(public_path('uploads/'.$product->image));
            }

            $imageName = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads'), $imageName);
            $data['image'] = $imageName;
        }

        $product->update($data);

        return redirect()->route('vendor.products')->with('success', 'Product updated successfully!');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);

        // Verify ownership
        if ($product->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action');
        }

        // Delete image if exists
        if ($product->image && file_exists(public_path('uploads/'.$product->image))) {
            unlink(public_path('uploads/'.$product->image));
        }

        $product->delete();

        return redirect()->route('vendor.products')->with('success', 'Product deleted successfully!');
    }

    public function settings()
    {
        $vendor = auth()->user();
        return view('vendor.settings', compact('vendor'));
    }

    public function updateProfile(Request $request)
    {
        $vendor = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $vendor->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $vendor->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Profile information updated successfully!');
    }

    public function updateShop(Request $request)
    {
        $vendor = auth()->user();
        
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'shop_description' => 'nullable|string|max:1000',
            'shop_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'shop_name' => $request->shop_name,
            'shop_description' => $request->shop_description,
        ];

        // Handle logo upload
        if ($request->hasFile('shop_logo')) {
            // Delete old logo if exists
            if ($vendor->shop_logo && file_exists(public_path('uploads/logos/' . $vendor->shop_logo))) {
                unlink(public_path('uploads/logos/' . $vendor->shop_logo));
            }

            // Create logos directory if it doesn't exist
            if (!file_exists(public_path('uploads/logos'))) {
                mkdir(public_path('uploads/logos'), 0777, true);
            }

            $logoName = time() . '_' . $request->shop_logo->getClientOriginalName();
            $request->shop_logo->move(public_path('uploads/logos'), $logoName);
            $data['shop_logo'] = $logoName;
        }

        $vendor->update($data);

        return back()->with('success', 'Shop details updated successfully!');
    }

    public function updateAddress(Request $request)
    {
        $vendor = auth()->user();
        
        $request->validate([
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:2',
        ]);

        $vendor->update([
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
        ]);

        return back()->with('success', 'Address information updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $vendor = auth()->user();
        
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        // Check if current password is correct
        if (!Hash::check($request->current_password, $vendor->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $vendor->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password changed successfully!');
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $vendor = auth()->user();
        
        \Log::info('Vendor search called', ['query' => $query, 'vendor_id' => $vendor->id]); // Debug log
        
        if (empty($query)) {
            return response()->json([]);
        }

        $results = [];

        try {
            // Search products
            $products = Product::where('user_id', $vendor->id)
                ->where(function($q) use ($query) {
                    $q->where('post_title', 'LIKE', "%{$query}%")
                      ->orWhere('post_description', 'LIKE', "%{$query}%");
                })
                ->limit(5)
                ->get();

            foreach ($products as $product) {
                $results[] = [
                    'type' => 'product',
                    'title' => $product->post_title,
                    'description' => 'Product - Rs. ' . number_format($product->price ?? 0) . ' (Stock: ' . ($product->quantity ?? 0) . ')',
                    'url' => route('vendor.products') . '#product-' . $product->id
                ];
            }

            // Search orders
            $orders = Order::whereHas('product', function($q) use ($vendor) {
                    $q->where('user_id', $vendor->id);
                })
                ->where(function($q) use ($query) {
                    $q->where('id', 'LIKE', "%{$query}%")
                      ->orWhereHas('user', function($userQuery) use ($query) {
                          $userQuery->where('name', 'LIKE', "%{$query}%");
                      })
                      ->orWhereHas('product', function($productQuery) use ($query) {
                          $productQuery->where('post_title', 'LIKE', "%{$query}%");
                      });
                })
                ->with(['user', 'product'])
                ->limit(5)
                ->get();

            foreach ($orders as $order) {
                $results[] = [
                    'type' => 'order',
                    'title' => 'Order #' . $order->id,
                    'description' => 'Customer: ' . $order->user->name . ' - Rs. ' . number_format($order->total_price) . ' (' . ucfirst($order->status) . ')',
                    'url' => route('vendor.orders') . '#order-' . $order->id
                ];
            }

            // If searching for specific terms, add navigation shortcuts
            $searchLower = strtolower($query);
            if (strpos($searchLower, 'product') !== false || strpos($searchLower, 'manage') !== false) {
                $results[] = [
                    'type' => 'navigation',
                    'title' => 'Manage Products',
                    'description' => 'Go to Products page to manage your inventory',
                    'url' => route('vendor.products')
                ];
            }
            
            if (strpos($searchLower, 'order') !== false) {
                $results[] = [
                    'type' => 'navigation',
                    'title' => 'View Orders',
                    'description' => 'Go to Orders page to manage customer orders',
                    'url' => route('vendor.orders')
                ];
            }
            
            if (strpos($searchLower, 'dashboard') !== false || strpos($searchLower, 'home') !== false) {
                $results[] = [
                    'type' => 'navigation',
                    'title' => 'Dashboard',
                    'description' => 'Go to main dashboard overview',
                    'url' => route('vendor.dashboard')
                ];
            }

            \Log::info('Search results', ['count' => count($results)]); // Debug log
            
        } catch (\Exception $e) {
            \Log::error('Search error', ['error' => $e->getMessage()]); // Debug log
            return response()->json(['error' => 'Search failed'], 500);
        }

        return response()->json($results);
    }

    public function getNotifications()
    {
        $vendor = auth()->user();
        
        \Log::info('Vendor notifications called', ['vendor_id' => $vendor->id]); // Debug log
        
        $notifications = [];

        try {
            // Get recent orders (last 24 hours)
            $recentOrders = Order::whereHas('product', function($q) use ($vendor) {
                    $q->where('user_id', $vendor->id);
                })
                ->where('created_at', '>=', now()->subDay())
                ->with(['user', 'product'])
                ->latest()
                ->limit(5)
                ->get();

            foreach ($recentOrders as $order) {
                $notifications[] = [
                    'type' => 'order',
                    'icon' => 'fas fa-shopping-cart',
                    'title' => 'New Order Received',
                    'description' => 'Order #' . $order->id . ' from ' . $order->user->name,
                    'time' => $order->created_at->diffForHumans(),
                    'unread' => true
                ];
            }

            // Get low stock products
            $lowStockProducts = Product::where('user_id', $vendor->id)
                ->where('quantity', '<=', 5)
                ->where('quantity', '>', 0)
                ->limit(3)
                ->get();

            foreach ($lowStockProducts as $product) {
                $notifications[] = [
                    'type' => 'stock',
                    'icon' => 'fas fa-box',
                    'title' => 'Low Stock Alert',
                    'description' => $product->post_title . ' inventory is running low (' . $product->quantity . ' left)',
                    'time' => 'Stock alert',
                    'unread' => true
                ];
            }

            // Get completed orders (last 7 days)
            $completedOrders = Order::whereHas('product', function($q) use ($vendor) {
                    $q->where('user_id', $vendor->id);
                })
                ->where('status', 'completed')
                ->where('updated_at', '>=', now()->subWeek())
                ->with(['user', 'product'])
                ->latest()
                ->limit(3)
                ->get();

            foreach ($completedOrders as $order) {
                $notifications[] = [
                    'type' => 'success',
                    'icon' => 'fas fa-check-circle',
                    'title' => 'Order Completed',
                    'description' => 'Order #' . $order->id . ' has been delivered',
                    'time' => $order->updated_at->diffForHumans(),
                    'unread' => false
                ];
            }

            // Sort by time (most recent first)
            usort($notifications, function($a, $b) {
                if ($a['type'] === 'stock') return 1;
                if ($b['type'] === 'stock') return -1;
                return 0;
            });

            $unreadCount = count(array_filter($notifications, function($n) { return $n['unread']; }));
            
            \Log::info('Notifications loaded', ['count' => count($notifications), 'unread' => $unreadCount]); // Debug log

            return response()->json([
                'notifications' => array_slice($notifications, 0, 10),
                'unread_count' => $unreadCount
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Notifications error', ['error' => $e->getMessage()]); // Debug log
            return response()->json(['error' => 'Failed to load notifications'], 500);
        }
    }
}
