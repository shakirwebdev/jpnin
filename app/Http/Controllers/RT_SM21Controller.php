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
use App\Ref_Spk_Peringkat_Kes;
use App\Ref_Spk_Kategori_Kes;
use App\Ref_Spk_Sub_Kategori_Kes;
use App\Ref_Status_Status_Etnik;
use App\Ref_Status_Warganegara;
use App\RefKaum;
use App\SPK_ikes;
use App\SPK_ikes_bilangan_terlibat;
use App\SPK_ikes_bilangan_cedera;
use App\SPK_ikes_bilangan_cedera_parah;
use App\SPK_ikes_bilangan_kematian;
use App\SPK_ikes_tindakan;
use App\SPK_ikes_terlibat;
use App\SPK_ikes_kedudukan;
use App\SPK_ikes_dokument;
use App\SPK_iKes_AT;
use App\Ref_SPK_iKes_AT_Jenis;
use App\SPK_iKes_TS;
use App\Ref_SPK_Ikes_Kluster;
use App\Ref_SPK_Ikes_Sub_Kluster;

class RT_SM21Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function senarai_permohonan_ikes(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('spk__ikes')
                        ->select('spk__ikes.id AS id',
                                'ref__spk_peringkat_kes.peringkat_description AS peringkat_description',
                                'ref__spk_kategori_kes.kategori_description AS kategori_description',
                                'users__profile.user_fullname AS user_fullname',
                                'ref__status_spk_ikes.status_description AS status_description',
                                'spk__ikes.status AS status')
                        ->leftJoin('ref__spk_peringkat_kes','ref__spk_peringkat_kes.id','=','spk__ikes.peringkat_id')
                        ->leftJoin('ref__spk_kategori_kes','ref__spk_kategori_kes.id','=','spk__ikes.kategori_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                        ->leftJoin('ref__status_spk_ikes','ref__status_spk_ikes.id','=','spk__ikes.status')
                        ->where('spk__ikes.dihantar_by', '=', Auth::user()->user_id)
                        ->whereIN('spk__ikes.status',[2,3,4,5,6,7,8])
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
            return view('rt-sm21.senarai-permohonan-ikes',compact('roles_menu'));
        }
        
    }

    function post_permohonan_ikes(Request $request){
        
        $action = $request->post_permohonan_ikes;
        
        $rules = array(
           
        );

        $messages = [
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm21.senarai_permohonan_ikes'))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'add') {
                $ikes               = new SPK_ikes;
                $ikes->status       = 2;
                $ikes->dihantar_by  = Auth::user()->user_id;
                $ikes->save();
            }
           
            return Redirect::to(route('rt-sm21.permohonan_ikes',$ikes->id));
        }

    }

    function permohonan_ikes(Request $request, $id){
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
            } else if($type == 'get_sub_kategori') {
                $value = $request->value;
                $where = array('kategori_kes_id' => $value);
                $data  = DB::table('ref__spk_sub_kategori_kes')
                        ->select('ref__spk_sub_kategori_kes.id', 'ref__spk_sub_kategori_kes.kategori_kes_id', 'ref__spk_sub_kategori_kes.sub_kategori_description', 
                        'ref__spk_sub_kategori_kes.status')
                        ->where('ref__spk_sub_kategori_kes.kategori_kes_id', '=',  $where)
                        ->where('ref__spk_sub_kategori_kes.status', '=',  true)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_sub_kluster') {
                $value = $request->value;
                $where = array('kluster_id' => $value);
                $data  = DB::table('ref__spk_ikes_sub_kluster')
                        ->select('ref__spk_ikes_sub_kluster.id', 'ref__spk_ikes_sub_kluster.kluster_id', 'ref__spk_ikes_sub_kluster.subkluster_description', 
                        'ref__spk_ikes_sub_kluster.status')
                        ->where('ref__spk_ikes_sub_kluster.kluster_id', '=',  $where)
                        ->where('ref__spk_ikes_sub_kluster.status', '=',  true)
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
            $negeri                 = RefStates::where('status', '=', true)->get();
            $daerah                 = RefDaerah::where('status', '=', true)->get();
            $bandar                 = RefBandar::where('status', '=', true)->get();
            $parlimen               = RefParlimen::where('status', '=', true)->get();
            $dun                    = RefDUN::where('status', '=', true)->get();
            $pbt                    = RefPBT::where('status', '=', true)->get();
            $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
            $peringkat_kes          = Ref_Spk_Peringkat_Kes::where('status', '=', true)->get();
            $kategori_kes           = Ref_Spk_Kategori_Kes::where('status', '=', true)->get();
            $sub_kategori_kes       = Ref_Spk_Sub_Kategori_Kes::where('status', '=', true)->get();
            $kluster                = Ref_SPK_Ikes_Kluster::where('status', '=', true)->get();
            $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.sub_kategori_id',
                                            'spk__ikes.kluster_id',
                                            'spk__ikes.sub_kluster_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon',
                                            'ref__status_spk_ikes.status_description AS status_description',
                                            'spk__ikes.diakui_note AS diakui_note',
                                            'spk__ikes.disemak_note AS disemak_note',
                                            'spk__ikes.disahkan_note AS disahkan_note'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->leftJoin('ref__status_spk_ikes','ref__status_spk_ikes.id','=','spk__ikes.status')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm21.permohonan-ikes', compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'peringkat_kes', 
            'kategori_kes', 'sub_kategori_kes', 'kluster', 'ikes'));
        }
        
    }

    function post_permohonan_ikes_1(Request $request){
        $action = $request->post_permohonan_ikes_1;
        $app_id = $request->pi3_ikes_id;
        $hasKRT = $request->pi_hasRT;

        if ($hasKRT == '1') {
            $rules_main = array(                
                'pi_negeri_id'                  => 'required',
                'pi_daerah_id'                  => 'required',
                'pi_krt_profile_id'             => 'required',
                'pi1_dihantar_alamat'           => 'required',
                'pi2_negeri_id'                 => 'required',
                'pi2_bandar_id'                 => 'required',
                'pi2_ikes_lokasi'               => 'required',
                'pi2_parlimen_id'               => 'required',
                'pi2_pbt_id'                    => 'required',
                'pi2_ikes_tarikh_berlaku'       => 'required',
                'pi2_daerah_id'                 => 'required',
                'pi2_ikes_kawasan'              => 'required',
                'pi2_ikes_poskod'               => 'required',
                'pi2_dun_id'                    => 'required',
                'pi2_ikes_bpolis'               => 'required',
                'pi2_peringkat_kes_id'          => 'required',
                'pi2_kategori_kes_id'           => 'required',
                'pi2_sub_kategori_kes_id'       => 'required',
                'pi2_kluster_id'                => 'required',
                'pi2_sub_kluster_id'            => 'required',
                'pi2_ikes_keterangan_kes'       => 'required',
                'pi2_ikes_tindakan_awal'        => 'required',
                'pi2_ikes_sumber'               => 'required',
            );
        } else {
            $rules_main = array(
                'pi1_dihantar_alamat'           => 'required',
                'pi2_negeri_id'                 => 'required',
                'pi2_bandar_id'                 => 'required',
                'pi2_ikes_lokasi'               => 'required',
                'pi2_parlimen_id'               => 'required',
                'pi2_pbt_id'                    => 'required',
                'pi2_ikes_tarikh_berlaku'       => 'required',
                'pi2_daerah_id'                 => 'required',
                'pi2_ikes_kawasan'              => 'required',
                'pi2_ikes_poskod'               => 'required',
                'pi2_dun_id'                    => 'required',
                'pi2_ikes_bpolis'               => 'required',
                'pi2_peringkat_kes_id'          => 'required',
                'pi2_kategori_kes_id'           => 'required',
                'pi2_sub_kategori_kes_id'       => 'required',
                'pi2_kluster_id'                => 'required',
                'pi2_sub_kluster_id'            => 'required',
                'pi2_ikes_keterangan_kes'       => 'required',
                'pi2_ikes_tindakan_awal'        => 'required',
                'pi2_ikes_sumber'               => 'required',
            );
        }
        
        $messages = [
            'pi_negeri_id.required'             => 'Ruangan Negeri mesti dipilih',
            'pi_daerah_id.required'             => 'Ruangan Daerah mesti dipilih',
            'pi_krt_profile_id.required'        => 'Ruangan Nama KRT mesti dipilih',
            'pi1_dihantar_alamat.required'      => 'Ruangan Alamat Pejabat Pemohon mesti diisi',
            'pi2_negeri_id.required'            => 'Ruangan Negeri mesti dipilih',
            'pi2_bandar_id.required'            => 'Ruangan Bandar mesti dipilih',
            'pi2_ikes_lokasi.required'          => 'Ruangan Lokasi /  Nama Jalan mesti diisi',
            'pi2_parlimen_id.required'          => 'Ruangan Parlimen mesti dipilih',
            'pi2_pbt_id.required'               => 'Ruangan PBT mesti dipilih',
            'pi2_ikes_tarikh_berlaku.required'  => 'Ruangan Tarikh Berlaku mesti dipilih',
            'pi2_daerah_id.required'            => 'Ruangan Daerah mesti dipilih',
            'pi2_ikes_kawasan.required'         => 'Ruangan Taman / Kampung mesti diisi',
            'pi2_ikes_poskod.required'          => 'Ruangan Poskod mesti diisi',
            'pi2_dun_id.required'               => 'Ruangan Dun mesti dipilih',
            'pi2_ikes_bpolis.required'          => 'Ruangan Balai Polis mesti diisi',
            'pi2_peringkat_kes_id.required'     => 'Ruangan Peringkat Kes mesti dipilih',
            'pi2_kategori_kes_id.required'      => 'Ruangan Kategori Kes mesti dipilih',
            'pi2_sub_kategori_kes_id.required'  => 'Ruangan Sub Kategori Kes mesti dipilih',
            'pi2_kluster_id.required'           => 'Ruangan Kluster mesti dipilih',
            'pi2_sub_kluster_id.required'       => 'Ruangan Sub-kluster mesti dipilih',
            'pi2_ikes_keterangan_kes.required'  => 'Ruangan Keterangan Kes mesti diisi',
            'pi2_ikes_tindakan_awal.required'   => 'Ruangan Tindakan / Maklumbalas Awal JPNIN mesti diisi',
            'pi2_ikes_sumber.required'          => 'Ruangan Sumber mesti diisi',
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $carbon_obj                         = Carbon::createFromFormat('d/m/Y', $request->pi2_ikes_tarikh_berlaku)->format('Y-m-d');
                $update_ikes                        = SPK_ikes::where($where)->first();
                $update_ikes->hasRT                 = $hasKRT;
                $update_ikes->krt_profile_id        = $request->pi_krt_profile_id;
                $update_ikes->state_id              = $request->pi2_negeri_id;
                $update_ikes->daerah_id             = $request->pi2_daerah_id;
                $update_ikes->bandar_id             = $request->pi2_bandar_id;
                $update_ikes->ikes_kawasan          = $request->pi2_ikes_kawasan;
                $update_ikes->ikes_lokasi           = $request->pi2_ikes_lokasi;
                $update_ikes->ikes_poskod           = $request->pi2_ikes_poskod;
                $update_ikes->parlimen_id           = $request->pi2_parlimen_id;
                $update_ikes->dun_id                = $request->pi2_dun_id;
                $update_ikes->pbt_id                = $request->pi2_pbt_id;
                $update_ikes->ikes_bpolis           = $request->pi2_ikes_bpolis;
                $update_ikes->ikes_tarikh_berlaku   = $carbon_obj;
                $update_ikes->peringkat_id          = $request->pi2_peringkat_kes_id;
                $update_ikes->kategori_id           = $request->pi2_kategori_kes_id;
                $update_ikes->sub_kategori_id       = $request->pi2_sub_kategori_kes_id;
                $update_ikes->kluster_id            = $request->pi2_kluster_id;
                $update_ikes->sub_kluster_id        = $request->pi2_sub_kluster_id;
                $update_ikes->ikes_keterangan_kes   = $request->pi2_ikes_keterangan_kes;
                $update_ikes->ikes_tindakan_awal    = $request->pi2_ikes_tindakan_awal;
                $update_ikes->ikes_sumber           = $request->pi2_ikes_sumber;
                $update_ikes->dihantar_alamat       = $request->pi1_dihantar_alamat;
                $update_ikes->save();
                
            }
        }
    }

    function permohonan_ikes_1(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon',
                                            'ref__status_spk_ikes.status_description AS status_description',
                                            'spk__ikes.diakui_note AS diakui_note',
                                            'spk__ikes.disemak_note AS disemak_note',
                                            'spk__ikes.disahkan_note AS disahkan_note'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->leftJoin('ref__status_spk_ikes','ref__status_spk_ikes.id','=','spk__ikes.status')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.permohonan-ikes-1', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function get_ikes_bilangan_terlibat(Request $request, $id){
        $data = DB::table('spk__ikes_bilangan_terlibat')
                ->select('spk__ikes_bilangan_terlibat.*', 'ref__kaum.kaum_description')
                ->leftJoin('ref__kaum','ref__kaum.id','=','spk__ikes_bilangan_terlibat.kaum_id')
                ->where('spk__ikes_bilangan_terlibat.spk_ikes_id', '=', $id)
                ->get();
            return Datatables::of($data)
                ->make(true);
    }

    function add_add_bilangan_terlibat(Request $request){
        $action = $request->add_bilangan_terlibat;
        $app_id = $request->mabt_ikes_id;
        
        $rules = array(
            'mabt_kaum_id'                         => 'required',
            'mabt_jumlah_terlibat'                 => 'required',
        );

        $messages = [
            'mabt_kaum_id.required'                => 'Ruangan Etnik mesti dipilih',
            'mabt_jumlah_terlibat.required'        => 'Ruangan Jumlah Yang Terlibat mesti diisi',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $bilangan_terlibat = new SPK_ikes_bilangan_terlibat;
                $bilangan_terlibat->spk_ikes_id                 = $app_id;
                $bilangan_terlibat->kaum_id                     = $request->mabt_kaum_id;
                $bilangan_terlibat->jumlah_bilangan_terlibat    = $request->mabt_jumlah_terlibat;
                $bilangan_terlibat->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_ikes_bilangan_terlibat($id){
        $data = DB::table('spk__ikes_bilangan_terlibat')->where('id', '=', $id)->delete();
    }

    function get_ikes_bilangan_cedera(Request $request, $id){
        $data = DB::table('spk__ikes_bilangan_cedera')
                ->select('spk__ikes_bilangan_cedera.*', 'ref__kaum.kaum_description')
                ->leftJoin('ref__kaum','ref__kaum.id','=','spk__ikes_bilangan_cedera.kaum_id')
                ->where('spk__ikes_bilangan_cedera.spk_ikes_id', '=', $id)
                ->get();
            return Datatables::of($data)
                ->make(true);
    }

    function add_bilangan_cedera(Request $request){
        $action = $request->add_bilangan_cedera;
        $app_id = $request->mabc_ikes_id;
        
        $rules = array(
            'mabc_kaum_id'                         => 'required',
            'mabc_jumlah_cedera_ringan'            => 'required',
        );

        $messages = [
            'mabc_kaum_id.required'                => 'Ruangan Etnik mesti dipilih',
            'mabc_jumlah_cedera_ringan.required'   => 'Ruangan Jumlah Cedera Ringan mesti diisi',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $bilangan_cedera_ringan = new SPK_ikes_bilangan_cedera;
                $bilangan_cedera_ringan->spk_ikes_id                = $app_id;
                $bilangan_cedera_ringan->kaum_id                    = $request->mabc_kaum_id;
                $bilangan_cedera_ringan->jumlah_cedera_ringan       = $request->mabc_jumlah_cedera_ringan;
                $bilangan_cedera_ringan->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_ikes_bilangan_cedera_ringan($id){
        $data = DB::table('spk__ikes_bilangan_cedera')->where('id', '=', $id)->delete();
    }

    function get_ikes_bilangan_cedera_parah(Request $request, $id){
        $data = DB::table('spk__ikes_bilangan_cedera_parah')
                ->select('spk__ikes_bilangan_cedera_parah.*', 'ref__kaum.kaum_description')
                ->leftJoin('ref__kaum','ref__kaum.id','=','spk__ikes_bilangan_cedera_parah.kaum_id')
                ->where('spk__ikes_bilangan_cedera_parah.spk_ikes_id', '=', $id)
                ->get();
            return Datatables::of($data)
                ->make(true);
    }

    function add_bilangan_cedera_parah(Request $request){
        $action = $request->add_bilangan_cedera_parah;
        $app_id = $request->mabcp_ikes_id;
        
        $rules = array(
            'mabcp_kaum_id'                        => 'required',
            'mabcp_jumlah_cedera_parah'            => 'required',
        );

        $messages = [
            'mabcp_kaum_id.required'               => 'Ruangan Etnik mesti dipilih',
            'mabcp_jumlah_cedera_parah.required'   => 'Ruangan Jumlah Cedera Ringan mesti diisi',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $bilangan_cedera_parah = new SPK_ikes_bilangan_cedera_parah;
                $bilangan_cedera_parah->spk_ikes_id               = $app_id;
                $bilangan_cedera_parah->kaum_id                   = $request->mabcp_kaum_id;
                $bilangan_cedera_parah->jumlah_cedera_parah       = $request->mabcp_jumlah_cedera_parah;
                $bilangan_cedera_parah->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_ikes_bilangan_cedera_parah($id){
        $data = DB::table('spk__ikes_bilangan_cedera_parah')->where('id', '=', $id)->delete();
    }

    function get_ikes_bilangan_kematian(Request $request, $id){
        $data = DB::table('spk__ikes_bilangan_kematian')
                ->select('spk__ikes_bilangan_kematian.*', 'ref__kaum.kaum_description')
                ->leftJoin('ref__kaum','ref__kaum.id','=','spk__ikes_bilangan_kematian.kaum_id')
                ->where('spk__ikes_bilangan_kematian.spk_ikes_id', '=', $id)
                ->get();
            return Datatables::of($data)
                ->make(true);
    }

    function add_bilangan_kematian(Request $request){
        $action = $request->add_bilangan_kematian;
        $app_id = $request->mabk_ikes_id;
        
        $rules = array(
            'mabk_kaum_id'                      => 'required',
            'mabk_jumlah_kematian'              => 'required',
        );

        $messages = [
            'mabk_kaum_id.required'             => 'Ruangan Etnik mesti dipilih',
            'mabk_jumlah_kematian.required'     => 'Ruangan Jumlah Kematian mesti diisi',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $bilangan_kematian = new SPK_ikes_bilangan_kematian;
                $bilangan_kematian->spk_ikes_id           = $app_id;
                $bilangan_kematian->kaum_id               = $request->mabk_kaum_id;
                $bilangan_kematian->jumlah_kematian       = $request->mabk_jumlah_kematian;
                $bilangan_kematian->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_ikes_bilangan_kematian($id){
        $data = DB::table('spk__ikes_bilangan_kematian')->where('id', '=', $id)->delete();
    }

    function post_permohonan_ikes_2(Request $request){
        $action = $request->post_permohonan_ikes_2;
        $app_id = $request->pi5_ikes_id;
        
        $rules_main = array(                
            'pi4_ikes_bil_terlibat'                 => 'required',
            'pi4_status_etnik_id'                   => 'required',
            'pi4_status_warganegara_id'             => 'required',
            'pi4_ikes_bil_tangkapan'                => 'required',
        );
        
        $messages = [
            'pi4_ikes_bil_terlibat.required'        => 'Ruangan Bilangan Terlibat mesti diisi',
            'pi4_status_etnik_id.required'          => 'Ruangan Antara Etnik mesti dipilih',
            'pi4_status_warganegara_id.required'    => 'Ruangan Pilihan Warganegara mesti dipilih',
            'pi4_ikes_bil_tangkapan.required'       => 'Ruangan Bilangan Tangkapan Polis mesti diisi',
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                
                $update_ikes_1                          = SPK_ikes::where($where)->first();
                $update_ikes_1->ikes_bil_terlibat       = $request->pi4_ikes_bil_terlibat;
                $update_ikes_1->status_etnik_id         = $request->pi4_status_etnik_id;
                $update_ikes_1->status_warganegara_id   = $request->pi4_status_warganegara_id;
                $update_ikes_1->ikes_bil_tangkapan      = $request->pi4_ikes_bil_tangkapan;
                $update_ikes_1->save();
                
            }
        }
    }

    function permohonan_ikes_2(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon',
                                            'ref__status_spk_ikes.status_description AS status_description',
                                            'spk__ikes.diakui_note AS diakui_note',
                                            'spk__ikes.disemak_note AS disemak_note',
                                            'spk__ikes.disahkan_note AS disahkan_note'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->leftJoin('ref__status_spk_ikes','ref__status_spk_ikes.id','=','spk__ikes.status')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.permohonan-ikes-2', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function get_bentuk_tindakan_table(Request $request, $id){
        return DataTables()->of(
            DB::select(DB::raw("
                SELECT
                ref__spk_ikes_tindakan.id, ref__spk_ikes_tindakan.tindakan_description, ref__spk_ikes_tindakan.status, spk__ikes_tindakan.id AS spk_ikes_tindakan_id, spk__ikes_tindakan.spk_ikes_id, spk__ikes_tindakan.ref_spk_tindakan_id
                FROM
                ref__spk_ikes_tindakan
                LEFT JOIN spk__ikes_tindakan ON spk__ikes_tindakan.ref_spk_tindakan_id = ref__spk_ikes_tindakan.id
                AND spk__ikes_tindakan.spk_ikes_id ='" . $id . "'
                ORDER BY ref__spk_ikes_tindakan.id + 0 ASC
            "))
        )->make();
    }

    function post_ikes_tindakan(Request $request){
        $pi6_spk_ikes_id        = $request->pi6_spk_ikes_id;
        $spk_ikes_tindakan_id   = $request->spk_ikes_tindakan_id;
        
        $ikes_tindakan                          = new SPK_ikes_tindakan;
        $ikes_tindakan->spk_ikes_id             = $pi6_spk_ikes_id;
        $ikes_tindakan->ref_spk_tindakan_id     = $request->spk_ikes_tindakan_id;
        $ikes_tindakan->save();

    }

    function post_delete_ikes_tindakan(Request $request){
        $pi6_spk_ikes_id        = $request->pi6_spk_ikes_id;
        $spk_ikes_tindakan_id   = $request->spk_ikes_tindakan_id;

        $data = DB::table('spk__ikes_tindakan')
                ->where('spk_ikes_id', '=', $pi6_spk_ikes_id)
                ->where('ref_spk_tindakan_id', '=', $spk_ikes_tindakan_id)
                ->delete();
        
    }

    function get_bentuk_terlibat_table(Request $request, $id){
        return DataTables()->of(
            DB::select(DB::raw("
                SELECT
                ref__spk_ikes_terlibat.id, ref__spk_ikes_terlibat.pihak_description, ref__spk_ikes_terlibat.status, spk__ikes_terlibat.id AS spk_ikes_terlibat_id, spk__ikes_terlibat.spk_ikes_id, spk__ikes_terlibat.ref_spk_terlibat_id
                FROM
                ref__spk_ikes_terlibat
                LEFT JOIN spk__ikes_terlibat ON spk__ikes_terlibat.ref_spk_terlibat_id = ref__spk_ikes_terlibat.id
                AND spk__ikes_terlibat.spk_ikes_id ='" . $id . "'
                ORDER BY ref__spk_ikes_terlibat.id + 0 ASC
            "))
        )->make();
    }

    function post_ikes_terlibat(Request $request){
        $pi6_spk_ikes_id        = $request->pi6_spk_ikes_id;
        $spk_ikes_terlibat_id   = $request->spk_ikes_terlibat_id;
        
        $ikes_terlibat                          = new SPK_ikes_terlibat;
        $ikes_terlibat->spk_ikes_id             = $pi6_spk_ikes_id;
        $ikes_terlibat->ref_spk_terlibat_id     = $request->spk_ikes_terlibat_id;
        $ikes_terlibat->save();

    }

    function post_delete_ikes_terlibat(Request $request){
        $pi6_spk_ikes_id        = $request->pi6_spk_ikes_id;
        $spk_ikes_terlibat_id   = $request->spk_ikes_terlibat_id;

        $data = DB::table('spk__ikes_terlibat')
                ->where('spk_ikes_id', '=', $pi6_spk_ikes_id)
                ->where('ref_spk_terlibat_id', '=', $spk_ikes_terlibat_id)
                ->delete();
        
    }
    
    function post_permohonan_ikes_3(Request $request){
        $action = $request->post_permohonan_ikes_3;
        $app_id = $request->pi7_ikes_id;
        
        $rules_main = array(                
            'pi6_ikes_keterangan_tindakan'          => 'required',
        );
        
        $messages = [
            'pi6_ikes_keterangan_tindakan.required' => 'Ruangan Keterangan Tindakan Penyelesaian mesti diisi',
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                
                $update_ikes_2                              = SPK_ikes::where($where)->first();
                $update_ikes_2->hasTindakan                 = $request->pi6_hasTindakan;
                $update_ikes_2->ikes_keterangan_tindakan    = $request->pi6_ikes_keterangan_tindakan;
                $update_ikes_2->save();
                
            }
        }
    }

    function permohonan_ikes_3(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon',
                                            'ref__status_spk_ikes.status_description AS status_description',
                                            'spk__ikes.diakui_note AS diakui_note',
                                            'spk__ikes.disemak_note AS disemak_note',
                                            'spk__ikes.disahkan_note AS disahkan_note'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->leftJoin('ref__status_spk_ikes','ref__status_spk_ikes.id','=','spk__ikes.status')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.permohonan-ikes-3', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function get_ikes_kedudukan(Request $request, $id){
        $data = DB::table('spk__ikes_kedudukan')
                ->select('spk__ikes_kedudukan.*')
                ->where('spk__ikes_kedudukan.spk_ikes_id', '=', $id)
                ->get();
            return Datatables::of($data)
                ->make(true);
    }

    function add_kedudukan_kes(Request $request){
        $action = $request->add_kedudukan_kes;
        $app_id = $request->makk_ikes_id;
        
        $rules = array(
            'makk_jenis_harta'                          => 'required',
            'makk_nilai_anggaran_kerosakan'             => 'required',
        );

        $messages = [
            'makk_jenis_harta.required'                 => 'Ruangan Jenis / Nama Harta Benda yang Musnah mesti diisi',
            'makk_nilai_anggaran_kerosakan.required'    => 'Ruangan Nilai Anggaran Kerosakan mesti diisi',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $kedudukan_kes = new SPK_ikes_kedudukan;
                $kedudukan_kes->spk_ikes_id                 = $app_id;
                $kedudukan_kes->jenis_harta                 = $request->makk_jenis_harta;
                $kedudukan_kes->nilai_anggaran_kerosakan    = $request->makk_nilai_anggaran_kerosakan;
                $kedudukan_kes->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_kedudukan_kes($id){
        $data = DB::table('spk__ikes_kedudukan')->where('id', '=', $id)->delete();
    }

    function get_dokument_kes_table(Request $request, $id){
        $data = DB::table('spk__ikes_dokument')
                ->select('spk__ikes_dokument.*')
                ->where('spk__ikes_dokument.spk_ikes_id', '=', $id)
                ->get();
        return Datatables::of($data)
                ->make(true);
    }

    function add_spk_ikes_dokument(Request $request){
        $action = $request->add_spk_ikes_dokument;
        $app_id = $request->pi9_spk_ikes_id;
        
       

        $rules = array(
            'pi9_file_title'                => 'required',
            'pi9_file_catatan'              => 'required',
            'pi9_file_dokument'             => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:5000'
        );

        $messages = [
            'pi9_file_title.required'       => 'Ruangan Tajuk Fail Mesti Diisi',
            'pi9_file_catatan.required'     => 'Ruangan Catatan Fail Mesti Diisi',
            'pi9_file_dokument.required'    => 'Ruangan Fail Mesti Dipilih',
            'pi9_file_dokument.mimes'       => 'Fail Mesti Dipilih Dalam Format jpeg,png,jpg,gif,svg,pdf',
            'pi9_file_dokument.max'         => 'Fail mesti dalam sive 5000KB',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            
            if ($action == 'add') {
                $fileName = $request->pi9_file_dokument->getClientOriginalName();
                $request->pi9_file_dokument->storeAs('public/ikes_dokument',$fileName);
                $ikes_dokument = new SPK_ikes_dokument;
                $ikes_dokument->spk_ikes_id     = $app_id;
                $ikes_dokument->file_title      = $request->pi9_file_title;
                $ikes_dokument->file_catatan    = $request->pi9_file_catatan;
                $ikes_dokument->file_dokument   = $fileName;
                $ikes_dokument->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function get_data_ikes_dokument($id){
        $data = DB::table('spk__ikes_dokument')
                ->select('spk__ikes_dokument.id', 
                    'spk__ikes_dokument.file_dokument AS file_dokument' )
                ->where('spk__ikes_dokument.id', '=', $id)
                ->first();
        return Response::json($data);
    }

    function delete_dokument_kes($id){
        $data = DB::table('spk__ikes_dokument')->where('id', '=', $id)->delete();
    }

    function post_permohonan_ikes_4_back(Request $request){
        $action = $request->post_permohonan_ikes_4;
        $app_id = $request->pi10_ikes_id;
        
        $rules_main = array(                
            'pi8_ikes_keadaan_semasa'               => 'required',
            'pi8_ikes_jangkaan_keadaan'             => 'required',
        );
        
        $messages = [
            'pi8_ikes_keadaan_semasa.required'      => 'Ruangan Keadaan Semasa mesti diisi',
            'pi8_ikes_jangkaan_keadaan.required'    => 'Ruangan Jangkaan keadaan pada masa akan datang mesti diisi',
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                
                $update_ikes_4                              = SPK_ikes::where($where)->first();
                $update_ikes_4->ikes_keadaan_semasa         = $request->pi8_ikes_keadaan_semasa;
                $update_ikes_4->ikes_jangkaan_keadaan       = $request->pi8_ikes_jangkaan_keadaan;
                $update_ikes_4->save();
                
            }
        }
    }

    function post_permohonan_ikes_4(Request $request){
        $action = $request->post_permohonan_ikes_4;
        $app_id = $request->pi10_ikes_id;
        
        $rules_main = array(                
            'pi8_ikes_keadaan_semasa'               => 'required',
            'pi8_ikes_jangkaan_keadaan'             => 'required',
        );
        
        $messages = [
            'pi8_ikes_keadaan_semasa.required'      => 'Ruangan Keadaan Semasa mesti diisi',
            'pi8_ikes_jangkaan_keadaan.required'    => 'Ruangan Jangkaan keadaan pada masa akan datang mesti diisi',
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                
                $update_ikes_3                              = SPK_ikes::where($where)->first();
                $update_ikes_3->ikes_keadaan_semasa         = $request->pi8_ikes_keadaan_semasa;
                $update_ikes_3->ikes_jangkaan_keadaan       = $request->pi8_ikes_jangkaan_keadaan;
                $update_ikes_3->status                      = 3;
                $update_ikes_3->dihantar_date               = date('Y-m-d H:i:s');
                $update_ikes_3->save();
                
            }
        }
    }

    function senarai_akuan_permohonan_ikes_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('spk__ikes')
                        ->select('spk__ikes.id AS id',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'ref__spk_peringkat_kes.peringkat_description AS peringkat_description',
                                'ref__spk_kategori_kes.kategori_description AS kategori_description',
                                'users__profile.user_fullname AS user_fullname',
                                'ref__status_spk_ikes.status_description AS status_description',
                                'spk__ikes.status AS status')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','spk__ikes.daerah_id')
                        ->leftJoin('ref__spk_peringkat_kes','ref__spk_peringkat_kes.id','=','spk__ikes.peringkat_id')
                        ->leftJoin('ref__spk_kategori_kes','ref__spk_kategori_kes.id','=','spk__ikes.kategori_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                        ->leftJoin('ref__status_spk_ikes','ref__status_spk_ikes.id','=','spk__ikes.status')
                        ->where('spk__ikes.state_id', '=', Auth::user()->state_id)
                        ->whereIN('spk__ikes.status',[3])
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
            return view('rt-sm21.senarai-akuan-permohonan-ikes-ppn',compact('roles_menu','daerah'));
        }
    }

    function akuan_permohonan_ikes_ppn(Request $request, $id){
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
            $peringkat_kes          = Ref_Spk_Peringkat_Kes::where('status', '=', true)->get();
            $kategori_kes           = Ref_Spk_Kategori_Kes::where('status', '=', true)->get();
            $sub_kategori_kes       = Ref_Spk_Sub_Kategori_Kes::where('status', '=', true)->get();
            $kluster                = Ref_SPK_Ikes_Kluster::where('status', '=', true)->get();
            $sub_kluster            = Ref_SPK_Ikes_Sub_Kluster::where('status', '=', true)->get();
            $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.sub_kategori_id',
                                            'spk__ikes.kluster_id',
                                            'spk__ikes.sub_kluster_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm21.akuan-permohonan-ikes-ppn', compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'peringkat_kes', 'kategori_kes', 
            'sub_kategori_kes', 'kluster', 'sub_kluster', 'ikes'));
        }
    }

    function akuan_permohonan_ikes_ppn_1(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.akuan-permohonan-ikes-ppn-1', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function akuan_permohonan_ikes_ppn_2(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.akuan-permohonan-ikes-ppn-2', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function akuan_permohonan_ikes_ppn_3(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.akuan-permohonan-ikes-ppn-3', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function post_akui_permohonan_ikes(Request $request){
        $action = $request->post_akui_permohonan_ikes;
        $app_id = $request->apipn3_spk_ikes_id;
        
        
        $rules = array(
            'apipn3_ikes_status'                => 'required',
            'apipn3_diakui_note'                => 'required',
        );

        $messages = [
            'apipn3_ikes_status.required'       => 'Ruangan Status dipilih',
            'apipn3_diakui_note.required'       => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $akui_permohonan_ikes                   = SPK_ikes::where($where)->first();
                $akui_permohonan_ikes->status           = $request->apipn3_ikes_status;
                $akui_permohonan_ikes->diakui_by        = Auth::user()->user_id;
                $akui_permohonan_ikes->diakui_date      = date('Y-m-d H:i:s');
                $akui_permohonan_ikes->diakui_note      = $request->apipn3_diakui_note;
                $akui_permohonan_ikes->save();
            }
        }
    }

    function senarai_semakan_permohonan_ikes_bpp(Request $request){
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
            $data = DB::table('spk__ikes')
                        ->select('spk__ikes.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'ref__spk_peringkat_kes.peringkat_description AS peringkat_description',
                                'ref__spk_kategori_kes.kategori_description AS kategori_description',
                                'ref__spk_ikes_kluster.kluster_description AS kluster_description',
                                'users__profile.user_fullname AS user_fullname',
                                'ref__status_spk_ikes.status_description AS status_description',
                                'spk__ikes.status AS status')
                        ->leftJoin('ref__states','ref__states.state_id','=','spk__ikes.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','spk__ikes.daerah_id')
                        ->leftJoin('ref__spk_peringkat_kes','ref__spk_peringkat_kes.id','=','spk__ikes.peringkat_id')
                        ->leftJoin('ref__spk_kategori_kes','ref__spk_kategori_kes.id','=','spk__ikes.kategori_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                        ->leftJoin('ref__status_spk_ikes','ref__status_spk_ikes.id','=','spk__ikes.status')
                        ->leftJoin('ref__spk_ikes_kluster','ref__spk_ikes_kluster.id','=','spk__ikes.kluster_id')
                        ->whereIN('spk__ikes.status',[4,9])
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
            return view('rt-sm21.senarai-semakan-permohonan-ikes-bpp',compact('roles_menu','state'));
        }
    }

    function semakan_permohonan_ikes_bpp(Request $request, $id){
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
            $peringkat_kes          = Ref_Spk_Peringkat_Kes::where('status', '=', true)->get();
            $kategori_kes           = Ref_Spk_Kategori_Kes::where('status', '=', true)->get();
            $sub_kategori_kes       = Ref_Spk_Sub_Kategori_Kes::where('status', '=', true)->get();
            $kluster                = Ref_SPK_Ikes_Kluster::where('status', '=', true)->get();
            $sub_kluster            = Ref_SPK_Ikes_Sub_Kluster::where('status', '=', true)->get();
            $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.sub_kategori_id',
                                            'spk__ikes.kluster_id',
                                            'spk__ikes.sub_kluster_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm21.semakan-permohonan-ikes-bpp', compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'peringkat_kes', 'kategori_kes', 
            'sub_kategori_kes', 'kluster', 'sub_kluster', 'ikes'));
        }
    }

    function semakan_permohonan_ikes_bpp_1(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.semakan-permohonan-ikes-bpp-1', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function semakan_permohonan_ikes_bpp_2(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.semakan-permohonan-ikes-bpp-2', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function semakan_permohonan_ikes_bpp_3(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.semakan-permohonan-ikes-bpp-3', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function post_semakan_permohonan_ikes(Request $request){
        $action = $request->post_semakan_permohonan_ikes;
        $app_id = $request->apipn3_spk_ikes_id;
        
        
        $rules = array(
            'apipn3_ikes_status'                => 'required',
            'apipn3_disemak_note'               => 'required',
        );

        $messages = [
            'apipn3_ikes_status.required'       => 'Ruangan Status dipilih',
            'apipn3_disemak_note.required'      => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $semakan_permohonan_ikes                    = SPK_ikes::where($where)->first();
                $semakan_permohonan_ikes->status            = $request->apipn3_ikes_status;
                $semakan_permohonan_ikes->disemak_by        = Auth::user()->user_id;
                $semakan_permohonan_ikes->disemak_date      = date('Y-m-d H:i:s');
                $semakan_permohonan_ikes->disemak_note      = $request->apipn3_disemak_note;
                $semakan_permohonan_ikes->save();
            }
        }
    }

    function senarai_sahkan_permohonan_ikes_p(Request $request){
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
            $data = DB::table('spk__ikes')
                        ->select('spk__ikes.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'ref__spk_peringkat_kes.peringkat_description AS peringkat_description',
                                'ref__spk_kategori_kes.kategori_description AS kategori_description',
                                'ref__spk_ikes_kluster.kluster_description AS kluster_description',
                                'users__profile.user_fullname AS user_fullname',
                                'ref__status_spk_ikes.status_description AS status_description',
                                'spk__ikes.status AS status')
                         ->leftJoin('ref__states','ref__states.state_id','=','spk__ikes.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','spk__ikes.daerah_id')
                        ->leftJoin('ref__spk_peringkat_kes','ref__spk_peringkat_kes.id','=','spk__ikes.peringkat_id')
                        ->leftJoin('ref__spk_kategori_kes','ref__spk_kategori_kes.id','=','spk__ikes.kategori_id')
                        ->leftJoin('ref__spk_ikes_kluster','ref__spk_ikes_kluster.id','=','spk__ikes.kluster_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                        ->leftJoin('ref__status_spk_ikes','ref__status_spk_ikes.id','=','spk__ikes.status')
                        ->whereIN('spk__ikes.status',[6,10,13])
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
            return view('rt-sm21.senarai-sahkan-permohonan-ikes-p',compact('roles_menu','state'));
        }
    }

    function sahkan_permohonan_ikes_p(Request $request, $id){
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
            $peringkat_kes          = Ref_Spk_Peringkat_Kes::where('status', '=', true)->get();
            $kategori_kes           = Ref_Spk_Kategori_Kes::where('status', '=', true)->get();
            $sub_kategori_kes       = Ref_Spk_Sub_Kategori_Kes::where('status', '=', true)->get();
            $kluster                = Ref_SPK_Ikes_Kluster::where('status', '=', true)->get();
            $sub_kluster            = Ref_SPK_Ikes_Sub_Kluster::where('status', '=', true)->get();
            $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.sub_kategori_id',
                                            'spk__ikes.kluster_id',
                                            'spk__ikes.sub_kluster_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm21.sahkan-permohonan-ikes-p', compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'peringkat_kes', 'kategori_kes', 
            'sub_kategori_kes', 'kluster', 'sub_kluster', 'ikes'));
        }
    }

    function sahkan_permohonan_ikes_p_1(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.sahkan-permohonan-ikes-p-1', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function sahkan_permohonan_ikes_p_2(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.sahkan-permohonan-ikes-p-2', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function sahkan_permohonan_ikes_p_3(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.sahkan-permohonan-ikes-p-3', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function post_pengesahan_permohonan_ikes(Request $request){
        $action = $request->post_pengesahan_permohonan_ikes;
        $app_id = $request->apipn3_spk_ikes_id;
        
        
        $rules = array(
            'apipn3_ikes_status'                => 'required',
            'apipn3_disahkan_note'              => 'required',
        );

        $messages = [
            'apipn3_ikes_status.required'       => 'Ruangan Status dipilih',
            'apipn3_disahkan_note.required'     => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $pengesahan_permohonan_ikes                    = SPK_ikes::where($where)->first();
                $pengesahan_permohonan_ikes->status            = $request->apipn3_ikes_status;
                $pengesahan_permohonan_ikes->disahkan_by       = Auth::user()->user_id;
                $pengesahan_permohonan_ikes->disahkan_date     = date('Y-m-d H:i:s');
                $pengesahan_permohonan_ikes->disahkan_note     = $request->apipn3_disahkan_note;
                $pengesahan_permohonan_ikes->save();
            }
        }
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function senarai_permohonan_ikes_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('spk__ikes')
                        ->select('spk__ikes.id AS id',
                                'ref__spk_peringkat_kes.peringkat_description AS peringkat_description',
                                'ref__spk_kategori_kes.kategori_description AS kategori_description',
                                'users__profile.user_fullname AS user_fullname',
                                'ref__status_spk_ikes.status_description AS status_description',
                                'spk__ikes.status AS status')
                        ->leftJoin('ref__spk_peringkat_kes','ref__spk_peringkat_kes.id','=','spk__ikes.peringkat_id')
                        ->leftJoin('ref__spk_kategori_kes','ref__spk_kategori_kes.id','=','spk__ikes.kategori_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                        ->leftJoin('ref__status_spk_ikes','ref__status_spk_ikes.id','=','spk__ikes.status')
                        ->where('spk__ikes.dihantar_by', '=', Auth::user()->user_id)
                        ->whereIN('spk__ikes.status',[2,9,10,11,12])
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
            return view('rt-sm21.senarai-permohonan-ikes-ppn',compact('roles_menu'));
        }
    }

    function post_permohonan_ikes_ppn(Request $request){
        
        $action = $request->post_permohonan_ikes_ppn;
        
        $rules = array(
           
        );

        $messages = [
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm21.senarai_permohonan_ikes_ppn'))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'add') {
                $ikes_ppn               = new SPK_ikes;
                $ikes_ppn->status       = 2;
                $ikes_ppn->dihantar_by  = Auth::user()->user_id;
                $ikes_ppn->save();
            }
           
            return Redirect::to(route('rt-sm21.permohonan_ikes_ppn',$ikes_ppn->id));
        }

    }

    function permohonan_ikes_ppn(Request $request, $id){
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
            } else if($type == 'get_sub_kategori') {
                $value = $request->value;
                $where = array('kategori_kes_id' => $value);
                $data  = DB::table('ref__spk_sub_kategori_kes')
                        ->select('ref__spk_sub_kategori_kes.id', 'ref__spk_sub_kategori_kes.kategori_kes_id', 'ref__spk_sub_kategori_kes.sub_kategori_description', 
                        'ref__spk_sub_kategori_kes.status')
                        ->where('ref__spk_sub_kategori_kes.kategori_kes_id', '=',  $where)
                        ->where('ref__spk_sub_kategori_kes.status', '=',  true)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_sub_kluster') {
                $value = $request->value;
                $where = array('kluster_id' => $value);
                $data  = DB::table('ref__spk_ikes_sub_kluster')
                        ->select('ref__spk_ikes_sub_kluster.id', 'ref__spk_ikes_sub_kluster.kluster_id', 'ref__spk_ikes_sub_kluster.subkluster_description', 
                        'ref__spk_ikes_sub_kluster.status')
                        ->where('ref__spk_ikes_sub_kluster.kluster_id', '=',  $where)
                        ->where('ref__spk_ikes_sub_kluster.status', '=',  true)
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
            $negeri                 = RefStates::where('status', '=', true)->get();
            $daerah                 = RefDaerah::where('status', '=', true)->get();
            $bandar                 = RefBandar::where('status', '=', true)->get();
            $parlimen               = RefParlimen::where('status', '=', true)->get();
            $dun                    = RefDUN::where('status', '=', true)->get();
            $pbt                    = RefPBT::where('status', '=', true)->get();
            $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
            $peringkat_kes          = Ref_Spk_Peringkat_Kes::where('status', '=', true)->get();
            $kategori_kes           = Ref_Spk_Kategori_Kes::where('status', '=', true)->get();
            $sub_kategori_kes       = Ref_Spk_Sub_Kategori_Kes::where('status', '=', true)->get();
            $kluster                = Ref_SPK_Ikes_Kluster::where('status', '=', true)->get();
            $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.sub_kategori_id',
                                            'spk__ikes.kluster_id',
                                            'spk__ikes.sub_kluster_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon',
                                            'ref__status_spk_ikes.status_description AS status_description',
                                            'spk__ikes.diakui_note AS diakui_note',
                                            'spk__ikes.disemak_note AS disemak_note',
                                            'spk__ikes.disahkan_note AS disahkan_note'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->leftJoin('ref__status_spk_ikes','ref__status_spk_ikes.id','=','spk__ikes.status')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm21.permohonan-ikes-ppn', compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'peringkat_kes', 'kategori_kes', 'sub_kategori_kes', 'kluster', 'ikes'));
        }
        
    }

    function post_permohonan_ikes_ppn_1(Request $request){
        $action = $request->post_permohonan_ikes_ppn_1;
        $app_id = $request->pipn3_ikes_id;
        $hasKRT = $request->pipn_hasRT;

        if ($hasKRT == '1') {
            $rules_main = array(                
                'pipn_negeri_id'                  => 'required',
                'pipn_daerah_id'                  => 'required',
                'pipn_krt_profile_id'             => 'required',
                'pipn1_dihantar_alamat'           => 'required',
                'pipn2_negeri_id'                 => 'required',
                'pipn2_bandar_id'                 => 'required',
                'pipn2_ikes_lokasi'               => 'required',
                'pipn2_parlimen_id'               => 'required',
                'pipn2_pbt_id'                    => 'required',
                'pipn2_ikes_tarikh_berlaku'       => 'required',
                'pipn2_daerah_id'                 => 'required',
                'pipn2_ikes_kawasan'              => 'required',
                'pipn2_ikes_poskod'               => 'required',
                'pipn2_dun_id'                    => 'required',
                'pipn2_ikes_bpolis'               => 'required',
                'pipn2_peringkat_kes_id'          => 'required',
                'pipn2_kategori_kes_id'           => 'required',
                'pipn2_sub_kategori_kes_id'       => 'required',
                'pipn2_kluster_id'                => 'required',
                'pipn2_sub_kluster_id'            => 'required',
                'pipn2_ikes_keterangan_kes'       => 'required',
                'pipn2_ikes_tindakan_awal'        => 'required',
                'pipn2_ikes_sumber'               => 'required',
            );
        } else {
            $rules_main = array(
                'pipn1_dihantar_alamat'           => 'required',
                'pipn2_negeri_id'                 => 'required',
                'pipn2_bandar_id'                 => 'required',
                'pipn2_ikes_lokasi'               => 'required',
                'pipn2_parlimen_id'               => 'required',
                'pipn2_pbt_id'                    => 'required',
                'pipn2_ikes_tarikh_berlaku'       => 'required',
                'pipn2_daerah_id'                 => 'required',
                'pipn2_ikes_kawasan'              => 'required',
                'pipn2_ikes_poskod'               => 'required',
                'pipn2_dun_id'                    => 'required',
                'pipn2_ikes_bpolis'               => 'required',
                'pipn2_peringkat_kes_id'          => 'required',
                'pipn2_kategori_kes_id'           => 'required',
                'pipn2_sub_kategori_kes_id'       => 'required',
                'pipn2_kluster_id'                => 'required',
                'pipn2_sub_kluster_id'            => 'required',
                'pipn2_ikes_keterangan_kes'       => 'required',
                'pipn2_ikes_tindakan_awal'        => 'required',
                'pipn2_ikes_sumber'               => 'required',
            );
        }
        
        $messages = [
            'pipn_negeri_id.required'             => 'Ruangan Negeri mesti dipilih',
            'pipn_daerah_id.required'             => 'Ruangan Daerah mesti dipilih',
            'pipn_krt_profile_id.required'        => 'Ruangan Nama KRT mesti dipilih',
            'pipn1_dihantar_alamat.required'      => 'Ruangan Alamat Pejabat Pemohon mesti diisi',
            'pipn2_negeri_id.required'            => 'Ruangan Negeri mesti dipilih',
            'pipn2_bandar_id.required'            => 'Ruangan Bandar mesti dipilih',
            'pipn2_ikes_lokasi.required'          => 'Ruangan Lokasi /  Nama Jalan mesti diisi',
            'pipn2_parlimen_id.required'          => 'Ruangan Parlimen mesti dipilih',
            'pipn2_pbt_id.required'               => 'Ruangan PBT mesti dipilih',
            'pipn2_ikes_tarikh_berlaku.required'  => 'Ruangan Tarikh Berlaku mesti dipilih',
            'pipn2_daerah_id.required'            => 'Ruangan Daerah mesti dipilih',
            'pipn2_ikes_kawasan.required'         => 'Ruangan Taman / Kampung mesti diisi',
            'pipn2_ikes_poskod.required'          => 'Ruangan Poskod mesti diisi',
            'pipn2_dun_id.required'               => 'Ruangan Dun mesti dipilih',
            'pipn2_ikes_bpolis.required'          => 'Ruangan Balai Polis mesti diisi',
            'pipn2_peringkat_kes_id.required'     => 'Ruangan Peringkat Kes mesti dipilih',
            'pipn2_kategori_kes_id.required'      => 'Ruangan Kategori Kes mesti dipilih',
            'pipn2_sub_kategori_kes_id.required'  => 'Ruangan Sub Kategori Kes mesti dipilih',
            'pipn2_kluster_id.required'           => 'Ruangan Kluster mesti dipilih',
            'pipn2_sub_kluster_id.required'       => 'Ruangan Sub Kluster mesti dipilih',
            'pipn2_ikes_keterangan_kes.required'  => 'Ruangan Keterangan Kes mesti diisi',
            'pipn2_ikes_tindakan_awal.required'   => 'Ruangan Tindakan / Maklumbalas Awal JPNIN mesti diisi',
            'pipn2_ikes_sumber.required'          => 'Ruangan Sumber mesti dipilih',
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $carbon_obj                             = Carbon::createFromFormat('d/m/Y', $request->pipn2_ikes_tarikh_berlaku)->format('Y-m-d');
                $update_ikes_ppn                        = SPK_ikes::where($where)->first();
                $update_ikes_ppn->hasRT                 = $hasKRT;
                $update_ikes_ppn->krt_profile_id        = $request->pipn_krt_profile_id;
                $update_ikes_ppn->state_id              = $request->pipn2_negeri_id;
                $update_ikes_ppn->daerah_id             = $request->pipn2_daerah_id;
                $update_ikes_ppn->bandar_id             = $request->pipn2_bandar_id;
                $update_ikes_ppn->ikes_kawasan          = $request->pipn2_ikes_kawasan;
                $update_ikes_ppn->ikes_lokasi           = $request->pipn2_ikes_lokasi;
                $update_ikes_ppn->ikes_poskod           = $request->pipn2_ikes_poskod;
                $update_ikes_ppn->parlimen_id           = $request->pipn2_parlimen_id;
                $update_ikes_ppn->dun_id                = $request->pipn2_dun_id;
                $update_ikes_ppn->pbt_id                = $request->pipn2_pbt_id;
                $update_ikes_ppn->ikes_bpolis           = $request->pipn2_ikes_bpolis;
                $update_ikes_ppn->ikes_tarikh_berlaku   = $carbon_obj;
                $update_ikes_ppn->peringkat_id          = $request->pipn2_peringkat_kes_id;
                $update_ikes_ppn->kategori_id           = $request->pipn2_kategori_kes_id;
                $update_ikes_ppn->sub_kategori_id       = $request->pipn2_sub_kategori_kes_id;
                $update_ikes_ppn->kluster_id            = $request->pipn2_kluster_id;
                $update_ikes_ppn->sub_kluster_id        = $request->pipn2_sub_kluster_id;
                $update_ikes_ppn->ikes_keterangan_kes   = $request->pipn2_ikes_keterangan_kes;
                $update_ikes_ppn->ikes_tindakan_awal    = $request->pipn2_ikes_tindakan_awal;
                $update_ikes_ppn->ikes_sumber           = $request->pipn2_ikes_sumber;
                $update_ikes_ppn->dihantar_alamat       = $request->pipn1_dihantar_alamat;
                $update_ikes_ppn->save();
                
            }
        }
    }

    function permohonan_ikes_ppn_1(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon',
                                            'ref__status_spk_ikes.status_description AS status_description',
                                            'spk__ikes.diakui_note AS diakui_note',
                                            'spk__ikes.disemak_note AS disemak_note',
                                            'spk__ikes.disahkan_note AS disahkan_note'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->leftJoin('ref__status_spk_ikes','ref__status_spk_ikes.id','=','spk__ikes.status')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.permohonan-ikes-ppn-1', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function post_permohonan_ikes_ppn_2(Request $request){
        $action = $request->post_permohonan_ikes_ppn_2;
        $app_id = $request->pipn5_ikes_id;
        
        $rules_main = array(                
            'pipn4_ikes_bil_terlibat'                 => 'required',
            'pipn4_status_etnik_id'                   => 'required',
            'pipn4_status_warganegara_id'             => 'required',
            'pipn4_ikes_bil_tangkapan'                => 'required',
        );
        
        $messages = [
            'pipn4_ikes_bil_terlibat.required'        => 'Ruangan Bilangan Terlibat mesti diisi',
            'pipn4_status_etnik_id.required'          => 'Ruangan Antara Etnik mesti dipilih',
            'pipn4_status_warganegara_id.required'    => 'Ruangan Pilihan Warganegara mesti dipilih',
            'pipn4_ikes_bil_tangkapan.required'       => 'Ruangan Bilangan Tangkapan Polis mesti diisi',
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                
                $update_ikes_ppn_1                          = SPK_ikes::where($where)->first();
                $update_ikes_ppn_1->ikes_bil_terlibat       = $request->pipn4_ikes_bil_terlibat;
                $update_ikes_ppn_1->status_etnik_id         = $request->pipn4_status_etnik_id;
                $update_ikes_ppn_1->status_warganegara_id   = $request->pipn4_status_warganegara_id;
                $update_ikes_ppn_1->ikes_bil_tangkapan      = $request->pipn4_ikes_bil_tangkapan;
                $update_ikes_ppn_1->save();
                
            }
        }
    }

    function permohonan_ikes_ppn_2(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon',
                                            'ref__status_spk_ikes.status_description AS status_description',
                                            'spk__ikes.diakui_note AS diakui_note',
                                            'spk__ikes.disemak_note AS disemak_note',
                                            'spk__ikes.disahkan_note AS disahkan_note'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->leftJoin('ref__status_spk_ikes','ref__status_spk_ikes.id','=','spk__ikes.status')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.permohonan-ikes-ppn-2', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function post_permohonan_ikes_ppn_3(Request $request){
        $action = $request->post_permohonan_ikes_ppn_3;
        $app_id = $request->pipn7_ikes_id;
        
        $rules_main = array(                
            'pipn6_ikes_keterangan_tindakan'          => 'required',
        );
        
        $messages = [
            'pipn6_ikes_keterangan_tindakan.required' => 'Ruangan Keterangan Tindakan Penyelesaian mesti diisi',
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                
                $update_ikes_ppn_2                              = SPK_ikes::where($where)->first();
                $update_ikes_ppn_2->hasTindakan                 = $request->pipn6_hasTindakan;
                $update_ikes_ppn_2->ikes_keterangan_tindakan    = $request->pipn6_ikes_keterangan_tindakan;
                $update_ikes_ppn_2->save();
                
            }
        }
    }

    function permohonan_ikes_ppn_3(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon',
                                            'ref__status_spk_ikes.status_description AS status_description',
                                            'spk__ikes.diakui_note AS diakui_note',
                                            'spk__ikes.disemak_note AS disemak_note',
                                            'spk__ikes.disahkan_note AS disahkan_note'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->leftJoin('ref__status_spk_ikes','ref__status_spk_ikes.id','=','spk__ikes.status')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.permohonan-ikes-ppn-3', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function add_spk_ikes_dokument_ppn(Request $request){
        $action = $request->add_spk_ikes_dokument_ppn;
        $app_id = $request->pipn9_spk_ikes_id;
        
       

        $rules = array(
            'pipn9_file_title'                => 'required',
            'pipn9_file_catatan'              => 'required',
            'pipn9_file_dokument'             => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:5000'
        );

        $messages = [
            'pipn9_file_title.required'       => 'Ruangan Tajuk Fail Mesti Diisi',
            'pipn9_file_catatan.required'     => 'Ruangan Catatan Fail Mesti Diisi',
            'pipn9_file_dokument.required'    => 'Ruangan Fail Mesti Dipilih',
            'pipn9_file_dokument.mimes'       => 'Fail Mesti Dipilih Dalam Format jpeg,png,jpg,gif,svg,pdf',
            'pipn9_file_dokument.max'         => 'Fail mesti dalam sive 5000KB',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            
            if ($action == 'add') {
                $fileName = $request->pipn9_file_dokument->getClientOriginalName();
                $request->pipn9_file_dokument->storeAs('public/ikes_dokument',$fileName);
                $ikes_dokument = new SPK_ikes_dokument;
                $ikes_dokument->spk_ikes_id     = $app_id;
                $ikes_dokument->file_title      = $request->pipn9_file_title;
                $ikes_dokument->file_catatan    = $request->pipn9_file_catatan;
                $ikes_dokument->file_dokument   = $fileName;
                $ikes_dokument->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function post_permohonan_ikes_ppn_4(Request $request){
        $action = $request->post_permohonan_ikes_ppn_4;
        $app_id = $request->pipn10_ikes_id;
        
        $rules_main = array(                
            'pipn8_ikes_keadaan_semasa'               => 'required',
            'pipn8_ikes_jangkaan_keadaan'             => 'required',
        );
        
        $messages = [
            'pipn8_ikes_keadaan_semasa.required'      => 'Ruangan Keadaan Semasa mesti diisi',
            'pipn8_ikes_jangkaan_keadaan.required'    => 'Ruangan Jangkaan keadaan pada masa akan datang mesti diisi',
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $update_ikes_ppn_3                              = SPK_ikes::where($where)->first();
                $update_ikes_ppn_3->ikes_keadaan_semasa         = $request->pipn8_ikes_keadaan_semasa;
                $update_ikes_ppn_3->ikes_jangkaan_keadaan       = $request->pipn8_ikes_jangkaan_keadaan;
                $update_ikes_ppn_3->status                      = 9;
                $update_ikes_ppn_3->dihantar_date               = date('Y-m-d H:i:s');
                $update_ikes_ppn_3->save();
                
            }
        }
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function senarai_permohonan_ikes_bpp(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('spk__ikes')
                        ->select('spk__ikes.id AS id',
                                'ref__spk_peringkat_kes.peringkat_description AS peringkat_description',
                                'ref__spk_kategori_kes.kategori_description AS kategori_description',
                                'ref__spk_ikes_kluster.kluster_description AS kluster_description',
                                'users__profile.user_fullname AS user_fullname',
                                'ref__status_spk_ikes.status_description AS status_description',
                                'spk__ikes.status AS status')
                        ->leftJoin('ref__spk_peringkat_kes','ref__spk_peringkat_kes.id','=','spk__ikes.peringkat_id')
                        ->leftJoin('ref__spk_kategori_kes','ref__spk_kategori_kes.id','=','spk__ikes.kategori_id')
                        ->leftJoin('ref__spk_ikes_kluster','ref__spk_ikes_kluster.id','=','spk__ikes.kluster_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                        ->leftJoin('ref__status_spk_ikes','ref__status_spk_ikes.id','=','spk__ikes.status')
                        ->where('spk__ikes.dihantar_by', '=', Auth::user()->user_id)
                        ->whereIN('spk__ikes.status',[2,13,14,15])
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
            return view('rt-sm21.senarai-permohonan-ikes-bpp',compact('roles_menu'));
        }
    }

    function post_permohonan_ikes_bpp(Request $request){
        
        $action = $request->post_permohonan_ikes_bpp;
        
        $rules = array(
           
        );

        $messages = [
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm21.senarai_permohonan_ikes_bpp'))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'add') {
                $ikes_bpp               = new SPK_ikes;
                $ikes_bpp->status       = 2;
                $ikes_bpp->dihantar_by  = Auth::user()->user_id;
                $ikes_bpp->save();
            }
           
            return Redirect::to(route('rt-sm21.permohonan_ikes_bpp',$ikes_bpp->id));
        }

    }

    function permohonan_ikes_bpp(Request $request, $id){
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
            } else if($type == 'get_sub_kategori') {
                $value = $request->value;
                $where = array('kategori_kes_id' => $value);
                $data  = DB::table('ref__spk_sub_kategori_kes')
                        ->select('ref__spk_sub_kategori_kes.id', 'ref__spk_sub_kategori_kes.kategori_kes_id', 'ref__spk_sub_kategori_kes.sub_kategori_description', 
                        'ref__spk_sub_kategori_kes.status')
                        ->where('ref__spk_sub_kategori_kes.kategori_kes_id', '=',  $where)
                        ->where('ref__spk_sub_kategori_kes.status', '=',  true)
                        ->get();
                return Response::json($data);
            } else if($type == 'get_sub_kluster') {
                $value = $request->value;
                $where = array('kluster_id' => $value);
                $data  = DB::table('ref__spk_ikes_sub_kluster')
                        ->select('ref__spk_ikes_sub_kluster.id', 'ref__spk_ikes_sub_kluster.kluster_id', 'ref__spk_ikes_sub_kluster.subkluster_description', 
                        'ref__spk_ikes_sub_kluster.status')
                        ->where('ref__spk_ikes_sub_kluster.kluster_id', '=',  $where)
                        ->where('ref__spk_ikes_sub_kluster.status', '=',  true)
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
            $negeri                 = RefStates::where('status', '=', true)->get();
            $daerah                 = RefDaerah::where('status', '=', true)->get();
            $bandar                 = RefBandar::where('status', '=', true)->get();
            $parlimen               = RefParlimen::where('status', '=', true)->get();
            $dun                    = RefDUN::where('status', '=', true)->get();
            $pbt                    = RefPBT::where('status', '=', true)->get();
            $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
            $peringkat_kes          = Ref_Spk_Peringkat_Kes::where('status', '=', true)->get();
            $kategori_kes           = Ref_Spk_Kategori_Kes::where('status', '=', true)->get();
            $sub_kategori_kes       = Ref_Spk_Sub_Kategori_Kes::where('status', '=', true)->get();
            $kluster                = Ref_SPK_Ikes_Kluster::where('status', '=', true)->get();
            $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.sub_kategori_id',
                                            'spk__ikes.kluster_id',
                                            'spk__ikes.sub_kluster_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon',
                                            'ref__status_spk_ikes.status_description AS status_description',
                                            'spk__ikes.diakui_note AS diakui_note',
                                            'spk__ikes.disemak_note AS disemak_note',
                                            'spk__ikes.disahkan_note AS disahkan_note'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->leftJoin('ref__status_spk_ikes','ref__status_spk_ikes.id','=','spk__ikes.status')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm21.permohonan-ikes-bpp', compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'peringkat_kes', 'kategori_kes', 'sub_kategori_kes', 'kluster', 'ikes'));
        }
        
    }

    function post_permohonan_ikes_bpp_1(Request $request){
        $action = $request->post_permohonan_ikes_bpp_1;
        $app_id = $request->pipp3_ikes_id;
        $hasKRT = $request->pipp_hasRT;

        if ($hasKRT == '1') {
            $rules_main = array(                
                'pipp_negeri_id'                  => 'required',
                'pipp_daerah_id'                  => 'required',
                'pipp_krt_profile_id'             => 'required',
                'pipp1_dihantar_alamat'           => 'required',
                'pipp2_negeri_id'                 => 'required',
                'pipp2_bandar_id'                 => 'required',
                'pipp2_ikes_lokasi'               => 'required',
                'pipp2_parlimen_id'               => 'required',
                'pipp2_pbt_id'                    => 'required',
                'pipp2_ikes_tarikh_berlaku'       => 'required',
                'pipp2_daerah_id'                 => 'required',
                'pipp2_ikes_kawasan'              => 'required',
                'pipp2_ikes_poskod'               => 'required',
                'pipp2_dun_id'                    => 'required',
                'pipp2_ikes_bpolis'               => 'required',
                'pipp2_peringkat_kes_id'          => 'required',
                'pipp2_kategori_kes_id'           => 'required',
                'pipp2_sub_kategori_kes_id'       => 'required',
                'pipp2_kluster_id'                => 'required',
                'pipp2_sub_kluster_id'            => 'required',
                'pipp2_ikes_keterangan_kes'       => 'required',
                'pipp2_ikes_tindakan_awal'        => 'required',
                'pipp2_ikes_sumber'               => 'required',
            );
        } else {
            $rules_main = array(
                'pipp1_dihantar_alamat'           => 'required',
                'pipp2_negeri_id'                 => 'required',
                'pipp2_bandar_id'                 => 'required',
                'pipp2_ikes_lokasi'               => 'required',
                'pipp2_parlimen_id'               => 'required',
                'pipp2_pbt_id'                    => 'required',
                'pipp2_ikes_tarikh_berlaku'       => 'required',
                'pipp2_daerah_id'                 => 'required',
                'pipp2_ikes_kawasan'              => 'required',
                'pipp2_ikes_poskod'               => 'required',
                'pipp2_dun_id'                    => 'required',
                'pipp2_ikes_bpolis'               => 'required',
                'pipp2_peringkat_kes_id'          => 'required',
                'pipp2_kategori_kes_id'           => 'required',
                'pipp2_sub_kategori_kes_id'       => 'required',
                'pipp2_kluster_id'                => 'required',
                'pipp2_sub_kluster_id'            => 'required',
                'pipp2_ikes_keterangan_kes'       => 'required',
                'pipp2_ikes_tindakan_awal'        => 'required',
                'pipp2_ikes_sumber'               => 'required',
            );
        }
        
        $messages = [
            'pipp_negeri_id.required'             => 'Ruangan Negeri mesti dipilih',
            'pipp_daerah_id.required'             => 'Ruangan Daerah mesti dipilih',
            'pipp_krt_profile_id.required'        => 'Ruangan Nama KRT mesti dipilih',
            'pipp1_dihantar_alamat.required'      => 'Ruangan Alamat Pemohon mesti diisi',
            'pipp2_negeri_id.required'            => 'Ruangan Negeri mesti dipilih',
            'pipp2_bandar_id.required'            => 'Ruangan Bandar mesti dipilih',
            'pipp2_ikes_lokasi.required'          => 'Ruangan Lokasi /  Nama Jalan mesti diisi',
            'pipp2_parlimen_id.required'          => 'Ruangan Parlimen mesti dipilih',
            'pipp2_pbt_id.required'               => 'Ruangan PBT mesti dipilih',
            'pipp2_ikes_tarikh_berlaku.required'  => 'Ruangan Tarikh Berlaku mesti dipilih',
            'pipp2_daerah_id.required'            => 'Ruangan Daerah mesti dipilih',
            'pipp2_ikes_kawasan.required'         => 'Ruangan Taman / Kampung mesti diisi',
            'pipp2_ikes_poskod.required'          => 'Ruangan Poskod mesti diisi',
            'pipp2_dun_id.required'               => 'Ruangan Dun mesti dipilih',
            'pipp2_ikes_bpolis.required'          => 'Ruangan Balai Polis mesti diisi',
            'pipp2_peringkat_kes_id.required'     => 'Ruangan Peringkat Kes mesti dipilih',
            'pipp2_kategori_kes_id.required'      => 'Ruangan Kategori Kes mesti dipilih',
            'pipp2_sub_kategori_kes_id.required'  => 'Ruangan Sub Kategori Kes mesti dipilih',
            'pipp2_ikes_keterangan_kes.required'  => 'Ruangan Keterangan Kes mesti diisi',
            'pipp2_ikes_tindakan_awal.required'   => 'Ruangan Keterangan Kes mesti diisi',
            'pipp2_ikes_sumber.required'          => 'Ruangan Keterangan Kes mesti diisi',
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $carbon_obj                             = Carbon::createFromFormat('d/m/Y', $request->pipp2_ikes_tarikh_berlaku)->format('Y-m-d');
                $update_ikes_bpp                        = SPK_ikes::where($where)->first();
                $update_ikes_bpp->hasRT                 = $hasKRT;
                $update_ikes_bpp->krt_profile_id        = $request->pipp_krt_profile_id;
                $update_ikes_bpp->state_id              = $request->pipp2_negeri_id;
                $update_ikes_bpp->daerah_id             = $request->pipp2_daerah_id;
                $update_ikes_bpp->bandar_id             = $request->pipp2_bandar_id;
                $update_ikes_bpp->ikes_kawasan          = $request->pipp2_ikes_kawasan;
                $update_ikes_bpp->ikes_lokasi           = $request->pipp2_ikes_lokasi;
                $update_ikes_bpp->ikes_poskod           = $request->pipp2_ikes_poskod;
                $update_ikes_bpp->parlimen_id           = $request->pipp2_parlimen_id;
                $update_ikes_bpp->dun_id                = $request->pipp2_dun_id;
                $update_ikes_bpp->pbt_id                = $request->pipp2_pbt_id;
                $update_ikes_bpp->ikes_bpolis           = $request->pipp2_ikes_bpolis;
                $update_ikes_bpp->ikes_tarikh_berlaku   = $carbon_obj;
                $update_ikes_bpp->peringkat_id          = $request->pipp2_peringkat_kes_id;
                $update_ikes_bpp->kategori_id           = $request->pipp2_kategori_kes_id;
                $update_ikes_bpp->sub_kategori_id       = $request->pipp2_sub_kategori_kes_id;
                $update_ikes_bpp->kluster_id            = $request->pipp2_kluster_id;
                $update_ikes_bpp->sub_kluster_id        = $request->pipp2_sub_kluster_id;
                $update_ikes_bpp->ikes_keterangan_kes   = $request->pipp2_ikes_keterangan_kes;
                $update_ikes_bpp->ikes_tindakan_awal    = $request->pipp2_ikes_tindakan_awal;
                $update_ikes_bpp->ikes_sumber           = $request->pipp2_ikes_sumber;
                $update_ikes_bpp->dihantar_alamat       = $request->pipp1_dihantar_alamat;
                $update_ikes_bpp->save();
                
            }
        }
    }

    function permohonan_ikes_bpp_1(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon',
                                            'ref__status_spk_ikes.status_description AS status_description',
                                            'spk__ikes.diakui_note AS diakui_note',
                                            'spk__ikes.disemak_note AS disemak_note',
                                            'spk__ikes.disahkan_note AS disahkan_note'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->leftJoin('ref__status_spk_ikes','ref__status_spk_ikes.id','=','spk__ikes.status')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.permohonan-ikes-bpp-1', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function post_permohonan_ikes_bpp_2(Request $request){
        $action = $request->post_permohonan_ikes_bpp_2;
        $app_id = $request->pipp5_ikes_id;
        
        $rules_main = array(                
            'pipp4_ikes_bil_terlibat'                 => 'required',
            'pipp4_status_etnik_id'                   => 'required',
            'pipp4_status_warganegara_id'             => 'required',
            'pipp4_ikes_bil_tangkapan'                => 'required',
        );
        
        $messages = [
            'pipp4_ikes_bil_terlibat.required'        => 'Ruangan Bilangan Terlibat mesti diisi',
            'pipp4_status_etnik_id.required'          => 'Ruangan Antara Etnik mesti dipilih',
            'pipp4_status_warganegara_id.required'    => 'Ruangan Pilihan Warganegara mesti dipilih',
            'pipp4_ikes_bil_tangkapan.required'       => 'Ruangan Bilangan Tangkapan Polis mesti diisi',
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                
                $update_ikes_bpp_1                          = SPK_ikes::where($where)->first();
                $update_ikes_bpp_1->ikes_bil_terlibat       = $request->pipp4_ikes_bil_terlibat;
                $update_ikes_bpp_1->status_etnik_id         = $request->pipp4_status_etnik_id;
                $update_ikes_bpp_1->status_warganegara_id   = $request->pipp4_status_warganegara_id;
                $update_ikes_bpp_1->ikes_bil_tangkapan      = $request->pipp4_ikes_bil_tangkapan;
                $update_ikes_bpp_1->save();
                
            }
        }
    }

    function permohonan_ikes_bpp_2(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon',
                                            'ref__status_spk_ikes.status_description AS status_description',
                                            'spk__ikes.diakui_note AS diakui_note',
                                            'spk__ikes.disemak_note AS disemak_note',
                                            'spk__ikes.disahkan_note AS disahkan_note'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->leftJoin('ref__status_spk_ikes','ref__status_spk_ikes.id','=','spk__ikes.status')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.permohonan-ikes-bpp-2', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function post_permohonan_ikes_bpp_3(Request $request){
        $action = $request->post_permohonan_ikes_bpp_3;
        $app_id = $request->pipp7_ikes_id;
        
        $rules_main = array(                
            'pipp6_ikes_keterangan_tindakan'          => 'required',
        );
        
        $messages = [
            'pipp6_ikes_keterangan_tindakan.required' => 'Ruangan Keterangan Tindakan Penyelesaian mesti diisi',
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                
                $update_ikes_bpp_2                              = SPK_ikes::where($where)->first();
                $update_ikes_bpp_2->hasTindakan                 = $request->pipp6_hasTindakan;
                $update_ikes_bpp_2->ikes_keterangan_tindakan    = $request->pipp6_ikes_keterangan_tindakan;
                $update_ikes_bpp_2->save();
                
            }
        }
    }

    function permohonan_ikes_bpp_3(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon',
                                            'ref__status_spk_ikes.status_description AS status_description',
                                            'spk__ikes.diakui_note AS diakui_note',
                                            'spk__ikes.disemak_note AS disemak_note',
                                            'spk__ikes.disahkan_note AS disahkan_note'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->leftJoin('ref__status_spk_ikes','ref__status_spk_ikes.id','=','spk__ikes.status')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.permohonan-ikes-bpp-3', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function add_spk_ikes_dokument_bpp(Request $request){
        $action = $request->add_spk_ikes_dokument_bpp;
        $app_id = $request->pipp9_spk_ikes_id;
        
       

        $rules = array(
            'pipp9_file_title'                => 'required',
            'pipp9_file_catatan'              => 'required',
            'pipp9_file_dokument'             => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:5000'
        );

        $messages = [
            'pipp9_file_title.required'       => 'Ruangan Tajuk Fail Mesti Diisi',
            'pipp9_file_catatan.required'     => 'Ruangan Catatan Fail Mesti Diisi',
            'pipp9_file_dokument.required'    => 'Ruangan Fail Mesti Dipilih',
            'pipp9_file_dokument.mimes'       => 'Fail Mesti Dipilih Dalam Format jpeg,png,jpg,gif,svg,pdf',
            'pipp9_file_dokument.max'         => 'Fail mesti dalam sive 5000KB',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            
            if ($action == 'add') {
                $fileName = $request->pipp9_file_dokument->getClientOriginalName();
                $request->pipp9_file_dokument->storeAs('public/ikes_dokument',$fileName);
                $ikes_dokument = new SPK_ikes_dokument;
                $ikes_dokument->spk_ikes_id     = $app_id;
                $ikes_dokument->file_title      = $request->pipp9_file_title;
                $ikes_dokument->file_catatan    = $request->pipp9_file_catatan;
                $ikes_dokument->file_dokument   = $fileName;
                $ikes_dokument->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function post_permohonan_ikes_bpp_4(Request $request){
        $action = $request->post_permohonan_ikes_bpp_4;
        $app_id = $request->pipp10_ikes_id;
        
        $rules_main = array(                
            'pipp8_ikes_keadaan_semasa'               => 'required',
            'pipp8_ikes_jangkaan_keadaan'             => 'required',
        );
        
        $messages = [
            'pipp8_ikes_keadaan_semasa.required'      => 'Ruangan Keadaan Semasa mesti diisi',
            'pipp8_ikes_jangkaan_keadaan.required'    => 'Ruangan Jangkaan keadaan pada masa akan datang mesti diisi',
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $update_ikes_bpp_3                              = SPK_ikes::where($where)->first();
                $update_ikes_bpp_3->ikes_keadaan_semasa         = $request->pipp8_ikes_keadaan_semasa;
                $update_ikes_bpp_3->ikes_jangkaan_keadaan       = $request->pipp8_ikes_jangkaan_keadaan;
                $update_ikes_bpp_3->status                      = 13;
                $update_ikes_bpp_3->dihantar_date               = date('Y-m-d H:i:s');
                $update_ikes_bpp_3->save();
                
            }
        }
    }

    function senarai_at_ikes_p(Request $request){
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
            $data = DB::table('spk__ikes')
                        ->select('spk__ikes.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'ref__spk_peringkat_kes.peringkat_description AS peringkat_description',
                                'ref__spk_kategori_kes.kategori_description AS kategori_description',
                                'ref__spk_ikes_kluster.kluster_description AS kluster_description',
                                'users__profile.user_fullname AS user_fullname',
                                'ref__status_spk_ikes.status_description AS status_description',
                                'spk__ikes.status AS status',
                                'spk__ikes_at.id AS spk__ikes_at_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','spk__ikes.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','spk__ikes.daerah_id')
                        ->leftJoin('ref__spk_peringkat_kes','ref__spk_peringkat_kes.id','=','spk__ikes.peringkat_id')
                        ->leftJoin('ref__spk_kategori_kes','ref__spk_kategori_kes.id','=','spk__ikes.kategori_id')
                        ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                        ->leftJoin('ref__status_spk_ikes','ref__status_spk_ikes.id','=','spk__ikes.status')
                        ->leftJoin('spk__ikes_at','spk__ikes_at.spk_ikes_id','=','spk__ikes.id')
                        ->leftJoin('ref__spk_ikes_kluster','ref__spk_ikes_kluster.id','=','spk__ikes.kluster_id')
                        ->where('spk__ikes_at.id','=', null)
                        ->whereIN('spk__ikes.status',[1])
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
            return view('rt-sm21.senarai-at-ikes-p', compact('roles_menu','state', 'jenis_tindakan'));
        }
    }

    function paparan_pelaporan_ikes_p(Request $request, $id){
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
            $peringkat_kes          = Ref_Spk_Peringkat_Kes::where('status', '=', true)->get();
            $kategori_kes           = Ref_Spk_Kategori_Kes::where('status', '=', true)->get();
            $kluster                = Ref_SPK_Ikes_Kluster::where('status', '=', true)->get();
            $sub_kluster            = Ref_SPK_Ikes_Sub_Kluster::where('status', '=', true)->get();
            $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.kluster_id',
                                            'spk__ikes.sub_kluster_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm21.paparan-pelaporan-ikes-p', compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'peringkat_kes', 
            'kategori_kes', 'kluster', 'sub_kluster', 'ikes'));
        }
    }

    function paparan_pelaporan_ikes_p_1(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.paparan-pelaporan-ikes-p-1', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function paparan_pelaporan_ikes_p_2(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.paparan-pelaporan-ikes-p-2', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function paparan_pelaporan_ikes_p_3(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.paparan-pelaporan-ikes-p-3', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function post_add_arahan_tindakan_p(Request $request){
        $action = $request->post_add_arahan_tindakan_p;
        $app_id = $request->matip_ikes_id;
        
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
                $arahan_tindakan_ikes = new SPK_iKes_AT;
                $arahan_tindakan_ikes->spk_ikes_id              = $app_id;
                $arahan_tindakan_ikes->tempoh_tindakan          = $request->matip_tempoh_tindakan;
                $arahan_tindakan_ikes->tarikh_arahan            = $carbon_obj;
                $arahan_tindakan_ikes->jenis_arahan_id          = $request->matip_jenis_arahan_id;
                $arahan_tindakan_ikes->tindakan_kepada_ppn      = $request->matip_tindakan_kepada_ppn;
                $arahan_tindakan_ikes->tindakan_kepada_ppd      = $request->matip_tindakan_kepada_ppd;
                $arahan_tindakan_ikes->arahan_by                = Auth::user()->user_id;
                $arahan_tindakan_ikes->save();
                
            }
        }
    }

    function senarai_ts_ikes_p(Request $request){
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
            $data = DB::table('spk__ikes_at')
                        ->select('spk__ikes_at.id AS id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'ref__spk_peringkat_kes.peringkat_description AS peringkat_description',
                                'ref__spk_kategori_kes.kategori_description AS kategori_description',
                                'ref__spk_ikes_kluster.kluster_description AS kluster_description',
                                'ref__roles_users.long_description AS long_description')
                        ->leftJoin('spk__ikes','spk__ikes.id','=','spk__ikes_at.spk_ikes_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','spk__ikes.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','spk__ikes.daerah_id')
                        ->leftJoin('ref__spk_peringkat_kes','ref__spk_peringkat_kes.id','=','spk__ikes.peringkat_id')
                        ->leftJoin('ref__spk_kategori_kes','ref__spk_kategori_kes.id','=','spk__ikes.kategori_id')
                        ->leftJoin('users','users.user_id','=','spk__ikes_at.arahan_by')
                        ->leftJoin('ref__roles_users','ref__roles_users.id','=','users.user_role')
                        ->leftJoin('ref__spk_ikes_kluster','ref__spk_ikes_kluster.id','=','spk__ikes.kluster_id')
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
            return view('rt-sm21.senarai-ts-ikes-p', compact('roles_menu','state', 'jenis_tindakan'));
        }
    }

    function paparan_pelaporan_ikes_ts_p(Request $request, $id){
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
            $peringkat_kes          = Ref_Spk_Peringkat_Kes::where('status', '=', true)->get();
            $kategori_kes           = Ref_Spk_Kategori_Kes::where('status', '=', true)->get();
            $kluster                = Ref_SPK_Ikes_Kluster::where('status', '=', true)->get();
            $sub_kluster            = Ref_SPK_Ikes_Sub_Kluster::where('status', '=', true)->get();
            $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.kluster_id',
                                            'spk__ikes.sub_kluster_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm21.paparan-pelaporan-ikes-ts-p', compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'peringkat_kes', 
            'kategori_kes', 'kluster', 'sub_kluster', 'ikes'));
        }
    }

    function paparan_pelaporan_ikes_ts_p_1(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.paparan-pelaporan-ikes-ts-p-1', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function paparan_pelaporan_ikes_ts_p_2(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.paparan-pelaporan-ikes-ts-p-2', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function paparan_pelaporan_ikes_ts_p_3(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.paparan-pelaporan-ikes-ts-p-3', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function get_view_ts_ikes($id){
        $data = DB::table('spk__ikes_at')
                ->select('spk__ikes_at.id', 
                    'spk__ikes_at.spk_ikes_id AS spk_ikes_id',
                    'spk__ikes_at.tempoh_tindakan AS tempoh_tindakan',
                    DB::raw(" DATE_FORMAT(spk__ikes_at.tarikh_arahan,'%d/%m/%Y') AS tarikh_arahan"),
                    'spk__ikes_at.jenis_arahan_id AS jenis_arahan_id',
                    'spk__ikes_at.tindakan_kepada_ppn AS tindakan_kepada_ppn',
                    'spk__ikes_at.tindakan_kepada_ppd AS tindakan_kepada_ppd')
                ->join('ref__spk_ikes_at_jenis','ref__spk_ikes_at_jenis.id','=','spk__ikes_at.jenis_arahan_id')
                ->where('spk__ikes_at.id', '=', $id)
                ->first();
        return Response::json($data);
    }

    function get_view_tindakan_susulan(Request $request, $id){
        $data = DB::table('spk__ikes_ts')
                ->select('spk__ikes_ts.id', 
                'spk__ikes_ts.spk_ikes_at_id',
                DB::raw(" DATE_FORMAT(spk__ikes_ts.tarikh_tindakan,'%d/%m/%Y') AS tarikh_tindakan"),
                'spk__ikes_ts.keterangan_tindakan',
                'ref__roles_users.long_description AS long_description')
                ->leftJoin('users','users.user_id','=','spk__ikes_ts.tindakan_susulan_by')
                ->leftJoin('ref__roles_users','ref__roles_users.id','=','users.user_role')
                ->where('spk__ikes_ts.spk_ikes_at_id', '=', $id)
                ->get();
        return Datatables::of($data)
                ->make(true);
    }

    function senarai_ts_ikes_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('spk__ikes_at')
                        ->select('spk__ikes_at.id AS id',
                                'spk__ikes.id AS spk_ikes_id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'ref__spk_peringkat_kes.peringkat_description AS peringkat_description',
                                'ref__spk_kategori_kes.kategori_description AS kategori_description',
                                'ref__roles_users.long_description AS long_description')
                        ->leftJoin('spk__ikes','spk__ikes.id','=','spk__ikes_at.spk_ikes_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','spk__ikes.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','spk__ikes.daerah_id')
                        ->leftJoin('ref__spk_peringkat_kes','ref__spk_peringkat_kes.id','=','spk__ikes.peringkat_id')
                        ->leftJoin('ref__spk_kategori_kes','ref__spk_kategori_kes.id','=','spk__ikes.kategori_id')
                        ->leftJoin('users','users.user_id','=','spk__ikes_at.arahan_by')
                        ->leftJoin('ref__roles_users','ref__roles_users.id','=','users.user_role')
                        ->where('spk__ikes_at.tindakan_kepada_ppd', '=', 1)
                        ->where('spk__ikes.daerah_id', '=', Auth::user()->daerah_id)
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
            return view('rt-sm21.senarai-ts-ikes-ppd', compact('roles_menu','jenis_tindakan'));
        }
    }

    function paparan_pelaporan_ikes_ts_ppd(Request $request, $id){
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
            $peringkat_kes          = Ref_Spk_Peringkat_Kes::where('status', '=', true)->get();
            $kategori_kes           = Ref_Spk_Kategori_Kes::where('status', '=', true)->get();
            $kluster                = Ref_SPK_Ikes_Kluster::where('status', '=', true)->get();
            $sub_kluster            = Ref_SPK_Ikes_Sub_Kluster::where('status', '=', true)->get();
            $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.kluster_id',
                                            'spk__ikes.sub_kluster_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm21.paparan-pelaporan-ikes-ts-ppd', compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'peringkat_kes', 
            'kategori_kes', 'kluster', 'sub_kluster', 'ikes'));
        }
    }

    function paparan_pelaporan_ikes_ts_ppd_1(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.paparan-pelaporan-ikes-ts-ppd-1', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function paparan_pelaporan_ikes_ts_ppd_2(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.paparan-pelaporan-ikes-ts-ppd-2', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function paparan_pelaporan_ikes_ts_ppd_3(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.paparan-pelaporan-ikes-ts-ppd-3', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function get_tindakan_susulan(Request $request, $id){
        $data = DB::table('spk__ikes_ts')
                ->select('spk__ikes_ts.id', 
                'spk__ikes_ts.spk_ikes_at_id',
                DB::raw(" DATE_FORMAT(spk__ikes_ts.tarikh_tindakan,'%d/%m/%Y') AS tarikh_tindakan"),
                'spk__ikes_ts.keterangan_tindakan',
                'ref__roles_users.long_description AS long_description')
                ->leftJoin('users','users.user_id','=','spk__ikes_ts.tindakan_susulan_by')
                ->leftJoin('ref__roles_users','ref__roles_users.id','=','users.user_role')
                ->where('spk__ikes_ts.spk_ikes_at_id', '=', $id)
                ->where('spk__ikes_ts.tindakan_susulan_by', '=', Auth::user()->user_id)
                ->get();
        return Datatables::of($data)
                ->make(true);
    }

    function post_add_ts_ikes_ppd(Request $request){
        $action = $request->post_add_ts_ikes_ppd;
        $app_id = $request->matipd_spk_ikes_id;
        
        $rules = array(
            'matipd_tarikh_tindakan'                => 'required',
            'matipd_keterangan_tindakan'            => 'required'
        );

        $messages = [
            'matipd_tarikh_tindakan.required'       => 'Ruangan Jenis Premis mesti dipilih',
            'matipd_keterangan_tindakan.required'   => 'Ruangan Alamat mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $carbon_obj = Carbon::createFromFormat('d/m/Y', $request->matipd_tarikh_tindakan)->format('Y-m-d');
                $tindakan_susulan_ppd = new SPK_iKes_TS;
                $tindakan_susulan_ppd->spk_ikes_at_id           = $app_id;
                $tindakan_susulan_ppd->tarikh_tindakan          = $carbon_obj;
                $tindakan_susulan_ppd->keterangan_tindakan      = $request->matipd_keterangan_tindakan;
                $tindakan_susulan_ppd->tindakan_susulan_by      = Auth::user()->user_id;
                
                $tindakan_susulan_ppd->save();
                
            }
        }
    }

    function senarai_ts_ikes_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('spk__ikes_at')
                        ->select('spk__ikes_at.id AS id',
                                'spk__ikes.id AS spk_kes_id',
                                'ref__states.state_description AS state_description',
                                'ref__daerahs.daerah_description AS daerah_description',
                                'ref__spk_peringkat_kes.peringkat_description AS peringkat_description',
                                'ref__spk_kategori_kes.kategori_description AS kategori_description',
                                'ref__spk_ikes_kluster.kluster_description AS kluster_description',
                                'ref__roles_users.long_description AS long_description')
                        ->leftJoin('spk__ikes','spk__ikes.id','=','spk__ikes_at.spk_ikes_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','spk__ikes.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','spk__ikes.daerah_id')
                        ->leftJoin('ref__spk_peringkat_kes','ref__spk_peringkat_kes.id','=','spk__ikes.peringkat_id')
                        ->leftJoin('ref__spk_kategori_kes','ref__spk_kategori_kes.id','=','spk__ikes.kategori_id')
                        ->leftJoin('ref__spk_ikes_kluster','ref__spk_ikes_kluster.id','=','spk__ikes.kluster_id')
                        ->leftJoin('users','users.user_id','=','spk__ikes_at.arahan_by')
                        ->leftJoin('ref__roles_users','ref__roles_users.id','=','users.user_role')
                        ->where('spk__ikes_at.tindakan_kepada_ppn', '=', 1)
                        ->where('spk__ikes.state_id', '=', Auth::user()->state_id)
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
            $daerah             = RefDaerah::where('status', '=',  true)
                                ->where('ref__daerahs.state_id', '=', Auth::user()->state_id)    
                                ->get();
            $jenis_tindakan     = Ref_SPK_iKes_AT_Jenis::where('status', '=', true)->get();
            return view('rt-sm21.senarai-ts-ikes-ppn', compact('roles_menu','daerah', 'jenis_tindakan'));
        }
    }
    
    function paparan_pelaporan_ikes_ts_ppn(Request $request, $id){
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
            $peringkat_kes          = Ref_Spk_Peringkat_Kes::where('status', '=', true)->get();
            $kategori_kes           = Ref_Spk_Kategori_Kes::where('status', '=', true)->get();
            $kluster                = Ref_SPK_Ikes_Kluster::where('status', '=', true)->get();
            $sub_kluster            = Ref_SPK_Ikes_Sub_Kluster::where('status', '=', true)->get();
            $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.kluster_id',
                                            'spk__ikes.sub_kluster_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm21.paparan-pelaporan-ikes-ts-ppn', compact('roles_menu','negeri', 'daerah', 'bandar', 'parlimen', 'dun', 'pbt', 'krt', 'peringkat_kes', 
            'kategori_kes', 'kluster', 'sub_kluster', 'ikes'));
        }
    }

    function paparan_pelaporan_ikes_ts_ppn_1(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.paparan-pelaporan-ikes-ts-ppn-1', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function paparan_pelaporan_ikes_ts_ppn_2(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.paparan-pelaporan-ikes-ts-ppn-2', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function paparan_pelaporan_ikes_ts_ppn_3(Request $request, $id){
        $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
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
        $krt                    = KRT_Profile::where('krt_status', '=', true)->get();
        $status_etnik           = Ref_Status_Status_Etnik::where('status', '=', true)->get();
        $status_warganegara     = Ref_Status_Warganegara::where('status', '=', true)->get();
        $ref_kaum               = RefKaum::where('status', '=', true)->get();
        $ikes                   = DB::table('spk__ikes')
                                    ->select('spk__ikes.id',
                                            'spk__ikes.hasRT',
                                            'krt__profile.state_id AS krt_state_id',
                                            'krt__profile.daerah_id AS krt_daerah_id',
                                            'spk__ikes.krt_profile_id',
                                            'spk__ikes.state_id',
                                            'spk__ikes.daerah_id',
                                            'spk__ikes.bandar_id',
                                            'spk__ikes.ikes_kawasan',
                                            'spk__ikes.ikes_lokasi',
                                            'spk__ikes.ikes_poskod',
                                            'spk__ikes.parlimen_id',
                                            'spk__ikes.dun_id',
                                            'spk__ikes.pbt_id',
                                            'spk__ikes.ikes_bpolis',
                                            DB::raw(" DATE_FORMAT(spk__ikes.ikes_tarikh_berlaku,'%d/%m/%Y') AS ikes_tarikh_berlaku"),
                                            'spk__ikes.peringkat_id',
                                            'spk__ikes.kategori_id',
                                            'spk__ikes.ikes_keterangan_kes',
                                            'spk__ikes.ikes_tindakan_awal',
                                            'spk__ikes.ikes_sumber',
                                            'spk__ikes.ikes_bil_terlibat',
                                            'spk__ikes.status_warganegara_id',
                                            'spk__ikes.status_etnik_id',
                                            'spk__ikes.ikes_bil_tangkapan',
                                            'spk__ikes.hasTindakan',
                                            'spk__ikes.ikes_keterangan_tindakan',
                                            'spk__ikes.ikes_keadaan_semasa',
                                            'spk__ikes.ikes_jangkaan_keadaan',
                                            'spk__ikes.status',
                                            'spk__ikes.dihantar_by',
                                            'spk__ikes.dihantar_alamat',
                                            'users__profile.user_fullname AS nama_permohon',
                                            'users__profile.no_ic AS ic_pemohon',
                                            'users__profile.no_phone AS phone_pemohon'
                                            )
                                    ->leftJoin('users__profile','users__profile.user_id','=','spk__ikes.dihantar_by')
                                    ->leftJoin('krt__profile','krt__profile.id','=','spk__ikes.krt_profile_id')
                                    ->where('spk__ikes.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        return view('rt-sm21.paparan-pelaporan-ikes-ts-ppn-3', compact('roles_menu','negeri', 'daerah', 'krt', 'status_etnik', 'status_warganegara', 'ref_kaum', 'ikes'));
    }

    function get_tindakan_susulan_ppn(Request $request, $id){
        $data = DB::table('spk__ikes_ts')
                ->select('spk__ikes_ts.id', 
                'spk__ikes_ts.spk_ikes_at_id',
                DB::raw(" DATE_FORMAT(spk__ikes_ts.tarikh_tindakan,'%d/%m/%Y') AS tarikh_tindakan"),
                'spk__ikes_ts.keterangan_tindakan',
                'ref__roles_users.long_description AS long_description')
                ->leftJoin('users','users.user_id','=','spk__ikes_ts.tindakan_susulan_by')
                ->leftJoin('ref__roles_users','ref__roles_users.id','=','users.user_role')
                ->where('spk__ikes_ts.spk_ikes_at_id', '=', $id)
                ->get();
        return Datatables::of($data)
                ->make(true);
    }

    function post_add_ts_ikes_ppn(Request $request){
        $action = $request->post_add_ts_ikes_ppn;
        $app_id = $request->matipn_spk_ikes_id;
        
        $rules = array(
            'matipn_tarikh_tindakan'                => 'required',
            'matipn_keterangan_tindakan'            => 'required'
        );

        $messages = [
            'matipn_tarikh_tindakan.required'       => 'Ruangan Jenis Premis mesti dipilih',
            'matipn_keterangan_tindakan.required'   => 'Ruangan Alamat mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $carbon_obj = Carbon::createFromFormat('d/m/Y', $request->matipn_tarikh_tindakan)->format('Y-m-d');
                $tindakan_susulan_ppn = new SPK_iKes_TS;
                $tindakan_susulan_ppn->spk_ikes_at_id           = $app_id;
                $tindakan_susulan_ppn->tarikh_tindakan          = $carbon_obj;
                $tindakan_susulan_ppn->keterangan_tindakan      = $request->matipn_keterangan_tindakan;
                $tindakan_susulan_ppn->tindakan_susulan_by      = Auth::user()->user_id;
                
                $tindakan_susulan_ppn->save();
                
            }
        }
    }

    function senarai_permohonan_insiden_admin(){
        return view('rt-sm21.senarai-permohonan-insiden-admin');
    }

    function permohonan_insiden_admin(){
        return view('rt-sm21.permohonan-insiden-admin');
    }

    function permohonan_insiden_admin_1(){
        return view('rt-sm21.permohonan-insiden-admin-1');
    }

    function permohonan_insiden_admin_2(){
        return view('rt-sm21.permohonan-insiden-admin-2');
    }

    function permohonan_insiden_admin_3(){
        return view('rt-sm21.permohonan-insiden-admin-3');
    }

    function akuan_permohonan_insiden_admin(){
        return view('rt-sm21.akuan-permohonan-insiden-admin');
    }

    function akuan_permohonan_insiden_admin_1(){
        return view('rt-sm21.akuan-permohonan-insiden-admin-1');
    }

    function akuan_permohonan_insiden_admin_2(){
        return view('rt-sm21.akuan-permohonan-insiden-admin-2');
    }

    function akuan_permohonan_insiden_admin_3(){
        return view('rt-sm21.akuan-permohonan-insiden-admin-3');
    }

    function akuan_permohonan_insiden_admin_4(){
        return view('rt-sm21.akuan-permohonan-insiden-admin-4');
    }

    function semakan_permohonan_insiden_admin(){
        return view('rt-sm21.semakan-permohonan-insiden-admin');
    }

    function semakan_permohonan_insiden_admin_1(){
        return view('rt-sm21.semakan-permohonan-insiden-admin-1');
    }

    function semakan_permohonan_insiden_admin_2(){
        return view('rt-sm21.semakan-permohonan-insiden-admin-2');
    }

    function semakan_permohonan_insiden_admin_3(){
        return view('rt-sm21.semakan-permohonan-insiden-admin-3');
    }

    function semakan_permohonan_insiden_admin_4(){
        return view('rt-sm21.semakan-permohonan-insiden-admin-4');
    }

    function pengesahan_permohonan_insiden_admin(){
        return view('rt-sm21.pengesahan-permohonan-insiden-admin');
    }

    function pengesahan_permohonan_insiden_admin_1(){
        return view('rt-sm21.pengesahan-permohonan-insiden-admin-1');
    }

    function pengesahan_permohonan_insiden_admin_2(){
        return view('rt-sm21.pengesahan-permohonan-insiden-admin-2');
    }

    function pengesahan_permohonan_insiden_admin_3(){
        return view('rt-sm21.pengesahan-permohonan-insiden-admin-3');
    }

    function pengesahan_permohonan_insiden_admin_4(){
        return view('rt-sm21.pengesahan-permohonan-insiden-admin-4');
    }
}
