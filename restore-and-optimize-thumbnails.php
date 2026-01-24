<?php

require __DIR__.'/vendor/autoload.php';

use Intervention\Image\Facades\Image;

echo "=== RESTORE ORIGINAL PRODUCTS & ULTRA-COMPRESS THUMBNAILS ===\n\n";

// Step 1: Restore original product images from backup
echo "Step 1: Restoring original product images from backup...\n";

$backupFile = 'public/assets/images/backup-images-20260124-165058.tar.gz';
$productsDir = 'public/assets/images/products';
$thumbnailsDir = 'public/assets/images/thumbnails';

if (!file_exists($backupFile)) {
    die("ERROR: Backup file not found!\n");
}

// Extract only the products folder from backup (overwrite current compressed ones)
echo "Extracting products from backup...\n";
exec("cd public/assets/images && tar -xzf backup-images-20260124-165058.tar.gz products/ 2>&1", $output, $returnCode);

if ($returnCode === 0) {
    echo "✓ Products restored successfully!\n\n";
} else {
    echo "⚠ Warning: " . implode("\n", $output) . "\n\n";
}

// Step 2: Ultra-compress thumbnails (SMALLEST SIZE EVER)
echo "Step 2: Ultra-compressing thumbnails (quality 60% for MINIMUM size)...\n\n";

$thumbnails = glob($thumbnailsDir . '/*.webp');
$processed = 0;
$optimized = 0;
$totalBefore = 0;
$totalAfter = 0;
$errors = 0;

foreach ($thumbnails as $file) {
    try {
        $originalSize = filesize($file);
        $totalBefore += $originalSize;

        // Load and ultra-compress (quality 60 = MINIMUM size with acceptable quality)
        $img = Image::make($file);

        // Ensure small dimensions for thumbnails
        $img->resize(285, 285, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        // Save with ULTRA compression (quality 60%)
        $tempFile = $file . '.tmp';
        $img->encode('webp', 60)->save($tempFile);

        $newSize = filesize($tempFile);
        $totalAfter += $newSize;

        // Only replace if smaller
        if ($newSize < $originalSize) {
            rename($tempFile, $file);
            $optimized++;

            $savedKB = round(($originalSize - $newSize) / 1024, 2);
            echo "✓ " . basename($file) . " - Saved {$savedKB} KB\n";
        } else {
            unlink($tempFile);
        }

        $processed++;

        // Progress indicator every 500 files
        if ($processed % 500 === 0) {
            echo "\n--- Processed {$processed} thumbnails ---\n\n";
        }

    } catch (Exception $e) {
        $errors++;
        echo "✗ Error on " . basename($file) . ": " . $e->getMessage() . "\n";
    }
}

// Final Statistics
echo "\n=== RESULTS ===\n";
echo "Thumbnails Processed: {$processed}\n";
echo "Thumbnails Optimized: {$optimized}\n";
echo "Errors: {$errors}\n\n";

$beforeMB = round($totalBefore / 1024 / 1024, 2);
$afterMB = round($totalAfter / 1024 / 1024, 2);
$savedMB = round(($totalBefore - $totalAfter) / 1024 / 1024, 2);
$savedPercent = $totalBefore > 0 ? round((($totalBefore - $totalAfter) / $totalBefore) * 100, 1) : 0;

echo "Thumbnails Before: {$beforeMB} MB\n";
echo "Thumbnails After: {$afterMB} MB\n";
echo "Saved: {$savedMB} MB ({$savedPercent}%)\n\n";

// Check products folder size
exec("du -sh {$productsDir}", $productSize);
exec("du -sh {$thumbnailsDir}", $thumbSize);

echo "=== FINAL SIZES ===\n";
echo "Products (original quality): " . trim($productSize[0]) . "\n";
echo "Thumbnails (ultra-compressed): " . trim($thumbSize[0]) . "\n";

echo "\n✓ DONE! Products use original quality, thumbnails are ultra-compressed!\n";

