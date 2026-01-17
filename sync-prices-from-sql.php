<?php
/**
 * PRODUCT PRICE SYNC FROM SQL FILES
 * Syncs price and sale_price from SQL export to database
 * Maps: SQL sale_price → DB price (current price)
 *       SQL price → DB previous_price (original price before discount)
 */

require __DIR__.'/vendor/autoload.php';

use Illuminate\Support\Facades\DB;

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║   PRODUCT PRICE SYNC FROM SQL FILES                            ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

$sqlFile = __DIR__.'/public/products.sql';

if (!file_exists($sqlFile)) {
    die("❌ ERROR: File not found: $sqlFile\n");
}

echo "📋 Step 1: Reading products SQL file...\n\n";
$content = file_get_contents($sqlFile);
echo "  ✓ File loaded: " . number_format(strlen($content)/1024, 2) . " KB\n";

echo "\n🔍 Step 2: Parsing product data with prices...\n\n";

// Extract column names from INSERT statement
preg_match("/INSERT INTO `ec_products` \((.*?)\) VALUES/", $content, $colMatch);
if (empty($colMatch[1])) {
    die("❌ ERROR: Could not parse column names\n");
}

$columns = array_map(function($col) {
    return trim($col, '` ');
}, explode(',', $colMatch[1]));

// Find column positions
$idPos = array_search('id', $columns);
$namePos = array_search('name', $columns);
$pricePos = array_search('price', $columns);
$salePricePos = array_search('sale_price', $columns);

echo "  ✓ Found columns - id:$idPos, name:$namePos, price:$pricePos, sale_price:$salePricePos\n";

// Parse products with prices
$productsWithPrices = [];
$lines = explode("\n", $content);

foreach ($lines as $line) {
    // Skip non-data lines
    if (!preg_match("/^\((\d+),/", $line)) {
        continue;
    }
    
    // Extract values using regex - handle quoted strings with escapes
    $values = [];
    $current = '';
    $inQuotes = false;
    $escaped = false;
    $parenCount = 0;
    
    for ($i = 0; $i < strlen($line); $i++) {
        $char = $line[$i];
        
        if ($char === '(' && !$inQuotes) {
            $parenCount++;
            if ($parenCount > 1) $current .= $char;
            continue;
        }
        
        if ($char === ')' && !$inQuotes) {
            $parenCount--;
            if ($parenCount > 0) $current .= $char;
            if ($parenCount === 0) {
                if ($current !== '') {
                    $values[] = $current;
                }
                break;
            }
            continue;
        }
        
        if ($char === '\\' && !$escaped) {
            $escaped = true;
            $current .= $char;
            continue;
        }
        
        if ($char === "'" && !$escaped) {
            $inQuotes = !$inQuotes;
            $current .= $char;
            $escaped = false;
            continue;
        }
        
        if ($char === ',' && !$inQuotes && $parenCount === 1) {
            $values[] = trim($current);
            $current = '';
            $escaped = false;
            continue;
        }
        
        $current .= $char;
        $escaped = false;
    }
    
    if (count($values) > max($idPos, $namePos, $pricePos, $salePricePos)) {
        $id = $values[$idPos];
        $name = trim($values[$namePos], "'");
        $name = str_replace("\\'", "'", $name);
        
        $price = $values[$pricePos];
        $price = ($price === 'NULL' || $price === '') ? null : floatval($price);
        
        $salePrice = $values[$salePricePos];
        $salePrice = ($salePrice === 'NULL' || $salePrice === '') ? null : floatval($salePrice);
        
        // Only store if has meaningful price data
        if ($price !== null || $salePrice !== null) {
            $productsWithPrices[$id] = [
                'name' => $name,
                'regular_price' => $price,      // Original price from SQL
                'sale_price' => $salePrice      // Discounted price from SQL
            ];
        }
    }
}

echo "  ✓ Parsed " . count($productsWithPrices) . " products with price data\n";

// Get database products
echo "\n🗄️  Step 3: Loading database products...\n\n";
$dbProducts = DB::table('products')
    ->where('status', 1)
    ->select('id', 'name', 'price', 'previous_price')
    ->get()
    ->keyBy('name');

echo "  ✓ Database has " . $dbProducts->count() . " active products\n";

// Map by name
echo "\n🔗 Step 4: Matching products by name...\n\n";

$priceUpdates = [];
$matched = 0;
$notMatched = [];

foreach ($productsWithPrices as $sqlId => $sqlData) {
    $dbProduct = $dbProducts->get($sqlData['name']);
    
    if (!$dbProduct) {
        $notMatched[] = $sqlData['name'];
        continue;
    }
    
    $matched++;
    
    // Determine new prices
    // If there's a sale price in SQL, use it as the current price and regular price as previous
    // Otherwise, use regular price as current price
    $newPrice = null;
    $newPreviousPrice = null;
    
    if ($sqlData['sale_price'] !== null && $sqlData['sale_price'] > 0) {
        // Product is on sale
        $newPrice = $sqlData['sale_price'];  // Current discounted price
        $newPreviousPrice = $sqlData['regular_price']; // Original price
    } elseif ($sqlData['regular_price'] !== null && $sqlData['regular_price'] > 0) {
        // Product has regular price only
        $newPrice = $sqlData['regular_price'];
        $newPreviousPrice = null; // No discount
    }
    
    // Only update if prices changed
    $needsUpdate = false;
    $changes = [];
    
    if ($newPrice !== null && abs($dbProduct->price - $newPrice) > 0.01) {
        $needsUpdate = true;
        $changes['price'] = "DB: {$dbProduct->price} → SQL: $newPrice";
    }
    
    if ($newPreviousPrice !== null) {
        $dbPrevPrice = $dbProduct->previous_price ?? 0;
        if (abs($dbPrevPrice - $newPreviousPrice) > 0.01) {
            $needsUpdate = true;
            $changes['previous_price'] = "DB: $dbPrevPrice → SQL: $newPreviousPrice";
        }
    } elseif ($dbProduct->previous_price !== null) {
        $needsUpdate = true;
        $changes['previous_price'] = "Remove (no discount)";
    }
    
    if ($needsUpdate) {
        $priceUpdates[$dbProduct->id] = [
            'name' => $sqlData['name'],
            'new_price' => $newPrice,
            'new_previous_price' => $newPreviousPrice,
            'changes' => $changes
        ];
    }
}

echo "  ✓ Matched products: $matched\n";
echo "  ✓ Products needing price updates: " . count($priceUpdates) . "\n";

if (!empty($notMatched)) {
    echo "  ⚠️  Not matched: " . count($notMatched) . " products\n";
}

// Show sample updates
if (!empty($priceUpdates)) {
    echo "\n📊 Sample price updates (first 10):\n\n";
    $count = 0;
    foreach ($priceUpdates as $id => $data) {
        if ($count++ >= 10) break;
        echo "  • {$data['name']}\n";
        foreach ($data['changes'] as $field => $change) {
            echo "    $field: $change\n";
        }
    }
}

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║   READY TO UPDATE PRICES                                        ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

echo "Summary:\n";
echo "  • Products with price updates: " . count($priceUpdates) . "\n";
echo "  • Products matched: $matched\n\n";

if (empty($priceUpdates)) {
    echo "✅ All prices are already up to date!\n\n";
    exit(0);
}

echo "What would you like to do?\n";
echo "  1. Apply price updates (RECOMMENDED)\n";
echo "  2. Exit\n\n";
echo "Enter choice (1 or 2): ";

$choice = trim(fgets(STDIN));

if ($choice === '1') {
    echo "\n💰 Applying price updates...\n\n";
    
    try {
        DB::beginTransaction();
        
        $updated = 0;
        foreach ($priceUpdates as $productId => $data) {
            $updateData = ['price' => $data['new_price']];
            
            if ($data['new_previous_price'] !== null) {
                $updateData['previous_price'] = $data['new_previous_price'];
            } else {
                $updateData['previous_price'] = null;
            }
            
            DB::table('products')
                ->where('id', $productId)
                ->update($updateData);
            
            $updated++;
        }
        
        DB::commit();
        
        echo "  ✓ Updated prices for $updated products\n\n";
        echo "✅ SUCCESS! All prices synced from SQL file!\n\n";
        
    } catch (\Exception $e) {
        DB::rollBack();
        echo "\n❌ ERROR: " . $e->getMessage() . "\n";
        echo "   No changes were made.\n\n";
    }
    
} else {
    echo "\n✅ No changes made.\n\n";
}

echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║   PROCESS COMPLETE                                              ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";
