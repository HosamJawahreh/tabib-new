<?php

/*
 * Category Diagnostic Tool
 * Use this to investigate specific category/product issues
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;

echo "╔══════════════════════════════════════════════════════════════╗\n";
echo "║              CATEGORY DIAGNOSTIC TOOL                        ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n\n";

// 1. Show all categories with product counts
echo "📋 ALL CATEGORIES WITH PRODUCT COUNTS:\n\n";
$categories = Category::where('status', 1)
    ->withCount('products')
    ->orderBy('products_count', 'desc')
    ->get();

foreach ($categories as $cat) {
    $isFeatured = $cat->is_featured ? '⭐' : '  ';
    echo sprintf("%s %3d. %-40s %4d products\n",
        $isFeatured,
        $cat->id,
        $cat->name,
        $cat->products_count
    );
}

echo "\n\n";
echo "═══════════════════════════════════════════════════════════════\n";
echo "ENTER DIAGNOSTIC MODE\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

echo "What would you like to check?\n";
echo "1. Test a specific category (enter category ID)\n";
echo "2. Test a specific product (enter product name)\n";
echo "3. Check products without categories\n";
echo "4. Check for duplicate category assignments\n";
echo "5. Exit\n\n";

echo "Enter your choice (1-5): ";
$handle = fopen("php://stdin", "r");
$choice = trim(fgets($handle));

switch ($choice) {
    case '1':
        echo "\nEnter category ID: ";
        $catId = trim(fgets($handle));

        $category = Category::find($catId);
        if (!$category) {
            echo "❌ Category not found!\n";
            break;
        }

        echo "\n📁 CATEGORY: {$category->name} (ID: {$catId})\n";
        echo "   Status: " . ($category->status ? 'Active' : 'Inactive') . "\n";
        echo "   Featured: " . ($category->is_featured ? 'Yes' : 'No') . "\n\n";

        // Get products using the exact controller query
        $products = Product::where('status', 1)
            ->where(function($q) use ($catId) {
                $q->whereHas('categories', function($subQuery) use ($catId) {
                    $subQuery->where('categories.id', $catId);
                })
                ->orWhere('category_id', $catId)
                ->orWhere('subcategory_id', $catId)
                ->orWhere('childcategory_id', $catId);
            })
            ->with('categories')
            ->get();

        echo "   Products found (using controller query): {$products->count()}\n\n";

        if ($products->count() > 0) {
            echo "   First 10 products:\n";
            foreach ($products->take(10) as $p) {
                $cats = $p->categories->pluck('name')->implode(', ');
                $oldCat = $p->category_id ? "old_cat:{$p->category_id}" : 'no_old_cat';
                echo "   • {$p->name}\n";
                echo "     Categories: {$cats}\n";
                echo "     Old columns: {$oldCat}\n\n";
            }
        }

        // Also show using ONLY pivot table
        $pivotProducts = Product::where('status', 1)
            ->whereHas('categories', function($q) use ($catId) {
                $q->where('categories.id', $catId);
            })
            ->count();

        echo "   Products (pivot table only): {$pivotProducts}\n";

        $difference = $products->count() - $pivotProducts;
        if ($difference > 0) {
            echo "   ⚠️  {$difference} products matched via old columns!\n";
        } else {
            echo "   ✅ All products matched via pivot table\n";
        }
        break;

    case '2':
        echo "\nEnter product name (or part of it): ";
        $productName = trim(fgets($handle));

        $products = Product::where('name', 'LIKE', "%{$productName}%")
            ->with('categories')
            ->get();

        if ($products->count() === 0) {
            echo "❌ No products found!\n";
            break;
        }

        echo "\n🔍 PRODUCTS MATCHING '{$productName}':\n\n";
        foreach ($products as $p) {
            echo "📦 {$p->name} (ID: {$p->id})\n";
            echo "   Status: " . ($p->status ? 'Active' : 'Inactive') . "\n";
            echo "   Old category_id: " . ($p->category_id ?: 'NULL') . "\n";
            echo "   Old subcategory_id: " . ($p->subcategory_id ?: 'NULL') . "\n";
            echo "   Old childcategory_id: " . ($p->childcategory_id ?: 'NULL') . "\n";
            echo "   Categories (pivot): " . $p->categories->pluck('name')->implode(', ') . "\n";
            echo "   Category count: " . $p->categories->count() . "\n\n";
        }
        break;

    case '3':
        echo "\n🔍 PRODUCTS WITHOUT CATEGORIES:\n\n";
        $productsWithoutCats = Product::where('status', 1)
            ->doesntHave('categories')
            ->get();

        echo "Total: {$productsWithoutCats->count()}\n\n";

        if ($productsWithoutCats->count() > 0) {
            echo "First 20:\n";
            foreach ($productsWithoutCats->take(20) as $p) {
                echo "• {$p->name} (ID: {$p->id})\n";
            }
        }
        break;

    case '4':
        echo "\n🔍 CHECKING FOR DUPLICATES:\n\n";
        $duplicates = DB::select("
            SELECT product_id, category_id, COUNT(*) as count
            FROM category_product
            GROUP BY product_id, category_id
            HAVING count > 1
        ");

        if (empty($duplicates)) {
            echo "✅ No duplicate relationships found!\n";
        } else {
            echo "⚠️  Found " . count($duplicates) . " duplicate relationships:\n\n";
            foreach ($duplicates as $dup) {
                $product = Product::find($dup->product_id);
                $category = Category::find($dup->category_id);
                echo "  Product: " . ($product ? $product->name : "ID {$dup->product_id}") . "\n";
                echo "  Category: " . ($category ? $category->name : "ID {$dup->category_id}") . "\n";
                echo "  Duplicates: {$dup->count}\n\n";
            }
        }
        break;

    case '5':
        echo "\nGoodbye!\n";
        exit(0);

    default:
        echo "\n❌ Invalid choice!\n";
}

fclose($handle);
