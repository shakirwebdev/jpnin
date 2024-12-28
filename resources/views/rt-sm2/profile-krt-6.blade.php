@extends('layout.master')
@section('title', 'Kemaskini Profil Kawasan Rukun Tetangga')


@section('content')
@include('modal.modal-add-binaan-jambatan')
@include('modal.modal-view-binaan-jambatan')
@include('modal.modal-add-bagunan-tumpang')
@include('modal.modal-view-bagunan-tumpang')
@include('modal.modal-add-bagunan-sewa')
@include('modal.modal-view-bagunan-sewa')
@include('modal.modal-add-kabin-sedia-ada')
@include('modal.modal-view-kabin-sedia-ada')
@include('modal.modal-add-cadangan-pembinaan-prt')
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
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <small>Isi maklumat pada borang yang disediakan dibawah, dan tekan butang Seterusnya. 
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
                                                <h6><b>MAKLUMAT AM KRT</b></h6>
                                                <br>
                                                <p><span style="font-size:12px">Nama KRT</span><br><b><span name="pk_krt_nama" id="pk_krt_nama"></span></b></p>
                                                <br>
                                                <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span name="pk_krt_alamat" id="pk_krt_alamat"></span></b></p>
                                                <br>
                                                <p><span style="font-size:12px">Tarikh Permohonan</span><br><b><span name="pk_tarikh_memohon" id="pk_tarikh_memohon"></span></b></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="POST" id="form_kpk6">
                                        @csrf
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <h6><b>MAKLUMAT ASAS KAWASAN</b></h6>
                                                        <br>
                                                        <p>6. Maklumat Bangunan Operasi Rukun Tetangga</p>
                                                        <hr class="mt-1">
                                                    </div>
                                                    <br><br>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">1. Status Bangunan Binaan Jabatan Sedia Ada: </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-primary pull-right" onclick="load_add_binaan_jambatan();"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_binaan_jambatan_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="background-color: #113f50" ><font color="white">Bil</font></th>
                                                                        <th style="background-color: #113f50" ><font color="white">Jenis Premis</font></th>
                                                                        <th style="background-color: #113f50" ><font color="white">Alamat</font></th>
                                                                        <th style="background-color: #113f50" ><font color="white">Isu</font></th>
                                                                        <th style="background-color: #113f50" ><font color="white">Tindakan</font></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                        <br><br>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">2. Status Bangunan Tumpang Sedia Ada: </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-primary pull-right" onclick="load_add_bagunan_tumpang();"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_bagunan_tumpang_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="background-color: #113f50" ><font color="white">Bil</font></th>
                                                                        <th style="background-color: #113f50" ><font color="white">Jenis Premis</font></th>
                                                                        <th style="background-color: #113f50" ><font color="white">Alamat</font></th>
                                                                        <th style="background-color: #113f50" ><font color="white">Tindakan</font></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                        <br><br>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">3. Status Bangunan Sewa Sedia Ada: </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-primary pull-right" onclick="load_add_bagunan_sewa();"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_bagunan_sewa_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="background-color: #113f50" ><font color="white">Bil</font></th>
                                                                        <th style="background-color: #113f50" ><font color="white">Jenis Premis</font></th>
                                                                        <th style="background-color: #113f50" ><font color="white">Alamat</font></th>
                                                                        <th style="background-color: #113f50" ><font color="white">Tindakan</font></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                        <br><br>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">4. Status Kabin/Bangunan Binaan Sendiri Sedia Ada: </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-primary pull-right" onclick="load_add_kabin();"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_kabin_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="background-color: #113f50" ><font color="white">Bil</font></th>
                                                                        <th style="background-color: #113f50" ><font color="white">Jenis Kabin/Bangunan Binaan Sendiri</font></th>
                                                                        <th style="background-color: #113f50" ><font color="white">Alamat</font></th>
                                                                        <th style="background-color: #113f50" ><font color="white">Anggaran Kos</font></th>
                                                                        <th style="background-color: #113f50" ><font color="white">Tindakan</font></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                        <br><br>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">5. Cadangan Pembinaan PRT / Kompleks Perpaduan / Kabin (tiada had tahun): </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-primary pull-right" onclick="load_add_cadangan_pembinaan_prt();"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_cadangan_pembinaan_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="background-color: #113f50" ><font color="white">Bil</font></th>
                                                                        <th style="background-color: #113f50" ><font color="white">Jenis Premis</font></th>
                                                                        <th style="background-color: #113f50" ><font color="white">Status Tanah Terkini</font></th>
                                                                        <th style="background-color: #113f50" ><font color="white">Tahun Pembinaan</font></th>
                                                                        <th style="background-color: #113f50" ><font color="white">Tindakan</font></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="button" class="btn btn-primary" id="btn_next">Seterusnya&nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
                                            </div>
                                        </form>
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
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@stop

@include('js.rt-sm2.j-profile-krt-6')
