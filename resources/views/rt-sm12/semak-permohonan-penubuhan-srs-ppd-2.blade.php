@extends('layout.master')
@section('title', 'Semak Permohonan Penubuhan SRS')


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
    <div class="section-body mt-3" style="display:none;" id="sppsp_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert" >
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> 
                                <span class="text-red blink" id="sppsp_status_description" name="sppsp_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> 
                                <span id="sppsp_disahkan_note" name="sppsp_disahkan_note"></span></span>.
                                <br>
                                <input type="hidden" name="sppsp_status" id="sppsp_status">
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
                                                    <h6><b>MAKLUMAT KAWASAN RUKUN TETANGGA (KRT)</b></h6>
                                                    <br><br>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="sppsp_2_nama_krt" name="sppsp_2_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="sppsp_2_alamat_krt" name="sppsp_2_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="sppsp_2_negeri_krt" name="sppsp_2_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="sppsp_2_parlimen_krt" name="sppsp_2_parlimen_krt"></span></b></p>
                                                        
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="sppsp_2_pbt_krt" name="sppsp_2_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="sppsp_2_daerah_krt" name="sppsp_2_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="sppsp_2_dun_krt" name="sppsp_2_dun_krt"></span></b></p>
                                                        
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
                                                    <input type="text" class="form-control" name="sppsp_2_nama_pemohon" id="sppsp_2_nama_pemohon" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Kad Pengenalan: </label>
                                                    <input type="text" class="form-control" name="sppsp_2_ic_pemohon" id="sppsp_2_ic_pemohon" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Alamat: </label>
                                                    <textarea class="form-control" id="sppsp_2_address_pemohon" name="sppsp_2_address_pemohon" rows="4" disabled=""></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT STATUS SEMAKAN</b></h6>
                                                <br><br>
                                                <form action="#" id="form_sppsp_2" >
                                                @csrf
                                                    <div class="form-group">
                                                        <label class="form-label">Status: <span class="text-red">*</span></label>
                                                        <select class="form-control" name="sppsp_2_srs_status" id="sppsp_2_srs_status">
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            <option value="5">Disemak</option>
                                                            <option value="6">Perlu Dikemaskini</option>
                                                        </select>
                                                        <div class="error_sppsp_2_srs_status invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Penerangan: <span class="text-red">*</span></label>
                                                        <textarea class="form-control" rows="4" name="sppsp_2_disemak_note" id="sppsp_2_disemak_note"></textarea>
                                                        <div class="error_sppsp_2_disemak_note invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group pull-right">
                                                            <input type="hidden" name="sppsp_2_srs_id" id="sppsp_2_srs_id">
                                                            <input type="hidden" name="post_semak_permohonan_penubuhan_srs" value="edit">
                                                            <input type="hidden" name="action" id="post_semak_permohonan_penubuhan_srs" value="edit">
                                                            <button type="submit" class="btn btn-primary" id="btn_submit">Hantar Status Semakan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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
                                            <h6><b>MAKLUMAT SKIM RONDAAN SUKARELA</b></h6>
                                            <br>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <p>4. Maklumat Minit Mesyuarat Penubuhan SRS</p>
                                            <hr class="mt-1">
                                            <div class="row clearfix">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
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
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <p>5. Muat Naik Pelan Lakar Dan Diskripsi Sempadan Kawasan Rondaan Dan Kawalan Tersebut <span class="text-red">*</span></p>
                                            <hr class="mt-1">
                                            <form action="#" id="form_sppsppd2">
                                                {{ csrf_field() }}
                                                <div class="col-md-12 alert alert-danger error_form_sppsppd2" role="alert" style="display: none; padding-bottom: 0px;">
                                                    <ul></ul>
                                                </div>
                                                <div class="series-frame">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Tajuk Fail : </label>
                                                            <input type="text" class="form-control" name="sppsppd2_file_title" id="sppsppd2_file_title" placeholder="Tajuk Fail">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Catatan Fail: </label>
                                                            <textarea class="form-control" id="sppsppd2_file_catatan" name="sppsppd2_file_catatan" rows="4" placeholder="Catatan Fail"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Fail : </label>
                                                            <input type="file" class="form-control" name="sppsppd2_file_peta" id="sppsppd2_file_peta" placeholder="Fail">
                                                        </div>
                                                        <input type="hidden" name="sppsppd2_srs_profile_id" id="sppsppd2_srs_profile_id">
                                                        <input type="hidden" name="add_profile_srs_peta_kawasan" value="add">
                                                        <button type="submit" class="btn btn-primary pull-right" id="btn_save_peta_kawasan"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                    </div>
                                                </div>
                                                <br/><br/>
                                                <div class="table-responsive">
                                                    <table class="table thead-dark table-bordered table-striped" id="senarai_peta_kawasan_srs_table" style="width: 100%" border="1">
                                                        <thead>
                                                            <tr>
                                                                <th width="6%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">Tajuk Fail</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">Catatan Fail</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">Fail</font></label></th>
                                                                <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </form>
                                        </div>
                                        <br>
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

@include('js.rt-sm12.j-semak-permohonan-penubuhan-srs-ppd-2')
