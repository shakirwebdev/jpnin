@extends('layout.master')
@section('title', 'Permohonan Sejiwa')


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
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert" style="display:none;" id="psk_perlu_kemaskini">
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> <span class="text-red blink" id="psk_status_description" name="psk_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> <span id="psk_disemak_note" name="psk_disemak_note"></span><span id="psk_disahkan_note" name="psk_disahkan_note"></span>.
                                <br>
                                <input type="hidden" name="psk_status" id="psk_status">
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
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="psk_nama_krt" name="psk_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="psk_alamat_krt" name="psk_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="psk_negeri_krt" name="psk_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="psk_parlimen_krt" name="psk_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="psk_pbt_krt" name="psk_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="psk_daerah_krt" name="psk_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="psk_dun_krt" name="psk_dun_krt"></span></b></p>
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
                                                <form method="POST" id="form_psk1">
                                                @csrf
                                                    <h6><b>MAKLUMAT AM SEJIWA</b></h6>
                                                    <br><br>
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Sejiwa: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="psk1_sejiwa_nama" id="psk1_sejiwa_nama" placeholder="Nama Sejiwa" >
                                                        <div class="error_psk1_sejiwa_nama invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Tarikh Penubuhan Sejiwa: <span class="text-red">*</span></label>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                            </div>
                                                            <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="psk1_sejiwa_tarikh_ditubuhkan" id="psk1_sejiwa_tarikh_ditubuhkan" placeholder="Tarikh Penubuhan Sejiwa" data-date-format="dd/mm/yyyy">
                                                            <div class="error_psk1_sejiwa_tarikh_ditubuhkan invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Pusat Operasi Sejiwa: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="psk1_sejiwa_pusat_operasi" id="psk1_sejiwa_pusat_operasi" placeholder="Pusat Operasi Sejiwa" >
                                                        <div class="error_psk1_sejiwa_pusat_operasi invalid-feedback text-right"></div>
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
                                            <h6><b>MAKLUMAT PROFIL SEJIWA</b></h6>
                                            <br>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <form method="POST" id="form_psk2">
                                                @csrf
                                                    <p>1. Maklumat Pengerusi</p>
                                                    <hr class="mt-1">
                                                    <div class="row clearfix">
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Nama Penuh: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="psk2_sejiwa_nama_pengerusi" id="psk2_sejiwa_nama_pengerusi" placeholder="Nama Penuh" >
                                                                <div class="error_psk2_sejiwa_nama_pengerusi invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">No Telefon: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="psk2_sejiwa_phone_pengerusi" id="psk2_sejiwa_phone_pengerusi" placeholder="No Telefon" >
                                                                <div class="error_psk2_sejiwa_phone_pengerusi invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">E-mel: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="psk2_sejiwa_email_pengerusi" id="psk2_sejiwa_email_pengerusi" placeholder="E-mel" >
                                                                <div class="error_psk2_sejiwa_email_pengerusi invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">No Kad Pengenalan: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="psk2_sejiwa_ic_pengerusi" id="psk2_sejiwa_ic_pengerusi" placeholder="XXXXXXXXXXXX" >
                                                                <div class="error_psk2_sejiwa_ic_pengerusi invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Alamat Rumah: <span class="text-red">*</span></label>
                                                                <textarea class="form-control" name="psk2_sejiwa_alamat_pengerusi" id="psk2_sejiwa_alamat_pengerusi" rows="5" placeholder="Alamat Rumah"></textarea>
                                                                <div class="error_psk2_sejiwa_alamat_pengerusi invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Pekerjaan: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="psk2_sejiwa_pekerjaan_pengerusi" id="psk2_sejiwa_pekerjaan_pengerusi" placeholder="Pekerjaan" >
                                                                <div class="error_psk2_sejiwa_pekerjaan_pengerusi invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p>2. Maklumat Timbalan Pengerusi</p>
                                                    <hr class="mt-1">
                                                    <div class="row clearfix">
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Nama Penuh: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="psk2_sejiwa_nama_timbalan" id="psk2_sejiwa_nama_timbalan" placeholder="Nama Penuh" >
                                                                <div class="error_psk2_sejiwa_nama_timbalan invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">No Telefon: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="psk2_sejiwa_phone_timbalan" id="psk2_sejiwa_phone_timbalan" placeholder="No Telefon" >
                                                                <div class="error_psk2_sejiwa_phone_timbalan invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">E-mel: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="psk2_sejiwa_email_timbalan" id="psk2_sejiwa_email_timbalan" placeholder="E-mel" >
                                                                <div class="error_psk2_sejiwa_email_timbalan invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">No Kad Pengenalan: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="psk2_sejiwa_ic_timbalan" id="psk2_sejiwa_ic_timbalan" placeholder="XXXXXXXXXXXX" >
                                                                <div class="error_psk2_sejiwa_ic_timbalan invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Alamat Rumah: <span class="text-red">*</span></label>
                                                                <textarea class="form-control" name="psk2_sejiwa_alamat_timbalan" id="psk2_sejiwa_alamat_timbalan" rows="5" placeholder="Alamat Rumah"></textarea>
                                                                <div class="error_psk2_sejiwa_alamat_timbalan invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Pekerjaan: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="psk2_sejiwa_pekerjaan_timbalan" id="psk2_sejiwa_pekerjaan_timbalan" placeholder="Pekerjaan" >
                                                                <div class="error_psk2_sejiwa_pekerjaan_timbalan invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p>3. Maklumat Setiausaha</p>
                                                    <hr class="mt-1">
                                                    <div class="row clearfix">
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Nama Penuh: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="psk2_sejiwa_nama_su" id="psk2_sejiwa_nama_su" placeholder="Nama Penuh" >
                                                                <div class="error_psk2_sejiwa_nama_su invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">No Telefon: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="psk2_sejiwa_phone_su" id="psk2_sejiwa_phone_su" placeholder="No Telefon" >
                                                                <div class="error_psk2_sejiwa_phone_su invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">E-mel: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="psk2_sejiwa_email_su" id="psk2_sejiwa_email_su" placeholder="E-mel" >
                                                                <div class="error_psk2_sejiwa_email_su invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">No Kad Pengenalan: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="psk2_sejiwa_ic_su" id="psk2_sejiwa_ic_su" placeholder="XXXXXXXXXXXX" >
                                                                <div class="error_psk2_sejiwa_ic_su invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Alamat Rumah: <span class="text-red">*</span></label>
                                                                <textarea class="form-control" name="psk2_sejiwa_alamat_su" id="psk2_sejiwa_alamat_su" rows="5" placeholder="Alamat Rumah"></textarea>
                                                                <div class="error_psk2_sejiwa_alamat_su invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Pekerjaan: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="psk2_sejiwa_pekerjaan_su" id="psk2_sejiwa_pekerjaan_su" placeholder="Pekerjaan" >
                                                                <div class="error_psk2_sejiwa_pekerjaan_su invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <br>
                                        </div>
                                        <br>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <form method="POST" id="form_psk3">
                                            @csrf
                                                <input type="hidden" name="psk3_sejiwa_id" id="psk3_sejiwa_id">
                                                <input type="hidden" name="action" id="post_profil_sejiwa_krt" value="edit">
                                                <input type="hidden" name="post_profil_sejiwa_krt" value="edit">
                                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="submit" class="btn btn-primary" id="btn_next">Seterusnya &nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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

@include('js.rt-sm10.j-permohonan-sejiwa-krt-1')
