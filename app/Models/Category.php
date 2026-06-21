<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

	protected $fillable = [
        'name',
        'category_slug',
        'image',
        'icon',
        'show_in_homepage',
        'status',
        'user_id',
    ];

    // join query
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin', 'user_id', 'id');
    }

    // join query
    public function products()
    {
        return $this->hasMany(Product::class);
    }


}