@extends('layout.master')
@section('parentPageTitle', 'HRMS')
@section('title', 'Pengesahan Rekod Penerimaan & Pengeluaran Kewangan')


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
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="prkr_nama_krt" name="prkr_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="prkr_alamat_krt" name="prkr_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="prkr_negeri_krt" name="prkr_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="prkr_parlimen_krt" name="prkr_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="prkr_pbt_krt" name="prkr_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="prkr_daerah_krt" name="prkr_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="prkr_dun_krt" name="prkr_dun_krt"></span></b></p>
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
                                                <form action="#" id="form_prkr_1" >
                                                @csrf
                                                    <div class="form-group">
                                                        <label class="form-label">Status: <span class="text-red">*</span></label>
                                                        <select class="form-control" name="prkr_1_kewangan_status" id="prkr_1_kewangan_status">
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            <option value="1">Disahkan</option>
                                                            <option value="2">Perlu Dikemaskini</option>
                                                        </select>
                                                        <div class="error_prkr_1_kewangan_status invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Penerangan: <span class="text-red">*</span></label>
                                                        <textarea class="form-control" rows="4" name="prkr_1_sahkan_noted" id="prkr_1_sahkan_noted"></textarea>
                                                        <div class="error_prkr_1_sahkan_noted invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group pull-right">
                                                            <input type="hidden" name="prkr_1_krt_profile_id" id="prkr_1_krt_profile_id">
                                                            <input type="hidden" name="prkr_1_kewangan_baki_tunai" id="prkr_1_kewangan_baki_tunai">
                                                            <input type="hidden" name="prkr_1_kewangan_baki_bank" id="prkr_1_kewangan_baki_bank">
                                                            <input type="hidden" name="prkr_1_krt_kewangan_id" id="prkr_1_krt_kewangan_id">
                                                            <input type="hidden" name="post_pengesahan_rekod_kewangan_rt" value="edit">
                                                            <input type="hidden" name="action" id="post_pengesahan_rekod_kewangan_rt" value="edit">
                                                            <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                            <button type="submit" class="btn btn-primary" id="btn_submit">Hantar Status Pengesahan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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
                                                    <select class="form-control" name="prkr_kewangan_jenis_kewangan" id="prkr_kewangan_jenis_kewangan" disabled>
                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                        @foreach($ref_jenis_kewangan as $item)                                    
                                                            <option value="{{ $item->id }}">{{ $item->jenis_kewangan_description }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Akaun: </label>
                                                    <input type="text" class="form-control" name="prkr_kewangan_no_acc" id="prkr_kewangan_no_acc" placeholder="No Akaun" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Nama Bank: </label>
                                                    <input type="text" class="form-control" name="prkr_kewangan_nama_bank" id="prkr_kewangan_nama_bank" placeholder="No E-Vendor" disabled>
                                                </div>
                                                <div class="form-group" style="display:none;">
                                                    <label class="form-label">No E-Vendor: </label>
                                                    <input type="text" class="form-control" name="prkr_kewangan_no_evendor" id="prkr_kewangan_no_evendor" placeholder="No E-Vendor" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">Nama Penuh:</label>
                                                    <input type="text" class="form-control" name="prkr_kewangan_nama_penuh" id="prkr_kewangan_nama_penuh" placeholder="Nama Penuh" disabled>
                                                    <div class="error_prkr_kewangan_nama_penuh invalid-feedback text-right"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Alamat: </label>
                                                    <textarea class="form-control" name="prkr_kewangan_alamat" id="prkr_kewangan_alamat" rows="6" placeholder="Alamat" disabled></textarea>
                                                    <div class="error_prkr_kewangan_alamat invalid-feedback text-right"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">Maklumat Kewangan: </label>
                                                </div>
                                                <div class="series-frame">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Butiran:</label>
                                                            <input type="text" class="form-control" name="prkr_kewangan_butiran" id="prkr_kewangan_butiran" placeholder="Butiran"  disabled="">
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Tarikh Penerimaan / Pembayaran</b>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control" name="prkr_tarikh_t_b" id="prkr_tarikh_t_b" placeholder="Tarikh Penerimaan / Pembayaran" disabled="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">No Cek / No Baucer:</label>
                                                            <input type="text" class="form-control" name="prkr_kewangan_cek_baucer" id="prkr_kewangan_cek_baucer" placeholder="No Cek / No Baucer" disabled="">
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Tarikh Cek / Tarikh Baucer</b>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control" name="prkr_tarikh_c_b" id="prkr_tarikh_c_b" placeholder="Tarikh Cek / Tarikh Baucer" value="01/01/2020" disabled="">
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
                                                                <input type="text" class="form-control" name="prkr_kewangan_jumlah_tunai" id="prkr_kewangan_jumlah_tunai" placeholder="Tunai" disabled="">
                                                                <div class="c_username invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">Bank (RM)</span>
                                                                </div>
                                                                <input type="text" class="form-control" name="prkr_kewangan_jumlah_bank" id="prkr_kewangan_jumlah_bank" placeholder="Bank" disabled="">
                                                                <div class="c_username invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Baki</b>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">Tunai (RM)</span>
                                                                </div>
                                                                <input type="text" class="form-control" name="prkr_kewangan_baki_tunai" id="prkr_kewangan_baki_tunai" placeholder="Tunai" disabled="">
                                                                <div class="c_username invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">Bank (RM)</span>
                                                                </div>
                                                                <input type="text" class="form-control" name="prkr_kewangan_baki_bank" id="prkr_kewangan_baki_bank" placeholder="Bank" disabled="">
                                                                <div class="c_username invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">Jumlah (RM)</span>
                                                                </div>
                                                                <input type="text" class="form-control" name="prkr_kewangan_jumlah_baki" id="prkr_kewangan_jumlah_baki" placeholder="Jumlah" disabled="">
                                                                <div class="c_username invalid-feedback text-right"></div>
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
                </div>
            </div>
        </div>            
    </div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
@stop

@include('js.rt-sm7.j-pengesahan-rekod-kewangan-rt-1')