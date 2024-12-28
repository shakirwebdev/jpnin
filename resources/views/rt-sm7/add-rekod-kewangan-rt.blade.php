@extends('layout.master')
@section('parentPageTitle', 'HRMS')
@section('title', 'Rekod Penerimaan & Pengeluaran Kewangan')


@section('content')
@include('modal.modal-view-dokumen')
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
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="arkr_nama_krt" name="arkr_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="arkr_alamat_krt" name="arkr_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="arkr_negeri_krt" name="arkr_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="arkr_parlimen_krt" name="arkr_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="arkr_pbt_krt" name="arkr_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="arkr_daerah_krt" name="arkr_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="arkr_dun_krt" name="arkr_dun_krt"></span></b></p>
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
                                        <form action="#" id="form_arkr" >
										{{ csrf_field() }}
                                            <div class="row clearfix">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <h6><b>MAKLUMAT KEWANGAN RUKUN TETANGGA</b></h6>
                                                    <br>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Jenis Kewangan: <span class="text-red">*</span></label>
                                                        <select class="form-control" name="arkr_kewangan_jenis_kewangan" id="arkr_kewangan_jenis_kewangan">
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            @foreach($ref_jenis_kewangan as $item)                                    
                                                                <option value="{{ $item->id }}">{{ $item->jenis_kewangan_description }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="error_arkr_kewangan_jenis_kewangan invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Bank: </label>
                                                        <input type="text" class="form-control" name="arkr_kewangan_nama_bank" id="arkr_kewangan_nama_bank" placeholder="Nama Bank" disabled>
                                                        <div class="error_arkr_kewangan_nama_bank invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Akaun: </label>
                                                        <input type="text" class="form-control" name="arkr_kewangan_no_acc" id="arkr_kewangan_no_acc" placeholder="No Akaun" disabled>
                                                        <div class="error_arkr_kewangan_no_acc invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group" style="display:none;">
                                                        <label class="form-label">No E-Vendor: </label>
                                                        <input type="text" class="form-control" name="arkr_kewangan_no_evendor" id="arkr_kewangan_no_evendor" placeholder="No E-Vendor" disabled>
                                                        <div class="error_arkr_kewangan_no_evendor invalid-feedback text-right"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6" style="border:1px solid;">
                                                    <p>Pihak Yang Membuat Bayaran kepada KRT / Pihak Yang terima Bayaran Daripada KRT</p>
                                                    <hr class="mt-1">
                                                    <div class="form-group">
                                                        <label class="form-label">Penerima / Pembayar (Syarikat / individu/persatuan dan lain-lain : <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="arkr_kewangan_nama_penuh" id="arkr_kewangan_nama_penuh" placeholder="Nama Penuh">
                                                        <div class="error_arkr_kewangan_nama_penuh invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Alamat: <span class="text-red">*</span></label>
                                                        <textarea class="form-control" name="arkr_kewangan_alamat" id="arkr_kewangan_alamat" rows="6" placeholder="Alamat"></textarea>
                                                        <div class="error_arkr_kewangan_alamat invalid-feedback text-right"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Maklumat Kewangan: </label>
														<div>
															<table class="table" id="senarai_trx" name="senarai_trx" style="width: 100%; display:none;">
																<thead>
																	<tr>
                                                                        <th style="background-color: #113f50" ><font color="white">id</font></th>
                                                                        <th style="background-color: #113f50" ><font color="white">tarikh</font></th>
																		<th style="background-color: #113f50" ><font color="white">jenis</font></th>
																		<th style="background-color: #113f50" ><font color="white">tunai</font></th>
																		<th style="background-color: #113f50" ><font color="white">bank</font></th>
																		<th style="background-color: #113f50" ><font color="white">tarikh_kewangan</font></th>   
                                                                    </tr>
																</thead>
															</table>
														</div>
                                                    </div>
                                                    <div class="series-frame">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Butiran: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="arkr_kewangan_butiran" id="arkr_kewangan_butiran" placeholder="Butiran">
                                                                <div class="error_arkr_kewangan_butiran invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <b>Tarikh Penerimaan / Pembayaran: <span class="text-red">*</span></b>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                    </div>
                                                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="arkr_kewangan_tarikh_t_b" id="arkr_kewangan_tarikh_t_b" placeholder="Tarikh Penerimaan / Pembayaran" data-date-format="dd/mm/yyyy">
                                                                    <div class="error_arkr_kewangan_tarikh_t_b invalid-feedback text-right"></div>
                                                                </div>
                                                            </div>
															<div class="form-group">
																<b>Masa (24 jam) <span class="text-red">*</span></b>
																<div class="input-group mb-3">
																	<div class="input-group-prepend">
																		<span class="input-group-text"><i class="fa fa-clock-o"></i></span>
																	</div>
																	<input type="text" class="form-control time24" name="arkr_kewangan_time_t_b" id="arkr_kewangan_time_t_b" placeholder="Masa">
																	<div class="error_arkr_kewangan_time_t_b invalid-feedback text-right"></div>
																</div>
															</div>
                                                            <!-- <div class="form-group">
                                                                <label class="form-label">No Cek / No Baucer / No. Resit: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="arkr_kewangan_cek_baucer" id="arkr_kewangan_cek_baucer" placeholder="No Cek / No Baucer">
                                                            </div>
                                                             <div class="form-group">
                                                                <b>Tarikh Cek / Tarikh Baucer / Tarikh Resit: <span class="text-red">*</span></b>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                    </div>
                                                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="arkr_kewangan_tarikh_cek" id="arkr_kewangan_tarikh_cek" placeholder="Tarikh Cek / Tarikh Baucer" data-date-format="dd/mm/yyyy">
                                                                    <div class="error_arkr_kewangan_tarikh_cek invalid-feedback text-right"></div>
                                                                </div>
                                                            </div> -->
															<div class="form-group border border-info pl-4 pt-2 pr-4 pb-2">
																	<label class="form-label">Jenis Dokumen Sokongan : <span class="text-red">*</span></label>
																	<select class="form-control" id="mag_file_jenis" name="mag_file_jenis">
																		<option id="0" value="">--Sila pilih--</option>
																		<option value="1">Baucer</option>
																		<option value="2">Cek</option>
																		<option value="3">Resit</option>
																		<option value="4">Lain-lain</option>
																	</select>
																	<div class="error_mag_file_jenis invalid-feedback text-right"></div>
																	<br>
                                                                    <label class="form-label">No. Dokumen : <span class="text-red">*</span></label>
                                                                    <input type="text" class="form-control" name="arkr_kewangan_cek_baucer" id="arkr_kewangan_cek_baucer" placeholder="No Cek / No Baucer">
                                                                    <div class="error_arkr_kewangan_cek_baucer invalid-feedback text-right"></div>
                                                                    <br>
                                                                    <b>Tarikh Dokumen : <span class="text-red">*</span></b>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                    </div>
                                                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="arkr_kewangan_tarikh_cek" id="arkr_kewangan_tarikh_cek" placeholder="Tarikh Cek / Tarikh Baucer" data-date-format="dd/mm/yyyy">
                                                                    <div class="error_arkr_kewangan_tarikh_cek invalid-feedback text-right"></div>
                                                                </div>
																	<label class="form-label">Butiran : <span class="text-red">*</span></label>
																	<input type="text" class="form-control" name="mag_butiran" id="mag_butiran" placeholder="Butiran dokumen">
																	<div class="error_mag_butiran invalid-feedback text-right"></div>
																	<br>
																	<label class="form-label">Fail Dokumen Sokongan : <span class="text-red">*</span></label>
																	<input type="file" class="form-control" name="mag_file_dokumen" id="mag_file_dokumen" placeholder="Fail Dokumen Sokongan">
																	<div class="error_mag_file_dokumen invalid-feedback text-right"></div>
																	<br>
																	<div class="row">
																		<input type="hidden" name="mag_dokumen_krt_id" id="mag_dokumen_krt_id">
																		<input type="hidden" name="mag_dokumen_kewangan_id" id="mag_dokumen_kewangan_id">
																		<input type="hidden" name="action" id="post_add_gambar" value="edit">
																		<input type="hidden" name="post_add_gambar" value="edit">
																		<div class="col-sm-3">&nbsp;</div>
																		<div class="col-sm-9" style="text-align:right;">
																			<button id="upload_dokumen" name="upload_dokumen" type="button" class="btn btn-secondary" onclick="add_dokumen();">Muat naik dokumen sokongan</button>
																		</div>
																	</div>
															</div>
															<div class="form-group">
																<b>Senarai Dokumen Sokongan: <span class="text-red">*</span></b>
																<div class="table-responsive">
																	<table class="table table-striped table-vcenter table-hover mb-0" id="senarai_dokumen_sokongan_table" style="width: 100%">
																		<thead>
																			<tr>
																				<th style="background-color: #113f50"><font color="white"><b>Bil</b></font></th>
																				<th style="background-color: #113f50"><font color="white"><b>Jenis</b></font></th>
                                                                                <th style="background-color: #113f50"><font color="white"><b>No. Dokumen</b></font></th>
                                                                                <th style="background-color: #113f50"><font color="white"><b>Tarikh</b></font></th>
																				<th style="background-color: #113f50"><font color="white"><b>Butiran</b></font></th>
																				<th style="background-color: #113f50"><font color="white"><b>Nama fail</b></font></th>
																				<th style="background-color: #113f50"><font color="white"><b>Tindakan</b></font></th>
																			</tr>
																		</thead>
																	</table>
																</div>
															</div>
															
                                                            <div class="form-group">
                                                                <b>Jumlah <span class="text-red">*</span></b>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Tunai (RM)</span>
                                                                    </div>
                                                                    <input type="number" step=".01" class="form-control" name="arkr_kewangan_jumlah_tunai" id="arkr_kewangan_jumlah_tunai" placeholder="cth : 0.00" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)">
                                                                    <div class="error_arkr_kewangan_jumlah_tunai invalid-feedback text-right"></div>
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Bank (RM)</span>
                                                                    </div>
                                                                    <input type="number" step=".01" class="form-control" name="arkr_kewangan_jumlah_bank" id="arkr_kewangan_jumlah_bank" placeholder="cth : 0.00" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)">
                                                                    <div class="error_arkr_kewangan_jumlah_bank invalid-feedback text-right"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <b>Baki</b>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Tunai (RM)</span>
                                                                    </div>
                                                                    <input type="number" class="form-control" name="kewangan_baki_tunai" id="kewangan_baki_tunai" placeholder="Tunai" disabled>
                                                                    <input type="hidden" name="arkr_kewangan_baki_tunai" id="arkr_kewangan_baki_tunai" >
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Bank (RM)</span>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="kewangan_baki_bank" id="kewangan_baki_bank" placeholder="Bank" disabled>
                                                                    <input type="hidden" name="arkr_kewangan_baki_bank" id="arkr_kewangan_baki_bank" >
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Jumlah (RM)</span>
                                                                    </div>
                                                                    <input type="number" class="form-control" name="kewangan_jumlah_baki" id="kewangan_jumlah_baki" placeholder="Jumlah" disabled>
                                                                    <input type="hidden" name="arkr_kewangan_jumlah_baki" id="arkr_kewangan_jumlah_baki" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <br/>
                                                    <input type="hidden" name="arkr_krt_profile_id" id="arkr_krt_profile_id" >
                                                    <input type="hidden" name="post_rekod_kewangan_rt" value="add">
                                                    <input type="hidden" name="action" id="post_rekod_kewangan_rt" value="add">
                                                    <button type="button" class="btn btn-secondary" onclick="kembali();"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                    <button type="submit" class="btn btn-primary" id="btn_send">Hantar Maklumat Kewangan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@stop

@include('js.rt-sm7.j-add-rekod-kewangan-rt')