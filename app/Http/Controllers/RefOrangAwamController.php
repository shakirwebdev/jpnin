<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DataTables;
use DB;
use Validator;
use Redirect, Response;
use Session;
use Hash;
use App\User;
use App\UserProfile;
use App\RefDaerah;
use App\KRT_Profile;

class RefOrangAwamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
                        ->where('krt__profile.krt_status', '=',  true)
                        ->get();
                return Response::json($data);
            } else {
                $data = DB::table('users')
                    ->select('users.user_id',
                    'users__profile.user_fullname',
                    'users__profile.no_ic',
                    'users__profile.no_phone',
                    'ref__roles_users.short_description',
                    'users.created_at',
                    'users.user_status')
                    ->join('users__profile','users__profile.user_id','=','users.user_id')
                    ->join('ref__roles_users','ref__roles_users.id','=','users.user_role')
                    ->where('users.user_role', '=', '2')
                    ->where('users.user_status', '=', true)
                    ->get();

                return Datatables::of($data)
                        ->make(true);
            }
        }
    }

    public function edit(Request $request, $id){
        $data = DB::table('users')
                    ->select('users.user_id',
                    'users.user_email',
                    'users.user_role',
                    'users__profile.user_fullname',
                    'users__profile.no_ic',
                    'users__profile.no_phone',
                    'users__profile.state_id',
                    'users__profile.daerah_id')
                    ->join('users__profile','users__profile.user_id','=','users.user_id')
                    ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                    ->where('users.user_id', '=', $id)
                    ->first();
 
        return Response::json($data);
    }

    public function store(Request $request){
        $action = $request->action_orang_awam;
        $app_id = $request->user_profile_id;
        $urole = $request->select_peranan_orang_awam;
        $rules_main = array(
            'select_peranan_orang_awam'             => 'required',
            'select_negeri_orang_awam'              => 'required',
            'select_daerah_orang_awam'              => 'required',
            'select_krt_orang_awam'                 => 'required',
            'password_1_orang_awam'                 => 'min:6|required_with:password_2_orang_awam|same:password_2_orang_awam',
            'password_2_orang_awam'                 => 'min:6',
            'name_orang_awam'                       => 'required',  
            'ic_orang_awam'                         => 'required|min:11', 
            'phone_orang_awam'                      => 'required|numeric',
            'email_orang_awam'                      => 'required|email',
            'alamat_orang_awam'                     => 'required',
        );
        $messages = [
            'select_peranan_orang_awam.required'    => 'Ruangan peranan mesti dipilih',
            'select_negeri_orang_awam.required'     => 'Ruangan negeri mesti dipilih',
            'select_daerah_orang_awam.required'     => 'Ruangan daerah mesti dipilih',
            'select_krt_orang_awam.required'        => 'Ruangan KRT mesti dipilih',
            'password_1_orang_awam.required_with'   => 'Ruangan kata laluan mesti diisi',
            'password_1_orang_awam.same'            => 'Kata laluan dimasukkan tidak sepadan dengan yang ditaip semula. Sahkan kemasukkan',
            'name_orang_awam.required'              => 'Ruangan Nama Penuh mesti diisi',
            'ic_orang_awam.required'                => 'Ruangan No Kad Pengenalan mesti diisi',
            'phone_orang_awam.required'             => 'Ruangan No Telefon mesti diisi',
            'email_orang_awam.required'             => 'Ruangan email mesti diisi',
            'email_orang_awam.email'                => 'Alamat email yang dimasukkan tidah sah',
            'alamat_orang_awam.required'            => 'Ruangan alamat mesti diisi',
            
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {
            if ($action == 'edit') {
                $where = array('user_id' => $app_id);
                
                $user = User::where($where)->first();
                $user->user_email       = $request->email_orang_awam;
                $user->user_role        = $request->select_peranan_orang_awam;
                $user->password         = Hash::make($request->password_1_orang_awam);
                $user->state_id         = $request->select_negeri_orang_awam;
                $user->daerah_id        = $request->select_daerah_orang_awam;
                $user->krt_id           = $request->select_krt_orang_awam;
                $user->save();

                $userProfile = UserProfile::where($where)->first();
                $userProfile->no_phone       = $request->phone_orang_awam;
                $userProfile->user_address   = $request->alamat_orang_awam;
                $userProfile->state_id       = $request->select_negeri_orang_awam;
                $userProfile->daerah_id      = $request->select_daerah_orang_awam;
                $userProfile->krt_id         = $request->select_krt_orang_awam; 
                $userProfile->save();
            }
            
        }
    }
}
