# 🔧 Laravel Root .htaccess Solution

## ✅ Solution Created!

I've created a **`.htaccess`** file in your project root that redirects all requests to the `public/index.php` file.

---

## 📁 File Structure

```
/home/hjawahreh/Desktop/Projects/file/
├── .htaccess                    ← ROOT .htaccess (NEW!)
├── public/
│   ├── .htaccess               ← Public .htaccess (already exists)
│   ├── index.php               ← Laravel entry point
│   └── assets/
└── ... other Laravel files
```

---

## 🎯 What This Does

The root `.htaccess` file redirects all requests to `public/index.php`, so you can deploy without changing the Document Root.

### Root `.htaccess` Content:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]
    
    # Handle Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ public/index.php [L]
</IfModule>
```

**How it works:**
1. If the request is not a real directory or file
2. Redirect it to `public/index.php`
3. Laravel handles the routing from there

---

## 🚀 Deployment Options

### Option 1: Using Root .htaccess (What We Just Created)

**Pros:** 
- No need to change Document Root
- Works immediately after upload

**Cons:** 
- Slightly less secure (exposes root folder)
- Can cause conflicts with some server configs

**Steps:**
1. Upload entire project to server
2. Make sure `.htaccess` is in the root
3. Done! Visit your domain

---

### Option 2: Proper Document Root (Recommended for Production)

**Pros:** 
- More secure
- Better performance
- Laravel best practice

**Cons:** 
- Need access to server config

**Steps:**
1. Upload project to `/home/username/tabib-new/`
2. Set Document Root to `/home/username/tabib-new/public`
3. The `.htaccess` in `public/` handles everything

---

## 🔍 Testing

After uploading, test these URLs:

```
✅ https://yourdomain.com/          → Should show homepage
✅ https://yourdomain.com/login     → Should show login
✅ https://yourdomain.com/assets/   → Should load assets
❌ https://yourdomain.com/.env      → Should NOT be accessible
```

---

## ⚠️ Security Note

**Using root `.htaccess` exposes your project root directory.**

To secure it, add this to your root `.htaccess`:

```apache
# Deny access to sensitive files
<FilesMatch "^\.">
    Order allow,deny
    Deny from all
</FilesMatch>

<FilesMatch "(composer\.json|composer\.lock|package\.json|yarn\.lock|\.env|\.env\..*|artisan)$">
    Order allow,deny
    Deny from all
</FilesMatch>

# Deny access to directories
RedirectMatch 403 ^/\.(git|svn|hg|bzr)
RedirectMatch 403 ^/(app|bootstrap|config|database|resources|routes|storage|tests|vendor)/
```

---

## 🛠️ Alternative: Create index.php in Root

If `.htaccess` doesn't work, create `index.php` in root:

```php
<?php
// Root index.php - Redirect to public
header('Location: /public/index.php');
exit;
```

Or better:

```php
<?php
// Root index.php - Bootstrap Laravel from root
define('LARAVEL_START', microtime(true));

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);
```

---

## 📋 Complete Deployment Checklist

### Before Upload:
- [ ] `.htaccess` exists in root
- [ ] `public/.htaccess` exists
- [ ] `.env.example` renamed to `.env`
- [ ] Database credentials in `.env`

### After Upload:
- [ ] Run: `php artisan key:generate`
- [ ] Run: `php artisan storage:link`
- [ ] Run: `chmod -R 755 storage bootstrap/cache`
- [ ] Test URL loads homepage
- [ ] Test login works
- [ ] Test assets load correctly

---

## 🆘 Troubleshooting

### Still Getting 403?

1. **Check if mod_rewrite is enabled:**
   ```bash
   sudo a2enmod rewrite
   sudo systemctl restart apache2
   ```

2. **Check Apache AllowOverride:**
   ```apache
   <Directory /var/www/html>
       AllowOverride All
   </Directory>
   ```

3. **Check file permissions:**
   ```bash
   chmod 644 .htaccess
   chmod 644 public/.htaccess
   ```

### Getting 500 Error?

1. **Check Apache error log:**
   ```bash
   tail -f /var/log/apache2/error.log
   ```

2. **Check Laravel log:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

3. **Clear Laravel cache:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

### Assets Not Loading?

Add to root `.htaccess`:
```apache
# Allow access to assets
RewriteCond %{REQUEST_URI} ^/public/assets/
RewriteRule ^public/(.*)$ /$1 [L]
```

---

## 💡 Best Practice Recommendations

### For Development:
- Use root `.htaccess` (easier to set up)
- Keep `APP_DEBUG=true` in `.env`

### For Production:
- **Set Document Root to `public/`** (more secure)
- Set `APP_DEBUG=false` in `.env`
- Set `APP_ENV=production` in `.env`
- Enable cache:
  ```bash
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  ```

---

## 📞 Quick Reference Commands

```bash
# Fix permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Laravel setup
php artisan key:generate
php artisan storage:link
php artisan migrate

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Production optimization
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## ✅ Success Indicators

Your site is working correctly when:
- Homepage loads without errors
- Login/Register works
- Orders can be placed
- Images and CSS load properly
- No 403 or 500 errors

---

**Your `.htaccess` file is ready! Upload and test!** 🚀
