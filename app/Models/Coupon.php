<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{

    protected $fillable = [
        'code',
        'discount',
        'is_active',
        'usage_limit',
        'used_count',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }


    public function isValid()
    {
        if (!$this->is_active) return false;

        if ($this->expires_at && now()->gt($this->expires_at)) return false;

        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) return false;

        return true;
    }


}
