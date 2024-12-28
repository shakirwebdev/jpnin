<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect, Response;
use DataTables;
use DB;
use Auth;
use Validator;
use Illuminate\Support\Facades\Input;
use App\RefDaerah;
use App\RefParlimen;
use App\RefDUN;
use App\RefStates;
use App\RefRolesUser;
use App\KRT_Profile;
use App\SRS_Profile;
use App\User;


class PenggunaController extends Controller
{
    function pengguna_admin(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            
        } else {
                $roles_menu = DB::table('roles__menu')
                    ->select('roles__menu.id AS id',
                    'users__menu.menu_id AS first_menu',
                    'users__menu.menu2nd_id AS second_menu',
                    'users__menu.users_menu_page_name AS nama_menu',
                    'users__menu.users_menu_file_url AS menu_url',
                    'users__menu.highlight AS highlight_menu',
                    'users__menu.users_menu_page_icon AS icon_menu')
                    ->leftJoin('users__menu','users__menu.id','=','roles__menu.users_menu_id')
                    ->leftJoin('users__roles','users__roles.role_id','=','roles__menu.role_id')
                    ->where('users__roles.user_id', '=', Auth::user()->user_id)
                    ->orderBy('first_menu', 'asc')
                    ->orderBy('id', 'asc')
                    ->get();
            return view('pengurusan.pengguna-admin', compact('roles_menu'));
        }
    }

    function post_add_pengguna_jpnin_admin(Request $request){
        
        $action = $request->add_pengguna_jpnin_admin;
        
        $rules = array(
           
        );

        $messages = [
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('pengurusan.pengguna-admin'))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'add') {
                $add_pengguna_jpnin_admin   = new User;
                $add_pengguna_jpnin_admin->user_status      = 2;
                $add_pengguna_jpnin_admin->save();
            }
           
            return Redirect::to(route('pengurusan.pengguna_admin',$add_pengguna_jpnin_admin->id));
        }

    }
}
