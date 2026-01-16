<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "Categories Table Structure:\n\n";
$columns = DB::select('DESCRIBE categories');

foreach ($columns as $col) {
    echo "  • {$col->Field} ({$col->Type}) - {$col->Null} - {$col->Key}\n";
}

echo "\n\nSample Categories:\n";
$categories = DB::table('categories')
    ->select('id', 'name', 'slug')
    ->limit(15)
    ->get();

foreach ($categories as $cat) {
    echo "  ID {$cat->id}: {$cat->name}\n";
}

echo "\n\nTotal categories: " . DB::table('categories')->count() . "\n";
