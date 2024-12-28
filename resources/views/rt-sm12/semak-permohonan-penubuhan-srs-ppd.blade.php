@extends('layout.master')
@section('title', 'Semak Permohonan Penubuhan SRS')


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
                                    <p>Kepada</p>
                                    <br>
                                    <p>Pegawai Perpaduan Negara dan Integrasi Nasional</p>
                                    <p>Daerah / Bahagian</p>
                                    <p><b><span id="sppsp_daerah" name="sppsp_daerah"></span></b></p>
                                    <br>
                                    <p>Tuan / Puan</p>
                                    <br><br>
                                    <p><b>PERMOHONAN PENUBUHAN SKIM RONDAAN SUKARELA</b></p>
                                    <br>
                                    <p>Saya mewakili Jawatankuasa Rukun Tertangga <b><span id="sppsp_nama_krt" name="sppsp_nama_krt"></span></b> memohon supaya SRS dapat diwujudkan di kawasan ini. Keputusan untuk mewujudkan SRS ini telah dibuat dan dipersetujui dalam Mesyuarat Jawatankuasa pada .</p>
                                    <p>Bersama-sama ini disertakan <b>Borang SRS 02</b>.</p>
                                    <p>2. Dikemukakan untuk pertimbangan dan tindakan tuan/puan selanjutnya.</p>
                                    <br><br>
                                    <p>Terima Kasih</p>
                                    <br><br>
                                    <p>Yang Benar,</p>
                                    <br><br><br><br>
                                    <p>...................................................................................</p>
                                    <p>(Pengerusi Rukun Tertangga)</p>
                                    <p>Nama : <b><span id="sppsp_nama_pengerusi" name="sppsp_nama_pengerusi"></span></b></p>
                                    <p>Tarikh : <b><span id="sppsp_tarikh_srs_dimohon" name="sppsp_tarikh_srs_dimohon"></span></b></p><br><br>
                                </div>
                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>&nbsp;
                                <button type="submit" class="btn btn-primary" id="btn_next">Seterusnya&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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

@include('js.rt-sm12.j-semak-permohonan-penubuhan-srs-ppd')
