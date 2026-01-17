<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Product;

echo "=== Fixing Category 170 (كولاجين& فيتامين) ===\n\n";

// Category ID for كولاجين& فيتامين
$categoryId = 170;

// Find all products that contain keywords related to collagen, vitamins, omega
$keywords = [
    '%كولاجين%',
    '%collagen%',
    '%COLLAGEN%',
    '%اوميغا%',
    '%omega%',
    '%OMEGA%',
    '%فيتامين%',
    '%vitamin%',
    '%VITAMIN%'
];

$query = Product::where(function($q) use ($keywords) {
    foreach ($keywords as $keyword) {
        $q->orWhere('name', 'LIKE', $keyword);
    }
});

$products = $query->get();

echo "Found {$products->count()} products matching keywords\n\n";

$added = 0;
$skipped = 0;

foreach ($products as $product) {
    // Check if already linked to category 170
    $exists = DB::table('category_product')
        ->where('product_id', $product->id)
        ->where('category_id', $categoryId)
        ->exists();

    if ($exists) {
        $skipped++;
        continue;
    }

    // Add the product to category 170
    DB::table('category_product')->insert([
        'product_id' => $product->id,
        'category_id' => $categoryId
    ]);

    $added++;
    echo "✓ Added: [{$product->id}] " . mb_substr($product->name, 0, 50) . "...\n";
}

echo "\n=== Summary ===\n";
echo "Products added to category 170: $added\n";
echo "Products already in category: $skipped\n";

// Show final count
$finalCount = DB::table('category_product')
    ->where('category_id', $categoryId)
    ->count();

echo "Total products in category 170 now: $finalCount\n";

echo "\nDone!\n";
