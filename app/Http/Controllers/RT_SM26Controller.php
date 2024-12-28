<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RT_SM26Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function permohonan_laporan_kes_mediasi_admin(){
        return view('rt-sm26.permohonan-laporan-kes-mediasi-admin');
    }

    function permohonan_laporan_kes_mediasi_admin_1(){
        return view('rt-sm26.permohonan-laporan-kes-mediasi-admin-1');
    }

    function perakuan_laporan_kes_mediasi_admin(){
        return view('rt-sm26.perakuan-laporan-kes-mediasi-admin');
    }

    function perakuan_laporan_kes_mediasi_admin_1(){
        return view('rt-sm26.perakuan-laporan-kes-mediasi-admin-1');
    }

    function perakuan_laporan_kes_mediasi_admin_p(){
        return view('rt-sm26.perakuan-laporan-kes-mediasi-admin-p');
    }

    function perakuan_laporan_kes_mediasi_admin_p_1(){
        return view('rt-sm26.perakuan-laporan-kes-mediasi-admin-p-1');
    }

    function pengesahan_laporan_kes_mediasi_admin(){
        return view('rt-sm26.pengesahan-laporan-kes-mediasi-admin');
    }

    function pengesahan_laporan_kes_mediasi_admin_1(){
        return view('rt-sm26.pengesahan-laporan-kes-mediasi-admin-1');
    }
}
