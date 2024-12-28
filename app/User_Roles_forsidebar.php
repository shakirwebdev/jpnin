<?php

namespace App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Redirect, Response;
use App\Users_Roles;
use Auth;

class User_Roles_forsidebar extends Authenticatable
{
    
    public static function isPPD(){
        if (!is_null(Auth::user())) {
            $users_roles  = Users_Roles::select('role_id')->where('user_id', '=', Auth::user()->user_id)->get();
            return Response::json($users_roles);
            $value1 =  $users_roles->role_id;
            if($value1  == 3){
                return true;
            }
        } else 
        return false;
    }

    public static function isPPN(){
        if (!is_null(Auth::user())) {
            $users_roles  = Users_Roles::select('role_id')->where('user_id', '=', Auth::user()->user_id)->get();
            return Response::json($users_roles);
            $value1 =  $users_roles->role_id;
            if($value1  == 4){
                return true;
            }
        } else 
        return false;
    }
}
