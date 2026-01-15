# Fix: Order Submission Error - Currency Name Too Long

## 🚨 Error Message:
```
SQLSTATE[22001]: String data, right truncated: 1406 Data too long for column 'currency_name' at row 1
An error occurred. Please try again.
```

## 🔍 Root Cause:
1. The `currency_name` column in `orders` table is **VARCHAR(10)** - too small!
2. The default currency name "Joradainain Dinar" is **17 characters** long
3. Also has a typo: "Joradainain" should be "Jordanian"

---

## ✅ Solution 1: Run SQL Fix (FASTEST - Recommended)

### Via phpMyAdmin:
1. Login to phpMyAdmin
2. Select your database
3. Click **SQL** tab
4. Paste this SQL:

```sql
-- Fix currency_name column size
ALTER TABLE `orders` 
MODIFY COLUMN `currency_name` VARCHAR(50) DEFAULT NULL;

-- Fix the typo: Joradainain -> Jordanian
UPDATE `currencies` 
SET `name` = 'Jordanian Dinar' 
WHERE `name` = 'Joradainain Dinar';
```

5. Click **Go**
6. Done! ✅

---

## ✅ Solution 2: Import SQL File

Upload `fix-currency-name-column.sql` and run:

```bash
mysql -u username -p database_name < fix-currency-name-column.sql
```

Or via phpMyAdmin → Import → Choose file → Go

---

## ✅ Solution 3: Run Laravel Migration

On your server via SSH:

```bash
cd /home/tabibjoc/domains/new.tabib-jo.com/public_html

# Run the migration
php artisan migrate --path=database/migrations/2026_01_15_000002_fix_currency_name_column.php

# Clear cache
php artisan config:clear
php artisan cache:clear
```

---

## ✅ Verification

After applying the fix, verify:

```sql
-- Check column size
SHOW COLUMNS FROM orders LIKE 'currency_name';
-- Should show: varchar(50)

-- Check currency name
SELECT id, sign, name FROM currencies WHERE sign = 'JD';
-- Should show: Jordanian Dinar (not Joradainain)
```

---

## 🧪 Test Order Submission

1. Clear browser cache
2. Go to checkout page
3. Fill in customer details
4. Click "Place Order"
5. Should redirect to order success page ✅

---

## 📊 What Was Fixed:

### Before:
```
orders.currency_name: VARCHAR(10)  ❌ Too small!
Currency name: "Joradainain Dinar" (17 chars) ❌ Typo + Too long!
```

### After:
```
orders.currency_name: VARCHAR(50)  ✅ Plenty of space
Currency name: "Jordanian Dinar" (15 chars) ✅ Correct!
```

---

## 🎯 Summary

The order form was failing because:
1. Currency name was 17 characters: "**Joradainain** Dinar"
2. Database column only allowed 10 characters
3. This caused SQL error and prevented order creation

**Fix:** Increased column to VARCHAR(50) and corrected the typo.

---

## 📝 Files Created:

1. `fix-currency-name-column.sql` - SQL fix
2. `database/migrations/2026_01_15_000002_fix_currency_name_column.php` - Laravel migration
3. `FIX-CURRENCY-NAME-ERROR.md` - This guide

---

## 🆘 If Still Having Issues:

1. Clear all caches:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

2. Check Laravel logs:
   ```bash
   tail -f storage/logs/laravel.log
   ```

3. Verify the fix was applied:
   ```bash
   php -r "require 'vendor/autoload.php'; \$app = require_once 'bootstrap/app.php'; \$kernel = \$app->make(Illuminate\Contracts\Console\Kernel::class); \$kernel->bootstrap(); \$result = DB::select('SHOW COLUMNS FROM orders LIKE \"currency_name\"'); echo 'Column Type: ' . \$result[0]->Type . PHP_EOL;"
   ```

---

**After fixing, orders should work perfectly! ✅**
