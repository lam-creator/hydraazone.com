<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trust extends Model
{
    //
    use HasFactory;

	protected $fillable = [
        'title',
        'slogan',
        'image',
        'status',
        'user_id',
    ];

    // join query
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin', 'user_id', 'id');
    }

}
