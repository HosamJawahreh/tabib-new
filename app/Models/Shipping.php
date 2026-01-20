<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $fillable = ['user_id', 'title', 'title_ar', 'subtitle', 'price'];

    public $timestamps = false;

    // Get title based on current locale
    public function getLocalizedTitle()
    {
        $locale = app()->getLocale();
        if ($locale == 'ar' && !empty($this->title_ar)) {
            return $this->title_ar;
        }
        return $this->title;
    }
}
