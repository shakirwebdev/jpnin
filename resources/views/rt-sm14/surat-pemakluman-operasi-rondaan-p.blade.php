@extends('layout.master')
@section('title', 'Surat Pemakluman Operasi Rondaan')


@section('content')
    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                &nbsp;
            </div>
        </div>
    </div>
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="user-list" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <br/><br/>
                                <p>Pegawai Perpaduan Daerah / Bahagian</p>
                                <p>Jabatan Perpaduan Negara dan Integrasi Nasional</p>
                                <p>Daerah : <b><font color="black"><span id="spors_daerah" name="spors_daerah"></span></font></b></p>
                                <p>Negeri &nbsp;: <b><font color="black"><span id="spors_state" name="spors_state"></span></font></b></p>
                                <br/><br/>
                                <p>Tuan / Puan</p>
                                <br/><br/>
                                <p><b>NOTIS MAKLUMAN PENGOPERASIAN RONDAAN</b></p>
                                <br/>
                                <p>Sukacita dimaklumkan bahawa Skim Rondaan Sukarela <b><font color="black"><span id="spors_nama_srs" name="spors_nama_srs"></span></font></b> , Kawasan Rukun Tetangga <b><font color="black"><span id="spors_nama_krt" name="spors_nama_krt"></span></font></b> Daerah <b><font color="black"><span id="spors_daerah_1" name="spors_daerah_1"></span></font></b> telah memulakan rondaan keselamatan kawasan kejiranan pada tarikh <b><font color="black"><span id="spors_ops_tarikh_mula_ronda" name="spors_ops_tarikh_mula_ronda"></span></font></b></p>
                                <br/><br/>
                                <p>Sekian, terima kasih</b></p>
                                <br/><br/>
                                <p>Yang Benar,</p>
                                <p>Nama : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><font color="black"><span id="spors_user_fullname" name="spors_user_fullname"></span></font></b></p>
                                <p>Jawatan : &nbsp;<b><font color="black">PENGERUSI</font></b></p>
                                <p>Tarikh : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><font color="black"><span id="spors_direkod_date" name="spors_direkod_date"></span></font></b></p>
                                <p>s.k: Pengarah JPNIN Negeri</p>
                            </div>
                            <br><br>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>            
    </div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
@stop

@include('js.rt-sm14.j-surat-pemakluman-operasi-rondaan-p')
