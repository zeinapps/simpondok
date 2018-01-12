<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CacheModelTrait;

class Siswa extends Model {

    use CacheModelTrait;
    
    public $table = 'siswa';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'nama', 'nomor_induk', 'foto'
    ];

}
