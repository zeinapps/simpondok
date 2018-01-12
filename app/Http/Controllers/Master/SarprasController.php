<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Traits\ControllerTrait;
use App\Models\Master\Sarpras;
use App\Models\Master\Tingkat;
use Alert;


class SarprasController extends Controller{
    use ControllerTrait;
    public function index(Request $request){ 
        $tag = ['sarpras'];
        $key = '_list_sarpras';
        $s = '';
        if($request->s){
            $s = $request->s;
            $model = Sarpras::where('keterangan','like',"%$s%");
        }else{
            $model = new Sarpras();
        }
        $result = $this->paginateFromCache($tag, $model, $key);
        
        return view('master/sarpras/index', ['data' => $result, 's' => $s ]);
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
                $new_data = Sarpras::create($request->all());
            }else{
                $new_data = Sarpras::find($request->id);
                $new_data->update($request->all());
            }
            
        } catch (\Exception $e) {
            
            Alert::danger("Terjadi masalah pada database");
            
            
            return back()->withInput()->withErrors($e->getMessage());
        }
        $this->clearCache('m_sarpras');
        Alert::success('Add/Update Data berhasil');
        return redirect()->route('permission.sarpras.index');
        
    }
    
    public function edit($id){
        $query = Sarpras::find($id)->toArray();
        $tagCache = ['tingkat'];
        $key = '_get_all_tingkat';
        foreach ($this->getFromCache($tagCache, new Tingkat, $key) as $va) {
            $tingkat [$va->id] = $va->nama;
        }
        return view('master/sarpras/form', array_merge($query, ['tingkat_all' => $tingkat]));
    }
    
    public function add(){ 
        $tagCache = ['tingkat'];
        $key = '_get_all_tingkat';
        foreach ($this->getFromCache($tagCache, new Tingkat, $key) as $va) {
            $tingkat [$va->id] = $va->nama;
        }
        return view('master/sarpras/form',array_merge(['tingkat_all' => $tingkat], []));
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