@extends('layout.master')
@section('title', 'Permohonan Pembatalan KRT')


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
<div class="section-body mt-3" style="display:none;" id="ppk_perlu_kemaskini">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="mb-4">
                    <div class="alert alert-warning alert-dismissible fade show small" role="alert">
                        <div class="mb-10">
                            <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> <span class="text-red blink" id="ppk_status_description" name="ppk_status_description"></span></b>
                            <br><br>
                            <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> <span id="ppk_disemak_note" name="ppk_disemak_note"></span><span id="ppk_disokong_note" name="ppk_disokong_note"></span><span id="ppk_diluluskan_note" name="ppk_diluluskan_note"></span>.
                            <br>
                            <input type="hidden" name="ppk_status" id="ppk_status">
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
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="row clearfix">
                                                <h6><b>MAKLUMAT KAWASAN RUKUN TETANGGA</b></h6>
                                                <br><br>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="ppk_nama_krt" name="ppk_nama_krt"></span></b></p>
                                                    <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="ppk_alamat_krt" name="ppk_alamat_krt"></span></b></p>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <p><span style="font-size:12px">Negeri</span><br><b><span id="ppk_negeri_krt" name="ppk_negeri_krt"></span></b></p>
                                                    <p><span style="font-size:12px">Parlimen</span><br><b><span id="ppk_parlimen_krt" name="ppk_parlimen_krt"></span></b></p>
                                                    <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="ppk_pbt_krt" name="ppk_pbt_krt"></span></b></p>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <p><span style="font-size:12px">Daerah</span><br><b><span id="ppk_daerah_krt" name="ppk_daerah_krt"></span></b></p>
                                                    <p><span style="font-size:12px">Dun</span><br><b><span id="ppk_dun_krt" name="ppk_dun_krt"></span></b></p>
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
                                                <input type="text" class="form-control" name="ppk_pemohon_name" id="ppk_pemohon_name" disabled="">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">No Kad Pengenalan: </label>
                                                <input type="text" class="form-control" name="ppk_pemohon_ic" id="ppk_pemohon_ic" disabled="">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Alamat: </label>
                                                <textarea class="form-control" id="ppk_pemohon_address" name="ppk_pemohon_address" rows="4" disabled=""></textarea>
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
                                        <h6><b>MAKLUMAT PEMBATALAN KRT</b></h6>
                                        <br>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <p>1. Tujuan Pembatalan KRT</p>
                                        <hr class="mt-1">
                                        <form method="POST" id="form_ppk">
                                        @csrf
                                            <div class="row clearfix">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-radio custom-control-inline">
                                                                    <input type="radio" class="custom-control-input" name="ppk_tujuan_pembatalan_id" value="1">
                                                                    <span class="custom-control-label">Persempadanan semula kawasan</span>
                                                                </label>
                                                            </div>
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-radio custom-control-inline">
                                                                    <input type="radio" class="custom-control-input" name="ppk_tujuan_pembatalan_id" value="2">
                                                                    <span class="custom-control-label">Penamaan semula KRT</span>
                                                                </label>
                                                            </div>
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-radio custom-control-inline">
                                                                    <input type="radio" class="custom-control-input" name="ppk_tujuan_pembatalan_id" value="3">
                                                                    <span class="custom-control-label">Pembangunan Semula Kawasan</span>
                                                                </label>
                                                            </div>
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-radio custom-control-inline">
                                                                    <input type="radio" class="custom-control-input" name="ppk_tujuan_pembatalan_id" value="4">
                                                                    <span class="custom-control-label">Pembatalan terus disebabkan tidak dapat diaktifkan semula</span>
                                                                </label>
                                                            </div>
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-radio custom-control-inline">
                                                                    <input type="radio" class="custom-control-input enable_tb" name="ppk_tujuan_pembatalan_id" value="5">
                                                                    <span class="custom-control-label">Lain-lain : Nyatakan</span>
                                                                </label>
                                                            </div>
                                                            <input type="hidden" name="ppk_tujuan_pembatalan_id_checked" id="ppk_tujuan_pembatalan_id_checked" >
                                                            <div class="error_ppk_tujuan_pembatalan_id invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Nyatakan : </label>
                                                            <input type="text" class="form-control" name="ppk_nyatakan_tujuan" id="ppk_nyatakan_tujuan" disabled>
                                                            <div class="error_ppk_nyatakan_tujuan invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <br>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                         <p>2. Maklumat Minit Mesyuarat Berkaitan Pembatalan KRT</p>
                                         <hr class="mt-1">
                                        <form method="#" id="form_ppk2">
                                        {{ csrf_field() }}
                                            <div class="row clearfix">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Minit Mesyuarat Pembatalan: <span class="text-red">*</span></label>
                                                    </div>
                                                    <div class="col-md-12 alert alert-danger error_alert_ppk2" role="alert" style="display: none; padding-bottom: 0px;">
                                                        <ul></ul>
                                                    </div>
                                                    <div class="series-frame">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Tajuk Mesyuarat: </label>
                                                                <select class="select2 custom-select" id="ppk2_minit_mesyuarat_id" name="ppk2_minit_mesyuarat_id">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($minit_mesyuarat as $item)                                    
                                                                        <option value="{{ $item->id }}">{{ $item->mesyuarat_title }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Keterangan: </label>
                                                                <textarea class="form-control" name="ppk2_keterangan" id="ppk2_keterangan" rows="4" placeholder="Keterangan"></textarea>
                                                            </div>
                                                            <input type="hidden" name="ppk2_krt_pembatalan_id" id="ppk2_krt_pembatalan_id">
                                                            <input type="hidden" name="add_minit_meeting_pembatalan_krt" value="add">
                                                            <button type="submit" class="btn btn-primary pull-right" id="btn_add"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                            <br/><br/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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
                                        <form method="POST" id="form_ppk4">
                                        @csrf
                                            <input type="hidden" name="ppk4_krt_pembatalan_id" id="ppk4_krt_pembatalan_id" >
                                            <input type="hidden" name="action" id="post_create_permohonan_pembatalan_krt_1" value="edit">
                                            <input type="hidden" name="post_create_permohonan_pembatalan_krt_1" value="edit">
                                            <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                            <button type="submit" class="btn btn-primary" id="btn_submit">Hantar Permohonan Pembatalan KRT&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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
@stop

@include('js.rt-sm8.j-permohonan-pembatalan-krt-1')
