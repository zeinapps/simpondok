<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CacheModelTrait;

class MTingkat extends Model {

    use CacheModelTrait;
    
    public $table = 'm_tingkat';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'nama','keterangan'
    ];

    public function mapels_default()
    {
        return $this->belongsToMany('App\Models\Master\Mapel', 'm_tingkat_mapel', 'tingkat_id', 'mapel_id');
    }
    
    
    public function mapels()
    {
        return $this->belongsToMany('App\Models\Master\Mapel', 'tingkat_mapel', 'tingkat_id', 'mapel_id');
    }
}
