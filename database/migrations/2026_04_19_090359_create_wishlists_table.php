<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * This creates the wishlists table to store customer wishlist items
     */
    public function up(): void
    {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('user_id'); // Customer who added to wishlist
            $table->unsignedBigInteger('product_id'); // Product that was wishlisted
            $table->timestamps(); // created_at and updated_at
            
            // Create a unique constraint to prevent duplicate wishlist entries
            // Same user cannot add the same product to wishlist twice
            $table->unique(['user_id', 'product_id']);
            
            // Add indexes for better query performance
            $table->index('user_id');
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     * This drops the wishlists table
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};