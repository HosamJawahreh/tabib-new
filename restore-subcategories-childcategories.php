<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== RESTORING SUBCATEGORY AND CHILDCATEGORY RELATIONSHIPS ===\n\n";

$pivotFile = __DIR__ . '/public/product_category_product .sql';
$productsFile = __DIR__ . '/public/products.sql';

// Step 1: Build product name mapping
echo "Step 1: Building product name mappings...\n";

$currentProducts = DB::table('products')->get(['id', 'name']);
$nameToId = [];
foreach ($currentProducts as $product) {
    $normalizedName = mb_strtolower(trim($product->name));
    $nameToId[$normalizedName] = $product->id;
}
echo "  Current products: " . count($nameToId) . "\n";

// Extract product names from backup
$productsContent = file_get_contents($productsFile);
preg_match_all('/\((\d+),\s*\'([^\']+)\'/', $productsContent, $matches, PREG_SET_ORDER);

$oldIdToName = [];
foreach ($matches as $match) {
    $oldIdToName[$match[1]] = $match[2];
}
echo "  Backup products: " . count($oldIdToName) . "\n\n";

// Step 2: Get all subcategory and childcategory IDs
echo "Step 2: Getting subcategory and childcategory IDs...\n";

$subcategoryIds = DB::table('subcategories')->pluck('id')->toArray();
$childcategoryIds = DB::table('childcategories')->pluck('id')->toArray();

echo "  Subcategories: " . count($subcategoryIds) . "\n";
echo "  Child categories: " . count($childcategoryIds) . "\n\n";

// Step 3: Parse pivot table and restore subcategory/childcategory relationships
echo "Step 3: Parsing and restoring relationships...\n";

$pivotContent = file_get_contents($pivotFile);
preg_match_all('/INSERT INTO `ec_product_category_product` \(`category_id`, `product_id`\) VALUES\s*(.*?);/s', $pivotContent, $pivotMatches);

$relationships = [];
foreach ($pivotMatches[1] as $valuesBlock) {
    $rows = preg_split('/\),\s*\(/', $valuesBlock);

    foreach ($rows as $row) {
        $row = trim($row, ' (),');
        if (empty($row)) continue;

        if (preg_match('/(\d+),\s*(\d+)/', $row, $match)) {
            $categoryId = (int)$match[1];
            $oldProductId = (int)$match[2];

            // Only process if category_id is a subcategory or childcategory
            if (in_array($categoryId, $subcategoryIds) || in_array($categoryId, $childcategoryIds)) {
                $relationships[] = [
                    'category_id' => $categoryId,
                    'old_product_id' => $oldProductId,
                    'type' => in_array($categoryId, $subcategoryIds) ? 'subcategory' : 'childcategory'
                ];
            }
        }
    }
}

echo "  Found " . count($relationships) . " subcategory/childcategory relationships\n\n";

// Step 4: Insert relationships
echo "Step 4: Inserting relationships...\n";

$inserted = 0;
$skipped = 0;
$productNotFound = 0;
$categoryNotFound = 0;

$subcategoryStats = [];
$childcategoryStats = [];

foreach ($relationships as $rel) {
    $categoryId = $rel['category_id'];
    $oldProductId = $rel['old_product_id'];
    $type = $rel['type'];

    // Verify category still exists
    if ($type === 'subcategory') {
        $exists = DB::table('subcategories')->where('id', $categoryId)->exists();
    } else {
        $exists = DB::table('childcategories')->where('id', $categoryId)->exists();
    }

    if (!$exists) {
        $categoryNotFound++;
        continue;
    }

    // Get product name from backup
    if (!isset($oldIdToName[$oldProductId])) {
        $skipped++;
        continue;
    }

    $productName = $oldIdToName[$oldProductId];
    $normalizedName = mb_strtolower(trim($productName));

    // Find current product by name
    if (!isset($nameToId[$normalizedName])) {
        $productNotFound++;
        continue;
    }

    $newProductId = $nameToId[$normalizedName];

    // Check if relationship already exists
    $exists = DB::table('category_product')
        ->where('category_id', $categoryId)
        ->where('product_id', $newProductId)
        ->exists();

    if ($exists) {
        $skipped++;
        continue;
    }

    // Insert
    try {
        DB::table('category_product')->insert([
            'category_id' => $categoryId,
            'product_id' => $newProductId
        ]);
        $inserted++;

        if ($type === 'subcategory') {
            if (!isset($subcategoryStats[$categoryId])) {
                $subcategoryStats[$categoryId] = 0;
            }
            $subcategoryStats[$categoryId]++;
        } else {
            if (!isset($childcategoryStats[$categoryId])) {
                $childcategoryStats[$categoryId] = 0;
            }
            $childcategoryStats[$categoryId]++;
        }

        if ($inserted % 100 == 0) {
            echo "  Inserted $inserted relationships...\n";
        }
    } catch (\Exception $e) {
        if (strpos($e->getMessage(), 'Duplicate') === false) {
            echo "  Error: " . $e->getMessage() . "\n";
        }
        $skipped++;
    }
}

echo "\n=== RESTORATION COMPLETE ===\n\n";
echo "Summary:\n";
echo "  Total found: " . count($relationships) . "\n";
echo "  Successfully inserted: $inserted\n";
echo "  Skipped (already exists/other): $skipped\n";
echo "  Product not found: $productNotFound\n";
echo "  Category not found: $categoryNotFound\n";
echo "  Subcategories updated: " . count($subcategoryStats) . "\n";
echo "  Child categories updated: " . count($childcategoryStats) . "\n";

// Show sample subcategories
echo "\n=== SAMPLE SUBCATEGORIES ===\n";
$sampleSubcats = [123, 124, 125, 126, 127];
foreach ($sampleSubcats as $subcatId) {
    $count = DB::table('category_product')->where('category_id', $subcatId)->count();
    $subcatName = DB::table('subcategories')->where('id', $subcatId)->value('name');
    if ($count > 0) {
        echo "Subcategory $subcatId ($subcatName): $count products\n";
    }
}

echo "\n=== FINAL STATS ===\n";
$totalRelationships = DB::table('category_product')->count();
echo "Total category relationships: $totalRelationships\n";

echo "\nDone!\n";
