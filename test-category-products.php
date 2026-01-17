<?php
/**
 * Test Script: Verify Multi-Category Products Retrieval
 * 
 * This script tests:
 * 1. Products have correct category relationships in database
 * 2. Categories can retrieve their products correctly
 * 3. Products appear in all their assigned categories
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

echo "\n====================================\n";
echo "MULTI-CATEGORY PRODUCTS TEST\n";
echo "====================================\n\n";

// Test 1: Check category_product pivot table
echo "1. Checking category_product pivot table...\n";
$pivotCount = DB::table('category_product')->count();
echo "   Total category-product relationships: {$pivotCount}\n\n";

if ($pivotCount == 0) {
    echo "   ⚠️  WARNING: No relationships found in category_product table!\n";
    echo "   Please run the migration script to populate multi-categories.\n\n";
}

// Test 2: Check sample products and their categories
echo "2. Sample products with their categories:\n";
echo str_repeat("-", 80) . "\n";

$products = Product::where('status', 1)
    ->with('categories')
    ->limit(10)
    ->get();

foreach ($products as $product) {
    echo "   Product: {$product->name} (ID: {$product->id})\n";
    
    if ($product->categories->count() > 0) {
        echo "   Categories: ";
        $catNames = $product->categories->pluck('name')->toArray();
        echo implode(', ', $catNames) . "\n";
        echo "   Total: {$product->categories->count()} categories\n";
    } else {
        echo "   ⚠️  No categories assigned!\n";
    }
    echo "\n";
}

// Test 3: Check categories and their products count
echo "\n3. Categories and their product counts:\n";
echo str_repeat("-", 80) . "\n";

$categories = Category::where('status', 1)
    ->withCount(['products' => function($query) {
        $query->where('status', 1);
    }])
    ->orderBy('name')
    ->get();

foreach ($categories as $category) {
    echo "   Category: {$category->name} (ID: {$category->id})\n";
    echo "   Products count: {$category->products_count}\n";
    
    // Show first 3 products in this category
    $categoryProducts = Product::where('status', 1)
        ->whereHas('categories', function($q) use ($category) {
            $q->where('categories.id', $category->id);
        })
        ->limit(3)
        ->get();
    
    if ($categoryProducts->count() > 0) {
        echo "   Sample products:\n";
        foreach ($categoryProducts as $prod) {
            echo "      - {$prod->name} (ID: {$prod->id})\n";
        }
    } else {
        echo "   ⚠️  No products found in this category!\n";
    }
    echo "\n";
}

// Test 4: Test category filtering (simulate homepage category click)
echo "\n4. Testing category filtering (simulating homepage click):\n";
echo str_repeat("-", 80) . "\n";

$testCategory = Category::where('status', 1)->first();

if ($testCategory) {
    echo "   Testing with category: {$testCategory->name}\n";
    
    $filteredProducts = Product::where('status', 1)
        ->whereHas('categories', function($q) use ($testCategory) {
            $q->where('categories.id', $testCategory->id);
        })
        ->with('categories')
        ->limit(5)
        ->get();
    
    echo "   Found {$filteredProducts->count()} products:\n";
    foreach ($filteredProducts as $prod) {
        echo "      - {$prod->name}\n";
    }
} else {
    echo "   ⚠️  No categories found!\n";
}

// Test 5: Check for products with no categories
echo "\n\n5. Products without categories (orphaned products):\n";
echo str_repeat("-", 80) . "\n";

$orphanedProducts = Product::where('status', 1)
    ->doesntHave('categories')
    ->limit(10)
    ->get();

if ($orphanedProducts->count() > 0) {
    echo "   ⚠️  Found {$orphanedProducts->count()} products without categories:\n";
    foreach ($orphanedProducts as $prod) {
        echo "      - {$prod->name} (ID: {$prod->id})\n";
    }
    echo "\n   These products need categories assigned!\n";
} else {
    echo "   ✓ All products have categories assigned!\n";
}

// Summary
echo "\n\n====================================\n";
echo "TEST SUMMARY\n";
echo "====================================\n";
echo "Total products: " . Product::where('status', 1)->count() . "\n";
echo "Total categories: " . Category::where('status', 1)->count() . "\n";
echo "Total relationships: {$pivotCount}\n";
echo "Products with categories: " . Product::where('status', 1)->has('categories')->count() . "\n";
echo "Products without categories: " . $orphanedProducts->count() . "\n";
echo "\n";

if ($pivotCount > 0 && $orphanedProducts->count() == 0) {
    echo "✓ Multi-category system is working correctly!\n";
} else {
    echo "⚠️  Issues found - please review the warnings above.\n";
}

echo "\n";
