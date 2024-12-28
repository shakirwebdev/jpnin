<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Redirect, Response;
use Auth;
use Validator;
use Session;
use DataTables;
use DB;
use Carbon\Carbon;
use App\User;
use App\UserProfile;
use App\RefStates;
use App\RefDaerah;
use App\RefBandar;
use App\RefParlimen;
use App\RefDUN;
use App\RefPBT;
use App\KRT_Profile;
use App\RefKaum;
use App\RefJantina;


class RT_SM31Controller extends Controller
{   

    public function __construct(){
        $this->middleware('auth');
    }

    function laporan_srs_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_dun') {
                $value = $request->value;
                $where = array('dun_description' => $value);
                $data  = DB::table('ref__duns')
                        ->select('ref__duns.id', 'ref__duns.dun_id', 'ref__duns.dun_description', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description')
                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','ref__duns.parlimen_id')
                        ->where('ref__parlimens.parlimen_description', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('srs__profile')
                        ->select('srs__profile.id AS id',
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'ref__parlimens.parlimen_description AS parlimen',
                                'ref__duns.dun_description AS dun',
                                'krt__profile.krt_nama AS krt_nama',
                                'srs__profile.srs_name AS srs_nama',
                                DB::raw("CONCAT('SRS',ref__states.state_id,ref__daerahs.daerah_id,srs__profile.id) AS no_rujukan_srs"),
                                DB::raw("YEAR(srs__profile.dihantar_date) AS tarikh_tubuh"),
                                'srs__profile.srs_peronda_total AS bil_pronda')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                        ->whereIN('srs__profile.srs_status',[1])
                        ->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)
                        ->orderBy('krt__profile.state_id')
                        ->get();
                return Datatables::of($data)
                        ->make(true);
        } else {
                $roles_menu     = DB::table('roles__menu')
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
            $krt        = KRT_Profile::where('krt_status', '=',  true)
                        ->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)    
                        ->get();
            $parlimen   = RefParlimen::where('status', '=',  true)
                        ->where('ref__parlimens.state_id', '=', Auth::user()->state_id)    
                        ->get();
            return view('rt-sm31.laporan-srs-ppd',compact('roles_menu','krt','parlimen'));
        }
    }
    
    function laporan_srs_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_dun') {
                $value = $request->value;
                $where = array('dun_description' => $value);
                $data  = DB::table('ref__duns')
                        ->select('ref__duns.id', 'ref__duns.dun_id', 'ref__duns.dun_description', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description')
                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','ref__duns.parlimen_id')
                        ->where('ref__parlimens.parlimen_description', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('krt_nama' => $value);
                $data  = DB::table('krt__profile')
                        ->select('krt__profile.id', 'krt__profile.krt_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->where('ref__daerahs.daerah_description', '=',  $where)
                        ->where('krt__profile.krt_status', '=',  1)
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('srs__profile')
                        ->select('srs__profile.id AS id',
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'ref__parlimens.parlimen_description AS parlimen',
                                'ref__duns.dun_description AS dun',
                                'krt__profile.krt_nama AS krt_nama',
                                'srs__profile.srs_name AS srs_nama',
                                DB::raw("CONCAT('SRS',ref__states.state_id,ref__daerahs.daerah_id,srs__profile.id) AS no_rujukan_srs"),
                                DB::raw("YEAR(srs__profile.dihantar_date) AS tarikh_tubuh"),
                                'srs__profile.srs_peronda_total AS bil_pronda')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                        ->whereIN('srs__profile.srs_status',[1])
                        ->where('krt__profile.state_id', '=', Auth::user()->state_id)
                        ->orderBy('krt__profile.state_id')
                        ->get();
                return Datatables::of($data)
                        ->make(true);
        } else {
                $roles_menu     = DB::table('roles__menu')
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
            $daerah     = RefDaerah::where('status', '=',  true)
                        ->where('ref__daerahs.state_id', '=', Auth::user()->state_id)    
                        ->get();
            $parlimen   = RefParlimen::where('status', '=',  true)
                        ->where('ref__parlimens.state_id', '=', Auth::user()->state_id)    
                        ->get();
            return view('rt-sm31.laporan-srs-ppn',compact('roles_menu','daerah','parlimen'));
        }
    }

    function laporan_srs_hqsrs(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_description' => $value);
                $data  = DB::table('ref__daerahs')
                        ->select('ref__daerahs.id', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__daerahs.state_id')
                        ->where('ref__states.state_description', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            else if($type == 'get_parlimen') {
                $value = $request->value;
                $where = array('parlimen_description' => $value);
                $data  = DB::table('ref__parlimens')
                        ->select('ref__parlimens.id', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__parlimens.state_id')
                        ->where('ref__states.state_description', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            else if($type == 'get_dun') {
                $value = $request->value;
                $where = array('dun_description' => $value);
                $data  = DB::table('ref__duns')
                        ->select('ref__duns.id', 'ref__duns.dun_id', 'ref__duns.dun_description', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description')
                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','ref__duns.parlimen_id')
                        ->where('ref__parlimens.parlimen_description', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('krt_nama' => $value);
                $data  = DB::table('krt__profile')
                        ->select('krt__profile.id', 'krt__profile.krt_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->where('ref__daerahs.daerah_description', '=',  $where)
                        ->where('krt__profile.krt_status', '=',  1)
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('srs__profile')
                        ->select('srs__profile.id AS id',
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'ref__parlimens.parlimen_description AS parlimen',
                                'ref__duns.dun_description AS dun',
                                'krt__profile.krt_nama AS krt_nama',
                                'srs__profile.srs_name AS srs_nama',
                                DB::raw("CONCAT('SRS',ref__states.state_id,ref__daerahs.daerah_id,srs__profile.id) AS no_rujukan_srs"),
                                DB::raw("YEAR(srs__profile.dihantar_date) AS tarikh_tubuh"),
                                'srs__profile.srs_peronda_total AS bil_pronda')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                        ->whereIN('srs__profile.srs_status',[1])
                        ->orderBy('krt__profile.state_id')
                        ->get();
                return Datatables::of($data)
                        ->make(true);
        } else {
                $roles_menu     = DB::table('roles__menu')
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
            $state      = RefStates::where('status', '=',  true)->get();
            return view('rt-sm31.laporan-srs-hqsrs',compact('roles_menu','state'));
        }
    }

    function laporan_srs_hqrt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_description' => $value);
                $data  = DB::table('ref__daerahs')
                        ->select('ref__daerahs.id', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__daerahs.state_id')
                        ->where('ref__states.state_description', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            else if($type == 'get_parlimen') {
                $value = $request->value;
                $where = array('parlimen_description' => $value);
                $data  = DB::table('ref__parlimens')
                        ->select('ref__parlimens.id', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__parlimens.state_id')
                        ->where('ref__states.state_description', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            else if($type == 'get_dun') {
                $value = $request->value;
                $where = array('dun_description' => $value);
                $data  = DB::table('ref__duns')
                        ->select('ref__duns.id', 'ref__duns.dun_id', 'ref__duns.dun_description', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description')
                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','ref__duns.parlimen_id')
                        ->where('ref__parlimens.parlimen_description', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('krt_nama' => $value);
                $data  = DB::table('krt__profile')
                        ->select('krt__profile.id', 'krt__profile.krt_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->where('ref__daerahs.daerah_description', '=',  $where)
                        ->where('krt__profile.krt_status', '=',  1)
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('srs__profile')
                        ->select('srs__profile.id AS id',
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'ref__parlimens.parlimen_description AS parlimen',
                                'ref__duns.dun_description AS dun',
                                'krt__profile.krt_nama AS krt_nama',
                                'srs__profile.srs_name AS srs_nama',
                                DB::raw("CONCAT('SRS',ref__states.state_id,ref__daerahs.daerah_id,srs__profile.id) AS no_rujukan_srs"),
                                DB::raw("YEAR(srs__profile.dihantar_date) AS tarikh_tubuh"),
                                'srs__profile.srs_peronda_total AS bil_pronda')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                        ->whereIN('srs__profile.srs_status',[1])
                        ->orderBy('krt__profile.state_id')
                        ->get();
                return Datatables::of($data)
                        ->make(true);
        } else {
                $roles_menu     = DB::table('roles__menu')
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
            $state      = RefStates::where('status', '=',  true)->get();
            return view('rt-sm31.laporan-srs-hqrt',compact('roles_menu','state'));
        }
    }

    function laporan_srs_kp(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_description' => $value);
                $data  = DB::table('ref__daerahs')
                        ->select('ref__daerahs.id', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__daerahs.state_id')
                        ->where('ref__states.state_description', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            else if($type == 'get_parlimen') {
                $value = $request->value;
                $where = array('parlimen_description' => $value);
                $data  = DB::table('ref__parlimens')
                        ->select('ref__parlimens.id', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__parlimens.state_id')
                        ->where('ref__states.state_description', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            else if($type == 'get_dun') {
                $value = $request->value;
                $where = array('dun_description' => $value);
                $data  = DB::table('ref__duns')
                        ->select('ref__duns.id', 'ref__duns.dun_id', 'ref__duns.dun_description', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description')
                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','ref__duns.parlimen_id')
                        ->where('ref__parlimens.parlimen_description', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('krt_nama' => $value);
                $data  = DB::table('krt__profile')
                        ->select('krt__profile.id', 'krt__profile.krt_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->where('ref__daerahs.daerah_description', '=',  $where)
                        ->where('krt__profile.krt_status', '=',  1)
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('srs__profile')
                        ->select('srs__profile.id AS id',
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'ref__parlimens.parlimen_description AS parlimen',
                                'ref__duns.dun_description AS dun',
                                'krt__profile.krt_nama AS krt_nama',
                                'srs__profile.srs_name AS srs_nama',
                                DB::raw("CONCAT('SRS',ref__states.state_id,ref__daerahs.daerah_id,srs__profile.id) AS no_rujukan_srs"),
                                DB::raw("YEAR(srs__profile.dihantar_date) AS tarikh_tubuh"),
                                'srs__profile.srs_peronda_total AS bil_pronda')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                        ->whereIN('srs__profile.srs_status',[1])
                        ->orderBy('krt__profile.state_id')
                        ->get();
                return Datatables::of($data)
                        ->make(true);
        } else {
                $roles_menu     = DB::table('roles__menu')
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
            $state      = RefStates::where('status', '=',  true)->get();
            return view('rt-sm31.laporan-srs-kp',compact('roles_menu','state'));
        }
    }
    
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function laporan_pembantalan_srs_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_dun') {
                $value = $request->value;
                $where = array('dun_description' => $value);
                $data  = DB::table('ref__duns')
                        ->select('ref__duns.id', 'ref__duns.dun_id', 'ref__duns.dun_description', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description')
                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','ref__duns.parlimen_id')
                        ->where('ref__parlimens.parlimen_description', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            $data = DB::select(DB::raw("
            SELECT
                srs__permohonan_pembatalan_srs.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS krt_nama,
                CONCAT('SRS',ref__states.state_id,ref__daerahs.daerah_id,srs__profile.id) AS no_rujukan_srs,
                srs__profile.srs_name AS srs_nama,
                srs__profile.srs_peronda_total AS jumlah_peronda,
                DATE_FORMAT(srs__profile.diluluskan_date,'%d/%m/%Y') AS tarikh_ditubuhkan_srs,
                DATE_FORMAT(srs__permohonan_pembatalan_srs.diluluskan_date,'%d/%m/%Y') AS tarikh_pembatalan_srs
            FROM srs__permohonan_pembatalan_srs
            LEFT JOIN srs__profile ON srs__profile.id = srs__permohonan_pembatalan_srs.srs_profile_id
            LEFT JOIN krt__profile ON krt__profile.id = srs__profile.krt_id
            LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
            LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
            WHERE srs__permohonan_pembatalan_srs.pembatalan_status = 1 AND krt__profile.daerah_id = '" . Auth::user()->daerah_id . "'"));
            return Datatables::of($data)
            ->make(true);
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
                        ->where('roles__menu.status', '=', true)
                        ->orderBy('first_menu', 'asc')
                        ->orderBy('id', 'asc')
                        ->get();
             $krt        = KRT_Profile::where('krt_status', '=',  true)
                        ->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)    
                        ->get();
             $parlimen   = RefParlimen::where('status', '=',  true)
                        ->where('ref__parlimens.state_id', '=', Auth::user()->state_id)    
                        ->get();
            return view('rt-sm31.laporan-pembantalan-srs-ppd',compact('roles_menu','krt','parlimen'));
        }
    }

    function laporan_pembantalan_srs_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_dun') {
                $value = $request->value;
                $where = array('dun_description' => $value);
                $data  = DB::table('ref__duns')
                        ->select('ref__duns.id', 'ref__duns.dun_id', 'ref__duns.dun_description', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description')
                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','ref__duns.parlimen_id')
                        ->where('ref__parlimens.parlimen_description', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('krt_nama' => $value);
                $data  = DB::table('krt__profile')
                        ->select('krt__profile.id', 'krt__profile.krt_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->where('ref__daerahs.daerah_description', '=',  $where)
                        ->where('krt__profile.krt_status', '=',  1)
                        ->get();
                return Response::json($data);
            }
            $data = DB::select(DB::raw("
            SELECT
                srs__permohonan_pembatalan_srs.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS krt_nama,
                CONCAT('SRS',ref__states.state_id,ref__daerahs.daerah_id,srs__profile.id) AS no_rujukan_srs,
                srs__profile.srs_name AS srs_nama,
                srs__profile.srs_peronda_total AS jumlah_peronda,
                DATE_FORMAT(srs__profile.diluluskan_date,'%d/%m/%Y') AS tarikh_ditubuhkan_srs,
                DATE_FORMAT(srs__permohonan_pembatalan_srs.diluluskan_date,'%d/%m/%Y') AS tarikh_pembatalan_srs
            FROM srs__permohonan_pembatalan_srs
            LEFT JOIN srs__profile ON srs__profile.id = srs__permohonan_pembatalan_srs.srs_profile_id
            LEFT JOIN krt__profile ON krt__profile.id = srs__profile.krt_id
            LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
            LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
            WHERE srs__permohonan_pembatalan_srs.pembatalan_status = 1 AND krt__profile.state_id = '" . Auth::user()->state_id . "'"));
            return Datatables::of($data)
            ->make(true);
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
                        ->where('roles__menu.status', '=', true)
                        ->orderBy('first_menu', 'asc')
                        ->orderBy('id', 'asc')
                        ->get();
             $daerah     = RefDaerah::where('status', '=',  true)
                        ->where('ref__daerahs.state_id', '=', Auth::user()->state_id)    
                        ->get();
            $parlimen   = RefParlimen::where('status', '=',  true)
                        ->where('ref__parlimens.state_id', '=', Auth::user()->state_id)    
                        ->get();
            return view('rt-sm31.laporan-pembantalan-srs-ppn',compact('roles_menu','daerah','parlimen'));
        }
    }

    function laporan_pembantalan_srs_hqsrs(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_description' => $value);
                $data  = DB::table('ref__daerahs')
                        ->select('ref__daerahs.id', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__daerahs.state_id')
                        ->where('ref__states.state_description', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            else if($type == 'get_parlimen') {
                $value = $request->value;
                $where = array('parlimen_description' => $value);
                $data  = DB::table('ref__parlimens')
                        ->select('ref__parlimens.id', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__parlimens.state_id')
                        ->where('ref__states.state_description', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            else if($type == 'get_dun') {
                $value = $request->value;
                $where = array('dun_description' => $value);
                $data  = DB::table('ref__duns')
                        ->select('ref__duns.id', 'ref__duns.dun_id', 'ref__duns.dun_description', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description')
                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','ref__duns.parlimen_id')
                        ->where('ref__parlimens.parlimen_description', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('krt_nama' => $value);
                $data  = DB::table('krt__profile')
                        ->select('krt__profile.id', 'krt__profile.krt_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->where('ref__daerahs.daerah_description', '=',  $where)
                        ->where('krt__profile.krt_status', '=',  1)
                        ->get();
                return Response::json($data);
            }
            $data = DB::select(DB::raw("
            SELECT
                srs__permohonan_pembatalan_srs.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS krt_nama,
                CONCAT('SRS',ref__states.state_id,ref__daerahs.daerah_id,srs__profile.id) AS no_rujukan_srs,
                srs__profile.srs_name AS srs_nama,
                srs__profile.srs_peronda_total AS jumlah_peronda,
                DATE_FORMAT(srs__profile.diluluskan_date,'%d/%m/%Y') AS tarikh_ditubuhkan_srs,
                DATE_FORMAT(srs__permohonan_pembatalan_srs.diluluskan_date,'%d/%m/%Y') AS tarikh_pembatalan_srs
            FROM srs__permohonan_pembatalan_srs
            LEFT JOIN srs__profile ON srs__profile.id = srs__permohonan_pembatalan_srs.srs_profile_id
            LEFT JOIN krt__profile ON krt__profile.id = srs__profile.krt_id
            LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
            LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
            WHERE srs__permohonan_pembatalan_srs.pembatalan_status = 1 "));
            return Datatables::of($data)
            ->make(true);
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
                        ->where('roles__menu.status', '=', true)
                        ->orderBy('first_menu', 'asc')
                        ->orderBy('id', 'asc')
                        ->get();
            $state      = RefStates::where('status', '=',  true)->get();
            return view('rt-sm31.laporan-pembantalan-srs-hqsrs',compact('roles_menu','state'));
        }
    }

    function laporan_pembantalan_srs_kp(Request $request){ 
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_description' => $value);
                $data  = DB::table('ref__daerahs')
                        ->select('ref__daerahs.id', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__daerahs.state_id')
                        ->where('ref__states.state_description', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            else if($type == 'get_parlimen') {
                $value = $request->value;
                $where = array('parlimen_description' => $value);
                $data  = DB::table('ref__parlimens')
                        ->select('ref__parlimens.id', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__parlimens.state_id')
                        ->where('ref__states.state_description', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            else if($type == 'get_dun') {
                $value = $request->value;
                $where = array('dun_description' => $value);
                $data  = DB::table('ref__duns')
                        ->select('ref__duns.id', 'ref__duns.dun_id', 'ref__duns.dun_description', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description')
                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','ref__duns.parlimen_id')
                        ->where('ref__parlimens.parlimen_description', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('krt_nama' => $value);
                $data  = DB::table('krt__profile')
                        ->select('krt__profile.id', 'krt__profile.krt_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->where('ref__daerahs.daerah_description', '=',  $where)
                        ->where('krt__profile.krt_status', '=',  1)
                        ->get();
                return Response::json($data);
            }
            $data = DB::select(DB::raw("
            SELECT
                srs__permohonan_pembatalan_srs.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS krt_nama,
                CONCAT('SRS',ref__states.state_id,ref__daerahs.daerah_id,srs__profile.id) AS no_rujukan_srs,
                srs__profile.srs_name AS srs_nama,
                srs__profile.srs_peronda_total AS jumlah_peronda,
                DATE_FORMAT(srs__profile.diluluskan_date,'%d/%m/%Y') AS tarikh_ditubuhkan_srs,
                DATE_FORMAT(srs__permohonan_pembatalan_srs.diluluskan_date,'%d/%m/%Y') AS tarikh_pembatalan_srs
            FROM srs__permohonan_pembatalan_srs
            LEFT JOIN srs__profile ON srs__profile.id = srs__permohonan_pembatalan_srs.srs_profile_id
            LEFT JOIN krt__profile ON krt__profile.id = srs__profile.krt_id
            LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
            LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
            WHERE srs__permohonan_pembatalan_srs.pembatalan_status = 1 "));
            return Datatables::of($data)
            ->make(true);
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
                        ->where('roles__menu.status', '=', true)
                        ->orderBy('first_menu', 'asc')
                        ->orderBy('id', 'asc')
                        ->get();
            $state      = RefStates::where('status', '=',  true)->get();
            return view('rt-sm31.laporan-pembantalan-srs-kp',compact('roles_menu','state'));
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function laporan_peronda_srs_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_srs') {
                $value = $request->value;
                $where = array('krt_nama' => $value);
                $data  = DB::table('srs__profile')
                        ->select('srs__profile.id', 'srs__profile.srs_name', 'krt__profile.id', 'krt__profile.krt_nama')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->where('krt__profile.krt_nama', '=',  $where)
                        ->where('srs__profile.srs_status', '=',  1)
                        ->orderBy('srs__profile.srs_name', 'ASC')   
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('srs__ahli_peronda')
                        ->select('srs__ahli_peronda.id AS id',
                                'ref__states.state_description AS negeri',
                                'ref__daerahs.daerah_description AS daerah',
                                'krt__profile.krt_nama AS peronda_krt',
                                'srs__profile.srs_name AS peronda_srs',
                                'srs__ahli_peronda.peronda_nama AS peronda_nama',
                                DB::raw("CONCAT('SRS',krt__profile.state_id,krt__profile.daerah_id,srs__ahli_peronda.id) AS peronda_kad_no"),
                                'ref__kaum.kaum_description AS peronda_kaum',
                                'ref__jantina.jantina_description AS peronda_jantina',
                                DB::raw("TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) AS peronda_umur"),
                                'srs__ahli_peronda.peronda_alamat AS peronda_alamat')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__ahli_peronda.srs_profile_id')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__kaum','ref__kaum.id','=','srs__ahli_peronda.peronda_kaum')
                        ->leftJoin('ref__jantina','ref__jantina.id','=','srs__ahli_peronda.peronda_jantina')
                        ->whereIN('srs__ahli_peronda.peronda_status',[1])
                        ->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)
                        ->orderBy('krt__profile.state_id')
                        ->get();
                return Datatables::of($data)
                        ->make(true);
        } else {
                $roles_menu     = DB::table('roles__menu')
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
                $krt    = KRT_Profile::where('krt_status', '=',  true)
                        ->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)    
                        ->get();
            return view('rt-sm31.laporan-peronda-srs-ppd',compact('roles_menu','krt'));
        }
    }

    function laporan_peronda_srs_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_description' => $value);
                $data  = DB::table('krt__profile')
                        ->select('krt__profile.id', 'krt__profile.krt_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->where('ref__daerahs.daerah_description', '=',  $where)
                        ->where('krt__profile.krt_status', '=',  1)
                        ->orderBy('krt__profile.krt_nama', 'ASC')   
                        ->get();
                return Response::json($data);
            } else if($type == 'get_srs') {
                $value = $request->value;
                $where = array('krt_nama' => $value);
                $data  = DB::table('srs__profile')
                        ->select('srs__profile.id', 'srs__profile.srs_name', 'krt__profile.id', 'krt__profile.krt_nama')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->where('krt__profile.krt_nama', '=',  $where)
                        ->where('srs__profile.srs_status', '=',  1)
                        ->orderBy('srs__profile.srs_name', 'ASC')   
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('srs__ahli_peronda')
                        ->select('srs__ahli_peronda.id AS id',
                                'ref__states.state_description AS negeri',
                                'ref__daerahs.daerah_description AS daerah',
                                'krt__profile.krt_nama AS peronda_krt',
                                'srs__profile.srs_name AS peronda_srs',
                                'srs__ahli_peronda.peronda_nama AS peronda_nama',
                                DB::raw("CONCAT('SRS',krt__profile.state_id,krt__profile.daerah_id,srs__ahli_peronda.id) AS peronda_kad_no"),
                                'ref__kaum.kaum_description AS peronda_kaum',
                                'ref__jantina.jantina_description AS peronda_jantina',
                                DB::raw("TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) AS peronda_umur"),
                                'srs__ahli_peronda.peronda_alamat AS peronda_alamat')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__ahli_peronda.srs_profile_id')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__kaum','ref__kaum.id','=','srs__ahli_peronda.peronda_kaum')
                        ->leftJoin('ref__jantina','ref__jantina.id','=','srs__ahli_peronda.peronda_jantina')
                        ->whereIN('srs__ahli_peronda.peronda_status',[1])
                        ->where('krt__profile.state_id', '=', Auth::user()->state_id)
                        ->orderBy('krt__profile.state_id')
                        ->get();
                return Datatables::of($data)
                        ->make(true);
        } else {
                $roles_menu     = DB::table('roles__menu')
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
                $daerah         = RefDaerah::where('status', '=',  true)
                                ->where('ref__daerahs.state_id', '=', Auth::user()->state_id) 
                                ->orderBy('daerah_description', 'ASC')   
                                ->get();
            return view('rt-sm31.laporan-peronda-srs-ppn',compact('roles_menu','daerah'));
        }
    }

    function laporan_peronda_srs_hqsrs(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_description' => $value);
                $data  = DB::table('ref__daerahs')
                        ->select('ref__daerahs.id', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__daerahs.state_id')
                        ->where('ref__states.state_description', '=',  $where)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_description' => $value);
                $data  = DB::table('krt__profile')
                        ->select('krt__profile.id', 'krt__profile.krt_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->where('ref__daerahs.daerah_description', '=',  $where)
                        ->where('krt__profile.krt_status', '=',  1)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_srs') {
                $value = $request->value;
                $where = array('krt_nama' => $value);
                $data  = DB::table('srs__profile')
                        ->select('srs__profile.id', 'srs__profile.srs_name', 'krt__profile.id', 'krt__profile.krt_nama')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->where('krt__profile.krt_nama', '=',  $where)
                        ->where('srs__profile.srs_status', '=',  1)
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('srs__ahli_peronda')
                        ->select('srs__ahli_peronda.id AS id',
                                'ref__states.state_description AS negeri',
                                'ref__daerahs.daerah_description AS daerah',
                                'krt__profile.krt_nama AS peronda_krt',
                                'srs__profile.srs_name AS peronda_srs',
                                'srs__ahli_peronda.peronda_nama AS peronda_nama',
                                DB::raw("CONCAT('SRS',krt__profile.state_id,krt__profile.daerah_id,srs__ahli_peronda.id) AS peronda_kad_no"),
                                'ref__kaum.kaum_description AS peronda_kaum',
                                'ref__jantina.jantina_description AS peronda_jantina',
                                DB::raw("TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) AS peronda_umur"),
                                'srs__ahli_peronda.peronda_alamat AS peronda_alamat')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__ahli_peronda.srs_profile_id')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__kaum','ref__kaum.id','=','srs__ahli_peronda.peronda_kaum')
                        ->leftJoin('ref__jantina','ref__jantina.id','=','srs__ahli_peronda.peronda_jantina')
                        ->whereIN('srs__ahli_peronda.peronda_status',[1])
                        ->orderBy('krt__profile.state_id')
                        ->get();
                return Datatables::of($data)
                        ->make(true);
        } else {
                $roles_menu     = DB::table('roles__menu')
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
            $state      = RefStates::where('status', '=',  true)->get();
            return view('rt-sm31.laporan-peronda-srs-hqsrs',compact('roles_menu','state'));
        }
    }

    function laporan_peronda_srs_kp(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_description' => $value);
                $data  = DB::table('ref__daerahs')
                        ->select('ref__daerahs.id', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__daerahs.state_id')
                        ->where('ref__states.state_description', '=',  $where)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_description' => $value);
                $data  = DB::table('krt__profile')
                        ->select('krt__profile.id', 'krt__profile.krt_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->where('ref__daerahs.daerah_description', '=',  $where)
                        ->where('krt__profile.krt_status', '=',  1)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_srs') {
                $value = $request->value;
                $where = array('krt_nama' => $value);
                $data  = DB::table('srs__profile')
                        ->select('srs__profile.id', 'srs__profile.srs_name', 'krt__profile.id', 'krt__profile.krt_nama')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->where('krt__profile.krt_nama', '=',  $where)
                        ->where('srs__profile.srs_status', '=',  1)
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('srs__ahli_peronda')
                        ->select('srs__ahli_peronda.id AS id',
                                'ref__states.state_description AS negeri',
                                'ref__daerahs.daerah_description AS daerah',
                                'krt__profile.krt_nama AS peronda_krt',
                                'srs__profile.srs_name AS peronda_srs',
                                'srs__ahli_peronda.peronda_nama AS peronda_nama',
                                DB::raw("CONCAT('SRS',krt__profile.state_id,krt__profile.daerah_id,srs__ahli_peronda.id) AS peronda_kad_no"),
                                'ref__kaum.kaum_description AS peronda_kaum',
                                'ref__jantina.jantina_description AS peronda_jantina',
                                DB::raw("TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) AS peronda_umur"),
                                'srs__ahli_peronda.peronda_alamat AS peronda_alamat')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__ahli_peronda.srs_profile_id')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__kaum','ref__kaum.id','=','srs__ahli_peronda.peronda_kaum')
                        ->leftJoin('ref__jantina','ref__jantina.id','=','srs__ahli_peronda.peronda_jantina')
                        ->whereIN('srs__ahli_peronda.peronda_status',[1])
                        ->orderBy('krt__profile.state_id')
                        ->get();
                return Datatables::of($data)
                        ->make(true);
        } else {
                $roles_menu     = DB::table('roles__menu')
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
            $state      = RefStates::where('status', '=',  true)->get();
            return view('rt-sm31.laporan-peronda-srs-kp',compact('roles_menu','state'));
        }
    }

     /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function laporan_ringkasan_peronda_srs_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_srs') {
                $value = $request->value;
                $where = array('krt_nama' => $value);
                $data  = DB::table('srs__profile')
                        ->select('srs__profile.id', 'srs__profile.srs_name', 'krt__profile.id', 'krt__profile.krt_nama')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->where('krt__profile.krt_nama', '=',  $where)
                        ->where('srs__profile.srs_status', '=',  1)
                        ->orderBy('srs__profile.srs_name', 'ASC')   
                        ->get();
                return Response::json($data);
            }
            $data = DB::select(DB::raw("
                SELECT
                ref__states.state_description AS negeri,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
                krt__profile.krt_nama AS krt_nama,
                srs__profile.srs_name AS srs_nama,
                (case when a.total_ahli_peronda IS NOT NULL then a.total_ahli_peronda else 0 end)AS total_ahli_peronda,
                (case when ml.total_ml IS NOT NULL then ml.total_ml else 0 end)AS total_ml,
                (case when mp.total_mp IS NOT NULL then mp.total_mp else 0 end)AS total_mp,
                (case when cl.total_cl IS NOT NULL then cl.total_cl else 0 end)AS total_cl,
                (case when cp.total_cp IS NOT NULL then cp.total_cp else 0 end)AS total_cp,
                (case when il.total_il IS NOT NULL then il.total_il else 0 end)AS total_il,
                (case when ip.total_ip IS NOT NULL then ip.total_ip else 0 end)AS total_ip,
                (case when sl.total_sl IS NOT NULL then sl.total_sl else 0 end)AS total_sl,
                (case when sp.total_sp IS NOT NULL then sp.total_sp else 0 end)AS total_sp,
                (case when skl.total_skl IS NOT NULL then skl.total_skl else 0 end)AS total_skl,
                (case when skp.total_skp IS NOT NULL then skp.total_skp else 0 end)AS total_skp,
                (case when ll.total_ll IS NOT NULL then ll.total_ll else 0 end)AS total_ll,
                (case when lp.total_lp IS NOT NULL then lp.total_lp else 0 end)AS total_lp,
                (case when age1.total_age1 IS NOT NULL then age1.total_age1 else 0 end)AS total_age1,
                (case when age2.total_age2 IS NOT NULL then age2.total_age2 else 0 end)AS total_age2,
                (case when age3.total_age3 IS NOT NULL then age3.total_age3 else 0 end)AS total_age3,
                (case when age4.total_age4 IS NOT NULL then age4.total_age4 else 0 end)AS total_age4,
                (case when age5.total_age5 IS NOT NULL then age5.total_age5 else 0 end)AS total_age5
                FROM srs__profile
                LEFT JOIN krt__profile ON krt__profile.id = srs__profile.krt_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
                LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id, 
                        count(*) AS total_ahli_peronda
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) a ON a.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_ml
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (1,2,3,4,5,6,7) AND 
                    srs__ahli_peronda.peronda_jantina = 1
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) ml ON ml.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_mp
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (1,2,3,4,5,6,7) AND 
                    srs__ahli_peronda.peronda_jantina = 2
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) mp ON mp.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_cl
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (8,9,10,11,12,13,14,15,16,17,18,19,20) AND 
                    srs__ahli_peronda.peronda_jantina = 1
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) cl ON cl.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_cp
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (8,9,10,11,12,13,14,15,16,17,18,19,20) AND 
                    srs__ahli_peronda.peronda_jantina = 2
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) cp ON cp.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_il
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37) AND 
                    srs__ahli_peronda.peronda_jantina = 1
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) il ON il.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_ip
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37) AND 
                    srs__ahli_peronda.peronda_jantina = 2
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) ip ON ip.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_sl
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    srs__ahli_peronda.peronda_kaum IN (40,41,42,43,44,45,46,47,48,49,50,52,53,54,55,56,57,58,59,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96) 
                    AND srs__ahli_peronda.peronda_jantina = 1
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) sl ON sl.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_sp
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    srs__ahli_peronda.peronda_kaum IN (40,41,42,43,44,45,46,47,48,49,50,52,53,54,55,56,57,58,59,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96) 
                    AND srs__ahli_peronda.peronda_jantina = 2
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) sp ON sp.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_skl
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    srs__ahli_peronda.peronda_kaum IN (97,98,99,100,101,102,103,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,167,168,169,170,171) 
                    AND srs__ahli_peronda.peronda_jantina = 1
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) skl ON skl.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_skp
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    srs__ahli_peronda.peronda_kaum IN (97,98,99,100,101,102,103,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,167,168,169,170,171) 
                    AND srs__ahli_peronda.peronda_jantina = 2
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) skp ON skp.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_ll
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (38,39,51,61) AND srs__ahli_peronda.peronda_jantina = 1
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) ll ON ll.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_lp
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (38,39,51,61) AND srs__ahli_peronda.peronda_jantina = 2
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) lp ON lp.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_age1
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) >= 18 AND TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) <= 21
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) age1 ON age1.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_age2
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) >= 22 AND TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) <= 40
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) age2 ON age2.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_age3
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) >= 41 AND TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) <= 55
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) age3 ON age3.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_age4
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) >= 56 AND TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) <= 70
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) age4 ON age4.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_age5
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) >= 71
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) age5 ON age5.srs_profile_id = srs__profile.id
                WHERE srs__profile.srs_status = 1 AND krt__profile.daerah_id = '" . Auth::user()->daerah_id . "'
                GROUP BY ref__states.state_description, ref__daerahs.daerah_description, ref__parlimens.parlimen_description, ref__duns.dun_description, krt__profile.krt_nama,
                        srs__profile.srs_name, a.total_ahli_peronda, ml.total_ml, mp.total_mp, cl.total_cl, cp.total_cp, il.total_il, ip.total_ip, sl.total_sl, sp.total_sp,
                        skl.total_skl, skp.total_skp, ll.total_ll, lp.total_lp, age1.total_age1, age2.total_age2, age3.total_age3, age4.total_age4, age5.total_age5
                    "));
            return Datatables::of($data)
            ->make(true);
        } else {
                $roles_menu     = DB::table('roles__menu')
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
                $krt    = KRT_Profile::where('krt_status', '=',  true)
                        ->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)    
                        ->get();
            return view('rt-sm31.laporan-ringkasan-peronda-srs-ppd',compact('roles_menu','krt'));
        }
       
    }

     function laporan_ringkasan_peronda_srs_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_parlimen') {
                $value = $request->value;
                $where = array('parlimen_description' => $value);
                $data  = DB::table('ref__parlimens')
                        ->select('ref__parlimens.id', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__parlimens.state_id')
                        ->where('ref__states.state_description', '=',  $where)
                        ->orderBy('parlimen_description', 'ASC')  
                        ->get();
                return Response::json($data);
            } else if($type == 'get_dun') {
                $value = $request->value;
                $where = array('dun_description' => $value);
                $data  = DB::table('ref__duns')
                        ->select('ref__duns.id', 'ref__duns.dun_id', 'ref__duns.dun_description', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description')
                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','ref__duns.parlimen_id')
                        ->where('ref__parlimens.parlimen_description', '=',  $where)
                        ->orderBy('dun_description', 'ASC')  
                        ->get();
                return Response::json($data);
            } else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_description' => $value);
                $data  = DB::table('krt__profile')
                        ->select('krt__profile.id', 'krt__profile.krt_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->where('ref__daerahs.daerah_description', '=',  $where)
                        ->where('krt__profile.krt_status', '=',  1)
                        ->orderBy('krt_nama', 'ASC') 
                        ->get();
                return Response::json($data);
            } else if($type == 'get_srs') {
                $value = $request->value;
                $where = array('krt_nama' => $value);
                $data  = DB::table('srs__profile')
                        ->select('srs__profile.id', 'srs__profile.srs_name', 'krt__profile.id', 'krt__profile.krt_nama')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->where('krt__profile.krt_nama', '=',  $where)
                        ->where('srs__profile.srs_status', '=',  1)
                        ->orderBy('srs_name', 'ASC') 
                        ->get();
                return Response::json($data);
            }
            $data = DB::select(DB::raw("
                SELECT
                ref__states.state_description AS negeri,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
                krt__profile.krt_nama AS krt_nama,
                srs__profile.srs_name AS srs_nama,
                (case when a.total_ahli_peronda IS NOT NULL then a.total_ahli_peronda else 0 end)AS total_ahli_peronda,
                (case when ml.total_ml IS NOT NULL then ml.total_ml else 0 end)AS total_ml,
                (case when mp.total_mp IS NOT NULL then mp.total_mp else 0 end)AS total_mp,
                (case when cl.total_cl IS NOT NULL then cl.total_cl else 0 end)AS total_cl,
                (case when cp.total_cp IS NOT NULL then cp.total_cp else 0 end)AS total_cp,
                (case when il.total_il IS NOT NULL then il.total_il else 0 end)AS total_il,
                (case when ip.total_ip IS NOT NULL then ip.total_ip else 0 end)AS total_ip,
                (case when sl.total_sl IS NOT NULL then sl.total_sl else 0 end)AS total_sl,
                (case when sp.total_sp IS NOT NULL then sp.total_sp else 0 end)AS total_sp,
                (case when skl.total_skl IS NOT NULL then skl.total_skl else 0 end)AS total_skl,
                (case when skp.total_skp IS NOT NULL then skp.total_skp else 0 end)AS total_skp,
                (case when ll.total_ll IS NOT NULL then ll.total_ll else 0 end)AS total_ll,
                (case when lp.total_lp IS NOT NULL then lp.total_lp else 0 end)AS total_lp,
                (case when age1.total_age1 IS NOT NULL then age1.total_age1 else 0 end)AS total_age1,
                (case when age2.total_age2 IS NOT NULL then age2.total_age2 else 0 end)AS total_age2,
                (case when age3.total_age3 IS NOT NULL then age3.total_age3 else 0 end)AS total_age3,
                (case when age4.total_age4 IS NOT NULL then age4.total_age4 else 0 end)AS total_age4,
                (case when age5.total_age5 IS NOT NULL then age5.total_age5 else 0 end)AS total_age5
                FROM srs__profile
                LEFT JOIN krt__profile ON krt__profile.id = srs__profile.krt_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
                LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id, 
                        count(*) AS total_ahli_peronda
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) a ON a.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_ml
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (1,2,3,4,5,6,7) AND 
                    srs__ahli_peronda.peronda_jantina = 1
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) ml ON ml.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_mp
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (1,2,3,4,5,6,7) AND 
                    srs__ahli_peronda.peronda_jantina = 2
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) mp ON mp.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_cl
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (8,9,10,11,12,13,14,15,16,17,18,19,20) AND 
                    srs__ahli_peronda.peronda_jantina = 1
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) cl ON cl.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_cp
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (8,9,10,11,12,13,14,15,16,17,18,19,20) AND 
                    srs__ahli_peronda.peronda_jantina = 2
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) cp ON cp.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_il
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37) AND 
                    srs__ahli_peronda.peronda_jantina = 1
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) il ON il.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_ip
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37) AND 
                    srs__ahli_peronda.peronda_jantina = 2
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) ip ON ip.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_sl
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    srs__ahli_peronda.peronda_kaum IN (40,41,42,43,44,45,46,47,48,49,50,52,53,54,55,56,57,58,59,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96) 
                    AND srs__ahli_peronda.peronda_jantina = 1
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) sl ON sl.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_sp
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    srs__ahli_peronda.peronda_kaum IN (40,41,42,43,44,45,46,47,48,49,50,52,53,54,55,56,57,58,59,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96) 
                    AND srs__ahli_peronda.peronda_jantina = 2
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) sp ON sp.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_skl
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    srs__ahli_peronda.peronda_kaum IN (97,98,99,100,101,102,103,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,167,168,169,170,171) 
                    AND srs__ahli_peronda.peronda_jantina = 1
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) skl ON skl.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_skp
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    srs__ahli_peronda.peronda_kaum IN (97,98,99,100,101,102,103,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,167,168,169,170,171) 
                    AND srs__ahli_peronda.peronda_jantina = 2
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) skp ON skp.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_ll
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (38,39,51,61) AND srs__ahli_peronda.peronda_jantina = 1
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) ll ON ll.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_lp
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (38,39,51,61) AND srs__ahli_peronda.peronda_jantina = 2
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) lp ON lp.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_age1
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) >= 18 AND TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) <= 21
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) age1 ON age1.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_age2
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) >= 22 AND TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) <= 40
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) age2 ON age2.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_age3
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) >= 41 AND TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) <= 55
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) age3 ON age3.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_age4
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) >= 56 AND TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) <= 70
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) age4 ON age4.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_age5
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) >= 71
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) age5 ON age5.srs_profile_id = srs__profile.id
                WHERE srs__profile.srs_status = 1 AND krt__profile.state_id = '" . Auth::user()->state_id . "'
                GROUP BY ref__states.state_description, ref__daerahs.daerah_description, ref__parlimens.parlimen_description, ref__duns.dun_description, krt__profile.krt_nama,
                        srs__profile.srs_name, a.total_ahli_peronda, ml.total_ml, mp.total_mp, cl.total_cl, cp.total_cp, il.total_il, ip.total_ip, sl.total_sl, sp.total_sp,
                        skl.total_skl, skp.total_skp, ll.total_ll, lp.total_lp, age1.total_age1, age2.total_age2, age3.total_age3, age4.total_age4, age5.total_age5
                    "));
            return Datatables::of($data)
            ->make(true);
        } else {
                $roles_menu     = DB::table('roles__menu')
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
                $daerah = RefDaerah::where('status', '=',  true)
                        ->where('ref__daerahs.state_id', '=', Auth::user()->state_id) 
                        ->orderBy('daerah_description', 'ASC')   
                        ->get();
                $parlimen   = RefParlimen::where('status', '=',  true)
                        ->where('ref__parlimens.state_id', '=', Auth::user()->state_id) 
                        ->orderBy('parlimen_description', 'ASC')    
                        ->get();
            return view('rt-sm31.laporan-ringkasan-peronda-srs-ppn',compact('roles_menu','daerah','parlimen'));
        }
       
    }

    function laporan_ringkasan_peronda_srs_hqsrs(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_description' => $value);
                $data  = DB::table('ref__daerahs')
                        ->select('ref__daerahs.id', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__daerahs.state_id')
                        ->where('ref__states.state_description', '=',  $where)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_parlimen') {
                $value = $request->value;
                $where = array('parlimen_description' => $value);
                $data  = DB::table('ref__parlimens')
                        ->select('ref__parlimens.id', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__parlimens.state_id')
                        ->where('ref__states.state_description', '=',  $where)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_dun') {
                $value = $request->value;
                $where = array('dun_description' => $value);
                $data  = DB::table('ref__duns')
                        ->select('ref__duns.id', 'ref__duns.dun_id', 'ref__duns.dun_description', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description')
                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','ref__duns.parlimen_id')
                        ->where('ref__parlimens.parlimen_description', '=',  $where)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_description' => $value);
                $data  = DB::table('krt__profile')
                        ->select('krt__profile.id', 'krt__profile.krt_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->where('ref__daerahs.daerah_description', '=',  $where)
                        ->where('krt__profile.krt_status', '=',  1)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_srs') {
                $value = $request->value;
                $where = array('krt_nama' => $value);
                $data  = DB::table('srs__profile')
                        ->select('srs__profile.id', 'srs__profile.srs_name', 'krt__profile.id', 'krt__profile.krt_nama')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->where('krt__profile.krt_nama', '=',  $where)
                        ->where('srs__profile.srs_status', '=',  1)
                        ->get();
                return Response::json($data);
            }
            $data = DB::select(DB::raw("
                SELECT
                ref__states.state_description AS negeri,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
                krt__profile.krt_nama AS krt_nama,
                srs__profile.srs_name AS srs_nama,
                (case when a.total_ahli_peronda IS NOT NULL then a.total_ahli_peronda else 0 end)AS total_ahli_peronda,
                (case when ml.total_ml IS NOT NULL then ml.total_ml else 0 end)AS total_ml,
                (case when mp.total_mp IS NOT NULL then mp.total_mp else 0 end)AS total_mp,
                (case when cl.total_cl IS NOT NULL then cl.total_cl else 0 end)AS total_cl,
                (case when cp.total_cp IS NOT NULL then cp.total_cp else 0 end)AS total_cp,
                (case when il.total_il IS NOT NULL then il.total_il else 0 end)AS total_il,
                (case when ip.total_ip IS NOT NULL then ip.total_ip else 0 end)AS total_ip,
                (case when sl.total_sl IS NOT NULL then sl.total_sl else 0 end)AS total_sl,
                (case when sp.total_sp IS NOT NULL then sp.total_sp else 0 end)AS total_sp,
                (case when skl.total_skl IS NOT NULL then skl.total_skl else 0 end)AS total_skl,
                (case when skp.total_skp IS NOT NULL then skp.total_skp else 0 end)AS total_skp,
                (case when ll.total_ll IS NOT NULL then ll.total_ll else 0 end)AS total_ll,
                (case when lp.total_lp IS NOT NULL then lp.total_lp else 0 end)AS total_lp,
                (case when age1.total_age1 IS NOT NULL then age1.total_age1 else 0 end)AS total_age1,
                (case when age2.total_age2 IS NOT NULL then age2.total_age2 else 0 end)AS total_age2,
                (case when age3.total_age3 IS NOT NULL then age3.total_age3 else 0 end)AS total_age3,
                (case when age4.total_age4 IS NOT NULL then age4.total_age4 else 0 end)AS total_age4,
                (case when age5.total_age5 IS NOT NULL then age5.total_age5 else 0 end)AS total_age5
                FROM srs__profile
                LEFT JOIN krt__profile ON krt__profile.id = srs__profile.krt_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
                LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id, 
                        count(*) AS total_ahli_peronda
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) a ON a.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_ml
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (1,2,3,4,5,6,7) AND 
                    srs__ahli_peronda.peronda_jantina = 1
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) ml ON ml.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_mp
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (1,2,3,4,5,6,7) AND 
                    srs__ahli_peronda.peronda_jantina = 2
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) mp ON mp.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_cl
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (8,9,10,11,12,13,14,15,16,17,18,19,20) AND 
                    srs__ahli_peronda.peronda_jantina = 1
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) cl ON cl.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_cp
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (8,9,10,11,12,13,14,15,16,17,18,19,20) AND 
                    srs__ahli_peronda.peronda_jantina = 2
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) cp ON cp.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_il
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37) AND 
                    srs__ahli_peronda.peronda_jantina = 1
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) il ON il.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_ip
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37) AND 
                    srs__ahli_peronda.peronda_jantina = 2
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) ip ON ip.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_sl
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    srs__ahli_peronda.peronda_kaum IN (40,41,42,43,44,45,46,47,48,49,50,52,53,54,55,56,57,58,59,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96) 
                    AND srs__ahli_peronda.peronda_jantina = 1
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) sl ON sl.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_sp
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    srs__ahli_peronda.peronda_kaum IN (40,41,42,43,44,45,46,47,48,49,50,52,53,54,55,56,57,58,59,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96) 
                    AND srs__ahli_peronda.peronda_jantina = 2
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) sp ON sp.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_skl
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    srs__ahli_peronda.peronda_kaum IN (97,98,99,100,101,102,103,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,167,168,169,170,171) 
                    AND srs__ahli_peronda.peronda_jantina = 1
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) skl ON skl.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_skp
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    srs__ahli_peronda.peronda_kaum IN (97,98,99,100,101,102,103,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,167,168,169,170,171) 
                    AND srs__ahli_peronda.peronda_jantina = 2
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) skp ON skp.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_ll
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (38,39,51,61) AND srs__ahli_peronda.peronda_jantina = 1
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) ll ON ll.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_lp
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (38,39,51,61) AND srs__ahli_peronda.peronda_jantina = 2
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) lp ON lp.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_age1
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) >= 18 AND TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) <= 21
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) age1 ON age1.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_age2
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) >= 22 AND TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) <= 40
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) age2 ON age2.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_age3
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) >= 41 AND TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) <= 55
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) age3 ON age3.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_age4
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) >= 56 AND TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) <= 70
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) age4 ON age4.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_age5
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) >= 71
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) age5 ON age5.srs_profile_id = srs__profile.id
                WHERE srs__profile.srs_status = 1
                GROUP BY ref__states.state_description, ref__daerahs.daerah_description, ref__parlimens.parlimen_description, ref__duns.dun_description, krt__profile.krt_nama,
                        srs__profile.srs_name, a.total_ahli_peronda, ml.total_ml, mp.total_mp, cl.total_cl, cp.total_cp, il.total_il, ip.total_ip, sl.total_sl, sp.total_sp,
                        skl.total_skl, skp.total_skp, ll.total_ll, lp.total_lp, age1.total_age1, age2.total_age2, age3.total_age3, age4.total_age4, age5.total_age5
                    "));
            return Datatables::of($data)
            ->make(true);
        } else {
                $roles_menu     = DB::table('roles__menu')
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
            $state      = RefStates::where('status', '=',  true)->get();
            return view('rt-sm31.laporan-ringkasan-peronda-srs-hqsrs',compact('roles_menu','state'));
        }
       
    }

    function laporan_ringkasan_peronda_srs_kp(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_description' => $value);
                $data  = DB::table('ref__daerahs')
                        ->select('ref__daerahs.id', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__daerahs.state_id')
                        ->where('ref__states.state_description', '=',  $where)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_parlimen') {
                $value = $request->value;
                $where = array('parlimen_description' => $value);
                $data  = DB::table('ref__parlimens')
                        ->select('ref__parlimens.id', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__parlimens.state_id')
                        ->where('ref__states.state_description', '=',  $where)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_dun') {
                $value = $request->value;
                $where = array('dun_description' => $value);
                $data  = DB::table('ref__duns')
                        ->select('ref__duns.id', 'ref__duns.dun_id', 'ref__duns.dun_description', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description')
                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','ref__duns.parlimen_id')
                        ->where('ref__parlimens.parlimen_description', '=',  $where)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_description' => $value);
                $data  = DB::table('krt__profile')
                        ->select('krt__profile.id', 'krt__profile.krt_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->where('ref__daerahs.daerah_description', '=',  $where)
                        ->where('krt__profile.krt_status', '=',  1)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_srs') {
                $value = $request->value;
                $where = array('krt_nama' => $value);
                $data  = DB::table('srs__profile')
                        ->select('srs__profile.id', 'srs__profile.srs_name', 'krt__profile.id', 'krt__profile.krt_nama')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->where('krt__profile.krt_nama', '=',  $where)
                        ->where('srs__profile.srs_status', '=',  1)
                        ->get();
                return Response::json($data);
            }
            $data = DB::select(DB::raw("
                SELECT
                ref__states.state_description AS negeri,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
                krt__profile.krt_nama AS krt_nama,
                srs__profile.srs_name AS srs_nama,
                (case when a.total_ahli_peronda IS NOT NULL then a.total_ahli_peronda else 0 end)AS total_ahli_peronda,
                (case when ml.total_ml IS NOT NULL then ml.total_ml else 0 end)AS total_ml,
                (case when mp.total_mp IS NOT NULL then mp.total_mp else 0 end)AS total_mp,
                (case when cl.total_cl IS NOT NULL then cl.total_cl else 0 end)AS total_cl,
                (case when cp.total_cp IS NOT NULL then cp.total_cp else 0 end)AS total_cp,
                (case when il.total_il IS NOT NULL then il.total_il else 0 end)AS total_il,
                (case when ip.total_ip IS NOT NULL then ip.total_ip else 0 end)AS total_ip,
                (case when sl.total_sl IS NOT NULL then sl.total_sl else 0 end)AS total_sl,
                (case when sp.total_sp IS NOT NULL then sp.total_sp else 0 end)AS total_sp,
                (case when skl.total_skl IS NOT NULL then skl.total_skl else 0 end)AS total_skl,
                (case when skp.total_skp IS NOT NULL then skp.total_skp else 0 end)AS total_skp,
                (case when ll.total_ll IS NOT NULL then ll.total_ll else 0 end)AS total_ll,
                (case when lp.total_lp IS NOT NULL then lp.total_lp else 0 end)AS total_lp,
                (case when age1.total_age1 IS NOT NULL then age1.total_age1 else 0 end)AS total_age1,
                (case when age2.total_age2 IS NOT NULL then age2.total_age2 else 0 end)AS total_age2,
                (case when age3.total_age3 IS NOT NULL then age3.total_age3 else 0 end)AS total_age3,
                (case when age4.total_age4 IS NOT NULL then age4.total_age4 else 0 end)AS total_age4,
                (case when age5.total_age5 IS NOT NULL then age5.total_age5 else 0 end)AS total_age5
                FROM srs__profile
                LEFT JOIN krt__profile ON krt__profile.id = srs__profile.krt_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
                LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id, 
                        count(*) AS total_ahli_peronda
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) a ON a.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_ml
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (1,2,3,4,5,6,7) AND 
                    srs__ahli_peronda.peronda_jantina = 1
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) ml ON ml.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_mp
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (1,2,3,4,5,6,7) AND 
                    srs__ahli_peronda.peronda_jantina = 2
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) mp ON mp.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_cl
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (8,9,10,11,12,13,14,15,16,17,18,19,20) AND 
                    srs__ahli_peronda.peronda_jantina = 1
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) cl ON cl.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_cp
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (8,9,10,11,12,13,14,15,16,17,18,19,20) AND 
                    srs__ahli_peronda.peronda_jantina = 2
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) cp ON cp.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_il
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37) AND 
                    srs__ahli_peronda.peronda_jantina = 1
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) il ON il.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_ip
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37) AND 
                    srs__ahli_peronda.peronda_jantina = 2
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) ip ON ip.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_sl
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    srs__ahli_peronda.peronda_kaum IN (40,41,42,43,44,45,46,47,48,49,50,52,53,54,55,56,57,58,59,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96) 
                    AND srs__ahli_peronda.peronda_jantina = 1
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) sl ON sl.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_sp
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    srs__ahli_peronda.peronda_kaum IN (40,41,42,43,44,45,46,47,48,49,50,52,53,54,55,56,57,58,59,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96) 
                    AND srs__ahli_peronda.peronda_jantina = 2
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) sp ON sp.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_skl
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    srs__ahli_peronda.peronda_kaum IN (97,98,99,100,101,102,103,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,167,168,169,170,171) 
                    AND srs__ahli_peronda.peronda_jantina = 1
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) skl ON skl.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_skp
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    srs__ahli_peronda.peronda_kaum IN (97,98,99,100,101,102,103,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,167,168,169,170,171) 
                    AND srs__ahli_peronda.peronda_jantina = 2
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) skp ON skp.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_ll
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (38,39,51,61) AND srs__ahli_peronda.peronda_jantina = 1
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) ll ON ll.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_lp
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.peronda_kaum IN (38,39,51,61) AND srs__ahli_peronda.peronda_jantina = 2
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) lp ON lp.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_age1
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) >= 18 AND TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) <= 21
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) age1 ON age1.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_age2
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) >= 22 AND TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) <= 40
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) age2 ON age2.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_age3
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) >= 41 AND TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) <= 55
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) age3 ON age3.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_age4
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND 
                    TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) >= 56 AND TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) <= 70
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) age4 ON age4.srs_profile_id = srs__profile.id
                LEFT JOIN (
                    SELECT
                        srs__ahli_peronda.srs_profile_id,
                        count(*) AS total_age5
                    FROM srs__ahli_peronda 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__ahli_peronda.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__ahli_peronda.peronda_status = 1 AND TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) >= 71
                    GROUP BY srs__ahli_peronda.srs_profile_id
                ) age5 ON age5.srs_profile_id = srs__profile.id
                WHERE srs__profile.srs_status = 1
                GROUP BY ref__states.state_description, ref__daerahs.daerah_description, ref__parlimens.parlimen_description, ref__duns.dun_description, krt__profile.krt_nama,
                        srs__profile.srs_name, a.total_ahli_peronda, ml.total_ml, mp.total_mp, cl.total_cl, cp.total_cp, il.total_il, ip.total_ip, sl.total_sl, sp.total_sp,
                        skl.total_skl, skp.total_skp, ll.total_ll, lp.total_lp, age1.total_age1, age2.total_age2, age3.total_age3, age4.total_age4, age5.total_age5
                    "));
            return Datatables::of($data)
            ->make(true);
        } else {
                $roles_menu     = DB::table('roles__menu')
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
            $state      = RefStates::where('status', '=',  true)->get();
            return view('rt-sm31.laporan-ringkasan-peronda-srs-kp',compact('roles_menu','state'));
        }
       
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function laporan_rondaan_srs_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_srs') {
                $value = $request->value;
                $where = array('krt_nama' => $value);
                $data  = DB::table('srs__profile')
                        ->select('srs__profile.id', 'srs__profile.srs_name', 'krt__profile.id', 'krt__profile.krt_nama')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->where('krt__profile.krt_nama', '=',  $where)
                        ->where('srs__profile.srs_status', '=',  1)
                        ->orderBy('srs__profile.srs_name', 'ASC')   
                        ->get();
                return Response::json($data);
            }
            $data = DB::select(DB::raw("
            SELECT
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                srs__profile.srs_name AS nama_srs,
                (case when a.total_rondaan_jan IS NOT NULL then a.total_rondaan_jan else 0 end)AS total_rondaan_jan,
                (case when b.total_rondaan_feb IS NOT NULL then b.total_rondaan_feb else 0 end)AS total_rondaan_feb,
                (case when c.total_rondaan_mar IS NOT NULL then c.total_rondaan_mar else 0 end)AS total_rondaan_mar,
                (case when d.total_rondaan_apr IS NOT NULL then d.total_rondaan_apr else 0 end)AS total_rondaan_apr,
                (case when e.total_rondaan_mei IS NOT NULL then e.total_rondaan_mei else 0 end)AS total_rondaan_mei,
                (case when f.total_rondaan_jun IS NOT NULL then f.total_rondaan_jun else 0 end)AS total_rondaan_jun,
                (case when g.total_rondaan_jul IS NOT NULL then g.total_rondaan_jul else 0 end)AS total_rondaan_jul,
                (case when h.total_rondaan_aug IS NOT NULL then h.total_rondaan_aug else 0 end)AS total_rondaan_aug,
                (case when i.total_rondaan_sep IS NOT NULL then i.total_rondaan_sep else 0 end)AS total_rondaan_sep,
                (case when j.total_rondaan_oct IS NOT NULL then j.total_rondaan_oct else 0 end)AS total_rondaan_oct,
                (case when k.total_rondaan_nov IS NOT NULL then k.total_rondaan_nov else 0 end)AS total_rondaan_nov,
                (case when l.total_rondaan_dec IS NOT NULL then l.total_rondaan_dec else 0 end)AS total_rondaan_dec,
                (case when m.total_ahli_peronda IS NOT NULL then m.total_ahli_peronda else 0 end)AS total_ahli_peronda
            FROM srs__profile
            LEFT JOIN krt__profile ON krt__profile.id = srs__profile.krt_id
            LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
            LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_jan
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='1'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) a ON a.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_feb
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='2'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) b ON b.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_mar
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='3'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) c ON c.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_apr
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='4'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) d ON d.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_mei
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='5'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) e ON e.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_jun
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='6'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) f ON f.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_jul
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='7'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) g ON g.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_aug
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='8'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) h ON h.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_sep
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='9'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) i ON i.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_oct
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='10'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) j ON j.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_nov
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='11'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) k ON k.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_dec
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='12'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) l ON l.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_ahli_peronda
                    FROM srs__pelaksanaan_rondaan_ahli 
                    LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_ahli.srs_pelaksanaan_rondaan_id
                    WHERE srs__pelaksanaan_rondaan.id AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) m ON m.srs_profile_id = srs__profile.id
            WHERE srs__profile.srs_status = 1 AND krt__profile.daerah_id = '" . Auth::user()->daerah_id . "'
                    "));
            return Datatables::of($data)
            ->make(true);
        } else {
           $roles_menu  = DB::table('roles__menu')
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
            $krt    = KRT_Profile::where('krt_status', '=',  true)
                        ->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)    
                        ->get();
            return view('rt-sm31.laporan-rondaan-srs-ppd',compact('roles_menu','krt'));
        }
    }
    
    function laporan_rondaan_srs_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_description' => $value);
                $data  = DB::table('krt__profile')
                        ->select('krt__profile.id', 'krt__profile.krt_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->where('ref__daerahs.daerah_description', '=',  $where)
                        ->where('krt__profile.krt_status', '=',  1)
                        ->orderBy('krt__profile.krt_nama', 'ASC')    
                        ->get();
                return Response::json($data);
            } else if($type == 'get_srs') {
                $value = $request->value;
                $where = array('krt_nama' => $value);
                $data  = DB::table('srs__profile')
                        ->select('srs__profile.id', 'srs__profile.srs_name', 'krt__profile.id', 'krt__profile.krt_nama')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->where('krt__profile.krt_nama', '=',  $where)
                        ->where('srs__profile.srs_status', '=',  1)
                        ->orderBy('srs_name', 'ASC')  
                        ->get();
                return Response::json($data);
            }
            $data = DB::select(DB::raw("
            SELECT
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                srs__profile.srs_name AS nama_srs,
                (case when a.total_rondaan_jan IS NOT NULL then a.total_rondaan_jan else 0 end)AS total_rondaan_jan,
                (case when b.total_rondaan_feb IS NOT NULL then b.total_rondaan_feb else 0 end)AS total_rondaan_feb,
                (case when c.total_rondaan_mar IS NOT NULL then c.total_rondaan_mar else 0 end)AS total_rondaan_mar,
                (case when d.total_rondaan_apr IS NOT NULL then d.total_rondaan_apr else 0 end)AS total_rondaan_apr,
                (case when e.total_rondaan_mei IS NOT NULL then e.total_rondaan_mei else 0 end)AS total_rondaan_mei,
                (case when f.total_rondaan_jun IS NOT NULL then f.total_rondaan_jun else 0 end)AS total_rondaan_jun,
                (case when g.total_rondaan_jul IS NOT NULL then g.total_rondaan_jul else 0 end)AS total_rondaan_jul,
                (case when h.total_rondaan_aug IS NOT NULL then h.total_rondaan_aug else 0 end)AS total_rondaan_aug,
                (case when i.total_rondaan_sep IS NOT NULL then i.total_rondaan_sep else 0 end)AS total_rondaan_sep,
                (case when j.total_rondaan_oct IS NOT NULL then j.total_rondaan_oct else 0 end)AS total_rondaan_oct,
                (case when k.total_rondaan_nov IS NOT NULL then k.total_rondaan_nov else 0 end)AS total_rondaan_nov,
                (case when l.total_rondaan_dec IS NOT NULL then l.total_rondaan_dec else 0 end)AS total_rondaan_dec,
                (case when m.total_ahli_peronda IS NOT NULL then m.total_ahli_peronda else 0 end)AS total_ahli_peronda
            FROM srs__profile
            LEFT JOIN krt__profile ON krt__profile.id = srs__profile.krt_id
            LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
            LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_jan
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='1'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) a ON a.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_feb
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='2'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) b ON b.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_mar
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='3'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) c ON c.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_apr
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='4'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) d ON d.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_mei
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='5'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) e ON e.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_jun
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='6'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) f ON f.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_jul
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='7'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) g ON g.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_aug
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='8'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) h ON h.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_sep
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='9'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) i ON i.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_oct
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='10'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) j ON j.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_nov
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='11'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) k ON k.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_dec
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='12'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) l ON l.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_ahli_peronda
                    FROM srs__pelaksanaan_rondaan_ahli 
                    LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_ahli.srs_pelaksanaan_rondaan_id
                    WHERE srs__pelaksanaan_rondaan.id AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) m ON m.srs_profile_id = srs__profile.id
            WHERE srs__profile.srs_status = 1 AND krt__profile.state_id = '" . Auth::user()->state_id . "'
                    "));
            return Datatables::of($data)
            ->make(true);
        } else {
                $roles_menu     = DB::table('roles__menu')
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
            $daerah = RefDaerah::where('status', '=',  true)
                        ->where('ref__daerahs.state_id', '=', Auth::user()->state_id) 
                        ->orderBy('daerah_description', 'ASC')   
                        ->get();
            $parlimen   = RefParlimen::where('status', '=',  true)
                        ->where('ref__parlimens.state_id', '=', Auth::user()->state_id) 
                        ->orderBy('parlimen_description', 'ASC')    
                        ->get();
            return view('rt-sm31.laporan-rondaan-srs-ppn',compact('roles_menu','daerah','parlimen'));
        }
    }

    function laporan_rondaan_srs_ppn_filter(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_description' => $value);
                $data  = DB::table('krt__profile')
                        ->select('krt__profile.id', 'krt__profile.krt_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->where('ref__daerahs.daerah_description', '=',  $where)
                        ->where('krt__profile.krt_status', '=',  1)
                        ->orderBy('krt__profile.krt_nama', 'ASC')  
                        ->get();
                return Response::json($data);
            } else if($type == 'get_srs') {
                $value = $request->value;
                $where = array('krt_nama' => $value);
                $data  = DB::table('srs__profile')
                        ->select('srs__profile.id', 'srs__profile.srs_name', 'krt__profile.id', 'krt__profile.krt_nama')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->where('krt__profile.krt_nama', '=',  $where)
                        ->where('srs__profile.srs_status', '=',  1)
                        ->orderBy('srs_name', 'ASC')  
                        ->get();
                return Response::json($data);
            }
            $data = DB::select(DB::raw("
            SELECT
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                srs__profile.srs_name AS nama_srs,
                (case when a.total_rondaan_jan IS NOT NULL then a.total_rondaan_jan else 0 end)AS total_rondaan_jan,
                (case when b.total_rondaan_feb IS NOT NULL then b.total_rondaan_feb else 0 end)AS total_rondaan_feb,
                (case when c.total_rondaan_mar IS NOT NULL then c.total_rondaan_mar else 0 end)AS total_rondaan_mar,
                (case when d.total_rondaan_apr IS NOT NULL then d.total_rondaan_apr else 0 end)AS total_rondaan_apr,
                (case when e.total_rondaan_mei IS NOT NULL then e.total_rondaan_mei else 0 end)AS total_rondaan_mei,
                (case when f.total_rondaan_jun IS NOT NULL then f.total_rondaan_jun else 0 end)AS total_rondaan_jun,
                (case when g.total_rondaan_jul IS NOT NULL then g.total_rondaan_jul else 0 end)AS total_rondaan_jul,
                (case when h.total_rondaan_aug IS NOT NULL then h.total_rondaan_aug else 0 end)AS total_rondaan_aug,
                (case when i.total_rondaan_sep IS NOT NULL then i.total_rondaan_sep else 0 end)AS total_rondaan_sep,
                (case when j.total_rondaan_oct IS NOT NULL then j.total_rondaan_oct else 0 end)AS total_rondaan_oct,
                (case when k.total_rondaan_nov IS NOT NULL then k.total_rondaan_nov else 0 end)AS total_rondaan_nov,
                (case when l.total_rondaan_dec IS NOT NULL then l.total_rondaan_dec else 0 end)AS total_rondaan_dec,
                (case when m.total_ahli_peronda IS NOT NULL then m.total_ahli_peronda else 0 end)AS total_ahli_peronda
            FROM srs__profile
            LEFT JOIN krt__profile ON krt__profile.id = srs__profile.krt_id
            LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
            LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_jan
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='1'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= $id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) a ON a.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_feb
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='2'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) b ON b.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_mar
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='3'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) c ON c.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_apr
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='4'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) d ON d.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_mei
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='5'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) e ON e.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_jun
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='6'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) f ON f.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_jul
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='7'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) g ON g.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_aug
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='8'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) h ON h.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_sep
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='9'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) i ON i.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_oct
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='10'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) j ON j.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_nov
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='11'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) k ON k.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_dec
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='12'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) l ON l.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_ahli_peronda
                    FROM srs__pelaksanaan_rondaan_ahli 
                    LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_ahli.srs_pelaksanaan_rondaan_id
                    WHERE srs__pelaksanaan_rondaan.id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) m ON m.srs_profile_id = srs__profile.id
            WHERE srs__profile.srs_status = 1 AND krt__profile.state_id = '" . Auth::user()->state_id . "'
                    "));
            return Datatables::of($data)
            ->make(true);
        } else {
                $roles_menu     = DB::table('roles__menu')
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
            $daerah = RefDaerah::where('status', '=',  true)
                        ->where('ref__daerahs.state_id', '=', Auth::user()->state_id) 
                        ->orderBy('daerah_description', 'ASC')   
                        ->get();
            $parlimen   = RefParlimen::where('status', '=',  true)
                        ->where('ref__parlimens.state_id', '=', Auth::user()->state_id) 
                        ->orderBy('parlimen_description', 'ASC')    
                        ->get();
            return view('rt-sm31.laporan-rondaan-srs-ppn',compact('roles_menu','daerah','parlimen'));
        }
    }

    function laporan_rondaan_srs_hqsrs(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_description' => $value);
                $data  = DB::table('ref__daerahs')
                        ->select('ref__daerahs.id', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__daerahs.state_id')
                        ->where('ref__states.state_description', '=',  $where)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_description' => $value);
                $data  = DB::table('krt__profile')
                        ->select('krt__profile.id', 'krt__profile.krt_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->where('ref__daerahs.daerah_description', '=',  $where)
                        ->where('krt__profile.krt_status', '=',  1)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_srs') {
                $value = $request->value;
                $where = array('krt_nama' => $value);
                $data  = DB::table('srs__profile')
                        ->select('srs__profile.id', 'srs__profile.srs_name', 'krt__profile.id', 'krt__profile.krt_nama')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->where('krt__profile.krt_nama', '=',  $where)
                        ->where('srs__profile.srs_status', '=',  1)
                        ->get();
                return Response::json($data);
            }
            $data = DB::select(DB::raw("
            SELECT
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                srs__profile.srs_name AS nama_srs,
                (case when a.total_rondaan_jan IS NOT NULL then a.total_rondaan_jan else 0 end)AS total_rondaan_jan,
                (case when b.total_rondaan_feb IS NOT NULL then b.total_rondaan_feb else 0 end)AS total_rondaan_feb,
                (case when c.total_rondaan_mar IS NOT NULL then c.total_rondaan_mar else 0 end)AS total_rondaan_mar,
                (case when d.total_rondaan_apr IS NOT NULL then d.total_rondaan_apr else 0 end)AS total_rondaan_apr,
                (case when e.total_rondaan_mei IS NOT NULL then e.total_rondaan_mei else 0 end)AS total_rondaan_mei,
                (case when f.total_rondaan_jun IS NOT NULL then f.total_rondaan_jun else 0 end)AS total_rondaan_jun,
                (case when g.total_rondaan_jul IS NOT NULL then g.total_rondaan_jul else 0 end)AS total_rondaan_jul,
                (case when h.total_rondaan_aug IS NOT NULL then h.total_rondaan_aug else 0 end)AS total_rondaan_aug,
                (case when i.total_rondaan_sep IS NOT NULL then i.total_rondaan_sep else 0 end)AS total_rondaan_sep,
                (case when j.total_rondaan_oct IS NOT NULL then j.total_rondaan_oct else 0 end)AS total_rondaan_oct,
                (case when k.total_rondaan_nov IS NOT NULL then k.total_rondaan_nov else 0 end)AS total_rondaan_nov,
                (case when l.total_rondaan_dec IS NOT NULL then l.total_rondaan_dec else 0 end)AS total_rondaan_dec,
                (case when m.total_ahli_peronda IS NOT NULL then m.total_ahli_peronda else 0 end)AS total_ahli_peronda
            FROM srs__profile
            LEFT JOIN krt__profile ON krt__profile.id = srs__profile.krt_id
            LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
            LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_jan
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='1'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) a ON a.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_feb
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='2'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) b ON b.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_mar
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='3'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) c ON c.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_apr
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='4'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) d ON d.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_mei
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='5'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) e ON e.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_jun
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='6'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) f ON f.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_jul
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='7'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) g ON g.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_aug
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='8'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) h ON h.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_sep
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='9'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) i ON i.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_oct
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='10'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) j ON j.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_nov
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='11'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) k ON k.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_dec
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='12'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) l ON l.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_ahli_peronda
                    FROM srs__pelaksanaan_rondaan_ahli 
                    LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_ahli.srs_pelaksanaan_rondaan_id
                    WHERE srs__pelaksanaan_rondaan.id AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) m ON m.srs_profile_id = srs__profile.id
            WHERE srs__profile.srs_status = 1 
                    "));
            return Datatables::of($data)
            ->make(true);
        } else {
                $roles_menu     = DB::table('roles__menu')
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
            $state      = RefStates::where('status', '=',  true)->get();
            return view('rt-sm31.laporan-rondaan-srs-hqsrs',compact('roles_menu','state'));
        }
    }

    function laporan_rondaan_srs_hqsrs_filter(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_description' => $value);
                $data  = DB::table('ref__daerahs')
                        ->select('ref__daerahs.id', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__daerahs.state_id')
                        ->where('ref__states.state_description', '=',  $where)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_description' => $value);
                $data  = DB::table('krt__profile')
                        ->select('krt__profile.id', 'krt__profile.krt_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->where('ref__daerahs.daerah_description', '=',  $where)
                        ->where('krt__profile.krt_status', '=',  1)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_srs') {
                $value = $request->value;
                $where = array('krt_nama' => $value);
                $data  = DB::table('srs__profile')
                        ->select('srs__profile.id', 'srs__profile.srs_name', 'krt__profile.id', 'krt__profile.krt_nama')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->where('krt__profile.krt_nama', '=',  $where)
                        ->where('srs__profile.srs_status', '=',  1)
                        ->get();
                return Response::json($data);
            }
            $data = DB::select(DB::raw("
            SELECT
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                srs__profile.srs_name AS nama_srs,
                (case when a.total_rondaan_jan IS NOT NULL then a.total_rondaan_jan else 0 end)AS total_rondaan_jan,
                (case when b.total_rondaan_feb IS NOT NULL then b.total_rondaan_feb else 0 end)AS total_rondaan_feb,
                (case when c.total_rondaan_mar IS NOT NULL then c.total_rondaan_mar else 0 end)AS total_rondaan_mar,
                (case when d.total_rondaan_apr IS NOT NULL then d.total_rondaan_apr else 0 end)AS total_rondaan_apr,
                (case when e.total_rondaan_mei IS NOT NULL then e.total_rondaan_mei else 0 end)AS total_rondaan_mei,
                (case when f.total_rondaan_jun IS NOT NULL then f.total_rondaan_jun else 0 end)AS total_rondaan_jun,
                (case when g.total_rondaan_jul IS NOT NULL then g.total_rondaan_jul else 0 end)AS total_rondaan_jul,
                (case when h.total_rondaan_aug IS NOT NULL then h.total_rondaan_aug else 0 end)AS total_rondaan_aug,
                (case when i.total_rondaan_sep IS NOT NULL then i.total_rondaan_sep else 0 end)AS total_rondaan_sep,
                (case when j.total_rondaan_oct IS NOT NULL then j.total_rondaan_oct else 0 end)AS total_rondaan_oct,
                (case when k.total_rondaan_nov IS NOT NULL then k.total_rondaan_nov else 0 end)AS total_rondaan_nov,
                (case when l.total_rondaan_dec IS NOT NULL then l.total_rondaan_dec else 0 end)AS total_rondaan_dec,
                (case when m.total_ahli_peronda IS NOT NULL then m.total_ahli_peronda else 0 end)AS total_ahli_peronda
            FROM srs__profile
            LEFT JOIN krt__profile ON krt__profile.id = srs__profile.krt_id
            LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
            LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_jan
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='1'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= $id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) a ON a.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_feb
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='2'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) b ON b.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_mar
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='3'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) c ON c.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_apr
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='4'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) d ON d.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_mei
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='5'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) e ON e.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_jun
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='6'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) f ON f.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_jul
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='7'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) g ON g.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_aug
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='8'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) h ON h.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_sep
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='9'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) i ON i.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_oct
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='10'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) j ON j.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_nov
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='11'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) k ON k.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_dec
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='12'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) l ON l.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_ahli_peronda
                    FROM srs__pelaksanaan_rondaan_ahli 
                    LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_ahli.srs_pelaksanaan_rondaan_id
                    WHERE srs__pelaksanaan_rondaan.id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) m ON m.srs_profile_id = srs__profile.id
            WHERE srs__profile.srs_status = 1 
                    "));
            return Datatables::of($data)
            ->make(true);
        } else {
                $roles_menu     = DB::table('roles__menu')
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
            $state      = RefStates::where('status', '=',  true)->get();
            return view('rt-sm31.laporan-rondaan-srs-hqsrs',compact('roles_menu','state'));
        }
    }

    function laporan_rondaan_srs_kp(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_description' => $value);
                $data  = DB::table('ref__daerahs')
                        ->select('ref__daerahs.id', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__daerahs.state_id')
                        ->where('ref__states.state_description', '=',  $where)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_description' => $value);
                $data  = DB::table('krt__profile')
                        ->select('krt__profile.id', 'krt__profile.krt_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->where('ref__daerahs.daerah_description', '=',  $where)
                        ->where('krt__profile.krt_status', '=',  1)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_srs') {
                $value = $request->value;
                $where = array('krt_nama' => $value);
                $data  = DB::table('srs__profile')
                        ->select('srs__profile.id', 'srs__profile.srs_name', 'krt__profile.id', 'krt__profile.krt_nama')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->where('krt__profile.krt_nama', '=',  $where)
                        ->where('srs__profile.srs_status', '=',  1)
                        ->get();
                return Response::json($data);
            }
            $data = DB::select(DB::raw("
            SELECT
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                srs__profile.srs_name AS nama_srs,
                (case when a.total_rondaan_jan IS NOT NULL then a.total_rondaan_jan else 0 end)AS total_rondaan_jan,
                (case when b.total_rondaan_feb IS NOT NULL then b.total_rondaan_feb else 0 end)AS total_rondaan_feb,
                (case when c.total_rondaan_mar IS NOT NULL then c.total_rondaan_mar else 0 end)AS total_rondaan_mar,
                (case when d.total_rondaan_apr IS NOT NULL then d.total_rondaan_apr else 0 end)AS total_rondaan_apr,
                (case when e.total_rondaan_mei IS NOT NULL then e.total_rondaan_mei else 0 end)AS total_rondaan_mei,
                (case when f.total_rondaan_jun IS NOT NULL then f.total_rondaan_jun else 0 end)AS total_rondaan_jun,
                (case when g.total_rondaan_jul IS NOT NULL then g.total_rondaan_jul else 0 end)AS total_rondaan_jul,
                (case when h.total_rondaan_aug IS NOT NULL then h.total_rondaan_aug else 0 end)AS total_rondaan_aug,
                (case when i.total_rondaan_sep IS NOT NULL then i.total_rondaan_sep else 0 end)AS total_rondaan_sep,
                (case when j.total_rondaan_oct IS NOT NULL then j.total_rondaan_oct else 0 end)AS total_rondaan_oct,
                (case when k.total_rondaan_nov IS NOT NULL then k.total_rondaan_nov else 0 end)AS total_rondaan_nov,
                (case when l.total_rondaan_dec IS NOT NULL then l.total_rondaan_dec else 0 end)AS total_rondaan_dec,
                (case when m.total_ahli_peronda IS NOT NULL then m.total_ahli_peronda else 0 end)AS total_ahli_peronda
            FROM srs__profile
            LEFT JOIN krt__profile ON krt__profile.id = srs__profile.krt_id
            LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
            LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_jan
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='1'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) a ON a.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_feb
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='2'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) b ON b.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_mar
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='3'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) c ON c.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_apr
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='4'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) d ON d.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_mei
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='5'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) e ON e.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_jun
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='6'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) f ON f.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_jul
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='7'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) g ON g.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_aug
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='8'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) h ON h.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_sep
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='9'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) i ON i.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_oct
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='10'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) j ON j.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_nov
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='11'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) k ON k.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_dec
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='12'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) l ON l.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_ahli_peronda
                    FROM srs__pelaksanaan_rondaan_ahli 
                    LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_ahli.srs_pelaksanaan_rondaan_id
                    WHERE srs__pelaksanaan_rondaan.id AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=YEAR(CURDATE())
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) m ON m.srs_profile_id = srs__profile.id
            WHERE srs__profile.srs_status = 1 
                    "));
            return Datatables::of($data)
            ->make(true);
        } else {
                $roles_menu     = DB::table('roles__menu')
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
            $state      = RefStates::where('status', '=',  true)->get();
            return view('rt-sm31.laporan-rondaan-srs-kp',compact('roles_menu','state'));
        }
    }

    function laporan_rondaan_srs_kp_filter(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_description' => $value);
                $data  = DB::table('ref__daerahs')
                        ->select('ref__daerahs.id', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__daerahs.state_id')
                        ->where('ref__states.state_description', '=',  $where)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_description' => $value);
                $data  = DB::table('krt__profile')
                        ->select('krt__profile.id', 'krt__profile.krt_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->where('ref__daerahs.daerah_description', '=',  $where)
                        ->where('krt__profile.krt_status', '=',  1)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_srs') {
                $value = $request->value;
                $where = array('krt_nama' => $value);
                $data  = DB::table('srs__profile')
                        ->select('srs__profile.id', 'srs__profile.srs_name', 'krt__profile.id', 'krt__profile.krt_nama')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->where('krt__profile.krt_nama', '=',  $where)
                        ->where('srs__profile.srs_status', '=',  1)
                        ->get();
                return Response::json($data);
            }
            $data = DB::select(DB::raw("
            SELECT
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                srs__profile.srs_name AS nama_srs,
                (case when a.total_rondaan_jan IS NOT NULL then a.total_rondaan_jan else 0 end)AS total_rondaan_jan,
                (case when b.total_rondaan_feb IS NOT NULL then b.total_rondaan_feb else 0 end)AS total_rondaan_feb,
                (case when c.total_rondaan_mar IS NOT NULL then c.total_rondaan_mar else 0 end)AS total_rondaan_mar,
                (case when d.total_rondaan_apr IS NOT NULL then d.total_rondaan_apr else 0 end)AS total_rondaan_apr,
                (case when e.total_rondaan_mei IS NOT NULL then e.total_rondaan_mei else 0 end)AS total_rondaan_mei,
                (case when f.total_rondaan_jun IS NOT NULL then f.total_rondaan_jun else 0 end)AS total_rondaan_jun,
                (case when g.total_rondaan_jul IS NOT NULL then g.total_rondaan_jul else 0 end)AS total_rondaan_jul,
                (case when h.total_rondaan_aug IS NOT NULL then h.total_rondaan_aug else 0 end)AS total_rondaan_aug,
                (case when i.total_rondaan_sep IS NOT NULL then i.total_rondaan_sep else 0 end)AS total_rondaan_sep,
                (case when j.total_rondaan_oct IS NOT NULL then j.total_rondaan_oct else 0 end)AS total_rondaan_oct,
                (case when k.total_rondaan_nov IS NOT NULL then k.total_rondaan_nov else 0 end)AS total_rondaan_nov,
                (case when l.total_rondaan_dec IS NOT NULL then l.total_rondaan_dec else 0 end)AS total_rondaan_dec,
                (case when m.total_ahli_peronda IS NOT NULL then m.total_ahli_peronda else 0 end)AS total_ahli_peronda
            FROM srs__profile
            LEFT JOIN krt__profile ON krt__profile.id = srs__profile.krt_id
            LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
            LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_jan
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='1'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)= $id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) a ON a.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_feb
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='2'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) b ON b.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_mar
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='3'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) c ON c.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_apr
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='4'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) d ON d.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_mei
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='5'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) e ON e.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_jun
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='6'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) f ON f.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_jul
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='7'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) g ON g.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_aug
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='8'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) h ON h.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_sep
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='9'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) i ON i.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_oct
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='10'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) j ON j.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_nov
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='11'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) k ON k.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_rondaan_dec
                    FROM srs__pelaksanaan_rondaan 
                    LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id
                    WHERE srs__profile.srs_status = 1 AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 AND MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)='12'
                    AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)=$id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) l ON l.srs_profile_id = srs__profile.id
            LEFT JOIN (
                    SELECT
                            srs__pelaksanaan_rondaan.srs_profile_id, 
                            count(*) AS total_ahli_peronda
                    FROM srs__pelaksanaan_rondaan_ahli 
                    LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_ahli.srs_pelaksanaan_rondaan_id
                    WHERE srs__pelaksanaan_rondaan.id
                    GROUP BY srs__pelaksanaan_rondaan.srs_profile_id
            ) m ON m.srs_profile_id = srs__profile.id
            WHERE srs__profile.srs_status = 1 
                    "));
            return Datatables::of($data)
            ->make(true);
        } else {
                $roles_menu     = DB::table('roles__menu')
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
            $state      = RefStates::where('status', '=',  true)->get();
            return view('rt-sm31.laporan-rondaan-srs-kp',compact('roles_menu','state'));
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function laporan_pengendalian_kes_srs_ppd(Request $request){
        if($request->ajax()){ 
                $type = $request->type;
                if($type == 'get_srs') {
                        $value = $request->value;
                        $where = array('krt_nama' => $value);
                        $data  = DB::table('srs__profile')
                                ->select('srs__profile.id', 'srs__profile.srs_name', 'krt__profile.id', 'krt__profile.krt_nama')
                                ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                                ->where('krt__profile.krt_nama', '=',  $where)
                                ->where('srs__profile.srs_status', '=',  1)
                                ->orderBy('srs__profile.srs_name', 'ASC')   
                                ->get();
                        return Response::json($data);
                    }
                $data = DB::select(DB::raw("
                SELECT 
                ref__states.state_description AS state, 
                ref__daerahs.daerah_description AS daerah, 
                krt__profile.krt_nama AS nama_krt, 
                srs__profile.srs_name AS nama_srs, 
                ref__srs_kategori_kes.kategori_description AS kategori_kes, 
                ref__srs_jenis_kes.jenis_description AS jenis_kes, 
                srs__pelaksanaan_rondaan.kes_jumlah_org_terlibat AS jumlah_terlibat, 
                (case when ml.total_ml IS NOT NULL then ml.total_ml else 0 end)AS total_ml,
                (case when mp.total_mp IS NOT NULL then mp.total_mp else 0 end)AS total_mp,
                (case when cl.total_cl IS NOT NULL then cl.total_cl else 0 end)AS total_cl,
                (case when cp.total_cp IS NOT NULL then cp.total_cp else 0 end)AS total_cp,
                (case when il.total_il IS NOT NULL then il.total_il else 0 end)AS total_il,
                (case when ip.total_ip IS NOT NULL then ip.total_ip else 0 end)AS total_ip,
                (case when sbl.total_sbl IS NOT NULL then sbl.total_sbl else 0 end)AS total_sbl,
                (case when sbp.total_sbp IS NOT NULL then sbp.total_sbp else 0 end)AS total_sbp,
                (case when swl.total_swl IS NOT NULL then swl.total_swl else 0 end)AS total_swl,
                (case when swp.total_swp IS NOT NULL then swp.total_swp else 0 end)AS total_swp,
                (case when age1.total_age1 IS NOT NULL then age1.total_age1 else 0 end)AS total_age1,
                (case when age2.total_age2 IS NOT NULL then age2.total_age2 else 0 end)AS total_age2,
                (case when age3.total_age3 IS NOT NULL then age3.total_age3 else 0 end)AS total_age3,
                (case when age4.total_age4 IS NOT NULL then age4.total_age4 else 0 end)AS total_age4,
                (case when age5.total_age5 IS NOT NULL then age5.total_age5 else 0 end)AS total_age5,
                ref__srs_dirujuk_kes.rujuk_description AS kes_dirujuk 
                FROM 
                srs__pelaksanaan_rondaan 
                LEFT JOIN krt__profile ON krt__profile.id = srs__pelaksanaan_rondaan.krt_profile_id 
                LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id 
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id 
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id 
                LEFT JOIN ref__srs_kategori_kes ON ref__srs_kategori_kes.id = srs__pelaksanaan_rondaan.kategori_kes_id 
                LEFT JOIN ref__srs_jenis_kes ON ref__srs_jenis_kes.id = srs__pelaksanaan_rondaan.jenis_kes_id 
                LEFT JOIN ref__srs_dirujuk_kes ON ref__srs_dirujuk_kes.id = srs__pelaksanaan_rondaan.kes_dirujuk_id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_ml 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (1, 2, 3, 4, 5, 6, 7) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) ml ON ml.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_mp 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (1, 2, 3, 4, 5, 6, 7) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) mp ON mp.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_cl 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 
                        19, 20
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) cl ON cl.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_cp 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 
                        19, 20
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) cp ON cp.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_il 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 
                        32, 33, 34, 35, 36, 37
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) il ON il.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_ip 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 
                        32, 33, 34, 35, 36, 37
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) ip ON ip.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_sbl 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 
                        52, 53, 54, 55, 56, 57, 58, 59, 62, 63, 
                        64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 
                        74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 
                        84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 
                        94, 95, 96
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) sbl ON sbl.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_sbp 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 
                        52, 53, 54, 55, 56, 57, 58, 59, 62, 63, 
                        64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 
                        74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 
                        84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 
                        94, 95, 96
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) sbp ON sbp.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_swl 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        97, 98, 99, 100, 101, 102, 103, 105, 106, 
                        107, 108, 109, 110, 111, 112, 113, 114, 
                        115, 116, 117, 118, 119, 120, 121, 122, 
                        123, 124, 125, 126, 127, 128, 129, 130, 
                        131, 132, 133, 134, 135, 136, 137, 138, 
                        139, 140, 141, 142, 143, 144, 145, 146, 
                        147, 148, 149, 150, 151, 152, 153, 154, 
                        155, 156, 157, 158, 159, 160, 161, 162, 
                        163, 164, 165, 167, 168, 169, 170, 171
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) swl ON swl.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_swp 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        97, 98, 99, 100, 101, 102, 103, 105, 106, 
                        107, 108, 109, 110, 111, 112, 113, 114, 
                        115, 116, 117, 118, 119, 120, 121, 122, 
                        123, 124, 125, 126, 127, 128, 129, 130, 
                        131, 132, 133, 134, 135, 136, 137, 138, 
                        139, 140, 141, 142, 143, 144, 145, 146, 
                        147, 148, 149, 150, 151, 152, 153, 154, 
                        155, 156, 157, 158, 159, 160, 161, 162, 
                        163, 164, 165, 167, 168, 169, 170, 171
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) swp ON swp.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age1 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 18 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur <= 21 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age1 ON age1.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age2 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 22 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur <= 40 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age2 ON age2.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age3 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 41 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur <= 55 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age3 ON age3.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age4 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 56 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur <= 70 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age4 ON age4.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age5 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 71 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age5 ON age5.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_kes = 'Ada' 
                AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = '1'
                AND krt__profile.daerah_id = '" . Auth::user()->daerah_id . "'
                AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh) = YEAR(CURDATE())
                "));
                return Datatables::of($data)
                ->make(true);
        } else {
                $roles_menu     = DB::table('roles__menu')
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
                $krt    = KRT_Profile::where('krt_status', '=',  true)
                        ->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)    
                        ->get();
                return view('rt-sm31.laporan-pengendalian-kes-srs-ppd',compact('roles_menu','krt'));
        }    
    }
    
    function laporan_pengendalian_kes_srs_ppn(Request $request){
        if($request->ajax()){ 
                $type = $request->type;
                if($type == 'get_parlimen') {
                    $value = $request->value;
                    $where = array('parlimen_description' => $value);
                    $data  = DB::table('ref__parlimens')
                            ->select('ref__parlimens.id', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description', 'ref__states.state_id', 'ref__states.state_description')
                            ->leftJoin('ref__states','ref__states.state_id','=','ref__parlimens.state_id')
                            ->where('ref__states.state_description', '=',  $where)
                            ->orderBy('ref__parlimens.parlimen_description', 'ASC')
                            ->get();
                    return Response::json($data);
                } else if($type == 'get_dun') {
                    $value = $request->value;
                    $where = array('dun_description' => $value);
                    $data  = DB::table('ref__duns')
                            ->select('ref__duns.id', 'ref__duns.dun_id', 'ref__duns.dun_description', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description')
                            ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','ref__duns.parlimen_id')
                            ->where('ref__parlimens.parlimen_description', '=',  $where)
                            ->orderBy('ref__duns.dun_description', 'ASC')
                            ->get();
                    return Response::json($data);
                } else if($type == 'get_krt') {
                    $value = $request->value;
                    $where = array('daerah_description' => $value);
                    $data  = DB::table('krt__profile')
                            ->select('krt__profile.id', 'krt__profile.krt_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                            ->where('ref__daerahs.daerah_description', '=',  $where)
                            ->where('krt__profile.krt_status', '=',  1)
                            ->orderBy('krt__profile.krt_nama', 'ASC')
                            ->get();
                    return Response::json($data);
                } else if($type == 'get_srs') {
                    $value = $request->value;
                    $where = array('krt_nama' => $value);
                    $data  = DB::table('srs__profile')
                            ->select('srs__profile.id', 'srs__profile.srs_name', 'krt__profile.id', 'krt__profile.krt_nama')
                            ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                            ->where('krt__profile.krt_nama', '=',  $where)
                            ->where('srs__profile.srs_status', '=',  1)
                            ->orderBy('srs__profile.srs_name', 'ASC')
                            ->get();
                    return Response::json($data);
                }
                $data = DB::select(DB::raw("
                SELECT 
                ref__states.state_description AS state, 
                ref__daerahs.daerah_description AS daerah, 
                krt__profile.krt_nama AS nama_krt, 
                srs__profile.srs_name AS nama_srs, 
                ref__srs_kategori_kes.kategori_description AS kategori_kes, 
                ref__srs_jenis_kes.jenis_description AS jenis_kes, 
                srs__pelaksanaan_rondaan.kes_jumlah_org_terlibat AS jumlah_terlibat, 
                (case when ml.total_ml IS NOT NULL then ml.total_ml else 0 end)AS total_ml,
                (case when mp.total_mp IS NOT NULL then mp.total_mp else 0 end)AS total_mp,
                (case when cl.total_cl IS NOT NULL then cl.total_cl else 0 end)AS total_cl,
                (case when cp.total_cp IS NOT NULL then cp.total_cp else 0 end)AS total_cp,
                (case when il.total_il IS NOT NULL then il.total_il else 0 end)AS total_il,
                (case when ip.total_ip IS NOT NULL then ip.total_ip else 0 end)AS total_ip,
                (case when sbl.total_sbl IS NOT NULL then sbl.total_sbl else 0 end)AS total_sbl,
                (case when sbp.total_sbp IS NOT NULL then sbp.total_sbp else 0 end)AS total_sbp,
                (case when swl.total_swl IS NOT NULL then swl.total_swl else 0 end)AS total_swl,
                (case when swp.total_swp IS NOT NULL then swp.total_swp else 0 end)AS total_swp,
                (case when age1.total_age1 IS NOT NULL then age1.total_age1 else 0 end)AS total_age1,
                (case when age2.total_age2 IS NOT NULL then age2.total_age2 else 0 end)AS total_age2,
                (case when age3.total_age3 IS NOT NULL then age3.total_age3 else 0 end)AS total_age3,
                (case when age4.total_age4 IS NOT NULL then age4.total_age4 else 0 end)AS total_age4,
                (case when age5.total_age5 IS NOT NULL then age5.total_age5 else 0 end)AS total_age5,
                ref__srs_dirujuk_kes.rujuk_description AS kes_dirujuk 
                FROM 
                srs__pelaksanaan_rondaan 
                LEFT JOIN krt__profile ON krt__profile.id = srs__pelaksanaan_rondaan.krt_profile_id 
                LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id 
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id 
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id 
                LEFT JOIN ref__srs_kategori_kes ON ref__srs_kategori_kes.id = srs__pelaksanaan_rondaan.kategori_kes_id 
                LEFT JOIN ref__srs_jenis_kes ON ref__srs_jenis_kes.id = srs__pelaksanaan_rondaan.jenis_kes_id 
                LEFT JOIN ref__srs_dirujuk_kes ON ref__srs_dirujuk_kes.id = srs__pelaksanaan_rondaan.kes_dirujuk_id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_ml 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (1, 2, 3, 4, 5, 6, 7) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) ml ON ml.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_mp 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (1, 2, 3, 4, 5, 6, 7) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) mp ON mp.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_cl 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 
                        19, 20
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) cl ON cl.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_cp 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 
                        19, 20
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) cp ON cp.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_il 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 
                        32, 33, 34, 35, 36, 37
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) il ON il.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_ip 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 
                        32, 33, 34, 35, 36, 37
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) ip ON ip.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_sbl 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 
                        52, 53, 54, 55, 56, 57, 58, 59, 62, 63, 
                        64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 
                        74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 
                        84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 
                        94, 95, 96
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) sbl ON sbl.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_sbp 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 
                        52, 53, 54, 55, 56, 57, 58, 59, 62, 63, 
                        64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 
                        74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 
                        84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 
                        94, 95, 96
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) sbp ON sbp.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_swl 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        97, 98, 99, 100, 101, 102, 103, 105, 106, 
                        107, 108, 109, 110, 111, 112, 113, 114, 
                        115, 116, 117, 118, 119, 120, 121, 122, 
                        123, 124, 125, 126, 127, 128, 129, 130, 
                        131, 132, 133, 134, 135, 136, 137, 138, 
                        139, 140, 141, 142, 143, 144, 145, 146, 
                        147, 148, 149, 150, 151, 152, 153, 154, 
                        155, 156, 157, 158, 159, 160, 161, 162, 
                        163, 164, 165, 167, 168, 169, 170, 171
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) swl ON swl.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_swp 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        97, 98, 99, 100, 101, 102, 103, 105, 106, 
                        107, 108, 109, 110, 111, 112, 113, 114, 
                        115, 116, 117, 118, 119, 120, 121, 122, 
                        123, 124, 125, 126, 127, 128, 129, 130, 
                        131, 132, 133, 134, 135, 136, 137, 138, 
                        139, 140, 141, 142, 143, 144, 145, 146, 
                        147, 148, 149, 150, 151, 152, 153, 154, 
                        155, 156, 157, 158, 159, 160, 161, 162, 
                        163, 164, 165, 167, 168, 169, 170, 171
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) swp ON swp.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age1 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 18 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur <= 21 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age1 ON age1.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age2 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 22 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur <= 40 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age2 ON age2.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age3 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 41 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur <= 55 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age3 ON age3.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age4 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 56 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur <= 70 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age4 ON age4.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age5 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 71 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age5 ON age5.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_kes = 'Ada' 
                AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = '1'
                AND krt__profile.state_id = '" . Auth::user()->state_id . "'
                AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh) = YEAR(CURDATE())
                "));
                return Datatables::of($data)
                ->make(true);
        } else {
                $roles_menu     = DB::table('roles__menu')
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
                $daerah = RefDaerah::where('status', '=',  true)
                        ->where('ref__daerahs.state_id', '=', Auth::user()->state_id) 
                        ->orderBy('daerah_description', 'ASC')   
                        ->get();
                $parlimen   = RefParlimen::where('status', '=',  true)
                        ->where('ref__parlimens.state_id', '=', Auth::user()->state_id) 
                        ->orderBy('parlimen_description', 'ASC')    
                        ->get();
                return view('rt-sm31.laporan-pengendalian-kes-srs-ppn',compact('roles_menu','daerah','parlimen'));
        }    
    }

    function laporan_pengendalian_kes_srs_ppn_filter(Request $request, $id){
        if($request->ajax()){ 
                $type = $request->type;
                if($type == 'get_parlimen') {
                        $value = $request->value;
                        $where = array('parlimen_description' => $value);
                        $data  = DB::table('ref__parlimens')
                                ->select('ref__parlimens.id', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description', 'ref__states.state_id', 'ref__states.state_description')
                                ->leftJoin('ref__states','ref__states.state_id','=','ref__parlimens.state_id')
                                ->where('ref__states.state_description', '=',  $where)
                                ->orderBy('ref__parlimens.parlimen_description', 'ASC')
                                ->get();
                        return Response::json($data);
                } else if($type == 'get_dun') {
                        $value = $request->value;
                        $where = array('dun_description' => $value);
                        $data  = DB::table('ref__duns')
                                ->select('ref__duns.id', 'ref__duns.dun_id', 'ref__duns.dun_description', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description')
                                ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','ref__duns.parlimen_id')
                                ->where('ref__parlimens.parlimen_description', '=',  $where)
                                ->orderBy('ref__duns.dun_description', 'ASC')
                                ->get();
                        return Response::json($data);
                } else if($type == 'get_krt') {
                        $value = $request->value;
                        $where = array('daerah_description' => $value);
                        $data  = DB::table('krt__profile')
                                ->select('krt__profile.id', 'krt__profile.krt_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                                ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                ->where('ref__daerahs.daerah_description', '=',  $where)
                                ->where('krt__profile.krt_status', '=',  1)
                                ->orderBy('krt__profile.krt_nama', 'ASC')
                                ->get();
                        return Response::json($data);
                } else if($type == 'get_srs') {
                        $value = $request->value;
                        $where = array('krt_nama' => $value);
                        $data  = DB::table('srs__profile')
                                ->select('srs__profile.id', 'srs__profile.srs_name', 'krt__profile.id', 'krt__profile.krt_nama')
                                ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                                ->where('krt__profile.krt_nama', '=',  $where)
                                ->where('srs__profile.srs_status', '=',  1)
                                ->orderBy('srs__profile.srs_name', 'ASC')
                                ->get();
                        return Response::json($data);
                }
                $data = DB::select(DB::raw("
                SELECT 
                ref__states.state_description AS state, 
                ref__daerahs.daerah_description AS daerah, 
                krt__profile.krt_nama AS nama_krt, 
                srs__profile.srs_name AS nama_srs, 
                ref__srs_kategori_kes.kategori_description AS kategori_kes, 
                ref__srs_jenis_kes.jenis_description AS jenis_kes, 
                srs__pelaksanaan_rondaan.kes_jumlah_org_terlibat AS jumlah_terlibat, 
                (case when ml.total_ml IS NOT NULL then ml.total_ml else 0 end)AS total_ml,
                (case when mp.total_mp IS NOT NULL then mp.total_mp else 0 end)AS total_mp,
                (case when cl.total_cl IS NOT NULL then cl.total_cl else 0 end)AS total_cl,
                (case when cp.total_cp IS NOT NULL then cp.total_cp else 0 end)AS total_cp,
                (case when il.total_il IS NOT NULL then il.total_il else 0 end)AS total_il,
                (case when ip.total_ip IS NOT NULL then ip.total_ip else 0 end)AS total_ip,
                (case when sbl.total_sbl IS NOT NULL then sbl.total_sbl else 0 end)AS total_sbl,
                (case when sbp.total_sbp IS NOT NULL then sbp.total_sbp else 0 end)AS total_sbp,
                (case when swl.total_swl IS NOT NULL then swl.total_swl else 0 end)AS total_swl,
                (case when swp.total_swp IS NOT NULL then swp.total_swp else 0 end)AS total_swp,
                (case when age1.total_age1 IS NOT NULL then age1.total_age1 else 0 end)AS total_age1,
                (case when age2.total_age2 IS NOT NULL then age2.total_age2 else 0 end)AS total_age2,
                (case when age3.total_age3 IS NOT NULL then age3.total_age3 else 0 end)AS total_age3,
                (case when age4.total_age4 IS NOT NULL then age4.total_age4 else 0 end)AS total_age4,
                (case when age5.total_age5 IS NOT NULL then age5.total_age5 else 0 end)AS total_age5,
                ref__srs_dirujuk_kes.rujuk_description AS kes_dirujuk 
                FROM 
                srs__pelaksanaan_rondaan 
                LEFT JOIN krt__profile ON krt__profile.id = srs__pelaksanaan_rondaan.krt_profile_id 
                LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id 
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id 
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id 
                LEFT JOIN ref__srs_kategori_kes ON ref__srs_kategori_kes.id = srs__pelaksanaan_rondaan.kategori_kes_id 
                LEFT JOIN ref__srs_jenis_kes ON ref__srs_jenis_kes.id = srs__pelaksanaan_rondaan.jenis_kes_id 
                LEFT JOIN ref__srs_dirujuk_kes ON ref__srs_dirujuk_kes.id = srs__pelaksanaan_rondaan.kes_dirujuk_id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_ml 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (1, 2, 3, 4, 5, 6, 7) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) ml ON ml.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_mp 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (1, 2, 3, 4, 5, 6, 7) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) mp ON mp.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_cl 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 
                        19, 20
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) cl ON cl.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_cp 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 
                        19, 20
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) cp ON cp.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_il 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 
                        32, 33, 34, 35, 36, 37
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) il ON il.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_ip 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 
                        32, 33, 34, 35, 36, 37
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) ip ON ip.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_sbl 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 
                        52, 53, 54, 55, 56, 57, 58, 59, 62, 63, 
                        64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 
                        74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 
                        84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 
                        94, 95, 96
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) sbl ON sbl.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_sbp 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 
                        52, 53, 54, 55, 56, 57, 58, 59, 62, 63, 
                        64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 
                        74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 
                        84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 
                        94, 95, 96
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) sbp ON sbp.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_swl 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        97, 98, 99, 100, 101, 102, 103, 105, 106, 
                        107, 108, 109, 110, 111, 112, 113, 114, 
                        115, 116, 117, 118, 119, 120, 121, 122, 
                        123, 124, 125, 126, 127, 128, 129, 130, 
                        131, 132, 133, 134, 135, 136, 137, 138, 
                        139, 140, 141, 142, 143, 144, 145, 146, 
                        147, 148, 149, 150, 151, 152, 153, 154, 
                        155, 156, 157, 158, 159, 160, 161, 162, 
                        163, 164, 165, 167, 168, 169, 170, 171
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) swl ON swl.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_swp 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        97, 98, 99, 100, 101, 102, 103, 105, 106, 
                        107, 108, 109, 110, 111, 112, 113, 114, 
                        115, 116, 117, 118, 119, 120, 121, 122, 
                        123, 124, 125, 126, 127, 128, 129, 130, 
                        131, 132, 133, 134, 135, 136, 137, 138, 
                        139, 140, 141, 142, 143, 144, 145, 146, 
                        147, 148, 149, 150, 151, 152, 153, 154, 
                        155, 156, 157, 158, 159, 160, 161, 162, 
                        163, 164, 165, 167, 168, 169, 170, 171
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) swp ON swp.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age1 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 18 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur <= 21 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age1 ON age1.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age2 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 22 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur <= 40 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age2 ON age2.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age3 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 41 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur <= 55 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age3 ON age3.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age4 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 56 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur <= 70 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age4 ON age4.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age5 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 71 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age5 ON age5.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_kes = 'Ada' 
                AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = '1'
                AND krt__profile.state_id = '" . Auth::user()->state_id . "'
                AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh) = $id
                "));
                return Datatables::of($data)
                ->make(true);
        } else {
                $roles_menu     = DB::table('roles__menu')
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
                $daerah = RefDaerah::where('status', '=',  true)
                        ->where('ref__daerahs.state_id', '=', Auth::user()->state_id) 
                        ->orderBy('daerah_description', 'ASC')   
                        ->get();
                $parlimen   = RefParlimen::where('status', '=',  true)
                        ->where('ref__parlimens.state_id', '=', Auth::user()->state_id) 
                        ->orderBy('parlimen_description', 'ASC')    
                        ->get();
                return view('rt-sm31.laporan-pengendalian-kes-srs-ppn',compact('roles_menu','daerah','parlimen'));
        }    
    }

    function laporan_pengendalian_kes_srs_hqsrs(Request $request){
        if($request->ajax()){ 
                $type = $request->type;
                if($type == 'get_daerah') {
                    $value = $request->value;
                    $where = array('state_description' => $value);
                    $data  = DB::table('ref__daerahs')
                            ->select('ref__daerahs.id', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description', 'ref__states.state_id', 'ref__states.state_description')
                            ->leftJoin('ref__states','ref__states.state_id','=','ref__daerahs.state_id')
                            ->where('ref__states.state_description', '=',  $where)
                            ->get();
                    return Response::json($data);
                } else if($type == 'get_parlimen') {
                    $value = $request->value;
                    $where = array('parlimen_description' => $value);
                    $data  = DB::table('ref__parlimens')
                            ->select('ref__parlimens.id', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description', 'ref__states.state_id', 'ref__states.state_description')
                            ->leftJoin('ref__states','ref__states.state_id','=','ref__parlimens.state_id')
                            ->where('ref__states.state_description', '=',  $where)
                            ->get();
                    return Response::json($data);
                } else if($type == 'get_dun') {
                    $value = $request->value;
                    $where = array('dun_description' => $value);
                    $data  = DB::table('ref__duns')
                            ->select('ref__duns.id', 'ref__duns.dun_id', 'ref__duns.dun_description', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description')
                            ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','ref__duns.parlimen_id')
                            ->where('ref__parlimens.parlimen_description', '=',  $where)
                            ->get();
                    return Response::json($data);
                } else if($type == 'get_krt') {
                    $value = $request->value;
                    $where = array('daerah_description' => $value);
                    $data  = DB::table('krt__profile')
                            ->select('krt__profile.id', 'krt__profile.krt_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                            ->where('ref__daerahs.daerah_description', '=',  $where)
                            ->where('krt__profile.krt_status', '=',  1)
                            ->get();
                    return Response::json($data);
                } else if($type == 'get_srs') {
                    $value = $request->value;
                    $where = array('krt_nama' => $value);
                    $data  = DB::table('srs__profile')
                            ->select('srs__profile.id', 'srs__profile.srs_name', 'krt__profile.id', 'krt__profile.krt_nama')
                            ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                            ->where('krt__profile.krt_nama', '=',  $where)
                            ->where('srs__profile.srs_status', '=',  1)
                            ->get();
                    return Response::json($data);
                }
                $data = DB::select(DB::raw("
                SELECT 
                ref__states.state_description AS state, 
                ref__daerahs.daerah_description AS daerah, 
                krt__profile.krt_nama AS nama_krt, 
                srs__profile.srs_name AS nama_srs, 
                ref__srs_kategori_kes.kategori_description AS kategori_kes, 
                ref__srs_jenis_kes.jenis_description AS jenis_kes, 
                srs__pelaksanaan_rondaan.kes_jumlah_org_terlibat AS jumlah_terlibat, 
                (case when ml.total_ml IS NOT NULL then ml.total_ml else 0 end)AS total_ml,
                (case when mp.total_mp IS NOT NULL then mp.total_mp else 0 end)AS total_mp,
                (case when cl.total_cl IS NOT NULL then cl.total_cl else 0 end)AS total_cl,
                (case when cp.total_cp IS NOT NULL then cp.total_cp else 0 end)AS total_cp,
                (case when il.total_il IS NOT NULL then il.total_il else 0 end)AS total_il,
                (case when ip.total_ip IS NOT NULL then ip.total_ip else 0 end)AS total_ip,
                (case when sbl.total_sbl IS NOT NULL then sbl.total_sbl else 0 end)AS total_sbl,
                (case when sbp.total_sbp IS NOT NULL then sbp.total_sbp else 0 end)AS total_sbp,
                (case when swl.total_swl IS NOT NULL then swl.total_swl else 0 end)AS total_swl,
                (case when swp.total_swp IS NOT NULL then swp.total_swp else 0 end)AS total_swp,
                (case when age1.total_age1 IS NOT NULL then age1.total_age1 else 0 end)AS total_age1,
                (case when age2.total_age2 IS NOT NULL then age2.total_age2 else 0 end)AS total_age2,
                (case when age3.total_age3 IS NOT NULL then age3.total_age3 else 0 end)AS total_age3,
                (case when age4.total_age4 IS NOT NULL then age4.total_age4 else 0 end)AS total_age4,
                (case when age5.total_age5 IS NOT NULL then age5.total_age5 else 0 end)AS total_age5,
                ref__srs_dirujuk_kes.rujuk_description AS kes_dirujuk 
                FROM 
                srs__pelaksanaan_rondaan 
                LEFT JOIN krt__profile ON krt__profile.id = srs__pelaksanaan_rondaan.krt_profile_id 
                LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id 
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id 
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id 
                LEFT JOIN ref__srs_kategori_kes ON ref__srs_kategori_kes.id = srs__pelaksanaan_rondaan.kategori_kes_id 
                LEFT JOIN ref__srs_jenis_kes ON ref__srs_jenis_kes.id = srs__pelaksanaan_rondaan.jenis_kes_id 
                LEFT JOIN ref__srs_dirujuk_kes ON ref__srs_dirujuk_kes.id = srs__pelaksanaan_rondaan.kes_dirujuk_id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_ml 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (1, 2, 3, 4, 5, 6, 7) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) ml ON ml.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_mp 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (1, 2, 3, 4, 5, 6, 7) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) mp ON mp.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_cl 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 
                        19, 20
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) cl ON cl.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_cp 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 
                        19, 20
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) cp ON cp.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_il 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 
                        32, 33, 34, 35, 36, 37
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) il ON il.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_ip 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 
                        32, 33, 34, 35, 36, 37
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) ip ON ip.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_sbl 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 
                        52, 53, 54, 55, 56, 57, 58, 59, 62, 63, 
                        64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 
                        74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 
                        84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 
                        94, 95, 96
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) sbl ON sbl.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_sbp 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 
                        52, 53, 54, 55, 56, 57, 58, 59, 62, 63, 
                        64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 
                        74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 
                        84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 
                        94, 95, 96
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) sbp ON sbp.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_swl 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        97, 98, 99, 100, 101, 102, 103, 105, 106, 
                        107, 108, 109, 110, 111, 112, 113, 114, 
                        115, 116, 117, 118, 119, 120, 121, 122, 
                        123, 124, 125, 126, 127, 128, 129, 130, 
                        131, 132, 133, 134, 135, 136, 137, 138, 
                        139, 140, 141, 142, 143, 144, 145, 146, 
                        147, 148, 149, 150, 151, 152, 153, 154, 
                        155, 156, 157, 158, 159, 160, 161, 162, 
                        163, 164, 165, 167, 168, 169, 170, 171
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) swl ON swl.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_swp 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        97, 98, 99, 100, 101, 102, 103, 105, 106, 
                        107, 108, 109, 110, 111, 112, 113, 114, 
                        115, 116, 117, 118, 119, 120, 121, 122, 
                        123, 124, 125, 126, 127, 128, 129, 130, 
                        131, 132, 133, 134, 135, 136, 137, 138, 
                        139, 140, 141, 142, 143, 144, 145, 146, 
                        147, 148, 149, 150, 151, 152, 153, 154, 
                        155, 156, 157, 158, 159, 160, 161, 162, 
                        163, 164, 165, 167, 168, 169, 170, 171
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) swp ON swp.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age1 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 18 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur <= 21 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age1 ON age1.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age2 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 22 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur <= 40 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age2 ON age2.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age3 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 41 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur <= 55 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age3 ON age3.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age4 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 56 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur <= 70 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age4 ON age4.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age5 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 71 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age5 ON age5.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_kes = 'Ada' 
                AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = '1'
                AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh) = YEAR(CURDATE())
                "));
                return Datatables::of($data)
                ->make(true);
        } else {
                $roles_menu     = DB::table('roles__menu')
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
                $state      = RefStates::where('status', '=',  true)->get();
                return view('rt-sm31.laporan-pengendalian-kes-srs-hqsrs',compact('roles_menu','state'));
        }    
    }

    function laporan_pengendalian_kes_srs_hqsrs_filter(Request $request, $id){
        if($request->ajax()){ 
                $type = $request->type;
                if($type == 'get_daerah') {
                    $value = $request->value;
                    $where = array('state_description' => $value);
                    $data  = DB::table('ref__daerahs')
                            ->select('ref__daerahs.id', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description', 'ref__states.state_id', 'ref__states.state_description')
                            ->leftJoin('ref__states','ref__states.state_id','=','ref__daerahs.state_id')
                            ->where('ref__states.state_description', '=',  $where)
                            ->get();
                    return Response::json($data);
                } else if($type == 'get_parlimen') {
                    $value = $request->value;
                    $where = array('parlimen_description' => $value);
                    $data  = DB::table('ref__parlimens')
                            ->select('ref__parlimens.id', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description', 'ref__states.state_id', 'ref__states.state_description')
                            ->leftJoin('ref__states','ref__states.state_id','=','ref__parlimens.state_id')
                            ->where('ref__states.state_description', '=',  $where)
                            ->get();
                    return Response::json($data);
                } else if($type == 'get_dun') {
                    $value = $request->value;
                    $where = array('dun_description' => $value);
                    $data  = DB::table('ref__duns')
                            ->select('ref__duns.id', 'ref__duns.dun_id', 'ref__duns.dun_description', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description')
                            ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','ref__duns.parlimen_id')
                            ->where('ref__parlimens.parlimen_description', '=',  $where)
                            ->get();
                    return Response::json($data);
                } else if($type == 'get_krt') {
                    $value = $request->value;
                    $where = array('daerah_description' => $value);
                    $data  = DB::table('krt__profile')
                            ->select('krt__profile.id', 'krt__profile.krt_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                            ->where('ref__daerahs.daerah_description', '=',  $where)
                            ->where('krt__profile.krt_status', '=',  1)
                            ->get();
                    return Response::json($data);
                } else if($type == 'get_srs') {
                    $value = $request->value;
                    $where = array('krt_nama' => $value);
                    $data  = DB::table('srs__profile')
                            ->select('srs__profile.id', 'srs__profile.srs_name', 'krt__profile.id', 'krt__profile.krt_nama')
                            ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                            ->where('krt__profile.krt_nama', '=',  $where)
                            ->where('srs__profile.srs_status', '=',  1)
                            ->get();
                    return Response::json($data);
                }
                $data = DB::select(DB::raw("
                SELECT 
                ref__states.state_description AS state, 
                ref__daerahs.daerah_description AS daerah, 
                krt__profile.krt_nama AS nama_krt, 
                srs__profile.srs_name AS nama_srs, 
                ref__srs_kategori_kes.kategori_description AS kategori_kes, 
                ref__srs_jenis_kes.jenis_description AS jenis_kes, 
                srs__pelaksanaan_rondaan.kes_jumlah_org_terlibat AS jumlah_terlibat, 
                (case when ml.total_ml IS NOT NULL then ml.total_ml else 0 end)AS total_ml,
                (case when mp.total_mp IS NOT NULL then mp.total_mp else 0 end)AS total_mp,
                (case when cl.total_cl IS NOT NULL then cl.total_cl else 0 end)AS total_cl,
                (case when cp.total_cp IS NOT NULL then cp.total_cp else 0 end)AS total_cp,
                (case when il.total_il IS NOT NULL then il.total_il else 0 end)AS total_il,
                (case when ip.total_ip IS NOT NULL then ip.total_ip else 0 end)AS total_ip,
                (case when sbl.total_sbl IS NOT NULL then sbl.total_sbl else 0 end)AS total_sbl,
                (case when sbp.total_sbp IS NOT NULL then sbp.total_sbp else 0 end)AS total_sbp,
                (case when swl.total_swl IS NOT NULL then swl.total_swl else 0 end)AS total_swl,
                (case when swp.total_swp IS NOT NULL then swp.total_swp else 0 end)AS total_swp,
                (case when age1.total_age1 IS NOT NULL then age1.total_age1 else 0 end)AS total_age1,
                (case when age2.total_age2 IS NOT NULL then age2.total_age2 else 0 end)AS total_age2,
                (case when age3.total_age3 IS NOT NULL then age3.total_age3 else 0 end)AS total_age3,
                (case when age4.total_age4 IS NOT NULL then age4.total_age4 else 0 end)AS total_age4,
                (case when age5.total_age5 IS NOT NULL then age5.total_age5 else 0 end)AS total_age5,
                ref__srs_dirujuk_kes.rujuk_description AS kes_dirujuk 
                FROM 
                srs__pelaksanaan_rondaan 
                LEFT JOIN krt__profile ON krt__profile.id = srs__pelaksanaan_rondaan.krt_profile_id 
                LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id 
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id 
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id 
                LEFT JOIN ref__srs_kategori_kes ON ref__srs_kategori_kes.id = srs__pelaksanaan_rondaan.kategori_kes_id 
                LEFT JOIN ref__srs_jenis_kes ON ref__srs_jenis_kes.id = srs__pelaksanaan_rondaan.jenis_kes_id 
                LEFT JOIN ref__srs_dirujuk_kes ON ref__srs_dirujuk_kes.id = srs__pelaksanaan_rondaan.kes_dirujuk_id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_ml 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (1, 2, 3, 4, 5, 6, 7) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) ml ON ml.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_mp 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (1, 2, 3, 4, 5, 6, 7) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) mp ON mp.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_cl 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 
                        19, 20
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) cl ON cl.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_cp 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 
                        19, 20
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) cp ON cp.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_il 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 
                        32, 33, 34, 35, 36, 37
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) il ON il.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_ip 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 
                        32, 33, 34, 35, 36, 37
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) ip ON ip.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_sbl 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 
                        52, 53, 54, 55, 56, 57, 58, 59, 62, 63, 
                        64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 
                        74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 
                        84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 
                        94, 95, 96
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) sbl ON sbl.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_sbp 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 
                        52, 53, 54, 55, 56, 57, 58, 59, 62, 63, 
                        64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 
                        74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 
                        84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 
                        94, 95, 96
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) sbp ON sbp.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_swl 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        97, 98, 99, 100, 101, 102, 103, 105, 106, 
                        107, 108, 109, 110, 111, 112, 113, 114, 
                        115, 116, 117, 118, 119, 120, 121, 122, 
                        123, 124, 125, 126, 127, 128, 129, 130, 
                        131, 132, 133, 134, 135, 136, 137, 138, 
                        139, 140, 141, 142, 143, 144, 145, 146, 
                        147, 148, 149, 150, 151, 152, 153, 154, 
                        155, 156, 157, 158, 159, 160, 161, 162, 
                        163, 164, 165, 167, 168, 169, 170, 171
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) swl ON swl.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_swp 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        97, 98, 99, 100, 101, 102, 103, 105, 106, 
                        107, 108, 109, 110, 111, 112, 113, 114, 
                        115, 116, 117, 118, 119, 120, 121, 122, 
                        123, 124, 125, 126, 127, 128, 129, 130, 
                        131, 132, 133, 134, 135, 136, 137, 138, 
                        139, 140, 141, 142, 143, 144, 145, 146, 
                        147, 148, 149, 150, 151, 152, 153, 154, 
                        155, 156, 157, 158, 159, 160, 161, 162, 
                        163, 164, 165, 167, 168, 169, 170, 171
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) swp ON swp.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age1 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 18 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur <= 21 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age1 ON age1.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age2 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 22 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur <= 40 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age2 ON age2.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age3 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 41 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur <= 55 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age3 ON age3.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age4 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 56 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur <= 70 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age4 ON age4.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age5 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 71 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age5 ON age5.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_kes = 'Ada' 
                AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = '1'
                AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh) = $id
                "));
                return Datatables::of($data)
                ->make(true);
        } else {
                $roles_menu     = DB::table('roles__menu')
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
                $state      = RefStates::where('status', '=',  true)->get();
                return view('rt-sm31.laporan-pengendalian-kes-srs-hqsrs',compact('roles_menu','state'));
        }    
    }

    function laporan_pengendalian_kes_srs_kp(Request $request){
        if($request->ajax()){ 
                $type = $request->type;
                if($type == 'get_daerah') {
                    $value = $request->value;
                    $where = array('state_description' => $value);
                    $data  = DB::table('ref__daerahs')
                            ->select('ref__daerahs.id', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description', 'ref__states.state_id', 'ref__states.state_description')
                            ->leftJoin('ref__states','ref__states.state_id','=','ref__daerahs.state_id')
                            ->where('ref__states.state_description', '=',  $where)
                            ->get();
                    return Response::json($data);
                } else if($type == 'get_parlimen') {
                    $value = $request->value;
                    $where = array('parlimen_description' => $value);
                    $data  = DB::table('ref__parlimens')
                            ->select('ref__parlimens.id', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description', 'ref__states.state_id', 'ref__states.state_description')
                            ->leftJoin('ref__states','ref__states.state_id','=','ref__parlimens.state_id')
                            ->where('ref__states.state_description', '=',  $where)
                            ->get();
                    return Response::json($data);
                } else if($type == 'get_dun') {
                    $value = $request->value;
                    $where = array('dun_description' => $value);
                    $data  = DB::table('ref__duns')
                            ->select('ref__duns.id', 'ref__duns.dun_id', 'ref__duns.dun_description', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description')
                            ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','ref__duns.parlimen_id')
                            ->where('ref__parlimens.parlimen_description', '=',  $where)
                            ->get();
                    return Response::json($data);
                } else if($type == 'get_krt') {
                    $value = $request->value;
                    $where = array('daerah_description' => $value);
                    $data  = DB::table('krt__profile')
                            ->select('krt__profile.id', 'krt__profile.krt_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                            ->where('ref__daerahs.daerah_description', '=',  $where)
                            ->where('krt__profile.krt_status', '=',  1)
                            ->get();
                    return Response::json($data);
                } else if($type == 'get_srs') {
                    $value = $request->value;
                    $where = array('krt_nama' => $value);
                    $data  = DB::table('srs__profile')
                            ->select('srs__profile.id', 'srs__profile.srs_name', 'krt__profile.id', 'krt__profile.krt_nama')
                            ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                            ->where('krt__profile.krt_nama', '=',  $where)
                            ->where('srs__profile.srs_status', '=',  1)
                            ->get();
                    return Response::json($data);
                }
                $data = DB::select(DB::raw("
                SELECT 
                ref__states.state_description AS state, 
                ref__daerahs.daerah_description AS daerah, 
                krt__profile.krt_nama AS nama_krt, 
                srs__profile.srs_name AS nama_srs, 
                ref__srs_kategori_kes.kategori_description AS kategori_kes, 
                ref__srs_jenis_kes.jenis_description AS jenis_kes, 
                srs__pelaksanaan_rondaan.kes_jumlah_org_terlibat AS jumlah_terlibat, 
                (case when ml.total_ml IS NOT NULL then ml.total_ml else 0 end)AS total_ml,
                (case when mp.total_mp IS NOT NULL then mp.total_mp else 0 end)AS total_mp,
                (case when cl.total_cl IS NOT NULL then cl.total_cl else 0 end)AS total_cl,
                (case when cp.total_cp IS NOT NULL then cp.total_cp else 0 end)AS total_cp,
                (case when il.total_il IS NOT NULL then il.total_il else 0 end)AS total_il,
                (case when ip.total_ip IS NOT NULL then ip.total_ip else 0 end)AS total_ip,
                (case when sbl.total_sbl IS NOT NULL then sbl.total_sbl else 0 end)AS total_sbl,
                (case when sbp.total_sbp IS NOT NULL then sbp.total_sbp else 0 end)AS total_sbp,
                (case when swl.total_swl IS NOT NULL then swl.total_swl else 0 end)AS total_swl,
                (case when swp.total_swp IS NOT NULL then swp.total_swp else 0 end)AS total_swp,
                (case when age1.total_age1 IS NOT NULL then age1.total_age1 else 0 end)AS total_age1,
                (case when age2.total_age2 IS NOT NULL then age2.total_age2 else 0 end)AS total_age2,
                (case when age3.total_age3 IS NOT NULL then age3.total_age3 else 0 end)AS total_age3,
                (case when age4.total_age4 IS NOT NULL then age4.total_age4 else 0 end)AS total_age4,
                (case when age5.total_age5 IS NOT NULL then age5.total_age5 else 0 end)AS total_age5,
                ref__srs_dirujuk_kes.rujuk_description AS kes_dirujuk 
                FROM 
                srs__pelaksanaan_rondaan 
                LEFT JOIN krt__profile ON krt__profile.id = srs__pelaksanaan_rondaan.krt_profile_id 
                LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id 
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id 
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id 
                LEFT JOIN ref__srs_kategori_kes ON ref__srs_kategori_kes.id = srs__pelaksanaan_rondaan.kategori_kes_id 
                LEFT JOIN ref__srs_jenis_kes ON ref__srs_jenis_kes.id = srs__pelaksanaan_rondaan.jenis_kes_id 
                LEFT JOIN ref__srs_dirujuk_kes ON ref__srs_dirujuk_kes.id = srs__pelaksanaan_rondaan.kes_dirujuk_id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_ml 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (1, 2, 3, 4, 5, 6, 7) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) ml ON ml.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_mp 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (1, 2, 3, 4, 5, 6, 7) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) mp ON mp.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_cl 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 
                        19, 20
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) cl ON cl.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_cp 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 
                        19, 20
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) cp ON cp.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_il 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 
                        32, 33, 34, 35, 36, 37
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) il ON il.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_ip 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 
                        32, 33, 34, 35, 36, 37
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) ip ON ip.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_sbl 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 
                        52, 53, 54, 55, 56, 57, 58, 59, 62, 63, 
                        64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 
                        74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 
                        84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 
                        94, 95, 96
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) sbl ON sbl.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_sbp 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 
                        52, 53, 54, 55, 56, 57, 58, 59, 62, 63, 
                        64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 
                        74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 
                        84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 
                        94, 95, 96
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) sbp ON sbp.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_swl 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        97, 98, 99, 100, 101, 102, 103, 105, 106, 
                        107, 108, 109, 110, 111, 112, 113, 114, 
                        115, 116, 117, 118, 119, 120, 121, 122, 
                        123, 124, 125, 126, 127, 128, 129, 130, 
                        131, 132, 133, 134, 135, 136, 137, 138, 
                        139, 140, 141, 142, 143, 144, 145, 146, 
                        147, 148, 149, 150, 151, 152, 153, 154, 
                        155, 156, 157, 158, 159, 160, 161, 162, 
                        163, 164, 165, 167, 168, 169, 170, 171
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) swl ON swl.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_swp 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        97, 98, 99, 100, 101, 102, 103, 105, 106, 
                        107, 108, 109, 110, 111, 112, 113, 114, 
                        115, 116, 117, 118, 119, 120, 121, 122, 
                        123, 124, 125, 126, 127, 128, 129, 130, 
                        131, 132, 133, 134, 135, 136, 137, 138, 
                        139, 140, 141, 142, 143, 144, 145, 146, 
                        147, 148, 149, 150, 151, 152, 153, 154, 
                        155, 156, 157, 158, 159, 160, 161, 162, 
                        163, 164, 165, 167, 168, 169, 170, 171
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) swp ON swp.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age1 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 18 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur <= 21 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age1 ON age1.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age2 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 22 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur <= 40 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age2 ON age2.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age3 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 41 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur <= 55 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age3 ON age3.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age4 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 56 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur <= 70 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age4 ON age4.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age5 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 71 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age5 ON age5.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_kes = 'Ada' 
                AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = '1'
                AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh) = YEAR(CURDATE())
                "));
                return Datatables::of($data)
                ->make(true);
        } else {
                $roles_menu     = DB::table('roles__menu')
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
                $state      = RefStates::where('status', '=',  true)->get();
                return view('rt-sm31.laporan-pengendalian-kes-srs-kp',compact('roles_menu','state'));
        }    
    }

    function laporan_pengendalian_kes_srs_kp_filter(Request $request, $id){
        if($request->ajax()){ 
                $type = $request->type;
                if($type == 'get_daerah') {
                    $value = $request->value;
                    $where = array('state_description' => $value);
                    $data  = DB::table('ref__daerahs')
                            ->select('ref__daerahs.id', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description', 'ref__states.state_id', 'ref__states.state_description')
                            ->leftJoin('ref__states','ref__states.state_id','=','ref__daerahs.state_id')
                            ->where('ref__states.state_description', '=',  $where)
                            ->get();
                    return Response::json($data);
                } else if($type == 'get_parlimen') {
                    $value = $request->value;
                    $where = array('parlimen_description' => $value);
                    $data  = DB::table('ref__parlimens')
                            ->select('ref__parlimens.id', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description', 'ref__states.state_id', 'ref__states.state_description')
                            ->leftJoin('ref__states','ref__states.state_id','=','ref__parlimens.state_id')
                            ->where('ref__states.state_description', '=',  $where)
                            ->get();
                    return Response::json($data);
                } else if($type == 'get_dun') {
                    $value = $request->value;
                    $where = array('dun_description' => $value);
                    $data  = DB::table('ref__duns')
                            ->select('ref__duns.id', 'ref__duns.dun_id', 'ref__duns.dun_description', 'ref__parlimens.parlimen_id', 'ref__parlimens.parlimen_description')
                            ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','ref__duns.parlimen_id')
                            ->where('ref__parlimens.parlimen_description', '=',  $where)
                            ->get();
                    return Response::json($data);
                } else if($type == 'get_krt') {
                    $value = $request->value;
                    $where = array('daerah_description' => $value);
                    $data  = DB::table('krt__profile')
                            ->select('krt__profile.id', 'krt__profile.krt_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                            ->where('ref__daerahs.daerah_description', '=',  $where)
                            ->where('krt__profile.krt_status', '=',  1)
                            ->get();
                    return Response::json($data);
                } else if($type == 'get_srs') {
                    $value = $request->value;
                    $where = array('krt_nama' => $value);
                    $data  = DB::table('srs__profile')
                            ->select('srs__profile.id', 'srs__profile.srs_name', 'krt__profile.id', 'krt__profile.krt_nama')
                            ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                            ->where('krt__profile.krt_nama', '=',  $where)
                            ->where('srs__profile.srs_status', '=',  1)
                            ->get();
                    return Response::json($data);
                }
                $data = DB::select(DB::raw("
                SELECT 
                ref__states.state_description AS state, 
                ref__daerahs.daerah_description AS daerah, 
                krt__profile.krt_nama AS nama_krt, 
                srs__profile.srs_name AS nama_srs, 
                ref__srs_kategori_kes.kategori_description AS kategori_kes, 
                ref__srs_jenis_kes.jenis_description AS jenis_kes, 
                srs__pelaksanaan_rondaan.kes_jumlah_org_terlibat AS jumlah_terlibat, 
                (case when ml.total_ml IS NOT NULL then ml.total_ml else 0 end)AS total_ml,
                (case when mp.total_mp IS NOT NULL then mp.total_mp else 0 end)AS total_mp,
                (case when cl.total_cl IS NOT NULL then cl.total_cl else 0 end)AS total_cl,
                (case when cp.total_cp IS NOT NULL then cp.total_cp else 0 end)AS total_cp,
                (case when il.total_il IS NOT NULL then il.total_il else 0 end)AS total_il,
                (case when ip.total_ip IS NOT NULL then ip.total_ip else 0 end)AS total_ip,
                (case when sbl.total_sbl IS NOT NULL then sbl.total_sbl else 0 end)AS total_sbl,
                (case when sbp.total_sbp IS NOT NULL then sbp.total_sbp else 0 end)AS total_sbp,
                (case when swl.total_swl IS NOT NULL then swl.total_swl else 0 end)AS total_swl,
                (case when swp.total_swp IS NOT NULL then swp.total_swp else 0 end)AS total_swp,
                (case when age1.total_age1 IS NOT NULL then age1.total_age1 else 0 end)AS total_age1,
                (case when age2.total_age2 IS NOT NULL then age2.total_age2 else 0 end)AS total_age2,
                (case when age3.total_age3 IS NOT NULL then age3.total_age3 else 0 end)AS total_age3,
                (case when age4.total_age4 IS NOT NULL then age4.total_age4 else 0 end)AS total_age4,
                (case when age5.total_age5 IS NOT NULL then age5.total_age5 else 0 end)AS total_age5,
                ref__srs_dirujuk_kes.rujuk_description AS kes_dirujuk 
                FROM 
                srs__pelaksanaan_rondaan 
                LEFT JOIN krt__profile ON krt__profile.id = srs__pelaksanaan_rondaan.krt_profile_id 
                LEFT JOIN srs__profile ON srs__profile.id = srs__pelaksanaan_rondaan.srs_profile_id 
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id 
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id 
                LEFT JOIN ref__srs_kategori_kes ON ref__srs_kategori_kes.id = srs__pelaksanaan_rondaan.kategori_kes_id 
                LEFT JOIN ref__srs_jenis_kes ON ref__srs_jenis_kes.id = srs__pelaksanaan_rondaan.jenis_kes_id 
                LEFT JOIN ref__srs_dirujuk_kes ON ref__srs_dirujuk_kes.id = srs__pelaksanaan_rondaan.kes_dirujuk_id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_ml 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (1, 2, 3, 4, 5, 6, 7) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) ml ON ml.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_mp 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (1, 2, 3, 4, 5, 6, 7) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) mp ON mp.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_cl 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 
                        19, 20
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) cl ON cl.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_cp 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 
                        19, 20
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) cp ON cp.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_il 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 
                        32, 33, 34, 35, 36, 37
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) il ON il.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_ip 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 
                        32, 33, 34, 35, 36, 37
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) ip ON ip.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_sbl 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 
                        52, 53, 54, 55, 56, 57, 58, 59, 62, 63, 
                        64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 
                        74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 
                        84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 
                        94, 95, 96
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) sbl ON sbl.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_sbp 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 
                        52, 53, 54, 55, 56, 57, 58, 59, 62, 63, 
                        64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 
                        74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 
                        84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 
                        94, 95, 96
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) sbp ON sbp.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_swl 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        97, 98, 99, 100, 101, 102, 103, 105, 106, 
                        107, 108, 109, 110, 111, 112, 113, 114, 
                        115, 116, 117, 118, 119, 120, 121, 122, 
                        123, 124, 125, 126, 127, 128, 129, 130, 
                        131, 132, 133, 134, 135, 136, 137, 138, 
                        139, 140, 141, 142, 143, 144, 145, 146, 
                        147, 148, 149, 150, 151, 152, 153, 154, 
                        155, 156, 157, 158, 159, 160, 161, 162, 
                        163, 164, 165, 167, 168, 169, 170, 171
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 1 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) swl ON swl.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_swp 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.kaum_id IN (
                        97, 98, 99, 100, 101, 102, 103, 105, 106, 
                        107, 108, 109, 110, 111, 112, 113, 114, 
                        115, 116, 117, 118, 119, 120, 121, 122, 
                        123, 124, 125, 126, 127, 128, 129, 130, 
                        131, 132, 133, 134, 135, 136, 137, 138, 
                        139, 140, 141, 142, 143, 144, 145, 146, 
                        147, 148, 149, 150, 151, 152, 153, 154, 
                        155, 156, 157, 158, 159, 160, 161, 162, 
                        163, 164, 165, 167, 168, 169, 170, 171
                ) 
                AND srs__pelaksanaan_rondaan_kes_terlibat.jantina_id = 2 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) swp ON swp.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age1 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 18 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur <= 21 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age1 ON age1.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age2 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 22 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur <= 40 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age2 ON age2.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age3 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 41 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur <= 55 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age3 ON age3.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age4 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 56 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur <= 70 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age4 ON age4.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                LEFT JOIN (
                SELECT 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id, 
                count(*) AS total_age5 
                FROM 
                srs__pelaksanaan_rondaan_kes_terlibat 
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1 
                AND srs__pelaksanaan_rondaan_kes_terlibat.terlibat_umur >= 71 
                GROUP BY 
                srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id
                ) age5 ON age5.srs_pelaksanaan_rondaan_id = srs__pelaksanaan_rondaan.id 
                WHERE 
                srs__pelaksanaan_rondaan.pelaksanaan_rondaan_kes = 'Ada' 
                AND srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = '1'
                AND YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh) = $id
                "));
                return Datatables::of($data)
                ->make(true);
        } else {
                $roles_menu     = DB::table('roles__menu')
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
                $state      = RefStates::where('status', '=',  true)->get();
                return view('rt-sm31.laporan-pengendalian-kes-srs-kp',compact('roles_menu','state'));
        }    
    }
}
