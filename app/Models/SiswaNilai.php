<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CacheModelTrait;

class SiswaNilai extends Model {

    use CacheModelTrait;
    
    public $table = 'siswa_nilai';
    protected $primaryKey = 'id';
    protected $fillable = [
        'siswa_id', 
        'tingkat_mapel_id',
        'nilai',
    ];

}
