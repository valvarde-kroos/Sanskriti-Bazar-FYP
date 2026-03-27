<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get vendor and customer users
        $vendor = User::where('role', 'vendor')->first();
        $customer = User::where('role', 'customer')->first();
        
        if (!$vendor || !$customer) {
            $this->command->info('Please run UserRoleSeeder first to create vendor and customer users.');
            return;
        }
        
        // Get or create a product for the vendor
        $product = Product::where('user_id', $vendor->id)->first();
        
        if (!$product) {
            // Create a sample product if none exists
            $category = \App\Models\Category::first();
            if ($category) {
                $product = Product::create([
                    'user_id' => $vendor->id,
                    'category_id' => $category->id,
                    'post_title' => 'Sample Product',
                    'post_description' => 'This is a sample product for testing',
                    'image' => null,
                ]);
            } else {
                $this->command->info('Please create at least one category first.');
                return;
            }
        }
        
        // Create sample orders
        Order::create([
            'user_id' => $customer->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'total_price' => 2000.00,
            'status' => 'pending',
        ]);
        
        Order::create([
            'user_id' => $customer->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'total_price' => 1500.00,
            'status' => 'processing',
        ]);
        
        Order::create([
            'user_id' => $customer->id,
            'product_id' => $product->id,
            'quantity' => 3,
            'total_price' => 4500.00,
            'status' => 'completed',
        ]);
        
        $this->command->info('Sample orders created successfully!');
    }
}
