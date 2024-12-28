<?php

namespace App\Http\Controllers;

use App\RefParlimen;
use Illuminate\Http\Request;
use Redirect, Response;
use DataTables;
use DB;

class RefParlimenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::table('ref__parlimens')
                    ->select('ref__parlimens.id','ref__parlimens.parlimen_id','ref__parlimens.parlimen_description','ref__states.state_description','ref__states.state_id')
                    ->join('ref__states','ref__states.state_id','=','ref__parlimens.state_id')
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
            'kod_parlimen.required'             => 'Kod parlimen MESTI diisi dan unik',
            'input_parlimen.required'           => 'Ruangan nama parlimen MESTI diisi',
            'select_negeri_parlimen.required'   => 'Sila pilih negeri',
        ];
        $validator = \Validator::make($request->all(), [
            'kod_parlimen'              => 'required',
            'input_parlimen'            => 'required',
            'select_negeri_parlimen'    => 'required',
        ], $messages);

        if ($validator->fails())
        {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        }

        $parlimen = new RefParlimen;

        $parlimen->parlimen_id           = $request->kod_parlimen;
        $parlimen->parlimen_description  = $request->input_parlimen;
        $parlimen->state_id              = $request->select_negeri_parlimen;

        $parlimen->save();
        
        return redirect()->route('pengurusan.rujukan_data');
    }

    public function show(RefParlimen $refParlimen)
    {
        //
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $data  = RefParlimen::where($where)->first();
 
        return Response::json($data);
    }

    public function update(Request $request, RefParlimen $refParlimen, $id)
    {
        $messages = [
            'kod_parlimen.required'             => 'Kod parlimen MESTI diisi dan unik',
            'input_parlimen.required'           => 'Ruangan nama parlimen MESTI diisi',
            'select_negeri_parlimen.required'   => 'Sila pilih negeri',
        ];
        $validator = \Validator::make($request->all(), [
            'kod_parlimen'              => 'required',
            'input_parlimen'            => 'required',
            'select_negeri_parlimen'    => 'required',
        ], $messages);

        if ($validator->fails())
        {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        }
        
        $where = array('id' => $id);
        $parlimen  = RefParlimen::where($where)->first();
 
        $parlimen->parlimen_id           = $request->kod_parlimen;
        $parlimen->parlimen_description  = $request->input_parlimen;
        $parlimen->state_id              = $request->select_negeri_parlimen;
 
        $parlimen->save();
 
        return redirect()->route('pengurusan.rujukan_data');
    }

    public function destroy(RefParlimen $refParlimen, $id)
    {
        $data = RefParlimen::where('id',$id)->delete();
   
        return Response::json($data);
    }
}
