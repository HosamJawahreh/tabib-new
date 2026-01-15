# Order Submission Not Redirecting - Debug Guide

## 🚨 Problem:
Order submission stays on checkout page instead of redirecting to success page.

## 🔍 Debugging Steps:

### 1. Check if Order is Being Created

**Via SSH or phpMyAdmin:**
```sql
SELECT * FROM orders ORDER BY id DESC LIMIT 1;
```

If you see a new order with today's date, the submission is working but redirect is failing.

### 2. Check Laravel Logs

**Via SSH:**
```bash
tail -f storage/logs/laravel.log
```

Look for:
- "Order saved successfully"
- "Redirecting to success page"
- Any error messages

### 3. Check Order Debug Log

**Via SSH:**
```bash
tail -f storage/logs/order-debug.log
```

Should show:
- "Controller instantiated"
- "submitOrder() method called"
- "Order saved! Redirecting to success page"

### 4. Check Browser Console

**In Chrome DevTools (F12):**
- Go to Console tab
- Submit order
- Look for any JavaScript errors
- Check Network tab for the POST request

---

## ✅ Quick Fixes:

### Fix 1: Clear Cache
```bash
cd /home/tabibjoc/domains/new.tabib-jo.com/public_html
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### Fix 2: Check .env APP_URL
Make sure your `.env` has correct URL:
```env
APP_URL=https://new.tabib-jo.com
```

### Fix 3: Test the Route Manually

Visit directly:
```
https://new.tabib-jo.com/order-success/ORD-1234567890-1234
```

Replace with actual order number from database. If this loads, the route works.

---

## 🔧 Alternative: Add JavaScript Redirect

If backend redirect fails, add JavaScript fallback.

**Edit: `/resources/views/frontend/checkout.blade.php`**

Find this line (around line 1152):
```javascript
$('.checkoutform').on('submit',function(e){
```

Replace the entire handler with:
```javascript
$('.checkoutform').on('submit',function(e){
    console.log('Form submitting to:', $(this).attr('action'));
    
    // Validate required fields
    var name = $('input[name="customer_name"]').val();
    var phone = $('input[name="customer_phone"]').val();

    if(!name || name.trim() === '') {
        alert('Please enter your name');
        e.preventDefault();
        return false;
    }

    if(!phone || phone.trim() === '') {
        alert('Please enter your phone number');
        e.preventDefault();
        return false;
    }

    // Show loading
    $('#preloader').show();
    $('#place-order-btn').prop('disabled', true);
    
    // Submit via AJAX to ensure redirect works
    e.preventDefault();
    var formData = $(this).serialize();
    var formAction = $(this).attr('action');
    
    $.ajax({
        url: formAction,
        type: 'POST',
        data: formData,
        success: function(response) {
            // If response is HTML (redirect worked on backend)
            if(typeof response === 'string' && response.includes('<!DOCTYPE')) {
                window.location.reload();
            } else {
                // Redirect to success page
                window.location.href = '/order-success/' + response.order_number;
            }
        },
        error: function(xhr) {
            $('#preloader').hide();
            $('#place-order-btn').prop('disabled', false);
            
            if(xhr.status === 302 || xhr.status === 301) {
                // Redirect happened - follow it
                window.location.href = xhr.getResponseHeader('Location');
            } else {
                alert('Error: ' + (xhr.responseJSON?.message || 'Failed to submit order'));
            }
        }
    });
});
```

---

## 🎯 Most Likely Issues:

1. **Session/Cookie Issue**
   - Browser blocking cookies
   - Session driver misconfigured
   - Clear browser cookies for your site

2. **CSRF Token Issue**
   - Token expired
   - Token mismatch
   - Add `'submit-order-now'` to CSRF exceptions (already done)

3. **Middleware Blocking**
   - Check if any middleware is preventing redirect
   - Check routes/web.php middleware

4. **JavaScript Interference**
   - Check for console errors
   - Disable browser extensions
   - Try in incognito mode

---

## 📝 Modified Controller Response

I'll update the controller to return JSON on success, making debugging easier.

**File: `app/Http/Controllers/SimpleOrderController.php`**

Change the return line (around line 133) from:
```php
return redirect()->route('order.success', ['order_number' => $order->order_number])
               ->with('success', 'Order placed successfully!');
```

To:
```php
// Check if request wants JSON (for debugging)
if (request()->expectsJson() || request()->ajax()) {
    return response()->json([
        'success' => true,
        'order_number' => $order->order_number,
        'redirect_url' => route('order.success', ['order_number' => $order->order_number])
    ]);
}

// Normal redirect
return redirect()->route('order.success', ['order_number' => $order->order_number])
               ->with('success', 'Order placed successfully!');
```

---

## 🧪 Test Script

Create this file: `test-order-redirect.php`

```php
<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Get latest order
$order = App\Models\Order::latest()->first();

if ($order) {
    echo "Latest Order: " . $order->order_number . "\n";
    echo "Success URL: " . route('order.success', ['order_number' => $order->order_number]) . "\n";
    echo "\nTest this URL in your browser:\n";
    echo "https://new.tabib-jo.com/order-success/" . $order->order_number . "\n";
} else {
    echo "No orders found\n";
}
```

Run:
```bash
php test-order-redirect.php
```

---

## 🆘 Emergency Fix: Force Redirect with Meta Tag

Add this to the controller return if nothing else works:

```php
return response()->view('redirect-to-success', [
    'url' => route('order.success', ['order_number' => $order->order_number])
]);
```

Create: `resources/views/redirect-to-success.blade.php`
```html
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="0;url={{ $url }}">
    <script>window.location.href = "{{ $url }}";</script>
</head>
<body>
    <p>Redirecting to order confirmation...</p>
    <p>If not redirected, <a href="{{ $url }}">click here</a>.</p>
</body>
</html>
```

---

Follow these steps in order and let me know what you find!
