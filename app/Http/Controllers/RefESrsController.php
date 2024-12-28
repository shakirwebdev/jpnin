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

class RefESrsController extends Controller
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
            } else if($type == 'get_srs') {
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
                    ->whereIn('users.user_role', [13])
                    ->get();

                return Datatables::of($data)
                        ->make(true);
            }
        }
    }

    public function store(Request $request) {
        $action = $request->action_srs;
        $app_id = $request->user_profile_id;
        $urole = $request->select_peranan_esrs;
        if ($action == 'edit') {
            $rules_main = array(                
            'select_peranan_esrs_edit'          => 'required',
            'select_negeri_esrs_edit'           => 'required',
            'select_daerah_esrs_edit'           => 'required',
            'select_krt_esrs_edit'              => 'required',
            'select_srs_esrs_edit'              => 'required',
            'password_1_esrs_edit'              => 'min:6|required_with:password_2_esrs_edit|same:password_2_esrs_edit',
            'password_2_esrs_edit'              => 'min:6',
            'name_esrs_edit'                    => 'required',
            'phone_esrs_edit'                   => 'required|numeric',
            'email_esrs_edit'                   => 'required|email',
            'alamat_esrs_edit'                  => 'required',
            );
        }else {
            $rules_main = array(
            'select_peranan_esrs'               => 'required',
            'select_negeri_esrs'                => 'required',
            'select_daerah_esrs'                => 'required',
            'select_krt_esrs'                   => 'required',
            'select_srs_esrs'                   => 'required',
            // 'username_esrs'                     => 'required|alpha_num|unique:users,user_name',
            'password_1_esrs'                   => 'min:6|required_with:password_2_esrs|same:password_2_esrs',
            'password_2_esrs'                   => 'min:6',
            'name_esrs'                         => 'required',
            'ic_esrs'                           => 'required|min:11|unique:users__profile,no_ic',
            'phone_esrs'                        => 'required|numeric',
            'email_esrs'                        => 'required|email',
            'alamat_esrs'                       => 'required',
            );
        }
        
        $messages = [
            'select_peranan_esrs.required'      => 'Ruangan peranan mesti dipilih',
            'select_negeri_esrs.required'       => 'Ruangan negeri mesti dipilih',
            'select_daerah_esrs.required'       => 'Ruangan daerah mesti dipilih',
            'select_krt_esrs.required'          => 'Ruangan KRT mesti dipilih',
            'select_srs_esrs.required'          => 'Ruangan SRS mesti dipilih',
            // 'username_esrs.required'            => 'Ruangan kata nama mesti diisi',
            // 'username_esrs.alpha_num'           => 'Kata nama hanya huruf dan nombor sahaja dibenarkan. Tanda space tidak dibenarkan',
            // 'username_esrs.unique'              => 'Kata nama yang dimasukkan telah wujud di dalam pangkalan data. Sila pilih kata nama lain',
            'password_1_esrs.required_with'     => 'Ruangan kata laluan mesti diisi',
            'password_1_esrs.same'              => 'Kata laluan dimasukkan tidak sepadan dengan yang ditaip semula. Sahkan kemasukkan',
            'name_esrs.required'                => 'Ruangan nama mesti diisi',
            'ic_esrs.required'                  => 'Ruangan no kad pengenalan mesti diisi',
            'ic_esrs.unique'                    => 'No kad pengenalan telah wujud dengan Sistem Maklumat Perpaduan.',
            'phone_esrs.required'               => 'Ruangan no telefon mesti diisi',
            'email_esrs.required'               => 'Ruangan email mesti diisi',
            'email_esrs.email'                  => 'Alamat email yang dimasukkan tidah sah',
            'alamat_esrs.required'              => 'Ruangan alamat mesti diisi',

            'select_peranan_esrs_edit.required'  => 'Ruangan peranan mesti dipilih',
            'select_negeri_esrs_edit.required'   => 'Ruangan negeri mesti dipilih',
            'select_daerah_esrs_edit.required'   => 'Ruangan daerah mesti dipilih',
            'select_krt_esrs_edit.required'      => 'Ruangan KRT mesti dipilih',
            'select_srs_esrs_edit.required'      => 'Ruangan SRS mesti dipilih',
            'password_1_esrs_edit.required_with' => 'Ruangan kata laluan mesti diisi',
            'password_1_esrs_edit.same'          => 'Kata laluan dimasukkan tidak sepadan dengan yang ditaip semula. Sahkan kemasukkan',
            'name_esrs_edit.required'            => 'Ruangan nama mesti diisi',
            'phone_esrs_edit.required'           => 'Ruangan no telefon mesti diisi',
            'email_esrs_edit.required'           => 'Ruangan email mesti diisi',
            'email_esrs_edit.email'              => 'Alamat email yang dimasukkan tidah sah',
            'alamat_esrs_edit.required'          => 'Ruangan alamat mesti diisi',
        ];
        
        $rules = $rules_main;
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        } else {  
            if ($action == 'edit') {
                $where = array('user_id' => $app_id);
                
                $user = User::where($where)->first();
                $user->no_ic            = preg_replace('/[^0-9]/', '', $request->ic_esrs_edit);
                $user->user_email       = $request->email_esrs_edit;
                $user->user_role        = $request->select_peranan_esrs_edit;
                $user->password         = Hash::make($request->password_1_esrs_edit);
                $user->state_id         = $request->select_negeri_esrs_edit;
                $user->daerah_id        = $request->select_daerah_esrs_edit;
                $user->krt_id           = $request->select_krt_esrs_edit;
                $user->srs_id           = $request->select_srs_esrs_edit;
                $user->user_status      = $request->select_status_esrs;
                $user->save();

                $userProfile = UserProfile::where($where)->first();
                $userProfile->user_fullname  = $request->name_esrs_edit;
                $user->no_ic                 = preg_replace('/[^0-9]/', '', $request->ic_esrs_edit);
                $userProfile->no_phone       = $request->phone_esrs_edit;
                $userProfile->state_id       = $request->select_negeri_esrs_edit;
                $userProfile->daerah_id      = $request->select_daerah_esrs_edit;
                $userProfile->krt_id         = $request->select_krt_esrs_edit;
                $userProfile->srs_id         = $request->select_srs_esrs_edit;
                $userProfile->user_address   = $request->alamat_esrs_edit;
                $userProfile->save();
                Session::flash('success', "Akaun [".$request->name_esrs_edit."] telah berjaya dikemaskini!");

            } else {
                $user = new User;
                $user->no_ic            = preg_replace('/[^0-9]/', '', $request->ic_esrs);
                $user->user_email       = $request->email_esrs;
                $user->user_role        = $request->select_peranan_esrs;
                $user->password         = Hash::make($request->password_1_esrs);
                $user->state_id         = $request->select_negeri_esrs;
                $user->daerah_id        = $request->select_daerah_esrs;
                $user->krt_id           = $request->select_krt_esrs;
                $user->srs_id           = $request->select_srs_esrs;
                $user->user_status      = '1';

                $user->save();
                $last_user_id           = $user->user_id;

                $userProfile = new UserProfile;            
                $userProfile->user_id        = $last_user_id;
                $userProfile->user_fullname  = $request->name_esrs;
                $userProfile->no_ic          = preg_replace('/[^0-9]/', '', $request->ic_esrs);
                $userProfile->no_phone       = $request->phone_esrs;
                $userProfile->state_id       = $request->select_negeri_esrs;
                $userProfile->daerah_id      = $request->select_daerah_esrs; 
                $userProfile->krt_id         = $request->select_krt_esrs;
                $userProfile->srs_id         = $request->select_srs_esrs;  
                $userProfile->user_address   = $request->alamat_esrs;             

                $userProfile->save();

                $data = [
                    'ic' =>  preg_replace('/[^0-9]/', '', $request->ic_esrs),
                    'password' =>  $request->password_1_esrs
                ];

                Session::flash('success', "Akaun baru [".$request->name_esrs."] telah berjaya dicipta!");
                Mail::to($request->email_esrs)->send(new SendMail($data));
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
