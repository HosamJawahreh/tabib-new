# 🚀 Quick Server Setup for Tabib Project

## 🚨 Fixing 403 Forbidden Error

The **403 error** means your web server can't access the Laravel files. Here's how to fix it:

---

## ✅ Method 1: Automatic Fix (Recommended)

### On Your Server, run:

```bash
cd /path/to/tabib-new
bash fix-server.sh
```

This will automatically:
- Fix permissions on `storage` and `bootstrap/cache`
- Create `.env` file if missing
- Generate application key
- Create storage symlink
- Clear all caches
- Verify `.htaccess` exists

---

## ✅ Method 2: Manual Fix

### Step 1: Set Document Root

**⚠️ THIS IS THE MOST IMPORTANT STEP!**

Your web server **MUST** point to the `public` folder, not the root folder.

#### For cPanel:
1. Login to cPanel
2. Go to **Domains** (or **Addon Domains**)
3. Click **Manage** next to your domain
4. Change **Document Root** from:
   ```
   tabib-new  ❌ Wrong!
   ```
   To:
   ```
   tabib-new/public  ✅ Correct!
   ```
5. Click **Save**

#### For Apache Config:
```apache
DocumentRoot /var/www/html/tabib-new/public

<Directory /var/www/html/tabib-new/public>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
```

---

### Step 2: Fix File Permissions

Run these commands via SSH:

```bash
cd /path/to/tabib-new

# Fix storage permissions
chmod -R 755 storage
chmod -R 775 storage/framework
chmod -R 775 storage/logs

# Fix bootstrap cache
chmod -R 755 bootstrap/cache

# Set ownership (replace www-data with your server user)
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
```

**For cPanel servers:**
```bash
chown -R username:username storage
chown -R username:username bootstrap/cache
```

---

### Step 3: Create .env File

```bash
cd /path/to/tabib-new

# Copy .env.example to .env
cp .env.example .env

# Edit with your database details
nano .env
```

Update these lines in `.env`:
```env
DB_HOST=localhost
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

APP_URL=https://yourdomain.com
```

---

### Step 4: Run Laravel Commands

```bash
cd /path/to/tabib-new

# Generate application key
php artisan key:generate

# Create storage symlink
php artisan storage:link

# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Run migrations (if first time)
php artisan migrate
```

---

### Step 5: Verify Files Exist

Make sure these files exist:

```bash
cd /path/to/tabib-new/public

# Check .htaccess
ls -la .htaccess

# Check index.php
ls -la index.php
```

If `.htaccess` is missing, the `fix-server.sh` script will create it automatically.

---

## 🔍 Troubleshooting

### Still Getting 403?

1. **Check Apache Error Log:**
   ```bash
   tail -f /var/log/apache2/error.log
   ```
   
   Or in cPanel: **Metrics → Errors**

2. **Check Laravel Log:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

3. **Verify Document Root:**
   ```bash
   # Should show /path/to/tabib-new/public
   grep DocumentRoot /etc/apache2/sites-available/*.conf
   ```

4. **Check Permissions:**
   ```bash
   ls -la storage/
   ls -la bootstrap/cache/
   ```

5. **Restart Apache:**
   ```bash
   sudo systemctl restart apache2
   # Or
   sudo service apache2 restart
   ```

---

## 📁 Correct Directory Structure

Your server should see:

```
/home/username/tabib-new/              ← Project Root (NOT web accessible)
├── app/
├── bootstrap/
│   └── cache/                         ← Needs 755 permissions
├── config/
├── database/
├── public/                            ← THIS is your Document Root!
│   ├── .htaccess                     ✅ Must exist
│   ├── index.php                     ✅ Must exist
│   ├── assets/
│   └── storage/ → ../storage/app/public  ← Symlink
├── resources/
├── routes/
├── storage/                           ← Needs 755/775 permissions
│   ├── app/
│   ├── framework/
│   └── logs/
├── vendor/
├── .env                               ✅ Must exist
├── artisan
└── fix-server.sh                      ← Run this!
```

---

## ✅ Final Checklist

Before you say "it's working":

- [ ] Document Root points to `public` folder (MOST IMPORTANT!)
- [ ] `storage` folder has correct permissions (755 or 775)
- [ ] `bootstrap/cache` has correct permissions
- [ ] `.env` file exists with database credentials
- [ ] `php artisan storage:link` was executed
- [ ] `php artisan key:generate` was executed
- [ ] `public/.htaccess` file exists
- [ ] `public/index.php` file exists
- [ ] Apache/Nginx has been restarted
- [ ] Browser cache cleared

---

## 🎯 Quick Commands Reference

```bash
# Navigate to project
cd /path/to/tabib-new

# Run fix script
bash fix-server.sh

# Or manually:
chmod -R 755 storage bootstrap/cache
php artisan key:generate
php artisan storage:link
php artisan config:clear
php artisan cache:clear

# Restart Apache
sudo systemctl restart apache2
```

---

## 💡 Common Mistakes

1. **Document Root NOT pointing to public folder** ← Most common!
2. **Wrong file permissions on storage**
3. **Missing .env file**
4. **Missing application key (APP_KEY in .env)**
5. **Missing storage symlink**
6. **Apache mod_rewrite not enabled**

---

## 🆘 Still Need Help?

1. Check `SERVER-DEPLOYMENT-GUIDE.md` for detailed instructions
2. Run `bash fix-server.sh` and share the output
3. Check error logs in `storage/logs/laravel.log`

---

## 📝 After Deployment

Don't forget to:

1. **Update .env for production:**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   ```

2. **Optimize Laravel:**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

3. **Set up SSL certificate** (Let's Encrypt)

4. **Configure email settings** in `.env`

5. **Test the order system!**

---

**Good luck! 🚀**
