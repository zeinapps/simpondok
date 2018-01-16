<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Traits\ControllerTrait;
use App\Models\Master\Mapel;
use Alert;


class MapelController extends Controller{
    use ControllerTrait;
    public function index(Request $request){ 
        $tag = ['mapel'];
        $key = '_list_mapel';
        $s = '';
        if($request->s){
            $s = $request->s;
            $model = Mapel::where('keterangan','like',"%$s%")
                    ->orWhere('nama','like',"%$s%")
                    ->orWhere('kode','like',"%$s%");
        }else{
            $model = new Mapel();
        }
        $result = $this->paginateFromCache($tag, $model, $key);
        
        return view('master/mapel/index', ['data' => $result, 's' => $s ]);
    }
    
    public function store(Request $request){ 
        $validator = Validator::make($request->all(), [
            'kode' => 'required|string|max:10',
            'nama' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            Alert::danger($validator->errors());
            return back()->withInput()->withErrors($validator);
        }
        
        try {
            if(!$request->id){
                $new_data = Mapel::create($request->all());
            }else{
                $new_data = Mapel::find($request->id);
                $new_data->update($request->all());
            }
            
        } catch (\Exception $e) {
            
            $errorCode = $e->errorInfo[1];          
            if($errorCode == 1062){
                Alert::danger("Kode sudah di pakai");
            }else{
                Alert::danger("Terjadi masalah pada database");
            }
            
            return back()->withInput()->withErrors($e->getMessage());
        }
        $this->clearCache('m_mapel');
        Alert::success('Add/Update Data berhasil');
        return redirect()->route('permission.mapel.index');
        
    }
    
    public function edit($id){
        $query = Mapel::find($id)->toArray();
        return view('master/mapel/form', array_merge($query, []));
    }
    
    public function add(){ 
        return view('master/mapel/form');
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