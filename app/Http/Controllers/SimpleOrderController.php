<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;

class SimpleOrderController extends Controller
{
    public function __construct()
    {
        // PERFORMANCE: Remove debug logging in production
        // Only enable when debugging specific issues
        if (config('app.debug')) {
            file_put_contents(storage_path('logs/order-debug.log'), date('Y-m-d H:i:s') . " - Controller instantiated\n", FILE_APPEND);
        }
    }

    public function submitOrder(Request $request)
    {
        // Define debug log path
        $debugLog = storage_path('logs/order-debug.log');

        // Log everything for debugging
        Log::info('=== ORDER SUBMISSION STARTED ===');
        Log::info('Request URL: ' . $request->fullUrl());
        Log::info('Request Method: ' . $request->method());
        Log::info('Request Data: ' . json_encode($request->all()));

        if (config('app.debug')) {
            file_put_contents($debugLog, "\n\n" . date('Y-m-d H:i:s') . " - NEW ORDER SUBMISSION\n", FILE_APPEND);
            file_put_contents($debugLog, "Request: " . json_encode($request->all()) . "\n", FILE_APPEND);
        }

        try {
            // PERFORMANCE: Start database transaction for data integrity
            DB::beginTransaction();

            // Get cart from session
            $cart = Session::get('cart');

            if (!$cart) {
                Log::warning('Cart is empty!');

                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'error' => 'Your cart is empty'
                    ], 400);
                }

                return redirect()->back()->with('error', 'Your cart is empty');
            }

            Log::info('Cart found: ' . $cart->totalQty . ' items, Total: ' . $cart->totalPrice);

            // Get customer data from request
            $customerName = $request->input('customer_name', 'Guest Customer');
            $customerPhone = $request->input('customer_phone', '');
            $customerEmail = $request->input('customer_email', 'noemail@example.com');
            $countryCode = $request->input('country_code', '+962');
            $deliveryDetails = $request->input('delivery_details', '');

            // Phone validation - must be at least 9 digits
            $phoneDigits = preg_replace('/\D/', '', $customerPhone);
            if (strlen($phoneDigits) < 9) {
                Log::warning('Phone validation failed: ' . $customerPhone);

                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'error' => 'Phone number must be at least 9 digits'
                    ], 400);
                }

                return redirect()->back()
                    ->with('error', 'Phone number must be at least 9 digits')
                    ->withInput();
            }

            // Combine country code with phone number for storage
            $fullPhone = $countryCode . ' ' . $customerPhone;

            Log::info('Customer Data: Name=' . $customerName . ', Email=' . $customerEmail . ', Phone=' . $fullPhone);

            if (config('app.debug')) {
                file_put_contents($debugLog, "Customer: $customerName, Phone: $fullPhone\n", FILE_APPEND);
            }

            // Get cart data
            $cartData = $cart->items;
            $totalQty = $cart->totalQty;
            $subtotal = $cart->totalPrice;

            Log::info('Cart Data: Items=' . count($cartData) . ', Qty=' . $totalQty . ', Subtotal=' . $subtotal);

            // Get costs from request
            $shippingCost = floatval($request->input('shipping_cost', 0));
            $packingCost = floatval($request->input('packing_cost', 0));
            $tax = floatval($request->input('tax', 0));
            $discount = floatval($request->input('coupon_discount', 0));

            // Calculate total
            $totalAmount = $subtotal + $shippingCost + $packingCost + $tax - $discount;

            Log::info('Calculated Total: ' . $totalAmount);

            if (config('app.debug')) {
                file_put_contents($debugLog, "Creating order...\n", FILE_APPEND);
            }

            // Create order in database
            $order = new Order();
            $order->order_number = 'ORD-' . time() . '-' . rand(1000, 9999);

            Log::info('Generated Order Number: ' . $order->order_number);
            $order->user_id = auth()->check() ? auth()->id() : null;
            $order->cart = json_encode($cartData);
            $order->method = $request->input('method', 'Cash on Delivery');
            $order->shipping = $request->input('shipping', 'shipto');
            $order->pickup_location = $request->input('pickup_location', null);
            $order->totalQty = $totalQty;
            $order->pay_amount = $totalAmount;
            $order->txnid = null;
            $order->charge_id = null;
            $order->payment_status = 'Pending';
            $order->status = 'pending';

            // Customer details - Ensure no NULL values for required fields
            $order->customer_name = $customerName;
            $order->customer_email = $customerEmail;
            $order->customer_phone = $fullPhone;
            $order->customer_country = $request->input('customer_country', 'Jordan');
            $order->customer_address = $deliveryDetails ?: $request->input('customer_address', 'N/A');
            $order->customer_city = $request->input('customer_city', 'N/A');
            $order->customer_zip = $request->input('customer_zip', '00000');
            $order->customer_state = $request->input('customer_state', 'N/A');

            // Shipping (same as customer for COD)
            $order->shipping_name = $customerName;
            $order->shipping_email = $customerEmail;
            $order->shipping_phone = $fullPhone;
            $order->shipping_country = $order->customer_country;
            $order->shipping_address = $order->customer_address;
            $order->shipping_city = $order->customer_city;
            $order->shipping_zip = $order->customer_zip;
            $order->shipping_state = $order->customer_state;

            // Other fields - Use the calculated values, not direct from request
            $order->order_note = $deliveryDetails ?: $request->input('order_note', '');
            $order->coupon_code = null;
            $order->coupon_discount = 0;
            $order->currency_sign = $request->input('currency_sign', 'JD');
            $order->currency_name = $request->input('currency_name', 'Jordanian Dinar');
            $order->currency_value = floatval($request->input('currency_value', 1)); // Changed to 1 - prices already in JD
            $order->shipping_cost = $shippingCost; // Use calculated value
            $order->packing_cost = $packingCost; // Use calculated value
            $order->tax = $tax; // Use calculated value (guaranteed to be float)
            $order->dp = intval($request->input('dp', 0));
            $order->wallet_price = floatval($request->input('wallet_price', 0));

            Log::info('Attempting to save order...');
            $order->save();
            Log::info('Order saved successfully! Order #: ' . $order->order_number);

            // Clear cart
            Session::forget('cart');
            Session::forget('cart_total');
            Session::forget('cart_count');
            Log::info('Cart cleared from session');

            // PERFORMANCE: Commit transaction
            DB::commit();

            if (config('app.debug')) {
                file_put_contents($debugLog, "Order saved! Redirecting to success page\n", FILE_APPEND);
            }

            Log::info('Redirecting to success page');

            // Generate success URL
            $successUrl = route('order.success', ['order_number' => $order->order_number]);

            if (config('app.debug')) {
                file_put_contents($debugLog, "Success URL: $successUrl\n", FILE_APPEND);
            }

            // Check if request expects JSON (AJAX)
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Order placed successfully!',
                    'redirect' => $successUrl,
                    'order_number' => $order->order_number
                ]);
            }

            // Regular form submission - redirect normally
            return redirect($successUrl)
                           ->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            // PERFORMANCE: Rollback transaction on error
            DB::rollBack();

            if (config('app.debug')) {
                file_put_contents($debugLog, "\n=== EXCEPTION CAUGHT ===\n", FILE_APPEND);
                file_put_contents($debugLog, "Error: " . $e->getMessage() . "\n", FILE_APPEND);
                file_put_contents($debugLog, "File: " . $e->getFile() . ":" . $e->getLine() . "\n", FILE_APPEND);
                file_put_contents($debugLog, "Trace: " . $e->getTraceAsString() . "\n", FILE_APPEND);
            }

            Log::error('=== ORDER SUBMISSION ERROR ===');
            Log::error('Error message: ' . $e->getMessage());
            Log::error('Error file: ' . $e->getFile() . ':' . $e->getLine());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            $errorMessage = 'Failed to place order: ' . $e->getMessage();

            // Check if request expects JSON (AJAX)
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'error' => $errorMessage
                ], 500);
            }

            // Regular form submission - redirect back with error
            return redirect()->back()
                ->with('error', $errorMessage)
                ->withInput();
        }
    }

    public function orderSuccess($order_number)
    {
        $order = Order::where('order_number', $order_number)->first();

        if (!$order) {
            return redirect('/')->with('error', 'Order not found');
        }

        // Decode cart to get items
        $order->cart_items = json_decode($order->cart, true);

        return view('order-success', compact('order'));
    }
}
