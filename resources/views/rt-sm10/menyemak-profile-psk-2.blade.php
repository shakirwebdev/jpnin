@extends('layout.master')
@section('title', 'PROFAIL DAN MAKLUMAT LOKASI B40')


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
                                                <h6><b>MAKLUMAT AM PROGRAM SAYANGI KOMUNITI (PSK)</b></h6>
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
                                                    <label class="form-label">Nama PSK : <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Nama PSK" value="PSK Kuala Perlis" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Alamat Lokasi PSK : <span class="text-red">*</span></label>
                                                    <textarea class="form-control" rows="4" disabled="">NO 10, Lorong 5, Taman Peladang Jaya,02000 Kuala Perlis, Perlis</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Jenis Kediaman : <span class="text-red">*</span></label>
                                                    <div class="custom-controls-stacked">
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="" disabled="">
                                                            <span class="custom-control-label">Rumah Perkampungan / Persendirian</span>
                                                        </label>
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="" disabled="">
                                                            <span class="custom-control-label">Flat / Rumah Pangsa</span>
                                                        </label>
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="" checked disabled="">
                                                            <span class="custom-control-label">Rumah Teres Kos Rendah</span>
                                                        </label>
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="" disabled="">
                                                            <span class="custom-control-label">Gabungan Jenis Perumahan</span>
                                                        </label>
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
                                                <h6><b>MAKLUMAT STATUS SEMAKAN PERANCANGAN</b></h6>
                                                <br><br>
                                                <div class="form-group">
                                                    <label class="form-label">Status: <span class="text-red">*</span></label>
                                                    <select class="form-control">
                                                        <option>-- Sila Pilih --</option>
                                                        <option>Disemak</option>
                                                        <option>Ditolak</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Catatan: </label>
                                                    <textarea class="form-control" id="" name="" rows="4"></textarea>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                <button type="submit" class="btn btn-primary pull-right">Hantar</button>
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
                                            <h6><b>MAKLUMAT PROFIL DAN LOKASI PROGRAM SAYANGI KOMUNITI (PSK)</b></h6>
                                            <br>
                                            <p>Langkah Yang Telah Dilaksanakan dan Cadangan Langkah Untuk Menangani Isu / Masalah Tersebut di Atas : <span class="text-red">*</span></p> 
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="cadangan_hadapi_masalah_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Isu / Masalah</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Langkah / Tindakan Diambil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Pelaksana</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Status Pelaksana</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <p>Pemimpin Tempatan dan Organisasi Tempatan : <span class="text-red">*</span></p> 
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="pemimpin_organisasi_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Nama Individu / Organisasi</font></label></th>
                                                                        <th width="45%"><label class="form-label"><font color="#113f50">Catatan</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <p>Gambar Lokasi, Komuniti dan Gambar AJK KRT Di Kawasan Berkenaan : <span class="text-red">*</span></p> 
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="gambar_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Tajuk</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Keterangan</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">File</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm10.menyemak_profile_psk')}}';"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
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
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
@stop

@include('js.rt-sm10.j-menyemak-profile-psk-2')
