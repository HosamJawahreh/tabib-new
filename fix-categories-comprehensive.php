<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\DB;

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║   COMPREHENSIVE CATEGORY-PRODUCT CORRECTION SYSTEM              ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// Step 1: Analyze current database structure
echo "📊 Step 1: Analyzing current database structure...\n\n";

$categories = DB::table('categories')
    ->where('status', 1)
    ->orderBy('name')
    ->get();

$products = DB::table('products')
    ->where('status', 1)
    ->get();

$currentRelations = DB::table('category_product')->get();

echo "✓ Total categories: " . $categories->count() . "\n";
echo "✓ Total products: " . $products->count() . "\n";
echo "✓ Current category-product relations: " . $currentRelations->count() . "\n\n";

// Step 2: Check for duplicate category names
echo "📋 Step 2: Checking for duplicate category names...\n\n";

$categoryGroups = [];
foreach ($categories as $cat) {
    $name = trim($cat->name);
    if (!isset($categoryGroups[$name])) {
        $categoryGroups[$name] = [];
    }
    $categoryGroups[$name][] = $cat;
}

$duplicates = array_filter($categoryGroups, function($group) {
    return count($group) > 1;
});

if (count($duplicates) > 0) {
    echo "⚠️  Found duplicate category names:\n";
    foreach ($duplicates as $name => $group) {
        echo "  • '$name' (IDs: " . implode(', ', array_map(fn($c) => $c->id, $group)) . ")\n";
        echo "    Recommendation: Keep the most used one, merge others\n";
    }
    echo "\n";
} else {
    echo "✓ No duplicate category names found\n\n";
}

// Step 3: Define comprehensive category mapping rules
echo "🔍 Step 3: Defining category mapping rules...\n\n";

$categoryRules = [
    'خالي جلوتين' => [
        'keywords' => ['شار', 'schar', 'خالي جلوتين', 'gluten free', 'بسكويت ويفر'],
        'brands' => ['شار'],
        'exclude' => ['حليب', 'milk', 'يوغي', 'yogi'],
    ],
    'خالي سكر' => [
        'keywords' => ['ينجوين', 'مربى', 'سكر', 'ستيفيا', 'stevia', 'jam', 'sugar free', 'محلي'],
        'brands' => ['ينجوين', 'لايت اند سويت'],
    ],
    'كيتو' => [
        'keywords' => ['كيتو', 'keto', 'لايت اند سويت', 'light and sweet', 'منخفض النشويات', 'low carb'],
        'brands' => ['لايت اند سويت'],
    ],
    'حلوى' => [
        'keywords' => ['يم ايرث', 'yum earth', 'فيدال', 'vidal', 'سوس', 'مصاص', 'lollipop', 'حلوى', 'candy', 'جلي', 'gummy'],
        'brands' => ['يم ايرث', 'فيدال'],
    ],
    'حليب نباتي' => [
        'keywords' => ['حليب', 'milk', 'ميلك لاب', 'milklab', 'كويتا', 'لوز', 'شوفان', 'جوز هند', 'almond', 'oat', 'coconut'],
        'brands' => ['ميلك لاب', 'كويتا'],
        'exclude' => ['بروتين', 'protein'],
    ],
    'شاي' => [
        'keywords' => ['شاي', 'tea', 'يوغي', 'yogi'],
        'brands' => ['يوغي'],
    ],
    'بديل ماجي' => [
        'keywords' => ['ماجي', 'maggi', 'بديل', 'فيجيتا', 'vegeta', 'كوشار', 'ادوبو', 'adobo', 'بهارات'],
        'brands' => ['فيجيتا', 'كوشار', 'باديا'],
    ],
    'واي بروتين' => [
        'keywords' => ['بروتين', 'protein', 'واي', 'whey'],
        'brands' => [],
    ],
    'كرياتين' => [
        'keywords' => ['كرياتين', 'creatine'],
        'brands' => [],
    ],
    'امينو' => [
        'keywords' => ['امينو', 'amino', 'bcaa'],
        'brands' => [],
    ],
    'فيتامينات' => [
        'keywords' => ['فيتامين', 'vitamin'],
        'brands' => [],
    ],
    'معادن' => [
        'keywords' => ['معدن', 'mineral', 'كالسيوم', 'calcium', 'زنك', 'zinc', 'حديد', 'iron', 'مغنيسيوم', 'magnesium'],
        'brands' => [],
    ],
    'اوميغا' => [
        'keywords' => ['أوميغا', 'اوميغا', 'omega'],
        'brands' => [],
    ],
];

echo "✓ Defined " . count($categoryRules) . " category rules\n\n";

// Step 4: Analyze each product and suggest correct categories
echo "🔬 Step 4: Analyzing products and finding correct categories...\n\n";

$corrections = [];
$unmatchedProducts = [];

foreach ($products as $product) {
    $productName = mb_strtolower($product->name);
    $matchedCategories = [];
    
    foreach ($categoryRules as $categoryName => $rules) {
        $matches = false;
        
        // Check keywords
        foreach ($rules['keywords'] as $keyword) {
            if (stripos($productName, mb_strtolower($keyword)) !== false) {
                $matches = true;
                break;
            }
        }
        
        // Check brands
        if (!$matches && isset($rules['brands'])) {
            foreach ($rules['brands'] as $brand) {
                if (stripos($productName, mb_strtolower($brand)) !== false) {
                    $matches = true;
                    break;
                }
            }
        }
        
        // Check exclusions
        if ($matches && isset($rules['exclude'])) {
            foreach ($rules['exclude'] as $exclude) {
                if (stripos($productName, mb_strtolower($exclude)) !== false) {
                    $matches = false;
                    break;
                }
            }
        }
        
        if ($matches) {
            $matchedCategories[] = $categoryName;
        }
    }
    
    if (count($matchedCategories) > 0) {
        $corrections[$product->id] = [
            'product' => $product,
            'categories' => $matchedCategories,
        ];
    } else {
        $unmatchedProducts[] = $product;
    }
}

echo "✓ Matched " . count($corrections) . " products to categories\n";
echo "⚠️  " . count($unmatchedProducts) . " products need manual review\n\n";

// Step 5: Display analysis results
echo "📈 Step 5: Analysis Results\n\n";

$categoryStats = [];
foreach ($corrections as $productId => $data) {
    foreach ($data['categories'] as $catName) {
        if (!isset($categoryStats[$catName])) {
            $categoryStats[$catName] = 0;
        }
        $categoryStats[$catName]++;
    }
}

arsort($categoryStats);

echo "Products per category:\n";
foreach ($categoryStats as $catName => $count) {
    echo "  • $catName: $count products\n";
}
echo "\n";

// Step 6: Show unmatched products
if (count($unmatchedProducts) > 0) {
    echo "⚠️  Products needing manual review (first 20):\n";
    $sample = array_slice($unmatchedProducts, 0, 20);
    foreach ($sample as $product) {
        echo "  • [{$product->id}] {$product->name}\n";
    }
    echo "\n";
}

// Step 7: Generate correction SQL
echo "🔧 Step 6: Generating correction SQL...\n\n";

$sqlStatements = [];
$sqlStatements[] = "-- Category-Product Relationship Corrections";
$sqlStatements[] = "-- Generated: " . date('Y-m-d H:i:s');
$sqlStatements[] = "-- Total products to fix: " . count($corrections);
$sqlStatements[] = "";
$sqlStatements[] = "START TRANSACTION;";
$sqlStatements[] = "";

// First, remove all existing relationships for products we're fixing
$sqlStatements[] = "-- Step 1: Remove existing incorrect relationships";
$productIds = array_keys($corrections);
$chunks = array_chunk($productIds, 100);

foreach ($chunks as $chunk) {
    $ids = implode(',', $chunk);
    $sqlStatements[] = "DELETE FROM category_product WHERE product_id IN ($ids);";
}
$sqlStatements[] = "";

// Then, add correct relationships
$sqlStatements[] = "-- Step 2: Add correct category relationships";

foreach ($corrections as $productId => $data) {
    $product = $data['product'];
    $categoryNames = $data['categories'];
    
    $sqlStatements[] = "-- Product: {$product->name}";
    
    foreach ($categoryNames as $catName) {
        // Find matching category in database
        $matchingCat = $categories->first(function($cat) use ($catName) {
            return stripos(mb_strtolower($cat->name), mb_strtolower($catName)) !== false;
        });
        
        if ($matchingCat) {
            $sqlStatements[] = "INSERT IGNORE INTO category_product (category_id, product_id) VALUES ({$matchingCat->id}, {$productId});";
        } else {
            $sqlStatements[] = "-- WARNING: Category '$catName' not found in database for product {$productId}";
        }
    }
    $sqlStatements[] = "";
}

$sqlStatements[] = "COMMIT;";
$sqlStatements[] = "";
$sqlStatements[] = "-- End of corrections";

// Save SQL to file
$sqlFile = __DIR__ . '/fix-categories.sql';
file_put_contents($sqlFile, implode("\n", $sqlStatements));

echo "✓ SQL corrections saved to: fix-categories.sql\n\n";

// Step 7: Ask for confirmation
echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║   READY TO APPLY CORRECTIONS                                    ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

echo "Summary:\n";
echo "  • Products to correct: " . count($corrections) . "\n";
echo "  • Categories affected: " . count($categoryStats) . "\n";
echo "  • SQL file generated: fix-categories.sql\n\n";

echo "What would you like to do?\n";
echo "  1. Apply corrections automatically (RECOMMENDED)\n";
echo "  2. Exit and review SQL file manually\n\n";

echo "Enter choice (1 or 2): ";
$handle = fopen("php://stdin", "r");
$choice = trim(fgets($handle));

if ($choice == '1') {
    echo "\n🚀 Applying corrections...\n\n";
    
    try {
        DB::beginTransaction();
        
        // Remove old relationships
        echo "  • Removing old relationships...\n";
        foreach ($chunks as $chunk) {
            DB::table('category_product')
                ->whereIn('product_id', $chunk)
                ->delete();
        }
        
        // Add new relationships
        echo "  • Adding correct relationships...\n";
        $insertData = [];
        
        foreach ($corrections as $productId => $data) {
            foreach ($data['categories'] as $catName) {
                $matchingCat = $categories->first(function($cat) use ($catName) {
                    return stripos(mb_strtolower($cat->name), mb_strtolower($catName)) !== false;
                });
                
                if ($matchingCat) {
                    $insertData[] = [
                        'category_id' => $matchingCat->id,
                        'product_id' => $productId,
                    ];
                }
            }
        }
        
        // Insert in batches
        $batches = array_chunk($insertData, 500);
        foreach ($batches as $batch) {
            DB::table('category_product')->insertOrIgnore($batch);
        }
        
        DB::commit();
        
        echo "\n✅ SUCCESS! All corrections applied!\n\n";
        
        // Final statistics
        $newRelations = DB::table('category_product')->count();
        echo "Final Statistics:\n";
        echo "  • Total category-product relations: $newRelations\n";
        echo "  • Products with categories: " . count($corrections) . "\n";
        echo "  • Average categories per product: " . round($newRelations / $products->count(), 2) . "\n\n";
        
        echo "🎉 Your categories are now correctly organized!\n";
        echo "   Products will now appear in the correct categories on your homepage.\n\n";
        
    } catch (\Exception $e) {
        DB::rollBack();
        echo "\n❌ ERROR: " . $e->getMessage() . "\n";
        echo "   No changes were made. Please check the error and try again.\n\n";
    }
    
} else {
    echo "\n📝 Exiting. Please review 'fix-categories.sql' and apply manually.\n\n";
}

echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║   PROCESS COMPLETE                                              ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n";
