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
use App\TBK_Student;
use App\Ref_Agama;
use App\RefJantina;
use App\RefKaum;
use App\RefProfession;
use App\Ref_Status_Warganegara;
use App\Tbk_Student_Pengesahan_Penjaga;
use App\Tbk_Student_Dokument;

class RT_SM27Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function senarai_permohonan_student_tp_p(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('tbk__student')
                        ->select('tbk__student.id AS id',
                                 DB::raw("CONCAT('STP',tbk__profile.state_id,tbk__profile.daerah_id,tbk__student.id) AS no_permohonan"),
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'tbk__profile.tbk_nama AS tbk_nama',
                                'tbk__student.student_nama AS student_nama',
                                'tbk__student.student_mykid AS student_mykid',
                                'ref__jantina.jantina_description AS student_jantina',
                                'tbk__student.student_alamat AS student_alamat',
                                'tbk__student.student_status AS status',
                                'ref__status_tbk_student.status_description AS student_status')
                        ->leftJoin('tbk__profile','tbk__profile.id','=','tbk__student.tabika_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','tbk__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','tbk__profile.daerah_id')
                        ->leftJoin('ref__jantina','ref__jantina.id','=','tbk__student.student_jantina_id')
                        ->leftJoin('ref__status_tbk_student','ref__status_tbk_student.id','=','tbk__student.student_status')
                        ->whereIN('tbk__student.student_status',[2])
                        ->where('tbk__student.dihantar_by', '=', Auth::user()->user_id)
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
            return view('rt-sm27.senarai-permohonan-student-tp-p',compact('roles_menu'));
        }
    }

    function post_permohonan_student_tp(Request $request){
        
        $action = $request->post_permohonan_student_tp;
        
        $rules = array(
           
        );

        $messages = [
            
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to(route('rt-sm27.senarai_permohonan_student_tp_p'))
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            if ($action == 'add') {
                $permohonan_student                 = new TBK_Student;
                $permohonan_student->student_status = 2;
                $permohonan_student->dihantar_by    = Auth::user()->user_id;
                $permohonan_student->save();
            }
           
            return Redirect::to(route('rt-sm27.mohon_student_tp_p',$permohonan_student->id));
        }

    }

    function mohon_student_tp_p(Request $request, $id){
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
            else if($type == 'get_tabika') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = DB::table('tbk__profile')
                        ->select('tbk__profile.id', 'tbk__profile.daerah_id', 'tbk__profile.tbk_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','tbk__profile.daerah_id')
                        ->where('ref__daerahs.daerah_id', '=',  $where)
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $ref_agama          = Ref_Agama::where('status', '=', true)->get();
            $ref_jantina        = RefJantina::where('status', '=', true)->get();
            $ref_kaum           = RefKaum::where('status', '=', true)->get();
            $ref_profession     = RefProfession::where('status', '=', true)->get();
            $ref_kerakyatan     = Ref_Status_Warganegara::where('status', '=', true)->get();
            $tbk_student        = DB::table('tbk__student')
                                    ->select('tbk__student.id',
                                                'tbk__profile.state_id AS state_id',
                                                'tbk__profile.daerah_id AS daerah_id',
                                                'tbk__student.tabika_id AS tabika_id',
                                                'tbk__student.student_nama AS student_nama',
                                                'tbk__student.student_mykid AS student_mykid',
                                                'tbk__student.student_sijil_lahir AS student_sijil_lahir',
                                                DB::raw(" DATE_FORMAT(tbk__student.student_tarikh_lahir,'%d/%m/%Y') AS student_tarikh_lahir"),
                                                'tbk__student.student_agama_id AS student_agama_id',
                                                'tbk__student.student_jantina_id AS student_jantina_id', 
                                                'tbk__student.student_kaum_id AS student_kaum_id', 
                                                'tbk__student.student_kesihatan AS student_kesihatan',
                                                'tbk__student.student_alamat AS student_alamat',
                                                'tbk__student.student_jarak_rumah AS student_jarak_rumah',
                                                'tbk__student.bapa_nama AS bapa_nama',
                                                'tbk__student.bapa_ic AS bapa_ic',
                                                'tbk__student.bapa_pekerjaan AS bapa_pekerjaan',
                                                'tbk__student.bapa_profession_id AS bapa_profession_id',
                                                'tbk__student.bapa_pendapatan AS bapa_pendapatan',
                                                'tbk__student.bapa_alamat_office AS bapa_alamat_office',
                                                'tbk__student.bapa_phone_office AS bapa_phone_office',
                                                'tbk__student.bapa_kerakyatan_id AS bapa_kerakyatan_id',
                                                'tbk__student.bapa_phone AS bapa_phone',
                                                'tbk__student.bapa_jumlah_pendapatan AS bapa_jumlah_pendapatan',
                                                'tbk__student.bapa_phone_rumah AS bapa_phone_rumah',
                                                'tbk__student.student_status AS student_status',
                                                'tbk__student.disahkan_note AS disahkan_note',
                                                'tbk__student.diluluskan_note AS diluluskan_note',
                                                'ref__status_tbk_student.status_description AS status_description')
                                    ->leftJoin('tbk__profile','tbk__profile.id','=','tbk__student.tabika_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','tbk__profile.state_id')
                                    ->leftJoin('ref__status_tbk_student','ref__status_tbk_student.id','=','tbk__student.student_status')
                                    ->where('tbk__student.id', '=', $id)
                                    ->limit(1)
                                    ->first();
            return view('rt-sm27.mohon-student-tp-p', compact('roles_menu','negeri', 'daerah', 'ref_agama', 'ref_jantina', 'ref_kaum', 'ref_profession', 'ref_kerakyatan', 'tbk_student'));
        }
    }

    function post_permohonan_student_tp_1(Request $request){
        $action = $request->post_permohonan_student_tp_1;
        $app_id = $request->mstpp_1_student_id;
        
        $rules_main = array(
            'mstpp_state_id'                    => 'required',
            'mstpp_daerah_id'                   => 'required',
            'mstpp_tabika_id'                   => 'required',
            'mstpp_1_student_nama'              => 'required',
            'mstpp_1_student_sijil_lahir'       => 'required',
            'mstpp_1_student_agama_id'          => 'required',
            'mstpp_1_student_kaum_id'           => 'required',
            'mstpp_1_student_mykid'             => 'required',
            'mstpp_1_student_tarikh_lahir'      => 'required',
            'mstpp_1_student_jantina_id'        => 'required',
            'mstpp_1_student_alamat'            => 'required',
            'mstpp_1_student_jarak_rumah'       => 'required',
            'mstpp_1_bapa_nama'                 => 'required',
            'mstpp_1_bapa_pekerjaan'            => 'required',
            'mstpp_1_bapa_profession_id'        => 'required',
            'mstpp_1_bapa_pendapatan'           => 'required',
            'mstpp_1_bapa_kerakyatan_id'        => 'required',
            'mstpp_1_bapa_jumlah_pendapatan'    => 'required',
            'mstpp_1_bapa_ic'                   => 'required',
            'mstpp_1_bapa_alamat_office'        => 'required',
            'mstpp_1_bapa_phone_office'         => 'required',
            'mstpp_1_bapa_phone'                => 'required',
        );

        $messages = [
            'mstpp_state_id.required'                       => 'Ruangan Negeri mesti dipilih',
            'mstpp_daerah_id.required'                      => 'Ruangan Daerah / Bahagian mesti dipilih',
            'mstpp_tabika_id.required'                      => 'Ruangan Nama Tabika Perpaduan mesti dipilih',
            'mstpp_1_student_nama.required'                 => 'Ruangan Nama mesti diisi',
            'mstpp_1_student_sijil_lahir.required'          => 'Ruangan No Sijil Lahir mesti diisi',
            'mstpp_1_student_agama_id.required'             => 'Ruangan Agama mesti dipilih',
            'mstpp_1_student_kaum_id.required'              => 'Ruangan Kaum mesti dipilih',
            'mstpp_1_student_mykid.required'                => 'Ruangan Mykid mesti diisi',
            'mstpp_1_student_tarikh_lahir.required'         => 'Ruangan Tarikh Lahir mesti dipilih',
            'mstpp_1_student_jantina_id.required'           => 'Ruangan Jantina mesti dipilih',
            'mstpp_1_student_alamat.required'               => 'Ruangan Alamat mesti diisi',
            'mstpp_1_student_jarak_rumah.required'          => 'Ruangan Jarak Rumah Ke Sekolah mesti diisi',
            'mstpp_1_bapa_nama.required'                    => 'Ruangan Nama mesti diisi',
            'mstpp_1_bapa_pekerjaan.required'               => 'Ruangan Pekerjaan diisi',
            'mstpp_1_bapa_profession_id.required'           => 'Ruangan ektor Pekerjaan mesti dipilih',
            'mstpp_1_bapa_pendapatan.required'              => 'Ruangan Pendapatan Bulanan (RM) mesti diisi',
            'mstpp_1_bapa_kerakyatan_id.required'           => 'Ruangan Kerakyatan mesti diisi',
            'mstpp_1_bapa_jumlah_pendapatan.required'       => 'Ruangan Jumlah Pendapatan Bulanan (RM) mesti diisi',
            'mstpp_1_bapa_ic.required'                      => 'Ruangan No Kad Pengenalan mesti diisi',
            'mstpp_1_bapa_alamat_office.required'           => 'Ruangan Alamat Tempat Kerja mesti diisi',
            'mstpp_1_bapa_phone_office.required'            => 'Ruangan No Telefon Pejabat mesti diisi',
            'mstpp_1_bapa_phone.required'                   => 'Ruangan No Telefon Bimbit mesti diisi',
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $carbon_obj = Carbon::createFromFormat('d/m/Y', $request->mstpp_1_student_tarikh_lahir)->format('Y-m-d');
                $edit_permohonan_student                            = TBK_Student::where($where)->first();
                $edit_permohonan_student->tabika_id                 = $request->mstpp_tabika_id;
                $edit_permohonan_student->student_nama              = $request->mstpp_1_student_nama;
                $edit_permohonan_student->student_mykid             = $request->mstpp_1_student_mykid;
                $edit_permohonan_student->student_sijil_lahir       = $request->mstpp_1_student_sijil_lahir;
                $edit_permohonan_student->student_tarikh_lahir      = $carbon_obj;
                $edit_permohonan_student->student_agama_id          = $request->mstpp_1_student_agama_id;
                $edit_permohonan_student->student_jantina_id        = $request->mstpp_1_student_jantina_id;
                $edit_permohonan_student->student_kaum_id           = $request->mstpp_1_student_kaum_id;
                $edit_permohonan_student->student_kesihatan         = $request->mstpp_1_student_kesihatan;
                $edit_permohonan_student->student_alamat            = $request->mstpp_1_student_alamat;
                $edit_permohonan_student->student_jarak_rumah       = $request->mstpp_1_student_jarak_rumah;
                $edit_permohonan_student->bapa_nama                 = $request->mstpp_1_bapa_nama;
                $edit_permohonan_student->bapa_ic                   = $request->mstpp_1_bapa_ic;
                $edit_permohonan_student->bapa_pekerjaan            = $request->mstpp_1_bapa_pekerjaan;
                $edit_permohonan_student->bapa_profession_id        = $request->mstpp_1_bapa_profession_id;
                $edit_permohonan_student->bapa_pendapatan           = $request->mstpp_1_bapa_pendapatan;
                $edit_permohonan_student->bapa_alamat_office        = $request->mstpp_1_bapa_alamat_office;
                $edit_permohonan_student->bapa_phone_office         = $request->mstpp_1_bapa_phone_office;
                $edit_permohonan_student->bapa_kerakyatan_id        = $request->mstpp_1_bapa_kerakyatan_id;
                $edit_permohonan_student->bapa_phone                = $request->mstpp_1_bapa_phone;
                $edit_permohonan_student->bapa_jumlah_pendapatan    = $request->mstpp_1_bapa_jumlah_pendapatan;
                $edit_permohonan_student->bapa_phone_rumah          = $request->mstpp_1_bapa_phone_rumah;
                $edit_permohonan_student->save();
            }
        }

    }

    function mohon_student_tp_p_1(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $ref_profession     = RefProfession::where('status', '=', true)->get();
            $ref_kerakyatan     = Ref_Status_Warganegara::where('status', '=', true)->get();
            $tabika_profile     = DB::table('tbk__profile')->select('tbk__profile.id','tbk__profile.tbk_nama')->where('tbk__profile.tbk_status', '=', true)->get();
            $tbk_student        = DB::table('tbk__student')
                                    ->select('tbk__student.id',
                                                'tbk__profile.state_id AS state_id',
                                                'tbk__profile.daerah_id AS daerah_id',
                                                'tbk__student.tabika_id AS tabika_id',
                                                'tbk__student.ibu_nama AS ibu_nama',
                                                'tbk__student.ibu_ic AS ibu_ic',
                                                'tbk__student.ibu_pekerjaan AS ibu_pekerjaan',
                                                'tbk__student.ibu_profession_id AS ibu_profession_id',
                                                'tbk__student.ibu_pendapatan AS ibu_pendapatan', 
                                                'tbk__student.ibu_alamat_office AS ibu_alamat_office', 
                                                'tbk__student.ibu_phone_office AS ibu_phone_office',
                                                'tbk__student.ibu_kerakyatan_id AS ibu_kerakyatan_id',
                                                'tbk__student.ibu_phone AS ibu_phone',
                                                'tbk__student.ibu_jumlah_pendapatan AS ibu_jumlah_pendapatan',
                                                'tbk__student.ibu_jumlah_pendapatan_lain AS ibu_jumlah_pendapatan_lain',
                                                'tbk__student.ibu_phone_rumah AS ibu_phone_rumah',
                                                'tbk__student.ibu_bil_anak AS ibu_bil_anak',
                                                'tbk__student.ibu_bil_anak_sekolah AS ibu_bil_anak_sekolah',
                                                'tbk__student.ibu_hubungan_student AS ibu_hubungan_student',
                                                'tbk__student.ibu_tabika_lain AS ibu_tabika_lain',
                                                'tbk__student.ibu_pilihan AS ibu_pilihan',
                                                'tbk__student.student_status AS student_status',
                                                'tbk__student.disahkan_note AS disahkan_note',
                                                'tbk__student.diluluskan_note AS diluluskan_note',
                                                'ref__status_tbk_student.status_description AS status_description')
                                    ->leftJoin('tbk__profile','tbk__profile.id','=','tbk__student.tabika_id')
                                    ->leftJoin('ref__status_tbk_student','ref__status_tbk_student.id','=','tbk__student.student_status')
                                    ->where('tbk__student.id', '=', $id)
                                    ->limit(1)
                                    ->first();
            return view('rt-sm27.mohon-student-tp-p-1', compact('roles_menu','negeri', 'daerah', 'ref_profession', 'ref_kerakyatan', 'tabika_profile', 'tbk_student'));
        }
    }

    function get_pengesahan_penjaga_table(Request $request, $id){
        return DataTables()->of(
            DB::select(DB::raw("
                SELECT
                ref__tbk_pengesahan_penjaga.id, 
                ref__tbk_pengesahan_penjaga.pengesahan_description, 
                ref__tbk_pengesahan_penjaga.status, 
                tbk__student_pengesahan_penjaga.id AS tbk_student_pengesahan_id, 
                tbk__student_pengesahan_penjaga.tbk_student_id, 
                tbk__student_pengesahan_penjaga.ref_pengesahan_id
                FROM
                ref__tbk_pengesahan_penjaga
                LEFT JOIN tbk__student_pengesahan_penjaga ON tbk__student_pengesahan_penjaga.ref_pengesahan_id = ref__tbk_pengesahan_penjaga.id
                AND tbk__student_pengesahan_penjaga.tbk_student_id ='" . $id . "'
                ORDER BY ref__tbk_pengesahan_penjaga.id + 0 ASC
            "))
        )->make();
    }

    function post_pengesahan_penjaga(Request $request){
        $mstpp_3_student_id         = $request->mstpp_3_student_id;
        $tbk_student_pengesahan_id  = $request->tbk_student_pengesahan_id;
        
        $pengesahan_penjaga                         = new Tbk_Student_Pengesahan_Penjaga;
        $pengesahan_penjaga->tbk_student_id         = $mstpp_3_student_id;
        $pengesahan_penjaga->ref_pengesahan_id      = $request->tbk_student_pengesahan_id;
        $pengesahan_penjaga->save();

    }

    function post_delete_pengesahan_penjaga(Request $request){
        $mstpp_3_student_id         = $request->mstpp_3_student_id;
        $tbk_student_pengesahan_id  = $request->tbk_student_pengesahan_id;

        $data = DB::table('tbk__student_pengesahan_penjaga')
                ->where('tbk_student_id', '=', $mstpp_3_student_id)
                ->where('ref_pengesahan_id', '=', $tbk_student_pengesahan_id)
                ->delete();
        
    }

    function get_dokument_student_table(Request $request, $id){
        $data = DB::table('tbk__student_dokument')
                ->select('tbk__student_dokument.*')
                ->where('tbk__student_dokument.tbk_student_id', '=', $id)
                ->get();
        return Datatables::of($data)
                ->make(true);
    }

    function add_tbk_student_dokument(Request $request){
        $action = $request->add_tbk_student_dokument;
        $app_id = $request->mstpp_4_student_id;
        
       

        $rules = array(
            'mstpp_4_file_title'                => 'required',
            'mstpp_4_file_dokument'             => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:5000'
        );

        $messages = [
            'mstpp_4_file_title.required'       => 'Ruangan Tajuk Fail Mesti Diisi',
            'mstpp_4_file_dokument.required'    => 'Ruangan Fail Mesti Dipilih',
            'mstpp_4_file_dokument.mimes'       => 'Fail Mesti Dipilih Dalam Format jpeg,png,jpg,gif,svg,pdf',
            'mstpp_4_file_dokument.max'         => 'Fail mesti dalam sive 5000KB',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            
            if ($action == 'add') {
                $fileName = $request->mstpp_4_file_dokument->getClientOriginalName();
                $request->mstpp_4_file_dokument->storeAs('public/tbk_student_dokument',$fileName);
                $student_dokument = new Tbk_Student_Dokument;
                $student_dokument->tbk_student_id  = $app_id;
                $student_dokument->file_title      = $request->mstpp_4_file_title;
                $student_dokument->file_dokument   = $fileName;
                $student_dokument->save();
            }

            return \Response::json(array('success' => '1'));
        }

    }

    function get_download_dokument_student($id){
        $data = DB::table('tbk__student_dokument')
                ->select('tbk__student_dokument.id', 
                    'tbk__student_dokument.file_dokument AS file_dokument' )
                ->where('tbk__student_dokument.id', '=', $id)
                ->first();
        return Response::json($data);
    }

    function delete_dokument_student($id){
        $data = DB::table('tbk__student_dokument')->where('id', '=', $id)->delete();
    }

    function post_permohonan_student_tp_2_back(Request $request){
        $action = $request->post_permohonan_student_tp_2;
        $app_id = $request->mstpp_5_student_id;
        
        $rules_main = array(
            
        );

        $messages = [
            
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $edit_permohonan_student                                = TBK_Student::where($where)->first();
                $edit_permohonan_student->ibu_nama                      = $request->mstpp_2_ibu_nama;
                $edit_permohonan_student->ibu_ic                        = $request->mstpp_2_ibu_ic;
                $edit_permohonan_student->ibu_pekerjaan                 = $request->mstpp_2_ibu_pekerjaan;
                $edit_permohonan_student->ibu_profession_id             = $request->mstpp_2_ibu_profession_id;
                $edit_permohonan_student->ibu_pendapatan                = $request->mstpp_2_ibu_pendapatan;
                $edit_permohonan_student->ibu_alamat_office             = $request->mstpp_2_ibu_alamat_office;
                $edit_permohonan_student->ibu_phone_office              = $request->mstpp_2_ibu_phone_office;
                $edit_permohonan_student->ibu_kerakyatan_id             = $request->mstpp_2_ibu_kerakyatan_id;
                $edit_permohonan_student->ibu_phone                     = $request->mstpp_2_ibu_phone;
                $edit_permohonan_student->ibu_jumlah_pendapatan         = $request->mstpp_2_ibu_jumlah_pendapatan;
                $edit_permohonan_student->ibu_jumlah_pendapatan_lain    = $request->mstpp_2_ibu_jumlah_pendapatan_lain;
                $edit_permohonan_student->ibu_phone_rumah               = $request->mstpp_2_ibu_phone_rumah;
                $edit_permohonan_student->ibu_bil_anak                  = $request->mstpp_2_ibu_bil_anak;
                $edit_permohonan_student->ibu_bil_anak_sekolah          = $request->mstpp_2_ibu_bil_anak_sekolah;
                $edit_permohonan_student->ibu_hubungan_student          = $request->mstpp_2_ibu_hubungan_student;
                $edit_permohonan_student->ibu_tabika_lain               = $request->mstpp_2_ibu_tabika_lain;
                $edit_permohonan_student->ibu_pilihan                   = $request->mstpp_2_ibu_pilihan;
                $edit_permohonan_student->save();
            }
        }

    }

    function post_permohonan_student_tp_2(Request $request){
        $action = $request->post_permohonan_student_tp_2;
        $app_id = $request->mstpp_5_student_id;
        
        $rules_main = array(
            'mstpp_2_ibu_nama'                  => 'required',
            'mstpp_2_ibu_pekerjaan'             => 'required',
            'mstpp_2_ibu_profession_id'         => 'required',
            'mstpp_2_ibu_pendapatan'            => 'required',
            'mstpp_2_ibu_kerakyatan_id'         => 'required',
            'mstpp_2_ibu_jumlah_pendapatan'     => 'required',
            'mstpp_2_ibu_ic'                    => 'required',
            'mstpp_2_ibu_alamat_office'         => 'required',
            'mstpp_2_ibu_phone_office'          => 'required',
            'mstpp_2_ibu_phone'                 => 'required',
            'mstpp_2_ibu_bil_anak'              => 'required',
            'mstpp_2_ibu_hubungan_student'      => 'required',
            'mstpp_2_ibu_pilihan'               => 'required',
            'mstpp_2_ibu_bil_anak_sekolah'      => 'required',
        );

        $messages = [
            'mstpp_2_ibu_nama.required'                 => 'Ruangan Nama mesti diisi',
            'mstpp_2_ibu_pekerjaan.required'            => 'Ruangan Pekerjaan mesti diisi',
            'mstpp_2_ibu_profession_id.required'        => 'Ruangan Sektor Pekerjaan mesti dipilih',
            'mstpp_2_ibu_pendapatan.required'           => 'Ruangan Pendapatan Bulan (RM) mesti diisi',
            'mstpp_2_ibu_kerakyatan_id.required'        => 'Ruangan Kerakyatan mesti dipilih',
            'mstpp_2_ibu_jumlah_pendapatan.required'    => 'Ruangan Jumlah Pendapatan Bulanan mesti diisi',
            'mstpp_2_ibu_ic.required'                   => 'Ruangan No Kad Pengenalan mesti diisi',
            'mstpp_2_ibu_alamat_office.required'        => 'Ruangan Alamat Tempat Kerja mesti diisi',
            'mstpp_2_ibu_phone_office.required'         => 'Ruangan No Telefon Pejabat mesti diisi',
            'mstpp_2_ibu_phone.required'                => 'Ruangan No Telefon Bimbit mesti diisi',
            'mstpp_2_ibu_bil_anak.required'             => 'Ruangan Bilangan Anak mesti diisi',
            'mstpp_2_ibu_hubungan_student.required'     => 'Ruangan Hubungan Dengan Murid mesti diisi',
            'mstpp_2_ibu_pilihan.required'              => 'Ruangan Tabika Perpaduan Adalah Pilihan yang Kebarapa dipilih',
            'mstpp_2_ibu_bil_anak_sekolah.required'     => 'Ruangan Bilangan Anak Bersekolah mesti dipilih',
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $edit_permohonan_student                                = TBK_Student::where($where)->first();
                $edit_permohonan_student->ibu_nama                      = $request->mstpp_2_ibu_nama;
                $edit_permohonan_student->ibu_ic                        = $request->mstpp_2_ibu_ic;
                $edit_permohonan_student->ibu_pekerjaan                 = $request->mstpp_2_ibu_pekerjaan;
                $edit_permohonan_student->ibu_profession_id             = $request->mstpp_2_ibu_profession_id;
                $edit_permohonan_student->ibu_pendapatan                = $request->mstpp_2_ibu_pendapatan;
                $edit_permohonan_student->ibu_alamat_office             = $request->mstpp_2_ibu_alamat_office;
                $edit_permohonan_student->ibu_phone_office              = $request->mstpp_2_ibu_phone_office;
                $edit_permohonan_student->ibu_kerakyatan_id             = $request->mstpp_2_ibu_kerakyatan_id;
                $edit_permohonan_student->ibu_phone                     = $request->mstpp_2_ibu_phone;
                $edit_permohonan_student->ibu_jumlah_pendapatan         = $request->mstpp_2_ibu_jumlah_pendapatan;
                $edit_permohonan_student->ibu_jumlah_pendapatan_lain    = $request->mstpp_2_ibu_jumlah_pendapatan_lain;
                $edit_permohonan_student->ibu_phone_rumah               = $request->mstpp_2_ibu_phone_rumah;
                $edit_permohonan_student->ibu_bil_anak                  = $request->mstpp_2_ibu_bil_anak;
                $edit_permohonan_student->ibu_bil_anak_sekolah          = $request->mstpp_2_ibu_bil_anak_sekolah;
                $edit_permohonan_student->ibu_hubungan_student          = $request->mstpp_2_ibu_hubungan_student;
                $edit_permohonan_student->ibu_tabika_lain               = $request->mstpp_2_ibu_tabika_lain;
                $edit_permohonan_student->ibu_pilihan                   = $request->mstpp_2_ibu_pilihan;
                $edit_permohonan_student->student_status                = 3;
                $edit_permohonan_student->dihantar_date                 = date('Y-m-d H:i:s');
                $edit_permohonan_student->save();
            }
        }

    }

    function senarai_sah_mohon_student_tp_g(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('tbk__student')
                        ->select('tbk__student.id AS id',
                                DB::raw("CONCAT('STP',tbk__profile.state_id,tbk__profile.daerah_id,tbk__student.id) AS no_permohonan"),
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'tbk__profile.tbk_nama AS tbk_nama',
                                'tbk__student.student_nama AS student_nama',
                                'tbk__student.student_mykid AS student_mykid',
                                'ref__jantina.jantina_description AS student_jantina',
                                'tbk__student.student_alamat AS student_alamat',
                                'ref__status_tbk_student.status_description AS student_status',
                                DB::raw("CONCAT(tbk__student.bapa_jumlah_pendapatan + tbk__student.ibu_jumlah_pendapatan) AS pendapatan"))
                        ->leftJoin('tbk__profile','tbk__profile.id','=','tbk__student.tabika_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','tbk__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','tbk__profile.daerah_id')
                        ->leftJoin('ref__jantina','ref__jantina.id','=','tbk__student.student_jantina_id')
                        ->leftJoin('ref__status_tbk_student','ref__status_tbk_student.id','=','tbk__student.student_status')
                        ->whereIN('tbk__student.student_status',[3,9])
                        ->where('tbk__profile.id', '=', Auth::user()->tabika_id)
                        ->orderBy('pendapatan', 'ASC')
                        ->orderBy('student_jarak_rumah', 'ASC')
                        ->orderBy('ibu_bil_anak', 'DESC')
                        ->orderBy('ibu_bil_anak_sekolah', 'DESC')
                        ->orderBy('ibu_pilihan', 'ASC')
                        ->orderBy('tbk__student.created_at', 'ASC')
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
            return view('rt-sm27.senarai-sah-mohon-student-tp-g',compact('roles_menu'));
        }
    }

    function sah_mohon_student_tp_g(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $tabika_profile     = DB::table('tbk__profile')->select('tbk__profile.id','tbk__profile.tbk_nama')->where('tbk__profile.tbk_status', '=', true)->get();
            $ref_agama          = Ref_Agama::where('status', '=', true)->get();
            $ref_jantina        = RefJantina::where('status', '=', true)->get();
            $ref_kaum           = RefKaum::where('status', '=', true)->get();
            $ref_profession     = RefProfession::where('status', '=', true)->get();
            $ref_kerakyatan     = Ref_Status_Warganegara::where('status', '=', true)->get();
            $tbk_student        = DB::table('tbk__student')
                                    ->select('tbk__student.id',
                                                'tbk__profile.state_id AS state_id',
                                                'tbk__profile.daerah_id AS daerah_id',
                                                'tbk__student.tabika_id AS tabika_id',
                                                'tbk__student.student_nama AS student_nama',
                                                'tbk__student.student_mykid AS student_mykid',
                                                'tbk__student.student_sijil_lahir AS student_sijil_lahir',
                                                DB::raw(" DATE_FORMAT(tbk__student.student_tarikh_lahir,'%d/%m/%Y') AS student_tarikh_lahir"),
                                                'tbk__student.student_agama_id AS student_agama_id',
                                                'tbk__student.student_jantina_id AS student_jantina_id', 
                                                'tbk__student.student_kaum_id AS student_kaum_id', 
                                                'tbk__student.student_kesihatan AS student_kesihatan',
                                                'tbk__student.student_alamat AS student_alamat',
                                                'tbk__student.student_jarak_rumah AS student_jarak_rumah',
                                                'tbk__student.bapa_nama AS bapa_nama',
                                                'tbk__student.bapa_ic AS bapa_ic',
                                                'tbk__student.bapa_pekerjaan AS bapa_pekerjaan',
                                                'tbk__student.bapa_profession_id AS bapa_profession_id',
                                                'tbk__student.bapa_pendapatan AS bapa_pendapatan',
                                                'tbk__student.bapa_alamat_office AS bapa_alamat_office',
                                                'tbk__student.bapa_phone_office AS bapa_phone_office',
                                                'tbk__student.bapa_kerakyatan_id AS bapa_kerakyatan_id',
                                                'tbk__student.bapa_phone AS bapa_phone',
                                                'tbk__student.bapa_jumlah_pendapatan AS bapa_jumlah_pendapatan',
                                                'tbk__student.bapa_phone_rumah AS bapa_phone_rumah')
                                    ->leftJoin('tbk__profile','tbk__profile.id','=','tbk__student.tabika_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','tbk__profile.state_id')
                                    ->where('tbk__student.id', '=', $id)
                                    ->limit(1)
                                    ->first();
            return view('rt-sm27.sah-mohon-student-tp-g', compact('roles_menu','negeri', 'daerah', 'tabika_profile', 'ref_agama', 'ref_jantina', 'ref_kaum', 'ref_profession', 'ref_kerakyatan', 'tbk_student'));
        }
    }

    function sah_mohon_student_tp_g_1(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $ref_profession     = RefProfession::where('status', '=', true)->get();
            $ref_kerakyatan     = Ref_Status_Warganegara::where('status', '=', true)->get();
            $tabika_profile     = DB::table('tbk__profile')->select('tbk__profile.id','tbk__profile.tbk_nama')->where('tbk__profile.tbk_status', '=', true)->get();
            $tbk_student        = DB::table('tbk__student')
                                    ->select('tbk__student.id',
                                                'tbk__profile.state_id AS state_id',
                                                'tbk__profile.daerah_id AS daerah_id',
                                                'tbk__student.tabika_id AS tabika_id',
                                                'tbk__student.ibu_nama AS ibu_nama',
                                                'tbk__student.ibu_ic AS ibu_ic',
                                                'tbk__student.ibu_pekerjaan AS ibu_pekerjaan',
                                                'tbk__student.ibu_profession_id AS ibu_profession_id',
                                                'tbk__student.ibu_pendapatan AS ibu_pendapatan', 
                                                'tbk__student.ibu_alamat_office AS ibu_alamat_office', 
                                                'tbk__student.ibu_phone_office AS ibu_phone_office',
                                                'tbk__student.ibu_kerakyatan_id AS ibu_kerakyatan_id',
                                                'tbk__student.ibu_phone AS ibu_phone',
                                                'tbk__student.ibu_jumlah_pendapatan AS ibu_jumlah_pendapatan',
                                                'tbk__student.ibu_jumlah_pendapatan_lain AS ibu_jumlah_pendapatan_lain',
                                                'tbk__student.ibu_phone_rumah AS ibu_phone_rumah',
                                                'tbk__student.ibu_bil_anak AS ibu_bil_anak',
                                                'tbk__student.ibu_bil_anak_sekolah AS ibu_bil_anak_sekolah',
                                                'tbk__student.ibu_hubungan_student AS ibu_hubungan_student',
                                                'tbk__student.ibu_tabika_lain AS ibu_tabika_lain',
                                                'tbk__student.ibu_pilihan AS ibu_pilihan')
                                    ->leftJoin('tbk__profile','tbk__profile.id','=','tbk__student.tabika_id')
                                    ->where('tbk__student.id', '=', $id)
                                    ->limit(1)
                                    ->first();
            return view('rt-sm27.sah-mohon-student-tp-g-1', compact('roles_menu','negeri', 'daerah', 'ref_profession', 'ref_kerakyatan', 'tabika_profile', 'tbk_student'));
        }
    }

    function post_sah_permohonan_student(Request $request){
        $action = $request->post_sah_permohonan_student;
        $app_id = $request->smstg_student_id;
        $status_pengesahan = $request->smstg_student_status;

        if ($status_pengesahan !== '7') {
            $rules_main = array(                
                'smstg_student_status'           => 'required',
                'smstg_disahkan_note'            => 'required',
            );
        } else {
            $rules_main = array(
                'smstg_student_status'           => 'required',
            );
        }
        
        $messages = [
            'smstg_student_status.required'      => 'Ruangan Status dipilih',
            'smstg_disahkan_note.required'       => 'Ruangan Penerangan mesti diisi',
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $sah_permohonan_student                     = TBK_Student::where($where)->first();
                $sah_permohonan_student->student_status     = $request->smstg_student_status;
                $sah_permohonan_student->disahkan_by        = Auth::user()->user_id;
                $sah_permohonan_student->disahkan_date      = date('Y-m-d H:i:s');
                $sah_permohonan_student->disahkan_note      = $request->smstg_disahkan_note;
                $sah_permohonan_student->ditolak_tahun      = $request->smstg_ditolak_tahun;
                $sah_permohonan_student->ditolak_penuh      = $request->smstg_ditolak_penuh;
                $sah_permohonan_student->ditolak_xlengkap   = $request->smstg_ditolak_xlengkap;
                $sah_permohonan_student->ditolak_jauh       = $request->smstg_ditolak_jauh;
                $sah_permohonan_student->save();
            }
        }
    }

    function senarai_lulus_mohon_student_tp_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('tbk__student')
                        ->select('tbk__student.id AS id',
                                 DB::raw("CONCAT('STP',tbk__profile.state_id,tbk__profile.daerah_id,tbk__student.id) AS no_permohonan"),
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'tbk__profile.tbk_nama AS tbk_nama',
                                'tbk__student.student_nama AS student_nama',
                                'tbk__student.student_mykid AS student_mykid',
                                'ref__jantina.jantina_description AS student_jantina',
                                'tbk__student.student_alamat AS student_alamat',
                                'ref__status_tbk_student.status_description AS student_status',
                                DB::raw("CONCAT(tbk__student.bapa_jumlah_pendapatan + tbk__student.ibu_jumlah_pendapatan) AS pendapatan"))
                        ->leftJoin('tbk__profile','tbk__profile.id','=','tbk__student.tabika_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','tbk__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','tbk__profile.daerah_id')
                        ->leftJoin('ref__jantina','ref__jantina.id','=','tbk__student.student_jantina_id')
                        ->leftJoin('ref__status_tbk_student','ref__status_tbk_student.id','=','tbk__student.student_status')
                        ->whereIN('tbk__student.student_status',[5,8])
                        ->where('tbk__profile.daerah_id', '=', Auth::user()->daerah_id)
                        ->orderBy('pendapatan', 'ASC')
                        ->orderBy('student_jarak_rumah', 'ASC')
                        ->orderBy('ibu_bil_anak', 'DESC')
                        ->orderBy('ibu_bil_anak_sekolah', 'DESC')
                        ->orderBy('ibu_pilihan', 'ASC')
                        ->orderBy('tbk__student.created_at', 'ASC')
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
            $tabika_profile     = DB::table('tbk__profile')
                                ->select('tbk__profile.id','tbk__profile.tbk_nama')
                                ->where('tbk__profile.tbk_status', '=', true)
                                ->where('tbk__profile.daerah_id', '=', Auth::user()->daerah_id)
                                ->get();
            return view('rt-sm27.senarai-lulus-mohon-student-tp-ppd', compact('roles_menu','tabika_profile'));
        }
    }

    function lulus_mohon_student_tp_ppd(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $tabika_profile     = DB::table('tbk__profile')->select('tbk__profile.id','tbk__profile.tbk_nama')->where('tbk__profile.tbk_status', '=', true)->get();
            $ref_agama          = Ref_Agama::where('status', '=', true)->get();
            $ref_jantina        = RefJantina::where('status', '=', true)->get();
            $ref_kaum           = RefKaum::where('status', '=', true)->get();
            $ref_profession     = RefProfession::where('status', '=', true)->get();
            $ref_kerakyatan     = Ref_Status_Warganegara::where('status', '=', true)->get();
            $tbk_student        = DB::table('tbk__student')
                                    ->select('tbk__student.id',
                                                'tbk__profile.state_id AS state_id',
                                                'tbk__profile.daerah_id AS daerah_id',
                                                'tbk__student.tabika_id AS tabika_id',
                                                'tbk__student.student_status AS status_pengesahan',
                                                'tbk__student.disahkan_note AS disahkan_note',
                                                'tbk__student.student_nama AS student_nama',
                                                'tbk__student.student_mykid AS student_mykid',
                                                'tbk__student.student_sijil_lahir AS student_sijil_lahir',
                                                DB::raw(" DATE_FORMAT(tbk__student.student_tarikh_lahir,'%d/%m/%Y') AS student_tarikh_lahir"),
                                                'tbk__student.student_agama_id AS student_agama_id',
                                                'tbk__student.student_jantina_id AS student_jantina_id', 
                                                'tbk__student.student_kaum_id AS student_kaum_id', 
                                                'tbk__student.student_kesihatan AS student_kesihatan',
                                                'tbk__student.student_alamat AS student_alamat',
                                                'tbk__student.student_jarak_rumah AS student_jarak_rumah',
                                                'tbk__student.bapa_nama AS bapa_nama',
                                                'tbk__student.bapa_ic AS bapa_ic',
                                                'tbk__student.bapa_pekerjaan AS bapa_pekerjaan',
                                                'tbk__student.bapa_profession_id AS bapa_profession_id',
                                                'tbk__student.bapa_pendapatan AS bapa_pendapatan',
                                                'tbk__student.bapa_alamat_office AS bapa_alamat_office',
                                                'tbk__student.bapa_phone_office AS bapa_phone_office',
                                                'tbk__student.bapa_kerakyatan_id AS bapa_kerakyatan_id',
                                                'tbk__student.bapa_phone AS bapa_phone',
                                                'tbk__student.bapa_jumlah_pendapatan AS bapa_jumlah_pendapatan',
                                                'tbk__student.bapa_phone_rumah AS bapa_phone_rumah')
                                    ->leftJoin('tbk__profile','tbk__profile.id','=','tbk__student.tabika_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','tbk__profile.state_id')
                                    ->where('tbk__student.id', '=', $id)
                                    ->limit(1)
                                    ->first();
            return view('rt-sm27.lulus-mohon-student-tp-ppd', compact('roles_menu','negeri', 'daerah', 'tabika_profile', 'ref_agama', 'ref_jantina', 'ref_kaum', 'ref_profession', 'ref_kerakyatan', 'tbk_student'));
        }
    }

    function lulus_mohon_student_tp_ppd_1(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $ref_profession     = RefProfession::where('status', '=', true)->get();
            $ref_kerakyatan     = Ref_Status_Warganegara::where('status', '=', true)->get();
            $tabika_profile     = DB::table('tbk__profile')->select('tbk__profile.id','tbk__profile.tbk_nama')->where('tbk__profile.tbk_status', '=', true)->get();
            $tbk_student        = DB::table('tbk__student')
                                    ->select('tbk__student.id',
                                                'tbk__profile.state_id AS state_id',
                                                'tbk__profile.daerah_id AS daerah_id',
                                                'tbk__student.tabika_id AS tabika_id',
                                                'tbk__student.student_status AS status_pengesahan',
                                                'tbk__student.disahkan_note AS disahkan_note',
                                                'tbk__student.ibu_nama AS ibu_nama',
                                                'tbk__student.ibu_ic AS ibu_ic',
                                                'tbk__student.ibu_pekerjaan AS ibu_pekerjaan',
                                                'tbk__student.ibu_profession_id AS ibu_profession_id',
                                                'tbk__student.ibu_pendapatan AS ibu_pendapatan', 
                                                'tbk__student.ibu_alamat_office AS ibu_alamat_office', 
                                                'tbk__student.ibu_phone_office AS ibu_phone_office',
                                                'tbk__student.ibu_kerakyatan_id AS ibu_kerakyatan_id',
                                                'tbk__student.ibu_phone AS ibu_phone',
                                                'tbk__student.ibu_jumlah_pendapatan AS ibu_jumlah_pendapatan',
                                                'tbk__student.ibu_jumlah_pendapatan_lain AS ibu_jumlah_pendapatan_lain',
                                                'tbk__student.ibu_phone_rumah AS ibu_phone_rumah',
                                                'tbk__student.ibu_bil_anak AS ibu_bil_anak',
                                                'tbk__student.ibu_bil_anak_sekolah AS ibu_bil_anak_sekolah',
                                                'tbk__student.ibu_hubungan_student AS ibu_hubungan_student',
                                                'tbk__student.ibu_tabika_lain AS ibu_tabika_lain',
                                                'tbk__student.ibu_pilihan AS ibu_pilihan')
                                    ->leftJoin('tbk__profile','tbk__profile.id','=','tbk__student.tabika_id')
                                    ->where('tbk__student.id', '=', $id)
                                    ->limit(1)
                                    ->first();
            return view('rt-sm27.lulus-mohon-student-tp-ppd-1', compact('roles_menu','negeri', 'daerah', 'ref_profession', 'ref_kerakyatan', 'tabika_profile', 'tbk_student'));
        }
    }

    function post_lulus_permohonan_student(Request $request){
        $action = $request->post_lulus_permohonan_student;
        $app_id = $request->lmstpd_student_id;
        
        $rules = array(
            'lmstpd_student_status'               => 'required',
        );

        $messages = [
            'lmstpd_student_status.required'      => 'Ruangan Status dipilih',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('id' => $app_id);
                $lulus_permohonan_student                       = TBK_Student::where($where)->first();
                $lulus_permohonan_student->student_status       = $request->lmstpd_student_status;
                $lulus_permohonan_student->diluluskan_by        = Auth::user()->user_id;
                $lulus_permohonan_student->diluluskan_date      = date('Y-m-d H:i:s');
                $lulus_permohonan_student->diluluskan_note      = $request->lmstpd_diluluskan_note;
                $lulus_permohonan_student->save();
            }
        }
    }

    function senarai_student_tp_p(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('tbk__student')
                        ->select('tbk__student.id AS id',
                                 DB::raw("CONCAT('STP',tbk__profile.state_id,tbk__profile.daerah_id,tbk__student.id) AS no_permohonan"),
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'tbk__profile.tbk_nama AS tbk_nama',
                                'tbk__student.student_nama AS student_nama',
                                'tbk__student.student_mykid AS student_mykid',
                                'ref__jantina.jantina_description AS student_jantina',
                                'tbk__student.student_alamat AS student_alamat',
                                'tbk__student.student_status AS status',
                                'ref__status_tbk_student.status_description AS student_status')
                        ->leftJoin('tbk__profile','tbk__profile.id','=','tbk__student.tabika_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','tbk__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','tbk__profile.daerah_id')
                        ->leftJoin('ref__jantina','ref__jantina.id','=','tbk__student.student_jantina_id')
                        ->leftJoin('ref__status_tbk_student','ref__status_tbk_student.id','=','tbk__student.student_status')
                        ->whereIN('tbk__student.student_status',[1,3,4,5,6,7])
                        ->where('tbk__student.dihantar_by', '=', Auth::user()->user_id)
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
            return view('rt-sm27.senarai-student-tp-p',compact('roles_menu'));
        }
    }

    function student_tp_p(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $tabika_profile     = DB::table('tbk__profile')->select('tbk__profile.id','tbk__profile.tbk_nama')->where('tbk__profile.tbk_status', '=', true)->get();
            $ref_agama          = Ref_Agama::where('status', '=', true)->get();
            $ref_jantina        = RefJantina::where('status', '=', true)->get();
            $ref_kaum           = RefKaum::where('status', '=', true)->get();
            $ref_profession     = RefProfession::where('status', '=', true)->get();
            $ref_kerakyatan     = Ref_Status_Warganegara::where('status', '=', true)->get();
            $tbk_student        = DB::table('tbk__student')
                                    ->select('tbk__student.id',
                                                'tbk__profile.state_id AS state_id',
                                                'tbk__profile.daerah_id AS daerah_id',
                                                'tbk__student.tabika_id AS tabika_id',
                                                'tbk__student.student_nama AS student_nama',
                                                'tbk__student.student_mykid AS student_mykid',
                                                'tbk__student.student_sijil_lahir AS student_sijil_lahir',
                                                DB::raw(" DATE_FORMAT(tbk__student.student_tarikh_lahir,'%d/%m/%Y') AS student_tarikh_lahir"),
                                                'tbk__student.student_agama_id AS student_agama_id',
                                                'tbk__student.student_jantina_id AS student_jantina_id', 
                                                'tbk__student.student_kaum_id AS student_kaum_id', 
                                                'tbk__student.student_kesihatan AS student_kesihatan',
                                                'tbk__student.student_alamat AS student_alamat',
                                                'tbk__student.student_jarak_rumah AS student_jarak_rumah',
                                                'tbk__student.bapa_nama AS bapa_nama',
                                                'tbk__student.bapa_ic AS bapa_ic',
                                                'tbk__student.bapa_pekerjaan AS bapa_pekerjaan',
                                                'tbk__student.bapa_profession_id AS bapa_profession_id',
                                                'tbk__student.bapa_pendapatan AS bapa_pendapatan',
                                                'tbk__student.bapa_alamat_office AS bapa_alamat_office',
                                                'tbk__student.bapa_phone_office AS bapa_phone_office',
                                                'tbk__student.bapa_kerakyatan_id AS bapa_kerakyatan_id',
                                                'tbk__student.bapa_phone AS bapa_phone',
                                                'tbk__student.bapa_jumlah_pendapatan AS bapa_jumlah_pendapatan',
                                                'tbk__student.bapa_phone_rumah AS bapa_phone_rumah')
                                    ->leftJoin('tbk__profile','tbk__profile.id','=','tbk__student.tabika_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','tbk__profile.state_id')
                                    ->where('tbk__student.id', '=', $id)
                                    ->limit(1)
                                    ->first();
            return view('rt-sm27.student-tp-p', compact('roles_menu','negeri', 'daerah', 'tabika_profile', 'ref_agama', 'ref_jantina', 'ref_kaum', 'ref_profession', 'ref_kerakyatan', 'tbk_student'));
        }
    }

    function student_tp_p_1(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $ref_profession     = RefProfession::where('status', '=', true)->get();
            $ref_kerakyatan     = Ref_Status_Warganegara::where('status', '=', true)->get();
            $tabika_profile     = DB::table('tbk__profile')->select('tbk__profile.id','tbk__profile.tbk_nama')->where('tbk__profile.tbk_status', '=', true)->get();
            $tbk_student        = DB::table('tbk__student')
                                    ->select('tbk__student.id',
                                                'tbk__profile.state_id AS state_id',
                                                'tbk__profile.daerah_id AS daerah_id',
                                                'tbk__student.tabika_id AS tabika_id',
                                                'tbk__student.ibu_nama AS ibu_nama',
                                                'tbk__student.ibu_ic AS ibu_ic',
                                                'tbk__student.ibu_pekerjaan AS ibu_pekerjaan',
                                                'tbk__student.ibu_profession_id AS ibu_profession_id',
                                                'tbk__student.ibu_pendapatan AS ibu_pendapatan', 
                                                'tbk__student.ibu_alamat_office AS ibu_alamat_office', 
                                                'tbk__student.ibu_phone_office AS ibu_phone_office',
                                                'tbk__student.ibu_kerakyatan_id AS ibu_kerakyatan_id',
                                                'tbk__student.ibu_phone AS ibu_phone',
                                                'tbk__student.ibu_jumlah_pendapatan AS ibu_jumlah_pendapatan',
                                                'tbk__student.ibu_jumlah_pendapatan_lain AS ibu_jumlah_pendapatan_lain',
                                                'tbk__student.ibu_phone_rumah AS ibu_phone_rumah',
                                                'tbk__student.ibu_bil_anak AS ibu_bil_anak',
                                                'tbk__student.ibu_bil_anak_sekolah AS ibu_bil_anak_sekolah',
                                                'tbk__student.ibu_hubungan_student AS ibu_hubungan_student',
                                                'tbk__student.ibu_tabika_lain AS ibu_tabika_lain',
                                                'tbk__student.ibu_pilihan AS ibu_pilihan')
                                    ->leftJoin('tbk__profile','tbk__profile.id','=','tbk__student.tabika_id')
                                    ->where('tbk__student.id', '=', $id)
                                    ->limit(1)
                                    ->first();
            return view('rt-sm27.student-tp-p-1', compact('roles_menu','negeri', 'daerah', 'ref_profession', 'ref_kerakyatan', 'tabika_profile', 'tbk_student'));
        }
    }

    function senarai_student_tp_g(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('tbk__student')
                        ->select('tbk__student.id AS id',
                                 DB::raw("CONCAT('STP',tbk__profile.state_id,tbk__profile.daerah_id,tbk__student.id) AS no_permohonan"),
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'tbk__profile.tbk_nama AS tbk_nama',
                                'tbk__student.student_nama AS student_nama',
                                'tbk__student.student_mykid AS student_mykid',
                                'ref__jantina.jantina_description AS student_jantina',
                                'tbk__student.student_alamat AS student_alamat',
                                'tbk__student.student_status AS status',
                                'ref__status_tbk_student.status_description AS student_status')
                        ->leftJoin('tbk__profile','tbk__profile.id','=','tbk__student.tabika_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','tbk__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','tbk__profile.daerah_id')
                        ->leftJoin('ref__jantina','ref__jantina.id','=','tbk__student.student_jantina_id')
                        ->leftJoin('ref__status_tbk_student','ref__status_tbk_student.id','=','tbk__student.student_status')
                        ->whereIN('tbk__student.student_status',[1,5,7,8])
                        ->where('tbk__profile.id', '=',Auth::user()->tabika_id)
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
            return view('rt-sm27.senarai-student-tp-g',compact('roles_menu'));
        }
    }

    function student_tp_g(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $tabika_profile     = DB::table('tbk__profile')->select('tbk__profile.id','tbk__profile.tbk_nama')->where('tbk__profile.tbk_status', '=', true)->get();
            $ref_agama          = Ref_Agama::where('status', '=', true)->get();
            $ref_jantina        = RefJantina::where('status', '=', true)->get();
            $ref_kaum           = RefKaum::where('status', '=', true)->get();
            $ref_profession     = RefProfession::where('status', '=', true)->get();
            $ref_kerakyatan     = Ref_Status_Warganegara::where('status', '=', true)->get();
            $tbk_student        = DB::table('tbk__student')
                                    ->select('tbk__student.id',
                                                'tbk__profile.state_id AS state_id',
                                                'tbk__profile.daerah_id AS daerah_id',
                                                'tbk__student.tabika_id AS tabika_id',
                                                'tbk__student.student_nama AS student_nama',
                                                'tbk__student.student_mykid AS student_mykid',
                                                'tbk__student.student_sijil_lahir AS student_sijil_lahir',
                                                DB::raw(" DATE_FORMAT(tbk__student.student_tarikh_lahir,'%d/%m/%Y') AS student_tarikh_lahir"),
                                                'tbk__student.student_agama_id AS student_agama_id',
                                                'tbk__student.student_jantina_id AS student_jantina_id', 
                                                'tbk__student.student_kaum_id AS student_kaum_id', 
                                                'tbk__student.student_kesihatan AS student_kesihatan',
                                                'tbk__student.student_alamat AS student_alamat',
                                                'tbk__student.student_jarak_rumah AS student_jarak_rumah',
                                                'tbk__student.bapa_nama AS bapa_nama',
                                                'tbk__student.bapa_ic AS bapa_ic',
                                                'tbk__student.bapa_pekerjaan AS bapa_pekerjaan',
                                                'tbk__student.bapa_profession_id AS bapa_profession_id',
                                                'tbk__student.bapa_pendapatan AS bapa_pendapatan',
                                                'tbk__student.bapa_alamat_office AS bapa_alamat_office',
                                                'tbk__student.bapa_phone_office AS bapa_phone_office',
                                                'tbk__student.bapa_kerakyatan_id AS bapa_kerakyatan_id',
                                                'tbk__student.bapa_phone AS bapa_phone',
                                                'tbk__student.bapa_jumlah_pendapatan AS bapa_jumlah_pendapatan',
                                                'tbk__student.bapa_phone_rumah AS bapa_phone_rumah')
                                    ->leftJoin('tbk__profile','tbk__profile.id','=','tbk__student.tabika_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','tbk__profile.state_id')
                                    ->where('tbk__student.id', '=', $id)
                                    ->limit(1)
                                    ->first();
            return view('rt-sm27.student-tp-g', compact('roles_menu','negeri', 'daerah', 'tabika_profile', 'ref_agama', 'ref_jantina', 'ref_kaum', 'ref_profession', 'ref_kerakyatan', 'tbk_student'));
        }
    }

    function student_tp_g_1(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $ref_profession     = RefProfession::where('status', '=', true)->get();
            $ref_kerakyatan     = Ref_Status_Warganegara::where('status', '=', true)->get();
            $tabika_profile     = DB::table('tbk__profile')->select('tbk__profile.id','tbk__profile.tbk_nama')->where('tbk__profile.tbk_status', '=', true)->get();
            $tbk_student        = DB::table('tbk__student')
                                    ->select('tbk__student.id',
                                                'tbk__profile.state_id AS state_id',
                                                'tbk__profile.daerah_id AS daerah_id',
                                                'tbk__student.tabika_id AS tabika_id',
                                                'tbk__student.ibu_nama AS ibu_nama',
                                                'tbk__student.ibu_ic AS ibu_ic',
                                                'tbk__student.ibu_pekerjaan AS ibu_pekerjaan',
                                                'tbk__student.ibu_profession_id AS ibu_profession_id',
                                                'tbk__student.ibu_pendapatan AS ibu_pendapatan', 
                                                'tbk__student.ibu_alamat_office AS ibu_alamat_office', 
                                                'tbk__student.ibu_phone_office AS ibu_phone_office',
                                                'tbk__student.ibu_kerakyatan_id AS ibu_kerakyatan_id',
                                                'tbk__student.ibu_phone AS ibu_phone',
                                                'tbk__student.ibu_jumlah_pendapatan AS ibu_jumlah_pendapatan',
                                                'tbk__student.ibu_jumlah_pendapatan_lain AS ibu_jumlah_pendapatan_lain',
                                                'tbk__student.ibu_phone_rumah AS ibu_phone_rumah',
                                                'tbk__student.ibu_bil_anak AS ibu_bil_anak',
                                                'tbk__student.ibu_bil_anak_sekolah AS ibu_bil_anak_sekolah',
                                                'tbk__student.ibu_hubungan_student AS ibu_hubungan_student',
                                                'tbk__student.ibu_tabika_lain AS ibu_tabika_lain',
                                                'tbk__student.ibu_pilihan AS ibu_pilihan')
                                    ->leftJoin('tbk__profile','tbk__profile.id','=','tbk__student.tabika_id')
                                    ->where('tbk__student.id', '=', $id)
                                    ->limit(1)
                                    ->first();
            return view('rt-sm27.student-tp-g-1', compact('roles_menu','negeri', 'daerah', 'ref_profession', 'ref_kerakyatan', 'tabika_profile', 'tbk_student'));
        }
    }

    function senarai_student_tp_ppd(Request $request){
        if($request->ajax()){ 
            $type = $request->type;
            $data = DB::table('tbk__student')
                        ->select('tbk__student.id AS id',
                                 DB::raw("CONCAT('STP',tbk__profile.state_id,tbk__profile.daerah_id,tbk__student.id) AS no_permohonan"),
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'tbk__profile.tbk_nama AS tbk_nama',
                                'tbk__student.student_nama AS student_nama',
                                'tbk__student.student_mykid AS student_mykid',
                                'ref__jantina.jantina_description AS student_jantina',
                                'tbk__student.student_alamat AS student_alamat',
                                'tbk__student.student_status AS status',
                                'ref__status_tbk_student.status_description AS student_status')
                        ->leftJoin('tbk__profile','tbk__profile.id','=','tbk__student.tabika_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','tbk__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','tbk__profile.daerah_id')
                        ->leftJoin('ref__jantina','ref__jantina.id','=','tbk__student.student_jantina_id')
                        ->leftJoin('ref__status_tbk_student','ref__status_tbk_student.id','=','tbk__student.student_status')
                        ->whereIN('tbk__student.student_status',[1,7])
                        ->where('tbk__profile.daerah_id', '=', Auth::user()->daerah_id)
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
            $tabika_profile     = DB::table('tbk__profile')
                                ->select('tbk__profile.id','tbk__profile.tbk_nama')
                                ->where('tbk__profile.tbk_status', '=', true)
                                ->where('tbk__profile.daerah_id', '=', Auth::user()->daerah_id)
                                ->get();
            return view('rt-sm27.senarai-student-tp-ppd', compact('roles_menu','tabika_profile'));
        }
    }

    function student_tp_ppd(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $tabika_profile     = DB::table('tbk__profile')->select('tbk__profile.id','tbk__profile.tbk_nama')->where('tbk__profile.tbk_status', '=', true)->get();
            $ref_agama          = Ref_Agama::where('status', '=', true)->get();
            $ref_jantina        = RefJantina::where('status', '=', true)->get();
            $ref_kaum           = RefKaum::where('status', '=', true)->get();
            $ref_profession     = RefProfession::where('status', '=', true)->get();
            $ref_kerakyatan     = Ref_Status_Warganegara::where('status', '=', true)->get();
            $tbk_student        = DB::table('tbk__student')
                                    ->select('tbk__student.id',
                                                'tbk__profile.state_id AS state_id',
                                                'tbk__profile.daerah_id AS daerah_id',
                                                'tbk__student.tabika_id AS tabika_id',
                                                'tbk__student.student_nama AS student_nama',
                                                'tbk__student.student_mykid AS student_mykid',
                                                'tbk__student.student_sijil_lahir AS student_sijil_lahir',
                                                DB::raw(" DATE_FORMAT(tbk__student.student_tarikh_lahir,'%d/%m/%Y') AS student_tarikh_lahir"),
                                                'tbk__student.student_agama_id AS student_agama_id',
                                                'tbk__student.student_jantina_id AS student_jantina_id', 
                                                'tbk__student.student_kaum_id AS student_kaum_id', 
                                                'tbk__student.student_kesihatan AS student_kesihatan',
                                                'tbk__student.student_alamat AS student_alamat',
                                                'tbk__student.student_jarak_rumah AS student_jarak_rumah',
                                                'tbk__student.bapa_nama AS bapa_nama',
                                                'tbk__student.bapa_ic AS bapa_ic',
                                                'tbk__student.bapa_pekerjaan AS bapa_pekerjaan',
                                                'tbk__student.bapa_profession_id AS bapa_profession_id',
                                                'tbk__student.bapa_pendapatan AS bapa_pendapatan',
                                                'tbk__student.bapa_alamat_office AS bapa_alamat_office',
                                                'tbk__student.bapa_phone_office AS bapa_phone_office',
                                                'tbk__student.bapa_kerakyatan_id AS bapa_kerakyatan_id',
                                                'tbk__student.bapa_phone AS bapa_phone',
                                                'tbk__student.bapa_jumlah_pendapatan AS bapa_jumlah_pendapatan',
                                                'tbk__student.bapa_phone_rumah AS bapa_phone_rumah')
                                    ->leftJoin('tbk__profile','tbk__profile.id','=','tbk__student.tabika_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','tbk__profile.state_id')
                                    ->where('tbk__student.id', '=', $id)
                                    ->limit(1)
                                    ->first();
            return view('rt-sm27.student-tp-ppd', compact('roles_menu','negeri', 'daerah', 'tabika_profile', 'ref_agama', 'ref_jantina', 'ref_kaum', 'ref_profession', 'ref_kerakyatan', 'tbk_student'));
        }
    }

    function student_tp_ppd_1(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $ref_profession     = RefProfession::where('status', '=', true)->get();
            $ref_kerakyatan     = Ref_Status_Warganegara::where('status', '=', true)->get();
            $tabika_profile     = DB::table('tbk__profile')->select('tbk__profile.id','tbk__profile.tbk_nama')->where('tbk__profile.tbk_status', '=', true)->get();
            $tbk_student        = DB::table('tbk__student')
                                    ->select('tbk__student.id',
                                                'tbk__profile.state_id AS state_id',
                                                'tbk__profile.daerah_id AS daerah_id',
                                                'tbk__student.tabika_id AS tabika_id',
                                                'tbk__student.ibu_nama AS ibu_nama',
                                                'tbk__student.ibu_ic AS ibu_ic',
                                                'tbk__student.ibu_pekerjaan AS ibu_pekerjaan',
                                                'tbk__student.ibu_profession_id AS ibu_profession_id',
                                                'tbk__student.ibu_pendapatan AS ibu_pendapatan', 
                                                'tbk__student.ibu_alamat_office AS ibu_alamat_office', 
                                                'tbk__student.ibu_phone_office AS ibu_phone_office',
                                                'tbk__student.ibu_kerakyatan_id AS ibu_kerakyatan_id',
                                                'tbk__student.ibu_phone AS ibu_phone',
                                                'tbk__student.ibu_jumlah_pendapatan AS ibu_jumlah_pendapatan',
                                                'tbk__student.ibu_jumlah_pendapatan_lain AS ibu_jumlah_pendapatan_lain',
                                                'tbk__student.ibu_phone_rumah AS ibu_phone_rumah',
                                                'tbk__student.ibu_bil_anak AS ibu_bil_anak',
                                                'tbk__student.ibu_bil_anak_sekolah AS ibu_bil_anak_sekolah',
                                                'tbk__student.ibu_hubungan_student AS ibu_hubungan_student',
                                                'tbk__student.ibu_tabika_lain AS ibu_tabika_lain',
                                                'tbk__student.ibu_pilihan AS ibu_pilihan')
                                    ->leftJoin('tbk__profile','tbk__profile.id','=','tbk__student.tabika_id')
                                    ->where('tbk__student.id', '=', $id)
                                    ->limit(1)
                                    ->first();
            return view('rt-sm27.student-tp-ppd-1', compact('roles_menu','negeri', 'daerah', 'ref_profession', 'ref_kerakyatan', 'tabika_profile', 'tbk_student'));
        }
    }

    function senarai_student_tp_hqtp(Request $request){
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
            } else if($type == 'get_tabika') {
                $value = $request->value;
                $where = array('daerah_description' => $value);
                $data  = DB::table('tbk__profile')
                        ->select('tbk__profile.id', 'tbk__profile.tbk_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','tbk__profile.daerah_id')
                        ->where('ref__daerahs.daerah_description', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('tbk__student')
                        ->select('tbk__student.id AS id',
                                 DB::raw("CONCAT('STP',tbk__profile.state_id,tbk__profile.daerah_id,tbk__student.id) AS no_permohonan"),
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'tbk__profile.tbk_nama AS tbk_nama',
                                'tbk__student.student_nama AS student_nama',
                                'tbk__student.student_mykid AS student_mykid',
                                'ref__jantina.jantina_description AS student_jantina',
                                'tbk__student.student_alamat AS student_alamat',
                                'tbk__student.student_status AS status',
                                'ref__status_tbk_student.status_description AS student_status')
                        ->leftJoin('tbk__profile','tbk__profile.id','=','tbk__student.tabika_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','tbk__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','tbk__profile.daerah_id')
                        ->leftJoin('ref__jantina','ref__jantina.id','=','tbk__student.student_jantina_id')
                        ->leftJoin('ref__status_tbk_student','ref__status_tbk_student.id','=','tbk__student.student_status')
                        ->whereIN('tbk__student.student_status',[1,7])
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
            return view('rt-sm27.senarai-student-tp-hqtp', compact('roles_menu','state'));
        }
    }

    function student_tp_hqtp(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $tabika_profile     = DB::table('tbk__profile')->select('tbk__profile.id','tbk__profile.tbk_nama')->where('tbk__profile.tbk_status', '=', true)->get();
            $ref_agama          = Ref_Agama::where('status', '=', true)->get();
            $ref_jantina        = RefJantina::where('status', '=', true)->get();
            $ref_kaum           = RefKaum::where('status', '=', true)->get();
            $ref_profession     = RefProfession::where('status', '=', true)->get();
            $ref_kerakyatan     = Ref_Status_Warganegara::where('status', '=', true)->get();
            $tbk_student        = DB::table('tbk__student')
                                    ->select('tbk__student.id',
                                                'tbk__profile.state_id AS state_id',
                                                'tbk__profile.daerah_id AS daerah_id',
                                                'tbk__student.tabika_id AS tabika_id',
                                                'tbk__student.student_nama AS student_nama',
                                                'tbk__student.student_mykid AS student_mykid',
                                                'tbk__student.student_sijil_lahir AS student_sijil_lahir',
                                                DB::raw(" DATE_FORMAT(tbk__student.student_tarikh_lahir,'%d/%m/%Y') AS student_tarikh_lahir"),
                                                'tbk__student.student_agama_id AS student_agama_id',
                                                'tbk__student.student_jantina_id AS student_jantina_id', 
                                                'tbk__student.student_kaum_id AS student_kaum_id', 
                                                'tbk__student.student_kesihatan AS student_kesihatan',
                                                'tbk__student.student_alamat AS student_alamat',
                                                'tbk__student.student_jarak_rumah AS student_jarak_rumah',
                                                'tbk__student.bapa_nama AS bapa_nama',
                                                'tbk__student.bapa_ic AS bapa_ic',
                                                'tbk__student.bapa_pekerjaan AS bapa_pekerjaan',
                                                'tbk__student.bapa_profession_id AS bapa_profession_id',
                                                'tbk__student.bapa_pendapatan AS bapa_pendapatan',
                                                'tbk__student.bapa_alamat_office AS bapa_alamat_office',
                                                'tbk__student.bapa_phone_office AS bapa_phone_office',
                                                'tbk__student.bapa_kerakyatan_id AS bapa_kerakyatan_id',
                                                'tbk__student.bapa_phone AS bapa_phone',
                                                'tbk__student.bapa_jumlah_pendapatan AS bapa_jumlah_pendapatan',
                                                'tbk__student.bapa_phone_rumah AS bapa_phone_rumah')
                                    ->leftJoin('tbk__profile','tbk__profile.id','=','tbk__student.tabika_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','tbk__profile.state_id')
                                    ->where('tbk__student.id', '=', $id)
                                    ->limit(1)
                                    ->first();
            return view('rt-sm27.student-tp-hqtp', compact('roles_menu','negeri', 'daerah', 'tabika_profile', 'ref_agama', 'ref_jantina', 'ref_kaum', 'ref_profession', 'ref_kerakyatan', 'tbk_student'));
        }
    }

    function student_tp_hqtp_1(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $ref_profession     = RefProfession::where('status', '=', true)->get();
            $ref_kerakyatan     = Ref_Status_Warganegara::where('status', '=', true)->get();
            $tabika_profile     = DB::table('tbk__profile')->select('tbk__profile.id','tbk__profile.tbk_nama')->where('tbk__profile.tbk_status', '=', true)->get();
            $tbk_student        = DB::table('tbk__student')
                                    ->select('tbk__student.id',
                                                'tbk__profile.state_id AS state_id',
                                                'tbk__profile.daerah_id AS daerah_id',
                                                'tbk__student.tabika_id AS tabika_id',
                                                'tbk__student.ibu_nama AS ibu_nama',
                                                'tbk__student.ibu_ic AS ibu_ic',
                                                'tbk__student.ibu_pekerjaan AS ibu_pekerjaan',
                                                'tbk__student.ibu_profession_id AS ibu_profession_id',
                                                'tbk__student.ibu_pendapatan AS ibu_pendapatan', 
                                                'tbk__student.ibu_alamat_office AS ibu_alamat_office', 
                                                'tbk__student.ibu_phone_office AS ibu_phone_office',
                                                'tbk__student.ibu_kerakyatan_id AS ibu_kerakyatan_id',
                                                'tbk__student.ibu_phone AS ibu_phone',
                                                'tbk__student.ibu_jumlah_pendapatan AS ibu_jumlah_pendapatan',
                                                'tbk__student.ibu_jumlah_pendapatan_lain AS ibu_jumlah_pendapatan_lain',
                                                'tbk__student.ibu_phone_rumah AS ibu_phone_rumah',
                                                'tbk__student.ibu_bil_anak AS ibu_bil_anak',
                                                'tbk__student.ibu_bil_anak_sekolah AS ibu_bil_anak_sekolah',
                                                'tbk__student.ibu_hubungan_student AS ibu_hubungan_student',
                                                'tbk__student.ibu_tabika_lain AS ibu_tabika_lain',
                                                'tbk__student.ibu_pilihan AS ibu_pilihan')
                                    ->leftJoin('tbk__profile','tbk__profile.id','=','tbk__student.tabika_id')
                                    ->where('tbk__student.id', '=', $id)
                                    ->limit(1)
                                    ->first();
            return view('rt-sm27.student-tp-hqtp-1', compact('roles_menu','negeri', 'daerah', 'ref_profession', 'ref_kerakyatan', 'tabika_profile', 'tbk_student'));
        }
    }

    function senarai_student_tp_pksin(Request $request){
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
            } else if($type == 'get_tabika') {
                $value = $request->value;
                $where = array('daerah_description' => $value);
                $data  = DB::table('tbk__profile')
                        ->select('tbk__profile.id', 'tbk__profile.tbk_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','tbk__profile.daerah_id')
                        ->where('ref__daerahs.daerah_description', '=',  $where)
                        ->get();
                return Response::json($data);
            }
            $data = DB::table('tbk__student')
                        ->select('tbk__student.id AS id',
                                 DB::raw("CONCAT('STP',tbk__profile.state_id,tbk__profile.daerah_id,tbk__student.id) AS no_permohonan"),
                                'ref__states.state_description AS state',
                                'ref__daerahs.daerah_description AS daerah',
                                'tbk__profile.tbk_nama AS tbk_nama',
                                'tbk__student.student_nama AS student_nama',
                                'tbk__student.student_mykid AS student_mykid',
                                'ref__jantina.jantina_description AS student_jantina',
                                'tbk__student.student_alamat AS student_alamat',
                                'tbk__student.student_status AS status',
                                'ref__status_tbk_student.status_description AS student_status')
                        ->leftJoin('tbk__profile','tbk__profile.id','=','tbk__student.tabika_id')
                        ->leftJoin('ref__states','ref__states.state_id','=','tbk__profile.state_id')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','tbk__profile.daerah_id')
                        ->leftJoin('ref__jantina','ref__jantina.id','=','tbk__student.student_jantina_id')
                        ->leftJoin('ref__status_tbk_student','ref__status_tbk_student.id','=','tbk__student.student_status')
                        ->whereIN('tbk__student.student_status',[1,7])
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
            return view('rt-sm27.senarai-student-tp-pksin', compact('roles_menu','state'));
        }
    }

    function student_tp_pksin(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $tabika_profile     = DB::table('tbk__profile')->select('tbk__profile.id','tbk__profile.tbk_nama')->where('tbk__profile.tbk_status', '=', true)->get();
            $ref_agama          = Ref_Agama::where('status', '=', true)->get();
            $ref_jantina        = RefJantina::where('status', '=', true)->get();
            $ref_kaum           = RefKaum::where('status', '=', true)->get();
            $ref_profession     = RefProfession::where('status', '=', true)->get();
            $ref_kerakyatan     = Ref_Status_Warganegara::where('status', '=', true)->get();
            $tbk_student        = DB::table('tbk__student')
                                    ->select('tbk__student.id',
                                                'tbk__profile.state_id AS state_id',
                                                'tbk__profile.daerah_id AS daerah_id',
                                                'tbk__student.tabika_id AS tabika_id',
                                                'tbk__student.student_nama AS student_nama',
                                                'tbk__student.student_mykid AS student_mykid',
                                                'tbk__student.student_sijil_lahir AS student_sijil_lahir',
                                                DB::raw(" DATE_FORMAT(tbk__student.student_tarikh_lahir,'%d/%m/%Y') AS student_tarikh_lahir"),
                                                'tbk__student.student_agama_id AS student_agama_id',
                                                'tbk__student.student_jantina_id AS student_jantina_id', 
                                                'tbk__student.student_kaum_id AS student_kaum_id', 
                                                'tbk__student.student_kesihatan AS student_kesihatan',
                                                'tbk__student.student_alamat AS student_alamat',
                                                'tbk__student.student_jarak_rumah AS student_jarak_rumah',
                                                'tbk__student.bapa_nama AS bapa_nama',
                                                'tbk__student.bapa_ic AS bapa_ic',
                                                'tbk__student.bapa_pekerjaan AS bapa_pekerjaan',
                                                'tbk__student.bapa_profession_id AS bapa_profession_id',
                                                'tbk__student.bapa_pendapatan AS bapa_pendapatan',
                                                'tbk__student.bapa_alamat_office AS bapa_alamat_office',
                                                'tbk__student.bapa_phone_office AS bapa_phone_office',
                                                'tbk__student.bapa_kerakyatan_id AS bapa_kerakyatan_id',
                                                'tbk__student.bapa_phone AS bapa_phone',
                                                'tbk__student.bapa_jumlah_pendapatan AS bapa_jumlah_pendapatan',
                                                'tbk__student.bapa_phone_rumah AS bapa_phone_rumah')
                                    ->leftJoin('tbk__profile','tbk__profile.id','=','tbk__student.tabika_id')
                                    ->leftJoin('ref__states','ref__states.state_id','=','tbk__profile.state_id')
                                    ->where('tbk__student.id', '=', $id)
                                    ->limit(1)
                                    ->first();
            return view('rt-sm27.student-tp-pksin', compact('roles_menu','negeri', 'daerah', 'tabika_profile', 'ref_agama', 'ref_jantina', 'ref_kaum', 'ref_profession', 'ref_kerakyatan', 'tbk_student'));
        }
    }

    function student_tp_pksin_1(Request $request, $id){
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
            $negeri             = RefStates::where('status', '=', true)->get();
            $daerah             = RefDaerah::where('status', '=', true)->get();
            $ref_profession     = RefProfession::where('status', '=', true)->get();
            $ref_kerakyatan     = Ref_Status_Warganegara::where('status', '=', true)->get();
            $tabika_profile     = DB::table('tbk__profile')->select('tbk__profile.id','tbk__profile.tbk_nama')->where('tbk__profile.tbk_status', '=', true)->get();
            $tbk_student        = DB::table('tbk__student')
                                    ->select('tbk__student.id',
                                                'tbk__profile.state_id AS state_id',
                                                'tbk__profile.daerah_id AS daerah_id',
                                                'tbk__student.tabika_id AS tabika_id',
                                                'tbk__student.ibu_nama AS ibu_nama',
                                                'tbk__student.ibu_ic AS ibu_ic',
                                                'tbk__student.ibu_pekerjaan AS ibu_pekerjaan',
                                                'tbk__student.ibu_profession_id AS ibu_profession_id',
                                                'tbk__student.ibu_pendapatan AS ibu_pendapatan', 
                                                'tbk__student.ibu_alamat_office AS ibu_alamat_office', 
                                                'tbk__student.ibu_phone_office AS ibu_phone_office',
                                                'tbk__student.ibu_kerakyatan_id AS ibu_kerakyatan_id',
                                                'tbk__student.ibu_phone AS ibu_phone',
                                                'tbk__student.ibu_jumlah_pendapatan AS ibu_jumlah_pendapatan',
                                                'tbk__student.ibu_jumlah_pendapatan_lain AS ibu_jumlah_pendapatan_lain',
                                                'tbk__student.ibu_phone_rumah AS ibu_phone_rumah',
                                                'tbk__student.ibu_bil_anak AS ibu_bil_anak',
                                                'tbk__student.ibu_bil_anak_sekolah AS ibu_bil_anak_sekolah',
                                                'tbk__student.ibu_hubungan_student AS ibu_hubungan_student',
                                                'tbk__student.ibu_tabika_lain AS ibu_tabika_lain',
                                                'tbk__student.ibu_pilihan AS ibu_pilihan')
                                    ->leftJoin('tbk__profile','tbk__profile.id','=','tbk__student.tabika_id')
                                    ->where('tbk__student.id', '=', $id)
                                    ->limit(1)
                                    ->first();
            return view('rt-sm27.student-tp-pksin-1', compact('roles_menu','negeri', 'daerah', 'ref_profession', 'ref_kerakyatan', 'tabika_profile', 'tbk_student'));
        }
    }

    function senarai_mohon_masuk_tabika_admin(){
        return view('rt-sm27.senarai-mohon-masuk-tabika-admin');
    }

    function mohon_masuk_tabika_admin(){
        return view('rt-sm27.mohon-masuk-tabika-admin');
    }

    function mohon_masuk_tabika_admin_1(){
        return view('rt-sm27.mohon-masuk-tabika-admin-1');
    }

    function senarai_sah_mohon_masuk_tabika_admin(){
        return view('rt-sm27.senarai-sah-mohon-masuk-tabika-admin');
    }

    function sah_mohon_masuk_tabika_admin(){
        return view('rt-sm27.sah-mohon-masuk-tabika-admin');
    }

    function sah_mohon_masuk_tabika_admin_1(){
        return view('rt-sm27.sah-mohon-masuk-tabika-admin-1');
    }

    function senarai_lulus_mohon_masuk_tabika_admin(){
        return view('rt-sm27.senarai-lulus-mohon-masuk-tabika-admin');
    }
    
    function lulus_mohon_masuk_tabika_admin(){
        return view('rt-sm27.lulus-mohon-masuk-tabika-admin');
    }

    function lulus_mohon_masuk_tabika_admin_1(){
        return view('rt-sm27.lulus-mohon-masuk-tabika-admin-1');
    }

    function senarai_masuk_tabika_admin(){
        return view('rt-sm27.senarai-masuk-tabika-admin');
    }

    function laporan_bil_murid_negeri_admin(){
        return view('rt-sm27.laporan-bil-murid-negeri-admin');
    }

    function laporan_bil_murid_kaum_admin(){
        return view('rt-sm27.laporan-bil-murid-kaum-admin');
    }
}
