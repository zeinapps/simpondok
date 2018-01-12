<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CacheModelTrait;

class MRombel extends Model {

    use CacheModelTrait;
    
    public $table = 'm_rombel';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'tingkat_id','nama','keterangan','max_siswa'
    ];

}
