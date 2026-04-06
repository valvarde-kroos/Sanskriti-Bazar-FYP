<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle($id)
    {
        $product = Product::findOrFail($id);

        $like = Like::where('user_id', Auth::id())->where('product_id', $id)->first();

        if ($like) {
            $like->delete();
            $message = 'Like removed.';
            $isLiked = false;
        } else {
            Like::create([
                'user_id' => Auth::id(),
                'product_id' => $id,
            ]);
            $message = 'Product liked.';
            $isLiked = true;
        }

        // If it's an AJAX request, return JSON
        if (request()->ajax()) {
            $wishlistCount = Like::where('user_id', Auth::id())->count();
            return response()->json([
                'success' => true,
                'message' => $message,
                'isLiked' => $isLiked,
                'wishlistCount' => $wishlistCount
            ]);
        }

        return back()->with('success', $message);
    }
}
