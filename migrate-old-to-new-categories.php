<?php

/*
 * MIGRATE FROM OLD product_categories TO NEW category_product SYSTEM
 *
 * This migrates all data from the old product_categories table to the new
 * category_product pivot table, properly handling the category hierarchy.
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;

echo "╔══════════════════════════════════════════════════════════════╗\n";
echo "║   MIGRATE product_categories → category_product             ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n\n";

try {
    DB::beginTransaction();

    echo "📊 STEP 1: ANALYZING OLD SYSTEM (product_categories)\n";
    echo str_repeat('-', 60) . "\n\n";

    $oldRecords = DB::table('product_categories')->count();
    $oldUniqueProducts = DB::table('product_categories')->distinct('product_id')->count('product_id');

    echo "Old system (product_categories table):\n";
    echo "  • Total records: {$oldRecords}\n";
    echo "  • Unique products: {$oldUniqueProducts}\n\n";

    echo "📊 STEP 2: ANALYZING NEW SYSTEM (category_product)\n";
    echo str_repeat('-', 60) . "\n\n";

    $newRecords = DB::table('category_product')->count();
    $newUniqueProducts = DB::table('category_product')->distinct('product_id')->count('product_id');

    echo "New system (category_product pivot table):\n";
    echo "  • Total records: {$newRecords}\n";
    echo "  • Unique products: {$newUniqueProducts}\n\n";

    $productsMissing = $oldUniqueProducts - $newUniqueProducts;
    echo "  ⚠️  Missing: {$productsMissing} products need migration\n\n";

    echo "📊 STEP 3: CHECKING product_categories STRUCTURE\n";
    echo str_repeat('-', 60) . "\n\n";

    // Check table structure
    $sampleRecord = DB::table('product_categories')->first();
    echo "product_categories structure:\n";
    if ($sampleRecord) {
        foreach ($sampleRecord as $column => $value) {
            echo "  • {$column}: {$value}\n";
        }
    }

    echo "\n\n📊 STEP 4: MIGRATING DATA\n";
    echo str_repeat('-', 60) . "\n\n";

    // Get all records from product_categories
    $oldRecordsData = DB::table('product_categories')->get();

    $stats = [
        'processed' => 0,
        'inserted' => 0,
        'skipped_existing' => 0,
        'skipped_invalid' => 0,
        'products_updated' => 0,
    ];

    $processedProducts = [];
    $insertBatch = [];
    $batchSize = 100;

    echo "Processing {$oldRecordsData->count()} records...\n\n";

    foreach ($oldRecordsData as $record) {
        $stats['processed']++;

        // Verify product exists and is active
        $product = Product::find($record->product_id);
        if (!$product || $product->status != 1) {
            $stats['skipped_invalid']++;
            continue;
        }

        // Get category ID - could be in category_id, subcategory_id, or childcategory_id
        $categoryId = $record->category_id ?? null;

        // If no category_id but has subcategory_id, try to map it
        if (!$categoryId && isset($record->subcategory_id) && $record->subcategory_id) {
            // Try to find if this subcategory exists as a main category
            $subcat = DB::table('subcategories')->where('id', $record->subcategory_id)->first();
            if ($subcat) {
                // Check if this subcategory name exists in main categories
                $mainCat = Category::where('name', $subcat->name)->where('status', 1)->first();
                if ($mainCat) {
                    $categoryId = $mainCat->id;
                }
            }
        }

        // If still no category, try childcategory_id
        if (!$categoryId && isset($record->childcategory_id) && $record->childcategory_id) {
            $childcat = DB::table('childcategories')->where('id', $record->childcategory_id)->first();
            if ($childcat) {
                $mainCat = Category::where('name', $childcat->name)->where('status', 1)->first();
                if ($mainCat) {
                    $categoryId = $mainCat->id;
                }
            }
        }

        if (!$categoryId) {
            $stats['skipped_invalid']++;
            continue;
        }

        // Verify category exists in main categories table
        $category = Category::find($categoryId);
        if (!$category || $category->status != 1) {
            $stats['skipped_invalid']++;
            continue;
        }

        // Check if this relationship already exists
        $exists = DB::table('category_product')
            ->where('product_id', $record->product_id)
            ->where('category_id', $categoryId)
            ->exists();

        if ($exists) {
            $stats['skipped_existing']++;
            continue;
        }

        // Add to batch
        $insertBatch[] = [
            'product_id' => $record->product_id,
            'category_id' => $categoryId,
        ];

        $stats['inserted']++;

        // Track products updated
        if (!in_array($record->product_id, $processedProducts)) {
            $processedProducts[] = $record->product_id;
            $stats['products_updated']++;
        }

        // Insert batch if reached batch size
        if (count($insertBatch) >= $batchSize) {
            DB::table('category_product')->insert($insertBatch);
            $insertBatch = [];

            if ($stats['inserted'] % 500 == 0) {
                echo "  ✓ Processed {$stats['inserted']} records...\n";
            }
        }
    }

    // Insert remaining batch
    if (!empty($insertBatch)) {
        DB::table('category_product')->insert($insertBatch);
    }

    echo "\n\n📊 STEP 5: FINAL STATISTICS\n";
    echo str_repeat('-', 60) . "\n\n";

    $finalRecords = DB::table('category_product')->count();
    $finalUniqueProducts = DB::table('category_product')->distinct('product_id')->count('product_id');

    echo "Migration Results:\n";
    echo "  • Records processed: {$stats['processed']}\n";
    echo "  • New records inserted: {$stats['inserted']}\n";
    echo "  • Skipped (already exists): {$stats['skipped_existing']}\n";
    echo "  • Skipped (invalid): {$stats['skipped_invalid']}\n";
    echo "  • Products updated: {$stats['products_updated']}\n\n";

    echo "Final state (category_product):\n";
    echo "  • Total records: {$finalRecords} (was {$newRecords})\n";
    echo "  • Unique products: {$finalUniqueProducts} (was {$newUniqueProducts})\n";
    echo "  • Gain: +" . ($finalRecords - $newRecords) . " records, +" . ($finalUniqueProducts - $newUniqueProducts) . " products\n\n";

    // Check products without categories
    $productsWithoutCats = Product::where('status', 1)->doesntHave('categories')->count();
    $totalActive = Product::where('status', 1)->count();
    $coverage = round(($totalActive - $productsWithoutCats) / $totalActive * 100, 1);

    echo "Product Coverage:\n";
    echo "  • Total active products: {$totalActive}\n";
    echo "  • Products WITH categories: " . ($totalActive - $productsWithoutCats) . " ({$coverage}%)\n";
    echo "  • Products WITHOUT categories: {$productsWithoutCats} (" . (100 - $coverage) . "%)\n\n";

    echo "⚠️  Do you want to commit these changes? (yes/no): ";

    $handle = fopen("php://stdin", "r");
    $line = trim(fgets($handle));

    if (strtolower($line) === 'yes') {
        DB::commit();
        echo "\n✅ Migration completed successfully!\n\n";

        echo "╔══════════════════════════════════════════════════════════════╗\n";
        echo "║                    MIGRATION COMPLETED                       ║\n";
        echo "╚══════════════════════════════════════════════════════════════╝\n\n";

        echo "📋 NEXT STEPS:\n";
        echo "1. Clear caches: php artisan cache:clear && php artisan view:clear\n";
        echo "2. Test category filtering on homepage\n";
        echo "3. Test subcategory filtering\n";
        echo "4. Verify all products appear in correct categories\n\n";
    } else {
        DB::rollBack();
        echo "\n❌ Changes rolled back. No modifications made to database.\n";
    }

    fclose($handle);

} catch (\Exception $e) {
    DB::rollBack();
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    exit(1);
}
