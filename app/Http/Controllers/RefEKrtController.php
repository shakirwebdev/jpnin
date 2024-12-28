<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use DataTables;
use DB;
use Validator;
use Redirect, Response;
use Session;
use Hash;
use App\Mail\SendMail;
use App\User;
use App\UserProfile;
use App\RefDaerah;
use App\KRT_Profile;

class RefEKrtController extends Controller
{
    public function index(Request $request){
        if($request->ajax())
        {
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
                        ->where('krt_status','=', true)
                        ->get();
                return Response::json($data);
            } else {
                $data = DB::table('users')
                    ->select('users.user_id',
                    'users__profile.user_fullname',
                    'users__profile.no_ic',
                    'users__profile.no_phone',
                    'users.user_email',
                    'users.user_role',
                    'users.created_at',
                    'users.user_status',
                    'ref__roles_users.short_description')
                    ->join('users__profile','users__profile.user_id','=','users.user_id')
                    ->join('ref__roles_users','ref__roles_users.id','=','users.user_role')
                    ->whereIn('users.user_role', [10,11,12])
                    ->get();

                return Datatables::of($data)
                        ->make(true);
            }
        }
    }

    public function store(Request $request) {
        $action = $request->action_krt;
        $app_id = $request->user_profile_id;
        $urole = $request->select_peranan_ekrt;
        if ($action == 'edit') {
            $rules_main = array(                
            'select_peranan_ekrt_edit'      => 'required',
            'select_negeri_ekrt_edit'       => 'required',
            'select_daerah_ekrt_edit'       => 'required',
            'select_krt_ekrt_edit'          => 'required',
            'password_1_ekrt_edit'          => 'min:6|required_with:password_2_ekrt_edit|same:password_2_ekrt_edit',
            'password_2_ekrt_edit'          => 'min:6',
            'name_ekrt_edit'                => 'required',
            'phone_ekrt_edit'               => 'required|numeric',
            'email_ekrt_edit'               => 'required|email',
            'alamat_ekrt_edit'              => 'required',
            );
        } else {
            $rules_main = array(
            'select_peranan_ekrt'                   => 'required',
            'select_negeri_ekrt'                    => 'required',
            'select_daerah_ekrt'                    => 'required',
            'select_krt_ekrt'                       => 'required',
            'password_1_ekrt'                       => 'min:6|required_with:password_2_ekrt|same:password_2_ekrt',
            'password_2_ekrt'                       => 'min:6',
            'name_ekrt'                             => 'required',
            'ic_ekrt'                               => 'required|min:11|unique:users__profile,no_ic',
            'phone_ekrt'                            => 'required|numeric',
            'email_ekrt'                            => 'required|email',
            'alamat_ekrt'                           => 'required',
            );
        }
        
        $messages = [
            'select_peranan_ekrt.required'          => 'Ruangan peranan mesti dipilih',
            'select_negeri_ekrt.required'           => 'Ruangan negeri mesti dipilih',
            'select_daerah_ekrt.required'           => 'Ruangan daerah mesti dipilih',
            'select_krt_ekrt.required'              => 'Ruangan KRT mesti dipilih',
            'username_ekrt.required'                => 'Ruangan kata nama mesti diisi',
            'username_ekrt.alpha_num'               => 'Kata nama hanya huruf dan nombor sahaja dibenarkan. Tanda space tidak dibenarkan',
            'username_ekrt.unique'                  => 'Kata nama yang dimasukkan telah wujud di dalam pangkalan data. Sila pilih kata nama lain',
            'password_1_ekrt.required_with'         => 'Ruangan kata laluan mesti diisi',
            'password_1_ekrt.same'                  => 'Kata laluan dimasukkan tidak sepadan dengan yang ditaip semula. Sahkan kemasukkan',
            'name_ekrt.required'                    => 'Ruangan nama mesti diisi',
            'ic_ekrt.required'                      => 'Ruangan no kad pengenalan mesti diisi',
            'ic_ekrt.unique'                        => 'No kad pengenalan telah wujud dengan Sistem Maklumat Perpaduan.',
            'phone_ekrt.required'                   => 'Ruangan no telefon mesti diisi',
            'email_ekrt.required'                   => 'Ruangan email mesti diisi',
            'email_ekrt.email'                      => 'Alamat email yang dimasukkan tidah sah',
            'alamat_ekrt.required'                  => 'Ruangan alamat mesti diisi',
            
            'select_peranan_ekrt_edit.required'     => 'Ruangan peranan mesti dipilih',
            'select_negeri_ekrt_edit.required'      => 'Ruangan negeri mesti dipilih',
            'select_daerah_ekrt_edit.required'      => 'Ruangan daerah mesti dipilih',
            'select_krt_ekrt_edit.required'         => 'Ruangan KRT mesti dipilih',
            'password_1_ekrt_edit.required_with'    => 'Ruangan kata laluan mesti diisi',
            'password_1_ekrt_edit.same'             => 'Kata laluan dimasukkan tidak sepadan dengan yang ditaip semula. Sahkan kemasukkan',
            'name_ekrt_edit.required'               => 'Ruangan nama mesti diisi',
            'phone_ekrt_edit.required'              => 'Ruangan no telefon mesti diisi',
            'email_ekrt_edit.required'              => 'Ruangan email mesti diisi',
            'email_ekrt_edit.email'                 => 'Alamat email yang dimasukkan tidah sah',
            'alamat_ekrt_edit.required'             => 'Ruangan alamat mesti diisi',
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {  
            if ($action == 'edit') {
                $where = array('user_id' => $app_id);
                
                $user = User::where($where)->first();
                $user->user_email           = $request->email_ekrt_edit;
                $user->user_role            = $request->select_peranan_ekrt_edit;
                $user->password             = Hash::make($request->password_1_ekrt_edit);
                $user->state_id             = $request->select_negeri_ekrt_edit;
                $user->daerah_id            = $request->select_daerah_ekrt_edit;
                $user->krt_id               = $request->select_krt_ekrt_edit;
                $user->user_status          = $request->select_status_ekrt;
                $user->save();

                $userProfile = UserProfile::where($where)->first();
                $userProfile->user_fullname = $request->name_ekrt_edit;
                $userProfile->no_phone      = $request->phone_ekrt_edit;
                $userProfile->state_id      = $request->select_negeri_ekrt_edit;
                $userProfile->daerah_id     = $request->select_daerah_ekrt_edit;
                $userProfile->krt_id        = $request->select_krt_ekrt_edit;
                $userProfile->user_address  = $request->alamat_ekrt_edit;
                $userProfile->save();
                Session::flash('success', "Akaun [".$request->name_ekrt_edit."] telah berjaya dikemaskini!");

            } else {
                $user = new User;
                $user->no_ic                = preg_replace('/[^0-9]/', '', $request->ic_ekrt);
                $user->user_email           = $request->email_ekrt;
                $user->user_role            = $request->select_peranan_ekrt;
                $user->password             = Hash::make($request->password_1_ekrt);
                $user->state_id             = $request->select_negeri_ekrt;
                $user->daerah_id            = $request->select_daerah_ekrt;
                $user->krt_id               = $request->select_krt_ekrt;
                $user->user_status          = '1';

                $user->save();
                $last_user_id               = $user->user_id;

                $userProfile = new UserProfile;            
                $userProfile->user_id       = $last_user_id;
                $userProfile->user_fullname = $request->name_ekrt;
                $userProfile->no_ic         = preg_replace('/[^0-9]/', '', $request->ic_ekrt);
                $userProfile->no_phone      = $request->phone_ekrt;
                $userProfile->state_id      = $request->select_negeri_ekrt;
                $userProfile->daerah_id     = $request->select_daerah_ekrt; 
                $userProfile->krt_id        = $request->select_krt_ekrt; 
                $userProfile->user_address  = $request->alamat_ekrt;             

                $userProfile->save();

                $data = [
                    'ic' =>  preg_replace('/[^0-9]/', '', $request->ic_ekrt),
                    'password' =>  $request->password_1_ekrt
                ];

                Session::flash('success', "Akaun baru [".$request->username_ekrt."] telah berjaya dicipta!");
                Mail::to($request->email_ekrt)->send(new SendMail($data));
                return redirect()->route('pengurusan.pengguna');
                }         
            
        }
    }

    public function edit(Request $request, $id){
        $data = DB::table('users')
                    ->select('users.user_id',
                    'users.user_role',
                    'users__profile.state_id',
                    'users__profile.daerah_id',
                    'users__profile.krt_id',
                    'users__profile.user_fullname',
                    'users__profile.no_ic',
                    'users__profile.no_phone',
                    'users.user_email',
                    'users__profile.user_address',
                    'users.user_status')
                    ->join('users__profile','users__profile.user_id','=','users.user_id')
                    ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                    ->where('users.user_id', '=', $id)
                    ->first();
 
        return Response::json($data);
    }
}
