<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserMasyarakat extends Authenticatable implements JWTSubject
{
    //
    use Notifiable;

    protected $table = "user_masyarakat";
    protected $guarded = [];
    protected $fillable = [
        'name', 'email', 'password', 'nik','no_telp', 'alamat',
    ];
    protected $hidden = [
        'password', 'kode_otp', 'remember_token',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
