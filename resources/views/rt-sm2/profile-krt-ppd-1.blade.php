@extends('layout.master')
@section('parentPageTitle', 'HRMS')
@section('title', 'Paparan Profil KRT')


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
                                <div class="col-12">
                                    <p>(Diisi oleh Jawatankuasa Penaja)</p>
                                    <br><br>
                                    <p>Kepada</p>
                                    <br>
                                    <p>Pegawai Perpaduan Negara dan Integrasi Nasional</p>
                                    <p>Daerah / Bahagian</p>
                                    <br>
                                    <p>Tuan / Puan</p>
                                    <br><br>
                                    <p><b>PERMOHONAN PENETAPAN KAWASAN RUKUN TERTANGGA</b></p>
                                    <br>
                                    <p>Saya mewakili Jawatankuasa Rukun Tertangga <b><span id="krt_nama" name="krt_nama"></span></b> memohon supaya KRT dapat diwujudkan di kawasan ini. Keputusan untuk mewujudkan KRT ini telah dibuat dan dipersetujui dalam Majlis Perjumpaan dengan Penduduk Setempat pada <b><span id="created_at" name="created_at"></span></b>.</p>
                                    <p>Bersama-sama ini disertakan perkara-perkara berikut:</p>
                                    <div class="col-12">
                                        <p> (a) Maklumat Asas Kawasan<br>
                                            (b) Peta Kawasan<br>
                                            (c) Senarai Nama Jawatankuasa Penaja Rukun Tertangga<br>
                                        </p>
                                    </div>
                                    <p>2. Dikemukakan untuk pertimbangan dan tindakan tuan/puan selanjutnya.</p>
                                    <br><br>
                                    <p>Terima Kasih</p>
                                    <br><br>
                                    <p>Yang Benar,</p>
                                    <br><br>
                                    <p>Nama : <b><span id="dihantar_by" name="dihantar_by"></span></b></p>
                                    <p>Tarikh : <b><span id="dihantar_date" name="dihantar_date"></span></b></p><br><br>
                                </div>
                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>&nbsp;
                                <button type="button" class="btn btn-primary" id="btn_next">Seterusnya&nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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

@include('js.rt-sm2.j-profile-krt-ppd-1')