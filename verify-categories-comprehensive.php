<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\DB;

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Comprehensive Category-Product Verification ===\n\n";

// Get all categories with their details
$categories = DB::table('ec_product_categories')
    ->where('status', 'published')
    ->orderBy('name')
    ->get();

echo "Total categories: " . $categories->count() . "\n\n";

// Check for duplicate category names
$categoryNames = $categories->groupBy('name');
$duplicates = $categoryNames->filter(function($group) {
    return $group->count() > 1;
});

if ($duplicates->count() > 0) {
    echo "⚠️  WARNING: Found duplicate category names:\n";
    foreach ($duplicates as $name => $group) {
        echo "  - '$name' appears " . $group->count() . " times (IDs: " .
             $group->pluck('id')->implode(', ') . ")\n";
    }
    echo "\n";
}

// Analyze each category
$issuesFound = [];
$totalProducts = 0;
$totalRelationships = 0;

foreach ($categories as $category) {
    $products = $category->products()->where('status', 'published')->get();
    $productCount = $products->count();
    $totalProducts += $productCount;

    // Get relationship count
    $relationshipCount = DB::table('category_product')
        ->where('category_id', $category->id)
        ->count();
    $totalRelationships += $relationshipCount;

    echo "Category: {$category->name} (ID: {$category->id})\n";
    echo "  Products: $productCount\n";
    echo "  Parent ID: " . ($category->parent_id ?: 'None (Root category)') . "\n";

    // Sample products in this category
    if ($productCount > 0) {
        echo "  Sample products:\n";
        $sampleProducts = $products->take(5);
        foreach ($sampleProducts as $product) {
            echo "    - {$product->name} (ID: {$product->id})\n";

            // Check if product name matches category
            $productNameLower = mb_strtolower($product->name);
            $categoryNameLower = mb_strtolower($category->name);

            // Define keyword mappings for validation
            $categoryKeywords = [
                'خالي جلوتين' => ['شار', 'خالي', 'جلوتين', 'gluten'],
                'خالي سكر' => ['سكر', 'ستيفيا', 'محلي', 'مربى', 'sugar'],
                'كيتو' => ['كيتو', 'لايت', 'سويت', 'keto', 'light'],
                'بروتين' => ['بروتين', 'protein', 'واي', 'whey'],
                'فيتامينات' => ['فيتامين', 'vitamin'],
                'معادن' => ['معدن', 'mineral', 'زنك', 'حديد'],
                'أوميغا' => ['أوميغا', 'omega'],
                'حلوى' => ['حلوى', 'يم', 'yum', 'سوس', 'مصاص'],
                'مربى' => ['مربى', 'ينجوين'],
                'بديل ماجي' => ['ماجي', 'كوشار', 'فيجيتا', 'vegeta', 'ادوبو'],
                'شاي' => ['شاي', 'يوغي', 'tea', 'yogi'],
                'حليب' => ['حليب', 'ميلك', 'milk', 'لوز', 'شوفان', 'جوز'],
            ];

            // Check if product seems misplaced
            $seemsMisplaced = false;
            $suggestedCategory = null;

            foreach ($categoryKeywords as $catName => $keywords) {
                if (stripos($categoryNameLower, $catName) !== false) {
                    // This is the category we're checking
                    $hasMatchingKeyword = false;
                    foreach ($keywords as $keyword) {
                        if (stripos($productNameLower, $keyword) !== false) {
                            $hasMatchingKeyword = true;
                            break;
                        }
                    }
                    if (!$hasMatchingKeyword) {
                        $seemsMisplaced = true;
                    }
                } else {
                    // Check if product better matches another category
                    foreach ($keywords as $keyword) {
                        if (stripos($productNameLower, $keyword) !== false) {
                            $suggestedCategory = $catName;
                            break 2;
                        }
                    }
                }
            }

            if ($seemsMisplaced && $suggestedCategory) {
                $issuesFound[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'current_category' => $category->name,
                    'current_category_id' => $category->id,
                    'suggested_category' => $suggestedCategory,
                ];
            }
        }
    }
    echo "\n";
}

echo "=== Summary ===\n";
echo "Total unique products across categories: $totalProducts\n";
echo "Total category-product relationships: $totalRelationships\n\n";

// Show potential issues
if (count($issuesFound) > 0) {
    echo "⚠️  POTENTIAL ISSUES FOUND (" . count($issuesFound) . " products):\n\n";
    foreach ($issuesFound as $issue) {
        echo "Product: {$issue['product_name']} (ID: {$issue['product_id']})\n";
        echo "  Current category: {$issue['current_category']} (ID: {$issue['current_category_id']})\n";
        echo "  Suggested category: {$issue['suggested_category']}\n\n";
    }

    // Create correction SQL
    echo "\n=== Suggested Corrections (SQL) ===\n";
    echo "-- Review these carefully before executing!\n\n";

    foreach ($issuesFound as $issue) {
        // Find the suggested category ID
        $suggestedCat = Category::where('name', 'like', '%' . $issue['suggested_category'] . '%')
            ->where('status', 'published')
            ->first();

        if ($suggestedCat) {
            echo "-- Move '{$issue['product_name']}' from '{$issue['current_category']}' to '{$suggestedCat->name}'\n";
            echo "DELETE FROM category_product WHERE product_id = {$issue['product_id']} AND category_id = {$issue['current_category_id']};\n";
            echo "INSERT INTO category_product (category_id, product_id) VALUES ({$suggestedCat->id}, {$issue['product_id']});\n\n";
        }
    }
} else {
    echo "✅ No obvious category mismatches detected!\n";
    echo "All products appear to be in appropriate categories based on name analysis.\n";
}

// Check for products with unusual category counts
echo "\n=== Products with Multiple Categories ===\n";
$productsWithMultipleCategories = DB::table('category_product')
    ->select('product_id', DB::raw('COUNT(*) as category_count'))
    ->groupBy('product_id')
    ->having('category_count', '>', 3)
    ->orderBy('category_count', 'desc')
    ->limit(10)
    ->get();

foreach ($productsWithMultipleCategories as $pc) {
    $product = Product::find($pc->product_id);
    if ($product) {
        echo "Product: {$product->name} (ID: {$pc->product_id})\n";
        echo "  Number of categories: {$pc->category_count}\n";
        $cats = $product->categories()->pluck('name')->toArray();
        echo "  Categories: " . implode(', ', $cats) . "\n\n";
    }
}

echo "\n=== Verification Complete ===\n";
