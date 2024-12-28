@extends('layout.master')
@section('title', 'Pengesahan Pembatalan SRS')


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
                    <div class="alert alert-warning alert-dismissible fade show small" role="alert" style="display:none;" id="spspn_perlu_kemaskini">
                        <div class="mb-10">
                            <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> <span id="spspn_status_description" name="spspn_status_description"></span></b>
                            <br><br>
                            <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> <span id="spspn_diluluskan_note" name="spspn_diluluskan_note"></span>.
                            <br>
                            <input type="hidden" name="spspn_pembatalan_status" id="spspn_pembatalan_status">
                        </div>
                    </div>
                </div>
            </div>
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
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="row clearfix">
                                                <h6><b>MAKLUMAT KAWASAN RUKUN TETANGGA</b></h6>
                                                <br><br>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="spspn_nama_krt" name="spspn_nama_krt"></span></b></p>
                                                    <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="spspn_alamat_krt" name="spspn_alamat_krt"></span></b></p>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <p><span style="font-size:12px">Negeri</span><br><b><span id="spspn_negeri_krt" name="spspn_negeri_krt"></span></b></p>
                                                    <p><span style="font-size:12px">Parlimen</span><br><b><span id="spspn_parlimen_krt" name="spspn_parlimen_krt"></span></b></p>
                                                    <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="spspn_pbt_krt" name="spspn_pbt_krt"></span></b></p>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <p><span style="font-size:12px">Daerah</span><br><b><span id="spspn_daerah_krt" name="spspn_daerah_krt"></span></b></p>
                                                    <p><span style="font-size:12px">Dun</span><br><b><span id="spspn_dun_krt" name="spspn_dun_krt"></span></b></p>
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
                                            <h6><b>MAKLUMAT PEMOHON</b></h6>
                                            <br>
                                            <div class="form-group">
                                                <label class="form-label">Nama Pemohon: </label>
                                                <input type="text" class="form-control" name="spspn_pemohon_name" id="spspn_pemohon_name" disabled="">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">No Kad Pengenalan: </label>
                                                <input type="text" class="form-control" name="spspn_pemohon_ic" id="spspn_pemohon_ic" disabled="">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Alamat: </label>
                                                <textarea class="form-control" id="spspn_pemohon_address" name="spspn_pemohon_address" rows="4" disabled=""></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <h6><b>MAKLUMAT STATUS PENGESAHAN</b></h6>
                                            <br><br>
                                            <form method="POST" id="form_spspn">
                                            @csrf
                                                <div class="form-group">
                                                    <label class="form-label">Status: <span class="text-red">*</span></label>
                                                    <select class="form-control" name="spspn_pembatalan_status" id="spspn_pembatalan_status">
                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                        <option value="6" >Disahkan</option>
                                                        <option value="7" >Perlu Dikemaskini</option>
                                                    </select>
                                                    <div class="error_spspn_pembatalan_status invalid-feedback text-right"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Penerangan: <span class="text-red">*</span></label>
                                                    <textarea class="form-control" rows="4" name="spspn_disemak_note"id="spspn_disemak_note" placeholder="Penerangan"></textarea>
                                                    <div class="error_spspn_disemak_note invalid-feedback text-right"></div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group pull-right">
                                                        <input type="hidden" name="spspn_pembatalan_id" id="spspn_pembatalan_id">
                                                        <input type="hidden" name="post_pengesahan_pembatalan_srs" value="edit">
                                                        <input type="hidden" name="action" id="post_pengesahan_pembatalan_srs" value="edit">
                                                        <button type="submit" id="btn_submit" class="btn btn-primary">Hantar Status Pengesahan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <h6><b>MAKLUMAT PEMBATALAN SRS</b></h6>
                                        <br>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <p>1. Maklumat Pembatalan SRS</p>
                                        <hr class="mt-1">
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <b>Nama SRS: </b>
                                                    <select class="form-control" name="spspn_srs_profile_id" id="spspn_srs_profile_id" disabled>
                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                        @foreach($srs_profile as $item)                                    
                                                            <option value="{{ $item->id }}">{{ $item->srs_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <p>2. Maklumat Minit Meeting Berkaitan Pembatalan SRS</p>
                                        <hr class="mt-1">
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">Senarai Minit Meeting: </label>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table thead-dark table-bordered table-striped" id="senarai_minit_meeting_table" style="width: 100%" border="1">
                                                <thead>
                                                    <tr>
                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                        <th><label class="form-label"><font color="#113f50">Tajuk Mesyuarat</font></label></th>
                                                        <th width="30%"><label class="form-label"><font color="#113f50">Keterangan</font></label></th>
                                                        <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                        <button type="button" class="btn btn-secondary" disabled><i class="dropdown-icon fe fe-arrow-right"></i>&nbsp;Seterusnya</button>
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

@include('js.rt-sm19.j-pengesahan-pembatalan-srs-ppn-1')