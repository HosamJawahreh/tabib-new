<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubcategoryTranslation extends Model
{
    protected $fillable = ['subcategory_id', 'lang_code', 'name'];

    protected $table = 'subcategory_translations';

    public function subcategory()
    {
        return $this->belongsTo('App\Models\Subcategory');
    }
}
