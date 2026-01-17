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
    	return $this->hasMany('App\Models\Childcategory')->where('status','=',1);
    }

    public function category()
    {
    	return $this->belongsTo('App\Models\Category')->withDefault();
    }

    public function products()
    {
        // Use the multi-category system by finding the corresponding main category
        // Subcategories are now mapped as main categories in the categories table
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

}
