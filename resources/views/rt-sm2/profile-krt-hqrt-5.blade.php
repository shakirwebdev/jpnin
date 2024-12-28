@extends('layout.master')
@section('parentPageTitle', 'HRMS')
@section('title', 'Paparan Profil KRT')


@section('content')
@include('modal.modal-view-binaan-jambatan')
@include('modal.modal-view-bagunan-tumpang')
@include('modal.modal-view-bagunan-sewa')
@include('modal.modal-view-kabin-sedia-ada')
@include('modal.modal-view-cadangan-pembinaan-prt')
    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                &nbsp;
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
                                                <h6><b>MAKLUMAT AM KRT</b></h6>
                                                <br>
                                                <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span name="kpk_krt_nama" id="kpk_krt_nama"></span></b></p>
                                                <br>
                                                <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span name="kpk_krt_alamat" id="kpk_krt_alamat"></span></b></p>
                                                <br>
                                                <p><span style="font-size:12px">Tarikh Permohonan</span><br><b><span name="kpk_tarikh_memohon" id="kpk_tarikh_memohon"></span></b></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <h6><b>MAKLUMAT ASAS KAWASAN</b></h6>
                                            <br>
                                            <p>6. Maklumat Bangunan Operasi Rukun Tetangga</p>
                                            <hr class="mt-1">
                                            <div class="row clearfix">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <br>
                                                    <div class="form-group">
                                                        <label class="form-label">1. Status Bangunan Binaan Jabatan Sedia Ada: </label>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table thead-dark table-bordered table-striped" id="senarai_binaan_jambatan_table" style="width: 100%" border="1">
                                                            <thead>
                                                                <tr>
                                                                    <th><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Jenis Premis</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Alamat</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Isu</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <br>
                                                    <div class="form-group">
                                                        <label class="form-label">2. Status Bangunan Tumpang Sedia Ada: </label>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table thead-dark table-bordered table-striped" id="senarai_bagunan_tumpang_table" style="width: 100%" border="1">
                                                            <thead>
                                                                <tr>
                                                                    <th><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Jenis Premis</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Alamat</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <br>
                                                    <div class="form-group">
                                                        <label class="form-label">3. Status Bangunan Sewa Sedia Ada: </label>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table thead-dark table-bordered table-striped" id="senarai_bagunan_sewa_table" style="width: 100%" border="1">
                                                            <thead>
                                                                <tr>
                                                                    <th><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Jenis Premis</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Alamat</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <br>
                                                    <div class="form-group">
                                                        <label class="form-label">4. Status Kabin Sedia Ada: </label>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table thead-dark table-bordered table-striped" id="senarai_kabin_table" style="width: 100%" border="1">
                                                            <thead>
                                                                <tr>
                                                                    <th width="6%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Jenis Kabin</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Alamat</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Anggaran Kos Kabin</font></label></th>
                                                                    <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <br>
                                                    <div class="form-group">
                                                        <label class="form-label">5. Cadangan Pembinaan PRT / Kompleks Perpaduan / Kabin (tiada had tahun): </label>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table thead-dark table-bordered table-striped" id="senarai_cadangan_pembinaan_table" style="width: 100%" border="1">
                                                            <thead>
                                                                <tr>
                                                                    <th width="6%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Jenis Premis</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Status Tanah Terkini</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Tahun Pembinaan</font></label></th>
                                                                    <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <br><br>
                                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>&nbsp;
                                                <button type="submit" class="btn btn-primary" id="btn_next">Seterusnya&nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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

@include('js.rt-sm2.j-profile-krt-hqrt-5')