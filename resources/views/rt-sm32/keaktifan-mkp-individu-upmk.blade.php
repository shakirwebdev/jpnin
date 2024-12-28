@extends('layout.master')
@section('title', 'Paparan Keaktifan Mediator Komuniti')


@section('content')
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="user-list" role="tabpanel">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT MKP</b></h6>
                                                <br>
                                                <div class="form-group">
                                                    <label class="form-label">Nama: </label>
                                                    <input type="text" class="form-control" name="kmpd_mkp_nama" id="kmpd_mkp_nama" placeholder="No Kad Pengenalan" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Kad Pengenalan: </label>
                                                    <input type="text" class="form-control" name="kmpd_mkp_no_ic" id="kmpd_mkp_no_ic" placeholder="No Kad Pengenalan" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Telefon: </label>
                                                    <input type="text" class="form-control" name="kmpd_mkp_no_phone" id="kmpd_mkp_no_phone" placeholder="No Telefon" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Alamat Email: </label>
                                                    <input type="text" class="form-control" name="kmpd_mkp_email" id="kmpd_mkp_email" placeholder="Alamat Email" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <h6><b>MAKLUMAT KRITERIA PENILAIAN KEAKTIFAN MEDIATOR</b></h6>
                                            <br>
                                            <p>1. Kes Mediasi Yang Telah Dikendalikan : </p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_kes_mediasi_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Bil</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Kes Mediasi</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Status</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Peringkat</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br><br>
                                            <p>2. Aktiviti / Program Sosial / Kemasyarakatan : </p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_aktiviti_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Bil</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Nama Aktiviti</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Tarikh</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Tempat</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Jawatan</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Peringkat</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br><br>
                                            <p>3. Latihan / Kursus Pembangunan Diri : </p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_latihan_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Bil</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Nama Latihan</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Tarikh</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Tempat</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Penganjur</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Peringkat</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br><br>
                                            <p>3. Latihan / Kursus Pembangunan Diri : </p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_sumbangan_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Bil</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Sumbangan / Pengiktirafan</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Peringkat</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br><br>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                        </div>
                                    </div>
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
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@stop

@include('js.rt-sm32.j-keaktifan-mkp-individu-upmk')
