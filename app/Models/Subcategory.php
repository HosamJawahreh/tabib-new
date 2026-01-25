<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Subcategory extends Model
{
    protected $fillable = ['category_id','name','slug'];
    public $timestamps = false;

    public function childs()
    {
    	return $this->hasMany('App\Models\Childcategory')->where('status','=',1)->orderBy('sort_order', 'desc');
    }

    public function category()
    {
    	return $this->belongsTo('App\Models\Category')->withDefault();
    }

    public function products()
    {
        // Subcategories are used directly in category_product table
        // The category_id in the pivot table can be a subcategory ID
        return $this->belongsToMany('App\Models\Product', 'category_product', 'category_id', 'product_id');
    }

    // Get products count - query directly from pivot table
    public function getProductsCount()
    {
        return $this->products()->count();
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
        return $this->hasMany('App\Models\SubcategoryTranslation', 'subcategory_id');
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
        return $translation ? $translation->name : $this->name;
    }

    public function getNameArAttribute()
    {
        $translation = $this->translations()->where('lang_code', 'ar')->first();
        return $translation ? $translation->name : $this->name;
    }

    public function getNameEnAttribute()
    {
        $translation = $this->translations()->where('lang_code', 'en')->first();
        return $translation ? $translation->name : $this->name;
    }

    public function getTranslatedNameAttribute()
    {
        return $this->translation();
    }

    public function saveTranslations($translations)
    {
        foreach ($translations as $lang => $name) {
            if (!empty($name)) {
                SubcategoryTranslation::updateOrCreate(
                    ['subcategory_id' => $this->id, 'lang_code' => $lang],
                    ['name' => $name]
                );
            }
        }
    }

    // Get total products count including all child categories
    public function getTotalProductsCountAttribute()
    {
        $count = $this->getProductsCount();
        
        // Add products from child categories
        foreach ($this->childs as $child) {
            $count += $child->getProductsCount();
        }
        
        return $count;
    }

    // Check if subcategory can be deleted (no products in this subcategory or any child categories)
    public function canBeDeleted()
    {
        // Check if this subcategory has products
        if ($this->getProductsCount() > 0) {
            return false;
        }
        
        // Check if any child categories have products
        foreach ($this->childs as $child) {
            if ($child->getProductsCount() > 0) {
                return false;
            }
        }
        
        return true;
    }

}
