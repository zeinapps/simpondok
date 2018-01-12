<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\ApilibUserTrait;
use App\Traits\CacheModelTrait;

class User extends Authenticatable
{
    use Notifiable, ApilibUserTrait, CacheModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
        'telp',
        'alamat', 
        'tempat_lahir', 
        'tanggal_lahir',
        'tahun_masuk',
        'riwayat_pelatihan',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function roles()
    {
        return $this->belongsToMany(\App\Models\Role::class);
    }
}
