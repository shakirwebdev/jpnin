@extends('layout.master')
@section('title', 'REKOD PROFIL AHLI JAWATAN KUASA CAWANGAN')


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
                                                <h6><b>MAKLUMAT AM SEJIWA</b></h6>
                                                <br>
                                                <div class="form-group">
                                                    <label class="form-label">Negeri: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Negeri" value="Perlis" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Daerah: <span class="text-red">*</span></label>
                                                    <select class="form-control">
                                                        <option>-- Sila Pilih --</option>
                                                        <option>Padang Besar</option>
                                                        <option>Arau</option>
                                                        <option>Kangar</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Nama Cawangan Jiran Wanita: <span class="text-red">*</span></label>
                                                    <select class="form-control">
                                                        <option>-- Sila Pilih --</option>
                                                        <option>Jiran Wanita Kuala Perlis</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Pusat Operasi SeJIWA: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Pusat Operasi SeJIWA" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <b>Tarikh Penubuhan SeJIWA</b>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                        <input type="text" name="" class="form-control" value="" placeholder="arikh Penubuhan Skuad" disabled="">
                                                        <div class="c_username invalid-feedback text-right"></div>
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
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <h6><b>MAKLUMAT PERANCANGAN AKTIVTI / PERKHIDMATAN</b></h6>
                                            <br>
                                            <div class="tab-content mt-3">
                                                <div class="alert alert-warning alert-dismissible fade show small" role="alert">
                                                    <div class="mb-10">
                                                        <code><span style="text-size: 16px;"><strong>Nota </strong></span></code>
                                                        <br><br>
                                                        1. Setiap Skuad Uniti adalah dikehendaki melaksanakan minima 2 jenis aktivti atau perkhidmatan setahun. 
                                                        <br>
                                                        <br>
                                                        2. Fokus perkhidmatan SeJIWA adalah jaringan networking, project-project ekonomi dan perkhidmatan sosial:
                                                    </div>
                                                </div>
                                            </div>    
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="series-frame">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Perancangan Aktivti / Perkhidmatan: </label>
                                                                    <input type="text" class="form-control" name="" placeholder="Nama Penuh">
                                                                </div>
                                                                <div class="form-group">
                                                                    <b>Tarikh</b>
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                        </div>
                                                                        <input type="text" name="" class="form-control" value="" placeholder="Tarikh">
                                                                        <div class="c_username invalid-feedback text-right"></div>
                                                                    </div>
                                                                </div> 
                                                                <div class="form-group">
                                                                    <label class="form-label">Kumpulan Sasaran: <span class="text-red">*</span></label>
                                                                    <input type="text" class="form-control" name="" placeholder="Kumpulan Sasaran">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Kerjasama: </label>
                                                                    <input type="text" class="form-control" name="" placeholder="Kerjasama">
                                                                </div>
                                                                <button type="submit" class="btn btn-primary pull-right">Tambah</button>
                                                            </div>
                                                            
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="perancangan_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Perancangan Aktivti/ Perkhidmatan</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Tarikh</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Kumpulan Sasaran</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Kerjasama</font></label></th>
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
                                            <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm10.perancangan_aktivti_sejiwa')}}';"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                            <button type="submit" class="btn btn-primary">Hantar</button>
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

@include('js.rt-sm10.j-add-perancangan-sejiwa-ppd')
