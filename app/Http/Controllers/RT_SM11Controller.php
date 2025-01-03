<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Redirect, Response;
use Auth;
use Validator;
use Session;
use DataTables;
use DB;
use Carbon\Carbon;
use App\User;
use App\RefStates;
use App\RefDaerah;
use App\RefParlimen;
use App\RefDUN;
use App\UserProfile;
use App\KRT_Profile;
use App\Krt_Keaktifan;
use App\Krt_Pemulihan;
use App\Laporan_Keaktifan;

class RT_SM11Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	
	public function get_excel_file(Request $request, $state, $parlimen, $daerah, $dun, $krt, $tahun, $kunci_ajk, $kunci_aktiviti, $kunci_mesyuarat, $kunci_kewangan)
    {
		$data_extract = DB::table('krt__profile')
                      	->select(
					  	'ref__states.state_description AS negeri',
					  	'ref__daerahs.daerah_description AS daerah',
					  	'ref__parlimens.parlimen_description AS parlimen',
					  	'ref__duns.dun_description AS dun',
					  	'krt__profile.krt_nama AS nama_krt',
						DB::raw("CONCAT('RT',krt__profile.state_id,krt__profile.daerah_id,krt__profile.id) AS no_rujukan_krt"),
						DB::raw('ifnull(vw_ajk.cnt_ajk,0) AS bil_ajk'),
						DB::raw('ifnull(vw_aktiviti.cnt_aktiviti,0) AS bil_aktiviti'),
						DB::raw('ifnull(vw_mesyuarat.cnt_mesyuarat,0) AS bil_mesyuarat'),
						DB::raw('ifnull(vw_kewangan.cnt_kewangan,0) AS bil_kewangan'),
						DB::raw("(case when krt__profile.state_id is not null and krt__profile.daerah_id is not null and krt__profile.parlimen_id is not null and krt__profile.dun_id is not null then 1
						else 0 end) as markah_latar"),
						DB::raw("(case when count_profile_penduduk.bil is null then 0
						when count_profile_penduduk.bil >=1 then 2 
						else 0 end) AS markah_penduduk"),
						DB::raw("(case when count_profile_pekerjaan.bil >=1 then 2 
						else 0 end) AS markah_pekerjaan"),
						DB::raw("(case when count_profile_rumah.bil >=1 then 2 
						else 0 end) AS markah_rumah"),
						DB::raw("(case when count_profile_pertubuhan.bil >=1 then 1 
						else 0 end) AS markah_pertubuhan"),
						DB::raw("(case when count_profile_kemudahan.bil >=1 then 1 
						else 0 end) AS markah_kemudahan"),
						DB::raw("(case when count_profile_sosial.bil >= 1 or count_profile_jenayah.bil>=1 then 1
						else 0 end) AS markah_sosial"),
						DB::raw("(case when count_profile_binaan.bil >= 1 or count_profile_tumpang.bil >= 1 or count_profile_sewa.bil >= 1 or count_profile_kabin.bil >= 1 then 2
						else 0 end) AS markah_tempat_krt"),
						DB::raw("(case when count_profile_peta.bil >=1 then 2 
						else 0 end) AS markah_profil_peta"), 
						DB::raw("(case when vw_ajk.cnt_ajk is null then 0.0 
						when vw_ajk.cnt_ajk >=20 then 10 
						when vw_ajk.cnt_ajk = 19 then 9.5 
						when vw_ajk.cnt_ajk = 18 then 9.0 
						when vw_ajk.cnt_ajk = 17 then 8.5
						when vw_ajk.cnt_ajk = 16 then 8.0
						when vw_ajk.cnt_ajk = 15 then 7.5
						when vw_ajk.cnt_ajk = 14 then 7.0
						when vw_ajk.cnt_ajk = 13 then 6.5
						when vw_ajk.cnt_ajk = 12 then 6.0
						when vw_ajk.cnt_ajk = 11 then 5.5
						when vw_ajk.cnt_ajk = 10 then 5.0
						when vw_ajk.cnt_ajk = 9 then 4.5
						when vw_ajk.cnt_ajk = 8 then 4.0
						when vw_ajk.cnt_ajk = 7 then 3.5
						when vw_ajk.cnt_ajk = 6 then 3.0
						when vw_ajk.cnt_ajk = 5 then 2.5
						when vw_ajk.cnt_ajk = 4 then 2.0
						when vw_ajk.cnt_ajk = 3 then 1.5
						when vw_ajk.cnt_ajk = 2 then 1.0
						when vw_ajk.cnt_ajk = 1 then 0.5 
						else 0.0 end) AS markah_ajk"),
						DB::raw("(case when vw_aktiviti.cnt_aktiviti is null then 0 
						when vw_aktiviti.cnt_aktiviti >=12 then 12
						else vw_aktiviti.cnt_aktiviti end) AS markah_aktiviti"),
						DB::raw("(case when vw_mesyuarat.cnt_mesyuarat is null then 0
						when vw_mesyuarat.cnt_mesyuarat >=6 then 12
						else vw_mesyuarat.cnt_mesyuarat*2 end) AS markah_mesyuarat"),
						DB::raw("(case when vw_kewangan.cnt_kewangan is null then 0
						when vw_kewangan.cnt_kewangan >=12 then 12
						else vw_kewangan.cnt_kewangan end) AS markah_kewangan"),
						DB::raw('ifnull(krt__keaktifan.keaktifan_markah,0) AS keaktifan_markah'),
						DB::raw("(case when krt__keaktifan.status = '1' then 'Selesai' else 'Belum Selesai' end) AS status"))
						->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
						->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
						->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
						->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
						->leftJoin('krt__keaktifan',function($join) use ($tahun)
						{
							$join->on('krt__keaktifan.krt_profile_id','=','krt__profile.id');
							$join->on('krt__keaktifan.tahun','=',DB::raw("'".$tahun."'"));
						})
						->leftJoin('count_profile_penduduk','count_profile_penduduk.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_pekerjaan','count_profile_pekerjaan.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_rumah','count_profile_rumah.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_pertubuhan','count_profile_pertubuhan.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_kemudahan','count_profile_kemudahan.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_sosial','count_profile_sosial.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_jenayah','count_profile_jenayah.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_binaan','count_profile_binaan.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_tumpang','count_profile_tumpang.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_sewa','count_profile_sewa.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_kabin','count_profile_kabin.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_peta','count_profile_peta.krt_profile_id','=','krt__profile.id')
						->leftJoin(DB::raw("(select krt__ahli_jawatan_kuasa.krt_profile_id,count(krt__ahli_jawatan_kuasa.id) as cnt_ajk from krt__ahli_jawatan_kuasa where ajk_nama is not null and '".$tahun."' >= date_format(krt__ahli_jawatan_kuasa.ajk_tarikh_mula,'%Y') and '".$tahun."'<=date_format(krt__ahli_jawatan_kuasa.ajk_tarikh_akhir,'%Y') and date_format(krt__ahli_jawatan_kuasa.updated_at,'%Y%m%d%h%i%s')<='".$kunci_ajk."' and krt__ahli_jawatan_kuasa.ajk_status_form=5 group by krt__ahli_jawatan_kuasa.krt_profile_id) as vw_ajk"),function($join){
							$join->on("vw_ajk.krt_profile_id","=","krt__profile.id");
  						})
						->leftJoin(DB::raw("(select krt__aktiviti_laporan.krt_profile_id,count(krt__aktiviti_laporan.id) as cnt_aktiviti from krt__aktiviti_laporan where aktiviti_status=1 and date_format(krt__aktiviti_laporan.aktiviti_tarikh,'%Y')='".$tahun."' and date_format(krt__aktiviti_laporan.updated_at,'%Y%m%d%h%i%s')<='".$kunci_aktiviti."' group by krt__aktiviti_laporan.krt_profile_id) as vw_aktiviti"),function($join){
							$join->on("vw_aktiviti.krt_profile_id","=","krt__profile.id");
  						})
						->leftJoin(DB::raw("(select krt__minit_mesyuarat.krt_profile_id,count(krt__minit_mesyuarat.id) as cnt_mesyuarat from krt__minit_mesyuarat where mesyuarat_status=1 and date_format(krt__minit_mesyuarat.mesyuarat_tarikh,'%Y')='".$tahun."' and date_format(krt__minit_mesyuarat.updated_at,'%Y%m%d%h%i%s')<='".$kunci_mesyuarat."' group by krt__minit_mesyuarat.krt_profile_id) as vw_mesyuarat"),function($join){
							$join->on("vw_mesyuarat.krt_profile_id","=","krt__profile.id");
  						})
						->leftJoin(DB::raw("(select krt__kewangan.krt_profile_id,count(krt__kewangan.id) as cnt_kewangan from krt__kewangan where kewangan_status=1 and date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y')='".$tahun."' and date_format(krt__kewangan.updated_at,'%Y%m%d%h%i%s')<='".$kunci_kewangan."' group by krt__kewangan.krt_profile_id) as vw_kewangan"),function($join){
							$join->on("vw_kewangan.krt_profile_id","=","krt__profile.id");
  						})
					    ->where('krt__profile.krt_status','=',1)
						->when($state != 0, function($q) use ($state) 
						{
							$q->where('krt__profile.state_id','=',$state);
						})
						->when($daerah != 0, function($q) use ($daerah) 
						{
							$q->where('krt__profile.daerah_id','=',$daerah);
						})
						->when($parlimen != 0, function($q) use ($parlimen) 
						{
							$q->where('krt__profile.parlimen_id','=',$parlimen);
						})
						->when($dun != 0, function($q) use ($dun) 
						{
							$q->where('krt__profile.dun_id','=',$dun);
						})
						->when($krt != 0, function($q) use ($krt) 
						{
							$q->where('krt__profile.id','=',$krt);
						})
						->orderBy('ref__states.state_description','asc')
						->orderBy('ref__daerahs.daerah_description','asc')
						->orderBy('krt__profile.krt_nama','asc')
						->get();
						
        return Excel::download(new Laporan_Keaktifan($data_extract), 'keaktifan_file.xlsx');
    }

	function keaktifan_krt_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
			$wherefilter="";
			$vnegeri = $request->negeri;
			$vparlimen = $request->parlimen;
			$vdaerah = $request->daerah;
			$vdun = $request->dun;
			$vkrt = $request->krt;
			$tahun = $request->tahun;
			$kunci_ajk = $request->tkh_kunci_ajk;
			$kunci_aktiviti = $request->tkh_kunci_aktiviti;
			$kunci_mesyuarat = $request->tkh_kunci_mesyuarat;
			$kunci_kewangan = $request->tkh_kunci_kewangan;
            if($type == 'get_daerah') 
			{
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_krt') 
			{
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = KRT_Profile::where($where)
                        ->where('krt__profile.krt_status', '=',  true)
						->orderBy('krt__profile.krt_nama','asc')
                        ->get();
                return Response::json($data);
            }else if($type == 'get_parlimen')
			{
				$value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefParlimen::where($where)->get();
                return Response::json($data);
			}else if($type == 'get_dun')
			{
				$value = $request->value;
                $where = array('parlimen_id' => $value);
                $data  = RefDUN::where($where)->get();
                return Response::json($data);
			}
			$data = DB::table('krt__profile')
                      	->select(
						'krt__profile.id AS id',
					  	'ref__states.state_description AS negeri',
					  	'ref__daerahs.daerah_description AS daerah',
					  	'ref__parlimens.parlimen_description AS parlimen',
					  	'ref__duns.dun_description AS dun',
					  	'krt__profile.krt_nama AS nama_krt',
						DB::raw("CONCAT('RT',krt__profile.state_id,krt__profile.daerah_id,krt__profile.id) AS no_rujukan_krt"),
						DB::raw('ifnull(vw_ajk.cnt_ajk,0) AS bil_ajk'),
						DB::raw('ifnull(vw_aktiviti.cnt_aktiviti,0) AS bil_aktiviti'),
						DB::raw('ifnull(vw_mesyuarat.cnt_mesyuarat,0) AS bil_mesyuarat'),
						DB::raw('ifnull(vw_kewangan.cnt_kewangan,0) AS bil_kewangan'),
						DB::raw("(case when krt__profile.state_id is not null and krt__profile.daerah_id is not null and krt__profile.parlimen_id is not null and krt__profile.dun_id is not null then 1
						else 0 end) as markah_latar"),
						DB::raw("(case when count_profile_penduduk.bil is null then 0
						when count_profile_penduduk.bil >=1 then 2 
						else 0 end) AS markah_penduduk"),
						DB::raw("(case when count_profile_pekerjaan.bil >=1 then 2 
						else 0 end) AS markah_pekerjaan"),
						DB::raw("(case when count_profile_rumah.bil >=1 then 2 
						else 0 end) AS markah_rumah"),
						DB::raw("(case when count_profile_pertubuhan.bil >=1 then 1 
						else 0 end) AS markah_pertubuhan"),
						DB::raw("(case when count_profile_kemudahan.bil >=1 then 1 
						else 0 end) AS markah_kemudahan"),
						DB::raw("(case when count_profile_sosial.bil >= 1 or count_profile_jenayah.bil>=1 then 1
						else 0 end) AS markah_sosial"),
						DB::raw("(case when count_profile_binaan.bil >= 1 or count_profile_tumpang.bil >= 1 or count_profile_sewa.bil >= 1 or count_profile_kabin.bil >= 1 then 2
						else 0 end) AS markah_tempat_krt"),
						DB::raw("(case when count_profile_peta.bil >=1 then 2 
						else 0 end) AS markah_profil_peta"), 
						DB::raw("(case when vw_ajk.cnt_ajk is null then 0.0 
						when vw_ajk.cnt_ajk >=20 then 10 
						when vw_ajk.cnt_ajk = 19 then 9.5 
						when vw_ajk.cnt_ajk = 18 then 9.0 
						when vw_ajk.cnt_ajk = 17 then 8.5
						when vw_ajk.cnt_ajk = 16 then 8.0
						when vw_ajk.cnt_ajk = 15 then 7.5
						when vw_ajk.cnt_ajk = 14 then 7.0
						when vw_ajk.cnt_ajk = 13 then 6.5
						when vw_ajk.cnt_ajk = 12 then 6.0
						when vw_ajk.cnt_ajk = 11 then 5.5
						when vw_ajk.cnt_ajk = 10 then 5.0
						when vw_ajk.cnt_ajk = 9 then 4.5
						when vw_ajk.cnt_ajk = 8 then 4.0
						when vw_ajk.cnt_ajk = 7 then 3.5
						when vw_ajk.cnt_ajk = 6 then 3.0
						when vw_ajk.cnt_ajk = 5 then 2.5
						when vw_ajk.cnt_ajk = 4 then 2.0
						when vw_ajk.cnt_ajk = 3 then 1.5
						when vw_ajk.cnt_ajk = 2 then 1.0
						when vw_ajk.cnt_ajk = 1 then 0.5 
						else 0.0 end) AS markah_ajk"),
						DB::raw("(case when vw_aktiviti.cnt_aktiviti is null then 0 
						when vw_aktiviti.cnt_aktiviti >=12 then 12
						else vw_aktiviti.cnt_aktiviti end) AS markah_aktiviti"),
						DB::raw("(case when vw_mesyuarat.cnt_mesyuarat is null then 0
						when vw_mesyuarat.cnt_mesyuarat >=6 then 12
						else vw_mesyuarat.cnt_mesyuarat*2 end) AS markah_mesyuarat"),
						DB::raw("(case when vw_kewangan.cnt_kewangan is null then 0
						when vw_kewangan.cnt_kewangan >=12 then 12
						else vw_kewangan.cnt_kewangan end) AS markah_kewangan"),
						DB::raw('ifnull(krt__keaktifan.keaktifan_markah,0) AS keaktifan_markah'),
						DB::raw("(case when krt__keaktifan.status = '1' then 'Selesai' else 'Belum Selesai' end) AS status"))
						->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
						->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
						->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
						->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
						->leftJoin('krt__keaktifan',function($join) use ($tahun)
						{
							$join->on('krt__keaktifan.krt_profile_id','=','krt__profile.id');
							$join->on('krt__keaktifan.tahun','=',DB::raw("'".$tahun."'"));
						})
						->leftJoin('count_profile_penduduk','count_profile_penduduk.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_pekerjaan','count_profile_pekerjaan.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_rumah','count_profile_rumah.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_pertubuhan','count_profile_pertubuhan.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_kemudahan','count_profile_kemudahan.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_sosial','count_profile_sosial.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_jenayah','count_profile_jenayah.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_binaan','count_profile_binaan.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_tumpang','count_profile_tumpang.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_sewa','count_profile_sewa.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_kabin','count_profile_kabin.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_peta','count_profile_peta.krt_profile_id','=','krt__profile.id')
						->leftJoin(DB::raw("(select krt__ahli_jawatan_kuasa.krt_profile_id,count(krt__ahli_jawatan_kuasa.id) as cnt_ajk from krt__ahli_jawatan_kuasa where ajk_nama is not null and '".$tahun."' >= date_format(krt__ahli_jawatan_kuasa.ajk_tarikh_mula,'%Y') and '".$tahun."'<=date_format(krt__ahli_jawatan_kuasa.ajk_tarikh_akhir,'%Y') and date_format(krt__ahli_jawatan_kuasa.updated_at,'%Y%m%d%h%i%s')<='".$kunci_ajk."' and krt__ahli_jawatan_kuasa.ajk_status_form=5 group by krt__ahli_jawatan_kuasa.krt_profile_id) as vw_ajk"),function($join){
							$join->on("vw_ajk.krt_profile_id","=","krt__profile.id");
  						})
						->leftJoin(DB::raw("(select krt__aktiviti_laporan.krt_profile_id,count(krt__aktiviti_laporan.id) as cnt_aktiviti from krt__aktiviti_laporan where aktiviti_status=1 and date_format(krt__aktiviti_laporan.aktiviti_tarikh,'%Y')='".$tahun."' and date_format(krt__aktiviti_laporan.updated_at,'%Y%m%d%h%i%s')<='".$kunci_aktiviti."' group by krt__aktiviti_laporan.krt_profile_id) as vw_aktiviti"),function($join){
							$join->on("vw_aktiviti.krt_profile_id","=","krt__profile.id");
  						})
						->leftJoin(DB::raw("(select krt__minit_mesyuarat.krt_profile_id,count(krt__minit_mesyuarat.id) as cnt_mesyuarat from krt__minit_mesyuarat where mesyuarat_status=1 and date_format(krt__minit_mesyuarat.mesyuarat_tarikh,'%Y')='".$tahun."' and date_format(krt__minit_mesyuarat.updated_at,'%Y%m%d%h%i%s')<='".$kunci_mesyuarat."' group by krt__minit_mesyuarat.krt_profile_id) as vw_mesyuarat"),function($join){
							$join->on("vw_mesyuarat.krt_profile_id","=","krt__profile.id");
  						})
						->leftJoin(DB::raw("(select krt__kewangan.krt_profile_id,count(krt__kewangan.id) as cnt_kewangan from krt__kewangan where kewangan_status=1 and date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y')='".$tahun."' and date_format(krt__kewangan.updated_at,'%Y%m%d%h%i%s')<='".$kunci_kewangan."' group by krt__kewangan.krt_profile_id) as vw_kewangan"),function($join){
							$join->on("vw_kewangan.krt_profile_id","=","krt__profile.id");
  						})
					    ->where('krt__profile.krt_status','=',1)
						->when($vnegeri != null, function($q) use ($vnegeri) 
						{
							$q->where('krt__profile.state_id','=',$vnegeri);
						})
						->when($vdaerah != null, function($q) use ($vdaerah) 
						{
							$q->where('krt__profile.daerah_id','=',$vdaerah);
						})
						->when($vparlimen != null, function($q) use ($vparlimen) 
						{
							$q->where('krt__profile.parlimen_id','=',$vparlimen);
						})
						->when($vdun != null, function($q) use ($vdun) 
						{
							$q->where('krt__profile.dun_id','=',$vdun);
						})
						->when($vkrt != null, function($q) use ($vkrt) 
						{
							$q->where('krt__profile.id','=',$vkrt);
						})
						->orderBy('ref__states.state_description','asc')
						->orderBy('ref__daerahs.daerah_description','asc')
						->orderBy('krt__profile.krt_nama','asc')
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
							
			$users_info = DB::table('users')
						-> select('users.state_id as state_id',
						'users.daerah_id as daerah_id')
						->where('users.user_id','=',Auth::user()->user_id)
						-> get();
						
            $state   = RefStates::where('status', '=',  true)->get();
            $daerah  = RefDaerah::where('status', '=',  true)->get();
			$parlimen  = RefParlimen::where('status', '=',  true)->get();
			$dun  = RefDUN::where('status', '=',  true)->get();
            $krt     = KRT_Profile::where('krt_status', '=',  true)->orderBy('krt_nama','asc')->get();
			
            return view('rt-sm11.keaktifan-krt-ppd', compact('roles_menu','users_info','state','daerah','krt','parlimen','dun'));
        }
    }
	
	function keaktifan_krt_ppd_kunci(Request $request)
	{
		$data = DB::table('krt__kunci_markah')
				->select('tahun',
				'jenis',
				DB::raw("DATE_FORMAT(tkh_kunci,'%Y%m%d%h%i%s') AS tkh_kunci"))
				->where('krt__kunci_markah.tahun','=',$request->tahun_penilaian)
				->get();
		return Datatables::of($data)
        ->make(true);
	}
	
	function keaktifan_krt_ppn(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
			$vnegeri = $request->negeri;
			$vparlimen = $request->parlimen;
			$vdaerah = $request->daerah;
			$vdun = $request->dun;
			$vkrt = $request->krt;
			$tahun = $request->tahun;
			$kunci_ajk = $request->tkh_kunci_ajk;
			$kunci_aktiviti = $request->tkh_kunci_aktiviti;
			$kunci_mesyuarat = $request->tkh_kunci_mesyuarat;
			$kunci_kewangan = $request->tkh_kunci_kewangan;
            if($type == 'get_daerah') 
			{
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_krt') 
			{
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = KRT_Profile::where($where)
                        ->where('krt__profile.krt_status', '=',  true)
						->orderBy('krt__profile.krt_nama','asc')
                        ->get();
                return Response::json($data);
            }else if($type == 'get_parlimen')
			{
				$value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefParlimen::where($where)->get();
                return Response::json($data);
			}else if($type == 'get_dun')
			{
				$value = $request->value;
                $where = array('parlimen_id' => $value);
                $data  = RefDUN::where($where)->get();
                return Response::json($data);
			}
			$data = DB::table('krt__profile')
                      	->select(
					  	'ref__states.state_description AS negeri',
					  	'ref__daerahs.daerah_description AS daerah',
					  	'ref__parlimens.parlimen_description AS parlimen',
					  	'ref__duns.dun_description AS dun',
					  	'krt__profile.krt_nama AS nama_krt',
						DB::raw("CONCAT('RT',krt__profile.state_id,krt__profile.daerah_id,krt__profile.id) AS no_rujukan_krt"),
						DB::raw('ifnull(vw_ajk.cnt_ajk,0) AS bil_ajk'),
						DB::raw('ifnull(vw_aktiviti.cnt_aktiviti,0) AS bil_aktiviti'),
						DB::raw('ifnull(vw_mesyuarat.cnt_mesyuarat,0) AS bil_mesyuarat'),
						DB::raw('ifnull(vw_kewangan.cnt_kewangan,0) AS bil_kewangan'),
						DB::raw("(case when krt__profile.state_id is not null and krt__profile.daerah_id is not null and krt__profile.parlimen_id is not null and krt__profile.dun_id is not null then 1
						else 0 end) as markah_latar"),
						DB::raw("(case when count_profile_penduduk.bil is null then 0
						when count_profile_penduduk.bil >=1 then 2 
						else 0 end) AS markah_penduduk"),
						DB::raw("(case when count_profile_pekerjaan.bil >=1 then 2 
						else 0 end) AS markah_pekerjaan"),
						DB::raw("(case when count_profile_rumah.bil >=1 then 2 
						else 0 end) AS markah_rumah"),
						DB::raw("(case when count_profile_pertubuhan.bil >=1 then 1 
						else 0 end) AS markah_pertubuhan"),
						DB::raw("(case when count_profile_kemudahan.bil >=1 then 1 
						else 0 end) AS markah_kemudahan"),
						DB::raw("(case when count_profile_sosial.bil >= 1 or count_profile_jenayah.bil>=1 then 1
						else 0 end) AS markah_sosial"),
						DB::raw("(case when count_profile_binaan.bil >= 1 or count_profile_tumpang.bil >= 1 or count_profile_sewa.bil >= 1 or count_profile_kabin.bil >= 1 then 2
						else 0 end) AS markah_tempat_krt"),
						DB::raw("(case when count_profile_peta.bil >=1 then 2 
						else 0 end) AS markah_profil_peta"), 
						DB::raw("(case when vw_ajk.cnt_ajk is null then 0.0 
						when vw_ajk.cnt_ajk >=20 then 10 
						when vw_ajk.cnt_ajk = 19 then 9.5 
						when vw_ajk.cnt_ajk = 18 then 9.0 
						when vw_ajk.cnt_ajk = 17 then 8.5
						when vw_ajk.cnt_ajk = 16 then 8.0
						when vw_ajk.cnt_ajk = 15 then 7.5
						when vw_ajk.cnt_ajk = 14 then 7.0
						when vw_ajk.cnt_ajk = 13 then 6.5
						when vw_ajk.cnt_ajk = 12 then 6.0
						when vw_ajk.cnt_ajk = 11 then 5.5
						when vw_ajk.cnt_ajk = 10 then 5.0
						when vw_ajk.cnt_ajk = 9 then 4.5
						when vw_ajk.cnt_ajk = 8 then 4.0
						when vw_ajk.cnt_ajk = 7 then 3.5
						when vw_ajk.cnt_ajk = 6 then 3.0
						when vw_ajk.cnt_ajk = 5 then 2.5
						when vw_ajk.cnt_ajk = 4 then 2.0
						when vw_ajk.cnt_ajk = 3 then 1.5
						when vw_ajk.cnt_ajk = 2 then 1.0
						when vw_ajk.cnt_ajk = 1 then 0.5 
						else 0.0 end) AS markah_ajk"),
						DB::raw("(case when vw_aktiviti.cnt_aktiviti is null then 0 
						when vw_aktiviti.cnt_aktiviti >=12 then 12
						else vw_aktiviti.cnt_aktiviti end) AS markah_aktiviti"),
						DB::raw("(case when vw_mesyuarat.cnt_mesyuarat is null then 0
						when vw_mesyuarat.cnt_mesyuarat >=6 then 12
						else vw_mesyuarat.cnt_mesyuarat*2 end) AS markah_mesyuarat"),
						DB::raw("(case when vw_kewangan.cnt_kewangan is null then 0
						when vw_kewangan.cnt_kewangan >=12 then 12
						else vw_kewangan.cnt_kewangan end) AS markah_kewangan"),
						DB::raw('ifnull(krt__keaktifan.keaktifan_markah,0) AS keaktifan_markah'),
						DB::raw("(case when krt__keaktifan.status = '1' then 'Selesai' else 'Belum Selesai' end) AS status"))
						->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
						->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
						->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
						->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
						->leftJoin('krt__keaktifan',function($join) use ($tahun)
						{
							$join->on('krt__keaktifan.krt_profile_id','=','krt__profile.id');
							$join->on('krt__keaktifan.tahun','=',DB::raw("'".$tahun."'"));
						})
						->leftJoin('count_profile_penduduk','count_profile_penduduk.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_pekerjaan','count_profile_pekerjaan.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_rumah','count_profile_rumah.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_pertubuhan','count_profile_pertubuhan.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_kemudahan','count_profile_kemudahan.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_sosial','count_profile_sosial.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_jenayah','count_profile_jenayah.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_binaan','count_profile_binaan.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_tumpang','count_profile_tumpang.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_sewa','count_profile_sewa.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_kabin','count_profile_kabin.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_peta','count_profile_peta.krt_profile_id','=','krt__profile.id')
						->leftJoin(DB::raw("(select krt__ahli_jawatan_kuasa.krt_profile_id,count(krt__ahli_jawatan_kuasa.id) as cnt_ajk from krt__ahli_jawatan_kuasa where ajk_nama is not null and '".$tahun."' >= date_format(krt__ahli_jawatan_kuasa.ajk_tarikh_mula,'%Y') and '".$tahun."'<=date_format(krt__ahli_jawatan_kuasa.ajk_tarikh_akhir,'%Y') and date_format(krt__ahli_jawatan_kuasa.updated_at,'%Y%m%d%h%i%s')<='".$kunci_ajk."' and krt__ahli_jawatan_kuasa.ajk_status_form=5 group by krt__ahli_jawatan_kuasa.krt_profile_id) as vw_ajk"),function($join){
							$join->on("vw_ajk.krt_profile_id","=","krt__profile.id");
  						})
						->leftJoin(DB::raw("(select krt__aktiviti_laporan.krt_profile_id,count(krt__aktiviti_laporan.id) as cnt_aktiviti from krt__aktiviti_laporan where aktiviti_status=1 and date_format(krt__aktiviti_laporan.aktiviti_tarikh,'%Y')='".$tahun."' and date_format(krt__aktiviti_laporan.updated_at,'%Y%m%d%h%i%s')<='".$kunci_aktiviti."' group by krt__aktiviti_laporan.krt_profile_id) as vw_aktiviti"),function($join){
							$join->on("vw_aktiviti.krt_profile_id","=","krt__profile.id");
  						})
						->leftJoin(DB::raw("(select krt__minit_mesyuarat.krt_profile_id,count(krt__minit_mesyuarat.id) as cnt_mesyuarat from krt__minit_mesyuarat where mesyuarat_status=1 and date_format(krt__minit_mesyuarat.mesyuarat_tarikh,'%Y')='".$tahun."' and date_format(krt__minit_mesyuarat.updated_at,'%Y%m%d%h%i%s')<='".$kunci_mesyuarat."' group by krt__minit_mesyuarat.krt_profile_id) as vw_mesyuarat"),function($join){
							$join->on("vw_mesyuarat.krt_profile_id","=","krt__profile.id");
  						})
						->leftJoin(DB::raw("(select krt__kewangan.krt_profile_id,count(krt__kewangan.id) as cnt_kewangan from krt__kewangan where kewangan_status=1 and date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y')='".$tahun."' and date_format(krt__kewangan.updated_at,'%Y%m%d%h%i%s')<='".$kunci_kewangan."' group by krt__kewangan.krt_profile_id) as vw_kewangan"),function($join){
							$join->on("vw_kewangan.krt_profile_id","=","krt__profile.id");
  						})
					    ->where('krt__profile.krt_status','=',1)
						->when($vnegeri != null, function($q) use ($vnegeri) 
						{
							$q->where('krt__profile.state_id','=',$vnegeri);
						})
						->when($vdaerah != null, function($q) use ($vdaerah) 
						{
							$q->where('krt__profile.daerah_id','=',$vdaerah);
						})
						->when($vparlimen != null, function($q) use ($vparlimen) 
						{
							$q->where('krt__profile.parlimen_id','=',$vparlimen);
						})
						->when($vdun != null, function($q) use ($vdun) 
						{
							$q->where('krt__profile.dun_id','=',$vdun);
						})
						->when($vkrt != null, function($q) use ($vkrt) 
						{
							$q->where('krt__profile.id','=',$vkrt);
						})
						->orderBy('ref__states.state_description','asc')
						->orderBy('ref__daerahs.daerah_description','asc')
						->orderBy('krt__profile.krt_nama','asc')
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
			$parlimen  = RefParlimen::where('status', '=',  true)->get();
			$dun  = RefDUN::where('status', '=',  true)->get();
            $krt     = KRT_Profile::where('krt_status', '=',  true)->orderBy('krt_nama','asc')->get();
            return view('rt-sm11.keaktifan-krt-ppn', compact('roles_menu','state','daerah','krt','parlimen','dun'));
        }
    }
	
    function add_markah_keaktifan_ppd(Request $request){
        $action         = $request->add_markah_keaktifan_ppd;
        $krt_profile_id = $request->mamkk_krt_profile_id;
		$vtahun 		= $request->add_tahun;
        
        $rules = array(
            'mamkk_markah'                 => 'between:0,40|required',
        );

        $messages = [
            'mamkk_markah.required'        => 'Ruangan Markah mesti diisi.',
            'mamkk_markah.between'         => 'Ruangan Markah mesti tidak melebihi 40 markah.',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
				$data = DB::table('krt__keaktifan')
						->select('id')
						->where('krt_profile_id','=',$krt_profile_id)
						->where('tahun','=',$vtahun)
						->count();
				if($data == 0)
				{
					$markah_keaktifan                   = new Krt_Keaktifan;
					$markah_keaktifan->krt_profile_id   = $krt_profile_id;
					$markah_keaktifan->keaktifan_markah = $request->mamkk_markah;
					$markah_keaktifan->status           = 1;
					$markah_keaktifan->tahun			= $vtahun;
					$markah_keaktifan->save();
				}
            }
        }
    }

    function keaktifan_krt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::select(DB::raw("
                    select 
                    krt__profile.id,
                    krt__profile.krt_nama AS nama_krt,
                    CONCAT('RT',krt__profile.state_id,krt__profile.daerah_id,krt__profile.id) AS no_rujukan_krt,
                    (select count(*) from krt__ahli_jawatan_kuasa ac where ac.krt_profile_id = krt__profile.id AND ac.ajk_status = 1) as bil_ajk,
                    (select count(*) from krt__minit_mesyuarat bc where bc.krt_profile_id = krt__profile.id AND bc.mesyuarat_status = 1) as bil_mesyuarat,
                    (select count(*) from krt__aktiviti_laporan cc where cc.krt_profile_id = krt__profile.id AND cc.aktiviti_status = 1) as bil_aktiviti,
                    (select count(*) from krt__kewangan dc where dc.krt_profile_id = krt__profile.id AND dc.kewangan_status = 1) as bil_kewangan,
                    (select count(DISTINCT ec.cawangan_id) from krt__ahli_jawatan_kuasa_cawangan ec where ec.krt_profile_id = krt__profile.id AND ec.ajk_status = 1) as bil_cawangan,
                    (select count(*) from srs__profile fc where fc.krt_id = krt__profile.id AND fc.srs_status = 1) as bil_srs,
                    (select count(*) from srs__perancangan_rondaan gc where gc.krt_profile_id = krt__profile.id AND gc.perancangan_rondaan_status = 1) as bil_perancangan_srs,
                    (select count(*) from srs__pelaksanaan_rondaan hc where hc.krt_profile_id = krt__profile.id AND hc.pelaksanaan_rondaan_status = 1) as bil_pelaksanaan_srs,
                    (select count(*) from srs__pelaksanaan_rondaan ic where ic.krt_profile_id = krt__profile.id AND ic.pelaksanaan_rondaan_kes = 'Ada' AND ic.pelaksanaan_rondaan_status = 1) as bil_pengendalian_kes_srs,
                    (case when i.status = '1' then 'Selesai' else 'Belum Selesai' end)AS status,
                    ((case when a.krt_profile_id IS NOT NULL then 16 else 0 end) + 
                    (case when b.count_mesyuarat <= 6 then b.count_mesyuarat * 1 when b.count_mesyuarat > 6 then 6 else 0 end) +
                    (case when c.count_aktiviti <= 12 then c.count_aktiviti * 2 when c.count_aktiviti > 12 then 24 else 0 end) +
                    (case when d.count_kewangan <= 12 then d.count_kewangan * 1 when d.count_kewangan > 12 then 12 else 0 end) +
                    (case when e.count_cawangan <= 4 then e.count_cawangan * 3 when e.count_cawangan > 4 then 4 else 0 end) +
                    (case when f.krt_id IS NOT NULL then 5 else 0 end) +
                    (case when g.krt_profile_id IS NOT NULL then 2 else 0 end) +
                    (case when h.krt_profile_id IS NOT NULL then 8 else 0 end) +
                    (case when h.count_kes IS NOT NULL then 5 else 0 end) +
                    (case when i.keaktifan_markah IS NOT NULL then i.keaktifan_markah else 0 end)
                    ) AS markah
                    FROM krt__profile
                    LEFT JOIN (
                        SELECT krt__ahli_jawatan_kuasa.krt_profile_id, count(*) AS count_ajk
                        FROM krt__ahli_jawatan_kuasa 
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1
                        GROUP BY krt__ahli_jawatan_kuasa.krt_profile_id
                    ) a ON a.krt_profile_id = krt__profile.id
                    LEFT JOIN (
                        SELECT krt__minit_mesyuarat.krt_profile_id, count(*) AS count_mesyuarat
                        FROM krt__minit_mesyuarat
                        WHERE krt__minit_mesyuarat.mesyuarat_status = 1
                        GROUP BY krt__minit_mesyuarat.krt_profile_id
                    ) b ON b.krt_profile_id = krt__profile.id
                    LEFT JOIN (
                        SELECT krt__aktiviti_laporan.krt_profile_id, count(*) AS count_aktiviti
                        FROM krt__aktiviti_laporan 
                        WHERE krt__aktiviti_laporan.aktiviti_status = 1
                        GROUP BY krt__aktiviti_laporan.krt_profile_id
                    ) c ON c.krt_profile_id = krt__profile.id
                    LEFT JOIN (
                        SELECT krt__kewangan.krt_profile_id, count(*) AS count_kewangan
                        FROM krt__kewangan 
                        WHERE krt__kewangan.kewangan_status = 1
                        GROUP BY krt__kewangan.krt_profile_id
                    ) d ON d.krt_profile_id = krt__profile.id
                    LEFT JOIN (
                        SELECT krt__ahli_jawatan_kuasa_cawangan.krt_profile_id, COUNT(DISTINCT krt__ahli_jawatan_kuasa_cawangan.cawangan_id) AS count_cawangan
                        FROM krt__ahli_jawatan_kuasa_cawangan 
                        WHERE krt__ahli_jawatan_kuasa_cawangan.ajk_status = 1
                        GROUP BY krt__ahli_jawatan_kuasa_cawangan.krt_profile_id
                    ) e ON e.krt_profile_id = krt__profile.id
                    LEFT JOIN (
                        SELECT srs__profile.krt_id
                        FROM srs__profile 
                        WHERE srs__profile.srs_status = 1
                        GROUP BY srs__profile.krt_id
                    ) f ON f.krt_id = krt__profile.id
                    LEFT JOIN (
                    SELECT srs__perancangan_rondaan.krt_profile_id 
                        FROM srs__perancangan_rondaan 
                        WHERE srs__perancangan_rondaan.perancangan_rondaan_status = 1
                        GROUP BY srs__perancangan_rondaan.krt_profile_id
                    ) g ON g.krt_profile_id = krt__profile.id
                    LEFT JOIN (
                        SELECT srs__pelaksanaan_rondaan.krt_profile_id, COUNT(DISTINCT srs__pelaksanaan_rondaan.kategori_kes_id) AS count_kes
                        FROM srs__pelaksanaan_rondaan 
                        WHERE srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1
                        GROUP BY srs__pelaksanaan_rondaan.krt_profile_id
                    ) h ON h.krt_profile_id = krt__profile.id
                    LEFT JOIN (
                        SELECT krt__keaktifan.krt_profile_id, krt__keaktifan.status, krt__keaktifan.keaktifan_markah
                        FROM krt__keaktifan
                        GROUP BY krt__keaktifan.krt_profile_id, krt__keaktifan.status, krt__keaktifan.keaktifan_markah
                    ) i ON i.krt_profile_id = krt__profile.id
                    WHERE krt__profile.krt_status = 1 AND i.keaktifan_markah IS NOT NULL AND krt__profile.id = '" . Auth::user()->krt_id . "'
                    GROUP BY krt__profile.id, krt__profile.krt_nama, krt__profile.state_id, krt__profile.daerah_id, a.krt_profile_id, b.count_mesyuarat, c.count_aktiviti, d.count_kewangan,
                    e.count_cawangan, f.krt_id, g.krt_profile_id, h.krt_profile_id, h.count_kes, i.status, i.keaktifan_markah
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
            return view('rt-sm11.keaktifan-krt',compact('roles_menu'));
        }
    }

    function keaktifan_krt_hqrt(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
			$vnegeri = $request->negeri;
			$vparlimen = $request->parlimen;
			$vdaerah = $request->daerah;
			$vdun = $request->dun;
			$vkrt = $request->krt;
			$tahun = $request->tahun;
			$kunci_ajk = $request->tkh_kunci_ajk;
			$kunci_aktiviti = $request->tkh_kunci_aktiviti;
			$kunci_mesyuarat = $request->tkh_kunci_mesyuarat;
			$kunci_kewangan = $request->tkh_kunci_kewangan;
            if($type == 'get_daerah') 
			{
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else if($type == 'get_krt') 
			{
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = KRT_Profile::where($where)
                        ->where('krt__profile.krt_status', '=',  true)
						->orderBy('krt__profile.krt_nama','asc')
                        ->get();
                return Response::json($data);
            }else if($type == 'get_parlimen')
			{
				$value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefParlimen::where($where)->get();
                return Response::json($data);
			}else if($type == 'get_dun')
			{
				$value = $request->value;
                $where = array('parlimen_id' => $value);
                $data  = RefDUN::where($where)->get();
                return Response::json($data);
			}
			$data = DB::table('krt__profile')
                      	->select(
					  	'ref__states.state_description AS negeri',
					  	'ref__daerahs.daerah_description AS daerah',
					  	'ref__parlimens.parlimen_description AS parlimen',
					  	'ref__duns.dun_description AS dun',
					  	'krt__profile.krt_nama AS nama_krt',
						DB::raw("CONCAT('RT',krt__profile.state_id,krt__profile.daerah_id,krt__profile.id) AS no_rujukan_krt"),
						DB::raw('ifnull(vw_ajk.cnt_ajk,0) AS bil_ajk'),
						DB::raw('ifnull(vw_aktiviti.cnt_aktiviti,0) AS bil_aktiviti'),
						DB::raw('ifnull(vw_mesyuarat.cnt_mesyuarat,0) AS bil_mesyuarat'),
						DB::raw('ifnull(vw_kewangan.cnt_kewangan,0) AS bil_kewangan'),
						DB::raw("(case when krt__profile.state_id is not null and krt__profile.daerah_id is not null and krt__profile.parlimen_id is not null and krt__profile.dun_id is not null then 1
						else 0 end) as markah_latar"),
						DB::raw("(case when count_profile_penduduk.bil is null then 0
						when count_profile_penduduk.bil >=1 then 2 
						else 0 end) AS markah_penduduk"),
						DB::raw("(case when count_profile_pekerjaan.bil >=1 then 2 
						else 0 end) AS markah_pekerjaan"),
						DB::raw("(case when count_profile_rumah.bil >=1 then 2 
						else 0 end) AS markah_rumah"),
						DB::raw("(case when count_profile_pertubuhan.bil >=1 then 1 
						else 0 end) AS markah_pertubuhan"),
						DB::raw("(case when count_profile_kemudahan.bil >=1 then 1 
						else 0 end) AS markah_kemudahan"),
						DB::raw("(case when count_profile_sosial.bil >= 1 or count_profile_jenayah.bil>=1 then 1
						else 0 end) AS markah_sosial"),
						DB::raw("(case when count_profile_binaan.bil >= 1 or count_profile_tumpang.bil >= 1 or count_profile_sewa.bil >= 1 or count_profile_kabin.bil >= 1 then 2
						else 0 end) AS markah_tempat_krt"),
						DB::raw("(case when count_profile_peta.bil >=1 then 2 
						else 0 end) AS markah_profil_peta"), 
						DB::raw("(case when vw_ajk.cnt_ajk is null then 0.0 
						when vw_ajk.cnt_ajk >=20 then 10 
						when vw_ajk.cnt_ajk = 19 then 9.5 
						when vw_ajk.cnt_ajk = 18 then 9.0 
						when vw_ajk.cnt_ajk = 17 then 8.5
						when vw_ajk.cnt_ajk = 16 then 8.0
						when vw_ajk.cnt_ajk = 15 then 7.5
						when vw_ajk.cnt_ajk = 14 then 7.0
						when vw_ajk.cnt_ajk = 13 then 6.5
						when vw_ajk.cnt_ajk = 12 then 6.0
						when vw_ajk.cnt_ajk = 11 then 5.5
						when vw_ajk.cnt_ajk = 10 then 5.0
						when vw_ajk.cnt_ajk = 9 then 4.5
						when vw_ajk.cnt_ajk = 8 then 4.0
						when vw_ajk.cnt_ajk = 7 then 3.5
						when vw_ajk.cnt_ajk = 6 then 3.0
						when vw_ajk.cnt_ajk = 5 then 2.5
						when vw_ajk.cnt_ajk = 4 then 2.0
						when vw_ajk.cnt_ajk = 3 then 1.5
						when vw_ajk.cnt_ajk = 2 then 1.0
						when vw_ajk.cnt_ajk = 1 then 0.5 
						else 0.0 end) AS markah_ajk"),
						DB::raw("(case when vw_aktiviti.cnt_aktiviti is null then 0 
						when vw_aktiviti.cnt_aktiviti >=12 then 12
						else vw_aktiviti.cnt_aktiviti end) AS markah_aktiviti"),
						DB::raw("(case when vw_mesyuarat.cnt_mesyuarat is null then 0
						when vw_mesyuarat.cnt_mesyuarat >=6 then 12
						else vw_mesyuarat.cnt_mesyuarat*2 end) AS markah_mesyuarat"),
						DB::raw("(case when vw_kewangan.cnt_kewangan is null then 0
						when vw_kewangan.cnt_kewangan >=12 then 12
						else vw_kewangan.cnt_kewangan end) AS markah_kewangan"),
						DB::raw('ifnull(krt__keaktifan.keaktifan_markah,0) AS keaktifan_markah'),
						DB::raw("(case when krt__keaktifan.status = '1' then 'Selesai' else 'Belum Selesai' end) AS status"))
						->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
						->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
						->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
						->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
						->leftJoin('krt__keaktifan',function($join) use ($tahun)
						{
							$join->on('krt__keaktifan.krt_profile_id','=','krt__profile.id');
							$join->on('krt__keaktifan.tahun','=',DB::raw("'".$tahun."'"));
						})
						->leftJoin('count_profile_penduduk','count_profile_penduduk.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_pekerjaan','count_profile_pekerjaan.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_rumah','count_profile_rumah.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_pertubuhan','count_profile_pertubuhan.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_kemudahan','count_profile_kemudahan.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_sosial','count_profile_sosial.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_jenayah','count_profile_jenayah.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_binaan','count_profile_binaan.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_tumpang','count_profile_tumpang.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_sewa','count_profile_sewa.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_kabin','count_profile_kabin.krt_profile_id','=','krt__profile.id')
						->leftJoin('count_profile_peta','count_profile_peta.krt_profile_id','=','krt__profile.id')
						->leftJoin(DB::raw("(select krt__ahli_jawatan_kuasa.krt_profile_id,count(krt__ahli_jawatan_kuasa.id) as cnt_ajk from krt__ahli_jawatan_kuasa where ajk_nama is not null and '".$tahun."' >= date_format(krt__ahli_jawatan_kuasa.ajk_tarikh_mula,'%Y') and '".$tahun."'<=date_format(krt__ahli_jawatan_kuasa.ajk_tarikh_akhir,'%Y') and date_format(krt__ahli_jawatan_kuasa.updated_at,'%Y%m%d%h%i%s')<='".$kunci_ajk."' and krt__ahli_jawatan_kuasa.ajk_status_form=5 group by krt__ahli_jawatan_kuasa.krt_profile_id) as vw_ajk"),function($join){
							$join->on("vw_ajk.krt_profile_id","=","krt__profile.id");
  						})
						->leftJoin(DB::raw("(select krt__aktiviti_laporan.krt_profile_id,count(krt__aktiviti_laporan.id) as cnt_aktiviti from krt__aktiviti_laporan where aktiviti_status=1 and date_format(krt__aktiviti_laporan.aktiviti_tarikh,'%Y')='".$tahun."' and date_format(krt__aktiviti_laporan.updated_at,'%Y%m%d%h%i%s')<='".$kunci_aktiviti."' group by krt__aktiviti_laporan.krt_profile_id) as vw_aktiviti"),function($join){
							$join->on("vw_aktiviti.krt_profile_id","=","krt__profile.id");
  						})
						->leftJoin(DB::raw("(select krt__minit_mesyuarat.krt_profile_id,count(krt__minit_mesyuarat.id) as cnt_mesyuarat from krt__minit_mesyuarat where mesyuarat_status=1 and date_format(krt__minit_mesyuarat.mesyuarat_tarikh,'%Y')='".$tahun."' and date_format(krt__minit_mesyuarat.updated_at,'%Y%m%d%h%i%s')<='".$kunci_mesyuarat."' group by krt__minit_mesyuarat.krt_profile_id) as vw_mesyuarat"),function($join){
							$join->on("vw_mesyuarat.krt_profile_id","=","krt__profile.id");
  						})
						->leftJoin(DB::raw("(select krt__kewangan.krt_profile_id,count(krt__kewangan.id) as cnt_kewangan from krt__kewangan where kewangan_status=1 and date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y')='".$tahun."' and date_format(krt__kewangan.updated_at,'%Y%m%d%h%i%s')<='".$kunci_kewangan."' group by krt__kewangan.krt_profile_id) as vw_kewangan"),function($join){
							$join->on("vw_kewangan.krt_profile_id","=","krt__profile.id");
  						})
					    ->where('krt__profile.krt_status','=',1)
						->when($vnegeri != null, function($q) use ($vnegeri) 
						{
							$q->where('krt__profile.state_id','=',$vnegeri);
						})
						->when($vdaerah != null, function($q) use ($vdaerah) 
						{
							$q->where('krt__profile.daerah_id','=',$vdaerah);
						})
						->when($vparlimen != null, function($q) use ($vparlimen) 
						{
							$q->where('krt__profile.parlimen_id','=',$vparlimen);
						})
						->when($vdun != null, function($q) use ($vdun) 
						{
							$q->where('krt__profile.dun_id','=',$vdun);
						})
						->when($vkrt != null, function($q) use ($vkrt) 
						{
							$q->where('krt__profile.id','=',$vkrt);
						})
						->orderBy('ref__states.state_description','asc')
						->orderBy('ref__daerahs.daerah_description','asc')
						->orderBy('krt__profile.krt_nama','asc')
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
			$parlimen  = RefParlimen::where('status', '=',  true)->get();
			$dun  = RefDUN::where('status', '=',  true)->get();
            $krt     = KRT_Profile::where('krt_status', '=',  true)->orderBy('krt_nama','asc')->get();
            return view('rt-sm11.keaktifan-krt-hqrt', compact('roles_menu','state','daerah','krt','parlimen','dun'));
        }
    }

    function pemulihan_krt_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::select(DB::raw("
                    select 
                    krt__profile.id,
                    krt__profile.krt_nama AS nama_krt,
                    CONCAT('RT',krt__profile.state_id,krt__profile.daerah_id,krt__profile.id) AS no_rujukan_krt,
                    (select count(*) from krt__ahli_jawatan_kuasa ac where ac.krt_profile_id = krt__profile.id AND ac.ajk_status = 1) as bil_ajk,
                    (select count(*) from krt__minit_mesyuarat bc where bc.krt_profile_id = krt__profile.id AND bc.mesyuarat_status = 1) as bil_mesyuarat,
                    (select count(*) from krt__aktiviti_laporan cc where cc.krt_profile_id = krt__profile.id AND cc.aktiviti_status = 1) as bil_aktiviti,
                    (select count(*) from krt__kewangan dc where dc.krt_profile_id = krt__profile.id AND dc.kewangan_status = 1) as bil_kewangan,
                    (select count(DISTINCT ec.cawangan_id) from krt__ahli_jawatan_kuasa_cawangan ec where ec.krt_profile_id = krt__profile.id AND ec.ajk_status = 1) as bil_cawangan,
                    (select count(*) from srs__profile fc where fc.krt_id = krt__profile.id AND fc.srs_status = 1) as bil_srs,
                    (select count(*) from srs__perancangan_rondaan gc where gc.krt_profile_id = krt__profile.id AND gc.perancangan_rondaan_status = 1) as bil_perancangan_srs,
                    (select count(*) from srs__pelaksanaan_rondaan hc where hc.krt_profile_id = krt__profile.id AND hc.pelaksanaan_rondaan_status = 1) as bil_pelaksanaan_srs,
                    (select count(*) from srs__pelaksanaan_rondaan ic where ic.krt_profile_id = krt__profile.id AND ic.pelaksanaan_rondaan_kes = 'Ada' AND ic.pelaksanaan_rondaan_status = 1) as bil_pengendalian_kes_srs,
                    (case when j.status = '1' then 'Selesai' when j.status = '2' then 'Dihantar Untuk Disemak Oleh PPN' when j.status = '3' then 'Perlu Dikemaskini' else 'Belum Selesai' end) AS status,
                    ((case when a.krt_profile_id IS NOT NULL then 16 else 0 end) + 
                    (case when b.count_mesyuarat <= 6 then b.count_mesyuarat * 1 when b.count_mesyuarat > 6 then 6 else 0 end) +
                    (case when c.count_aktiviti <= 12 then c.count_aktiviti * 2 when c.count_aktiviti > 12 then 24 else 0 end) +
                    (case when d.count_kewangan <= 12 then d.count_kewangan * 1 when d.count_kewangan > 12 then 12 else 0 end) +
                    (case when e.count_cawangan <= 4 then e.count_cawangan * 3 when e.count_cawangan > 4 then 4 else 0 end) +
                    (case when f.krt_id IS NOT NULL then 5 else 0 end) +
                    (case when g.krt_profile_id IS NOT NULL then 2 else 0 end) +
                    (case when h.krt_profile_id IS NOT NULL then 8 else 0 end) +
                    (case when h.count_kes IS NOT NULL then 5 else 0 end) +
                    (case when i.keaktifan_markah IS NOT NULL then i.keaktifan_markah else 0 end)
                    ) AS markah
                    FROM krt__profile
                    LEFT JOIN (
                        SELECT krt__ahli_jawatan_kuasa.krt_profile_id, count(*) AS count_ajk
                        FROM krt__ahli_jawatan_kuasa 
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1
                        GROUP BY krt__ahli_jawatan_kuasa.krt_profile_id
                    ) a ON a.krt_profile_id = krt__profile.id
                    LEFT JOIN (
                        SELECT krt__minit_mesyuarat.krt_profile_id, count(*) AS count_mesyuarat
                        FROM krt__minit_mesyuarat
                        WHERE krt__minit_mesyuarat.mesyuarat_status = 1
                        GROUP BY krt__minit_mesyuarat.krt_profile_id
                    ) b ON b.krt_profile_id = krt__profile.id
                    LEFT JOIN (
                        SELECT krt__aktiviti_laporan.krt_profile_id, count(*) AS count_aktiviti
                        FROM krt__aktiviti_laporan 
                        WHERE krt__aktiviti_laporan.aktiviti_status = 1
                        GROUP BY krt__aktiviti_laporan.krt_profile_id
                    ) c ON c.krt_profile_id = krt__profile.id
                    LEFT JOIN (
                        SELECT krt__kewangan.krt_profile_id, count(*) AS count_kewangan
                        FROM krt__kewangan 
                        WHERE krt__kewangan.kewangan_status = 1
                        GROUP BY krt__kewangan.krt_profile_id
                    ) d ON d.krt_profile_id = krt__profile.id
                    LEFT JOIN (
                        SELECT krt__ahli_jawatan_kuasa_cawangan.krt_profile_id, COUNT(DISTINCT krt__ahli_jawatan_kuasa_cawangan.cawangan_id) AS count_cawangan
                        FROM krt__ahli_jawatan_kuasa_cawangan 
                        WHERE krt__ahli_jawatan_kuasa_cawangan.ajk_status = 1
                        GROUP BY krt__ahli_jawatan_kuasa_cawangan.krt_profile_id
                    ) e ON e.krt_profile_id = krt__profile.id
                    LEFT JOIN (
                        SELECT srs__profile.krt_id
                        FROM srs__profile 
                        WHERE srs__profile.srs_status = 1
                        GROUP BY srs__profile.krt_id
                    ) f ON f.krt_id = krt__profile.id
                    LEFT JOIN (
                    SELECT srs__perancangan_rondaan.krt_profile_id 
                        FROM srs__perancangan_rondaan 
                        WHERE srs__perancangan_rondaan.perancangan_rondaan_status = 1
                        GROUP BY srs__perancangan_rondaan.krt_profile_id
                    ) g ON g.krt_profile_id = krt__profile.id
                    LEFT JOIN (
                        SELECT srs__pelaksanaan_rondaan.krt_profile_id, COUNT(DISTINCT srs__pelaksanaan_rondaan.kategori_kes_id) AS count_kes
                        FROM srs__pelaksanaan_rondaan 
                        WHERE srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1
                        GROUP BY srs__pelaksanaan_rondaan.krt_profile_id
                    ) h ON h.krt_profile_id = krt__profile.id
                    LEFT JOIN (
                        SELECT krt__keaktifan.krt_profile_id, krt__keaktifan.status, krt__keaktifan.keaktifan_markah
                        FROM krt__keaktifan
                        GROUP BY krt__keaktifan.krt_profile_id, krt__keaktifan.status, krt__keaktifan.keaktifan_markah
                    ) i ON i.krt_profile_id = krt__profile.id
                    LEFT JOIN (
                        SELECT krt__pemulihan.krt_profile_id, krt__pemulihan.status
                        FROM krt__pemulihan
                        GROUP BY krt__pemulihan.krt_profile_id, krt__pemulihan.status
                    ) j ON j.krt_profile_id = krt__profile.id
                    WHERE krt__profile.krt_status = 1 AND krt__profile.daerah_id = '" . Auth::user()->daerah_id . "'
                    GROUP BY krt__profile.id, krt__profile.krt_nama, krt__profile.state_id, krt__profile.daerah_id, a.krt_profile_id, b.count_mesyuarat, c.count_aktiviti, d.count_kewangan,
                    e.count_cawangan, f.krt_id, g.krt_profile_id, h.krt_profile_id, h.count_kes, i.status, i.keaktifan_markah, j.status
                    HAVING markah <= 30
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
            $krt        = KRT_Profile::where('krt_status', '=', true)
                        ->where('krt__profile.daerah_id', '=', Auth::user()->daerah_id)
                        ->get();
            return view('rt-sm11.pemulihan-krt-ppd', compact('roles_menu','krt'));
        }
    }

    function pemulihan_krt_ppd_1(Request $request, $id){
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
            $krt_profile        = DB::table('krt__profile')
                                    ->select('krt__profile.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__pemulihan.id AS krt_pemulihan_id',
                                            'krt__pemulihan.status AS status',
                                            DB::raw(" (case when krt__pemulihan.status = '3' then 'Perlu Dikemaskini'  else 'Belum Selesai' end) AS status_description"),
                                            'krt__pemulihan.disemak_note AS disemak_note',
                                            'krt__pemulihan.pemulihan_tempoh_bulan AS pemulihan_tempoh_bulan',
                                            'krt__pemulihan.pemulihan_punca_tidak_aktif AS pemulihan_punca_tidak_aktif',
                                            'krt__pemulihan.pemulihan_suku_thn_1 AS pemulihan_suku_thn_1',
                                            'krt__pemulihan.pemulihan_suku_thn_2 AS pemulihan_suku_thn_2',
                                            'krt__pemulihan.pemulihan_suku_thn_3 AS pemulihan_suku_thn_3',
                                            'krt__pemulihan.pemulihan_suku_thn_4 AS pemulihan_suku_thn_4',
                                            'krt__pemulihan.pemulihan_tempoh_pelaksanaan AS pemulihan_tempoh_pelaksanaan',
                                            'krt__pemulihan.pemulihan_cadangan_ppd AS pemulihan_cadangan_ppd',
                                            'krt__pemulihan.pemulihan_cadangan_hq AS pemulihan_cadangan_hq')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('krt__pemulihan','krt__pemulihan.krt_profile_id','=','krt__profile.id')
                                    ->where('krt__profile.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm11.pemulihan-krt-ppd-1', compact('roles_menu','krt_profile'));
        }
    }

    function post_laporan_pemulihan(Request $request){
        $action = $request->post_laporan_pemulihan;
        
        $rules = array(
            'pkpd1_pemulihan_tempoh_bulan'                 => 'required',
            'pkpd1_pemulihan_punca_tidak_aktif'            => 'required',
            'pkpd1_pemulihan_suku_thn_1'                   => 'required',
            'pkpd1_pemulihan_suku_thn_2'                   => 'required',
            'pkpd1_pemulihan_suku_thn_3'                   => 'required',
            'pkpd1_pemulihan_suku_thn_4'                   => 'required',
            'pkpd1_pemulihan_tempoh_pelaksanaan'           => 'required',
            'pkpd1_pemulihan_cadangan_ppd'                 => 'required',
            'pkpd1_pemulihan_cadangan_hq'                  => 'required',
        );

        $messages = [
            'pkpd1_pemulihan_tempoh_bulan.required'        => 'Ruangan Tempoh Tidak Aktif (Bulan) mesti diisi.',
            'pkpd1_pemulihan_punca_tidak_aktif.required'   => 'Ruangan Punca / Sebab Tidak Aktif mesti diisi',
            'pkpd1_pemulihan_suku_thn_1.required'          => 'Ruangan Suku Tahun Pertama (Jan - Mac) mesti diisi',
            'pkpd1_pemulihan_suku_thn_2.required'          => 'Ruangan Suku Tahun Kedua (Mac - Jul) mesti diisi',
            'pkpd1_pemulihan_suku_thn_3.required'          => 'Ruangan Suku Tahun Ketiga (Jul - Sep) mesti diisi',
            'pkpd1_pemulihan_suku_thn_4.required'          => 'Ruangan Suku Tahun Keempat (Sep - Dis) mesti diisi',
            'pkpd1_pemulihan_tempoh_pelaksanaan.required'  => 'Ruangan Tempoh Pemulihan Dilaksanakan mesti diisi',
            'pkpd1_pemulihan_cadangan_ppd.required'        => 'Ruangan Cadangan PPD mesti dipilih',
            'pkpd1_pemulihan_cadangan_hq.required'         => 'Ruangan Keputusan Mesyuarat Ibu Pejabat mesti dipilih',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'add') {
                $pemulihan_krt                                  = new Krt_Pemulihan;
                $pemulihan_krt->krt_profile_id                  = $request->pkpd1_krt_profile_id;
                $pemulihan_krt->pemulihan_tempoh_bulan          = $request->pkpd1_pemulihan_tempoh_bulan;
                $pemulihan_krt->pemulihan_punca_tidak_aktif     = $request->pkpd1_pemulihan_punca_tidak_aktif;
                $pemulihan_krt->pemulihan_suku_thn_1            = $request->pkpd1_pemulihan_suku_thn_1;
                $pemulihan_krt->pemulihan_suku_thn_2            = $request->pkpd1_pemulihan_suku_thn_2;
                $pemulihan_krt->pemulihan_suku_thn_3            = $request->pkpd1_pemulihan_suku_thn_3;
                $pemulihan_krt->pemulihan_suku_thn_4            = $request->pkpd1_pemulihan_suku_thn_4;
                $pemulihan_krt->pemulihan_tempoh_pelaksanaan    = $request->pkpd1_pemulihan_tempoh_pelaksanaan;
                $pemulihan_krt->pemulihan_cadangan_ppd          = $request->pkpd1_pemulihan_cadangan_ppd;
                $pemulihan_krt->pemulihan_cadangan_hq           = $request->pkpd1_pemulihan_cadangan_hq;
                $pemulihan_krt->status                          = 2;
                $pemulihan_krt->dihantar_by                     = Auth::user()->user_id;
                $pemulihan_krt->dihantar_date                   = date('Y-m-d H:i:s');
                $pemulihan_krt->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function post_laporan_pemulihan2(Request $request){
        $action = $request->post_laporan_pemulihan2;
        $app_id = $request->pkpd1_pemulihan_krt_id;
        
        $rules = array(
            'pkpd1_pemulihan_tempoh_bulan'                 => 'required',
            'pkpd1_pemulihan_punca_tidak_aktif'            => 'required',
            'pkpd1_pemulihan_suku_thn_1'                   => 'required',
            'pkpd1_pemulihan_suku_thn_2'                   => 'required',
            'pkpd1_pemulihan_suku_thn_3'                   => 'required',
            'pkpd1_pemulihan_suku_thn_4'                   => 'required',
            'pkpd1_pemulihan_tempoh_pelaksanaan'           => 'required',
            'pkpd1_pemulihan_cadangan_ppd'                 => 'required',
            'pkpd1_pemulihan_cadangan_hq'                  => 'required',
        );

        $messages = [
            'pkpd1_pemulihan_tempoh_bulan.required'        => 'Ruangan Tempoh Tidak Aktif (Bulan) mesti diisi.',
            'pkpd1_pemulihan_punca_tidak_aktif.required'   => 'Ruangan Punca / Sebab Tidak Aktif mesti diisi',
            'pkpd1_pemulihan_suku_thn_1.required'          => 'Ruangan Suku Tahun Pertama (Jan - Mac) mesti diisi',
            'pkpd1_pemulihan_suku_thn_2.required'          => 'Ruangan Suku Tahun Kedua (Mac - Jul) mesti diisi',
            'pkpd1_pemulihan_suku_thn_3.required'          => 'Ruangan Suku Tahun Ketiga (Jul - Sep) mesti diisi',
            'pkpd1_pemulihan_suku_thn_4.required'          => 'Ruangan Suku Tahun Keempat (Sep - Dis) mesti diisi',
            'pkpd1_pemulihan_tempoh_pelaksanaan.required'  => 'Ruangan Tempoh Pemulihan Dilaksanakan mesti diisi',
            'pkpd1_pemulihan_cadangan_ppd.required'        => 'Ruangan Cadangan PPD mesti dipilih',
            'pkpd1_pemulihan_cadangan_hq.required'         => 'Ruangan Keputusan Mesyuarat Ibu Pejabat mesti dipilih'
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $pemulihan_krt                                  = Krt_Pemulihan::where($where)->first();
                $pemulihan_krt->krt_profile_id                  = $request->pkpd1_krt_profile_id;
                $pemulihan_krt->pemulihan_tempoh_bulan          = $request->pkpd1_pemulihan_tempoh_bulan;
                $pemulihan_krt->pemulihan_punca_tidak_aktif     = $request->pkpd1_pemulihan_punca_tidak_aktif;
                $pemulihan_krt->pemulihan_suku_thn_1            = $request->pkpd1_pemulihan_suku_thn_1;
                $pemulihan_krt->pemulihan_suku_thn_2            = $request->pkpd1_pemulihan_suku_thn_2;
                $pemulihan_krt->pemulihan_suku_thn_3            = $request->pkpd1_pemulihan_suku_thn_3;
                $pemulihan_krt->pemulihan_suku_thn_4            = $request->pkpd1_pemulihan_suku_thn_4;
                $pemulihan_krt->pemulihan_tempoh_pelaksanaan    = $request->pkpd1_pemulihan_tempoh_pelaksanaan;
                $pemulihan_krt->pemulihan_cadangan_ppd          = $request->pkpd1_pemulihan_cadangan_ppd;
                $pemulihan_krt->pemulihan_cadangan_hq           = $request->pkpd1_pemulihan_cadangan_hq;
                $pemulihan_krt->status                          = 2;
                $pemulihan_krt->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function pemulihan_krt_ppn(Request $request){
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
            $data = DB::select(DB::raw("
                    select 
                    krt__profile.id,
                    ref__daerahs.daerah_description AS daerah,
                    krt__profile.krt_nama AS nama_krt,
                    CONCAT('RT',krt__profile.state_id,krt__profile.daerah_id,krt__profile.id) AS no_rujukan_krt,
                    (select count(*) from krt__ahli_jawatan_kuasa ac where ac.krt_profile_id = krt__profile.id AND ac.ajk_status = 1) as bil_ajk,
                    (select count(*) from krt__minit_mesyuarat bc where bc.krt_profile_id = krt__profile.id AND bc.mesyuarat_status = 1) as bil_mesyuarat,
                    (select count(*) from krt__aktiviti_laporan cc where cc.krt_profile_id = krt__profile.id AND cc.aktiviti_status = 1) as bil_aktiviti,
                    (select count(*) from krt__kewangan dc where dc.krt_profile_id = krt__profile.id AND dc.kewangan_status = 1) as bil_kewangan,
                    (select count(DISTINCT ec.cawangan_id) from krt__ahli_jawatan_kuasa_cawangan ec where ec.krt_profile_id = krt__profile.id AND ec.ajk_status = 1) as bil_cawangan,
                    (select count(*) from srs__profile fc where fc.krt_id = krt__profile.id AND fc.srs_status = 1) as bil_srs,
                    (select count(*) from srs__perancangan_rondaan gc where gc.krt_profile_id = krt__profile.id AND gc.perancangan_rondaan_status = 1) as bil_perancangan_srs,
                    (select count(*) from srs__pelaksanaan_rondaan hc where hc.krt_profile_id = krt__profile.id AND hc.pelaksanaan_rondaan_status = 1) as bil_pelaksanaan_srs,
                    (select count(*) from srs__pelaksanaan_rondaan ic where ic.krt_profile_id = krt__profile.id AND ic.pelaksanaan_rondaan_kes = 'Ada' AND ic.pelaksanaan_rondaan_status = 1) as bil_pengendalian_kes_srs,
                    (case when j.status = '1' then 'Selesai' when j.status = '2' then 'Dihantar Untuk Disemak Oleh PPN' else 'Belum Selesai' end) AS status,
                    ((case when a.krt_profile_id IS NOT NULL then 16 else 0 end) + 
                    (case when b.count_mesyuarat <= 6 then b.count_mesyuarat * 1 when b.count_mesyuarat > 6 then 6 else 0 end) +
                    (case when c.count_aktiviti <= 12 then c.count_aktiviti * 2 when c.count_aktiviti > 12 then 24 else 0 end) +
                    (case when d.count_kewangan <= 12 then d.count_kewangan * 1 when d.count_kewangan > 12 then 12 else 0 end) +
                    (case when e.count_cawangan <= 4 then e.count_cawangan * 3 when e.count_cawangan > 4 then 4 else 0 end) +
                    (case when f.krt_id IS NOT NULL then 5 else 0 end) +
                    (case when g.krt_profile_id IS NOT NULL then 2 else 0 end) +
                    (case when h.krt_profile_id IS NOT NULL then 8 else 0 end) +
                    (case when h.count_kes IS NOT NULL then 5 else 0 end) +
                    (case when i.keaktifan_markah IS NOT NULL then i.keaktifan_markah else 0 end)
                    ) AS markah
                    FROM krt__profile
                    LEFT JOIN ref__daerahs ON ref__daerahs.daerah_id = krt__profile.daerah_id
                    LEFT JOIN (
                        SELECT krt__ahli_jawatan_kuasa.krt_profile_id, count(*) AS count_ajk
                        FROM krt__ahli_jawatan_kuasa 
                        WHERE krt__ahli_jawatan_kuasa.ajk_status = 1
                        GROUP BY krt__ahli_jawatan_kuasa.krt_profile_id
                    ) a ON a.krt_profile_id = krt__profile.id
                    LEFT JOIN (
                        SELECT krt__minit_mesyuarat.krt_profile_id, count(*) AS count_mesyuarat
                        FROM krt__minit_mesyuarat
                        WHERE krt__minit_mesyuarat.mesyuarat_status = 1
                        GROUP BY krt__minit_mesyuarat.krt_profile_id
                    ) b ON b.krt_profile_id = krt__profile.id
                    LEFT JOIN (
                        SELECT krt__aktiviti_laporan.krt_profile_id, count(*) AS count_aktiviti
                        FROM krt__aktiviti_laporan 
                        WHERE krt__aktiviti_laporan.aktiviti_status = 1
                        GROUP BY krt__aktiviti_laporan.krt_profile_id
                    ) c ON c.krt_profile_id = krt__profile.id
                    LEFT JOIN (
                        SELECT krt__kewangan.krt_profile_id, count(*) AS count_kewangan
                        FROM krt__kewangan 
                        WHERE krt__kewangan.kewangan_status = 1
                        GROUP BY krt__kewangan.krt_profile_id
                    ) d ON d.krt_profile_id = krt__profile.id
                    LEFT JOIN (
                        SELECT krt__ahli_jawatan_kuasa_cawangan.krt_profile_id, COUNT(DISTINCT krt__ahli_jawatan_kuasa_cawangan.cawangan_id) AS count_cawangan
                        FROM krt__ahli_jawatan_kuasa_cawangan 
                        WHERE krt__ahli_jawatan_kuasa_cawangan.ajk_status = 1
                        GROUP BY krt__ahli_jawatan_kuasa_cawangan.krt_profile_id
                    ) e ON e.krt_profile_id = krt__profile.id
                    LEFT JOIN (
                        SELECT srs__profile.krt_id
                        FROM srs__profile 
                        WHERE srs__profile.srs_status = 1
                        GROUP BY srs__profile.krt_id
                    ) f ON f.krt_id = krt__profile.id
                    LEFT JOIN (
                    SELECT srs__perancangan_rondaan.krt_profile_id 
                        FROM srs__perancangan_rondaan 
                        WHERE srs__perancangan_rondaan.perancangan_rondaan_status = 1
                        GROUP BY srs__perancangan_rondaan.krt_profile_id
                    ) g ON g.krt_profile_id = krt__profile.id
                    LEFT JOIN (
                        SELECT srs__pelaksanaan_rondaan.krt_profile_id, COUNT(DISTINCT srs__pelaksanaan_rondaan.kategori_kes_id) AS count_kes
                        FROM srs__pelaksanaan_rondaan 
                        WHERE srs__pelaksanaan_rondaan.pelaksanaan_rondaan_status = 1
                        GROUP BY srs__pelaksanaan_rondaan.krt_profile_id
                    ) h ON h.krt_profile_id = krt__profile.id
                    LEFT JOIN (
                        SELECT krt__keaktifan.krt_profile_id, krt__keaktifan.status, krt__keaktifan.keaktifan_markah
                        FROM krt__keaktifan
                        GROUP BY krt__keaktifan.krt_profile_id, krt__keaktifan.status, krt__keaktifan.keaktifan_markah
                    ) i ON i.krt_profile_id = krt__profile.id
                    LEFT JOIN (
                        SELECT krt__pemulihan.krt_profile_id, krt__pemulihan.status
                        FROM krt__pemulihan
                        GROUP BY krt__pemulihan.krt_profile_id, krt__pemulihan.status
                    ) j ON j.krt_profile_id = krt__profile.id
                    WHERE krt__profile.krt_status = 1 AND j.status = 2 AND krt__profile.state_id = '" . Auth::user()->state_id . "'
                    GROUP BY krt__profile.id, krt__profile.krt_nama, krt__profile.state_id, krt__profile.daerah_id, a.krt_profile_id, b.count_mesyuarat, c.count_aktiviti, d.count_kewangan,
                    e.count_cawangan, f.krt_id, g.krt_profile_id, h.krt_profile_id, h.count_kes, i.status, i.keaktifan_markah, j.status, ref__daerahs.daerah_description
                    HAVING markah <= 30
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
            $daerah     = RefDaerah::where('state_id', '=',  Auth::user()->state_id)->get();
            $krt        = KRT_Profile::where('krt_status', '=', true)
                        ->where('krt__profile.state_id', '=', Auth::user()->state_id)
                        ->get();
            return view('rt-sm11.pemulihan-krt-ppn', compact('roles_menu','daerah','krt'));
        }
    }

    function pemulihan_krt_ppn_1(Request $request, $id){
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
            $krt_pemulihan      = DB::table('krt__pemulihan')
                                    ->select('krt__pemulihan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'ref__daerahs.daerah_description AS daerah_krt', 
                                            'ref__duns.dun_description AS dun_krt',
                                            'krt__pemulihan.pemulihan_tempoh_bulan AS pemulihan_tempoh_bulan',
                                            'krt__pemulihan.pemulihan_punca_tidak_aktif AS pemulihan_punca_tidak_aktif',
                                            'krt__pemulihan.pemulihan_suku_thn_1 AS pemulihan_suku_thn_1',
                                            'krt__pemulihan.pemulihan_suku_thn_2 AS pemulihan_suku_thn_2',
                                            'krt__pemulihan.pemulihan_suku_thn_3 AS pemulihan_suku_thn_3',
                                            'krt__pemulihan.pemulihan_suku_thn_4 AS pemulihan_suku_thn_4',
                                            'krt__pemulihan.pemulihan_tempoh_pelaksanaan AS pemulihan_tempoh_pelaksanaan',
                                            'krt__pemulihan.pemulihan_cadangan_ppd AS pemulihan_cadangan_ppd',
                                            'krt__pemulihan.pemulihan_cadangan_hq AS pemulihan_cadangan_hq')
                                    ->leftJoin('krt__profile','krt__profile.id','=','krt__pemulihan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('krt__pemulihan.krt_profile_id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            return view('rt-sm11.pemulihan-krt-ppn-1', compact('roles_menu','krt_pemulihan'));
        }
    }

    function post_semakan_pemulihan_krt(Request $request){
        $action = $request->post_semakan_pemulihan_krt;
        $app_id = $request->pkpn_pemulihan_krt_id;
        
        
        $rules = array(
            'pkpn_status'                  => 'required',
            'pkpn_disemak_note'            => 'required',
        );

        $messages = [
            'pkpn_status.required'         => 'Ruangan Status mesti dipilih',
            'pkpn_disemak_note.required'   => 'Ruangan Penerangan mesti diisi',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $semakan_pemulihan_krt                    = Krt_Pemulihan::where($where)->first();
                $semakan_pemulihan_krt->status            = $request->pkpn_status;
                $semakan_pemulihan_krt->disemak_note      = $request->pkpn_disemak_note;
                $semakan_pemulihan_krt->disemak_by        = Auth::user()->user_id;
                $semakan_pemulihan_krt->disemak_date      = date('Y-m-d H:i:s');
                $semakan_pemulihan_krt->save();
            }
        }
    }

    function senarai_laporan_pemulihan_krt_tidak_aktif(){
        return view('rt-sm11.senarai-laporan-pemulihan-krt-tidak-aktif');
    }

    function add_krt_tidak_aktif(){
        return view('rt-sm11.add-krt-tidak-aktif');
    }

    function senarai_laporan_pemulihan_krt_tidak_aktif_ppn(){
        return view('rt-sm11.senarai-laporan-pemulihan-krt-tidak-aktif-ppn');
    }

    function pengesahan_krt_tidak_aktif_ppn(){
        return view('rt-sm11.pengesahan-krt-tidak-aktif-ppn');
    }
}
