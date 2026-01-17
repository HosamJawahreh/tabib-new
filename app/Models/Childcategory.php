<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Childcategory extends Model
{
    protected $fillable = ['subcategory_id','name','slug'];
    public $timestamps = false;

    public function subcategory()
    {
    	return $this->belongsTo('App\Models\Subcategory')->withDefault();
    }

    public function products()
    {
        // Use the multi-category system by finding the corresponding main category
        // Childcategories are now mapped as main categories in the categories table
        $mainCategory = \App\Models\Category::where('name', $this->name)
            ->where('status', 1)
            ->first();

        if ($mainCategory) {
            // Return products through the category_product pivot table
            return $mainCategory->products();
        }

        // Fallback to empty relationship if no mapping found
        return $this->hasMany('App\Models\Product')->whereRaw('0=1');
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
        return $this->hasMany('App\Models\ChildcategoryTranslation', 'childcategory_id');
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
                ChildcategoryTranslation::updateOrCreate(
                    ['childcategory_id' => $this->id, 'lang_code' => $lang],
                    ['name' => $name]
                );
            }
        }
    }
}
