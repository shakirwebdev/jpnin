@extends('layout.master')
@section('parentPageTitle', 'HRMS')
@section('title', 'SEMAKAN PERMOHONAN PENUBUHAN KRT BAHARU')


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
                                    <p>Pemohonan daripada Jawatankuasa Penaja Kawasan Rukun Tetangga <b>KRT Taman Peladang Jaya</b> untuk mewujudkan KRT telah disemak dan semua dokumen lengkap telah disediakan.</p>
                                    <p>2. Dikemukakan untuk pertimbangan dan tindakan tuan/puan selanjutnya.</p>
                                    <br><br>
                                    <p>Terima Kasih</p>
                                    <br><br>
                                    <p>Yang Benar,</p>
                                    <br><br><br><br>
                                    <p>...................................................................................</p>
                                    <p>(Tandatangan Pegawai Perpaduan Daerah / Bahagian)</p>
                                    <p>Nama : <b>Administor</b></p>
                                    <p>Tarikh : <b>02/11/2020</b></p>
                                    <br><br>
                                    <p>Disokong</p>
                                    <p>...................................................................................................................................................................................................................................................................................................................................................................................................................</p>
                                    <p>...................................................................................................................................................................................................................................................................................................................................................................................................................</p>
                                    <br><br><br><br>
                                    <p>...................................................................................</p>
                                    <p>(Tandatangan Pengarah Perpaduan Negeri)</p>
                                    <p>Nama : <b>Administor</b></p>
                                    <p>Tarikh : <b>02/11/2020</b></p><br><br>
                                </div>
                                <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm3.pengesahan_permohonan_krt_baharu')}}';">Kembali</button>&nbsp;
                                <button type="submit" class="btn btn-primary" onclick="window.location.href = '{{route('rt-sm3.pengesahan_permohonan_krt_hq_1')}}';">Seterusnya</button>
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

@include('js.rt-sm4.j-borang-pendaftaran-eIDRT')