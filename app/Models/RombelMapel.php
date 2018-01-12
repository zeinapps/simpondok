<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CacheModelTrait;

class RombelMapel extends Model {

    use CacheModelTrait;
    
    public $table = 'rombel_mapel';
    protected $primaryKey = 'id';
    protected $fillable = [
        'rombel_id', 
        'tingkat_mapel_id',
        'user_id',
    ];

}
