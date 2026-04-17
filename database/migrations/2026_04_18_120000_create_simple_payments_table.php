<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations - Create simple payments table without foreign key constraints
     */
    public function up(): void
    {
        // Drop existing payments table if it exists
        Schema::dropIfExists('payments');
        
        // Create new simple payments table
        Schema::create('payments', function (Blueprint $table) {
            $table->id();                                           // Primary key
            $table->unsignedBigInteger('order_id')->nullable();     // Order ID (no foreign key)
            $table->unsignedBigInteger('customer_id')->nullable();  // Customer ID (no foreign key)
            $table->decimal('amount', 10, 2);                      // Base amount
            $table->decimal('tax_amount', 10, 2)->default(0);      // Tax amount
            $table->decimal('total_amount', 10, 2);                // Total amount
            $table->string('transaction_uuid')->unique();          // Unique transaction ID
            $table->string('product_code')->default('EPAYTEST');   // eSewa merchant code
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending'); // Payment status
            $table->string('payment_method')->default('esewa');    // Payment method
            $table->string('ref_id')->nullable();                  // eSewa reference ID
            $table->timestamps();                                   // Created at and updated at
        });
    }

    /**
     * Reverse the migrations
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};