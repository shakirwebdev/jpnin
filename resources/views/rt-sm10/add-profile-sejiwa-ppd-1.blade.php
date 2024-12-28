@extends('layout.master')
@section('title', 'TAMBAH REKOD PROFIL SEJIWA (SKUAD ELIT JIRAN WANITA)')


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
                                                <h6><b>MAKLUMAT AM SeJiwa</b></h6>
                                                <br><br>
                                                <div class="form-group">
                                                    <label class="form-label">Negeri : <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Negeri" value="Perlis" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Daerah : <span class="text-red">*</span></label>
                                                    <select class="form-control">
                                                        <option>-- Sila Pilih --</option>
                                                        <option>Padang Besar</option>
                                                        <option>Kangar</option>
                                                        <option>Arau</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Nama Cawangan Jiran Wanita : <span class="text-red">*</span></label>
                                                    <select class="form-control">
                                                        <option>-- Sila Pilih --</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <b>Tarikh Penubuhan SeJIWA : <span class="text-red">*</span></b>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                        <input type="text" name="" class="form-control" value="" placeholder="arikh Penubuhan Skuad">
                                                        <div class="c_username invalid-feedback text-right"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Pusat Operasi SeJIWA : <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Pusat Operasi SeJIWA">
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
                                            <h6><b>MAKLUMAT PROFIL SEJIWA TERPERINCI</b></h6>
                                            <br>
                                            <p>B. Pegawai Rujukan / Penyelia SeJIWA :</p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Nama : </label>
                                                            <input type="text" class="form-control" name="" placeholder="Nama">
                                                        </div> 
                                                        
                                                        <div class="form-group">
                                                            <label class="form-label">No Telefon : </label>
                                                            <input type="text" class="form-control" name="" placeholder="No Telefon">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Jawatan : </label>
                                                            <input type="text" class="form-control" name="" placeholder="Jawatan">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">E-mel : </label>
                                                            <input type="text" class="form-control" name="" placeholder="E-mel">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <p>C. Cabaran Dan Cara Menangani :</p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="series-frame">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Cabaran : </label>
                                                                    <input type="text" class="form-control" name="" placeholder="Cabaran">
                                                                </div> 
                                                                <div class="form-group">
                                                                    <label class="form-label">Cara Mengatasi : <span class="text-red">*</span></label>
                                                                    <input type="text" class="form-control" name="" placeholder="Cara Mengatasi">
                                                                </div>
                                                                <button type="submit" class="btn btn-primary pull-right">Tambah</button>
                                                            </div>
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="cabaran_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Cabaran</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Cara Mengatasi</font></label></th>
                                                                        <th width="12%"><label class="form-label"><font color="#113f50"></font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm10.add_profile_sejiwa_ppd')}}';"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
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
    <div class="modal fade" id="ModalAhliSeJIWA" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalJPNINLabel">Tambah Ahli SeJIWA</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="form-group">
                                <small>Isi maklumat pada ruangan di bawah, dan tekan butang <strong>Simpan</strong> untuk menambah rekod ke pangkalan data.
                                <br>
                                Ruangan bertanda <span class="text-red">*</span> adalah ruangan mandatori dan perlu diisi..&nbsp;&nbsp;</small></small>
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
                                <label class="form-label">Pekerjaan: </label>
                                <input type="text" class="form-control" name="" placeholder="Pekerjaan">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Kaum: </label>
                                <select class="form-control">
                                    <option>-- Sila Pilih --</option>
                                    <option>Melayu</option>
                                    <option>Cina</option>
                                    <option>India</option>
                                    <option>Orang Asli</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Pekerjaan: </label>
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
    <div class="modal fade" id="ModalPerkhidmatan" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalJPNINLabel">Tambah Maklumat Perkhidmatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="form-group">
                                <small>Isi maklumat pada ruangan di bawah, dan tekan butang <strong>Simpan</strong> untuk menambah rekod ke pangkalan data.
                                <br>
                                Ruangan bertanda <span class="text-red">*</span> adalah ruangan mandatori dan perlu diisi..&nbsp;&nbsp;</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Keperluan/ Masalah/ Isu: <span class="text-red">*</span></label>
                                <textarea class="form-control" id="" name="" rows="4"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jenis Aktiviti/ Perkhidmatan SeJiwa (Penumpuan): <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="" placeholder="Jenis Aktiviti/ Perkhidmatan SeJiwa">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Kerjasama (Agensi Dan Bentuk Kerjasama): <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="" placeholder="Kerjasama">
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

@include('js.rt-sm10.j-add-profile-sejiwa-ppd')
