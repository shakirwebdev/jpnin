<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect, Response;
use Auth;
use Validator;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\User;
use App\UserProfile;
use App\RefStates;
use App\RefDaerah;
use App\KRT_Profile;
use App\Ref_KRT_Cawangan;
use App\KRT_Ahli_Jawatan_Kuasa_Cawangan;
use App\RefJantina;
use App\RefKaum;
use App\Ref_Status_Perkahwinan;
use App\Ref_Jawatan_Ajk_Cawangan;
use App\RefPendidikan;
use App\KRT_Ahli_Jawatan_Kuasa_Cawangan_Akademik;
use App\KRT_Ahli_Jawatan_Kuasa_Cawangan_Pengalaman;



use DataTables;
use DB;

class RT_SM9Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function tambah_ajk_cawangan_rt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__ahli_jawatan_kuasa_cawangan')
                        ->select('krt__ahli_jawatan_kuasa_cawangan.id',
                                'ref__krt_cawangan.cawangan_description AS jenis_cawangan',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_ic AS ajk_ic',
                                DB::raw(" YEAR(CURDATE()) - YEAR(krt__ahli_jawatan_kuasa_cawangan.ajk_tarikh_lahir) AS age"),
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_tarikh_lahir AS ajk_umur',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_phone AS ajk_phone',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_email AS ajk_email',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_status_form AS ajk_status_form',
                                'ref__status_krt_ajk_cawangan.status_description AS status')
                        ->leftJoin('ref__krt_cawangan','ref__krt_cawangan.id','=','krt__ahli_jawatan_kuasa_cawangan.cawangan_id')
                        ->leftJoin('ref__status_krt_ajk_cawangan','ref__status_krt_ajk_cawangan.id','=','krt__ahli_jawatan_kuasa_cawangan.ajk_status_form')
                        ->orderBy('krt__ahli_jawatan_kuasa_cawangan.id', 'asc')
                        ->whereIn('krt__ahli_jawatan_kuasa_cawangan.ajk_status_form', [3,4,5,7,8,9])
                        ->where('krt__ahli_jawatan_kuasa_cawangan.krt_profile_id', '=', Auth::user()->krt_id)
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
            $cawangan  = Ref_KRT_Cawangan::where('status', '=',  true)->get();
            return view('rt-sm9.tambah-ajk-cawangan-rt', compact('roles_menu','cawangan'));
        }
    }

    function post_tambah_ajk_cawangan_rt(Request $request){
        
        $action = $request->add_tambah_ajk_cawangan_rt;
        
        $rules = array(
           
        );

        $messages = [
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm9.add_tambah_ajk_cawangan_rt',$app_id))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'add') {
                $ajk_cawangan = new KRT_Ahli_Jawatan_Kuasa_Cawangan;
                $ajk_cawangan->krt_profile_id       = Auth::user()->krt_id;
                $ajk_cawangan->ajk_status_form      = 3;
                $ajk_cawangan->save();
            }
           
            return Redirect::to(route('rt-sm9.tambah_ajk_cawangan_rt_1',$ajk_cawangan->id));
        }

    }

    function tambah_ajk_cawangan_rt_1(Request $request, $id){
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
            $ajk_cawangan       = DB::table('krt__ahli_jawatan_kuasa_cawangan')
                                        ->select('krt__ahli_jawatan_kuasa_cawangan.id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.krt_profile_id AS krt_id',
                                                    'krt__profile.krt_nama AS nama_krt',
                                                    'krt__profile.krt_alamat AS alamat_krt',
                                                    'ref__states.state_description AS negeri_krt',
                                                    'ref__parlimens.parlimen_description AS parlimen_krt',
                                                    'ref__pbts.pbt_description AS pbt_krt',
                                                    'ref__daerahs.daerah_description AS daerah_krt', 
                                                    'ref__duns.dun_description AS dun_krt',
                                                    'krt__ahli_jawatan_kuasa_cawangan.cawangan_id AS cawangan_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_nama AS ajk_nama',
                                                    DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa_cawangan.ajk_tarikh_lahir,'%d/%m/%Y') AS ajk_tarikh_lahir"),
                                                    DB::raw(" YEAR(CURDATE()) - YEAR(krt__ahli_jawatan_kuasa_cawangan.ajk_tarikh_lahir) AS age"),
                                                    'krt__ahli_jawatan_kuasa_cawangan.jantina_id AS jantina_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.kaum_id AS kaum_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_ic AS ajk_ic',
                                                    'krt__ahli_jawatan_kuasa_cawangan.status_perkahwinan_id AS status_perkahwinan_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_alamat AS ajk_alamat',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_poskod AS ajk_poskod',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_phone AS ajk_phone',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_email AS ajk_email',
                                                    'krt__ahli_jawatan_kuasa_cawangan.jawatan_cawangan_id AS jawatan_cawangan_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_status_form AS ajk_status_form',
                                                    'ref__status_krt_ajk_cawangan.status_description AS status_description',
                                                    'krt__ahli_jawatan_kuasa_cawangan.disemak_note AS disemak_note',
                                                    'krt__ahli_jawatan_kuasa_cawangan.diakui_note AS diakui_note')
                                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa_cawangan.krt_profile_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                        ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                        ->leftJoin('ref__status_krt_ajk_cawangan','ref__status_krt_ajk_cawangan.id','=','krt__ahli_jawatan_kuasa_cawangan.ajk_status_form')
                                        ->where('krt__ahli_jawatan_kuasa_cawangan.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            $cawangan           = Ref_KRT_Cawangan::where('status', '=',  true)->get();
            $jantina            = RefJantina::where('status', '=',  true)->get();
            $status_perkahwinan = Ref_Status_Perkahwinan::where('status', '=',  true)->get();
            $jawatan_cawangan   = Ref_Jawatan_Ajk_Cawangan::where('status', '=',  true)->get();
            $pendidikan         = RefPendidikan::where('pendidikan_status', '=',  true)->get();
            $kaum               = RefKaum::where('status', '=',  true)->get();
            return view('rt-sm9.tambah-ajk-cawangan-rt-1', compact('roles_menu','ajk_cawangan', 'cawangan','jantina', 'status_perkahwinan', 'jawatan_cawangan', 'pendidikan','kaum'));
        }
    }

    function get_pendidikan_table(Request $request, $id){
        $data = DB::table('krt__ahli_jawatan_kuasa_cawangan_akademik')
                    ->select('krt__ahli_jawatan_kuasa_cawangan_akademik.*','ref__pendidikan.pendidikan_description')
                    ->join('ref__pendidikan','ref__pendidikan.id','=','krt__ahli_jawatan_kuasa_cawangan_akademik.pendidikan_id')
                    ->where('krt__ahli_jawatan_kuasa_cawangan_akademik.krt_ajk_cawangan_id', '=', $id)
                    ->get();
                return Datatables::of($data)
                        ->make(true);
    }

    function post_pendidikan(Request $request){
        $action = $request->add_maklumat_akedemik;
        $app_id = $request->tacr_2_ajk_cawangan_id;
        
        $rules = array(
            'tacr_2_pendidikan_id'                 => 'required',
            'tacr_2_akademik_pencapaian'           => 'required',
            'tacr_2_akademik_tahun'                => 'required'
        );

        $messages = [
            'tacr_2_pendidikan_id.required'        => 'Ruangan tahap pendidikan mesti dipilih',
            'tacr_2_akademik_pencapaian.required'  => 'Ruangan tahun graduasi mesti diisi',
            'tacr_2_akademik_tahun.required'       => 'Ruangan pencapaian mesti diisi',
            
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $pendidikan = new KRT_Ahli_Jawatan_Kuasa_Cawangan_Akademik;
                $pendidikan->krt_ajk_cawangan_id    = $request->tacr_2_ajk_cawangan_id;
                $pendidikan->pendidikan_id          = $request->tacr_2_pendidikan_id;
                $pendidikan->akademik_tahun         = $request->tacr_2_akademik_pencapaian;
                $pendidikan->akademik_pencapaian    = $request->tacr_2_akademik_tahun;
                $pendidikan->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_pendidikans($id){
        $data = DB::table('krt__ahli_jawatan_kuasa_cawangan_akademik')->where('id', '=', $id)->delete();
    }

    function update_ajk_cawangan_rt(Request $request){
        $action = $request->update_ajk_cawangan_rt;
        $app_id = $request->tacr_3_ajk_cawangan_id;
        
        $rules = array(
            'tacr_cawangan_id'              => 'required',
            'tacr_1_ajk_nama'               => 'required',
            'tacr_1_ajk_tarikh_lahir'       => 'required',
            'tacr_1_jantina_id'             => 'required',
            'tacr_1_kaum_id'                => 'required',
            'tacr_1_ajk_ic'                 => 'required|min:11',
            'tacr_1_status_perkahwinan_id'  => 'required',
            'tacr_1_ajk_alamat'             => 'required',
            'tacr_1_ajk_poskod'             => 'required',
            'tacr_1_ajk_phone'              => 'required',
            'tacr_1_ajk_email'              => 'required|email',
            'tacr_1_jawatan_cawangan_id'    => 'required'
        );

        $messages = [
            'tacr_cawangan_id.required'             => 'Ruangan nama cawangan mesti dipilih',
            'tacr_1_ajk_nama.required'              => 'Ruangan nama permohon mesti diisi',
            'tacr_1_ajk_tarikh_lahir.required'      => 'Ruangan tarikh lahir mesti dipilih',
            'tacr_1_jantina_id.required'            => 'Ruangan jantina mesti dipilih',
            'tacr_1_kaum_id.required'               => 'Ruangan kaum mesti dipilih',
            'tacr_1_ajk_ic.required'                => 'Ruangan no kad pengenalan mesti diisi',
            'tacr_1_status_perkahwinan_id.required' => 'Ruangan status perkahwinan mesti dipilih',
            'tacr_1_ajk_alamat.required'            => 'Ruangan alamat mesti diisi',
            'tacr_1_ajk_poskod.required'            => 'Ruangan poskod mesti diisi',
            'tacr_1_ajk_phone.required'             => 'Ruangan no telefon mesti diisi',
            'tacr_1_ajk_email.required'             => 'Ruangan email mesti diisi',
            'tacr_1_ajk_email.email'                => 'Alamat email yang dimasukkan tidah sah',
            'tacr_1_jawatan_cawangan_id.required'   => 'Ruangan jawatan mesti dipilih',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $carbon_obj = Carbon::createFromFormat('d/m/Y', $request->tacr_1_ajk_tarikh_lahir)->format('Y-m-d');
                $where = array('id' => $app_id);
                $ajk_cawangan = KRT_Ahli_Jawatan_Kuasa_Cawangan::where($where)->first();
                $ajk_cawangan->cawangan_id              = $request->tacr_cawangan_id;
                $ajk_cawangan->ajk_nama                 = $request->tacr_1_ajk_nama;
                $ajk_cawangan->ajk_ic                   = $request->tacr_1_ajk_ic;
                $ajk_cawangan->ajk_tarikh_lahir         = $carbon_obj;
                $ajk_cawangan->jantina_id               = $request->tacr_1_jantina_id;
                $ajk_cawangan->kaum_id                  = $request->tacr_1_kaum_id;
                $ajk_cawangan->ajk_alamat               = $request->tacr_1_ajk_alamat;
                $ajk_cawangan->ajk_poskod               = $request->tacr_1_ajk_poskod;
                $ajk_cawangan->ajk_phone                = $request->tacr_1_ajk_phone;
                $ajk_cawangan->ajk_email                = $request->tacr_1_ajk_email;
                $ajk_cawangan->status_perkahwinan_id    = $request->tacr_1_status_perkahwinan_id;
                $ajk_cawangan->jawatan_cawangan_id      = $request->tacr_1_jawatan_cawangan_id;
                $ajk_cawangan->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function tambah_ajk_cawangan_rt_2(Request $request, $id){
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
            $ajk_cawangan       = DB::table('krt__ahli_jawatan_kuasa_cawangan')
                                        ->select('krt__ahli_jawatan_kuasa_cawangan.id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.krt_profile_id AS krt_id',
                                                    'krt__profile.krt_nama AS nama_krt',
                                                    'krt__profile.krt_alamat AS alamat_krt',
                                                    'ref__states.state_description AS negeri_krt',
                                                    'ref__parlimens.parlimen_description AS parlimen_krt',
                                                    'ref__pbts.pbt_description AS pbt_krt',
                                                    'ref__daerahs.daerah_description AS daerah_krt', 
                                                    'ref__duns.dun_description AS dun_krt',
                                                    'krt__ahli_jawatan_kuasa_cawangan.cawangan_id AS cawangan_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.status_perkejaan_id AS status_perkejaan_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_pekerjaan_jawatan AS ajk_pekerjaan_jawatan',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_pekerjaan_bidang AS ajk_pekerjaan_bidang',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_pekerjaan_pengalaman AS ajk_pekerjaan_pengalaman',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_kemahiran AS ajk_kemahiran',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_minat AS ajk_minat',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_status_form AS ajk_status_form',
                                                    'ref__status_krt_ajk_cawangan.status_description AS status_description',
                                                    'krt__ahli_jawatan_kuasa_cawangan.disemak_note AS disemak_note',
                                                    'krt__ahli_jawatan_kuasa_cawangan.diakui_note AS diakui_note')
                                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa_cawangan.krt_profile_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                        ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                        ->leftJoin('ref__status_krt_ajk_cawangan','ref__status_krt_ajk_cawangan.id','=','krt__ahli_jawatan_kuasa_cawangan.ajk_status_form')
                                        ->where('krt__ahli_jawatan_kuasa_cawangan.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            $cawangan           = Ref_KRT_Cawangan::where('status', '=',  true)->get();
            $jantina            = RefJantina::where('status', '=',  true)->get();
            $status_perkahwinan = Ref_Status_Perkahwinan::where('status', '=',  true)->get();
            $jawatan_cawangan   = Ref_Jawatan_Ajk_Cawangan::where('status', '=',  true)->get();
            $pendidikan   = RefPendidikan::where('pendidikan_status', '=',  true)->get();
            return view('rt-sm9.tambah-ajk-cawangan-rt-2', compact('roles_menu','ajk_cawangan', 'cawangan','jantina', 'status_perkahwinan', 'jawatan_cawangan', 'pendidikan'));
        }
    }

    function get_pengalaman_table(Request $request, $id){
        $data = DB::table('krt__ahli_jawatan_kuasa_cawangan_pengalaman')
                    ->select('krt__ahli_jawatan_kuasa_cawangan_pengalaman.*')
                    ->where('krt__ahli_jawatan_kuasa_cawangan_pengalaman.krt_ajk_cawangan_id', '=', $id)
                    ->get();
                return Datatables::of($data)
                        ->make(true);
    }

    function post_pengalaman(Request $request){
        $action = $request->add_maklumat_pengalaman;
        $app_id = $request->tacr_6_ajk_cawangan_id;
        
        $rules = array(
            'tacr_6_pengalaman_tahun'             => 'required',
            'tacr_6_pengalaman_program'           => 'required',
        );

        $messages = [
            'tacr_6_pengalaman_tahun.required'    => 'Ruangan Tahun mesti dipilih',
            'tacr_6_pengalaman_program.required'  => 'Ruangan Program mesti diisi'
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $pengalaman = new KRT_Ahli_Jawatan_Kuasa_Cawangan_Pengalaman;
                $pengalaman->krt_ajk_cawangan_id    = $request->tacr_6_ajk_cawangan_id;
                $pengalaman->pengalaman_tahun       = $request->tacr_6_pengalaman_tahun;
                $pengalaman->pengalaman_program     = $request->tacr_6_pengalaman_program;
                $pengalaman->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_pengalaman($id){
        $data = DB::table('krt__ahli_jawatan_kuasa_cawangan_pengalaman')->where('id', '=', $id)->delete();
    }

    function update_ajk_cawangan_rt_2(Request $request){
        $action = $request->update_ajk_cawangan_rt_2;
        $app_id = $request->tacr_8_ajk_cawangan_id;
        $status_pekerjaan = $request->tacr_4_status_perkejaan_id;
        $rules_main = array(
            'tacr_4_status_perkejaan_id'            => 'required',
            'tacr_4_ajk_kemahiran'                  => 'required',
            'tacr_4_ajk_minat'                      => 'required',
        );

        if ($status_pekerjaan == '1') {
            $rules_second = array(                
                'tacr_4_ajk_pekerjaan_jawatan'      => 'required',
                'tacr_4_ajk_pekerjaan_bidang'       => 'required',
                'tacr_4_ajk_pekerjaan_pengalaman'   => 'required',
            );
        } else {
            $rules_second = array(
                'tacr_4_status_perkejaan_id'   => 'required',
            );
        }
        
        $messages = [
            'tacr_4_status_perkejaan_id.required'       => 'Ruangan status pekerjaan mesti dipilih',
            'tacr_4_ajk_pekerjaan_jawatan.required'     => 'Ruangan jawatan mesti diisi',
            'tacr_4_ajk_pekerjaan_bidang.required'      => 'Ruangan bidang mesti diisi',
            'tacr_4_ajk_pekerjaan_pengalaman.required'  => 'Ruangan pengalaman pekerjaan dan skop penglibatan mesti diisi',
            'tacr_4_ajk_kemahiran.required'             => 'Ruangan kemahiran mesti diisi',
            'tacr_4_ajk_minat.required'                 => 'Ruangan minat mesti diisi'
        ];

        $rules = $rules_main + $rules_second;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $ajk_cawangan_2 = KRT_Ahli_Jawatan_Kuasa_Cawangan::where($where)->first();
                $ajk_cawangan_2->status_perkejaan_id          = $request->tacr_4_status_perkejaan_id;
                $ajk_cawangan_2->ajk_pekerjaan_jawatan        = $request->tacr_4_ajk_pekerjaan_jawatan;
                $ajk_cawangan_2->ajk_pekerjaan_bidang         = $request->tacr_4_ajk_pekerjaan_bidang;
                $ajk_cawangan_2->ajk_pekerjaan_pengalaman     = $request->tacr_4_ajk_pekerjaan_pengalaman;
                $ajk_cawangan_2->ajk_kemahiran                = $request->tacr_4_ajk_kemahiran;
                $ajk_cawangan_2->ajk_minat                    = $request->tacr_4_ajk_minat;
                $ajk_cawangan_2->ajk_status_form              = 4;
                $ajk_cawangan_2->direkod_by                   = Auth::user()->user_id;
                $ajk_cawangan_2->direkod_date                 = date('Y-m-d H:i:s');
                $ajk_cawangan_2->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function menyemak_ajk_cawangan_rt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__ahli_jawatan_kuasa_cawangan')
                        ->select('krt__ahli_jawatan_kuasa_cawangan.id',
                                'ref__krt_cawangan.cawangan_description AS jenis_cawangan',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_ic AS ajk_ic',
                                DB::raw(" YEAR(CURDATE()) - YEAR(krt__ahli_jawatan_kuasa_cawangan.ajk_tarikh_lahir) AS age"),
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_tarikh_lahir AS ajk_umur',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_phone AS ajk_phone',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_email AS ajk_email',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_status_form AS ajk_status_form')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa_cawangan.krt_profile_id')
                        ->leftJoin('ref__krt_cawangan','ref__krt_cawangan.id','=','krt__ahli_jawatan_kuasa_cawangan.cawangan_id')
                        ->orderBy('krt__ahli_jawatan_kuasa_cawangan.id', 'asc')
                        ->where('krt__ahli_jawatan_kuasa_cawangan.ajk_status_form', '=', 4)
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
            $cawangan  = Ref_KRT_Cawangan::where('status', '=',  true)->get();
            return view('rt-sm9.menyemak-ajk-cawangan-rt', compact('roles_menu','cawangan'));
        }
    }

    function menyemak_ajk_cawangan_rt_1_ppd(Request $request, $id){
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
            $ajk_cawangan       = DB::table('krt__ahli_jawatan_kuasa_cawangan')
                                        ->select('krt__ahli_jawatan_kuasa_cawangan.id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.krt_profile_id AS krt_id',
                                                    'krt__profile.krt_nama AS nama_krt',
                                                    'krt__profile.krt_alamat AS alamat_krt',
                                                    'ref__states.state_description AS negeri_krt',
                                                    'ref__parlimens.parlimen_description AS parlimen_krt',
                                                    'ref__pbts.pbt_description AS pbt_krt',
                                                    'ref__daerahs.daerah_description AS daerah_krt', 
                                                    'ref__duns.dun_description AS dun_krt',
                                                    'krt__ahli_jawatan_kuasa_cawangan.cawangan_id AS cawangan_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_nama AS ajk_nama',
                                                    DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa_cawangan.ajk_tarikh_lahir,'%d/%m/%Y') AS ajk_tarikh_lahir"),
                                                    'krt__ahli_jawatan_kuasa_cawangan.jantina_id AS jantina_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.kaum_id AS kaum_id',
                                                    DB::raw(" YEAR(CURDATE()) - YEAR(krt__ahli_jawatan_kuasa_cawangan.ajk_tarikh_lahir) AS age"),
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_ic AS ajk_ic',
                                                    'krt__ahli_jawatan_kuasa_cawangan.status_perkahwinan_id AS status_perkahwinan_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_alamat AS ajk_alamat',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_poskod AS ajk_poskod',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_phone AS ajk_phone',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_email AS ajk_email',
                                                    'krt__ahli_jawatan_kuasa_cawangan.jawatan_cawangan_id AS jawatan_cawangan_id')
                                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa_cawangan.krt_profile_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                        ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                        ->where('krt__ahli_jawatan_kuasa_cawangan.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            $cawangan           = Ref_KRT_Cawangan::where('status', '=',  true)->get();
            $jantina            = RefJantina::where('status', '=',  true)->get();
            $status_perkahwinan = Ref_Status_Perkahwinan::where('status', '=',  true)->get();
            $jawatan_cawangan   = Ref_Jawatan_Ajk_Cawangan::where('status', '=',  true)->get();
            $pendidikan         = RefPendidikan::where('pendidikan_status', '=',  true)->get();
            $kaum               = RefKaum::where('status', '=',  true)->get();
            return view('rt-sm9.menyemak-ajk-cawangan-rt-1-ppd', compact('roles_menu','ajk_cawangan', 'cawangan','jantina', 'status_perkahwinan', 'jawatan_cawangan', 'pendidikan', 'kaum'));
        }
    }

    function menyemak_ajk_cawangan_rt_2_ppd(Request $request, $id){
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
            $ajk_cawangan       = DB::table('krt__ahli_jawatan_kuasa_cawangan')
                                        ->select('krt__ahli_jawatan_kuasa_cawangan.id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.krt_profile_id AS krt_id',
                                                    'krt__profile.krt_nama AS nama_krt',
                                                    'krt__profile.krt_alamat AS alamat_krt',
                                                    'ref__states.state_description AS negeri_krt',
                                                    'ref__parlimens.parlimen_description AS parlimen_krt',
                                                    'ref__pbts.pbt_description AS pbt_krt',
                                                    'ref__daerahs.daerah_description AS daerah_krt', 
                                                    'ref__duns.dun_description AS dun_krt',
                                                    'krt__ahli_jawatan_kuasa_cawangan.cawangan_id AS cawangan_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.status_perkejaan_id AS status_perkejaan_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_pekerjaan_jawatan AS ajk_pekerjaan_jawatan',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_pekerjaan_bidang AS ajk_pekerjaan_bidang',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_pekerjaan_pengalaman AS ajk_pekerjaan_pengalaman',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_kemahiran AS ajk_kemahiran',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_minat AS ajk_minat')
                                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa_cawangan.krt_profile_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                        ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                        ->where('krt__ahli_jawatan_kuasa_cawangan.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            $cawangan           = Ref_KRT_Cawangan::where('status', '=',  true)->get();
            $jantina            = RefJantina::where('status', '=',  true)->get();
            $status_perkahwinan = Ref_Status_Perkahwinan::where('status', '=',  true)->get();
            $jawatan_cawangan   = Ref_Jawatan_Ajk_Cawangan::where('status', '=',  true)->get();
            $pendidikan   = RefPendidikan::where('pendidikan_status', '=',  true)->get();
            return view('rt-sm9.menyemak-ajk-cawangan-rt-2-ppd', compact('roles_menu','ajk_cawangan', 'cawangan','jantina', 'status_perkahwinan', 'jawatan_cawangan', 'pendidikan'));
        }
    }

    function post_semakan_ajk_cawangan_rt_ppd(Request $request){
        $action = $request->post_semakan_ajk_cawangan_rt_ppd;
        $app_id = $request->macr_ppd_3_ajk_cawangan_id;
        $status = $request->macr_ppd_3_ajk_status_form;
        
        $rules = array(
            'macr_ppd_3_ajk_status_form'             => 'required',
            'macr_ppd_3_disemak_note'                => 'required',
        );

        $messages = [
            'macr_ppd_3_ajk_status_form.required'    => 'Ruangan Status mesti dipilih',
            'macr_ppd_3_disemak_note.required'       => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $semakan_ajk_cawangan                         = KRT_Ahli_Jawatan_Kuasa_Cawangan::where($where)->first();
                $semakan_ajk_cawangan->ajk_status_form        = $request->macr_ppd_3_ajk_status_form;
                $semakan_ajk_cawangan->disemak_note           = $request->macr_ppd_3_disemak_note;
                $semakan_ajk_cawangan->disemak_by             = Auth::user()->user_id;
                $semakan_ajk_cawangan->disemak_date           = date('Y-m-d H:i:s');
                $semakan_ajk_cawangan->save();

            }
        }
    }

    function memperakui_ajk_cawangan_rt_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__ahli_jawatan_kuasa_cawangan')
                        ->select('krt__ahli_jawatan_kuasa_cawangan.id',
                                'ref__krt_cawangan.cawangan_description AS jenis_cawangan',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_ic AS ajk_ic',
                                DB::raw(" YEAR(CURDATE()) - YEAR(krt__ahli_jawatan_kuasa_cawangan.ajk_tarikh_lahir) AS age"),
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_tarikh_lahir AS ajk_umur',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_phone AS ajk_phone',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_email AS ajk_email',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_status_form AS ajk_status_form')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa_cawangan.krt_profile_id')
                        ->leftJoin('ref__krt_cawangan','ref__krt_cawangan.id','=','krt__ahli_jawatan_kuasa_cawangan.cawangan_id')
                        ->orderBy('krt__ahli_jawatan_kuasa_cawangan.id', 'asc')
                        ->where('krt__ahli_jawatan_kuasa_cawangan.ajk_status_form', '=', 5)
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
            $cawangan  = Ref_KRT_Cawangan::where('status', '=',  true)->get();
            return view('rt-sm9.memperakui-ajk-cawangan-rt-ppn', compact('roles_menu','cawangan'));
        }
    }

    function memperakui_ajk_cawangan_rt_ppn_1(Request $request, $id){
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
            $ajk_cawangan       = DB::table('krt__ahli_jawatan_kuasa_cawangan')
                                        ->select('krt__ahli_jawatan_kuasa_cawangan.id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.krt_profile_id AS krt_id',
                                                    'krt__profile.krt_nama AS nama_krt',
                                                    'krt__profile.krt_alamat AS alamat_krt',
                                                    'ref__states.state_description AS negeri_krt',
                                                    'ref__parlimens.parlimen_description AS parlimen_krt',
                                                    'ref__pbts.pbt_description AS pbt_krt',
                                                    'ref__daerahs.daerah_description AS daerah_krt', 
                                                    'ref__duns.dun_description AS dun_krt',
                                                    'krt__ahli_jawatan_kuasa_cawangan.cawangan_id AS cawangan_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_nama AS ajk_nama',
                                                    DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa_cawangan.ajk_tarikh_lahir,'%d/%m/%Y') AS ajk_tarikh_lahir"),
                                                    'krt__ahli_jawatan_kuasa_cawangan.jantina_id AS jantina_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.kaum_id AS kaum_id',
                                                    DB::raw(" YEAR(CURDATE()) - YEAR(krt__ahli_jawatan_kuasa_cawangan.ajk_tarikh_lahir) AS age"),
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_ic AS ajk_ic',
                                                    'krt__ahli_jawatan_kuasa_cawangan.status_perkahwinan_id AS status_perkahwinan_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_alamat AS ajk_alamat',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_poskod AS ajk_poskod',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_phone AS ajk_phone',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_email AS ajk_email',
                                                    'krt__ahli_jawatan_kuasa_cawangan.jawatan_cawangan_id AS jawatan_cawangan_id')
                                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa_cawangan.krt_profile_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                        ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                        ->where('krt__ahli_jawatan_kuasa_cawangan.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            $cawangan           = Ref_KRT_Cawangan::where('status', '=',  true)->get();
            $jantina            = RefJantina::where('status', '=',  true)->get();
            $status_perkahwinan = Ref_Status_Perkahwinan::where('status', '=',  true)->get();
            $jawatan_cawangan   = Ref_Jawatan_Ajk_Cawangan::where('status', '=',  true)->get();
            $pendidikan         = RefPendidikan::where('pendidikan_status', '=',  true)->get();
            $kaum               = RefKaum::where('status', '=',  true)->get();
            return view('rt-sm9.memperakui-ajk-cawangan-rt-ppn-1', compact('roles_menu','ajk_cawangan', 'cawangan','jantina', 'status_perkahwinan', 'jawatan_cawangan', 'pendidikan', 'kaum'));
        }
    }

    function memperakui_ajk_cawangan_rt_ppn_2(Request $request, $id){
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
            $ajk_cawangan       = DB::table('krt__ahli_jawatan_kuasa_cawangan')
                                        ->select('krt__ahli_jawatan_kuasa_cawangan.id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.krt_profile_id AS krt_id',
                                                    'krt__profile.krt_nama AS nama_krt',
                                                    'krt__profile.krt_alamat AS alamat_krt',
                                                    'ref__states.state_description AS negeri_krt',
                                                    'ref__parlimens.parlimen_description AS parlimen_krt',
                                                    'ref__pbts.pbt_description AS pbt_krt',
                                                    'ref__daerahs.daerah_description AS daerah_krt', 
                                                    'ref__duns.dun_description AS dun_krt',
                                                    'krt__ahli_jawatan_kuasa_cawangan.cawangan_id AS cawangan_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.status_perkejaan_id AS status_perkejaan_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_pekerjaan_jawatan AS ajk_pekerjaan_jawatan',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_pekerjaan_bidang AS ajk_pekerjaan_bidang',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_pekerjaan_pengalaman AS ajk_pekerjaan_pengalaman',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_kemahiran AS ajk_kemahiran',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_minat AS ajk_minat')
                                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa_cawangan.krt_profile_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                        ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                        ->where('krt__ahli_jawatan_kuasa_cawangan.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            $cawangan           = Ref_KRT_Cawangan::where('status', '=',  true)->get();
            $jantina            = RefJantina::where('status', '=',  true)->get();
            $status_perkahwinan = Ref_Status_Perkahwinan::where('status', '=',  true)->get();
            $jawatan_cawangan   = Ref_Jawatan_Ajk_Cawangan::where('status', '=',  true)->get();
            $pendidikan   = RefPendidikan::where('pendidikan_status', '=',  true)->get();
            return view('rt-sm9.memperakui-ajk-cawangan-rt-ppn-2', compact('roles_menu','ajk_cawangan', 'cawangan','jantina', 'status_perkahwinan', 'jawatan_cawangan', 'pendidikan'));
        }
    }

    function post_akui_ajk_cawangan_rt_ppd(Request $request){
        $action = $request->post_akui_ajk_cawangan_rt_ppd;
        $app_id = $request->macr_ppn_3_ajk_cawangan_id;
        $ajk_status_form = $request->macr_ppn_3_ajk_status_form;

        $rules = array(
            'macr_ppn_3_ajk_status_form'             => 'required',
            'macr_ppn_3_diakui_note'                => 'required',
        );

        $messages = [
            'macr_ppn_3_ajk_status_form.required'    => 'Ruangan Status mesti dipilih',
            'macr_ppn_3_diakui_note.required'       => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $akui_ajk_cawangan                         = KRT_Ahli_Jawatan_Kuasa_Cawangan::where($where)->first();
                $akui_ajk_cawangan->ajk_status_form        = $request->macr_ppn_3_ajk_status_form;
                $akui_ajk_cawangan->diakui_note            = $request->macr_ppn_3_diakui_note;
                $akui_ajk_cawangan->diakui_by              = Auth::user()->user_id;
                $akui_ajk_cawangan->diakui_date            = date('Y-m-d H:i:s');
                $akui_ajk_cawangan->save();

                if($ajk_status_form == '6'){
                    $where1 = array('id' => $app_id);
                    $akui_ajk_cawangan                     = KRT_Ahli_Jawatan_Kuasa_Cawangan::where($where1)->first();
                    $akui_ajk_cawangan->ajk_status         = 1;
                    $akui_ajk_cawangan->save();
                }
            }
        }
    }

    function senarai_ajk_cawangan_rt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__ahli_jawatan_kuasa_cawangan')
                        ->select('krt__ahli_jawatan_kuasa_cawangan.id',
                                'ref__daerahs.daerah_description AS daerah',
                                'ref__krt_cawangan.cawangan_description AS jenis_cawangan',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_ic AS ajk_ic',
                                DB::raw(" YEAR(CURDATE()) - YEAR(krt__ahli_jawatan_kuasa_cawangan.ajk_tarikh_lahir) AS age"),
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_tarikh_lahir AS ajk_umur',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_phone AS ajk_phone',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_email AS ajk_email',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_status AS ajk_status',
                                'ref__status_krt_ajk_cawangan.status_description AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa_cawangan.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__krt_cawangan','ref__krt_cawangan.id','=','krt__ahli_jawatan_kuasa_cawangan.cawangan_id')
                        ->leftJoin('ref__status_krt_ajk_cawangan','ref__status_krt_ajk_cawangan.id','=','krt__ahli_jawatan_kuasa_cawangan.ajk_status')
                        ->orderBy('krt__ahli_jawatan_kuasa_cawangan.id', 'asc')
                        ->whereIn('krt__ahli_jawatan_kuasa_cawangan.ajk_status', [1,2])
                        ->where('krt__ahli_jawatan_kuasa_cawangan.krt_profile_id', '=', Auth::user()->krt_id)
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
            $cawangan  = Ref_KRT_Cawangan::where('status', '=',  true)->get();
            return view('rt-sm9.senarai-ajk-cawangan-rt', compact('roles_menu','cawangan'));
        }
    }

    function view_ajk_cawangan_rt(Request $request, $id){
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
            $ajk_cawangan       = DB::table('krt__ahli_jawatan_kuasa_cawangan')
                                        ->select('krt__ahli_jawatan_kuasa_cawangan.id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.krt_profile_id AS krt_id',
                                                    'krt__profile.krt_nama AS nama_krt',
                                                    'krt__profile.krt_alamat AS alamat_krt',
                                                    'ref__states.state_description AS negeri_krt',
                                                    'ref__parlimens.parlimen_description AS parlimen_krt',
                                                    'ref__pbts.pbt_description AS pbt_krt',
                                                    'ref__daerahs.daerah_description AS daerah_krt', 
                                                    'ref__duns.dun_description AS dun_krt',
                                                    'krt__ahli_jawatan_kuasa_cawangan.cawangan_id AS cawangan_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_nama AS ajk_nama',
                                                    DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa_cawangan.ajk_tarikh_lahir,'%d/%m/%Y') AS ajk_tarikh_lahir"),
                                                    'krt__ahli_jawatan_kuasa_cawangan.jantina_id AS jantina_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_ic AS ajk_ic',
                                                    'krt__ahli_jawatan_kuasa_cawangan.status_perkahwinan_id AS status_perkahwinan_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_alamat AS ajk_alamat',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_poskod AS ajk_poskod',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_phone AS ajk_phone',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_email AS ajk_email',
                                                    'krt__ahli_jawatan_kuasa_cawangan.jawatan_cawangan_id AS jawatan_cawangan_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_status AS ajk_status')
                                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa_cawangan.krt_profile_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                        ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                        ->where('krt__ahli_jawatan_kuasa_cawangan.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            $cawangan           = Ref_KRT_Cawangan::where('status', '=',  true)->get();
            $jantina            = RefJantina::where('status', '=',  true)->get();
            $status_perkahwinan = Ref_Status_Perkahwinan::where('status', '=',  true)->get();
            $jawatan_cawangan   = Ref_Jawatan_Ajk_Cawangan::where('status', '=',  true)->get();
            $pendidikan   = RefPendidikan::where('pendidikan_status', '=',  true)->get();
            return view('rt-sm9.view-ajk-cawangan-rt', compact('roles_menu','ajk_cawangan', 'cawangan','jantina', 'status_perkahwinan', 'jawatan_cawangan', 'pendidikan'));
        }
    }

    function view_ajk_cawangan_rt_1(Request $request, $id){
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
            $ajk_cawangan       = DB::table('krt__ahli_jawatan_kuasa_cawangan')
                                        ->select('krt__ahli_jawatan_kuasa_cawangan.id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.krt_profile_id AS krt_id',
                                                    'krt__profile.krt_nama AS nama_krt',
                                                    'krt__profile.krt_alamat AS alamat_krt',
                                                    'ref__states.state_description AS negeri_krt',
                                                    'ref__parlimens.parlimen_description AS parlimen_krt',
                                                    'ref__pbts.pbt_description AS pbt_krt',
                                                    'ref__daerahs.daerah_description AS daerah_krt', 
                                                    'ref__duns.dun_description AS dun_krt',
                                                    'krt__ahli_jawatan_kuasa_cawangan.cawangan_id AS cawangan_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.status_perkejaan_id AS status_perkejaan_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_pekerjaan_jawatan AS ajk_pekerjaan_jawatan',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_pekerjaan_bidang AS ajk_pekerjaan_bidang',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_pekerjaan_pengalaman AS ajk_pekerjaan_pengalaman',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_kemahiran AS ajk_kemahiran',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_minat AS ajk_minat',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_status AS ajk_status')
                                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa_cawangan.krt_profile_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                        ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                        ->where('krt__ahli_jawatan_kuasa_cawangan.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            $cawangan           = Ref_KRT_Cawangan::where('status', '=',  true)->get();
            $jantina            = RefJantina::where('status', '=',  true)->get();
            $status_perkahwinan = Ref_Status_Perkahwinan::where('status', '=',  true)->get();
            $jawatan_cawangan   = Ref_Jawatan_Ajk_Cawangan::where('status', '=',  true)->get();
            $pendidikan   = RefPendidikan::where('pendidikan_status', '=',  true)->get();
            return view('rt-sm9.view-ajk-cawangan-rt-1', compact('roles_menu','ajk_cawangan', 'cawangan','jantina', 'status_perkahwinan', 'jawatan_cawangan', 'pendidikan'));
        }
    }

    function post_kemaskini_status_ajk(Request $request){
        $action = $request->post_kemaskini_status_ajk;
        $app_id = $request->vacr1_ajk_cawangan_id;
        
        $rules = array(
            'vacr1_ajk_status'                  => 'required',
        );

        $messages = [
            'vacr1_ajk_status.required'         => 'Ruangan Status mesti dipilih'
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $kemaskini_status_cawangan_krt                  = KRT_Ahli_Jawatan_Kuasa_Cawangan::where($where)->first();
                $kemaskini_status_cawangan_krt->ajk_status      = $request->vacr1_ajk_status;
                $kemaskini_status_cawangan_krt->save();
            }
        }
    }

    function senarai_ajk_cawangan_rt_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__ahli_jawatan_kuasa_cawangan')
                        ->select('krt__ahli_jawatan_kuasa_cawangan.id',
                                'krt__profile.krt_nama AS krt_nama',
                                'ref__daerahs.daerah_description AS krt_daerah',
                                'ref__krt_cawangan.cawangan_description AS jenis_cawangan',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_ic AS ajk_ic',
                                DB::raw(" YEAR(CURDATE()) - YEAR(krt__ahli_jawatan_kuasa_cawangan.ajk_tarikh_lahir) AS age"),
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_tarikh_lahir AS ajk_umur',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_phone AS ajk_phone',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_email AS ajk_email',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_status AS ajk_status',
                                'ref__status_krt_ajk_cawangan.status_description AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa_cawangan.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__krt_cawangan','ref__krt_cawangan.id','=','krt__ahli_jawatan_kuasa_cawangan.cawangan_id')
                        ->leftJoin('ref__status_krt_ajk_cawangan','ref__status_krt_ajk_cawangan.id','=','krt__ahli_jawatan_kuasa_cawangan.ajk_status')
                        ->orderBy('krt__ahli_jawatan_kuasa_cawangan.id', 'asc')
                        ->where('krt__ahli_jawatan_kuasa_cawangan.ajk_status', '=', 1)
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
            $cawangan       = Ref_KRT_Cawangan::where('status', '=',  true)->get();
            $senarai_krt    = KRT_Profile::where('daerah_id', '=', Auth::user()->daerah_id)
                            ->where('krt__profile.krt_status', '=', true)
                            ->get();
            return view('rt-sm9.senarai-ajk-cawangan-rt-ppd', compact('roles_menu','cawangan', 'senarai_krt'));
        }
    }

    function view_ajk_cawangan_rt_ppd(Request $request, $id){
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
            $ajk_cawangan       = DB::table('krt__ahli_jawatan_kuasa_cawangan')
                                        ->select('krt__ahli_jawatan_kuasa_cawangan.id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.krt_profile_id AS krt_id',
                                                    'krt__profile.krt_nama AS nama_krt',
                                                    'krt__profile.krt_alamat AS alamat_krt',
                                                    'ref__states.state_description AS negeri_krt',
                                                    'ref__parlimens.parlimen_description AS parlimen_krt',
                                                    'ref__pbts.pbt_description AS pbt_krt',
                                                    'ref__daerahs.daerah_description AS daerah_krt', 
                                                    'ref__duns.dun_description AS dun_krt',
                                                    'krt__ahli_jawatan_kuasa_cawangan.cawangan_id AS cawangan_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_nama AS ajk_nama',
                                                    DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa_cawangan.ajk_tarikh_lahir,'%d/%m/%Y') AS ajk_tarikh_lahir"),
                                                    'krt__ahli_jawatan_kuasa_cawangan.jantina_id AS jantina_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_ic AS ajk_ic',
                                                    'krt__ahli_jawatan_kuasa_cawangan.status_perkahwinan_id AS status_perkahwinan_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_alamat AS ajk_alamat',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_poskod AS ajk_poskod',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_phone AS ajk_phone',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_email AS ajk_email',
                                                    'krt__ahli_jawatan_kuasa_cawangan.jawatan_cawangan_id AS jawatan_cawangan_id')
                                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa_cawangan.krt_profile_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                        ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                        ->where('krt__ahli_jawatan_kuasa_cawangan.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            $cawangan           = Ref_KRT_Cawangan::where('status', '=',  true)->get();
            $jantina            = RefJantina::where('status', '=',  true)->get();
            $status_perkahwinan = Ref_Status_Perkahwinan::where('status', '=',  true)->get();
            $jawatan_cawangan   = Ref_Jawatan_Ajk_Cawangan::where('status', '=',  true)->get();
            $pendidikan   = RefPendidikan::where('pendidikan_status', '=',  true)->get();
            return view('rt-sm9.view-ajk-cawangan-rt-ppd', compact('roles_menu','ajk_cawangan', 'cawangan','jantina', 'status_perkahwinan', 'jawatan_cawangan', 'pendidikan'));
        }
    }

    function view_ajk_cawangan_rt_ppd_1(Request $request, $id){
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
            $ajk_cawangan       = DB::table('krt__ahli_jawatan_kuasa_cawangan')
                                        ->select('krt__ahli_jawatan_kuasa_cawangan.id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.krt_profile_id AS krt_id',
                                                    'krt__profile.krt_nama AS nama_krt',
                                                    'krt__profile.krt_alamat AS alamat_krt',
                                                    'ref__states.state_description AS negeri_krt',
                                                    'ref__parlimens.parlimen_description AS parlimen_krt',
                                                    'ref__pbts.pbt_description AS pbt_krt',
                                                    'ref__daerahs.daerah_description AS daerah_krt', 
                                                    'ref__duns.dun_description AS dun_krt',
                                                    'krt__ahli_jawatan_kuasa_cawangan.cawangan_id AS cawangan_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.status_perkejaan_id AS status_perkejaan_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_pekerjaan_jawatan AS ajk_pekerjaan_jawatan',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_pekerjaan_bidang AS ajk_pekerjaan_bidang',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_pekerjaan_pengalaman AS ajk_pekerjaan_pengalaman',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_kemahiran AS ajk_kemahiran',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_minat AS ajk_minat')
                                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa_cawangan.krt_profile_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                        ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                        ->where('krt__ahli_jawatan_kuasa_cawangan.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            $cawangan           = Ref_KRT_Cawangan::where('status', '=',  true)->get();
            $jantina            = RefJantina::where('status', '=',  true)->get();
            $status_perkahwinan = Ref_Status_Perkahwinan::where('status', '=',  true)->get();
            $jawatan_cawangan   = Ref_Jawatan_Ajk_Cawangan::where('status', '=',  true)->get();
            $pendidikan   = RefPendidikan::where('pendidikan_status', '=',  true)->get();
            return view('rt-sm9.view-ajk-cawangan-rt-ppd-1', compact('roles_menu','ajk_cawangan', 'cawangan','jantina', 'status_perkahwinan', 'jawatan_cawangan', 'pendidikan'));
        }
    }

    function senarai_ajk_cawangan_rt_ppn(Request $request){
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
            $data = DB::table('krt__ahli_jawatan_kuasa_cawangan')
                        ->select('krt__ahli_jawatan_kuasa_cawangan.id',
                                'krt__profile.krt_nama AS krt_nama',
                                'ref__daerahs.daerah_description AS krt_daerah',
                                'ref__krt_cawangan.cawangan_description AS jenis_cawangan',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_ic AS ajk_ic',
                                DB::raw(" YEAR(CURDATE()) - YEAR(krt__ahli_jawatan_kuasa_cawangan.ajk_tarikh_lahir) AS age"),
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_tarikh_lahir AS ajk_umur',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_phone AS ajk_phone',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_email AS ajk_email',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_status AS ajk_status',
                                'ref__status_krt_ajk_cawangan.status_description AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa_cawangan.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__krt_cawangan','ref__krt_cawangan.id','=','krt__ahli_jawatan_kuasa_cawangan.cawangan_id')
                        ->leftJoin('ref__status_krt_ajk_cawangan','ref__status_krt_ajk_cawangan.id','=','krt__ahli_jawatan_kuasa_cawangan.ajk_status')
                        ->orderBy('krt__ahli_jawatan_kuasa_cawangan.id', 'asc')
                        ->where('krt__ahli_jawatan_kuasa_cawangan.ajk_status', '=', 1)
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
            $cawangan        = Ref_KRT_Cawangan::where('status', '=',  true)->get();
            $senarai_daerah  = RefDaerah::where('state_id', '=', Auth::user()->state_id)->get();
            $senarai_krt     = KRT_Profile::where('state_id', '=', Auth::user()->state_id)->get();
            return view('rt-sm9.senarai-ajk-cawangan-rt-ppn', compact('roles_menu','cawangan', 'senarai_daerah', 'senarai_krt'));
        }
    }

    function tambah_ajk_cawangan_rt_admin(Request $request){
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
                $data  = KRT_Profile::where($where)->get();
                return Response::json($data);
            }
            $data = DB::table('krt__ahli_jawatan_kuasa_cawangan')
                        ->select('krt__ahli_jawatan_kuasa_cawangan.id',
                                'ref__states.state_description AS krt_state',
                                'ref__daerahs.daerah_description AS krt_daerah',
                                'krt__profile.krt_nama AS krt_nama',
                                'ref__krt_cawangan.cawangan_description AS jenis_cawangan',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_ic AS ajk_ic',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_tarikh_lahir AS ajk_umur',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_phone AS ajk_phone',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_email AS ajk_email',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_status_form AS ajk_status_form',
                                'ref__status_krt_ajk_cawangan.status_description AS status')
                        ->leftJoin('ref__krt_cawangan','ref__krt_cawangan.id','=','krt__ahli_jawatan_kuasa_cawangan.cawangan_id')
                        ->leftJoin('ref__status_krt_ajk_cawangan','ref__status_krt_ajk_cawangan.id','=','krt__ahli_jawatan_kuasa_cawangan.ajk_status_form')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa_cawangan.krt_profile_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->orderBy('krt__ahli_jawatan_kuasa_cawangan.id', 'asc')
                        ->whereIn('krt__ahli_jawatan_kuasa_cawangan.ajk_status_form', [3,4,5])
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
            $daerah     = RefDaerah::where('status', '=',  true)->get();
            $krt        = KRT_Profile::where('krt_status', '=', true)->get();
            $cawangan   = Ref_KRT_Cawangan::where('status', '=',  true)->get();
            return view('rt-sm9.tambah-ajk-cawangan-rt-admin', compact('roles_menu','state','daerah','krt','cawangan'));
        }
    }

    function menyemak_ajk_cawangan_rt_admin(Request $request){
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
                $data  = KRT_Profile::where($where)->get();
                return Response::json($data);
            }
            $data = DB::table('krt__ahli_jawatan_kuasa_cawangan')
                        ->select('krt__ahli_jawatan_kuasa_cawangan.id',
                                'ref__states.state_description AS krt_state',
                                'ref__daerahs.daerah_description AS krt_daerah',
                                'krt__profile.krt_nama AS krt_nama',
                                'ref__krt_cawangan.cawangan_description AS jenis_cawangan',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_ic AS ajk_ic',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_tarikh_lahir AS ajk_umur',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_phone AS ajk_phone',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_email AS ajk_email',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_status_form AS ajk_status_form',
                                'ref__status_krt_ajk_cawangan.status_description AS status')
                        ->leftJoin('ref__krt_cawangan','ref__krt_cawangan.id','=','krt__ahli_jawatan_kuasa_cawangan.cawangan_id')
                        ->leftJoin('ref__status_krt_ajk_cawangan','ref__status_krt_ajk_cawangan.id','=','krt__ahli_jawatan_kuasa_cawangan.ajk_status_form')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa_cawangan.krt_profile_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->orderBy('krt__ahli_jawatan_kuasa_cawangan.id', 'asc')
                        ->where('krt__ahli_jawatan_kuasa_cawangan.ajk_status_form', '=', 4)
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
            $daerah     = RefDaerah::where('status', '=',  true)->get();
            $krt        = KRT_Profile::where('krt_status', '=', true)->get();
            $cawangan   = Ref_KRT_Cawangan::where('status', '=',  true)->get();
            return view('rt-sm9.menyemak-ajk-cawangan-rt-admin', compact('roles_menu','state','daerah','krt','cawangan'));
        }
    }

    function memperakui_ajk_cawangan_rt_admin(Request $request){
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
                $data  = KRT_Profile::where($where)->get();
                return Response::json($data);
            }
            $data = DB::table('krt__ahli_jawatan_kuasa_cawangan')
                        ->select('krt__ahli_jawatan_kuasa_cawangan.id',
                                'ref__states.state_description AS krt_state',
                                'ref__daerahs.daerah_description AS krt_daerah',
                                'krt__profile.krt_nama AS krt_nama',
                                'ref__krt_cawangan.cawangan_description AS jenis_cawangan',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_ic AS ajk_ic',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_tarikh_lahir AS ajk_umur',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_phone AS ajk_phone',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_email AS ajk_email',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_status_form AS ajk_status_form',
                                'ref__status_krt_ajk_cawangan.status_description AS status')
                        ->leftJoin('ref__krt_cawangan','ref__krt_cawangan.id','=','krt__ahli_jawatan_kuasa_cawangan.cawangan_id')
                        ->leftJoin('ref__status_krt_ajk_cawangan','ref__status_krt_ajk_cawangan.id','=','krt__ahli_jawatan_kuasa_cawangan.ajk_status_form')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa_cawangan.krt_profile_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->orderBy('krt__ahli_jawatan_kuasa_cawangan.id', 'asc')
                        ->where('krt__ahli_jawatan_kuasa_cawangan.ajk_status_form', '=', 5)
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
            $daerah     = RefDaerah::where('status', '=',  true)->get();
            $krt        = KRT_Profile::where('krt_status', '=', true)->get();
            $cawangan   = Ref_KRT_Cawangan::where('status', '=',  true)->get();
            return view('rt-sm9.memperakui-ajk-cawangan-rt-admin', compact('roles_menu','state','daerah','krt','cawangan'));
        }
    }

    function senarai_ajk_cawangan_rt_admin(Request $request){
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
                $data  = KRT_Profile::where($where)->get();
                return Response::json($data);
            }
            $data = DB::table('krt__ahli_jawatan_kuasa_cawangan')
                        ->select('krt__ahli_jawatan_kuasa_cawangan.id',
                                'ref__states.state_description AS krt_state',
                                'ref__daerahs.daerah_description AS krt_daerah',
                                'krt__profile.krt_nama AS krt_nama',
                                'ref__krt_cawangan.cawangan_description AS jenis_cawangan',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_ic AS ajk_ic',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_tarikh_lahir AS ajk_umur',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_phone AS ajk_phone',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_email AS ajk_email',
                                'krt__ahli_jawatan_kuasa_cawangan.ajk_status AS ajk_status',
                                'ref__status_krt_ajk_cawangan.status_description AS status')
                        ->leftJoin('ref__krt_cawangan','ref__krt_cawangan.id','=','krt__ahli_jawatan_kuasa_cawangan.cawangan_id')
                        ->leftJoin('ref__status_krt_ajk_cawangan','ref__status_krt_ajk_cawangan.id','=','krt__ahli_jawatan_kuasa_cawangan.ajk_status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa_cawangan.krt_profile_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->orderBy('krt__ahli_jawatan_kuasa_cawangan.id', 'asc')
                        ->whereIn('krt__ahli_jawatan_kuasa_cawangan.ajk_status', [1,2])
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
            $daerah     = RefDaerah::where('status', '=',  true)->get();
            $krt        = KRT_Profile::where('krt_status', '=', true)->get();
            $cawangan   = Ref_KRT_Cawangan::where('status', '=',  true)->get();
            return view('rt-sm9.senarai-ajk-cawangan-rt-admin', compact('roles_menu','state','daerah','krt','cawangan'));
        }
    }

    function view_ajk_cawangan_rt_admin(Request $request, $id){
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
            $ajk_cawangan       = DB::table('krt__ahli_jawatan_kuasa_cawangan')
                                        ->select('krt__ahli_jawatan_kuasa_cawangan.id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.krt_profile_id AS krt_id',
                                                    'krt__profile.krt_nama AS nama_krt',
                                                    'krt__profile.krt_alamat AS alamat_krt',
                                                    'ref__states.state_description AS negeri_krt',
                                                    'ref__parlimens.parlimen_description AS parlimen_krt',
                                                    'ref__pbts.pbt_description AS pbt_krt',
                                                    'ref__daerahs.daerah_description AS daerah_krt', 
                                                    'ref__duns.dun_description AS dun_krt',
                                                    'krt__ahli_jawatan_kuasa_cawangan.cawangan_id AS cawangan_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_nama AS ajk_nama',
                                                    DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa_cawangan.ajk_tarikh_lahir,'%d/%m/%Y') AS ajk_tarikh_lahir"),
                                                    'krt__ahli_jawatan_kuasa_cawangan.jantina_id AS jantina_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_ic AS ajk_ic',
                                                    'krt__ahli_jawatan_kuasa_cawangan.status_perkahwinan_id AS status_perkahwinan_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_alamat AS ajk_alamat',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_poskod AS ajk_poskod',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_phone AS ajk_phone',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_email AS ajk_email',
                                                    'krt__ahli_jawatan_kuasa_cawangan.jawatan_cawangan_id AS jawatan_cawangan_id')
                                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa_cawangan.krt_profile_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                        ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                        ->where('krt__ahli_jawatan_kuasa_cawangan.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            $cawangan           = Ref_KRT_Cawangan::where('status', '=',  true)->get();
            $jantina            = RefJantina::where('status', '=',  true)->get();
            $status_perkahwinan = Ref_Status_Perkahwinan::where('status', '=',  true)->get();
            $jawatan_cawangan   = Ref_Jawatan_Ajk_Cawangan::where('status', '=',  true)->get();
            $pendidikan   = RefPendidikan::where('pendidikan_status', '=',  true)->get();
            return view('rt-sm9.view-ajk-cawangan-rt-admin', compact('roles_menu','ajk_cawangan', 'cawangan','jantina', 'status_perkahwinan', 'jawatan_cawangan', 'pendidikan'));
        }
    }

    function view_ajk_cawangan_rt_1_admin(Request $request, $id){
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
            $ajk_cawangan       = DB::table('krt__ahli_jawatan_kuasa_cawangan')
                                        ->select('krt__ahli_jawatan_kuasa_cawangan.id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.krt_profile_id AS krt_id',
                                                    'krt__profile.krt_nama AS nama_krt',
                                                    'krt__profile.krt_alamat AS alamat_krt',
                                                    'ref__states.state_description AS negeri_krt',
                                                    'ref__parlimens.parlimen_description AS parlimen_krt',
                                                    'ref__pbts.pbt_description AS pbt_krt',
                                                    'ref__daerahs.daerah_description AS daerah_krt', 
                                                    'ref__duns.dun_description AS dun_krt',
                                                    'krt__ahli_jawatan_kuasa_cawangan.cawangan_id AS cawangan_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.status_perkejaan_id AS status_perkejaan_id',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_pekerjaan_jawatan AS ajk_pekerjaan_jawatan',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_pekerjaan_bidang AS ajk_pekerjaan_bidang',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_pekerjaan_pengalaman AS ajk_pekerjaan_pengalaman',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_kemahiran AS ajk_kemahiran',
                                                    'krt__ahli_jawatan_kuasa_cawangan.ajk_minat AS ajk_minat')
                                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa_cawangan.krt_profile_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                        ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                        ->where('krt__ahli_jawatan_kuasa_cawangan.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            $cawangan           = Ref_KRT_Cawangan::where('status', '=',  true)->get();
            $jantina            = RefJantina::where('status', '=',  true)->get();
            $status_perkahwinan = Ref_Status_Perkahwinan::where('status', '=',  true)->get();
            $jawatan_cawangan   = Ref_Jawatan_Ajk_Cawangan::where('status', '=',  true)->get();
            $pendidikan   = RefPendidikan::where('pendidikan_status', '=',  true)->get();
            return view('rt-sm9.view-ajk-cawangan-rt-1-admin', compact('roles_menu','ajk_cawangan', 'cawangan','jantina', 'status_perkahwinan', 'jawatan_cawangan', 'pendidikan'));
        }
    }

}
