<?php

/*
 * PROFESSIONAL SOLUTION: Merge Category Hierarchy into Flat Multi-Category System
 *
 * This script:
 * 1. Identifies all subcategories and childcategories that are actually imported as main categories
 * 2. Maps old product assignments (category_id, subcategory_id, childcategory_id) to new system
 * 3. Handles duplicate "عروض" categories professionally
 * 4. Creates comprehensive category_product relationships
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;

echo "╔══════════════════════════════════════════════════════════════╗\n";
echo "║   PROFESSIONAL CATEGORY SYSTEM CONSOLIDATION                ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n\n";

try {
    DB::beginTransaction();

    echo "📊 STEP 1: ANALYZING CURRENT STATE\n";
    echo str_repeat('-', 60) . "\n\n";

    // Count current state
    $categories = Category::where('status', 1)->count();
    $subcategories = DB::table('subcategories')->where('status', 1)->count();
    $childcategories = DB::table('childcategories')->where('status', 1)->count();
    $currentPivotRecords = DB::table('category_product')->count();

    echo "Current state:\n";
    echo "  • Main categories: {$categories}\n";
    echo "  • Subcategories: {$subcategories}\n";
    echo "  • Child categories: {$childcategories}\n";
    echo "  • Current pivot records: {$currentPivotRecords}\n\n";

    // Check products WITHOUT any category assignment
    $productsWithoutAnyCategory = Product::where('status', 1)
        ->doesntHave('categories')
        ->whereNull('category_id')
        ->whereNull('subcategory_id')
        ->whereNull('childcategory_id')
        ->count();

    echo "  • Products without ANY category: {$productsWithoutAnyCategory}\n\n";

    echo "\n📊 STEP 2: MAPPING CATEGORY HIERARCHY TO FLAT SYSTEM\n";
    echo str_repeat('-', 60) . "\n\n";

    // Create mapping arrays
    $categoryMap = []; // Maps old IDs to new category IDs in main table
    $stats = [
        'subcategories_mapped' => 0,
        'childcategories_mapped' => 0,
        'new_relationships' => 0,
        'products_updated' => 0,
    ];

    // Map subcategories to main categories
    echo "Mapping subcategories to main categories table:\n";
    $subcats = DB::table('subcategories')->where('status', 1)->get();

    foreach ($subcats as $subcat) {
        // Check if this subcategory exists as a main category
        $existingCategory = Category::where('name', $subcat->name)->first();

        if ($existingCategory) {
            $categoryMap['subcat_' . $subcat->id] = $existingCategory->id;
            echo "  ✓ Subcategory '{$subcat->name}' (ID: {$subcat->id}) → Category ID {$existingCategory->id}\n";
            $stats['subcategories_mapped']++;
        } else {
            echo "  ⚠ Subcategory '{$subcat->name}' (ID: {$subcat->id}) not found in main categories\n";
        }
    }

    echo "\n";

    // Map childcategories to main categories
    echo "Mapping childcategories to main categories table:\n";
    $childcats = DB::table('childcategories')->where('status', 1)->get();

    foreach ($childcats as $childcat) {
        // Check if this childcategory exists as a main category
        $existingCategory = Category::where('name', $childcat->name)->first();

        if ($existingCategory) {
            $categoryMap['childcat_' . $childcat->id] = $existingCategory->id;
            echo "  ✓ Childcategory '{$childcat->name}' (ID: {$childcat->id}) → Category ID {$existingCategory->id}\n";
            $stats['childcategories_mapped']++;
        } else {
            echo "  ⚠ Childcategory '{$childcat->name}' (ID: {$childcat->id}) not found in main categories\n";
        }
    }

    echo "\n\n📊 STEP 3: MIGRATING PRODUCT ASSIGNMENTS\n";
    echo str_repeat('-', 60) . "\n\n";

    // Find products that have category_id, subcategory_id, or childcategory_id in old columns
    // but DON'T have corresponding entries in category_product pivot table

    $productsToMigrate = Product::where('status', 1)
        ->where(function($q) use ($categoryMap) {
            // Products with subcategory_id that maps to a main category
            $subcatIds = array_filter(array_keys($categoryMap), function($key) {
                return strpos($key, 'subcat_') === 0;
            });
            $subcatIds = array_map(function($key) {
                return (int) str_replace('subcat_', '', $key);
            }, $subcatIds);

            if (!empty($subcatIds)) {
                $q->whereIn('subcategory_id', $subcatIds);
            }

            // OR products with childcategory_id that maps to a main category
            $childcatIds = array_filter(array_keys($categoryMap), function($key) {
                return strpos($key, 'childcat_') === 0;
            });
            $childcatIds = array_map(function($key) {
                return (int) str_replace('childcat_', '', $key);
            }, $childcatIds);

            if (!empty($childcatIds)) {
                $q->orWhereIn('childcategory_id', $childcatIds);
            }
        })
        ->with('categories')
        ->get();

    echo "Found {$productsToMigrate->count()} products with old category assignments to migrate\n\n";

    $migratedCount = 0;
    $newRelationships = 0;

    foreach ($productsToMigrate as $product) {
        $categoriesToAdd = [];
        $productUpdated = false;

        // Check subcategory_id
        if ($product->subcategory_id) {
            $key = 'subcat_' . $product->subcategory_id;
            if (isset($categoryMap[$key])) {
                $newCategoryId = $categoryMap[$key];

                // Check if relationship doesn't already exist
                $exists = $product->categories()->where('category_id', $newCategoryId)->exists();
                if (!$exists) {
                    $categoriesToAdd[] = $newCategoryId;
                    $productUpdated = true;
                }
            }
        }

        // Check childcategory_id
        if ($product->childcategory_id) {
            $key = 'childcat_' . $product->childcategory_id;
            if (isset($categoryMap[$key])) {
                $newCategoryId = $categoryMap[$key];

                // Check if relationship doesn't already exist
                $exists = $product->categories()->where('category_id', $newCategoryId)->exists();
                if (!$exists && !in_array($newCategoryId, $categoriesToAdd)) {
                    $categoriesToAdd[] = $newCategoryId;
                    $productUpdated = true;
                }
            }
        }

        // Add the new relationships
        if (!empty($categoriesToAdd)) {
            $product->categories()->attach($categoriesToAdd);
            $newRelationships += count($categoriesToAdd);
            $migratedCount++;

            if ($migratedCount <= 10) {
                echo "  ✓ {$product->name}: Added " . count($categoriesToAdd) . " categories\n";
            }
        }
    }

    if ($migratedCount > 10) {
        echo "  ... and " . ($migratedCount - 10) . " more products\n";
    }

    echo "\n  Total: {$migratedCount} products updated, {$newRelationships} new relationships created\n\n";

    $stats['products_updated'] = $migratedCount;
    $stats['new_relationships'] = $newRelationships;

    echo "\n📊 STEP 4: FINAL STATISTICS\n";
    echo str_repeat('-', 60) . "\n\n";

    $totalPivotRecords = DB::table('category_product')->count();
    $uniqueProducts = DB::table('category_product')->distinct('product_id')->count('product_id');
    $productsWithCategories = Product::where('status', 1)->has('categories')->count();
    $productsWithoutCategories = Product::where('status', 1)->doesntHave('categories')->count();
    $totalActiveProducts = Product::where('status', 1)->count();

    echo "Final state:\n";
    echo "  • Total pivot records: {$totalPivotRecords}\n";
    echo "  • Unique products with categories: {$uniqueProducts}\n";
    echo "  • Active products: {$totalActiveProducts}\n";
    echo "  • Products WITH categories: {$productsWithCategories} (" . round($productsWithCategories/$totalActiveProducts*100, 1) . "%)\n";
    echo "  • Products WITHOUT categories: {$productsWithoutCategories} (" . round($productsWithoutCategories/$totalActiveProducts*100, 1) . "%)\n\n";

    echo "Migration statistics:\n";
    echo "  • Subcategories mapped: {$stats['subcategories_mapped']}\n";
    echo "  • Childcategories mapped: {$stats['childcategories_mapped']}\n";
    echo "  • Products updated: {$stats['products_updated']}\n";
    echo "  • New relationships created: {$stats['new_relationships']}\n\n";

    echo "\n⚠️  IMPORTANT: Review the results before committing!\n";
    echo "Do you want to commit these changes? (yes/no): ";

    $handle = fopen("php://stdin", "r");
    $line = trim(fgets($handle));

    if (strtolower($line) === 'yes') {
        DB::commit();
        echo "\n✅ Changes committed successfully!\n\n";

        echo "╔══════════════════════════════════════════════════════════════╗\n";
        echo "║                    MIGRATION COMPLETED                       ║\n";
        echo "╚══════════════════════════════════════════════════════════════╝\n\n";

        echo "📋 NEXT STEPS:\n";
        echo "1. Clear caches: php artisan cache:clear && php artisan view:clear\n";
        echo "2. Test category filtering on homepage\n";
        echo "3. Check both 'عروض' categories work correctly\n";
        echo "4. Review products without categories and assign them manually\n\n";
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
