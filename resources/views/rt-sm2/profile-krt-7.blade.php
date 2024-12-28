@extends('layout.master')
@section('title', 'Kemaskini Profil Kawasan Rukun Tetangga')


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
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <h6><b>MAKLUMAT ASAS KAWASAN</b></h6>
                                                <br>
                                                <p>7. Peta Kawasan Yang Dicadangkan </p>
                                                <p class="form-label" style="font-size:12px"><font style="color: #ff7f81">A. Mohon masukkan panduan penyediaan peta lakar dan deskripsi kawasan sepertimana dalam pekeliling 2012 sebagai pautan rujukan</font></p>
                                                <p class="form-label" style="font-size:12px"><font style="color: #ff7f81"> 1. Bagi Kawasan yang boleh di 'zoom' memalui google maps, hendaklah membuat lakaran di atas google maps yang di cetak dan tangkap gambar / scan serta upload dalam sistem.</font></p>
                                                <p class="form-label" style="font-size:12px"><font style="color: #ff7f81"> 2. Bagi kawasan yang tidak boleh di zoom melalui google maps, boleh membuat lakaran di atas kertas , tangkap gambar atau scan dan upload dalam sistem.</font></p>
                                                <hr class="mt-1">
                                            </div>
                                            <br>
                                            <form action="#" id="form_pk11">
                                                {{ csrf_field() }}
                                                <div class="col-md-12 alert alert-danger error_form_pk11" role="alert" style="display: none; padding-bottom: 0px;">
                                                    <ul></ul>
                                                </div>
                                                <div class="series-frame">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Tajuk Fail : <i class="fa fa-info-circle" data-toggle="tooltip" title="letakkan contoh tajuk fail : Peta Lakar KRT Kg Setia"></i></label>
                                                            <input type="text" class="form-control" name="pk11_file_title" id="pk11_file_title" placeholder="Tajuk Fail">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Catatan Fail: <i class="fa fa-info-circle" data-toggle="tooltip" title="Lakaran atas google maps / Lakaran sendiri"></i></label>
                                                            <textarea class="form-control" id="pk11_file_catatan" name="pk11_file_catatan" rows="4" placeholder="Catatan Fail"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Fail : </label>
                                                            <input type="file" class="form-control" name="pk11_file_peta" id="pk11_file_peta" placeholder="Fail">
                                                        </div>
                                                        <input type="hidden" name="pk11_krt_profile_id" id="pk11_krt_profile_id">
                                                        <input type="hidden" name="add_profile_krt_peta_kawasan" value="add">
                                                        <button type="submit" class="btn btn-primary pull-right" id="btn_save_peta_kawasan"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                    </div>
                                                </div>
                                                <br/><br/>
                                                <div class="table-responsive">
                                                    <table class="table thead-dark table-bordered table-striped" id="senarai_peta_kawasan_table" style="width: 100%" border="1">
                                                        <thead>
                                                            <tr>
                                                                <th style="background-color: #113f50" ><font color="white">Bil</font></th>
                                                                <th style="background-color: #113f50" ><font color="white">Tajuk Fail</font></th>
                                                                <th style="background-color: #113f50" ><font color="white">Catatan Fail</font></th>
                                                                <th style="background-color: #113f50" ><font color="white">Fail</font></th>
                                                                <th style="background-color: #113f50" ><font color="white">Tindakan</font></th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </form>
                                        </div>
                                        <br/><br/>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                            <button type="button" class="btn btn-primary" id="btn_next">Seterusnya&nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
                                            <!-- <form action="POST" id="form_pk12">
                                            @csrf
                                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="submit" class="btn btn-primary" id="btn_edit">Kemaskini Profil KRT&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
                                            </form> -->
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
<link rel="stylesheet" href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}">
@stop

@include('js.rt-sm2.j-profile-krt-7')
