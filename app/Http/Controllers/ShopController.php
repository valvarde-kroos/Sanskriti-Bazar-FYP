<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'user']);
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('post_title', 'like', "%{$search}%")
                  ->orWhere('post_description', 'like', "%{$search}%");
            });
        }
        
        // Category Filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        // Price Filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        // Sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }
        
        $products = $query->get();
        $categories = Category::orderBy('categoryName')->get();
        
        return view('shop', compact('products', 'categories'));
    }
    
    public function show($id)
    {
        $product = Product::with(['category', 'user', 'likes'])->findOrFail($id);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();
        
        $isLiked = false;
        if (auth()->check()) {
            $isLiked = $product->isLikedBy(auth()->user());
        }
        
        return view('product-detail', compact('product', 'relatedProducts', 'isLiked'));
    }
}
