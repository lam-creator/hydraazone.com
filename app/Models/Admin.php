<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasRoles, HasFactory, Notifiable;

    protected $guard ="admin";
	protected $guard_name = 'admin'; // Critical for role/permission checks

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'image',
        'status',
        'user_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // join query
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin', 'user_id', 'id');
    }

}
