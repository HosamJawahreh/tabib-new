<?php
/**
 * Re-optimize EXISTING WebP Images with Maximum Compression
 * Your images are already WebP but at high quality - let's compress them more!
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Intervention\Image\Facades\Image;

echo "=================================================================\n";
echo "    RE-OPTIMIZE EXISTING WebP Images\n";
echo "    Maximum Compression: Quality 75% for products, 70% for thumbnails\n";
echo "=================================================================\n\n";

$productsPath = __DIR__ . '/public/assets/images/products/';
$thumbnailsPath = __DIR__ . '/public/assets/images/thumbnails/';

$stats = [
    'total_products' => 0,
    'optimized_products' => 0,
    'total_thumbnails' => 0,
    'optimized_thumbnails' => 0,
    'size_before_products' => 0,
    'size_after_products' => 0,
    'size_before_thumbnails' => 0,
    'size_after_thumbnails' => 0,
    'errors' => 0
];

echo "Step 1: Re-optimizing Product Images\n";
echo "--------------------------------------\n";

$files = glob($productsPath . '*.webp');
$stats['total_products'] = count($files);

foreach ($files as $index => $file) {
    $num = $index + 1;
    $filename = basename($file);

    if ($num % 100 == 0) {
        echo "Processed $num/{$stats['total_products']} products...\n";
    }

    $oldSize = filesize($file);
    $stats['size_before_products'] += $oldSize;

    try {
        $img = Image::make($file);

        // Resize to max 1200px
        $img->resize(1200, 1200, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        // Create temp file
        $tempFile = $productsPath . 'temp_' . $filename;
        $img->encode('webp', 75)->save($tempFile);

        $newSize = filesize($tempFile);

        // Only replace if we saved space
        if ($newSize < $oldSize) {
            unlink($file);
            rename($tempFile, $file);
            $stats['size_after_products'] += $newSize;
            $stats['optimized_products']++;
        } else {
            unlink($tempFile);
            $stats['size_after_products'] += $oldSize;
        }

    } catch (\Exception $e) {
        $stats['size_after_products'] += $oldSize;
        $stats['errors']++;
        if ($num % 100 == 0) {
            echo "   Error on $filename: " . $e->getMessage() . "\n";
        }
    }
}

echo "✅ Product images complete!\n\n";

echo "Step 2: Re-optimizing Thumbnails\n";
echo "----------------------------------\n";

$files = glob($thumbnailsPath . '*.webp');
$stats['total_thumbnails'] = count($files);

foreach ($files as $index => $file) {
    $num = $index + 1;
    $filename = basename($file);

    if ($num % 100 == 0) {
        echo "Processed $num/{$stats['total_thumbnails']} thumbnails...\n";
    }

    $oldSize = filesize($file);
    $stats['size_before_thumbnails'] += $oldSize;

    try {
        $img = Image::make($file);

        // Resize thumbnails
        $img->resize(285, 285, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        // Create temp file
        $tempFile = $thumbnailsPath . 'temp_' . $filename;
        $img->encode('webp', 70)->save($tempFile);

        $newSize = filesize($tempFile);

        // Only replace if we saved space
        if ($newSize < $oldSize) {
            unlink($file);
            rename($tempFile, $file);
            $stats['size_after_thumbnails'] += $newSize;
            $stats['optimized_thumbnails']++;
        } else {
            unlink($tempFile);
            $stats['size_after_thumbnails'] += $oldSize;
        }

    } catch (\Exception $e) {
        $stats['size_after_thumbnails'] += $oldSize;
        $stats['errors']++;
        if ($num % 100 == 0) {
            echo "   Error on $filename: " . $e->getMessage() . "\n";
        }
    }
}

echo "✅ Thumbnails complete!\n\n";

// Final Statistics
echo "\n=================================================================\n";
echo "                    OPTIMIZATION COMPLETE!\n";
echo "=================================================================\n\n";

echo "📊 Statistics:\n";
echo "   Products Processed: {$stats['total_products']}\n";
echo "   Products Optimized: {$stats['optimized_products']}\n";
echo "   Thumbnails Processed: {$stats['total_thumbnails']}\n";
echo "   Thumbnails Optimized: {$stats['optimized_thumbnails']}\n";
echo "   Errors: {$stats['errors']}\n\n";

$totalBefore = $stats['size_before_products'] + $stats['size_before_thumbnails'];
$totalAfter = $stats['size_after_products'] + $stats['size_after_thumbnails'];
$totalSaved = $totalBefore - $totalAfter;
$percentSaved = $totalBefore > 0 ? round(($totalSaved / $totalBefore) * 100, 1) : 0;

echo "💾 Storage Savings:\n";
echo "   Products Before: " . formatBytes($stats['size_before_products']) . "\n";
echo "   Products After:  " . formatBytes($stats['size_after_products']) . "\n";
echo "   Products Saved:  " . formatBytes($stats['size_before_products'] - $stats['size_after_products']) . "\n\n";

echo "   Thumbnails Before: " . formatBytes($stats['size_before_thumbnails']) . "\n";
echo "   Thumbnails After:  " . formatBytes($stats['size_after_thumbnails']) . "\n";
echo "   Thumbnails Saved:  " . formatBytes($stats['size_before_thumbnails'] - $stats['size_after_thumbnails']) . "\n\n";

echo "   📦 TOTAL Before: " . formatBytes($totalBefore) . "\n";
echo "   📦 TOTAL After:  " . formatBytes($totalAfter) . "\n";
echo "   💰 TOTAL Saved:  " . formatBytes($totalSaved) . " ({$percentSaved}%)\n\n";

echo "🚀 Performance Impact:\n";
echo "   ✅ " . formatBytes($totalSaved) . " less data to load\n";
echo "   ✅ {$percentSaved}% faster page loads\n";
echo "   ✅ {$percentSaved}% less bandwidth usage\n";
echo "   ✅ Better mobile experience\n";
echo "   ✅ Improved Google PageSpeed score\n\n";

echo "=================================================================\n";

function formatBytes($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    $bytes /= (1 << (10 * $pow));

    return round($bytes, $precision) . ' ' . $units[$pow];
}
