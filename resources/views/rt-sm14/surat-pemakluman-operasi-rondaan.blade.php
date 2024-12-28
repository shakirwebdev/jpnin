@extends('layout.master')
@section('title', 'Hantar Pemakluman Operasi Rondaan')


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
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <br/><br/>
                                    <p>Pegawai Perpaduan Daerah / Bahagian</p>
                                    <p>Jabatan Perpaduan Negara dan Integrasi Nasional</p>
                                    <p>Daerah : <b><font color="black">PERLIS</font></b></p>
                                    <p>Negeri &nbsp;: <b><font color="black">10/01/2021</font></b></p>
                                    <br/><br/>
                                    <p>Tuan / Puan</p>
                                    <br/><br/>
                                    <p><b>NOTIS MAKLUMAN PENGOPERASI RONDAAN</b></p>
                                    <br/>
                                    <p>Sukacita dimaklumkan bahawa Skim Rondaan Sukarela Kawasan Rukun Tetangga <b><font color="black">SRS Taman Peladang Jaya, KRT Taman Peladang Jaya,</font></b> Daerah <b><font color="black">PERLIS</font></b> telah memulakan rondaan keselamatan kawasan kejiranan pada tarikh <b><font color="black">PERLIS</font></b></p>
                                    <br/><br/>
                                    <p>Sekian, terima kasih</b></p>
                                    <br/><br/>
                                    <p>Yang Benar,</p>
                                    <p>(Pengerusi Kawasan Rukun Tetangga)</p>
                                    <p>Nama : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><font color="black">Mohamad Shauki Bin Sahardi</font></b></p>
                                    <p>Jawatan : &nbsp;<b><font color="black">PENGURUSI</font></b></p>
                                    <p>Tarikh : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><font color="black">10/01/2021</font></b></p>
                                    <p>s.k: Pengarah JPNIN Negeri</p>
                                </div>
                                
                                <div class="col-12">
                                    <br/><br/><br/>
                                    <button type="submit" class="btn btn-primary">Cetak Pemakluman Operasi Rondaan&nbsp;&nbsp;<i class="dropdown-icon fa fa-print"></i></button>
                                </div>
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

@include('js.rt-sm14.j-pemakluman-operasi-rondaan')
