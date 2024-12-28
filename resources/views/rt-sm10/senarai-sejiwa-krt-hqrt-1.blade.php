@extends('layout.master')
@section('title', 'Profil Sejiwa')


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
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <h6><b>MAKLUMAT KAWASAN RUKUN TETANGGA</b></h6>
                                                    <br><br>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="ask1_nama_krt" name="ask1_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="ask1_alamat_krt" name="ask1_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="ask1_negeri_krt" name="ask1_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="ask1_parlimen_krt" name="ask1_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="ask1_pbt_krt" name="ask1_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="ask1_daerah_krt" name="ask1_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="ask1_dun_krt" name="ask1_dun_krt"></span></b></p>
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
                                                <h6><b>MAKLUMAT AM SEJIWA</b></h6>
                                                <br><br>
                                                <div class="form-group">
                                                    <label class="form-label">Nama Sejiwa: </label>
                                                    <input type="text" class="form-control" name="ask1_sejiwa_nama" id="ask1_sejiwa_nama" placeholder="Nama Sejiwa" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Tarikh Penubuhan Sejiwa: </label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                        <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="ask1_sejiwa_tarikh_ditubuhkan" id="ask1_sejiwa_tarikh_ditubuhkan" placeholder="Tarikh Penubuhan Sejiwa" data-date-format="dd/mm/yyyy" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Pusat Operasi Sejiwa: </label>
                                                    <input type="text" class="form-control" name="ask1_sejiwa_pusat_operasi" id="ask1_sejiwa_pusat_operasi" placeholder="Pusat Operasi Sejiwa" disabled>
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
                                            <h6><b>MAKLUMAT PROFIL SEJIWA</b></h6>
                                            <br>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <p>1. Maklumat Pengerusi</p>
                                                <hr class="mt-1">
                                                <div class="row clearfix">
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Nama Penuh: </label>
                                                            <input type="text" class="form-control" name="ask1_sejiwa_nama_pengerusi" id="ask1_sejiwa_nama_pengerusi" placeholder="Nama Penuh" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">No Telefon: </label>
                                                            <input type="text" class="form-control" name="ask1_sejiwa_phone_pengerusi" id="ask1_sejiwa_phone_pengerusi" placeholder="No Telefon" disabled>
                                                            <div class="error_psk2_sejiwa_phone_pengerusi invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">E-mel: </label>
                                                            <input type="text" class="form-control" name="ask1_sejiwa_email_pengerusi" id="ask1_sejiwa_email_pengerusi" placeholder="E-mel" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">No Kad Pengenalan: </label>
                                                            <input type="text" class="form-control" name="ask1_sejiwa_ic_pengerusi" id="ask1_sejiwa_ic_pengerusi" placeholder="No Kad Pengenalan" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Alamat Rumah: </label>
                                                            <textarea class="form-control" name="ask1_sejiwa_alamat_pengerusi" id="ask1_sejiwa_alamat_pengerusi" rows="5" placeholder="Alamat Rumah" disabled></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Pekerjaan: </label>
                                                            <input type="text" class="form-control" name="ask1_sejiwa_pekerjaan_pengerusi" id="ask1_sejiwa_pekerjaan_pengerusi" placeholder="Pekerjaan" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p>2. Maklumat Timbalan Pengerusi</p>
                                                <hr class="mt-1">
                                                <div class="row clearfix">
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Nama Penuh: </label>
                                                            <input type="text" class="form-control" name="ask1_sejiwa_nama_timbalan" id="ask1_sejiwa_nama_timbalan" placeholder="Nama Penuh" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">No Telefon: </label>
                                                            <input type="text" class="form-control" name="ask1_sejiwa_phone_timbalan" id="ask1_sejiwa_phone_timbalan" placeholder="No Telefon" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">E-mel: </label>
                                                            <input type="text" class="form-control" name="ask1_sejiwa_email_timbalan" id="ask1_sejiwa_email_timbalan" placeholder="E-mel" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">No Kad Pengenalan: </label>
                                                            <input type="text" class="form-control" name="ask1_sejiwa_ic_timbalan" id="ask1_sejiwa_ic_timbalan" placeholder="No Kad Pengenalan" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Alamat Rumah: </label>
                                                            <textarea class="form-control" name="ask1_sejiwa_alamat_timbalan" id="ask1_sejiwa_alamat_timbalan" rows="5" placeholder="Alamat Rumah" disabled></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Pekerjaan: </label>
                                                            <input type="text" class="form-control" name="ask1_sejiwa_pekerjaan_timbalan" id="ask1_sejiwa_pekerjaan_timbalan" placeholder="Pekerjaan" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p>3. Maklumat Setiausaha</p>
                                                <hr class="mt-1">
                                                <div class="row clearfix">
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Nama Penuh: </label>
                                                            <input type="text" class="form-control" name="ask1_sejiwa_nama_su" id="ask1_sejiwa_nama_su" placeholder="Nama Penuh" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">No Telefon: </label>
                                                            <input type="text" class="form-control" name="ask1_sejiwa_phone_su" id="ask1_sejiwa_phone_su" placeholder="No Telefon" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">E-mel: </label>
                                                            <input type="text" class="form-control" name="ask1_sejiwa_email_su" id="ask1_sejiwa_email_su" placeholder="E-mel" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">No Kad Pengenalan: </label>
                                                            <input type="text" class="form-control" name="ask1_sejiwa_ic_su" id="ask1_sejiwa_ic_su" placeholder="No Kad Pengenalan" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Alamat Rumah: </label>
                                                            <textarea class="form-control" name="ask1_sejiwa_alamat_su" id="ask1_sejiwa_alamat_su" rows="5" placeholder="Alamat Rumah" disabled></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Pekerjaan: </label>
                                                            <input type="text" class="form-control" name="ask1_sejiwa_pekerjaan_su" id="ask1_sejiwa_pekerjaan_su" placeholder="Pekerjaan" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                        </div>
                                        <br>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                            <button type="button" class="btn btn-primary" id="btn_next">Seterusnya &nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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

@include('js.rt-sm10.j-senarai-sejiwa-krt-hqrt-1')
