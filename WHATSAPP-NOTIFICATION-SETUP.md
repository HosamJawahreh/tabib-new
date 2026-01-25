# WhatsApp Order Notifications Setup Guide

## Overview
This system sends automatic WhatsApp notifications to a group/number when new orders are placed using the free CallMeBot API.

## Setup Instructions

### Step 1: Get CallMeBot API Key

1. **Add CallMeBot to your WhatsApp contacts:**
   - Save this number in your phone: `+34 644 33 34 34` (Primary)
   - Alternative number if first doesn't work: `+34 644 24 76 05`
   - Or click direct link: https://wa.me/34644333434?text=I%20allow%20callmebot%20to%20send%20me%20messages

2. **Get your API key:**
   - Send this message to CallMeBot: `I allow callmebot to send me messages`
   - You will receive your API key in the response within seconds
   - Save this API key securely

### Step 2: Configure Environment Variables

Add these lines to your `.env` file:

```env
# WhatsApp Notifications (CallMeBot API)
WHATSAPP_PHONE=962XXXXXXXXX  # Your phone number with country code (no + or spaces)
WHATSAPP_API_KEY=your_api_key_here  # API key from CallMeBot
```

**Phone Number Format Examples:**
- Jordan: `962791234567` (not +962 79 123 4567)
- Saudi Arabia: `966512345678`
- UAE: `971501234567`

### Step 3: Test the Connection

Create a test route in `routes/web.php`:

```php
Route::get('/test-whatsapp', function() {
    try {
        $service = new \App\Services\WhatsAppNotificationService();
        $result = $service->testConnection();
        return response()->json([
            'status' => 'success',
            'message' => 'Test message sent!',
            'details' => $result
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
})->middleware('auth'); // Add auth middleware for security
```

Then visit: `https://yourwebsite.com/test-whatsapp`

You should receive a test message on WhatsApp!

### Step 4: Send to WhatsApp Group (Optional)

To send notifications to a WhatsApp group instead of individual number:

1. Create a WhatsApp group for orders
2. Add your phone number to the group
3. Add CallMeBot number to the group: `+34 644 33 34 34`
4. Use your personal number in WHATSAPP_PHONE (the API will send to all groups you're both in)

## Message Format

### Arabic Message Example:
```
🛍️ طلب جديد - رقم #12345

👤 العميل: أحمد محمد
📱 الهاتف: 0791234567
📧 البريد: customer@example.com
📍 العنوان: عمان، الأردن

💰 الإجمالي: 50.00 دينار
💳 طريقة الدفع: الدفع عند الاستلام

📦 المنتجات:
• منتج 1 (x2) - 20.00 د.أ
• منتج 2 (x1) - 30.00 د.أ

🚚 الشحن: 5.00 د.أ
```

### English Message Example:
```
🛍️ New Order - #12345

👤 Customer: Ahmad Mohammad
📱 Phone: 0791234567
📧 Email: customer@example.com
📍 Address: Amman, Jordan

💰 Total: 50.00 JOD
💳 Payment: Cash on Delivery

📦 Products:
• Product 1 (x2) - 20.00 JOD
• Product 2 (x1) - 30.00 JOD

🚚 Shipping: 5.00 JOD
```

## Features

✅ **Completely Free** - No subscription or fees
✅ **Instant Notifications** - Get notified immediately when orders are placed
✅ **Bilingual Support** - Messages in Arabic and English
✅ **Full Order Details** - Customer info, products, totals, payment method
✅ **Fail-Safe** - If WhatsApp fails, orders still process normally
✅ **Group Support** - Send to multiple people via WhatsApp groups

## Troubleshooting

### "Failed to send message"
- Check your phone number format (no spaces, no +)
- Verify API key is correct
- Make sure CallMeBot is still in your contacts
- Check internet connection on server

### "Messages not arriving"
- Make sure you sent the activation message to CallMeBot
- Check if you blocked CallMeBot accidentally
- API key might have expired (request new one)

### "Empty cart items in message"
- This is normal if cart was already cleared
- Message will still show totals and customer info
- Cart items are shown when available

## API Limits

CallMeBot Free Tier:
- **Rate Limit:** Maximum 1 message per 10 seconds per number
- **Message Length:** Up to 2000 characters
- **Reliability:** Best effort delivery (not guaranteed)

For high-volume stores (100+ orders/hour), consider premium WhatsApp Business API.

## Files Modified

1. `app/Services/WhatsAppNotificationService.php` - New service class
2. `app/Http/Controllers/SimpleOrderController.php` - Added notification call
3. `.env` - Added WHATSAPP_PHONE and WHATSAPP_API_KEY

## Security Notes

⚠️ **Important:**
- Never commit `.env` file to git
- Keep API key private
- Add auth middleware to test route
- API key is tied to your phone number
- If API key is compromised, get a new one by messaging CallMeBot again

## Alternative Solutions

If CallMeBot doesn't meet your needs:

1. **WhatsApp Business API** (Official, expensive)
2. **Twilio WhatsApp** ($0.005 per message)
3. **WhatSender** (Free tier: 100 msgs/month)
4. **Telegram Bot** (Completely free, unlimited)

---

**Setup Complete!** 🎉

Your store will now send WhatsApp notifications for every new order.
