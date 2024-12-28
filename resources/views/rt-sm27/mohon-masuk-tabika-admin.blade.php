@extends('layout.master')
@section('title', 'Permohonan Kemasukan Tabika Perpaduan')


@section('content')
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
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="row clearfix">
                        <div class="col-lg-4 col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <h6><b>MAKLUMAT TABIKA PERPADUAN</b></h6>
                                            <br>
                                            <div class="form-group">
                                                <label class="form-label">Negeri: </label>
                                                <select class="form-control" name="" id="" disabled>
                                                    <option>PERLIS</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Daerah / Bahagian: </label>
                                                <select class="form-control" name="" id="" disabled>
                                                    <option>PERLIS</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Nama Tabika Perpaduan: </label>
                                                <select class="form-control" name="" id="">
                                                    <option>-- Sila Pilih --</option>
                                                </select>
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
                                        <h6><b>MAKLUMAT PERMOHONAN</b></h6>
                                        <br>
                                        <span><b>Bahagian A : Maklumat Murid</b></span>
                                        <hr>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="row clearfix">
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Penuh: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="Nama Penuh">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Sijil Lahir: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="No Sijil Lahir">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Agama: <span class="text-red">*</span></label>
                                                        <select class="form-control" name="" id="">
                                                            <option>-- Sila Pilih --</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Kaum: <span class="text-red">*</span></label>
                                                        <select class="form-control" name="" id="">
                                                            <option>-- Sila Pilih --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">No Mykid: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="No Mykid">
                                                    </div>
                                                    <div class="form-group">
                                                        <b>Tarikh Lahir: <span class="text-red">*</span></b>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                            </div>
                                                            <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="" id="" placeholder="Tarikh Lahir" data-date-format="dd/mm/yyyy">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Jantina: <span class="text-red">*</span></label>
                                                        <select class="form-control" name="" id="">
                                                            <option>-- Sila Pilih --</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Alahan / Masalah Kesihatan: <span class="text-red">(jika ada)</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="Alahan / Masalah Kesihatan">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Alamat Rumah: <span class="text-red">*</span></label>
                                                        <textarea class="form-control" rows="4" name="" placeholder="Alamat Rumah"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Jarak Rumah Ke Sekolah (KM): <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="Jarak Rumah Ke Sekolah (KM)">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <span><b>Bahagian B : Maklumat Ibu/Bapa/Penjaga</b></span>
                                        <hr>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="row clearfix">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <label class="form-label">Maklumat Bapa/Penjaga</label>
                                                    <br>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Nama: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="Nama">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Pekerjaan: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="Pekerjaan">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Sektor Pekerjaan: <span class="text-red">*</span></label>
                                                        <select class="form-control" name="" id="">
                                                            <option>-- Sila Pilih --</option>
                                                            <option>Swasta</option>
                                                            <option>Kerajaan</option>
                                                            <option>Sendiri</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Pendapatan Bulanan (RM): <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="Pendapatan Bulanan">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Kerakyatan: <span class="text-red">*</span></label>
                                                        <select class="form-control" name="" id="">
                                                            <option>-- Sila Pilih --</option>
                                                            <option>Warganegara</option>
                                                            <option>Penduduk Tetap</option>
                                                            <option>Bukan Warganegara</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Jumlah Pendapatan Bulanan (RM): <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="Jumlah Pendapatan Bulanan">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">No Kad Pengenalan: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="No Kad Pengenalan">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Alamat Tempat Kerja: <span class="text-red">*</span></label>
                                                        <textarea class="form-control" rows="5" name="" placeholder="Alamat Tempat Kerja"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Telefon Pejabat: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="No Telefon Pejabat">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Telefon Bimbit: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="No Telefon Bimbit">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Telefon Rumah: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="No Telefon Rumah">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <br>
                                        <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                        <button type="button" class="btn btn-primary" id="btn_next">Seterusnya&nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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

@include('js.rt-sm27.j-mohon-masuk-tabika-admin')