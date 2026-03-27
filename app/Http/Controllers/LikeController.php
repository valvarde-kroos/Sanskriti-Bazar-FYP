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
            return back()->with('success', 'Like removed.');
        } else {
            Like::create([
                'user_id' => Auth::id(),
                'product_id' => $id,
            ]);
            return back()->with('success', 'Product liked.');
        }
    }
}
