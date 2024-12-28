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
use App\RefKaum;
use App\RefStates;
use App\RefDaerah;
use App\KRT_Profile;
use App\Krt_Pembatalan;
use App\KRT_Minit_Mesyuarat_RT;
use App\Krt_Pembatalan_Meeting;

class RT_SM8Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function permohonan_pembatalan_krt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__pembatalan')
                        ->select('krt__pembatalan.id AS id',
                                'krt__profile.krt_nama AS nama_krt',
                                'krt__profile.state_id AS state_id',
                                'krt__profile.daerah_id AS daerah_id',
                                'ref__krt_tujuan_pembatalan.tujuan_description AS tujuan_description',
                                DB::raw(" DATE_FORMAT(krt__pembatalan.direkod_date,'%d/%m/%Y') AS tarikh_permohonan"),
                                'ref__status_krt_pembatalan.status_description AS status_description',
                                'krt__pembatalan.status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__pembatalan.krt_profile_id')
                        ->leftJoin('ref__krt_tujuan_pembatalan','ref__krt_tujuan_pembatalan.id','=','krt__pembatalan.tujuan_pembatalan_id')
                        ->leftJoin('ref__status_krt_pembatalan','ref__status_krt_pembatalan.id','=','krt__pembatalan.status')
                        ->where('krt__profile.id', '=', Auth::user()->krt_id)
                        ->whereIN('krt__pembatalan.status', [2,3,4,5,6,7,8])
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
            return view('rt-sm8.permohonan-pembatalan-krt',compact('roles_menu'));
        }
    }

    function post_create_permohonan_pembatalan_krt(Request $request){
        $action = $request->post_create_permohonan_pembatalan_krt;
        
        $rules = array(
           
        );

        $messages = [
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm8.permohonan_pembatalan_krt'))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'add') {
                $pembatalan_krt                       = new Krt_Pembatalan;
                $pembatalan_krt->krt_profile_id       = Auth::user()->krt_id;
                $pembatalan_krt->status               = 2;
                $pembatalan_krt->save();
            }
           
            return Redirect::to(route('rt-sm8.permohonan_pembatalan_krt_1',$pembatalan_krt->id));
        }

    }

    function permohonan_pembatalan_krt_1(Request $request, $id){
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
        $pembatalan_krt     = DB::table('krt__pembatalan')
                            ->select('krt__pembatalan.id',
                                'krt__profile.krt_nama AS nama_krt',
                                'krt__profile.krt_alamat AS alamat_krt',
                                'ref__states.state_description AS negeri_krt',
                                'ref__parlimens.parlimen_description AS parlimen_krt',
                                'ref__pbts.pbt_description AS pbt_krt',
                                'ref__daerahs.daerah_description AS daerah_krt', 
                                'ref__duns.dun_description AS dun_krt',
                                'krt__pembatalan.tujuan_pembatalan_id AS tujuan_pembatalan_id',
                                'krt__pembatalan.nyatakan_tujuan AS nyatakan_tujuan',
                                'krt__pembatalan.status AS status',
                                'ref__status_krt_pembatalan.status_description AS status_description',
                                'krt__pembatalan.disemak_note AS disemak_note',
                                'krt__pembatalan.disokong_note AS disokong_note',
                                'krt__pembatalan.diluluskan_note AS diluluskan_note')
                            ->leftJoin('krt__profile','krt__profile.id','=','krt__pembatalan.krt_profile_id')
                            ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                            ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                            ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                            ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                            ->leftJoin('ref__status_krt_pembatalan','ref__status_krt_pembatalan.id','=','krt__pembatalan.status')
                            ->where('krt__pembatalan.id', '=', $id)  
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
        $minit_mesyuarat    = KRT_Minit_Mesyuarat_RT::where('mesyuarat_status', '=', true)
                            ->where('krt__minit_mesyuarat.krt_profile_id', '=', Auth::user()->krt_id)  
                            ->get();
        return view('rt-sm8.permohonan-pembatalan-krt-1',compact('roles_menu','pembatalan_krt','user_profile','minit_mesyuarat'));
    }

    function get_minit_meeting_pembatalan_krt_table(Request $request, $id){
        $data = DB::table('krt__pembatalan_meeting')
                ->select('krt__pembatalan_meeting.*',
                'krt__minit_mesyuarat.mesyuarat_title AS mesyuarat_title')
                ->leftjoin('krt__minit_mesyuarat','krt__minit_mesyuarat.id','=','krt__pembatalan_meeting.minit_mesyuarat_id')
                ->where('krt__pembatalan_meeting.krt_pembatalan_id', '=', $id)
                ->get();
        return Datatables::of($data)
                ->make(true);
    }

    function post_minit_meeting_pembatalan_krt(Request $request){
        $action = $request->add_minit_meeting_pembatalan_krt;
        $app_id = $request->ppk2_krt_pembatalan_id;
        
        $rules = array(
            'ppk2_minit_mesyuarat_id'              => 'required',
            'ppk2_keterangan'                      => 'required'
        );

        $messages = [
            'ppk2_minit_mesyuarat_id.required'     => 'Ruangan tajuk mesyuarat mesti dipilih',
            'ppk2_keterangan.required'             => 'Ruangan keterangan mesti diisi'
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $minit_meeting_pembatalan = new Krt_Pembatalan_Meeting;
                $minit_meeting_pembatalan->krt_pembatalan_id       = $request->ppk2_krt_pembatalan_id;
                $minit_meeting_pembatalan->minit_mesyuarat_id      = $request->ppk2_minit_mesyuarat_id;
                $minit_meeting_pembatalan->keterangan              = $request->ppk2_keterangan;
                $minit_meeting_pembatalan->save();
            }
            return \Response::json(array('success' => '1'));
        }

    }

    function delete_minit_meeting_pembatalan_krt($id){
        $data = DB::table('krt__pembatalan_meeting')->where('id', '=', $id)->delete();
    }

    function post_create_permohonan_pembatalan_krt_1(Request $request){
        $action = $request->post_create_permohonan_pembatalan_krt_1;
        $app_id = $request->ppk4_krt_pembatalan_id;
        
        
        $rules = array(
            'ppk_tujuan_pembatalan_id'              => 'required',
        );

        $messages = [
            'ppk_tujuan_pembatalan_id.required'     => 'Ruangan Tujuan Pembatalan KRT mesti dipilih',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $pembatalan_krt                            = Krt_Pembatalan::where($where)->first();
                $pembatalan_krt->tujuan_pembatalan_id      = $request->ppk_tujuan_pembatalan_id;
                $pembatalan_krt->nyatakan_tujuan           = $request->ppk_nyatakan_tujuan;
                $pembatalan_krt->status                    = 3;
                $pembatalan_krt->direkod_by                = Auth::user()->user_id;
                $pembatalan_krt->direkod_date              = date('Y-m-d H:i:s');
                $pembatalan_krt->save();
            }
        }
    }

    function semakan_pembatalan_krt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__pembatalan')
                        ->select('krt__pembatalan.id AS id',
                                'krt__profile.krt_nama AS nama_krt',
                                'krt__profile.state_id AS state_id',
                                'krt__profile.daerah_id AS daerah_id',
                                'ref__krt_tujuan_pembatalan.tujuan_description AS tujuan_description',
                                DB::raw(" DATE_FORMAT(krt__pembatalan.direkod_date,'%d/%m/%Y') AS tarikh_permohonan"),
                                'ref__status_krt_pembatalan.status_description AS status_description',
                                'krt__pembatalan.status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__pembatalan.krt_profile_id')
                        ->leftJoin('ref__krt_tujuan_pembatalan','ref__krt_tujuan_pembatalan.id','=','krt__pembatalan.tujuan_pembatalan_id')
                        ->leftJoin('ref__status_krt_pembatalan','ref__status_krt_pembatalan.id','=','krt__pembatalan.status')
                        ->whereIN('krt__pembatalan.status', [3])
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
            $krt_profile    = KRT_Profile::where('krt_status', '=', true)
                                ->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)
                                ->get();
            return view('rt-sm8.semakan-pembatalan-krt',compact('roles_menu','krt_profile'));
        }
    }

    function semakan_pembatalan_krt_1(Request $request, $id){
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
        $pembatalan_krt     = DB::table('krt__pembatalan')
                            ->select('krt__pembatalan.id',
                                'krt__pembatalan.krt_profile_id AS krt_profile_id',
                                'krt__profile.krt_nama AS nama_krt',
                                'krt__profile.krt_alamat AS alamat_krt',
                                'ref__states.state_description AS negeri_krt',
                                'ref__parlimens.parlimen_description AS parlimen_krt',
                                'ref__pbts.pbt_description AS pbt_krt',
                                'ref__daerahs.daerah_description AS daerah_krt', 
                                'ref__duns.dun_description AS dun_krt',
                                'krt__pembatalan.tujuan_pembatalan_id AS tujuan_pembatalan_id',
                                'krt__pembatalan.nyatakan_tujuan AS nyatakan_tujuan')
                            ->leftJoin('krt__profile','krt__profile.id','=','krt__pembatalan.krt_profile_id')
                            ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                            ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                            ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                            ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                            ->where('krt__pembatalan.id', '=', $id)  
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
        $minit_mesyuarat    = KRT_Minit_Mesyuarat_RT::where('mesyuarat_status', '=', true)
                            ->where('krt__minit_mesyuarat.krt_profile_id', '=', Auth::user()->krt_id)  
                            ->get();
        return view('rt-sm8.semakan-pembatalan-krt-1',compact('roles_menu','pembatalan_krt','user_profile','minit_mesyuarat'));
    }

    function post_semakan_pembatalan_krt(Request $request){
        $action = $request->post_semakan_pembatalan_krt;
        $app_id = $request->spk_pembatalan_id;
        
        
        $rules = array(
            'spk_pembatalan_status'              => 'required',
            'spk_disemak_note'                   => 'required',
        );

        $messages = [
            'spk_pembatalan_status.required'     => 'Ruangan Status mesti dipilih',
            'spk_disemak_note.required'          => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $semakan_pembatalan_krt                        = Krt_Pembatalan::where($where)->first();
                $semakan_pembatalan_krt->status                = $request->spk_pembatalan_status;
                $semakan_pembatalan_krt->disemak_note          = $request->spk_disemak_note;
                $semakan_pembatalan_krt->disemak_by            = Auth::user()->user_id;
                $semakan_pembatalan_krt->disemak_date          = date('Y-m-d H:i:s');
                $semakan_pembatalan_krt->save();
            }
        }
    }

    function sokongan_pembatalan_krt(Request $request){
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
            $data = DB::table('krt__pembatalan')
                        ->select('krt__pembatalan.id AS id',
                                'krt__profile.krt_nama AS nama_krt',
                                'krt__profile.state_id AS state_id',
                                'krt__profile.daerah_id AS daerah_id',
                                'ref__krt_tujuan_pembatalan.tujuan_description AS tujuan_description',
                                DB::raw(" DATE_FORMAT(krt__pembatalan.direkod_date,'%d/%m/%Y') AS tarikh_permohonan"),
                                'ref__status_krt_pembatalan.status_description AS status_description',
                                'krt__pembatalan.status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__pembatalan.krt_profile_id')
                        ->leftJoin('ref__krt_tujuan_pembatalan','ref__krt_tujuan_pembatalan.id','=','krt__pembatalan.tujuan_pembatalan_id')
                        ->leftJoin('ref__status_krt_pembatalan','ref__status_krt_pembatalan.id','=','krt__pembatalan.status')
                        ->whereIN('krt__pembatalan.status', [4])
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
            $daerah     = RefDaerah::where('status', '=', true)
                        ->where('ref__daerahs.state_id', '=', Auth::user()->state_id)
                        ->get();
            $krt        = KRT_Profile::where('krt_status', '=',  true)
                        ->get();
            return view('rt-sm8.sokongan-pembatalan-krt',compact('roles_menu','daerah','krt'));
        }
    }

    function sokongan_pembatalan_krt_1(Request $request, $id){
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
        $pembatalan_krt     = DB::table('krt__pembatalan')
                            ->select('krt__pembatalan.id',
                                'krt__pembatalan.krt_profile_id AS krt_profile_id',
                                'krt__profile.krt_nama AS nama_krt',
                                'krt__profile.krt_alamat AS alamat_krt',
                                'ref__states.state_description AS negeri_krt',
                                'ref__parlimens.parlimen_description AS parlimen_krt',
                                'ref__pbts.pbt_description AS pbt_krt',
                                'ref__daerahs.daerah_description AS daerah_krt', 
                                'ref__duns.dun_description AS dun_krt',
                                'krt__pembatalan.tujuan_pembatalan_id AS tujuan_pembatalan_id',
                                'krt__pembatalan.nyatakan_tujuan AS nyatakan_tujuan')
                            ->leftJoin('krt__profile','krt__profile.id','=','krt__pembatalan.krt_profile_id')
                            ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                            ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                            ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                            ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                            ->where('krt__pembatalan.id', '=', $id)  
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
        $minit_mesyuarat    = KRT_Minit_Mesyuarat_RT::where('mesyuarat_status', '=', true)
                            ->where('krt__minit_mesyuarat.krt_profile_id', '=', Auth::user()->krt_id)  
                            ->get();
        return view('rt-sm8.sokongan-pembatalan-krt-1',compact('roles_menu','pembatalan_krt','user_profile','minit_mesyuarat'));
    }

    function post_sokongan_pembatalan_krt(Request $request){
        $action = $request->post_sokongan_pembatalan_krt;
        $app_id = $request->spk_pembatalan_id;
        
        
        $rules = array(
            'spk_pembatalan_status'               => 'required',
            'spk_disokong_note'                   => 'required',
        );

        $messages = [
            'spk_pembatalan_status.required'     => 'Ruangan Status mesti dipilih',
            'spk_disokong_note.required'         => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $sokongan_pembatalan_krt                        = Krt_Pembatalan::where($where)->first();
                $sokongan_pembatalan_krt->status                = $request->spk_pembatalan_status;
                $sokongan_pembatalan_krt->disokong_note         = $request->spk_disokong_note;
                $sokongan_pembatalan_krt->disokong_by           = Auth::user()->user_id;
                $sokongan_pembatalan_krt->disokong_date         = date('Y-m-d H:i:s');
                $sokongan_pembatalan_krt->save();
            }
        }
    }

    function kelulusan_pembatalan_krt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = KRT_Profile::where($where)
                        ->where('krt__profile.krt_status', '=',  true) 
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('krt__pembatalan')
                        ->select('krt__pembatalan.id AS id',
                                'krt__profile.krt_nama AS nama_krt',
                                'krt__profile.state_id AS state_id',
                                'krt__profile.daerah_id AS daerah_id',
                                'ref__krt_tujuan_pembatalan.tujuan_description AS tujuan_description',
                                DB::raw(" DATE_FORMAT(krt__pembatalan.direkod_date,'%d/%m/%Y') AS tarikh_permohonan"),
                                'ref__status_krt_pembatalan.status_description AS status_description',
                                'krt__pembatalan.status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__pembatalan.krt_profile_id')
                        ->leftJoin('ref__krt_tujuan_pembatalan','ref__krt_tujuan_pembatalan.id','=','krt__pembatalan.tujuan_pembatalan_id')
                        ->leftJoin('ref__status_krt_pembatalan','ref__status_krt_pembatalan.id','=','krt__pembatalan.status')
                        ->whereIN('krt__pembatalan.status', [6])
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
            $state      = RefStates::where('status', '=', true)
                        ->get();
            $daerah     = RefDaerah::where('status', '=', true)
                        ->get();
            $krt        = KRT_Profile::where('krt_status', '=',  true)
                        ->get();
            return view('rt-sm8.kelulusan-pembatalan-krt',compact('roles_menu','state','daerah','krt'));
        }
    }

    function kelulusan_pembatalan_krt_1(Request $request, $id){
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
        $pembatalan_krt     = DB::table('krt__pembatalan')
                            ->select('krt__pembatalan.id',
                                'krt__pembatalan.krt_profile_id AS krt_profile_id',
                                'krt__profile.krt_nama AS nama_krt',
                                'krt__profile.krt_alamat AS alamat_krt',
                                'ref__states.state_description AS negeri_krt',
                                'ref__parlimens.parlimen_description AS parlimen_krt',
                                'ref__pbts.pbt_description AS pbt_krt',
                                'ref__daerahs.daerah_description AS daerah_krt', 
                                'ref__duns.dun_description AS dun_krt',
                                'krt__pembatalan.tujuan_pembatalan_id AS tujuan_pembatalan_id',
                                'krt__pembatalan.nyatakan_tujuan AS nyatakan_tujuan')
                            ->leftJoin('krt__profile','krt__profile.id','=','krt__pembatalan.krt_profile_id')
                            ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                            ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                            ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                            ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                            ->where('krt__pembatalan.id', '=', $id)  
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
        $minit_mesyuarat    = KRT_Minit_Mesyuarat_RT::where('mesyuarat_status', '=', true)
                            ->where('krt__minit_mesyuarat.krt_profile_id', '=', Auth::user()->krt_id)  
                            ->get();
        return view('rt-sm8.kelulusan-pembatalan-krt-1',compact('roles_menu','pembatalan_krt','user_profile','minit_mesyuarat'));
    }

    function post_kelulusan_pembatalan_krt(Request $request){
        $action = $request->post_kelulusan_pembatalan_krt;
        $app_id = $request->kpk_pembatalan_id;
        $krt_profile_id = $request->kpk_krt_profile_id;
        $status = $request->kpk_pembatalan_status;
        
        $rules = array(
            'kpk_pembatalan_status'              => 'required',
            'kpk_diluluskan_note'                => 'required',
        );

        $messages = [
            'kpk_pembatalan_status.required'     => 'Ruangan Status mesti dipilih',
            'kpk_diluluskan_note.required'       => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $kelulusan_pembatalan_krt                        = Krt_Pembatalan::where($where)->first();
                $kelulusan_pembatalan_krt->status                = $request->kpk_pembatalan_status;
                $kelulusan_pembatalan_krt->diluluskan_note       = $request->kpk_diluluskan_note;
                $kelulusan_pembatalan_krt->diluluskan_by         = Auth::user()->user_id;
                $kelulusan_pembatalan_krt->diluluskan_date       = date('Y-m-d H:i:s');
                $kelulusan_pembatalan_krt->save();

                if($status == '1'){
                    $where1 = array('id' => $krt_profile_id);
                    $krt_profile                                  = KRT_Profile::where($where1)->first();
                    $krt_profile->krt_status                      = 8;
                    $krt_profile->save();

                    $where2 = array('krt_id' => $krt_profile_id);
                    $users = User::where('krt_id', $where2)
                        ->whereIN('users.user_role', [10,11,12,13])
                        ->get();
                    foreach($users as $users){
                        $users->user_status = 2;
                        $users->save();
                    }
                }
            }
        }
    }

    function senarai_pembatalan_krt_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__pembatalan')
                        ->select('krt__pembatalan.id AS id',
                                'krt__profile.id AS krt_profile_id',
                                'krt__profile.krt_nama AS nama_krt',
                                'krt__profile.state_id AS state_id',
                                'krt__profile.daerah_id AS daerah_id',
                                'ref__krt_tujuan_pembatalan.tujuan_description AS tujuan_description',
                                DB::raw(" DATE_FORMAT(krt__pembatalan.direkod_date,'%d/%m/%Y') AS tarikh_permohonan"),
                                'ref__status_krt_pembatalan.status_description AS status_description',
                                'krt__pembatalan.status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__pembatalan.krt_profile_id')
                        ->leftJoin('ref__krt_tujuan_pembatalan','ref__krt_tujuan_pembatalan.id','=','krt__pembatalan.tujuan_pembatalan_id')
                        ->leftJoin('ref__status_krt_pembatalan','ref__status_krt_pembatalan.id','=','krt__pembatalan.status')
                        ->whereIN('krt__pembatalan.status', [1])
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
            $krt_profile    = KRT_Profile::where('krt_status', '=', true)
                                ->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)
                                ->get();
            return view('rt-sm8.senarai-pembatalan-krt-ppd',compact('roles_menu','krt_profile'));
        }
    }

    function senarai_pembatalan_krt_ppn(Request $request){
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
            $data = DB::table('krt__pembatalan')
                        ->select('krt__pembatalan.id AS id',
                                'krt__profile.id AS krt_profile_id',
                                'krt__profile.krt_nama AS nama_krt',
                                'krt__profile.state_id AS state_id',
                                'krt__profile.daerah_id AS daerah_id',
                                'ref__krt_tujuan_pembatalan.tujuan_description AS tujuan_description',
                                DB::raw(" DATE_FORMAT(krt__pembatalan.direkod_date,'%d/%m/%Y') AS tarikh_permohonan"),
                                'ref__status_krt_pembatalan.status_description AS status_description',
                                'krt__pembatalan.status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__pembatalan.krt_profile_id')
                        ->leftJoin('ref__krt_tujuan_pembatalan','ref__krt_tujuan_pembatalan.id','=','krt__pembatalan.tujuan_pembatalan_id')
                        ->leftJoin('ref__status_krt_pembatalan','ref__status_krt_pembatalan.id','=','krt__pembatalan.status')
                        ->whereIN('krt__pembatalan.status', [1])
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
            $daerah     = RefDaerah::where('status', '=', true)
                        ->where('ref__daerahs.state_id', '=', Auth::user()->state_id)
                        ->get();
            $krt        = KRT_Profile::where('krt_status', '=',  8)
                        ->get();
            return view('rt-sm8.senarai-pembatalan-krt-ppn',compact('roles_menu','daerah','krt'));
        }
    }

    function senarai_pembatalan_krt_hqrt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = KRT_Profile::where($where)
                        ->where('krt__profile.krt_status', '=',  1) 
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('krt__pembatalan')
                        ->select('krt__pembatalan.id AS id',
                                'krt__profile.id AS krt_profile_id',
                                'krt__profile.krt_nama AS nama_krt',
                                'krt__profile.state_id AS state_id',
                                'krt__profile.daerah_id AS daerah_id',
                                'ref__krt_tujuan_pembatalan.tujuan_description AS tujuan_description',
                                DB::raw(" DATE_FORMAT(krt__pembatalan.direkod_date,'%d/%m/%Y') AS tarikh_permohonan"),
                                'ref__status_krt_pembatalan.status_description AS status_description',
                                'krt__pembatalan.status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__pembatalan.krt_profile_id')
                        ->leftJoin('ref__krt_tujuan_pembatalan','ref__krt_tujuan_pembatalan.id','=','krt__pembatalan.tujuan_pembatalan_id')
                        ->leftJoin('ref__status_krt_pembatalan','ref__status_krt_pembatalan.id','=','krt__pembatalan.status')
                        ->whereIN('krt__pembatalan.status', [1])
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
            $state      = RefStates::where('status', '=', true)
                        ->get();
            $daerah     = RefDaerah::where('status', '=', true)
                        ->get();
            $krt        = KRT_Profile::where('krt_status', '=',  true)
                        ->get();
            return view('rt-sm8.senarai-pembatalan-krt-hqrt',compact('roles_menu','state','daerah','krt'));
        }
    }

    function permohonan_pembatalan_krt_admin(){
        return view('rt-sm8.permohonan-pembatalan-krt-admin');
    }

    function semak_permohonan_pembatalan_krt_admin(){
        return view('rt-sm8.semak-permohonan-pembatalan-krt-admin');
    }

    function sokongan_pembatalan_krt_admin(){
        return view('rt-sm8.sokongan-pembatalan-krt-admin');
    }

    function semakan_pembatalan_krt_ppd_admin(){
        return view('rt-sm8.semakan-pembatalan-krt-ppd-admin');
    }

    function semakan_pembatalan_krt_ppd_admin_1(){
        return view('rt-sm8.semakan-pembatalan-krt-ppd-admin-1');
    }

    function paparan_senarai_permohonan_krt_batal_admin(){
        return view('rt-sm8.paparan-senarai-permohonan-krt-batal_admin');
    }

    function semakan_pembatalan_krt_ppn_admin(){
        return view('rt-sm8.semakan-pembatalan-krt-ppn-admin');
    }

    function semakan_pembatalan_krt_ppn_admin_1(){
        return view('rt-sm8.semakan-pembatalan-krt-ppn-admin-1');
    }

    function kelulusan_pembatalan_admin(){
        return view('rt-sm8.kelulusan-pembatalan_admin');
    }

    function semakan_pembatalan_krt_hq_admin(){
        return view('rt-sm8.semakan-pembatalan-krt-hq-admin');
    }

    function semakan_pembatalan_krt_hq_admin_1(){
        return view('rt-sm8.semakan-pembatalan-krt-hq-admin-1');
    }

    function jana_surat_kelulusan_pembatalan_admin(){
        return view('rt-sm8.jana-surat-kelulusan-pembatalan-admin');
    }

    function surat_kelulusan_pembatalan_krt_admin(){
        return view('rt-sm8.surat-kelulusan-pembatalan-krt-admin');
    }

    function paparan_senarai_krt_batal_admin(){
        return view('rt-sm8.paparan-senarai-krt-batal-admin');
    }
}
