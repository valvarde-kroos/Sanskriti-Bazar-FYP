<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Product;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Get some customers and products for the reviews
        $customers = User::where('role', 'customer')->get();
        $products = Product::all();

        if ($customers->count() > 0 && $products->count() > 0) {
            $reviews = [
                [
                    'user_id' => $customers->first()->id,
                    'product_id' => $products->first()->id,
                    'rating' => 5,
                    'comment' => 'Excellent product! Great quality and fast delivery. Highly recommended for everyone.',
                    'status' => 'approved',
                    'admin_response' => null,
                ],
                [
                    'user_id' => $customers->skip(1)->first()->id ?? $customers->first()->id,
                    'product_id' => $products->skip(1)->first()->id ?? $products->first()->id,
                    'rating' => 4,
                    'comment' => 'Good quality fabric and nice design. Fits perfectly. Will order again.',
                    'status' => 'pending',
                    'admin_response' => null,
                ],
                [
                    'user_id' => $customers->first()->id,
                    'product_id' => $products->skip(2)->first()->id ?? $products->first()->id,
                    'rating' => 2,
                    'comment' => 'Product arrived damaged. Packaging was poor. Not satisfied with the quality.',
                    'status' => 'approved',
                    'admin_response' => 'We apologize for the inconvenience. Please contact our support team for a replacement.',
                ],
                [
                    'user_id' => $customers->skip(1)->first()->id ?? $customers->first()->id,
                    'product_id' => $products->skip(3)->first()->id ?? $products->first()->id,
                    'rating' => 5,
                    'comment' => 'Beautiful traditional flute with amazing sound quality. Perfect for meditation and music.',
                    'status' => 'approved',
                    'admin_response' => null,
                ],
                [
                    'user_id' => $customers->first()->id,
                    'product_id' => $products->skip(4)->first()->id ?? $products->first()->id,
                    'rating' => 3,
                    'comment' => 'Average product. Could be better for the price. Delivery was on time though.',
                    'status' => 'pending',
                    'admin_response' => null,
                ],
            ];

            foreach ($reviews as $reviewData) {
                Review::create($reviewData);
            }

            $this->command->info('Sample reviews created successfully!');
        } else {
            $this->command->warn('No customers or products found. Please seed users and products first.');
        }
    }
}