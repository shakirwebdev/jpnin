@extends('layout.master')
@section('title', 'MEMPERAKUI PERANCANGAN AKTIVTI DAN PERKHIDMATAN SKUAD UNITI')


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
                                                <h6><b>MAKLUMAT AM SKUAD UNITI</b></h6>
                                                <br><br>
                                                <div class="form-group">
                                                    <label class="form-label">Nama Skuad Uniti: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Nama Skuad Uniti" value="Skuad Uniti Kuala Perlis" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Alamat KRT / Skuad: <span class="text-red">*</span></label>
                                                    <textarea class="form-control" rows="4" disabled="">No 10, Lorong 5, Taman Peladang Jaya, 02000 Kuala Perlis, Perlis</textarea>
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
                                                    <input type="text" name="" class="form-control" value="" placeholder="arikh Penubuhan Skuad" value="01/01/2020" disabled="">
                                                    <div class="c_username invalid-feedback text-right"></div>
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
                                                <h6><b>MAKLUMAT STATUS SEMAKAN PERANCANGAN</b></h6>
                                                <br><br>
                                                <div class="form-group">
                                                    <label class="form-label">Nama Cawangan: <span class="text-red">*</span></label>
                                                    <select class="form-control">
                                                        <option>-- Sila Pilih --</option>
                                                        <option>Memperakui</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm10.menyemak_perancangan_aktivti_uniti')}}';"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="submit" class="btn btn-primary">Hantar</button>
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
                                            <h6><b>MAKLUMAT PROFIL SKUAD UNITI</b></h6>
                                            <br>
                                            <p>1. Butiran Skuad Uniti</p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <!-- <a href="javascript:void(0);" class="btn btn-sm btn-primary pull-right" title="" data-toggle="modal" data-target="#ModalAhliSkuad"><i class="fa fa-window-restore" aria-hidden="true"></i>&nbsp;&nbsp;Tambah Ahli Skuad</a>
                                                        <br/><br/> -->
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_ahli_skuad_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Nama</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">No.K/P</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Jawatan</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">No Telefon</font></label></th>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <p>2. Jaringan Kerjasama Strategik (<i>Berdasarkan isu / keperluan komuniti</i>) : <span class="text-red">*</span></p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_agensi_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Nama Agensi</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Nama Pegawai / Rujukan</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Jaringan Kerjasama Yang Dipersetuji</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <p>3. Maklumat Perancangan Aktivti / Perkhidmatan : <span class="text-red">*</span></p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_aktivti_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Perancangan Aktiviti / Perkhidmatan</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Tarikh</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Kumpulan Sasaran</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Kerjasama</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
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

@include('js.rt-sm10.j-memperakui-perancangan-aktivti-uniti-hq')
