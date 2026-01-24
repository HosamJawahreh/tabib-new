<?php
/**
 * Check Featured Products
 * This script checks if there are featured products in the database
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== FEATURED PRODUCTS CHECK ===" . PHP_EOL . PHP_EOL;

// Check total products
$totalProducts = App\Models\Product::count();
echo "Total Products: " . $totalProducts . PHP_EOL;

// Check featured products
$featuredProducts = App\Models\Product::where('featured', 1)->get();
echo "Featured Products (featured=1): " . $featuredProducts->count() . PHP_EOL . PHP_EOL;

if ($featuredProducts->count() > 0) {
    echo "Featured Products List:" . PHP_EOL;
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;
    foreach ($featuredProducts as $product) {
        echo "ID: {$product->id} | Name: {$product->name} | Status: " . ($product->status ? 'Active' : 'Inactive') . " | Featured: {$product->featured}" . PHP_EOL;
    }
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL . PHP_EOL;
} else {
    echo "⚠️  NO FEATURED PRODUCTS FOUND!" . PHP_EOL . PHP_EOL;
    echo "To fix this:" . PHP_EOL;
    echo "1. Go to Admin Panel" . PHP_EOL;
    echo "2. Go to Products section" . PHP_EOL;
    echo "3. Edit products and check the 'Featured' checkbox" . PHP_EOL;
    echo "4. Save the products" . PHP_EOL . PHP_EOL;
}

// Check active featured products
$activeFeatured = App\Models\Product::where('featured', 1)->where('status', 1)->get();
echo "Active Featured Products (featured=1 AND status=1): " . $activeFeatured->count() . PHP_EOL;

if ($activeFeatured->count() > 0) {
    echo "These products will show in the featured section:" . PHP_EOL;
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;
    foreach ($activeFeatured as $product) {
        echo "✓ {$product->name}" . PHP_EOL;
    }
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;
}

echo PHP_EOL . "Done!" . PHP_EOL;
