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
use App\UserProfile;
use App\RefDaerah;
use App\KRT_Profile;

class RefESepakatController extends Controller
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
                    ->whereIn('users.user_role', [15,16,17,18,19,20,21,22,23,24])
                    ->get();

                return Datatables::of($data)
                        ->make(true);
            }
        }
    }

    public function store(Request $request) {
        $action = $request->action_sepakat;
        $app_id = $request->user_profile_id;
        $urole = $request->select_peranan_sepakat;
        if ($action == 'edit') {
            $rules_main = array(                
                'select_peranan_sepakat_edit'          => 'required',
                'password_1_sepakat_edit'              => 'min:6|required_with:password_2_sepakat_edit|same:password_2_sepakat_edit',
                'password_2_sepakat_edit'              => 'min:6',
                'name_sepakat_edit'                    => 'required',
                'phone_sepakat_edit'                   => 'required|numeric',
                'email_sepakat_edit'                   => 'required|email',
            );
            if($urole == '15'){
                $rules_main_1 = array(            
                    'select_negeri_sepakat_edit'       => 'required',
                    'select_daerah_sepakat_edit'       => 'required',
                );
            }else if($urole == '16'){
                $rules_main_1 = array(            
                    'select_negeri_sepakat_edit'       => 'required',
                    'select_daerah_sepakat_edit'       => 'required',
                );
            }else if($urole == '17'){
                $rules_main_1 = array(            
                    'select_negeri_sepakat_edit'       => 'required',
                );
            }else if($urole == '18'){
                $rules_main_1 = array(            
                    'select_negeri_sepakat_edit'       => 'required',
                );
            }else if($urole == '19'){
                $rules_main_1 = array(            
                    
                );
            }else if($urole == '20'){
                $rules_main_1 = array(            
                    
                );
            }else if($urole == '21'){
                $rules_main_1 = array(            
                    
                );
            }else if($urole == '22'){
                $rules_main_1 = array(            
                    'select_negeri_sepakat_edit'       => 'required',
                );
            }else if($urole == '23'){
                $rules_main_1 = array(            
                    'select_negeri_sepakat_edit'       => 'required',
                );
            }else if($urole == '24'){
                $rules_main_1 = array(            
                    'select_negeri_sepakat_edit'       => 'required',
                );
            }else {
                $rules_main_1 = array(
                    'select_negeri_sepakat_edit'       => 'required'
                );
            }
        }else {
            $rules_main = array(
                'select_peranan_sepakat'               => 'required',
                // 'username_sepakat'                     => 'required|alpha_num|unique:users,user_name',
                'password_1_sepakat'                   => 'min:6|required_with:password_2_sepakat|same:password_2_sepakat',
                'password_2_sepakat'                   => 'min:6',
                'name_sepakat'                         => 'required',
                'ic_sepakat'                           => 'required|min:11|unique:users__profile,no_ic',
                'phone_sepakat'                        => 'required|numeric',
                'email_sepakat'                        => 'required|email',
            );
            if($urole == '15'){
                $rules_main_1 = array(            
                    'select_negeri_sepakat'            => 'required',
                    'select_daerah_sepakat'            => 'required',
                );
            }else if($urole == '16'){
                $rules_main_1 = array(            
                    'select_negeri_sepakat'            => 'required',
                    'select_daerah_sepakat'            => 'required',
                );
            }else if($urole == '17'){
                $rules_main_1 = array(            
                    'select_negeri_sepakat'            => 'required',
                );
            }else if($urole == '18'){
                $rules_main_1 = array(            
                    'select_negeri_sepakat'            => 'required',
                );
            }else if($urole == '19'){
                $rules_main_1 = array(            
                    
                );
            }else if($urole == '20'){
                $rules_main_1 = array(            
                    
                );
            }else if($urole == '21'){
                $rules_main_1 = array(            
                    
                );
            }else if($urole == '22'){
                $rules_main_1 = array(            
                    'select_negeri_sepakat'            => 'required',
                );
            }else if($urole == '23'){
                $rules_main_1 = array(            
                    
                );
            }else if($urole == '24'){
                $rules_main_1 = array(            
                    'select_negeri_sepakat'            => 'required',
                );
            }else {
                $rules_main_1 = array(
                    'select_negeri_sepakat_edit'       => 'required',
                );
            }
        }
        
        $messages = [
            'select_peranan_sepakat.required'      => 'Ruangan peranan mesti dipilih',
            'select_negeri_sepakat.required'       => 'Ruangan negeri mesti dipilih',
            'select_daerah_sepakat.required'       => 'Ruangan daerah mesti dipilih',
            // 'username_sepakat.required'            => 'Ruangan kata nama mesti diisi',
            // 'username_sepakat.alpha_num'           => 'Kata nama hanya huruf dan nombor sahaja dibenarkan. Tanda space tidak dibenarkan',
            // 'username_sepakat.unique'              => 'Kata nama yang dimasukkan telah wujud di dalam pangkalan data. Sila pilih kata nama lain',
            'password_1_sepakat.required_with'     => 'Ruangan kata laluan mesti diisi',
            'password_1_sepakat.same'              => 'Kata laluan dimasukkan tidak sepadan dengan yang ditaip semula. Sahkan kemasukkan',
            'name_sepakat.required'                => 'Ruangan nama mesti diisi',
            'ic_sepakat.required'                  => 'Ruangan no kad pengenalan mesti diisi',
            'ic_sepakat.unique'                    => 'No kad pengenalan telah wujud dengan Sistem Maklumat Perpaduan.',
            'phone_sepakat.required'               => 'Ruangan no telefon mesti diisi',
            'email_sepakat.required'               => 'Ruangan email mesti diisi',
            'email_sepakat.email'                  => 'Alamat email yang dimasukkan tidah sah',

            'select_peranan_sepakat_edit.required'      => 'Ruangan peranan mesti dipilih',
            'select_negeri_sepakat_edit.required'       => 'Ruangan negeri mesti dipilih',
            'select_daerah_sepakat_edit.required'       => 'Ruangan daerah mesti dipilih',
            'password_1_sepakat_edit.required_with'     => 'Ruangan kata laluan mesti diisi',
            'password_1_sepakat_edit.same'              => 'Kata laluan dimasukkan tidak sepadan dengan yang ditaip semula. Sahkan kemasukkan',
            'name_sepakat_edit.required'                => 'Ruangan nama mesti diisi',
            'phone_sepakat_edit.required'               => 'Ruangan no telefon mesti diisi',
            'email_sepakat_edit.required'               => 'Ruangan email mesti diisi',
            'email_sepakat_edit.email'                  => 'Alamat email yang dimasukkan tidah sah',
        ];
        
        $rules = $rules_main + $rules_main_1;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {  
            if ($action == 'edit') {
                $where = array('user_id' => $app_id);
                
                $user = User::where($where)->first();
                $user->user_email       = $request->email_sepakat_edit;
                $user->user_role        = $request->select_peranan_sepakat_edit;
                $user->password         = Hash::make($request->password_1_sepakat_edit);
                $user->state_id         = $request->select_negeri_sepakat_edit;
                $user->daerah_id        = $request->select_daerah_sepakat_edit;
                $user->user_status      = $request->select_status_sepakat;
                $user->save();

                $userProfile = UserProfile::where($where)->first();
                $userProfile->user_fullname  = $request->name_sepakat_edit;
                $userProfile->no_phone       = $request->phone_sepakat_edit;
                $userProfile->state_id       = $request->select_negeri_sepakat_edit;
                $userProfile->daerah_id      = $request->select_daerah_sepakat_edit;
                $userProfile->save();
                Session::flash('success', "Akaun [".$request->name_sepakat_edit."] telah berjaya dikemaskini!");

            } else {
                $user = new User;
                $user->no_ic            = preg_replace('/[^0-9]/', '', $request->ic_sepakat);
                $user->user_email       = $request->email_sepakat;
                $user->user_role        = $request->select_peranan_sepakat;
                $user->password         = Hash::make($request->password_1_sepakat);
                $user->state_id         = $request->select_negeri_sepakat;
                $user->daerah_id        = $request->select_daerah_sepakat;
                $user->user_status      = '1';

                $user->save();
                $last_user_id           = $user->user_id;

                $userProfile = new UserProfile;            
                $userProfile->user_id        = $last_user_id;
                $userProfile->user_fullname  = $request->name_sepakat;
                $userProfile->no_ic          = preg_replace('/[^0-9]/', '', $request->ic_sepakat);
                $userProfile->no_phone       = $request->phone_sepakat;
                $userProfile->state_id       = $request->select_negeri_sepakat;
                $userProfile->daerah_id      = $request->select_daerah_sepakat; 
                             
                $userProfile->save();

                $data = [
                    'ic' =>  preg_replace('/[^0-9]/', '', $request->ic_sepakat),
                    'password' =>  $request->password_1_sepakat
                ];

                Session::flash('success', "Akaun baru [".$request->name_sepakat."] telah berjaya dicipta!");
                Mail::to($request->email_sepakat)->send(new SendMail($data));
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
                    'users__profile.srs_id',
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
