@extends('layout.master')
@section('title', 'Jana Notis Pembatalan Skim Rondaan Sukarela (SRS)')


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
                                    <p class="text-center"><b>SEKSYEN 21, AKTA RUKUN TETANGGA 2012<br>NOTIS PEMBATALAN SKIM RONDAAN SUKARELA</b></p>
                                    <br><br><br>
                                    <p>Adalah saya diarah menarik perhatian tuan/puan kepada perkara diatas dan memaklumkan bahawa Skim Rondaan Sukarela yang disebut dibawah ini telah dibatalkan penubuhan oleh Ketua Pengarah mengikut Sekyen 21 Akta Rukun Tetangga 2012</p>
                                    <br><br>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2">
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <p>(i) Nama SRS yang dibatalkan : <font color="black"><b>SRS Taman Peladang Jaya</b></font></p>
                                    <p>(ii) Tarikh Notis Pembatalan : <font color="black"><b>26/1/2021</b></font></p>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <p>2. Mengikut Seksyen 21, Akta Rukun Tetangga 2012, pembatalan ini juga bermakna peronda Skim Rondaan Sukarela yang berkenaan diatas hendaklah ditamatkan serta merta.</p><br>
                                    <p>3. Pengerusi Jawatankuasa juga mesti memaklumkan kepada peronda mengenai penamatan Skim Rondaan Sukarela.</p><br>
                                    <br><br>
                                    <p>Sekian, Terima Kasih</p>
                                    <br>
                                    <p><b>"BERKHIDMAT UNTUK NEGARA"</b></p>
                                    <br><br>
                                    <p>Saya yang menjalankan amanah,</p>
                                    <br><br><br><br>
                                    <p>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</p>
                                    <p>Ketua Pengarah Rukun Tetangga</p>
                                    <p>Jabatan Perpaduan Negara Dan Integrasi Nasional</p>
                                    <p>Jabatan Perdana Menteri</p><br><br>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm19.jana_notis_pembatalan_srs')}}';"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                    <button type="submit" class="btn btn-primary">Jana Notis Pembatalan SRS&nbsp;&nbsp;<i class="dropdown-icon fa fa-print"></i></button>
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

@include('js.rt-sm19.j-borang-pembatalan-srs')
