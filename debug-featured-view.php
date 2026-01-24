<?php
/**
 * Debug Featured Products in View
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DEBUG FEATURED PRODUCTS FOR PRODUCT VIEW ===" . PHP_EOL . PHP_EOL;

// Get a sample product
$product = App\Models\Product::where('status', 1)->first();

if (!$product) {
    echo "❌ No products found!" . PHP_EOL;
    exit;
}

echo "Testing with product: {$product->name} (ID: {$product->id})" . PHP_EOL . PHP_EOL;

// Simulate the controller query
$featured_products = App\Models\Product::where('featured', 1)
    ->where('status', 1)
    ->where('id', '!=', $product->id)
    ->withCount('ratings')
    ->withAvg('ratings', 'rating')
    ->inRandomOrder()
    ->take(12)
    ->get();

echo "Featured products count: " . $featured_products->count() . PHP_EOL . PHP_EOL;

if ($featured_products->count() > 0) {
    echo "Featured Products List:" . PHP_EOL;
    echo str_repeat("━", 80) . PHP_EOL;
    
    foreach ($featured_products as $item) {
        echo "ID: {$item->id}" . PHP_EOL;
        echo "Name: {$item->name}" . PHP_EOL;
        echo "SKU: {$item->sku}" . PHP_EOL;
        echo "Photo: {$item->photo}" . PHP_EOL;
        echo "Thumbnail: {$item->thumbnail}" . PHP_EOL;
        echo "Featured: " . ($item->featured ? 'YES' : 'NO') . PHP_EOL;
        echo "Status: " . ($item->status ? 'Active' : 'Inactive') . PHP_EOL;
        echo "Price: {$item->price}" . PHP_EOL;
        echo "Rating: " . number_format($item->ratings_avg_rating ?? 0, 1) . PHP_EOL;
        echo "Rating Count: " . ($item->ratings_count ?? 0) . PHP_EOL;
        echo str_repeat("─", 80) . PHP_EOL;
    }
} else {
    echo "❌ No featured products found!" . PHP_EOL;
    echo PHP_EOL;
    echo "Checking reasons:" . PHP_EOL;
    
    $all_featured = App\Models\Product::where('featured', 1)->count();
    echo "- Total featured products (any status): {$all_featured}" . PHP_EOL;
    
    $featured_active = App\Models\Product::where('featured', 1)
        ->where('status', 1)
        ->count();
    echo "- Featured + Active products: {$featured_active}" . PHP_EOL;
    
    $excluding_current = App\Models\Product::where('featured', 1)
        ->where('status', 1)
        ->where('id', '!=', $product->id)
        ->count();
    echo "- Featured + Active (excluding current product): {$excluding_current}" . PHP_EOL;
}

echo PHP_EOL;
echo "✅ Debug complete!" . PHP_EOL;
