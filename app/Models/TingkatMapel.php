<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CacheModelTrait;

class TingkatMapel extends Model {

    use CacheModelTrait;
    
    public $table = 'tingkat_mapel';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'tingkat_id','mapel_id','tahun_id'
    ];

}
