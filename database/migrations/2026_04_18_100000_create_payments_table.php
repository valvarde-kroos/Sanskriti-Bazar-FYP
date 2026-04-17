<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations - Create payments table for eSewa integration
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();                                           // Primary key
            $table->foreignId('order_id')->constrained('orders');  // Foreign key to orders table
            $table->foreignId('customer_id')->constrained('users'); // Foreign key to users table
            $table->decimal('amount', 10, 2);                      // Base amount
            $table->decimal('tax_amount', 10, 2)->default(0);      // Tax amount
            $table->decimal('total_amount', 10, 2);                // Total amount
            $table->string('transaction_uuid')->unique();          // Unique transaction ID for eSewa
            $table->string('product_code')->default('EPAYTEST');   // eSewa merchant code
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending'); // Payment status
            $table->string('payment_method')->default('esewa');    // Payment method
            $table->string('ref_id')->nullable();                  // eSewa reference ID after payment
            $table->timestamps();                                   // Created at and updated at
        });
    }

    /**
     * Reverse the migrations - Drop payments table
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};