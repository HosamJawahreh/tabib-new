<?php
/**
 * CORRECT Product Status Update Script
 * 
 * This script correctly updates ALL products by importing the complete old database
 * Expected: 2,543 published and 2,819 pending products
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "================================================================================\n";
echo "CORRECT PRODUCT STATUS UPDATE SCRIPT\n";
echo "================================================================================\n\n";

try {
    // First, check current status distribution
    echo "📊 Current Status Distribution:\n";
    $currentStatus = DB::table('products')
        ->select('status', DB::raw('COUNT(*) as count'))
        ->groupBy('status')
        ->get();
    
    foreach ($currentStatus as $stat) {
        echo "   - Status '{$stat->status}': {$stat->count} products\n";
    }
    echo "\n";
    
    // Step 1: Reset all products to status = 1 (published)
    echo "🔄 Step 1: Resetting all products to published (status = 1)...\n";
    DB::table('products')->update(['status' => 1]);
    echo "   ✅ All products reset to published\n\n";
    
    // Step 2: Load the old database file and extract ALL products
    $oldDbFile = __DIR__ . '/public/ec_products (2).sql';
    
    if (!file_exists($oldDbFile)) {
        die("❌ Error: Old database file not found at: {$oldDbFile}\n");
    }
    
    echo "📂 Step 2: Reading complete old database file...\n";
    $sqlContent = file_get_contents($oldDbFile);
    
    // Extract all INSERT statements
    echo "   Processing INSERT statements...\n";
    
    // Find all rows and their status
    $products_to_update = [];
    
    // Pattern to match each row with product name and status
    // The status is the 5th field in the INSERT statement
    preg_match_all(
        "/\((\d+),\s*'([^']*(?:''[^']*)*)',\s*(?:'[^']*(?:''[^']*)*'|NULL),\s*(?:.*?),\s*'(published|pending)'/s",
        $sqlContent,
        $matches,
        PREG_SET_ORDER
    );
    
    $published_count = 0;
    $pending_count = 0;
    $products_by_status = ['published' => [], 'pending' => []];
    
    foreach ($matches as $match) {
        $name = str_replace("''", "'", $match[2]); // Unescape single quotes
        $status = $match[3];
        
        $products_by_status[$status][] = $name;
        
        if ($status === 'published') {
            $published_count++;
        } else {
            $pending_count++;
        }
    }
    
    echo "   ✅ Extracted {$published_count} published products\n";
    echo "   ✅ Extracted {$pending_count} pending products\n";
    echo "   📦 Total: " . ($published_count + $pending_count) . " products\n\n";
    
    // Step 3: Update only PENDING products to status = 0
    echo "🔄 Step 3: Updating PENDING products to inactive (status = 0)...\n";
    
    $updated = 0;
    $notFound = 0;
    
    // Process in batches for better performance
    $batchSize = 100;
    $batches = array_chunk($products_by_status['pending'], $batchSize);
    
    echo "   Processing " . count($batches) . " batches...\n";
    
    foreach ($batches as $batchIndex => $batch) {
        $batchUpdated = DB::table('products')
            ->whereIn('name', $batch)
            ->update(['status' => 0]);
        
        $updated += $batchUpdated;
        
        if (($batchIndex + 1) % 10 == 0) {
            echo "   ... Processed " . ($batchIndex + 1) . " batches\n";
        }
    }
    
    $notFound = $pending_count - $updated;
    
    echo "   ✅ Updated {$updated} products to inactive\n";
    echo "   ⚠️  {$notFound} products not found in current database\n\n";
    
    // Step 4: Verify the results
    echo "================================================================================\n";
    echo "VERIFICATION\n";
    echo "================================================================================\n\n";
    
    echo "📊 Expected from Old Database:\n";
    echo "   ✅ Published (Active): {$published_count}\n";
    echo "   ❌ Pending (Inactive): {$pending_count}\n\n";
    
    echo "📊 Final Status Distribution in Current Database:\n";
    $finalStatus = DB::table('products')
        ->select('status', DB::raw('COUNT(*) as count'))
        ->groupBy('status')
        ->get();
    
    $finalPublished = 0;
    $finalPending = 0;
    
    foreach ($finalStatus as $stat) {
        echo "   - Status '{$stat->status}': {$stat->count} products\n";
        if ($stat->status == 1) $finalPublished = $stat->count;
        if ($stat->status == 0) $finalPending = $stat->count;
    }
    
    echo "\n";
    echo "================================================================================\n";
    echo "UPDATE SUMMARY\n";
    echo "================================================================================\n";
    echo "✅ Successfully updated: {$updated} products to inactive\n";
    echo "📊 Final Active (status=1): {$finalPublished} products\n";
    echo "📊 Final Inactive (status=0): {$finalPending} products\n";
    echo "⚠️  Products not found: {$notFound}\n\n";
    
    // Calculate accuracy
    $accuracy = ($updated / $pending_count) * 100;
    echo "📈 Update Accuracy: " . number_format($accuracy, 2) . "%\n";
    
    echo "================================================================================\n";
    echo "✅ Product status update completed successfully!\n";
    echo "================================================================================\n";
    
} catch (\Exception $e) {
    echo "\n❌ Fatal Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}
