<?php
/**
 * Create Category-Product Pivot Table
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

echo "================================================================================\n";
echo "CREATE CATEGORY-PRODUCT PIVOT TABLE\n";
echo "================================================================================\n\n";

// Drop if exists
if (Schema::hasTable('category_product')) {
    echo "⚠️  Dropping existing category_product table...\n";
    Schema::dropIfExists('category_product');
}

echo "📦 Creating category_product pivot table...\n";

Schema::create('category_product', function (Blueprint $table) {
    $table->unsignedBigInteger('category_id');
    $table->unsignedBigInteger('product_id');

    $table->primary(['category_id', 'product_id']);

    $table->index('category_id');
    $table->index('product_id');
});

echo "✅ Table created successfully!\n\n";

// Verify
$tableExists = Schema::hasTable('category_product');
echo "Verification: " . ($tableExists ? "✅ Table EXISTS" : "❌ Table NOT FOUND") . "\n";

if ($tableExists) {
    echo "\nTable structure:\n";
    $columns = Schema::getColumnListing('category_product');
    foreach ($columns as $col) {
        echo "  • $col\n";
    }
}

echo "\n================================================================================\n";
