<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Traits\ControllerTrait;
use App\Models\Master\Agama;
use Alert;

class AgamaController extends Controller{
    use ControllerTrait;
    public function index(Request $request){ 
        $tag = ['agama'];
        $key = '_list_agama';
        $s = '';
        if($request->s){
            $s = $request->s;
            $model = Agama::where('keterangan','like',"%$s%");
        }else{
            $model = new Agama();
        }
        $result = $this->paginateFromCache($tag, $model, $key);
        
        return view('master/agama/index', ['data' => $result, 's' => $s ]);
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
            $new_data = new Agama();
        }else{
            $new_data = Agama::find($request->id);
            if(!$new_data){
                Alert::warning("Failed ID");
                return back()->withInput();
            }
        }
        
        $new_data->keterangan = $request->keterangan;
        // optional
        $new_data->save();
        $this->clearCache('agama');
        Alert::success('Add/Update Data berhasil');
        return redirect()->route('permission.agama.index');
        
    }
    
    public function edit($id){
        $query = Agama::find($id)->toArray();
        return view('master/agama/form', array_merge($query, []));
    }
    
    public function add(){ 
        return view('master/agama/form');
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