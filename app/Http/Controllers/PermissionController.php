<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Traits\ControllerTrait;
use App\Models\Permission;
use Alert;

class PermissionController extends Controller{
    use ControllerTrait;
    public function index(Request $request){ 
        $tag = ['permissions'];
        $key = '_list_permissions';
        $s = '';
        if($request->s){
            $s = $request->s;
            $model = Permission::where('name','like',"%$s%");
        }else{
            $model = new Permission();
        }
        $result = $this->paginateFromCache($tag, $model, $key);
        
        return view('permission/index', ['data' => $result, 's' => $s ]);
    }
    
    public function store(Request $request){ 
        $validator = Validator::make($request->all(), [
            'display_name' => 'required|max:191',
            'description' => 'required|max:191',
        ]);

        if ($validator->fails()) {
            Alert::danger($validator->errors());
            return back()->withInput()->withErrors($validator);
        }
        
        if(!$request->id){
//            $exists = Permission::where('name',$request->name)->first();
//            if($exists){
//                Alert::warning("name $request->name sudah ada");
//                return back()->withInput();
//            }
//            $new_permission = new Permission();
//            $new_permission->name = $request->name;
        }else{
            $new_permission = Permission::find($request->id);
            if(!$new_permission){
                Alert::warning("Failed ID");
                return back()->withInput();
            }
        }
        
        $new_permission->display_name = $request->display_name; 
        $new_permission->description = $request->description; 
        $new_permission->save();
        $this->clearCache('permissions');
        Alert::success('Add/Update Data berhasil');
        return redirect()->route('permission.permission.index');
        
    }
    
    public function edit($id){
        $query = Permission::find($id)->toArray();
        return view('permission/form', array_merge($query, []));
    }
    
//    public function add(){ 
//        return view('permission/form');
//    }
    
    public function delete($id){ 
        $permission = Permission::find($id);
        if($permission){
            $permission->delete();
            $this->clearCache($this->tagCache);
        }
        
        return $this->sendData(null);
    }
    
}