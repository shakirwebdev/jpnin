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
use App\RefPendidikan;
use App\Ref_Jawatan_Ajk_KRT;
use App\Ref_Aktiviti_Agenda_Kerja;
use App\Ref_Aktiviti_Bidang;
use App\Ref_Aktiviti;
use App\Ref_Jenis_Aktiviti;
use App\Ref_Kelompok_Umur;
use Maatwebsite\Excel\Facades\Excel;
use App\Laporan_Aktiviti;
use App\RefPenggal;

class RT_SM30Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function laporan_maklumat_asas_krt_ppd(Request $request){
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
            $data = DB::table('krt__profile')
                        ->select('krt__profile.id AS id',
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'krt__profile.krt_nama AS krt_nama',
                                'krt__profile.krt_alamat AS krt_alamat',
                                'ref__parlimens.parlimen_description AS parlimen',
                                'ref__duns.dun_description AS dun',
                                'ref__pbts.pbt_description AS pbt',
                                'krt__profile.krt_ipd AS krt_ipd',
                                'krt__profile.krt_balai AS krt_balai',
                                'krt__profile.krt_keluasan AS krt_keluasan',
                                'krt__profile.srs_nama AS srs_nama',
                                'krt__profile.krt_tabika AS krt_tabika',
                                'krt__profile.krt_taska AS krt_taska')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__parlimens','ref__parlimens.id','=','krt__profile.parlimen_id')
                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                        ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                        ->whereIN('krt__profile.krt_status',[1])
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
            $parlimen   = RefParlimen::where('status', '=',  true)
                        ->where('ref__parlimens.state_id', '=', Auth::user()->state_id)    
                        ->get();
            return view('rt-sm30.laporan-maklumat-asas-krt-ppd',compact('roles_menu','parlimen'));
        }
        
    }

    function laporan_maklumat_asas_krt_ppn(Request $request){
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
            $data = DB::table('krt__profile')
                        ->select('krt__profile.id AS id',
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'krt__profile.krt_nama AS krt_nama',
                                'krt__profile.krt_alamat AS krt_alamat',
                                'ref__parlimens.parlimen_description AS parlimen',
                                'ref__duns.dun_description AS dun',
                                'ref__pbts.pbt_description AS pbt',
                                'krt__profile.krt_ipd AS krt_ipd',
                                'krt__profile.krt_balai AS krt_balai',
                                'krt__profile.krt_keluasan AS krt_keluasan',
                                'krt__profile.srs_nama AS srs_nama',
                                'krt__profile.krt_tabika AS krt_tabika',
                                'krt__profile.krt_taska AS krt_taska')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__parlimens','ref__parlimens.id','=','krt__profile.parlimen_id')
                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                        ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                        ->whereIN('krt__profile.krt_status',[1])
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
            $pbt        = RefPBT::where('status', '=',  true)
                        ->where('ref__pbts.state_id', '=', Auth::user()->state_id)    
                        ->get();
            $parlimen   = RefParlimen::where('status', '=',  true)
                        ->where('ref__parlimens.state_id', '=', Auth::user()->state_id)    
                        ->get();
            return view('rt-sm30.laporan-maklumat-asas-krt-ppn',compact('roles_menu','daerah','pbt','parlimen'));
        }
        
    }

    function laporan_maklumat_asas_krt_hqrt(Request $request){
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
            else if($type == 'get_pbt') {
                $value = $request->value;
                $where = array('pbt_description' => $value);
                $data  = DB::table('ref__pbts')
                        ->select('ref__pbts.id', 'ref__pbts.pbt_id', 'ref__pbts.pbt_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__pbts.state_id')
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
            $data = DB::table('krt__profile')
                        ->select('krt__profile.id AS id',
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'krt__profile.krt_nama AS krt_nama',
                                'krt__profile.krt_alamat AS krt_alamat',
                                'ref__parlimens.parlimen_description AS parlimen',
                                'ref__duns.dun_description AS dun',
                                'ref__pbts.pbt_description AS pbt',
                                'krt__profile.krt_ipd AS krt_ipd',
                                'krt__profile.krt_balai AS krt_balai',
                                'krt__profile.krt_keluasan AS krt_keluasan',
                                'krt__profile.srs_nama AS srs_nama',
                                'krt__profile.krt_tabika AS krt_tabika',
                                'krt__profile.krt_taska AS krt_taska')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__parlimens','ref__parlimens.id','=','krt__profile.parlimen_id')
                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                        ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                        ->whereIN('krt__profile.krt_status',[1])
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
            $state   = RefStates::where('status', '=',  true)->get();
            $daerah  = RefDaerah::where('status', '=',  true)->get();
            return view('rt-sm30.laporan-maklumat-asas-krt-hqrt',compact('roles_menu','state','daerah'));
        }
    }

    function laporan_maklumat_asas_krt_kp(Request $request){
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
            else if($type == 'get_pbt') {
                $value = $request->value;
                $where = array('pbt_description' => $value);
                $data  = DB::table('ref__pbts')
                        ->select('ref__pbts.id', 'ref__pbts.pbt_id', 'ref__pbts.pbt_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__pbts.state_id')
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
            $data = DB::table('krt__profile')
                        ->select('krt__profile.id AS id',
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'krt__profile.krt_nama AS krt_nama',
                                'krt__profile.krt_alamat AS krt_alamat',
                                'ref__parlimens.parlimen_description AS parlimen',
                                'ref__duns.dun_description AS dun',
                                'ref__pbts.pbt_description AS pbt',
                                'krt__profile.krt_ipd AS krt_ipd',
                                'krt__profile.krt_balai AS krt_balai',
                                'krt__profile.krt_keluasan AS krt_keluasan',
                                'krt__profile.srs_nama AS srs_nama',
                                'krt__profile.krt_tabika AS krt_tabika',
                                'krt__profile.krt_taska AS krt_taska')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__parlimens','ref__parlimens.id','=','krt__profile.parlimen_id')
                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                        ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                        ->whereIN('krt__profile.krt_status',[1])
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
            $state   = RefStates::where('status', '=',  true)->get();
            $daerah  = RefDaerah::where('status', '=',  true)->get();
            return view('rt-sm30.laporan-maklumat-asas-krt-kp',compact('roles_menu','state','daerah'));
        }
        
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function laporan_maklumat_asas_krt_2_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
           
            $data = DB::select(DB::raw("
            SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS krt_nama,
                (case when melayu.total_kaum IS NOT NULL then melayu.total_kaum else 0 end)AS total_melayu,
                (case when cina.total_kaum IS NOT NULL then cina.total_kaum else 0 end)AS total_cina,
                (case when india.total_kaum IS NOT NULL then india.total_kaum else 0 end)AS total_india,
                (case when sabah.total_kaum IS NOT NULL then sabah.total_kaum else 0 end)AS total_sabah,
                (case when sarawak.total_kaum IS NOT NULL then sarawak.total_kaum else 0 end)AS total_sarawak,
                (case when kerajaan.peratus_pekerjaan IS NOT NULL then kerajaan.peratus_pekerjaan else 0 end)AS total_kerjaan,
                (case when swasta.peratus_pekerjaan IS NOT NULL then swasta.peratus_pekerjaan else 0 end)AS total_swasta,
                (case when sendiri.peratus_pekerjaan IS NOT NULL then sendiri.peratus_pekerjaan else 0 end)AS total_sendiri,
                (case when xbekerja.peratus_pekerjaan IS NOT NULL then xbekerja.peratus_pekerjaan else 0 end)AS total_xbekerja,
                (case when pesara.peratus_pekerjaan IS NOT NULL then pesara.peratus_pekerjaan else 0 end)AS total_pesara,
                (case when pelajar.peratus_pekerjaan IS NOT NULL then pelajar.peratus_pekerjaan else 0 end)AS total_pelajar
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN (
                        SELECT
                        krt__komposisi_penduduk.krt_profileID AS krt_id,
                        SUM(krt__komposisi_penduduk.komposisi_jumlah) AS total_kaum
                        FROM krt__komposisi_penduduk 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__komposisi_penduduk.krt_profileID
                        WHERE krt__komposisi_penduduk.komposisi_kaum IN (1,2,3,4,5,6,7)
                        GROUP BY krt__komposisi_penduduk.krt_profileID
                ) melayu on melayu.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__komposisi_penduduk.krt_profileID AS krt_id,
                        SUM(krt__komposisi_penduduk.komposisi_jumlah) AS total_kaum
                        FROM krt__komposisi_penduduk 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__komposisi_penduduk.krt_profileID
                        WHERE krt__komposisi_penduduk.komposisi_kaum IN (8,9,10,11,12,13,14,15,16,17,18,19,20)
                        GROUP BY krt__komposisi_penduduk.krt_profileID
                ) cina on cina.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__komposisi_penduduk.krt_profileID AS krt_id,
                        SUM(krt__komposisi_penduduk.komposisi_jumlah) AS total_kaum
                        FROM krt__komposisi_penduduk 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__komposisi_penduduk.krt_profileID
                        WHERE krt__komposisi_penduduk.komposisi_kaum IN (21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37)
                        GROUP BY krt__komposisi_penduduk.krt_profileID
                ) india on india.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__komposisi_penduduk.krt_profileID AS krt_id,
                        SUM(krt__komposisi_penduduk.komposisi_jumlah) AS total_kaum
                        FROM krt__komposisi_penduduk 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__komposisi_penduduk.krt_profileID
                        WHERE krt__komposisi_penduduk.komposisi_kaum IN (40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96)
                        GROUP BY krt__komposisi_penduduk.krt_profileID
                ) sabah on sabah.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__komposisi_penduduk.krt_profileID AS krt_id,
                        SUM(krt__komposisi_penduduk.komposisi_jumlah) AS total_kaum
                        FROM krt__komposisi_penduduk 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__komposisi_penduduk.krt_profileID
                        WHERE krt__komposisi_penduduk.komposisi_kaum IN (97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167,168,169,170,171)
                        GROUP BY krt__komposisi_penduduk.krt_profileID
                ) sarawak on sarawak.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__pekerjaan.krt_profileID AS krt_id,
                        krt__pekerjaan.pekerjaan_peratus AS peratus_pekerjaan
                        FROM krt__pekerjaan 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__pekerjaan.krt_profileID
                        WHERE krt__pekerjaan.profession_id = 1
                ) kerajaan on kerajaan.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__pekerjaan.krt_profileID AS krt_id,
                        krt__pekerjaan.pekerjaan_peratus AS peratus_pekerjaan
                        FROM krt__pekerjaan 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__pekerjaan.krt_profileID
                        WHERE krt__pekerjaan.profession_id = 2
                ) swasta on swasta.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__pekerjaan.krt_profileID AS krt_id,
                        krt__pekerjaan.pekerjaan_peratus AS peratus_pekerjaan
                        FROM krt__pekerjaan 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__pekerjaan.krt_profileID
                        WHERE krt__pekerjaan.profession_id = 3
                ) sendiri on sendiri.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__pekerjaan.krt_profileID AS krt_id,
                        krt__pekerjaan.pekerjaan_peratus AS peratus_pekerjaan
                        FROM krt__pekerjaan 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__pekerjaan.krt_profileID
                        WHERE krt__pekerjaan.profession_id = 4
                ) xbekerja on xbekerja.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__pekerjaan.krt_profileID AS krt_id,
                        krt__pekerjaan.pekerjaan_peratus AS peratus_pekerjaan
                        FROM krt__pekerjaan 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__pekerjaan.krt_profileID
                        WHERE krt__pekerjaan.profession_id = 5
                ) pesara on pesara.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__pekerjaan.krt_profileID AS krt_id,
                        krt__pekerjaan.pekerjaan_peratus AS peratus_pekerjaan
                        FROM krt__pekerjaan 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__pekerjaan.krt_profileID
                        WHERE krt__pekerjaan.profession_id = 6
                ) pelajar on pelajar.krt_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND krt__profile.daerah_id = '" . Auth::user()->daerah_id . "' "));
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
            return view('rt-sm30.laporan-maklumat-asas-krt-2-ppd',compact('roles_menu'));
        }
    }

    function laporan_maklumat_asas_krt_2_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
           
            $data = DB::select(DB::raw("
            SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS krt_nama,
                (case when melayu.total_kaum IS NOT NULL then melayu.total_kaum else 0 end)AS total_melayu,
                (case when cina.total_kaum IS NOT NULL then cina.total_kaum else 0 end)AS total_cina,
                (case when india.total_kaum IS NOT NULL then india.total_kaum else 0 end)AS total_india,
                (case when sabah.total_kaum IS NOT NULL then sabah.total_kaum else 0 end)AS total_sabah,
                (case when sarawak.total_kaum IS NOT NULL then sarawak.total_kaum else 0 end)AS total_sarawak,
                (case when kerajaan.peratus_pekerjaan IS NOT NULL then kerajaan.peratus_pekerjaan else 0 end)AS total_kerjaan,
                (case when swasta.peratus_pekerjaan IS NOT NULL then swasta.peratus_pekerjaan else 0 end)AS total_swasta,
                (case when sendiri.peratus_pekerjaan IS NOT NULL then sendiri.peratus_pekerjaan else 0 end)AS total_sendiri,
                (case when xbekerja.peratus_pekerjaan IS NOT NULL then xbekerja.peratus_pekerjaan else 0 end)AS total_xbekerja,
                (case when pesara.peratus_pekerjaan IS NOT NULL then pesara.peratus_pekerjaan else 0 end)AS total_pesara,
                (case when pelajar.peratus_pekerjaan IS NOT NULL then pelajar.peratus_pekerjaan else 0 end)AS total_pelajar
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN (
                        SELECT
                        krt__komposisi_penduduk.krt_profileID AS krt_id,
                        SUM(krt__komposisi_penduduk.komposisi_jumlah) AS total_kaum
                        FROM krt__komposisi_penduduk 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__komposisi_penduduk.krt_profileID
                        WHERE krt__komposisi_penduduk.komposisi_kaum IN (1,2,3,4,5,6,7)
                        GROUP BY krt__komposisi_penduduk.krt_profileID
                ) melayu on melayu.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__komposisi_penduduk.krt_profileID AS krt_id,
                        SUM(krt__komposisi_penduduk.komposisi_jumlah) AS total_kaum
                        FROM krt__komposisi_penduduk 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__komposisi_penduduk.krt_profileID
                        WHERE krt__komposisi_penduduk.komposisi_kaum IN (8,9,10,11,12,13,14,15,16,17,18,19,20)
                        GROUP BY krt__komposisi_penduduk.krt_profileID
                ) cina on cina.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__komposisi_penduduk.krt_profileID AS krt_id,
                        SUM(krt__komposisi_penduduk.komposisi_jumlah) AS total_kaum
                        FROM krt__komposisi_penduduk 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__komposisi_penduduk.krt_profileID
                        WHERE krt__komposisi_penduduk.komposisi_kaum IN (21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37)
                        GROUP BY krt__komposisi_penduduk.krt_profileID
                ) india on india.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__komposisi_penduduk.krt_profileID AS krt_id,
                        SUM(krt__komposisi_penduduk.komposisi_jumlah) AS total_kaum
                        FROM krt__komposisi_penduduk 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__komposisi_penduduk.krt_profileID
                        WHERE krt__komposisi_penduduk.komposisi_kaum IN (40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96)
                        GROUP BY krt__komposisi_penduduk.krt_profileID
                ) sabah on sabah.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__komposisi_penduduk.krt_profileID AS krt_id,
                        SUM(krt__komposisi_penduduk.komposisi_jumlah) AS total_kaum
                        FROM krt__komposisi_penduduk 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__komposisi_penduduk.krt_profileID
                        WHERE krt__komposisi_penduduk.komposisi_kaum IN (97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167,168,169,170,171)
                        GROUP BY krt__komposisi_penduduk.krt_profileID
                ) sarawak on sarawak.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__pekerjaan.krt_profileID AS krt_id,
                        krt__pekerjaan.pekerjaan_peratus AS peratus_pekerjaan
                        FROM krt__pekerjaan 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__pekerjaan.krt_profileID
                        WHERE krt__pekerjaan.profession_id = 1
                ) kerajaan on kerajaan.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__pekerjaan.krt_profileID AS krt_id,
                        krt__pekerjaan.pekerjaan_peratus AS peratus_pekerjaan
                        FROM krt__pekerjaan 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__pekerjaan.krt_profileID
                        WHERE krt__pekerjaan.profession_id = 2
                ) swasta on swasta.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__pekerjaan.krt_profileID AS krt_id,
                        krt__pekerjaan.pekerjaan_peratus AS peratus_pekerjaan
                        FROM krt__pekerjaan 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__pekerjaan.krt_profileID
                        WHERE krt__pekerjaan.profession_id = 3
                ) sendiri on sendiri.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__pekerjaan.krt_profileID AS krt_id,
                        krt__pekerjaan.pekerjaan_peratus AS peratus_pekerjaan
                        FROM krt__pekerjaan 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__pekerjaan.krt_profileID
                        WHERE krt__pekerjaan.profession_id = 4
                ) xbekerja on xbekerja.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__pekerjaan.krt_profileID AS krt_id,
                        krt__pekerjaan.pekerjaan_peratus AS peratus_pekerjaan
                        FROM krt__pekerjaan 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__pekerjaan.krt_profileID
                        WHERE krt__pekerjaan.profession_id = 5
                ) pesara on pesara.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__pekerjaan.krt_profileID AS krt_id,
                        krt__pekerjaan.pekerjaan_peratus AS peratus_pekerjaan
                        FROM krt__pekerjaan 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__pekerjaan.krt_profileID
                        WHERE krt__pekerjaan.profession_id = 6
                ) pelajar on pelajar.krt_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND krt__profile.state_id = '" . Auth::user()->state_id . "' "));
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
            return view('rt-sm30.laporan-maklumat-asas-krt-2-ppn',compact('roles_menu','daerah'));
        }
    }

    function laporan_maklumat_asas_krt_2_hqrt(Request $request){
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
            $data = DB::select(DB::raw("
            SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS krt_nama,
                (case when melayu.total_kaum IS NOT NULL then melayu.total_kaum else 0 end)AS total_melayu,
                (case when cina.total_kaum IS NOT NULL then cina.total_kaum else 0 end)AS total_cina,
                (case when india.total_kaum IS NOT NULL then india.total_kaum else 0 end)AS total_india,
                (case when sabah.total_kaum IS NOT NULL then sabah.total_kaum else 0 end)AS total_sabah,
                (case when sarawak.total_kaum IS NOT NULL then sarawak.total_kaum else 0 end)AS total_sarawak,
                (case when kerajaan.peratus_pekerjaan IS NOT NULL then kerajaan.peratus_pekerjaan else 0 end)AS total_kerjaan,
                (case when swasta.peratus_pekerjaan IS NOT NULL then swasta.peratus_pekerjaan else 0 end)AS total_swasta,
                (case when sendiri.peratus_pekerjaan IS NOT NULL then sendiri.peratus_pekerjaan else 0 end)AS total_sendiri,
                (case when xbekerja.peratus_pekerjaan IS NOT NULL then xbekerja.peratus_pekerjaan else 0 end)AS total_xbekerja,
                (case when pesara.peratus_pekerjaan IS NOT NULL then pesara.peratus_pekerjaan else 0 end)AS total_pesara,
                (case when pelajar.peratus_pekerjaan IS NOT NULL then pelajar.peratus_pekerjaan else 0 end)AS total_pelajar
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN (
                        SELECT
                        krt__komposisi_penduduk.krt_profileID AS krt_id,
                        SUM(krt__komposisi_penduduk.komposisi_jumlah) AS total_kaum
                        FROM krt__komposisi_penduduk 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__komposisi_penduduk.krt_profileID
                        WHERE krt__komposisi_penduduk.komposisi_kaum IN (1,2,3,4,5,6,7)
                        GROUP BY krt__komposisi_penduduk.krt_profileID
                ) melayu on melayu.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__komposisi_penduduk.krt_profileID AS krt_id,
                        SUM(krt__komposisi_penduduk.komposisi_jumlah) AS total_kaum
                        FROM krt__komposisi_penduduk 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__komposisi_penduduk.krt_profileID
                        WHERE krt__komposisi_penduduk.komposisi_kaum IN (8,9,10,11,12,13,14,15,16,17,18,19,20)
                        GROUP BY krt__komposisi_penduduk.krt_profileID
                ) cina on cina.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__komposisi_penduduk.krt_profileID AS krt_id,
                        SUM(krt__komposisi_penduduk.komposisi_jumlah) AS total_kaum
                        FROM krt__komposisi_penduduk 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__komposisi_penduduk.krt_profileID
                        WHERE krt__komposisi_penduduk.komposisi_kaum IN (21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37)
                        GROUP BY krt__komposisi_penduduk.krt_profileID
                ) india on india.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__komposisi_penduduk.krt_profileID AS krt_id,
                        SUM(krt__komposisi_penduduk.komposisi_jumlah) AS total_kaum
                        FROM krt__komposisi_penduduk 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__komposisi_penduduk.krt_profileID
                        WHERE krt__komposisi_penduduk.komposisi_kaum IN (40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96)
                        GROUP BY krt__komposisi_penduduk.krt_profileID
                ) sabah on sabah.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__komposisi_penduduk.krt_profileID AS krt_id,
                        SUM(krt__komposisi_penduduk.komposisi_jumlah) AS total_kaum
                        FROM krt__komposisi_penduduk 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__komposisi_penduduk.krt_profileID
                        WHERE krt__komposisi_penduduk.komposisi_kaum IN (97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167,168,169,170,171)
                        GROUP BY krt__komposisi_penduduk.krt_profileID
                ) sarawak on sarawak.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__pekerjaan.krt_profileID AS krt_id,
                        krt__pekerjaan.pekerjaan_peratus AS peratus_pekerjaan
                        FROM krt__pekerjaan 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__pekerjaan.krt_profileID
                        WHERE krt__pekerjaan.profession_id = 1
                ) kerajaan on kerajaan.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__pekerjaan.krt_profileID AS krt_id,
                        krt__pekerjaan.pekerjaan_peratus AS peratus_pekerjaan
                        FROM krt__pekerjaan 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__pekerjaan.krt_profileID
                        WHERE krt__pekerjaan.profession_id = 2
                ) swasta on swasta.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__pekerjaan.krt_profileID AS krt_id,
                        krt__pekerjaan.pekerjaan_peratus AS peratus_pekerjaan
                        FROM krt__pekerjaan 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__pekerjaan.krt_profileID
                        WHERE krt__pekerjaan.profession_id = 3
                ) sendiri on sendiri.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__pekerjaan.krt_profileID AS krt_id,
                        krt__pekerjaan.pekerjaan_peratus AS peratus_pekerjaan
                        FROM krt__pekerjaan 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__pekerjaan.krt_profileID
                        WHERE krt__pekerjaan.profession_id = 4
                ) xbekerja on xbekerja.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__pekerjaan.krt_profileID AS krt_id,
                        krt__pekerjaan.pekerjaan_peratus AS peratus_pekerjaan
                        FROM krt__pekerjaan 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__pekerjaan.krt_profileID
                        WHERE krt__pekerjaan.profession_id = 5
                ) pesara on pesara.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__pekerjaan.krt_profileID AS krt_id,
                        krt__pekerjaan.pekerjaan_peratus AS peratus_pekerjaan
                        FROM krt__pekerjaan 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__pekerjaan.krt_profileID
                        WHERE krt__pekerjaan.profession_id = 6
                ) pelajar on pelajar.krt_id = krt__profile.id
                WHERE krt__profile.krt_status = 1"));
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
            $state   = RefStates::where('status', '=',  true)->get();
            return view('rt-sm30.laporan-maklumat-asas-krt-2-hqrt',compact('roles_menu','state'));
        }
    }

    function laporan_maklumat_asas_krt_2_kp(Request $request){
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
            $data = DB::select(DB::raw("
            SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS krt_nama,
                (case when melayu.total_kaum IS NOT NULL then melayu.total_kaum else 0 end)AS total_melayu,
                (case when cina.total_kaum IS NOT NULL then cina.total_kaum else 0 end)AS total_cina,
                (case when india.total_kaum IS NOT NULL then india.total_kaum else 0 end)AS total_india,
                (case when sabah.total_kaum IS NOT NULL then sabah.total_kaum else 0 end)AS total_sabah,
                (case when sarawak.total_kaum IS NOT NULL then sarawak.total_kaum else 0 end)AS total_sarawak,
                (case when kerajaan.peratus_pekerjaan IS NOT NULL then kerajaan.peratus_pekerjaan else 0 end)AS total_kerjaan,
                (case when swasta.peratus_pekerjaan IS NOT NULL then swasta.peratus_pekerjaan else 0 end)AS total_swasta,
                (case when sendiri.peratus_pekerjaan IS NOT NULL then sendiri.peratus_pekerjaan else 0 end)AS total_sendiri,
                (case when xbekerja.peratus_pekerjaan IS NOT NULL then xbekerja.peratus_pekerjaan else 0 end)AS total_xbekerja,
                (case when pesara.peratus_pekerjaan IS NOT NULL then pesara.peratus_pekerjaan else 0 end)AS total_pesara,
                (case when pelajar.peratus_pekerjaan IS NOT NULL then pelajar.peratus_pekerjaan else 0 end)AS total_pelajar
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN (
                        SELECT
                        krt__komposisi_penduduk.krt_profileID AS krt_id,
                        SUM(krt__komposisi_penduduk.komposisi_jumlah) AS total_kaum
                        FROM krt__komposisi_penduduk 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__komposisi_penduduk.krt_profileID
                        WHERE krt__komposisi_penduduk.komposisi_kaum IN (1,2,3,4,5,6,7)
                        GROUP BY krt__komposisi_penduduk.krt_profileID
                ) melayu on melayu.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__komposisi_penduduk.krt_profileID AS krt_id,
                        SUM(krt__komposisi_penduduk.komposisi_jumlah) AS total_kaum
                        FROM krt__komposisi_penduduk 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__komposisi_penduduk.krt_profileID
                        WHERE krt__komposisi_penduduk.komposisi_kaum IN (8,9,10,11,12,13,14,15,16,17,18,19,20)
                        GROUP BY krt__komposisi_penduduk.krt_profileID
                ) cina on cina.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__komposisi_penduduk.krt_profileID AS krt_id,
                        SUM(krt__komposisi_penduduk.komposisi_jumlah) AS total_kaum
                        FROM krt__komposisi_penduduk 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__komposisi_penduduk.krt_profileID
                        WHERE krt__komposisi_penduduk.komposisi_kaum IN (21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37)
                        GROUP BY krt__komposisi_penduduk.krt_profileID
                ) india on india.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__komposisi_penduduk.krt_profileID AS krt_id,
                        SUM(krt__komposisi_penduduk.komposisi_jumlah) AS total_kaum
                        FROM krt__komposisi_penduduk 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__komposisi_penduduk.krt_profileID
                        WHERE krt__komposisi_penduduk.komposisi_kaum IN (40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96)
                        GROUP BY krt__komposisi_penduduk.krt_profileID
                ) sabah on sabah.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__komposisi_penduduk.krt_profileID AS krt_id,
                        SUM(krt__komposisi_penduduk.komposisi_jumlah) AS total_kaum
                        FROM krt__komposisi_penduduk 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__komposisi_penduduk.krt_profileID
                        WHERE krt__komposisi_penduduk.komposisi_kaum IN (97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167,168,169,170,171)
                        GROUP BY krt__komposisi_penduduk.krt_profileID
                ) sarawak on sarawak.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__pekerjaan.krt_profileID AS krt_id,
                        krt__pekerjaan.pekerjaan_peratus AS peratus_pekerjaan
                        FROM krt__pekerjaan 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__pekerjaan.krt_profileID
                        WHERE krt__pekerjaan.profession_id = 1
                ) kerajaan on kerajaan.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__pekerjaan.krt_profileID AS krt_id,
                        krt__pekerjaan.pekerjaan_peratus AS peratus_pekerjaan
                        FROM krt__pekerjaan 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__pekerjaan.krt_profileID
                        WHERE krt__pekerjaan.profession_id = 2
                ) swasta on swasta.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__pekerjaan.krt_profileID AS krt_id,
                        krt__pekerjaan.pekerjaan_peratus AS peratus_pekerjaan
                        FROM krt__pekerjaan 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__pekerjaan.krt_profileID
                        WHERE krt__pekerjaan.profession_id = 3
                ) sendiri on sendiri.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__pekerjaan.krt_profileID AS krt_id,
                        krt__pekerjaan.pekerjaan_peratus AS peratus_pekerjaan
                        FROM krt__pekerjaan 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__pekerjaan.krt_profileID
                        WHERE krt__pekerjaan.profession_id = 4
                ) xbekerja on xbekerja.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__pekerjaan.krt_profileID AS krt_id,
                        krt__pekerjaan.pekerjaan_peratus AS peratus_pekerjaan
                        FROM krt__pekerjaan 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__pekerjaan.krt_profileID
                        WHERE krt__pekerjaan.profession_id = 5
                ) pesara on pesara.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__pekerjaan.krt_profileID AS krt_id,
                        krt__pekerjaan.pekerjaan_peratus AS peratus_pekerjaan
                        FROM krt__pekerjaan 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__pekerjaan.krt_profileID
                        WHERE krt__pekerjaan.profession_id = 6
                ) pelajar on pelajar.krt_id = krt__profile.id
                WHERE krt__profile.krt_status = 1"));
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
            $state   = RefStates::where('status', '=',  true)->get();
            return view('rt-sm30.laporan-maklumat-asas-krt-2-hqrt',compact('roles_menu','state'));
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function laporan_maklumat_asas_krt_3_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
           
            $data = DB::select(DB::raw("
            SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS krt_nama,
                (case when r_sebuah.jumlah_rumah IS NOT NULL then r_sebuah.jumlah_rumah else 0 end)AS total_r_sebuah,
                (case when r_teres.jumlah_rumah IS NOT NULL then r_teres.jumlah_rumah else 0 end)AS total_r_teres,
                (case when r_kampung.jumlah_rumah IS NOT NULL then r_kampung.jumlah_rumah else 0 end)AS total_r_kampung,
                (case when r_stinggan.jumlah_rumah IS NOT NULL then r_stinggan.jumlah_rumah else 0 end)AS total_r_stinggan,
                (case when r_berkembar.jumlah_rumah IS NOT NULL then r_berkembar.jumlah_rumah else 0 end)AS total_r_berkembar,
                (case when r_flat.jumlah_rumah IS NOT NULL then r_flat.jumlah_rumah else 0 end)AS total_r_flat,
                (case when r_kondo.jumlah_rumah IS NOT NULL then r_kondo.jumlah_rumah else 0 end)AS total_r_kondo,
                (case when r_apartment.jumlah_rumah IS NOT NULL then r_apartment.jumlah_rumah else 0 end)AS total_r_apartment,
                (case when r_kedai.jumlah_rumah IS NOT NULL then r_kedai.jumlah_rumah else 0 end)AS total_r_kedai,
                k_a.kemudahan_awam AS kemudahan_awam,
	        k_j.kes_jenayah AS kes_jenayah,
                m_s.maslah_sosial AS maslah_sosial,
                k_p.kawasan_pertanian AS kawasan_pertanian
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 1
                ) r_sebuah on r_sebuah.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 2
                ) r_teres on r_teres.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 3
                ) r_kampung on r_kampung.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 4
                ) r_stinggan on r_stinggan.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 5
                ) r_berkembar on r_berkembar.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 6
                ) r_flat on r_flat.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 7
                ) r_kondo on r_kondo.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 8
                ) r_apartment on r_apartment.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 9
                ) r_kedai on r_kedai.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__kemudahan_awam.krt_profileID AS krt_id,
                        GROUP_CONCAT(ref__kemudahan_awam.kemudahan_awam_description , ' ' ) AS kemudahan_awam
                        FROM krt__kemudahan_awam 
                        LEFT JOIN ref__kemudahan_awam ON ref__kemudahan_awam.id = krt__kemudahan_awam.ref_kemudahan_awamID
                        GROUP BY krt_id
                ) k_a on k_a.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__kes_jenayah.krt_profileID AS krt_id,
                        GROUP_CONCAT(ref__jenayah.jenayah_description , ' ' ) AS kes_jenayah
                        FROM krt__kes_jenayah
                        LEFT JOIN ref__jenayah ON ref__jenayah.id = krt__kes_jenayah.ref_jenayahID
                        GROUP BY krt_id
                ) k_j on k_j.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__masalah_sosial.krt_profileID AS krt_id,
                        GROUP_CONCAT(ref__masalah_sosial.sosial_description , ' ' ) AS maslah_sosial
                        FROM krt__masalah_sosial
                        LEFT JOIN ref__masalah_sosial ON ref__masalah_sosial.id = krt__masalah_sosial.ref_masalahSosialID
                        GROUP BY krt_id
                ) m_s on m_s.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__kawasan_pertanian.krt_profileID AS krt_id,
                        GROUP_CONCAT(ref__pertanian.pertanian_description , ' ' ) AS kawasan_pertanian
                        FROM krt__kawasan_pertanian
                        LEFT JOIN ref__pertanian ON ref__pertanian.id = krt__kawasan_pertanian.ref_pertanianID
                        GROUP BY krt_id
                ) k_p on k_p.krt_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND krt__profile.daerah_id = '" . Auth::user()->daerah_id . "'"));
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
            $state   = RefStates::where('status', '=',  true)->get();
            return view('rt-sm30.laporan-maklumat-asas-krt-3-ppd',compact('roles_menu','state'));
        }
    }

    function laporan_maklumat_asas_krt_3_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
           
            $data = DB::select(DB::raw("
            SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS krt_nama,
                (case when r_sebuah.jumlah_rumah IS NOT NULL then r_sebuah.jumlah_rumah else 0 end)AS total_r_sebuah,
                (case when r_teres.jumlah_rumah IS NOT NULL then r_teres.jumlah_rumah else 0 end)AS total_r_teres,
                (case when r_kampung.jumlah_rumah IS NOT NULL then r_kampung.jumlah_rumah else 0 end)AS total_r_kampung,
                (case when r_stinggan.jumlah_rumah IS NOT NULL then r_stinggan.jumlah_rumah else 0 end)AS total_r_stinggan,
                (case when r_berkembar.jumlah_rumah IS NOT NULL then r_berkembar.jumlah_rumah else 0 end)AS total_r_berkembar,
                (case when r_flat.jumlah_rumah IS NOT NULL then r_flat.jumlah_rumah else 0 end)AS total_r_flat,
                (case when r_kondo.jumlah_rumah IS NOT NULL then r_kondo.jumlah_rumah else 0 end)AS total_r_kondo,
                (case when r_apartment.jumlah_rumah IS NOT NULL then r_apartment.jumlah_rumah else 0 end)AS total_r_apartment,
                (case when r_kedai.jumlah_rumah IS NOT NULL then r_kedai.jumlah_rumah else 0 end)AS total_r_kedai,
                k_a.kemudahan_awam AS kemudahan_awam,
	        k_j.kes_jenayah AS kes_jenayah,
                m_s.maslah_sosial AS maslah_sosial,
                k_p.kawasan_pertanian AS kawasan_pertanian
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 1
                ) r_sebuah on r_sebuah.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 2
                ) r_teres on r_teres.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 3
                ) r_kampung on r_kampung.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 4
                ) r_stinggan on r_stinggan.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 5
                ) r_berkembar on r_berkembar.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 6
                ) r_flat on r_flat.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 7
                ) r_kondo on r_kondo.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 8
                ) r_apartment on r_apartment.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 9
                ) r_kedai on r_kedai.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__kemudahan_awam.krt_profileID AS krt_id,
                        GROUP_CONCAT(ref__kemudahan_awam.kemudahan_awam_description , ' ' ) AS kemudahan_awam
                        FROM krt__kemudahan_awam 
                        LEFT JOIN ref__kemudahan_awam ON ref__kemudahan_awam.id = krt__kemudahan_awam.ref_kemudahan_awamID
                        GROUP BY krt_id
                ) k_a on k_a.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__kes_jenayah.krt_profileID AS krt_id,
                        GROUP_CONCAT(ref__jenayah.jenayah_description , ' ' ) AS kes_jenayah
                        FROM krt__kes_jenayah
                        LEFT JOIN ref__jenayah ON ref__jenayah.id = krt__kes_jenayah.ref_jenayahID
                        GROUP BY krt_id
                ) k_j on k_j.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__masalah_sosial.krt_profileID AS krt_id,
                        GROUP_CONCAT(ref__masalah_sosial.sosial_description , ' ' ) AS maslah_sosial
                        FROM krt__masalah_sosial
                        LEFT JOIN ref__masalah_sosial ON ref__masalah_sosial.id = krt__masalah_sosial.ref_masalahSosialID
                        GROUP BY krt_id
                ) m_s on m_s.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__kawasan_pertanian.krt_profileID AS krt_id,
                        GROUP_CONCAT(ref__pertanian.pertanian_description , ' ' ) AS kawasan_pertanian
                        FROM krt__kawasan_pertanian
                        LEFT JOIN ref__pertanian ON ref__pertanian.id = krt__kawasan_pertanian.ref_pertanianID
                        GROUP BY krt_id
                ) k_p on k_p.krt_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND krt__profile.state_id = '" . Auth::user()->state_id . "'"));
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
            return view('rt-sm30.laporan-maklumat-asas-krt-3-ppn',compact('roles_menu','daerah'));
        }
    }
    
    function laporan_maklumat_asas_krt_3_hqrt(Request $request){
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
            $data = DB::select(DB::raw("
            SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS krt_nama,
                (case when r_sebuah.jumlah_rumah IS NOT NULL then r_sebuah.jumlah_rumah else 0 end)AS total_r_sebuah,
                (case when r_teres.jumlah_rumah IS NOT NULL then r_teres.jumlah_rumah else 0 end)AS total_r_teres,
                (case when r_kampung.jumlah_rumah IS NOT NULL then r_kampung.jumlah_rumah else 0 end)AS total_r_kampung,
                (case when r_stinggan.jumlah_rumah IS NOT NULL then r_stinggan.jumlah_rumah else 0 end)AS total_r_stinggan,
                (case when r_berkembar.jumlah_rumah IS NOT NULL then r_berkembar.jumlah_rumah else 0 end)AS total_r_berkembar,
                (case when r_flat.jumlah_rumah IS NOT NULL then r_flat.jumlah_rumah else 0 end)AS total_r_flat,
                (case when r_kondo.jumlah_rumah IS NOT NULL then r_kondo.jumlah_rumah else 0 end)AS total_r_kondo,
                (case when r_apartment.jumlah_rumah IS NOT NULL then r_apartment.jumlah_rumah else 0 end)AS total_r_apartment,
                (case when r_kedai.jumlah_rumah IS NOT NULL then r_kedai.jumlah_rumah else 0 end)AS total_r_kedai,
                k_a.kemudahan_awam AS kemudahan_awam,
	        k_j.kes_jenayah AS kes_jenayah,
                m_s.maslah_sosial AS maslah_sosial,
                k_p.kawasan_pertanian AS kawasan_pertanian
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 1
                ) r_sebuah on r_sebuah.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 2
                ) r_teres on r_teres.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 3
                ) r_kampung on r_kampung.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 4
                ) r_stinggan on r_stinggan.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 5
                ) r_berkembar on r_berkembar.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 6
                ) r_flat on r_flat.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 7
                ) r_kondo on r_kondo.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 8
                ) r_apartment on r_apartment.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 9
                ) r_kedai on r_kedai.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__kemudahan_awam.krt_profileID AS krt_id,
                        GROUP_CONCAT(ref__kemudahan_awam.kemudahan_awam_description , ' ' ) AS kemudahan_awam
                        FROM krt__kemudahan_awam 
                        LEFT JOIN ref__kemudahan_awam ON ref__kemudahan_awam.id = krt__kemudahan_awam.ref_kemudahan_awamID
                        GROUP BY krt_id
                ) k_a on k_a.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__kes_jenayah.krt_profileID AS krt_id,
                        GROUP_CONCAT(ref__jenayah.jenayah_description , ' ' ) AS kes_jenayah
                        FROM krt__kes_jenayah
                        LEFT JOIN ref__jenayah ON ref__jenayah.id = krt__kes_jenayah.ref_jenayahID
                        GROUP BY krt_id
                ) k_j on k_j.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__masalah_sosial.krt_profileID AS krt_id,
                        GROUP_CONCAT(ref__masalah_sosial.sosial_description , ' ' ) AS maslah_sosial
                        FROM krt__masalah_sosial
                        LEFT JOIN ref__masalah_sosial ON ref__masalah_sosial.id = krt__masalah_sosial.ref_masalahSosialID
                        GROUP BY krt_id
                ) m_s on m_s.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__kawasan_pertanian.krt_profileID AS krt_id,
                        GROUP_CONCAT(ref__pertanian.pertanian_description , ' ' ) AS kawasan_pertanian
                        FROM krt__kawasan_pertanian
                        LEFT JOIN ref__pertanian ON ref__pertanian.id = krt__kawasan_pertanian.ref_pertanianID
                        GROUP BY krt_id
                ) k_p on k_p.krt_id = krt__profile.id
                WHERE krt__profile.krt_status = 1"));
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
            $state   = RefStates::where('status', '=',  true)->get();
            return view('rt-sm30.laporan-maklumat-asas-krt-3-hqrt',compact('roles_menu','state'));
        }
    }

    function laporan_maklumat_asas_krt_3_kp(Request $request){
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
            $data = DB::select(DB::raw("
            SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS krt_nama,
                (case when r_sebuah.jumlah_rumah IS NOT NULL then r_sebuah.jumlah_rumah else 0 end)AS total_r_sebuah,
                (case when r_teres.jumlah_rumah IS NOT NULL then r_teres.jumlah_rumah else 0 end)AS total_r_teres,
                (case when r_kampung.jumlah_rumah IS NOT NULL then r_kampung.jumlah_rumah else 0 end)AS total_r_kampung,
                (case when r_stinggan.jumlah_rumah IS NOT NULL then r_stinggan.jumlah_rumah else 0 end)AS total_r_stinggan,
                (case when r_berkembar.jumlah_rumah IS NOT NULL then r_berkembar.jumlah_rumah else 0 end)AS total_r_berkembar,
                (case when r_flat.jumlah_rumah IS NOT NULL then r_flat.jumlah_rumah else 0 end)AS total_r_flat,
                (case when r_kondo.jumlah_rumah IS NOT NULL then r_kondo.jumlah_rumah else 0 end)AS total_r_kondo,
                (case when r_apartment.jumlah_rumah IS NOT NULL then r_apartment.jumlah_rumah else 0 end)AS total_r_apartment,
                (case when r_kedai.jumlah_rumah IS NOT NULL then r_kedai.jumlah_rumah else 0 end)AS total_r_kedai,
                k_a.kemudahan_awam AS kemudahan_awam,
	        k_j.kes_jenayah AS kes_jenayah,
                m_s.maslah_sosial AS maslah_sosial,
                k_p.kawasan_pertanian AS kawasan_pertanian
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 1
                ) r_sebuah on r_sebuah.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 2
                ) r_teres on r_teres.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 3
                ) r_kampung on r_kampung.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 4
                ) r_stinggan on r_stinggan.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 5
                ) r_berkembar on r_berkembar.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 6
                ) r_flat on r_flat.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 7
                ) r_kondo on r_kondo.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 8
                ) r_apartment on r_apartment.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__jenis_rumah.krt_profileID AS krt_id,
                        krt__jenis_rumah.jumlah_pintu AS jumlah_rumah
                        FROM krt__jenis_rumah 
                        LEFT JOIN krt__profile ON krt__profile.id = krt__jenis_rumah.krt_profileID
                        WHERE krt__jenis_rumah.jenis_rumah_id = 9
                ) r_kedai on r_kedai.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__kemudahan_awam.krt_profileID AS krt_id,
                        GROUP_CONCAT(ref__kemudahan_awam.kemudahan_awam_description , ' ' ) AS kemudahan_awam
                        FROM krt__kemudahan_awam 
                        LEFT JOIN ref__kemudahan_awam ON ref__kemudahan_awam.id = krt__kemudahan_awam.ref_kemudahan_awamID
                        GROUP BY krt_id
                ) k_a on k_a.krt_id = krt__profile.id
								LEFT JOIN (
                        SELECT
                        krt__kes_jenayah.krt_profileID AS krt_id,
                        GROUP_CONCAT(ref__jenayah.jenayah_description , ' ' ) AS kes_jenayah
                        FROM krt__kes_jenayah
                        LEFT JOIN ref__jenayah ON ref__jenayah.id = krt__kes_jenayah.ref_jenayahID
                        GROUP BY krt_id
                ) k_j on k_j.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__masalah_sosial.krt_profileID AS krt_id,
                        GROUP_CONCAT(ref__masalah_sosial.sosial_description , ' ' ) AS maslah_sosial
                        FROM krt__masalah_sosial
                        LEFT JOIN ref__masalah_sosial ON ref__masalah_sosial.id = krt__masalah_sosial.ref_masalahSosialID
                        GROUP BY krt_id
                ) m_s on m_s.krt_id = krt__profile.id
                LEFT JOIN (
                        SELECT
                        krt__kawasan_pertanian.krt_profileID AS krt_id,
                        GROUP_CONCAT(ref__pertanian.pertanian_description , ' ' ) AS kawasan_pertanian
                        FROM krt__kawasan_pertanian
                        LEFT JOIN ref__pertanian ON ref__pertanian.id = krt__kawasan_pertanian.ref_pertanianID
                        GROUP BY krt_id
                ) k_p on k_p.krt_id = krt__profile.id
                WHERE krt__profile.krt_status = 1"));
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
            $state   = RefStates::where('status', '=',  true)->get();
            return view('rt-sm30.laporan-maklumat-asas-krt-3-kp',compact('roles_menu','state'));
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function laporan_maklumat_asas_krt_4_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            
            
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
            return view('rt-sm30.laporan-maklumat-asas-krt-4-ppd',compact('roles_menu'));
        }
        
    }

    function laporan_maklumat_asas_krt_4_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            
            
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
            return view('rt-sm30.laporan-maklumat-asas-krt-4-ppn',compact('roles_menu'));
        }
        
    }

    function laporan_maklumat_asas_krt_4_hqrt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            
            
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
            return view('rt-sm30.laporan-maklumat-asas-krt-4-hqrt',compact('roles_menu'));
        }
        
    }

    function laporan_maklumat_asas_krt_4_kp(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            
            
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
            return view('rt-sm30.laporan-maklumat-asas-krt-4-kp',compact('roles_menu'));
        }
        
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function laporan_aktiviti_rt_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
           
            $data = DB::select(DB::raw("
            SELECT
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS krt_name,
                ref__penganjur.penganjur_description AS penganjur,
                krt__aktiviti_laporan.aktiviti_tajuk AS tajuk_aktiviti,
                krt__aktiviti_laporan.aktiviti_perasmi AS perasmi_aktiviti,
                ref__aktiviti_agenda_kerja.agenda_description AS agenda_kerja,
                ref__aktiviti_bidang.bidang_description AS bidang_kerja,
                ref__aktiviti.aktiviti_description AS kategori_aktiviti,
                ref__jenis_aktiviti.aktiviti_description AS jenis_aktiviti
             FROM krt__aktiviti_laporan
             LEFT JOIN krt__profile ON krt__profile.id = krt__aktiviti_laporan.krt_profile_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__penganjur ON ref__penganjur.id = krt__aktiviti_laporan.penganjur_id
                LEFT JOIN ref__aktiviti_agenda_kerja ON ref__aktiviti_agenda_kerja.id = krt__aktiviti_laporan.agenda_id
                LEFT JOIN ref__aktiviti_bidang ON ref__aktiviti_bidang.id = krt__aktiviti_laporan.bidang_id
                LEFT JOIN ref__aktiviti ON ref__aktiviti.id = krt__aktiviti_laporan.aktiviti_id
                LEFT JOIN ref__jenis_aktiviti ON ref__jenis_aktiviti.id = krt__aktiviti_laporan.sub_aktiviti_id
                WHERE krt__aktiviti_laporan.aktiviti_status = 1 AND krt__profile.daerah_id = '" . Auth::user()->daerah_id . "' "));
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
                $agenda     = Ref_Aktiviti_Agenda_Kerja::where('status', '=',  true)
                            ->get();
                $bidang     = Ref_Aktiviti_Bidang::where('status', '=',  true)
                            ->get();
                $k_aktiviti = Ref_Aktiviti::where('status', '=',  true)
                            ->get();
                $j_aktiviti = Ref_Jenis_Aktiviti::where('status', '=',  true)
                            ->get();
            return view('rt-sm30.laporan-aktiviti-rt-ppd',compact('roles_menu', 'agenda', 'bidang', 'k_aktiviti', 'j_aktiviti'));
        }
    }

    function laporan_aktiviti_rt_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
           
            $data = DB::select(DB::raw("
            SELECT
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS krt_name,
                ref__penganjur.penganjur_description AS penganjur,
                krt__aktiviti_laporan.aktiviti_tajuk AS tajuk_aktiviti,
                krt__aktiviti_laporan.aktiviti_perasmi AS perasmi_aktiviti,
                ref__aktiviti_agenda_kerja.agenda_description AS agenda_kerja,
                ref__aktiviti_bidang.bidang_description AS bidang_kerja,
                ref__aktiviti.aktiviti_description AS kategori_aktiviti,
                ref__jenis_aktiviti.aktiviti_description AS jenis_aktiviti
            FROM krt__aktiviti_laporan
            LEFT JOIN krt__profile ON krt__profile.id = krt__aktiviti_laporan.krt_profile_id
            LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
            LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
            LEFT JOIN ref__penganjur ON ref__penganjur.id = krt__aktiviti_laporan.penganjur_id
            LEFT JOIN ref__aktiviti_agenda_kerja ON ref__aktiviti_agenda_kerja.id = krt__aktiviti_laporan.agenda_id
            LEFT JOIN ref__aktiviti_bidang ON ref__aktiviti_bidang.id = krt__aktiviti_laporan.bidang_id
            LEFT JOIN ref__aktiviti ON ref__aktiviti.id = krt__aktiviti_laporan.aktiviti_id
            LEFT JOIN ref__jenis_aktiviti ON ref__jenis_aktiviti.id = krt__aktiviti_laporan.sub_aktiviti_id
            WHERE krt__aktiviti_laporan.aktiviti_status = 1  AND krt__profile.state_id = '" . Auth::user()->state_id . "' "));
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
                $agenda     = Ref_Aktiviti_Agenda_Kerja::where('status', '=',  true)
                            ->get();
                $bidang     = Ref_Aktiviti_Bidang::where('status', '=',  true)
                            ->get();
                $k_aktiviti = Ref_Aktiviti::where('status', '=',  true)
                            ->get();
                $j_aktiviti = Ref_Jenis_Aktiviti::where('status', '=',  true)
                            ->get();
            return view('rt-sm30.laporan-aktiviti-rt-ppn',compact('roles_menu','daerah','agenda', 'bidang', 'k_aktiviti', 'j_aktiviti'));
        }
    }

    function laporan_aktiviti_rt_hqrt(Request $request){
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
            /*$data = DB::select(DB::raw("
					SELECT
						ref__states.state_description AS state,
						ref__daerahs.daerah_description AS daerah,
						krt__profile.krt_nama AS krt_name,
						ref__penganjur.penganjur_description AS penganjur,
						krt__aktiviti_laporan.aktiviti_tajuk AS tajuk_aktiviti,
						krt__aktiviti_laporan.aktiviti_perasmi AS perasmi_aktiviti,
						ref__aktiviti_agenda_kerja.agenda_description AS agenda_kerja,
						ref__aktiviti_bidang.bidang_description AS bidang_kerja,
						ref__aktiviti.aktiviti_description AS kategori_aktiviti,
						ref__jenis_aktiviti.aktiviti_description AS jenis_aktiviti,
						DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh,'%d/%m/%Y') AS tarikh_aktiviti,
						ref__aktiviti_program.program_description AS program,
						krt__aktiviti_laporan.program_id AS program_id
					FROM krt__aktiviti_laporan
					LEFT JOIN krt__profile ON krt__profile.id = krt__aktiviti_laporan.krt_profile_id
					LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
					LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
					LEFT JOIN ref__penganjur ON ref__penganjur.id = krt__aktiviti_laporan.penganjur_id
					LEFT JOIN ref__aktiviti_agenda_kerja ON ref__aktiviti_agenda_kerja.id = krt__aktiviti_laporan.agenda_id
					LEFT JOIN ref__aktiviti_bidang ON ref__aktiviti_bidang.id = krt__aktiviti_laporan.bidang_id
					LEFT JOIN ref__aktiviti ON ref__aktiviti.id = krt__aktiviti_laporan.aktiviti_id
					LEFT JOIN ref__jenis_aktiviti ON ref__jenis_aktiviti.id = krt__aktiviti_laporan.sub_aktiviti_id
					LEFT JOIN ref__aktiviti_program ON ref__aktiviti_program.id = krt__aktiviti_laporan.program_id
					WHERE krt__aktiviti_laporan.aktiviti_status = 1"));*/
			set_time_limit(300);
			$data = DB::table('krt__aktiviti_laporan')
					->select('ref__states.state_description AS state',
					  'ref__daerahs.daerah_description AS daerah',
					  'krt__profile.krt_nama AS krt_name',
					  'ref__penganjur.penganjur_description AS penganjur',
					  'krt__aktiviti_laporan.aktiviti_tajuk AS tajuk_aktiviti',
					  'krt__aktiviti_laporan.aktiviti_perasmi AS perasmi_aktiviti',
				      'ref__aktiviti_agenda_kerja.agenda_description AS agenda_kerja',
					  'ref__aktiviti_bidang.bidang_description AS bidang_kerja',
					  'ref__aktiviti.aktiviti_description AS kategori_aktiviti',
					  'ref__jenis_aktiviti.aktiviti_description AS jenis_aktiviti',
					   DB::raw("DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh,'%d/%m/%Y') AS tarikh_aktiviti"),
					   'ref__aktiviti_program.program_description AS program',
					   'krt__aktiviti_laporan.program_id AS program_id',
					   DB::raw("IFNULL(krt__aktiviti_jantinal.bilangan,0) AS jumlah_lelaki"),
					   DB::raw("IFNULL(krt__aktiviti_jantinap.bilangan,0) AS jumlah_perempuan"),
					   DB::raw("IFNULL(krt__aktiviti_umur1.bilangan,0) AS jumlah_umur1"),
					   DB::raw("IFNULL(krt__aktiviti_umur2.bilangan,0) AS jumlah_umur2"),
					   DB::raw("IFNULL(krt__aktiviti_umur3.bilangan,0) AS jumlah_umur3"),
					   DB::raw("IFNULL(krt__aktiviti_umur4.bilangan,0) AS jumlah_umur4"),
					   DB::raw("IFNULL(krt__aktiviti_umur5.bilangan,0) AS jumlah_umur5"),
					   DB::raw("IFNULL(krt__aktiviti_umur6.bilangan,0) AS jumlah_umur6"),
					   DB::raw("IFNULL(krt__aktiviti_umur7.bilangan,0) AS jumlah_umur7"))
					->leftjoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
					->leftjoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
					->leftjoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
					->leftjoin('ref__penganjur','ref__penganjur.id','=','krt__aktiviti_laporan.penganjur_id')
					->leftjoin('ref__aktiviti_agenda_kerja','ref__aktiviti_agenda_kerja.id','=','krt__aktiviti_laporan.agenda_id')
					->leftjoin('ref__aktiviti_bidang','ref__aktiviti_bidang.id','=','krt__aktiviti_laporan.bidang_id')
					->leftjoin('ref__aktiviti','ref__aktiviti.id','=','krt__aktiviti_laporan.aktiviti_id')
					->leftjoin('ref__jenis_aktiviti','ref__jenis_aktiviti.id','=','krt__aktiviti_laporan.sub_aktiviti_id')
					->leftjoin('ref__aktiviti_program','ref__aktiviti_program.id','=','krt__aktiviti_laporan.program_id')
					->leftjoin('krt__aktiviti_jantinal','krt__aktiviti_jantinal.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_jantinap','krt__aktiviti_jantinap.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur1','krt__aktiviti_umur1.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur2','krt__aktiviti_umur2.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur3','krt__aktiviti_umur3.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur4','krt__aktiviti_umur4.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur5','krt__aktiviti_umur5.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur6','krt__aktiviti_umur6.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur7','krt__aktiviti_umur7.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->where('krt__aktiviti_laporan.aktiviti_status','=',1)
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
            $state   = RefStates::where('status', '=',  true)->get();
            $agenda     = Ref_Aktiviti_Agenda_Kerja::where('status', '=',  true)
                            ->get();
            $agenda     = Ref_Aktiviti_Agenda_Kerja::where('status', '=',  true)
                            ->get();
            $bidang     = Ref_Aktiviti_Bidang::where('status', '=',  true)
                            ->get();
            $k_aktiviti = Ref_Aktiviti::where('status', '=',  true)
                            ->get();
            $j_aktiviti = Ref_Jenis_Aktiviti::where('status', '=',  true)
                            ->get();
            return view('rt-sm30.laporan-aktiviti-rt-hqrt',compact('roles_menu','state', 'agenda', 'bidang', 'k_aktiviti', 'j_aktiviti'));
        }
    }

    function laporan_aktiviti_rt_kp(Request $request){
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
            $data = DB::select(DB::raw("
            SELECT
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS krt_name,
                ref__penganjur.penganjur_description AS penganjur,
                krt__aktiviti_laporan.aktiviti_tajuk AS tajuk_aktiviti,
                krt__aktiviti_laporan.aktiviti_perasmi AS perasmi_aktiviti,
                ref__aktiviti_agenda_kerja.agenda_description AS agenda_kerja,
                ref__aktiviti_bidang.bidang_description AS bidang_kerja,
                ref__aktiviti.aktiviti_description AS kategori_aktiviti,
                ref__jenis_aktiviti.aktiviti_description AS jenis_aktiviti
            FROM krt__aktiviti_laporan
            LEFT JOIN krt__profile ON krt__profile.id = krt__aktiviti_laporan.krt_profile_id
            LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
            LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
            LEFT JOIN ref__penganjur ON ref__penganjur.id = krt__aktiviti_laporan.penganjur_id
            LEFT JOIN ref__aktiviti_agenda_kerja ON ref__aktiviti_agenda_kerja.id = krt__aktiviti_laporan.agenda_id
            LEFT JOIN ref__aktiviti_bidang ON ref__aktiviti_bidang.id = krt__aktiviti_laporan.bidang_id
            LEFT JOIN ref__aktiviti ON ref__aktiviti.id = krt__aktiviti_laporan.aktiviti_id
            LEFT JOIN ref__jenis_aktiviti ON ref__jenis_aktiviti.id = krt__aktiviti_laporan.sub_aktiviti_id
            WHERE krt__aktiviti_laporan.aktiviti_status = 1"));
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
            $state   = RefStates::where('status', '=',  true)->get();
            $agenda     = Ref_Aktiviti_Agenda_Kerja::where('status', '=',  true)
                            ->get();
            $agenda     = Ref_Aktiviti_Agenda_Kerja::where('status', '=',  true)
                            ->get();
            $bidang     = Ref_Aktiviti_Bidang::where('status', '=',  true)
                            ->get();
            $k_aktiviti = Ref_Aktiviti::where('status', '=',  true)
                            ->get();
            $j_aktiviti = Ref_Jenis_Aktiviti::where('status', '=',  true)
                            ->get();
            return view('rt-sm30.laporan-aktiviti-rt-kp',compact('roles_menu','state', 'agenda', 'bidang', 'k_aktiviti', 'j_aktiviti'));
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function laporan_aktiviti_rt_2_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
           
            $data = DB::select(DB::raw("
            SELECT
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS krt_name,
                ref__penganjur.penganjur_description AS penganjur,
                krt__aktiviti_laporan.aktiviti_tajuk AS tajuk_aktiviti,
                (case when lelaki.total_lelaki IS NOT NULL then lelaki.total_lelaki else 0 end)AS total_lelaki,
                (case when perempuan.total_perempuan IS NOT NULL then perempuan.total_perempuan else 0 end)AS total_perempuan,
                (case when umur_1.total_umur_1 IS NOT NULL then umur_1.total_umur_1 else 0 end)AS total_umur_1,
                (case when umur_2.total_umur_2 IS NOT NULL then umur_2.total_umur_2 else 0 end)AS total_umur_2,
                (case when umur_3.total_umur_3 IS NOT NULL then umur_3.total_umur_3 else 0 end)AS total_umur_3,
                (case when umur_4.total_umur_4 IS NOT NULL then umur_4.total_umur_4 else 0 end)AS total_umur_4,
                (case when umur_5.total_umur_5 IS NOT NULL then umur_5.total_umur_5 else 0 end)AS total_umur_5,
                (case when umur_6.total_umur_6 IS NOT NULL then umur_6.total_umur_6 else 0 end)AS total_umur_6,
                (case when umur_7.total_umur_7 IS NOT NULL then umur_7.total_umur_7 else 0 end)AS total_umur_7
                FROM krt__aktiviti_laporan
                LEFT JOIN krt__profile ON krt__profile.id = krt__aktiviti_laporan.krt_profile_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__penganjur ON ref__penganjur.id = krt__aktiviti_laporan.penganjur_id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_lelaki
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.jantina_id IN (1)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) lelaki on lelaki.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_perempuan
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.jantina_id IN (2)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) perempuan on perempuan.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_umur_1
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.umur_id IN (1)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) umur_1 on umur_1.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_umur_2
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.umur_id IN (2)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) umur_2 on umur_2.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_umur_3
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.umur_id IN (3)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) umur_3 on umur_3.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_umur_4
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.umur_id IN (4)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) umur_4 on umur_4.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_umur_5
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.umur_id IN (5)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) umur_5 on umur_5.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_umur_6
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.umur_id IN (6)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) umur_6 on umur_6.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_umur_7
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.umur_id IN (7)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) umur_7 on umur_7.laporan_id = krt__aktiviti_laporan.id
                WHERE krt__aktiviti_laporan.aktiviti_status = 1 AND krt__profile.daerah_id = '" . Auth::user()->daerah_id . "' "));
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
            return view('rt-sm30.laporan-aktiviti-rt-2-ppd',compact('roles_menu', 'daerah'));
        }
    }

    function laporan_aktiviti_rt_2_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
           
            $data = DB::select(DB::raw("
            SELECT
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS krt_name,
                ref__penganjur.penganjur_description AS penganjur,
                krt__aktiviti_laporan.aktiviti_tajuk AS tajuk_aktiviti,
                (case when lelaki.total_lelaki IS NOT NULL then lelaki.total_lelaki else 0 end)AS total_lelaki,
                (case when perempuan.total_perempuan IS NOT NULL then perempuan.total_perempuan else 0 end)AS total_perempuan,
                (case when umur_1.total_umur_1 IS NOT NULL then umur_1.total_umur_1 else 0 end)AS total_umur_1,
                (case when umur_2.total_umur_2 IS NOT NULL then umur_2.total_umur_2 else 0 end)AS total_umur_2,
                (case when umur_3.total_umur_3 IS NOT NULL then umur_3.total_umur_3 else 0 end)AS total_umur_3,
                (case when umur_4.total_umur_4 IS NOT NULL then umur_4.total_umur_4 else 0 end)AS total_umur_4,
                (case when umur_5.total_umur_5 IS NOT NULL then umur_5.total_umur_5 else 0 end)AS total_umur_5,
                (case when umur_6.total_umur_6 IS NOT NULL then umur_6.total_umur_6 else 0 end)AS total_umur_6,
                (case when umur_7.total_umur_7 IS NOT NULL then umur_7.total_umur_7 else 0 end)AS total_umur_7
                FROM krt__aktiviti_laporan
                LEFT JOIN krt__profile ON krt__profile.id = krt__aktiviti_laporan.krt_profile_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__penganjur ON ref__penganjur.id = krt__aktiviti_laporan.penganjur_id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_lelaki
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.jantina_id IN (1)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) lelaki on lelaki.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_perempuan
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.jantina_id IN (2)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) perempuan on perempuan.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_umur_1
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.umur_id IN (1)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) umur_1 on umur_1.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_umur_2
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.umur_id IN (2)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) umur_2 on umur_2.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_umur_3
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.umur_id IN (3)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) umur_3 on umur_3.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_umur_4
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.umur_id IN (4)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) umur_4 on umur_4.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_umur_5
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.umur_id IN (5)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) umur_5 on umur_5.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_umur_6
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.umur_id IN (6)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) umur_6 on umur_6.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_umur_7
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.umur_id IN (7)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) umur_7 on umur_7.laporan_id = krt__aktiviti_laporan.id
                WHERE krt__aktiviti_laporan.aktiviti_status = 1 AND krt__profile.state_id = '" . Auth::user()->state_id . "' "));
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
            return view('rt-sm30.laporan-aktiviti-rt-2-ppn',compact('roles_menu', 'daerah'));
        }
    }

    function laporan_aktiviti_rt_2_hqrt(Request $request){
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
            $data = DB::select(DB::raw("
            SELECT
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS krt_name,
                ref__penganjur.penganjur_description AS penganjur,
                krt__aktiviti_laporan.aktiviti_tajuk AS tajuk_aktiviti,
                (case when lelaki.total_lelaki IS NOT NULL then lelaki.total_lelaki else 0 end)AS total_lelaki,
                (case when perempuan.total_perempuan IS NOT NULL then perempuan.total_perempuan else 0 end)AS total_perempuan,
                (case when umur_1.total_umur_1 IS NOT NULL then umur_1.total_umur_1 else 0 end)AS total_umur_1,
                (case when umur_2.total_umur_2 IS NOT NULL then umur_2.total_umur_2 else 0 end)AS total_umur_2,
                (case when umur_3.total_umur_3 IS NOT NULL then umur_3.total_umur_3 else 0 end)AS total_umur_3,
                (case when umur_4.total_umur_4 IS NOT NULL then umur_4.total_umur_4 else 0 end)AS total_umur_4,
                (case when umur_5.total_umur_5 IS NOT NULL then umur_5.total_umur_5 else 0 end)AS total_umur_5,
                (case when umur_6.total_umur_6 IS NOT NULL then umur_6.total_umur_6 else 0 end)AS total_umur_6,
                (case when umur_7.total_umur_7 IS NOT NULL then umur_7.total_umur_7 else 0 end)AS total_umur_7
                FROM krt__aktiviti_laporan
                LEFT JOIN krt__profile ON krt__profile.id = krt__aktiviti_laporan.krt_profile_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__penganjur ON ref__penganjur.id = krt__aktiviti_laporan.penganjur_id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_lelaki
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.jantina_id IN (1)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) lelaki on lelaki.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_perempuan
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.jantina_id IN (2)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) perempuan on perempuan.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_umur_1
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.umur_id IN (1)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) umur_1 on umur_1.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_umur_2
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.umur_id IN (2)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) umur_2 on umur_2.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_umur_3
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.umur_id IN (3)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) umur_3 on umur_3.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_umur_4
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.umur_id IN (4)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) umur_4 on umur_4.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_umur_5
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.umur_id IN (5)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) umur_5 on umur_5.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_umur_6
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.umur_id IN (6)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) umur_6 on umur_6.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_umur_7
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.umur_id IN (7)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) umur_7 on umur_7.laporan_id = krt__aktiviti_laporan.id
                WHERE krt__aktiviti_laporan.aktiviti_status = 1 "));
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
                $state   = RefStates::where('status', '=',  true)->get();
            return view('rt-sm30.laporan-aktiviti-rt-2-hqrt',compact('roles_menu', 'state'));
        }
    }

    function laporan_aktiviti_rt_2_kp(Request $request){
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
            $data = DB::select(DB::raw("
            SELECT
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS krt_name,
                ref__penganjur.penganjur_description AS penganjur,
                krt__aktiviti_laporan.aktiviti_tajuk AS tajuk_aktiviti,
                (case when lelaki.total_lelaki IS NOT NULL then lelaki.total_lelaki else 0 end)AS total_lelaki,
                (case when perempuan.total_perempuan IS NOT NULL then perempuan.total_perempuan else 0 end)AS total_perempuan,
                (case when umur_1.total_umur_1 IS NOT NULL then umur_1.total_umur_1 else 0 end)AS total_umur_1,
                (case when umur_2.total_umur_2 IS NOT NULL then umur_2.total_umur_2 else 0 end)AS total_umur_2,
                (case when umur_3.total_umur_3 IS NOT NULL then umur_3.total_umur_3 else 0 end)AS total_umur_3,
                (case when umur_4.total_umur_4 IS NOT NULL then umur_4.total_umur_4 else 0 end)AS total_umur_4,
                (case when umur_5.total_umur_5 IS NOT NULL then umur_5.total_umur_5 else 0 end)AS total_umur_5,
                (case when umur_6.total_umur_6 IS NOT NULL then umur_6.total_umur_6 else 0 end)AS total_umur_6,
                (case when umur_7.total_umur_7 IS NOT NULL then umur_7.total_umur_7 else 0 end)AS total_umur_7
                FROM krt__aktiviti_laporan
                LEFT JOIN krt__profile ON krt__profile.id = krt__aktiviti_laporan.krt_profile_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__penganjur ON ref__penganjur.id = krt__aktiviti_laporan.penganjur_id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_lelaki
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.jantina_id IN (1)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) lelaki on lelaki.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_perempuan
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.jantina_id IN (2)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) perempuan on perempuan.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_umur_1
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.umur_id IN (1)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) umur_1 on umur_1.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_umur_2
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.umur_id IN (2)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) umur_2 on umur_2.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_umur_3
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.umur_id IN (3)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) umur_3 on umur_3.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_umur_4
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.umur_id IN (4)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) umur_4 on umur_4.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_umur_5
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.umur_id IN (5)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) umur_5 on umur_5.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_umur_6
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.umur_id IN (6)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) umur_6 on umur_6.laporan_id = krt__aktiviti_laporan.id
                LEFT JOIN (
                                        SELECT
                                        krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id AS laporan_id,
                                        SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS total_umur_7
                                        FROM krt__aktiviti_laporan_penyertaan 
                                        LEFT JOIN krt__aktiviti_laporan ON krt__aktiviti_laporan.id = krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                        WHERE krt__aktiviti_laporan_penyertaan.umur_id IN (7)
                                        GROUP BY krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id
                                ) umur_7 on umur_7.laporan_id = krt__aktiviti_laporan.id
                WHERE krt__aktiviti_laporan.aktiviti_status = 1 "));
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
                $state   = RefStates::where('status', '=',  true)->get();
            return view('rt-sm30.laporan-aktiviti-rt-2-kp',compact('roles_menu', 'state'));
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function laporan_ajk_krt_pengerusi(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            
            $data = DB::table('krt__ahli_jawatan_kuasa')
                        ->select('krt__ahli_jawatan_kuasa.id AS id',
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'ref__parlimens.parlimen_description AS parlimen',
                                'ref__duns.dun_description AS dun',
								'ref__penggal.penggal_mula AS penggal_mula',
								'ref__penggal.penggal_tamat AS penggal_tamat',
                                'krt__profile.krt_nama AS krt_nama',
                                'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
                                'ref__jantina.jantina_description AS ajk_jantina',
                                'ref__kaum.kaum_description AS ajk_kaum',
                                'ref__agama.agama_description AS ajk_agama',
                                'ref__pendidikan.pendidikan_description AS ajk_pendidikan',
                                'ref__profession.profession_description AS ajk_profession',
                                'ref__jawatan_ajk_krt.jawatan_description AS ajk_jawatan',
                                'krt__ahli_jawatan_kuasa.ajk_phone AS ajk_phone')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                        ->leftJoin('ref__jantina','ref__jantina.id','=','krt__ahli_jawatan_kuasa.ajk_jantina')
                        ->leftJoin('ref__agama','ref__agama.id','=','krt__ahli_jawatan_kuasa.ajk_agama')
                        ->leftJoin('ref__kaum','ref__kaum.id','=','krt__ahli_jawatan_kuasa.ajk_kaum')
                        ->leftJoin('ref__pendidikan','ref__pendidikan.id','=','krt__ahli_jawatan_kuasa.ajk_pendidikan_id')
                        ->leftJoin('ref__profession','ref__profession.id','=','krt__ahli_jawatan_kuasa.ajk_profession_id')
                        ->leftJoin('ref__jawatan_ajk_krt','ref__jawatan_ajk_krt.id','=','krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
						->leftJoin('ref__penggal','ref__penggal.id','=','krt__ahli_jawatan_kuasa.ajk_penggal')
                        ->whereIN('krt__ahli_jawatan_kuasa.ajk_status',[1])
                        ->where('krt__profile.id', '=', Auth::user()->krt_id)
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
                $kaum       = RefKaum::where('status', '=',  true)->get();
                $pendidikan = RefPendidikan::where('pendidikan_status', '=',  true)->get();
                $jawatan    = Ref_Jawatan_Ajk_KRT::where('jawatan_status', '=',  true)->get();
				$penggal    = $penggal	= DB::table('ref__penggal')
						  ->select('id','penggal_mula','penggal_tamat')
						  ->orderBy('penggal_mula','asc')
						  ->get();
                return view('rt-sm30.laporan-ajk-krt-pengerusi',compact('roles_menu','kaum','pendidikan','jawatan','penggal'));
        }
    }

    function laporan_ajk_krt_setiausaha(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            
            $data = DB::table('krt__ahli_jawatan_kuasa')
                        ->select('krt__ahli_jawatan_kuasa.id AS id',
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'ref__parlimens.parlimen_description AS parlimen',
                                'ref__duns.dun_description AS dun',
								'ref__penggal.penggal_mula AS penggal_mula',
								'ref__penggal.penggal_tamat AS penggal_tamat',
                                'krt__profile.krt_nama AS krt_nama',
                                'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
                                'ref__jantina.jantina_description AS ajk_jantina',
                                'ref__kaum.kaum_description AS ajk_kaum',
                                'ref__agama.agama_description AS ajk_agama',
                                'ref__pendidikan.pendidikan_description AS ajk_pendidikan',
                                'ref__profession.profession_description AS ajk_profession',
                                'ref__jawatan_ajk_krt.jawatan_description AS ajk_jawatan',
                                'krt__ahli_jawatan_kuasa.ajk_phone AS ajk_phone')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                        ->leftJoin('ref__jantina','ref__jantina.id','=','krt__ahli_jawatan_kuasa.ajk_jantina')
                        ->leftJoin('ref__agama','ref__agama.id','=','krt__ahli_jawatan_kuasa.ajk_agama')
                        ->leftJoin('ref__kaum','ref__kaum.id','=','krt__ahli_jawatan_kuasa.ajk_kaum')
                        ->leftJoin('ref__pendidikan','ref__pendidikan.id','=','krt__ahli_jawatan_kuasa.ajk_pendidikan_id')
                        ->leftJoin('ref__profession','ref__profession.id','=','krt__ahli_jawatan_kuasa.ajk_profession_id')
                        ->leftJoin('ref__jawatan_ajk_krt','ref__jawatan_ajk_krt.id','=','krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
						->leftJoin('ref__penggal','ref__penggal.id','=','krt__ahli_jawatan_kuasa.ajk_penggal')
                        ->whereIN('krt__ahli_jawatan_kuasa.ajk_status',[1])
                        ->where('krt__profile.id', '=', Auth::user()->krt_id)
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
                $kaum       = RefKaum::where('status', '=',  true)->get();
                $pendidikan = RefPendidikan::where('pendidikan_status', '=',  true)->get();
                $jawatan    = Ref_Jawatan_Ajk_KRT::where('jawatan_status', '=',  true)->get();
				$penggal    = $penggal	= DB::table('ref__penggal')
						  ->select('id','penggal_mula','penggal_tamat')
						  ->orderBy('penggal_mula','asc')
						  ->get();
                return view('rt-sm30.laporan-ajk-krt-setiausaha',compact('roles_menu','kaum','pendidikan','jawatan','penggal'));
        }
    }

    function laporan_ajk_krt_ppd(Request $request){
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
            $data = DB::table('krt__ahli_jawatan_kuasa')
                        ->select('krt__ahli_jawatan_kuasa.id AS id',
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'ref__parlimens.parlimen_description AS parlimen',
                                'ref__duns.dun_description AS dun',
								'krt__ahli_jawatan_kuasa.ajk_penggal AS ajk_penggal',
								'ref__penggal.penggal_mula AS penggal_mula',
								'ref__penggal.penggal_tamat AS penggal_tamat',
								'krt__profile.krt_nama AS krt_nama',
                                'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
                                'ref__jantina.jantina_description AS ajk_jantina',
                                'ref__kaum.kaum_description AS ajk_kaum',
                                'ref__agama.agama_description AS ajk_agama',
                                'ref__pendidikan.pendidikan_description AS ajk_pendidikan',
                                'ref__profession.profession_description AS ajk_profession',
                                'ref__jawatan_ajk_krt.jawatan_description AS ajk_jawatan',
                                'krt__ahli_jawatan_kuasa.ajk_phone AS ajk_phone')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                        ->leftJoin('ref__jantina','ref__jantina.id','=','krt__ahli_jawatan_kuasa.ajk_jantina')
                        ->leftJoin('ref__agama','ref__agama.id','=','krt__ahli_jawatan_kuasa.ajk_agama')
                        ->leftJoin('ref__kaum','ref__kaum.id','=','krt__ahli_jawatan_kuasa.ajk_kaum')
                        ->leftJoin('ref__pendidikan','ref__pendidikan.id','=','krt__ahli_jawatan_kuasa.ajk_pendidikan_id')
                        ->leftJoin('ref__profession','ref__profession.id','=','krt__ahli_jawatan_kuasa.ajk_profession_id')
                        ->leftJoin('ref__jawatan_ajk_krt','ref__jawatan_ajk_krt.id','=','krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
						->leftJoin('ref__penggal','ref__penggal.id','=','krt__ahli_jawatan_kuasa.ajk_penggal')
                        ->whereIN('krt__ahli_jawatan_kuasa.ajk_status',[1])
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
						->orderBy('krt_nama', 'asc')  
                        ->get();
            $parlimen   = RefParlimen::where('status', '=',  true)
                        ->where('ref__parlimens.state_id', '=', Auth::user()->state_id)    
                        ->get();
            $kaum       = RefKaum::where('status', '=',  true)->orderBy('kaum_description', 'asc')->get();
            $pendidikan = RefPendidikan::where('pendidikan_status', '=',  true)->get();
            $jawatan    = Ref_Jawatan_Ajk_KRT::where('jawatan_status', '=',  true)->get();
			$penggal    = $penggal	= DB::table('ref__penggal')
						  ->select('id','penggal_mula','penggal_tamat')
						  ->orderBy('penggal_mula','asc')
						  ->get();
            return view('rt-sm30.laporan-ajk-krt-ppd',compact('roles_menu','krt','parlimen','kaum','pendidikan','jawatan','penggal'));
        }
    }

    function laporan_ajk_krt_ppn(Request $request){
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
						->orderBy('krt__profile.krt_nama','asc')
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('krt__ahli_jawatan_kuasa')
                        ->select('krt__ahli_jawatan_kuasa.id AS id',
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'ref__parlimens.parlimen_description AS parlimen',
                                'ref__duns.dun_description AS dun',
								'ref__penggal.penggal_mula AS penggal_mula',
								'ref__penggal.penggal_tamat AS penggal_tamat',
                                'krt__profile.krt_nama AS krt_nama',
                                'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
                                'ref__jantina.jantina_description AS ajk_jantina',
                                'ref__kaum.kaum_description AS ajk_kaum',
                                'ref__agama.agama_description AS ajk_agama',
                                'ref__pendidikan.pendidikan_description AS ajk_pendidikan',
                                'ref__profession.profession_description AS ajk_profession',
                                'ref__jawatan_ajk_krt.jawatan_description AS ajk_jawatan',
                                'krt__ahli_jawatan_kuasa.ajk_phone AS ajk_phone')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                        ->leftJoin('ref__jantina','ref__jantina.id','=','krt__ahli_jawatan_kuasa.ajk_jantina')
                        ->leftJoin('ref__kaum','ref__kaum.id','=','krt__ahli_jawatan_kuasa.ajk_kaum')
                        ->leftJoin('ref__agama','ref__agama.id','=','krt__ahli_jawatan_kuasa.ajk_agama')
                        ->leftJoin('ref__pendidikan','ref__pendidikan.id','=','krt__ahli_jawatan_kuasa.ajk_pendidikan_id')
                        ->leftJoin('ref__profession','ref__profession.id','=','krt__ahli_jawatan_kuasa.ajk_profession_id')
                        ->leftJoin('ref__jawatan_ajk_krt','ref__jawatan_ajk_krt.id','=','krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
						->leftJoin('ref__penggal','ref__penggal.id','=','krt__ahli_jawatan_kuasa.ajk_penggal')
                        ->whereIN('krt__ahli_jawatan_kuasa.ajk_status',[1])
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
            $kaum       = RefKaum::where('status', '=',  true)->get();
            $pendidikan = RefPendidikan::where('pendidikan_status', '=',  true)->get();
            $jawatan    = Ref_Jawatan_Ajk_KRT::where('jawatan_status', '=',  true)->get();
			$penggal    = $penggal	= DB::table('ref__penggal')
						  ->select('id','penggal_mula','penggal_tamat')
						  ->orderBy('penggal_mula','asc')
						  ->get();
            return view('rt-sm30.laporan-ajk-krt-ppn',compact('roles_menu','daerah','parlimen','kaum','pendidikan','jawatan','penggal'));
        }
    }

    function laporan_ajk_krt_hqrt(Request $request){
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
						->orderBy('krt__profile.krt_nama','asc')
                        ->get();
                return Response::json($data);
            }
            /*$data = DB::select(DB::raw("
            SELECT
                krt__ahli_jawatan_kuasa.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
				'ref__penggal.penggal_mula AS penggal_mula',
				'ref__penggal.penggal_tamat AS penggal_tamat',
                krt__profile.krt_nama AS krt_nama,
                krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama,
                krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic,
                krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat,
                ref__jantina.jantina_description AS ajk_jantina,
                ref__kaum.kaum_description AS ajk_kaum,
                ref__agama.agama_description AS ajk_agama,
                ref__pendidikan.pendidikan_description AS ajk_pendidikan,
                ref__profession.profession_description AS ajk_profession,
                ref__jawatan_ajk_krt.jawatan_description AS ajk_jawatan,
                krt__ahli_jawatan_kuasa.ajk_phone AS ajk_phone
            FROM krt__ahli_jawatan_kuasa
            LEFT JOIN krt__profile ON krt__profile.id = krt__ahli_jawatan_kuasa.krt_profile_id
            LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
            LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
            LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
            LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
            LEFT JOIN ref__jantina ON ref__jantina.id = krt__ahli_jawatan_kuasa.ajk_jantina
            LEFT JOIN ref__kaum ON ref__kaum.id = krt__ahli_jawatan_kuasa.ajk_kaum
            LEFT JOIN ref__agama ON ref__agama.id = krt__ahli_jawatan_kuasa.ajk_agama
            LEFT JOIN ref__pendidikan ON ref__pendidikan.id = krt__ahli_jawatan_kuasa.ajk_pendidikan_id
            LEFT JOIN ref__profession ON ref__profession.id = krt__ahli_jawatan_kuasa.ajk_profession_id
            LEFT JOIN ref__jawatan_ajk_krt ON ref__jawatan_ajk_krt.id = krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id
			LEFT JOIN ref__penggal ON ref__penggal.id = krt__ahli_jawatan_kuasa.ajk_penggal
            WHERE krt__ahli_jawatan_kuasa.ajk_status = 1
            ORDER BY krt__profile.state_id ASC LIMIT 0,30000"));*/
			$data = DB::table('krt__ahli_jawatan_kuasa')
                        ->select('krt__ahli_jawatan_kuasa.id AS id',
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'ref__parlimens.parlimen_description AS parlimen',
                                'ref__duns.dun_description AS dun',
								'ref__penggal.penggal_mula AS penggal_mula',
								'ref__penggal.penggal_tamat AS penggal_tamat',
                                'krt__profile.krt_nama AS krt_nama',
                                'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
                                'ref__jantina.jantina_description AS ajk_jantina',
                                'ref__kaum.kaum_description AS ajk_kaum',
                                'ref__agama.agama_description AS ajk_agama',
                                'ref__pendidikan.pendidikan_description AS ajk_pendidikan',
                                'ref__profession.profession_description AS ajk_profession',
                                'ref__jawatan_ajk_krt.jawatan_description AS ajk_jawatan',
                                'krt__ahli_jawatan_kuasa.ajk_phone AS ajk_phone')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                        ->leftJoin('ref__jantina','ref__jantina.id','=','krt__ahli_jawatan_kuasa.ajk_jantina')
                        ->leftJoin('ref__kaum','ref__kaum.id','=','krt__ahli_jawatan_kuasa.ajk_kaum')
                        ->leftJoin('ref__agama','ref__agama.id','=','krt__ahli_jawatan_kuasa.ajk_agama')
                        ->leftJoin('ref__pendidikan','ref__pendidikan.id','=','krt__ahli_jawatan_kuasa.ajk_pendidikan_id')
                        ->leftJoin('ref__profession','ref__profession.id','=','krt__ahli_jawatan_kuasa.ajk_profession_id')
                        ->leftJoin('ref__jawatan_ajk_krt','ref__jawatan_ajk_krt.id','=','krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
						->leftJoin('ref__penggal','ref__penggal.id','=','krt__ahli_jawatan_kuasa.ajk_penggal')
                        ->whereIN('krt__ahli_jawatan_kuasa.ajk_status',[1])
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
            $kaum       = RefKaum::where('status', '=',  true)->get();
            $pendidikan = RefPendidikan::where('pendidikan_status', '=',  true)->get();
            $jawatan    = Ref_Jawatan_Ajk_KRT::where('jawatan_status', '=',  true)->get();
			$penggal    = $penggal	= DB::table('ref__penggal')
						  ->select('id','penggal_mula','penggal_tamat')
						  ->orderBy('penggal_mula','asc')
						  ->get();
            return view('rt-sm30.laporan-ajk-krt-hqrt',compact('roles_menu','state','kaum','pendidikan','jawatan','penggal'));
        }
    }

    function laporan_ajk_krt_kp(Request $request){
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
            $data = DB::table('krt__ahli_jawatan_kuasa')
                        ->select('krt__ahli_jawatan_kuasa.id AS id',
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'ref__parlimens.parlimen_description AS parlimen',
                                'ref__duns.dun_description AS dun',
                                'krt__profile.krt_nama AS krt_nama',
                                'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
                                'ref__jantina.jantina_description AS ajk_jantina',
                                'ref__kaum.kaum_description AS ajk_kaum',
                                'ref__agama.agama_description AS ajk_agama',
                                'ref__pendidikan.pendidikan_description AS ajk_pendidikan',
                                'ref__profession.profession_description AS ajk_profession',
                                'ref__jawatan_ajk_krt.jawatan_description AS ajk_jawatan',
                                'krt__ahli_jawatan_kuasa.ajk_phone AS ajk_phone')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                        ->leftJoin('ref__jantina','ref__jantina.id','=','krt__ahli_jawatan_kuasa.ajk_jantina')
                        ->leftJoin('ref__kaum','ref__kaum.id','=','krt__ahli_jawatan_kuasa.ajk_kaum')
                        ->leftJoin('ref__agama','ref__agama.id','=','krt__ahli_jawatan_kuasa.ajk_agama')
                        ->leftJoin('ref__pendidikan','ref__pendidikan.id','=','krt__ahli_jawatan_kuasa.ajk_pendidikan_id')
                        ->leftJoin('ref__profession','ref__profession.id','=','krt__ahli_jawatan_kuasa.ajk_profession_id')
                        ->leftJoin('ref__jawatan_ajk_krt','ref__jawatan_ajk_krt.id','=','krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
                        ->whereIN('krt__ahli_jawatan_kuasa.ajk_status',[1])
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
            $kaum       = RefKaum::where('status', '=',  true)->get();
            $pendidikan = RefPendidikan::where('pendidikan_status', '=',  true)->get();
            $jawatan    = Ref_Jawatan_Ajk_KRT::where('jawatan_status', '=',  true)->get();
            return view('rt-sm30.laporan-ajk-krt-kp',compact('roles_menu','state','kaum','pendidikan','jawatan'));
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function laporan_ajk_krt_umur_pengerusi(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            
            $data = DB::table('krt__ahli_jawatan_kuasa')
                        ->select('krt__ahli_jawatan_kuasa.id AS id',
                                'ref__kelompok_umur.umur_description AS ajk_kelompok_umur',
                                'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
                                'krt__ahli_jawatan_kuasa.ajk_phone AS ajk_phone')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
                        ->leftJoin('ref__kelompok_umur','ref__kelompok_umur.id','=','krt__ahli_jawatan_kuasa.ajk_kelompok_umur')
                        ->whereIN('krt__ahli_jawatan_kuasa.ajk_status',[1])
                        ->where('krt__profile.id', '=', Auth::user()->krt_id)
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
                $kelompok_umur = Ref_Kelompok_Umur::where('status', '=',  true)->get();
                return view('rt-sm30.laporan-ajk-krt-umur-pengerusi',compact('roles_menu','kelompok_umur'));
        }
    }

    function laporan_ajk_krt_umur_setiausaha(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            
            $data = DB::table('krt__ahli_jawatan_kuasa')
                        ->select('krt__ahli_jawatan_kuasa.id AS id',
                                'ref__kelompok_umur.umur_description AS ajk_kelompok_umur',
                                'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
                                'krt__ahli_jawatan_kuasa.ajk_phone AS ajk_phone')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
                        ->leftJoin('ref__kelompok_umur','ref__kelompok_umur.id','=','krt__ahli_jawatan_kuasa.ajk_kelompok_umur')
                        ->whereIN('krt__ahli_jawatan_kuasa.ajk_status',[1])
                        ->where('krt__profile.id', '=', Auth::user()->krt_id)
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
                $kelompok_umur = Ref_Kelompok_Umur::where('status', '=',  true)->get();
                return view('rt-sm30.laporan-ajk-krt-umur-setiausaha',compact('roles_menu','kelompok_umur'));
        }
    }

    function laporan_ajk_krt_umur_ppd(Request $request){
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
            $data = DB::table('krt__ahli_jawatan_kuasa')
                        ->select('krt__ahli_jawatan_kuasa.id AS id',
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'ref__parlimens.parlimen_description AS parlimen',
                                'ref__duns.dun_description AS dun',
                                'ref__kelompok_umur.umur_description AS ajk_kelompok_umur',
                                'krt__profile.krt_nama AS krt_nama',
                                'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
                                'krt__ahli_jawatan_kuasa.ajk_phone AS ajk_phone')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                        ->leftJoin('ref__kelompok_umur','ref__kelompok_umur.id','=','krt__ahli_jawatan_kuasa.ajk_kelompok_umur')
                        ->whereIN('krt__ahli_jawatan_kuasa.ajk_status',[1])
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
            $kelompok_umur = Ref_Kelompok_Umur::where('status', '=',  true)->get();
            return view('rt-sm30.laporan-ajk-krt-umur-ppd',compact('roles_menu','krt','parlimen','kelompok_umur'));
        }
    }

    function laporan_ajk_krt_umur_ppn(Request $request){
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
            $data = DB::table('krt__ahli_jawatan_kuasa')
                        ->select('krt__ahli_jawatan_kuasa.id AS id',
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'ref__parlimens.parlimen_description AS parlimen',
                                'ref__duns.dun_description AS dun',
                                'krt__profile.krt_nama AS krt_nama',
                                'ref__kelompok_umur.umur_description AS ajk_kelompok_umur',
                                'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
                                'krt__ahli_jawatan_kuasa.ajk_phone AS ajk_phone')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                        ->leftJoin('ref__kelompok_umur','ref__kelompok_umur.id','=','krt__ahli_jawatan_kuasa.ajk_kelompok_umur')
                        ->whereIN('krt__ahli_jawatan_kuasa.ajk_status',[1])
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
            $kelompok_umur = Ref_Kelompok_Umur::where('status', '=',  true)->get();
            return view('rt-sm30.laporan-ajk-krt-umur-ppn',compact('roles_menu','daerah','parlimen','kelompok_umur'));
        }
    }

    function laporan_ajk_krt_umur_hqrt(Request $request){
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
            $data = DB::table('krt__ahli_jawatan_kuasa')
                        ->select('krt__ahli_jawatan_kuasa.id AS id',
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'ref__parlimens.parlimen_description AS parlimen',
                                'ref__duns.dun_description AS dun',
                                'krt__profile.krt_nama AS krt_nama',
                                'ref__kelompok_umur.umur_description AS ajk_kelompok_umur',
                                'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
                                'krt__ahli_jawatan_kuasa.ajk_phone AS ajk_phone')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                        ->leftJoin('ref__kelompok_umur','ref__kelompok_umur.id','=','krt__ahli_jawatan_kuasa.ajk_kelompok_umur')
                        ->whereIN('krt__ahli_jawatan_kuasa.ajk_status',[1])
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
            $kelompok_umur = Ref_Kelompok_Umur::where('status', '=',  true)->get();
            return view('rt-sm30.laporan-ajk-krt-umur-hqrt',compact('roles_menu','state','kelompok_umur'));
        }
    }

    function laporan_ajk_krt_umur_kp(Request $request){
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
            $data = DB::table('krt__ahli_jawatan_kuasa')
                        ->select('krt__ahli_jawatan_kuasa.id AS id',
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'ref__parlimens.parlimen_description AS parlimen',
                                'ref__duns.dun_description AS dun',
                                'krt__profile.krt_nama AS krt_nama',
                                'ref__kelompok_umur.umur_description AS ajk_kelompok_umur',
                                'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
                                'krt__ahli_jawatan_kuasa.ajk_phone AS ajk_phone')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                        ->leftJoin('ref__kelompok_umur','ref__kelompok_umur.id','=','krt__ahli_jawatan_kuasa.ajk_kelompok_umur')
                        ->whereIN('krt__ahli_jawatan_kuasa.ajk_status',[1])
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
            $kelompok_umur = Ref_Kelompok_Umur::where('status', '=',  true)->get();
            return view('rt-sm30.laporan-ajk-krt-umur-kp',compact('roles_menu','state','kelompok_umur'));
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function laporan_bilangan_ajk_umur_pengerusi(Request $request){
        if($request->ajax()){ 
                $type = $request->type;
                $data = DB::select(DB::raw("
                SELECT
                ref__kelompok_umur.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__kelompok_umur.umur_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
		JOIN ref__kelompok_umur
                  LEFT JOIN (
                              SELECT
                              krt__ahli_jawatan_kuasa.ajk_kelompok_umur AS umur_id, 
                              count(*) AS total
                              FROM krt__ahli_jawatan_kuasa 
                              LEFT JOIN ref__kelompok_umur ON ref__kelompok_umur.id = krt__ahli_jawatan_kuasa.ajk_kelompok_umur
                              WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__kelompok_umur.status = 1
                              GROUP BY krt__ahli_jawatan_kuasa.ajk_kelompok_umur, krt__ahli_jawatan_kuasa.krt_profile_id
                  ) a ON a.umur_id = ref__kelompok_umur.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__profile.id = '" . Auth::user()->krt_id . "'
                GROUP BY ref__kelompok_umur.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__kelompok_umur.umur_description, a.total
                ORDER BY krt__profile.krt_nama, ref__kelompok_umur.id"));
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
                        ->orderBy('krt_nama', 'ASC')    
                        ->get();
                return view('rt-sm30.laporan-bilangan-ajk-umur-pengerusi',compact('roles_menu','krt'));
        }
    }

    function laporan_bilangan_ajk_umur_setiausaha(Request $request){
        if($request->ajax()){ 
                $type = $request->type;
                $data = DB::select(DB::raw("
                SELECT
                ref__kelompok_umur.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__kelompok_umur.umur_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
		JOIN ref__kelompok_umur
                  LEFT JOIN (
                              SELECT
                              krt__ahli_jawatan_kuasa.ajk_kelompok_umur AS umur_id, 
                              count(*) AS total
                              FROM krt__ahli_jawatan_kuasa 
                              LEFT JOIN ref__kelompok_umur ON ref__kelompok_umur.id = krt__ahli_jawatan_kuasa.ajk_kelompok_umur
                              WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__kelompok_umur.status = 1
                              GROUP BY krt__ahli_jawatan_kuasa.ajk_kelompok_umur, krt__ahli_jawatan_kuasa.krt_profile_id
                  ) a ON a.umur_id = ref__kelompok_umur.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__profile.id = '" . Auth::user()->krt_id . "'
                GROUP BY ref__kelompok_umur.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__kelompok_umur.umur_description, a.total
                ORDER BY krt__profile.krt_nama, ref__kelompok_umur.id"));
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
                        ->orderBy('krt_nama', 'ASC')    
                        ->get();
                return view('rt-sm30.laporan-bilangan-ajk-umur-setiausaha',compact('roles_menu','krt'));
        }
    }

    function laporan_bilangan_ajk_umur_ppd(Request $request){
        if($request->ajax()){ 
                $type = $request->type;
                $data = DB::select(DB::raw("
                SELECT
                ref__kelompok_umur.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__kelompok_umur.umur_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
		JOIN ref__kelompok_umur
                  LEFT JOIN (
                              SELECT
                              krt__ahli_jawatan_kuasa.ajk_kelompok_umur AS umur_id, 
                              count(*) AS total
                              FROM krt__ahli_jawatan_kuasa 
                              LEFT JOIN ref__kelompok_umur ON ref__kelompok_umur.id = krt__ahli_jawatan_kuasa.ajk_kelompok_umur
                              WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__kelompok_umur.status = 1
                              GROUP BY krt__ahli_jawatan_kuasa.ajk_kelompok_umur, krt__ahli_jawatan_kuasa.krt_profile_id
                  ) a ON a.umur_id = ref__kelompok_umur.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__profile.daerah_id = '" . Auth::user()->daerah_id . "'
                GROUP BY ref__kelompok_umur.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__kelompok_umur.umur_description, a.total
                ORDER BY krt__profile.krt_nama, ref__kelompok_umur.id"));
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
                        ->orderBy('krt_nama', 'ASC')    
                        ->get();
                return view('rt-sm30.laporan-bilangan-ajk-umur-ppd',compact('roles_menu','krt'));
        }
    }

    function laporan_bilangan_ajk_umur_ppn(Request $request){
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
                                ->orderBy('krt_nama', 'ASC')
                                ->get();
                        return Response::json($data);
                    }
                $data = DB::select(DB::raw("
                SELECT
                ref__kelompok_umur.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__kelompok_umur.umur_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
		JOIN ref__kelompok_umur
                  LEFT JOIN (
                              SELECT
                              krt__ahli_jawatan_kuasa.ajk_kelompok_umur AS umur_id, 
                              count(*) AS total
                              FROM krt__ahli_jawatan_kuasa 
                              LEFT JOIN ref__kelompok_umur ON ref__kelompok_umur.id = krt__ahli_jawatan_kuasa.ajk_kelompok_umur
                              WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__kelompok_umur.status = 1
                              GROUP BY krt__ahli_jawatan_kuasa.ajk_kelompok_umur, krt__ahli_jawatan_kuasa.krt_profile_id
                  ) a ON a.umur_id = ref__kelompok_umur.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__profile.state_id = '" . Auth::user()->state_id . "'
                GROUP BY ref__kelompok_umur.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__kelompok_umur.umur_description, a.total
                ORDER BY krt__profile.krt_nama, ref__kelompok_umur.id"));
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
                                ->get();
                return view('rt-sm30.laporan-bilangan-ajk-umur-ppn',compact('roles_menu','daerah'));
        }
    }

    function laporan_bilangan_ajk_umur_hqrt(Request $request){
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
                                ->orderBy('krt_nama', 'ASC')
                                ->get();
                        return Response::json($data);
                }
                $data = DB::select(DB::raw("
                SELECT
                ref__kelompok_umur.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__kelompok_umur.umur_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
		JOIN ref__kelompok_umur
                  LEFT JOIN (
                              SELECT
                              krt__ahli_jawatan_kuasa.ajk_kelompok_umur AS umur_id, 
                              count(*) AS total
                              FROM krt__ahli_jawatan_kuasa 
                              LEFT JOIN ref__kelompok_umur ON ref__kelompok_umur.id = krt__ahli_jawatan_kuasa.ajk_kelompok_umur
                              WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__kelompok_umur.status = 1
                              GROUP BY krt__ahli_jawatan_kuasa.ajk_kelompok_umur, krt__ahli_jawatan_kuasa.krt_profile_id
                  ) a ON a.umur_id = ref__kelompok_umur.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 
                GROUP BY ref__kelompok_umur.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__kelompok_umur.umur_description, a.total
                ORDER BY krt__profile.krt_nama, ref__kelompok_umur.id"));
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
                return view('rt-sm30.laporan-bilangan-ajk-umur-hqrt',compact('roles_menu','state'));
        }
    }

    function laporan_bilangan_ajk_umur_kp(Request $request){
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
                                ->orderBy('krt_nama', 'ASC')
                                ->get();
                        return Response::json($data);
                }
                $data = DB::select(DB::raw("
                SELECT
                ref__kelompok_umur.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__kelompok_umur.umur_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
		JOIN ref__kelompok_umur
                  LEFT JOIN (
                              SELECT
                              krt__ahli_jawatan_kuasa.ajk_kelompok_umur AS umur_id, 
                              count(*) AS total
                              FROM krt__ahli_jawatan_kuasa 
                              LEFT JOIN ref__kelompok_umur ON ref__kelompok_umur.id = krt__ahli_jawatan_kuasa.ajk_kelompok_umur
                              WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__kelompok_umur.status = 1
                              GROUP BY krt__ahli_jawatan_kuasa.ajk_kelompok_umur, krt__ahli_jawatan_kuasa.krt_profile_id
                  ) a ON a.umur_id = ref__kelompok_umur.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 
                GROUP BY ref__kelompok_umur.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__kelompok_umur.umur_description, a.total
                ORDER BY krt__profile.krt_nama, ref__kelompok_umur.id"));
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
                return view('rt-sm30.laporan-bilangan-ajk-umur-kp',compact('roles_menu','state'));
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function laporan_bilangan_ajk_jawatan_pengerusi(Request $request){
        if($request->ajax()){ 
                $type = $request->type;
                $data = DB::select(DB::raw("
                SELECT
                ref__jawatan_ajk_krt.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__jawatan_ajk_krt.jawatan_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
		JOIN ref__jawatan_ajk_krt
                LEFT JOIN (
                   SELECT
                        krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS jawatan_id, 
                        count(*) AS total
                   FROM krt__ahli_jawatan_kuasa 
                   LEFT JOIN ref__jawatan_ajk_krt ON ref__jawatan_ajk_krt.id = krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id
                   WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__jawatan_ajk_krt.jawatan_status = 1
                   GROUP BY krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id, krt__ahli_jawatan_kuasa.krt_profile_id
                ) a ON a.jawatan_id = ref__jawatan_ajk_krt.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__profile.id = '" . Auth::user()->krt_id . "'
                GROUP BY ref__jawatan_ajk_krt.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__jawatan_ajk_krt.jawatan_description, a.total
                ORDER BY krt__profile.krt_nama, ref__jawatan_ajk_krt.id"));
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
                return view('rt-sm30.laporan-bilangan-ajk-jawatan-pengerusi',compact('roles_menu'));
        }
    }

    function laporan_bilangan_ajk_jawatan_setiausaha(Request $request){
        if($request->ajax()){ 
                $type = $request->type;
                $data = DB::select(DB::raw("
                SELECT
                ref__jawatan_ajk_krt.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__jawatan_ajk_krt.jawatan_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
		JOIN ref__jawatan_ajk_krt
                LEFT JOIN (
                   SELECT
                        krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS jawatan_id, 
                        count(*) AS total
                   FROM krt__ahli_jawatan_kuasa 
                   LEFT JOIN ref__jawatan_ajk_krt ON ref__jawatan_ajk_krt.id = krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id
                   WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__jawatan_ajk_krt.jawatan_status = 1
                   GROUP BY krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id, krt__ahli_jawatan_kuasa.krt_profile_id
                ) a ON a.jawatan_id = ref__jawatan_ajk_krt.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__profile.id = '" . Auth::user()->krt_id . "'
                GROUP BY ref__jawatan_ajk_krt.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__jawatan_ajk_krt.jawatan_description, a.total
                ORDER BY krt__profile.krt_nama, ref__jawatan_ajk_krt.id"));
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
                return view('rt-sm30.laporan-bilangan-ajk-jawatan-setiausaha',compact('roles_menu'));
        }
    }
    
    function laporan_bilangan_ajk_jawatan_ppd(Request $request){
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
            $parlimen   = RefParlimen::where('status', '=',  true)
                        ->where('ref__parlimens.state_id', '=', Auth::user()->state_id)    
                        ->get();
            return view('rt-sm30.laporan-bilangan-ajk-jawatan-ppd',compact('roles_menu','parlimen'));
        }
        
    }

    function get_total_ajk_jawatan_pengerusi_ppd(Request $request){
        $data = DB::select(DB::raw("
                SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
                krt__profile.krt_nama AS krt_nama,
                a.jawatan AS jawatan,
                a.total_jawatan AS total_jawatan
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
                LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
                LEFT JOIN (
                        SELECT 
                        krt__ahli_jawatan_kuasa.krt_profile_id, 
                        krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS jawatan_id, 
                        ref__jawatan_ajk_krt.jawatan_description AS jawatan, 
                        count(*) AS total_jawatan
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__jawatan_ajk_krt ON ref__jawatan_ajk_krt.id = krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id = 1
                        GROUP BY krt__ahli_jawatan_kuasa.krt_profile_id , krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id , ref__jawatan_ajk_krt.jawatan_description
                ) a ON a.krt_profile_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND a.jawatan_id = 1 AND krt__profile.daerah_id = '" . Auth::user()->daerah_id . "'
                            "));
            return Datatables::of($data)
            ->make(true);
    }

    function get_total_ajk_jawatan_tpengerusi_ppd(Request $request){
        $data = DB::select(DB::raw("
                SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
                krt__profile.krt_nama AS krt_nama,
                a.jawatan AS jawatan,
                a.total_jawatan AS total_jawatan
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
                LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
                LEFT JOIN (
                        SELECT 
                        krt__ahli_jawatan_kuasa.krt_profile_id, 
                        krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS jawatan_id, 
                        ref__jawatan_ajk_krt.jawatan_description AS jawatan, 
                        count(*) AS total_jawatan
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__jawatan_ajk_krt ON ref__jawatan_ajk_krt.id = krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id = 2
                        GROUP BY krt__ahli_jawatan_kuasa.krt_profile_id , krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id , ref__jawatan_ajk_krt.jawatan_description
                ) a ON a.krt_profile_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND a.jawatan_id = 2 AND krt__profile.daerah_id = '" . Auth::user()->daerah_id . "'
                            "));
            return Datatables::of($data)
            ->make(true);
    }

    function get_total_ajk_jawatan_setiausaha_ppd(Request $request){
        $data = DB::select(DB::raw("
                SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
                krt__profile.krt_nama AS krt_nama,
                a.jawatan AS jawatan,
                a.total_jawatan AS total_jawatan
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
                LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
                LEFT JOIN (
                        SELECT 
                        krt__ahli_jawatan_kuasa.krt_profile_id, 
                        krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS jawatan_id, 
                        ref__jawatan_ajk_krt.jawatan_description AS jawatan, 
                        count(*) AS total_jawatan
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__jawatan_ajk_krt ON ref__jawatan_ajk_krt.id = krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id = 3
                        GROUP BY krt__ahli_jawatan_kuasa.krt_profile_id , krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id , ref__jawatan_ajk_krt.jawatan_description
                ) a ON a.krt_profile_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND a.jawatan_id = 3 AND krt__profile.daerah_id = '" . Auth::user()->daerah_id . "'
                            "));
            return Datatables::of($data)
            ->make(true);
    }

    function get_total_ajk_jawatan_bendahari_ppd(Request $request){
        $data = DB::select(DB::raw("
                SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
                krt__profile.krt_nama AS krt_nama,
                a.jawatan AS jawatan,
                a.total_jawatan AS total_jawatan
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
                LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
                LEFT JOIN (
                        SELECT 
                        krt__ahli_jawatan_kuasa.krt_profile_id, 
                        krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS jawatan_id, 
                        ref__jawatan_ajk_krt.jawatan_description AS jawatan, 
                        count(*) AS total_jawatan
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__jawatan_ajk_krt ON ref__jawatan_ajk_krt.id = krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id = 4
                        GROUP BY krt__ahli_jawatan_kuasa.krt_profile_id , krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id , ref__jawatan_ajk_krt.jawatan_description
                ) a ON a.krt_profile_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND a.jawatan_id = 4 AND krt__profile.daerah_id = '" . Auth::user()->daerah_id . "'
                            "));
            return Datatables::of($data)
            ->make(true);
    }

    function get_total_ajk_jawatan_psetiausaha_ppd(Request $request){
        $data = DB::select(DB::raw("
                SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
                krt__profile.krt_nama AS krt_nama,
                a.jawatan AS jawatan,
                a.total_jawatan AS total_jawatan
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
                LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
                LEFT JOIN (
                        SELECT 
                        krt__ahli_jawatan_kuasa.krt_profile_id, 
                        krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS jawatan_id, 
                        ref__jawatan_ajk_krt.jawatan_description AS jawatan, 
                        count(*) AS total_jawatan
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__jawatan_ajk_krt ON ref__jawatan_ajk_krt.id = krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id = 5
                        GROUP BY krt__ahli_jawatan_kuasa.krt_profile_id , krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id , ref__jawatan_ajk_krt.jawatan_description
                ) a ON a.krt_profile_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND a.jawatan_id = 5 AND krt__profile.daerah_id = '" . Auth::user()->daerah_id . "'
                            "));
            return Datatables::of($data)
            ->make(true);
    }

    function get_total_ajk_jawatan_ajk_ppd(Request $request){
        $data = DB::select(DB::raw("
                SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
                krt__profile.krt_nama AS krt_nama,
                a.jawatan AS jawatan,
                a.total_jawatan AS total_jawatan
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
                LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
                LEFT JOIN (
                        SELECT 
                        krt__ahli_jawatan_kuasa.krt_profile_id, 
                        krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS jawatan_id, 
                        ref__jawatan_ajk_krt.jawatan_description AS jawatan, 
                        count(*) AS total_jawatan
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__jawatan_ajk_krt ON ref__jawatan_ajk_krt.id = krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id = 6
                        GROUP BY krt__ahli_jawatan_kuasa.krt_profile_id , krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id , ref__jawatan_ajk_krt.jawatan_description
                ) a ON a.krt_profile_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND a.jawatan_id = 6 AND krt__profile.daerah_id = '" . Auth::user()->daerah_id . "'
                            "));
            return Datatables::of($data)
            ->make(true);
    }

    function laporan_bilangan_ajk_jawatan_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_parlimen') {
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
            return view('rt-sm30.laporan-bilangan-ajk-jawatan-ppn',compact('roles_menu','daerah', 'parlimen'));
        }
        
    }

    function get_total_ajk_jawatan_pengerusi_ppn(Request $request){
        $data = DB::select(DB::raw("
                SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
                krt__profile.krt_nama AS krt_nama,
                a.jawatan AS jawatan,
                a.total_jawatan AS total_jawatan
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
                LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
                LEFT JOIN (
                        SELECT 
                        krt__ahli_jawatan_kuasa.krt_profile_id, 
                        krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS jawatan_id, 
                        ref__jawatan_ajk_krt.jawatan_description AS jawatan, 
                        count(*) AS total_jawatan
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__jawatan_ajk_krt ON ref__jawatan_ajk_krt.id = krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id = 1
                        GROUP BY krt__ahli_jawatan_kuasa.krt_profile_id , krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id , ref__jawatan_ajk_krt.jawatan_description
                ) a ON a.krt_profile_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND a.jawatan_id = 1 AND krt__profile.state_id = '" . Auth::user()->state_id . "'
                            "));
            return Datatables::of($data)
            ->make(true);
    }

    function get_total_ajk_jawatan_tpengerusi_ppn(Request $request){
        $data = DB::select(DB::raw("
                SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
                krt__profile.krt_nama AS krt_nama,
                a.jawatan AS jawatan,
                a.total_jawatan AS total_jawatan
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
                LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
                LEFT JOIN (
                        SELECT 
                        krt__ahli_jawatan_kuasa.krt_profile_id, 
                        krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS jawatan_id, 
                        ref__jawatan_ajk_krt.jawatan_description AS jawatan, 
                        count(*) AS total_jawatan
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__jawatan_ajk_krt ON ref__jawatan_ajk_krt.id = krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id = 2
                        GROUP BY krt__ahli_jawatan_kuasa.krt_profile_id , krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id , ref__jawatan_ajk_krt.jawatan_description
                ) a ON a.krt_profile_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND a.jawatan_id = 2 AND krt__profile.state_id = '" . Auth::user()->state_id . "'
                            "));
            return Datatables::of($data)
            ->make(true);
    }

    function get_total_ajk_jawatan_setiausaha_ppn(Request $request){
        $data = DB::select(DB::raw("
                SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
                krt__profile.krt_nama AS krt_nama,
                a.jawatan AS jawatan,
                a.total_jawatan AS total_jawatan
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
                LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
                LEFT JOIN (
                        SELECT 
                        krt__ahli_jawatan_kuasa.krt_profile_id, 
                        krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS jawatan_id, 
                        ref__jawatan_ajk_krt.jawatan_description AS jawatan, 
                        count(*) AS total_jawatan
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__jawatan_ajk_krt ON ref__jawatan_ajk_krt.id = krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id = 3
                        GROUP BY krt__ahli_jawatan_kuasa.krt_profile_id , krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id , ref__jawatan_ajk_krt.jawatan_description
                ) a ON a.krt_profile_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND a.jawatan_id = 3 AND krt__profile.state_id = '" . Auth::user()->state_id . "'
                            "));
            return Datatables::of($data)
            ->make(true);
    }

    function get_total_ajk_jawatan_bendahari_ppn(Request $request){
        $data = DB::select(DB::raw("
                SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
                krt__profile.krt_nama AS krt_nama,
                a.jawatan AS jawatan,
                a.total_jawatan AS total_jawatan
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
                LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
                LEFT JOIN (
                        SELECT 
                        krt__ahli_jawatan_kuasa.krt_profile_id, 
                        krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS jawatan_id, 
                        ref__jawatan_ajk_krt.jawatan_description AS jawatan, 
                        count(*) AS total_jawatan
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__jawatan_ajk_krt ON ref__jawatan_ajk_krt.id = krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id = 4
                        GROUP BY krt__ahli_jawatan_kuasa.krt_profile_id , krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id , ref__jawatan_ajk_krt.jawatan_description
                ) a ON a.krt_profile_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND a.jawatan_id = 4 AND krt__profile.state_id = '" . Auth::user()->state_id . "'
                            "));
            return Datatables::of($data)
            ->make(true);
    }

    function get_total_ajk_jawatan_psetiausaha_ppn(Request $request){
        $data = DB::select(DB::raw("
                SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
                krt__profile.krt_nama AS krt_nama,
                a.jawatan AS jawatan,
                a.total_jawatan AS total_jawatan
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
                LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
                LEFT JOIN (
                        SELECT 
                        krt__ahli_jawatan_kuasa.krt_profile_id, 
                        krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS jawatan_id, 
                        ref__jawatan_ajk_krt.jawatan_description AS jawatan, 
                        count(*) AS total_jawatan
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__jawatan_ajk_krt ON ref__jawatan_ajk_krt.id = krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id = 5
                        GROUP BY krt__ahli_jawatan_kuasa.krt_profile_id , krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id , ref__jawatan_ajk_krt.jawatan_description
                ) a ON a.krt_profile_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND a.jawatan_id = 5 AND krt__profile.state_id = '" . Auth::user()->state_id . "'
                            "));
            return Datatables::of($data)
            ->make(true);
    }

    function get_total_ajk_jawatan_ajk_ppn(Request $request){
        $data = DB::select(DB::raw("
                SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
                krt__profile.krt_nama AS krt_nama,
                a.jawatan AS jawatan,
                a.total_jawatan AS total_jawatan
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
                LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
                LEFT JOIN (
                        SELECT 
                        krt__ahli_jawatan_kuasa.krt_profile_id, 
                        krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS jawatan_id, 
                        ref__jawatan_ajk_krt.jawatan_description AS jawatan, 
                        count(*) AS total_jawatan
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__jawatan_ajk_krt ON ref__jawatan_ajk_krt.id = krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id = 6
                        GROUP BY krt__ahli_jawatan_kuasa.krt_profile_id , krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id , ref__jawatan_ajk_krt.jawatan_description
                ) a ON a.krt_profile_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND a.jawatan_id = 6 AND krt__profile.state_id = '" . Auth::user()->state_id . "'
                            "));
            return Datatables::of($data)
            ->make(true);
    }
    
    function laporan_bilangan_ajk_jawatan_hqrt(Request $request){
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
            return view('rt-sm30.laporan-bilangan-ajk-jawatan-hqrt',compact('roles_menu','state'));
        }
    }

    function get_total_ajk_jawatan_pengerusi_hqrt(Request $request){
        $data = DB::select(DB::raw("
                SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
                krt__profile.krt_nama AS krt_nama,
                a.jawatan AS jawatan,
                a.total_jawatan AS total_jawatan
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
                LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
                LEFT JOIN (
                        SELECT 
                        krt__ahli_jawatan_kuasa.krt_profile_id, 
                        krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS jawatan_id, 
                        ref__jawatan_ajk_krt.jawatan_description AS jawatan, 
                        count(*) AS total_jawatan
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__jawatan_ajk_krt ON ref__jawatan_ajk_krt.id = krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id = 1
                        GROUP BY krt__ahli_jawatan_kuasa.krt_profile_id , krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id , ref__jawatan_ajk_krt.jawatan_description
                ) a ON a.krt_profile_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND a.jawatan_id = 1
                            "));
            return Datatables::of($data)
            ->make(true);
    }

    function get_total_ajk_jawatan_tpengerusi_hqrt(Request $request){
        $data = DB::select(DB::raw("
                SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
                krt__profile.krt_nama AS krt_nama,
                a.jawatan AS jawatan,
                a.total_jawatan AS total_jawatan
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
                LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
                LEFT JOIN (
                        SELECT 
                        krt__ahli_jawatan_kuasa.krt_profile_id, 
                        krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS jawatan_id, 
                        ref__jawatan_ajk_krt.jawatan_description AS jawatan, 
                        count(*) AS total_jawatan
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__jawatan_ajk_krt ON ref__jawatan_ajk_krt.id = krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id = 2
                        GROUP BY krt__ahli_jawatan_kuasa.krt_profile_id , krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id , ref__jawatan_ajk_krt.jawatan_description
                ) a ON a.krt_profile_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND a.jawatan_id = 2
                            "));
            return Datatables::of($data)
            ->make(true);
    }

    function get_total_ajk_jawatan_setiausaha_hqrt(Request $request){
        $data = DB::select(DB::raw("
                SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
                krt__profile.krt_nama AS krt_nama,
                a.jawatan AS jawatan,
                a.total_jawatan AS total_jawatan
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
                LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
                LEFT JOIN (
                        SELECT 
                        krt__ahli_jawatan_kuasa.krt_profile_id, 
                        krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS jawatan_id, 
                        ref__jawatan_ajk_krt.jawatan_description AS jawatan, 
                        count(*) AS total_jawatan
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__jawatan_ajk_krt ON ref__jawatan_ajk_krt.id = krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id = 3
                        GROUP BY krt__ahli_jawatan_kuasa.krt_profile_id , krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id , ref__jawatan_ajk_krt.jawatan_description
                ) a ON a.krt_profile_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND a.jawatan_id = 3
                            "));
            return Datatables::of($data)
            ->make(true);
    }

    function get_total_ajk_jawatan_bendahari_hqrt(Request $request){
        $data = DB::select(DB::raw("
                SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
                krt__profile.krt_nama AS krt_nama,
                a.jawatan AS jawatan,
                a.total_jawatan AS total_jawatan
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
                LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
                LEFT JOIN (
                        SELECT 
                        krt__ahli_jawatan_kuasa.krt_profile_id, 
                        krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS jawatan_id, 
                        ref__jawatan_ajk_krt.jawatan_description AS jawatan, 
                        count(*) AS total_jawatan
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__jawatan_ajk_krt ON ref__jawatan_ajk_krt.id = krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id = 4
                        GROUP BY krt__ahli_jawatan_kuasa.krt_profile_id , krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id , ref__jawatan_ajk_krt.jawatan_description
                ) a ON a.krt_profile_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND a.jawatan_id = 4
                            "));
            return Datatables::of($data)
            ->make(true);
    }

    function get_total_ajk_jawatan_psetiausaha_hqrt(Request $request){
        $data = DB::select(DB::raw("
                SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
                krt__profile.krt_nama AS krt_nama,
                a.jawatan AS jawatan,
                a.total_jawatan AS total_jawatan
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
                LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
                LEFT JOIN (
                        SELECT 
                        krt__ahli_jawatan_kuasa.krt_profile_id, 
                        krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS jawatan_id, 
                        ref__jawatan_ajk_krt.jawatan_description AS jawatan, 
                        count(*) AS total_jawatan
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__jawatan_ajk_krt ON ref__jawatan_ajk_krt.id = krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id = 5
                        GROUP BY krt__ahli_jawatan_kuasa.krt_profile_id , krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id , ref__jawatan_ajk_krt.jawatan_description
                ) a ON a.krt_profile_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND a.jawatan_id = 5
                            "));
            return Datatables::of($data)
            ->make(true);
    }

    function get_total_ajk_jawatan_ajk_hqrt(Request $request){
        $data = DB::select(DB::raw("
                SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
                krt__profile.krt_nama AS krt_nama,
                a.jawatan AS jawatan,
                a.total_jawatan AS total_jawatan
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
                LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
                LEFT JOIN (
                        SELECT 
                        krt__ahli_jawatan_kuasa.krt_profile_id, 
                        krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS jawatan_id, 
                        ref__jawatan_ajk_krt.jawatan_description AS jawatan, 
                        count(*) AS total_jawatan
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__jawatan_ajk_krt ON ref__jawatan_ajk_krt.id = krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id = 6
                        GROUP BY krt__ahli_jawatan_kuasa.krt_profile_id , krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id , ref__jawatan_ajk_krt.jawatan_description
                ) a ON a.krt_profile_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND a.jawatan_id = 6
                            "));
            return Datatables::of($data)
            ->make(true);
    }

    function laporan_bilangan_ajk_jawatan_kp(Request $request){
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
            return view('rt-sm30.laporan-bilangan-ajk-jawatan-kp',compact('roles_menu','state'));
        }
    }

    function get_total_ajk_jawatan_pengerusi_kp(Request $request){
        $data = DB::select(DB::raw("
                SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
                krt__profile.krt_nama AS krt_nama,
                a.jawatan AS jawatan,
                a.total_jawatan AS total_jawatan
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
                LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
                LEFT JOIN (
                        SELECT 
                        krt__ahli_jawatan_kuasa.krt_profile_id, 
                        krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS jawatan_id, 
                        ref__jawatan_ajk_krt.jawatan_description AS jawatan, 
                        count(*) AS total_jawatan
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__jawatan_ajk_krt ON ref__jawatan_ajk_krt.id = krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id = 1
                        GROUP BY krt__ahli_jawatan_kuasa.krt_profile_id , krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id , ref__jawatan_ajk_krt.jawatan_description
                ) a ON a.krt_profile_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND a.jawatan_id = 1
                            "));
            return Datatables::of($data)
            ->make(true);
    }

    function get_total_ajk_jawatan_tpengerusi_kp(Request $request){
        $data = DB::select(DB::raw("
                SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
                krt__profile.krt_nama AS krt_nama,
                a.jawatan AS jawatan,
                a.total_jawatan AS total_jawatan
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
                LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
                LEFT JOIN (
                        SELECT 
                        krt__ahli_jawatan_kuasa.krt_profile_id, 
                        krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS jawatan_id, 
                        ref__jawatan_ajk_krt.jawatan_description AS jawatan, 
                        count(*) AS total_jawatan
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__jawatan_ajk_krt ON ref__jawatan_ajk_krt.id = krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id = 2
                        GROUP BY krt__ahli_jawatan_kuasa.krt_profile_id , krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id , ref__jawatan_ajk_krt.jawatan_description
                ) a ON a.krt_profile_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND a.jawatan_id = 2
                            "));
            return Datatables::of($data)
            ->make(true);
    }

    function get_total_ajk_jawatan_setiausaha_kp(Request $request){
        $data = DB::select(DB::raw("
                SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
                krt__profile.krt_nama AS krt_nama,
                a.jawatan AS jawatan,
                a.total_jawatan AS total_jawatan
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
                LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
                LEFT JOIN (
                        SELECT 
                        krt__ahli_jawatan_kuasa.krt_profile_id, 
                        krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS jawatan_id, 
                        ref__jawatan_ajk_krt.jawatan_description AS jawatan, 
                        count(*) AS total_jawatan
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__jawatan_ajk_krt ON ref__jawatan_ajk_krt.id = krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id = 3
                        GROUP BY krt__ahli_jawatan_kuasa.krt_profile_id , krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id , ref__jawatan_ajk_krt.jawatan_description
                ) a ON a.krt_profile_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND a.jawatan_id = 3
                            "));
            return Datatables::of($data)
            ->make(true);
    }

    function get_total_ajk_jawatan_bendahari_kp(Request $request){
        $data = DB::select(DB::raw("
                SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
                krt__profile.krt_nama AS krt_nama,
                a.jawatan AS jawatan,
                a.total_jawatan AS total_jawatan
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
                LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
                LEFT JOIN (
                        SELECT 
                        krt__ahli_jawatan_kuasa.krt_profile_id, 
                        krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS jawatan_id, 
                        ref__jawatan_ajk_krt.jawatan_description AS jawatan, 
                        count(*) AS total_jawatan
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__jawatan_ajk_krt ON ref__jawatan_ajk_krt.id = krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id = 4
                        GROUP BY krt__ahli_jawatan_kuasa.krt_profile_id , krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id , ref__jawatan_ajk_krt.jawatan_description
                ) a ON a.krt_profile_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND a.jawatan_id = 4
                            "));
            return Datatables::of($data)
            ->make(true);
    }

    function get_total_ajk_jawatan_psetiausaha_kp(Request $request){
        $data = DB::select(DB::raw("
                SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
                krt__profile.krt_nama AS krt_nama,
                a.jawatan AS jawatan,
                a.total_jawatan AS total_jawatan
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
                LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
                LEFT JOIN (
                        SELECT 
                        krt__ahli_jawatan_kuasa.krt_profile_id, 
                        krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS jawatan_id, 
                        ref__jawatan_ajk_krt.jawatan_description AS jawatan, 
                        count(*) AS total_jawatan
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__jawatan_ajk_krt ON ref__jawatan_ajk_krt.id = krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id = 5
                        GROUP BY krt__ahli_jawatan_kuasa.krt_profile_id , krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id , ref__jawatan_ajk_krt.jawatan_description
                ) a ON a.krt_profile_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND a.jawatan_id = 5
                            "));
            return Datatables::of($data)
            ->make(true);
    }

    function get_total_ajk_jawatan_ajk_kp(Request $request){
        $data = DB::select(DB::raw("
                SELECT
                krt__profile.id AS id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                ref__parlimens.parlimen_description AS parlimen,
                ref__duns.dun_description AS dun,
                krt__profile.krt_nama AS krt_nama,
                a.jawatan AS jawatan,
                a.total_jawatan AS total_jawatan
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__parlimens ON ref__parlimens.parlimen_id = krt__profile.parlimen_id
                LEFT JOIN ref__duns ON ref__duns.dun_id = krt__profile.dun_id
                LEFT JOIN (
                        SELECT 
                        krt__ahli_jawatan_kuasa.krt_profile_id, 
                        krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS jawatan_id, 
                        ref__jawatan_ajk_krt.jawatan_description AS jawatan, 
                        count(*) AS total_jawatan
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__jawatan_ajk_krt ON ref__jawatan_ajk_krt.id = krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id = 6
                        GROUP BY krt__ahli_jawatan_kuasa.krt_profile_id , krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id , ref__jawatan_ajk_krt.jawatan_description
                ) a ON a.krt_profile_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND a.jawatan_id = 6
                            "));
            return Datatables::of($data)
            ->make(true);
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function laporan_ajk_pendidikan_pengerusi(Request $request){
        if($request->ajax()){ 
                $type = $request->type;
                $data = DB::select(DB::raw("
                SELECT
                ref__pendidikan.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__pendidikan.pendidikan_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                JOIN ref__pendidikan
                LEFT JOIN (
                   SELECT
                        krt__ahli_jawatan_kuasa.ajk_pendidikan_id AS pendidikan_id, 
                        count(*) AS total
                   FROM krt__ahli_jawatan_kuasa 
                   LEFT JOIN ref__pendidikan ON ref__pendidikan.id = krt__ahli_jawatan_kuasa.ajk_pendidikan_id
                   WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__pendidikan.pendidikan_status = 1
                   GROUP BY krt__ahli_jawatan_kuasa.ajk_pendidikan_id, krt__ahli_jawatan_kuasa.krt_profile_id
                ) a ON a.pendidikan_id = ref__pendidikan.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__profile.id = '" . Auth::user()->krt_id . "'
                GROUP BY ref__pendidikan.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__pendidikan.pendidikan_description, a.total
                ORDER BY krt__profile.krt_nama, ref__pendidikan.id"));
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
                        ->orderBy('krt_nama', 'ASC')    
                        ->get();
                return view('rt-sm30.laporan-ajk-pendidikan-pengerusi',compact('roles_menu','krt'));
        }
    }

    function laporan_ajk_pendidikan_setiausaha(Request $request){
        if($request->ajax()){ 
                $type = $request->type;
                $data = DB::select(DB::raw("
                SELECT
                ref__pendidikan.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__pendidikan.pendidikan_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                JOIN ref__pendidikan
                LEFT JOIN (
                   SELECT
                        krt__ahli_jawatan_kuasa.ajk_pendidikan_id AS pendidikan_id, 
                        count(*) AS total
                   FROM krt__ahli_jawatan_kuasa 
                   LEFT JOIN ref__pendidikan ON ref__pendidikan.id = krt__ahli_jawatan_kuasa.ajk_pendidikan_id
                   WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__pendidikan.pendidikan_status = 1
                   GROUP BY krt__ahli_jawatan_kuasa.ajk_pendidikan_id, krt__ahli_jawatan_kuasa.krt_profile_id
                ) a ON a.pendidikan_id = ref__pendidikan.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__profile.id = '" . Auth::user()->krt_id . "'
                GROUP BY ref__pendidikan.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__pendidikan.pendidikan_description, a.total
                ORDER BY krt__profile.krt_nama, ref__pendidikan.id"));
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
                        ->orderBy('krt_nama', 'ASC')    
                        ->get();
                return view('rt-sm30.laporan-ajk-pendidikan-setiausaha',compact('roles_menu','krt'));
        }
    }

    function laporan_ajk_pendidikan_ppd(Request $request){
        if($request->ajax()){ 
                $type = $request->type;
                $data = DB::select(DB::raw("
                SELECT
                ref__pendidikan.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__pendidikan.pendidikan_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                JOIN ref__pendidikan
                LEFT JOIN (
                        SELECT
                                        krt__ahli_jawatan_kuasa.ajk_pendidikan_id AS pendidikan_id, 
                                        count(*) AS total
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__pendidikan ON ref__pendidikan.id = krt__ahli_jawatan_kuasa.ajk_pendidikan_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__pendidikan.pendidikan_status = 1
                        GROUP BY krt__ahli_jawatan_kuasa.ajk_pendidikan_id, krt__ahli_jawatan_kuasa.krt_profile_id
                ) a ON a.pendidikan_id = ref__pendidikan.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__profile.daerah_id = '" . Auth::user()->daerah_id . "'
                GROUP BY ref__pendidikan.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__pendidikan.pendidikan_description, a.total
                ORDER BY krt__profile.krt_nama, ref__pendidikan.id
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
                        ->orderBy('krt_nama', 'ASC')    
                        ->get();
                return view('rt-sm30.laporan-ajk-pendidikan-ppd',compact('roles_menu','krt'));
            }
    }

    function laporan_ajk_pendidikan_ppn(Request $request){
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
                            ->orderBy('krt_nama', 'ASC')
                            ->get();
                    return Response::json($data);
                }
                $data = DB::select(DB::raw("
                SELECT
                ref__pendidikan.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__pendidikan.pendidikan_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                JOIN ref__pendidikan
                LEFT JOIN (
                        SELECT
                                        krt__ahli_jawatan_kuasa.ajk_pendidikan_id AS pendidikan_id, 
                                        count(*) AS total
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__pendidikan ON ref__pendidikan.id = krt__ahli_jawatan_kuasa.ajk_pendidikan_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__pendidikan.pendidikan_status = 1
                        GROUP BY krt__ahli_jawatan_kuasa.ajk_pendidikan_id, krt__ahli_jawatan_kuasa.krt_profile_id
                ) a ON a.pendidikan_id = ref__pendidikan.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__profile.state_id = '" . Auth::user()->state_id . "'
                GROUP BY ref__pendidikan.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__pendidikan.pendidikan_description, a.total
                ORDER BY krt__profile.krt_nama, ref__pendidikan.id
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
                        ->get();
                return view('rt-sm30.laporan-ajk-pendidikan-ppn',compact('roles_menu','daerah'));
            }
    }

    function laporan_ajk_pendidikan_hqrt(Request $request){
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
                            ->orderBy('krt_nama', 'ASC')
                            ->get();
                    return Response::json($data);
                }
                $data = DB::select(DB::raw("
                SELECT
                ref__pendidikan.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__pendidikan.pendidikan_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                JOIN ref__pendidikan
                LEFT JOIN (
                        SELECT
                                        krt__ahli_jawatan_kuasa.ajk_pendidikan_id AS pendidikan_id, 
                                        count(*) AS total
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__pendidikan ON ref__pendidikan.id = krt__ahli_jawatan_kuasa.ajk_pendidikan_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__pendidikan.pendidikan_status = 1
                        GROUP BY krt__ahli_jawatan_kuasa.ajk_pendidikan_id, krt__ahli_jawatan_kuasa.krt_profile_id
                ) a ON a.pendidikan_id = ref__pendidikan.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1
                GROUP BY ref__pendidikan.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__pendidikan.pendidikan_description, a.total
                ORDER BY krt__profile.krt_nama, ref__pendidikan.id
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
                return view('rt-sm30.laporan-ajk-pendidikan-hqrt',compact('roles_menu','state'));
            }
    }

    function laporan_ajk_pendidikan_kp(Request $request){
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
                            ->orderBy('krt_nama', 'ASC')
                            ->get();
                    return Response::json($data);
                }
                $data = DB::select(DB::raw("
                SELECT
                ref__pendidikan.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__pendidikan.pendidikan_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                JOIN ref__pendidikan
                LEFT JOIN (
                        SELECT
                                        krt__ahli_jawatan_kuasa.ajk_pendidikan_id AS pendidikan_id, 
                                        count(*) AS total
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__pendidikan ON ref__pendidikan.id = krt__ahli_jawatan_kuasa.ajk_pendidikan_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__pendidikan.pendidikan_status = 1
                        GROUP BY krt__ahli_jawatan_kuasa.ajk_pendidikan_id, krt__ahli_jawatan_kuasa.krt_profile_id
                ) a ON a.pendidikan_id = ref__pendidikan.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1
                GROUP BY ref__pendidikan.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__pendidikan.pendidikan_description, a.total
                ORDER BY krt__profile.krt_nama, ref__pendidikan.id
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
                return view('rt-sm30.laporan-ajk-pendidikan-kp',compact('roles_menu','state'));
            }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function laporan_ajk_kaum_pengerusi(Request $request){
        if($request->ajax()){ 
                $type = $request->type;
                $data = DB::select(DB::raw("
                SELECT
                ref__kaum.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__kaum.kaum_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                JOIN ref__kaum
                LEFT JOIN (
                   SELECT
                        krt__ahli_jawatan_kuasa.ajk_kaum AS kaum_id, 
                        count(*) AS total
                   FROM krt__ahli_jawatan_kuasa 
                   LEFT JOIN ref__kaum ON ref__kaum.id = krt__ahli_jawatan_kuasa.ajk_kaum
                   WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__kaum.`status` = 1
                   GROUP BY krt__ahli_jawatan_kuasa.ajk_kaum, krt__ahli_jawatan_kuasa.krt_profile_id
                ) a ON a.kaum_id = ref__kaum.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__profile.id = '" . Auth::user()->krt_id . "'
                GROUP BY ref__kaum.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__kaum.kaum_description, a.total
                ORDER BY krt__profile.krt_nama, ref__kaum.id"));
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
                return view('rt-sm30.laporan-ajk-kaum-pengerusi',compact('roles_menu'));
            }
    }

    function laporan_ajk_kaum_setiausaha(Request $request){
        if($request->ajax()){ 
                $type = $request->type;
                $data = DB::select(DB::raw("
                SELECT
                ref__kaum.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__kaum.kaum_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                JOIN ref__kaum
                LEFT JOIN (
                   SELECT
                        krt__ahli_jawatan_kuasa.ajk_kaum AS kaum_id, 
                        count(*) AS total
                   FROM krt__ahli_jawatan_kuasa 
                   LEFT JOIN ref__kaum ON ref__kaum.id = krt__ahli_jawatan_kuasa.ajk_kaum
                   WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__kaum.`status` = 1
                   GROUP BY krt__ahli_jawatan_kuasa.ajk_kaum, krt__ahli_jawatan_kuasa.krt_profile_id
                ) a ON a.kaum_id = ref__kaum.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__profile.id = '" . Auth::user()->krt_id . "'
                GROUP BY ref__kaum.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__kaum.kaum_description, a.total
                ORDER BY krt__profile.krt_nama, ref__kaum.id"));
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
                return view('rt-sm30.laporan-ajk-kaum-setiausaha',compact('roles_menu'));
            }
    }
    
    function laporan_ajk_kaum_ppd(Request $request){
        if($request->ajax()){ 
                $type = $request->type;
                $data = DB::select(DB::raw("
                SELECT
                ref__kaum.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__kaum.kaum_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                JOIN ref__kaum
                LEFT JOIN (
                        SELECT
                                        krt__ahli_jawatan_kuasa.ajk_kaum AS kaum_id, 
                                        count(*) AS total
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__kaum ON ref__kaum.id = krt__ahli_jawatan_kuasa.ajk_kaum
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__kaum.`status` = 1
                        GROUP BY krt__ahli_jawatan_kuasa.ajk_kaum, krt__ahli_jawatan_kuasa.krt_profile_id
                ) a ON a.kaum_id = ref__kaum.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__profile.daerah_id = '" . Auth::user()->daerah_id . "'
                GROUP BY ref__kaum.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__kaum.kaum_description, a.total
                ORDER BY krt__profile.krt_nama, ref__kaum.id
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
                $krt        = KRT_Profile::where('krt_status', '=',  true)
                        ->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)
                        ->orderBy('krt_nama', 'ASC')    
                        ->get();
                return view('rt-sm30.laporan-ajk-kaum-ppd',compact('roles_menu','krt'));
            }
    }

    function laporan_ajk_kaum_ppn(Request $request){
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
                            ->orderBy('krt_nama', 'ASC')
                            ->get();
                    return Response::json($data);
                }
                $data = DB::select(DB::raw("
                SELECT
                ref__kaum.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__kaum.kaum_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                JOIN ref__kaum
                LEFT JOIN (
                        SELECT
                                        krt__ahli_jawatan_kuasa.ajk_kaum AS kaum_id, 
                                        count(*) AS total
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__kaum ON ref__kaum.id = krt__ahli_jawatan_kuasa.ajk_kaum
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__kaum.`status` = 1
                        GROUP BY krt__ahli_jawatan_kuasa.ajk_kaum, krt__ahli_jawatan_kuasa.krt_profile_id
                ) a ON a.kaum_id = ref__kaum.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__profile.state_id = '" . Auth::user()->state_id . "'
                GROUP BY ref__kaum.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__kaum.kaum_description, a.total
                ORDER BY krt__profile.krt_nama, ref__kaum.id
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
                        ->get();
                return view('rt-sm30.laporan-ajk-kaum-ppn',compact('roles_menu','daerah'));
            }
    }

    function laporan_ajk_kaum_hqrt(Request $request){
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
                            ->orderBy('krt_nama', 'ASC')
                            ->get();
                    return Response::json($data);
                }
                $data = DB::select(DB::raw("
                SELECT
                ref__kaum.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__kaum.kaum_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                JOIN ref__kaum
                LEFT JOIN (
                        SELECT
                                        krt__ahli_jawatan_kuasa.ajk_kaum AS kaum_id, 
                                        count(*) AS total
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__kaum ON ref__kaum.id = krt__ahli_jawatan_kuasa.ajk_kaum
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__kaum.`status` = 1
                        GROUP BY krt__ahli_jawatan_kuasa.ajk_kaum, krt__ahli_jawatan_kuasa.krt_profile_id
                ) a ON a.kaum_id = ref__kaum.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1
                GROUP BY ref__kaum.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__kaum.kaum_description, a.total
                ORDER BY krt__profile.krt_nama, ref__kaum.id
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
                return view('rt-sm30.laporan-ajk-kaum-hqrt',compact('roles_menu','state'));
            }
    }

    function laporan_ajk_kaum_kp(Request $request){
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
                            ->orderBy('krt_nama', 'ASC')
                            ->get();
                    return Response::json($data);
                }
                $data = DB::select(DB::raw("
                SELECT
                ref__kaum.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__kaum.kaum_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                JOIN ref__kaum
                LEFT JOIN (
                        SELECT
                                        krt__ahli_jawatan_kuasa.ajk_kaum AS kaum_id, 
                                        count(*) AS total
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__kaum ON ref__kaum.id = krt__ahli_jawatan_kuasa.ajk_kaum
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__kaum.`status` = 1
                        GROUP BY krt__ahli_jawatan_kuasa.ajk_kaum, krt__ahli_jawatan_kuasa.krt_profile_id
                ) a ON a.kaum_id = ref__kaum.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1
                GROUP BY ref__kaum.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__kaum.kaum_description, a.total
                ORDER BY krt__profile.krt_nama, ref__kaum.id
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
                return view('rt-sm30.laporan-ajk-kaum-kp',compact('roles_menu','state'));
            }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function laporan_ajk_pekerjaan_pengerusi(Request $request){
        if($request->ajax()){ 
                $type = $request->type;
                $data = DB::select(DB::raw("
                SELECT
                ref__profession.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__profession.profession_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                JOIN ref__profession
                LEFT JOIN (
                   SELECT
                        krt__ahli_jawatan_kuasa.ajk_profession_id AS profession_id, 
                        count(*) AS total
                   FROM krt__ahli_jawatan_kuasa 
                   LEFT JOIN ref__profession ON ref__profession.id = krt__ahli_jawatan_kuasa.ajk_profession_id
                   WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__profession.`status` = 1
                   GROUP BY krt__ahli_jawatan_kuasa.ajk_profession_id, krt__ahli_jawatan_kuasa.krt_profile_id
                ) a ON a.profession_id = ref__profession.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__profile.id = '" . Auth::user()->krt_id . "'
                GROUP BY ref__profession.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__profession.profession_description, a.total
                ORDER BY krt__profile.krt_nama, ref__profession.id"));
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
                return view('rt-sm30.laporan-ajk-pekerjaan-pengerusi',compact('roles_menu'));
        }
    }

    function laporan_ajk_pekerjaan_setiausa(Request $request){
        if($request->ajax()){ 
                $type = $request->type;
                $data = DB::select(DB::raw("
                SELECT
                ref__profession.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__profession.profession_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                JOIN ref__profession
                LEFT JOIN (
                   SELECT
                        krt__ahli_jawatan_kuasa.ajk_profession_id AS profession_id, 
                        count(*) AS total
                   FROM krt__ahli_jawatan_kuasa 
                   LEFT JOIN ref__profession ON ref__profession.id = krt__ahli_jawatan_kuasa.ajk_profession_id
                   WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__profession.`status` = 1
                   GROUP BY krt__ahli_jawatan_kuasa.ajk_profession_id, krt__ahli_jawatan_kuasa.krt_profile_id
                ) a ON a.profession_id = ref__profession.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__profile.id = '" . Auth::user()->krt_id . "'
                GROUP BY ref__profession.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__profession.profession_description, a.total
                ORDER BY krt__profile.krt_nama, ref__profession.id"));
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
                return view('rt-sm30.laporan-ajk-pekerjaan-setiausaha',compact('roles_menu'));
        }
    }
    
    function laporan_ajk_pekerjaan_ppd(Request $request){
        if($request->ajax()){ 
                $type = $request->type;
                $data = DB::select(DB::raw("
                SELECT
                ref__profession.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__profession.profession_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                JOIN ref__profession
                LEFT JOIN (
                        SELECT
                                        krt__ahli_jawatan_kuasa.ajk_profession_id AS profession_id, 
                                        count(*) AS total
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__profession ON ref__profession.id = krt__ahli_jawatan_kuasa.ajk_profession_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__profession.`status` = 1
                        GROUP BY krt__ahli_jawatan_kuasa.ajk_profession_id, krt__ahli_jawatan_kuasa.krt_profile_id
                ) a ON a.profession_id = ref__profession.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__profile.daerah_id = '" . Auth::user()->daerah_id . "'
                GROUP BY ref__profession.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__profession.profession_description, a.total
                ORDER BY krt__profile.krt_nama, ref__profession.id
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
                        ->orderBy('krt_nama', 'ASC') 
                        ->get();
                return view('rt-sm30.laporan-ajk-pekerjaan-ppd',compact('roles_menu','krt'));
            }
    }

    function laporan_ajk_pekerjaan_ppn(Request $request){
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
                            ->orderBy('krt_nama', 'ASC')
                            ->get();
                    return Response::json($data);
                }
                $data = DB::select(DB::raw("
                SELECT
                ref__profession.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__profession.profession_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                JOIN ref__profession
                LEFT JOIN (
                        SELECT
                                        krt__ahli_jawatan_kuasa.ajk_profession_id AS profession_id, 
                                        count(*) AS total
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__profession ON ref__profession.id = krt__ahli_jawatan_kuasa.ajk_profession_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__profession.`status` = 1
                        GROUP BY krt__ahli_jawatan_kuasa.ajk_profession_id, krt__ahli_jawatan_kuasa.krt_profile_id
                ) a ON a.profession_id = ref__profession.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__profile.state_id = '" . Auth::user()->state_id . "'
                GROUP BY ref__profession.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__profession.profession_description, a.total
                ORDER BY krt__profile.krt_nama, ref__profession.id
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
                        ->get();
                return view('rt-sm30.laporan-ajk-pekerjaan-ppn',compact('roles_menu','daerah'));
            }
    }

    function laporan_ajk_pekerjaan_hqrt(Request $request){
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
                            ->orderBy('krt_nama', 'ASC')
                            ->get();
                    return Response::json($data);
                }
                $data = DB::select(DB::raw("
                SELECT
                ref__profession.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__profession.profession_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                JOIN ref__profession
                LEFT JOIN (
                        SELECT
                                        krt__ahli_jawatan_kuasa.ajk_profession_id AS profession_id, 
                                        count(*) AS total
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__profession ON ref__profession.id = krt__ahli_jawatan_kuasa.ajk_profession_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__profession.`status` = 1
                        GROUP BY krt__ahli_jawatan_kuasa.ajk_profession_id, krt__ahli_jawatan_kuasa.krt_profile_id
                ) a ON a.profession_id = ref__profession.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1
                GROUP BY ref__profession.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__profession.profession_description, a.total
                ORDER BY krt__profile.krt_nama, ref__profession.id
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
                return view('rt-sm30.laporan-ajk-pekerjaan-hqrt',compact('roles_menu','state'));
            }
    }

    function laporan_ajk_pekerjaan_kp(Request $request){
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
                            ->orderBy('krt_nama', 'ASC')
                            ->get();
                    return Response::json($data);
                }
                $data = DB::select(DB::raw("
                SELECT
                ref__profession.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__profession.profession_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                JOIN ref__profession
                LEFT JOIN (
                        SELECT
                                        krt__ahli_jawatan_kuasa.ajk_profession_id AS profession_id, 
                                        count(*) AS total
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__profession ON ref__profession.id = krt__ahli_jawatan_kuasa.ajk_profession_id
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__profession.`status` = 1
                        GROUP BY krt__ahli_jawatan_kuasa.ajk_profession_id, krt__ahli_jawatan_kuasa.krt_profile_id
                ) a ON a.profession_id = ref__profession.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1
                GROUP BY ref__profession.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__profession.profession_description, a.total
                ORDER BY krt__profile.krt_nama, ref__profession.id
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
                return view('rt-sm30.laporan-ajk-pekerjaan-kp',compact('roles_menu','state'));
            }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function laporan_ajk_jantina_pengerusi(Request $request){
        if($request->ajax()){ 
                $type = $request->type;
                $data = DB::select(DB::raw("
                SELECT
                ref__jantina.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__jantina.jantina_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                JOIN ref__jantina
                LEFT JOIN (
                  SELECT
                        krt__ahli_jawatan_kuasa.ajk_jantina AS jantina_id, 
                        count(*) AS total
                  FROM krt__ahli_jawatan_kuasa 
                  LEFT JOIN ref__jantina ON ref__jantina.id = krt__ahli_jawatan_kuasa.ajk_jantina
                  WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__jantina.`status` = 1
                  GROUP BY krt__ahli_jawatan_kuasa.ajk_jantina, krt__ahli_jawatan_kuasa.krt_profile_id
                ) a ON a.jantina_id = ref__jantina.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__profile.id = '" . Auth::user()->krt_id . "'
                GROUP BY ref__jantina.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__jantina.jantina_description, a.total
                ORDER BY krt__profile.krt_nama, ref__jantina.id"));
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
                return view('rt-sm30.laporan-ajk-jantina-pengerusi',compact('roles_menu'));
        }
    }

    function laporan_ajk_jantina_setiausaha(Request $request){
        if($request->ajax()){ 
                $type = $request->type;
                $data = DB::select(DB::raw("
                SELECT
                ref__jantina.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__jantina.jantina_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                JOIN ref__jantina
                LEFT JOIN (
                  SELECT
                        krt__ahli_jawatan_kuasa.ajk_jantina AS jantina_id, 
                        count(*) AS total
                  FROM krt__ahli_jawatan_kuasa 
                  LEFT JOIN ref__jantina ON ref__jantina.id = krt__ahli_jawatan_kuasa.ajk_jantina
                  WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__jantina.`status` = 1
                  GROUP BY krt__ahli_jawatan_kuasa.ajk_jantina, krt__ahli_jawatan_kuasa.krt_profile_id
                ) a ON a.jantina_id = ref__jantina.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__profile.id = '" . Auth::user()->krt_id . "'
                GROUP BY ref__jantina.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__jantina.jantina_description, a.total
                ORDER BY krt__profile.krt_nama, ref__jantina.id"));
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
                return view('rt-sm30.laporan-ajk-jantina-setiausaha',compact('roles_menu'));
        }
    }
    
    function laporan_ajk_jantina_ppd(Request $request){
        if($request->ajax()){ 
                $type = $request->type;
                $data = DB::select(DB::raw("
                SELECT
                ref__jantina.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__jantina.jantina_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                JOIN ref__jantina
                LEFT JOIN (
                        SELECT
                                        krt__ahli_jawatan_kuasa.ajk_jantina AS jantina_id, 
                                        count(*) AS total
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__jantina ON ref__jantina.id = krt__ahli_jawatan_kuasa.ajk_jantina
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__jantina.`status` = 1
                        GROUP BY krt__ahli_jawatan_kuasa.ajk_jantina, krt__ahli_jawatan_kuasa.krt_profile_id
                ) a ON a.jantina_id = ref__jantina.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__profile.daerah_id = '" . Auth::user()->daerah_id . "'
                GROUP BY ref__jantina.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__jantina.jantina_description, a.total
                ORDER BY krt__profile.krt_nama, ref__jantina.id
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
                        ->orderBy('krt_nama', 'ASC') 
                        ->get();
                return view('rt-sm30.laporan-ajk-jantina-ppd',compact('roles_menu','krt'));
            }
    }

    function laporan_ajk_jantina_ppn(Request $request){
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
                            ->orderBy('krt_nama', 'ASC')
                            ->get();
                    return Response::json($data);
                }
                $data = DB::select(DB::raw("
                SELECT
                ref__jantina.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__jantina.jantina_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                JOIN ref__jantina
                LEFT JOIN (
                        SELECT
                                        krt__ahli_jawatan_kuasa.ajk_jantina AS jantina_id, 
                                        count(*) AS total
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__jantina ON ref__jantina.id = krt__ahli_jawatan_kuasa.ajk_jantina
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__jantina.`status` = 1
                        GROUP BY krt__ahli_jawatan_kuasa.ajk_jantina, krt__ahli_jawatan_kuasa.krt_profile_id
                ) a ON a.jantina_id = ref__jantina.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND krt__profile.state_id = '" . Auth::user()->state_id . "'
                GROUP BY ref__jantina.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__jantina.jantina_description, a.total
                ORDER BY krt__profile.krt_nama, ref__jantina.id
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
                        ->get();
                return view('rt-sm30.laporan-ajk-jantina-ppn',compact('roles_menu','daerah'));
            }
    }

    function laporan_ajk_jantina_hqrt(Request $request){
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
                            ->orderBy('krt_nama', 'ASC')
                            ->get();
                    return Response::json($data);
                }
                $data = DB::select(DB::raw("
                SELECT
                ref__jantina.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__jantina.jantina_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                JOIN ref__jantina
                LEFT JOIN (
                        SELECT
                                        krt__ahli_jawatan_kuasa.ajk_jantina AS jantina_id, 
                                        count(*) AS total
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__jantina ON ref__jantina.id = krt__ahli_jawatan_kuasa.ajk_jantina
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__jantina.`status` = 1
                        GROUP BY krt__ahli_jawatan_kuasa.ajk_jantina, krt__ahli_jawatan_kuasa.krt_profile_id
                ) a ON a.jantina_id = ref__jantina.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1
                GROUP BY ref__jantina.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__jantina.jantina_description, a.total
                ORDER BY krt__profile.krt_nama, ref__jantina.id"));
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
                return view('rt-sm30.laporan-ajk-jantina-hqrt',compact('roles_menu','state'));
            }
    }

    function laporan_ajk_jantina_kp(Request $request){
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
                            ->orderBy('krt_nama', 'ASC')
                            ->get();
                    return Response::json($data);
                }
                $data = DB::select(DB::raw("
                SELECT
                ref__jantina.id,
                ref__states.state_description AS state,
                ref__daerahs.daerah_description AS daerah,
                krt__profile.krt_nama AS nama_krt,
                ref__jantina.jantina_description,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN krt__ahli_jawatan_kuasa ON krt__ahli_jawatan_kuasa.krt_profile_id = krt__profile.id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                JOIN ref__jantina
                LEFT JOIN (
                        SELECT
                                        krt__ahli_jawatan_kuasa.ajk_jantina AS jantina_id, 
                                        count(*) AS total
                        FROM krt__ahli_jawatan_kuasa 
                        LEFT JOIN ref__jantina ON ref__jantina.id = krt__ahli_jawatan_kuasa.ajk_jantina
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1 AND ref__jantina.`status` = 1
                        GROUP BY krt__ahli_jawatan_kuasa.ajk_jantina, krt__ahli_jawatan_kuasa.krt_profile_id
                ) a ON a.jantina_id = ref__jantina.id
                WHERE krt__ahli_jawatan_kuasa.ajk_status = 1
                GROUP BY ref__jantina.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, ref__jantina.jantina_description, a.total
                ORDER BY krt__profile.krt_nama, ref__jantina.id
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
                return view('rt-sm30.laporan-ajk-jantina-kp',compact('roles_menu','state'));
            }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function laporan_mesyuarat_krt_ppd(Request $request){
        if($request->ajax()){ 
                $type = $request->type;
                $data = DB::select(DB::raw("
                SELECT
                krt__profile.id,
                ref__states.state_description,
                ref__daerahs.daerah_description,
                krt__profile.krt_nama,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN (
                        SELECT
                        krt__minit_mesyuarat.krt_profile_id AS krt_profile_id, 
                count(*) AS total
                FROM krt__minit_mesyuarat 
                WHERE krt__minit_mesyuarat.mesyuarat_status = 1 
                GROUP BY krt__minit_mesyuarat.krt_profile_id
                ) a ON a.krt_profile_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND krt__profile.daerah_id = '" . Auth::user()->daerah_id . "'
                GROUP BY krt__profile.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, a.total"));
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
                        ->orderBy('krt_nama', 'ASC') 
                        ->get();
                return view('rt-sm30.laporan-mesyuarat-krt-ppd',compact('roles_menu','krt'));
            }
    }

    function laporan_mesyuarat_krt_ppn(Request $request){
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
                                ->orderBy('krt_nama', 'ASC')
                                ->get();
                        return Response::json($data);
                    }
                $data = DB::select(DB::raw("
                SELECT
                krt__profile.id,
                ref__states.state_description,
                ref__daerahs.daerah_description,
                krt__profile.krt_nama,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN (
                        SELECT
                        krt__minit_mesyuarat.krt_profile_id AS krt_profile_id, 
                count(*) AS total
                FROM krt__minit_mesyuarat 
                WHERE krt__minit_mesyuarat.mesyuarat_status = 1 
                GROUP BY krt__minit_mesyuarat.krt_profile_id
                ) a ON a.krt_profile_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 AND krt__profile.state_id = '" . Auth::user()->state_id . "'
                GROUP BY krt__profile.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, a.total"));
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
                        ->get();
                return view('rt-sm30.laporan-mesyuarat-krt-ppn',compact('roles_menu','daerah'));
            }
    }

    function laporan_mesyuarat_krt_hqrt(Request $request){
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
                                ->orderBy('krt_nama', 'ASC')
                                ->get();
                        return Response::json($data);
                    }
                $data = DB::select(DB::raw("
                SELECT
                krt__profile.id,
                ref__states.state_description,
                ref__daerahs.daerah_description,
                krt__profile.krt_nama,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN (
                        SELECT
                        krt__minit_mesyuarat.krt_profile_id AS krt_profile_id, 
                count(*) AS total
                FROM krt__minit_mesyuarat 
                WHERE krt__minit_mesyuarat.mesyuarat_status = 1 
                GROUP BY krt__minit_mesyuarat.krt_profile_id
                ) a ON a.krt_profile_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 
                GROUP BY krt__profile.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, a.total"));
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
                return view('rt-sm30.laporan-mesyuarat-krt-hqrt',compact('roles_menu','state'));
            }
    }

    function laporan_mesyuarat_krt_kp(Request $request){
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
                                ->orderBy('krt_nama', 'ASC')
                                ->get();
                        return Response::json($data);
                    }
                $data = DB::select(DB::raw("
                SELECT
                krt__profile.id,
                ref__states.state_description,
                ref__daerahs.daerah_description,
                krt__profile.krt_nama,
                (case when a.total IS NOT NULL then a.total else 0 end)AS total
                FROM krt__profile
                LEFT JOIN ref__states ON ref__states.state_id = krt__profile.state_id
                LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                LEFT JOIN (
                        SELECT
                        krt__minit_mesyuarat.krt_profile_id AS krt_profile_id, 
                count(*) AS total
                FROM krt__minit_mesyuarat 
                WHERE krt__minit_mesyuarat.mesyuarat_status = 1 
                GROUP BY krt__minit_mesyuarat.krt_profile_id
                ) a ON a.krt_profile_id = krt__profile.id
                WHERE krt__profile.krt_status = 1 
                GROUP BY krt__profile.id, ref__states.state_description, ref__daerahs.daerah_description, krt__profile.krt_nama, a.total"));
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
                return view('rt-sm30.laporan-mesyuarat-krt-kp',compact('roles_menu','state'));
            }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    function laporan_skuad_uniti_hqrt(Request $request){
        return view('rt-sm30.laporan-skuad-uniti-hqrt');
    }

    function laporan_penduduk_rt_kaum_hqrt(){
        return view('rt-sm30.laporan-penduduk-rt-kaum-hqrt');
    }

    function laporan_sosio_ekonomi_rt_hqrt(){
        return view('rt-sm30.laporan-sosio-ekonomi-rt-hqrt');
    }

    function laporan_kategori_rumah_rt_hqrt(){
        return view('rt-sm30.laporan-kategori-rumah-rt-hqrt');
    }

    function laporan_kemudahan_rt_hqrt(){
        return view('rt-sm30.laporan-kemudahan-rt-hqrt');
    }

    function laporan_binaan_jabatan_rt_hqrt(){
        return view('rt-sm30.laporan-binaan-jabatan-rt-hqrt');
    }

    function laporan_binaan_tumpang_rt_hqrt(){
        return view('rt-sm30.laporan-binaan-tumpang-rt-hqrt');
    }

    function laporan_binaan_sewa_rt_hqrt(){
        return view('rt-sm30.laporan-binaan-sewa-rt-hqrt');
    }

    function laporan_kabin_rt_hqrt(){
        return view('rt-sm30.laporan-kabin-rt-hqrt');
    }

    function laporan_kekerapan_mesyuarat_rt_hqrt(){
        return view('rt-sm30.laporan-kekerapan-mesyuarat-rt-hqrt');
    }

    function laporan_maklumat_perbankan_rt_hqrt(){
        return view('rt-sm30.laporan-maklumat-perbankan-rt-hqrt');
    }
    
	public function get_excel_file2(Request $request, $negeri, $daerah, $agenda, $bidang, $kategori, $jenis)
    {
		$v_where =  "";
		$v_negeri = $negeri;
		if($v_negeri != "null")
		{
			$v_where = " ref__states.state_description='". $v_negeri ."'";
		}
		$v_daerah = $daerah;
		if($v_daerah != "null")
		{
			if($v_where != "")
				$v_where = $v_where . " AND ref__daerahs.daerah_description='". $v_daerah ."'";
			else
				$v_where = " ref__daerahs.daerah_description='". $v_daerah ."'";
		}
		$v_agenda = $agenda;
		if($v_agenda != "null")
		{
			if($v_where != "")
				$v_where = $v_where . " AND ref__aktiviti_agenda_kerja.agenda_description='". $v_agenda ."'";
			else
				$v_where = " ref__aktiviti_agenda_kerja.agenda_description='". $v_agenda ."'";
		}
		$v_bidang = $bidang;
		if($v_bidang != "null")
		{
			if($v_where != "")
				$v_where = $v_where . " AND ref__aktiviti_bidang.bidang_description='". $v_bidang ."'";
			else
				$v_where = " ref__aktiviti_bidang.bidang_description='". $v_bidang ."'";
		}
		$v_kategori = $kategori;
		if($v_kategori != "null")
		{
			if($v_where != "")
				$v_where = $v_where . " AND ref__aktiviti.aktiviti_description='". $v_kategori ."'";
			else
				$v_where = " ref__aktiviti.aktiviti_description='". $v_kategori ."'";
		}
		$v_jenis = $jenis;
		if($v_jenis != "null")
		{
			if($v_where != "")
				$v_where = $v_where . " AND ref__jenis_aktiviti.aktiviti_description='". $v_jenis ."'";
			else
				$v_where = " ref__jenis_aktiviti.aktiviti_description='". $v_jenis ."'";
		}
		set_time_limit(300);
		if($v_where != "")
		{
			$data = DB::table('krt__aktiviti_laporan')
					->select('ref__states.state_description AS state',
					  'ref__daerahs.daerah_description AS daerah',
					  'krt__profile.krt_nama AS krt_name',
					  'ref__penganjur.penganjur_description AS penganjur',
					  'krt__aktiviti_laporan.aktiviti_tajuk AS tajuk_aktiviti',
					  'krt__aktiviti_laporan.aktiviti_perasmi AS perasmi_aktiviti',
				      'ref__aktiviti_agenda_kerja.agenda_description AS agenda_kerja',
					  'ref__aktiviti_bidang.bidang_description AS bidang_kerja',
					  'ref__aktiviti.aktiviti_description AS kategori_aktiviti',
					  'ref__jenis_aktiviti.aktiviti_description AS jenis_aktiviti',
					   DB::raw("DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh,'%d/%m/%Y') AS tarikh_aktiviti"),
					   'ref__aktiviti_program.program_description AS program',
					   'krt__aktiviti_laporan.program_id AS program_id',
					   DB::raw("IFNULL(krt__aktiviti_jantinal.bilangan,0) AS jumlah_lelaki"),
					   DB::raw("IFNULL(krt__aktiviti_jantinap.bilangan,0) AS jumlah_perempuan"),
					   DB::raw("IFNULL(krt__aktiviti_umur1.bilangan,0) AS jumlah_umur1"),
					   DB::raw("IFNULL(krt__aktiviti_umur2.bilangan,0) AS jumlah_umur2"),
					   DB::raw("IFNULL(krt__aktiviti_umur3.bilangan,0) AS jumlah_umur3"),
					   DB::raw("IFNULL(krt__aktiviti_umur4.bilangan,0) AS jumlah_umur4"),
					   DB::raw("IFNULL(krt__aktiviti_umur5.bilangan,0) AS jumlah_umur5"),
					   DB::raw("IFNULL(krt__aktiviti_umur6.bilangan,0) AS jumlah_umur6"),
					   DB::raw("IFNULL(krt__aktiviti_umur7.bilangan,0) AS jumlah_umur7"))
					->leftjoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
					->leftjoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
					->leftjoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
					->leftjoin('ref__penganjur','ref__penganjur.id','=','krt__aktiviti_laporan.penganjur_id')
					->leftjoin('ref__aktiviti_agenda_kerja','ref__aktiviti_agenda_kerja.id','=','krt__aktiviti_laporan.agenda_id')
					->leftjoin('ref__aktiviti_bidang','ref__aktiviti_bidang.id','=','krt__aktiviti_laporan.bidang_id')
					->leftjoin('ref__aktiviti','ref__aktiviti.id','=','krt__aktiviti_laporan.aktiviti_id')
					->leftjoin('ref__jenis_aktiviti','ref__jenis_aktiviti.id','=','krt__aktiviti_laporan.sub_aktiviti_id')
					->leftjoin('ref__aktiviti_program','ref__aktiviti_program.id','=','krt__aktiviti_laporan.program_id')
					->leftjoin('krt__aktiviti_jantinal','krt__aktiviti_jantinal.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_jantinap','krt__aktiviti_jantinap.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur1','krt__aktiviti_umur1.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur2','krt__aktiviti_umur2.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur3','krt__aktiviti_umur3.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur4','krt__aktiviti_umur4.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur5','krt__aktiviti_umur5.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur6','krt__aktiviti_umur6.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur7','krt__aktiviti_umur7.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->where('krt__aktiviti_laporan.aktiviti_status','=',1)
					->whereRaw($v_where)
					->orderBy('ref__states.state_description')
					->orderBy('ref__daerahs.daerah_description')
					->orderBy('krt__profile.krt_nama')
					->orderBy('krt__aktiviti_laporan.aktiviti_tarikh')
					->get();
		}else
		{
			$data = DB::table('krt__aktiviti_laporan')
					->select('ref__states.state_description AS state',
					  'ref__daerahs.daerah_description AS daerah',
					  'krt__profile.krt_nama AS krt_name',
					  'ref__penganjur.penganjur_description AS penganjur',
					  'krt__aktiviti_laporan.aktiviti_tajuk AS tajuk_aktiviti',
					  'krt__aktiviti_laporan.aktiviti_perasmi AS perasmi_aktiviti',
				      'ref__aktiviti_agenda_kerja.agenda_description AS agenda_kerja',
					  'ref__aktiviti_bidang.bidang_description AS bidang_kerja',
					  'ref__aktiviti.aktiviti_description AS kategori_aktiviti',
					  'ref__jenis_aktiviti.aktiviti_description AS jenis_aktiviti',
					   DB::raw("DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh,'%d/%m/%Y') AS tarikh_aktiviti"),
					   'ref__aktiviti_program.program_description AS program',
					   'krt__aktiviti_laporan.program_id AS program_id',
					   DB::raw("IFNULL(krt__aktiviti_jantinal.bilangan,0) AS jumlah_lelaki"),
					   DB::raw("IFNULL(krt__aktiviti_jantinap.bilangan,0) AS jumlah_perempuan"),
					   DB::raw("IFNULL(krt__aktiviti_umur1.bilangan,0) AS jumlah_umur1"),
					   DB::raw("IFNULL(krt__aktiviti_umur2.bilangan,0) AS jumlah_umur2"),
					   DB::raw("IFNULL(krt__aktiviti_umur3.bilangan,0) AS jumlah_umur3"),
					   DB::raw("IFNULL(krt__aktiviti_umur4.bilangan,0) AS jumlah_umur4"),
					   DB::raw("IFNULL(krt__aktiviti_umur5.bilangan,0) AS jumlah_umur5"),
					   DB::raw("IFNULL(krt__aktiviti_umur6.bilangan,0) AS jumlah_umur6"),
					   DB::raw("IFNULL(krt__aktiviti_umur7.bilangan,0) AS jumlah_umur7"))
					->leftjoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
					->leftjoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
					->leftjoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
					->leftjoin('ref__penganjur','ref__penganjur.id','=','krt__aktiviti_laporan.penganjur_id')
					->leftjoin('ref__aktiviti_agenda_kerja','ref__aktiviti_agenda_kerja.id','=','krt__aktiviti_laporan.agenda_id')
					->leftjoin('ref__aktiviti_bidang','ref__aktiviti_bidang.id','=','krt__aktiviti_laporan.bidang_id')
					->leftjoin('ref__aktiviti','ref__aktiviti.id','=','krt__aktiviti_laporan.aktiviti_id')
					->leftjoin('ref__jenis_aktiviti','ref__jenis_aktiviti.id','=','krt__aktiviti_laporan.sub_aktiviti_id')
					->leftjoin('ref__aktiviti_program','ref__aktiviti_program.id','=','krt__aktiviti_laporan.program_id')
					->leftjoin('krt__aktiviti_jantinal','krt__aktiviti_jantinal.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_jantinap','krt__aktiviti_jantinap.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur1','krt__aktiviti_umur1.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur2','krt__aktiviti_umur2.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur3','krt__aktiviti_umur3.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur4','krt__aktiviti_umur4.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur5','krt__aktiviti_umur5.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur6','krt__aktiviti_umur6.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur7','krt__aktiviti_umur7.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->where('krt__aktiviti_laporan.aktiviti_status','=',1)
					->orderBy('ref__states.state_description')
					->orderBy('ref__daerahs.daerah_description')
					->orderBy('krt__profile.krt_nama')
					->orderBy('krt__aktiviti_laporan.aktiviti_tarikh')
					->get();	
		}
		return Excel::download(new Laporan_Aktiviti($data), 'aktiviti_file.xlsx');
	}
}
