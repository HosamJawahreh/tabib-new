<?php
/**
 * Check Product Translation Issue
 * 
 * This script identifies products where the main name and translations
 * might have been entered in reverse (English in Arabic field, etc.)
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== PRODUCT TRANSLATION ISSUE DIAGNOSIS ===" . PHP_EOL . PHP_EOL;

// Find all products with translations containing "test"
$products = App\Models\Product::with('translations')
    ->where(function($q) {
        $q->where('name', 'LIKE', '%test%')
          ->orWhereHas('translations', function($subQ) {
              $subQ->where('name', 'LIKE', '%test%');
          });
    })
    ->get();

echo "Found " . $products->count() . " products with 'test' in name or translations" . PHP_EOL . PHP_EOL;

foreach ($products as $product) {
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;
    echo "Product ID: {$product->id}" . PHP_EOL;
    echo "SKU: {$product->sku}" . PHP_EOL;
    echo "Main Name (products.name): {$product->name}" . PHP_EOL;
    
    // Check if main name looks like English (basic check)
    $isMainNameEnglish = preg_match('/^[a-zA-Z0-9\s\-]+$/', $product->name);
    if ($isMainNameEnglish) {
        echo "⚠️  WARNING: Main name appears to be in English (should be Arabic)" . PHP_EOL;
    }
    
    echo PHP_EOL . "Translations:" . PHP_EOL;
    $translations = $product->translations;
    
    if ($translations->count() > 0) {
        foreach ($translations as $trans) {
            echo "  [{$trans->lang_code}] Name: {$trans->name}" . PHP_EOL;
            
            // Check if translation looks like Arabic (basic check)
            if ($trans->lang_code == 'en_US') {
                $isTransNameArabic = preg_match('/[\x{0600}-\x{06FF}]/u', $trans->name);
                if ($isTransNameArabic) {
                    echo "  ⚠️  WARNING: English translation contains Arabic characters" . PHP_EOL;
                }
            }
        }
    } else {
        echo "  No translations found" . PHP_EOL;
    }
    
    echo PHP_EOL;
}

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL . PHP_EOL;

echo "EXPLANATION:" . PHP_EOL;
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;
echo "Your system has TWO separate fields for product names:" . PHP_EOL . PHP_EOL;
echo "1. MAIN NAME (products.name) - This should be ARABIC" . PHP_EOL;
echo "   → Displayed in the first input field in the edit form" . PHP_EOL;
echo "   → Example: 'ميلتي فروت عصير'" . PHP_EOL . PHP_EOL;
echo "2. ENGLISH TRANSLATION (ec_products_translations.name)" . PHP_EOL;
echo "   → Displayed in the second input field (with UK flag)" . PHP_EOL;
echo "   → Example: 'Multi Fruit Juice'" . PHP_EOL . PHP_EOL;
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;
echo "The issue occurs when you enter:" . PHP_EOL;
echo "✗ 'test' in the FIRST field (Arabic) → Stores 'test' as Arabic name" . PHP_EOL;
echo "✗ 'test ar' in the SECOND field (English) → Stores 'test ar' as English" . PHP_EOL . PHP_EOL;
echo "What you should do:" . PHP_EOL;
echo "✓ Enter Arabic name in the FIRST field" . PHP_EOL;
echo "✓ Enter English name in the SECOND field (with UK flag)" . PHP_EOL;
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;
