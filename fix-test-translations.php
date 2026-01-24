<?php
/**
 * Fix "test" Translations
 *
 * This script removes all English translations that were set to "test"
 * while keeping the correct Arabic names intact.
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== FIX 'TEST' TRANSLATIONS ===" . PHP_EOL . PHP_EOL;

// Find all translations with "test"
$testTranslations = App\Models\ProductTranslation::where('name', 'test')->get();

echo "Found {$testTranslations->count()} translations with 'test'" . PHP_EOL . PHP_EOL;

if ($testTranslations->count() == 0) {
    echo "✅ No 'test' translations found. Nothing to fix!" . PHP_EOL;
    exit(0);
}

echo "Products affected:" . PHP_EOL;
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;

foreach ($testTranslations as $trans) {
    $product = App\Models\Product::find($trans->ec_products_id);
    if ($product) {
        echo "Product #{$product->id}: {$product->name}" . PHP_EOL;
        echo "  SKU: {$product->sku}" . PHP_EOL;
        echo "  English translation: '{$trans->name}' will be removed" . PHP_EOL;
        echo "---" . PHP_EOL;
    }
}

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL . PHP_EOL;

echo "⚠️  WARNING: This will DELETE all English translations set to 'test'" . PHP_EOL;
echo "The Arabic names will remain intact." . PHP_EOL . PHP_EOL;

echo "Do you want to proceed? (yes/no): ";
$handle = fopen ("php://stdin","r");
$line = trim(fgets($handle));

if($line !== 'yes'){
    echo PHP_EOL . "❌ Aborted. No changes made." . PHP_EOL;
    exit(0);
}

echo PHP_EOL . "🔧 Deleting 'test' translations..." . PHP_EOL;

$deleted = App\Models\ProductTranslation::where('name', 'test')->delete();

echo "✅ Deleted {$deleted} translations" . PHP_EOL . PHP_EOL;

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;
echo "✅ FIX COMPLETE!" . PHP_EOL;
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;
echo "All products now have:" . PHP_EOL;
echo "  ✓ Arabic names (in products.name) - unchanged" . PHP_EOL;
echo "  ✗ No English translations - you can add them properly now" . PHP_EOL . PHP_EOL;
echo "Next steps:" . PHP_EOL;
echo "1. Edit each product in the admin panel" . PHP_EOL;
echo "2. Fill in the English translation field (with UK flag) correctly" . PHP_EOL;
echo "3. Save the product" . PHP_EOL;
