# Regenerate Thumbnails for Existing Products

If you have existing products without thumbnails, you can regenerate them using this script.

## Option 1: Artisan Command (Recommended)

Create this command file:

```bash
php artisan make:command RegenerateThumbnails
```

Then paste this code into `app/Console/Commands/RegenerateThumbnails.php`:

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class RegenerateThumbnails extends Command
{
    protected $signature = 'thumbnails:regenerate {--missing-only : Only regenerate missing thumbnails}';
    protected $description = 'Regenerate product thumbnails';

    public function handle()
    {
        $missingOnly = $this->option('missing-only');
        
        if ($missingOnly) {
            $products = Product::whereNull('thumbnail')
                ->orWhere('thumbnail', '')
                ->get();
            $this->info("Regenerating thumbnails for {$products->count()} products with missing thumbnails...");
        } else {
            $products = Product::all();
            $this->info("Regenerating thumbnails for all {$products->count()} products...");
        }

        $bar = $this->output->createProgressBar($products->count());
        $bar->start();

        $success = 0;
        $failed = 0;
        $skipped = 0;

        foreach ($products as $product) {
            $photoPath = public_path('assets/images/products/' . $product->photo);
            
            if (!file_exists($photoPath)) {
                $skipped++;
                $bar->advance();
                continue;
            }

            try {
                // Ensure thumbnails directory exists
                $thumbnailDir = public_path('assets/images/thumbnails/');
                if (!file_exists($thumbnailDir)) {
                    mkdir($thumbnailDir, 0755, true);
                }

                // Delete old thumbnail if exists
                if ($product->thumbnail) {
                    $oldThumbnailPath = public_path('assets/images/thumbnails/' . $product->thumbnail);
                    if (file_exists($oldThumbnailPath)) {
                        unlink($oldThumbnailPath);
                    }
                }

                $img = Image::make($photoPath);
                
                $img->resize(285, 285, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $thumbnail = time() . Str::random(8) . '.webp';
                $thumbnailPath = public_path('assets/images/thumbnails/' . $thumbnail);

                $img->encode('webp', 60)->save($thumbnailPath);
                
                $product->thumbnail = $thumbnail;
                $product->save();

                $success++;
                
            } catch (\Exception $e) {
                $failed++;
                Log::error("Failed to regenerate thumbnail for product {$product->id}: {$e->getMessage()}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        
        $this->info("✓ Success: {$success}");
        $this->warn("⊘ Skipped (no photo): {$skipped}");
        $this->error("✗ Failed: {$failed}");
        
        $this->newLine();
        $this->info('Thumbnail regeneration complete!');
    }
}
```

### Run the command:

```bash
# Regenerate only missing thumbnails (recommended)
php artisan thumbnails:regenerate --missing-only

# Regenerate all thumbnails (use with caution)
php artisan thumbnails:regenerate
```

## Option 2: Tinker Script

Run this in `php artisan tinker`:

```php
use App\Models\Product;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

$products = Product::whereNull('thumbnail')->orWhere('thumbnail', '')->get();

foreach ($products as $product) {
    $photoPath = public_path('assets/images/products/' . $product->photo);
    
    if (file_exists($photoPath)) {
        try {
            $thumbnailDir = public_path('assets/images/thumbnails/');
            if (!file_exists($thumbnailDir)) {
                mkdir($thumbnailDir, 0755, true);
            }
            
            $img = Image::make($photoPath);
            $img->resize(285, 285, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            $thumbnail = time() . Str::random(8) . '.webp';
            $thumbnailPath = public_path('assets/images/thumbnails/' . $thumbnail);
            $img->encode('webp', 60)->save($thumbnailPath);
            
            $product->thumbnail = $thumbnail;
            $product->save();
            
            echo "✓ {$product->name}\n";
            sleep(1); // Prevent duplicate timestamps
        } catch (\Exception $e) {
            echo "✗ Failed: {$product->name} - {$e->getMessage()}\n";
        }
    } else {
        echo "⊘ No photo: {$product->name}\n";
    }
}

echo "\nDone!\n";
```

## Option 3: Database Query

Find products with missing thumbnails:

```sql
-- Count products without thumbnails
SELECT COUNT(*) FROM products WHERE thumbnail IS NULL OR thumbnail = '';

-- List products without thumbnails
SELECT id, name, photo, thumbnail FROM products 
WHERE thumbnail IS NULL OR thumbnail = '' 
LIMIT 10;

-- Find products where photo exists but thumbnail doesn't
SELECT p.id, p.name, p.photo 
FROM products p 
WHERE (p.thumbnail IS NULL OR p.thumbnail = '')
AND p.photo IS NOT NULL 
AND p.photo != '';
```

## Verification

After regenerating, verify the results:

```bash
# Count thumbnails before
before=$(find public/assets/images/thumbnails -type f -name "*.webp" | wc -l)
echo "Thumbnails before: $before"

# Run regeneration
php artisan thumbnails:regenerate --missing-only

# Count thumbnails after
after=$(find public/assets/images/thumbnails -type f -name "*.webp" | wc -l)
echo "Thumbnails after: $after"
echo "New thumbnails created: $((after - before))"
```

## Important Notes

1. **Backup First**: Always backup your database and files before bulk operations
2. **Missing Only**: Use `--missing-only` flag to only regenerate missing thumbnails
3. **Performance**: Regenerating all thumbnails can take time for large databases
4. **Disk Space**: Ensure you have enough disk space (each thumbnail ~10-15 KB)
5. **Permissions**: Ensure web server has write access to thumbnails directory

## Troubleshooting

### Error: "Call to undefined method"
**Solution**: Make sure Intervention Image is installed:
```bash
composer require intervention/image
```

### Error: "Permission denied"
**Solution**: Fix directory permissions:
```bash
chmod -R 775 public/assets/images/thumbnails
chown -R www-data:www-data public/assets/images/thumbnails
```

### Error: "GD Library extension not installed"
**Solution**: Install GD:
```bash
sudo apt-get install php-gd
sudo systemctl restart apache2  # or nginx/php-fpm
```

## Automation

Add to your cron jobs to automatically check for missing thumbnails:

```bash
# Run daily at 2 AM
0 2 * * * cd /path/to/project && php artisan thumbnails:regenerate --missing-only >> /var/log/thumbnails.log 2>&1
```

---
**Last Updated**: January 25, 2026  
**Purpose**: Regenerate missing product thumbnails  
**Safety**: Backup before running on production
