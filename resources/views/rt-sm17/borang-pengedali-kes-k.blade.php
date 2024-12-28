@extends('layout.master')
@section('title', 'Penyediaan Pengendalian Kes Srs')


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
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <h6><b>MAKLUMAT RONDAAN SRS</b></h6>
                                                    <br><br>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <p><span style="font-size:12px">Nama Skim Rondaan Sukarela (SRS)</span><br><b>SRS Taman Peladang Jaya</b></p>
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b>KRT Taman Peladang Jaya</b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b>No 10 Lorong 5,<br>Taman Peladang Jaya,<br>02000 Kuala Perlis</b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b>Perlis</b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b>Kangar</b></p>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <p><span style="font-size:12px">Tarikh Rondaan</span><br><b>10/01/2021</b></p>
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
                                                <h6><b>MAKLUMAT KES</b></h6>
                                                <br>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Kategori Kes: <span class="text-red">*</span></label>
                                                        <select class="form-control">
                                                            <option>-- Sila Pilih --</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Jenis Kes: <span class="text-red">*</span></label>
                                                        <select class="form-control">
                                                            <option>-- Sila Pilih --</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Keterangan Kes: <label><font color="red">*</font></label> </label>
                                                        <textarea id="summernote_1" name="summernote_1" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Bilangan Orang Yang Terlibat: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="Bilangan Orang">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Bilangan Yang Terlibat Mengikut Kaum: <span class="text-red">*</span></label>
                                                    </div>
                                                    <div class="series-frame">
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Kaum: <span class="text-red">*</span></label>
                                                                <select class="select2 custom-select" id="" name="">
                                                                    <option value="">-- Pilih Nama --</option>
                                                                    <option value="">Melayu</option>
                                                                    <option value="">Cina</option>
                                                                    <option value="">India</option>
                                                                </select>
                                                            </div> 
                                                            <div class="form-group">
                                                                <label class="form-label">Bilangan: </label>
                                                                <input type="text" class="form-control" name="" placeholder="Tahun Graduasi">
                                                            </div><br><br>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Jantina: </label>
                                                                <select class="select2 custom-select" id="" name="">
                                                                    <option value="">-- Pilih Nama --</option>
                                                                    <option value="">Lelaki</option>
                                                                    <option value="">Perempuan</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Umur: </label>
                                                                <input type="text" class="form-control" name="" placeholder="Tahun Graduasi">
                                                            </div>
                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-primary pull-right"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br/><br/>
                                                    <div class="table-responsive">
                                                        <table class="table thead-dark table-bordered table-striped" id="senarai_bilangan_kaum_table" style="width: 100%" border="1">
                                                            <thead>
                                                                <tr>
                                                                    <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Kaum</font></label></th>
                                                                    <th width="30%"><label class="form-label"><font color="#113f50">Bilangan</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Jantina</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Umur</font></label></th>
                                                                    <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="form-label">Kes dirujuk kepada: <span class="text-red">*</span></div>
                                                        <div class="custom-controls-stacked">
                                                            <label class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" class="custom-control-input" name="example-inline-radios" value="option1" checked>
                                                                <span class="custom-control-label">Polis</span>
                                                            </label>
                                                            <label class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" class="custom-control-input" name="example-inline-radios" value="option2">
                                                                <span class="custom-control-label">Jabatan Agama</span>
                                                            </label>
                                                            <label class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" class="custom-control-input" name="example-inline-radios" value="option3">
                                                                <span class="custom-control-label">PBT</span>
                                                            </label>
                                                            <label class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" class="custom-control-input" name="example-inline-radios" value="option3">
                                                                <span class="custom-control-label">AADK</span>
                                                            </label>
                                                            <label class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" class="custom-control-input" name="example-inline-radios" value="option3">
                                                                <span class="custom-control-label">Tiada Tindakan</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm17.penyediaan_pengedalian_kes_srs')}}';"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                    <button type="button" class="btn btn-secondary"><i class="dropdown-icon fa fa-save"></i>&nbsp;Simpan</button>
                                                    <button type="button" class="btn btn-primary">Hantar Maklumat Pengedalian Kes SRS&nbsp;&nbsp;<i class="dropdown-icon fa fa-send"></i></button>
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
    </div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@stop

@include('js.rt-sm17.j-borang-pengedali-kes-k')
