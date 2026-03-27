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
        Schema::table('users', function (Blueprint $table) {
            // Shop details fields
            $table->string('shop_name')->nullable();
            $table->text('shop_description')->nullable();
            $table->string('shop_logo')->nullable();
            
            // Address fields
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country', 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'shop_name',
                'shop_description', 
                'shop_logo',
                'address_line1',
                'address_line2',
                'city',
                'postal_code',
                'country'
            ]);
        });
    }
};
