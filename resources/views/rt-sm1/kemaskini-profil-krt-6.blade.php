@extends('layout.master')
@section('title', 'Kemaskini Permohonan Profail Penubuhan KRT')


@section('content')
@include('modal.modal-add-binaan-jambatan')
@include('modal.modal-view-binaan-jambatan')
@include('modal.modal-add-bagunan-tumpang')
@include('modal.modal-view-bagunan-tumpang')
@include('modal.modal-add-kabin-sedia-ada')
@include('modal.modal-view-kabin-sedia-ada')
@include('modal.modal-add-cadangan-pembinaan-prt')
@include('modal.modal-view-cadangan-pembinaan-prt')
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
    <div class="section-body mt-3" style="display:none;" id="kpk_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert">
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> <span class="text-red blink" id="kpk_status_description" name="kpk_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> <span id="kpk_disemak_note" name="kpk_disemak_note"></span><span id="kpk_disahkan_note" name="kpk_disahkan_note"></span>.
                                <br>
                                <input type="hidden" name="kpk_status" id="kpk_status">
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
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT PERMOHONAN KRT</b></h6>
                                                <br>
                                                <p><span style="font-size:12px">Cadangan Nama KRT</span><br><b><span name="kpk_krt_nama" id="kpk_krt_nama"></span></b></p>
                                                <br>
                                                <p><span style="font-size:12px">Cadangan Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span name="kpk_krt_alamat" id="kpk_krt_alamat"></span></b></p>
                                                <br>
                                                <p><span style="font-size:12px">Tarikh Permohonan</span><br><b><span name="kpk_tarikh_memohon" id="kpk_tarikh_memohon"></span></b></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT PEMOHON</b></h6>
                                                <br>
                                                <div class="form-group">
                                                    <label class="form-label">Nama Pemohon: </label>
                                                    <input type="text" class="form-control" name="kpk_pemohon_name" id="kpk_pemohon_name" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Kad Pengenalan: </label>
                                                    <input type="text" class="form-control" name="kpk_pemohon_ic" id="kpk_pemohon_ic" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Alamat: </label>
                                                    <textarea class="form-control" name="kpk_pemohon_alamat" id="kpk_pemohon_alamat" rows="4" disabled=""></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="POST" id="form_kpk6">
                                        @csrf
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <h6><b>MAKLUMAT ASAS KAWASAN</b></h6>
                                                        <br>
                                                        <p>6. Maklumat Bangunan Operasi Rukun Tetangga</p>
                                                        <hr class="mt-1">
                                                    </div>
                                                    <br><br>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">1. Status Bangunan Sedia Ada: </label>
                                                            <select class="form-control" name="kpk6_krt_status_bagunan_id" id="kpk6_krt_status_bagunan_id">
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($ref_status_bagunan as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->status_bagunan_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="kpk6_krt_id" id="kpk6_krt_id">
                                                    <input type="hidden" name="action" id="update_kemaskini_profil_krt_6" value="edit">
                                                    <input type="hidden" name="update_kemaskini_profil_krt_6" value="edit">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 for_jabatan" style="display:none;">
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-primary pull-right" onclick="load_add_binaan_jambatan();"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_binaan_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Jenis Premis</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Alamat</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Isu</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 for_tumpang" style="display:none;">
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-primary pull-right" onclick="load_add_bagunan_tumpang();"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_bagunan_tumpang_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Jenis Premis</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Alamat</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">2. Status Kabin Sedia Ada: </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-primary pull-right" onclick="load_add_kabin();"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_kabin_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="6%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Jenis Kabin</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Alamat</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Anggaran Kos Kabin</font></label></th>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">3. Cadangan Pembinaan PRT / Kompleks Perpaduan / Kabin (tiada had tahun): </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-primary pull-right" onclick="load_add_cadangan_pembinaan_prt();"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="cadangan_pembinaan_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="6%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Jenis Premis</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Status Tanah Terkini</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Cadangan Tahun Pembinaan</font></label></th>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm1.kemaskini_profil_krt_5','')}}'+'/'+{{$profile_krt->id}};"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <!-- <button type="button" class="btn btn-secondary"><i class="dropdown-icon fa fa-save"></i>&nbsp;Simpan</button> -->
                                                <button type="submit" class="btn btn-primary" id="btn_next">Seterusnya&nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@stop

@include('js.rt-sm1.j-kemaskini-profil-krt-6')
