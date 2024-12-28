@extends('layout.master')
@section('title', 'BORANG LAPORAN ISU DAN MASALAH DI LOKASI PSK')


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
                                                <h6><b>MAKLUMAT AM LAPORAN ISU DAN MASALAH</b></h6>
                                                <br>
                                                <div class="form-group">
                                                    <label class="form-label">Tahun : <span class="text-red">*</span></label>
                                                    <select class="form-control">
                                                        <option>-- Sila Pilih--</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Negeri : </label>
                                                    <select class="form-control" disabled="">
                                                        <option>Perlis</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Daerah : </label>
                                                    <select class="form-control" disabled="">
                                                        <option>Kangar</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Lokasi PSK : <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Lokasi PSK">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Kluster dan masalah : <span class="text-red">*</span></label>
                                                    <select class="form-control">
                                                        <option>-- Sila Pilih --</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Bilangan Yang Terlibat : <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Bilangan Yang Terlibat">
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
                                            <h6><b>MAKLUMAT LAPORAN ISU DAN MASALAH DI LOKASI PSK</b></h6>
                                            <br>
                                            <p>Bilangan Yang Terlibat Mengikut Kaum : <span class="text-red">*</span></p> 
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="series-frame">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Bilangan : </label>
                                                                    <input type="text" class="form-control" name="" placeholder="Bilangan">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Kaum : </label>
                                                                    <select class="form-control">
                                                                        <option>-- Sila Pilih --</option>
                                                                        <option>Melayu</option>
                                                                        <option>Cina</option>
                                                                        <option>India</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Jantina : </label>
                                                                    <select class="form-control">
                                                                        <option>-- Sila Pilih --</option>
                                                                        <option>Lelaki</option>
                                                                        <option>Perempuan</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Umur : </label>
                                                                    <input type="text" class="form-control" name="" placeholder="Umur">
                                                                </div>
                                                                <button type="submit" class="btn btn-primary pull-right">Tambah</button>
                                                            </div>
                                                            
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="pecahan_kaum_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Kaum</font></label></th>
                                                                        <th><label class="form-label text-center"><font color="#113f50">Jantina</font></label></th>
                                                                        <th><label class="form-label text-center"><font color="#113f50">Umur</font></label></th>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <p>Tindakan Penyelesaian oleh : <span class="text-red">*</span></p> 
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">i) Jawatankuasa Pelaksanaan PSK Peringkat Daerah :<label><font color="red">*</font></label> </label>
                                                    <textarea id="summernote_1" name="summernote_1" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm10.senarai_laporan_isu_psk')}}';"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                        <button type="button" class="btn btn-primary"><i class="dropdown-icon fa fa-paper-plane"></i>&nbsp;Hantar</button>
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

@include('js.rt-sm10.j-add-laporan-isu-psk')
