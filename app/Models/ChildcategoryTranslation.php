<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChildcategoryTranslation extends Model
{
    protected $fillable = ['childcategory_id', 'lang_code', 'name'];

    protected $table = 'childcategory_translations';

    public function childcategory()
    {
        return $this->belongsTo('App\Models\Childcategory');
    }
}
