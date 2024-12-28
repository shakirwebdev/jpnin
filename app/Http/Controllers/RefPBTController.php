<?php

namespace App\Http\Controllers;

use App\RefPBT;
use Illuminate\Http\Request;
use Redirect, Response;
use DataTables;
use DB;

class RefPBTController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::table('ref__pbts')
                    ->select('ref__pbts.id','ref__pbts.pbt_id','ref__pbts.pbt_description','ref__states.state_description','ref__states.state_id')
                    ->join('ref__states','ref__states.state_id','=','ref__pbts.state_id')
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
            'kod_pbt.required'              => 'Kod PBT MESTI diisi dan unik',
            'input_pbt.required'            => 'Ruangan nama PBT MESTI diisi',
            'select_negeri_pbt.required'    => 'Sila pilih negeri',
        ];
        $validator = \Validator::make($request->all(), [
            'kod_pbt'               => 'required',
            'input_pbt'             => 'required',
            'select_negeri_pbt'     => 'required',
        ], $messages);

        if ($validator->fails())
        {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        }

        $pbt = new RefPBT;

        $pbt->pbt_id            = $request->kod_pbt;
        $pbt->pbt_description   = $request->input_pbt;
        $pbt->state_id          = $request->select_negeri_pbt;

        $pbt->save();
        
        return redirect()->route('pengurusan.rujukan_data');
    }

    public function show()
    {
        //
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $data  = RefPBT::where($where)->first();
 
        return Response::json($data);
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'kod_pbt.required'              => 'Kod PBT MESTI diisi dan unik',
            'input_pbt.required'            => 'Ruangan nama PBT MESTI diisi',
            'select_negeri_pbt.required'    => 'Sila pilih negeri',
        ];
        $validator = \Validator::make($request->all(), [
            'kod_pbt'               => 'required',
            'input_pbt'             => 'required',
            'select_negeri_pbt'     => 'required',
        ], $messages);

        if ($validator->fails())
        {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        }
        
        $where = array('id' => $id);
        $pbt  = RefPBT::where($where)->first();
        
        $pbt->pbt_id            = $request->kod_pbt;
        $pbt->pbt_description   = $request->input_pbt;
        $pbt->state_id          = $request->select_negeri_pbt;
 
        $pbt->save();
 
        return redirect()->route('pengurusan.rujukan_data');
    }

    public function destroy($id)
    {
        $data = RefPBT::where('id',$id)->delete();
   
        return Response::json($data);
    }
}
