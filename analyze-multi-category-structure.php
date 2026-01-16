<?php
/**
 * Analyze Multi-Category Structure Migration
 * Understand the old system and plan migration
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "================================================================================\n";
echo "MULTI-CATEGORY STRUCTURE ANALYSIS\n";
echo "================================================================================\n\n";

echo "📊 Step 1: Checking Current Database Structure\n";
echo "--------------------------------------------------------------------------------\n\n";

// Check if we have the pivot table
$hasPivotTable = Schema::hasTable('category_product');
$hasOldPivotTable = Schema::hasTable('product_category');

echo "Current Tables:\n";
echo "  ✓ products table: " . (Schema::hasTable('products') ? 'EXISTS' : 'NOT FOUND') . "\n";
echo "  ✓ categories table: " . (Schema::hasTable('categories') ? 'EXISTS' : 'NOT FOUND') . "\n";
echo "  • category_product pivot: " . ($hasPivotTable ? 'EXISTS' : 'NOT FOUND') . "\n";
echo "  • product_category pivot: " . ($hasOldPivotTable ? 'EXISTS' : 'NOT FOUND') . "\n";

// Check products table structure
echo "\nProducts Table Columns:\n";
$productColumns = Schema::getColumnListing('products');
foreach ($productColumns as $col) {
    if (strpos($col, 'category') !== false) {
        echo "  • $col\n";
    }
}

echo "\n\n📊 Step 2: Analyzing Old Database Files\n";
echo "--------------------------------------------------------------------------------\n\n";

// Parse categories from SQL file
echo "Reading categories from: public/ec_product_categories (1).sql\n";
$categoriesFile = file_get_contents(__DIR__ . '/public/ec_product_categories (1).sql');
preg_match_all('/INSERT INTO.*?VALUES\s+(.*?);/s', $categoriesFile, $categoryMatches);

$oldCategories = [];
if (!empty($categoryMatches[1][0])) {
    $values = $categoryMatches[1][0];
    preg_match_all('/\((\d+),\s*\'([^\']+)\'/', $values, $catData);

    foreach ($catData[1] as $idx => $catId) {
        $oldCategories[$catId] = $catData[2][$idx];
    }
}

echo "Found " . count($oldCategories) . " categories in old database\n";
echo "Sample categories:\n";
$sampleCount = 0;
foreach ($oldCategories as $id => $name) {
    echo "  ID $id: $name\n";
    if (++$sampleCount >= 10) break;
}

// Parse product-category relationships
echo "\n\nReading relationships from: public/ec_product_category_product.sql\n";
$relationshipsFile = file_get_contents(__DIR__ . '/public/ec_product_category_product.sql');
preg_match_all('/\((\d+),\s*(\d+)\)/', $relationshipsFile, $relMatches);

$relationships = [];
$productCategoryCounts = [];

for ($i = 0; $i < count($relMatches[1]); $i++) {
    $categoryId = $relMatches[1][$i];
    $productId = $relMatches[2][$i];

    if (!isset($relationships[$productId])) {
        $relationships[$productId] = [];
        $productCategoryCounts[$productId] = 0;
    }

    $relationships[$productId][] = $categoryId;
    $productCategoryCounts[$productId]++;
}

echo "Found " . count($relationships) . " products with category assignments\n";
echo "Total category-product relationships: " . count($relMatches[1]) . "\n\n";

// Analyze distribution
$distribution = array_count_values($productCategoryCounts);
arsort($distribution);

echo "Category Distribution per Product:\n";
foreach ($distribution as $count => $products) {
    echo "  $count categories: $products products\n";
    if ($count > 5) break; // Show only first few
}

// Find products with most categories
arsort($productCategoryCounts);
echo "\nProducts with Most Categories:\n";
$shown = 0;
foreach ($productCategoryCounts as $productId => $count) {
    echo "  Product ID $productId: $count categories\n";
    if (++$shown >= 5) break;
}

echo "\n\n📊 Step 3: Checking Current Product-Category Assignments\n";
echo "--------------------------------------------------------------------------------\n\n";

// Check current products table
$currentProducts = DB::table('products')
    ->where('status', 1)
    ->select('id', 'name', 'category_id', 'subcategory_id', 'childcategory_id')
    ->limit(5)
    ->get();

echo "Current Products Structure (Sample):\n";
foreach ($currentProducts as $product) {
    echo "  Product: {$product->name}\n";
    echo "    - category_id: " . ($product->category_id ?? 'NULL') . "\n";
    echo "    - subcategory_id: " . ($product->subcategory_id ?? 'NULL') . "\n";
    echo "    - childcategory_id: " . ($product->childcategory_id ?? 'NULL') . "\n";
}

// Check if categories table exists and has data
$categoriesCount = DB::table('categories')->count();
echo "\nCurrent categories table: $categoriesCount categories\n";

echo "\n\n📋 MIGRATION PLAN\n";
echo "================================================================================\n\n";

echo "Old System:\n";
echo "  • Many-to-Many relationship\n";
echo "  • Products can belong to multiple categories\n";
echo "  • Stored in: ec_product_category_product table\n\n";

echo "Current System:\n";
echo "  • Single category per product (category_id, subcategory_id, childcategory_id)\n";
echo "  • Hierarchical structure (3 levels)\n\n";

echo "Migration Steps Needed:\n";
echo "  1. ✅ Create 'category_product' pivot table\n";
echo "  2. ✅ Match old category names to new category IDs\n";
echo "  3. ✅ Match old product IDs to new product names\n";
echo "  4. ✅ Populate pivot table with relationships\n";
echo "  5. ✅ Update Product model to use belongsToMany\n";
echo "  6. ✅ Update FrontendController filtering logic\n";
echo "  7. ✅ Update Admin dashboard product forms\n\n";

echo "⚠️  IMPORTANT NOTES:\n";
echo "  • Old system had " . count($relationships) . " products with categories\n";
echo "  • Average categories per product: " . round(count($relMatches[1]) / count($relationships), 2) . "\n";
echo "  • Some products have " . max($productCategoryCounts) . " categories!\n";
echo "  • Need to keep old category_id fields for backward compatibility\n\n";

echo "================================================================================\n";
