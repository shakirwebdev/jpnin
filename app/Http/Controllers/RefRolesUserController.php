<?php

namespace App\Http\Controllers;

use App\RefRolesUser;
use Illuminate\Http\Request;
use Redirect, Response;
use DataTables;
use DB;

class RefRolesUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request){
        if($request->ajax())
        {
            $data = DB::table('ref__roles_users')
                    ->select('ref__roles_users.id','ref__roles_users.short_description','ref__roles_users.long_description')
                    ->where('ref__roles_users.status', '=', true)
                    ->get();

            return Datatables::of($data)
                    ->make(true);
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request){
        $messages = [
            'input_peranan_nama.required' => 'Ruangan nama peranan pengguna MESTI diisi',
            'input_peranan_penerangan.required' => 'Ruangan penerangan MESTI diisi ',
        ];
        $validator = \Validator::make($request->all(), [
            'input_peranan_nama'    => 'required',
            'input_peranan_penerangan'   => 'required',
        ], $messages);

        if ($validator->fails())
        {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        }

        $pengguna = new RefRolesUser;

        $pengguna->short_description = $request->input_peranan_nama;
        $pengguna->long_description = $request->input_peranan_penerangan;

        $pengguna->save();
        
        return redirect()->route('pengurusan.peranan');
    }

    public function show($id)
    {
        //
    }

    public function edit($id){
        $where = array('id' => $id);
        $data  = RefRolesUser::where($where)->first();
 
        return Response::json($data);
    }

    public function update(Request $request, $id){
        $messages = [
            'input_peranan_nama.required' => 'Ruangan nama peranan pengguna MESTI diisi',
            'input_peranan_penerangan.required' => 'Ruangan penerangan MESTI diisi ',
        ];
        $validator = \Validator::make($request->all(), [
            'input_peranan_nama'    => 'required',
            'input_peranan_penerangan'   => 'required',
        ], $messages);

        if ($validator->fails())
        {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        }
        
        $where = array('id' => $id);
        $pengguna  = RefRolesUser::where($where)->first();
 
        $pengguna->short_description = $request->input_peranan_nama;
        $pengguna->long_description = $request->input_peranan_penerangan;
 
        $pengguna->save();
 
        return redirect()->route('pengurusan.peranan');
    }

    public function destroy($id)
    {
        $data = RefRolesUser::where('id',$id)->delete();
   
        return Response::json($data);
    }
}
