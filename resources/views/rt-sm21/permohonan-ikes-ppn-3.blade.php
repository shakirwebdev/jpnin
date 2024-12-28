@extends('layout.master')
@section('title', 'Permohonan Pelaporan i-Kes')


@section('content')
@include('modal.modal-add-kedudukan-kes')
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
    <div class="section-body mt-3" style="display:none;" id="pipn8_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert" >
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> 
                                <span class="text-red blink" id="pipn8_status_description" name="pipn8_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> 
                                <span id="pipn8_diakui_note" name="pipn8_diakui_note"></span></span>
                                <span id="pipn8_disemak_note" name="pipn8_disemak_note"></span></span>
                                <span id="pipn8_disahkan_note" name="pipn8_disahkan_note"></span></span>.
                                <br>
                                <input type="hidden" name="pipn8_status" id="pipn8_status">
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
                                                        <input type="checkbox" name="pipn8_hasRT" id="pipn8_hasRT" class="custom-switch-input" disabled>
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="custom-switch-description">Kejadian Kes Dalam KRT</span>
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Negeri: </label>
                                                    <select class="form-control" name="pipn8_negeri_id" id="pipn8_negeri_id" disabled>
                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                        @foreach($negeri as $item)                                    
                                                            <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Daerah: </label>
                                                    <select class="form-control" name="pipn8_daerah_id" id="pipn8_daerah_id" disabled>
                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                        @foreach($daerah as $item)                                    
                                                            <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Nama KRT: </label>
                                                    <select class="form-control" name="pipn8_krt_profile_id" id="pipn8_krt_profile_id" disabled>
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
                                                    <input type="text" class="form-control" name="pipn8_user_fullname" id="pipn8_user_fullname" placeholder="Nama Pemohon" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Kad Pengenalan: </label>
                                                    <input type="text" class="form-control" name="pipn8_user_no_ic" id="pipn8_user_no_ic" placeholder="No Kad Pengenalan" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Telefon: </label>
                                                    <input type="text" class="form-control" name="pipn8_user_no_phone" id="pipn8_user_no_phone" placeholder="No Telefon" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Alamat Pejabat: </label>
                                                    <textarea class="form-control" id="pipn8_dihantar_alamat" name="pipn8_dihantar_alamat" rows="4" disabled="" placeholder="Alamat"></textarea>
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
                                            <p>5. Nyatakan Kedudukan Kes Setelah Tindakan Diambil : </p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <form method="POST" id="form_pipn8">
                                                        @csrf
                                                            <div class="form-group">
                                                                <label class="form-label">Keadaan Semasa: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pipn8_ikes_keadaan_semasa" id="pipn8_ikes_keadaan_semasa" placeholder="Keadaan Semasa">
                                                                <div class="error_pipn8_ikes_keadaan_semasa invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Jangkaan keadaan pada masa akan datang: <span class="text-red">*</span></label>
                                                                <textarea class="form-control" name="pipn8_ikes_jangkaan_keadaan" id="pipn8_ikes_jangkaan_keadaan" ></textarea>
                                                                <div class="error_pipn8_ikes_jangkaan_keadaan invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Senarai Kedudukan Kes Setelah Tindakan Diambil: </label>
                                                            </div>
                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-primary pull-right" onclick="load_add_kedudukan_kes();"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                            </div>
                                                            <br/><br/>
                                                            <div class="table-responsive">
                                                                <table class="table thead-dark table-bordered table-striped" id="senarai_kedudukan_kes_table" style="width: 100%" border="1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Jenis / Nama Harta Benda yang Musnah</font></label></th>
                                                                            <th width="30%"><label class="form-label"><font color="#113f50">Nilai Anggaran Kerosakan</font></label></th>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </form>
                                                        <div class="form-group">
                                                            <label class="form-label">Senarai Foto / Dokumen: </label>
                                                        </div>
                                                        <form action="#" id="form_pipn9">
                                                        {{ csrf_field() }}
                                                            <div class="col-md-12 alert alert-danger error_form_pipn9" role="alert" style="display: none; padding-bottom: 0px;">
                                                                <ul></ul>
                                                            </div>
                                                            <div class="series-frame">
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Tajuk Fail : </label>
                                                                        <input type="text" class="form-control" name="pipn9_file_title" id="pipn9_file_title" placeholder="Tajuk Fail">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Catatan Fail: </label>
                                                                        <textarea class="form-control" id="pipn9_file_catatan" name="pipn9_file_catatan" rows="4" placeholder="Catatan Fail"></textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Fail : </label>
                                                                        <input type="file" class="form-control" name="pipn9_file_dokument" id="pipn9_file_dokument" placeholder="Fail">
                                                                    </div>
                                                                    <input type="hidden" name="pipn9_spk_ikes_id" id="pipn9_spk_ikes_id">
                                                                    <input type="hidden" name="add_spk_ikes_dokument_ppn" value="add">
                                                                    <button type="submit" class="btn btn-primary pull-right" id="btn_save_dokument"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <br>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_gambar_ikes_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Tajuk Fail</font></label></th>
                                                                        <th width="25%"><label class="form-label"><font color="#113f50">Catatan Fail</font></label></th>
                                                                        <th width="20%"><label class="form-label"><font color="#113f50">Fail</font></label></th>
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
                                            <form method="POST" id="form_pipn10">
                                            @csrf
                                                <input type="hidden" name="pipn10_ikes_id" id="pipn10_ikes_id">
                                                <input type="hidden" name="post_permohonan_ikes_ppn_4" value="edit">
                                                <input type="hidden" name="action" id="post_permohonan_ikes_ppn_4" value="edit">
                                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="submit" class="btn btn-primary" id="btn_submit">Hantar Permohonan Pelaporan i-Kes&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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
<link rel="stylesheet" href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}">
@stop

@include('js.rt-sm21.j-permohonan-ikes-ppn-3')
