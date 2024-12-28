@extends('layout.master')
@section('title', 'SEMAKAN BORANG LAPORAN AKTIVITI PERPADUAN')


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
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <small>Isi maklumat pada borang yang disediakan dibawah, dan tekan butang HANTAR. 
                        <br>
                        Ruangan bertanda <span class="text-red">*</span> adalah ruangan mandatori dan perlu diisi..&nbsp;&nbsp;<a href="#"><i class="dropdown-icon fe fe-help-circle"></i></a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                                                <h6><b>MAKLUMAT AM LAPORAN AKTIVITI</b></h6>
                                                <br>
                                                <div class="form-group">
                                                    <label class="form-label">Negeri : </label>
                                                    <select class="form-control" disabled="">
                                                        <option>Perlis</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Daerah : <span class="text-red">*</span></label>
                                                    <select class="form-control" disabled="">
                                                        <option>Kangar</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Penganjur : <span class="text-red">*</span></label>
                                                    <select class="form-control" disabled="">
                                                        <option value="krt">KRT</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Nama KRT : <span class="text-red"><br> (Wajib diisi sekiranya penganjur adalah KRT)</span></label>
                                                    <select class="form-control" disabled="">
                                                        <option>KRT Taman Peladang Jaya</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT STATUS SEMAKAN LAPORAN AKTIVITI</b></h6>
                                                <br><br>
                                                <div class="form-group">
                                                    <label class="form-label">Status: <span class="text-red">*</span></label>
                                                    <select class="form-control">
                                                        <option>-- Sila Pilih --</option>
                                                        <option>Disahkan</option>
                                                        <option>Ditolak</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Catatan: </label>
                                                    <textarea class="form-control" id="" name="" rows="4"></textarea>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                <button type="submit" class="btn btn-secondary pull-right" disabled="">Hantar</button>
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
                                            <h6><b>MAKLUMAT LAPORAN AKTIVITI</b></h6>
                                            <br>
                                            <div class="row clearfix">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Impak / Keberkesanan :<br/><label><font color="red">(tidak lebih 100 perkataan)</font></label> </label>
                                                        <textarea id="summernote_3" name="summernote_3" class="form-control">TEST</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Cadangan Penambahanaikan :<br/><label><font color="red">(tidak lebih 100 perkataan)</font></label> </label>
                                                        <textarea id="summernote_4" name="summernote_4" class="form-control">TEST</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm10.sah_laporan_aktiviti_psk_ppd_1')}}';"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                        <button type="button" class="btn btn-primary" onclick="window.location.href = '{{route('rt-sm10.sah_laporan_aktiviti_psk_ppd_3')}}';">Seterusnya&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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
@stop

@include('js.rt-sm10.j-sah-laporan-aktiviti-psk-ppd-2')
