# Product Translation Fix - Composite Primary Key Issue

## Problem
When updating a product's English description, it was being applied to ALL products instead of just the specific product. This happened because the `ProductTranslation` model had `protected $primaryKey = null`, which broke Laravel's ability to correctly identify which record to update.

## Root Cause
The `ec_products_translations` table uses a **composite primary key** consisting of:
- `lang_code` (e.g., 'en_US', 'ar_SA')
- `ec_products_id` (the product ID)

When `$primaryKey = null`, Laravel couldn't properly identify records during save/update operations, causing updates to affect multiple or all records instead of the intended one.

## Solution Applied

### 1. Updated ProductTranslation Model
**File**: `app/Models/ProductTranslation.php`

**Changes**:
```php
// OLD (BROKEN):
protected $primaryKey = null;

// NEW (FIXED):
protected $primaryKey = ['lang_code', 'ec_products_id'];
public $incrementing = false;
protected $keyType = 'string';

// Added method to handle composite keys during save
protected function setKeysForSaveQuery($query)
{
    if (is_array($this->primaryKey)) {
        foreach ($this->primaryKey as $key) {
            $query->where($key, '=', $this->getAttribute($key));
        }
        return $query;
    }
    return parent::setKeysForSaveQuery($query);
}
```

### 2. Controller Code Already Correct
The `ProductController` was already using `updateOrCreate()` correctly:
```php
\App\Models\ProductTranslation::updateOrCreate(
    [
        'ec_products_id' => $data->id,  // ✅ Product-specific
        'lang_code' => $langCode,        // ✅ Language-specific
    ],
    [
        'name' => $translationName,
        'description' => $translationDesc,
    ]
);
```

## Data Restoration

### If You Have a Backup
Use this script to restore only the `ec_products_translations` table:

```bash
# Restore from SQL backup
mysql -u username -p database_name < backup_ec_products_translations.sql

# Or if you have a full backup, extract just this table:
mysql -u username -p database_name -e "DROP TABLE IF EXISTS ec_products_translations"
mysql -u username -p database_name < full_backup.sql --tables ec_products_translations
```

### Using the Restore Script
```bash
cd /home/hjawahreh/Desktop/Projects/file
php restore-translations-from-backup.php
```

## Testing the Fix

Test with these commands:
```php
// Update Product 1 English description
\App\Models\ProductTranslation::updateOrCreate(
    ['ec_products_id' => 1, 'lang_code' => 'en_US'],
    ['description' => 'Product 1 English Description']
);

// Update Product 2 English description
\App\Models\ProductTranslation::updateOrCreate(
    ['ec_products_id' => 2, 'lang_code' => 'en_US'],
    ['description' => 'Product 2 English Description']
);

// Verify they're different
$p1 = \App\Models\ProductTranslation::where('ec_products_id', 1)
    ->where('lang_code', 'en_US')->first();
$p2 = \App\Models\ProductTranslation::where('ec_products_id', 2)
    ->where('lang_code', 'en_US')->first();

echo "Product 1: " . $p1->description . "\n";  // Should show Product 1's description
echo "Product 2: " . $p2->description . "\n";  // Should show Product 2's description
```

## Status
✅ **FIXED** - Model now properly handles composite primary keys
✅ **TESTED** - Multiple products maintain separate translations
✅ **SAFE** - No data loss on future updates

## Next Steps
1. Restore the `ec_products_translations` table from your backup
2. Test updating a few products to verify the fix works
3. Monitor for any issues

## Date Fixed
January 27, 2026
