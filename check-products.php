<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Checking products in database...\n\n";

$products = \App\Models\Product::orderBy('id')->get();

echo "Total products: " . $products->count() . "\n\n";

echo "Product List:\n";
echo str_repeat("-", 80) . "\n";
printf("%-5s %-40s %-15s %-10s\n", "ID", "Title", "Category", "Price");
echo str_repeat("-", 80) . "\n";

foreach ($products as $product) {
    printf(
        "%-5s %-40s %-15s %-10s\n",
        $product->id,
        substr($product->post_title, 0, 40),
        $product->category ? substr($product->category->categoryName, 0, 15) : 'N/A',
        'Rs. ' . number_format($product->price ?? 0, 2)
    );
}

echo str_repeat("-", 80) . "\n";

// Check for duplicate titles
$duplicateTitles = \App\Models\Product::select('post_title')
    ->groupBy('post_title')
    ->havingRaw('COUNT(*) > 1')
    ->pluck('post_title');

if ($duplicateTitles->count() > 0) {
    echo "\n⚠️  Found duplicate product titles:\n";
    foreach ($duplicateTitles as $title) {
        $count = \App\Models\Product::where('post_title', $title)->count();
        echo "  - '$title' appears $count times\n";
    }
} else {
    echo "\n✓ No duplicate product titles found\n";
}
