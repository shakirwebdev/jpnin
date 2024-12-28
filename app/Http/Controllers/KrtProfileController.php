<?php

namespace App\Http\Controllers;

use App\KRT_Profile;
use Illuminate\Http\Request;
use Redirect, Response;
use DataTables;
use DB;

class KrtProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::table('krt__profile')
                    ->select('krt__profile.*')
                    ->get();

            return Datatables::of($data)
                    ->make(true);
        }
    }
}
