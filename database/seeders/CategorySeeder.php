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
            ['categoryName' => 'Madal', 'image' => null],
            ['categoryName' => 'Bansuri', 'image' => null],
            ['categoryName' => 'Sarangi', 'image' => null],
            ['categoryName' => 'Damaha', 'image' => null],
            ['categoryName' => 'Tungna', 'image' => null],
            ['categoryName' => 'Khaijhandi', 'image' => null],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('Categories created successfully!');
    }
}
