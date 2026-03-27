<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['categoryName' => 'Traditional Clothing', 'image' => null],
            ['categoryName' => 'Handicrafts', 'image' => null],
            ['categoryName' => 'Jewelry', 'image' => null],
            ['categoryName' => 'Home Decor', 'image' => null],
            ['categoryName' => 'Religious Items', 'image' => null],
            ['categoryName' => 'Musical Instruments', 'image' => null],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('Categories created successfully!');
    }
}
