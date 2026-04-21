<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'wishlists';

    /**
     * The attributes that are mass assignable.
     * These fields can be filled using create() or fill() methods
     */
    protected $fillable = [
        'user_id',    // ID of the customer who added to wishlist
        'product_id', // ID of the product that was wishlisted
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: Wishlist belongs to a User (Customer)
     * This allows us to get the customer who owns this wishlist item
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: Wishlist belongs to a Product
     * This allows us to get the product details for this wishlist item
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope: Get wishlist items for a specific user
     * Usage: Wishlist::forUser($userId)->get()
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Static method: Check if a product is in user's wishlist
     * Usage: Wishlist::isInWishlist($userId, $productId)
     */
    public static function isInWishlist($userId, $productId)
    {
        return self::where('user_id', $userId)
                   ->where('product_id', $productId)
                   ->exists();
    }

    /**
     * Static method: Add product to wishlist
     * Usage: Wishlist::addToWishlist($userId, $productId)
     */
    public static function addToWishlist($userId, $productId)
    {
        return self::firstOrCreate([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);
    }

    /**
     * Static method: Remove product from wishlist
     * Usage: Wishlist::removeFromWishlist($userId, $productId)
     */
    public static function removeFromWishlist($userId, $productId)
    {
        return self::where('user_id', $userId)
                   ->where('product_id', $productId)
                   ->delete();
    }
}