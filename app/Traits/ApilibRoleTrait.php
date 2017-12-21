<?php
namespace App\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Cache\TaggableStore;
use App\Lib;

trait ApilibRoleTrait{
    
    public function getPermissions()
    {
        return $this->permissions()->get();
    }
    
    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission', 'permission_role', 'role_id', 'permission_id');
    }
    
    public function permissions_instansi()
    {
        return $this->belongsToMany('App\Models\Permission', 'permission_role_instansi', 'role_id', 'permission_id');
    }
    
    public function permissions_kelas()
    {
        return $this->belongsToMany('App\Models\Permission', 'permission_role_kelas', 'role_id', 'permission_id');
    }
    
    public function users()
    {
        return $this->belongsToMany(config('apilib.user_model'), 'role_user', 'role_id', 'user_id');
    }
    
    public function hasPermission($permissionname)
    {
        $key = __CLASS__.$this->{$this->primaryKey}.__FUNCTION__.$permissionname;
        if(Cache::getStore() instanceof TaggableStore) {
            return Cache::tags('permission_role')->remember($key, Lib::getExpiredCache(), function () use ($permissionname) {
                if($this->permissions()->where('name',$permissionname)->first()){
                    return true;
                }else{
                    return false;
                }
            });
        }else{
            if($this->permissions()->where('name',$permissionname)->first()){
                return true;
            }else{
                return false;
            }
        }
    }
    
    public function hasPermission_instansi($permissionname, $id_instansi)
    {
        $key = __CLASS__.$this->{$this->primaryKey}.__FUNCTION__.$permissionname;
        if(Cache::getStore() instanceof TaggableStore) {
            return Cache::tags('permission_role_instansi')->remember($key, Lib::getExpiredCache(), function () use ($permissionname, $id_instansi) {
                if($this->permissions_instansi()
                        ->where('id_instansi',$id_instansi)
                        ->where('name',$permissionname)->first()){
                    return true;
                }else{
                    return false;
                }
            });
        }else{
            if($this->permissions_instansi()
                    ->where('id_instansi',$id_instansi)
                    ->where('name',$permissionname)->first()){
                return true;
            }else{
                return false;
            }
        }
    }
    
    public function hasPermission_kelas($permissionname, $id_kelas)
    {
        $key = __CLASS__.$this->{$this->primaryKey}.__FUNCTION__.$permissionname;
        if(Cache::getStore() instanceof TaggableStore) {
            return Cache::tags('permission_role_instansi')->remember($key, Lib::getExpiredCache(), function () use ($permissionname, $id_kelas) {
                if($this->permissions_kelas()
                        ->where('id_kelas',$id_kelas)
                        ->where('name',$permissionname)->first()){
                    return true;
                }else{
                    return false;
                }
            });
        }else{
            if($this->permissions_kelas()
                    ->where('id_kelas',$id_kelas)
                    ->where('name',$permissionname)->first()){
                return true;
            }else{
                return false;
            }
        }
    }
    
    public function attachPermission($permission)
    {
        if(is_object($permission)) {
            $permission = $permission->getKey();
        }

        if(is_array($permission)) {
            $permission = $permission['id'];
        }

        $this->permissions()->attach($permission);
    }

    public function detachPermission($permission)
    {
        if (is_object($permission)) {
            $permission = $permission->getKey();
        }

        if (is_array($permission)) {
            $permission = $permission['id'];
        }

        $this->permissions()->detach($permission);
    }

    
    public function attachPermissions($permissions)
    {
        foreach ($permissions as $permission) {
            $this->attachPermission($permission);
        }
    }

    public function detachRoles($permissions=null)
    {
        if (!$permissions) $permissions = $this->permission()->get();
        foreach ($permissions as $permission) {
            $this->detachRole($permission);
        }
    }
    
    
}
