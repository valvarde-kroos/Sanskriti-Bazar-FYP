<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'user')->get();
        return view('home', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_title' => 'required|string|max:255',
            'post_description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads'), $imageName);
        }

        Product::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'post_title' => $request->post_title,
            'post_description' => $request->post_description,
            'image' => $imageName,
        ]);

        // Redirect vendors back to their dashboard
        if (auth()->user()->isVendor()) {
            return redirect()->route('vendor.dashboard')->with('success', 'Product added successfully.');
        }

        return back()->with('success', 'Product added successfully.');
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);

        // Check if user owns the product or is admin
        if ($product->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action');
        }

        if ($product->image && file_exists(public_path('uploads/'.$product->image))) {
            unlink(public_path('uploads/'.$product->image));
        }

        $product->delete();
        
        // Redirect vendors back to their dashboard
        if (auth()->user()->isVendor()) {
            return redirect()->route('vendor.dashboard')->with('delete', 'Product deleted successfully.');
        }
        
        return back()->with('delete', 'Product deleted successfully.');
    }
}
