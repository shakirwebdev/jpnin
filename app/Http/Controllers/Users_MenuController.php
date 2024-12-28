<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect, Response;
use Auth;
use Hash;
use Session;
use DataTables;
use DB;
use App\Http\Controllers\Controller;
use App\RefRolesUser;
use App\User;
use App\UserProfile;

class Users_MenuController extends Controller
{
    function get_roles_menu(Request $request)
    {
        $roles_menu = DB::table('roles__menu')
            ->select(
                'roles__menu.id AS id',
                'users__menu.menu_id AS first_menu',
                'users__menu.menu2nd_id AS second_menu',
                'users__menu.users_menu_page_name AS nama_menu',
                'users__menu.users_menu_page_icon AS icon_menu'
            )
            ->leftJoin('users__menu', 'users__menu.id', '=', 'roles__menu.users_menu_id')
            ->leftJoin('users__roles', 'users__roles.role_id', '=', 'roles__menu.roles_id')
            ->where('users__roles.user_id', '=', Auth::user()->user_id)
            ->get();
        return view('layout.sidebar', compact('roles_menu'));
    }
}
