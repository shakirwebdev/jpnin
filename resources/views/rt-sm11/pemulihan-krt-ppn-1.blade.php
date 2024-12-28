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
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="pkpn_nama_krt" name="pkpn_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="pkpn_alamat_krt" name="pkpn_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="pkpn_negeri_krt" name="pkpn_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="pkpn_parlimen_krt" name="pkpn_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="pkpn_pbt_krt" name="pkpn_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="pkpn_daerah_krt" name="pkpn_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="pkpn_dun_krt" name="pkpn_dun_krt"></span></b></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT STATUS SEMAKAN</b></h6>
                                                <br><br>
                                                <form method="POST" id="form_pkpn">
                                                @csrf
                                                    <div class="form-group">
                                                        <label class="form-label">Status: <span class="text-red">*</span></label>
                                                        <select class="form-control" name="pkpn_status" id="pkpn_status">
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            <option value="1" >Disokong</option>
                                                            <option value="3" >Tidak Disokong</option>
                                                        </select>
                                                        <div class="error_pkpn_status invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Penerangan: <span class="text-red">*</span></label>
                                                        <textarea class="form-control" rows="4" name="pkpn_disemak_note"id="pkpn_disemak_note" placeholder="Penerangan"></textarea>
                                                        <div class="error_pkpn_disemak_note invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group pull-right">
                                                            <input type="hidden" name="pkpn_pemulihan_krt_id" id="pkpn_pemulihan_krt_id">
                                                            <input type="hidden" name="post_semakan_pemulihan_krt" value="edit">
                                                            <input type="hidden" name="action" id="post_semakan_pemulihan_krt" value="edit">
                                                            <button type="submit" id="btn_submit" class="btn btn-primary">Hantar Status Semakan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
                                                        </div>
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
                                            <h6><b>MAKLUMAT LAPORAN PEMULIHAN KAWASAN RUKUN TETANGGA</b></h6>
                                            <br>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Tempoh Tidak Aktif (Bulan): </label>
                                                            <input type="text" class="form-control" name="pkpn_pemulihan_tempoh_bulan" id="pkpn_pemulihan_tempoh_bulan" placeholder="Tempoh Tidak Aktif (Bulan)" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Punca / Sebab Tidak Aktif: </label>
                                                            <input type="text" class="form-control" name="pkpn_pemulihan_punca_tidak_aktif" id="pkpn_pemulihan_punca_tidak_aktif" placeholder="Punca / Sebab Tidak Aktif" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p>Markah Berdasarkan Kaedah Penilaian Keaktifan RT Pada Tahun Semasa :</p>
                                                <hr class="mt-1">
                                                <div class="row clearfix">
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Suku Tahun Pertama (Jan - Mac): </label>
                                                            <input type="text" class="form-control" name="pkpn_pemulihan_suku_thn_1" id="pkpn_pemulihan_suku_thn_1" placeholder="Suku Tahun Pertama (Jan - Mac)" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Suku Tahun Kedua (Mac - Jul): </label>
                                                            <input type="text" class="form-control" name="pkpn_pemulihan_suku_thn_2" id="pkpn_pemulihan_suku_thn_2" placeholder="Suku Tahun Kedua (Mac - Jul)" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Suku Tahun Ketiga (Jul - Sep): </label>
                                                            <input type="text" class="form-control" name="pkpn_pemulihan_suku_thn_3" id="pkpn_pemulihan_suku_thn_3" placeholder="Suku Tahun Ketiga (Jul - Sep)" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Suku Tahun Keempat (Sep - Dis): </label>
                                                            <input type="text" class="form-control" name="pkpn_pemulihan_suku_thn_4" id="pkpn_pemulihan_suku_thn_4" placeholder="Suku Tahun Keempat (Sep - Dis)" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Tempoh Pemulihan Dilaksanakan: </label>
                                                            <input type="text" class="form-control" name="pkpn_pemulihan_tempoh_pelaksanaan" id="pkpn_pemulihan_tempoh_pelaksanaan" placeholder="Tempoh Pemulihan Dilaksanakan" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Cadangan PPD: </label>
                                                            <select class="form-control" name="pkpn_pemulihan_cadangan_ppd" id="pkpn_pemulihan_cadangan_ppd" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                <option value="1" >Aktifkan Semula</option>
                                                                <option value="2" >KRT Dibatalkan</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Keputusan Mesyuarat Ibu Pejabat: </label>
                                                            <select class="form-control" name="pkpn_pemulihan_cadangan_hq" id="pkpn_pemulihan_cadangan_hq" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                <option value="1" >Aktifkan Semula</option>
                                                                <option value="2" >KRT Dibatalkan</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                        <button type="button" class="btn btn-secondary" disabled>Seterusnya&nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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

@include('js.rt-sm11.j-pemulihan-krt-ppn-1')
