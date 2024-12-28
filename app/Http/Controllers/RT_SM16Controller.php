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
use App\SRS_Pelaksanaan_Rondaan;
use App\SRS_Pelaksanaan_Rondaan_Ahli;
use App\Ref_SRS_Kategori_Kes;
use App\Ref_SRS_Jenis_Kes;
use App\Ref_SRS_Dirujuk_Kes ;
use App\SRS_Pelaksanaan_Rondaan_Kes_Terlibat ;


use DataTables;
use DB;

class RT_SM16Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function penyediaan_pelaksanaan_rondaan_srs(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('srs__pelaksanaan_rondaan')
                        ->select('srs__pelaksanaan_rondaan.id',
                                'srs__pelaksanaan_rondaan.krt_profile_id AS krt_profile_id',
                                'srs__pelaksanaan_rondaan.srs_profile_id AS srs_profile_id',
                                'krt__profile.krt_nama AS nama_krt',
                                'srs__profile.srs_name AS nama_srs',
                                DB::raw(" DATE_FORMAT(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh,'%d/%m/%Y') AS pelaksanaan_rondaan_tarikh"),
                                DB::raw(" DATE_FORMAT(srs__pelaksanaan_rondaan.direkod_date,'%d/%m/%Y') AS direkod_date"),
                                'users__profile.user_fullname AS user_fullname',
                                'srs__pelaksanaan_rondaan.pelaksanaan_rondaan_kes AS pelaksanaan_rondaan_kes',
                                'ref__status_pelaksanaan_rondaan_srs.status_description AS status',
                                'srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status AS pelaksanaan_rondaan_status')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__pelaksanaan_rondaan.krt_profile_id')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__pelaksanaan_rondaan.srs_profile_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','srs__pelaksanaan_rondaan.direkod_by')
                        ->leftJoin('ref__status_pelaksanaan_rondaan_srs','ref__status_pelaksanaan_rondaan_srs.id','=','srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status')
                        ->where('srs__pelaksanaan_rondaan.krt_profile_id', '=', Auth::user()->krt_id)
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
            $srs_profile        = SRS_Profile::where('srs_status', '=', true)
                                ->where('srs__profile.krt_id', '=', Auth::user()->krt_id)
                                ->get();
            return view('rt-sm16.penyediaan-pelaksanaan-rondaan-srs',compact('roles_menu','srs_profile'));
        }
    }

    function post_tambah_pelaksanaan_rondaan(Request $request){
        
        $action = $request->tambah_pelaksanaan_rondaan;
        
        $rules = array(
           
        );

        $messages = [
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm15.penyediaan_pelaksanaan_rondaan_srs'))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'add') {
                $tambah_pelaksanaan_rondaan                             = new SRS_Pelaksanaan_Rondaan;
                $tambah_pelaksanaan_rondaan->krt_profile_id             = Auth::user()->krt_id;
                $tambah_pelaksanaan_rondaan->srs_profile_id             = Auth::user()->srs_id;
                $tambah_pelaksanaan_rondaan->pelaksanaan_rondaan_status = 2;
                $tambah_pelaksanaan_rondaan->save();
            }
           
            return Redirect::to(route('rt-sm16.penyediaan_pelaksanaan_rondaan_srs_1',$tambah_pelaksanaan_rondaan->id));
        }

    }

    function penyediaan_pelaksanaan_rondaan_srs_1(Request $request, $id){
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
            $pelaksanaan_rondaan    = DB::table('srs__pelaksanaan_rondaan')
                                    ->select('srs__pelaksanaan_rondaan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt', 
                                            'ref__daerahs.daerah_description AS daerah_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__duns.dun_description AS dun_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'srs__pelaksanaan_rondaan.krt_profile_id AS krt_profile_id',
                                            'srs__pelaksanaan_rondaan.srs_profile_id AS srs_profile_id',
                                            DB::raw(" DATE_FORMAT(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh,'%d/%m/%Y') AS pelaksanaan_rondaan_tarikh"),
                                            'srs__pelaksanaan_rondaan.pelaksanaan_rondaan_kes AS pelaksanaan_rondaan_kes')
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__pelaksanaan_rondaan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('srs__pelaksanaan_rondaan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $srs_profile            = SRS_Profile::where('srs_status', '=', true)
                                    ->where('srs__profile.krt_id', '=', Auth::user()->krt_id)
                                    ->get();
            return view('rt-sm16.penyediaan-pelaksanaan-rondaan-srs-1',compact('roles_menu','pelaksanaan_rondaan','srs_profile'));
        }
    }

    function get_senarai_ahli_table(Request $request, $id){
        return DataTables()->of(
            DB::select(DB::raw("
                SELECT
                srs__ahli_peronda.id, srs__ahli_peronda.peronda_nama, srs__ahli_peronda.peronda_ic, srs__pelaksanaan_rondaan_ahli.id AS srs__pelaksanaan_rondaan_ahli_id, 
                srs__pelaksanaan_rondaan_ahli.srs_pelaksanaan_rondaan_id, srs__pelaksanaan_rondaan_ahli.srs_ahli_peronda_id
                FROM
                srs__ahli_peronda
                LEFT JOIN srs__pelaksanaan_rondaan_ahli ON srs__pelaksanaan_rondaan_ahli.srs_ahli_peronda_id = srs__ahli_peronda.id
                AND srs__pelaksanaan_rondaan_ahli.srs_pelaksanaan_rondaan_id = '" . $id . "' 
                WHERE srs__ahli_peronda.peronda_status = 1 AND srs__ahli_peronda.srs_profile_id =  '" .Auth::user()->srs_id. "'
                ORDER BY srs__ahli_peronda.id + 0 ASC
            "))
        )->make();
    }

    function add_pelaksanaan_rondaan_ahli(Request $request){
        $pprs_srs_pelaksanaan_rondaan_id = $request->pprs_srs_pelaksanaan_rondaan_id;
        $srs_pelaksanaan_rondaan_id = $request->srs_pelaksanaan_rondaan_id;
        
        $pelaksanaan_rondaan_ahli = new SRS_Pelaksanaan_Rondaan_Ahli;
        $pelaksanaan_rondaan_ahli->srs_pelaksanaan_rondaan_id   = $pprs_srs_pelaksanaan_rondaan_id;
        $pelaksanaan_rondaan_ahli->srs_ahli_peronda_id          = $request->srs_ahli_peronda_id;
        $pelaksanaan_rondaan_ahli->save();

    }

    function delete__pelaksanaan_rondaan_ahli($id){
        $data = DB::table('srs__pelaksanaan_rondaan_ahli')->where('srs_ahli_peronda_id', '=', $id)->delete();
    }

    function post_tambah_pelaksanaan_rondaan_1(Request $request){
        $action = $request->post_tambah_pelaksanaan_rondaan_1;
        $app_id = $request->pprs_srs_pelaksanaan_rondaan_id;
        
        
        $rules = array(
            'pprs_pelaksanaan_rondaan_tarikh'           => 'required',
            'pprs_pelaksanaan_rondaan_kes'              => 'required',
        );

        $messages = [
            'pprs_pelaksanaan_rondaan_tarikh.required'  => 'Ruangan Tarikh Rondaaan mesti diisi',
            'pprs_pelaksanaan_rondaan_kes.required'     => 'Ruangan Status Kes mesti dipilih',
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $carbon_obj     = Carbon::createFromFormat('d/m/Y', $request->pprs_pelaksanaan_rondaan_tarikh)->format('Y-m-d');
                $pelaksanaan_rondaan                                = SRS_Pelaksanaan_Rondaan::where($where)->first();
                $pelaksanaan_rondaan->direkod_by                    = Auth::user()->user_id;
                $pelaksanaan_rondaan->direkod_date                  = date('Y-m-d H:i:s');
                $pelaksanaan_rondaan->pelaksanaan_rondaan_tarikh    = $carbon_obj;
                $pelaksanaan_rondaan->pelaksanaan_rondaan_kes       = $request->pprs_pelaksanaan_rondaan_kes;
                $pelaksanaan_rondaan->save();
            }
        }
    }

    function post_tambah_pelaksanaan_rondaan_2(Request $request){
        $action = $request->post_tambah_pelaksanaan_rondaan_2;
        $app_id = $request->pprs_srs_pelaksanaan_rondaan_id;
        
        
        $rules = array(
            'pprs_pelaksanaan_rondaan_tarikh'           => 'required',
            'pprs_pelaksanaan_rondaan_kes'              => 'required',
        );

        $messages = [
            'pprs_pelaksanaan_rondaan_tarikh.required'  => 'Ruangan Tarikh Rondaaan mesti diisi',
            'pprs_pelaksanaan_rondaan_kes.required'     => 'Ruangan Status Kes mesti dipilih',
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $carbon_obj     = Carbon::createFromFormat('d/m/Y', $request->pprs_pelaksanaan_rondaan_tarikh)->format('Y-m-d');
                $pelaksanaan_rondaan                                = SRS_Pelaksanaan_Rondaan::where($where)->first();
                $pelaksanaan_rondaan->direkod_by                    = Auth::user()->user_id;
                $pelaksanaan_rondaan->direkod_date                  = date('Y-m-d H:i:s');
                $pelaksanaan_rondaan->pelaksanaan_rondaan_tarikh    = $carbon_obj;
                $pelaksanaan_rondaan->pelaksanaan_rondaan_kes       = $request->pprs_pelaksanaan_rondaan_kes;
                $pelaksanaan_rondaan->pelaksanaan_rondaan_status    = 3;
                $pelaksanaan_rondaan->save();
            }
        }
    }

    function penyediaan_pelaksanaan_rondaan_srs_2(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_jenis') {
                $value = $request->value;
                $where = array('kategori_id' => $value);
                $data  = Ref_SRS_Jenis_Kes::where($where)
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
            $pelaksanaan_rondaan    = DB::table('srs__pelaksanaan_rondaan')
                                    ->select('srs__pelaksanaan_rondaan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt', 
                                            'ref__daerahs.daerah_description AS daerah_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__duns.dun_description AS dun_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'srs__pelaksanaan_rondaan.krt_profile_id AS krt_profile_id',
                                            'srs__pelaksanaan_rondaan.srs_profile_id AS srs_profile_id',
                                            DB::raw(" DATE_FORMAT(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh,'%d/%m/%Y') AS pelaksanaan_rondaan_tarikh"))
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__pelaksanaan_rondaan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('srs__pelaksanaan_rondaan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $kategori_kes           = Ref_SRS_Kategori_Kes::where('status', '=', true)
                                    ->get();
            $jenis_kes              = Ref_SRS_Jenis_Kes::where('status', '=', true)
                                    ->get();
            $kaum                   = RefKaum::where('status', '=', true)
                                    ->get();
            $jantina                = RefJantina::where('status', '=', true)
                                    ->get();
            $rujuk_kes              = Ref_SRS_Dirujuk_Kes::where('status', '=', true)
                                    ->get();
            return view('rt-sm16.penyediaan-pelaksanaan-rondaan-srs-2',compact('roles_menu','pelaksanaan_rondaan','kategori_kes','jenis_kes', 'kaum', 'jantina', 'rujuk_kes'));
        }
        
    }

    function get_kaum_terlibat_table(Request $request, $id){
        $data = DB::table('srs__pelaksanaan_rondaan_kes_terlibat')
                    ->select('srs__pelaksanaan_rondaan_kes_terlibat.*','ref__kaum.kaum_description', 'ref__jantina.jantina_description')
                    ->join('ref__kaum','ref__kaum.id','=','srs__pelaksanaan_rondaan_kes_terlibat.kaum_id')
                    ->join('ref__jantina','ref__jantina.id','=','srs__pelaksanaan_rondaan_kes_terlibat.jantina_id')
                    ->where('srs__pelaksanaan_rondaan_kes_terlibat.srs_pelaksanaan_rondaan_id', '=', $id)
                    ->get();
                return Datatables::of($data)
                        ->make(true);
    }

    function post_add_kaum_terlibat(Request $request){
        $action = $request->add_kaum_terlibat;
        $app_id = $request->pprs3_srs_pelaksanaan_rondaan_id;
        
        $rules = array(
            'pprs3_kaum_id'                     => 'required',
            'pprs3_terlibat_bilangan'           => 'required',
            'pprs3_jantina_id'                  => 'required',
            'pprs3_terlibat_umur'               => 'required'
        );

        $messages = [
            'pprs3_kaum_id.required'            => 'Ruangan Kaum mesti dipilih',
            'pprs3_terlibat_bilangan.required'  => 'Ruangan Jantina mesti diisi',
            'pprs3_jantina_id.required'         => 'Ruangan Bilangan mesti dipilih',
            'pprs3_terlibat_umur.required'      => 'Ruangan Umur mesti diisi',
            
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $kaum_terlibat = new SRS_Pelaksanaan_Rondaan_Kes_Terlibat;
                $kaum_terlibat->srs_pelaksanaan_rondaan_id    = $request->pprs3_srs_pelaksanaan_rondaan_id;
                $kaum_terlibat->kaum_id                       = $request->pprs3_kaum_id;
                $kaum_terlibat->terlibat_bilangan             = $request->pprs3_terlibat_bilangan;
                $kaum_terlibat->jantina_id                    = $request->pprs3_jantina_id;
                $kaum_terlibat->terlibat_umur                 = $request->pprs3_terlibat_umur;
                $kaum_terlibat->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_kaum_terlibat($id){
        $data = DB::table('srs__pelaksanaan_rondaan_kes_terlibat')->where('id', '=', $id)->delete();
    }

    function post_tambah_pelaksanaan_rondaan_3(Request $request){
        $action = $request->post_tambah_pelaksanaan_rondaan_3;
        $app_id = $request->pprs5_srs_pelaksanaan_rondaan_id;
        
        $rules = array(
            'pprs2_kategori_id'                        => 'required',
            'pprs2_jenis_id'                           => 'required',
            'pprs2_kes_keterangan'                     => 'required',
            'pprs4_kes_jumlah_org_terlibat'            => 'required',
            'pprs4_kes_dirujuk_id'                     => 'required',
        );

        $messages = [
            'pprs2_kategori_id.required'               => 'Ruangan kategori kes mesti dipilih',
            'pprs2_jenis_id.required'                  => 'Ruangan Jenis Kes mesti dipilih',
            'pprs2_kes_keterangan.required'            => 'Ruangan Keterangan Kes mesti diisi',
            'pprs4_kes_jumlah_org_terlibat.required'   => 'Ruangan Bilangan Orang Yang Terlibat mesti diisi',
            'pprs4_kes_dirujuk_id.required'            => 'Ruangan Kes dirujuk kepada mesti dipilih',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $pelaksanaan_rondaan = SRS_Pelaksanaan_Rondaan::where($where)->first();
                $pelaksanaan_rondaan->kategori_kes_id               = $request->pprs2_kategori_id;
                $pelaksanaan_rondaan->jenis_kes_id                  = $request->pprs2_jenis_id;
                $pelaksanaan_rondaan->kes_keterangan                = $request->pprs2_kes_keterangan;
                $pelaksanaan_rondaan->kes_jumlah_org_terlibat       = $request->pprs4_kes_jumlah_org_terlibat;
                $pelaksanaan_rondaan->kes_dirujuk_id                = $request->pprs4_kes_dirujuk_id;
                $pelaksanaan_rondaan->pelaksanaan_rondaan_status    = 3;
                $pelaksanaan_rondaan->direkod_by                    = Auth::user()->user_id;
                $pelaksanaan_rondaan->direkod_date                  = date('Y-m-d H:i:s');
                $pelaksanaan_rondaan->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function pengesahan_pelaksanaan_rondaan_srs(Request $request){
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
            $data = DB::table('srs__pelaksanaan_rondaan')
                        ->select('srs__pelaksanaan_rondaan.id',
                                'srs__pelaksanaan_rondaan.krt_profile_id AS krt_profile_id',
                                'srs__pelaksanaan_rondaan.srs_profile_id AS srs_profile_id',
                                'krt__profile.krt_nama AS nama_krt',
                                'srs__profile.srs_name AS nama_srs',
                                DB::raw(" DATE_FORMAT(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh,'%d/%m/%Y') AS pelaksanaan_rondaan_tarikh"),
                                DB::raw(" DATE_FORMAT(srs__pelaksanaan_rondaan.direkod_date,'%d/%m/%Y') AS direkod_date"),
                                'users__profile.user_fullname AS user_fullname',
                                'srs__pelaksanaan_rondaan.pelaksanaan_rondaan_kes AS pelaksanaan_rondaan_kes',
                                'ref__status_pelaksanaan_rondaan_srs.status_description AS status',
                                'srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status AS pelaksanaan_rondaan_status')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__pelaksanaan_rondaan.krt_profile_id')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__pelaksanaan_rondaan.srs_profile_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','srs__pelaksanaan_rondaan.direkod_by')
                        ->leftJoin('ref__status_pelaksanaan_rondaan_srs','ref__status_pelaksanaan_rondaan_srs.id','=','srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status')
                        ->where('krt__profile.daerah_id','=', Auth::user()->daerah_id)
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
            $krt_profile        = KRT_Profile::where('krt_status', '=', true)
                                ->get();
            $srs_profile        = SRS_Profile::where('srs_status', '=', true)
                                ->get();
            return view('rt-sm16.pengesahan-pelaksanaan-rondaan-srs',compact('roles_menu','krt_profile' ,'srs_profile'));
        }
    }

    function pengesahan_pelaksanaan_rondaan_srs_1(Request $request, $id){
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
            $pelaksanaan_rondaan    = DB::table('srs__pelaksanaan_rondaan')
                                    ->select('srs__pelaksanaan_rondaan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt', 
                                            'ref__daerahs.daerah_description AS daerah_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__duns.dun_description AS dun_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'srs__pelaksanaan_rondaan.krt_profile_id AS krt_profile_id',
                                            'srs__pelaksanaan_rondaan.srs_profile_id AS srs_profile_id',
                                            DB::raw(" DATE_FORMAT(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh,'%d/%m/%Y') AS pelaksanaan_rondaan_tarikh"),
                                            'srs__pelaksanaan_rondaan.pelaksanaan_rondaan_kes AS pelaksanaan_rondaan_kes')
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__pelaksanaan_rondaan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('srs__pelaksanaan_rondaan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $srs_profile            = SRS_Profile::where('srs_status', '=', true)
                                    ->get();
            return view('rt-sm16.pengesahan-pelaksanaan-rondaan-srs-1',compact('roles_menu','pelaksanaan_rondaan','srs_profile'));
        }
    }

    function get_senarai_ahli_ppd_table(Request $request, $id){
        return DataTables()->of(
            DB::select(DB::raw("
                SELECT
                srs__ahli_peronda.id, srs__ahli_peronda.peronda_nama, srs__ahli_peronda.peronda_ic, srs__pelaksanaan_rondaan_ahli.id AS srs__pelaksanaan_rondaan_ahli_id, 
                srs__pelaksanaan_rondaan_ahli.srs_pelaksanaan_rondaan_id, srs__pelaksanaan_rondaan_ahli.srs_ahli_peronda_id
                FROM
                srs__ahli_peronda
                LEFT JOIN srs__pelaksanaan_rondaan_ahli ON srs__pelaksanaan_rondaan_ahli.srs_ahli_peronda_id = srs__ahli_peronda.id
                AND srs__pelaksanaan_rondaan_ahli.srs_pelaksanaan_rondaan_id = '" . $id . "'
                LEFT JOIN srs__pelaksanaan_rondaan ON srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_ahli.srs_pelaksanaan_rondaan_id
                WHERE srs__ahli_peronda.peronda_status = 1 AND srs__pelaksanaan_rondaan.id = srs__pelaksanaan_rondaan_ahli.srs_pelaksanaan_rondaan_id
                ORDER BY srs__ahli_peronda.id + 0 ASC
            "))
        )->make();
    }

    function post_pengesahan_pelaksanaan_rondaan_srs(Request $request){
        $action = $request->post_pengesahan_pelaksanaan_rondaan_srs;
        $app_id = $request->pprpd_srs_pelaksanaan_rondaan_id;
        
        
        $rules = array(
            'pprpd_pelaksanaan_rondaan_status'              => 'required',
            'pprpd_disemak_note'                            => 'required',
        );

        $messages = [
            'pprpd_pelaksanaan_rondaan_status.required'     => 'Ruangan Status mesti dipilih',
            'pprpd_disemak_note.required'                   => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $pengesahan_pelaksanaan_rondaan                                 = SRS_Pelaksanaan_Rondaan::where($where)->first();
                $pengesahan_pelaksanaan_rondaan->pelaksanaan_rondaan_status     = $request->pprpd_pelaksanaan_rondaan_status;
                $pengesahan_pelaksanaan_rondaan->disahkan_note                  = $request->pprpd_disemak_note;
                $pengesahan_pelaksanaan_rondaan->disahkan_by                    = Auth::user()->user_id;
                $pengesahan_pelaksanaan_rondaan->disahkan_date                  = date('Y-m-d H:i:s');
                $pengesahan_pelaksanaan_rondaan->save();
            }
        }
    }

    function pengesahan_pelaksanaan_rondaan_srs_2(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_jenis') {
                $value = $request->value;
                $where = array('kategori_id' => $value);
                $data  = Ref_SRS_Jenis_Kes::where($where)
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
            $pelaksanaan_rondaan    = DB::table('srs__pelaksanaan_rondaan')
                                    ->select('srs__pelaksanaan_rondaan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt', 
                                            'ref__daerahs.daerah_description AS daerah_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__duns.dun_description AS dun_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'srs__pelaksanaan_rondaan.kategori_kes_id AS kategori_kes_id',
                                            'srs__pelaksanaan_rondaan.jenis_kes_id AS jenis_kes_id',
                                            'srs__pelaksanaan_rondaan.kes_keterangan AS kes_keterangan',
                                            'srs__pelaksanaan_rondaan.kes_jumlah_org_terlibat AS kes_jumlah_org_terlibat',
                                            'srs__pelaksanaan_rondaan.kes_dirujuk_id AS kes_dirujuk_id')
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__pelaksanaan_rondaan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('srs__pelaksanaan_rondaan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $kategori_kes           = Ref_SRS_Kategori_Kes::where('status', '=', true)
                                    ->get();
            $jenis_kes              = Ref_SRS_Jenis_Kes::where('status', '=', true)
                                    ->get();
            $kaum                   = RefKaum::where('status', '=', true)
                                    ->get();
            $jantina                = RefJantina::where('status', '=', true)
                                    ->get();
            $rujuk_kes              = Ref_SRS_Dirujuk_Kes::where('status', '=', true)
                                    ->get();
            return view('rt-sm16.pengesahan-pelaksanaan-rondaan-srs-2',compact('roles_menu','pelaksanaan_rondaan','kategori_kes','jenis_kes', 'kaum', 'jantina', 'rujuk_kes'));
        }
        
    }

    function post_pengesahan_pelaksanaan_rondaan_srs_2(Request $request){
        $action = $request->post_pengesahan_pelaksanaan_rondaan_srs_2;
        $app_id = $request->pprpd2_srs_pelaksanaan_rondaan_id;
        
        
        $rules = array(
            'pprpd2_pelaksanaan_rondaan_status'              => 'required',
            'pprpd2_disemak_note'                            => 'required',
        );

        $messages = [
            'pprpd2_pelaksanaan_rondaan_status.required'     => 'Ruangan Status mesti dipilih',
            'pprpd2_disemak_note.required'                   => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $pengesahan_pelaksanaan_rondaan                                 = SRS_Pelaksanaan_Rondaan::where($where)->first();
                $pengesahan_pelaksanaan_rondaan->pelaksanaan_rondaan_status     = $request->pprpd2_pelaksanaan_rondaan_status;
                $pengesahan_pelaksanaan_rondaan->disahkan_note                  = $request->pprpd2_disemak_note;
                $pengesahan_pelaksanaan_rondaan->disahkan_by                    = Auth::user()->user_id;
                $pengesahan_pelaksanaan_rondaan->disahkan_date                  = date('Y-m-d H:i:s');
                $pengesahan_pelaksanaan_rondaan->save();
            }
        }
    }

    function laporan_pelaksanaan_rondaan_ppd(Request $request){
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
            $data = DB::table('srs__pelaksanaan_rondaan')
                            ->select('ref__daerahs.daerah_description AS daerah',
                                    'krt__profile.krt_nama AS krt_nama',
                                    'srs__profile.srs_name AS srs_nama',
                                    DB::raw(" YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh) AS tahun_pelaksanaan"),
                                    DB::raw(" MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh) AS bulan_pelaksanaan"),
                                    DB::raw(" SUM(case when day(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh) between 1 AND 7 then 1 else 0 end) AS week_1"),
                                    DB::raw(" SUM(case when day(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh) between 8 AND 14 then 1 else 0 end) AS week_2"),
                                    DB::raw(" SUM(case when day(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh) between 15 AND 21 then 1 else 0 end) AS week_3"),
                                    DB::raw(" SUM(case when day(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh) between 22 AND 31 then 1 else 0 end) AS week_4"),
                                    DB::raw(" SUM(case when month(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh) then 1 else 0 end) AS total_pelaksanaan"))
                            ->leftJoin('krt__profile','krt__profile.id','=','srs__pelaksanaan_rondaan.krt_profile_id')
                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                            ->leftJoin('srs__profile','srs__profile.id','=','srs__pelaksanaan_rondaan.srs_profile_id')
                            ->groupBy(['ref__daerahs.daerah_description', 'krt__profile.krt_nama', 'srs__profile.srs_name',
                            DB::raw(" YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)"),
                            DB::raw(" MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)"),
                            DB::raw(" DATE_FORMAT(pelaksanaan_rondaan_tarikh,'%Y-%m')")])
                            ->where('krt__profile.daerah_id','=', Auth::user()->daerah_id)
                            ->where('srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status','=', true)
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
            $krt_profile        = KRT_Profile::where('krt_status', '=', true)
                                ->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)
                                ->get();
            $srs_profile        = SRS_Profile::where('srs_status', '=', true)
                                ->get();
            return view('rt-sm16.laporan-pelaksanaan-rondaan-ppd',compact('roles_menu','krt_profile','srs_profile'));
        }
    }
    
    function laporan_pelaksanaan_rondaan_ppn(Request $request){
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
            $data = DB::table('srs__pelaksanaan_rondaan')
                        ->select('ref__daerahs.daerah_description AS daerah',
                                'krt__profile.krt_nama AS krt_nama',
                                'srs__profile.srs_name AS srs_nama',
                                DB::raw(" YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh) AS tahun_pelaksanaan"),
                                DB::raw(" MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh) AS bulan_pelaksanaan"),
                                DB::raw(" SUM(case when day(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh) between 1 AND 7 then 1 else 0 end) AS week_1"),
                                DB::raw(" SUM(case when day(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh) between 8 AND 14 then 1 else 0 end) AS week_2"),
                                DB::raw(" SUM(case when day(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh) between 15 AND 21 then 1 else 0 end) AS week_3"),
                                DB::raw(" SUM(case when day(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh) between 22 AND 31 then 1 else 0 end) AS week_4"),
                                DB::raw(" SUM(case when month(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh) then 1 else 0 end) AS total_pelaksanaan"))
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__pelaksanaan_rondaan.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('srs__profile','srs__profile.id','=','srs__pelaksanaan_rondaan.srs_profile_id')
                        ->groupBy(['ref__daerahs.daerah_description', 'krt__profile.krt_nama', 'srs__profile.srs_name',
                        DB::raw(" YEAR(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)"),
                        DB::raw(" MONTH(srs__pelaksanaan_rondaan.pelaksanaan_rondaan_tarikh)"),
                        DB::raw(" DATE_FORMAT(pelaksanaan_rondaan_tarikh,'%Y-%m')")])
                        ->where('krt__profile.state_id','=', Auth::user()->state_id)
                        ->where('srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status','=', true)
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
            $daerah             = RefDaerah::where('status', '=', true)
                                ->where('ref__daerahs.state_id', '=', Auth::user()->state_id)
                                ->get();
            $krt_profile        = KRT_Profile::where('krt_status', '=', true)
                                ->get();
            $srs_profile        = SRS_Profile::where('srs_status', '=', true)
                                ->get();
            return view('rt-sm16.laporan-pelaksanaan-rondaan-ppn',compact('roles_menu','daerah','krt_profile','srs_profile'));
        }
    }

    function penyediaan_pelaksanaan_rondaan(){
        return view('rt-sm16.penyediaan-pelaksanaan-rondaan');
    }

    function laporan_kekerapan_pelaksanaan_rondaan(){
        return view('rt-sm16.laporan-kekerapan-pelaksanaan-rondaan');
    }

    function laporan_rondaan_srs(){
        return view('rt-sm16.laporan-rondaan-srs');
    }

    function laporan_kekerapan_pelaksanaan_rondaan_d(){
        return view('rt-sm16.laporan-kekerapan-pelaksanaan-rondaan-d');
    }

    function laporan_kekerapan_pelaksanaan_rondaan_n(){
        return view('rt-sm16.laporan-kekerapan-pelaksanaan-rondaan-n');
    }

    function laporan_kekerapan_pelaksanaan_rondaan_all(){
        return view('rt-sm16.laporan-kekerapan-pelaksanaan-rondaan-all');
    }
}
