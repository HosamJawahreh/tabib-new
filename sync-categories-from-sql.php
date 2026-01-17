<?php
/**
 * PROFESSIONAL CATEGORY-PRODUCT SYNC FROM SQL FILES
 * Syncs live database with SQL export files by matching product/category names
 */

require __DIR__.'/vendor/autoload.php';

use Illuminate\Support\Facades\DB;

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║   PROFESSIONAL CATEGORY-PRODUCT SYNC FROM SQL FILES            ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// File paths
$sqlFiles = [
    'categories' => __DIR__.'/public/product_categories.sql',
    'products' => __DIR__.'/public/products.sql',
    'relations' => __DIR__.'/public/product_category_product .sql'
];

// Verify files exist
echo "📋 Step 1: Verifying SQL files...\n\n";
foreach ($sqlFiles as $type => $file) {
    if (!file_exists($file)) {
        die("❌ ERROR: File not found: $file\n");
    }
    $size = filesize($file);
    echo "  ✓ $type: " . basename($file) . " (" . number_format($size/1024, 2) . " KB)\n";
}

echo "\n🔍 Step 2: Parsing SQL files...\n\n";

// Parse categories from SQL
function parseCategories($file) {
    $content = file_get_contents($file);
    $categories = [];

    // Match INSERT INTO statements
    preg_match_all("/INSERT INTO `ec_product_categories`.*?VALUES\s*(.*?);/s", $content, $matches);

    if (!empty($matches[1])) {
        foreach ($matches[1] as $valuesBlock) {
            // Match individual value tuples
            preg_match_all("/\((\d+),\s*'([^']+)',[^)]+\)/", $valuesBlock, $tuples);

            for ($i = 0; $i < count($tuples[1]); $i++) {
                $id = $tuples[1][$i];
                $name = $tuples[2][$i];
                $categories[$id] = $name;
            }
        }
    }

    return $categories;
}

// Parse products from SQL
function parseProducts($file) {
    $content = file_get_contents($file);
    $products = [];

    // Match INSERT INTO statements
    preg_match_all("/INSERT INTO `ec_products`.*?VALUES\s*(.*?);/s", $content, $matches);

    if (!empty($matches[1])) {
        foreach ($matches[1] as $valuesBlock) {
            // Match individual value tuples - only extract ID and name
            preg_match_all("/\((\d+),\s*'([^']+)'/", $valuesBlock, $tuples);

            for ($i = 0; $i < count($tuples[1]); $i++) {
                $id = $tuples[1][$i];
                $name = $tuples[2][$i];
                $products[$id] = $name;
            }
        }
    }

    return $products;
}

// Parse category-product relationships from SQL
function parseRelations($file) {
    $content = file_get_contents($file);
    $relations = [];

    // Match INSERT INTO statements
    preg_match_all("/INSERT INTO `ec_product_category_product`.*?VALUES\s*(.*?);/s", $content, $matches);

    if (!empty($matches[1])) {
        foreach ($matches[1] as $valuesBlock) {
            // Match individual value tuples (category_id, product_id)
            preg_match_all("/\((\d+),\s*(\d+)\)/", $valuesBlock, $tuples);

            for ($i = 0; $i < count($tuples[1]); $i++) {
                $categoryId = $tuples[1][$i];
                $productId = $tuples[2][$i];

                if (!isset($relations[$productId])) {
                    $relations[$productId] = [];
                }
                $relations[$productId][] = $categoryId;
            }
        }
    }

    return $relations;
}

// Parse all files
$categories = parseCategories($sqlFiles['categories']);
$products = parseProducts($sqlFiles['products']);
$relations = parseRelations($sqlFiles['relations']);

echo "  ✓ Categories parsed: " . count($categories) . "\n";
echo "  ✓ Products parsed: " . count($products) . "\n";
echo "  ✓ Relationships parsed: " . count($relations) . " products with categories\n";

// Calculate total relationships
$totalRelations = 0;
foreach ($relations as $productRelations) {
    $totalRelations += count($productRelations);
}
echo "  ✓ Total category-product links: " . $totalRelations . "\n";

echo "\n🔄 Step 3: Analyzing database vs SQL files...\n\n";

// Get current database state
$dbCategories = DB::table('categories')->where('status', 1)->pluck('name', 'id')->toArray();
$dbProducts = DB::table('products')->where('status', 1)->pluck('name', 'id')->toArray();

echo "  📊 Current Database:\n";
echo "     • Categories: " . count($dbCategories) . "\n";
echo "     • Products: " . count($dbProducts) . "\n";
echo "     • Current relationships: " . DB::table('category_product')->count() . "\n\n";

echo "  📊 SQL Files Data:\n";
echo "     • Categories: " . count($categories) . "\n";
echo "     • Products: " . count($products) . "\n";
echo "     • Target relationships: " . $totalRelations . "\n\n";

// Build category ID mapping (SQL ID -> DB ID)
echo "🔗 Step 4: Mapping category IDs (SQL -> Database)...\n\n";

$categoryIdMap = [];
$unmappedCategories = [];

foreach ($categories as $sqlId => $categoryName) {
    // Try to find matching category in database by name
    $found = false;
    foreach ($dbCategories as $dbId => $dbName) {
        if (trim($dbName) === trim($categoryName)) {
            $categoryIdMap[$sqlId] = $dbId;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $unmappedCategories[$sqlId] = $categoryName;
    }
}

echo "  ✓ Mapped categories: " . count($categoryIdMap) . "/" . count($categories) . "\n";

if (!empty($unmappedCategories)) {
    echo "  ⚠️  Unmapped categories (" . count($unmappedCategories) . "):\n";
    foreach (array_slice($unmappedCategories, 0, 10) as $sqlId => $name) {
        echo "     • [SQL ID: $sqlId] $name\n";
    }
    if (count($unmappedCategories) > 10) {
        echo "     ... and " . (count($unmappedCategories) - 10) . " more\n";
    }
}

// Build product ID mapping (SQL ID -> DB ID)
echo "\n🔗 Step 5: Mapping product IDs (SQL -> Database)...\n\n";

$productIdMap = [];
$unmappedProducts = [];

foreach ($products as $sqlId => $productName) {
    // Try to find matching product in database by name
    $found = false;
    foreach ($dbProducts as $dbId => $dbName) {
        if (trim($dbName) === trim($productName)) {
            $productIdMap[$sqlId] = $dbId;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $unmappedProducts[$sqlId] = $productName;
    }
}

echo "  ✓ Mapped products: " . count($productIdMap) . "/" . count($products) . "\n";

if (!empty($unmappedProducts)) {
    echo "  ⚠️  Unmapped products (" . count($unmappedProducts) . "):\n";
    foreach (array_slice($unmappedProducts, 0, 10) as $sqlId => $name) {
        echo "     • [SQL ID: $sqlId] $name\n";
    }
    if (count($unmappedProducts) > 10) {
        echo "     ... and " . (count($unmappedProducts) - 10) . " more\n";
    }
}

// Build new relationships using mapped IDs
echo "\n🔧 Step 6: Building corrected relationships...\n\n";

$newRelations = [];
$skippedRelations = 0;
$uniqueCheck = []; // To prevent duplicates

foreach ($relations as $sqlProductId => $sqlCategoryIds) {
    // Check if product exists in our mapping
    if (!isset($productIdMap[$sqlProductId])) {
        $skippedRelations += count($sqlCategoryIds);
        continue;
    }

    $dbProductId = $productIdMap[$sqlProductId];

    foreach ($sqlCategoryIds as $sqlCategoryId) {
        // Check if category exists in our mapping
        if (!isset($categoryIdMap[$sqlCategoryId])) {
            $skippedRelations++;
            continue;
        }

        $dbCategoryId = $categoryIdMap[$sqlCategoryId];

        // Check for duplicates
        $key = "$dbCategoryId-$dbProductId";
        if (isset($uniqueCheck[$key])) {
            continue; // Skip duplicate
        }

        $uniqueCheck[$key] = true;
        $newRelations[] = [
            'category_id' => $dbCategoryId,
            'product_id' => $dbProductId
        ];
    }
}

echo "  ✓ Valid relationships to insert: " . count($newRelations) . "\n";
echo "  ⚠️  Skipped (unmapped IDs): " . $skippedRelations . "\n";

// Generate statistics
echo "\n📈 Step 7: Statistics Summary\n\n";

$productCategoryCounts = [];
foreach ($newRelations as $rel) {
    $catId = $rel['category_id'];
    if (!isset($productCategoryCounts[$catId])) {
        $productCategoryCounts[$catId] = 0;
    }
    $productCategoryCounts[$catId]++;
}

arsort($productCategoryCounts);
$topCategories = array_slice($productCategoryCounts, 0, 15, true);

echo "  Top 15 categories by product count:\n";
foreach ($topCategories as $catId => $count) {
    $catName = $dbCategories[$catId] ?? 'Unknown';
    echo "     • $catName: $count products\n";
}

// Generate SQL file
echo "\n💾 Step 8: Generating SQL file...\n\n";

$sqlFile = __DIR__.'/fix-categories-from-sql.sql';
$sql = "-- Category-Product Sync SQL\n";
$sql .= "-- Generated: " . date('Y-m-d H:i:s') . "\n\n";
$sql .= "-- Remove all current relationships\n";
$sql .= "DELETE FROM category_product;\n\n";
$sql .= "-- Insert correct relationships from SQL files\n";
$sql .= "INSERT INTO category_product (category_id, product_id) VALUES\n";

$values = [];
foreach ($newRelations as $rel) {
    $values[] = "({$rel['category_id']}, {$rel['product_id']})";
}

$sql .= implode(",\n", $values) . ";\n";

file_put_contents($sqlFile, $sql);
echo "  ✓ SQL file saved: " . basename($sqlFile) . "\n";

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║   READY TO APPLY CORRECTIONS                                    ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

echo "Summary:\n";
echo "  • SQL categories: " . count($categories) . " (mapped: " . count($categoryIdMap) . ")\n";
echo "  • SQL products: " . count($products) . " (mapped: " . count($productIdMap) . ")\n";
echo "  • Relationships to sync: " . count($newRelations) . "\n";
echo "  • SQL file generated: fix-categories-from-sql.sql\n\n";

if (empty($newRelations)) {
    echo "⚠️  WARNING: No relationships to sync!\n";
    echo "   This means the SQL files have different product/category IDs than your database.\n\n";
    exit(1);
}

echo "What would you like to do?\n";
echo "  1. Apply corrections automatically (RECOMMENDED)\n";
echo "  2. Exit and review SQL file manually\n\n";
echo "Enter choice (1 or 2): ";

$choice = trim(fgets(STDIN));

if ($choice === '1') {
    echo "\n🚀 Applying corrections...\n\n";

    try {
        DB::beginTransaction();

        // Remove all current relationships
        echo "  • Removing current relationships...\n";
        DB::table('category_product')->delete();

        // Insert new relationships in batches
        echo "  • Inserting correct relationships...\n";
        $chunks = array_chunk($newRelations, 1000);
        foreach ($chunks as $chunk) {
            DB::table('category_product')->insert($chunk);
        }

        DB::commit();

        echo "\n✅ SUCCESS! Database synced with SQL files!\n\n";

        // Final statistics
        $finalCount = DB::table('category_product')->count();
        echo "Final Statistics:\n";
        echo "  • Total relationships: $finalCount\n";
        echo "  • Products with categories: " . DB::table('category_product')->distinct('product_id')->count('product_id') . "\n";
        echo "  • Categories in use: " . DB::table('category_product')->distinct('category_id')->count('category_id') . "\n\n";

        echo "🎉 Your database now matches the SQL export files exactly!\n";

    } catch (\Exception $e) {
        DB::rollBack();
        echo "\n❌ ERROR: " . $e->getMessage() . "\n";
        echo "   No changes were made to the database.\n\n";
    }

} else {
    echo "\n✅ SQL file saved. You can review and apply it manually.\n\n";
}

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║   PROCESS COMPLETE                                              ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";
