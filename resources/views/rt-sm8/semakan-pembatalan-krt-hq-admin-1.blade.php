@extends('layout.master')
@section('title', 'BORANG PEMBATALAN KAWASAN RUKUN TERTANGGA (KRT)')


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
                                                <br><br>
                                                <p><span style="font-size:12px">No Rujukan</span><br><b>PRT0303013</b></p>
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
                                                <h6><b>MAKLUMAT PEMOHON</b></h6>
                                                <br><br>
                                                <div class="form-group">
                                                    <label class="form-label">Nama Pemohon: </label>
                                                    <input type="text" class="form-control" name="" placeholder="Nama Pemohon" value="Mohamad Shauki Bin Sahardi" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Kad Pengenalan: </label>
                                                    <input type="text" class="form-control" name="" placeholder="No Kad Pengenalan" value="930508-09-5161" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Alamat: </label>
                                                    <textarea class="form-control" id="" name="" rows="4" disabled="">
No, 10 Lorong 5,
Taman Peladang Jaya,
02000 Kuala Perlis, Perlis
                                                    </textarea>
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
                                            <h6><b>MAKLUMAT TUJUAN DAN DOKUMEN UNTUK MEMBATALKAN KRT</b></h6>
                                            <br>
                                            <p>1. Tujuan : <span class="text-red">*</span></p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <div class="custom-controls-stacked">
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="" disabled="">
                                                            <span class="custom-control-label">Persempadanan semula kawasan</span>
                                                        </label>
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="" checked="" disabled="">
                                                            <span class="custom-control-label">Penambahan semula KRT</span>
                                                        </label>
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="" disabled="">
                                                            <span class="custom-control-label">Pembangunan Semula Kawasan</span>
                                                        </label>
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="" disabled="">
                                                            <span class="custom-control-label">Pembatalan terus disebabkan tidak dapat diaktifkan semula</span>
                                                        </label>
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="" disabled="">
                                                            <span class="custom-control-label">Lain-lain : Nyatakan</span>
                                                        </label>
                                                    </div>
                                                    <br>
                                                    <div class="form-group">
                                                        <label class="form-label">Nyatakan : </label>
                                                        <input type="text" class="form-control" name="" disabled="">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <p>2. Senarai Dokumen : <span class="text-red">*</span></p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="table-responsive">
                                                    <table class="table thead-dark table-bordered table-striped" id="senarai_dokument_table" style="width: 100%" border="1">
                                                        <thead>
                                                            <tr>
                                                                <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">Tajuk</font></label></th>
                                                                <th width="30%"><label class="form-label"><font color="#113f50">Catatan</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">File</font></label></th>
                                                                <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                <br>
                                                <div class="form-group">
                                                    <br/>
                                                    <label class="form-label">Status: </label>
                                                    <select class="select2 custom-select" id="nama_krt" name="nama_krt">
                                                        <option value="">-- Pilih Nama --</option>
                                                        <option value="">Lulus</option>
                                                        <option value="">Tidak Lulus</option>
                                                    </select>
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm8.semakan_pembatalan_krt_ppd')}}';">Kembali</button>&nbsp;
                                            <button type="submit" class="btn btn-primary">Hantar</button>
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

@include('js.rt-sm8.j-semakan-pembatalan-krt-ppd-1')
