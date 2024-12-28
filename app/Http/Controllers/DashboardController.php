<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Hash;
use update;
use Session;
use App\User;
use App\Users;
use Validator;
use DataTables;
use Carbon\Carbon;
use App\UserProfile;
use App\Mail\SendMail;
use App\Mail\UpdateProfileMail;
use Redirect, Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index(Request $request)
    {
        if ($request->ajax()) {
            $type = $request->type;
        } else {
            $roles_menu = DB::table('roles__menu')
                ->select(
                    'roles__menu.id AS id',
                    'users__menu.menu_id AS first_menu',
                    'users__menu.menu2nd_id AS second_menu',
                    'users__menu.users_menu_page_name AS nama_menu',
                    'users__menu.users_menu_file_url AS menu_url',
                    'users__menu.highlight AS highlight_menu',
                    'users__menu.users_menu_page_icon AS icon_menu'
                )
                ->leftJoin('users__menu', 'users__menu.id', '=', 'roles__menu.users_menu_id')
                ->leftJoin('users__roles', 'users__roles.role_id', '=', 'roles__menu.role_id')
                ->where('users__roles.user_id', '=', Auth::user()->user_id)
                ->where('roles__menu.status', '=', true)
                ->orderBy('first_menu', 'asc')
                ->orderBy('id', 'asc')
                ->get();
            $role_users  = DB::table('users__roles')
                ->select(
                    'users__roles.user_id',
                    DB::raw("CASE WHEN users__roles.role_id >= 18 AND users__roles.role_id <= 25 THEN '1' ELSE '0' END AS role_users")
                )
                ->where('users__roles.user_id', '=', Auth::user()->user_id)
                ->orderBy('users__roles.role_id', 'Desc')
                ->limit(1)
                ->first();
            $total_ikes  = DB::table('spk__ikes')
                ->select(
                    DB::raw("count(*) as total_ikes")
                )
                ->where('spk__ikes.status', '=', '1')
                ->limit(1)
                ->first();
            $total_iramal   = DB::table('spk__imuhibbah')
                ->select(
                    DB::raw("count(*) as total_iramal")
                )
                ->where('spk__imuhibbah.status', '=', '1')
                ->limit(1)
                ->first();
            $total_mkp      = DB::table('spk__imediator')
                ->select(
                    DB::raw("count(*) as total_mkp")
                )
                ->where('spk__imediator.status', '=', '1')
                ->limit(1)
                ->first();
            $total_mediasi  = DB::table('spk__imediator_mediasi')
                ->select(
                    DB::raw("count(*) as total_mediasi")
                )
                ->where('spk__imediator_mediasi.status', '=', '1')
                ->limit(1)
                ->first();
            $total_kes_s_1  = DB::table('spk__ikes')
                ->select(
                    DB::raw("count(*) as total_kes_s_1")
                )
                ->where('spk__ikes.status', '=', '1')
                ->where('spk__ikes.state_id', '=', '01')
                ->limit(1)
                ->first();
            $total_kes_s_2  = DB::table('spk__ikes')
                ->select(
                    DB::raw("count(*) as total_kes_s_2")
                )
                ->where('spk__ikes.status', '=', '1')
                ->where('spk__ikes.state_id', '=', '02')
                ->limit(1)
                ->first();
            $total_kes_s_3  = DB::table('spk__ikes')
                ->select(
                    DB::raw("count(*) as total_kes_s_3")
                )
                ->where('spk__ikes.status', '=', '1')
                ->where('spk__ikes.state_id', '=', '03')
                ->limit(1)
                ->first();
            $total_kes_s_4  = DB::table('spk__ikes')
                ->select(
                    DB::raw("count(*) as total_kes_s_4")
                )
                ->where('spk__ikes.status', '=', '1')
                ->where('spk__ikes.state_id', '=', '04')
                ->limit(1)
                ->first();
            $total_kes_s_5  = DB::table('spk__ikes')
                ->select(
                    DB::raw("count(*) as total_kes_s_5")
                )
                ->where('spk__ikes.status', '=', '1')
                ->where('spk__ikes.state_id', '=', '05')
                ->limit(1)
                ->first();
            $total_kes_s_6  = DB::table('spk__ikes')
                ->select(
                    DB::raw("count(*) as total_kes_s_6")
                )
                ->where('spk__ikes.status', '=', '1')
                ->where('spk__ikes.state_id', '=', '06')
                ->limit(1)
                ->first();
            $total_kes_s_7  = DB::table('spk__ikes')
                ->select(
                    DB::raw("count(*) as total_kes_s_7")
                )
                ->where('spk__ikes.status', '=', '1')
                ->where('spk__ikes.state_id', '=', '07')
                ->limit(1)
                ->first();
            $total_kes_s_8  = DB::table('spk__ikes')
                ->select(
                    DB::raw("count(*) as total_kes_s_8")
                )
                ->where('spk__ikes.status', '=', '1')
                ->where('spk__ikes.state_id', '=', '08')
                ->limit(1)
                ->first();
            $total_kes_s_9  = DB::table('spk__ikes')
                ->select(
                    DB::raw("count(*) as total_kes_s_9")
                )
                ->where('spk__ikes.status', '=', '1')
                ->where('spk__ikes.state_id', '=', '09')
                ->limit(1)
                ->first();
            $total_kes_s_10  = DB::table('spk__ikes')
                ->select(
                    DB::raw("count(*) as total_kes_s_10")
                )
                ->where('spk__ikes.status', '=', '1')
                ->where('spk__ikes.state_id', '=', '10')
                ->limit(1)
                ->first();
            $total_kes_s_11  = DB::table('spk__ikes')
                ->select(
                    DB::raw("count(*) as total_kes_s_11")
                )
                ->where('spk__ikes.status', '=', '1')
                ->where('spk__ikes.state_id', '=', '11')
                ->limit(1)
                ->first();
            $total_kes_s_12  = DB::table('spk__ikes')
                ->select(
                    DB::raw("count(*) as total_kes_s_12")
                )
                ->where('spk__ikes.status', '=', '1')
                ->where('spk__ikes.state_id', '=', '12')
                ->limit(1)
                ->first();
            $total_kes_s_13  = DB::table('spk__ikes')
                ->select(
                    DB::raw("count(*) as total_kes_s_13")
                )
                ->where('spk__ikes.status', '=', '1')
                ->where('spk__ikes.state_id', '=', '13')
                ->limit(1)
                ->first();
            $total_kes_s_14  = DB::table('spk__ikes')
                ->select(
                    DB::raw("count(*) as total_kes_s_14")
                )
                ->where('spk__ikes.status', '=', '1')
                ->where('spk__ikes.state_id', '=', '14')
                ->limit(1)
                ->first();
            $total_kes_s_15  = DB::table('spk__ikes')
                ->select(
                    DB::raw("count(*) as total_kes_s_15")
                )
                ->where('spk__ikes.status', '=', '1')
                ->where('spk__ikes.state_id', '=', '15')
                ->limit(1)
                ->first();
            $total_kes_s_16  = DB::table('spk__ikes')
                ->select(
                    DB::raw("count(*) as total_kes_s_16")
                )
                ->where('spk__ikes.status', '=', '1')
                ->where('spk__ikes.state_id', '=', '16')
                ->limit(1)
                ->first();
            $total_mkp_s_1  = DB::table('spk__imediator')
                ->select(
                    DB::raw("count(*) as total_mkp_s_1")
                )
                ->leftJoin('users__profile', 'users__profile.user_id', '=', 'spk__imediator.user_id')
                ->where('spk__imediator.status', '=', '1')
                ->where('users__profile.state_id', '=', '01')
                ->limit(1)
                ->first();
            $total_mkp_s_2  = DB::table('spk__imediator')
                ->select(
                    DB::raw("count(*) as total_mkp_s_2")
                )
                ->leftJoin('users__profile', 'users__profile.user_id', '=', 'spk__imediator.user_id')
                ->where('spk__imediator.status', '=', '1')
                ->where('users__profile.state_id', '=', '02')
                ->limit(1)
                ->first();
            $total_mkp_s_3  = DB::table('spk__imediator')
                ->select(
                    DB::raw("count(*) as total_mkp_s_3")
                )
                ->leftJoin('users__profile', 'users__profile.user_id', '=', 'spk__imediator.user_id')
                ->where('spk__imediator.status', '=', '1')
                ->where('users__profile.state_id', '=', '03')
                ->limit(1)
                ->first();
            $total_mkp_s_4  = DB::table('spk__imediator')
                ->select(
                    DB::raw("count(*) as total_mkp_s_4")
                )
                ->leftJoin('users__profile', 'users__profile.user_id', '=', 'spk__imediator.user_id')
                ->where('spk__imediator.status', '=', '1')
                ->where('users__profile.state_id', '=', '04')
                ->limit(1)
                ->first();
            $total_mkp_s_5  = DB::table('spk__imediator')
                ->select(
                    DB::raw("count(*) as total_mkp_s_5")
                )
                ->leftJoin('users__profile', 'users__profile.user_id', '=', 'spk__imediator.user_id')
                ->where('spk__imediator.status', '=', '1')
                ->where('users__profile.state_id', '=', '05')
                ->limit(1)
                ->first();
            $total_mkp_s_6  = DB::table('spk__imediator')
                ->select(
                    DB::raw("count(*) as total_mkp_s_6")
                )
                ->leftJoin('users__profile', 'users__profile.user_id', '=', 'spk__imediator.user_id')
                ->where('spk__imediator.status', '=', '1')
                ->where('users__profile.state_id', '=', '06')
                ->limit(1)
                ->first();
            $total_mkp_s_7  = DB::table('spk__imediator')
                ->select(
                    DB::raw("count(*) as total_mkp_s_7")
                )
                ->leftJoin('users__profile', 'users__profile.user_id', '=', 'spk__imediator.user_id')
                ->where('spk__imediator.status', '=', '1')
                ->where('users__profile.state_id', '=', '07')
                ->limit(1)
                ->first();
            $total_mkp_s_8  = DB::table('spk__imediator')
                ->select(
                    DB::raw("count(*) as total_mkp_s_8")
                )
                ->leftJoin('users__profile', 'users__profile.user_id', '=', 'spk__imediator.user_id')
                ->where('spk__imediator.status', '=', '1')
                ->where('users__profile.state_id', '=', '08')
                ->limit(1)
                ->first();
            $total_mkp_s_9  = DB::table('spk__imediator')
                ->select(DB::raw("count(*) as total_mkp_s_9"))
                ->leftJoin('users__profile', 'users__profile.user_id', '=', 'spk__imediator.user_id')
                ->where('spk__imediator.status', '=', '1')
                ->where('users__profile.state_id', '=', '09')
                ->limit(1)
                ->first();
            $total_mkp_s_10  = DB::table('spk__imediator')
                ->select(
                    DB::raw("count(*) as total_mkp_s_10")
                )
                ->leftJoin('users__profile', 'users__profile.user_id', '=', 'spk__imediator.user_id')
                ->where('spk__imediator.status', '=', '1')
                ->where('users__profile.state_id', '=', '10')
                ->limit(1)
                ->first();
            $total_mkp_s_11  = DB::table('spk__imediator')
                ->select(
                    DB::raw("count(*) as total_mkp_s_11")
                )
                ->leftJoin('users__profile', 'users__profile.user_id', '=', 'spk__imediator.user_id')
                ->where('spk__imediator.status', '=', '1')
                ->where('users__profile.state_id', '=', '11')
                ->limit(1)
                ->first();
            $total_mkp_s_12  = DB::table('spk__imediator')
                ->select(
                    DB::raw("count(*) as total_mkp_s_12")
                )
                ->leftJoin('users__profile', 'users__profile.user_id', '=', 'spk__imediator.user_id')
                ->where('spk__imediator.status', '=', '1')
                ->where('users__profile.state_id', '=', '12')
                ->limit(1)
                ->first();
            $total_mkp_s_13  = DB::table('spk__imediator')
                ->select(
                    DB::raw("count(*) as total_mkp_s_13")
                )
                ->leftJoin('users__profile', 'users__profile.user_id', '=', 'spk__imediator.user_id')
                ->where('spk__imediator.status', '=', '1')
                ->where('users__profile.state_id', '=', '13')
                ->limit(1)
                ->first();
            $total_mkp_s_14  = DB::table('spk__imediator')
                ->select(
                    DB::raw("count(*) as total_mkp_s_14")
                )
                ->leftJoin('users__profile', 'users__profile.user_id', '=', 'spk__imediator.user_id')
                ->where('spk__imediator.status', '=', '1')
                ->where('users__profile.state_id', '=', '14')
                ->limit(1)
                ->first();
            $total_mkp_s_15  = DB::table('spk__imediator')
                ->select(
                    DB::raw("count(*) as total_mkp_s_15")
                )
                ->leftJoin('users__profile', 'users__profile.user_id', '=', 'spk__imediator.user_id')
                ->where('spk__imediator.status', '=', '1')
                ->where('users__profile.state_id', '=', '15')
                ->limit(1)
                ->first();
            $total_mkp_s_16  = DB::table('spk__imediator')
                ->select(
                    DB::raw("count(*) as total_mkp_s_16")
                )
                ->leftJoin('users__profile', 'users__profile.user_id', '=', 'spk__imediator.user_id')
                ->where('spk__imediator.status', '=', '1')
                ->where('users__profile.state_id', '=', '16')
                ->limit(1)
                ->first();
            return view('dashboard.index', compact(
                'roles_menu',
                'role_users',
                'total_ikes',
                'total_iramal',
                'total_mkp',
                'total_mediasi',
                'total_kes_s_1',
                'total_kes_s_2',
                'total_kes_s_3',
                'total_kes_s_4',
                'total_kes_s_5',
                'total_kes_s_6',
                'total_kes_s_7',
                'total_kes_s_8',
                'total_kes_s_9',
                'total_kes_s_10',
                'total_kes_s_11',
                'total_kes_s_12',
                'total_kes_s_13',
                'total_kes_s_14',
                'total_kes_s_15',
                'total_kes_s_16',
                'total_mkp_s_1',
                'total_mkp_s_2',
                'total_mkp_s_3',
                'total_mkp_s_4',
                'total_mkp_s_5',
                'total_mkp_s_6',
                'total_mkp_s_7',
                'total_mkp_s_8',
                'total_mkp_s_9',
                'total_mkp_s_10',
                'total_mkp_s_11',
                'total_mkp_s_12',
                'total_mkp_s_13',
                'total_mkp_s_14',
                'total_mkp_s_15',
                'total_mkp_s_16'
            ));
        }
    }



    function user_profile(Request $request)
    {
        if ($request->ajax()) {
            $type = $request->type;
            $data = DB::table('krt__kewangan')
                ->select(
                    'krt__kewangan.id',
                    'krt__kewangan.kewangan_butiran AS kewangan_butiran',
                    DB::raw("DATE_FORMAT(krt__kewangan.kewangan_tarikh_t_b,'%d/%m/%Y') AS tarikh_t_b"),
                    'krt__kewangan.kewangan_cek_baucer AS kewangan_cek_baucer',
                    DB::raw("DATE_FORMAT(krt__kewangan.kewangan_tarikh_cek,'%d/%m/%Y') AS kewangan_tarikh_cek"),
                    DB::raw("CASE WHEN krt__kewangan.kewangan_jenis_kewangan = 1 THEN krt__kewangan.kewangan_jumlah_tunai ELSE '0' END AS terima_tunai"),
                    DB::raw("CASE WHEN krt__kewangan.kewangan_jenis_kewangan = 1 THEN krt__kewangan.kewangan_jumlah_bank ELSE '0' END AS terima_bank"),
                    DB::raw("CASE WHEN krt__kewangan.kewangan_jenis_kewangan = 2 THEN krt__kewangan.kewangan_jumlah_tunai ELSE '0' END AS bayar_tunai"),
                    DB::raw("CASE  WHEN krt__kewangan.kewangan_jenis_kewangan = 2 THEN krt__kewangan.kewangan_jumlah_bank ELSE '0' END AS bayar_bank"),
                    'krt__kewangan.kewangan_baki_tunai AS kewangan_baki_tunai',
                    'krt__kewangan.kewangan_baki_bank AS kewangan_baki_bank'
                )
                ->orderBy('krt__kewangan.id', 'asc')
                ->where('krt__kewangan.krt_profile_id', '=', Auth::user()->krt_id)
                ->get();
            return Datatables::of($data)
                ->make(true);
        } else {
            $roles_menu     = DB::table('roles__menu')
                ->select(
                    'roles__menu.id AS id',
                    'users__menu.menu_id AS first_menu',
                    'users__menu.menu2nd_id AS second_menu',
                    'users__menu.users_menu_page_name AS nama_menu',
                    'users__menu.users_menu_file_url AS menu_url',
                    'users__menu.highlight AS highlight_menu',
                    'users__menu.users_menu_page_icon AS icon_menu'
                )
                ->leftJoin('users__menu', 'users__menu.id', '=', 'roles__menu.users_menu_id')
                ->leftJoin('users__roles', 'users__roles.role_id', '=', 'roles__menu.role_id')
                ->where('users__roles.user_id', '=', Auth::user()->user_id)
                ->where('roles__menu.status', '=', true)
                ->orderBy('first_menu', 'asc')
                ->orderBy('id', 'asc')
                ->get();
            $krt     = DB::table('krt__profile')
                ->select(
                    'krt__profile.id AS id',
                    'krt__profile.krt_nama AS krt_nama',
                    'krt__profile.krt_bank_no_acc as bank_no_acc',
                    'krt__profile.krt_bank_nama AS bank_nama',
                    'krt__profile.krt_bank_no_evendor AS no_evendor',
                    'ref__daerahs.daerah_description AS daerah',
                    'ref__states.state_description AS state'
                )
                ->leftJoin('ref__states', 'ref__states.state_id', '=', 'krt__profile.state_id')
                ->leftJoin('ref__daerahs', 'ref__daerahs.daerah_id', '=', 'krt__profile.daerah_id')
                ->where('krt__profile.id', '=', Auth::user()->krt_id)
                ->limit(1)
                ->first();

            $profile  =  DB::table('users__profile')
                ->select(
                    'users__profile.user_id As user_profile_user_id',
                    'users__profile.id AS user_profile_id',
                    'users__profile.user_fullname AS name',
                    'users__profile.no_phone AS no_phone',
                    'users.user_email AS user_email',
                    'users.password AS password',
                    'krt__profile.id',
                    'krt__profile.krt_nama AS krt_nama',
                    'users__profile.no_ic AS no_ic'
                )
                ->leftJoin('krt__profile', 'krt__profile.id', '=', 'users__profile.krt_id')
                ->leftJoin('users', 'users.user_id', '=', 'users__profile.user_id')
                ->where('krt__profile.id', '=', Auth::user()->krt_id)
                ->where('users__profile.user_id', '=', Auth::user()->user_id)
                ->limit(1)
                ->first();


            // $ajk       =  DB::table('krt__ahli_jawatan_kuasa')
            //                 ->select('users__profile.user_id As user_profile_user_id',
            //                         'krt__ahli_jawatan_kuasa.ajk_alamat As ajk_alamat',
            //                         'krt__ahli_jawatan_kuasa.krt_profile_id As krt_profile_id',
            //                         'krt__ahli_jawatan_kuasa.ajk_nama As ajk_nama',
            //                         'users.user_id As user_id')
            //                 ->leftJoin('users__profile', 'users__profile.no_ic', '=', 'krt_ahli_jawatan_kuasa.ajk_ic')
            //                 ->leftJoin('users', 'users.user_id', '=', 'users__profile.user_id')
            //                 ->where('krt__ahli_jawatan_kuasa.krt_profile_id', '=', Auth::user()->krt_id)
            //                 ->where('users.user_id', '=', Auth::user()->user_id)
            //                 ->limit(1)
            //                 ->first();



            //return dd($profile);
            return view('user_profile', compact('roles_menu', 'krt', 'profile'));
        }
    }

    function update_user_profile(Request $request)
    {
        $app_id = $request->user_profile_user_id;
        $app_id2 = $request->user_profile_id;


        $rules = array(
            'user_email'                    => 'required|email',
            // 'new_password'                  => 'min:6',
            'no_phone'                      => 'required',
            'captcha'                       => 'required|captcha',
        );

        $messages = [
            'user_email.required'           => 'Ruangan Email mesti diisi',
            // 'new_password.required'         => 'Ruangan password mesti diisi',
            'no_phone.required'             => 'Ruangan nombor telefon mesti diisi',
            'captcha.required'              => 'Ruangan CAPTCHA mesti diisi',
            'captcha.captcha'               => 'Kod sekuriti tidak sah',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);


        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            $where1 = array('user_id' => $app_id);
            $where2 = array('id' => $app_id2);
            $user                    = Users::where($where1)->first();
            $user_profile            = UserProfile::where($where2)->first();
            $user->user_email        = $request->input('user_email');
            $user_profile->no_phone  = $request->input('no_phone');

            auth()->user()->update([
                'password' => Hash::make($request->new_password)
            ]);
            $user->save();
            $user_profile->save();

            $data = [
                'ic' =>  preg_replace('/[^0-9]/', '', $request->no_kp),
                'password' =>  $request->new_password
            ];


            Session::flash('success', "Data berjaya dikemaskini!");
            Mail::to($request->user_email)->send(new UpdateProfileMail($data));
        }
    }
}
