<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class WhatsAppNotificationService
{
    /**
     * Send order notification to WhatsApp using CallMeBot API
     * 
     * CallMeBot is completely FREE and simple to use.
     * Setup instructions: https://www.callmebot.com/blog/free-api-whatsapp-messages/
     * 
     * SETUP STEPS:
     * 1. Save +34 644 44 84 40 in your phone contacts as "CallMeBot"
     * 2. Send this message to CallMeBot: "I allow callmebot to send me messages"
     * 3. You'll receive your API key
     * 4. Add to .env: WHATSAPP_PHONE=962XXXXXXXXX and WHATSAPP_API_KEY=your_key
     */
    public function sendOrderNotification(Order $order)
    {
        try {
            $phone = env('WHATSAPP_PHONE');
            $apiKey = env('WHATSAPP_API_KEY');

            // Check if WhatsApp is configured
            if (!$phone || !$apiKey) {
                Log::info('WhatsApp not configured. Skipping notification.');
                return false;
            }

            $message = $this->formatOrderMessage($order);
            
            // CallMeBot API endpoint
            $url = "https://api.callmebot.com/whatsapp.php";
            
            $response = Http::get($url, [
                'phone' => $phone,
                'text' => $message,
                'apikey' => $apiKey
            ]);

            if ($response->successful()) {
                Log::info("WhatsApp notification sent successfully for Order #{$order->order_number}");
                return true;
            } else {
                Log::error("WhatsApp notification failed: " . $response->body());
                return false;
            }

        } catch (\Exception $e) {
            Log::error("WhatsApp notification error: " . $e->getMessage());
            return false;
        }
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
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        foreach ($cart as $key => $item) {
            $message .= "• {$item['item']['name']} x{$item['qty']}\n";
        }
        
        $message .= "\n⏰ *الوقت:* " . $order->created_at->format('Y-m-d H:i') . "\n";
        $message .= "━━━━━━━━━━━━━━━\n";
        $message .= "✅ *تفاصيل كاملة:* " . route('admin-order-show', $order->id);
        
        return urlencode($message);
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
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        foreach ($cart as $key => $item) {
            $message .= "• {$item['item']['name']} x{$item['qty']}\n";
        }
        
        $message .= "\n⏰ *Time:* " . $order->created_at->format('Y-m-d H:i') . "\n";
        $message .= "━━━━━━━━━━━━━━━\n";
        $message .= "✅ *Full Details:* " . route('admin-order-show', $order->id);
        
        return urlencode($message);
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
