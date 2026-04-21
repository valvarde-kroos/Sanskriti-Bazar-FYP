<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\Review;

class VendorDataSeeder extends Seeder
{
    public function run()
    {
        // Get the vendor user
        $vendor = User::where('email', 'vendor@gmail.com')->first();
        
        if (!$vendor) {
            $this->command->error('Vendor user not found! Please create vendor@gmail.com first.');
            return;
        }

        // Get some customers
        $customers = User::where('role', 'customer')->limit(3)->get();
        
        if ($customers->isEmpty()) {
            $this->command->error('No customers found! Please create some customer accounts first.');
            return;
        }

        // Get categories
        $categories = Category::all();
        
        if ($categories->isEmpty()) {
            $this->command->error('No categories found! Please run CategorySeeder first.');
            return;
        }

        $this->command->info('Creating sample products for vendor...');

        // Sample products data
        $productsData = [
            [
                'post_title' => 'Professional Madal',
                'post_description' => 'High-quality traditional Nepali madal made from premium wood. Perfect for professional performances and cultural events.',
                'price' => 5500.00,
                'quantity' => 15,
                'status' => 'active',
                'image' => '1771662179_Tabala.jpg'
            ],
            [
                'post_title' => 'Bamboo Bansuri Flute',
                'post_description' => 'Authentic bamboo flute handcrafted by skilled artisans. Produces melodious traditional sounds.',
                'price' => 1200.00,
                'quantity' => 25,
                'status' => 'active',
                'image' => '1774111562_Musical Instrument Bamboo Flute.jpg'
            ],
            [
                'post_title' => 'Traditional Sarangi',
                'post_description' => 'Beautiful handcrafted Nepali sarangi with rich cultural heritage. Ideal for folk music enthusiasts.',
                'price' => 8500.00,
                'quantity' => 8,
                'status' => 'active',
                'image' => '1774282521_Nepalesisches Sarangi-Volksinstrument_ Gandalbha-Musikinstrument.jpg'
            ],
            [
                'post_title' => 'Tungna Folk Guitar',
                'post_description' => 'Traditional Nepali string instrument with unique sound. Perfect for folk music performances.',
                'price' => 6000.00,
                'quantity' => 10,
                'status' => 'active',
                'image' => '1774806954_Tungna.jpg'
            ],
            [
                'post_title' => 'Damaha Drum',
                'post_description' => 'Large traditional drum used in Nepali festivals and ceremonies. Authentic sound quality.',
                'price' => 12000.00,
                'quantity' => 5,
                'status' => 'active',
                'image' => '1774808020_Damaha.png'
            ],
            [
                'post_title' => 'Khaijandi Cymbals',
                'post_description' => 'Traditional Nepali cymbals for cultural performances. Made from high-quality brass.',
                'price' => 1800.00,
                'quantity' => 20,
                'status' => 'active',
                'image' => '1774808993_khaijandi.png'
            ],
        ];

        $products = [];
        foreach ($productsData as $productData) {
            $product = Product::create([
                'user_id' => $vendor->id,
                'category_id' => $categories->random()->id,
                'post_title' => $productData['post_title'],
                'post_description' => $productData['post_description'],
                'price' => $productData['price'],
                'quantity' => $productData['quantity'],
                'status' => $productData['status'],
                'image' => $productData['image'],
            ]);
            $products[] = $product;
            $this->command->info("Created product: {$product->post_title}");
        }

        $this->command->info('Creating sample orders...');

        // Create orders with different statuses
        $orderStatuses = ['pending', 'accepted', 'processing', 'completed', 'completed', 'completed'];
        $paymentMethods = ['cash_on_delivery', 'esewa', 'cash_on_delivery'];
        
        foreach ($customers as $customer) {
            // Each customer makes 2-3 orders
            $orderCount = rand(2, 3);
            
            for ($i = 0; $i < $orderCount; $i++) {
                $product = $products[array_rand($products)];
                $quantity = rand(1, 3);
                $status = $orderStatuses[array_rand($orderStatuses)];
                $paymentMethod = $paymentMethods[array_rand($paymentMethods)];
                
                $order = Order::create([
                    'user_id' => $customer->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'total_price' => $product->price * $quantity,
                    'status' => $status,
                    'payment_method' => $paymentMethod,
                    'payment_status' => $status === 'completed' ? 'paid' : 'pending',
                    'shipping_name' => $customer->name,
                    'shipping_address' => 'Kathmandu, Nepal',
                    'shipping_phone' => $customer->phone ?? '9800000000',
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now()->subDays(rand(0, 15)),
                ]);
                
                $this->command->info("Created order #{$order->id} - {$status} - Rs. {$order->total_price}");
                
                // Add reviews for completed orders (50% chance)
                if ($status === 'completed' && rand(0, 1)) {
                    Review::create([
                        'user_id' => $customer->id,
                        'product_id' => $product->id,
                        'rating' => rand(4, 5),
                        'comment' => $this->getRandomReview(),
                        'created_at' => now()->subDays(rand(0, 10)),
                    ]);
                    $this->command->info("Added review for product: {$product->post_title}");
                }
            }
        }

        $this->command->info('✅ Vendor data seeded successfully!');
        $this->command->info('📊 Statistics:');
        $this->command->info("   - Products: " . count($products));
        $this->command->info("   - Orders: " . Order::whereHas('product', function($q) use ($vendor) {
            $q->where('user_id', $vendor->id);
        })->count());
        $this->command->info("   - Revenue: Rs. " . number_format(Order::whereHas('product', function($q) use ($vendor) {
            $q->where('user_id', $vendor->id);
        })->where('payment_status', 'paid')->sum('total_price'), 2));
    }

    private function getRandomReview()
    {
        $reviews = [
            'Excellent quality! Very authentic sound. Highly recommended.',
            'Beautiful craftsmanship. Worth every rupee!',
            'Great product for traditional music. Fast delivery too.',
            'Amazing instrument! Perfect for cultural performances.',
            'Very satisfied with the quality. Will order again.',
            'Authentic Nepali instrument. Sounds wonderful!',
            'Good value for money. Seller was very helpful.',
            'Perfect for beginners and professionals alike.',
        ];
        
        return $reviews[array_rand($reviews)];
    }
}
