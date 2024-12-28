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
use App\SRS_Pemakluman_Ops_Rondaan;

use DataTables;
use DB;


class RT_SM14Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function pemakluman_ops_rondaan_srs(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('srs__pemakluman_ops_rondaan')
                        ->select('srs__pemakluman_ops_rondaan.id',
                                'srs__pemakluman_ops_rondaan.krt_profile_id AS krt_profile_id',
                                'srs__pemakluman_ops_rondaan.srs_profile_id AS srs_profile_id',
                                'krt__profile.krt_nama AS nama_krt',
                                'srs__profile.srs_name AS nama_srs',
                                DB::raw(" DATE_FORMAT(srs__pemakluman_ops_rondaan.ops_tarikh_mula_ronda,'%d/%m/%Y') AS ops_tarikh_mula_ronda"),
                                DB::raw(" DATE_FORMAT(srs__pemakluman_ops_rondaan.ops_tarikh_surat,'%d/%m/%Y') AS ops_tarikh_surat"),
                                DB::raw(" DATE_FORMAT(srs__pemakluman_ops_rondaan.direkod_date,'%d/%m/%Y') AS direkod_date"),
                                'users__profile.user_fullname AS user_fullname')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__pemakluman_ops_rondaan.krt_profile_id')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__pemakluman_ops_rondaan.srs_profile_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','srs__pemakluman_ops_rondaan.direkod_by')
                        ->where('krt__profile.id', '=', Auth::user()->krt_id)
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
            return view('rt-sm14.pemakluman-ops-rondaan-srs',compact('roles_menu','srs_profile'));
        }
    }

    function add_pemakluman_ops_rondaan(Request $request){
        // dd($request);
        $action = $request->add_pemakluman_ops_rondaan;
        
        $rules = array(
            'mapor_srs_profile_id'                      => 'required',
            'mapor_ops_tarikh_mula_ronda'               => 'required',
            'mapor_ops_tarikh_surat'                    => 'required',
        );

        $messages = [
            'mapor_srs_profile_id.required'             => 'Ruangan Nama SRS mesti dipilih.',
            'mapor_ops_tarikh_mula_ronda.required'      => 'Ruangan Tarikh Mula Rondaan mesti dipilih.',
            'mapor_ops_tarikh_surat.required'           => 'Ruangan Tarikh Surat mesti dipilih.',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $carbon_obj     = Carbon::createFromFormat('d/m/Y', $request->mapor_ops_tarikh_mula_ronda)->format('Y-m-d');
                $carbon_obj_1   = Carbon::createFromFormat('d/m/Y', $request->mapor_ops_tarikh_surat)->format('Y-m-d');
                $ops_rondaan    = new SRS_Pemakluman_Ops_Rondaan;
                $ops_rondaan->krt_profile_id             = Auth::user()->krt_id;
                $ops_rondaan->srs_profile_id             = $request->mapor_srs_profile_id;
                $ops_rondaan->ops_tarikh_mula_ronda      = $carbon_obj;
                $ops_rondaan->ops_tarikh_surat           = $carbon_obj_1;
                $ops_rondaan->direkod_by                 = Auth::user()->user_id;
                $ops_rondaan->direkod_date               = date('Y-m-d H:i:s');
                $ops_rondaan->save();
            }
        }
    }

    function get_view_pemakluman_ops_rondaan_srs($id){
        $data = DB::table('srs__pemakluman_ops_rondaan')
                ->select('srs__pemakluman_ops_rondaan.id',
                        'srs__pemakluman_ops_rondaan.srs_profile_id AS srs_profile_id',
                        DB::raw(" DATE_FORMAT(srs__pemakluman_ops_rondaan.ops_tarikh_mula_ronda,'%d/%m/%Y') AS ops_tarikh_mula_ronda"),
                        DB::raw(" DATE_FORMAT(srs__pemakluman_ops_rondaan.ops_tarikh_surat,'%d/%m/%Y') AS ops_tarikh_surat"))
                ->where('srs__pemakluman_ops_rondaan.id', '=', $id)
                ->first();
        return Response::json($data);
    }

    function delete_pemakluman_ops_rondaan($id){
        $data = DB::table('srs__pemakluman_ops_rondaan')->where('id', '=', $id)->delete();
    }

    function paparan_pemakluman_ops_rondaan_p(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('srs__pemakluman_ops_rondaan')
                        ->select('srs__pemakluman_ops_rondaan.id',
                                'srs__pemakluman_ops_rondaan.krt_profile_id AS krt_profile_id',
                                'srs__pemakluman_ops_rondaan.srs_profile_id AS srs_profile_id',
                                'krt__profile.krt_nama AS nama_krt',
                                'srs__profile.srs_name AS nama_srs',
                                DB::raw(" DATE_FORMAT(srs__pemakluman_ops_rondaan.ops_tarikh_mula_ronda,'%d/%m/%Y') AS ops_tarikh_mula_ronda"),
                                DB::raw(" DATE_FORMAT(srs__pemakluman_ops_rondaan.ops_tarikh_surat,'%d/%m/%Y') AS ops_tarikh_surat"),
                                DB::raw(" DATE_FORMAT(srs__pemakluman_ops_rondaan.direkod_date,'%d/%m/%Y') AS direkod_date"),
                                'users__profile.user_fullname AS user_fullname')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__pemakluman_ops_rondaan.krt_profile_id')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__pemakluman_ops_rondaan.srs_profile_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','srs__pemakluman_ops_rondaan.direkod_by')
                        ->where('srs__pemakluman_ops_rondaan.srs_profile_id', '=', Auth::user()->srs_id)  
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
                                ->get();
            return view('rt-sm14.paparan-pemakluman-ops-rondaan-p',compact('roles_menu','srs_profile'));
        }
    }

    function surat_pemakluman_operasi_rondaan_p(Request $request, $id){
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
            $ops_rondaan   = DB::table('srs__pemakluman_ops_rondaan')
                                    ->select('srs__pemakluman_ops_rondaan.id',
                                            'srs__pemakluman_ops_rondaan.krt_profile_id AS krt_profile_id',
                                            'srs__pemakluman_ops_rondaan.srs_profile_id AS srs_profile_id',
                                            'ref__states.state_description AS state',
                                            'ref__daerahs.daerah_description AS daerah',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'srs__profile.srs_name AS nama_srs',
                                            DB::raw(" DATE_FORMAT(srs__pemakluman_ops_rondaan.ops_tarikh_mula_ronda,'%d/%m/%Y') AS ops_tarikh_mula_ronda"),
                                            DB::raw(" DATE_FORMAT(srs__pemakluman_ops_rondaan.ops_tarikh_surat,'%d/%m/%Y') AS ops_tarikh_surat"),
                                            DB::raw(" DATE_FORMAT(srs__pemakluman_ops_rondaan.direkod_date,'%d/%m/%Y') AS direkod_date"),
                                            'users__profile.user_fullname AS user_fullname')
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__pemakluman_ops_rondaan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('srs__profile','srs__profile.id','=','srs__pemakluman_ops_rondaan.srs_profile_id')
                                    ->leftJoin('users__profile','users__profile.user_id','=','srs__pemakluman_ops_rondaan.direkod_by')
                                    ->where('srs__pemakluman_ops_rondaan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm14.surat-pemakluman-operasi-rondaan-p', compact('roles_menu','ops_rondaan'));
        }
    }

    function paparan_pemakluman_ops_rondaan_ppd(Request $request){
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
            $data = DB::table('srs__pemakluman_ops_rondaan')
                        ->select('srs__pemakluman_ops_rondaan.id',
                                'srs__pemakluman_ops_rondaan.krt_profile_id AS krt_profile_id',
                                'srs__pemakluman_ops_rondaan.srs_profile_id AS srs_profile_id',
                                'krt__profile.krt_nama AS nama_krt',
                                'srs__profile.srs_name AS nama_srs',
                                DB::raw(" DATE_FORMAT(srs__pemakluman_ops_rondaan.ops_tarikh_mula_ronda,'%d/%m/%Y') AS ops_tarikh_mula_ronda"),
                                DB::raw(" DATE_FORMAT(srs__pemakluman_ops_rondaan.ops_tarikh_surat,'%d/%m/%Y') AS ops_tarikh_surat"),
                                DB::raw(" DATE_FORMAT(srs__pemakluman_ops_rondaan.direkod_date,'%d/%m/%Y') AS direkod_date"),
                                'users__profile.user_fullname AS user_fullname')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__pemakluman_ops_rondaan.krt_profile_id')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__pemakluman_ops_rondaan.srs_profile_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','srs__pemakluman_ops_rondaan.direkod_by')
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
            return view('rt-sm14.paparan-pemakluman-ops-rondaan-ppd',compact('roles_menu','krt_profile','srs_profile'));
        }
    }

    function surat_pemakluman_operasi_rondaan_ppd(Request $request, $id){
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
            $ops_rondaan   = DB::table('srs__pemakluman_ops_rondaan')
                                    ->select('srs__pemakluman_ops_rondaan.id',
                                            'srs__pemakluman_ops_rondaan.krt_profile_id AS krt_profile_id',
                                            'srs__pemakluman_ops_rondaan.srs_profile_id AS srs_profile_id',
                                            'ref__states.state_description AS state',
                                            'ref__daerahs.daerah_description AS daerah',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'srs__profile.srs_name AS nama_srs',
                                            DB::raw(" DATE_FORMAT(srs__pemakluman_ops_rondaan.ops_tarikh_mula_ronda,'%d/%m/%Y') AS ops_tarikh_mula_ronda"),
                                            DB::raw(" DATE_FORMAT(srs__pemakluman_ops_rondaan.ops_tarikh_surat,'%d/%m/%Y') AS ops_tarikh_surat"),
                                            DB::raw(" DATE_FORMAT(srs__pemakluman_ops_rondaan.direkod_date,'%d/%m/%Y') AS direkod_date"),
                                            'users__profile.user_fullname AS user_fullname')
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__pemakluman_ops_rondaan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('srs__profile','srs__profile.id','=','srs__pemakluman_ops_rondaan.srs_profile_id')
                                    ->leftJoin('users__profile','users__profile.user_id','=','srs__pemakluman_ops_rondaan.direkod_by')
                                    ->where('srs__pemakluman_ops_rondaan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm14.surat-pemakluman-operasi-rondaan-ppd', compact('roles_menu','ops_rondaan'));
        }
    }

    function paparan_pemakluman_ops_rondaan_ppn(Request $request){
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
            $data = DB::table('srs__pemakluman_ops_rondaan')
                        ->select('srs__pemakluman_ops_rondaan.id',
                                'srs__pemakluman_ops_rondaan.krt_profile_id AS krt_profile_id',
                                'srs__pemakluman_ops_rondaan.srs_profile_id AS srs_profile_id',
                                'ref__daerahs.daerah_description AS daerah',
                                'krt__profile.krt_nama AS nama_krt',
                                'srs__profile.srs_name AS nama_srs',
                                DB::raw(" DATE_FORMAT(srs__pemakluman_ops_rondaan.ops_tarikh_mula_ronda,'%d/%m/%Y') AS ops_tarikh_mula_ronda"),
                                DB::raw(" DATE_FORMAT(srs__pemakluman_ops_rondaan.ops_tarikh_surat,'%d/%m/%Y') AS ops_tarikh_surat"),
                                DB::raw(" DATE_FORMAT(srs__pemakluman_ops_rondaan.direkod_date,'%d/%m/%Y') AS direkod_date"),
                                'users__profile.user_fullname AS user_fullname')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__pemakluman_ops_rondaan.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__pemakluman_ops_rondaan.srs_profile_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','srs__pemakluman_ops_rondaan.direkod_by')
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
            return view('rt-sm14.paparan-pemakluman-ops-rondaan-ppn',compact('roles_menu','daerah','krt_profile','srs_profile'));
        }
    }

    function surat_pemakluman_operasi_rondaan_ppn(Request $request, $id){
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
            $ops_rondaan   = DB::table('srs__pemakluman_ops_rondaan')
                                    ->select('srs__pemakluman_ops_rondaan.id',
                                            'srs__pemakluman_ops_rondaan.krt_profile_id AS krt_profile_id',
                                            'srs__pemakluman_ops_rondaan.srs_profile_id AS srs_profile_id',
                                            'ref__states.state_description AS state',
                                            'ref__daerahs.daerah_description AS daerah',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'srs__profile.srs_name AS nama_srs',
                                            DB::raw(" DATE_FORMAT(srs__pemakluman_ops_rondaan.ops_tarikh_mula_ronda,'%d/%m/%Y') AS ops_tarikh_mula_ronda"),
                                            DB::raw(" DATE_FORMAT(srs__pemakluman_ops_rondaan.ops_tarikh_surat,'%d/%m/%Y') AS ops_tarikh_surat"),
                                            DB::raw(" DATE_FORMAT(srs__pemakluman_ops_rondaan.direkod_date,'%d/%m/%Y') AS direkod_date"),
                                            'users__profile.user_fullname AS user_fullname')
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__pemakluman_ops_rondaan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('srs__profile','srs__profile.id','=','srs__pemakluman_ops_rondaan.srs_profile_id')
                                    ->leftJoin('users__profile','users__profile.user_id','=','srs__pemakluman_ops_rondaan.direkod_by')
                                    ->where('srs__pemakluman_ops_rondaan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm14.surat-pemakluman-operasi-rondaan-ppn', compact('roles_menu','ops_rondaan'));
        }
    }

    function pemakluman_operasi_rondaan(){
        return view('rt-sm14.pemakluman-operasi-rondaan');
    }

     function surat_pemakluman_operasi_rondaan(){
        return view('rt-sm14.surat-pemakluman-operasi-rondaan');
    }

    function paparan_pemakluman_operasi_rondaan(){
        return view('rt-sm14.paparan-pemakluman-operasi-rondaan');
    }
}
