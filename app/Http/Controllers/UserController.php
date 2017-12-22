<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Traits\ControllerTrait;
use App\User;
use Alert;

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
        $result = $this->paginateFromCache($tag, $model, $key);
        
        return view('user/index', ['data' => $result, 's' => $s ]);
    }
    
    public function store(Request $request){ 
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'confirmed',
        ]);

        if ($validator->fails()) {
            Alert::danger($validator->errors());
            return back()->withInput()->withErrors($validator);
        }
        
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
        $this->clearCache('users');
        Alert::success('Add/Update Data berhasil');
        return redirect()->route('permission.user.index');
        
    }
    
    public function edit($id){
        $query = User::find($id)->toArray();
        return view('user/form', array_merge($query, []));
    }
    
    public function add(){ 
        return view('user/form');
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