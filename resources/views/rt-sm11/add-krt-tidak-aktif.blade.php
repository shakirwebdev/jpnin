@extends('layout.master')
@section('title', 'LAPORAN TINDAKAN PEMULIHAN KRT TIDAK AKTIF')


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
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT KAWASAN RUKUN TETANGGA</b></h6>
                                                <br>
                                                <div class="form-group">
                                                    <label class="form-label">Negeri: </label>
                                                    <select class="form-control" disabled="">
                                                        <option>PERLIS</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Daerah: </label>
                                                    <select class="form-control">
                                                        <option>-- SIla Pilih --</option>
                                                        <option>Padang Besar</option>
                                                        <option>Arau</option>
                                                        <option>Kangar</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Nama KRT: </label>
                                                    <select class="form-control">
                                                        <option>-- Sila Pilih --</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Alamat: </label>
                                                    <textarea class="form-control" id="" name="" rows="4" disabled=""></textarea>
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
                                            <div class="row clearfix">
                                                <h6><b>MAKLUMAT LAPORAN PEMULIHAN KAWASAN RUKUN TETANGGA</b></h6>
                                                <br>
                                                <br>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Tempoh Tidak Aktif (bulan): <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="Tempoh Tidak Aktif (bulan)" >
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Punca / Sebab Tidak Aktif: <span class="text-red">*</span></label>
                                                        <select class="form-control">
                                                            <option>-- Sila Pilih --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <p>Markah Berdasarkan Kaedah Penilaian Keaktifan RT Pada Tahun Semasa : </p>
                                            <hr class="mt-1">
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label class="form-label">Suku Tahun Pertama (Jan-Mac): <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="Suku Tahun Pertama (Jan-Mac)" >
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Suku Tahun Kedua (Mac-Jul): <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="Suku Tahun Kedua (Mac-Jul)" >
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Suku Tahun Ketiga (Jul-Sep): <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="Suku Tahun Ketiga (Jul-Sep)" >
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Suku Tahun Keempat (Sep-Dis): <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="Suku Tahun Keempat (Sep-Dis)" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">Tempoh Pemulihan Dilaksanakan: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Tempoh Pemulihan Dilaksanakan" >
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Punca / Sebab Tidak Aktif: <span class="text-red">*</span></label>
                                                    <select class="form-control">
                                                        <option>-- Sila Pilih --</option>
                                                        <option>AJK Dilantik Tidak Lagi Berminat</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Status KRT Terkini: <span class="text-red">*</span></label>
                                                    <select class="form-control">
                                                        <option>-- Sila Pilih --</option>
                                                        <option>Dalam Tempoh Permulihan</option>
                                                        <option>Telah Diaktifkan</option>
                                                        <option>Tidak Dapat Diaktifkan</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Cadangan PPD: <span class="text-red">*</span></label>
                                                    <select class="form-control">
                                                        <option>-- Sila Pilih --</option>
                                                        <option>Aktifkan Semula</option>
                                                        <option>KRT Dibatalkan</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Keputusan Mesyuarat Ibu Pejabat: <span class="text-red">*</span></label>
                                                    <select class="form-control">
                                                        <option>-- Sila Pilih --</option>
                                                        <option>Aktifkan Semula</option>
                                                        <option>Pembatalan</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm11.senarai_laporan_pemulihan_krt_tidak_aktif')}}';"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                            <button type="button" class="btn btn-secondary">Simpan</button>
                                            <button type="button" class="btn btn-primary">Hantar&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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
@stop

@include('js.rt-sm11.j-add-krt-tidak-aktif')
