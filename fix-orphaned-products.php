<?php
/**
 * Fix Orphaned Products - Auto-assign Categories
 * 
 * This script assigns categories to the 10 products that don't have any categories
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

echo "\n====================================\n";
echo "FIX ORPHANED PRODUCTS\n";
echo "====================================\n\n";

// Get orphaned products
$orphanedProducts = Product::where('status', 1)
    ->doesntHave('categories')
    ->get();

echo "Found {$orphanedProducts->count()} orphaned products\n\n";

// Category mapping based on product names and attributes
$categoryMap = [
    'كورن فليكس' => 'كورن فلكس / شوفان',
    'بسكويت' => 'بسكوت / ويفر',
    'طحينية' => 'متنوع',
    'حبيبات' => 'شكولاتة / حلوى',
    'حليب' => 'حليب',
    'سوس' => 'شيبس/ سوس/ مارشملو',
    'شوكلاتة' => 'شكولاتة',
    'الواح شوكلاتة' => 'شكولاتة',
    'بروتين' => 'واي بروتين',
    'واي' => 'واي بروتين',
];

$fixed = 0;
$errors = 0;

foreach ($orphanedProducts as $product) {
    echo "Processing: {$product->name} (ID: {$product->id})\n";
    
    $assignedCategories = [];
    
    // Try to find matching categories based on product name
    foreach ($categoryMap as $keyword => $categoryName) {
        if (stripos($product->name, $keyword) !== false) {
            $category = Category::where('name', $categoryName)->where('status', 1)->first();
            
            if ($category) {
                $assignedCategories[] = $category->id;
                echo "  - Matched category: {$categoryName}\n";
            }
        }
    }
    
    // Check if product name contains "خالي" (sugar-free/gluten-free indicators)
    if (stripos($product->name, 'خالي') !== false || stripos($product->name, 'خالية') !== false) {
        if (stripos($product->name, 'سكر') !== false) {
            $category = Category::where('name', 'خالي سكر')->where('status', 1)->first();
            if ($category && !in_array($category->id, $assignedCategories)) {
                $assignedCategories[] = $category->id;
                echo "  - Added: خالي سكر\n";
            }
        }
        if (stripos($product->name, 'جلوتين') !== false) {
            $category = Category::where('name', 'خالي جلوتين')->where('status', 1)->first();
            if ($category && !in_array($category->id, $assignedCategories)) {
                $assignedCategories[] = $category->id;
                echo "  - Added: خالي جلوتين\n";
            }
        }
    }
    
    // Check for organic products
    if (stripos($product->name, 'عضوي') !== false || stripos($product->name, 'العضوي') !== false) {
        $category = Category::where('name', 'أغذية عضوية')->where('status', 1)->first();
        if ($category && !in_array($category->id, $assignedCategories)) {
            $assignedCategories[] = $category->id;
            echo "  - Added: أغذية عضوية\n";
        }
    }
    
    // If no categories matched, assign to "متنوع" (Miscellaneous)
    if (empty($assignedCategories)) {
        $category = Category::where('name', 'متنوع')->where('status', 1)->first();
        if ($category) {
            $assignedCategories[] = $category->id;
            echo "  - Default category: متنوع\n";
        }
    }
    
    // Assign categories to product
    if (!empty($assignedCategories)) {
        try {
            $product->categories()->sync($assignedCategories);
            echo "  ✓ Assigned " . count($assignedCategories) . " category/categories\n";
            $fixed++;
        } catch (\Exception $e) {
            echo "  ✗ Error: " . $e->getMessage() . "\n";
            $errors++;
        }
    } else {
        echo "  ⚠️ No suitable categories found\n";
        $errors++;
    }
    
    echo "\n";
}

echo "\n====================================\n";
echo "SUMMARY\n";
echo "====================================\n";
echo "Total orphaned products: {$orphanedProducts->count()}\n";
echo "Successfully fixed: {$fixed}\n";
echo "Errors: {$errors}\n";

// Verify
$remainingOrphaned = Product::where('status', 1)->doesntHave('categories')->count();
echo "\nRemaining orphaned products: {$remainingOrphaned}\n";

if ($remainingOrphaned == 0) {
    echo "✓ All products now have categories!\n";
} else {
    echo "⚠️ Some products still need manual category assignment\n";
}

echo "\n";
