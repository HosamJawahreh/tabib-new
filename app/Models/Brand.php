<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'status', 'sort_order'];

    public function products()
    {
        return $this->hasMany(BrandProduct::class, 'brand_id');
    }
}
