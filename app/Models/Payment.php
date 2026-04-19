<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'payments';

    // Fields that can be mass assigned - simplified without removed columns
    protected $fillable = [
        'order_id',          // Order ID (no foreign key constraint)
        'customer_id',       // Customer ID (no foreign key constraint)
        'amount',            // Payment amount
        'total_amount',      // Total amount
        'transaction_uuid',  // Unique transaction ID
        'status',            // Payment status
        'payment_method',    // Payment method
    ];

    // Cast attributes to proper types
    protected $casts = [
        'amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    // Default values
    protected $attributes = [
        'status' => 'pending',
        'payment_method' => 'esewa',
    ];

    // Relationship: Payment belongs to an Order (optional, no constraint)
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // Relationship: Payment belongs to a Customer (optional, no constraint)
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAILED = 'failed';

    // Check if payment is successful
    public function isSuccessful()
    {
        return $this->status === self::STATUS_SUCCESS;
    }

    // Check if payment is pending
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    // Check if payment failed
    public function isFailed()
    {
        return $this->status === self::STATUS_FAILED;
    }
}