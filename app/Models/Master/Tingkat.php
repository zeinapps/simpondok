<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ApilibRoleTrait;
use App\Traits\CacheModelTrait;

class Tingkat extends Model {

    use ApilibRoleTrait,CacheModelTrait;
    
    public $table = 'm_tingkat';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'syarat','nama','keterangan'
    ];

}
