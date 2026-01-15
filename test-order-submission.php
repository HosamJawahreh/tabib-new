<?php

// Test order submission directly
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Cart;
use Illuminate\Support\Facades\Session;

echo "🧪 Testing Order Submission\n";
echo "==========================\n\n";

// Create a fake cart
$cart = new Cart(null);
$cart->items = [
    [
        'item' => [
            'id' => 1,
            'name' => 'Test Product',
            'photo' => 'test.jpg',
            'price' => 10.00
        ],
        'qty' => 1,
        'price' => 10.00
    ]
];
$cart->totalQty = 1;
$cart->totalPrice = 10.00;

Session::put('cart', $cart);

echo "✅ Cart created in session\n";
echo "Cart items: " . count($cart->items) . "\n";
echo "Total: " . $cart->totalPrice . "\n\n";

// Test if Cart can be retrieved
$retrievedCart = Session::get('cart');
if ($retrievedCart) {
    echo "✅ Cart retrieved successfully\n";
    echo "Total Qty: " . $retrievedCart->totalQty . "\n";
    echo "Total Price: " . $retrievedCart->totalPrice . "\n\n";
} else {
    echo "❌ Failed to retrieve cart\n\n";
}

// Try to create a simple request
echo "📝 Simulating request data...\n";
$requestData = [
    'customer_name' => 'Test Customer',
    'customer_email' => 'test@example.com',
    'customer_phone' => '1234567890',
    'customer_address' => 'Test Address',
    'customer_city' => 'Test City',
    'customer_country' => 'Test Country',
    'method' => 'Cash on Delivery',
    'shipping' => 'shipto',
    'currency_sign' => 'JD',
    'currency_name' => 'Jordanian Dinar',
    'currency_value' => 0.71,
    'shipping_cost' => 0,
    'packing_cost' => 0,
    'tax' => 0
];

echo "✅ Request data prepared\n\n";

foreach ($requestData as $key => $value) {
    echo "  $key: $value\n";
}

echo "\n✅ Test data looks good!\n";
echo "\nNow try submitting the order through the browser.\n";
