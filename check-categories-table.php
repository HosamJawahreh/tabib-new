<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

$columns = DB::select('DESCRIBE categories');

echo "Categories Table Structure:\n";
foreach ($columns as $col) {
    echo "  • {$col->Field} ({$col->Type})\n";
}
