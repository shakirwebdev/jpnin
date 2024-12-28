@extends('layout.master')
@section('title', 'Sokongan Permohonan Pembatalan KRT')


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
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="row clearfix">
                                                <h6><b>MAKLUMAT KAWASAN RUKUN TETANGGA</b></h6>
                                                <br><br>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="spk_nama_krt" name="spk_nama_krt"></span></b></p>
                                                    <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="spk_alamat_krt" name="spk_alamat_krt"></span></b></p>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <p><span style="font-size:12px">Negeri</span><br><b><span id="spk_negeri_krt" name="spk_negeri_krt"></span></b></p>
                                                    <p><span style="font-size:12px">Parlimen</span><br><b><span id="spk_parlimen_krt" name="spk_parlimen_krt"></span></b></p>
                                                    <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="spk_pbt_krt" name="spk_pbt_krt"></span></b></p>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <p><span style="font-size:12px">Daerah</span><br><b><span id="spk_daerah_krt" name="spk_daerah_krt"></span></b></p>
                                                    <p><span style="font-size:12px">Dun</span><br><b><span id="spk_dun_krt" name="spk_dun_krt"></span></b></p>
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
                                            <h6><b>MAKLUMAT STATUS SOKONGAN</b></h6>
                                            <br><br>
                                            <form method="POST" id="form_spk">
                                            @csrf
                                                <div class="form-group">
                                                    <label class="form-label">Status: <span class="text-red">*</span></label>
                                                    <select class="form-control" name="spk_pembatalan_status" id="spk_pembatalan_status">
                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                        <option value="6" >Disokong</option>
                                                        <option value="7" >Perlu Dikemaskini</option>
                                                    </select>
                                                    <div class="error_spk_pembatalan_status invalid-feedback text-right"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Penerangan: <span class="text-red">*</span></label>
                                                    <textarea class="form-control" rows="4" name="spk_disokong_note"id="spk_disokong_note" placeholder="Penerangan"></textarea>
                                                    <div class="error_spk_disokong_note invalid-feedback text-right"></div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group pull-right">
                                                        <input type="hidden" name="spk_pembatalan_id" id="spk_pembatalan_id">
                                                        <input type="hidden" name="post_sokongan_pembatalan_krt" value="edit">
                                                        <input type="hidden" name="action" id="post_sokongan_pembatalan_krt" value="edit">
                                                        <button type="submit" id="btn_submit" class="btn btn-primary">Hantar Status Sokongan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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
                                        <h6><b>MAKLUMAT PEMBATALAN KRT</b></h6>
                                        <br>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <p>1. Tujuan Pembatalan KRT</p>
                                        <hr class="mt-1">
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <div class="custom-controls-stacked">
                                                            <label class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" class="custom-control-input" name="spk_tujuan_pembatalan_id" value="1" disabled>
                                                                <span class="custom-control-label">Persempadanan semula kawasan</span>
                                                            </label>
                                                        </div>
                                                        <div class="custom-controls-stacked">
                                                            <label class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" class="custom-control-input" name="spk_tujuan_pembatalan_id" value="2" disabled>
                                                                <span class="custom-control-label">Penamaan semula KRT</span>
                                                            </label>
                                                        </div>
                                                        <div class="custom-controls-stacked">
                                                            <label class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" class="custom-control-input" name="spk_tujuan_pembatalan_id" value="3" disabled>
                                                                <span class="custom-control-label">Pembangunan Semula Kawasan</span>
                                                            </label>
                                                        </div>
                                                        <div class="custom-controls-stacked">
                                                            <label class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" class="custom-control-input" name="spk_tujuan_pembatalan_id" value="4" disabled>
                                                                <span class="custom-control-label">Pembatalan terus disebabkan tidak dapat diaktifkan semula</span>
                                                            </label>
                                                        </div>
                                                        <div class="custom-controls-stacked">
                                                            <label class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" class="custom-control-input enable_tb" name="spk_tujuan_pembatalan_id" value="5" disabled>
                                                                <span class="custom-control-label">Lain-lain : Nyatakan</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Nyatakan : </label>
                                                        <input type="text" class="form-control" name="spk_nyatakan_tujuan" id="spk_nyatakan_tujuan" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                         <p>2. Maklumat Minit Meeting Berkaitan Pembatalan KRT</p>
                                         <hr class="mt-1">
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
                                        <p>3. Maklumat Kewangan KRT</p>
                                         <hr class="mt-1">
                                         <div class="table-responsive">
                                            <table class="table thead-dark table-bordered table-striped" id="senarai_maklumat_kewangan_table" style="width: 100%" border="1">
                                                <thead>
                                                    <tr>
                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                        <th><label class="form-label"><font color="#113f50">Tajuk</font></label></th>
                                                        <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                        <button type="button" class="btn btn-secondary" disabled>Seterusnya&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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

@include('js.rt-sm8.j-sokongan-pembatalan-krt-1')
