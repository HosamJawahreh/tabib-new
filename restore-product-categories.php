<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Restoring Product Categories from Backup ===\n\n";

// Path to the SQL backup file
$sqlFile = __DIR__ . '/public/product_category_product .sql';

if (!file_exists($sqlFile)) {
    die("Error: Backup file not found at: $sqlFile\n");
}

echo "Reading backup file...\n";
$sqlContent = file_get_contents($sqlFile);

// Extract INSERT statements
preg_match_all('/INSERT INTO `ec_product_category_product` \(`category_id`, `product_id`\) VALUES\s*(.*?);/s', $sqlContent, $matches);

if (empty($matches[1])) {
    die("Error: No INSERT statements found in backup file\n");
}

$totalInserted = 0;
$errors = 0;
$skipped = 0;

foreach ($matches[1] as $valuesBlock) {
    // Split the values into individual rows
    $rows = explode('),', $valuesBlock);

    foreach ($rows as $row) {
        // Clean up the row
        $row = trim($row);
        $row = ltrim($row, '(');
        $row = rtrim($row, ')');
        $row = rtrim($row, ',');

        if (empty($row)) {
            continue;
        }

        // Parse category_id and product_id
        list($categoryId, $productId) = array_map('trim', explode(',', $row));

        // Convert old product IDs (244, 245, etc.) to new IDs (1, 2, etc.)
        $newProductId = $productId - 243;

        // Check if product exists
        $productExists = DB::table('products')->where('id', $newProductId)->exists();
        if (!$productExists) {
            // echo "  Skipping: Product $newProductId doesn't exist (was $productId in backup)\n";
            $skipped++;
            continue;
        }

        // Check if category exists
        $categoryExists = DB::table('product_categories')->where('id', $categoryId)->exists();
        if (!$categoryExists) {
            // echo "  Skipping: Category $categoryId doesn't exist\n";
            $skipped++;
            continue;
        }

        // Check if relationship already exists
        $exists = DB::table('category_product')
            ->where('category_id', $categoryId)
            ->where('product_id', $newProductId)
            ->exists();

        if ($exists) {
            $skipped++;
            continue;
        }

        // Insert the relationship
        try {
            DB::table('category_product')->insert([
                'category_id' => $categoryId,
                'product_id' => $newProductId
            ]);
            $totalInserted++;

            if ($totalInserted % 100 == 0) {
                echo "  Inserted $totalInserted relationships...\n";
            }
        } catch (\Exception $e) {
            echo "  Error inserting product $newProductId -> category $categoryId: " . $e->getMessage() . "\n";
            $errors++;
        }
    }
}

echo "\n=== Summary ===\n";
echo "Total inserted: $totalInserted\n";
echo "Skipped (already exists or missing): $skipped\n";
echo "Errors: $errors\n";

// Show current stats
$totalProducts = DB::table('products')->count();
$productsWithCategories = DB::table('products')
    ->join('category_product', 'products.id', '=', 'category_product.product_id')
    ->distinct()
    ->count('products.id');
$productsWithoutCategories = $totalProducts - $productsWithCategories;

echo "\n=== Database Stats ===\n";
echo "Total products: $totalProducts\n";
echo "Products with categories: $productsWithCategories\n";
echo "Products without categories: $productsWithoutCategories\n";

echo "\nDone!\n";
