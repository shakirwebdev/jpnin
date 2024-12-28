<?php

namespace App\Http\Controllers;

use App\RefRolesMenu;
use Illuminate\Http\Request;
use Redirect, Response;
use DB;

class RefRolesMenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::table('ref__roles_menus')
                    ->select('ref__roles_menus.id','ref__roles_menus.url','ref__roles_menus.nama','ref__roles_menus.ikon','ref__roles_menus.tabs')
                    ->where('ref__roles_menus.status', '=', true)
                    ->get();

            return Response::json($data);
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $messages = [
            'url.required' => 'Ruangan URL MESTI diisi',
            'nama.required' => 'Ruangan nama MESTI diisi ',
        ];
        $validator = \Validator::make($request->all(), [
            'url'    => 'required',
            'nama'   => 'required',
        ], $messages);

        if ($validator->fails())
        {
            return \Response::json(array('errors' => $validator->errors()->toArray()));
        }

        $menu = new RefRolesMenu;

        $menu->url = $request->url;
        $menu->nama = $request->nama;

        $menu->save();
        
        return redirect()->route('pengurusan.peranan');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $data  = RefRolesMenu::where($where)->first();
 
        return Response::json($data);
    }

    public function update(Request $request, $id)
    {
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
        $pengguna  = RefRolesMenu::where($where)->first();
 
        $pengguna->short_description = $request->input_peranan_nama;
        $pengguna->long_description = $request->input_peranan_penerangan;
 
        $pengguna->save();
 
        return redirect()->route('pengurusan.peranan');
    }

    public function destroy($id)
    {
        $data = RefRolesMenu::where('id',$id)->delete();
   
        return Response::json($data);
    }
}
