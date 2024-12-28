<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect, Response;
use Auth;
use Validator;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\RefPenggal;
use App\RefStates;
use App\RefDaerah;
use App\RefParlimen;
use App\RefDUN;
use App\RefJantina;
use App\RefKaum;
use App\Ref_Agama;
use App\Ref_Kelompok_Umur;
use App\RefProfession;
use App\RefPendidikan;
use App\Ref_Jawatan_Ajk_KRT;
use App\User;
use App\UserProfile;
use App\KRT_Profile;
use App\KRT_Ahli_Jawatan_Kuasa;
use App\KRT_Ahli_Jawatan_Kuasa_Luar;
use App\KRT_Ahli_Jawatan_Kuasa_Pendidikan;
use App\KRT_Ahli_Jawatan_Kuasa_Pekerjaan;

use DataTables;
use DB;

class RT_SM4Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    function pendaftaran_ahli_krt_utama(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__ahli_jawatan_kuasa')
                        ->select('krt__ahli_jawatan_kuasa.id',
								'ref__penggal.penggal_mula AS penggal_mula',
								'ref__penggal.penggal_tamat AS penggal_tamat',
								'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
								'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
								'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
								'krt__ahli_jawatan_kuasa.ajk_phone AS ajk_phone',
								'krt__ahli_jawatan_kuasa.ajk_status AS ajk_status',
								'krt__ahli_jawatan_kuasa.ajk_status_form AS ajk_status_form',
                                'ref__status_krt_ajk.status_description',
                                'ref__kaum.kaum_description AS kaum_description',
                                'ref__jantina.jantina_description AS jantina_description')
                        ->leftJoin('ref__status_krt_ajk','ref__status_krt_ajk.id','=','krt__ahli_jawatan_kuasa.ajk_status_form')
                        ->leftJoin('ref__kaum','ref__kaum.id','=','krt__ahli_jawatan_kuasa.ajk_kaum')
                        ->leftJoin('ref__jantina','ref__jantina.id','=','krt__ahli_jawatan_kuasa.ajk_jantina')
						->leftJoin('ref__penggal','ref__penggal.id','=','krt__ahli_jawatan_kuasa.ajk_penggal')
                        ->where('krt__ahli_jawatan_kuasa.krt_profile_id', '=', Auth::user()->krt_id)
                        ->whereIN('krt__ahli_jawatan_kuasa.ajk_status_form', [3,4,6])
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
            $user_profile   = DB::table('users__profile')
                            ->select('users__profile.user_id',
                                    'krt__profile.id AS krt_id')
                            ->leftJoin('krt__profile','krt__profile.id','=','users__profile.krt_id')
                            ->where('users__profile.user_id', '=', Auth::user()->user_id)  
                            ->limit(1)
                            ->first();
			$penggal	= DB::table('ref__penggal')
						  ->select('id','penggal_mula','penggal_tamat')
						  ->orderBy('penggal_mula','asc')
						  ->get();
            return view('rt-sm4.pendaftaran-ahli-krt-utama', compact('roles_menu','user_profile','penggal'));
        }
    }

    function post_daftar_ahli_krt(Request $request){
        
        $action = $request->daftar_ajk;
        $app_id = $request->krt_id;
        
        $rules = array(
           
        );

        $messages = [
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm4.pendaftaran_ahli_krt_utama',$app_id))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'add') {
                $ajk_krt = new KRT_Ahli_Jawatan_Kuasa;
                $ajk_krt->krt_profile_id       = $request->krt_id;
                $ajk_krt->ajk_status_form      = 3;
                $ajk_krt->save();
            }
           
            return Redirect::to(route('rt-sm4.borang_pendaftaran_eIDRT',$ajk_krt->id));
        }

    }

    function borang_pendaftaran_eIDRT(Request $request, $id){
        if($request->ajax()){ 
             
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
            $ref_jantina        = RefJantina::where('status', '=', true)->get();
            $ref_kaum           = RefKaum::where('status', '=', true)->get();
            $ref_profession     = RefProfession::where('status', '=', true)->get();
            $ref_pendidikan     = RefPendidikan::where('pendidikan_status', '=', true)->get();
            $ref_jawatan_krt    = Ref_Jawatan_Ajk_KRT::where('jawatan_status', '=', true)->get();
            $ref_agama          = Ref_Agama::where('status', '=', true)->get();
            $ref_kelompok_umur  = Ref_Kelompok_Umur::where('status', '=', true)->get();
			$ref_penggal        = RefPenggal::where('status', '=', true)->get();
            $krt_profile        = DB::table('users__profile')
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
            $krt_ajk            = KRT_Ahli_Jawatan_Kuasa::whereIN('ajk_status_form', [3,6])
                                ->select('krt__ahli_jawatan_kuasa.ajk_penggal','krt__ahli_jawatan_kuasa.id',
                                        'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                                        'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                        DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa.ajk_tarikh_lahir,'%d/%m/%Y') AS ajk_tarikh_lahir"),
                                        'krt__ahli_jawatan_kuasa.ajk_kaum AS ajk_kaum',
                                        'krt__ahli_jawatan_kuasa.ajk_kelompok_umur AS ajk_kelompok_umur',
                                        'krt__ahli_jawatan_kuasa.ajk_jantina AS ajk_jantina',
                                        'krt__ahli_jawatan_kuasa.ajk_warganegara AS ajk_warganegara',
                                        'krt__ahli_jawatan_kuasa.ajk_agama AS ajk_agama',
                                        'krt__ahli_jawatan_kuasa.ajk_phone AS ajk_phone',
                                        'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
                                        'krt__ahli_jawatan_kuasa.ajk_poskod AS ajk_poskod',
                                        'krt__ahli_jawatan_kuasa.ajk_profession_id AS ajk_profession_id',
                                        'krt__ahli_jawatan_kuasa.ajk_pendidikan_id AS ajk_pendidikan_id',
                                        'krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS ajk_jawatan_krt_id',
                                        DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa.ajk_tarikh_mula,'%d/%m/%Y') AS ajk_tarikh_mula"),
                                        DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa.ajk_tarikh_akhir,'%d/%m/%Y') AS ajk_tarikh_akhir"),
                                        'krt__ahli_jawatan_kuasa.ajk_status AS ajk_status',
                                        'krt__ahli_jawatan_kuasa.ajk_status_form AS ajk_status_form',
                                        'krt__ahli_jawatan_kuasa.direkodby_user_id AS direkodby_user_id',
                                        'krt__ahli_jawatan_kuasa.direkod_date AS direkod_date',
                                        'krt__ahli_jawatan_kuasa.disahkan_by AS disahkan_by',
                                        'krt__ahli_jawatan_kuasa.disahkan_date AS disahkan_date',
                                        'krt__ahli_jawatan_kuasa.disahkan_note AS disahkan_note',
                                        'ref__status_krt_ajk.status_description AS status_description',
                                        'krt__ahli_jawatan_kuasa.ajk_bekepentingan AS ajk_bekepentingan',
                                        'krt__ahli_jawatan_kuasa.ajk_bekepentingan_interaksi_1 AS ajk_bekepentingan_interaksi_1',
                                        'krt__ahli_jawatan_kuasa.ajk_bekepentingan_interaksi_2 AS ajk_bekepentingan_interaksi_2',
                                        'krt__ahli_jawatan_kuasa.ajk_bekepentingan_interaksi_3 AS ajk_bekepentingan_interaksi_3',
                                        'krt__ahli_jawatan_kuasa.ajk_bekepentingan_interaksi_4 AS ajk_bekepentingan_interaksi_4',
                                        'krt__ahli_jawatan_kuasa.ajk_bekepentingan_interaksi_5 AS ajk_bekepentingan_interaksi_5',
                                        'krt__ahli_jawatan_kuasa.ajk_berkepentingan_keterangan AS ajk_berkepentingan_keterangan',
                                        'krt__ahli_jawatan_kuasa.file_avatar AS file_avatar')
                                ->leftJoin('ref__status_krt_ajk','ref__status_krt_ajk.id','=','krt__ahli_jawatan_kuasa.ajk_status_form')
                                ->where('krt__ahli_jawatan_kuasa.id', '=', $id)
                                ->limit(1)
                                ->first();
            return view('rt-sm4.borang-pendaftaran-eIDRT', 
            compact('roles_menu','ref_jantina','ref_kaum','ref_profession', 'ref_pendidikan', 'ref_jawatan_krt', 'krt_profile','krt_ajk', 'ref_agama','ref_kelompok_umur','ref_penggal'));
        }
    }

    function post_add_gambar(Request $request){
        $action = $request->post_add_gambar;
        $app_id = $request->mag_krt_ajk_krt_id;
        
        $rules = array(
            'mag_file_avatar'                => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:5000'
        );

        $messages = [
            'mag_file_avatar.required'      => 'Ruangan Fail Mesti Dipilih',
            'mag_file_avatar.mimes'         => 'Fail Mesti Dipilih Dalam Format jpeg,png,jpg,gif,svg,pdf',
            'mag_file_avatar.max'           => 'Fail mesti dalam sive 5000KB',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            $fileName = $request->mag_file_avatar->getClientOriginalName();
            $request->mag_file_avatar->storeAs('public/ajk_krt',$fileName);
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $gambar_ajk_krt                     = KRT_Ahli_Jawatan_Kuasa::where($where)->first();
                $gambar_ajk_krt->file_avatar        = $fileName;
                $gambar_ajk_krt->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function post_pendaftaran_ahli_krt(Request $request){
        $action = $request->post_pendaftaran_ahli_krt;
        $app_id = $request->bpe_ajk_id;
        $ajk_berkepentingan = $request->bpe_ajk_bekepentingan;
        $ajk_status = $request->bpe_ajk_status;
		$ajk_penggal = $request->bpe_ajk_penggal;
        
        $rules_main = array(
            'bpe_ajk_nama'                  => 'required',
            'bpe_ajk_tarikh_lahir'          => 'required',
            'bpe_ajk_kaum'                  => 'required',
            'bpe_ajk_k_umur'                => 'required',
            'bpe_ajk_jantina'               => 'required',
            'bpe_ajk_warganegara'           => 'required',
            'bpe_ajk_agama'                 => 'required',
            'bpe_ajk_phone'                 => 'required',
            'bpe_ajk_ic'                    => 'required',
            'bpe_ajk_alamat'                => 'required',
            'bpe_ajk_poskod'                => 'required',
            'bpe_ajk_profession_id'         => 'required',
            'bpe_ajk_pendidikan_id'         => 'required',
            'bpe_ajk_jawatan_krt_id'        => 'required',
            'bpe_ajk_tarikh_mula'           => 'required',
            'bpe_ajk_tarikh_akhir'          => 'required',
        );

        if ($ajk_berkepentingan == '1') 
		{
            $rules_rule_1 = array(                
                'bpe_ajk_berkepentingan_keterangan'      => 'required',
            );
        }else if ($ajk_status == '6') 
		{
            $rules_rule_1 = array(                
                'bpe_ajk_ic'                    => 'required|min:11|unique:krt__ahli_jawatan_kuasa,ajk_ic',
            );
        }else
		{
			$rules_rule_1 = array(                
            );
		}

        $messages = [
            'bpe_ajk_nama.required'                         => 'Ruangan Nama Penuh mesti diisi',
            'bpe_ajk_tarikh_lahir.required'                 => 'Ruangan Tarikh Lahir mesti dipilih',
            'bpe_ajk_kaum.required'                         => 'Ruangan Kaum mesti dipilih',
            'bpe_ajk_k_umur.required'                       => 'Ruangan Kelompok Umur mesti dipilih',
            'bpe_ajk_jantina.required'                      => 'Ruangan Jantina mesti dipilih',
            'bpe_ajk_warganegara.required'                  => 'Ruangan Warganegara mesti diisi',
            'bpe_ajk_agama.required'                        => 'Ruangan Agama mesti diisi',
            'bpe_ajk_phone.required'                        => 'Ruangan No Telefon mesti diisi',
            'bpe_ajk_ic.required'                           => 'Ruangan No Kad Pengenalan mesti diisi',
            'bpe_ajk_ic.unique'                             => 'No kad pengenalan telah wujud di dalam pangkalan data.',
            'bpe_ajk_alamat.required'                       => 'Ruangan Alamat mesti diisi',
            'bpe_ajk_poskod.required'                       => 'Ruangan Poskod mesti diisi',
            'bpe_ajk_profession_id.required'                => 'Ruangan Pekerjaan mesti dipilih',
            'bpe_ajk_pendidikan_id.required'                => 'Ruangan Pendidikan mesti dipilih',
            'bpe_ajk_jawatan_krt_id.required'               => 'Ruangan Jawatan mesti dipilih',
            'bpe_ajk_tarikh_mula.required'                  => 'Ruangan Tarikh Mula mesti dipilih',
            'bpe_ajk_tarikh_akhir.required'                 => 'Ruangan Tarikh Akhir mesti dipilih',
            'bpe_ajk_berkepentingan_keterangan.required'    => 'Ruangan Keterangan lanjut mengenai kepentingan interaksi sosial diatas mesti diisi'
        ];
        
        $rules = $rules_main + $rules_rule_1;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') 
			{
				$whereaktif = array('ajk_ic'=>$request->bpe_ajk_ic, 'ajk_status'=>1);
				$aktif_exist = KRT_Ahli_Jawatan_Kuasa::where($whereaktif)->first();
				if(is_null($aktif_exist))
				{
					$whereexist = array('ajk_ic'=>$request->bpe_ajk_ic, 'ajk_penggal'=>$request->bpe_ajk_penggal, 'ajk_status_form'=>5);
					$penggal_exist = KRT_Ahli_Jawatan_Kuasa::where($whereexist)->first();
					if(is_null($penggal_exist))
					{
							$where = array('id' => $app_id);
							$carbon_obj = Carbon::createFromFormat('d/m/Y', $request->bpe_ajk_tarikh_lahir)->format('Y-m-d');
							$carbon_obj_1 = Carbon::createFromFormat('d/m/Y', $request->bpe_ajk_tarikh_mula)->format('Y-m-d');
							$carbon_obj_2 = Carbon::createFromFormat('d/m/Y', $request->bpe_ajk_tarikh_akhir)->format('Y-m-d');
							$daftar_ahli_krt                         = KRT_Ahli_Jawatan_Kuasa::where($where)->first();
							$daftar_ahli_krt->ajk_nama               = $request->bpe_ajk_nama;
							$daftar_ahli_krt->ajk_ic                 = $request->bpe_ajk_ic;
							$daftar_ahli_krt->ajk_penggal			 = $request->bpe_ajk_penggal;
							$daftar_ahli_krt->ajk_tarikh_lahir       = $carbon_obj;
							$daftar_ahli_krt->ajk_kaum               = $request->bpe_ajk_kaum;
							$daftar_ahli_krt->ajk_kelompok_umur      = $request->bpe_ajk_k_umur;
							$daftar_ahli_krt->ajk_jantina            = $request->bpe_ajk_jantina;
							$daftar_ahli_krt->ajk_warganegara        = $request->bpe_ajk_warganegara;
							$daftar_ahli_krt->ajk_agama              = $request->bpe_ajk_agama;
							$daftar_ahli_krt->ajk_phone              = $request->bpe_ajk_phone;
							$daftar_ahli_krt->ajk_alamat             = $request->bpe_ajk_alamat;
							$daftar_ahli_krt->ajk_poskod             = $request->bpe_ajk_poskod;
							$daftar_ahli_krt->ajk_profession_id      = $request->bpe_ajk_profession_id;
							$daftar_ahli_krt->ajk_pendidikan_id      = $request->bpe_ajk_pendidikan_id;
							$daftar_ahli_krt->ajk_jawatan_krt_id     = $request->bpe_ajk_jawatan_krt_id;
							$daftar_ahli_krt->ajk_tarikh_mula        = $carbon_obj_1;
							$daftar_ahli_krt->ajk_tarikh_akhir       = $carbon_obj_2;
							$daftar_ahli_krt->ajk_status_form        = $request->bpe_ajk_status_form;
							$daftar_ahli_krt->direkodby_user_id      = Auth::user()->user_id;
							$daftar_ahli_krt->direkod_date           = date('Y-m-d H:i:s');
							$daftar_ahli_krt->file_avatar			 = $request->imgfilename;
							$daftar_ahli_krt->save();
							
							if($ajk_berkepentingan == '1')
							{
								$where1 = array('id' => $app_id);
								$daftar_ahli_krt                                    = KRT_Ahli_Jawatan_Kuasa::where($where1)->first();
								$daftar_ahli_krt->ajk_bekepentingan                 = $ajk_berkepentingan;
								$daftar_ahli_krt->ajk_bekepentingan_interaksi_1     = $request->bpe_ajk_bekepentingan_interaksi_1;
								$daftar_ahli_krt->ajk_bekepentingan_interaksi_2     = $request->bpe_ajk_bekepentingan_interaksi_2;
								$daftar_ahli_krt->ajk_bekepentingan_interaksi_3     = $request->bpe_ajk_bekepentingan_interaksi_3;
								$daftar_ahli_krt->ajk_bekepentingan_interaksi_4     = $request->bpe_ajk_bekepentingan_interaksi_4;
								$daftar_ahli_krt->ajk_bekepentingan_interaksi_5     = $request->bpe_ajk_bekepentingan_interaksi_5;
								$daftar_ahli_krt->ajk_berkepentingan_keterangan     = $request->bpe_ajk_berkepentingan_keterangan;
								$daftar_ahli_krt->save();
			
							}  
					}else
					{
						return \Response::json(array('errors' => 1));
					}
				}else
				{
					return \Response::json(array('errors' => 2));
				}
			}
        }
    }

    function pengesahan_ahli_krt_utama(Request $request){
        if($request->ajax()){ 
			$krtid = 2298;
			if($request->pbpe_krt_id === null)
			{
				$type = $request->type;
				$data = DB::table('krt__ahli_jawatan_kuasa')
							->select('krt__ahli_jawatan_kuasa.id',
									'krt__profile.krt_nama AS krt_nama',
									'ref__penggal.penggal_mula AS penggal_mula',
									'ref__penggal.penggal_tamat AS penggal_tamat',
									'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
									'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
									'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
									'ref__jawatan_ajk_krt.jawatan_description AS ajk_jawatan_desc',
									'ref__status_krt_ajk.status_description AS ajk_status_form_description',
									'krt__profile.daerah_id AS daerah_id',
									'krt__ahli_jawatan_kuasa.ajk_status_form AS ajk_status_form')
							->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
							->leftJoin('ref__status_krt_ajk','ref__status_krt_ajk.id','=','krt__ahli_jawatan_kuasa.ajk_status_form')
							->leftJoin('ref__jawatan_ajk_krt','ref__jawatan_ajk_krt.id','=','krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
							->leftJoin('ref__penggal','ref__penggal.id','=','krt__ahli_jawatan_kuasa.ajk_penggal')
							->where('krt__ahli_jawatan_kuasa.ajk_status_form', '=', 4)
							->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)
							->get();
			}else
			{
				$type = $request->type;
				$data = DB::table('krt__ahli_jawatan_kuasa')
							->select('krt__ahli_jawatan_kuasa.id',
									'krt__profile.krt_nama AS krt_nama',
									'ref__penggal.penggal_mula AS penggal_mula',
									'ref__penggal.penggal_tamat AS penggal_tamat',
									'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
									'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
									'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
									'ref__jawatan_ajk_krt.jawatan_description AS ajk_jawatan_desc',
									'ref__status_krt_ajk.status_description AS ajk_status_form_description',
									'krt__profile.daerah_id AS daerah_id',
									'krt__ahli_jawatan_kuasa.ajk_status_form AS ajk_status_form')
							->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
							->leftJoin('ref__status_krt_ajk','ref__status_krt_ajk.id','=','krt__ahli_jawatan_kuasa.ajk_status_form')
							->leftJoin('ref__jawatan_ajk_krt','ref__jawatan_ajk_krt.id','=','krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
							->leftJoin('ref__penggal','ref__penggal.id','=','krt__ahli_jawatan_kuasa.ajk_penggal')
							->where('krt__ahli_jawatan_kuasa.ajk_status_form', '=', 4)
							->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)
							->where('krt__profile.id','=',2298)
							->get();
			}
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
            $krt        = KRT_Profile::where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)
                        ->where('krt__profile.krt_status', '=', 1)
						->orderBy('krt_nama','asc')
                        ->get();
			$penggal	= DB::table('ref__penggal')
						  ->select('id','penggal_mula','penggal_tamat')
						  ->orderBy('penggal_mula','asc')
						  ->get();
            return view('rt-sm4.pengesahan-ahli-krt-utama',compact('roles_menu','krt','penggal'));
        }
    }

    function pengesahan_borang_pendaftaran_eIDRT(Request $request, $id){
        if($request->ajax()){ 
             
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
            $ref_jantina        = RefJantina::where('status', '=', true)->get();
            $ref_kaum           = RefKaum::where('status', '=', true)->get();
            $ref_profession     = RefProfession::where('status', '=', true)->get();
            $ref_pendidikan     = RefPendidikan::where('pendidikan_status', '=', true)->get();
            $ref_jawatan_krt    = Ref_Jawatan_Ajk_KRT::where('jawatan_status', '=', true)->get();
            $ref_agama          = Ref_Agama::where('status', '=', true)->get();
            $ref_kelompok_umur  = Ref_Kelompok_Umur::where('status', '=', true)->get();
            $krt_ajk            = KRT_Ahli_Jawatan_Kuasa::where('ajk_status_form', '=', 4)
                                ->select('krt__ahli_jawatan_kuasa.id',
									'ref__penggal.penggal_mula AS penggal_mula',
									'ref__penggal.penggal_tamat AS penggal_tamat',
                                    'krt__profile.krt_nama AS krt_nama',
									'krt__profile.id AS krt_id',
                                    'krt__profile.krt_alamat AS krt_alamat',
                                    'ref__states.state_description AS krt_negeri',
                                    'ref__parlimens.parlimen_description AS krt_parlimen',
                                    'ref__pbts.pbt_description AS krt_pbt',
                                    'ref__daerahs.daerah_description AS krt_daerah',
                                    'ref__duns.dun_description AS krt_dun',
                                    'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                                    'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                    'krt__ahli_jawatan_kuasa.ajk_jantina AS ajk_jantina',
                                    'krt__ahli_jawatan_kuasa.ajk_warganegara AS ajk_warganegara',
                                    'krt__ahli_jawatan_kuasa.ajk_agama AS ajk_agama',
                                    DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa.ajk_tarikh_lahir,'%d/%m/%Y') AS ajk_tarikh_lahir"),
                                    'krt__ahli_jawatan_kuasa.ajk_kaum AS ajk_kaum',
                                    'krt__ahli_jawatan_kuasa.ajk_kelompok_umur AS ajk_kelompok_umur',
                                    'krt__ahli_jawatan_kuasa.ajk_phone AS ajk_phone',
                                    'krt__ahli_jawatan_kuasa.ajk_poskod AS ajk_poskod',
                                    'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
                                    'krt__ahli_jawatan_kuasa.ajk_pendidikan_id AS ajk_pendidikan_id',
                                    'krt__ahli_jawatan_kuasa.ajk_profession_id AS ajk_profession_id',
                                    'krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS ajk_jawatan_krt_id',
                                    DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa.ajk_tarikh_mula,'%d/%m/%Y') AS ajk_tarikh_mula"),
                                    DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa.ajk_tarikh_akhir,'%d/%m/%Y') AS ajk_tarikh_akhir"),
                                    'ref__jawatan_ajk_krt.jawatan_description AS ajk_jawatan_desc',
                                    'ref__status_krt_ajk.status_description AS ajk_status_form_description',
                                    'krt__profile.daerah_id AS daerah_id',
                                    'krt__ahli_jawatan_kuasa.ajk_status_form AS ajk_status_form',
                                    'krt__ahli_jawatan_kuasa.ajk_bekepentingan AS ajk_bekepentingan',
                                    'krt__ahli_jawatan_kuasa.ajk_bekepentingan_interaksi_1 AS ajk_bekepentingan_interaksi_1',
                                    'krt__ahli_jawatan_kuasa.ajk_bekepentingan_interaksi_2 AS ajk_bekepentingan_interaksi_2',
                                    'krt__ahli_jawatan_kuasa.ajk_bekepentingan_interaksi_3 AS ajk_bekepentingan_interaksi_3',
                                    'krt__ahli_jawatan_kuasa.ajk_bekepentingan_interaksi_4 AS ajk_bekepentingan_interaksi_4',
                                    'krt__ahli_jawatan_kuasa.ajk_bekepentingan_interaksi_5 AS ajk_bekepentingan_interaksi_5',
                                    'krt__ahli_jawatan_kuasa.ajk_berkepentingan_keterangan AS ajk_berkepentingan_keterangan',
                                    'krt__ahli_jawatan_kuasa.file_avatar AS file_avatar')
                                ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
                                ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                ->leftJoin('ref__status_krt_ajk','ref__status_krt_ajk.id','=','krt__ahli_jawatan_kuasa.ajk_status_form')
                                ->leftJoin('ref__jawatan_ajk_krt','ref__jawatan_ajk_krt.id','=','krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
								->leftJoin('ref__penggal','ref__penggal.id','=','krt__ahli_jawatan_kuasa.ajk_penggal')
                                ->where('krt__ahli_jawatan_kuasa.id', '=', $id)
                                ->limit(1)
                                ->first();
            return view('rt-sm4.pengesahan-borang-pendaftaran-eIDRT', 
            compact('roles_menu','ref_jantina','ref_kaum','ref_profession', 'ref_pendidikan', 'ref_jawatan_krt', 'krt_ajk', 'ref_agama', 'ref_kelompok_umur'));
        }
    }

    function post_pengesahan_ahli_krt(Request $request){
        $action = $request->post_pengesahan_ahli_krt;
        $app_id = $request->pbpe_ajk_krt_id;
        $status = $request->pbpe_ajk_status_form;
        
        $rules = array(
            'pbpe_ajk_status_form'            => 'required',
            'pbpe_disahkan_note'              => 'required',
        );

        $messages = [
            'pbpe_ajk_status_form.required'   => 'Ruangan Status mesti dipilih',
            'pbpe_disahkan_note.required'     => 'Ruangan Penerangan mesti diisi'
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $pengesahan_ahli_krt                         = KRT_Ahli_Jawatan_Kuasa::where($where)->first();
                $pengesahan_ahli_krt->ajk_status_form        = $request->pbpe_ajk_status_form;
                $pengesahan_ahli_krt->disahkan_note          = $request->pbpe_disahkan_note;
                $pengesahan_ahli_krt->disahkan_by            = Auth::user()->user_id;
                $pengesahan_ahli_krt->disahkan_date          = date('Y-m-d H:i:s');
                
                $pengesahan_ahli_krt->save();

                if($status == '5'){
                    $where1 = array('id' => $app_id);
                    $pengesahan_ahli_krt                     = KRT_Ahli_Jawatan_Kuasa::where($where1)->first();
                    $pengesahan_ahli_krt->ajk_status         = 1;
                    $pengesahan_ahli_krt->save();

                }  
            }
        }
    }

    function cadangan_ajk_kepentingan_krt(Request $request){

        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__ahli_jawatan_kuasa_luar')
                        ->select('krt__ahli_jawatan_kuasa_luar.id',
                                'krt__ahli_jawatan_kuasa_luar.ajk_luar_nama AS ajk_luar_nama',
                                'krt__ahli_jawatan_kuasa_luar.ajk_luar_ic AS ajk_luar_ic',
                                'krt__ahli_jawatan_kuasa_luar.ajk_luar_alamat AS ajk_luar_alamat',
                                'krt__ahli_jawatan_kuasa_luar.ajk_luar_status AS ajk_luar_status',
                                'ref__status_krt_ajk_luar.status_description AS status')
                        ->leftJoin('ref__status_krt_ajk_luar','ref__status_krt_ajk_luar.id','=','krt__ahli_jawatan_kuasa_luar.ajk_luar_status')
                        ->where('krt__ahli_jawatan_kuasa_luar.krt_profile_id', '=', Auth::user()->krt_id)
                        ->get();
                return Datatables::of($data)
                        ->make(true);
        } else {
            
            return view('rt-sm4.cadangan-ajk-kepentingan-krt');
        }
    }

    function borang_pendaftaran_rt_b1(Request $request){
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
                                'krt__profile.id AS krt_id',
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
            return view('rt-sm4.borang-pendaftaran-rt-b1', compact('roles_menu','krt_profile'));
        }
    }

    function post_borang_rt_b1(Request $request){
        $action = $request->post_borang_rt_b1;
        
        $rules = array(
            'bprb_ajk_luar_nama'              => 'required',
            'bprb_ajk_luar_ic'                => 'required',
            'bprb_ajk_luar_alamat'            => 'required',
            'bprb_ajk_luar_note'              => 'required',
            
        );

        $messages = [
            'bprb_ajk_luar_nama.required'     => 'Ruangan Nama Penuh mesti diisi',
            'bprb_ajk_luar_ic.required'       => 'Ruangan No Kad Pengenalan mesti diisi',
            'bprb_ajk_luar_alamat.required'   => 'Ruangan Alamat mesti diisi',
            'bprb_ajk_luar_note.required'     => 'Ruangan Keterangan lanjut mengenai kepentingan interaksi sosial diatas mesti diisi'
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $cadangan_ajk_kepentingan_krt = new KRT_Ahli_Jawatan_Kuasa_Luar;
                $cadangan_ajk_kepentingan_krt->krt_profile_id                  = $request->bprb_krt_profile_id;
                $cadangan_ajk_kepentingan_krt->ajk_luar_nama                   = $request->bprb_ajk_luar_nama;
                $cadangan_ajk_kepentingan_krt->ajk_luar_ic                     = $request->bprb_ajk_luar_ic;
                $cadangan_ajk_kepentingan_krt->ajk_luar_alamat                 = $request->bprb_ajk_luar_alamat;
                $cadangan_ajk_kepentingan_krt->ajk_luar_miliki_perniagaan      = $request->bprb_ajk_luar_miliki_perniagaan;
                $cadangan_ajk_kepentingan_krt->ajk_luar_miliki_keluarga        = $request->bprb_ajk_luar_miliki_keluarga;
                $cadangan_ajk_kepentingan_krt->ajk_luar_miliki_pekerjaan       = $request->bprb_ajk_luar_miliki_pekerjaan;
                $cadangan_ajk_kepentingan_krt->ajk_luar_miliki_jawatan         = $request->bprb_ajk_luar_miliki_jawatan;
                $cadangan_ajk_kepentingan_krt->ajk_luar_miliki_kepentingan     = $request->bprb_ajk_luar_miliki_kepentingan;
                $cadangan_ajk_kepentingan_krt->ajk_luar_note                   = $request->bprb_ajk_luar_note;
                $cadangan_ajk_kepentingan_krt->ajk_luar_status                 = 1;
                $cadangan_ajk_kepentingan_krt->save();
            }
        }
    }

    function pengesahan_cadangan_ajk_kepentingan_krt_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__ahli_jawatan_kuasa_luar')
                        ->select('krt__ahli_jawatan_kuasa_luar.id',
                                'krt__ahli_jawatan_kuasa_luar.krt_profile_id AS krt_id',
                                'krt__profile.krt_nama AS krt_nama',
                                'krt__ahli_jawatan_kuasa_luar.ajk_luar_nama AS ajk_luar_nama',
                                'krt__ahli_jawatan_kuasa_luar.ajk_luar_ic AS ajk_luar_ic',
                                'krt__ahli_jawatan_kuasa_luar.ajk_luar_alamat AS ajk_luar_alamat',
                                'krt__ahli_jawatan_kuasa_luar.ajk_luar_status AS ajk_luar_status',
                                'ref__status_krt_ajk_luar.status_description AS status')
                        ->leftJoin('ref__status_krt_ajk_luar','ref__status_krt_ajk_luar.id','=','krt__ahli_jawatan_kuasa_luar.ajk_luar_status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa_luar.krt_profile_id')
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
            $krt     = KRT_Profile::where('daerah_id', '=', Auth::user()->daerah_id)->get();
            return view('rt-sm4.pengesahan-cadangan-ajk-kepentingan-krt-ppd',compact('roles_menu','krt'));
        }
    }

    function pengesahan_borang_pendaftaran_rt_b1(Request $request, $id){
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
            $cadangan_ajk_berkepentingan        = DB::table('krt__ahli_jawatan_kuasa_luar')
                                                ->select('krt__ahli_jawatan_kuasa_luar.id',
                                                        'krt__profile.krt_nama AS nama_krt',
                                                        'krt__profile.krt_alamat AS alamat_krt', 
                                                        'ref__states.state_description AS negeri_krt', 
                                                        'ref__daerahs.daerah_description AS daerah_krt',
                                                        'ref__parlimens.parlimen_description AS parlimen_krt',
                                                        'ref__duns.dun_description AS dun_krt',
                                                        'ref__pbts.pbt_description AS pbt_krt',
                                                        'krt__ahli_jawatan_kuasa_luar.ajk_luar_nama AS ajk_luar_nama',
                                                        'krt__ahli_jawatan_kuasa_luar.ajk_luar_ic AS ajk_luar_ic',
                                                        'krt__ahli_jawatan_kuasa_luar.ajk_luar_alamat AS ajk_luar_alamat',
                                                        'krt__ahli_jawatan_kuasa_luar.ajk_luar_miliki_perniagaan AS ajk_luar_miliki_perniagaan',
                                                        'krt__ahli_jawatan_kuasa_luar.ajk_luar_miliki_keluarga AS ajk_luar_miliki_keluarga',
                                                        'krt__ahli_jawatan_kuasa_luar.ajk_luar_miliki_pekerjaan AS ajk_luar_miliki_pekerjaan',
                                                        'krt__ahli_jawatan_kuasa_luar.ajk_luar_miliki_jawatan AS ajk_luar_miliki_jawatan',
                                                        'krt__ahli_jawatan_kuasa_luar.ajk_luar_miliki_kepentingan AS ajk_luar_miliki_kepentingan',
                                                        'krt__ahli_jawatan_kuasa_luar.ajk_luar_note AS ajk_luar_note')
                                                ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa_luar.krt_profile_id')
                                                ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                                ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                                ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                                ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                                ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                                ->where('krt__ahli_jawatan_kuasa_luar.id', '=', $id)  
                                                ->limit(1)
                                                ->first();
            return view('rt-sm4.pengesahan-borang-pendaftaran-rt-b1', compact('roles_menu','cadangan_ajk_berkepentingan'));
        }
    }

    function post_pengesahan_borang_rt_b1(Request $request){
        $action = $request->post_pengesahan_borang_rt_b1;
        $app_id = $request->pbprb_ajk_luar_id;
        
        $rules = array(
            'pbprb_ajk_luar_status'            => 'required',
            'pbprb_disahkan_note'              => 'required',
        );

        $messages = [
            'pbprb_ajk_luar_status.required'   => 'Ruangan Status mesti dipilih',
            'pbprb_disahkan_note.required'     => 'Ruangan Penerangan mesti diisi'
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $pengesahan_cadangan_ajk                         = KRT_Ahli_Jawatan_Kuasa_Luar::where($where)->first();
                $pengesahan_cadangan_ajk->ajk_luar_status        = $request->pbprb_ajk_luar_status;
                $pengesahan_cadangan_ajk->disahkan_note          = $request->pbprb_disahkan_note;
                $pengesahan_cadangan_ajk->disahkan_by            = Auth::user()->user_id;
                $pengesahan_cadangan_ajk->disahkan_date          = date('Y-m-d H:i:s');
                $pengesahan_cadangan_ajk->save();
            }
        }
    }

    function senarai_ajk_krt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__ahli_jawatan_kuasa')
                        ->select('krt__ahli_jawatan_kuasa.id',
								'krt__ahli_jawatan_kuasa.ajk_penggal AS ajk_penggal',
								'ref__penggal.penggal_mula AS penggal_mula',
								'ref__penggal.penggal_tamat AS penggal_tamat',
                                'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
                                'ref__jawatan_ajk_krt.jawatan_description AS ajk_jawatan',
                                'ref__status_krt_ajk.status_description AS ajk_status',
                                DB::raw(" DATEDIFF( NOW(), krt__ahli_jawatan_kuasa.ajk_tarikh_mula) AS ajk_status_pelantikan"),
                                DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa.ajk_tarikh_akhir,'%d/%m/%Y') AS ajk_tarikh_akhir"),
                                DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa.ajk_tarikh_mula,'%d/%m/%Y') AS ajk_tarikh_mula"))
                        ->leftJoin('ref__jawatan_ajk_krt','ref__jawatan_ajk_krt.id','=','krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
                        ->leftJoin('ref__status_krt_ajk','ref__status_krt_ajk.id','=','krt__ahli_jawatan_kuasa.ajk_status')
						->leftJoin('ref__penggal','ref__penggal.id','=','krt__ahli_jawatan_kuasa.ajk_penggal')
                        ->where('krt__ahli_jawatan_kuasa.krt_profile_id', '=', Auth::user()->krt_id)
                        ->whereIn('krt__ahli_jawatan_kuasa.ajk_status', [1,2])
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
			$penggal	= DB::table('ref__penggal')
						  ->select('id','penggal_mula','penggal_tamat')
						  ->orderBy('penggal_mula','asc')
						  ->get();
            return view('rt-sm4.senarai-ajk-krt',compact('roles_menu','penggal'));
        }
    }

    function kemaskini_ajk_krt(Request $request, $id){
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
            $ref_jantina        = RefJantina::where('status', '=', true)->get();
            $ref_kaum           = RefKaum::where('status', '=', true)->get();
            $ref_profession     = RefProfession::where('status', '=', true)->get();
            $ref_pendidikan     = RefPendidikan::where('pendidikan_status', '=', true)->get();
            $ref_jawatan_krt    = Ref_Jawatan_Ajk_KRT::where('jawatan_status', '=', true)->get();
            $ref_agama          = Ref_Agama::where('status', '=', true)->get();
            $ref_kelompok_umur  = Ref_Kelompok_Umur::where('status', '=', true)->get();
            $krt_ajk            = KRT_Ahli_Jawatan_Kuasa::where('ajk_status', '=', 1)
                                ->select('krt__ahli_jawatan_kuasa.id',
									'ref__penggal.penggal_mula AS penggal_mula',
									'ref__penggal.penggal_tamat AS penggal_tamat',
                                    'krt__profile.krt_nama AS krt_nama',
                                    'krt__profile.krt_alamat AS krt_alamat',
                                    'ref__states.state_description AS krt_negeri',
                                    'ref__parlimens.parlimen_description AS krt_parlimen',
                                    'ref__pbts.pbt_description AS krt_pbt',
                                    'ref__daerahs.daerah_description AS krt_daerah',
                                    'ref__duns.dun_description AS krt_dun',
                                    'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                                    'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                    'krt__ahli_jawatan_kuasa.ajk_jantina AS ajk_jantina',
                                    'krt__ahli_jawatan_kuasa.ajk_warganegara AS ajk_warganegara',
                                    'krt__ahli_jawatan_kuasa.ajk_agama AS ajk_agama',
                                    DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa.ajk_tarikh_lahir,'%d/%m/%Y') AS ajk_tarikh_lahir"),
                                    'krt__ahli_jawatan_kuasa.ajk_kelompok_umur AS ajk_kelompok_umur',
                                    'krt__ahli_jawatan_kuasa.ajk_kaum AS ajk_kaum',
                                    'krt__ahli_jawatan_kuasa.ajk_phone AS ajk_phone',
                                    'krt__ahli_jawatan_kuasa.ajk_poskod AS ajk_poskod',
                                    'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
                                    'krt__ahli_jawatan_kuasa.ajk_pendidikan_id AS ajk_pendidikan_id',
                                    'krt__ahli_jawatan_kuasa.ajk_profession_id AS ajk_profession_id',
                                    'krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id AS ajk_jawatan_krt_id',
                                    DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa.ajk_tarikh_mula,'%d/%m/%Y') AS ajk_tarikh_mula"),
                                    DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa.ajk_tarikh_akhir,'%d/%m/%Y') AS ajk_tarikh_akhir"),
                                    'ref__jawatan_ajk_krt.jawatan_description AS ajk_jawatan_desc',
                                    'ref__status_krt_ajk.status_description AS ajk_status_form_description',
                                    'krt__profile.daerah_id AS daerah_id',
                                    'krt__ahli_jawatan_kuasa.ajk_status AS ajk_status',
                                    'krt__ahli_jawatan_kuasa.file_avatar AS file_avatar')
                                ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
                                ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                ->leftJoin('ref__status_krt_ajk','ref__status_krt_ajk.id','=','krt__ahli_jawatan_kuasa.ajk_status_form')
                                ->leftJoin('ref__jawatan_ajk_krt','ref__jawatan_ajk_krt.id','=','krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
								->leftJoin('ref__penggal','ref__penggal.id','=','krt__ahli_jawatan_kuasa.ajk_penggal')
                                ->where('krt__ahli_jawatan_kuasa.id', '=', $id)
                                ->limit(1)
                                ->first();
            return view('rt-sm4.kemaskini-ajk-krt', 
            compact('roles_menu','ref_jantina','ref_kaum','ref_profession', 'ref_pendidikan', 'ref_jawatan_krt', 'krt_ajk', 'ref_agama', 'ref_kelompok_umur'));
        }
    }

    function post_edit_gambar(Request $request){
        $action = $request->post_edit_gambar;
        $app_id = $request->meg_krt_ajk_krt_id;
        
        $rules = array(
            'meg_file_avatar'                => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:5000'
        );

        $messages = [
            'meg_file_avatar.required'      => 'Ruangan Fail Mesti Dipilih',
            'meg_file_avatar.mimes'         => 'Fail Mesti Dipilih Dalam Format jpeg,png,jpg,gif,svg,pdf',
            'meg_file_avatar.max'           => 'Fail mesti dalam sive 5000KB',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            $fileName = $request->meg_file_avatar->getClientOriginalName();
            $request->meg_file_avatar->storeAs('public/ajk_krt',$fileName);
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $gambar_ajk_krt                     = KRT_Ahli_Jawatan_Kuasa::where($where)->first();
                $gambar_ajk_krt->file_avatar        = $fileName;
                $gambar_ajk_krt->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function post_kemaskini_ahli_krt(Request $request){
        $action = $request->post_kemaskini_ahli_krt;
        $app_id = $request->kak_ajk_krt_id;
        
        $rules = array(
            'kak_ajk_status'                => 'required',
            'kak_ajk_tarikh_lahir'          => 'required',
            'kak_ajk_k_umur'                => 'required',
            'kak_ajk_kaum'                  => 'required',
            'kak_ajk_agama'                 => 'required',
            'kak_ajk_phone'                 => 'required',
            'kak_ajk_alamat'                => 'required',
            'kak_ajk_poskod'                => 'required',
            'kak_ajk_pendidikan_id'         => 'required',
            'kak_ajk_profession_id'         => 'required',
            'kak_ajk_jawatan_krt_id'        => 'required',
        );

        $messages = [
            'kak_ajk_status.required'         => 'Ruangan Status mesti dipilih',
            'kak_ajk_tarikh_lahir.required'   => 'Ruangan Tarikh Lahir mesti dipilih',
            'kak_ajk_k_umur.required'         => 'Ruangan Kelompok Kaum mesti dipilih',
            'kak_ajk_kaum.required'           => 'Ruangan Kaum mesti dipilih',
            'kak_ajk_agama.required'          => 'Ruangan Agama mesti dipilih',
            'kak_ajk_phone.required'          => 'Ruangan Phone mesti diisi',
            'kak_ajk_alamat.required'         => 'Ruangan Alamat mesti diisi',
            'kak_ajk_poskod.required'         => 'Ruangan Poskod mesti diisi',
            'kak_ajk_pendidikan_id.required'  => 'Ruangan Pendidikan mesti dipilih',
            'kak_ajk_profession_id.required'  => 'Ruangan Pekerjaan mesti dipilih',
            'kak_ajk_jawatan_krt_id.required' => 'Ruangan Jawatan mesti dipilih'
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $carbon_obj = Carbon::createFromFormat('d/m/Y', $request->kak_ajk_tarikh_lahir)->format('Y-m-d');
                $kemaskini_ahli_krt                         = KRT_Ahli_Jawatan_Kuasa::where($where)->first();
                $kemaskini_ahli_krt->ajk_status             = $request->kak_ajk_status;
                $kemaskini_ahli_krt->ajk_tarikh_lahir       = $carbon_obj;
                $kemaskini_ahli_krt->ajk_kelompok_umur      = $request->kak_ajk_k_umur;
                $kemaskini_ahli_krt->ajk_kaum               = $request->kak_ajk_kaum;
                $kemaskini_ahli_krt->ajk_agama              = $request->kak_ajk_agama;
                $kemaskini_ahli_krt->ajk_phone              = $request->kak_ajk_phone;
                $kemaskini_ahli_krt->ajk_alamat             = $request->kak_ajk_alamat;
                $kemaskini_ahli_krt->ajk_poskod             = $request->kak_ajk_poskod;
                $kemaskini_ahli_krt->ajk_pendidikan_id      = $request->kak_ajk_pendidikan_id;
                $kemaskini_ahli_krt->ajk_profession_id      = $request->kak_ajk_profession_id;
                $kemaskini_ahli_krt->ajk_jawatan_krt_id     = $request->kak_ajk_jawatan_krt_id;
                $kemaskini_ahli_krt->save();
            }
        }
    }

    function senarai_ajk_krt_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__ahli_jawatan_kuasa')
                        ->select('krt__ahli_jawatan_kuasa.id',
                                'krt__profile.krt_nama AS krt_nama',
								'ref__penggal.penggal_mula AS penggal_mula',
								'ref__penggal.penggal_tamat AS penggal_tamat',
                                'krt__profile.state_id AS krt_state',
                                'krt__profile.daerah_id AS krt_daerah',
                                'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
                                'ref__jawatan_ajk_krt.jawatan_description AS ajk_jawatan',
                                'ref__status_krt_ajk.status_description AS ajk_status',
                                DB::raw(" DATEDIFF( NOW(), krt__ahli_jawatan_kuasa.ajk_tarikh_mula) AS ajk_status_pelantikan"),
                                DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa.ajk_tarikh_akhir,'%d/%m/%Y') AS ajk_tarikh_akhir"),
                                DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa.ajk_tarikh_mula,'%d/%m/%Y') AS ajk_tarikh_mula"))
                        ->leftJoin('ref__jawatan_ajk_krt','ref__jawatan_ajk_krt.id','=','krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
                        ->leftJoin('ref__status_krt_ajk','ref__status_krt_ajk.id','=','krt__ahli_jawatan_kuasa.ajk_status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
						->leftJoin('ref__penggal','ref__penggal.id','=','krt__ahli_jawatan_kuasa.ajk_penggal')
                        ->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)
                        ->where('krt__ahli_jawatan_kuasa.ajk_status', '=', 1)
                        ->orderBy('krt__profile.krt_nama', 'ASC')
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
            $senarai_krt    = KRT_Profile::where('krt_status', '=', true)
                            ->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)    
							->orderBy('krt_nama','asc')            
                            ->get();
			$penggal	= DB::table('ref__penggal')
						  ->select('id','penggal_mula','penggal_tamat')
						  ->orderBy('penggal_mula','asc')
						  ->get();
            return view('rt-sm4.senarai-ajk-krt-ppd', compact('roles_menu','senarai_krt','penggal'));
        }
    }

    function senarai_ajk_krt_ppn(Request $request){
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
            $data = DB::table('krt__ahli_jawatan_kuasa')
                        ->select('krt__ahli_jawatan_kuasa.id',
                                'krt__profile.krt_nama AS krt_nama',
                                'ref__daerahs.daerah_description AS krt_daerah',
                                'krt__profile.state_id AS krt_state_id',
                                'krt__profile.daerah_id AS krt_daerah_id',
                                'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
                                'ref__jawatan_ajk_krt.jawatan_description AS ajk_jawatan',
                                'ref__status_krt_ajk.status_description AS ajk_status',
                                DB::raw(" DATEDIFF( NOW(), krt__ahli_jawatan_kuasa.ajk_tarikh_mula) AS ajk_status_pelantikan"),
                                DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa.ajk_tarikh_akhir,'%d/%m/%Y') AS ajk_tarikh_akhir"),
                                DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa.ajk_tarikh_mula,'%d/%m/%Y') AS ajk_tarikh_mula"))
                        ->leftJoin('ref__jawatan_ajk_krt','ref__jawatan_ajk_krt.id','=','krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
                        ->leftJoin('ref__status_krt_ajk','ref__status_krt_ajk.id','=','krt__ahli_jawatan_kuasa.ajk_status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->where('krt__profile.state_id', '=', Auth::user()->state_id)
                        ->where('krt__ahli_jawatan_kuasa.ajk_status', '=', 1)
                        ->orderBy('krt__profile.krt_nama', 'ASC')
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
            $krt     = KRT_Profile::where('krt_status', '=', true)->get();
            return view('rt-sm4.senarai-ajk-krt-ppn', compact('roles_menu','daerah','krt'));
        }
    }

    function kad_keahlian_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__ahli_jawatan_kuasa')
                        ->select('krt__ahli_jawatan_kuasa.id',
                                'krt__profile.krt_nama AS krt_nama',
                                'krt__profile.state_id AS krt_state',
                                'krt__profile.daerah_id AS krt_daerah',
                                'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                DB::raw(" CONCAT('KRT',krt__profile.state_id,krt__profile.daerah_id,krt__profile.id,krt__ahli_jawatan_kuasa.id) AS no_ahli"),
                                'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
                                'ref__jawatan_ajk_krt.jawatan_description AS ajk_jawatan',
                                'ref__status_krt_ajk.status_description AS ajk_status',
                                DB::raw(" DATEDIFF( NOW(), krt__ahli_jawatan_kuasa.ajk_tarikh_mula) AS ajk_status_pelantikan"),
                                'krt__ahli_jawatan_kuasa.ajk_tarikh_mula',
                                'krt__ahli_jawatan_kuasa.ajk_tarikh_akhir')
                        ->leftJoin('ref__jawatan_ajk_krt','ref__jawatan_ajk_krt.id','=','krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
                        ->leftJoin('ref__status_krt_ajk','ref__status_krt_ajk.id','=','krt__ahli_jawatan_kuasa.ajk_status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
                        ->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)
                        ->where('krt__ahli_jawatan_kuasa.ajk_status', '=', 1)
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
            $senarai_krt     =  KRT_Profile::where('daerah_id', '=', Auth::user()->daerah_id, 'AND' ,'krt_status', '=', true)
                                ->orderBy('krt_nama', 'ASC')
                                ->get();
            return view('rt-sm4.kad-keahlian-ppd', compact('roles_menu','senarai_krt'));
        }
    }

    function kad_keahlian_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_krt') {
                $value = $request->value;
                $where = array('krt_nama' => $value);
                $data  = DB::table('krt__profile')
                        ->select('krt__profile.id', 'krt__profile.krt_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->where('ref__daerahs.daerah_description', '=',  $where)
                        ->where('krt__profile.krt_status', '=',  1)
                        ->orderBy('krt__profile.krt_nama', 'ASC')
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('krt__ahli_jawatan_kuasa')
                        ->select('krt__ahli_jawatan_kuasa.id',
                                'krt__profile.krt_nama AS krt_nama',
                                'ref__daerahs.daerah_description AS krt_daerah',
                                'krt__profile.state_id AS krt_state_id',
                                'krt__profile.daerah_id AS krt_daerah_id',
                                'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
                                'ref__jawatan_ajk_krt.jawatan_description AS ajk_jawatan',
                                'ref__status_krt_ajk.status_description AS ajk_status',
                                DB::raw(" DATEDIFF( NOW(), krt__ahli_jawatan_kuasa.ajk_tarikh_mula) AS ajk_status_pelantikan"),
                                'krt__ahli_jawatan_kuasa.ajk_tarikh_mula',
                                'krt__ahli_jawatan_kuasa.ajk_tarikh_akhir')
                        ->leftJoin('ref__jawatan_ajk_krt','ref__jawatan_ajk_krt.id','=','krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
                        ->leftJoin('ref__status_krt_ajk','ref__status_krt_ajk.id','=','krt__ahli_jawatan_kuasa.ajk_status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->where('krt__profile.state_id', '=', Auth::user()->state_id)
                        ->where('krt__ahli_jawatan_kuasa.ajk_status', '=', 1)
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
            $daerah     = RefDaerah::where('state_id', '=', Auth::user()->state_id)->get();
            return view('rt-sm4.kad-keahlian-ppn', compact('roles_menu','daerah'));
        }
    }

    function kad_keahlian_hqrt(Request $request){
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
                        ->orderBy('krt__profile.krt_nama', 'ASC')
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('krt__ahli_jawatan_kuasa')
                        ->select('krt__ahli_jawatan_kuasa.id',
                                'krt__profile.krt_nama AS krt_nama',
                                'ref__daerahs.daerah_description AS krt_daerah',
                                'ref__states.state_description AS krt_state',
                                'krt__profile.state_id AS krt_state_id',
                                'krt__profile.daerah_id AS krt_daerah_id',
                                'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
                                'ref__jawatan_ajk_krt.jawatan_description AS ajk_jawatan',
                                'ref__status_krt_ajk.status_description AS ajk_status',
                                DB::raw(" DATEDIFF( NOW(), krt__ahli_jawatan_kuasa.ajk_tarikh_mula) AS ajk_status_pelantikan"),
                                'krt__ahli_jawatan_kuasa.ajk_tarikh_mula',
                                'krt__ahli_jawatan_kuasa.ajk_tarikh_akhir')
                        ->leftJoin('ref__jawatan_ajk_krt','ref__jawatan_ajk_krt.id','=','krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
                        ->leftJoin('ref__status_krt_ajk','ref__status_krt_ajk.id','=','krt__ahli_jawatan_kuasa.ajk_status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->where('krt__ahli_jawatan_kuasa.ajk_status', '=', 1)
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
            $state  = RefStates::where('status', '=', true)->get();
            $daerah  = RefDaerah::where('status', '=', true)->get();
            $krt     = KRT_Profile::where('krt_status', '=', true)->get();
            return view('rt-sm4.kad-keahlian-hqrt', compact('roles_menu','state','daerah','krt'));
        }
    }

    function kad_keahlian_admin(Request $request){
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
                $data  = KRT_Profile::where($where)->get();
                return Response::json($data);
            }
            $data = DB::table('krt__ahli_jawatan_kuasa')
                        ->select('krt__ahli_jawatan_kuasa.id',
                                'krt__profile.krt_nama AS krt_nama',
                                'ref__daerahs.daerah_description AS krt_daerah',
                                'ref__states.state_description AS krt_state',
                                'krt__profile.state_id AS krt_state_id',
                                'krt__profile.daerah_id AS krt_daerah_id',
                                'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
                                'ref__jawatan_ajk_krt.jawatan_description AS ajk_jawatan',
                                'ref__status_krt_ajk.status_description AS ajk_status',
                                DB::raw(" DATEDIFF( NOW(), krt__ahli_jawatan_kuasa.ajk_tarikh_mula) AS ajk_status_pelantikan"),
                                'krt__ahli_jawatan_kuasa.ajk_tarikh_mula',
                                'krt__ahli_jawatan_kuasa.ajk_tarikh_akhir')
                        ->leftJoin('ref__jawatan_ajk_krt','ref__jawatan_ajk_krt.id','=','krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
                        ->leftJoin('ref__status_krt_ajk','ref__status_krt_ajk.id','=','krt__ahli_jawatan_kuasa.ajk_status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->where('krt__ahli_jawatan_kuasa.ajk_status', '=', 1)
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
            $state  = RefStates::where('status', '=', true)->get();
            $daerah  = RefDaerah::where('status', '=', true)->get();
            $krt     = KRT_Profile::where('krt_status', '=', true)->get();
            return view('rt-sm4.kad-keahlian-admin', compact('roles_menu','state','daerah','krt'));
        }
    }

    function pendaftaran_ahli_krt_utama_admin(Request $request){
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
                $data  = KRT_Profile::where($where)->get();
                return Response::json($data);
            }
            $data = DB::table('krt__ahli_jawatan_kuasa')
                            ->select('krt__ahli_jawatan_kuasa.id',
                                    'ref__states.state_description AS krt_negeri',
                                    'ref__daerahs.daerah_description AS krt_daerah',
                                    'krt__profile.krt_nama AS krt_nama',
                                    'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                                    'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                    'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
                                    'ref__jawatan_ajk_krt.jawatan_description AS ajk_jawatan_desc',
                                    'ref__status_krt_ajk.status_description AS ajk_status_form_description',
                                    'krt__profile.daerah_id AS daerah_id',
                                    'krt__ahli_jawatan_kuasa.ajk_status_form AS ajk_status_form')
                            ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
                            ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                            ->leftJoin('ref__status_krt_ajk','ref__status_krt_ajk.id','=','krt__ahli_jawatan_kuasa.ajk_status_form')
                            ->leftJoin('ref__jawatan_ajk_krt','ref__jawatan_ajk_krt.id','=','krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
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
            $state  = RefStates::where('status', '=', true)->get();
            $daerah  = RefDaerah::where('status', '=', true)->get();
            $krt     = KRT_Profile::where('krt_status', '=', true)->get();
            return view('rt-sm4.pendaftaran-ahli-krt-utama-admin',compact('roles_menu','state','daerah','krt'));
        }
    }

    function pengesahan_ahli_krt_utama_admin(Request $request){
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
                $data  = KRT_Profile::where($where)->get();
                return Response::json($data);
            }
            $data = DB::table('krt__ahli_jawatan_kuasa')
                        ->select('krt__ahli_jawatan_kuasa.id',
                                'ref__states.state_description AS krt_negeri',
                                'ref__daerahs.daerah_description AS krt_daerah',
                                'krt__profile.krt_nama AS krt_nama',
                                'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
                                'ref__jawatan_ajk_krt.jawatan_description AS ajk_jawatan_desc',
                                'ref__status_krt_ajk.status_description AS ajk_status_form_description',
                                'krt__profile.daerah_id AS daerah_id',
                                'krt__ahli_jawatan_kuasa.ajk_status_form AS ajk_status_form')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__status_krt_ajk','ref__status_krt_ajk.id','=','krt__ahli_jawatan_kuasa.ajk_status_form')
                        ->leftJoin('ref__jawatan_ajk_krt','ref__jawatan_ajk_krt.id','=','krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
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
            $state  = RefStates::where('status', '=', true)->get();
            $daerah  = RefDaerah::where('status', '=', true)->get();
            $krt     = KRT_Profile::where('krt_status', '=', true)->get();
            return view('rt-sm4.pengesahan-ahli-krt-utama-admin',compact('roles_menu','state','daerah','krt'));
        }
    }

    function senarai_ajk_krt_admin(Request $request){
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
                $data  = KRT_Profile::where($where)->get();
                return Response::json($data);
            }
            $data = DB::table('krt__ahli_jawatan_kuasa')
                        ->select('krt__ahli_jawatan_kuasa.id',
                                'krt__profile.krt_nama AS krt_nama',
                                'ref__daerahs.daerah_description AS krt_daerah',
                                'ref__states.state_description AS krt_state',
                                'krt__profile.state_id AS krt_state_id',
                                'krt__profile.daerah_id AS krt_daerah_id',
                                'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                                'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
                                'ref__jawatan_ajk_krt.jawatan_description AS ajk_jawatan',
                                'ref__status_krt_ajk.status_description AS ajk_status',
                                DB::raw(" DATEDIFF( NOW(), krt__ahli_jawatan_kuasa.ajk_tarikh_mula) AS ajk_status_pelantikan"),
                                'krt__ahli_jawatan_kuasa.ajk_tarikh_mula',
                                'krt__ahli_jawatan_kuasa.ajk_tarikh_akhir')
                        ->leftJoin('ref__jawatan_ajk_krt','ref__jawatan_ajk_krt.id','=','krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
                        ->leftJoin('ref__status_krt_ajk','ref__status_krt_ajk.id','=','krt__ahli_jawatan_kuasa.ajk_status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->where('krt__ahli_jawatan_kuasa.ajk_status', '=', 1)
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
            $state  = RefStates::where('status', '=',  true)->get();
            $daerah  = RefDaerah::where('status', '=',  true)->get();
            $krt     = KRT_Profile::where('krt_status', '=', true)->get();
            return view('rt-sm4.senarai-ajk-krt-admin', compact('roles_menu','state','daerah','krt'));
        }
    }

    function cadangan_ajk_kepentingan_krt_admin(Request $request){

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
                $data  = KRT_Profile::where($where)->get();
                return Response::json($data);
            }
            $data = DB::table('krt__ahli_jawatan_kuasa_luar')
                        ->select('krt__ahli_jawatan_kuasa_luar.id',
                                'ref__states.state_description AS krt_state',
                                'ref__daerahs.daerah_description AS krt_daerah',
                                'krt__profile.krt_nama AS krt_nama',
                                'krt__ahli_jawatan_kuasa_luar.ajk_luar_nama AS ajk_luar_nama',
                                'krt__ahli_jawatan_kuasa_luar.ajk_luar_ic AS ajk_luar_ic',
                                'krt__ahli_jawatan_kuasa_luar.ajk_luar_alamat AS ajk_luar_alamat',
                                'krt__ahli_jawatan_kuasa_luar.ajk_luar_status AS ajk_luar_status',
                                'ref__status_krt_ajk_luar.status_description AS status')
                        ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa_luar.krt_profile_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                        ->leftJoin('ref__status_krt_ajk_luar','ref__status_krt_ajk_luar.id','=','krt__ahli_jawatan_kuasa_luar.ajk_luar_status')
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
            $state  = RefStates::where('status', '=',  true)->get();
            $daerah  = RefDaerah::where('status', '=',  true)->get();
            $krt     = KRT_Profile::where('krt_status', '=', true)->get();
            return view('rt-sm4.cadangan-ajk-kepentingan-krt-admin', compact('roles_menu','state','daerah','krt'));
        }
    }
    
    function jana_analisa_lampiran(){
        return view('rt-sm4.jana-analisa-lampiran');
    }

	function check_ajk(Request $request){
		if($request->ajax())
		{
			$type = $request->type;
			if($type == 'check_ajk')
			{
				$value = $request->noic;
            	$data  = DB::table('krt__ahli_jawatan_kuasa')
                         ->select('krt__ahli_jawatan_kuasa.id AS id',
                         'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                         'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
						 'krt__ahli_jawatan_kuasa.file_avatar AS file_avatar',
                         'ref__penggal.penggal_mula AS penggal_mula',
						 'ref__penggal.penggal_tamat AS penggal_tamat',
                         'krt__profile.krt_nama AS krt_nama')
                         ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
                         ->leftJoin('ref__penggal','ref__penggal.id','=','krt__ahli_jawatan_kuasa.ajk_penggal')
						 ->where('ajk_ic','=',$value)
						 ->get();
            	return Response::json($data);
			} 
			if($type == 'get_ajk')
			{
				$value = $request->noic;
            	$data  = KRT_Ahli_Jawatan_Kuasa::where('id','=',$value)->get();
            	return Response::json($data);
			} 
		}
	}
	
	function delete_ajk($id){
        $data = DB::table('krt__ahli_jawatan_kuasa')->where('id', '=', $id)->delete();
    }
}
