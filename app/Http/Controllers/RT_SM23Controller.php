<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Redirect, Response;
use Auth;
use Validator;
use Hash;
use Session;
use DataTables;
use DB;
use Carbon\Carbon;
use App\Mail\SendMail;
use App\RefRolesUser;
use App\User;
use App\UserProfile;
use App\RefStates;
use App\RefDaerah;
use App\RefBandar;
use App\RefParlimen;
use App\RefDUN;
use App\RefPBT;
use App\KRT_Profile;
use App\RefKaum;
use App\RefJantina;
use App\RefPendidikan;
use App\Ref_SPK_MKP_Kategori;
use App\Ref_SPK_MKP_Tahap;
use App\Ref_SPK_MKP_Kategori_Kursus;
use App\Ref_SPK_MKP_Peringkat_Kursus;
use App\SPK_iMediator_Kursus;
use App\SPK_imediator;
use App\SPK_imediator_keaktifan;
use App\Ref_SPK_MKP_Mediasi;
use App\Ref_SPK_MKP_Mediasi_Status;
use App\Ref_SPK_MKP_Peringkat;
use App\SPK_imediator_Keaktifan_Mediasi;
use App\SPK_imediator_Keaktifan_Aktiviti;
use App\SPK_imediator_Keaktifan_Latihan;
use App\SPK_imediator_Keaktifan_Sumbangan;
use App\SPK_iMediator_mediasi;
use App\SPK_iMediator_mediasi_P_Terlibat;

class RT_SM23Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function senarai_pra_pendaftaran_mkp_upmk(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            }  if($type == 'get_daerahs') {
                $value = $request->value;
                $where = array('state_description' => $value);
                $data  = DB::table('ref__daerahs')
                        ->select('ref__daerahs.id', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__daerahs.state_id')
                        ->where('ref__states.state_description', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('users')
                    ->select('users.user_id',
                        'ref__states.state_description',
                        'ref__daerahs.daerah_description',
                        'users__profile.user_fullname',
                        'users__profile.no_ic',
                        'users__profile.no_phone',
                        'users.user_email',
                        'users.user_role',
                        'users.created_at',
                        'users.user_status',
                        'ref__roles_users.short_description',
                        'spk__imediator.status')
                    ->join('users__profile','users__profile.user_id','=','users.user_id')
                    ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                    ->join('ref__roles_users','ref__roles_users.id','=','users.user_role')
                    ->leftJoin('spk__imediator','spk__imediator.user_id','=','users.user_id')
                    ->leftJoin('ref__status_spk_imediator','ref__status_spk_imediator.id','=','spk__imediator.status')
                    ->whereIn('users.mkp', [1])
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
            $state          = RefStates::where('status', '=', true)->get();
            $daerah         = RefDaerah::where('status', '=', true)->get();
            return view('rt-sm23.senarai-pra-pendaftaran-mkp-upmk',compact('roles_menu','state','daerah'));
        }
    }

    function get_profile_user($id){
        $users_profile  = DB::table('users__profile')
                        ->select('users__profile.user_id',
                        'users__profile.user_fullname',
                        'users__profile.no_phone',
                        'users__profile.user_address',
                        'users__profile.daerah_id',
                        'users.user_email')
                        ->leftJoin('users','users.user_id','=','users__profile.user_id')
                        ->where('users__profile.no_ic', '=', $id)  
                        ->limit(1)
                        ->first();
         return Response::json($users_profile);
    }

    function post_add_pendaftaran_mkp(Request $request){
        $action     = $request->post_add_pendaftaran_mkp;
        $app_id     = $request->mapm_user_id;
        $email      = $request->mapm_email;
        
        $rules = array(
            'mapm_state_id'                      => 'required',
            'mapm_daerah_id'                     => 'required',
            'mapm_no_ic'                         => 'required|min:11',
            'mapm_user_id'                       => 'required|unique:spk__imediator,user_id'
        );

        $messages = [
            'mapm_state_id.required'             => 'Ruangan Negeri mesti dipilih.',
            'mapm_daerah_id.required'            => 'Ruangan Daerah mesti dipilih.',
            'mapm_no_ic.required'                => 'Ruangan No Kad Pengenalan mesti diisi.',
            'mapm_user_id.required'              => 'Sila Pastikan Pemilik IC sudah di tambah dalam sistem Perpaduan',
            'mapm_user_id.unique'                => 'No kad pengenalan telah wujud di dalam pangkalan data MKP.',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $where = array('user_id' => $app_id);

                $user = User::where($where)->first();
                $user->state_id         = $request->mapm_state_id;
                $user->daerah_id        = $request->mapm_daerah_id;
                $user->mkp              = '1';
                $user->save();
                
                $userProfile = UserProfile::where($where)->first();
                $userProfile->state_id       = $request->mapm_state_id;
                $userProfile->daerah_id      = $request->mapm_daerah_id;
                $userProfile->mkp            = '1';
                $userProfile->save();

                $mkp                        = new SPK_imediator;       
                $mkp->status                = 2;
                $mkp->user_id               = $app_id;
                $mkp->save();

                $data = [
                    'ic' =>  preg_replace('/[^0-9]/', '', $request->mapm_no_ic),
                    'password' =>  'password'
                ];

                Session::flash('success', "Akaun baru [".$request->mapm_user_fullname."] telah berjaya dicipta!");
                // Mail::to($email)->send(new SendMail($data));
            }
        }
    }

    function get_pra_pendaftaran_mkp($id){
        $data = DB::table('users')
                ->select('users.user_id',
                'users.user_role',
                'users__profile.state_id',
                'users__profile.daerah_id',
                'users__profile.krt_id',
                'users__profile.srs_id',
                'users__profile.user_fullname',
                'users__profile.no_ic',
                'users__profile.no_phone',
                'users.user_email',
                'users__profile.user_address',
                'users.user_status')
                ->join('users__profile','users__profile.user_id','=','users.user_id')
                ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                ->where('users.user_id', '=', $id)
                ->first();
        return Response::json($data);
    }

    function post_edit_pendaftaran_mkp(Request $request){
        $action = $request->post_edit_pendaftaran_mkp;
        $app_id = $request->user_profile_id;

        $rules_main = array(
            'mepm_state_id'                 => 'required',
            'mepm_daerah_id'                => 'required',
            'mepm_user_fullname'            => 'required',
            'mepm_no_phone'                 => 'required',
            'mepm_user_email'               => 'required',
        );
        
        $messages = [
            'mepm_state_id.required'        => 'Ruangan Negeri mesti dipilih',
            'mepm_daerah_id.required'       => 'Ruangan Daerah mesti dipilih',
            'mepm_user_fullname.required'   => 'Ruangan Nama Pemohon mesti diisi',
            'mepm_no_phone.required'        => 'Ruangan Tarikh Lahir mesti dipilih',
            'mepm_user_email.required'      => 'Ruangan Daerah mesti dipilih',
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('user_id' => $app_id);
                
                $user = User::where($where)->first();
                $user->user_email       = $request->mepm_user_email;
                $user->state_id         = $request->mepm_state_id;
                $user->daerah_id        = $request->mepm_daerah_id;
                $user->user_status      = $request->mepm_status_id;
                $user->save();

                $userProfile = UserProfile::where($where)->first();
                $userProfile->user_fullname  = $request->mepm_user_fullname;
                $userProfile->no_phone       = $request->mepm_no_phone;
                $userProfile->state_id       = $request->mepm_state_id;
                $userProfile->daerah_id      = $request->mepm_daerah_id;
                $userProfile->save();
                Session::flash('success', "Akaun [".$request->mepm_user_fullname."] telah berjaya dikemaskini!");
                
            }
        }
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function mohon_pendaftaran_mkp(Request $request){
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
                $data  = RefParlimen::where($where)
                        ->orderBy('parlimen_description')
                        ->get();
                return Response::json($data);
            } else if($type == 'get_dun') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDUN::where($where)
                        ->orderBy('dun_description')
                        ->get();
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $bandar             = RefBandar::where('status', '=', true)->get();
            $parlimen           = RefParlimen::where('status', '=', true)->get();
            $dun                = RefDUN::where('status', '=', true)->get();
            $pbt                = RefPBT::where('status', '=', true)->get();
            $krt                = KRT_Profile::where('krt_status', '=', true)->get();
            $kaum               = RefKaum::where('status', '=', true)->get();
            $jantina            = RefJantina::where('status', '=', true)->get();
            $pendidikan         = RefPendidikan::where('pendidikan_status', '=', true)->get();
            $mkp_kategori       = Ref_SPK_MKP_Kategori::where('status', '=', true)->get();
            $mkp_tahap          = Ref_SPK_MKP_Tahap::where('status', '=', true)->get();
            $kategori_kursus    = Ref_SPK_MKP_Kategori_Kursus::where('status', '=', true)->get();
            $peringkat_kursus   = Ref_SPK_MKP_Peringkat_Kursus::where('status', '=', true)->get();
            $mkp                = DB::table('spk__imediator')
                                ->select('spk__imediator.id',
                                    'spk__imediator.hasRT',
                                    'krt__profile.state_id AS krt_state_id',
                                    'krt__profile.daerah_id AS krt_daerah_id',
                                    'spk__imediator.krt_profile_id',
                                    'users__profile.user_fullname AS mkp_pemohon_nama',
                                    'users__profile.no_ic AS mkp_pemohon_ic',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_pemohon_tarikh_lahir,'%d/%m/%Y') AS mkp_pemohon_tarikh_lahir"),
                                    'users__profile.state_id AS mkp_pemohon_state_id',
                                    'users__profile.daerah_id AS mkp_pemohon_daerah_id',
                                    'spk__imediator.mkp_pemohon_parlimen_id',
                                    'spk__imediator.mkp_pemohon_pbt_id',
                                    'spk__imediator.mkp_pemohon_dun_id',
                                    'spk__imediator.mkp_pemohon_mukim_id',
                                    'spk__imediator.mkp_pemohon_jantina_id',
                                    'spk__imediator.mkp_pemohon_kaum_id',
                                    'users.user_email AS mkp_pemohon_email',
                                    'spk__imediator.mkp_pemohon_alamat',
                                    'users__profile.no_phone AS mkp_pemohon_no_phone',
                                    'spk__imediator.mkp_pemohon_alamat_p',
                                    'spk__imediator.mkp_pemohon_no_phone_p',
                                    'spk__imediator.mkp_pemohon_kategori_id',
                                    'spk__imediator.mkp_pemohon_tahap_id',
                                    'spk__imediator.mkp_pemohon_akademik',
                                    'spk__imediator.mkp_pemohon_khusus',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_tarikh_dilantik,'%d/%m/%Y') AS mkp_tarikh_dilantik"),
                                    'spk__imediator.mkp_file_avatar',
                                    'spk__imediator.status',
                                    'spk__imediator.dihantar_by',
                                    'spk__imediator.disokong_by',
                                    'spk__imediator.disokong_note',
                                    'spk__imediator.disokong_p_by',
                                    'spk__imediator.disokong_p_note',
                                    'spk__imediator.disahkan_by',
                                    'spk__imediator.disahkan_note',
                                    'spk__imediator.disemak_by',
                                    'spk__imediator.disemak_note',
                                    'spk__imediator.dilulus_by',
                                    'spk__imediator.dilulus_note',
                                    'spk__imediator.dilantik_by',
                                    'spk__imediator.dilantik_note',
                                    'ref__status_spk_imediator.status_description AS status_description',
                                    DB::raw(" CONCAT(users__profile.state_id,'/',users__profile.daerah_id,'/',spk__imediator.id) AS no_rujukan_mkp"))
                                ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                                ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                                ->leftJoin('ref__status_spk_imediator','ref__status_spk_imediator.id','=','spk__imediator.status')
                                ->leftJoin('krt__profile','krt__profile.id','=','spk__imediator.krt_profile_id')
                                ->where('spk__imediator.user_id', '=', Auth::user()->user_id)  
                                ->limit(1)
                                ->first();
            return view('rt-sm23.mohon-pendaftaran-mkp', 
            compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'kaum', 'jantina', 'pendidikan', 'mkp_kategori', 'mkp_tahap', 'kategori_kursus', 'peringkat_kursus', 'mkp'));
        }
    }

    function get_senarai_kursus_mkp_table(Request $request, $id){
        $data = DB::table('spk__imediator_kursus')
                ->select('spk__imediator_kursus.*', 'ref__spk_mkp_kategori_kursus.kursus_description', 'ref__spk_mkp_peringkat_kursus.peringkat_description', 'spk__imediator.status', 'spk__imediator.status_pelanjutan')
                ->leftJoin('ref__spk_mkp_kategori_kursus','ref__spk_mkp_kategori_kursus.id','=','spk__imediator_kursus.mkp_kategori_kursus_id')
                ->leftJoin('ref__spk_mkp_peringkat_kursus','ref__spk_mkp_peringkat_kursus.id','=','spk__imediator_kursus.mkp_peringkat_kursus_id')
                ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_kursus.spk_imediator_id')
                ->where('spk__imediator_kursus.spk_imediator_id', '=', $id)
                ->get();
        return Datatables::of($data)
                ->make(true);
    }

    function post_imediator_kursus_mkp(Request $request){
        $action = $request->post_imediator_kursus_mkp;
        $app_id = $request->mpm2_spk_imediator_id;
        
        $rules = array(
            'mpm2_kursus_nama'                       => 'required',
            'mpm2_mkp_kategori_kursus_id'           => 'required',
            'mpm2_mkp_peringkat_kursus_id'          => 'required',
            'mpm2_kursus_penganjur'                 => 'required',
            'mpm2_file_dokument'                    => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:5000'
        );

        $messages = [
            'mpm2_kursus_nama.required'              => 'Ruangan Nama Kursus Mesti Diisi',
            'mpm2_mkp_kategori_kursus_id.required'  => 'Ruangan Kategori Kursus Mesti Dipilih',
            'mpm2_mkp_peringkat_kursus_id.required' => 'Ruangan Peringkat Kursus Mesti Dipilih',
            'mpm2_kursus_penganjur.required'        => 'Ruangan Penganjur Mesti Diisi',
            'mpm2_file_dokument.required'           => 'Ruangan Dokumen Mesti Dipilih',
            'mpm2_file_dokument.mimes'              => 'Fail Mesti Dipilih Dalam Format jpeg,png,jpg,gif,svg,pdf',
            'mpm2_file_dokument.max'                => 'Fail mesti dalam sive 5000KB',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            
            if ($action == 'add') {
                $fileName = $request->mpm2_file_dokument->getClientOriginalName();
                $request->mpm2_file_dokument->storeAs('public/mkp_dokument_kursus',$fileName);
                $mkp_dokument_kursus                            = new SPK_iMediator_Kursus;
                $mkp_dokument_kursus->spk_imediator_id          = $app_id;
                $mkp_dokument_kursus->kursus_nama               = $request->mpm2_kursus_nama;
                $mkp_dokument_kursus->mkp_kategori_kursus_id    = $request->mpm2_mkp_kategori_kursus_id;
                $mkp_dokument_kursus->mkp_peringkat_kursus_id   = $request->mpm2_mkp_peringkat_kursus_id;
                $mkp_dokument_kursus->kursus_penganjur          = $request->mpm2_kursus_penganjur;
                $mkp_dokument_kursus->file_dokument             = $fileName;
                $mkp_dokument_kursus->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function get_download_dokument_kursus($id){
        $data = DB::table('spk__imediator_kursus')
                ->select('spk__imediator_kursus.id', 
                    'spk__imediator_kursus.file_dokument AS file_dokument' )
                ->where('spk__imediator_kursus.id', '=', $id)
                ->first();
        return Response::json($data);
    }

    function post_edit_gambar_mkp(Request $request){
        $action = $request->post_edit_gambar_mkp;
        $app_id = $request->mgm_mkp_id;
        
        $rules = array(
            'mgm_mkp_file_avatar'               => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:5000'
        );

        $messages = [
            'mgm_mkp_file_avatar.required'      => 'Ruangan Fail Mesti Dipilih',
            'mgm_mkp_file_avatar.mimes'         => 'Fail Mesti Dipilih Dalam Format jpeg,png,jpg,gif,svg,pdf',
            'mgm_mkp_file_avatar.max'           => 'Fail mesti dalam sive 5000KB',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            $fileName = $request->mgm_mkp_file_avatar->getClientOriginalName();
            $request->mgm_mkp_file_avatar->storeAs('public/mkp_profile',$fileName);
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $gambar_mkp                     = SPK_imediator::where($where)->first();
                $gambar_mkp->mkp_file_avatar    = $fileName;
                $gambar_mkp->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function post_mohon_mkp(Request $request){
        $action = $request->post_mohon_mkp;
        $app_id = $request->mpm3_spk_imediator_id;
        $hasKRT = $request->mpm_hasRT;

        if ($hasKRT == '1') {
            $rules_main = array(                
                'mpm_krt_profile_id'                   => 'required',
                'mpm1_mkp_pemohon_tarikh_lahir'        => 'required',
                'mpm1_mkp_pemohon_dun_id'              => 'required',
                'mpm1_mkp_pemohon_mukim_id'            => 'required',
                'mpm1_mkp_pemohon_kaum_id'             => 'required',
                'mpm1_mkp_pemohon_alamat'              => 'required',
                'mpm1_mkp_pemohon_kategori_id'         => 'required',
                'mpm1_mkp_pemohon_akademik'            => 'required',
                'mpm1_mkp_pemohon_parlimen_id'         => 'required',
                'mpm1_mkp_pemohon_pbt_id'              => 'required',
                'mpm1_mkp_pemohon_jantina_id'          => 'required',
                'mpm1_mkp_pemohon_alamat_p'            => 'required',
                'mpm1_mkp_pemohon_no_phone_p'          => 'required|numeric',
                'mpm1_mkp_pemohon_tahap_id'            => 'required',
                'mpm1_mkp_pemohon_khusus'              => 'required',
                'mpm1_mkp_tarikh_dilantik'             => 'required',
            );
        } else {
            $rules_main = array(
                'mpm1_mkp_pemohon_tarikh_lahir'        => 'required',
                'mpm1_mkp_pemohon_dun_id'              => 'required',
                'mpm1_mkp_pemohon_mukim_id'            => 'required',
                'mpm1_mkp_pemohon_kaum_id'             => 'required',
                'mpm1_mkp_pemohon_alamat'              => 'required',
                'mpm1_mkp_pemohon_kategori_id'         => 'required',
                'mpm1_mkp_pemohon_akademik'            => 'required',
                'mpm1_mkp_pemohon_parlimen_id'         => 'required',
                'mpm1_mkp_pemohon_pbt_id'              => 'required',
                'mpm1_mkp_pemohon_jantina_id'          => 'required',
                'mpm1_mkp_pemohon_alamat_p'            => 'required',
                'mpm1_mkp_pemohon_no_phone_p'          => 'required|numeric',
                'mpm1_mkp_pemohon_tahap_id'            => 'required',
                'mpm1_mkp_pemohon_khusus'              => 'required',
                'mpm1_mkp_tarikh_dilantik'             => 'required',
            );
        }
        
        $messages = [
            'mpm_krt_profile_id.required'              => 'Ruangan Nama KRT mesti dipilih',
            'mpm1_mkp_pemohon_tarikh_lahir.required'   => 'Ruangan Tarikh Lahir mesti dipilih',
            'mpm1_mkp_pemohon_dun_id.required'         => 'Ruangan Dun mesti dipilih',
            'mpm1_mkp_pemohon_mukim_id.required'       => 'Ruangan Mukim mesti diisi',
            'mpm1_mkp_pemohon_kaum_id.required'        => 'Ruangan Kaum mesti dipilih',
            'mpm1_mkp_pemohon_alamat.required'         => 'Ruangan Alamat mesti diisi',
            'mpm1_mkp_pemohon_kategori_id.required'    => 'Ruangan Kategori MKP mesti dipilih',
            'mpm1_mkp_pemohon_akademik.required'       => 'Ruangan Kelulusan Akademik mesti dipilih',
            'mpm1_mkp_pemohon_parlimen_id.required'    => 'Ruangan Parlimen mesti dipilih',
            'mpm1_mkp_pemohon_pbt_id.required'         => 'Ruangan PBT mesti dipilih',
            'mpm1_mkp_pemohon_jantina_id.required'     => 'Ruangan Jantina mesti dipilih',
            'mpm1_mkp_pemohon_no_phone_p.required'     => 'Ruangan No Telefon Pejabat mesti diisi',
            'mpm1_mkp_pemohon_no_phone_p.numeric'      => 'Ruangan No Telefon Pejabat mesti diisi dalam bentuk Nombor',
            'mpm1_mkp_pemohon_alamat_p.required'       => 'Ruangan Alamat Pejabat mesti diisi',
            'mpm1_mkp_pemohon_tahap_id.required'       => 'Ruangan Tahap MKP mesti dipilih',
            'mpm1_mkp_pemohon_khusus.required'         => 'Ruangan Pengkhususan mesti diisi',
            'mpm1_mkp_tarikh_dilantik.required'        => 'Ruangan Tarikh Pelantikan mesti diisi',
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $carbon_obj                               = Carbon::createFromFormat('d/m/Y', $request->mpm1_mkp_pemohon_tarikh_lahir)->format('Y-m-d');
                $carbon_obj_1                             = Carbon::createFromFormat('d/m/Y', $request->mpm1_mkp_tarikh_dilantik)->format('Y-m-d');
                $update_mkp                               = SPK_imediator::where($where)->first();
                $update_mkp->hasRT                        = $hasKRT;
                $update_mkp->krt_profile_id               = $request->mpm_krt_profile_id;
                $update_mkp->mkp_pemohon_tarikh_lahir     = $carbon_obj;
                $update_mkp->mkp_pemohon_parlimen_id      = $request->mpm1_mkp_pemohon_parlimen_id;
                $update_mkp->mkp_pemohon_dun_id           = $request->mpm1_mkp_pemohon_dun_id;
                $update_mkp->mkp_pemohon_pbt_id           = $request->mpm1_mkp_pemohon_pbt_id;
                $update_mkp->mkp_pemohon_mukim_id         = $request->mpm1_mkp_pemohon_mukim_id;
                $update_mkp->mkp_pemohon_jantina_id       = $request->mpm1_mkp_pemohon_jantina_id;
                $update_mkp->mkp_pemohon_kaum_id          = $request->mpm1_mkp_pemohon_kaum_id;
                $update_mkp->mkp_pemohon_alamat           = $request->mpm1_mkp_pemohon_alamat;
                $update_mkp->mkp_pemohon_alamat_p         = $request->mpm1_mkp_pemohon_alamat_p;
                $update_mkp->mkp_pemohon_no_phone_p       = $request->mpm1_mkp_pemohon_no_phone_p;
                $update_mkp->mkp_pemohon_kategori_id      = $request->mpm1_mkp_pemohon_kategori_id;
                $update_mkp->mkp_pemohon_tahap_id         = $request->mpm1_mkp_pemohon_tahap_id;
                $update_mkp->mkp_pemohon_akademik         = $request->mpm1_mkp_pemohon_akademik;
                $update_mkp->mkp_pemohon_khusus           = $request->mpm1_mkp_pemohon_khusus;
                $update_mkp->mkp_tarikh_dilantik          = $carbon_obj_1;
                $update_mkp->status                       = 3;
                $update_mkp->dihantar_date                = date('Y-m-d H:i:s');
                $update_mkp->save();
                
            }
        }
    }

    function senarai_permohonan_mkp_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('spk__imediator')
                        ->select('spk__imediator.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'users__profile.user_fullname AS mkp_pemohon_nama',
                                'users__profile.no_ic AS mkp_pemohon_ic',
                                'users__profile.no_phone AS mkp_pemohon_no_phone',
                                'users.user_email AS mkp_pemohon_email',
                                'spk__imediator.status AS status',
                                'ref__status_spk_imediator.status_description AS status_description')
                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                        ->leftJoin('ref__status_spk_imediator','ref__status_spk_imediator.id','=','spk__imediator.status')
                        ->where('users__profile.daerah_id', '=', Auth::user()->daerah_id)
                        ->whereIN('spk__imediator.mkp_pemohon_kategori_id',[2,3,4,5])
                        ->whereIN('spk__imediator.status',[3])
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
            return view('rt-sm23.senarai-permohonan-mkp-ppd',compact('roles_menu'));
        }
    }

    function sokongan_permohonan_mkp_ppd(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $bandar             = RefBandar::where('status', '=', true)->get();
            $parlimen           = RefParlimen::where('status', '=', true)->get();
            $dun                = RefDUN::where('status', '=', true)->get();
            $pbt                = RefPBT::where('status', '=', true)->get();
            $krt                = KRT_Profile::where('krt_status', '=', true)->get();
            $kaum               = RefKaum::where('status', '=', true)->get();
            $jantina            = RefJantina::where('status', '=', true)->get();
            $pendidikan         = RefPendidikan::where('pendidikan_status', '=', true)->get();
            $mkp_kategori       = Ref_SPK_MKP_Kategori::where('status', '=', true)->get();
            $mkp_tahap          = Ref_SPK_MKP_Tahap::where('status', '=', true)->get();
            $kategori_kursus    = Ref_SPK_MKP_Kategori_Kursus::where('status', '=', true)->get();
            $peringkat_kursus   = Ref_SPK_MKP_Peringkat_Kursus::where('status', '=', true)->get();
            $mkp                = DB::table('spk__imediator')
                            ->select('spk__imediator.id',
                                    'spk__imediator.hasRT',
                                    'krt__profile.state_id AS krt_state_id',
                                    'krt__profile.daerah_id AS krt_daerah_id',
                                    'spk__imediator.krt_profile_id',
                                    'users__profile.user_fullname AS mkp_pemohon_nama',
                                    'users__profile.no_ic AS mkp_pemohon_ic',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_pemohon_tarikh_lahir,'%d/%m/%Y') AS mkp_pemohon_tarikh_lahir"),
                                    'users__profile.state_id AS mkp_pemohon_state_id',
                                    'users__profile.daerah_id AS mkp_pemohon_daerah_id',
                                    'spk__imediator.mkp_pemohon_parlimen_id',
                                    'spk__imediator.mkp_pemohon_pbt_id',
                                    'spk__imediator.mkp_pemohon_dun_id',
                                    'spk__imediator.mkp_pemohon_mukim_id',
                                    'spk__imediator.mkp_pemohon_jantina_id',
                                    'spk__imediator.mkp_pemohon_kaum_id',
                                    'users.user_email AS mkp_pemohon_email',
                                    'spk__imediator.mkp_pemohon_alamat',
                                    'users__profile.no_phone AS mkp_pemohon_no_phone',
                                    'spk__imediator.mkp_pemohon_alamat_p',
                                    'spk__imediator.mkp_pemohon_no_phone_p',
                                    'spk__imediator.mkp_pemohon_kategori_id',
                                    'spk__imediator.mkp_pemohon_tahap_id',
                                    'spk__imediator.mkp_pemohon_akademik',
                                    'spk__imediator.mkp_pemohon_khusus',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_tarikh_dilantik,'%d/%m/%Y') AS mkp_tarikh_dilantik"),
                                    'spk__imediator.mkp_file_avatar',
                                    'spk__imediator.status',
                                    'spk__imediator.dihantar_by',
                                    'spk__imediator.disokong_by',
                                    'spk__imediator.disokong_note',
                                    'spk__imediator.disokong_p_by',
                                    'spk__imediator.disokong_p_note',
                                    'spk__imediator.disemak_by',
                                    'spk__imediator.disemak_note',
                                    'spk__imediator.dilulus_by',
                                    'spk__imediator.dilulus_note',
                                    'spk__imediator.dilantik_by',
                                    'spk__imediator.dilantik_note'
                                    )
                            ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                            ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                            ->leftJoin('krt__profile','krt__profile.id','=','spk__imediator.krt_profile_id')
                            ->where('spk__imediator.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm23.sokongan-permohonan-mkp-ppd', 
            compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'kaum', 'jantina', 'pendidikan', 'mkp_kategori', 'mkp_tahap', 'kategori_kursus', 'peringkat_kursus', 'mkp'));
        }
    }

    function post_sokongan_permohonan_mkp_ppd(Request $request){
        $action = $request->post_sokongan_permohonan_mkp_ppd;
        $app_id = $request->spmpd_spk_imediator_id;
        
        
        $rules = array(
            'spmpd_imediator_status'            => 'required',
            'spmpd_disokong_note'               => 'required',
        );

        $messages = [
            'spmpd_imediator_status.required'   => 'Ruangan Status dipilih',
            'spmpd_disokong_note.required'      => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $sokongan_permohonan_mkp                   = SPK_imediator::where($where)->first();
                $sokongan_permohonan_mkp->status           = $request->spmpd_imediator_status;
                $sokongan_permohonan_mkp->disokong_by      = Auth::user()->user_id;
                $sokongan_permohonan_mkp->disokong_date    = date('Y-m-d H:i:s');
                $sokongan_permohonan_mkp->disokong_note    = $request->spmpd_disokong_note;
                $sokongan_permohonan_mkp->save();
            }
        }
    }

    function senarai_permohonan_mkp_ppmk(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('spk__imediator')
                        ->select('spk__imediator.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'users__profile.user_fullname AS mkp_pemohon_nama',
                                'users__profile.no_ic AS mkp_pemohon_ic',
                                'users__profile.no_phone AS mkp_pemohon_no_phone',
                                'users.user_email AS mkp_pemohon_email',
                                'spk__imediator.status AS status',
                                'ref__status_spk_imediator.status_description AS status_description')
                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                        ->leftJoin('ref__status_spk_imediator','ref__status_spk_imediator.id','=','spk__imediator.status')
                        ->where('users__profile.state_id', '=', Auth::user()->state_id)
                        ->whereIN('spk__imediator.mkp_pemohon_kategori_id',[1])
                        ->whereIN('spk__imediator.status',[3])
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
            return view('rt-sm23.senarai-permohonan-mkp-ppmk',compact('roles_menu','daerah'));
        }
    }

    function sokongan_permohonan_mkp_ppmk(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $bandar             = RefBandar::where('status', '=', true)->get();
            $parlimen           = RefParlimen::where('status', '=', true)->get();
            $dun                = RefDUN::where('status', '=', true)->get();
            $pbt                = RefPBT::where('status', '=', true)->get();
            $krt                = KRT_Profile::where('krt_status', '=', true)->get();
            $kaum               = RefKaum::where('status', '=', true)->get();
            $jantina            = RefJantina::where('status', '=', true)->get();
            $pendidikan         = RefPendidikan::where('pendidikan_status', '=', true)->get();
            $mkp_kategori       = Ref_SPK_MKP_Kategori::where('status', '=', true)->get();
            $mkp_tahap          = Ref_SPK_MKP_Tahap::where('status', '=', true)->get();
            $kategori_kursus    = Ref_SPK_MKP_Kategori_Kursus::where('status', '=', true)->get();
            $peringkat_kursus   = Ref_SPK_MKP_Peringkat_Kursus::where('status', '=', true)->get();
            $mkp                = DB::table('spk__imediator')
                                ->select('spk__imediator.id',
                                    'spk__imediator.hasRT',
                                    'krt__profile.state_id AS krt_state_id',
                                    'krt__profile.daerah_id AS krt_daerah_id',
                                    'spk__imediator.krt_profile_id',
                                    'users__profile.user_fullname AS mkp_pemohon_nama',
                                    'users__profile.no_ic AS mkp_pemohon_ic',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_pemohon_tarikh_lahir,'%d/%m/%Y') AS mkp_pemohon_tarikh_lahir"),
                                    'users__profile.state_id AS mkp_pemohon_state_id',
                                    'users__profile.daerah_id AS mkp_pemohon_daerah_id',
                                    'spk__imediator.mkp_pemohon_parlimen_id',
                                    'spk__imediator.mkp_pemohon_pbt_id',
                                    'spk__imediator.mkp_pemohon_dun_id',
                                    'spk__imediator.mkp_pemohon_mukim_id',
                                    'spk__imediator.mkp_pemohon_jantina_id',
                                    'spk__imediator.mkp_pemohon_kaum_id',
                                    'users.user_email AS mkp_pemohon_email',
                                    'spk__imediator.mkp_pemohon_alamat',
                                    'users__profile.no_phone AS mkp_pemohon_no_phone',
                                    'spk__imediator.mkp_pemohon_alamat_p',
                                    'spk__imediator.mkp_pemohon_no_phone_p',
                                    'spk__imediator.mkp_pemohon_kategori_id',
                                    'spk__imediator.mkp_pemohon_tahap_id',
                                    'spk__imediator.mkp_pemohon_akademik',
                                    'spk__imediator.mkp_pemohon_khusus',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_tarikh_dilantik,'%d/%m/%Y') AS mkp_tarikh_dilantik"),
                                    'spk__imediator.mkp_file_avatar',
                                    'spk__imediator.status',
                                    'spk__imediator.dihantar_by',
                                    'spk__imediator.disokong_by',
                                    'spk__imediator.disokong_note',
                                    'spk__imediator.disokong_p_by',
                                    'spk__imediator.disokong_p_note',
                                    'spk__imediator.disemak_by',
                                    'spk__imediator.disemak_note',
                                    'spk__imediator.dilulus_by',
                                    'spk__imediator.dilulus_note',
                                    'spk__imediator.dilantik_by',
                                    'spk__imediator.dilantik_note'
                                    )
                            ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                            ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                            ->leftJoin('krt__profile','krt__profile.id','=','spk__imediator.krt_profile_id')
                            ->where('spk__imediator.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm23.sokongan-permohonan-mkp-ppmk', 
            compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'kaum', 'jantina', 'pendidikan', 'mkp_kategori', 'mkp_tahap', 'kategori_kursus', 'peringkat_kursus', 'mkp'));
        }
    }

    function post_sokongan_permohonan_mkp_ppmk(Request $request){
        $action = $request->post_sokongan_permohonan_mkp_ppmk;
        $app_id = $request->spmmk_spk_imediator_id;
        
        
        $rules = array(
            'spmmk_imediator_status'            => 'required',
            'spmmk_disokong_note'               => 'required',
        );

        $messages = [
            'spmmk_imediator_status.required'   => 'Ruangan Status dipilih',
            'spmmk_disokong_note.required'      => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $sokongan_permohonan_mkp                   = SPK_imediator::where($where)->first();
                $sokongan_permohonan_mkp->status           = $request->spmmk_imediator_status;
                $sokongan_permohonan_mkp->disokong_p_by    = Auth::user()->user_id;
                $sokongan_permohonan_mkp->disokong_p_date  = date('Y-m-d H:i:s');
                $sokongan_permohonan_mkp->disokong_p_note  = $request->spmmk_disokong_note;
                $sokongan_permohonan_mkp->save();
            }
        }
    }

    function senarai_permohonan_mkp_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('spk__imediator')
                        ->select('spk__imediator.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'users__profile.user_fullname AS mkp_pemohon_nama',
                                'users__profile.no_ic AS mkp_pemohon_ic',
                                'users__profile.no_phone AS mkp_pemohon_no_phone',
                                'users.user_email AS mkp_pemohon_email',
                                'spk__imediator.status AS status',
                                'ref__status_spk_imediator.status_description AS status_description')
                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                        ->leftJoin('ref__status_spk_imediator','ref__status_spk_imediator.id','=','spk__imediator.status')
                        ->where('users__profile.state_id', '=', Auth::user()->state_id)
                        ->whereIN('spk__imediator.status',[4,6])
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
            return view('rt-sm23.senarai-permohonan-mkp-ppn', compact('roles_menu','daerah'));
        }
    }

    function pengesahan_permohonan_mkp_ppn(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $bandar             = RefBandar::where('status', '=', true)->get();
            $parlimen           = RefParlimen::where('status', '=', true)->get();
            $dun                = RefDUN::where('status', '=', true)->get();
            $pbt                = RefPBT::where('status', '=', true)->get();
            $krt                = KRT_Profile::where('krt_status', '=', true)->get();
            $kaum               = RefKaum::where('status', '=', true)->get();
            $jantina            = RefJantina::where('status', '=', true)->get();
            $pendidikan         = RefPendidikan::where('pendidikan_status', '=', true)->get();
            $mkp_kategori       = Ref_SPK_MKP_Kategori::where('status', '=', true)->get();
            $mkp_tahap          = Ref_SPK_MKP_Tahap::where('status', '=', true)->get();
            $kategori_kursus    = Ref_SPK_MKP_Kategori_Kursus::where('status', '=', true)->get();
            $peringkat_kursus   = Ref_SPK_MKP_Peringkat_Kursus::where('status', '=', true)->get();
            $mkp                = DB::table('spk__imediator')
                                ->select('spk__imediator.id',
                                    'spk__imediator.hasRT',
                                    'krt__profile.state_id AS krt_state_id',
                                    'krt__profile.daerah_id AS krt_daerah_id',
                                    'spk__imediator.krt_profile_id',
                                    'users__profile.user_fullname AS mkp_pemohon_nama',
                                    'users__profile.no_ic AS mkp_pemohon_ic',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_pemohon_tarikh_lahir,'%d/%m/%Y') AS mkp_pemohon_tarikh_lahir"),
                                    'users__profile.state_id AS mkp_pemohon_state_id',
                                    'users__profile.daerah_id AS mkp_pemohon_daerah_id',
                                    'spk__imediator.mkp_pemohon_parlimen_id',
                                    'spk__imediator.mkp_pemohon_pbt_id',
                                    'spk__imediator.mkp_pemohon_dun_id',
                                    'spk__imediator.mkp_pemohon_mukim_id',
                                    'spk__imediator.mkp_pemohon_jantina_id',
                                    'spk__imediator.mkp_pemohon_kaum_id',
                                    'users.user_email AS mkp_pemohon_email',
                                    'spk__imediator.mkp_pemohon_alamat',
                                    'users__profile.no_phone AS mkp_pemohon_no_phone',
                                    'spk__imediator.mkp_pemohon_alamat_p',
                                    'spk__imediator.mkp_pemohon_no_phone_p',
                                    'spk__imediator.mkp_pemohon_kategori_id',
                                    'spk__imediator.mkp_pemohon_tahap_id',
                                    'spk__imediator.mkp_pemohon_akademik',
                                    'spk__imediator.mkp_pemohon_khusus',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_tarikh_dilantik,'%d/%m/%Y') AS mkp_tarikh_dilantik"),
                                    'spk__imediator.mkp_file_avatar',
                                    'spk__imediator.status',
                                    'spk__imediator.dihantar_by',
                                    'spk__imediator.disokong_by',
                                    'spk__imediator.disokong_note',
                                    'spk__imediator.disokong_p_by',
                                    'spk__imediator.disokong_p_note',
                                    'spk__imediator.disemak_by',
                                    'spk__imediator.disemak_note',
                                    'spk__imediator.dilulus_by',
                                    'spk__imediator.dilulus_note',
                                    'spk__imediator.dilantik_by',
                                    'spk__imediator.dilantik_note'
                                    )
                            ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                            ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                            ->leftJoin('krt__profile','krt__profile.id','=','spk__imediator.krt_profile_id')
                            ->where('spk__imediator.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm23.pengesahan-permohonan-mkp-ppn', 
            compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'kaum', 'jantina', 'pendidikan', 'mkp_kategori', 'mkp_tahap', 'kategori_kursus', 'peringkat_kursus', 'mkp'));
        }
    }

    function post_pengesahan_permohonan_mkp_ppn(Request $request){
        $action = $request->post_pengesahan_permohonan_mkp_ppn;
        $app_id = $request->ppmpn_spk_imediator_id;
        
        
        $rules = array(
            'ppmpn_imediator_status'            => 'required',
            'ppmpn_disahkan_note'               => 'required',
        );

        $messages = [
            'ppmpn_imediator_status.required'   => 'Ruangan Status dipilih',
            'ppmpn_disahkan_note.required'      => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $pengesahan_permohonan_mkp                  = SPK_imediator::where($where)->first();
                $pengesahan_permohonan_mkp->status          = $request->ppmpn_imediator_status;
                $pengesahan_permohonan_mkp->disahkan_by     = Auth::user()->user_id;
                $pengesahan_permohonan_mkp->disahkan_date   = date('Y-m-d H:i:s');
                $pengesahan_permohonan_mkp->disahkan_note   = $request->ppmpn_disahkan_note;
                $pengesahan_permohonan_mkp->save();
            }
        }
    }

    function senarai_permohonan_mkp_upmk(Request $request){
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
            $data = DB::table('spk__imediator')
                        ->select('spk__imediator.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'users__profile.user_fullname AS mkp_pemohon_nama',
                                'users__profile.no_ic AS mkp_pemohon_ic',
                                'users__profile.no_phone AS mkp_pemohon_no_phone',
                                'users.user_email AS mkp_pemohon_email',
                                'spk__imediator.status AS status',
                                'ref__status_spk_imediator.status_description AS status_description')
                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                        ->leftJoin('ref__status_spk_imediator','ref__status_spk_imediator.id','=','spk__imediator.status')
                        ->whereIN('spk__imediator.status',[8])
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
            return view('rt-sm23.senarai-permohonan-mkp-upmk', compact('roles_menu','state'));
        }
    }

    function semakan_permohonan_mkp_upmk(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $bandar             = RefBandar::where('status', '=', true)->get();
            $parlimen           = RefParlimen::where('status', '=', true)->get();
            $dun                = RefDUN::where('status', '=', true)->get();
            $pbt                = RefPBT::where('status', '=', true)->get();
            $krt                = KRT_Profile::where('krt_status', '=', true)->get();
            $kaum               = RefKaum::where('status', '=', true)->get();
            $jantina            = RefJantina::where('status', '=', true)->get();
            $pendidikan         = RefPendidikan::where('pendidikan_status', '=', true)->get();
            $mkp_kategori       = Ref_SPK_MKP_Kategori::where('status', '=', true)->get();
            $mkp_tahap          = Ref_SPK_MKP_Tahap::where('status', '=', true)->get();
            $kategori_kursus    = Ref_SPK_MKP_Kategori_Kursus::where('status', '=', true)->get();
            $peringkat_kursus   = Ref_SPK_MKP_Peringkat_Kursus::where('status', '=', true)->get();
            $mkp                = DB::table('spk__imediator')
                            ->select('spk__imediator.id',
                                    'spk__imediator.hasRT',
                                    'krt__profile.state_id AS krt_state_id',
                                    'krt__profile.daerah_id AS krt_daerah_id',
                                    'spk__imediator.krt_profile_id',
                                    'users__profile.user_fullname AS mkp_pemohon_nama',
                                    'users__profile.no_ic AS mkp_pemohon_ic',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_pemohon_tarikh_lahir,'%d/%m/%Y') AS mkp_pemohon_tarikh_lahir"),
                                    'users__profile.state_id AS mkp_pemohon_state_id',
                                    'users__profile.daerah_id AS mkp_pemohon_daerah_id',
                                    'spk__imediator.mkp_pemohon_parlimen_id',
                                    'spk__imediator.mkp_pemohon_pbt_id',
                                    'spk__imediator.mkp_pemohon_dun_id',
                                    'spk__imediator.mkp_pemohon_mukim_id',
                                    'spk__imediator.mkp_pemohon_jantina_id',
                                    'spk__imediator.mkp_pemohon_kaum_id',
                                    'users.user_email AS mkp_pemohon_email',
                                    'spk__imediator.mkp_pemohon_alamat',
                                    'users__profile.no_phone AS mkp_pemohon_no_phone',
                                    'spk__imediator.mkp_pemohon_alamat_p',
                                    'spk__imediator.mkp_pemohon_no_phone_p',
                                    'spk__imediator.mkp_pemohon_kategori_id',
                                    'spk__imediator.mkp_pemohon_tahap_id',
                                    'spk__imediator.mkp_pemohon_akademik',
                                    'spk__imediator.mkp_pemohon_khusus',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_tarikh_dilantik,'%d/%m/%Y') AS mkp_tarikh_dilantik"),
                                    'spk__imediator.mkp_file_avatar',
                                    'spk__imediator.status',
                                    'spk__imediator.dihantar_by',
                                    'spk__imediator.disokong_by',
                                    'spk__imediator.disokong_note',
                                    'spk__imediator.disokong_p_by',
                                    'spk__imediator.disokong_p_note',
                                    'spk__imediator.disemak_by',
                                    'spk__imediator.disemak_note',
                                    'spk__imediator.dilulus_by',
                                    'spk__imediator.dilulus_note',
                                    'spk__imediator.dilantik_by',
                                    'spk__imediator.dilantik_note'
                                    )
                            ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                            ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                            ->leftJoin('krt__profile','krt__profile.id','=','spk__imediator.krt_profile_id')
                            ->where('spk__imediator.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm23.semakan-permohonan-mkp-upmk', 
            compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'kaum', 'jantina', 'pendidikan', 'mkp_kategori', 'mkp_tahap', 'kategori_kursus', 'peringkat_kursus', 'mkp'));
        }
    }

    function post_semakan_permohonan_mkp_upmk(Request $request){
        $action = $request->post_semakan_permohonan_mkp_upmk;
        $app_id = $request->spmupmk_spk_imediator_id;
        
        
        $rules = array(
            'spmupmk_imediator_status'           => 'required',
            'spmupmk_disemak_note'               => 'required',
        );

        $messages = [
            'spmupmk_imediator_status.required'  => 'Ruangan Status dipilih',
            'spmupmk_disemak_note.required'      => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $semakan_permohonan_mkp                  = SPK_imediator::where($where)->first();
                $semakan_permohonan_mkp->status          = $request->spmupmk_imediator_status;
                $semakan_permohonan_mkp->disemak_by      = Auth::user()->user_id;
                $semakan_permohonan_mkp->disemak_date    = date('Y-m-d H:i:s');
                $semakan_permohonan_mkp->disemak_note    = $request->spmupmk_disemak_note;
                $semakan_permohonan_mkp->save();
            }
        }
    }

    function senarai_permohonan_mkp_ppp(Request $request){
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
            $data = DB::table('spk__imediator')
                        ->select('spk__imediator.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'users__profile.user_fullname AS mkp_pemohon_nama',
                                'users__profile.no_ic AS mkp_pemohon_ic',
                                'users__profile.no_phone AS mkp_pemohon_no_phone',
                                'users.user_email AS mkp_pemohon_email',
                                'spk__imediator.status AS status',
                                'ref__status_spk_imediator.status_description AS status_description')
                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                        ->leftJoin('ref__status_spk_imediator','ref__status_spk_imediator.id','=','spk__imediator.status')
                        ->whereIN('spk__imediator.status',[10])
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
            return view('rt-sm23.senarai-permohonan-mkp-ppp', compact('roles_menu','state'));
        }
    }

    function kelulusan_permohonan_mkp_ppp(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $bandar             = RefBandar::where('status', '=', true)->get();
            $parlimen           = RefParlimen::where('status', '=', true)->get();
            $dun                = RefDUN::where('status', '=', true)->get();
            $pbt                = RefPBT::where('status', '=', true)->get();
            $krt                = KRT_Profile::where('krt_status', '=', true)->get();
            $kaum               = RefKaum::where('status', '=', true)->get();
            $jantina            = RefJantina::where('status', '=', true)->get();
            $pendidikan         = RefPendidikan::where('pendidikan_status', '=', true)->get();
            $mkp_kategori       = Ref_SPK_MKP_Kategori::where('status', '=', true)->get();
            $mkp_tahap          = Ref_SPK_MKP_Tahap::where('status', '=', true)->get();
            $kategori_kursus    = Ref_SPK_MKP_Kategori_Kursus::where('status', '=', true)->get();
            $peringkat_kursus   = Ref_SPK_MKP_Peringkat_Kursus::where('status', '=', true)->get();
            $mkp                = DB::table('spk__imediator')
                                ->select('spk__imediator.id',
                                    'spk__imediator.hasRT',
                                    'krt__profile.state_id AS krt_state_id',
                                    'krt__profile.daerah_id AS krt_daerah_id',
                                    'spk__imediator.krt_profile_id',
                                    'users__profile.user_fullname AS mkp_pemohon_nama',
                                    'users__profile.no_ic AS mkp_pemohon_ic',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_pemohon_tarikh_lahir,'%d/%m/%Y') AS mkp_pemohon_tarikh_lahir"),
                                    'users__profile.state_id AS mkp_pemohon_state_id',
                                    'users__profile.daerah_id AS mkp_pemohon_daerah_id',
                                    'spk__imediator.mkp_pemohon_parlimen_id',
                                    'spk__imediator.mkp_pemohon_pbt_id',
                                    'spk__imediator.mkp_pemohon_dun_id',
                                    'spk__imediator.mkp_pemohon_mukim_id',
                                    'spk__imediator.mkp_pemohon_jantina_id',
                                    'spk__imediator.mkp_pemohon_kaum_id',
                                    'users.user_email AS mkp_pemohon_email',
                                    'spk__imediator.mkp_pemohon_alamat',
                                    'users__profile.no_phone AS mkp_pemohon_no_phone',
                                    'spk__imediator.mkp_pemohon_alamat_p',
                                    'spk__imediator.mkp_pemohon_no_phone_p',
                                    'spk__imediator.mkp_pemohon_kategori_id',
                                    'spk__imediator.mkp_pemohon_tahap_id',
                                    'spk__imediator.mkp_pemohon_akademik',
                                    'spk__imediator.mkp_pemohon_khusus',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_tarikh_dilantik,'%d/%m/%Y') AS mkp_tarikh_dilantik"),
                                    'spk__imediator.mkp_file_avatar',
                                    'spk__imediator.status',
                                    'spk__imediator.dihantar_by',
                                    'spk__imediator.disokong_by',
                                    'spk__imediator.disokong_note',
                                    'spk__imediator.disokong_p_by',
                                    'spk__imediator.disokong_p_note',
                                    'spk__imediator.disemak_by',
                                    'spk__imediator.disemak_note',
                                    'spk__imediator.dilulus_by',
                                    'spk__imediator.dilulus_note',
                                    'spk__imediator.dilantik_by',
                                    'spk__imediator.dilantik_note'
                                    )
                            ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                            ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                            ->leftJoin('krt__profile','krt__profile.id','=','spk__imediator.krt_profile_id')
                            ->where('spk__imediator.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm23.kelulusan-permohonan-mkp-ppp', 
            compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'kaum', 'jantina', 'pendidikan', 'mkp_kategori', 'mkp_tahap', 'kategori_kursus', 'peringkat_kursus', 'mkp'));
        }
    }

    function post_kelulusan_permohonan_mkp_ppp(Request $request){
        $action = $request->post_kelulusan_permohonan_mkp_ppp;
        $app_id = $request->kpmppp_spk_imediator_id;
        
        
        $rules = array(
            'kpmppp_imediator_status'           => 'required',
            'kpmppp_diluluskan_note'            => 'required',
        );

        $messages = [
            'kpmppp_imediator_status.required'  => 'Ruangan Status dipilih',
            'kpmppp_diluluskan_note.required'   => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $kelulusan_permohonan_mkp                  = SPK_imediator::where($where)->first();
                $kelulusan_permohonan_mkp->status          = $request->kpmppp_imediator_status;
                $kelulusan_permohonan_mkp->dilulus_by      = Auth::user()->user_id;
                $kelulusan_permohonan_mkp->dilulus_date    = date('Y-m-d H:i:s');
                $kelulusan_permohonan_mkp->dilulus_note    = $request->kpmppp_diluluskan_note;
                $kelulusan_permohonan_mkp->save();
            }
        }
    }

    function senarai_permohonan_mkp_kp(Request $request){
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
            $data = DB::table('spk__imediator')
                        ->select('spk__imediator.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'users__profile.user_fullname AS mkp_pemohon_nama',
                                'users__profile.no_ic AS mkp_pemohon_ic',
                                'users__profile.no_phone AS mkp_pemohon_no_phone',
                                'users.user_email AS mkp_pemohon_email',
                                'spk__imediator.status AS status',
                                'ref__status_spk_imediator.status_description AS status_description')
                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                        ->leftJoin('ref__status_spk_imediator','ref__status_spk_imediator.id','=','spk__imediator.status')
                        ->whereIN('spk__imediator.status',[12])
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
            return view('rt-sm23.senarai-permohonan-mkp-kp', compact('roles_menu','state'));
        }
    }

    function pelantikan_permohonan_mkp_kp(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $bandar             = RefBandar::where('status', '=', true)->get();
            $parlimen           = RefParlimen::where('status', '=', true)->get();
            $dun                = RefDUN::where('status', '=', true)->get();
            $pbt                = RefPBT::where('status', '=', true)->get();
            $krt                = KRT_Profile::where('krt_status', '=', true)->get();
            $kaum               = RefKaum::where('status', '=', true)->get();
            $jantina            = RefJantina::where('status', '=', true)->get();
            $pendidikan         = RefPendidikan::where('pendidikan_status', '=', true)->get();
            $mkp_kategori       = Ref_SPK_MKP_Kategori::where('status', '=', true)->get();
            $mkp_tahap          = Ref_SPK_MKP_Tahap::where('status', '=', true)->get();
            $kategori_kursus    = Ref_SPK_MKP_Kategori_Kursus::where('status', '=', true)->get();
            $peringkat_kursus   = Ref_SPK_MKP_Peringkat_Kursus::where('status', '=', true)->get();
            $mkp                = DB::table('spk__imediator')
                            ->select('spk__imediator.id',
                                    'spk__imediator.hasRT',
                                    'krt__profile.state_id AS krt_state_id',
                                    'krt__profile.daerah_id AS krt_daerah_id',
                                    'spk__imediator.krt_profile_id',
                                    'users__profile.user_fullname AS mkp_pemohon_nama',
                                    'users__profile.no_ic AS mkp_pemohon_ic',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_pemohon_tarikh_lahir,'%d/%m/%Y') AS mkp_pemohon_tarikh_lahir"),
                                    'users__profile.state_id AS mkp_pemohon_state_id',
                                    'users__profile.daerah_id AS mkp_pemohon_daerah_id',
                                    'spk__imediator.mkp_pemohon_parlimen_id',
                                    'spk__imediator.mkp_pemohon_pbt_id',
                                    'spk__imediator.mkp_pemohon_dun_id',
                                    'spk__imediator.mkp_pemohon_mukim_id',
                                    'spk__imediator.mkp_pemohon_jantina_id',
                                    'spk__imediator.mkp_pemohon_kaum_id',
                                    'users.user_email AS mkp_pemohon_email',
                                    'spk__imediator.mkp_pemohon_alamat',
                                    'users__profile.no_phone AS mkp_pemohon_no_phone',
                                    'spk__imediator.mkp_pemohon_alamat_p',
                                    'spk__imediator.mkp_pemohon_no_phone_p',
                                    'spk__imediator.mkp_pemohon_kategori_id',
                                    'spk__imediator.mkp_pemohon_tahap_id',
                                    'spk__imediator.mkp_pemohon_akademik',
                                    'spk__imediator.mkp_pemohon_khusus',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_tarikh_dilantik,'%d/%m/%Y') AS mkp_tarikh_dilantik"),
                                    'spk__imediator.mkp_file_avatar',
                                    'spk__imediator.status',
                                    'spk__imediator.dihantar_by',
                                    'spk__imediator.disokong_by',
                                    'spk__imediator.disokong_note',
                                    'spk__imediator.disokong_p_by',
                                    'spk__imediator.disokong_p_note',
                                    'spk__imediator.disemak_by',
                                    'spk__imediator.disemak_note',
                                    'spk__imediator.dilulus_by',
                                    'spk__imediator.dilulus_note',
                                    'spk__imediator.dilantik_by',
                                    'spk__imediator.dilantik_note'
                                    )
                            ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                            ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                            ->leftJoin('krt__profile','krt__profile.id','=','spk__imediator.krt_profile_id')
                            ->where('spk__imediator.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm23.pelantikan-permohonan-mkp-kp', 
            compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'kaum', 'jantina', 'pendidikan', 'mkp_kategori', 'mkp_tahap', 'kategori_kursus', 'peringkat_kursus', 'mkp'));
        }
    }

    function post_pelantikan_permohonan_mkp_kp(Request $request){
        $action = $request->post_pelantikan_permohonan_mkp_kp;
        $app_id = $request->ppmkp_spk_imediator_id;
        
        
        $rules = array(
            'ppmkp_imediator_status'            => 'required',
            'ppmkp_dilantik_note'               => 'required',
        );

        $messages = [
            'ppmkp_imediator_status.required'  => 'Ruangan Status dipilih',
            'ppmkp_dilantik_note.required'      => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $pelantikan_permohonan_mkp                  = SPK_imediator::where($where)->first();
                $pelantikan_permohonan_mkp->status          = $request->ppmkp_imediator_status;
                $pelantikan_permohonan_mkp->dilantik_by     = Auth::user()->user_id;
                $pelantikan_permohonan_mkp->dilantik_date   = date('Y-m-d H:i:s');
                $pelantikan_permohonan_mkp->dilantik_note   = $request->ppmkp_dilantik_note;
                $pelantikan_permohonan_mkp->save();
            }
        }
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    function senarai_mkp_dilantik_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('spk__imediator')
                        ->select('spk__imediator.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'users__profile.user_fullname AS mkp_pemohon_nama',
                                'users__profile.no_ic AS mkp_pemohon_ic',
                                'users__profile.no_phone AS mkp_pemohon_no_phone',
                                'users.user_email AS mkp_pemohon_email',
                                'spk__imediator.status AS status',
                                'ref__status_spk_imediator.status_description AS status_description')
                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                        ->leftJoin('ref__status_spk_imediator','ref__status_spk_imediator.id','=','spk__imediator.status')
                        ->whereIN('spk__imediator.status',[1])
                        ->where('users__profile.daerah_id', '=', Auth::user()->daerah_id)
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
            return view('rt-sm23.senarai-mkp-dilantik-ppd',compact('roles_menu'));
        }
    }

    function profile_mkp_ppd(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $bandar             = RefBandar::where('status', '=', true)->get();
            $parlimen           = RefParlimen::where('status', '=', true)->get();
            $dun                = RefDUN::where('status', '=', true)->get();
            $pbt                = RefPBT::where('status', '=', true)->get();
            $krt                = KRT_Profile::where('krt_status', '=', true)->get();
            $kaum               = RefKaum::where('status', '=', true)->get();
            $jantina            = RefJantina::where('status', '=', true)->get();
            $pendidikan         = RefPendidikan::where('pendidikan_status', '=', true)->get();
            $mkp_kategori       = Ref_SPK_MKP_Kategori::where('status', '=', true)->get();
            $mkp_tahap          = Ref_SPK_MKP_Tahap::where('status', '=', true)->get();
            $kategori_kursus    = Ref_SPK_MKP_Kategori_Kursus::where('status', '=', true)->get();
            $peringkat_kursus   = Ref_SPK_MKP_Peringkat_Kursus::where('status', '=', true)->get();
            $mkp                = DB::table('spk__imediator')
                                ->select('spk__imediator.id',
                                    'spk__imediator.hasRT',
                                    'krt__profile.state_id AS krt_state_id',
                                    'krt__profile.daerah_id AS krt_daerah_id',
                                    'spk__imediator.krt_profile_id',
                                    'users__profile.user_fullname AS mkp_pemohon_nama',
                                    'users__profile.no_ic AS mkp_pemohon_ic',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_pemohon_tarikh_lahir,'%d/%m/%Y') AS mkp_pemohon_tarikh_lahir"),
                                    'users__profile.state_id AS mkp_pemohon_state_id',
                                    'users__profile.daerah_id AS mkp_pemohon_daerah_id',
                                    'spk__imediator.mkp_pemohon_parlimen_id',
                                    'spk__imediator.mkp_pemohon_pbt_id',
                                    'spk__imediator.mkp_pemohon_dun_id',
                                    'spk__imediator.mkp_pemohon_mukim_id',
                                    'spk__imediator.mkp_pemohon_jantina_id',
                                    'spk__imediator.mkp_pemohon_kaum_id',
                                    'users.user_email AS mkp_pemohon_email',
                                    'spk__imediator.mkp_pemohon_alamat',
                                    'users__profile.no_phone AS mkp_pemohon_no_phone',
                                    'spk__imediator.mkp_pemohon_alamat_p',
                                    'spk__imediator.mkp_pemohon_no_phone_p',
                                    'spk__imediator.mkp_pemohon_kategori_id',
                                    'spk__imediator.mkp_pemohon_tahap_id',
                                    'spk__imediator.mkp_pemohon_akademik',
                                    'spk__imediator.mkp_pemohon_khusus',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_tarikh_dilantik,'%d/%m/%Y') AS mkp_tarikh_dilantik"),
                                    'spk__imediator.mkp_file_avatar',
                                    'spk__imediator.status',
                                    'spk__imediator.dihantar_by',
                                    'spk__imediator.disokong_by',
                                    'spk__imediator.disokong_note',
                                    'spk__imediator.disokong_p_by',
                                    'spk__imediator.disokong_p_note',
                                    'spk__imediator.disemak_by',
                                    'spk__imediator.disemak_note',
                                    'spk__imediator.dilulus_by',
                                    'spk__imediator.dilulus_note',
                                    'spk__imediator.dilantik_by',
                                    'spk__imediator.dilantik_note')
                            ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                            ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                            ->leftJoin('krt__profile','krt__profile.id','=','spk__imediator.krt_profile_id')
                            ->where('spk__imediator.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm23.profile-mkp-ppd', 
            compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'kaum', 'jantina', 'pendidikan', 'mkp_kategori', 'mkp_tahap', 'kategori_kursus', 'peringkat_kursus', 'mkp'));
        }
    }

    function senarai_mkp_dilantik_ppmk(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('spk__imediator')
                        ->select('spk__imediator.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'users__profile.user_fullname AS mkp_pemohon_nama',
                                'users__profile.no_ic AS mkp_pemohon_ic',
                                'users__profile.no_phone AS mkp_pemohon_no_phone',
                                'users.user_email AS mkp_pemohon_email',
                                'spk__imediator.status AS status',
                                'ref__status_spk_imediator.status_description AS status_description')
                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                        ->leftJoin('ref__status_spk_imediator','ref__status_spk_imediator.id','=','spk__imediator.status')
                        ->whereIN('spk__imediator.status',[1])
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
            return view('rt-sm23.senarai-mkp-dilantik-ppmk',compact('roles_menu','daerah'));
        }
    }

    function profile_mkp_ppmk(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $bandar             = RefBandar::where('status', '=', true)->get();
            $parlimen           = RefParlimen::where('status', '=', true)->get();
            $dun                = RefDUN::where('status', '=', true)->get();
            $pbt                = RefPBT::where('status', '=', true)->get();
            $krt                = KRT_Profile::where('krt_status', '=', true)->get();
            $kaum               = RefKaum::where('status', '=', true)->get();
            $jantina            = RefJantina::where('status', '=', true)->get();
            $pendidikan         = RefPendidikan::where('pendidikan_status', '=', true)->get();
            $mkp_kategori       = Ref_SPK_MKP_Kategori::where('status', '=', true)->get();
            $mkp_tahap          = Ref_SPK_MKP_Tahap::where('status', '=', true)->get();
            $kategori_kursus    = Ref_SPK_MKP_Kategori_Kursus::where('status', '=', true)->get();
            $peringkat_kursus   = Ref_SPK_MKP_Peringkat_Kursus::where('status', '=', true)->get();
            $mkp                = DB::table('spk__imediator')
                            ->select('spk__imediator.id',
                                    'spk__imediator.hasRT',
                                    'krt__profile.state_id AS krt_state_id',
                                    'krt__profile.daerah_id AS krt_daerah_id',
                                    'spk__imediator.krt_profile_id',
                                    'users__profile.user_fullname AS mkp_pemohon_nama',
                                    'users__profile.no_ic AS mkp_pemohon_ic',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_pemohon_tarikh_lahir,'%d/%m/%Y') AS mkp_pemohon_tarikh_lahir"),
                                    'users__profile.state_id AS mkp_pemohon_state_id',
                                    'users__profile.daerah_id AS mkp_pemohon_daerah_id',
                                    'spk__imediator.mkp_pemohon_parlimen_id',
                                    'spk__imediator.mkp_pemohon_pbt_id',
                                    'spk__imediator.mkp_pemohon_dun_id',
                                    'spk__imediator.mkp_pemohon_mukim_id',
                                    'spk__imediator.mkp_pemohon_jantina_id',
                                    'spk__imediator.mkp_pemohon_kaum_id',
                                    'users.user_email AS mkp_pemohon_email',
                                    'spk__imediator.mkp_pemohon_alamat',
                                    'users__profile.no_phone AS mkp_pemohon_no_phone',
                                    'spk__imediator.mkp_pemohon_alamat_p',
                                    'spk__imediator.mkp_pemohon_no_phone_p',
                                    'spk__imediator.mkp_pemohon_kategori_id',
                                    'spk__imediator.mkp_pemohon_tahap_id',
                                    'spk__imediator.mkp_pemohon_akademik',
                                    'spk__imediator.mkp_pemohon_khusus',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_tarikh_dilantik,'%d/%m/%Y') AS mkp_tarikh_dilantik"),
                                    'spk__imediator.mkp_file_avatar',
                                    'spk__imediator.status',
                                    'spk__imediator.dihantar_by',
                                    'spk__imediator.disokong_by',
                                    'spk__imediator.disokong_note',
                                    'spk__imediator.disokong_p_by',
                                    'spk__imediator.disokong_p_note',
                                    'spk__imediator.disemak_by',
                                    'spk__imediator.disemak_note',
                                    'spk__imediator.dilulus_by',
                                    'spk__imediator.dilulus_note',
                                    'spk__imediator.dilantik_by',
                                    'spk__imediator.dilantik_note'
                                    )
                            ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                            ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                            ->leftJoin('krt__profile','krt__profile.id','=','spk__imediator.krt_profile_id')
                            ->where('spk__imediator.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm23.profile-mkp-ppmk', 
            compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'kaum', 'jantina', 'pendidikan', 'mkp_kategori', 'mkp_tahap', 'kategori_kursus', 'peringkat_kursus', 'mkp'));
        }
    }

    function senarai_mkp_dilantik_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('spk__imediator')
                        ->select('spk__imediator.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'users__profile.user_fullname AS mkp_pemohon_nama',
                                'users__profile.no_ic AS mkp_pemohon_ic',
                                'users__profile.no_phone AS mkp_pemohon_no_phone',
                                'users.user_email AS mkp_pemohon_email',
                                'spk__imediator.status AS status',
                                'ref__status_spk_imediator.status_description AS status_description')
                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                        ->leftJoin('ref__status_spk_imediator','ref__status_spk_imediator.id','=','spk__imediator.status')
                        ->whereIN('spk__imediator.status',[1])
                        ->where('users__profile.state_id', '=', Auth::user()->state_id)
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
             $daerah    = RefDaerah::where('status', '=',  true)
                        ->where('ref__daerahs.state_id', '=', Auth::user()->state_id)    
                        ->get();
            return view('rt-sm23.senarai-mkp-dilantik-ppn', compact('roles_menu','daerah'));
        }
    }

    function profile_mkp_ppn(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $bandar             = RefBandar::where('status', '=', true)->get();
            $parlimen           = RefParlimen::where('status', '=', true)->get();
            $dun                = RefDUN::where('status', '=', true)->get();
            $pbt                = RefPBT::where('status', '=', true)->get();
            $krt                = KRT_Profile::where('krt_status', '=', true)->get();
            $kaum               = RefKaum::where('status', '=', true)->get();
            $jantina            = RefJantina::where('status', '=', true)->get();
            $pendidikan         = RefPendidikan::where('pendidikan_status', '=', true)->get();
            $mkp_kategori       = Ref_SPK_MKP_Kategori::where('status', '=', true)->get();
            $mkp_tahap          = Ref_SPK_MKP_Tahap::where('status', '=', true)->get();
            $kategori_kursus    = Ref_SPK_MKP_Kategori_Kursus::where('status', '=', true)->get();
            $peringkat_kursus   = Ref_SPK_MKP_Peringkat_Kursus::where('status', '=', true)->get();
            $mkp                = DB::table('spk__imediator')
                                ->select('spk__imediator.id',
                                    'spk__imediator.hasRT',
                                    'krt__profile.state_id AS krt_state_id',
                                    'krt__profile.daerah_id AS krt_daerah_id',
                                    'spk__imediator.krt_profile_id',
                                    'users__profile.user_fullname AS mkp_pemohon_nama',
                                    'users__profile.no_ic AS mkp_pemohon_ic',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_pemohon_tarikh_lahir,'%d/%m/%Y') AS mkp_pemohon_tarikh_lahir"),
                                    'users__profile.state_id AS mkp_pemohon_state_id',
                                    'users__profile.daerah_id AS mkp_pemohon_daerah_id',
                                    'spk__imediator.mkp_pemohon_parlimen_id',
                                    'spk__imediator.mkp_pemohon_pbt_id',
                                    'spk__imediator.mkp_pemohon_dun_id',
                                    'spk__imediator.mkp_pemohon_mukim_id',
                                    'spk__imediator.mkp_pemohon_jantina_id',
                                    'spk__imediator.mkp_pemohon_kaum_id',
                                    'users.user_email AS mkp_pemohon_email',
                                    'spk__imediator.mkp_pemohon_alamat',
                                    'users__profile.no_phone AS mkp_pemohon_no_phone',
                                    'spk__imediator.mkp_pemohon_alamat_p',
                                    'spk__imediator.mkp_pemohon_no_phone_p',
                                    'spk__imediator.mkp_pemohon_kategori_id',
                                    'spk__imediator.mkp_pemohon_tahap_id',
                                    'spk__imediator.mkp_pemohon_akademik',
                                    'spk__imediator.mkp_pemohon_khusus',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_tarikh_dilantik,'%d/%m/%Y') AS mkp_tarikh_dilantik"),
                                    'spk__imediator.mkp_file_avatar',
                                    'spk__imediator.status',
                                    'spk__imediator.dihantar_by',
                                    'spk__imediator.disokong_by',
                                    'spk__imediator.disokong_note',
                                    'spk__imediator.disokong_p_by',
                                    'spk__imediator.disokong_p_note',
                                    'spk__imediator.disemak_by',
                                    'spk__imediator.disemak_note',
                                    'spk__imediator.dilulus_by',
                                    'spk__imediator.dilulus_note',
                                    'spk__imediator.dilantik_by',
                                    'spk__imediator.dilantik_note'
                                    )
                            ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                            ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                            ->leftJoin('krt__profile','krt__profile.id','=','spk__imediator.krt_profile_id')
                            ->where('spk__imediator.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm23.profile-mkp-ppn', 
            compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'kaum', 'jantina', 'pendidikan', 'mkp_kategori', 'mkp_tahap', 'kategori_kursus', 'peringkat_kursus', 'mkp'));
        }
    }

    function senarai_mkp_dilantik_upmk(Request $request){
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
            $data = DB::table('spk__imediator')
                        ->select('spk__imediator.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'users__profile.user_fullname AS mkp_pemohon_nama',
                                'users__profile.no_ic AS mkp_pemohon_ic',
                                'users__profile.no_phone AS mkp_pemohon_no_phone',
                                'users.user_email AS mkp_pemohon_email',
                                'spk__imediator.status AS status',
                                'ref__status_spk_imediator.status_description AS status_description')
                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                        ->leftJoin('ref__status_spk_imediator','ref__status_spk_imediator.id','=','spk__imediator.status')
                        ->whereIN('spk__imediator.status',[1])
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
            return view('rt-sm23.senarai-mkp-dilantik-upmk', compact('roles_menu','state'));
        }
    }

    function profile_mkp_upmk(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $bandar             = RefBandar::where('status', '=', true)->get();
            $parlimen           = RefParlimen::where('status', '=', true)->get();
            $dun                = RefDUN::where('status', '=', true)->get();
            $pbt                = RefPBT::where('status', '=', true)->get();
            $krt                = KRT_Profile::where('krt_status', '=', true)->get();
            $kaum               = RefKaum::where('status', '=', true)->get();
            $jantina            = RefJantina::where('status', '=', true)->get();
            $pendidikan         = RefPendidikan::where('pendidikan_status', '=', true)->get();
            $mkp_kategori       = Ref_SPK_MKP_Kategori::where('status', '=', true)->get();
            $mkp_tahap          = Ref_SPK_MKP_Tahap::where('status', '=', true)->get();
            $kategori_kursus    = Ref_SPK_MKP_Kategori_Kursus::where('status', '=', true)->get();
            $peringkat_kursus   = Ref_SPK_MKP_Peringkat_Kursus::where('status', '=', true)->get();
            $mkp                = DB::table('spk__imediator')
                                ->select('spk__imediator.id',
                                    'spk__imediator.hasRT',
                                    'krt__profile.state_id AS krt_state_id',
                                    'krt__profile.daerah_id AS krt_daerah_id',
                                    'spk__imediator.krt_profile_id',
                                    'users__profile.user_fullname AS mkp_pemohon_nama',
                                    'users__profile.no_ic AS mkp_pemohon_ic',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_pemohon_tarikh_lahir,'%d/%m/%Y') AS mkp_pemohon_tarikh_lahir"),
                                    'users__profile.state_id AS mkp_pemohon_state_id',
                                    'users__profile.daerah_id AS mkp_pemohon_daerah_id',
                                    'spk__imediator.mkp_pemohon_parlimen_id',
                                    'spk__imediator.mkp_pemohon_pbt_id',
                                    'spk__imediator.mkp_pemohon_dun_id',
                                    'spk__imediator.mkp_pemohon_mukim_id',
                                    'spk__imediator.mkp_pemohon_jantina_id',
                                    'spk__imediator.mkp_pemohon_kaum_id',
                                    'users.user_email AS mkp_pemohon_email',
                                    'spk__imediator.mkp_pemohon_alamat',
                                    'users__profile.no_phone AS mkp_pemohon_no_phone',
                                    'spk__imediator.mkp_pemohon_alamat_p',
                                    'spk__imediator.mkp_pemohon_no_phone_p',
                                    'spk__imediator.mkp_pemohon_kategori_id',
                                    'spk__imediator.mkp_pemohon_tahap_id',
                                    'spk__imediator.mkp_pemohon_akademik',
                                    'spk__imediator.mkp_pemohon_khusus',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_tarikh_dilantik,'%d/%m/%Y') AS mkp_tarikh_dilantik"),
                                    'spk__imediator.mkp_file_avatar',
                                    'spk__imediator.status',
                                    'spk__imediator.dihantar_by',
                                    'spk__imediator.disokong_by',
                                    'spk__imediator.disokong_note',
                                    'spk__imediator.disokong_p_by',
                                    'spk__imediator.disokong_p_note',
                                    'spk__imediator.disemak_by',
                                    'spk__imediator.disemak_note',
                                    'spk__imediator.dilulus_by',
                                    'spk__imediator.dilulus_note',
                                    'spk__imediator.dilantik_by',
                                    'spk__imediator.dilantik_note'
                                    )
                            ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                            ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                            ->leftJoin('krt__profile','krt__profile.id','=','spk__imediator.krt_profile_id')
                            ->where('spk__imediator.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm23.profile-mkp-upmk', 
            compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'kaum', 'jantina', 'pendidikan', 'mkp_kategori', 'mkp_tahap', 'kategori_kursus', 'peringkat_kursus', 'mkp'));
        }
    }

    function senarai_mkp_dilantik_ppp(Request $request){
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
            $data = DB::table('spk__imediator')
                        ->select('spk__imediator.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'users__profile.user_fullname AS mkp_pemohon_nama',
                                'users__profile.no_ic AS mkp_pemohon_ic',
                                'users__profile.no_phone AS mkp_pemohon_no_phone',
                                'users.user_email AS mkp_pemohon_email',
                                'spk__imediator.status AS status',
                                'ref__status_spk_imediator.status_description AS status_description')
                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                        ->leftJoin('ref__status_spk_imediator','ref__status_spk_imediator.id','=','spk__imediator.status')
                        ->whereIN('spk__imediator.status',[1])
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
            return view('rt-sm23.senarai-mkp-dilantik-ppp', compact('roles_menu','state'));
        }
    }

    function profile_mkp_ppp(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $bandar             = RefBandar::where('status', '=', true)->get();
            $parlimen           = RefParlimen::where('status', '=', true)->get();
            $dun                = RefDUN::where('status', '=', true)->get();
            $pbt                = RefPBT::where('status', '=', true)->get();
            $krt                = KRT_Profile::where('krt_status', '=', true)->get();
            $kaum               = RefKaum::where('status', '=', true)->get();
            $jantina            = RefJantina::where('status', '=', true)->get();
            $pendidikan         = RefPendidikan::where('pendidikan_status', '=', true)->get();
            $mkp_kategori       = Ref_SPK_MKP_Kategori::where('status', '=', true)->get();
            $mkp_tahap          = Ref_SPK_MKP_Tahap::where('status', '=', true)->get();
            $kategori_kursus    = Ref_SPK_MKP_Kategori_Kursus::where('status', '=', true)->get();
            $peringkat_kursus   = Ref_SPK_MKP_Peringkat_Kursus::where('status', '=', true)->get();
            $mkp                = DB::table('spk__imediator')
                                ->select('spk__imediator.id',
                                    'spk__imediator.hasRT',
                                    'krt__profile.state_id AS krt_state_id',
                                    'krt__profile.daerah_id AS krt_daerah_id',
                                    'spk__imediator.krt_profile_id',
                                    'users__profile.user_fullname AS mkp_pemohon_nama',
                                    'users__profile.no_ic AS mkp_pemohon_ic',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_pemohon_tarikh_lahir,'%d/%m/%Y') AS mkp_pemohon_tarikh_lahir"),
                                    'users__profile.state_id AS mkp_pemohon_state_id',
                                    'users__profile.daerah_id AS mkp_pemohon_daerah_id',
                                    'spk__imediator.mkp_pemohon_parlimen_id',
                                    'spk__imediator.mkp_pemohon_pbt_id',
                                    'spk__imediator.mkp_pemohon_dun_id',
                                    'spk__imediator.mkp_pemohon_mukim_id',
                                    'spk__imediator.mkp_pemohon_jantina_id',
                                    'spk__imediator.mkp_pemohon_kaum_id',
                                    'users.user_email AS mkp_pemohon_email',
                                    'spk__imediator.mkp_pemohon_alamat',
                                    'users__profile.no_phone AS mkp_pemohon_no_phone',
                                    'spk__imediator.mkp_pemohon_alamat_p',
                                    'spk__imediator.mkp_pemohon_no_phone_p',
                                    'spk__imediator.mkp_pemohon_kategori_id',
                                    'spk__imediator.mkp_pemohon_tahap_id',
                                    'spk__imediator.mkp_pemohon_akademik',
                                    'spk__imediator.mkp_pemohon_khusus',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_tarikh_dilantik,'%d/%m/%Y') AS mkp_tarikh_dilantik"),
                                    'spk__imediator.mkp_file_avatar',
                                    'spk__imediator.status',
                                    'spk__imediator.dihantar_by',
                                    'spk__imediator.disokong_by',
                                    'spk__imediator.disokong_note',
                                    'spk__imediator.disokong_p_by',
                                    'spk__imediator.disokong_p_note',
                                    'spk__imediator.disemak_by',
                                    'spk__imediator.disemak_note',
                                    'spk__imediator.dilulus_by',
                                    'spk__imediator.dilulus_note',
                                    'spk__imediator.dilantik_by',
                                    'spk__imediator.dilantik_note'
                                    )
                            ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                            ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                            ->leftJoin('krt__profile','krt__profile.id','=','spk__imediator.krt_profile_id')
                            ->where('spk__imediator.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm23.profile-mkp-ppp', 
            compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'kaum', 'jantina', 'pendidikan', 'mkp_kategori', 'mkp_tahap', 'kategori_kursus', 'peringkat_kursus', 'mkp'));
        }
    }

    function senarai_mkp_dilantik_kp(Request $request){
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
            $data = DB::table('spk__imediator')
                        ->select('spk__imediator.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'users__profile.user_fullname AS mkp_pemohon_nama',
                                'users__profile.no_ic AS mkp_pemohon_ic',
                                'users__profile.no_phone AS mkp_pemohon_no_phone',
                                'users.user_email AS mkp_pemohon_email',
                                'spk__imediator.status AS status',
                                'ref__status_spk_imediator.status_description AS status_description')
                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                        ->leftJoin('ref__status_spk_imediator','ref__status_spk_imediator.id','=','spk__imediator.status')
                        ->whereIN('spk__imediator.status',[1])
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
            return view('rt-sm23.senarai-mkp-dilantik-kp', compact('roles_menu','state'));
        }
    }

    function profile_mkp_kp(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $bandar             = RefBandar::where('status', '=', true)->get();
            $parlimen           = RefParlimen::where('status', '=', true)->get();
            $dun                = RefDUN::where('status', '=', true)->get();
            $pbt                = RefPBT::where('status', '=', true)->get();
            $krt                = KRT_Profile::where('krt_status', '=', true)->get();
            $kaum               = RefKaum::where('status', '=', true)->get();
            $jantina            = RefJantina::where('status', '=', true)->get();
            $pendidikan         = RefPendidikan::where('pendidikan_status', '=', true)->get();
            $mkp_kategori       = Ref_SPK_MKP_Kategori::where('status', '=', true)->get();
            $mkp_tahap          = Ref_SPK_MKP_Tahap::where('status', '=', true)->get();
            $kategori_kursus    = Ref_SPK_MKP_Kategori_Kursus::where('status', '=', true)->get();
            $peringkat_kursus   = Ref_SPK_MKP_Peringkat_Kursus::where('status', '=', true)->get();
            $mkp                = DB::table('spk__imediator')
                                ->select('spk__imediator.id',
                                    'spk__imediator.hasRT',
                                    'krt__profile.state_id AS krt_state_id',
                                    'krt__profile.daerah_id AS krt_daerah_id',
                                    'spk__imediator.krt_profile_id',
                                    'users__profile.user_fullname AS mkp_pemohon_nama',
                                    'users__profile.no_ic AS mkp_pemohon_ic',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_pemohon_tarikh_lahir,'%d/%m/%Y') AS mkp_pemohon_tarikh_lahir"),
                                    'users__profile.state_id AS mkp_pemohon_state_id',
                                    'users__profile.daerah_id AS mkp_pemohon_daerah_id',
                                    'spk__imediator.mkp_pemohon_parlimen_id',
                                    'spk__imediator.mkp_pemohon_pbt_id',
                                    'spk__imediator.mkp_pemohon_dun_id',
                                    'spk__imediator.mkp_pemohon_mukim_id',
                                    'spk__imediator.mkp_pemohon_jantina_id',
                                    'spk__imediator.mkp_pemohon_kaum_id',
                                    'users.user_email AS mkp_pemohon_email',
                                    'spk__imediator.mkp_pemohon_alamat',
                                    'users__profile.no_phone AS mkp_pemohon_no_phone',
                                    'spk__imediator.mkp_pemohon_alamat_p',
                                    'spk__imediator.mkp_pemohon_no_phone_p',
                                    'spk__imediator.mkp_pemohon_kategori_id',
                                    'spk__imediator.mkp_pemohon_tahap_id',
                                    'spk__imediator.mkp_pemohon_akademik',
                                    'spk__imediator.mkp_pemohon_khusus',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_tarikh_dilantik,'%d/%m/%Y') AS mkp_tarikh_dilantik"),
                                    'spk__imediator.mkp_file_avatar',
                                    'spk__imediator.status',
                                    'spk__imediator.dihantar_by',
                                    'spk__imediator.disokong_by',
                                    'spk__imediator.disokong_note',
                                    'spk__imediator.disokong_p_by',
                                    'spk__imediator.disokong_p_note',
                                    'spk__imediator.disemak_by',
                                    'spk__imediator.disemak_note',
                                    'spk__imediator.dilulus_by',
                                    'spk__imediator.dilulus_note',
                                    'spk__imediator.dilantik_by',
                                    'spk__imediator.dilantik_note'
                                    )
                            ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                            ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                            ->leftJoin('krt__profile','krt__profile.id','=','spk__imediator.krt_profile_id')
                            ->where('spk__imediator.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm23.profile-mkp-kp', 
            compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'kaum', 'jantina', 'pendidikan', 'mkp_kategori', 'mkp_tahap', 'kategori_kursus', 'peringkat_kursus', 'mkp'));
        }
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    function senarai_permohonan_laporan_mediasi(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('spk__imediator_mediasi')
                        ->select('spk__imediator_mediasi.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'ref__spk_mkp_mediasi.kluster_description AS kluster',
                                DB::raw(" DATE_FORMAT(spk__imediator_mediasi.mediasi_tarikh,'%d/%m/%Y') AS mediasi_tarikh"),
                                'spk__imediator_mediasi.mediasi_alamat AS mediasi_alamat',
                                'users__profile.user_fullname AS nama_mediator',
                                'spk__imediator_mediasi.mediasi_pembantu_nama AS mediasi_pembantu_nama',
                                'spk__imediator_mediasi.status AS status',
                                'ref__status_spk_imediator_mediasi.status_description AS status_description')
                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_mediasi.spk_imediator_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                        ->leftJoin('ref__spk_mkp_mediasi','ref__spk_mkp_mediasi.id','=','spk__imediator_mediasi.ref_mkp_kategori_id')
                        ->leftJoin('ref__status_spk_imediator_mediasi','ref__status_spk_imediator_mediasi.id','=','spk__imediator_mediasi.status')
                        ->where('spk__imediator_mediasi.dihantar_by', '=', Auth::user()->user_id)
                        ->whereIN('spk__imediator_mediasi.status',[2,3,4,5,6,7,8,9,10,11,12])
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
            $mkp        = DB::table('spk__imediator')
                        ->select('spk__imediator.id AS id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->where('spk__imediator.user_id', '=', Auth::user()->user_id)
                        ->limit(1)
                        ->first();
            return view('rt-sm23.senarai-permohonan-laporan-mediasi', compact('roles_menu','mkp'));
        }
    }

    function post_permohonan_laporan_mediasi(Request $request){
        
        $action = $request->post_permohonan_laporan_mediasi;
        $user_id = $request->splm_mkp_id;
        
        $rules = array(
           
        );

        $messages = [
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm23.senarai_permohonan_laporan_mediasi'))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'add') {
                $laporan_mediasi                    = new SPK_iMediator_mediasi;
                $laporan_mediasi->spk_imediator_id  = $user_id;
                $laporan_mediasi->status            = 2;
                $laporan_mediasi->dihantar_by       = Auth::user()->user_id;
                $laporan_mediasi->save();
            }
           
            return Redirect::to(route('rt-sm23.permohonan_laporan_mediasi_mkp',$laporan_mediasi->id));
        }

    }

    function permohonan_laporan_mediasi_mkp(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_mkp_value') {
                $value = $request->value;
                $where = array('id' => $value);
                $data  = SPK_imediator::where('spk__imediator.id', '=', $where)
                        ->select('spk__imediator.*', 'krt__profile.krt_nama')
                        ->leftJoin('krt__profile','krt__profile.id','=','spk__imediator.krt_profile_id')
                        ->get();
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
            $mediasi_kluster            = Ref_SPK_MKP_Mediasi::where('status', '=', true)->get();
            $peringkat_kes              = Ref_SPK_MKP_Peringkat::where('status', '=', true)->get();
            $laporan_mediasi            = DB::table('spk__imediator_mediasi')
                                        ->select('spk__imediator_mediasi.id',
                                            'spk__imediator_mediasi.spk_imediator_id AS spk_imediator_id',
                                            'users__profile.user_fullname AS mkp_nama',
                                            'users__profile.no_ic AS mkp_pemohon_ic',
                                            'users__profile.no_phone AS mkp_pemohon_no_phone',
                                            'spk__imediator_mediasi.mediasi_pembantu_nama AS mediasi_pembantu_nama',
                                            'spk__imediator_mediasi.mediasi_pembantu_ic AS mediasi_pembantu_ic',
                                            'spk__imediator_mediasi.mediasi_pembantu_phone AS mediasi_pembantu_phone',
                                            'spk__imediator_mediasi.ref_mkp_kategori_id AS ref_mkp_kategori_id',
                                            DB::raw(" DATE_FORMAT(spk__imediator_mediasi.mediasi_tarikh,'%d/%m/%Y') AS mediasi_tarikh"),
                                            'spk__imediator_mediasi.mediasi_alamat AS mediasi_alamat',
                                            'spk__imediator_mediasi.mediasi_ngo_terlibat AS mediasi_ngo_terlibat',
                                            'spk__imediator_mediasi.mediasi_ringkasan_kes AS mediasi_ringkasan_kes',
                                            'spk__imediator_mediasi.ref_spk_mkp_peringkat_id AS peringkat_kes_id',
                                            'spk__imediator_mediasi.mediasi_status_kes AS mediasi_status_kes',
                                            'spk__imediator_mediasi.mediasi_note_penyelesaian_kes AS mediasi_note_penyelesaian_kes',
                                            'spk__imediator_mediasi.mediasi_note_sebab_kes_xberjaya AS mediasi_note_sebab_kes_xberjaya',
                                            'spk__imediator_mediasi.status AS status',
                                            'spk__imediator_mediasi.disokong_note AS disokong_note',
                                            'spk__imediator_mediasi.disokong_p_note AS disokong_p_note',
                                            'spk__imediator_mediasi.disahkan_note AS disahkan_note',
                                            'spk__imediator_mediasi.disemak_note AS disemak_note',
                                            'spk__imediator_mediasi.diluluskan_note AS diluluskan_note',
                                            'ref__status_spk_imediator_mediasi.status_description AS status_description')
                                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_mediasi.spk_imediator_id')
                                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                                        ->leftJoin('ref__spk_mkp_mediasi','ref__spk_mkp_mediasi.id','=','spk__imediator_mediasi.ref_mkp_kategori_id')
                                        ->leftJoin('ref__status_spk_imediator_mediasi','ref__status_spk_imediator_mediasi.id','=','spk__imediator_mediasi.status')
                                        ->where('spk__imediator_mediasi.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            return view('rt-sm23.permohonan-laporan-mediasi-mkp', compact('roles_menu','mediasi_kluster', 'peringkat_kes', 'laporan_mediasi'));
        }
    }

    function get_laporan_mediasi_terlibat_table(Request $request, $id){
        $data   = DB::table('spk__imediator_mediasi_p_terlibat')
                    ->select('spk__imediator_mediasi_p_terlibat.*')
                    ->where('spk__imediator_mediasi_p_terlibat.spk_imediator_mediasi_id', '=', $id)
                    ->get();
                return Datatables::of($data)
                    ->make(true);
    }

    function post_add_pihak_terlibat_laporan_mediasi(Request $request){
        $action = $request->post_add_pihak_terlibat_laporan_mediasi;
        $app_id = $request->pkkmkp3_spk_imediator_mediasi_id;
        
        $rules = array(
            'pkkmkp3_pihak_pertama'             => 'required',
            'pkkmkp3_pihak_kedua'               => 'required',
        );

        $messages = [
            'pkkmkp3_pihak_pertama.required'    => 'Ruangan Pihak Pertama mesti diisi',
            'pkkmkp3_pihak_kedua.required'      => 'Ruangan Pihak Kedua mesti diisi',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $pihak_terlibat = new SPK_iMediator_mediasi_P_Terlibat;
                $pihak_terlibat->spk_imediator_mediasi_id   = $app_id;
                $pihak_terlibat->pihak_pertama              = $request->pkkmkp3_pihak_pertama;
                $pihak_terlibat->pihak_kedua                = $request->pkkmkp3_pihak_kedua;
                $pihak_terlibat->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_laporan_mediasi_terlibat($id){
        $data = DB::table('spk__imediator_mediasi_p_terlibat')->where('id', '=', $id)->delete();
    }

    function post_permohonan_laporan_mediasi_1(Request $request){
        $action = $request->post_permohonan_laporan_mediasi_1;
        $app_id = $request->plmmkp5_spk_imediator_mediasi_id;
        $status_kes_id = $request->plmmkp4_mediasi_status_kes;
        
        $rules_main = array(                
            'plmmkp2_ref_mkp_kategori_id'                       => 'required',
            'plmmkp2_mediasi_tarikh'                            => 'required',
            'plmmkp2_mediasi_alamat'                            => 'required',
            'plmmkp4_mediasi_ringkasan_kes'                     => 'required',
            'plmmkp4_peringkat_kes_id'                          => 'required',
            'plmmkp4_mediasi_status_kes'                        => 'required',
        );

        if ($status_kes_id == 'Selesai') {
            $rules_sub_main = array(                
            'plmmkp4_mediasi_note_penyelesaian_kes'             => 'required',
            );
        }else{
            $rules_sub_main = array(                
                'plmmkp4_mediasi_note_sebab_kes_xberjaya'             => 'required',
                );
        }
        
        $messages = [
            'plmmkp2_ref_mkp_kategori_id.required'              => 'Ruangan Kluster / Bidang mesti dipilih',
            'plmmkp2_mediasi_tarikh.required'                   => 'Ruangan Tarikh Mediasi mesti dipilih',
            'plmmkp2_mediasi_alamat.required'                   => 'Ruangan Tempat Mediasi mesti diisi',
            'plmmkp4_mediasi_ringkasan_kes.required'            => 'Ruangan Ringkasan Kes / Isu mesti diisi',
            'plmmkp4_peringkat_kes_id.required'                 => 'Ruangan Peringkat Kes mesti diisi',
            'plmmkp4_mediasi_status_kes.required'               => 'Ruangan Status Kes mesti diisi',
            'plmmkp4_mediasi_note_penyelesaian_kes.required'    => 'Ruangan Nyatakan Terma-Terma Penyelesaian Kes/Isu mesti diisi',
            'plmmkp4_mediasi_note_sebab_kes_xberjaya.required'  => 'Ruangan Nyatakan Ulasan /  Sebab-Sebab mesti diisi',
            
        ];
        
        $rules = $rules_main + $rules_sub_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $carbon_obj = Carbon::createFromFormat('d/m/Y', $request->plmmkp2_mediasi_tarikh)->format('Y-m-d');
                $where = array('id' => $app_id);
                $update_permohonan_laporan_mediasi                                  = SPK_iMediator_mediasi::where($where)->first();
                $update_permohonan_laporan_mediasi->ref_mkp_kategori_id             = $request->plmmkp2_ref_mkp_kategori_id;
                $update_permohonan_laporan_mediasi->mediasi_tarikh                  = $carbon_obj;
                $update_permohonan_laporan_mediasi->mediasi_alamat                  = $request->plmmkp2_mediasi_alamat;
                $update_permohonan_laporan_mediasi->mediasi_pembantu_nama           = $request->plmmkp1_mediasi_pembantu_nama;
                $update_permohonan_laporan_mediasi->mediasi_pembantu_ic             = $request->plmmkp1_mediasi_pembantu_ic;
                $update_permohonan_laporan_mediasi->mediasi_pembantu_phone          = $request->plmmkp1_mediasi_pembantu_phone;
                $update_permohonan_laporan_mediasi->mediasi_ngo_terlibat            = $request->plmmkp4_mediasi_ngo_terlibat;
                $update_permohonan_laporan_mediasi->mediasi_ringkasan_kes           = $request->plmmkp4_mediasi_ringkasan_kes;
                $update_permohonan_laporan_mediasi->ref_spk_mkp_peringkat_id        = $request->plmmkp4_peringkat_kes_id;
                $update_permohonan_laporan_mediasi->mediasi_status_kes              = $request->plmmkp4_mediasi_status_kes;
                $update_permohonan_laporan_mediasi->mediasi_note_penyelesaian_kes   = $request->plmmkp4_mediasi_note_penyelesaian_kes;
                $update_permohonan_laporan_mediasi->mediasi_note_sebab_kes_xberjaya = $request->plmmkp4_mediasi_note_sebab_kes_xberjaya;
                $update_permohonan_laporan_mediasi->status                          = 3;
                $update_permohonan_laporan_mediasi->dihantar_date                   = date('Y-m-d H:i:s');
                $update_permohonan_laporan_mediasi->save();
                
            }
        }
    }

    function senarai_semakan_laporan_mediasi_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('spk__imediator_mediasi')
                        ->select('spk__imediator_mediasi.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'ref__spk_mkp_mediasi.kluster_description AS kluster',
                                DB::raw(" DATE_FORMAT(spk__imediator_mediasi.mediasi_tarikh,'%d/%m/%Y') AS mediasi_tarikh"),
                                'spk__imediator_mediasi.mediasi_alamat AS mediasi_alamat',
                                'users__profile.user_fullname AS nama_mediator',
                                'spk__imediator_mediasi.mediasi_pembantu_nama AS mediasi_pembantu_nama',
                                'spk__imediator_mediasi.status AS status',
                                'ref__status_spk_imediator_mediasi.status_description AS status_description')
                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_mediasi.spk_imediator_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                        ->leftJoin('ref__spk_mkp_mediasi','ref__spk_mkp_mediasi.id','=','spk__imediator_mediasi.ref_mkp_kategori_id')
                        ->leftJoin('ref__status_spk_imediator_mediasi','ref__status_spk_imediator_mediasi.id','=','spk__imediator_mediasi.status')
                        ->where('users__profile.daerah_id', '=', Auth::user()->daerah_id)
                        ->whereIN('spk__imediator.mkp_pemohon_kategori_id',[2,3,4,5])
                        ->whereIN('spk__imediator_mediasi.status',[3])
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
            return view('rt-sm23.senarai-semakan-laporan-mediasi-ppd',compact('roles_menu'));
        }
    }

    function semakan_laporan_mediasi_mkp_ppd(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_mkp_value') {
                $value = $request->value;
                $where = array('id' => $value);
                $data  = SPK_imediator::where('spk__imediator.id', '=', $where)
                        ->select('spk__imediator.*', 'krt__profile.krt_nama')
                        ->leftJoin('krt__profile','krt__profile.id','=','spk__imediator.krt_profile_id')
                        ->get();
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
            $mediasi_kluster            = Ref_SPK_MKP_Mediasi::where('status', '=', true)->get();
            $laporan_mediasi            = DB::table('spk__imediator_mediasi')
                                        ->select('spk__imediator_mediasi.id',
                                            'spk__imediator_mediasi.spk_imediator_id AS spk_imediator_id',
                                            'users__profile.user_fullname AS mkp_nama',
                                            'users__profile.no_ic AS mkp_no_ic',
                                            'users__profile.no_phone AS mkp_no_phone',
                                            'spk__imediator_mediasi.mediasi_pembantu_nama AS mediasi_pembantu_nama',
                                            'spk__imediator_mediasi.mediasi_pembantu_ic AS mediasi_pembantu_ic',
                                            'spk__imediator_mediasi.mediasi_pembantu_phone AS mediasi_pembantu_phone',
                                            'spk__imediator_mediasi.ref_mkp_kategori_id AS ref_mkp_kategori_id',
                                            DB::raw(" DATE_FORMAT(spk__imediator_mediasi.mediasi_tarikh,'%d/%m/%Y') AS mediasi_tarikh"),
                                            'spk__imediator_mediasi.mediasi_alamat AS mediasi_alamat',
                                            'spk__imediator_mediasi.mediasi_ngo_terlibat AS mediasi_ngo_terlibat',
                                            'spk__imediator_mediasi.mediasi_ringkasan_kes AS mediasi_ringkasan_kes',
                                            'spk__imediator_mediasi.mediasi_status_kes AS mediasi_status_kes',
                                            'spk__imediator_mediasi.mediasi_note_penyelesaian_kes AS mediasi_note_penyelesaian_kes',
                                            'spk__imediator_mediasi.mediasi_note_sebab_kes_xberjaya AS mediasi_note_sebab_kes_xberjaya',
                                            'spk__imediator_mediasi.status AS status',
                                            'spk__imediator_mediasi.disokong_note AS disokong_note',
                                            'spk__imediator_mediasi.disokong_p_note AS disokong_p_note',
                                            'spk__imediator_mediasi.disahkan_note AS disahkan_note',
                                            'spk__imediator_mediasi.disemak_note AS disemak_note',
                                            'spk__imediator_mediasi.diluluskan_note AS diluluskan_note')
                                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_mediasi.spk_imediator_id')
                                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                                        ->leftJoin('ref__spk_mkp_mediasi','ref__spk_mkp_mediasi.id','=','spk__imediator_mediasi.ref_mkp_kategori_id')
                                        ->where('spk__imediator_mediasi.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            return view('rt-sm23.semakan-laporan-mediasi-mkp-ppd', compact('roles_menu','mediasi_kluster', 'laporan_mediasi'));
        }
    }

    function post_semakan_laporan_mediasi_ppd(Request $request){
        $action = $request->post_semakan_laporan_mediasi_ppd;
        $app_id = $request->slmmpd_imediator_mediasi_id;
        
        
        $rules = array(
            'slmmpd_status'                 => 'required',
            'slmmpd_disokong_note'           => 'required',
        );

        $messages = [
            'slmmpd_status.required'        => 'Ruangan Status dipilih',
            'slmmpd_disokong_note.required'  => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $semakan_laporan_mediasi                    = SPK_iMediator_mediasi::where($where)->first();
                $semakan_laporan_mediasi->status            = $request->slmmpd_status;
                $semakan_laporan_mediasi->disemak_by        = Auth::user()->user_id;
                $semakan_laporan_mediasi->disemak_date      = date('Y-m-d H:i:s');
                $semakan_laporan_mediasi->disokong_note      = $request->slmmpd_disokong_note;
                $semakan_laporan_mediasi->save();
            }
        }
    }

    function senarai_semakan_laporan_mediasi_ppmk(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('spk__imediator_mediasi')
                        ->select('spk__imediator_mediasi.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'ref__spk_mkp_mediasi.kluster_description AS kluster',
                                DB::raw(" DATE_FORMAT(spk__imediator_mediasi.mediasi_tarikh,'%d/%m/%Y') AS mediasi_tarikh"),
                                'spk__imediator_mediasi.mediasi_alamat AS mediasi_alamat',
                                'users__profile.user_fullname AS nama_mediator',
                                'spk__imediator_mediasi.mediasi_pembantu_nama AS mediasi_pembantu_nama',
                                'spk__imediator_mediasi.status AS status',
                                'ref__status_spk_imediator_mediasi.status_description AS status_description')
                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_mediasi.spk_imediator_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                        ->leftJoin('ref__spk_mkp_mediasi','ref__spk_mkp_mediasi.id','=','spk__imediator_mediasi.ref_mkp_kategori_id')
                        ->leftJoin('ref__status_spk_imediator_mediasi','ref__status_spk_imediator_mediasi.id','=','spk__imediator_mediasi.status')
                        ->where('users__profile.state_id', '=', Auth::user()->state_id)
                        ->whereIN('spk__imediator.mkp_pemohon_kategori_id',[1])
                        ->whereIN('spk__imediator_mediasi.status',[3])
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
            return view('rt-sm23.senarai-semakan-laporan-mediasi-ppmk',compact('roles_menu','daerah'));
        }
    }

    function semakan_laporan_mediasi_mkp_ppmk(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_mkp_value') {
                $value = $request->value;
                $where = array('id' => $value);
                $data  = SPK_imediator::where('spk__imediator.id', '=', $where)
                        ->select('spk__imediator.*', 'krt__profile.krt_nama')
                        ->leftJoin('krt__profile','krt__profile.id','=','spk__imediator.krt_profile_id')
                        ->get();
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
            $mediasi_kluster            = Ref_SPK_MKP_Mediasi::where('status', '=', true)->get();
            $laporan_mediasi            = DB::table('spk__imediator_mediasi')
                                        ->select('spk__imediator_mediasi.id',
                                            'spk__imediator_mediasi.spk_imediator_id AS spk_imediator_id',
                                            'users__profile.user_fullname AS mkp_nama',
                                            'users__profile.no_ic AS mkp_no_ic',
                                            'users__profile.no_phone AS mkp_no_phone',
                                            'spk__imediator_mediasi.mediasi_pembantu_nama AS mediasi_pembantu_nama',
                                            'spk__imediator_mediasi.mediasi_pembantu_ic AS mediasi_pembantu_ic',
                                            'spk__imediator_mediasi.mediasi_pembantu_phone AS mediasi_pembantu_phone',
                                            'spk__imediator_mediasi.ref_mkp_kategori_id AS ref_mkp_kategori_id',
                                            DB::raw(" DATE_FORMAT(spk__imediator_mediasi.mediasi_tarikh,'%d/%m/%Y') AS mediasi_tarikh"),
                                            'spk__imediator_mediasi.mediasi_alamat AS mediasi_alamat',
                                            'spk__imediator_mediasi.mediasi_ngo_terlibat AS mediasi_ngo_terlibat',
                                            'spk__imediator_mediasi.mediasi_ringkasan_kes AS mediasi_ringkasan_kes',
                                            'spk__imediator_mediasi.mediasi_status_kes AS mediasi_status_kes',
                                            'spk__imediator_mediasi.mediasi_note_penyelesaian_kes AS mediasi_note_penyelesaian_kes',
                                            'spk__imediator_mediasi.mediasi_note_sebab_kes_xberjaya AS mediasi_note_sebab_kes_xberjaya',
                                            'spk__imediator_mediasi.status AS status',
                                            'spk__imediator_mediasi.disokong_note AS disokong_note',
                                            'spk__imediator_mediasi.disokong_p_note AS disokong_p_note',
                                            'spk__imediator_mediasi.disahkan_note AS disahkan_note',
                                            'spk__imediator_mediasi.disemak_note AS disemak_note',
                                            'spk__imediator_mediasi.diluluskan_note AS diluluskan_note')
                                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_mediasi.spk_imediator_id')
                                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                                        ->leftJoin('ref__spk_mkp_mediasi','ref__spk_mkp_mediasi.id','=','spk__imediator_mediasi.ref_mkp_kategori_id')
                                        ->where('spk__imediator_mediasi.id', '=', $id)
                                        ->limit(1)
                                        ->first();
            return view('rt-sm23.semakan-laporan-mediasi-mkp-ppmk', compact('roles_menu','mediasi_kluster', 'laporan_mediasi'));
        }
    }

    function post_semakan_laporan_mediasi_ppmk(Request $request){
        $action = $request->post_semakan_laporan_mediasi_ppmk;
        $app_id = $request->slmmpmk_imediator_mediasi_id;
        
        
        $rules = array(
            'slmmpmk_status'                 => 'required',
            'slmmpmk_disokong_p_note'         => 'required',
        );

        $messages = [
            'slmmpmk_status.required'        => 'Ruangan Status dipilih',
            'slmmpmk_disokong_p_note.required'=> 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $semakan_laporan_mediasi                    = SPK_iMediator_mediasi::where($where)->first();
                $semakan_laporan_mediasi->status            = $request->slmmpmk_status;
                $semakan_laporan_mediasi->disokong_p_by      = Auth::user()->user_id;
                $semakan_laporan_mediasi->disokong_p_date    = date('Y-m-d H:i:s');
                $semakan_laporan_mediasi->disokong_p_note    = $request->slmmpmk_disokong_p_note;
                $semakan_laporan_mediasi->save();
            }
        }
    }

    function senarai_pengesahan_laporan_mediasi_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('spk__imediator_mediasi')
                        ->select('spk__imediator_mediasi.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'ref__spk_mkp_mediasi.kluster_description AS kluster',
                                DB::raw(" DATE_FORMAT(spk__imediator_mediasi.mediasi_tarikh,'%d/%m/%Y') AS mediasi_tarikh"),
                                'spk__imediator_mediasi.mediasi_alamat AS mediasi_alamat',
                                'users__profile.user_fullname AS nama_mediator',
                                'spk__imediator_mediasi.mediasi_pembantu_nama AS mediasi_pembantu_nama',
                                'spk__imediator_mediasi.status AS status',
                                'ref__status_spk_imediator_mediasi.status_description AS status_description')
                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_mediasi.spk_imediator_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                        ->leftJoin('ref__spk_mkp_mediasi','ref__spk_mkp_mediasi.id','=','spk__imediator_mediasi.ref_mkp_kategori_id')
                        ->leftJoin('ref__status_spk_imediator_mediasi','ref__status_spk_imediator_mediasi.id','=','spk__imediator_mediasi.status')
                        ->where('users__profile.state_id', '=', Auth::user()->state_id)
                        ->whereIN('spk__imediator_mediasi.status',[4,6])
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
            return view('rt-sm23.senarai-pengesahan-laporan-mediasi-ppn', compact('roles_menu','daerah'));
        }
    }

    function pengesahan_laporan_mediasi_mkp_ppn(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_mkp_value') {
                $value = $request->value;
                $where = array('id' => $value);
                $data  = SPK_imediator::where('spk__imediator.id', '=', $where)
                        ->select('spk__imediator.*', 'krt__profile.krt_nama')
                        ->leftJoin('krt__profile','krt__profile.id','=','spk__imediator.krt_profile_id')
                        ->get();
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
            $mediasi_kluster            = Ref_SPK_MKP_Mediasi::where('status', '=', true)->get();
            $laporan_mediasi            = DB::table('spk__imediator_mediasi')
                                        ->select('spk__imediator_mediasi.id',
                                           'spk__imediator_mediasi.spk_imediator_id AS spk_imediator_id',
                                            'users__profile.user_fullname AS mkp_nama',
                                            'users__profile.no_ic AS mkp_no_ic',
                                            'users__profile.no_phone AS mkp_no_phone',
                                            'spk__imediator_mediasi.mediasi_pembantu_nama AS mediasi_pembantu_nama',
                                            'spk__imediator_mediasi.mediasi_pembantu_ic AS mediasi_pembantu_ic',
                                            'spk__imediator_mediasi.mediasi_pembantu_phone AS mediasi_pembantu_phone',
                                            'spk__imediator_mediasi.ref_mkp_kategori_id AS ref_mkp_kategori_id',
                                            DB::raw(" DATE_FORMAT(spk__imediator_mediasi.mediasi_tarikh,'%d/%m/%Y') AS mediasi_tarikh"),
                                            'spk__imediator_mediasi.mediasi_alamat AS mediasi_alamat',
                                            'spk__imediator_mediasi.mediasi_ngo_terlibat AS mediasi_ngo_terlibat',
                                            'spk__imediator_mediasi.mediasi_ringkasan_kes AS mediasi_ringkasan_kes',
                                            'spk__imediator_mediasi.mediasi_status_kes AS mediasi_status_kes',
                                            'spk__imediator_mediasi.mediasi_note_penyelesaian_kes AS mediasi_note_penyelesaian_kes',
                                            'spk__imediator_mediasi.mediasi_note_sebab_kes_xberjaya AS mediasi_note_sebab_kes_xberjaya',
                                            'spk__imediator_mediasi.status AS status',
                                            'spk__imediator_mediasi.disokong_note AS disokong_note',
                                            'spk__imediator_mediasi.disokong_p_note AS disokong_p_note',
                                            'spk__imediator_mediasi.disahkan_note AS disahkan_note',
                                            'spk__imediator_mediasi.disemak_note AS disemak_note',
                                            'spk__imediator_mediasi.diluluskan_note AS diluluskan_note')
                                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_mediasi.spk_imediator_id')
                                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                                        ->leftJoin('ref__spk_mkp_mediasi','ref__spk_mkp_mediasi.id','=','spk__imediator_mediasi.ref_mkp_kategori_id')
                                        ->where('spk__imediator_mediasi.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            return view('rt-sm23.pengesahan-laporan-mediasi-mkp-ppn', compact('roles_menu','mediasi_kluster', 'laporan_mediasi'));
        }
    }

    function post_pengesahan_laporan_mediasi_ppn(Request $request){
        $action = $request->post_pengesahan_laporan_mediasi_ppn;
        $app_id = $request->plmmpn_imediator_mediasi_id;
        
        
        $rules = array(
            'plmmpn_status'                 => 'required',
            'plmmpn_disahkan_note'          => 'required',
        );

        $messages = [
            'plmmpn_status.required'        => 'Ruangan Status dipilih',
            'plmmpn_disahkan_note.required' => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $sahkan_laporan_mediasi                    = SPK_iMediator_mediasi::where($where)->first();
                $sahkan_laporan_mediasi->status            = $request->plmmpn_status;
                $sahkan_laporan_mediasi->disahkan_by       = Auth::user()->user_id;
                $sahkan_laporan_mediasi->disahkan_date     = date('Y-m-d H:i:s');
                $sahkan_laporan_mediasi->disahkan_note     = $request->plmmpn_disahkan_note;
                $sahkan_laporan_mediasi->save();
            }
        }
    }

    function senarai_semakan_laporan_mediasi_upmk(Request $request){
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
            $data = DB::table('spk__imediator_mediasi')
                        ->select('spk__imediator_mediasi.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'ref__spk_mkp_mediasi.kluster_description AS kluster',
                                DB::raw(" DATE_FORMAT(spk__imediator_mediasi.mediasi_tarikh,'%d/%m/%Y') AS mediasi_tarikh"),
                                'spk__imediator_mediasi.mediasi_alamat AS mediasi_alamat',
                                'users__profile.user_fullname AS nama_mediator',
                                'spk__imediator_mediasi.mediasi_pembantu_nama AS mediasi_pembantu_nama',
                                'spk__imediator_mediasi.status AS status',
                                'ref__status_spk_imediator_mediasi.status_description AS status_description')
                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_mediasi.spk_imediator_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                        ->leftJoin('ref__spk_mkp_mediasi','ref__spk_mkp_mediasi.id','=','spk__imediator_mediasi.ref_mkp_kategori_id')
                        ->leftJoin('ref__status_spk_imediator_mediasi','ref__status_spk_imediator_mediasi.id','=','spk__imediator_mediasi.status')
                        ->whereIN('spk__imediator_mediasi.status',[8])
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
            return view('rt-sm23.senarai-semakan-laporan-mediasi-upmk', compact('roles_menu','state'));
        }
    }

    function semakan_laporan_kes_mkp_upmk(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_mkp_value') {
                $value = $request->value;
                $where = array('id' => $value);
                $data  = SPK_imediator::where('spk__imediator.id', '=', $where)
                        ->select('spk__imediator.*', 'krt__profile.krt_nama')
                        ->leftJoin('krt__profile','krt__profile.id','=','spk__imediator.krt_profile_id')
                        ->get();
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
            $mediasi_kluster            = Ref_SPK_MKP_Mediasi::where('status', '=', true)->get();
            $laporan_mediasi            = DB::table('spk__imediator_mediasi')
                                        ->select('spk__imediator_mediasi.id',
                                           'spk__imediator_mediasi.spk_imediator_id AS spk_imediator_id',
                                            'users__profile.user_fullname AS mkp_nama',
                                            'users__profile.no_ic AS mkp_no_ic',
                                            'users__profile.no_phone AS mkp_no_phone',
                                            'spk__imediator_mediasi.mediasi_pembantu_nama AS mediasi_pembantu_nama',
                                            'spk__imediator_mediasi.mediasi_pembantu_ic AS mediasi_pembantu_ic',
                                            'spk__imediator_mediasi.mediasi_pembantu_phone AS mediasi_pembantu_phone',
                                            'spk__imediator_mediasi.ref_mkp_kategori_id AS ref_mkp_kategori_id',
                                            DB::raw(" DATE_FORMAT(spk__imediator_mediasi.mediasi_tarikh,'%d/%m/%Y') AS mediasi_tarikh"),
                                            'spk__imediator_mediasi.mediasi_alamat AS mediasi_alamat',
                                            'spk__imediator_mediasi.mediasi_ngo_terlibat AS mediasi_ngo_terlibat',
                                            'spk__imediator_mediasi.mediasi_ringkasan_kes AS mediasi_ringkasan_kes',
                                            'spk__imediator_mediasi.mediasi_status_kes AS mediasi_status_kes',
                                            'spk__imediator_mediasi.mediasi_note_penyelesaian_kes AS mediasi_note_penyelesaian_kes',
                                            'spk__imediator_mediasi.mediasi_note_sebab_kes_xberjaya AS mediasi_note_sebab_kes_xberjaya',
                                            'spk__imediator_mediasi.status AS status',
                                            'spk__imediator_mediasi.disokong_note AS disokong_note',
                                            'spk__imediator_mediasi.disokong_p_note AS disokong_p_note',
                                            'spk__imediator_mediasi.disahkan_note AS disahkan_note',
                                            'spk__imediator_mediasi.disemak_note AS disemak_note',
                                            'spk__imediator_mediasi.diluluskan_note AS diluluskan_note')
                                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_mediasi.spk_imediator_id')
                                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                                        ->leftJoin('ref__spk_mkp_mediasi','ref__spk_mkp_mediasi.id','=','spk__imediator_mediasi.ref_mkp_kategori_id')
                                        ->where('spk__imediator_mediasi.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            return view('rt-sm23.semakan-laporan-kes-mkp-upmk', compact('roles_menu','mediasi_kluster', 'laporan_mediasi'));
        }
    }

    function post_semakan_laporan_mediasi_upmk(Request $request){
        $action = $request->post_semakan_laporan_mediasi_upmk;
        $app_id = $request->slkmu_imediator_mediasi_id;
        
        
        $rules = array(
            'slkmu_status'                  => 'required',
            'slkmu_disemak_note'            => 'required',
        );

        $messages = [
            'slkmu_status.required'         => 'Ruangan Status dipilih',
            'slkmu_disemak_note.required'   => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $sahkan_laporan_mediasi                 = SPK_iMediator_mediasi::where($where)->first();
                $sahkan_laporan_mediasi->status         = $request->slkmu_status;
                $sahkan_laporan_mediasi->disemak_by     = Auth::user()->user_id;
                $sahkan_laporan_mediasi->disemak_date   = date('Y-m-d H:i:s');
                $sahkan_laporan_mediasi->disemak_note   = $request->slkmu_disemak_note;
                $sahkan_laporan_mediasi->save();
            }
        }
    }

    function senarai_lulus_laporan_mediasi_pp(Request $request){
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
            $data = DB::table('spk__imediator_mediasi')
                        ->select('spk__imediator_mediasi.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'ref__spk_mkp_mediasi.kluster_description AS kluster',
                                DB::raw(" DATE_FORMAT(spk__imediator_mediasi.mediasi_tarikh,'%d/%m/%Y') AS mediasi_tarikh"),
                                'spk__imediator_mediasi.mediasi_alamat AS mediasi_alamat',
                                'users__profile.user_fullname AS nama_mediator',
                                'spk__imediator_mediasi.mediasi_pembantu_nama AS mediasi_pembantu_nama',
                                'spk__imediator_mediasi.status AS status',
                                'ref__status_spk_imediator_mediasi.status_description AS status_description')
                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_mediasi.spk_imediator_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                        ->leftJoin('ref__spk_mkp_mediasi','ref__spk_mkp_mediasi.id','=','spk__imediator_mediasi.ref_mkp_kategori_id')
                        ->leftJoin('ref__status_spk_imediator_mediasi','ref__status_spk_imediator_mediasi.id','=','spk__imediator_mediasi.status')
                        ->whereIN('spk__imediator_mediasi.status',[10])
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
            return view('rt-sm23.senarai-lulus-laporan-mediasi-pp', compact('roles_menu','state'));
        }
    }

    function kelulusan_laporan_kes_mkp_pp(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_mkp_value') {
                $value = $request->value;
                $where = array('id' => $value);
                $data  = SPK_imediator::where('spk__imediator.id', '=', $where)
                        ->select('spk__imediator.*', 'krt__profile.krt_nama')
                        ->leftJoin('krt__profile','krt__profile.id','=','spk__imediator.krt_profile_id')
                        ->get();
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
            $mediasi_kluster            = Ref_SPK_MKP_Mediasi::where('status', '=', true)->get();
            $laporan_mediasi            = DB::table('spk__imediator_mediasi')
                                        ->select('spk__imediator_mediasi.id',
                                           'spk__imediator_mediasi.spk_imediator_id AS spk_imediator_id',
                                            'users__profile.user_fullname AS mkp_nama',
                                            'users__profile.no_ic AS mkp_no_ic',
                                            'users__profile.no_phone AS mkp_no_phone',
                                            'spk__imediator_mediasi.mediasi_pembantu_nama AS mediasi_pembantu_nama',
                                            'spk__imediator_mediasi.mediasi_pembantu_ic AS mediasi_pembantu_ic',
                                            'spk__imediator_mediasi.mediasi_pembantu_phone AS mediasi_pembantu_phone',
                                            'spk__imediator_mediasi.ref_mkp_kategori_id AS ref_mkp_kategori_id',
                                            DB::raw(" DATE_FORMAT(spk__imediator_mediasi.mediasi_tarikh,'%d/%m/%Y') AS mediasi_tarikh"),
                                            'spk__imediator_mediasi.mediasi_alamat AS mediasi_alamat',
                                            'spk__imediator_mediasi.mediasi_ngo_terlibat AS mediasi_ngo_terlibat',
                                            'spk__imediator_mediasi.mediasi_ringkasan_kes AS mediasi_ringkasan_kes',
                                            'spk__imediator_mediasi.mediasi_status_kes AS mediasi_status_kes',
                                            'spk__imediator_mediasi.mediasi_note_penyelesaian_kes AS mediasi_note_penyelesaian_kes',
                                            'spk__imediator_mediasi.mediasi_note_sebab_kes_xberjaya AS mediasi_note_sebab_kes_xberjaya',
                                            'spk__imediator_mediasi.status AS status',
                                            'spk__imediator_mediasi.disokong_note AS disokong_note',
                                            'spk__imediator_mediasi.disokong_p_note AS disokong_p_note',
                                            'spk__imediator_mediasi.disahkan_note AS disahkan_note',
                                            'spk__imediator_mediasi.disemak_note AS disemak_note',
                                            'spk__imediator_mediasi.diluluskan_note AS diluluskan_note')
                                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_mediasi.spk_imediator_id')
                                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                                        ->leftJoin('ref__spk_mkp_mediasi','ref__spk_mkp_mediasi.id','=','spk__imediator_mediasi.ref_mkp_kategori_id')
                                        ->where('spk__imediator_mediasi.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            return view('rt-sm23.kelulusan-laporan-kes-mkp-pp', compact('roles_menu','mediasi_kluster', 'laporan_mediasi'));
        }
    }

    function post_lulus_laporan_mediasi_pp(Request $request){
        $action = $request->post_lulus_laporan_mediasi_pp;
        $app_id = $request->klkmp_imediator_mediasi_id;
        
        
        $rules = array(
            'klkmp_status'                      => 'required',
            'klkmp_diluluskan_note'             => 'required',
        );

        $messages = [
            'klkmp_status.required'             => 'Ruangan Status dipilih',
            'klkmp_diluluskan_note.required'    => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $sahkan_laporan_mediasi                    = SPK_iMediator_mediasi::where($where)->first();
                $sahkan_laporan_mediasi->status            = $request->klkmp_status;
                $sahkan_laporan_mediasi->diluluskan_by     = Auth::user()->user_id;
                $sahkan_laporan_mediasi->diluluskan_date   = date('Y-m-d H:i:s');
                $sahkan_laporan_mediasi->diluluskan_note   = $request->klkmp_diluluskan_note;
                $sahkan_laporan_mediasi->save();
            }
        }
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function senarai_laporan_kes_upmk(Request $request){
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
            $data = DB::table('spk__imediator_mediasi')
                        ->select('spk__imediator_mediasi.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'ref__spk_mkp_mediasi.kluster_description AS kluster',
                                DB::raw(" DATE_FORMAT(spk__imediator_mediasi.mediasi_tarikh,'%d/%m/%Y') AS mediasi_tarikh"),
                                'spk__imediator_mediasi.mediasi_alamat AS mediasi_alamat',
                                'users__profile.user_fullname AS nama_mediator',
                                'spk__imediator_mediasi.mediasi_pembantu_nama AS mediasi_pembantu_nama',
                                'spk__imediator_mediasi.status AS status',
                                'ref__status_spk_imediator_mediasi.status_description AS status_description')
                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_mediasi.spk_imediator_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                        ->leftJoin('ref__spk_mkp_mediasi','ref__spk_mkp_mediasi.id','=','spk__imediator_mediasi.ref_mkp_kategori_id')
                        ->leftJoin('ref__status_spk_imediator_mediasi','ref__status_spk_imediator_mediasi.id','=','spk__imediator_mediasi.status')
                        ->whereIN('spk__imediator_mediasi.status',[1])
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
            return view('rt-sm23.senarai-laporan-kes-upmk', compact('roles_menu','state'));
        }
    }

    function laporan_kes_mkp_upmk(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_mkp_value') {
                $value = $request->value;
                $where = array('id' => $value);
                $data  = SPK_imediator::where('spk__imediator.id', '=', $where)
                        ->select('spk__imediator.*', 'krt__profile.krt_nama')
                        ->leftJoin('krt__profile','krt__profile.id','=','spk__imediator.krt_profile_id')
                        ->get();
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
            $mediasi_kluster            = Ref_SPK_MKP_Mediasi::where('status', '=', true)->get();
            $laporan_mediasi            = DB::table('spk__imediator_mediasi')
                                        ->select('spk__imediator_mediasi.id',
                                           'spk__imediator_mediasi.spk_imediator_id AS spk_imediator_id',
                                            'users__profile.user_fullname AS mkp_nama',
                                            'users__profile.no_ic AS mkp_no_ic',
                                            'users__profile.no_phone AS mkp_no_phone',
                                            'spk__imediator_mediasi.mediasi_pembantu_nama AS mediasi_pembantu_nama',
                                            'spk__imediator_mediasi.mediasi_pembantu_ic AS mediasi_pembantu_ic',
                                            'spk__imediator_mediasi.mediasi_pembantu_phone AS mediasi_pembantu_phone',
                                            'spk__imediator_mediasi.ref_mkp_kategori_id AS ref_mkp_kategori_id',
                                            DB::raw(" DATE_FORMAT(spk__imediator_mediasi.mediasi_tarikh,'%d/%m/%Y') AS mediasi_tarikh"),
                                            'spk__imediator_mediasi.mediasi_alamat AS mediasi_alamat',
                                            'spk__imediator_mediasi.mediasi_ngo_terlibat AS mediasi_ngo_terlibat',
                                            'spk__imediator_mediasi.mediasi_ringkasan_kes AS mediasi_ringkasan_kes',
                                            'spk__imediator_mediasi.mediasi_status_kes AS mediasi_status_kes',
                                            'spk__imediator_mediasi.mediasi_note_penyelesaian_kes AS mediasi_note_penyelesaian_kes',
                                            'spk__imediator_mediasi.mediasi_note_sebab_kes_xberjaya AS mediasi_note_sebab_kes_xberjaya',
                                            'spk__imediator_mediasi.status AS status',
                                            'spk__imediator_mediasi.disokong_note AS disokong_note',
                                            'spk__imediator_mediasi.disokong_p_note AS disokong_p_note',
                                            'spk__imediator_mediasi.disahkan_note AS disahkan_note',
                                            'spk__imediator_mediasi.disemak_note AS disemak_note',
                                            'spk__imediator_mediasi.diluluskan_note AS diluluskan_note')
                                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_mediasi.spk_imediator_id')
                                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                                        ->leftJoin('ref__spk_mkp_mediasi','ref__spk_mkp_mediasi.id','=','spk__imediator_mediasi.ref_mkp_kategori_id')
                                        ->where('spk__imediator_mediasi.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            return view('rt-sm23.laporan-kes-mkp-upmk', compact('roles_menu','mediasi_kluster', 'laporan_mediasi'));
        }
    }

    function senarai_laporan_kes_pp(Request $request){
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
            $data = DB::table('spk__imediator_mediasi')
                        ->select('spk__imediator_mediasi.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'ref__spk_mkp_mediasi.kluster_description AS kluster',
                                DB::raw(" DATE_FORMAT(spk__imediator_mediasi.mediasi_tarikh,'%d/%m/%Y') AS mediasi_tarikh"),
                                'spk__imediator_mediasi.mediasi_alamat AS mediasi_alamat',
                                'users__profile.user_fullname AS nama_mediator',
                                'spk__imediator_mediasi.mediasi_pembantu_nama AS mediasi_pembantu_nama',
                                'spk__imediator_mediasi.status AS status',
                                'ref__status_spk_imediator_mediasi.status_description AS status_description')
                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_mediasi.spk_imediator_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                        ->leftJoin('ref__spk_mkp_mediasi','ref__spk_mkp_mediasi.id','=','spk__imediator_mediasi.ref_mkp_kategori_id')
                        ->leftJoin('ref__status_spk_imediator_mediasi','ref__status_spk_imediator_mediasi.id','=','spk__imediator_mediasi.status')
                        ->whereIN('spk__imediator_mediasi.status',[1])
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
            return view('rt-sm23.senarai-laporan-kes-pp', compact('roles_menu','state'));
        }
    }

    function laporan_kes_mkp_pp(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_mkp_value') {
                $value = $request->value;
                $where = array('id' => $value);
                $data  = SPK_imediator::where('spk__imediator.id', '=', $where)
                        ->select('spk__imediator.*', 'krt__profile.krt_nama')
                        ->leftJoin('krt__profile','krt__profile.id','=','spk__imediator.krt_profile_id')
                        ->get();
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
            $mediasi_kluster            = Ref_SPK_MKP_Mediasi::where('status', '=', true)->get();
            $laporan_mediasi            = DB::table('spk__imediator_mediasi')
                                        ->select('spk__imediator_mediasi.id',
                                           'spk__imediator_mediasi.spk_imediator_id AS spk_imediator_id',
                                            'users__profile.user_fullname AS mkp_nama',
                                            'users__profile.no_ic AS mkp_no_ic',
                                            'users__profile.no_phone AS mkp_no_phone',
                                            'spk__imediator_mediasi.mediasi_pembantu_nama AS mediasi_pembantu_nama',
                                            'spk__imediator_mediasi.mediasi_pembantu_ic AS mediasi_pembantu_ic',
                                            'spk__imediator_mediasi.mediasi_pembantu_phone AS mediasi_pembantu_phone',
                                            'spk__imediator_mediasi.ref_mkp_kategori_id AS ref_mkp_kategori_id',
                                            DB::raw(" DATE_FORMAT(spk__imediator_mediasi.mediasi_tarikh,'%d/%m/%Y') AS mediasi_tarikh"),
                                            'spk__imediator_mediasi.mediasi_alamat AS mediasi_alamat',
                                            'spk__imediator_mediasi.mediasi_ngo_terlibat AS mediasi_ngo_terlibat',
                                            'spk__imediator_mediasi.mediasi_ringkasan_kes AS mediasi_ringkasan_kes',
                                            'spk__imediator_mediasi.mediasi_status_kes AS mediasi_status_kes',
                                            'spk__imediator_mediasi.mediasi_note_penyelesaian_kes AS mediasi_note_penyelesaian_kes',
                                            'spk__imediator_mediasi.mediasi_note_sebab_kes_xberjaya AS mediasi_note_sebab_kes_xberjaya',
                                            'spk__imediator_mediasi.status AS status',
                                            'spk__imediator_mediasi.disokong_note AS disokong_note',
                                            'spk__imediator_mediasi.disokong_p_note AS disokong_p_note',
                                            'spk__imediator_mediasi.disahkan_note AS disahkan_note',
                                            'spk__imediator_mediasi.disemak_note AS disemak_note',
                                            'spk__imediator_mediasi.diluluskan_note AS diluluskan_note')
                                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_mediasi.spk_imediator_id')
                                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                                        ->leftJoin('ref__spk_mkp_mediasi','ref__spk_mkp_mediasi.id','=','spk__imediator_mediasi.ref_mkp_kategori_id')
                                        ->where('spk__imediator_mediasi.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            return view('rt-sm23.laporan-kes-mkp-pp', compact('roles_menu','mediasi_kluster', 'laporan_mediasi'));
        }
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function mohon_keaktifan_mkp(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
        }
        else {
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
            $mediasi_kluster            = Ref_SPK_MKP_Mediasi::where('status', '=', true)->get();
            $mediasi_status             = Ref_SPK_MKP_Mediasi_Status::where('status', '=', true)->get();
            $mediasi_peringkat          = Ref_SPK_MKP_Peringkat::where('status', '=', true)->get();
            $mkp                        = DB::table('spk__imediator')
                                        ->select('spk__imediator.id AS id',
                                                'users__profile.user_fullname AS mkp_nama',
                                                'users__profile.no_ic AS mkp_no_ic',
                                                'users__profile.no_phone AS mkp_no_phone',
                                                'users.user_email AS user_email',
                                                'spk__imediator.status AS status_mkp',
                                                'ref__status_spk_imediator.status_description AS status_mkp_description',
                                                'spk__imediator_keaktifan.status AS status',
                                                DB::raw(" CONCAT('MKP','/',users__profile.state_id,'/',users__profile.daerah_id,'/',spk__imediator.id) AS no_rujukan_mkp"),
                                                'ref__status_spk_imediator_keaktifan.status_description AS status_description',
                                                'spk__imediator_keaktifan.disokong_note AS disokong_note',
                                                'spk__imediator_keaktifan.disokong_p_note AS disokong_p_note',
                                                'spk__imediator_keaktifan.disahkan_note AS disahkan_note')
                                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                                        ->leftJoin('spk__imediator_keaktifan','spk__imediator_keaktifan.spk_imediator_id','=','spk__imediator.id')
                                        ->leftJoin('ref__status_spk_imediator','ref__status_spk_imediator.id','=','spk__imediator.status')
                                        ->leftJoin('ref__status_spk_imediator_keaktifan','ref__status_spk_imediator_keaktifan.id','=','spk__imediator_keaktifan.status')
                                        ->where('spk__imediator.user_id', '=', Auth::user()->user_id)
                                        ->limit(1)
                                        ->first();
            $total_kes                  = DB::table('spk__imediator_mediasi')
                                        ->select(DB::raw('count(*) as total_kes'))
                                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_mediasi.spk_imediator_id')
                                        ->where('spk__imediator.user_id', '=', Auth::user()->user_id)
                                        ->limit(1)
                                        ->first();
            return view('rt-sm23.mohon-keaktifan-mkp', compact('roles_menu','mediasi_kluster','mediasi_status','mediasi_peringkat','mkp','total_kes'));
        }
    }

    function get_kes_mediasi_mkp_table(Request $request, $id){
        $data   = DB::table('spk__imediator_mediasi')
                    ->select('spk__imediator_mediasi.id AS id',
                            'ref__spk_mkp_mediasi.kluster_description AS kluster_description',
                            'spk__imediator_mediasi.mediasi_status_kes AS mediasi_status_kes',
                            'ref__spk_mkp_peringkat.peringkat_description AS peringkat_description',
                            'spk__imediator_keaktifan.status AS status_keaktifan')
                    ->join('ref__spk_mkp_mediasi','ref__spk_mkp_mediasi.id','=','spk__imediator_mediasi.ref_mkp_kategori_id')
                    ->join('ref__spk_mkp_peringkat','ref__spk_mkp_peringkat.id','=','spk__imediator_mediasi.ref_spk_mkp_peringkat_id')
                    ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_mediasi.spk_imediator_id')
                    ->leftJoin('spk__imediator_keaktifan','spk__imediator_keaktifan.spk_imediator_id','=','spk__imediator.id')
                    ->where('spk__imediator_mediasi.status', '=', 1)
                    ->where('spk__imediator.id', '=', $id)
                    ->get();
                return Datatables::of($data)
                    ->make(true);
    }

    function get_keaktifan_aktiviti_mkp_table(Request $request, $id){
        $data   = DB::table('spk__imediator_keaktifan_aktiviti')
                    ->select('spk__imediator_keaktifan_aktiviti.id',
                            'spk__imediator_keaktifan_aktiviti.aktiviti_nama',
                            DB::raw(" DATE_FORMAT(spk__imediator_keaktifan_aktiviti.aktiviti_tarikh,'%d/%m/%Y') AS aktiviti_tarikh"),
                            'spk__imediator_keaktifan_aktiviti.aktiviti_tempat',
                            'spk__imediator_keaktifan_aktiviti.aktiviti_jawatan',
                            'ref__spk_mkp_peringkat.peringkat_description')
                    ->join('ref__spk_mkp_peringkat','ref__spk_mkp_peringkat.id','=','spk__imediator_keaktifan_aktiviti.ref_peringkat_id')
                    ->where('spk__imediator_keaktifan_aktiviti.spk_imediator_id', '=', $id)
                    ->get();
                return Datatables::of($data)
                    ->make(true);
    }

    function post_add_keaktifan_aktiviti_mkp(Request $request){
        $action = $request->post_add_keaktifan_aktiviti_mkp;
        $app_id = $request->pkkmkp2_spk_imediator_id;
        
        $rules = array(
            'pkkmkp2_aktiviti_nama'               => 'required',
            'pkkmkp2_aktiviti_tarikh'             => 'required',
            'pkkmkp2_aktiviti_tempat'             => 'required',
            'pkkmkp2_aktiviti_jawatan'            => 'required',
            'pkkmkp2_ref_peringkat_id'            => 'required'
        );

        $messages = [
            'pkkmkp2_aktiviti_nama.required'      => 'Ruangan Nama Aktiviti / Program mesti diisi',
            'pkkmkp2_aktiviti_tarikh.required'    => 'Ruangan Tarikh mesti dipilih',
            'pkkmkp2_aktiviti_tempat.required'    => 'Ruangan Tempat mesti diisi',
            'pkkmkp2_aktiviti_jawatan.required'   => 'Ruangan Jawatan mesti diisi',
            'pkkmkp2_ref_peringkat_id.required'   => 'Ruangan peringkat mesti dipilih',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $carbon_obj                         = Carbon::createFromFormat('d/m/Y', $request->pkkmkp2_aktiviti_tarikh)->format('Y-m-d');
                $aktiviti                           = new SPK_imediator_Keaktifan_Aktiviti;
                $aktiviti->spk_imediator_id         = $app_id;
                $aktiviti->aktiviti_nama            = $request->pkkmkp2_aktiviti_nama;
                $aktiviti->aktiviti_tarikh          = $carbon_obj;
                $aktiviti->aktiviti_tempat          = $request->pkkmkp2_aktiviti_tempat;
                $aktiviti->aktiviti_jawatan         = $request->pkkmkp2_aktiviti_jawatan;
                $aktiviti->ref_peringkat_id         = $request->pkkmkp2_ref_peringkat_id;
                $aktiviti->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_keaktifan_aktiviti_mkp($id){
        $data = DB::table('spk__imediator_keaktifan_aktiviti')->where('id', '=', $id)->delete();
    }

    function mohon_keaktifan_mkp_1(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
        }
        else {
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
            $mediasi_kluster            = Ref_SPK_MKP_Mediasi::where('status', '=', true)->get();
            $mediasi_status             = Ref_SPK_MKP_Mediasi_Status::where('status', '=', true)->get();
            $mediasi_peringkat          = Ref_SPK_MKP_Peringkat::where('status', '=', true)->get();
            $mkp                        = DB::table('spk__imediator')
                                        ->select('spk__imediator.id AS id',
                                                'spk__imediator_keaktifan.id AS spk_imediator_id',
                                                'users__profile.user_fullname AS mkp_nama',
                                                'users__profile.no_ic AS mkp_no_ic',
                                                'users__profile.no_phone AS mkp_no_phone',
                                                'users.user_email AS user_email',
                                                'spk__imediator.status AS status_mkp',
                                                'ref__status_spk_imediator.status_description AS status_mkp_description',
                                                'spk__imediator_keaktifan.status AS status',
                                                DB::raw(" CONCAT(users__profile.state_id,'/',users__profile.daerah_id,'/',spk__imediator.id) AS no_rujukan_mkp"),
                                                'ref__status_spk_imediator_keaktifan.status_description AS status_description',
                                                'spk__imediator_keaktifan.disokong_note AS disokong_note',
                                                'spk__imediator_keaktifan.disokong_p_note AS disokong_p_note',
                                                'spk__imediator_keaktifan.disahkan_note AS disahkan_note',
                                                DB::raw(" DATE_ADD(spk__imediator.mkp_tarikh_dilantik, INTERVAL 548 DAY) AS tarikh_mkp_hantar_keaktifan"))
                                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                                        ->leftJoin('ref__status_spk_imediator','ref__status_spk_imediator.id','=','spk__imediator.status')
                                        ->leftJoin('spk__imediator_keaktifan','spk__imediator_keaktifan.spk_imediator_id','=','spk__imediator.id')
                                        ->leftJoin('ref__status_spk_imediator_keaktifan','ref__status_spk_imediator_keaktifan.id','=','spk__imediator_keaktifan.status')
                                        ->where('spk__imediator.user_id', '=', Auth::user()->user_id)
                                        ->limit(1)
                                        ->first();
            return view('rt-sm23.mohon-keaktifan-mkp-1', compact('roles_menu','mediasi_kluster','mediasi_status','mediasi_peringkat','mkp'));
        }
    }

    function get_keaktifan_latihan_table_mkp(Request $request, $id){
        $data       = DB::table('spk__imediator_keaktifan_latihan')
                        ->select('spk__imediator_keaktifan_latihan.id',
                            'spk__imediator_keaktifan_latihan.latihan_nama',
                            DB::raw(" DATE_FORMAT(spk__imediator_keaktifan_latihan.latihan_tarikh,'%d/%m/%Y') AS latihan_tarikh"),
                            'spk__imediator_keaktifan_latihan.latihan_tempat',
                            'spk__imediator_keaktifan_latihan.latihan_penganjur',
                            'ref__spk_mkp_peringkat.peringkat_description')
                        ->join('ref__spk_mkp_peringkat','ref__spk_mkp_peringkat.id','=','spk__imediator_keaktifan_latihan.ref_peringkat_id')
                        ->where('spk__imediator_keaktifan_latihan.spk_imediator_id', '=', $id)
                        ->get();
                    return Datatables::of($data)
                        ->make(true);
    }

    function post_add_keaktifan_latihan_mkp(Request $request){
        $action = $request->post_add_keaktifan_latihan_mkp;
        $app_id = $request->mkm5_spk_imediator_id;
        
        $rules = array(
            'mkm5_latihan_nama'                  => 'required',
            'mkm5_latihan_tarikh'                => 'required',
            'mkm5_latihan_tempat'                => 'required',
            'mkm5_latihan_penganjur'             => 'required',
            'mkm5_ref_peringkat_id'              => 'required'
        );

        $messages = [
            'mkm5_latihan_nama.required'         => 'Ruangan Nama Latihan / Kursus mesti diisi',
            'mkm5_latihan_tarikh.required'       => 'Ruangan Tarikh mesti dipilih',
            'mkm5_latihan_tempat.required'       => 'Ruangan Tempat mesti diisi',
            'mkm5_latihan_penganjur.required'    => 'Ruangan Penganjur mesti diisi',
            'mkm5_ref_peringkat_id.required'     => 'Ruangan Peringkat mesti dipilih',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $carbon_obj                        = Carbon::createFromFormat('d/m/Y', $request->mkm5_latihan_tarikh)->format('Y-m-d');
                $latihan                           = new SPK_imediator_Keaktifan_Latihan;
                $latihan->spk_imediator_id         = $app_id;
                $latihan->latihan_nama             = $request->mkm5_latihan_nama;
                $latihan->latihan_tarikh           = $carbon_obj;
                $latihan->latihan_tempat           = $request->mkm5_latihan_tempat;
                $latihan->latihan_penganjur        = $request->mkm5_latihan_penganjur;
                $latihan->ref_peringkat_id         = $request->mkm5_ref_peringkat_id;
                $latihan->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_keaktifan_latihan_mkp($id){
        $data = DB::table('spk__imediator_keaktifan_latihan')->where('id', '=', $id)->delete();
    }

    function get_keaktifan_sumbangan_mkp_table(Request $request, $id){
        $data   = DB::table('spk__imediator_keaktifan_sumbangan')
                    ->select('spk__imediator_keaktifan_sumbangan.id',
                            'spk__imediator_keaktifan_sumbangan.sumbangan_nama',
                            'ref__spk_mkp_peringkat.peringkat_description')
                    ->join('ref__spk_mkp_peringkat','ref__spk_mkp_peringkat.id','=','spk__imediator_keaktifan_sumbangan.ref_peringkat_id')
                    ->where('spk__imediator_keaktifan_sumbangan.spk_imediator_id', '=', $id)
                    ->get();
                return Datatables::of($data)
                    ->make(true);
    }

    function post_add_keaktifan_sumbangan_mkp(Request $request){
        $action = $request->post_add_keaktifan_sumbangan_mkp;
        $app_id = $request->mkm6_spk_imediator_id;
        
        $rules = array(
            'mkm6_sumbangan_nama'                  => 'required',
            'mkm6_ref_peringkat_id'                => 'required'
        );

        $messages = [
            'mkm6_sumbangan_nama.required'         => 'Ruangan Nama Latihan / Kursus mesti diisi',
            'mkm6_ref_peringkat_id.required'       => 'Ruangan Tarikh mesti dipilih',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $sumbangan                           = new SPK_imediator_Keaktifan_Sumbangan;
                $sumbangan->spk_imediator_id         = $app_id;
                $sumbangan->sumbangan_nama           = $request->mkm6_sumbangan_nama;
                $sumbangan->ref_peringkat_id         = $request->mkm6_ref_peringkat_id;
                $sumbangan->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_keaktifan_sumbangan_mkp($id){
        $data = DB::table('spk__imediator_keaktifan_sumbangan')->where('id', '=', $id)->delete();
    }

    function post_permohonan_keaktifan_mkp(Request $request){
        $action = $request->post_permohonan_keaktifan_mkp;
        $app_id = $request->mkm7_spk_imediator_id;
        
        $rules_main = array(                
            
        );
        
        $messages = [
            
            
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $update_mkp_keaktifan                   = new SPK_imediator_keaktifan;
                $update_mkp_keaktifan->spk_imediator_id = $app_id;
                $update_mkp_keaktifan->status           = 3;
                $update_mkp_keaktifan->dihantar_by      = Auth::user()->user_id;;
                $update_mkp_keaktifan->dihantar_date    = date('Y-m-d H:i:s');
                $update_mkp_keaktifan->save();
                
            }
        }
    }

    function post_edit_permohonan_keaktifan_mkp(Request $request){
        $action = $request->post_edit_permohonan_keaktifan_mkp;
        $app_id = $request->mkm7_spk_imediator_keaktifan_id;
        
        $rules_main = array(                
            
        );
        
        $messages = [
            
            
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $update_mkp_keaktifan                   = SPK_imediator_keaktifan::where($where)->first();
                $update_mkp_keaktifan->status           = 3;
                $update_mkp_keaktifan->dihantar_by      = Auth::user()->user_id;;
                $update_mkp_keaktifan->dihantar_date    = date('Y-m-d H:i:s');
                $update_mkp_keaktifan->save();
                
            }
        }
    }

    function senarai_permohonan_mkp_keaktifan_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('spk__imediator_keaktifan')
                        ->select('spk__imediator_keaktifan.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'users__profile.user_fullname AS mkp_pemohon_nama',
                                'users__profile.no_ic AS mkp_pemohon_ic',
                                'users__profile.no_phone AS mkp_pemohon_no_phone',
                                'users.user_email AS mkp_pemohon_email',
                                'spk__imediator_keaktifan.status AS status',
                                'ref__status_spk_imediator_keaktifan.status_description AS status_description',
                                DB::raw(" CONCAT('MKP','/',users__profile.state_id,'/',users__profile.daerah_id,'/',spk__imediator.id) AS no_rujukan_mkp"))
                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_keaktifan.spk_imediator_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                        ->leftJoin('ref__status_spk_imediator_keaktifan','ref__status_spk_imediator_keaktifan.id','=','spk__imediator_keaktifan.status')
                        ->where('users__profile.daerah_id', '=', Auth::user()->daerah_id)
                        ->whereIN('spk__imediator_keaktifan.status',[3])
                        ->whereIN('spk__imediator.mkp_pemohon_kategori_id',[2,3,4,5])
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
            return view('rt-sm23.senarai-permohonan-mkp-keaktifan-ppd',compact('roles_menu'));
        }
    }

    function sokongan_keaktifan_mkp_ppd(Request $request, $id){
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
            $mediasi_kluster            = Ref_SPK_MKP_Mediasi::where('status', '=', true)->get();
            $mediasi_status             = Ref_SPK_MKP_Mediasi_Status::where('status', '=', true)->get();
            $mediasi_peringkat          = Ref_SPK_MKP_Peringkat::where('status', '=', true)->get();
            $mkp                        = DB::table('spk__imediator')
                                        ->select('spk__imediator.id AS id',
                                                'spk__imediator_keaktifan.id AS spk_imediator_id',
                                                'users__profile.user_fullname AS mkp_nama',
                                                'users__profile.no_ic AS mkp_no_ic',
                                                'users__profile.no_phone AS mkp_no_phone',
                                                'users.user_email AS user_email',
                                                'spk__imediator_keaktifan.status AS status',
                                                DB::raw(" CONCAT('MKP','/',users__profile.state_id,'/',users__profile.daerah_id,'/',spk__imediator.id) AS no_rujukan_mkp"),
                                                'ref__status_spk_imediator_keaktifan.status_description AS status_description')
                                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                                        ->leftJoin('spk__imediator_keaktifan','spk__imediator_keaktifan.spk_imediator_id','=','spk__imediator.id')
                                        ->leftJoin('ref__status_spk_imediator_keaktifan','ref__status_spk_imediator_keaktifan.id','=','spk__imediator_keaktifan.status')
                                        ->where('spk__imediator_keaktifan.id', '=', $id)
                                        ->limit(1)
                                        ->first();
            $total_kes                  = DB::table('spk__imediator_mediasi')
                                        ->select(DB::raw('count(*) as total_kes'))
                                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_mediasi.spk_imediator_id')
                                        ->leftJoin('spk__imediator_keaktifan','spk__imediator_keaktifan.spk_imediator_id','=','spk__imediator.id')
                                        ->where('spk__imediator_keaktifan.id', '=', $id)
                                        ->limit(1)
                                        ->first();
            return view('rt-sm23.sokongan-keaktifan-mkp-ppd', 
            compact('roles_menu','mediasi_kluster', 'mediasi_status', 'mediasi_peringkat', 'mkp', 'total_kes'));
        }
    }

    function post_sokongan_mkp_keaktifan_ppd(Request $request){
        $action = $request->post_sokongan_mkp_keaktifan_ppd;
        $app_id = $request->spmpd_spk_mkp_keaktifan_id;
        
        
        $rules = array(
            'skmppd_mkp_keaktifan_status'           => 'required',
            'skmppd_disokong_note'                  => 'required',
        );

        $messages = [
            'skmppd_mkp_keaktifan_status.required'  => 'Ruangan Status dipilih',
            'skmppd_disokong_note.required'         => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $sokongan_mkp_keaktifan                   = SPK_imediator_keaktifan::where($where)->first();
                $sokongan_mkp_keaktifan->status           = $request->skmppd_mkp_keaktifan_status;
                $sokongan_mkp_keaktifan->disokong_by      = Auth::user()->user_id;
                $sokongan_mkp_keaktifan->disokong_date    = date('Y-m-d H:i:s');
                $sokongan_mkp_keaktifan->disokong_note    = $request->skmppd_disokong_note;
                $sokongan_mkp_keaktifan->save();
            }
        }
    }

    function senarai_permohonan_mkp_keaktifan_ppmk(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('spk__imediator_keaktifan')
                        ->select('spk__imediator_keaktifan.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'users__profile.user_fullname AS mkp_pemohon_nama',
                                'users__profile.no_ic AS mkp_pemohon_ic',
                                'users__profile.no_phone AS mkp_pemohon_no_phone',
                                'users.user_email AS mkp_pemohon_email',
                                'spk__imediator_keaktifan.status AS status',
                                'ref__status_spk_imediator_keaktifan.status_description AS status_description',
                                DB::raw(" CONCAT('MKP','/',users__profile.state_id,'/',users__profile.daerah_id,'/',spk__imediator.id) AS no_rujukan_mkp"))
                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_keaktifan.spk_imediator_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                        ->leftJoin('ref__status_spk_imediator_keaktifan','ref__status_spk_imediator_keaktifan.id','=','spk__imediator_keaktifan.status')
                        ->where('users__profile.state_id', '=', Auth::user()->state_id)
                        ->whereIN('spk__imediator_keaktifan.status',[3])
                        ->whereIN('spk__imediator.mkp_pemohon_kategori_id',[1])
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
            return view('rt-sm23.senarai-permohonan-mkp-keaktifan-ppmk',compact('roles_menu'));
        }
    }

    function sokongan_keaktifan_mkp_ppmk(Request $request, $id){
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
            $mediasi_kluster            = Ref_SPK_MKP_Mediasi::where('status', '=', true)->get();
            $mediasi_status             = Ref_SPK_MKP_Mediasi_Status::where('status', '=', true)->get();
            $mediasi_peringkat          = Ref_SPK_MKP_Peringkat::where('status', '=', true)->get();
            $mkp                        = DB::table('spk__imediator')
                                        ->select('spk__imediator.id AS id',
                                                'spk__imediator_keaktifan.id AS spk_imediator_id',
                                                'users__profile.user_fullname AS mkp_nama',
                                                'users__profile.no_ic AS mkp_no_ic',
                                                'users__profile.no_phone AS mkp_no_phone',
                                                'users.user_email AS user_email',
                                                'spk__imediator_keaktifan.status AS status',
                                                DB::raw(" CONCAT('MKP','/',users__profile.state_id,'/',users__profile.daerah_id,'/',spk__imediator.id) AS no_rujukan_mkp"),
                                                'ref__status_spk_imediator_keaktifan.status_description AS status_description')
                                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                                        ->leftJoin('spk__imediator_keaktifan','spk__imediator_keaktifan.spk_imediator_id','=','spk__imediator.id')
                                        ->leftJoin('ref__status_spk_imediator_keaktifan','ref__status_spk_imediator_keaktifan.id','=','spk__imediator_keaktifan.status')
                                        ->where('spk__imediator_keaktifan.id', '=', $id)
                                        ->limit(1)
                                        ->first();
            $total_kes                  = DB::table('spk__imediator_mediasi')
                                        ->select(DB::raw('count(*) as total_kes'))
                                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_mediasi.spk_imediator_id')
                                        ->leftJoin('spk__imediator_keaktifan','spk__imediator_keaktifan.spk_imediator_id','=','spk__imediator.id')
                                        ->where('spk__imediator_keaktifan.id', '=', $id)
                                        ->limit(1)
                                        ->first();
            return view('rt-sm23.sokongan-keaktifan-mkp-ppmk', 
            compact('roles_menu','mediasi_kluster', 'mediasi_status', 'mediasi_peringkat', 'mkp', 'total_kes'));
        }
    }

    function post_sokongan_mkp_keaktifan_ppmk(Request $request){
        $action = $request->post_sokongan_mkp_keaktifan_ppmk;
        $app_id = $request->skmpmk_spk_mkp_keaktifan_id;
        
        
        $rules = array(
            'skmpmk_mkp_keaktifan_status'           => 'required',
            'skmpmk_disokong_note'                  => 'required',
        );

        $messages = [
            'skmpmk_mkp_keaktifan_status.required'  => 'Ruangan Status dipilih',
            'skmpmk_disokong_note.required'         => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $sokongan_mkp_keaktifan                   = SPK_imediator_keaktifan::where($where)->first();
                $sokongan_mkp_keaktifan->status           = $request->skmpmk_mkp_keaktifan_status;
                $sokongan_mkp_keaktifan->disokong_p_by    = Auth::user()->user_id;
                $sokongan_mkp_keaktifan->disokong_p_date  = date('Y-m-d H:i:s');
                $sokongan_mkp_keaktifan->disokong_p_note  = $request->skmpmk_disokong_note;
                $sokongan_mkp_keaktifan->save();
            }
        }
    }

    function senarai_permohonan_mkp_keaktifan_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('spk__imediator_keaktifan')
                        ->select('spk__imediator_keaktifan.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'users__profile.user_fullname AS mkp_pemohon_nama',
                                'users__profile.no_ic AS mkp_pemohon_ic',
                                'users__profile.no_phone AS mkp_pemohon_no_phone',
                                'users.user_email AS mkp_pemohon_email',
                                'spk__imediator_keaktifan.status AS status',
                                'ref__status_spk_imediator_keaktifan.status_description AS status_description',
                                DB::raw(" CONCAT('MKP','/',users__profile.state_id,'/',users__profile.daerah_id,'/',spk__imediator.id) AS no_rujukan_mkp"))
                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_keaktifan.spk_imediator_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                        ->leftJoin('ref__status_spk_imediator_keaktifan','ref__status_spk_imediator_keaktifan.id','=','spk__imediator_keaktifan.status')
                        ->where('users__profile.state_id', '=', Auth::user()->state_id)
                        ->whereIN('spk__imediator_keaktifan.status',[4,6])
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
            return view('rt-sm23.senarai-permohonan-mkp-keaktifan-ppn', compact('roles_menu','daerah'));
        }
    }

    function sahkan_keaktifan_mkp_ppn(Request $request, $id){
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
            $mediasi_kluster            = Ref_SPK_MKP_Mediasi::where('status', '=', true)->get();
            $mediasi_status             = Ref_SPK_MKP_Mediasi_Status::where('status', '=', true)->get();
            $mediasi_peringkat          = Ref_SPK_MKP_Peringkat::where('status', '=', true)->get();
            $mkp                        = DB::table('spk__imediator')
                                        ->select('spk__imediator.id AS id',
                                                'spk__imediator_keaktifan.id AS spk_imediator_id',
                                                'users__profile.user_fullname AS mkp_nama',
                                                'users__profile.no_ic AS mkp_no_ic',
                                                'users__profile.no_phone AS mkp_no_phone',
                                                'users.user_email AS user_email',
                                                'spk__imediator_keaktifan.status AS status',
                                                DB::raw(" CONCAT('MKP','/',users__profile.state_id,'/',users__profile.daerah_id,'/',spk__imediator.id) AS no_rujukan_mkp"),
                                                'ref__status_spk_imediator_keaktifan.status_description AS status_description')
                                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                                        ->leftJoin('spk__imediator_keaktifan','spk__imediator_keaktifan.spk_imediator_id','=','spk__imediator.id')
                                        ->leftJoin('ref__status_spk_imediator_keaktifan','ref__status_spk_imediator_keaktifan.id','=','spk__imediator_keaktifan.status')
                                        ->where('spk__imediator_keaktifan.id', '=', $id)
                                        ->limit(1)
                                        ->first();
            $total_kes                  = DB::table('spk__imediator_mediasi')
                                        ->select(DB::raw('count(*) as total_kes'))
                                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_mediasi.spk_imediator_id')
                                        ->leftJoin('spk__imediator_keaktifan','spk__imediator_keaktifan.spk_imediator_id','=','spk__imediator.id')
                                        ->where('spk__imediator_keaktifan.id', '=', $id)
                                        ->limit(1)
                                        ->first();
            return view('rt-sm23.sahkan-keaktifan-mkp-ppn', 
            compact('roles_menu','mediasi_kluster', 'mediasi_status', 'mediasi_peringkat', 'mkp', 'total_kes'));
        }
    }

    function post_sahkan_mkp_keaktifan_ppn(Request $request){
        $action = $request->post_sahkan_mkp_keaktifan_ppn;
        $app_id = $request->spmpd_spk_mkp_keaktifan_id;
        
        
        $rules = array(
            'skmpn_mkp_keaktifan_status'           => 'required',
            'skmpn_disahkan_note'                  => 'required',
        );

        $messages = [
            'skmpn_mkp_keaktifan_status.required'  => 'Ruangan Status dipilih',
            'skmpn_disahkan_note.required'         => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $sahkan_mkp_keaktifan                   = SPK_imediator_keaktifan::where($where)->first();
                $sahkan_mkp_keaktifan->status           = $request->skmpn_mkp_keaktifan_status;
                $sahkan_mkp_keaktifan->disahkan_by      = Auth::user()->user_id;
                $sahkan_mkp_keaktifan->disahkan_date    = date('Y-m-d H:i:s');
                $sahkan_mkp_keaktifan->disahkan_note    = $request->skmpn_disahkan_note;
                $sahkan_mkp_keaktifan->save();
            }
        }
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    function senarai_mkp_keaktifan_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('spk__imediator_keaktifan')
                        ->select('spk__imediator_keaktifan.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'users__profile.user_fullname AS mkp_pemohon_nama',
                                'users__profile.no_ic AS mkp_pemohon_ic',
                                'users__profile.no_phone AS mkp_pemohon_no_phone',
                                'users.user_email AS mkp_pemohon_email',
                                'spk__imediator_keaktifan.status AS status',
                                'ref__status_spk_imediator_keaktifan.status_description AS status_description',
                                DB::raw(" CONCAT('MKP','/',users__profile.state_id,'/',users__profile.daerah_id,'/',spk__imediator.id) AS no_rujukan_mkp"))
                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_keaktifan.spk_imediator_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                        ->leftJoin('ref__status_spk_imediator_keaktifan','ref__status_spk_imediator_keaktifan.id','=','spk__imediator_keaktifan.status')
                        ->where('users__profile.daerah_id', '=', Auth::user()->daerah_id)
                        ->whereIN('spk__imediator_keaktifan.status',[1])
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
            return view('rt-sm23.senarai-mkp-keaktifan-ppd',compact('roles_menu'));
        }
    }

    function keaktifan_mkp_ppd(Request $request, $id){
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
            $mediasi_kluster            = Ref_SPK_MKP_Mediasi::where('status', '=', true)->get();
            $mediasi_status             = Ref_SPK_MKP_Mediasi_Status::where('status', '=', true)->get();
            $mediasi_peringkat          = Ref_SPK_MKP_Peringkat::where('status', '=', true)->get();
            $mkp                        = DB::table('spk__imediator')
                                        ->select('spk__imediator.id AS id',
                                                'spk__imediator_keaktifan.id AS spk_imediator_id',
                                                'users__profile.user_fullname AS mkp_nama',
                                                'users__profile.no_ic AS mkp_no_ic',
                                                'users__profile.no_phone AS mkp_no_phone',
                                                'users.user_email AS user_email',
                                                'spk__imediator_keaktifan.status AS status',
                                                DB::raw(" CONCAT('MKP','/',users__profile.state_id,'/',users__profile.daerah_id,'/',spk__imediator.id) AS no_rujukan_mkp"),
                                                'ref__status_spk_imediator_keaktifan.status_description AS status_description')
                                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                                        ->leftJoin('spk__imediator_keaktifan','spk__imediator_keaktifan.spk_imediator_id','=','spk__imediator.id')
                                        ->leftJoin('ref__status_spk_imediator_keaktifan','ref__status_spk_imediator_keaktifan.id','=','spk__imediator_keaktifan.status')
                                        ->where('spk__imediator_keaktifan.id', '=', $id)
                                        ->limit(1)
                                        ->first();
            $total_kes                  = DB::table('spk__imediator_mediasi')
                                        ->select(DB::raw('count(*) as total_kes'))
                                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_mediasi.spk_imediator_id')
                                        ->leftJoin('spk__imediator_keaktifan','spk__imediator_keaktifan.spk_imediator_id','=','spk__imediator.id')
                                        ->where('spk__imediator_keaktifan.id', '=', $id)
                                        ->limit(1)
                                        ->first();
            return view('rt-sm23.keaktifan-mkp-ppd', 
            compact('roles_menu','mediasi_kluster', 'mediasi_status', 'mediasi_peringkat', 'mkp', 'total_kes'));
        }
    }

    function senarai_mkp_keaktifan_ppmk(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('spk__imediator_keaktifan')
                        ->select('spk__imediator_keaktifan.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'users__profile.user_fullname AS mkp_pemohon_nama',
                                'users__profile.no_ic AS mkp_pemohon_ic',
                                'users__profile.no_phone AS mkp_pemohon_no_phone',
                                'users.user_email AS mkp_pemohon_email',
                                'spk__imediator_keaktifan.status AS status',
                                'ref__status_spk_imediator_keaktifan.status_description AS status_description',
                                DB::raw(" CONCAT('MKP','/',users__profile.state_id,'/',users__profile.daerah_id,'/',spk__imediator.id) AS no_rujukan_mkp"))
                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_keaktifan.spk_imediator_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                        ->leftJoin('ref__status_spk_imediator_keaktifan','ref__status_spk_imediator_keaktifan.id','=','spk__imediator_keaktifan.status')
                        ->where('users__profile.state_id', '=', Auth::user()->state_id)
                        ->whereIN('spk__imediator_keaktifan.status',[1])
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
            return view('rt-sm23.senarai-mkp-keaktifan-ppmk',compact('roles_menu'));
        }
    }

    function keaktifan_mkp_ppmk(Request $request, $id){
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
            $mediasi_kluster            = Ref_SPK_MKP_Mediasi::where('status', '=', true)->get();
            $mediasi_status             = Ref_SPK_MKP_Mediasi_Status::where('status', '=', true)->get();
            $mediasi_peringkat          = Ref_SPK_MKP_Peringkat::where('status', '=', true)->get();
            $mkp                        = DB::table('spk__imediator')
                                        ->select('spk__imediator.id AS id',
                                                'spk__imediator_keaktifan.id AS spk_imediator_id',
                                                'users__profile.user_fullname AS mkp_nama',
                                                'users__profile.no_ic AS mkp_no_ic',
                                                'users__profile.no_phone AS mkp_no_phone',
                                                'users.user_email AS user_email',
                                                'spk__imediator_keaktifan.status AS status',
                                                DB::raw(" CONCAT('MKP','/',users__profile.state_id,'/',users__profile.daerah_id,'/',spk__imediator.id) AS no_rujukan_mkp"),
                                                'ref__status_spk_imediator_keaktifan.status_description AS status_description')
                                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                                        ->leftJoin('spk__imediator_keaktifan','spk__imediator_keaktifan.spk_imediator_id','=','spk__imediator.id')
                                        ->leftJoin('ref__status_spk_imediator_keaktifan','ref__status_spk_imediator_keaktifan.id','=','spk__imediator_keaktifan.status')
                                        ->where('spk__imediator_keaktifan.id', '=', $id)
                                        ->limit(1)
                                        ->first();
            $total_kes                  = DB::table('spk__imediator_mediasi')
                                        ->select(DB::raw('count(*) as total_kes'))
                                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_mediasi.spk_imediator_id')
                                        ->leftJoin('spk__imediator_keaktifan','spk__imediator_keaktifan.spk_imediator_id','=','spk__imediator.id')
                                        ->where('spk__imediator_keaktifan.id', '=', $id)
                                        ->limit(1)
                                        ->first();
            return view('rt-sm23.keaktifan-mkp-ppmk', 
            compact('roles_menu','mediasi_kluster', 'mediasi_status', 'mediasi_peringkat', 'mkp', 'total_kes'));
        }
    }

    function senarai_mkp_keaktifan_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('spk__imediator_keaktifan')
                        ->select('spk__imediator_keaktifan.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'users__profile.user_fullname AS mkp_pemohon_nama',
                                'users__profile.no_ic AS mkp_pemohon_ic',
                                'users__profile.no_phone AS mkp_pemohon_no_phone',
                                'users.user_email AS mkp_pemohon_email',
                                'spk__imediator_keaktifan.status AS status',
                                'ref__status_spk_imediator_keaktifan.status_description AS status_description',
                                DB::raw(" CONCAT('MKP','/',users__profile.state_id,'/',users__profile.daerah_id,'/',spk__imediator.id) AS no_rujukan_mkp"))
                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_keaktifan.spk_imediator_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                        ->leftJoin('ref__status_spk_imediator_keaktifan','ref__status_spk_imediator_keaktifan.id','=','spk__imediator_keaktifan.status')
                        ->where('users__profile.state_id', '=', Auth::user()->state_id)
                        ->whereIN('spk__imediator_keaktifan.status',[1])
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
            return view('rt-sm23.senarai-mkp-keaktifan-ppn', compact('roles_menu','daerah'));
        }
    }

    function keaktifan_mkp_ppn(Request $request, $id){
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
            $mediasi_kluster            = Ref_SPK_MKP_Mediasi::where('status', '=', true)->get();
            $mediasi_status             = Ref_SPK_MKP_Mediasi_Status::where('status', '=', true)->get();
            $mediasi_peringkat          = Ref_SPK_MKP_Peringkat::where('status', '=', true)->get();
            $mkp                        = DB::table('spk__imediator')
                                        ->select('spk__imediator.id AS id',
                                                'spk__imediator_keaktifan.id AS spk_imediator_id',
                                                'users__profile.user_fullname AS mkp_nama',
                                                'users__profile.no_ic AS mkp_no_ic',
                                                'users__profile.no_phone AS mkp_no_phone',
                                                'users.user_email AS user_email',
                                                'spk__imediator_keaktifan.status AS status',
                                                DB::raw(" CONCAT('MKP','/',users__profile.state_id,'/',users__profile.daerah_id,'/',spk__imediator.id) AS no_rujukan_mkp"),
                                                'ref__status_spk_imediator_keaktifan.status_description AS status_description')
                                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                                        ->leftJoin('spk__imediator_keaktifan','spk__imediator_keaktifan.spk_imediator_id','=','spk__imediator.id')
                                        ->leftJoin('ref__status_spk_imediator_keaktifan','ref__status_spk_imediator_keaktifan.id','=','spk__imediator_keaktifan.status')
                                        ->where('spk__imediator_keaktifan.id', '=', $id)
                                        ->limit(1)
                                        ->first();
            $total_kes                  = DB::table('spk__imediator_mediasi')
                                        ->select(DB::raw('count(*) as total_kes'))
                                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_mediasi.spk_imediator_id')
                                        ->leftJoin('spk__imediator_keaktifan','spk__imediator_keaktifan.spk_imediator_id','=','spk__imediator.id')
                                        ->where('spk__imediator_keaktifan.id', '=', $id)
                                        ->limit(1)
                                        ->first();
            return view('rt-sm23.keaktifan-mkp-ppn', 
            compact('roles_menu','mediasi_kluster', 'mediasi_status', 'mediasi_peringkat', 'mkp', 'total_kes'));
        }
    }

    function senarai_mkp_keaktifan_upmk(Request $request){
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
            $data = DB::table('spk__imediator_keaktifan')
                        ->select('spk__imediator_keaktifan.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'users__profile.user_fullname AS mkp_pemohon_nama',
                                'users__profile.no_ic AS mkp_pemohon_ic',
                                'users__profile.no_phone AS mkp_pemohon_no_phone',
                                'users.user_email AS mkp_pemohon_email',
                                'spk__imediator_keaktifan.status AS status',
                                'ref__status_spk_imediator_keaktifan.status_description AS status_description',
                                DB::raw(" CONCAT('MKP','/',users__profile.state_id,'/',users__profile.daerah_id,'/',spk__imediator.id) AS no_rujukan_mkp"))
                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_keaktifan.spk_imediator_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                        ->leftJoin('ref__status_spk_imediator_keaktifan','ref__status_spk_imediator_keaktifan.id','=','spk__imediator_keaktifan.status')
                        ->whereIN('spk__imediator_keaktifan.status',[1])
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
            return view('rt-sm23.senarai-mkp-keaktifan-upmk', compact('roles_menu','state'));
        }
    }

    function keaktifan_mkp_upmk(Request $request, $id){
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
            $mediasi_kluster            = Ref_SPK_MKP_Mediasi::where('status', '=', true)->get();
            $mediasi_status             = Ref_SPK_MKP_Mediasi_Status::where('status', '=', true)->get();
            $mediasi_peringkat          = Ref_SPK_MKP_Peringkat::where('status', '=', true)->get();
            $mkp                        = DB::table('spk__imediator')
                                        ->select('spk__imediator.id AS id',
                                                'spk__imediator_keaktifan.id AS spk_imediator_id',
                                                'users__profile.user_fullname AS mkp_nama',
                                                'users__profile.no_ic AS mkp_no_ic',
                                                'users__profile.no_phone AS mkp_no_phone',
                                                'users.user_email AS user_email',
                                                'spk__imediator_keaktifan.status AS status',
                                                DB::raw(" CONCAT('MKP','/',users__profile.state_id,'/',users__profile.daerah_id,'/',spk__imediator.id) AS no_rujukan_mkp"),
                                                'ref__status_spk_imediator_keaktifan.status_description AS status_description')
                                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                                        ->leftJoin('spk__imediator_keaktifan','spk__imediator_keaktifan.spk_imediator_id','=','spk__imediator.id')
                                        ->leftJoin('ref__status_spk_imediator_keaktifan','ref__status_spk_imediator_keaktifan.id','=','spk__imediator_keaktifan.status')
                                        ->where('spk__imediator_keaktifan.id', '=', $id)
                                        ->limit(1)
                                        ->first();
            $total_kes                  = DB::table('spk__imediator_mediasi')
                                        ->select(DB::raw('count(*) as total_kes'))
                                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_mediasi.spk_imediator_id')
                                        ->leftJoin('spk__imediator_keaktifan','spk__imediator_keaktifan.spk_imediator_id','=','spk__imediator.id')
                                        ->where('spk__imediator_keaktifan.id', '=', $id)
                                        ->limit(1)
                                        ->first();
            return view('rt-sm23.keaktifan-mkp-upmk', 
            compact('roles_menu','mediasi_kluster', 'mediasi_status', 'mediasi_peringkat', 'mkp', 'total_kes'));
        }
    }

    function senarai_mkp_keaktifan_p(Request $request){
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
            $data = DB::table('spk__imediator_keaktifan')
                        ->select('spk__imediator_keaktifan.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'users__profile.user_fullname AS mkp_pemohon_nama',
                                'users__profile.no_ic AS mkp_pemohon_ic',
                                'users__profile.no_phone AS mkp_pemohon_no_phone',
                                'users.user_email AS mkp_pemohon_email',
                                'spk__imediator_keaktifan.status AS status',
                                'ref__status_spk_imediator_keaktifan.status_description AS status_description',
                                DB::raw(" CONCAT('MKP','/',users__profile.state_id,'/',users__profile.daerah_id,'/',spk__imediator.id) AS no_rujukan_mkp"))
                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_keaktifan.spk_imediator_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                        ->leftJoin('ref__status_spk_imediator_keaktifan','ref__status_spk_imediator_keaktifan.id','=','spk__imediator_keaktifan.status')
                        ->whereIN('spk__imediator_keaktifan.status',[1])
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
            return view('rt-sm23.senarai-mkp-keaktifan-p', compact('roles_menu','state'));
        }
    }

    function keaktifan_mkp_p(Request $request, $id){
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
            $mediasi_kluster            = Ref_SPK_MKP_Mediasi::where('status', '=', true)->get();
            $mediasi_status             = Ref_SPK_MKP_Mediasi_Status::where('status', '=', true)->get();
            $mediasi_peringkat          = Ref_SPK_MKP_Peringkat::where('status', '=', true)->get();
            $mkp                        = DB::table('spk__imediator')
                                        ->select('spk__imediator.id AS id',
                                                'spk__imediator_keaktifan.id AS spk_imediator_id',
                                                'users__profile.user_fullname AS mkp_nama',
                                                'users__profile.no_ic AS mkp_no_ic',
                                                'users__profile.no_phone AS mkp_no_phone',
                                                'users.user_email AS user_email',
                                                'spk__imediator_keaktifan.status AS status',
                                                DB::raw(" CONCAT('MKP','/',users__profile.state_id,'/',users__profile.daerah_id,'/',spk__imediator.id) AS no_rujukan_mkp"),
                                                'ref__status_spk_imediator_keaktifan.status_description AS status_description')
                                        ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                                        ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                                        ->leftJoin('spk__imediator_keaktifan','spk__imediator_keaktifan.spk_imediator_id','=','spk__imediator.id')
                                        ->leftJoin('ref__status_spk_imediator_keaktifan','ref__status_spk_imediator_keaktifan.id','=','spk__imediator_keaktifan.status')
                                        ->where('spk__imediator_keaktifan.id', '=', $id)
                                        ->limit(1)
                                        ->first();
            $total_kes                  = DB::table('spk__imediator_mediasi')
                                        ->select(DB::raw('count(*) as total_kes'))
                                        ->leftJoin('spk__imediator','spk__imediator.id','=','spk__imediator_mediasi.spk_imediator_id')
                                        ->leftJoin('spk__imediator_keaktifan','spk__imediator_keaktifan.spk_imediator_id','=','spk__imediator.id')
                                        ->where('spk__imediator_keaktifan.id', '=', $id)
                                        ->limit(1)
                                        ->first();
            return view('rt-sm23.keaktifan-mkp-p', 
            compact('roles_menu','mediasi_kluster', 'mediasi_status', 'mediasi_peringkat', 'mkp', 'total_kes'));
        }
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function permohonan_pelanjutan_mkp(Request $request){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $bandar             = RefBandar::where('status', '=', true)->get();
            $parlimen           = RefParlimen::where('status', '=', true)->get();
            $dun                = RefDUN::where('status', '=', true)->get();
            $pbt                = RefPBT::where('status', '=', true)->get();
            $krt                = KRT_Profile::where('krt_status', '=', true)->get();
            $kaum               = RefKaum::where('status', '=', true)->get();
            $jantina            = RefJantina::where('status', '=', true)->get();
            $pendidikan         = RefPendidikan::where('pendidikan_status', '=', true)->get();
            $mkp_kategori       = Ref_SPK_MKP_Kategori::where('status', '=', true)->get();
            $mkp_tahap          = Ref_SPK_MKP_Tahap::where('status', '=', true)->get();
            $kategori_kursus    = Ref_SPK_MKP_Kategori_Kursus::where('status', '=', true)->get();
            $peringkat_kursus   = Ref_SPK_MKP_Peringkat_Kursus::where('status', '=', true)->get();
            $mkp                = DB::table('spk__imediator')
                                ->select('spk__imediator.id',
                                    DB::raw("CONCAT('MKP','/',users__profile.state_id,'/',users__profile.daerah_id,'/',spk__imediator.id) AS no_rujukan_mkp"),
                                    DB::raw("(case when a.count_kes >= 2 AND b.count_kes >= 2 AND c.count_kes >= 2 then 'Layak' else 'Tidak Layak' end)AS status_kelayakan"),
                                    'spk__imediator.hasRT',
                                    'users__profile.state_id AS mkp_pemohon_state_id',
                                    'users__profile.daerah_id AS mkp_pemohon_daerah_id',
                                    'spk__imediator.krt_profile_id',
                                    'spk__imediator.mkp_file_avatar',
                                    'users__profile.user_fullname AS mkp_pemohon_nama',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_pemohon_tarikh_lahir,'%d/%m/%Y') AS mkp_pemohon_tarikh_lahir"),
                                    'spk__imediator.mkp_pemohon_dun_id',
                                    'spk__imediator.mkp_pemohon_mukim_id',
                                    'spk__imediator.mkp_pemohon_kaum_id',
                                    'spk__imediator.mkp_pemohon_alamat',
                                    'users__profile.no_phone AS mkp_pemohon_no_phone',
                                    'spk__imediator.mkp_pemohon_kategori_id',
                                    'spk__imediator.mkp_pemohon_akademik',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_tarikh_dilantik,'%d/%m/%Y') AS mkp_tarikh_dilantik"),
                                    'users__profile.no_ic AS mkp_pemohon_ic',
                                    'users__profile.state_id AS mkp_pemohon_state_id',
                                    'spk__imediator.mkp_pemohon_parlimen_id',
                                    'spk__imediator.mkp_pemohon_pbt_id',
                                    'spk__imediator.mkp_pemohon_jantina_id',
                                    'users.user_email AS mkp_pemohon_email',
                                    'spk__imediator.mkp_pemohon_alamat_p',
                                    'spk__imediator.mkp_pemohon_no_phone_p',
                                    'spk__imediator.mkp_pemohon_tahap_id',
                                    'spk__imediator.mkp_pemohon_khusus',
                                    'spk__imediator.status_pelanjutan',
                                    'spk__imediator.status',
                                    'spk__imediator_keaktifan.status AS status_keaktifan',
                                    'ref__status_spk_imediator.status_description',
                                    'spk__imediator.disokong_note',
                                    'spk__imediator.disokong_p_note',
                                    'spk__imediator.disahkan_note',
                                    'spk__imediator.disemak_note',
                                    'spk__imediator.dilulus_note',
                                    'spk__imediator.dilantik_note')
                                ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                                ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                                ->leftJoin('ref__states','ref__states.state_id','=','users.state_id')
                                ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users.daerah_id')
                                ->leftJoin('ref__status_spk_imediator','ref__status_spk_imediator.id','=','spk__imediator.status_pelanjutan')
                                ->leftJoin('krt__profile','krt__profile.id','=','spk__imediator.krt_profile_id')
                                ->leftJoin('spk__imediator_keaktifan','spk__imediator_keaktifan.spk_imediator_id','=','spk__imediator.id')
                                ->leftJoin(DB::raw('(SELECT spk__imediator_mediasi.spk_imediator_id, COUNT(*) count_kes
                                                    FROM spk__imediator_mediasi GROUP BY spk__imediator_mediasi.spk_imediator_id)
                                                    a'), function ($join) {
                                    $join->on('a.spk_imediator_id', '=', 'spk__imediator.id');
                                })
                                ->leftJoin(DB::raw('(SELECT spk__imediator_keaktifan_aktiviti.spk_imediator_id, COUNT(*) count_kes
                                                    FROM spk__imediator_keaktifan_aktiviti GROUP BY spk__imediator_keaktifan_aktiviti.spk_imediator_id)
                                                    b'), function ($join) {
                                    $join->on('b.spk_imediator_id', '=', 'spk__imediator.id');
                                })
                                ->leftJoin(DB::raw('(SELECT spk__imediator_keaktifan_latihan.spk_imediator_id, COUNT(*) count_kes
                                                    FROM spk__imediator_keaktifan_latihan GROUP BY spk__imediator_keaktifan_latihan.spk_imediator_id)
                                                    c'), function ($join) {
                                    $join->on('c.spk_imediator_id', '=', 'spk__imediator.id');
                                })
                                ->where('spk__imediator.user_id', '=', Auth::user()->user_id)
                                ->limit(1)
                                ->first();
            
            return view('rt-sm23.permohonan-pelanjutan-mkp', 
            compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'kaum', 'jantina', 'pendidikan', 'mkp_kategori', 'mkp_tahap', 'kategori_kursus', 'peringkat_kursus','mkp'));
        }
    }

    function post_imediator_kursus(Request $request){
        $action = $request->post_imediator_kursus;
        $app_id = $request->ppm2_spk_imediator_id;
        
        $rules = array(
            'ppm2_kursus_nama'                       => 'required',
            'ppm2_mkp_kategori_kursus_id'           => 'required',
            'ppm2_mkp_peringkat_kursus_id'          => 'required',
            'ppm2_kursus_penganjur'                 => 'required',
            'ppm2_file_dokument'                    => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:5000'
        );

        $messages = [
            'ppm2_kursus_nama.required'              => 'Ruangan Nama Kursus Mesti Diisi',
            'ppm2_mkp_kategori_kursus_id.required'  => 'Ruangan Kategori Kursus Mesti Dipilih',
            'ppm2_mkp_peringkat_kursus_id.required' => 'Ruangan Peringkat Kursus Mesti Dipilih',
            'ppm2_kursus_penganjur.required'        => 'Ruangan Penganjur Mesti Diisi',
            'ppm2_file_dokument.required'           => 'Ruangan Dokumen Mesti Dipilih',
            'ppm2_file_dokument.mimes'              => 'Fail Mesti Dipilih Dalam Format jpeg,png,jpg,gif,svg,pdf',
            'ppm2_file_dokument.max'                => 'Fail mesti dalam sive 5000KB',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            
            if ($action == 'add') {
                $fileName = $request->ppm2_file_dokument->getClientOriginalName();
                $request->ppm2_file_dokument->storeAs('public/mkp_dokument_kursus',$fileName);
                $mkp_dokument_kursus                            = new SPK_iMediator_Kursus;
                $mkp_dokument_kursus->spk_imediator_id          = $app_id;
                $mkp_dokument_kursus->kursus_nama               = $request->ppm2_kursus_nama;
                $mkp_dokument_kursus->mkp_kategori_kursus_id    = $request->ppm2_mkp_kategori_kursus_id;
                $mkp_dokument_kursus->mkp_peringkat_kursus_id   = $request->ppm2_mkp_peringkat_kursus_id;
                $mkp_dokument_kursus->kursus_penganjur          = $request->ppm2_kursus_penganjur;
                $mkp_dokument_kursus->file_dokument             = $fileName;
                $mkp_dokument_kursus->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_kursus_mkp($id){
        $data = DB::table('spk__imediator_kursus')->where('id', '=', $id)->delete();
    }

    function post_mohon_pelanjutan_mkp(Request $request){
        $action = $request->post_mohon_pelanjutan_mkp;
        $app_id = $request->ppm3_spk_imediator_id;
        $hasKRT = $request->ppm_hasRT;

        if ($hasKRT == '1') {
            $rules_main = array(                
                'ppm_krt_profile_id'                   => 'required',
                'ppm1_mkp_pemohon_tarikh_lahir'        => 'required',
                'ppm1_mkp_pemohon_dun_id'              => 'required',
                'ppm1_mkp_pemohon_mukim_id'            => 'required',
                'ppm1_mkp_pemohon_kaum_id'             => 'required',
                'ppm1_mkp_pemohon_alamat'              => 'required',
                'ppm1_mkp_pemohon_kategori_id'         => 'required',
                'ppm1_mkp_pemohon_akademik'            => 'required',
                'ppm1_mkp_pemohon_parlimen_id'         => 'required',
                'ppm1_mkp_pemohon_pbt_id'              => 'required',
                'ppm1_mkp_pemohon_jantina_id'          => 'required',
                'ppm1_mkp_pemohon_alamat_p'            => 'required',
                'ppm1_mkp_pemohon_no_phone_p'          => 'required|numeric',
                'ppm1_mkp_pemohon_tahap_id'            => 'required',
                'ppm1_mkp_pemohon_khusus'              => 'required',
                'ppm1_mkp_tarikh_dilantik'             => 'required',
            );
        } else {
            $rules_main = array(
                'ppm1_mkp_pemohon_tarikh_lahir'        => 'required',
                'ppm1_mkp_pemohon_dun_id'              => 'required',
                'ppm1_mkp_pemohon_mukim_id'            => 'required',
                'ppm1_mkp_pemohon_kaum_id'             => 'required',
                'ppm1_mkp_pemohon_alamat'              => 'required',
                'ppm1_mkp_pemohon_kategori_id'         => 'required',
                'ppm1_mkp_pemohon_akademik'            => 'required',
                'ppm1_mkp_pemohon_parlimen_id'         => 'required',
                'ppm1_mkp_pemohon_pbt_id'              => 'required',
                'ppm1_mkp_pemohon_jantina_id'          => 'required',
                'ppm1_mkp_pemohon_alamat_p'            => 'required',
                'ppm1_mkp_pemohon_no_phone_p'          => 'required|numeric',
                'ppm1_mkp_pemohon_tahap_id'            => 'required',
                'ppm1_mkp_pemohon_khusus'              => 'required',
                'ppm1_mkp_tarikh_dilantik'             => 'required',
            );
        }
        
        $messages = [
            'ppm_krt_profile_id.required'              => 'Ruangan Nama KRT mesti dipilih',
            'ppm1_mkp_pemohon_tarikh_lahir.required'   => 'Ruangan Tarikh Lahir mesti dipilih',
            'ppm1_mkp_pemohon_dun_id.required'         => 'Ruangan Dun mesti dipilih',
            'ppm1_mkp_pemohon_mukim_id.required'       => 'Ruangan Mukim mesti diisi',
            'ppm1_mkp_pemohon_kaum_id.required'        => 'Ruangan Kaum mesti dipilih',
            'ppm1_mkp_pemohon_alamat.required'         => 'Ruangan Alamat mesti diisi',
            'ppm1_mkp_pemohon_kategori_id.required'    => 'Ruangan Kategori MKP mesti dipilih',
            'ppm1_mkp_pemohon_akademik.required'       => 'Ruangan Kelulusan Akademik mesti dipilih',
            'ppm1_mkp_pemohon_parlimen_id.required'    => 'Ruangan Parlimen mesti dipilih',
            'ppm1_mkp_pemohon_pbt_id.required'         => 'Ruangan PBT mesti dipilih',
            'ppm1_mkp_pemohon_jantina_id.required'     => 'Ruangan Jantina mesti dipilih',
            'ppm1_mkp_pemohon_no_phone_p.required'     => 'Ruangan No Telefon Pejabat mesti diisi',
            'ppm1_mkp_pemohon_no_phone_p.numeric'      => 'Ruangan No Telefon Pejabat mesti diisi dalam bentuk Nombor',
            'ppm1_mkp_pemohon_alamat_p.required'       => 'Ruangan Alamat Pejabat mesti diisi',
            'ppm1_mkp_pemohon_tahap_id.required'       => 'Ruangan Tahap MKP mesti dipilih',
            'ppm1_mkp_pemohon_khusus.required'         => 'Ruangan Pengkhususan mesti diisi',
            'ppm1_mkp_tarikh_dilantik.required'        => 'Ruangan Tarikh Pelantikan mesti diisi',
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $carbon_obj                               = Carbon::createFromFormat('d/m/Y', $request->ppm1_mkp_pemohon_tarikh_lahir)->format('Y-m-d');
                $carbon_obj_1                             = Carbon::createFromFormat('d/m/Y', $request->ppm1_mkp_tarikh_dilantik)->format('Y-m-d');
                $update_mkp                               = SPK_imediator::where($where)->first();
                $update_mkp->hasRT                        = $hasKRT;
                $update_mkp->krt_profile_id               = $request->ppm_krt_profile_id;
                $update_mkp->mkp_pemohon_tarikh_lahir     = $carbon_obj;
                $update_mkp->mkp_pemohon_parlimen_id      = $request->ppm1_mkp_pemohon_parlimen_id;
                $update_mkp->mkp_pemohon_dun_id           = $request->ppm1_mkp_pemohon_dun_id;
                $update_mkp->mkp_pemohon_pbt_id           = $request->ppm1_mkp_pemohon_pbt_id;
                $update_mkp->mkp_pemohon_mukim_id         = $request->ppm1_mkp_pemohon_mukim_id;
                $update_mkp->mkp_pemohon_jantina_id       = $request->ppm1_mkp_pemohon_jantina_id;
                $update_mkp->mkp_pemohon_kaum_id          = $request->ppm1_mkp_pemohon_kaum_id;
                $update_mkp->mkp_pemohon_alamat           = $request->ppm1_mkp_pemohon_alamat;
                $update_mkp->mkp_pemohon_alamat_p         = $request->ppm1_mkp_pemohon_alamat_p;
                $update_mkp->mkp_pemohon_no_phone_p       = $request->ppm1_mkp_pemohon_no_phone_p;
                $update_mkp->mkp_pemohon_kategori_id      = $request->ppm1_mkp_pemohon_kategori_id;
                $update_mkp->mkp_pemohon_tahap_id         = $request->ppm1_mkp_pemohon_tahap_id;
                $update_mkp->mkp_pemohon_akademik         = $request->ppm1_mkp_pemohon_akademik;
                $update_mkp->mkp_pemohon_khusus           = $request->ppm1_mkp_pemohon_khusus;
                $update_mkp->mkp_tarikh_dilantik          = $carbon_obj_1;
                $update_mkp->status                       = 15;
                $update_mkp->status_pelanjutan            = 3;
                $update_mkp->dihantar_by                  = Auth::user()->user_id;
                $update_mkp->dihantar_date                = date('Y-m-d H:i:s');
                $update_mkp->save();
                
            }
        }
    }

    function senarai_sokongan_pelanjutan_mkp_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::select(DB::raw("
            SELECT spk__imediator.id AS id,
            ref__states.state_description AS state_description,
            ref__daerahs.daerah_description AS daerah_description,
            users__profile.user_fullname AS mkp_pemohon_nama,
            users__profile.no_ic AS mkp_pemohon_ic,
            users__profile.no_phone AS mkp_pemohon_no_phone,
            users.user_email AS mkp_pemohon_email,
            DATE_FORMAT(spk__imediator.mkp_tarikh_dilantik,'%d/%m/%Y') AS mkp_tarikh_dilantik,
            DATE_FORMAT(DATE_ADD(spk__imediator.mkp_tarikh_dilantik, INTERVAL 548 DAY),'%d/%m/%Y') AS tarikh_kemaskini,
            DATE_FORMAT(DATE_ADD(spk__imediator.mkp_tarikh_dilantik, INTERVAL 731 DAY),'%d/%m/%Y') AS tarikh_tamat,
            (case when a.count_kes >= 2 AND b.count_aktiviti >= 2 AND c.count_latihan >= 2 then 'Layak' else 'Tidak Layak' end)AS status_kelayakan,
            ref__status_spk_imediator.status_description AS status_pelanjutan,
            spk__imediator.status_pelanjutan AS status
            FROM spk__imediator
            LEFT JOIN users ON users.user_id = spk__imediator.user_id
            LEFT JOIN users__profile ON users__profile.user_id = spk__imediator.user_id
            LEFT JOIN ref__states ON ref__states.state_id = users__profile.state_id
            LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = users__profile.daerah_id
            LEFT JOIN ref__status_spk_imediator ON ref__status_spk_imediator.id = spk__imediator.status_pelanjutan
            LEFT JOIN (
                            SELECT spk__imediator_mediasi.spk_imediator_id, count(*) AS count_kes
                            FROM spk__imediator_mediasi
                            GROUP BY spk__imediator_mediasi.spk_imediator_id
            ) a ON a.spk_imediator_id = spk__imediator.id
            LEFT JOIN (
                            SELECT spk__imediator_keaktifan_aktiviti.spk_imediator_id, count(*) AS count_aktiviti
                            FROM spk__imediator_keaktifan_aktiviti
                            GROUP BY spk__imediator_keaktifan_aktiviti.spk_imediator_id
            ) b ON b.spk_imediator_id = spk__imediator.id
            LEFT JOIN (
                            SELECT spk__imediator_keaktifan_latihan.spk_imediator_id, count(*) AS count_latihan
                            FROM spk__imediator_keaktifan_latihan
                            GROUP BY spk__imediator_keaktifan_latihan.spk_imediator_id
            ) c ON c.spk_imediator_id = spk__imediator.id
            WHERE users__profile.daerah_id = '" . Auth::user()->daerah_id . "' AND spk__imediator.status_pelanjutan = 3 AND spk__imediator.mkp_pemohon_kategori_id IN (2,3,4,5)
                    "));
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
            return view('rt-sm23.senarai-sokongan-pelanjutan-mkp-ppd',compact('roles_menu'));
        }
    }

    function sokongan_pelanjuatan_mkp_ppd(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $bandar             = RefBandar::where('status', '=', true)->get();
            $parlimen           = RefParlimen::where('status', '=', true)->get();
            $dun                = RefDUN::where('status', '=', true)->get();
            $pbt                = RefPBT::where('status', '=', true)->get();
            $krt                = KRT_Profile::where('krt_status', '=', true)->get();
            $kaum               = RefKaum::where('status', '=', true)->get();
            $jantina            = RefJantina::where('status', '=', true)->get();
            $pendidikan         = RefPendidikan::where('pendidikan_status', '=', true)->get();
            $mkp_kategori       = Ref_SPK_MKP_Kategori::where('status', '=', true)->get();
            $mkp_tahap          = Ref_SPK_MKP_Tahap::where('status', '=', true)->get();
            $kategori_kursus    = Ref_SPK_MKP_Kategori_Kursus::where('status', '=', true)->get();
            $peringkat_kursus   = Ref_SPK_MKP_Peringkat_Kursus::where('status', '=', true)->get();
            $mkp                = DB::table('spk__imediator')
                                ->select('spk__imediator.id',
                                    'spk__imediator.hasRT',
                                    'users__profile.state_id AS mkp_pemohon_state_id',
                                    'users__profile.daerah_id AS mkp_pemohon_daerah_id',
                                    'spk__imediator.krt_profile_id',
                                    'spk__imediator.mkp_file_avatar',
                                    'users__profile.user_fullname AS mkp_pemohon_nama',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_pemohon_tarikh_lahir,'%d/%m/%Y') AS mkp_pemohon_tarikh_lahir"),
                                    'spk__imediator.mkp_pemohon_dun_id',
                                    'spk__imediator.mkp_pemohon_mukim_id',
                                    'spk__imediator.mkp_pemohon_kaum_id',
                                    'spk__imediator.mkp_pemohon_alamat',
                                    'users__profile.no_phone AS mkp_pemohon_no_phone',
                                    'spk__imediator.mkp_pemohon_kategori_id',
                                    'spk__imediator.mkp_pemohon_akademik',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_tarikh_dilantik,'%d/%m/%Y') AS mkp_tarikh_dilantik"),
                                    'users__profile.no_ic AS mkp_pemohon_ic',
                                    'users__profile.state_id AS mkp_pemohon_state_id',
                                    'spk__imediator.mkp_pemohon_parlimen_id',
                                    'spk__imediator.mkp_pemohon_pbt_id',
                                    'spk__imediator.mkp_pemohon_jantina_id',
                                    'users.user_email AS mkp_pemohon_email',
                                    'spk__imediator.mkp_pemohon_alamat_p',
                                    'spk__imediator.mkp_pemohon_no_phone_p',
                                    'spk__imediator.mkp_pemohon_tahap_id',
                                    'spk__imediator.mkp_pemohon_khusus',
                                    'spk__imediator.status_pelanjutan'
                                    )
                            ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                            ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                            ->leftJoin('ref__states','ref__states.state_id','=','users.state_id')
                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users.daerah_id')
                            ->leftJoin('krt__profile','krt__profile.id','=','spk__imediator.krt_profile_id')
                            ->where('spk__imediator.id', '=', $id)  
                            ->limit(1)
                            ->first();
            return view('rt-sm23.sokongan-pelanjuatan-mkp-ppd', 
            compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'kaum', 'jantina', 'pendidikan', 'mkp_kategori', 'mkp_tahap', 'kategori_kursus', 'peringkat_kursus', 'mkp'));
        }
    }

    function post_sokongan_pelanjutan_mkp_ppd(Request $request){
        $action = $request->post_sokongan_pelanjutan_mkp_ppd;
        $app_id = $request->spmpd_spk_imediator_id;
        
        
        $rules = array(
            'spmpd_imediator_status'            => 'required',
            'spmpd_disokong_note'               => 'required',
        );

        $messages = [
            'spmpd_imediator_status.required'   => 'Ruangan Status dipilih',
            'spmpd_disokong_note.required'      => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $sokongan_pelanjutan_mkp                    = SPK_imediator::where($where)->first();
                $sokongan_pelanjutan_mkp->status_pelanjutan = $request->spmpd_imediator_status;
                $sokongan_pelanjutan_mkp->disokong_by       = Auth::user()->user_id;
                $sokongan_pelanjutan_mkp->disokong_date     = date('Y-m-d H:i:s');
                $sokongan_pelanjutan_mkp->disokong_note     = $request->spmpd_disokong_note;
                $sokongan_pelanjutan_mkp->save();
            }
        }
    }

    function senarai_sokongan_pelanjutan_mkp_ppmk(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::select(DB::raw("
            SELECT spk__imediator.id AS id,
            ref__states.state_description AS state_description,
            ref__daerahs.daerah_description AS daerah_description,
            users__profile.user_fullname AS mkp_pemohon_nama,
            users__profile.no_ic AS mkp_pemohon_ic,
            users__profile.no_phone AS mkp_pemohon_no_phone,
            users.user_email AS mkp_pemohon_email,
            DATE_FORMAT(spk__imediator.mkp_tarikh_dilantik,'%d/%m/%Y') AS mkp_tarikh_dilantik,
            DATE_FORMAT(DATE_ADD(spk__imediator.mkp_tarikh_dilantik, INTERVAL 548 DAY),'%d/%m/%Y') AS tarikh_kemaskini,
            DATE_FORMAT(DATE_ADD(spk__imediator.mkp_tarikh_dilantik, INTERVAL 731 DAY),'%d/%m/%Y') AS tarikh_tamat,
            (case when a.count_kes >= 2 AND b.count_aktiviti >= 2 AND c.count_latihan >= 2 then 'Layak' else 'Tidak Layak' end)AS status_kelayakan,
            ref__status_spk_imediator.status_description AS status_pelanjutan,
            spk__imediator.status_pelanjutan AS status
            FROM spk__imediator
            LEFT JOIN users ON users.user_id = spk__imediator.user_id
            LEFT JOIN users__profile ON users__profile.user_id = spk__imediator.user_id
            LEFT JOIN ref__states ON ref__states.state_id = users__profile.state_id
            LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = users__profile.daerah_id
            LEFT JOIN ref__status_spk_imediator ON ref__status_spk_imediator.id = spk__imediator.status_pelanjutan
            LEFT JOIN (
                            SELECT spk__imediator_mediasi.spk_imediator_id, count(*) AS count_kes
                            FROM spk__imediator_mediasi
                            GROUP BY spk__imediator_mediasi.spk_imediator_id
            ) a ON a.spk_imediator_id = spk__imediator.id
            LEFT JOIN (
                            SELECT spk__imediator_keaktifan_aktiviti.spk_imediator_id, count(*) AS count_aktiviti
                            FROM spk__imediator_keaktifan_aktiviti
                            GROUP BY spk__imediator_keaktifan_aktiviti.spk_imediator_id
            ) b ON b.spk_imediator_id = spk__imediator.id
            LEFT JOIN (
                            SELECT spk__imediator_keaktifan_latihan.spk_imediator_id, count(*) AS count_latihan
                            FROM spk__imediator_keaktifan_latihan
                            GROUP BY spk__imediator_keaktifan_latihan.spk_imediator_id
            ) c ON c.spk_imediator_id = spk__imediator.id
            WHERE users__profile.state_id = '" . Auth::user()->state_id . "' AND spk__imediator.status_pelanjutan = 3 AND spk__imediator.mkp_pemohon_kategori_id IN (1)
                    "));
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
            return view('rt-sm23.senarai-sokongan-pelanjutan-mkp-ppmk',compact('roles_menu','daerah'));
        }
    }

    function sokongan_pelanjuatan_mkp_ppmk(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $bandar             = RefBandar::where('status', '=', true)->get();
            $parlimen           = RefParlimen::where('status', '=', true)->get();
            $dun                = RefDUN::where('status', '=', true)->get();
            $pbt                = RefPBT::where('status', '=', true)->get();
            $krt                = KRT_Profile::where('krt_status', '=', true)->get();
            $kaum               = RefKaum::where('status', '=', true)->get();
            $jantina            = RefJantina::where('status', '=', true)->get();
            $pendidikan         = RefPendidikan::where('pendidikan_status', '=', true)->get();
            $mkp_kategori       = Ref_SPK_MKP_Kategori::where('status', '=', true)->get();
            $mkp_tahap          = Ref_SPK_MKP_Tahap::where('status', '=', true)->get();
            $kategori_kursus    = Ref_SPK_MKP_Kategori_Kursus::where('status', '=', true)->get();
            $peringkat_kursus   = Ref_SPK_MKP_Peringkat_Kursus::where('status', '=', true)->get();
            $mkp                = DB::table('spk__imediator')
                                ->select('spk__imediator.id',
                                    'spk__imediator.hasRT',
                                    'users__profile.state_id AS mkp_pemohon_state_id',
                                    'users__profile.daerah_id AS mkp_pemohon_daerah_id',
                                    'spk__imediator.krt_profile_id',
                                    'spk__imediator.mkp_file_avatar',
                                    'users__profile.user_fullname AS mkp_pemohon_nama',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_pemohon_tarikh_lahir,'%d/%m/%Y') AS mkp_pemohon_tarikh_lahir"),
                                    'spk__imediator.mkp_pemohon_dun_id',
                                    'spk__imediator.mkp_pemohon_mukim_id',
                                    'spk__imediator.mkp_pemohon_kaum_id',
                                    'spk__imediator.mkp_pemohon_alamat',
                                    'users__profile.no_phone AS mkp_pemohon_no_phone',
                                    'spk__imediator.mkp_pemohon_kategori_id',
                                    'spk__imediator.mkp_pemohon_akademik',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_tarikh_dilantik,'%d/%m/%Y') AS mkp_tarikh_dilantik"),
                                    'users__profile.no_ic AS mkp_pemohon_ic',
                                    'users__profile.state_id AS mkp_pemohon_state_id',
                                    'spk__imediator.mkp_pemohon_parlimen_id',
                                    'spk__imediator.mkp_pemohon_pbt_id',
                                    'spk__imediator.mkp_pemohon_jantina_id',
                                    'users.user_email AS mkp_pemohon_email',
                                    'spk__imediator.mkp_pemohon_alamat_p',
                                    'spk__imediator.mkp_pemohon_no_phone_p',
                                    'spk__imediator.mkp_pemohon_tahap_id',
                                    'spk__imediator.mkp_pemohon_khusus',
                                    'spk__imediator.status_pelanjutan'
                                )
                                ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                                ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                                ->leftJoin('ref__states','ref__states.state_id','=','users.state_id')
                                ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users.daerah_id')
                                ->leftJoin('krt__profile','krt__profile.id','=','spk__imediator.krt_profile_id')
                                ->where('spk__imediator.id', '=', $id)  
                                ->limit(1)
                                ->first();
            return view('rt-sm23.sokongan-pelanjuatan-mkp-ppmk', 
            compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'kaum', 'jantina', 'pendidikan', 'mkp_kategori', 'mkp_tahap', 'kategori_kursus', 'peringkat_kursus', 'mkp'));
        }
    }

    function post_sokongan_pelanjutan_mkp_ppmk(Request $request){
        $action = $request->post_sokongan_pelanjutan_mkp_ppmk;
        $app_id = $request->spmppmk_spk_imediator_id;
        
        
        $rules = array(
            'spmppmk_imediator_status'            => 'required',
            'spmppmk_disokong_p_note'             => 'required',
        );

        $messages = [
            'spmppmk_imediator_status.required'   => 'Ruangan Status dipilih',
            'spmppmk_disokong_p_note.required'    => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $sokongan_pelanjutan_mkp                    = SPK_imediator::where($where)->first();
                $sokongan_pelanjutan_mkp->status_pelanjutan = $request->spmppmk_imediator_status;
                $sokongan_pelanjutan_mkp->disokong_p_by     = Auth::user()->user_id;
                $sokongan_pelanjutan_mkp->disokong_p_date   = date('Y-m-d H:i:s');
                $sokongan_pelanjutan_mkp->disokong_p_note   = $request->spmppmk_disokong_p_note;
                $sokongan_pelanjutan_mkp->save();
            }
        }
    }

    function senarai_sahkan_pelanjutan_mkp_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::select(DB::raw("
            SELECT spk__imediator.id AS id,
            ref__states.state_description AS state_description,
            ref__daerahs.daerah_description AS daerah_description,
            users__profile.user_fullname AS mkp_pemohon_nama,
            users__profile.no_ic AS mkp_pemohon_ic,
            users__profile.no_phone AS mkp_pemohon_no_phone,
            users.user_email AS mkp_pemohon_email,
            DATE_FORMAT(spk__imediator.mkp_tarikh_dilantik,'%d/%m/%Y') AS mkp_tarikh_dilantik,
            DATE_FORMAT(DATE_ADD(spk__imediator.mkp_tarikh_dilantik, INTERVAL 548 DAY),'%d/%m/%Y') AS tarikh_kemaskini,
            DATE_FORMAT(DATE_ADD(spk__imediator.mkp_tarikh_dilantik, INTERVAL 731 DAY),'%d/%m/%Y') AS tarikh_tamat,
            (case when a.count_kes >= 2 AND b.count_aktiviti >= 2 AND c.count_latihan >= 2 then 'Layak' else 'Tidak Layak' end)AS status_kelayakan,
            ref__status_spk_imediator.status_description AS status_pelanjutan,
            spk__imediator.status_pelanjutan AS status
            FROM spk__imediator
            LEFT JOIN users ON users.user_id = spk__imediator.user_id
            LEFT JOIN users__profile ON users__profile.user_id = spk__imediator.user_id
            LEFT JOIN ref__states ON ref__states.state_id = users__profile.state_id
            LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = users__profile.daerah_id
            LEFT JOIN ref__status_spk_imediator ON ref__status_spk_imediator.id = spk__imediator.status_pelanjutan
            LEFT JOIN (
                            SELECT spk__imediator_mediasi.spk_imediator_id, count(*) AS count_kes
                            FROM spk__imediator_mediasi
                            GROUP BY spk__imediator_mediasi.spk_imediator_id
            ) a ON a.spk_imediator_id = spk__imediator.id
            LEFT JOIN (
                            SELECT spk__imediator_keaktifan_aktiviti.spk_imediator_id, count(*) AS count_aktiviti
                            FROM spk__imediator_keaktifan_aktiviti
                            GROUP BY spk__imediator_keaktifan_aktiviti.spk_imediator_id
            ) b ON b.spk_imediator_id = spk__imediator.id
            LEFT JOIN (
                            SELECT spk__imediator_keaktifan_latihan.spk_imediator_id, count(*) AS count_latihan
                            FROM spk__imediator_keaktifan_latihan
                            GROUP BY spk__imediator_keaktifan_latihan.spk_imediator_id
            ) c ON c.spk_imediator_id = spk__imediator.id
            WHERE users__profile.state_id = '" . Auth::user()->state_id . "' AND spk__imediator.status_pelanjutan IN (4,6)
                    "));
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
            return view('rt-sm23.senarai-sahkan-pelanjutan-mkp-ppn', compact('roles_menu','daerah'));
        }
    }

    function sahkan_pelanjuatan_mkp_ppn(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $bandar             = RefBandar::where('status', '=', true)->get();
            $parlimen           = RefParlimen::where('status', '=', true)->get();
            $dun                = RefDUN::where('status', '=', true)->get();
            $pbt                = RefPBT::where('status', '=', true)->get();
            $krt                = KRT_Profile::where('krt_status', '=', true)->get();
            $kaum               = RefKaum::where('status', '=', true)->get();
            $jantina            = RefJantina::where('status', '=', true)->get();
            $pendidikan         = RefPendidikan::where('pendidikan_status', '=', true)->get();
            $mkp_kategori       = Ref_SPK_MKP_Kategori::where('status', '=', true)->get();
            $mkp_tahap          = Ref_SPK_MKP_Tahap::where('status', '=', true)->get();
            $kategori_kursus    = Ref_SPK_MKP_Kategori_Kursus::where('status', '=', true)->get();
            $peringkat_kursus   = Ref_SPK_MKP_Peringkat_Kursus::where('status', '=', true)->get();
            $mkp                = DB::table('spk__imediator')
                                ->select('spk__imediator.id',
                                    'spk__imediator.hasRT',
                                    'users__profile.state_id AS mkp_pemohon_state_id',
                                    'users__profile.daerah_id AS mkp_pemohon_daerah_id',
                                    'spk__imediator.krt_profile_id',
                                    'spk__imediator.mkp_file_avatar',
                                    'users__profile.user_fullname AS mkp_pemohon_nama',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_pemohon_tarikh_lahir,'%d/%m/%Y') AS mkp_pemohon_tarikh_lahir"),
                                    'spk__imediator.mkp_pemohon_dun_id',
                                    'spk__imediator.mkp_pemohon_mukim_id',
                                    'spk__imediator.mkp_pemohon_kaum_id',
                                    'spk__imediator.mkp_pemohon_alamat',
                                    'users__profile.no_phone AS mkp_pemohon_no_phone',
                                    'spk__imediator.mkp_pemohon_kategori_id',
                                    'spk__imediator.mkp_pemohon_akademik',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_tarikh_dilantik,'%d/%m/%Y') AS mkp_tarikh_dilantik"),
                                    'users__profile.no_ic AS mkp_pemohon_ic',
                                    'users__profile.state_id AS mkp_pemohon_state_id',
                                    'spk__imediator.mkp_pemohon_parlimen_id',
                                    'spk__imediator.mkp_pemohon_pbt_id',
                                    'spk__imediator.mkp_pemohon_jantina_id',
                                    'users.user_email AS mkp_pemohon_email',
                                    'spk__imediator.mkp_pemohon_alamat_p',
                                    'spk__imediator.mkp_pemohon_no_phone_p',
                                    'spk__imediator.mkp_pemohon_tahap_id',
                                    'spk__imediator.mkp_pemohon_khusus',
                                    'spk__imediator.status_pelanjutan')
                                ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                                ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                                ->leftJoin('ref__states','ref__states.state_id','=','users.state_id')
                                ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users.daerah_id')
                                ->leftJoin('krt__profile','krt__profile.id','=','spk__imediator.krt_profile_id')
                                ->where('spk__imediator.id', '=', $id)  
                                ->limit(1)
                                ->first();
            return view('rt-sm23.sahkan-pelanjuatan-mkp-ppn', 
            compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'kaum', 'jantina', 'pendidikan', 'mkp_kategori', 'mkp_tahap', 'kategori_kursus', 'peringkat_kursus', 'mkp'));
        }
    }

    function post_sahkan_pelanjutan_mkp_ppn(Request $request){
        $action = $request->post_sahkan_pelanjutan_mkp_ppn;
        $app_id = $request->spmpn_spk_imediator_id;
        
        
        $rules = array(
            'spmpn_imediator_status'            => 'required',
            'spmpn_disahkan_note'               => 'required',
        );

        $messages = [
            'spmpn_imediator_status.required'   => 'Ruangan Status dipilih',
            'spmpn_disahkan_note.required'      => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $sahkan_pelanjutan_mkp                    = SPK_imediator::where($where)->first();
                $sahkan_pelanjutan_mkp->status_pelanjutan = $request->spmpn_imediator_status;
                $sahkan_pelanjutan_mkp->disahkan_by       = Auth::user()->user_id;
                $sahkan_pelanjutan_mkp->disahkan_date     = date('Y-m-d H:i:s');
                $sahkan_pelanjutan_mkp->disahkan_note     = $request->spmpn_disahkan_note;
                $sahkan_pelanjutan_mkp->save();
            }
        }
    }

    function senarai_semakan_pelanjutan_mkp_upmk(Request $request){
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
            $data = DB::select(DB::raw("
            SELECT spk__imediator.id AS id,
            ref__states.state_description AS state_description,
            ref__daerahs.daerah_description AS daerah_description,
            users__profile.user_fullname AS mkp_pemohon_nama,
            users__profile.no_ic AS mkp_pemohon_ic,
            users__profile.no_phone AS mkp_pemohon_no_phone,
            users.user_email AS mkp_pemohon_email,
            DATE_FORMAT(spk__imediator.mkp_tarikh_dilantik,'%d/%m/%Y') AS mkp_tarikh_dilantik,
            DATE_FORMAT(DATE_ADD(spk__imediator.mkp_tarikh_dilantik, INTERVAL 548 DAY),'%d/%m/%Y') AS tarikh_kemaskini,
            DATE_FORMAT(DATE_ADD(spk__imediator.mkp_tarikh_dilantik, INTERVAL 731 DAY),'%d/%m/%Y') AS tarikh_tamat,
            (case when a.count_kes >= 2 AND b.count_aktiviti >= 2 AND c.count_latihan >= 2 then 'Layak' else 'Tidak Layak' end)AS status_kelayakan,
            ref__status_spk_imediator.status_description AS status_pelanjutan,
            spk__imediator.status_pelanjutan AS status
            FROM spk__imediator
            LEFT JOIN users ON users.user_id = spk__imediator.user_id
            LEFT JOIN users__profile ON users__profile.user_id = spk__imediator.user_id
            LEFT JOIN ref__states ON ref__states.state_id = users__profile.state_id
            LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = users__profile.daerah_id
            LEFT JOIN ref__status_spk_imediator ON ref__status_spk_imediator.id = spk__imediator.status_pelanjutan
            LEFT JOIN (
                            SELECT spk__imediator_mediasi.spk_imediator_id, count(*) AS count_kes
                            FROM spk__imediator_mediasi
                            GROUP BY spk__imediator_mediasi.spk_imediator_id
            ) a ON a.spk_imediator_id = spk__imediator.id
            LEFT JOIN (
                            SELECT spk__imediator_keaktifan_aktiviti.spk_imediator_id, count(*) AS count_aktiviti
                            FROM spk__imediator_keaktifan_aktiviti
                            GROUP BY spk__imediator_keaktifan_aktiviti.spk_imediator_id
            ) b ON b.spk_imediator_id = spk__imediator.id
            LEFT JOIN (
                            SELECT spk__imediator_keaktifan_latihan.spk_imediator_id, count(*) AS count_latihan
                            FROM spk__imediator_keaktifan_latihan
                            GROUP BY spk__imediator_keaktifan_latihan.spk_imediator_id
            ) c ON c.spk_imediator_id = spk__imediator.id
            WHERE spk__imediator.status_pelanjutan = 8
                    "));
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
            return view('rt-sm23.senarai-semakan-pelanjutan-mkp-upmk', compact('roles_menu','state'));
        }
    }

    function semakan_pelanjuatan_mkp_upmk(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $bandar             = RefBandar::where('status', '=', true)->get();
            $parlimen           = RefParlimen::where('status', '=', true)->get();
            $dun                = RefDUN::where('status', '=', true)->get();
            $pbt                = RefPBT::where('status', '=', true)->get();
            $krt                = KRT_Profile::where('krt_status', '=', true)->get();
            $kaum               = RefKaum::where('status', '=', true)->get();
            $jantina            = RefJantina::where('status', '=', true)->get();
            $pendidikan         = RefPendidikan::where('pendidikan_status', '=', true)->get();
            $mkp_kategori       = Ref_SPK_MKP_Kategori::where('status', '=', true)->get();
            $mkp_tahap          = Ref_SPK_MKP_Tahap::where('status', '=', true)->get();
            $kategori_kursus    = Ref_SPK_MKP_Kategori_Kursus::where('status', '=', true)->get();
            $peringkat_kursus   = Ref_SPK_MKP_Peringkat_Kursus::where('status', '=', true)->get();
            $mkp                = DB::table('spk__imediator')
                                ->select('spk__imediator.id',
                                    'spk__imediator.hasRT',
                                    'users__profile.state_id AS mkp_pemohon_state_id',
                                    'users__profile.daerah_id AS mkp_pemohon_daerah_id',
                                    'spk__imediator.krt_profile_id',
                                    'spk__imediator.mkp_file_avatar',
                                    'users__profile.user_fullname AS mkp_pemohon_nama',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_pemohon_tarikh_lahir,'%d/%m/%Y') AS mkp_pemohon_tarikh_lahir"),
                                    'spk__imediator.mkp_pemohon_dun_id',
                                    'spk__imediator.mkp_pemohon_mukim_id',
                                    'spk__imediator.mkp_pemohon_kaum_id',
                                    'spk__imediator.mkp_pemohon_alamat',
                                    'users__profile.no_phone AS mkp_pemohon_no_phone',
                                    'spk__imediator.mkp_pemohon_kategori_id',
                                    'spk__imediator.mkp_pemohon_akademik',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_tarikh_dilantik,'%d/%m/%Y') AS mkp_tarikh_dilantik"),
                                    'users__profile.no_ic AS mkp_pemohon_ic',
                                    'users__profile.state_id AS mkp_pemohon_state_id',
                                    'spk__imediator.mkp_pemohon_parlimen_id',
                                    'spk__imediator.mkp_pemohon_pbt_id',
                                    'spk__imediator.mkp_pemohon_jantina_id',
                                    'users.user_email AS mkp_pemohon_email',
                                    'spk__imediator.mkp_pemohon_alamat_p',
                                    'spk__imediator.mkp_pemohon_no_phone_p',
                                    'spk__imediator.mkp_pemohon_tahap_id',
                                    'spk__imediator.mkp_pemohon_khusus',
                                    'spk__imediator.status_pelanjutan')
                                ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                                ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                                ->leftJoin('ref__states','ref__states.state_id','=','users.state_id')
                                ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users.daerah_id')
                                ->leftJoin('krt__profile','krt__profile.id','=','spk__imediator.krt_profile_id')
                                ->where('spk__imediator.id', '=', $id)  
                                ->limit(1)
                                ->first();
            return view('rt-sm23.semakan-pelanjuatan-mkp-upmk', 
            compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'kaum', 'jantina', 'pendidikan', 'mkp_kategori', 'mkp_tahap', 'kategori_kursus', 'peringkat_kursus', 'mkp'));
        }
    }

    function post_semakan_pelanjutan_mkp_upmk(Request $request){
        $action = $request->post_semakan_pelanjutan_mkp_upmk;
        $app_id = $request->spmupmkn_spk_imediator_id;
        
        
        $rules = array(
            'spmupmkn_imediator_status'            => 'required',
            'spmupmkn_disemak_note'             => 'required',
        );

        $messages = [
            'spmupmkn_imediator_status.required'   => 'Ruangan Status dipilih',
            'spmupmkn_disemak_note.required'    => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $semakan_pelanjutan_mkp                    = SPK_imediator::where($where)->first();
                $semakan_pelanjutan_mkp->status_pelanjutan = $request->spmupmkn_imediator_status;
                $semakan_pelanjutan_mkp->disemak_by        = Auth::user()->user_id;
                $semakan_pelanjutan_mkp->disemak_date      = date('Y-m-d H:i:s');
                $semakan_pelanjutan_mkp->disemak_note      = $request->spmupmkn_disemak_note;
                $semakan_pelanjutan_mkp->save();
            }
        }
    }

    function senarai_kelulusan_pelanjutan_mkp_ppp(Request $request){
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
            $data = DB::select(DB::raw("
            SELECT spk__imediator.id AS id,
            ref__states.state_description AS state_description,
            ref__daerahs.daerah_description AS daerah_description,
            users__profile.user_fullname AS mkp_pemohon_nama,
            users__profile.no_ic AS mkp_pemohon_ic,
            users__profile.no_phone AS mkp_pemohon_no_phone,
            users.user_email AS mkp_pemohon_email,
            DATE_FORMAT(spk__imediator.mkp_tarikh_dilantik,'%d/%m/%Y') AS mkp_tarikh_dilantik,
            DATE_FORMAT(DATE_ADD(spk__imediator.mkp_tarikh_dilantik, INTERVAL 548 DAY),'%d/%m/%Y') AS tarikh_kemaskini,
            DATE_FORMAT(DATE_ADD(spk__imediator.mkp_tarikh_dilantik, INTERVAL 731 DAY),'%d/%m/%Y') AS tarikh_tamat,
            (case when a.count_kes >= 2 AND b.count_aktiviti >= 2 AND c.count_latihan >= 2 then 'Layak' else 'Tidak Layak' end)AS status_kelayakan,
            ref__status_spk_imediator.status_description AS status_pelanjutan,
            spk__imediator.status_pelanjutan AS status
            FROM spk__imediator
            LEFT JOIN users ON users.user_id = spk__imediator.user_id
            LEFT JOIN users__profile ON users__profile.user_id = spk__imediator.user_id
            LEFT JOIN ref__states ON ref__states.state_id = users__profile.state_id
            LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = users__profile.daerah_id
            LEFT JOIN ref__status_spk_imediator ON ref__status_spk_imediator.id = spk__imediator.status_pelanjutan
            LEFT JOIN (
                            SELECT spk__imediator_mediasi.spk_imediator_id, count(*) AS count_kes
                            FROM spk__imediator_mediasi
                            GROUP BY spk__imediator_mediasi.spk_imediator_id
            ) a ON a.spk_imediator_id = spk__imediator.id
            LEFT JOIN (
                            SELECT spk__imediator_keaktifan_aktiviti.spk_imediator_id, count(*) AS count_aktiviti
                            FROM spk__imediator_keaktifan_aktiviti
                            GROUP BY spk__imediator_keaktifan_aktiviti.spk_imediator_id
            ) b ON b.spk_imediator_id = spk__imediator.id
            LEFT JOIN (
                            SELECT spk__imediator_keaktifan_latihan.spk_imediator_id, count(*) AS count_latihan
                            FROM spk__imediator_keaktifan_latihan
                            GROUP BY spk__imediator_keaktifan_latihan.spk_imediator_id
            ) c ON c.spk_imediator_id = spk__imediator.id
            WHERE spk__imediator.status_pelanjutan = 10
                    "));
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
            return view('rt-sm23.senarai-kelulusan-pelanjutan-mkp-ppp', compact('roles_menu','state'));
        }
    }

    function kelulusan_pelanjuatan_mkp_ppp(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $bandar             = RefBandar::where('status', '=', true)->get();
            $parlimen           = RefParlimen::where('status', '=', true)->get();
            $dun                = RefDUN::where('status', '=', true)->get();
            $pbt                = RefPBT::where('status', '=', true)->get();
            $krt                = KRT_Profile::where('krt_status', '=', true)->get();
            $kaum               = RefKaum::where('status', '=', true)->get();
            $jantina            = RefJantina::where('status', '=', true)->get();
            $pendidikan         = RefPendidikan::where('pendidikan_status', '=', true)->get();
            $mkp_kategori       = Ref_SPK_MKP_Kategori::where('status', '=', true)->get();
            $mkp_tahap          = Ref_SPK_MKP_Tahap::where('status', '=', true)->get();
            $kategori_kursus    = Ref_SPK_MKP_Kategori_Kursus::where('status', '=', true)->get();
            $peringkat_kursus   = Ref_SPK_MKP_Peringkat_Kursus::where('status', '=', true)->get();
            $mkp                = DB::table('spk__imediator')
                                ->select('spk__imediator.id',
                                    'spk__imediator.hasRT',
                                    'users__profile.state_id AS mkp_pemohon_state_id',
                                    'users__profile.daerah_id AS mkp_pemohon_daerah_id',
                                    'spk__imediator.krt_profile_id',
                                    'spk__imediator.mkp_file_avatar',
                                    'users__profile.user_fullname AS mkp_pemohon_nama',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_pemohon_tarikh_lahir,'%d/%m/%Y') AS mkp_pemohon_tarikh_lahir"),
                                    'spk__imediator.mkp_pemohon_dun_id',
                                    'spk__imediator.mkp_pemohon_mukim_id',
                                    'spk__imediator.mkp_pemohon_kaum_id',
                                    'spk__imediator.mkp_pemohon_alamat',
                                    'users__profile.no_phone AS mkp_pemohon_no_phone',
                                    'spk__imediator.mkp_pemohon_kategori_id',
                                    'spk__imediator.mkp_pemohon_akademik',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_tarikh_dilantik,'%d/%m/%Y') AS mkp_tarikh_dilantik"),
                                    'users__profile.no_ic AS mkp_pemohon_ic',
                                    'users__profile.state_id AS mkp_pemohon_state_id',
                                    'spk__imediator.mkp_pemohon_parlimen_id',
                                    'spk__imediator.mkp_pemohon_pbt_id',
                                    'spk__imediator.mkp_pemohon_jantina_id',
                                    'users.user_email AS mkp_pemohon_email',
                                    'spk__imediator.mkp_pemohon_alamat_p',
                                    'spk__imediator.mkp_pemohon_no_phone_p',
                                    'spk__imediator.mkp_pemohon_tahap_id',
                                    'spk__imediator.mkp_pemohon_khusus',
                                    'spk__imediator.status_pelanjutan')
                                ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                                ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                                ->leftJoin('ref__states','ref__states.state_id','=','users.state_id')
                                ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users.daerah_id')
                                ->leftJoin('krt__profile','krt__profile.id','=','spk__imediator.krt_profile_id')
                                ->where('spk__imediator.id', '=', $id)  
                                ->limit(1)
                                ->first();
            return view('rt-sm23.kelulusan-pelanjuatan-mkp-ppp', 
            compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'kaum', 'jantina', 'pendidikan', 'mkp_kategori', 'mkp_tahap', 'kategori_kursus', 'peringkat_kursus', 'mkp'));
        }
    }

    function post_kelulusan_pelanjutan_mkp_ppp(Request $request){
        $action = $request->post_kelulusan_pelanjutan_mkp_ppp;
        $app_id = $request->kpmpp_spk_imediator_id;
        
        
        $rules = array(
            'kpmpp_imediator_status'            => 'required',
            'kpmpp_dilulus_note'                => 'required',
        );

        $messages = [
            'kpmpp_imediator_status.required'   => 'Ruangan Status dipilih',
            'kpmpp_dilulus_note.required'       => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $kelulusan_pelanjutan_mkp                    = SPK_imediator::where($where)->first();
                $kelulusan_pelanjutan_mkp->status_pelanjutan = $request->kpmpp_imediator_status;
                $kelulusan_pelanjutan_mkp->dilulus_by        = Auth::user()->user_id;
                $kelulusan_pelanjutan_mkp->dilulus_date      = date('Y-m-d H:i:s');
                $kelulusan_pelanjutan_mkp->dilulus_note      = $request->kpmpp_dilulus_note;
                $kelulusan_pelanjutan_mkp->save();
            }
        }
    }

    function senarai_lantikan_pelanjutan_mkp_kp(Request $request){
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
            $data = DB::select(DB::raw("
            SELECT spk__imediator.id AS id,
            ref__states.state_description AS state_description,
            ref__daerahs.daerah_description AS daerah_description,
            users__profile.user_fullname AS mkp_pemohon_nama,
            users__profile.no_ic AS mkp_pemohon_ic,
            users__profile.no_phone AS mkp_pemohon_no_phone,
            users.user_email AS mkp_pemohon_email,
            DATE_FORMAT(spk__imediator.mkp_tarikh_dilantik,'%d/%m/%Y') AS mkp_tarikh_dilantik,
            DATE_FORMAT(DATE_ADD(spk__imediator.mkp_tarikh_dilantik, INTERVAL 548 DAY),'%d/%m/%Y') AS tarikh_kemaskini,
            DATE_FORMAT(DATE_ADD(spk__imediator.mkp_tarikh_dilantik, INTERVAL 731 DAY),'%d/%m/%Y') AS tarikh_tamat,
            (case when a.count_kes >= 2 AND b.count_aktiviti >= 2 AND c.count_latihan >= 2 then 'Layak' else 'Tidak Layak' end)AS status_kelayakan,
            ref__status_spk_imediator.status_description AS status_pelanjutan,
            spk__imediator.status_pelanjutan AS status
            FROM spk__imediator
            LEFT JOIN users ON users.user_id = spk__imediator.user_id
            LEFT JOIN users__profile ON users__profile.user_id = spk__imediator.user_id
            LEFT JOIN ref__states ON ref__states.state_id = users__profile.state_id
            LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = users__profile.daerah_id
            LEFT JOIN ref__status_spk_imediator ON ref__status_spk_imediator.id = spk__imediator.status_pelanjutan
            LEFT JOIN (
                            SELECT spk__imediator_mediasi.spk_imediator_id, count(*) AS count_kes
                            FROM spk__imediator_mediasi
                            GROUP BY spk__imediator_mediasi.spk_imediator_id
            ) a ON a.spk_imediator_id = spk__imediator.id
            LEFT JOIN (
                            SELECT spk__imediator_keaktifan_aktiviti.spk_imediator_id, count(*) AS count_aktiviti
                            FROM spk__imediator_keaktifan_aktiviti
                            GROUP BY spk__imediator_keaktifan_aktiviti.spk_imediator_id
            ) b ON b.spk_imediator_id = spk__imediator.id
            LEFT JOIN (
                            SELECT spk__imediator_keaktifan_latihan.spk_imediator_id, count(*) AS count_latihan
                            FROM spk__imediator_keaktifan_latihan
                            GROUP BY spk__imediator_keaktifan_latihan.spk_imediator_id
            ) c ON c.spk_imediator_id = spk__imediator.id
            WHERE spk__imediator.status_pelanjutan = 12
                    "));
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
            return view('rt-sm23.senarai-lantikan-pelanjutan-mkp-kp', compact('roles_menu','state'));
        }
    }

    function lantikan_pelanjuatan_mkp_kp(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $bandar             = RefBandar::where('status', '=', true)->get();
            $parlimen           = RefParlimen::where('status', '=', true)->get();
            $dun                = RefDUN::where('status', '=', true)->get();
            $pbt                = RefPBT::where('status', '=', true)->get();
            $krt                = KRT_Profile::where('krt_status', '=', true)->get();
            $kaum               = RefKaum::where('status', '=', true)->get();
            $jantina            = RefJantina::where('status', '=', true)->get();
            $pendidikan         = RefPendidikan::where('pendidikan_status', '=', true)->get();
            $mkp_kategori       = Ref_SPK_MKP_Kategori::where('status', '=', true)->get();
            $mkp_tahap          = Ref_SPK_MKP_Tahap::where('status', '=', true)->get();
            $kategori_kursus    = Ref_SPK_MKP_Kategori_Kursus::where('status', '=', true)->get();
            $peringkat_kursus   = Ref_SPK_MKP_Peringkat_Kursus::where('status', '=', true)->get();
            $mkp                = DB::table('spk__imediator')
                                ->select('spk__imediator.id',
                                    'spk__imediator.hasRT',
                                    'users__profile.state_id AS mkp_pemohon_state_id',
                                    'users__profile.daerah_id AS mkp_pemohon_daerah_id',
                                    'spk__imediator.krt_profile_id',
                                    'spk__imediator.mkp_file_avatar',
                                    'users__profile.user_fullname AS mkp_pemohon_nama',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_pemohon_tarikh_lahir,'%d/%m/%Y') AS mkp_pemohon_tarikh_lahir"),
                                    'spk__imediator.mkp_pemohon_dun_id',
                                    'spk__imediator.mkp_pemohon_mukim_id',
                                    'spk__imediator.mkp_pemohon_kaum_id',
                                    'spk__imediator.mkp_pemohon_alamat',
                                    'users__profile.no_phone AS mkp_pemohon_no_phone',
                                    'spk__imediator.mkp_pemohon_kategori_id',
                                    'spk__imediator.mkp_pemohon_akademik',
                                    DB::raw(" DATE_FORMAT(spk__imediator.mkp_tarikh_dilantik,'%d/%m/%Y') AS mkp_tarikh_dilantik"),
                                    'users__profile.no_ic AS mkp_pemohon_ic',
                                    'users__profile.state_id AS mkp_pemohon_state_id',
                                    'spk__imediator.mkp_pemohon_parlimen_id',
                                    'spk__imediator.mkp_pemohon_pbt_id',
                                    'spk__imediator.mkp_pemohon_jantina_id',
                                    'users.user_email AS mkp_pemohon_email',
                                    'spk__imediator.mkp_pemohon_alamat_p',
                                    'spk__imediator.mkp_pemohon_no_phone_p',
                                    'spk__imediator.mkp_pemohon_tahap_id',
                                    'spk__imediator.mkp_pemohon_khusus',
                                    'spk__imediator.status_pelanjutan')
                                ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                                ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                                ->leftJoin('ref__states','ref__states.state_id','=','users.state_id')
                                ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users.daerah_id')
                                ->leftJoin('krt__profile','krt__profile.id','=','spk__imediator.krt_profile_id')
                                ->where('spk__imediator.id', '=', $id)  
                                ->limit(1)
                                ->first();
            return view('rt-sm23.lantikan-pelanjuatan-mkp-kp', 
            compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'kaum', 'jantina', 'pendidikan', 'mkp_kategori', 'mkp_tahap', 'kategori_kursus', 'peringkat_kursus', 'mkp'));
        }
    }

    function post_lantikan_pelanjutan_mkp_kp(Request $request){
        $action = $request->post_lantikan_pelanjutan_mkp_kp;
        $app_id = $request->lpmkp_spk_imediator_id;
        $status = $request->lpmkp_imediator_status;
        
        $rules = array(
            'lpmkp_imediator_status'            => 'required',
            'lpmkp_dilantik_note'               => 'required',
        );

        $messages = [
            'lpmkp_imediator_status.required'   => 'Ruangan Status dipilih',
            'lpmkp_dilantik_note.required'      => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $lantikan_pelanjutan_mkp                    = SPK_imediator::where($where)->first();
                $lantikan_pelanjutan_mkp->status_pelanjutan = $request->lpmkp_imediator_status;
                $lantikan_pelanjutan_mkp->dilantik_by       = Auth::user()->user_id;
                $lantikan_pelanjutan_mkp->dilantik_date     = date('Y-m-d H:i:s');
                $lantikan_pelanjutan_mkp->dilantik_note     = $request->lpmkp_dilantik_note;
                $lantikan_pelanjutan_mkp->save();

                if($status == '1'){
                    $where1 = array('id' => $app_id);
                    $mediator_profile                       = SPK_imediator::where($where1)->first();
                    $mediator_profile->status               = 1;
                    $mediator_profile->status_pelanjutan    = null;
                    $mediator_profile->save();

                    $mediator_keaktifan                     = SPK_imediator_keaktifan::where('spk_imediator_id', '=', $where1)->first();
                    $mediator_keaktifan->status             = null;
                    $mediator_keaktifan->save();
                }
            }
        }
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
    function permohonan_mkp_admin(){
        return view('rt-sm23.permohonan-mkp-admin');
    }

    function permohonan_mkp_admin_1(){
        return view('rt-sm23.permohonan-mkp-admin-1');
    }

    function sokongan_mkp_admin_ppd(){
        return view('rt-sm23.sokongan-mkp-admin-ppd');
    }

    function sokongan_mkp_admin_ppd_1(){
        return view('rt-sm23.sokongan-mkp-admin-ppd-1');
    }

    function sokongan_mkp_admin_ppmk(){
        return view('rt-sm23.sokongan-mkp-admin-ppmk');
    }

    function sokongan_mkp_admin_ppmk_1(){
        return view('rt-sm23.sokongan-mkp-admin-ppmk-1');
    }

    function pengesahan_mkp_admin_ppn(){
        return view('rt-sm23.pengesahan-mkp-admin-ppn');
    }

    function pengesahan_mkp_admin_ppn_1(){
        return view('rt-sm23.pengesahan-mkp-admin-ppn-1');
    }

    function menyemak_mkp_admin_hq(){
        return view('rt-sm23.menyemak-mkp-admin-hq');
    }

    function menyemak_mkp_admin_hq_1(){
        return view('rt-sm23.menyemak-mkp-admin-hq-1');
    }

    function kelulusan_mkp_admin_hq(){
        return view('rt-sm23.kelulusan-mkp-admin-hq');
    }

    function kelulusan_mkp_admin_hq_1(){
        return view('rt-sm23.kelulusan-mkp-admin-hq-1');
    }

    function senarai_mkp_admin(){
        return view('rt-sm23.senarai-mkp-admin');
    }

    function statistik_mkp_admin(){
        return view('rt-sm23.statistik-mkp-admin');
    }
}
