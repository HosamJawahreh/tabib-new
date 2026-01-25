<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Category extends Model
{
    protected $fillable = ['name','slug','photo','image','is_featured','status','parent_id','sort_order'];
    public $timestamps = false;

    // Legacy method for backward compatibility - now points to children
    public function subs()
    {
    	return $this->children();
    }

    // New parent_id based relationship - children categories
    public function children()
    {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id')->where('status','=',1)->orderBy('sort_order', 'desc');
    }

    // Legacy typo relationship for backward compatibility (childs -> children)
    public function childs()
    {
        return $this->children();
    }

    // Get parent category
    public function parent()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id', 'id');
    }

    // Multi-category relationship (many-to-many)
    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'category_product', 'category_id', 'product_id');
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_replace(' ', '-', $value);
    }

    public function attributes() {
        return $this->morphMany('App\Models\Attribute', 'attributable');
    }

    // ========================================
    // Translation Relationships
    // ========================================

    public function translations()
    {
        return $this->hasMany('App\Models\CategoryTranslation', 'category_id');
    }

    public function translation($lang = null)
    {
        if (!$lang) {
            $lang = App::getLocale();
        }

        // Map custom language codes to database lang_code format
        $langMap = [
            '1684403411sQWZMppH' => 'en', // English language code from your system
            '1662525873Kynbiefk' => 'ar', // Arabic language code from your system
            'en' => 'en',
            'ar' => 'ar',
        ];

        $dbLangCode = $langMap[$lang] ?? 'ar'; // Default to Arabic

        $translation = $this->translations()->where('lang_code', $dbLangCode)->first();

        // Fallback to name if no translation found
        return $translation ? $translation->name : $this->name;
    }

    // Get Arabic name
    public function getNameArAttribute()
    {
        $translation = $this->translations()->where('lang_code', 'ar')->first();
        return $translation ? $translation->name : $this->name;
    }

    // Get English name
    public function getNameEnAttribute()
    {
        $translation = $this->translations()->where('lang_code', 'en')->first();
        return $translation ? $translation->name : $this->name;
    }

    // Get translated name based on current locale
    public function getTranslatedNameAttribute()
    {
        return $this->translation();
    }

    // Save translations
    public function saveTranslations($translations)
    {
        foreach ($translations as $lang => $name) {
            if (!empty($name)) {
                CategoryTranslation::updateOrCreate(
                    ['category_id' => $this->id, 'lang_code' => $lang],
                    ['name' => $name]
                );
            }
        }
    }

    // Get total products count including all subcategories and child categories
    public function getTotalProductsCountAttribute()
    {
        $count = $this->products()->count();
        
        // Add products from all children recursively (parent_id structure)
        foreach ($this->children as $child) {
            $count += $child->getTotalProductsCountAttribute();
        }
        
        return $count;
    }

    // Check if category can be deleted (no products in this category or any descendants)
    public function canBeDeleted()
    {
        // Check if this category has products
        if ($this->products()->count() > 0) {
            return false;
        }
        
        // Check if any children have products (recursive)
        foreach ($this->children as $child) {
            if (!$child->canBeDeleted()) {
                return false;
            }
        }
        
        return true;
    }

    // Get products count for this category only (used in tree view)
    public function getProductsCount()
    {
        return $this->products()->count();
    }
}
