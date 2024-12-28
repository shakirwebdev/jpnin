<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect, Response;
use Auth;
use Validator;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\RefStates;
use App\RefDaerah;
use App\RefParlimen;
use App\RefDUN;
use App\RefJantina;
use App\User;
use App\UserProfile;
use App\KRT_Profile;
use App\SRS_Profile;
use App\SRS_Peronda;
use App\SRS_Peronda_Sukarela;
use App\KRT_Minit_Mesyuarat_RT;
use App\SRS_Profile_Meeting;
use App\Srs_Profile_Upload_Peta;

use DataTables;
use DB;

class RT_SM12Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function list_senarai_srs(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('srs__profile')
                        ->select('srs__profile.id',
                                'srs__profile.krt_id',
                                'srs__profile.srs_name',
                                'srs__profile.srs_peronda_total',
                                'krt__profile.krt_nama AS krt_name',
                                'krt__profile.state_id AS krt_state_id',
                                'krt__profile.daerah_id AS krt_daerah_id',
                                'ref__status_srs.status_description',
                                'srs__profile.dihantar_date',
                                'srs__profile.srs_status')
                        ->join('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->join('ref__status_srs','ref__status_srs.id','=','srs__profile.srs_status')
                        ->where('srs__profile.dihantar_by', '=', Auth::user()->user_id)  
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
            $user_profile   = DB::table('users__profile')
                            ->select('users__profile.id',
                                        'users__profile.user_id',
                                        'users__profile.user_fullname AS pemohon_name',
                                        'users__profile.no_ic AS pemohon_ic',
                                        'users__profile.no_phone AS pemohon_phone',
                                        'users__profile.krt_id',
                                        'krt__profile.krt_nama AS krt_name',
                                        'krt__profile.krt_alamat AS krt_address', 
                                        'ref__states.state_description AS krt_state', 
                                        'ref__daerahs.daerah_description AS krt_daerah')
                            ->leftJoin('krt__profile','krt__profile.id','=','users__profile.krt_id')
                            ->join('ref__states','ref__states.state_id','=','krt__profile.state_id')
                            ->join('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                            ->where('users__profile.user_id', '=', Auth::user()->user_id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm12.senarai-srs', compact('roles_menu','user_profile'));
        }
    }

    function create_permohonan_penubuhan_srs(Request $request){
        
        $action = $request->create_permohonan_srs;
        $app_id = $request->krt_id;
        
        $rules = array(
           
        );

        $messages = [
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm12.senarai_srs',$app_id))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'add') {
                $srs_profile = new SRS_Profile;
                $srs_profile->krt_id               = Auth::user()->krt_id;
                $srs_profile->dihantar_by          = Auth::user()->user_id;
                $srs_profile->srs_status           = 3;
                $srs_profile->save();
            }
           
            return Redirect::to(route('rt-sm12.permohonan_penubuhan_srs',$srs_profile->id));
        }

    }

    function permohonan_penubuhan_srs(Request $request, $id){
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
            $srs_profile   = DB::table('srs__profile')
                            ->select('srs__profile.id',
                                'krt__profile.krt_nama AS nama_krt',
                                'krt__profile.krt_alamat AS alamat_krt',
                                'ref__states.state_description AS negeri_krt',
                                'ref__parlimens.parlimen_description AS parlimen_krt',
                                'ref__pbts.pbt_description AS pbt_krt',
                                'ref__daerahs.daerah_description AS daerah_krt', 
                                'ref__duns.dun_description AS dun_krt',
                                'srs__profile.srs_name AS srs_name',
                                'srs__profile.srs_peronda_total AS srs_peronda_total',
                                'srs__profile.srs_kawalan AS srs_kawalan',
                                'srs__profile.srs_status AS srs_status',
                                'ref__status_srs.status_description AS status_description',
                                'srs__profile.disemak_note AS disemak_note',
                                'srs__profile.disahkan_note AS disahkan_note',
                                'srs__profile.diakui_note AS diakui_note',
                                'srs__profile.diluluskan_note AS diluluskan_note')
                            ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                            ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                            ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                            ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                            ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                            ->leftJoin('users__profile','users__profile.user_id','=','krt__profile.pbt_id')
                            ->leftJoin('ref__status_srs','ref__status_srs.id','=','srs__profile.srs_status')
                            ->where('srs__profile.id', '=', $id)  
                            ->limit(1)
                            ->first();
            $user_profile   = DB::table('users__profile')
                            ->select('users__profile.id',
                                'users__profile.user_fullname AS pemohon_name',
                                'users__profile.no_ic AS pemohon_ic',
                                'users__profile.user_address AS pemohon_address')
                            ->where('users__profile.user_id', '=', Auth::user()->user_id) 
                            ->limit(1)
                            ->first();
            return view('rt-sm12.permohonan-penubuhan-srs', compact('roles_menu','srs_profile','user_profile'));
        }
    }

    function senarai_peronda_table(Request $request, $id){
        $data = DB::table('srs__senarai_peronda')
                    ->select('srs__senarai_peronda.*')
                    ->where('srs__senarai_peronda.srs_profile_id', '=', $id)
                    ->get();
                return Datatables::of($data)
                        ->make(true);
    }

    function add_peronda(Request $request){
        $action = $request->add_peronda;
        $app_id = $request->pps2_srs_profile_id;
        
        $rules = array(
            'pps2_peronda_nama'                 => 'required',
            'pps2_peronda_kad'                  => 'required|numeric'
        );

        $messages = [
            'pps2_peronda_nama.required'        => 'Ruangan nama ahli mesti dipilih',
            'pps2_peronda_kad.required'         => 'Ruangan no kad mesti diisi',
            'pps2_peronda_kad.numeric'          => 'Ruangan no kad mesti diisi number sahaja',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $peronda = new SRS_Peronda;
                $peronda->srs_profile_id     = $request->pps2_srs_profile_id;
                $peronda->peronda_nama      = $request->pps2_peronda_nama;
                $peronda->peronda_kad       = $request->pps2_peronda_kad;
                $peronda->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_peronda($id){
        $data = DB::table('srs__senarai_peronda')->where('id', '=', $id)->delete();
    }

    function update_kemaskini_srs_profile(Request $request){
        $action = $request->update_kemaskini_srs_profile;
        $app_id = $request->pps1_srs_id;
        
        
        $rules = array(
            'pps1_srs_name'                     => 'required',
            'pps1_srs_peronda_total'            => 'required',
            'pps1_srs_kawalan'                  => 'required'
        );

        $messages = [
            'pps1_srs_name.required'            => 'Ruangan Cadangan Nama SRS mesti diisi',
            'pps1_srs_peronda_total.required'   => 'Ruangan Jumlah Peronda mesti diisi',
            'pps1_srs_kawalan.required'         => 'Ruangan rondaan dan kawalan SRS mesti dipilih',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $srs_profile                      = SRS_Profile::where($where)->first();
                $srs_profile->srs_name            = $request->pps1_srs_name;
                $srs_profile->srs_peronda_total   = $request->pps1_srs_peronda_total;
                $srs_profile->srs_kawalan         = $request->pps1_srs_kawalan;
                $srs_profile->save();
            }
        }
    }

    function permohonan_penubuhan_srs_1(Request $request, $id){
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
            $jantina            = RefJantina::where('status', '=', true)->get();
            $srs_profile        = DB::table('srs__profile')
                                ->select('srs__profile.id',
                                    'krt__profile.krt_nama AS nama_krt',
                                    'krt__profile.krt_alamat AS alamat_krt',
                                    'ref__states.state_description AS negeri_krt',
                                    'ref__parlimens.parlimen_description AS parlimen_krt',
                                    'ref__pbts.pbt_description AS pbt_krt',
                                    'ref__daerahs.daerah_description AS daerah_krt', 
                                    'ref__duns.dun_description AS dun_krt',
                                    'srs__profile.srs_name AS srs_name',
                                    'srs__profile.srs_peronda_total AS srs_peronda_total',
                                    'srs__profile.srs_kawalan AS srs_kawalan',
                                    'srs__profile.srs_status AS srs_status',
                                    'ref__status_srs.status_description AS status_description',
                                    'srs__profile.disemak_note AS disemak_note',
                                    'srs__profile.disahkan_note AS disahkan_note',
                                    'srs__profile.diakui_note AS diakui_note',
                                    'srs__profile.diluluskan_note AS diluluskan_note')
                                ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                                ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                ->leftJoin('users__profile','users__profile.user_id','=','krt__profile.pbt_id')
                                ->leftJoin('ref__status_srs','ref__status_srs.id','=','srs__profile.srs_status')
                                ->where('srs__profile.id', '=', $id)  
                                ->limit(1)
                                ->first();
            $user_profile       = DB::table('users__profile')
                                ->select('users__profile.id',
                                    'users__profile.user_fullname AS pemohon_name',
                                    'users__profile.no_ic AS pemohon_ic',
                                    'users__profile.user_address AS pemohon_address')
                                ->where('users__profile.user_id', '=', Auth::user()->user_id) 
                                ->limit(1)
                                ->first();
            return view('rt-sm12.permohonan-penubuhan-srs-1', compact('roles_menu','jantina','user_profile', 'srs_profile'));
        }
    }

    function senarai_peronda_sukarela_table(Request $request, $id){
        $data = DB::table('srs__senarai_peronda_sukarela')
                    ->select('srs__senarai_peronda_sukarela.*',
                            'ref__jantina.jantina_description')
                    ->join('ref__jantina','ref__jantina.id','=','srs__senarai_peronda_sukarela.jantina_id')
                    ->where('srs__senarai_peronda_sukarela.srs_profile_id', '=', $id)
                    ->get();
                return Datatables::of($data)
                        ->make(true);
    }

    function add_peronda_sukarela(Request $request){
        $action = $request->add_peronda_sukarela;
        $app_id = $request->pps1_1_srs_profileID;
        
        $rules = array(
            'pps5_p_sukarela_nama'                 => 'required',
            'pps5_p_sukarela_kad'                  => 'required|numeric',
            'pps5_jantina_id'                      => 'required',
            'pps5_p_sukarela_pekerjaan'            => 'required',
            'pps5_p_sukarela_alamat_k'             => 'required'
        );

        $messages = [
            'pps5_p_sukarela_nama.required'        => 'Ruangan nama ahli mesti dipilih',
            'pps5_p_sukarela_kad.required'         => 'Ruangan no kad pengenalan mesti diisi',
            'pps5_p_sukarela_kad.numeric'          => 'Ruangan no kad pengenalan mesti diisi number sahaja',
            'pps5_jantina_id.required'             => 'Ruangan jantina mesti dipilih',
            'pps5_p_sukarela_pekerjaan.required'   => 'Ruangan pekerjaan mesti dipilih',
            'pps5_p_sukarela_alamat_k.required'      => 'Ruangan alamat kediaman mesti dipilih',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $peronda_sukarela = new SRS_Peronda_Sukarela;
                $peronda_sukarela->srs_profile_id       = $request->pps5_srs_profile_id;
                $peronda_sukarela->p_sukarela_nama      = $request->pps5_p_sukarela_nama;
                $peronda_sukarela->p_sukarela_kad       = $request->pps5_p_sukarela_kad;
                $peronda_sukarela->jantina_id           = $request->pps5_jantina_id;
                $peronda_sukarela->p_sukarela_pekerjaan = $request->pps5_p_sukarela_pekerjaan;
                $peronda_sukarela->p_sukarela_alamat_k  = $request->pps5_p_sukarela_alamat_k;
                $peronda_sukarela->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_peronda_sukarela($id){
        $data = DB::table('srs__senarai_peronda_sukarela')->where('id', '=', $id)->delete();
    }

    function permohonan_penubuhan_srs_2(Request $request, $id){
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
            $minit_mesyuarat    = KRT_Minit_Mesyuarat_RT::where('mesyuarat_status', '=', true)
                                ->where('krt__minit_mesyuarat.krt_profile_id', '=', Auth::user()->krt_id)  
                                ->get();
            $srs_profile        = DB::table('srs__profile')
                                ->select('srs__profile.id',
                                    'krt__profile.krt_nama AS nama_krt',
                                    'krt__profile.krt_alamat AS alamat_krt',
                                    'ref__states.state_description AS negeri_krt',
                                    'ref__parlimens.parlimen_description AS parlimen_krt',
                                    'ref__pbts.pbt_description AS pbt_krt',
                                    'ref__daerahs.daerah_description AS daerah_krt', 
                                    'ref__duns.dun_description AS dun_krt',
                                    'srs__profile.srs_name AS srs_name',
                                    'srs__profile.srs_peronda_total AS srs_peronda_total',
                                    'srs__profile.srs_kawalan AS srs_kawalan',
                                    'srs__profile.srs_status AS srs_status',
                                    'ref__status_srs.status_description AS status_description',
                                    'srs__profile.disemak_note AS disemak_note',
                                    'srs__profile.disahkan_note AS disahkan_note',
                                    'srs__profile.diakui_note AS diakui_note',
                                    'srs__profile.diluluskan_note AS diluluskan_note')
                                ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                                ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                ->leftJoin('users__profile','users__profile.user_id','=','krt__profile.pbt_id')
                                ->leftJoin('ref__status_srs','ref__status_srs.id','=','srs__profile.srs_status')
                                ->where('srs__profile.id', '=', $id)  
                                ->limit(1)
                                ->first();
            $user_profile       = DB::table('users__profile')
                                ->select('users__profile.id',
                                    'users__profile.user_fullname AS pemohon_name',
                                    'users__profile.no_ic AS pemohon_ic',
                                    'users__profile.user_address AS pemohon_address')
                                ->where('users__profile.user_id', '=', Auth::user()->user_id) 
                                ->limit(1)
                                ->first();
            return view('rt-sm12.permohonan-penubuhan-srs-2', compact('roles_menu','minit_mesyuarat','user_profile', 'srs_profile'));
        }
    }

    function get_senarai_minit_meeting_table(Request $request, $id){
        $data = DB::table('srs__profile_meeting')
                    ->select('srs__profile_meeting.*',
                    'krt__minit_mesyuarat.mesyuarat_title AS mesyuarat_title')
                    ->leftjoin('krt__minit_mesyuarat','krt__minit_mesyuarat.id','=','srs__profile_meeting.minit_mesyuarat_id')
                    ->where('srs__profile_meeting.srs_profile_id', '=', $id)
                    ->get();
                return Datatables::of($data)
                        ->make(true);
    }

    function post_minit_meeting(Request $request){
        $action = $request->add_minit_meeting;
        $app_id = $request->pps7_srs_profile_id;
        
        $rules = array(
            'pps7_minit_mesyuarat_id'              => 'required',
            'pps7_keterangan'                      => 'required'
        );

        $messages = [
            'pps7_minit_mesyuarat_id.required'     => 'Ruangan tajuk mesyuarat mesti dipilih',
            'pps7_keterangan.required'             => 'Ruangan keterangan mesti diisi'
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $minit_meeting = new SRS_Profile_Meeting;
                $minit_meeting->srs_profile_id          = $request->pps7_srs_profile_id;
                $minit_meeting->minit_mesyuarat_id      = $request->pps7_minit_mesyuarat_id;
                $minit_meeting->keterangan              = $request->pps7_keterangan;
                $minit_meeting->save();
            }
            return \Response::json(array('success' => '1'));
        }

    }

    function delete_senarai_minit_meeting($id){
        $data = DB::table('srs__profile_meeting')->where('id', '=', $id)->delete();
    }

    function hantar_permohonan_pertubuhan_srs(Request $request){
        
        $action = $request->hantar_permohonan_pertubuhan_srs;
        $app_id = $request->srs_profile_id;
        
        $rules = array(
            
        );

        $messages = [
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm12.permohonan_penubuhan_srs_2',$app_id))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $srs_profile                         = SRS_Profile::where($where)->first();
                $srs_profile->srs_status             = 4;
                $srs_profile->dihantar_by            = Auth::user()->user_id;
                $srs_profile->dihantar_date          = date('Y-m-d H:i:s');
                $srs_profile->save();
                
            }
           
            return Redirect::to(route('rt-sm12.senarai_srs'));
        }

    }

    function profile_srs_p_1(Request $request, $id){
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
            $profile_srs    = DB::table('srs__profile')
                                    ->select('srs__profile.id',
                                            'krt__profile.state_id',
                                            'ref__states.state_description AS negeri_krt',
                                            'krt__profile.daerah_id',
                                            'ref__daerahs.daerah_description AS daerah_krt',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__duns.dun_description AS dun_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'users__profile.user_fullname AS nama_pemohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.user_address AS address_pemohon',
                                            'srs__profile.dihantar_date AS tarikh_srs_dimohon',
                                            'srs__profile.srs_name AS nama_srs',
                                            'srs__profile.srs_peronda_total AS jumlah_peronda',
                                            'srs__profile.srs_kawalan AS srs_kawalan',
                                            'srs__profile.srs_status AS srs_status',
                                            'ref__status_srs.status_description AS status_description',
                                            'srs__profile.disemak_note AS disemak_note',
                                            'srs__profile.disahkan_note AS disahkan_note',
                                            'srs__profile.diakui_note AS diakui_note',
                                            'srs__profile.diluluskan_note AS diluluskan_note')
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('users__profile','users__profile.user_id','=','srs__profile.dihantar_by')
                                    ->leftJoin('ref__status_srs','ref__status_srs.id','=','srs__profile.srs_status')
                                    ->where('srs__profile.id', '=', $id)
                                    ->limit(1)
                                    ->first();
            return view('rt-sm12.profile-srs-p-1', compact('roles_menu','profile_srs'));
        }
    }

    function profile_srs_p_2(Request $request, $id){
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
            $profile_srs    = DB::table('srs__profile')
                                        ->select('srs__profile.id',
                                                'krt__profile.state_id',
                                                'ref__states.state_description AS negeri_krt',
                                                'krt__profile.daerah_id',
                                                'ref__daerahs.daerah_description AS daerah_krt',
                                                'krt__profile.krt_nama AS nama_krt',
                                                'krt__profile.krt_alamat AS alamat_krt',
                                                'ref__parlimens.parlimen_description AS parlimen_krt',
                                                'ref__duns.dun_description AS dun_krt',
                                                'ref__pbts.pbt_description AS pbt_krt',
                                                'users__profile.user_fullname AS nama_pemohon',
                                                'users__profile.no_ic AS ic_pemohon',
                                                'users__profile.user_address AS address_pemohon',
                                                'srs__profile.dihantar_date AS tarikh_srs_dimohon',
                                                'srs__profile.srs_status AS srs_status',
                                                'srs__profile.srs_name AS nama_srs',
                                                'srs__profile.srs_peronda_total AS jumlah_peronda',
                                                'srs__profile.srs_kawalan AS srs_kawalan',
                                                'ref__status_srs.status_description AS status_description',
                                                'srs__profile.diakui_note AS diakui_note')
                                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                        ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                        ->leftJoin('users__profile','users__profile.user_id','=','srs__profile.dihantar_by')
                                        ->leftJoin('ref__status_srs','ref__status_srs.id','=','srs__profile.srs_status')
                                        ->where('srs__profile.id', '=', $id)
                                        ->limit(1)
                                        ->first();
            return view('rt-sm12.profile-srs-p-2', compact('roles_menu','profile_srs'));
        }
    }

    function semak_permohonan_penubuhan_srs(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('srs__profile')
                        ->select('srs__profile.id',
                                'srs__profile.krt_id',
                                'srs__profile.srs_name',
                                'srs__profile.srs_peronda_total',
                                'krt__profile.krt_nama AS krt_name',
                                'krt__profile.state_id AS krt_state_id',
                                'krt__profile.daerah_id AS krt_daerah_id',
                                'ref__status_srs.status_description',
                                'srs__profile.dihantar_date')
                        ->join('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->join('ref__status_srs','ref__status_srs.id','=','srs__profile.srs_status')
                        ->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)  
                        ->whereIn('srs__profile.srs_status', [4,8]) 
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
            $krt_profile    = KRT_Profile::where('krt_status', '=', 1)
                            ->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)
                            ->where('krt__profile.krt_status', '=',  true) 
                            ->get();
            return view('rt-sm12.semak-permohonan-penubuhan-srs', compact('roles_menu','krt_profile'));
        }
    }

    function semak_permohonan_penubuhan_srs_ppd(Request $request, $id){
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
            $surat_penubuhan_srs    = SRS_Profile::whereIn('srs_status', [4,8])
                                    ->select('srs__profile.id','krt__profile.daerah_id',
                                            'ref__daerahs.daerah_description AS daerah',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'users__profile.user_fullname AS nama_pengerusi',
                                            DB::raw(" DATE_FORMAT(srs__profile.dihantar_date,'%d/%m/%Y') AS tarikh_srs_dimohon"),
                                            'srs__profile.srs_status AS srs_status',
                                            'ref__status_srs.status_description AS status_description',
                                            'srs__profile.disemak_note AS disemak_note',
                                            'srs__profile.disahkan_note AS disahkan_note',
                                            'srs__profile.diakui_note AS diakui_note',
                                            'srs__profile.diluluskan_note AS diluluskan_note')
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('users__profile','users__profile.user_id','=','srs__profile.dihantar_by')
                                    ->leftJoin('ref__status_srs','ref__status_srs.id','=','srs__profile.srs_status')
                                    ->where('srs__profile.id', '=', $id)
                                    ->limit(1)
                                    ->first();
            return view('rt-sm12.semak-permohonan-penubuhan-srs-ppd', compact('roles_menu','surat_penubuhan_srs'));
        }
    }

    function semak_permohonan_penubuhan_srs_ppd_1(Request $request, $id){
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
            $surat_penubuhan_srs    = SRS_Profile::whereIn('srs_status', [4,8])
                                    ->select('srs__profile.id',
                                            'krt__profile.state_id',
                                            'ref__states.state_description AS negeri_krt',
                                            'krt__profile.daerah_id',
                                            'ref__daerahs.daerah_description AS daerah_krt',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__duns.dun_description AS dun_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'users__profile.user_fullname AS nama_pemohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.user_address AS address_pemohon',
                                            'srs__profile.dihantar_date AS tarikh_srs_dimohon',
                                            'srs__profile.srs_name AS nama_srs',
                                            'srs__profile.srs_peronda_total AS jumlah_peronda',
                                            'srs__profile.srs_kawalan AS srs_kawalan',
                                            'srs__profile.srs_status AS srs_status',
                                            'ref__status_srs.status_description AS status_description',
                                            'srs__profile.disemak_note AS disemak_note',
                                            'srs__profile.disahkan_note AS disahkan_note',
                                            'srs__profile.diakui_note AS diakui_note',
                                            'srs__profile.diluluskan_note AS diluluskan_note')
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('users__profile','users__profile.user_id','=','srs__profile.dihantar_by')
                                    ->leftJoin('ref__status_srs','ref__status_srs.id','=','srs__profile.srs_status')
                                    ->where('srs__profile.id', '=', $id)
                                    ->limit(1)
                                    ->first();
            return view('rt-sm12.semak-permohonan-penubuhan-srs-ppd-1', compact('roles_menu','surat_penubuhan_srs'));
        }
    }

    function semak_permohonan_penubuhan_srs_ppd_2(Request $request, $id){
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
            $surat_penubuhan_srs    = SRS_Profile::whereIn('srs_status', [4,8])
                                    ->select('srs__profile.id',
                                            'krt__profile.state_id',
                                            'ref__states.state_description AS negeri_krt',
                                            'krt__profile.daerah_id',
                                            'ref__daerahs.daerah_description AS daerah_krt',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__duns.dun_description AS dun_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'users__profile.user_fullname AS nama_pemohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.user_address AS address_pemohon',
                                            'srs__profile.dihantar_date AS tarikh_srs_dimohon',
                                            'srs__profile.srs_name AS nama_srs',
                                            'srs__profile.srs_peronda_total AS jumlah_peronda',
                                            'srs__profile.srs_kawalan AS srs_kawalan',
                                            'srs__profile.srs_status AS srs_status',
                                            'ref__status_srs.status_description AS status_description',
                                            'srs__profile.disemak_note AS disemak_note',
                                            'srs__profile.disahkan_note AS disahkan_note',
                                            'srs__profile.diakui_note AS diakui_note',
                                            'srs__profile.diluluskan_note AS diluluskan_note')
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('users__profile','users__profile.user_id','=','srs__profile.dihantar_by')
                                    ->leftJoin('ref__status_srs','ref__status_srs.id','=','srs__profile.srs_status')
                                    ->where('srs__profile.id', '=', $id)
                                    ->limit(1)
                                    ->first();
            return view('rt-sm12.semak-permohonan-penubuhan-srs-ppd-2', compact('roles_menu','surat_penubuhan_srs'));
        }
    }

    function get_profile_srs_peta_kawasan_table(Request $request, $id){
        $data = DB::table('srs__profile_upload_peta')
                ->select('srs__profile_upload_peta.*')
                ->where('srs__profile_upload_peta.srs_profile_id', '=', $id)
                ->get();
        return Datatables::of($data)
                ->make(true);
    }

    function add_profile_srs_peta_kawasan(Request $request){
        $action = $request->add_profile_srs_peta_kawasan;
        $app_id = $request->sppsppd2_srs_profile_id;
        
        $rules = array(
            'sppsppd2_file_title'               => 'required',
            'sppsppd2_file_catatan'             => 'required',
            'sppsppd2_file_peta'                => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:5000'
        );

        $messages = [
            'sppsppd2_file_title.required'     => 'Ruangan Tajuk Fail Mesti Diisi',
            'sppsppd2_file_catatan.required'   => 'Ruangan Catatan Fail Mesti Diisi',
            'sppsppd2_file_peta.required'      => 'Ruangan Fail Mesti Dipilih',
            'sppsppd2_file_peta.mimes'         => 'Fail Mesti Dipilih Dalam Format jpeg,png,jpg,gif,svg,pdf',
            'sppsppd2_file_peta.max'           => 'Fail mesti dalam sive 5000KB',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            $fileName = $request->sppsppd2_file_peta->getClientOriginalName();
            $request->sppsppd2_file_peta->storeAs('public/srs_peta_kawasan',$fileName);
            if ($action == 'add') {
                $peta_kawasan = new Srs_Profile_Upload_Peta;
                $peta_kawasan->srs_profile_id   = $app_id;
                $peta_kawasan->file_title       = $request->sppsppd2_file_title;
                $peta_kawasan->file_catatan     = $request->sppsppd2_file_catatan;
                $peta_kawasan->file_peta        = $fileName;
                $peta_kawasan->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function get_data_srs_peta_kawasan($id){
        $data = DB::table('srs__profile_upload_peta')
                ->select('srs__profile_upload_peta.id', 
                    'srs__profile_upload_peta.file_peta AS file_peta' )
                ->where('srs__profile_upload_peta.id', '=', $id)
                ->first();
        return Response::json($data);
    }

    function delete_profile_srs_peta_kawasan($id){
        $data = DB::table('srs__profile_upload_peta')->where('id', '=', $id)->delete();
    }
    
    function post_semak_permohonan_penubuhan_srs(Request $request){
        $action = $request->post_semak_permohonan_penubuhan_srs;
        $app_id = $request->sppsp_2_srs_id;
        
        
        $rules = array(
            'sppsp_2_srs_status'                => 'required',
            'sppsp_2_disemak_note'              => 'required',
        );

        $messages = [
            'sppsp_2_srs_status.required'       => 'Ruangan Status dipilih',
            'sppsp_2_disemak_note.required'     => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $semak_permohonan_srs                       = SRS_Profile::where($where)->first();
                $semak_permohonan_srs->srs_status           = $request->sppsp_2_srs_status;
                $semak_permohonan_srs->disemak_by           = Auth::user()->user_id;
                $semak_permohonan_srs->disemak_date         = date('Y-m-d H:i:s');
                $semak_permohonan_srs->disemak_note         = $request->sppsp_2_disemak_note;
                $semak_permohonan_srs->save();
            }
        }
    }

    function jana_surat_terima_permohonan_srs(){
        return view('rt-sm12.jana-surat-terima-permohonan-srs');
    }

    function surat_terima_penubuhan_srs_ppd(){
        return view('rt-sm12.surat-terima-penubuhan-srs-ppd');
    }

    function surat_terima_penubuhan_srs_ppd_1(){
        return view('rt-sm12.surat-terima-penubuhan-srs-ppd-1');
    }

    function surat_terima_penubuhan_srs_ppd_2(){
        return view('rt-sm12.surat-terima-penubuhan-srs-ppd-2');
    }


    function pengesahan_permohonan_penubuhan_srs(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = KRT_Profile::where($where)
                        ->where('krt__profile.krt_status', '=',  true) 
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('srs__profile')
                        ->select('srs__profile.id',
                                'srs__profile.krt_id',
                                'srs__profile.srs_name',
                                'srs__profile.srs_peronda_total',
                                'krt__profile.krt_nama AS krt_name',
                                'krt__profile.state_id AS krt_state_id',
                                'krt__profile.daerah_id AS krt_daerah_id',
                                'ref__status_srs.status_description',
                                'srs__profile.dihantar_date')
                        ->join('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->join('ref__status_srs','ref__status_srs.id','=','srs__profile.srs_status')
                        ->where('krt__profile.state_id', '=', Auth::user()->state_id)
                        ->whereIN('srs__profile.srs_status', [5,10]) 
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
            $daerah    = RefDaerah::where('status', '=', true)
                        ->where('ref__daerahs.state_id', '=', Auth::user()->state_id)
                        ->get();
            $krt       = KRT_Profile::where('krt_status', '=', 1)->get();
            return view('rt-sm12.pengesahan-permohonan-penubuhan-srs', compact('roles_menu','daerah', 'krt'));
        }
    }

    function pengesahan_permohonan_penubuhan_srs_ppn(Request $request, $id){
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
            $surat_penubuhan_srs    = SRS_Profile::whereIN('srs_status', [5,10])
                                    ->select('srs__profile.id','krt__profile.daerah_id',
                                            'ref__daerahs.daerah_description AS daerah',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'users__profile.user_fullname AS nama_pengerusi',
                                            DB::raw(" DATE_FORMAT(srs__profile.dihantar_date,'%d/%m/%Y') AS tarikh_srs_dimohon"),
                                            'srs__profile.srs_status AS srs_status')
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('users__profile','users__profile.user_id','=','srs__profile.dihantar_by')
                                    ->leftJoin('ref__status_srs','ref__status_srs.id','=','srs__profile.srs_status')
                                    ->where('srs__profile.id', '=', $id)
                                    ->limit(1)
                                    ->first();
            return view('rt-sm12.pengesahan-permohonan-penubuhan-srs-ppn', compact('roles_menu','surat_penubuhan_srs'));
        }
    }

    function pengesahan_permohonan_penubuhan_srs_ppn_1(Request $request, $id){
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
            $pengesahan_penubuhan_srs   = SRS_Profile::whereIN('srs_status', [5,10])
                                        ->select('srs__profile.id',
                                                'krt__profile.state_id',
                                                'ref__states.state_description AS negeri_krt',
                                                'krt__profile.daerah_id',
                                                'ref__daerahs.daerah_description AS daerah_krt',
                                                'krt__profile.krt_nama AS nama_krt',
                                                'krt__profile.krt_alamat AS alamat_krt',
                                                'ref__parlimens.parlimen_description AS parlimen_krt',
                                                'ref__duns.dun_description AS dun_krt',
                                                'ref__pbts.pbt_description AS pbt_krt',
                                                'users__profile.user_fullname AS nama_pemohon',
                                                'users__profile.no_ic AS ic_pemohon',
                                                'users__profile.user_address AS address_pemohon',
                                                'srs__profile.dihantar_date AS tarikh_srs_dimohon',
                                                'srs__profile.srs_status AS srs_status',
                                                'srs__profile.srs_name AS nama_srs',
                                                'srs__profile.srs_peronda_total AS jumlah_peronda',
                                                'srs__profile.srs_kawalan AS srs_kawalan',
                                                'ref__status_srs.status_description AS status_description',
                                                'srs__profile.diakui_note AS diakui_note')
                                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                        ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                        ->leftJoin('users__profile','users__profile.user_id','=','srs__profile.dihantar_by')
                                        ->leftJoin('ref__status_srs','ref__status_srs.id','=','srs__profile.srs_status')
                                        ->where('srs__profile.id', '=', $id)
                                        ->limit(1)
                                        ->first();
            return view('rt-sm12.pengesahan-permohonan-penubuhan-srs-ppn-1', compact('roles_menu','pengesahan_penubuhan_srs'));
        }
    }

    function pengesahan_permohonan_penubuhan_srs_ppn_2(Request $request, $id){
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
            $pengesahan_penubuhan_srs    = SRS_Profile::whereIN('srs_status', [5,10])
                                        ->select('srs__profile.id',
                                                'krt__profile.state_id',
                                                'ref__states.state_description AS negeri_krt',
                                                'krt__profile.daerah_id',
                                                'ref__daerahs.daerah_description AS daerah_krt',
                                                'krt__profile.krt_nama AS nama_krt',
                                                'krt__profile.krt_alamat AS alamat_krt',
                                                'ref__parlimens.parlimen_description AS parlimen_krt',
                                                'ref__duns.dun_description AS dun_krt',
                                                'ref__pbts.pbt_description AS pbt_krt',
                                                'users__profile.user_fullname AS nama_pemohon',
                                                'users__profile.no_ic AS ic_pemohon',
                                                'users__profile.user_address AS address_pemohon',
                                                'srs__profile.dihantar_date AS tarikh_srs_dimohon',
                                                'srs__profile.srs_status AS srs_status',
                                                'srs__profile.srs_name AS nama_srs',
                                                'srs__profile.srs_peronda_total AS jumlah_peronda',
                                                'srs__profile.srs_kawalan AS srs_kawalan',
                                                'ref__status_srs.status_description AS status_description',
                                                'srs__profile.diakui_note AS diakui_note')
                                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                        ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                        ->leftJoin('users__profile','users__profile.user_id','=','srs__profile.dihantar_by')
                                        ->leftJoin('ref__status_srs','ref__status_srs.id','=','srs__profile.srs_status')
                                        ->where('srs__profile.id', '=', $id)
                                        ->limit(1)
                                        ->first();
            return view('rt-sm12.pengesahan-permohonan-penubuhan-srs-ppn-2', compact('roles_menu','pengesahan_penubuhan_srs'));
        }
    }

    function post_pengesahan_permohonan_penubuhan_srs(Request $request){
        $action = $request->post_pengesahan_permohonan_penubuhan_srs;
        $app_id = $request->pppsp_2_srs_id;
        
        
        $rules = array(
            'pppsp_2_srs_status'                => 'required',
            'pppsp_2_disahkan_note'             => 'required',
        );

        $messages = [
            'pppsp_2_srs_status.required'       => 'Ruangan Status dipilih',
            'pppsp_2_disahkan_note.required'    => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $pengesahan_permohonan_srs                      = SRS_Profile::where($where)->first();
                $pengesahan_permohonan_srs->srs_status          = $request->pppsp_2_srs_status;
                $pengesahan_permohonan_srs->disahkan_by         = Auth::user()->user_id;
                $pengesahan_permohonan_srs->disahkan_date       = date('Y-m-d H:i:s');
                $pengesahan_permohonan_srs->disahkan_note       = $request->pppsp_2_disahkan_note;
                $pengesahan_permohonan_srs->save();
            }
        }
    }

    function peraku_permohonan_penubuhan_srs(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = KRT_Profile::where($where)
                        ->where('krt__profile.krt_status', '=',  true) 
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('srs__profile')
                        ->select('srs__profile.id',
                                'srs__profile.krt_id',
                                'srs__profile.srs_name',
                                'srs__profile.srs_peronda_total',
                                'krt__profile.krt_nama AS krt_name',
                                'krt__profile.state_id AS krt_state_id',
                                'krt__profile.daerah_id AS krt_daerah_id',
                                'ref__status_srs.status_description',
                                'srs__profile.dihantar_date')
                        ->join('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->join('ref__status_srs','ref__status_srs.id','=','srs__profile.srs_status')
                        ->whereIn('srs__profile.srs_status', [7]) 
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
            $state      = RefStates::where('status', '=', true)->get();
            $daerah     = RefDaerah::where('status', '=', true)->get();
            $krt        = KRT_Profile::where('krt_status', '=', true)->get();
            return view('rt-sm12.peraku-permohonan-penubuhan-srs',compact('roles_menu','state', 'daerah', 'krt'));
        }
    }

    function peraku_permohonan_penubuhan_srs_hq(Request $request, $id){
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
            $surat_penubuhan_srs    = SRS_Profile::where('srs_status', '=', 7)
                                    ->select('srs__profile.id','krt__profile.daerah_id',
                                            'ref__daerahs.daerah_description AS daerah',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'users__profile.user_fullname AS nama_pengerusi',
                                            DB::raw(" DATE_FORMAT(srs__profile.dihantar_date,'%d/%m/%Y') AS tarikh_srs_dimohon"),
                                            'srs__profile.srs_status AS srs_status')
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('users__profile','users__profile.user_id','=','srs__profile.dihantar_by')
                                    ->where('srs__profile.id', '=', $id)
                                    ->limit(1)
                                    ->first();
            return view('rt-sm12.peraku-permohonan-penubuhan-srs-hq', compact('roles_menu','surat_penubuhan_srs'));
        }
    }

    function peraku_permohonan_penubuhan_srs_hq_1(Request $request, $id){
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
            $peraku_penubuhan_srs    = SRS_Profile::where('srs_status', '=', 7)
                                        ->select('srs__profile.id',
                                                'krt__profile.state_id',
                                                'ref__states.state_description AS negeri_krt',
                                                'krt__profile.daerah_id',
                                                'ref__daerahs.daerah_description AS daerah_krt',
                                                'krt__profile.krt_nama AS nama_krt',
                                                'krt__profile.krt_alamat AS alamat_krt',
                                                'ref__parlimens.parlimen_description AS parlimen_krt',
                                                'ref__duns.dun_description AS dun_krt',
                                                'ref__pbts.pbt_description AS pbt_krt',
                                                'users__profile.user_fullname AS nama_pemohon',
                                                'users__profile.no_ic AS ic_pemohon',
                                                'users__profile.user_address AS address_pemohon',
                                                'srs__profile.dihantar_date AS tarikh_srs_dimohon',
                                                'srs__profile.srs_status AS srs_status',
                                                'srs__profile.srs_name AS nama_srs',
                                                'srs__profile.srs_peronda_total AS jumlah_peronda',
                                                'srs__profile.srs_kawalan AS srs_kawalan')
                                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                        ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                        ->leftJoin('users__profile','users__profile.user_id','=','srs__profile.dihantar_by')
                                        ->where('srs__profile.id', '=', $id)
                                        ->limit(1)
                                        ->first();
            return view('rt-sm12.peraku-permohonan-penubuhan-srs-hq-1', compact('roles_menu','peraku_penubuhan_srs'));
        }
    }

    function peraku_permohonan_penubuhan_srs_hq_2(Request $request, $id){
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
            $peraku_penubuhan_srs    = SRS_Profile::where('srs_status', '=', 7)
                                    ->select('srs__profile.id',
                                            'krt__profile.state_id',
                                            'ref__states.state_description AS negeri_krt',
                                            'krt__profile.daerah_id',
                                            'ref__daerahs.daerah_description AS daerah_krt',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__duns.dun_description AS dun_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'users__profile.user_fullname AS nama_pemohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.user_address AS address_pemohon',
                                            'srs__profile.dihantar_date AS tarikh_srs_dimohon',
                                            'srs__profile.srs_status AS srs_status',
                                            'srs__profile.srs_name AS nama_srs',
                                            'srs__profile.srs_peronda_total AS jumlah_peronda',
                                            'srs__profile.srs_kawalan AS srs_kawalan')
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('users__profile','users__profile.user_id','=','srs__profile.dihantar_by')
                                    ->where('srs__profile.id', '=', $id)
                                    ->limit(1)
                                    ->first();
            return view('rt-sm12.peraku-permohonan-penubuhan-srs-hq-2', compact('roles_menu','peraku_penubuhan_srs'));
        }
    }

    function post_peraku_permohonan_penubuhan_srs(Request $request){
        $action = $request->post_peraku_permohonan_penubuhan_srs;
        $app_id = $request->pppsh_2_srs_id;
        
        
        $rules = array(
            'pppsh_2_srs_status'                => 'required',
            'pppsh_2_diakui_note'               => 'required',
        );

        $messages = [
            'pppsh_2_srs_status.required'       => 'Ruangan Status dipilih',
            'pppsh_2_diakui_note.required'      => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $perakuan_permohonan_srs                      = SRS_Profile::where($where)->first();
                $perakuan_permohonan_srs->srs_status          = $request->pppsh_2_srs_status;
                $perakuan_permohonan_srs->diakui_by           = Auth::user()->user_id;
                $perakuan_permohonan_srs->diakui_date         = date('Y-m-d H:i:s');
                $perakuan_permohonan_srs->diakui_note         = $request->pppsh_2_diakui_note;
                $perakuan_permohonan_srs->save();
            }
        }
    }

    function kelulusan_permohonan_penubuhan_srs(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = KRT_Profile::where($where)
                        ->where('krt__profile.krt_status', '=',  true) 
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('srs__profile')
                        ->select('srs__profile.id',
                                'srs__profile.krt_id',
                                'srs__profile.srs_name',
                                'srs__profile.srs_peronda_total',
                                'krt__profile.krt_nama AS krt_name',
                                'krt__profile.state_id AS krt_state_id',
                                'krt__profile.daerah_id AS krt_daerah_id',
                                'ref__status_srs.status_description',
                                'srs__profile.dihantar_date')
                        ->join('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->join('ref__status_srs','ref__status_srs.id','=','srs__profile.srs_status')
                        ->where('srs__profile.srs_status', '=', 9) 
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
            $state      = RefStates::where('status', '=', true)->get();
            $daerah     = RefDaerah::where('status', '=', true)->get();
            $krt        = KRT_Profile::where('krt_status', '=', true)->get();
            return view('rt-sm12.kelulusan-permohonan-penubuhan-srs',compact('roles_menu','state', 'daerah', 'krt'));
        }
    }

    function kelulusan_permohonan_penubuhan_srs_hq(Request $request, $id){
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
            $surat_penubuhan_srs    = SRS_Profile::where('srs_status', '=', 9)
                                    ->select('srs__profile.id','krt__profile.daerah_id',
                                            'ref__daerahs.daerah_description AS daerah',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'users__profile.user_fullname AS nama_pengerusi',
                                            DB::raw(" DATE_FORMAT(srs__profile.dihantar_date,'%d/%m/%Y') AS tarikh_srs_dimohon"),
                                            'srs__profile.srs_status AS srs_status')
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('users__profile','users__profile.user_id','=','srs__profile.dihantar_by')
                                    ->where('srs__profile.id', '=', $id)
                                    ->limit(1)
                                    ->first();
            return view('rt-sm12.kelulusan-permohonan-penubuhan-srs-hq', compact('roles_menu','surat_penubuhan_srs'));
        }
    }

    function kelulusan_permohonan_penubuhan_srs_hq_1(Request $request, $id){
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
            $kelulusan_penubuhan_srs    = SRS_Profile::where('srs_status', '=', 9)
                                        ->select('srs__profile.id',
                                                'krt__profile.state_id',
                                                'ref__states.state_description AS negeri_krt',
                                                'krt__profile.daerah_id',
                                                'ref__daerahs.daerah_description AS daerah_krt',
                                                'krt__profile.krt_nama AS nama_krt',
                                                'krt__profile.krt_alamat AS alamat_krt',
                                                'ref__parlimens.parlimen_description AS parlimen_krt',
                                                'ref__duns.dun_description AS dun_krt',
                                                'ref__pbts.pbt_description AS pbt_krt',
                                                'users__profile.user_fullname AS nama_pemohon',
                                                'users__profile.no_ic AS ic_pemohon',
                                                'users__profile.user_address AS address_pemohon',
                                                'srs__profile.dihantar_date AS tarikh_srs_dimohon',
                                                'srs__profile.srs_status AS srs_status',
                                                'srs__profile.srs_name AS nama_srs',
                                                'srs__profile.srs_peronda_total AS jumlah_peronda',
                                                'srs__profile.srs_kawalan AS srs_kawalan')
                                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                        ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                        ->leftJoin('users__profile','users__profile.user_id','=','srs__profile.dihantar_by')
                                        ->where('srs__profile.id', '=', $id)
                                        ->limit(1)
                                        ->first();
            return view('rt-sm12.kelulusan-permohonan-penubuhan-srs-hq-1', compact('roles_menu','kelulusan_penubuhan_srs'));
        }
    }

    function kelulusan_permohonan_penubuhan_srs_hq_2(Request $request, $id){
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
            $kelulusan_penubuhan_srs    = SRS_Profile::where('srs_status', '=', 9)
                                    ->select('srs__profile.id',
                                            'krt__profile.state_id',
                                            'ref__states.state_description AS negeri_krt',
                                            'krt__profile.daerah_id',
                                            'ref__daerahs.daerah_description AS daerah_krt',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__duns.dun_description AS dun_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'users__profile.user_fullname AS nama_pemohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.user_address AS address_pemohon',
                                            'srs__profile.dihantar_date AS tarikh_srs_dimohon',
                                            'srs__profile.srs_status AS srs_status',
                                            'srs__profile.srs_name AS nama_srs',
                                            'srs__profile.srs_peronda_total AS jumlah_peronda',
                                            'srs__profile.srs_kawalan AS srs_kawalan')
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('users__profile','users__profile.user_id','=','srs__profile.dihantar_by')
                                    ->where('srs__profile.id', '=', $id)
                                    ->limit(1)
                                    ->first();
            return view('rt-sm12.kelulusan-permohonan-penubuhan-srs-hq-2', compact('roles_menu','kelulusan_penubuhan_srs'));
        }
    }

    function post_kelulusan_permohonan_penubuhan_srs(Request $request){
        $action = $request->post_kelulusan_permohonan_penubuhan_srs;
        $app_id = $request->kppsh_2_srs_id;
        
        
        $rules = array(
            'kppsh_2_srs_status'                    => 'required',
            'kppsh_2_diluluskan_note'               => 'required',
        );

        $messages = [
            'kppsh_2_srs_status.required'           => 'Ruangan Status dipilih',
            'kppsh_2_diluluskan_note.required'      => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $kelulusan_permohonan_srs                          = SRS_Profile::where($where)->first();
                $kelulusan_permohonan_srs->srs_status              = $request->kppsh_2_srs_status;
                $kelulusan_permohonan_srs->diluluskan_by           = Auth::user()->user_id;
                $kelulusan_permohonan_srs->diluluskan_date         = date('Y-m-d H:i:s');
                $kelulusan_permohonan_srs->diluluskan_note         = $request->kppsh_2_diluluskan_note;
                $kelulusan_permohonan_srs->save();
            }
        }
    }

}
