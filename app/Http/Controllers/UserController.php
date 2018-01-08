<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Traits\ControllerTrait;
use App\User;
use App\Models\Role;
use Alert;
use DB;
use PDF;

class UserController extends Controller{
    use ControllerTrait;
    public function index(Request $request){ 
        $tag = ['users'];
        $key = '_list_users';
        $s = '';
        if($request->s){
            $s = $request->s;
            $model = User::where('name','like',"%$s%");
        }else{
            $model = new User();
        }
        $model->with(['roles']);
        $result = $this->paginateFromCache($tag, $model, $key);
        
        return view('user/index', ['data' => $result, 's' => $s ]);
    }
    
    public function store(Request $request){ 
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'confirmed',
            'roles' => 'required',
        ]);
        
        if ($validator->fails()) {
            Alert::danger($validator->errors());
            return back()->withInput()->withErrors($validator);
        }
        DB::beginTransaction();
        try {
            if(!$request->id){
                $validator = Validator::make($request->all(), [
                    'password' => 'required|confirmed',
                ]);
                if ($validator->fails()) {
                    Alert::danger($validator->errors());
                    return back()->withInput()->withErrors($validator);
                }

                $exists = User::where('email',$request->email)->first();
                if($exists){
                    Alert::warning("Email $request->email sudah ada");
                    return back()->withInput();
                }
                $new_user = new User();
                $new_user->password = bcrypt($request->password); 
            }else{
                $new_user = User::find($request->id);
                if(!$new_user){
                    Alert::warning("Failed ID");
                    return back()->withInput();
                }
            }

            $new_user->name = $request->name;
            $new_user->email = $request->email; 
            // optional
            $new_user->save();
            $new_user->detachRoles();
            $new_user->attachRoles($request->roles);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::danger($e->getMessage());
            
            return back()->withInput()->withErrors($e->getMessage());
        }
        $this->clearCache('users');
        Alert::success('Add/Update Data berhasil');
        return redirect()->route('permission.user.index');
        
    }
    
    public function edit($id){
        $query = User::find($id);
        $user_role = [];
        foreach ($query->roles as $key => $value) {
            $user_role[] = $value->id;
        }
        $tagCache = ['roles'];
        $key = '_get_all_roles';
        $role = [];
        foreach ($this->getFromCache($tagCache,new Role,$key) as $v) {
            $r = $v;
            $r->cheked = in_array($v->id, $user_role);
            $role[] = $r;
        }
        return view('user/form', array_merge($query->toArray(), ['roles' => $role]));
    }
    
    public function add(){ 
        $tagCache = ['roles'];
        $key = '_get_all_roles';
        $role = $this->getFromCache($tagCache,new Role,$key);
        
        return view('user/form',['roles' => $role]);
    }
    
    public function delete($id){ 
        $role = Role::find($id);
        if($role){
            $role->delete();
            $this->clearCache($this->tagCache);
        }
        
        return $this->sendData(null);
    }
    
    public function cetak($id){
        $akun = User::where('id',$id)->with('roles')->first()->makeVisible(['password']);
        
        $pdf = PDF::loadView('user/cetak', $akun)
                ->setPaper('a4','portrait')
                ->setWarnings(false);
        return $pdf->download("cetak-$akun->name.pdf");
    }
    
    public function preview($id){ 
        $akun = User::where('id',$id)->with('roles')->first()->makeVisible(['password']);
        
        return view('user/preview',$akun);
    }
}