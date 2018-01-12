<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CacheModelTrait;

class MTingkatMapel extends Model {

    use CacheModelTrait;
    
    public $table = 'm_tingkat_mapel';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'tingkat_id','mapel_id'
    ];

}
