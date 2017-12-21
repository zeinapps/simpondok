<?php

namespace App\Http\Middleware;

use Closure;
use App\Lib;
use Illuminate\Support\Facades\Auth;

class AuthorizeRoute
{
    
    public function handle($request, Closure $next, $guard = null)
    {
        $authorized     = false;  
        $user = Auth::user();
        if(!$user){
            return Lib::sendError('Anda belum login');
        }
        $routename = $request->route()->getName();
        if ($user->hasRole('superadmin')){
            $authorized = true;
        }else{
            $prefix = 'routegenerate|';
            $permissionname = $prefix.$routename;
            if($user->can($permissionname)){
                $authorized = true;
            }
        }
        if($authorized){
            return $next($request);
        }else{
            return Lib::sendError('You dont have permission in this action');
        }
        
    }
    
}
