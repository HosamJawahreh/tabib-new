#!/bin/bash

echo "==================================="
echo "Testing Infinite Scroll Category Fix"
echo "==================================="
echo ""

# Test 1: Homepage (no filters)
echo "Test 1: Homepage without filters"
echo "Expected: Should load ALL products"
curl -s "http://localhost/products/load?page=2" \
  -H "X-Requested-With: XMLHttpRequest" \
  | jq '{success: .success, has_more: .has_more, current_page: .current_page, total: .total, products_count: (.html | length)}'
echo ""

# Test 2: Category 170 filter
echo "Test 2: Category 170 (كولاجين& فيتامين)"
echo "Expected: Should return only products from category 170"
curl -s "http://localhost/products/filter?category_id=170&page=1" \
  -H "X-Requested-With: XMLHttpRequest" \
  | jq '{success: .success, has_more: .has_more, products_count: .products_count, total_count: .total_count}'
echo ""

# Test 3: Category 170 page 2 (should have no more)
echo "Test 3: Category 170 Page 2"
echo "Expected: has_more should be false (only 14 products, less than 24)"
curl -s "http://localhost/products/filter?category_id=170&page=2" \
  -H "X-Requested-With: XMLHttpRequest" \
  | jq '{success: .success, has_more: .has_more, products_count: .products_count, total_count: .total_count}'
echo ""

# Test 4: Subcategory 127 (should have multiple pages)
echo "Test 4: Subcategory 127"
echo "Expected: Should have has_more: true (423 products total)"
curl -s "http://localhost/products/filter?subcategory_id=127&page=1" \
  -H "X-Requested-With: XMLHttpRequest" \
  | jq '{success: .success, has_more: .has_more, products_count: .products_count, total_count: .total_count}'
echo ""

# Test 5: Subcategory 127 page 2
echo "Test 5: Subcategory 127 Page 2"
echo "Expected: Should still have products from subcategory 127 only"
curl -s "http://localhost/products/filter?subcategory_id=127&page=2" \
  -H "X-Requested-With: XMLHttpRequest" \
  | jq '{success: .success, has_more: .has_more, products_count: .products_count, total_count: .total_count}'
echo ""

# Test 6: Child category 130
echo "Test 6: Child Category 130"
echo "Expected: Should return 107 products from child category 130"
curl -s "http://localhost/products/filter?childcategory_id=130&page=1" \
  -H "X-Requested-With: XMLHttpRequest" \
  | jq '{success: .success, has_more: .has_more, products_count: .products_count, total_count: .total_count}'
echo ""

echo "==================================="
echo "Tests Complete!"
echo "==================================="
