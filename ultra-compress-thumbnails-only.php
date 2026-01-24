<?php

echo "=== ULTRA-COMPRESS THUMBNAILS ONLY (Quality 60%) ===\n\n";

$thumbnailsDir = 'public/assets/images/thumbnails';

if (!extension_loaded('gd')) {
    die("ERROR: GD extension not loaded. Please install php-gd.\n");
}

$thumbnails = glob($thumbnailsDir . '/*.webp');
$processed = 0;
$optimized = 0;
$totalBefore = 0;
$totalAfter = 0;
$errors = 0;

echo "Found " . count($thumbnails) . " thumbnail files\n\n";
echo "Processing thumbnails with quality 60% (ULTRA compression)...\n\n";

foreach ($thumbnails as $file) {
    try {
        $originalSize = filesize($file);
        $totalBefore += $originalSize;
        
        // Load WebP image using imagecreatefromwebp
        $img = @imagecreatefromwebp($file);
        
        if ($img === false) {
            echo "⚠ Skipped " . basename($file) . " (cannot read)\n";
            $errors++;
            continue;
        }
        
        // Resize to 285x285 if needed
        $width = imagesx($img);
        $height = imagesy($img);
        
        if ($width > 285 || $height > 285) {
            // Calculate new dimensions maintaining aspect ratio
            $ratio = min(285 / $width, 285 / $height);
            $newWidth = round($width * $ratio);
            $newHeight = round($height * $ratio);
            
            $newImg = imagecreatetruecolor($newWidth, $newHeight);
            imagealphablending($newImg, false);
            imagesavealpha($newImg, true);
            
            imagecopyresampled($newImg, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($img);
            $img = $newImg;
        }
        
        // Save with ultra compression (quality 60)
        $tempFile = $file . '.tmp';
        imagewebp($img, $tempFile, 60);
        imagedestroy($img);
        
        $newSize = filesize($tempFile);
        $totalAfter += $newSize;
        
        // Only replace if smaller
        if ($newSize < $originalSize) {
            rename($tempFile, $file);
            $optimized++;
            
            $savedKB = round(($originalSize - $newSize) / 1024, 2);
            
            if ($processed < 10) {
                echo "✓ " . basename($file) . " - Saved {$savedKB} KB\n";
            }
        } else {
            unlink($tempFile);
        }
        
        $processed++;
        
        // Progress indicator every 500 files
        if ($processed % 500 === 0) {
            echo "\n--- Processed {$processed}/{" . count($thumbnails) . "} thumbnails ---\n\n";
        }
        
    } catch (Exception $e) {
        $errors++;
        if ($errors < 10) {
            echo "✗ Error on " . basename($file) . ": " . $e->getMessage() . "\n";
        }
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

echo "✓ DONE! Thumbnails compressed to MINIMUM size (quality 60%)\n";
echo "  Products remain at original quality for detail pages.\n";

