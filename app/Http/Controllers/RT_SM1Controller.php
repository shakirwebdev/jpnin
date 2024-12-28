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
use App\RefJenisKabin;
use App\KRT_Kabin;
use App\Krt_Profile_Upload_Peta;

use DataTables;
use DB;

class RT_SM1Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function permohonan_penubuhan_krt(Request $request){
        if($request->ajax())
        {
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            }
        } else {
            $roles_menu = DB::table('roles__menu')
                ->select('roles__menu.id AS id',
                'users__menu.menu_id AS first_menu',
                'users__menu.menu2nd_id AS second_menu',
                'users__menu.users_menu_page_name AS nama_menu',
                'users__menu.users_menu_file_url AS menu_url',
                'users__menu.highlight AS highlight_menu',
                'users__menu.users_menu_page_icon AS icon_menu')
                ->leftJoin('users__menu','users__menu.id','=','roles__menu.users_menu_id')
                ->leftJoin('users__roles','users__roles.role_id','=','roles__menu.role_id')
                ->where('users__roles.user_id', '=', Auth::user()->user_id)
                ->where('roles__menu.status', '=', true)
                ->orderBy('first_menu', 'asc')
                ->orderBy('id', 'asc')
                ->get();
            $daerah         = RefDaerah::where('status', '=', true)->get();
            $negeri         = RefStates::where('status', '=', true)->get();
            $parlimen       = RefParlimen::where('status', '=', true)->get();
            $dun            = RefDun::where('status', '=', true)->get();
            $applicant      = DB::table('rt__applications')
                            ->select('rt__applications.id',
                                    'rt__applications.user_fullname',
                                    'rt__applications.no_ic',
                                    'rt__applications.no_phone',
                                    'rt__applications.user_address',
                                    'rt__applications.daerah_id',
                                    'rt__applications.state_id',
                                    'rt__applications.krt_name',
                                    'rt__applications.krt_note',
                                    'rt__applications.status',
                                    'rt__applications.is_edit',
                                    'rt__applications.submitby_user_id',
                                    'rt__applications.disemak_by',
                                    'rt__applications.disemak_date',
                                    'rt__applications.disemak_note',
                                    'ref__status_pengesahan_nama.status_description')
                            ->leftJoin('ref__status_pengesahan_nama','ref__status_pengesahan_nama.id','=','rt__applications.status')
                            ->whereIN('rt__applications.status', [1,3])  
                            ->where('submitby_user_id', '=', Auth::user()->user_id)
                            ->limit(1)
                            ->first();
            
            return view('rt-sm1.permohonan-penubuhan-krt', compact('roles_menu','daerah', 'negeri', 'parlimen', 'dun', 'applicant'));
        }
    }

    function action_permohonan_penubuhan_krt(Request $request){
        $action = $request->application_action;
        $app_id = $request->application_id;

        $rules = array(
            'krt_nama_pemohon'          => 'required',
            'krt_no_ic_pemohon'         => 'required|numeric',
            'krt_no_telefon_pemohon'    => 'required|numeric',
            'krt_alamat_pemohon'        => 'required',
            'select_negeri_krt'         => 'required',
            'select_daerah_krt'         => 'required',
            'krt_nama'                  => 'required'
        );

        $messages = [
            'krt_nama_pemohon.required'         => 'Ruangan nama pemohon mesti diisi',
            'krt_no_ic_pemohon.required'        => 'Ruangan no kad pengenalan pemohon mesti diisi',
            'krt_no_ic_pemohon.numeric'         => 'Hanya digit sahaja dibenarkan pada ruangan no kad pengenalan pemohon',
            'krt_no_telefon_pemohon.required'   => 'Ruangan no telefon pemohon mesti diisi',
            'krt_no_telefon_pemohon.numeric'    => 'Hanya digit sahaja dibenarkan pada ruangan no telefon pemohon',
            'krt_alamat_pemohon.required'       => 'Ruangan alamat pemohon mesti diisi',
            'select_negeri_krt.required'        => 'Pilih negeri kedudukan KRT yang dipohon',
            'select_daerah_krt.required'        => 'Pilih daerah kedudukan KRT yang dipohon',
            'krt_nama.required'                 => 'Ruangan cadangan nama KRT mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm1.permohonan_penubuhan_krt'))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'add') {
                $application = new RT_Applications;
                $application->user_fullname        = $request->krt_nama_pemohon;
                $application->no_ic                = preg_replace('/[^0-9]/', '', $request->krt_no_ic_pemohon);
                $application->no_phone             = preg_replace('/[^0-9]/', '', $request->krt_no_telefon_pemohon);
                $application->user_address         = $request->krt_alamat_pemohon;
                $application->daerah_id            = $request->select_daerah_krt;
                $application->state_id             = $request->select_negeri_krt;
                $application->krt_name             = $request->krt_nama;
                $application->krt_note             = $request->krt_catatan;
                $application->submitby_user_id     = Auth::user()->user_id;

                $application->save();
                $last_user_id           = $application->id;

            } elseif ($action == 'update') {
                $where = array('id' => $app_id);
                $application  = RT_Applications::where($where)->first();
        
                $application->user_fullname        = $request->krt_nama_pemohon;
                $application->no_ic                = preg_replace('/[^0-9]/', '', $request->krt_no_ic_pemohon);
                $application->no_phone             = preg_replace('/[^0-9]/', '', $request->krt_no_telefon_pemohon);
                $application->user_address         = $request->krt_alamat_pemohon;
                $application->daerah_id            = $request->select_daerah_krt;
                $application->state_id             = $request->select_negeri_krt;
                $application->krt_name             = $request->krt_nama;
                $application->krt_note             = $request->krt_catatan;
                $application->is_edit              = false; 
                $application->save();
            
            } elseif ($action == 'edit') {
                $where = array('id' => $app_id);
                $application  = RT_Applications::where($where)->first();
        
                $application->user_fullname        = $request->krt_nama_pemohon;
                $application->no_ic                = preg_replace('/[^0-9]/', '', $request->krt_no_ic_pemohon);
                $application->no_phone             = preg_replace('/[^0-9]/', '', $request->krt_no_telefon_pemohon);
                $application->user_address         = $request->krt_alamat_pemohon;
                $application->daerah_id            = $request->select_daerah_krt;
                $application->state_id             = $request->select_negeri_krt;
                $application->krt_name             = $request->krt_nama;
                $application->krt_note             = $request->krt_catatan;
                $application->status               = 1;
                $application->is_edit              = false; 
                $application->save();
            }

            return Redirect::to(route('rt-sm1.permohonan_penubuhan_krt'));
        }
    }

    function unlock_permohonan_penubuhan_krt(Request $request){
        $id = $request->application_id;
        
        $where = array('id' => $id,
                        'is_edit' => 0,
                        'submitby_user_id' => Auth::user()->user_id);
        $application  = RT_Applications::where($where)->first();
 
        $application->is_edit = true; 
        $application->save();

        Session::flash('success', "Anda kini boleh mengubah kandungan Permohonan Penubuhan Kawasan Rukun Tetangga!");
        return Redirect::to(route('rt-sm1.permohonan_penubuhan_krt'));
    }

    function status_permohonan_penubuhan_krt(Request $request){
        if($request->ajax())
        {
            $type = $request->type;
            if($type == 'get_negeri') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else {
                $data = DB::table('rt__applications')
                        ->select('rt__applications.id',
                                    'krt__profile.id AS krt_id',
                                    'rt__applications.user_fullname',
                                    'rt__applications.no_ic',
                                    'rt__applications.created_at',
                                    'rt__applications.krt_name',
                                    'rt__applications.state_id',
                                    'ref__states.state_description',
                                    'rt__applications.daerah_id',
                                    'ref__daerahs.daerah_description',
                                    'rt__applications.status',
                                    'ref__status_pengesahan_nama.status_description AS rt_application_status',
                                    'krt__profile.krt_status',
                                    'a.user_fullname AS disemak_oleh',
                                    'b.user_fullname AS disahkan_oleh',
                                    'ref__status_krt.status_description AS krt_status_description')
                        ->join('ref__states','ref__states.state_id','=','rt__applications.state_id')
                        ->join('ref__daerahs','ref__daerahs.daerah_id','=','rt__applications.daerah_id')
                        ->join('ref__status_pengesahan_nama','ref__status_pengesahan_nama.id','=','rt__applications.status')
                        ->join('krt__profile','krt__profile.rt_applicationID','=','rt__applications.id')
                        ->leftJoin('users__profile as a','a.user_id','=','krt__profile.disemak_by')
                        ->leftJoin('users__profile as b','b.user_id','=','krt__profile.disahkan_by')
                        ->join('ref__status_krt','ref__status_krt.id','=','krt__profile.krt_status')
                        ->where('rt__applications.submitby_user_id', '=', Auth::user()->user_id)                        
                        ->get();

                return Datatables::of($data)
                        ->make(true);
            }
        } else {
            $roles_menu = DB::table('roles__menu')
                ->select('roles__menu.id AS id',
                'users__menu.menu_id AS first_menu',
                'users__menu.menu2nd_id AS second_menu',
                'users__menu.users_menu_page_name AS nama_menu',
                'users__menu.users_menu_file_url AS menu_url',
                'users__menu.highlight AS highlight_menu',
                'users__menu.users_menu_page_icon AS icon_menu')
                ->leftJoin('users__menu','users__menu.id','=','roles__menu.users_menu_id')
                ->leftJoin('users__roles','users__roles.role_id','=','roles__menu.role_id')
                ->where('users__roles.user_id', '=', Auth::user()->user_id)
                ->where('roles__menu.status', '=', true)
                ->orderBy('first_menu', 'asc')
                ->orderBy('id', 'asc')
                ->get();
            return view('rt-sm1.status-permohonan-penubuhan-krt',compact('roles_menu'));
        }
    }

    function semakan_cadangan_krt_baharu(Request $request){
        if($request->ajax()){
            $type = $request->type;
            $data = DB::table('rt__applications')
                        ->select('rt__applications.id',
                            'rt__applications.user_fullname',
                            'rt__applications.no_ic',
                            'rt__applications.created_at',
                            'rt__applications.krt_name',
                            'rt__applications.krt_note',
                            'ref__states.state_id',
                            'ref__states.state_description',
                            'ref__daerahs.daerah_id',
                            'ref__daerahs.daerah_description',
                            'rt__applications.status',
                            'ref__status_pengesahan_nama.status_description',
                            'rt__applications.created_at')
                        ->join('ref__states','ref__states.state_id','=','rt__applications.state_id')
                        ->join('ref__daerahs','ref__daerahs.daerah_id','=','rt__applications.daerah_id')
                        ->join('ref__status_pengesahan_nama','ref__status_pengesahan_nama.status','=','rt__applications.status')
                        ->where('rt__applications.status', '=', 1)
                        ->where('rt__applications.daerah_id', '=', Auth::user()->daerah_id)
                        ->get();
                return Datatables::of($data)
                        ->make(true);
            
        } else {
            $roles_menu = DB::table('roles__menu')
                ->select('roles__menu.id AS id',
                'users__menu.menu_id AS first_menu',
                'users__menu.menu2nd_id AS second_menu',
                'users__menu.users_menu_page_name AS nama_menu',
                'users__menu.users_menu_file_url AS menu_url',
                'users__menu.highlight AS highlight_menu',
                'users__menu.users_menu_page_icon AS icon_menu')
                ->leftJoin('users__menu','users__menu.id','=','roles__menu.users_menu_id')
                ->leftJoin('users__roles','users__roles.role_id','=','roles__menu.role_id')
                ->where('users__roles.user_id', '=', Auth::user()->user_id)
                ->where('roles__menu.status', '=', true)
                ->orderBy('first_menu', 'asc')
                ->orderBy('id', 'asc')
                ->get();
            return view('rt-sm1.semakan-cadangan-krt-baharu',compact('roles_menu'));
        }
    }

    function semak_borang_cadangan_krt_baharu(Request $request, $id){
        if($request->ajax())
        {
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
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
            $daerah         = RefDaerah::where('status', '=', true)->get();
            $negeri         = RefStates::where('status', '=', true)->get();
            $parlimen       = RefParlimen::where('status', '=', true)->get();
            $dun            = RefDun::where('status', '=', true)->get();
            $applicant      = DB::table('rt__applications')
                                ->select('rt__applications.id',
                                        'rt__applications.user_fullname',
                                        'rt__applications.no_ic',
                                        'rt__applications.no_phone',
                                        'rt__applications.user_address',
                                        'rt__applications.daerah_id',
                                        'rt__applications.state_id',
                                        'rt__applications.krt_name',
                                        'rt__applications.krt_note',
                                        'rt__applications.status',
                                        'rt__applications.is_edit',
                                        'rt__applications.submitby_user_id',
                                        'rt__applications.disemak_by',
                                        'rt__applications.disemak_date',
                                        'rt__applications.disemak_note')
                                ->where('status', '=', 1)
                                ->where('id', '=', $id)
                                ->limit(1)
                                ->first();
            return view('rt-sm1.semak-borang-cadangan-krt-baharu', compact('roles_menu','daerah', 'negeri', 'parlimen', 'dun', 'applicant'));

        }
        
    }

    function post_semak_borang_cadangan_krt_baharu(Request $request){
        $action = $request->post_semak_borang_cadangan_krt_baharu;
        $app_id = $request->sbckb_application_id;
        $status = $request->select_status_cadangan_krt;

        $rules = array(
            'select_status_cadangan_krt'            => 'required',
            'krt_disemak_note'                      => 'required'
        );

        $messages = [
            'select_status_cadangan_krt.required'   => 'Pilih status kedudukan KRT yang dipohon',
            'krt_disemak_note.required'             => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $application  = RT_Applications::where($where)->first();
                $application->status                  = $request->select_status_cadangan_krt;
                $application->disemak_note            = $request->krt_disemak_note;
                $application->disemak_by              = Auth::user()->user_id;
                $application->disemak_date            = date('Y-m-d H:i:s');
                $application->save();

                if($status == '2'){
                    $application = new KRT_Profile;
                    $application->rt_applicationID        = $request->sbckb_application_id;
                    $application->krt_nama                = $request->sbckb_krt_nama;
                    $application->krt_alamat              = $request->sbckb_krt_alamat;
                    $application->state_id                = $request->sbckb_krt_state_id;
                    $application->daerah_id               = $request->sbckb_krt_daerah_id;
                    $application->krt_status              = 2;
                    $application->save();
                }
            }
        }
    }

    function kemaskini_profil_krt(Request $request, $id){
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
            $negeri           = RefStates::where('status', '=', true)->get();
            $daerah           = RefDaerah::where('status', '=', true)->get();
            $ref_kaum         = RefKaum::where('status', '=', true)->get();
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
                                            'krt__profile.disahkan_note AS disahkan_note',
                                            'krt__profile.diluluskan_note AS diluluskan_note')
                                    ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                                    ->leftJoin('ref__status_krt','ref__status_krt.id','=','krt__profile.krt_status')
                                    ->where('krt__profile.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $parlimen         = RefParlimen::where('state_id', '=', $profile_krt->state_id)->get();
            $pbt              = RefPBT::where('state_id', '=', $profile_krt->state_id)->get();
            $dun              = RefDun::where('state_id', '=', $profile_krt->state_id)->get();
            return view('rt-sm1.kemaskini-profil-krt', compact('roles_menu','negeri', 'daerah', 'ref_kaum', 'profile_krt', 'parlimen', 'pbt', 'dun'));
        }
    }

    function komposisi_penduduk_table(Request $request, $id){
        $data = DB::table('krt__komposisi_penduduk')
                    ->select('krt__komposisi_penduduk.*','ref__kaum.kaum_description')
                    ->join('ref__kaum','ref__kaum.id','=','krt__komposisi_penduduk.komposisi_kaum')
                    ->where('krt__komposisi_penduduk.krt_profileID', '=', $id)
                    ->get();
                return Datatables::of($data)
                        ->make(true);
    }

    function add_komposisi_penduduk(Request $request){
        $action = $request->add_komposisi_penduduk;
        $app_id = $request->kpk_krt_profileID;
        
        $rules = array(
            'kpk_komposisi_kaum'                => 'required',
            'kpk_komposisi_jumlah'              => 'required'
        );

        $messages = [
            'kpk_komposisi_kaum.required'       => 'Pilih status kedudukan Kaum yang dipohon',
            'kpk_komposisi_jumlah.required'     => 'Ruangan Jumlah mesti diisi',
            
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $komposisi_penduduk = new KRT_Komposisi_penduduk;
                $komposisi_penduduk->krt_profileID    = $request->kpk_krt_profileID;
                $komposisi_penduduk->komposisi_kaum   = $request->kpk_komposisi_kaum;
                $komposisi_penduduk->komposisi_jumlah = $request->kpk_komposisi_jumlah;
                $komposisi_penduduk->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_komposisi_penduduk($id){
        $data = DB::table('krt__komposisi_penduduk')->where('id', '=', $id)->delete();
    }

    function update_kemaskini_profil_krt(Request $request){
        // dd($request);
        $action = $request->update_kemaskini_profil_krt;
        $app_id = $request->kpk1_krt_id;
        
        $rules = array(
            'kpk1_parlimen_id'            => 'required',
            'kpk1_pbt_id'                 => 'required',
            'kpk1_krt_kawasan'            => 'required',
            'kpk1_krt_keluasan'           => 'required',
            'kpk1_krt_ipd'                => 'required',
            'kpk1_krt_balai'              => 'required'
        );

        $messages = [
            'kpk1_parlimen_id.required'   => 'Ruangan parliment mesti dipilih',
            'kpk1_pbt_id.required'        => 'Ruangan pihak berkuasa tempatan mesti dipilih',
            'kpk1_krt_kawasan.required'   => 'Ruangan nama kawasan mesti diisi',
            'kpk1_krt_keluasan.required'  => 'Ruangan saiz keluasan mesti diisi',
            'kpk1_krt_ipd.required'       => 'Ruangan Ibu Pejabat Polis Daerah mesti diisi',
            'kpk1_krt_balai.required'     => 'Ruangan Balai Poslis Daerah mesti diisi'
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $krt_profile  = KRT_Profile::where($where)->first();
                $krt_profile->parlimen_id        = $request->kpk1_parlimen_id;
                $krt_profile->dun_id             = $request->kpk1_dun_id;
                $krt_profile->pbt_id             = $request->kpk1_pbt_id;
                $krt_profile->krt_kawasan        = $request->kpk1_krt_kawasan;
                $krt_profile->krt_keluasan       = $request->kpk1_krt_keluasan;
                $krt_profile->krt_ipd            = $request->kpk1_krt_ipd;
                $krt_profile->krt_balai          = $request->kpk1_krt_balai;
                $krt_profile->srs_nama           = $request->kpk1_srs_nama;
                $krt_profile->krt_tabika         = $request->kpk1_krt_tabika;
                $krt_profile->krt_taska          = $request->kpk1_krt_taska;
                $krt_profile->save();
                
            }
        }
    }

    function kemaskini_profil_krt_1(Request $request, $id){
        if($request->ajax()){ 
             
        } else {
            $profession       = RefProfession::where('status', '=', true)->get();
            $jenis_rumah      = RefJenisRumah::where('status', '=', true)->get();
            $roles_menu       = DB::table('roles__menu')
                                ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
                                'users__menu.highlight AS highlight_menu',
                                'users__menu.users_menu_page_icon AS icon_menu')
                                ->leftJoin('users__menu','users__menu.id','=','roles__menu.users_menu_id')
                                ->leftJoin('users__roles','users__roles.role_id','=','roles__menu.role_id')
                                ->where('users__roles.user_id', '=', Auth::user()->user_id)
                                ->where('roles__menu.status', '=', true)
                                ->orderBy('first_menu', 'asc')
                                ->orderBy('id', 'asc')
                                ->get();
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
                                        'krt__profile.disahkan_note AS disahkan_note',
                                        'krt__profile.diluluskan_note AS diluluskan_note')
                                ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                                ->leftJoin('ref__status_krt','ref__status_krt.id','=','krt__profile.krt_status')
                                ->where('krt__profile.id', '=', $id)  
                                ->limit(1)
                                ->first();
            return view('rt-sm1.kemaskini-profil-krt-1', compact('profession', 'jenis_rumah', 'roles_menu', 'profile_krt'));
        }
    }

    function pekerjaan_table(Request $request, $id){
        $data = DB::table('krt__pekerjaan')
                    ->select('krt__pekerjaan.*','ref__profession.profession_description')
                    ->join('ref__profession','ref__profession.id','=','krt__pekerjaan.profession_id')
                    ->where('krt__pekerjaan.krt_profileID', '=', $id)
                    ->get();
                return Datatables::of($data)
                        ->make(true);
    }

    function add_pekerjaan(Request $request){
        $action = $request->add_pekerjaan;
        $app_id = $request->kpk1_krt_profileID;
        
        $rules = array(
            'kpk1_profession_id'                 => 'required',
            'kpk1_pekerjaan_peratus'             => 'required'
        );

        $messages = [
            'kpk1_profession_id.required'        => 'Ruangan pekerjaan mesti dipilih',
            'kpk1_pekerjaan_peratus.required'    => 'Ruangan Peratus (%) mesti diisi',
            
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $pekerjaan = new KRT_Pekerjaan;
                $pekerjaan->krt_profileID    = $request->kpk1_krt_profileID;
                $pekerjaan->profession_id   = $request->kpk1_profession_id;
                $pekerjaan->pekerjaan_peratus = $request->kpk1_pekerjaan_peratus;
                $pekerjaan->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_pekerjaan_krt($id){
        $data = DB::table('krt__pekerjaan')->where('id', '=', $id)->delete();
    }

    function jenis_rumah_table(Request $request, $id){
        $data = DB::table('krt__jenis_rumah')
                    ->select('krt__jenis_rumah.*','ref__jenis_rumah.jenis_rumah_description')
                    ->join('ref__jenis_rumah','ref__jenis_rumah.id','=','krt__jenis_rumah.jenis_rumah_id')
                    ->where('krt__jenis_rumah.krt_profileID', '=', $id)
                    ->get();
                return Datatables::of($data)
                        ->make(true);
    }

    function add_jenis_rumah(Request $request){
        $action = $request->add_jenis_rumah;
        $app_id = $request->jrf_krt_profileID;
        
        $rules = array(
            'jrf_jenis_rumah_id'                 => 'required',
            'jrf_jumlah_pintu'                   => 'required'
        );

        $messages = [
            'jrf_jenis_rumah_id.required'        => 'Ruangan Jenis Rumah mesti dipilih',
            'jrf_jumlah_pintu.required'          => 'Ruangan Bilangan Pintu/Unit mesti diisi',
            
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $jenis_rumah = new KRT_JenisRumah;
                $jenis_rumah->krt_profileID    = $request->jrf_krt_profileID;
                $jenis_rumah->jenis_rumah_id   = $request->jrf_jenis_rumah_id;
                $jenis_rumah->jumlah_pintu = $request->jrf_jumlah_pintu;
                $jenis_rumah->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_jenis_rumah($id){
        $data = DB::table('krt__jenis_rumah')->where('id', '=', $id)->delete();
    }

    function kemaskini_profil_krt_2(Request $request, $id){
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
                            'krt__profile.disahkan_note AS disahkan_note',
                            'krt__profile.diluluskan_note AS diluluskan_note')
                            ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                            ->leftJoin('ref__status_krt','ref__status_krt.id','=','krt__profile.krt_status')
                            ->where('krt__profile.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm1.kemaskini-profil-krt-2', compact('roles_menu','profile_krt'));
        }
    }

    function jenis_pertubuhan_table(Request $request, $id){
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

    function post_jenis_pertubuhan(Request $request){
        $action = $request->add_jenis_pekerjaan;
        $kpk2_krt_profileID = $request->kpk2_krt_profileID;
        $krt_JenisPertubuhanID = $request->krt_JenisPertubuhanID;
        
        $jenis_pekerjaan = new KRT_JenisPertubuhan;
        $jenis_pekerjaan->krt_profileID         = $kpk2_krt_profileID;
        $jenis_pekerjaan->jenis_pertubuhan_id   = $request->krt_JenisPertubuhanID;
        $jenis_pekerjaan->save();

    }

    function delete_jenis_pertubuhan(Request $request){
        $kpk2_krt_profileID      = $request->kpk2_krt_profileID;
        $krt_JenisPertubuhanID  = $request->krt_JenisPertubuhanID;

        $data = DB::table('krt__jenis_pertubuhan')
                ->where('krt_profileID', '=', $kpk2_krt_profileID)
                ->where('jenis_pertubuhan_id', '=', $krt_JenisPertubuhanID)
                ->delete();
    }

    function kemaskini_profil_krt_3(Request $request, $id){
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
            $kemudahan_awam = RefKemudahanAwam::where('status', '=', true)->get();
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
                                'krt__profile.disahkan_note AS disahkan_note',
                                'krt__profile.diluluskan_note AS diluluskan_note')
                            ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                            ->leftJoin('ref__status_krt','ref__status_krt.id','=','krt__profile.krt_status')
                            ->where('krt__profile.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm1.kemaskini-profil-krt-3', compact('roles_menu','kemudahan_awam', 'profile_krt'));
        }
    }

    function kemudahan_awam_table(Request $request, $id){
        $data = DB::table('krt__kemudahan_awam')
                    ->select('krt__kemudahan_awam.*','ref__kemudahan_awam.kemudahan_awam_description')
                    ->join('ref__kemudahan_awam','ref__kemudahan_awam.id','=','krt__kemudahan_awam.ref_kemudahan_awamID')
                    ->where('krt__kemudahan_awam.krt_profileID', '=', $id)
                    ->get();
                return Datatables::of($data)
                        ->make(true);
    }

    function add_kemudahan_awam(Request $request){
        $action = $request->add_kemudahan_awam;
        $app_id = $request->kaf_krt_profileID;
        
        $rules = array(
            'kaf_ref_kemudahan_awamID'            => 'required',
            'kaf_kemudahan_awam_jumlah'           => 'required'
        );

        $messages = [
            'kaf_ref_kemudahan_awamID.required'   => 'Ruangan Perkara mesti dipilih',
            'kaf_kemudahan_awam_jumlah.required'  => 'Ruangan Jumlah mesti diisi',
            
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $kemudahan_awam = new KRT_KemudahanAwam;
                $kemudahan_awam->krt_profileID          = $request->kaf_krt_profileID;
                $kemudahan_awam->ref_kemudahan_awamID   = $request->kaf_ref_kemudahan_awamID;
                $kemudahan_awam->kemudahan_awam_jumlah  = $request->kaf_kemudahan_awam_jumlah;
                $kemudahan_awam->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_kemudahan_awam($id){
        $data = DB::table('krt__kemudahan_awam')->where('id', '=', $id)->delete();
    }

    function kemaskini_profil_krt_4(Request $request, $id){
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
                                'krt__profile.disahkan_note AS disahkan_note',
                                'krt__profile.diluluskan_note AS diluluskan_note')
                            ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                            ->leftJoin('ref__status_krt','ref__status_krt.id','=','krt__profile.krt_status')
                            ->where('krt__profile.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm1.kemaskini-profil-krt-4', compact('roles_menu','profile_krt'));
        }
    }

    function kes_jenayah_table(Request $request, $id){
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

    function post_kes_jenayah(Request $request){
        $kpk4_1_krt_profileID = $request->kpk4_1_krt_profileID;
        $krt_kesJenayahID = $request->krt_kesJenayahID;
        
        $kes_jenayah = new KRT_KesJenayah;
        $kes_jenayah->krt_profileID         = $kpk4_1_krt_profileID;
        $kes_jenayah->ref_jenayahID         = $request->krt_kesJenayahID;
        $kes_jenayah->save();

    }

    function delete_kes_jenayah(Request $request){
        $kpk4_1_krt_profileID   = $request->kpk4_1_krt_profileID;
        $krt_kesJenayahID       = $request->krt_kesJenayahID;

        $data = DB::table('krt__kes_jenayah')
                ->where('krt_profileID', '=', $kpk4_1_krt_profileID)
                ->where('ref_jenayahID', '=', $krt_kesJenayahID)
                ->delete();
    }

    function kes_masalah_sosial_table(Request $request, $id){
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

    function post_masalah_sosial(Request $request){
        $kpk4_2_krt_profileID = $request->kpk4_2_krt_profileID;
        $krt_masalahSosialID = $request->krt_masalahSosialID;
        
        $kes_jenayah = new KRT_masalahSosial;
        $kes_jenayah->krt_profileID             = $kpk4_2_krt_profileID;
        $kes_jenayah->ref_masalahSosialID       = $request->krt_masalahSosialID;
        $kes_jenayah->save();

    }

    function delete_masalah_sosial(Request $request){
        $kpk4_2_krt_profileID       = $request->kpk4_2_krt_profileID;
        $krt_masalahSosialID        = $request->krt_masalahSosialID;

        $data = DB::table('krt__masalah_sosial')
            ->where('krt_profileID', '=', $kpk4_2_krt_profileID)
            ->where('ref_masalahSosialID', '=', $krt_masalahSosialID)
            ->delete();
    }

    function kemaskini_profil_krt_5(Request $request, $id){
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
            $pertanian      = RefPertanian::where('status', '=', true)->get();
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
                                'krt__profile.disahkan_note AS disahkan_note',
                                'krt__profile.diluluskan_note AS diluluskan_note')
                            ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                            ->leftJoin('ref__status_krt','ref__status_krt.id','=','krt__profile.krt_status')
                            ->where('krt__profile.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm1.kemaskini-profil-krt-5', compact('roles_menu','pertanian', 'profile_krt'));
        }
    }

    function kawasan_pertanian_table(Request $request, $id){
        $data = DB::table('krt__kawasan_pertanian')
                    ->select('krt__kawasan_pertanian.*','ref__pertanian.pertanian_description')
                    ->join('ref__pertanian','ref__pertanian.id','=','krt__kawasan_pertanian.ref_pertanianID')
                    ->where('krt__kawasan_pertanian.krt_profileID', '=', $id)
                    ->get();
                return Datatables::of($data)
                        ->make(true);
    }

    function add_kawasan_pertanian(Request $request){
        $action = $request->add_kawasan_pertanian;
        $app_id = $request->kpf_krt_profileID;
        
        $rules = array(
            'kpf_ref_pertanianID'                       => 'required',
            'kpf_kawasan_pertanian_dalam'               => 'required',
            'kpf_kawasan_pertanian_luar'                => 'required'
        );

        $messages = [
            'kpf_ref_pertanianID.required'              => 'Ruangan Perkara mesti dipilih',
            'kpf_kawasan_pertanian_dalam.required'      => 'Ruangan Dalam Kawasan KRT mesti diisi',
            'kpf_kawasan_pertanian_luar.required'       => 'Ruangan Luar  Kawasan KRT mesti diisi',
            
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $kawasan_pertanian = new KRT_KawasanPertanian;
                $kawasan_pertanian->krt_profileID               = $request->kpf_krt_profileID;
                $kawasan_pertanian->ref_pertanianID             = $request->kpf_ref_pertanianID;
                $kawasan_pertanian->kawasan_pertanian_dalam     = $request->kpf_kawasan_pertanian_dalam;
                $kawasan_pertanian->kawasan_pertanian_luar      = $request->kpf_kawasan_pertanian_luar;
                $kawasan_pertanian->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_kawasan_pertanian($id){
        $data = DB::table('krt__kawasan_pertanian')->where('id', '=', $id)->delete();
    }

    function kemaskini_profil_krt_6(Request $request, $id){
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
                                    ->where('krt__profile.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm1.kemaskini-profil-krt-6', compact('roles_menu','ref_status_bagunan', 'jenis_premis_binaan', 'jenis_premis_tumpang' , 'kabin' ,'profile_krt'));
        }
    }

    function senarai_binaan_table(Request $request, $id){
        $data = DB::table('krt__binaan')
                    ->select('krt__binaan.*', 'ref__jenis_premis.jenis_premis_description')
                    ->join('ref__jenis_premis','ref__jenis_premis.id','=','krt__binaan.binaan_jenis_premis_id')
                    ->where('krt__binaan.krt_profileID', '=', $id)
                    ->get();
        return Datatables::of($data)
                    ->make(true);
    }

    function add_binaan_jambatan(Request $request){
        // dd($request);
        $action = $request->add_binaan_jambatan;
        
        $rules = array(
            'mabj_binaan_jenis_premis_id'            => 'required',
            'mabj_binaan_alamat'                     => 'required',
            'mabj_binaan_kos'                        => 'required',
            'mabj_binaan_keluasan_tanah'             => 'required',
            'mabj_binaan_keluasan_bagunan'           => 'required',
            'mabj_binaan_tarikh_mula_bina'           => 'required',
            'mabj_binaan_isu'                        => 'required',
        );

        $messages = [
            'mabj_binaan_jenis_premis_id.required'      => 'Ruangan Jenis Premis mesti dipilih',
            'mabj_binaan_alamat.required'               => 'Ruangan Alamat mesti diisi',
            'mabj_binaan_kos.required'                  => 'Ruangan Kos Pembinaan Bagunan mesti diisi',
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
                $krt_binaan->binaan_tanah_ptp           = $request->mabj_binaan_tanah_ptp;
                $krt_binaan->binaan_tanah_negeri        = $request->mabj_binaan_tanah_negeri;
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

    function delete_binaan($id){
        $data = DB::table('krt__binaan')->where('id', '=', $id)->delete();
    }

    function get_senarai_bagunan_tumpang(Request $request, $id){
        $data = DB::table('krt__bagunan_tumpang')
                    ->select('krt__bagunan_tumpang.*', 'ref__jenis_premis.jenis_premis_description')
                    ->join('ref__jenis_premis','ref__jenis_premis.id','=','krt__bagunan_tumpang.tumpang_jenis_premis_id')
                    ->where('krt__bagunan_tumpang.krt_profileID', '=', $id)
                    ->get();
        return Datatables::of($data)
                    ->make(true);
    }

    function add_bagunan_tumpang(Request $request){
        // dd($request);
        $action = $request->add_bagunan_tumpang;
        
        $rules = array(
            'mabt_tumpang_jenis_premis_id'            => 'required',
            'mabt_tumpang_alamat'                     => 'required',
        );

        $messages = [
            'mabt_tumpang_jenis_premis_id.required'     => 'Ruangan Jenis Premis mesti dipilih',
            'mabt_tumpang_alamat.required'              => 'Ruangan Alamat mesti diisi',
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
                $krt_bagunan_tumpang->tumpang_tanah_ptp           = $request->mabt_tumpang_tanah_ptp;
                $krt_bagunan_tumpang->tumpang_tanah_negeri        = $request->mabt_tumpang_tanah_negeri;
                $krt_bagunan_tumpang->tumpang_tanah_persendirian  = $request->mabt_tumpang_tanah_persendirian;
                $krt_bagunan_tumpang->tumpang_tanah_swasta        = $request->mabt_tumpang_tanah_swasta;
                $krt_bagunan_tumpang->save();
                
            }
        }
    }

    function delete_bagunan_tumpang($id){
        $data = DB::table('krt__bagunan_tumpang')->where('id', '=', $id)->delete();
    }

    function senarai_kabin_table(Request $request, $id){
        $data = DB::table('krt__kabin')
                    ->select('krt__kabin.*', 'ref__jenis_kabin.jenis_kabin_description AS jenis_kabin')
                    ->join('ref__jenis_kabin','ref__jenis_kabin.id','=','krt__kabin.kabin_jenis')
                    ->where('krt__kabin.krt_profileID', '=', $id)
                    ->get();
        return Datatables::of($data)
                    ->make(true);
    }

    function add_kabin(Request $request){
        $action = $request->add_kabin;
        
        $rules = array(
            'maksa_kabin_jenis'                                 => 'required',
            'maksa_kabin_alamat'                                => 'required',
            'maksa_kabin_tarikh_bina'                           => 'required',
            'maksa_kabin_kos'                                   => 'required',
            'maksa_kabin_isu'                                   => 'required'
        );

        $messages = [
            'maksa_kabin_jenis.required'                        => 'Ruangan Jenis Kabin mesti dipilih',
            'maksa_kabin_alamat.required'                       => 'Ruangan Alamat mesti diisi',
            'maksa_kabin_tarikh_bina.required'                  => 'Ruangan Tarikh Mula Bina Bagunan mesti dipilih',
            'maksa_kabin_kos.required'                          => 'Ruangan Anggaran Kos Kabin mesti diisi',
            'maksa_kabin_isu.required'                          => 'Ruangan Isu mesti dipilih',
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
                $kabin->kabin_tanah_ptp                       = $request->maksa_kabin_tanah_ptp;
                $kabin->kabin_tanah_negeri                    = $request->maksa_kabin_tanah_negeri;
                $kabin->kabin_tanah_swasta                    = $request->maksa_kabin_tanah_swasta;
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

    function add_kabin_sedia_ada(Request $request){
        $action = $request->add_kabin;
        $app_id = $request->maksa_krt_profileID;
        $carbon_obj = Carbon::createFromFormat('d/m/Y', $request->maksa_kabin_tarikh_bina)->format('Y-m-d');
        
        $rules = array(
            'maksa_kabin_jenis'                                 => 'required',
            'maksa_kabin_alamat'                                => 'required',
            'maksa_kabin_tarikh_bina'                           => 'required',
            'maksa_kabin_kos'                                   => 'required',
            'maksa_kabin_isu'                                   => 'required'
        );

        $messages = [
            'maksa_kabin_jenis.required'                        => 'Ruangan Jenis Kabin mesti dipilih',
            'maksa_kabin_alamat.required'                       => 'Ruangan Alamat mesti diisi',
            'maksa_kabin_tarikh_bina.required'                  => 'Ruangan Tarikh Mula Bina Bagunan mesti dipilih',
            'maksa_kabin_kos.required'                          => 'Ruangan Anggaran Kos Kabin mesti diisi',
            'maksa_kabin_isu.required'                          => 'Ruangan Isu mesti dipilih',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $kabin = new KRT_Kabin;
                $kabin->krt_profileID                         = $request->maksa_krt_profileID;
                $kabin->kabin_jenis                           = $request->maksa_kabin_jenis;
                $kabin->kabin_sumbangan_lain                  = $request->maksa_kabin_sumbangan_lain;
                $kabin->kabin_alamat                          = $request->maksa_kabin_alamat;
                $kabin->kabin_tanah_ptp                       = $request->maksa_kabin_tanah_ptp;
                $kabin->kabin_tanah_negeri                    = $request->maksa_kabin_tanah_negeri;
                $kabin->kabin_tanah_swasta                    = $request->maksa_kabin_tanah_swasta;
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

    function delete_kabin($id){
        $data = DB::table('krt__kabin')->where('id', '=', $id)->delete();
    }

    function cadangan_pembinaan_table(Request $request, $id){
        $data = DB::table('krt__pembinaan_prt1')
                    ->select('krt__pembinaan_prt1.*')
                    ->where('krt__pembinaan_prt1.krt_profileID', '=', $id)
                    ->get();
                return Datatables::of($data)
                    ->make(true);
    }

    function add_cadangan_pembinaan_prt(Request $request){
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

    function delete_cadangan_pembinaan($id){
        $data = DB::table('krt__pembinaan_prt1')->where('id', '=', $id)->delete();
    }

    function update_kemaskini_profil_krt_6(Request $request){
        // dd($request);
        $action = $request->update_kemaskini_profil_krt_6;
        $app_id = $request->kpk6_krt_id;
        
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
                $krt_profile  = KRT_Profile::where($where)->first();
                $krt_profile->krt_status_bagunan_id     = $request->kpk6_krt_status_bagunan_id;
                $krt_profile->save();
                
            }
        }
    }

    function kemaskini_profil_krt_7(Request $request, $id){
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
                                'krt__profile.disahkan_note AS disahkan_note',
                                'krt__profile.diluluskan_note AS diluluskan_note')
                            ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                            ->leftJoin('ref__status_krt','ref__status_krt.id','=','krt__profile.krt_status')
                            ->where('krt__profile.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm1.kemaskini-profil-krt-7', compact('roles_menu','profile_krt'));
        }
    }

    function get_peta_kawasan_table(Request $request, $id){
        $data = DB::table('krt__profile_upload_peta')
                ->select('krt__profile_upload_peta.*')
                ->where('krt__profile_upload_peta.krt_profile_id', '=', $id)
                ->get();
        return Datatables::of($data)
                ->make(true);
    }

    function add_peta_kawasan(Request $request){
        $action = $request->add_peta_kawasan;
        $app_id = $request->pk7_krt_profile_id;
        $fileName = $request->pk7_file_peta->getClientOriginalName();
       

        $rules = array(
            'pk7_file_title'               => 'required',
            'pk7_file_catatan'             => 'required',
            'pk7_file_peta'                => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:5000'
        );

        $messages = [
            'pk7_file_title.required'     => 'Ruangan Tajuk Fail Mesti Diisi',
            'pk7_file_catatan.required'   => 'Ruangan Catatan Fail Mesti Diisi',
            'pk7_file_peta.required'      => 'Ruangan Fail Mesti Dipilih',
            'pk7_file_peta.mimes'         => 'Fail Mesti Dipilih Dalam Format jpeg,png,jpg,gif,svg,pdf',
            'pk7_file_peta.max'           => 'Fail mesti dalam sive 5000KB',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            $request->pk7_file_peta->storeAs('public/peta_kawasan',$fileName);
            if ($action == 'add') {
                $peta_kawasan = new Krt_Profile_Upload_Peta;
                $peta_kawasan->krt_profile_id   = $app_id;
                $peta_kawasan->file_title       = $request->pk7_file_title;
                $peta_kawasan->file_catatan     = $request->pk7_file_catatan;
                $peta_kawasan->file_peta        = $fileName;
                $peta_kawasan->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function get_peta_kawasan($id){
        $data = DB::table('krt__profile_upload_peta')
                ->select('krt__profile_upload_peta.id', 
                    'krt__profile_upload_peta.file_peta AS file_peta' )
                ->where('krt__profile_upload_peta.id', '=', $id)
                ->first();
        return Response::json($data);
    }

    function delete_peta_kawasan($id){
        $data = DB::table('krt__profile_upload_peta')->where('id', '=', $id)->delete();
    }

    function kemaskini_profil_krt_8(Request $request, $id){
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
                                'rt__applications.user_address',
                                'krt__profile.krt_status AS status',
                                'ref__status_krt.status_description AS status_description',
                                'krt__profile.disemak_note AS disemak_note',
                                'krt__profile.disahkan_note AS disahkan_note',
                                'krt__profile.diluluskan_note AS diluluskan_note')
                            ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                            ->leftJoin('ref__status_krt','ref__status_krt.id','=','krt__profile.krt_status')
                            ->where('krt__profile.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm1.kemaskini-profil-krt-8', compact('roles_menu','ref_kaum', 'ref_jantina', 'profile_krt'));
        }
    }

    function jawatankuasa_penaja_table(Request $request, $id){
        $data = DB::table('krt__senarai_jawatankuasa_penaja')
                    ->select('krt__senarai_jawatankuasa_penaja.*')
                    ->where('krt__senarai_jawatankuasa_penaja.krt_profileID', '=', $id)
                    ->get();
                return Datatables::of($data)
                        ->make(true);
    }
    
    function view_jawatankuasa_penaja_table($id){
        $data = DB::table('krt__senarai_jawatankuasa_penaja')
                ->select('krt__senarai_jawatankuasa_penaja.*')
                ->where('krt__senarai_jawatankuasa_penaja.id', '=', $id)
                ->first();
        return Response::json($data);
    }

    function add_jawatankuasa_penaja(Request $request){
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
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $carbon_obj = Carbon::createFromFormat('d/m/Y', $request->jpf_penaja_birth)->format('Y-m-d');
                $jawatankuasa_penaja = new KRT_JawatankuasaPenaja;
                $jawatankuasa_penaja->krt_profileID             = $request->jpf_krt_profileID;
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

    function delete_jawatankuasa_penaja($id){
        $data = DB::table('krt__senarai_jawatankuasa_penaja')->where('id', '=', $id)->delete();
    }

    function hantar_permohonan_krt(Request $request){
        
        $action = $request->hantar_permohonan_krt;
        $app_id = $request->krt_profile_id;
        
        $rules = array(
            
        );

        $messages = [
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm1.kemaskini_profil_krt_8',$app_id))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $krt_profile                     = KRT_Profile::where($where)->first();
                $krt_profile->krt_status         = 3;
                $krt_profile->dihantar_by        = Auth::user()->user_id;
                $krt_profile->dihantar_date      = date('Y-m-d H:i:s');
                $krt_profile->save();
                
            }
           
            return Redirect::to(route('rt-sm1.status_permohonan_penubuhan_krt'));
        }

    }

    function semakan_permohonan_krt_baharu(Request $request){
        if($request->ajax()){
            $type = $request->type;
            $data = DB::table('krt__profile')
                        ->select('krt__profile.id',
                            'krt__profile.state_id',
                            'krt__profile.daerah_id',
                            'krt__profile.krt_nama',
                            'krt__profile.krt_alamat',
                            'krt__profile.created_at',
                            'ref__status_krt.status_description')
                        ->join('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                        ->join('ref__status_krt','ref__status_krt.id','=','krt__profile.krt_status')
                        ->where('krt__profile.krt_status', '=', 3) 
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
            return view('rt-sm1.semakan-permohonan-krt-baharu',compact('roles_menu'));
        }
    }

    function semakan_permohonan_krt_ppd(Request $request, $id){
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
            return view('rt-sm1.semakan-permohonan-krt-ppd', compact('profile_krt','roles_menu'));
        }
    }

    function semakan_permohonan_krt_ppd_1(Request $request, $id){
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
            $negeri           = RefStates::where('status', '=', true)->get();
            $daerah           = RefDaerah::where('status', '=', true)->get();
            $parlimen         = RefParlimen::where('status', '=', true)->get();
            $dun              = RefDun::where('status', '=', true)->get();
            $pbt              = RefPBT::where('status', '=', true)->get();
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
                                                'rt__applications.user_address')
                                        ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                                        ->where('krt__profile.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            return view('rt-sm1.semakan-permohonan-krt-ppd-1', compact('roles_menu','negeri', 'daerah', 'parlimen', 'dun', 'pbt', 'profile_krt'));
        }
    }

    function semakan_permohonan_krt_ppd_2(Request $request, $id){
        if($request->ajax()){ 
        } else {
             $roles_menu    = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
            return view('rt-sm1.semakan-permohonan-krt-ppd-2', compact('roles_menu','negeri', 'daerah', 'parlimen', 'dun', 'pbt', 'profile_krt'));
        }
    }

    function semakan_permohonan_krt_ppd_3(Request $request, $id){
        if($request->ajax()){ 
        } else {
            $roles_menu    = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
            return view('rt-sm1.semakan-permohonan-krt-ppd-3', compact('roles_menu','profile_krt'));
        }
    }

    function semakan_permohonan_krt_ppd_4(Request $request, $id){
        if($request->ajax()){ 
        } else {
            $roles_menu    = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
                                                'rt__applications.user_address')
                                        ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                                        ->where('krt__profile.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            return view('rt-sm1.semakan-permohonan-krt-ppd-4', compact('roles_menu','ref_status_bagunan','jenis_premis_binaan','jenis_premis_tumpang','kabin','profile_krt'));
        }
    }

    function semakan_permohonan_krt_ppd_5(Request $request, $id){
        if($request->ajax()){ 
        } else {
            $roles_menu    = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
            return view('rt-sm1.semakan-permohonan-krt-ppd-5', compact('roles_menu','ref_jantina','ref_kaum','profile_krt'));
        }
    }

    function post_semakan_permohonan_krt_ppd(Request $request){
        
        $action = $request->post_semakan_permohonan_krt_ppd;
        $app_id = $request->spk_ppd_krt_profile_id;
        
        $rules = array(
            'spk_ppd_krt_status'                => 'required',
            'spk_ppd_disemak_note'              => 'required'
        );

        $messages = [
            'spk_ppd_krt_status.required'       => 'Ruangan Status mesti dipilih',
            'spk_ppd_disemak_note.required'     => 'Ruangan Penerangan mesti diisi'
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $krt_profile                     = KRT_Profile::where($where)->first();
                $krt_profile->krt_status         = $request->spk_ppd_krt_status;
                $krt_profile->disemak_by         = Auth::user()->user_id;
                $krt_profile->disemak_date       = date('Y-m-d H:i:s');
                $krt_profile->disemak_note       = $request->spk_ppd_disemak_note;
                $krt_profile->save();
                
            }
           
            return Redirect::to(route('rt-sm1.semakan_permohonan_krt_baharu'));
        }

    }

    function pengesahan_permohonan_krt_baharu(Request $request){
        if($request->ajax()){
            $type = $request->type;
            $data = DB::table('krt__profile')
                        ->select('krt__profile.id',
                            'ref__daerahs.daerah_description AS krt_daerah',
                            'krt__profile.state_id',
                            'krt__profile.daerah_id',
                            'krt__profile.krt_nama',
                            'krt__profile.krt_alamat',
                            'krt__profile.created_at',
                            'ref__status_krt.status_description')
                        ->join('ref__status_krt','ref__status_krt.id','=','krt__profile.krt_status')
                        ->leftjoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftjoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->where('krt__profile.krt_status', '=', 4)  
                        ->where('krt__profile.state_id', '=', Auth::user()->state_id)   
                        ->get();
                return Datatables::of($data)
                        ->make(true);
        } else {
            $roles_menu    = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
                                'users__menu.highlight AS highlight_menu',
                                'users__menu.users_menu_page_icon AS icon_menu')
                            ->leftJoin('users__menu','users__menu.id','=','roles__menu.users_menu_id')
                            ->leftJoin('users__roles','users__roles.role_id','=','roles__menu.role_id')
                            ->where('users__roles.user_id', '=', Auth::user()->user_id)
                            ->where('roles__menu.status', '=', true)
                            ->orderBy('first_menu', 'asc')
                            ->orderBy('id', 'asc')
                            ->get();
            $daerah  = RefDaerah::where('state_id', '=',   Auth::user()->state_id)->get();
            return view('rt-sm1.pengesahan-permohonan-krt-baharu', compact('roles_menu','daerah'));
        }
    }

    function pengesahan_permohonan_krt_ppn(Request $request, $id){
        if($request->ajax()){ 
        } else {
             $roles_menu    = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
                                'users__menu.highlight AS highlight_menu',
                                'users__menu.users_menu_page_icon AS icon_menu')
                            ->leftJoin('users__menu','users__menu.id','=','roles__menu.users_menu_id')
                            ->leftJoin('users__roles','users__roles.role_id','=','roles__menu.role_id')
                            ->where('users__roles.user_id', '=', Auth::user()->user_id)
                            ->where('roles__menu.status', '=', true)
                            ->orderBy('first_menu', 'asc')
                            ->orderBy('id', 'asc')
                            ->get();
            $profile_krt       = DB::table('krt__profile')
                                ->select('krt__profile.id',
                                'krt__profile.krt_nama AS krt_nama',
                                'users__profile.user_fullname AS disemak_by',
                                DB::raw(" DATE_FORMAT(krt__profile.disemak_date,'%d/%m/%Y') AS disemak_date"),
                                'krt__profile.disemak_note AS disemak_note')
                                ->leftJoin('users__profile','users__profile.user_id','=','krt__profile.disemak_by')
                                ->where('krt__profile.id', '=', $id)  
                                ->limit(1)
                                ->first();
            return view('rt-sm1.pengesahan-permohonan-krt-ppn', compact('roles_menu','profile_krt'));
        }
    }

    function pengesahan_permohonan_krt_ppn_1(Request $request, $id){
        if($request->ajax()){ 
        } else {
            $roles_menu    = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
                                'users__menu.highlight AS highlight_menu',
                                'users__menu.users_menu_page_icon AS icon_menu')
                            ->leftJoin('users__menu','users__menu.id','=','roles__menu.users_menu_id')
                            ->leftJoin('users__roles','users__roles.role_id','=','roles__menu.role_id')
                            ->where('users__roles.user_id', '=', Auth::user()->user_id)
                            ->where('roles__menu.status', '=', true)
                            ->orderBy('first_menu', 'asc')
                            ->orderBy('id', 'asc')
                            ->get();
            $negeri           = RefStates::where('status', '=', true)->get();
            $daerah           = RefDaerah::where('status', '=', true)->get();
            $parlimen         = RefParlimen::where('status', '=', true)->get();
            $dun              = RefDun::where('status', '=', true)->get();
            $pbt              = RefPBT::where('status', '=', true)->get();
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
                                                'rt__applications.user_address')
                                        ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                                        ->where('krt__profile.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            return view('rt-sm1.pengesahan-permohonan-krt-ppn-1', compact('roles_menu','negeri', 'daerah', 'parlimen', 'dun', 'pbt', 'profile_krt'));
        }
    }

    function pengesahan_permohonan_krt_ppn_2(Request $request, $id){
        if($request->ajax()){ 
        } else {
            $roles_menu    = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
            return view('rt-sm1.pengesahan-permohonan-krt-ppn-2', compact('roles_menu','profile_krt'));
        }
    }

    function pengesahan_permohonan_krt_ppn_3(Request $request, $id){
        if($request->ajax()){ 
        } else {
            $roles_menu    = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
            return view('rt-sm1.pengesahan-permohonan-krt-ppn-3', compact('roles_menu','profile_krt'));
        }
    }

    function pengesahan_permohonan_krt_ppn_4(Request $request, $id){
        if($request->ajax()){ 
        } else {
            $roles_menu    = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
                                                'rt__applications.user_address')
                                        ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                                        ->where('krt__profile.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            return view('rt-sm1.pengesahan-permohonan-krt-ppn-4', compact('roles_menu','ref_status_bagunan','jenis_premis_binaan','jenis_premis_tumpang','kabin', 'profile_krt'));
        }
    }

    function pengesahan_permohonan_krt_ppn_5(Request $request, $id){
        if($request->ajax()){ 
        } else {
            $roles_menu    = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
                                'users__menu.highlight AS highlight_menu',
                                'users__menu.users_menu_page_icon AS icon_menu')
                            ->leftJoin('users__menu','users__menu.id','=','roles__menu.users_menu_id')
                            ->leftJoin('users__roles','users__roles.role_id','=','roles__menu.role_id')
                            ->where('users__roles.user_id', '=', Auth::user()->user_id)
                            ->where('roles__menu.status', '=', true)
                            ->orderBy('first_menu', 'asc')
                            ->orderBy('id', 'asc')
                            ->get();
            $ref_jantina      = RefJantina::where('status', '=', true)->get();
            $ref_kaum         = RefKaum::where('status', '=', true)->get();
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
                                                'rt__applications.user_address')
                                        ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                                        ->where('krt__profile.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            return view('rt-sm1.pengesahan-permohonan-krt-ppn-5', compact('roles_menu','ref_jantina','ref_kaum','profile_krt'));
        }
    }

    function hantar_pengesahan_permohonan_krt_ppn(Request $request){
        
        $action = $request->post_pengesahan_permohonan_krt_ppn;
        $app_id = $request->ppk_ppn_krt_profile_id;
        
        $rules = array(
            'ppk_ppn_krt_status'                => 'required',
            'ppk_ppn_disahkan_note'             => 'required'
        );

        $messages = [
            'ppk_ppn_krt_status.required'       => 'Pilih status kedudukan KRT yang disemak',
            'ppk_ppn_disahkan_note.required'    => 'Ruangan Penerangan mesti diisi'
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $krt_profile                        = KRT_Profile::where($where)->first();
                $krt_profile->krt_status            = $request->ppk_ppn_krt_status;
                $krt_profile->disahkan_by           = Auth::user()->user_id;
                $krt_profile->disahkan_note         = $request->ppk_ppn_disahkan_note;
                $krt_profile->disahkan_date         = date('Y-m-d H:i:s');
                $krt_profile->save();
                
            }
           
            return Redirect::to(route('rt-sm1.pengesahan_permohonan_krt_baharu'));
        }

    }

    function kelulusan_permohonan_krt_baharu(Request $request){
        if($request->ajax()){
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            }
            $data = DB::table('krt__profile')
                        ->select('krt__profile.id',
                            'ref__states.state_description AS krt_state',
                            'ref__daerahs.daerah_description AS krt_daerah',
                            'krt__profile.state_id',
                            'krt__profile.daerah_id',
                            'krt__profile.krt_nama',
                            'krt__profile.krt_alamat',
                            'krt__profile.created_at',
                            'krt__profile.dihantar_date',
                            'krt__profile.disemak_date',
                            'krt__profile.disahkan_date',
                            'ref__status_krt.status_description')
                        ->join('ref__status_krt','ref__status_krt.id','=','krt__profile.krt_status')
                        ->leftjoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftjoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->where('krt__profile.krt_status', '=', 6)   
                        ->get();
                return Datatables::of($data)
                        ->make(true);
        } else {
            $roles_menu    = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
            return view('rt-sm1.kelulusan-permohonan-krt-baharu', compact('roles_menu','state','daerah'));
        }
    }

    function kelulusan_permohonan_krt_hq(Request $request, $id){
        if($request->ajax()){ 
        } else {
            $roles_menu    = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
                                'users__menu.highlight AS highlight_menu',
                                'users__menu.users_menu_page_icon AS icon_menu')
                            ->leftJoin('users__menu','users__menu.id','=','roles__menu.users_menu_id')
                            ->leftJoin('users__roles','users__roles.role_id','=','roles__menu.role_id')
                            ->where('users__roles.user_id', '=', Auth::user()->user_id)
                            ->where('roles__menu.status', '=', true)
                            ->orderBy('first_menu', 'asc')
                            ->orderBy('id', 'asc')
                            ->get();
            $profile_krt      = KRT_Profile::where('krt_status', '=', 6)
                                ->select('krt__profile.id',
                                'krt__profile.krt_nama AS krt_nama',
                                'a.user_fullname AS disemak_by',
                                'b.user_fullname AS disahkan_by',
                                DB::raw(" DATE_FORMAT(krt__profile.disemak_date,'%d/%m/%Y') AS disemak_date"),
                                DB::raw(" DATE_FORMAT(krt__profile.disahkan_date,'%d/%m/%Y') AS disahkan_date"),
                                'krt__profile.disemak_note AS disemak_note',
                                'krt__profile.disahkan_note AS disahkan_note')
                                ->join('users__profile as a','a.user_id','=','krt__profile.disemak_by')
                                ->join('users__profile as b','b.user_id','=','krt__profile.disahkan_by')
                                ->where('krt__profile.id', '=', $id)
                                ->limit(1)
                                ->first();
            return view('rt-sm1.kelulusan-permohonan-krt-hq', compact('roles_menu','profile_krt'));
        }
    }

    function kelulusan_permohonan_krt_hq_1(Request $request, $id){
        if($request->ajax()){ 
        } else {
            $roles_menu    = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
                                'users__menu.highlight AS highlight_menu',
                                'users__menu.users_menu_page_icon AS icon_menu')
                            ->leftJoin('users__menu','users__menu.id','=','roles__menu.users_menu_id')
                            ->leftJoin('users__roles','users__roles.role_id','=','roles__menu.role_id')
                            ->where('users__roles.user_id', '=', Auth::user()->user_id)
                            ->where('roles__menu.status', '=', true)
                            ->orderBy('first_menu', 'asc')
                            ->orderBy('id', 'asc')
                            ->get();
            $negeri           = RefStates::where('status', '=', true)->get();
            $daerah           = RefDaerah::where('status', '=', true)->get();
            $parlimen         = RefParlimen::where('status', '=', true)->get();
            $dun              = RefDun::where('status', '=', true)->get();
            $pbt              = RefPBT::where('status', '=', true)->get();
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
                                                'rt__applications.user_address')
                                        ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                                        ->where('krt__profile.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            return view('rt-sm1.kelulusan-permohonan-krt-hq-1', compact('roles_menu','negeri', 'daerah', 'parlimen', 'dun', 'pbt', 'profile_krt'));
        }
    }

    function kelulusan_permohonan_krt_hq_2(Request $request, $id){
        if($request->ajax()){ 
        } else {
            $roles_menu    = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
                                'users__menu.highlight AS highlight_menu',
                                'users__menu.users_menu_page_icon AS icon_menu')
                            ->leftJoin('users__menu','users__menu.id','=','roles__menu.users_menu_id')
                            ->leftJoin('users__roles','users__roles.role_id','=','roles__menu.role_id')
                            ->where('users__roles.user_id', '=', Auth::user()->user_id)
                            ->where('roles__menu.status', '=', true)
                            ->orderBy('first_menu', 'asc')
                            ->orderBy('id', 'asc')
                            ->get();
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
                                                'rt__applications.user_address')
                                        ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                                        ->where('krt__profile.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            return view('rt-sm1.kelulusan-permohonan-krt-hq-2', compact('roles_menu','profile_krt'));
        }
    }

    function kelulusan_permohonan_krt_hq_3(Request $request, $id){
        if($request->ajax()){ 
        } else {
            $roles_menu    = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
                                'users__menu.highlight AS highlight_menu',
                                'users__menu.users_menu_page_icon AS icon_menu')
                            ->leftJoin('users__menu','users__menu.id','=','roles__menu.users_menu_id')
                            ->leftJoin('users__roles','users__roles.role_id','=','roles__menu.role_id')
                            ->where('users__roles.user_id', '=', Auth::user()->user_id)
                            ->where('roles__menu.status', '=', true)
                            ->orderBy('first_menu', 'asc')
                            ->orderBy('id', 'asc')
                            ->get();
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
                                                'rt__applications.user_address')
                                        ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                                        ->where('krt__profile.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            return view('rt-sm1.kelulusan-permohonan-krt-hq-3', compact('roles_menu','profile_krt'));
        }
    }

    function kelulusan_permohonan_krt_hq_4(Request $request, $id){
        if($request->ajax()){ 
        } else {
            $roles_menu    = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
                                                'rt__applications.user_address')
                                        ->leftJoin('rt__applications','rt__applications.id','=','krt__profile.rt_applicationID')
                                        ->where('krt__profile.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            return view('rt-sm1.kelulusan-permohonan-krt-hq-4', compact('roles_menu','ref_status_bagunan','jenis_premis_binaan','jenis_premis_tumpang','kabin','profile_krt'));
        }
    }

    function kelulusan_permohonan_krt_hq_5(Request $request, $id){
        if($request->ajax()){ 
        } else {
            $roles_menu    = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
            return view('rt-sm1.kelulusan-permohonan-krt-hq-5', compact('roles_menu','ref_jantina','ref_kaum','profile_krt'));
        }
    }

    function post_kelulusan_permohonan_krt_hq(Request $request){
        $action = $request->post_kelulusan_permohonan_krt_hq;
        $app_id = $request->krt_profile_id;
        
        
        $rules = array(
            'kpkh5_krt_status_kelulusan'             => 'required',
            'kpkh5_krt_diluluskan_note'              => 'required',
        );

        $messages = [
            'kpkh5_krt_status_kelulusan.required'    => 'Ruangan Status dipilih',
            'kpkh5_krt_diluluskan_note.required'     => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $kelulusan_krt_profile                         = KRT_Profile::where($where)->first();
                $kelulusan_krt_profile->krt_status             = $request->kpkh5_krt_status_kelulusan;
                $kelulusan_krt_profile->diluluskan_note        = $request->kpkh5_krt_diluluskan_note;
                $kelulusan_krt_profile->diluluskan_by          = Auth::user()->user_id;
                $kelulusan_krt_profile->diluluskan_date        = date('Y-m-d H:i:s');
                $kelulusan_krt_profile->save();
            }
        }
    }

}
