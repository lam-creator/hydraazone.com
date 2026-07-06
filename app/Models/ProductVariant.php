<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'type',
        'value',
        'price_adjustment',
        'stock',
        'sku',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
