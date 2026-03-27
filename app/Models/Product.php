<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'price',
        'quantity',
        'post_title',
        'post_description',
        'image',
        'status',
    ];

    /**
     * A product belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class, );
    }

    /**
     * A product belongs to a category
     */
    public function category()
    {
        return $this->belongsTo(Category::class, );
    }

    /**
     * A product can have many likes
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isLikedBy($user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function carts()
{
    return $this->hasMany(Cart::class);
}
      public function likesCount()
    {
        return $this->likes()->count();
    }

}
