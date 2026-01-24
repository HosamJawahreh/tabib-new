<?php
/**
 * Convert ALL Existing Product Images to ULTRA-COMPRESSED WebP
 * 
 * This script will:
 * 1. Convert all PNG/JPG/JPEG images to WebP with maximum compression
 * 2. Resize images to max 1200px (reduces size dramatically)
 * 3. Use quality 75 for products (excellent for WebP)
 * 4. Use quality 70 for thumbnails (perfect for small images)
 * 5. Update database with new filenames
 * 6. Delete old files after successful conversion
 * 7. Show size savings
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Intervention\Image\Facades\Image;
use App\Models\Product;

echo "=================================================================\n";
echo "    ULTRA-COMPRESSED WebP Conversion Tool\n";
echo "    Maximum Compression for Best Performance\n";
echo "=================================================================\n\n";

$productsPath = public_path('assets/images/products/');
$thumbnailsPath = public_path('assets/images/thumbnails/');

// Statistics
$stats = [
    'total_products' => 0,
    'converted_products' => 0,
    'skipped_products' => 0,
    'converted_thumbnails' => 0,
    'total_size_before' => 0,
    'total_size_after' => 0,
    'errors' => 0
];

echo "Step 1: Converting Product Images (Main Photos)\n";
echo "------------------------------------------------\n";

$products = Product::whereNotNull('photo')->get();
$stats['total_products'] = $products->count();

foreach ($products as $index => $product) {
    $num = $index + 1;
    echo "[$num/{$stats['total_products']}] Processing: {$product->name} (ID: {$product->id})\n";
    
    // Skip if already WebP
    if (pathinfo($product->photo, PATHINFO_EXTENSION) === 'webp') {
        echo "   ⚠️  Already WebP, checking if needs optimization...\n";
        
        $photoPath = $productsPath . $product->photo;
        if (file_exists($photoPath)) {
            $currentSize = filesize($photoPath);
            $stats['total_size_before'] += $currentSize;
            
            try {
                // Re-optimize existing WebP with better compression
                $img = Image::make($photoPath);
                
                // Resize to max 1200px
                $img->resize(1200, 1200, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                
                $newFilename = time() . '_' . $product->id . '_opt.webp';
                $newPath = $productsPath . $newFilename;
                
                // Save with 75% quality (aggressive compression)
                $img->encode('webp', 75)->save($newPath);
                
                $newSize = filesize($newPath);
                $saved = $currentSize - $newSize;
                $percentSaved = round(($saved / $currentSize) * 100, 1);
                
                if ($saved > 0) {
                    // Only replace if we saved space
                    @unlink($photoPath);
                    $product->photo = $newFilename;
                    $product->save();
                    
                    $stats['total_size_after'] += $newSize;
                    $stats['converted_products']++;
                    
                    echo "   ✅ Re-optimized: " . formatBytes($currentSize) . " → " . formatBytes($newSize) . " (saved {$percentSaved}%)\n";
                } else {
                    // New file is bigger, keep original
                    @unlink($newPath);
                    $stats['total_size_after'] += $currentSize;
                    $stats['skipped_products']++;
                    echo "   ⏭️  Already optimal, skipped\n";
                }
            } catch (Exception $e) {
                echo "   ❌ Error: " . $e->getMessage() . "\n";
                $stats['errors']++;
                $stats['total_size_after'] += $currentSize;
            }
        } else {
            echo "   ⚠️  File not found, skipping\n";
            $stats['skipped_products']++;
        }
        continue;
    }
    
    // Convert non-WebP images
    $photoPath = $productsPath . $product->photo;
    
    if (!file_exists($photoPath)) {
        echo "   ⚠️  File not found: {$product->photo}\n";
        $stats['skipped_products']++;
        continue;
    }
    
    $oldSize = filesize($photoPath);
    $stats['total_size_before'] += $oldSize;
    
    try {
        $img = Image::make($photoPath);
        
        // Resize to maximum 1200px (maintains aspect ratio)
        $img->resize(1200, 1200, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize(); // Don't upscale smaller images
        });
        
        // Generate new filename
        $newFilename = pathinfo($product->photo, PATHINFO_FILENAME) . '.webp';
        $newPath = $productsPath . $newFilename;
        
        // Save with 75% quality (perfect balance for WebP)
        $img->encode('webp', 75)->save($newPath);
        
        $newSize = filesize($newPath);
        $saved = $oldSize - $newSize;
        $percentSaved = round(($saved / $oldSize) * 100, 1);
        
        // Update database
        $product->photo = $newFilename;
        $product->save();
        
        // Delete old file
        @unlink($photoPath);
        
        $stats['converted_products']++;
        $stats['total_size_after'] += $newSize;
        
        echo "   ✅ Converted: " . formatBytes($oldSize) . " → " . formatBytes($newSize) . " (saved {$percentSaved}%)\n";
        
    } catch (Exception $e) {
        echo "   ❌ Error: " . $e->getMessage() . "\n";
        $stats['errors']++;
        $stats['total_size_after'] += $oldSize;
    }
}

echo "\n\nStep 2: Converting Thumbnails\n";
echo "------------------------------\n";

$productsWithThumbs = Product::whereNotNull('thumbnail')->get();

foreach ($productsWithThumbs as $index => $product) {
    $num = $index + 1;
    $total = $productsWithThumbs->count();
    echo "[$num/$total] Processing thumbnail for: {$product->name}\n";
    
    // Skip if already optimized WebP
    if (pathinfo($product->thumbnail, PATHINFO_EXTENSION) === 'webp' && 
        strpos($product->thumbnail, '_opt.webp') !== false) {
        echo "   ⏭️  Already optimized, skipping\n";
        continue;
    }
    
    $thumbPath = $thumbnailsPath . $product->thumbnail;
    
    if (!file_exists($thumbPath)) {
        echo "   ⚠️  File not found: {$product->thumbnail}\n";
        continue;
    }
    
    $oldSize = filesize($thumbPath);
    $stats['total_size_before'] += $oldSize;
    
    try {
        $img = Image::make($thumbPath);
        
        // Resize to 285x285 (thumbnail size)
        $img->resize(285, 285, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        
        // Generate new filename
        $newFilename = pathinfo($product->thumbnail, PATHINFO_FILENAME) . '_opt.webp';
        $newPath = $thumbnailsPath . $newFilename;
        
        // Save with 70% quality (aggressive for thumbnails)
        $img->encode('webp', 70)->save($newPath);
        
        $newSize = filesize($newPath);
        $saved = $oldSize - $newSize;
        $percentSaved = round(($saved / $oldSize) * 100, 1);
        
        // Update database
        $product->thumbnail = $newFilename;
        $product->save();
        
        // Delete old file
        @unlink($thumbPath);
        
        $stats['converted_thumbnails']++;
        $stats['total_size_after'] += $newSize;
        
        echo "   ✅ Converted: " . formatBytes($oldSize) . " → " . formatBytes($newSize) . " (saved {$percentSaved}%)\n";
        
    } catch (Exception $e) {
        echo "   ❌ Error: " . $e->getMessage() . "\n";
        $stats['errors']++;
        $stats['total_size_after'] += $oldSize;
    }
}

// Final Statistics
echo "\n\n";
echo "=================================================================\n";
echo "                    CONVERSION COMPLETE!\n";
echo "=================================================================\n\n";

echo "📊 Statistics:\n";
echo "   Total Products: {$stats['total_products']}\n";
echo "   Converted Products: {$stats['converted_products']}\n";
echo "   Converted Thumbnails: {$stats['converted_thumbnails']}\n";
echo "   Skipped: {$stats['skipped_products']}\n";
echo "   Errors: {$stats['errors']}\n\n";

$totalSaved = $stats['total_size_before'] - $stats['total_size_after'];
$percentSaved = $stats['total_size_before'] > 0 
    ? round(($totalSaved / $stats['total_size_before']) * 100, 1) 
    : 0;

echo "💾 Storage Savings:\n";
echo "   Before: " . formatBytes($stats['total_size_before']) . "\n";
echo "   After:  " . formatBytes($stats['total_size_after']) . "\n";
echo "   Saved:  " . formatBytes($totalSaved) . " ({$percentSaved}%)\n\n";

echo "🚀 Performance Impact:\n";
echo "   ✅ Faster page load times\n";
echo "   ✅ Reduced bandwidth usage\n";
echo "   ✅ Better mobile performance\n";
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
