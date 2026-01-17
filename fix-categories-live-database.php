<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

/**
 * PROFESSIONAL LIVE DATABASE CATEGORY CORRECTION
 * 
 * This analyzes your CURRENT live database and fixes category assignments
 * based on product names, brands, and keywords.
 */

echo "\n";
echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║   PROFESSIONAL LIVE DATABASE CATEGORY CORRECTION               ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// Step 1: Get all categories and products from live database
echo "📊 Step 1: Loading data from live database...\n\n";

$categories = DB::table('categories')
    ->where('status', 1)
    ->select('id', 'name')
    ->get()
    ->keyBy('name');

$products = DB::table('products')
    ->where('status', 1)
    ->select('id', 'name')
    ->get();

echo "  ✓ Found " . $categories->count() . " active categories\n";
echo "  ✓ Found " . $products->count() . " active products\n\n";

// Step 2: Build category mapping rules based on product names and keywords
echo "🔍 Step 2: Building intelligent category mapping rules...\n\n";

$categoryRules = [];

// Define mapping rules: category name => [keywords, brands, exclusions]
$ruleDefinitions = [
    'خالي جلوتين' => [
        'keywords' => ['شار', 'gluten free', 'خالي جلوتين', 'خالي من الجلوتين'],
        'brands' => ['شار'],
        'exclusions' => []
    ],
    'خالي سكر' => [
        'keywords' => ['خالي سكر', 'sugar free', 'ينجوين', 'ستيفيا', 'stevia', 'بدون سكر', 'خالي من السكر'],
        'brands' => ['ينجوين'],
        'exclusions' => []
    ],
    'كيتو' => [
        'keywords' => ['كيتو', 'keto', 'لايت اند سويت', 'low carb', 'منخفض الكربوهيدرات'],
        'brands' => ['لايت اند سويت'],
        'exclusions' => []
    ],
    'شكولاتة / حلوى' => [
        'keywords' => ['يم ايرث', 'فيدال', 'حلوى', 'حلويات', 'كاندي', 'candy', 'شوكولاتة', 'gummy'],
        'brands' => ['يم ايرث', 'فيدال'],
        'exclusions' => ['بروتين', 'protein']
    ],
    'نباتي' => [
        'keywords' => ['حليب نباتي', 'ميلك لاب', 'كويتا', 'plant milk', 'نباتي'],
        'brands' => ['ميلك لاب', 'كويتا'],
        'exclusions' => []
    ],
    'مشروبات' => [
        'keywords' => ['شاي', 'يوغي', 'tea', 'عصير', 'juice'],
        'brands' => ['يوغي'],
        'exclusions' => []
    ],
    'بهارات/ حبوب/ ماجي' => [
        'keywords' => ['فيجيتا', 'كوشار', 'باديا', 'بهارات', 'maggi', 'ماجي'],
        'brands' => ['فيجيتا', 'كوشار', 'باديا'],
        'exclusions' => []
    ],
    'واي بروتين' => [
        'keywords' => ['واي', 'whey', 'protein', 'بروتين'],
        'brands' => [],
        'exclusions' => ['iso', 'beef', 'vegan', 'نباتي', 'ايزو', 'بيف']
    ],
    'ايزو بروتين' => [
        'keywords' => ['ايزو', 'iso', 'isopure'],
        'brands' => [],
        'exclusions' => []
    ],
    'بيف بروتين' => [
        'keywords' => ['بيف', 'beef'],
        'brands' => [],
        'exclusions' => []
    ],
    'نباتي بروتين' => [
        'keywords' => ['نباتي بروتين', 'vegan protein', 'plant protein'],
        'brands' => [],
        'exclusions' => []
    ],
    'احماض امينية' => [
        'keywords' => ['امينو', 'amino', 'bcaa', 'eaa'],
        'brands' => [],
        'exclusions' => []
    ],
    'كرياتين' => [
        'keywords' => ['كرياتين', 'creatine'],
        'brands' => [],
        'exclusions' => []
    ],
    'كولاجين& فيتامين' => [
        'keywords' => ['فيتامين', 'vitamin', 'معادن', 'minerals', 'اوميغا', 'omega', 'كولاجين', 'collagen'],
        'brands' => [],
        'exclusions' => []
    ],
    'حوارق دهون' => [
        'keywords' => ['حارق', 'burner', 'fat burner', 'l-carnitine', 'كارنتين'],
        'brands' => [],
        'exclusions' => []
    ],
    'ماس' => [
        'keywords' => ['ماس', 'mass', 'gainer'],
        'brands' => [],
        'exclusions' => []
    ],
];

// Build rules with actual category IDs from database
foreach ($ruleDefinitions as $categoryName => $rules) {
    $category = $categories->get($categoryName);
    if ($category) {
        $categoryRules[$category->id] = [
            'name' => $categoryName,
            'keywords' => $rules['keywords'],
            'brands' => $rules['brands'],
            'exclusions' => $rules['exclusions']
        ];
    }
}

echo "  ✓ Defined " . count($categoryRules) . " category matching rules\n\n";

// Step 3: Analyze products and match to categories
echo "🔬 Step 3: Analyzing " . $products->count() . " products...\n\n";

$corrections = [];
$matched = 0;
$unmatched = [];

foreach ($products as $product) {
    $productName = mb_strtolower($product->name);
    $productCategories = [];
    
    foreach ($categoryRules as $categoryId => $rule) {
        $matches = false;
        
        // Check keywords
        foreach ($rule['keywords'] as $keyword) {
            if (mb_stripos($productName, mb_strtolower($keyword)) !== false) {
                $matches = true;
                break;
            }
        }
        
        // Check exclusions
        if ($matches) {
            foreach ($rule['exclusions'] as $exclusion) {
                if (mb_stripos($productName, mb_strtolower($exclusion)) !== false) {
                    $matches = false;
                    break;
                }
            }
        }
        
        if ($matches) {
            $productCategories[] = $categoryId;
        }
    }
    
    if (!empty($productCategories)) {
        $corrections[$product->id] = [
            'name' => $product->name,
            'categories' => $productCategories
        ];
        $matched++;
    } else {
        $unmatched[] = $product->name;
    }
}

echo "  ✓ Successfully matched {$matched} products\n";
echo "  ⚠️  {$unmatched_count} products need manual review\n\n" . ($unmatched_count = count($unmatched));

if (!empty($unmatched) && count($unmatched) <= 20) {
    echo "  Products needing manual review:\n";
    foreach (array_slice($unmatched, 0, 20) as $name) {
        echo "    • {$name}\n";
    }
    echo "\n";
}

// Step 4: Generate statistics
echo "📈 Step 4: Correction Statistics\n\n";

$categoryCount = [];
foreach ($corrections as $data) {
    foreach ($data['categories'] as $catId) {
        $catName = $categoryRules[$catId]['name'];
        if (!isset($categoryCount[$catName])) {
            $categoryCount[$catName] = 0;
        }
        $categoryCount[$catName]++;
    }
}

arsort($categoryCount);

echo "Products per category:\n";
foreach ($categoryCount as $catName => $count) {
    echo "  • {$catName}: {$count} products\n";
}

// Step 5: Generate SQL file
echo "\n🔧 Step 5: Generating correction SQL...\n\n";

$sqlStatements = [];
$sqlStatements[] = "-- Live Database Category Corrections";
$sqlStatements[] = "-- Generated: " . date('Y-m-d H:i:s');
$sqlStatements[] = "-- Total products: " . count($corrections);
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

$sqlFile = 'fix-categories-live.sql';
file_put_contents($sqlFile, implode("\n", $sqlStatements));

echo "  ✓ SQL file saved: {$sqlFile}\n";

// Step 6: Ask for confirmation
echo "\n";
echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║   READY TO APPLY CORRECTIONS                                    ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

echo "Summary:\n";
echo "  • Products to correct: " . count($corrections) . "\n";
echo "  • Categories affected: " . count($categoryCount) . "\n";
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
        
        echo "  • Processing " . count($corrections) . " products...\n";
        
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
        $productsWithCategories = DB::table('category_product')
            ->distinct('product_id')
            ->count('product_id');
            
        echo "Final Statistics:\n";
        echo "  • Total category-product relations: {$finalStats}\n";
        echo "  • Products with categories: {$productsWithCategories}\n";
        echo "  • Products updated: " . count($corrections) . "\n\n";
        
        echo "🎉 Categories are now correctly assigned based on product names!\n";
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
