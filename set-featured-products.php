<?php
/**
 * Set Featured Products
 * This script marks random active products as featured
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== SET FEATURED PRODUCTS ===" . PHP_EOL . PHP_EOL;

// Get 20 random active products that are not already featured
$products = App\Models\Product::where('status', 1)
    ->where('featured', 0)
    ->inRandomOrder()
    ->take(20)
    ->get();

if ($products->count() > 0) {
    echo "Setting " . $products->count() . " products as featured..." . PHP_EOL . PHP_EOL;
    
    foreach ($products as $product) {
        $product->featured = 1;
        $product->save();
        echo "✓ Set as featured: {$product->name}" . PHP_EOL;
    }
    
    echo PHP_EOL . "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;
    echo "SUCCESS! " . $products->count() . " products have been marked as featured." . PHP_EOL;
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;
} else {
    echo "⚠️  No active products found to mark as featured!" . PHP_EOL;
}

// Show total featured products now
$totalFeatured = App\Models\Product::where('featured', 1)->where('status', 1)->count();
echo PHP_EOL . "Total Active Featured Products: " . $totalFeatured . PHP_EOL;

echo PHP_EOL . "Done!" . PHP_EOL;
