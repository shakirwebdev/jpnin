<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect, Response;
use Auth;
use Validator;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\RefDaerah;
use App\RefParlimen;
use App\RefDUN;
use App\RefStates;
use App\RefJantina;
use App\RefKaum;
use App\User;
use App\UserProfile;
use App\KRT_Profile;
use App\SRS_Profile;
use App\SRS_Perancangan_Rondaan;
use App\SRS_Perancangan_Rondaan_Ahli;

use DataTables;
use DB;

class RT_SM15Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function penyediaan_perancangan_rondaan_srs(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('srs__perancangan_rondaan')
                        ->select('srs__perancangan_rondaan.id',
                                'srs__perancangan_rondaan.krt_profile_id AS krt_profile_id',
                                'srs__perancangan_rondaan.srs_profile_id AS srs_profile_id',
                                'krt__profile.krt_nama AS nama_krt',
                                'srs__profile.srs_name AS nama_srs',
                                DB::raw(" DATE_FORMAT(srs__perancangan_rondaan.perancangan_rondaan_tarikh,'%d/%m/%Y') AS perancangan_rondaan_tarikh"),
                                DB::raw(" DATE_FORMAT(srs__perancangan_rondaan.direkod_date,'%d/%m/%Y') AS direkod_date"),
                                'users__profile.user_fullname AS user_fullname',
                                'ref__status_rondaan_srs.status_description AS status',
                                'srs__perancangan_rondaan.perancangan_rondaan_status AS srs__perancangan_rondaan')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__perancangan_rondaan.krt_profile_id')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__perancangan_rondaan.srs_profile_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','srs__perancangan_rondaan.direkod_by')
                        ->leftJoin('ref__status_rondaan_srs','ref__status_rondaan_srs.id','=','srs__perancangan_rondaan.perancangan_rondaan_status')
                        ->where('srs__perancangan_rondaan.krt_profile_id', '=', Auth::user()->krt_id)
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
            $srs_profile        = SRS_Profile::where('srs_status', '=', true)
                                ->where('srs__profile.krt_id', '=', Auth::user()->krt_id)
                                ->get();
            return view('rt-sm15.penyediaan-perancangan-rondaan-srs',compact('roles_menu','srs_profile'));
        }
    }

    function post_tambah_perancangan_rondaan(Request $request){
        
        $action = $request->tambah_perancangan_rondaan;
        
        $rules = array(
           
        );

        $messages = [
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm15.penyediaan_perancangan_rondaan_srs'))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'add') {
                $tambah_perancangan_rondaan                             = new SRS_Perancangan_Rondaan;
                $tambah_perancangan_rondaan->krt_profile_id             = Auth::user()->krt_id;
                $tambah_perancangan_rondaan->srs_profile_id             = Auth::user()->srs_id;
                $tambah_perancangan_rondaan->perancangan_rondaan_status = 2;
                $tambah_perancangan_rondaan->save();
            }
           
            return Redirect::to(route('rt-sm15.penyediaan_perancangan_rondaan_srs_1',$tambah_perancangan_rondaan->id));
        }

    }

    function penyediaan_perancangan_rondaan_srs_1(Request $request, $id){
        if($request->ajax()){ 
            
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
            $perancangan_rondaan    = DB::table('srs__perancangan_rondaan')
                                    ->select('srs__perancangan_rondaan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt', 
                                            'ref__daerahs.daerah_description AS daerah_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__duns.dun_description AS dun_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'srs__perancangan_rondaan.krt_profile_id AS krt_profile_id',
                                            'srs__perancangan_rondaan.srs_profile_id AS srs_profile_id',
                                            DB::raw(" DATE_FORMAT(srs__perancangan_rondaan.perancangan_rondaan_tarikh,'%d/%m/%Y') AS perancangan_rondaan_tarikh"))
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__perancangan_rondaan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('srs__perancangan_rondaan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $srs_profile            = SRS_Profile::where('srs_status', '=', true)
                                    ->where('srs__profile.krt_id', '=', Auth::user()->krt_id)
                                    ->get();
            return view('rt-sm15.penyediaan-perancangan-rondaan-srs-1',compact('roles_menu','perancangan_rondaan','srs_profile'));
        }
    }

    function get_senarai_ahli(Request $request, $id){
        return DataTables()->of(
            DB::select(DB::raw("
                SELECT
                srs__ahli_peronda.id, srs__ahli_peronda.peronda_nama, srs__ahli_peronda.peronda_ic, srs__perancangan_rondaan_ahli.id AS srs__perancangan_rondaan_ahli_id, 
                srs__perancangan_rondaan_ahli.srs_perancangan_rondaan_id, srs__perancangan_rondaan_ahli.srs_ahli_peronda_id
                FROM
                srs__ahli_peronda
                LEFT JOIN srs__perancangan_rondaan_ahli ON srs__perancangan_rondaan_ahli.srs_ahli_peronda_id = srs__ahli_peronda.id
                AND srs__perancangan_rondaan_ahli.srs_perancangan_rondaan_id = '" . $id . "'
                WHERE srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.srs_profile_id =  '" .Auth::user()->srs_id. "'
                ORDER BY srs__ahli_peronda.id + 0 ASC
            "))
        )->make();
    }

    function add_perancangan_rondaan_ahli(Request $request){
        $pprs_srs_perancangan_rondaan_id = $request->pprs_srs_perancangan_rondaan_id;
        $srs_perancangan_rondaan_id = $request->srs_perancangan_rondaan_id;
        
        $perancangan_rondaan_ahli = new SRS_Perancangan_Rondaan_Ahli;
        $perancangan_rondaan_ahli->srs_perancangan_rondaan_id   = $pprs_srs_perancangan_rondaan_id;
        $perancangan_rondaan_ahli->srs_ahli_peronda_id          = $request->srs_ahli_peronda_id;
        $perancangan_rondaan_ahli->save();

    }

    function delete__perancangan_rondaan_ahli($id){
        $data = DB::table('srs__perancangan_rondaan_ahli')->where('srs_ahli_peronda_id', '=', $id)->delete();
    }

    function post_tambah_perancangan_rondaan_1(Request $request){
        $action = $request->post_tambah_perancangan_rondaan_1;
        $app_id = $request->pprs_srs_perancangan_rondaan_id;
        
        
        $rules = array(
            'pprs_perancangan_rondaan_tarikh'           => 'required',
        );

        $messages = [
            'pprs_perancangan_rondaan_tarikh.required'  => 'Ruangan Tarikh Rondaaan mesti diisi',
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $carbon_obj     = Carbon::createFromFormat('d/m/Y', $request->pprs_perancangan_rondaan_tarikh)->format('Y-m-d');
                $perancangan_rondaan                                = SRS_Perancangan_Rondaan::where($where)->first();
                $perancangan_rondaan->direkod_by                    = Auth::user()->user_id;
                $perancangan_rondaan->direkod_date                  = date('Y-m-d H:i:s');
                $perancangan_rondaan->perancangan_rondaan_tarikh    = $carbon_obj;
                $perancangan_rondaan->perancangan_rondaan_status    = 1;
                $perancangan_rondaan->save();
            }
        }
    }

    function jana_jadual_rondaan_k(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('srs__perancangan_rondaan')
                        ->select('srs__perancangan_rondaan.id',
                                'srs__perancangan_rondaan.krt_profile_id AS krt_profile_id',
                                'srs__perancangan_rondaan.srs_profile_id AS srs_profile_id',
                                'krt__profile.krt_nama AS nama_krt',
                                'srs__profile.srs_name AS nama_srs',
                                DB::raw(" DATE_FORMAT(srs__perancangan_rondaan.perancangan_rondaan_tarikh,'%d/%m/%Y') AS perancangan_rondaan_tarikh"),
                                DB::raw(" DATE_FORMAT(srs__perancangan_rondaan.direkod_date,'%d/%m/%Y') AS direkod_date"),
                                'users__profile.user_fullname AS user_fullname',
                                'ref__status_rondaan_srs.status_description AS status',
                                'srs__perancangan_rondaan.perancangan_rondaan_status AS srs__perancangan_rondaan')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__perancangan_rondaan.krt_profile_id')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__perancangan_rondaan.srs_profile_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','srs__perancangan_rondaan.direkod_by')
                        ->leftJoin('ref__status_rondaan_srs','ref__status_rondaan_srs.id','=','srs__perancangan_rondaan.perancangan_rondaan_status')
                        ->where('srs__perancangan_rondaan.krt_profile_id', '=', Auth::user()->krt_id)
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
            $srs_profile        = SRS_Profile::where('srs_status', '=', true)
                                ->where('srs__profile.krt_id', '=', Auth::user()->krt_id)
                                ->get();
            return view('rt-sm15.jana-jadual-rondaan-k',compact('roles_menu','srs_profile'));
        }
    }

    function jana_jadual_rondaan_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_srs') {
                $value = $request->value;
                $where = array('krt_id' => $value);
                $data  = SRS_Profile::where($where)
                        ->where('srs__profile.srs_status', '=',  true) 
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('srs__perancangan_rondaan')
                        ->select('srs__perancangan_rondaan.id',
                                'srs__perancangan_rondaan.krt_profile_id AS krt_profile_id',
                                'srs__perancangan_rondaan.srs_profile_id AS srs_profile_id',
                                'krt__profile.krt_nama AS nama_krt',
                                'srs__profile.srs_name AS nama_srs',
                                DB::raw(" DATE_FORMAT(srs__perancangan_rondaan.perancangan_rondaan_tarikh,'%d/%m/%Y') AS perancangan_rondaan_tarikh"),
                                DB::raw(" DATE_FORMAT(srs__perancangan_rondaan.direkod_date,'%d/%m/%Y') AS direkod_date"),
                                'users__profile.user_fullname AS user_fullname',
                                'ref__status_rondaan_srs.status_description AS status',
                                'srs__perancangan_rondaan.perancangan_rondaan_status AS srs__perancangan_rondaan')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__perancangan_rondaan.krt_profile_id')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__perancangan_rondaan.srs_profile_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','srs__perancangan_rondaan.direkod_by')
                        ->leftJoin('ref__status_rondaan_srs','ref__status_rondaan_srs.id','=','srs__perancangan_rondaan.perancangan_rondaan_status')
                        ->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)
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
            $krt_profile        = KRT_Profile::where('krt_status', '=', true)
                                ->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)
                                ->get();
            $srs_profile        = SRS_Profile::where('srs_status', '=', true)
                                ->get();
            return view('rt-sm15.jana-jadual-rondaan-ppd',compact('roles_menu','krt_profile','srs_profile'));
        }
    }

    function jana_jadual_rondaan_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = KRT_Profile::where($where)
                        ->where('krt__profile.krt_status', '=',  true) 
                        ->get();
                return Response::json($data);
            }elseif($type == 'get_srs') {
                $value = $request->value;
                $where = array('krt_id' => $value);
                $data  = SRS_Profile::where($where)
                        ->where('srs__profile.srs_status', '=',  true) 
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('srs__perancangan_rondaan')
                        ->select('srs__perancangan_rondaan.id',
                                'srs__perancangan_rondaan.krt_profile_id AS krt_profile_id',
                                'srs__perancangan_rondaan.srs_profile_id AS srs_profile_id',
                                'ref__daerahs.daerah_description AS daerah',
                                'krt__profile.krt_nama AS nama_krt',
                                'srs__profile.srs_name AS nama_srs',
                                DB::raw(" DATE_FORMAT(srs__perancangan_rondaan.perancangan_rondaan_tarikh,'%d/%m/%Y') AS perancangan_rondaan_tarikh"),
                                DB::raw(" DATE_FORMAT(srs__perancangan_rondaan.direkod_date,'%d/%m/%Y') AS direkod_date"),
                                'users__profile.user_fullname AS user_fullname',
                                'ref__status_rondaan_srs.status_description AS status',
                                'srs__perancangan_rondaan.perancangan_rondaan_status AS srs__perancangan_rondaan')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__perancangan_rondaan.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__perancangan_rondaan.srs_profile_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','srs__perancangan_rondaan.direkod_by')
                        ->leftJoin('ref__status_rondaan_srs','ref__status_rondaan_srs.id','=','srs__perancangan_rondaan.perancangan_rondaan_status')
                        ->whereIn('srs__perancangan_rondaan.perancangan_rondaan_status', [1])
                        ->where('krt__profile.state_id', '=', Auth::user()->state_id)
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
            $daerah             = RefDaerah::where('status', '=', true)
                                ->where('ref__daerahs.state_id', '=', Auth::user()->state_id)
                                ->get();
            $krt_profile        = KRT_Profile::where('krt_status', '=', true)
                                ->get();
            $srs_profile        = SRS_Profile::where('srs_status', '=', true)
                                ->get();
            return view('rt-sm15.jana-jadual-rondaan-ppn',compact('roles_menu','daerah','krt_profile','srs_profile'));
        }
    }

    function laporan_perancangan_rondaan_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_srs') {
                $value = $request->value;
                $where = array('krt_id' => $value);
                $data  = SRS_Profile::where($where)
                        ->where('srs__profile.srs_status', '=',  true) 
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('srs__perancangan_rondaan')
                            ->select('ref__daerahs.daerah_description AS daerah',
                                    'krt__profile.krt_nama AS krt_nama',
                                    'srs__profile.srs_name AS srs_nama',
                                    DB::raw(" YEAR(srs__perancangan_rondaan.perancangan_rondaan_tarikh) AS tahun_perancangan"),
                                    DB::raw(" MONTH(srs__perancangan_rondaan.perancangan_rondaan_tarikh) AS bulan_perancangan"),
                                    DB::raw(" SUM(case when day(srs__perancangan_rondaan.perancangan_rondaan_tarikh) between 1 AND 7 then 1 else 0 end) AS week_1"),
                                    DB::raw(" SUM(case when day(srs__perancangan_rondaan.perancangan_rondaan_tarikh) between 8 AND 14 then 1 else 0 end) AS week_2"),
                                    DB::raw(" SUM(case when day(srs__perancangan_rondaan.perancangan_rondaan_tarikh) between 15 AND 21 then 1 else 0 end) AS week_3"),
                                    DB::raw(" SUM(case when day(srs__perancangan_rondaan.perancangan_rondaan_tarikh) between 22 AND 31 then 1 else 0 end) AS week_4"),
                                    DB::raw(" SUM(case when month(srs__perancangan_rondaan.perancangan_rondaan_tarikh) then 1 else 0 end) AS total_perancangan"))
                            ->leftJoin('krt__profile','krt__profile.id','=','srs__perancangan_rondaan.krt_profile_id')
                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                            ->leftJoin('srs__profile','srs__profile.id','=','srs__perancangan_rondaan.srs_profile_id')
                            ->groupBy(['ref__daerahs.daerah_description', 'krt__profile.krt_nama', 'srs__profile.srs_name',
                            DB::raw(" YEAR(srs__perancangan_rondaan.perancangan_rondaan_tarikh)"),
                            DB::raw(" MONTH(srs__perancangan_rondaan.perancangan_rondaan_tarikh)"),
                            DB::raw(" DATE_FORMAT(perancangan_rondaan_tarikh,'%Y-%m')")])
                            ->where('krt__profile.daerah_id','=', Auth::user()->daerah_id)
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
            $krt_profile        = KRT_Profile::where('krt_status', '=', true)
                                ->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)
                                ->get();
            $srs_profile        = SRS_Profile::where('srs_status', '=', true)
                                ->get();
            return view('rt-sm15.laporan-perancangan-rondaan-ppd',compact('roles_menu','krt_profile','srs_profile'));
        }
    }

    function laporan_perancangan_rondaan_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = KRT_Profile::where($where)
                        ->where('krt__profile.krt_status', '=',  true) 
                        ->get();
                return Response::json($data);
            } else if($type == 'get_srs') {
                $value = $request->value;
                $where = array('krt_id' => $value);
                $data  = SRS_Profile::where($where)
                        ->where('srs__profile.srs_status', '=',  true) 
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('srs__perancangan_rondaan')
                        ->select('ref__daerahs.daerah_description AS daerah',
                                'krt__profile.krt_nama AS krt_nama',
                                'srs__profile.srs_name AS srs_nama',
                                DB::raw(" YEAR(srs__perancangan_rondaan.perancangan_rondaan_tarikh) AS tahun_perancangan"),
                                DB::raw(" MONTH(srs__perancangan_rondaan.perancangan_rondaan_tarikh) AS bulan_perancangan"),
                                DB::raw(" SUM(case when day(srs__perancangan_rondaan.perancangan_rondaan_tarikh) between 1 AND 7 then 1 else 0 end) AS week_1"),
                                DB::raw(" SUM(case when day(srs__perancangan_rondaan.perancangan_rondaan_tarikh) between 8 AND 14 then 1 else 0 end) AS week_2"),
                                DB::raw(" SUM(case when day(srs__perancangan_rondaan.perancangan_rondaan_tarikh) between 15 AND 21 then 1 else 0 end) AS week_3"),
                                DB::raw(" SUM(case when day(srs__perancangan_rondaan.perancangan_rondaan_tarikh) between 22 AND 31 then 1 else 0 end) AS week_4"),
                                DB::raw(" SUM(case when month(srs__perancangan_rondaan.perancangan_rondaan_tarikh) then 1 else 0 end) AS total_perancangan"))
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__perancangan_rondaan.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__perancangan_rondaan.srs_profile_id')
                        ->groupBy(['ref__daerahs.daerah_description', 'krt__profile.krt_nama', 'srs__profile.srs_name',
                        DB::raw(" YEAR(srs__perancangan_rondaan.perancangan_rondaan_tarikh)"),
                        DB::raw(" MONTH(srs__perancangan_rondaan.perancangan_rondaan_tarikh)"),
                        DB::raw(" DATE_FORMAT(perancangan_rondaan_tarikh,'%Y-%m')")])
                        ->whereIn('srs__perancangan_rondaan.perancangan_rondaan_status', [1])
                        ->where('krt__profile.state_id','=', Auth::user()->state_id)
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
            $daerah             = RefDaerah::where('status', '=', true)
                                ->where('ref__daerahs.state_id', '=', Auth::user()->state_id)
                                ->get();
            $krt_profile        = KRT_Profile::where('krt_status', '=', true)
                                ->get();
            $srs_profile        = SRS_Profile::where('srs_status', '=', true)
                                ->get();
            return view('rt-sm15.laporan-perancangan-rondaan-ppn',compact('roles_menu','daerah','krt_profile','srs_profile'));
        }
    }

    function penyediaan_perancangan_rondaan(){
        return view('rt-sm15.penyediaan-perancangan-rondaan');
    }

    function jana_jadual_rondaan_srs(){
        return view('rt-sm15.jana-jadual-rondaan-srs');
    }

    function pengesahan_rondaan_srs(){
        return view('rt-sm15.pengesahan-rondaan-srs');
    }

    function ringkasan_laporan_perancangan_rondaan(){
        return view('rt-sm15.ringkasan-laporan-perancangan-rondaan');
    }

    function jana_laporan_kekerapan_rondaan_d(){
        return view('rt-sm15.jana-laporan-kekerapan-rondaan-d');
    }

    function jana_laporan_kekerapan_rondaan_n(){
        return view('rt-sm15.jana-laporan-kekerapan-rondaan-n');
    }

    function jana_laporan_kekerapan_rondaan_all(){
        return view('rt-sm15.jana-laporan-kekerapan-rondaan-all');
    }
}
