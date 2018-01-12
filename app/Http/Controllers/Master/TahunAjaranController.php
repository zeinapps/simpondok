<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Traits\ControllerTrait;
use App\Models\Master\TahunAjaran;
use Alert;
use DB;


class TahunAjaranController extends Controller{
    use ControllerTrait;
    public function index(Request $request){ 
        $tag = ['tahun_ajaran'];
        $key = '_list_tahun_ajaran';
        $s = '';
        if($request->s){
            $s = $request->s;
            $model = TahunAjaran::where('keterangan','like',"%$s%");
        }else{
            $model = new TahunAjaran();
        }
        $result = $this->paginateFromCache($tag, $model, $key);
        
        return view('master/tahun_ajaran/index', ['data' => $result, 's' => $s ]);
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
                $new_data = TahunAjaran::create($request->all());
            }else{
                $new_data = TahunAjaran::find($request->id);
                $new_data->update($request->all());
            }
            
        } catch (\Exception $e) {
            
            Alert::danger("Terjadi masalah pada database");
            
            
            return back()->withInput()->withErrors($e->getMessage());
        }
        $this->clearCache('m_tahun_ajaran');
        Alert::success('Add/Update Data berhasil');
        return redirect()->route('permission.tahun_ajaran.index');
        
    }
    
    public function edit($id){
        $tagCache = ['tahun_ajaran'];
        $key = '_get_all_tahun_ajaran';
        $tahun_ajaran[0] = "Tidak Ada";
        foreach ($this->getFromCache($tagCache, new TahunAjaran, $key) as $va) {
            $tahun_ajaran [$va->id] = $va->nama;
        }
        $query = TahunAjaran::find($id)->toArray();
        return view('master/tahun_ajaran/form', array_merge($query, ['tahun_ajaran_all' => $tahun_ajaran]));
    }
    
    public function add(){ 
        $tagCache = ['tahun_ajaran'];
        $key = '_get_all_tahun_ajaran';
        $tahun_ajaran[0] = "Tidak Ada";
        foreach ($this->getFromCache($tagCache, new TahunAjaran, $key) as $va) {
            $tahun_ajaran [$va->id] = $va->nama;
        }
        return view('master/tahun_ajaran/form',array_merge(['tahun_ajaran_all' => $tahun_ajaran], []));
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