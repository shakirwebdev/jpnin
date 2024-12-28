@extends('layout.master')
@section('title', 'BORANG LAPORAN KEAKTIFAN KOPERASI KAWASAN RUKUN TETANGGA')


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
                                                <h6><b>MAKLUMAT KAWASAN RUKUN TETANGGA (KRT)</b></h6>
                                                <br>
                                                <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b>KRT Taman Peladang Jaya</b></p>
                                                <br>
                                                <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b>No 10 Lorong 5,<br>Taman Peladang Jaya,<br>02000 Kuala Perlis</b></p>
                                                <br>
                                                <p><span style="font-size:12px">Negeri</span><br><b>Perlis</b></p>
                                                <br>
                                                <p><span style="font-size:12px">Daerah</span><br><b>Kangar</b></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT STATUS PENGESAHAN</b></h6>
                                                <br>
                                                <div class="form-group">
                                                    <label class="form-label">Status: <span class="text-red">*</span></label>
                                                    <select class="form-control">
                                                        <option>-- Sila Pilih --</option>
                                                        <option>Disahkan</option>
                                                        <option>Perlu Dikemaskini</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Penerangan: <span class="text-red">*</span></label>
                                                    <textarea class="form-control" rows="4"></textarea>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group pull-right">
                                                        <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm10.senarai_semakan_koperasi_krt')}}';"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                        <button type="submit" class="btn btn-primary">Hantar&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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
                                            <h6><b>MAKLUMAT PROJEK EKONOMI RT</b></h6>
                                            <br>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Nama Koperasi : </label>
                                                            <input type="text" class="form-control" name="" placeholder="Nama Koperasi" value="Koperasi Taman Peladang Jaya" disabled="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Fungsi Koperasi : <span class="text-red">*</span></label>
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="" disabled="" checked>
                                                                    <span class="custom-control-label">Perbankan</span>
                                                                </label>
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="" disabled="">
                                                                    <span class="custom-control-label">Kredit</span>
                                                                </label>
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="" disabled>
                                                                    <span class="custom-control-label">Pertanian</span>
                                                                </label>
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="" disabled="">
                                                                    <span class="custom-control-label">Perumahan</span>
                                                                </label>
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="" disabled="">
                                                                    <span class="custom-control-label">Perindustrian</span>
                                                                </label>
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="" disabled="">
                                                                    <span class="custom-control-label">Pengguna</span>
                                                                </label>
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="" disabled="">
                                                                    <span class="custom-control-label">Pembinaan</span>
                                                                </label>
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="" disabled="">
                                                                    <span class="custom-control-label">Pengangkutan</span>
                                                                </label>
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="" disabled="">
                                                                    <span class="custom-control-label">Perkhidmatan</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Aktiviti Tambahan : <span class="text-red">*</span></label>
                                                            <textarea class="form-control" rows="4" disabled="">test</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Status Keaktifan : <span class="text-red">*</span></label>
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="" checked disabled>
                                                                    <span class="custom-control-label">Aktif</span>
                                                                </label>
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="" disabled="">
                                                                    <span class="custom-control-label">Tidak Aktif</span>
                                                                </label>
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="" disabled="">
                                                                    <span class="custom-control-label">Dorman</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Isu / Masalah : <span class="text-red">*</span></label>
                                                            <textarea class="form-control" rows="4" disabled="">test</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-lg-12 col-md-12 col-sm-12">
                                                <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm10.senarai_laporan_aktif_koperasi_krt')}}';"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="button" class="btn btn-secondary">Simpan</button>
                                                <button type="button" class="btn btn-primary">Hantar&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
                                            </div> -->
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

@include('js.rt-sm10.j-p-laporan-aktif-koperasi-krt-ppn')
