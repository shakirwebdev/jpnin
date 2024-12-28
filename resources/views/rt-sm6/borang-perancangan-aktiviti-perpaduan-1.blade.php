@extends('layout.master')
@section('title', 'Penyediaan Perancangan Aktiviti Perpaduan')


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
                                                            <select class="form-control">
                                                                <option>-- Sila Pilih --</option>
                                                                <option>Lelaki</option>
                                                                <option>Perempuan</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Daerah: <span class="text-red">*</span></label>
                                                            <select class="form-control">
                                                                <option>-- Sila Pilih --</option>
                                                                <option>Lelaki</option>
                                                                <option>Perempuan</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Tempat: <span class="text-red">*</span></label>
                                                            <textarea class="form-control" rows="4" placeholder="Tempat"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-radio">
                                                                    <input type="radio" class="custom-control-input" name="example-radios" value="option1" checked>
                                                                    <div class="custom-control-label">Kawasan Rukun Tetangga</div>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input type="radio" class="custom-control-input" name="example-radios" value="option2">
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
                                                    <label class="form-label">Penyertaan : <span class="text-red">*</span></label>
                                                </div>
                                                <div class="series-frame">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Komposisi Kaum: </label>
                                                            <select class="form-control">
                                                                <option>-- Sila Pilih --</option>
                                                                <option>Melayu</option>
                                                                <option>Cina</option>
                                                                <option>India</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Pilih Jantina: </label>
                                                            <select class="form-control">
                                                                <option>-- Sila Pilih --</option>
                                                                <option>Melayu</option>
                                                                <option>Cina</option>
                                                                <option>India</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Umur: </label>
                                                            <select class="form-control">
                                                                <option>-- Sila Pilih --</option>
                                                                <option>0 - 6</option>
                                                                <option>7 - 12</option>
                                                                <option>13 - 17</option>
                                                                <option>18 - 35</option>
                                                                <option>36 - 45</option>
                                                                <option>45 - 59</option>
                                                                <option>60 Keatas</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                                <label class="form-label">Jumlah (Bil. Orang): </label>
                                                                <input type="text" class="form-control" name="" placeholder="Jumlah (Bil. Orang)">
                                                            </div>
                                                        <button type="submit" class="btn btn-primary pull-right"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                    </div>
                                                </div>
                                                <br/><br/>
                                                <div class="table-responsive">
                                                    <table class="table thead-dark table-bordered table-striped" id="senarai_kaum_table" style="width: 100%" border="1">
                                                        <thead>
                                                            <tr>
                                                                <th width="6%" rowspan="2"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                <th rowspan="2"><label class="form-label"><font color="#113f50">Kaum</font></label></th>
                                                                <th colspan="2"><label class="form-label text-center"><font color="#113f50">Jantina</font></label></th>
                                                                <th colspan="7"><label class="form-label text-center"><font color="#113f50">Umur</font></label></th>
                                                                <th rowspan="2"><label class="form-label"><font color="#113f50">Jumlah (Bil. Orang)</font></label></th>
                                                                <th rowspan="2" width="6%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                            </tr>
                                                            <tr>
                                                                <th><label class="form-label"><font color="#113f50">Lelaki</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">Perempuan</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">0 - 6</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">07 - 12</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">13 - 17</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">18 - 35</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">36 - 45</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">45 - 59</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">60 Keatas</font></label></th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Rakan Perpaduan : <span class="text-red">*</span></label>
                                                </div>
                                                <div class="series-frame">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Rakan Perpaduan: </label>
                                                            <select class="form-control">
                                                                <option>-- Sila Pilih --</option>
                                                                <option>RT</option>
                                                                <option>MPKK</option>
                                                                <option>MPP</option>
                                                                <option>RA</option>
                                                                <option>Agensi Kerajaan</option>
                                                                <option>Media</option>
                                                                <option>Pusat Membeli Belah</option>
                                                                <option>Swasta</option>
                                                                <option>Institusi Pendidikan</option>
                                                                <option>NGO</option>
                                                                <option>CSO Agama</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Bentuk Sumbangan: </label>
                                                            <select class="form-control">
                                                                <option>-- Sila Pilih --</option>
                                                                <option>Kewangan (RM)</option>
                                                                <option>Lain - Lain</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Jumlah : </label>
                                                            <input type="text" class="form-control" name="" placeholder="Jumlah">
                                                        </div>
                                                        <button type="submit" class="btn btn-primary pull-right"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                    </div>
                                                </div>
                                                <br/><br/>
                                                <div class="table-responsive">
                                                    <table class="table thead-dark table-bordered table-striped" id="rakan_perpaduan_table" style="width: 100%" border="1">
                                                        <thead>
                                                            <tr>
                                                                <th width="6%" rowspan="2"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                <th rowspan="2"><label class="form-label"><font color="#113f50">Rakan Perpaduan</font></label></th>
                                                                <th colspan="2"><label class="form-label text-center"><font color="#113f50">Bentuk Sumbangan</font></label></th>
                                                                <th rowspan="2" width="6%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                            </tr>
                                                            <tr>
                                                                <th><label class="form-label"><font color="#113f50">Kewangan (RM)</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">Lain-lain (Nyatakan)</font></label></th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm6.borang_perancangan_aktiviti_perpaduan')}}';"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="button" class="btn btn-secondary"><i class="dropdown-icon fa fa-save"></i>&nbsp;Simpan</button>
                                                <button type="button" class="btn btn-primary" onclick="window.location.href = '{{route('rt-sm6.borang_perancangan_aktiviti_perpaduan_2')}}';">Seterusnya&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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
@stop

@include('js.rt-sm6.j-borang-perancangan-aktiviti-perpaduan-1')
