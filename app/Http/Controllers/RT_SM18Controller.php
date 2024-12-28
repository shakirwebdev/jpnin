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
use App\SRS_Permohonan_Penarikan_Diri;
use App\SRS_Ahli_Peronda;

use DataTables;
use DB;

class RT_SM18Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function permohonan_penarikan_diri_ahli_srs(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_ahli') {
                $value = $request->value;
                $where = array('srs_profile_id' => $value);
                $data  = SRS_Ahli_Peronda::where($where)
                        ->where('srs__ahli_peronda.peronda_status', '=',  true) 
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('srs__permohonan_penarikan_diri')
                        ->select('srs__permohonan_penarikan_diri.id AS id',
                                'srs__profile.srs_name AS nama_srs',
                                'srs__ahli_peronda.peronda_nama AS nama_peronda',
                                'srs__ahli_peronda.peronda_ic AS ic_peronda',
                                DB::raw(" DATE_FORMAT(srs__permohonan_penarikan_diri.direkod_date,'%d/%m/%Y') AS direkod_date"),
                                'users__profile.user_fullname AS direkod_oleh',
                                'srs__permohonan_penarikan_diri.penarikan_diri_status AS status',
                                'ref__status_srs_penarikan_diri.status_description AS status_description')
                        ->leftJoin('srs__ahli_peronda','srs__ahli_peronda.id','=','srs__permohonan_penarikan_diri.ahli_peronda_id')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__permohonan_penarikan_diri.srs_profile_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','srs__permohonan_penarikan_diri.direkod_by')
                        ->leftJoin('ref__status_srs_penarikan_diri','ref__status_srs_penarikan_diri.id','=','srs__permohonan_penarikan_diri.penarikan_diri_status')
                        ->where('srs__permohonan_penarikan_diri.krt_profile_id', '=', Auth::user()->krt_id)
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
            $ahli_peronda       = SRS_Ahli_Peronda::where('peronda_status', '=', true)
                                ->where('srs__ahli_peronda.krt_profile_id', '=', Auth::user()->krt_id)
                                ->get();
            return view('rt-sm18.permohonan-penarikan-diri-ahli-srs',compact('roles_menu','srs_profile','ahli_peronda'));
        }
    }

    function get_ahli_peronda($id){
        $data = DB::table('srs__ahli_peronda')
                ->select('srs__ahli_peronda.id',
                        'srs__ahli_peronda.peronda_ic AS peronda_ic',
                        'srs__ahli_peronda.peronda_alamat AS peronda_alamat')
                ->where('srs__ahli_peronda.id', '=', $id)
                ->first();
        return Response::json($data);
    }

    function add_penarikan_diri_srs(Request $request){
        // dd($request);
        $action = $request->add_penarikan_diri_srs;
        
        $rules = array(
            'mapds_srs_profile_id'                      => 'required',
            'mapds_ahli_peronda_id'                     => 'required',
            'mapds_alasan_id'                           => 'required',
        );

        $messages = [
            'mapds_srs_profile_id.required'             => 'Ruangan Nama SRS mesti dipilih.',
            'mapds_ahli_peronda_id.required'            => 'Ruangan Nama Ahli mesti dipilih.',
            'mapds_alasan_id.required'                  => 'Ruangan Alasan Ingin Menarik Diri mesti dipilih.',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $penarikan_diri                             = new SRS_Permohonan_Penarikan_Diri;
                $penarikan_diri->krt_profile_id             = Auth::user()->krt_id;
                $penarikan_diri->srs_profile_id             = $request->mapds_srs_profile_id;
                $penarikan_diri->ahli_peronda_id            = $request->mapds_ahli_peronda_id;
                $penarikan_diri->alasan_id                  = $request->mapds_alasan_id;
                $penarikan_diri->penarikan_diri_nyatakan    = $request->mapds_penarikan_diri_nyatakan;
                $penarikan_diri->penarikan_diri_status      = 2;
                $penarikan_diri->direkod_by                 = Auth::user()->user_id;
                $penarikan_diri->direkod_date               = date('Y-m-d H:i:s');
                $penarikan_diri->save();
            }
        }
    }

    function get_view_permohonan_penarikan_diri($id){
        $data = DB::table('srs__permohonan_penarikan_diri')
                ->select('srs__permohonan_penarikan_diri.id AS id',
                        'srs__permohonan_penarikan_diri.srs_profile_id AS srs_profile_id',
                        'srs__permohonan_penarikan_diri.ahli_peronda_id AS ahli_peronda_id',
                        'srs__ahli_peronda.peronda_ic AS peronda_ic',
                        'srs__ahli_peronda.peronda_alamat AS peronda_alamat',
                        'srs__permohonan_penarikan_diri.alasan_id AS alasan_id',
                        'srs__permohonan_penarikan_diri.penarikan_diri_nyatakan AS penarikan_diri_nyatakan')
                ->leftJoin('srs__ahli_peronda','srs__ahli_peronda.id','=','srs__permohonan_penarikan_diri.ahli_peronda_id')
                ->where('srs__permohonan_penarikan_diri.id', '=', $id)
                ->first();
        return Response::json($data);
    }

    function pengesahan_penarikan_diri_ahli_srs(Request $request){
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
            $data = DB::table('srs__permohonan_penarikan_diri')
                        ->select('srs__permohonan_penarikan_diri.id AS id',
                                'krt__profile.krt_nama AS nama_krt',
                                'srs__profile.srs_name AS nama_srs',
                                'srs__ahli_peronda.peronda_nama AS nama_peronda',
                                'srs__ahli_peronda.peronda_ic AS ic_peronda',
                                DB::raw(" DATE_FORMAT(srs__permohonan_penarikan_diri.direkod_date,'%d/%m/%Y') AS direkod_date"),
                                'users__profile.user_fullname AS direkod_oleh',
                                'srs__permohonan_penarikan_diri.penarikan_diri_status AS status',
                                'ref__status_srs_penarikan_diri.status_description AS status_description')
                        ->leftJoin('srs__ahli_peronda','srs__ahli_peronda.id','=','srs__permohonan_penarikan_diri.ahli_peronda_id')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__permohonan_penarikan_diri.krt_profile_id')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__permohonan_penarikan_diri.srs_profile_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','srs__permohonan_penarikan_diri.direkod_by')
                        ->leftJoin('ref__status_srs_penarikan_diri','ref__status_srs_penarikan_diri.id','=','srs__permohonan_penarikan_diri.penarikan_diri_status')
                        ->where('srs__permohonan_penarikan_diri.penarikan_diri_status', '=', 2)
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
                                 ->where('krt__profile.daerah_id', '=',   Auth::user()->daerah_id)
                                ->get();
            $srs_profile        = SRS_Profile::where('srs_status', '=', true)
                                ->get();
            $ahli_peronda       = SRS_Ahli_Peronda::where('peronda_status', '=', true)
                                ->get();
            return view('rt-sm18.pengesahan-penarikan-diri-ahli-srs',compact('roles_menu','krt_profile' ,'srs_profile', 'ahli_peronda'));
        }
    }

    function post_sahkan_penarikan_diri_srs(Request $request){
        $action = $request->post_sahkan_penarikan_diri_srs;
        $app_id = $request->mspds_penarikan_diri_id;
        $ahli_id = $request->mspds_ahli_peronda_srs_id;
        $status = $request->mspds_penarikan_diri_status;
        
        $rules = array(
            'mspds_penarikan_diri_status'              => 'required',
            
        );

        $messages = [
            'mspds_penarikan_diri_status.required'     => 'Ruangan Status mesti dipilih',
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $pengesahan_penarikan_diri                                 = SRS_Permohonan_Penarikan_Diri::where($where)->first();
                $pengesahan_penarikan_diri->penarikan_diri_status          = $request->mspds_penarikan_diri_status;
                $pengesahan_penarikan_diri->disemak_by                     = Auth::user()->user_id;
                $pengesahan_penarikan_diri->disemak_date                   = date('Y-m-d H:i:s');
                $pengesahan_penarikan_diri->save();
                if($status == '1'){
                    $where1 = array('id' => $ahli_id);
                    $ahli_peronda                                               = SRS_Ahli_Peronda::where($where1)->first();
                    $ahli_peronda->peronda_status                               = 2;
                    $ahli_peronda->save();
                }
                
            }
        }
    }

    function permohonan_penarikan_diri_srs(){
        return view('rt-sm18.permohonan-penarikan-diri-srs');
    }

    function pengesahan_penarikan_diri_srs(){
        return view('rt-sm18.pengesahan-penarikan-diri-srs');
    }

    function kemaskini_aktif_maklumat_peronda(){
        return view('rt-sm18.kemaskini-aktif-maklumat-peronda');
    }
}
