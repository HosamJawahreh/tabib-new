# COMPLETE FIX: Orders User Sidebar and Permissions

## Issues Found

1. ✅ **"Site Settings" visible for all users** - FIXED
2. ⚠️ **"Default Background" (inside Vendors section) visible** - Needs role update
3. ✅ **Dashboard redirect logic** - UPDATED

## Solutions Applied

### 1. Site Settings - Hidden for Non-Admin Users
**File**: `resources/views/partials/admin-role/normal.blade.php`

Wrapped the entire "Site Settings" section with admin-only check:

```blade
@if(Auth::guard('admin')->user()->role_id == 0)
<li>
    <a href="#siteSettings"...>
        Site Settings
    </a>
    ...
</li>
@endif
```

**Result**: Site Settings now only visible to super admin (role_id == 0)

### 2. Dashboard Redirect Logic - Updated
**File**: `app/Http/Controllers/Admin/DashboardController.php`

Changed redirect logic to only redirect when accessing dashboard directly:

```php
public function index()
{
    // Redirect orders@tabib-jo.com user directly to orders page
    if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->email === 'orders@tabib-jo.com') {
        // If coming from dashboard link, redirect to orders
        if(request()->is('admin') || request()->is('admin/dashboard')) {
            return redirect()->route('admin-orders-all');
        }
    }
    // ... rest of code
}
```

**Result**: 
- ✅ Dashboard link in sidebar → Redirects to Orders page
- ✅ Dashboard analytics/stats → Stays on dashboard (if accessed directly)

### 3. Default Background Issue - Requires Role Update

**Problem**: The "Default Background" link is visible because the user's role (ID: 17 - Moderator) has `vendors` permission.

**Current Role Sections**:
```
orders , products , customers , vendors , categories , blog , messages , home_page_settings , payment_settings , social_settings , language_settings , seo_tools , subscribers
```

**Required Action**: Update the role to remove unwanted permissions.

## ACTION REQUIRED: Update Role Permissions

Run this command to update the role for orders-only user:

```php
php artisan tinker
```

```php
// Option 1: Update existing Moderator role (ID: 17) to have only orders and products
DB::table('roles')->where('id', 17)->update([
    'section' => 'orders , products'
]);

// OR

// Option 2: Create a new "Orders Only" role
DB::table('roles')->insert([
    'name' => 'Orders Manager',
    'section' => 'orders , products',
    'created_at' => now(),
    'updated_at' => now()
]);
// Then update the admin user to use this new role
```

### Create orders@tabib-jo.com User

If the user doesn't exist yet:

```php
php artisan tinker
```

```php
DB::table('admins')->insert([
    'name' => 'Orders Manager',
    'email' => 'orders@tabib-jo.com',
    'password' => Hash::make('your_secure_password_here'),
    'role_id' => 17,  // or use the new role ID from Option 2 above
    'created_at' => now(),
    'updated_at' => now()
]);
```

## Expected Final Result

After updating the role permissions, the orders@tabib-jo.com user will see ONLY:

### Sidebar Items:
- **Dashboard** (redirects to Orders when clicked)
- **Orders** ✅
- **Products** ✅

### Hidden Items:
- ❌ Categories
- ❌ Brands  
- ❌ Customers
- ❌ Vendors (including "Default Background")
- ❌ Messages
- ❌ Blog
- ❌ General Settings
- ❌ Home Page Settings
- ❌ Site Settings
- ❌ Social Settings
- ❌ Language Settings
- ❌ SEO Tools
- ❌ Subscribers

## Verification Steps

1. Update the role permissions (run the SQL above)
2. Login as orders@tabib-jo.com
3. Check sidebar - should only see Dashboard, Orders, Products
4. Click Dashboard link - should redirect to Orders page
5. Try accessing `/admin` directly - should show dashboard stats (if you don't want the redirect)

## Files Modified

1. ✅ `resources/views/partials/admin-role/normal.blade.php` - Added admin-only check for Site Settings
2. ✅ `app/Http/Controllers/Admin/DashboardController.php` - Updated redirect logic for dashboard

---
**Date**: January 27, 2026
**Status**: ✅ Code Fixed - Awaiting Role Permission Update
