<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CacheModelTrait;

class Rombel extends Model {

    use CacheModelTrait;
    
    public $table = 'rombel';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 
        'tingkat_id',
        'nama',
        'keterangan',
        'user_id',
        'tahun_id',
        'max_siswa',
    ];
    
    public function wali()
    {
        return $this->belongsTo(\App\User::class,'user_id');
    }
    
    public function siswa()
    {
        return $this->belongsToMany('App\Models\Siswa', 'rombel_siswa', 'rombel_id', 'siswa_id');
    }

}
