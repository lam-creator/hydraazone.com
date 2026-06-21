<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteSettings extends Model
{
    use HasFactory;

	protected $fillable = [
        'logo',
        'company_name',
        'company_slogan',
        'phone',
        'support_phone',
        'email',
        'company_address',
        'facebook_url',
        'twitter_url',
        'youtube_url',
        'instagram_url',
        'android_app_url',
        'ios_app_url',
        'copyright',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'user_id',
    ];

    // join query
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin', 'user_id', 'id');
    }

}
