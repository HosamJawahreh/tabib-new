<?php

/*
 * Clear Old Category Columns - Fix Category Conflicts
 *
 * This script clears the old category_id, subcategory_id, childcategory_id columns
 * from the products table to prevent conflicts with the new multi-category system.
 *
 * The filterProducts() function uses OR logic to check both old and new category
 * systems, which causes products to appear in wrong categories.
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Product;

echo "╔══════════════════════════════════════════════════════════════╗\n";
echo "║     CLEAR OLD CATEGORY COLUMNS - FIX CATEGORY CONFLICTS     ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n\n";

try {
    // Start transaction
    DB::beginTransaction();

    echo "📊 Analyzing current state...\n\n";

    // Count products with old category columns
    $productsWithOldCat = Product::whereNotNull('category_id')->count();
    $productsWithOldSubcat = Product::whereNotNull('subcategory_id')->count();
    $productsWithOldChildcat = Product::whereNotNull('childcategory_id')->count();

    echo "Products with old category_id: {$productsWithOldCat}\n";
    echo "Products with old subcategory_id: {$productsWithOldSubcat}\n";
    echo "Products with old childcategory_id: {$productsWithOldChildcat}\n\n";

    // Get sample before clearing
    echo "📝 Sample products BEFORE clearing (first 5):\n";
    $sampleBefore = Product::whereNotNull('category_id')
        ->with('categories')
        ->take(5)
        ->get();

    foreach ($sampleBefore as $product) {
        echo "\n  Product: {$product->name}\n";
        echo "    Old category_id: {$product->category_id}\n";
        echo "    Old subcategory_id: {$product->subcategory_id}\n";
        echo "    Old childcategory_id: {$product->childcategory_id}\n";
        echo "    New categories (pivot): " . $product->categories->pluck('name')->implode(', ') . "\n";
    }

    echo "\n\n⚠️  WARNING: This will clear all old category columns!\n";
    echo "The new multi-category system (category_product table) will be used exclusively.\n\n";
    echo "Do you want to proceed? (yes/no): ";

    $handle = fopen("php://stdin", "r");
    $line = trim(fgets($handle));

    if (strtolower($line) !== 'yes') {
        echo "\n❌ Operation cancelled.\n";
        DB::rollBack();
        exit(0);
    }

    echo "\n🔧 Clearing old category columns...\n";

    // Clear old category columns
    $updated = DB::table('products')->update([
        'category_id' => null,
        'subcategory_id' => null,
        'childcategory_id' => null,
    ]);

    echo "✅ Updated {$updated} products\n\n";

    // Verify clearing
    echo "📝 Sample products AFTER clearing (same 5):\n";
    $sampleAfter = Product::whereIn('id', $sampleBefore->pluck('id'))
        ->with('categories')
        ->get();

    foreach ($sampleAfter as $product) {
        echo "\n  Product: {$product->name}\n";
        echo "    Old category_id: " . ($product->category_id ?: 'NULL') . "\n";
        echo "    Old subcategory_id: " . ($product->subcategory_id ?: 'NULL') . "\n";
        echo "    Old childcategory_id: " . ($product->childcategory_id ?: 'NULL') . "\n";
        echo "    New categories (pivot): " . $product->categories->pluck('name')->implode(', ') . "\n";
    }

    echo "\n\n✅ Old category columns cleared successfully!\n";
    echo "✅ All products now use ONLY the multi-category system.\n\n";

    DB::commit();

    echo "╔══════════════════════════════════════════════════════════════╗\n";
    echo "║                    OPERATION COMPLETED                       ║\n";
    echo "╚══════════════════════════════════════════════════════════════╝\n\n";

    echo "📋 NEXT STEPS:\n";
    echo "1. Clear application cache: php artisan cache:clear\n";
    echo "2. Clear view cache: php artisan view:clear\n";
    echo "3. Test homepage category filtering\n";
    echo "4. Verify products appear in correct categories\n\n";

} catch (\Exception $e) {
    DB::rollBack();
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    exit(1);
}
