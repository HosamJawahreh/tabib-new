# 🚨 Fix: Resource Temporarily Unavailable Error

## Problem
You're getting this error on your server:
```
fatal: unable to create threaded lstat: Resource temporarily unavailable
bash: fork: retry: Resource temporarily unavailable
```

This means your server is **out of resources** (memory or process limits).

---

## ✅ Solution 1: Kill Unnecessary Processes (Quickest)

Run these commands on your server:

```bash
# Check current processes
ps aux | grep tabibjoc | wc -l

# Kill hung processes (be careful!)
killall -u tabibjoc -9

# Wait 30 seconds
sleep 30

# Try git pull again
cd ~/domains/new.tabib-jo.com/public_html
git pull origin main
```

---

## ✅ Solution 2: Download & Upload (Safest)

Since git pull isn't working, manually download and upload:

### On Your Local Machine:

```bash
cd /home/hjawahreh/Desktop/Projects/file

# Create a clean archive without .git folder
tar -czf tabib-new-latest.tar.gz \
  --exclude='.git' \
  --exclude='node_modules' \
  --exclude='vendor' \
  --exclude='storage/logs/*' \
  --exclude='storage/framework/sessions/*' \
  --exclude='storage/framework/cache/*' \
  .

echo "✅ Archive created: tabib-new-latest.tar.gz"
```

### Upload to Server:

1. Upload `tabib-new-latest.tar.gz` via FTP/cPanel File Manager
2. Extract on server:

```bash
cd ~/domains/new.tabib-jo.com
tar -xzf tabib-new-latest.tar.gz -C public_html
cd public_html
composer install --no-dev --optimize-autoloader
```

---

## ✅ Solution 3: Use ZIP Instead of Git (Alternative)

### Create ZIP locally:

```bash
cd /home/hjawahreh/Desktop/Projects/file

# Create zip excluding git
zip -r tabib-new-latest.zip . \
  -x "*.git*" \
  -x "node_modules/*" \
  -x "vendor/*" \
  -x "storage/logs/*" \
  -x "storage/framework/cache/*" \
  -x "storage/framework/sessions/*"
```

### Then upload and extract on server.

---

## ✅ Solution 4: Clear Server Cache & Retry

```bash
# SSH into server
cd ~/domains/new.tabib-jo.com/public_html

# Remove git lock if exists
rm -f .git/index.lock
rm -f .git/HEAD.lock

# Clean git
git gc --prune=now

# Reset to clean state
git reset --hard HEAD

# Try pull again
git pull origin main
```

---

## ✅ Solution 5: Contact Hosting Provider

If none of the above works:

1. **Contact LiteSpeed/Your Host Support**
2. Tell them: "I'm hitting process/memory limits, need increase"
3. Ask for:
   - Increased process limits (NPROC)
   - Increased memory (VMEM/PMEM)
   - Or temporary boost to complete deployment

---

## ✅ Solution 6: Use SFTP/FTP Upload (Recommended for Now)

Since git is having issues:

### Using FileZilla or WinSCP:

1. **Backup current files on server first**
   ```bash
   cd ~/domains/new.tabib-jo.com
   tar -czf backup-$(date +%Y%m%d).tar.gz public_html
   ```

2. **Upload ONLY these important files via FTP:**
   - `.htaccess` (root)
   - `artisan`
   - `fix-server.sh`
   - `public/.htaccess`
   - Any changed files in `app/`, `routes/`, `resources/`

3. **Then run on server:**
   ```bash
   cd ~/domains/new.tabib-jo.com/public_html
   chmod +x artisan
   chmod +x fix-server.sh
   bash fix-server.sh
   ```

---

## 🎯 Quick Commands to Try First

Run these in order on your server:

```bash
# 1. Go to project
cd ~/domains/new.tabib-jo.com/public_html

# 2. Check if artisan exists
ls -la artisan

# 3. If NOT, create it manually:
cat > artisan << 'ARTISAN_EOF'
#!/usr/bin/env php
<?php
define('LARAVEL_START', microtime(true));
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$status = $kernel->handle(
    $input = new Symfony\Component\Console\Input\ArgvInput,
    new Symfony\Component\Console\Output\ConsoleOutput
);
$kernel->terminate($input, $status);
exit($status);
ARTISAN_EOF

# 4. Make executable
chmod +x artisan

# 5. Test
php artisan --version

# 6. Run fixes
php artisan key:generate
php artisan storage:link
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# 7. Fix permissions
chmod -R 755 storage bootstrap/cache
```

---

## ⚠️ Important: Document Root Must Still Point to public/

Even after uploading files, make sure:

**cPanel → Domains → Manage → Document Root:**
```
new.tabib-jo.com/public_html/public
```

NOT:
```
new.tabib-jo.com/public_html  ❌
```

---

## 📝 After You Can Access Server Again

1. Check what's eating resources:
   ```bash
   top
   # Press 'q' to quit
   ```

2. Check disk space:
   ```bash
   df -h
   ```

3. Check memory:
   ```bash
   free -m
   ```

4. Check process limit:
   ```bash
   ulimit -a
   ```

---

## 🚀 Fastest Solution Right Now

**DO THIS:**

1. **On your local machine**, create the files you need:
   ```bash
   cd /home/hjawahreh/Desktop/Projects/file
   
   # Copy these specific files to a folder for upload:
   mkdir ~/upload-to-server
   cp artisan ~/upload-to-server/
   cp .htaccess ~/upload-to-server/
   cp fix-server.sh ~/upload-to-server/
   cp -r app ~/upload-to-server/
   cp -r routes ~/upload-to-server/
   cp -r resources ~/upload-to-server/
   ```

2. **Upload that folder** via cPanel File Manager or FTP

3. **Move files** on server:
   ```bash
   cd ~/domains/new.tabib-jo.com/public_html
   mv ~/upload-to-server/* .
   chmod +x artisan fix-server.sh
   bash fix-server.sh
   ```

That's it! No git needed when server is struggling.

---

## 🆘 Last Resort

If NOTHING works and you can't SSH:

1. Use **cPanel File Manager**
2. **Upload each file manually**
3. **Edit .htaccess via File Manager** if needed
4. **Set permissions via File Manager** (right-click → Change Permissions)
   - `storage`: 755
   - `bootstrap/cache`: 755
   - `artisan`: 755

---

## 📞 Need Help?

The main issue is **server resource limits**. This is common on shared hosting.

Your options:
1. ✅ Upload files manually (FASTEST)
2. ✅ Contact hosting to increase limits
3. ✅ Upgrade hosting plan
4. ✅ Use dedicated/VPS hosting

The project is fine - it's just the server struggling with git operations.
