@extends('layout.master')
@section('parentPageTitle', 'HRMS')
@section('title', 'JANA SURAT KELULUSAN & NOTIS PEMBATALAN RT')


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
                                    <p>Rujukan Kami : <b>PRT0303013</b></p>
                                    <p>Tarikh : <b>02/11/2020</b></p>
                                    <br>
                                    <p>Pegawai Perpaduan Negeri</p>
                                    <br><br><br>
                                    <p>Tuan,</p>
                                    <br><br>
                                    <p><b>KELULUSAN PERMOHONAN PEMBATALAN PENETAPAN KAWASAN RUKUN TETANGGA KRT TAMAN PELADANG JAYA</b></p>
                                    <br>
                                    <p>Dengan segala hormatnya perkara tersebut di atas adalah dirujuk dan surat permohonan pembatalan Kawasan Rukun Tetangga tuan (<b>PRT0303013</b>) bertarikh <b>02/11/2020</b> adalah Berkaitan</p><br>
                                    <p>2. Sukacita dimaklumkan bahawa merujuk kepada Seksyen 10(1) Akta Rukun Tetangga 2012 yang menerangkan maksud "Ketua Pengarah boleh, pada bila-bila masa, melalui notis diiklankan mengikut apa-apa cara yang difikirkannya patut, membatalkan mana-mana penetapan Kawasan Rukun Tetangga yang dibuat dibawah seksyen 5".</p><br>
                                    <p>3. Sehubungan dengan itu, kerjasama tuan adalah dipohon untuk menyerahkan sesalinan Notis Pembatalan ke atas Kawasan Rukun Tetangga <b>KRT Taman Peladang Jaya</b> serta mengambil tindakan susulan seperti berikut :</p><br>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="row clearfix"> 
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <p>i. Memaklumkan kepada Pengerusi dan ahli-ahli Jawatankuasa Rukun Tetangga berkenaan</p>
                                                <p>ii. Memastikan semua bil dan hutang dijelaskan</p>
                                                <p>iii. Menutupkan Akuan Bank Rukun Tetangga dan jika ada baki hendaklah diserahkan kepada</p>
                                                <p>iv. Semua Aset Alih Rukun Tetangga handaklah diserahkan kepada</p>
                                                <p>v. Papan tanda Kawasan Rukun Tentangga (jika ada) hendaklah diturunkan.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    
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
                                <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm8.jana_surat_kelulusan_pembatalan_admin')}}';">Kembali</button>&nbsp;
                                <button type="submit" class="btn btn-primary">Jana Surat Kelulusan & Notis Pembatalan RT</button>
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

@include('js.rt-sm8.j-surat-kelulusan-pembatalan-krt-admin')