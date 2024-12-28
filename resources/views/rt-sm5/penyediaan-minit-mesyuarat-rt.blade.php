@extends('layout.master')
@section('title', 'Penyediaan Minit Mesyuarat Jawatankuasa')

@section('content')
@include('modal.modal-add-kehadiran-mesyuarat-krt')
@include('modal.modal-view-kehadiran-mesyuarat-krt')
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
    <div class="section-body mt-3" style="display:none;" id="pmmrt_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert" >
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> <span class="text-red blink" id="pmmrt_status_description" name="pmmrt_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> <span id="pmmrt_disahkan_note" name="pmmrt_disahkan_note"></span></span>.
                                <br>
                                <input type="hidden" name="pmmrt_status" id="pmmrt_status">
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
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="pmmrt_nama_krt" name="pmmrt_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="pmmrt_alamat_krt" name="pmmrt_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="pmmrt_negeri_krt" name="pmmrt_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="pmmrt_parlimen_krt" name="pmmrt_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="pmmrt_pbt_krt" name="pmmrt_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="pmmrt_daerah_krt" name="pmmrt_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="pmmrt_dun_krt" name="pmmrt_dun_krt"></span></b></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="#" id="form_pmmrt" >
                                        @csrf
                                            <div class="row clearfix">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <h6><b>MAKLUMAT MINIT MESYUARAT JAWATANKUASA</b></h6>
                                                    <br>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Tajuk Minit Mesyuarat: <font color="red">*</font></label>
                                                        <input type="text" class="form-control" name="pmmrt_mesyuarat_title" id="pmmrt_mesyuarat_title" placeholder="Tajuk Minit Mesyuarat">
                                                        <div class="error_pmmrt_mesyuarat_title invalid-feedback text-right"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <b>Tarikh Mesyuarat: <span class="text-red">*</span></b>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                            </div>
                                                            <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="pmmrt_mesyuarat_tarikh" id="pmmrt_mesyuarat_tarikh" placeholder="Tarikh Mesyuarat" data-date-format="dd/mm/yyyy">
                                                            <div class="error_pmmrt_mesyuarat_tarikh invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Bil Minit Mesyuarat: <font color="red">*</font></label>
                                                        <input type="text" class="form-control" name="pmmrt_mesyuarat_bil" id="pmmrt_mesyuarat_bil" placeholder="Bil Minit Mesyuarat">
                                                        <div class="error_pmmrt_mesyuarat_bil invalid-feedback text-right"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <b>Masa (24 jam) <span class="text-red">*</span></b>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fa fa-clock-o"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control time24" name="pmmrt_mesyuarat_time" id="pmmrt_mesyuarat_time" placeholder="Masa">
                                                            <div class="error_pmmrt_mesyuarat_time invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                   <div class="form-group">
                                                        <label class="form-label">Tempat Mesyuarat: <font color="red">*</font></label>
                                                        <textarea class="form-control" rows="4" name="pmmrt_mesyuarat_tempat" id="pmmrt_mesyuarat_tempat" placeholder="Tempat"></textarea>
                                                        <div class="error_pmmrt_mesyuarat_tempat invalid-feedback text-right"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Senarai Kehadiran: <span class="text-red">*</span></label>
                                                    </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
															<label class="form-label">AJK: <span class="text-red">*</span></label>
															<div>
																<table class="table" id="senarai_ajk_table" name="senarai_ajk_table" style="width: 100%; display:none;">
																</table>
															</div>
															<div>
																<table class="table" id="senarai_kehadiran_all_table" name="senarai_kehadiran_all_table" style="width: 100%; display:none;">
																</table>
															</div>
                                                            <div>
																<table class="table" id="senarai_kehadiran_ajk_table" name="senarai_kehadiran_ajk_table" style="width: 100%">
																	<thead>
																		<tr>
                                                                        	<th style="background-color: #113f50" ><font color="white">Bil</font></th>
                                                                            <th style="background-color: #113f50" ><font color="white">Nama</font></th>
                                                                            <th style="background-color: #113f50" ><font color="white">Jawatan</font></th>
                                                                            <th style="background-color: #113f50" align="center"><font color="white">Status</font></th>
																			<th style="background-color: #113f50; display:none;" align="center"><font color="white">ID</font></th>
                                                                        </tr>
																	</thead>
																</table>
															</div>
                                                        <div class="series-frame">
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <label class="form-label">Turut Hadir: <span class="text-red">*</span></label>
                                                                    <br>
                                                                    <label class="form-label">Nama : <span class="text-red">*</span></label>
                                                                    <input type="text" class="form-control" name="kehadiran_nama" id="kehadiran_nama" placeholder="Nama kehadiran" oninput="this.value = this.value.toUpperCase()">
                                                                    <div class="error_kehadiran_nama invalid-feedback text-right"></div>
                                                                    <br>
                                                                    <label class="form-label">Jawatan : <span class="text-red">*</span></label>
                                                                    <input type="text" class="form-control" name="kehadiran_ic" id="kehadiran_ic" placeholder="Jawatan" oninput="this.value = this.value.toUpperCase()">
                                                                    <div class="error_kehadiran_ic invalid-feedback text-right"></div>
                                                                    <input type="hidden" id="kehadiran_action" name="kehadiran_action" value="">
																	<input type="hidden" id="add_kehadiran_mesyuarat" name="add_kehadiran_mesyuarat" value="">
                                                                    <br>
                                                                    <button type="button" class="btn btn-primary pull-right" id="btn_save_kehadiran"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                                    <br>
                                                                </div>
                                                        </div>
                                                        <br>
                                                        <br>
                                                        <div>
                                                            <table class="table" id="senarai_kehadiran_table" style="width: 100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="background-color: #113f50"><font color="white">Bil</font></th>
                                                                        <th style="background-color: #113f50"><font color="white">Nama</font></th>
                                                                        <th style="background-color: #113f50"><font color="white">Jawatan</font></th>
                                                                        <th style="background-color: #113f50"><font color="white">Status</font></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    <br>
                                                    <br>
													<div class="form-group">
                                                        <label class="form-label">Dipengerusikan oleh: </label>
														<select id="pmmrt_pengerusi_mesyuarat" name="pmmrt_pengerusi_mesyuarat" class="form-control">
														</select>
														<div class="error_pmmrt_pengerusi_mesyuarat invalid-feedback text-right"></div>
                                                        </div>
														<label class="form-label">Dicatat oleh: </label>
														<select id="pmmrt_catat_mesyuarat" name="pmmrt_catat_mesyuarat" class="form-control">
														</select>
														<div class="error_pmmrt_catat_mesyuarat invalid-feedback text-right"></div>
                                                        </div>
														<br>
														
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Minit Perjumpaan: </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">1. Perutusan Pengerusi: <label><font color="red">*</font></label> </label>
                                                        <textarea name="pmmrt_mesyuarat_perutusan_pengerusi" id="pmmrt_mesyuarat_perutusan_pengerusi" class="form-control" style="white-space: pre-line"></textarea>
                                                        <div class="error_pmmrt_mesyuarat_perutusan_pengerusi invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">2. Pengesahan Minit mesyuarat: <label><font color="red">*</font></label> </label>
                                                            <textarea id="pmmrt_mesyuarat_yang_lalu" name="pmmrt_mesyuarat_yang_lalu" class="form-control"></textarea>
                                                        <div class="error_pmmrt_mesyuarat_yang_lalu invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <input type="hidden" name="pmmrt_minit_mesyuarat_id" id="pmmrt_minit_mesyuarat_id" >
                                                        <input type="hidden" name="post_penyediaan_minit_mesyuarat_rt" value="edit">
                                                        <input type="hidden" name="action" id="post_penyediaan_minit_mesyuarat_rt" value="edit">
                                                        <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                        <button type="submit" class="btn btn-primary" id="btn_next" >Seterusnya&nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
                                                    </div>
                                                </div>
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
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">

<link rel="stylesheet" href="../assets/plugins/datatable/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/plugins/datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/plugins/datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css">

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">

@stop

@include('js.rt-sm5.j-penyediaan-minit-mesyuarat-rt')
