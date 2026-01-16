<?php
/**
 * Identify Root vs Sub/Child Categories
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "================================================================================\n";
echo "IDENTIFY ROOT vs SUB/CHILD CATEGORIES\n";
echo "================================================================================\n\n";

// Parse old categories with parent info
$categoriesFile = file_get_contents(__DIR__ . '/public/ec_product_categories (1).sql');
preg_match_all('/\((\d+),\s*\'([^\']+)\',\s*(\d+)/', $categoriesFile, $catMatches);

$oldCategories = [];
for ($i = 0; $i < count($catMatches[1]); $i++) {
    $id = $catMatches[1][$i];
    $name = str_replace("\\'", "'", $catMatches[2][$i]);
    $parentId = $catMatches[3][$i];

    $oldCategories[] = [
        'old_id' => $id,
        'name' => $name,
        'parent_id' => $parentId,
        'is_root' => $parentId == 0
    ];
}

echo "Categories from Old Database:\n\n";

echo "ROOT CATEGORIES (parent_id = 0):\n";
echo "────────────────────────────────────────────────────────────────────────────\n";
$rootCount = 0;
foreach ($oldCategories as $cat) {
    if ($cat['is_root']) {
        echo "  ✓ {$cat['name']} (Old ID: {$cat['old_id']})\n";
        $rootCount++;
    }
}
echo "\nTotal Root Categories: $rootCount\n\n";

echo "SUBCATEGORIES (parent_id > 0):\n";
echo "────────────────────────────────────────────────────────────────────────────\n";
$subCount = 0;
$parentGroups = [];
foreach ($oldCategories as $cat) {
    if (!$cat['is_root']) {
        $parentId = $cat['parent_id'];
        if (!isset($parentGroups[$parentId])) {
            $parentGroups[$parentId] = [];
        }
        $parentGroups[$parentId][] = $cat;
        $subCount++;
    }
}

foreach ($parentGroups as $parentId => $children) {
    $parentName = 'Unknown';
    foreach ($oldCategories as $cat) {
        if ($cat['old_id'] == $parentId) {
            $parentName = $cat['name'];
            break;
        }
    }

    echo "\n  Parent: {$parentName} (ID: {$parentId})\n";
    foreach ($children as $child) {
        echo "    → {$child['name']} (Old ID: {$child['old_id']})\n";
    }
}
echo "\nTotal Subcategories: $subCount\n\n";

echo "================================================================================\n";
echo "CURRENT DATABASE STATUS\n";
echo "================================================================================\n\n";

$currentCategories = DB::table('categories')
    ->select('id', 'name')
    ->orderBy('id')
    ->get();

$currentSubcategories = DB::table('subcategories')
    ->select('id', 'name', 'category_id')
    ->orderBy('id')
    ->get();

echo "Categories Table: " . count($currentCategories) . " records\n";
echo "Subcategories Table: " . count($currentSubcategories) . " records\n\n";

// Find incorrectly placed categories
$incorrectlyPlaced = [];
$currentCategoryNames = $currentCategories->pluck('name', 'id')->toArray();

foreach ($oldCategories as $oldCat) {
    if (!$oldCat['is_root']) { // This was a subcategory in old DB
        // Check if it's in the main categories table now
        $foundInMain = false;
        foreach ($currentCategoryNames as $id => $name) {
            if ($name === $oldCat['name']) {
                $foundInMain = true;
                $incorrectlyPlaced[] = [
                    'id' => $id,
                    'name' => $name,
                    'old_parent_id' => $oldCat['parent_id'],
                    'should_be' => 'subcategory'
                ];
                break;
            }
        }
    }
}

if (count($incorrectlyPlaced) > 0) {
    echo "⚠️  INCORRECTLY PLACED CATEGORIES:\n";
    echo "────────────────────────────────────────────────────────────────────────────\n";
    echo "These are subcategories from the old DB but are in the main categories table:\n\n";

    foreach ($incorrectlyPlaced as $item) {
        $parentName = 'Unknown';
        foreach ($oldCategories as $cat) {
            if ($cat['old_id'] == $item['old_parent_id']) {
                $parentName = $cat['name'];
                break;
            }
        }
        echo "  ❌ ID {$item['id']}: {$item['name']}\n";
        echo "     → Should be subcategory of: {$parentName}\n\n";
    }

    echo "Total Incorrectly Placed: " . count($incorrectlyPlaced) . "\n\n";
}

echo "================================================================================\n";
echo "RECOMMENDATION\n";
echo "================================================================================\n\n";

if (count($incorrectlyPlaced) > 0) {
    echo "❌ Issue Found: " . count($incorrectlyPlaced) . " categories are in wrong table\n\n";
    echo "Solutions:\n";
    echo "  1. Delete incorrectly placed categories from 'categories' table\n";
    echo "  2. Keep only ROOT categories in 'categories' table\n";
    echo "  3. Move subcategories to 'subcategories' table (if needed)\n\n";
    echo "OR\n\n";
    echo "  • Simply filter categories by is_featured=1 to show only main ones\n";
    echo "  • Use WHERE is_featured=1 in the query\n\n";
} else {
    echo "✅ All categories are correctly placed!\n";
}

echo "================================================================================\n";
