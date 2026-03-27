<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment',
        'status',
        'admin_response'
    ];

    protected $casts = [
        'rating' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship with User (customer who wrote the review)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Scope for approved reviews
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // Scope for pending reviews
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Get customer name
    public function getCustomerNameAttribute()
    {
        return $this->user ? $this->user->name : 'Unknown Customer';
    }

    // Get customer email
    public function getCustomerEmailAttribute()
    {
        return $this->user ? $this->user->email : 'No email';
    }

    // Get product name
    public function getProductNameAttribute()
    {
        return $this->product ? $this->product->post_title : 'Product Deleted';
    }
}