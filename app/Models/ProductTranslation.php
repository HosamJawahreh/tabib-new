<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    protected $fillable = ['ec_products_id', 'lang_code', 'name', 'description', 'content'];

    protected $table = 'ec_products_translations';
    
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'ec_products_id');
    }
}
