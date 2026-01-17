<?php
/**
 * COMPREHENSIVE CATEGORY & PRICE SYNC FROM SQL FILES
 * Syncs both category relationships AND product prices from SQL exports
 */

require __DIR__.'/vendor/autoload.php';

use Illuminate\Support\Facades\DB;

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║   COMPREHENSIVE CATEGORY & PRICE SYNC FROM SQL FILES           ║\n";
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

    preg_match_all("/INSERT INTO `ec_product_categories`.*?VALUES\s*(.*?);/s", $content, $matches);

    if (!empty($matches[1])) {
        foreach ($matches[1] as $valuesBlock) {
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

// Parse products from SQL with prices
function parseProducts($file) {
    $content = file_get_contents($file);
    $products = [];

    // Find the INSERT statement with column definitions
    preg_match("/INSERT INTO `ec_products` \((.*?)\) VALUES/s", $content, $columnMatch);
    if (empty($columnMatch[1])) {
        return $products;
    }

    // Parse column names
    $columns = array_map('trim', explode(',', $columnMatch[1]));
    $columns = array_map(function($col) {
        return trim($col, '` ');
    }, $columns);

    // Find positions of important columns
    $idPos = array_search('id', $columns);
    $namePos = array_search('name', $columns);
    $pricePos = array_search('price', $columns);
    $salePricePos = array_search('sale_price', $columns);

    // Extract all INSERT statements
    preg_match_all("/INSERT INTO `ec_products`.*?VALUES\s*(.*?);/s", $content, $matches);

    if (!empty($matches[1])) {
        foreach ($matches[1] as $valuesBlock) {
            // Split by row - more sophisticated parsing needed
            preg_match_all("/\((\d+),\s*'([^']+)',[^(]*?,\s*([0-9.]+|NULL),\s*([0-9.]+|NULL)/", $valuesBlock, $tuples);

            // This is a simplified parser - for full accuracy we'd need a proper SQL parser
            // Let's try a different approach: parse line by line
            $lines = explode("\n", $valuesBlock);
            foreach ($lines as $line) {
                // Match: (id, 'name', ... other fields ..., price, sale_price, ...)
                if (preg_match("/^\((\d+),\s*'([^']*(?:\\'[^']*)*)'.*?$/", $line, $match)) {
                    $id = $match[1];
                    $name = str_replace("\\'", "'", $match[2]);

                    // Extract price and sale_price from the full row
                    // This is simplified - in production you'd want a proper SQL parser
                    $products[$id] = [
                        'name' => $name,
                        'price' => null,
                        'sale_price' => null
                    ];
                }
            }
        }
    }

    return $products;
}

// Better product parser
function parseProductsAdvanced($file) {
    $content = file_get_contents($file);
    $products = [];

    // Read line by line to find product entries
    $lines = explode("\n", $content);

    foreach ($lines as $line) {
        // Look for lines starting with product INSERT data
        if (preg_match("/^\((\d+),\s*'([^']*(?:\\'[^']*)*)'/", $line, $match)) {
            $id = $match[1];
            $name = str_replace("\\'", "'", $match[2]);

            // Extract numeric values that look like prices
            // Price typically appears after several fields
            preg_match_all("/,\s*([0-9]+\.?[0-9]*)\s*,/", $line, $numbers);

            $price = null;
            $salePrice = null;

            // Try to find price values (typically between 0 and 10000)
            if (!empty($numbers[1])) {
                foreach ($numbers[1] as $num) {
                    $val = floatval($num);
                    if ($val > 0 && $val < 10000) {
                        if ($price === null) {
                            $price = $val;
                        } elseif ($salePrice === null) {
                            $salePrice = $val;
                            break;
                        }
                    }
                }
            }

            $products[$id] = [
                'name' => $name,
                'price' => $price,
                'sale_price' => $salePrice
            ];
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
$categories = parseCategories($sqlFiles['categories']);
$products = parseProductsAdvanced($sqlFiles['products']);
$relations = parseRelations($sqlFiles['relations']);

echo "  ✓ Categories parsed: " . count($categories) . "\n";
echo "  ✓ Products parsed: " . count($products) . "\n";
echo "  ✓ Relationships parsed: " . count($relations) . " products with categories\n";

// Count products with prices
$withPrices = 0;
foreach ($products as $prod) {
    if ($prod['price'] !== null || $prod['sale_price'] !== null) {
        $withPrices++;
    }
}
echo "  ✓ Products with price data: $withPrices\n";

echo "\n🔄 Step 3: Analyzing database...\n\n";

// Get current database state
$dbCategories = DB::table('categories')->where('status', 1)->pluck('name', 'id')->toArray();
$dbProducts = DB::table('products')->where('status', 1)->pluck('name', 'id')->toArray();

echo "  📊 Database has:\n";
echo "     • Categories: " . count($dbCategories) . "\n";
echo "     • Products: " . count($dbProducts) . "\n";
echo "     • Current relationships: " . DB::table('category_product')->count() . "\n\n";

// Build category ID mapping (SQL ID -> DB ID)
echo "🔗 Step 4: Mapping categories and products...\n\n";

$categoryIdMap = [];
foreach ($categories as $sqlId => $categoryName) {
    foreach ($dbCategories as $dbId => $dbName) {
        if (trim($dbName) === trim($categoryName)) {
            $categoryIdMap[$sqlId] = $dbId;
            break;
        }
    }
}

// Build product ID mapping (SQL ID -> DB ID)
$productIdMap = [];
$productPriceUpdates = [];

foreach ($products as $sqlId => $productData) {
    $productName = $productData['name'];

    foreach ($dbProducts as $dbId => $dbName) {
        if (trim($dbName) === trim($productName)) {
            $productIdMap[$sqlId] = $dbId;

            // Store price update data
            if ($productData['price'] !== null || $productData['sale_price'] !== null) {
                $productPriceUpdates[$dbId] = [
                    'name' => $productName,
                    'price' => $productData['price'],
                    'sale_price' => $productData['sale_price']
                ];
            }
            break;
        }
    }
}

echo "  ✓ Mapped categories: " . count($categoryIdMap) . "/" . count($categories) . "\n";
echo "  ✓ Mapped products: " . count($productIdMap) . "/" . count($products) . "\n";
echo "  ✓ Products with price updates: " . count($productPriceUpdates) . "\n";

// Build new relationships
echo "\n🔧 Step 5: Building corrections...\n\n";

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

echo "  ✓ Category relationships to sync: " . count($newRelations) . "\n";
echo "  ✓ Product prices to sync: " . count($productPriceUpdates) . "\n";

// Show price update samples
if (!empty($productPriceUpdates)) {
    echo "\n  📊 Sample price updates (first 10):\n";
    $count = 0;
    foreach ($productPriceUpdates as $dbId => $data) {
        if ($count++ >= 10) break;
        $priceStr = $data['price'] !== null ? number_format($data['price'], 2) . ' JD' : 'N/A';
        $saleStr = $data['sale_price'] !== null ? number_format($data['sale_price'], 2) . ' JD' : 'N/A';
        echo "     • {$data['name']}\n";
        echo "       Price: $priceStr | Sale: $saleStr\n";
    }
}

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║   READY TO APPLY CORRECTIONS                                    ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

echo "Summary:\n";
echo "  • Category relationships: " . count($newRelations) . "\n";
echo "  • Price updates: " . count($productPriceUpdates) . "\n\n";

echo "What would you like to do?\n";
echo "  1. Apply ALL corrections (categories + prices) - RECOMMENDED\n";
echo "  2. Apply only category corrections\n";
echo "  3. Apply only price corrections\n";
echo "  4. Exit\n\n";
echo "Enter choice (1-4): ";

$choice = trim(fgets(STDIN));

if (in_array($choice, ['1', '2', '3'])) {
    echo "\n🚀 Applying corrections...\n\n";

    try {
        DB::beginTransaction();

        // Apply category corrections
        if ($choice === '1' || $choice === '2') {
            echo "  📦 Syncing category relationships...\n";
            DB::table('category_product')->delete();

            $chunks = array_chunk($newRelations, 1000);
            foreach ($chunks as $chunk) {
                DB::table('category_product')->insert($chunk);
            }
            echo "  ✓ Synced " . count($newRelations) . " category relationships\n";
        }

        // Apply price corrections
        if ($choice === '1' || $choice === '3') {
            echo "\n  💰 Syncing product prices...\n";
            $updatedCount = 0;

            foreach ($productPriceUpdates as $productId => $data) {
                $updateData = [];
                if ($data['price'] !== null) {
                    $updateData['price'] = $data['price'];
                }
                if ($data['sale_price'] !== null) {
                    $updateData['sale_price'] = $data['sale_price'];
                }

                if (!empty($updateData)) {
                    DB::table('products')
                        ->where('id', $productId)
                        ->update($updateData);
                    $updatedCount++;
                }
            }

            echo "  ✓ Updated prices for $updatedCount products\n";
        }

        DB::commit();

        echo "\n✅ SUCCESS! All corrections applied!\n\n";

        // Final statistics
        echo "Final Statistics:\n";
        echo "  • Total category relationships: " . DB::table('category_product')->count() . "\n";
        echo "  • Products with categories: " . DB::table('category_product')->distinct('product_id')->count('product_id') . "\n";
        echo "  • Categories in use: " . DB::table('category_product')->distinct('category_id')->count('category_id') . "\n";

        if ($choice === '1' || $choice === '3') {
            echo "  • Products with updated prices: $updatedCount\n";
        }

        echo "\n🎉 Your database is now synced with the SQL files!\n";

    } catch (\Exception $e) {
        DB::rollBack();
        echo "\n❌ ERROR: " . $e->getMessage() . "\n";
        echo "   No changes were made to the database.\n\n";
    }

} else {
    echo "\n✅ No changes made.\n\n";
}

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║   PROCESS COMPLETE                                              ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";
