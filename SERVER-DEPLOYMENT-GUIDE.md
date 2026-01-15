# Laravel Server Deployment Guide - Fix 403 Error

## 🚨 Problem: 403 Forbidden Error

This happens when the web server cannot access your Laravel files properly.

---

## ✅ Solution 1: Set Correct Document Root

### For Apache/cPanel:
Your **Document Root** must point to the `public` folder:

```
/home/username/tabib-new/public
```

NOT to:
```
/home/username/tabib-new  ❌ Wrong!
```

### How to change in cPanel:
1. Go to **Domains** or **Addon Domains**
2. Click **Manage** next to your domain
3. Set **Document Root** to: `public`
4. Save changes

---

## ✅ Solution 2: Set Correct File Permissions

Run these commands via SSH or Terminal:

```bash
cd /path/to/your/project

# Set folder permissions
sudo chmod -R 755 storage bootstrap/cache

# Set ownership (replace www-data with your server user)
sudo chown -R www-data:www-data storage
sudo chown -R www-data:www-data bootstrap/cache

# For cPanel servers (usually nobody or your username)
sudo chown -R nobody:nobody storage
sudo chown -R nobody:nobody bootstrap/cache
```

### Quick Permission Fix:
```bash
cd /path/to/your/project
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

---

## ✅ Solution 3: Create Storage Symlink

Laravel needs a symlink from `public/storage` to `storage/app/public`:

```bash
cd /path/to/your/project
php artisan storage:link
```

---

## ✅ Solution 4: Verify .htaccess File

Make sure `public/.htaccess` exists with this content:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

---

## ✅ Solution 5: Check Apache Configuration

Make sure Apache has `AllowOverride All` for your directory:

```apache
<Directory /path/to/your/project/public>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
```

---

## ✅ Solution 6: Environment File

Make sure `.env` file exists and has correct permissions:

```bash
cd /path/to/your/project

# Check if .env exists
ls -la .env

# If not, copy from example
cp .env.example .env

# Set permissions
chmod 644 .env

# Generate app key if needed
php artisan key:generate
```

---

## ✅ Solution 7: Clear Laravel Cache

```bash
cd /path/to/your/project

php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

## 📁 Correct Directory Structure

Your server should see:

```
/home/username/tabib-new/          ← Project root (NOT accessible via web)
├── app/
├── bootstrap/
├── config/
├── database/
├── public/                          ← Document root (web accessible)
│   ├── .htaccess                   ✅ Must exist!
│   ├── index.php                   ✅ Must exist!
│   ├── assets/
│   └── storage/                    ← Symlink to storage/app/public
├── resources/
├── routes/
├── storage/
│   ├── app/
│   ├── framework/
│   └── logs/
├── vendor/
├── .env                            ✅ Must exist!
└── artisan
```

---

## 🔍 Troubleshooting Steps

### 1. Check Document Root:
```bash
# View Apache config
cat /etc/apache2/sites-available/your-site.conf | grep DocumentRoot
```

### 2. Check Permissions:
```bash
ls -la storage/
ls -la bootstrap/cache/
```

### 3. Check .env:
```bash
cat .env | grep APP_
```

### 4. Check Apache Error Log:
```bash
tail -f /var/log/apache2/error.log
```

Or in cPanel: **Metrics → Errors**

---

## 🚀 Quick Fix Script

Create this file: `fix-permissions.sh`

```bash
#!/bin/bash

echo "🔧 Fixing Laravel Permissions..."

# Navigate to project
cd /path/to/your/project

# Set folder permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Set storage permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Create storage symlink
php artisan storage:link

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo "✅ Permissions fixed!"
echo ""
echo "⚠️  IMPORTANT: Set Document Root to /public folder"
```

Then run:
```bash
chmod +x fix-permissions.sh
./fix-permissions.sh
```

---

## 📝 cPanel Specific Instructions

### Step 1: Upload Files
Upload your project to: `/home/username/tabib-new/`

### Step 2: Set Document Root
1. cPanel → **Domains**
2. Click **Manage** next to domain
3. Change Document Root to: `tabib-new/public`
4. Save

### Step 3: Fix Permissions
1. cPanel → **File Manager**
2. Navigate to `tabib-new`
3. Right-click `storage` folder → **Change Permissions**
4. Set to: `755` or `775`
5. Check **"Recurse into subdirectories"**
6. Repeat for `bootstrap/cache`

### Step 4: Set up .env
1. Rename `.env.example` to `.env`
2. Update database credentials:
   ```
   DB_HOST=localhost
   DB_DATABASE=your_db_name
   DB_USERNAME=your_db_user
   DB_PASSWORD=your_db_password
   ```

### Step 5: Run Commands (via SSH or Terminal in cPanel)
```bash
cd ~/tabib-new
php artisan key:generate
php artisan storage:link
php artisan migrate
php artisan config:clear
php artisan cache:clear
```

---

## ✅ Final Checklist

- [ ] Document Root points to `/public` folder
- [ ] `storage` folder has 755/775 permissions
- [ ] `bootstrap/cache` has 755/775 permissions
- [ ] `.env` file exists with correct database settings
- [ ] `php artisan storage:link` was run
- [ ] `public/.htaccess` file exists
- [ ] `public/index.php` file exists
- [ ] Apache mod_rewrite is enabled
- [ ] AllowOverride All is set

---

## 🆘 Still Getting 403?

### Check these:

1. **SELinux (CentOS/RHEL)**:
   ```bash
   sudo setenforce 0
   ```

2. **File Ownership**:
   ```bash
   sudo chown -R www-data:www-data /path/to/project
   # Or for cPanel:
   sudo chown -R username:username /path/to/project
   ```

3. **Apache User**:
   Find Apache user:
   ```bash
   ps aux | grep apache
   ```

4. **Check if mod_rewrite is enabled**:
   ```bash
   sudo a2enmod rewrite
   sudo systemctl restart apache2
   ```

---

## 📞 Need More Help?

Check Laravel logs:
```bash
tail -f storage/logs/laravel.log
```

Check Apache error logs:
```bash
tail -f /var/log/apache2/error.log
```

---

**After making changes, always clear cache:**
```bash
php artisan config:clear
php artisan cache:clear
```

**And restart Apache:**
```bash
sudo systemctl restart apache2
# Or in cPanel: Restart Apache via WHM
```
