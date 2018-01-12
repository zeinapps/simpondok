<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CacheModelTrait;

class Mapel extends Model {

    use CacheModelTrait;
    
    public $table = 'm_mapel';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'kode','nama','keterangan'
    ];

}
