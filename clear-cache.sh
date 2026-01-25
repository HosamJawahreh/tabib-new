#!/bin/bash
echo "🧹 Clearing Laravel Cache..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
echo "✅ All caches cleared successfully!"
echo ""
echo "📝 Next steps:"
echo "1. Upload the updated product-card-custom.js to your live server"
echo "2. Run this script on your live server"
echo "3. Hard refresh your browser (Ctrl + F5)"
echo "4. Test the cart icon with browser console open (F12)"
