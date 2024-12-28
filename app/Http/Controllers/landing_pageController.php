<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect, Response;
use Auth;
use Validator;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\RefStates;
use App\RefDaerah;
use App\RefParlimen;
use App\RefDUN;
use App\RefJantina;
use App\RefKaum;
use App\Ref_Agama;
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

class landing_pageController extends Controller
{   
    function ajk_krt(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = DB::table('ref__daerahs')
                        ->select('ref__daerahs.id', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__daerahs.state_id')
                        ->where('ref__states.state_id', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            
        } else {
            $krt_ajk            = DB::table('krt__ahli_jawatan_kuasa')
                                ->select('krt__ahli_jawatan_kuasa.id',
                                        'krt__ahli_jawatan_kuasa.ajk_nama AS ajk_nama',
                                        'krt__ahli_jawatan_kuasa.ajk_ic AS ajk_ic',
                                        'ref__jantina.jantina_description AS ajk_jantina',
                                        DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa.ajk_tarikh_lahir,'%d/%m/%Y') AS ajk_tarikh_lahir"),
                                        'krt__ahli_jawatan_kuasa.ajk_warganegara AS ajk_warganegara',
                                        'ref__kaum.kaum_description AS ajk_kaum',
                                        'ref__agama.agama_description AS ajk_agama',
                                        'krt__ahli_jawatan_kuasa.ajk_phone AS ajk_phone',
                                        'krt__ahli_jawatan_kuasa.ajk_alamat AS ajk_alamat',
                                        'krt__ahli_jawatan_kuasa.ajk_poskod AS ajk_poskod',
                                        'ref__pendidikan.pendidikan_description AS ajk_pendidikan',
                                        'ref__profession.profession_description AS ajk_pekerjaan',
                                        'ref__jawatan_ajk_krt.jawatan_description AS ajk_jawatan',
                                        DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa.ajk_tarikh_mula,'%d/%m/%Y') AS ajk_tarikh_mula"),
                                        DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa.ajk_tarikh_akhir,'%d/%m/%Y') AS ajk_tarikh_akhir"),
                                        DB::raw(" CONCAT('KRT',krt__profile.state_id,krt__profile.daerah_id,krt__profile.id,krt__ahli_jawatan_kuasa.id) AS krt_id"),
                                        'krt__profile.krt_nama AS krt_nama',
                                        'ref__daerahs.daerah_description AS krt_daerah',
                                        'ref__states.state_description AS krt_state',
                                        'krt__profile.state_id AS krt_state_id',
                                        'krt__profile.daerah_id AS krt_daerah_id',
                                        'ref__status_krt_ajk.status_description AS ajk_status',
                                        DB::raw(" DATEDIFF( NOW(), krt__ahli_jawatan_kuasa.ajk_tarikh_mula) AS ajk_status_pelantikan"),
                                        'users__profile.user_fullname AS ajk_disahkan_oleh',
                                        DB::raw(" DATE_FORMAT(krt__ahli_jawatan_kuasa.disahkan_date,'%d/%m/%Y') AS ajk_tarikh_disahkan"),
                                        'krt__ahli_jawatan_kuasa.file_avatar AS file_avatar')
                                ->leftJoin('ref__jantina','ref__jantina.id','=','krt__ahli_jawatan_kuasa.ajk_jantina')
                                ->leftJoin('ref__kaum','ref__kaum.id','=','krt__ahli_jawatan_kuasa.ajk_kaum')
                                ->leftJoin('ref__agama','ref__agama.id','=','krt__ahli_jawatan_kuasa.ajk_agama')
                                ->leftJoin('ref__pendidikan','ref__pendidikan.id','=','krt__ahli_jawatan_kuasa.ajk_pendidikan_id')
                                ->leftJoin('ref__profession','ref__profession.id','=','krt__ahli_jawatan_kuasa.ajk_profession_id')
                                ->leftJoin('ref__jawatan_ajk_krt','ref__jawatan_ajk_krt.id','=','krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
                                ->leftJoin('ref__status_krt_ajk','ref__status_krt_ajk.id','=','krt__ahli_jawatan_kuasa.ajk_status')
                                ->leftJoin('krt__profile','krt__profile.id','=','krt__ahli_jawatan_kuasa.krt_profile_id')
                                ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                ->leftJoin('users__profile','users__profile.user_id','=','krt__ahli_jawatan_kuasa.disahkan_by')
                                ->where('krt__ahli_jawatan_kuasa.id', '=', $id)  
                                ->limit(1)
                                ->first();
            $state      = RefStates::where('status', '=',  true)->get();
            return view('authentication.ajk_krt',compact('krt_ajk','state'));
        }
    }

    function ajk_srs(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = DB::table('ref__daerahs')
                        ->select('ref__daerahs.id', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__daerahs.state_id')
                        ->where('ref__states.state_id', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            
        } else {
            $srs_ahli_peronda   = DB::table('srs__ahli_peronda')
                                    ->select('srs__ahli_peronda.id',
                                            'srs__ahli_peronda.peronda_nama AS peronda_nama',
                                            'ref__jantina.jantina_description AS peronda_jantina',
                                            'srs__ahli_peronda.peronda_warganegara AS peronda_warganegara',
                                            'srs__ahli_peronda.peronda_phone AS peronda_phone',
                                            'srs__ahli_peronda.peronda_ic AS peronda_ic',
                                            DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lahir,'%d/%m/%Y') AS peronda_tarikh_lahir"),
                                            'ref__kaum.kaum_description AS peronda_kaum',
                                            'srs__ahli_peronda.peronda_alamat AS peronda_alamat',
                                            'srs__ahli_peronda.peronda_poskod AS peronda_poskod',
                                            'srs__ahli_peronda.file_gambar_profile AS file_gambar_profile',
                                            DB::raw(" DATE_FORMAT(srs__ahli_peronda.peronda_tarikh_lantikan,'%d/%m/%Y') AS peronda_tarikh_lantikan"))
                                    ->leftJoin('ref__jantina','ref__jantina.id','=','srs__ahli_peronda.peronda_jantina')
                                    ->leftJoin('ref__kaum','ref__kaum.id','=','srs__ahli_peronda.peronda_kaum')
                                    ->leftJoin('krt__profile','krt__profile.id','=','srs__ahli_peronda.krt_profile_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','krt__profile.state_id')
                                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                                    ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','krt__profile.parlimen_id')
                                    ->leftJoin('ref__duns','ref__duns.dun_id','=','krt__profile.dun_id')
                                    ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','krt__profile.pbt_id')
                                    ->where('srs__ahli_peronda.id', '=', $id)  
                                    ->limit(1)
                                    ->first();
            $state      = RefStates::where('status', '=',  true)->get();
            return view('authentication.ajk_srs',compact('srs_ahli_peronda','state'));
        }
    }

    function ahli_mk(Request $request, $id){
        if($request->ajax()){ 
            $type = $request->type;
            if($type == 'get_daerah') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = DB::table('ref__daerahs')
                        ->select('ref__daerahs.id', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description', 'ref__states.state_id', 'ref__states.state_description')
                        ->leftJoin('ref__states','ref__states.state_id','=','ref__daerahs.state_id')
                        ->where('ref__states.state_id', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            
        } else {
            $kad_keahlian_mkp       = DB::table('spk__imediator')
                                ->select('spk__imediator.id',
                                        'spk__imediator.mkp_file_avatar',
                                        'users__profile.user_fullname',
                                        DB::raw(" DATE_FORMAT(spk__imediator.mkp_pemohon_tarikh_lahir,'%d/%m/%Y') AS mk_tarikh_lahir"),
                                        'ref__daerahs.daerah_description AS mk_daerah',
                                        'ref__duns.dun_description AS mk_dun',
                                        'spk__imediator.mkp_pemohon_mukim_id AS mk_mukim',
                                        'ref__kaum.kaum_description AS mk_kaum',
                                        'spk__imediator.mkp_pemohon_alamat AS mk_alamat_rumah',
                                        'users__profile.no_phone AS mk_telefon',
                                        'spk__imediator.mkp_pemohon_kategori_id AS mk_kategori_mkp',
                                        'ref__pendidikan.pendidikan_description AS mk_akademik',
                                        DB::raw(" DATE_FORMAT(spk__imediator.mkp_tarikh_dilantik,'%d/%m/%Y') AS mk_tarikh_lantik"),
                                        'users__profile.no_ic AS mk_no_ic',
                                        'ref__states.state_description As mk_negeri',
                                        'ref__parlimens.parlimen_description AS mk_parlimen',
                                        'ref__pbts.pbt_description AS mk_pbt',
                                        'ref__jantina.jantina_description AS mk_jantina',
                                        'users.user_email AS mk_email',
                                        'spk__imediator.mkp_pemohon_alamat_p AS mk_pejabat',
                                        'spk__imediator.mkp_pemohon_no_phone_p AS mk_phone_pejabat',
                                        'ref__spk_mkp_tahap.tahap_description AS mk_tahap',
                                        'spk__imediator.mkp_pemohon_khusus AS mk_kemahiran')
                                ->leftJoin('users','users.user_id','=','spk__imediator.user_id')
                                ->leftJoin('users__profile','users__profile.user_id','=','users.user_id')
                                ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                                ->leftJoin('ref__duns','ref__duns.dun_id','=','spk__imediator.mkp_pemohon_dun_id')
                                ->leftJoin('ref__kaum','ref__kaum.id','=','spk__imediator.mkp_pemohon_kaum_id')
                                ->leftJoin('ref__pendidikan','ref__pendidikan.id','=','spk__imediator.mkp_pemohon_akademik')
                                ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                                ->leftJoin('ref__parlimens','ref__parlimens.parlimen_id','=','spk__imediator.mkp_pemohon_parlimen_id')
                                ->leftJoin('ref__pbts','ref__pbts.pbt_id','=','spk__imediator.mkp_pemohon_pbt_id')
                                ->leftJoin('ref__jantina','ref__jantina.id','=','spk__imediator.mkp_pemohon_jantina_id')
                                ->leftJoin('ref__spk_mkp_tahap','ref__spk_mkp_tahap.id','=','spk__imediator.mkp_pemohon_tahap_id')
                                ->where('spk__imediator.id', '=', $id)  
                                ->limit(1)
                                ->first();
            $state      = RefStates::where('status', '=',  true)->get();
            return view('authentication.ahli_mk',compact('kad_keahlian_mkp','state'));
        }
    }
}
