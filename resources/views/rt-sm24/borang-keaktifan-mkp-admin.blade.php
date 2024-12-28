@extends('layout.master')
@section('title', 'Borang Keaktifan Mediator Komuniti')


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
                                                <h6><b>MAKLUMAT MKP</b></h6>
                                                <br>
                                                <div class="form-group">
                                                    <label class="form-label">Nama: </label>
                                                    <input type="text" class="form-control" name="" placeholder="Nama" value="Mohamad Shauki Bin Sahardi" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Kad Pengenalan: </label>
                                                    <input type="text" class="form-control" name="" placeholder="No Kad Pengenalan" value="930508095161" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Telefon: </label>
                                                    <input type="text" class="form-control" name="" placeholder="No Telefon" value="0124470470" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Nama KRT: <span class="text-red">*</span></label>
                                                    <select class="select2 custom-select" id="" name="">
                                                        <option value="">-- Sila Pilih --</option>
                                                        <option value="">KRT Taman Peladang Jaya</option>
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
                                            <h6><b>MAKLUMAT KRITERIA PENILAIAN KEAKTIFAN MEDIATOR</b></h6>
                                            <br>
                                            <p>1. Kes Mediasi Yang Telah Dikendalikan: <span class="text-red">*</span></p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="series-frame">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Kes Mediasi: </label>
                                                                    <select class="select2 custom-select" id="" name="">
                                                                        <option value="">-- Sila Pilih --</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Status: </label>
                                                                    <select class="select2 custom-select" id="" name="">
                                                                        <option value="">-- Sila Pilih --</option>
                                                                        <option value="">Selesai</option>
                                                                        <option value="">Tidak Selesai</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Peringkat: </label>
                                                                    <select class="select2 custom-select" id="" name="">
                                                                        <option value="">-- Sila Pilih --</option>
                                                                        <option value="">Komuniti</option>
                                                                        <option value="">Jabatan</option>
                                                                        <option value="">Daerah</option>
                                                                        <option value="">Negeri</option>
                                                                        <option value="">Negara</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Bilangan: </label>
                                                                    <input type="text" class="form-control" name="" placeholder="Bilangan">
                                                                </div>
                                                                <button type="submit" class="btn btn-primary pull-right">Tambah</button>
                                                            </div>
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_kes_mediasi_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Kes Mediasi</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Status</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Peringkat</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Bilangan</font></label></th>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <p>2. Aktiviti / Program Sosial / Kemasyarakatan: <span class="text-red">*</span></p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="series-frame">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Nama Aktiviti / Program: </label>
                                                                    <input type="text" class="form-control" name="" placeholder="Nama Aktiviti / Program">
                                                                </div>
                                                                <div class="form-group">
                                                                    <b>Tarikh: </b>
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                        </div>
                                                                        <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="" id="" placeholder="Tarikh" data-date-format="dd/mm/yyyy">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Tempat: </label>
                                                                    <input type="text" class="form-control" name="" placeholder="Tempat">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Jawatan: </label>
                                                                    <select class="select2 custom-select" id="" name="">
                                                                        <option value="">-- Sila Pilih --</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Peringkat: </label>
                                                                    <select class="select2 custom-select" id="" name="">
                                                                        <option value="">-- Sila Pilih --</option>
                                                                        <option value="">Komuniti</option>
                                                                        <option value="">Jabatan</option>
                                                                        <option value="">Daerah</option>
                                                                        <option value="">Negeri</option>
                                                                        <option value="">Negara</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Bilangan: </label>
                                                                    <input type="text" class="form-control" name="" placeholder="Bilangan">
                                                                </div>
                                                                <button type="submit" class="btn btn-primary pull-right">Tambah</button>
                                                            </div>
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_aktiviti_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Nama Aktiviti</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Tarikh</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Tempat</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Jawatan</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Peringkat</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Bilangan</font></label></th>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-secondary" disabled><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
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
    </div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@stop

@include('js.rt-sm24.j-borang-keaktifan-mkp-admin')
