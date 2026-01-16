<?php
/**
 * Migrate Multi-Category Relationships
 * Maps old product-category relationships to new pivot table
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;

echo "================================================================================\n";
echo "MIGRATE MULTI-CATEGORY RELATIONSHIPS\n";
echo "================================================================================\n\n";

echo "📊 Step 1: Loading Old Data\n";
echo "--------------------------------------------------------------------------------\n\n";

// Parse old categories
echo "Reading categories from SQL file...\n";
$categoriesFile = file_get_contents(__DIR__ . '/public/ec_product_categories (1).sql');
preg_match_all('/\((\d+),\s*\'([^\']+)\',\s*(\d+)/', $categoriesFile, $catMatches);

$oldCategories = [];
$categoryParents = [];
for ($i = 0; $i < count($catMatches[1]); $i++) {
    $id = $catMatches[1][$i];
    $name = str_replace("\\'", "'", $catMatches[2][$i]);
    $parentId = $catMatches[3][$i];
    
    $oldCategories[$id] = $name;
    $categoryParents[$id] = $parentId;
}

echo "Loaded " . count($oldCategories) . " old categories\n\n";

// Parse old products
echo "Reading products from SQL file...\n";
$productsFile = file_get_contents(__DIR__ . '/public/ec_products.sql');
preg_match_all('/\((\d+),\s*\'([^\']+)\'/', $productsFile, $prodMatches);

$oldProducts = [];
for ($i = 0; $i < count($prodMatches[1]); $i++) {
    $id = $prodMatches[1][$i];
    $name = str_replace("\\'", "'", $prodMatches[2][$i]);
    $oldProducts[$id] = $name;
}

echo "Loaded " . count($oldProducts) . " old products\n\n";

// Parse relationships
echo "Reading product-category relationships...\n";
$relationshipsFile = file_get_contents(__DIR__ . '/public/ec_product_category_product.sql');
preg_match_all('/\((\d+),\s*(\d+)\)/', $relationshipsFile, $relMatches);

$oldRelationships = [];
for ($i = 0; $i < count($relMatches[1]); $i++) {
    $categoryId = $relMatches[1][$i];
    $productId = $relMatches[2][$i];
    
    if (!isset($oldRelationships[$productId])) {
        $oldRelationships[$productId] = [];
    }
    
    $oldRelationships[$productId][] = $categoryId;
}

echo "Loaded " . count($relMatches[1]) . " relationships for " . count($oldRelationships) . " products\n\n";

echo "📊 Step 2: Mapping to Current Database\n";
echo "--------------------------------------------------------------------------------\n\n";

// Get current categories
echo "Loading current categories...\n";
$currentCategories = Category::all()->keyBy('name');
echo "Found " . $currentCategories->count() . " current categories\n\n";

// Create category mapping
$categoryMapping = [];
foreach ($oldCategories as $oldId => $oldName) {
    $found = $currentCategories->get($oldName);
    if ($found) {
        $categoryMapping[$oldId] = $found->id;
    }
}

echo "Mapped " . count($categoryMapping) . " categories successfully\n";
$unmappedCategories = array_diff_key($oldCategories, $categoryMapping);
echo "Unmapped categories: " . count($unmappedCategories) . "\n";

if (count($unmappedCategories) > 0 && count($unmappedCategories) <= 20) {
    echo "\nUnmapped categories:\n";
    foreach ($unmappedCategories as $oldId => $name) {
        echo "  • ID $oldId: $name\n";
    }
}

// Get current products
echo "\n\nLoading current products...\n";
$currentProducts = Product::all()->keyBy('name');
echo "Found " . $currentProducts->count() . " current products\n\n";

// Create product mapping
$productMapping = [];
foreach ($oldProducts as $oldId => $oldName) {
    $found = $currentProducts->get($oldName);
    if ($found) {
        $productMapping[$oldId] = $found->id;
    }
}

echo "Mapped " . count($productMapping) . " products successfully\n";
echo "Unmapped products: " . (count($oldProducts) - count($productMapping)) . "\n\n";

echo "📊 Step 3: Populating Pivot Table\n";
echo "--------------------------------------------------------------------------------\n\n";

// Clear existing data
DB::table('category_product')->truncate();
echo "Cleared existing pivot table data\n\n";

$inserted = 0;
$skipped = 0;
$skippedReasons = [
    'product_not_found' => 0,
    'category_not_found' => 0,
    'already_exists' => 0,
];

$insertBatch = [];
$batchSize = 1000;

echo "Processing relationships...\n";

foreach ($oldRelationships as $oldProductId => $oldCategoryIds) {
    // Map product ID
    if (!isset($productMapping[$oldProductId])) {
        $skipped += count($oldCategoryIds);
        $skippedReasons['product_not_found'] += count($oldCategoryIds);
        continue;
    }
    
    $newProductId = $productMapping[$oldProductId];
    
    foreach ($oldCategoryIds as $oldCategoryId) {
        // Map category ID
        if (!isset($categoryMapping[$oldCategoryId])) {
            $skipped++;
            $skippedReasons['category_not_found']++;
            continue;
        }
        
        $newCategoryId = $categoryMapping[$oldCategoryId];
        
        // Add to batch
        $insertBatch[] = [
            'category_id' => $newCategoryId,
            'product_id' => $newProductId,
        ];
        
        // Insert batch
        if (count($insertBatch) >= $batchSize) {
            try {
                DB::table('category_product')->insertOrIgnore($insertBatch);
                $inserted += count($insertBatch);
                $insertBatch = [];
                echo ".";
            } catch (\Exception $e) {
                echo "E";
                $skipped += count($insertBatch);
                $skippedReasons['already_exists'] += count($insertBatch);
                $insertBatch = [];
            }
        }
    }
}

// Insert remaining
if (count($insertBatch) > 0) {
    try {
        DB::table('category_product')->insertOrIgnore($insertBatch);
        $inserted += count($insertBatch);
    } catch (\Exception $e) {
        $skipped += count($insertBatch);
        $skippedReasons['already_exists'] += count($insertBatch);
    }
}

echo "\n\n";

echo "✅ Migration Complete!\n\n";

echo "Results:\n";
echo "  • Inserted: $inserted relationships\n";
echo "  • Skipped: $skipped relationships\n";

if ($skipped > 0) {
    echo "\nSkipped Reasons:\n";
    foreach ($skippedReasons as $reason => $count) {
        if ($count > 0) {
            echo "  • " . str_replace('_', ' ', ucfirst($reason)) . ": $count\n";
        }
    }
}

// Verify
$totalInPivot = DB::table('category_product')->count();
echo "\n\nVerification:\n";
echo "  • Total relationships in pivot table: $totalInPivot\n";

// Sample products
echo "\n\nSample Product Categories:\n";
$sampleProducts = Product::with('categories')->where('status', 1)->limit(5)->get();

foreach ($sampleProducts as $product) {
    echo "\n  Product: {$product->name}\n";
    echo "    Categories (" . $product->categories->count() . "):\n";
    foreach ($product->categories as $category) {
        echo "      • {$category->name}\n";
    }
}

echo "\n================================================================================\n";
