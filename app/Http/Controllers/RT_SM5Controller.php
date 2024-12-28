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
use App\KRT_Profile;
use App\KRT_Minit_Mesyuarat_RT;
use App\KRT_Minit_Mesyuarat_Kehadiran;
use App\KRT_Minit_Mesyuarat_Perkara_Berbangkit;
use App\KRT_Minit_Mesyuarat_Kertas_Kerja;
use App\KRT_Minit_Mesyuarat_Hal_Lain;
use App\KRT_Ahli_Jawatan_Kuasa;

use DataTables;
use DB;

class RT_SM5Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function senarai_minit_mesyuarat_rt(Request $request){
        if($request->ajax()){
            $type = $request->type;
            $data = DB::table('krt__minit_mesyuarat')
                        ->select('krt__minit_mesyuarat.id',
                        'krt__minit_mesyuarat.mesyuarat_title',
                        DB::raw(" DATE_FORMAT(krt__minit_mesyuarat.mesyuarat_tarikh,'%d/%m/%Y') AS mesyuarat_tarikh"),
						//DB::raw(" REPLACE(krt__minit_mesyuarat.mesyuarat_tempat,'\n',' ') AS mesyuarat_tempat1"),
                        'krt__minit_mesyuarat.mesyuarat_tempat AS mesyuarat_tempat',
                        'ref__status_krt_minit_mesyuarat.status_description',
                        'krt__minit_mesyuarat.mesyuarat_status AS mesyuarat_status')
                        ->leftJoin('ref__status_krt_minit_mesyuarat','ref__status_krt_minit_mesyuarat.id','=','krt__minit_mesyuarat.mesyuarat_status')
                        ->orderBy('krt__minit_mesyuarat.id', 'asc')
                        ->whereIn('krt__minit_mesyuarat.mesyuarat_status', [2,3,4])
                        ->where('krt__minit_mesyuarat.krt_profile_id', '=', Auth::user()->krt_id)
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
            $user_profile   = DB::table('users__profile')
                            ->select('users__profile.id',
                                    'krt__profile.id AS krt_id')
                            ->leftJoin('krt__profile','krt__profile.id','=','users__profile.krt_id')
                            ->where('users__profile.user_id', '=', Auth::user()->user_id)
                            ->limit(1)
                            ->first();
            return view('rt-sm5.senarai-minit-mesyuarat-rt', compact('roles_menu','user_profile'));
        }
    }

    function post_daftar_minit_mesyuarat(Request $request){

        $action = $request->daftar_minit_mesyuarat;
        $app_id = $request->krt_id;

        $rules = array(

        );

        $messages = [

        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm5.senarai_minit_mesyuarat_rt',$app_id))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'add') {
                $minit_mesyuarat = new KRT_Minit_Mesyuarat_RT;
                $minit_mesyuarat->krt_profile_id       = Auth::user()->krt_id;
                $minit_mesyuarat->mesyuarat_status     = 2;
                $minit_mesyuarat->save();
            }

            return Redirect::to(route('rt-sm5.penyediaan_minit_mesyuarat_rt',$minit_mesyuarat->id));
        }

    }

    function penyediaan_minit_mesyuarat_rt(Request $request, $id){
        if($request->ajax()){

        } else {
		
            $krt_ajk        = DB::table('krt__ahli_jawatan_kuasa')
                            ->select('krt__ahli_jawatan_kuasa.id AS id',
                                'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama')
							->leftJoin('krt__minit_mesyuarat','krt__minit_mesyuarat.krt_profile_id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
                            ->where('krt__minit_mesyuarat.id', '=', $id )
                            ->get();
			
			$krt_minit_mesyuarat_kehadiran = DB::table('krt__minit_mesyuarat_kehadiran')
                               			->select('krt__minit_mesyuarat_kehadiran.id',
										'krt__minit_mesyuarat_kehadiran.krt_minit_mesyuarat_id',
                                        'krt__minit_mesyuarat_kehadiran.kehadiran_nama AS kehadiran_nama',
                                        'krt__minit_mesyuarat_kehadiran.kehadiran_ic AS kehadiran_ic')
                                        ->where('krt__minit_mesyuarat_kehadiran.krt_minit_mesyuarat_id', '=', $id)
                                        ->get();
			
            $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
                                'users__menu.highlight AS highlight_menu',
                                'users__menu.users_menu_page_icon AS icon_menu')
                            ->leftJoin('users__menu','users__menu.id','=','roles__menu.users_menu_id')
                            ->leftJoin('users__roles','users__roles.role_id','=','roles__menu.role_id')
                            ->where('users__roles.user_id', '=', Auth::user()->user_id)
                            ->where('roles__menu.status', '=', true)
                            ->orderBy('first_menu', 'asc')
                            ->orderBy('id', 'asc')
                            ->get();
							
            $krt_profile    = DB::table('users__profile')
                            ->select('users__profile.id',
                                        'users__profile.user_id',
                                        'users__profile.user_fullname AS pemohon_name',
                                        'users__profile.no_ic AS pemohon_ic',
                                        'users__profile.no_phone AS pemohon_phone',
                                        'users__profile.krt_id',
                                        'krt__profile.krt_nama AS nama_krt',
                                        'krt__profile.krt_alamat AS alamat_krt',
                                        'ref__states.state_description AS negeri_krt',
                                        'ref__daerahs.daerah_description AS daerah_krt',
                                        'ref__parlimens.parlimen_description AS parlimen_krt',
                                        'ref__duns.dun_description AS dun_krt',
                                        'ref__pbts.pbt_description AS pbt_krt')
                            ->leftJoin('krt__profile','krt__profile.id','=','users__profile.krt_id')
                            ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                            ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                            ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                            ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                            ->where('users__profile.user_id', '=', Auth::user()->user_id)
                            ->limit(1)
                            ->first();
							
            $krt_minit_mesyuarat    = DB::table('krt__minit_mesyuarat')
                                        ->select('krt__minit_mesyuarat.id',
                                        'krt__minit_mesyuarat.krt_profile_id AS krt_profile_id',
                                        'krt__minit_mesyuarat.mesyuarat_title AS mesyuarat_title',
                                        'krt__minit_mesyuarat.mesyuarat_bil AS mesyuarat_bil',
                                        DB::raw(" DATE_FORMAT(krt__minit_mesyuarat.mesyuarat_tarikh,'%d/%m/%Y') AS mesyuarat_tarikh"),
										DB::raw(" REPLACE(REPLACE(krt__minit_mesyuarat.mesyuarat_tempat, '\r', ''), '\n', '<br />') AS mesyuarat_tempat1"),
                                        'krt__minit_mesyuarat.mesyuarat_time AS mesyuarat_time',
                                        'krt__minit_mesyuarat.mesyuarat_tempat AS mesyuarat_tempat',
										'krt__minit_mesyuarat.pengerusi AS pengerusi',
										'krt__minit_mesyuarat.pencatat AS pencatat',
										DB::raw(" REPLACE(REPLACE(krt__minit_mesyuarat.mesyuarat_perutusan_pengerusi, '\r', ''), '\n', '<br />') AS mesyuarat_perutusan_pengerusi"),
                                        //'krt__minit_mesyuarat.mesyuarat_perutusan_pengerusi AS mesyuarat_perutusan_pengerusi',
										DB::raw(" REPLACE(REPLACE(krt__minit_mesyuarat.mesyuarat_yang_lalu, '\r', ''), '\n', '<br />') AS mesyuarat_yang_lalu"),
                                        //'krt__minit_mesyuarat.mesyuarat_yang_lalu AS mesyuarat_yang_lalu',
										DB::raw(" REPLACE(REPLACE(krt__minit_mesyuarat.mesyuarat_penyata_kewangan, '\r', ''), '\n', '<br />') AS mesyuarat_penyata_kewangan"),
                                        //'krt__minit_mesyuarat.mesyuarat_penyata_kewangan AS mesyuarat_penyata_kewangan',
										DB::raw(" REPLACE(REPLACE(krt__minit_mesyuarat.mesyuarat_penutup, '\r', ''), '\n', '<br />') AS mesyuarat_penutup"),
                                        //'krt__minit_mesyuarat.mesyuarat_penutup AS mesyuarat_penutup',
                                        'krt__minit_mesyuarat.mesyuarat_disedia AS mesyuarat_disedia',
                                        'krt__minit_mesyuarat.mesyuarat_disemak AS mesyuarat_disemak',
                                        'krt__minit_mesyuarat.mesyuarat_status AS mesyuarat_status',
                                        'ref__status_krt_minit_mesyuarat.status_description AS status_description',
                                        'krt__minit_mesyuarat.direkod_by AS direkod_by',
                                        'krt__minit_mesyuarat.direkod_date AS direkod_date',
                                        'krt__minit_mesyuarat.disemak_by AS disemak_by',
                                        'krt__minit_mesyuarat.disemak_date AS disemak_date',
                                        'krt__minit_mesyuarat.disemak_note AS disemak_note')
                                        ->leftJoin('ref__status_krt_minit_mesyuarat','ref__status_krt_minit_mesyuarat.id','=','krt__minit_mesyuarat.mesyuarat_status')
                                        ->where('krt__minit_mesyuarat.id', '=', $id)
                                        ->limit(1)
                                        ->first();
										
            return view('rt-sm5.penyediaan-minit-mesyuarat-rt', compact('krt_ajk','roles_menu','krt_profile','krt_minit_mesyuarat','krt_minit_mesyuarat_kehadiran'));
        }
    }

    function post_penyediaan_minit_mesyuarat_rt(Request $request){
        $action = $request->post_penyediaan_minit_mesyuarat_rt;
        $app_id = $request->pmmrt_minit_mesyuarat_id;


        $rules = array(
            'pmmrt_mesyuarat_title'                         => 'required',
            'pmmrt_mesyuarat_tarikh'                        => 'required',
            'pmmrt_mesyuarat_bil'                           => 'required',
            'pmmrt_mesyuarat_time'                          => 'required',
            'pmmrt_mesyuarat_tempat'                        => 'required',
			'pmmrt_pengerusi_mesyuarat'                     => 'required',
			'pmmrt_catat_mesyuarat'                         => 'required',
            'pmmrt_mesyuarat_perutusan_pengerusi'           => 'required',
            'pmmrt_mesyuarat_yang_lalu'                     => 'required',
        );

        $messages = [
            'pmmrt_mesyuarat_title.required'                => 'Ruangan Tajuk Minit Mesyuarat mesti diisi',
            'pmmrt_mesyuarat_tarikh.required'               => 'Ruangan Tarikh Mesyuarat mesti dipilih',
            'pmmrt_mesyuarat_bil.required'                  => 'Ruangan Bil Minit Mesyuarat mesti dipilih',
            'pmmrt_mesyuarat_time.required'                 => 'Ruangan Masa diisi',
            'pmmrt_mesyuarat_tempat.required'               => 'Ruangan Tempat Mesyuarat mesti diisi',
			'pmmrt_pengerusi_mesyuarat.required'            => 'Ruangan Pengerusi Mesyuarat mesti diisi',
			'pmmrt_catat_mesyuarat.required'                => 'Ruangan Pencatat Mesyuarat mesti diisi',
            'pmmrt_mesyuarat_perutusan_pengerusi.required'  => 'Ruangan Perutusan Pengerusi mesti diisi',
            'pmmrt_mesyuarat_yang_lalu.required'            => 'Ruangan Pengesahan Minit mensyurat Yang Lalu mesti diisi'
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $carbon_obj = Carbon::createFromFormat('d/m/Y', $request->pmmrt_mesyuarat_tarikh)->format('Y-m-d');
                $where = array('id' => $app_id);
                $minit_mesyuarat                                    = KRT_Minit_Mesyuarat_RT::where($where)->first();
                $minit_mesyuarat->mesyuarat_title                   = $request->pmmrt_mesyuarat_title;
                $minit_mesyuarat->mesyuarat_tarikh                  = $carbon_obj;
                $minit_mesyuarat->mesyuarat_bil                     = $request->pmmrt_mesyuarat_bil;
                $minit_mesyuarat->mesyuarat_time                    = $request->pmmrt_mesyuarat_time;
                $minit_mesyuarat->mesyuarat_tempat                  = $request->pmmrt_mesyuarat_tempat;
				$minit_mesyuarat->pengerusi			                = $request->pmmrt_pengerusi_mesyuarat;
				$minit_mesyuarat->pencatat			                = $request->pmmrt_catat_mesyuarat;
                $minit_mesyuarat->mesyuarat_perutusan_pengerusi     = $request->pmmrt_mesyuarat_perutusan_pengerusi;
                $minit_mesyuarat->mesyuarat_yang_lalu               = $request->pmmrt_mesyuarat_yang_lalu;
                $minit_mesyuarat->save();
            }
        }
    }

    function senarai_kehadiran_table(Request $request, $id){
        /*$data = DB::table('krt__minit_mesyuarat_kehadiran')
                    ->select('krt__minit_mesyuarat_kehadiran.*')
                    ->where('krt__minit_mesyuarat_kehadiran.krt_minit_mesyuarat_id', '=', $id)
                    ->get();*/
		$data = DB::table('krt__minit_mesyuarat_kehadiran')
				->select('krt__minit_mesyuarat_kehadiran.*')
				//->leftJoin('krt__minit_mesyuarat','krt__minit_mesyuarat.id','=','krt__minit_mesyuarat_kehadiran.krt_minit_mesyuarat_id')
				//->leftJoin('krt__ahli_jawatan_kuasa','krt__ahli_jawatan_kuasa.id','=','krt__minit_mesyuarat_kehadiran.kehadiran_ic')
				->where('krt__minit_mesyuarat_kehadiran.krt_minit_mesyuarat_id', '=', $id)
				//->whereRaw('krt__minit_mesyuarat_kehadiran.kehadiran_ic NOT IN (select krt__ahli_jawatan_kuasa.id from krt__ahli_jawatan_kuasa where krt__ahli_jawatan_kuasa.krt_profile_id=krt__minit_mesyuarat.krt_profile_id and krt__ahli_jawatan_kuasa.ajk_status=1)')
				->where('krt__minit_mesyuarat_kehadiran.jenis_kehadiran','=',1)
				->get();
        return Datatables::of($data)
                    ->make(true);
    }
	
	function senarai_kehadiran_all_table(Request $request, $id){
		$data = DB::table('krt__minit_mesyuarat_kehadiran')
				->select('krt__minit_mesyuarat_kehadiran.*',
				//DB::raw(" test(kehadiran_ic) AS test"),
				DB::raw(" check_jawatan(kehadiran_ic,kehadiran_ic) AS kehadiran_jawatan"),
				'krt__minit_mesyuarat_kehadiran.kehadiran_ic AS kehadiran_ic')
				->where('krt__minit_mesyuarat_kehadiran.krt_minit_mesyuarat_id', '=', $id)
				->get();
        return Datatables::of($data)
                    ->make(true);
    }
	
	function senarai_kehadiran_ajk_table(Request $request, $id){
        $data = DB::table('krt__ahli_jawatan_kuasa')
				->select('krt__ahli_jawatan_kuasa.id AS ajk_id',
				'krt__ahli_jawatan_kuasa.krt_profile_id AS krt_id',
				'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
				'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
				'ref__jawatan_ajk_krt.jawatan_description AS ajk_jawatan',
				DB::raw(" check_hadir(krt__ahli_jawatan_kuasa.id,krt__minit_mesyuarat.id) AS status"),
				'krt__minit_mesyuarat.id AS mtg_id')
				->leftJoin('krt__minit_mesyuarat','krt__minit_mesyuarat.krt_profile_id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
				->leftJoin('ref__jawatan_ajk_krt','ref__jawatan_ajk_krt.id','=','krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
				->where('krt__minit_mesyuarat.id', '=', $id)
				->where('krt__ahli_jawatan_kuasa.ajk_status', '=', 1)
				->orderBy('ajk_jawatan_krt_id', 'asc')
				->get();
        return Datatables::of($data)
                    ->make(true);
    }
	
	function senarai_kehadiran_ajk_table_show(Request $request, $id){
        $data = DB::table('krt__ahli_jawatan_kuasa')
				->select('krt__ahli_jawatan_kuasa.id AS ajk_id',
				'krt__ahli_jawatan_kuasa.krt_profile_id AS krt_id',
				'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
				'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
				'krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS ajk_jawatan_id',
				'ref__jawatan_ajk_krt.jawatan_description AS ajk_jawatan',
				DB::raw(" check_hadir(krt__ahli_jawatan_kuasa.id,krt__minit_mesyuarat.id) AS status"),
				'krt__minit_mesyuarat.id AS mtg_id')
				->leftJoin('krt__minit_mesyuarat','krt__minit_mesyuarat.krt_profile_id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
				->leftJoin('ref__jawatan_ajk_krt','ref__jawatan_ajk_krt.id','=','krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
				->where('krt__minit_mesyuarat.id', '=', $id)
				->where('krt__ahli_jawatan_kuasa.ajk_status', '=', 1)
				->whereRaw("check_hadir(krt__ahli_jawatan_kuasa.id,krt__minit_mesyuarat.id) = 1")
				->orderBy('krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id', 'asc')
				->get();
        return Datatables::of($data)
                    ->make(true);
    }
	
	function senarai_ajk_table(Request $request){
        $data = DB::table('krt__ahli_jawatan_kuasa')
				->select('krt__ahli_jawatan_kuasa.id AS ajk_id',
				'krt__ahli_jawatan_kuasa.krt_profile_id AS krt_id',
				'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
				'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
				//'ref__jawatan_ajk_krt.jawatan_description AS ajk_jawatan')
				DB::raw(" check_jawatan_ajk(krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id) AS ajk_jawatan"),
				'krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
				//'krt__minit_mesyuarat.id AS mtg_id')
				//->leftJoin('krt__minit_mesyuarat','krt__minit_mesyuarat.krt_profile_id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
				//->leftJoin('ref__jawatan_ajk_krt','ref__jawatan_ajk_krt.id','=','krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
				//->where('krt__minit_mesyuarat.id', '=', $id)
				->where('krt__ahli_jawatan_kuasa.krt_profile_id','=',Auth::user()->krt_id)
				->where('krt__ahli_jawatan_kuasa.ajk_status', '=', 1)
				->orderBy('ajk_jawatan_krt_id', 'asc')
				->get();
        return Datatables::of($data)
                    ->make(true);
    }

    function add_kehadiran_mesyuarat(Request $request){
        $action = $request->kehadiran_action;
		$rules = array(
			'kehadiran_nama'            => 'required',
			'kehadiran_ic'              => 'required',
		);
		$messages = [
			'kehadiran_nama.required'   => 'Ruangan Nama Penuh mesti diisi.',
			'kehadiran_ic.required'     => 'Ruangan No Kad Pengenalan mesti diisi.',
		];

		$validator = Validator::make(Input::all(), $rules, $messages);
		if ($validator->fails()) {
			return \Response::json(array('errors' => $validator->errors()->toArray()));
		} else 
		{
			$kehadiran = new KRT_Minit_Mesyuarat_Kehadiran;
			$kehadiran->krt_minit_mesyuarat_id      = $request->pmmrt_minit_mesyuarat_id;
			$kehadiran->jenis_kehadiran				= 1;
			$kehadiran->kehadiran_nama              = $request->kehadiran_nama;
			$kehadiran->kehadiran_ic                = $request->kehadiran_ic;
			$kehadiran->save();
		}
    }

    function get_view_kehadiran_mesyuarat($id){
        $data = DB::table('krt__minit_mesyuarat_kehadiran')
                ->select('krt__minit_mesyuarat_kehadiran.*')
                ->where('krt__minit_mesyuarat_kehadiran.id', '=', $id)
                ->first();
        return Response::json($data);
    }

    function delete_kehadiran($id){
        $data = DB::table('krt__minit_mesyuarat_kehadiran')->where('id', '=', $id)->delete();
    }
	
	function delete_minit($id){
        $data = DB::table('krt__minit_mesyuarat')->where('id', '=', $id)->delete();
    }
	
	function delete_kehadiran_ajk(Request $request){
        $data = DB::table('krt__minit_mesyuarat_kehadiran')
				->where('kehadiran_ic', '=', $request->ajkid)
				->where('krt_minit_mesyuarat_id', '=', $request->mtg_id)
				->where('jenis_kehadiran', '=', 0)
				->delete();
    }
	
	function add_kehadiran_ajk(Request $request){
        $kehadiran = new KRT_Minit_Mesyuarat_Kehadiran;
					 $kehadiran->krt_minit_mesyuarat_id      = $request->mtg_id;
					 $kehadiran->jenis_kehadiran			 = $request->jenis_hadir;
					 $kehadiran->kehadiran_nama              = $request->ajk_nama;
					 $kehadiran->kehadiran_ic                = $request->ajkid;
					 $kehadiran->save();
    }

    function penyediaan_minit_mesyuarat_rt_1(Request $request, $id){
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
            $krt_profile    = DB::table('users__profile')
                            ->select('users__profile.id',
                                'users__profile.user_id',
                                'users__profile.user_fullname AS pemohon_name',
                                'users__profile.no_ic AS pemohon_ic',
                                'users__profile.no_phone AS pemohon_phone',
                                'users__profile.krt_id',
                                'krt__profile.krt_nama AS nama_krt',
                                'krt__profile.krt_alamat AS alamat_krt',
                                'ref__states.state_description AS negeri_krt',
                                'ref__daerahs.daerah_description AS daerah_krt',
                                'ref__parlimens.parlimen_description AS parlimen_krt',
                                'ref__duns.dun_description AS dun_krt',
                                'ref__pbts.pbt_description AS pbt_krt')
                            ->leftJoin('krt__profile','krt__profile.id','=','users__profile.krt_id')
                            ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                            ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                            ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                            ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                            ->where('users__profile.user_id', '=', Auth::user()->user_id)
                            ->limit(1)
                            ->first();
							
            $krt_minit_mesyuarat    = DB::table('krt__minit_mesyuarat')
                                        ->select('krt__minit_mesyuarat.id',
                                        'krt__minit_mesyuarat.krt_profile_id AS krt_profile_id',
                                        'krt__minit_mesyuarat.mesyuarat_title AS mesyuarat_title',
                                        'krt__minit_mesyuarat.mesyuarat_bil AS mesyuarat_bil',
                                        DB::raw(" DATE_FORMAT(krt__minit_mesyuarat.mesyuarat_tarikh,'%d/%m/%Y') AS mesyuarat_tarikh"),
										DB::raw(" REPLACE(REPLACE(krt__minit_mesyuarat.mesyuarat_tempat, '\r', ''), '\n', '<br />') AS mesyuarat_tempat1"),
                                        'krt__minit_mesyuarat.mesyuarat_time AS mesyuarat_time',
                                        'krt__minit_mesyuarat.mesyuarat_tempat AS mesyuarat_tempat',
										DB::raw(" REPLACE(REPLACE(krt__minit_mesyuarat.mesyuarat_perutusan_pengerusi, '\r', ''), '\n', '<br />') AS mesyuarat_perutusan_pengerusi"),
                                        //'krt__minit_mesyuarat.mesyuarat_perutusan_pengerusi AS mesyuarat_perutusan_pengerusi',
										DB::raw(" REPLACE(REPLACE(krt__minit_mesyuarat.mesyuarat_yang_lalu, '\r', ''), '\n', '<br />') AS mesyuarat_yang_lalu"),
                                        //'krt__minit_mesyuarat.mesyuarat_yang_lalu AS mesyuarat_yang_lalu',
										DB::raw(" REPLACE(REPLACE(krt__minit_mesyuarat.mesyuarat_penyata_kewangan, '\r', ''), '\n', '<br />') AS mesyuarat_penyata_kewangan"),
                                        //'krt__minit_mesyuarat.mesyuarat_penyata_kewangan AS mesyuarat_penyata_kewangan',
										DB::raw(" REPLACE(REPLACE(krt__minit_mesyuarat.mesyuarat_penutup, '\r', ''), '\n', '<br />') AS mesyuarat_penutup"),
                                        //'krt__minit_mesyuarat.mesyuarat_penutup AS mesyuarat_penutup',
                                        'krt__minit_mesyuarat.mesyuarat_disedia AS mesyuarat_disedia',
                                        'krt__minit_mesyuarat.mesyuarat_disemak AS mesyuarat_disemak',
                                        'krt__minit_mesyuarat.mesyuarat_status AS mesyuarat_status',
                                        'ref__status_krt_minit_mesyuarat.status_description AS status_description',
                                        'krt__minit_mesyuarat.direkod_by AS direkod_by',
                                        'krt__minit_mesyuarat.direkod_date AS direkod_date',
                                        'krt__minit_mesyuarat.disemak_by AS disemak_by',
                                        'krt__minit_mesyuarat.disemak_date AS disemak_date',
                                        'krt__minit_mesyuarat.disemak_note AS disemak_note')
                                        ->leftJoin('ref__status_krt_minit_mesyuarat','ref__status_krt_minit_mesyuarat.id','=','krt__minit_mesyuarat.mesyuarat_status')
                                        ->where('krt__minit_mesyuarat.id', '=', $id)
                                        ->limit(1)
                                        ->first();
            return view('rt-sm5.penyediaan-minit-mesyuarat-rt-1', compact('roles_menu','krt_profile','krt_minit_mesyuarat'));
        }
    }

    function senarai_perkara_berbangkit_table(Request $request, $id){
        $data = DB::table('krt__minit_mesyuarat_perkara_berbangkit')
                    ->select('krt__minit_mesyuarat_perkara_berbangkit.*')
                    ->where('krt__minit_mesyuarat_perkara_berbangkit.krt_minit_mesyuarat_id', '=', $id)
                    ->get();
        return Datatables::of($data)
                    ->make(true);
    }

    function add_pekara_berbangkit_mesyuarat(Request $request){
        $action = $request->add_pekara_berbangkit_mesyuarat;

        $rules = array(
            'mapbmk_berbangkit_perkara'       => 'required',
            'mapbmk_berbangkit_tindakan'      => 'required',
			'mapbmk_berbangkit_tindakan_siapa'      => 'required',
        );

        $messages = [
            'mapbmk_berbangkit_perkara.required'   => 'Ruangan Perkara mesti diisi.',
            'mapbmk_berbangkit_tindakan.required'  => 'Ruangan Tindakan Yang Diambil mesti diisi.',
			'mapbmk_berbangkit_tindakan_siapa.required'  => 'Ruangan Tindakan Siapa Yang Diambil mesti diisi.',

        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $perkara_berbangkit = new KRT_Minit_Mesyuarat_Perkara_Berbangkit;
                $perkara_berbangkit->krt_minit_mesyuarat_id      = $request->mapbmk_krt_minit_mesyuarat_id;
                $perkara_berbangkit->berbangkit_perkara          = $request->mapbmk_berbangkit_perkara;
                $perkara_berbangkit->berbangkit_tindakan         = $request->mapbmk_berbangkit_tindakan;
				$perkara_berbangkit->berbangkit_tindakan_siapa   = $request->mapbmk_berbangkit_tindakan_siapa;
                $perkara_berbangkit->save();

            }
        }
    }

    function get_view_pekara_berbangkit_mesyuarat($id){
        $data = DB::table('krt__minit_mesyuarat_perkara_berbangkit')
                ->select('krt__minit_mesyuarat_perkara_berbangkit.*')
                ->where('krt__minit_mesyuarat_perkara_berbangkit.id', '=', $id)
                ->first();
        return Response::json($data);
    }

    function delete_perkara_berbangkit_mesyuarat($id){
        $data = DB::table('krt__minit_mesyuarat_perkara_berbangkit')->where('id', '=', $id)->delete();
    }

    function senarai_kertas_kerja_table(Request $request, $id){
        $data = DB::table('krt__minit_mesyuarat_kertas_kerja')
                    ->select('krt__minit_mesyuarat_kertas_kerja.*')
                    ->where('krt__minit_mesyuarat_kertas_kerja.krt_minit_mesyuarat_id', '=', $id)
                    ->get();
        return Datatables::of($data)
                    ->make(true);
    }

    function add_kertas_kerja_mesyuarat(Request $request){
        $action = $request->add_kertas_kerja_mesyuarat;

        $rules = array(
            'makkmk_kertas_kerja_perkara'       		=> 'required',
            'makkmk_kertas_kerja_tindakan'      		=> 'required',
			'makkmk_kertas_kerja_tindakan_siapa'     => 'required',
        );

        $messages = [
            'makkmk_kertas_kerja_perkara.required'   		=> 'Ruangan Perkara mesti diisi.',
            'makkmk_kertas_kerja_tindakan.required'  		=> 'Ruangan Tindakan Yang Diambil mesti diisi.',
			'makkmk_kertas_kerja_tindakan_siapa.required'   => 'Ruangan Tindakan Siapa mesti diisi.',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
			
				if($request->makkmk_kertas_kerja_dokumen == "")
				{
					$fileName = "";
				}else
				{
					$fileName = $request->makkmk_kertas_kerja_dokumen->getClientOriginalName();
            		$request->makkmk_kertas_kerja_dokumen->storeAs('public/dokumen_mesyuarat',$fileName);
				}
					
                $kertas_keja = new KRT_Minit_Mesyuarat_Kertas_Kerja;
                $kertas_keja->krt_minit_mesyuarat_id      = $request->makkmk_krt_minit_mesyuarat_id;
                $kertas_keja->kertas_kerja_perkara        = $request->makkmk_kertas_kerja_perkara;
                $kertas_keja->kertas_kerja_tindakan       = $request->makkmk_kertas_kerja_tindakan;
				$kertas_keja->kertas_kerja_tindakan_siapa = $request->makkmk_kertas_kerja_tindakan_siapa;
				$kertas_keja->kertas_kerja_dokumen = $fileName;
                $kertas_keja->save();
				return \Response::json(array('success' => $request->makkmk_krt_minit_mesyuarat_id));
            }
        }
    }

    function get_view_kertas_kerja_mesyuarat($id){
        $data = DB::table('krt__minit_mesyuarat_kertas_kerja')
                ->select('krt__minit_mesyuarat_kertas_kerja.*')
                ->where('krt__minit_mesyuarat_kertas_kerja.id', '=', $id)
                ->first();
        return Response::json($data);
    }

    function delete_kertas_kerja_mesyuarat($id){
		$ret="";
		$dataselect = DB::table('krt__minit_mesyuarat_kertas_kerja')
                ->select('krt__minit_mesyuarat_kertas_kerja.*')
                ->where('krt__minit_mesyuarat_kertas_kerja.id', '=', $id)
                ->first();
		
		if($dataselect->kertas_kerja_dokumen != "")
		{
			$fileName = $dataselect->kertas_kerja_dokumen;
			$file_path = public_path().'/storage/dokumen_mesyuarat/'.$fileName;
			unlink($file_path);
			$ret=$fileName;
		}
		
        $data = DB::table('krt__minit_mesyuarat_kertas_kerja')->where('id', '=', $id);
		//unlink(storage_path('public/dokumen_mesyuarat'.$fileName));
		$data->delete();
		
		return Response::json($ret);
    }

    function senarai_hal_lain_table(Request $request, $id){
        $data = DB::table('krt__minit_mesyuarat_hal_lain')
                    ->select('krt__minit_mesyuarat_hal_lain.*')
                    ->where('krt__minit_mesyuarat_hal_lain.krt_minit_mesyuarat_id', '=', $id)
                    ->get();
        return Datatables::of($data)
                    ->make(true);
    }

    function add_hal_lain_mesyuarat(Request $request){
        $action = $request->add_hal_lain_mesyuarat;

        $rules = array(
            'mahlmk_hal_lain_perkara'            => 'required',
            'mahlmk_hal_lain_tindakan'           => 'required',
			'mahlmk_hal_lain_tindakan_siapa'           => 'required',
        );

        $messages = [
            'mahlmk_hal_lain_perkara.required'   => 'Ruangan Perkara mesti diisi.',
            'mahlmk_hal_lain_tindakan.required'  => 'Ruangan Tindakan Yang Diambil mesti diisi.',
			'mahlmk_hal_lain_tindakan_siapa.required'  => 'Ruangan Tindakan Siapa mesti diisi.',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $hal_lain = new KRT_Minit_Mesyuarat_Hal_Lain;
                $hal_lain->krt_minit_mesyuarat_id      = $request->mahlmk_krt_minit_mesyuarat_id;
                $hal_lain->hal_lain_perkara            = $request->mahlmk_hal_lain_perkara;
                $hal_lain->hal_lain_tindakan           = $request->mahlmk_hal_lain_tindakan;
				$hal_lain->hal_lain_tindakan_siapa     = $request->mahlmk_hal_lain_tindakan_siapa;
                $hal_lain->save();

            }
        }
    }

    function get_view_hal_lain_mesyuarat($id){
        $data = DB::table('krt__minit_mesyuarat_hal_lain')
                ->select('krt__minit_mesyuarat_hal_lain.*')
                ->where('krt__minit_mesyuarat_hal_lain.id', '=', $id)
                ->first();
        return Response::json($data);
    }

    function delete_hal_lain_mesyuarat($id){
        $data = DB::table('krt__minit_mesyuarat_hal_lain')->where('id', '=', $id)->delete();
    }

    function post_penyediaan_minit_mesyuarat_rt_1(Request $request){
        $action = $request->post_penyediaan_minit_mesyuarat_rt_1;
        $app_id = $request->pmmrt_1_minit_mesyuarat_id;


        $rules = array(
            'pmmrt_1_mesyuarat_penyata_kewangan'               => 'required',
            'pmmrt_1_mesyuarat_penutup'                        => 'required',
        );

        $messages = [
            'pmmrt_1_mesyuarat_penyata_kewangan.required'      => 'Ruangan Pembentangan Penyata Kewangan Rukun Tetangga mesti diisi',
            'pmmrt_1_mesyuarat_penutup.required'               => 'Ruangan Penutup mesti diisi',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $minit_mesyuarat                                    = KRT_Minit_Mesyuarat_RT::where($where)->first();
                $minit_mesyuarat->mesyuarat_penyata_kewangan        = $request->pmmrt_1_mesyuarat_penyata_kewangan;
                $minit_mesyuarat->mesyuarat_penutup                 = $request->pmmrt_1_mesyuarat_penutup;
                $minit_mesyuarat->mesyuarat_status                  = 3;
                $minit_mesyuarat->direkod_by                        = Auth::user()->user_id;
                $minit_mesyuarat->direkod_date                      = date('Y-m-d H:i:s');
                $minit_mesyuarat->save();
            }
        }
    }
	
	function kembali_penyediaan_minit_mesyuarat_rt(Request $request){
        $app_id = $request->pmmrt_minit_mesyuarat_id;
        $carbon_obj = Carbon::createFromFormat('d/m/Y', $request->pmmrt_mesyuarat_tarikh)->format('Y-m-d');
        $where = array('id' => $app_id);
        $minit_mesyuarat                                    = KRT_Minit_Mesyuarat_RT::where($where)->first();
        $minit_mesyuarat->mesyuarat_title                   = $request->pmmrt_mesyuarat_title;
        $minit_mesyuarat->mesyuarat_tarikh                  = $carbon_obj;
        $minit_mesyuarat->mesyuarat_bil                     = $request->pmmrt_mesyuarat_bil;
        $minit_mesyuarat->mesyuarat_time                    = $request->pmmrt_mesyuarat_time;
        $minit_mesyuarat->mesyuarat_tempat                  = $request->pmmrt_mesyuarat_tempat;
		$minit_mesyuarat->pengerusi			                = $request->pmmrt_pengerusi_mesyuarat;
		$minit_mesyuarat->pencatat			                = $request->pmmrt_catat_mesyuarat;
        $minit_mesyuarat->mesyuarat_perutusan_pengerusi     = $request->pmmrt_mesyuarat_perutusan_pengerusi;
        $minit_mesyuarat->mesyuarat_yang_lalu               = $request->pmmrt_mesyuarat_yang_lalu;
        $minit_mesyuarat->save();
    }
	
	function kembali_penyediaan_minit_mesyuarat_rt_1(Request $request){
        $app_id = $request->pmmrt_1_minit_mesyuarat_id;
        $where = array('id' => $app_id);
        $minit_mesyuarat                                    = KRT_Minit_Mesyuarat_RT::where($where)->first();
        $minit_mesyuarat->mesyuarat_penyata_kewangan        = $request->pmmrt_1_mesyuarat_penyata_kewangan;
        $minit_mesyuarat->mesyuarat_penutup                 = $request->pmmrt_1_mesyuarat_penutup;
        $minit_mesyuarat->mesyuarat_status                  = 2;
        $minit_mesyuarat->direkod_by                        = Auth::user()->user_id;
        $minit_mesyuarat->direkod_date                      = date('Y-m-d H:i:s');
        $minit_mesyuarat->save();
    }

    function pengesahan_minit_mesyuarat_rt(Request $request){
        if($request->ajax()){
            $type           = $request->type;
            $data           = DB::table('krt__minit_mesyuarat')
                            ->select('krt__minit_mesyuarat.id',
                                'krt__profile.krt_nama AS krt_nama',
                                'krt__minit_mesyuarat.mesyuarat_title',
                                DB::raw(" DATE_FORMAT(krt__minit_mesyuarat.mesyuarat_tarikh,'%d/%m/%Y') AS mesyuarat_tarikh"),
								//DB::raw(" REPLACE(REPLACE(krt__minit_mesyuarat.mesyuarat_tempat, '\r', ''), '\n', '<br />') AS mesyuarat_tempat1"),
                                'krt__minit_mesyuarat.mesyuarat_tempat',
                                'ref__status_krt_minit_mesyuarat.status_description',
                                'krt__minit_mesyuarat.mesyuarat_status')
                            ->leftJoin('ref__status_krt_minit_mesyuarat','ref__status_krt_minit_mesyuarat.id','=','krt__minit_mesyuarat.mesyuarat_status')
                            ->leftJoin('krt__profile','krt__profile.id','=','krt__minit_mesyuarat.krt_profile_id')
                            ->orderBy('krt__minit_mesyuarat.id', 'asc')
                            ->where('krt__minit_mesyuarat.mesyuarat_status', '=', 3)
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
							->orderBy('krt__profile.krt_nama', 'asc')
                            ->get();
            return view('rt-sm5.pengesahan-minit-mesyuarat-rt', compact('roles_menu','krt_profile'));
        }
    }

    function pengesahan_minit_mesyuarat_rt_ppd(Request $request, $id){
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
            $pengesahan_minit_mesyuarat     = DB::table('krt__minit_mesyuarat')
                                            ->select('krt__minit_mesyuarat.id',
                                                    'krt__profile.krt_nama AS nama_krt',
                                                    'krt__profile.krt_alamat AS alamat_krt',
                                                    'ref__states.state_description AS negeri_krt',
                                                    'ref__parlimens.parlimen_description AS parlimen_krt',
                                                    'ref__pbts.pbt_description AS pbt_krt',
                                                    'ref__daerahs.daerah_description AS daerah_krt',
                                                    'ref__duns.dun_description AS dun_krt',
                                                    'krt__minit_mesyuarat.mesyuarat_title AS mesyuarat_tajuk',
                                                    DB::raw(" DATE_FORMAT(krt__minit_mesyuarat.mesyuarat_tarikh,'%d/%m/%Y') AS mesyuarat_tarikh"),
                                                    'krt__minit_mesyuarat.mesyuarat_time AS mesyuarat_masa',
													DB::raw(" REPLACE(REPLACE(krt__minit_mesyuarat.mesyuarat_tempat, '\r', ''), '\n', '<br />') AS mesyuarat_tempat"),
                                                    //'krt__minit_mesyuarat.mesyuarat_tempat AS mesyuarat_tempat',
													'krt__minit_mesyuarat.pengerusi AS pengerusi',
													'krt__minit_mesyuarat.pencatat AS pencatat',
													DB::raw(" REPLACE(REPLACE(krt__minit_mesyuarat.mesyuarat_perutusan_pengerusi, '\r', ''), '\n', '<br />') AS mesyuarat_perutusan_pengerusi"),
                                                    //'krt__minit_mesyuarat.mesyuarat_perutusan_pengerusi AS mesyuarat_perutusan_pengerusi',
													DB::raw(" REPLACE(REPLACE(krt__minit_mesyuarat.mesyuarat_yang_lalu, '\r', ''), '\n', '<br />') AS mesyuarat_yang_lalu"),
                                                    'krt__minit_mesyuarat.mesyuarat_yang_lalu AS mesyuarat_yang_lalu1',
													DB::raw(" check_jawatan(krt__minit_mesyuarat_kehadiran.kehadiran_ic,krt__minit_mesyuarat_kehadiran.kehadiran_ic) AS kehadiran_jawatan"),
													DB::raw(" check_kehadiran_nama(krt__minit_mesyuarat.pencatat) AS nama_pencatat"),
													DB::raw(" check_kehadiran_jawatan(krt__minit_mesyuarat.pencatat) AS jawatan_pencatat"),
													'krt__minit_mesyuarat_kehadiran.kehadiran_nama AS kehadiran_nama')
                                            ->leftJoin('krt__profile','krt__profile.id','=','krt__minit_mesyuarat.krt_profile_id')
                                            ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                            ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                            ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                            ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
											->leftJoin('krt__minit_mesyuarat_kehadiran','krt__minit_mesyuarat_kehadiran.id','=','krt__minit_mesyuarat.pengerusi')
                                            ->where('krt__minit_mesyuarat.id', '=', $id)
                                            ->limit(1)
                                            ->first();
            return view('rt-sm5.pengesahan-minit-mesyuarat-rt-ppd', compact('roles_menu','pengesahan_minit_mesyuarat'));
        }
    }

    function pengesahan_minit_mesyuarat_rt_ppd_1(Request $request, $id){
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
            $pengesahan_minit_mesyuarat     = DB::table('krt__minit_mesyuarat')
                                            ->select('krt__minit_mesyuarat.id',
                                                    'krt__profile.krt_nama AS nama_krt',
                                                    'krt__profile.krt_alamat AS alamat_krt',
                                                    'ref__states.state_description AS negeri_krt',
                                                    'ref__parlimens.parlimen_description AS parlimen_krt',
                                                    'ref__pbts.pbt_description AS pbt_krt',
                                                    'ref__daerahs.daerah_description AS daerah_krt',
                                                    'ref__duns.dun_description AS dun_krt',
													DB::raw(" REPLACE(REPLACE(krt__minit_mesyuarat.mesyuarat_penyata_kewangan, '\r', ''), '\n', '<br />') AS mesyuarat_penyata_kewangan"),
                                                    //'krt__minit_mesyuarat.mesyuarat_penyata_kewangan AS mesyuarat_penyata_kewangan',
													DB::raw(" REPLACE(REPLACE(krt__minit_mesyuarat.mesyuarat_penutup, '\r', ''), '\n', '<br />') AS mesyuarat_penutup"),
                                                    'krt__minit_mesyuarat.mesyuarat_penutup AS mesyuarat_penutup1')
                                            ->leftJoin('krt__profile','krt__profile.id','=','krt__minit_mesyuarat.krt_profile_id')
                                            ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                            ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                            ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                            ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                            ->where('krt__minit_mesyuarat.id', '=', $id)
                                            ->limit(1)
                                            ->first();
            return view('rt-sm5.pengesahan-minit-mesyuarat-rt-ppd-1', compact('roles_menu','pengesahan_minit_mesyuarat'));
        }
    }

    function post_pengesahan_minit_mesyuarat(Request $request){
        $action = $request->post_pengesahan_minit_mesyuarat;
        $app_id = $request->pmmrp_1_minit_mesyuarat_id;


        $rules = array(
            'pmmrp_1_mesyuarat_status'             => 'required',
            'pmmrp_1_disemak_note'                 => 'required',
        );

        $messages = [
            'pmmrp_1_mesyuarat_status.required'    => 'Ruangan Status mesti dipilih',
            'pmmrp_1_disemak_note.required'        => 'Ruangan Penerangan mesti diisi',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $pengesahan_minit_mesyuarat                         = KRT_Minit_Mesyuarat_RT::where($where)->first();
                $pengesahan_minit_mesyuarat->mesyuarat_status       = $request->pmmrp_1_mesyuarat_status;
                $pengesahan_minit_mesyuarat->disemak_note           = $request->pmmrp_1_disemak_note;
                $pengesahan_minit_mesyuarat->disemak_by             = Auth::user()->user_id;
                $pengesahan_minit_mesyuarat->disemak_date           = date('Y-m-d H:i:s');
                $pengesahan_minit_mesyuarat->save();
            }
        }
    }

    function paparan_minit_mesyuarat_rt(Request $request){
        if($request->ajax()){
            $type = $request->type;
            $data = DB::table('krt__minit_mesyuarat')
                        ->select('krt__minit_mesyuarat.*',
                                DB::raw(" DATE_FORMAT(krt__minit_mesyuarat.mesyuarat_tarikh,'%d/%m/%Y') AS tarikh_mesyuarat"),
                                'ref__status_krt_minit_mesyuarat.status_description')
                        ->leftJoin('ref__status_krt_minit_mesyuarat','ref__status_krt_minit_mesyuarat.id','=','krt__minit_mesyuarat.mesyuarat_status')
                        ->orderBy('krt__minit_mesyuarat.id', 'asc')
                        ->where('krt__minit_mesyuarat.mesyuarat_status', '=', 1)
                        ->where('krt__minit_mesyuarat.krt_profile_id', '=', Auth::user()->krt_id)
						//->where('krt__minit_mesyuarat.krt_profile_id', '=', 5777)
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
		    $users_role     = DB::table('users')
							-> select ('users.user_role')
							-> where('users.user_id','=',Auth::user()->user_id)
							->limit(1)
                            ->first();
			$krt_profile    = KRT_Profile::where('krt_status', '=', 1)
                            ->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)
                            ->get();
            return view('rt-sm5.paparan-minit-mesyuarat-rt', compact('roles_menu','users_role','krt_profile'));
        }
    }
	
	function paparan_minit_mesyuarat_rt_ppd(Request $request){
        if($request->ajax()){
            $type = $request->type;
            /*$data = DB::table('krt__minit_mesyuarat')
                        ->select('krt__minit_mesyuarat.*',
                                DB::raw(" DATE_FORMAT(krt__minit_mesyuarat.mesyuarat_tarikh,'%d/%m/%Y') AS tarikh_mesyuarat"),
                                'ref__status_krt_minit_mesyuarat.status_description')
                        ->leftJoin('ref__status_krt_minit_mesyuarat','ref__status_krt_minit_mesyuarat.id','=','krt__minit_mesyuarat.mesyuarat_status')
                        ->orderBy('krt__minit_mesyuarat.id', 'asc')
                        ->where('krt__minit_mesyuarat.mesyuarat_status', '=', 1)
                        ->where('krt__minit_mesyuarat.krt_profile_id', '=', Auth::user()->krt_id)
						//->where('krt__minit_mesyuarat.krt_profile_id', '=', 5777)
                        ->get();
                return Datatables::of($data)
                        ->make(true);*/
			$data           = DB::table('krt__minit_mesyuarat')
                            ->select('krt__minit_mesyuarat.id',
                                'krt__profile.krt_nama AS krt_nama',
                                'krt__minit_mesyuarat.mesyuarat_title',
                                DB::raw(" DATE_FORMAT(krt__minit_mesyuarat.mesyuarat_tarikh,'%d/%m/%Y') AS mesyuarat_tarikh"),
								//DB::raw(" REPLACE(REPLACE(krt__minit_mesyuarat.mesyuarat_tempat, '\r', ''), '\n', '<br />') AS mesyuarat_tempat1"),
                                'krt__minit_mesyuarat.mesyuarat_tempat',
                                'ref__status_krt_minit_mesyuarat.status_description',
                                'krt__minit_mesyuarat.mesyuarat_status')
                            ->leftJoin('ref__status_krt_minit_mesyuarat','ref__status_krt_minit_mesyuarat.id','=','krt__minit_mesyuarat.mesyuarat_status')
                            ->leftJoin('krt__profile','krt__profile.id','=','krt__minit_mesyuarat.krt_profile_id')
                            ->orderBy('krt__minit_mesyuarat.id', 'asc')
                            ->where('krt__minit_mesyuarat.mesyuarat_status', '=', 1)
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
		    $users_role     = DB::table('users')
							-> select ('users.user_role')
							-> where('users.user_id','=',Auth::user()->user_id)
							->limit(1)
                            ->first();
			$krt_profile    = KRT_Profile::where('krt_status', '=', 1)
                            ->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)
							->orderBy('krt__profile.krt_nama', 'asc')
                            ->get();
            return view('rt-sm5.paparan-minit-mesyuarat-rt-ppd', compact('roles_menu','users_role','krt_profile'));
        }
    }

    function add_kehadiran_bukanajk(Request $request){
            $action = $request->add_kehadiran_bukanajk;

            $rules = array(
                'kehadiran_nama'                => 'required',
                'kehadiran_ic'              => 'required'
            );

            $messages = [
                'kehadiran_nama.required'       => 'Ruangan nama mesti diisi',
                'kehadiran_ic.required'     => 'Ruangan No.KP mesti diisi',

            ];

            $validator = Validator::make(Input::all(), $rules, $messages);

            if ($validator->fails()) {
                return \Response::json(array('errors' => $validator->errors()->toArray()));
            } else {
                if ($action == 'add') {
                    $kehadiran = new KRT_Minit_Mesyuarat_Kehadiran;
                    $kehadiran->krt_minit_mesyuarat_id      = $request->pmmrt_minit_mesyuarat_id;
                    $kehadiran->kehadiran_nama              = $request->kehadiran_nama;
                    $kehadiran->kehadiran_ic                = $request->kehadiran_ic;
                    $kehadiran->save();
                }
                return \Response::json(array('success' => '1'));
            }

        }

}
