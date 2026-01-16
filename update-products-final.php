<?php
/**
 * FINAL CORRECT Product Status Update Script
 * Uses pre-extracted product list with exact counts:
 * - 2,542 Published
 * - 2,819 Pending
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "================================================================================\n";
echo "FINAL CORRECT PRODUCT STATUS UPDATE\n";
echo "================================================================================\n\n";

try {
    // Load the extracted products list
    $listFile = __DIR__ . '/products_status_list.txt';
    
    if (!file_exists($listFile)) {
        die("❌ Error: Products list file not found at: {$listFile}\n");
    }
    
    echo "📂 Loading products from extracted list...\n";
    $lines = file($listFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    $products_by_status = ['published' => [], 'pending' => []];
    
    foreach ($lines as $line) {
        $parts = explode('|', $line);
        if (count($parts) == 2) {
            $name = $parts[0];
            $status = $parts[1];
            
            if ($status === 'published' || $status === 'pending') {
                $products_by_status[$status][] = $name;
            }
        }
    }
    
    $published_count = count($products_by_status['published']);
    $pending_count = count($products_by_status['pending']);
    
    echo "   ✅ Loaded {$published_count} published products\n";
    echo "   ✅ Loaded {$pending_count} pending products\n";
    echo "   📦 Total: " . ($published_count + $pending_count) . " products\n\n";
    
    // Current status
    echo "📊 Current Database Status:\n";
    $currentStatus = DB::table('products')
        ->select('status', DB::raw('COUNT(*) as count'))
        ->groupBy('status')
        ->get();
    
    foreach ($currentStatus as $stat) {
        echo "   - Status '{$stat->status}': {$stat->count} products\n";
    }
    echo "\n";
    
    // Step 1: Reset all to published
    echo "🔄 Step 1: Resetting ALL products to published (status = 1)...\n";
    $resetCount = DB::table('products')->update(['status' => 1]);
    echo "   ✅ Reset {$resetCount} products to published\n\n";
    
    // Step 2: Update PENDING products to status = 0
    echo "🔄 Step 2: Updating PENDING products to inactive (status = 0)...\n";
    echo "   Expected to update: {$pending_count} products\n";
    
    $updated = 0;
    $notFound = [];
    
    // Process in batches for performance
    $batchSize = 50;
    $batches = array_chunk($products_by_status['pending'], $batchSize);
    
    $totalBatches = count($batches);
    echo "   Processing {$totalBatches} batches of {$batchSize} products each...\n\n";
    
    foreach ($batches as $index => $batch) {
        $batchUpdated = DB::table('products')
            ->whereIn('name', $batch)
            ->update(['status' => 0]);
        
        $updated += $batchUpdated;
        
        // Track not found products in this batch
        if ($batchUpdated < count($batch)) {
            foreach ($batch as $name) {
                $exists = DB::table('products')->where('name', $name)->exists();
                if (!$exists) {
                    $notFound[] = $name;
                }
            }
        }
        
        // Progress indicator
        if (($index + 1) % 20 == 0 || ($index + 1) == $totalBatches) {
            $percent = round((($index + 1) / $totalBatches) * 100, 1);
            echo "   Progress: {$percent}% (" . ($index + 1) . "/{$totalBatches} batches)\n";
        }
    }
    
    $notFoundCount = count($notFound);
    
    echo "\n   ✅ Successfully updated: {$updated} products to inactive\n";
    echo "   ⚠️  Not found: {$notFoundCount} products\n\n";
    
    // Step 3: Verification
    echo "================================================================================\n";
    echo "VERIFICATION & RESULTS\n";
    echo "================================================================================\n\n";
    
    echo "📊 Expected from Old Database:\n";
    echo "   ✅ Published (Active): {$published_count}\n";
    echo "   ❌ Pending (Inactive): {$pending_count}\n";
    echo "   📦 Total: " . ($published_count + $pending_count) . "\n\n";
    
    echo "📊 Final Status in Current Database:\n";
    $finalStatus = DB::table('products')
        ->select('status', DB::raw('COUNT(*) as count'))
        ->groupBy('status')
        ->orderBy('status', 'desc')
        ->get();
    
    $finalPublished = 0;
    $finalPending = 0;
    $totalProducts = 0;
    
    foreach ($finalStatus as $stat) {
        $statusLabel = ($stat->status == 1) ? 'Active/Published' : 'Inactive/Pending';
        echo "   - Status {$stat->status} ({$statusLabel}): {$stat->count} products\n";
        
        if ($stat->status == 1) $finalPublished = $stat->count;
        if ($stat->status == 0) $finalPending = $stat->count;
        $totalProducts += $stat->count;
    }
    
    echo "   📦 Total Products: {$totalProducts}\n\n";
    
    // Calculate statistics
    $matchRate = ($updated / $pending_count) * 100;
    
    echo "📈 Update Statistics:\n";
    echo "   • Products marked as pending in old DB: {$pending_count}\n";
    echo "   • Successfully updated to inactive: {$updated}\n";
    echo "   • Match rate: " . number_format($matchRate, 2) . "%\n";
    echo "   • Not found in current DB: {$notFoundCount}\n\n";
    
    // Show sample of not found products
    if ($notFoundCount > 0 && $notFoundCount <= 20) {
        echo "⚠️  Products not found in current database:\n";
        foreach ($notFound as $name) {
            echo "   - {$name}\n";
        }
        echo "\n";
    } elseif ($notFoundCount > 20) {
        echo "⚠️  {$notFoundCount} products not found (showing first 20):\n";
        for ($i = 0; $i < 20; $i++) {
            echo "   - {$notFound[$i]}\n";
        }
        echo "   ... and " . ($notFoundCount - 20) . " more\n\n";
    }
    
    echo "================================================================================\n";
    echo "✅ PRODUCT STATUS UPDATE COMPLETED SUCCESSFULLY!\n";
    echo "================================================================================\n";
    echo "Summary:\n";
    echo "  • Active products (status=1): {$finalPublished}\n";
    echo "  • Inactive products (status=0): {$finalPending}\n";
    echo "  • Total products: {$totalProducts}\n";
    echo "================================================================================\n";
    
} catch (\Exception $e) {
    echo "\n❌ Fatal Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}
