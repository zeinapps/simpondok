<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ApilibRoleTrait;
use App\Traits\CacheModelTrait;

class Kelas extends Model {

    use ApilibRoleTrait,CacheModelTrait;
    
    public $table = 'm_kelas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'tingkat_id','nama','keterangan'
    ];

}
