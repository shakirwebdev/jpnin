<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Redirect, Response;
use Auth;
use Validator;
use Session;
use DataTables;
use DB;
use Carbon\Carbon;
use App\User;
use App\UserProfile;
use App\RefStates;
use App\RefDaerah;
use App\RefBandar;
use App\RefParlimen;
use App\RefDUN;
use App\RefPBT;
use App\KRT_Profile;
use App\RefKaum;
use App\RefJantina;
use App\RefPendidikan;
use App\SPK_imediator;
use App\SPK_imediator_keaktifan;
use App\Ref_SPK_MKP_Mediasi;
use App\Ref_SPK_MKP_Mediasi_Status;
use App\Ref_SPK_MKP_Peringkat;
use App\SPK_imediator_Keaktifan_Mediasi;
use App\SPK_imediator_Keaktifan_Aktiviti;
use App\SPK_imediator_Keaktifan_Latihan;
use App\SPK_imediator_Keaktifan_Sumbangan;

class RT_SM24Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function borang_keaktifan_mkp_admin(){
        return view('rt-sm24.borang-keaktifan-mkp-admin');
    }

    function borang_keaktifan_mkp_admin_1(){
        return view('rt-sm24.borang-keaktifan-mkp-admin-1');
    }

    function senarai_keaktifan_mkp_admin(){
        return view('rt-sm24.senarai-keaktifan-mkp-admin');
    }

    function senarai_keaktifan_mkp_admin_1(){
        return view('rt-sm24.senarai-keaktifan-mkp-admin-1');
    }

    function senarai_keaktifan_mkp_admin_2(){
        return view('rt-sm24.senarai-keaktifan-mkp-admin-2');
    }
}
