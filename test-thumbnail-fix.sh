#!/bin/bash

# Product Thumbnail Fix - Test Script
# This script verifies that the thumbnail fix is working correctly

echo "=========================================="
echo "Product Thumbnail Fix - Verification Test"
echo "=========================================="
echo ""

# Colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if directories exist
echo "1. Checking directory structure..."

if [ -d "public/assets/images/products" ]; then
    echo -e "${GREEN}✓${NC} Products directory exists"
else
    echo -e "${RED}✗${NC} Products directory missing"
    mkdir -p public/assets/images/products
    echo -e "${YELLOW}  Created products directory${NC}"
fi

if [ -d "public/assets/images/thumbnails" ]; then
    echo -e "${GREEN}✓${NC} Thumbnails directory exists"
else
    echo -e "${RED}✗${NC} Thumbnails directory missing"
    mkdir -p public/assets/images/thumbnails
    echo -e "${YELLOW}  Created thumbnails directory${NC}"
fi

echo ""

# Check directory permissions
echo "2. Checking directory permissions..."

PRODUCTS_PERM=$(stat -c "%a" public/assets/images/products 2>/dev/null || stat -f "%Lp" public/assets/images/products)
THUMBNAILS_PERM=$(stat -c "%a" public/assets/images/thumbnails 2>/dev/null || stat -f "%Lp" public/assets/images/thumbnails)

if [ "$PRODUCTS_PERM" = "755" ] || [ "$PRODUCTS_PERM" = "775" ] || [ "$PRODUCTS_PERM" = "777" ]; then
    echo -e "${GREEN}✓${NC} Products directory is writable ($PRODUCTS_PERM)"
else
    echo -e "${YELLOW}!${NC} Products directory permissions: $PRODUCTS_PERM (should be 755/775/777)"
fi

if [ "$THUMBNAILS_PERM" = "755" ] || [ "$THUMBNAILS_PERM" = "775" ] || [ "$THUMBNAILS_PERM" = "777" ]; then
    echo -e "${GREEN}✓${NC} Thumbnails directory is writable ($THUMBNAILS_PERM)"
else
    echo -e "${YELLOW}!${NC} Thumbnails directory permissions: $THUMBNAILS_PERM (should be 755/775/777)"
fi

echo ""

# Check if GD or Imagick is installed
echo "3. Checking image processing libraries..."

if php -m | grep -q "gd"; then
    echo -e "${GREEN}✓${NC} GD library is installed"
elif php -m | grep -q "imagick"; then
    echo -e "${GREEN}✓${NC} Imagick library is installed"
else
    echo -e "${RED}✗${NC} Neither GD nor Imagick is installed"
    echo -e "${YELLOW}  Install one of them: sudo apt-get install php-gd${NC}"
fi

echo ""

# Count existing products and thumbnails
echo "4. Checking existing files..."

PRODUCT_COUNT=$(find public/assets/images/products -type f -name "*.webp" -o -name "*.jpg" -o -name "*.png" 2>/dev/null | wc -l)
THUMBNAIL_COUNT=$(find public/assets/images/thumbnails -type f -name "*.webp" 2>/dev/null | wc -l)

echo "   Product images: $PRODUCT_COUNT"
echo "   Thumbnails: $THUMBNAIL_COUNT"

if [ "$THUMBNAIL_COUNT" -lt "$PRODUCT_COUNT" ]; then
    echo -e "${YELLOW}   Note: Some products may be missing thumbnails${NC}"
fi

echo ""

# Check recent log entries
echo "5. Checking recent logs for thumbnail creation..."

if [ -f "storage/logs/laravel.log" ]; then
    RECENT_THUMBNAILS=$(grep -c "Thumbnail created (WebP)" storage/logs/laravel.log 2>/dev/null || echo "0")
    echo "   Recent thumbnail creations logged: $RECENT_THUMBNAILS"
    
    # Show last 3 thumbnail creations
    if [ "$RECENT_THUMBNAILS" -gt "0" ]; then
        echo ""
        echo "   Last 3 thumbnail creations:"
        grep "Thumbnail created (WebP)" storage/logs/laravel.log | tail -3 | while read line; do
            echo -e "${GREEN}   ✓${NC} $line"
        done
    fi
else
    echo -e "${YELLOW}   Log file not found${NC}"
fi

echo ""
echo "=========================================="
echo "Test Complete!"
echo "=========================================="
echo ""
echo "To test the fix:"
echo "1. Go to Admin Panel → Products → Add New Product"
echo "2. Upload an image and fill required fields"
echo "3. Create the product"
echo "4. Check 'All Products' page - thumbnail should display"
echo "5. Run this script again to see new log entries"
echo ""
