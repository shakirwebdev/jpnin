<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Auth;
use DataTables;
use DB;
use Validator;
use Redirect, Response;
use Session;
use Hash;
use App\Mail\SendMail;
use App\User;
use App\UserRole;
use App\UserProfile;
use App\RefDaerah;
use App\KRT_Profile;

class RefKrtPPDController extends Controller
{
    public function index(Request $request){
        if($request->ajax())
        {
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
            }else if($type == 'get_krt') {
                $value = $request->value;
                $where = array('daerah_id' => $value);
                $data  = DB::table('krt__profile')
                        ->select('krt__profile.id', 'krt__profile.krt_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->where('ref__daerahs.daerah_id', '=',  $where)
                        ->where('krt__profile.krt_status', '=',  true)
                        ->get();
                return Response::json($data);
            }else if($type == 'get_srs') {
                $value = $request->value;
                $where = array('id' => $value);
                $data  = DB::table('srs__profile')
                        ->select('srs__profile.id', 'srs__profile.srs_name', 'krt__profile.krt_nama')
                        ->leftJoin('krt__profile','krt__profile.id','=','srs__profile.krt_id')
                        ->where('krt__profile.id', '=',  $where)
                        ->where('srs__profile.srs_status', '=',  true)
                        ->get();
                return Response::json($data);
            } else {
                // $data = DB::table('users')
                //     ->select('users.user_id',
                //     'krt__profile.krt_nama',
                //     'users__profile.user_fullname',
                //     'users__profile.no_ic',
                //     'users.user_email',
                //     'users.user_role',
                //     'users.created_at',
                //     'users.user_status',
                //     'ref__roles_users.short_description')
                //     ->join('users__profile','users__profile.user_id','=','users.user_id')
                //     ->join('ref__roles_users','ref__roles_users.id','=','users.user_role')
                //     ->join('krt__profile','krt__profile.id','=','users.krt_id')
                //     ->whereIn('users.user_role', [10,11,12])
                //     ->where('users.daerah_id', '=', Auth::user()->daerah_id)
                //     ->get();

                $data = DB::table('users')
                    ->select('users.user_id',
                            'krt__profile.krt_nama',
                            'users__profile.user_fullname',
                            'users__profile.no_ic',
                            'users.created_at',
                            'users.user_status',
                            DB::raw(" GROUP_CONCAT(ref__roles_users.short_description) AS role"))
                    ->leftjoin('users__profile','users__profile.user_id','=','users.user_id')
                    ->leftjoin('users__roles','users__roles.user_id','=','users.user_id')
                    ->leftjoin('ref__roles_users','ref__roles_users.id','=','users__roles.role_id')
                    ->leftjoin('krt__profile','krt__profile.id','=','users.krt_id')
                    ->whereIn('users__roles.role_id', [4,5,6])
                    ->where('users.daerah_id', '=', Auth::user()->daerah_id)
                    ->groupBy(['users.user_id', 'krt__profile.krt_nama', 'users__profile.user_fullname', 'users__profile.no_ic', 'users__profile.no_phone','users.user_email', 'users.created_at', 'users.user_status'])
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
            'select_peranan_ekrt_e'     => 'required',
            'select_negeri_ekrt_e'      => 'required',
            'select_daerah_ekrt_e'      => 'required',
            'select_daerah_ekrt_e'      => 'required',
            'name'                      => 'required',
            'phone'                     => 'required|numeric',
            'email'                     => 'required|email',
            'alamat'                    => 'required',
            );
        } else {
            $rules_main = array(
            'select_peranan_ekrt'       => 'required',
            'select_negeri_ekrt'        => 'required',
            'select_daerah_ekrt'        => 'required',
            'select_krt_ekrt'           => 'required',
            'password_1'                => 'min:6|required_with:password_2|same:password_2',
            'password_2'                => 'min:6',
            'name'                      => 'required',
            'ic'                        => 'required|min:11|unique:users__profile,no_ic',
            'phone'                     => 'required|numeric',
            'email'                     => 'required|email',
            'alamat'                    => 'required',
            );
        }
        
        $messages = [
            'select_peranan_ekrt.required'      => 'Ruangan peranan mesti dipilih',
            'select_negeri_ekrt.required'       => 'Ruangan negeri mesti dipilih',
            'select_daerah_ekrt.required'       => 'Ruangan daerah mesti dipilih',
            'select_krt_ekrt.required'          => 'Ruangan KRT mesti dipilih',
            'select_peranan_ekrt_e.required'    => 'Ruangan peranan mesti dipilih',
            'select_negeri_ekrt_e.required'     => 'Ruangan negeri mesti dipilih',
            'select_daerah_ekrt_e.required'     => 'Ruangan daerah mesti dipilih',
            'select_krt_ekrt_e.required'        => 'Ruangan KRT mesti dipilih',
            'password_1.required_with'          => 'Ruangan kata laluan mesti diisi',
            'password_1.same'                   => 'Kata laluan dimasukkan tidak sepadan dengan yang ditaip semula. Sahkan kemasukkan',
            'name.required'                     => 'Ruangan nama mesti diisi',
            'ic.required'                       => 'Ruangan no kad pengenalan mesti diisi',
            'ic.unique'                         => 'No kad pengenalan telah wujud dengan Sistem Maklumat Perpaduan.',
            'phone.required'                    => 'Ruangan no telefon mesti diisi',
            'email.required'                    => 'Ruangan email mesti diisi',
            'email.email'                       => 'Alamat email yang dimasukkan tidah sah',
            'alamat.required'                   => 'Ruangan alamat mesti diisi'
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {  
            if ($action == 'edit') {
                $where = array('user_id' => $app_id);
                
                $user = User::where($where)->first();
                $user->user_email       = $request->email;
                // $user->user_role        = $request->select_peranan_ekrt_e;
                $user->state_id         = $request->select_negeri_ekrt_e;
                $user->daerah_id        = $request->select_daerah_ekrt_e;
                $user->krt_id           = $request->select_krt_ekrt_e;
                $user->user_status      = $request->select_status_ekrt;
                $user->save();

                $userProfile = UserProfile::where($where)->first();
                $userProfile->user_fullname  = $request->name;
                $userProfile->no_phone       = $request->phone;
                $userProfile->state_id       = $request->select_negeri_ekrt_e;
                $userProfile->daerah_id      = $request->select_daerah_ekrt_e;
                $userProfile->krt_id         = $request->select_krt_ekrt_e;
                $userProfile->user_address   = $request->alamat;
                $userProfile->save();

                $user_role  = UserRole::where($where)->first();
                $user_role->role_id      = $request->select_peranan_ekrt_e;
                $user_role->status       = 1;
                $user_role->save();
                Session::flash('success', "Akaun [".$request->name."] telah berjaya dikemaskini!");

            } else {
                $user = new User;
                $user->no_ic            = preg_replace('/[^0-9]/', '', $request->ic);
                $user->user_email       = $request->email;
                // $user->user_role        = $request->select_peranan_ekrt;
                $user->password         = Hash::make($request->password_1);
                $user->state_id         = $request->select_negeri_ekrt;
                $user->daerah_id        = $request->select_daerah_ekrt;
                $user->krt_id           = $request->select_krt_ekrt;
                $user->user_status      = '1';

                $user->save();
                $last_user_id           = $user->user_id;

                $userProfile = new UserProfile;            
                $userProfile->user_id        = $last_user_id;
                $userProfile->user_fullname  = $request->name;
                $userProfile->no_ic          = preg_replace('/[^0-9]/', '', $request->ic);
                $userProfile->no_phone       = $request->phone;
                $userProfile->state_id       = $request->select_negeri_ekrt;
                $userProfile->daerah_id      = $request->select_daerah_ekrt; 
                $userProfile->krt_id         = $request->select_krt_ekrt; 
                $userProfile->user_address   = $request->alamat;             
                $userProfile->save();

                $user_role  = new UserRole;
                $user_role->user_id      = $last_user_id;
                $user_role->role_id      = $request->select_peranan_ekrt;
                $user_role->status       = 1;
                $user_role->save();

                

                $data = [
                    'ic' =>  preg_replace('/[^0-9]/', '', $request->ic),
                    'password' =>  $request->password_1
                ];

                Session::flash('success', "Akaun baru [".$request->name."] telah berjaya dicipta!");
                Mail::to($request->email)->send(new SendMail($data));
                return redirect()->route('pengurusan.pengguna');
                }         
            
        }
    }

    public function edit(Request $request, $id){
        $data = DB::table('users')
                    ->select('users.user_id',
                    'users__roles.role_id AS user_role',
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
                    ->leftjoin('users__roles','users__roles.user_id','=','users.user_id')
                    ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                    ->where('users.user_id', '=', $id)
                    ->first();
 
        return Response::json($data);
    }
}
