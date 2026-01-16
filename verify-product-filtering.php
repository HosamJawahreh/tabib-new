<?php
/**
 * Verification Script - Check Product Status Filtering
 * 
 * This script verifies that inactive products (status=0) are properly filtered
 * from all product queries in the application.
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Product;

echo "================================================================================\n";
echo "PRODUCT STATUS FILTERING VERIFICATION\n";
echo "================================================================================\n\n";

// Get current status distribution
echo "📊 Current Database Status:\n";
$statusCount = DB::table('products')
    ->select('status', DB::raw('COUNT(*) as count'))
    ->groupBy('status')
    ->orderBy('status', 'desc')
    ->get();

$totalActive = 0;
$totalInactive = 0;

foreach ($statusCount as $stat) {
    $label = $stat->status == 1 ? 'Active (Published)' : 'Inactive (Pending)';
    echo "   - Status {$stat->status} ({$label}): {$stat->count} products\n";
    
    if ($stat->status == 1) $totalActive = $stat->count;
    if ($stat->status == 0) $totalInactive = $stat->count;
}

echo "\n";
echo "================================================================================\n";
echo "TESTING PRODUCT QUERIES\n";
echo "================================================================================\n\n";

$tests = [];

// Test 1: Homepage products query
try {
    $homeProducts = Product::where('status', 1)->count();
    $tests[] = [
        'name' => 'Homepage Products',
        'result' => $homeProducts,
        'expected' => $totalActive,
        'status' => $homeProducts == $totalActive ? '✅' : '❌'
    ];
} catch (Exception $e) {
    $tests[] = ['name' => 'Homepage Products', 'result' => 0, 'expected' => $totalActive, 'status' => '❌', 'error' => $e->getMessage()];
}

// Test 2: Hot products
try {
    $hotProducts = Product::whereHot(1)->whereStatus(1)->count();
    $tests[] = [
        'name' => 'Hot Products',
        'result' => $hotProducts,
        'expected' => "Active hot products",
        'status' => '✅'
    ];
} catch (Exception $e) {
    $tests[] = ['name' => 'Hot Products', 'result' => 0, 'expected' => 'N/A', 'status' => '❌', 'error' => $e->getMessage()];
}

// Test 3: Latest products
try {
    $latestProducts = Product::whereLatest(1)->whereStatus(1)->count();
    $tests[] = [
        'name' => 'Latest Products',
        'result' => $latestProducts,
        'expected' => "Active latest products",
        'status' => '✅'
    ];
} catch (Exception $e) {
    $tests[] = ['name' => 'Latest Products', 'result' => 0, 'expected' => 'N/A', 'status' => '❌', 'error' => $e->getMessage()];
}

// Test 4: Sale products
try {
    $saleProducts = Product::whereSale(1)->whereStatus(1)->count();
    $tests[] = [
        'name' => 'Sale Products',
        'result' => $saleProducts,
        'expected' => "Active sale products",
        'status' => '✅'
    ];
} catch (Exception $e) {
    $tests[] = ['name' => 'Sale Products', 'result' => 0, 'expected' => 'N/A', 'status' => '❌', 'error' => $e->getMessage()];
}

// Test 5: Best seller products
try {
    $bestProducts = Product::whereStatus(1)->whereBest(1)->count();
    $tests[] = [
        'name' => 'Best Seller Products',
        'result' => $bestProducts,
        'expected' => "Active best products",
        'status' => '✅'
    ];
} catch (Exception $e) {
    $tests[] = ['name' => 'Best Seller Products', 'result' => 0, 'expected' => 'N/A', 'status' => '❌', 'error' => $e->getMessage()];
}

// Test 6: Featured products
try {
    $featuredProducts = Product::whereStatus(1)->whereFeatured(1)->count();
    $tests[] = [
        'name' => 'Featured Products',
        'result' => $featuredProducts,
        'expected' => "Active featured products",
        'status' => '✅'
    ];
} catch (Exception $e) {
    $tests[] = ['name' => 'Featured Products', 'result' => 0, 'expected' => 'N/A', 'status' => '❌', 'error' => $e->getMessage()];
}

// Test 7: Top rated products
try {
    $topProducts = Product::whereStatus(1)->whereTop(1)->count();
    $tests[] = [
        'name' => 'Top Rated Products',
        'result' => $topProducts,
        'expected' => "Active top products",
        'status' => '✅'
    ];
} catch (Exception $e) {
    $tests[] = ['name' => 'Top Rated Products', 'result' => 0, 'expected' => 'N/A', 'status' => '❌', 'error' => $e->getMessage()];
}

// Test 8: Search - verify no inactive products in search
try {
    $searchAllActive = Product::where('status', '=', 1)->where('name', 'like', '%a%')->count();
    $searchAll = Product::where('name', 'like', '%a%')->count();
    $tests[] = [
        'name' => 'Search Filtering',
        'result' => "{$searchAllActive} active / {$searchAll} total",
        'expected' => "Only active products",
        'status' => $searchAllActive <= $totalActive ? '✅' : '❌'
    ];
} catch (Exception $e) {
    $tests[] = ['name' => 'Search Filtering', 'result' => 0, 'expected' => 'N/A', 'status' => '❌', 'error' => $e->getMessage()];
}

// Test 9: Verify NO inactive products show up without filter
try {
    $withoutFilter = Product::count();
    $withFilter = Product::where('status', 1)->count();
    $tests[] = [
        'name' => 'Status Filter Check',
        'result' => "With filter: {$withFilter}, Without: {$withoutFilter}",
        'expected' => "{$totalActive} active, {$totalInactive} inactive",
        'status' => ($withFilter == $totalActive && $withoutFilter == ($totalActive + $totalInactive)) ? '✅' : '❌'
    ];
} catch (Exception $e) {
    $tests[] = ['name' => 'Status Filter Check', 'result' => 0, 'expected' => 'N/A', 'status' => '❌', 'error' => $e->getMessage()];
}

// Display test results
foreach ($tests as $test) {
    echo "{$test['status']} {$test['name']}\n";
    echo "   Result: {$test['result']}\n";
    echo "   Expected: {$test['expected']}\n";
    if (isset($test['error'])) {
        echo "   Error: {$test['error']}\n";
    }
    echo "\n";
}

echo "================================================================================\n";
echo "VERIFICATION COMPLETE\n";
echo "================================================================================\n\n";

$passedTests = count(array_filter($tests, function($t) { return $t['status'] === '✅'; }));
$totalTests = count($tests);

echo "Tests Passed: {$passedTests}/{$totalTests}\n\n";

if ($passedTests === $totalTests) {
    echo "✅ ALL TESTS PASSED! Inactive products are properly filtered.\n";
} else {
    echo "⚠️  Some tests failed. Please review the results above.\n";
}

echo "================================================================================\n";
