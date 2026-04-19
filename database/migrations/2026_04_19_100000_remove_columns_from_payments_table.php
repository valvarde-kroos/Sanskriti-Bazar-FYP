<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations - Remove tax_amount, product_code, ref_id from payments table
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['tax_amount', 'product_code', 'ref_id']);
        });
    }

    /**
     * Reverse the migrations - Add back the columns if needed
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->string('product_code')->default('EPAYTEST');
            $table->string('ref_id')->nullable();
        });
    }
};