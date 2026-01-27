<?php
/**
 * Restore ec_products_translations table from backup
 * 
 * This script helps restore the translations table from a backup file
 * Run: php restore-translations-from-backup.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

echo "=================================================\n";
echo "   RESTORE EC_PRODUCTS_TRANSLATIONS FROM BACKUP\n";
echo "=================================================\n\n";

// Get database credentials
$dbHost = env('DB_HOST', '127.0.0.1');
$dbName = env('DB_DATABASE');
$dbUser = env('DB_USERNAME');
$dbPass = env('DB_PASSWORD');

echo "Database: $dbName\n";
echo "User: $dbUser\n\n";

// Check for backup files
$possibleBackups = [
    __DIR__ . '/backup_ec_products_translations.sql',
    __DIR__ . '/ec_products_translations_backup.sql',
    __DIR__ . '/translations_backup.sql',
];

$backupFile = null;
foreach ($possibleBackups as $file) {
    if (File::exists($file)) {
        $backupFile = $file;
        echo "✓ Found backup file: $file\n";
        break;
    }
}

if (!$backupFile) {
    echo "❌ No backup file found!\n";
    echo "\nLooking for:\n";
    foreach ($possibleBackups as $file) {
        echo "  - $file\n";
    }
    echo "\nPlease place your backup SQL file in the project root directory.\n";
    echo "Or provide the path when prompted below.\n\n";
    
    echo "Enter the full path to your backup file (or press Enter to exit): ";
    $customPath = trim(fgets(STDIN));
    
    if (empty($customPath)) {
        echo "Exiting...\n";
        exit(1);
    }
    
    if (!File::exists($customPath)) {
        echo "❌ File not found: $customPath\n";
        exit(1);
    }
    
    $backupFile = $customPath;
}

// Show current data stats
echo "\n=== CURRENT DATA STATS ===\n";
$totalTranslations = DB::table('ec_products_translations')->count();
$enTranslations = DB::table('ec_products_translations')->where('lang_code', 'en_US')->count();
$arTranslations = DB::table('ec_products_translations')->where('lang_code', 'ar_SA')->count();

echo "Total translations: $totalTranslations\n";
echo "English (en_US): $enTranslations\n";
echo "Arabic (ar_SA): $arTranslations\n\n";

// Confirm restoration
echo "⚠️  WARNING: This will DROP and RESTORE the ec_products_translations table!\n";
echo "All current translation data will be replaced with backup data.\n\n";
echo "Do you want to continue? (yes/no): ";
$confirm = trim(fgets(STDIN));

if (strtolower($confirm) !== 'yes') {
    echo "Restoration cancelled.\n";
    exit(0);
}

echo "\n=== CREATING SAFETY BACKUP ===\n";
$safetyBackup = __DIR__ . '/ec_products_translations_before_restore_' . date('Y-m-d_His') . '.sql';
$dumpCommand = "mysqldump -h{$dbHost} -u{$dbUser} -p{$dbPass} {$dbName} ec_products_translations > {$safetyBackup}";
exec($dumpCommand, $output, $returnVar);

if ($returnVar === 0) {
    echo "✓ Safety backup created: $safetyBackup\n\n";
} else {
    echo "⚠️  Could not create safety backup, but continuing...\n\n";
}

echo "=== RESTORING FROM BACKUP ===\n";

try {
    // Read the backup file
    $sql = File::get($backupFile);
    
    // Drop and recreate the table
    echo "Dropping existing table...\n";
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::statement('DROP TABLE IF EXISTS ec_products_translations');
    
    // Execute the backup SQL
    echo "Restoring from backup...\n";
    DB::unprepared($sql);
    
    DB::statement('SET FOREIGN_KEY_CHECKS=1');
    
    echo "✓ Restoration complete!\n\n";
    
    // Show restored data stats
    echo "=== RESTORED DATA STATS ===\n";
    $totalTranslations = DB::table('ec_products_translations')->count();
    $enTranslations = DB::table('ec_products_translations')->where('lang_code', 'en_US')->count();
    $arTranslations = DB::table('ec_products_translations')->where('lang_code', 'ar_SA')->count();
    
    echo "Total translations: $totalTranslations\n";
    echo "English (en_US): $enTranslations\n";
    echo "Arabic (ar_SA): $arTranslations\n\n";
    
    // Verify some random products
    echo "=== VERIFICATION (Random Products) ===\n";
    $randomProducts = DB::table('ec_products_translations')
        ->where('lang_code', 'en_US')
        ->inRandomOrder()
        ->limit(3)
        ->get(['ec_products_id', 'name', 'description']);
    
    foreach ($randomProducts as $product) {
        $desc = substr($product->description ?? 'No description', 0, 50);
        echo "Product ID {$product->ec_products_id}: {$product->name}\n";
        echo "  Description: {$desc}...\n\n";
    }
    
    echo "✅ SUCCESS! Translations have been restored.\n";
    echo "\nThe ProductTranslation model has been fixed to properly handle\n";
    echo "composite primary keys, so this issue should not happen again.\n";
    
} catch (\Exception $e) {
    echo "❌ ERROR during restoration: " . $e->getMessage() . "\n";
    echo "\nYou can manually restore using:\n";
    echo "mysql -u{$dbUser} -p {$dbName} < {$backupFile}\n";
    exit(1);
}

echo "\n=================================================\n";
echo "              RESTORATION COMPLETE\n";
echo "=================================================\n";
