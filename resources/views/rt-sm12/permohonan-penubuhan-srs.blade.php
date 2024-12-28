@extends('layout.master')
@section('title', 'Permohonan Penubuhan SRS')


@section('content')
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
    <div class="section-body mt-3" style="display:none;" id="pps_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert" >
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> 
                                <span class="text-red blink" id="pps_status_description" name="pps_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> 
                                <span id="pps_disemak_note" name="pps_disemak_note"></span></span>.
                                <br>
                                <input type="hidden" name="pps_status" id="pps_status">
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
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="pps_nama_krt" name="pps_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="pps_alamat_krt" name="pps_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="pps_negeri_krt" name="pps_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="pps_parlimen_krt" name="pps_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="pps_pbt_krt" name="pps_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="pps_daerah_krt" name="pps_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="pps_dun_krt" name="pps_dun_krt"></span></b></p>
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
                                                    <input type="text" class="form-control" name="pps_pemohon_name" id="pps_pemohon_name" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Kad Pengenalan: </label>
                                                    <input type="text" class="form-control" name="pps_pemohon_ic" id="pps_pemohon_ic" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Alamat: </label>
                                                    <textarea class="form-control" id="pps_pemohon_address" name="pps_pemohon_address" rows="4" disabled=""></textarea>
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
                                            <h6><b>MAKLUMAT SKIM RONDAAN SUKARELA</b></h6>
                                            <br>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <p>1. Maklumat Asas</p>
                                            <hr class="mt-1">
                                            <form method="POST" id="form_pps1">
                                            @csrf
                                                <div class="row clearfix">
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Cadangan Nama SRS: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="pps1_srs_name" id="pps1_srs_name"  placeholder="Cadangan Nama SRS">
                                                            <div class="error_pps1_srs_name invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Bilangan Peronda: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="pps1_srs_peronda_total" id="pps1_srs_peronda_total"  placeholder="Bilangan Peronda">
                                                            <div class="error_pps1_srs_peronda_total invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Permohonan Rondaan dan kawalan SRS meliputi: <span class="text-red">*</span></label>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-radio">
                                                                    <input type="radio" class="custom-control-input" name="pps1_srs_kawalan" value="1">
                                                                    <div class="custom-control-label">(i) Keseluruhan Kawasan Rukun Tertangga</div>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input type="radio" class="custom-control-input" name="pps1_srs_kawalan" value="2">
                                                                    <div class="custom-control-label">(ii) Sebahagian Kawasan Rukun Tertangga</div>
                                                                    <div class="error_pps1_srs_kawalan invalid-feedback text-right"></div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="pps1_srs_id" id="pps1_srs_id">
                                                    <input type="hidden" name="action" id="update_kemaskini_srs_profile" value="edit">
                                                    <input type="hidden" name="update_kemaskini_srs_profile" value="edit">
                                                </div>
                                            </form>
                                        </div>
                                        <br>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <p>2. Maklumat Peronda</p>
                                            <hr class="mt-1">
                                            <form method="#" id="form_pps2">
                                            {{ csrf_field() }}
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Senarai Peronda: </label>
                                                        </div>
                                                        <div class="col-md-12 alert alert-danger error_alert_pps2" role="alert" style="display: none; padding-bottom: 0px;">
                                                            <ul></ul>
                                                        </div>
                                                        <div class="series-frame">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <br/>
                                                                    <label class="form-label">Nama Ahli: <span class="text-red">*</span></label>
                                                                    <input type="text" class="form-control" name="pps2_peronda_nama" id="pps2_peronda_nama" placeholder="Nama Ahli">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">No Kad Pengenalan: <span class="text-red">*</span></label>
                                                                    <input type="text" class="form-control" name="pps2_peronda_kad" id="pps2_peronda_kad" placeholder="XXXXXXXXXXXX">
                                                                </div>
                                                                <input type="hidden" name="pps2_srs_profile_id" id="pps2_srs_profile_id">
                                                                <input type="hidden" name="add_peronda" value="add">
                                                                <button type="submit" class="btn btn-primary pull-right" id="btn_add_peronda"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                                <br/><br/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <br>
                                            <div class="table-responsive">
                                                <table class="table thead-dark table-bordered table-striped" id="senarai_peronda_table" style="width: 100%" border="1">
                                                    <thead>
                                                        <tr>
                                                            <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                            <th><label class="form-label"><font color="#113f50">Nama Ahli</font></label></th>
                                                            <th width="30%"><label class="form-label"><font color="#113f50">No Kad</font></label></th>
                                                            <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <form action="#" id="form_pps3" >
                                            @csrf
                                                <input type="hidden" name="update_kemaskini_srs_profile" value="edit">
                                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>&nbsp;
                                                <button type="submit" class="btn btn-primary" id="btn_next">Seterusnya&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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
<link rel="stylesheet" href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}">
@stop

@include('js.rt-sm12.j-permohonan-penubuhan-srs')
