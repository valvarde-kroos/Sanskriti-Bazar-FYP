<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id');
            $table->unsignedBigInteger('product_id')->after('user_id');
            $table->integer('quantity')->default(1)->after('product_id');
            $table->decimal('total_price', 10, 2)->after('quantity');
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending')->after('total_price');
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['product_id']);
            $table->dropColumn(['user_id', 'product_id', 'quantity', 'total_price', 'status']);
        });
    }
};
