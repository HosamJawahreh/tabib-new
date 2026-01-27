# Orders User Configuration Guide

## Overview
This guide documents how to configure an admin user (orders@tabib-jo.com) to have access only to Orders and Products, with Orders as their default landing page.

## Steps to Create Orders Admin User

### 1. Create the Admin User
Run this in the database or via tinker:

```sql
INSERT INTO admins (name, email, password, role_id, created_at, updated_at)
VALUES ('Orders Manager', 'orders@tabib-jo.com', '$2y$10$hashed_password_here', 17, NOW(), NOW());
```

Or use tinker:
```php
php artisan tinker

DB::table('admins')->insert([
    'name' => 'Orders Manager',
    'email' => 'orders@tabib-jo.com',
    'password' => Hash::make('your_secure_password'),
    'role_id' => 17, // Moderator role
    'created_at' => now(),
    'updated_at' => now()
]);
```

### 2. Configure Role Permissions
Update the role (ID: 17 - Moderator) to have only orders and products access:

```php
DB::table('roles')->where('id', 17)->update([
    'section' => 'orders , products'
]);
```

Or create a new role specifically for orders:

```php
DB::table('roles')->insert([
    'name' => 'Orders Only',
    'section' => 'orders , products',
    'created_at' => now(),
    'updated_at' => now()
]);
```

### 3. Auto-Redirect Configuration
The system is now configured to automatically redirect users with email `orders@tabib-jo.com` to the orders page when they access the dashboard.

**File**: `app/Http/Controllers/Admin/DashboardController.php`

```php
public function index()
{
    // Redirect orders@tabib-jo.com user directly to orders page
    if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->email === 'orders@tabib-jo.com') {
        return redirect()->route('admin-orders-all');
    }
    // ... rest of dashboard code
}
```

### 4. Sidebar Visibility
The sidebar automatically shows only the sections the user has permission for based on their role's `section` field.

For orders@tabib-jo.com user, only these will be visible:
- ✅ **Orders** (default landing page)
- ✅ **Products**

All other sections are automatically hidden by the permission system.

## How It Works

### Permission Check
In the sidebar (`resources/views/partials/admin-role/normal.blade.php`), each section is wrapped with:

```blade
@if(Auth::guard('admin')->user()->sectionCheck('orders'))
    <li>
        <a href="{{ route('admin-orders-all') }}">Orders</a>
    </li>
@endif
```

### Section Names Available
- `orders` - Orders management
- `products` - Product management
- `customers` - Customer management
- `categories` - Category management
- `blog` - Blog management
- `home_page_settings` - Homepage settings
- `menu_page_settings` - Menu/page settings
- `payment_settings` - Payment configuration
- `social_settings` - Social media settings
- `language_settings` - Language configuration
- `seo_tools` - SEO tools
- `subscribers` - Newsletter subscribers
- And more...

## Testing

1. **Create the orders@tabib-jo.com user** with the appropriate role
2. **Login** as orders@tabib-jo.com
3. **Expected behavior**:
   - Automatically redirected to `/admin/orders/all`
   - Sidebar shows only "Orders" and "Products"
   - Dashboard link redirects to orders page
   - No access to other admin sections

## Security Notes

- ✅ Permissions are enforced at controller level
- ✅ Sidebar visibility is role-based
- ✅ Auto-redirect prevents unauthorized dashboard access
- ✅ Role configuration stored in database

## Files Modified

1. **DashboardController.php** - Added auto-redirect for orders@tabib-jo.com
2. **normal.blade.php** - Fixed visible comment text `--}} END VENDOR SECTIONS --}}`

---
**Date**: January 27, 2026
**Status**: ✅ Configured and Ready
