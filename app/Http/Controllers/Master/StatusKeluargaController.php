<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Traits\ControllerTrait;
use App\Models\Master\StatusKeluarga;
use Alert;

class StatusKeluargaController extends Controller{
    use ControllerTrait;
    public function index(Request $request){ 
        $tag = ['status_keluarga'];
        $key = '_list_status_keluarga';
        $s = '';
        if($request->s){
            $s = $request->s;
            $model = StatusKeluarga::where('keterangan','like',"%$s%");
        }else{
            $model = new StatusKeluarga();
        }
        $result = $this->paginateFromCache($tag, $model, $key);
        
        return view('master/status_keluarga/index', ['data' => $result, 's' => $s ]);
    }
    
    public function store(Request $request){ 
        $validator = Validator::make($request->all(), [
            'keterangan' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            Alert::danger($validator->errors());
            return back()->withInput()->withErrors($validator);
        }
        
        if(!$request->id){
            $new_data = new StatusKeluarga();
        }else{
            $new_data = StatusKeluarga::find($request->id);
            if(!$new_data){
                Alert::warning("Failed ID");
                return back()->withInput();
            }
        }
        
        $new_data->keterangan = $request->keterangan;
        // optional
        $new_data->save();
        $this->clearCache('status_keluarga');
        Alert::success('Add/Update Data berhasil');
        return redirect()->route('permission.status_keluarga.index');
        
    }
    
    public function edit($id){
        $query = StatusKeluarga::find($id)->toArray();
        return view('master/status_keluarga/form', array_merge($query, []));
    }
    
    public function add(){ 
        return view('master/status_keluarga/form');
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