<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RT_SM20Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function laporan_senarai_srs(){
        return view('rt-sm20.laporan-senarai-srs');
    }

    function laporan_pembatalan_srs(){
        return view('rt-sm20.laporan-pembatalan-srs');
    }

    function laporan_senarai_peronda_srs(){
        return view('rt-sm20.laporan-senarai-peronda-srs');
    }

    function laporan_ringkasan_jumlah_peronda_srs(){
        return view('rt-sm20.laporan-ringkasan-jumlah-peronda-srs');
    }
}
