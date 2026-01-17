<?php
/**
 * COMPLETE DATABASE SYNC FROM SQL FILES
 * - Syncs categories for ALL products
 * - Syncs prices (price and previous_price)
 * - Professional and comprehensive solution
 */

require __DIR__.'/vendor/autoload.php';

use Illuminate\Support\Facades\DB;

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║   COMPLETE DATABASE SYNC: CATEGORIES + PRICES                  ║\n";
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
    echo "  ✓ $type: " . basename($file) . "\n";
}

echo "\n🔍 Step 2: Parsing SQL files...\n\n";

// Parse categories from SQL
function parseCategories($file) {
    $content = file_get_contents($file);
    $categories = [];
    
    preg_match_all("/INSERT INTO `ec_product_categories`.*?VALUES\s*(.*?);/s", $content, $matches);
    
    if (!empty($matches[1])) {
        foreach ($matches[1] as $valuesBlock) {
            preg_match_all("/\((\d+),\s*'([^']+)',[^)]+\)/", $valuesBlock, $tuples);
            
            for ($i = 0; $i < count($tuples[1]); $i++) {
                $categories[$tuples[1][$i]] = $tuples[2][$i];
            }
        }
    }
    
    return $categories;
}

// Parse products with prices from SQL
function parseProductsWithPrices($file) {
    $content = file_get_contents($file);
    $products = [];
    
    // Match INSERT statements
    preg_match_all("/INSERT INTO `ec_products`[^(]*\((.*?)\)[^V]*VALUES\s*(.*?);/s", $content, $matches);
    
    if (empty($matches[1]) || empty($matches[2])) {
        return $products;
    }
    
    // Get column names
    $columns = array_map('trim', explode(',', $matches[1][0]));
    $columns = array_map(function($col) { return trim($col, '`'); }, $columns);
    
    // Find price and sale_price column indices
    $idIndex = array_search('id', $columns);
    $nameIndex = array_search('name', $columns);
    $priceIndex = array_search('price', $columns);
    $salePriceIndex = array_search('sale_price', $columns);
    
    foreach ($matches[2] as $valuesBlock) {
        // Split by rows - handle complex parsing
        $rows = [];
        $currentRow = '';
        $depth = 0;
        $inString = false;
        $stringChar = '';
        
        for ($i = 0; $i < strlen($valuesBlock); $i++) {
            $char = $valuesBlock[$i];
            
            if (($char === '"' || $char === "'") && ($i === 0 || $valuesBlock[$i-1] !== '\\')) {
                if (!$inString) {
                    $inString = true;
                    $stringChar = $char;
                } elseif ($char === $stringChar) {
                    $inString = false;
                }
            }
            
            if (!$inString) {
                if ($char === '(') $depth++;
                if ($char === ')') $depth--;
                
                if ($depth === 0 && $char === ',') {
                    $rows[] = trim($currentRow);
                    $currentRow = '';
                    continue;
                }
            }
            
            $currentRow .= $char;
        }
        
        if (!empty($currentRow)) {
            $rows[] = trim($currentRow);
        }
        
        // Parse each row
        foreach ($rows as $row) {
            $row = trim($row, '()');
            
            // Simple regex to extract values
            if (preg_match("/^(\d+),\s*'([^']+)',.*?,\s*(\d+\.?\d*|\d*\.?\d+|NULL),\s*(\d+\.?\d*|\d*\.?\d+|NULL)/", $row, $values)) {
                $id = $values[1];
                $name = $values[2];
                $price = $values[3] === 'NULL' ? null : (float)$values[3];
                $salePrice = $values[4] === 'NULL' ? null : (float)$values[4];
                
                $products[$id] = [
                    'name' => $name,
                    'price' => $price,
                    'sale_price' => $salePrice
                ];
            }
        }
    }
    
    return $products;
}

// Parse category-product relationships
function parseRelations($file) {
    $content = file_get_contents($file);
    $relations = [];
    
    preg_match_all("/INSERT INTO `ec_product_category_product`.*?VALUES\s*(.*?);/s", $content, $matches);
    
    if (!empty($matches[1])) {
        foreach ($matches[1] as $valuesBlock) {
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
echo "  • Parsing categories...\n";
$categories = parseCategories($sqlFiles['categories']);

echo "  • Parsing products with prices...\n";
$products = parseProductsWithPrices($sqlFiles['products']);

echo "  • Parsing relationships...\n";
$relations = parseRelations($sqlFiles['relations']);

$totalRelations = 0;
foreach ($relations as $rels) {
    $totalRelations += count($rels);
}

echo "\n  ✓ Categories: " . count($categories) . "\n";
echo "  ✓ Products: " . count($products) . "\n";
echo "  ✓ Relationships: " . $totalRelations . "\n";

echo "\n🔄 Step 3: Analyzing database...\n\n";

$dbCategories = DB::table('categories')->where('status', 1)->pluck('name', 'id')->toArray();
$dbProducts = DB::table('products')->where('status', 1)->pluck('name', 'id')->toArray();

echo "  📊 Database:\n";
echo "     • Categories: " . count($dbCategories) . "\n";
echo "     • Products: " . count($dbProducts) . "\n";
echo "     • Current relationships: " . DB::table('category_product')->count() . "\n";

echo "\n🔗 Step 4: Mapping IDs...\n\n";

// Map categories
$categoryIdMap = [];
foreach ($categories as $sqlId => $categoryName) {
    foreach ($dbCategories as $dbId => $dbName) {
        if (trim($dbName) === trim($categoryName)) {
            $categoryIdMap[$sqlId] = $dbId;
            break;
        }
    }
}

// Map products
$productIdMap = [];
$productPrices = [];
foreach ($products as $sqlId => $productData) {
    foreach ($dbProducts as $dbId => $dbName) {
        if (trim($dbName) === trim($productData['name'])) {
            $productIdMap[$sqlId] = $dbId;
            $productPrices[$dbId] = [
                'price' => $productData['price'],
                'previous_price' => $productData['sale_price'] // sale_price from SQL = previous_price in DB
            ];
            break;
        }
    }
}

echo "  ✓ Mapped categories: " . count($categoryIdMap) . "/" . count($categories) . "\n";
echo "  ✓ Mapped products: " . count($productIdMap) . "/" . count($products) . "\n";
echo "  ✓ Products with prices to update: " . count($productPrices) . "\n";

echo "\n🔧 Step 5: Building updates...\n\n";

// Build category relationships
$newRelations = [];
$uniqueCheck = [];

foreach ($relations as $sqlProductId => $sqlCategoryIds) {
    if (!isset($productIdMap[$sqlProductId])) {
        continue;
    }
    
    $dbProductId = $productIdMap[$sqlProductId];
    
    foreach ($sqlCategoryIds as $sqlCategoryId) {
        if (!isset($categoryIdMap[$sqlCategoryId])) {
            continue;
        }
        
        $dbCategoryId = $categoryIdMap[$sqlCategoryId];
        $key = "$dbCategoryId-$dbProductId";
        
        if (isset($uniqueCheck[$key])) {
            continue;
        }
        
        $uniqueCheck[$key] = true;
        $newRelations[] = [
            'category_id' => $dbCategoryId,
            'product_id' => $dbProductId
        ];
    }
}

echo "  ✓ Category relationships ready: " . count($newRelations) . "\n";
echo "  ✓ Price updates ready: " . count($productPrices) . "\n";

// Statistics
$productsWithPriceChanges = 0;
$productsWithNewPrevPrice = 0;

foreach ($productPrices as $productId => $prices) {
    $current = DB::table('products')->where('id', $productId)->first(['price', 'previous_price']);
    if ($current) {
        if ($current->price != $prices['price']) {
            $productsWithPriceChanges++;
        }
        if ($prices['previous_price'] && $current->previous_price != $prices['previous_price']) {
            $productsWithNewPrevPrice++;
        }
    }
}

echo "\n📊 Step 6: Change Summary\n\n";
echo "  Categories:\n";
echo "     • Products to sync: " . count(array_unique(array_column($newRelations, 'product_id'))) . "\n";
echo "     • Total relationships: " . count($newRelations) . "\n\n";
echo "  Prices:\n";
echo "     • Products with price changes: " . $productsWithPriceChanges . "\n";
echo "     • Products with discount prices: " . $productsWithNewPrevPrice . "\n";

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║   READY TO APPLY CHANGES                                        ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

echo "What would you like to do?\n";
echo "  1. Apply ALL changes (categories + prices)\n";
echo "  2. Apply only category changes\n";
echo "  3. Apply only price changes\n";
echo "  4. Exit without changes\n\n";
echo "Enter choice (1-4): ";

$choice = trim(fgets(STDIN));

if ($choice === '4') {
    echo "\n✅ Exiting without changes.\n\n";
    exit(0);
}

try {
    DB::beginTransaction();
    
    if ($choice === '1' || $choice === '2') {
        echo "\n🔄 Syncing categories...\n";
        echo "  • Removing old relationships...\n";
        DB::table('category_product')->delete();
        
        echo "  • Inserting correct relationships...\n";
        $chunks = array_chunk($newRelations, 1000);
        foreach ($chunks as $chunk) {
            DB::table('category_product')->insert($chunk);
        }
        echo "  ✅ Categories synced!\n";
    }
    
    if ($choice === '1' || $choice === '3') {
        echo "\n💰 Syncing prices...\n";
        $updated = 0;
        foreach ($productPrices as $productId => $prices) {
            $updateData = [];
            
            if ($prices['price'] !== null) {
                $updateData['price'] = $prices['price'];
            }
            
            if ($prices['previous_price'] !== null) {
                $updateData['previous_price'] = $prices['previous_price'];
            }
            
            if (!empty($updateData)) {
                DB::table('products')->where('id', $productId)->update($updateData);
                $updated++;
            }
        }
        echo "  ✅ Prices updated for $updated products!\n";
    }
    
    DB::commit();
    
    echo "\n✅ SUCCESS! Database fully synced!\n\n";
    
    // Final statistics
    echo "Final Statistics:\n";
    echo "  • Total products: " . count($dbProducts) . "\n";
    echo "  • Products with categories: " . DB::table('category_product')->distinct('product_id')->count('product_id') . "\n";
    echo "  • Total relationships: " . DB::table('category_product')->count() . "\n";
    echo "  • Products with prices: " . DB::table('products')->whereNotNull('price')->count() . "\n";
    echo "  • Products with discount: " . DB::table('products')->whereNotNull('previous_price')->where('previous_price', '>', 0)->count() . "\n\n";
    
    echo "🎉 Your database is now fully synced with SQL files!\n";
    
} catch (\Exception $e) {
    DB::rollBack();
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo "   No changes were made.\n\n";
}

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║   PROCESS COMPLETE                                              ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";
