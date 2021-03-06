<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CacheModelTrait;

class Agama extends Model {

    use CacheModelTrait;
    
    public $table = 'm_agama';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'keterangan'
    ];

}
