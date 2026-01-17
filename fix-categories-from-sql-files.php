<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

/**
 * PROFESSIONAL CATEGORY-PRODUCT CORRECTION SYSTEM
 *
 * This script analyzes the 3 SQL files provided:
 * 1. ec_product_categories.sql - Category definitions
 * 2. ec_product_category_product.sql - Product-Category relationships
 * 3. ec_products.sql - Product definitions
 *
 * It matches products by NAME (not ID) to handle ID differences between databases.
 */

echo "\n";
echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║   PROFESSIONAL SQL-BASED CATEGORY CORRECTION SYSTEM            ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// Step 1: Read and parse SQL files
echo "📂 Step 1: Reading SQL files...\n\n";

$sqlFiles = [
    'categories' => 'public/ec_product_categories (1).sql',
    'relationships' => 'public/ec_product_category_product.sql',
    'products' => 'public/ec_products.sql'
];

$sqlData = [];
$missingFiles = [];

foreach ($sqlFiles as $key => $file) {
    $filePath = __DIR__ . '/' . $file;
    if (file_exists($filePath)) {
        $sqlData[$key] = file_get_contents($filePath);
        echo "  ✓ Loaded: {$file}\n";
    } else {
        $missingFiles[] = $file;
        echo "  ✗ Missing: {$file}\n";
    }
}

if (!empty($missingFiles)) {
    echo "\n❌ ERROR: Missing SQL files:\n";
    foreach ($missingFiles as $file) {
        echo "  • {$file}\n";
    }
    echo "\nPlease ensure all 3 SQL files are in the project root directory.\n";
    exit(1);
}

// Step 2: Parse categories from SQL
echo "\n📊 Step 2: Parsing categories from SQL file...\n\n";

function parseSqlInserts($sql, $tableName) {
    $pattern = "/INSERT INTO `{$tableName}`.*?VALUES\s*(.*?);/is";
    preg_match_all($pattern, $sql, $matches);

    $allValues = [];
    foreach ($matches[1] as $valueString) {
        // Split by '),(' to separate multiple rows
        $rows = preg_split('/\),\s*\(/s', $valueString);
        foreach ($rows as $row) {
            $row = trim($row, '() ');
            $allValues[] = $row;
        }
    }

    return $allValues;
}

function parseRow($row) {
    $values = [];
    $current = '';
    $inQuotes = false;
    $escapeNext = false;

    for ($i = 0; $i < strlen($row); $i++) {
        $char = $row[$i];

        if ($escapeNext) {
            $current .= $char;
            $escapeNext = false;
            continue;
        }

        if ($char === '\\') {
            $escapeNext = true;
            continue;
        }

        if ($char === "'" && !$escapeNext) {
            $inQuotes = !$inQuotes;
            continue;
        }

        if ($char === ',' && !$inQuotes) {
            $values[] = trim($current) === 'NULL' ? null : $current;
            $current = '';
            continue;
        }

        $current .= $char;
    }

    if ($current !== '') {
        $values[] = trim($current) === 'NULL' ? null : $current;
    }

    return $values;
}

// Parse categories
$categoriesFromSql = [];
$categoryRows = parseSqlInserts($sqlData['categories'], 'ec_product_categories');

foreach ($categoryRows as $row) {
    $values = parseRow($row);
    if (count($values) >= 2) {
        $id = $values[0];
        $name = $values[1];
        $categoriesFromSql[$id] = $name;
    }
}

echo "  ✓ Found " . count($categoriesFromSql) . " categories in SQL file\n";

// Step 3: Parse products from SQL
echo "\n📦 Step 3: Parsing products from SQL file...\n\n";

$productsFromSql = [];
$productRows = parseSqlInserts($sqlData['products'], 'ec_products');

foreach ($productRows as $row) {
    $values = parseRow($row);
    if (count($values) >= 2) {
        $id = $values[0];
        $name = $values[1];
        $productsFromSql[$id] = $name;
    }
}

echo "  ✓ Found " . count($productsFromSql) . " products in SQL file\n";

// Step 4: Parse relationships from SQL
echo "\n🔗 Step 4: Parsing category-product relationships from SQL file...\n\n";

$relationshipsFromSql = [];
$relationshipRows = parseSqlInserts($sqlData['relationships'], 'ec_product_category_product');

foreach ($relationshipRows as $row) {
    $values = parseRow($row);
    if (count($values) >= 2) {
        $categoryId = $values[0];
        $productId = $values[1];

        if (!isset($relationshipsFromSql[$productId])) {
            $relationshipsFromSql[$productId] = [];
        }
        $relationshipsFromSql[$productId][] = $categoryId;
    }
}

echo "  ✓ Found " . count($relationshipsFromSql) . " products with category relationships\n";

// Step 5: Get current database state
echo "\n🗄️  Step 5: Analyzing current database...\n\n";

$dbCategories = DB::table('categories')
    ->where('status', 1)
    ->select('id', 'name')
    ->get()
    ->keyBy('name');

$dbProducts = DB::table('products')
    ->where('status', 1)
    ->select('id', 'name')
    ->get()
    ->keyBy('name');

echo "  ✓ Database has " . $dbCategories->count() . " active categories\n";
echo "  ✓ Database has " . $dbProducts->count() . " active products\n";

// Step 6: Build mapping by matching names
echo "\n🔍 Step 6: Building product-category mapping by name matching...\n\n";

$corrections = [];
$matched = 0;
$notFound = [
    'products' => [],
    'categories' => []
];

foreach ($relationshipsFromSql as $productId => $categoryIds) {
    // Get product name from SQL
    if (!isset($productsFromSql[$productId])) {
        continue;
    }

    $productName = $productsFromSql[$productId];

    // Find matching product in database by name
    $dbProduct = $dbProducts->get($productName);

    if (!$dbProduct) {
        $notFound['products'][] = $productName;
        continue;
    }

    // For each category ID in SQL
    foreach ($categoryIds as $categoryId) {
        if (!isset($categoriesFromSql[$categoryId])) {
            continue;
        }

        $categoryName = $categoriesFromSql[$categoryId];

        // Find matching category in database by name
        $dbCategory = $dbCategories->get($categoryName);

        if (!$dbCategory) {
            if (!in_array($categoryName, $notFound['categories'])) {
                $notFound['categories'][] = $categoryName;
            }
            continue;
        }

        // Store the correction
        if (!isset($corrections[$dbProduct->id])) {
            $corrections[$dbProduct->id] = [
                'name' => $productName,
                'categories' => []
            ];
        }

        $corrections[$dbProduct->id]['categories'][] = $dbCategory->id;
        $matched++;
    }
}

echo "  ✓ Successfully matched {$matched} product-category relationships\n";
echo "  ✓ Products to update: " . count($corrections) . "\n";

if (!empty($notFound['products'])) {
    echo "\n  ⚠️  Products not found in database: " . count($notFound['products']) . "\n";
    if (count($notFound['products']) <= 10) {
        foreach ($notFound['products'] as $name) {
            echo "    • {$name}\n";
        }
    } else {
        for ($i = 0; $i < 10; $i++) {
            echo "    • {$notFound['products'][$i]}\n";
        }
        echo "    ... and " . (count($notFound['products']) - 10) . " more\n";
    }
}

if (!empty($notFound['categories'])) {
    echo "\n  ⚠️  Categories not found in database: " . count($notFound['categories']) . "\n";
    foreach ($notFound['categories'] as $name) {
        echo "    • {$name}\n";
    }
}

// Step 7: Generate SQL corrections
echo "\n🔧 Step 7: Generating correction SQL...\n\n";

$sqlStatements = [];
$sqlStatements[] = "-- Category-Product Corrections Generated from SQL Files";
$sqlStatements[] = "-- Generated: " . date('Y-m-d H:i:s');
$sqlStatements[] = "-- Products to update: " . count($corrections);
$sqlStatements[] = "";
$sqlStatements[] = "START TRANSACTION;";
$sqlStatements[] = "";

foreach ($corrections as $productId => $data) {
    $sqlStatements[] = "-- Product: {$data['name']} (ID: {$productId})";
    $sqlStatements[] = "DELETE FROM category_product WHERE product_id = {$productId};";

    foreach ($data['categories'] as $categoryId) {
        $sqlStatements[] = "INSERT INTO category_product (category_id, product_id) VALUES ({$categoryId}, {$productId});";
    }

    $sqlStatements[] = "";
}

$sqlStatements[] = "COMMIT;";

$sqlFile = 'fix-categories-from-sql.sql';
file_put_contents($sqlFile, implode("\n", $sqlStatements));

echo "  ✓ SQL file saved: {$sqlFile}\n";

// Step 8: Show statistics
echo "\n📈 Step 8: Correction Statistics\n\n";

$categoryCount = [];
foreach ($corrections as $data) {
    foreach ($data['categories'] as $catId) {
        $categoryName = $dbCategories->first(function($cat) use ($catId) {
            return $cat->id == $catId;
        })->name ?? 'Unknown';

        if (!isset($categoryCount[$categoryName])) {
            $categoryCount[$categoryName] = 0;
        }
        $categoryCount[$categoryName]++;
    }
}

arsort($categoryCount);

echo "Products per category (top 15):\n";
$count = 0;
foreach ($categoryCount as $catName => $prodCount) {
    if ($count++ >= 15) break;
    echo "  • {$catName}: {$prodCount} products\n";
}

// Step 9: Ask for confirmation
echo "\n";
echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║   READY TO APPLY CORRECTIONS                                    ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

echo "Summary:\n";
echo "  • Products to correct: " . count($corrections) . "\n";
echo "  • Total relationships: {$matched}\n";
echo "  • SQL file: {$sqlFile}\n\n";

echo "What would you like to do?\n";
echo "  1. Apply corrections automatically (RECOMMENDED)\n";
echo "  2. Exit and review SQL file manually\n\n";

echo "Enter choice (1 or 2): ";
$choice = trim(fgets(STDIN));

if ($choice === '1') {
    echo "\n🚀 Applying corrections...\n\n";

    DB::beginTransaction();

    try {
        $deletedCount = 0;
        $insertedCount = 0;

        foreach ($corrections as $productId => $data) {
            // Remove old relationships
            $deleted = DB::table('category_product')
                ->where('product_id', $productId)
                ->delete();
            $deletedCount += $deleted;

            // Add new relationships
            foreach ($data['categories'] as $categoryId) {
                DB::table('category_product')->insert([
                    'category_id' => $categoryId,
                    'product_id' => $productId
                ]);
                $insertedCount++;
            }
        }

        DB::commit();

        echo "  ✓ Deleted {$deletedCount} old relationships\n";
        echo "  ✓ Inserted {$insertedCount} new relationships\n\n";

        echo "✅ SUCCESS! All corrections applied!\n\n";

        $finalStats = DB::table('category_product')->count();
        echo "Final Statistics:\n";
        echo "  • Total category-product relations: {$finalStats}\n";
        echo "  • Products updated: " . count($corrections) . "\n\n";

        echo "🎉 Categories are now correctly mapped from your SQL files!\n";
        echo "   Products will appear in their correct categories on the homepage.\n\n";

    } catch (\Exception $e) {
        DB::rollBack();
        echo "\n❌ ERROR: " . $e->getMessage() . "\n";
        echo "   No changes were made to the database.\n";
        echo "   Please review the SQL file manually: {$sqlFile}\n\n";
    }

} else {
    echo "\n✓ Corrections saved to {$sqlFile}\n";
    echo "  Review and apply manually when ready.\n\n";
}

echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║   PROCESS COMPLETE                                              ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";
