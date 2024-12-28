<?php

namespace App\Http\Controllers;

use App\RefDaerah;
use Illuminate\Http\Request;
use Redirect, Response;
use DataTables;
use DB;

class RefDaerahController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::table('ref__daerahs')
                    ->select('ref__daerahs.id','ref__daerahs.daerah_id','ref__daerahs.daerah_description','ref__states.state_description','ref__states.state_id')
                    ->join('ref__states','ref__states.state_id','=','ref__daerahs.state_id')
                    ->get();

            return Datatables::of($data)
                    ->make(true);
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $messages = [
            'kod_daerah.required'       => 'Kod daerah MESTI diisi dan unik',
            'input_daerah.required'     => 'Ruangan nama daerah MESTI diisi',
            'select_negeri.required'    => 'Sila pilih negeri',
        ];
        $validator = \Validator::make($request->all(), [
            'kod_daerah'      => 'required',
            'input_daerah'    => 'required',
            'select_negeri'   => 'required',
        ], $messages);

        if ($validator->fails())
        {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        }

        $daerah = new RefDaerah;

        $daerah->daerah_id            = $request->kod_daerah;
        $daerah->daerah_description   = $request->input_daerah;
        $daerah->state_id             = $request->select_negeri;

        $daerah->save();
        
        return redirect()->route('pengurusan.rujukan_data');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $data  = RefDaerah::where($where)->first();
 
        return Response::json($data);
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'kod_daerah.required'       => 'Kod daerah MESTI diisi dan unik',
            'input_daerah.required'     => 'Ruangan nama daerah MESTI diisi',
            'select_negeri.required'    => 'Sila pilih negeri',
        ];
        $validator = \Validator::make($request->all(), [
            'kod_daerah'      => 'required',
            'input_daerah'    => 'required',
            'select_negeri'   => 'required',
        ], $messages);

        if ($validator->fails())
        {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        }
        
        $where = array('id' => $id);
        $daerah  = RefDaerah::where($where)->first();
 
        $daerah->daerah_id          = $request->kod_daerah;
        $daerah->daerah_description = $request->input_daerah;
        $daerah->state_id           = $request->select_negeri;
 
        $daerah->save();
 
        return redirect()->route('pengurusan.rujukan_data');
    }

    public function destroy($id)
    {
        $data = RefDaerah::where('id',$id)->delete();
   
        return Response::json($data);
    }
}
