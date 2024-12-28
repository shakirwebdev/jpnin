@extends('layout.master')
@section('parentPageTitle', 'HRMS')
@section('title', 'PENDAFTARAN e-IDRT')


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
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="user-list" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <div class="row clearfix">
                                <div class="col-12">
                                    <h6>MAKLUMAT KAWASAN RT</h6>
                                    <hr class="mt-1">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Nama KRT: </label>
                                        <input type="text" class="form-control" name="" placeholder=".." value="" disabled="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Negeri: </label>
                                        <input type="text" class="form-control" name="" placeholder=".." value="" disabled="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Daerah: </label>
                                        <input type="text" class="form-control" name="" placeholder=".." value="" disabled="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Parlimen: </label>
                                        <input type="text" class="form-control" name="" placeholder=".." value="" disabled="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Dun: </label>
                                        <input type="text" class="form-control" name="" placeholder=".." value="" disabled="">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Pihak Berkuasa Tempatan: </label>
                                        <input type="text" class="form-control" name="" placeholder=".." value="" disabled="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Balai Polis: </label>
                                        <input type="text" class="form-control" name="" placeholder=".." value="" disabled="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">IPD: </label>
                                        <input type="text" class="form-control" name="" placeholder=".." value="" disabled="">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h6>MAKLUMAT PEMOHON</h6>
                                    <hr class="mt-1">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Nama Penuh: </label>
                                        <input type="text" class="form-control" name="" placeholder=".." value="" disabled="">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Gambar:  <font style="font-size:11px">(bersaiz ukuran pasport)</font></label>
                                        <input type="text" class="form-control" name="" placeholder=".." value="" disabled="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">No Kad Pengenalan: </label>
                                        <input type="text" class="form-control" name="" placeholder=".." value="" disabled="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Umur: <span class="text-red">*</span></label>
                                        <input type="text" class="form-control" name="" placeholder=".." value="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Jantina: <span class="text-red">*</span></label>
                                        <select class="custom-select" id="">
                                            <option value="">-- Pilih Jantina --</option>
                                            <option value="">Lelaki</option>
                                            <option value="">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Warganegara: <span class="text-red">*</span></label>
                                        <select class="custom-select" id="">
                                            <option value="">-- Pilih Warganegara --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Kaum: <span class="text-red">*</span></label>
                                        <select class="custom-select" id="">
                                            <option value="">-- Pilih Kaum --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">No Telefon: <span class="text-red">*</span></label>
                                        <input type="text" class="form-control" name="" placeholder=".." value="">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Alamat Terkini: <span class="text-red">*</span></label>
                                        <textarea class="form-control" id="" name="" rows="4"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Poskod: <span class="text-red">*</span></label>
                                        <input type="text" class="form-control" name="" placeholder=".." value="">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Pendidikan: <span class="text-red">*</span></label>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-vcenter table-hover mb-0" id="pendidikan_krt_table" style="width: 100%">
                                                    <thead>
                                                        <tr>
                                                            <th><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                            <th><label class="form-label"><font color="#113f50">Peringatan</font></label></th>
                                                            <th><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Pekerjaan: <span class="text-red">*</span></label>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-vcenter table-hover mb-0" id="pekerjaan_krt_table" style="width: 100%">
                                                    <thead>
                                                        <tr>
                                                            <th><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                            <th><label class="form-label"><font color="#113f50">Kategori</font></label></th>
                                                            <th><label class="form-label"><font color="#113f50">Pekerjaan</font></label></th>
                                                            <th><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Ideologi: <span class="text-red">*</span></label>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-vcenter table-hover mb-0" id="ideologi_krt_table" style="width: 100%">
                                                    <thead>
                                                        <tr>
                                                            <th><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                            <th><label class="form-label"><font color="#113f50">Parti</font></label></th>
                                                            <th><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">AJK KRT: <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1">
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2">
                                    <div class="form-group">
                                        <label class="form-label">Jawatan: <span class="text-red">*</span></label>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <select class="custom-select" id="">
                                            <option value="">-- Pilih Jawatan --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1">
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1">
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2">
                                    <div class="form-group">
                                        <label class="form-label">Tarikh Lantikan: <span class="text-red">*</span></label>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <select class="custom-select" id="">
                                            <option value="">-- Pilih Tarikh --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1">
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1">
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2">
                                    <div class="form-group">
                                        <label class="form-label">Tarikh Tamat: <span class="text-red">*</span></label>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <select class="custom-select" id="">
                                            <option value="">-- Pilih Tamat --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">AJK SRS: <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1">
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2">
                                    <div class="form-group">
                                        <label class="form-label">Nama SRS: <span class="text-red">*</span></label>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="" placeholder=".." value="">
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1"></div>
                                <div class="col-lg-1 col-md-1 col-sm-1"></div>
                                <div class="col-lg-2 col-md-2 col-sm-2">
                                    <div class="form-group">
                                        <label class="form-label">Tarikh Lantikan: <span class="text-red">*</span></label>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <select class="custom-select" id="">
                                            <option value="">-- Pilih Tarikh --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1"></div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Cawangan: <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1"></div>
                                <div class="col-lg-2 col-md-2 col-sm-2">
                                    <div class="form-group">
                                        <label class="form-label">Cawangan: <span class="text-red">*</span></label>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <select class="custom-select" id="">
                                            <option value="">-- Pilih Cawangan --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1"></div>
                                <div class="col-lg-1 col-md-1 col-sm-1"></div>
                                <div class="col-lg-2 col-md-2 col-sm-2">
                                    <div class="form-group">
                                        <label class="form-label">Jawatan: <span class="text-red">*</span></label>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <select class="custom-select" id="">
                                            <option value="">-- Pilih Jawatan --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1"></div>
                                <div class="col-lg-1 col-md-1 col-sm-1"></div>
                                <div class="col-lg-2 col-md-2 col-sm-2">
                                    <div class="form-group">
                                        <label class="form-label">Tarikh Lantikan: <span class="text-red">*</span></label>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <select class="custom-select" id="">
                                            <option value="">-- Pilih Tarikh --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1"></div>
                                <div class="col-lg-1 col-md-1 col-sm-1"></div>
                                <div class="col-lg-2 col-md-2 col-sm-2">
                                    <div class="form-group">
                                        <label class="form-label">Tarikh Tamat: <span class="text-red">*</span></label>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <select class="custom-select" id="">
                                            <option value="">-- Pilih Tarikh --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1"></div>
                                <br/><br/><br/>
                                <button type="button" class="btn btn-secondary">Simpan</button>&nbsp;
                                <button type="submit" class="btn btn-primary">Hantar Borang e-IDRT</button>
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

@include('js.rt-sm4.j-borang-pendaftaran-eIDRT')