<?php
/**
 * Update Product Status Script
 * 
 * This script updates product status in the current database based on the old database.
 * It compares products by name and updates their status field.
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "================================================================================\n";
echo "PRODUCT STATUS UPDATE SCRIPT\n";
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
    
    // Load the old database data
    $oldDbFile = __DIR__ . '/public/ec_products (2).sql';
    
    if (!file_exists($oldDbFile)) {
        die("❌ Error: Old database file not found at: {$oldDbFile}\n");
    }
    
    echo "📂 Reading old database file...\n";
    $sqlContent = file_get_contents($oldDbFile);
    
    // Extract product data from SQL
    $products = [];
    
    // Pattern to match INSERT statements
    preg_match_all("/\((\d+),\s*'([^']*(?:''[^']*)*)',\s*[^,]*,\s*[^,]*,\s*'(published|pending)'/", $sqlContent, $matches, PREG_SET_ORDER);
    
    foreach ($matches as $match) {
        $name = str_replace("''", "'", $match[2]); // Unescape single quotes
        $status = $match[3];
        $products[$name] = $status;
    }
    
    echo "✅ Found " . count($products) . " products in old database\n\n";
    
    // Count by status
    $publishedCount = 0;
    $pendingCount = 0;
    
    foreach ($products as $status) {
        if ($status === 'published') {
            $publishedCount++;
        } else {
            $pendingCount++;
        }
    }
    
    echo "📈 Old Database Statistics:\n";
    echo "   ✓ Published (Active): {$publishedCount}\n";
    echo "   ✗ Pending (Inactive): {$pendingCount}\n\n";
    
    // Update products in current database
    echo "🔄 Updating products in current database...\n";
    echo "   (Note: 'published' = 1, 'pending' = 0)\n\n";
    
    $updated = 0;
    $notFound = 0;
    $errors = 0;
    
    foreach ($products as $name => $status) {
        try {
            // Map text status to numeric
            $numericStatus = ($status === 'published') ? 1 : 0;
            
            $result = DB::table('products')
                ->where('name', $name)
                ->update(['status' => $numericStatus]);
            
            if ($result > 0) {
                $updated++;
                $statusText = ($numericStatus === 1) ? '✓ published (1)' : '✗ pending (0)';
                echo "   {$statusText} - {$name}\n";
            } else {
                $notFound++;
                echo "   ⚠ Not found: {$name}\n";
            }
        } catch (\Exception $e) {
            $errors++;
            echo "   ✗ Error updating '{$name}': " . $e->getMessage() . "\n";
        }
    }
    
    echo "\n";
    echo "================================================================================\n";
    echo "UPDATE SUMMARY\n";
    echo "================================================================================\n";
    echo "✅ Successfully updated: {$updated} products\n";
    echo "⚠️  Not found in current DB: {$notFound} products\n";
    echo "❌ Errors: {$errors}\n\n";
    
    // Show final status distribution
    echo "📊 Final Status Distribution:\n";
    $finalStatus = DB::table('products')
        ->select('status', DB::raw('COUNT(*) as count'))
        ->groupBy('status')
        ->get();
    
    foreach ($finalStatus as $stat) {
        echo "   - Status '{$stat->status}': {$stat->count} products\n";
    }
    echo "\n";
    
    echo "================================================================================\n";
    echo "✅ Product status update completed successfully!\n";
    echo "================================================================================\n";
    
} catch (\Exception $e) {
    echo "\n❌ Fatal Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}
