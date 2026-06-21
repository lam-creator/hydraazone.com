<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'product_slug',
        'category_id',
        'unit_id',
        'image',
        'sale_price',
        'discount_price',
        'short_description',
        'long_description',
        'additional_info',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'status',
        'show_as',
        'user_id',
    ];

     // join query
     public function admin()
     {
         return $this->belongsTo('App\Models\Admin', 'user_id', 'id');
     }

    // join query
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    // join query
    public function unit()
    {
        return $this->belongsTo('App\Models\Unit', 'unit_id', 'id');
    }

}