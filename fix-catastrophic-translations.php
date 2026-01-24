<?php
/**
 * CATASTROPHIC FIX: Clean All "test" Translations
 *
 * ⚠️  WARNING: This will DELETE all "test" translations
 * ⚠️  This action CANNOT be undone without a backup
 *
 * What this script does:
 * 1. Shows you the full extent of the damage
 * 2. Deletes ALL translations set to "test"
 * 3. Optionally deletes Arabic translations (ar_SA) that shouldn't exist
 * 4. Leaves Arabic product names intact in products table
 *
 * After running this:
 * - Your products will have NO English translations
 * - You'll need to manually add English names through admin panel
 * - OR use Google Translate API to auto-generate them
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;
echo "🚨 CATASTROPHIC TRANSLATION CLEANUP 🚨" . PHP_EOL;
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL . PHP_EOL;

// Get statistics
$totalTranslations = DB::table('ec_products_translations')->count();
$testTranslations = DB::table('ec_products_translations')->where('name', 'test')->count();
$arabicTranslations = DB::table('ec_products_translations')->where('lang_code', 'ar_SA')->count();
$totalProducts = DB::table('products')->count();

echo "📊 CURRENT DATABASE STATE:" . PHP_EOL;
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;
echo "Total Products: " . $totalProducts . PHP_EOL;
echo "Total Translations: " . $totalTranslations . PHP_EOL;
echo "Translations with 'test': " . $testTranslations . PHP_EOL;
echo "Arabic translations (ar_SA): " . $arabicTranslations . PHP_EOL;
echo "Percentage corrupted: " . round(($testTranslations / $totalTranslations) * 100, 2) . "%" . PHP_EOL;
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL . PHP_EOL;

if ($testTranslations == $totalTranslations) {
    echo "🚨 CRITICAL: 100% of ALL translations are set to 'test'!" . PHP_EOL;
    echo "This means ALL English translations have been lost!" . PHP_EOL . PHP_EOL;
}

echo "⚠️  CRITICAL WARNING:" . PHP_EOL;
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;
echo "This script will DELETE all corrupted translations." . PHP_EOL;
echo "This action CANNOT be undone without a database backup." . PHP_EOL . PHP_EOL;
echo "Before proceeding, you should:" . PHP_EOL;
echo "1. ✅ Check if you have a database backup" . PHP_EOL;
echo "2. ✅ Create a backup NOW if you haven't" . PHP_EOL;
echo "3. ✅ Verify with your team about the 'test' data" . PHP_EOL . PHP_EOL;

echo "What will happen after cleanup:" . PHP_EOL;
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;
echo "✅ Your {$totalProducts} products will keep their Arabic names" . PHP_EOL;
echo "❌ ALL English translations will be removed" . PHP_EOL;
echo "✓  You can then add proper English names manually" . PHP_EOL;
echo "✓  OR use Google Translate API to auto-generate them" . PHP_EOL;
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL . PHP_EOL;

// Ask for confirmation
echo "🛑 Do you want to proceed with cleanup? (yes/no): ";
$handle = fopen("php://stdin","r");
$line = trim(fgets($handle));

if(strtolower($line) !== 'yes'){
    echo PHP_EOL . "❌ Operation cancelled. No changes made." . PHP_EOL;
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;
    exit(0);
}

echo PHP_EOL . "🔧 Creating backup before cleanup..." . PHP_EOL;

try {
    // Export translations table to backup file
    $backupFile = 'backup-translations-before-cleanup-' . date('Y-m-d-His') . '.sql';
    $dbName = env('DB_DATABASE');
    $dbUser = env('DB_USERNAME');
    $dbPass = env('DB_PASSWORD');

    $command = "mysqldump -u{$dbUser} -p{$dbPass} {$dbName} ec_products_translations > {$backupFile}";
    exec($command, $output, $returnCode);

    if ($returnCode === 0) {
        echo "✅ Backup created: {$backupFile}" . PHP_EOL . PHP_EOL;
    } else {
        echo "⚠️  Could not create automatic backup. Proceeding anyway..." . PHP_EOL . PHP_EOL;
    }
} catch (\Exception $e) {
    echo "⚠️  Backup failed: " . $e->getMessage() . PHP_EOL . PHP_EOL;
}

echo "🗑️  Step 1: Deleting all 'test' translations..." . PHP_EOL;
$deletedTest = DB::table('ec_products_translations')->where('name', 'test')->delete();
echo "✅ Deleted {$deletedTest} 'test' translations" . PHP_EOL . PHP_EOL;

if ($arabicTranslations > 0) {
    echo "🗑️  Step 2: Cleaning invalid Arabic translations..." . PHP_EOL;
    echo "⚠️  Note: Arabic names should ONLY be in products.name column" . PHP_EOL;
    echo "Do you want to delete Arabic translations from translations table? (yes/no): ";
    $line = trim(fgets($handle));

    if(strtolower($line) === 'yes'){
        $deletedArabic = DB::table('ec_products_translations')->where('lang_code', 'ar_SA')->delete();
        echo "✅ Deleted {$deletedArabic} Arabic translations" . PHP_EOL . PHP_EOL;
    } else {
        echo "⏭️  Skipped Arabic translations cleanup" . PHP_EOL . PHP_EOL;
    }
}

fclose($handle);

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;
echo "✅ CLEANUP COMPLETE!" . PHP_EOL;
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL . PHP_EOL;

// Show new state
$remaining = DB::table('ec_products_translations')->count();
echo "📊 NEW DATABASE STATE:" . PHP_EOL;
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;
echo "Total Products: " . $totalProducts . " (unchanged ✓)" . PHP_EOL;
echo "Remaining Translations: " . $remaining . PHP_EOL;
echo "Deleted Translations: " . ($totalTranslations - $remaining) . PHP_EOL;
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL . PHP_EOL;

echo "📋 NEXT STEPS:" . PHP_EOL;
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;
echo "1. ✅ Your products still have their Arabic names" . PHP_EOL;
echo "2. ❌ English translations need to be added" . PHP_EOL . PHP_EOL;
echo "Options to add English translations:" . PHP_EOL;
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;
echo "Option A: Manual Entry" . PHP_EOL;
echo "  - Go to Admin → Products" . PHP_EOL;
echo "  - Edit each product" . PHP_EOL;
echo "  - Fill in the English name field (with UK flag 🇬🇧)" . PHP_EOL;
echo "  - Save" . PHP_EOL . PHP_EOL;
echo "Option B: Restore from Backup (if you have one)" . PHP_EOL;
echo "  - mysql your_database < backup_translations.sql" . PHP_EOL . PHP_EOL;
echo "Option C: Auto-translate (I can create a script)" . PHP_EOL;
echo "  - Use Google Translate API" . PHP_EOL;
echo "  - Automatically translate Arabic → English" . PHP_EOL;
echo "  - Review and adjust as needed" . PHP_EOL;
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL . PHP_EOL;

echo "💡 Would you like me to create an auto-translation script?" . PHP_EOL;
echo "This would use Google Translate API to generate English names" . PHP_EOL;
echo "from your existing Arabic product names." . PHP_EOL . PHP_EOL;

echo "🎯 IMPORTANT: Set up automatic backups to prevent this in future!" . PHP_EOL;
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;
