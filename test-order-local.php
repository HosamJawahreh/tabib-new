<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "🧪 TESTING ORDER SUBMISSION LOCALLY\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

// 1. Check currency
echo "1️⃣  Checking currency...\n";
$currency = DB::table('currencies')->where('id', 12)->first();
echo "   Currency Name: {$currency->name}\n";
echo "   Currency Sign: {$currency->sign}\n";
echo "   Length: " . strlen($currency->name) . " characters\n";
echo "   ✅ Currency found\n\n";

// 2. Check orders table structure
echo "2️⃣  Checking orders table structure...\n";
$result = DB::select("SHOW COLUMNS FROM orders WHERE Field = 'currency_name'");
if (!empty($result)) {
    echo "   Column Type: {$result[0]->Type}\n";
    
    // Extract size from VARCHAR(X)
    preg_match('/varchar\((\d+)\)/i', $result[0]->Type, $matches);
    $size = isset($matches[1]) ? intval($matches[1]) : 0;
    
    if ($size < 50) {
        echo "   ❌ PROBLEM: Column too small ({$size} chars)\n";
        echo "   ⚠️  Need at least 50 characters\n\n";
        echo "Run this SQL to fix:\n";
        echo "ALTER TABLE orders MODIFY COLUMN currency_name VARCHAR(50);\n\n";
    } else {
        echo "   ✅ Column size OK ({$size} chars)\n\n";
    }
}

// 3. Test order creation
echo "3️⃣  Testing order creation...\n";
try {
    // Create test cart
    $cart = new \App\Models\Cart([]);
    $cart->items = [
        [
            'item' => [
                'name' => 'Test Product',
                'photo' => 'test.jpg',
                'id' => 1
            ],
            'price' => 10.50,
            'qty' => 2
        ]
    ];
    $cart->totalQty = 2;
    $cart->totalPrice = 21.00;
    
    // Create test order
    $order = new \App\Models\Order();
    $order->order_number = 'TEST-' . time();
    $order->cart = json_encode($cart->items);
    $order->method = 'Cash on Delivery';
    $order->shipping = 'shipto';
    $order->totalQty = $cart->totalQty;
    $order->pay_amount = $cart->totalPrice;
    $order->payment_status = 'Pending';
    $order->status = 'pending';
    
    // Customer details
    $order->customer_name = 'Test Customer';
    $order->customer_email = 'test@example.com';
    $order->customer_phone = '0123456789';
    $order->customer_country = 'Jordan';
    $order->customer_address = 'Test Address';
    $order->customer_city = 'Amman';
    $order->customer_zip = '11111';
    
    // Shipping (same as customer)
    $order->shipping_name = $order->customer_name;
    $order->shipping_email = $order->customer_email;
    $order->shipping_phone = $order->customer_phone;
    $order->shipping_country = $order->customer_country;
    $order->shipping_address = $order->customer_address;
    $order->shipping_city = $order->customer_city;
    $order->shipping_zip = $order->customer_zip;
    
    // Currency - THIS IS THE CRITICAL PART
    $order->currency_sign = $currency->sign;
    $order->currency_name = $currency->name; // This was causing the error!
    $order->currency_value = $currency->value;
    
    // Add all required fields
    $order->shipping_cost = 0;
    $order->packing_cost = 0;
    $order->tax = 0;
    $order->dp = 0;
    $order->wallet_price = 0;
    $order->coupon_code = null;
    $order->coupon_discount = 0;
    $order->order_note = '';
    $order->customer_state = '';
    $order->shipping_state = '';
    $order->pickup_location = null;
    $order->txnid = null;
    $order->charge_id = null;
    
    echo "   Testing with currency name: '{$currency->name}' (" . strlen($currency->name) . " chars)\n";
    
    // Try to save
    $order->save();
    
    echo "   ✅ Order created successfully!\n";
    echo "   Order Number: {$order->order_number}\n\n";
    
    // Clean up test order
    $order->delete();
    echo "   🧹 Test order cleaned up\n\n";
    
} catch (\Exception $e) {
    echo "   ❌ ERROR: " . $e->getMessage() . "\n\n";
    
    if (strpos($e->getMessage(), 'Data too long') !== false) {
        echo "   🔧 FIX NEEDED:\n";
        echo "   Run: mysql -u root -p your_database < fix-currency-name-column.sql\n";
        echo "   Or: php artisan migrate\n\n";
    }
}

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "📋 SUMMARY\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

$result = DB::select("SHOW COLUMNS FROM orders WHERE Field = 'currency_name'");
if (!empty($result)) {
    preg_match('/varchar\((\d+)\)/i', $result[0]->Type, $matches);
    $size = isset($matches[1]) ? intval($matches[1]) : 0;
    
    if ($size < 50) {
        echo "❌ ISSUE FOUND: currency_name column is too small\n";
        echo "   Current: VARCHAR({$size})\n";
        echo "   Required: VARCHAR(50)\n";
        echo "   Currency needs: " . strlen($currency->name) . " characters\n\n";
        echo "🔧 TO FIX:\n";
        echo "   Option 1: Run migration\n";
        echo "   php artisan migrate\n\n";
        echo "   Option 2: Run SQL file\n";
        echo "   mysql -u root -p your_database < fix-currency-name-column.sql\n\n";
        echo "   Option 3: Direct SQL\n";
        echo "   ALTER TABLE orders MODIFY COLUMN currency_name VARCHAR(50);\n\n";
    } else {
        echo "✅ Everything looks good!\n";
        echo "   Column size: VARCHAR({$size})\n";
        echo "   Currency length: " . strlen($currency->name) . " characters\n";
        echo "   Orders should work fine!\n\n";
    }
}

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
