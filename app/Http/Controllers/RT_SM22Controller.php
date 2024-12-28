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
use App\RefStates;
use App\RefDaerah;
use App\RefBandar;
use App\RefParlimen;
use App\RefDUN;
use App\RefPBT;
use App\KRT_Profile;
use App\SPK_imuhibbah;
use App\SPK_iMuhibbah_AT;
use App\Ref_SPK_iKes_AT_Jenis;
use App\SPK_iMuhibbah_TS;

class RT_SM22Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function senarai_permohonan_muhibbah_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('spk__imuhibbah')
                        ->select('spk__imuhibbah.id AS id',
                                'spk__imuhibbah.imuhibbah_tajuk AS imuhibbah_tajuk',
                                DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_laporan,'%d/%m/%Y') AS imuhibbah_tarikh_laporan"),
                                DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_j_berlaku,'%d/%m/%Y') AS imuhibbah_tarikh_j_berlaku"),
                                'users__profile.user_fullname AS user_fullname',
                                'spk__imuhibbah.status AS status',
                                'ref__status_spk_imuhibbah.status_description AS status_description')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imuhibbah.dihantar_by')
                        ->leftJoin('ref__status_spk_imuhibbah','ref__status_spk_imuhibbah.id','=','spk__imuhibbah.status')
                        ->where('spk__imuhibbah.dihantar_by', '=', Auth::user()->user_id)
                        ->whereIN('spk__imuhibbah.status',[2,3,4,5,6,7,8])
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
            return view('rt-sm22.senarai-permohonan-muhibbah-ppd',compact('roles_menu'));
        }
    }

    function post_permohonan_imuhibbah(Request $request){
        
        $action = $request->post_permohonan_imuhibbah;
        
        $rules = array(
           
        );

        $messages = [
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm22.senarai_permohonan_muhibbah_ppd'))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'add') {
                $imuhibbah               = new SPK_imuhibbah;
                $imuhibbah->status       = 2;
                $imuhibbah->dihantar_by  = Auth::user()->user_id;
                $imuhibbah->save();
            }
           
            return Redirect::to(route('rt-sm22.permohonan_muhibbah_ppd',$imuhibbah->id));
        }

    }

    function permohonan_muhibbah_ppd(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_bandar') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = RefBandar::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = KRT_Profile::where($where)
                        ->where('krt__profile.krt_status', '=',  true)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_parlimen') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefParlimen::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_dun') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDUN::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_pbt') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefPBT::where($where)->get();
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
            $negeri                 = RefStates::where('status', '=', true)->get();
            $daerah                 = RefDaerah::where('status', '=', true)->get();
            $bandar                 = RefBandar::where('status', '=', true)->get();
            $parlimen               = RefParlimen::where('status', '=', true)->get();
            $dun                    = RefDUN::where('status', '=', true)->get();
            $pbt                    = RefPBT::where('status', '=', true)->get();
            $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
            $imuhibbah              = DB::table('spk__imuhibbah')
                                    ->select('spk__imuhibbah.id',
                                            'spk__imuhibbah.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__imuhibbah.krt_profile_id',
                                            'spk__imuhibbah.imuhibbah_tajuk',
                                            'spk__imuhibbah.state_id',
                                            'spk__imuhibbah.daerah_id',
                                            'spk__imuhibbah.bandar_id',
                                            'spk__imuhibbah.imuhibbah_kawasan',
                                            'spk__imuhibbah.imuhibbah_lokasi',
                                            'spk__imuhibbah.imuhibbah_poskod',
                                            'spk__imuhibbah.parlimen_id',
                                            'spk__imuhibbah.dun_id',
                                            'spk__imuhibbah.pbt_id',
                                            DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_laporan,'%d/%m/%Y') AS imuhibbah_tarikh_laporan"),
                                            DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_j_berlaku,'%d/%m/%Y') AS imuhibbah_tarikh_j_berlaku"),
                                            'spk__imuhibbah.imuhibbah_laporan',
                                            'spk__imuhibbah.imuhibbah_sumber_maklumat',
                                            'spk__imuhibbah.imuhibbah_pelapor_nama',
                                            'spk__imuhibbah.imuhibbah_pelapor_no',
                                            'spk__imuhibbah.imuhibbah_pelapor_jawatan',
                                            'spk__imuhibbah.imuhibbah_pelapor_alamat',
                                            'spk__imuhibbah.status',
                                            'spk__imuhibbah.dihantar_by',
                                            'spk__imuhibbah.diakui_by',
                                            'spk__imuhibbah.disemak_by',
                                            'spk__imuhibbah.disahkan_by',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon',
                                            'spk__imuhibbah.diakui_note AS diakui_note',
                                            'spk__imuhibbah.disemak_note AS disemak_note',
                                            'spk__imuhibbah.disahkan_note AS disahkan_note',
                                            'ref__status_spk_imuhibbah.status_description AS status_description'
                                            )
                                    ->leftJoin('ref__status_spk_imuhibbah','ref__status_spk_imuhibbah.id','=','spk__imuhibbah.status')
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__imuhibbah.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__imuhibbah.krt_profile_id')
                                    ->where('spk__imuhibbah.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm22.permohonan-muhibbah-ppd', compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt','imuhibbah'));
        }
    }

    function post_permohonan_imuhibbah_1(Request $request){
        $action = $request->post_permohonan_imuhibbah_1;
        $app_id = $request->pmpd3_imuhibbah_id;
        $hasKRT = $request->pmpd_hasRT;

        if ($hasKRT == '1') {
            $rules_main = array(                
                'pmpd_state_id'                         => 'required',
                'pmpd_daerah_id'                        => 'required',
                'pmpd_krt_profile_id'                   => 'required',
                'pmpd2_imuhibbah_tajuk'                 => 'required',
                'pmpd2_state_id'                        => 'required',
                'pmpd2_bandar_id'                       => 'required',
                'pmpd2_imuhibbah_lokasi'                => 'required',
                'pmpd2_parlimen_id'                     => 'required',
                'pmpd2_pbt_id'                          => 'required',
                'pmpd2_daerah_id'                       => 'required',
                'pmpd2_imuhibbah_kawasan'               => 'required',
                'pmpd2_imuhibbah_poskod'                => 'required',
                'pmpd2_dun_id'                          => 'required',
                'pmpd2_imuhibbah_tarikh_laporan'        => 'required',
                'pmpd2_imuhibbah_tarikh_j_berlaku'      => 'required',
                'pmpd2_imuhibbah_laporan'               => 'required',
                'pmpd2_imuhibbah_sumber_maklumat'       => 'required',
                'pmpd2_imuhibbah_pelapor_nama'          => 'required',
                'pmpd2_imuhibbah_pelapor_no'            => 'required',
                'pmpd2_imuhibbah_pelapor_jawatan'       => 'required',
                'pmpd2_imuhibbah_pelapor_alamat'        => 'required',
            );
        } else {
            $rules_main = array(
                'pmpd2_imuhibbah_tajuk'                 => 'required',
                'pmpd2_state_id'                        => 'required',
                'pmpd2_bandar_id'                       => 'required',
                'pmpd2_imuhibbah_lokasi'                => 'required',
                'pmpd2_parlimen_id'                     => 'required',
                'pmpd2_pbt_id'                          => 'required',
                'pmpd2_daerah_id'                       => 'required',
                'pmpd2_imuhibbah_kawasan'               => 'required',
                'pmpd2_imuhibbah_poskod'                => 'required',
                'pmpd2_dun_id'                          => 'required',
                'pmpd2_imuhibbah_tarikh_laporan'        => 'required',
                'pmpd2_imuhibbah_tarikh_j_berlaku'      => 'required',
                'pmpd2_imuhibbah_laporan'               => 'required',
                'pmpd2_imuhibbah_sumber_maklumat'       => 'required',
                'pmpd2_imuhibbah_pelapor_nama'          => 'required',
                'pmpd2_imuhibbah_pelapor_no'            => 'required',
                'pmpd2_imuhibbah_pelapor_jawatan'       => 'required',
                'pmpd2_imuhibbah_pelapor_alamat'        => 'required',
            );
        }
        
        $messages = [
            'pmpd_state_id.required'                    => 'Ruangan Negeri mesti dipilih',
            'pmpd_daerah_id.required'                   => 'Ruangan Daerah mesti dipilih',
            'pmpd_krt_profile_id.required'              => 'Ruangan Nama KRT mesti dipilih',
            'pmpd2_imuhibbah_tajuk.required'            => 'Ruangan Tajuk mesti diisi',
            'pmpd2_state_id.required'                   => 'Ruangan Negeri mesti dipilih',
            'pmpd2_bandar_id.required'                  => 'Ruangan Bandar mesti dipilih',
            'pmpd2_imuhibbah_lokasi.required'           => 'Ruangan Lokasi /  Nama Jalan mesti diisi',
            'pmpd2_parlimen_id.required'                => 'Ruangan Parlimen mesti dipilih',
            'pmpd2_pbt_id.required'                     => 'Ruangan PBT mesti dipilih',
            'pmpd2_daerah_id.required'                  => 'Ruangan Daerah mesti dipilih',
            'pmpd2_imuhibbah_kawasan.required'          => 'Ruangan Taman / Kampung mesti diisi',
            'pmpd2_imuhibbah_poskod.required'           => 'Ruangan Poskod mesti diisi',
            'pmpd2_dun_id.required'                     => 'Ruangan Dun mesti dipilih',
            'pmpd2_imuhibbah_tarikh_laporan.required'   => 'Ruangan Tarikh Laporan mesti dipilih',
            'pmpd2_imuhibbah_tarikh_j_berlaku.required' => 'Ruangan Tarikh Jangkaan Berlaku mesti dipilih',
            'pmpd2_imuhibbah_laporan.required'          => 'Ruangan Laporan mesti diisi',
            'pmpd2_imuhibbah_sumber_maklumat.required'  => 'Ruangan Sumber Maklumat Kes mesti diisi',
            'pmpd2_imuhibbah_pelapor_nama.required'     => 'Ruangan Nama Pelapor mesti diisi',
            'pmpd2_imuhibbah_pelapor_no.required'       => 'Ruangan No Telefon Pelapor mesti diisi',
            'pmpd2_imuhibbah_pelapor_jawatan.required'  => 'Ruangan Jawatan Pelapor mesti diisi',
            'pmpd2_imuhibbah_pelapor_alamat.required'   => 'Ruangan Alamat Pelapor mesti diisi',
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $carbon_obj                                     = Carbon::createFromFormat('d/m/Y', $request->pmpd2_imuhibbah_tarikh_laporan)->format('Y-m-d');
                $carbon_obj_1                                   = Carbon::createFromFormat('d/m/Y', $request->pmpd2_imuhibbah_tarikh_j_berlaku)->format('Y-m-d');
                $update_imuhibbah                               = SPK_imuhibbah::where($where)->first();
                $update_imuhibbah->hasRT                        = $hasKRT;
                $update_imuhibbah->krt_profile_id               = $request->pmpd_krt_profile_id;
                $update_imuhibbah->imuhibbah_tajuk              = $request->pmpd2_imuhibbah_tajuk;
                $update_imuhibbah->state_id                     = $request->pmpd2_state_id;
                $update_imuhibbah->daerah_id                    = $request->pmpd2_daerah_id;
                $update_imuhibbah->bandar_id                    = $request->pmpd2_bandar_id;
                $update_imuhibbah->imuhibbah_kawasan            = $request->pmpd2_imuhibbah_kawasan;
                $update_imuhibbah->imuhibbah_lokasi             = $request->pmpd2_imuhibbah_lokasi;
                $update_imuhibbah->imuhibbah_poskod             = $request->pmpd2_imuhibbah_poskod;
                $update_imuhibbah->parlimen_id                  = $request->pmpd2_parlimen_id;
                $update_imuhibbah->dun_id                       = $request->pmpd2_dun_id;
                $update_imuhibbah->pbt_id                       = $request->pmpd2_pbt_id;
                $update_imuhibbah->imuhibbah_tarikh_laporan     = $carbon_obj;
                $update_imuhibbah->imuhibbah_tarikh_j_berlaku   = $carbon_obj_1;
                $update_imuhibbah->imuhibbah_laporan            = $request->pmpd2_imuhibbah_laporan;
                $update_imuhibbah->imuhibbah_sumber_maklumat    = $request->pmpd2_imuhibbah_sumber_maklumat;
                $update_imuhibbah->imuhibbah_pelapor_nama       = $request->pmpd2_imuhibbah_pelapor_nama;
                $update_imuhibbah->imuhibbah_pelapor_no         = $request->pmpd2_imuhibbah_pelapor_no;
                $update_imuhibbah->imuhibbah_pelapor_jawatan    = $request->pmpd2_imuhibbah_pelapor_jawatan;
                $update_imuhibbah->imuhibbah_pelapor_alamat     = $request->pmpd2_imuhibbah_pelapor_alamat;
                $update_imuhibbah->status                       = 3;
                $update_imuhibbah->dihantar_date                = date('Y-m-d H:i:s');
                $update_imuhibbah->save();
                
            }
        }
    }

    function senarai_akuan_permohonan_muhibbah_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('spk__imuhibbah')
                        ->select('spk__imuhibbah.id AS id',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'spk__imuhibbah.imuhibbah_tajuk AS imuhibbah_tajuk',
                                DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_laporan,'%d/%m/%Y') AS imuhibbah_tarikh_laporan"),
                                DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_j_berlaku,'%d/%m/%Y') AS imuhibbah_tarikh_j_berlaku"),
                                'users__profile.user_fullname AS user_fullname',
                                'spk__imuhibbah.status AS status',
                                'ref__status_spk_imuhibbah.status_description AS status_description')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','spk__imuhibbah.daerah_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imuhibbah.dihantar_by')
                        ->leftJoin('ref__status_spk_imuhibbah','ref__status_spk_imuhibbah.id','=','spk__imuhibbah.status')
                        ->where('spk__imuhibbah.state_id', '=', Auth::user()->state_id)
                        ->whereIN('spk__imuhibbah.status',[3])
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
            $daerah     = RefDaerah::where('status', '=',  true)
                        ->where('ref__daerahs.state_id', '=', Auth::user()->state_id)    
                        ->get();
            return view('rt-sm22.senarai-akuan-permohonan-muhibbah-ppn', compact('roles_menu','daerah'));
        }
    }

    function akuan_permohonan_muhibbah_ppn(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_bandar') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = RefBandar::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = KRT_Profile::where($where)
                        ->where('krt__profile.krt_status', '=',  true)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_parlimen') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefParlimen::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_dun') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDUN::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_pbt') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefPBT::where($where)->get();
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
            $negeri                 = RefStates::where('status', '=', true)->get();
            $daerah                 = RefDaerah::where('status', '=', true)->get();
            $bandar                 = RefBandar::where('status', '=', true)->get();
            $parlimen               = RefParlimen::where('status', '=', true)->get();
            $dun                    = RefDUN::where('status', '=', true)->get();
            $pbt                    = RefPBT::where('status', '=', true)->get();
            $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
            $imuhibbah              = DB::table('spk__imuhibbah')
                                    ->select('spk__imuhibbah.id',
                                            'spk__imuhibbah.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__imuhibbah.krt_profile_id',
                                            'spk__imuhibbah.imuhibbah_tajuk',
                                            'spk__imuhibbah.state_id',
                                            'spk__imuhibbah.daerah_id',
                                            'spk__imuhibbah.bandar_id',
                                            'spk__imuhibbah.imuhibbah_kawasan',
                                            'spk__imuhibbah.imuhibbah_lokasi',
                                            'spk__imuhibbah.imuhibbah_poskod',
                                            'spk__imuhibbah.parlimen_id',
                                            'spk__imuhibbah.dun_id',
                                            'spk__imuhibbah.pbt_id',
                                            DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_laporan,'%d/%m/%Y') AS imuhibbah_tarikh_laporan"),
                                            DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_j_berlaku,'%d/%m/%Y') AS imuhibbah_tarikh_j_berlaku"),
                                            'spk__imuhibbah.imuhibbah_laporan',
                                            'spk__imuhibbah.imuhibbah_sumber_maklumat',
                                            'spk__imuhibbah.imuhibbah_pelapor_nama',
                                            'spk__imuhibbah.imuhibbah_pelapor_no',
                                            'spk__imuhibbah.imuhibbah_pelapor_jawatan',
                                            'spk__imuhibbah.imuhibbah_pelapor_alamat',
                                            'spk__imuhibbah.status',
                                            'spk__imuhibbah.dihantar_by',
                                            'spk__imuhibbah.diakui_by',
                                            'spk__imuhibbah.disemak_by',
                                            'spk__imuhibbah.disahkan_by',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon',
                                            'spk__imuhibbah.diakui_note AS diakui_note',
                                            'spk__imuhibbah.disemak_note AS disemak_note',
                                            'spk__imuhibbah.disahkan_note AS disahkan_note'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__imuhibbah.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__imuhibbah.krt_profile_id')
                                    ->where('spk__imuhibbah.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm22.akuan-permohonan-muhibbah-ppn', compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt','imuhibbah'));
        }
    }

    function post_akui_permohonan_imuhibbah(Request $request){
        $action = $request->post_akui_permohonan_imuhibbah;
        $app_id = $request->apmpn_spk_imuhibbah_id;
        
        
        $rules = array(
            'apmpn_imuhibbah_status'            => 'required',
            'apmpn_diakui_note'                 => 'required',
        );

        $messages = [
            'apmpn_imuhibbah_status.required'   => 'Ruangan Status dipilih',
            'apmpn_diakui_note.required'        => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $akui_permohonan_imuhibbah                   = SPK_imuhibbah::where($where)->first();
                $akui_permohonan_imuhibbah->status           = $request->apmpn_imuhibbah_status;
                $akui_permohonan_imuhibbah->diakui_by        = Auth::user()->user_id;
                $akui_permohonan_imuhibbah->diakui_date      = date('Y-m-d H:i:s');
                $akui_permohonan_imuhibbah->diakui_note      = $request->apmpn_diakui_note;
                $akui_permohonan_imuhibbah->save();
            }
        }
    }

    function senarai_semakan_permohonan_muhibbah_bpp(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_description' => $value);
                $data  = DB::table('ref__daerahs')
                        ->select('ref__daerahs.id', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__daerahs.state_id')
                        ->where('ref__states.state_description', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('spk__imuhibbah')
                        ->select('spk__imuhibbah.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'spk__imuhibbah.imuhibbah_tajuk AS imuhibbah_tajuk',
                                DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_laporan,'%d/%m/%Y') AS imuhibbah_tarikh_laporan"),
                                DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_j_berlaku,'%d/%m/%Y') AS imuhibbah_tarikh_j_berlaku"),
                                'users__profile.user_fullname AS user_fullname',
                                'spk__imuhibbah.status AS status',
                                'ref__status_spk_imuhibbah.status_description AS status_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','spk__imuhibbah.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','spk__imuhibbah.daerah_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imuhibbah.dihantar_by')
                        ->leftJoin('ref__status_spk_imuhibbah','ref__status_spk_imuhibbah.id','=','spk__imuhibbah.status')
                        ->whereIN('spk__imuhibbah.status',[4,9])
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
            return view('rt-sm22.senarai-semakan-permohonan-muhibbah-bpp',compact('roles_menu','state'));
        }
    }

    function semakan_permohonan_muhibbah_bpp(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_bandar') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = RefBandar::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = KRT_Profile::where($where)
                        ->where('krt__profile.krt_status', '=',  true)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_parlimen') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefParlimen::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_dun') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDUN::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_pbt') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefPBT::where($where)->get();
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
            $negeri                 = RefStates::where('status', '=', true)->get();
            $daerah                 = RefDaerah::where('status', '=', true)->get();
            $bandar                 = RefBandar::where('status', '=', true)->get();
            $parlimen               = RefParlimen::where('status', '=', true)->get();
            $dun                    = RefDUN::where('status', '=', true)->get();
            $pbt                    = RefPBT::where('status', '=', true)->get();
            $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
            $imuhibbah              = DB::table('spk__imuhibbah')
                                    ->select('spk__imuhibbah.id',
                                            'spk__imuhibbah.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__imuhibbah.krt_profile_id',
                                            'spk__imuhibbah.imuhibbah_tajuk',
                                            'spk__imuhibbah.state_id',
                                            'spk__imuhibbah.daerah_id',
                                            'spk__imuhibbah.bandar_id',
                                            'spk__imuhibbah.imuhibbah_kawasan',
                                            'spk__imuhibbah.imuhibbah_lokasi',
                                            'spk__imuhibbah.imuhibbah_poskod',
                                            'spk__imuhibbah.parlimen_id',
                                            'spk__imuhibbah.dun_id',
                                            'spk__imuhibbah.pbt_id',
                                            DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_laporan,'%d/%m/%Y') AS imuhibbah_tarikh_laporan"),
                                            DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_j_berlaku,'%d/%m/%Y') AS imuhibbah_tarikh_j_berlaku"),
                                            'spk__imuhibbah.imuhibbah_laporan',
                                            'spk__imuhibbah.imuhibbah_sumber_maklumat',
                                            'spk__imuhibbah.imuhibbah_pelapor_nama',
                                            'spk__imuhibbah.imuhibbah_pelapor_no',
                                            'spk__imuhibbah.imuhibbah_pelapor_jawatan',
                                            'spk__imuhibbah.imuhibbah_pelapor_alamat',
                                            'spk__imuhibbah.status',
                                            'spk__imuhibbah.dihantar_by',
                                            'spk__imuhibbah.diakui_by',
                                            'spk__imuhibbah.disemak_by',
                                            'spk__imuhibbah.disahkan_by',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon',
                                            'spk__imuhibbah.diakui_note AS diakui_note',
                                            'spk__imuhibbah.disemak_note AS disemak_note',
                                            'spk__imuhibbah.disahkan_note AS disahkan_note'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__imuhibbah.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__imuhibbah.krt_profile_id')
                                    ->where('spk__imuhibbah.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm22.semakan-permohonan-muhibbah-bpp', compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt','imuhibbah'));
        }
    }

    function post_semakan_permohonan_imuhibbah(Request $request){
        $action = $request->post_semakan_permohonan_imuhibbah;
        $app_id = $request->spmpp_spk_imuhibbah_id;
        
        
        $rules = array(
            'spmpp_imuhibbah_status'            => 'required',
            'spmpp_disemak_note'                => 'required',
        );

        $messages = [
            'spmpp_imuhibbah_status.required'   => 'Ruangan Status dipilih',
            'spmpp_disemak_note.required'       => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $semak_permohonan_imuhibbah                   = SPK_imuhibbah::where($where)->first();
                $semak_permohonan_imuhibbah->status           = $request->spmpp_imuhibbah_status;
                $semak_permohonan_imuhibbah->disemak_by       = Auth::user()->user_id;
                $semak_permohonan_imuhibbah->disemak_date     = date('Y-m-d H:i:s');
                $semak_permohonan_imuhibbah->disemak_note     = $request->spmpp_disemak_note;
                $semak_permohonan_imuhibbah->save();
            }
        }
    }

    function senarai_sahkan_permohonan_muhibbah_p(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_description' => $value);
                $data  = DB::table('ref__daerahs')
                        ->select('ref__daerahs.id', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__daerahs.state_id')
                        ->where('ref__states.state_description', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('spk__imuhibbah')
                        ->select('spk__imuhibbah.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'spk__imuhibbah.imuhibbah_tajuk AS imuhibbah_tajuk',
                                DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_laporan,'%d/%m/%Y') AS imuhibbah_tarikh_laporan"),
                                DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_j_berlaku,'%d/%m/%Y') AS imuhibbah_tarikh_j_berlaku"),
                                'users__profile.user_fullname AS user_fullname',
                                'spk__imuhibbah.status AS status',
                                'ref__status_spk_imuhibbah.status_description AS status_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','spk__imuhibbah.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','spk__imuhibbah.daerah_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imuhibbah.dihantar_by')
                        ->leftJoin('ref__status_spk_imuhibbah','ref__status_spk_imuhibbah.id','=','spk__imuhibbah.status')
                        ->whereIN('spk__imuhibbah.status',[6,10,13])
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
            return view('rt-sm22.senarai-sahkan-permohonan-muhibbah-p', compact('roles_menu','state'));
        }
    }

    function sahkan_permohonan_muhibbah_p(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_bandar') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = RefBandar::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = KRT_Profile::where($where)
                        ->where('krt__profile.krt_status', '=',  true)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_parlimen') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefParlimen::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_dun') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDUN::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_pbt') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefPBT::where($where)->get();
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
            $negeri                 = RefStates::where('status', '=', true)->get();
            $daerah                 = RefDaerah::where('status', '=', true)->get();
            $bandar                 = RefBandar::where('status', '=', true)->get();
            $parlimen               = RefParlimen::where('status', '=', true)->get();
            $dun                    = RefDUN::where('status', '=', true)->get();
            $pbt                    = RefPBT::where('status', '=', true)->get();
            $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
            $imuhibbah              = DB::table('spk__imuhibbah')
                                    ->select('spk__imuhibbah.id',
                                            'spk__imuhibbah.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__imuhibbah.krt_profile_id',
                                            'spk__imuhibbah.imuhibbah_tajuk',
                                            'spk__imuhibbah.state_id',
                                            'spk__imuhibbah.daerah_id',
                                            'spk__imuhibbah.bandar_id',
                                            'spk__imuhibbah.imuhibbah_kawasan',
                                            'spk__imuhibbah.imuhibbah_lokasi',
                                            'spk__imuhibbah.imuhibbah_poskod',
                                            'spk__imuhibbah.parlimen_id',
                                            'spk__imuhibbah.dun_id',
                                            'spk__imuhibbah.pbt_id',
                                            DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_laporan,'%d/%m/%Y') AS imuhibbah_tarikh_laporan"),
                                            DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_j_berlaku,'%d/%m/%Y') AS imuhibbah_tarikh_j_berlaku"),
                                            'spk__imuhibbah.imuhibbah_laporan',
                                            'spk__imuhibbah.imuhibbah_sumber_maklumat',
                                            'spk__imuhibbah.imuhibbah_pelapor_nama',
                                            'spk__imuhibbah.imuhibbah_pelapor_no',
                                            'spk__imuhibbah.imuhibbah_pelapor_jawatan',
                                            'spk__imuhibbah.imuhibbah_pelapor_alamat',
                                            'spk__imuhibbah.status',
                                            'spk__imuhibbah.dihantar_by',
                                            'spk__imuhibbah.diakui_by',
                                            'spk__imuhibbah.disemak_by',
                                            'spk__imuhibbah.disahkan_by',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon',
                                            'spk__imuhibbah.diakui_note AS diakui_note',
                                            'spk__imuhibbah.disemak_note AS disemak_note',
                                            'spk__imuhibbah.disahkan_note AS disahkan_note'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__imuhibbah.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__imuhibbah.krt_profile_id')
                                    ->where('spk__imuhibbah.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm22.sahkan-permohonan-muhibbah-p', compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt','imuhibbah'));
        }
    }

    function post_sahkan_permohonan_imuhibbah(Request $request){
        $action = $request->post_sahkan_permohonan_imuhibbah;
        $app_id = $request->spmph_spk_imuhibbah_id;
        
        
        $rules = array(
            'spmph_imuhibbah_status'            => 'required',
            'spmph_disahkan_note'               => 'required',
        );

        $messages = [
            'spmph_imuhibbah_status.required'   => 'Ruangan Status dipilih',
            'spmph_disahkan_note.required'      => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $sahkan_permohonan_imuhibbah                   = SPK_imuhibbah::where($where)->first();
                $sahkan_permohonan_imuhibbah->status           = $request->spmph_imuhibbah_status;
                $sahkan_permohonan_imuhibbah->disahkan_by      = Auth::user()->user_id;
                $sahkan_permohonan_imuhibbah->disahkan_date    = date('Y-m-d H:i:s');
                $sahkan_permohonan_imuhibbah->disahkan_note    = $request->spmph_disahkan_note;
                $sahkan_permohonan_imuhibbah->save();
            }
        }
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function senarai_permohonan_muhibbah_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('spk__imuhibbah')
                        ->select('spk__imuhibbah.id AS id',
                                'spk__imuhibbah.imuhibbah_tajuk AS imuhibbah_tajuk',
                                DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_laporan,'%d/%m/%Y') AS imuhibbah_tarikh_laporan"),
                                DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_j_berlaku,'%d/%m/%Y') AS imuhibbah_tarikh_j_berlaku"),
                                'users__profile.user_fullname AS user_fullname',
                                'spk__imuhibbah.status AS status',
                                'ref__status_spk_imuhibbah.status_description AS status_description')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imuhibbah.dihantar_by')
                        ->leftJoin('ref__status_spk_imuhibbah','ref__status_spk_imuhibbah.id','=','spk__imuhibbah.status')
                        ->where('spk__imuhibbah.dihantar_by', '=', Auth::user()->user_id)
                        ->whereIN('spk__imuhibbah.status',[2,9,10,11,12])
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
            return view('rt-sm22.senarai-permohonan-muhibbah-ppn',compact('roles_menu'));
        }
    }

    function post_permohonan_imuhibbah_ppn(Request $request){
        
        $action = $request->post_permohonan_imuhibbah_ppn;
        
        $rules = array(
           
        );

        $messages = [
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm22.senarai_permohonan_muhibbah_ppn'))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'add') {
                $imuhibbah_ppn               = new SPK_imuhibbah;
                $imuhibbah_ppn->status       = 2;
                $imuhibbah_ppn->dihantar_by  = Auth::user()->user_id;
                $imuhibbah_ppn->save();
            }
           
            return Redirect::to(route('rt-sm22.permohonan_muhibbah_ppn',$imuhibbah_ppn->id));
        }

    }

    function permohonan_muhibbah_ppn(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_bandar') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = RefBandar::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = KRT_Profile::where($where)
                        ->where('krt__profile.krt_status', '=',  true)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_parlimen') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefParlimen::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_dun') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDUN::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_pbt') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefPBT::where($where)->get();
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
            $negeri                 = RefStates::where('status', '=', true)->get();
            $daerah                 = RefDaerah::where('status', '=', true)->get();
            $bandar                 = RefBandar::where('status', '=', true)->get();
            $parlimen               = RefParlimen::where('status', '=', true)->get();
            $dun                    = RefDUN::where('status', '=', true)->get();
            $pbt                    = RefPBT::where('status', '=', true)->get();
            $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
            $imuhibbah              = DB::table('spk__imuhibbah')
                                    ->select('spk__imuhibbah.id',
                                            'spk__imuhibbah.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__imuhibbah.krt_profile_id',
                                            'spk__imuhibbah.imuhibbah_tajuk',
                                            'spk__imuhibbah.state_id',
                                            'spk__imuhibbah.daerah_id',
                                            'spk__imuhibbah.bandar_id',
                                            'spk__imuhibbah.imuhibbah_kawasan',
                                            'spk__imuhibbah.imuhibbah_lokasi',
                                            'spk__imuhibbah.imuhibbah_poskod',
                                            'spk__imuhibbah.parlimen_id',
                                            'spk__imuhibbah.dun_id',
                                            'spk__imuhibbah.pbt_id',
                                            DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_laporan,'%d/%m/%Y') AS imuhibbah_tarikh_laporan"),
                                            DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_j_berlaku,'%d/%m/%Y') AS imuhibbah_tarikh_j_berlaku"),
                                            'spk__imuhibbah.imuhibbah_laporan',
                                            'spk__imuhibbah.imuhibbah_sumber_maklumat',
                                            'spk__imuhibbah.imuhibbah_pelapor_nama',
                                            'spk__imuhibbah.imuhibbah_pelapor_no',
                                            'spk__imuhibbah.imuhibbah_pelapor_jawatan',
                                            'spk__imuhibbah.imuhibbah_pelapor_alamat',
                                            'spk__imuhibbah.status',
                                            'spk__imuhibbah.dihantar_by',
                                            'spk__imuhibbah.diakui_by',
                                            'spk__imuhibbah.disemak_by',
                                            'spk__imuhibbah.disahkan_by',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon',
                                            'spk__imuhibbah.diakui_note AS diakui_note',
                                            'spk__imuhibbah.disemak_note AS disemak_note',
                                            'spk__imuhibbah.disahkan_note AS disahkan_note',
                                            'ref__status_spk_imuhibbah.status_description AS status_description'
                                            )
                                    ->leftJoin('ref__status_spk_imuhibbah','ref__status_spk_imuhibbah.id','=','spk__imuhibbah.status')
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__imuhibbah.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__imuhibbah.krt_profile_id')
                                    ->where('spk__imuhibbah.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm22.permohonan-muhibbah-ppn', compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt','imuhibbah'));
        }
    }

    function post_permohonan_imuhibbah_ppn_1(Request $request){
        $action = $request->post_permohonan_imuhibbah_ppn_1;
        $app_id = $request->pmpn3_imuhibbah_id;
        $hasKRT = $request->pmpn_hasRT;

        if ($hasKRT == '1') {
            $rules_main = array(                
                'pmpn_state_id'                         => 'required',
                'pmpn_daerah_id'                        => 'required',
                'pmpn_krt_profile_id'                   => 'required',
                'pmpn2_imuhibbah_tajuk'                 => 'required',
                'pmpn2_state_id'                        => 'required',
                'pmpn2_bandar_id'                       => 'required',
                'pmpn2_imuhibbah_lokasi'                => 'required',
                'pmpn2_parlimen_id'                     => 'required',
                'pmpn2_pbt_id'                          => 'required',
                'pmpn2_daerah_id'                       => 'required',
                'pmpn2_imuhibbah_kawasan'               => 'required',
                'pmpn2_imuhibbah_poskod'                => 'required',
                'pmpn2_dun_id'                          => 'required',
                'pmpn2_imuhibbah_tarikh_laporan'        => 'required',
                'pmpn2_imuhibbah_tarikh_j_berlaku'      => 'required',
                'pmpn2_imuhibbah_laporan'               => 'required',
                'pmpn2_imuhibbah_sumber_maklumat'       => 'required',
                'pmpn2_imuhibbah_pelapor_nama'          => 'required',
                'pmpn2_imuhibbah_pelapor_no'            => 'required',
                'pmpn2_imuhibbah_pelapor_jawatan'       => 'required',
                'pmpn2_imuhibbah_pelapor_alamat'        => 'required',
            );
        } else {
            $rules_main = array(
                'pmpn2_imuhibbah_tajuk'                 => 'required',
                'pmpn2_state_id'                        => 'required',
                'pmpn2_bandar_id'                       => 'required',
                'pmpn2_imuhibbah_lokasi'                => 'required',
                'pmpn2_parlimen_id'                     => 'required',
                'pmpn2_pbt_id'                          => 'required',
                'pmpn2_daerah_id'                       => 'required',
                'pmpn2_imuhibbah_kawasan'               => 'required',
                'pmpn2_imuhibbah_poskod'                => 'required',
                'pmpn2_dun_id'                          => 'required',
                'pmpn2_imuhibbah_tarikh_laporan'        => 'required',
                'pmpn2_imuhibbah_tarikh_j_berlaku'      => 'required',
                'pmpn2_imuhibbah_laporan'               => 'required',
                'pmpn2_imuhibbah_sumber_maklumat'       => 'required',
                'pmpn2_imuhibbah_pelapor_nama'          => 'required',
                'pmpn2_imuhibbah_pelapor_no'            => 'required',
                'pmpn2_imuhibbah_pelapor_jawatan'       => 'required',
                'pmpn2_imuhibbah_pelapor_alamat'        => 'required',
            );
        }
        
        $messages = [
            'pmpn_state_id.required'                    => 'Ruangan Negeri mesti dipilih',
            'pmpn_daerah_id.required'                   => 'Ruangan Daerah mesti dipilih',
            'pmpn_krt_profile_id.required'              => 'Ruangan Nama KRT mesti dipilih',
            'pmpn2_imuhibbah_tajuk.required'            => 'Ruangan Tajuk mesti diisi',
            'pmpn2_state_id.required'                   => 'Ruangan Negeri mesti dipilih',
            'pmpn2_bandar_id.required'                  => 'Ruangan Bandar mesti dipilih',
            'pmpn2_imuhibbah_lokasi.required'           => 'Ruangan Lokasi /  Nama Jalan mesti diisi',
            'pmpn2_parlimen_id.required'                => 'Ruangan Parlimen mesti dipilih',
            'pmpn2_pbt_id.required'                     => 'Ruangan PBT mesti dipilih',
            'pmpn2_daerah_id.required'                  => 'Ruangan Daerah mesti dipilih',
            'pmpn2_imuhibbah_kawasan.required'          => 'Ruangan Taman / Kampung mesti diisi',
            'pmpn2_imuhibbah_poskod.required'           => 'Ruangan Poskod mesti diisi',
            'pmpn2_dun_id.required'                     => 'Ruangan Dun mesti dipilih',
            'pmpn2_imuhibbah_tarikh_laporan.required'   => 'Ruangan Tarikh Laporan mesti dipilih',
            'pmpn2_imuhibbah_tarikh_j_berlaku.required' => 'Ruangan Tarikh Jangkaan Berlaku mesti dipilih',
            'pmpn2_imuhibbah_laporan.required'          => 'Ruangan Laporan mesti diisi',
            'pmpn2_imuhibbah_sumber_maklumat.required'  => 'Ruangan Sumber Maklumat Kes mesti diisi',
            'pmpn2_imuhibbah_pelapor_nama.required'     => 'Ruangan Nama Pelapor mesti diisi',
            'pmpn2_imuhibbah_pelapor_no.required'       => 'Ruangan No Telefon Pelapor mesti diisi',
            'pmpn2_imuhibbah_pelapor_jawatan.required'  => 'Ruangan Jawatan Pelapor mesti diisi',
            'pmpn2_imuhibbah_pelapor_alamat.required'   => 'Ruangan Alamat Pelapor mesti diisi',
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $carbon_obj                                     = Carbon::createFromFormat('d/m/Y', $request->pmpn2_imuhibbah_tarikh_laporan)->format('Y-m-d');
                $carbon_obj_1                                   = Carbon::createFromFormat('d/m/Y', $request->pmpn2_imuhibbah_tarikh_j_berlaku)->format('Y-m-d');
                $update_imuhibbah_ppn                               = SPK_imuhibbah::where($where)->first();
                $update_imuhibbah_ppn->hasRT                        = $hasKRT;
                $update_imuhibbah_ppn->krt_profile_id               = $request->pmpn_krt_profile_id;
                $update_imuhibbah_ppn->imuhibbah_tajuk              = $request->pmpn2_imuhibbah_tajuk;
                $update_imuhibbah_ppn->state_id                     = $request->pmpn2_state_id;
                $update_imuhibbah_ppn->daerah_id                    = $request->pmpn2_daerah_id;
                $update_imuhibbah_ppn->bandar_id                    = $request->pmpn2_bandar_id;
                $update_imuhibbah_ppn->imuhibbah_kawasan            = $request->pmpn2_imuhibbah_kawasan;
                $update_imuhibbah_ppn->imuhibbah_lokasi             = $request->pmpn2_imuhibbah_lokasi;
                $update_imuhibbah_ppn->imuhibbah_poskod             = $request->pmpn2_imuhibbah_poskod;
                $update_imuhibbah_ppn->parlimen_id                  = $request->pmpn2_parlimen_id;
                $update_imuhibbah_ppn->dun_id                       = $request->pmpn2_dun_id;
                $update_imuhibbah_ppn->pbt_id                       = $request->pmpn2_pbt_id;
                $update_imuhibbah_ppn->imuhibbah_tarikh_laporan     = $carbon_obj;
                $update_imuhibbah_ppn->imuhibbah_tarikh_j_berlaku   = $carbon_obj_1;
                $update_imuhibbah_ppn->imuhibbah_laporan            = $request->pmpn2_imuhibbah_laporan;
                $update_imuhibbah_ppn->imuhibbah_sumber_maklumat    = $request->pmpn2_imuhibbah_sumber_maklumat;
                $update_imuhibbah_ppn->imuhibbah_pelapor_nama       = $request->pmpn2_imuhibbah_pelapor_nama;
                $update_imuhibbah_ppn->imuhibbah_pelapor_no         = $request->pmpn2_imuhibbah_pelapor_no;
                $update_imuhibbah_ppn->imuhibbah_pelapor_jawatan    = $request->pmpn2_imuhibbah_pelapor_jawatan;
                $update_imuhibbah_ppn->imuhibbah_pelapor_alamat     = $request->pmpn2_imuhibbah_pelapor_alamat;
                $update_imuhibbah_ppn->status                       = 9;
                $update_imuhibbah_ppn->dihantar_date                = date('Y-m-d H:i:s');
                $update_imuhibbah_ppn->save();
                
            }
        }
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function senarai_permohonan_muhibbah_bpp(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('spk__imuhibbah')
                        ->select('spk__imuhibbah.id AS id',
                                'spk__imuhibbah.imuhibbah_tajuk AS imuhibbah_tajuk',
                                DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_laporan,'%d/%m/%Y') AS imuhibbah_tarikh_laporan"),
                                DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_j_berlaku,'%d/%m/%Y') AS imuhibbah_tarikh_j_berlaku"),
                                'users__profile.user_fullname AS user_fullname',
                                'spk__imuhibbah.status AS status',
                                'ref__status_spk_imuhibbah.status_description AS status_description')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imuhibbah.dihantar_by')
                        ->leftJoin('ref__status_spk_imuhibbah','ref__status_spk_imuhibbah.id','=','spk__imuhibbah.status')
                        ->where('spk__imuhibbah.dihantar_by', '=', Auth::user()->user_id)
                        ->whereIN('spk__imuhibbah.status',[2,13,14,15])
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
            return view('rt-sm22.senarai-permohonan-muhibbah-bpp',compact('roles_menu'));
        }
    }

    function post_permohonan_imuhibbah_bpp(Request $request){
        
        $action = $request->post_permohonan_imuhibbah_bpp;
        
        $rules = array(
           
        );

        $messages = [
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm22.senarai_permohonan_muhibbah_bpp'))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'add') {
                $imuhibbah_bpp               = new SPK_imuhibbah;
                $imuhibbah_bpp->status       = 2;
                $imuhibbah_bpp->dihantar_by  = Auth::user()->user_id;
                $imuhibbah_bpp->save();
            }
           
            return Redirect::to(route('rt-sm22.permohonan_muhibbah_bpp',$imuhibbah_bpp->id));
        }

    }

    function permohonan_muhibbah_bpp(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_bandar') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = RefBandar::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = KRT_Profile::where($where)
                        ->where('krt__profile.krt_status', '=',  true)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_parlimen') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefParlimen::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_dun') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDUN::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_pbt') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefPBT::where($where)->get();
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
            $negeri                 = RefStates::where('status', '=', true)->get();
            $daerah                 = RefDaerah::where('status', '=', true)->get();
            $bandar                 = RefBandar::where('status', '=', true)->get();
            $parlimen               = RefParlimen::where('status', '=', true)->get();
            $dun                    = RefDUN::where('status', '=', true)->get();
            $pbt                    = RefPBT::where('status', '=', true)->get();
            $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
            $imuhibbah              = DB::table('spk__imuhibbah')
                                    ->select('spk__imuhibbah.id',
                                            'spk__imuhibbah.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__imuhibbah.krt_profile_id',
                                            'spk__imuhibbah.imuhibbah_tajuk',
                                            'spk__imuhibbah.state_id',
                                            'spk__imuhibbah.daerah_id',
                                            'spk__imuhibbah.bandar_id',
                                            'spk__imuhibbah.imuhibbah_kawasan',
                                            'spk__imuhibbah.imuhibbah_lokasi',
                                            'spk__imuhibbah.imuhibbah_poskod',
                                            'spk__imuhibbah.parlimen_id',
                                            'spk__imuhibbah.dun_id',
                                            'spk__imuhibbah.pbt_id',
                                            DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_laporan,'%d/%m/%Y') AS imuhibbah_tarikh_laporan"),
                                            DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_j_berlaku,'%d/%m/%Y') AS imuhibbah_tarikh_j_berlaku"),
                                            'spk__imuhibbah.imuhibbah_laporan',
                                            'spk__imuhibbah.imuhibbah_sumber_maklumat',
                                            'spk__imuhibbah.imuhibbah_pelapor_nama',
                                            'spk__imuhibbah.imuhibbah_pelapor_no',
                                            'spk__imuhibbah.imuhibbah_pelapor_jawatan',
                                            'spk__imuhibbah.imuhibbah_pelapor_alamat',
                                            'spk__imuhibbah.status',
                                            'spk__imuhibbah.dihantar_by',
                                            'spk__imuhibbah.diakui_by',
                                            'spk__imuhibbah.disemak_by',
                                            'spk__imuhibbah.disahkan_by',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon',
                                            'spk__imuhibbah.diakui_note AS diakui_note',
                                            'spk__imuhibbah.disemak_note AS disemak_note',
                                            'spk__imuhibbah.disahkan_note AS disahkan_note',
                                            'ref__status_spk_imuhibbah.status_description AS status_description'
                                            )
                                    ->leftJoin('ref__status_spk_imuhibbah','ref__status_spk_imuhibbah.id','=','spk__imuhibbah.status')
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__imuhibbah.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__imuhibbah.krt_profile_id')
                                    ->where('spk__imuhibbah.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm22.permohonan-muhibbah-bpp', compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt','imuhibbah'));
        }
    }

    function post_permohonan_imuhibbah_bpp_1(Request $request){
        $action = $request->post_permohonan_imuhibbah_bpp_1;
        $app_id = $request->pmbpp3_imuhibbah_id;
        $hasKRT = $request->pmbpp_hasRT;

        if ($hasKRT == '1') {
            $rules_main = array(                
                'pmbpp_state_id'                         => 'required',
                'pmbpp_daerah_id'                        => 'required',
                'pmbpp_krt_profile_id'                   => 'required',
                'pmbpp2_imuhibbah_tajuk'                 => 'required',
                'pmbpp2_state_id'                        => 'required',
                'pmbpp2_bandar_id'                       => 'required',
                'pmbpp2_imuhibbah_lokasi'                => 'required',
                'pmbpp2_parlimen_id'                     => 'required',
                'pmbpp2_pbt_id'                          => 'required',
                'pmbpp2_daerah_id'                       => 'required',
                'pmbpp2_imuhibbah_kawasan'               => 'required',
                'pmbpp2_imuhibbah_poskod'                => 'required',
                'pmbpp2_dun_id'                          => 'required',
                'pmbpp2_imuhibbah_tarikh_laporan'        => 'required',
                'pmbpp2_imuhibbah_tarikh_j_berlaku'      => 'required',
                'pmbpp2_imuhibbah_laporan'               => 'required',
                'pmbpp2_imuhibbah_sumber_maklumat'       => 'required',
                'pmbpp2_imuhibbah_pelapor_nama'          => 'required',
                'pmbpp2_imuhibbah_pelapor_no'            => 'required',
                'pmbpp2_imuhibbah_pelapor_jawatan'       => 'required',
                'pmbpp2_imuhibbah_pelapor_alamat'        => 'required',
            );
        } else {
            $rules_main = array(
                'pmbpp2_imuhibbah_tajuk'                 => 'required',
                'pmbpp2_state_id'                        => 'required',
                'pmbpp2_bandar_id'                       => 'required',
                'pmbpp2_imuhibbah_lokasi'                => 'required',
                'pmbpp2_parlimen_id'                     => 'required',
                'pmbpp2_pbt_id'                          => 'required',
                'pmbpp2_daerah_id'                       => 'required',
                'pmbpp2_imuhibbah_kawasan'               => 'required',
                'pmbpp2_imuhibbah_poskod'                => 'required',
                'pmbpp2_dun_id'                          => 'required',
                'pmbpp2_imuhibbah_tarikh_laporan'        => 'required',
                'pmbpp2_imuhibbah_tarikh_j_berlaku'      => 'required',
                'pmbpp2_imuhibbah_laporan'               => 'required',
                'pmbpp2_imuhibbah_sumber_maklumat'       => 'required',
                'pmbpp2_imuhibbah_pelapor_nama'          => 'required',
                'pmbpp2_imuhibbah_pelapor_no'            => 'required',
                'pmbpp2_imuhibbah_pelapor_jawatan'       => 'required',
                'pmbpp2_imuhibbah_pelapor_alamat'        => 'required',
            );
        }
        
        $messages = [
            'pmbpp_state_id.required'                    => 'Ruangan Negeri mesti dipilih',
            'pmbpp_daerah_id.required'                   => 'Ruangan Daerah mesti dipilih',
            'pmbpp_krt_profile_id.required'              => 'Ruangan Nama KRT mesti dipilih',
            'pmbpp2_imuhibbah_tajuk.required'            => 'Ruangan Tajuk mesti diisi',
            'pmbpp2_state_id.required'                   => 'Ruangan Negeri mesti dipilih',
            'pmbpp2_bandar_id.required'                  => 'Ruangan Bandar mesti dipilih',
            'pmbpp2_imuhibbah_lokasi.required'           => 'Ruangan Lokasi /  Nama Jalan mesti diisi',
            'pmbpp2_parlimen_id.required'                => 'Ruangan Parlimen mesti dipilih',
            'pmbpp2_pbt_id.required'                     => 'Ruangan PBT mesti dipilih',
            'pmbpp2_daerah_id.required'                  => 'Ruangan Daerah mesti dipilih',
            'pmbpp2_imuhibbah_kawasan.required'          => 'Ruangan Taman / Kampung mesti diisi',
            'pmbpp2_imuhibbah_poskod.required'           => 'Ruangan Poskod mesti diisi',
            'pmbpp2_dun_id.required'                     => 'Ruangan Dun mesti dipilih',
            'pmbpp2_imuhibbah_tarikh_laporan.required'   => 'Ruangan Tarikh Laporan mesti dipilih',
            'pmbpp2_imuhibbah_tarikh_j_berlaku.required' => 'Ruangan Tarikh Jangkaan Berlaku mesti dipilih',
            'pmbpp2_imuhibbah_laporan.required'          => 'Ruangan Laporan mesti diisi',
            'pmbpp2_imuhibbah_sumber_maklumat.required'  => 'Ruangan Sumber Maklumat Kes mesti diisi',
            'pmbpp2_imuhibbah_pelapor_nama.required'     => 'Ruangan Nama Pelapor mesti diisi',
            'pmbpp2_imuhibbah_pelapor_no.required'       => 'Ruangan No Telefon Pelapor mesti diisi',
            'pmbpp2_imuhibbah_pelapor_jawatan.required'  => 'Ruangan Jawatan Pelapor mesti diisi',
            'pmbpp2_imuhibbah_pelapor_alamat.required'   => 'Ruangan Alamat Pelapor mesti diisi',
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $carbon_obj                                     = Carbon::createFromFormat('d/m/Y', $request->pmbpp2_imuhibbah_tarikh_laporan)->format('Y-m-d');
                $carbon_obj_1                                   = Carbon::createFromFormat('d/m/Y', $request->pmbpp2_imuhibbah_tarikh_j_berlaku)->format('Y-m-d');
                $update_imuhibbah_bpp                               = SPK_imuhibbah::where($where)->first();
                $update_imuhibbah_bpp->hasRT                        = $hasKRT;
                $update_imuhibbah_bpp->krt_profile_id               = $request->pmbpp_krt_profile_id;
                $update_imuhibbah_bpp->imuhibbah_tajuk              = $request->pmbpp2_imuhibbah_tajuk;
                $update_imuhibbah_bpp->state_id                     = $request->pmbpp2_state_id;
                $update_imuhibbah_bpp->daerah_id                    = $request->pmbpp2_daerah_id;
                $update_imuhibbah_bpp->bandar_id                    = $request->pmbpp2_bandar_id;
                $update_imuhibbah_bpp->imuhibbah_kawasan            = $request->pmbpp2_imuhibbah_kawasan;
                $update_imuhibbah_bpp->imuhibbah_lokasi             = $request->pmbpp2_imuhibbah_lokasi;
                $update_imuhibbah_bpp->imuhibbah_poskod             = $request->pmbpp2_imuhibbah_poskod;
                $update_imuhibbah_bpp->parlimen_id                  = $request->pmbpp2_parlimen_id;
                $update_imuhibbah_bpp->dun_id                       = $request->pmbpp2_dun_id;
                $update_imuhibbah_bpp->pbt_id                       = $request->pmbpp2_pbt_id;
                $update_imuhibbah_bpp->imuhibbah_tarikh_laporan     = $carbon_obj;
                $update_imuhibbah_bpp->imuhibbah_tarikh_j_berlaku   = $carbon_obj_1;
                $update_imuhibbah_bpp->imuhibbah_laporan            = $request->pmbpp2_imuhibbah_laporan;
                $update_imuhibbah_bpp->imuhibbah_sumber_maklumat    = $request->pmbpp2_imuhibbah_sumber_maklumat;
                $update_imuhibbah_bpp->imuhibbah_pelapor_nama       = $request->pmbpp2_imuhibbah_pelapor_nama;
                $update_imuhibbah_bpp->imuhibbah_pelapor_no         = $request->pmbpp2_imuhibbah_pelapor_no;
                $update_imuhibbah_bpp->imuhibbah_pelapor_jawatan    = $request->pmbpp2_imuhibbah_pelapor_jawatan;
                $update_imuhibbah_bpp->imuhibbah_pelapor_alamat     = $request->pmbpp2_imuhibbah_pelapor_alamat;
                $update_imuhibbah_bpp->status                       = 13;
                $update_imuhibbah_bpp->dihantar_date                = date('Y-m-d H:i:s');
                $update_imuhibbah_bpp->save();
                
            }
        }
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function senarai_at_imuhibbah_p(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_description' => $value);
                $data  = DB::table('ref__daerahs')
                        ->select('ref__daerahs.id', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__daerahs.state_id')
                        ->where('ref__states.state_description', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('spk__imuhibbah')
                        ->select('spk__imuhibbah.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'spk__imuhibbah.imuhibbah_tajuk AS imuhibbah_tajuk',
                                DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_laporan,'%d/%m/%Y') AS imuhibbah_tarikh_laporan"),
                                DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_j_berlaku,'%d/%m/%Y') AS imuhibbah_tarikh_j_berlaku"),
                                'users__profile.user_fullname AS user_fullname',
                                'spk__imuhibbah.status AS status',
                                'ref__status_spk_imuhibbah.status_description AS status_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','spk__imuhibbah.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','spk__imuhibbah.daerah_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imuhibbah.dihantar_by')
                        ->leftJoin('ref__status_spk_imuhibbah','ref__status_spk_imuhibbah.id','=','spk__imuhibbah.status')
                        ->leftJoin('spk__imuhibbah_at','spk__imuhibbah_at.spk_imuhibbah_id','=','spk__imuhibbah.id')
                        ->where('spk__imuhibbah_at.id','=', null)
                        ->whereIN('spk__imuhibbah.status',[1])
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
            $jenis_tindakan     = Ref_SPK_iKes_AT_Jenis::where('status', '=', true)->get();
            return view('rt-sm22.senarai-at-imuhibbah-p', compact('roles_menu','state','jenis_tindakan'));
        }
    }

    function paparan_pelaporan_imuhibbah_p(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_bandar') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = RefBandar::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = KRT_Profile::where($where)
                        ->where('krt__profile.krt_status', '=',  true)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_parlimen') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefParlimen::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_dun') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDUN::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_pbt') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefPBT::where($where)->get();
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
            $negeri                 = RefStates::where('status', '=', true)->get();
            $daerah                 = RefDaerah::where('status', '=', true)->get();
            $bandar                 = RefBandar::where('status', '=', true)->get();
            $parlimen               = RefParlimen::where('status', '=', true)->get();
            $dun                    = RefDUN::where('status', '=', true)->get();
            $pbt                    = RefPBT::where('status', '=', true)->get();
            $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
            $imuhibbah              = DB::table('spk__imuhibbah')
                                    ->select('spk__imuhibbah.id',
                                            'spk__imuhibbah.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__imuhibbah.krt_profile_id',
                                            'spk__imuhibbah.imuhibbah_tajuk',
                                            'spk__imuhibbah.state_id',
                                            'spk__imuhibbah.daerah_id',
                                            'spk__imuhibbah.bandar_id',
                                            'spk__imuhibbah.imuhibbah_kawasan',
                                            'spk__imuhibbah.imuhibbah_lokasi',
                                            'spk__imuhibbah.imuhibbah_poskod',
                                            'spk__imuhibbah.parlimen_id',
                                            'spk__imuhibbah.dun_id',
                                            'spk__imuhibbah.pbt_id',
                                            DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_laporan,'%d/%m/%Y') AS imuhibbah_tarikh_laporan"),
                                            DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_j_berlaku,'%d/%m/%Y') AS imuhibbah_tarikh_j_berlaku"),
                                            'spk__imuhibbah.imuhibbah_laporan',
                                            'spk__imuhibbah.imuhibbah_sumber_maklumat',
                                            'spk__imuhibbah.imuhibbah_pelapor_nama',
                                            'spk__imuhibbah.imuhibbah_pelapor_no',
                                            'spk__imuhibbah.imuhibbah_pelapor_jawatan',
                                            'spk__imuhibbah.imuhibbah_pelapor_alamat',
                                            'spk__imuhibbah.status',
                                            'spk__imuhibbah.dihantar_by',
                                            'spk__imuhibbah.diakui_by',
                                            'spk__imuhibbah.disemak_by',
                                            'spk__imuhibbah.disahkan_by',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon',
                                            'spk__imuhibbah.diakui_note AS diakui_note',
                                            'spk__imuhibbah.disemak_note AS disemak_note',
                                            'spk__imuhibbah.disahkan_note AS disahkan_note'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__imuhibbah.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__imuhibbah.krt_profile_id')
                                    ->where('spk__imuhibbah.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm22.paparan-pelaporan-imuhibbah-p', compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt','imuhibbah'));
        }
    }

    function post_add_at_imuhibbah_p(Request $request){
        $action = $request->post_add_at_imuhibbah_p;
        $app_id = $request->matip_imuhibbah_id;
        
        $rules = array(
            'matip_tempoh_tindakan'             => 'required',
            'matip_tarikh_arahan'               => 'required',
            'matip_jenis_arahan_id'             => 'required',
        );

        $messages = [
            'matip_tempoh_tindakan.required'    => 'Ruangan Tempoh Tindakan mesti dipilih',
            'matip_tarikh_arahan.required'      => 'Ruangan Tarikh Arahan mesti diisi',
            'matip_jenis_arahan_id.required'    => 'Ruangan Jenis Premis mesti dipilih',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $carbon_obj = Carbon::createFromFormat('d/m/Y', $request->matip_tarikh_arahan)->format('Y-m-d');
                $at_imuhibbah = new SPK_iMuhibbah_AT;
                $at_imuhibbah->spk_imuhibbah_id         = $app_id;
                $at_imuhibbah->tempoh_tindakan          = $request->matip_tempoh_tindakan;
                $at_imuhibbah->tarikh_arahan            = $carbon_obj;
                $at_imuhibbah->jenis_arahan_id          = $request->matip_jenis_arahan_id;
                $at_imuhibbah->tindakan_kepada_ppn      = $request->matip_tindakan_kepada_ppn;
                $at_imuhibbah->tindakan_kepada_ppd      = $request->matip_tindakan_kepada_ppd;
                $at_imuhibbah->arahan_by                = Auth::user()->user_id;
                $at_imuhibbah->save();
                
            }
        }
    }

    function senarai_ts_imuhibbah_p(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_description' => $value);
                $data  = DB::table('ref__daerahs')
                        ->select('ref__daerahs.id', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__daerahs.state_id')
                        ->where('ref__states.state_description', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('spk__imuhibbah_at')
                        ->select('spk__imuhibbah_at.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'spk__imuhibbah.imuhibbah_tajuk AS imuhibbah_tajuk',
                                DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_laporan,'%d/%m/%Y') AS imuhibbah_tarikh_laporan"),
                                DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_j_berlaku,'%d/%m/%Y') AS imuhibbah_tarikh_j_berlaku"),
                                'ref__roles_users.long_description AS long_description')
                        ->leftJoin('spk__imuhibbah','spk__imuhibbah.id','=','spk__imuhibbah_at.spk_imuhibbah_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','spk__imuhibbah.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','spk__imuhibbah.daerah_id')
                        ->leftJoin('users','users.user_id','=','spk__imuhibbah_at.arahan_by')
                        ->leftJoin('ref__roles_users','ref__roles_users.id','=','users.user_role')
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
            $jenis_tindakan     = Ref_SPK_iKes_AT_Jenis::where('status', '=', true)->get();
            return view('rt-sm22.senarai-ts-imuhibbah-p', compact('roles_menu','state', 'jenis_tindakan'));
        }
    }

    function paparan_pelaporan_imuhibbah_ts_p(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_bandar') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = RefBandar::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = KRT_Profile::where($where)
                        ->where('krt__profile.krt_status', '=',  true)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_parlimen') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefParlimen::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_dun') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDUN::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_pbt') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefPBT::where($where)->get();
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
            $negeri                 = RefStates::where('status', '=', true)->get();
            $daerah                 = RefDaerah::where('status', '=', true)->get();
            $bandar                 = RefBandar::where('status', '=', true)->get();
            $parlimen               = RefParlimen::where('status', '=', true)->get();
            $dun                    = RefDUN::where('status', '=', true)->get();
            $pbt                    = RefPBT::where('status', '=', true)->get();
            $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
            $imuhibbah              = DB::table('spk__imuhibbah')
                                    ->select('spk__imuhibbah.id',
                                            'spk__imuhibbah.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__imuhibbah.krt_profile_id',
                                            'spk__imuhibbah.imuhibbah_tajuk',
                                            'spk__imuhibbah.state_id',
                                            'spk__imuhibbah.daerah_id',
                                            'spk__imuhibbah.bandar_id',
                                            'spk__imuhibbah.imuhibbah_kawasan',
                                            'spk__imuhibbah.imuhibbah_lokasi',
                                            'spk__imuhibbah.imuhibbah_poskod',
                                            'spk__imuhibbah.parlimen_id',
                                            'spk__imuhibbah.dun_id',
                                            'spk__imuhibbah.pbt_id',
                                            DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_laporan,'%d/%m/%Y') AS imuhibbah_tarikh_laporan"),
                                            DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_j_berlaku,'%d/%m/%Y') AS imuhibbah_tarikh_j_berlaku"),
                                            'spk__imuhibbah.imuhibbah_laporan',
                                            'spk__imuhibbah.imuhibbah_sumber_maklumat',
                                            'spk__imuhibbah.imuhibbah_pelapor_nama',
                                            'spk__imuhibbah.imuhibbah_pelapor_no',
                                            'spk__imuhibbah.imuhibbah_pelapor_jawatan',
                                            'spk__imuhibbah.imuhibbah_pelapor_alamat',
                                            'spk__imuhibbah.status',
                                            'spk__imuhibbah.dihantar_by',
                                            'spk__imuhibbah.diakui_by',
                                            'spk__imuhibbah.disemak_by',
                                            'spk__imuhibbah.disahkan_by',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon',
                                            'spk__imuhibbah.diakui_note AS diakui_note',
                                            'spk__imuhibbah.disemak_note AS disemak_note',
                                            'spk__imuhibbah.disahkan_note AS disahkan_note'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__imuhibbah.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__imuhibbah.krt_profile_id')
                                    ->where('spk__imuhibbah.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm22.paparan-pelaporan-imuhibbah-ts-p', compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt','imuhibbah'));
        }
    }

    function get_view_ts_imuhibbah_p($id){
        $data = DB::table('spk__imuhibbah_at')
                ->select('spk__imuhibbah_at.id', 
                    'spk__imuhibbah_at.spk_imuhibbah_id AS spk_imuhibbah_id',
                    'spk__imuhibbah_at.tempoh_tindakan AS tempoh_tindakan',
                    DB::raw(" DATE_FORMAT(spk__imuhibbah_at.tarikh_arahan,'%d/%m/%Y') AS tarikh_arahan"),
                    'spk__imuhibbah_at.jenis_arahan_id AS jenis_arahan_id',
                    'spk__imuhibbah_at.tindakan_kepada_ppn AS tindakan_kepada_ppn',
                    'spk__imuhibbah_at.tindakan_kepada_ppd AS tindakan_kepada_ppd')
                ->join('ref__spk_ikes_at_jenis','ref__spk_ikes_at_jenis.id','=','spk__imuhibbah_at.jenis_arahan_id')
                ->where('spk__imuhibbah_at.id', '=', $id)
                ->first();
        return Response::json($data);
    }

    function get_view_ts_table(Request $request, $id){
        $data = DB::table('spk__imuhibbah_ts')
                ->select('spk__imuhibbah_ts.id', 
                'spk__imuhibbah_ts.spk_imuhibbah_at_id',
                DB::raw(" DATE_FORMAT(spk__imuhibbah_ts.tarikh_tindakan,'%d/%m/%Y') AS tarikh_tindakan"),
                'spk__imuhibbah_ts.keterangan_tindakan',
                'ref__roles_users.long_description AS long_description')
                ->leftJoin('users','users.user_id','=','spk__imuhibbah_ts.tindakan_susulan_by')
                ->leftJoin('ref__roles_users','ref__roles_users.id','=','users.user_role')
                ->where('spk__imuhibbah_ts.spk_imuhibbah_at_id', '=', $id)
                ->get();
        return Datatables::of($data)
                ->make(true);
    }

    function senarai_ts_imuhibbah_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('spk__imuhibbah_at')
                        ->select('spk__imuhibbah_at.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'spk__imuhibbah.imuhibbah_tajuk AS imuhibbah_tajuk',
                                DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_laporan,'%d/%m/%Y') AS imuhibbah_tarikh_laporan"),
                                DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_j_berlaku,'%d/%m/%Y') AS imuhibbah_tarikh_j_berlaku"),
                                DB::raw(" DATE_FORMAT(spk__imuhibbah_at.tarikh_arahan,'%d/%m/%Y') AS tarikh_arahan"),
                                'ref__roles_users.long_description AS long_description')
                        ->leftJoin('spk__imuhibbah','spk__imuhibbah.id','=','spk__imuhibbah_at.spk_imuhibbah_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','spk__imuhibbah.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','spk__imuhibbah.daerah_id')
                        ->leftJoin('users','users.user_id','=','spk__imuhibbah_at.arahan_by')
                        ->leftJoin('ref__roles_users','ref__roles_users.id','=','users.user_role')
                        ->where('spk__imuhibbah_at.tindakan_kepada_ppd', '=', 1)    
                        ->where('spk__imuhibbah.daerah_id', '=', Auth::user()->daerah_id)
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
            $jenis_tindakan     = Ref_SPK_iKes_AT_Jenis::where('status', '=', true)->get();
            return view('rt-sm22.senarai-ts-imuhibbah-ppd', compact('roles_menu','jenis_tindakan'));
        }
    }

    function paparan_pelaporan_imuhibbah_ts_ppd(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_bandar') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = RefBandar::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = KRT_Profile::where($where)
                        ->where('krt__profile.krt_status', '=',  true)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_parlimen') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefParlimen::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_dun') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDUN::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_pbt') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefPBT::where($where)->get();
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
            $negeri                 = RefStates::where('status', '=', true)->get();
            $daerah                 = RefDaerah::where('status', '=', true)->get();
            $bandar                 = RefBandar::where('status', '=', true)->get();
            $parlimen               = RefParlimen::where('status', '=', true)->get();
            $dun                    = RefDUN::where('status', '=', true)->get();
            $pbt                    = RefPBT::where('status', '=', true)->get();
            $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
            $imuhibbah              = DB::table('spk__imuhibbah')
                                    ->select('spk__imuhibbah.id',
                                            'spk__imuhibbah.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__imuhibbah.krt_profile_id',
                                            'spk__imuhibbah.imuhibbah_tajuk',
                                            'spk__imuhibbah.state_id',
                                            'spk__imuhibbah.daerah_id',
                                            'spk__imuhibbah.bandar_id',
                                            'spk__imuhibbah.imuhibbah_kawasan',
                                            'spk__imuhibbah.imuhibbah_lokasi',
                                            'spk__imuhibbah.imuhibbah_poskod',
                                            'spk__imuhibbah.parlimen_id',
                                            'spk__imuhibbah.dun_id',
                                            'spk__imuhibbah.pbt_id',
                                            DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_laporan,'%d/%m/%Y') AS imuhibbah_tarikh_laporan"),
                                            DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_j_berlaku,'%d/%m/%Y') AS imuhibbah_tarikh_j_berlaku"),
                                            'spk__imuhibbah.imuhibbah_laporan',
                                            'spk__imuhibbah.imuhibbah_sumber_maklumat',
                                            'spk__imuhibbah.imuhibbah_pelapor_nama',
                                            'spk__imuhibbah.imuhibbah_pelapor_no',
                                            'spk__imuhibbah.imuhibbah_pelapor_jawatan',
                                            'spk__imuhibbah.imuhibbah_pelapor_alamat',
                                            'spk__imuhibbah.status',
                                            'spk__imuhibbah.dihantar_by',
                                            'spk__imuhibbah.diakui_by',
                                            'spk__imuhibbah.disemak_by',
                                            'spk__imuhibbah.disahkan_by',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon',
                                            'spk__imuhibbah.diakui_note AS diakui_note',
                                            'spk__imuhibbah.disemak_note AS disemak_note',
                                            'spk__imuhibbah.disahkan_note AS disahkan_note'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__imuhibbah.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__imuhibbah.krt_profile_id')
                                    ->where('spk__imuhibbah.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm22.paparan-pelaporan-imuhibbah-ts-ppd', compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt','imuhibbah'));
        }
    }

    function get_ts_imuhibbah_ppd(Request $request, $id){
        $data = DB::table('spk__imuhibbah_ts')
                ->select('spk__imuhibbah_ts.id', 
                'spk__imuhibbah_ts.spk_imuhibbah_at_id',
                DB::raw(" DATE_FORMAT(spk__imuhibbah_ts.tarikh_tindakan,'%d/%m/%Y') AS tarikh_tindakan"),
                'spk__imuhibbah_ts.keterangan_tindakan',
                'ref__roles_users.long_description AS role_description')
                ->leftJoin('users','users.user_id','=','spk__imuhibbah_ts.tindakan_susulan_by')
                ->leftJoin('ref__roles_users','ref__roles_users.id','=','users.user_role')
                ->where('spk__imuhibbah_ts.spk_imuhibbah_at_id', '=', $id)
                
                ->get();
        return Datatables::of($data)
                ->make(true);
    }

    function post_add_ts_imuhibbah_ppd(Request $request){
        $action = $request->post_add_ts_imuhibbah_ppd;
        $app_id = $request->matmpd_spk_imuhibbah_id;
        
        $rules = array(
            'matmpd_tarikh_tindakan'                => 'required',
            'matmpd_keterangan_tindakan'            => 'required'
        );

        $messages = [
            'matmpd_tarikh_tindakan.required'       => 'Ruangan Jenis Premis mesti dipilih',
            'matmpd_keterangan_tindakan.required'   => 'Ruangan Alamat mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $carbon_obj = Carbon::createFromFormat('d/m/Y', $request->matmpd_tarikh_tindakan)->format('Y-m-d');
                $tindakan_susulan_ppd = new SPK_iMuhibbah_TS;
                $tindakan_susulan_ppd->spk_imuhibbah_at_id      = $app_id;
                $tindakan_susulan_ppd->tarikh_tindakan          = $carbon_obj;
                $tindakan_susulan_ppd->keterangan_tindakan      = $request->matmpd_keterangan_tindakan;
                $tindakan_susulan_ppd->tindakan_susulan_by      = Auth::user()->user_id;
                $tindakan_susulan_ppd->save();
                
            }
        }
    }

    function senarai_ts_imuhibbah_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('spk__imuhibbah_at')
                        ->select('spk__imuhibbah_at.id AS id',
                                'spk__imuhibbah.id AS spk_imuhibbah_id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'spk__imuhibbah.imuhibbah_tajuk AS imuhibbah_tajuk',
                                DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_laporan,'%d/%m/%Y') AS imuhibbah_tarikh_laporan"),
                                DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_j_berlaku,'%d/%m/%Y') AS imuhibbah_tarikh_j_berlaku"),
                                DB::raw(" DATE_FORMAT(spk__imuhibbah_at.tarikh_arahan,'%d/%m/%Y') AS tarikh_arahan"),
                                'ref__roles_users.long_description AS long_description')
                        ->leftJoin('spk__imuhibbah','spk__imuhibbah.id','=','spk__imuhibbah_at.spk_imuhibbah_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','spk__imuhibbah.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','spk__imuhibbah.daerah_id')
                        ->leftJoin('users','users.user_id','=','spk__imuhibbah_at.arahan_by')
                        ->leftJoin('ref__roles_users','ref__roles_users.id','=','users.user_role')
                        ->where('spk__imuhibbah_at.tindakan_kepada_ppn', '=', 1)    
                        ->where('spk__imuhibbah.state_id', '=', Auth::user()->state_id)
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
            $daerah         = RefDaerah::where('status', '=',  true)
                            ->where('ref__daerahs.state_id', '=', Auth::user()->state_id)    
                            ->get();
            $jenis_tindakan = Ref_SPK_iKes_AT_Jenis::where('status', '=', true)->get();
            return view('rt-sm22.senarai-ts-imuhibbah-ppn', compact('roles_menu','daerah', 'jenis_tindakan'));
        }
    }

    function paparan_pelaporan_imuhibbah_ts_ppn(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_bandar') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = RefBandar::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = KRT_Profile::where($where)
                        ->where('krt__profile.krt_status', '=',  true)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_parlimen') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefParlimen::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_dun') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDUN::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_pbt') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefPBT::where($where)->get();
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
            $negeri                 = RefStates::where('status', '=', true)->get();
            $daerah                 = RefDaerah::where('status', '=', true)->get();
            $bandar                 = RefBandar::where('status', '=', true)->get();
            $parlimen               = RefParlimen::where('status', '=', true)->get();
            $dun                    = RefDUN::where('status', '=', true)->get();
            $pbt                    = RefPBT::where('status', '=', true)->get();
            $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
            $imuhibbah              = DB::table('spk__imuhibbah')
                                    ->select('spk__imuhibbah.id',
                                            'spk__imuhibbah.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__imuhibbah.krt_profile_id',
                                            'spk__imuhibbah.imuhibbah_tajuk',
                                            'spk__imuhibbah.state_id',
                                            'spk__imuhibbah.daerah_id',
                                            'spk__imuhibbah.bandar_id',
                                            'spk__imuhibbah.imuhibbah_kawasan',
                                            'spk__imuhibbah.imuhibbah_lokasi',
                                            'spk__imuhibbah.imuhibbah_poskod',
                                            'spk__imuhibbah.parlimen_id',
                                            'spk__imuhibbah.dun_id',
                                            'spk__imuhibbah.pbt_id',
                                            DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_laporan,'%d/%m/%Y') AS imuhibbah_tarikh_laporan"),
                                            DB::raw(" DATE_FORMAT(spk__imuhibbah.imuhibbah_tarikh_j_berlaku,'%d/%m/%Y') AS imuhibbah_tarikh_j_berlaku"),
                                            'spk__imuhibbah.imuhibbah_laporan',
                                            'spk__imuhibbah.imuhibbah_sumber_maklumat',
                                            'spk__imuhibbah.imuhibbah_pelapor_nama',
                                            'spk__imuhibbah.imuhibbah_pelapor_no',
                                            'spk__imuhibbah.imuhibbah_pelapor_jawatan',
                                            'spk__imuhibbah.imuhibbah_pelapor_alamat',
                                            'spk__imuhibbah.status',
                                            'spk__imuhibbah.dihantar_by',
                                            'spk__imuhibbah.diakui_by',
                                            'spk__imuhibbah.disemak_by',
                                            'spk__imuhibbah.disahkan_by',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon',
                                            'spk__imuhibbah.diakui_note AS diakui_note',
                                            'spk__imuhibbah.disemak_note AS disemak_note',
                                            'spk__imuhibbah.disahkan_note AS disahkan_note'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__imuhibbah.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__imuhibbah.krt_profile_id')
                                    ->where('spk__imuhibbah.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm22.paparan-pelaporan-imuhibbah-ts-ppn', compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt','imuhibbah'));
        }
    }

    function get_ts_imuhibbah_ppn(Request $request, $id){
        $data = DB::table('spk__imuhibbah_ts')
                ->select('spk__imuhibbah_ts.id', 
                'spk__imuhibbah_ts.spk_imuhibbah_at_id',
                DB::raw(" DATE_FORMAT(spk__imuhibbah_ts.tarikh_tindakan,'%d/%m/%Y') AS tarikh_tindakan"),
                'spk__imuhibbah_ts.keterangan_tindakan',
                'ref__roles_users.long_description AS role_description')
                ->leftJoin('users','users.user_id','=','spk__imuhibbah_ts.tindakan_susulan_by')
                ->leftJoin('ref__roles_users','ref__roles_users.id','=','users.user_role')
                ->where('spk__imuhibbah_ts.spk_imuhibbah_at_id', '=', $id)
                
                ->get();
        return Datatables::of($data)
                ->make(true);
    }

    function post_add_ts_imuhibbah_ppn(Request $request){
        $action = $request->post_add_ts_imuhibbah_ppn;
        $app_id = $request->matmpn_spk_imuhibbah_id;
        
        $rules = array(
            'matmpn_tarikh_tindakan'                => 'required',
            'matmpn_keterangan_tindakan'            => 'required'
        );

        $messages = [
            'matmpn_tarikh_tindakan.required'       => 'Ruangan Jenis Premis mesti dipilih',
            'matmpn_keterangan_tindakan.required'   => 'Ruangan Alamat mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $carbon_obj = Carbon::createFromFormat('d/m/Y', $request->matmpn_tarikh_tindakan)->format('Y-m-d');
                $tindakan_susulan_ppn = new SPK_iMuhibbah_TS;
                $tindakan_susulan_ppn->spk_imuhibbah_at_id      = $app_id;
                $tindakan_susulan_ppn->tarikh_tindakan          = $carbon_obj;
                $tindakan_susulan_ppn->keterangan_tindakan      = $request->matmpn_keterangan_tindakan;
                $tindakan_susulan_ppn->tindakan_susulan_by      = Auth::user()->user_id;
                $tindakan_susulan_ppn->save();
                
            }
        }
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function permohonan_muhibbah_admin(){
        return view('rt-sm22.permohonan-muhibbah-admin');
    }

    function permohonan_muhibbah_admin_1(){
        return view('rt-sm22.permohonan-muhibbah-admin-1');
    }

    function memperakui_muhibbah_admin(){
        return view('rt-sm22.memperakui-muhibbah-admin');
    }

    function memperakui_muhibbah_admin_1(){
        return view('rt-sm22.memperakui-muhibbah-admin-1');
    }

    function menyemak_muhibbah_admin(){
        return view('rt-sm22.menyemak-muhibbah-admin');
    }

    function menyemak_muhibbah_admin_1(){
        return view('rt-sm22.menyemak-muhibbah-admin-1');
    }

    function mengesahkan_muhibbah_admin(){
        return view('rt-sm22.mengesahkan-muhibbah-admin');
    }

    function mengesahkan_muhibbah_admin_1(){
        return view('rt-sm22.mengesahkan-muhibbah-admin-1');
    }
}
