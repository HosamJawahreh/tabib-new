#!/bin/bash

echo "=================================================="
echo "🔧 Laravel Server Fix Script"
echo "=================================================="
echo ""

# Get the script directory
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

echo "📁 Project Directory: $SCRIPT_DIR"
echo ""

# Fix storage permissions
echo "1️⃣  Fixing storage folder permissions..."
chmod -R 755 "$SCRIPT_DIR/storage"
chmod -R 775 "$SCRIPT_DIR/storage/framework"
chmod -R 775 "$SCRIPT_DIR/storage/logs"
echo "   ✅ Storage permissions set"
echo ""

# Fix bootstrap/cache permissions
echo "2️⃣  Fixing bootstrap/cache permissions..."
chmod -R 755 "$SCRIPT_DIR/bootstrap/cache"
echo "   ✅ Bootstrap cache permissions set"
echo ""

# Check if .env exists
echo "3️⃣  Checking .env file..."
if [ ! -f "$SCRIPT_DIR/.env" ]; then
    echo "   ⚠️  .env file not found!"
    if [ -f "$SCRIPT_DIR/.env.example" ]; then
        echo "   📝 Copying from .env.example..."
        cp "$SCRIPT_DIR/.env.example" "$SCRIPT_DIR/.env"
        echo "   ✅ .env file created"
        echo "   ⚠️  Don't forget to update database credentials in .env"
    else
        echo "   ❌ .env.example also not found!"
    fi
else
    echo "   ✅ .env file exists"
fi
echo ""

# Generate app key if needed
echo "4️⃣  Checking application key..."
if grep -q "APP_KEY=$" "$SCRIPT_DIR/.env" 2>/dev/null || ! grep -q "APP_KEY=" "$SCRIPT_DIR/.env" 2>/dev/null; then
    echo "   🔑 Generating application key..."
    php "$SCRIPT_DIR/artisan" key:generate
    echo "   ✅ Application key generated"
else
    echo "   ✅ Application key already set"
fi
echo ""

# Create storage symlink
echo "5️⃣  Creating storage symlink..."
if [ -L "$SCRIPT_DIR/public/storage" ]; then
    echo "   ✅ Storage symlink already exists"
else
    php "$SCRIPT_DIR/artisan" storage:link
    echo "   ✅ Storage symlink created"
fi
echo ""

# Clear all caches
echo "6️⃣  Clearing Laravel caches..."
php "$SCRIPT_DIR/artisan" config:clear
php "$SCRIPT_DIR/artisan" cache:clear
php "$SCRIPT_DIR/artisan" route:clear
php "$SCRIPT_DIR/artisan" view:clear
echo "   ✅ All caches cleared"
echo ""

# Check public/.htaccess
echo "7️⃣  Checking .htaccess file..."
if [ -f "$SCRIPT_DIR/public/.htaccess" ]; then
    echo "   ✅ public/.htaccess exists"
else
    echo "   ❌ public/.htaccess is MISSING!"
    echo "   📝 Creating default .htaccess..."
    cat > "$SCRIPT_DIR/public/.htaccess" << 'EOF'
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
EOF
    echo "   ✅ .htaccess created"
fi
echo ""

# Check public/index.php
echo "8️⃣  Checking index.php file..."
if [ -f "$SCRIPT_DIR/public/index.php" ]; then
    echo "   ✅ public/index.php exists"
else
    echo "   ❌ public/index.php is MISSING!"
fi
echo ""

echo "=================================================="
echo "✅ Fix Script Completed!"
echo "=================================================="
echo ""
echo "⚠️  IMPORTANT NEXT STEPS:"
echo ""
echo "1. Make sure your web server Document Root points to:"
echo "   $SCRIPT_DIR/public"
echo ""
echo "2. Update .env file with your database credentials:"
echo "   DB_DATABASE=your_database_name"
echo "   DB_USERNAME=your_database_user"
echo "   DB_PASSWORD=your_database_password"
echo ""
echo "3. If using cPanel:"
echo "   - Go to Domains → Manage"
echo "   - Set Document Root to: public"
echo "   - Save changes"
echo ""
echo "4. Run database migrations:"
echo "   php artisan migrate"
echo ""
echo "5. Clear browser cache and try again"
echo ""
echo "=================================================="
