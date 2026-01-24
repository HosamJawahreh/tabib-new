<?php

/**
 * Convert All Product Images and Thumbnails to WebP Format
 * 
 * This script converts all existing product images and thumbnails to WebP format
 * with maximum compression for best website performance.
 * 
 * Usage: php convert-images-to-webp.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Intervention\Image\Facades\Image;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ImageConverter
{
    private $productsPath;
    private $thumbnailsPath;
    private $backupPath;
    private $stats = [
        'total_products' => 0,
        'products_converted' => 0,
        'products_skipped' => 0,
        'products_failed' => 0,
        'thumbnails_converted' => 0,
        'thumbnails_failed' => 0,
        'space_saved_mb' => 0,
    ];

    public function __construct()
    {
        $this->productsPath = public_path('assets/images/products');
        $this->thumbnailsPath = public_path('assets/images/thumbnails');
        $this->backupPath = public_path('assets/images/backup_originals');
        
        // Create backup directory if it doesn't exist
        if (!file_exists($this->backupPath)) {
            mkdir($this->backupPath, 0755, true);
        }
    }

    public function run()
    {
        echo "\n╔══════════════════════════════════════════════════════════════╗\n";
        echo "║          WebP Image Conversion Tool - Tabib System          ║\n";
        echo "╚══════════════════════════════════════════════════════════════╝\n\n";

        echo "⚙️  Configuration:\n";
        echo "   - Product Images Quality: 85%\n";
        echo "   - Thumbnail Quality: 80%\n";
        echo "   - Thumbnail Size: 285x285px\n";
        echo "   - Backup: YES (originals saved to backup_originals/)\n\n";

        echo "🔍 Loading products from database...\n";
        $products = Product::whereNotNull('photo')->get();
        $this->stats['total_products'] = $products->count();

        echo "📊 Found {$this->stats['total_products']} products with images\n\n";
        
        if ($this->stats['total_products'] == 0) {
            echo "✓ No products to process.\n";
            return;
        }

        echo "🚀 Starting conversion process...\n";
        echo str_repeat("─", 62) . "\n\n";

        $progressBar = 0;
        foreach ($products as $index => $product) {
            $progressBar = ($index + 1);
            $percentage = round(($progressBar / $this->stats['total_products']) * 100);
            
            echo "Processing [{$progressBar}/{$this->stats['total_products']}] ({$percentage}%) - ID: {$product->id}\n";
            
            $this->convertProductImage($product);
            
            echo "\n";
        }

        $this->displaySummary();
    }

    private function convertProductImage($product)
    {
        $originalPhoto = $product->photo;
        $photoPath = $this->productsPath . '/' . $originalPhoto;

        // Skip if already WebP
        if (pathinfo($originalPhoto, PATHINFO_EXTENSION) === 'webp') {
            echo "   ⏭️  Already WebP format, skipping...\n";
            $this->stats['products_skipped']++;
            
            // Still create/update thumbnail
            $this->createThumbnail($product, $photoPath);
            return;
        }

        // Skip if file doesn't exist
        if (!file_exists($photoPath)) {
            echo "   ⚠️  File not found: {$originalPhoto}\n";
            $this->stats['products_failed']++;
            return;
        }

        try {
            // Get original file size
            $originalSize = filesize($photoPath);
            
            // Backup original file
            $backupFile = $this->backupPath . '/' . $originalPhoto;
            if (!file_exists($backupFile)) {
                copy($photoPath, $backupFile);
                echo "   💾 Backed up original\n";
            }

            // Convert to WebP
            $img = Image::make($photoPath);
            $webpName = pathinfo($originalPhoto, PATHINFO_FILENAME) . '.webp';
            $webpPath = $this->productsPath . '/' . $webpName;
            
            $img->encode('webp', 85)->save($webpPath);
            
            // Get new file size
            $newSize = filesize($webpPath);
            $savedSpace = $originalSize - $newSize;
            $this->stats['space_saved_mb'] += ($savedSpace / 1024 / 1024);
            
            $savedPercentage = round(($savedSpace / $originalSize) * 100);
            $originalKb = round($originalSize / 1024);
            $newKb = round($newSize / 1024);
            
            echo "   ✓ Converted: {$originalKb}KB → {$newKb}KB (saved {$savedPercentage}%)\n";
            
            // Update database
            $product->photo = $webpName;
            $product->save();
            
            // Delete old image file (not WebP)
            if (file_exists($photoPath) && pathinfo($photoPath, PATHINFO_EXTENSION) !== 'webp') {
                unlink($photoPath);
                echo "   🗑️  Deleted old image\n";
            }
            
            $this->stats['products_converted']++;
            
            // Create thumbnail
            $this->createThumbnail($product, $webpPath);
            
        } catch (\Exception $e) {
            echo "   ❌ Conversion failed: " . $e->getMessage() . "\n";
            Log::error("Image conversion failed for product {$product->id}: " . $e->getMessage());
            $this->stats['products_failed']++;
        }
    }

    private function createThumbnail($product, $photoPath)
    {
        try {
            if (!file_exists($photoPath)) {
                echo "   ⚠️  Photo not found for thumbnail creation\n";
                return;
            }

            // Delete old thumbnail if exists
            if ($product->thumbnail) {
                $oldThumbPath = $this->thumbnailsPath . '/' . $product->thumbnail;
                if (file_exists($oldThumbPath)) {
                    unlink($oldThumbPath);
                }
            }

            // Create new WebP thumbnail
            $img = Image::make($photoPath)->resize(285, 285);
            $thumbnailName = time() . '_' . $product->id . '_thumb.webp';
            $thumbnailPath = $this->thumbnailsPath . '/' . $thumbnailName;
            
            $img->encode('webp', 80)->save($thumbnailPath);
            
            // Update database
            $product->thumbnail = $thumbnailName;
            $product->save();
            
            $thumbSize = round(filesize($thumbnailPath) / 1024);
            echo "   🖼️  Thumbnail created: {$thumbSize}KB\n";
            
            $this->stats['thumbnails_converted']++;
            
        } catch (\Exception $e) {
            echo "   ⚠️  Thumbnail creation failed: " . $e->getMessage() . "\n";
            Log::error("Thumbnail creation failed for product {$product->id}: " . $e->getMessage());
            $this->stats['thumbnails_failed']++;
        }
    }

    private function displaySummary()
    {
        echo "\n" . str_repeat("═", 62) . "\n";
        echo "                       CONVERSION SUMMARY\n";
        echo str_repeat("═", 62) . "\n\n";
        
        echo "📦 Total Products:          {$this->stats['total_products']}\n";
        echo "✅ Successfully Converted:  {$this->stats['products_converted']}\n";
        echo "⏭️  Already WebP (Skipped):  {$this->stats['products_skipped']}\n";
        echo "❌ Failed:                  {$this->stats['products_failed']}\n";
        echo "🖼️  Thumbnails Created:     {$this->stats['thumbnails_converted']}\n";
        echo "⚠️  Thumbnail Failures:     {$this->stats['thumbnails_failed']}\n";
        
        $spaceSaved = round($this->stats['space_saved_mb'], 2);
        echo "\n💾 Total Space Saved:       {$spaceSaved} MB\n";
        
        echo "\n" . str_repeat("─", 62) . "\n";
        echo "✓ Conversion complete!\n";
        echo "✓ Original images backed up to: assets/images/backup_originals/\n";
        echo "✓ All product records updated in database\n\n";
    }
}

// Run the converter
$converter = new ImageConverter();
$converter->run();

echo "Press Enter to exit...";
fgets(STDIN);
