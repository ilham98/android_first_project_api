<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'npk', 'password', 'role_id', 'departemen_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';

    public function karyawan() {
        return $this->hasOne('App\SQLSRVKaryawan', 'npk', 'npk');
    }

    public function role() {
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }

    public function firebaseToken() {
        return $this->hasMany('App\FirebaseMessageServiceToken', 'user_id', 'id');
    }
}
