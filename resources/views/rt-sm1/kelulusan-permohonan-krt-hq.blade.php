@extends('layout.master')
@section('parentPageTitle', 'HRMS')
@section('title', 'Pengesahan Permohonan Penubuhan Kawasan Rukun Tetangga Baharu')


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
                                    <p>Kepada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <u><b>Ketua Pengarah Rukun Tetangga</b></u></p>
                                    <br><br>
                                    <p>Tuan / Puan</p>
                                    <br><br>
                                    <p><b>SOKONGAN PERMOHONAN PENEPATAN KAWASAN RUKUN TETANGGA</b></p>
                                    <br>
                                    <p>Pemohonan daripada Jawatankuasa Penaja Kawasan Rukun Tetangga <b><span id="krt_nama" name="krt_nama"></span></b> untuk mewujudkan KRT telah disemak dan semua dokumen lengkap telah disediakan.</p>
                                    <p>2. Dikemukakan untuk pertimbangan dan tindakan tuan/puan selanjutnya.</p>
                                    <br><br>
                                    <p>Terima Kasih</p>
                                    <br><br>
                                    <p>Yang Benar,</p>
                                    <br><br><br><br>
                                    <p>(Tandatangan Pegawai Perpaduan Daerah / Bahagian)</p>
                                    <p>Nama : <b><span id="krt_disemak_by" name="krt_disemak_by"></span></b></p>
                                    <p>Tarikh : <b><span id="krt_disemak_date" name="krt_disemak_date"></span></b></p>
                                    <br><br>
                                    <p>Status: <b>Disokong</b></p>
                                    <p>Catatan: <b><span id="krt_disemak_note" name="krt_disemak_note"></span></b></p>
                                    <br><br><br><br>
                                    <p>(Tandatangan Pengarah Perpaduan Negeri)</p>
                                    <p>Nama : <b><span id="krt_disahkan_by" name="krt_disahkan_by"></span></b></p>
                                    <p>Tarikh : <b><span id="krt_disahkan_date" name="krt_disahkan_date"></span></b></p>
                                    <br><br>
                                    <p>Status: <b>Disemak</b></p>
                                    <p>Catatan: <b><span id="krt_disahkan_note" name="krt_disahkan_note"></span></b></p>
                                </div>
                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>&nbsp;
                                <button type="submit" class="btn btn-primary" id="btn_next">Seterusnya&nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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

@include('js.rt-sm1.j-kelulusan-permohonan-krt-hq')