<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== COMPREHENSIVE CATEGORY RESTORATION FROM LIVE DATABASE ===\n\n";

// Step 1: Build a map of old product IDs to SKUs from the backup
echo "Step 1: Parsing live products backup to build SKU mapping...\n";

$productsFile = __DIR__ . '/public/products.sql';
$pivotFile = __DIR__ . '/public/product_category_product .sql';

if (!file_exists($productsFile)) {
    die("Error: products.sql not found at: $productsFile\n");
}

if (!file_exists($pivotFile)) {
    die("Error: product_category_product .sql not found at: $pivotFile\n");
}

// Parse products file to get ID -> SKU mapping
echo "  Reading products.sql (this may take a moment)...\n";
$productsContent = file_get_contents($productsFile);

// Extract INSERT statements
preg_match_all('/\((\d+),\s*\'[^\']*\',\s*[^,]*,\s*[^,]*,\s*[^,]*,\s*[^,]*,\s*\'([^\']*)\'/s', $productsContent, $matches, PREG_SET_ORDER);

$oldIdToSku = [];
$skuCount = 0;

foreach ($matches as $match) {
    $oldId = $match[1];
    $sku = $match[2];

    if (!empty($sku) && $sku !== 'NULL') {
        $oldIdToSku[$oldId] = $sku;
        $skuCount++;
    }
}

echo "  Found " . count($oldIdToSku) . " products with SKUs in backup\n\n";

// Step 2: Build map of SKU -> current product ID
echo "Step 2: Building SKU to current product ID mapping...\n";

$currentProducts = DB::table('products')
    ->whereNotNull('sku')
    ->where('sku', '!=', '')
    ->get(['id', 'sku', 'name']);

$skuToNewId = [];
foreach ($currentProducts as $product) {
    $skuToNewId[$product->sku] = $product->id;
}

echo "  Found " . count($skuToNewId) . " products with SKUs in current database\n\n";

// Step 3: Parse pivot table and restore relationships
echo "Step 3: Parsing category-product relationships from live backup...\n";

$pivotContent = file_get_contents($pivotFile);

// Extract INSERT statements
preg_match_all('/INSERT INTO `ec_product_category_product` \(`category_id`, `product_id`\) VALUES\s*(.*?);/s', $pivotContent, $pivotMatches);

if (empty($pivotMatches[1])) {
    die("Error: No INSERT statements found in pivot table backup\n");
}

$relationships = [];
$totalParsed = 0;

foreach ($pivotMatches[1] as $valuesBlock) {
    // Split into individual rows
    $rows = preg_split('/\),\s*\(/', $valuesBlock);

    foreach ($rows as $row) {
        // Clean up
        $row = trim($row);
        $row = ltrim($row, '(');
        $row = rtrim($row, ')');
        $row = rtrim($row, ',');

        if (empty($row)) continue;

        // Parse category_id and product_id
        if (preg_match('/(\d+),\s*(\d+)/', $row, $match)) {
            $categoryId = $match[1];
            $oldProductId = $match[2];

            $relationships[] = [
                'category_id' => $categoryId,
                'old_product_id' => $oldProductId
            ];
            $totalParsed++;
        }
    }
}

echo "  Parsed $totalParsed category-product relationships\n\n";

// Step 4: Map old product IDs to new IDs via SKU and insert
echo "Step 4: Mapping and inserting relationships...\n";

$inserted = 0;
$skipped = 0;
$categoryNotFound = 0;
$productNotMapped = 0;
$productNotFound = 0;
$alreadyExists = 0;

// Clear existing relationships first
echo "  Clearing existing category_product relationships...\n";
DB::table('category_product')->truncate();
echo "  Cleared.\n\n";

$processedCategories = [];

foreach ($relationships as $rel) {
    $categoryId = $rel['category_id'];
    $oldProductId = $rel['old_product_id'];

    // Check if category exists
    $categoryExists = DB::table('product_categories')->where('id', $categoryId)->exists();
    if (!$categoryExists) {
        $categoryNotFound++;
        continue;
    }

    // Map old product ID to SKU
    if (!isset($oldIdToSku[$oldProductId])) {
        $productNotMapped++;
        continue;
    }

    $sku = $oldIdToSku[$oldProductId];

    // Map SKU to new product ID
    if (!isset($skuToNewId[$sku])) {
        $productNotFound++;
        continue;
    }

    $newProductId = $skuToNewId[$sku];

    // Insert relationship
    try {
        DB::table('category_product')->insert([
            'category_id' => $categoryId,
            'product_id' => $newProductId
        ]);
        $inserted++;

        $processedCategories[$categoryId] = true;

        if ($inserted % 500 == 0) {
            echo "  Inserted $inserted relationships...\n";
        }
    } catch (\Exception $e) {
        // Duplicate entry is OK, skip it
        if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
            $alreadyExists++;
        } else {
            echo "  Error: " . $e->getMessage() . "\n";
            $skipped++;
        }
    }
}

echo "\n=== RESTORATION COMPLETE ===\n\n";

echo "Summary:\n";
echo "  Total relationships in backup: $totalParsed\n";
echo "  Successfully inserted: $inserted\n";
echo "  Already existed: $alreadyExists\n";
echo "  Skipped (category not found): $categoryNotFound\n";
echo "  Skipped (product SKU not in backup): $productNotMapped\n";
echo "  Skipped (product not in current DB): $productNotFound\n";
echo "  Other errors: $skipped\n";
echo "  Unique categories processed: " . count($processedCategories) . "\n";

// Show final stats
echo "\n=== FINAL DATABASE STATS ===\n";
$totalProducts = DB::table('products')->count();
$productsWithCategories = DB::table('products')
    ->join('category_product', 'products.id', '=', 'category_product.product_id')
    ->distinct()
    ->count('products.id');
$productsWithoutCategories = $totalProducts - $productsWithCategories;

echo "Total products: $totalProducts\n";
echo "Products with categories: $productsWithCategories\n";
echo "Products without categories: $productsWithoutCategories\n";

echo "\n=== SAMPLE CATEGORIES ===\n";
$sampleCategories = DB::table('product_categories')
    ->whereIn('id', [84, 85, 86, 88, 89, 170])
    ->get(['id', 'name']);

foreach ($sampleCategories as $cat) {
    $count = DB::table('category_product')->where('category_id', $cat->id)->count();
    echo "Category {$cat->id} ({$cat->name}): $count products\n";
}

echo "\nDone!\n";
