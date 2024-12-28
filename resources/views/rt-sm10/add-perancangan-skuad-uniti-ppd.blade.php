@extends('layout.master')
@section('title', 'REKOD PROFIL AHLI JAWATAN KUASA CAWANGAN')


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
                                                <h6><b>MAKLUMAT SKUAD UNITI</b></h6>
                                                <br><br>
                                                <div class="form-group">
                                                    <label class="form-label">Nama Skuad Uniti: <span class="text-red">*</span></label>
                                                    <select class="form-control">
                                                        <option>-- Sila Pilih --</option>
                                                        <option>Skuad Uniti Kuala Perlis</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Alamat KRT / Skuad: <span class="text-red">*</span></label>
                                                    <textarea class="form-control" rows="4" disabled=""></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Negeri: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Negeri" value="Perlis" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Daerah: <span class="text-red">*</span></label>
                                                    <select class="form-control" disabled="">
                                                        <option>Kangar</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <b>Tarikh Penubuhan Skuad</b>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                        <input type="text" name="" class="form-control" value="" placeholder="arikh Penubuhan Skuad" disabled="">
                                                        <div class="c_username invalid-feedback text-right"></div>
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
                                            <h6><b>MAKLUMAT PERANCANGAN AKTIVTI / PERKHIDMATAN</b></h6>
                                            <br><br>
                                            <div class="tab-content mt-3">
                                                <div class="alert alert-warning alert-dismissible fade show small" role="alert">
                                                    <div class="mb-10">
                                                        <code><span style="text-size: 16px;"><strong>Nota </strong></span></code>
                                                        <br><br>
                                                        1. Setiap Skuad Uniti adalah dikehendaki melaksanakan minima 2 jenis aktivti atau perkhidmatan setahun. 
                                                        <br>
                                                        <br>
                                                        2. Bagi Skuad Uniti Perluasan (Baharu) adalah dikehendaki melaksanakan:
                                                        <br>
                                                        &nbsp;&nbsp;&nbsp; a) 1 kursus kemahiran asas bantu mula<br>
                                                        &nbsp;&nbsp;&nbsp; b) 2 jenis perkhidmatan / aktiviti
                                                    </div>
                                                </div>
                                            </div>    
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="series-frame">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Perancangan Aktivti / Perkhidmatan: </label>
                                                                    <input type="text" class="form-control" name="" placeholder="Nama Penuh">
                                                                </div>
                                                                <div class="form-group">
                                                                    <b>Tarikh</b>
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                        </div>
                                                                        <input type="text" name="" class="form-control" value="" placeholder="Tarikh">
                                                                        <div class="c_username invalid-feedback text-right"></div>
                                                                    </div>
                                                                </div> 
                                                                <div class="form-group">
                                                                    <label class="form-label">Kumpulan Sasaran: <span class="text-red">*</span></label>
                                                                    <input type="text" class="form-control" name="" placeholder="Kumpulan Sasaran">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Kerjasama: </label>
                                                                    <input type="text" class="form-control" name="" placeholder="Kerjasama">
                                                                </div>
                                                                <button type="submit" class="btn btn-primary pull-right">Tambah</button>
                                                            </div>
                                                            
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_agensi_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Perancangan Aktivti/ Perkhidmatan</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Tarikh</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Kumpulan Sasaran</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Kerjasama</font></label></th>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm10.perancangan_aktivti_uniti')}}';"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                            <button type="button" class="btn btn-secondary">Simpan</button>&nbsp;
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

@section('popup')
    <!-- Modal -->
    <div class="modal fade" id="ModalAhliSkuad" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalJPNINLabel">Tambah Ahli Skuad Uniti</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="form-group">
                                <small>Isi maklumat pada ruangan di bawah, dan tekan butang <strong>Simpan</strong> untuk menambah rekod ke pangkalan data</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Nama Penuh: </label>
                                <input type="text" class="form-control" name="" placeholder="Nama Penuh">
                            </div>
                            <div class="form-group">
                                <label class="form-label">No Kad Pengenalan: </label>
                                <input type="text" class="form-control" name="" placeholder="No Kad Pengenalan">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jawatan: </label>
                                <select class="form-control">
                                    <optgroup>-- Sila Pilih --</optgroup>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">No Telefon: </label>
                                <input type="text" class="form-control" name="" placeholder="No Telefon">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Alamat Rumah: </label>
                                <input type="text" class="form-control" name="" placeholder="Alamat Rumah">
                            </div>
                            <div class="form-group">
                                <label class="form-label">E-mel: </label>
                                <input type="text" class="form-control" name="" placeholder="E-mel">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Pekerjaan: </label>
                                <input type="text" class="form-control" name="" placeholder="Pekerjaan">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tempoh Penglibatan dalam KRT: </label>
                                <input type="text" class="form-control" name="" placeholder="Pekerjaan">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn-save-jpnin">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
@stop

@include('js.rt-sm10.j-add-profile-skuad-uniti-ppd')
