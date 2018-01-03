<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Traits\ControllerTrait;
use App\Models\Master\Kelas;
use App\Models\Master\Tingkat;
use Alert;


class KelasController extends Controller{
    use ControllerTrait;
    public function index(Request $request){ 
        $tag = ['kelas'];
        $key = '_list_kelas';
        $s = '';
        if($request->s){
            $s = $request->s;
            $model = Kelas::where('keterangan','like',"%$s%");
        }else{
            $model = new Kelas();
        }
        $model = $model->leftJoin('m_tingkat','m_kelas.tingkat_id','=','m_tingkat.id');
        $model = $model->select('m_kelas.*','m_tingkat.nama as tingkat');
        $result = $this->paginateFromCache($tag, $model, $key);
        
        return view('master/kelas/index', ['data' => $result, 's' => $s ]);
    }
    
    public function store(Request $request){ 
        $validator = Validator::make($request->all(), [
            'tingkat_id' => 'required',
            'nama' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            Alert::danger($validator->errors());
            return back()->withInput()->withErrors($validator);
        }
        
        try {
            if(!$request->id){
                $new_data = Kelas::create($request->all());
            }else{
                $new_data = Kelas::find($request->id);
                $new_data->update($request->all());
            }
            
        } catch (\Exception $e) {
            
            Alert::danger("Terjadi masalah pada database");
            
            
            return back()->withInput()->withErrors($e->getMessage());
        }
        $this->clearCache('kelas');
        Alert::success('Add/Update Data berhasil');
        return redirect()->route('permission.kelas.index');
        
    }
    
    public function edit($id){
        $query = Kelas::find($id)->toArray();
        $tagCache = ['tingkat'];
        $key = '_get_all_tingkat';
        foreach ($this->getFromCache($tagCache, new Tingkat, $key) as $va) {
            $tingkat [$va->id] = $va->nama;
        }
        return view('master/kelas/form', array_merge($query, ['tingkat_all' => $tingkat]));
    }
    
    public function add(){ 
        $tagCache = ['tingkat'];
        $key = '_get_all_tingkat';
        foreach ($this->getFromCache($tagCache, new Tingkat, $key) as $va) {
            $tingkat [$va->id] = $va->nama;
        }
        return view('master/kelas/form',array_merge(['tingkat_all' => $tingkat], []));
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