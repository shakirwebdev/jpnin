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
use App\Ref_Agama;
use App\User;
use App\UserProfile;
use App\SRS_Ahli_Peronda;
use App\KRT_Profile;
use App\SRS_Profile;
use App\SRS_Ahli_Peronda_Pendidikan;
use App\SRS_Ahli_Peronda_Pekerjaan;

use DataTables;
use DB;

class RT_SM13Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function senarai_pendaftaran_ahli_peronda_srs(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('srs__ahli_peronda')
                        ->select('srs__ahli_peronda.id',
                                'srs__ahli_peronda.srs_profile_id',
                                'srs__profile.srs_name AS nama_srs',
                                'srs__ahli_peronda.peronda_nama AS ahli_peronda_nama',
                                'srs__ahli_peronda.peronda_ic AS ahli_peronda_ic',
                                DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lahir,'%d/%m/%Y') AS peronda_tarikh_lahir"),
                                DB::raw(" TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) AS ahli_peronda_umur"),
								DB::raw("REPLACE(REPLACE(srs__ahli_peronda.peronda_alamat,'\n',''), '\r', '') AS ahli_peronda_alamat"),
                                //'srs__ahli_peronda.peronda_alamat AS ahli_peronda_alamat',
                                'srs__ahli_peronda.peronda_kaum AS ahli_peronda_kaum',
                                'ref__jantina.jantina_description AS ahli_peronda_jantina',
                                'srs__ahli_peronda.peronda_warganegara AS ahli_peronda_warganegara',
                                'srs__ahli_peronda.peronda_phone AS ahli_peronda_phone',
                                'ref__status_srs_ahli_peronda.status_description AS ahli_peronda_status',
                                'srs__ahli_peronda.peronda_status AS status')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__ahli_peronda.srs_profile_id')
                        ->leftJoin('ref__status_srs_ahli_peronda','ref__status_srs_ahli_peronda.id','=','srs__ahli_peronda.peronda_status')
                        ->leftJoin('ref__jantina','ref__jantina.id','=','srs__ahli_peronda.peronda_jantina')
                        ->whereIN('srs__ahli_peronda.peronda_status', [3,4,6])
                        ->where('srs__ahli_peronda.srs_profile_id', '=', Auth::user()->srs_id)  
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
            return view('rt-sm13.senarai-pendaftaran-ahli-peronda-srs',compact('roles_menu'));
        }
    }

    function post_daftar_ahli_peronda_srs(Request $request){
        
        $action = $request->daftar_ahli_peronda;
        $app_id = $request->krt_id;
        
        $rules = array(
           
        );

        $messages = [
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm13.senarai_pendaftaran_ahli_peronda_srs',$app_id))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'add') {
                $ahli_peronda_srs = new SRS_Ahli_Peronda;
                $ahli_peronda_srs->krt_profile_id       = Auth::user()->krt_id;
                $ahli_peronda_srs->srs_profile_id       = Auth::user()->srs_id;
                $ahli_peronda_srs->peronda_status       = 3;
                $ahli_peronda_srs->save();
            }
           
            return Redirect::to(route('rt-sm13.pendaftaran_ahli_peronda_srs',$ahli_peronda_srs->id));
        }

    }

    function pendaftaran_ahli_peronda_srs(Request $request, $id){
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
            $srs_profile        = SRS_Profile::where('srs_status', '=', true)->get();
            $ref_jantina        = RefJantina::where('status', '=', true)->get();
            $ref_kaum           = RefKaum::where('status', '=', true)->get();
            $ref_agama          = Ref_Agama::where('status', '=', true)->get();
            $srs_ahli_peronda   = DB::table('srs__ahli_peronda')
                                    ->select('srs__ahli_peronda.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt', 
                                            'ref__daerahs.daerah_description AS daerah_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__duns.dun_description AS dun_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'srs__ahli_peronda.srs_profile_id AS srs_profile_id',
                                            'srs__ahli_peronda.file_gambar_profile AS file_gambar_profile',
                                            'srs__ahli_peronda.peronda_nama AS peronda_nama',
                                            'srs__ahli_peronda.peronda_ic AS peronda_ic',
                                            DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lahir,'%d/%m/%Y') AS peronda_tarikh_lahir"),
                                            'srs__ahli_peronda.peronda_kaum AS peronda_kaum',
                                            'srs__ahli_peronda.peronda_jantina AS peronda_jantina',
                                            'srs__ahli_peronda.peronda_warganegara AS peronda_warganegara',
                                            'srs__ahli_peronda.peronda_agama AS peronda_agama',
                                            'srs__ahli_peronda.peronda_phone AS peronda_phone',
											DB::raw("REPLACE(REPLACE(srs__ahli_peronda.peronda_alamat,'\n',''), '\r', '') AS peronda_alamat"),
                                            //'srs__ahli_peronda.peronda_alamat AS peronda_alamat',
                                            'srs__ahli_peronda.peronda_poskod AS peronda_poskod',
                                            DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lantikan,'%d/%m/%Y') AS peronda_tarikh_lantikan"),
                                            'srs__ahli_peronda.peronda_status AS status',
                                            'ref__status_srs_ahli_peronda.status_description AS status_description',
                                            'srs__ahli_peronda.disemak_note AS disemak_note')
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__ahli_peronda.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_srs_ahli_peronda','ref__status_srs_ahli_peronda.id','=','srs__ahli_peronda.peronda_status')
                                    ->where('srs__ahli_peronda.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm13.pendaftaran-ahli-peronda-srs', 
            compact('roles_menu','srs_profile','ref_jantina','ref_kaum','srs_ahli_peronda', 'ref_agama'));
        }
    }

    function post_add_gambar_peronda_srs(Request $request){
        $action = $request->post_add_gambar_peronda_srs;
        $app_id = $request->magps_ahli_peronda_id;
        
        $rules = array(
            'magps_file_gambar_profile'                => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:5000'
        );

        $messages = [
            'magps_file_gambar_profile.required'      => 'Ruangan Fail Mesti Dipilih',
            'magps_file_gambar_profile.mimes'         => 'Fail Mesti Dipilih Dalam Format jpeg,png,jpg,gif,svg,pdf',
            'magps_file_gambar_profile.max'           => 'Fail mesti dalam sive 5000KB',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            $fileName = $request->magps_file_gambar_profile->getClientOriginalName();
            $request->magps_file_gambar_profile->storeAs('public/ahli_peronda_srs',$fileName);
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $gambar_peronda_srs                             = SRS_Ahli_Peronda::where($where)->first();
                $gambar_peronda_srs->file_gambar_profile        = $fileName;
                $gambar_peronda_srs->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function get_senarai_pendidikan_table(Request $request, $id){
        return DataTables()->of(
            DB::select(DB::raw("
                SELECT
                ref__pendidikan.id, ref__pendidikan.pendidikan_description, ref__pendidikan.pendidikan_status, srs__ahli_peronda_pendidikan.id AS srs_ahli_peronda_pendidikanID, srs__ahli_peronda_pendidikan.srs_profileID, srs__ahli_peronda_pendidikan.ref_pendidikanID
                FROM
                ref__pendidikan
                LEFT JOIN srs__ahli_peronda_pendidikan ON srs__ahli_peronda_pendidikan.ref_pendidikanID = ref__pendidikan.id
                AND srs__ahli_peronda_pendidikan.srs_profileID = '" . $id . "'
                ORDER BY ref__pendidikan.id + 0 ASC
            "))
        )->make();
    }

    function add_pendidikan(Request $request){
        $paps_srs_ahli_peronda_id = $request->paps_srs_ahli_peronda_id;
        $srs_ahli_peronda_pendidikanID = $request->srs_ahli_peronda_pendidikanID;
        
        $pendidikan = new SRS_Ahli_Peronda_Pendidikan;
        $pendidikan->srs_profileID         = $paps_srs_ahli_peronda_id;
        $pendidikan->ref_pendidikanID      = $request->srs_ahli_peronda_pendidikanID;
        $pendidikan->save();

    }

    function delete_pendidikan(Request $request){
        $paps_srs_ahli_peronda_id       = $request->paps_srs_ahli_peronda_id;
        $srs_ahli_peronda_pendidikanID  = $request->srs_ahli_peronda_pendidikanID;

        $data = DB::table('srs__ahli_peronda_pendidikan')
                ->where('srs_profileID', '=', $paps_srs_ahli_peronda_id)
                ->where('ref_pendidikanID', '=', $srs_ahli_peronda_pendidikanID)
                ->delete();
        
    }

    function post_pendaftaran_ahli_peronda_srs(Request $request){
        $action = $request->post_pendaftaran_ahli_peronda_srs;
        $app_id = $request->paps_srs_ahli_peronda_id;
        
        
        $rules = array(
            'paps_peronda_nama'                         => 'required',
            'paps_peronda_tarikh_lahir'                 => 'required',
            'paps_peronda_kaum'                         => 'required',
            'paps_peronda_jantina'                      => 'required',
            'paps_peronda_warganegara'                  => 'required',
            'paps_peronda_agama'                        => 'required',
            'paps_peronda_ic'                           => 'required',
            'paps_peronda_alamat'                       => 'required',
            'paps_peronda_poskod'                       => 'required',
            'paps_peronda_phone'                        => 'required',
            'paps_peronda_tarikh_lantikan'              => 'required',
        );

        $messages = [
            'paps_peronda_nama.required'                => 'Ruangan Nama Penuh mesti diisi',
            'paps_peronda_tarikh_lahir.required'        => 'Ruangan Tarikh Lahir mesti diisi',
            'paps_peronda_kaum.required'                => 'Ruangan Kaum mesti dipilih',
            'paps_peronda_jantina.required'             => 'Ruangan Jantina mesti dipilih',
            'paps_peronda_warganegara.required'         => 'Ruangan Warganegara mesti diisi',
            'paps_peronda_agama.required'               => 'Ruangan Agama mesti diisi',
            'paps_peronda_ic.required'                  => 'Ruangan No Kad Pengenalan mesti diisi',
            'paps_peronda_alamat.required'              => 'Ruangan Alamat mesti diisi',
            'paps_peronda_poskod.required'              => 'Ruangan Poskod mesti diisi',
            'paps_peronda_phone.required'               => 'Ruangan Phone mesti diisi',
            'paps_peronda_tarikh_lantikan.required'     => 'Ruangan Tarikh Lantikan SRS mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $carbon_obj     = Carbon::createFromFormat('d/m/Y', $request->paps_peronda_tarikh_lahir)->format('Y-m-d');
                $carbon_obj_1   = Carbon::createFromFormat('d/m/Y', $request->paps_peronda_tarikh_lantikan)->format('Y-m-d');
                $daftar_ahli_peronda_srs                            = SRS_Ahli_Peronda::where($where)->first();
                $daftar_ahli_peronda_srs->peronda_nama              = $request->paps_peronda_nama;
                $daftar_ahli_peronda_srs->peronda_tarikh_lahir      = $carbon_obj;
                $daftar_ahli_peronda_srs->peronda_kaum              = $request->paps_peronda_kaum;
                $daftar_ahli_peronda_srs->peronda_jantina           = $request->paps_peronda_jantina;
                $daftar_ahli_peronda_srs->peronda_warganegara       = $request->paps_peronda_warganegara;
                $daftar_ahli_peronda_srs->peronda_agama             = $request->paps_peronda_agama;
                $daftar_ahli_peronda_srs->peronda_ic                = $request->paps_peronda_ic;
                $daftar_ahli_peronda_srs->peronda_alamat            = $request->paps_peronda_alamat;
                $daftar_ahli_peronda_srs->peronda_poskod            = $request->paps_peronda_poskod;
                $daftar_ahli_peronda_srs->peronda_phone             = $request->paps_peronda_phone;
                $daftar_ahli_peronda_srs->peronda_tarikh_lantikan   = $carbon_obj_1;
                $daftar_ahli_peronda_srs->save();
            }
        }
    }

    function pendaftaran_ahli_peronda_srs_1(Request $request, $id){
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
            $srs_ahli_peronda   = DB::table('srs__ahli_peronda')
                                    ->select('srs__ahli_peronda.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt', 
                                            'ref__daerahs.daerah_description AS daerah_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__duns.dun_description AS dun_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'srs__ahli_peronda.srs_profile_id AS srs_profile_id',
                                            'srs__ahli_peronda.peronda_nama AS peronda_nama',
                                            'srs__ahli_peronda.peronda_ic AS peronda_ic',
                                            DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lahir,'%d/%m/%Y') AS peronda_tarikh_lahir"),
                                            'srs__ahli_peronda.peronda_kaum AS peronda_kaum',
                                            'srs__ahli_peronda.peronda_jantina AS peronda_jantina',
                                            'srs__ahli_peronda.peronda_warganegara AS peronda_warganegara',
                                            'srs__ahli_peronda.peronda_phone AS peronda_phone',
											DB::raw("REPLACE(REPLACE(srs__ahli_peronda.peronda_alamat,'\n',''), '\r', '') AS peronda_alamat"),
                                            //'srs__ahli_peronda.peronda_alamat AS peronda_alamat',
                                            'srs__ahli_peronda.peronda_poskod AS peronda_poskod',
                                            'srs__ahli_peronda.peronda_status AS status',
                                            'ref__status_srs_ahli_peronda.status_description AS status_description',
                                            'srs__ahli_peronda.disemak_note AS disemak_note')
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__ahli_peronda.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_srs_ahli_peronda','ref__status_srs_ahli_peronda.id','=','srs__ahli_peronda.peronda_status')
                                    ->where('srs__ahli_peronda.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm13.pendaftaran-ahli-peronda-srs-1', compact('roles_menu','srs_ahli_peronda'));
        }
    }

    function get_senarai_pekerjaan_table(Request $request, $id){
        return DataTables()->of(
            DB::select(DB::raw("
                SELECT
                ref__profession.id, ref__profession.profession_description, ref__profession.status, srs__ahli_peronda_pekerjaan.id AS srs_ahli_peronda_pekerjaanID, srs__ahli_peronda_pekerjaan.srs_profile_id, srs__ahli_peronda_pekerjaan.ref_profession_id
                FROM
                ref__profession
                LEFT JOIN srs__ahli_peronda_pekerjaan ON srs__ahli_peronda_pekerjaan.ref_profession_id = ref__profession.id
                AND srs__ahli_peronda_pekerjaan.srs_profile_id = '" . $id . "'
                ORDER BY ref__profession.id + 0 ASC
            "))
        )->make();
    }

    function add_pekerjaan(Request $request){
        $paps1_srs_ahli_peronda_id = $request->paps1_srs_ahli_peronda_id;
        $srs_ahli_peronda_pekerjaanID = $request->srs_ahli_peronda_pekerjaanID;
        
        $pendidikan = new SRS_Ahli_Peronda_Pekerjaan;
        $pendidikan->srs_profile_id         = $paps1_srs_ahli_peronda_id;
        $pendidikan->ref_profession_id      = $request->srs_ahli_peronda_pekerjaanID;
        $pendidikan->save();

    }

    function delete_pekerjaan(Request $request){
        $paps1_srs_ahli_peronda_id       = $request->paps1_srs_ahli_peronda_id;
        $srs_ahli_peronda_pekerjaanID  = $request->srs_ahli_peronda_pekerjaanID;

        $data = DB::table('srs__ahli_peronda_pekerjaan')
                ->where('srs_profile_id', '=', $paps1_srs_ahli_peronda_id)
                ->where('ref_profession_id', '=', $srs_ahli_peronda_pekerjaanID)
                ->delete();
        
    }

    function post_pendaftaran_ahli_peronda_srs_1(Request $request){
        $action = $request->post_pendaftaran_ahli_peronda_srs_1;
        $app_id = $request->paps2_srs_ahli_peronda_id;
        
        
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
                $daftar_ahli_peronda_srs                            = SRS_Ahli_Peronda::where($where)->first();
                $daftar_ahli_peronda_srs->peronda_status            = 4;
                $daftar_ahli_peronda_srs->direkod_by                = Auth::user()->user_id;
                $daftar_ahli_peronda_srs->direkod_date              = date('Y-m-d H:i:s');
                $daftar_ahli_peronda_srs->save();
            }
        }
    }

    function semak_pendaftaran_ahli_peronda_srs_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('srs__ahli_peronda')
                        ->select('srs__ahli_peronda.id',
                                'srs__ahli_peronda.srs_profile_id',
                                'krt__profile.krt_nama AS nama_krt',
                                'srs__profile.srs_name AS nama_srs',
                                'srs__ahli_peronda.peronda_nama AS ahli_peronda_nama',
                                'srs__ahli_peronda.peronda_ic AS ahli_peronda_ic',
                                DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lahir,'%d/%m/%Y') AS peronda_tarikh_lahir"),
                                DB::raw(" TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) AS ahli_peronda_umur"),
								DB::raw("REPLACE(REPLACE(srs__ahli_peronda.peronda_alamat,'\n',''), '\r', '') AS ahli_peronda_alamat"),
                                //'srs__ahli_peronda.peronda_alamat AS ahli_peronda_alamat',
                                'srs__ahli_peronda.peronda_kaum AS ahli_peronda_kaum',
                                'ref__jantina.jantina_description AS ahli_peronda_jantina',
                                'srs__ahli_peronda.peronda_warganegara AS ahli_peronda_warganegara',
                                'srs__ahli_peronda.peronda_phone AS ahli_peronda_phone',
                                'ref__status_srs_ahli_peronda.status_description AS ahli_peronda_status',
                                'srs__ahli_peronda.peronda_status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__ahli_peronda.krt_profile_id')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__ahli_peronda.srs_profile_id')
                        ->leftJoin('ref__status_srs_ahli_peronda','ref__status_srs_ahli_peronda.id','=','srs__ahli_peronda.peronda_status')
                        ->leftJoin('ref__jantina','ref__jantina.id','=','srs__ahli_peronda.peronda_jantina')
                        ->whereIN('srs__ahli_peronda.peronda_status', [4])
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
            $krt_profile    = KRT_Profile::where('krt_status', '=', 1)
                            ->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)
                            ->where('krt__profile.krt_status', '=',  true) 
                            ->get();
            return view('rt-sm13.semak-pendaftaran-ahli-peronda-srs-ppd', compact('roles_menu','krt_profile'));
        }
    }

    function semak_pendaftaran_ahli_peronda_srs_ppd_1(Request $request, $id){
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
            $srs_profile        = SRS_Profile::where('srs_status', '=', true)->get();
            $ref_jantina        = RefJantina::where('status', '=', true)->get();
            $ref_kaum           = RefKaum::where('status', '=', true)->get();
            $ref_agama          = Ref_Agama::where('status', '=', true)->get();
            $srs_ahli_peronda   = DB::table('srs__ahli_peronda')
                                    ->select('srs__ahli_peronda.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt', 
                                            'ref__daerahs.daerah_description AS daerah_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__duns.dun_description AS dun_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'srs__ahli_peronda.srs_profile_id AS srs_profile_id',
                                            'srs__ahli_peronda.file_gambar_profile AS file_gambar_profile',
                                            'srs__ahli_peronda.peronda_nama AS peronda_nama',
                                            'srs__ahli_peronda.peronda_ic AS peronda_ic',
                                            DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lahir,'%d/%m/%Y') AS peronda_tarikh_lahir"),
                                            'srs__ahli_peronda.peronda_kaum AS peronda_kaum',
                                            'srs__ahli_peronda.peronda_jantina AS peronda_jantina',
                                            'srs__ahli_peronda.peronda_warganegara AS peronda_warganegara',
                                            'srs__ahli_peronda.peronda_agama AS peronda_agama',
                                            'srs__ahli_peronda.peronda_phone AS peronda_phone',
											DB::raw("REPLACE(REPLACE(srs__ahli_peronda.peronda_alamat,'\n',''), '\r', '') AS peronda_alamat"),
                                            //'srs__ahli_peronda.peronda_alamat AS peronda_alamat',
                                            'srs__ahli_peronda.peronda_poskod AS peronda_poskod',
                                            DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lantikan,'%d/%m/%Y') AS peronda_tarikh_lantikan"))
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__ahli_peronda.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('srs__ahli_peronda.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm13.semak-pendaftaran-ahli-peronda-srs-ppd-1', 
            compact('roles_menu','srs_profile','ref_jantina','ref_kaum','srs_ahli_peronda', 'ref_agama'));
        }
    }

    function semak_pendaftaran_ahli_peronda_srs_ppd_2(Request $request, $id){
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
            $srs_ahli_peronda   = DB::table('srs__ahli_peronda')
                                    ->select('srs__ahli_peronda.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt', 
                                            'ref__daerahs.daerah_description AS daerah_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__duns.dun_description AS dun_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'srs__ahli_peronda.srs_profile_id AS srs_profile_id',
                                            'srs__ahli_peronda.peronda_nama AS peronda_nama',
                                            'srs__ahli_peronda.peronda_ic AS peronda_ic',
                                            DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lahir,'%d/%m/%Y') AS peronda_tarikh_lahir"),
                                            'srs__ahli_peronda.peronda_kaum AS peronda_kaum',
                                            'srs__ahli_peronda.peronda_jantina AS peronda_jantina',
                                            'srs__ahli_peronda.peronda_warganegara AS peronda_warganegara',
                                            'srs__ahli_peronda.peronda_phone AS peronda_phone',
											DB::raw("REPLACE(REPLACE(srs__ahli_peronda.peronda_alamat,'\n',''), '\r', '') AS peronda_alamat"),
                                            //'srs__ahli_peronda.peronda_alamat AS peronda_alamat',
                                            'srs__ahli_peronda.peronda_poskod AS peronda_poskod')
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__ahli_peronda.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('srs__ahli_peronda.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm13.semak-pendaftaran-ahli-peronda-srs-ppd-2', compact('roles_menu','srs_ahli_peronda'));
        }
    }

    function post_semak_pendaftaran_ahli_peronda(Request $request){
        $action = $request->post_semak_pendaftaran_ahli_peronda;
        $app_id = $request->spapsp1_ahli_peronda_id;
        
        
        $rules = array(
            'spapsp1_peronda_status'            => 'required',
            'spapsp1_disemak_note'              => 'required',
        );

        $messages = [
            'spapsp1_peronda_status.required'   => 'Ruangan Status dipilih',
            'spapsp1_disemak_note.required'     => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $semak_ahli_peronda_srs                       = SRS_Ahli_Peronda::where($where)->first();
                $semak_ahli_peronda_srs->peronda_status       = $request->spapsp1_peronda_status;
                $semak_ahli_peronda_srs->disemak_by           = Auth::user()->user_id;
                $semak_ahli_peronda_srs->disemak_date         = date('Y-m-d H:i:s');
                $semak_ahli_peronda_srs->disemak_note         = $request->spapsp1_disemak_note;
                $semak_ahli_peronda_srs->save();
            }
        }
    }

    function senarai_ahli_peronda_srs(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('srs__ahli_peronda')
                        ->select('srs__ahli_peronda.id',
                                'srs__ahli_peronda.srs_profile_id',
                                'srs__profile.srs_name AS nama_srs',
                                'srs__ahli_peronda.peronda_nama AS ahli_peronda_nama',
                                'srs__ahli_peronda.peronda_ic AS ahli_peronda_ic',
                                DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lahir,'%d/%m/%Y') AS peronda_tarikh_lahir"),
                                DB::raw(" TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) AS ahli_peronda_umur"),
								DB::raw("REPLACE(REPLACE(srs__ahli_peronda.peronda_alamat,'\n',''), '\r', '') AS ahli_peronda_alamat"),
                                //'srs__ahli_peronda.peronda_alamat AS ahli_peronda_alamat',
                                'srs__ahli_peronda.peronda_kaum AS ahli_peronda_kaum',
                                'ref__jantina.jantina_description AS ahli_peronda_jantina',
                                'srs__ahli_peronda.peronda_warganegara AS ahli_peronda_warganegara',
                                'srs__ahli_peronda.peronda_phone AS ahli_peronda_phone',
                                'ref__status_srs_ahli_peronda.status_description AS ahli_peronda_status',
                                'srs__ahli_peronda.peronda_status AS status')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__ahli_peronda.srs_profile_id')
                        ->leftJoin('ref__status_srs_ahli_peronda','ref__status_srs_ahli_peronda.id','=','srs__ahli_peronda.peronda_status')
                        ->leftJoin('ref__jantina','ref__jantina.id','=','srs__ahli_peronda.peronda_jantina')
                        ->where('srs__ahli_peronda.srs_profile_id', '=', Auth::user()->srs_id)
                        ->whereIN('srs__ahli_peronda.peronda_status', [1,2])
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
            return view('rt-sm13.senarai-ahli-peronda-srs',compact('roles_menu'));
        }
    }

    function ahli_peronda_srs(Request $request, $id){
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
            $srs_profile        = SRS_Profile::where('srs_status', '=', true)->get();
            $ref_jantina        = RefJantina::where('status', '=', true)->get();
            $ref_kaum           = RefKaum::where('status', '=', true)->get();
            $ref_agama          = Ref_Agama::where('status', '=', true)->get();
            $srs_ahli_peronda   = DB::table('srs__ahli_peronda')
                                    ->select('srs__ahli_peronda.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt', 
                                            'ref__daerahs.daerah_description AS daerah_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__duns.dun_description AS dun_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'srs__ahli_peronda.srs_profile_id AS srs_profile_id',
                                            'srs__ahli_peronda.file_gambar_profile AS file_gambar_profile',
                                            'srs__ahli_peronda.peronda_nama AS peronda_nama',
                                            'srs__ahli_peronda.peronda_ic AS peronda_ic',
                                            DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lahir,'%d/%m/%Y') AS peronda_tarikh_lahir"),
                                            'srs__ahli_peronda.peronda_kaum AS peronda_kaum',
                                            'srs__ahli_peronda.peronda_jantina AS peronda_jantina',
                                            'srs__ahli_peronda.peronda_warganegara AS peronda_warganegara',
                                            'srs__ahli_peronda.peronda_agama AS peronda_agama',
                                            'srs__ahli_peronda.peronda_phone AS peronda_phone',
											DB::raw("REPLACE(REPLACE(srs__ahli_peronda.peronda_alamat,'\n',''), '\r', '') AS peronda_alamat"),
                                            //'srs__ahli_peronda.peronda_alamat AS peronda_alamat',
                                            'srs__ahli_peronda.peronda_poskod AS peronda_poskod',
                                            DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lantikan,'%d/%m/%Y') AS peronda_tarikh_lantikan"))
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__ahli_peronda.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('srs__ahli_peronda.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm13.ahli-peronda-srs', 
            compact('roles_menu','srs_profile','ref_jantina','ref_kaum','srs_ahli_peronda', 'ref_agama'));
        }
    }

    function post_edit_gambar_peronda_srs(Request $request){
        $action = $request->post_edit_gambar_peronda_srs;
        $app_id = $request->megps_ahli_peronda_id;
        
        $rules = array(
            'megps_file_gambar_profile'                => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:5000'
        );

        $messages = [
            'megps_file_gambar_profile.required'      => 'Ruangan Fail Mesti Dipilih',
            'megps_file_gambar_profile.mimes'         => 'Fail Mesti Dipilih Dalam Format jpeg,png,jpg,gif,svg,pdf',
            'megps_file_gambar_profile.max'           => 'Fail mesti dalam sive 5000KB',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            $fileName = $request->megps_file_gambar_profile->getClientOriginalName();
            $request->megps_file_gambar_profile->storeAs('public/ahli_peronda_srs',$fileName);
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $gambar_peronda_srs                             = SRS_Ahli_Peronda::where($where)->first();
                $gambar_peronda_srs->file_gambar_profile        = $fileName;
                $gambar_peronda_srs->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function get_senarai_pendidikan_srs_table(Request $request, $id){
        return DataTables()->of(
            DB::select(DB::raw("
                SELECT
                ref__pendidikan.id, ref__pendidikan.pendidikan_description, ref__pendidikan.pendidikan_status, srs__ahli_peronda_pendidikan.id AS srs_ahli_peronda_pendidikanID, srs__ahli_peronda_pendidikan.srs_profileID, srs__ahli_peronda_pendidikan.ref_pendidikanID
                FROM
                ref__pendidikan
                LEFT JOIN srs__ahli_peronda_pendidikan ON srs__ahli_peronda_pendidikan.ref_pendidikanID = ref__pendidikan.id
                AND srs__ahli_peronda_pendidikan.srs_profileID = '" . $id . "'
                ORDER BY ref__pendidikan.id + 0 ASC
            "))
        )->make();
    }

    function add_pendidikan_srs(Request $request){
        $aps_srs_ahli_peronda_id = $request->aps_srs_ahli_peronda_id;
        $srs_ahli_peronda_pendidikanID = $request->srs_ahli_peronda_pendidikanID;
        
        $pendidikan = new SRS_Ahli_Peronda_Pendidikan;
        $pendidikan->srs_profileID         = $aps_srs_ahli_peronda_id;
        $pendidikan->ref_pendidikanID      = $request->srs_ahli_peronda_pendidikanID;
        $pendidikan->save();

    }

    function delete_pendidikan_srs($id){
        $data = DB::table('srs__ahli_peronda_pendidikan')->where('ref_pendidikanID', '=', $id)->delete();
    }

    function post_ahli_peronda_srs(Request $request){
        $action = $request->post_ahli_peronda_srs;
        $app_id = $request->aps_srs_ahli_peronda_id;
        
        
        $rules = array(
            'aps_peronda_kaum'                         => 'required',
            'aps_peronda_jantina'                      => 'required',
            'aps_peronda_warganegara'                  => 'required',
            'aps_peronda_agama'                        => 'required',
            'aps_peronda_alamat'                       => 'required',
            'aps_peronda_poskod'                       => 'required',
            'aps_peronda_phone'                        => 'required',
            'aps_peronda_tarikh_lantikan'              => 'required',
        );

        $messages = [
            'aps_peronda_kaum.required'                => 'Ruangan Kaum mesti dipilih',
            'aps_peronda_jantina.required'             => 'Ruangan Jantina mesti dipilih',
            'aps_peronda_warganegara.required'         => 'Ruangan Warganegara mesti diisi',
            'aps_peronda_agama.required'               => 'Ruangan Agama mesti diisi',
            'aps_peronda_alamat.required'              => 'Ruangan Alamat mesti diisi',
            'aps_peronda_poskod.required'              => 'Ruangan Poskod mesti diisi',
            'aps_peronda_phone.required'               => 'Ruangan Phone mesti diisi',
            'aps_peronda_tarikh_lantikan.required'     => 'Ruangan Tarikh Lantikan SRS mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $carbon_obj_1   = Carbon::createFromFormat('d/m/Y', $request->aps_peronda_tarikh_lantikan)->format('Y-m-d');
                $update_ahli_peronda_srs                            = SRS_Ahli_Peronda::where($where)->first();
                $update_ahli_peronda_srs->peronda_kaum              = $request->aps_peronda_kaum;
                $update_ahli_peronda_srs->peronda_jantina           = $request->aps_peronda_jantina;
                $update_ahli_peronda_srs->peronda_warganegara       = $request->aps_peronda_warganegara;
                $update_ahli_peronda_srs->peronda_agama             = $request->aps_peronda_agama;
                $update_ahli_peronda_srs->peronda_alamat            = $request->aps_peronda_alamat;
                $update_ahli_peronda_srs->peronda_poskod            = $request->aps_peronda_poskod;
                $update_ahli_peronda_srs->peronda_phone             = $request->aps_peronda_phone;
                $update_ahli_peronda_srs->peronda_tarikh_lantikan   = $carbon_obj_1;
                $update_ahli_peronda_srs->save();
            }
        }
    }

    function ahli_peronda_srs_1(Request $request, $id){
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
            $srs_ahli_peronda   = DB::table('srs__ahli_peronda')
                                    ->select('srs__ahli_peronda.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt', 
                                            'ref__daerahs.daerah_description AS daerah_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__duns.dun_description AS dun_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'srs__ahli_peronda.srs_profile_id AS srs_profile_id',
                                            'srs__ahli_peronda.peronda_nama AS peronda_nama',
                                            'srs__ahli_peronda.peronda_ic AS peronda_ic',
                                            DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lahir,'%d/%m/%Y') AS peronda_tarikh_lahir"),
                                            'srs__ahli_peronda.peronda_kaum AS peronda_kaum',
                                            'srs__ahli_peronda.peronda_jantina AS peronda_jantina',
                                            'srs__ahli_peronda.peronda_warganegara AS peronda_warganegara',
                                            'srs__ahli_peronda.peronda_phone AS peronda_phone',
											DB::raw("REPLACE(REPLACE(srs__ahli_peronda.peronda_alamat,'\n',''), '\r', '') AS peronda_alamat"),
                                            //'srs__ahli_peronda.peronda_alamat AS peronda_alamat',
                                            'srs__ahli_peronda.peronda_poskod AS peronda_poskod',
                                            'srs__ahli_peronda.peronda_status AS peronda_status')
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__ahli_peronda.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('srs__ahli_peronda.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm13.ahli-peronda-srs-1', compact('roles_menu','srs_ahli_peronda'));
        }
    }

    function get_senarai_pekerjaan_srs_table(Request $request, $id){
        return DataTables()->of(
            DB::select(DB::raw("
                SELECT
                ref__profession.id, ref__profession.profession_description, ref__profession.status, srs__ahli_peronda_pekerjaan.id AS srs_ahli_peronda_pekerjaanID, srs__ahli_peronda_pekerjaan.srs_profile_id, srs__ahli_peronda_pekerjaan.ref_profession_id
                FROM
                ref__profession
                LEFT JOIN srs__ahli_peronda_pekerjaan ON srs__ahli_peronda_pekerjaan.ref_profession_id = ref__profession.id
                AND srs__ahli_peronda_pekerjaan.srs_profile_id = '" . $id . "'
                ORDER BY ref__profession.id + 0 ASC
            "))
        )->make();
    }

    function add_pekerjaan_srs(Request $request){
        $aps1_srs_ahli_peronda_id = $request->aps1_srs_ahli_peronda_id;
        $srs_ahli_peronda_pekerjaanID = $request->srs_ahli_peronda_pekerjaanID;
        
        $pendidikan = new SRS_Ahli_Peronda_Pekerjaan;
        $pendidikan->srs_profile_id         = $aps1_srs_ahli_peronda_id;
        $pendidikan->ref_profession_id      = $request->srs_ahli_peronda_pekerjaanID;
        $pendidikan->save();

    }

    function delete_pekerjaan_srs($id){
        $data = DB::table('srs__ahli_peronda_pekerjaan')->where('ref_profession_id', '=', $id)->delete();
    }

    function post_ahli_peronda_srs_1(Request $request){
        $action = $request->post_ahli_peronda_srs_1;
        $app_id = $request->aps2_srs_ahli_peronda_id;
        
        
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
                $update_ahli_peronda_srs                            = SRS_Ahli_Peronda::where($where)->first();
               
                $update_ahli_peronda_srs->save();
            }
        }
    }

    function senarai_ahli_peronda_srs_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('srs__ahli_peronda')
                        ->select('srs__ahli_peronda.id',
                                'srs__ahli_peronda.srs_profile_id',
                                'krt__profile.krt_nama AS nama_krt',
                                'srs__profile.srs_name AS nama_srs',
                                'srs__ahli_peronda.peronda_nama AS ahli_peronda_nama',
                                'srs__ahli_peronda.peronda_ic AS ahli_peronda_ic',
                                DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lahir,'%d/%m/%Y') AS peronda_tarikh_lahir"),
                                DB::raw(" TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) AS ahli_peronda_umur"),
								DB::raw("REPLACE(REPLACE(srs__ahli_peronda.peronda_alamat,'\n',''), '\r', '') AS ahli_peronda_alamat"),
                                //'srs__ahli_peronda.peronda_alamat AS ahli_peronda_alamat',
                                'srs__ahli_peronda.peronda_kaum AS ahli_peronda_kaum',
                                'ref__jantina.jantina_description AS ahli_peronda_jantina',
                                'srs__ahli_peronda.peronda_warganegara AS ahli_peronda_warganegara',
                                'srs__ahli_peronda.peronda_phone AS ahli_peronda_phone',
                                'ref__status_srs_ahli_peronda.status_description AS ahli_peronda_status',
                                'srs__ahli_peronda.peronda_status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__ahli_peronda.krt_profile_id')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__ahli_peronda.srs_profile_id')
                        ->leftJoin('ref__status_srs_ahli_peronda','ref__status_srs_ahli_peronda.id','=','srs__ahli_peronda.peronda_status')
                        ->leftJoin('ref__jantina','ref__jantina.id','=','srs__ahli_peronda.peronda_jantina')
                        ->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)
                        ->whereIN('srs__ahli_peronda.peronda_status', [1,2])
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
            return view('rt-sm13.senarai-ahli-peronda-srs-ppd', compact('roles_menu','krt_profile'));
        }
    }

    function senarai_ahli_peronda_srs_ppd_1(Request $request, $id){
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
            $srs_profile        = SRS_Profile::where('srs_status', '=', true)->get();
            $ref_jantina        = RefJantina::where('status', '=', true)->get();
            $ref_kaum           = RefKaum::where('status', '=', true)->get();
            $ref_agama          = Ref_Agama::where('status', '=', true)->get();
            $srs_ahli_peronda   = DB::table('srs__ahli_peronda')
                                    ->select('srs__ahli_peronda.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt', 
                                            'ref__daerahs.daerah_description AS daerah_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__duns.dun_description AS dun_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'srs__ahli_peronda.file_gambar_profile AS file_gambar_profile',
                                            'srs__ahli_peronda.srs_profile_id AS srs_profile_id',
                                            'srs__ahli_peronda.peronda_nama AS peronda_nama',
                                            'srs__ahli_peronda.peronda_ic AS peronda_ic',
                                            DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lahir,'%d/%m/%Y') AS peronda_tarikh_lahir"),
                                            'srs__ahli_peronda.peronda_kaum AS peronda_kaum',
                                            'srs__ahli_peronda.peronda_jantina AS peronda_jantina',
                                            'srs__ahli_peronda.peronda_warganegara AS peronda_warganegara',
                                            'srs__ahli_peronda.peronda_agama AS peronda_agama',
                                            'srs__ahli_peronda.peronda_phone AS peronda_phone',
											DB::raw("REPLACE(REPLACE(srs__ahli_peronda.peronda_alamat,'\n',''), '\r', '') AS peronda_alamat"),
                                            //'srs__ahli_peronda.peronda_alamat AS peronda_alamat',
                                            'srs__ahli_peronda.peronda_poskod AS peronda_poskod',
                                            DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lantikan,'%d/%m/%Y') AS peronda_tarikh_lantikan"))
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__ahli_peronda.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('srs__ahli_peronda.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm13.senarai-ahli-peronda-srs-ppd-1', 
            compact('roles_menu','srs_profile','ref_jantina','ref_kaum','srs_ahli_peronda', 'ref_agama'));
        }
    }

    function senarai_ahli_peronda_srs_ppd_2(Request $request, $id){
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
            $srs_ahli_peronda   = DB::table('srs__ahli_peronda')
                                    ->select('srs__ahli_peronda.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt', 
                                            'ref__daerahs.daerah_description AS daerah_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__duns.dun_description AS dun_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'srs__ahli_peronda.srs_profile_id AS srs_profile_id',
                                            'srs__ahli_peronda.peronda_nama AS peronda_nama',
                                            'srs__ahli_peronda.peronda_ic AS peronda_ic',
                                            DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lahir,'%d/%m/%Y') AS peronda_tarikh_lahir"),
                                            'srs__ahli_peronda.peronda_kaum AS peronda_kaum',
                                            'srs__ahli_peronda.peronda_jantina AS peronda_jantina',
                                            'srs__ahli_peronda.peronda_warganegara AS peronda_warganegara',
                                            'srs__ahli_peronda.peronda_phone AS peronda_phone',
											DB::raw("REPLACE(REPLACE(srs__ahli_peronda.peronda_alamat,'\n',''), '\r', '') AS peronda_alamat"),
                                            //'srs__ahli_peronda.peronda_alamat AS peronda_alamat',
                                            'srs__ahli_peronda.peronda_poskod AS peronda_poskod')
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__ahli_peronda.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('srs__ahli_peronda.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm13.senarai-ahli-peronda-srs-ppd-2', compact('roles_menu','srs_ahli_peronda'));
        }
    }

    function senarai_ahli_peronda_srs_ppn(Request $request){
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
            $data = DB::table('srs__ahli_peronda')
                        ->select('srs__ahli_peronda.id',
                                'srs__ahli_peronda.srs_profile_id',
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'krt__profile.krt_nama AS nama_krt',
                                'srs__profile.srs_name AS nama_srs',
                                'srs__ahli_peronda.peronda_nama AS ahli_peronda_nama',
                                'srs__ahli_peronda.peronda_ic AS ahli_peronda_ic',
                                DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lahir,'%d/%m/%Y') AS peronda_tarikh_lahir"),
                                DB::raw(" TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) AS ahli_peronda_umur"),
								DB::raw("REPLACE(REPLACE(srs__ahli_peronda.peronda_alamat,'\n',''), '\r', '') AS ahli_peronda_alamat"),
                                //'srs__ahli_peronda.peronda_alamat AS ahli_peronda_alamat',
                                'srs__ahli_peronda.peronda_kaum AS ahli_peronda_kaum',
                                'ref__jantina.jantina_description AS ahli_peronda_jantina',
                                'srs__ahli_peronda.peronda_warganegara AS ahli_peronda_warganegara',
                                'srs__ahli_peronda.peronda_phone AS ahli_peronda_phone',
                                'ref__status_srs_ahli_peronda.status_description AS ahli_peronda_status',
                                'srs__ahli_peronda.peronda_status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__ahli_peronda.krt_profile_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__ahli_peronda.srs_profile_id')
                        ->leftJoin('ref__status_srs_ahli_peronda','ref__status_srs_ahli_peronda.id','=','srs__ahli_peronda.peronda_status')
                        ->leftJoin('ref__jantina','ref__jantina.id','=','srs__ahli_peronda.peronda_jantina')
                        ->where('krt__profile.state_id', '=', Auth::user()->state_id)
                        ->whereIN('srs__ahli_peronda.peronda_status', [1,2])
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
            $daerah         = RefDaerah::where('state_id', '=', Auth::user()->state_id)->get();
            $krt_profile    = KRT_Profile::where('krt_status', '=', true)->get();
            return view('rt-sm13.senarai-ahli-peronda-srs-ppn', compact('roles_menu','daerah','krt_profile'));
        }
    }

    function senarai_ahli_peronda_srs_ppn_1(Request $request, $id){
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
            $srs_profile        = SRS_Profile::where('srs_status', '=', true)->get();
            $ref_jantina        = RefJantina::where('status', '=', true)->get();
            $ref_kaum           = RefKaum::where('status', '=', true)->get();
            $srs_ahli_peronda   = DB::table('srs__ahli_peronda')
                                    ->select('srs__ahli_peronda.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt', 
                                            'ref__daerahs.daerah_description AS daerah_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__duns.dun_description AS dun_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'srs__ahli_peronda.srs_profile_id AS srs_profile_id',
                                            'srs__ahli_peronda.file_gambar_profile AS file_gambar_profile',
                                            'srs__ahli_peronda.peronda_nama AS peronda_nama',
                                            'srs__ahli_peronda.peronda_ic AS peronda_ic',
                                            DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lahir,'%d/%m/%Y') AS peronda_tarikh_lahir"),
                                            'srs__ahli_peronda.peronda_kaum AS peronda_kaum',
                                            'srs__ahli_peronda.peronda_jantina AS peronda_jantina',
                                            'srs__ahli_peronda.peronda_warganegara AS peronda_warganegara',
                                            'srs__ahli_peronda.peronda_phone AS peronda_phone',
											DB::raw("REPLACE(REPLACE(srs__ahli_peronda.peronda_alamat,'\n',''), '\r', '') AS peronda_alamat"),
                                            //'srs__ahli_peronda.peronda_alamat AS peronda_alamat',
                                            'srs__ahli_peronda.peronda_poskod AS peronda_poskod',
                                            DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lantikan,'%d/%m/%Y') AS peronda_tarikh_lantikan"))
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__ahli_peronda.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('srs__ahli_peronda.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm13.senarai-ahli-peronda-srs-ppn-1', compact('roles_menu','srs_profile','ref_jantina','ref_kaum','srs_ahli_peronda'));
        }
    }

    function senarai_ahli_peronda_srs_ppn_2(Request $request, $id){
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
            $srs_ahli_peronda   = DB::table('srs__ahli_peronda')
                                    ->select('srs__ahli_peronda.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt', 
                                            'ref__daerahs.daerah_description AS daerah_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__duns.dun_description AS dun_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'srs__ahli_peronda.srs_profile_id AS srs_profile_id',
                                            'srs__ahli_peronda.peronda_nama AS peronda_nama',
                                            'srs__ahli_peronda.peronda_ic AS peronda_ic',
                                            DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lahir,'%d/%m/%Y') AS peronda_tarikh_lahir"),
                                            'srs__ahli_peronda.peronda_kaum AS peronda_kaum',
                                            'srs__ahli_peronda.peronda_jantina AS peronda_jantina',
                                            'srs__ahli_peronda.peronda_warganegara AS peronda_warganegara',
                                            'srs__ahli_peronda.peronda_phone AS peronda_phone',
											DB::raw("REPLACE(REPLACE(srs__ahli_peronda.peronda_alamat,'\n',''), '\r', '') AS peronda_alamat"),
                                            //'srs__ahli_peronda.peronda_alamat AS peronda_alamat',
                                            'srs__ahli_peronda.peronda_poskod AS peronda_poskod')
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__ahli_peronda.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('srs__ahli_peronda.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm13.senarai-ahli-peronda-srs-ppn-2', compact('roles_menu','srs_ahli_peronda'));
        }
    }

    function senarai_ahli_peronda_srs_hq(Request $request){
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
            $data = DB::table('srs__ahli_peronda')
                        ->select('srs__ahli_peronda.id',
                                'srs__ahli_peronda.srs_profile_id',
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'krt__profile.krt_nama AS nama_krt',
                                'srs__profile.srs_name AS nama_srs',
                                'srs__ahli_peronda.peronda_nama AS ahli_peronda_nama',
                                'srs__ahli_peronda.peronda_ic AS ahli_peronda_ic',
                                DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lahir,'%d/%m/%Y') AS peronda_tarikh_lahir"),
                                DB::raw(" TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) AS ahli_peronda_umur"),
								DB::raw("REPLACE(REPLACE(srs__ahli_peronda.peronda_alamat,'\n',''), '\r', '') AS ahli_peronda_alamat"),
                                //'srs__ahli_peronda.peronda_alamat AS ahli_peronda_alamat',
                                'srs__ahli_peronda.peronda_kaum AS ahli_peronda_kaum',
                                'ref__jantina.jantina_description AS ahli_peronda_jantina',
                                'srs__ahli_peronda.peronda_warganegara AS ahli_peronda_warganegara',
                                'srs__ahli_peronda.peronda_phone AS ahli_peronda_phone',
                                'ref__status_srs_ahli_peronda.status_description AS ahli_peronda_status',
                                'srs__ahli_peronda.peronda_status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__ahli_peronda.krt_profile_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__ahli_peronda.srs_profile_id')
                        ->leftJoin('ref__status_srs_ahli_peronda','ref__status_srs_ahli_peronda.id','=','srs__ahli_peronda.peronda_status')
                        ->leftJoin('ref__jantina','ref__jantina.id','=','srs__ahli_peronda.peronda_jantina')
                        ->whereIN('srs__ahli_peronda.peronda_status', [1])
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
            $krt_profile    = KRT_Profile::where('krt_status', '=', true)->get();
            return view('rt-sm13.senarai-ahli-peronda-srs-hq', compact('roles_menu','state','daerah','krt_profile'));
        }
    }

    function senarai_ahli_peronda_srs_hq_1(Request $request, $id){
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
            $srs_profile        = SRS_Profile::where('srs_status', '=', true)->get();
            $ref_jantina        = RefJantina::where('status', '=', true)->get();
            $ref_kaum           = RefKaum::where('status', '=', true)->get();
            $srs_ahli_peronda   = DB::table('srs__ahli_peronda')
                                    ->select('srs__ahli_peronda.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt', 
                                            'ref__daerahs.daerah_description AS daerah_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__duns.dun_description AS dun_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'srs__ahli_peronda.file_gambar_profile AS file_gambar_profile',
                                            'srs__ahli_peronda.srs_profile_id AS srs_profile_id',
                                            'srs__ahli_peronda.peronda_nama AS peronda_nama',
                                            'srs__ahli_peronda.peronda_ic AS peronda_ic',
                                            DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lahir,'%d/%m/%Y') AS peronda_tarikh_lahir"),
                                            'srs__ahli_peronda.peronda_kaum AS peronda_kaum',
                                            'srs__ahli_peronda.peronda_jantina AS peronda_jantina',
                                            'srs__ahli_peronda.peronda_warganegara AS peronda_warganegara',
                                            'srs__ahli_peronda.peronda_phone AS peronda_phone',
											DB::raw("REPLACE(REPLACE(srs__ahli_peronda.peronda_alamat,'\n',''), '\r', '') AS peronda_alamat"),
                                            //'srs__ahli_peronda.peronda_alamat AS peronda_alamat',
                                            'srs__ahli_peronda.peronda_poskod AS peronda_poskod',
                                            DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lantikan,'%d/%m/%Y') AS peronda_tarikh_lantikan"))
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__ahli_peronda.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('srs__ahli_peronda.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm13.senarai-ahli-peronda-srs-hq-1', compact('roles_menu','srs_profile','ref_jantina','ref_kaum','srs_ahli_peronda'));
        }
    }

    function senarai_ahli_peronda_srs_hq_2(Request $request, $id){
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
            $srs_ahli_peronda   = DB::table('srs__ahli_peronda')
                                    ->select('srs__ahli_peronda.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt', 
                                            'ref__daerahs.daerah_description AS daerah_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__duns.dun_description AS dun_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'srs__ahli_peronda.srs_profile_id AS srs_profile_id',
                                            'srs__ahli_peronda.peronda_nama AS peronda_nama',
                                            'srs__ahli_peronda.peronda_ic AS peronda_ic',
                                            DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lahir,'%d/%m/%Y') AS peronda_tarikh_lahir"),
                                            'srs__ahli_peronda.peronda_kaum AS peronda_kaum',
                                            'srs__ahli_peronda.peronda_jantina AS peronda_jantina',
                                            'srs__ahli_peronda.peronda_warganegara AS peronda_warganegara',
                                            'srs__ahli_peronda.peronda_phone AS peronda_phone',
											DB::raw("REPLACE(REPLACE(srs__ahli_peronda.peronda_alamat,'\n',''), '\r', '') AS peronda_alamat"),
                                            //'srs__ahli_peronda.peronda_alamat AS peronda_alamat',
                                            'srs__ahli_peronda.peronda_poskod AS peronda_poskod')
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__ahli_peronda.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('srs__ahli_peronda.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm13.senarai-ahli-peronda-srs-hq-2', compact('roles_menu','srs_ahli_peronda'));
        }
    }

    function kad_keahlian_hqsrs(Request $request){
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
            $data = DB::table('srs__ahli_peronda')
                        ->select('srs__ahli_peronda.id',
                                'srs__ahli_peronda.srs_profile_id',
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'krt__profile.krt_nama AS nama_krt',
                                'srs__profile.srs_name AS nama_srs',
                                'srs__ahli_peronda.peronda_nama AS ahli_peronda_nama',
                                'srs__ahli_peronda.peronda_ic AS ahli_peronda_ic',
                                DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lahir,'%d/%m/%Y') AS peronda_tarikh_lahir"),
                                DB::raw(" TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) AS ahli_peronda_umur"),
								DB::raw("REPLACE(REPLACE(srs__ahli_peronda.peronda_alamat,'\n',''), '\r', '') AS ahli_peronda_alamat"),
                                //'srs__ahli_peronda.peronda_alamat AS ahli_peronda_alamat',
                                'srs__ahli_peronda.peronda_kaum AS ahli_peronda_kaum',
                                'ref__jantina.jantina_description AS ahli_peronda_jantina',
                                'srs__ahli_peronda.peronda_warganegara AS ahli_peronda_warganegara',
                                'srs__ahli_peronda.peronda_phone AS ahli_peronda_phone',
                                'ref__status_srs_ahli_peronda.status_description AS ahli_peronda_status',
                                'srs__ahli_peronda.peronda_status AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__ahli_peronda.krt_profile_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__ahli_peronda.srs_profile_id')
                        ->leftJoin('ref__status_srs_ahli_peronda','ref__status_srs_ahli_peronda.id','=','srs__ahli_peronda.peronda_status')
                        ->leftJoin('ref__jantina','ref__jantina.id','=','srs__ahli_peronda.peronda_jantina')
                        ->whereIN('srs__ahli_peronda.peronda_status', [1])
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
            $krt_profile    = KRT_Profile::where('krt_status', '=', true)->get();
            return view('rt-sm13.kad-keahlian-hqsrs', compact('roles_menu','state','daerah','krt_profile'));
        }
    }

    function semak_pendaftaran_ahli_peronda_srs(){
        return view('rt-sm13.semak-pendaftaran-ahli-peronda-srs');
    }

    function semak_pendaftaran_ahli_peronda_srs_1(){
        return view('rt-sm13.semak-pendaftaran-ahli-peronda-srs-1');
    }

    function semak_pendaftaran_ahli_peronda_srs_2(){
        return view('rt-sm13.semak-pendaftaran-ahli-peronda-srs-2');
    }

    function semak_pendaftaran_ahli_peronda_srs_3(){
        return view('rt-sm13.semak-pendaftaran-ahli-peronda-srs-3');
    }

    function kad_keahlian_srs(Request $request){
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
							->orderBy('krt__profile.krt_nama','asc')
							->get();
					return Response::json($data);
				}
				if(Auth::user()->daerah_id === null)
				{
					$data = DB::table('srs__ahli_peronda')
								->select('srs__ahli_peronda.id',
										'srs__ahli_peronda.srs_profile_id',
										'ref__states.state_description AS state',
										'ref__daerahs.daerah_description AS daerah',
										'krt__profile.krt_nama AS nama_krt',
										'srs__profile.srs_name AS nama_srs',
										'srs__ahli_peronda.peronda_nama AS ahli_peronda_nama',
										'srs__ahli_peronda.peronda_ic AS ahli_peronda_ic',
										DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lahir,'%d/%m/%Y') AS peronda_tarikh_lahir"),
										DB::raw(" TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) AS ahli_peronda_umur"),
										DB::raw("REPLACE(REPLACE(srs__ahli_peronda.peronda_alamat,'\n',''), '\r', '') AS ahli_peronda_alamat"),
										//'srs__ahli_peronda.peronda_alamat AS ahli_peronda_alamat',
										'srs__ahli_peronda.peronda_kaum AS ahli_peronda_kaum',
										'ref__jantina.jantina_description AS ahli_peronda_jantina',
										'srs__ahli_peronda.peronda_warganegara AS ahli_peronda_warganegara',
										'srs__ahli_peronda.peronda_phone AS ahli_peronda_phone',
										'ref__status_srs_ahli_peronda.status_description AS ahli_peronda_status',
										'srs__ahli_peronda.peronda_status AS status')
								->leftJoin('krt__profile','krt__profile.id','=','srs__ahli_peronda.krt_profile_id')
								->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
								->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
								->leftJoin('srs__profile','srs__profile.id','=','srs__ahli_peronda.srs_profile_id')
								->leftJoin('ref__status_srs_ahli_peronda','ref__status_srs_ahli_peronda.id','=','srs__ahli_peronda.peronda_status')
								->leftJoin('ref__jantina','ref__jantina.id','=','srs__ahli_peronda.peronda_jantina')
								->whereIN('srs__ahli_peronda.peronda_status', [1])
								->where('krt__profile.state_id','=',Auth::user()->state_id)
								->orderBy('krt__profile.krt_nama','asc')
								->orderBy('srs__profile.srs_name','asc')
								->orderBy('srs__ahli_peronda.peronda_nama','asc')
								->get();
				}else
				{
					$data = DB::table('srs__ahli_peronda')
								->select('srs__ahli_peronda.id',
										'srs__ahli_peronda.srs_profile_id',
										'ref__states.state_description AS state',
										'ref__daerahs.daerah_description AS daerah',
										'krt__profile.krt_nama AS nama_krt',
										'srs__profile.srs_name AS nama_srs',
										'srs__ahli_peronda.peronda_nama AS ahli_peronda_nama',
										'srs__ahli_peronda.peronda_ic AS ahli_peronda_ic',
										DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lahir,'%d/%m/%Y') AS peronda_tarikh_lahir"),
										DB::raw(" TIMESTAMPDIFF(YEAR, srs__ahli_peronda.peronda_tarikh_lahir, CURDATE()) AS ahli_peronda_umur"),
										DB::raw("REPLACE(REPLACE(srs__ahli_peronda.peronda_alamat,'\n',''), '\r', '') AS ahli_peronda_alamat"),
										//'srs__ahli_peronda.peronda_alamat AS ahli_peronda_alamat',
										'srs__ahli_peronda.peronda_kaum AS ahli_peronda_kaum',
										'ref__jantina.jantina_description AS ahli_peronda_jantina',
										'srs__ahli_peronda.peronda_warganegara AS ahli_peronda_warganegara',
										'srs__ahli_peronda.peronda_phone AS ahli_peronda_phone',
										'ref__status_srs_ahli_peronda.status_description AS ahli_peronda_status',
										'srs__ahli_peronda.peronda_status AS status')
								->leftJoin('krt__profile','krt__profile.id','=','srs__ahli_peronda.krt_profile_id')
								->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
								->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
								->leftJoin('srs__profile','srs__profile.id','=','srs__ahli_peronda.srs_profile_id')
								->leftJoin('ref__status_srs_ahli_peronda','ref__status_srs_ahli_peronda.id','=','srs__ahli_peronda.peronda_status')
								->leftJoin('ref__jantina','ref__jantina.id','=','srs__ahli_peronda.peronda_jantina')
								->whereIN('srs__ahli_peronda.peronda_status', [1])
								->where('krt__profile.state_id','=',Auth::user()->state_id)
								->where('krt__profile.daerah_id','=',Auth::user()->daerah_id)
								->orderBy('krt__profile.krt_nama','asc')
								->orderBy('srs__profile.srs_name','asc')
								->orderBy('srs__ahli_peronda.peronda_nama','asc')
								->get();
				}
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
				$state          = RefStates::where('status', '=', true)->where('state_id','=',Auth::user()->state_id)->get();
				$daerah         = RefDaerah::where('status', '=', true)->where('daerah_id','=',Auth::user()->daerah_id)->get();
				$krt_profile    = KRT_Profile::where('krt_status', '=', true)
								  ->where('state_id','=',Auth::user()->state_id)
								  ->where('daerah_id','=',Auth::user()->daerah_id)
								  ->orderBy('krt_nama','asc')
								  ->get();
				return view('rt-sm13.kad-keahlian-srs', compact('roles_menu','state','daerah','krt_profile'));
			}
    }
}
