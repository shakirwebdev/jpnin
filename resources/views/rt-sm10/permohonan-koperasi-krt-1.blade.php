@extends('layout.master')
@section('title', 'Permohonan Koperasi')


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
    <div class="section-body mt-3" style="display:none;" id="pkk_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert">
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> <span class="text-red blink" id="pkk_status_description" name="pkk_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> <span id="pkk_disemak_note" name="pkk_disemak_note"></span><span id="pkk_disahkan_note" name="pkk_disahkan_note"></span>.
                                <br>
                                <input type="hidden" name="pkk_status" id="pkk_status">
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
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="pkk_nama_krt" name="pkk_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="pkk_alamat_krt" name="pkk_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="pkk_negeri_krt" name="pkk_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="pkk_parlimen_krt" name="pkk_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="pkk_pbt_krt" name="pkk_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="pkk_daerah_krt" name="pkk_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="pkk_dun_krt" name="pkk_dun_krt"></span></b></p>
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
                                            <h6><b>MAKLUMAT KOPERASI</b></h6>
                                            <br>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <form method="POST" id="form_pkk1">
                                                @csrf
                                                    <div class="row clearfix">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Nama Koperasi: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pkk1_koperasi_nama" id="pkk1_koperasi_nama" placeholder="Nama Koperasi" >
                                                                <div class="error_pkk1_koperasi_nama invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Penerangan Ringkas Mengenai Fungsi Koperasi: <span class="text-red">*</span></label>
                                                            </div>
                                                            <div class="table-responsive">
                                                                <table class="table thead-dark table-bordered table-striped" id="fungsi_koperasi_table" style="width: 100%" border="1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Fungsi</font></label></th>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                            <br>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Tarikh Didaftarkan Sebagai Koperasi KRT: <span class="text-red">*</span></label>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                    </div>
                                                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="pkk1_koperasi_tarikh_daftar" id="pkk1_koperasi_tarikh_daftar" placeholder="Tarikh Didaftarkan Sebagai Koperasi KRT" data-date-format="dd/mm/yyyy">
                                                                    <div class="error_pkk1_koperasi_tarikh_daftar invalid-feedback text-right"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Bilangan Ahli Lembaga Koperasi (ALK): <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pkk1_koperasi_bilangan_ahli_lembaga" id="pkk1_koperasi_bilangan_ahli_lembaga" placeholder="Bilangan Ahli Lembaga Koperasi (ALK)" >
                                                                <div class="error_pkk1_koperasi_bilangan_ahli_lembaga invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Jumlah Anggota Koperasi: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pkk1_koperasi_jumlah_anggota" id="pkk1_koperasi_jumlah_anggota" placeholder="Jumlah Anggota Koperasi" >
                                                                <div class="error_pkk1_koperasi_jumlah_anggota invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <div class="form-label">Status Koperasi: <span class="text-red">*</span></div>
                                                                <div class="custom-controls-stacked">
                                                                    <label class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" class="custom-control-input enable_tb" name="pkk1_status_koperasi_id" value="1">
                                                                        <span class="custom-control-label">Aktif</span>
                                                                    </label>
                                                                </div>
                                                                <div class="custom-controls-stacked">
                                                                    <label class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" class="custom-control-input" name="pkk1_status_koperasi_id" value="2">
                                                                        <span class="custom-control-label">Tidak Aktif</span>
                                                                    </label>
                                                                </div>
                                                                <div class="custom-controls-stacked">
                                                                    <label class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" class="custom-control-input" name="pkk1_status_koperasi_id" value="3">
                                                                        <span class="custom-control-label">Dorman</span>
                                                                    </label>
                                                                </div>
                                                                <div class="error_pkk1_status_koperasi_id invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Jumlah Pendapatan Koperasi Bagi Tahun Semasa: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pkk1_koperasi_pendapatan_semasa" id="pkk1_koperasi_pendapatan_semasa" placeholder="Jumlah Pendapatan Koperasi Bagi Tahun Semasa" >
                                                                <div class="error_pkk1_koperasi_pendapatan_semasa invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Jumlah Pendapatan Koperasi Bagi Tahun Sebelum: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pkk1_koperasi_pendapatan_sebelum" id="pkk1_koperasi_pendapatan_sebelum" placeholder="Jumlah Pendapatan Koperasi Bagi Tahun Sebelum" >
                                                                <div class="error_pkk1_koperasi_pendapatan_sebelum invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Aktiviti Tambahan Koperasi: <span class="text-red">*</span></label>
                                                            </div>
                                                            <div class="table-responsive">
                                                                <table class="table thead-dark table-bordered table-striped" id="aktiviti_tambahan_koperasi_table" style="width: 100%" border="1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Fungsi</font></label></th>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <form method="POST" id="form_pkk2">
                                            @csrf
                                                <input type="hidden" name="pkk2_koperasi_krt_id" id="pkk2_koperasi_krt_id">
                                                <input type="hidden" name="action" id="post_permohonan_koperasi_1" value="edit">
                                                <input type="hidden" name="post_permohonan_koperasi_1" value="edit">
                                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="submit" class="btn btn-primary" id="btn_submit">Hantar Permohonan Koperasi &nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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

@include('js.rt-sm10.j-permohonan-koperasi-krt-1')
