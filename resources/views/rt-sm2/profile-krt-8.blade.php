@extends('layout.master')
@section('title', 'Kemaskini Profil Kawasan Rukun Tetangga')


@section('content')
@include('modal.modal-add-jawatankuasa-penaja-rt')
@include('modal.modal-view-jawatankuasa-penaja-rt')
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
                                        <!-- <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="row clearfix">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <h6><b>MAKLUMAT ASAS KAWASAN</b></h6>
                                                    <br>
                                                    <p>8. Senarai Jawatan Kuasa Penaja Rukun Tetangga   <i class="fa fa-info-circle" data-toggle="tooltip" title="minimum senarai penaja hendaklah diisi di antara 15 orang"></i></p>
                                                    <hr class="mt-1">
                                                </div>
                                                <br><br>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Jawatankuasa Penaja RT: <span class="text-red">*</span></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary pull-right" onclick="load_add_jawatankuasa_penaja_rt();"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                    </div>
                                                    <br/><br/>
                                                    <input type="hidden" name="jkpf_krt_profileID" id="kaf_krt_profileID" value="{{$profile_krt->id}}">
                                                    <div class="table-responsive">
                                                        <table class="table thead-dark table-bordered table-striped" id="senarai_jawatankuasa_penaja_table" style="width: 100%" border="1">
                                                            <thead>
                                                                <tr>
                                                                    <th width="6%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Nama</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">No Kad Pengenalan</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">No Telefon</font></label></th>
                                                                    <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <h6><b>MAKLUMAT ASAS KRT</b></h6>
                                                <br>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <form method="POST" id="form_pk12">
                                                @csrf
                                                <p>9. MAKLUMAT AKAUN BANK KRT</p>
                                                <hr class="mt-1">
                                                <div class="row clearfix">
                                                    <br><br>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Nama Bank: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="pk12_krt_bank_nama" id="pk12_krt_bank_nama" placeholder="Nama Bank">
                                                            <div class="error_pk12_krt_bank_nama invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">No Akaun Bank: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="pk12_krt_bank_no_acc" id="pk12_krt_bank_no_acc" placeholder="No Akaun Bank">
                                                            <div class="error_pk12_krt_bank_no_acc invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6" style="display:none;">
                                                        <div class="form-group">
                                                            <label class="form-label">No Evendor: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="pk12_krt_bank_no_evendor" id="pk12_krt_bank_no_evendor" placeholder="No Evendor" value="Tiada">
                                                            <div class="error_pk12_krt_bank_no_evendor invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-lg-6 col-md-6 col-sm-6" style="display:none;">
                                                        <div class="form-group">
                                                            <label class="form-label">Baki Tunai (RM): <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="pk12_krt_bank_baki_cash" id="pk12_krt_bank_baki_cash" placeholder="cth : 0.00" disabled>
                                                            <div class="error_pk12_krt_bank_baki_cash invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6" style="display:none;">
                                                        <div class="form-group">
                                                            <label class="form-label">Baki Bank (RM): <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="pk12_krt_bank_baki_bank" id="pk12_krt_bank_baki_bank" placeholder="cth : 0.00" disabled>
                                                            <div class="error_pk12_krt_bank_baki_bank invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6" style="display:none;">
                                                        <div class="form-group">
                                                            <label class="form-label">Jumlah (RM): </label>
                                                            <input type="text" class="form-control" name="pk12_krt_bank_total" id="pk12_krt_bank_total" placeholder="Jumlah (RM)" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <form action="POST" id="form_pk13">
                                            @csrf
                                                <input type="hidden" name="pk13_krt_profile_id" id="pk13_krt_profile_id">
                                                <input type="hidden" name="pk13_krt_bank_baki_status_edit" id="pk13_krt_bank_baki_status_edit">
                                                <input type="hidden" name="action" id="update_profile_krt_8" value="edit">
                                                <input type="hidden" name="update_profile_krt_8" value="edit">
                                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="submit" class="btn btn-primary" id="btn_edit">Kemaskini Profil KRT&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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
    </div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@stop

@include('js.rt-sm2.j-profile-krt-8')
