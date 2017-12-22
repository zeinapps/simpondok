<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Traits\ControllerTrait;
use App\Models\Group;
use App\Models\Permission;
use App\Models\PermissionGroup;
use Alert;

class GroupController extends Controller{
    use ControllerTrait;
    public function index(Request $request){ 
        $tag = ['groups'];
        $key = '_list_groups';
        $s = '';
        if($request->s){
            $s = $request->s;
            $model = Group::where('name','like',"%$s%");
        }else{
            $model = new Group();
        }
        $result = $this->paginateFromCache($tag, $model, $key);
        
        return view('group/index', ['data' => $result, 's' => $s ]);
    }
    
    public function store(Request $request){ 
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'display_name' => 'required|max:191',
            'description' => 'required|max:191',
        ]);

        if ($validator->fails()) {
            Alert::danger($validator->errors());
            return back()->withInput()->withErrors($validator);
        }
        
        if(!$request->id){
            $exists = Group::where('name',$request->name)->first();
            if($exists){
                Alert::warning("name $request->name sudah ada");
                return back()->withInput();
            }
            $new_group = new Group();
            $new_group->name = $request->name;
        }else{
            $new_group = Group::find($request->id);
            if(!$new_group){
                Alert::warning("Failed ID");
                return back()->withInput();
            }
        }
        
        $new_group->display_name = $request->display_name; 
        $new_group->description = $request->description; 
        $new_group->save();
        $this->clearCache('groups');
        Alert::success('Add/Update Data berhasil');
        return redirect()->route('permission.group.index');
        
    }
    
    public function edit($id){
        $query = Group::find($id)->toArray();
        return view('group/form', array_merge($query, []));
    }
    
    public function add(){ 
        return view('group/form');
    }
    
    public function delete($id){ 
        $group = Group::find($id);
        if($group){
            $group->delete();
            $this->clearCache($this->tagCache);
        }
        
        return $this->sendData(null);
    }
    
    public function editpermission($id_group){
        $group = Group::whereId($id_group)->first();

        $allPermissions = Permission::where('name', 'not like', 'debugbar%')
            ->leftJoin('permission_group', function($q) use ($id_group) {
            $q->on('permissions.id', '=', 'permission_group.permission_id');
            $q->where('permission_group.group_id', '=', $id_group);
        })->select(\DB::raw('permissions.*, permission_group.group_id, 
            IF(permission_group.group_id is null, 0, 1) as centang'))->get();

        return view('group/permission', compact('group','allPermissions'));
    }
    
    public function permission(Request $request){
        $perms  = $request->get('perms');
        $group_id = $request->get('group_id');
        \DB::beginTransaction();
        PermissionGroup::whereGroupId($group_id)->delete();
        if(is_array($perms))
        {
            foreach ($perms as $key => $value) {
                PermissionGroup::insert([
                    'permission_id' => $value,
                    'group_id' => $group_id
                ]);
            }
        }
        \DB::commit();
        $this->clearCache(['permission_group']);
        \Alert::success('Sukses: Ubah Hak akses Peran');
        return redirect()->route('permission.group.permission', ['id' => $group_id]);
    }
    
}