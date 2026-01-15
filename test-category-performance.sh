#!/bin/bash

# ============================================================================
# CATEGORY FILTER PERFORMANCE TEST SCRIPT
# ============================================================================
# This script tests the performance of category filtering
# Run BEFORE and AFTER optimization to see improvements
# ============================================================================

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🧪 CATEGORY FILTER PERFORMANCE TEST"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

# Check if curl is installed
if ! command -v curl &> /dev/null; then
    echo "❌ curl is not installed. Please install it first."
    exit 1
fi

# Get site URL
read -p "Enter your site URL (e.g., https://new.tabib-jo.com): " SITE_URL

if [ -z "$SITE_URL" ]; then
    echo "❌ Site URL is required"
    exit 1
fi

echo ""
echo "🎯 Testing filter performance on: $SITE_URL"
echo ""

# Test 1: Filter by Category
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "Test 1: Filter by Category (category_id=1)"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
START=$(date +%s.%N)
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" \
    -H "X-Requested-With: XMLHttpRequest" \
    "$SITE_URL/products/filter?category_id=1")
END=$(date +%s.%N)
DIFF=$(echo "$END - $START" | bc)

echo "HTTP Status: $HTTP_CODE"
echo "Time taken: ${DIFF}s"

if (( $(echo "$DIFF < 0.5" | bc -l) )); then
    echo "✅ EXCELLENT! (< 500ms)"
elif (( $(echo "$DIFF < 1.0" | bc -l) )); then
    echo "✅ GOOD! (< 1s)"
elif (( $(echo "$DIFF < 2.0" | bc -l) )); then
    echo "⚠️  OK (< 2s) - Could be better"
else
    echo "❌ SLOW! (> 2s) - Needs optimization"
fi
echo ""

# Test 2: Filter by Subcategory
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "Test 2: Filter by Subcategory"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
START=$(date +%s.%N)
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" \
    -H "X-Requested-With: XMLHttpRequest" \
    "$SITE_URL/products/filter?category_id=1&subcategory_id=1")
END=$(date +%s.%N)
DIFF=$(echo "$END - $START" | bc)

echo "HTTP Status: $HTTP_CODE"
echo "Time taken: ${DIFF}s"

if (( $(echo "$DIFF < 0.5" | bc -l) )); then
    echo "✅ EXCELLENT! (< 500ms)"
elif (( $(echo "$DIFF < 1.0" | bc -l) )); then
    echo "✅ GOOD! (< 1s)"
elif (( $(echo "$DIFF < 2.0" | bc -l) )); then
    echo "⚠️  OK (< 2s) - Could be better"
else
    echo "❌ SLOW! (> 2s) - Needs optimization"
fi
echo ""

# Test 3: Repeat request (should be cached)
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "Test 3: Repeat Request (Should be FAST from cache)"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
START=$(date +%s.%N)
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" \
    -H "X-Requested-With: XMLHttpRequest" \
    "$SITE_URL/products/filter?category_id=1")
END=$(date +%s.%N)
DIFF=$(echo "$END - $START" | bc)

echo "HTTP Status: $HTTP_CODE"
echo "Time taken: ${DIFF}s"

if (( $(echo "$DIFF < 0.3" | bc -l) )); then
    echo "✅ EXCELLENT! Cached response!"
elif (( $(echo "$DIFF < 0.5" | bc -l) )); then
    echo "✅ GOOD!"
else
    echo "⚠️  Caching might not be working"
fi
echo ""

# Summary
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "📊 PERFORMANCE SUMMARY"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""
echo "Expected performance after optimization:"
echo "  • First request: < 500ms ✅"
echo "  • Cached request: < 100ms ✅"
echo "  • HTTP Status: 200 ✅"
echo ""
echo "If you see times > 1 second:"
echo "  1. Run: optimize-category-filters.sql in phpMyAdmin"
echo "  2. Replace filterProducts() method in FrontendController"
echo "  3. Clear cache: php artisan cache:clear"
echo "  4. Run this test again"
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
