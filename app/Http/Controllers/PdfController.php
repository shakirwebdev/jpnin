<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;
use Auth;
use Session;
use Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Redirect;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use DataTables;
use App\KRT_Profile;
use App\KRT_Minit_Mesyuarat_Kehadiran;
use App\KRT_Minit_Mesyuarat_Perkara_Berbangkit;
use App\KRT_Minit_Mesyuarat_Kertas_Kerja;
use App\KRT_Minit_Mesyuarat_Hal_Lain;

class PdfController extends Controller
{

    public function surat_pelantikan_ajk(Request $request, $id){
            $surat_pelantikan_ajk_krt       = DB::table('krt__ahli_jawatan_kuasa')
                                            ->select('krt__ahli_jawatan_kuasa.id',
                                                    'krt__profile.krt_nama AS krt_nama',
                                                    'krt__profile.state_id AS krt_state',
                                                    'krt__profile.daerah_id AS krt_daerah',
                                                    'ref__daerahs.daerah_description AS daerah_description',
													'ref__states.state_description AS state_description',
                                                    'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                                                    'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                                    'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
                                                    'ref__jawatan_ajk_krt.jawatan_description AS ajk_jawatan',
                                                    'ref__status_krt_ajk.status_description AS ajk_status',
                                                    DB::raw(" DATEDIFF( NOW(), krt__ahli_jawatan_kuasa.ajk_tarikh_mula) AS ajk_status_pelantikan"),
                                                    DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa.ajk_tarikh_mula,'%d/%m/%Y') AS ajk_tarikh_mula"),
                                                    DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa.ajk_tarikh_akhir,'%d/%m/%Y') AS ajk_tarikh_akhir"),
                                                    'users__profile.user_fullname AS ajk_disahkan_oleh',
													'krt__tandatangan.userid AS userid',
                                                    DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa.disahkan_date,'%d/%m/%Y') AS ajk_tarikh_disahkan"))
                                            ->leftJoin('ref__jawatan_ajk_krt','ref__jawatan_ajk_krt.id','=','krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
                                            ->leftJoin('ref__status_krt_ajk','ref__status_krt_ajk.id','=','krt__ahli_jawatan_kuasa.ajk_status')
                                            ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
                                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
											->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
											->leftJoin('krt__tandatangan', function ($join) {
												$join->on('krt__tandatangan.state_id', '=', 'krt__profile.state_id');
												$join->on('krt__tandatangan.daerah_id', '=', 'krt__profile.daerah_id');
											})
											->leftJoin('users__profile','users__profile.user_id','=','krt__tandatangan.userid')
                                            ->where('krt__ahli_jawatan_kuasa.id', '=', $id)  
                                            ->limit(1)
                                            ->first();
    
        
        
        $pdf = PDF::loadView('print.print-surat-pelantikan-ajk', compact('surat_pelantikan_ajk_krt'))->setPaper('A4', 'potrait');
        return $pdf->stream('Surat Pelantikan AJK KRT.pdf');
    }
    
    public function kad_keahlian(Request $request, $id){
            $kad_keahlian_ajk_krt           = DB::table('krt__ahli_jawatan_kuasa')
                                            ->select('krt__ahli_jawatan_kuasa.id',
                                                    DB::raw(" CONCAT('KRT',krt__profile.state_id,krt__profile.daerah_id,krt__profile.id,krt__ahli_jawatan_kuasa.id) AS krt_id"),
                                                    'krt__profile.krt_nama AS krt_nama',
                                                    'ref__daerahs.daerah_description AS krt_daerah',
                                                    'ref__states.state_description AS krt_state',
                                                    'krt__profile.state_id AS krt_state_id',
                                                    'krt__profile.daerah_id AS krt_daera_id',
                                                    'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                                                    'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                                    'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
                                                    'ref__jawatan_ajk_krt.jawatan_description AS ajk_jawatan',
                                                    'ref__status_krt_ajk.status_description AS ajk_status',
                                                    DB::raw(" DATEDIFF( NOW(), krt__ahli_jawatan_kuasa.ajk_tarikh_mula) AS ajk_status_pelantikan"),
                                                    DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa.ajk_tarikh_mula,'%d/%m/%Y') AS ajk_tarikh_mula"),
                                                    DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa.ajk_tarikh_akhir,'%d/%m/%Y') AS ajk_tarikh_akhir"),
                                                    'users__profile.user_fullname AS ajk_disahkan_oleh',
                                                    DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa.disahkan_date,'%d/%m/%Y') AS ajk_tarikh_disahkan"),
                                                    'krt__ahli_jawatan_kuasa.file_avatar AS file_avatar')
                                            ->leftJoin('ref__jawatan_ajk_krt','ref__jawatan_ajk_krt.id','=','krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
                                            ->leftJoin('ref__status_krt_ajk','ref__status_krt_ajk.id','=','krt__ahli_jawatan_kuasa.ajk_status')
                                            ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
                                            ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                            ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                            ->leftJoin('users__profile','users__profile.user_id','=','krt__ahli_jawatan_kuasa.disahkan_by')
                                            ->where('krt__ahli_jawatan_kuasa.id', '=', $id)  
                                            ->limit(1)
                                            ->first();
        $customPaper = array(0,0,204.09448819,321.25984252);
        $pdf = PDF::loadView('kad.kad-keahlian-krt', compact('kad_keahlian_ajk_krt'))->setPaper($customPaper, 'potrait');
        return $pdf->stream('Kad Keahlian AJK KRT.pdf');
    }

    public function minit_mesyuarat(Request $request, $id){
                //$data_kehadiran                 = KRT_Minit_Mesyuarat_Kehadiran::where('krt_minit_mesyuarat_id', '=', $id)->get();
				$data_basic						= DB::table('krt__minit_mesyuarat')
												-> select('krt__minit_mesyuarat.krt_profile_id AS krt_id')
												-> where('krt__minit_mesyuarat.id','=',$id)
												->limit(1)
                                            	->first();
				$data_kehadiran					= DB::table('krt__minit_mesyuarat_kehadiran')
												-> select('krt__minit_mesyuarat_kehadiran.id',
												'krt__minit_mesyuarat_kehadiran.jenis_kehadiran',
												'krt__minit_mesyuarat_kehadiran.kehadiran_ic',
												'krt__minit_mesyuarat_kehadiran.kehadiran_nama',
												DB::raw(' check_jawatan(kehadiran_ic,kehadiran_ic) AS kehadiran_jawatan'),
												'krt__minit_mesyuarat_kehadiran.kehadiran_ic')
												-> where('krt__minit_mesyuarat_kehadiran.krt_minit_mesyuarat_id','=',$id)
												-> get();
				$data_ajk						= DB::table('krt__ahli_jawatan_kuasa')
												-> select('krt__ahli_jawatan_kuasa.ajk_nama',
												'krt__ahli_jawatan_kuasa.id',
												'krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id',
												'ref__jawatan_ajk_krt.jawatan_description')
												->leftJoin('ref__jawatan_ajk_krt','ref__jawatan_ajk_krt.id','=','krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
												-> where('krt__ahli_jawatan_kuasa.krt_profile_id','=',$data_basic->krt_id)
												-> where('krt__ahli_jawatan_kuasa.ajk_status','=',1)
												-> orderBy('krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id', 'asc')
												-> get();
                $data_pekara_berbangkit         = KRT_Minit_Mesyuarat_Perkara_Berbangkit::where('krt_minit_mesyuarat_id', '=', $id)->get();
                $data_kertas_kerja              = KRT_Minit_Mesyuarat_Kertas_Kerja::where('krt_minit_mesyuarat_id', '=', $id)->get();
                $data_hal_lain                  = KRT_Minit_Mesyuarat_Hal_Lain::where('krt_minit_mesyuarat_id', '=', $id)->get();
                $data_minit_mesyuarat           = DB::table('krt__minit_mesyuarat')
                                                ->select('krt__minit_mesyuarat.id',
                                                        'krt__profile.krt_nama AS nama_krt',
                                                        'krt__minit_mesyuarat.mesyuarat_bil AS mesyuarat_bil',
                                                        'krt__minit_mesyuarat.mesyuarat_title AS mesyuarat_title',
                                                        DB::raw(" DATE_FORMAT(krt__minit_mesyuarat.mesyuarat_tarikh,'%Y') AS tahun_mesyuarat"),
                                                        DB::raw(" DATE_FORMAT(krt__minit_mesyuarat.mesyuarat_tarikh,'%d/%m/%Y') AS tarikh_mesyuarat"),
                                                        'krt__minit_mesyuarat.mesyuarat_time AS masa_mesyuarat',
                                                        'krt__minit_mesyuarat.mesyuarat_tempat AS tempat_mesyuarat',
                                                        //'users__profile.user_fullname AS pengerusi_krt',
														'krt__minit_mesyuarat.pengerusi AS pengerusi_krt',
														'krt__minit_mesyuarat.pencatat AS pencatat',
														DB::raw(" DATE_FORMAT(krt__minit_mesyuarat.direkod_date,'%d/%m/%Y') AS tarikh_rekod"),
														DB::raw(" REPLACE(REPLACE(krt__minit_mesyuarat.mesyuarat_perutusan_pengerusi, '\r', ''), '\n', '<br />') AS perutusan_pengerusi_mesyuarat"),
														DB::raw(" REPLACE(REPLACE(krt__minit_mesyuarat.mesyuarat_yang_lalu, '\r', ''), '\n', '<br />') AS minit_yang_lalu_mesyuarat"),
														DB::raw(" REPLACE(REPLACE(krt__minit_mesyuarat.mesyuarat_penyata_kewangan, '\r', ''), '\n', '<br />') AS penyata_kewangan_mesyuarat"),
														DB::raw(" REPLACE(REPLACE(krt__minit_mesyuarat.mesyuarat_penutup, '\r', ''), '\n', '<br />') AS penutup_mesyuarat"),
                                                        'krt__minit_mesyuarat.mesyuarat_penutup AS penutup_mesyuarat2',
														DB::raw(" check_users(krt__minit_mesyuarat.disemak_by) AS penyemak"),
														DB::raw(" DATE_FORMAT(krt__minit_mesyuarat.disemak_date,'%d/%m/%Y') AS tarikh_semak"),
                                                        'krt__minit_mesyuarat.mesyuarat_title AS mesyuarat_tajuk')
                                                ->leftJoin('krt__profile','krt__profile.id','=','krt__minit_mesyuarat.krt_profile_id')
												//->leftJoin('users__profile', function($join)
        														//	{
																//		$join->on('users__profile.krt_id', '=', 'krt__profile.id');
																//		$join->on('users__profile.user_id', '=', 'krt__minit_mesyuarat.disemak_by');
																//	})
                                                ->leftJoin('users__profile','users__profile.krt_id','=','krt__profile.id')
											//	->leftJoin('users__profile','users__profile.user_id','=','krt__minit_mesyuarat.disemak_by')
                                                ->leftJoin('users','users.user_id','=','users__profile.user_id')
                                                ->where('krt__minit_mesyuarat.id', '=', $id)  
                                                ->limit(1)
                                                ->first();
                $data_krt                 	= DB::table('krt__profile')
											->select('krt__profile.daerah_id as daerah_id',
											'ref__daerahs.daerah_description as daerah',
											'ref__states.state_description as negeri')
											->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
											->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
											->where('krt__profile.id','=',$data_basic->krt_id)
											->limit(1)
                                            ->first();
        
        $pdf = PDF::loadView('print.print-minit-mesyuarat', 
        compact('data_krt','data_kehadiran', 'data_pekara_berbangkit', 'data_kertas_kerja' , 'data_hal_lain','data_minit_mesyuarat','data_ajk'))->setPaper('A4', 'potrait');
        $pdf->output();
		$domPdf = $pdf->getDomPDF();
		$canvas = $domPdf->get_canvas();
        $canvas->page_text(500, 810, "Mukasurat {PAGE_NUM} / {PAGE_COUNT}", null, 10, [0, 0, 0]);
		//return $pdf->download('itsolutionstuff.pdf');
		return $pdf->stream('asdasjihasd.pdf');
    }	

    public function kewangan_resit_penerimaan(Request $request, $id){
            $data_resit_penerimaan     = DB::table('krt__kewangan')
                                            ->select('krt__kewangan.id',
                                                    'krt__kewangan.kewangan_nama_penuh',
                                                    DB::raw(" FORMAT(krt__kewangan.kewangan_jumlah_bank + krt__kewangan.kewangan_jumlah_tunai, 2) AS total_jumlah"),
                                                    'krt__kewangan.kewangan_cek_baucer',
                                                    'krt__kewangan.kewangan_butiran',
                                                    DB::raw(" DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%d/%m/%Y') AS tarikh_kewangan"))
                                            ->where('krt__kewangan.id', '=', $id)  
                                            ->limit(1)
                                            ->first();
    
        // $pdf = PDF::loadView('kad.kad-keahlian-krt', $data);
        // return $pdf->stream('sss.pdf');
        
        $pdf = PDF::loadView('print.print-resit-penerimaan-kewangan', compact('data_resit_penerimaan'))->setPaper('A4', 'potrait');
        return $pdf->stream('asdasjihasd.pdf');
    }

    public function kewangan_baucer_pembayaran(Request $request, $id){
            $data_baucer_pembayaran     = DB::table('krt__kewangan')
                                            ->select('krt__kewangan.id',
                                                    'krt__kewangan.kewangan_nama_penuh',
                                                    'krt__kewangan.kewangan_alamat',
                                                    DB::raw(" krt__kewangan.kewangan_jumlah_bank + krt__kewangan.kewangan_jumlah_tunai AS total_jumlah"),
                                                    'krt__kewangan.kewangan_cek_baucer',
                                                    'krt__kewangan.kewangan_butiran',
                                                    DB::raw(" DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%d/%m/%Y') AS tarikh_kewangan"))
                                            ->where('krt__kewangan.id', '=', $id)  
                                            ->limit(1)
                                            ->first();
    
        // $pdf = PDF::loadView('kad.kad-keahlian-krt', $data);
        // return $pdf->stream('sss.pdf');
        
        $pdf = PDF::loadView('print.print-baucer-bayaran-kewangan', compact('data_baucer_pembayaran'))->setPaper('A4', 'potrait');
        return $pdf->stream('asdasjihasd.pdf');
    }

    public function laporan_kewangan_rt(Request $request, $krt, $bulan, $tahun){
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
				'kewangan_dokumen_cek.kewangan_cek_baucer AS no_cek',
				DB::raw("DATE_FORMAT(kewangan_dokumen_cek.kewangan_tarikh_cek,'%d/%m/%Y') AS tarikh_cek"),
				'kewangan_dokumen_resit.kewangan_cek_baucer AS no_resit',
				DB::raw("DATE_FORMAT(kewangan_dokumen_resit.kewangan_tarikh_cek,'%d/%m/%Y') AS tarikh_resit"),
				'kewangan_dokumen_baucer.kewangan_cek_baucer AS no_baucer',
				DB::raw("DATE_FORMAT(kewangan_dokumen_baucer.kewangan_tarikh_cek,'%d/%m/%Y') AS tarikh_baucer"),
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
				->get();
								
		/*$laporan_kewangan = DB::table('krt__kewangan')
							->select('krt__kewangan.id',
							'krt__kewangan.kewangan_butiran',
            				'krt__kewangan.kewangan_alamat',
            				'krt__kewangan.kewangan_nama_penuh',
							DB::raw("DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b, '%d/%m/%Y') AS tarikh_t_b"),
							'kewangan_dokumen_cek.kewangan_cek_baucer AS no_cek',
							'kewangan_dokumen_baucer.kewangan_cek_baucer AS no_baucer',
							DB::raw("CASE WHEN krt__kewangan.kewangan_jenis_kewangan = 1 THEN krt__kewangan.kewangan_jumlah_tunai ELSE '0' END AS terima_tunai"),
            				DB::raw("CASE WHEN krt__kewangan.kewangan_jenis_kewangan = 1 THEN krt__kewangan.kewangan_jumlah_bank ELSE '0' END AS terima_bank"),
            				DB::raw("CASE WHEN krt__kewangan.kewangan_jenis_kewangan = 2 THEN krt__kewangan.kewangan_jumlah_tunai ELSE '0' END AS bayar_tunai"),
            				DB::raw("CASE WHEN krt__kewangan.kewangan_jenis_kewangan = 2 THEN krt__kewangan.kewangan_jumlah_bank ELSE '0' END AS bayar_bank"),
							DB::raw(" semak_baki_tunai_sah(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(krt__kewangan.kewangan_masa_t_b,'00:00:00'),'%H%i%s'))) as kewangan_baki_tunai"),
							DB::raw(" semak_baki_bank_sah(krt__kewangan.krt_profile_id,concat(date_format(krt__kewangan.kewangan_tarikh_t_b,'%Y%m%d'),time_format(IFNULL(krt__kewangan.kewangan_masa_t_b,'00:00:00'),'%H%i%s'))) as kewangan_baki_bank"))
							->leftJoin('kewangan_dokumen_cek','kewangan_dokumen_cek.kewangan_id','=','krt__kewangan.id')
							->leftJoin('kewangan_dokumen_baucer','kewangan_dokumen_baucer.kewangan_id','=','krt__kewangan.id')
							->where('krt__kewangan.krt_profile_id', '=', $id)
        					->where('krt__kewangan.kewangan_status', '=', 1)
							->orderBy('krt__kewangan.kewangan_tarikh_t_b', 'ASC')
        					->get();
							
        /*$laporan_kewangan   = DB::table('krt__kewangan')
        					->select('krt__kewangan.id',
            				'krt__kewangan.kewangan_jenis_kewangan',
            				'krt__kewangan.kewangan_butiran',
            				'krt__kewangan.kewangan_alamat',
            				'krt__kewangan.kewangan_nama_penuh',
            				DB::raw("DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b, '%d/%m/%Y') AS tarikh_t_b"),
            				DB::raw("GROUP_CONCAT( CONCAT(CASE 
                            				WHEN jenis = 1 THEN 'No. Baucer :'
                                            WHEN jenis = 2 THEN 'No. Cek :'
                                            ELSE 'No. Resit : '
                                        	END, ' ', krt__kewangan_dokumen.kewangan_cek_baucer, ' ', '(', krt__kewangan_dokumen.kewangan_tarikh_cek, ')', ',') ) AS Concatenated_Jenis"),
            				DB::raw("CASE WHEN krt__kewangan.kewangan_jenis_kewangan = 1 THEN krt__kewangan.kewangan_jumlah_tunai ELSE '0' END AS terima_tunai"),
            				DB::raw("CASE WHEN krt__kewangan.kewangan_jenis_kewangan = 1 THEN krt__kewangan.kewangan_jumlah_bank ELSE '0' END AS terima_bank"),
            				DB::raw("CASE WHEN krt__kewangan.kewangan_jenis_kewangan = 2 THEN krt__kewangan.kewangan_jumlah_tunai ELSE '0' END AS bayar_tunai"),
            				DB::raw("CASE WHEN krt__kewangan.kewangan_jenis_kewangan = 2 THEN krt__kewangan.kewangan_jumlah_bank ELSE '0' END AS bayar_bank"),
            				'krt__kewangan.kewangan_baki_tunai AS kewangan_baki_tunai',
            				'krt__kewangan.kewangan_baki_bank AS kewangan_baki_bank')
        					->leftJoin('krt__kewangan_dokumen', 'krt__kewangan_dokumen.kewangan_id', '=', 'krt__kewangan.id')
        					->where('krt__kewangan.krt_profile_id', '=', $id)
        					->where('krt__kewangan.kewangan_status', '=', 1)
							//->groupBy('krt__kewangan.id')
							->groupBy(['krt__kewangan.id','krt__kewangan.kewangan_jenis_kewangan','krt__kewangan.kewangan_butiran','krt__kewangan.kewangan_alamat','krt__kewangan.kewangan_nama_penuh'])
        					->orderBy('krt__kewangan.kewangan_tarikh_t_b', 'ASC')
        					->get();
		*/
        $profile_krt     = DB::table('krt__kewangan')
                                ->select('krt__profile.id AS id',
                                        'krt__profile.krt_nama AS krt_nama',
                                        'krt__profile.krt_bank_no_acc as bank_no_acc',
                                        'krt__profile.krt_bank_nama AS bank_nama',
                                        'krt__profile.krt_bank_no_evendor AS no_evendor',
                                        'ref__daerahs.daerah_description AS daerah',
                                        'ref__states.state_description AS state')
                                ->leftJoin('krt__profile','krt__profile.id','=','krt__kewangan.krt_profile_id')
                                ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                ->where('krt__profile.id', '=', $id)
                                ->limit(1)
                                ->first();

        $sign            = DB::table('users__profile')
                              ->select('users__profile.user_id',
                                        'users__profile.user_id AS asrap',
                                        'krt__profile.krt_nama',
                                        'users__profile.user_fullname')
                              ->where('users__profile.krt_id', '=', $id)
                              ->where('users.user_role', '=', 12)
                              ->leftJoin('users','users.user_id','=','users__profile.user_id')
                              ->leftJoin('krt__profile','krt__profile.id','=','users__profile.krt_id')
                              ->limit(1)
                              ->first();
							  
        $pdf = PDF::loadView('print.print-laporan-kewangan-rt', compact('profile_krt','laporan_kewangan','sign'))->setPaper('A4', 'landscape');
		$pdf->output();
		$domPdf = $pdf->getDomPDF();
		$canvas = $domPdf->get_canvas();
        $canvas->page_text(700, 548, "Mukasurat {PAGE_NUM} / {PAGE_COUNT}", null, 10, [0, 0, 0]);
        return $pdf->stream('asdasjihasd.pdf');
    }
	
	public function laporan_kewangan_rt_pdf(Request $request, $krt, $bulan, $tahun){
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
				'kewangan_dokumen_cek.kewangan_cek_baucer AS no_cek',
				DB::raw("DATE_FORMAT(kewangan_dokumen_cek.kewangan_tarikh_cek,'%d/%m/%Y') AS tarikh_cek"),
				'kewangan_dokumen_resit.kewangan_cek_baucer AS no_resit',
				DB::raw("DATE_FORMAT(kewangan_dokumen_resit.kewangan_tarikh_cek,'%d/%m/%Y') AS tarikh_resit"),
				'kewangan_dokumen_baucer.kewangan_cek_baucer AS no_baucer',
				DB::raw("DATE_FORMAT(kewangan_dokumen_baucer.kewangan_tarikh_cek,'%d/%m/%Y') AS tarikh_baucer"),
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
								
        $profile_krt     = DB::table('krt__kewangan')
                                ->select('krt__profile.id AS id',
                                        'krt__profile.krt_nama AS krt_nama',
                                        'krt__profile.krt_bank_no_acc as bank_no_acc',
                                        'krt__profile.krt_bank_nama AS bank_nama',
                                        'krt__profile.krt_bank_no_evendor AS no_evendor',
                                        'ref__daerahs.daerah_description AS daerah',
                                        'ref__states.state_description AS state',
										DB::raw($v_bulan." AS kew_bulan"),
										DB::raw($v_tahun." AS kew_tahun"))
                                ->leftJoin('krt__profile','krt__profile.id','=','krt__kewangan.krt_profile_id')
                                ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                ->where('krt__profile.id', '=', $v_krt)
                                ->limit(1)
                                ->first();

        $sign_bendahari       = DB::table('users__profile')
                              ->select('users__profile.user_id',
                                        'users__profile.user_id AS asrap',
                                        'krt__profile.krt_nama',
                                        'users__profile.user_fullname')
                              ->where('users__profile.krt_id', '=', $v_krt)
                              ->where('users.user_role', '=', 12)
                              ->leftJoin('users','users.user_id','=','users__profile.user_id')
                              ->leftJoin('krt__profile','krt__profile.id','=','users__profile.krt_id')
                              ->limit(1)
                              ->first();
		$sign_pengerusi       = DB::table('users__profile')
                              ->select('users__profile.user_id',
                                        'users__profile.user_id AS asrap',
                                        'krt__profile.krt_nama',
                                        'users__profile.user_fullname')
                              ->where('users__profile.krt_id', '=', $v_krt)
                              ->where('users.user_role', '=', 10)
							  ->where('users.user_status', '=', 1)
                              ->leftJoin('users','users.user_id','=','users__profile.user_id')
                              ->leftJoin('krt__profile','krt__profile.id','=','users__profile.krt_id')
                              ->limit(1)
                              ->first();
							  
        $pdf = PDF::loadView('print.print-laporan-kewangan-rt', compact('profile_krt','laporan_kewangan','sign_bendahari','sign_pengerusi'))->setPaper('A4', 'landscape');
		$pdf->output();
		$domPdf = $pdf->getDomPDF();
		$canvas = $domPdf->get_canvas();
        $canvas->page_text(700, 548, "Mukasurat {PAGE_NUM} / {PAGE_COUNT}", null, 10, [0, 0, 0]);
        return $pdf->stream('asdasjihasd.pdf');
    }
	
	public function laporan_keaktifan(Request $request, $state, $parlimen, $daerah, $dun, $krt, $tahun, $kunci_ajk, $kunci_aktiviti, $kunci_mesyuarat, $kunci_kewangan){
		
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
						->leftJoin(DB::raw("(select krt__ahli_jawatan_kuasa.krt_profile_id,count(krt__ahli_jawatan_kuasa.id) as cnt_ajk from krt__ahli_jawatan_kuasa where ajk_nama is not null and '".$tahun."' >= date_format(krt__ahli_jawatan_kuasa.ajk_tarikh_mula,'%Y') and '".$tahun."'<=date_format(krt__ahli_jawatan_kuasa.ajk_tarikh_akhir,'%Y') and date_format(krt__ahli_jawatan_kuasa.updated_at,'%Y%m%d%h%i%s')<='".$kunci_ajk."' group by krt__ahli_jawatan_kuasa.krt_profile_id) as vw_ajk"),function($join){
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

        $pdf = PDF::loadView('print.print-laporan-keaktifan', compact('data'))->setPaper('A4', 'landscape');
		$pdf->output();
		$domPdf = $pdf->getDomPDF();
		$canvas = $domPdf->get_canvas();
        $canvas->page_text(700, 570, "Mukasurat {PAGE_NUM} / {PAGE_COUNT}", null, 10, [0, 0, 0]);
        return $pdf->stream('asdasjihasd.pdf');
    }

    public function aktiviti_surat_perancangan_aktiviti_hq(Request $request, $id){
        
        $data_surat_perancangan_aktiviti     = DB::table('krt__aktiviti_surat_perancangan')
                                                ->select('krt__aktiviti_surat_perancangan.id',
                                                'krt__aktiviti_surat_perancangan.surat_tahun',
                                                DB::raw(" DATE_FORMAT(krt__aktiviti_surat_perancangan.surat_tarikh,'%d/%m/%Y') AS surat_tarikh"),
                                                'krt__aktiviti_surat_perancangan.created_at',
                                                'users__profile.user_fullname AS create_by')
                                                ->leftJoin('users__profile','users__profile.user_id','=','krt__aktiviti_surat_perancangan.create_by')
                                                ->orderBy('krt__aktiviti_surat_perancangan.id', 'asc')
                                                ->where('krt__aktiviti_surat_perancangan.id', '=', $id)  
                                                ->limit(1)
                                                ->first();

        $pdf = PDF::loadView('print.print-aktiviti-surat-perancangan-hq', compact('data_surat_perancangan_aktiviti'))->setPaper('A4', 'potrait');
        return $pdf->stream('asdasjihasd.pdf');
    }

    public function perancangan_rondaan_srs(Request $request, $id){
        $ahli_peronda           = DB::table('srs__perancangan_rondaan_ahli')
                                    ->select('srs__perancangan_rondaan_ahli.id',
                                            'srs__ahli_peronda.peronda_nama AS peronda_nama',
                                            'srs__ahli_peronda.peronda_ic AS peronda_ic')
                                    ->leftJoin('srs__ahli_peronda','srs__ahli_peronda.id','=','srs__perancangan_rondaan_ahli.srs_ahli_peronda_id')
                                    ->where('srs__perancangan_rondaan_ahli.srs_perancangan_rondaan_id', '=', $id)
                                    ->get();
        $perancangan_rondaan    = DB::table('srs__perancangan_rondaan')
                                    ->select('srs__perancangan_rondaan.id',
                                            'krt__profile.krt_nama AS nama_krt',
                                            'krt__profile.krt_alamat AS alamat_krt',
                                            'ref__states.state_description AS negeri_krt', 
                                            'ref__daerahs.daerah_description AS daerah_krt',
                                            'ref__parlimens.parlimen_description AS parlimen_krt',
                                            'ref__duns.dun_description AS dun_krt',
                                            'ref__pbts.pbt_description AS pbt_krt',
                                            'srs__profile.srs_name AS nama_srs',
                                            'srs__perancangan_rondaan.krt_profile_id AS krt_profile_id',
                                            'srs__perancangan_rondaan.srs_profile_id AS srs_profile_id',
                                            DB::raw(" DATE_FORMAT(srs__perancangan_rondaan.perancangan_rondaan_tarikh,'%d/%m/%Y') AS perancangan_rondaan_tarikh"))
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__perancangan_rondaan.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->leftJoin('srs__profile','srs__profile.id','=','srs__perancangan_rondaan.srs_profile_id')
                                    ->where('srs__perancangan_rondaan.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
        

        $pdf = PDF::loadView('print.print-perancangan-rondaan-srs', compact('ahli_peronda','perancangan_rondaan'))->setPaper('A4', 'potrait');
        return $pdf->stream('asdasjihasd.pdf');
    }

    public function notis_pembatalan_srs(Request $request, $id){
                $data_pembatalan_srs    = DB::table('srs__permohonan_pembatalan_srs')
                                                ->select('srs__permohonan_pembatalan_srs.id',
                                                        'srs__profile.srs_name AS nama_srs',
                                                        DB::raw(" DATE_FORMAT(srs__permohonan_pembatalan_srs.diluluskan_date,'%d/%m/%Y') AS diluluskan_date"))
                                                ->leftJoin('srs__profile','srs__profile.id','=','srs__permohonan_pembatalan_srs.srs_profile_id')  
                                                ->where('srs__permohonan_pembatalan_srs.id', '=', $id)  
                                                ->limit(1)
                                                ->first();
        $pdf = PDF::loadView('print.notis-pembatalan-srs', compact('data_pembatalan_srs'))->setPaper('A4', 'potrait');
        return $pdf->stream('asdasjihasd.pdf');
    }

    public function report_kewangan_krt(Request $request, $id){
                $data_kewangan_krt1     = DB::table('krt__kewangan')
                                                ->select('krt__profile.id',
                                                        'ref__states.state_description AS state',
                                                        'ref__daerahs.daerah_description AS daerah',
                                                        'krt__profile.krt_nama AS nama_krt',
                                                        'krt__kewangan.kewangan_butiran AS butiran',
                                                        DB::raw(" DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%d/%m/%Y') AS tarikh_pp"),
                                                        'krt__kewangan.kewangan_cek_baucer AS no_cek_baucer',
                                                        DB::raw(" DATE_FORMAT(krt__kewangan.kewangan_tarikh_cek,'%d/%m/%Y') AS tarikh_cek_baucer"),
                                                        DB::raw(" (case when krt__kewangan.kewangan_jenis_kewangan = 1 then krt__kewangan.kewangan_jumlah_bank else 0 end) AS penerimaan_bank"),
                                                        DB::raw(" (case when krt__kewangan.kewangan_jenis_kewangan = 1 then krt__kewangan.kewangan_jumlah_tunai else 0 end) AS penerimaan_tunai"),
                                                        DB::raw(" (case when krt__kewangan.kewangan_jenis_kewangan = 2 then krt__kewangan.kewangan_jumlah_bank else 0 end) AS pembayaran_bank"),
                                                        DB::raw(" (case when krt__kewangan.kewangan_jenis_kewangan = 2 then krt__kewangan.kewangan_jumlah_tunai else 0 end) AS pembayaran_tunai"),
                                                        DB::raw(" (case when krt__kewangan.kewangan_jenis_kewangan = 1 then krt__kewangan.kewangan_jumlah_bank  else 0 end) + 
                                                        (case when krt__kewangan.kewangan_jenis_kewangan = 2 then krt__kewangan.kewangan_jumlah_bank  else 0 end)  AS total_bank"),
                                                        DB::raw(" (case when krt__kewangan.kewangan_jenis_kewangan = 1 then krt__kewangan.kewangan_jumlah_tunai else 0 end) -
                                                        (case when krt__kewangan.kewangan_jenis_kewangan = 2 then krt__kewangan.kewangan_jumlah_tunai else 0 end) AS total_tunai"),
                                                        DB::raw(" (case when krt__kewangan.kewangan_jenis_kewangan = 1 then krt__kewangan.kewangan_jumlah_bank else 0 end) - 
                                                        (case when krt__kewangan.kewangan_jenis_kewangan = 2 then krt__kewangan.kewangan_jumlah_bank else 0 end) +
                                                        (case when krt__kewangan.kewangan_jenis_kewangan = 1 then krt__kewangan.kewangan_jumlah_tunai else 0 end) -
                                                        (case when krt__kewangan.kewangan_jenis_kewangan = 2 then krt__kewangan.kewangan_jumlah_tunai else 0 end) AS total_baki"))
                                                ->leftJoin('krt__profile','krt__profile.id','=','krt__kewangan.krt_profile_id') 
                                                ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id') 
                                                ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id') 
                                                ->where('krt__kewangan.kewangan_status', '=', 1) 
                                                ->where('krt__kewangan.krt_profile_id', '=', $id)  
                                                ->get();
        $pdf = PDF::loadView('print.report-kewangan-krt', compact('data_kewangan_krt1'))->setPaper('A4', 'landscape');
        return $pdf->stream('asdasjihasd.pdf');
    }

    public function notis_pembatalan_krt(Request $request, $id){
        $data_notis_pembatalan_krt      = DB::table('krt__pembatalan')
                                        ->select('krt__pembatalan.id',
                                                'krt__profile.id AS krt_profile_id',
                                                'krt__profile.krt_nama AS nama_krt',
                                                'krt__profile.state_id AS state_id',
                                                'krt__profile.daerah_id AS daerah_id',
                                                DB::raw(" DATE_FORMAT(krt__pembatalan.diluluskan_date,'%d/%m/%Y') AS diluluskan_date"))
                                        ->leftJoin('krt__profile','krt__profile.id','=','krt__pembatalan.krt_profile_id') 
                                        ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id') 
                                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id') 
                                        ->where('krt__pembatalan.id', '=', $id)  
                                        ->get();
        $pdf = PDF::loadView('print.notis_pembatalan-krt', compact('data_notis_pembatalan_krt'))->setPaper('A4', 'potrait');
        return $pdf->stream('asdasjihasd.pdf');
    }

    /* public function srs_kad_keahlian(Request $request, $id){
        $kad_keahlian_ajk_srs           = DB::table('srs__ahli_peronda')
                                        ->select('srs__ahli_peronda.id',
                                                DB::raw(" CONCAT('SRS',krt__profile.state_id,krt__profile.daerah_id,srs__profile.id) AS srs_id"),
                                                'srs__ahli_peronda.peronda_nama AS peronda_nama',
                                                'srs__ahli_peronda.peronda_ic AS peronda_ic',
                                                'srs__ahli_peronda.peronda_alamat AS peronda_alamat',
                                                'srs__profile.srs_name AS srs_name',
                                                'srs__ahli_peronda.file_gambar_profile AS file_gambar_profile')
                                        ->leftJoin('srs__profile','srs__profile.id','=','srs__ahli_peronda.srs_profile_id')
                                        ->leftJoin('krt__profile','krt__profile.id','=','srs__ahli_peronda.krt_profile_id')
                                        ->where('srs__ahli_peronda.id', '=', $id)  
                                        ->limit(1)
                                        ->first();
    
    
        $customPaper = array(0,0,204.09448819,321.25984252);
        $pdf = PDF::loadView('kad.kad-keahlian-srs', compact('kad_keahlian_ajk_srs'))->setPaper($customPaper, 'potrait');
        return $pdf->stream('Kad Keahlian AJK KRT.pdf');
    } */
	
	public function srs_kad_keahlian(Request $request, $id){
          $kad_keahlian_ajk_srs           = DB::table('srs__ahli_peronda')
                                        ->select('srs__ahli_peronda.id',
                                                DB::raw(" CONCAT('SRS',krt__profile.state_id,krt__profile.daerah_id,srs__profile.id) AS srs_id"),
                                                'srs__ahli_peronda.peronda_nama AS peronda_nama',
                                                'srs__ahli_peronda.peronda_ic AS peronda_ic',
                                                'srs__ahli_peronda.peronda_alamat AS peronda_alamat',
                                                'srs__profile.srs_name AS srs_name',
                                                'srs__ahli_peronda.file_gambar_profile AS file_gambar_profile',
                                                'ref__daerahs.daerah_description AS srs_daerah',
	                                              'ref__states.state_description AS srs_state')
                                        ->leftJoin('srs__profile','srs__profile.id','=','srs__ahli_peronda.srs_profile_id')
                                        ->leftJoin('krt__profile','krt__profile.id','=','srs__ahli_peronda.krt_profile_id')
                                        ->leftJoin('ref__daerahs', 'ref__daerahs.daerah_id','=', 'krt__profile.daerah_id')
                                        ->leftJoin('ref__states', 'ref__states.state_id', '=', 'krt__profile.state_id')
                                        ->where('srs__ahli_peronda.id', '=', $id)
                                        ->limit(1)
                                        ->first();
          $customPaper = array(0,0,204.09448819,321.25984252);
          $pdf = PDF::loadView('kad.kad-keahlian-srs', compact('kad_keahlian_ajk_srs'))->setPaper($customPaper, 'potrait');
          return $pdf->stream('Kad Keahlian AJK KRT.pdf');
        }

        public function kad_imediator(Request $request, $id){
            $kad_keahlian_mkp       = DB::table('spk__imediator')
                                  ->select('spk__imediator.id',
                                          'users__profile.user_fullname',
                                          'users__profile.no_ic',
                                          'spk__imediator.mkp_file_avatar AS file_gambar_profile',
                                          DB::raw("DATE_FORMAT(spk__imediator.mkp_tarikh_dilantik,'%d/%m/%Y') AS tarikh_mula"),
                                          DB::raw("DATE_FORMAT(DATE_ADD(spk__imediator.mkp_tarikh_dilantik, INTERVAL 731 DAY),'%d/%m/%Y') AS tarikh_tamat"),
                                          'ref__states.state_description AS mkp_state')
                                  ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                                  ->leftJoin('users__profile','users__profile.user_id','=','users.user_id')
                                  ->leftJoin('ref__states', 'ref__states.state_id', '=', 'users__profile.state_id')
                                  ->where('spk__imediator.id', '=', $id)
                                  ->limit(1)
                                  ->first();
            $customPaper = array(0,0,204.09448819,321.25984252);
            $pdf = PDF::loadView('kad.kad-keahlian-mediator', compact('kad_keahlian_mkp'))->setPaper($customPaper, 'potrait');
            return $pdf->stream('Kad Keahlian iMediator.pdf');
          }



        public function surat_pelantikan_mediator(Request $request, $id){
          $data_pelantikan_mkp    = DB::table('spk__imediator')
                                ->select('spk__imediator.id',
                                        'users__profile.user_fullname AS mkp_pemohon_nama',
                                        'users__profile.no_ic AS mkp_pemohon_ic',
                                        DB::raw(" DATE_FORMAT(spk__imediator.dilantik_date,'%d/%m/%Y') AS dilantik_date"),
                                        'users__profile.user_fullname AS user_fullname',
                                        DB::raw("DATE_FORMAT(DATE_ADD(spk__imediator.mkp_tarikh_dilantik, INTERVAL 731 DAY),'%d/%m/%Y') AS tarikh_tamat"))
                                ->leftJoin('users__profile','users__profile.user_id','=','spk__imediator.user_id')
                                ->where('spk__imediator.id', '=', $id)  
                                ->get();
          $pdf = PDF::loadView('print.print-surat-pelantikan-mediator', compact('data_pelantikan_mkp'))->setPaper('A4', 'potrait');
          return $pdf->stream('Surat Pelantikan AJK KRT.pdf');
        }

    public function surat_pemakluman_tabika(Request $request, $id){
        $lulus_permohonan_pelajar  = DB::table('tbk__student')
                                ->select('tbk__student.id',
                                        'tbk__student.ibu_nama AS ibu_nama',
                                        'tbk__student.bapa_nama AS bapa_nama',
                                        'tbk__student.student_alamat AS student_alamat',
                                        'tbk__student.student_nama AS student_nama',
                                        'tbk__profile.tbk_nama AS tbk_nama',
                                        'ref__states.state_description AS state',
                                        'ref__daerahs.daerah_description AS daerah',
                                        'users__profile.user_fullname AS user_fullname',
                                        DB::raw("DATE_FORMAT(tbk__student.diluluskan_date,'%d/%m/%Y') AS tarikh_lulus"))
                                ->leftJoin('tbk__profile','tbk__profile.id','=','tbk__student.tabika_id')
                                ->leftJoin('ref__states','ref__states.state_id','=','tbk__profile.state_id')
                                ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','tbk__profile.daerah_id')
                                ->leftJoin('users__profile','users__profile.user_id','=','tbk__student.diluluskan_by')
                                ->where('tbk__student.id', '=', $id)  
                                ->get();
        $pdf = PDF::loadView('print.print-surat-pemakluman-tabika', compact('lulus_permohonan_pelajar'))->setPaper('A4', 'potrait');
        return $pdf->stream('Surat Pemakluman kelulusan Tabika.pdf');
    }

    public function surat_pemakluman_tabika_xberjaya(Request $request, $id){
        $permohonan_pelajar  = DB::table('tbk__student')
                                ->select('tbk__student.id',
                                        'tbk__student.ibu_nama AS ibu_nama',
                                        'tbk__student.bapa_nama AS bapa_nama',
                                        'tbk__student.student_alamat AS student_alamat',
                                        'tbk__student.student_nama AS student_nama',
                                        'tbk__profile.tbk_nama AS tbk_nama',
                                        'ref__states.state_description AS state',
                                        'ref__daerahs.daerah_description AS daerah',
                                        'users__profile.user_fullname AS user_fullname',
                                        DB::raw("DATE_FORMAT(tbk__student.disahkan_date,'%d/%m/%Y') AS tarikh_disahkan"),
                                        'tbk__student.ditolak_tahun AS ditolak_tahun',
                                        'tbk__student.ditolak_penuh AS ditolak_penuh',
                                        'tbk__student.ditolak_xlengkap AS ditolak_xlengkap',
                                        'tbk__student.ditolak_jauh AS ditolak_jauh')
                                ->leftJoin('tbk__profile','tbk__profile.id','=','tbk__student.tabika_id')
                                ->leftJoin('ref__states','ref__states.state_id','=','tbk__profile.state_id')
                                ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','tbk__profile.daerah_id')
                                ->leftJoin('users__profile','users__profile.user_id','=','tbk__student.diluluskan_by')
                                ->where('tbk__student.id', '=', $id)  
                                ->get();
        $pdf = PDF::loadView('print.print-surat-pemakluman-tabika-xberjaya', compact('permohonan_pelajar'))->setPaper('A4', 'potrait');
        return $pdf->stream('Surat Pemakluman Ditolak Kemasukan Tabika Perpaduan.pdf');
    }

	public function laporan_aktiviti_rt_pdf(Request $request, $negeri, $daerah, $agenda, $bidang, $kategori, $jenis)
	{
		$v_where =  "";
		$v_negeri = $negeri;
		if($v_negeri != "null")
		{
			$v_where = " ref__states.state_description='". $v_negeri ."'";
		}
		$v_daerah = $daerah;
		if($v_daerah != "null")
		{
			if($v_where != "")
				$v_where = $v_where . " AND ref__daerahs.daerah_description='". $v_daerah ."'";
			else
				$v_where = " ref__daerahs.daerah_description='". $v_daerah ."'";
		}
		$v_agenda = $agenda;
		if($v_agenda != "null")
		{
			if($v_where != "")
				$v_where = $v_where . " AND ref__aktiviti_agenda_kerja.agenda_description='". $v_agenda ."'";
			else
				$v_where = " ref__aktiviti_agenda_kerja.agenda_description='". $v_agenda ."'";
		}
		$v_bidang = $bidang;
		if($v_bidang != "null")
		{
			if($v_where != "")
				$v_where = $v_where . " AND ref__aktiviti_bidang.bidang_description='". $v_bidang ."'";
			else
				$v_where = " ref__aktiviti_bidang.bidang_description='". $v_bidang ."'";
		}
		$v_kategori = $kategori;
		if($v_kategori != "null")
		{
			if($v_where != "")
				$v_where = $v_where . " AND ref__aktiviti.aktiviti_description='". $v_kategori ."'";
			else
				$v_where = " ref__aktiviti.aktiviti_description='". $v_kategori ."'";
		}
		$v_jenis = $jenis;
		if($v_jenis != "null")
		{
			if($v_where != "")
				$v_where = $v_where . " AND ref__jenis_aktiviti.aktiviti_description='". $v_jenis ."'";
			else
				$v_where = " ref__jenis_aktiviti.aktiviti_description='". $v_jenis ."'";
		}
		
		if($v_where != "")
		{
			$data = DB::table('krt__aktiviti_laporan')
					->select('ref__states.state_description AS state',
					  'ref__daerahs.daerah_description AS daerah',
					  'krt__profile.krt_nama AS krt_name',
					  'ref__penganjur.penganjur_description AS penganjur',
					  'krt__aktiviti_laporan.aktiviti_tajuk AS tajuk_aktiviti',
					  'krt__aktiviti_laporan.aktiviti_perasmi AS perasmi_aktiviti',
				      'ref__aktiviti_agenda_kerja.agenda_description AS agenda_kerja',
					  'ref__aktiviti_bidang.bidang_description AS bidang_kerja',
					  'ref__aktiviti.aktiviti_description AS kategori_aktiviti',
					  'ref__jenis_aktiviti.aktiviti_description AS jenis_aktiviti',
					   DB::raw("DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh,'%d/%m/%Y') AS tarikh_aktiviti"),
					   'ref__aktiviti_program.program_description AS program',
					   'krt__aktiviti_laporan.program_id AS program_id',
					   DB::raw("IFNULL(krt__aktiviti_jantinal.bilangan,0) AS jumlah_lelaki"),
					   DB::raw("IFNULL(krt__aktiviti_jantinap.bilangan,0) AS jumlah_perempuan"),
					   DB::raw("IFNULL(krt__aktiviti_umur1.bilangan,0) AS jumlah_umur1"),
					   DB::raw("IFNULL(krt__aktiviti_umur2.bilangan,0) AS jumlah_umur2"),
					   DB::raw("IFNULL(krt__aktiviti_umur3.bilangan,0) AS jumlah_umur3"),
					   DB::raw("IFNULL(krt__aktiviti_umur4.bilangan,0) AS jumlah_umur4"),
					   DB::raw("IFNULL(krt__aktiviti_umur5.bilangan,0) AS jumlah_umur5"),
					   DB::raw("IFNULL(krt__aktiviti_umur6.bilangan,0) AS jumlah_umur6"),
					   DB::raw("IFNULL(krt__aktiviti_umur7.bilangan,0) AS jumlah_umur7"))
					->leftjoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
					->leftjoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
					->leftjoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
					->leftjoin('ref__penganjur','ref__penganjur.id','=','krt__aktiviti_laporan.penganjur_id')
					->leftjoin('ref__aktiviti_agenda_kerja','ref__aktiviti_agenda_kerja.id','=','krt__aktiviti_laporan.agenda_id')
					->leftjoin('ref__aktiviti_bidang','ref__aktiviti_bidang.id','=','krt__aktiviti_laporan.bidang_id')
					->leftjoin('ref__aktiviti','ref__aktiviti.id','=','krt__aktiviti_laporan.aktiviti_id')
					->leftjoin('ref__jenis_aktiviti','ref__jenis_aktiviti.id','=','krt__aktiviti_laporan.sub_aktiviti_id')
					->leftjoin('ref__aktiviti_program','ref__aktiviti_program.id','=','krt__aktiviti_laporan.program_id')
					->leftjoin('krt__aktiviti_jantinal','krt__aktiviti_jantinal.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_jantinap','krt__aktiviti_jantinap.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur1','krt__aktiviti_umur1.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur2','krt__aktiviti_umur2.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur3','krt__aktiviti_umur3.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur4','krt__aktiviti_umur4.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur5','krt__aktiviti_umur5.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur6','krt__aktiviti_umur6.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur7','krt__aktiviti_umur7.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->where('krt__aktiviti_laporan.aktiviti_status','=',1)
					->whereRaw($v_where)
					->orderBy('ref__states.state_description')
					->orderBy('ref__daerahs.daerah_description')
					->orderBy('krt__profile.krt_nama')
					->orderBy('krt__aktiviti_laporan.aktiviti_tarikh')
					->get();
		}else
		{
			$data = DB::table('krt__aktiviti_laporan')
					->select('ref__states.state_description AS state',
					  'ref__daerahs.daerah_description AS daerah',
					  'krt__profile.krt_nama AS krt_name',
					  'ref__penganjur.penganjur_description AS penganjur',
					  'krt__aktiviti_laporan.aktiviti_tajuk AS tajuk_aktiviti',
					  'krt__aktiviti_laporan.aktiviti_perasmi AS perasmi_aktiviti',
				      'ref__aktiviti_agenda_kerja.agenda_description AS agenda_kerja',
					  'ref__aktiviti_bidang.bidang_description AS bidang_kerja',
					  'ref__aktiviti.aktiviti_description AS kategori_aktiviti',
					  'ref__jenis_aktiviti.aktiviti_description AS jenis_aktiviti',
					   DB::raw("DATE_FORMAT(krt__aktiviti_laporan.aktiviti_tarikh,'%d/%m/%Y') AS tarikh_aktiviti"),
					   'ref__aktiviti_program.program_description AS program',
					   'krt__aktiviti_laporan.program_id AS program_id',
					   DB::raw("IFNULL(krt__aktiviti_jantinal.bilangan,0) AS jumlah_lelaki"),
					   DB::raw("IFNULL(krt__aktiviti_jantinap.bilangan,0) AS jumlah_perempuan"),
					   DB::raw("IFNULL(krt__aktiviti_umur1.bilangan,0) AS jumlah_umur1"),
					   DB::raw("IFNULL(krt__aktiviti_umur2.bilangan,0) AS jumlah_umur2"),
					   DB::raw("IFNULL(krt__aktiviti_umur3.bilangan,0) AS jumlah_umur3"),
					   DB::raw("IFNULL(krt__aktiviti_umur4.bilangan,0) AS jumlah_umur4"),
					   DB::raw("IFNULL(krt__aktiviti_umur5.bilangan,0) AS jumlah_umur5"),
					   DB::raw("IFNULL(krt__aktiviti_umur6.bilangan,0) AS jumlah_umur6"),
					   DB::raw("IFNULL(krt__aktiviti_umur7.bilangan,0) AS jumlah_umur7"))
					->leftjoin('krt__profile','krt__profile.id','=','krt__aktiviti_laporan.krt_profile_id')
					->leftjoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
					->leftjoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
					->leftjoin('ref__penganjur','ref__penganjur.id','=','krt__aktiviti_laporan.penganjur_id')
					->leftjoin('ref__aktiviti_agenda_kerja','ref__aktiviti_agenda_kerja.id','=','krt__aktiviti_laporan.agenda_id')
					->leftjoin('ref__aktiviti_bidang','ref__aktiviti_bidang.id','=','krt__aktiviti_laporan.bidang_id')
					->leftjoin('ref__aktiviti','ref__aktiviti.id','=','krt__aktiviti_laporan.aktiviti_id')
					->leftjoin('ref__jenis_aktiviti','ref__jenis_aktiviti.id','=','krt__aktiviti_laporan.sub_aktiviti_id')
					->leftjoin('ref__aktiviti_program','ref__aktiviti_program.id','=','krt__aktiviti_laporan.program_id')
					->leftjoin('krt__aktiviti_jantinal','krt__aktiviti_jantinal.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_jantinap','krt__aktiviti_jantinap.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur1','krt__aktiviti_umur1.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur2','krt__aktiviti_umur2.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur3','krt__aktiviti_umur3.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur4','krt__aktiviti_umur4.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur5','krt__aktiviti_umur5.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur6','krt__aktiviti_umur6.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->leftjoin('krt__aktiviti_umur7','krt__aktiviti_umur7.aktiviti_laporan_id','=','krt__aktiviti_laporan.id')
					->where('krt__aktiviti_laporan.aktiviti_status','=',1)
					->orderBy('ref__states.state_description')
					->orderBy('ref__daerahs.daerah_description')
					->orderBy('krt__profile.krt_nama')
					->orderBy('krt__aktiviti_laporan.aktiviti_tarikh')
					->get();	
		}
							  
        $pdf = PDF::loadView('print.print-laporan-aktiviti-rt', compact('data'))->setPaper('A4', 'landscape');
		$pdf->output();
		$domPdf = $pdf->getDomPDF();
		$canvas = $domPdf->get_canvas();
        $canvas->page_text(700, 548, "Mukasurat {PAGE_NUM} / {PAGE_COUNT}", null, 10, [0, 0, 0]);
        return $pdf->stream('asdasjihasd.pdf');
    }
	
	public function laporan_aktiviti(Request $request, $id){
                //$data_kehadiran                 = KRT_Minit_Mesyuarat_Kehadiran::where('krt_minit_mesyuarat_id', '=', $id)->get();
				$data_basic						= DB::table('krt__aktiviti_laporan')
												-> select('krt__aktiviti_laporan.krt_profile_id AS krt_id',
												'krt__aktiviti_laporan.state_id AS state_id',
												'krt__aktiviti_laporan.daerah_id AS daerah_id',
												'krt__aktiviti_laporan.aktiviti_tempat AS aktiviti_tempat',
												'krt__aktiviti_laporan.aktiviti_tajuk AS aktiviti_tajuk',
												'krt__aktiviti_laporan.aktiviti_tarikh AS aktiviti_tarikh',
												'krt__aktiviti_laporan.aktiviti_tarikh_rancang AS aktiviti_tarikh_rancang',
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
												'krt__aktiviti_laporan.aktiviti_perasmi AS aktiviti_perasmi')
												-> where('krt__aktiviti_laporan.id','=',$id)
												->limit(1)
                                            	->first();
				$data_penyertaan				= DB::table('krt__aktiviti_laporan_penyertaan')
												-> select('krt__aktiviti_laporan_penyertaan.id',
												'krt__aktiviti_laporan_penyertaan.kaum_id',
												'krt__aktiviti_laporan_penyertaan.jantina_id',
												'krt__aktiviti_laporan_penyertaan.umur_id',
												'krt__aktiviti_laporan_penyertaan.penyertaan_jumlah')
												-> where('krt__aktiviti_laporan_penyertaan.aktiviti_laporan_id','=',$id)
												-> get();
				$data_rakan						= DB::table('krt__aktiviti_laporan_rakan_perpaduan')
												-> select('krt__aktiviti_laporan_rakan_perpaduan.rakan_id',
												'krt__aktiviti_laporan_rakan_perpaduan.sumbangan_id',
												'krt__aktiviti_laporan_rakan_perpaduan.rakan_perpaduan_jumlah')
												-> where('krt__aktiviti_laporan_rakan_perpaduan.aktiviti_laporan_id','=',$id)
												-> get();
                $data_krt                 	= DB::table('krt__profile')
											->select('krt__profile.daerah_id as daerah_id',
											'krt__profile.krt_nama as krt_nama',
											'ref__daerahs.daerah_description as daerah',
											'ref__states.state_description as negeri')
											->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
											->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
											->where('krt__profile.id','=',$data_basic->krt_id)
											->limit(1)
                                            ->first();
        
        $pdf = PDF::loadView('print.print-laporan-aktiviti', 
        compact('data_basic','data_krt','data_penyertaan', 'data_rakan'))->setPaper('A4', 'potrait');
        $pdf->output();
		$domPdf = $pdf->getDomPDF();
		$canvas = $domPdf->get_canvas();
        $canvas->page_text(500, 810, "Mukasurat {PAGE_NUM} / {PAGE_COUNT}", null, 10, [0, 0, 0]);
		//return $pdf->download('itsolutionstuff.pdf');
		return $pdf->stream('asdasjihasd.pdf');
    }
}
