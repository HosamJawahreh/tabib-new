<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\DB;

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Category-Product Analysis ===\n\n";

// Get all categories
$categories = DB::table('ec_product_categories')
    ->where('status', 'published')
    ->orderBy('name')
    ->get();

echo "Total active categories: " . count($categories) . "\n\n";

// Check for duplicate names
$nameGroups = [];
foreach ($categories as $cat) {
    if (!isset($nameGroups[$cat->name])) {
        $nameGroups[$cat->name] = [];
    }
    $nameGroups[$cat->name][] = $cat->id;
}

echo "=== Duplicate Category Names ===\n";
$hasDuplicates = false;
foreach ($nameGroups as $name => $ids) {
    if (count($ids) > 1) {
        echo "⚠️  '$name' appears " . count($ids) . " times (IDs: " . implode(', ', $ids) . ")\n";
        $hasDuplicates = true;
    }
}
if (!$hasDuplicates) {
    echo "✅ No duplicate category names found\n";
}
echo "\n";

// Analyze each category
echo "=== Category Analysis ===\n\n";

// Define category keywords for validation
$categoryKeywords = [
    'خالي جلوتين' => ['شار', 'خالي', 'جلوتين', 'gluten', 'schar'],
    'خالي سكر' => ['سكر', 'ستيفيا', 'محلي', 'مربى', 'sugar', 'ينجوين', 'stevia'],
    'كيتو' => ['كيتو', 'لايت', 'سويت', 'keto', 'light'],
    'واي بروتين' => ['بروتين', 'protein', 'واي', 'whey'],
    'فيتامينات' => ['فيتامين', 'vitamin'],
    'معادن' => ['معدن', 'mineral', 'زنك', 'حديد', 'كالسيوم'],
    'أوميغا' => ['أوميغا', 'omega'],
    'حلوى' => ['حلوى', 'يم', 'yum', 'سوس', 'مصاص', 'جلي', 'lollipop'],
    'مربى' => ['مربى', 'ينجوين', 'jam'],
    'بديل ماجي' => ['ماجي', 'كوشار', 'فيجيتا', 'vegeta', 'ادوبو', 'adobo', 'بهارات'],
    'شاي' => ['شاي', 'يوغي', 'tea', 'yogi'],
    'حليب نباتي' => ['حليب', 'ميلك', 'milk', 'لوز', 'شوفان', 'جوز', 'almond', 'oat'],
];

$issuesFound = [];
$totalRelationships = 0;

foreach ($categories as $category) {
    // Get products in this category
    $productRelations = DB::table('category_product')
        ->where('category_id', $category->id)
        ->get();

    $productCount = count($productRelations);
    $totalRelationships += $productCount;

    echo "Category: {$category->name} (ID: {$category->id})\n";
    echo "  Products: $productCount\n";
    echo "  Parent ID: " . ($category->parent_id ?: 'Root') . "\n";

    if ($productCount > 0) {
        // Sample 5 products
        $sampleRelations = array_slice($productRelations->toArray(), 0, 5);
        echo "  Sample products:\n";

        foreach ($sampleRelations as $relation) {
            $product = DB::table('ec_products')
                ->where('id', $relation->product_id)
                ->first();

            if ($product) {
                echo "    - {$product->name} (ID: {$product->id})\n";

                // Check if product matches category keywords
                $productNameLower = mb_strtolower($product->name);
                $categoryNameLower = mb_strtolower($category->name);

                $matchesCategory = false;
                $betterCategory = null;

                // Check current category
                foreach ($categoryKeywords as $catKey => $keywords) {
                    if (stripos($categoryNameLower, mb_strtolower($catKey)) !== false) {
                        // This is the current category type
                        foreach ($keywords as $keyword) {
                            if (stripos($productNameLower, mb_strtolower($keyword)) !== false) {
                                $matchesCategory = true;
                                break;
                            }
                        }
                        break;
                    }
                }

                // If doesn't match, find better category
                if (!$matchesCategory) {
                    foreach ($categoryKeywords as $catKey => $keywords) {
                        foreach ($keywords as $keyword) {
                            if (stripos($productNameLower, mb_strtolower($keyword)) !== false) {
                                $betterCategory = $catKey;
                                break 2;
                            }
                        }
                    }

                    if ($betterCategory) {
                        $issuesFound[] = [
                            'product_id' => $product->id,
                            'product_name' => $product->name,
                            'current_category' => $category->name,
                            'current_category_id' => $category->id,
                            'suggested' => $betterCategory,
                        ];
                        echo "      ⚠️  May belong in: $betterCategory\n";
                    }
                }
            }
        }
    }
    echo "\n";
}

echo "\n=== Summary ===\n";
echo "Total category-product relationships: $totalRelationships\n";
echo "Potential issues found: " . count($issuesFound) . "\n\n";

// Show detailed issues
if (count($issuesFound) > 0) {
    echo "=== Potential Mismatches ===\n\n";
    foreach ($issuesFound as $issue) {
        echo "Product: {$issue['product_name']}\n";
        echo "  ID: {$issue['product_id']}\n";
        echo "  Current category: {$issue['current_category']} (ID: {$issue['current_category_id']})\n";
        echo "  Better match: {$issue['suggested']}\n\n";
    }

    // Group by suggested category
    $grouped = [];
    foreach ($issuesFound as $issue) {
        if (!isset($grouped[$issue['suggested']])) {
            $grouped[$issue['suggested']] = [];
        }
        $grouped[$issue['suggested']][] = $issue;
    }

    echo "\n=== Issues Grouped by Suggested Category ===\n\n";
    foreach ($grouped as $suggestedCat => $issues) {
        echo "$suggestedCat (" . count($issues) . " products):\n";
        foreach ($issues as $issue) {
            echo "  - {$issue['product_name']} (from {$issue['current_category']})\n";
        }
        echo "\n";
    }
}

echo "\n=== Analysis Complete ===\n";
