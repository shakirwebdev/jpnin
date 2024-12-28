@extends('layout.master')
@section('title', 'Permohonan Laporan Kes Mediasi')


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
                                                <h6><b>MAKLUMAT MEDIATOR</b></h6>
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT PEMBANTU MEDIATOR</b></h6>
                                                <br>
                                                <div class="form-group">
                                                    <label class="form-label">Nama: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Nama" >
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Kad Pengenalan: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="No Kad Pengenalan" >
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Telefon: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="No Telefon" >
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
                                            <h6><b>MAKLUMAT KES MEDIASI</b></h6>
                                            <br>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">No Telefon: <span class="text-red">*</span></label>
                                                            <select class="form-control" id="" name="">
                                                                <option>-- Sila Pilih --</option>
                                                                <option>Kejiranan</option>
                                                                <option>Hubungan Kekeluargaan</option>
                                                                <option>Harta</option>
                                                                <option>Alam Sekitar</option>
                                                                <option>Kepenggunaan</option>
                                                                <option>Kesihatan (kecuaian)</option>
                                                                <option>Perjanjian / Kontrak</option>
                                                                <option>Harta Intelek</option>
                                                                <option>Pembinaan dan Kejuteraan</option>
                                                                <option>Pelbagai Isu Agama</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <b>Tarikh Mediasi: <span class="text-red">*</span></b>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                                <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="" id="" placeholder="Tarikh Mediasi" data-date-format="dd/mm/yyyy">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Tempat Mediasi: <span class="text-red">*</span></label>
                                                            <textarea class="form-control" rows="4" name="" placeholder="Tempat Mediasi"></textarea>
                                                        </div>
                                                    </div>
                                                    <p>1. Pihak Pertama Terlibat: <span class="text-red">*</span></p>
                                                    <hr class="mt-1">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="series-frame">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Nama Pihak Pertama: </label>
                                                                    <input type="text" class="form-control" name="" placeholder="Nama Pihak Pertama">
                                                                </div>
                                                                <button type="submit" class="btn btn-primary pull-right">Tambah</button>
                                                            </div>
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_pihak_pertama_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Nama</font></label></th>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <p>2. Pihak Kedua Terlibat: <span class="text-red">*</span></p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="series-frame">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Nama Pihak Kedua: </label>
                                                                    <input type="text" class="form-control" name="" placeholder="Nama Pihak Kedua">
                                                                </div>
                                                                <button type="submit" class="btn btn-primary pull-right">Tambah</button>
                                                            </div>
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_pihak_kedua_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Nama</font></label></th>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Agensi / NGO Terlibat: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="" placeholder="Agensi / NGO Terlibat">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Ringkasan Kes / Isu: <span class="text-red">*</span></label>
                                                            <textarea class="form-control" rows="4" name="" placeholder="Ringkasan Kes / Isu"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">No Telefon: <span class="text-red">*</span></label>
                                                            <select class="form-control" id="" name="">
                                                                <option>-- Sila Pilih --</option>
                                                                <option>Berjaya</option>
                                                                <option>Tidak Berjaya</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                            <button type="button" class="btn btn-primary" >Hantar Permohonan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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

@include('js.rt-sm26.j-permohonan-laporan-kes-mediasi-admin-1')
