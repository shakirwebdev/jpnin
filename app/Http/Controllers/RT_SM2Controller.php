<?php

namespace App\Http\Controllers;

use DataTables;
use DB;
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
use App\RefPBT;
use App\User;
use App\RT_Applications;
use App\KRT_Profile;
use App\KRT_Komposisi_penduduk;
use App\RefProfession;
use App\KRT_Pekerjaan;
use App\RefJenisRumah;
use App\KRT_JenisRumah;
use App\RefJenisPertubuhan;
use App\KRT_JenisPertubuhan;
use App\RefKemudahanAwam;
use App\KRT_KemudahanAwam;
use App\KRT_KesJenayah;
use App\KRT_masalahSosial;
use App\RefPertanian;
use App\KRT_KawasanPertanian;
use App\KRT_JawatankuasaPenaja;
use App\KRT_CadanganPembinaanPRT;
use App\RefStatusBagunan;
use App\RefJenisPremis;
use App\KRT_Binaan;
use App\KRT_Bagunan_Tumpang;
use App\Krt_Bagunan_Sewa;
use App\RefJenisKabin;
use App\KRT_Kabin;
use App\Krt_Profile_Upload_Peta;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class RT_SM2Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function profile_krt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_parlimen') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefParlimen::where($where)->get();
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
            $negeri          = RefStates::where('status', '=', true)->get();
            $daerah          = RefDaerah::where('status', '=', true)->get();
            $ref_kaum        = RefKaum::where('status', '=', true)->get();
            $profile_krt     = DB::table('krt__profile')
                            ->select('krt__profile.id',
                                'krt__profile.krt_nama',
                                'krt__profile.krt_alamat',
                                'krt__profile.state_id',
                                'krt__profile.daerah_id',
                                'krt__profile.parlimen_id',
                                'krt__profile.dun_id',
                                'krt__profile.pbt_id',
                                'krt__profile.krt_kawasan',
                                'krt__profile.krt_keluasan',
                                'krt__profile.krt_ipd',
                                'krt__profile.krt_balai',
                                'krt__profile.srs_nama',
                                'krt__profile.krt_tabika',
                                'krt__profile.krt_taska',
                                'krt__profile.krt_status_bagunan_id',
                                'krt__profile.krt_status',
                                DB::raw(" DATE_FORMAT(rt__applications.created_at,'%d/%m/%Y') AS created_at"),
                                'rt__applications.user_fullname',
                                'rt__applications.no_ic',
                                'rt__applications.user_address',
                                'krt__profile.krt_status AS status',
                                'ref__status_krt.status_description AS status_description',
                                'krt__profile.disemak_note AS disemak_note',
                                'krt__profile.disahkan_note AS disahkan_note')
                                ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                                ->leftJoin('ref__status_krt','ref__status_krt.id','=','krt__profile.krt_status')
                                ->where('krt__profile.id', '=', Auth::user()->krt_id)  
                                ->limit(1)
                                ->first();
            $parlimen         = RefParlimen::where('state_id', '=', $profile_krt->state_id)->get();
            $pbt              = RefPBT::where('state_id', '=', $profile_krt->state_id)->get();
            $dun              = RefDun::where('state_id', '=', $profile_krt->state_id)->get();
            return view('rt-sm2.profile-krt', compact('roles_menu','negeri', 'daerah', 'ref_kaum', 'profile_krt', 'parlimen', 'pbt', 'dun'));
        }
    }

    function get_krt_profile_komposisi_table(Request $request, $id){
        $data = DB::table('krt__komposisi_penduduk')
                    ->select('krt__komposisi_penduduk.*','ref__kaum.kaum_description')
                    ->join('ref__kaum','ref__kaum.id','=','krt__komposisi_penduduk.komposisi_kaum')
                    ->where('krt__komposisi_penduduk.krt_profileID', '=', $id)
                    ->get();
                return Datatables::of($data)
                        ->make(true);
    }

    function add_profile_krt_komposisi(Request $request){
        $action = $request->add_profile_krt_komposisi;
        $app_id = $request->pk2_krt_profileID;
        
        $rules = array(
            'pk2_komposisi_kaum'                => 'required',
            'pk2_komposisi_jumlah'              => 'required'
        );

        $messages = [
            'pk2_komposisi_kaum.required'       => 'Pilih status kedudukan Kaum yang dipohon',
            'pk2_komposisi_jumlah.required'     => 'Ruangan Jumlah mesti diisi',
            
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $komposisi_penduduk = new KRT_Komposisi_penduduk;
                $komposisi_penduduk->krt_profileID    = $app_id;
                $komposisi_penduduk->komposisi_kaum   = $request->pk2_komposisi_kaum;
                $komposisi_penduduk->komposisi_jumlah = $request->pk2_komposisi_jumlah;
                $komposisi_penduduk->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_krt_profile_komposisi($id){
        $data = DB::table('krt__komposisi_penduduk')->where('id', '=', $id)->delete();
    }

    function update_profile_krt(Request $request){
        $action = $request->update_profile_krt;
        $app_id = $request->pk3_krt_profile_id;
        
        $rules = array(
            'pk_parlimen_id'            => 'required',
            'pk_pbt_id'                 => 'required',
            'pk_krt_kawasan'            => 'required',
            'pk_krt_keluasan'           => 'required',
            'pk_krt_ipd'                => 'required',
            'pk_krt_balai'              => 'required'
        );

        $messages = [
            'pk_parlimen_id.required'   => 'Ruangan parliment mesti dipilih',
            'pk_pbt_id.required'        => 'Ruangan pihak berkuasa tempatan mesti dipilih',
            'pk_krt_kawasan.required'   => 'Ruangan nama kawasan mesti diisi',
            'pk_krt_keluasan.required'  => 'Ruangan saiz keluasan mesti diisi',
            'pk_krt_ipd.required'       => 'Ruangan Ibu Pejabat Polis Daerah mesti diisi',
            'pk_krt_balai.required'     => 'Ruangan Balai Poslis Daerah mesti diisi'
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $krt_profile  = KRT_Profile::where($where)->first();
                $krt_profile->parlimen_id        = $request->pk_parlimen_id;
                $krt_profile->pbt_id             = $request->pk_pbt_id;
                $krt_profile->dun_id             = $request->pk_dun_id;
                $krt_profile->krt_kawasan        = $request->pk_krt_kawasan;
                $krt_profile->krt_keluasan       = $request->pk_krt_keluasan;
                $krt_profile->krt_ipd            = $request->pk_krt_ipd;
                $krt_profile->krt_balai          = $request->pk_krt_balai;
                $krt_profile->srs_nama           = $request->pk_srs_nama;
                $krt_profile->krt_tabika         = $request->pk_krt_tabika;
                $krt_profile->krt_taska          = $request->pk_krt_taska;
                $krt_profile->save();
                
            }
        }
    }

    function profile_krt_1(Request $request){
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
            $profession     = RefProfession::where('status', '=', true)->get();
            $jenis_rumah    = RefJenisRumah::where('status', '=', true)->get();
            $profile_krt    = DB::table('krt__profile')
                            ->select('krt__profile.id',
                                'krt__profile.krt_nama',
                                'krt__profile.krt_alamat',
                                'krt__profile.state_id',
                                'krt__profile.daerah_id',
                                'krt__profile.parlimen_id',
                                'krt__profile.dun_id',
                                'krt__profile.pbt_id',
                                'krt__profile.krt_kawasan',
                                'krt__profile.krt_keluasan',
                                'krt__profile.krt_ipd',
                                'krt__profile.krt_balai',
                                'krt__profile.srs_nama',
                                'krt__profile.krt_tabika',
                                'krt__profile.krt_taska',
                                'krt__profile.krt_status_bagunan_id',
                                'krt__profile.krt_status',
                                DB::raw(" DATE_FORMAT(rt__applications.created_at,'%d/%m/%Y') AS created_at"),
                                'rt__applications.user_fullname',
                                'rt__applications.no_ic',
                                'rt__applications.user_address',
                                'krt__profile.krt_status AS status',
                                'ref__status_krt.status_description AS status_description',
                                'krt__profile.disemak_note AS disemak_note',
                                'krt__profile.disahkan_note AS disahkan_note')
                            ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                            ->leftJoin('ref__status_krt','ref__status_krt.id','=','krt__profile.krt_status')
                            ->where('krt__profile.id', '=', Auth::user()->krt_id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm2.profile-krt-1', compact('roles_menu','profession', 'jenis_rumah', 'profile_krt'));
        }
    }

    function get_krt_profile_pekerjaan_table(Request $request, $id){
        $data = DB::table('krt__pekerjaan')
                    ->select('krt__pekerjaan.*','ref__profession.profession_description')
                    ->join('ref__profession','ref__profession.id','=','krt__pekerjaan.profession_id')
                    ->where('krt__pekerjaan.krt_profileID', '=', $id)
                    ->get();
                return Datatables::of($data)
                        ->make(true);
    }

    function add_profile_krt_pekerjaan(Request $request){
        $action = $request->add_profile_krt_pekerjaan;
        $app_id = $request->pk4_krt_profileID;
        
        $rules = array(
            'pk4_profession_id'                 => 'required',
            'pk4_pekerjaan_peratus'             => 'required'
        );

        $messages = [
            'pk4_profession_id.required'        => 'Ruangan pekerjaan mesti dipilih',
            'pk4_pekerjaan_peratus.required'    => 'Ruangan Peratus (%) mesti diisi',
            
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $pekerjaan = new KRT_Pekerjaan;
                $pekerjaan->krt_profileID       = $app_id;
                $pekerjaan->profession_id       = $request->pk4_profession_id;
                $pekerjaan->pekerjaan_peratus   = $request->pk4_pekerjaan_peratus;
                $pekerjaan->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_krt_profile_pekerjaan($id){
        $data = DB::table('krt__pekerjaan')->where('id', '=', $id)->delete();
    }

    function get_krt_profile_jenis_rumah_table(Request $request, $id){
        $data = DB::table('krt__jenis_rumah')
                ->select('krt__jenis_rumah.*','ref__jenis_rumah.jenis_rumah_description')
                ->join('ref__jenis_rumah','ref__jenis_rumah.id','=','krt__jenis_rumah.jenis_rumah_id')
                ->where('krt__jenis_rumah.krt_profileID', '=', $id)
                ->get();
            return Datatables::of($data)
                ->make(true);
    }

    function add_profile_krt_jenis_rumah(Request $request){
        $action = $request->add_profile_krt_jenis_rumah;
        $app_id = $request->pk5_krt_profileID;
        
        $rules = array(
            'pk5_jenis_rumah_id'                 => 'required',
            'pk5_jumlah_pintu'                   => 'required'
        );

        $messages = [
            'pk5_jenis_rumah_id.required'        => 'Ruangan Jenis Rumah mesti dipilih',
            'pk5_jumlah_pintu.required'          => 'Ruangan Bilangan Pintu/Unit mesti diisi',
            
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $jenis_rumah = new KRT_JenisRumah;
                $jenis_rumah->krt_profileID    = $app_id;
                $jenis_rumah->jenis_rumah_id   = $request->pk5_jenis_rumah_id;
                $jenis_rumah->jumlah_pintu     = $request->pk5_jumlah_pintu;
                $jenis_rumah->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_krt_profile_jenis_rumah($id){
        $data = DB::table('krt__jenis_rumah')->where('id', '=', $id)->delete();
    }

    function profile_krt_2(Request $request){
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
            $profile_krt    = DB::table('krt__profile')
                            ->select('krt__profile.id',
                                'krt__profile.krt_nama',
                                'krt__profile.krt_alamat',
                                'krt__profile.state_id',
                                'krt__profile.daerah_id',
                                'krt__profile.parlimen_id',
                                'krt__profile.dun_id',
                                'krt__profile.pbt_id',
                                'krt__profile.krt_kawasan',
                                'krt__profile.krt_keluasan',
                                'krt__profile.krt_ipd',
                                'krt__profile.krt_balai',
                                'krt__profile.srs_nama',
                                'krt__profile.krt_tabika',
                                'krt__profile.krt_taska',
                                'krt__profile.krt_status_bagunan_id',
                                'krt__profile.krt_status',
                                DB::raw(" DATE_FORMAT(rt__applications.created_at,'%d/%m/%Y') AS created_at"),
                                'rt__applications.user_fullname',
                                'rt__applications.no_ic',
                                'rt__applications.user_address',
                                'krt__profile.krt_status AS status',
                                'ref__status_krt.status_description AS status_description',
                                'krt__profile.disemak_note AS disemak_note',
                                'krt__profile.disahkan_note AS disahkan_note')
                            ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                            ->leftJoin('ref__status_krt','ref__status_krt.id','=','krt__profile.krt_status')
                            ->where('krt__profile.id', '=', Auth::user()->krt_id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm2.profile-krt-2', compact('roles_menu','profile_krt'));
        }
    }

    function get_profile_krt_jenis_pertubuhan_table(Request $request, $id){
        return DataTables()->of(
            DB::select(DB::raw("
                SELECT
                ref__jenis_pertubuhan.id, ref__jenis_pertubuhan.jenis_pertubuhan_description, ref__jenis_pertubuhan.status, krt__jenis_pertubuhan.id AS krt_JenisPertubuhanID, krt__jenis_pertubuhan.krt_profileID, krt__jenis_pertubuhan.jenis_pertubuhan_id
                FROM
                ref__jenis_pertubuhan
                LEFT JOIN krt__jenis_pertubuhan ON krt__jenis_pertubuhan.jenis_pertubuhan_id = ref__jenis_pertubuhan.id
                AND krt__jenis_pertubuhan.krt_profileID ='" . $id . "'
                ORDER BY ref__jenis_pertubuhan.id + 0 ASC
            "))
        )->make();
    }

    function post_profile_krt_jenis_pertubuhan(Request $request){
        $pk6_krt_profileID      = $request->pk6_krt_profileID;
        $krt_JenisPertubuhanID  = $request->krt_JenisPertubuhanID;
        
        $jenis_pekerjaan                        = new KRT_JenisPertubuhan;
        $jenis_pekerjaan->krt_profileID         = $pk6_krt_profileID;
        $jenis_pekerjaan->jenis_pertubuhan_id   = $request->krt_JenisPertubuhanID;
        $jenis_pekerjaan->save();

    }

    function post_delete_profile_krt_jenis_pertubuhan(Request $request){
        $pk6_krt_profileID      = $request->pk6_krt_profileID;
        $krt_JenisPertubuhanID  = $request->krt_JenisPertubuhanID;

        $data = DB::table('krt__jenis_pertubuhan')
                ->where('krt_profileID', '=', $pk6_krt_profileID)
                ->where('jenis_pertubuhan_id', '=', $krt_JenisPertubuhanID)
                ->delete();
        
    }

    function profile_krt_3(Request $request){
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
            $kemudahan_awam   = RefKemudahanAwam::where('status', '=', true)->get();
            $profile_krt      = DB::table('krt__profile')
                                    ->select('krt__profile.id',
                                            'krt__profile.krt_nama',
                                            'krt__profile.krt_alamat',
                                            'krt__profile.state_id',
                                            'krt__profile.daerah_id',
                                            'krt__profile.parlimen_id',
                                            'krt__profile.dun_id',
                                            'krt__profile.pbt_id',
                                            'krt__profile.krt_kawasan',
                                            'krt__profile.krt_keluasan',
                                            'krt__profile.krt_ipd',
                                            'krt__profile.krt_balai',
                                            'krt__profile.srs_nama',
                                            'krt__profile.krt_tabika',
                                            'krt__profile.krt_taska',
                                            'krt__profile.krt_status_bagunan_id',
                                            'krt__profile.krt_status',
                                            DB::raw(" DATE_FORMAT(rt__applications.created_at,'%d/%m/%Y') AS created_at"),
                                            'rt__applications.user_fullname',
                                            'rt__applications.no_ic',
                                            'rt__applications.user_address',
                                            'krt__profile.krt_status AS status',
                                            'ref__status_krt.status_description AS status_description',
                                            'krt__profile.disemak_note AS disemak_note',
                                            'krt__profile.disahkan_note AS disahkan_note')
                                    ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                                    ->leftJoin('ref__status_krt','ref__status_krt.id','=','krt__profile.krt_status')
                                    ->where('krt__profile.id', '=', Auth::user()->krt_id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm2.profile-krt-3', compact('roles_menu','kemudahan_awam', 'profile_krt'));
        }
    }

    function get_profile_krt_kemudahan_awam_table(Request $request, $id){
        $data = DB::table('krt__kemudahan_awam')
                ->select('krt__kemudahan_awam.*','ref__kemudahan_awam.kemudahan_awam_description')
                ->join('ref__kemudahan_awam','ref__kemudahan_awam.id','=','krt__kemudahan_awam.ref_kemudahan_awamID')
                ->where('krt__kemudahan_awam.krt_profileID', '=', $id)
                ->get();
            return Datatables::of($data)
                ->make(true);
    }

    function add_profile_krt_kemudahan_awam(Request $request){
        $action = $request->add_profile_krt_kemudahan_awam;
        $app_id = $request->pk7_krt_profileID;
        
        $rules = array(
            'pk7_ref_kemudahan_awamID'            => 'required',
            'pk7_kemudahan_awam_jumlah'           => 'required'
        );

        $messages = [
            'pk7_ref_kemudahan_awamID.required'   => 'Ruangan Perkara mesti dipilih',
            'pk7_kemudahan_awam_jumlah.required'  => 'Ruangan Jumlah mesti diisi',
            
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $kemudahan_awam                         = new KRT_KemudahanAwam;
                $kemudahan_awam->krt_profileID          = $app_id;
                $kemudahan_awam->ref_kemudahan_awamID   = $request->pk7_ref_kemudahan_awamID;
                $kemudahan_awam->kemudahan_awam_jumlah  = $request->pk7_kemudahan_awam_jumlah;
                $kemudahan_awam->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_profile_krt_kemudahan_awam($id){
        $data = DB::table('krt__kemudahan_awam')->where('id', '=', $id)->delete();
    }

    function profile_krt_4(Request $request){
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
            $profile_krt    = DB::table('krt__profile')
                            ->select('krt__profile.id',
                                'krt__profile.krt_nama',
                                'krt__profile.krt_alamat',
                                'krt__profile.state_id',
                                'krt__profile.daerah_id',
                                'krt__profile.parlimen_id',
                                'krt__profile.dun_id',
                                'krt__profile.pbt_id',
                                'krt__profile.krt_kawasan',
                                'krt__profile.krt_keluasan',
                                'krt__profile.krt_ipd',
                                'krt__profile.krt_balai',
                                'krt__profile.srs_nama',
                                'krt__profile.krt_tabika',
                                'krt__profile.krt_taska',
                                'krt__profile.krt_status_bagunan_id',
                                'krt__profile.krt_status',
                                DB::raw(" DATE_FORMAT(rt__applications.created_at,'%d/%m/%Y') AS created_at"),
                                'rt__applications.user_fullname',
                                'rt__applications.no_ic',
                                'rt__applications.user_address',
                                'krt__profile.krt_status AS status',
                                'ref__status_krt.status_description AS status_description',
                                'krt__profile.disemak_note AS disemak_note',
                                'krt__profile.disahkan_note AS disahkan_note')
                            ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                            ->leftJoin('ref__status_krt','ref__status_krt.id','=','krt__profile.krt_status')
                            ->where('krt__profile.id', '=', Auth::user()->krt_id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm2.profile-krt-4', compact('roles_menu','profile_krt'));
        }
    }

    function get_profile_krt_kes_jenayah_table(Request $request, $id){
        return DataTables()->of(
            DB::select(DB::raw("
                SELECT
                ref__jenayah.id, ref__jenayah.jenayah_description, ref__jenayah.status, krt__kes_jenayah.id AS krt_kesJenayahID, krt__kes_jenayah.krt_profileID, krt__kes_jenayah.ref_jenayahID
                FROM
                ref__jenayah
                LEFT JOIN krt__kes_jenayah ON krt__kes_jenayah.ref_jenayahID = ref__jenayah.id
                AND krt__kes_jenayah.krt_profileID ='" . $id . "'
                ORDER BY ref__jenayah.id + 0 ASC
            "))
        )->make();
    }

    function post_profile_krt_kes_jenayah(Request $request){
        $pk8_krt_profileID  = $request->pk8_krt_profileID;
        $krt_kesJenayahID   = $request->krt_kesJenayahID;
        
        $kes_jenayah = new KRT_KesJenayah;
        $kes_jenayah->krt_profileID         = $pk8_krt_profileID;
        $kes_jenayah->ref_jenayahID         = $request->krt_kesJenayahID;
        $kes_jenayah->save();

    }

    function post_delete_profile_krt_kes_jenayah(Request $request){
        $pk8_krt_profileID      = $request->pk8_krt_profileID;
        $krt_kesJenayahID       = $request->krt_kesJenayahID;

        $data = DB::table('krt__kes_jenayah')
                ->where('krt_profileID', '=', $pk8_krt_profileID)
                ->where('ref_jenayahID', '=', $krt_kesJenayahID)
                ->delete();
        
    }

    function get_profile_krt_masalah_sosial_table(Request $request, $id){
        return DataTables()->of(
            DB::select(DB::raw("
                SELECT
                ref__masalah_sosial.id, ref__masalah_sosial.sosial_description, ref__masalah_sosial.status, 
                krt__masalah_sosial.id AS krt_masalahSosialID, krt__masalah_sosial.krt_profileID, krt__masalah_sosial.ref_masalahSosialID
                FROM
                ref__masalah_sosial
                LEFT JOIN krt__masalah_sosial ON krt__masalah_sosial.ref_masalahSosialID = ref__masalah_sosial.id
                AND krt__masalah_sosial.krt_profileID ='" . $id . "'
                ORDER BY ref__masalah_sosial.id + 0 ASC
            "))
        )->make();
    }

    function post_profile_krt_masalah_sosial(Request $request){
        $pk9_krt_profileID      = $request->pk9_krt_profileID;
        $krt_masalahSosialID    = $request->krt_masalahSosialID;
        
        $kes_jenayah = new KRT_masalahSosial;
        $kes_jenayah->krt_profileID             = $pk9_krt_profileID;
        $kes_jenayah->ref_masalahSosialID       = $request->krt_masalahSosialID;
        $kes_jenayah->save();

    }

    function post_delete_profile_krt_masalah_sosial(Request $request){
        $pk9_krt_profileID          = $request->pk9_krt_profileID;
        $krt_masalahSosialID        = $request->krt_masalahSosialID;

        $data = DB::table('krt__masalah_sosial')
                ->where('krt_profileID', '=', $pk9_krt_profileID)
                ->where('ref_masalahSosialID', '=', $krt_masalahSosialID)
                ->delete();
    }

    function profile_krt_5(Request $request){
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
            $pertanian       = RefPertanian::where('status', '=', true)->get();
            $profile_krt     = DB::table('krt__profile')
                            ->select('krt__profile.id',
                                'krt__profile.krt_nama',
                                'krt__profile.krt_alamat',
                                'krt__profile.state_id',
                                'krt__profile.daerah_id',
                                'krt__profile.parlimen_id',
                                'krt__profile.dun_id',
                                'krt__profile.pbt_id',
                                'krt__profile.krt_kawasan',
                                'krt__profile.krt_keluasan',
                                'krt__profile.krt_ipd',
                                'krt__profile.krt_balai',
                                'krt__profile.srs_nama',
                                'krt__profile.krt_tabika',
                                'krt__profile.krt_taska',
                                'krt__profile.krt_status_bagunan_id',
                                'krt__profile.krt_status',
                                DB::raw(" DATE_FORMAT(rt__applications.created_at,'%d/%m/%Y') AS created_at"),
                                'rt__applications.user_fullname',
                                'rt__applications.no_ic',
                                'rt__applications.user_address',
                                'krt__profile.krt_status AS status',
                                'ref__status_krt.status_description AS status_description',
                                'krt__profile.disemak_note AS disemak_note',
                                'krt__profile.disahkan_note AS disahkan_note')
                            ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                            ->leftJoin('ref__status_krt','ref__status_krt.id','=','krt__profile.krt_status')
                            ->where('krt__profile.id', '=', Auth::user()->krt_id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm2.profile-krt-5', compact('roles_menu','pertanian', 'profile_krt'));
        }
    }

    function get_profile_krt_kawasan_pertanian_table(Request $request, $id){
        $data = DB::table('krt__kawasan_pertanian')
                ->select('krt__kawasan_pertanian.*','ref__pertanian.pertanian_description')
                ->join('ref__pertanian','ref__pertanian.id','=','krt__kawasan_pertanian.ref_pertanianID')
                ->where('krt__kawasan_pertanian.krt_profileID', '=', $id)
                ->get();
        return Datatables::of($data)
                ->make(true);
    }

    function add_profile_krt_kawasan_pertanian(Request $request){
        $action = $request->add_profile_krt_kawasan_pertanian;
        $app_id = $request->pk10_krt_profileID;
        
        $rules = array(
            'pk10_ref_pertanianID'                       => 'required',
            'pk10_kawasan_pertanian_dalam'               => 'required',
            'pk10_kawasan_pertanian_luar'                => 'required'
        );

        $messages = [
            'pk10_ref_pertanianID.required'              => 'Ruangan Perkara mesti dipilih',
            'pk10_kawasan_pertanian_dalam.required'      => 'Ruangan Dalam Kawasan KRT mesti diisi',
            'pk10_kawasan_pertanian_luar.required'       => 'Ruangan Luar  Kawasan KRT mesti diisi',
            
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $kawasan_pertanian = new KRT_KawasanPertanian;
                $kawasan_pertanian->krt_profileID               = $app_id;
                $kawasan_pertanian->ref_pertanianID             = $request->pk10_ref_pertanianID;
                $kawasan_pertanian->kawasan_pertanian_dalam     = $request->pk10_kawasan_pertanian_dalam;
                $kawasan_pertanian->kawasan_pertanian_luar      = $request->pk10_kawasan_pertanian_luar;
                $kawasan_pertanian->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_profile_krt_kawasan_pertanian($id){
        $data = DB::table('krt__kawasan_pertanian')->where('id', '=', $id)->delete();
    }

    function profile_krt_6(Request $request){
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
            $ref_status_bagunan     = RefStatusBagunan::where('status', '=', true)->get();
            $jenis_premis_binaan    = RefJenisPremis::where('status', '=', true)->get()
                                        ->whereIn('id', [1,2,3,4,5,6]);
            $jenis_premis_tumpang   = RefJenisPremis::where('status', '=', true)->get()
                                        ->whereIn('id', [1,2,3,4,5,6]);
            $kabin                  = RefJenisKabin::where('status', '=', true)->get();
            $profile_krt            = DB::table('krt__profile')
                                        ->select('krt__profile.id',
                                                'krt__profile.krt_nama',
                                                'krt__profile.krt_alamat',
                                                'krt__profile.state_id',
                                                'krt__profile.daerah_id',
                                                'krt__profile.parlimen_id',
                                                'krt__profile.dun_id',
                                                'krt__profile.pbt_id',
                                                'krt__profile.krt_kawasan',
                                                'krt__profile.krt_keluasan',
                                                'krt__profile.krt_ipd',
                                                'krt__profile.krt_balai',
                                                'krt__profile.srs_nama',
                                                'krt__profile.krt_tabika',
                                                'krt__profile.krt_taska',
                                                'krt__profile.krt_status_bagunan_id',
                                                'krt__profile.krt_status',
                                                DB::raw(" DATE_FORMAT(rt__applications.created_at,'%d/%m/%Y') AS created_at"),
                                                'rt__applications.user_fullname',
                                                'rt__applications.no_ic',
                                                'rt__applications.user_address',
                                                'krt__profile.krt_status AS status',
                                                'ref__status_krt.status_description AS status_description',
                                                'krt__profile.disemak_note AS disemak_note',
                                                'krt__profile.disahkan_note AS disahkan_note')
                                        ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                                        ->leftJoin('ref__status_krt','ref__status_krt.id','=','krt__profile.krt_status')
                                        ->where('krt__profile.id', '=', Auth::user()->krt_id)  
                                        ->limit(1)
                                        ->first();
            return view('rt-sm2.profile-krt-6', compact('roles_menu','ref_status_bagunan', 'jenis_premis_binaan', 'jenis_premis_tumpang' , 'kabin' ,'profile_krt'));
        }
    }

    function get_profile_krt_senarai_binaan(Request $request, $id){
        $data = DB::table('krt__binaan')
                ->select('krt__binaan.*', 'ref__jenis_premis.jenis_premis_description')
                ->join('ref__jenis_premis','ref__jenis_premis.id','=','krt__binaan.binaan_jenis_premis_id')
                ->where('krt__binaan.krt_profileID', '=', $id)
                ->get();
        return Datatables::of($data)
                ->make(true);
    }

    function add_profile_krt_binaan_jambatan(Request $request){
        $action = $request->add_binaan_jambatan;
        
        $rules = array(
            'mabj_binaan_jenis_premis_id'            => 'required',
            'mabj_binaan_alamat'                     => 'required',
            'mabj_status_tanah_id'                   => 'required',
            'mabj_binaan_keluasan_tanah'             => 'required',
            'mabj_binaan_keluasan_bagunan'           => 'required',
            'mabj_binaan_tarikh_mula_bina'           => 'required',
            'mabj_binaan_isu'                        => 'required',
        );

        $messages = [
            'mabj_binaan_jenis_premis_id.required'      => 'Ruangan Jenis Premis mesti dipilih',
            'mabj_binaan_alamat.required'               => 'Ruangan Alamat mesti diisi',
            'mabj_status_tanah_id.required'             => 'Ruangan Status Tanah mesti dipilih',
            'mabj_binaan_keluasan_tanah.required'       => 'Ruangan Keluasan Tanah mesti diisi',
            'mabj_binaan_keluasan_bagunan.required'     => 'Ruangan Keluasan Bagunan mesti diisi',
            'mabj_binaan_tarikh_mula_bina.required'     => 'Ruangan Tarikh Mula Bina Bagunan mesti dipilih',
            'mabj_binaan_isu.required'                  => 'Ruangan Isu mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $carbon_obj = Carbon::createFromFormat('d/m/Y', $request->mabj_binaan_tarikh_mula_bina)->format('Y-m-d');
                $krt_binaan = new KRT_Binaan;
                $krt_binaan->krt_profileID              = $request->mabj_krt_profileID;
                $krt_binaan->binaan_jenis_premis_id     = $request->mabj_binaan_jenis_premis_id;
                $krt_binaan->binaan_alamat              = $request->mabj_binaan_alamat;
                $krt_binaan->status_tanah_id           = $request->mabj_status_tanah_id;
                $krt_binaan->binaan_kos                 = $request->mabj_binaan_kos;
                $krt_binaan->binaan_keluasan_tanah      = $request->mabj_binaan_keluasan_tanah;
                $krt_binaan->binaan_keluasan_bagunan    = $request->mabj_binaan_keluasan_bagunan;
                $krt_binaan->binaan_tarikh_mula_bina    = $carbon_obj;
                $krt_binaan->binaan_pengguna_rt         = $request->mabj_binaan_pengguna_rt;
                $krt_binaan->binaan_pengguna_srs        = $request->mabj_binaan_pengguna_srs;
                $krt_binaan->binaan_pengguna_tabika     = $request->mabj_binaan_pengguna_tabika;
                $krt_binaan->binaan_pengguna_taska      = $request->mabj_binaan_pengguna_taska;
                $krt_binaan->binaan_isu                 = $request->mabj_binaan_isu;
                $krt_binaan->save();
                
            }
        }
    }

    function get_view_binaan_jambatan($id){
        $data = DB::table('krt__binaan')
                ->select('krt__binaan.id', 
                    'krt__binaan.krt_profileID AS krt_profileID',
                    'krt__binaan.binaan_jenis_premis_id AS binaan_jenis_premis_id',
                    'krt__binaan.binaan_alamat AS binaan_alamat',
                    'krt__binaan.status_tanah_id AS status_tanah_id',
                    'krt__binaan.binaan_kos AS binaan_kos',
                    'krt__binaan.binaan_keluasan_tanah AS binaan_keluasan_tanah',
                    'krt__binaan.binaan_keluasan_bagunan AS binaan_keluasan_bagunan',
                    DB::raw(" DATE_FORMAT(krt__binaan.binaan_tarikh_mula_bina,'%d/%m/%Y') AS binaan_tarikh_mula_bina"),
                    'krt__binaan.binaan_pengguna_rt AS binaan_pengguna_rt',
                    'krt__binaan.binaan_pengguna_srs AS binaan_pengguna_srs',
                    'krt__binaan.binaan_pengguna_tabika AS binaan_pengguna_tabika',
                    'krt__binaan.binaan_pengguna_taska AS binaan_pengguna_taska',
                    'krt__binaan.binaan_isu AS binaan_isu',
                    'ref__jenis_premis.jenis_premis_description')
                ->join('ref__jenis_premis','ref__jenis_premis.id','=','krt__binaan.binaan_jenis_premis_id')
                ->where('krt__binaan.id', '=', $id)
                ->first();
        return Response::json($data);
    }

    function delete_profile_krt_binaan($id){
        $data = DB::table('krt__binaan')->where('id', '=', $id)->delete();
    }

    function get_profile_krt_bagunan_tumpang(Request $request, $id){
        $data = DB::table('krt__bagunan_tumpang')
                ->select('krt__bagunan_tumpang.*', 'ref__jenis_premis.jenis_premis_description')
                ->join('ref__jenis_premis','ref__jenis_premis.id','=','krt__bagunan_tumpang.tumpang_jenis_premis_id')
                ->where('krt__bagunan_tumpang.krt_profileID', '=', $id)
                ->get();
        return Datatables::of($data)
                ->make(true);
    }

    function add_profile_krt_bagunan_tumpang(Request $request){
        $action = $request->add_bagunan_tumpang;
        
        $rules = array(
            'mabt_tumpang_jenis_premis_id'              => 'required',
            'mabt_tumpang_alamat'                       => 'required',
            'mabt_tumpang_status_tanah_id'              => 'required',
        );

        $messages = [
            'mabt_tumpang_jenis_premis_id.required'     => 'Ruangan Jenis Premis mesti dipilih',
            'mabt_tumpang_alamat.required'              => 'Ruangan Alamat mesti diisi',
            'mabt_tumpang_status_tanah_id.required'     => 'Ruangan Status Tanah mesti dipilih',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $krt_bagunan_tumpang = new KRT_Bagunan_Tumpang;
                $krt_bagunan_tumpang->krt_profileID               = $request->mabt_krt_profileID;
                $krt_bagunan_tumpang->tumpang_jenis_premis_id     = $request->mabt_tumpang_jenis_premis_id;
                $krt_bagunan_tumpang->tumpang_alamat              = $request->mabt_tumpang_alamat;
                $krt_bagunan_tumpang->tumpang_pengguna_rt         = $request->mabt_tumpang_pengguna_rt;
                $krt_bagunan_tumpang->tumpang_pengguna_srs        = $request->mabt_tumpang_pengguna_srs;
                $krt_bagunan_tumpang->tumpang_pengguna_tabika     = $request->mabt_tumpang_pengguna_tabika;
                $krt_bagunan_tumpang->tumpang_pengguna_taska      = $request->mabt_tumpang_pengguna_taska;
                $krt_bagunan_tumpang->tumpang_status_tanah_id     = $request->mabt_tumpang_status_tanah_id;
                $krt_bagunan_tumpang->save();
                
            }
        }
    }

    function delete_get_profile_bagunan_tumpang($id){
        $data = DB::table('krt__bagunan_tumpang')->where('id', '=', $id)->delete();
    }

    function get_view_bagunan_tumpang($id){
        $data = DB::table('krt__bagunan_tumpang')
                ->select('krt__bagunan_tumpang.*', 'ref__jenis_premis.jenis_premis_description')
                ->join('ref__jenis_premis','ref__jenis_premis.id','=','krt__bagunan_tumpang.tumpang_jenis_premis_id')
                ->where('krt__bagunan_tumpang.id', '=', $id)
                ->first();
        return Response::json($data);
    }

    function get_profile_krt_bagunan_sewa(Request $request, $id){
        $data = DB::table('krt__bagunan_sewa')
                ->select('krt__bagunan_sewa.*', 'ref__jenis_premis.jenis_premis_description')
                ->join('ref__jenis_premis','ref__jenis_premis.id','=','krt__bagunan_sewa.jenis_premis_id')
                ->where('krt__bagunan_sewa.krt_profileID', '=', $id)
                ->get();
        return Datatables::of($data)
                ->make(true);
    }

    function add_profile_krt_bagunan_sewa(Request $request){
        $action = $request->add_bagunan_sewa;
        
        $rules = array(
            'mabs_jenis_premis_id'              => 'required',
            'mabs_sewa_alamat'                  => 'required',
            'mabs_sewa_isu'                     => 'required',
            'mabs_sewa_bayaran'                 => 'required',
        );

        $messages = [
            'mabs_jenis_premis_id.required'     => 'Ruangan Jenis Premis mesti dipilih',
            'mabs_sewa_alamat.required'         => 'Ruangan Alamat mesti diisi',
            'mabs_sewa_isu.required'            => 'Ruangan Isu mesti diisi',
            'mabs_sewa_bayaran.required'        => 'Ruangan Bayaran mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $krt_bagunan_sewa = new KRT_Bagunan_Sewa;
                $krt_bagunan_sewa->krt_profileID               = $request->mabs_krt_profileID;
                $krt_bagunan_sewa->jenis_premis_id             = $request->mabs_jenis_premis_id;
                $krt_bagunan_sewa->sewa_alamat                 = $request->mabs_sewa_alamat;
                $krt_bagunan_sewa->sewa_pengguna_rt            = $request->mabs_sewa_pengguna_rt;
                $krt_bagunan_sewa->sewa_pengguna_srs           = $request->mabs_sewa_pengguna_srs;
                $krt_bagunan_sewa->sewa_pengguna_tabika        = $request->mabs_sewa_pengguna_tabika;
                $krt_bagunan_sewa->sewa_pengguna_taska         = $request->mabs_sewa_pengguna_taska;
                $krt_bagunan_sewa->sewa_isu                    = $request->mabs_sewa_isu;
                $krt_bagunan_sewa->sewa_bayaran                = $request->mabs_sewa_bayaran;
                $krt_bagunan_sewa->save();
                
            }
        }
    }

    function delete_get_profile_bagunan_sewa($id){
        $data = DB::table('krt__bagunan_sewa')->where('id', '=', $id)->delete();
    }

    function get_view_bagunan_sewa($id){
        $data = DB::table('krt__bagunan_sewa')
                ->select('krt__bagunan_sewa.*', 'ref__jenis_premis.jenis_premis_description')
                ->join('ref__jenis_premis','ref__jenis_premis.id','=','krt__bagunan_sewa.jenis_premis_id')
                ->where('krt__bagunan_sewa.id', '=', $id)
                ->first();
        return Response::json($data);
    }

    function get_profile_krt_senarai_kabin(Request $request, $id){
        $data = DB::table('krt__kabin')
                    ->select('krt__kabin.*', 'ref__jenis_kabin.jenis_kabin_description AS jenis_kabin')
                    ->join('ref__jenis_kabin','ref__jenis_kabin.id','=','krt__kabin.kabin_jenis')
                    ->where('krt__kabin.krt_profileID', '=', $id)
                    ->get();
        return Datatables::of($data)
                    ->make(true);
    }

    function add_profile_krt_kabin(Request $request){
        $action = $request->add_kabin;
        
        $rules = array(
            'maksa_kabin_jenis'                                 => 'required',
            'maksa_kabin_alamat'                                => 'required',
            'maksa_kabin_tarikh_bina'                           => 'required',
            'maksa_kabin_isu'                                   => 'required',
            'maksa_kabin_status_tanah_id'                       => 'required'
        );

        $messages = [
            'maksa_kabin_jenis.required'                        => 'Ruangan Jenis Kabin mesti dipilih',
            'maksa_kabin_alamat.required'                       => 'Ruangan Alamat mesti diisi',
            'maksa_kabin_tarikh_bina.required'                  => 'Ruangan Tarikh Mula Bina Bagunan mesti dipilih',
            'maksa_kabin_isu.required'                          => 'Ruangan Isu mesti dipilih',
            'maksa_kabin_status_tanah_id.required'              => 'Ruangan Status Tanah mesti dipilih',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $carbon_obj = Carbon::createFromFormat('d/m/Y', $request->maksa_kabin_tarikh_bina)->format('Y-m-d');
                $kabin = new KRT_Kabin;
                $kabin->krt_profileID                         = $request->maksa_krt_profileID;
                $kabin->kabin_jenis                           = $request->maksa_kabin_jenis;
                $kabin->kabin_sumbangan_lain                  = $request->maksa_kabin_sumbangan_lain;
                $kabin->kabin_alamat                          = $request->maksa_kabin_alamat;
                $kabin->kabin_status_tanah_id                 = $request->maksa_kabin_status_tanah_id;
                $kabin->kabin_tarikh_bina                     = $carbon_obj;
                $kabin->kabin_kos                             = $request->maksa_kabin_kos;
                $kabin->kabin_pengguna_rt                     = $request->maksa_kabin_pengguna_rt;
                $kabin->kabin_pengguna_srs                    = $request->maksa_kabin_pengguna_srs;
                $kabin->kabin_pengguna_tabika                 = $request->maksa_kabin_pengguna_tabika;
                $kabin->kabin_pengguna_taska                  = $request->maksa_kabin_pengguna_taska;
                $kabin->kabin_isu                             = $request->maksa_kabin_isu;
                $kabin->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_profile_krt_kabin($id){
        $data = DB::table('krt__kabin')->where('id', '=', $id)->delete();
    }

    function get_view_kabin_table($id){
        $data = DB::table('krt__kabin')
                ->select('krt__kabin.*', 'ref__jenis_kabin.jenis_kabin_description AS jenis_kabin')
                ->join('ref__jenis_kabin','ref__jenis_kabin.id','=','krt__kabin.kabin_jenis')
                ->where('krt__kabin.id', '=', $id)
                ->first();
        return Response::json($data);
    }

    function get_profile_krt_cadangan_pembinaan(Request $request, $id){
        $data = DB::table('krt__pembinaan_prt1')
                ->select('krt__pembinaan_prt1.*')
                ->where('krt__pembinaan_prt1.krt_profileID', '=', $id)
                ->get();
        return Datatables::of($data)
                ->make(true);
    }

    function delete_cadangan_pembinaan_prt($id){
        $data = DB::table('krt__pembinaan_prt1')->where('id', '=', $id)->delete();
    }

    function add_profile_krt_cadangan_pembinaan(Request $request){
        $action = $request->add_cadangan_pembinaan_prt;
        $app_id = $request->macpp_krt_profileID;
        
        $rules = array(
            'macpp_prt_jenis_premis'                             => 'required',
            'macpp_prt_status_tanah_terkini'                     => 'required',
            'macpp_prt_keluasan'                                 => 'required',
            'macpp_prt_status_kelulusan_tanah_kabin'             => 'required',
            'macpp_prt_cadangan_tahun'                           => 'required'
        );

        $messages = [
            'macpp_prt_jenis_premis.required'                    => 'Ruangan Jenis Premis mesti dipilih',
            'macpp_prt_status_tanah_terkini.required'            => 'Ruangan Status Tanah Terkini mesti dipilih',
            'macpp_prt_keluasan.required'                        => 'Ruangan Keluasan mesti diisi',
            'macpp_prt_status_kelulusan_tanah_kabin.required'    => 'Ruangan Status Kelulusan Tanah Untuk Pembinaan Kabin mesti dipilih',
            'macpp_prt_cadangan_tahun.required'                  => 'Ruangan Cadangan Tahun Pembinaan mesti dipilih',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $jawatankuasa_penaja = new KRT_CadanganPembinaanPRT;
                $jawatankuasa_penaja->krt_profileID                         = $request->macpp_krt_profileID;
                $jawatankuasa_penaja->prt_jenis_premis                      = $request->macpp_prt_jenis_premis;
                $jawatankuasa_penaja->prt_status_tanah_terkini              = $request->macpp_prt_status_tanah_terkini;
                $jawatankuasa_penaja->prt_keluasan                          = $request->macpp_prt_keluasan;
                $jawatankuasa_penaja->prt_status_kelulusan_tanah_kabin      = $request->macpp_prt_status_kelulusan_tanah_kabin;
                $jawatankuasa_penaja->prt_cadangan_tahun                    = $request->macpp_prt_cadangan_tahun;
                $jawatankuasa_penaja->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function view_cadangan_pembinaan_table($id){
        $data = DB::table('krt__pembinaan_prt1')
                ->select('krt__pembinaan_prt1.*')
                ->where('krt__pembinaan_prt1.id', '=', $id)
                ->first();
        return Response::json($data);
    }

    function profile_krt_7(Request $request){
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
            $profile_krt    = DB::table('krt__profile')
                                ->select('krt__profile.id',
                                        'krt__profile.krt_nama',
                                        'krt__profile.krt_alamat',
                                        'krt__profile.state_id',
                                        'krt__profile.daerah_id',
                                        'krt__profile.parlimen_id',
                                        'krt__profile.dun_id',
                                        'krt__profile.pbt_id',
                                        'krt__profile.krt_kawasan',
                                        'krt__profile.krt_keluasan',
                                        'krt__profile.krt_ipd',
                                        'krt__profile.krt_balai',
                                        'krt__profile.srs_nama',
                                        'krt__profile.krt_tabika',
                                        'krt__profile.krt_taska',
                                        'krt__profile.krt_status_bagunan_id',
                                        'krt__profile.krt_status',
                                        DB::raw(" DATE_FORMAT(rt__applications.created_at,'%d/%m/%Y') AS created_at"),
                                        'rt__applications.user_fullname',
                                        'rt__applications.no_ic',
                                        'rt__applications.user_address',
                                        'krt__profile.krt_status AS status',
                                        'ref__status_krt.status_description AS status_description',
                                        'krt__profile.disemak_note AS disemak_note',
                                        'krt__profile.disahkan_note AS disahkan_note')
                                ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                                ->leftJoin('ref__status_krt','ref__status_krt.id','=','krt__profile.krt_status')
                                ->where('krt__profile.id', '=', Auth::user()->krt_id)  
                                ->limit(1)
                                ->first();
            return view('rt-sm2.profile-krt-7', compact('roles_menu','profile_krt'));
        }
    }

    function add_profile_krt_peta_kawasan(Request $request){
        $action = $request->add_profile_krt_peta_kawasan;
        $app_id = $request->pk11_krt_profile_id;
        $fileName = $request->pk11_file_peta->getClientOriginalName();
       

        $rules = array(
            'pk11_file_title'               => 'required',
            'pk11_file_catatan'             => 'required',
            'pk11_file_peta'                => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:5000'
        );

        $messages = [
            'pk11_file_title.required'     => 'Ruangan Tajuk Fail Mesti Diisi',
            'pk11_file_catatan.required'   => 'Ruangan Catatan Fail Mesti Diisi',
            'pk11_file_peta.required'      => 'Ruangan Fail Mesti Dipilih',
            'pk11_file_peta.mimes'         => 'Fail Mesti Dipilih Dalam Format jpeg,png,jpg,gif,svg,pdf',
            'pk11_file_peta.max'           => 'Fail mesti dalam sive 5000KB',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            $request->pk11_file_peta->storeAs('public/peta_kawasan',$fileName);
            if ($action == 'add') {
                $peta_kawasan = new Krt_Profile_Upload_Peta;
                $peta_kawasan->krt_profile_id   = $app_id;
                $peta_kawasan->file_title       = $request->pk11_file_title;
                $peta_kawasan->file_catatan     = $request->pk11_file_catatan;
                $peta_kawasan->file_peta        = $fileName;
                $peta_kawasan->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function get_profile_krt_peta_kawasan_table(Request $request, $id){
        $data = DB::table('krt__profile_upload_peta')
                ->select('krt__profile_upload_peta.*')
                ->where('krt__profile_upload_peta.krt_profile_id', '=', $id)
                ->get();
        return Datatables::of($data)
                ->make(true);
    }

    function delete_profile_krt_peta_kawasan($id){
        $data = DB::table('krt__profile_upload_peta')->where('id', '=', $id)->delete();
    }

    function get_data_peta_kawasan($id){
        $data = DB::table('krt__profile_upload_peta')
                ->select('krt__profile_upload_peta.id', 
                    'krt__profile_upload_peta.file_peta AS file_peta' )
                ->where('krt__profile_upload_peta.id', '=', $id)
                ->first();
        return Response::json($data);
    }

    function profile_krt_8(Request $request){
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
            $ref_jantina    = RefJantina::where('status', '=', true)->get();
            $ref_kaum       = RefKaum::where('status', '=', true)->get();
            $profile_krt    = DB::table('krt__profile')
                            ->select('krt__profile.id',
                                    'krt__profile.krt_nama',
                                    'krt__profile.krt_alamat',
                                    'krt__profile.state_id',
                                    'krt__profile.daerah_id',
                                    'krt__profile.parlimen_id',
                                    'krt__profile.dun_id',
                                    'krt__profile.pbt_id',
                                    'krt__profile.krt_kawasan',
                                    'krt__profile.krt_keluasan',
                                    'krt__profile.krt_ipd',
                                    'krt__profile.krt_balai',
                                    'krt__profile.srs_nama',
                                    'krt__profile.krt_tabika',
                                    'krt__profile.krt_taska',
                                    'krt__profile.krt_status_bagunan_id',
                                    'krt__profile.krt_status',
                                    'krt__profile.krt_bank_nama',
                                    'krt__profile.krt_bank_no_acc',
                                    'krt__profile.krt_bank_no_evendor',
                                    'krt__profile.krt_bank_baki_status_edit',
                                    'krt__profile.krt_bank_baki_bank',
                                    'krt__profile.krt_bank_baki_cash',
                                    DB::raw(" DATE_FORMAT(rt__applications.created_at,'%d/%m/%Y') AS created_at"),
                                    'rt__applications.user_fullname',
                                    'rt__applications.no_ic',
                                    'rt__applications.user_address',
                                    'krt__profile.krt_status AS status',
                                    'ref__status_krt.status_description AS status_description',
                                    'krt__profile.disemak_note AS disemak_note',
                                    'krt__profile.disahkan_note AS disahkan_note')
                            ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                            ->leftJoin('ref__status_krt','ref__status_krt.id','=','krt__profile.krt_status')
                            ->where('krt__profile.id', '=', Auth::user()->krt_id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm2.profile-krt-8', compact('roles_menu','ref_kaum', 'ref_jantina', 'profile_krt'));
        }
    }

    function get_profile_krt_jawatankuasa_penaja_table(Request $request, $id){
        $data = DB::table('krt__senarai_jawatankuasa_penaja')
                ->select('krt__senarai_jawatankuasa_penaja.*')
                ->where('krt__senarai_jawatankuasa_penaja.krt_profileID', '=', $id)
                ->get();
            return Datatables::of($data)
                ->make(true);
    }

    function add_profile_krt_jawatankuasa_penaja(Request $request){
        $action = $request->add_jawatankuasa_penaja;
        $app_id = $request->jpf_krt_profileID;
        
        $rules = array(
            'jpf_penaja_nama'                         => 'required',
            'jpf_penaja_ic'                           => 'required',
            'jpf_penaja_birth'                        => 'required',
            'jpf_ref_jantinaID'                       => 'required',
            'jpf_ref_kaumID'                          => 'required',
            'jpf_penaja_pekerjaan'                    => 'required',
            'jpf_penaja_alamat_rumah'                 => 'required',
            'jpf_penaja_no_fone'                      => 'required',
            'jpf_penaja_alamat_pejabat'               => 'required',
        );

        $messages = [
            'jpf_penaja_nama.required'                 => 'Ruangan Nama mesti diisi',
            'jpf_penaja_ic.required'                   => 'Ruangan No Kad Pengenalan mesti diisi',
            'jpf_penaja_birth.required'                => 'Ruangan Tarikh Lahir mesti dipilih',
            'jpf_ref_jantinaID.required'               => 'Ruangan Jantina mesti dipilih',
            'jpf_ref_kaumID.required'                  => 'Ruangan Kaum mesti dipilih',
            'jpf_penaja_pekerjaan.required'            => 'Ruangan Pekerjaan mesti diisi',
            'jpf_penaja_alamat_rumah.required'         => 'Ruangan Alamat Rumah mesti diisi',
            'jpf_penaja_no_fone.required'              => 'Ruangan No Telefon Rumah mesti diisi',
            'jpf_penaja_alamat_pejabat.required'       => 'Ruangan Alamat Pejabat Rumah mesti diisi',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $carbon_obj = Carbon::createFromFormat('d/m/Y', $request->jpf_penaja_birth)->format('Y-m-d');
                $jawatankuasa_penaja = new KRT_JawatankuasaPenaja;
                $jawatankuasa_penaja->krt_profileID             = $app_id;
                $jawatankuasa_penaja->penaja_nama               = $request->jpf_penaja_nama;
                $jawatankuasa_penaja->penaja_ic                 = $request->jpf_penaja_ic;
                $jawatankuasa_penaja->penaja_birth              = $carbon_obj;
                $jawatankuasa_penaja->ref_jantinaID             = $request->jpf_ref_jantinaID;
                $jawatankuasa_penaja->ref_kaumID                = $request->jpf_ref_kaumID;
                $jawatankuasa_penaja->penaja_pekerjaan          = $request->jpf_penaja_pekerjaan;
                $jawatankuasa_penaja->penaja_alamat_rumah       = $request->jpf_penaja_alamat_rumah;
                $jawatankuasa_penaja->penaja_no_fone            = $request->jpf_penaja_no_fone;
                $jawatankuasa_penaja->penaja_alamat_pejabat     = $request->jpf_penaja_alamat_pejabat;
                $jawatankuasa_penaja->penaja_no_office          = $request->jpf_penaja_no_office;
                $jawatankuasa_penaja->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_profile_krt_jawatankuasa_penaja($id){
        $data = DB::table('krt__senarai_jawatankuasa_penaja')->where('id', '=', $id)->delete();
    }

    function update_profile_krt_8(Request $request){
        $action = $request->update_profile_krt_8;
        $app_id = $request->pk13_krt_profile_id;
        $status_edit = $request->pk13_krt_bank_baki_status_edit;
        $rules_main = array(
            'pk12_krt_bank_nama'                    => 'required',
            'pk12_krt_bank_no_acc'                  => 'required'
        );

        $messages = [
            'pk12_krt_bank_nama.required'           => 'Ruangan Nama Bank mesti diis',
            'pk12_krt_bank_no_acc.required'         => 'Ruangan No Akaun Bank mesti diis',
        ];
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $krt_profile  = KRT_Profile::where($where)->first();
                $krt_profile->krt_bank_nama         = $request->pk12_krt_bank_nama;
                $krt_profile->krt_bank_no_acc       = $request->pk12_krt_bank_no_acc;
                $krt_profile->krt_bank_baki_status_edit   = 1;
                $krt_profile->save();
                
            }
        }
    }

    function profile_krt_ppd(Request $request){
        if($request->ajax()){
            $type = $request->type;
            $data = DB::table('krt__profile')
                        ->select('krt__profile.id',
                            'krt__profile.state_id',
                            'krt__profile.daerah_id',
                            'krt__profile.krt_nama',
                            'krt__profile.krt_alamat',
                            DB::raw(" DATE_FORMAT(krt__profile.created_at,'%d/%m/%Y') AS created_at"),
                            DB::raw(" DATE_FORMAT(krt__profile.diluluskan_date,'%d/%m/%Y') AS diluluskan_date"),
                            'ref__status_krt.status_description')
                        ->join('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                        ->join('ref__status_krt','ref__status_krt.id','=','krt__profile.krt_status')
                        ->where('krt__profile.krt_status', '=', 1) 
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
            $krt            = KRT_Profile::where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)
                            ->where('krt__profile.krt_status', '=', 1)
                            ->orderBy('krt_nama', 'ASC')
                            ->get();
            return view('rt-sm2.profile-krt-ppd', compact('roles_menu','krt'));
        }
    }

    function profile_krt_ppd_1(Request $request, $id){
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
            $profile_krt    = DB::table('krt__profile')
                                ->select('krt__profile.id',
                                'krt__profile.krt_nama AS krt_nama',
                                DB::raw(" DATE_FORMAT(krt__profile.created_at,'%d/%m/%Y') AS created_at"),
                                'users__profile.user_fullname AS dihantar_by',
                                DB::raw(" DATE_FORMAT(krt__profile.dihantar_date,'%d/%m/%Y') AS dihantar_date"))
                                ->leftJoin('users__profile','users__profile.user_id','=','krt__profile.dihantar_by')
                                ->where('krt__profile.id', '=', $id)  
                                ->limit(1)
                                ->first();
            return view('rt-sm2.profile-krt-ppd-1', compact('roles_menu','profile_krt'));
        }
    }

    function profile_krt_ppd_2(Request $request, $id){
        if($request->ajax()){ 
            //return view('rt-sm2.profile-krt-ppd-2', compact('roles_menu','negeri', 'daerah', 'parlimen', 'dun', 'pbt', 'profile_krt','act_kemaskini'));
        } else 
		{
            $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
                                'users__menu.highlight AS highlight_menu',
                                'users__menu.users_menu_page_icon AS icon_menu')
                            ->leftJoin('users__menu','users__menu.id','=','roles__menu.users_menu_id')
                            ->leftJoin('users__roles','users__roles.role_id','=','roles__menu.role_id')
                            ->where('users__roles.user_id', '=', Auth::user()->user_id)
                            ->where('roles__menu.status', '=', true)
                            ->orderBy('first_menu', 'asc')
                            ->orderBy('id', 'asc')
                            ->get();
            $negeri         = RefStates::where('status', '=', true)->get();
            $daerah         = RefDaerah::where('status', '=', true)->get();
            $parlimen       = RefParlimen::where('status', '=', true)->get();
            $dun            = RefDun::where('status', '=', true)->get();
            $pbt            = RefPBT::where('status', '=', true)->get();
            $profile_krt    = DB::table('krt__profile')
                                ->select('krt__profile.id',
                                        'krt__profile.krt_nama',
                                        'krt__profile.krt_alamat',
                                        'krt__profile.state_id',
                                        'krt__profile.daerah_id',
                                        'krt__profile.parlimen_id',
                                        'krt__profile.dun_id',
                                        'krt__profile.pbt_id',
                                        'krt__profile.krt_kawasan',
                                        'krt__profile.krt_keluasan',
                                        'krt__profile.krt_ipd',
                                        'krt__profile.krt_balai',
                                        'krt__profile.srs_nama',
                                        'krt__profile.krt_tabika',
                                        'krt__profile.krt_taska',
                                        'krt__profile.krt_status_bagunan_id',
                                        'krt__profile.krt_status',
                                        DB::raw(" DATE_FORMAT(rt__applications.created_at,'%d/%m/%Y') AS created_at"),
                                        'rt__applications.user_fullname',
                                        'rt__applications.no_ic',
                                        'rt__applications.user_address')
                                ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                                ->where('krt__profile.id', '=', $id)  
                                ->limit(1)
                                ->first();
			if($request->act_kemaskini == "kemaskini")
			{
				$act_kemaskini         = "done";
			}else
			{
				$act_kemaskini         = "done2";
			}
            return view('rt-sm2.profile-krt-ppd-2', compact('roles_menu','negeri', 'daerah', 'parlimen', 'dun', 'pbt', 'profile_krt','act_kemaskini'));
        }
    }
	
	function profile_krt_ppd_2_update(Request $request)
	{
		$act_id = $request->act_id;
        $kpk_krt_nama = $request->kpk_krt_nama;
        $kpk_krt_alamat = $request->kpk_krt_alamat;
        $rules_main = array(
            'kpk_krt_nama'                    => 'required',
            'kpk_krt_alamat'                  => 'required'
        );

        $messages = [
            'kpk_krt_nama.required'           => 'Ruangan Nama KRT mesti diisi',
            'kpk_krt_alamat.required'         => 'Ruangan Alamat KRT mesti diisi',
        ];
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
                $where = array('id' => $act_id);
                $krt_profile  = KRT_Profile::where($where)->first();
                $krt_profile->krt_nama         = $request->kpk_krt_nama;
                $krt_profile->krt_alamat       = $request->kpk_krt_alamat;
                $krt_profile->save();
        }
	}
	
    function profile_krt_ppd_3(Request $request, $id){
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
            $negeri         = RefStates::where('status', '=', true)->get();
            $daerah         = RefDaerah::where('status', '=', true)->get();
            $parlimen       = RefParlimen::where('status', '=', true)->get();
            $dun            = RefDun::where('status', '=', true)->get();
            $pbt            = RefPBT::where('status', '=', true)->get();
            $profile_krt    = DB::table('krt__profile')
                            ->select('krt__profile.id',
                                    'krt__profile.krt_nama',
                                    'krt__profile.krt_alamat',
                                    'krt__profile.state_id',
                                    'krt__profile.daerah_id',
                                    'krt__profile.parlimen_id',
                                    'krt__profile.dun_id',
                                    'krt__profile.pbt_id',
                                    'krt__profile.krt_kawasan',
                                    'krt__profile.krt_keluasan',
                                    'krt__profile.krt_ipd',
                                    'krt__profile.krt_balai',
                                    'krt__profile.srs_nama',
                                    'krt__profile.krt_tabika',
                                    'krt__profile.krt_taska',
                                    'krt__profile.krt_status_bagunan_id',
                                    'krt__profile.krt_status',
                                    DB::raw(" DATE_FORMAT(rt__applications.created_at,'%d/%m/%Y') AS created_at"),
                                    'rt__applications.user_fullname',
                                    'rt__applications.no_ic',
                                    'rt__applications.user_address')
                            ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                            ->where('krt__profile.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm2.profile-krt-ppd-3', compact('roles_menu','negeri', 'daerah', 'parlimen', 'dun', 'pbt', 'profile_krt'));
        }
    }

    function profile_krt_ppd_4(Request $request, $id){
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
            $profile_krt    = DB::table('krt__profile')
                            ->select('krt__profile.id',
                                'krt__profile.krt_nama',
                                'krt__profile.krt_alamat',
                                'krt__profile.state_id',
                                'krt__profile.daerah_id',
                                'krt__profile.parlimen_id',
                                'krt__profile.dun_id',
                                'krt__profile.pbt_id',
                                'krt__profile.krt_kawasan',
                                'krt__profile.krt_keluasan',
                                'krt__profile.krt_ipd',
                                'krt__profile.krt_balai',
                                'krt__profile.srs_nama',
                                'krt__profile.krt_tabika',
                                'krt__profile.krt_taska',
                                'krt__profile.krt_status_bagunan_id',
                                'krt__profile.krt_status',
                                DB::raw(" DATE_FORMAT(rt__applications.created_at,'%d/%m/%Y') AS created_at"),
                                'rt__applications.user_fullname',
                                'rt__applications.no_ic',
                                'rt__applications.user_address')
                        ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                            ->where('krt__profile.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm2.profile-krt-ppd-4', compact('roles_menu','profile_krt'));
        }
    }

    function profile_krt_ppd_5(Request $request, $id){
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
            $ref_status_bagunan     = RefStatusBagunan::where('status', '=', true)->get();
            $jenis_premis_binaan    = RefJenisPremis::where('status', '=', true)->get()
                                    ->whereIn('id', [1,2,3]);
            $jenis_premis_tumpang   = RefJenisPremis::where('status', '=', true)->get()
                                    ->whereIn('id', [4,5,6,7]);
            $kabin                  = RefJenisKabin::where('status', '=', true)->get();
            $profile_krt            = DB::table('krt__profile')
                                    ->select('krt__profile.id',
                                            'krt__profile.krt_nama',
                                            'krt__profile.krt_alamat',
                                            'krt__profile.state_id',
                                            'krt__profile.daerah_id',
                                            'krt__profile.parlimen_id',
                                            'krt__profile.dun_id',
                                            'krt__profile.pbt_id',
                                            'krt__profile.krt_kawasan',
                                            'krt__profile.krt_keluasan',
                                            'krt__profile.krt_ipd',
                                            'krt__profile.krt_balai',
                                            'krt__profile.srs_nama',
                                            'krt__profile.krt_tabika',
                                            'krt__profile.krt_taska',
                                            'krt__profile.krt_status_bagunan_id',
                                            'krt__profile.krt_status',
                                            DB::raw(" DATE_FORMAT(rt__applications.created_at,'%d/%m/%Y') AS created_at"),
                                            'rt__applications.user_fullname',
                                            'rt__applications.no_ic',
                                            'rt__applications.user_address',
                                            'krt__profile.krt_status AS status',
                                            'ref__status_krt.status_description AS status_description',
                                            'krt__profile.disemak_note AS disemak_note',
                                            'krt__profile.disahkan_note AS disahkan_note')
                                    ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                                    ->leftJoin('ref__status_krt','ref__status_krt.id','=','krt__profile.krt_status')
                                    ->where('krt__profile.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm2.profile-krt-ppd-5', compact('roles_menu','ref_status_bagunan', 'jenis_premis_binaan', 'jenis_premis_tumpang' , 'kabin' ,'profile_krt'));
        }
    }

    function profile_krt_ppd_6(Request $request, $id){
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
            $ref_jantina    = RefJantina::where('status', '=', true)->get();
            $ref_kaum       = RefKaum::where('status', '=', true)->get();
            $profile_krt    = DB::table('krt__profile')
                            ->select('krt__profile.id',
                                'krt__profile.krt_nama',
                                'krt__profile.krt_alamat',
                                'krt__profile.state_id',
                                'krt__profile.daerah_id',
                                'krt__profile.parlimen_id',
                                'krt__profile.dun_id',
                                'krt__profile.pbt_id',
                                'krt__profile.krt_kawasan',
                                'krt__profile.krt_keluasan',
                                'krt__profile.krt_ipd',
                                'krt__profile.krt_balai',
                                'krt__profile.srs_nama',
                                'krt__profile.krt_tabika',
                                'krt__profile.krt_taska',
                                'krt__profile.krt_status_bagunan_id',
                                'krt__profile.krt_status',
                                DB::raw(" DATE_FORMAT(rt__applications.created_at,'%d/%m/%Y') AS created_at"),
                                'rt__applications.user_fullname',
                                'rt__applications.no_ic',
                                'rt__applications.user_address')
                            ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                            ->where('krt__profile.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm2.profile-krt-ppd-6', compact('roles_menu','ref_jantina','ref_kaum','profile_krt'));
        }
    }

    function profile_krt_ppn(Request $request){
        if($request->ajax()){
            $type   = $request->type;
            if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = KRT_Profile::where($where)
                        ->where('krt__profile.krt_status', '=',  true) 
                        ->orderBy('krt_nama', 'ASC')
                        ->get();
                return Response::json($data);
            }
            $data   = DB::table('krt__profile')
                        ->select('krt__profile.id',
                            'krt__profile.state_id',
                            'krt__profile.daerah_id',
                            'krt__profile.krt_nama',
                            'krt__profile.krt_alamat',
                            DB::raw(" DATE_FORMAT(krt__profile.created_at,'%d/%m/%Y') AS created_at"),
                            DB::raw(" DATE_FORMAT(krt__profile.diluluskan_date,'%d/%m/%Y') AS diluluskan_date"),
                            'ref__status_krt.status_description')
                        ->join('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                        ->join('ref__status_krt','ref__status_krt.id','=','krt__profile.krt_status')
                        ->where('krt__profile.krt_status', '=', 1) 
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
            $krt            = KRT_Profile::where('krt__profile.state_id', '=', Auth::user()->state_id)
                            ->where('krt__profile.krt_status', '=', 1)
                            ->orderBy('krt_nama', 'ASC')
                            ->get();
            return view('rt-sm2.profile-krt-ppn', compact('roles_menu','daerah','krt'));
        }
    }

    function profile_krt_ppn_1(Request $request, $id){
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
            $profile_krt    = DB::table('krt__profile')
                            ->select('krt__profile.id',
                                'krt__profile.krt_nama AS krt_nama',
                                DB::raw(" DATE_FORMAT(krt__profile.created_at,'%d/%m/%Y') AS created_at"),
                                'users__profile.user_fullname AS dihantar_by',
                                DB::raw(" DATE_FORMAT(krt__profile.dihantar_date,'%d/%m/%Y') AS dihantar_date"))
                            ->leftJoin('users__profile','users__profile.user_id','=','krt__profile.dihantar_by')
                            ->where('krt__profile.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm2.profile-krt-ppn-1', compact('roles_menu','profile_krt'));
        }
    }

    function profile_krt_ppn_2(Request $request, $id){
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
            $negeri         = RefStates::where('status', '=', true)->get();
            $daerah         = RefDaerah::where('status', '=', true)->get();
            $parlimen       = RefParlimen::where('status', '=', true)->get();
            $dun            = RefDun::where('status', '=', true)->get();
            $pbt            = RefPBT::where('status', '=', true)->get();
            $profile_krt    = DB::table('krt__profile')
                            ->select('krt__profile.id',
                                'krt__profile.krt_nama',
                                'krt__profile.krt_alamat',
                                'krt__profile.state_id',
                                'krt__profile.daerah_id',
                                'krt__profile.parlimen_id',
                                'krt__profile.dun_id',
                                'krt__profile.pbt_id',
                                'krt__profile.krt_kawasan',
                                'krt__profile.krt_keluasan',
                                'krt__profile.krt_ipd',
                                'krt__profile.krt_balai',
                                'krt__profile.srs_nama',
                                'krt__profile.krt_tabika',
                                'krt__profile.krt_taska',
                                'krt__profile.krt_status_bagunan_id',
                                'krt__profile.krt_status',
                                DB::raw(" DATE_FORMAT(rt__applications.created_at,'%d/%m/%Y') AS created_at"),
                                'rt__applications.user_fullname',
                                'rt__applications.no_ic',
                                'rt__applications.user_address')
                            ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                            ->where('krt__profile.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm2.profile-krt-ppn-2', compact('roles_menu','negeri', 'daerah', 'parlimen', 'dun', 'pbt', 'profile_krt'));
        }
    }

    function profile_krt_ppn_3(Request $request, $id){
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
            $negeri         = RefStates::where('status', '=', true)->get();
            $daerah         = RefDaerah::where('status', '=', true)->get();
            $parlimen       = RefParlimen::where('status', '=', true)->get();
            $dun            = RefDun::where('status', '=', true)->get();
            $pbt            = RefPBT::where('status', '=', true)->get();
            $profile_krt    = DB::table('krt__profile')
                            ->select('krt__profile.id',
                                'krt__profile.krt_nama',
                                'krt__profile.krt_alamat',
                                'krt__profile.state_id',
                                'krt__profile.daerah_id',
                                'krt__profile.parlimen_id',
                                'krt__profile.dun_id',
                                'krt__profile.pbt_id',
                                'krt__profile.krt_kawasan',
                                'krt__profile.krt_keluasan',
                                'krt__profile.krt_ipd',
                                'krt__profile.krt_balai',
                                'krt__profile.srs_nama',
                                'krt__profile.krt_tabika',
                                'krt__profile.krt_taska',
                                'krt__profile.krt_status_bagunan_id',
                                'krt__profile.krt_status',
                                DB::raw(" DATE_FORMAT(rt__applications.created_at,'%d/%m/%Y') AS created_at"),
                                'rt__applications.user_fullname',
                                'rt__applications.no_ic',
                                'rt__applications.user_address')
                            ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                            ->where('krt__profile.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm2.profile-krt-ppn-3', compact('roles_menu','negeri', 'daerah', 'parlimen', 'dun', 'pbt', 'profile_krt'));
        }
    }

    function profile_krt_ppn_4(Request $request, $id){
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
            $profile_krt    = DB::table('krt__profile')
                            ->select('krt__profile.id',
                                    'krt__profile.krt_nama',
                                    'krt__profile.krt_alamat',
                                    'krt__profile.state_id',
                                    'krt__profile.daerah_id',
                                    'krt__profile.parlimen_id',
                                    'krt__profile.dun_id',
                                    'krt__profile.pbt_id',
                                    'krt__profile.krt_kawasan',
                                    'krt__profile.krt_keluasan',
                                    'krt__profile.krt_ipd',
                                    'krt__profile.krt_balai',
                                    'krt__profile.srs_nama',
                                    'krt__profile.krt_tabika',
                                    'krt__profile.krt_taska',
                                    'krt__profile.krt_status_bagunan_id',
                                    'krt__profile.krt_status',
                                    DB::raw(" DATE_FORMAT(rt__applications.created_at,'%d/%m/%Y') AS created_at"),
                                    'rt__applications.user_fullname',
                                    'rt__applications.no_ic',
                                    'rt__applications.user_address')
                            ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                            ->where('krt__profile.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm2.profile-krt-ppn-4', compact('roles_menu','profile_krt'));
        }
    }

    function profile_krt_ppn_5(Request $request, $id){
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
            $ref_status_bagunan     = RefStatusBagunan::where('status', '=', true)->get();
            $jenis_premis_binaan    = RefJenisPremis::where('status', '=', true)->get()
                                    ->whereIn('id', [1,2,3]);
            $jenis_premis_tumpang   = RefJenisPremis::where('status', '=', true)->get()
                                    ->whereIn('id', [4,5,6,7]);
            $kabin                  = RefJenisKabin::where('status', '=', true)->get();
            $profile_krt            = DB::table('krt__profile')
                                    ->select('krt__profile.id',
                                            'krt__profile.krt_nama',
                                            'krt__profile.krt_alamat',
                                            'krt__profile.state_id',
                                            'krt__profile.daerah_id',
                                            'krt__profile.parlimen_id',
                                            'krt__profile.dun_id',
                                            'krt__profile.pbt_id',
                                            'krt__profile.krt_kawasan',
                                            'krt__profile.krt_keluasan',
                                            'krt__profile.krt_ipd',
                                            'krt__profile.krt_balai',
                                            'krt__profile.srs_nama',
                                            'krt__profile.krt_tabika',
                                            'krt__profile.krt_taska',
                                            'krt__profile.krt_status_bagunan_id',
                                            'krt__profile.krt_status',
                                            DB::raw(" DATE_FORMAT(rt__applications.created_at,'%d/%m/%Y') AS created_at"),
                                            'rt__applications.user_fullname',
                                            'rt__applications.no_ic',
                                            'rt__applications.user_address',
                                            'krt__profile.krt_status AS status',
                                            'ref__status_krt.status_description AS status_description',
                                            'krt__profile.disemak_note AS disemak_note',
                                            'krt__profile.disahkan_note AS disahkan_note')
                                    ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                                    ->leftJoin('ref__status_krt','ref__status_krt.id','=','krt__profile.krt_status')
                                    ->where('krt__profile.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm2.profile-krt-ppn-5', compact('roles_menu','ref_status_bagunan', 'jenis_premis_binaan', 'jenis_premis_tumpang' , 'kabin' ,'profile_krt'));
        }
    }

    function profile_krt_ppn_6(Request $request, $id){
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
            $ref_jantina    = RefJantina::where('status', '=', true)->get();
            $ref_kaum       = RefKaum::where('status', '=', true)->get();
            $profile_krt    = DB::table('krt__profile')
                            ->select('krt__profile.id',
                                'krt__profile.krt_nama',
                                'krt__profile.krt_alamat',
                                'krt__profile.state_id',
                                'krt__profile.daerah_id',
                                'krt__profile.parlimen_id',
                                'krt__profile.dun_id',
                                'krt__profile.pbt_id',
                                'krt__profile.krt_kawasan',
                                'krt__profile.krt_keluasan',
                                'krt__profile.krt_ipd',
                                'krt__profile.krt_balai',
                                'krt__profile.srs_nama',
                                'krt__profile.krt_tabika',
                                'krt__profile.krt_taska',
                                'krt__profile.krt_status_bagunan_id',
                                'krt__profile.krt_status',
                                DB::raw(" DATE_FORMAT(rt__applications.created_at,'%d/%m/%Y') AS created_at"),
                                'rt__applications.user_fullname',
                                'rt__applications.no_ic',
                                'rt__applications.user_address')
                            ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                            ->where('krt__profile.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm2.profile-krt-ppn-6', compact('roles_menu','ref_jantina','ref_kaum','profile_krt'));
        }
    }

    function profile_krt_hqrt(Request $request){
        if($request->ajax()){
            $type   = $request->type;
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
                        ->orderBy('krt_nama', 'ASC')
                        ->get();
                return Response::json($data);
            }
            $data   = DB::table('krt__profile')
                        ->select('krt__profile.id',
                            'krt__profile.state_id',
                            'krt__profile.daerah_id',
                            'krt__profile.krt_nama',
                            'krt__profile.krt_alamat',
                            DB::raw(" DATE_FORMAT(krt__profile.created_at,'%d/%m/%Y') AS created_at"),
                            DB::raw(" DATE_FORMAT(krt__profile.diluluskan_date,'%d/%m/%Y') AS diluluskan_date"),
                            'ref__status_krt.status_description')
                        ->join('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                        ->join('ref__status_krt','ref__status_krt.id','=','krt__profile.krt_status')
                        ->where('krt__profile.krt_status', '=', 1) 
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
            $krt            = KRT_Profile::where('krt_status', '=',  true)
                            ->orderBy('krt_nama', 'ASC')
                            ->get();
            return view('rt-sm2.profile-krt-hqrt', compact('roles_menu','state','daerah','krt'));
        }
    }

    function profile_krt_hqrt_1(Request $request, $id){
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
            $profile_krt    = DB::table('krt__profile')
                            ->select('krt__profile.id',
                                'krt__profile.krt_nama AS krt_nama',
                                DB::raw(" DATE_FORMAT(krt__profile.created_at,'%d/%m/%Y') AS created_at"),
                                'users__profile.user_fullname AS dihantar_by',
                                DB::raw(" DATE_FORMAT(krt__profile.dihantar_date,'%d/%m/%Y') AS dihantar_date"))
                            ->leftJoin('users__profile','users__profile.user_id','=','krt__profile.dihantar_by')
                            ->where('krt__profile.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm2.profile-krt-hqrt-1', compact('roles_menu','profile_krt'));
        }
    }

    function profile_krt_hqrt_2(Request $request, $id){
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
            $negeri         = RefStates::where('status', '=', true)->get();
            $daerah         = RefDaerah::where('status', '=', true)->get();
            $parlimen       = RefParlimen::where('status', '=', true)->get();
            $dun            = RefDun::where('status', '=', true)->get();
            $pbt            = RefPBT::where('status', '=', true)->get();
            $profile_krt    = DB::table('krt__profile')
                            ->select('krt__profile.id',
                                'krt__profile.krt_nama',
                                'krt__profile.krt_alamat',
                                'krt__profile.state_id',
                                'krt__profile.daerah_id',
                                'krt__profile.parlimen_id',
                                'krt__profile.dun_id',
                                'krt__profile.pbt_id',
                                'krt__profile.krt_kawasan',
                                'krt__profile.krt_keluasan',
                                'krt__profile.krt_ipd',
                                'krt__profile.krt_balai',
                                'krt__profile.srs_nama',
                                'krt__profile.krt_tabika',
                                'krt__profile.krt_taska',
                                'krt__profile.krt_status_bagunan_id',
                                'krt__profile.krt_status',
                                DB::raw(" DATE_FORMAT(rt__applications.created_at,'%d/%m/%Y') AS created_at"),
                                'rt__applications.user_fullname',
                                'rt__applications.no_ic',
                                'rt__applications.user_address')
                            ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                            ->where('krt__profile.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm2.profile-krt-hqrt-2', compact('roles_menu','negeri', 'daerah', 'parlimen', 'dun', 'pbt', 'profile_krt'));
        }
    }

    function profile_krt_hqrt_3(Request $request, $id){
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
            $negeri         = RefStates::where('status', '=', true)->get();
            $daerah         = RefDaerah::where('status', '=', true)->get();
            $parlimen       = RefParlimen::where('status', '=', true)->get();
            $dun            = RefDun::where('status', '=', true)->get();
            $pbt            = RefPBT::where('status', '=', true)->get();
            $profile_krt    = DB::table('krt__profile')
                            ->select('krt__profile.id',
                                'krt__profile.krt_nama',
                                'krt__profile.krt_alamat',
                                'krt__profile.state_id',
                                'krt__profile.daerah_id',
                                'krt__profile.parlimen_id',
                                'krt__profile.dun_id',
                                'krt__profile.pbt_id',
                                'krt__profile.krt_kawasan',
                                'krt__profile.krt_keluasan',
                                'krt__profile.krt_ipd',
                                'krt__profile.krt_balai',
                                'krt__profile.srs_nama',
                                'krt__profile.krt_tabika',
                                'krt__profile.krt_taska',
                                'krt__profile.krt_status_bagunan_id',
                                'krt__profile.krt_status',
                                DB::raw(" DATE_FORMAT(rt__applications.created_at,'%d/%m/%Y') AS created_at"),
                                'rt__applications.user_fullname',
                                'rt__applications.no_ic',
                                'rt__applications.user_address')
                            ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                            ->where('krt__profile.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm2.profile-krt-hqrt-3', compact('roles_menu','negeri', 'daerah', 'parlimen', 'dun', 'pbt', 'profile_krt'));
        }
    }

    function profile_krt_hqrt_4(Request $request, $id){
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
            $profile_krt    = DB::table('krt__profile')
                            ->select('krt__profile.id',
                                'krt__profile.krt_nama',
                                'krt__profile.krt_alamat',
                                'krt__profile.state_id',
                                'krt__profile.daerah_id',
                                'krt__profile.parlimen_id',
                                'krt__profile.dun_id',
                                'krt__profile.pbt_id',
                                'krt__profile.krt_kawasan',
                                'krt__profile.krt_keluasan',
                                'krt__profile.krt_ipd',
                                'krt__profile.krt_balai',
                                'krt__profile.srs_nama',
                                'krt__profile.krt_tabika',
                                'krt__profile.krt_taska',
                                'krt__profile.krt_status_bagunan_id',
                                'krt__profile.krt_status',
                                DB::raw(" DATE_FORMAT(rt__applications.created_at,'%d/%m/%Y') AS created_at"),
                                'rt__applications.user_fullname',
                                'rt__applications.no_ic',
                                'rt__applications.user_address')
                            ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                            ->where('krt__profile.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm2.profile-krt-hqrt-4', compact('roles_menu','profile_krt'));
        }
    }

    function profile_krt_hqrt_5(Request $request, $id){
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
            $ref_status_bagunan     = RefStatusBagunan::where('status', '=', true)->get();
            $jenis_premis_binaan    = RefJenisPremis::where('status', '=', true)->get()
                                    ->whereIn('id', [1,2,3]);
            $jenis_premis_tumpang   = RefJenisPremis::where('status', '=', true)->get()
                                    ->whereIn('id', [4,5,6,7]);
            $kabin                  = RefJenisKabin::where('status', '=', true)->get();
            $profile_krt            = DB::table('krt__profile')
                                    ->select('krt__profile.id',
                                            'krt__profile.krt_nama',
                                            'krt__profile.krt_alamat',
                                            'krt__profile.state_id',
                                            'krt__profile.daerah_id',
                                            'krt__profile.parlimen_id',
                                            'krt__profile.dun_id',
                                            'krt__profile.pbt_id',
                                            'krt__profile.krt_kawasan',
                                            'krt__profile.krt_keluasan',
                                            'krt__profile.krt_ipd',
                                            'krt__profile.krt_balai',
                                            'krt__profile.srs_nama',
                                            'krt__profile.krt_tabika',
                                            'krt__profile.krt_taska',
                                            'krt__profile.krt_status_bagunan_id',
                                            'krt__profile.krt_status',
                                            DB::raw(" DATE_FORMAT(rt__applications.created_at,'%d/%m/%Y') AS created_at"),
                                            'rt__applications.user_fullname',
                                            'rt__applications.no_ic',
                                            'rt__applications.user_address',
                                            'krt__profile.krt_status AS status',
                                            'ref__status_krt.status_description AS status_description',
                                            'krt__profile.disemak_note AS disemak_note',
                                            'krt__profile.disahkan_note AS disahkan_note')
                                    ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                                    ->leftJoin('ref__status_krt','ref__status_krt.id','=','krt__profile.krt_status')
                                    ->where('krt__profile.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm2.profile-krt-hqrt-5', compact('roles_menu','ref_status_bagunan', 'jenis_premis_binaan', 'jenis_premis_tumpang' , 'kabin' ,'profile_krt'));
        }
    }

    function profile_krt_hqrt_6(Request $request, $id){
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
            $ref_jantina    = RefJantina::where('status', '=', true)->get();
            $ref_kaum       = RefKaum::where('status', '=', true)->get();
            $profile_krt    = DB::table('krt__profile')
                            ->select('krt__profile.id',
                                'krt__profile.krt_nama',
                                'krt__profile.krt_alamat',
                                'krt__profile.state_id',
                                'krt__profile.daerah_id',
                                'krt__profile.parlimen_id',
                                'krt__profile.dun_id',
                                'krt__profile.pbt_id',
                                'krt__profile.krt_kawasan',
                                'krt__profile.krt_keluasan',
                                'krt__profile.krt_ipd',
                                'krt__profile.krt_balai',
                                'krt__profile.srs_nama',
                                'krt__profile.krt_tabika',
                                'krt__profile.krt_taska',
                                'krt__profile.krt_status_bagunan_id',
                                'krt__profile.krt_status',
                                DB::raw(" DATE_FORMAT(rt__applications.created_at,'%d/%m/%Y') AS created_at"),
                                'rt__applications.user_fullname',
                                'rt__applications.no_ic',
                                'rt__applications.user_address')
                            ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                            ->where('krt__profile.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm2.profile-krt-hqrt-6', compact('roles_menu','ref_jantina','ref_kaum','profile_krt'));
        }
    }
}
