<?php
/**
 * Test WebP Compression Levels
 * Shows file size at different quality levels
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Intervention\Image\Facades\Image;

echo "=================================================================\n";
echo "          WebP COMPRESSION COMPARISON TEST\n";
echo "=================================================================\n\n";

// Find first PNG or JPG product image
$productsPath = __DIR__ . '/public/assets/images/products/';
$testFile = null;
$originalSize = 0;

foreach (scandir($productsPath) as $file) {
    if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg'])) {
        $testFile = $productsPath . $file;
        $originalSize = filesize($testFile);
        break;
    }
}

if (!$testFile) {
    echo "❌ No PNG/JPG files found for testing.\n";
    echo "Looking for WebP to test re-compression...\n\n";
    
    foreach (scandir($productsPath) as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'webp') {
            $testFile = $productsPath . $file;
            $originalSize = filesize($testFile);
            break;
        }
    }
}

if (!$testFile) {
    echo "❌ No images found for testing.\n";
    exit;
}

echo "Test Image: " . basename($testFile) . "\n";
echo "Original Size: " . formatBytes($originalSize) . "\n";
echo "Original Format: " . strtoupper(pathinfo($testFile, PATHINFO_EXTENSION)) . "\n\n";

echo "Testing different compression levels:\n";
echo "-------------------------------------\n\n";

$qualities = [90, 85, 80, 75, 70, 65, 60];
$testPath = __DIR__ . '/public/assets/images/products/test_compression/';

if (!file_exists($testPath)) {
    mkdir($testPath, 0755, true);
}

$results = [];

foreach ($qualities as $quality) {
    try {
        $img = Image::make($testFile);
        
        // Resize to max 1200px
        $img->resize(1200, 1200, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        
        $outputFile = $testPath . 'test_q' . $quality . '.webp';
        $img->encode('webp', $quality)->save($outputFile);
        
        $newSize = filesize($outputFile);
        $saved = $originalSize - $newSize;
        $percentSaved = round(($saved / $originalSize) * 100, 1);
        
        $results[$quality] = [
            'size' => $newSize,
            'saved' => $saved,
            'percent' => $percentSaved
        ];
        
        $recommendation = '';
        if ($quality == 75) {
            $recommendation = ' ⭐ RECOMMENDED for products';
        } elseif ($quality == 70) {
            $recommendation = ' ⭐ RECOMMENDED for thumbnails';
        }
        
        echo "Quality $quality%: " . formatBytes($newSize) . " (saved {$percentSaved}%)" . $recommendation . "\n";
        
    } catch (Exception $e) {
        echo "Quality $quality%: ❌ Error - " . $e->getMessage() . "\n";
    }
}

echo "\n\n📈 ANALYSIS:\n";
echo "============\n\n";

echo "Sweet Spot Analysis:\n";
echo "- Quality 90%: Highest quality, but larger file size\n";
echo "- Quality 85%: Excellent quality, good compression\n";
echo "- Quality 75%: ⭐ OPTIMAL - Great quality, maximum compression\n";
echo "- Quality 70%: ⭐ BEST for thumbnails - Still looks great\n";
echo "- Quality 65%: Aggressive, may show artifacts\n";
echo "- Quality 60%: Too compressed, noticeable quality loss\n\n";

echo "💡 RECOMMENDATION:\n";
echo "==================\n";
echo "✅ Product Images (large): Quality 75% with max 1200px width\n";
echo "✅ Thumbnails (small): Quality 70% at 285x285px\n\n";

echo "Why these settings?\n";
echo "- WebP is 30-50% more efficient than JPEG at same quality\n";
echo "- Quality 75% WebP ≈ Quality 90% JPEG (visually)\n";
echo "- Thumbnails are small, so 70% is perfect\n";
echo "- Max 1200px width is perfect for web display\n";
echo "- Faster loading = Better SEO + User Experience\n\n";

echo "🎯 Expected Results:\n";
echo "====================\n";
if (isset($results[75])) {
    echo "With these settings, you'll save approximately {$results[75]['percent']}% per image!\n";
    echo "Your 278 MB of images will become around " . formatBytes(278 * 1024 * 1024 * (100 - $results[75]['percent']) / 100) . "\n\n";
}

echo "Test files saved in: {$testPath}\n";
echo "You can compare quality visually!\n\n";

echo "=================================================================\n";

function formatBytes($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    
    $bytes /= (1 << (10 * $pow));
    
    return round($bytes, $precision) . ' ' . $units[$pow];
}
