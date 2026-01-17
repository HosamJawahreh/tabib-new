<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== COMPREHENSIVE CATEGORY RESTORATION FROM LIVE DATABASE (NAME MATCHING) ===\n\n";

$pivotFile = __DIR__ . '/public/product_category_product .sql';

if (!file_exists($pivotFile)) {
    die("Error: product_category_product .sql not found\n");
}

// Step 1: Build current product name -> ID mapping
echo "Step 1: Building product name to ID mapping from current database...\n";

$currentProducts = DB::table('products')->get(['id', 'name']);

$nameToId = [];
$idToName = [];

foreach ($currentProducts as $product) {
    // Normalize name for matching (trim, lowercase)
    $normalizedName = mb_strtolower(trim($product->name));
    $nameToId[$normalizedName] = $product->id;
    $idToName[$product->id] = $product->name;
}

echo "  Built mapping for " . count($nameToId) . " products\n\n";

// Step 2: Parse products.sql to build old ID -> name mapping
echo "Step 2: Parsing live products.sql to extract product names...\n";

$productsFile = __DIR__ . '/public/products.sql';
$productsContent = file_get_contents($productsFile);

// More robust regex to extract product data
// Format: (id, 'name', ...)
preg_match_all('/\((\d+),\s*\'([^\']+)\'/', $productsContent, $matches, PREG_SET_ORDER);

$oldIdToName = [];
foreach ($matches as $match) {
    $oldId = $match[1];
    $name = $match[2];
    $oldIdToName[$oldId] = $name;
}

echo "  Extracted " . count($oldIdToName) . " product names from backup\n\n";

// Step 3: Parse pivot table
echo "Step 3: Parsing category-product relationships from backup...\n";

$pivotContent = file_get_contents($pivotFile);
preg_match_all('/INSERT INTO `ec_product_category_product` \(`category_id`, `product_id`\) VALUES\s*(.*?);/s', $pivotContent, $pivotMatches);

$relationships = [];
foreach ($pivotMatches[1] as $valuesBlock) {
    $rows = preg_split('/\),\s*\(/', $valuesBlock);

    foreach ($rows as $row) {
        $row = trim($row, ' (),');
        if (empty($row)) continue;

        if (preg_match('/(\d+),\s*(\d+)/', $row, $match)) {
            $relationships[] = [
                'category_id' => $match[1],
                'old_product_id' => $match[2]
            ];
        }
    }
}

echo "  Parsed " . count($relationships) . " relationships\n\n";

// Step 4: Clear and restore relationships
echo "Step 4: Restoring relationships...\n";
echo "  Clearing existing relationships...\n";
DB::table('category_product')->truncate();
echo "  Cleared.\n\n";

$inserted = 0;
$notFound = 0;
$categoryNotFound = 0;
$productNameNotInBackup = 0;
$productNotInCurrent = 0;
$errors = 0;

$categoryStats = [];

foreach ($relationships as $rel) {
    $categoryId = $rel['category_id'];
    $oldProductId = $rel['old_product_id'];

    // Check category exists
    $categoryExists = DB::table('product_categories')->where('id', $categoryId)->exists();
    if (!$categoryExists) {
        $categoryNotFound++;
        continue;
    }

    // Get product name from backup
    if (!isset($oldIdToName[$oldProductId])) {
        $productNameNotInBackup++;
        continue;
    }

    $productName = $oldIdToName[$oldProductId];
    $normalizedName = mb_strtolower(trim($productName));

    // Find current product by name
    if (!isset($nameToId[$normalizedName])) {
        $productNotInCurrent++;
        continue;
    }

    $newProductId = $nameToId[$normalizedName];

    // Insert
    try {
        DB::table('category_product')->insert([
            'category_id' => $categoryId,
            'product_id' => $newProductId
        ]);
        $inserted++;

        if (!isset($categoryStats[$categoryId])) {
            $categoryStats[$categoryId] = 0;
        }
        $categoryStats[$categoryId]++;

        if ($inserted % 500 == 0) {
            echo "  Inserted $inserted relationships...\n";
        }
    } catch (\Exception $e) {
        if (strpos($e->getMessage(), 'Duplicate') === false) {
            $errors++;
        }
    }
}

echo "\n=== RESTORATION COMPLETE ===\n\n";
echo "Summary:\n";
echo "  Total relationships in backup: " . count($relationships) . "\n";
echo "  Successfully inserted: $inserted\n";
echo "  Skipped (category not found): $categoryNotFound\n";
echo "  Skipped (product name not in backup): $productNameNotInBackup\n";
echo "  Skipped (product not in current DB): $productNotInCurrent\n";
echo "  Errors: $errors\n";
echo "  Categories updated: " . count($categoryStats) . "\n";

// Final stats
echo "\n=== FINAL DATABASE STATS ===\n";
$totalProducts = DB::table('products')->count();
$productsWithCategories = DB::table('products')
    ->join('category_product', 'products.id', '=', 'category_product.product_id')
    ->distinct()
    ->count('products.id');

echo "Total products: $totalProducts\n";
echo "Products with categories: $productsWithCategories\n";
echo "Products without categories: " . ($totalProducts - $productsWithCategories) . "\n";
echo "Total category relationships: " . DB::table('category_product')->count() . "\n";

// Sample categories
echo "\n=== TOP 10 CATEGORIES BY PRODUCT COUNT ===\n";
$topCategories = DB::table('category_product')
    ->select('category_id', DB::raw('COUNT(*) as product_count'))
    ->groupBy('category_id')
    ->orderBy('product_count', 'desc')
    ->limit(10)
    ->get();

foreach ($topCategories as $cat) {
    $catName = DB::table('product_categories')->where('id', $cat->category_id)->value('category_name');
    echo "Category {$cat->category_id} ({$catName}): {$cat->product_count} products\n";
}

echo "\n=== SPECIFIC CATEGORIES CHECK ===\n";
$testCategories = [84, 85, 86, 88, 89, 170];
foreach ($testCategories as $catId) {
    $count = DB::table('category_product')->where('category_id', $catId)->count();
    $catName = DB::table('product_categories')->where('id', $catId)->value('category_name');
    echo "Category $catId ($catName): $count products\n";
}

echo "\nDone!\n";
