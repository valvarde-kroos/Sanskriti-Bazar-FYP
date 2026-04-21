<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Dashboard with comprehensive analytics
    public function dashboard()
    {
        try {
            // Basic counts with error handling
            $totalCategories = Category::count();
            $totalCustomers = User::where('role', 'customer')->count();
            $totalVendors = User::where('role', 'vendor')->count();
            $totalProducts = Product::count();
            $totalOrders = Order::count();
            
            // Revenue analytics
            $totalRevenue = Order::where('payment_status', 'paid')->sum('total_price') ?? 0;
            $monthlyRevenue = Order::where('payment_status', 'paid')
                ->whereMonth('created_at', now()->month)
                ->sum('total_price') ?? 0;
            $lastMonthRevenue = Order::where('payment_status', 'paid')
                ->whereMonth('created_at', now()->subMonth()->month)
                ->whereYear('created_at', now()->subMonth()->year)
                ->sum('total_price') ?? 0;
            
            // Calculate revenue growth percentage
            $revenueGrowth = 0;
            if ($lastMonthRevenue > 0) {
                $revenueGrowth = (($monthlyRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
            } elseif ($monthlyRevenue > 0) {
                $revenueGrowth = 100; // 100% growth if no previous month data
            }
            $pendingOrders = Order::where('status', 'pending')->count();
            
            // Calculate monthly growth for orders, products, and users
            $thisMonthOrders = Order::whereMonth('created_at', now()->month)->count();
            $lastMonthOrders = Order::whereMonth('created_at', now()->subMonth()->month)
                ->whereYear('created_at', now()->subMonth()->year)->count();
            $ordersGrowth = 0;
            if ($lastMonthOrders > 0) {
                $ordersGrowth = (($thisMonthOrders - $lastMonthOrders) / $lastMonthOrders) * 100;
            } elseif ($thisMonthOrders > 0) {
                $ordersGrowth = 100;
            }
            
            $thisMonthProducts = Product::whereMonth('created_at', now()->month)->count();
            $lastMonthProducts = Product::whereMonth('created_at', now()->subMonth()->month)
                ->whereYear('created_at', now()->subMonth()->year)->count();
            $productsGrowth = 0;
            if ($lastMonthProducts > 0) {
                $productsGrowth = (($thisMonthProducts - $lastMonthProducts) / $lastMonthProducts) * 100;
            } elseif ($thisMonthProducts > 0) {
                $productsGrowth = 100;
            }
            
            $thisMonthUsers = User::whereIn('role', ['customer', 'vendor'])
                ->whereMonth('created_at', now()->month)->count();
            $lastMonthUsers = User::whereIn('role', ['customer', 'vendor'])
                ->whereMonth('created_at', now()->subMonth()->month)
                ->whereYear('created_at', now()->subMonth()->year)->count();
            $usersGrowth = 0;
            if ($lastMonthUsers > 0) {
                $usersGrowth = (($thisMonthUsers - $lastMonthUsers) / $lastMonthUsers) * 100;
            } elseif ($thisMonthUsers > 0) {
                $usersGrowth = 100;
            }
            
            // Products per category for bar chart
            $productsPerCategory = Category::withCount('products')
                ->orderBy('products_count', 'desc')
                ->get()
                ->map(function ($category) {
                    return [
                        'name' => $category->categoryName ?? 'Unknown',
                        'count' => $category->products_count ?? 0
                    ];
                });
            
            // Monthly sales data for line chart (last 12 months)
            $monthlySales = [];
            for ($i = 11; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $sales = Order::where('payment_status', 'paid')
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->sum('total_price') ?? 0;
                
                $monthlySales[] = [
                    'month' => $date->format('M Y'),
                    'sales' => $sales
                ];
            }
            
            // Order status distribution for doughnut chart
            $orderStatusDistribution = [
                'pending' => Order::where('status', 'pending')->count(),
                'accepted' => Order::where('status', 'accepted')->count(),
                'processing' => Order::where('status', 'processing')->count(),
                'completed' => Order::where('status', 'completed')->count(),
                'cancelled' => Order::where('status', 'cancelled')->count(),
            ];
            
            // Top selling products - simplified query to avoid GROUP BY issues
            $topProducts = collect();
            try {
                $products = Product::all();
                $topProducts = $products->map(function($product) {
                    $totalSold = Order::where('product_id', $product->id)
                        ->where('payment_status', 'paid')
                        ->sum('quantity') ?? 0;
                    
                    $product->total_sold = $totalSold;
                    return $product;
                })
                ->sortByDesc('total_sold')
                ->take(5);
            } catch (\Exception $e) {
                // Fallback to basic product list if query fails
                $topProducts = Product::limit(5)->get()->map(function($product) {
                    $product->total_sold = 0;
                    return $product;
                });
            }
            
            // Recent orders
            $recentOrders = Order::with(['user', 'product'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
            
            // Vendor performance - simplified
            $vendorPerformance = collect();
            try {
                $vendors = User::where('role', 'vendor')->withCount('products')->get();
                $vendorPerformance = $vendors->map(function($vendor) {
                    $totalRevenue = 0;
                    try {
                        $vendorProducts = Product::where('user_id', $vendor->id)->pluck('id');
                        $totalRevenue = Order::whereIn('product_id', $vendorProducts)
                            ->where('payment_status', 'paid')
                            ->sum('total_price') ?? 0;
                    } catch (\Exception $e) {
                        $totalRevenue = 0;
                    }
                    
                    $vendor->total_revenue = $totalRevenue;
                    return $vendor;
                })
                ->sortByDesc('total_revenue')
                ->take(5);
            } catch (\Exception $e) {
                $vendorPerformance = collect();
            }
            
            // Daily orders for the current month
            $dailyOrders = [];
            $daysInMonth = now()->daysInMonth;
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $orderCount = Order::whereDay('created_at', $day)
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count();
                
                $dailyOrders[] = [
                    'day' => $day,
                    'orders' => $orderCount
                ];
            }
            
            // Recent users for management dashboard
            $recentVendors = User::where('role', 'vendor')
                ->latest()
                ->limit(5)
                ->get();
                
            $recentCustomers = User::where('role', 'customer')
                ->latest()
                ->limit(5)
                ->get();
            
        } catch (\Exception $e) {
            // Fallback data in case of any errors
            $totalCategories = 0;
            $totalCustomers = 0;
            $totalVendors = 0;
            $totalProducts = 0;
            $totalOrders = 0;
            $totalRevenue = 0;
            $monthlyRevenue = 0;
            $lastMonthRevenue = 0;
            $revenueGrowth = 0;
            $ordersGrowth = 0;
            $productsGrowth = 0;
            $usersGrowth = 0;
            $pendingOrders = 0;
            $productsPerCategory = collect();
            $monthlySales = [];
            $orderStatusDistribution = [
                'pending' => 0,
                'accepted' => 0,
                'processing' => 0,
                'completed' => 0,
                'cancelled' => 0,
            ];
            $topProducts = collect();
            $recentOrders = collect();
            $vendorPerformance = collect();
            $dailyOrders = [];
            $recentVendors = collect();
            $recentCustomers = collect();
            
            // Log the error for debugging
            \Log::error('Dashboard error: ' . $e->getMessage());
        }
        
        return view('admin.dashboard', compact(
            'totalCategories',
            'totalCustomers', 
            'totalVendors',
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'monthlyRevenue',
            'lastMonthRevenue',
            'revenueGrowth',
            'ordersGrowth',
            'productsGrowth',
            'usersGrowth',
            'pendingOrders',
            'productsPerCategory',
            'monthlySales',
            'orderStatusDistribution',
            'topProducts',
            'recentOrders',
            'vendorPerformance',
            'dailyOrders',
            'recentVendors',
            'recentCustomers'
        ));
    }

    // Vendors Management
    public function vendors()
    {
        $vendors = User::where('role', 'vendor')
            ->withCount('products')
            ->with(['products' => function($query) {
                $query->select('id', 'user_id', 'post_title', 'price', 'quantity', 'status', 'created_at');
            }])
            ->orderByRaw("FIELD(approval_status, 'pending', 'approved', 'declined')")
            ->orderBy('created_at', 'desc')
            ->get();
        
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

    // Get notifications for admin
    public function getNotifications()
    {
        try {
            $notifications = [];
            
            // Get recent customer registrations (last 7 days)
            $recentCustomers = User::where('role', 'customer')
                ->where('created_at', '>=', now()->subDays(7))
                ->latest()
                ->limit(5)
                ->get();
            
            foreach ($recentCustomers as $customer) {
                $notifications[] = [
                    'id' => 'customer-' . $customer->id,
                    'type' => 'customer',
                    'message' => 'New customer ' . $customer->name . ' just registered',
                    'time' => $customer->created_at->diffForHumans(),
                    'timestamp' => $customer->created_at->timestamp,
                    'isRead' => false
                ];
            }
            
            // Get recent vendor registrations (last 7 days)
            $recentVendors = User::where('role', 'vendor')
                ->where('created_at', '>=', now()->subDays(7))
                ->latest()
                ->limit(5)
                ->get();
            
            foreach ($recentVendors as $vendor) {
                $notifications[] = [
                    'id' => 'vendor-' . $vendor->id,
                    'type' => 'vendor',
                    'message' => 'New vendor ' . $vendor->name . ' applied for approval',
                    'time' => $vendor->created_at->diffForHumans(),
                    'timestamp' => $vendor->created_at->timestamp,
                    'isRead' => false
                ];
            }
            
            // Get recent orders (last 3 days)
            $recentOrders = Order::where('created_at', '>=', now()->subDays(3))
                ->with('user')
                ->latest()
                ->limit(10)
                ->get();
            
            foreach ($recentOrders as $order) {
                $notifications[] = [
                    'id' => 'order-' . $order->id,
                    'type' => 'order',
                    'message' => 'Customer ' . $order->user->name . ' placed a new order #' . $order->id,
                    'time' => $order->created_at->diffForHumans(),
                    'timestamp' => $order->created_at->timestamp,
                    'isRead' => false
                ];
            }
            
            // Get recent categories (last 7 days)
            $recentCategories = Category::where('created_at', '>=', now()->subDays(7))
                ->latest()
                ->limit(3)
                ->get();
            
            foreach ($recentCategories as $category) {
                $notifications[] = [
                    'id' => 'category-' . $category->id,
                    'type' => 'category',
                    'message' => 'New category ' . $category->categoryName . ' was added',
                    'time' => $category->created_at->diffForHumans(),
                    'timestamp' => $category->created_at->timestamp,
                    'isRead' => false
                ];
            }
            
            // Sort by timestamp (newest first)
            usort($notifications, function($a, $b) {
                return $b['timestamp'] - $a['timestamp'];
            });
            
            // Limit to 20 most recent
            $notifications = array_slice($notifications, 0, 20);
            
            return response()->json([
                'success' => true,
                'notifications' => $notifications,
                'unread_count' => count($notifications)
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Admin notifications error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'notifications' => [],
                'unread_count' => 0
            ]);
        }
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture && file_exists(public_path('uploads/profiles/' . $user->profile_picture))) {
                unlink(public_path('uploads/profiles/' . $user->profile_picture));
            }

            // Create profiles directory if it doesn't exist
            if (!file_exists(public_path('uploads/profiles'))) {
                mkdir(public_path('uploads/profiles'), 0777, true);
            }

            $fileName = time() . '_' . $request->profile_picture->getClientOriginalName();
            $request->profile_picture->move(public_path('uploads/profiles'), $fileName);
            $data['profile_picture'] = $fileName;
        }

        $user->update($data);

        return redirect()->route('admin.profile.edit')->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Check if current password is correct
        if (!\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Check if new password is different from current
        if (\Hash::check($request->new_password, $user->password)) {
            return back()->withErrors(['new_password' => 'New password must be different from current password.']);
        }

        $user->update([
            'password' => \Hash::make($request->new_password),
        ]);

        return redirect()->route('admin.profile.password')->with('success', 'Password updated successfully!');
    }

    // Vendor Approval Management
    public function vendorApprovals()
    {
        $pendingVendors = User::where('role', 'vendor')
            ->where('approval_status', 'pending')
            ->withCount('products')
            ->latest()
            ->get();
        
        $approvedVendors = User::where('role', 'vendor')
            ->where('approval_status', 'approved')
            ->withCount('products')
            ->latest()
            ->get();
        
        $declinedVendors = User::where('role', 'vendor')
            ->where('approval_status', 'declined')
            ->withCount('products')
            ->latest()
            ->get();
        
        return view('admin.vendor-approvals', compact('pendingVendors', 'approvedVendors', 'declinedVendors'));
    }

    public function approveVendor($id)
    {
        $vendor = User::findOrFail($id);
        
        if ($vendor->role !== 'vendor') {
            return redirect()->back()->with('error', 'User is not a vendor.');
        }
        
        $vendor->update(['approval_status' => 'approved']);
        
        return redirect()->back()->with('success', "Vendor {$vendor->name} has been approved successfully!");
    }

    public function declineVendor($id)
    {
        $vendor = User::findOrFail($id);
        
        if ($vendor->role !== 'vendor') {
            return redirect()->back()->with('error', 'User is not a vendor.');
        }
        
        $vendor->update(['approval_status' => 'declined']);
        
        return redirect()->back()->with('success', "Vendor {$vendor->name} has been declined.");
    }

    // User Role Management
    public function userRoleManagement()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.user-role-management', compact('users'));
    }

    public function updateUserRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,vendor,customer'
        ]);

        $user = User::findOrFail($id);
        $oldRole = $user->role;
        
        $user->update([
            'role' => $request->role,
            'approval_status' => $request->role === 'vendor' ? 'approved' : 'approved'
        ]);
        
        return redirect()->back()->with('success', "User role updated from {$oldRole} to {$request->role} successfully!");
    }

    // Account Status Management
    public function accountStatusManagement()
    {
        $users = User::orderBy('is_active', 'desc')->orderBy('created_at', 'desc')->get();
        return view('admin.account-status', compact('users'));
    }

    public function toggleAccountStatus($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent admin from deactivating themselves
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot deactivate your own account.');
        }
        
        $user->update(['is_active' => !$user->is_active]);
        
        $status = $user->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "User account has been {$status} successfully!");
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }
        
        $userName = $user->name;
        
        // Delete user
        $user->delete();
        
        return redirect()->back()->with('success', "User '{$userName}' has been deleted successfully!");
    }
}