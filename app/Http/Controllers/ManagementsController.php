<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;
use App\RefDaerah;
use App\RefParlimen;
use App\RefDUN;
use App\RefStates;
use App\RefRolesUser;
use App\KRT_Profile;
use App\SRS_Profile;
use App\User;
use Auth;

class ManagementsController extends Controller
{
    /*
        GETs
    */
    public function __construct()
    {
        $this->middleware('auth');
    }

    function pengguna(){
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
                    ->where('roles__menu.status', '=', true)
                    ->orderBy('first_menu', 'asc')
                    ->orderBy('id', 'asc')
                    ->get();
        $daerah                   = RefDaerah::where('status', '=', true)->get();
        $negeri                   = RefStates::where('status', '=', true)->get();
        $parlimen                 = RefParlimen::where('status', '=', true)->get();
        $dun                      = RefDun::where('status', '=', true)->get();
        $user                     = RefDun::where('status', '=', true)->get();
        $roles_user               = RefRolesUser::where('status', '=', true)
                                    ->whereIn('id', [3,4,5,6,7,8,9,14,27,28,29])
                                    ->get();
        $krt                      = KRT_Profile::where('krt_status', '=', '1')->get();
        $srs                      = SRS_Profile::where('srs_status', '=', true)->get();
        $roles_user_orang_awam    = RefRolesUser::where('status', '=', true)
                                    ->whereIn('id', [10,11,12])
                                    ->get();
        $roles_user_ekrt          = RefRolesUser::where('status', '=', true)
                                    ->whereIn('id', [10,11,12])
                                    ->get();
        $roles_user_esrs          = RefRolesUser::where('status', '=', true)
                                    ->where('id','=', 13)
                                    ->get();
        $roles_user_sepakat       = RefRolesUser::where('status', '=', true)
                                    ->whereIn('id', [15,16,17,18,19,20,21,22,23,24])
                                    ->get();
        
        return view('pengurusan.pengguna', 
                    compact('roles_menu',
                            'daerah', 
                            'negeri', 
                            'parlimen', 
                            'dun', 
                            'user', 
                            'roles_user', 
                            'krt', 
                            'srs',
                            'roles_user_orang_awam',
                            'roles_user_ekrt', 
                            'roles_user_esrs', 
                            'roles_user_sepakat'));
    }

    function peranan(){
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
                    ->where('roles__menu.status', '=', true)
                    ->orderBy('first_menu', 'asc')
                    ->orderBy('id', 'asc')
                    ->get();
        $roles_user = RefRolesUser::where('status', '=', true)->get();

        return view('pengurusan.peranan', compact('roles_menu','roles_user'));
    }

    function rujukan_data(){
        $daerah         = RefDaerah::where('status', '=', true)->get();
        $negeri         = RefStates::where('status', '=', true)->get();
        $parlimen       = RefParlimen::where('status', '=', true)->get();
        $dun            = RefDun::where('status', '=', true)->get();
        
        return view('pengurusan.rujukan_data', compact('daerah', 'negeri', 'parlimen', 'dun'));
    }

    function pengguna_ppd(){
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
                    ->where('roles__menu.status', '=', true)
                    ->orderBy('first_menu', 'asc')
                    ->orderBy('id', 'asc')
                    ->get();
        $daerah                   = RefDaerah::where('status', '=', true)->get();
        $negeri                   = RefStates::where('status', '=', true)->get();
        $parlimen                 = RefParlimen::where('status', '=', true)->get();
        $dun                      = RefDun::where('status', '=', true)->get();
        $user                     = RefDun::where('status', '=', true)->get();
        $roles_user               = RefRolesUser::where('status', '=', true)->get();
        $krt                      = KRT_Profile::where('krt_status', '=', true)->get();
        $srs                      = SRS_Profile::where('srs_status', '=', true)->get();
        $roles_user_orang_awam    = RefRolesUser::where('status', '=', true)
                                    ->whereIn('id', [10,11,12])
                                    ->get();
        $roles_user_ekrt          = RefRolesUser::where('status', '=', true)
                                    ->whereIn('id', [4,5,6])
                                    ->get();
        $roles_user_esrs          = RefRolesUser::where('status', '=', true)
                                    ->where('id','=', 7)
                                    ->get();
        
        return view('pengurusan.pengguna-ppd', compact('roles_menu','daerah', 'negeri', 'parlimen', 'dun', 'user', 'roles_user', 'krt', 'srs', 'roles_user_orang_awam','roles_user_ekrt', 'roles_user_esrs'));
    }

    function audit_trail(){
        return view('pengurusan.audit_trail');
    }

    function rujukan_emel(){
        return view('pengurusan.rujukan_emel');
    }
}
