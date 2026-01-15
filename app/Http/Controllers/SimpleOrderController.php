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

        try {
            // PERFORMANCE: Start database transaction for data integrity
            DB::beginTransaction();

            // Get cart from session
            $cart = Session::get('cart');

            if (!$cart) {
                return redirect()->back()->with('error', 'Your cart is empty');
            }

            // Get customer data from request
            $customerName = $request->input('customer_name', 'Guest Customer');
            $customerPhone = $request->input('customer_phone', '');
            $customerEmail = $request->input('customer_email', 'noemail@example.com');

            if (config('app.debug')) {
                file_put_contents($debugLog, "Customer: $customerName, Phone: $customerPhone\n", FILE_APPEND);
            }

            // Get cart data
            $cartData = $cart->items;
            $totalQty = $cart->totalQty;
            $subtotal = $cart->totalPrice;

            // Get costs from request
            $shippingCost = floatval($request->input('shipping_cost', 0));
            $packingCost = floatval($request->input('packing_cost', 0));
            $tax = floatval($request->input('tax', 0));
            $discount = floatval($request->input('coupon_discount', 0));

            // Calculate total
            $totalAmount = $subtotal + $shippingCost + $packingCost + $tax - $discount;

            if (config('app.debug')) {
                file_put_contents($debugLog, "Creating order...\n", FILE_APPEND);
            }

            // Create order in database
            $order = new Order();
            $order->order_number = 'ORD-' . time() . '-' . rand(1000, 9999);
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

            // Customer details
            $order->customer_name = $customerName;
            $order->customer_email = $customerEmail;
            $order->customer_phone = $customerPhone;
            $order->customer_country = $request->input('customer_country', '');
            $order->customer_address = $request->input('customer_address', '');
            $order->customer_city = $request->input('customer_city', '');
            $order->customer_zip = $request->input('customer_zip', '');
            $order->customer_state = $request->input('customer_state', '');

            // Shipping (same as customer for COD)
            $order->shipping_name = $customerName;
            $order->shipping_email = $customerEmail;
            $order->shipping_phone = $customerPhone;
            $order->shipping_country = $order->customer_country;
            $order->shipping_address = $order->customer_address;
            $order->shipping_city = $order->customer_city;
            $order->shipping_zip = $order->customer_zip;
            $order->shipping_state = $order->customer_state;

            // Other fields
            $order->order_note = $request->input('order_note', '');
            $order->coupon_code = null;
            $order->coupon_discount = 0;
            $order->currency_sign = $request->input('currency_sign', 'JD');
            $order->currency_name = $request->input('currency_name', 'Jordanian Dinar');
            $order->currency_value = $request->input('currency_value', 0.71);
            $order->shipping_cost = $request->input('shipping_cost', 0);
            $order->packing_cost = $request->input('packing_cost', 0);
            $order->tax = $request->input('tax', 0);
            $order->dp = $request->input('dp', 0);
            $order->wallet_price = $request->input('wallet_price', 0);

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

            // TEMPORARY FIX: Force redirect without AJAX detection
            $successUrl = route('order.success', ['order_number' => $order->order_number]);

            if (config('app.debug')) {
                file_put_contents($debugLog, "Success URL: $successUrl\n", FILE_APPEND);
            }

            // Force redirect using multiple methods
            return redirect()->away($successUrl)
                           ->with('success', 'Order placed successfully!')
                           ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                           ->header('Pragma', 'no-cache')
                           ->header('Expires', '0');
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

            // Return with more detailed error
            return redirect()->back()
                ->with('error', 'Failed to place order: ' . $e->getMessage())
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
