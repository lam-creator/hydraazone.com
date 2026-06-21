<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total_amount', 'discount_amount', 'shipping', 'status', 'date', 'name', 'mobile', 'zone', 'address', 'order_note'];


    // public function items()
    // {
    //     return $this->hasMany(OrderItem::class);
    // }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'zone', 'id');
    }


}