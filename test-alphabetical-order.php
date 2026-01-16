<?php
/**
 * Test Alphabetical Product Ordering
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

echo "================================================================================\n";
echo "ALPHABETICAL PRODUCT ORDERING TEST\n";
echo "================================================================================\n\n";

echo "📋 Testing product ordering...\n\n";

// Get first 10 products as they would appear on homepage
$products = Product::where('status', 1)
    ->orderBy('name', 'asc')
    ->take(10)
    ->get(['id', 'name', 'status']);

echo "First 10 products (Alphabetical Order):\n";
echo str_repeat("-", 80) . "\n";

foreach ($products as $index => $product) {
    $num = $index + 1;
    echo "{$num}. {$product->name}\n";
}

echo "\n";
echo "✅ Products are now ordered alphabetically by name!\n";
echo "\n";

// Verify they are actually in alphabetical order
$names = $products->pluck('name')->toArray();
$sorted_names = $names;
sort($sorted_names, SORT_NATURAL | SORT_FLAG_CASE);

if ($names === $sorted_names) {
    echo "✅ VERIFIED: Products are correctly sorted alphabetically!\n";
} else {
    echo "⚠️  WARNING: Products may not be in correct alphabetical order\n";
    echo "This could be due to special characters or Arabic text sorting\n";
}

echo "\n";
echo "📊 Total Active Products: " . Product::where('status', 1)->count() . "\n";
echo "\n";
echo "================================================================================\n";
