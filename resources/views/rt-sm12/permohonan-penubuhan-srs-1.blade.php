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
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="pps4_nama_krt" name="pps4_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="pps4_alamat_krt" name="pps4_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="pps4_negeri_krt" name="pps4_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="pps4_parlimen_krt" name="pps4_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="pps4_pbt_krt" name="pps4_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="pps4_daerah_krt" name="pps4_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="pps4_dun_krt" name="pps4_dun_krt"></span></b></p>
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
                                                    <input type="text" class="form-control" name="pps4_pemohon_name" id="pps4_pemohon_name" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Kad Pengenalan: </label>
                                                    <input type="text" class="form-control" name="pps4_pemohon_ic" id="pps4_pemohon_ic" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Alamat: </label>
                                                    <textarea class="form-control" id="pps4_pemohon_address" name="pps4_pemohon_address" rows="4" disabled=""></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <h6><b>MAKLUMAT SKIM RONDAAN SUKARELA</b></h6>
                                                <br>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <p>3. Maklumat Peronda Sukarela</p>
                                                <hr class="mt-1">
                                                <form action="#" id="form_pps5">
                                                {{ csrf_field() }}
                                                    <div class="form-group">
                                                        <label class="form-label">Maklumat Peronda Sukarela : <span class="text-red">(minimun 20 org) </span></label>
                                                    </div>
                                                    <div class="col-md-12 alert alert-danger error_alert_pps5" role="alert" style="display: none; padding-bottom: 0px;">
                                                        <ul></ul>
                                                    </div>
                                                    <div class="series-frame">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <br/>
                                                                <label class="form-label">Nama: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pps5_p_sukarela_nama" id="pps5_p_sukarela_nama" placeholder="Nama">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">No Kad Pengenalan: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pps5_p_sukarela_kad" id="pps5_p_sukarela_kad" placeholder="XXXXXXXXXXXX">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Jantina: <span class="text-red">*</span></label>
                                                                <select class="select2 custom-select" id="pps5_jantina_id" name="pps5_jantina_id">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($jantina as $item)                                    
                                                                        <option value="{{ $item->id }}">{{ $item->jantina_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Pekerjaan: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pps5_p_sukarela_pekerjaan" id="pps5_p_sukarela_pekerjaan" placeholder="Pekerjaan">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Alamat Kediaman: <span class="text-red">*</span></label>
                                                                <textarea class="form-control" rows="3" name="pps5_p_sukarela_alamat_k" id="pps5_p_sukarela_alamat_k" placeholder="Alamat Kediaman"></textarea>
                                                            </div>
                                                            <input type="hidden" name="pps5_srs_profile_id" id="pps5_srs_profile_id">
                                                            <input type="hidden" name="add_peronda_sukarela" value="add">
                                                            <button type="submit" class="btn btn-primary pull-right" id="btn_save_peronda_sukarela"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                            <br/><br/>
                                                        </div>
                                                    </div>
                                                </form>
                                                <br>
                                                <div class="table-responsive">
                                                    <table class="table thead-dark table-bordered table-striped" id="senarai_peronda_sukarela_table" style="width: 100%" border="1">
                                                        <thead>
                                                            <tr>
                                                                <th><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">Nama</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">No kad Pengenalan</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">Jantina</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">Pekerjaan</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">Alamat Kediaman</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="button" class="btn btn-primary" id="btn_next">Seterusnya&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
@stop

@include('js.rt-sm12.j-permohonan-penubuhan-srs-1')
