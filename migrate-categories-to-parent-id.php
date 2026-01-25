<?php
/**
 * Script to migrate from 3-table category system to single-table parent_id system
 * Run: php migrate-categories-to-parent-id.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "╔══════════════════════════════════════════════════════════════════╗\n";
echo "║                                                                  ║\n";
echo "║   MIGRATING TO SINGLE-TABLE CATEGORY SYSTEM (parent_id)         ║\n";
echo "║                                                                  ║\n";
echo "╚══════════════════════════════════════════════════════════════════╝\n\n";

// Step 1: Add parent_id column to categories table if it doesn't exist
echo "Step 1: Adding parent_id column to categories table...\n";
if (!Schema::hasColumn('categories', 'parent_id')) {
    DB::statement('ALTER TABLE categories ADD COLUMN parent_id INT UNSIGNED DEFAULT 0 AFTER id');
    echo "  ✅ Added parent_id column\n";
} else {
    echo "  ℹ️  parent_id column already exists\n";
}

// Step 2: Migrate subcategories to categories table
echo "\nStep 2: Migrating subcategories to categories table...\n";
$subcategories = DB::table('subcategories')->get();
$migratedSubs = 0;

foreach ($subcategories as $sub) {
    // Check if this subcategory already exists in categories table
    $existing = DB::table('categories')->where('id', $sub->id)->first();
    
    if ($existing) {
        // Update existing category to set parent_id
        DB::table('categories')
            ->where('id', $sub->id)
            ->update([
                'parent_id' => $sub->category_id,
                'name' => $sub->name,
                'slug' => $sub->slug,
                'status' => $sub->status ?? 1,
            ]);
        echo "  ⚠️  Updated existing ID {$sub->id}: {$sub->name} (parent: {$sub->category_id})\n";
    } else {
        // Insert subcategory into categories table
        DB::table('categories')->insert([
            'id' => $sub->id,
            'name' => $sub->name,
            'slug' => $sub->slug,
            'parent_id' => $sub->category_id,
            'status' => $sub->status ?? 1,
            'is_featured' => 0,
            'photo' => $sub->image ?? null,
        ]);
        echo "  ✅ Migrated subcategory ID {$sub->id}: {$sub->name} (parent: {$sub->category_id})\n";
        $migratedSubs++;
    }
}
echo "  Total subcategories migrated: {$migratedSubs}\n";

// Step 3: Migrate childcategories to categories table
echo "\nStep 3: Migrating childcategories to categories table...\n";
$childcategories = DB::table('childcategories')->get();
$migratedChildren = 0;

foreach ($childcategories as $child) {
    // Check if this child already exists in categories table
    $existing = DB::table('categories')->where('id', $child->id)->first();
    
    if ($existing) {
        // Update existing category to set parent_id
        DB::table('categories')
            ->where('id', $child->id)
            ->update([
                'parent_id' => $child->subcategory_id,
                'name' => $child->name,
                'slug' => $child->slug,
                'status' => $child->status ?? 1,
            ]);
        echo "  ⚠️  Updated existing ID {$child->id}: {$child->name} (parent: {$child->subcategory_id})\n";
    } else {
        // Insert child into categories table
        DB::table('categories')->insert([
            'id' => $child->id,
            'name' => $child->name,
            'slug' => $child->slug,
            'parent_id' => $child->subcategory_id,
            'status' => $child->status ?? 1,
            'is_featured' => 0,
            'photo' => null,
        ]);
        echo "  ✅ Migrated child category ID {$child->id}: {$child->name} (parent: {$child->subcategory_id})\n";
        $migratedChildren++;
    }
}
echo "  Total child categories migrated: {$migratedChildren}\n";

// Step 4: Ensure all parent categories have parent_id = 0
echo "\nStep 4: Setting parent_id = 0 for main categories...\n";
DB::table('categories')
    ->where('is_featured', 1)
    ->update(['parent_id' => 0]);
echo "  ✅ Updated featured categories to have parent_id = 0\n";

// Step 5: Verify the migration
echo "\nStep 5: Verification...\n";
$totalCategories = DB::table('categories')->count();
$parentCategories = DB::table('categories')->where('parent_id', 0)->count();
$childrenCount = DB::table('categories')->where('parent_id', '>', 0)->count();

echo "  Total categories: {$totalCategories}\n";
echo "  Parent categories: {$parentCategories}\n";
echo "  Children/Subcategories: {$childrenCount}\n";

// Show sample hierarchy
echo "\nSample Category Tree:\n";
$samples = DB::table('categories')->where('parent_id', 0)->take(3)->get();
foreach ($samples as $parent) {
    echo "  📁 {$parent->name} (ID: {$parent->id})\n";
    
    $children = DB::table('categories')->where('parent_id', $parent->id)->get();
    foreach ($children as $child) {
        echo "     └─ {$child->name} (ID: {$child->id})\n";
        
        // Check for grandchildren
        $grandchildren = DB::table('categories')->where('parent_id', $child->id)->take(3)->get();
        foreach ($grandchildren as $gc) {
            echo "        └─ {$gc->name} (ID: {$gc->id})\n";
        }
    }
}

echo "\n╔══════════════════════════════════════════════════════════════════╗\n";
echo "║                                                                  ║\n";
echo "║              ✅ MIGRATION COMPLETE! ✅                           ║\n";
echo "║                                                                  ║\n";
echo "╚══════════════════════════════════════════════════════════════════╝\n\n";

echo "Next Steps:\n";
echo "1. Update ProductController to use parent_id for category tree\n";
echo "2. Update blade templates to display hierarchy\n";
echo "3. Test category display and product assignments\n";
echo "4. (Optional) Backup and drop old subcategories/childcategories tables\n";
