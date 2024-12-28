<?php

namespace App\Http\Controllers;

use App\RefDUN;
use App\RefParlimen;
use Illuminate\Http\Request;
use Redirect, Response;
use DataTables;
use DB;

class RefDUNController extends Controller
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
                $data  = RefParlimen::where($where)->get();
                return Response::json($data);
            } else {
                $data = DB::table('ref__duns')
                        ->select('ref__duns.id','ref__duns.dun_id','ref__duns.dun_description','ref__parlimens.parlimen_description','ref__states.state_description')
                        ->join('ref__states','ref__states.state_id','=','ref__duns.state_id')
                        ->join('ref__parlimens','ref__parlimens.id','=','ref__duns.parlimen_id')
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
            'kod_dun.required'              => 'Kod DUN MESTI diisi dan unik',
            'input_dun.required'            => 'Ruangan nama DUN MESTI diisi',
            'select_parlimen_dun.required'  => 'Sila pilih parlimen',
            'select_negeri_dun.required'    => 'Sila pilih negeri',
        ];
        $validator = \Validator::make($request->all(), [
            'kod_dun'               => 'required',
            'input_dun'             => 'required',
            'select_parlimen_dun'   => 'required',
            'select_negeri_dun'     => 'required',
        ], $messages);

        if ($validator->fails())
        {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        }
        
        $dun = new RefDUN;

        $dun->dun_id            = $request->kod_dun;
        $dun->dun_description   = $request->input_dun;
        $dun->parlimen_id       = $request->select_parlimen_dun;
        $dun->state_id          = $request->select_negeri_dun;

        $dun->save();
        
        return redirect()->route('pengurusan.rujukan_data');
    }

    public function show(Request $request, $id)
    {
        //
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $data  = RefDUN::where($where)->first();
 
        return Response::json($data);
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'kod_dun.required'              => 'Kod DUN MESTI diisi dan unik',
            'input_dun.required'            => 'Ruangan nama DUN MESTI diisi',
            'select_parlimen_dun.required'  => 'Sila pilih parlimen',
            'select_negeri_dun.required'    => 'Sila pilih negeri',
        ];
        $validator = \Validator::make($request->all(), [
            'kod_dun'               => 'required',
            'input_dun'             => 'required',
            'select_parlimen_dun'   => 'required',
            'select_negeri_dun'     => 'required',
        ], $messages);

        if ($validator->fails())
        {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        }
        
        $where = array('id' => $id);
        $dun  = RefDUN::where($where)->first();
 
        $dun->dun_id            = $request->kod_dun;
        $dun->dun_description   = $request->input_dun;
        $dun->parlimen_id       = $request->select_parlimen_dun;
        $dun->state_id          = $request->select_negeri_dun;
 
        $dun->save();
 
        return redirect()->route('pengurusan.rujukan_data');
    }

    public function destroy($id)
    {
        $data = RefDUN::where('id',$id)->delete();
   
        return Response::json($data);
    }
}
