@extends('layout.master')
@section('title', 'Permohonan Profil Skuad Uniti')


@section('content')
@include('modal.modal-add-biro-skuad-uniti')
@include('modal.modal-view-biro-skuad-uniti')
@include('modal.modal-add-jaringan-skuad-uniti')
@include('modal.modal-view-jaringan-skuad-uniti')
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
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert" style="display:none;" id="psuk_perlu_kemaskini">
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> <span class="text-red blink" id="psuk_status_description" name="psuk_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> <span id="psuk_disemak_note" name="psuk_disemak_note"></span><span id="psuk_diakui_note" name="psuk_diakui_note"></span>.
                                <br>
                                <input type="hidden" name="psuk_status" id="psuk_status">
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
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <h6><b>MAKLUMAT KAWASAN RUKUN TETANGGA</b></h6>
                                                    <br><br>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="psuk_nama_krt" name="psuk_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="psuk_alamat_krt" name="psuk_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="psuk_negeri_krt" name="psuk_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="psuk_parlimen_krt" name="psuk_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="psuk_pbt_krt" name="psuk_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="psuk_daerah_krt" name="psuk_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="psuk_dun_krt" name="psuk_dun_krt"></span></b></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <form method="POST" id="form_psuk1">
                                                @csrf
                                                    <h6><b>MAKLUMAT AM SKUAD UNITI</b></h6>
                                                    <br><br>
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Skuad Uniti: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="psuk1_skuad_nama" id="psuk1_skuad_nama" placeholder="Nama Skuad Uniti" >
                                                        <div class="error_psuk1_skuad_nama invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Tarikh Penubuhan Skuad: <span class="text-red">*</span></label>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                            </div>
                                                            <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="psuk1_skuad_tarikh_ditubuhkan" id="psuk1_skuad_tarikh_ditubuhkan" placeholder="Tarikh Penubuhan Skuad" data-date-format="dd/mm/yyyy">
                                                            <div class="error_psuk1_skuad_tarikh_ditubuhkan invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Skop Perkhidmatan Skuad Uniti: <span class="text-red">*</span></label>
                                                        <textarea class="form-control" name="psuk1_skuad_skop_perkhidmatan" id="psuk1_skuad_skop_perkhidmatan" rows="4" placeholder="Skop Perkhidmatan Skuad Uniti"></textarea>
                                                        <div class="error_psuk1_skuad_skop_perkhidmatan invalid-feedback text-right"></div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <h6><b>MAKLUMAT PROFIL SKUAD UNITI</b></h6>
                                            <br>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <form method="POST" id="form_psuk2">
                                                @csrf
                                                    <p>1. Maklumat Ketua Skuad Uniti</p>
                                                    <hr class="mt-1">
                                                    <div class="row clearfix">
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Nama Penuh: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="psuk2_skuad_nama_ketua" id="psuk2_skuad_nama_ketua" placeholder="Nama Penuh" >
                                                                <div class="error_psuk2_skuad_nama_ketua invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">No Telefon: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="psuk2_skuad_phone_ketua" id="psuk2_skuad_phone_ketua" placeholder="No Telefon" >
                                                                <div class="error_psuk2_skuad_phone_ketua invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">E-mel: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="psuk2_skuad_email_ketua" id="psuk2_skuad_email_ketua" placeholder="E-mel" >
                                                                <div class="error_psuk2_skuad_email_ketua invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">No Kad Pengenalan: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="psuk2_skuad_ic_ketua" id="psuk2_skuad_ic_ketua" placeholder="XXXXXXXXXXXX">
                                                                <div class="error_psuk2_skuad_ic_ketua invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Alamat Rumah: <span class="text-red">*</span></label>
                                                                <textarea class="form-control" name="psuk2_skuad_alamat_ketua" id="psuk2_skuad_alamat_ketua" rows="5" placeholder="Alamat Rumah"></textarea>
                                                                <div class="error_psuk2_skuad_alamat_ketua invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Pekerjaan: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="psuk2_skuad_pekerjaan_ketua" id="psuk2_skuad_pekerjaan_ketua" placeholder="Pekerjaan" >
                                                                <div class="error_psuk2_skuad_pekerjaan_ketua invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p>2. Maklumat Setiausaha Skuad Uniti</p>
                                                    <hr class="mt-1">
                                                    <div class="row clearfix">
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Nama Penuh: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="psuk2_skuad_nama_setiausaha" id="psuk2_skuad_nama_setiausaha" placeholder="Nama Penuh" >
                                                                <div class="error_psuk2_skuad_nama_setiausaha invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">No Telefon: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="psuk2_skuad_phone_setiausaha" id="psuk2_skuad_phone_setiausaha" placeholder="No Telefon" >
                                                                <div class="error_psuk2_skuad_phone_setiausaha invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">E-mel: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="psuk2_skuad_email_setiausaha" id="psuk2_skuad_email_setiausaha" placeholder="E-mel" >
                                                                <div class="error_psuk2_skuad_email_setiausaha invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">No Kad Pengenalan: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="psuk2_skuad_ic_setiausaha" id="psuk2_skuad_ic_setiausaha" placeholder="XXXXXXXXXXXX" >
                                                                <div class="error_psuk2_skuad_ic_setiausaha invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Alamat Rumah: <span class="text-red">*</span></label>
                                                                <textarea class="form-control" name="psuk2_skuad_alamat_setiausaha" id="psuk2_skuad_alamat_setiausaha" rows="5" placeholder="Alamat Rumah"></textarea>
                                                                <div class="error_psuk2_skuad_alamat_setiausaha invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Pekerjaan: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="psuk2_skuad_pekerjaan_setiausaha" id="psuk2_skuad_pekerjaan_setiausaha" placeholder="Pekerjaan" >
                                                                <div class="error_psuk2_skuad_pekerjaan_setiausaha invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <br>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <p>3. Biro Skuad Uniti</p>
                                                <hr class="mt-1">
                                                <br>
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-primary pull-right" onclick="load_add_biro_skuad_uniti();"><i class="fe fe-plus mr-2"></i>Tambah Biro Skuad Uniti</button>
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_biro_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Nama Biro</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Nama Penuh</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">No Kad Pengenalan</font></label></th>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <p>4. Jaringan Kerjasama Strategik (<i>Berdasarkan isu / keperluan komuniti</i> )</p>
                                                <hr class="mt-1">
                                                <br>
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-primary pull-right" onclick="load_add_jaringan_skuad_uniti();"><i class="fe fe-plus mr-2"></i>Tambah Jaringan Kerjasama</button>
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_jaringan_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Nama Agensi</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Nama Pegawai</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">No Telefon</font></label></th>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
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
                                            <form method="POST" id="form_psuk5">
                                            @csrf
                                                <input type="hidden" name="psuk5_skuad_uniti_id" id="psuk5_skuad_uniti_id">
                                                <input type="hidden" name="action" id="post_profil_skuad_uniti_krt" value="edit">
                                                <input type="hidden" name="post_profil_skuad_uniti_krt" value="edit">
                                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="submit" class="btn btn-primary" id="btn_submit">Hantar Profil Skuad Uniti &nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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
<link rel="stylesheet" href="../assets/plugins/datatable/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/plugins/datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/plugins/datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@stop

@include('js.rt-sm10.j-profil-skuad-uniti-krt-1')
