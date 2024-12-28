@extends('layout.master')
@section('title', 'Laporan Pemulihan KRT')


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
    <div class="section-body mt-3" style="display:none;" id="pkpd_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert">
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> <span class="text-red blink" id="pkpd_status_description" name="pkpd_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> <span id="pkpd_disemak_note" name="pkpd_disemak_note"></span>.
                                <br>
                                <input type="hidden" name="pkpd_status" id="pkpd_status">
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
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="pkpd_nama_krt" name="pkpd_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="pkpd_alamat_krt" name="pkpd_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="pkpd_negeri_krt" name="pkpd_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="pkpd_parlimen_krt" name="pkpd_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="pkpd_pbt_krt" name="pkpd_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="pkpd_daerah_krt" name="pkpd_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="pkpd_dun_krt" name="pkpd_dun_krt"></span></b></p>
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
                                            <h6><b>MAKLUMAT LAPORAN PEMULIHAN KAWASAN RUKUN TETANGGA</b></h6>
                                            <br>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <form method="POST" id="form_pkpd1">
                                                @csrf
                                                    <div class="row clearfix">
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Tempoh Tidak Aktif (Bulan): <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pkpd1_pemulihan_tempoh_bulan" id="pkpd1_pemulihan_tempoh_bulan" placeholder="Tempoh Tidak Aktif (Bulan)" >
                                                                <div class="error_pkpd1_pemulihan_tempoh_bulan invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Punca / Sebab Tidak Aktif: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pkpd1_pemulihan_punca_tidak_aktif" id="pkpd1_pemulihan_punca_tidak_aktif" placeholder="Punca / Sebab Tidak Aktif" >
                                                                <div class="error_pkpd1_pemulihan_punca_tidak_aktif invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <p>Markah Berdasarkan Kaedah Penilaian Keaktifan RT Pada Tahun Semasa :</p>
                                                        <hr class="mt-1">
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Suku Tahun Pertama (Jan - Mac): <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pkpd1_pemulihan_suku_thn_1" id="pkpd1_pemulihan_suku_thn_1" placeholder="Suku Tahun Pertama (Jan - Mac)" >
                                                                <div class="error_pkpd1_pemulihan_suku_thn_1 invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Suku Tahun Kedua (Mac - Jul): <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pkpd1_pemulihan_suku_thn_2" id="pkpd1_pemulihan_suku_thn_2" placeholder="Suku Tahun Kedua (Mac - Jul)" >
                                                                <div class="error_pkpd1_pemulihan_suku_thn_2 invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Suku Tahun Ketiga (Jul - Sep): <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pkpd1_pemulihan_suku_thn_3" id="pkpd1_pemulihan_suku_thn_3" placeholder="Suku Tahun Ketiga (Jul - Sep)" >
                                                                <div class="error_pkpd1_pemulihan_suku_thn_3 invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Suku Tahun Keempat (Sep - Dis): <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pkpd1_pemulihan_suku_thn_4" id="pkpd1_pemulihan_suku_thn_4" placeholder="Suku Tahun Keempat (Sep - Dis)" >
                                                                <div class="error_pkpd1_pemulihan_suku_thn_4 invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Tempoh Pemulihan Dilaksanakan: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pkpd1_pemulihan_tempoh_pelaksanaan" id="pkpd1_pemulihan_tempoh_pelaksanaan" placeholder="Tempoh Pemulihan Dilaksanakan" >
                                                                <div class="error_pkpd1_pemulihan_tempoh_pelaksanaan invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Cadangan PPD: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="pkpd1_pemulihan_cadangan_ppd" id="pkpd1_pemulihan_cadangan_ppd">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    <option value="1" >Aktifkan Semula</option>
                                                                    <option value="2" >KRT Dibatalkan</option>
                                                                </select>
                                                                <div class="error_pkpd1_pemulihan_cadangan_ppd invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Keputusan Mesyuarat Ibu Pejabat: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="pkpd1_pemulihan_cadangan_hq" id="pkpd1_pemulihan_cadangan_hq">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    <option value="1" >Aktifkan Semula</option>
                                                                    <option value="2" >KRT Dibatalkan</option>
                                                                </select>
                                                                <div class="error_pkpd1_pemulihan_cadangan_hq invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <input type="hidden" name="pkpd1_krt_profile_id" id="pkpd1_krt_profile_id">
                                                            <input type="hidden" name="pkpd1_pemulihan_krt_id" id="pkpd1_pemulihan_krt_id">
                                                            <input type="hidden" name="action" id="post_laporan_pemulihan" value="add">
                                                            <input type="hidden" name="post_laporan_pemulihan" value="add">
                                                            <input type="hidden" name="action" id="post_laporan_pemulihan2" value="edit">
                                                            <input type="hidden" name="post_laporan_pemulihan2" value="edit">
                                                            <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                            <button type="button" class="btn btn-primary" id="btn_submit">Hantar Laporan Pemulihan KRT 1 &nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
                                                            <button type="button" class="btn btn-primary" id="btn_submit2" style="display:none;">Hantar Laporan Pemulihan KRT 2 &nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
                                                        </div>
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

@include('js.rt-sm11.j-pemulihan-krt-ppd-1')
