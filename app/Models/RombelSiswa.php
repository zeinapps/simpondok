<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CacheModelTrait;

class RombelSiswa extends Model {

    use CacheModelTrait;
    
    public $table = 'rombel_siswa';
    protected $fillable = [
        'rombel_id', 
        'siswa_id',
    ];

}
