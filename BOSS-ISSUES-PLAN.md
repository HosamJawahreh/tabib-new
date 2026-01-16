# Boss Issues Report & Action Plan
**Date:** January 17, 2026

## Issues Translation & Priority

### 🔴 HIGH PRIORITY (Urgent - Affecting UX)

#### 1. **Header disappears when scrolling** ❌
**Arabic:** مافي Header وانا بنزل بالمنتجات لتحت
**Problem:** Header is set to `position: relative` (static), disappears when scrolling down
**Solution:** Make header sticky/fixed
**File:** `resources/views/partials/global/common-header.blade.php`
**Status:** NEEDS FIX

#### 2. **Cart modal shows half page on mobile** ❌
**Arabic:** لما اكبس على السلة (بالموبايل) بطلع نص الصفحة ما بتطلع كامله
**Problem:** Cart dropdown positioning issue on mobile
**Solution:** Already attempted to center it, may need mobile-specific height fix
**File:** `resources/views/partials/global/common-header.blade.php`
**Status:** PARTIALLY FIXED - needs mobile testing

#### 3. **Cannot delete products from cart** ❌
**Arabic:** بالسلة مابقدر احذف منتج لو مابدي ياه
**Problem:** Remove button not working in cart
**Solution:** Check cart remove functionality and AJAX
**File:** `resources/views/load/cart.blade.php`
**Status:** NEEDS FIX

#### 4. **Search not visible** ❌
**Arabic:** الـ Search لسا مش مبين
**Problem:** Search bar is hidden or not displaying
**Solution:** Check search bar visibility in header
**File:** `resources/views/partials/global/common-header.blade.php`
**Status:** NEEDS INVESTIGATION

---

### 🟡 MEDIUM PRIORITY (Data/Display Issues)

#### 5. **Product prices display backwards** ❌
**Arabic:** المنتج الي عليه عرض محطوط بالسعر الاصلي ومشطوب على السعر الي بعد الخصم
**Problem:** Sale products show original price with discounted price crossed out (should be opposite)
**Solution:** Fix price display logic
**File:** Product card templates
**Status:** NEEDS FIX

#### 6. **Related Products don't change** ❌
**Arabic:** الـ Related Products نفسهم ما بتغيررو مع كل منتج
**Problem:** Related products are static, not dynamic per product
**Solution:** Fix related products query/logic
**File:** Product controller/view
**Status:** NEEDS FIX

#### 7. **Product image zoom doesn't fit** ❌
**Arabic:** الصورة الي بتيجي تحت المنتج بتعمل zoom ما بتيجي fit
**Problem:** Product zoom image doesn't fit properly
**Solution:** Fix zoom CSS/JS
**File:** Product details page
**Status:** NEEDS FIX

---

### 🟢 LOW PRIORITY (Category/Organization Issues)

#### 8. **Categories are mixed up** ⚠️
**Arabic:** الكاتيكوريز مخربطين : في منتجات اغذية رياضيين موجودين في خالي سكر. بس بتعد ما تفوت ع المنتج مكتوب تحت مكانه الصح
**Problem:** Products appear in wrong category on listing, but show correct category on product page
**Solution:** Fix category filter/query logic
**File:** Product controller/filters
**Status:** DATABASE/LOGIC ISSUE

#### 9. **Products in 2 categories don't show both** ⚠️
**Arabic:** في منتجات بتكون موجودة في ٢ كتاجري مابطلع تحت انها موجوده في التنين
**Problem:** When product is in 2 categories, only shows 1
**Solution:** Display all categories for multi-category products
**File:** Product card template
**Status:** NEEDS FIX

---

## Implementation Order

### Phase 1: Critical UX Fixes (Today)
1. ✅ Make header sticky on scroll
2. ✅ Fix cart dropdown on mobile
3. ✅ Fix cart remove button functionality
4. ✅ Show search bar

### Phase 2: Display/Price Fixes (Tomorrow)
5. Fix sale price display (original crossed, sale price prominent)
6. Fix product image zoom fit
7. Fix related products to be dynamic

### Phase 3: Category/Data Fixes (Later)
8. Fix category filtering logic
9. Display all categories for products

---

## Files to Edit

### Priority Files:
- `resources/views/partials/global/common-header.blade.php` - Header sticky + search
- `resources/views/load/cart.blade.php` - Cart remove button
- `public/assets/front/css/*` - Cart mobile styling
- Product card templates - Price display
- Product detail page - Zoom fix
- Controllers - Related products, categories

