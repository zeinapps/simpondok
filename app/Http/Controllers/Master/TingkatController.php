<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Traits\ControllerTrait;
use App\Models\Master\Tingkat;
use Alert;
use DB;


class TingkatController extends Controller{
    use ControllerTrait;
    public function index(Request $request){ 
        $tag = ['tingkat'];
        $key = '_list_tingkat';
        $s = '';
        if($request->s){
            $s = $request->s;
            $model = Tingkat::where('keterangan','like',"%$s%");
        }else{
            $model = new Tingkat();
        }
        $model = $model->leftJoin(DB::raw('(SELECT b.* FROM m_tingkat b ) c'), 'm_tingkat.syarat', '=', 'c.id');
        $model = $model->select('m_tingkat.*','c.nama as syarat_nama');
        $result = $this->paginateFromCache($tag, $model, $key);
        
        return view('master/tingkat/index', ['data' => $result, 's' => $s ]);
    }
    
    public function store(Request $request){ 
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            Alert::danger($validator->errors());
            return back()->withInput()->withErrors($validator);
        }
        
        try {
            if(!$request->id){
                $new_data = Tingkat::create($request->all());
            }else{
                $new_data = Tingkat::find($request->id);
                $new_data->update($request->all());
            }
            
        } catch (\Exception $e) {
            
            Alert::danger("Terjadi masalah pada database");
            
            
            return back()->withInput()->withErrors($e->getMessage());
        }
        $this->clearCache('tingkat');
        Alert::success('Add/Update Data berhasil');
        return redirect()->route('permission.tingkat.index');
        
    }
    
    public function edit($id){
        $tagCache = ['tingkat'];
        $key = '_get_all_tingkat';
        $tingkat[0] = "Tidak Ada";
        foreach ($this->getFromCache($tagCache, new Tingkat, $key) as $va) {
            $tingkat [$va->id] = $va->nama;
        }
        $query = Tingkat::find($id)->toArray();
        return view('master/tingkat/form', array_merge($query, ['tingkat_all' => $tingkat]));
    }
    
    public function add(){ 
        $tagCache = ['tingkat'];
        $key = '_get_all_tingkat';
        $tingkat[0] = "Tidak Ada";
        foreach ($this->getFromCache($tagCache, new Tingkat, $key) as $va) {
            $tingkat [$va->id] = $va->nama;
        }
        return view('master/tingkat/form',array_merge(['tingkat_all' => $tingkat], []));
    }
    
    public function delete($id){ 
        $role = Role::find($id);
        if($role){
            $role->delete();
            $this->clearCache($this->tagCache);
        }
        
        return $this->sendData(null);
    }
    
}