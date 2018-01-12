<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CacheModelTrait;

class Sarpras extends Model {

    use CacheModelTrait;
    
    public $table = 'm_sarpras';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id','nama','keterangan'
    ];

}
