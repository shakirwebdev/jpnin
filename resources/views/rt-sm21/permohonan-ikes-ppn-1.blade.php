@extends('layout.master')
@section('title', 'Permohonan Pelaporan i-Kes')


@section('content')
@include('modal.modal-add-bilangan-terlibat')
@include('modal.modal-add-bilangan-cedera')
@include('modal.modal-add-bilangan-cedera-parah')
@include('modal.modal-add-bilangan-kematian')
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
    <div class="section-body mt-3" style="display:none;" id="pipn4_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert" >
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> 
                                <span class="text-red blink" id="pipn4_status_description" name="pipn4_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> 
                                <span id="pipn4_diakui_note" name="pipn4_diakui_note"></span></span>
                                <span id="pipn4_disemak_note" name="pipn4_disemak_note"></span></span>
                                <span id="pipn4_disahkan_note" name="pipn4_disahkan_note"></span></span>.
                                <br>
                                <input type="hidden" name="pipn4_status" id="pipn4_status">
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
                                                <h6><b>MAKLUMAT KES DALAM KRT</b></h6>
                                                <br>
                                                <div class="form-group">
                                                    <label class="custom-switch">
                                                        <input type="checkbox" name="pipn4_hasRT" id="pipn4_hasRT" class="custom-switch-input" disabled>
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="custom-switch-description">Kejadian Kes Dalam KRT</span>
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Negeri: </label>
                                                    <select class="form-control" name="pipn4_negeri_id" id="pipn4_negeri_id" disabled>
                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                        @foreach($negeri as $item)                                    
                                                            <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Daerah: </label>
                                                    <select class="form-control" name="pipn4_daerah_id" id="pipn4_daerah_id" disabled>
                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                        @foreach($daerah as $item)                                    
                                                            <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Nama KRT: </label>
                                                    <select class="form-control" name="pipn4_krt_profile_id" id="pipn4_krt_profile_id" disabled>
                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                        @foreach($krt as $item)                                    
                                                            <option value="{{ $item->id }}">{{ $item->krt_nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
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
                                                    <input type="text" class="form-control" name="pipn4_user_fullname" id="pipn4_user_fullname" placeholder="Nama Pemohon" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Kad Pengenalan: </label>
                                                    <input type="text" class="form-control" name="pipn4_user_no_ic" id="pipn4_user_no_ic" placeholder="No Kad Pengenalan" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Telefon: </label>
                                                    <input type="text" class="form-control" name="pipn4_user_no_phone" id="pipn4_user_no_phone" placeholder="No Telefon" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Alamat Pejabat: </label>
                                                    <textarea class="form-control" id="pipn4_dihantar_alamat" name="pipn4_dihantar_alamat" rows="4" disabled="" placeholder="Alamat"></textarea>
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
                                            <h6><b>MAKLUMAT KES KEJADIAN</b></h6>
                                            <br>
                                            <p>3. Maklumat Kes Penglibatan : </p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <form method="POST" id="form_pipn4">
                                                @csrf
                                                    <div class="row clearfix">
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Bilangan Terlibat: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pipn4_ikes_bil_terlibat" id="pipn4_ikes_bil_terlibat" placeholder="Bilangan Terlibat">
                                                                <div class="error_pipn4_ikes_bil_terlibat invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Antara Etnik: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="pipn4_status_etnik_id" id="pipn4_status_etnik_id">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($status_etnik as $item)                                    
                                                                        <option value="{{ $item->id }}">{{ $item->status_etnik_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_pipn4_status_etnik_id invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Pilihan Warganegara: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="pipn4_status_warganegara_id" id="pipn4_status_warganegara_id">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($status_warganegara as $item)                                    
                                                                        <option value="{{ $item->id }}">{{ $item->warganegara_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_pipn4_status_warganegara_id invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Bilangan Yang Terlibat Mengikut Etnik: </label>
                                                            </div>
                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-primary pull-right" onclick="load_add_bilangan_terlibat();"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                            </div>
                                                            <br/><br/>
                                                            <div class="table-responsive">
                                                                <table class="table thead-dark table-bordered table-striped" id="senarai_jumlah_terlibat_table" style="width: 100%" border="1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Etnik</font></label></th>
                                                                            <th width="30%"><label class="form-label"><font color="#113f50">Jumlah Yang Terlibat</font></label></th>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <br/><br/>
                                                            <div class="form-group">
                                                                <label class="form-label">Bilangan Cedera Ringan Mengikut Etnik: </label>
                                                            </div>
                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-primary pull-right" onclick="load_add_bilangan_cedera();"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                            </div>
                                                            <br/><br/>
                                                            <div class="table-responsive">
                                                                <table class="table thead-dark table-bordered table-striped" id="senarai_jumlah_cedera_ringan_table" style="width: 100%" border="1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Etnik</font></label></th>
                                                                            <th width="30%"><label class="form-label"><font color="#113f50">Jumlah Cedera Ringan</font></label></th>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <br/><br/>
                                                            <div class="form-group">
                                                                <label class="form-label">Bilangan Cedera Parah Mengikut Etnik: </label>
                                                            </div>
                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-primary pull-right" onclick="load_add_bilangan_cedera_parah();"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                            </div>
                                                            <br/><br/>
                                                            <div class="table-responsive">
                                                                <table class="table thead-dark table-bordered table-striped" id="senarai_jumlah_cedera_parah_table" style="width: 100%" border="1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Etnik</font></label></th>
                                                                            <th width="30%"><label class="form-label"><font color="#113f50">Jumlah Cedera parah</font></label></th>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <br/><br/>
                                                            <div class="form-group">
                                                                <label class="form-label">Bilangan Kematian Mengikut Etnik: </label>
                                                            </div>
                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-primary pull-right" onclick="load_add_bilangan_kematian();"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                            </div>
                                                            <br/><br/>
                                                            <div class="table-responsive">
                                                                <table class="table thead-dark table-bordered table-striped" id="senarai_jumlah_kematian_table" style="width: 100%" border="1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Etnik</font></label></th>
                                                                            <th width="30%"><label class="form-label"><font color="#113f50">Jumlah Cedera parah</font></label></th>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Bilangan Tangkapan Polis: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pipn4_ikes_bil_tangkapan" id="pipn4_ikes_bil_tangkapan" placeholder="Bilangan Tangkapan Polis">
                                                                <div class="error_pipn4_ikes_bil_tangkapan invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <form method="POST" id="form_pipn5">
                                            @csrf
                                                <input type="hidden" name="pipn5_ikes_id" id="pipn5_ikes_id">
                                                <input type="hidden" name="post_permohonan_ikes_ppn_2" value="edit">
                                                <input type="hidden" name="action" id="post_permohonan_ikes_ppn_2" value="edit">
                                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="submit" class="btn btn-primary" id="btn_next">Seterusnya&nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@stop

@include('js.rt-sm21.j-permohonan-ikes-ppn-1')
