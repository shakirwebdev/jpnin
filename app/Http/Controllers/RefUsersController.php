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
use App\UserRole;
use App\UserProfile;
use App\RefDaerah;

class RefUsersController extends Controller
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
                $data  = DB::table('krt__profile')
                        ->select('krt__profile.id', 'krt__profile.krt_nama', 'ref__daerahs.daerah_id', 'ref__daerahs.daerah_description')
                        ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','krt__profile.daerah_id')
                        ->where('ref__daerahs.daerah_id', '=',  $where)
                        ->where('krt__profile.krt_status', '=',  true)
                        ->get();
                return Response::json($data);
            } else {
                $data = DB::table('users')
                        ->select('users.user_id',
                                'users__profile.user_fullname',
                                'users__profile.no_ic',
                                'users__profile.no_phone',
                                'users.user_email',
                                'users.created_at',
                                'users.user_status',
                                DB::raw(" GROUP_CONCAT(ref__roles_users.short_description) AS role"))
                        ->leftjoin('users__profile','users__profile.user_id','=','users.user_id')
                        ->leftjoin('users__roles','users__roles.user_id','=','users.user_id')
                        ->leftjoin('ref__roles_users','ref__roles_users.id','=','users__roles.role_id')
                        ->groupBy(['users.user_id', 'users__profile.user_fullname', 'users__profile.no_ic', 'users__profile.no_phone','users.user_email', 'users.created_at', 'users.user_status'])
                        ->get();
                return Datatables::of($data)
                        ->make(true);
            }
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request){
        $action = $request->action_jpnin;
        $urole  = $request->select_peranan_jpnin;
        $urole_edit  = $request->select_edit_peranan_jpnin;
        // dd($urole);
        $app_id = $request->user_profile_id;
        if ($action == 'edit') {
            $rules_edit_main = array(
                // 'select_edit_peranan_jpnin' => 'required',
                'edit_password_1'           => 'min:6|required_with:edit_password_2|same:edit_password_2',
                'edit_password_2'           => 'min:6',     
                'edit_name'                 => 'required', 
                'edit_phone'                => 'required|numeric',  
                'edit_email'                => 'required|email',
            );
            if($urole == '3'){
                $rules_edit_1 = array(            
                    'select_edit_negeri_jpnin'   => 'required',
                    'select_edit_daerah_jpnin'   => 'required',
                );
            } else if ($urole == '4') {
                $rules_edit_1 = array(
                    'select_edit_negeri_jpnin'   => 'required',
                );
            } else {
                $rules_edit_1 = array(
                    
                );
            }
        }else {
            $rules_edit_main = array(
                // 'select_peranan_jpnin[]'  => 'required',
                'password_1'            => 'min:6|required_with:password_2|same:password_2',
                'password_2'            => 'min:6',     
                'name'                  => 'required', 
                'ic'                    => 'required|min:11|unique:users__profile,no_ic', 
                'phone'                 => 'required|numeric', 
                'email'                 => 'required|email'
            );
            if($urole == '3'){
                $rules_edit_1 = array(            
                    'select_negeri_jpnin'   => 'required',
                    'select_daerah_jpnin'   => 'required',
                );
            } else if ($urole == '4') {
                $rules_edit_1 = array(
                    'select_negeri_jpnin'   => 'required',
                );
            } else {
                $rules_edit_1 = array(
                    
                );
            }
        }
        
        $messages = [
            // 'select_peranan_jpnin.required'         => 'Ruangan peranan mesti dipilih',
            'select_negeri_jpnin.required'          => 'Ruangan negeri mesti dipilih',
            'select_daerah_jpnin.required'          => 'Ruangan daerah mesti dipilih',
            'name.required'                         => 'Ruangan nama mesti diisi',
            'ic.required'                           => 'Ruangan no kad pengenalan mesti diisi',
            'ic.unique'                             => 'No kad pengenalan telah wujud di dalam pangkalan data.',
            'phone.required'                        => 'Ruangan no telefon mesti diisi',
            'email.required'                        => 'Ruangan email mesti diisi',
            'email.email'                           => 'Alamat email yang dimasukkan tidah sah',
            'password_1.required_with'              => 'Ruangan kata laluan mesti diisi',
            'password_1.same'                       => 'Kata laluan dimasukkan tidak sepadan dengan yang ditaip semula. Sahkan kemasukkan',
            
            // 'select_edit_peranan_jpnin.required'    => 'Ruangan peranan mesti dipilih',
            'edit_password_1.required_with'         => 'Ruangan kata laluan mesti diisi',
            'edit_password_1.same'                  => 'Kata laluan dimasukkan tidak sepadan dengan yang ditaip semula. Sahkan kemasukkan',
            'edit_name.required'                    => 'Ruangan nama mesti diisi',
            'edit_ic.required'                      => 'Ruangan no kad pengenalan mesti diisi',
            'edit_phone.required'                   => 'Ruangan no telefon mesti diisi',
            'edit_email.required'                   => 'Ruangan email mesti diisi',
            'edit_email.email'                      => 'Alamat email yang dimasukkan tidah sah',
        ];
        
        $rules = $rules_edit_main + $rules_edit_1;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else { 
            if ($action == 'edit') {
                $where = array('user_id' => $app_id);
                
                $user = User::where($where)->first();
                $user->no_ic            = preg_replace('/[^0-9]/', '', $request->edit_ic);
                $user->user_email       = $request->edit_email;
                $user->password         = Hash::make($request->edit_password_1);
                $user->state_id         = $request->select_edit_negeri_jpnin;
                $user->daerah_id        = $request->select_edit_daerah_jpnin;
                $user->krt_id           = $request->select_edit_krt_jpnin;
                $user->user_status      = $request->select_status_ekrt_jpnin;
                $user->save();

                $userProfile = UserProfile::where($where)->first();
                $userProfile->user_fullname  = $request->edit_name;
                $userProfile->no_ic          = preg_replace('/[^0-9]/', '', $request->edit_ic);
                $userProfile->no_phone       = $request->edit_phone;
                $userProfile->state_id       = $request->select_edit_negeri_jpnin;
                $userProfile->daerah_id      = $request->select_edit_daerah_jpnin;
                $userProfile->krt_id         = $request->select_edit_krt_jpnin;
                $userProfile->save();

                $data = DB::table('users__roles')->where('user_id', '=', $where)->delete();

                foreach($urole_edit as $value){
                    $user_role  = new UserRole; 
                    $user_role->user_id      = $app_id;
                    $user_role->role_id      = $value;
                    $user_role->status       = 1;
                    $user_role->save();
                }
                

                Session::flash('success', "Akaun [".$request->username."] telah berjaya dikemaskini!");

            }else if ($action == 'reset_pass') {
                $where = array('user_id' => $app_id);
                
                $user = User::where($where)->first();
                $user->password         = Hash::make('Ptm4381*');
                $user->save();

                
                Session::flash('success', "Akaun [".$request->username."] telah berjaya dikemaskini!");

            } else {     
                $user = new User;
                $user->no_ic            = preg_replace('/[^0-9]/', '', $request->ic);
                $user->user_email       = $request->email;
                $user->password         = Hash::make($request->password_1);
                $user->state_id         = $request->select_negeri_jpnin;
                $user->daerah_id        = $request->select_daerah_jpnin;
                $user->krt_id           = $request->select_krt_jpnin;
                $user->user_status      = '1';
                $user->save();
                $last_user_id           = $user->user_id;

                $userProfile = new UserProfile;            
                $userProfile->user_id        = $last_user_id;
                $userProfile->user_fullname  = $request->name;
                $userProfile->no_ic          = preg_replace('/[^0-9]/', '', $request->ic);
                $userProfile->no_phone       = $request->phone;
                $userProfile->state_id       = $request->select_negeri_jpnin;
                $userProfile->daerah_id      = $request->select_daerah_jpnin; 
                $userProfile->krt_id         = $request->select_krt_jpnin;           
                $userProfile->save();

                foreach($urole as $value){
                    $user_role  = new UserRole; 
                    $user_role->user_id      = $last_user_id;
                    $user_role->role_id      = $value;
                    $user_role->status       = 1;
                    $user_role->save();
                }

                $data = [
                    'ic' =>  preg_replace('/[^0-9]/', '', $request->ic),
                    'password' =>  $request->password_1
                ];

                Session::flash('success', "Akaun baru [".$request->username."] telah berjaya dicipta!");
                Mail::to($request->email)->send(new SendMail($data));
                return redirect()->route('pengurusan.pengguna');
            }
        }
    }

    

    public function edit(Request $request, $id){
        $data = DB::table('users')
                    ->select('users.user_id AS user_id',
                    'users.user_email AS user_email',
                    'users__profile.user_fullname AS user_fullname',
                    'users__profile.no_ic AS no_ic',
                    'users__profile.no_phone AS no_phone',
                    'users__profile.state_id AS state_id',
                    'users__profile.daerah_id AS daerah_id',
                    'users__profile.krt_id AS krt_id',
                    'users.user_status AS user_status')
                    ->join('users__profile','users__profile.user_id','=','users.user_id')
                    ->leftJoin('ref__roles_users','ref__roles_users.id','=','users.user_role')
                    ->leftJoin('ref__states','ref__states.state_id','=','users__profile.state_id')
                    ->leftJoin('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                    ->where('users.user_id', '=', $id)
                    ->first();
        $data2 = DB::table('users__roles')
                    ->select('*')
                    ->where('users__roles.user_id', '=', $id)
                    ->first();
 
        return Response::json($data);
        return Response::json($data2);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function peranan(Request $request, $id){
        $data = DB::table('users__roles')
                ->select('users__roles.id AS id',
                'ref__roles_users.short_description AS peranan',
                'ref__states.state_description AS state',
                'ref__daerahs.daerah_description AS daerah')
                ->join('ref__roles_users','ref__roles_users.id','=','users__roles.role_id')
                ->join('users__profile','users__profile.id','=','users__roles.user_id')
                ->join('ref__states','ref__states.state_id','=','users__profile.state_id')
                ->join('ref__daerahs','ref__daerahs.daerah_id','=','users__profile.daerah_id')
                ->where('users__roles.user_id', '=', $id)
                ->get();
            return Datatables::of($data)
            ->make(true);
    }
}
