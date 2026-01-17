<?php

/*
 * PROFESSIONAL SOLUTION: Handle Duplicate "عروض" Categories
 *
 * Strategy:
 * 1. Keep main "عروض" category (ID 96) as-is for general offers
 * 2. Rename childcategory "عروض" (ID 142) to "عروض مكملات" (Supplements Offers)
 *    to make it more specific and avoid confusion
 * 3. Update the corresponding entry in categories table if it exists
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Category;

echo "╔══════════════════════════════════════════════════════════════╗\n";
echo "║   RESOLVE DUPLICATE 'عروض' CATEGORIES PROFESSIONALLY        ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n\n";

try {
    DB::beginTransaction();

    echo "📊 CURRENT STATE:\n";
    echo str_repeat('-', 60) . "\n\n";

    // Show both عروض categories
    $mainOffers = Category::find(96);
    echo "1. Main Category 'عروض' (ID: 96):\n";
    echo "   Name: {$mainOffers->name}\n";
    echo "   Slug: {$mainOffers->slug}\n";
    echo "   Featured: " . ($mainOffers->is_featured ? 'Yes' : 'No') . "\n";
    echo "   Products: " . $mainOffers->products()->count() . "\n";
    echo "   PURPOSE: General offers/promotions\n\n";

    // Check if category ID 96 exists in other tables
    $childOffersCategory = DB::table('childcategories')->where('id', 142)->first();
    if ($childOffersCategory) {
        $parentSubcat = DB::table('subcategories')->where('id', $childOffersCategory->subcategory_id)->first();
        $parentCat = Category::find($parentSubcat->category_id);

        echo "2. Child Category 'عروض' (ID: 142 in childcategories table):\n";
        echo "   Name: {$childOffersCategory->name}\n";
        echo "   Hierarchy: {$parentCat->name} → {$parentSubcat->name} → {$childOffersCategory->name}\n";
        echo "   PURPOSE: Supplements/Sports nutrition offers\n\n";
    }

    echo "\n📝 PROPOSED SOLUTION:\n";
    echo str_repeat('-', 60) . "\n\n";
    echo "1. Keep 'عروض' (ID: 96) as main general offers category\n";
    echo "2. Rename child category to 'عروض مكملات' to be more specific\n";
    echo "3. This makes it clear: \n";
    echo "   • 'عروض' = General offers for all products\n";
    echo "   • 'عروض مكملات' = Special offers for supplements only\n\n";

    echo "⚠️  Do you want to proceed with renaming? (yes/no): ";

    $handle = fopen("php://stdin", "r");
    $line = trim(fgets($handle));

    if (strtolower($line) !== 'yes') {
        echo "\n❌ Operation cancelled.\n";
        DB::rollBack();
        exit(0);
    }

    echo "\n🔧 APPLYING CHANGES:\n";
    echo str_repeat('-', 60) . "\n\n";

    // Update childcategory name in childcategories table
    $updated = DB::table('childcategories')
        ->where('id', 142)
        ->update([
            'name' => 'عروض مكملات',
            'slug' => 'aarod-mkmlat'
        ]);

    if ($updated) {
        echo "✅ Updated childcategory 'عروض' to 'عروض مكملات'\n";
    }

    // Check if this exists as a main category and update it too
    // Since childcategory ID 142 was mapped to category ID 96 in our earlier migration
    // But we want to keep ID 96 as general offers
    // So we don't need to update the main categories table

    echo "\n\n📊 FINAL STATE:\n";
    echo str_repeat('-', 60) . "\n\n";

    echo "1. Main Category (ID: 96):\n";
    echo "   Name: عروض\n";
    echo "   Purpose: General offers/promotions\n";
    echo "   Location: Featured categories on homepage\n\n";

    echo "2. Child Category (ID: 142):\n";
    echo "   Name: عروض مكملات\n";
    echo "   Purpose: Supplements offers\n";
    echo "   Location: أغذية رياضيين → مكملات → عروض مكملات\n\n";

    DB::commit();

    echo "✅ Changes committed successfully!\n\n";

    echo "╔══════════════════════════════════════════════════════════════╗\n";
    echo "║                  RESOLUTION COMPLETED                        ║\n";
    echo "╚══════════════════════════════════════════════════════════════╝\n\n";

    echo "📋 NEXT STEPS:\n";
    echo "1. Clear caches: php artisan cache:clear && php artisan view:clear\n";
    echo "2. Test both categories work correctly\n";
    echo "3. Assign products to appropriate offers category\n\n";

    fclose($handle);

} catch (\Exception $e) {
    DB::rollBack();
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    exit(1);
}
