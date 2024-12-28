@extends('layout.master')
@section('title', 'Pendaftaran Mediator Komuniti')


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
                                                <h6><b>MAKLUMAT KAWASAN RUKUN TETANGGA</b></h6>
                                                <br>
                                                <div class="form-group">
                                                    <label class="custom-switch">
                                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="custom-switch-description">Dalam Kawasan KRT</span>
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Negeri: </label>
                                                    <select class="select2 custom-select" id="" name="" disabled>
                                                        <option value="">-- Sila Pilih --</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Daerah: </label>
                                                    <select class="select2 custom-select" id="" name="" disabled>
                                                        <option value="">-- Sila Pilih --</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Nama KRT: </label>
                                                    <select class="select2 custom-select" id="" name="" disabled>
                                                        <option value="">-- Sila Pilih --</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Alamat KRT: </label>
                                                    <textarea class="form-control" id="" name="" rows="4" disabled="" placeholder="Alamat KRT"></textarea>
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
                                            <h6><b>MAKLUMAT DARI SUMBER YANG MUNGKIN BERLAKU</b></h6>
                                            <br>
                                            <p>1. Maklumat Pemohon : </p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Nama Pemohon: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="" placeholder="Nama Pemohon">
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
                                                            <select class="select2 custom-select" id="" name="">
                                                                <option value="">-- Sila Pilih --</option>
                                                                <option value="">Lelaki</option>
                                                                <option value="">Perempuan</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Kaum: <span class="text-red">*</span></label>
                                                            <select class="select2 custom-select" id="" name="">
                                                                <option value="">-- Sila Pilih --</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Emel : <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="" placeholder="Emel">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Alamat Rumah: <span class="text-red">*</span></label>
                                                            <textarea class="form-control" id="" name="" rows="5" placeholder="Alamat Rumah">
                                                            </textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Alamat Pejabat: <span class="text-red">*</span></label>
                                                            <textarea class="form-control" id="" name="" rows="5" placeholder="Alamat Pejabat">
                                                            </textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Kategori MKP: <span class="text-red">*</span></label>
                                                            <select class="select2 custom-select" id="" name="">
                                                                <option value="">-- Sila Pilih --</option>
                                                                <option value="">Pegawai</option>
                                                                <option value="">Ahli Rukun Tetangga</option>
                                                                <option value="">Mediator Agama</option>
                                                                <option value="">NGO</option>
                                                                <option value="">Orang Awam</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Kelulusan Akademik: <span class="text-red">*</span></label>
                                                            <select class="select2 custom-select" id="" name="">
                                                                <option value="">-- Sila Pilih --</option>
                                                                <option value="">Doktor Falsafah (Phd)</option>
                                                                <option value="">Sarjana / Sarjana Muda</option>
                                                                <option value="">Diploma</option>
                                                                <option value="">Stpm dan Setaraf</option>
                                                                <option value="">SPM / SPVM dan Setaraf</option>
                                                                <option value="">PMK / SRP dan Setaraf</option>
                                                                <option value="">Sekolah Rendah</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">No Kad Pengenalan: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="" placeholder="No Kad Pengenalan">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Negeri: <span class="text-red">*</span></label>
                                                            <select class="select2 custom-select" id="" name="">
                                                                <option value="">-- Sila Pilih --</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Parlimen: <span class="text-red">*</span></label>
                                                            <select class="select2 custom-select" id="" name="">
                                                                <option value="">-- Sila Pilih --</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Dun: <span class="text-red">*</span></label>
                                                            <select class="select2 custom-select" id="" name="">
                                                                <option value="">-- Sila Pilih --</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">PBT: <span class="text-red">*</span></label>
                                                            <select class="select2 custom-select" id="" name="">
                                                                <option value="">-- Sila Pilih --</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Mukim: <span class="text-red">*</span></label>
                                                            <select class="select2 custom-select" id="" name="">
                                                                <option value="">-- Sila Pilih --</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Daerah: <span class="text-red">*</span></label>
                                                            <select class="select2 custom-select" id="" name="">
                                                                <option value="">-- Sila Pilih --</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">No Telefon : <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="" placeholder="No Telefon">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">No Telefon Pejabat : <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="" placeholder="No Telefon Pejabat">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Tahap MKP: <span class="text-red">*</span></label>
                                                            <select class="select2 custom-select" id="" name="">
                                                                <option value="">-- Sila Pilih --</option>
                                                                <option value="">Mediator Pelatih</option>
                                                                <option value="">Mediator</option>
                                                                <option value="">Senior Mediator</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Pengkhususan (kemahiran): <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="" placeholder="Pengkhususan">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <p>2. Maklumat Kursus Yang Dihadiri : <span class="text-red">*</span></p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="series-frame">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Nama Kursus : </label>
                                                                    <input type="text" class="form-control" name="" placeholder="Isu / Masalah">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Kategori Kursus: </label>
                                                                    <select class="select2 custom-select" id="" name="">
                                                                        <option value="">-- Sila Pilih --</option>
                                                                        <option value="">Tahap 1</option>
                                                                        <option value="">Tahap 2</option>
                                                                        <option value="">Tahap 3</option>
                                                                        <option value="">Tahap 4</option>
                                                                        <option value="">Conferensing Case</option>
                                                                        <option value="">Pentaulihan</option>
                                                                        <option value="">Simposium</option>
                                                                        <option value="">Refseshing</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Peringkat Kursus: </label>
                                                                    <select class="select2 custom-select" id="" name="">
                                                                        <option value="">-- Sila Pilih --</option>
                                                                        <option value="">Ibu Pejabat</option>
                                                                        <option value="">Negeri</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Penganjur : </label>
                                                                    <input type="text" class="form-control" name="" placeholder="Status Pelaksana">
                                                                </div>
                                                                <button type="submit" class="btn btn-primary pull-right">Tambah</button>
                                                            </div>
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_kursus_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Nama Kursus</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Kategori Kursus</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Peringkat Kursus</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Penganjur</font></label></th>
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
                                            <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                            <button type="button" class="btn btn-primary" id="btn_submit">Hantar Permohonan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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

@include('js.rt-sm23.j-permohonan-mkp-admin-1')
