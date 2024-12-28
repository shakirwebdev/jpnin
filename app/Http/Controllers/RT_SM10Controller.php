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
use App\RefJantina;
use App\RefStates;
use App\RefDaerah;
use App\KRT_Profile;
use App\KRT_Profile_Skuad_Uniti;
use App\KRT_Profile_Skuad_Uniti_Biro;
use App\KRT_Profile_Skuad_Uniti_Jaringan;
use App\Ref_Status_Rondaan_SRS;
use App\KRT_Profile_Sejiwa;
use App\KRT_Profile_Sejiwa_Ahli;
use App\KRT_Profile_Sejiwa_Perkhidmatan;
use App\KRT_Profile_Sejiwa_Cabaran;
use App\KRT_Projek_Ekonomi;
use App\KRT_Projek_Ekonomi_ST;
use App\KRT_Projek_Ekonomi_ST_Peserta;
use App\KRT_Koperasi;
use App\Ref_Fungsi_Koperasi;
use App\KRT_Isu_masalah_lokasi_kanta_komuniti;
use App\KRT_Isu_masalah_lokasi_kanta_komuniti_terlibat;
use App\KRT_Koperasi_Fungsi;
use App\KRT_Koperasi_Aktiviti_Tambahan;
use App\Krt_Kanta_Komuniti;
use App\Krt_Kanta_Komuniti_Kaum;
use App\Krt_Kanta_Komuniti_Penduduk;
use App\Krt_Kanta_Komuniti_Risiko;
use App\Krt_Kanta_Komuniti_Masalah;
use App\Krt_Kanta_Komuniti_Kewuudan_Krt;
use App\Krt_Kanta_Komuniti_Langkah_Masalah;
use App\Krt_Kanta_Komuniti_Pemimpin;

class RT_SM10Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function profil_skuad_uniti_krt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__profile_skuad_uniti')
                        ->select('krt__profile_skuad_uniti.id',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__profile_skuad_uniti.skuad_nama AS skuad_nama',
                               DB::raw(" DATE_FORMAT(krt__profile_skuad_uniti.skuad_tarikh_ditubuhkan,'%d/%m/%Y') AS skuad_tarikh_ditubuhkan"),
                               'krt__profile_skuad_uniti.skuad_skop_perkhidmatan AS skuad_skop_perkhidmatan',
                               'ref__status_krt_skuad_uniti.status_description AS status_description',
                               'krt__profile_skuad_uniti.status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_skuad_uniti.krt_profile_id')
                        ->leftJoin('ref__status_krt_skuad_uniti','ref__status_krt_skuad_uniti.id','=','krt__profile_skuad_uniti.status')
                        ->orderBy('krt__profile_skuad_uniti.id', 'asc')
                        ->whereIn('krt__profile_skuad_uniti.status', [3,4,5,6,7])
                        ->where('krt__profile_skuad_uniti.krt_profile_id', '=', Auth::user()->krt_id)
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
            return view('rt-sm10.profil-skuad-uniti-krt',compact('roles_menu'));
        }
    }

    function post_tambah_profile_skuad_uniti(Request $request){
        
        $action = $request->add_profile_skuad_uniti;
        
        $rules = array(
           
        );

        $messages = [
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm10.profil_skuad_uniti_krt'))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'add') {
                $skuad_uniti = new KRT_Profile_Skuad_Uniti;
                $skuad_uniti->krt_profile_id    = Auth::user()->krt_id;
                $skuad_uniti->status            = 3;
                $skuad_uniti->save();
            }
            return Redirect::to(route('rt-sm10.profil_skuad_uniti_krt_1',$skuad_uniti->id));
        }

    }

    function profil_skuad_uniti_krt_1(Request $request, $id){
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
            $skuad_uniti   = DB::table('krt__profile_skuad_uniti')
                                    ->select('krt__profile_skuad_uniti.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__profile_skuad_uniti.skuad_nama AS skuad_nama',
                                            DB::raw(" DATE_FORMAT(krt__profile_skuad_uniti.skuad_tarikh_ditubuhkan,'%d/%m/%Y') AS skuad_tarikh_ditubuhkan"),
                                            'krt__profile_skuad_uniti.skuad_skop_perkhidmatan AS skuad_skop_perkhidmatan',
                                            'krt__profile_skuad_uniti.skuad_nama_ketua AS skuad_nama_ketua',
                                            'krt__profile_skuad_uniti.skuad_ic_ketua AS skuad_ic_ketua',
                                            'krt__profile_skuad_uniti.skuad_phone_ketua AS skuad_phone_ketua',
                                            'krt__profile_skuad_uniti.skuad_email_ketua AS skuad_email_ketua',
                                            'krt__profile_skuad_uniti.skuad_alamat_ketua AS skuad_alamat_ketua',
                                            'krt__profile_skuad_uniti.skuad_pekerjaan_ketua AS skuad_pekerjaan_ketua',
                                            'krt__profile_skuad_uniti.skuad_nama_setiausaha AS skuad_nama_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_ic_setiausaha AS skuad_ic_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_phone_setiausaha AS skuad_phone_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_email_setiausaha AS skuad_email_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_alamat_setiausaha AS skuad_alamat_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_pekerjaan_setiausaha AS skuad_pekerjaan_setiausaha',
                                            'ref__status_krt_skuad_uniti.status_description AS status_description',
                                            'krt__profile_skuad_uniti.disemak_note AS disemak_note',
                                            'krt__profile_skuad_uniti.status AS status',
                                            'krt__profile_skuad_uniti.diakui_note AS diakui_note')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_skuad_uniti.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_krt_skuad_uniti','ref__status_krt_skuad_uniti.id','=','krt__profile_skuad_uniti.status')
                                    ->where('krt__profile_skuad_uniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.profil-skuad-uniti-krt-1', compact('roles_menu','skuad_uniti'));
        }
    }

    function get_senarai_biro_table(Request $request, $id){
        $data = DB::table('krt__profile_skuad_uniti_biro')
                    ->select('krt__profile_skuad_uniti_biro.*')
                    ->where('krt__profile_skuad_uniti_biro.skuad_uniti_id', '=', $id)
                    ->get();
        return Datatables::of($data)
                    ->make(true);
    }

    function delete_biro($id){
        $data = DB::table('krt__profile_skuad_uniti_biro')->where('id', '=', $id)->delete();
    }

    function add_biro_skuad_uniti(Request $request){
        // dd($request);
        $action = $request->add_biro_skuad_uniti;
        
        $rules = array(
            'psuk3_biro_nama'                           => 'required',
            'psuk3_biro_nama_penuh'                     => 'required',
            'psuk3_biro_ic'                             => 'required',
            'psuk3_biro_phone'                          => 'required|numeric',
            'psuk3_biro_emel'                           => 'required|email',
            'psuk3_biro_pekerjaan'                      => 'required',
        );

        $messages = [
            'psuk3_biro_nama.required'                  => 'Ruangan Nama Biro mesti dipilih',
            'psuk3_biro_nama_penuh.required'            => 'Ruangan Nama Penuh mesti diisi',
            'psuk3_biro_ic.required'                    => 'Ruangan No Kad Pengenalan mesti diisi',
            'psuk3_biro_phone.required'                 => 'Ruangan No Telefon mesti diisi',
            'psuk3_biro_phone.numeric'                  => 'Ruangan No Telefon mesti diisi nombor sahaja',
            'psuk3_biro_emel.required'                  => 'Ruangan Emel mesti diisi',
            'psuk3_biro_emel.email'                     => 'Alamat Emel yang dimasukkan tidah sah',
            'psuk3_biro_pekerjaan.required'             => 'Ruangan Pekerjaan mesti dipilih',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $biro = new KRT_Profile_Skuad_Uniti_Biro;
                $biro->skuad_uniti_id                   = $request->psuk3_skuad_uniti_id;
                $biro->biro_nama                        = $request->psuk3_biro_nama;
                $biro->biro_nama_penuh                  = $request->psuk3_biro_nama_penuh;
                $biro->biro_ic                          = $request->psuk3_biro_ic;
                $biro->biro_phone                       = $request->psuk3_biro_phone;
                $biro->biro_emel                        = $request->psuk3_biro_emel;
                $biro->biro_pekerjaan                   = $request->psuk3_biro_pekerjaan;
                $biro->save();
                
            }
        }
    }

    function get_view_biro_skuad_uniti($id){
        $data = DB::table('krt__profile_skuad_uniti_biro')
                ->select('krt__profile_skuad_uniti_biro.id AS id',
                        'krt__profile_skuad_uniti_biro.skuad_uniti_id AS skuad_uniti_id',
                        'krt__profile_skuad_uniti_biro.biro_nama AS biro_nama',
                        'krt__profile_skuad_uniti_biro.biro_nama_penuh AS biro_nama_penuh',
                        'krt__profile_skuad_uniti_biro.biro_ic AS biro_ic',
                        'krt__profile_skuad_uniti_biro.biro_phone AS biro_phone',
                        'krt__profile_skuad_uniti_biro.biro_emel AS biro_emel',
                        'krt__profile_skuad_uniti_biro.biro_pekerjaan AS biro_pekerjaan')
                ->where('krt__profile_skuad_uniti_biro.id', '=', $id)
                ->first();
        return Response::json($data);
    }

    function get_senarai_jaringan_table(Request $request, $id){
        $data = DB::table('krt__profile_skuad_uniti_jaringan')
                    ->select('krt__profile_skuad_uniti_jaringan.*')
                    ->where('krt__profile_skuad_uniti_jaringan.skuad_uniti_id', '=', $id)
                    ->get();
        return Datatables::of($data)
                    ->make(true);
    }

    function add_jaringan_skuad_uniti(Request $request){
        // dd($request);
        $action = $request->add_jaringan_skuad_uniti;
        
        $rules = array(
            'psuk4_jaringan_agensi_nama'                => 'required',
            'psuk4_jaringan_nama_pegawai'               => 'required',
            'psuk4_jaringan_no_telefon'                 => 'required|numeric',
            'psuk4_jaringan_kerjasama'                  => 'required',
        );

        $messages = [
            'psuk4_jaringan_agensi_nama.required'       => 'Ruangan Nama Biro mesti dipilih',
            'psuk4_jaringan_nama_pegawai.required'      => 'Ruangan Nama Penuh mesti diisi',
            'psuk4_jaringan_no_telefon.required'        => 'Ruangan No Kad Pengenalan mesti diisi',
            'psuk4_jaringan_no_telefon.numeric'         => 'Ruangan No Telefon mesti diisi nombor sahaja',
            'psuk4_jaringan_kerjasama.required'         => 'Ruangan No Telefon mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $jaringan = new KRT_Profile_Skuad_Uniti_Jaringan;
                $jaringan->skuad_uniti_id                   = $request->psuk4_skuad_uniti_id;
                $jaringan->jaringan_agensi_nama             = $request->psuk4_jaringan_agensi_nama;
                $jaringan->jaringan_nama_pegawai            = $request->psuk4_jaringan_nama_pegawai;
                $jaringan->jaringan_no_telefon              = $request->psuk4_jaringan_no_telefon;
                $jaringan->jaringan_kerjasama               = $request->psuk4_jaringan_kerjasama;
                $jaringan->save();
                
            }
        }
    }

    function get_view_jaringan_skuad_uniti($id){
        $data = DB::table('krt__profile_skuad_uniti_jaringan')
                ->select('krt__profile_skuad_uniti_jaringan.id AS id',
                        'krt__profile_skuad_uniti_jaringan.skuad_uniti_id AS skuad_uniti_id',
                        'krt__profile_skuad_uniti_jaringan.jaringan_agensi_nama AS jaringan_agensi_nama',
                        'krt__profile_skuad_uniti_jaringan.jaringan_nama_pegawai AS jaringan_nama_pegawai',
                        'krt__profile_skuad_uniti_jaringan.jaringan_no_telefon AS jaringan_no_telefon',
                        'krt__profile_skuad_uniti_jaringan.jaringan_kerjasama AS jaringan_kerjasama')
                ->where('krt__profile_skuad_uniti_jaringan.id', '=', $id)
                ->first();
        return Response::json($data);
    }

    function delete_jaringan($id){
        $data = DB::table('krt__profile_skuad_uniti_jaringan')->where('id', '=', $id)->delete();
    }

    function post_profil_skuad_uniti_krt(Request $request){
        $action = $request->post_profil_skuad_uniti_krt;
        $app_id = $request->psuk5_skuad_uniti_id;
        
        $rules = array(
            'psuk1_skuad_nama'                              => 'required',
            'psuk1_skuad_tarikh_ditubuhkan'                 => 'required',
            'psuk1_skuad_skop_perkhidmatan'                 => 'required',
            'psuk2_skuad_nama_ketua'                        => 'required',
            'psuk2_skuad_phone_ketua'                       => 'required|numeric',
            'psuk2_skuad_email_ketua'                       => 'required|email',
            'psuk2_skuad_ic_ketua'                          => 'required',
            'psuk2_skuad_alamat_ketua'                      => 'required',
            'psuk2_skuad_pekerjaan_ketua'                   => 'required',
            'psuk2_skuad_nama_setiausaha'                   => 'required',
            'psuk2_skuad_phone_setiausaha'                  => 'required|numeric',
            'psuk2_skuad_email_setiausaha'                  => 'required|email',
            'psuk2_skuad_ic_setiausaha'                     => 'required',
            'psuk2_skuad_alamat_setiausaha'                 => 'required',
            'psuk2_skuad_pekerjaan_setiausaha'              => 'required',
        );

        $messages = [
            'psuk1_skuad_nama.required'                     => 'Ruangan Nama Skuad Uniti mesti dipilih',
            'psuk1_skuad_tarikh_ditubuhkan.required'        => 'Ruangan Penubuhan Skuad mesti diisi',
            'psuk1_skuad_skop_perkhidmatan.required'        => 'Ruangan Skop Perkhidmatan Skuad Uniti mesti diisi',
            'psuk2_skuad_nama_ketua.required'               => 'Ruangan Nama Penuh mesti diisi',
            'psuk2_skuad_phone_ketua.required'              => 'Ruangan No Telefon mesti diisi',
            'psuk2_skuad_phone_ketua.numeric'               => 'Ruangan No Telefon mesti diisi nombor sahaja',
            'psuk2_skuad_email_ketua.required'              => 'Ruangan Emel mesti diisi',
            'psuk2_skuad_email_ketua.email'                 => 'Alamat Emel yang dimasukkan tidah sah',
            'psuk2_skuad_ic_ketua.required'                 => 'Ruangan No Kad Pengenalan mesti diisi',
            'psuk2_skuad_alamat_ketua.required'             => 'Ruangan Alamat Rumah mesti diisi',
            'psuk2_skuad_pekerjaan_ketua.required'          => 'Ruangan Pekerjaan mesti diisi',
            'psuk2_skuad_nama_setiausaha.required'          => 'Ruangan Nama Penuh mesti diisi',
            'psuk2_skuad_phone_setiausaha.required'         => 'Ruangan No Telefon mesti diisi',
            'psuk2_skuad_phone_ketua.numeric'               => 'Ruangan No Telefon mesti diisi nombor sahaja',
            'psuk2_skuad_email_setiausaha.required'         => 'Ruangan Emel mesti diisi',
            'psuk2_skuad_email_setiausaha.email'            => 'Alamat Emel yang dimasukkan tidah sah',
            'psuk2_skuad_ic_setiausaha.required'            => 'Ruangan No Kad Pengenalan mesti diisi',
            'psuk2_skuad_alamat_setiausaha.required'        => 'Ruangan Alamat Rumah mesti diisi',
            'psuk2_skuad_pekerjaan_setiausaha.required'     => 'Ruangan Pekerjaan mesti diisi'
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $carbon_obj = Carbon::createFromFormat('d/m/Y', $request->psuk1_skuad_tarikh_ditubuhkan)->format('Y-m-d');
                $where = array('id' => $app_id);
                $profil_skuad_uniti = KRT_Profile_Skuad_Uniti::where($where)->first();
                $profil_skuad_uniti->skuad_nama                   = $request->psuk1_skuad_nama;
                $profil_skuad_uniti->skuad_tarikh_ditubuhkan      = $carbon_obj;
                $profil_skuad_uniti->skuad_skop_perkhidmatan      = $request->psuk1_skuad_skop_perkhidmatan;
                $profil_skuad_uniti->skuad_nama_ketua             = $request->psuk2_skuad_nama_ketua;
                $profil_skuad_uniti->skuad_phone_ketua            = $request->psuk2_skuad_phone_ketua;
                $profil_skuad_uniti->skuad_email_ketua            = $request->psuk2_skuad_email_ketua;
                $profil_skuad_uniti->skuad_ic_ketua               = $request->psuk2_skuad_ic_ketua;
                $profil_skuad_uniti->skuad_alamat_ketua           = $request->psuk2_skuad_alamat_ketua;
                $profil_skuad_uniti->skuad_pekerjaan_ketua        = $request->psuk2_skuad_pekerjaan_ketua;
                $profil_skuad_uniti->skuad_nama_setiausaha        = $request->psuk2_skuad_nama_setiausaha;
                $profil_skuad_uniti->skuad_phone_setiausaha       = $request->psuk2_skuad_phone_setiausaha;
                $profil_skuad_uniti->skuad_email_setiausaha       = $request->psuk2_skuad_email_setiausaha;
                $profil_skuad_uniti->skuad_ic_setiausaha          = $request->psuk2_skuad_ic_setiausaha;
                $profil_skuad_uniti->skuad_alamat_setiausaha      = $request->psuk2_skuad_alamat_setiausaha;
                $profil_skuad_uniti->skuad_pekerjaan_setiausaha   = $request->psuk2_skuad_pekerjaan_setiausaha;
                $profil_skuad_uniti->status                       = 4;
                $profil_skuad_uniti->dihantar_by                  = Auth::user()->user_id;
                $profil_skuad_uniti->dihantar_date                = date('Y-m-d H:i:s');
                $profil_skuad_uniti->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function semakan_profil_skuad_uniti_krt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__profile_skuad_uniti')
                        ->select('krt__profile_skuad_uniti.id',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__profile_skuad_uniti.skuad_nama AS skuad_nama',
                               DB::raw(" DATE_FORMAT(krt__profile_skuad_uniti.skuad_tarikh_ditubuhkan,'%d/%m/%Y') AS skuad_tarikh_ditubuhkan"),
                               'krt__profile_skuad_uniti.skuad_skop_perkhidmatan AS skuad_skop_perkhidmatan',
                               'ref__status_krt_skuad_uniti.status_description AS status_description',
                               'krt__profile_skuad_uniti.status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_skuad_uniti.krt_profile_id')
                        ->leftJoin('ref__status_krt_skuad_uniti','ref__status_krt_skuad_uniti.id','=','krt__profile_skuad_uniti.status')
                        ->orderBy('krt__profile_skuad_uniti.id', 'asc')
                        ->whereIn('krt__profile_skuad_uniti.status', [4])
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
            $krt  = KRT_Profile::where('krt_status', '=',  true)
            ->where('krt__profile.daerah_id','=',Auth::user()->daerah_id)
            ->get();
            return view('rt-sm10.semakan-profil-skuad-uniti-krt', compact('roles_menu','krt'));
        }
    }

    function semakan_profil_skuad_uniti_krt_1(Request $request, $id){
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
            $skuad_uniti   = DB::table('krt__profile_skuad_uniti')
                                    ->select('krt__profile_skuad_uniti.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__profile_skuad_uniti.skuad_nama AS skuad_nama',
                                            DB::raw(" DATE_FORMAT(krt__profile_skuad_uniti.skuad_tarikh_ditubuhkan,'%d/%m/%Y') AS skuad_tarikh_ditubuhkan"),
                                            'krt__profile_skuad_uniti.skuad_skop_perkhidmatan AS skuad_skop_perkhidmatan',
                                            'krt__profile_skuad_uniti.skuad_nama_ketua AS skuad_nama_ketua',
                                            'krt__profile_skuad_uniti.skuad_ic_ketua AS skuad_ic_ketua',
                                            'krt__profile_skuad_uniti.skuad_phone_ketua AS skuad_phone_ketua',
                                            'krt__profile_skuad_uniti.skuad_email_ketua AS skuad_email_ketua',
                                            'krt__profile_skuad_uniti.skuad_alamat_ketua AS skuad_alamat_ketua',
                                            'krt__profile_skuad_uniti.skuad_pekerjaan_ketua AS skuad_pekerjaan_ketua',
                                            'krt__profile_skuad_uniti.skuad_nama_setiausaha AS skuad_nama_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_ic_setiausaha AS skuad_ic_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_phone_setiausaha AS skuad_phone_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_email_setiausaha AS skuad_email_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_alamat_setiausaha AS skuad_alamat_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_pekerjaan_setiausaha AS skuad_pekerjaan_setiausaha')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_skuad_uniti.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__profile_skuad_uniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.semakan-profil-skuad-uniti-krt-1', compact('roles_menu','skuad_uniti'));
        }
    }

    function post_semakan_profile_skuad_uniti(Request $request){
        $action = $request->post_semakan_profile_skuad_uniti;
        $app_id = $request->spsuk_skuad_uniti_id;
        
        
        $rules = array(
            'spsuk_status'                  => 'required',
            'spsuk_disemak_note'            => 'required',
        );

        $messages = [
            'spsuk_status.required'         => 'Ruangan Status mesti dipilih',
            'spsuk_disemak_note.required'   => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $semakan_skuad_uniti                    = KRT_Profile_Skuad_Uniti::where($where)->first();
                $semakan_skuad_uniti->status            = $request->spsuk_status;
                $semakan_skuad_uniti->disemak_note      = $request->spsuk_disemak_note;
                $semakan_skuad_uniti->disemak_by        = Auth::user()->user_id;
                $semakan_skuad_uniti->disemak_date      = date('Y-m-d H:i:s');
                $semakan_skuad_uniti->save();
            }
        }
    }

    function akui_profil_skuad_uniti_krt(Request $request){
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
            $data = DB::table('krt__profile_skuad_uniti')
                        ->select('krt__profile_skuad_uniti.id',
                               'ref__daerahs.daerah_description AS daerah_description',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__profile_skuad_uniti.skuad_nama AS skuad_nama',
                               DB::raw(" DATE_FORMAT(krt__profile_skuad_uniti.skuad_tarikh_ditubuhkan,'%d/%m/%Y') AS skuad_tarikh_ditubuhkan"),
                               'krt__profile_skuad_uniti.skuad_skop_perkhidmatan AS skuad_skop_perkhidmatan',
                               'ref__status_krt_skuad_uniti.status_description AS status_description',
                               'krt__profile_skuad_uniti.status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_skuad_uniti.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__status_krt_skuad_uniti','ref__status_krt_skuad_uniti.id','=','krt__profile_skuad_uniti.status')
                        ->orderBy('krt__profile_skuad_uniti.id', 'asc')
                        ->whereIn('krt__profile_skuad_uniti.status', [6])
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
            return view('rt-sm10.akui-profil-skuad-uniti-krt', compact('roles_menu','daerah','krt'));
        }
    }

    function akui_profil_skuad_uniti_krt_1(Request $request, $id){
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
            $skuad_uniti   = DB::table('krt__profile_skuad_uniti')
                                    ->select('krt__profile_skuad_uniti.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__profile_skuad_uniti.skuad_nama AS skuad_nama',
                                            DB::raw(" DATE_FORMAT(krt__profile_skuad_uniti.skuad_tarikh_ditubuhkan,'%d/%m/%Y') AS skuad_tarikh_ditubuhkan"),
                                            'krt__profile_skuad_uniti.skuad_skop_perkhidmatan AS skuad_skop_perkhidmatan',
                                            'krt__profile_skuad_uniti.skuad_nama_ketua AS skuad_nama_ketua',
                                            'krt__profile_skuad_uniti.skuad_ic_ketua AS skuad_ic_ketua',
                                            'krt__profile_skuad_uniti.skuad_phone_ketua AS skuad_phone_ketua',
                                            'krt__profile_skuad_uniti.skuad_email_ketua AS skuad_email_ketua',
                                            'krt__profile_skuad_uniti.skuad_alamat_ketua AS skuad_alamat_ketua',
                                            'krt__profile_skuad_uniti.skuad_pekerjaan_ketua AS skuad_pekerjaan_ketua',
                                            'krt__profile_skuad_uniti.skuad_nama_setiausaha AS skuad_nama_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_ic_setiausaha AS skuad_ic_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_phone_setiausaha AS skuad_phone_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_email_setiausaha AS skuad_email_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_alamat_setiausaha AS skuad_alamat_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_pekerjaan_setiausaha AS skuad_pekerjaan_setiausaha')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_skuad_uniti.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__profile_skuad_uniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.akui-profil-skuad-uniti-krt-1', compact('roles_menu','skuad_uniti'));
        }
    }

    function post_akui_profile_skuad_uniti(Request $request){
        $action = $request->post_akui_profile_skuad_uniti;
        $app_id = $request->apsupn_skuad_uniti_id;
        
        
        $rules = array(
            'apsupn_status'                  => 'required',
            'apsupn_diakui_note'             => 'required',
        );

        $messages = [
            'apsupn_status.required'         => 'Ruangan Status mesti dipilih',
            'apsupn_diakui_note.required'    => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $akui_skuad_uniti                    = KRT_Profile_Skuad_Uniti::where($where)->first();
                $akui_skuad_uniti->status            = $request->apsupn_status;
                $akui_skuad_uniti->diakui_note       = $request->apsupn_diakui_note;
                $akui_skuad_uniti->diakui_by         = Auth::user()->user_id;
                $akui_skuad_uniti->diakui_date       = date('Y-m-d H:i:s');
                $akui_skuad_uniti->save();
            }
        }
    }

    function senarai_skuad_uniti_krt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__profile_skuad_uniti')
                        ->select('krt__profile_skuad_uniti.id',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__profile_skuad_uniti.skuad_nama AS skuad_nama',
                               DB::raw(" DATE_FORMAT(krt__profile_skuad_uniti.skuad_tarikh_ditubuhkan,'%d/%m/%Y') AS skuad_tarikh_ditubuhkan"),
                               'krt__profile_skuad_uniti.skuad_skop_perkhidmatan AS skuad_skop_perkhidmatan',
                               'ref__status_krt_skuad_uniti.status_description AS status_description',
                               'krt__profile_skuad_uniti.status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_skuad_uniti.krt_profile_id')
                        ->leftJoin('ref__status_krt_skuad_uniti','ref__status_krt_skuad_uniti.id','=','krt__profile_skuad_uniti.status')
                        ->orderBy('krt__profile_skuad_uniti.id', 'asc')
                        ->whereIn('krt__profile_skuad_uniti.status', [1])
                        ->where('krt__profile_skuad_uniti.krt_profile_id', '=', Auth::user()->krt_id)
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
            $skuad_uniti    = KRT_Profile_Skuad_Uniti::where('status', '=', true)
                            ->where('krt__profile_skuad_uniti.krt_profile_id', '=', Auth::user()->krt_id)
                            ->get();
            return view('rt-sm10.senarai-skuad-uniti-krt', compact('roles_menu','skuad_uniti'));
        }
    }

    function senarai_skuad_uniti_krt_1(Request $request, $id){
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
            $skuad_uniti   = DB::table('krt__profile_skuad_uniti')
                                    ->select('krt__profile_skuad_uniti.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__profile_skuad_uniti.skuad_nama AS skuad_nama',
                                            DB::raw(" DATE_FORMAT(krt__profile_skuad_uniti.skuad_tarikh_ditubuhkan,'%d/%m/%Y') AS skuad_tarikh_ditubuhkan"),
                                            'krt__profile_skuad_uniti.skuad_skop_perkhidmatan AS skuad_skop_perkhidmatan',
                                            'krt__profile_skuad_uniti.skuad_nama_ketua AS skuad_nama_ketua',
                                            'krt__profile_skuad_uniti.skuad_ic_ketua AS skuad_ic_ketua',
                                            'krt__profile_skuad_uniti.skuad_phone_ketua AS skuad_phone_ketua',
                                            'krt__profile_skuad_uniti.skuad_email_ketua AS skuad_email_ketua',
                                            'krt__profile_skuad_uniti.skuad_alamat_ketua AS skuad_alamat_ketua',
                                            'krt__profile_skuad_uniti.skuad_pekerjaan_ketua AS skuad_pekerjaan_ketua',
                                            'krt__profile_skuad_uniti.skuad_nama_setiausaha AS skuad_nama_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_ic_setiausaha AS skuad_ic_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_phone_setiausaha AS skuad_phone_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_email_setiausaha AS skuad_email_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_alamat_setiausaha AS skuad_alamat_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_pekerjaan_setiausaha AS skuad_pekerjaan_setiausaha')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_skuad_uniti.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__profile_skuad_uniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.senarai-skuad-uniti-krt-1', compact('roles_menu','skuad_uniti'));
        }
    }

    function senarai_skuad_uniti_krt_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_skuad_uniti') {
                $value = $request->value;
                $where = array('krt_profile_id' => $value);
                $data  = KRT_Profile_Skuad_Uniti::where($where)
                        ->where('krt__profile_skuad_uniti.status', '=',  true) 
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('krt__profile_skuad_uniti')
                        ->select('krt__profile_skuad_uniti.id',
                               'ref__daerahs.daerah_description AS daerah',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__profile_skuad_uniti.skuad_nama AS skuad_nama',
                               DB::raw(" DATE_FORMAT(krt__profile_skuad_uniti.skuad_tarikh_ditubuhkan,'%d/%m/%Y') AS skuad_tarikh_ditubuhkan"),
                               'krt__profile_skuad_uniti.skuad_skop_perkhidmatan AS skuad_skop_perkhidmatan',
                               'ref__status_krt_skuad_uniti.status_description AS status_description',
                               'krt__profile_skuad_uniti.status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_skuad_uniti.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__status_krt_skuad_uniti','ref__status_krt_skuad_uniti.id','=','krt__profile_skuad_uniti.status')
                        ->orderBy('krt__profile_skuad_uniti.id', 'asc')
                        ->whereIn('krt__profile_skuad_uniti.status', [1])
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
            $krt            = KRT_Profile::where('krt_status', '=', true)
                            ->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)
                            ->get();
            $skuad_uniti    = KRT_Profile_Skuad_Uniti::where('status', '=', true)
                            ->get();
            return view('rt-sm10.senarai-skuad-uniti-krt-ppd', compact('roles_menu','krt', 'skuad_uniti'));
        }
    }

    function senarai_skuad_uniti_krt_ppd_1(Request $request, $id){
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
            $skuad_uniti   = DB::table('krt__profile_skuad_uniti')
                                    ->select('krt__profile_skuad_uniti.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__profile_skuad_uniti.skuad_nama AS skuad_nama',
                                            DB::raw(" DATE_FORMAT(krt__profile_skuad_uniti.skuad_tarikh_ditubuhkan,'%d/%m/%Y') AS skuad_tarikh_ditubuhkan"),
                                            'krt__profile_skuad_uniti.skuad_skop_perkhidmatan AS skuad_skop_perkhidmatan',
                                            'krt__profile_skuad_uniti.skuad_nama_ketua AS skuad_nama_ketua',
                                            'krt__profile_skuad_uniti.skuad_ic_ketua AS skuad_ic_ketua',
                                            'krt__profile_skuad_uniti.skuad_phone_ketua AS skuad_phone_ketua',
                                            'krt__profile_skuad_uniti.skuad_email_ketua AS skuad_email_ketua',
                                            'krt__profile_skuad_uniti.skuad_alamat_ketua AS skuad_alamat_ketua',
                                            'krt__profile_skuad_uniti.skuad_pekerjaan_ketua AS skuad_pekerjaan_ketua',
                                            'krt__profile_skuad_uniti.skuad_nama_setiausaha AS skuad_nama_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_ic_setiausaha AS skuad_ic_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_phone_setiausaha AS skuad_phone_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_email_setiausaha AS skuad_email_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_alamat_setiausaha AS skuad_alamat_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_pekerjaan_setiausaha AS skuad_pekerjaan_setiausaha')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_skuad_uniti.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__profile_skuad_uniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.senarai-skuad-uniti-krt-ppd-1', compact('roles_menu','skuad_uniti'));
        }
    }

    function senarai_skuad_uniti_krt_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = KRT_Profile::where($where)
                        ->where('krt__profile.krt_status', '=',  true) 
                        ->get();
                return Response::json($data);
            } else if($type == 'get_skuad_uniti') {
                $value = $request->value;
                $where = array('krt_profile_id' => $value);
                $data  = KRT_Profile_Skuad_Uniti::where($where)
                        ->where('krt__profile_skuad_uniti.status', '=',  true) 
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('krt__profile_skuad_uniti')
                        ->select('krt__profile_skuad_uniti.id',
                               'ref__daerahs.daerah_description AS daerah',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__profile_skuad_uniti.skuad_nama AS skuad_nama',
                               DB::raw(" DATE_FORMAT(krt__profile_skuad_uniti.skuad_tarikh_ditubuhkan,'%d/%m/%Y') AS skuad_tarikh_ditubuhkan"),
                               'krt__profile_skuad_uniti.skuad_skop_perkhidmatan AS skuad_skop_perkhidmatan',
                               'ref__status_krt_skuad_uniti.status_description AS status_description',
                               'krt__profile_skuad_uniti.status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_skuad_uniti.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__status_krt_skuad_uniti','ref__status_krt_skuad_uniti.id','=','krt__profile_skuad_uniti.status')
                        ->orderBy('krt__profile_skuad_uniti.id', 'asc')
                        ->whereIn('krt__profile_skuad_uniti.status', [1])
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
            $krt            = KRT_Profile::where('krt_status', '=', true)
                            ->get();
            $skuad_uniti    = KRT_Profile_Skuad_Uniti::where('status', '=', true)
                            ->get();
            return view('rt-sm10.senarai-skuad-uniti-krt-ppn', compact('roles_menu','daerah', 'krt', 'skuad_uniti'));
        }
    }

    function senarai_skuad_uniti_krt_ppn_1(Request $request, $id){
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
            $skuad_uniti   = DB::table('krt__profile_skuad_uniti')
                                    ->select('krt__profile_skuad_uniti.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__profile_skuad_uniti.skuad_nama AS skuad_nama',
                                            DB::raw(" DATE_FORMAT(krt__profile_skuad_uniti.skuad_tarikh_ditubuhkan,'%d/%m/%Y') AS skuad_tarikh_ditubuhkan"),
                                            'krt__profile_skuad_uniti.skuad_skop_perkhidmatan AS skuad_skop_perkhidmatan',
                                            'krt__profile_skuad_uniti.skuad_nama_ketua AS skuad_nama_ketua',
                                            'krt__profile_skuad_uniti.skuad_ic_ketua AS skuad_ic_ketua',
                                            'krt__profile_skuad_uniti.skuad_phone_ketua AS skuad_phone_ketua',
                                            'krt__profile_skuad_uniti.skuad_email_ketua AS skuad_email_ketua',
                                            'krt__profile_skuad_uniti.skuad_alamat_ketua AS skuad_alamat_ketua',
                                            'krt__profile_skuad_uniti.skuad_pekerjaan_ketua AS skuad_pekerjaan_ketua',
                                            'krt__profile_skuad_uniti.skuad_nama_setiausaha AS skuad_nama_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_ic_setiausaha AS skuad_ic_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_phone_setiausaha AS skuad_phone_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_email_setiausaha AS skuad_email_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_alamat_setiausaha AS skuad_alamat_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_pekerjaan_setiausaha AS skuad_pekerjaan_setiausaha')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_skuad_uniti.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__profile_skuad_uniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.senarai-skuad-uniti-krt-ppn-1', compact('roles_menu','skuad_uniti'));
        }
    }

    function senarai_skuad_uniti_krt_hqrt(Request $request){
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
            } else if($type == 'get_skuad_uniti') {
                $value = $request->value;
                $where = array('krt_profile_id' => $value);
                $data  = KRT_Profile_Skuad_Uniti::where($where)
                        ->where('krt__profile_skuad_uniti.status', '=',  true) 
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('krt__profile_skuad_uniti')
                        ->select('krt__profile_skuad_uniti.id',
                               'ref__states.state_description AS state',
                               'ref__daerahs.daerah_description AS daerah',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__profile_skuad_uniti.skuad_nama AS skuad_nama',
                               DB::raw(" DATE_FORMAT(krt__profile_skuad_uniti.skuad_tarikh_ditubuhkan,'%d/%m/%Y') AS skuad_tarikh_ditubuhkan"),
                               'krt__profile_skuad_uniti.skuad_skop_perkhidmatan AS skuad_skop_perkhidmatan',
                               'ref__status_krt_skuad_uniti.status_description AS status_description',
                               'krt__profile_skuad_uniti.status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_skuad_uniti.krt_profile_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__status_krt_skuad_uniti','ref__status_krt_skuad_uniti.id','=','krt__profile_skuad_uniti.status')
                        ->orderBy('krt__profile_skuad_uniti.id', 'asc')
                        ->whereIn('krt__profile_skuad_uniti.status', [1])
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
            $krt            = KRT_Profile::where('krt_status', '=', true)
                            ->get();
            $skuad_uniti    = KRT_Profile_Skuad_Uniti::where('status', '=', true)
                            ->get();
            return view('rt-sm10.senarai-skuad-uniti-krt-hqrt', compact('roles_menu','state','daerah', 'krt', 'skuad_uniti'));
        }
    }

    function senarai_skuad_uniti_krt_hqrt_1(Request $request, $id){
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
            $skuad_uniti   = DB::table('krt__profile_skuad_uniti')
                                    ->select('krt__profile_skuad_uniti.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__profile_skuad_uniti.skuad_nama AS skuad_nama',
                                            DB::raw(" DATE_FORMAT(krt__profile_skuad_uniti.skuad_tarikh_ditubuhkan,'%d/%m/%Y') AS skuad_tarikh_ditubuhkan"),
                                            'krt__profile_skuad_uniti.skuad_skop_perkhidmatan AS skuad_skop_perkhidmatan',
                                            'krt__profile_skuad_uniti.skuad_nama_ketua AS skuad_nama_ketua',
                                            'krt__profile_skuad_uniti.skuad_ic_ketua AS skuad_ic_ketua',
                                            'krt__profile_skuad_uniti.skuad_phone_ketua AS skuad_phone_ketua',
                                            'krt__profile_skuad_uniti.skuad_email_ketua AS skuad_email_ketua',
                                            'krt__profile_skuad_uniti.skuad_alamat_ketua AS skuad_alamat_ketua',
                                            'krt__profile_skuad_uniti.skuad_pekerjaan_ketua AS skuad_pekerjaan_ketua',
                                            'krt__profile_skuad_uniti.skuad_nama_setiausaha AS skuad_nama_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_ic_setiausaha AS skuad_ic_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_phone_setiausaha AS skuad_phone_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_email_setiausaha AS skuad_email_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_alamat_setiausaha AS skuad_alamat_setiausaha',
                                            'krt__profile_skuad_uniti.skuad_pekerjaan_setiausaha AS skuad_pekerjaan_setiausaha')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_skuad_uniti.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__profile_skuad_uniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.senarai-skuad-uniti-krt-hqrt-1', compact('roles_menu','skuad_uniti'));
        }
    }

    function permohonan_sejiwa_krt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__profile_sejiwa')
                        ->select('krt__profile_sejiwa.id',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__profile_sejiwa.sejiwa_nama AS sejiwa_nama',
                               DB::raw(" DATE_FORMAT(krt__profile_sejiwa.sejiwa_tarikh_ditubuhkan,'%d/%m/%Y') AS sejiwa_tarikh_ditubuhkan"),
                               'krt__profile_sejiwa.sejiwa_pusat_operasi AS sejiwa_pusat_operasi',
                               'krt__profile_sejiwa.status AS status',
                               'ref__status_krt_sejiwa.status_description AS status_description')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_sejiwa.krt_profile_id')
                        ->leftJoin('ref__status_krt_sejiwa','ref__status_krt_sejiwa.id','=','krt__profile_sejiwa.status')
                        ->orderBy('krt__profile_sejiwa.id', 'asc')
                        ->whereIn('krt__profile_sejiwa.status', [3,4,5,6,7])
                        ->where('krt__profile_sejiwa.krt_profile_id', '=', Auth::user()->krt_id)
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
            return view('rt-sm10.permohonan-sejiwa-krt',compact('roles_menu'));
        }
    }

    function post_permohonan_sejiwa(Request $request){
        
        $action = $request->add_permohonan_sejiwa;
        
        $rules = array(
           
        );

        $messages = [
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm10.permohonan_sejiwa_krt'))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'add') {
                $sejiwa = new KRT_Profile_Sejiwa;
                $sejiwa->krt_profile_id    = Auth::user()->krt_id;
                $sejiwa->status            = 3;
                $sejiwa->save();
            }
            return Redirect::to(route('rt-sm10.permohonan_sejiwa_krt_1',$sejiwa->id));
        }

    }

    function permohonan_sejiwa_krt_1(Request $request, $id){
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
            $sejiwa     = DB::table('krt__profile_sejiwa')
                                    ->select('krt__profile_sejiwa.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__profile_sejiwa.sejiwa_nama AS sejiwa_nama',
                                            DB::raw(" DATE_FORMAT(krt__profile_sejiwa.sejiwa_tarikh_ditubuhkan,'%d/%m/%Y') AS sejiwa_tarikh_ditubuhkan"),
                                            'krt__profile_sejiwa.sejiwa_pusat_operasi AS sejiwa_pusat_operasi',
                                            'krt__profile_sejiwa.sejiwa_nama_pengerusi AS sejiwa_nama_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_ic_pengerusi AS sejiwa_ic_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_phone_pengerusi AS sejiwa_phone_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_email_pengerusi AS sejiwa_email_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_alamat_pengerusi AS sejiwa_alamat_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_pekerjaan_pengerusi AS sejiwa_pekerjaan_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_nama_timbalan AS sejiwa_nama_timbalan',
                                            'krt__profile_sejiwa.sejiwa_ic_timbalan AS sejiwa_ic_timbalan',
                                            'krt__profile_sejiwa.sejiwa_phone_timbalan AS sejiwa_phone_timbalan',
                                            'krt__profile_sejiwa.sejiwa_email_timbalan AS sejiwa_email_timbalan',
                                            'krt__profile_sejiwa.sejiwa_alamat_timbalan AS sejiwa_alamat_timbalan',
                                            'krt__profile_sejiwa.sejiwa_pekerjaan_timbalan AS sejiwa_pekerjaan_timbalan',
                                            'krt__profile_sejiwa.sejiwa_nama_su AS sejiwa_nama_su',
                                            'krt__profile_sejiwa.sejiwa_ic_su AS sejiwa_ic_su',
                                            'krt__profile_sejiwa.sejiwa_phone_su AS sejiwa_phone_su',
                                            'krt__profile_sejiwa.sejiwa_email_su AS sejiwa_email_su',
                                            'krt__profile_sejiwa.sejiwa_alamat_su AS sejiwa_alamat_su',
                                            'krt__profile_sejiwa.sejiwa_pekerjaan_su AS sejiwa_pekerjaan_su',
                                            'krt__profile_sejiwa.status AS status',
                                            'ref__status_krt_sejiwa.status_description AS status_description',
                                            'krt__profile_sejiwa.disemak_note AS disemak_note',
                                            'krt__profile_sejiwa.disahkan_note AS disahkan_note')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_sejiwa.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_krt_sejiwa','ref__status_krt_sejiwa.id','=','krt__profile_sejiwa.status')
                                    ->where('krt__profile_sejiwa.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.permohonan-sejiwa-krt-1', compact('roles_menu','sejiwa'));
        }
    }

    function post_profil_sejiwa_krt(Request $request){
        $action = $request->post_profil_sejiwa_krt;
        $app_id = $request->psk3_sejiwa_id;
        
        $rules = array(
            'psk1_sejiwa_nama'                              => 'required',
            'psk1_sejiwa_tarikh_ditubuhkan'                 => 'required',
            'psk1_sejiwa_pusat_operasi'                     => 'required',
            'psk2_sejiwa_nama_pengerusi'                    => 'required',
            'psk2_sejiwa_phone_pengerusi'                   => 'required|numeric',
            'psk2_sejiwa_email_pengerusi'                   => 'required|email',
            'psk2_sejiwa_ic_pengerusi'                      => 'required',
            'psk2_sejiwa_alamat_pengerusi'                  => 'required',
            'psk2_sejiwa_pekerjaan_pengerusi'               => 'required',
            'psk2_sejiwa_nama_timbalan'                     => 'required',
            'psk2_sejiwa_phone_timbalan'                    => 'required|numeric',
            'psk2_sejiwa_email_timbalan'                    => 'required|email',
            'psk2_sejiwa_ic_timbalan'                       => 'required',
            'psk2_sejiwa_alamat_timbalan'                   => 'required',
            'psk2_sejiwa_pekerjaan_timbalan'                => 'required',
            'psk2_sejiwa_nama_su'                           => 'required',
            'psk2_sejiwa_phone_su'                          => 'required|numeric',
            'psk2_sejiwa_email_su'                          => 'required|email',
            'psk2_sejiwa_ic_su'                             => 'required',
            'psk2_sejiwa_alamat_su'                         => 'required',
            'psk2_sejiwa_pekerjaan_su'                      => 'required',
        );

        $messages = [
            'psk1_sejiwa_nama.required'                     => 'Ruangan Nama Sejiwa mesti dipilih',
            'psk1_sejiwa_tarikh_ditubuhkan.required'        => 'Ruangan Tarikh Penubuhan Sejiwa mesti diisi',
            'psk1_sejiwa_pusat_operasi.required'            => 'Ruangan Pusat Operasi Sejiwa mesti diisi',
            'psk2_sejiwa_nama_pengerusi.required'           => 'Ruangan Nama Penuh mesti diisi',
            'psk2_sejiwa_phone_pengerusi.required'          => 'Ruangan No Telefon mesti diisi',
            'psk2_sejiwa_phone_pengerusi.numeric'           => 'Ruangan No Telefon mesti diisi nombor sahaja',
            'psk2_sejiwa_email_pengerusi.required'          => 'Ruangan Emel mesti diisi',
            'psk2_sejiwa_email_pengerusi.email'             => 'Alamat Emel yang dimasukkan tidah sah',
            'psk2_sejiwa_ic_pengerusi.required'             => 'Ruangan No Kad Pengenalan mesti diisi',
            'psk2_sejiwa_alamat_pengerusi.required'         => 'Ruangan Alamat Rumah mesti diisi',
            'psk2_sejiwa_pekerjaan_pengerusi.required'      => 'Ruangan Pekerjaan mesti diisi',
            'psk2_sejiwa_nama_timbalan.required'            => 'Ruangan Nama Penuh mesti diisi',
            'psk2_sejiwa_phone_timbalan.required'           => 'Ruangan No Telefon mesti diisi',
            'psk2_sejiwa_phone_timbalan.numeric'            => 'Ruangan No Telefon mesti diisi nombor sahaja',
            'psk2_sejiwa_email_timbalan.required'           => 'Ruangan Emel mesti diisi',
            'psk2_sejiwa_email_timbalan.email'              => 'Alamat Emel yang dimasukkan tidah sah',
            'psk2_sejiwa_ic_timbalan.required'              => 'Ruangan No Kad Pengenalan mesti diisi',
            'psk2_sejiwa_alamat_timbalan.required'          => 'Ruangan Alamat Rumah mesti diisi',
            'psk2_sejiwa_pekerjaan_timbalan.required'       => 'Ruangan Pekerjaan mesti diisi',
            'psk2_sejiwa_nama_su.required'                  => 'Ruangan Nama Penuh mesti diisi',
            'psk2_sejiwa_phone_su.required'                 => 'Ruangan No Telefon mesti diisi',
            'psk2_sejiwa_phone_su.numeric'                  => 'Ruangan No Telefon mesti diisi nombor sahaja',
            'psk2_sejiwa_email_su.required'                 => 'Ruangan Emel mesti diisi',
            'psk2_sejiwa_email_su.email'                    => 'Alamat Emel yang dimasukkan tidah sah',
            'psk2_sejiwa_ic_su.required'                    => 'Ruangan No Kad Pengenalan mesti diisi',
            'psk2_sejiwa_alamat_su.required'                => 'Ruangan Alamat Rumah mesti diisi',
            'psk2_sejiwa_pekerjaan_su.required'             => 'Ruangan Pekerjaan mesti diisi'
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $carbon_obj = Carbon::createFromFormat('d/m/Y', $request->psk1_sejiwa_tarikh_ditubuhkan)->format('Y-m-d');
                $where = array('id' => $app_id);
                $sejiwa = KRT_Profile_Sejiwa::where($where)->first();
                $sejiwa->sejiwa_nama                  = $request->psk1_sejiwa_nama;
                $sejiwa->sejiwa_tarikh_ditubuhkan     = $carbon_obj;
                $sejiwa->sejiwa_pusat_operasi         = $request->psk1_sejiwa_pusat_operasi;
                $sejiwa->sejiwa_nama_pengerusi        = $request->psk2_sejiwa_nama_pengerusi;
                $sejiwa->sejiwa_phone_pengerusi       = $request->psk2_sejiwa_phone_pengerusi;
                $sejiwa->sejiwa_email_pengerusi       = $request->psk2_sejiwa_email_pengerusi;
                $sejiwa->sejiwa_ic_pengerusi          = $request->psk2_sejiwa_ic_pengerusi;
                $sejiwa->sejiwa_alamat_pengerusi      = $request->psk2_sejiwa_alamat_pengerusi;
                $sejiwa->sejiwa_pekerjaan_pengerusi   = $request->psk2_sejiwa_pekerjaan_pengerusi;
                $sejiwa->sejiwa_nama_timbalan         = $request->psk2_sejiwa_nama_timbalan;
                $sejiwa->sejiwa_phone_timbalan        = $request->psk2_sejiwa_phone_timbalan;
                $sejiwa->sejiwa_email_timbalan        = $request->psk2_sejiwa_email_timbalan;
                $sejiwa->sejiwa_ic_timbalan           = $request->psk2_sejiwa_ic_timbalan;
                $sejiwa->sejiwa_alamat_timbalan       = $request->psk2_sejiwa_alamat_timbalan;
                $sejiwa->sejiwa_pekerjaan_timbalan    = $request->psk2_sejiwa_pekerjaan_timbalan;
                $sejiwa->sejiwa_nama_su               = $request->psk2_sejiwa_nama_su;
                $sejiwa->sejiwa_phone_su              = $request->psk2_sejiwa_phone_su;
                $sejiwa->sejiwa_email_su              = $request->psk2_sejiwa_email_su;
                $sejiwa->sejiwa_ic_su                 = $request->psk2_sejiwa_ic_su;
                $sejiwa->sejiwa_alamat_su             = $request->psk2_sejiwa_alamat_su;
                $sejiwa->sejiwa_pekerjaan_su          = $request->psk2_sejiwa_pekerjaan_su;
                $sejiwa->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function permohonan_sejiwa_krt_2(Request $request, $id){
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
            $sejiwa     = DB::table('krt__profile_sejiwa')
                            ->select('krt__profile_sejiwa.id',
                                    'krt__profile.krt_nama AS nama_krt',
                                    'krt__profile.krt_alamat AS alamat_krt',
                                    'ref__states.state_description AS negeri_krt',
                                    'ref__parlimens.parlimen_description AS parlimen_krt',
                                    'ref__pbts.pbt_description AS pbt_krt',
                                    'ref__daerahs.daerah_description AS daerah_krt', 
                                    'ref__duns.dun_description AS dun_krt',
                                    'krt__profile_sejiwa.sejiwa_nama AS sejiwa_nama',
                                    DB::raw(" DATE_FORMAT(krt__profile_sejiwa.sejiwa_tarikh_ditubuhkan,'%d/%m/%Y') AS sejiwa_tarikh_ditubuhkan"),
                                    'krt__profile_sejiwa.sejiwa_pusat_operasi AS sejiwa_pusat_operasi',
                                    'krt__profile_sejiwa.sejiwa_pegawai_nama AS sejiwa_pegawai_nama',
                                    'krt__profile_sejiwa.sejiwa_pegawai_jawatan AS sejiwa_pegawai_jawatan',
                                    'krt__profile_sejiwa.sejiwa_pegawai_phone AS sejiwa_pegawai_phone',
                                    'krt__profile_sejiwa.sejiwa_pegawai_emel AS sejiwa_pegawai_emel',
                                    'krt__profile_sejiwa.status AS status',
                                    'ref__status_krt_sejiwa.status_description AS status_description',
                                    'krt__profile_sejiwa.disemak_note AS disemak_note',
                                    'krt__profile_sejiwa.disahkan_note AS disahkan_note')
                            ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_sejiwa.krt_profile_id')
                            ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                            ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                            ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                            ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                            ->leftJoin('ref__status_krt_sejiwa','ref__status_krt_sejiwa.id','=','krt__profile_sejiwa.status')
                            ->where('krt__profile_sejiwa.id', '=', $id)  
                            ->limit(1)
                            ->first();
            $ref_kaum           = RefKaum::where('status', '=', true)->get();
            return view('rt-sm10.permohonan-sejiwa-krt-2', compact('roles_menu','sejiwa','ref_kaum'));
        }
    }

    function get_senarai_ahli_sejiwa_table(Request $request, $id){
        $data = DB::table('krt__profile_sejiwa_ahli')
                    ->select('krt__profile_sejiwa_ahli.*')
                    ->where('krt__profile_sejiwa_ahli.sejiwa_id', '=', $id)
                    ->get();
        return Datatables::of($data)
                    ->make(true);
    }

    function add_ahli_sejiwa(Request $request){
        // dd($request);
        $action = $request->add_ahli_sejiwa;
        
        $rules = array(
            'psk4_ahli_sejiwa_nama'                 => 'required',
            'psk4_ahli_sejiwa_ic'                   => 'required',
            'psk4_ahli_sejiwa_pekerjaan'            => 'required',
            'psk4_kaum_id'                          => 'required',
            'psk4_ahli_sejiwa_jawatan'              => 'required',
        );

        $messages = [
            'psk4_ahli_sejiwa_nama.required'        => 'Ruangan Nama Biro mesti dipilih',
            'psk4_ahli_sejiwa_ic.required'          => 'Ruangan Nama Penuh mesti diisi',
            'psk4_ahli_sejiwa_pekerjaan.required'   => 'Ruangan No Kad Pengenalan mesti diisi',
            'psk4_kaum_id.required'                 => 'Ruangan No Telefon mesti diisi',
            'psk4_ahli_sejiwa_jawatan.required'     => 'Ruangan E-mel mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $ahli_sejiwa = new KRT_Profile_Sejiwa_Ahli;
                $ahli_sejiwa->sejiwa_id                   = $request->psk4_sejiwa_id;
                $ahli_sejiwa->ahli_sejiwa_nama            = $request->psk4_ahli_sejiwa_nama;
                $ahli_sejiwa->ahli_sejiwa_ic              = $request->psk4_ahli_sejiwa_ic;
                $ahli_sejiwa->ahli_sejiwa_pekerjaan       = $request->psk4_ahli_sejiwa_pekerjaan;
                $ahli_sejiwa->kaum_id                     = $request->psk4_kaum_id;
                $ahli_sejiwa->ahli_sejiwa_jawatan         = $request->psk4_ahli_sejiwa_jawatan;
                $ahli_sejiwa->save();
                
            }
        }
    }

    function get_view_ahli_sejiwa($id){
        $data = DB::table('krt__profile_sejiwa_ahli')
                ->select('krt__profile_sejiwa_ahli.id AS id',
                        'krt__profile_sejiwa_ahli.sejiwa_id AS sejiwa_id',
                        'krt__profile_sejiwa_ahli.ahli_sejiwa_nama AS ahli_sejiwa_nama',
                        'krt__profile_sejiwa_ahli.ahli_sejiwa_ic AS ahli_sejiwa_ic',
                        'krt__profile_sejiwa_ahli.ahli_sejiwa_pekerjaan AS ahli_sejiwa_pekerjaan',
                        'krt__profile_sejiwa_ahli.kaum_id AS kaum_id',
                        'krt__profile_sejiwa_ahli.ahli_sejiwa_jawatan AS ahli_sejiwa_jawatan')
                ->where('krt__profile_sejiwa_ahli.id', '=', $id)
                ->first();
        return Response::json($data);
    }

    function delete_ahli_sejiwa($id){
        $data = DB::table('krt__profile_sejiwa_ahli')->where('id', '=', $id)->delete();
    }

    function get_senarai_perkhidmatan_sejiwa_table(Request $request, $id){
        $data = DB::table('krt__profile_sejiwa_perkhidmatan')
                    ->select('krt__profile_sejiwa_perkhidmatan.*')
                    ->where('krt__profile_sejiwa_perkhidmatan.sejiwa_id', '=', $id)
                    ->get();
        return Datatables::of($data)
                    ->make(true);
    }

    function add_perkhidmatan_sejiwa(Request $request){
        // dd($request);
        $action = $request->add_perkhidmatan_sejiwa;
        
        $rules = array(
            'psk5_perkhidmatan_sejiwa_keperluan'                => 'required',
            'psk5_perkhidmatan_sejiwa_perkhidmatan'             => 'required',
            'psk5_perkhidmatan_sejiwa_kerjasama'                => 'required',
        );

        $messages = [
            'psk5_perkhidmatan_sejiwa_keperluan.required'        => 'Ruangan Nama Biro mesti dipilih',
            'psk5_perkhidmatan_sejiwa_perkhidmatan.required'     => 'Ruangan Nama Penuh mesti diisi',
            'psk5_perkhidmatan_sejiwa_kerjasama.required'        => 'Ruangan No Kad Pengenalan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $perkhidmatan_sejiwa = new KRT_Profile_Sejiwa_Perkhidmatan;
                $perkhidmatan_sejiwa->sejiwa_id                         = $request->psk5_sejiwa_id;
                $perkhidmatan_sejiwa->perkhidmatan_sejiwa_keperluan     = $request->psk5_perkhidmatan_sejiwa_keperluan;
                $perkhidmatan_sejiwa->perkhidmatan_sejiwa_perkhidmatan  = $request->psk5_perkhidmatan_sejiwa_perkhidmatan;
                $perkhidmatan_sejiwa->perkhidmatan_sejiwa_kerjasama     = $request->psk5_perkhidmatan_sejiwa_kerjasama;
                $perkhidmatan_sejiwa->save();
                
            }
        }
    }

    function get_view_perkhidmatan_sejiwa($id){
        $data = DB::table('krt__profile_sejiwa_perkhidmatan')
                ->select('krt__profile_sejiwa_perkhidmatan.id AS id',
                        'krt__profile_sejiwa_perkhidmatan.sejiwa_id AS sejiwa_id',
                        'krt__profile_sejiwa_perkhidmatan.perkhidmatan_sejiwa_keperluan AS perkhidmatan_sejiwa_keperluan',
                        'krt__profile_sejiwa_perkhidmatan.perkhidmatan_sejiwa_perkhidmatan AS perkhidmatan_sejiwa_perkhidmatan',
                        'krt__profile_sejiwa_perkhidmatan.perkhidmatan_sejiwa_kerjasama AS perkhidmatan_sejiwa_kerjasama')
                ->where('krt__profile_sejiwa_perkhidmatan.id', '=', $id)
                ->first();
        return Response::json($data);
    }

    function delete_perkhidmatan_sejiwa($id){
        $data = DB::table('krt__profile_sejiwa_perkhidmatan')->where('id', '=', $id)->delete();
    }

    function get_senarai_cabaran_sejiwa_table(Request $request, $id){
        $data = DB::table('krt__profile_sejiwa_cabaran')
                    ->select('krt__profile_sejiwa_cabaran.*')
                    ->where('krt__profile_sejiwa_cabaran.sejiwa_id', '=', $id)
                    ->get();
        return Datatables::of($data)
                    ->make(true);
    }

    function add_cabaran_sejiwa(Request $request){
        // dd($request);
        $action = $request->add_cabaran_sejiwa;
        
        $rules = array(
            'psk7_cabaran_sejiwa_cabaran'                       => 'required',
            'psk7_cabaran_sejiwa_mengatasi'                     => 'required',
        );

        $messages = [
            'psk7_cabaran_sejiwa_cabaran.required'              => 'Ruangan Nama Biro mesti dipilih',
            'psk7_cabaran_sejiwa_mengatasi.required'            => 'Ruangan Nama Penuh mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $cabaran_sejiwa = new KRT_Profile_Sejiwa_Cabaran;
                $cabaran_sejiwa->sejiwa_id                         = $request->psk7_sejiwa_id;
                $cabaran_sejiwa->cabaran_sejiwa_cabaran            = $request->psk7_cabaran_sejiwa_cabaran;
                $cabaran_sejiwa->cabaran_sejiwa_mengatasi          = $request->psk7_cabaran_sejiwa_mengatasi;
                $cabaran_sejiwa->save();
                
            }
        }
    }

    function get_view_cabaran_sejiwa($id){
        $data = DB::table('krt__profile_sejiwa_cabaran')
                ->select('krt__profile_sejiwa_cabaran.id AS id',
                        'krt__profile_sejiwa_cabaran.sejiwa_id AS sejiwa_id',
                        'krt__profile_sejiwa_cabaran.cabaran_sejiwa_cabaran AS cabaran_sejiwa_cabaran',
                        'krt__profile_sejiwa_cabaran.cabaran_sejiwa_mengatasi AS cabaran_sejiwa_mengatasi')
                ->where('krt__profile_sejiwa_cabaran.id', '=', $id)
                ->first();
        return Response::json($data);
    }

    function delete_cabaran_sejiwa($id){
        $data = DB::table('krt__profile_sejiwa_cabaran')->where('id', '=', $id)->delete();
    }
    
    function post_profil_sejiwa_krt_1(Request $request){
        $action = $request->post_profil_sejiwa_krt_1;
        $app_id = $request->psk8_sejiwa_id;
        
        $rules = array(
            'psk6_sejiwa_pegawai_nama'                  => 'required',
            'psk6_sejiwa_pegawai_phone'                 => 'required|numeric',
            'psk6_sejiwa_pegawai_jawatan'               => 'required',
            'psk6_sejiwa_pegawai_emel'                  => 'required|email',
        );

        $messages = [
            'psk6_sejiwa_pegawai_nama.required'         => 'Ruangan Nama Skuad Uniti mesti dipilih',
            'psk6_sejiwa_pegawai_phone.required'        => 'Ruangan Penubuhan Skuad mesti diisi',
            'psk6_sejiwa_pegawai_phone.numeric'         => 'Ruangan No Telefon mesti diisi nombor sahaja',
            'psk6_sejiwa_pegawai_jawatan.required'      => 'Ruangan Skop Perkhidmatan Skuad Uniti mesti diisi',
            'psk6_sejiwa_pegawai_emel.required'         => 'Ruangan Emel mesti diisi',
            'psk6_sejiwa_pegawai_emel.email'            => 'Alamat Emel yang dimasukkan tidah sah',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $profil_skuad_uniti = KRT_Profile_Sejiwa::where($where)->first();
                $profil_skuad_uniti->sejiwa_pegawai_nama          = $request->psk6_sejiwa_pegawai_nama;
                $profil_skuad_uniti->sejiwa_pegawai_phone         = $request->psk6_sejiwa_pegawai_phone;
                $profil_skuad_uniti->sejiwa_pegawai_jawatan       = $request->psk6_sejiwa_pegawai_jawatan;
                $profil_skuad_uniti->sejiwa_pegawai_emel          = $request->psk6_sejiwa_pegawai_emel;
                $profil_skuad_uniti->status                       = 4;
                $profil_skuad_uniti->dihantar_by                  = Auth::user()->user_id;
                $profil_skuad_uniti->dihantar_date                = date('Y-m-d H:i:s');
                $profil_skuad_uniti->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function semakan_sejiwa_krt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__profile_sejiwa')
                        ->select('krt__profile_sejiwa.id',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__profile_sejiwa.sejiwa_nama AS sejiwa_nama',
                               DB::raw(" DATE_FORMAT(krt__profile_sejiwa.sejiwa_tarikh_ditubuhkan,'%d/%m/%Y') AS sejiwa_tarikh_ditubuhkan"),
                               'krt__profile_sejiwa.sejiwa_pusat_operasi AS sejiwa_pusat_operasi',
                               'krt__profile_sejiwa.status AS status',
                               'ref__status_krt_sejiwa.status_description AS status_description')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_sejiwa.krt_profile_id')
                        ->leftJoin('ref__status_krt_sejiwa','ref__status_krt_sejiwa.id','=','krt__profile_sejiwa.status')
                        ->orderBy('krt__profile_sejiwa.id', 'asc')
                        ->whereIn('krt__profile_sejiwa.status', [4])
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
            $krt  = KRT_Profile::where('krt_status', '=',  true)
            ->where('krt__profile.daerah_id','=',Auth::user()->daerah_id)
            ->get();
            return view('rt-sm10.semakan-sejiwa-krt', compact('roles_menu','krt'));
        }
    }

    function semakan_sejiwa_krt_1(Request $request, $id){
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
            $sejiwa     = DB::table('krt__profile_sejiwa')
                                    ->select('krt__profile_sejiwa.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__profile_sejiwa.sejiwa_nama AS sejiwa_nama',
                                            DB::raw(" DATE_FORMAT(krt__profile_sejiwa.sejiwa_tarikh_ditubuhkan,'%d/%m/%Y') AS sejiwa_tarikh_ditubuhkan"),
                                            'krt__profile_sejiwa.sejiwa_pusat_operasi AS sejiwa_pusat_operasi',
                                            'krt__profile_sejiwa.sejiwa_nama_pengerusi AS sejiwa_nama_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_ic_pengerusi AS sejiwa_ic_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_phone_pengerusi AS sejiwa_phone_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_email_pengerusi AS sejiwa_email_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_alamat_pengerusi AS sejiwa_alamat_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_pekerjaan_pengerusi AS sejiwa_pekerjaan_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_nama_timbalan AS sejiwa_nama_timbalan',
                                            'krt__profile_sejiwa.sejiwa_ic_timbalan AS sejiwa_ic_timbalan',
                                            'krt__profile_sejiwa.sejiwa_phone_timbalan AS sejiwa_phone_timbalan',
                                            'krt__profile_sejiwa.sejiwa_email_timbalan AS sejiwa_email_timbalan',
                                            'krt__profile_sejiwa.sejiwa_alamat_timbalan AS sejiwa_alamat_timbalan',
                                            'krt__profile_sejiwa.sejiwa_pekerjaan_timbalan AS sejiwa_pekerjaan_timbalan',
                                            'krt__profile_sejiwa.sejiwa_nama_su AS sejiwa_nama_su',
                                            'krt__profile_sejiwa.sejiwa_ic_su AS sejiwa_ic_su',
                                            'krt__profile_sejiwa.sejiwa_phone_su AS sejiwa_phone_su',
                                            'krt__profile_sejiwa.sejiwa_email_su AS sejiwa_email_su',
                                            'krt__profile_sejiwa.sejiwa_alamat_su AS sejiwa_alamat_su',
                                            'krt__profile_sejiwa.sejiwa_pekerjaan_su AS sejiwa_pekerjaan_su')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_sejiwa.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__profile_sejiwa.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.semakan-sejiwa-krt-1', compact('roles_menu','sejiwa'));
        }
    }

    function semakan_sejiwa_krt_2(Request $request, $id){
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
            $sejiwa     = DB::table('krt__profile_sejiwa')
                            ->select('krt__profile_sejiwa.id',
                                    'krt__profile.krt_nama AS nama_krt',
                                    'krt__profile.krt_alamat AS alamat_krt',
                                    'ref__states.state_description AS negeri_krt',
                                    'ref__parlimens.parlimen_description AS parlimen_krt',
                                    'ref__pbts.pbt_description AS pbt_krt',
                                    'ref__daerahs.daerah_description AS daerah_krt', 
                                    'ref__duns.dun_description AS dun_krt',
                                    'krt__profile_sejiwa.sejiwa_nama AS sejiwa_nama',
                                    DB::raw(" DATE_FORMAT(krt__profile_sejiwa.sejiwa_tarikh_ditubuhkan,'%d/%m/%Y') AS sejiwa_tarikh_ditubuhkan"),
                                    'krt__profile_sejiwa.sejiwa_pusat_operasi AS sejiwa_pusat_operasi',
                                    'krt__profile_sejiwa.sejiwa_pegawai_nama AS sejiwa_pegawai_nama',
                                    'krt__profile_sejiwa.sejiwa_pegawai_jawatan AS sejiwa_pegawai_jawatan',
                                    'krt__profile_sejiwa.sejiwa_pegawai_phone AS sejiwa_pegawai_phone',
                                    'krt__profile_sejiwa.sejiwa_pegawai_emel AS sejiwa_pegawai_emel')
                            ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_sejiwa.krt_profile_id')
                            ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                            ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                            ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                            ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                            ->where('krt__profile_sejiwa.id', '=', $id)  
                            ->limit(1)
                            ->first();
            $ref_kaum           = RefKaum::where('status', '=', true)->get();
            return view('rt-sm10.semakan-sejiwa-krt-2', compact('roles_menu','sejiwa','ref_kaum'));
        }
    }

    function post_semakan_profile_sejiwa(Request $request){
        $action = $request->post_semakan_profile_sejiwa;
        $app_id = $request->ssk2_sejiwa_id;
        
        
        $rules = array(
            'ssk2_status'                  => 'required',
            'ssk2_disemak_note'            => 'required',
        );

        $messages = [
            'ssk2_status.required'         => 'Ruangan Status mesti dipilih',
            'ssk2_disemak_note.required'   => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $semakan_sejiwa                    = KRT_Profile_Sejiwa::where($where)->first();
                $semakan_sejiwa->status            = $request->ssk2_status;
                $semakan_sejiwa->disemak_note      = $request->ssk2_disemak_note;
                $semakan_sejiwa->disemak_by        = Auth::user()->user_id;
                $semakan_sejiwa->disemak_date      = date('Y-m-d H:i:s');
                $semakan_sejiwa->save();
            }
        }
    }

    function akui_sejiwa_krt(Request $request){
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
            $data = DB::table('krt__profile_sejiwa')
                        ->select('krt__profile_sejiwa.id',
                               'ref__daerahs.daerah_description AS daerah',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__profile_sejiwa.sejiwa_nama AS sejiwa_nama',
                               DB::raw(" DATE_FORMAT(krt__profile_sejiwa.sejiwa_tarikh_ditubuhkan,'%d/%m/%Y') AS sejiwa_tarikh_ditubuhkan"),
                               'krt__profile_sejiwa.sejiwa_pusat_operasi AS sejiwa_pusat_operasi',
                               'krt__profile_sejiwa.status AS status',
                               'ref__status_krt_sejiwa.status_description AS status_description')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_sejiwa.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__status_krt_sejiwa','ref__status_krt_sejiwa.id','=','krt__profile_sejiwa.status')
                        ->orderBy('krt__profile_sejiwa.id', 'asc')
                        ->whereIn('krt__profile_sejiwa.status', [6])
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
            return view('rt-sm10.akui-sejiwa-krt', compact('roles_menu','daerah','krt'));
        }
    }

    function akui_sejiwa_krt_1(Request $request, $id){
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
            $sejiwa     = DB::table('krt__profile_sejiwa')
                                    ->select('krt__profile_sejiwa.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__profile_sejiwa.sejiwa_nama AS sejiwa_nama',
                                            DB::raw(" DATE_FORMAT(krt__profile_sejiwa.sejiwa_tarikh_ditubuhkan,'%d/%m/%Y') AS sejiwa_tarikh_ditubuhkan"),
                                            'krt__profile_sejiwa.sejiwa_pusat_operasi AS sejiwa_pusat_operasi',
                                            'krt__profile_sejiwa.sejiwa_nama_pengerusi AS sejiwa_nama_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_ic_pengerusi AS sejiwa_ic_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_phone_pengerusi AS sejiwa_phone_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_email_pengerusi AS sejiwa_email_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_alamat_pengerusi AS sejiwa_alamat_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_pekerjaan_pengerusi AS sejiwa_pekerjaan_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_nama_timbalan AS sejiwa_nama_timbalan',
                                            'krt__profile_sejiwa.sejiwa_ic_timbalan AS sejiwa_ic_timbalan',
                                            'krt__profile_sejiwa.sejiwa_phone_timbalan AS sejiwa_phone_timbalan',
                                            'krt__profile_sejiwa.sejiwa_email_timbalan AS sejiwa_email_timbalan',
                                            'krt__profile_sejiwa.sejiwa_alamat_timbalan AS sejiwa_alamat_timbalan',
                                            'krt__profile_sejiwa.sejiwa_pekerjaan_timbalan AS sejiwa_pekerjaan_timbalan',
                                            'krt__profile_sejiwa.sejiwa_nama_su AS sejiwa_nama_su',
                                            'krt__profile_sejiwa.sejiwa_ic_su AS sejiwa_ic_su',
                                            'krt__profile_sejiwa.sejiwa_phone_su AS sejiwa_phone_su',
                                            'krt__profile_sejiwa.sejiwa_email_su AS sejiwa_email_su',
                                            'krt__profile_sejiwa.sejiwa_alamat_su AS sejiwa_alamat_su',
                                            'krt__profile_sejiwa.sejiwa_pekerjaan_su AS sejiwa_pekerjaan_su')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_sejiwa.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__profile_sejiwa.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.akui-sejiwa-krt-1', compact('roles_menu','sejiwa'));
        }
    }

    function akui_sejiwa_krt_2(Request $request, $id){
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
            $sejiwa     = DB::table('krt__profile_sejiwa')
                            ->select('krt__profile_sejiwa.id',
                                    'krt__profile.krt_nama AS nama_krt',
                                    'krt__profile.krt_alamat AS alamat_krt',
                                    'ref__states.state_description AS negeri_krt',
                                    'ref__parlimens.parlimen_description AS parlimen_krt',
                                    'ref__pbts.pbt_description AS pbt_krt',
                                    'ref__daerahs.daerah_description AS daerah_krt', 
                                    'ref__duns.dun_description AS dun_krt',
                                    'krt__profile_sejiwa.sejiwa_nama AS sejiwa_nama',
                                    DB::raw(" DATE_FORMAT(krt__profile_sejiwa.sejiwa_tarikh_ditubuhkan,'%d/%m/%Y') AS sejiwa_tarikh_ditubuhkan"),
                                    'krt__profile_sejiwa.sejiwa_pusat_operasi AS sejiwa_pusat_operasi',
                                    'krt__profile_sejiwa.sejiwa_pegawai_nama AS sejiwa_pegawai_nama',
                                    'krt__profile_sejiwa.sejiwa_pegawai_jawatan AS sejiwa_pegawai_jawatan',
                                    'krt__profile_sejiwa.sejiwa_pegawai_phone AS sejiwa_pegawai_phone',
                                    'krt__profile_sejiwa.sejiwa_pegawai_emel AS sejiwa_pegawai_emel')
                            ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_sejiwa.krt_profile_id')
                            ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                            ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                            ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                            ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                            ->where('krt__profile_sejiwa.id', '=', $id)  
                            ->limit(1)
                            ->first();
            $ref_kaum           = RefKaum::where('status', '=', true)->get();
            return view('rt-sm10.akui-sejiwa-krt-2', compact('roles_menu','sejiwa','ref_kaum'));
        }
    }

    function post_akui_profile_sejiwa(Request $request){
        $action = $request->post_akui_profile_sejiwa;
        $app_id = $request->ask2_sejiwa_id;
        
        
        $rules = array(
            'ask2_status'                 => 'required',
            'ask2_diakui_note'            => 'required',
        );

        $messages = [
            'ask2_status.required'        => 'Ruangan Status mesti dipilih',
            'ask2_diakui_note.required'   => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $akui_sejiwa                    = KRT_Profile_Sejiwa::where($where)->first();
                $akui_sejiwa->status            = $request->ask2_status;
                $akui_sejiwa->disahkan_note     = $request->ask2_diakui_note;
                $akui_sejiwa->disahkan_by       = Auth::user()->user_id;
                $akui_sejiwa->disahkan_date     = date('Y-m-d H:i:s');
                $akui_sejiwa->save();
            }
        }
    }

    function senarai_sejiwa_krt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__profile_sejiwa')
                        ->select('krt__profile_sejiwa.id',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__profile_sejiwa.sejiwa_nama AS sejiwa_nama',
                               DB::raw(" DATE_FORMAT(krt__profile_sejiwa.sejiwa_tarikh_ditubuhkan,'%d/%m/%Y') AS sejiwa_tarikh_ditubuhkan"),
                               'krt__profile_sejiwa.sejiwa_pusat_operasi AS sejiwa_pusat_operasi',
                               'krt__profile_sejiwa.status AS status',
                               'ref__status_krt_sejiwa.status_description AS status_description')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_sejiwa.krt_profile_id')
                        ->leftJoin('ref__status_krt_sejiwa','ref__status_krt_sejiwa.id','=','krt__profile_sejiwa.status')
                        ->orderBy('krt__profile_sejiwa.id', 'asc')
                        ->whereIn('krt__profile_sejiwa.status', [1])
                        ->where('krt__profile_sejiwa.krt_profile_id', '=', Auth::user()->krt_id)
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
            $sejiwa         = KRT_Profile_Sejiwa::where('status', '=', true)
                            ->where('krt__profile_sejiwa.krt_profile_id', '=', Auth::user()->krt_id)
                            ->get();
            return view('rt-sm10.senarai-sejiwa-krt', compact('roles_menu','sejiwa'));
        }
    }

    function senarai_sejiwa_krt_1(Request $request, $id){
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
            $sejiwa     = DB::table('krt__profile_sejiwa')
                                    ->select('krt__profile_sejiwa.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__profile_sejiwa.sejiwa_nama AS sejiwa_nama',
                                            DB::raw(" DATE_FORMAT(krt__profile_sejiwa.sejiwa_tarikh_ditubuhkan,'%d/%m/%Y') AS sejiwa_tarikh_ditubuhkan"),
                                            'krt__profile_sejiwa.sejiwa_pusat_operasi AS sejiwa_pusat_operasi',
                                            'krt__profile_sejiwa.sejiwa_nama_pengerusi AS sejiwa_nama_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_ic_pengerusi AS sejiwa_ic_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_phone_pengerusi AS sejiwa_phone_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_email_pengerusi AS sejiwa_email_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_alamat_pengerusi AS sejiwa_alamat_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_pekerjaan_pengerusi AS sejiwa_pekerjaan_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_nama_timbalan AS sejiwa_nama_timbalan',
                                            'krt__profile_sejiwa.sejiwa_ic_timbalan AS sejiwa_ic_timbalan',
                                            'krt__profile_sejiwa.sejiwa_phone_timbalan AS sejiwa_phone_timbalan',
                                            'krt__profile_sejiwa.sejiwa_email_timbalan AS sejiwa_email_timbalan',
                                            'krt__profile_sejiwa.sejiwa_alamat_timbalan AS sejiwa_alamat_timbalan',
                                            'krt__profile_sejiwa.sejiwa_pekerjaan_timbalan AS sejiwa_pekerjaan_timbalan',
                                            'krt__profile_sejiwa.sejiwa_nama_su AS sejiwa_nama_su',
                                            'krt__profile_sejiwa.sejiwa_ic_su AS sejiwa_ic_su',
                                            'krt__profile_sejiwa.sejiwa_phone_su AS sejiwa_phone_su',
                                            'krt__profile_sejiwa.sejiwa_email_su AS sejiwa_email_su',
                                            'krt__profile_sejiwa.sejiwa_alamat_su AS sejiwa_alamat_su',
                                            'krt__profile_sejiwa.sejiwa_pekerjaan_su AS sejiwa_pekerjaan_su')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_sejiwa.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__profile_sejiwa.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.senarai-sejiwa-krt-1', compact('roles_menu','sejiwa'));
        }
    }

    function senarai_sejiwa_krt_2(Request $request, $id){
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
            $sejiwa     = DB::table('krt__profile_sejiwa')
                            ->select('krt__profile_sejiwa.id',
                                    'krt__profile.krt_nama AS nama_krt',
                                    'krt__profile.krt_alamat AS alamat_krt',
                                    'ref__states.state_description AS negeri_krt',
                                    'ref__parlimens.parlimen_description AS parlimen_krt',
                                    'ref__pbts.pbt_description AS pbt_krt',
                                    'ref__daerahs.daerah_description AS daerah_krt', 
                                    'ref__duns.dun_description AS dun_krt',
                                    'krt__profile_sejiwa.sejiwa_nama AS sejiwa_nama',
                                    DB::raw(" DATE_FORMAT(krt__profile_sejiwa.sejiwa_tarikh_ditubuhkan,'%d/%m/%Y') AS sejiwa_tarikh_ditubuhkan"),
                                    'krt__profile_sejiwa.sejiwa_pusat_operasi AS sejiwa_pusat_operasi',
                                    'krt__profile_sejiwa.sejiwa_pegawai_nama AS sejiwa_pegawai_nama',
                                    'krt__profile_sejiwa.sejiwa_pegawai_jawatan AS sejiwa_pegawai_jawatan',
                                    'krt__profile_sejiwa.sejiwa_pegawai_phone AS sejiwa_pegawai_phone',
                                    'krt__profile_sejiwa.sejiwa_pegawai_emel AS sejiwa_pegawai_emel')
                            ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_sejiwa.krt_profile_id')
                            ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                            ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                            ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                            ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                            ->where('krt__profile_sejiwa.id', '=', $id)  
                            ->limit(1)
                            ->first();
            $ref_kaum           = RefKaum::where('status', '=', true)->get();
            return view('rt-sm10.senarai-sejiwa-krt-2', compact('roles_menu','sejiwa','ref_kaum'));
        }
    }

    function senarai_sejiwa_krt_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_sejiwa') {
                $value = $request->value;
                $where = array('krt_profile_id' => $value);
                $data  = KRT_Profile_Sejiwa::where($where)
                        ->where('krt__profile_sejiwa.status', '=',  true) 
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('krt__profile_sejiwa')
                        ->select('krt__profile_sejiwa.id',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__profile_sejiwa.sejiwa_nama AS sejiwa_nama',
                               DB::raw(" DATE_FORMAT(krt__profile_sejiwa.sejiwa_tarikh_ditubuhkan,'%d/%m/%Y') AS sejiwa_tarikh_ditubuhkan"),
                               'krt__profile_sejiwa.sejiwa_pusat_operasi AS sejiwa_pusat_operasi',
                               'krt__profile_sejiwa.status AS status',
                               'ref__status_krt_sejiwa.status_description AS status_description')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_sejiwa.krt_profile_id')
                        ->leftJoin('ref__status_krt_sejiwa','ref__status_krt_sejiwa.id','=','krt__profile_sejiwa.status')
                        ->orderBy('krt__profile_sejiwa.id', 'asc')
                        ->whereIn('krt__profile_sejiwa.status', [1])
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
            $krt            = KRT_Profile::where('krt_status', '=', true)
                            ->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)
                            ->get();
            $sejiwa         = KRT_Profile_Sejiwa::where('status', '=', true)
                            ->get();
            return view('rt-sm10.senarai-sejiwa-krt-ppd', compact('roles_menu','krt','sejiwa'));
        }
    }

    function senarai_sejiwa_krt_ppd_1(Request $request, $id){
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
            $sejiwa     = DB::table('krt__profile_sejiwa')
                                    ->select('krt__profile_sejiwa.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__profile_sejiwa.sejiwa_nama AS sejiwa_nama',
                                            DB::raw(" DATE_FORMAT(krt__profile_sejiwa.sejiwa_tarikh_ditubuhkan,'%d/%m/%Y') AS sejiwa_tarikh_ditubuhkan"),
                                            'krt__profile_sejiwa.sejiwa_pusat_operasi AS sejiwa_pusat_operasi',
                                            'krt__profile_sejiwa.sejiwa_nama_pengerusi AS sejiwa_nama_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_ic_pengerusi AS sejiwa_ic_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_phone_pengerusi AS sejiwa_phone_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_email_pengerusi AS sejiwa_email_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_alamat_pengerusi AS sejiwa_alamat_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_pekerjaan_pengerusi AS sejiwa_pekerjaan_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_nama_timbalan AS sejiwa_nama_timbalan',
                                            'krt__profile_sejiwa.sejiwa_ic_timbalan AS sejiwa_ic_timbalan',
                                            'krt__profile_sejiwa.sejiwa_phone_timbalan AS sejiwa_phone_timbalan',
                                            'krt__profile_sejiwa.sejiwa_email_timbalan AS sejiwa_email_timbalan',
                                            'krt__profile_sejiwa.sejiwa_alamat_timbalan AS sejiwa_alamat_timbalan',
                                            'krt__profile_sejiwa.sejiwa_pekerjaan_timbalan AS sejiwa_pekerjaan_timbalan',
                                            'krt__profile_sejiwa.sejiwa_nama_su AS sejiwa_nama_su',
                                            'krt__profile_sejiwa.sejiwa_ic_su AS sejiwa_ic_su',
                                            'krt__profile_sejiwa.sejiwa_phone_su AS sejiwa_phone_su',
                                            'krt__profile_sejiwa.sejiwa_email_su AS sejiwa_email_su',
                                            'krt__profile_sejiwa.sejiwa_alamat_su AS sejiwa_alamat_su',
                                            'krt__profile_sejiwa.sejiwa_pekerjaan_su AS sejiwa_pekerjaan_su')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_sejiwa.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__profile_sejiwa.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.senarai-sejiwa-krt-ppd-1', compact('roles_menu','sejiwa'));
        }
    }

    function senarai_sejiwa_krt_ppd_2(Request $request, $id){
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
            $sejiwa     = DB::table('krt__profile_sejiwa')
                            ->select('krt__profile_sejiwa.id',
                                    'krt__profile.krt_nama AS nama_krt',
                                    'krt__profile.krt_alamat AS alamat_krt',
                                    'ref__states.state_description AS negeri_krt',
                                    'ref__parlimens.parlimen_description AS parlimen_krt',
                                    'ref__pbts.pbt_description AS pbt_krt',
                                    'ref__daerahs.daerah_description AS daerah_krt', 
                                    'ref__duns.dun_description AS dun_krt',
                                    'krt__profile_sejiwa.sejiwa_nama AS sejiwa_nama',
                                    DB::raw(" DATE_FORMAT(krt__profile_sejiwa.sejiwa_tarikh_ditubuhkan,'%d/%m/%Y') AS sejiwa_tarikh_ditubuhkan"),
                                    'krt__profile_sejiwa.sejiwa_pusat_operasi AS sejiwa_pusat_operasi',
                                    'krt__profile_sejiwa.sejiwa_pegawai_nama AS sejiwa_pegawai_nama',
                                    'krt__profile_sejiwa.sejiwa_pegawai_jawatan AS sejiwa_pegawai_jawatan',
                                    'krt__profile_sejiwa.sejiwa_pegawai_phone AS sejiwa_pegawai_phone',
                                    'krt__profile_sejiwa.sejiwa_pegawai_emel AS sejiwa_pegawai_emel')
                            ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_sejiwa.krt_profile_id')
                            ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                            ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                            ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                            ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                            ->where('krt__profile_sejiwa.id', '=', $id)  
                            ->limit(1)
                            ->first();
            $ref_kaum           = RefKaum::where('status', '=', true)->get();
            return view('rt-sm10.senarai-sejiwa-krt-ppd-2', compact('roles_menu','sejiwa','ref_kaum'));
        }
    }

    function senarai_sejiwa_krt_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = KRT_Profile::where($where)
                        ->where('krt__profile.krt_status', '=',  true) 
                        ->get();
                return Response::json($data);
            } else if($type == 'get_sejiwa') {
                $value = $request->value;
                $where = array('krt_profile_id' => $value);
                $data  = KRT_Profile_Sejiwa::where($where)
                        ->where('krt__profile_sejiwa.status', '=',  true) 
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('krt__profile_sejiwa')
                        ->select('krt__profile_sejiwa.id',
                               'ref__daerahs.daerah_description AS daerah',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__profile_sejiwa.sejiwa_nama AS sejiwa_nama',
                               DB::raw(" DATE_FORMAT(krt__profile_sejiwa.sejiwa_tarikh_ditubuhkan,'%d/%m/%Y') AS sejiwa_tarikh_ditubuhkan"),
                               'krt__profile_sejiwa.sejiwa_pusat_operasi AS sejiwa_pusat_operasi',
                               'krt__profile_sejiwa.status AS status',
                               'ref__status_krt_sejiwa.status_description AS status_description')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_sejiwa.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__status_krt_sejiwa','ref__status_krt_sejiwa.id','=','krt__profile_sejiwa.status')
                        ->orderBy('krt__profile_sejiwa.id', 'asc')
                        ->whereIn('krt__profile_sejiwa.status', [1])
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
            $krt            = KRT_Profile::where('krt_status', '=', true)
                            ->get();
            $sejiwa         = KRT_Profile_Sejiwa::where('status', '=', true)
                            ->get();
            return view('rt-sm10.senarai-sejiwa-krt-ppn', compact('roles_menu','daerah','krt','sejiwa'));
        }
    }

    function senarai_sejiwa_krt_ppn_1(Request $request, $id){
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
            $sejiwa     = DB::table('krt__profile_sejiwa')
                                    ->select('krt__profile_sejiwa.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__profile_sejiwa.sejiwa_nama AS sejiwa_nama',
                                            DB::raw(" DATE_FORMAT(krt__profile_sejiwa.sejiwa_tarikh_ditubuhkan,'%d/%m/%Y') AS sejiwa_tarikh_ditubuhkan"),
                                            'krt__profile_sejiwa.sejiwa_pusat_operasi AS sejiwa_pusat_operasi',
                                            'krt__profile_sejiwa.sejiwa_nama_pengerusi AS sejiwa_nama_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_ic_pengerusi AS sejiwa_ic_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_phone_pengerusi AS sejiwa_phone_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_email_pengerusi AS sejiwa_email_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_alamat_pengerusi AS sejiwa_alamat_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_pekerjaan_pengerusi AS sejiwa_pekerjaan_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_nama_timbalan AS sejiwa_nama_timbalan',
                                            'krt__profile_sejiwa.sejiwa_ic_timbalan AS sejiwa_ic_timbalan',
                                            'krt__profile_sejiwa.sejiwa_phone_timbalan AS sejiwa_phone_timbalan',
                                            'krt__profile_sejiwa.sejiwa_email_timbalan AS sejiwa_email_timbalan',
                                            'krt__profile_sejiwa.sejiwa_alamat_timbalan AS sejiwa_alamat_timbalan',
                                            'krt__profile_sejiwa.sejiwa_pekerjaan_timbalan AS sejiwa_pekerjaan_timbalan',
                                            'krt__profile_sejiwa.sejiwa_nama_su AS sejiwa_nama_su',
                                            'krt__profile_sejiwa.sejiwa_ic_su AS sejiwa_ic_su',
                                            'krt__profile_sejiwa.sejiwa_phone_su AS sejiwa_phone_su',
                                            'krt__profile_sejiwa.sejiwa_email_su AS sejiwa_email_su',
                                            'krt__profile_sejiwa.sejiwa_alamat_su AS sejiwa_alamat_su',
                                            'krt__profile_sejiwa.sejiwa_pekerjaan_su AS sejiwa_pekerjaan_su')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_sejiwa.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__profile_sejiwa.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.senarai-sejiwa-krt-ppn-1', compact('roles_menu','sejiwa'));
        }
    }

    function senarai_sejiwa_krt_ppn_2(Request $request, $id){
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
            $sejiwa     = DB::table('krt__profile_sejiwa')
                            ->select('krt__profile_sejiwa.id',
                                    'krt__profile.krt_nama AS nama_krt',
                                    'krt__profile.krt_alamat AS alamat_krt',
                                    'ref__states.state_description AS negeri_krt',
                                    'ref__parlimens.parlimen_description AS parlimen_krt',
                                    'ref__pbts.pbt_description AS pbt_krt',
                                    'ref__daerahs.daerah_description AS daerah_krt', 
                                    'ref__duns.dun_description AS dun_krt',
                                    'krt__profile_sejiwa.sejiwa_nama AS sejiwa_nama',
                                    DB::raw(" DATE_FORMAT(krt__profile_sejiwa.sejiwa_tarikh_ditubuhkan,'%d/%m/%Y') AS sejiwa_tarikh_ditubuhkan"),
                                    'krt__profile_sejiwa.sejiwa_pusat_operasi AS sejiwa_pusat_operasi',
                                    'krt__profile_sejiwa.sejiwa_pegawai_nama AS sejiwa_pegawai_nama',
                                    'krt__profile_sejiwa.sejiwa_pegawai_jawatan AS sejiwa_pegawai_jawatan',
                                    'krt__profile_sejiwa.sejiwa_pegawai_phone AS sejiwa_pegawai_phone',
                                    'krt__profile_sejiwa.sejiwa_pegawai_emel AS sejiwa_pegawai_emel')
                            ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_sejiwa.krt_profile_id')
                            ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                            ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                            ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                            ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                            ->where('krt__profile_sejiwa.id', '=', $id)  
                            ->limit(1)
                            ->first();
            $ref_kaum           = RefKaum::where('status', '=', true)->get();
            return view('rt-sm10.senarai-sejiwa-krt-ppn-2', compact('roles_menu','sejiwa','ref_kaum'));
        }
    }

    function senarai_sejiwa_krt_hqrt(Request $request){
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
            } else if($type == 'get_sejiwa') {
                $value = $request->value;
                $where = array('krt_profile_id' => $value);
                $data  = KRT_Profile_Sejiwa::where($where)
                        ->where('krt__profile_sejiwa.status', '=',  true) 
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('krt__profile_sejiwa')
                        ->select('krt__profile_sejiwa.id',
                               'ref__states.state_description AS state',
                               'ref__daerahs.daerah_description AS daerah',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__profile_sejiwa.sejiwa_nama AS sejiwa_nama',
                               DB::raw(" DATE_FORMAT(krt__profile_sejiwa.sejiwa_tarikh_ditubuhkan,'%d/%m/%Y') AS sejiwa_tarikh_ditubuhkan"),
                               'krt__profile_sejiwa.sejiwa_pusat_operasi AS sejiwa_pusat_operasi',
                               'krt__profile_sejiwa.status AS status',
                               'ref__status_krt_sejiwa.status_description AS status_description')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_sejiwa.krt_profile_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__status_krt_sejiwa','ref__status_krt_sejiwa.id','=','krt__profile_sejiwa.status')
                        ->orderBy('krt__profile_sejiwa.id', 'asc')
                        ->whereIn('krt__profile_sejiwa.status', [1])
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
            $krt            = KRT_Profile::where('krt_status', '=', true)
                            ->get();
            $sejiwa         = KRT_Profile_Sejiwa::where('status', '=', true)
                            ->get();
            return view('rt-sm10.senarai-sejiwa-krt-hqrt', compact('roles_menu','state','daerah','krt','sejiwa'));
        }
    }

    function senarai_sejiwa_krt_hqrt_1(Request $request, $id){
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
            $sejiwa     = DB::table('krt__profile_sejiwa')
                                    ->select('krt__profile_sejiwa.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__profile_sejiwa.sejiwa_nama AS sejiwa_nama',
                                            DB::raw(" DATE_FORMAT(krt__profile_sejiwa.sejiwa_tarikh_ditubuhkan,'%d/%m/%Y') AS sejiwa_tarikh_ditubuhkan"),
                                            'krt__profile_sejiwa.sejiwa_pusat_operasi AS sejiwa_pusat_operasi',
                                            'krt__profile_sejiwa.sejiwa_nama_pengerusi AS sejiwa_nama_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_ic_pengerusi AS sejiwa_ic_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_phone_pengerusi AS sejiwa_phone_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_email_pengerusi AS sejiwa_email_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_alamat_pengerusi AS sejiwa_alamat_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_pekerjaan_pengerusi AS sejiwa_pekerjaan_pengerusi',
                                            'krt__profile_sejiwa.sejiwa_nama_timbalan AS sejiwa_nama_timbalan',
                                            'krt__profile_sejiwa.sejiwa_ic_timbalan AS sejiwa_ic_timbalan',
                                            'krt__profile_sejiwa.sejiwa_phone_timbalan AS sejiwa_phone_timbalan',
                                            'krt__profile_sejiwa.sejiwa_email_timbalan AS sejiwa_email_timbalan',
                                            'krt__profile_sejiwa.sejiwa_alamat_timbalan AS sejiwa_alamat_timbalan',
                                            'krt__profile_sejiwa.sejiwa_pekerjaan_timbalan AS sejiwa_pekerjaan_timbalan',
                                            'krt__profile_sejiwa.sejiwa_nama_su AS sejiwa_nama_su',
                                            'krt__profile_sejiwa.sejiwa_ic_su AS sejiwa_ic_su',
                                            'krt__profile_sejiwa.sejiwa_phone_su AS sejiwa_phone_su',
                                            'krt__profile_sejiwa.sejiwa_email_su AS sejiwa_email_su',
                                            'krt__profile_sejiwa.sejiwa_alamat_su AS sejiwa_alamat_su',
                                            'krt__profile_sejiwa.sejiwa_pekerjaan_su AS sejiwa_pekerjaan_su')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_sejiwa.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__profile_sejiwa.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.senarai-sejiwa-krt-hqrt-1', compact('roles_menu','sejiwa'));
        }
    }

    function senarai_sejiwa_krt_hqrt_2(Request $request, $id){
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
            $sejiwa     = DB::table('krt__profile_sejiwa')
                            ->select('krt__profile_sejiwa.id',
                                    'krt__profile.krt_nama AS nama_krt',
                                    'krt__profile.krt_alamat AS alamat_krt',
                                    'ref__states.state_description AS negeri_krt',
                                    'ref__parlimens.parlimen_description AS parlimen_krt',
                                    'ref__pbts.pbt_description AS pbt_krt',
                                    'ref__daerahs.daerah_description AS daerah_krt', 
                                    'ref__duns.dun_description AS dun_krt',
                                    'krt__profile_sejiwa.sejiwa_nama AS sejiwa_nama',
                                    DB::raw(" DATE_FORMAT(krt__profile_sejiwa.sejiwa_tarikh_ditubuhkan,'%d/%m/%Y') AS sejiwa_tarikh_ditubuhkan"),
                                    'krt__profile_sejiwa.sejiwa_pusat_operasi AS sejiwa_pusat_operasi',
                                    'krt__profile_sejiwa.sejiwa_pegawai_nama AS sejiwa_pegawai_nama',
                                    'krt__profile_sejiwa.sejiwa_pegawai_jawatan AS sejiwa_pegawai_jawatan',
                                    'krt__profile_sejiwa.sejiwa_pegawai_phone AS sejiwa_pegawai_phone',
                                    'krt__profile_sejiwa.sejiwa_pegawai_emel AS sejiwa_pegawai_emel')
                            ->leftJoin('krt__profile','krt__profile.id','=','krt__profile_sejiwa.krt_profile_id')
                            ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                            ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                            ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                            ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                            ->where('krt__profile_sejiwa.id', '=', $id)  
                            ->limit(1)
                            ->first();
            $ref_kaum           = RefKaum::where('status', '=', true)->get();
            return view('rt-sm10.senarai-sejiwa-krt-hqrt-2', compact('roles_menu','sejiwa','ref_kaum'));
        }
    }

    function permohonan_projek_ekonomi_krt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__projek_ekonomi')
                        ->select('krt__projek_ekonomi.id',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__projek_ekonomi.projek_nama AS projek_nama',
                               'krt__projek_ekonomi.projek_tahun AS projek_tahun',
                               'ref__status_krt_pelaksanaan_projek.status_description AS status_projek',
                               'ref__status_krt_projek_ekonomi.status_description AS status_description',
                               'krt__projek_ekonomi.status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__projek_ekonomi.krt_profile_id')
                        ->leftJoin('ref__status_krt_pelaksanaan_projek','ref__status_krt_pelaksanaan_projek.id','=','krt__projek_ekonomi.status_pelaksanaan_projek_id')
                        ->leftJoin('ref__status_krt_projek_ekonomi','ref__status_krt_projek_ekonomi.id','=','krt__projek_ekonomi.status')
                        ->orderBy('krt__projek_ekonomi.id', 'asc')
                        ->whereIn('krt__projek_ekonomi.status', [3,4,5,6,7])
                        ->where('krt__projek_ekonomi.krt_profile_id', '=', Auth::user()->krt_id)
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
            return view('rt-sm10.permohonan-projek-ekonomi-krt',compact('roles_menu'));
        }
    }

    function post_permohonan_projek_ekonomi(Request $request){
        
        $action = $request->add_permohonan_projek_ekonomi;
        
        $rules = array(
           
        );

        $messages = [
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm10.permohonan_projek_ekonomi_krt'))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'add') {
                $projek_ekonomi                    = new KRT_Projek_Ekonomi;
                $projek_ekonomi->krt_profile_id    = Auth::user()->krt_id;
                $projek_ekonomi->status            = 3;
                $projek_ekonomi->save();
            }
            return Redirect::to(route('rt-sm10.permohonan_projek_ekonomi_krt_1',$projek_ekonomi->id));
        }

    }

    function permohonan_projek_ekonomi_krt_1(Request $request, $id){
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
            $projek_ekonomi     = DB::table('krt__projek_ekonomi')
                                    ->select('krt__projek_ekonomi.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__projek_ekonomi.projek_nama AS projek_nama',
                                            'krt__projek_ekonomi.projek_penerangan AS projek_penerangan',
                                            'krt__projek_ekonomi.status_pelaksanaan_projek_id AS status_pelaksanaan_projek_id',
                                            'krt__projek_ekonomi.sekala_project_semasa_id AS sekala_project_semasa_id',
                                            'krt__projek_ekonomi.sekala_project_hadapan_id AS sekala_project_hadapan_id',
                                            'krt__projek_ekonomi.projek_jaringan AS projek_jaringan',
                                            'krt__projek_ekonomi.projek_tahun AS projek_tahun',
                                            'krt__projek_ekonomi.projek_impak AS projek_impak',
                                            'krt__projek_ekonomi.status AS status',
                                            'ref__status_krt_projek_ekonomi.status_description AS status_description',
                                            'krt__projek_ekonomi.disemak_note AS disemak_note',
                                            'krt__projek_ekonomi.disahkan_note AS disahkan_note')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__projek_ekonomi.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_krt_projek_ekonomi','ref__status_krt_projek_ekonomi.id','=','krt__projek_ekonomi.status')
                                    ->where('krt__projek_ekonomi.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.permohonan-projek-ekonomi-krt-1', compact('roles_menu','projek_ekonomi'));
        }
    }

    function post_permohonan_projek_ekonomi_1(Request $request){
        $action = $request->post_permohonan_projek_ekonomi_1;
        $app_id = $request->psk2_projek_ekonomi_id;
        
        $rules = array(
            'ppek1_projek_nama'                                 => 'required',
            'ppek1_projek_penerangan'                           => 'required',
            'ppek1_status_pelaksanaan_projek_id'                => 'required',
            'ppek1_sekala_project_semasa_id'                    => 'required',
            'ppek1_sekala_project_hadapan_id'                   => 'required',
            'ppek1_projek_jaringan'                             => 'required',
            'ppek1_projek_tahun'                                => 'required',
            'ppek1_projek_impak'                                => 'required',
        );

        $messages = [
            'ppek1_projek_nama.required'                        => 'Ruangan nama projek ekonomi diisi',
            'ppek1_projek_penerangan.required'                  => 'Ruangan penerangan ringkas mengenai projek mesti diisi',
            'ppek1_status_pelaksanaan_projek_id.required'       => 'Ruangan status pelaksanaan mesti dipilih',
            'ppek1_sekala_project_semasa_id.required'           => 'Ruangan sekala projek (semasa) mesti dipilih',
            'ppek1_sekala_project_hadapan_id.required'          => 'Ruangan sekala projek (sasaran masa hadapan) mesti dipilih',
            'ppek1_projek_jaringan.required'                    => 'Ruangan jaringan kerjasama dan jenis bantuan yang diterima mesti diisi',
            'ppek1_projek_tahun.required'                       => 'Ruangan tahun mula projek mesti diisi',
            'ppek1_projek_impak.required'                       => 'Ruangan impak kepada komuniti mesti diisi',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $projek_ekonomi = KRT_Projek_Ekonomi::where($where)->first();
                $projek_ekonomi->projek_nama                  = $request->ppek1_projek_nama;
                $projek_ekonomi->projek_penerangan            = $request->ppek1_projek_penerangan;
                $projek_ekonomi->status_pelaksanaan_projek_id = $request->ppek1_status_pelaksanaan_projek_id;
                $projek_ekonomi->sekala_project_semasa_id     = $request->ppek1_sekala_project_semasa_id;
                $projek_ekonomi->sekala_project_hadapan_id    = $request->ppek1_sekala_project_hadapan_id;
                $projek_ekonomi->projek_jaringan              = $request->ppek1_projek_jaringan;
                $projek_ekonomi->projek_tahun                 = $request->ppek1_projek_tahun;
                $projek_ekonomi->projek_impak                 = $request->ppek1_projek_impak;
                $projek_ekonomi->status                       = 4;
                $projek_ekonomi->dihantar_by                  = Auth::user()->user_id;
                $projek_ekonomi->dihantar_date                = date('Y-m-d H:i:s');
                $projek_ekonomi->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function semakan_projek_ekonomi_krt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__projek_ekonomi')
                        ->select('krt__projek_ekonomi.id',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__projek_ekonomi.projek_nama AS projek_nama',
                               'krt__projek_ekonomi.projek_tahun AS projek_tahun',
                               'ref__status_krt_pelaksanaan_projek.status_description AS status_projek',
                               'ref__status_krt_projek_ekonomi.status_description AS status_description',
                               'krt__projek_ekonomi.status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__projek_ekonomi.krt_profile_id')
                        ->leftJoin('ref__status_krt_pelaksanaan_projek','ref__status_krt_pelaksanaan_projek.id','=','krt__projek_ekonomi.status_pelaksanaan_projek_id')
                        ->leftJoin('ref__status_krt_projek_ekonomi','ref__status_krt_projek_ekonomi.id','=','krt__projek_ekonomi.status')
                        ->orderBy('krt__projek_ekonomi.id', 'asc')
                        ->whereIn('krt__projek_ekonomi.status', [4])
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
            $krt  = KRT_Profile::where('krt_status', '=',  true)
            ->where('krt__profile.daerah_id','=',Auth::user()->daerah_id)
            ->get();
            return view('rt-sm10.semakan-projek-ekonomi-krt', compact('roles_menu','krt'));
        }
    }

    function semakan_projek_ekonomi_krt_1(Request $request, $id){
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
            $projek_ekonomi     = DB::table('krt__projek_ekonomi')
                                    ->select('krt__projek_ekonomi.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__projek_ekonomi.projek_nama AS projek_nama',
                                            'krt__projek_ekonomi.projek_penerangan AS projek_penerangan',
                                            'krt__projek_ekonomi.status_pelaksanaan_projek_id AS status_pelaksanaan_projek_id',
                                            'krt__projek_ekonomi.sekala_project_semasa_id AS sekala_project_semasa_id',
                                            'krt__projek_ekonomi.sekala_project_hadapan_id AS sekala_project_hadapan_id',
                                            'krt__projek_ekonomi.projek_jaringan AS projek_jaringan',
                                            'krt__projek_ekonomi.projek_tahun AS projek_tahun',
                                            'krt__projek_ekonomi.projek_impak AS projek_impak')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__projek_ekonomi.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__projek_ekonomi.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.semakan-projek-ekonomi-krt-1', compact('roles_menu','projek_ekonomi'));
        }
    }

    function post_semakan_projek_ekonomi(Request $request){
        $action = $request->post_semakan_projek_ekonomi;
        $app_id = $request->spek_projek_ekonomi_id;
        
        
        $rules = array(
            'spek_status'                  => 'required',
            'spek_disemak_note'            => 'required',
        );

        $messages = [
            'spek_status.required'         => 'Ruangan Status mesti dipilih',
            'spek_disemak_note.required'   => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $semakan_projek_ekonomi                    = KRT_Projek_Ekonomi::where($where)->first();
                $semakan_projek_ekonomi->status            = $request->spek_status;
                $semakan_projek_ekonomi->disemak_note      = $request->spek_disemak_note;
                $semakan_projek_ekonomi->disemak_by        = Auth::user()->user_id;
                $semakan_projek_ekonomi->disemak_date      = date('Y-m-d H:i:s');
                $semakan_projek_ekonomi->save();
            }
        }
    }

    function pengesahan_projek_ekonomi_krt(Request $request){
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
            $data = DB::table('krt__projek_ekonomi')
                        ->select('krt__projek_ekonomi.id',
                               'ref__daerahs.daerah_description AS daerah',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__projek_ekonomi.projek_nama AS projek_nama',
                               'krt__projek_ekonomi.projek_tahun AS projek_tahun',
                               'ref__status_krt_pelaksanaan_projek.status_description AS status_projek',
                               'ref__status_krt_projek_ekonomi.status_description AS status_description',
                               'krt__projek_ekonomi.status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__projek_ekonomi.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__status_krt_pelaksanaan_projek','ref__status_krt_pelaksanaan_projek.id','=','krt__projek_ekonomi.status_pelaksanaan_projek_id')
                        ->leftJoin('ref__status_krt_projek_ekonomi','ref__status_krt_projek_ekonomi.id','=','krt__projek_ekonomi.status')
                        ->orderBy('krt__projek_ekonomi.id', 'asc')
                        ->whereIn('krt__projek_ekonomi.status', [6])
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
            return view('rt-sm10.pengesahan-projek-ekonomi-krt', compact('roles_menu','daerah','krt'));
        }
    }
    
    function pengesahan_projek_ekonomi_krt_1(Request $request, $id){
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
            $projek_ekonomi     = DB::table('krt__projek_ekonomi')
                                    ->select('krt__projek_ekonomi.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__projek_ekonomi.projek_nama AS projek_nama',
                                            'krt__projek_ekonomi.projek_penerangan AS projek_penerangan',
                                            'krt__projek_ekonomi.status_pelaksanaan_projek_id AS status_pelaksanaan_projek_id',
                                            'krt__projek_ekonomi.sekala_project_semasa_id AS sekala_project_semasa_id',
                                            'krt__projek_ekonomi.sekala_project_hadapan_id AS sekala_project_hadapan_id',
                                            'krt__projek_ekonomi.projek_jaringan AS projek_jaringan',
                                            'krt__projek_ekonomi.projek_tahun AS projek_tahun',
                                            'krt__projek_ekonomi.projek_impak AS projek_impak')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__projek_ekonomi.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__projek_ekonomi.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.pengesahan-projek-ekonomi-krt-1', compact('roles_menu','projek_ekonomi'));
        }
    }

    function post_pengesahan_projek_ekonomi(Request $request){
        $action = $request->post_pengesahan_projek_ekonomi;
        $app_id = $request->ppepn_projek_ekonomi_id;
        
        
        $rules = array(
            'ppepn_status'                 => 'required',
            'ppepn_disahkan_note'          => 'required',
        );

        $messages = [
            'ppepn_status.required'        => 'Ruangan Status mesti dipilih',
            'ppepn_disahkan_note.required' => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $pengesahan_projek_ekonomi                    = KRT_Projek_Ekonomi::where($where)->first();
                $pengesahan_projek_ekonomi->status            = $request->ppepn_status;
                $pengesahan_projek_ekonomi->disahkan_note     = $request->ppepn_disahkan_note;
                $pengesahan_projek_ekonomi->disahkan_by       = Auth::user()->user_id;
                $pengesahan_projek_ekonomi->disahkan_date     = date('Y-m-d H:i:s');
                $pengesahan_projek_ekonomi->save();
            }
        }
    }

    function senarai_projek_ekonomi_krt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__projek_ekonomi')
                        ->select('krt__projek_ekonomi.id',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__projek_ekonomi.projek_nama AS projek_nama',
                               'krt__projek_ekonomi.projek_tahun AS projek_tahun',
                               'ref__status_krt_pelaksanaan_projek.status_description AS status_projek',
                               'ref__status_krt_projek_ekonomi.status_description AS status_description',
                               'krt__projek_ekonomi.status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__projek_ekonomi.krt_profile_id')
                        ->leftJoin('ref__status_krt_pelaksanaan_projek','ref__status_krt_pelaksanaan_projek.id','=','krt__projek_ekonomi.status_pelaksanaan_projek_id')
                        ->leftJoin('ref__status_krt_projek_ekonomi','ref__status_krt_projek_ekonomi.id','=','krt__projek_ekonomi.status')
                        ->orderBy('krt__projek_ekonomi.id', 'asc')
                        ->whereIn('krt__projek_ekonomi.status', [1])
                        ->where('krt__projek_ekonomi.krt_profile_id', '=', Auth::user()->krt_id)
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
            return view('rt-sm10.senarai-projek-ekonomi-krt',compact('roles_menu'));
        }
    }

    function senarai_projek_ekonomi_krt_1(Request $request, $id){
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
            $projek_ekonomi     = DB::table('krt__projek_ekonomi')
                                    ->select('krt__projek_ekonomi.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__projek_ekonomi.projek_nama AS projek_nama',
                                            'krt__projek_ekonomi.projek_penerangan AS projek_penerangan',
                                            'krt__projek_ekonomi.status_pelaksanaan_projek_id AS status_pelaksanaan_projek_id',
                                            'krt__projek_ekonomi.sekala_project_semasa_id AS sekala_project_semasa_id',
                                            'krt__projek_ekonomi.sekala_project_hadapan_id AS sekala_project_hadapan_id',
                                            'krt__projek_ekonomi.projek_jaringan AS projek_jaringan',
                                            'krt__projek_ekonomi.projek_tahun AS projek_tahun',
                                            'krt__projek_ekonomi.projek_impak AS projek_impak')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__projek_ekonomi.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__projek_ekonomi.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.senarai-projek-ekonomi-krt-1', compact('roles_menu','projek_ekonomi'));
        }
    }

    function senarai_projek_ekonomi_krt_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__projek_ekonomi')
                        ->select('krt__projek_ekonomi.id',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__projek_ekonomi.projek_nama AS projek_nama',
                               'krt__projek_ekonomi.projek_tahun AS projek_tahun',
                               'ref__status_krt_pelaksanaan_projek.status_description AS status_projek',
                               'ref__status_krt_projek_ekonomi.status_description AS status_description',
                               'krt__projek_ekonomi.status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__projek_ekonomi.krt_profile_id')
                        ->leftJoin('ref__status_krt_pelaksanaan_projek','ref__status_krt_pelaksanaan_projek.id','=','krt__projek_ekonomi.status_pelaksanaan_projek_id')
                        ->leftJoin('ref__status_krt_projek_ekonomi','ref__status_krt_projek_ekonomi.id','=','krt__projek_ekonomi.status')
                        ->orderBy('krt__projek_ekonomi.id', 'asc')
                        ->whereIn('krt__projek_ekonomi.status', [1])
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
            $krt  = KRT_Profile::where('krt_status', '=',  true)
            ->where('krt__profile.daerah_id','=',Auth::user()->daerah_id)
            ->get();
            return view('rt-sm10.senarai-projek-ekonomi-krt-ppd', compact('roles_menu','krt'));
        }
    }

    function senarai_projek_ekonomi_krt_ppd_1(Request $request, $id){
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
            $projek_ekonomi     = DB::table('krt__projek_ekonomi')
                                    ->select('krt__projek_ekonomi.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__projek_ekonomi.projek_nama AS projek_nama',
                                            'krt__projek_ekonomi.projek_penerangan AS projek_penerangan',
                                            'krt__projek_ekonomi.status_pelaksanaan_projek_id AS status_pelaksanaan_projek_id',
                                            'krt__projek_ekonomi.sekala_project_semasa_id AS sekala_project_semasa_id',
                                            'krt__projek_ekonomi.sekala_project_hadapan_id AS sekala_project_hadapan_id',
                                            'krt__projek_ekonomi.projek_jaringan AS projek_jaringan',
                                            'krt__projek_ekonomi.projek_tahun AS projek_tahun',
                                            'krt__projek_ekonomi.projek_impak AS projek_impak')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__projek_ekonomi.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__projek_ekonomi.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.senarai-projek-ekonomi-krt-ppd-1', compact('roles_menu','projek_ekonomi'));
        }
    }

    function senarai_projek_ekonomi_krt_ppn(Request $request){
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
            $data = DB::table('krt__projek_ekonomi')
                        ->select('krt__projek_ekonomi.id',
                               'ref__daerahs.daerah_description AS daerah',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__projek_ekonomi.projek_nama AS projek_nama',
                               'krt__projek_ekonomi.projek_tahun AS projek_tahun',
                               'ref__status_krt_pelaksanaan_projek.status_description AS status_projek',
                               'ref__status_krt_projek_ekonomi.status_description AS status_description',
                               'krt__projek_ekonomi.status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__projek_ekonomi.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__status_krt_pelaksanaan_projek','ref__status_krt_pelaksanaan_projek.id','=','krt__projek_ekonomi.status_pelaksanaan_projek_id')
                        ->leftJoin('ref__status_krt_projek_ekonomi','ref__status_krt_projek_ekonomi.id','=','krt__projek_ekonomi.status')
                        ->orderBy('krt__projek_ekonomi.id', 'asc')
                        ->whereIn('krt__projek_ekonomi.status', [1])
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
            return view('rt-sm10.senarai-projek-ekonomi-krt-ppn', compact('roles_menu','daerah','krt'));
        }
    }

    function senarai_projek_ekonomi_krt_ppn_1(Request $request, $id){
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
            $projek_ekonomi     = DB::table('krt__projek_ekonomi')
                                    ->select('krt__projek_ekonomi.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__projek_ekonomi.projek_nama AS projek_nama',
                                            'krt__projek_ekonomi.projek_penerangan AS projek_penerangan',
                                            'krt__projek_ekonomi.status_pelaksanaan_projek_id AS status_pelaksanaan_projek_id',
                                            'krt__projek_ekonomi.sekala_project_semasa_id AS sekala_project_semasa_id',
                                            'krt__projek_ekonomi.sekala_project_hadapan_id AS sekala_project_hadapan_id',
                                            'krt__projek_ekonomi.projek_jaringan AS projek_jaringan',
                                            'krt__projek_ekonomi.projek_tahun AS projek_tahun',
                                            'krt__projek_ekonomi.projek_impak AS projek_impak')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__projek_ekonomi.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__projek_ekonomi.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.senarai-projek-ekonomi-krt-ppn-1', compact('roles_menu','projek_ekonomi'));
        }
    }

    function senarai_projek_ekonomi_krt_hqrt(Request $request){
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
            $data = DB::table('krt__projek_ekonomi')
                        ->select('krt__projek_ekonomi.id',
                               'ref__states.state_description AS state',
                               'ref__daerahs.daerah_description AS daerah',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__projek_ekonomi.projek_nama AS projek_nama',
                               'krt__projek_ekonomi.projek_tahun AS projek_tahun',
                               'ref__status_krt_pelaksanaan_projek.status_description AS status_projek',
                               'ref__status_krt_projek_ekonomi.status_description AS status_description',
                               'krt__projek_ekonomi.status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__projek_ekonomi.krt_profile_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__status_krt_pelaksanaan_projek','ref__status_krt_pelaksanaan_projek.id','=','krt__projek_ekonomi.status_pelaksanaan_projek_id')
                        ->leftJoin('ref__status_krt_projek_ekonomi','ref__status_krt_projek_ekonomi.id','=','krt__projek_ekonomi.status')
                        ->orderBy('krt__projek_ekonomi.id', 'asc')
                        ->whereIn('krt__projek_ekonomi.status', [1])
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
            return view('rt-sm10.senarai-projek-ekonomi-krt-hqrt', compact('roles_menu','state','daerah','krt'));
        }
    }

    function senarai_projek_ekonomi_krt_hqrt_1(Request $request, $id){
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
            $projek_ekonomi     = DB::table('krt__projek_ekonomi')
                                    ->select('krt__projek_ekonomi.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__projek_ekonomi.projek_nama AS projek_nama',
                                            'krt__projek_ekonomi.projek_penerangan AS projek_penerangan',
                                            'krt__projek_ekonomi.status_pelaksanaan_projek_id AS status_pelaksanaan_projek_id',
                                            'krt__projek_ekonomi.sekala_project_semasa_id AS sekala_project_semasa_id',
                                            'krt__projek_ekonomi.sekala_project_hadapan_id AS sekala_project_hadapan_id',
                                            'krt__projek_ekonomi.projek_jaringan AS projek_jaringan',
                                            'krt__projek_ekonomi.projek_tahun AS projek_tahun',
                                            'krt__projek_ekonomi.projek_impak AS projek_impak')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__projek_ekonomi.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__projek_ekonomi.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.senarai-projek-ekonomi-krt-hqrt-1', compact('roles_menu','projek_ekonomi'));
        }
    }

    function pelaksanaan_projek_ekonomi_st_krt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__projek_ekonomi_st')
                        ->select('krt__projek_ekonomi_st.id',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__projek_ekonomi_st.projek_st_nama AS projek_st_nama',
                               'krt__projek_ekonomi_st.projek_st_kategori AS projek_st_kategori',
                               'krt__projek_ekonomi_st.projek_st_tahun AS projek_st_tahun',
                               'ref__status_krt_projek_ekonomi_st.status_description AS status_description',
                               'krt__projek_ekonomi_st.status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__projek_ekonomi_st.krt_profile_id')
                        ->leftJoin('ref__status_krt_projek_ekonomi_st','ref__status_krt_projek_ekonomi_st.id','=','krt__projek_ekonomi_st.status')
                        ->orderBy('krt__projek_ekonomi_st.id', 'asc')
                        ->whereIn('krt__projek_ekonomi_st.status', [3,4,5,6,7])
                        ->where('krt__projek_ekonomi_st.krt_profile_id', '=', Auth::user()->krt_id)
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
            return view('rt-sm10.pelaksanaan-projek-ekonomi-st-krt',compact('roles_menu'));
        }
    }

    function post_pelaksanaan_projek_ekonomi_st(Request $request){
        
        $action = $request->add_pelaksanaan_projek_ekonomi_st;
        
        $rules = array(
           
        );

        $messages = [
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm10.pelaksanaan_projek_ekonomi_st_krt'))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'add') {
                $projek_ekonomi_st                    = new KRT_Projek_Ekonomi_ST;
                $projek_ekonomi_st->krt_profile_id    = Auth::user()->krt_id;
                $projek_ekonomi_st->status            = 3;
                $projek_ekonomi_st->save();
            }
            return Redirect::to(route('rt-sm10.pelaksanaan_projek_ekonomi_st_krt_1',$projek_ekonomi_st->id));
        }

    }

    function pelaksanaan_projek_ekonomi_st_krt_1(Request $request, $id){
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
            $projek_ekonomi_st      = DB::table('krt__projek_ekonomi_st')
                                    ->select('krt__projek_ekonomi_st.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__projek_ekonomi_st.projek_st_nama AS projek_st_nama',
                                            'krt__projek_ekonomi_st.projek_st_kategori AS projek_st_kategori',
                                            'krt__projek_ekonomi_st.projek_st_cabaran AS projek_st_cabaran',
                                            'krt__projek_ekonomi_st.projek_st_peruntukan_jabatan AS projek_st_peruntukan_jabatan',
                                            'krt__projek_ekonomi_st.projek_st_tahun AS projek_st_tahun',
                                            'krt__projek_ekonomi_st.projek_st_pendapatan AS projek_st_pendapatan',
                                            'krt__projek_ekonomi_st.projek_st_pembelanjaan AS projek_st_pembelanjaan',
                                            'krt__projek_ekonomi_st.status AS status',
                                            'ref__status_krt_projek_ekonomi_st.status_description AS status_description',
                                            'krt__projek_ekonomi_st.disemak_note AS disemak_note',
                                            'krt__projek_ekonomi_st.disahkan_note AS disahkan_note')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__projek_ekonomi_st.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_krt_projek_ekonomi_st','ref__status_krt_projek_ekonomi_st.id','=','krt__projek_ekonomi_st.status')
                                    ->where('krt__projek_ekonomi_st.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.pelaksanaan-projek-ekonomi-st-krt-1', compact('roles_menu','projek_ekonomi_st'));
        }
    }

    function get_peserta_table(Request $request, $id){
        $data = DB::table('krt__projek_ekonomi_st_peserta')
                ->select('krt__projek_ekonomi_st_peserta.*')
                ->where('krt__projek_ekonomi_st_peserta.projek_ekonomi_st_id', '=', $id)
                ->get();
        return Datatables::of($data)
                ->make(true);
    }

    function post_peserta_projek_ekonomi(Request $request){
        $action = $request->add_maklumat_peserta;
        $app_id = $request->ppesk2_pelaksanaan_projek_ekonomi_id;
        
        $rules = array(
            'ppesk2_nama_peserta'                 => 'required'
        );

        $messages = [
            'ppesk2_nama_peserta.required'        => 'Ruangan nama peserta projek mesti diisi'
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $peserta = new KRT_Projek_Ekonomi_ST_Peserta;
                $peserta->projek_ekonomi_st_id    = $request->ppesk2_pelaksanaan_projek_ekonomi_id;
                $peserta->nama_peserta            = $request->ppesk2_nama_peserta;
                $peserta->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_peserta($id){
        $data = DB::table('krt__projek_ekonomi_st_peserta')->where('id', '=', $id)->delete();
    }

    function post_pelaksanaan_projek_ekonomi_1(Request $request){
        $action = $request->post_pelaksanaan_projek_ekonomi_1;
        $app_id = $request->ppesk3_pelaksanaan_projek_ekonomi_id;
        
        $rules = array(
            'ppesk1_projek_st_nama'                         => 'required',
            'ppesk1_projek_st_kategori'                     => 'required',
            'ppesk1_projek_st_cabaran'                      => 'required',
            'ppesk1_projek_st_peruntukan_jabatan'           => 'required',
            'ppesk1_projek_st_tahun'                        => 'required',
            'ppesk1_projek_st_pendapatan'                   => 'required',
            'ppesk1_projek_st_pembelanjaan'                 => 'required',
        );

        $messages = [
            'ppesk1_projek_st_nama.required'                => 'Ruangan Nama Projek diisi',
            'ppesk1_projek_st_kategori.required'            => 'Ruangan Kategori Projek mesti diisi',
            'ppesk1_projek_st_cabaran.required'             => 'Ruangan Cabaran mesti diisi',
            'ppesk1_projek_st_peruntukan_jabatan.required'  => 'Ruangan Peruntukan Diterima mesti diisi',
            'ppesk1_projek_st_tahun.required'               => 'Ruangan Tahun Mula Projek mesti diisi',
            'ppesk1_projek_st_pendapatan.required'          => 'Ruangan Pendapatan Hasil Projek mesti diisi',
            'ppesk1_projek_st_pembelanjaan.required'        => 'Ruangan Pembelanjaan Projek mesti diisi',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $projek_ekonomi_st = KRT_Projek_Ekonomi_ST::where($where)->first();
                $projek_ekonomi_st->projek_st_nama               = $request->ppesk1_projek_st_nama;
                $projek_ekonomi_st->projek_st_kategori           = $request->ppesk1_projek_st_kategori;
                $projek_ekonomi_st->projek_st_cabaran            = $request->ppesk1_projek_st_cabaran;
                $projek_ekonomi_st->projek_st_peruntukan_jabatan = $request->ppesk1_projek_st_peruntukan_jabatan;
                $projek_ekonomi_st->projek_st_tahun              = $request->ppesk1_projek_st_tahun;
                $projek_ekonomi_st->projek_st_pendapatan         = $request->ppesk1_projek_st_pendapatan;
                $projek_ekonomi_st->projek_st_pembelanjaan       = $request->ppesk1_projek_st_pembelanjaan;
                $projek_ekonomi_st->status                       = 4;
                $projek_ekonomi_st->dihantar_by                  = Auth::user()->user_id;
                $projek_ekonomi_st->dihantar_date                = date('Y-m-d H:i:s');
                $projek_ekonomi_st->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function semakan_projek_ekonomi_st_krt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__projek_ekonomi_st')
                        ->select('krt__projek_ekonomi_st.id',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__projek_ekonomi_st.projek_st_nama AS projek_st_nama',
                               'krt__projek_ekonomi_st.projek_st_kategori AS projek_st_kategori',
                               'krt__projek_ekonomi_st.projek_st_tahun AS projek_st_tahun',
                               'ref__status_krt_projek_ekonomi_st.status_description AS status_description',
                               'krt__projek_ekonomi_st.status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__projek_ekonomi_st.krt_profile_id')
                        ->leftJoin('ref__status_krt_projek_ekonomi_st','ref__status_krt_projek_ekonomi_st.id','=','krt__projek_ekonomi_st.status')
                        ->orderBy('krt__projek_ekonomi_st.id', 'asc')
                        ->whereIn('krt__projek_ekonomi_st.status', [4])
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
            $krt  = KRT_Profile::where('krt_status', '=',  true)
            ->where('krt__profile.daerah_id','=',Auth::user()->daerah_id)
            ->get();
            return view('rt-sm10.semakan-projek-ekonomi-st-krt', compact('roles_menu','krt'));
        }
    }

    function semakan_projek_ekonomi_st_krt_1(Request $request, $id){
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
            $projek_ekonomi_st      = DB::table('krt__projek_ekonomi_st')
                                    ->select('krt__projek_ekonomi_st.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__projek_ekonomi_st.projek_st_nama AS projek_st_nama',
                                            'krt__projek_ekonomi_st.projek_st_kategori AS projek_st_kategori',
                                            'krt__projek_ekonomi_st.projek_st_cabaran AS projek_st_cabaran',
                                            'krt__projek_ekonomi_st.projek_st_peruntukan_jabatan AS projek_st_peruntukan_jabatan',
                                            'krt__projek_ekonomi_st.projek_st_tahun AS projek_st_tahun',
                                            'krt__projek_ekonomi_st.projek_st_pendapatan AS projek_st_pendapatan',
                                            'krt__projek_ekonomi_st.projek_st_pembelanjaan AS projek_st_pembelanjaan')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__projek_ekonomi_st.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_krt_projek_ekonomi_st','ref__status_krt_projek_ekonomi_st.id','=','krt__projek_ekonomi_st.status')
                                    ->where('krt__projek_ekonomi_st.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.semakan-projek-ekonomi-st-krt-1', compact('roles_menu','projek_ekonomi_st'));
        }
    }

    function post_semakan_pelaksanaan_projek_ekonomi(Request $request){
        $action = $request->post_semakan_pelaksanaan_projek_ekonomi;
        $app_id = $request->spesk_pelaksanaan_projek_ekonomi_id;
        
        
        $rules = array(
            'spesk_status'                  => 'required',
            'spesk_disemak_note'            => 'required',
        );

        $messages = [
            'spesk_status.required'         => 'Ruangan Status mesti dipilih',
            'spesk_disemak_note.required'   => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $semakan_pelaksanaan_projek_ekonomi                    = KRT_Projek_Ekonomi_ST::where($where)->first();
                $semakan_pelaksanaan_projek_ekonomi->status            = $request->spesk_status;
                $semakan_pelaksanaan_projek_ekonomi->disemak_note      = $request->spesk_disemak_note;
                $semakan_pelaksanaan_projek_ekonomi->disemak_by        = Auth::user()->user_id;
                $semakan_pelaksanaan_projek_ekonomi->disemak_date      = date('Y-m-d H:i:s');
                $semakan_pelaksanaan_projek_ekonomi->save();
            }
        }
    }

    function pengesahan_projek_ekonomi_st_krt(Request $request){
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
            $data = DB::table('krt__projek_ekonomi_st')
                        ->select('krt__projek_ekonomi_st.id',
                               'ref__daerahs.daerah_description AS daerah',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__projek_ekonomi_st.projek_st_nama AS projek_st_nama',
                               'krt__projek_ekonomi_st.projek_st_kategori AS projek_st_kategori',
                               'krt__projek_ekonomi_st.projek_st_tahun AS projek_st_tahun',
                               'ref__status_krt_projek_ekonomi_st.status_description AS status_description',
                               'krt__projek_ekonomi_st.status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__projek_ekonomi_st.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__status_krt_projek_ekonomi_st','ref__status_krt_projek_ekonomi_st.id','=','krt__projek_ekonomi_st.status')
                        ->orderBy('krt__projek_ekonomi_st.id', 'asc')
                        ->whereIn('krt__projek_ekonomi_st.status', [6])
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
            return view('rt-sm10.pengesahan-projek-ekonomi-st-krt', compact('roles_menu','daerah','krt'));
        }
    }

    function pengesahan_projek_ekonomi_st_krt_1(Request $request, $id){
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
            $projek_ekonomi_st      = DB::table('krt__projek_ekonomi_st')
                                    ->select('krt__projek_ekonomi_st.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__projek_ekonomi_st.projek_st_nama AS projek_st_nama',
                                            'krt__projek_ekonomi_st.projek_st_kategori AS projek_st_kategori',
                                            'krt__projek_ekonomi_st.projek_st_cabaran AS projek_st_cabaran',
                                            'krt__projek_ekonomi_st.projek_st_peruntukan_jabatan AS projek_st_peruntukan_jabatan',
                                            'krt__projek_ekonomi_st.projek_st_tahun AS projek_st_tahun',
                                            'krt__projek_ekonomi_st.projek_st_pendapatan AS projek_st_pendapatan',
                                            'krt__projek_ekonomi_st.projek_st_pembelanjaan AS projek_st_pembelanjaan')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__projek_ekonomi_st.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_krt_projek_ekonomi_st','ref__status_krt_projek_ekonomi_st.id','=','krt__projek_ekonomi_st.status')
                                    ->where('krt__projek_ekonomi_st.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.pengesahan-projek-ekonomi-st-krt-1', compact('roles_menu','projek_ekonomi_st'));
        }
    }

    function post_pengesahan_pelaksanaan_projek_ekonomi(Request $request){
        $action = $request->post_pengesahan_pelaksanaan_projek_ekonomi;
        $app_id = $request->ppespn_pelaksanaan_projek_ekonomi_id;
        
        
        $rules = array(
            'ppespn_status'                 => 'required',
            'ppespn_disahkan_note'          => 'required',
        );

        $messages = [
            'ppespn_status.required'        => 'Ruangan Status mesti dipilih',
            'ppespn_disahkan_note.required' => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $pengesahan_projek_ekonomi                    = KRT_Projek_Ekonomi_ST::where($where)->first();
                $pengesahan_projek_ekonomi->status            = $request->ppespn_status;
                $pengesahan_projek_ekonomi->disahkan_note     = $request->ppespn_disahkan_note;
                $pengesahan_projek_ekonomi->disahkan_by       = Auth::user()->user_id;
                $pengesahan_projek_ekonomi->disahkan_date     = date('Y-m-d H:i:s');
                $pengesahan_projek_ekonomi->save();
            }
        }
    }
    
    function senarai_pelaksanaan_projek_ekonomi_krt (Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__projek_ekonomi_st')
                        ->select('krt__projek_ekonomi_st.id',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__projek_ekonomi_st.projek_st_nama AS projek_st_nama',
                               'krt__projek_ekonomi_st.projek_st_kategori AS projek_st_kategori',
                               'krt__projek_ekonomi_st.projek_st_tahun AS projek_st_tahun',
                               'ref__status_krt_projek_ekonomi_st.status_description AS status_description',
                               'krt__projek_ekonomi_st.status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__projek_ekonomi_st.krt_profile_id')
                        ->leftJoin('ref__status_krt_projek_ekonomi_st','ref__status_krt_projek_ekonomi_st.id','=','krt__projek_ekonomi_st.status')
                        ->orderBy('krt__projek_ekonomi_st.id', 'asc')
                        ->whereIn('krt__projek_ekonomi_st.status', [1])
                        ->where('krt__projek_ekonomi_st.krt_profile_id', '=', Auth::user()->krt_id)
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
            return view('rt-sm10.senarai-pelaksanaan-projek-ekonomi-krt',compact('roles_menu'));
        }
    }

    function senarai_pelaksanaan_projek_ekonomi_krt_1(Request $request, $id){
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
            $projek_ekonomi_st      = DB::table('krt__projek_ekonomi_st')
                                    ->select('krt__projek_ekonomi_st.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__projek_ekonomi_st.projek_st_nama AS projek_st_nama',
                                            'krt__projek_ekonomi_st.projek_st_kategori AS projek_st_kategori',
                                            'krt__projek_ekonomi_st.projek_st_cabaran AS projek_st_cabaran',
                                            'krt__projek_ekonomi_st.projek_st_peruntukan_jabatan AS projek_st_peruntukan_jabatan',
                                            'krt__projek_ekonomi_st.projek_st_tahun AS projek_st_tahun',
                                            'krt__projek_ekonomi_st.projek_st_pendapatan AS projek_st_pendapatan',
                                            'krt__projek_ekonomi_st.projek_st_pembelanjaan AS projek_st_pembelanjaan')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__projek_ekonomi_st.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_krt_projek_ekonomi_st','ref__status_krt_projek_ekonomi_st.id','=','krt__projek_ekonomi_st.status')
                                    ->where('krt__projek_ekonomi_st.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.senarai-pelaksanaan-projek-ekonomi-krt-1', compact('roles_menu','projek_ekonomi_st'));
        }
    }

    function senarai_pelaksanaan_projek_ekonomi_ppd (Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__projek_ekonomi_st')
                        ->select('krt__projek_ekonomi_st.id',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__projek_ekonomi_st.projek_st_nama AS projek_st_nama',
                               'krt__projek_ekonomi_st.projek_st_kategori AS projek_st_kategori',
                               'krt__projek_ekonomi_st.projek_st_tahun AS projek_st_tahun',
                               'ref__status_krt_projek_ekonomi_st.status_description AS status_description',
                               'krt__projek_ekonomi_st.status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__projek_ekonomi_st.krt_profile_id')
                        ->leftJoin('ref__status_krt_projek_ekonomi_st','ref__status_krt_projek_ekonomi_st.id','=','krt__projek_ekonomi_st.status')
                        ->orderBy('krt__projek_ekonomi_st.id', 'asc')
                        ->whereIn('krt__projek_ekonomi_st.status', [1])
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
            $krt    = KRT_Profile::where('krt_status', '=',  true)
                    ->where('krt__profile.daerah_id','=',Auth::user()->daerah_id)
                    ->get();
            return view('rt-sm10.senarai-pelaksanaan-projek-ekonomi-ppd', compact('roles_menu','krt'));
        }
    }

    function senarai_pelaksanaan_projek_ekonomi_ppd_1(Request $request, $id){
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
            $projek_ekonomi_st      = DB::table('krt__projek_ekonomi_st')
                                    ->select('krt__projek_ekonomi_st.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__projek_ekonomi_st.projek_st_nama AS projek_st_nama',
                                            'krt__projek_ekonomi_st.projek_st_kategori AS projek_st_kategori',
                                            'krt__projek_ekonomi_st.projek_st_cabaran AS projek_st_cabaran',
                                            'krt__projek_ekonomi_st.projek_st_peruntukan_jabatan AS projek_st_peruntukan_jabatan',
                                            'krt__projek_ekonomi_st.projek_st_tahun AS projek_st_tahun',
                                            'krt__projek_ekonomi_st.projek_st_pendapatan AS projek_st_pendapatan',
                                            'krt__projek_ekonomi_st.projek_st_pembelanjaan AS projek_st_pembelanjaan')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__projek_ekonomi_st.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_krt_projek_ekonomi_st','ref__status_krt_projek_ekonomi_st.id','=','krt__projek_ekonomi_st.status')
                                    ->where('krt__projek_ekonomi_st.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.senarai-pelaksanaan-projek-ekonomi-ppd-1', compact('roles_menu','projek_ekonomi_st'));
        }
    }

    function senarai_pelaksanaan_projek_ekonomi_ppn (Request $request){
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
            $data = DB::table('krt__projek_ekonomi_st')
                        ->select('krt__projek_ekonomi_st.id',
                               'ref__daerahs.daerah_description AS daerah',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__projek_ekonomi_st.projek_st_nama AS projek_st_nama',
                               'krt__projek_ekonomi_st.projek_st_kategori AS projek_st_kategori',
                               'krt__projek_ekonomi_st.projek_st_tahun AS projek_st_tahun',
                               'ref__status_krt_projek_ekonomi_st.status_description AS status_description',
                               'krt__projek_ekonomi_st.status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__projek_ekonomi_st.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__status_krt_projek_ekonomi_st','ref__status_krt_projek_ekonomi_st.id','=','krt__projek_ekonomi_st.status')
                        ->orderBy('krt__projek_ekonomi_st.id', 'asc')
                        ->whereIn('krt__projek_ekonomi_st.status', [1])
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
            return view('rt-sm10.senarai-pelaksanaan-projek-ekonomi-ppn', compact('roles_menu','daerah','krt'));
        }
    }

    function senarai_pelaksanaan_projek_ekonomi_ppn_1(Request $request, $id){
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
            $projek_ekonomi_st      = DB::table('krt__projek_ekonomi_st')
                                    ->select('krt__projek_ekonomi_st.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__projek_ekonomi_st.projek_st_nama AS projek_st_nama',
                                            'krt__projek_ekonomi_st.projek_st_kategori AS projek_st_kategori',
                                            'krt__projek_ekonomi_st.projek_st_cabaran AS projek_st_cabaran',
                                            'krt__projek_ekonomi_st.projek_st_peruntukan_jabatan AS projek_st_peruntukan_jabatan',
                                            'krt__projek_ekonomi_st.projek_st_tahun AS projek_st_tahun',
                                            'krt__projek_ekonomi_st.projek_st_pendapatan AS projek_st_pendapatan',
                                            'krt__projek_ekonomi_st.projek_st_pembelanjaan AS projek_st_pembelanjaan')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__projek_ekonomi_st.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_krt_projek_ekonomi_st','ref__status_krt_projek_ekonomi_st.id','=','krt__projek_ekonomi_st.status')
                                    ->where('krt__projek_ekonomi_st.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.senarai-pelaksanaan-projek-ekonomi-ppn-1', compact('roles_menu','projek_ekonomi_st'));
        }
    }

    function senarai_pelaksanaan_projek_ekonomi_hqrt(Request $request){
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
            $data = DB::table('krt__projek_ekonomi_st')
                        ->select('krt__projek_ekonomi_st.id',
                               'ref__states.state_description AS state',
                               'ref__daerahs.daerah_description AS daerah',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__projek_ekonomi_st.projek_st_nama AS projek_st_nama',
                               'krt__projek_ekonomi_st.projek_st_kategori AS projek_st_kategori',
                               'krt__projek_ekonomi_st.projek_st_tahun AS projek_st_tahun',
                               'ref__status_krt_projek_ekonomi_st.status_description AS status_description',
                               'krt__projek_ekonomi_st.status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__projek_ekonomi_st.krt_profile_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__status_krt_projek_ekonomi_st','ref__status_krt_projek_ekonomi_st.id','=','krt__projek_ekonomi_st.status')
                        ->orderBy('krt__projek_ekonomi_st.id', 'asc')
                        ->whereIn('krt__projek_ekonomi_st.status', [1])
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
            return view('rt-sm10.senarai-pelaksanaan-projek-ekonomi-hqrt', compact('roles_menu','state','daerah','krt'));
        }
    }

    function senarai_pelaksanaan_projek_ekonomi_hqrt_1(Request $request, $id){
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
            $projek_ekonomi_st      = DB::table('krt__projek_ekonomi_st')
                                    ->select('krt__projek_ekonomi_st.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__projek_ekonomi_st.projek_st_nama AS projek_st_nama',
                                            'krt__projek_ekonomi_st.projek_st_kategori AS projek_st_kategori',
                                            'krt__projek_ekonomi_st.projek_st_cabaran AS projek_st_cabaran',
                                            'krt__projek_ekonomi_st.projek_st_peruntukan_jabatan AS projek_st_peruntukan_jabatan',
                                            'krt__projek_ekonomi_st.projek_st_tahun AS projek_st_tahun',
                                            'krt__projek_ekonomi_st.projek_st_pendapatan AS projek_st_pendapatan',
                                            'krt__projek_ekonomi_st.projek_st_pembelanjaan AS projek_st_pembelanjaan')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__projek_ekonomi_st.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_krt_projek_ekonomi_st','ref__status_krt_projek_ekonomi_st.id','=','krt__projek_ekonomi_st.status')
                                    ->where('krt__projek_ekonomi_st.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.senarai-pelaksanaan-projek-ekonomi-hqrt-1', compact('roles_menu','projek_ekonomi_st'));
        }
    }

    function permohonan_koperasi_krt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__koperasi')
                        ->select('krt__koperasi.id',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__koperasi.koperasi_nama AS koperasi_nama',
                               DB::raw(" DATE_FORMAT(krt__koperasi.koperasi_tarikh_daftar,'%d/%m/%Y') AS koperasi_tarikh_daftar"),
                               'krt__koperasi.koperasi_bilangan_ahli_lembaga AS koperasi_bilangan_ahli_lembaga',
                               'krt__koperasi.koperasi_jumlah_anggota AS koperasi_jumlah_anggota',
                               'ref__status_krt_koperasi_keaktifan.status_description AS status_koperasi_keaktifan',
                               'ref__status_krt_koperasi.status_description AS status_permohonan',
                               'krt__koperasi.status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__koperasi.krt_profile_id')
                        ->leftJoin('ref__status_krt_koperasi_keaktifan','ref__status_krt_koperasi_keaktifan.id','=','krt__koperasi.status_koperasi_id')
                        ->leftJoin('ref__status_krt_koperasi','ref__status_krt_koperasi.id','=','krt__koperasi.status')
                        ->orderBy('krt__koperasi.id', 'asc')
                        ->whereIn('krt__koperasi.status', [3,4,5,6,7])
                        ->where('krt__koperasi.krt_profile_id', '=', Auth::user()->krt_id)
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
            return view('rt-sm10.permohonan-koperasi-krt',compact('roles_menu'));
        }
    }

    function post_permohonan_koperasi(Request $request){
        
        $action = $request->add_permohonan_koperasi;
        
        $rules = array(
           
        );

        $messages = [
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm10.permohonan_koperasi_krt'))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'add') {
                $koperasi                    = new KRT_Koperasi;
                $koperasi->krt_profile_id    = Auth::user()->krt_id;
                $koperasi->status            = 3;
                $koperasi->save();
            }
            return Redirect::to(route('rt-sm10.permohonan_koperasi_krt_1',$koperasi->id));
        }

    }

    function permohonan_koperasi_krt_1(Request $request, $id){
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
            $koperasi     = DB::table('krt__koperasi')
                                    ->select('krt__koperasi.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__koperasi.koperasi_nama AS koperasi_nama',
                                            DB::raw(" DATE_FORMAT(krt__koperasi.koperasi_tarikh_daftar,'%d/%m/%Y') AS koperasi_tarikh_daftar"),
                                            'krt__koperasi.koperasi_bilangan_ahli_lembaga AS koperasi_bilangan_ahli_lembaga',
                                            'krt__koperasi.koperasi_jumlah_anggota AS koperasi_jumlah_anggota',
                                            'krt__koperasi.status_koperasi_id AS status_koperasi_id',
                                            'krt__koperasi.koperasi_pendapatan_semasa AS koperasi_pendapatan_semasa',
                                            'krt__koperasi.koperasi_pendapatan_sebelum AS koperasi_pendapatan_sebelum',
                                            'krt__koperasi.status AS status',
                                            'ref__status_krt_koperasi.status_description AS status_description',
                                            'krt__koperasi.disemak_note AS disemak_note',
                                            'krt__koperasi.disahkan_note AS disahkan_note')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__koperasi.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_krt_koperasi','ref__status_krt_koperasi.id','=','krt__koperasi.status')
                                    ->where('krt__koperasi.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.permohonan-koperasi-krt-1', compact('roles_menu','koperasi'));
        }
    }

    function get_fungsi_koperasi_table(Request $request, $id){
        return DataTables()->of(
            DB::select(DB::raw("
                SELECT
                ref__fungsi_koperasi.id, 
                ref__fungsi_koperasi.fungsi_koperasi_description, 
                ref__fungsi_koperasi.status, 
                krt__koperasi_fungsi.id AS krt_koperasi_fungsi_id, 
                krt__koperasi_fungsi.krt_koperasi_id, 
                krt__koperasi_fungsi.ref_fungsi_koperasi_id
                FROM
                ref__fungsi_koperasi
                LEFT JOIN krt__koperasi_fungsi ON krt__koperasi_fungsi.ref_fungsi_koperasi_id = ref__fungsi_koperasi.id
                AND krt__koperasi_fungsi.krt_koperasi_id ='" . $id . "'
                ORDER BY ref__fungsi_koperasi.id + 0 ASC
            "))
        )->make();
    }

    function post_add_fungsi_koperasi(Request $request){
        $krt_koperasi_id = $request->krt_koperasi_id;
        $krt_koperasi_fungsi_id = $request->krt_koperasi_fungsi_id;
        
        $fungsi_koperasi = new KRT_Koperasi_Fungsi;
        $fungsi_koperasi->krt_koperasi_id           = $krt_koperasi_id;
        $fungsi_koperasi->ref_fungsi_koperasi_id    = $request->krt_koperasi_fungsi_id;
        $fungsi_koperasi->save();

    }

    function post_delete_fungsi_koperasi(Request $request){
        $krt_koperasi_id = $request->krt_koperasi_id;
        $krt_koperasi_fungsi_id = $request->krt_koperasi_fungsi_id;

        $data = DB::table('krt__koperasi_fungsi')
                ->where('krt_koperasi_id', '=', $krt_koperasi_id)
                ->where('ref_fungsi_koperasi_id', '=', $krt_koperasi_fungsi_id)
                ->delete();
    }

    function get_aktiviti_tambahan_koperasi_table(Request $request, $id){
        return DataTables()->of(
            DB::select(DB::raw("
                SELECT
                ref__fungsi_koperasi.id, 
                ref__fungsi_koperasi.fungsi_koperasi_description, 
                ref__fungsi_koperasi.status, 
                krt__koperasi_aktiviti_tambahan.id AS krt_koperasi_fungsi_id, 
                krt__koperasi_aktiviti_tambahan.krt_koperasi_id, 
                krt__koperasi_aktiviti_tambahan.ref_fungsi_koperasi_id
                FROM
                ref__fungsi_koperasi
                LEFT JOIN krt__koperasi_aktiviti_tambahan ON krt__koperasi_aktiviti_tambahan.ref_fungsi_koperasi_id = ref__fungsi_koperasi.id
                AND krt__koperasi_aktiviti_tambahan.krt_koperasi_id ='" . $id . "'
                ORDER BY ref__fungsi_koperasi.id + 0 ASC
            "))
        )->make();
    }

    function post_add_koperasi_aktiviti_tambahan(Request $request){
        $krt_koperasi_id = $request->krt_koperasi_id;
        $krt_koperasi_fungsi_id = $request->krt_koperasi_fungsi_id;
        
        $koperasi_aktiviti_tamabahan = new KRT_Koperasi_Aktiviti_Tambahan;
        $koperasi_aktiviti_tamabahan->krt_koperasi_id           = $krt_koperasi_id;
        $koperasi_aktiviti_tamabahan->ref_fungsi_koperasi_id    = $request->krt_koperasi_fungsi_id;
        $koperasi_aktiviti_tamabahan->save();

    }

    function post_delete_koperasi_aktiviti_tambahan(Request $request){
        $krt_koperasi_id = $request->krt_koperasi_id;
        $krt_koperasi_fungsi_id = $request->krt_koperasi_fungsi_id;

        $data = DB::table('krt__koperasi_aktiviti_tambahan')
                ->where('krt_koperasi_id', '=', $krt_koperasi_id)
                ->where('ref_fungsi_koperasi_id', '=', $krt_koperasi_fungsi_id)
                ->delete();
    }

    function post_permohonan_koperasi_1(Request $request){
        $action = $request->post_permohonan_koperasi_1;
        $app_id = $request->pkk2_koperasi_krt_id;
        
        $rules = array(
            'pkk1_koperasi_nama'                                 => 'required',
            'pkk1_koperasi_tarikh_daftar'                        => 'required',
            'pkk1_koperasi_bilangan_ahli_lembaga'                => 'required',
            'pkk1_koperasi_jumlah_anggota'                       => 'required',
            'pkk1_status_koperasi_id'                            => 'required',
            'pkk1_koperasi_pendapatan_semasa'                    => 'required',
            'pkk1_koperasi_pendapatan_sebelum'                   => 'required',
        );

        $messages = [
            'pkk1_koperasi_nama.required'                        => 'Ruangan nama projek ekonomi diisi',
            'pkk1_koperasi_tarikh_daftar.required'               => 'Ruangan penerangan ringkas mengenai projek mesti diisi',
            'pkk1_koperasi_bilangan_ahli_lembaga.required'       => 'Ruangan status pelaksanaan mesti dipilih',
            'pkk1_koperasi_jumlah_anggota.required'              => 'Ruangan sekala projek (semasa) mesti dipilih',
            'pkk1_status_koperasi_id.required'                   => 'Ruangan sekala projek (sasaran masa hadapan) mesti dipilih',
            'pkk1_koperasi_pendapatan_semasa.required'           => 'Ruangan jaringan kerjasama dan jenis bantuan yang diterima mesti diisi',
            'pkk1_koperasi_pendapatan_sebelum.required'          => 'Ruangan tahun mula projek mesti diisi',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $carbon_obj = Carbon::createFromFormat('d/m/Y', $request->pkk1_koperasi_tarikh_daftar)->format('Y-m-d');
                $koperasi = KRT_Koperasi::where($where)->first();
                $koperasi->koperasi_nama                    = $request->pkk1_koperasi_nama;
                $koperasi->koperasi_tarikh_daftar           = $carbon_obj;
                $koperasi->koperasi_bilangan_ahli_lembaga   = $request->pkk1_koperasi_bilangan_ahli_lembaga;
                $koperasi->koperasi_jumlah_anggota          = $request->pkk1_koperasi_jumlah_anggota;
                $koperasi->status_koperasi_id               = $request->pkk1_status_koperasi_id;
                $koperasi->koperasi_pendapatan_semasa       = $request->pkk1_koperasi_pendapatan_semasa;
                $koperasi->koperasi_pendapatan_sebelum      = $request->pkk1_koperasi_pendapatan_sebelum;
                $koperasi->status                           = 4;
                $koperasi->dihantar_by                      = Auth::user()->user_id;
                $koperasi->dihantar_date                    = date('Y-m-d H:i:s');
                $koperasi->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function semakan_koperasi_krt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__koperasi')
                        ->select('krt__koperasi.id',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__koperasi.koperasi_nama AS koperasi_nama',
                               DB::raw(" DATE_FORMAT(krt__koperasi.koperasi_tarikh_daftar,'%d/%m/%Y') AS koperasi_tarikh_daftar"),
                               'krt__koperasi.koperasi_bilangan_ahli_lembaga AS koperasi_bilangan_ahli_lembaga',
                               'krt__koperasi.koperasi_jumlah_anggota AS koperasi_jumlah_anggota',
                               'ref__status_krt_koperasi_keaktifan.status_description AS status_koperasi_keaktifan',
                               'ref__status_krt_koperasi.status_description AS status_permohonan',
                               'krt__koperasi.status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__koperasi.krt_profile_id')
                        ->leftJoin('ref__status_krt_koperasi_keaktifan','ref__status_krt_koperasi_keaktifan.id','=','krt__koperasi.status_koperasi_id')
                        ->leftJoin('ref__status_krt_koperasi','ref__status_krt_koperasi.id','=','krt__koperasi.status')
                        ->orderBy('krt__koperasi.id', 'asc')
                        ->whereIn('krt__koperasi.status', [4])
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
            $krt  = KRT_Profile::where('krt_status', '=',  true)
            ->where('krt__profile.daerah_id','=',Auth::user()->daerah_id)
            ->get();
            return view('rt-sm10.semakan-koperasi-krt', compact('roles_menu','krt'));
        }
    }

    function semakan_koperasi_krt_1(Request $request, $id){
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
            $koperasi     = DB::table('krt__koperasi')
                                    ->select('krt__koperasi.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__koperasi.koperasi_nama AS koperasi_nama',
                                            DB::raw(" DATE_FORMAT(krt__koperasi.koperasi_tarikh_daftar,'%d/%m/%Y') AS koperasi_tarikh_daftar"),
                                            'krt__koperasi.koperasi_bilangan_ahli_lembaga AS koperasi_bilangan_ahli_lembaga',
                                            'krt__koperasi.koperasi_jumlah_anggota AS koperasi_jumlah_anggota',
                                            'krt__koperasi.status_koperasi_id AS status_koperasi_id',
                                            'krt__koperasi.koperasi_pendapatan_semasa AS koperasi_pendapatan_semasa',
                                            'krt__koperasi.koperasi_pendapatan_sebelum AS koperasi_pendapatan_sebelum')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__koperasi.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_krt_koperasi','ref__status_krt_koperasi.id','=','krt__koperasi.status')
                                    ->where('krt__koperasi.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.semakan-koperasi-krt-1', compact('roles_menu','koperasi'));
        }
    }

    function post_semakan_koperasi(Request $request){
        $action = $request->post_semakan_koperasi;
        $app_id = $request->skk_koperasi_krt_id;
        
        
        $rules = array(
            'skk_status'                  => 'required',
            'skk_disemak_note'            => 'required',
        );

        $messages = [
            'spek_status.required'         => 'Ruangan Status mesti dipilih',
            'spek_disemak_note.required'   => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $semakan_koperasi                    = KRT_Koperasi::where($where)->first();
                $semakan_koperasi->status            = $request->skk_status;
                $semakan_koperasi->disemak_note      = $request->skk_disemak_note;
                $semakan_koperasi->disemak_by        = Auth::user()->user_id;
                $semakan_koperasi->disemak_date      = date('Y-m-d H:i:s');
                $semakan_koperasi->save();
            }
        }
    }

    function pengesahan_koperasi_krt(Request $request){
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
            $data = DB::table('krt__koperasi')
                        ->select('krt__koperasi.id',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__koperasi.koperasi_nama AS koperasi_nama',
                               DB::raw(" DATE_FORMAT(krt__koperasi.koperasi_tarikh_daftar,'%d/%m/%Y') AS koperasi_tarikh_daftar"),
                               'krt__koperasi.koperasi_bilangan_ahli_lembaga AS koperasi_bilangan_ahli_lembaga',
                               'krt__koperasi.koperasi_jumlah_anggota AS koperasi_jumlah_anggota',
                               'ref__status_krt_koperasi_keaktifan.status_description AS status_koperasi_keaktifan',
                               'ref__status_krt_koperasi.status_description AS status_permohonan',
                               'krt__koperasi.status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__koperasi.krt_profile_id')
                        ->leftJoin('ref__status_krt_koperasi_keaktifan','ref__status_krt_koperasi_keaktifan.id','=','krt__koperasi.status_koperasi_id')
                        ->leftJoin('ref__status_krt_koperasi','ref__status_krt_koperasi.id','=','krt__koperasi.status')
                        ->orderBy('krt__koperasi.id', 'asc')
                        ->whereIn('krt__koperasi.status', [6])
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
            return view('rt-sm10.pengesahan-koperasi-krt', compact('roles_menu','daerah','krt'));
        }
    }

    function pengesahan_koperasi_krt_1(Request $request, $id){
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
            $koperasi     = DB::table('krt__koperasi')
                                    ->select('krt__koperasi.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__koperasi.koperasi_nama AS koperasi_nama',
                                            DB::raw(" DATE_FORMAT(krt__koperasi.koperasi_tarikh_daftar,'%d/%m/%Y') AS koperasi_tarikh_daftar"),
                                            'krt__koperasi.koperasi_bilangan_ahli_lembaga AS koperasi_bilangan_ahli_lembaga',
                                            'krt__koperasi.koperasi_jumlah_anggota AS koperasi_jumlah_anggota',
                                            'krt__koperasi.status_koperasi_id AS status_koperasi_id',
                                            'krt__koperasi.koperasi_pendapatan_semasa AS koperasi_pendapatan_semasa',
                                            'krt__koperasi.koperasi_pendapatan_sebelum AS koperasi_pendapatan_sebelum')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__koperasi.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_krt_koperasi','ref__status_krt_koperasi.id','=','krt__koperasi.status')
                                    ->where('krt__koperasi.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.pengesahan-koperasi-krt-1', compact('roles_menu','koperasi'));
        }
    }

    function post_pengesahan_koperasi(Request $request){
        $action = $request->post_pengesahan_koperasi;
        $app_id = $request->pkk_koperasi_krt_id;
        
        
        $rules = array(
            'pkk_status'                 => 'required',
            'pkk_disahkan_note'          => 'required',
        );

        $messages = [
            'pkk_status.required'        => 'Ruangan Status mesti dipilih',
            'pkk_disahkan_note.required' => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $pengesahan_koperasi                    = KRT_Koperasi::where($where)->first();
                $pengesahan_koperasi->status            = $request->pkk_status;
                $pengesahan_koperasi->disahkan_note     = $request->pkk_disahkan_note;
                $pengesahan_koperasi->disahkan_by       = Auth::user()->user_id;
                $pengesahan_koperasi->disahkan_date     = date('Y-m-d H:i:s');
                $pengesahan_koperasi->save();
            }
        }
    }

    function senarai_koperasi_krt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__koperasi')
                        ->select('krt__koperasi.id',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__koperasi.koperasi_nama AS koperasi_nama',
                               DB::raw(" DATE_FORMAT(krt__koperasi.koperasi_tarikh_daftar,'%d/%m/%Y') AS koperasi_tarikh_daftar"),
                               'krt__koperasi.koperasi_bilangan_ahli_lembaga AS koperasi_bilangan_ahli_lembaga',
                               'krt__koperasi.koperasi_jumlah_anggota AS koperasi_jumlah_anggota',
                               'ref__status_krt_koperasi_keaktifan.status_description AS status_koperasi_keaktifan',
                               'ref__status_krt_koperasi.status_description AS status_permohonan',
                               'krt__koperasi.status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__koperasi.krt_profile_id')
                        ->leftJoin('ref__status_krt_koperasi_keaktifan','ref__status_krt_koperasi_keaktifan.id','=','krt__koperasi.status_koperasi_id')
                        ->leftJoin('ref__status_krt_koperasi','ref__status_krt_koperasi.id','=','krt__koperasi.status')
                        ->orderBy('krt__koperasi.id', 'asc')
                        ->whereIn('krt__koperasi.status', [1])
                        ->where('krt__koperasi.krt_profile_id', '=', Auth::user()->krt_id)
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
            return view('rt-sm10.senarai-koperasi-krt',compact('roles_menu'));
        }
    }

    function senarai_koperasi_krt_1(Request $request, $id){
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
            $koperasi     = DB::table('krt__koperasi')
                                    ->select('krt__koperasi.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__koperasi.koperasi_nama AS koperasi_nama',
                                            DB::raw(" DATE_FORMAT(krt__koperasi.koperasi_tarikh_daftar,'%d/%m/%Y') AS koperasi_tarikh_daftar"),
                                            'krt__koperasi.koperasi_bilangan_ahli_lembaga AS koperasi_bilangan_ahli_lembaga',
                                            'krt__koperasi.koperasi_jumlah_anggota AS koperasi_jumlah_anggota',
                                            'krt__koperasi.status_koperasi_id AS status_koperasi_id',
                                            'krt__koperasi.koperasi_pendapatan_semasa AS koperasi_pendapatan_semasa',
                                            'krt__koperasi.koperasi_pendapatan_sebelum AS koperasi_pendapatan_sebelum')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__koperasi.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_krt_koperasi','ref__status_krt_koperasi.id','=','krt__koperasi.status')
                                    ->where('krt__koperasi.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.senarai-koperasi-krt-1', compact('roles_menu','koperasi'));
        }
    }

    function senarai_koperasi_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__koperasi')
                        ->select('krt__koperasi.id',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__koperasi.koperasi_nama AS koperasi_nama',
                               DB::raw(" DATE_FORMAT(krt__koperasi.koperasi_tarikh_daftar,'%d/%m/%Y') AS koperasi_tarikh_daftar"),
                               'krt__koperasi.koperasi_bilangan_ahli_lembaga AS koperasi_bilangan_ahli_lembaga',
                               'krt__koperasi.koperasi_jumlah_anggota AS koperasi_jumlah_anggota',
                               'ref__status_krt_koperasi_keaktifan.status_description AS status_koperasi_keaktifan',
                               'ref__status_krt_koperasi.status_description AS status_permohonan',
                               'krt__koperasi.status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__koperasi.krt_profile_id')
                        ->leftJoin('ref__status_krt_koperasi_keaktifan','ref__status_krt_koperasi_keaktifan.id','=','krt__koperasi.status_koperasi_id')
                        ->leftJoin('ref__status_krt_koperasi','ref__status_krt_koperasi.id','=','krt__koperasi.status')
                        ->orderBy('krt__koperasi.id', 'asc')
                        ->whereIn('krt__koperasi.status', [1])
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
            $krt    = KRT_Profile::where('krt_status', '=',  true)
                    ->where('krt__profile.daerah_id','=',Auth::user()->daerah_id)
                    ->get();
            return view('rt-sm10.senarai-koperasi-ppd', compact('roles_menu','krt'));
        }
    }

    function senarai_koperasi_ppd_1(Request $request, $id){
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
            $koperasi     = DB::table('krt__koperasi')
                                    ->select('krt__koperasi.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__koperasi.koperasi_nama AS koperasi_nama',
                                            DB::raw(" DATE_FORMAT(krt__koperasi.koperasi_tarikh_daftar,'%d/%m/%Y') AS koperasi_tarikh_daftar"),
                                            'krt__koperasi.koperasi_bilangan_ahli_lembaga AS koperasi_bilangan_ahli_lembaga',
                                            'krt__koperasi.koperasi_jumlah_anggota AS koperasi_jumlah_anggota',
                                            'krt__koperasi.status_koperasi_id AS status_koperasi_id',
                                            'krt__koperasi.koperasi_pendapatan_semasa AS koperasi_pendapatan_semasa',
                                            'krt__koperasi.koperasi_pendapatan_sebelum AS koperasi_pendapatan_sebelum')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__koperasi.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_krt_koperasi','ref__status_krt_koperasi.id','=','krt__koperasi.status')
                                    ->where('krt__koperasi.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.senarai-koperasi-ppd-1', compact('roles_menu','koperasi'));
        }
    }

    function senarai_koperasi_ppn(Request $request){
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
            $data = DB::table('krt__koperasi')
                        ->select('krt__koperasi.id',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__koperasi.koperasi_nama AS koperasi_nama',
                               DB::raw(" DATE_FORMAT(krt__koperasi.koperasi_tarikh_daftar,'%d/%m/%Y') AS koperasi_tarikh_daftar"),
                               'krt__koperasi.koperasi_bilangan_ahli_lembaga AS koperasi_bilangan_ahli_lembaga',
                               'krt__koperasi.koperasi_jumlah_anggota AS koperasi_jumlah_anggota',
                               'ref__status_krt_koperasi_keaktifan.status_description AS status_koperasi_keaktifan',
                               'ref__status_krt_koperasi.status_description AS status_permohonan',
                               'krt__koperasi.status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__koperasi.krt_profile_id')
                        ->leftJoin('ref__status_krt_koperasi_keaktifan','ref__status_krt_koperasi_keaktifan.id','=','krt__koperasi.status_koperasi_id')
                        ->leftJoin('ref__status_krt_koperasi','ref__status_krt_koperasi.id','=','krt__koperasi.status')
                        ->orderBy('krt__koperasi.id', 'asc')
                        ->whereIn('krt__koperasi.status', [1])
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
            return view('rt-sm10.senarai-koperasi-ppn', compact('roles_menu','daerah','krt'));
        }
    }

    function senarai_koperasi_ppn_1(Request $request, $id){
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
            $koperasi     = DB::table('krt__koperasi')
                                    ->select('krt__koperasi.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__koperasi.koperasi_nama AS koperasi_nama',
                                            DB::raw(" DATE_FORMAT(krt__koperasi.koperasi_tarikh_daftar,'%d/%m/%Y') AS koperasi_tarikh_daftar"),
                                            'krt__koperasi.koperasi_bilangan_ahli_lembaga AS koperasi_bilangan_ahli_lembaga',
                                            'krt__koperasi.koperasi_jumlah_anggota AS koperasi_jumlah_anggota',
                                            'krt__koperasi.status_koperasi_id AS status_koperasi_id',
                                            'krt__koperasi.koperasi_pendapatan_semasa AS koperasi_pendapatan_semasa',
                                            'krt__koperasi.koperasi_pendapatan_sebelum AS koperasi_pendapatan_sebelum')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__koperasi.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_krt_koperasi','ref__status_krt_koperasi.id','=','krt__koperasi.status')
                                    ->where('krt__koperasi.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.senarai-koperasi-ppn-1', compact('roles_menu','koperasi'));
        }
    }

    function senarai_koperasi_hqrt(Request $request){
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
            $data = DB::table('krt__koperasi')
                        ->select('krt__koperasi.id',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__koperasi.koperasi_nama AS koperasi_nama',
                               DB::raw(" DATE_FORMAT(krt__koperasi.koperasi_tarikh_daftar,'%d/%m/%Y') AS koperasi_tarikh_daftar"),
                               'krt__koperasi.koperasi_bilangan_ahli_lembaga AS koperasi_bilangan_ahli_lembaga',
                               'krt__koperasi.koperasi_jumlah_anggota AS koperasi_jumlah_anggota',
                               'ref__status_krt_koperasi_keaktifan.status_description AS status_koperasi_keaktifan',
                               'ref__status_krt_koperasi.status_description AS status_permohonan',
                               'krt__koperasi.status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__koperasi.krt_profile_id')
                        ->leftJoin('ref__status_krt_koperasi_keaktifan','ref__status_krt_koperasi_keaktifan.id','=','krt__koperasi.status_koperasi_id')
                        ->leftJoin('ref__status_krt_koperasi','ref__status_krt_koperasi.id','=','krt__koperasi.status')
                        ->orderBy('krt__koperasi.id', 'asc')
                        ->whereIn('krt__koperasi.status', [1])
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
            return view('rt-sm10.senarai-koperasi-hqrt', compact('roles_menu','state','daerah','krt'));
        }
    }

    function senarai_koperasi_hqrt_1(Request $request, $id){
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
            $koperasi     = DB::table('krt__koperasi')
                                    ->select('krt__koperasi.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__koperasi.koperasi_nama AS koperasi_nama',
                                            DB::raw(" DATE_FORMAT(krt__koperasi.koperasi_tarikh_daftar,'%d/%m/%Y') AS koperasi_tarikh_daftar"),
                                            'krt__koperasi.koperasi_bilangan_ahli_lembaga AS koperasi_bilangan_ahli_lembaga',
                                            'krt__koperasi.koperasi_jumlah_anggota AS koperasi_jumlah_anggota',
                                            'krt__koperasi.status_koperasi_id AS status_koperasi_id',
                                            'krt__koperasi.koperasi_pendapatan_semasa AS koperasi_pendapatan_semasa',
                                            'krt__koperasi.koperasi_pendapatan_sebelum AS koperasi_pendapatan_sebelum')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__koperasi.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_krt_koperasi','ref__status_krt_koperasi.id','=','krt__koperasi.status')
                                    ->where('krt__koperasi.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.senarai-koperasi-hqrt-1', compact('roles_menu','koperasi'));
        }
    }

    function isu_lokasi_kanta_komuniti_krt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__isu_masalah_lokasi_kanta_komuniti')
                        ->select('krt__isu_masalah_lokasi_kanta_komuniti.id',
                               'krt__isu_masalah_lokasi_kanta_komuniti.isu_lokasi_kanta_komuniti AS isu_lokasi_kanta_komuniti',
                               'krt__isu_masalah_lokasi_kanta_komuniti.isu_kluster AS isu_kluster',
                               'krt__isu_masalah_lokasi_kanta_komuniti.isu_bil_terlibat AS isu_bil_terlibat',
                               'krt__isu_masalah_lokasi_kanta_komuniti.isu_agensi_terlibat AS isu_agensi_terlibat',
                               'krt__isu_masalah_lokasi_kanta_komuniti.isu_status AS isu_status',
                               'krt__isu_masalah_lokasi_kanta_komuniti.status AS status',
                               'ref__status_masalah_kanta_komuniti.status_description AS status_description',
                               'ref__status_isu_lokasi_kanta_komuniti.status_description AS status_desc')
                        ->leftjoin('ref__status_masalah_kanta_komuniti','ref__status_masalah_kanta_komuniti.id','=','krt__isu_masalah_lokasi_kanta_komuniti.isu_status')
                        ->leftjoin('ref__status_isu_lokasi_kanta_komuniti','ref__status_isu_lokasi_kanta_komuniti.id','=','krt__isu_masalah_lokasi_kanta_komuniti.status')
                        ->orderBy('krt__isu_masalah_lokasi_kanta_komuniti.id', 'asc')
                        ->whereIn('krt__isu_masalah_lokasi_kanta_komuniti.status', [3,4,5,6,7])
                        ->where('krt__isu_masalah_lokasi_kanta_komuniti.krt_profile_id', '=', Auth::user()->krt_id)
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
            return view('rt-sm10.isu-lokasi-kanta-komuniti-krt',compact('roles_menu'));
        }
    }

    function post_lapor_isu_lokasi_kanta_komuniti(Request $request){
        
        $action = $request->add_lapor_isu_lokasi_kanta_komuniti;
        
        $rules = array(
           
        );

        $messages = [
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm10.isu_lokasi_kanta_komuniti_krt'))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'add') {
                $isu_lokasi_kk                    = new KRT_Isu_masalah_lokasi_kanta_komuniti;
                $isu_lokasi_kk->krt_profile_id    = Auth::user()->krt_id;
                $isu_lokasi_kk->status            = 3;
                $isu_lokasi_kk->save();
            }
            return Redirect::to(route('rt-sm10.isu_lokasi_kanta_komuniti_krt_1',$isu_lokasi_kk->id));
        }

    }

    function isu_lokasi_kanta_komuniti_krt_1(Request $request, $id){
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
            $ref_kaum       = RefKaum::where('status', '=', true)->get();
            $ref_jantina    = RefJantina::where('status', '=', true)->get();
            $isu_lokasi_kk  = DB::table('krt__isu_masalah_lokasi_kanta_komuniti')
                                    ->select('krt__isu_masalah_lokasi_kanta_komuniti.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_lokasi_kanta_komuniti AS isu_lokasi_kanta_komuniti',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_kluster AS isu_kluster',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_bil_terlibat AS isu_bil_terlibat',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_pelaksanan_daerah AS isu_pelaksanan_daerah',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_pelaksanan_negeri AS isu_pelaksanan_negeri',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_agensi_terlibat AS isu_agensi_terlibat',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_status AS isu_status',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.status AS status',
                                            'ref__status_isu_lokasi_kanta_komuniti.status_description AS status_desc',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.disemak_note AS disemak_note',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.disahkan_note AS disahkan_note')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__isu_masalah_lokasi_kanta_komuniti.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftjoin('ref__status_isu_lokasi_kanta_komuniti','ref__status_isu_lokasi_kanta_komuniti.id','=','krt__isu_masalah_lokasi_kanta_komuniti.status')
                                    ->where('krt__isu_masalah_lokasi_kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.isu-lokasi-kanta-komuniti-krt-1', compact('roles_menu','ref_kaum','ref_jantina','isu_lokasi_kk'));
        }
    }

    function get_senarai_terlibat_table(Request $request, $id){
        $data = DB::table('krt__isu_masalah_lokasi_kanta_komuniti_terlibat')
                    ->select('krt__isu_masalah_lokasi_kanta_komuniti_terlibat.*','ref__kaum.kaum_description','ref__jantina.jantina_description')
                    ->join('ref__kaum','ref__kaum.id','=','krt__isu_masalah_lokasi_kanta_komuniti_terlibat.kaum_id')
                    ->join('ref__jantina','ref__jantina.id','=','krt__isu_masalah_lokasi_kanta_komuniti_terlibat.jantina_id')
                    ->where('krt__isu_masalah_lokasi_kanta_komuniti_terlibat.isu_lokasi_kk_id', '=', $id)
                    ->get();
        return Datatables::of($data)
                    ->make(true);
    }

    function post_isu_lokasi_kk_terlibat(Request $request){
        $action = $request->add_isu_lokasi_kk_terlibat;
        $app_id = $request->ilkk2_isu_lokasi_kk_id;
        
        $rules = array(
            'ilkk2_bilangan'                => 'required|numeric',
            'ilkk2_kaum_id'                 => 'required',
            'ilkk2_jantina_id'              => 'required',
            'ilkk2_umur'                    => 'required|numeric'
        );

        $messages = [
            'ilkk2_bilangan.required'       => 'Ruangan Bilangan mesti diisi',
            'ilkk2_bilangan.numeric'        => 'Ruangan Bilangan mesti diisi dalam bentuk nombor',
            'ilkk2_kaum_id.required'        => 'Ruangan Kaum mesti dipilih',
            'ilkk2_jantina_id.required'     => 'Ruangan Jantina mesti dipilih',
            'ilkk2_umur.required'           => 'Ruangan Umur mesti diisi',
            'ilkk2_umur.numeric'            => 'Ruangan Umur mesti diisi dalam bentuk nombor',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $isu_lokasi_kk_terlibat = new KRT_Isu_masalah_lokasi_kanta_komuniti_terlibat;
                $isu_lokasi_kk_terlibat->isu_lokasi_kk_id   = $app_id;
                $isu_lokasi_kk_terlibat->bilangan           = $request->ilkk2_bilangan;
                $isu_lokasi_kk_terlibat->kaum_id            = $request->ilkk2_kaum_id;
                $isu_lokasi_kk_terlibat->jantina_id         = $request->ilkk2_jantina_id;
                $isu_lokasi_kk_terlibat->umur               = $request->ilkk2_umur;
                $isu_lokasi_kk_terlibat->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_isu_lokasi_kk_terlibat($id){
        $data = DB::table('krt__isu_masalah_lokasi_kanta_komuniti_terlibat')->where('id', '=', $id)->delete();
    }

    function post_lapor_isu_lokasi_kanta_komuniti_1(Request $request){
        $action = $request->post_lapor_isu_lokasi_kanta_komuniti_1;
        $app_id = $request->ilkk4_isu_lokasi_kk_id;
        
        $rules = array(
            'ilkk1_isu_lokasi_kanta_komuniti'               => 'required',
            'ilkk1_isu_bil_terlibat'                        => 'required',
            'ilkk1_isu_kluster'                             => 'required',
            'ilkk3_isu_pelaksanan_daerah'                   => 'required',
            'ilkk3_isu_pelaksanan_negeri'                   => 'required',
            'ilkk3_isu_agensi_terlibat'                     => 'required',
            'ilkk3_isu_status'                              => 'required',
        );

        $messages = [
            'ilkk1_isu_lokasi_kanta_komuniti.required'      => 'Ruangan nama projek ekonomi diisi',
            'ilkk1_isu_bil_terlibat.required'               => 'Ruangan penerangan ringkas mengenai projek mesti diisi',
            'ilkk1_isu_kluster.required'                    => 'Ruangan status pelaksanaan mesti dipilih',
            'ilkk3_isu_pelaksanan_daerah.required'          => 'Ruangan sekala projek (semasa) mesti dipilih',
            'ilkk3_isu_pelaksanan_negeri.required'          => 'Ruangan sekala projek (sasaran masa hadapan) mesti dipilih',
            'ilkk3_isu_agensi_terlibat.required'            => 'Ruangan jaringan kerjasama dan jenis bantuan yang diterima mesti diisi',
            'ilkk3_isu_status.required'                     => 'Ruangan tahun mula projek mesti diisi',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $isu_lokasi_kk = KRT_Isu_masalah_lokasi_kanta_komuniti::where($where)->first();
                $isu_lokasi_kk->isu_lokasi_kanta_komuniti        = $request->ilkk1_isu_lokasi_kanta_komuniti;
                $isu_lokasi_kk->isu_kluster                      = $request->ilkk1_isu_kluster;
                $isu_lokasi_kk->isu_bil_terlibat                 = $request->ilkk1_isu_bil_terlibat;
                $isu_lokasi_kk->isu_pelaksanan_daerah            = $request->ilkk3_isu_pelaksanan_daerah;
                $isu_lokasi_kk->isu_pelaksanan_negeri            = $request->ilkk3_isu_pelaksanan_negeri;
                $isu_lokasi_kk->isu_agensi_terlibat              = $request->ilkk3_isu_agensi_terlibat;
                $isu_lokasi_kk->isu_status                 = $request->ilkk3_isu_status;
                $isu_lokasi_kk->status                           = 4;
                $isu_lokasi_kk->dihantar_by                      = Auth::user()->user_id;
                $isu_lokasi_kk->dihantar_date                    = date('Y-m-d H:i:s');
                $isu_lokasi_kk->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function semakan_isu_lokasi_kanta_komuniti(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__isu_masalah_lokasi_kanta_komuniti')
                        ->select('krt__isu_masalah_lokasi_kanta_komuniti.id',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__isu_masalah_lokasi_kanta_komuniti.isu_lokasi_kanta_komuniti AS isu_lokasi_kanta_komuniti',
                               'krt__isu_masalah_lokasi_kanta_komuniti.isu_kluster AS isu_kluster',
                               'krt__isu_masalah_lokasi_kanta_komuniti.isu_bil_terlibat AS isu_bil_terlibat',
                               'krt__isu_masalah_lokasi_kanta_komuniti.isu_agensi_terlibat AS isu_agensi_terlibat',
                               'krt__isu_masalah_lokasi_kanta_komuniti.isu_status AS isu_status',
                               'krt__isu_masalah_lokasi_kanta_komuniti.status AS status',
                               'ref__status_masalah_kanta_komuniti.status_description AS status_description',
                               'ref__status_isu_lokasi_kanta_komuniti.status_description AS status_desc')
                        ->leftjoin('krt__profile','krt__profile.id','=','krt__isu_masalah_lokasi_kanta_komuniti.krt_profile_id')
                        ->leftjoin('ref__status_masalah_kanta_komuniti','ref__status_masalah_kanta_komuniti.id','=','krt__isu_masalah_lokasi_kanta_komuniti.isu_status')
                        ->leftjoin('ref__status_isu_lokasi_kanta_komuniti','ref__status_isu_lokasi_kanta_komuniti.id','=','krt__isu_masalah_lokasi_kanta_komuniti.status')
                        ->orderBy('krt__isu_masalah_lokasi_kanta_komuniti.id', 'asc')
                        ->whereIn('krt__isu_masalah_lokasi_kanta_komuniti.status', [4])
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
            $krt  = KRT_Profile::where('krt_status', '=',  true)
            ->where('krt__profile.daerah_id','=',Auth::user()->daerah_id)
            ->get();
            return view('rt-sm10.semakan-isu-lokasi-kanta-komuniti', compact('roles_menu','krt'));
        }
    }

    function semakan_isu_lokasi_kanta_komuniti_1(Request $request, $id){
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
            $ref_kaum       = RefKaum::where('status', '=', true)->get();
            $ref_jantina    = RefJantina::where('status', '=', true)->get();
            $isu_lokasi_kk  = DB::table('krt__isu_masalah_lokasi_kanta_komuniti')
                                    ->select('krt__isu_masalah_lokasi_kanta_komuniti.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_lokasi_kanta_komuniti AS isu_lokasi_kanta_komuniti',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_kluster AS isu_kluster',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_bil_terlibat AS isu_bil_terlibat',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_pelaksanan_daerah AS isu_pelaksanan_daerah',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_pelaksanan_negeri AS isu_pelaksanan_negeri',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_agensi_terlibat AS isu_agensi_terlibat',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_status AS isu_status',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.status AS status',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.disemak_note AS disemak_note',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.disahkan_note AS disahkan_note')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__isu_masalah_lokasi_kanta_komuniti.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__isu_masalah_lokasi_kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.semakan-isu-lokasi-kanta-komuniti-1', compact('roles_menu','ref_kaum','ref_jantina','isu_lokasi_kk'));
        }
    }

    function post_semakan_isu_lokasi_kanta_komuniti(Request $request){
        $action = $request->post_semakan_isu_lokasi_kanta_komuniti;
        $app_id = $request->silkk1_isu_lokasi_kk_id;
        
        
        $rules = array(
            'silkk1_status'                  => 'required',
            'silkk1_disemak_note'            => 'required',
        );

        $messages = [
            'silkk1_status.required'         => 'Ruangan Status mesti dipilih',
            'silkk1_disemak_note.required'   => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $semakan_koperasi                    = KRT_Isu_masalah_lokasi_kanta_komuniti::where($where)->first();
                $semakan_koperasi->status            = $request->silkk1_status;
                $semakan_koperasi->disemak_note      = $request->silkk1_disemak_note;
                $semakan_koperasi->disemak_by        = Auth::user()->user_id;
                $semakan_koperasi->disemak_date      = date('Y-m-d H:i:s');
                $semakan_koperasi->save();
            }
        }
    }

    function pengesahan_isu_lokasi_kanta_komuniti(Request $request){
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
            $data = DB::table('krt__isu_masalah_lokasi_kanta_komuniti')
                        ->select('krt__isu_masalah_lokasi_kanta_komuniti.id',
                               'krt__profile.krt_nama AS krt_nama',
                               'ref__daerahs.daerah_description AS daerah_description',
                               'krt__isu_masalah_lokasi_kanta_komuniti.isu_lokasi_kanta_komuniti AS isu_lokasi_kanta_komuniti',
                               'krt__isu_masalah_lokasi_kanta_komuniti.isu_kluster AS isu_kluster',
                               'krt__isu_masalah_lokasi_kanta_komuniti.isu_bil_terlibat AS isu_bil_terlibat',
                               'krt__isu_masalah_lokasi_kanta_komuniti.isu_agensi_terlibat AS isu_agensi_terlibat',
                               'krt__isu_masalah_lokasi_kanta_komuniti.isu_status AS isu_status',
                               'krt__isu_masalah_lokasi_kanta_komuniti.status AS status',
                               'ref__status_masalah_kanta_komuniti.status_description AS status_description',
                               'ref__status_isu_lokasi_kanta_komuniti.status_description AS status_desc')
                        ->leftjoin('krt__profile','krt__profile.id','=','krt__isu_masalah_lokasi_kanta_komuniti.krt_profile_id')
                        ->leftjoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftjoin('ref__status_masalah_kanta_komuniti','ref__status_masalah_kanta_komuniti.id','=','krt__isu_masalah_lokasi_kanta_komuniti.isu_status')
                        ->leftjoin('ref__status_isu_lokasi_kanta_komuniti','ref__status_isu_lokasi_kanta_komuniti.id','=','krt__isu_masalah_lokasi_kanta_komuniti.status')
                        ->orderBy('krt__isu_masalah_lokasi_kanta_komuniti.id', 'asc')
                        ->whereIn('krt__isu_masalah_lokasi_kanta_komuniti.status', [6])
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
            return view('rt-sm10.pengesahan-isu-lokasi-kanta-komuniti', compact('roles_menu','daerah','krt'));
        }
    }

    function pengesahan_isu_lokasi_kanta_komuniti_1(Request $request, $id){
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
            $ref_kaum       = RefKaum::where('status', '=', true)->get();
            $ref_jantina    = RefJantina::where('status', '=', true)->get();
            $isu_lokasi_kk  = DB::table('krt__isu_masalah_lokasi_kanta_komuniti')
                                    ->select('krt__isu_masalah_lokasi_kanta_komuniti.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_lokasi_kanta_komuniti AS isu_lokasi_kanta_komuniti',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_kluster AS isu_kluster',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_bil_terlibat AS isu_bil_terlibat',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_pelaksanan_daerah AS isu_pelaksanan_daerah',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_pelaksanan_negeri AS isu_pelaksanan_negeri',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_agensi_terlibat AS isu_agensi_terlibat',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_status AS isu_status',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.status AS status',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.disemak_note AS disemak_note',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.disahkan_note AS disahkan_note')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__isu_masalah_lokasi_kanta_komuniti.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__isu_masalah_lokasi_kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.pengesahan-isu-lokasi-kanta-komuniti-1', compact('roles_menu','ref_kaum','ref_jantina','isu_lokasi_kk'));
        }
    }

    function post_pengesahan_isu_lokasi_kanta_komuniti(Request $request){
        $action = $request->post_pengesahan_isu_lokasi_kanta_komuniti;
        $app_id = $request->pilkk_koperasi_krt_id;
        
        
        $rules = array(
            'pilkk_status'                   => 'required',
            'pilkk_disahkan_note'            => 'required',
        );

        $messages = [
            'pilkk_status.required'          => 'Ruangan Status mesti dipilih',
            'pilkk_disahkan_note.required'   => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $pengesahan_koperasi                     = KRT_Isu_masalah_lokasi_kanta_komuniti::where($where)->first();
                $pengesahan_koperasi->status             = $request->pilkk_status;
                $pengesahan_koperasi->disahkan_note      = $request->pilkk_disahkan_note;
                $pengesahan_koperasi->disahkan_by        = Auth::user()->user_id;
                $pengesahan_koperasi->disahkan_date      = date('Y-m-d H:i:s');
                $pengesahan_koperasi->save();
            }
        }
    }

    function analisa_isu_lokasi_kanta_komuniti(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__isu_masalah_lokasi_kanta_komuniti')
                        ->select('krt__isu_masalah_lokasi_kanta_komuniti.id',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__isu_masalah_lokasi_kanta_komuniti.isu_lokasi_kanta_komuniti AS isu_lokasi_kanta_komuniti',
                               'krt__isu_masalah_lokasi_kanta_komuniti.isu_kluster AS isu_kluster',
                               'krt__isu_masalah_lokasi_kanta_komuniti.isu_bil_terlibat AS isu_bil_terlibat',
                               'krt__isu_masalah_lokasi_kanta_komuniti.isu_agensi_terlibat AS isu_agensi_terlibat',
                               'krt__isu_masalah_lokasi_kanta_komuniti.isu_status AS isu_status',
                               'krt__isu_masalah_lokasi_kanta_komuniti.status AS status',
                               'ref__status_masalah_kanta_komuniti.status_description AS status_description',
                               'ref__status_isu_lokasi_kanta_komuniti.status_description AS status_desc',
                               DB::raw(" DATE_FORMAT(krt__isu_masalah_lokasi_kanta_komuniti.disahkan_date,'%Y') AS tahun_disahkan"))
                        ->leftjoin('krt__profile','krt__profile.id','=','krt__isu_masalah_lokasi_kanta_komuniti.krt_profile_id')
                        ->leftjoin('ref__status_masalah_kanta_komuniti','ref__status_masalah_kanta_komuniti.id','=','krt__isu_masalah_lokasi_kanta_komuniti.isu_status')
                        ->leftjoin('ref__status_isu_lokasi_kanta_komuniti','ref__status_isu_lokasi_kanta_komuniti.id','=','krt__isu_masalah_lokasi_kanta_komuniti.status')
                        ->orderBy('krt__isu_masalah_lokasi_kanta_komuniti.id', 'asc')
                        ->whereIn('krt__isu_masalah_lokasi_kanta_komuniti.status', [1])
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
            $krt  = KRT_Profile::where('krt_status', '=',  true)
            ->where('krt__profile.daerah_id','=',Auth::user()->daerah_id)
            ->get();
            return view('rt-sm10.analisa-isu-lokasi-kanta-komuniti', compact('roles_menu','krt'));
        }
    }

    function analisa_isu_lokasi_kanta_komuniti_1(Request $request, $id){
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
            $ref_kaum       = RefKaum::where('status', '=', true)->get();
            $ref_jantina    = RefJantina::where('status', '=', true)->get();
            $isu_lokasi_kk  = DB::table('krt__isu_masalah_lokasi_kanta_komuniti')
                                    ->select('krt__isu_masalah_lokasi_kanta_komuniti.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_lokasi_kanta_komuniti AS isu_lokasi_kanta_komuniti',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_kluster AS isu_kluster',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_bil_terlibat AS isu_bil_terlibat',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_pelaksanan_daerah AS isu_pelaksanan_daerah',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_pelaksanan_negeri AS isu_pelaksanan_negeri',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_agensi_terlibat AS isu_agensi_terlibat',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_status AS isu_status',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.status AS status',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.disemak_note AS disemak_note',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.disahkan_note AS disahkan_note')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__isu_masalah_lokasi_kanta_komuniti.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__isu_masalah_lokasi_kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.analisa-isu-lokasi-kanta-komuniti-1', compact('roles_menu','ref_kaum','ref_jantina','isu_lokasi_kk'));
        }
    }

    function analisa_isu_lokasi_kanta_komuniti_ppn(Request $request){
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
            $data = DB::table('krt__isu_masalah_lokasi_kanta_komuniti')
                        ->select('krt__isu_masalah_lokasi_kanta_komuniti.id',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__isu_masalah_lokasi_kanta_komuniti.isu_lokasi_kanta_komuniti AS isu_lokasi_kanta_komuniti',
                               'krt__isu_masalah_lokasi_kanta_komuniti.isu_kluster AS isu_kluster',
                               'krt__isu_masalah_lokasi_kanta_komuniti.isu_bil_terlibat AS isu_bil_terlibat',
                               'krt__isu_masalah_lokasi_kanta_komuniti.isu_agensi_terlibat AS isu_agensi_terlibat',
                               'krt__isu_masalah_lokasi_kanta_komuniti.isu_status AS isu_status',
                               'krt__isu_masalah_lokasi_kanta_komuniti.status AS status',
                               'ref__status_masalah_kanta_komuniti.status_description AS status_description',
                               'ref__status_isu_lokasi_kanta_komuniti.status_description AS status_desc',
                               DB::raw(" DATE_FORMAT(krt__isu_masalah_lokasi_kanta_komuniti.disahkan_date,'%Y') AS tahun_disahkan"))
                        ->leftjoin('krt__profile','krt__profile.id','=','krt__isu_masalah_lokasi_kanta_komuniti.krt_profile_id')
                        ->leftjoin('ref__status_masalah_kanta_komuniti','ref__status_masalah_kanta_komuniti.id','=','krt__isu_masalah_lokasi_kanta_komuniti.isu_status')
                        ->leftjoin('ref__status_isu_lokasi_kanta_komuniti','ref__status_isu_lokasi_kanta_komuniti.id','=','krt__isu_masalah_lokasi_kanta_komuniti.status')
                        ->orderBy('krt__isu_masalah_lokasi_kanta_komuniti.id', 'asc')
                        ->whereIn('krt__isu_masalah_lokasi_kanta_komuniti.status', [1])
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
            return view('rt-sm10.analisa-isu-lokasi-kanta-komuniti-ppn', compact('roles_menu','daerah','krt'));
        }
    }

    function analisa_isu_lokasi_kanta_komuniti_ppn_1(Request $request, $id){
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
            $ref_kaum       = RefKaum::where('status', '=', true)->get();
            $ref_jantina    = RefJantina::where('status', '=', true)->get();
            $isu_lokasi_kk  = DB::table('krt__isu_masalah_lokasi_kanta_komuniti')
                                    ->select('krt__isu_masalah_lokasi_kanta_komuniti.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_lokasi_kanta_komuniti AS isu_lokasi_kanta_komuniti',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_kluster AS isu_kluster',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_bil_terlibat AS isu_bil_terlibat',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_pelaksanan_daerah AS isu_pelaksanan_daerah',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_pelaksanan_negeri AS isu_pelaksanan_negeri',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_agensi_terlibat AS isu_agensi_terlibat',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.isu_status AS isu_status',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.status AS status',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.disemak_note AS disemak_note',
                                            'krt__isu_masalah_lokasi_kanta_komuniti.disahkan_note AS disahkan_note')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__isu_masalah_lokasi_kanta_komuniti.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__isu_masalah_lokasi_kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm10.analisa-isu-lokasi-kanta-komuniti-ppn-1', compact('roles_menu','ref_kaum','ref_jantina','isu_lokasi_kk'));
        }
    }

    function permohonan_kanta_komuniti(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__kanta_komuniti')
                        ->select('krt__kanta_komuniti.id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                'krt__kanta_komuniti.status AS status',
                                'ref__status_kanta_komuniti.status_description AS status_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__kanta_komuniti.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__kanta_komuniti.daerah_id')
                        ->leftJoin('ref__status_kanta_komuniti','ref__status_kanta_komuniti.id','=','krt__kanta_komuniti.status')
                        ->orderBy('krt__kanta_komuniti.id', 'asc')
                        ->whereIn('krt__kanta_komuniti.status', [3,4,5,6,7])
                        ->where('krt__kanta_komuniti.daerah_id', '=', Auth::user()->daerah_id)
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
            return view('rt-sm10.permohonan-kanta-komuniti',compact('roles_menu'));
        }
    }

    function post_permohonan_kanta_komuniti(Request $request){
        
        $action = $request->add_permohonan_kanta_komuniti;
        
        $rules = array(
           
        );

        $messages = [
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm10.permohonan_kanta_komuniti'))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'add') {
                $kanta_komuniti                    = new Krt_Kanta_Komuniti;
                $kanta_komuniti->state_id          = Auth::user()->state_id;
                $kanta_komuniti->daerah_id         = Auth::user()->daerah_id;
                $kanta_komuniti->status            = 3;
                $kanta_komuniti->save();
            }
            return Redirect::to(route('rt-sm10.permohonan_kanta_komuniti_1',$kanta_komuniti->id));
        }

    }

    function permohonan_kanta_komuniti_1(Request $request, $id){
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
            $kanta_komuniti     = DB::table('krt__kanta_komuniti')
                                    ->select('krt__kanta_komuniti.id',
                                            'krt__kanta_komuniti.state_id AS state_id',
                                            'krt__kanta_komuniti.daerah_id AS daerah_id',
                                            'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                            'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_1 AS kanta_jenis_kediaman_1',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_2 AS kanta_jenis_kediaman_2',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_3 AS kanta_jenis_kediaman_3',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_4 AS kanta_jenis_kediaman_4',
                                            'krt__kanta_komuniti.kanta_sejarah_lokasi AS kanta_sejarah_lokasi',
                                            'krt__kanta_komuniti.kanta_kelebihan_lokasi AS kanta_kelebihan_lokasi',
                                            'krt__kanta_komuniti.kanta_kemudahan AS kanta_kemudahan',
                                            'krt__kanta_komuniti.status AS status',
                                            'ref__status_kanta_komuniti.status_description AS status_description',
                                            'krt__kanta_komuniti.disemak_note AS disemak_note',
                                            'krt__kanta_komuniti.disahkan_note AS disahkan_note')
                                    ->leftJoin('ref__status_kanta_komuniti','ref__status_kanta_komuniti.id','=','krt__kanta_komuniti.status')
                                    ->where('krt__kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state                  = RefStates::where('status', '=', true)
                                    ->get();
            $daerah                 = RefDaerah::where('status', '=', true)
                                    ->get();
            $kaum                   = RefKaum::where('status', '=', true)
                                    ->get();
            return view('rt-sm10.permohonan-kanta-komuniti-1', compact('roles_menu','kanta_komuniti','state','daerah','kaum'));
        }
    }

    function get_senarai_kaum_table(Request $request, $id){
        $data = DB::table('krt__kanta_komuniti_kaum')
                    ->select('krt__kanta_komuniti_kaum.*','ref__kaum.kaum_description',
                    DB::raw(" ROUND(CAST((krt__kanta_komuniti_kaum.bilangan * 100 / (Select SUM(krt__kanta_komuniti_kaum.bilangan) 
                            From krt__kanta_komuniti_kaum WHERE krt__kanta_komuniti_kaum.kanta_komuniti_id = '" . $id . "')) AS FLOAT), 2) AS peratus"))
                    ->join('ref__kaum','ref__kaum.id','=','krt__kanta_komuniti_kaum.kaum_id')
                    ->where('krt__kanta_komuniti_kaum.kanta_komuniti_id', '=', $id)
                    ->get();
                return Datatables::of($data)
                        ->make(true);
    }

    function add_kanta_komuniti_kaum(Request $request){
        $action = $request->add_kanta_komuniti_kaum;
        $app_id = $request->pkk1_kanta_komuniti_id;
        
        $rules = array(
            'pkk1_kaum_id'               => 'required',
            'pkk1_bilangan'              => 'required|numeric'
        );

        $messages = [
            'pkk1_kaum_id.required'      => 'Pilih Kaum yang dipohon',
            'pkk1_bilangan.required'     => 'Ruangan Bilangan mesti diisi',
            'pkk1_bilangan.numeric'      => 'Ruangan Bilangan mesti diisi nombor sahaja',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $kanta_komuniti_kaum = new Krt_Kanta_Komuniti_Kaum;
                $kanta_komuniti_kaum->kanta_komuniti_id    = $app_id;
                $kanta_komuniti_kaum->kaum_id              = $request->pkk1_kaum_id;
                $kanta_komuniti_kaum->bilangan             = $request->pkk1_bilangan;
                $kanta_komuniti_kaum->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_kaum($id){
        $data = DB::table('krt__kanta_komuniti_kaum')->where('id', '=', $id)->delete();
    }

    function get_senarai_penduduk_table(Request $request, $id){
        $data = DB::table('krt__kanta_komuniti_penduduk')
                    ->select('krt__kanta_komuniti_penduduk.*','ref__kaum.kaum_description',
                    DB::raw(" ROUND(CAST((krt__kanta_komuniti_penduduk.bilangan_rumah * 100 / (Select SUM(krt__kanta_komuniti_penduduk.bilangan_rumah) 
                            From krt__kanta_komuniti_penduduk WHERE krt__kanta_komuniti_penduduk.kanta_komuniti_id = '" . $id . "')) AS FLOAT), 2) AS peratus"))
                    ->join('ref__kaum','ref__kaum.id','=','krt__kanta_komuniti_penduduk.kaum_id')
                    ->where('krt__kanta_komuniti_penduduk.kanta_komuniti_id', '=', $id)
                    ->get();
                return Datatables::of($data)
                        ->make(true);
    }

    function add_kanta_komuniti_penduduk(Request $request){
        $action = $request->add_kanta_komuniti_penduduk;
        $app_id = $request->pkk2_kanta_komuniti_id;
        
        $rules = array(
            'pkk2_kaum_id'                  => 'required',
            'pkk2_bilangan_rumah'           => 'required|numeric'
        );

        $messages = [
            'pkk2_kaum_id.required'         => 'Pilih Kaum yang dipohon',
            'pkk2_bilangan_rumah.required'  => 'Ruangan Bilangan mesti diisi',
            'pkk2_bilangan_rumah.numeric'   => 'Ruangan Bilangan mesti diisi nombor sahaja',
            
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $kanta_komuniti_penduduk = new Krt_Kanta_Komuniti_Penduduk;
                $kanta_komuniti_penduduk->kanta_komuniti_id    = $app_id;
                $kanta_komuniti_penduduk->kaum_id              = $request->pkk2_kaum_id;
                $kanta_komuniti_penduduk->bilangan_rumah       = $request->pkk2_bilangan_rumah;
                $kanta_komuniti_penduduk->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_penduduk($id){
        $data = DB::table('krt__kanta_komuniti_penduduk')->where('id', '=', $id)->delete();
    }

    function post_permohonan_kanta_komuniti_1(Request $request){
        $action = $request->post_permohonan_kanta_komuniti_1;
        $app_id = $request->pkk3_kanta_komuniti_id;
        
        $rules = array(
            'pkk_kanta_nama'                    => 'required',
            'pkk_kanta_alamat'                  => 'required',
        );

        $messages = [
            'pkk_kanta_nama.required'           => 'Ruangan nama projek ekonomi diisi',
            'pkk_kanta_alamat.required'         => 'Ruangan penerangan ringkas mengenai projek mesti diisi',
            
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $kanta_komuniti                               = Krt_Kanta_Komuniti::where($where)->first();
                $kanta_komuniti->kanta_nama                   = $request->pkk_kanta_nama;
                $kanta_komuniti->kanta_alamat                 = $request->pkk_kanta_alamat;
                $kanta_komuniti->kanta_jenis_kediaman_1       = $request->pkk_kanta_jenis_kediaman_1;
                $kanta_komuniti->kanta_jenis_kediaman_2       = $request->pkk_kanta_jenis_kediaman_2;
                $kanta_komuniti->kanta_jenis_kediaman_3       = $request->pkk_kanta_jenis_kediaman_3;
                $kanta_komuniti->kanta_jenis_kediaman_4       = $request->pkk_kanta_jenis_kediaman_4;
                $kanta_komuniti->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function permohonan_kanta_komuniti_2(Request $request, $id){
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
            $kanta_komuniti     = DB::table('krt__kanta_komuniti')
                                    ->select('krt__kanta_komuniti.id',
                                            'krt__kanta_komuniti.state_id AS state_id',
                                            'krt__kanta_komuniti.daerah_id AS daerah_id',
                                            'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                            'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_1 AS kanta_jenis_kediaman_1',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_2 AS kanta_jenis_kediaman_2',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_3 AS kanta_jenis_kediaman_3',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_4 AS kanta_jenis_kediaman_4',
                                            'krt__kanta_komuniti.kanta_sejarah_lokasi AS kanta_sejarah_lokasi',
                                            'krt__kanta_komuniti.kanta_kelebihan_lokasi AS kanta_kelebihan_lokasi',
                                            'krt__kanta_komuniti.kanta_kemudahan AS kanta_kemudahan',
                                            'krt__kanta_komuniti.status AS status',
                                            'ref__status_kanta_komuniti.status_description AS status_description',
                                            'krt__kanta_komuniti.disemak_note AS disemak_note',
                                            'krt__kanta_komuniti.disahkan_note AS disahkan_note')
                                    ->leftJoin('ref__status_kanta_komuniti','ref__status_kanta_komuniti.id','=','krt__kanta_komuniti.status')
                                    ->where('krt__kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state                  = RefStates::where('status', '=', true)
                                    ->get();
            $daerah                 = RefDaerah::where('status', '=', true)
                                    ->get();
            $kaum                   = RefKaum::where('status', '=', true)
                                    ->get();
            return view('rt-sm10.permohonan-kanta-komuniti-2', compact('roles_menu','kanta_komuniti','state','daerah','kaum'));
        }
    }

    function get_senarai_risiko_kanta_table(Request $request, $id){
        $data = DB::table('krt__kanta_komuniti_risiko')
                    ->select('krt__kanta_komuniti_risiko.*')
                    ->where('krt__kanta_komuniti_risiko.kanta_komuniti_id', '=', $id)
                    ->get();
                return Datatables::of($data)
                        ->make(true);
    }

    function add_kanta_komuniti_risiko(Request $request){
        $action = $request->add_kanta_komuniti_risiko;
        $app_id = $request->pkk4_kanta_komuniti_id;
        
        $rules = array(
            'pkk4_risiko_nama_agensi'           => 'required',
            'pkk4_risiko_jenis'                 => 'required',
            'pkk4_risiko_isu'                   => 'required'
        );

        $messages = [
            'pkk4_risiko_nama_agensi.required'  => 'Ruangan Nama Agensi mesti diisi',
            'pkk4_risiko_jenis.required'        => 'Ruangan Jenis Risiko mesti diisi',
            'pkk4_risiko_isu.required'          => 'Ruangan Isu / Kes mesti diisi',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $kanta_komuniti_risiko = new Krt_Kanta_Komuniti_Risiko;
                $kanta_komuniti_risiko->kanta_komuniti_id    = $app_id;
                $kanta_komuniti_risiko->risiko_nama_agensi   = $request->pkk4_risiko_nama_agensi;
                $kanta_komuniti_risiko->risiko_jenis         = $request->pkk4_risiko_jenis;
                $kanta_komuniti_risiko->risiko_isu           = $request->pkk4_risiko_isu;
                $kanta_komuniti_risiko->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_risiko_kanta($id){
        $data = DB::table('krt__kanta_komuniti_risiko')->where('id', '=', $id)->delete();
    }

    function post_permohonan_kanta_komuniti_2(Request $request){
        $action = $request->post_permohonan_kanta_komuniti_2;
        $app_id = $request->pkk6_kanta_komuniti_id;
        
        $rules = array(
            'pkk5_kanta_sejarah_lokasi'                 => 'required',
            'pkk5_kanta_kelebihan_lokasi'               => 'required',
            'pkk5_kanta_kemudahan'                      => 'required',
        );

        $messages = [
            'pkk5_kanta_sejarah_lokasi.required'        => 'Ruangan Sejarah dan Latar Belakang Lokasi mesti diisi',
            'pkk5_kanta_kelebihan_lokasi.required'      => 'Ruangan Kelebihan Lokasi mesti diisi',
            'pkk5_kanta_kemudahan.required'             => 'Ruangan Kemudahan Asas / Fizikal  mesti diisi',
            
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $kanta_komuniti                               = Krt_Kanta_Komuniti::where($where)->first();
                $kanta_komuniti->kanta_sejarah_lokasi          = $request->pkk5_kanta_sejarah_lokasi;
                $kanta_komuniti->kanta_kelebihan_lokasi       = $request->pkk5_kanta_kelebihan_lokasi;
                $kanta_komuniti->kanta_kemudahan              = $request->pkk5_kanta_kemudahan;
                $kanta_komuniti->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function permohonan_kanta_komuniti_3(Request $request, $id){
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
            $kanta_komuniti     = DB::table('krt__kanta_komuniti')
                                    ->select('krt__kanta_komuniti.id',
                                            'krt__kanta_komuniti.state_id AS state_id',
                                            'krt__kanta_komuniti.daerah_id AS daerah_id',
                                            'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                            'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_1 AS kanta_jenis_kediaman_1',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_2 AS kanta_jenis_kediaman_2',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_3 AS kanta_jenis_kediaman_3',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_4 AS kanta_jenis_kediaman_4',
                                            'krt__kanta_komuniti.kanta_sejarah_lokasi AS kanta_sejarah_lokasi',
                                            'krt__kanta_komuniti.kanta_kelebihan_lokasi AS kanta_kelebihan_lokasi',
                                            'krt__kanta_komuniti.kanta_kemudahan AS kanta_kemudahan',
                                            'krt__kanta_komuniti.status AS status',
                                            'ref__status_kanta_komuniti.status_description AS status_description',
                                            'krt__kanta_komuniti.disemak_note AS disemak_note',
                                            'krt__kanta_komuniti.disahkan_note AS disahkan_note')
                                    ->leftJoin('ref__status_kanta_komuniti','ref__status_kanta_komuniti.id','=','krt__kanta_komuniti.status')
                                    ->where('krt__kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state                  = RefStates::where('status', '=', true)
                                    ->get();
            $daerah                 = RefDaerah::where('status', '=', true)
                                    ->get();
            $kaum                   = RefKaum::where('status', '=', true)
                                    ->get();
            $krt_profile            = KRT_Profile::where('krt_status', '=', true)
                                    ->where('krt__profile.daerah_id','=',Auth::user()->daerah_id)
                                    ->get();
            return view('rt-sm10.permohonan-kanta-komuniti-3', compact('roles_menu','kanta_komuniti','state','daerah','kaum','krt_profile'));
        }
    }

    function get_senarai_masalah_kanta_table(Request $request, $id){
        $data = DB::table('krt__kanta_komuniti_masalah')
                    ->select('krt__kanta_komuniti_masalah.*')
                    ->where('krt__kanta_komuniti_masalah.kanta_komuniti_id', '=', $id)
                    ->get();
                return Datatables::of($data)
                        ->make(true);
    }

    function add_kanta_komuniti_masalah(Request $request){
        $action = $request->add_kanta_komuniti_masalah;
        $app_id = $request->pkk7_kanta_komuniti_id;
        
        $rules = array(
            'pkk7_masalah_tajuk'               => 'required',
            'pkk7_masalah_perincian'           => 'required',
            'pkk7_masalah_penjelasan'          => 'required'
        );

        $messages = [
            'pkk7_masalah_tajuk.required'       => 'Ruangan Nama Agensi mesti diisi',
            'pkk7_masalah_perincian.required'   => 'Ruangan Jenis Risiko mesti diisi',
            'pkk7_masalah_penjelasan.required'  => 'Ruangan Isu / Kes mesti diisi',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $kanta_komuniti_masalah = new Krt_Kanta_Komuniti_Masalah;
                $kanta_komuniti_masalah->kanta_komuniti_id    = $app_id;
                $kanta_komuniti_masalah->masalah_tajuk        = $request->pkk7_masalah_tajuk;
                $kanta_komuniti_masalah->masalah_perincian    = $request->pkk7_masalah_perincian;
                $kanta_komuniti_masalah->masalah_penjelasan   = $request->pkk7_masalah_penjelasan;
                $kanta_komuniti_masalah->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_masalah_kanta($id){
        $data = DB::table('krt__kanta_komuniti_masalah')->where('id', '=', $id)->delete();
    }

    function get_senarai_krt_kanta_table(Request $request, $id){
        $data = DB::table('krt__kanta_komuniti_kewujudan_krt')
                    ->select('krt__kanta_komuniti_kewujudan_krt.*','krt__profile.krt_nama AS nama_krt')
                    ->join('krt__profile','krt__profile.id','=','krt__kanta_komuniti_kewujudan_krt.krt_profile_id')
                    ->where('krt__kanta_komuniti_kewujudan_krt.kanta_komuniti_id', '=', $id)
                    ->get();
                return Datatables::of($data)
                        ->make(true);
    }

    function add_kanta_komuniti_krt(Request $request){
        $action = $request->add_kanta_komuniti_krt;
        $app_id = $request->pkk8_kanta_komuniti_id;
        
        $rules = array(
            'pkk8_krt_profile_id'           => 'required',
            'pkk8_krt_masalah'              => 'required'
        );

        $messages = [
            'pkk8_krt_profile_id.required'  => 'Ruangan Nama KRT mesti dipilih',
            'pkk8_krt_masalah.required'     => 'Ruangan Isu / Masalah mesti diisi'
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $kanta_komuniti_krt = new Krt_Kanta_Komuniti_Kewuudan_Krt;
                $kanta_komuniti_krt->kanta_komuniti_id    = $app_id;
                $kanta_komuniti_krt->krt_profile_id       = $request->pkk8_krt_profile_id;
                $kanta_komuniti_krt->krt_masalah          = $request->pkk8_krt_masalah;
                $kanta_komuniti_krt->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_krt_kanta($id){
        $data = DB::table('krt__kanta_komuniti_kewujudan_krt')->where('id', '=', $id)->delete();
    }

    function permohonan_kanta_komuniti_4(Request $request, $id){
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
            $kanta_komuniti     = DB::table('krt__kanta_komuniti')
                                    ->select('krt__kanta_komuniti.id',
                                            'krt__kanta_komuniti.state_id AS state_id',
                                            'krt__kanta_komuniti.daerah_id AS daerah_id',
                                            'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                            'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_1 AS kanta_jenis_kediaman_1',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_2 AS kanta_jenis_kediaman_2',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_3 AS kanta_jenis_kediaman_3',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_4 AS kanta_jenis_kediaman_4',
                                            'krt__kanta_komuniti.kanta_sejarah_lokasi AS kanta_sejarah_lokasi',
                                            'krt__kanta_komuniti.kanta_kelebihan_lokasi AS kanta_kelebihan_lokasi',
                                            'krt__kanta_komuniti.kanta_kemudahan AS kanta_kemudahan',
                                            'krt__kanta_komuniti.status AS status',
                                            'ref__status_kanta_komuniti.status_description AS status_description',
                                            'krt__kanta_komuniti.disemak_note AS disemak_note',
                                            'krt__kanta_komuniti.disahkan_note AS disahkan_note')
                                    ->leftJoin('ref__status_kanta_komuniti','ref__status_kanta_komuniti.id','=','krt__kanta_komuniti.status')
                                    ->where('krt__kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state                  = RefStates::where('status', '=', true)
                                    ->get();
            $daerah                 = RefDaerah::where('status', '=', true)
                                    ->get();
            $kaum                   = RefKaum::where('status', '=', true)
                                    ->get();
            $krt_profile            = KRT_Profile::where('krt_status', '=', true)
                                    ->where('krt__profile.daerah_id','=',Auth::user()->daerah_id)
                                    ->get();
            $masalah                = Krt_Kanta_Komuniti_Masalah::where('kanta_komuniti_id', '=', $id)
                                    ->get();
            return view('rt-sm10.permohonan-kanta-komuniti-4', compact('roles_menu','kanta_komuniti','state','daerah','kaum','krt_profile','masalah'));
        }
    }

    function get_senarai_langkah_masalah_kanta_table(Request $request, $id){
        $data = DB::table('krt__kanta_komuniti_langkah_masalah')
                    ->select('krt__kanta_komuniti_langkah_masalah.*','krt__kanta_komuniti_masalah.masalah_tajuk')
                    ->join('krt__kanta_komuniti_masalah','krt__kanta_komuniti_masalah.id','=','krt__kanta_komuniti_langkah_masalah.masalah_id')
                    ->where('krt__kanta_komuniti_langkah_masalah.kanta_komuniti_id', '=', $id)
                    ->get();
                return Datatables::of($data)
                        ->make(true);
    }

    function add_kanta_komuniti_langkah_masalah(Request $request){
        $action = $request->add_kanta_komuniti_langkah_masalah;
        $app_id = $request->pkk10_kanta_komuniti_id;
        
        $rules = array(
            'pkk10_masalah_id'                      => 'required',
            'pkk10_langkah_diambil'                 => 'required',
            'pkk10_langkah_pelaksanaan'             => 'required',
            'pkk10_langkah_status'                  => 'required'
        );

        $messages = [
            'pkk10_masalah_id.required'             => 'Ruangan Isu / Masalah mesti dipilih',
            'pkk10_langkah_diambil.required'        => 'Ruangan Langkah / Tindakan Diambil mesti diisi',
            'pkk10_langkah_pelaksanaan.required'    => 'Ruangan Pelaksanaan mesti diisi',
            'pkk10_langkah_status.required'         => 'Ruangan Status Pelaksanaan mesti diisi'
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $kanta_komuniti_langkah_masalah = new Krt_Kanta_Komuniti_Langkah_Masalah;
                $kanta_komuniti_langkah_masalah->kanta_komuniti_id    = $app_id;
                $kanta_komuniti_langkah_masalah->masalah_id           = $request->pkk10_masalah_id;
                $kanta_komuniti_langkah_masalah->langkah_diambil      = $request->pkk10_langkah_diambil;
                $kanta_komuniti_langkah_masalah->langkah_pelaksanaan  = $request->pkk10_langkah_pelaksanaan;
                $kanta_komuniti_langkah_masalah->langkah_status       = $request->pkk10_langkah_status;
                $kanta_komuniti_langkah_masalah->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_langkah_masalah_kanta($id){
        $data = DB::table('krt__kanta_komuniti_langkah_masalah')->where('id', '=', $id)->delete();
    }

    function get_senarai_pemimpin_kanta_table(Request $request, $id){
        $data = DB::table('krt__kanta_komuniti_pemimpin')
                    ->select('krt__kanta_komuniti_pemimpin.*')
                    ->where('krt__kanta_komuniti_pemimpin.kanta_komuniti_id', '=', $id)
                    ->get();
                return Datatables::of($data)
                        ->make(true);
    }

    function add_kanta_komuniti_pemimpin(Request $request){
        $action = $request->add_kanta_komuniti_pemimpin;
        $app_id = $request->pkk11_kanta_komuniti_id;
        
        $rules = array(
            'pkk11_pemimpin_nama'                 => 'required',
            'pkk11_pemimpin_catatan'              => 'required'
        );

        $messages = [
            'pkk11_pemimpin_nama.required'        => 'Ruangan Nama Individu / Organisas mesti diisi',
            'pkk11_pemimpin_catatan.required'     => 'Ruangan Catatan mesti diisi'
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $kanta_komuniti_pemimpin = new Krt_Kanta_Komuniti_Pemimpin;
                $kanta_komuniti_pemimpin->kanta_komuniti_id    = $app_id;
                $kanta_komuniti_pemimpin->pemimpin_nama        = $request->pkk11_pemimpin_nama;
                $kanta_komuniti_pemimpin->pemimpin_catatan     = $request->pkk11_pemimpin_catatan;
                $kanta_komuniti_pemimpin->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_pemimpin_kanta($id){
        $data = DB::table('krt__kanta_komuniti_pemimpin')->where('id', '=', $id)->delete();
    }

    function post_permohonan_kanta_komuniti_3(Request $request){
        $action = $request->post_permohonan_kanta_komuniti_3;
        $app_id = $request->pkk12_kanta_komuniti_id;
        
        $rules = array(
            
        );

        $messages = [
            
            
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $kanta_komuniti                         = Krt_Kanta_Komuniti::where($where)->first();
                $kanta_komuniti->status                 = 4;
                $kanta_komuniti->dihantar_by            = Auth::user()->user_id;
                $kanta_komuniti->dihantar_date          = date('Y-m-d H:i:s');
                $kanta_komuniti->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function semakan_kanta_komuniti(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__kanta_komuniti')
                        ->select('krt__kanta_komuniti.id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                'krt__kanta_komuniti.status AS status',
                                'ref__status_kanta_komuniti.status_description AS status_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__kanta_komuniti.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__kanta_komuniti.daerah_id')
                        ->leftJoin('ref__status_kanta_komuniti','ref__status_kanta_komuniti.id','=','krt__kanta_komuniti.status')
                        ->orderBy('krt__kanta_komuniti.id', 'asc')
                        ->whereIn('krt__kanta_komuniti.status', [4])
                        ->where('krt__kanta_komuniti.state_id', '=', Auth::user()->state_id)
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
            return view('rt-sm10.semakan-kanta-komuniti', compact('roles_menu','daerah'));
        }
    }

    function semakan_kanta_komuniti_1(Request $request, $id){
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
            $kanta_komuniti     = DB::table('krt__kanta_komuniti')
                                    ->select('krt__kanta_komuniti.id',
                                            'krt__kanta_komuniti.state_id AS state_id',
                                            'krt__kanta_komuniti.daerah_id AS daerah_id',
                                            'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                            'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_1 AS kanta_jenis_kediaman_1',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_2 AS kanta_jenis_kediaman_2',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_3 AS kanta_jenis_kediaman_3',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_4 AS kanta_jenis_kediaman_4',
                                            'krt__kanta_komuniti.kanta_sejarah_lokasi AS kanta_sejarah_lokasi',
                                            'krt__kanta_komuniti.kanta_kelebihan_lokasi AS kanta_kelebihan_lokasi',
                                            'krt__kanta_komuniti.kanta_kemudahan AS kanta_kemudahan')
                                    ->where('krt__kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state                  = RefStates::where('status', '=', true)
                                    ->get();
            $daerah                 = RefDaerah::where('status', '=', true)
                                    ->get();
            $kaum                   = RefKaum::where('status', '=', true)
                                    ->get();
            return view('rt-sm10.semakan-kanta-komuniti-1', compact('roles_menu','kanta_komuniti','state','daerah','kaum'));
        }
    }

    function semakan_kanta_komuniti_2(Request $request, $id){
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
            $kanta_komuniti     = DB::table('krt__kanta_komuniti')
                                    ->select('krt__kanta_komuniti.id',
                                            'krt__kanta_komuniti.state_id AS state_id',
                                            'krt__kanta_komuniti.daerah_id AS daerah_id',
                                            'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                            'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_1 AS kanta_jenis_kediaman_1',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_2 AS kanta_jenis_kediaman_2',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_3 AS kanta_jenis_kediaman_3',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_4 AS kanta_jenis_kediaman_4',
                                            'krt__kanta_komuniti.kanta_sejarah_lokasi AS kanta_sejarah_lokasi',
                                            'krt__kanta_komuniti.kanta_kelebihan_lokasi AS kanta_kelebihan_lokasi',
                                            'krt__kanta_komuniti.kanta_kemudahan AS kanta_kemudahan')
                                    ->where('krt__kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state                  = RefStates::where('status', '=', true)
                                    ->get();
            $daerah                 = RefDaerah::where('status', '=', true)
                                    ->get();
            $kaum                   = RefKaum::where('status', '=', true)
                                    ->get();
            return view('rt-sm10.semakan-kanta-komuniti-2', compact('roles_menu','kanta_komuniti','state','daerah','kaum'));
        }
    }

    function semakan_kanta_komuniti_3(Request $request, $id){
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
            $kanta_komuniti     = DB::table('krt__kanta_komuniti')
                                    ->select('krt__kanta_komuniti.id',
                                            'krt__kanta_komuniti.state_id AS state_id',
                                            'krt__kanta_komuniti.daerah_id AS daerah_id',
                                            'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                            'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_1 AS kanta_jenis_kediaman_1',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_2 AS kanta_jenis_kediaman_2',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_3 AS kanta_jenis_kediaman_3',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_4 AS kanta_jenis_kediaman_4',
                                            'krt__kanta_komuniti.kanta_sejarah_lokasi AS kanta_sejarah_lokasi',
                                            'krt__kanta_komuniti.kanta_kelebihan_lokasi AS kanta_kelebihan_lokasi',
                                            'krt__kanta_komuniti.kanta_kemudahan AS kanta_kemudahan')
                                    ->where('krt__kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state                  = RefStates::where('status', '=', true)
                                    ->get();
            $daerah                 = RefDaerah::where('status', '=', true)
                                    ->get();
            $kaum                   = RefKaum::where('status', '=', true)
                                    ->get();
            $krt_profile            = KRT_Profile::where('krt_status', '=', true)
                                    ->where('krt__profile.daerah_id','=',Auth::user()->daerah_id)
                                    ->get();
            return view('rt-sm10.semakan-kanta-komuniti-3', compact('roles_menu','kanta_komuniti','state','daerah','kaum','krt_profile'));
        }
    }

    function semakan_kanta_komuniti_4(Request $request, $id){
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
            $kanta_komuniti     = DB::table('krt__kanta_komuniti')
                                    ->select('krt__kanta_komuniti.id',
                                            'krt__kanta_komuniti.state_id AS state_id',
                                            'krt__kanta_komuniti.daerah_id AS daerah_id',
                                            'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                            'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_1 AS kanta_jenis_kediaman_1',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_2 AS kanta_jenis_kediaman_2',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_3 AS kanta_jenis_kediaman_3',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_4 AS kanta_jenis_kediaman_4',
                                            'krt__kanta_komuniti.kanta_sejarah_lokasi AS kanta_sejarah_lokasi',
                                            'krt__kanta_komuniti.kanta_kelebihan_lokasi AS kanta_kelebihan_lokasi',
                                            'krt__kanta_komuniti.kanta_kemudahan AS kanta_kemudahan')
                                    ->where('krt__kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state                  = RefStates::where('status', '=', true)
                                    ->get();
            $daerah                 = RefDaerah::where('status', '=', true)
                                    ->get();
            $kaum                   = RefKaum::where('status', '=', true)
                                    ->get();
            $krt_profile            = KRT_Profile::where('krt_status', '=', true)
                                    ->where('krt__profile.daerah_id','=',Auth::user()->daerah_id)
                                    ->get();
            $masalah                = Krt_Kanta_Komuniti_Masalah::where('kanta_komuniti_id', '=', $id)
                                    ->get();
            return view('rt-sm10.semakan-kanta-komuniti-4', compact('roles_menu','kanta_komuniti','state','daerah','kaum','krt_profile','masalah'));
        }
    }

    function post_semakan_kanta_komuniti(Request $request){
        $action = $request->post_semakan_kanta_komuniti;
        $app_id = $request->skk_kanta_komuniti_id;
        
        
        $rules = array(
            'skk_status'                  => 'required',
            'skk_disemak_note'            => 'required',
        );

        $messages = [
            'spek_status.required'         => 'Ruangan Status mesti dipilih',
            'spek_disemak_note.required'   => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $semakan_kanta_komuniti                    = Krt_Kanta_Komuniti::where($where)->first();
                $semakan_kanta_komuniti->status            = $request->skk_status;
                $semakan_kanta_komuniti->disemak_note      = $request->skk_disemak_note;
                $semakan_kanta_komuniti->disemak_by        = Auth::user()->user_id;
                $semakan_kanta_komuniti->disemak_date      = date('Y-m-d H:i:s');
                $semakan_kanta_komuniti->save();
            }
        }
    }

    function pengesahan_kanta_komuniti(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('krt__kanta_komuniti')
                        ->select('krt__kanta_komuniti.id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                'krt__kanta_komuniti.status AS status',
                                'ref__status_kanta_komuniti.status_description AS status_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__kanta_komuniti.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__kanta_komuniti.daerah_id')
                        ->leftJoin('ref__status_kanta_komuniti','ref__status_kanta_komuniti.id','=','krt__kanta_komuniti.status')
                        ->orderBy('krt__kanta_komuniti.id', 'asc')
                        ->whereIn('krt__kanta_komuniti.status', [6])
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
            $state     = RefStates::where('status', '=', true)
                        ->get();
            $daerah     = RefDaerah::where('status', '=', true)
                        ->get();
            return view('rt-sm10.pengesahan-kanta-komuniti', compact('roles_menu','state','daerah'));
        }
    }

    function pengesahan_kanta_komuniti_1(Request $request, $id){
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
            $kanta_komuniti     = DB::table('krt__kanta_komuniti')
                                    ->select('krt__kanta_komuniti.id',
                                            'krt__kanta_komuniti.state_id AS state_id',
                                            'krt__kanta_komuniti.daerah_id AS daerah_id',
                                            'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                            'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_1 AS kanta_jenis_kediaman_1',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_2 AS kanta_jenis_kediaman_2',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_3 AS kanta_jenis_kediaman_3',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_4 AS kanta_jenis_kediaman_4',
                                            'krt__kanta_komuniti.kanta_sejarah_lokasi AS kanta_sejarah_lokasi',
                                            'krt__kanta_komuniti.kanta_kelebihan_lokasi AS kanta_kelebihan_lokasi',
                                            'krt__kanta_komuniti.kanta_kemudahan AS kanta_kemudahan')
                                    ->where('krt__kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state                  = RefStates::where('status', '=', true)
                                    ->get();
            $daerah                 = RefDaerah::where('status', '=', true)
                                    ->get();
            $kaum                   = RefKaum::where('status', '=', true)
                                    ->get();
            return view('rt-sm10.pengesahan-kanta-komuniti-1', compact('roles_menu','kanta_komuniti','state','daerah','kaum'));
        }
    }

    function pengesahan_kanta_komuniti_2(Request $request, $id){
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
            $kanta_komuniti     = DB::table('krt__kanta_komuniti')
                                    ->select('krt__kanta_komuniti.id',
                                            'krt__kanta_komuniti.state_id AS state_id',
                                            'krt__kanta_komuniti.daerah_id AS daerah_id',
                                            'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                            'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_1 AS kanta_jenis_kediaman_1',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_2 AS kanta_jenis_kediaman_2',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_3 AS kanta_jenis_kediaman_3',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_4 AS kanta_jenis_kediaman_4',
                                            'krt__kanta_komuniti.kanta_sejarah_lokasi AS kanta_sejarah_lokasi',
                                            'krt__kanta_komuniti.kanta_kelebihan_lokasi AS kanta_kelebihan_lokasi',
                                            'krt__kanta_komuniti.kanta_kemudahan AS kanta_kemudahan')
                                    ->where('krt__kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state                  = RefStates::where('status', '=', true)
                                    ->get();
            $daerah                 = RefDaerah::where('status', '=', true)
                                    ->get();
            $kaum                   = RefKaum::where('status', '=', true)
                                    ->get();
            return view('rt-sm10.pengesahan-kanta-komuniti-2', compact('roles_menu','kanta_komuniti','state','daerah','kaum'));
        }
    }

    function pengesahan_kanta_komuniti_3(Request $request, $id){
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
            $kanta_komuniti     = DB::table('krt__kanta_komuniti')
                                    ->select('krt__kanta_komuniti.id',
                                            'krt__kanta_komuniti.state_id AS state_id',
                                            'krt__kanta_komuniti.daerah_id AS daerah_id',
                                            'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                            'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_1 AS kanta_jenis_kediaman_1',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_2 AS kanta_jenis_kediaman_2',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_3 AS kanta_jenis_kediaman_3',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_4 AS kanta_jenis_kediaman_4',
                                            'krt__kanta_komuniti.kanta_sejarah_lokasi AS kanta_sejarah_lokasi',
                                            'krt__kanta_komuniti.kanta_kelebihan_lokasi AS kanta_kelebihan_lokasi',
                                            'krt__kanta_komuniti.kanta_kemudahan AS kanta_kemudahan')
                                    ->where('krt__kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state                  = RefStates::where('status', '=', true)
                                    ->get();
            $daerah                 = RefDaerah::where('status', '=', true)
                                    ->get();
            $kaum                   = RefKaum::where('status', '=', true)
                                    ->get();
            $krt_profile            = KRT_Profile::where('krt_status', '=', true)
                                    ->where('krt__profile.daerah_id','=',Auth::user()->daerah_id)
                                    ->get();
            return view('rt-sm10.pengesahan-kanta-komuniti-3', compact('roles_menu','kanta_komuniti','state','daerah','kaum','krt_profile'));
        }
    }

    function pengesahan_kanta_komuniti_4(Request $request, $id){
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
            $kanta_komuniti     = DB::table('krt__kanta_komuniti')
                                    ->select('krt__kanta_komuniti.id',
                                            'krt__kanta_komuniti.state_id AS state_id',
                                            'krt__kanta_komuniti.daerah_id AS daerah_id',
                                            'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                            'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_1 AS kanta_jenis_kediaman_1',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_2 AS kanta_jenis_kediaman_2',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_3 AS kanta_jenis_kediaman_3',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_4 AS kanta_jenis_kediaman_4',
                                            'krt__kanta_komuniti.kanta_sejarah_lokasi AS kanta_sejarah_lokasi',
                                            'krt__kanta_komuniti.kanta_kelebihan_lokasi AS kanta_kelebihan_lokasi',
                                            'krt__kanta_komuniti.kanta_kemudahan AS kanta_kemudahan')
                                    ->where('krt__kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state                  = RefStates::where('status', '=', true)
                                    ->get();
            $daerah                 = RefDaerah::where('status', '=', true)
                                    ->get();
            $kaum                   = RefKaum::where('status', '=', true)
                                    ->get();
            $krt_profile            = KRT_Profile::where('krt_status', '=', true)
                                    ->where('krt__profile.daerah_id','=',Auth::user()->daerah_id)
                                    ->get();
            $masalah                = Krt_Kanta_Komuniti_Masalah::where('kanta_komuniti_id', '=', $id)
                                    ->get();
            return view('rt-sm10.pengesahan-kanta-komuniti-4', compact('roles_menu','kanta_komuniti','state','daerah','kaum','krt_profile','masalah'));
        }
    }

    function post_pengesahan_kanta_komuniti(Request $request){
        $action = $request->post_pengesahan_kanta_komuniti;
        $app_id = $request->pkk_kanta_komuniti_id;
        
        
        $rules = array(
            'pkk_status'                  => 'required',
            'pkk_disahkan_note'           => 'required',
        );

        $messages = [
            'pkk_status.required'         => 'Ruangan Status mesti dipilih',
            'pkk_disahkan_note.required'  => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $pengesahan_kanta_komuniti                    = Krt_Kanta_Komuniti::where($where)->first();
                $pengesahan_kanta_komuniti->status            = $request->pkk_status;
                $pengesahan_kanta_komuniti->disahkan_note     = $request->pkk_disahkan_note;
                $pengesahan_kanta_komuniti->disahkan_by       = Auth::user()->user_id;
                $pengesahan_kanta_komuniti->disahkan_date     = date('Y-m-d H:i:s');
                $pengesahan_kanta_komuniti->save();
            }
        }
    }

    function senarai_kanta_komuniti_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__kanta_komuniti')
                        ->select('krt__kanta_komuniti.id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                'krt__kanta_komuniti.status AS status',
                                'ref__status_kanta_komuniti.status_description AS status_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__kanta_komuniti.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__kanta_komuniti.daerah_id')
                        ->leftJoin('ref__status_kanta_komuniti','ref__status_kanta_komuniti.id','=','krt__kanta_komuniti.status')
                        ->orderBy('krt__kanta_komuniti.id', 'asc')
                        ->whereIn('krt__kanta_komuniti.status', [1])
                        ->where('krt__kanta_komuniti.daerah_id', '=', Auth::user()->daerah_id)
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
            return view('rt-sm10.senarai-kanta-komuniti-ppd',compact('roles_menu'));
        }
    }

    function senarai_kanta_komuniti_ppd_1(Request $request, $id){
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
            $kanta_komuniti     = DB::table('krt__kanta_komuniti')
                                    ->select('krt__kanta_komuniti.id',
                                            'krt__kanta_komuniti.state_id AS state_id',
                                            'krt__kanta_komuniti.daerah_id AS daerah_id',
                                            'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                            'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_1 AS kanta_jenis_kediaman_1',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_2 AS kanta_jenis_kediaman_2',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_3 AS kanta_jenis_kediaman_3',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_4 AS kanta_jenis_kediaman_4',
                                            'krt__kanta_komuniti.kanta_sejarah_lokasi AS kanta_sejarah_lokasi',
                                            'krt__kanta_komuniti.kanta_kelebihan_lokasi AS kanta_kelebihan_lokasi',
                                            'krt__kanta_komuniti.kanta_kemudahan AS kanta_kemudahan')
                                    ->where('krt__kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state                  = RefStates::where('status', '=', true)
                                    ->get();
            $daerah                 = RefDaerah::where('status', '=', true)
                                    ->get();
            $kaum                   = RefKaum::where('status', '=', true)
                                    ->get();
            return view('rt-sm10.senarai-kanta-komuniti-ppd-1', compact('roles_menu','kanta_komuniti','state','daerah','kaum'));
        }
    }

    function senarai_kanta_komuniti_ppd_2(Request $request, $id){
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
            $kanta_komuniti     = DB::table('krt__kanta_komuniti')
                                    ->select('krt__kanta_komuniti.id',
                                            'krt__kanta_komuniti.state_id AS state_id',
                                            'krt__kanta_komuniti.daerah_id AS daerah_id',
                                            'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                            'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_1 AS kanta_jenis_kediaman_1',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_2 AS kanta_jenis_kediaman_2',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_3 AS kanta_jenis_kediaman_3',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_4 AS kanta_jenis_kediaman_4',
                                            'krt__kanta_komuniti.kanta_sejarah_lokasi AS kanta_sejarah_lokasi',
                                            'krt__kanta_komuniti.kanta_kelebihan_lokasi AS kanta_kelebihan_lokasi',
                                            'krt__kanta_komuniti.kanta_kemudahan AS kanta_kemudahan')
                                    ->where('krt__kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state                  = RefStates::where('status', '=', true)
                                    ->get();
            $daerah                 = RefDaerah::where('status', '=', true)
                                    ->get();
            $kaum                   = RefKaum::where('status', '=', true)
                                    ->get();
            return view('rt-sm10.senarai-kanta-komuniti-ppd-2', compact('roles_menu','kanta_komuniti','state','daerah','kaum'));
        }
    }

    function senarai_kanta_komuniti_ppd_3(Request $request, $id){
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
            $kanta_komuniti     = DB::table('krt__kanta_komuniti')
                                    ->select('krt__kanta_komuniti.id',
                                            'krt__kanta_komuniti.state_id AS state_id',
                                            'krt__kanta_komuniti.daerah_id AS daerah_id',
                                            'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                            'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_1 AS kanta_jenis_kediaman_1',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_2 AS kanta_jenis_kediaman_2',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_3 AS kanta_jenis_kediaman_3',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_4 AS kanta_jenis_kediaman_4',
                                            'krt__kanta_komuniti.kanta_sejarah_lokasi AS kanta_sejarah_lokasi',
                                            'krt__kanta_komuniti.kanta_kelebihan_lokasi AS kanta_kelebihan_lokasi',
                                            'krt__kanta_komuniti.kanta_kemudahan AS kanta_kemudahan')
                                    ->where('krt__kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state                  = RefStates::where('status', '=', true)
                                    ->get();
            $daerah                 = RefDaerah::where('status', '=', true)
                                    ->get();
            $kaum                   = RefKaum::where('status', '=', true)
                                    ->get();
            $krt_profile            = KRT_Profile::where('krt_status', '=', true)
                                    ->where('krt__profile.daerah_id','=',Auth::user()->daerah_id)
                                    ->get();
            return view('rt-sm10.senarai-kanta-komuniti-ppd-3', compact('roles_menu','kanta_komuniti','state','daerah','kaum','krt_profile'));
        }
    }

    function senarai_kanta_komuniti_ppd_4(Request $request, $id){
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
            $kanta_komuniti     = DB::table('krt__kanta_komuniti')
                                    ->select('krt__kanta_komuniti.id',
                                            'krt__kanta_komuniti.state_id AS state_id',
                                            'krt__kanta_komuniti.daerah_id AS daerah_id',
                                            'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                            'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_1 AS kanta_jenis_kediaman_1',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_2 AS kanta_jenis_kediaman_2',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_3 AS kanta_jenis_kediaman_3',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_4 AS kanta_jenis_kediaman_4',
                                            'krt__kanta_komuniti.kanta_sejarah_lokasi AS kanta_sejarah_lokasi',
                                            'krt__kanta_komuniti.kanta_kelebihan_lokasi AS kanta_kelebihan_lokasi',
                                            'krt__kanta_komuniti.kanta_kemudahan AS kanta_kemudahan')
                                    ->where('krt__kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state                  = RefStates::where('status', '=', true)
                                    ->get();
            $daerah                 = RefDaerah::where('status', '=', true)
                                    ->get();
            $kaum                   = RefKaum::where('status', '=', true)
                                    ->get();
            $krt_profile            = KRT_Profile::where('krt_status', '=', true)
                                    ->where('krt__profile.daerah_id','=',Auth::user()->daerah_id)
                                    ->get();
            $masalah                = Krt_Kanta_Komuniti_Masalah::where('kanta_komuniti_id', '=', $id)
                                    ->get();
            return view('rt-sm10.senarai-kanta-komuniti-ppd-4', compact('roles_menu','kanta_komuniti','state','daerah','kaum','krt_profile','masalah'));
        }
    }

    function senarai_kanta_komuniti_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__kanta_komuniti')
                        ->select('krt__kanta_komuniti.id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                'krt__kanta_komuniti.status AS status',
                                'ref__status_kanta_komuniti.status_description AS status_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__kanta_komuniti.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__kanta_komuniti.daerah_id')
                        ->leftJoin('ref__status_kanta_komuniti','ref__status_kanta_komuniti.id','=','krt__kanta_komuniti.status')
                        ->orderBy('krt__kanta_komuniti.id', 'asc')
                        ->whereIn('krt__kanta_komuniti.status', [1])
                        ->where('krt__kanta_komuniti.state_id', '=', Auth::user()->state_id)
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
            return view('rt-sm10.senarai-kanta-komuniti-ppn', compact('roles_menu','daerah'));
        }
    }

    function senarai_kanta_komuniti_ppn_1(Request $request, $id){
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
            $kanta_komuniti     = DB::table('krt__kanta_komuniti')
                                    ->select('krt__kanta_komuniti.id',
                                            'krt__kanta_komuniti.state_id AS state_id',
                                            'krt__kanta_komuniti.daerah_id AS daerah_id',
                                            'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                            'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_1 AS kanta_jenis_kediaman_1',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_2 AS kanta_jenis_kediaman_2',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_3 AS kanta_jenis_kediaman_3',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_4 AS kanta_jenis_kediaman_4',
                                            'krt__kanta_komuniti.kanta_sejarah_lokasi AS kanta_sejarah_lokasi',
                                            'krt__kanta_komuniti.kanta_kelebihan_lokasi AS kanta_kelebihan_lokasi',
                                            'krt__kanta_komuniti.kanta_kemudahan AS kanta_kemudahan')
                                    ->where('krt__kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state                  = RefStates::where('status', '=', true)
                                    ->get();
            $daerah                 = RefDaerah::where('status', '=', true)
                                    ->get();
            $kaum                   = RefKaum::where('status', '=', true)
                                    ->get();
            return view('rt-sm10.senarai-kanta-komuniti-ppn-1', compact('roles_menu','kanta_komuniti','state','daerah','kaum'));
        }
    }

    function senarai_kanta_komuniti_ppn_2(Request $request, $id){
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
            $kanta_komuniti     = DB::table('krt__kanta_komuniti')
                                    ->select('krt__kanta_komuniti.id',
                                            'krt__kanta_komuniti.state_id AS state_id',
                                            'krt__kanta_komuniti.daerah_id AS daerah_id',
                                            'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                            'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_1 AS kanta_jenis_kediaman_1',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_2 AS kanta_jenis_kediaman_2',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_3 AS kanta_jenis_kediaman_3',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_4 AS kanta_jenis_kediaman_4',
                                            'krt__kanta_komuniti.kanta_sejarah_lokasi AS kanta_sejarah_lokasi',
                                            'krt__kanta_komuniti.kanta_kelebihan_lokasi AS kanta_kelebihan_lokasi',
                                            'krt__kanta_komuniti.kanta_kemudahan AS kanta_kemudahan')
                                    ->where('krt__kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state                  = RefStates::where('status', '=', true)
                                    ->get();
            $daerah                 = RefDaerah::where('status', '=', true)
                                    ->get();
            $kaum                   = RefKaum::where('status', '=', true)
                                    ->get();
            return view('rt-sm10.senarai-kanta-komuniti-ppn-2', compact('roles_menu','kanta_komuniti','state','daerah','kaum'));
        }
    }

    function senarai_kanta_komuniti_ppn_3(Request $request, $id){
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
            $kanta_komuniti     = DB::table('krt__kanta_komuniti')
                                    ->select('krt__kanta_komuniti.id',
                                            'krt__kanta_komuniti.state_id AS state_id',
                                            'krt__kanta_komuniti.daerah_id AS daerah_id',
                                            'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                            'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_1 AS kanta_jenis_kediaman_1',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_2 AS kanta_jenis_kediaman_2',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_3 AS kanta_jenis_kediaman_3',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_4 AS kanta_jenis_kediaman_4',
                                            'krt__kanta_komuniti.kanta_sejarah_lokasi AS kanta_sejarah_lokasi',
                                            'krt__kanta_komuniti.kanta_kelebihan_lokasi AS kanta_kelebihan_lokasi',
                                            'krt__kanta_komuniti.kanta_kemudahan AS kanta_kemudahan')
                                    ->where('krt__kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state                  = RefStates::where('status', '=', true)
                                    ->get();
            $daerah                 = RefDaerah::where('status', '=', true)
                                    ->get();
            $kaum                   = RefKaum::where('status', '=', true)
                                    ->get();
            $krt_profile            = KRT_Profile::where('krt_status', '=', true)
                                    ->where('krt__profile.daerah_id','=',Auth::user()->daerah_id)
                                    ->get();
            return view('rt-sm10.senarai-kanta-komuniti-ppn-3', compact('roles_menu','kanta_komuniti','state','daerah','kaum','krt_profile'));
        }
    }

    function senarai_kanta_komuniti_ppn_4(Request $request, $id){
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
            $kanta_komuniti     = DB::table('krt__kanta_komuniti')
                                    ->select('krt__kanta_komuniti.id',
                                            'krt__kanta_komuniti.state_id AS state_id',
                                            'krt__kanta_komuniti.daerah_id AS daerah_id',
                                            'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                            'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_1 AS kanta_jenis_kediaman_1',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_2 AS kanta_jenis_kediaman_2',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_3 AS kanta_jenis_kediaman_3',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_4 AS kanta_jenis_kediaman_4',
                                            'krt__kanta_komuniti.kanta_sejarah_lokasi AS kanta_sejarah_lokasi',
                                            'krt__kanta_komuniti.kanta_kelebihan_lokasi AS kanta_kelebihan_lokasi',
                                            'krt__kanta_komuniti.kanta_kemudahan AS kanta_kemudahan')
                                    ->where('krt__kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state                  = RefStates::where('status', '=', true)
                                    ->get();
            $daerah                 = RefDaerah::where('status', '=', true)
                                    ->get();
            $kaum                   = RefKaum::where('status', '=', true)
                                    ->get();
            $krt_profile            = KRT_Profile::where('krt_status', '=', true)
                                    ->where('krt__profile.daerah_id','=',Auth::user()->daerah_id)
                                    ->get();
            $masalah                = Krt_Kanta_Komuniti_Masalah::where('kanta_komuniti_id', '=', $id)
                                    ->get();
            return view('rt-sm10.senarai-kanta-komuniti-ppn-4', compact('roles_menu','kanta_komuniti','state','daerah','kaum','krt_profile','masalah'));
        }
    }

    function senarai_kanta_komuniti_hq(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('krt__kanta_komuniti')
                        ->select('krt__kanta_komuniti.id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                'krt__kanta_komuniti.status AS status',
                                'ref__status_kanta_komuniti.status_description AS status_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__kanta_komuniti.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__kanta_komuniti.daerah_id')
                        ->leftJoin('ref__status_kanta_komuniti','ref__status_kanta_komuniti.id','=','krt__kanta_komuniti.status')
                        ->orderBy('krt__kanta_komuniti.id', 'asc')
                        ->whereIn('krt__kanta_komuniti.status', [1])
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
            $state     = RefStates::where('status', '=', true)
                        ->get();
            $daerah     = RefDaerah::where('status', '=', true)
                        ->get();
            return view('rt-sm10.senarai-kanta-komuniti-hq', compact('roles_menu','state','daerah'));
        }
    }

    function senarai_kanta_komuniti_hq_1(Request $request, $id){
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
            $kanta_komuniti     = DB::table('krt__kanta_komuniti')
                                    ->select('krt__kanta_komuniti.id',
                                            'krt__kanta_komuniti.state_id AS state_id',
                                            'krt__kanta_komuniti.daerah_id AS daerah_id',
                                            'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                            'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_1 AS kanta_jenis_kediaman_1',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_2 AS kanta_jenis_kediaman_2',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_3 AS kanta_jenis_kediaman_3',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_4 AS kanta_jenis_kediaman_4',
                                            'krt__kanta_komuniti.kanta_sejarah_lokasi AS kanta_sejarah_lokasi',
                                            'krt__kanta_komuniti.kanta_kelebihan_lokasi AS kanta_kelebihan_lokasi',
                                            'krt__kanta_komuniti.kanta_kemudahan AS kanta_kemudahan')
                                    ->where('krt__kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state                  = RefStates::where('status', '=', true)
                                    ->get();
            $daerah                 = RefDaerah::where('status', '=', true)
                                    ->get();
            $kaum                   = RefKaum::where('status', '=', true)
                                    ->get();
            return view('rt-sm10.senarai-kanta-komuniti-hq-1', compact('roles_menu','kanta_komuniti','state','daerah','kaum'));
        }
    }

    function senarai_kanta_komuniti_hq_2(Request $request, $id){
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
            $kanta_komuniti     = DB::table('krt__kanta_komuniti')
                                    ->select('krt__kanta_komuniti.id',
                                            'krt__kanta_komuniti.state_id AS state_id',
                                            'krt__kanta_komuniti.daerah_id AS daerah_id',
                                            'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                            'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_1 AS kanta_jenis_kediaman_1',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_2 AS kanta_jenis_kediaman_2',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_3 AS kanta_jenis_kediaman_3',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_4 AS kanta_jenis_kediaman_4',
                                            'krt__kanta_komuniti.kanta_sejarah_lokasi AS kanta_sejarah_lokasi',
                                            'krt__kanta_komuniti.kanta_kelebihan_lokasi AS kanta_kelebihan_lokasi',
                                            'krt__kanta_komuniti.kanta_kemudahan AS kanta_kemudahan')
                                    ->where('krt__kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state                  = RefStates::where('status', '=', true)
                                    ->get();
            $daerah                 = RefDaerah::where('status', '=', true)
                                    ->get();
            $kaum                   = RefKaum::where('status', '=', true)
                                    ->get();
            return view('rt-sm10.senarai-kanta-komuniti-hq-2', compact('roles_menu','kanta_komuniti','state','daerah','kaum'));
        }
    }

    function senarai_kanta_komuniti_hq_3(Request $request, $id){
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
            $kanta_komuniti     = DB::table('krt__kanta_komuniti')
                                    ->select('krt__kanta_komuniti.id',
                                            'krt__kanta_komuniti.state_id AS state_id',
                                            'krt__kanta_komuniti.daerah_id AS daerah_id',
                                            'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                            'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_1 AS kanta_jenis_kediaman_1',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_2 AS kanta_jenis_kediaman_2',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_3 AS kanta_jenis_kediaman_3',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_4 AS kanta_jenis_kediaman_4',
                                            'krt__kanta_komuniti.kanta_sejarah_lokasi AS kanta_sejarah_lokasi',
                                            'krt__kanta_komuniti.kanta_kelebihan_lokasi AS kanta_kelebihan_lokasi',
                                            'krt__kanta_komuniti.kanta_kemudahan AS kanta_kemudahan')
                                    ->where('krt__kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state                  = RefStates::where('status', '=', true)
                                    ->get();
            $daerah                 = RefDaerah::where('status', '=', true)
                                    ->get();
            $kaum                   = RefKaum::where('status', '=', true)
                                    ->get();
            $krt_profile            = KRT_Profile::where('krt_status', '=', true)
                                    ->where('krt__profile.daerah_id','=',Auth::user()->daerah_id)
                                    ->get();
            return view('rt-sm10.senarai-kanta-komuniti-hq-3', compact('roles_menu','kanta_komuniti','state','daerah','kaum','krt_profile'));
        }
    }

    function senarai_kanta_komuniti_hq_4(Request $request, $id){
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
            $kanta_komuniti     = DB::table('krt__kanta_komuniti')
                                    ->select('krt__kanta_komuniti.id',
                                            'krt__kanta_komuniti.state_id AS state_id',
                                            'krt__kanta_komuniti.daerah_id AS daerah_id',
                                            'krt__kanta_komuniti.kanta_nama AS kanta_nama',
                                            'krt__kanta_komuniti.kanta_alamat AS kanta_alamat',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_1 AS kanta_jenis_kediaman_1',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_2 AS kanta_jenis_kediaman_2',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_3 AS kanta_jenis_kediaman_3',
                                            'krt__kanta_komuniti.kanta_jenis_kediaman_4 AS kanta_jenis_kediaman_4',
                                            'krt__kanta_komuniti.kanta_sejarah_lokasi AS kanta_sejarah_lokasi',
                                            'krt__kanta_komuniti.kanta_kelebihan_lokasi AS kanta_kelebihan_lokasi',
                                            'krt__kanta_komuniti.kanta_kemudahan AS kanta_kemudahan')
                                    ->where('krt__kanta_komuniti.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state                  = RefStates::where('status', '=', true)
                                    ->get();
            $daerah                 = RefDaerah::where('status', '=', true)
                                    ->get();
            $kaum                   = RefKaum::where('status', '=', true)
                                    ->get();
            $krt_profile            = KRT_Profile::where('krt_status', '=', true)
                                    ->where('krt__profile.daerah_id','=',Auth::user()->daerah_id)
                                    ->get();
            $masalah                = Krt_Kanta_Komuniti_Masalah::where('kanta_komuniti_id', '=', $id)
                                    ->get();
            return view('rt-sm10.senarai-kanta-komuniti-hq-4', compact('roles_menu','kanta_komuniti','state','daerah','kaum','krt_profile','masalah'));
        }
    }

    function rekod_profil_skuad_unit(){
        return view('rt-sm10.rekod-profil-skuad-unit');
    }

    function add_profile_skuad_uniti_ppd(){
        return view('rt-sm10.add-profile-skuad-uniti-ppd');
    }

    function perancangan_aktivti_uniti(){
        return view('rt-sm10.perancangan-aktivti-uniti');
    }

    function add_perancangan_skuad_uniti_ppd(){
        return view('rt-sm10.add-perancangan-skuad-uniti-ppd');
    }

    function menyemak_perancangan_aktivti_uniti(){
        return view('rt-sm10.menyemak-perancangan-aktivti-uniti');
    }

    function menyemak_perancangan_aktivti_uniti_ppn(){
        return view('rt-sm10.menyemak-perancangan-aktivti-uniti-ppn');
    }

    function memperakui_perancangan_aktivti_uniti(){
        return view('rt-sm10.memperakui-perancangan-aktivti-uniti');
    }

    function memperakui_perancangan_aktivti_uniti_hq(){
        return view('rt-sm10.memperakui-perancangan-aktivti-uniti-hq');
    }

    function rekod_profil_sejiwa(){
        return view('rt-sm10.rekod-profil-sejiwa');
    }

    function add_profile_sejiwa_ppd(){
        return view('rt-sm10.add-profile-sejiwa-ppd');
    }

    function add_profile_sejiwa_ppd_1(){
        return view('rt-sm10.add-profile-sejiwa-ppd-1');
    }

    function perancangan_aktivti_sejiwa(){
        return view('rt-sm10.perancangan-aktivti-sejiwa');
    }

    function add_perancangan_sejiwa_ppd(){
        return view('rt-sm10.add-perancangan-sejiwa-ppd');
    }

    function menyemak_perancangan_aktivti_sejiwa(){
        return view('rt-sm10.menyemak-perancangan-aktivti-sejiwa');
    }

    function menyemak_perancangan_aktivti_sejiwa_ppn(){
        return view('rt-sm10.menyemak-perancangan-aktivti-sejiwa-ppn');
    }

    function menyemak_perancangan_aktivti_sejiwa_ppn_1(){
        return view('rt-sm10.menyemak-perancangan-aktivti-sejiwa-ppn-1');
    }

    function memperakui_perancangan_aktivti_sejiwa(){
        return view('rt-sm10.memperakui-perancangan-aktivti-sejiwa');
    }

    function memperakui_perancangan_aktivti_sejiwa_ppn(){
        return view('rt-sm10.memperakui-perancangan-aktivti-sejiwa-ppn');
    }
    function memperakui_perancangan_aktivti_sejiwa_ppn_1(){
        return view('rt-sm10.memperakui-perancangan-aktivti-sejiwa-ppn-1');
    }

    function senarai_psk(){
        return view('rt-sm10.senarai-psk');
    }

    function add_profile_psk(){
        return view('rt-sm10.add-profile-psk');
    }

    function add_profile_psk_1(){
        return view('rt-sm10.add-profile-psk-1');
    }

    function add_profile_psk_2(){
        return view('rt-sm10.add-profile-psk-2');
    }

    function add_profile_psk_3(){
        return view('rt-sm10.add-profile-psk-3');
    }

    function add_profile_psk_4(){
        return view('rt-sm10.add-profile-psk-4');
    }

    function semakan_senarai_psk(){
        return view('rt-sm10.semakan-senarai-psk');
    }

    function menyemak_profile_psk(){
        return view('rt-sm10.menyemak-profile-psk');
    }

    function menyemak_profile_psk_1(){
        return view('rt-sm10.menyemak-profile-psk-1');
    }

    function menyemak_profile_psk_2(){
        return view('rt-sm10.menyemak-profile-psk-2');
    }

    function pengesahan_senarai_psk(){
        return view('rt-sm10.pengesahan-senarai-psk');
    }

     function pengesahan_profile_psk(){
        return view('rt-sm10.pengesahan-profile-psk');
    }

    function senarai_laporan_aktivti_psk(){
        return view('rt-sm10.senarai-laporan-aktivti-psk');
    }

    function add_laporan_aktiviti_psk(){
        return view('rt-sm10.add-laporan-aktiviti-psk');
    }

    function add_laporan_aktiviti_psk_1(){
        return view('rt-sm10.add-laporan-aktiviti-psk-1');
    }

    function add_laporan_aktiviti_psk_2(){
        return view('rt-sm10.add-laporan-aktiviti-psk-2');
    }

    function add_laporan_aktiviti_psk_3(){
        return view('rt-sm10.add-laporan-aktiviti-psk-3');
    }

    function senarai_laporan_aktivti_psk_ppd(){
        return view('rt-sm10.senarai-laporan-aktivti-psk-ppd');
    }

    function sah_laporan_aktiviti_psk_ppd(){
        return view('rt-sm10.sah-laporan-aktiviti-psk-ppd');
    }

    function sah_laporan_aktiviti_psk_ppd_1(){
        return view('rt-sm10.sah-laporan-aktiviti-psk-ppd-1');
    }

    function sah_laporan_aktiviti_psk_ppd_2(){
        return view('rt-sm10.sah-laporan-aktiviti-psk-ppd-2');
    }

    function sah_laporan_aktiviti_psk_ppd_3(){
        return view('rt-sm10.sah-laporan-aktiviti-psk-ppd-3');
    }

    function senarai_laporan_isu_psk(){
        return view('rt-sm10.senarai-laporan-isu-psk');
    }

    function add_laporan_isu_psk(){
        return view('rt-sm10.add-laporan-isu-psk');
    }

    function senarai_laporan_isu_psk_ppd(){
        return view('rt-sm10.senarai-laporan-isu-psk-ppd');
    }

    function semakan_laporan_isu_psk(){
        return view('rt-sm10.semakan-laporan-isu-psk');
    }

    function senarai_laporan_isu_psk_ppn(){
        return view('rt-sm10.senarai-laporan-isu-psk-ppn');
    }

    function pengesahan_laporan_isu_psk(){
        return view('rt-sm10.pengesahan-laporan-isu-psk');
    }

    function senarai_projek_ekonomi(){
        return view('rt-sm10.senarai-projek-ekonomi');
    }

    function add_profile_projek_ekonomi(){
        return view('rt-sm10.add-profile-projek-ekonomi');
    }

    function senarai_semakan_projek_ekonomi_ppd(){
        return view('rt-sm10.senarai-semakan-projek-ekonomi-ppd');
    }

    function menyemak_projek_ekonomi_ppd(){
        return view('rt-sm10.menyemak-projek-ekonomi-ppd');
    }

    function senarai_pengesahan_projek_ekonomi_ppn(){
        return view('rt-sm10.senarai-pengesahan-projek-ekonomi-ppn');
    }

    function pengesahan_projek_ekonomi_ppn(){
        return view('rt-sm10.pengesahan-projek-ekonomi-ppn');
    }

    function senarai_laporan_projek_ekonomi(){
        return view('rt-sm10.senarai-laporan-projek-ekonomi');
    }

    function add_laporan_projek_ekonomi(){
        return view('rt-sm10.add-laporan-projek-ekonomi');
    }

    function senarai_semakan_laporan_projek_ekonomi(){
        return view('rt-sm10.senarai-semakan-laporan-projek-ekonomi');
    }

    function menyemak_laporan_projek_ekonomi(){
        return view('rt-sm10.menyemak-laporan-projek-ekonomi');
    }

    function senarai_pengesahan_laporan_projek_ekonomi(){
        return view('rt-sm10.senarai-pengesahan-laporan-projek-ekonomi');
    }

    function pengesahan_laporan_projek_ekonomi(){
        return view('rt-sm10.pengesahan-laporan-projek-ekonomi');
    }

    function add_profile_koperasi_krt(){
        return view('rt-sm10.add-profile-koperasi-krt');
    }

    function senarai_semakan_koperasi_krt(){
        return view('rt-sm10.senarai-semakan-koperasi-krt');
    }

    function menyemak_koperasi_krt_ppd(){
        return view('rt-sm10.menyemak-koperasi-krt-ppd');
    }

    function senarai_pengesahan_koperasi_krt(){
        return view('rt-sm10.senarai-pengesahan-koperasi-krt');
    }

    function pengesahan_koperasi_krt_ppn(){
        return view('rt-sm10.pengesahan-koperasi-krt-ppn');
    }
    
    function view_profil_koperasi_krt(){
        return view('rt-sm10.view-profil-koperasi-krt');
    }

    function senarai_laporan_aktif_koperasi_krt(){
        return view('rt-sm10.senarai-laporan-aktif-koperasi-krt');
    }

    function laporan_aktif_koperasi_krt_ppd(){
        return view('rt-sm10.laporan-aktif-koperasi-krt-ppd');
    }

    function senarai_p_laporan_aktif_koperasi_krt(){
        return view('rt-sm10.senarai-p-laporan-aktif-koperasi-krt');
    }

    function p_laporan_aktif_koperasi_krt_ppn(){
        return view('rt-sm10.p-laporan-aktif-koperasi-krt-ppn');
    }

    function senarai_keaktifan_koperasi_krt(){
        return view('rt-sm10.senarai-keaktifan-koperasi-krt');
    }

}
