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
        // Clear existing categories first
        Category::truncate();
        
        $categories = [
            ['categoryName' => 'Percussion Instruments'],
            ['categoryName' => 'Wind Instruments'],
            ['categoryName' => 'String Instruments'],
            ['categoryName' => 'Traditional Instruments'],
            ['categoryName' => 'Idiophones'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('Categories created successfully!');
    }
}
