<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

class WhatsAppNotificationService
{
    /**
     * Generate WhatsApp notification link using wa.me
     * 
     * This is 100% FREE - no API, no limits, no registration needed!
     * Creates a clickable link that opens WhatsApp with pre-filled message.
     * 
     * SETUP STEPS:
     * 1. Add to .env:
     *    WHATSAPP_PHONE=962791234567 (group admin or your WhatsApp number with country code)
     *    Or for WhatsApp Group:
     *    WHATSAPP_GROUP_ID=962XXXXXXXXX-1234567890 (group ID format)
     * 
     * 2. The system will generate a clickable link for each order
     * 3. Click the link to send notification to WhatsApp
     * 
     * How to get Group ID:
     * 1. Export your WhatsApp group chat
     * 2. Or use a bot to get the group ID
     * 3. Format: countrycode+number-timestamp (e.g., 962791234567-1234567890)
     */
    public function sendOrderNotification(Order $order)
    {
        try {
            // Generate WhatsApp link
            $link = $this->generateWhatsAppLink($order);
            
            if ($link) {
                Log::info("Order #{$order->order_number} WhatsApp notification link generated: {$link}");
                // Return the link so it can be used for auto-redirect or stored
                return $link;
            } else {
                Log::warning("WhatsApp link could not be generated - check WHATSAPP_PHONE or WHATSAPP_GROUP_ID in .env");
                return false;
            }

        } catch (\Exception $e) {
            Log::error("WhatsApp notification error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Generate WhatsApp wa.me link for an order
     * This can be used in admin panel or emails
     */
    public function generateWhatsAppLink(Order $order)
    {
        $phone = env('WHATSAPP_PHONE');
        $groupId = env('WHATSAPP_GROUP_ID');

        // Use group ID if available, otherwise use phone number
        $recipient = $groupId ?: $phone;

        if (!$recipient) {
            return null;
        }

        $message = $this->formatOrderMessage($order);
        $encodedMessage = urlencode($message);

        // Generate wa.me link
        // For individual: https://wa.me/962791234567?text=message
        // For group: https://wa.me/962791234567-1234567890?text=message
        return "https://wa.me/{$recipient}?text={$encodedMessage}";
    }

    /**
     * Format order details into WhatsApp message
     */
    private function formatOrderMessage(Order $order)
    {
        // Use Arabic or English based on your preference
        $isArabic = true; // Set to false for English

        if ($isArabic) {
            return $this->formatArabicMessage($order);
        } else {
            return $this->formatEnglishMessage($order);
        }
    }

    /**
     * Format message in Arabic
     */
    private function formatArabicMessage(Order $order)
    {
        $message = "🛒 *طلب جديد!*\n";
        $message .= "━━━━━━━━━━━━━━━\n\n";
        
        $message .= "📋 *رقم الطلب:* {$order->order_number}\n";
        $message .= "👤 *العميل:* {$order->customer_name}\n";
        $message .= "📱 *الهاتف:* {$order->customer_phone}\n";
        $message .= "📧 *البريد:* {$order->customer_email}\n\n";
        
        $message .= "💰 *المبلغ الإجمالي:* {$order->pay_amount} {$order->currency_sign}\n";
        $message .= "🚚 *الشحن:* {$order->shipping_cost} {$order->currency_sign}\n";
        $message .= "📦 *التغليف:* {$order->packing_cost} {$order->currency_sign}\n\n";
        
        $message .= "💳 *طريقة الدفع:* " . ($order->method == 'Cash On Delivery' ? 'الدفع عند الاستلام' : $order->method) . "\n";
        $message .= "📍 *طريقة الشحن:* " . ($order->shipping == 'pickup' ? 'استلام من المتجر' : 'توصيل للمنزل') . "\n\n";
        
        if ($order->shipping == 'shipto') {
            $message .= "🏠 *العنوان:*\n";
            $message .= "{$order->customer_address}\n";
            $message .= "{$order->customer_city}, {$order->customer_zip}\n\n";
        }
        
        $message .= "📦 *المنتجات:*\n";
        
        // Cart is stored as JSON string
        $cart = json_decode($order->cart, true);
        
        if (is_array($cart)) {
            $totalItems = 0;
            foreach ($cart as $key => $item) {
                $itemName = $item['item']['name'] ?? 'Unknown Product';
                $itemQty = $item['qty'] ?? 1;
                $itemPrice = isset($item['price']) ? $item['price'] : 0;
                $itemTotal = $itemPrice * $itemQty;
                
                $message .= "━━━━━━━━━━━━━━━\n";
                $message .= "*{$itemName}*\n";
                $message .= "   الكمية: {$itemQty} قطعة\n";
                $message .= "   السعر: {$itemPrice} {$order->currency_sign}\n";
                $message .= "   المجموع: {$itemTotal} {$order->currency_sign}\n";
                
                $totalItems += $itemQty;
            }
            $message .= "━━━━━━━━━━━━━━━\n";
            $message .= "📊 *إجمالي القطع:* {$totalItems}\n";
        } else {
            $message .= "• [Error loading products]\n";
        }
        
        $message .= "\n⏰ *وقت الطلب:* " . $order->created_at->format('Y-m-d H:i') . "\n";
        $message .= "\n━━━━━━━━━━━━━━━\n";
        $message .= "🔗 *رابط مباشر للطلب:*\n" . route('admin-order-show', $order->id);
        
        return $message; // Return plain message, will be encoded in generateWhatsAppLink
    }

    /**
     * Format message in English
     */
    private function formatEnglishMessage(Order $order)
    {
        $message = "🛒 *New Order Received!*\n";
        $message .= "━━━━━━━━━━━━━━━\n\n";
        
        $message .= "📋 *Order #:* {$order->order_number}\n";
        $message .= "👤 *Customer:* {$order->customer_name}\n";
        $message .= "📱 *Phone:* {$order->customer_phone}\n";
        $message .= "📧 *Email:* {$order->customer_email}\n\n";
        
        $message .= "💰 *Total Amount:* {$order->pay_amount} {$order->currency_sign}\n";
        $message .= "🚚 *Shipping:* {$order->shipping_cost} {$order->currency_sign}\n";
        $message .= "📦 *Packing:* {$order->packing_cost} {$order->currency_sign}\n\n";
        
        $message .= "💳 *Payment:* {$order->method}\n";
        $message .= "📍 *Shipping:* " . ($order->shipping == 'pickup' ? 'Pickup' : 'Delivery') . "\n\n";
        
        if ($order->shipping == 'shipto') {
            $message .= "🏠 *Address:*\n";
            $message .= "{$order->customer_address}\n";
            $message .= "{$order->customer_city}, {$order->customer_zip}\n\n";
        }
        
        $message .= "📦 *Products:*\n";
        
        // Cart is stored as JSON string
        $cart = json_decode($order->cart, true);
        
        if (is_array($cart)) {
            $totalItems = 0;
            foreach ($cart as $key => $item) {
                $itemName = $item['item']['name'] ?? 'Unknown Product';
                $itemQty = $item['qty'] ?? 1;
                $itemPrice = isset($item['price']) ? $item['price'] : 0;
                $itemTotal = $itemPrice * $itemQty;
                
                $message .= "━━━━━━━━━━━━━━━\n";
                $message .= "*{$itemName}*\n";
                $message .= "   Quantity: {$itemQty} pcs\n";
                $message .= "   Price: {$itemPrice} {$order->currency_sign}\n";
                $message .= "   Subtotal: {$itemTotal} {$order->currency_sign}\n";
                
                $totalItems += $itemQty;
            }
            $message .= "━━━━━━━━━━━━━━━\n";
            $message .= "📊 *Total Items:* {$totalItems}\n";
        } else {
            $message .= "• [Error loading products]\n";
        }
        
        $message .= "\n⏰ *Order Time:* " . $order->created_at->format('Y-m-d H:i') . "\n";
        $message .= "\n━━━━━━━━━━━━━━━\n";
        $message .= "🔗 *Direct Order Link:*\n" . route('admin-order-show', $order->id);
        
        return $message; // Return plain message, will be encoded in generateWhatsAppLink
    }

    /**
     * Test WhatsApp connection
     */
    public function testConnection()
    {
        try {
            $phone = env('WHATSAPP_PHONE');
            $apiKey = env('WHATSAPP_API_KEY');

            if (!$phone || !$apiKey) {
                return [
                    'success' => false,
                    'message' => 'WhatsApp credentials not configured in .env file'
                ];
            }

            $message = urlencode("✅ WhatsApp notifications are working correctly!\nTest message from Tabib Store");
            
            $url = "https://api.callmebot.com/whatsapp.php";
            
            $response = Http::get($url, [
                'phone' => $phone,
                'text' => $message,
                'apikey' => $apiKey
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'Test message sent successfully!'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to send message: ' . $response->body()
                ];
            }

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }
}
