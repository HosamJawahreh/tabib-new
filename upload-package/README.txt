📦 UPLOAD PACKAGE - Critical Files Only
==========================================

These are the CRITICAL files that are missing on your server.
Upload these via cPanel File Manager or FTP.

FILES IN THIS PACKAGE:
----------------------
1. artisan              - Laravel command line tool (CRITICAL!)
2. htaccess-root        - Root .htaccess file (rename to .htaccess after upload)
3. fix-server.sh        - Server fix script

UPLOAD INSTRUCTIONS:
--------------------

METHOD 1: Using cPanel File Manager
1. Login to cPanel
2. Go to File Manager
3. Navigate to: domains/new.tabib-jo.com/public_html
4. Click "Upload" button
5. Upload ALL files from this folder
6. After upload, rename "htaccess-root" to ".htaccess"
7. Right-click on "artisan" → Change Permissions → Set to 755
8. Right-click on "fix-server.sh" → Change Permissions → Set to 755

METHOD 2: Using FTP (FileZilla/WinSCP)
1. Connect to your server via FTP
2. Navigate to: /home/tabibjoc/domains/new.tabib-jo.com/public_html
3. Upload ALL files from this folder
4. Rename "htaccess-root" to ".htaccess"
5. Set permissions:
   - artisan: 755 (rwxr-xr-x)
   - fix-server.sh: 755 (rwxr-xr-x)
   - .htaccess: 644 (rw-r--r--)

AFTER UPLOAD:
-------------
SSH into server and run:

cd ~/domains/new.tabib-jo.com/public_html
chmod +x artisan
chmod +x fix-server.sh
bash fix-server.sh

Then test:
php artisan --version

If that works, run:
php artisan key:generate
php artisan storage:link
php artisan config:clear
php artisan cache:clear

TROUBLESHOOTING:
----------------
If you still get "Resource temporarily unavailable":

1. Wait 5-10 minutes for server processes to clear
2. Try uploading files via cPanel File Manager (not FTP)
3. Contact your hosting provider to temporarily increase limits
4. Or just manually set permissions in cPanel:
   - File Manager → Navigate to files
   - Right-click → Change Permissions
   - storage: 755
   - bootstrap/cache: 755
   - artisan: 755

DOCUMENT ROOT:
--------------
Don't forget to set Document Root to:
domains/new.tabib-jo.com/public_html/public

In cPanel:
Domains → Manage → Document Root → public

==========================================
Questions? Check FIX-SERVER-RESOURCE-ERROR.md
