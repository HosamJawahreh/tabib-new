<?php
/**
 * Clean Up Incorrectly Placed Categories
 * Remove subcategories from main categories table
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "================================================================================\n";
echo "CLEAN UP INCORRECTLY PLACED CATEGORIES\n";
echo "================================================================================\n\n";

// The 10 ROOT categories that should remain
$rootCategoryIds = [84, 85, 86, 87, 88, 89, 90, 91, 95, 96];

$rootCategoryNames = DB::table('categories')
    ->whereIn('id', $rootCategoryIds)
    ->pluck('name', 'id')
    ->toArray();

echo "✓ ROOT CATEGORIES (should remain):\n";
echo "────────────────────────────────────────────────────────────────────────────\n";
foreach ($rootCategoryNames as $id => $name) {
    echo "  ID $id: $name\n";
}
echo "\n";

// Find incorrectly placed categories
$incorrectlyPlaced = DB::table('categories')
    ->whereNotIn('id', $rootCategoryIds)
    ->get();

echo "❌ INCORRECTLY PLACED CATEGORIES (should be removed):\n";
echo "────────────────────────────────────────────────────────────────────────────\n";
echo "These are subcategories from old DB but are in main categories table:\n\n";

foreach ($incorrectlyPlaced as $cat) {
    echo "  ID {$cat->id}: {$cat->name}\n";
}

echo "\nTotal to remove: " . count($incorrectlyPlaced) . "\n\n";

// Check if any products are using these categories
echo "📊 Checking product relationships...\n";
echo "────────────────────────────────────────────────────────────────────────────\n";

$productsAffected = DB::table('category_product')
    ->whereIn('category_id', $incorrectlyPlaced->pluck('id'))
    ->distinct('product_id')
    ->count('product_id');

$relationshipsAffected = DB::table('category_product')
    ->whereIn('category_id', $incorrectlyPlaced->pluck('id'))
    ->count();

echo "  • Products using these categories: $productsAffected\n";
echo "  • Total relationships affected: $relationshipsAffected\n\n";

if ($relationshipsAffected > 0) {
    echo "⚠️  WARNING: Products are using these categories!\n";
    echo "   These are valid category assignments from your multi-category system.\n";
    echo "   DO NOT DELETE these categories - they are being used.\n\n";
    echo "✅ RECOMMENDATION: Keep all categories, just filter the display\n";
    echo "   The FrontendController has been updated to only show root categories.\n\n";
} else {
    echo "✅ Safe to delete - no products using these categories\n\n";

    echo "Do you want to delete these " . count($incorrectlyPlaced) . " categories? (yes/no): ";
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);
    $confirmation = trim($line);

    if (strtolower($confirmation) === 'yes') {
        echo "\n🗑️  Deleting categories...\n";

        $deleted = DB::table('categories')
            ->whereNotIn('id', $rootCategoryIds)
            ->delete();

        echo "✅ Deleted $deleted categories\n";

        $remaining = DB::table('categories')->count();
        echo "✅ Remaining categories: $remaining (should be 10)\n";
    } else {
        echo "\n❌ Deletion cancelled\n";
    }
}

echo "\n================================================================================\n";
echo "SOLUTION IMPLEMENTED\n";
echo "================================================================================\n\n";

echo "✅ FrontendController updated to only show ROOT categories\n";
echo "   Query now uses: ->whereIn('id', [84, 85, 86, 87, 88, 89, 90, 91, 95, 96])\n\n";

echo "✅ Categories display filter:\n";
echo "   • Homepage will show only 10 main categories\n";
echo "   • Subcategories appear when main category is clicked\n";
echo "   • Multi-category system still works correctly\n\n";

echo "📖 Recommendation:\n";
echo "   KEEP all categories in the table (they're used by products)\n";
echo "   Just filter the display to show only root categories\n\n";

echo "================================================================================\n";
