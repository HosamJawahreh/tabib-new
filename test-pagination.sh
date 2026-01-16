#!/bin/bash

# Test Products Pagination AJAX Endpoints
# This script tests if the pagination endpoints are working correctly

echo "======================================"
echo "Testing Products Pagination System"
echo "======================================"
echo ""

BASE_URL="http://127.0.0.1:8080"

# Test 1: Load More Products - Page 2
echo "Test 1: Loading page 2..."
response=$(curl -s -H "X-Requested-With: XMLHttpRequest" "${BASE_URL}/products/load-more?page=2")

if echo "$response" | grep -q '"has_more"'; then
    echo "✅ Load More endpoint working"
    echo "$response" | grep -o '"current_page":[0-9]*' | head -1
    echo "$response" | grep -o '"total":[0-9]*' | head -1
    echo "$response" | grep -o '"loaded":[0-9]*' | head -1
else
    echo "❌ Load More endpoint failed"
    echo "Response: $response"
fi

echo ""

# Test 2: Filter Products
echo "Test 2: Filter products by category..."
response=$(curl -s -H "X-Requested-With: XMLHttpRequest" "${BASE_URL}/products/filter?category_id=1")

if echo "$response" | grep -q '"success"'; then
    echo "✅ Filter endpoint working"
    echo "$response" | grep -o '"products_count":[0-9]*' | head -1
    echo "$response" | grep -o '"total_count":[0-9]*' | head -1
else
    echo "❌ Filter endpoint failed"
    echo "Response: $response"
fi

echo ""
echo "======================================"
echo "Testing Complete!"
echo "======================================"
echo ""
echo "Next steps:"
echo "1. Open http://127.0.0.1:8080 in your browser"
echo "2. Scroll down to see infinite loading"
echo "3. Click 'Load More Products' button"
echo "4. Check browser console for logs"
