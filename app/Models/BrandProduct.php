<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandProduct extends Model
{
    use HasFactory;

    protected $fillable = ['brand_id', 'name', 'name_en', 'image', 'price', 'status', 'sort_order'];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}
