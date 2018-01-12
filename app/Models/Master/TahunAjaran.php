<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CacheModelTrait;

class TahunAjaran extends Model {

    use CacheModelTrait;
    
    public $table = 'm_tahun_ajaran';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'nama','keterangan'
    ];

}
