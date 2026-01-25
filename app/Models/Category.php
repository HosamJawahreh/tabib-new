<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Category extends Model
{
    protected $fillable = ['name','slug','photo','image','is_featured','status'];
    public $timestamps = false;

    public function subs()
    {
    	return $this->hasMany('App\Models\Subcategory')->where('status','=',1);
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
}
