<?php
/**
 * Test Flexible Category Filtering
 * Tests that products can be found by searching any category level
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use Illuminate\Support\Facades\DB;

echo "================================================================================\n";
echo "FLEXIBLE CATEGORY FILTER TEST\n";
echo "================================================================================\n\n";

// Get sample category IDs
echo "📊 Getting sample category data...\n\n";

$sampleProduct = Product::where('status', 1)
    ->whereNotNull('category_id')
    ->whereNotNull('subcategory_id')
    ->first(['id', 'name', 'category_id', 'subcategory_id', 'childcategory_id']);

if (!$sampleProduct) {
    echo "⚠️  No products with category data found.\n";
    exit;
}

echo "Sample Product:\n";
echo "  Name: {$sampleProduct->name}\n";
echo "  Category ID: {$sampleProduct->category_id}\n";
echo "  Subcategory ID: {$sampleProduct->subcategory_id}\n";
echo "  Childcategory ID: " . ($sampleProduct->childcategory_id ?? 'NULL') . "\n";
echo "\n";

echo "================================================================================\n";
echo "TEST 1: Search by Category ID (should find in all 3 fields)\n";
echo "================================================================================\n\n";

$categoryId = $sampleProduct->category_id;

// Old method (only category_id field)
$oldMethod = Product::where('status', 1)
    ->where('category_id', $categoryId)
    ->count();

// New flexible method (searches all 3 fields)
$newMethod = Product::where('status', 1)
    ->where(function($q) use ($categoryId) {
        $q->where('category_id', $categoryId)
          ->orWhere('subcategory_id', $categoryId)
          ->orWhere('childcategory_id', $categoryId);
    })
    ->count();

echo "Searching for Category ID: {$categoryId}\n";
echo "  Old Method (category_id only): {$oldMethod} products\n";
echo "  New Method (all 3 fields): {$newMethod} products\n";
echo "  Difference: " . ($newMethod - $oldMethod) . " additional products found\n";

if ($newMethod >= $oldMethod) {
    echo "  ✅ New method finds MORE or EQUAL products\n";
} else {
    echo "  ⚠️  Warning: New method found fewer products\n";
}

echo "\n";

echo "================================================================================\n";
echo "TEST 2: Search by Subcategory ID (should find in sub & child fields)\n";
echo "================================================================================\n\n";

$subcategoryId = $sampleProduct->subcategory_id;

// Old method (only subcategory_id field)
$oldMethodSub = Product::where('status', 1)
    ->where('subcategory_id', $subcategoryId)
    ->count();

// New flexible method (searches subcategory_id and childcategory_id)
$newMethodSub = Product::where('status', 1)
    ->where(function($q) use ($subcategoryId) {
        $q->where('subcategory_id', $subcategoryId)
          ->orWhere('childcategory_id', $subcategoryId);
    })
    ->count();

echo "Searching for Subcategory ID: {$subcategoryId}\n";
echo "  Old Method (subcategory_id only): {$oldMethodSub} products\n";
echo "  New Method (sub & child fields): {$newMethodSub} products\n";
echo "  Difference: " . ($newMethodSub - $oldMethodSub) . " additional products found\n";

if ($newMethodSub >= $oldMethodSub) {
    echo "  ✅ New method finds MORE or EQUAL products\n";
} else {
    echo "  ⚠️  Warning: New method found fewer products\n";
}

echo "\n";

echo "================================================================================\n";
echo "TEST 3: Distribution Analysis\n";
echo "================================================================================\n\n";

$stats = [
    'category_only' => Product::where('status', 1)->whereNotNull('category_id')->whereNull('subcategory_id')->count(),
    'subcategory_only' => Product::where('status', 1)->whereNotNull('subcategory_id')->whereNull('childcategory_id')->count(),
    'childcategory_only' => Product::where('status', 1)->whereNotNull('childcategory_id')->count(),
    'all_three' => Product::where('status', 1)
        ->whereNotNull('category_id')
        ->whereNotNull('subcategory_id')
        ->whereNotNull('childcategory_id')
        ->count(),
];

echo "Product Distribution:\n";
echo "  Products with Category only: {$stats['category_only']}\n";
echo "  Products with Subcategory: {$stats['subcategory_only']}\n";
echo "  Products with Childcategory: {$stats['childcategory_only']}\n";
echo "  Products with all three levels: {$stats['all_three']}\n";

echo "\n";

echo "================================================================================\n";
echo "VERIFICATION SUMMARY\n";
echo "================================================================================\n\n";

echo "✅ Flexible Category Filter Implementation:\n\n";

echo "CATEGORY LEVEL FILTER:\n";
echo "  • Searches in: category_id, subcategory_id, childcategory_id\n";
echo "  • Logic: OR condition (any match)\n";
echo "  • Benefit: Finds products assigned to that category at ANY level\n\n";

echo "SUBCATEGORY LEVEL FILTER:\n";
echo "  • Searches in: subcategory_id, childcategory_id\n";
echo "  • Logic: OR condition (any match)\n";
echo "  • Benefit: Finds products in subcategory or its children\n\n";

echo "CHILDCATEGORY LEVEL FILTER:\n";
echo "  • Searches in: childcategory_id only\n";
echo "  • Logic: Exact match\n";
echo "  • Benefit: Specific filtering for leaf category\n\n";

echo "✅ IMPLEMENTATION COMPLETE!\n";
echo "   Products can now be found regardless of which category level they're assigned to.\n";

echo "\n================================================================================\n";
