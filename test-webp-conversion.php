<?php

/**
 * Test WebP Conversion on Sample Images
 *
 * This script tests WebP conversion on a few sample images to show
 * the potential space savings before running the full conversion.
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Intervention\Image\Facades\Image;
use App\Models\Product;

echo "\n╔══════════════════════════════════════════════════════════════╗\n";
echo "║              WebP Conversion Test - Sample Images           ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n\n";

// Get 5 random products with images
$products = Product::whereNotNull('photo')
    ->inRandomOrder()
    ->take(5)
    ->get();

if ($products->count() == 0) {
    echo "❌ No products with images found!\n";
    exit;
}

echo "🔍 Testing conversion on {$products->count()} random products...\n\n";
echo str_repeat("─", 62) . "\n\n";

$totalOriginalSize = 0;
$totalWebpSize = 0;
$testPath = public_path('assets/images/test_webp');

// Create test directory
if (!file_exists($testPath)) {
    mkdir($testPath, 0755, true);
}

foreach ($products as $index => $product) {
    echo "Sample " . ($index + 1) . " - Product ID: {$product->id}\n";

    $originalPath = public_path('assets/images/products/' . $product->photo);

    if (!file_exists($originalPath)) {
        echo "   ⚠️  File not found: {$product->photo}\n\n";
        continue;
    }

    $extension = pathinfo($product->photo, PATHINFO_EXTENSION);
    $originalSize = filesize($originalPath);
    $totalOriginalSize += $originalSize;

    try {
        // Test WebP conversion
        $img = Image::make($originalPath);
        $testWebpName = 'test_' . pathinfo($product->photo, PATHINFO_FILENAME) . '.webp';
        $testWebpPath = $testPath . '/' . $testWebpName;

        $img->encode('webp', 85)->save($testWebpPath);

        $webpSize = filesize($testWebpPath);
        $totalWebpSize += $webpSize;

        $savedSpace = $originalSize - $webpSize;
        $savedPercentage = round(($savedSpace / $originalSize) * 100);

        echo "   Original ({$extension}): " . round($originalSize / 1024) . " KB\n";
        echo "   WebP (85%):      " . round($webpSize / 1024) . " KB\n";
        echo "   💾 Saved:        " . round($savedSpace / 1024) . " KB ({$savedPercentage}%)\n";

        // Clean up test file
        unlink($testWebpPath);

    } catch (\Exception $e) {
        echo "   ❌ Conversion failed: " . $e->getMessage() . "\n";
    }

    echo "\n";
}

// Clean up test directory
rmdir($testPath);

// Calculate totals
$totalSaved = $totalOriginalSize - $totalWebpSize;
$totalPercentage = round(($totalSaved / $totalOriginalSize) * 100);

echo str_repeat("═", 62) . "\n";
echo "                      TEST SUMMARY\n";
echo str_repeat("═", 62) . "\n\n";

echo "Total Original Size:  " . round($totalOriginalSize / 1024) . " KB\n";
echo "Total WebP Size:      " . round($totalWebpSize / 1024) . " KB\n";
echo "Total Saved:          " . round($totalSaved / 1024) . " KB ({$totalPercentage}%)\n\n";

// Estimate for all images
$currentSize = 278; // MB (from du -sh)
$estimatedAfter = round($currentSize * (1 - ($totalPercentage / 100)));
$estimatedSaved = $currentSize - $estimatedAfter;

echo "📊 ESTIMATED SAVINGS FOR ALL IMAGES:\n";
echo "   Current Total:     {$currentSize} MB\n";
echo "   After Conversion:  ~{$estimatedAfter} MB\n";
echo "   Space Saved:       ~{$estimatedSaved} MB\n\n";

echo "✓ Test complete! You can now run the full conversion with confidence.\n";
echo "  Run: php convert-images-to-webp.php\n\n";
