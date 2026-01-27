<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    protected $fillable = ['ec_products_id', 'lang_code', 'name', 'description', 'content'];

    protected $table = 'ec_products_translations';

    public $timestamps = false;

    // Composite primary key
    protected $primaryKey = ['lang_code', 'ec_products_id'];

    // This table doesn't have an auto-incrementing id
    public $incrementing = false;

    // Set key type as string for composite keys
    protected $keyType = 'string';

    /**
     * Override the setKeysForSaveQuery method to handle composite keys
     */
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

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'ec_products_id');
    }
}
