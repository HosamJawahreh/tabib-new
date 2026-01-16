<?php
/**
 * Import Missing Categories from Old Database
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Category;

echo "================================================================================\n";
echo "IMPORT MISSING CATEGORIES\n";
echo "================================================================================\n\n";

// Parse old categories
echo "Reading categories from SQL file...\n";
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
        'parent_id' => $parentId
    ];
}

echo "Found " . count($oldCategories) . " categories in old database\n\n";

// Get current categories
$currentCategories = Category::all()->pluck('id', 'name')->toArray();
echo "Current categories in database: " . count($currentCategories) . "\n\n";

echo "Existing Categories:\n";
foreach ($currentCategories as $name => $id) {
    echo "  • $name (ID: $id)\n";
}

echo "\n\nMissing Categories to Import:\n";
$missingCategories = [];

foreach ($oldCategories as $oldCat) {
    if (!isset($currentCategories[$oldCat['name']])) {
        $missingCategories[] = $oldCat;
        echo "  • {$oldCat['name']} (Old ID: {$oldCat['old_id']}, Parent: {$oldCat['parent_id']})\n";
    }
}

echo "\n\nTotal missing: " . count($missingCategories) . " categories\n\n";

if (count($missingCategories) > 0) {
    echo "Do you want to import these categories? (This will add them to your categories table)\n";
    echo "Type 'yes' to proceed: ";

    $handle = fopen ("php://stdin","r");
    $line = fgets($handle);
    $confirmation = trim($line);

    if(strtolower($confirmation) === 'yes') {
        echo "\n📦 Importing categories...\n\n";

        $imported = 0;
        foreach ($missingCategories as $cat) {
            try {
                DB::table('categories')->insert([
                    'name' => $cat['name'],
                    'slug' => \Illuminate\Support\Str::slug($cat['name']),
                    'status' => 1,
                ]);

                echo "  ✅ Imported: {$cat['name']}\n";
                $imported++;
            } catch (\Exception $e) {
                echo "  ❌ Failed: {$cat['name']} - " . $e->getMessage() . "\n";
            }
        }

        echo "\n\n✅ Import Complete!\n";
        echo "Imported: $imported categories\n";

        // Re-count
        $newTotal = Category::count();
        echo "Total categories now: $newTotal\n";

    } else {
        echo "\nImport cancelled.\n";
    }
}

echo "\n================================================================================\n";
