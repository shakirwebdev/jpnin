@extends('layout.master')
@section('parentPageTitle', 'HRMS')
@section('title', 'Semakan Rekod Penerimaan & Pengeluaran Kewangan')


@section('content')
@include('modal.modal-view-dokumen')
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
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="srkr_nama_krt" name="srkr_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="srkr_alamat_krt" name="srkr_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="srkr_negeri_krt" name="srkr_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="srkr_parlimen_krt" name="srkr_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="srkr_pbt_krt" name="srkr_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="srkr_daerah_krt" name="srkr_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="srkr_dun_krt" name="srkr_dun_krt"></span></b></p>
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
                                                <h6><b>MAKLUMAT STATUS SEMAKAN</b></h6>
                                                <br><br>
                                                <form action="#" id="form_srkr_1" >
                                                @csrf
                                                    <div class="form-group">
                                                        <label class="form-label">Status: <span class="text-red">*</span></label>
                                                        <select class="form-control" name="srkr_1_kewangan_status" id="srkr_1_kewangan_status">
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            <option value="6">Disemak</option>
                                                            <option value="4">Perlu Dikemaskini</option>
                                                        </select>
                                                        <div class="error_srkr_1_kewangan_status invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Penerangan: <span class="text-red">*</span></label>
                                                        <textarea class="form-control" rows="4" name="srkr_1_semak_noted" id="srkr_1_semak_noted"></textarea>
                                                        <div class="error_srkr_1_semak_noted invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group pull-right">
                                                            <input type="hidden" name="srkr_1_krt_kewangan_id" id="srkr_1_krt_kewangan_id">
                                                            <input type="hidden" name="post_semakan_rekod_kewangan_rt" value="edit">
                                                            <input type="hidden" name="action" id="post_semakan_rekod_kewangan_rt" value="edit">
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
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <h6><b>MAKLUMAT KEWANGAN RUKUN TETANGGA</b></h6>
                                                <br>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">Jenis Kewangan: </label>
                                                    <select class="form-control" name="srkr_kewangan_jenis_kewangan" id="srkr_kewangan_jenis_kewangan" disabled>
                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                        @foreach($ref_jenis_kewangan as $item)                                    
                                                            <option value="{{ $item->id }}">{{ $item->jenis_kewangan_description }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Nama Bank: </label>
                                                    <input type="text" class="form-control" name="srkr_kewangan_nama_bank" id="srkr_kewangan_nama_bank" placeholder="No E-Vendor" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Akaun: </label>
                                                    <input type="text" class="form-control" name="srkr_kewangan_no_acc" id="srkr_kewangan_no_acc" placeholder="No Akaun" disabled>
                                                </div>
                                                <div class="form-group" style="display:none;">
                                                    <label class="form-label">No E-Vendor: </label>
                                                    <input type="text" class="form-control" name="srkr_kewangan_no_evendor" id="srkr_kewangan_no_evendor" placeholder="No E-Vendor" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6" style="border:1px solid ">
                                                <div class="form-group">
                                                    <label class="form-label">Penerima / Pembayar (Syarikat / individu/persatuan dan lain-lain) : </label>
                                                    <input type="text" class="form-control" name="srkr_kewangan_nama_penuh" id="srkr_kewangan_nama_penuh" placeholder="Nama Penuh" disabled>
                                                    <div class="error_srkr_kewangan_nama_penuh invalid-feedback text-right"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Alamat: </label>
                                                    <textarea class="form-control" name="srkr_kewangan_alamat" id="srkr_kewangan_alamat" rows="6" placeholder="Alamat" disabled></textarea>
                                                    <div class="error_srkr_kewangan_alamat invalid-feedback text-right"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
												<div class="form-group">
													<div>
														<table class="table" id="senarai_trx" name="senarai_trx" style="width: 100%; display:none;">
														</table>
													</div>
												</div>
                                                <div class="form-group">
                                                    <label class="form-label">Maklumat Kewangan: </label>
                                                </div>
                                                <div class="series-frame">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Butiran:</label>
                                                            <input type="text" class="form-control" name="srkr_kewangan_butiran" id="srkr_kewangan_butiran" placeholder="Butiran"  disabled="">
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Tarikh Penerimaan / Pembayaran</b>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control" name="srkr_kewangan_tarikh_t_b" id="srkr_kewangan_tarikh_t_b" placeholder="Tarikh Penerimaan / Pembayaran" disabled="">
                                                            </div>
                                                        </div>
														<div class="form-group">
															<b>Masa (24 jam) <span class="text-red">*</span></b>
															<div class="input-group mb-3">
																<div class="input-group-prepend">
																	<span class="input-group-text"><i class="fa fa-clock-o"></i></span>
																</div>
																<input type="text" class="form-control time24" name="srkr_kewangan_time_t_b" id="srkr_kewangan_time_t_b" placeholder="Masa" disabled="">
																<div class="error_srkr_kewangan_time_t_b invalid-feedback text-right"></div>
															</div>
														</div>
														<div class="form-group">
																<b>Senarai Dokumen Sokongan:</b>
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
                                                            <b>Jumlah</b>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">Tunai (RM)</span>
                                                                </div>
                                                                <input type="number" class="form-control" name="srkr_kewangan_jumlah_tunai" id="srkr_kewangan_jumlah_tunai" placeholder="Tunai" disabled="" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)">
                                                                <div class="c_username invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">Bank (RM)</span>
                                                                </div>
                                                                <input type="number" class="form-control" name="srkr_kewangan_jumlah_bank" id="srkr_kewangan_jumlah_bank" placeholder="Bank" disabled="" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)">
                                                                <div class="c_username invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Baki</b>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">Tunai (RM)</span>
                                                                </div>
                                                                <input type="text" class="form-control" name="srkr_kewangan_baki_tunai" id="srkr_kewangan_baki_tunai" placeholder="Tunai" disabled="">
                                                                <div class="c_username invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">Bank (RM)</span>
                                                                </div>
                                                                <input type="text" class="form-control" name="srkr_kewangan_baki_bank" id="srkr_kewangan_baki_bank" placeholder="Bank" disabled="">
                                                                <div class="c_username invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">Jumlah (RM)</span>
                                                                </div>
                                                                <input type="text" class="form-control" name="srkr_kewangan_jumlah_baki" id="srkr_kewangan_jumlah_baki" placeholder="Jumlah" disabled="">
                                                                <div class="c_username invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <br>
                                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
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
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
@stop

@include('js.rt-sm7.j-semakan-rekod-kewangan-rt-1')