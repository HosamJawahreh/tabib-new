# Clear Cache on Live Server - Fix Cart Icon Facebook Pixel Issue

## Problem
Cart icon on homepage works locally but not on live server - Facebook Pixel events not firing.

## Solution: Clear All Caches

### Step 1: Clear Laravel Cache
Run these commands on your live server:

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Step 2: Clear Browser Cache (Force Refresh)

**On Desktop:**
- Chrome/Edge: Press `Ctrl + Shift + Delete` (Windows) or `Cmd + Shift + Delete` (Mac)
- Or press `Ctrl + F5` to hard refresh the page
- Or press `Shift + F5`

**On Mobile:**
- Go to browser settings
- Clear browsing data
- Select "Cached images and files"
- Clear data

### Step 3: Version Your JavaScript Files (Best Practice)

This prevents cache issues in the future. Edit `resources/views/layouts/front.blade.php`:

Find this line:
```blade
<script src="{{ asset('assets/front/js/product-card-custom.js') }}"></script>
```

Change it to:
```blade
<script src="{{ asset('assets/front/js/product-card-custom.js') }}?v={{ time() }}"></script>
```

Or use a version number:
```blade
<script src="{{ asset('assets/front/js/product-card-custom.js') }}?v=1.1"></script>
```

Then increment the version number (v=1.2, v=1.3, etc.) whenever you update the JavaScript file.

### Step 4: Check Facebook Pixel is Loaded

Open browser console (F12) on the live site homepage and check:

```javascript
// Check if fbq exists
console.log('fbq exists:', typeof fbq !== 'undefined');

// Check if FacebookPixelTracker exists
console.log('FacebookPixelTracker exists:', typeof FacebookPixelTracker !== 'undefined');

// Check if product data attributes exist on cart buttons
jQuery('.cart-icon-clean.add-cart').first().data();
```

### Step 5: Test Cart Button with Debugging

The updated `product-card-custom.js` now includes console.log debugging. Open browser console (F12) and click a cart icon. You should see:

```
Cart button clicked: {hasDataHref: true, productId: "123", ...}
Making AJAX request to: /product/cart/add/123
Cart response: [3, "45.00"]
Attempting Facebook Pixel tracking...
Using FacebookPixelTracker.trackAddToCart (or) Using direct fbq call
```

If you see errors, they will appear in red in the console.

### Step 6: Check Script Load Order

Make sure scripts are loaded in this order in `front.blade.php`:

1. jQuery
2. Facebook Pixel base code
3. `facebook-pixel-ecommerce.js`
4. `product-card-custom.js`

### Step 7: Verify on Live Server

After clearing caches:

1. Open homepage on live server
2. Open browser console (F12)
3. Click "Add to Cart" icon on any product
4. Check console for debug messages
5. Check Facebook Pixel Helper extension (if you have it)
6. Verify event fires in Facebook Events Manager

## What Changed in product-card-custom.js

✅ Added extensive console.log debugging
✅ Added fallback to direct `fbq()` call if FacebookPixelTracker is not available
✅ Added error handling with try-catch
✅ Added data validation checks
✅ More robust event firing

## Common Issues & Fixes

### Issue 1: "FacebookPixelTracker is not defined"
**Solution:** The script is trying to fire before Facebook Pixel loads.
- Make sure `facebook-pixel-ecommerce.js` loads BEFORE `product-card-custom.js`
- The code now has a fallback to direct `fbq()` call

### Issue 2: Events fire locally but not on live
**Solution:** Cache issue
- Clear Laravel cache (Step 1)
- Hard refresh browser (Ctrl + F5)
- Use cache busting (Step 3)

### Issue 3: Data attributes missing
**Solution:** Check the blade template
- View page source on live site
- Search for "cart-icon-clean add-cart"
- Verify it has: data-product-id, data-product-name, data-product-price

### Issue 4: AJAX request fails
**Solution:** Check routes and permissions
- Open Network tab in browser console
- Click cart icon
- See if request returns 200 OK or error

## Files Modified

1. `public/assets/front/js/product-card-custom.js` - Added debugging and fallback
2. `resources/views/partials/product/product-card-grid.blade.php` - Already has data attributes (lines 60-62)

## After Deploying

Remember to:
1. Upload the updated `product-card-custom.js` to live server
2. Clear all caches (Step 1)
3. Test with browser console open
4. Check Facebook Events Manager for the AddToCart events

---

**Note:** The debug console.log statements help identify where the issue is. Once everything works on live, you can optionally remove them or keep them for future debugging.
