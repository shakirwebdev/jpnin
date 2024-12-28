<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RT_SM17Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function penyediaan_pengedalian_kes_srs(){
        return view('rt-sm17.penyediaan-pengedalian-kes-srs');
    }

    function borang_pengedali_kes_k(){
        return view('rt-sm17.borang-pengedali-kes-k');
    }

    function jana_laporan_pengendalian_kes_srs(){
        return view('rt-sm17.jana-laporan-pengendalian-kes-srs');
    }

    function jana_laporan_pengendalian_kes_srs_d(){
        return view('rt-sm17.jana-laporan-pengendalian-kes-srs-d');
    }

    function jana_laporan_pengendalian_kes_srs_n(){
        return view('rt-sm17.jana-laporan-pengendalian-kes-srs-n');
    }

    function jana_laporan_pengendalian_kes_srs_all(){
        return view('rt-sm17.jana-laporan-pengendalian-kes-srs-all');
    }

    function print_borang_masa_rehat(){
        return view('rt-sm17.print-borang-masa-rehat');
    }
}
