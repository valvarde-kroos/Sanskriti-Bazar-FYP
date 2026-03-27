<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // Show all categories for admin dashboard
    public function adminIndex()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories', compact('categories'));
    }

    // Store new category (for admin)
    public function store(Request $request)
    {
        $request->validate([
            'categoryName' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads'), $imageName);
        }

        Category::create([
            'categoryName' => $request->categoryName,
            'image' => $imageName,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Category added successfully.']);
        }

        return back()->with('success', 'Category added successfully.');
    }

    // Update category (for admin)
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'categoryName' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($category->image && file_exists(public_path('uploads/'.$category->image))) {
                unlink(public_path('uploads/'.$category->image));
            }
            $imageName = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads'), $imageName);
            $category->image = $imageName;
        }

        $category->categoryName = $request->categoryName;
        $category->save();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Category updated successfully.']);
        }

        return back()->with('success', 'Category updated successfully.');
    }

    // Delete category (for admin)
    public function delete($id)
    {
        $category = Category::findOrFail($id);

        if ($category->image && file_exists(public_path('uploads/'.$category->image))) {
            unlink(public_path('uploads/'.$category->image));
        }

        $category->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);
        }

        return back()->with('success', 'Category deleted successfully.');
    }
}
