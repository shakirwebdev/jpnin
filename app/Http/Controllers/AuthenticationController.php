<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect, Response;
use Auth;
use Validator;
use Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

use Session;
use DB;
use App\User;
use App\Users;
use App\UserProfile;
use App\UserRole;
use App\RefStates;
use App\RefDaerah;
use App\Mail\SendMail;
use App\Mail\SendMailForgot;
use App\KRT_Ahli_Jawatan_Kuasa;

use Illuminate\Routing\Controller as BaseController;

class AuthenticationController extends BaseController
{
	function login()
	{
		return view('authentication.login');
	}
	function register(Request $request)
	{
		if ($request->ajax()) {
			$type = $request->type;
			if ($type == 'get_daerah') {
				$value = $request->value;
				$where = array('state_id' => $value);
				$data  = DB::table('ref__daerahs')
					->select('ref__daerahs.id', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description', 'ref__states.state_id', 'ref__states.state_description')
					->leftJoin('ref__states', 'ref__states.state_id', '=', 'ref__daerahs.state_id')
					->where('ref__states.state_id', '=',  $where)
					->get();
				return Response::json($data);
			} else if ($type == 'get_tabika') {
				$value = $request->value;
				$where = array('daerah_id' => $value);
				$data  = DB::table('tbk__profile')
					->select('tbk__profile.id', 'tbk__profile.daerah_id', 'tbk__profile.tbk_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
					->leftJoin('ref__daerahs', 'ref__daerahs.daerah_id', '=', 'tbk__profile.daerah_id')
					->where('ref__daerahs.daerah_id', '=',  $where)
					->get();
				return Response::json($data);
			}
		} else {
			$state      = RefStates::where('status', '=',  true)->get();

			return view('authentication.register', compact('state'));
		}
	}

	function lupakatalaluan(Request $request)
	{
		if ($request->ajax()) {
			$type = $request->type;
			if ($type == 'get_daerah') {
				$value = $request->value;
				$where = array('state_id' => $value);
				$data  = DB::table('ref__daerahs')
					->select('ref__daerahs.id', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description', 'ref__states.state_id', 'ref__states.state_description')
					->leftJoin('ref__states', 'ref__states.state_id', '=', 'ref__daerahs.state_id')
					->where('ref__states.state_id', '=',  $where)
					->get();
				return Response::json($data);
			} else if ($type == 'get_tabika') {
				$value = $request->value;
				$where = array('daerah_id' => $value);
				$data  = DB::table('tbk__profile')
					->select('tbk__profile.id', 'tbk__profile.daerah_id', 'tbk__profile.tbk_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
					->leftJoin('ref__daerahs', 'ref__daerahs.daerah_id', '=', 'tbk__profile.daerah_id')
					->where('ref__daerahs.daerah_id', '=',  $where)
					->get();
				return Response::json($data);
			}
		} else {
			$state      = RefStates::where('status', '=',  true)->get();

			return view('authentication.lupakatalaluan', compact('state'));
		}
	}

	function error404()
	{
		return view('authentication.error404');
	}
	function error500()
	{
		return view('authentication.error500');
	}
	public function doLogin()
	{
		$messages = [
			'ic.required' => 'Ruangan :attribute perlu diisi',
		];

		$rules = array(
			'ic' => 'required|min:12', // make sure the email is an actual email
		);

		$validator = Validator::make(Input::all(), $rules, $messages);

		if ($validator->fails()) {
			return back()->withErrors($validator)->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
		} else {
			$userdata = array(
				'no_ic' => Input::get('ic'),
				'password'  => Input::get('password'),
				'user_status'  => 1
			);
			if (Input::get('txtaction') == '') {
				if (Auth::attempt($userdata)) {
					$messages = [
						'password.regex:' => 'error2',
					];
					$rulespassword = [
						//'password' => 'required|min:12', // password can only be alphanumeric and has to be greater than 3 characters
						//'password' => 'required',
						//'password' => 'min:12'
						'password' => [
							'string',
							'min:1',             // must be at least 10 characters in length
							'regex:/[a-z]/',      // must contain at least one lowercase letter
							'regex:/[A-Z]/',      // must contain at least one uppercase letter
							'regex:/[0-9]/',      // must contain at least one digit
							'regex:/[@$!%*#?&]/', // must contain a special character
						],
					];
					$validator = Validator::make($userdata, $rulespassword, $messages);
					if ($validator->fails()) {
						return Redirect::to('secure/login')
							->withErrors($validator) // send back all errors to the login form
							->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
					} else {
						return Redirect::to('dashboard/index');
					}
				} else {
					Session::flash('error', "No Kad Pengenalan atau Kata Laluan tidak sah!");
					return Redirect::to('secure/login')
						->withErrors($validator)
						->withInput(Input::except('password'));
				}
			} else {
				$messages = [
					'password2.min'				=> 'Kata laluan hendaklah minima 12 character',
					//'password3.required_with'  	=> 'Ruangan pengesahan kata laluan mesti diisi',
					'password3.same'           	=> 'Kata laluan dimasukkan tidak sepadan dengan pengesahan kata laluan. Sila masukkan semula kata laluan',
					'captcha.required'   		=> 'Ruangan CAPTCHA mesti diisi',
					'captcha.captcha'    		=> 'Kod sekuriti tidak sah',
				];
				$rules = [
					'password2' => 'min:12',
					'password2' => 'regex:/[a-z]/',      // must contain at least one lowercase letter
					'password2' => 'regex:/[A-Z]/',      // must contain at least one uppercase letter
					'password2' => 'regex:/[0-9]/',      // must contain at least one digit
					'password2' => 'regex:/[@$!%*#?&]/', // must contain a special character
					'password3' => 'same:password2',
					'captcha'    => 'required|captcha',
				];

				$validator = Validator::make(Input::all(), $rules, $messages);

				if ($validator->fails()) {
					return back()
						->withErrors($validator)
						->withInput(Input::all()); // send back the input (not the password) so that we can repopulate the form
				} else {

					Auth::attempt($userdata);

					$user_data = DB::table('users')
						->select('user_id', 'user_email')
						->where('no_ic', '=', Input::get('ic'))
						->limit(1)
						->first();

					$values = array('password' => Hash::make(Input::get('password2')), 'updated_at' => date('Y-m-d H:i:s'));
					User::where('user_id', '=', $user_data->user_id)
						->update($values);

					$userdata = array(
						'no_ic' => Input::get('ic'),
						'password'  => Input::get('password2'),
						'user_status'  => 1
					);
					//Auth::attempt($userdata);

					$data = [
						'ic' =>  preg_replace('/[^0-9]/', '', Input::get('ic')),
						'password' =>  Input::get('password2')
					];

					//Mail::to($user_data->user_email)->send(new SendMailForgot($data));

					Session::flash('success', "Kata laluan telah berjaya dikemaskini!");
					return back();
				}
			}
		}
	}

	public function doRegister(Request $request)
	{
		$action = $request->action_register;
		$urole = $request->jenis_pengguna;
		if ($action == 'add') {
			$rules_main = array(
				// 'username'   => 'required|alpha_num|unique:users,user_name',
				'email'      => 'required|email',
				'password_1' => 'min:6|required_with:password_2|same:password_2',
				'password_2' => 'min:6',
				'name'       => 'required',
				'ic'         => 'required|min:11|unique:users__profile,no_ic',
				'phone'      => 'required|numeric',
				'captcha'    => 'required|captcha',
			);
			if ($urole == '2') {
				$rules_submain = array(
					'state'    => 'required',
					'daerah'   => 'required',
					'tabika'   => 'required',
				);
			} else {
				$rules_submain = array();
			}
		}

		if ($action == 'lupa') {
			$rules_main = array(
				// 'username'   => 'required|alpha_num|unique:users,user_name',
				'email'      => 'required|email',
				'ic'         => 'required|min:11',
			);
		}

		if ($action == 'add') {
			$messages = [
				// 'username.required'          => 'Ruangan kata nama mesti diisi',
				// 'username.alpha_num'         => 'Kata nama hanya huruf dan nombor sahaja dibenarkan. Tanda space tidak dibenarkan',
				// 'username.unique'            => 'Kata nama yang dimasukkan telah wujud di dalam pangkalan data. Sila pilih kata nama lain',
				'email.required'             => 'Ruangan email mesti diisi',
				'email.email'                => 'Alamat email yang dimasukkan tidah sah',
				'password_1.required_with'   => 'Ruangan kata laluan mesti diisi',
				'password_1.same'            => 'Kata laluan dimasukkan tidak sepadan dengan yang ditaip semula. Sahkan kemasukkan',
				'name.required'              => 'Ruangan nama mesti diisi',
				'ic.required'                => 'Ruangan no kad pengenalan mesti diisi',
				'ic.unique'                  => 'No kad pengenalan telah wujud dengan Sistem Maklumat Perpaduan. Gunakan laman Terlupa Katalaluan untuk mendapatkan kembali akaun anda',
				'phone.required'             => 'Ruangan no telefon mesti diisi',
				'state.required'             => 'Ruangan Negeri mesti dipilih',
				'daerah.required'            => 'Ruangan Daerah / Bahagian mesti dipilih',
				'tabika.required'            => 'Ruangan Nama Tabika Perpaduan mesti dipilih',
				'captcha.required'           => 'Ruangan CAPTCHA mesti diisi',
				'captcha.captcha'            => 'Kod sekuriti tidak sah',
			];

			$rules = $rules_main + $rules_submain;
		}

		if ($action == 'lupa') {
			$messages = [
				'email.required'             => 'Ruangan email mesti diisi',
				'ic.required'                => 'Ruangan no kad pengenalan mesti diisi',
			];

			$rules = $rules_main;
		}
		$validator = Validator::make(Input::all(), $rules, $messages);

		if ($validator->fails()) {
			return \Response::json(array('errors' => $validator->errors()->toArray()));
		} else {
			if ($action == 'add') {
				if ($urole == '3') {
					$user = new User;
					$user->no_ic            = preg_replace('/[^0-9]/', '', $request->ic);
					$user->user_email       = $request->email;
					$user->user_role        = '2';
					$user->password         = Hash::make($request->password_1);
					$user->user_status      = '1';

					$user->save();
					$last_user_id           = $user->user_id;

					$userPhone = new UserProfile;
					$userPhone->user_id        = $last_user_id;
					$userPhone->user_fullname  = $request->name;
					$userPhone->no_ic          = preg_replace('/[^0-9]/', '', $request->ic);
					$userPhone->no_phone       = $request->phone;
					$userPhone->save();

					$userRole = new UserRole;
					$userRole->user_id  = $last_user_id;
					$userRole->role_id  = $urole;
					$userRole->status   = '1';
					$userRole->save();
					$data = [
						'ic' =>  preg_replace('/[^0-9]/', '', $request->ic),
						'password' =>  $request->password_1
					];

					dd($data);
					Session::flash('success', "Akaun baru telah berjaya dicipta, sila log masuk menggunakan maklumat yang telah didaftarkan!");
					Mail::to($request->email)->send(new SendMail($data));
					// return Redirect::to('secure/register');
					// return redirect()->route('authentication.login')->with('success','Akaun baru telah berjaya dicipta, sila log masuk menggunakan maklumat yang telah didaftarkan!');

				} else if ($urole == '2') {
					$user = new User;
					$user->no_ic            = preg_replace('/[^0-9]/', '', $request->ic);
					$user->user_email       = $request->email;
					$user->user_role        = '25';
					$user->password         = Hash::make($request->password_1);
					$user->user_status      = '1';

					$user->save();
					$last_user_id           = $user->user_id;

					$userPhone = new UserProfile;
					$userPhone->user_id        = $last_user_id;
					$userPhone->user_fullname  = $request->name;
					$userPhone->no_ic          = preg_replace('/[^0-9]/', '', $request->ic);
					$userPhone->no_phone       = $request->phone;
					$userPhone->save();

					$data = [
						'ic' =>  preg_replace('/[^0-9]/', '', $request->ic),
						'password' =>  $request->password_1
					];

					Session::flash('success', "Akaun baru telah berjaya dicipta, sila log masuk menggunakan maklumat yang telah didaftarkan!");
					Mail::to($request->email)->send(new SendMail($data));
					// return \Response::json(array('errors' => $validator->errors()->toArray()));
					// return Redirect::to('secure/register');
					// return redirect()->route('secure/login')->with('success','Akaun baru telah berjaya dicipta, sila log masuk menggunakan maklumat yang telah didaftarkan!');
				} else {
					$user = new User;
					$user->no_ic            = preg_replace('/[^0-9]/', '', $request->ic);
					$user->user_email       = $request->email;
					$user->user_role        = '26';
					$user->password         = Hash::make($request->password_1);
					$user->state_id         = $request->state;
					$user->daerah_id        = $request->daerah;
					$user->tabika_id        = $request->tabika;
					$user->user_status      = '1';

					$user->save();
					$last_user_id           = $user->user_id;

					$userPhone = new UserProfile;
					$userPhone->user_id        = $last_user_id;
					$userPhone->user_fullname  = $request->name;
					$userPhone->no_ic          = preg_replace('/[^0-9]/', '', $request->ic);
					$userPhone->no_phone       = $request->phone;
					$userPhone->state_id            = $request->state;
					$userPhone->daerah_id           = $request->daerah;
					$userPhone->tabika_id           = $request->tabika;
					$userPhone->save();

					$data = [
						'ic' =>  preg_replace('/[^0-9]/', '', $request->ic),
						'password' =>  $request->password_1
					];

					Session::flash('success', "Akaun baru telah berjaya dicipta, sila log masuk menggunakan maklumat yang telah didaftarkan!");
					Mail::to($request->email)->send(new SendMail($data));
					// return \Response::json(array('errors' => $validator->errors()->toArray()));
					// return Redirect::to('secure/register');
					// return redirect()->route('secure/login')->with('success','Akaun baru telah berjaya dicipta, sila log masuk menggunakan maklumat yang telah didaftarkan!');
				}
			}

			if ($action == 'lupa') {
				$count2 = DB::table('users')
					->where('no_ic', '=', $request->ic)
					->where('user_email', '=', $request->email)
					->count();

				$data = [
					'ic' =>  preg_replace('/[^0-9]/', '', $request->ic),
					'password' =>  "testing"
				];

				/*KRT_Kewangan_Penyata::where('id', $request->mag_id)
      				->update($values);*/
				if ($count2 > 0) {
					$values = array('password' => Hash::make("testing"), 'updated_at' => date('Y-m-d H:i:s'));
					User::where('no_ic', '=', $request->ic)
						->update($values);

					Session::flash('success', "Katalaluan baru telah berjaya dihantar, sila semak email yang telah didaftarkan!");
					Mail::to($request->email)->send(new SendMailForgot($data));
				} else {
					Session::flash('success', "Katalaluan baru tidak berjaya dihantar, sila semak no kad pengenalan atau alamat email yang dimasukkan!");
				}
			}
		}
	}

	public function refreshCaptcha()
	{
		return captcha_img('default');
	}

	public function doLogout()
	{
		Auth::logout();
		return Redirect::to('/');
	}

	public function errorCode($errorCode)
	{
		try {
			// System Error Codes
			if ($errorCode == 0001) {
				return "System Error. Please Contact Administrator!";
			} else if ($errorCode == 1001) {
				return "Validation Error";
			} else if ($errorCode == 1002) {
				return "Post Method Error";
			} else if ($errorCode == 1003) {
				return "Unauthorized";
			} else if ($errorCode == 1004) {
				return "Token Mismatch";
			} else if ($errorCode == 1005) {
				return "LDAP Error. Please Contact Administrator!";
			} else if ($errorCode == 1003) {
				return "Unauthorized";
			} else if ($errorCode == 1004) {
				return "Token Mismatch";
			}
		} catch (\Exception $e) {
		}
	}

	function email_register()
	{
		return view('email.email_registration');
	}

	function ajk_krt(Request $request, $id)
	{
		if ($request->ajax()) {
			$type = $request->type;
			if ($type == 'get_daerah') {
				$value = $request->value;
				$where = array('state_id' => $value);
				$data  = DB::table('ref__daerahs')
					->select('ref__daerahs.id', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description', 'ref__states.state_id', 'ref__states.state_description')
					->leftJoin('ref__states', 'ref__states.state_id', '=', 'ref__daerahs.state_id')
					->where('ref__states.state_id', '=',  $where)
					->get();
				return Response::json($data);
			}
		} else {
			$krt_ajk            = KRT_Ahli_Jawatan_Kuasa::where('ajk_status_form', '=', 1)
				->select(
					'krt__ahli_jawatan_kuasa.id',
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
					'krt__ahli_jawatan_kuasa.ajk_status_form AS ajk_status_form',
					'krt__ahli_jawatan_kuasa.ajk_bekepentingan AS ajk_bekepentingan',
					'krt__ahli_jawatan_kuasa.ajk_bekepentingan_interaksi_1 AS ajk_bekepentingan_interaksi_1',
					'krt__ahli_jawatan_kuasa.ajk_bekepentingan_interaksi_2 AS ajk_bekepentingan_interaksi_2',
					'krt__ahli_jawatan_kuasa.ajk_bekepentingan_interaksi_3 AS ajk_bekepentingan_interaksi_3',
					'krt__ahli_jawatan_kuasa.ajk_bekepentingan_interaksi_4 AS ajk_bekepentingan_interaksi_4',
					'krt__ahli_jawatan_kuasa.ajk_bekepentingan_interaksi_5 AS ajk_bekepentingan_interaksi_5',
					'krt__ahli_jawatan_kuasa.ajk_berkepentingan_keterangan AS ajk_berkepentingan_keterangan',
					'krt__ahli_jawatan_kuasa.file_avatar AS file_avatar'
				)
				->leftJoin('krt__profile', 'krt__profile.id', '=', 'krt__ahli_jawatan_kuasa.krt_profile_id')
				->leftJoin('ref__states', 'ref__states.state_id', '=', 'krt__profile.state_id')
				->leftJoin('ref__parlimens', 'ref__parlimens.parlimen_id', '=', 'krt__profile.parlimen_id')
				->leftJoin('ref__pbts', 'ref__pbts.pbt_id', '=', 'krt__profile.pbt_id')
				->leftJoin('ref__daerahs', 'ref__daerahs.daerah_id', '=', 'krt__profile.daerah_id')
				->leftJoin('ref__duns', 'ref__duns.dun_id', '=', 'krt__profile.dun_id')
				->leftJoin('ref__status_krt_ajk', 'ref__status_krt_ajk.id', '=', 'krt__ahli_jawatan_kuasa.ajk_status_form')
				->leftJoin('ref__jawatan_ajk_krt', 'ref__jawatan_ajk_krt.id', '=', 'krt__ahli_jawatan_kuasa.ajk_jawatan_krt_id')
				->where('krt__ahli_jawatan_kuasa.id', '=', $id)
				->limit(1)
				->first();
			$state      = RefStates::where('status', '=',  true)->get();
			return view('authentication.ajk_krt', compact('state'));
		}
	}
}
