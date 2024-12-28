<?php

namespace App\Http\Controllers;

use App\RefBandar;
use App\RefDaerah;
use Illuminate\Http\Request;
use Redirect, Response;
use DataTables;
use DB;

class RefBandarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $type = $request->type;
            if($type == 'get_negeri') {
                $value = $request->value;
                $where = array('state_id' => $value);
                $data  = RefDaerah::where($where)->get();
                return Response::json($data);
            } else {
                $data = DB::table('ref__bandars')
                        ->select('ref__bandars.id','ref__bandars.bandar_description','ref__bandars.daerah_id','ref__states.state_description','ref__states.state_id')
                        ->join('ref__states','ref__states.state_id','=','ref__bandars.state_id')
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

    public function store(Request $request)
    {
        $messages = [
            'input_bandar.required'         => 'Ruangan nama bandar / kawasan MESTI diisi',
            'select_daerah_bandar.required' => 'Sila pilih daerah',
            'select_negeri_bandar.required' => 'Sila pilih negeri',
        ];
        $validator = \Validator::make($request->all(), [
            'input_bandar'              => 'required',
            'select_daerah_bandar'      => 'required',
            'select_negeri_bandar'      => 'required',
        ], $messages);

        if ($validator->fails())
        {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        }
        
        $bandar = new RefBandar;

        $bandar->bandar_description = $request->input_bandar;
        $bandar->daerah_id = $request->select_daerah_bandar;
        $bandar->state_id = $request->select_negeri_bandar;

        $bandar->save();
        
        return redirect()->route('pengurusan.rujukan_data');
    }

    public function show(Request $request, $id)
    {
        //
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $data  = RefBandar::where($where)->first();
 
        return Response::json($data);
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'input_bandar.required'         => 'Ruangan nama bandar / kawasan MESTI diisi',
            'select_daerah_bandar.required' => 'Sila pilih daerah',
            'select_negeri_bandar.required' => 'Sila pilih negeri',
        ];
        $validator = \Validator::make($request->all(), [
            'input_bandar'              => 'required',
            'select_daerah_bandar'      => 'required',
            'select_negeri_bandar'      => 'required',
        ], $messages);

        if ($validator->fails())
        {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        }
        
        $where = array('id' => $id);
        $bandar  = RefBandar::where($where)->first();
 
        $bandar->bandar_description = $request->input_bandar;
        $bandar->daerah_id = $request->select_daerah_bandar;
        $bandar->state_id = $request->select_negeri_bandar;
 
        $bandar->save();
 
        return redirect()->route('pengurusan.rujukan_data');
    }

    public function destroy($id)
    {
        $data = RefBandar::where('id',$id)->delete();
   
        return Response::json($data);
    }
}
