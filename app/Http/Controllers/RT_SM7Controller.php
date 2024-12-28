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
use App\KRT_Profile;
use App\RefJenisKewangan;
use App\RefStates;
use App\RefDaerah;
use App\RefParlimen;
use App\RefDUN;
use App\KRT_Kewangan;
use App\KRT_Kewangan_Dokumen;
use App\KRT_Kewangan_Penyata;
use File;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomExport;
use App\Laporan_Kewangan;

class RT_SM7Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function senarai_rekod_kewangan_rt(Request $request){
        if($request->ajax())
		{ 
            $type = $request->type;
			$v_tahun = $request->tahun;
			$v_bulan = $request->bulan;
			if($v_bulan == "00")
			{
				if($v_tahun == "0000")
				{
					$var_where = " DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%Y%m') between '200001' AND '205012'";
				}else
				{
					$var_where = " DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%Y')='".$v_tahun."'";
				}
			}else
			{
				if($request->tahun == "0000")
				{
					$var_where = " DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%m')='".$v_bulan."'";
				}else
				{
					$var_where = " DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%Y%m') between '".$v_tahun.$v_bulan."' AND '".$v_tahun.$v_bulan."'";
				}
			}
			$data = DB::table('krt__kewangan')
					->select('krt__kewangan.id as id','krt__kewangan.krt_profile_id as krt_id',
					DB::raw(" concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(kewangan_masa_t_b,'00:00:00'),'%H%i%s')) AS tarikh_kewangan"),
					DB::raw(" date_format(krt__kewangan.kewangan_tarikh_t_b,'%d/%m/%Y') as tarikh"),
					DB::raw(" time_format(IFNULL(kewangan_masa_t_b,'00:00:00'),'%H:%i:%s') as masa"),
					'krt__kewangan.kewangan_jenis_kewangan as jenis',
					'krt__kewangan.kewangan_butiran as butiran',
					'krt__kewangan.kewangan_nama_penuh as nama_penuh',
					'krt__kewangan.kewangan_alamat as alamat',
					'krt__kewangan.kewangan_jumlah_bank as jumlah_bank',
					DB::raw(" semak_baki_bank(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(kewangan_masa_t_b,'00:00:00'),'%H%i%s'))) as baki_bank"),
					'krt__kewangan.kewangan_jumlah_tunai as jumlah_tunai',
					DB::raw(" semak_baki_tunai(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(kewangan_masa_t_b,'00:00:00'),'%H%i%s'))) as baki_tunai"),
					'krt__kewangan.kewangan_status as status',
					'ref__status_krt_kewangan.status_kewangan_description as status_desc')
					->leftJoin('ref__status_krt_kewangan','ref__status_krt_kewangan.id','=','krt__kewangan.kewangan_status')
					->where('krt__kewangan.krt_profile_id','=',Auth::user()->krt_id)
					->whereIn('krt__kewangan.kewangan_status', [1,2,3,4,5,6])
					->whereRaw($var_where)
					->orderBy('tarikh','desc')
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
            return view('rt-sm7.senarai-rekod-kewangan-rt',compact('roles_menu'));
        }
    }

    function add_rekod_kewangan_rt(Request $request){
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
            $ref_jenis_kewangan     = RefJenisKewangan::where('status', '=', true)->get();
            $krt_profile            = DB::table('users__profile')
                                        ->select('users__profile.id',
                                                    'krt__profile.id AS krt_profile_id',
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
                                                    'ref__pbts.pbt_description AS pbt_krt',
                                                    'krt__profile.krt_bank_nama',
                                                    'krt__profile.krt_bank_no_acc',
                                                    'krt__profile.krt_bank_no_evendor',
                                                    'krt__profile.krt_bank_baki_bank',
                                                    'krt__profile.krt_bank_baki_cash')
                                        ->leftJoin('krt__profile','krt__profile.id','=','users__profile.krt_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                        ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                        ->where('users__profile.user_id', '=', Auth::user()->user_id)  
                                        ->limit(1)
                                        ->first();
            return view('rt-sm7.add-rekod-kewangan-rt', compact('roles_menu','ref_jenis_kewangan','krt_profile'));
        }
    }

    function kembali_rekod_kewangan_rt(Request $request){
        $action = $request->post_rekod_kewangan_rt;
        if($action == "add")
		{
			if ($request->mag_dokumen_kewangan_id == "") 
			{
				$masa=$request->arkr_kewangan_time_t_b.':00';
				$chkexist = DB::table('krt__kewangan')
							->select('id')
							->whereRaw("DATE_FORMAT(kewangan_tarikh_t_b,'%d/%m/%Y')='".$request->arkr_kewangan_tarikh_t_b."'")
							->where('kewangan_masa_t_b','=',$masa)
							->where('krt_profile_id','=',$request->arkr_krt_profile_id)
							->count();
				if ($chkexist == 0 ) {
					$rekod_kewangan                              = new KRT_Kewangan;
					$rekod_kewangan->krt_profile_id              = $request->arkr_krt_profile_id;
					$rekod_kewangan->kewangan_nama_penuh         = $request->arkr_kewangan_nama_penuh;
					$rekod_kewangan->kewangan_jenis_kewangan     = $request->arkr_kewangan_jenis_kewangan;
					$rekod_kewangan->kewangan_alamat             = $request->arkr_kewangan_alamat;
					$rekod_kewangan->kewangan_butiran            = $request->arkr_kewangan_butiran;
					if($request->arkr_kewangan_tarikh_t_b != "")
						$rekod_kewangan->kewangan_tarikh_t_b     = Carbon::createFromFormat('d/m/Y', $request->arkr_kewangan_tarikh_t_b)->format('Y-m-d');
					$rekod_kewangan->kewangan_masa_t_b			 = $request->arkr_kewangan_time_t_b;
					$rekod_kewangan->kewangan_jumlah_tunai       = $request->arkr_kewangan_jumlah_tunai;
					$rekod_kewangan->kewangan_jumlah_bank        = $request->arkr_kewangan_jumlah_bank;
					$rekod_kewangan->kewangan_baki_tunai         = $request->arkr_kewangan_baki_tunai;
					$rekod_kewangan->kewangan_baki_bank          = $request->arkr_kewangan_baki_bank;
					$rekod_kewangan->kewangan_jumlah_baki        = $request->arkr_kewangan_jumlah_baki;
					$rekod_kewangan->kewangan_status 			 = 4;
					$rekod_kewangan->direkodby                   = Auth::user()->user_id;
					$rekod_kewangan->rekod_date                  = date('Y-m-d H:i:s');
					$rekod_kewangan->save();
				}else
				{
					return \Response::json(array('errors' => 3));
				}
			}else
			{
				$masa=$request->arkr_kewangan_time_t_b.':00';
				$chkexist = DB::table('krt__kewangan')
							->select('id')
							->whereRaw("DATE_FORMAT(kewangan_tarikh_t_b,'%d/%m/%Y')='".$request->arkr_kewangan_tarikh_t_b."'")
							->where('kewangan_masa_t_b','=',$masa)
							->where('id','<>',$request->mag_dokumen_kewangan_id)
							->where('krt_profile_id','=',$request->arkr_krt_profile_id)
							->count();
				if ($chkexist == 0 ) 
				{
					$where = array('id' => $request->mag_dokumen_kewangan_id);
					$rekod_kewangan                              = KRT_Kewangan::where($where)->first();
					$rekod_kewangan->krt_profile_id              = $request->arkr_krt_profile_id;
					$rekod_kewangan->kewangan_nama_penuh         = $request->arkr_kewangan_nama_penuh;
					$rekod_kewangan->kewangan_jenis_kewangan     = $request->arkr_kewangan_jenis_kewangan;
					$rekod_kewangan->kewangan_alamat             = $request->arkr_kewangan_alamat;
					$rekod_kewangan->kewangan_butiran            = $request->arkr_kewangan_butiran;
					if($request->arkr_kewangan_tarikh_t_b != "")
						$rekod_kewangan->kewangan_tarikh_t_b         = Carbon::createFromFormat('d/m/Y', $request->arkr_kewangan_tarikh_t_b)->format('Y-m-d');
					$rekod_kewangan->kewangan_masa_t_b			 = $request->arkr_kewangan_time_t_b;
					$rekod_kewangan->kewangan_jumlah_tunai       = $request->arkr_kewangan_jumlah_tunai;
					$rekod_kewangan->kewangan_jumlah_bank        = $request->arkr_kewangan_jumlah_bank;
					$rekod_kewangan->kewangan_baki_tunai         = $request->arkr_kewangan_baki_tunai;
					$rekod_kewangan->kewangan_baki_bank          = $request->arkr_kewangan_baki_bank;
					$rekod_kewangan->kewangan_jumlah_baki        = $request->arkr_kewangan_jumlah_baki;
					$rekod_kewangan->kewangan_status             = 4;
					$rekod_kewangan->direkodby                   = Auth::user()->user_id;
					$rekod_kewangan->rekod_date                  = date('Y-m-d H:i:s');
					$rekod_kewangan->save();
				}else
				{
					return \Response::json(array('errors' => 3));
				}
			}
		}
		if($action == "edit")
		{
			if ($request->mag_dokumen_kewangan_id == "") 
			{
				$masa=$request->krkr_kewangan_time_t_b.':00';
				$chkexist = DB::table('krt__kewangan')
							->select('id')
							->whereRaw("DATE_FORMAT(kewangan_tarikh_t_b,'%d/%m/%Y')='".$request->krkr_kewangan_tarikh_t_b."'")
							->where('kewangan_masa_t_b','=',$masa)
							->where('krt_profile_id','=',$request->mag_dokumen_krt_id)
							->count();
				if ($chkexist == 0 ) 
				{
					$rekod_kewangan                              = new KRT_Kewangan;
					$rekod_kewangan->krt_profile_id              = $request->mag_dokumen_krt_id;
					$rekod_kewangan->kewangan_nama_penuh         = $request->krkr_kewangan_nama_penuh;
					$rekod_kewangan->kewangan_jenis_kewangan     = $request->krkr_kewangan_jenis_kewangan;
					$rekod_kewangan->kewangan_alamat             = $request->krkr_kewangan_alamat;
					$rekod_kewangan->kewangan_butiran            = $request->krkr_kewangan_butiran;
					if($request->krkr_kewangan_tarikh_t_b != "")
						$rekod_kewangan->kewangan_tarikh_t_b         = Carbon::createFromFormat('d/m/Y', $request->krkr_kewangan_tarikh_t_b)->format('Y-m-d');
					$rekod_kewangan->kewangan_masa_t_b			 = $request->krkr_kewangan_time_t_b;
					$rekod_kewangan->kewangan_jumlah_tunai       = $request->krkr_kewangan_jumlah_tunai;
					$rekod_kewangan->kewangan_jumlah_bank        = $request->krkr_kewangan_jumlah_bank;
					$rekod_kewangan->kewangan_baki_tunai         = $request->krkr_kewangan_baki_tunai;
					$rekod_kewangan->kewangan_baki_bank          = $request->krkr_kewangan_baki_bank;
					$rekod_kewangan->kewangan_jumlah_baki        = $request->krkr_kewangan_jumlah_baki;
					$rekod_kewangan->kewangan_status 			 = 4;
					$rekod_kewangan->direkodby                   = Auth::user()->user_id;
					$rekod_kewangan->rekod_date                  = date('Y-m-d H:i:s');
					$rekod_kewangan->save();
				}else
				{
					return \Response::json(array('errors' => 3));
				}
			}else
			{
				$masa=$request->krkr_kewangan_time_t_b.':00';
				$chkexist = DB::table('krt__kewangan')
							->select('id')
							->whereRaw("DATE_FORMAT(kewangan_tarikh_t_b,'%d/%m/%Y')='".$request->krkr_kewangan_tarikh_t_b."'")
							->where('kewangan_masa_t_b','=',$masa)
							->where('id','<>',$request->mag_dokumen_kewangan_id)
							->where('krt_profile_id','=',$request->mag_dokumen_krt_id)
							->count();
				if ($chkexist == 0 ) 
				{
					$where = array('id' => $request->mag_dokumen_kewangan_id);
					$rekod_kewangan                              = KRT_Kewangan::where($where)->first();
					$rekod_kewangan->krt_profile_id              = $request->mag_dokumen_krt_id;
					$rekod_kewangan->kewangan_nama_penuh         = $request->krkr_kewangan_nama_penuh;
					$rekod_kewangan->kewangan_jenis_kewangan     = $request->krkr_kewangan_jenis_kewangan;
					$rekod_kewangan->kewangan_alamat             = $request->krkr_kewangan_alamat;
					$rekod_kewangan->kewangan_butiran            = $request->krkr_kewangan_butiran;
					if($request->krkr_kewangan_tarikh_t_b != "")
						$rekod_kewangan->kewangan_tarikh_t_b         = Carbon::createFromFormat('d/m/Y', $request->krkr_kewangan_tarikh_t_b)->format('Y-m-d');
					$rekod_kewangan->kewangan_masa_t_b			 = $request->krkr_kewangan_time_t_b;
					$rekod_kewangan->kewangan_jumlah_tunai       = $request->krkr_kewangan_jumlah_tunai;
					$rekod_kewangan->kewangan_jumlah_bank        = $request->krkr_kewangan_jumlah_bank;
					$rekod_kewangan->kewangan_baki_tunai         = $request->krkr_kewangan_baki_tunai;
					$rekod_kewangan->kewangan_baki_bank          = $request->krkr_kewangan_baki_bank;
					$rekod_kewangan->kewangan_jumlah_baki        = $request->krkr_kewangan_jumlah_baki;
					$rekod_kewangan->kewangan_status             = 4;
					$rekod_kewangan->direkodby                   = Auth::user()->user_id;
					$rekod_kewangan->rekod_date                  = date('Y-m-d H:i:s');
					$rekod_kewangan->save();
				}else
				{
					return \Response::json(array('errors' => 3));
				}
			}
		}
    }
	
	function post_rekod_kewangan_rt(Request $request){
        $action = $request->post_rekod_kewangan_rt;
        
			$rules = array(
				'arkr_kewangan_jenis_kewangan'                 => 'required',
				'arkr_kewangan_nama_penuh'                     => 'required',
				'arkr_kewangan_alamat'                         => 'required',
				'arkr_kewangan_butiran'                        => 'required',
				'arkr_kewangan_tarikh_t_b'                     => 'required',
				'arkr_kewangan_time_t_b'                       => 'required',
				'arkr_kewangan_jumlah_tunai'                   => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
				'arkr_kewangan_jumlah_bank'                    => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/'
			);
	
			$messages = [
				'arkr_kewangan_jenis_kewangan.required'        => 'Ruangan Jenis Kewangan mesti dipilih',
				'arkr_kewangan_nama_penuh.required'            => 'Ruang Nama Penuh mesti diisi',
				'arkr_kewangan_alamat.required'                => 'Ruangan Alamat mesti diisi',
				'arkr_kewangan_butiran.required'               => 'Ruangan Butiran mesti diisi',
				'arkr_kewangan_tarikh_t_b.required'            => 'Ruangan Tarikh Penerimaan / Pembayaran mesti diisi',
				'arkr_kewangan_time_t_b.required'              => 'Ruangan Masa Penerimaan / Pembayaran mesti diisi',
				'arkr_kewangan_jumlah_tunai.required'          => 'Ruangan Tunai mesti diisi',
				'arkr_kewangan_jumlah_bank.required'           => 'Ruangan Baki mesti diisi',
				'arkr_kewangan_jumlah_tunai.numeric'           => 'Ruangan Tunai mesti diisi contoh : 0.00',
				'arkr_kewangan_jumlah_bank.numeric'            => 'Ruangan Baki mesti diisi contoh : 0.00',
				'arkr_kewangan_jumlah_tunai.regex'             => 'Ruangan Tunai mesti diisi contoh : 0.00',
				'arkr_kewangan_jumlah_bank.regex'              => 'Ruangan Baki mesti diisi contoh : 0.00',
			];
		
		$validator = Validator::make(Input::all(), $rules, $messages);

		if ($validator->fails()) 
		{
			return \Response::json(array('errors' => $validator->errors()->toArray()));
		} else 
		{
			if ($request->mag_dokumen_kewangan_id == '') 
			{
				$masa=$request->arkr_kewangan_time_t_b.':00';
				$chkexist = DB::table('krt__kewangan')
							->select('id')
							->whereRaw("DATE_FORMAT(kewangan_tarikh_t_b,'%d/%m/%Y')='".$request->arkr_kewangan_tarikh_t_b."'")
							->where('kewangan_masa_t_b','=',$masa)
							->where('krt_profile_id','=',$request->arkr_krt_profile_id)
							->count();
				if ($chkexist == 0 ) 
				{
					$carbon_obj_1 = Carbon::createFromFormat('d/m/Y', $request->arkr_kewangan_tarikh_t_b)->format('Y-m-d');
					$rekod_kewangan                              = new KRT_Kewangan;
					$rekod_kewangan->krt_profile_id              = $request->arkr_krt_profile_id;
					$rekod_kewangan->kewangan_nama_penuh         = $request->arkr_kewangan_nama_penuh;
					$rekod_kewangan->kewangan_jenis_kewangan     = $request->arkr_kewangan_jenis_kewangan;
					$rekod_kewangan->kewangan_alamat             = $request->arkr_kewangan_alamat;
					$rekod_kewangan->kewangan_butiran            = $request->arkr_kewangan_butiran;
					$rekod_kewangan->kewangan_tarikh_t_b         = $carbon_obj_1;
					$rekod_kewangan->kewangan_masa_t_b           = $request->arkr_kewangan_time_t_b;
					$rekod_kewangan->kewangan_jumlah_tunai       = $request->arkr_kewangan_jumlah_tunai;
					$rekod_kewangan->kewangan_jumlah_bank        = $request->arkr_kewangan_jumlah_bank;
					$rekod_kewangan->kewangan_baki_tunai         = $request->arkr_kewangan_baki_tunai;
					$rekod_kewangan->kewangan_baki_bank          = $request->arkr_kewangan_baki_bank;
					$rekod_kewangan->kewangan_jumlah_baki        = $request->arkr_kewangan_jumlah_baki;
					$rekod_kewangan->kewangan_status 			 = 2;
					$rekod_kewangan->direkodby                   = Auth::user()->user_id;
					$rekod_kewangan->rekod_date                  = date('Y-m-d H:i:s');
					$rekod_kewangan->save();
				}else
				{
					return \Response::json(array('errors' => 3 ));
				}
			}else
			{
				$masa=$request->arkr_kewangan_time_t_b.':00';
				$chkexist = DB::table('krt__kewangan')
							->select('id')
							->whereRaw("DATE_FORMAT(kewangan_tarikh_t_b,'%d/%m/%Y')='".$request->arkr_kewangan_tarikh_t_b."'")
							->where('kewangan_masa_t_b','=',$masa)
							->where('id','<>',$request->mag_dokumen_kewangan_id)
							->where('krt_profile_id','=',$request->arkr_krt_profile_id)
							->count();
				if ($chkexist == 0 ) 
				{
					$carbon_obj_1 = Carbon::createFromFormat('d/m/Y', $request->arkr_kewangan_tarikh_t_b)->format('Y-m-d');
					$where = array('id' => $request->mag_dokumen_kewangan_id);
					$rekod_kewangan                              = KRT_Kewangan::where($where)->first();
					$rekod_kewangan->krt_profile_id              = $request->arkr_krt_profile_id;
					$rekod_kewangan->kewangan_nama_penuh         = $request->arkr_kewangan_nama_penuh;
					$rekod_kewangan->kewangan_nama_penuh         = $request->arkr_kewangan_nama_penuh;
					$rekod_kewangan->kewangan_jenis_kewangan     = $request->arkr_kewangan_jenis_kewangan;
					$rekod_kewangan->kewangan_alamat             = $request->arkr_kewangan_alamat;
					$rekod_kewangan->kewangan_butiran            = $request->arkr_kewangan_butiran;
					$rekod_kewangan->kewangan_tarikh_t_b         = $carbon_obj_1;
					$rekod_kewangan->kewangan_masa_t_b           = $request->arkr_kewangan_time_t_b;
					$rekod_kewangan->kewangan_jumlah_tunai       = $request->arkr_kewangan_jumlah_tunai;
					$rekod_kewangan->kewangan_jumlah_bank        = $request->arkr_kewangan_jumlah_bank;
					$rekod_kewangan->kewangan_baki_tunai         = $request->arkr_kewangan_baki_tunai;
					$rekod_kewangan->kewangan_baki_bank          = $request->arkr_kewangan_baki_bank;
					$rekod_kewangan->kewangan_jumlah_baki        = $request->arkr_kewangan_jumlah_baki;
					$rekod_kewangan->kewangan_status             = 2;
					$rekod_kewangan->direkodby                   = Auth::user()->user_id;
					$rekod_kewangan->rekod_date                  = date('Y-m-d H:i:s');
					$rekod_kewangan->save();
				}else
				{
					return \Response::json(array('errors' => 3));
				}
			}
			//return \Response::json(array('success' =>'berjaya'));
		}
    }
	
	function senarai_trx(Request $request, $id){
        $data = DB::table('krt__kewangan')
				->select('krt__kewangan.id',
				'krt__kewangan.kewangan_tarikh_t_b',
				'krt__kewangan.kewangan_jenis_kewangan',
				'krt__kewangan.kewangan_jumlah_tunai',
				'krt__kewangan.kewangan_jumlah_bank',
				DB::Raw(" concat(DATE_FORMAT(kewangan_tarikh_t_b,'%Y%m%d'),TIME_FORMAT(IFNULL(kewangan_masa_t_b,'00:00:00'),'%H%i')) AS tarikh_kewangan"),
				'krt__kewangan.kewangan_masa_t_b')
				->where('krt__kewangan.krt_profile_id', '=', Auth::user()->krt_id)
				->whereNotNull('krt__kewangan.kewangan_tarikh_t_b')
				->orderBy('krt__kewangan.kewangan_tarikh_t_b', 'desc')
				->get();
        return Datatables::of($data)
                    ->make(true);
    }
	
	function senarai_dokumen_sokongan(Request $request, $id){
       $data = DB::table('krt__kewangan_dokumen')
				->select('krt__kewangan_dokumen.id',
				'krt__kewangan_dokumen.kewangan_id',
				'krt__kewangan_dokumen.jenis',
				'krt__kewangan_dokumen.butiran',
				'krt__kewangan_dokumen.fail_dokumen',
				DB::raw(" DATE_FORMAT(krt__kewangan_dokumen.kewangan_tarikh_cek,'%d/%m/%Y') AS kewangan_tarikh_cek"),
				'krt__kewangan_dokumen.kewangan_cek_baucer')
				->where('krt__kewangan_dokumen.kewangan_id', '=', $id)
				->orderBy('krt__kewangan_dokumen.jenis', 'asc')
				->get();
        return Datatables::of($data)
                ->make(true);
    }
	
    function kemaskini_rekod_kewangan_rt_1(Request $request , $id){
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
            $ref_jenis_kewangan     = RefJenisKewangan::where('status', '=', true)->get();
            $rekod_kewangan_rt      = DB::table('krt__kewangan')
                                        ->select('krt__kewangan.id',
                                                    'krt__kewangan.krt_profile_id',
                                                    'krt__profile.krt_nama AS nama_krt',
                                                    'krt__profile.krt_alamat AS alamat_krt',
                                                    'ref__states.state_description AS negeri_krt',
                                                    'ref__parlimens.parlimen_description AS parlimen_krt',
                                                    'ref__pbts.pbt_description AS pbt_krt',
                                                    'ref__daerahs.daerah_description AS daerah_krt',
                                                    'ref__duns.dun_description AS dun_krt', 
                                                    'krt__kewangan.kewangan_no_acc', 
                                                    'krt__kewangan.kewangan_jenis_kewangan',
                                                    'krt__profile.krt_bank_nama',
                                                    'krt__profile.krt_bank_no_acc',
                                                    'krt__profile.krt_bank_no_evendor',
                                                    'krt__kewangan.kewangan_alamat',
                                                    'krt__kewangan.kewangan_butiran',
                                                    DB::raw(" DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%d/%m/%Y') AS tarikh_t_b"),
													DB::raw(" TIME_FORMAT(IFNULL(kewangan_masa_t_b,'00:00'),'%H:%i') AS masa_t_b"),
                                                    'krt__kewangan.kewangan_cek_baucer AS kewangan_cek_baucer',
                                                    DB::raw(" DATE_FORMAT(krt__kewangan.kewangan_tarikh_cek,'%d/%m/%Y') AS tarikh_c_b"),
                                                    'krt__kewangan.kewangan_jumlah_tunai',
                                                    'krt__kewangan.kewangan_jumlah_bank',
													DB::raw(" semak_baki_tunai(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(kewangan_masa_t_b,'00:00:00'),'%H%i%s'))) as kewangan_baki_tunai"),
													DB::raw(" semak_baki_bank(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(kewangan_masa_t_b,'00:00:00'),'%H%i%s'))) as kewangan_baki_bank"),
                                                    //'krt__kewangan.kewangan_baki_tunai',
                                                    //'krt__kewangan.kewangan_baki_bank',
                                                    'krt__kewangan.kewangan_jumlah_baki',
                                                    'krt__kewangan.kewangan_status AS kewangan_status',
                                                    'ref__status_krt_kewangan.status_kewangan_description',
                                                    'krt__kewangan.direkodby AS direkodby',
                                                    'krt__kewangan.semakby AS semakby',
                                                    'krt__kewangan.semak_noted AS semak_noted',
                                                    'krt__kewangan.sahby AS sahby',
                                                    'krt__kewangan.sah_noted AS sah_noted',
                                                    'krt__kewangan.kewangan_nama_penuh',
                                                    'krt__kewangan.kewangan_nama_bank',
                                                    //'krt__kewangan.kewangan_no_evendor',
													DB::raw(" semak_baki_tunai(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(kewangan_masa_t_b,'00:00:00'),'%H%i%s'))) as krt_bank_baki_cash"),
													DB::raw(" semak_baki_bank(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(kewangan_masa_t_b,'00:00:00'),'%H%i%s'))) as krt_bank_baki_bank"),
                                                    //'krt__profile.krt_bank_baki_bank',
                                                    'krt__kewangan.kewangan_no_evendor')
                                        ->leftJoin('krt__profile','krt__profile.id','=','krt__kewangan.krt_profile_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                        ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                        ->leftJoin('ref__status_krt_kewangan','ref__status_krt_kewangan.id','=','krt__kewangan.kewangan_status')
                                        ->where('krt__kewangan.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            return view('rt-sm7.kemaskini-rekod-kewangan-rt-1', compact('roles_menu','ref_jenis_kewangan','rekod_kewangan_rt'));
        }
    }
	
	function lihat_rekod_kewangan_rt_1(Request $request , $id){
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
            $ref_jenis_kewangan     = RefJenisKewangan::where('status', '=', true)->get();
            $rekod_kewangan_rt      = DB::table('krt__kewangan')
                                        ->select('krt__kewangan.id',
                                                    'krt__kewangan.krt_profile_id',
                                                    'krt__profile.krt_nama AS nama_krt',
                                                    'krt__profile.krt_alamat AS alamat_krt',
                                                    'ref__states.state_description AS negeri_krt',
                                                    'ref__parlimens.parlimen_description AS parlimen_krt',
                                                    'ref__pbts.pbt_description AS pbt_krt',
                                                    'ref__daerahs.daerah_description AS daerah_krt',
                                                    'ref__duns.dun_description AS dun_krt', 
                                                    'krt__kewangan.kewangan_no_acc', 
                                                    'krt__kewangan.kewangan_jenis_kewangan',
                                                    'krt__profile.krt_bank_nama',
                                                    'krt__profile.krt_bank_no_acc',
                                                    'krt__profile.krt_bank_no_evendor',
                                                    'krt__kewangan.kewangan_alamat',
                                                    'krt__kewangan.kewangan_butiran',
                                                    DB::raw(" DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%d/%m/%Y') AS tarikh_t_b"),
													DB::raw(" TIME_FORMAT(IFNULL(kewangan_masa_t_b,'00:00'),'%H:%i') AS masa_t_b"),
                                                    'krt__kewangan.kewangan_cek_baucer AS kewangan_cek_baucer',
                                                    DB::raw(" DATE_FORMAT(krt__kewangan.kewangan_tarikh_cek,'%d/%m/%Y') AS tarikh_c_b"),
                                                    'krt__kewangan.kewangan_jumlah_tunai',
                                                    'krt__kewangan.kewangan_jumlah_bank',
													DB::raw(" semak_baki_tunai(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(kewangan_masa_t_b,'00:00:00'),'%H%i%s'))) as kewangan_baki_tunai"),
													DB::raw(" semak_baki_bank(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(kewangan_masa_t_b,'00:00:00'),'%H%i%s'))) as kewangan_baki_bank"),
                                                    //'krt__kewangan.kewangan_baki_tunai',
                                                    //'krt__kewangan.kewangan_baki_bank',
                                                    'krt__kewangan.kewangan_jumlah_baki',
                                                    'krt__kewangan.kewangan_status AS kewangan_status',
                                                    'ref__status_krt_kewangan.status_kewangan_description',
                                                    'krt__kewangan.direkodby AS direkodby',
                                                    'krt__kewangan.semakby AS semakby',
                                                    'krt__kewangan.semak_noted AS semak_noted',
                                                    'krt__kewangan.sahby AS sahby',
                                                    'krt__kewangan.sah_noted AS sah_noted',
                                                    'krt__kewangan.kewangan_nama_penuh',
                                                    'krt__kewangan.kewangan_nama_bank',
                                                    //'krt__kewangan.kewangan_no_evendor',
													DB::raw(" semak_baki_tunai(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(kewangan_masa_t_b,'00:00:00'),'%H%i%s'))) as krt_bank_baki_cash"),
													DB::raw(" semak_baki_bank(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(kewangan_masa_t_b,'00:00:00'),'%H%i%s'))) as krt_bank_baki_bank"),
                                                    //'krt__profile.krt_bank_baki_bank',
                                                    'krt__kewangan.kewangan_no_evendor')
                                        ->leftJoin('krt__profile','krt__profile.id','=','krt__kewangan.krt_profile_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                        ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                        ->leftJoin('ref__status_krt_kewangan','ref__status_krt_kewangan.id','=','krt__kewangan.kewangan_status')
                                        ->where('krt__kewangan.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            return view('rt-sm7.lihat-rekod-kewangan-rt-1', compact('roles_menu','ref_jenis_kewangan','rekod_kewangan_rt'));
        }
    }
	
	function lihatsemakan_rekod_kewangan_rt_1(Request $request , $id){
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
            $ref_jenis_kewangan     = RefJenisKewangan::where('status', '=', true)->get();
            $rekod_kewangan_rt      = DB::table('krt__kewangan')
                                        ->select('krt__kewangan.id',
                                                    'krt__kewangan.krt_profile_id',
                                                    'krt__profile.krt_nama AS nama_krt',
                                                    'krt__profile.krt_alamat AS alamat_krt',
                                                    'ref__states.state_description AS negeri_krt',
                                                    'ref__parlimens.parlimen_description AS parlimen_krt',
                                                    'ref__pbts.pbt_description AS pbt_krt',
                                                    'ref__daerahs.daerah_description AS daerah_krt',
                                                    'ref__duns.dun_description AS dun_krt', 
                                                    'krt__kewangan.kewangan_no_acc', 
                                                    'krt__kewangan.kewangan_jenis_kewangan',
                                                    'krt__profile.krt_bank_nama',
                                                    'krt__profile.krt_bank_no_acc',
                                                    'krt__profile.krt_bank_no_evendor',
                                                    'krt__kewangan.kewangan_alamat',
                                                    'krt__kewangan.kewangan_butiran',
                                                    DB::raw(" DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%d/%m/%Y') AS tarikh_t_b"),
													DB::raw(" TIME_FORMAT(IFNULL(kewangan_masa_t_b,'00:00'),'%H:%i') AS masa_t_b"),
                                                    'krt__kewangan.kewangan_cek_baucer AS kewangan_cek_baucer',
                                                    DB::raw(" DATE_FORMAT(krt__kewangan.kewangan_tarikh_cek,'%d/%m/%Y') AS tarikh_c_b"),
                                                    'krt__kewangan.kewangan_jumlah_tunai',
                                                    'krt__kewangan.kewangan_jumlah_bank',
													DB::raw(" semak_baki_tunai(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(kewangan_masa_t_b,'00:00:00'),'%H%i%s'))) as kewangan_baki_tunai"),
													DB::raw(" semak_baki_bank(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(kewangan_masa_t_b,'00:00:00'),'%H%i%s'))) as kewangan_baki_bank"),
                                                    //'krt__kewangan.kewangan_baki_tunai',
                                                    //'krt__kewangan.kewangan_baki_bank',
                                                    'krt__kewangan.kewangan_jumlah_baki',
                                                    'krt__kewangan.kewangan_status AS kewangan_status',
                                                    'ref__status_krt_kewangan.status_kewangan_description',
                                                    'krt__kewangan.direkodby AS direkodby',
                                                    'krt__kewangan.semakby AS semakby',
                                                    'krt__kewangan.semak_noted AS semak_noted',
                                                    'krt__kewangan.sahby AS sahby',
                                                    'krt__kewangan.sah_noted AS sah_noted',
                                                    'krt__kewangan.kewangan_nama_penuh',
                                                    'krt__kewangan.kewangan_nama_bank',
                                                    //'krt__kewangan.kewangan_no_evendor',
													DB::raw(" semak_baki_tunai(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(kewangan_masa_t_b,'00:00:00'),'%H%i%s'))) as krt_bank_baki_cash"),
													DB::raw(" semak_baki_bank(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(kewangan_masa_t_b,'00:00:00'),'%H%i%s'))) as krt_bank_baki_bank"),
                                                    //'krt__profile.krt_bank_baki_bank',
                                                    'krt__kewangan.kewangan_no_evendor')
                                        ->leftJoin('krt__profile','krt__profile.id','=','krt__kewangan.krt_profile_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                        ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                        ->leftJoin('ref__status_krt_kewangan','ref__status_krt_kewangan.id','=','krt__kewangan.kewangan_status')
                                        ->where('krt__kewangan.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            return view('rt-sm7.lihatsemakan-rekod-kewangan-rt-1', compact('roles_menu','ref_jenis_kewangan','rekod_kewangan_rt'));
        }
    }

    function post_edit_rekod_kewangan_rt(Request $request){
        $action = $request->post_edit_rekod_kewangan_rt;
        $app_id = $request->krkr_krt_kewangan_id;
        
        
        $rules = array(
            'krkr_kewangan_jenis_kewangan'                 => 'required',
            'krkr_kewangan_nama_penuh'                     => 'required',
            'krkr_kewangan_alamat'                         => 'required',
            'krkr_kewangan_butiran'                        => 'required',
            'krkr_kewangan_tarikh_t_b'                     => 'required',
			'krkr_kewangan_time_t_b'                     => 'required',
        );

        $messages = [
            'krkr_kewangan_jenis_kewangan.required'        => 'Ruangan Jenis Kewangan mesti dipilih',
            'krkr_kewangan_nama_penuh.required'            => 'Ruangan Nama Penuh mesti diisi',
            'krkr_kewangan_alamat.required'                => 'Ruangan Alamat mesti diisi',
            'krkr_kewangan_butiran.required'               => 'Ruangan Butiran mesti diisi',
            'krkr_kewangan_tarikh_t_b.required'            => 'Ruangan Tarikh Penerimaan / Pembayaran mesti diisi',
			'krkr_kewangan_time_t_b.required'              => 'Ruangan Masa Penerimaan / Pembayaran mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
				$masa=$request->krkr_kewangan_time_t_b.':00';
				$chkexist = DB::table('krt__kewangan')
							->select('id')
							->whereRaw("DATE_FORMAT(kewangan_tarikh_t_b,'%d/%m/%Y')='".$request->krkr_kewangan_tarikh_t_b."'")
							->where('kewangan_masa_t_b','=',$masa)
							->where('id','<>',$app_id)
							->where('krt_profile_id','=',$request->krkr_krt_profile_id)
							->count();
				if ($chkexist == 0 ) 
				{
					$where = array('id' => $app_id);
					$carbon_obj_1 = Carbon::createFromFormat('d/m/Y', $request->krkr_kewangan_tarikh_t_b)->format('Y-m-d');
					$edit_rekod_kewangan                         = KRT_Kewangan::where($where)->first();
					$edit_rekod_kewangan->kewangan_nama_penuh         = $request->krkr_kewangan_nama_penuh;
					$edit_rekod_kewangan->kewangan_jenis_kewangan     = $request->krkr_kewangan_jenis_kewangan;
					$edit_rekod_kewangan->kewangan_alamat             = $request->krkr_kewangan_alamat;
					$edit_rekod_kewangan->kewangan_butiran            = $request->krkr_kewangan_butiran;
					$edit_rekod_kewangan->kewangan_tarikh_t_b         = $carbon_obj_1;
					$edit_rekod_kewangan->kewangan_masa_t_b           = $request->krkr_kewangan_time_t_b;
					$edit_rekod_kewangan->kewangan_jumlah_tunai       = $request->krkr_kewangan_jumlah_tunai;
					$edit_rekod_kewangan->kewangan_jumlah_bank        = $request->krkr_kewangan_jumlah_bank;
					$edit_rekod_kewangan->kewangan_baki_tunai         = $request->krkr_kewangan_baki_tunai;
					$edit_rekod_kewangan->kewangan_baki_bank          = $request->krkr_kewangan_baki_bank;
					$edit_rekod_kewangan->kewangan_jumlah_baki        = $request->krkr_kewangan_jumlah_baki;
					$edit_rekod_kewangan->kewangan_status             = 2;
					$edit_rekod_kewangan->save();
				}else
				{
					return \Response::json(array('errors' => 3));
				}
            }
        }
    }

    function semakan_rekod_kewangan_rt(Request $request){
        if($request->ajax())
		{ 
            $type = $request->type;
			$v_bulan = $request->bulan;
			$v_tahun = $request->tahun;
			if($request->bulan == "00")
			{
				if($request->tahun == "0000")
				{
					$var_where = " DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%Y%m') between '200001' AND '205012'";
				}else
				{
					$var_where = " DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%Y')='".$v_tahun."'";
				}
			}else
			{
				if($request->tahun == "0000")
				{
					$var_where = " DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%m')='".$v_bulan."'";
				}else
				{
					$var_where = " DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%Y%m') between '".$v_tahun.$v_bulan."' AND '".$v_tahun.$v_bulan."'";
				}
			}
			
			$data = DB::table('krt__kewangan')
					->select('krt__kewangan.id as id','krt__kewangan.krt_profile_id as krt_id',
					DB::raw(" concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(kewangan_masa_t_b,'00:00:00'),'%H%i%s')) AS tarikh_kewangan"),
					DB::raw(" date_format(krt__kewangan.kewangan_tarikh_t_b,'%d/%m/%Y') as tarikh"),
					DB::raw(" time_format(IFNULL(kewangan_masa_t_b,'00:00:00'),'%H:%i:%s') as masa"),
					'krt__kewangan.kewangan_jenis_kewangan as jenis',
					'krt__kewangan.kewangan_butiran as butiran',
					'krt__kewangan.kewangan_nama_penuh as nama_penuh',
					'krt__kewangan.kewangan_alamat as alamat',
					'krt__kewangan.kewangan_jumlah_bank as jumlah_bank',
					DB::raw(" semak_baki_bank(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(kewangan_masa_t_b,'00:00:00'),'%H%i%s'))) as baki_bank"),
					'krt__kewangan.kewangan_jumlah_tunai as jumlah_tunai',
					DB::raw(" semak_baki_tunai(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(kewangan_masa_t_b,'00:00:00'),'%H%i%s'))) as baki_tunai"),
					'krt__kewangan.kewangan_status as status',
					'ref__status_krt_kewangan.status_kewangan_description as status_desc')
					->leftJoin('ref__status_krt_kewangan','ref__status_krt_kewangan.id','=','krt__kewangan.kewangan_status')
					->where('krt__kewangan.krt_profile_id','=',Auth::user()->krt_id)
					->whereIn('krt__kewangan.kewangan_status', [1,2,3,4,5,6])
					->whereRaw($var_where)
					->orderBy('tarikh','desc')
					->get();
            return Datatables::of($data)
            ->make(true);
        } else {
			$bulan = $request->input('pmpd_bulan');
			$tahun = $request->input('pmpd_tahun');
            $roles_menu     = DB::table('roles__menu')
                            ->select('roles__menu.id AS id',
                                'users__menu.menu_id AS first_menu',
                                'users__menu.menu2nd_id AS second_menu',
                                'users__menu.users_menu_page_name AS nama_menu',
                                'users__menu.users_menu_file_url AS menu_url',
                                'users__menu.highlight AS highlight_menu',
                                'users__menu.users_menu_page_icon AS icon_menu')
                            ->leftJoin('users__menu','users__menu.id','=','roles__menu.users_menu_id')
                            ->leftJoin('users__roles','users__roles.role_id','=','roles__menu.role_id')
                            ->where('users__roles.user_id', '=', Auth::user()->user_id)
                            ->where('roles__menu.status', '=', true)
                            ->orderBy('first_menu', 'asc')
                            ->orderBy('id', 'asc')
                            ->get();
			$krt_profile	= DB::table('users__profile')
                              ->select('users__profile.id',
                                                    'krt__profile.id AS krt_profile_id',
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
                                                    'ref__pbts.pbt_description AS pbt_krt',
                                                    'krt__profile.krt_bank_nama',
                                                    'krt__profile.krt_bank_no_acc',
                                                    'krt__profile.krt_bank_no_evendor',
                                                    'krt__profile.krt_bank_baki_bank',
                                                    'krt__profile.krt_bank_baki_cash')
                                        ->leftJoin('krt__profile','krt__profile.id','=','users__profile.krt_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                        ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                        ->where('users__profile.user_id', '=', Auth::user()->user_id)  
                                        ->limit(1)
                                        ->first();
										
			$senarai_tkhbulan  = DB::table('krt__kewangan')
							->select(DB::raw(" DISTINCT DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%m') AS bulan_tkhbulan"))
							->where('krt__kewangan.krt_profile_id', '=', Auth::user()->krt_id)
							->orderBy('bulan_tkhbulan', 'asc')
							->get();
							
			$senarai_tkhtahun  = DB::table('krt__kewangan')
							->select(DB::raw(" DISTINCT DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%Y') AS bulan_tkhtahun"))
							->where('krt__kewangan.krt_profile_id', '=', Auth::user()->krt_id)
							->orderBy('bulan_tkhtahun', 'asc')
							->get();
							
			$penyata_count = DB::table('krt__kewangan_penyata')
							 ->selectRaw(' COUNT(krt__kewangan_penyata.id) AS cnt')
							 ->where('krt__kewangan_penyata.krt_profile_id', '=', Auth::user()->krt_id)
							 ->where('krt__kewangan_penyata.bulan','=',Carbon::now()->month)
							 ->where('krt__kewangan_penyata.tahun','=',Carbon::now()->year)
							 //->get();
							 ->limit(1)
                             ->first();
			if($penyata_count->cnt == 0)
			{
				$penyata = DB::table('krt__kewangan_penyata')
							 ->selectRaw(' COUNT(krt__kewangan_penyata.id) AS id')
							 ->where('krt__kewangan_penyata.krt_profile_id', '=', Auth::user()->krt_id)
							 ->where('krt__kewangan_penyata.bulan','=',Carbon::now()->month)
							 ->where('krt__kewangan_penyata.tahun','=',Carbon::now()->year)
							 //->get();
							 ->limit(1)
                             ->first();
			}else
			{
				$penyata = DB::table('krt__kewangan_penyata')
							 ->select('krt__kewangan_penyata.id')
							 ->where('krt__kewangan_penyata.krt_profile_id', '=', Auth::user()->krt_id)
							 ->where('krt__kewangan_penyata.bulan','=',Carbon::now()->month)
							 ->where('krt__kewangan_penyata.tahun','=',Carbon::now()->year)
							 //->get();
							 ->limit(1)
                             ->first();
			} 
            return view('rt-sm7.semakan-rekod-kewangan-rt',compact('roles_menu','krt_profile','senarai_tkhbulan','senarai_tkhtahun','penyata_count','penyata'));
        }
    }

    function semakan_rekod_kewangan_rt_1(Request $request , $id){
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
            $ref_jenis_kewangan     = RefJenisKewangan::where('status', '=', true)->get();
            $rekod_kewangan_rt      = DB::table('krt__kewangan')
                                        ->select('krt__kewangan.id',
                                                    'krt__kewangan.krt_profile_id',
                                                    'krt__profile.krt_nama AS nama_krt',
                                                    'krt__profile.krt_alamat AS alamat_krt',
                                                    'ref__states.state_description AS negeri_krt',
                                                    'ref__parlimens.parlimen_description AS parlimen_krt',
                                                    'ref__pbts.pbt_description AS pbt_krt',
                                                    'ref__daerahs.daerah_description AS daerah_krt',
                                                    'ref__duns.dun_description AS dun_krt', 
                                                    'krt__kewangan.kewangan_jenis_kewangan',
                                                    'krt__profile.krt_bank_nama',
                                                    'krt__profile.krt_bank_no_acc',
                                                    'krt__profile.krt_bank_no_evendor',
                                                    'krt__kewangan.kewangan_nama_penuh',
                                                    'krt__kewangan.kewangan_alamat',
                                                    'krt__kewangan.kewangan_butiran',
                                                    DB::raw(" DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%d/%m/%Y') AS tarikh_t_b"),
													DB::raw(" TIME_FORMAT(IFNULL(kewangan_masa_t_b,'00:00'),'%H:%i') AS masa_t_b"),
													DB::raw(" DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%m') AS tarikh_bulan"),
													DB::raw(" DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%Y') AS tarikh_tahun"),
                                                    'krt__kewangan.kewangan_cek_baucer AS kewangan_cek_baucer',
                                                    DB::raw(" DATE_FORMAT(krt__kewangan.kewangan_tarikh_cek,'%d/%m/%Y') AS tarikh_c_b"),
                                                    'krt__kewangan.kewangan_jumlah_tunai',
                                                    'krt__kewangan.kewangan_jumlah_bank',
													DB::raw(" semak_baki_tunai(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(kewangan_masa_t_b,'00:00:00'),'%H%i%s'))) as kewangan_baki_tunai"),
													DB::raw(" semak_baki_bank(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(kewangan_masa_t_b,'00:00:00'),'%H%i%s'))) as kewangan_baki_bank"),
                                                    //'krt__kewangan.kewangan_baki_tunai',
                                                    //'krt__kewangan.kewangan_baki_bank',
                                                    'krt__kewangan.kewangan_jumlah_baki')
                                        ->leftJoin('krt__profile','krt__profile.id','=','krt__kewangan.krt_profile_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                        ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                        ->where('krt__kewangan.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            return view('rt-sm7.semakan-rekod-kewangan-rt-1', compact('roles_menu','ref_jenis_kewangan','rekod_kewangan_rt'));
        }
    }

    function post_semakan_rekod_kewangan_rt(Request $request){
        $action = $request->post_semakan_rekod_kewangan_rt;
        $app_id = $request->srkr_1_krt_kewangan_id;
        
        
        $rules = array(
            'srkr_1_kewangan_status'             => 'required',
            'srkr_1_semak_noted'                 => 'required',
        );

        $messages = [
            'srkr_1_kewangan_status.required'    => 'Ruangan Status mesti dipilih',
            'srkr_1_semak_noted.required'        => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
				//return \Response::json(array('success' => $request->srkr_1_kewangan_status));
                $where = array('id' => $app_id);
				$pengesahan_rekod_kewangan                       	= KRT_Kewangan::where($where)->first();
				$pengesahan_rekod_kewangan->kewangan_status        	= $request->srkr_1_kewangan_status;
				$pengesahan_rekod_kewangan->semak_noted            	= $request->srkr_1_semak_noted;
				$pengesahan_rekod_kewangan->semakby                	= Auth::user()->user_id;
				$pengesahan_rekod_kewangan->semak_date             	= date('Y-m-d H:i:s');
				$pengesahan_rekod_kewangan->save();
            }
        }
    }

    function pengesahan_rekod_kewangan_rt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
			$v_bulan = $request->bulan;
			$v_tahun = $request->tahun;
			if($request->bulan == "00")
			{
				if($request->tahun == "0000")
				{
					$var_where = " DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%Y%m') between '200001' AND '205012'";
				}else
				{
					$var_where = " DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%Y')='".$v_tahun."'";
				}
			}else
			{
				if($request->tahun == "0000")
				{
					$var_where = " DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%m')='".$v_bulan."'";
				}else
				{
					$var_where = " DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%Y%m') between '".$v_tahun.$v_bulan."' AND '".$v_tahun.$v_bulan."'";
				}
			}
			
            $data = DB::table('krt__kewangan')
					->select('krt__kewangan.id as id','krt__kewangan.krt_profile_id as krt_id',
					DB::raw(" concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(krt__kewangan.kewangan_masa_t_b,'%H%i%s')) AS tarikh_kewangan"),
					DB::raw(" date_format(krt__kewangan.kewangan_tarikh_t_b,'%d/%m/%Y') as tarikh"),
					DB::raw(" time_format(IFNULL(krt__kewangan.kewangan_masa_t_b,'00:00'),'%H:%i:%s') as masa"),
					'krt__kewangan.kewangan_jenis_kewangan as jenis',
					'krt__kewangan.kewangan_butiran as butiran',
					'krt__kewangan.kewangan_nama_penuh as nama_penuh',
					'krt__kewangan.kewangan_alamat as alamat',
					'krt__kewangan.kewangan_jumlah_bank as jumlah_bank',
					DB::raw(" semak_baki_bank(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(krt__kewangan.kewangan_masa_t_b,'00:00'),'%H%i%s'))) as baki_bank"),
					'krt__kewangan.kewangan_jumlah_tunai as jumlah_tunai',
					DB::raw(" semak_baki_tunai(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(krt__kewangan.kewangan_masa_t_b,'00:00'),'%H%i%s'))) as baki_tunai"),
					'krt__kewangan.kewangan_status as status',
					'ref__status_krt_kewangan.status_kewangan_description as status_desc')
					->leftJoin('ref__status_krt_kewangan','ref__status_krt_kewangan.id','=','krt__kewangan.kewangan_status')
                    ->whereIn('krt__kewangan.kewangan_status', [1,2,3,4,5,6])
					->where('krt__kewangan.krt_profile_id','=',$request->krt_id)
					->whereRaw($var_where)
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
					->orderBy('krt__profile.krt_nama', 'asc')
                    ->get();
					
							
            return view('rt-sm7.pengesahan-rekod-kewangan-rt', compact('roles_menu','krt'));
        }
    }
	
	function pengesahan_rekod_kewangan_rt_trx(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
			$v_bulan = $request->bulan;
			$v_tahun = $request->tahun;
			if($request->bulan == "00")
			{
				if($request->tahun == "0000")
				{
					$var_where = " DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%Y%m') between '200001' AND '205012'";
				}else
				{
					$var_where = " DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%Y')='".$v_tahun."'";
				}
			}else
			{
				if($request->tahun == "0000")
				{
					$var_where = " DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%m')='".$v_bulan."'";
				}else
				{
					$var_where = " DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%Y%m') between '".$v_tahun.$v_bulan."' AND '".$v_tahun.$v_bulan."'";
				}
			}
			
            $data = DB::table('krt__kewangan')
					->select('krt__kewangan.id as id','krt__kewangan.krt_profile_id as krt_id',
					DB::raw(" concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(krt__kewangan.kewangan_masa_t_b,'00:00:00'),'%H%i%s')) AS tarikh_kewangan"),
					DB::raw(" date_format(krt__kewangan.kewangan_tarikh_t_b,'%d/%m/%Y') as tarikh"),
					DB::raw(" time_format(IFNULL(krt__kewangan.kewangan_masa_t_b,'00:00:00'),'%H:%i:%s') as masa"),
					'krt__kewangan.kewangan_jenis_kewangan as jenis',
					'krt__kewangan.kewangan_butiran as butiran',
					'krt__kewangan.kewangan_nama_penuh as nama_penuh',
					'krt__kewangan.kewangan_alamat as alamat',
					'krt__kewangan.kewangan_jumlah_bank as jumlah_bank',
					DB::raw(" semak_baki_bank(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(krt__kewangan.kewangan_masa_t_b,'00:00:00'),'%H%i%s'))) as baki_bank"),
					'krt__kewangan.kewangan_jumlah_tunai as jumlah_tunai',
					DB::raw(" semak_baki_tunai(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(krt__kewangan.kewangan_masa_t_b,'00:00:00'),'%H%i%s'))) as baki_tunai"),
					'krt__kewangan.kewangan_status as status',
					'ref__status_krt_kewangan.status_kewangan_description as status_desc',
					'kewangan_dokumen_cek.kewangan_cek_baucer AS no_cek',
					DB::raw(" DATE_FORMAT(kewangan_dokumen_cek.kewangan_tarikh_cek,'%d/%m/%Y') AS tarikh_cek"),
					'kewangan_dokumen_baucer.kewangan_cek_baucer AS no_baucer',
					DB::raw(" DATE_FORMAT(kewangan_dokumen_baucer.kewangan_tarikh_cek,'%d/%m/%Y') AS tarikh_baucer"),
					'kewangan_dokumen_resit.kewangan_cek_baucer AS no_resit',
					DB::raw(" DATE_FORMAT(kewangan_dokumen_resit.kewangan_tarikh_cek,'%d/%m/%Y') AS tarikh_resit"))
					->leftJoin('ref__status_krt_kewangan','ref__status_krt_kewangan.id','=','krt__kewangan.kewangan_status')
					->leftJoin('kewangan_dokumen_cek','kewangan_dokumen_cek.kewangan_id','=','krt__kewangan.id')
					->leftJoin('kewangan_dokumen_baucer','kewangan_dokumen_baucer.kewangan_id','=','krt__kewangan.id')
					->leftJoin('kewangan_dokumen_resit','kewangan_dokumen_resit.kewangan_id','=','krt__kewangan.id')
                    ->whereIn('krt__kewangan.kewangan_status', [1,2,3,4,5,6])
					->where('krt__kewangan.krt_profile_id','=',$request->krt_id)
					->whereRaw($var_where)
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
							
            $krt = KRT_Profile::where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)
                    ->where('krt__profile.krt_status', '=', 1)
                    ->get();
					
            return view('rt-sm7.pengesahan-rekod-kewangan-rt', compact('roles_menu','krt'));
        }
    }
	
	function get_senarai_penyata(Request $request){
			$v_krt = $request->krt_id;
			$v_bulan = $request->bulan;
			$v_tahun = $request->tahun;			
            $data = DB::table('krt__kewangan_penyata')
            		->select('krt__kewangan_penyata.krt_profile_id',
                    'krt__kewangan_penyata.bulan as bulan',
                    'krt__kewangan_penyata.tahun AS tahun',
					'krt__kewangan_penyata.fail_penyata AS fail')
					->where('krt__kewangan_penyata.krt_profile_id','=',$v_krt)
					->where('krt__kewangan_penyata.bulan','=',$v_bulan)
					->where('krt__kewangan_penyata.tahun','=',$v_tahun)
                    ->get();
           	return Datatables::of($data)
           	->make(true);
    }
	
	function get_senarai_dokumen(Request $request){
			$v_krt = $request->krt;
			$v_id = $request->kew_id;			
            $data = DB::table('krt__kewangan_dokumen')
            		->select('krt__kewangan_dokumen.id',
                    'krt__kewangan_dokumen.krt_profile_id',
                    'krt__kewangan_dokumen.kewangan_id AS kewangan_id',
					'krt__kewangan_dokumen.jenis AS jenis',
					'krt__kewangan_dokumen.butiran AS butiran',
                    'krt__kewangan_dokumen.fail_dokumen AS fail_dokumen',
					'krt__kewangan_dokumen.kewangan_cek_baucer AS no_dokumen',
					DB::raw(" DATE_FORMAT(krt__kewangan_dokumen.kewangan_tarikh_cek,'%d/%m/%Y') as tarikh_dokumen"))
					->where('krt__kewangan_dokumen.kewangan_id','=',$v_id)
                    ->get();
           	return Datatables::of($data)
           	->make(true);
    }

    function pengesahan_rekod_kewangan_rt_1(Request $request , $id){
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
            $ref_jenis_kewangan     = RefJenisKewangan::where('status', '=', true)->get();
            $rekod_kewangan_rt      = DB::table('krt__kewangan')
                                        ->select('krt__kewangan.id',
                                                    'krt__kewangan.krt_profile_id',
                                                    'krt__profile.krt_nama AS nama_krt',
                                                    'krt__profile.krt_alamat AS alamat_krt',
                                                    'ref__states.state_description AS negeri_krt',
                                                    'ref__parlimens.parlimen_description AS parlimen_krt',
                                                    'ref__pbts.pbt_description AS pbt_krt',
                                                    'ref__daerahs.daerah_description AS daerah_krt',
                                                    'ref__duns.dun_description AS dun_krt', 
                                                    'krt__kewangan.kewangan_jenis_kewangan',
                                                    'krt__profile.krt_bank_nama',
                                                    'krt__profile.krt_bank_no_acc',
                                                    'krt__profile.krt_bank_no_evendor',
                                                    'krt__kewangan.kewangan_nama_penuh',
                                                    'krt__kewangan.kewangan_alamat',
                                                    'krt__kewangan.kewangan_butiran',
                                                    DB::raw(" DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%d/%m/%Y') AS tarikh_t_b"),
                                                    'krt__kewangan.kewangan_cek_baucer AS kewangan_cek_baucer',
                                                    DB::raw(" DATE_FORMAT(krt__kewangan.kewangan_tarikh_cek,'%d/%m/%Y') AS tarikh_c_b"),
													DB::raw(" DATE_FORMAT(krt__kewangan.kewangan_tarikh_cek,'%m') AS tarikh_bulan"),
													DB::raw(" DATE_FORMAT(krt__kewangan.kewangan_tarikh_cek,'%Y') AS tarikh_tahun"),
                                                    'krt__kewangan.kewangan_jumlah_tunai',
                                                    'krt__kewangan.kewangan_jumlah_bank',
                                                    'krt__kewangan.kewangan_baki_tunai',
                                                    'krt__kewangan.kewangan_baki_bank',
                                                    'krt__kewangan.kewangan_jumlah_baki' )
                                        ->leftJoin('krt__profile','krt__profile.id','=','krt__kewangan.krt_profile_id')
                                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                        ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                        ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                        ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                        ->where('krt__kewangan.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
            return view('rt-sm7.pengesahan-rekod-kewangan-rt-1', compact('roles_menu','ref_jenis_kewangan','rekod_kewangan_rt'));
        }
    }

    function post_pengesahan_rekod_kewangan_rt(Request $request){
        $action = $request->post_pengesahan_rekod_kewangan_rt;
        $app_id = $request->prkr_1_krt_kewangan_id;
        $krt_profile_id = $request->prkr_1_krt_profile_id;
        
        $rules = array(
            'prkr_1_kewangan_status'             => 'required',
            'prkr_1_sahkan_noted'                => 'required',
        );

        $messages = [
            'prkr_1_kewangan_status.required'    => 'Ruangan Status mesti dipilih',
            'prkr_1_sahkan_noted.required'       => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $pengesahan_rekod_kewangan                         = KRT_Kewangan::where($where)->first();
                $pengesahan_rekod_kewangan->kewangan_status        = $request->prkr_1_kewangan_status;
                $pengesahan_rekod_kewangan->sah_noted              = $request->prkr_1_sahkan_noted;
                $pengesahan_rekod_kewangan->sahby                  = Auth::user()->user_id;
                $pengesahan_rekod_kewangan->sah_date               = date('Y-m-d H:i:s');
                $pengesahan_rekod_kewangan->save();

                $where1 = array('id' => $krt_profile_id);
                $pengesahan_rekod_kewangan                         = KRT_Profile::where($where1)->first();
                $pengesahan_rekod_kewangan->krt_bank_baki_cash     = $request->prkr_1_kewangan_baki_tunai;
                $pengesahan_rekod_kewangan->krt_bank_baki_bank     = $request->prkr_1_kewangan_baki_bank;
                $pengesahan_rekod_kewangan->save();
            }
        }
    }

    function senarai_rekod_kewangan_rt_diluluskan(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('krt__kewangan')
                        ->select('krt__kewangan.id',
                                'krt__kewangan.kewangan_butiran AS kewangan_butiran',
                                DB::raw(" DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%d/%m/%Y') AS tarikh_t_b"),
                                'krt__kewangan.kewangan_cek_baucer AS kewangan_cek_baucer',
                                DB::raw(" DATE_FORMAT(krt__kewangan.kewangan_tarikh_cek,'%d/%m/%Y') AS tarikh_c_b"),
                                'ref__jenis_kewangan.jenis_kewangan_description AS kewangan_jenis',
                                'ref__status_krt_kewangan.status_kewangan_description',
                                'krt__kewangan.kewangan_jenis_kewangan')
                        ->leftJoin('ref__jenis_kewangan','ref__jenis_kewangan.id','=','krt__kewangan.kewangan_jenis_kewangan')
                        ->leftJoin('ref__status_krt_kewangan','ref__status_krt_kewangan.id','=','krt__kewangan.kewangan_status')
                        ->orderBy('krt__kewangan.id', 'asc')
                        ->whereIn('krt__kewangan.kewangan_status', [1])
                        ->where('krt__kewangan.direkodby', '=', Auth::user()->user_id)
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
            return view('rt-sm7.senarai-rekod-kewangan-rt-diluluskan',compact('roles_menu'));
        }
    }

    function laporan_kewangan_rt(Request $request){
        if($request->ajax())
		{ 
			$type = $request->type;
			if($type == 'get_daerah')
			{
				$value = $request->value;
            	$where = array('state_id' => $value);
            	$data  = RefDaerah::where($where)->get();
            	return Response::json($data);
			}else
			{
				if($type == 'get_krt')
				{
					$value = $request->value;
					$where = array('daerah_id' => $value);
					$data  = KRT_Profile::where($where)
							->where('krt__profile.krt_status', '=',  true)
							->orderBy('krt__profile.krt_nama','asc')
							->get();
					return Response::json($data);
				}else
				{
					if($type == 'get_infokrt')
					{
						$value = $request->value;
						$where = array('id' => $value);
						$data  = KRT_Profile::where($where)
								->where('krt__profile.krt_status', '=',  true)
								->get();
						return Response::json($data);
					}else
					{
						$v_bulan = $request->bulan;
						$v_tahun = $request->tahun;
						$v_krt = $request->krt;
				
						if($request->bulan == "00")
						{
							if($request->tahun == "0000")
							{
								$var_where = " DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%Y%m') between '200001' AND '205012'";
							}else
							{
								$var_where = " DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%Y')='".$v_tahun."'";
							}
						}else
						{
							if($request->tahun == "0000")
							{
								$var_where = " DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%m')='".$v_bulan."'";
							}else
							{
								$var_where = " DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%Y%m') between '".$v_tahun.$v_bulan."' AND '".$v_tahun.$v_bulan."'";
							}
						}
						$data = DB::table('krt__kewangan')
								->select('krt__kewangan.id',
								DB::raw("concat(DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),TIME_FORMAT(krt__kewangan.kewangan_masa_t_b,'%H%i%s')) AS tarikh_kewangan"),
								'krt__kewangan.kewangan_butiran AS kewangan_butiran',
								DB::raw("DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%d/%m/%Y') AS tarikh_t_b"),
								'kewangan_dokumen_cek.kewangan_cek_baucer AS no_cek',
								DB::raw("DATE_FORMAT(kewangan_dokumen_cek.kewangan_tarikh_cek,'%d/%m/%Y') AS tarikh_cek"),
								'kewangan_dokumen_cek.fail_dokumen AS nama_fail_cek',
								'kewangan_dokumen_resit.kewangan_cek_baucer AS no_resit',
								DB::raw("DATE_FORMAT(kewangan_dokumen_resit.kewangan_tarikh_cek,'%d/%m/%Y') AS tarikh_resit"),
								'kewangan_dokumen_resit.fail_dokumen AS nama_fail_resit',
								'kewangan_dokumen_baucer.kewangan_cek_baucer AS no_baucer',
								DB::raw("DATE_FORMAT(kewangan_dokumen_baucer.kewangan_tarikh_cek,'%d/%m/%Y') AS tarikh_baucer"),
								'kewangan_dokumen_baucer.fail_dokumen AS nama_fail_baucer',
								DB::raw("CASE WHEN krt__kewangan.kewangan_jenis_kewangan = 1 THEN format(krt__kewangan.kewangan_jumlah_tunai,2) ELSE 0.00 END AS terima_tunai"),
								DB::raw("CASE WHEN krt__kewangan.kewangan_jenis_kewangan = 1 THEN format(krt__kewangan.kewangan_jumlah_bank,2) ELSE 0.00 END AS terima_bank"),
								DB::raw("CASE WHEN krt__kewangan.kewangan_jenis_kewangan = 2 THEN format(krt__kewangan.kewangan_jumlah_tunai,2) ELSE 0.00 END AS bayar_tunai"),
								DB::raw("CASE  WHEN krt__kewangan.kewangan_jenis_kewangan = 2 THEN format(krt__kewangan.kewangan_jumlah_bank,2) ELSE 0.00 END AS bayar_bank"),
								DB::raw(" format(semak_baki_tunai_sah(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(krt__kewangan.kewangan_masa_t_b,'00:00:00'),'%H%i%s'))),2) as kewangan_baki_tunai"),
								DB::raw(" format(semak_baki_bank_sah(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(krt__kewangan.kewangan_masa_t_b,'00:00:00'),'%H%i%s'))),2) as kewangan_baki_bank"),
								DB::raw(" format((semak_baki_tunai_sah(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(krt__kewangan.kewangan_masa_t_b,'00:00:00'),'%H%i%s'))) + semak_baki_bank_sah(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(krt__kewangan.kewangan_masa_t_b,'00:00:00'),'%H%i%s')))),2) AS kewangan_jumlah_baki"))
								->leftJoin('kewangan_dokumen_cek','kewangan_dokumen_cek.kewangan_id','=','krt__kewangan.id')
								->leftJoin('kewangan_dokumen_resit','kewangan_dokumen_resit.kewangan_id','=','krt__kewangan.id')
								->leftJoin('kewangan_dokumen_baucer','kewangan_dokumen_baucer.kewangan_id','=','krt__kewangan.id')
								->where('krt__kewangan.krt_profile_id', '=', $v_krt)
								->where('krt__kewangan.kewangan_status', '=', 1)
									// ->whereRaw("DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b, '%Y') = '" . $request->tahun ."'")
									// ->whereRaw("DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b, '%m') = '" . $request->bulan ."'")
								->whereRaw($var_where)
								->get();		
						return Datatables::of($data)
						->make(true);
					}
				}
			}
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
							
            $krt     = DB::table('krt__profile')
                            ->select('krt__profile.id AS id',
                                'krt__profile.krt_nama AS krt_nama',
                                'krt__profile.krt_bank_no_acc as bank_no_acc',
                                'krt__profile.krt_bank_nama AS bank_nama',
                                'krt__profile.krt_bank_no_evendor AS no_evendor',
                                'ref__daerahs.daerah_description AS daerah',
                                'ref__states.state_description AS state')
                            ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                            ->where('krt__profile.id', '=', Auth::user()->krt_id)
                            ->limit(1)
                            ->first();
							
			$krt_kewangan  = DB::table('krt__kewangan')
                            ->select('krt__kewangan.id AS id',
								DB::Raw(" concat(DATE_FORMAT(kewangan_tarikh_t_b,'%Y%m%d'),TIME_FORMAT(IFNULL(kewangan_masa_t_b,'00:00:00'),'%H%i')) AS tarikh_kewangan"),
							    DB::raw("DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%m') AS kew_bulan"),
                                DB::raw("DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%Y') AS kew_tahun"),
                                'krt__kewangan.kewangan_jenis_kewangan as kew_jenis',
                                'krt__kewangan.kewangan_jumlah_tunai AS kew_tunai',
								'krt__kewangan.kewangan_jumlah_bank AS kew_bank')
                            ->where('krt__kewangan.krt_profile_id', '=', Auth::user()->krt_id)
							->where('krt__kewangan.kewangan_status','=',1)
							->orderByRaw(" concat(DATE_FORMAT(kewangan_tarikh_t_b,'%Y%m%d'),TIME_FORMAT(IFNULL(kewangan_masa_t_b,'00:00:00'),'%H%i'))")
                            ->get();
			$state = DB::table('ref__states')
					 ->select('state_id',
					 'state_description')
					 ->orderBy('state_description')
					 ->get();
            return view('rt-sm7.laporan-kewangan-rt',compact('roles_menu','krt','krt_kewangan','state'));
        }
    }
	
	function post_add_dokumen(Request $request){
		
        $rules = array(
			'mag_file_jenis'	          	  => 'required',
			'mag_butiran'	          	  	  => 'required',
            'mag_file_dokumen'                => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:5000',
			'arkr_kewangan_cek_baucer'        => 'required',
			'arkr_kewangan_tarikh_cek'        => 'required',
        );

        $messages = [
			'mag_file_jenis.required'    	         => 'Ruangan Jenis Dokumen mesti dipilih',
            'mag_butiran.required'      	         => 'Ruangan Butiran Dokumen Mesti diisi',
			'mag_file_dokumen.required'              => 'Ruangan Fail Mesti Dipilih',
            'mag_file_dokumen.mimes'                 => 'Fail Mesti Dipilih Dalam Format jpeg,png,jpg,gif,svg,pdf',
            'mag_file_dokumen.max'                   => 'Fail mesti dalam sive 5000KB',
			'arkr_kewangan_cek_baucer.required'      => 'Ruangan ini Mesti Diisi',
			'arkr_kewangan_tarikh_cek.required'      => 'Ruangan Ini Mesti Diisi',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) 
		{
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else 
		{
			
			if($request->mag_dokumen_kewangan_id == "0" || $request->mag_dokumen_kewangan_id == "")
			{
					$rekod_kewangan								= new KRT_Kewangan;
					$rekod_kewangan->krt_profile_id    			= $request->mag_dokumen_krt_id;
					if($request->arkr_kewangan_jenis_kewangan == 1 || $request->arkr_kewangan_jenis_kewangan == 2)
					{
						$rekod_kewangan->kewangan_jenis_kewangan	= $request->arkr_kewangan_jenis_kewangan;
					}
					$rekod_kewangan->kewangan_nama_penuh		= $request->arkr_kewangan_nama_penuh;
					$rekod_kewangan->kewangan_alamat			= $request->arkr_kewangan_alamat;
					$rekod_kewangan->kewangan_butiran			= $request->arkr_kewangan_butiran;
					$rekod_kewangan->kewangan_tarikh_t_b		= Carbon::createFromFormat('d/m/Y', $request->arkr_kewangan_tarikh_t_b)->format('Y-m-d');
					$rekod_kewangan->kewangan_masa_t_b		    = $request->arkr_kewangan_time_t_b;
					$rekod_kewangan->kewangan_jumlah_tunai		= $request->arkr_kewangan_jumlah_tunai;
					$rekod_kewangan->kewangan_jumlah_bank		= $request->arkr_kewangan_jumlah_bank;
					$rekod_kewangan->kewangan_status			= 4;
					$rekod_kewangan->direkodby					= Auth::user()->user_id;
					$rekod_kewangan->save();
					
					$next_id=$rekod_kewangan->id;
					
					$rekod_dokumen                     			= new KRT_Kewangan_Dokumen;
					$rekod_dokumen->krt_profile_id    			= $request->mag_dokumen_krt_id;
					$rekod_dokumen->kewangan_id    			 	= $next_id;
					$rekod_dokumen->jenis				        = $request->mag_file_jenis;
					$rekod_dokumen->butiran				        = $request->mag_butiran;
					$rekod_dokumen->kewangan_cek_baucer		    = $request->arkr_kewangan_cek_baucer;
					$rekod_dokumen->kewangan_tarikh_cek		    = Carbon::createFromFormat('d/m/Y', $request->arkr_kewangan_tarikh_cek)->format('Y-m-d');
					$rekod_dokumen->fail_dokumen		        = "";
					$rekod_dokumen->created_at                  = date('Y-m-d H:i:s');
					$rekod_dokumen->updated_at                  = date('Y-m-d H:i:s');
					$rekod_dokumen->save();
					
					$next_dokid=$rekod_dokumen->id;
					
					$fileName = "krt_" . $request->mag_dokumen_krt_id . "_" . $next_id . "_" . $next_dokid . "_" . $request->mag_file_dokumen->getClientOriginalName();
            		$request->mag_file_dokumen->storeAs('public/dokumen_kewangan',$fileName);
					
					$values=array('fail_dokumen'=>$fileName,'updated_at'=>date('Y-m-d H:i:s'));
					KRT_Kewangan_Dokumen::where('id', $next_dokid)
      				->update($values);
					
					return \Response::json(array('success' => $next_id));
			}else
			{
					$rekod_dokumen                     			= new KRT_Kewangan_Dokumen;
					$rekod_dokumen->krt_profile_id    			= $request->mag_dokumen_krt_id;
					$rekod_dokumen->kewangan_id    			 	= $request->mag_dokumen_kewangan_id;
					$rekod_dokumen->jenis				        = $request->mag_file_jenis;
					$rekod_dokumen->butiran				        = $request->mag_butiran;
					$rekod_dokumen->kewangan_cek_baucer		    = $request->arkr_kewangan_cek_baucer;
					$rekod_dokumen->kewangan_tarikh_cek		    = Carbon::createFromFormat('d/m/Y', $request->arkr_kewangan_tarikh_cek)->format('Y-m-d');
					$rekod_dokumen->fail_dokumen		        = "";
					$rekod_dokumen->created_at                  = date('Y-m-d H:i:s');
					$rekod_dokumen->updated_at                  = date('Y-m-d H:i:s');
					$rekod_dokumen->save();
			
					$next_dokid=$rekod_dokumen->id;
					
					$fileName = "krt_" . $request->mag_dokumen_krt_id . "_" . $request->mag_dokumen_kewangan_id . "_" . $next_dokid . "_" . $request->mag_file_dokumen->getClientOriginalName();
            		$request->mag_file_dokumen->storeAs('public/dokumen_kewangan',$fileName);
					
					$values=array('fail_dokumen'=>$fileName,'updated_at'=>date('Y-m-d H:i:s'));
					KRT_Kewangan_Dokumen::where('id', $next_dokid)
      				->update($values);
					
					return \Response::json(array('success' => $request->mag_dokumen_kewangan_id));
			}
			return \Response::json(array('success' => $request->mag_dokumen_kewangan_id));
        }
    }
	
	function post_add_penyata(Request $request){
		
        $rules = array(
			'carian_bulan'	          	  	  => 'required',
			'carian_tahun'	          	  	  => 'required',
            'mag_file_dokumen'                => 'required|mimes:jpeg,png,jpg,gif,svg|max:5000',
        );

        $messages = [
			'carian_bulan.required'    	 => 'Ruangan Bulan mesti dipilih',
            'carian_tahun.required'      	 => 'Ruangan Tahun mesti dipilih',
			'mag_file_dokumen.required'  => 'Ruangan Fail Penyata Mesti Dipilih',
            'mag_file_dokumen.mimes'     => 'Fail Mesti Dipilih Dalam Format jpeg,png,jpg,gif,svg',
            'mag_file_dokumen.max'       => 'Fail mesti dalam sive 5000KB',
        ];

		
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) 
		{
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else 
		{
			//$id=DB::select("SHOW TABLE STATUS LIKE 'KRT__Kewangan_Penyata'");
			//$next_id=$id[0]->Auto_increment;
			$fileName = "krtpenyata_" . $request->mag_krt_id . "_" . $request->carian_bulan.$request->carian_tahun . "_" . $request->mag_file_dokumen->getClientOriginalName();
			$request->mag_file_dokumen->storeAs('public/dokumen_kewangan',$fileName);
			
			if($request->mag_id == "0" || $request->mag_id == "")
			{
				$rekod_penyata                     			= new KRT_Kewangan_Penyata;
				$rekod_penyata->krt_profile_id    			= $request->mag_krt_id;
				$rekod_penyata->bulan				        = $request->carian_bulan;
				$rekod_penyata->tahun				        = $request->carian_tahun;
				$rekod_penyata->fail_penyata		        = $fileName;
				$rekod_penyata->created_at                  = date('Y-m-d H:i:s');
				$rekod_penyata->updated_at                  = date('Y-m-d H:i:s');
				$rekod_penyata->save();
				$next_id=$rekod_penyata->id;
				$ret_arr=array(
					'dok_id' => $next_id,
					'filename' => $fileName,
				);
			}else
			{
				$values=array('fail_penyata'=>$fileName,'updated_at'=>date('Y-m-d H:i:s'));
				KRT_Kewangan_Penyata::where('id', $request->mag_id)
      			->update($values);
				$ret_arr=array(
					'dok_id' =>$request->mag_id,
					'filename' => $fileName,
				);
				return \Response::json(array('success' => $ret_arr));
			}
			return \Response::json(array('success' => $ret_arr));
			/*
			
			$fileName = "krtpenyata_" . $request->mag_krt_id . "_" . $request->pmpd_bulan.$request->pmpd_tahun . "_" . $request->mag_file_dokumen->getClientOriginalName();
			$request->mag_file_dokumen->storeAs('public/dokumen_kewangan',$fileName);
			
			$ret_arr=array(
				'dok_id' =>$request->mag_id,
				'filename' => $fileName,
			);
			return \Response::json(array('success' => $ret_arr));
			
			/*if($request->mag_id == "0" )
			{
				$id=DB::select("SHOW TABLE STATUS LIKE 'KRT__Kewangan_Penyata'");
				$next_id=$id[0]->Auto_increment;
				$rekod_penyata                     			= new KRT_Kewangan_Penyata;
				$rekod_penyata->id							= $next_id;
				$rekod_penyata->krt_profile_id    			= $request->mag_krt_id;
				$rekod_penyata->bulan				        = $request->pmpd_bulan;
				$rekod_penyata->tahun				        = $request->pmpd_tahun;
				$rekod_penyata->fail_penyata		        = $fileName;
				$rekod_penyata->created_at                  = date('Y-m-d H:i:s');
				$rekod_penyata->updated_at                  = date('Y-m-d H:i:s');
				$rekod_penyata->save();
				$ret_arr=array(
					'dok_id' =>$next_id,
					'filename' => $fileName,
				);
				return \Response::json(array('success' => $ret_arr));
			}else
			{
				//$where = array('id' => $request->mag_id);
				//$where=array();
				//$where[] = ['krt_profile_id', '=', $request->mag_krt_id];
				//$where[] = ['bulan', '=', $request->pmpd_bulan];
				//$where[] = ['tahun', '=', $request->pmpd_tahun];
				//$rekod_kewangan                              = KRT_Kewangan_Penyata::where($where)->first();
				//$rekod_penyata->fail_penyata		        = $fileName;
				//$rekod_penyata->created_at                  = date('Y-m-d H:i:s');
				//$rekod_penyata->updated_at                  = date('Y-m-d H:i:s');
				//$rekod_penyata->save();
				
				/*$values=array('fail_penyata'=>$fileName,'updated_at'=>date('Y-m-d H:i:s'));
				KRT_Kewangan_Penyata::where('id', $request->mag_id)
      			->update($values);
				$ret_arr=array(
					'dok_id' =>$request->mag_id,
					'filename' => $fileName,
				);
				return \Response::json(array('success' => $ret_arr));
			}*/
        }
    }
	
	function get_penyata(Request $request){
		$vbulan = $request->carian_bulan;
		$vtahun = $request->carian_tahun;
							
		$count2 = DB::table('krt__kewangan_penyata')
				->where('krt__kewangan_penyata.krt_profile_id', '=', Auth::user()->krt_id)
				->where('krt__kewangan_penyata.tahun', '=', $vtahun)
				->where('krt__kewangan_penyata.bulan','=',$vbulan)
				->count(); 
				
		/*$penyata_id = DB::table('krt__kewangan_penyata')
					->select(DB::raw('krt_kewangan_penyata.id as id'))
					->where('krt__kewangan_penyata.krt_profile_id', '=', Auth::user()->krt_id)
					->where('krt__kewangan_penyata.tahun','=',$vtahun)
					->where('krt__kewangan_penyata.bulan','=',$vbulan)
					->limit(1)
					->first();*/
		if($count2 > 0)
		{
			$penyata = DB::table('krt__kewangan_penyata')
					->select('id',
					'fail_penyata')
					->where('krt_profile_id', '=', Auth::user()->krt_id)
					->where('tahun','=',$vtahun)
					->where('bulan','=',$vbulan)
					->first();
			return \Response::json(array('success' => $penyata));
		}else
		{
			$penyata=array(
				'id' => "0",
				'fail_penyata' => "",
				);
			return \Response::json(array('success' => $penyata));
		}
		//return \Response::json(array('success' => $count2));
    }
	
	function get_krt_kewangan(Request $request){
		$vkrt_id = $request->prkpd_krt_id;
		$vbulan = $request->lkr_bulan;
		$vtahun = $request->lkr_tahun;
		$penyata = DB::table('krt__profile')
					->select('id',
					'krt_nama',
					'krt_alamat',
					'krt_bank_nama',
					'krt_bank_no_acc',
					DB::raw(" get_penyata(".$vkrt_id.",'".$vbulan."','".$vtahun."') AS file_penyata"),
					'krt_bank_no_evendor')
					->where('id', '=', $vkrt_id)
					->first();
		return \Response::json(array('success' => $penyata));
    }
	
	function post_hantarppd_rekod_kewangan_rt(Request $request){
		
        $rules = array(
			'srkr_1_semak_noted'	          	  	  => 'required',
        );

        $messages = [
			'srkr_1_semak_noted.required'    	 => 'Ruangan penerangan mesti diisi',
        ];
		
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) 
		{
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else 
		{
				$values=array('kewangan_status'=>3,'updated_at'=>date('Y-m-d H:i:s'));
				KRT_Kewangan::where('krt_profile_id','=',$request->mag_krt_id)
				->where('kewangan_status','=',6)
				->whereRaw("DATE_FORMAT(kewangan_tarikh_t_b,'%m')=? and DATE_FORMAT(kewangan_tarikh_t_b,'%Y')=?",[$request->data_bulan,$request->data_tahun])
				->update($values);
				return \Response::json(array('success' => 1));
        }
    }
	
	function post_ppdsah_rekod_kewangan_rt(Request $request){
		$vkew_id = $request->mag_kew_id;
		$vkew_status = $request->mag_kew_status;
		$vkew_noted = $request->mag_kew_noted;
		$values=array('kewangan_status'=>$vkew_status,'semak_noted'=>$vkew_noted,'updated_at'=>date('Y-m-d H:i:s'));
		KRT_Kewangan::where('id','=',$vkew_id)
		->update($values);
		return \Response::json(array('success' => $vkew_status));
    }
	
	function delete_kewangan($id){
        $data = DB::table('krt__kewangan')->where('id', '=', $id)->delete();
		$data_dok = DB::table('krt__kewangan_dokumen')->where('kewangan_id', '=', $id)->get();
		foreach($data_dok as $dok)
     	{
			$filename = $dok->fail_dokumen;
			$file_path = public_path().'/storage/dokumen_kewangan/'.$filename;
			unlink($file_path);
     	}
		$data = DB::table('krt__kewangan_dokumen')->where('kewangan_id', '=', $id)->delete();
    }
	
	function delete_dokumen(Request $request, $id){
		$filename = $request->filename;
		$data = DB::table('krt__kewangan_dokumen')->where('id', '=', $id)->delete();
		$file_path = public_path().'/storage/dokumen_kewangan/'.$filename;
		unlink($file_path);
		//return response()->json(public_path());
    }
	
	public function get_excel_file(Request $request, $id)
    {
		$data_extract = DB::table('krt__kewangan')
        ->select(
            'krt__kewangan.id AS id',
            'krt__kewangan.kewangan_jenis_kewangan AS jenis',
            'krt__kewangan.kewangan_butiran AS butiran',
            'krt__kewangan.kewangan_alamat AS alamat',
            'krt__kewangan.kewangan_nama_penuh AS nama',
            DB::raw("DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b, '%d/%m/%Y') AS tarikh_t_b"),
            DB::raw("GROUP_CONCAT(CONCAT(CASE 
                                            WHEN jenis = 1 THEN 'No. Baucer :'
                                            WHEN jenis = 2 THEN 'No. Cek :'
                                            ELSE 'No. Resit : '
                                        END, ' ', krt__kewangan_dokumen.kewangan_cek_baucer, ' ', '(', krt__kewangan_dokumen.kewangan_tarikh_cek, ')', ',') ) AS dokumen_sokongan"),
            DB::raw("CASE WHEN krt__kewangan.kewangan_jenis_kewangan = 1 THEN krt__kewangan.kewangan_jumlah_tunai ELSE '0' END AS terima_tunai"),
            DB::raw("CASE WHEN krt__kewangan.kewangan_jenis_kewangan = 1 THEN krt__kewangan.kewangan_jumlah_bank ELSE '0' END AS terima_bank"),
            DB::raw("CASE WHEN krt__kewangan.kewangan_jenis_kewangan = 2 THEN krt__kewangan.kewangan_jumlah_tunai ELSE '0' END AS bayar_tunai"),
            DB::raw("CASE WHEN krt__kewangan.kewangan_jenis_kewangan = 2 THEN krt__kewangan.kewangan_jumlah_bank ELSE '0' END AS bayar_bank"),
            'krt__kewangan.kewangan_baki_tunai AS kewangan_baki_tunai',
            'krt__kewangan.kewangan_baki_bank AS kewangan_baki_bank'
        )
        ->leftJoin('krt__kewangan_dokumen', 'krt__kewangan_dokumen.kewangan_id', '=', 'krt__kewangan.id')
        ->where('krt__kewangan.krt_profile_id', '=', $id)
        ->where('krt__kewangan.kewangan_status', '=', 1)
        ->groupBy('krt__kewangan.id')
        ->orderBy('krt__kewangan.kewangan_tarikh_t_b', 'ASC')
        ->get();
        return Excel::download(new Laporan_Kewangan($data_extract), 'kewangan_file.xlsx');
    }
	
	public function get_excel_file2(Request $request, $krt, $bulan, $tahun)
    {
		$v_bulan = $bulan;
		$v_tahun = $tahun;
		$v_krt = $krt;
				
		if($request->bulan == "00")
		{
			if($request->tahun == "0000")
			{
				$var_where = " DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%Y%m') between '200001' AND '205012'";
			}else
			{
				$var_where = " DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%Y')='".$v_tahun."'";
			}
		}else
		{
			if($request->tahun == "0000")
			{
				$var_where = " DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%m')='".$v_bulan."'";
			}else
			{
				$var_where = " DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%Y%m') between '".$v_tahun.$v_bulan."' AND '".$v_tahun.$v_bulan."'";
			}
		}
		$laporan_kewangan = DB::table('krt__kewangan')
				->select('krt__kewangan.id',
				DB::raw("concat(DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),TIME_FORMAT(krt__kewangan.kewangan_masa_t_b,'%H%i%s')) AS tarikh_kewangan"),
				'krt__kewangan.kewangan_butiran AS kewangan_butiran',
				DB::raw("DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%d/%m/%Y') AS tarikh_t_b"),
				DB::raw("concat(kewangan_dokumen_cek.kewangan_cek_baucer,'/',DATE_FORMAT(kewangan_dokumen_cek.kewangan_tarikh_cek,'%d/%m/%Y')) AS notarikh_cek"),
				DB::raw("concat(kewangan_dokumen_resit.kewangan_cek_baucer,'/',DATE_FORMAT(kewangan_dokumen_resit.kewangan_tarikh_cek,'%d/%m/%Y')) AS notarikh_resit"),
				DB::raw("concat(kewangan_dokumen_baucer.kewangan_cek_baucer,'/',DATE_FORMAT(kewangan_dokumen_baucer.kewangan_tarikh_cek,'%d/%m/%Y')) AS notarikh_baucer"),
				DB::raw("CASE WHEN krt__kewangan.kewangan_jenis_kewangan = 1 THEN format(krt__kewangan.kewangan_jumlah_tunai,2) ELSE 0.00 END AS terima_tunai"),
				DB::raw("CASE WHEN krt__kewangan.kewangan_jenis_kewangan = 1 THEN format(krt__kewangan.kewangan_jumlah_bank,2) ELSE 0.00 END AS terima_bank"),
				DB::raw("CASE WHEN krt__kewangan.kewangan_jenis_kewangan = 2 THEN format(krt__kewangan.kewangan_jumlah_tunai,2) ELSE 0.00 END AS bayar_tunai"),
				DB::raw("CASE  WHEN krt__kewangan.kewangan_jenis_kewangan = 2 THEN format(krt__kewangan.kewangan_jumlah_bank,2) ELSE 0.00 END AS bayar_bank"),
				DB::raw(" format(semak_baki_tunai_sah(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(krt__kewangan.kewangan_masa_t_b,'00:00:00'),'%H%i%s'))),2) as kewangan_baki_tunai"),
				DB::raw(" format(semak_baki_bank_sah(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(krt__kewangan.kewangan_masa_t_b,'00:00:00'),'%H%i%s'))),2) as kewangan_baki_bank"),
				DB::raw(" format((semak_baki_tunai_sah(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(krt__kewangan.kewangan_masa_t_b,'00:00:00'),'%H%i%s'))) + semak_baki_bank_sah(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(krt__kewangan.kewangan_masa_t_b,'00:00:00'),'%H%i%s')))),2) AS kewangan_jumlah_baki"))
				->leftJoin('kewangan_dokumen_cek','kewangan_dokumen_cek.kewangan_id','=','krt__kewangan.id')
				->leftJoin('kewangan_dokumen_resit','kewangan_dokumen_resit.kewangan_id','=','krt__kewangan.id')
				->leftJoin('kewangan_dokumen_baucer','kewangan_dokumen_baucer.kewangan_id','=','krt__kewangan.id')
				->where('krt__kewangan.krt_profile_id', '=', $v_krt)
				->where('krt__kewangan.kewangan_status', '=', 1)
				->whereRaw($var_where)
				->orderByRaw("concat(DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),TIME_FORMAT(krt__kewangan.kewangan_masa_t_b,'%H%i%s'))")
				->get();
				
        /*return Excel::download(new Laporan_Kewangan($laporan_kewangan), 'kewangan_file.xlsx');*/
		$dbkrt  = DB::table('krt__profile')
				->select('krt_nama')
				->where('krt__profile.id','=',$v_krt)
				->limit(1)
                ->first();
				
		$dbarr=[];
		$singlearr=['NAMA KRT :'.$dbkrt->krt_nama];
		array_push($dbarr,$singlearr);
		$singlearr=['Bil','Tarikh Penerimaan/Pembayaran','Butiran','No.Cek/Tarikh Cek','No.Resit/Tarikh Resit','No.Baucer/Tarikh Baucer','Terima Tunai','Terima Bank','Bayar Tunai','Bayar Bank','Baki Tunai','Baki Bank','Jumlah Baki'];
		array_push($dbarr,$singlearr);
		$idx=0;
		foreach($laporan_kewangan as $r)
		{
			$idx=$idx+1;
			$singlearr=[$idx,$r->tarikh_t_b,$r->kewangan_butiran,$r->notarikh_cek,$r->notarikh_resit,$r->notarikh_baucer,$r->terima_tunai,$r->terima_bank,$r->bayar_tunai,$r->bayar_bank,$r->kewangan_baki_tunai,$r->kewangan_baki_bank,$r->kewangan_jumlah_baki];
			array_push($dbarr,$singlearr);
		}
		$title = 'BUKU TUNAI RUKUN TETANGGA BAGI BULAN '.$v_bulan.'/'.$v_tahun;
        /*$data = [
            ['KRT ID'.$v_krt],
            ['user_id', 'no_ic', 'user_email'], // Example headers
            [$dataarr], // Example data
            // Add more data rows as needed
        ];
		//dd($data);*/
        // Prepend the title row to the data array
        array_unshift($dbarr, [$title]);

        // Create an instance of the export class
        $export = new CustomExport($title, $dbarr);

        // Download the Excel file
        return Excel::download($export, 'Laporan_Kewangan.xlsx');
    }
}
