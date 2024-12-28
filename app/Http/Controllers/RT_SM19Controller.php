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
use App\SRS_Ahli_Peronda;
use App\SRS_Permohonan_Pembatalan_Srs;
use App\SRS_Permohonan_Pembatalan_Meeting;
use App\KRT_Minit_Mesyuarat_RT;

use DataTables;
use DB;

class RT_SM19Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function permohonan_pembatalan_srs_p(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('srs__permohonan_pembatalan_srs')
                        ->select('srs__permohonan_pembatalan_srs.id AS id',
                                'krt__profile.krt_nama AS nama_krt',
                                'krt__profile.state_id AS state_id',
                                'krt__profile.daerah_id AS daerah_id',
                                'srs__profile.srs_name AS nama_srs',
                                DB::raw(" DATE_FORMAT(srs__profile.diluluskan_date,'%Y') AS tahun_ditubuhkan_srs"),
                                'users__profile.user_fullname AS dimohon_oleh',
                                'ref__status_srs_pembatalan_srs.status_description AS status',
                                'srs__permohonan_pembatalan_srs.pembatalan_status AS pembatalan_status')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__permohonan_pembatalan_srs.krt_profile_id')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__permohonan_pembatalan_srs.srs_profile_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','srs__permohonan_pembatalan_srs.direkod_by')
                        ->leftJoin('ref__status_srs_pembatalan_srs','ref__status_srs_pembatalan_srs.id','=','srs__permohonan_pembatalan_srs.pembatalan_status')
                        ->whereIN('srs__permohonan_pembatalan_srs.pembatalan_status', [2,3,4,5,6,7,8])
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
            $krt_profile    = KRT_Profile::where('krt_status', '=', true)
                                ->where('krt__profile.id', '=', Auth::user()->krt_id)
                                ->get();
            $srs_profile    = SRS_Profile::where('srs_status', '=', true)
                                ->where('srs__profile.krt_id', '=', Auth::user()->krt_id)
                                ->get();
            return view('rt-sm19.permohonan-pembatalan-srs-p',compact('roles_menu','krt_profile','srs_profile'));
        }
    }

    function post_create_permohonan_pembatalan_srs(Request $request){
        $action = $request->post_create_permohonan_pembatalan_srs;
        
        $rules = array(
           
        );

        $messages = [
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm19.permohonan_pembatalan_srs_p'))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'add') {
                $pembatalan_srs = new SRS_Permohonan_Pembatalan_Srs;
                $pembatalan_srs->krt_profile_id       = Auth::user()->krt_id;
                $pembatalan_srs->pembatalan_status    = 2;
                $pembatalan_srs->save();
            }
           
            return Redirect::to(route('rt-sm19.permohonan_pembatalan_srs_p_1',$pembatalan_srs->id));
        }

    }

    function permohonan_pembatalan_srs_p_1(Request $request, $id){
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
        $pembatalan_srs   = DB::table('srs__permohonan_pembatalan_srs')
                            ->select('srs__permohonan_pembatalan_srs.id',
                                'krt__profile.krt_nama AS nama_krt',
                                'krt__profile.krt_alamat AS alamat_krt',
                                'ref__states.state_description AS negeri_krt',
                                'ref__parlimens.parlimen_description AS parlimen_krt',
                                'ref__pbts.pbt_description AS pbt_krt',
                                'ref__daerahs.daerah_description AS daerah_krt', 
                                'ref__duns.dun_description AS dun_krt',
                                'srs__permohonan_pembatalan_srs.srs_profile_id AS srs_profile_id',
                                'ref__status_srs_pembatalan_srs.status_description AS status_description',
                                'srs__permohonan_pembatalan_srs.disemak_note AS disemak_note',
                                'srs__permohonan_pembatalan_srs.pembatalan_status AS pembatalan_status')
                            ->leftJoin('krt__profile','krt__profile.id','=','srs__permohonan_pembatalan_srs.krt_profile_id')
                            ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                            ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                            ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                            ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                            ->leftJoin('ref__status_srs_pembatalan_srs','ref__status_srs_pembatalan_srs.id','=','srs__permohonan_pembatalan_srs.pembatalan_status')
                            ->where('srs__permohonan_pembatalan_srs.id', '=', $id)  
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
        $srs_profile    = SRS_Profile::where('srs_status', '=', true)
                            ->where('srs__profile.krt_id', '=', Auth::user()->krt_id)
                            ->get();
        $minit_mesyuarat    = KRT_Minit_Mesyuarat_RT::where('mesyuarat_status', '=', true)
                            ->where('krt__minit_mesyuarat.krt_profile_id', '=', Auth::user()->krt_id)  
                            ->get();
        return view('rt-sm19.permohonan-pembatalan-srs-p-1',compact('roles_menu','pembatalan_srs','user_profile','srs_profile','minit_mesyuarat'));
    }

    function get_senarai_minit_meeting_pembatalan_table(Request $request, $id){
        $data = DB::table('srs__permohonan_pembatalan_meeting')
                ->select('srs__permohonan_pembatalan_meeting.*',
                'krt__minit_mesyuarat.mesyuarat_title AS mesyuarat_title')
                ->leftjoin('krt__minit_mesyuarat','krt__minit_mesyuarat.id','=','srs__permohonan_pembatalan_meeting.minit_mesyuarat_id')
                ->where('srs__permohonan_pembatalan_meeting.pembatalan_srs_id', '=', $id)
                ->get();
        return Datatables::of($data)
                ->make(true);
    }

    function post_minit_meeting_pembatalan_srs(Request $request){
        $action = $request->add_minit_meeting_pembatalan_srs;
        $app_id = $request->ppsp2_pembatalan_srs_id;
        
        $rules = array(
            'ppsp2_minit_mesyuarat_id'              => 'required',
            'ppsp2_keterangan'                      => 'required'
        );

        $messages = [
            'ppsp2_minit_mesyuarat_id.required'     => 'Ruangan tajuk mesyuarat mesti dipilih',
            'ppsp2_keterangan.required'             => 'Ruangan keterangan mesti diisi'
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $minit_meeting_pembatalan = new SRS_Permohonan_Pembatalan_Meeting;
                $minit_meeting_pembatalan->pembatalan_srs_id       = $request->ppsp2_pembatalan_srs_id;
                $minit_meeting_pembatalan->minit_mesyuarat_id      = $request->ppsp2_minit_mesyuarat_id;
                $minit_meeting_pembatalan->keterangan              = $request->ppsp2_keterangan;
                $minit_meeting_pembatalan->save();
            }
            return \Response::json(array('success' => '1'));
        }

    }

    function delete_senarai_minit_meeting_pembatalan($id){
        $data = DB::table('srs__permohonan_pembatalan_meeting')->where('id', '=', $id)->delete();
    }

    function post_create_permohonan_pembatalan_srs_1(Request $request){
        $action = $request->post_create_permohonan_pembatalan_srs_1;
        $app_id = $request->ppsp3_pembatalan_srs_id;
        
        
        $rules = array(
            'ppsp_srs_profile_id'              => 'required',
        );

        $messages = [
            'ppsp_srs_profile_id.required'     => 'Ruangan Nama SRS mesti dipilih',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $pembatalan_srs                            = SRS_Permohonan_Pembatalan_Srs::where($where)->first();
                $pembatalan_srs->srs_profile_id            = $request->ppsp_srs_profile_id;
                $pembatalan_srs->pembatalan_status         = 3;
                $pembatalan_srs->direkod_by                = Auth::user()->user_id;
                $pembatalan_srs->direkod_date              = date('Y-m-d H:i:s');
                $pembatalan_srs->save();
            }
        }
    }

    function semakan_pembatalan_srs_ppd(Request $request){
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
            $data = DB::table('srs__permohonan_pembatalan_srs')
                        ->select('srs__permohonan_pembatalan_srs.id AS id',
                                'krt__profile.krt_nama AS nama_krt',
                                'krt__profile.state_id AS state_id',
                                'krt__profile.daerah_id AS daerah_id',
                                'srs__profile.srs_name AS nama_srs',
                                DB::raw(" DATE_FORMAT(srs__profile.diluluskan_date,'%Y') AS tahun_ditubuhkan_srs"),
                                'users__profile.user_fullname AS dimohon_oleh',
                                'ref__status_srs_pembatalan_srs.status_description AS status',
                                'srs__permohonan_pembatalan_srs.pembatalan_status AS pembatalan_status',
                                'ref__status_srs_pembatalan_srs.status_description AS status_description',
                                'srs__permohonan_pembatalan_srs.disahkan_note AS disahkan_note')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__permohonan_pembatalan_srs.krt_profile_id')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__permohonan_pembatalan_srs.srs_profile_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','srs__permohonan_pembatalan_srs.direkod_by')
                        ->leftJoin('ref__status_srs_pembatalan_srs','ref__status_srs_pembatalan_srs.id','=','srs__permohonan_pembatalan_srs.pembatalan_status')
                        ->whereIN('srs__permohonan_pembatalan_srs.pembatalan_status', [3,7])
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
            $srs_profile    = SRS_Profile::where('srs_status', '=', true)
                                ->get();
            return view('rt-sm19.semakan-pembatalan-srs-ppd',compact('roles_menu','krt_profile','srs_profile'));
        }
    }

    function semakan_pembatalan_srs_ppd_1(Request $request, $id){
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
        $pembatalan_srs   = DB::table('srs__permohonan_pembatalan_srs')
                            ->select('srs__permohonan_pembatalan_srs.id',
                                'krt__profile.krt_nama AS nama_krt',
                                'krt__profile.krt_alamat AS alamat_krt',
                                'ref__states.state_description AS negeri_krt',
                                'ref__parlimens.parlimen_description AS parlimen_krt',
                                'ref__pbts.pbt_description AS pbt_krt',
                                'ref__daerahs.daerah_description AS daerah_krt', 
                                'ref__duns.dun_description AS dun_krt',
                                'users__profile.user_fullname AS direkod_by',
                                'users__profile.no_ic AS direkod_ic',
                                'users__profile.user_address AS direkod_alamat',
                                'srs__permohonan_pembatalan_srs.srs_profile_id AS srs_profile_id',
                                'srs__permohonan_pembatalan_srs.pembatalan_status AS pembatalan_status',
                                'ref__status_srs_pembatalan_srs.status_description AS status_description',
                                'srs__permohonan_pembatalan_srs.disahkan_note AS disahkan_note')
                            ->leftJoin('krt__profile','krt__profile.id','=','srs__permohonan_pembatalan_srs.krt_profile_id')
                            ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                            ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                            ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                            ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                            ->leftJoin('users__profile','users__profile.user_id','=','srs__permohonan_pembatalan_srs.direkod_by')
                            ->leftJoin('ref__status_srs_pembatalan_srs','ref__status_srs_pembatalan_srs.id','=','srs__permohonan_pembatalan_srs.pembatalan_status')
                            ->where('srs__permohonan_pembatalan_srs.id', '=', $id)  
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
        $srs_profile    = SRS_Profile::where('srs_status', '=', true)
                            ->get();
        $minit_mesyuarat    = KRT_Minit_Mesyuarat_RT::where('mesyuarat_status', '=', true)
                            ->where('krt__minit_mesyuarat.krt_profile_id', '=', Auth::user()->krt_id)  
                            ->get();
        return view('rt-sm19.semakan-pembatalan-srs-ppd-1',compact('roles_menu','pembatalan_srs','user_profile','srs_profile','minit_mesyuarat'));
    }

    function post_semakan_pembatalan_srs(Request $request){
        $action = $request->post_semakan_pembatalan_srs;
        $app_id = $request->spspd_pembatalan_id;
        
        
        $rules = array(
            'spspd_pembatalan_status'              => 'required',
            'spspd_disemak_note'                   => 'required',
        );

        $messages = [
            'spspd_pembatalan_status.required'     => 'Ruangan Status mesti dipilih',
            'spspd_disemak_note.required'          => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $semakan_pembatalan_srs                        = SRS_Permohonan_Pembatalan_Srs::where($where)->first();
                $semakan_pembatalan_srs->pembatalan_status     = $request->spspd_pembatalan_status;
                $semakan_pembatalan_srs->disemak_note          = $request->spspd_disemak_note;
                $semakan_pembatalan_srs->disemak_by            = Auth::user()->user_id;
                $semakan_pembatalan_srs->disemak_date          = date('Y-m-d H:i:s');
                $semakan_pembatalan_srs->save();
            }
        }
    }

    function pengesahan_pembatalan_srs_ppn(Request $request){
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
            $data = DB::table('srs__permohonan_pembatalan_srs')
                        ->select('srs__permohonan_pembatalan_srs.id AS id',
                                'ref__daerahs.daerah_description AS daerah',
                                'krt__profile.krt_nama AS nama_krt',
                                'krt__profile.state_id AS state_id',
                                'krt__profile.daerah_id AS daerah_id',
                                'srs__profile.srs_name AS nama_srs',
                                DB::raw(" DATE_FORMAT(srs__profile.diluluskan_date,'%Y') AS tahun_ditubuhkan_srs"),
                                'users__profile.user_fullname AS dimohon_oleh',
                                'ref__status_srs_pembatalan_srs.status_description AS status',
                                'srs__permohonan_pembatalan_srs.pembatalan_status AS pembatalan_status')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__permohonan_pembatalan_srs.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__permohonan_pembatalan_srs.srs_profile_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','srs__permohonan_pembatalan_srs.direkod_by')
                        ->leftJoin('ref__status_srs_pembatalan_srs','ref__status_srs_pembatalan_srs.id','=','srs__permohonan_pembatalan_srs.pembatalan_status')
                        ->whereIN('srs__permohonan_pembatalan_srs.pembatalan_status', [4,8])
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
            $daerah         = RefDaerah::where('status', '=', true)
                            ->where('ref__daerahs.state_id', '=', Auth::user()->state_id)
                            ->get();
            $krt_profile    = KRT_Profile::where('krt_status', '=', true)
                                ->get();
            $srs_profile    = SRS_Profile::where('srs_status', '=', true)
                                ->get();
            return view('rt-sm19.pengesahan-pembatalan-srs-ppn',compact('roles_menu','daerah','krt_profile','srs_profile'));
        }
    }

    function pengesahan_pembatalan_srs_ppn_1(Request $request, $id){
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
        $pembatalan_srs   = DB::table('srs__permohonan_pembatalan_srs')
                            ->select('srs__permohonan_pembatalan_srs.id',
                                'krt__profile.krt_nama AS nama_krt',
                                'krt__profile.krt_alamat AS alamat_krt',
                                'ref__states.state_description AS negeri_krt',
                                'ref__parlimens.parlimen_description AS parlimen_krt',
                                'ref__pbts.pbt_description AS pbt_krt',
                                'ref__daerahs.daerah_description AS daerah_krt', 
                                'ref__duns.dun_description AS dun_krt',
                                'users__profile.user_fullname AS direkod_by',
                                'users__profile.no_ic AS direkod_ic',
                                'users__profile.user_address AS direkod_alamat',
                                'srs__permohonan_pembatalan_srs.srs_profile_id AS srs_profile_id',
                                'srs__permohonan_pembatalan_srs.pembatalan_status AS pembatalan_status',
                                'ref__status_srs_pembatalan_srs.status_description AS status_description',
                                'srs__permohonan_pembatalan_srs.diluluskan_note AS diluluskan_note')
                            ->leftJoin('krt__profile','krt__profile.id','=','srs__permohonan_pembatalan_srs.krt_profile_id')
                            ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                            ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                            ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                            ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                            ->leftJoin('users__profile','users__profile.user_id','=','srs__permohonan_pembatalan_srs.direkod_by')
                            ->leftJoin('ref__status_srs_pembatalan_srs','ref__status_srs_pembatalan_srs.id','=','srs__permohonan_pembatalan_srs.pembatalan_status')
                            ->where('srs__permohonan_pembatalan_srs.id', '=', $id)  
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
        $srs_profile    = SRS_Profile::where('srs_status', '=', true)
                            ->get();
        $minit_mesyuarat    = KRT_Minit_Mesyuarat_RT::where('mesyuarat_status', '=', true)
                            ->where('krt__minit_mesyuarat.krt_profile_id', '=', Auth::user()->krt_id)  
                            ->get();
        return view('rt-sm19.pengesahan-pembatalan-srs-ppn-1',compact('roles_menu','pembatalan_srs','user_profile','srs_profile','minit_mesyuarat'));
    }

    function post_pengesahan_pembatalan_srs(Request $request){
        $action = $request->post_pengesahan_pembatalan_srs;
        $app_id = $request->spspn_pembatalan_id;
        
        
        $rules = array(
            'spspn_pembatalan_status'              => 'required',
            'spspn_disemak_note'                   => 'required',
        );

        $messages = [
            'spspn_pembatalan_status.required'     => 'Ruangan Status mesti dipilih',
            'spspn_disemak_note.required'          => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $pengesahan_pembatalan_srs                        = SRS_Permohonan_Pembatalan_Srs::where($where)->first();
                $pengesahan_pembatalan_srs->pembatalan_status     = $request->spspn_pembatalan_status;
                $pengesahan_pembatalan_srs->disahkan_note         = $request->spspn_disemak_note;
                $pengesahan_pembatalan_srs->disahkan_by           = Auth::user()->user_id;
                $pengesahan_pembatalan_srs->disahkan_date         = date('Y-m-d H:i:s');
                $pengesahan_pembatalan_srs->save();
            }
        }
    }

    function kelulusan_pembatalan_srs_hq(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)
                        ->get();
                return Response::json($data);
            }else if($type == 'get_krt') {
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
            $data = DB::table('srs__permohonan_pembatalan_srs')
                        ->select('srs__permohonan_pembatalan_srs.id AS id',
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'krt__profile.krt_nama AS nama_krt',
                                'krt__profile.state_id AS state_id',
                                'krt__profile.daerah_id AS daerah_id',
                                'srs__profile.srs_name AS nama_srs',
                                DB::raw(" DATE_FORMAT(srs__profile.diluluskan_date,'%Y') AS tahun_ditubuhkan_srs"),
                                'users__profile.user_fullname AS dimohon_oleh',
                                'ref__status_srs_pembatalan_srs.status_description AS status',
                                'srs__permohonan_pembatalan_srs.pembatalan_status AS pembatalan_status')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__permohonan_pembatalan_srs.krt_profile_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__permohonan_pembatalan_srs.srs_profile_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','srs__permohonan_pembatalan_srs.direkod_by')
                        ->leftJoin('ref__status_srs_pembatalan_srs','ref__status_srs_pembatalan_srs.id','=','srs__permohonan_pembatalan_srs.pembatalan_status')
                        ->whereIN('srs__permohonan_pembatalan_srs.pembatalan_status', [6])
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
            $state          = RefStates::where('status', '=', true)
                            ->get();
            $daerah         = RefDaerah::where('status', '=', true)
                            ->get();
            $krt_profile    = KRT_Profile::where('krt_status', '=', true)
                            ->get();
            $srs_profile    = SRS_Profile::where('srs_status', '=', true)
                            ->get();
            return view('rt-sm19.kelulusan-pembatalan-srs-hq',compact('roles_menu','state','daerah','krt_profile','srs_profile'));
        }
    }

    function kelulusan_pembatalan_srs_hq_1(Request $request, $id){
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
        $pembatalan_srs   = DB::table('srs__permohonan_pembatalan_srs')
                            ->select('srs__permohonan_pembatalan_srs.id',
                                'krt__profile.krt_nama AS nama_krt',
                                'krt__profile.krt_alamat AS alamat_krt',
                                'ref__states.state_description AS negeri_krt',
                                'ref__parlimens.parlimen_description AS parlimen_krt',
                                'ref__pbts.pbt_description AS pbt_krt',
                                'ref__daerahs.daerah_description AS daerah_krt', 
                                'ref__duns.dun_description AS dun_krt',
                                'users__profile.user_fullname AS direkod_by',
                                'users__profile.no_ic AS direkod_ic',
                                'users__profile.user_address AS direkod_alamat',
                                'srs__permohonan_pembatalan_srs.srs_profile_id AS srs_profile_id')
                            ->leftJoin('krt__profile','krt__profile.id','=','srs__permohonan_pembatalan_srs.krt_profile_id')
                            ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                            ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                            ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                            ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                            ->leftJoin('users__profile','users__profile.user_id','=','srs__permohonan_pembatalan_srs.direkod_by')
                            ->where('srs__permohonan_pembatalan_srs.id', '=', $id)  
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
        $srs_profile    = SRS_Profile::where('srs_status', '=', true)
                            ->get();
        $minit_mesyuarat    = KRT_Minit_Mesyuarat_RT::where('mesyuarat_status', '=', true)
                            ->where('krt__minit_mesyuarat.krt_profile_id', '=', Auth::user()->krt_id)  
                            ->get();
        return view('rt-sm19.kelulusan-pembatalan-srs-hq-1',compact('roles_menu','pembatalan_srs','user_profile','srs_profile','minit_mesyuarat'));
    }

    function post_kelulusan_pembatalan_srs(Request $request){
        $action = $request->post_kelulusan_pembatalan_srs;
        $app_id = $request->kpshq_pembatalan_id;
        $srs_profile_id = $request->kpshq_srs_profile_id_2;
        $status = $request->kpshq_pembatalan_status;
        
        
        $rules = array(
            'kpshq_pembatalan_status'              => 'required',
            'kpshq_diluluskan_note'                   => 'required',
        );

        $messages = [
            'kpshq_pembatalan_status.required'     => 'Ruangan Status mesti dipilih',
            'kpshq_diluluskan_note.required'          => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $kelulusan_pembatalan_srs                          = SRS_Permohonan_Pembatalan_Srs::where($where)->first();
                $kelulusan_pembatalan_srs->pembatalan_status       = $request->kpshq_pembatalan_status;
                $kelulusan_pembatalan_srs->diluluskan_note         = $request->kpshq_diluluskan_note;
                $kelulusan_pembatalan_srs->diluluskan_by           = Auth::user()->user_id;
                $kelulusan_pembatalan_srs->diluluskan_date         = date('Y-m-d H:i:s');
                $kelulusan_pembatalan_srs->save();
                
                if($status == '1'){
                    $where1 = array('id' => $srs_profile_id);
                    $srs_profile                                  = SRS_Profile::where($where1)->first();
                    $srs_profile->srs_status                      = 2;
                    $srs_profile->save();

                    $where2 = array('srs_profile_id' => $srs_profile_id);
                    $ahli_peronda = SRS_Ahli_Peronda::where('srs_profile_id', $where2)
                         ->get();
                    foreach($ahli_peronda as $ahli_peronda){
                        $ahli_peronda->peronda_status = 2;
                        $ahli_peronda->save();
                    }
                }
            }
        }
    }

    function notis_pembatalan_srs_hq(Request $request){
		if(Auth::user()->state_id !== null)
		{
			if($request->ajax()){ 
				$type = $request->type;
				if($type == 'get_daerah') {
					$value = $request->value;
					$where = array('state_id' => $value);
					$data  = RefDaerah::where($where)
							->get();
					return Response::json($data);
				}else if($type == 'get_krt') {
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
				$data = DB::table('srs__permohonan_pembatalan_srs')
							->select('srs__permohonan_pembatalan_srs.id AS id',
									'ref__states.state_description AS state',
									'ref__daerahs.daerah_description AS daerah',
									'krt__profile.krt_nama AS nama_krt',
									'krt__profile.state_id AS state_id',
									'krt__profile.daerah_id AS daerah_id',
									'srs__profile.srs_name AS nama_srs',
									DB::raw(" DATE_FORMAT(srs__profile.diluluskan_date,'%Y') AS tahun_ditubuhkan_srs"),
									'users__profile.user_fullname AS dimohon_oleh',
									'ref__status_srs_pembatalan_srs.status_description AS status',
									'srs__permohonan_pembatalan_srs.pembatalan_status AS pembatalan_status')
							->leftJoin('krt__profile','krt__profile.id','=','srs__permohonan_pembatalan_srs.krt_profile_id')
							->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
							->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
							->leftJoin('srs__profile','srs__profile.id','=','srs__permohonan_pembatalan_srs.srs_profile_id')
							->leftJoin('users__profile','users__profile.user_id','=','srs__permohonan_pembatalan_srs.direkod_by')
							->leftJoin('ref__status_srs_pembatalan_srs','ref__status_srs_pembatalan_srs.id','=','srs__permohonan_pembatalan_srs.pembatalan_status')
							->whereIN('srs__permohonan_pembatalan_srs.pembatalan_status', [1])
							->where('krt__profile.state_id','=',Auth::user()->state_id)
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
				$state          = RefStates::where('status', '=', true)
								->where('state_id','=','10')
								->get();
				$daerah         = RefDaerah::where('status', '=', true)
								->get();
				$krt_profile    = KRT_Profile::where('krt_status', '=', true)
								->get();
				$srs_profile    = SRS_Profile::where('srs_status', '=', true)
								->get();
				return view('rt-sm19.notis-pembatalan-srs-hq',compact('roles_menu','state','daerah','krt_profile','srs_profile'));
			}
		}else
		{
			if($request->ajax()){ 
				$type = $request->type;
				if($type == 'get_daerah') {
					$value = $request->value;
					$where = array('state_id' => $value);
					$data  = RefDaerah::where($where)
							->get();
					return Response::json($data);
				}else if($type == 'get_krt') {
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
				$data = DB::table('srs__permohonan_pembatalan_srs')
							->select('srs__permohonan_pembatalan_srs.id AS id',
									'ref__states.state_description AS state',
									'ref__daerahs.daerah_description AS daerah',
									'krt__profile.krt_nama AS nama_krt',
									'krt__profile.state_id AS state_id',
									'krt__profile.daerah_id AS daerah_id',
									'srs__profile.srs_name AS nama_srs',
									DB::raw(" DATE_FORMAT(srs__profile.diluluskan_date,'%Y') AS tahun_ditubuhkan_srs"),
									'users__profile.user_fullname AS dimohon_oleh',
									'ref__status_srs_pembatalan_srs.status_description AS status',
									'srs__permohonan_pembatalan_srs.pembatalan_status AS pembatalan_status')
							->leftJoin('krt__profile','krt__profile.id','=','srs__permohonan_pembatalan_srs.krt_profile_id')
							->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
							->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
							->leftJoin('srs__profile','srs__profile.id','=','srs__permohonan_pembatalan_srs.srs_profile_id')
							->leftJoin('users__profile','users__profile.user_id','=','srs__permohonan_pembatalan_srs.direkod_by')
							->leftJoin('ref__status_srs_pembatalan_srs','ref__status_srs_pembatalan_srs.id','=','srs__permohonan_pembatalan_srs.pembatalan_status')
							->whereIN('srs__permohonan_pembatalan_srs.pembatalan_status', [1])
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
				$state          = RefStates::where('status', '=', true)
								->get();
				$daerah         = RefDaerah::where('status', '=', true)
								->get();
				$krt_profile    = KRT_Profile::where('krt_status', '=', true)
								->get();
				$srs_profile    = SRS_Profile::where('srs_status', '=', true)
								->get();
				return view('rt-sm19.notis-pembatalan-srs-hq',compact('roles_menu','state','daerah','krt_profile','srs_profile'));
			}
		}
    }

    function permohonan_pembatalan_srs(){
        return view('rt-sm19.permohonan-pembatalan-srs');
    }

    function borang_pembatalan_srs(){
        return view('rt-sm19.borang-pembatalan-srs');
    }

    function semakan_permohonan_pembatalan_srs(){
        return view('rt-sm19.semakan-permohonan-pembatalan-srs');
    }

    function semakan_borang_pembatalan_srs_ppd(){
        return view('rt-sm19.semakan-borang-pembatalan-srs-ppd');
    }

    function pengesahan_permohonan_pembatalan_srs(){
        return view('rt-sm19.pengesahan-permohonan-pembatalan-srs');
    }

    function pengesahan_borang_pembatalan_srs_hq(){
        return view('rt-sm19.pengesahan-borang-pembatalan-srs-hq');
    }

    function jana_notis_pembatalan_srs(){
        return view('rt-sm19.jana-notis-pembatalan-srs');
    }

    function surat_notis_pembatalan_srs(){
        return view('rt-sm19.surat-notis-pembatalan-srs');
    }
}
