<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect, Response;
use Auth;
use Validator;
use Session;
use DataTables;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\User;
use App\UserProfile;
use App\RefStates;
use App\RefDaerah;
use App\RefKaum;
use App\RefJantina;
use App\KRT_Profile;
use App\KRT_Aktiviti_Surat_Perancangan;
use App\Ref_Aktiviti_Bahagian;
use App\Ref_Aktiviti_PMK;
use App\Ref_Aktiviti_Penganjur;
use App\Ref_Aktiviti_Peringkat;
use App\Ref_Aktiviti_Agenda_Kerja;
use App\Ref_Aktiviti_Bidang;
use App\Ref_Aktiviti_Sub_Bidang;
use App\Ref_Aktiviti_Teras;
use App\Ref_Aktiviti_Strategi;
use App\Ref_Aktiviti;
use App\Ref_Aktiviti_Program;
use App\Ref_Aktiviti_Sub;
use App\Ref_Jenis_Aktiviti;
use App\Ref_Aktiviti_Sumber_Kewangan;
use App\KRT_Aktiviti_Perancangan;
use App\Ref_Kelompok_Umur;
use App\KRT_Aktiviti_Perancangan_Penyertaan;
use App\Ref_Rakan_Perpaduan;
use App\Ref_Sumbangan;
use App\KRT_Aktiviti_Perancangan_Rakan_Perpaduan;
use App\KRT_Aktiviti_Laporan;
use App\KRT_Aktiviti_Laporan_Penyertaan;
use App\KRT_Aktiviti_Laporan_Rakan_Perpaduan;


class RT_SM6Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function surat_perancangan_aktiviti_hq(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__aktiviti_surat_perancangan')
                        ->select('krt__aktiviti_surat_perancangan.id',
                                'krt__aktiviti_surat_perancangan.surat_tahun',
                                DB::raw(" DATE_FORMAT(krt__aktiviti_surat_perancangan.surat_tarikh,'%d/%m/%Y') AS surat_tarikh"),
                                'krt__aktiviti_surat_perancangan.created_at',
                                'users__profile.user_fullname AS create_by')
                        ->leftJoin('users__profile','users__profile.user_id','=','krt__aktiviti_surat_perancangan.create_by')
                        ->orderBy('krt__aktiviti_surat_perancangan.id', 'asc')
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
            return view('rt-sm6.surat-perancangan-aktiviti-hq',compact('roles_menu'));
        }
    }

    function add_surat_perancangan_aktiviti_hq(Request $request){
        $action = $request->add_surat_perancangan_aktiviti_hq;
        
        $rules = array(
            'maspa_surat_tahun'            => 'required',
            'maspa_surat_tarikh'           => 'required',
        );

        $messages = [
            'maspa_surat_tahun.required'   => 'Ruangan Tahun Perancangan Aktiviti RT mesti diisi.',
            'maspa_surat_tarikh.required'  => 'Ruangan Tarikh Surat mesti diisi.',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $carbon_obj = Carbon::createFromFormat('d/m/Y', $request->maspa_surat_tarikh)->format('Y-m-d');
                $surat_perancangan = new KRT_Aktiviti_Surat_Perancangan;
                $surat_perancangan->surat_tahun    = $request->maspa_surat_tahun;
                $surat_perancangan->surat_tarikh   = $carbon_obj;
                $surat_perancangan->create_by      = Auth::user()->user_id;
                $surat_perancangan->save();
                
            }
        }
    }

    function surat_perancangan_aktiviti_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__aktiviti_surat_perancangan')
                        ->select('krt__aktiviti_surat_perancangan.id',
                                'krt__aktiviti_surat_perancangan.surat_tahun',
                                DB::raw(" DATE_FORMAT(krt__aktiviti_surat_perancangan.surat_tarikh,'%d/%m/%Y') AS surat_tarikh"),
                                'krt__aktiviti_surat_perancangan.created_at',
                                'users__profile.user_fullname AS create_by')
                        ->leftJoin('users__profile','users__profile.user_id','=','krt__aktiviti_surat_perancangan.create_by')
                        ->orderBy('krt__aktiviti_surat_perancangan.id', 'asc')
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
            return view('rt-sm6.surat-perancangan-aktiviti-ppn',compact('roles_menu'));
        }
    }

    function surat_perancangan_aktiviti_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__aktiviti_surat_perancangan')
                        ->select('krt__aktiviti_surat_perancangan.id',
                                'krt__aktiviti_surat_perancangan.surat_tahun',
                                DB::raw(" DATE_FORMAT(krt__aktiviti_surat_perancangan.surat_tarikh,'%d/%m/%Y') AS surat_tarikh"),
                                'krt__aktiviti_surat_perancangan.created_at',
                                'users__profile.user_fullname AS create_by')
                        ->leftJoin('users__profile','users__profile.user_id','=','krt__aktiviti_surat_perancangan.create_by')
                        ->orderBy('krt__aktiviti_surat_perancangan.id', 'asc')
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
            return view('rt-sm6.surat-perancangan-aktiviti-ppd',compact('roles_menu'));
        }
    }

    function surat_perancangan_aktiviti_krt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__aktiviti_surat_perancangan')
                        ->select('krt__aktiviti_surat_perancangan.id',
                                'krt__aktiviti_surat_perancangan.surat_tahun',
                                DB::raw(" DATE_FORMAT(krt__aktiviti_surat_perancangan.surat_tarikh,'%d/%m/%Y') AS surat_tarikh"),
                                'krt__aktiviti_surat_perancangan.created_at',
                                'users__profile.user_fullname AS create_by')
                        ->leftJoin('users__profile','users__profile.user_id','=','krt__aktiviti_surat_perancangan.create_by')
                        ->orderBy('krt__aktiviti_surat_perancangan.id', 'asc')
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
            return view('rt-sm6.surat-perancangan-aktiviti-krt',compact('roles_menu'));
        }
    }

    function surat_perancangan_aktiviti_admin(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__aktiviti_surat_perancangan')
                        ->select('krt__aktiviti_surat_perancangan.id',
                                'krt__aktiviti_surat_perancangan.surat_tahun',
                                DB::raw(" DATE_FORMAT(krt__aktiviti_surat_perancangan.surat_tarikh,'%d/%m/%Y') AS surat_tarikh"),
                                'krt__aktiviti_surat_perancangan.created_at',
                                'users__profile.user_fullname AS create_by')
                        ->leftJoin('users__profile','users__profile.user_id','=','krt__aktiviti_surat_perancangan.create_by')
                        ->orderBy('krt__aktiviti_surat_perancangan.id', 'asc')
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
            return view('rt-sm6.surat-perancangan-aktiviti-hq',compact('roles_menu'));
        }
    }

    function penyediaan_perancangan_aktiviti_krt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__aktiviti_perancangan')
                        ->select('krt__aktiviti_perancangan.id',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__aktiviti_perancangan.aktiviti_tajuk AS aktiviti_tajuk',
                               'ref__aktiviti_agenda_kerja.agenda_description AS aktiviti_agenda',
                               'ref__aktiviti_bidang.bidang_description AS aktiviti_bidang',
                               DB::raw(" DATE_FORMAT(krt__aktiviti_perancangan.aktiviti_tarikh_rancang,'%d/%m/%Y') AS aktiviti_tarikh_rancang"),
                               DB::raw(" DATE_FORMAT(krt__aktiviti_perancangan.aktiviti_tarikh,'%d/%m/%Y') AS aktiviti_tarikh"),
                               'ref__status_aktiviti.status_description AS status_description',
                               'krt__aktiviti_perancangan.aktiviti_status AS aktiviti_status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_perancangan.krt_profile_id')
                        ->leftJoin('ref__aktiviti_agenda_kerja','ref__aktiviti_agenda_kerja.id','=','krt__aktiviti_perancangan.agenda_id')
                        ->leftJoin('ref__aktiviti_bidang','ref__aktiviti_bidang.id','=','krt__aktiviti_perancangan.bidang_id')
                        ->leftJoin('ref__status_aktiviti','ref__status_aktiviti.id','=','krt__aktiviti_perancangan.aktiviti_status')
                        ->orderBy('krt__aktiviti_perancangan.id', 'asc')
                        ->whereIn('krt__aktiviti_perancangan.aktiviti_status', [2,3,4])
                        ->where('krt__aktiviti_perancangan.krt_profile_id', '=', Auth::user()->krt_id)
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
            return view('rt-sm6.penyediaan-perancangan-aktiviti-krt',compact('roles_menu'));
        }
    }

    function post_penyediaan_perancangan_aktiviti_krt(Request $request){
        
        $action = $request->add_penyediaan_perancangan_aktiviti_krt;
        
        $rules = array(
           
        );

        $messages = [
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm6.penyediaan_perancangan_aktiviti_krt'))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'add') {
                $perancangan_aktiviti = new KRT_Aktiviti_Perancangan;
                $perancangan_aktiviti->krt_profile_id       = Auth::user()->krt_id;
                $perancangan_aktiviti->aktiviti_status      = 2;
                $perancangan_aktiviti->save();
            }
            return Redirect::to(route('rt-sm6.penyediaan_perancangan_aktiviti_krt_1',$perancangan_aktiviti->id));
        }

    }

    function penyediaan_perancangan_aktiviti_krt_1(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_program') {
                $value = $request->value;
                $where = array('agenda_id' => $value);
                $data  = Ref_Aktiviti_Program::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_sub_bidang') {
                $value = $request->value;
                $where = array('bidang_id' => $value);
                $data  = Ref_Aktiviti_Sub_Bidang::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_aktiviti') {
                $value = $request->value;
                $where = array('sub_bidang_id' => $value);
                $data  = Ref_Aktiviti::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_aktiviti_sub') {
                $value = $request->value;
                $where = array('aktiviti_id' => $value);
                $data  = Ref_Aktiviti_Sub::where($where)->get();
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
            $perancangan_aktiviti   = DB::table('krt__aktiviti_perancangan')
                                    ->select('krt__aktiviti_perancangan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_perancangan.state_id AS state_id',
                                            'krt__aktiviti_perancangan.daerah_id AS daerah_id',
                                            'krt__aktiviti_perancangan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_perancangan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL',
                                            'krt__aktiviti_perancangan.aktiviti_tajuk AS aktiviti_tajuk',
                                            DB::raw(" DATE_FORMAT(krt__aktiviti_perancangan.aktiviti_tarikh,'%d/%m/%Y') AS aktiviti_tarikh"),
                                            DB::raw(" DATE_FORMAT(krt__aktiviti_perancangan.aktiviti_tarikh_rancang,'%d/%m/%Y') AS aktiviti_tarikh_rancang"),
                                            'krt__aktiviti_perancangan.aktiviti_masa AS aktiviti_masa',
                                            'krt__aktiviti_perancangan.penganjur_id AS penganjur_id',
                                            'krt__aktiviti_perancangan.peringkat_id AS peringkat_id',
                                            'krt__aktiviti_perancangan.agenda_id AS agenda_id',
                                            'krt__aktiviti_perancangan.program_id AS program_id',
                                            'krt__aktiviti_perancangan.bidang_id AS bidang_id',
                                            'krt__aktiviti_perancangan.aktiviti_id AS aktiviti_id',
                                            'krt__aktiviti_perancangan.sub_aktiviti_id AS sub_aktiviti_id',
                                            'krt__aktiviti_perancangan.aktiviti_pembelanjaan AS aktiviti_pembelanjaan',
                                            'krt__aktiviti_perancangan.kewangan_id AS kewangan_id',
                                            'krt__aktiviti_perancangan.aktiviti_sasar AS aktiviti_sasar',
                                            'krt__aktiviti_perancangan.aktiviti_perasmi AS aktiviti_perasmi',
                                            'ref__status_aktiviti.status_description AS status_description',
                                            'krt__aktiviti_perancangan.aktiviti_status AS aktiviti_status',
                                            'krt__aktiviti_perancangan.disahkan_note AS disahkan_note')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_perancangan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_aktiviti','ref__status_aktiviti.id','=','krt__aktiviti_perancangan.aktiviti_status')
                                    ->where('krt__aktiviti_perancangan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state           = RefStates::where('status', '=',  true)->get();
            $daerah          = RefDaerah::where('status', '=',  true)->get();
            $penganjur       = Ref_Aktiviti_Penganjur::where('status', '=',  true)->get();
            $peringkat       = Ref_Aktiviti_Peringkat::where('status', '=',  true)->get();
            $agenda          = Ref_Aktiviti_Agenda_Kerja::where('status', '=',  true)->get();
            $bidang          = Ref_Aktiviti_Bidang::where('status', '=',  true)->get();
            $aktiviti        = Ref_Aktiviti::where('status', '=',  true)->get();
            $program         = Ref_Aktiviti_Program::where('status', '=',  true)->get();
            $sub_aktiviti    = Ref_Aktiviti_Sub::where('status', '=',  true)->get();
            $bahagian        = Ref_Aktiviti_Bahagian::where('status', '=',  true)->get();
            $sumber_kewangan = Ref_Aktiviti_Sumber_Kewangan::where('status', '=',  true)->get();
            return view('rt-sm6.penyediaan-perancangan-aktiviti-krt-1', 
            compact('roles_menu','perancangan_aktiviti', 'state', 'daerah', 'penganjur', 'peringkat', 'agenda', 'bidang', 'aktiviti', 'program', 'sub_aktiviti', 'bahagian', 'sumber_kewangan'));
        }
    }

    function post_penyediaan_perancangan_aktiviti_krt_1(Request $request){
        $action = $request->update_penyediaan_perancangan_aktiviti;
        $app_id = $request->ppak1_aktiviti_perancangan_id;
        
        $rules = array(
            'ppak_state_id'                         => 'required',
            'ppak_daerah_id'                        => 'required',
            'ppak_aktiviti_tempat'                  => 'required',
            'ppak1_aktiviti_tajuk'                  => 'required',
            'ppak1_aktiviti_tarikh'                 => 'required',
            'ppak1_aktiviti_tarikh_rancang'         => 'required',
            'ppak1_aktiviti_masa'                   => 'required',
            'ppak1_penganjur_id'                    => 'required',
            'ppak1_peringkat_id'                    => 'required',
            'ppak1_agenda_id'                       => 'required',
            'ppak1_program_id'                      => 'required',
            'ppak1_bidang_id'                       => 'required',
            'ppak1_aktiviti_id'                     => 'required',
            'ppak1_sub_aktiviti_id'                 => 'required',
            'ppak1_aktiviti_pembelanjaan'           => 'required',
            'ppak1_kewangan_id'                     => 'required',
            'ppak1_aktiviti_sasar'                  => 'required',
            'ppak1_aktiviti_perasmi'                => 'required'
        );

        $messages = [
            'ppak_state_id.required'                      => 'Ruangan negeri mesti dipilih.',
            'ppak_daerah_id.required'                     => 'Ruangan daerah mesti dipilih.',
            'ppak_aktiviti_tempat.required'               => 'Ruangan tempat mesti diisi.',
            'ppak1_aktiviti_tajuk.required'               => 'Ruangan tajuk aktiviti mesti diisi.',
            'ppak1_aktiviti_tarikh.required'              => 'Ruangan tarikh aktiviti mesti dipilih.',
            'ppak1_aktiviti_tarikh_rancang.required'      => 'Ruangan tarikh rancang aktiviti mesti dipilih.',
            'ppak1_aktiviti_masa.required'                => 'Ruangan masa aktiviti mesti diisi.',
            'ppak1_penganjur_id.required'                 => 'Ruangan Penganjur mesti dipilih.',
            'ppak1_peringkat_id.required'                 => 'Ruangan Peringkat mesti dipilih.',
            'ppak1_agenda_id.required'                    => 'Ruangan agenda mesti dipilih.',
            'ppak1_program_id.required'                   => 'Ruangan Program mesti dipilih.',
            'ppak1_bidang_id.required'                    => 'Ruangan bidang mesti dipilih.',
            'ppak1_aktiviti_id.required'                  => 'Ruangan Kategrori Aktiviti mesti dipilih.',
            'ppak1_sub_aktiviti_id.required'              => 'Ruangan Jenis Aktiviti mesti dipilih.',
            'ppak1_aktiviti_pembelanjaan.required'        => 'Ruangan pembelanjaan mesti diisi.',
            'ppak1_kewangan_id.required'                  => 'Ruangan sumber kewangan mesti dipilih.',
            'ppak1_aktiviti_sasar.required'               => 'Ruangan kumpulan sasar mesti diisi.',
            'ppak1_aktiviti_perasmi.required'             => 'Ruangan perasmi mesti diisi.'
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $carbon_obj = Carbon::createFromFormat('d/m/Y', $request->ppak1_aktiviti_tarikh)->format('Y-m-d');
                $carbon_obj_1 = Carbon::createFromFormat('d/m/Y', $request->ppak1_aktiviti_tarikh_rancang)->format('Y-m-d');
                $where = array('id' => $app_id);
                $perancangan_aktiviti = KRT_Aktiviti_Perancangan::where($where)->first();
                $perancangan_aktiviti->state_id                     = $request->ppak_state_id;
                $perancangan_aktiviti->daerah_id                    = $request->ppak_daerah_id;
                $perancangan_aktiviti->aktiviti_tempat              = $request->ppak_aktiviti_tempat;
                $perancangan_aktiviti->aktiviti_kawasan_DL          = $request->ppak_aktiviti_kawasan_DL;
                $perancangan_aktiviti->aktiviti_tajuk               = $request->ppak1_aktiviti_tajuk;
                $perancangan_aktiviti->aktiviti_tarikh              = $carbon_obj;
                $perancangan_aktiviti->aktiviti_tarikh_rancang      = $carbon_obj_1;
                $perancangan_aktiviti->aktiviti_masa                = $request->ppak1_aktiviti_masa;
                $perancangan_aktiviti->penganjur_id                 = $request->ppak1_penganjur_id;
                $perancangan_aktiviti->peringkat_id                 = $request->ppak1_peringkat_id;
                $perancangan_aktiviti->agenda_id                    = $request->ppak1_agenda_id;
                $perancangan_aktiviti->program_id                   = $request->ppak1_program_id;
                $perancangan_aktiviti->bidang_id                    = $request->ppak1_bidang_id;
                $perancangan_aktiviti->aktiviti_id                  = $request->ppak1_aktiviti_id;
                $perancangan_aktiviti->sub_aktiviti_id              = $request->ppak1_sub_aktiviti_id;
                $perancangan_aktiviti->aktiviti_pembelanjaan        = $request->ppak1_aktiviti_pembelanjaan;
                $perancangan_aktiviti->kewangan_id                  = $request->ppak1_kewangan_id;
                $perancangan_aktiviti->aktiviti_sasar               = $request->ppak1_aktiviti_sasar;
                $perancangan_aktiviti->aktiviti_perasmi             = $request->ppak1_aktiviti_perasmi;
                $perancangan_aktiviti->save();
            }
            return \Response::json(array('success' => '1'));
        }

    }

    function penyediaan_perancangan_aktiviti_krt_2(Request $request, $id){
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
            $perancangan_aktiviti   = DB::table('krt__aktiviti_perancangan')
                                    ->select('krt__aktiviti_perancangan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_perancangan.state_id AS state_id',
                                            'krt__aktiviti_perancangan.daerah_id AS daerah_id',
                                            'krt__aktiviti_perancangan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_perancangan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL',
                                            'ref__status_aktiviti.status_description AS status_description',
                                            'krt__aktiviti_perancangan.aktiviti_status AS aktiviti_status',
                                            'krt__aktiviti_perancangan.disahkan_note AS disahkan_note')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_perancangan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_aktiviti','ref__status_aktiviti.id','=','krt__aktiviti_perancangan.aktiviti_status')
                                    ->where('krt__aktiviti_perancangan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state          = RefStates::where('status', '=',  true)->get();
            $daerah         = RefDaerah::where('status', '=',  true)->get();
            $kaum           = RefKaum::where('status', '=',  true)->get();
            $jantina        = RefJantina::where('status', '=',  true)->get();
            $umur           = Ref_Kelompok_Umur::where('status', '=',  true)->get();
            $rakan_perpaduan = Ref_Rakan_Perpaduan::where('status', '=',  true)->get();
            $sumbangan       = Ref_Sumbangan::where('status', '=',  true)->get();
            return view('rt-sm6.penyediaan-perancangan-aktiviti-krt-2',compact('roles_menu','perancangan_aktiviti','state','daerah', 'kaum', 'jantina', 'umur', 'rakan_perpaduan', 'sumbangan'));
        }
    }

    function get_penyertaan_table(Request $request, $id){
        $data = DB::table('ref__kaum')
                    ->select('ref__kaum.id AS id',
                    'ref__kaum.kaum_description AS kaum',
                    DB::raw('SUM(case when krt__aktiviti_perancangan_penyertaan.jantina_id = 1 then krt__aktiviti_perancangan_penyertaan.penyertaan_jumlah else 0 end) AS lelaki'),
                    DB::raw('SUM(case when krt__aktiviti_perancangan_penyertaan.jantina_id = 2 then krt__aktiviti_perancangan_penyertaan.penyertaan_jumlah else 0 end) AS perempuan'),
                    DB::raw('SUM(case when krt__aktiviti_perancangan_penyertaan.umur_id = 1 then krt__aktiviti_perancangan_penyertaan.penyertaan_jumlah else 0 end) AS umur_1'),
                    DB::raw('SUM(case when krt__aktiviti_perancangan_penyertaan.umur_id = 2 then krt__aktiviti_perancangan_penyertaan.penyertaan_jumlah else 0 end) AS umur_2'),
                    DB::raw('SUM(case when krt__aktiviti_perancangan_penyertaan.umur_id = 3 then krt__aktiviti_perancangan_penyertaan.penyertaan_jumlah else 0 end) AS umur_3'),
                    DB::raw('SUM(case when krt__aktiviti_perancangan_penyertaan.umur_id = 4 then krt__aktiviti_perancangan_penyertaan.penyertaan_jumlah else 0 end) AS umur_4'),
                    DB::raw('SUM(case when krt__aktiviti_perancangan_penyertaan.umur_id = 5 then krt__aktiviti_perancangan_penyertaan.penyertaan_jumlah else 0 end) AS umur_5'),
                    DB::raw('SUM(case when krt__aktiviti_perancangan_penyertaan.umur_id = 6 then krt__aktiviti_perancangan_penyertaan.penyertaan_jumlah else 0 end) AS umur_6'),
                    DB::raw('SUM(case when krt__aktiviti_perancangan_penyertaan.umur_id = 7 then krt__aktiviti_perancangan_penyertaan.penyertaan_jumlah else 0 end) AS umur_7'),
                    DB::raw('SUM(krt__aktiviti_perancangan_penyertaan.penyertaan_jumlah) AS jumlah'))
                    ->join('krt__aktiviti_perancangan_penyertaan','krt__aktiviti_perancangan_penyertaan.kaum_id','=','ref__kaum.id')
                    ->groupBy(['ref__kaum.id','ref__kaum.kaum_description'])
                    ->orderBy('id', 'asc')
                    ->where('krt__aktiviti_perancangan_penyertaan.aktiviti_perancangan_id', '=', $id) 
                    ->get();
                return Datatables::of($data)
                        ->make(true);
        
    }

    function post_perancangan_penyertaan(Request $request){
        $action = $request->add_aktiviti_perancangan_penyertaan;
        $app_id = $request->ppak3_aktiviti_perancangan_id;
        
        $rules = array(
            'ppak3_kaum_id'                     => 'required',
            'ppak3_jantina_id'                  => 'required',
            'ppak3_umur_id'                     => 'required',
            'ppak3_penyertaan_jumlah'           => 'required'
        );

        $messages = [
            'ppak3_kaum_id.required'            => 'Ruangan komposisi kaum mesti dipilih.',
            'ppak3_jantina_id.required'         => 'Ruangan jantina mesti dipilih.',
            'ppak3_umur_id.required'            => 'Ruangan umur mesti dipilih.',
            'ppak3_penyertaan_jumlah.required'  => 'Ruangan Jumlah mesti diisi.',
            
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $perancangan_penyertaan = new KRT_Aktiviti_Perancangan_Penyertaan;
                $perancangan_penyertaan->aktiviti_perancangan_id    = $request->ppak3_aktiviti_perancangan_id;
                $perancangan_penyertaan->kaum_id                    = $request->ppak3_kaum_id;
                $perancangan_penyertaan->jantina_id                 = $request->ppak3_jantina_id;
                $perancangan_penyertaan->umur_id                    = $request->ppak3_umur_id;
                $perancangan_penyertaan->penyertaan_jumlah                    = $request->ppak3_penyertaan_jumlah;
                $perancangan_penyertaan->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_penyertaan($id){
        $data = DB::table('krt__aktiviti_perancangan_penyertaan')->where('kaum_id', '=', $id)->delete();
    }

    function get_rakan_perpaduan_table(Request $request, $id){
        $data = DB::table('krt__aktiviti_perancangan_rakan_perpaduan')
                    ->select('krt__aktiviti_perancangan_rakan_perpaduan.id AS id',
                    'ref__rakan_perpaduan.rakan_description AS rakan_perpaduan',
                    'ref__sumbangan.sumbangan_description AS bentuk_sumbangan',
                    'krt__aktiviti_perancangan_rakan_perpaduan.rakan_perpaduan_jumlah AS jumlah')
                    ->join('ref__rakan_perpaduan','ref__rakan_perpaduan.id','=','krt__aktiviti_perancangan_rakan_perpaduan.rakan_id')
                    ->join('ref__sumbangan','ref__sumbangan.id','=','krt__aktiviti_perancangan_rakan_perpaduan.sumbangan_id')
                    ->orderBy('id', 'asc')
                    ->where('krt__aktiviti_perancangan_rakan_perpaduan.aktiviti_perancangan_id', '=', $id) 
                    ->get();
                return Datatables::of($data)
                        ->make(true);
    }

    function post_perancangan_rakan_perpaduan(Request $request){
        $action = $request->add_aktiviti_perancangan_rakan_perpaduan;
        $app_id = $request->ppak4_aktiviti_perancangan_id;
        
        $rules = array(
            'ppak4_rakan_id'                         => 'required',
            'ppak4_sumbangan_id'                     => 'required',
            'ppak4_rakan_perpaduan_jumlah'           => 'required'
        );

        $messages = [
            'ppak4_rakan_id.required'                => 'Ruangan Rakan Perpaduan mesti dipilih.',
            'ppak4_sumbangan_id.required'            => 'Ruangan Bentuk Sumbangan mesti dipilih.',
            'ppak4_rakan_perpaduan_jumlah.required'  => 'Ruangan Jumlah mesti diisi.'
            
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $perancangan_rakan = new KRT_Aktiviti_Perancangan_Rakan_Perpaduan;
                $perancangan_rakan->aktiviti_perancangan_id    = $request->ppak4_aktiviti_perancangan_id;
                $perancangan_rakan->rakan_id                   = $request->ppak4_rakan_id;
                $perancangan_rakan->sumbangan_id               = $request->ppak4_sumbangan_id;
                $perancangan_rakan->rakan_perpaduan_jumlah     = $request->ppak4_rakan_perpaduan_jumlah;
                $perancangan_rakan->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_rakan_perpaduan($id){
        $data = DB::table('krt__aktiviti_perancangan_rakan_perpaduan')->where('id', '=', $id)->delete();
    }

    function penyediaan_perancangan_aktiviti_krt_3(Request $request, $id){
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
            $perancangan_aktiviti   = DB::table('krt__aktiviti_perancangan')
                                    ->select('krt__aktiviti_perancangan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_perancangan.state_id AS state_id',
                                            'krt__aktiviti_perancangan.daerah_id AS daerah_id',
                                            'krt__aktiviti_perancangan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_perancangan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL',
                                            'krt__aktiviti_perancangan.aktiviti_ringkasan_program AS aktiviti_ringkasan_program',
                                            'krt__aktiviti_perancangan.aktiviti_post_mortem AS aktiviti_post_mortem',
                                            'krt__aktiviti_perancangan.aktiviti_soal_selidik AS aktiviti_soal_selidik',
                                            'krt__aktiviti_perancangan.aktiviti_pemerhatian AS aktiviti_pemerhatian',
                                            'krt__aktiviti_perancangan.aktiviti_temubual AS aktiviti_temubual',
                                            'krt__aktiviti_perancangan.aktiviti_kekuatan AS aktiviti_kekuatan',
                                            'krt__aktiviti_perancangan.aktiviti_keberkesanan AS aktiviti_keberkesanan',
                                            'krt__aktiviti_perancangan.aktiviti_penambahbaikan AS aktiviti_penambahbaikan',
                                            'ref__status_aktiviti.status_description AS status_description',
                                            'krt__aktiviti_perancangan.aktiviti_status AS aktiviti_status',
                                            'krt__aktiviti_perancangan.disahkan_note AS disahkan_note')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_perancangan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_aktiviti','ref__status_aktiviti.id','=','krt__aktiviti_perancangan.aktiviti_status')
                                    ->where('krt__aktiviti_perancangan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state          = RefStates::where('status', '=',  true)->get();
            $daerah         = RefDaerah::where('status', '=',  true)->get();
            return view('rt-sm6.penyediaan-perancangan-aktiviti-krt-3',compact('roles_menu','perancangan_aktiviti','state','daerah'));
        }
    }

    function post_penyediaan_perancangan_aktiviti_krt_2(Request $request){
        $action = $request->update_penyediaan_perancangan_aktiviti;
        $app_id = $request->ppak6_aktiviti_perancangan_id;
        
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
                $perancangan_aktiviti = KRT_Aktiviti_Perancangan::where($where)->first();
                $perancangan_aktiviti->aktiviti_ringkasan_program   = $request->ppak6_aktiviti_ringkasan_program;
                // $perancangan_aktiviti->aktiviti_post_mortem         = $request->ppak6_aktiviti_post_mortem;
                // $perancangan_aktiviti->aktiviti_soal_selidik        = $request->ppak6_aktiviti_soal_selidik;
                // $perancangan_aktiviti->aktiviti_pemerhatian         = $request->ppak6_aktiviti_pemerhatian;
                // $perancangan_aktiviti->aktiviti_temubual            = $request->ppak6_aktiviti_temubual;
                // $perancangan_aktiviti->aktiviti_kekuatan            = $request->ppak6_aktiviti_kekuatan;
                // $perancangan_aktiviti->aktiviti_keberkesanan        = $request->ppak6_aktiviti_keberkesanan;
                // $perancangan_aktiviti->aktiviti_penambahbaikan      = $request->ppak6_aktiviti_penambahbaikan;
                $perancangan_aktiviti->aktiviti_status              = 3;
                $perancangan_aktiviti->dihantar_by                  = Auth::user()->user_id;
                $perancangan_aktiviti->dihantar_date                = date('Y-m-d H:i:s');
                $perancangan_aktiviti->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function pengesahan_perancangan_aktiviti_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__aktiviti_perancangan')
                        ->select('krt__aktiviti_perancangan.id',
                                'ref__daerahs.daerah_id AS daerah_id',
                                'krt__profile.krt_nama AS krt_nama',
                                'krt__aktiviti_perancangan.aktiviti_tajuk AS aktiviti_tajuk',
                                'ref__aktiviti_agenda_kerja.agenda_description AS aktiviti_agenda',
                                'ref__aktiviti_bidang.bidang_description AS aktiviti_bidang',
                                DB::raw(" DATE_FORMAT(krt__aktiviti_perancangan.aktiviti_tarikh_rancang,'%d/%m/%Y') AS aktiviti_tarikh_rancang"),
                                DB::raw(" DATE_FORMAT(krt__aktiviti_perancangan.aktiviti_tarikh,'%d/%m/%Y') AS aktiviti_tarikh"),
                                'ref__status_aktiviti.status_description AS status_description',
                                'krt__aktiviti_perancangan.aktiviti_status AS aktiviti_status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_perancangan.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__aktiviti_agenda_kerja','ref__aktiviti_agenda_kerja.id','=','krt__aktiviti_perancangan.agenda_id')
                        ->leftJoin('ref__aktiviti_bidang','ref__aktiviti_bidang.id','=','krt__aktiviti_perancangan.bidang_id')
                        ->leftJoin('ref__status_aktiviti','ref__status_aktiviti.id','=','krt__aktiviti_perancangan.aktiviti_status')
                        ->orderBy('krt__aktiviti_perancangan.id', 'asc')
                        ->where('krt__aktiviti_perancangan.aktiviti_status', '=', 3)
                        ->where('ref__daerahs.daerah_id', '=', Auth::user()->daerah_id)
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
            $krt  = KRT_Profile::where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)
                        ->where('krt__profile.krt_status', '=', 1)
                        ->get();
            return view('rt-sm6.pengesahan-perancangan-aktiviti-ppd', compact('roles_menu','krt'));
        }
    }

    function pengesahan_perancangan_aktiviti_ppd_1(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_program') {
                $value = $request->value;
                $where = array('agenda_id' => $value);
                $data  = Ref_Aktiviti_Program::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_sub_bidang') {
                $value = $request->value;
                $where = array('bidang_id' => $value);
                $data  = Ref_Aktiviti_Sub_Bidang::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_aktiviti') {
                $value = $request->value;
                $where = array('sub_bidang_id' => $value);
                $data  = Ref_Aktiviti::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_aktiviti_sub') {
                $value = $request->value;
                $where = array('aktiviti_id' => $value);
                $data  = Ref_Aktiviti_Sub::where($where)->get();
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
            $perancangan_aktiviti   = DB::table('krt__aktiviti_perancangan')
                                    ->select('krt__aktiviti_perancangan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_perancangan.state_id AS state_id',
                                            'krt__aktiviti_perancangan.daerah_id AS daerah_id',
                                            'krt__aktiviti_perancangan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_perancangan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL',
                                            'krt__aktiviti_perancangan.aktiviti_tajuk AS aktiviti_tajuk',
                                            DB::raw(" DATE_FORMAT(krt__aktiviti_perancangan.aktiviti_tarikh,'%d/%m/%Y') AS aktiviti_tarikh"),
                                            DB::raw(" DATE_FORMAT(krt__aktiviti_perancangan.aktiviti_tarikh_rancang,'%d/%m/%Y') AS aktiviti_tarikh_rancang"),
                                            'krt__aktiviti_perancangan.aktiviti_masa AS aktiviti_masa',
                                            'krt__aktiviti_perancangan.penganjur_id AS penganjur_id',
                                            'krt__aktiviti_perancangan.peringkat_id AS peringkat_id',
                                            'krt__aktiviti_perancangan.agenda_id AS agenda_id',
                                            'krt__aktiviti_perancangan.program_id AS program_id',
                                            'krt__aktiviti_perancangan.bidang_id AS bidang_id',
                                            'krt__aktiviti_perancangan.aktiviti_id AS aktiviti_id',
                                            'krt__aktiviti_perancangan.sub_aktiviti_id AS sub_aktiviti_id',
                                            'krt__aktiviti_perancangan.aktiviti_pembelanjaan AS aktiviti_pembelanjaan',
                                            'krt__aktiviti_perancangan.kewangan_id AS kewangan_id',
                                            'krt__aktiviti_perancangan.aktiviti_sasar AS aktiviti_sasar',
                                            'krt__aktiviti_perancangan.aktiviti_perasmi AS aktiviti_perasmi')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_perancangan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__aktiviti_perancangan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state           = RefStates::where('status', '=',  true)->get();
            $daerah          = RefDaerah::where('status', '=',  true)->get();
            $penganjur       = Ref_Aktiviti_Penganjur::where('status', '=',  true)->get();
            $peringkat       = Ref_Aktiviti_Peringkat::where('status', '=',  true)->get();
            $agenda          = Ref_Aktiviti_Agenda_Kerja::where('status', '=',  true)->get();
            $bidang          = Ref_Aktiviti_Bidang::where('status', '=',  true)->get();
            $aktiviti        = Ref_Aktiviti::where('status', '=',  true)->get();
            $program         = Ref_Aktiviti_Program::where('status', '=',  true)->get();
            $sub_aktiviti    = Ref_Aktiviti_Sub::where('status', '=',  true)->get();
            $sumber_kewangan = Ref_Aktiviti_Sumber_Kewangan::where('status', '=',  true)->get();
            return view('rt-sm6.pengesahan-perancangan-aktiviti-ppd-1', 
            compact('roles_menu','perancangan_aktiviti', 'state', 'daerah', 'penganjur', 'peringkat', 'agenda', 'bidang', 'aktiviti', 'program', 'sub_aktiviti', 'sumber_kewangan'));
        }
    }

    function post_perancangan_aktiviti_krt_ppd(Request $request){
        $action = $request->post_perancangan_aktiviti_krt_ppd;
        $app_id = $request->ppap1_aktiviti_perancangan_id;
        
        $rules = array(
            'ppap1_bahagian_id'                         => 'required'
        );

        $messages = [
            'ppap1_bahagian_id.required'                      => 'Ruangan negeri mesti dipilih.',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $perancangan_aktiviti = KRT_Aktiviti_Perancangan::where($where)->first();
                $perancangan_aktiviti->bahagian_id                     = $request->ppap1_bahagian_id;
                $perancangan_aktiviti->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function pengesahan_perancangan_aktiviti_ppd_2(Request $request, $id){
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
            $perancangan_aktiviti   = DB::table('krt__aktiviti_perancangan')
                                    ->select('krt__aktiviti_perancangan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_perancangan.state_id AS state_id',
                                            'krt__aktiviti_perancangan.daerah_id AS daerah_id',
                                            'krt__aktiviti_perancangan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_perancangan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_perancangan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__aktiviti_perancangan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state          = RefStates::where('status', '=',  true)->get();
            $daerah         = RefDaerah::where('status', '=',  true)->get();
            $kaum           = RefKaum::where('status', '=',  true)->get();
            $jantina        = RefJantina::where('status', '=',  true)->get();
            $umur           = Ref_Kelompok_Umur::where('status', '=',  true)->get();
            $rakan_perpaduan = Ref_Rakan_Perpaduan::where('status', '=',  true)->get();
            $sumbangan       = Ref_Sumbangan::where('status', '=',  true)->get();
            return view('rt-sm6.pengesahan-perancangan-aktiviti-ppd-2',compact('roles_menu','perancangan_aktiviti','state','daerah', 'kaum', 'jantina', 'umur', 'rakan_perpaduan', 'sumbangan'));
        }
    }

    function pengesahan_perancangan_aktiviti_ppd_3(Request $request, $id){
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
            $perancangan_aktiviti   = DB::table('krt__aktiviti_perancangan')
                                    ->select('krt__aktiviti_perancangan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_perancangan.state_id AS state_id',
                                            'krt__aktiviti_perancangan.daerah_id AS daerah_id',
                                            'krt__aktiviti_perancangan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_perancangan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL',
                                            'krt__aktiviti_perancangan.aktiviti_ringkasan_program AS aktiviti_ringkasan_program',
                                            'krt__aktiviti_perancangan.aktiviti_post_mortem AS aktiviti_post_mortem',
                                            'krt__aktiviti_perancangan.aktiviti_soal_selidik AS aktiviti_soal_selidik',
                                            'krt__aktiviti_perancangan.aktiviti_pemerhatian AS aktiviti_pemerhatian',
                                            'krt__aktiviti_perancangan.aktiviti_temubual AS aktiviti_temubual',
                                            'krt__aktiviti_perancangan.aktiviti_kekuatan AS aktiviti_kekuatan',
                                            'krt__aktiviti_perancangan.aktiviti_keberkesanan AS aktiviti_keberkesanan',
                                            'krt__aktiviti_perancangan.aktiviti_penambahbaikan AS aktiviti_penambahbaikan')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_perancangan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__aktiviti_perancangan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state          = RefStates::where('status', '=',  true)->get();
            $daerah         = RefDaerah::where('status', '=',  true)->get();
            return view('rt-sm6.pengesahan-perancangan-aktiviti-ppd-3',compact('roles_menu','perancangan_aktiviti','state','daerah'));
        }
    }

    function post_pengesahan_perancangan_aktiviti(Request $request){
        $action = $request->post_pengesahan_perancangan_aktiviti;
        $app_id = $request->ppap5_aktiviti_perancangan_id;
        
        
        $rules = array(
            'ppap5_disahkan_by'                   => 'required',
            'ppap5_disahkan_note'                 => 'required',
        );

        $messages = [
            'ppap5_disahkan_by.required'          => 'Ruangan Status mesti dipilih',
            'ppap5_disahkan_note.required'        => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $pengesahan_aktiviti_perancangan                         = KRT_Aktiviti_Perancangan::where($where)->first();
                $pengesahan_aktiviti_perancangan->aktiviti_status        = $request->ppap5_disahkan_by;
                $pengesahan_aktiviti_perancangan->disahkan_note          = $request->ppap5_disahkan_note;
                $pengesahan_aktiviti_perancangan->disahkan_by            = Auth::user()->user_id;
                $pengesahan_aktiviti_perancangan->disahkan_date          = date('Y-m-d H:i:s');
                $pengesahan_aktiviti_perancangan->save();
            }
        }
    }

    function penyediaan_laporan_aktiviti_krt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__aktiviti_laporan')
                        ->select('krt__aktiviti_laporan.id',
                               'krt__profile.krt_nama AS krt_nama',
                               'krt__aktiviti_laporan.aktiviti_tajuk AS aktiviti_tajuk',
                               'ref__aktiviti_agenda_kerja.agenda_description AS aktiviti_agenda',
                               'ref__aktiviti_bidang.bidang_description AS aktiviti_bidang',
                               DB::raw(" DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh_rancang,'%d/%m/%Y') AS aktiviti_tarikh_rancang"),
                               DB::raw(" DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh,'%d/%m/%Y') AS aktiviti_tarikh"),
                               'ref__status_aktiviti.status_description AS status_description',
                               'krt__aktiviti_laporan.aktiviti_status AS aktiviti_status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
                        ->leftJoin('ref__aktiviti_agenda_kerja','ref__aktiviti_agenda_kerja.id','=','krt__aktiviti_laporan.agenda_id')
                        ->leftJoin('ref__aktiviti_bidang','ref__aktiviti_bidang.id','=','krt__aktiviti_laporan.bidang_id')
                        ->leftJoin('ref__status_aktiviti','ref__status_aktiviti.id','=','krt__aktiviti_laporan.aktiviti_status')
                        ->orderBy('krt__aktiviti_laporan.id', 'asc')
                        ->whereIn('krt__aktiviti_laporan.aktiviti_status', [2,3,4])
                        ->where('krt__aktiviti_laporan.krt_profile_id', '=', Auth::user()->krt_id)
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
            return view('rt-sm6.penyediaan-laporan-aktiviti-krt',compact('roles_menu'));
        }
    }

    function post_penyediaan_laporan_aktiviti_krt(Request $request){
        
        $action = $request->add_penyediaan_laporan_aktiviti_krt;
        
        $rules = array(
           
        );

        $messages = [
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm6.penyediaan_laporan_aktiviti_krt'))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'add') {
                $laporan_aktiviti = new KRT_Aktiviti_Laporan;
                $laporan_aktiviti->krt_profile_id       = Auth::user()->krt_id;
                $laporan_aktiviti->aktiviti_status      = 2;
                $laporan_aktiviti->save();
            }
            return Redirect::to(route('rt-sm6.penyediaan_laporan_aktiviti_krt_1',$laporan_aktiviti->id));
        }

    }

    function penyediaan_laporan_aktiviti_krt_1(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_program') {
                $value = $request->value;
                $where = array('agenda_id' => $value);
                $data  = Ref_Aktiviti_Program::where($where)->get();
                return Response::json($data);
             }else if($type == 'get_sub_bidang') {
                $value = $request->value;
                $where = array('bidang_id' => $value);
                $data  = Ref_Aktiviti_Sub_Bidang::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_aktiviti') {
                $value = $request->value;
                $where = array('sub_bidang_id' => $value);
                $data  = Ref_Aktiviti::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_aktiviti_sub') {
                $value = $request->value;
                $where = array('aktiviti_id' => $value);
                $data  = Ref_Aktiviti_Sub::where($where)->get();
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
            $laporan_aktiviti   = DB::table('krt__aktiviti_laporan')
                                    ->select('krt__aktiviti_laporan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_laporan.state_id AS state_id',
                                            'krt__aktiviti_laporan.daerah_id AS daerah_id',
                                            'krt__aktiviti_laporan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_laporan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL',
                                            'krt__aktiviti_laporan.aktiviti_tajuk AS aktiviti_tajuk',
                                            DB::raw(" DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh,'%d/%m/%Y') AS aktiviti_tarikh"),
                                            DB::raw(" DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh_rancang,'%d/%m/%Y') AS aktiviti_tarikh_rancang"),
                                            'krt__aktiviti_laporan.aktiviti_masa AS aktiviti_masa',
                                            'krt__aktiviti_laporan.penganjur_id AS penganjur_id',
                                            'krt__aktiviti_laporan.peringkat_id AS peringkat_id',
                                            'krt__aktiviti_laporan.agenda_id AS agenda_id',
                                            'krt__aktiviti_laporan.program_id AS program_id',
                                            'krt__aktiviti_laporan.bidang_id AS bidang_id',
                                            'krt__aktiviti_laporan.aktiviti_id AS aktiviti_id',
                                            'krt__aktiviti_laporan.sub_aktiviti_id AS sub_aktiviti_id',
                                            'krt__aktiviti_laporan.aktiviti_pembelanjaan AS aktiviti_pembelanjaan',
                                            'krt__aktiviti_laporan.kewangan_id AS kewangan_id',
                                            'krt__aktiviti_laporan.aktiviti_sasar AS aktiviti_sasar',
                                            'krt__aktiviti_laporan.aktiviti_perasmi AS aktiviti_perasmi',
                                            'ref__status_aktiviti.status_description AS status_description',
                                            'krt__aktiviti_laporan.aktiviti_status AS aktiviti_status',
                                            'krt__aktiviti_laporan.disahkan_note AS disahkan_note')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_aktiviti','ref__status_aktiviti.id','=','krt__aktiviti_laporan.aktiviti_status')
                                    ->where('krt__aktiviti_laporan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state           = RefStates::where('status', '=',  true)->get();
            $daerah          = RefDaerah::where('status', '=',  true)->get();
            $penganjur       = Ref_Aktiviti_Penganjur::where('status', '=',  true)->get();
            $peringkat       = Ref_Aktiviti_Peringkat::where('status', '=',  true)->get();
            $agenda          = Ref_Aktiviti_Agenda_Kerja::where('status', '=',  true)->get();
            $bidang          = Ref_Aktiviti_Bidang::where('status', '=',  true)->get();
            $aktiviti        = Ref_Aktiviti::where('status', '=',  true)->get();
            $program         = Ref_Aktiviti_Program::where('status', '=',  true)->get();
            $sub_aktiviti    = Ref_Aktiviti_Sub::where('status', '=',  true)->get();
            $bahagian        = Ref_Aktiviti_Bahagian::where('status', '=',  true)->get();
            $sumber_kewangan = Ref_Aktiviti_Sumber_Kewangan::where('status', '=',  true)->get();
            return view('rt-sm6.penyediaan-laporan-aktiviti-krt-1', 
            compact('roles_menu','laporan_aktiviti', 'state', 'daerah', 'penganjur', 'peringkat', 'agenda', 'bidang', 'aktiviti', 'program', 'sub_aktiviti', 'bahagian', 'sumber_kewangan'));
        }
    }

    function post_penyediaan_laporan_aktiviti_krt_1(Request $request){
        $action = $request->update_penyediaan_laporan_aktiviti;
        $app_id = $request->plak1_aktiviti_laporan_id;
        
        $rules = array(
            'plak_state_id'                         => 'required',
            'plak_daerah_id'                        => 'required',
            'plak_aktiviti_tempat'                  => 'required',
            'plak1_aktiviti_tajuk'                  => 'required',
            'plak1_aktiviti_tarikh'                 => 'required',
            'plak1_aktiviti_tarikh_rancang'         => 'required',
            'plak1_aktiviti_masa'                   => 'required',
            'plak1_penganjur_id'                    => 'required',
            'plak1_peringkat_id'                    => 'required',
            'plak1_agenda_id'                       => 'required',
            'plak1_program_id'                      => 'required',
            'plak1_bidang_id'                       => 'required',
            'plak1_aktiviti_id'                     => 'required',
            'plak1_sub_aktiviti_id'                 => 'required',
            'plak1_aktiviti_pembelanjaan'           => 'required',
            'plak1_kewangan_id'                     => 'required',
            'plak1_aktiviti_sasar'                  => 'required',
            'plak1_aktiviti_perasmi'                => 'required'
        );

        $messages = [
            'plak_state_id.required'                      => 'Ruangan negeri mesti dipilih.',
            'plak_daerah_id.required'                     => 'Ruangan daerah mesti dipilih.',
            'plak_aktiviti_tempat.required'               => 'Ruangan tempat mesti diisi.',
            'plak1_aktiviti_tajuk.required'               => 'Ruangan tajuk aktiviti mesti diisi.',
            'plak1_aktiviti_tarikh.required'              => 'Ruangan tarikh aktiviti mesti dipilih.',
            'plak1_aktiviti_tarikh_rancang.required'      => 'Ruangan tarikh rancang aktiviti mesti dipilih.',
            'plak1_aktiviti_masa.required'                => 'Ruangan masa aktiviti mesti diisi.',
            'plak1_penganjur_id.required'                 => 'Ruangan penganjur mesti diisi.',
            'plak1_peringkat_id.required'                 => 'Ruangan Peringkat mesti diisi.',
            'plak1_agenda_id.required'                    => 'Ruangan agenda mesti dipilih.',
            'plak1_program_id.required'                   => 'Ruangan program mesti dipilih.',
            'plak1_bidang_id.required'                    => 'Ruangan bidang mesti dipilih.',
            'plak1_aktiviti_id.required'                  => 'Ruangan Kategroti Aktiviti mesti dipilih.',
            'plak1_sub_aktiviti_id.required'              => 'Ruangan Jenis Aktiviti mesti dipilih.',
            'plak1_aktiviti_pembelanjaan.required'        => 'Ruangan pembelanjaan mesti diisi.',
            'plak1_kewangan_id.required'                  => 'Ruangan sumber kewangan mesti dipilih.',
            'plak1_aktiviti_sasar.required'               => 'Ruangan kumpulan sasar mesti diisi.',
            'plak1_aktiviti_perasmi.required'             => 'Ruangan perasmi mesti diisi.',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $carbon_obj = Carbon::createFromFormat('d/m/Y', $request->plak1_aktiviti_tarikh)->format('Y-m-d');
                $carbon_obj_1 = Carbon::createFromFormat('d/m/Y', $request->plak1_aktiviti_tarikh_rancang)->format('Y-m-d');
                $where = array('id' => $app_id);
                $laporan_aktiviti = KRT_Aktiviti_Laporan::where($where)->first();
                $laporan_aktiviti->state_id                     = $request->plak_state_id;
                $laporan_aktiviti->daerah_id                    = $request->plak_daerah_id;
                $laporan_aktiviti->aktiviti_tempat              = $request->plak_aktiviti_tempat;
                $laporan_aktiviti->aktiviti_kawasan_DL          = $request->plak_aktiviti_kawasan_DL;
                $laporan_aktiviti->aktiviti_tajuk               = $request->plak1_aktiviti_tajuk;
                $laporan_aktiviti->aktiviti_tarikh              = $carbon_obj;
                $laporan_aktiviti->aktiviti_tarikh_rancang      = $carbon_obj_1;
                $laporan_aktiviti->aktiviti_masa                = $request->plak1_aktiviti_masa;
                $laporan_aktiviti->penganjur_id                 = $request->plak1_penganjur_id;
                $laporan_aktiviti->peringkat_id                 = $request->plak1_peringkat_id;
                $laporan_aktiviti->agenda_id                    = $request->plak1_agenda_id;
                $laporan_aktiviti->program_id                   = $request->plak1_program_id;
                $laporan_aktiviti->bidang_id                    = $request->plak1_bidang_id;
                $laporan_aktiviti->aktiviti_id                  = $request->plak1_aktiviti_id;
                $laporan_aktiviti->sub_aktiviti_id              = $request->plak1_sub_aktiviti_id;
                $laporan_aktiviti->aktiviti_pembelanjaan        = $request->plak1_aktiviti_pembelanjaan;
                $laporan_aktiviti->kewangan_id                  = $request->plak1_kewangan_id;
                $laporan_aktiviti->aktiviti_sasar               = $request->plak1_aktiviti_sasar;
                $laporan_aktiviti->aktiviti_perasmi             = $request->plak1_aktiviti_perasmi;
                $laporan_aktiviti->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function penyediaan_laporan_aktiviti_krt_2(Request $request, $id){
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
            $laporan_aktiviti   = DB::table('krt__aktiviti_laporan')
                                    ->select('krt__aktiviti_laporan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_laporan.state_id AS state_id',
                                            'krt__aktiviti_laporan.daerah_id AS daerah_id',
                                            'krt__aktiviti_laporan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_laporan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL',
                                            'ref__status_aktiviti.status_description AS status_description',
                                            'krt__aktiviti_laporan.aktiviti_status AS aktiviti_status',
                                            'krt__aktiviti_laporan.disahkan_note AS disahkan_note')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_aktiviti','ref__status_aktiviti.id','=','krt__aktiviti_laporan.aktiviti_status')
                                    ->where('krt__aktiviti_laporan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state          = RefStates::where('status', '=',  true)->get();
            $daerah         = RefDaerah::where('status', '=',  true)->get();
            $kaum           = RefKaum::where('status', '=',  true)->get();
            $jantina        = RefJantina::where('status', '=',  true)->get();
            $umur           = Ref_Kelompok_Umur::where('status', '=',  true)->get();
            $rakan_perpaduan = Ref_Rakan_Perpaduan::where('status', '=',  true)->get();
            $sumbangan       = Ref_Sumbangan::where('status', '=',  true)->get();
            return view('rt-sm6.penyediaan-laporan-aktiviti-krt-2',compact('roles_menu','laporan_aktiviti','state','daerah', 'kaum', 'jantina', 'umur', 'rakan_perpaduan', 'sumbangan'));
        }
    }

    function get_laporan_penyertaan_table(Request $request, $id){
        $data = DB::table('ref__kaum')
                    ->select('ref__kaum.id AS id',
                    'ref__kaum.kaum_description AS kaum',
                    DB::raw('SUM(case when krt__aktiviti_laporan_penyertaan.jantina_id = 1 then krt__aktiviti_laporan_penyertaan.penyertaan_jumlah else 0 end) AS lelaki'),
                    DB::raw('SUM(case when krt__aktiviti_laporan_penyertaan.jantina_id = 2 then krt__aktiviti_laporan_penyertaan.penyertaan_jumlah else 0 end) AS perempuan'),
                    DB::raw('SUM(case when krt__aktiviti_laporan_penyertaan.umur_id = 1 then krt__aktiviti_laporan_penyertaan.penyertaan_jumlah else 0 end) AS umur_1'),
                    DB::raw('SUM(case when krt__aktiviti_laporan_penyertaan.umur_id = 2 then krt__aktiviti_laporan_penyertaan.penyertaan_jumlah else 0 end) AS umur_2'),
                    DB::raw('SUM(case when krt__aktiviti_laporan_penyertaan.umur_id = 3 then krt__aktiviti_laporan_penyertaan.penyertaan_jumlah else 0 end) AS umur_3'),
                    DB::raw('SUM(case when krt__aktiviti_laporan_penyertaan.umur_id = 4 then krt__aktiviti_laporan_penyertaan.penyertaan_jumlah else 0 end) AS umur_4'),
                    DB::raw('SUM(case when krt__aktiviti_laporan_penyertaan.umur_id = 5 then krt__aktiviti_laporan_penyertaan.penyertaan_jumlah else 0 end) AS umur_5'),
                    DB::raw('SUM(case when krt__aktiviti_laporan_penyertaan.umur_id = 6 then krt__aktiviti_laporan_penyertaan.penyertaan_jumlah else 0 end) AS umur_6'),
                    DB::raw('SUM(case when krt__aktiviti_laporan_penyertaan.umur_id = 7 then krt__aktiviti_laporan_penyertaan.penyertaan_jumlah else 0 end) AS umur_7'),
                    DB::raw('SUM(krt__aktiviti_laporan_penyertaan.penyertaan_jumlah) AS jumlah'))
                    ->join('krt__aktiviti_laporan_penyertaan','krt__aktiviti_laporan_penyertaan.kaum_id','=','ref__kaum.id')
                    ->groupBy(['ref__kaum.id','ref__kaum.kaum_description'])
                    ->orderBy('id', 'asc')
                    ->where('krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id', '=', $id) 
                    ->get();
                return Datatables::of($data)
                        ->make(true);
    }

    function post_laporan_penyertaan(Request $request){
        $action = $request->add_aktiviti_laporan_penyertaan;
        $app_id = $request->ppak3_aktiviti_laporan_id;
        
        $rules = array(
            'plak3_kaum_id'                     => 'required',
            'plak3_jantina_id'                  => 'required',
            'plak3_umur_id'                     => 'required',
            'plak3_penyertaan_jumlah'           => 'required'
        );

        $messages = [
            'plak3_kaum_id.required'            => 'Ruangan komposisi kaum mesti dipilih.',
            'plak3_jantina_id.required'         => 'Ruangan jantina mesti dipilih.',
            'plak3_umur_id.required'            => 'Ruangan umur mesti dipilih.',
            'plak3_penyertaan_jumlah.required'  => 'Ruangan Jumlah mesti diisi.',
            
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $laporan_penyertaan = new KRT_Aktiviti_Laporan_Penyertaan;
                $laporan_penyertaan->aktiviti_laporan_id        = $request->plak3_aktiviti_laporan_id;
                $laporan_penyertaan->kaum_id                    = $request->plak3_kaum_id;
                $laporan_penyertaan->jantina_id                 = $request->plak3_jantina_id;
                $laporan_penyertaan->umur_id                    = $request->plak3_umur_id;
                $laporan_penyertaan->penyertaan_jumlah          = $request->plak3_penyertaan_jumlah;
                $laporan_penyertaan->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_laporan_penyertaan($id){
        $data = DB::table('krt__aktiviti_laporan_penyertaan')->where('kaum_id', '=', $id)->delete();
    }

    function get_laporan_rakan_perpaduan_table(Request $request, $id){
        $data = DB::table('krt__aktiviti_laporan_rakan_perpaduan')
                    ->select('krt__aktiviti_laporan_rakan_perpaduan.id AS id',
                    'ref__rakan_perpaduan.rakan_description AS rakan_perpaduan',
                    'ref__sumbangan.sumbangan_description AS bentuk_sumbangan',
                    'krt__aktiviti_laporan_rakan_perpaduan.rakan_perpaduan_jumlah AS jumlah')
                    ->join('ref__rakan_perpaduan','ref__rakan_perpaduan.id','=','krt__aktiviti_laporan_rakan_perpaduan.rakan_id')
                    ->join('ref__sumbangan','ref__sumbangan.id','=','krt__aktiviti_laporan_rakan_perpaduan.sumbangan_id')
                    ->orderBy('id', 'asc')
                    ->where('krt__aktiviti_laporan_rakan_perpaduan.aktiviti_laporan_id', '=', $id) 
                    ->get();
                return Datatables::of($data)
                        ->make(true);
    }

    function post_laporan_rakan_perpaduan(Request $request){
        $action = $request->add_aktiviti_laporan_rakan_perpaduan;
        $app_id = $request->ppak4_aktiviti_laporan_id;
        
        $rules = array(
            'plak4_rakan_id'                         => 'required',
            'plak4_sumbangan_id'                     => 'required',
            'plak4_rakan_perpaduan_jumlah'           => 'required'
        );

        $messages = [
            'plak4_rakan_id.required'                => 'Ruangan Rakan Perpaduan mesti dipilih.',
            'plak4_sumbangan_id.required'            => 'Ruangan Bentuk Sumbangan mesti dipilih.',
            'plak4_rakan_perpaduan_jumlah.required'  => 'Ruangan Jumlah mesti diisi.'
            
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                
                $laporan_rakan = new KRT_Aktiviti_Laporan_Rakan_Perpaduan;
                $laporan_rakan->aktiviti_laporan_id        = $request->plak4_aktiviti_laporan_id;
                $laporan_rakan->rakan_id                   = $request->plak4_rakan_id;
                $laporan_rakan->sumbangan_id               = $request->plak4_sumbangan_id;
                $laporan_rakan->rakan_perpaduan_jumlah     = $request->plak4_rakan_perpaduan_jumlah;
                $laporan_rakan->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function delete_laporan_rakan_perpaduan($id){
        $data = DB::table('krt__aktiviti_laporan_rakan_perpaduan')->where('id', '=', $id)->delete();
    }

    function penyediaan_laporan_aktiviti_krt_3(Request $request, $id){
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
            $laporan_aktiviti   = DB::table('krt__aktiviti_laporan')
                                    ->select('krt__aktiviti_laporan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_laporan.state_id AS state_id',
                                            'krt__aktiviti_laporan.daerah_id AS daerah_id',
                                            'krt__aktiviti_laporan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_laporan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL',
                                            'krt__aktiviti_laporan.aktiviti_ringkasan_program AS aktiviti_ringkasan_program',
                                            'krt__aktiviti_laporan.aktiviti_post_mortem AS aktiviti_post_mortem',
                                            'krt__aktiviti_laporan.aktiviti_soal_selidik AS aktiviti_soal_selidik',
                                            'krt__aktiviti_laporan.aktiviti_pemerhatian AS aktiviti_pemerhatian',
                                            'krt__aktiviti_laporan.aktiviti_temubual AS aktiviti_temubual',
                                            'krt__aktiviti_laporan.aktiviti_kekuatan AS aktiviti_kekuatan',
                                            'krt__aktiviti_laporan.aktiviti_keberkesanan AS aktiviti_keberkesanan',
                                            'krt__aktiviti_laporan.aktiviti_penambahbaikan AS aktiviti_penambahbaikan',
                                            'ref__status_aktiviti.status_description AS status_description',
                                            'krt__aktiviti_laporan.aktiviti_status AS aktiviti_status',
                                            'krt__aktiviti_laporan.disahkan_note AS disahkan_note')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_aktiviti','ref__status_aktiviti.id','=','krt__aktiviti_laporan.aktiviti_status')
                                    ->where('krt__aktiviti_laporan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state          = RefStates::where('status', '=',  true)->get();
            $daerah         = RefDaerah::where('status', '=',  true)->get();
            return view('rt-sm6.penyediaan-laporan-aktiviti-krt-3',compact('roles_menu','laporan_aktiviti','state','daerah'));
        }
    }

    function post_penyediaan_laporan_aktiviti_krt_2(Request $request){
        $action = $request->update_penyediaan_laporan_aktiviti;
        $app_id = $request->plak6_aktiviti_laporan_id;
        
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
                $laporan = KRT_Aktiviti_Laporan::where($where)->first();
                $laporan->aktiviti_ringkasan_program   = $request->plak6_aktiviti_ringkasan_program;
                $laporan->aktiviti_post_mortem         = $request->plak6_aktiviti_post_mortem;
                $laporan->aktiviti_soal_selidik        = $request->plak6_aktiviti_soal_selidik;
                $laporan->aktiviti_pemerhatian         = $request->plak6_aktiviti_pemerhatian;
                $laporan->aktiviti_temubual            = $request->plak6_aktiviti_temubual;
                $laporan->aktiviti_kekuatan            = $request->plak6_aktiviti_kekuatan;
                $laporan->aktiviti_keberkesanan        = $request->plak6_aktiviti_keberkesanan;
                $laporan->aktiviti_penambahbaikan      = $request->plak6_aktiviti_penambahbaikan;
                $laporan->aktiviti_status              = 3;
                $laporan->dihantar_by                  = Auth::user()->user_id;
                $laporan->dihantar_date                = date('Y-m-d H:i:s');
                $laporan->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function pengesahan_laporan_aktiviti_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__aktiviti_laporan')
                        ->select('krt__aktiviti_laporan.id',
                                'ref__daerahs.daerah_id AS daerah_id',
                                'krt__profile.krt_nama AS krt_nama',
                                'krt__aktiviti_laporan.aktiviti_tajuk AS aktiviti_tajuk',
                                'ref__aktiviti_agenda_kerja.agenda_description AS aktiviti_agenda',
                                'ref__aktiviti_bidang.bidang_description AS aktiviti_bidang',
                                DB::raw(" DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh_rancang,'%d/%m/%Y') AS aktiviti_tarikh_rancang"),
                                DB::raw(" DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh,'%d/%m/%Y') AS aktiviti_tarikh"),
                                'ref__status_aktiviti.status_description AS status_description',
                                'krt__aktiviti_laporan.aktiviti_status AS aktiviti_status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__aktiviti_agenda_kerja','ref__aktiviti_agenda_kerja.id','=','krt__aktiviti_laporan.agenda_id')
                        ->leftJoin('ref__aktiviti_bidang','ref__aktiviti_bidang.id','=','krt__aktiviti_laporan.bidang_id')
                        ->leftJoin('ref__status_aktiviti','ref__status_aktiviti.id','=','krt__aktiviti_laporan.aktiviti_status')
                        ->orderBy('krt__aktiviti_laporan.id', 'asc')
                        ->where('krt__aktiviti_laporan.aktiviti_status', '=', 3)
                        ->where('ref__daerahs.daerah_id', '=', Auth::user()->daerah_id)
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
            $krt    = KRT_Profile::where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)
                    ->where('krt__profile.krt_status', '=', 1)
					->orderBy('krt__profile.krt_nama','asc')
                    ->get();
            return view('rt-sm6.pengesahan-laporan-aktiviti-ppd', compact('roles_menu','krt'));
        }
    }

    function pengesahan_laporan_aktiviti_ppd_1(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_program') {
                $value = $request->value;
                $where = array('agenda_id' => $value);
                $data  = Ref_Aktiviti_Program::where($where)->get();
                return Response::json($data);
             }else if($type == 'get_sub_bidang') {
                $value = $request->value;
                $where = array('bidang_id' => $value);
                $data  = Ref_Aktiviti_Sub_Bidang::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_aktiviti') {
                $value = $request->value;
                $where = array('sub_bidang_id' => $value);
                $data  = Ref_Aktiviti::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_aktiviti_sub') {
                $value = $request->value;
                $where = array('aktiviti_id' => $value);
                $data  = Ref_Aktiviti_Sub::where($where)->get();
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
            $laporan_aktiviti   = DB::table('krt__aktiviti_laporan')
                                    ->select('krt__aktiviti_laporan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_laporan.state_id AS state_id',
                                            'krt__aktiviti_laporan.daerah_id AS daerah_id',
                                            'krt__aktiviti_laporan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_laporan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL',
                                            'krt__aktiviti_laporan.aktiviti_tajuk AS aktiviti_tajuk',
                                            DB::raw(" DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh,'%d/%m/%Y') AS aktiviti_tarikh"),
                                            DB::raw(" DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh_rancang,'%d/%m/%Y') AS aktiviti_tarikh_rancang"),
                                            'krt__aktiviti_laporan.aktiviti_masa AS aktiviti_masa',
                                            'krt__aktiviti_laporan.penganjur_id AS penganjur_id',
                                            'krt__aktiviti_laporan.peringkat_id AS peringkat_id',
                                            'krt__aktiviti_laporan.agenda_id AS agenda_id',
                                            'krt__aktiviti_laporan.program_id AS program_id',
                                            'krt__aktiviti_laporan.bidang_id AS bidang_id',
                                            'krt__aktiviti_laporan.aktiviti_id AS aktiviti_id',
                                            'krt__aktiviti_laporan.sub_aktiviti_id AS sub_aktiviti_id',
                                            'krt__aktiviti_laporan.aktiviti_pembelanjaan AS aktiviti_pembelanjaan',
                                            'krt__aktiviti_laporan.kewangan_id AS kewangan_id',
                                            'krt__aktiviti_laporan.aktiviti_sasar AS aktiviti_sasar',
                                            'krt__aktiviti_laporan.aktiviti_perasmi AS aktiviti_perasmi',
                                            'ref__status_aktiviti.status_description AS status_description',
                                            'krt__aktiviti_laporan.aktiviti_status AS aktiviti_status',
                                            'krt__aktiviti_laporan.disahkan_note AS disahkan_note')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_aktiviti','ref__status_aktiviti.id','=','krt__aktiviti_laporan.aktiviti_status')
                                    ->where('krt__aktiviti_laporan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state           = RefStates::where('status', '=',  true)->get();
            $daerah          = RefDaerah::where('status', '=',  true)->get();
            $penganjur       = Ref_Aktiviti_Penganjur::where('status', '=',  true)->get();
            $peringkat       = Ref_Aktiviti_Peringkat::where('status', '=',  true)->get();
            $agenda          = Ref_Aktiviti_Agenda_Kerja::where('status', '=',  true)->get();
            $bidang          = Ref_Aktiviti_Bidang::where('status', '=',  true)->get();
            $aktiviti        = Ref_Aktiviti::where('status', '=',  true)->get();
            $program         = Ref_Aktiviti_Program::where('status', '=',  true)->get();
            $sub_aktiviti    = Ref_Aktiviti_Sub::where('status', '=',  true)->get();
            $bahagian        = Ref_Aktiviti_Bahagian::where('status', '=',  true)->get();
            $sumber_kewangan = Ref_Aktiviti_Sumber_Kewangan::where('status', '=',  true)->get();
            return view('rt-sm6.pengesahan-laporan-aktiviti-ppd-1', 
            compact('roles_menu','laporan_aktiviti', 'state', 'daerah', 'penganjur', 'peringkat', 'agenda', 'bidang', 'aktiviti', 'program', 'sub_aktiviti', 'bahagian', 'sumber_kewangan'));
        }
    }

    function pengesahan_laporan_aktiviti_ppd_2(Request $request, $id){
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
            $laporan_aktiviti   = DB::table('krt__aktiviti_laporan')
                                    ->select('krt__aktiviti_laporan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_laporan.state_id AS state_id',
                                            'krt__aktiviti_laporan.daerah_id AS daerah_id',
                                            'krt__aktiviti_laporan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_laporan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__aktiviti_laporan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state          = RefStates::where('status', '=',  true)->get();
            $daerah         = RefDaerah::where('status', '=',  true)->get();
            $kaum           = RefKaum::where('status', '=',  true)->get();
            $jantina        = RefJantina::where('status', '=',  true)->get();
            $umur           = Ref_Kelompok_Umur::where('status', '=',  true)->get();
            $rakan_perpaduan = Ref_Rakan_Perpaduan::where('status', '=',  true)->get();
            $sumbangan       = Ref_Sumbangan::where('status', '=',  true)->get();
            return view('rt-sm6.pengesahan-laporan-aktiviti-ppd-2',compact('roles_menu','laporan_aktiviti','state','daerah', 'kaum', 'jantina', 'umur', 'rakan_perpaduan', 'sumbangan'));
        }
    }

    function pengesahan_laporan_aktiviti_ppd_3(Request $request, $id){
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
            $laporan_aktiviti   = DB::table('krt__aktiviti_laporan')
                                    ->select('krt__aktiviti_laporan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_laporan.state_id AS state_id',
                                            'krt__aktiviti_laporan.daerah_id AS daerah_id',
                                            'krt__aktiviti_laporan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_laporan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL',
                                            'krt__aktiviti_laporan.aktiviti_ringkasan_program AS aktiviti_ringkasan_program',
                                            'krt__aktiviti_laporan.aktiviti_post_mortem AS aktiviti_post_mortem',
                                            'krt__aktiviti_laporan.aktiviti_soal_selidik AS aktiviti_soal_selidik',
                                            'krt__aktiviti_laporan.aktiviti_pemerhatian AS aktiviti_pemerhatian',
                                            'krt__aktiviti_laporan.aktiviti_temubual AS aktiviti_temubual',
                                            'krt__aktiviti_laporan.aktiviti_kekuatan AS aktiviti_kekuatan',
                                            'krt__aktiviti_laporan.aktiviti_keberkesanan AS aktiviti_keberkesanan',
                                            'krt__aktiviti_laporan.aktiviti_penambahbaikan AS aktiviti_penambahbaikan')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__aktiviti_laporan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state          = RefStates::where('status', '=',  true)->get();
            $daerah         = RefDaerah::where('status', '=',  true)->get();
            return view('rt-sm6.pengesahan-laporan-aktiviti-ppd-3',compact('roles_menu','laporan_aktiviti','state','daerah'));
        }
    }

    function post_pengesahan_laporan_aktiviti(Request $request){
        $action = $request->post_pengesahan_laporan_aktiviti;
        $app_id = $request->plap5_aktiviti_laporan_id;
        
        
        $rules = array(
            'plap5_disahkan_by'                   => 'required',
            'plap5_disahkan_note'                 => 'required',
        );

        $messages = [
            'plap5_disahkan_by.required'          => 'Ruangan Status mesti dipilih',
            'plap5_disahkan_note.required'        => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $laporan_aktiviti_perancangan                         = KRT_Aktiviti_Laporan::where($where)->first();
                $laporan_aktiviti_perancangan->aktiviti_status        = $request->plap5_disahkan_by;
                $laporan_aktiviti_perancangan->disahkan_note          = $request->plap5_disahkan_note;
                $laporan_aktiviti_perancangan->disahkan_by            = Auth::user()->user_id;
                $laporan_aktiviti_perancangan->disahkan_date          = date('Y-m-d H:i:s');
                $laporan_aktiviti_perancangan->save();
            }
        }
    }
    
    function jana_laporan_perancangan_aktiviti_krt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__aktiviti_perancangan')
                        ->select('krt__aktiviti_perancangan.id',
                                'ref__daerahs.daerah_id AS daerah_id',
                                'krt__profile.krt_nama AS krt_nama',
                                'krt__aktiviti_perancangan.aktiviti_tajuk AS aktiviti_tajuk',
                                'ref__aktiviti_agenda_kerja.agenda_description AS aktiviti_agenda',
                                'ref__aktiviti_bidang.bidang_description AS aktiviti_bidang',
                                DB::raw(" DATE_FORMAT(krt__aktiviti_perancangan.aktiviti_tarikh_rancang,'%d/%m/%Y') AS aktiviti_tarikh_rancang"),
                                DB::raw(" DATE_FORMAT(krt__aktiviti_perancangan.aktiviti_tarikh,'%d/%m/%Y') AS aktiviti_tarikh"),
                                'ref__status_aktiviti.status_description AS status_description',
                                'krt__aktiviti_perancangan.aktiviti_status AS aktiviti_status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_perancangan.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__aktiviti_agenda_kerja','ref__aktiviti_agenda_kerja.id','=','krt__aktiviti_perancangan.agenda_id')
                        ->leftJoin('ref__aktiviti_bidang','ref__aktiviti_bidang.id','=','krt__aktiviti_perancangan.bidang_id')
                        ->leftJoin('ref__status_aktiviti','ref__status_aktiviti.id','=','krt__aktiviti_perancangan.aktiviti_status')
                        ->orderBy('krt__aktiviti_perancangan.id', 'asc')
                        ->where('krt__aktiviti_perancangan.aktiviti_status', '=', 1)
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
            $krt  = KRT_Profile::where('daerah_id', '=',  Auth::user()->daerah_id)->get();
            return view('rt-sm6.jana-laporan-perancangan-aktiviti-krt', compact('roles_menu','krt'));
        }
    }

    function jana_laporan_perancangan_aktiviti_krt_1(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_program') {
                $value = $request->value;
                $where = array('agenda_id' => $value);
                $data  = Ref_Aktiviti_Program::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_sub_bidang') {
                $value = $request->value;
                $where = array('bidang_id' => $value);
                $data  = Ref_Aktiviti_Sub_Bidang::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_aktiviti') {
                $value = $request->value;
                $where = array('sub_bidang_id' => $value);
                $data  = Ref_Aktiviti::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_aktiviti_sub') {
                $value = $request->value;
                $where = array('aktiviti_id' => $value);
                $data  = Ref_Aktiviti_Sub::where($where)->get();
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
            $perancangan_aktiviti   = DB::table('krt__aktiviti_perancangan')
                                    ->select('krt__aktiviti_perancangan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_perancangan.state_id AS state_id',
                                            'krt__aktiviti_perancangan.daerah_id AS daerah_id',
                                            'krt__aktiviti_perancangan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_perancangan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL',
                                            'krt__aktiviti_perancangan.aktiviti_tajuk AS aktiviti_tajuk',
                                            DB::raw(" DATE_FORMAT(krt__aktiviti_perancangan.aktiviti_tarikh,'%d/%m/%Y') AS aktiviti_tarikh"),
                                            DB::raw(" DATE_FORMAT(krt__aktiviti_perancangan.aktiviti_tarikh_rancang,'%d/%m/%Y') AS aktiviti_tarikh_rancang"),
                                            'krt__aktiviti_perancangan.aktiviti_masa AS aktiviti_masa',
                                            'krt__aktiviti_perancangan.penganjur_id AS penganjur_id',
                                            'krt__aktiviti_perancangan.peringkat_id AS peringkat_id',
                                            'krt__aktiviti_perancangan.agenda_id AS agenda_id',
                                            'krt__aktiviti_perancangan.program_id AS program_id',
                                            'krt__aktiviti_perancangan.bidang_id AS bidang_id',
                                            'krt__aktiviti_perancangan.aktiviti_id AS aktiviti_id',
                                            'krt__aktiviti_perancangan.sub_aktiviti_id AS sub_aktiviti_id',
                                            'krt__aktiviti_perancangan.aktiviti_pembelanjaan AS aktiviti_pembelanjaan',
                                            'krt__aktiviti_perancangan.kewangan_id AS kewangan_id',
                                            'krt__aktiviti_perancangan.aktiviti_sasar AS aktiviti_sasar',
                                            'krt__aktiviti_perancangan.aktiviti_perasmi AS aktiviti_perasmi')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_perancangan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__aktiviti_perancangan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state           = RefStates::where('status', '=',  true)->get();
            $daerah          = RefDaerah::where('status', '=',  true)->get();
            $penganjur       = Ref_Aktiviti_Penganjur::where('status', '=',  true)->get();
            $peringkat       = Ref_Aktiviti_Peringkat::where('status', '=',  true)->get();
            $agenda          = Ref_Aktiviti_Agenda_Kerja::where('status', '=',  true)->get();
            $bidang          = Ref_Aktiviti_Bidang::where('status', '=',  true)->get();
            $aktiviti        = Ref_Aktiviti::where('status', '=',  true)->get();
            $program         = Ref_Aktiviti_Program::where('status', '=',  true)->get();
            $sub_aktiviti    = Ref_Aktiviti_Sub::where('status', '=',  true)->get();
            $sumber_kewangan = Ref_Aktiviti_Sumber_Kewangan::where('status', '=',  true)->get();
            return view('rt-sm6.jana-laporan-perancangan-aktiviti-krt-1', 
            compact('roles_menu','perancangan_aktiviti', 'state', 'daerah', 'penganjur', 'peringkat', 'agenda', 'bidang', 'aktiviti', 'program', 'sub_aktiviti', 'sumber_kewangan'));
        }
    }

    function jana_laporan_perancangan_aktiviti_krt_2(Request $request, $id){
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
            $perancangan_aktiviti   = DB::table('krt__aktiviti_perancangan')
                                    ->select('krt__aktiviti_perancangan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_perancangan.state_id AS state_id',
                                            'krt__aktiviti_perancangan.daerah_id AS daerah_id',
                                            'krt__aktiviti_perancangan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_perancangan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_perancangan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__aktiviti_perancangan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state          = RefStates::where('status', '=',  true)->get();
            $daerah         = RefDaerah::where('status', '=',  true)->get();
            $kaum           = RefKaum::where('status', '=',  true)->get();
            $jantina        = RefJantina::where('status', '=',  true)->get();
            $umur           = Ref_Kelompok_Umur::where('status', '=',  true)->get();
            $rakan_perpaduan = Ref_Rakan_Perpaduan::where('status', '=',  true)->get();
            $sumbangan       = Ref_Sumbangan::where('status', '=',  true)->get();
            return view('rt-sm6.jana-laporan-perancangan-aktiviti-krt-2',compact('roles_menu','perancangan_aktiviti','state','daerah', 'kaum', 'jantina', 'umur', 'rakan_perpaduan', 'sumbangan'));
        }
    }

    function jana_laporan_perancangan_aktiviti_krt_3(Request $request, $id){
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
            $perancangan_aktiviti   = DB::table('krt__aktiviti_perancangan')
                                    ->select('krt__aktiviti_perancangan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_perancangan.state_id AS state_id',
                                            'krt__aktiviti_perancangan.daerah_id AS daerah_id',
                                            'krt__aktiviti_perancangan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_perancangan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL',
                                            'krt__aktiviti_perancangan.aktiviti_ringkasan_program AS aktiviti_ringkasan_program',
                                            'krt__aktiviti_perancangan.aktiviti_post_mortem AS aktiviti_post_mortem',
                                            'krt__aktiviti_perancangan.aktiviti_soal_selidik AS aktiviti_soal_selidik',
                                            'krt__aktiviti_perancangan.aktiviti_pemerhatian AS aktiviti_pemerhatian',
                                            'krt__aktiviti_perancangan.aktiviti_temubual AS aktiviti_temubual',
                                            'krt__aktiviti_perancangan.aktiviti_kekuatan AS aktiviti_kekuatan',
                                            'krt__aktiviti_perancangan.aktiviti_keberkesanan AS aktiviti_keberkesanan',
                                            'krt__aktiviti_perancangan.aktiviti_penambahbaikan AS aktiviti_penambahbaikan')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_perancangan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__aktiviti_perancangan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state          = RefStates::where('status', '=',  true)->get();
            $daerah         = RefDaerah::where('status', '=',  true)->get();
            return view('rt-sm6.jana-laporan-perancangan-aktiviti-krt-3',compact('roles_menu','perancangan_aktiviti','state','daerah'));
        }
    }

    function jana_laporan_perancangan_aktiviti_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__aktiviti_perancangan')
                        ->select('krt__aktiviti_perancangan.id',
                                'ref__daerahs.daerah_id AS daerah_id',
                                'krt__profile.krt_nama AS krt_nama',
                                'krt__aktiviti_perancangan.aktiviti_tajuk AS aktiviti_tajuk',
                                'ref__aktiviti_agenda_kerja.agenda_description AS aktiviti_agenda',
                                'ref__aktiviti_bidang.bidang_description AS aktiviti_bidang',
                                DB::raw(" DATE_FORMAT(krt__aktiviti_perancangan.aktiviti_tarikh_rancang,'%d/%m/%Y') AS aktiviti_tarikh_rancang"),
                                DB::raw(" DATE_FORMAT(krt__aktiviti_perancangan.aktiviti_tarikh,'%d/%m/%Y') AS aktiviti_tarikh"),
                                'ref__status_aktiviti.status_description AS status_description',
                                'krt__aktiviti_perancangan.aktiviti_status AS aktiviti_status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_perancangan.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__aktiviti_agenda_kerja','ref__aktiviti_agenda_kerja.id','=','krt__aktiviti_perancangan.agenda_id')
                        ->leftJoin('ref__aktiviti_bidang','ref__aktiviti_bidang.id','=','krt__aktiviti_perancangan.bidang_id')
                        ->leftJoin('ref__status_aktiviti','ref__status_aktiviti.id','=','krt__aktiviti_perancangan.aktiviti_status')
                        ->orderBy('krt__aktiviti_perancangan.id', 'asc')
                        ->where('krt__aktiviti_perancangan.aktiviti_status', '=', 1)
                        ->where('krt__profile.daerah_id', '=',  Auth::user()->daerah_id)
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
            $krt    = KRT_Profile::where('daerah_id', '=',  Auth::user()->daerah_id)
                    ->where('krt__profile.krt_status', '=', true)
                    ->get();
            return view('rt-sm6.jana-laporan-perancangan-aktiviti-ppd', compact('roles_menu','krt'));
        }
    }

    function jana_laporan_perancangan_aktiviti_ppd_1(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_program') {
                $value = $request->value;
                $where = array('agenda_id' => $value);
                $data  = Ref_Aktiviti_Program::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_sub_bidang') {
                $value = $request->value;
                $where = array('bidang_id' => $value);
                $data  = Ref_Aktiviti_Sub_Bidang::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_aktiviti') {
                $value = $request->value;
                $where = array('sub_bidang_id' => $value);
                $data  = Ref_Aktiviti::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_aktiviti_sub') {
                $value = $request->value;
                $where = array('aktiviti_id' => $value);
                $data  = Ref_Aktiviti_Sub::where($where)->get();
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
            $perancangan_aktiviti   = DB::table('krt__aktiviti_perancangan')
                                    ->select('krt__aktiviti_perancangan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_perancangan.state_id AS state_id',
                                            'krt__aktiviti_perancangan.daerah_id AS daerah_id',
                                            'krt__aktiviti_perancangan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_perancangan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL',
                                            'krt__aktiviti_perancangan.aktiviti_tajuk AS aktiviti_tajuk',
                                            DB::raw(" DATE_FORMAT(krt__aktiviti_perancangan.aktiviti_tarikh,'%d/%m/%Y') AS aktiviti_tarikh"),
                                            DB::raw(" DATE_FORMAT(krt__aktiviti_perancangan.aktiviti_tarikh_rancang,'%d/%m/%Y') AS aktiviti_tarikh_rancang"),
                                            'krt__aktiviti_perancangan.aktiviti_masa AS aktiviti_masa',
                                            'krt__aktiviti_perancangan.penganjur_id AS penganjur_id',
                                            'krt__aktiviti_perancangan.peringkat_id AS peringkat_id',
                                            'krt__aktiviti_perancangan.agenda_id AS agenda_id',
                                            'krt__aktiviti_perancangan.program_id AS program_id',
                                            'krt__aktiviti_perancangan.bidang_id AS bidang_id',
                                            'krt__aktiviti_perancangan.aktiviti_id AS aktiviti_id',
                                            'krt__aktiviti_perancangan.sub_aktiviti_id AS sub_aktiviti_id',
                                            'krt__aktiviti_perancangan.aktiviti_pembelanjaan AS aktiviti_pembelanjaan',
                                            'krt__aktiviti_perancangan.kewangan_id AS kewangan_id',
                                            'krt__aktiviti_perancangan.aktiviti_sasar AS aktiviti_sasar',
                                            'krt__aktiviti_perancangan.aktiviti_perasmi AS aktiviti_perasmi')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_perancangan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__aktiviti_perancangan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state           = RefStates::where('status', '=',  true)->get();
            $daerah          = RefDaerah::where('status', '=',  true)->get();
            $penganjur       = Ref_Aktiviti_Penganjur::where('status', '=',  true)->get();
            $peringkat       = Ref_Aktiviti_Peringkat::where('status', '=',  true)->get();
            $agenda          = Ref_Aktiviti_Agenda_Kerja::where('status', '=',  true)->get();
            $bidang          = Ref_Aktiviti_Bidang::where('status', '=',  true)->get();
            $aktiviti        = Ref_Aktiviti::where('status', '=',  true)->get();
            $program         = Ref_Aktiviti_Program::where('status', '=',  true)->get();
            $sub_aktiviti    = Ref_Aktiviti_Sub::where('status', '=',  true)->get();
            $sumber_kewangan = Ref_Aktiviti_Sumber_Kewangan::where('status', '=',  true)->get();
            return view('rt-sm6.jana-laporan-perancangan-aktiviti-ppd-1', 
            compact('roles_menu','perancangan_aktiviti', 'state', 'daerah', 'penganjur', 'peringkat', 'agenda', 'bidang', 'aktiviti', 'program', 'sub_aktiviti', 'sumber_kewangan'));
        }
    }

    function jana_laporan_perancangan_aktiviti_ppd_2(Request $request, $id){
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
            $perancangan_aktiviti   = DB::table('krt__aktiviti_perancangan')
                                    ->select('krt__aktiviti_perancangan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_perancangan.state_id AS state_id',
                                            'krt__aktiviti_perancangan.daerah_id AS daerah_id',
                                            'krt__aktiviti_perancangan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_perancangan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_perancangan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__aktiviti_perancangan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state          = RefStates::where('status', '=',  true)->get();
            $daerah         = RefDaerah::where('status', '=',  true)->get();
            $kaum           = RefKaum::where('status', '=',  true)->get();
            $jantina        = RefJantina::where('status', '=',  true)->get();
            $umur           = Ref_Kelompok_Umur::where('status', '=',  true)->get();
            $rakan_perpaduan = Ref_Rakan_Perpaduan::where('status', '=',  true)->get();
            $sumbangan       = Ref_Sumbangan::where('status', '=',  true)->get();
            return view('rt-sm6.jana-laporan-perancangan-aktiviti-ppd-2',compact('roles_menu','perancangan_aktiviti','state','daerah', 'kaum', 'jantina', 'umur', 'rakan_perpaduan', 'sumbangan'));
        }
    }

    function jana_laporan_perancangan_aktiviti_ppd_3(Request $request, $id){
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
            $perancangan_aktiviti   = DB::table('krt__aktiviti_perancangan')
                                    ->select('krt__aktiviti_perancangan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_perancangan.state_id AS state_id',
                                            'krt__aktiviti_perancangan.daerah_id AS daerah_id',
                                            'krt__aktiviti_perancangan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_perancangan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL',
                                            'krt__aktiviti_perancangan.aktiviti_ringkasan_program AS aktiviti_ringkasan_program',
                                            'krt__aktiviti_perancangan.aktiviti_post_mortem AS aktiviti_post_mortem',
                                            'krt__aktiviti_perancangan.aktiviti_soal_selidik AS aktiviti_soal_selidik',
                                            'krt__aktiviti_perancangan.aktiviti_pemerhatian AS aktiviti_pemerhatian',
                                            'krt__aktiviti_perancangan.aktiviti_temubual AS aktiviti_temubual',
                                            'krt__aktiviti_perancangan.aktiviti_kekuatan AS aktiviti_kekuatan',
                                            'krt__aktiviti_perancangan.aktiviti_keberkesanan AS aktiviti_keberkesanan',
                                            'krt__aktiviti_perancangan.aktiviti_penambahbaikan AS aktiviti_penambahbaikan')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_perancangan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__aktiviti_perancangan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state          = RefStates::where('status', '=',  true)->get();
            $daerah         = RefDaerah::where('status', '=',  true)->get();
            return view('rt-sm6.jana-laporan-perancangan-aktiviti-ppd-3',compact('roles_menu','perancangan_aktiviti','state','daerah'));
        }
    }

    function jana_laporan_perancangan_aktiviti_ppn(Request $request){
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
            $data = DB::table('krt__aktiviti_perancangan')
                        ->select('krt__aktiviti_perancangan.id',
                                'ref__daerahs.daerah_id AS daerah_id',
                                'ref__daerahs.daerah_description AS daerah',
                                'krt__profile.krt_nama AS krt_nama',
                                'krt__aktiviti_perancangan.aktiviti_tajuk AS aktiviti_tajuk',
                                'ref__aktiviti_agenda_kerja.agenda_description AS aktiviti_agenda',
                                'ref__aktiviti_bidang.bidang_description AS aktiviti_bidang',
                                DB::raw(" DATE_FORMAT(krt__aktiviti_perancangan.aktiviti_tarikh_rancang,'%d/%m/%Y') AS aktiviti_tarikh_rancang"),
                                DB::raw(" DATE_FORMAT(krt__aktiviti_perancangan.aktiviti_tarikh,'%d/%m/%Y') AS aktiviti_tarikh"),
                                'ref__status_aktiviti.status_description AS status_description',
                                'krt__aktiviti_perancangan.aktiviti_status AS aktiviti_status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_perancangan.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__aktiviti_agenda_kerja','ref__aktiviti_agenda_kerja.id','=','krt__aktiviti_perancangan.agenda_id')
                        ->leftJoin('ref__aktiviti_bidang','ref__aktiviti_bidang.id','=','krt__aktiviti_perancangan.bidang_id')
                        ->leftJoin('ref__status_aktiviti','ref__status_aktiviti.id','=','krt__aktiviti_perancangan.aktiviti_status')
                        ->orderBy('krt__aktiviti_perancangan.id', 'asc')
                        ->where('krt__aktiviti_perancangan.aktiviti_status', '=', 1)
                        ->where('krt__profile.state_id', '=',  Auth::user()->state_id)
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
            $daerah  = RefDaerah::where('state_id', '=',  Auth::user()->state_id)->get();
            $krt     = KRT_Profile::where('krt_status', '=',  true)->get();
            return view('rt-sm6.jana-laporan-perancangan-aktiviti-ppn', compact('roles_menu','daerah','krt'));
        }
    }

    function jana_laporan_perancangan_aktiviti_ppn_1(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_program') {
                $value = $request->value;
                $where = array('agenda_id' => $value);
                $data  = Ref_Aktiviti_Program::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_sub_bidang') {
                $value = $request->value;
                $where = array('bidang_id' => $value);
                $data  = Ref_Aktiviti_Sub_Bidang::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_aktiviti') {
                $value = $request->value;
                $where = array('sub_bidang_id' => $value);
                $data  = Ref_Aktiviti::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_aktiviti_sub') {
                $value = $request->value;
                $where = array('aktiviti_id' => $value);
                $data  = Ref_Aktiviti_Sub::where($where)->get();
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
            $perancangan_aktiviti   = DB::table('krt__aktiviti_perancangan')
                                    ->select('krt__aktiviti_perancangan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_perancangan.state_id AS state_id',
                                            'krt__aktiviti_perancangan.daerah_id AS daerah_id',
                                            'krt__aktiviti_perancangan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_perancangan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL',
                                            'krt__aktiviti_perancangan.aktiviti_tajuk AS aktiviti_tajuk',
                                            DB::raw(" DATE_FORMAT(krt__aktiviti_perancangan.aktiviti_tarikh,'%d/%m/%Y') AS aktiviti_tarikh"),
                                            DB::raw(" DATE_FORMAT(krt__aktiviti_perancangan.aktiviti_tarikh_rancang,'%d/%m/%Y') AS aktiviti_tarikh_rancang"),
                                            'krt__aktiviti_perancangan.aktiviti_masa AS aktiviti_masa',
                                            'krt__aktiviti_perancangan.penganjur_id AS penganjur_id',
                                            'krt__aktiviti_perancangan.peringkat_id AS peringkat_id',
                                            'krt__aktiviti_perancangan.agenda_id AS agenda_id',
                                            'krt__aktiviti_perancangan.program_id AS program_id',
                                            'krt__aktiviti_perancangan.bidang_id AS bidang_id',
                                            'krt__aktiviti_perancangan.aktiviti_id AS aktiviti_id',
                                            'krt__aktiviti_perancangan.sub_aktiviti_id AS sub_aktiviti_id',
                                            'krt__aktiviti_perancangan.aktiviti_pembelanjaan AS aktiviti_pembelanjaan',
                                            'krt__aktiviti_perancangan.kewangan_id AS kewangan_id',
                                            'krt__aktiviti_perancangan.aktiviti_sasar AS aktiviti_sasar',
                                            'krt__aktiviti_perancangan.aktiviti_perasmi AS aktiviti_perasmi')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_perancangan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__aktiviti_perancangan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state           = RefStates::where('status', '=',  true)->get();
            $daerah          = RefDaerah::where('status', '=',  true)->get();
            $penganjur       = Ref_Aktiviti_Penganjur::where('status', '=',  true)->get();
            $peringkat       = Ref_Aktiviti_Peringkat::where('status', '=',  true)->get();
            $agenda          = Ref_Aktiviti_Agenda_Kerja::where('status', '=',  true)->get();
            $bidang          = Ref_Aktiviti_Bidang::where('status', '=',  true)->get();
            $aktiviti        = Ref_Aktiviti::where('status', '=',  true)->get();
            $program         = Ref_Aktiviti_Program::where('status', '=',  true)->get();
            $sub_aktiviti    = Ref_Aktiviti_Sub::where('status', '=',  true)->get();
            $sumber_kewangan = Ref_Aktiviti_Sumber_Kewangan::where('status', '=',  true)->get();
            return view('rt-sm6.jana-laporan-perancangan-aktiviti-ppn-1', 
            compact('roles_menu','perancangan_aktiviti', 'state', 'daerah', 'penganjur', 'peringkat', 'agenda', 'bidang', 'aktiviti', 'program', 'sub_aktiviti', 'sumber_kewangan'));
        }
    }

    function jana_laporan_perancangan_aktiviti_ppn_2(Request $request, $id){
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
            $perancangan_aktiviti   = DB::table('krt__aktiviti_perancangan')
                                    ->select('krt__aktiviti_perancangan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_perancangan.state_id AS state_id',
                                            'krt__aktiviti_perancangan.daerah_id AS daerah_id',
                                            'krt__aktiviti_perancangan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_perancangan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_perancangan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__aktiviti_perancangan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state          = RefStates::where('status', '=',  true)->get();
            $daerah         = RefDaerah::where('status', '=',  true)->get();
            $kaum           = RefKaum::where('status', '=',  true)->get();
            $jantina        = RefJantina::where('status', '=',  true)->get();
            $umur           = Ref_Kelompok_Umur::where('status', '=',  true)->get();
            $rakan_perpaduan = Ref_Rakan_Perpaduan::where('status', '=',  true)->get();
            $sumbangan       = Ref_Sumbangan::where('status', '=',  true)->get();
            return view('rt-sm6.jana-laporan-perancangan-aktiviti-ppn-2',compact('roles_menu','perancangan_aktiviti','state','daerah', 'kaum', 'jantina', 'umur', 'rakan_perpaduan', 'sumbangan'));
        }
    }

    function jana_laporan_perancangan_aktiviti_ppn_3(Request $request, $id){
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
            $perancangan_aktiviti   = DB::table('krt__aktiviti_perancangan')
                                    ->select('krt__aktiviti_perancangan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_perancangan.state_id AS state_id',
                                            'krt__aktiviti_perancangan.daerah_id AS daerah_id',
                                            'krt__aktiviti_perancangan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_perancangan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL',
                                            'krt__aktiviti_perancangan.aktiviti_ringkasan_program AS aktiviti_ringkasan_program',
                                            'krt__aktiviti_perancangan.aktiviti_post_mortem AS aktiviti_post_mortem',
                                            'krt__aktiviti_perancangan.aktiviti_soal_selidik AS aktiviti_soal_selidik',
                                            'krt__aktiviti_perancangan.aktiviti_pemerhatian AS aktiviti_pemerhatian',
                                            'krt__aktiviti_perancangan.aktiviti_temubual AS aktiviti_temubual',
                                            'krt__aktiviti_perancangan.aktiviti_kekuatan AS aktiviti_kekuatan',
                                            'krt__aktiviti_perancangan.aktiviti_keberkesanan AS aktiviti_keberkesanan',
                                            'krt__aktiviti_perancangan.aktiviti_penambahbaikan AS aktiviti_penambahbaikan')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_perancangan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__aktiviti_perancangan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state          = RefStates::where('status', '=',  true)->get();
            $daerah         = RefDaerah::where('status', '=',  true)->get();
            return view('rt-sm6.jana-laporan-perancangan-aktiviti-ppn-3',compact('roles_menu','perancangan_aktiviti','state','daerah'));
        }
    }

    function jana_laporan_perancangan_aktiviti_hq(Request $request){
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
            $data = DB::table('krt__aktiviti_perancangan')
                        ->select('krt__aktiviti_perancangan.id',
                                'ref__daerahs.daerah_id AS daerah_id',
                                'ref__states.state_description AS negeri',
                                'ref__daerahs.daerah_description AS daerah',
                                'krt__profile.krt_nama AS krt_nama',
                                'krt__aktiviti_perancangan.aktiviti_tajuk AS aktiviti_tajuk',
                                'ref__aktiviti_agenda_kerja.agenda_description AS aktiviti_agenda',
                                'ref__aktiviti_bidang.bidang_description AS aktiviti_bidang',
                                DB::raw(" DATE_FORMAT(krt__aktiviti_perancangan.aktiviti_tarikh_rancang,'%d/%m/%Y') AS aktiviti_tarikh_rancang"),
                                DB::raw(" DATE_FORMAT(krt__aktiviti_perancangan.aktiviti_tarikh,'%d/%m/%Y') AS aktiviti_tarikh"),
                                'ref__status_aktiviti.status_description AS status_description',
                                'krt__aktiviti_perancangan.aktiviti_status AS aktiviti_status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_perancangan.krt_profile_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__aktiviti_agenda_kerja','ref__aktiviti_agenda_kerja.id','=','krt__aktiviti_perancangan.agenda_id')
                        ->leftJoin('ref__aktiviti_bidang','ref__aktiviti_bidang.id','=','krt__aktiviti_perancangan.bidang_id')
                        ->leftJoin('ref__status_aktiviti','ref__status_aktiviti.id','=','krt__aktiviti_perancangan.aktiviti_status')
                        ->orderBy('krt__aktiviti_perancangan.id', 'asc')
                        ->where('krt__aktiviti_perancangan.aktiviti_status', '=', 1)
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
            $state   = RefStates::where('status', '=',  true)->get();
            $daerah  = RefDaerah::where('status', '=',  true)->get();
            $krt     = KRT_Profile::where('krt_status', '=',  true)->get();
            return view('rt-sm6.jana-laporan-perancangan-aktiviti-hq', compact('roles_menu','state','daerah','krt'));
        }
    }

    function jana_laporan_perancangan_aktiviti_hq_1(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_program') {
                $value = $request->value;
                $where = array('agenda_id' => $value);
                $data  = Ref_Aktiviti_Program::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_sub_bidang') {
                $value = $request->value;
                $where = array('bidang_id' => $value);
                $data  = Ref_Aktiviti_Sub_Bidang::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_aktiviti') {
                $value = $request->value;
                $where = array('sub_bidang_id' => $value);
                $data  = Ref_Aktiviti::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_aktiviti_sub') {
                $value = $request->value;
                $where = array('aktiviti_id' => $value);
                $data  = Ref_Aktiviti_Sub::where($where)->get();
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
            $perancangan_aktiviti   = DB::table('krt__aktiviti_perancangan')
                                    ->select('krt__aktiviti_perancangan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_perancangan.state_id AS state_id',
                                            'krt__aktiviti_perancangan.daerah_id AS daerah_id',
                                            'krt__aktiviti_perancangan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_perancangan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL',
                                            'krt__aktiviti_perancangan.aktiviti_tajuk AS aktiviti_tajuk',
                                            DB::raw(" DATE_FORMAT(krt__aktiviti_perancangan.aktiviti_tarikh,'%d/%m/%Y') AS aktiviti_tarikh"),
                                            DB::raw(" DATE_FORMAT(krt__aktiviti_perancangan.aktiviti_tarikh_rancang,'%d/%m/%Y') AS aktiviti_tarikh_rancang"),
                                            'krt__aktiviti_perancangan.aktiviti_masa AS aktiviti_masa',
                                            'krt__aktiviti_perancangan.penganjur_id AS penganjur_id',
                                            'krt__aktiviti_perancangan.peringkat_id AS peringkat_id',
                                            'krt__aktiviti_perancangan.agenda_id AS agenda_id',
                                            'krt__aktiviti_perancangan.program_id AS program_id',
                                            'krt__aktiviti_perancangan.bidang_id AS bidang_id',
                                            'krt__aktiviti_perancangan.aktiviti_id AS aktiviti_id',
                                            'krt__aktiviti_perancangan.sub_aktiviti_id AS sub_aktiviti_id',
                                            'krt__aktiviti_perancangan.aktiviti_pembelanjaan AS aktiviti_pembelanjaan',
                                            'krt__aktiviti_perancangan.kewangan_id AS kewangan_id',
                                            'krt__aktiviti_perancangan.aktiviti_sasar AS aktiviti_sasar',
                                            'krt__aktiviti_perancangan.aktiviti_perasmi AS aktiviti_perasmi')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_perancangan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__aktiviti_perancangan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state           = RefStates::where('status', '=',  true)->get();
            $daerah          = RefDaerah::where('status', '=',  true)->get();
            $penganjur       = Ref_Aktiviti_Penganjur::where('status', '=',  true)->get();
            $peringkat       = Ref_Aktiviti_Peringkat::where('status', '=',  true)->get();
            $agenda          = Ref_Aktiviti_Agenda_Kerja::where('status', '=',  true)->get();
            $bidang          = Ref_Aktiviti_Bidang::where('status', '=',  true)->get();
            $aktiviti        = Ref_Aktiviti::where('status', '=',  true)->get();
            $program         = Ref_Aktiviti_Program::where('status', '=',  true)->get();
            $sub_aktiviti    = Ref_Aktiviti_Sub::where('status', '=',  true)->get();
            $sumber_kewangan = Ref_Aktiviti_Sumber_Kewangan::where('status', '=',  true)->get();
            return view('rt-sm6.jana-laporan-perancangan-aktiviti-hq-1', 
            compact('roles_menu','perancangan_aktiviti', 'state', 'daerah', 'penganjur', 'peringkat', 'agenda', 'bidang', 'aktiviti', 'program', 'sub_aktiviti', 'sumber_kewangan'));
        }
    }

    function jana_laporan_perancangan_aktiviti_hq_2(Request $request, $id){
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
            $perancangan_aktiviti   = DB::table('krt__aktiviti_perancangan')
                                    ->select('krt__aktiviti_perancangan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_perancangan.state_id AS state_id',
                                            'krt__aktiviti_perancangan.daerah_id AS daerah_id',
                                            'krt__aktiviti_perancangan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_perancangan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_perancangan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__aktiviti_perancangan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state          = RefStates::where('status', '=',  true)->get();
            $daerah         = RefDaerah::where('status', '=',  true)->get();
            $kaum           = RefKaum::where('status', '=',  true)->get();
            $jantina        = RefJantina::where('status', '=',  true)->get();
            $umur           = Ref_Kelompok_Umur::where('status', '=',  true)->get();
            $rakan_perpaduan = Ref_Rakan_Perpaduan::where('status', '=',  true)->get();
            $sumbangan       = Ref_Sumbangan::where('status', '=',  true)->get();
            return view('rt-sm6.jana-laporan-perancangan-aktiviti-hq-2',compact('roles_menu','perancangan_aktiviti','state','daerah', 'kaum', 'jantina', 'umur', 'rakan_perpaduan', 'sumbangan'));
        }
    }

    function jana_laporan_perancangan_aktiviti_hq_3(Request $request, $id){
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
            $perancangan_aktiviti   = DB::table('krt__aktiviti_perancangan')
                                    ->select('krt__aktiviti_perancangan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_perancangan.state_id AS state_id',
                                            'krt__aktiviti_perancangan.daerah_id AS daerah_id',
                                            'krt__aktiviti_perancangan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_perancangan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL',
                                            'krt__aktiviti_perancangan.aktiviti_ringkasan_program AS aktiviti_ringkasan_program',
                                            'krt__aktiviti_perancangan.aktiviti_post_mortem AS aktiviti_post_mortem',
                                            'krt__aktiviti_perancangan.aktiviti_soal_selidik AS aktiviti_soal_selidik',
                                            'krt__aktiviti_perancangan.aktiviti_pemerhatian AS aktiviti_pemerhatian',
                                            'krt__aktiviti_perancangan.aktiviti_temubual AS aktiviti_temubual',
                                            'krt__aktiviti_perancangan.aktiviti_kekuatan AS aktiviti_kekuatan',
                                            'krt__aktiviti_perancangan.aktiviti_keberkesanan AS aktiviti_keberkesanan',
                                            'krt__aktiviti_perancangan.aktiviti_penambahbaikan AS aktiviti_penambahbaikan')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_perancangan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__aktiviti_perancangan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state          = RefStates::where('status', '=',  true)->get();
            $daerah         = RefDaerah::where('status', '=',  true)->get();
            return view('rt-sm6.jana-laporan-perancangan-aktiviti-hq-3',compact('roles_menu','perancangan_aktiviti','state','daerah'));
        }
    }

    function jana_laporan_aktiviti_krt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__aktiviti_laporan')
                        ->select('krt__aktiviti_laporan.id',
                                'ref__daerahs.daerah_id AS daerah_id',
                                'krt__profile.krt_nama AS krt_nama',
                                'krt__aktiviti_laporan.aktiviti_tajuk AS aktiviti_tajuk',
                                'ref__aktiviti_agenda_kerja.agenda_description AS aktiviti_agenda',
                                'ref__aktiviti_bidang.bidang_description AS aktiviti_bidang',
                                DB::raw(" DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh_rancang,'%d/%m/%Y') AS aktiviti_tarikh_rancang"),
                                DB::raw(" DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh,'%d/%m/%Y') AS aktiviti_tarikh"),
                                'ref__status_aktiviti.status_description AS status_description',
                                'krt__aktiviti_laporan.aktiviti_status AS aktiviti_status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__aktiviti_agenda_kerja','ref__aktiviti_agenda_kerja.id','=','krt__aktiviti_laporan.agenda_id')
                        ->leftJoin('ref__aktiviti_bidang','ref__aktiviti_bidang.id','=','krt__aktiviti_laporan.bidang_id')
                        ->leftJoin('ref__status_aktiviti','ref__status_aktiviti.id','=','krt__aktiviti_laporan.aktiviti_status')
                        ->orderBy('krt__aktiviti_laporan.id', 'asc')
                        ->where('krt__aktiviti_laporan.aktiviti_status', '=', 1)
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
            $krt  = KRT_Profile::where('daerah_id', '=',  Auth::user()->daerah_id)->get();
            return view('rt-sm6.jana-laporan-aktiviti-krt', compact('roles_menu','krt'));
        }
    }

    function jana_laporan_aktiviti_krt_1(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_program') {
                $value = $request->value;
                $where = array('agenda_id' => $value);
                $data  = Ref_Aktiviti_Program::where($where)->get();
                return Response::json($data);
             }else if($type == 'get_sub_bidang') {
                $value = $request->value;
                $where = array('bidang_id' => $value);
                $data  = Ref_Aktiviti_Sub_Bidang::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_aktiviti') {
                $value = $request->value;
                $where = array('sub_bidang_id' => $value);
                $data  = Ref_Aktiviti::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_aktiviti_sub') {
                $value = $request->value;
                $where = array('aktiviti_id' => $value);
                $data  = Ref_Aktiviti_Sub::where($where)->get();
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
            $laporan_aktiviti   = DB::table('krt__aktiviti_laporan')
                                    ->select('krt__aktiviti_laporan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_laporan.state_id AS state_id',
                                            'krt__aktiviti_laporan.daerah_id AS daerah_id',
                                            'krt__aktiviti_laporan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_laporan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL',
                                            'krt__aktiviti_laporan.aktiviti_tajuk AS aktiviti_tajuk',
                                            DB::raw(" DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh,'%d/%m/%Y') AS aktiviti_tarikh"),
                                            DB::raw(" DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh_rancang,'%d/%m/%Y') AS aktiviti_tarikh_rancang"),
                                            'krt__aktiviti_laporan.aktiviti_masa AS aktiviti_masa',
                                            'krt__aktiviti_laporan.penganjur_id AS penganjur_id',
                                            'krt__aktiviti_laporan.peringkat_id AS peringkat_id',
                                            'krt__aktiviti_laporan.agenda_id AS agenda_id',
                                            'krt__aktiviti_laporan.program_id AS program_id',
                                            'krt__aktiviti_laporan.bidang_id AS bidang_id',
                                            'krt__aktiviti_laporan.aktiviti_id AS aktiviti_id',
                                            'krt__aktiviti_laporan.sub_aktiviti_id AS sub_aktiviti_id',
                                            'krt__aktiviti_laporan.aktiviti_pembelanjaan AS aktiviti_pembelanjaan',
                                            'krt__aktiviti_laporan.kewangan_id AS kewangan_id',
                                            'krt__aktiviti_laporan.aktiviti_sasar AS aktiviti_sasar',
                                            'krt__aktiviti_laporan.aktiviti_perasmi AS aktiviti_perasmi',
                                            'ref__status_aktiviti.status_description AS status_description',
                                            'krt__aktiviti_laporan.aktiviti_status AS aktiviti_status',
                                            'krt__aktiviti_laporan.disahkan_note AS disahkan_note')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_aktiviti','ref__status_aktiviti.id','=','krt__aktiviti_laporan.aktiviti_status')
                                    ->where('krt__aktiviti_laporan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state           = RefStates::where('status', '=',  true)->get();
            $daerah          = RefDaerah::where('status', '=',  true)->get();
            $penganjur       = Ref_Aktiviti_Penganjur::where('status', '=',  true)->get();
            $peringkat       = Ref_Aktiviti_Peringkat::where('status', '=',  true)->get();
            $agenda          = Ref_Aktiviti_Agenda_Kerja::where('status', '=',  true)->get();
            $bidang          = Ref_Aktiviti_Bidang::where('status', '=',  true)->get();
            $aktiviti        = Ref_Aktiviti::where('status', '=',  true)->get();
            $program         = Ref_Aktiviti_Program::where('status', '=',  true)->get();
            $sub_aktiviti    = Ref_Aktiviti_Sub::where('status', '=',  true)->get();
            $bahagian        = Ref_Aktiviti_Bahagian::where('status', '=',  true)->get();
            $sumber_kewangan = Ref_Aktiviti_Sumber_Kewangan::where('status', '=',  true)->get();
            return view('rt-sm6.jana-laporan-aktiviti-krt-1', 
            compact('roles_menu','laporan_aktiviti', 'state', 'daerah', 'penganjur', 'peringkat', 'agenda', 'bidang', 'aktiviti', 'program', 'sub_aktiviti', 'bahagian', 'sumber_kewangan'));
        }
    }

    function jana_laporan_aktiviti_krt_2(Request $request, $id){
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
            $laporan_aktiviti   = DB::table('krt__aktiviti_laporan')
                                    ->select('krt__aktiviti_laporan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_laporan.state_id AS state_id',
                                            'krt__aktiviti_laporan.daerah_id AS daerah_id',
                                            'krt__aktiviti_laporan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_laporan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__aktiviti_laporan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state          = RefStates::where('status', '=',  true)->get();
            $daerah         = RefDaerah::where('status', '=',  true)->get();
            $kaum           = RefKaum::where('status', '=',  true)->get();
            $jantina        = RefJantina::where('status', '=',  true)->get();
            $umur           = Ref_Kelompok_Umur::where('status', '=',  true)->get();
            $rakan_perpaduan = Ref_Rakan_Perpaduan::where('status', '=',  true)->get();
            $sumbangan       = Ref_Sumbangan::where('status', '=',  true)->get();
            return view('rt-sm6.jana-laporan-aktiviti-krt-2',compact('roles_menu','laporan_aktiviti','state','daerah', 'kaum', 'jantina', 'umur', 'rakan_perpaduan', 'sumbangan'));
        }
    }

    function jana_laporan_aktiviti_krt_3(Request $request, $id){
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
            $laporan_aktiviti   = DB::table('krt__aktiviti_laporan')
                                    ->select('krt__aktiviti_laporan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_laporan.state_id AS state_id',
                                            'krt__aktiviti_laporan.daerah_id AS daerah_id',
                                            'krt__aktiviti_laporan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_laporan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL',
                                            'krt__aktiviti_laporan.aktiviti_ringkasan_program AS aktiviti_ringkasan_program',
                                            'krt__aktiviti_laporan.aktiviti_post_mortem AS aktiviti_post_mortem',
                                            'krt__aktiviti_laporan.aktiviti_soal_selidik AS aktiviti_soal_selidik',
                                            'krt__aktiviti_laporan.aktiviti_pemerhatian AS aktiviti_pemerhatian',
                                            'krt__aktiviti_laporan.aktiviti_temubual AS aktiviti_temubual',
                                            'krt__aktiviti_laporan.aktiviti_kekuatan AS aktiviti_kekuatan',
                                            'krt__aktiviti_laporan.aktiviti_keberkesanan AS aktiviti_keberkesanan',
                                            'krt__aktiviti_laporan.aktiviti_penambahbaikan AS aktiviti_penambahbaikan')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__aktiviti_laporan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state          = RefStates::where('status', '=',  true)->get();
            $daerah         = RefDaerah::where('status', '=',  true)->get();
            return view('rt-sm6.jana-laporan-aktiviti-krt-3',compact('roles_menu','laporan_aktiviti','state','daerah'));
        }
    }

    function jana_laporan_aktiviti_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__aktiviti_laporan')
                        ->select('krt__aktiviti_laporan.id',
                                'ref__daerahs.daerah_id AS daerah_id',
                                'krt__profile.krt_nama AS krt_nama',
                                'krt__aktiviti_laporan.aktiviti_tajuk AS aktiviti_tajuk',
                                'ref__aktiviti_agenda_kerja.agenda_description AS aktiviti_agenda',
                                'ref__aktiviti_bidang.bidang_description AS aktiviti_bidang',
                                DB::raw(" DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh_rancang,'%d/%m/%Y') AS aktiviti_tarikh_rancang"),
                                DB::raw(" DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh,'%d/%m/%Y') AS aktiviti_tarikh"),
                                'ref__status_aktiviti.status_description AS status_description',
                                'krt__aktiviti_laporan.aktiviti_status AS aktiviti_status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__aktiviti_agenda_kerja','ref__aktiviti_agenda_kerja.id','=','krt__aktiviti_laporan.agenda_id')
                        ->leftJoin('ref__aktiviti_bidang','ref__aktiviti_bidang.id','=','krt__aktiviti_laporan.bidang_id')
                        ->leftJoin('ref__status_aktiviti','ref__status_aktiviti.id','=','krt__aktiviti_laporan.aktiviti_status')
                        ->orderBy('krt__aktiviti_laporan.id', 'asc')
                        ->where('krt__aktiviti_laporan.aktiviti_status', '=', 1)
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
            $krt    = KRT_Profile::where('daerah_id', '=',  Auth::user()->daerah_id)
                    ->where('krt__profile.krt_status', '=', true)
                    ->get();
            return view('rt-sm6.jana-laporan-aktiviti-ppd', compact('roles_menu','krt'));
        }
    }

    function jana_laporan_aktiviti_ppd_1(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_program') {
                $value = $request->value;
                $where = array('agenda_id' => $value);
                $data  = Ref_Aktiviti_Program::where($where)->get();
                return Response::json($data);
             }else if($type == 'get_sub_bidang') {
                $value = $request->value;
                $where = array('bidang_id' => $value);
                $data  = Ref_Aktiviti_Sub_Bidang::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_aktiviti') {
                $value = $request->value;
                $where = array('sub_bidang_id' => $value);
                $data  = Ref_Aktiviti::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_aktiviti_sub') {
                $value = $request->value;
                $where = array('aktiviti_id' => $value);
                $data  = Ref_Aktiviti_Sub::where($where)->get();
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
            $laporan_aktiviti   = DB::table('krt__aktiviti_laporan')
                                    ->select('krt__aktiviti_laporan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_laporan.state_id AS state_id',
                                            'krt__aktiviti_laporan.daerah_id AS daerah_id',
                                            'krt__aktiviti_laporan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_laporan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL',
                                            'krt__aktiviti_laporan.aktiviti_tajuk AS aktiviti_tajuk',
                                            DB::raw(" DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh,'%d/%m/%Y') AS aktiviti_tarikh"),
                                            DB::raw(" DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh_rancang,'%d/%m/%Y') AS aktiviti_tarikh_rancang"),
                                            'krt__aktiviti_laporan.aktiviti_masa AS aktiviti_masa',
                                            'krt__aktiviti_laporan.penganjur_id AS penganjur_id',
                                            'krt__aktiviti_laporan.peringkat_id AS peringkat_id',
                                            'krt__aktiviti_laporan.agenda_id AS agenda_id',
                                            'krt__aktiviti_laporan.program_id AS program_id',
                                            'krt__aktiviti_laporan.bidang_id AS bidang_id',
                                            'krt__aktiviti_laporan.aktiviti_id AS aktiviti_id',
                                            'krt__aktiviti_laporan.sub_aktiviti_id AS sub_aktiviti_id',
                                            'krt__aktiviti_laporan.aktiviti_pembelanjaan AS aktiviti_pembelanjaan',
                                            'krt__aktiviti_laporan.kewangan_id AS kewangan_id',
                                            'krt__aktiviti_laporan.aktiviti_sasar AS aktiviti_sasar',
                                            'krt__aktiviti_laporan.aktiviti_perasmi AS aktiviti_perasmi',
                                            'ref__status_aktiviti.status_description AS status_description',
                                            'krt__aktiviti_laporan.aktiviti_status AS aktiviti_status',
                                            'krt__aktiviti_laporan.disahkan_note AS disahkan_note')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_aktiviti','ref__status_aktiviti.id','=','krt__aktiviti_laporan.aktiviti_status')
                                    ->where('krt__aktiviti_laporan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state           = RefStates::where('status', '=',  true)->get();
            $daerah          = RefDaerah::where('status', '=',  true)->get();
            $penganjur       = Ref_Aktiviti_Penganjur::where('status', '=',  true)->get();
            $peringkat       = Ref_Aktiviti_Peringkat::where('status', '=',  true)->get();
            $agenda          = Ref_Aktiviti_Agenda_Kerja::where('status', '=',  true)->get();
            $bidang          = Ref_Aktiviti_Bidang::where('status', '=',  true)->get();
            $aktiviti        = Ref_Aktiviti::where('status', '=',  true)->get();
            $program         = Ref_Aktiviti_Program::where('status', '=',  true)->get();
            $sub_aktiviti    = Ref_Aktiviti_Sub::where('status', '=',  true)->get();
            $bahagian        = Ref_Aktiviti_Bahagian::where('status', '=',  true)->get();
            $sumber_kewangan = Ref_Aktiviti_Sumber_Kewangan::where('status', '=',  true)->get();
            return view('rt-sm6.jana-laporan-aktiviti-ppd-1', 
            compact('roles_menu','laporan_aktiviti', 'state', 'daerah', 'penganjur', 'peringkat', 'agenda', 'bidang', 'aktiviti', 'program', 'sub_aktiviti', 'bahagian', 'sumber_kewangan'));
        }
    }

    function jana_laporan_aktiviti_ppd_2(Request $request, $id){
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
            $laporan_aktiviti   = DB::table('krt__aktiviti_laporan')
                                    ->select('krt__aktiviti_laporan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_laporan.state_id AS state_id',
                                            'krt__aktiviti_laporan.daerah_id AS daerah_id',
                                            'krt__aktiviti_laporan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_laporan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__aktiviti_laporan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state          = RefStates::where('status', '=',  true)->get();
            $daerah         = RefDaerah::where('status', '=',  true)->get();
            $kaum           = RefKaum::where('status', '=',  true)->get();
            $jantina        = RefJantina::where('status', '=',  true)->get();
            $umur           = Ref_Kelompok_Umur::where('status', '=',  true)->get();
            $rakan_perpaduan = Ref_Rakan_Perpaduan::where('status', '=',  true)->get();
            $sumbangan       = Ref_Sumbangan::where('status', '=',  true)->get();
            return view('rt-sm6.jana-laporan-aktiviti-ppd-2',compact('roles_menu','laporan_aktiviti','state','daerah', 'kaum', 'jantina', 'umur', 'rakan_perpaduan', 'sumbangan'));
        }
    }

    function jana_laporan_aktiviti_ppd_3(Request $request, $id){
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
            $laporan_aktiviti   = DB::table('krt__aktiviti_laporan')
                                    ->select('krt__aktiviti_laporan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_laporan.state_id AS state_id',
                                            'krt__aktiviti_laporan.daerah_id AS daerah_id',
                                            'krt__aktiviti_laporan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_laporan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL',
                                            'krt__aktiviti_laporan.aktiviti_ringkasan_program AS aktiviti_ringkasan_program',
                                            'krt__aktiviti_laporan.aktiviti_post_mortem AS aktiviti_post_mortem',
                                            'krt__aktiviti_laporan.aktiviti_soal_selidik AS aktiviti_soal_selidik',
                                            'krt__aktiviti_laporan.aktiviti_pemerhatian AS aktiviti_pemerhatian',
                                            'krt__aktiviti_laporan.aktiviti_temubual AS aktiviti_temubual',
                                            'krt__aktiviti_laporan.aktiviti_kekuatan AS aktiviti_kekuatan',
                                            'krt__aktiviti_laporan.aktiviti_keberkesanan AS aktiviti_keberkesanan',
                                            'krt__aktiviti_laporan.aktiviti_penambahbaikan AS aktiviti_penambahbaikan')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__aktiviti_laporan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state          = RefStates::where('status', '=',  true)->get();
            $daerah         = RefDaerah::where('status', '=',  true)->get();
            return view('rt-sm6.jana-laporan-aktiviti-ppd-3',compact('roles_menu','laporan_aktiviti','state','daerah'));
        }
    }

    function jana_laporan_aktiviti_ppn(Request $request){
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
            $data = DB::table('krt__aktiviti_laporan')
                        ->select('krt__aktiviti_laporan.id',
                                'ref__daerahs.daerah_description AS daerah',
                                'ref__daerahs.daerah_id AS daerah_id',
                                'krt__profile.krt_nama AS krt_nama',
                                'krt__aktiviti_laporan.aktiviti_tajuk AS aktiviti_tajuk',
                                'ref__aktiviti_agenda_kerja.agenda_description AS aktiviti_agenda',
                                'ref__aktiviti_bidang.bidang_description AS aktiviti_bidang',
                                DB::raw(" DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh_rancang,'%d/%m/%Y') AS aktiviti_tarikh_rancang"),
                                DB::raw(" DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh,'%d/%m/%Y') AS aktiviti_tarikh"),
                                'ref__status_aktiviti.status_description AS status_description',
                                'krt__aktiviti_laporan.aktiviti_status AS aktiviti_status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__aktiviti_agenda_kerja','ref__aktiviti_agenda_kerja.id','=','krt__aktiviti_laporan.agenda_id')
                        ->leftJoin('ref__aktiviti_bidang','ref__aktiviti_bidang.id','=','krt__aktiviti_laporan.bidang_id')
                        ->leftJoin('ref__status_aktiviti','ref__status_aktiviti.id','=','krt__aktiviti_laporan.aktiviti_status')
                        ->orderBy('krt__aktiviti_laporan.id', 'asc')
                        ->where('krt__aktiviti_laporan.aktiviti_status', '=', 1)
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
            $daerah  = RefDaerah::where('state_id', '=',  Auth::user()->state_id)->get();
            $krt  = KRT_Profile::where('krt_status', '=',  true)->get();
            return view('rt-sm6.jana-laporan-aktiviti-ppn', compact('roles_menu','daerah','krt'));
        }
    }

    function jana_laporan_aktiviti_ppn_1(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_program') {
                $value = $request->value;
                $where = array('agenda_id' => $value);
                $data  = Ref_Aktiviti_Program::where($where)->get();
                return Response::json($data);
             }else if($type == 'get_sub_bidang') {
                $value = $request->value;
                $where = array('bidang_id' => $value);
                $data  = Ref_Aktiviti_Sub_Bidang::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_aktiviti') {
                $value = $request->value;
                $where = array('sub_bidang_id' => $value);
                $data  = Ref_Aktiviti::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_aktiviti_sub') {
                $value = $request->value;
                $where = array('aktiviti_id' => $value);
                $data  = Ref_Aktiviti_Sub::where($where)->get();
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
            $laporan_aktiviti   = DB::table('krt__aktiviti_laporan')
                                    ->select('krt__aktiviti_laporan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_laporan.state_id AS state_id',
                                            'krt__aktiviti_laporan.daerah_id AS daerah_id',
                                            'krt__aktiviti_laporan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_laporan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL',
                                            'krt__aktiviti_laporan.aktiviti_tajuk AS aktiviti_tajuk',
                                            DB::raw(" DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh,'%d/%m/%Y') AS aktiviti_tarikh"),
                                            DB::raw(" DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh_rancang,'%d/%m/%Y') AS aktiviti_tarikh_rancang"),
                                            'krt__aktiviti_laporan.aktiviti_masa AS aktiviti_masa',
                                            'krt__aktiviti_laporan.penganjur_id AS penganjur_id',
                                            'krt__aktiviti_laporan.peringkat_id AS peringkat_id',
                                            'krt__aktiviti_laporan.agenda_id AS agenda_id',
                                            'krt__aktiviti_laporan.program_id AS program_id',
                                            'krt__aktiviti_laporan.bidang_id AS bidang_id',
                                            'krt__aktiviti_laporan.aktiviti_id AS aktiviti_id',
                                            'krt__aktiviti_laporan.sub_aktiviti_id AS sub_aktiviti_id',
                                            'krt__aktiviti_laporan.aktiviti_pembelanjaan AS aktiviti_pembelanjaan',
                                            'krt__aktiviti_laporan.kewangan_id AS kewangan_id',
                                            'krt__aktiviti_laporan.aktiviti_sasar AS aktiviti_sasar',
                                            'krt__aktiviti_laporan.aktiviti_perasmi AS aktiviti_perasmi',
                                            'ref__status_aktiviti.status_description AS status_description',
                                            'krt__aktiviti_laporan.aktiviti_status AS aktiviti_status',
                                            'krt__aktiviti_laporan.disahkan_note AS disahkan_note')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_aktiviti','ref__status_aktiviti.id','=','krt__aktiviti_laporan.aktiviti_status')
                                    ->where('krt__aktiviti_laporan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state           = RefStates::where('status', '=',  true)->get();
            $daerah          = RefDaerah::where('status', '=',  true)->get();
            $penganjur       = Ref_Aktiviti_Penganjur::where('status', '=',  true)->get();
            $peringkat       = Ref_Aktiviti_Peringkat::where('status', '=',  true)->get();
            $agenda          = Ref_Aktiviti_Agenda_Kerja::where('status', '=',  true)->get();
            $bidang          = Ref_Aktiviti_Bidang::where('status', '=',  true)->get();
            $aktiviti        = Ref_Aktiviti::where('status', '=',  true)->get();
            $program         = Ref_Aktiviti_Program::where('status', '=',  true)->get();
            $sub_aktiviti    = Ref_Aktiviti_Sub::where('status', '=',  true)->get();
            $bahagian        = Ref_Aktiviti_Bahagian::where('status', '=',  true)->get();
            $sumber_kewangan = Ref_Aktiviti_Sumber_Kewangan::where('status', '=',  true)->get();
            return view('rt-sm6.jana-laporan-aktiviti-ppn-1', 
            compact('roles_menu','laporan_aktiviti', 'state', 'daerah', 'penganjur', 'peringkat', 'agenda', 'bidang', 'aktiviti', 'program', 'sub_aktiviti', 'bahagian', 'sumber_kewangan'));
        }
    }

    function jana_laporan_aktiviti_ppn_2(Request $request, $id){
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
            $laporan_aktiviti   = DB::table('krt__aktiviti_laporan')
                                    ->select('krt__aktiviti_laporan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_laporan.state_id AS state_id',
                                            'krt__aktiviti_laporan.daerah_id AS daerah_id',
                                            'krt__aktiviti_laporan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_laporan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__aktiviti_laporan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state          = RefStates::where('status', '=',  true)->get();
            $daerah         = RefDaerah::where('status', '=',  true)->get();
            $kaum           = RefKaum::where('status', '=',  true)->get();
            $jantina        = RefJantina::where('status', '=',  true)->get();
            $umur           = Ref_Kelompok_Umur::where('status', '=',  true)->get();
            $rakan_perpaduan = Ref_Rakan_Perpaduan::where('status', '=',  true)->get();
            $sumbangan       = Ref_Sumbangan::where('status', '=',  true)->get();
            return view('rt-sm6.jana-laporan-aktiviti-ppn-2',compact('roles_menu','laporan_aktiviti','state','daerah', 'kaum', 'jantina', 'umur', 'rakan_perpaduan', 'sumbangan'));
        }
    }

    function jana_laporan_aktiviti_ppn_3(Request $request, $id){
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
            $laporan_aktiviti   = DB::table('krt__aktiviti_laporan')
                                    ->select('krt__aktiviti_laporan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_laporan.state_id AS state_id',
                                            'krt__aktiviti_laporan.daerah_id AS daerah_id',
                                            'krt__aktiviti_laporan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_laporan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL',
                                            'krt__aktiviti_laporan.aktiviti_ringkasan_program AS aktiviti_ringkasan_program',
                                            'krt__aktiviti_laporan.aktiviti_post_mortem AS aktiviti_post_mortem',
                                            'krt__aktiviti_laporan.aktiviti_soal_selidik AS aktiviti_soal_selidik',
                                            'krt__aktiviti_laporan.aktiviti_pemerhatian AS aktiviti_pemerhatian',
                                            'krt__aktiviti_laporan.aktiviti_temubual AS aktiviti_temubual',
                                            'krt__aktiviti_laporan.aktiviti_kekuatan AS aktiviti_kekuatan',
                                            'krt__aktiviti_laporan.aktiviti_keberkesanan AS aktiviti_keberkesanan',
                                            'krt__aktiviti_laporan.aktiviti_penambahbaikan AS aktiviti_penambahbaikan')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__aktiviti_laporan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state          = RefStates::where('status', '=',  true)->get();
            $daerah         = RefDaerah::where('status', '=',  true)->get();
            return view('rt-sm6.jana-laporan-aktiviti-ppn-3',compact('roles_menu','laporan_aktiviti','state','daerah'));
        }
    }

    function jana_laporan_aktiviti_hq(Request $request){
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
            $data = DB::table('krt__aktiviti_laporan')
                        ->select('krt__aktiviti_laporan.id',
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'ref__daerahs.daerah_id AS daerah_id',
                                'krt__profile.krt_nama AS krt_nama',
                                'krt__aktiviti_laporan.aktiviti_tajuk AS aktiviti_tajuk',
                                'ref__aktiviti_agenda_kerja.agenda_description AS aktiviti_agenda',
                                'ref__aktiviti_bidang.bidang_description AS aktiviti_bidang',
                                DB::raw(" DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh_rancang,'%d/%m/%Y') AS aktiviti_tarikh_rancang"),
                                DB::raw(" DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh,'%d/%m/%Y') AS aktiviti_tarikh"),
                                'ref__status_aktiviti.status_description AS status_description',
                                'krt__aktiviti_laporan.aktiviti_status AS aktiviti_status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__aktiviti_agenda_kerja','ref__aktiviti_agenda_kerja.id','=','krt__aktiviti_laporan.agenda_id')
                        ->leftJoin('ref__aktiviti_bidang','ref__aktiviti_bidang.id','=','krt__aktiviti_laporan.bidang_id')
                        ->leftJoin('ref__status_aktiviti','ref__status_aktiviti.id','=','krt__aktiviti_laporan.aktiviti_status')
                        ->orderBy('krt__aktiviti_laporan.id', 'asc')
                        ->where('krt__aktiviti_laporan.aktiviti_status', '=', 1)
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
            $krt        = KRT_Profile::where('krt_status', '=',  true)->get();
            return view('rt-sm6.jana-laporan-aktiviti-hq', compact('roles_menu','state','daerah','krt'));
        }
    }

    function jana_laporan_aktiviti_hq_1(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_program') {
                $value = $request->value;
                $where = array('agenda_id' => $value);
                $data  = Ref_Aktiviti_Program::where($where)->get();
                return Response::json($data);
             }else if($type == 'get_sub_bidang') {
                $value = $request->value;
                $where = array('bidang_id' => $value);
                $data  = Ref_Aktiviti_Sub_Bidang::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_aktiviti') {
                $value = $request->value;
                $where = array('sub_bidang_id' => $value);
                $data  = Ref_Aktiviti::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_aktiviti_sub') {
                $value = $request->value;
                $where = array('aktiviti_id' => $value);
                $data  = Ref_Aktiviti_Sub::where($where)->get();
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
            $laporan_aktiviti   = DB::table('krt__aktiviti_laporan')
                                    ->select('krt__aktiviti_laporan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_laporan.state_id AS state_id',
                                            'krt__aktiviti_laporan.daerah_id AS daerah_id',
                                            'krt__aktiviti_laporan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_laporan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL',
                                            'krt__aktiviti_laporan.aktiviti_tajuk AS aktiviti_tajuk',
                                            DB::raw(" DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh,'%d/%m/%Y') AS aktiviti_tarikh"),
                                            DB::raw(" DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh_rancang,'%d/%m/%Y') AS aktiviti_tarikh_rancang"),
                                            'krt__aktiviti_laporan.aktiviti_masa AS aktiviti_masa',
                                            'krt__aktiviti_laporan.penganjur_id AS penganjur_id',
                                            'krt__aktiviti_laporan.peringkat_id AS peringkat_id',
                                            'krt__aktiviti_laporan.agenda_id AS agenda_id',
                                            'krt__aktiviti_laporan.program_id AS program_id',
                                            'krt__aktiviti_laporan.bidang_id AS bidang_id',
                                            'krt__aktiviti_laporan.aktiviti_id AS aktiviti_id',
                                            'krt__aktiviti_laporan.sub_aktiviti_id AS sub_aktiviti_id',
                                            'krt__aktiviti_laporan.aktiviti_pembelanjaan AS aktiviti_pembelanjaan',
                                            'krt__aktiviti_laporan.kewangan_id AS kewangan_id',
                                            'krt__aktiviti_laporan.aktiviti_sasar AS aktiviti_sasar',
                                            'krt__aktiviti_laporan.aktiviti_perasmi AS aktiviti_perasmi',
                                            'ref__status_aktiviti.status_description AS status_description',
                                            'krt__aktiviti_laporan.aktiviti_status AS aktiviti_status',
                                            'krt__aktiviti_laporan.disahkan_note AS disahkan_note')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('ref__status_aktiviti','ref__status_aktiviti.id','=','krt__aktiviti_laporan.aktiviti_status')
                                    ->where('krt__aktiviti_laporan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state           = RefStates::where('status', '=',  true)->get();
            $daerah          = RefDaerah::where('status', '=',  true)->get();
            $penganjur       = Ref_Aktiviti_Penganjur::where('status', '=',  true)->get();
            $peringkat       = Ref_Aktiviti_Peringkat::where('status', '=',  true)->get();
            $agenda          = Ref_Aktiviti_Agenda_Kerja::where('status', '=',  true)->get();
            $bidang          = Ref_Aktiviti_Bidang::where('status', '=',  true)->get();
            $aktiviti        = Ref_Aktiviti::where('status', '=',  true)->get();
            $program         = Ref_Aktiviti_Program::where('status', '=',  true)->get();
            $sub_aktiviti    = Ref_Aktiviti_Sub::where('status', '=',  true)->get();
            $bahagian        = Ref_Aktiviti_Bahagian::where('status', '=',  true)->get();
            $sumber_kewangan = Ref_Aktiviti_Sumber_Kewangan::where('status', '=',  true)->get();
            return view('rt-sm6.jana-laporan-aktiviti-hq-1', 
            compact('roles_menu','laporan_aktiviti', 'state', 'daerah', 'penganjur', 'peringkat', 'agenda', 'bidang', 'aktiviti', 'program', 'sub_aktiviti', 'bahagian', 'sumber_kewangan'));
        }
    }

    function jana_laporan_aktiviti_hq_2(Request $request, $id){
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
            $laporan_aktiviti   = DB::table('krt__aktiviti_laporan')
                                    ->select('krt__aktiviti_laporan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_laporan.state_id AS state_id',
                                            'krt__aktiviti_laporan.daerah_id AS daerah_id',
                                            'krt__aktiviti_laporan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_laporan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__aktiviti_laporan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state          = RefStates::where('status', '=',  true)->get();
            $daerah         = RefDaerah::where('status', '=',  true)->get();
            $kaum           = RefKaum::where('status', '=',  true)->get();
            $jantina        = RefJantina::where('status', '=',  true)->get();
            $umur           = Ref_Kelompok_Umur::where('status', '=',  true)->get();
            $rakan_perpaduan = Ref_Rakan_Perpaduan::where('status', '=',  true)->get();
            $sumbangan       = Ref_Sumbangan::where('status', '=',  true)->get();
            return view('rt-sm6.jana-laporan-aktiviti-hq-2',compact('roles_menu','laporan_aktiviti','state','daerah', 'kaum', 'jantina', 'umur', 'rakan_perpaduan', 'sumbangan'));
        }
    }

    function jana_laporan_aktiviti_hq_3(Request $request, $id){
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
            $laporan_aktiviti   = DB::table('krt__aktiviti_laporan')
                                    ->select('krt__aktiviti_laporan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__aktiviti_laporan.state_id AS state_id',
                                            'krt__aktiviti_laporan.daerah_id AS daerah_id',
                                            'krt__aktiviti_laporan.aktiviti_tempat AS aktiviti_tempat',
                                            'krt__aktiviti_laporan.aktiviti_kawasan_DL AS aktiviti_kawasan_DL',
                                            'krt__aktiviti_laporan.aktiviti_ringkasan_program AS aktiviti_ringkasan_program',
                                            'krt__aktiviti_laporan.aktiviti_post_mortem AS aktiviti_post_mortem',
                                            'krt__aktiviti_laporan.aktiviti_soal_selidik AS aktiviti_soal_selidik',
                                            'krt__aktiviti_laporan.aktiviti_pemerhatian AS aktiviti_pemerhatian',
                                            'krt__aktiviti_laporan.aktiviti_temubual AS aktiviti_temubual',
                                            'krt__aktiviti_laporan.aktiviti_kekuatan AS aktiviti_kekuatan',
                                            'krt__aktiviti_laporan.aktiviti_keberkesanan AS aktiviti_keberkesanan',
                                            'krt__aktiviti_laporan.aktiviti_penambahbaikan AS aktiviti_penambahbaikan')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__aktiviti_laporan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state          = RefStates::where('status', '=',  true)->get();
            $daerah         = RefDaerah::where('status', '=',  true)->get();
            return view('rt-sm6.jana-laporan-aktiviti-hq-3',compact('roles_menu','laporan_aktiviti','state','daerah'));
        }
    }

    function penyediaan_perancangan_aktiviti(){
        return view('rt-sm6.penyediaan-perancangan-aktiviti');
    }

    function borang_perancangan_aktiviti_perpaduan(){
        return view('rt-sm6.borang-perancangan-aktiviti-perpaduan');
    }

    function borang_perancangan_aktiviti_perpaduan_1(){
        return view('rt-sm6.borang-perancangan-aktiviti-perpaduan-1');
    }

    function borang_perancangan_aktiviti_perpaduan_2(){
        return view('rt-sm6.borang-perancangan-aktiviti-perpaduan-2');
    }

    function pengesahan_perancangan_aktiviti(){
        return view('rt-sm6.pengesahan-perancangan-aktiviti');
    }

    function pengesahan_borang_perancangan_aktiviti(){
        return view('rt-sm6.pengesahan-borang-perancangan-aktiviti');
    }

    function pengesahan_borang_perancangan_aktiviti_1(){
        return view('rt-sm6.pengesahan-borang-perancangan-aktiviti-1');
    }

    function pengesahan_borang_perancangan_aktiviti_2(){
        return view('rt-sm6.pengesahan-borang-perancangan-aktiviti-2');
    }
    
    function borang_laporan_aktiviti_perpaduan(){
        return view('rt-sm6.borang-laporan-aktiviti-perpaduan');
    }

    function borang_laporan_aktiviti_perpaduan_1(){
        return view('rt-sm6.borang-laporan-aktiviti-perpaduan-1');
    }

    function borang_laporan_aktiviti_perpaduan_2(){
        return view('rt-sm6.borang-laporan-aktiviti-perpaduan-2');
    }

    function pengesahan_laporan_aktiviti(){
        return view('rt-sm6.pengesahan-laporan-aktiviti');
    }

    function pengesahan_borang_laporan_aktiviti(){
        return view('rt-sm6.pengesahan-borang-laporan-aktiviti');
    }

    function pengesahan_borang_laporan_aktiviti_1(){
        return view('rt-sm6.pengesahan-borang-laporan-aktiviti-1');
    }

    function pengesahan_borang_laporan_aktiviti_2(){
        return view('rt-sm6.pengesahan-borang-laporan-aktiviti-2');
    }

    function jana_analisa_laporan_aktiviti(){
        return view('rt-sm6.jana-analisa-laporan-aktiviti');
    }

    function jana_laporan_perancangan_aktiviti_rt(){
        return view('rt-sm6.jana-laporan-perancangan-aktiviti-rt');
    }

    function jana_laporan_perancangan_aktiviti_daerah(){
        return view('rt-sm6.jana-laporan-perancangan-aktiviti-daerah');
    }

    function view_pengesahan_borang_perancangan_aktiviti(){
        return view('rt-sm6.view-pengesahan-borang-perancangan-aktiviti');
    }

    function view_pengesahan_borang_perancangan_aktiviti_1(){
        return view('rt-sm6.view-pengesahan-borang-perancangan-aktiviti-1');
    }

    function view_pengesahan_borang_perancangan_aktiviti_2(){
        return view('rt-sm6.view-pengesahan-borang-perancangan-aktiviti-2');
    }

    function jana_laporan_perancangan_aktiviti_negeri(){
        return view('rt-sm6.jana-laporan-perancangan-aktiviti-negeri');
    }

    function jana_laporan_aktiviti_daerah(){
        return view('rt-sm6.jana-laporan-aktiviti-daerah');
    }

    function jana_laporan_aktiviti_negeri(){
        return view('rt-sm6.jana-laporan-aktiviti-negeri');
    }

    function penyediaan_laporan_aktiviti(){
        return view('rt-sm6.penyediaan-laporan-aktiviti');
    }
}
