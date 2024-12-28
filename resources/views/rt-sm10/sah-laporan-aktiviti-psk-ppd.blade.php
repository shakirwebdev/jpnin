@extends('layout.master')
@section('title', 'BORANG LAPORAN AKTIVITI PERPADUAN')


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
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Bahagian : <span class="text-red">*</span></label>
                                                        <select class="form-control" disabled="">
                                                            <option>-- Sila Pilih --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">PMK : <span class="text-red">*</span></label>
                                                        <select class="form-control" disabled="">
                                                            <option>-- Sila Pilih --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Tajuk Aktiviti : </label>
                                                        <input type="text" class="form-control" name="" placeholder="Tajuk Aktiviti" value="Hari Sukan Negara" disabled="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <b>Tarikh Rancang</b>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                            </div>
                                                            <input type="text" name="" class="form-control" placeholder="Tarikh Rancang" value="1/11/2020" disabled="">
                                                            <div class="c_username invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <b>Tarikh Pelaksanaan</b>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                            </div>
                                                            <input type="text" name="" class="form-control" value="1/12/2020" placeholder="Tarikh Pelaksanaan" disabled="">
                                                            <div class="c_username invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <b>Masa</b>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fa fa-clock-o"></i></span>
                                                            </div>
                                                            <input type="text" name="" class="form-control" value="08:00:00" placeholder="Masa" disabled="">
                                                            <div class="c_username invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Tempat : <span class="text-red">*</span></label>
                                                        <div class="custom-controls-stacked">
                                                            <label class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" name="" checked="" disabled="">
                                                                <span class="custom-control-label">Kawasan Rukun Tetangga</span>
                                                            </label>
                                                            <label class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" name="" checked="" disabled="">
                                                                <span class="custom-control-label">Luar Kawasan Rukun Tetangga</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Bidang Aktiviti : <span class="text-red">*</span></label>
                                                        <select class="form-control" disabled="">
                                                            <option>Sukan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Kategori Aktiviti : <span class="text-red">*</span></label>
                                                        <select class="form-control" disabled="">
                                                            <option>-- Sila Pilih --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Anjuran Aktiviti : <span class="text-red">*</span></label>
                                                        <select class="form-control" disabled="">
                                                            <option>-- Sila Pilih --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <p>Rakan Perpaduan : <span class="text-red">*</span></p> 
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="pecahan_kaum_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%" rowspan="2"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th rowspan="2"><label class="form-label"><font color="#113f50">Rakan Perpaduan</font></label></th>
                                                                        <th colspan="2"><label class="form-label text-center"><font color="#113f50">Bentuk Sumbangan</font></label></th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th><label class="form-label"><font color="#113f50">Kewangan (RM)</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Lain-Lain (Nyatakan)</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm10.senarai_laporan_aktivti_psk_ppd')}}';"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                        <button type="button" class="btn btn-primary" onclick="window.location.href = '{{route('rt-sm10.sah_laporan_aktiviti_psk_ppd_1')}}';">Seterusnya&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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

@include('js.rt-sm10.j-sah-laporan-aktiviti-psk-ppd')
