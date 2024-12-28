@extends('layout.master')
@section('title', 'Jana Laporan Perancangan Aktiviti PERPADUAN')


@section('content')
    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                &nbsp;
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>&nbsp;</div>
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
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <h6><b>MAKLUMAT TEMPAT AKTIVITI PERPADUAN</b></h6>
                                                    <br><br>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Negeri: <span class="text-red">*</span></label>
                                                            <select class="form-control" disabled="">
                                                                <option>Perlis</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Daerah: <span class="text-red">*</span></label>
                                                            <select class="form-control" disabled="">
                                                                <option>Kangar</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Tempat: <span class="text-red">*</span></label>
                                                            <textarea class="form-control" rows="4" placeholder="Tempat" disabled="">Dewan Rakyat Taman Peladang Jaya 02000 Kuala Perlis</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-radio">
                                                                    <input type="radio" class="custom-control-input" name="example-radios" value="option1" checked disabled="">
                                                                    <div class="custom-control-label">Kawasan Rukun Tetangga</div>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input type="radio" class="custom-control-input" name="example-radios" value="option2" disabled="">
                                                                    <div class="custom-control-label">Luar Kawasan Rukun Tetangga</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT STATUS PENGESAHAN</b></h6>
                                                <br><br>
                                                <div class="form-group">
                                                    <label class="form-label">Status: <span class="text-red">*</span></label>
                                                    <select class="form-control" disabled="">
                                                        <option>-- Sila Pilih --</option>
                                                        <option>Disahkan</option>
                                                        <option>Perlu Dikemaskini</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Penerangan: <span class="text-red">*</span></label>
                                                    <textarea class="form-control" rows="4" disabled=""></textarea>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group pull-right">
                                                        <button type="submit" class="btn btn-primary">Jana Laporan&nbsp;&nbsp;<i class="dropdown-icon fa fa-print"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <div class="col-lg-8 col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <h6><b>MAKLUMAT AKTIVITI PERPADUAN</b></h6>
                                                <br>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">Ringkasan Program: <br><label><font color="red">(tidak lebih 100 perkataan)</font></label> </label>
                                                    <textarea id="summernote_1" name="summernote_1" class="form-control"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Kaedah Penilaian: <label><font color="red">*</font></label> </label>
                                                </div>
                                                <div class="form-group">
                                                    <div class="custom-controls-stacked">
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="" checked="" disabled="">
                                                            <span class="custom-control-label"><i>Post Mortem</i> : perbincangan tentang kelibihan, kekurangan dan cadangan penambahbaikan</span>
                                                        </label>
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="" disabled="">
                                                            <span class="custom-control-label">Soal Slidik : Pengukuran Program Perpaduan / Penilaian kursus</span>
                                                        </label>
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="" disabled="">
                                                            <span class="custom-control-label">Pemerhatian</span>
                                                        </label>
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="" disabled="">
                                                            <span class="custom-control-label">Temubual</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Kekuatan / Kelemahan Aktiviti: <br><label><font color="red">(tidak lebih 100 perkataan)</font></label> </label>
                                                    <textarea id="summernote_2" name="summernote_2" class="form-control"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Impak / Keberkesanan Aktiviti: <br><label><font color="red">(tidak lebih 100 perkataan)</font></label> </label>
                                                    <textarea id="summernote_3" name="summernote_3" class="form-control"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Cadangan Penambahbaikan: <br><label><font color="red">(tidak lebih 100 perkataan)</font></label> </label>
                                                    <textarea id="summernote_4" name="summernote_4" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm6.view_pengesahan_borang_perancangan_aktiviti_1')}}';"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="button" class="btn btn-secondary" disabled="">Seterusnya&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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
    </div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@stop

@include('js.rt-sm6.j-view-pengesahan-borang-perancangan-aktiviti-2')
