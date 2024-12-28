@extends('layout.master')
@section('title', 'Kemaskini Permohonan Profail Penubuhan KRT')


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
    <div class="section-body mt-3" style="display:none;" id="kpk_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert">
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> <span class="text-red blink" id="kpk_status_description" name="kpk_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> 
                                <span id="kpk_disemak_note" name="kpk_disemak_note"></span>
                                <span id="kpk_disahkan_note" name="kpk_disahkan_note"></span>
                                <span id="kpk_diluluskan_note" name="kpk_diluluskan_note"></span>.
                                <br>
                                <input type="hidden" name="kpk_status" id="kpk_status">
                            </div>
                        </div>
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
                                                <h6><b>MAKLUMAT PERMOHONAN KRT</b></h6>
                                                <br>
                                                <p><span style="font-size:12px">Cadangan Nama KRT</span><br><b><span name="kpk_krt_nama" id="kpk_krt_nama"></span></b></p>
                                                <br>
                                                <p><span style="font-size:12px">Cadangan Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span name="kpk_krt_alamat" id="kpk_krt_alamat"></span></b></p>
                                                <br>
                                                <p><span style="font-size:12px">Tarikh Permohonan</span><br><b><span name="kpk_tarikh_memohon" id="kpk_tarikh_memohon"></span></b></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT PEMOHON</b></h6>
                                                <br>
                                                <div class="form-group">
                                                    <label class="form-label">Nama Pemohon: </label>
                                                    <input type="text" class="form-control" name="kpk_pemohon_name" id="kpk_pemohon_name" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Kad Pengenalan: </label>
                                                    <input type="text" class="form-control" name="kpk_pemohon_ic" id="kpk_pemohon_ic" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Alamat: </label>
                                                    <textarea class="form-control" name="kpk_pemohon_alamat" id="kpk_pemohon_alamat" rows="4" disabled=""></textarea>
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
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <h6><b>MAKLUMAT ASAS KAWASAN</b></h6>
                                                <br>
                                                <p>6. Peta Kawasan Yang Dicadangkan</p>
                                                <p class="form-label" style="font-size:12px"><font style="color: #ff7f81">(penyediaan peta lakar dan deskripsi kawasan sepertimana dalam pekeliling 2012
                                                    sebagai pautan rujukan)</font></p>
                                                <hr class="mt-1">
                                            </div>
                                            <br>
                                            <form action="#" id="form_pk7">
                                                {{ csrf_field() }}
                                                <div class="col-md-12 alert alert-danger error_form_pk7" role="alert" style="display: none; padding-bottom: 0px;">
                                                    <ul></ul>
                                                </div>
                                                <div class="series-frame">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Tajuk Fail : <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="pk7_file_title" id="pk7_file_title" placeholder="Tajuk Fail">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Catatan Fail: <span class="text-red">*</span></label>
                                                            <textarea class="form-control" id="pk7_file_catatan" name="pk7_file_catatan" rows="4" placeholder="Catatan Fail"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Fail : <span class="text-red">*</span></label>
                                                            <input type="file" class="form-control" name="pk7_file_peta" id="pk7_file_peta" placeholder="Fail">
                                                        </div>
                                                        <input type="hidden" name="pk7_krt_profile_id" id="pk7_krt_profile_id">
                                                        <input type="hidden" name="add_peta_kawasan" value="add">
                                                        <button type="submit" class="btn btn-primary pull-right" id="btn_save_peta_kawasan"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                    </div>
                                                </div>
                                                <br/><br/>
                                                <div class="table-responsive">
                                                    <table class="table thead-dark table-bordered table-striped" id="senarai_peta_kawasan_table" style="width: 100%" border="1">
                                                        <thead>
                                                            <tr>
                                                                <th width="6%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">Tajuk Fail</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">Catatan Fail</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">Fail</font></label></th>
                                                                <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm1.kemaskini_profil_krt_5','')}}'+'/'+{{$profile_krt->id}};"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                            <button type="button" class="btn btn-primary" onclick="window.location.href = '{{route('rt-sm1.kemaskini_profil_krt_8','')}}'+'/'+{{$profile_krt->id}};">Seterusnya&nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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

@include('js.rt-sm1.j-kemaskini-profil-krt-7')
