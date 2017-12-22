<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Traits\ControllerTrait;
use App\Models\Role;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Group;
use App\Models\GroupRole;
use Alert;

class RoleController extends Controller{
    use ControllerTrait;
    public function index(Request $request){ 
        $tag = ['roles'];
        $key = '_list_roles';
        $s = '';
        if($request->s){
            $s = $request->s;
            $model = Role::where('name','like',"%$s%");
        }else{
            $model = new Role();
        }
        $result = $this->paginateFromCache($tag, $model, $key);
        
        return view('role/index', ['data' => $result, 's' => $s ]);
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
            $exists = Role::where('name',$request->name)->first();
            if($exists){
                Alert::warning("name $request->name sudah ada");
                return back()->withInput();
            }
            $new_role = new Role();
            $new_role->name = $request->name;
        }else{
            $new_role = Role::find($request->id);
            if(!$new_role){
                Alert::warning("Failed ID");
                return back()->withInput();
            }
        }
        
        $new_role->display_name = $request->display_name; 
        $new_role->description = $request->description; 
        $new_role->save();
        $this->clearCache('roles');
        Alert::success('Add/Update Data berhasil');
        return redirect()->route('permission.role.index');
        
    }
    
    public function edit($id){
        $query = Role::find($id)->toArray();
        return view('role/form', array_merge($query, []));
    }
    
    public function add(){ 
        return view('role/form');
    }
    
    public function delete($id){ 
        $role = Role::find($id);
        if($role){
            $role->delete();
            $this->clearCache($this->tagCache);
        }
        
        return $this->sendData(null);
    }
    
    public function editpermission($id_role){
        $role = Role::whereId($id_role)->first();
        $allPermissions = Permission::leftJoin('permission_group', 'permissions.id' , '=', 'permission_group.permission_id')
        ->leftJoin('permission_role', function ($q) use ($id_role) {
                $q->on('permissions.id', '=', 'permission_role.permission_id');
                $q->where('permission_role.role_id', '=', $id_role);
            })->select(\DB::raw('permissions.*, permission_role.role_id, 
            IF(permission_role.role_id is null, 0, 1) as centang, permission_group.group_id'))
            ->get();

        $allGroup = Group::all();

        return view('role/permission', compact('role', 'allPermissions', 'allGroup'));
    }
    
    public function permission(Request $request){
        $perms = $request->get('perms');
        $role_id = $request->get('role_id');
        \DB::beginTransaction();
        PermissionRole::whereRoleId($role_id)->delete();
        if (is_array($perms)) {
            foreach ($perms as $key => $value) {
                PermissionRole::insert([
                    'permission_id' => $value,
                    'role_id' => $role_id
                ]);
            }
        }
        \DB::commit();
        $this->clearCache(['permission_role','role_user']);
        \Alert::success('Sukses: Ubah Hak akses Peran');
        return redirect()->route('permission.role.permission', ['id' => $role_id]);
    }
    
     public function editgroup($id_role)
    {
        $role = Role::whereId($id_role)->first();

        $allGroups = Group::leftJoin('group_role', function ($q) use ($id_role) {
            $q->on('groups.id', '=', 'group_role.group_id');
            $q->where('group_role.role_id', '=', $id_role);
        })->select(\DB::raw('groups.*, group_role.role_id, 
            IF(group_role.role_id is null, 0, 1) as centang'))->get();


        return view('role/group', compact('role', 'allGroups'));
    }

    public function group(Request $request)
    {
        $perms = $request->get('perms');
        $role_id = $request->get('role_id');
        \DB::beginTransaction();
        GroupRole::whereRoleId($role_id)->delete();
        if (is_array($perms)) {
            foreach ($perms as $key => $value) {
                GroupRole::insert([
                    'group_id' => $value,
                    'role_id' => $role_id
                ]);
            }
        }
        \DB::commit();
        $this->clearCache(['group_role','role_user']);
        \Alert::success('Sukses: Ubah Hak akses Peran');
        return redirect()->route('permission.role.group', ['id_role' => $role_id]);
    }

}