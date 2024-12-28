@extends('layout.master')
@section('parentPageTitle', 'HRMS')
@section('title', 'Pengesahan Pendaftaran Ahli Kawasan Rukun Tetangga (Utama)')


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
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="pbpe_krt_nama" name="pbpe_krt_nama"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="pbpe_krt_alamat" name="pbpe_krt_alamat"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="pbpe_krt_negeri" name="pbpe_krt_negeri"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="pbpe_krt_parlimen" name="pbpe_krt_parlimen"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="pbpe_krt_pbt" name="pbpe_krt_pbt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="pbpe_krt_daerah" name="pbpe_krt_daerah"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="pbpe_krt_dun" name="pbpe_krt_dun"></span></b></p>
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
                                                <h6><b>MAKLUMAT STATUS PENGESAHAN</b></h6>
                                                <br>
                                                <form action="#" id="form_pbpe" >
                                                @csrf
                                                    <div class="form-group">
                                                        <label class="form-label">Status: </label>
                                                        <select class="form-control" name="pbpe_ajk_status_form" id="pbpe_ajk_status_form">
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            <option value="5">Disahkan</option>
                                                            <option value="6">Perlu Dikemaskini</option>
                                                        </select>
                                                        <div class="error_pbpe_ajk_status_form invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Penerangan: </label>
                                                        <textarea class="form-control" name="pbpe_disahkan_note" id="pbpe_disahkan_note" rows="4"></textarea>
                                                        <div class="error_pbpe_disahkan_note invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group pull-right">
                                                            <input type="hidden" name="pbpe_ajk_krt_id" id="pbpe_ajk_krt_id">
                                                            <input type="hidden" name="post_pengesahan_ahli_krt" value="edit">
                                                            <input type="hidden" name="action" id="post_pengesahan_ahli_krt" value="edit">
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
                                                <h6><b>MAKLUMAT PEMOHON AHLI KRT</b></h6>
                                                <br>
                                                <p>1. Maklumat Asas</p>
                                                <hr class="mt-1">
                                                <br>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group text-center">
                                                    <img src="" class="avatar" alt="Profile Image" id="pbpe_ajk_gambar" name="pbpe_ajk_gambar" width="230px"/><br><br>
                                                </div>
												<div class="form-group" style="width:30%">
                                                        <label class="form-label">Penggal: </label>
                                                        <input name="pbpe_ajk_penggal" type="text" disabled class="form-control" id="pbpe_ajk_penggal" size="4">
                                                    </div>
                                                <div class="form-group">
                                                    <label class="form-label">Nama Penuh: </label>
                                                    <input type="text" class="form-control" name="pbpe_ajk_nama" id="pbpe_ajk_nama" placeholder="Nama Penuh" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">No Kad Pengenalan: </label>
                                                    <input type="text" class="form-control" name="pbpe_ajk_ic" id="pbpe_ajk_ic" placeholder="No Kad Pengenalan" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Jantina: </label>
                                                    <select class="form-control" name="pbpe_ajk_jantina" id="pbpe_ajk_jantina" disabled>
                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                        @foreach($ref_jantina as $item)                                    
                                                            <option value="{{ $item->id }}">{{ $item->jantina_description }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Warganegara: </label>
                                                    <input type="text" class="form-control" name="pbpe_ajk_warganegara" id="pbpe_ajk_warganegara" placeholder="Warganegara" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Agama: </label>
                                                    <select class="form-control" name="pbpe_ajk_agama" id="pbpe_ajk_agama" disabled>
                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                        @foreach($ref_agama as $item)                                    
                                                            <option value="{{ $item->id }}">{{ $item->agama_description }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <b>Tarikh Lahir: </b>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                        <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="pbpe_ajk_tarikh_lahir" id="pbpe_ajk_tarikh_lahir" placeholder="Tarikh Lahir" data-date-format="dd/mm/yyyy" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Umur: </label>
													<input type="text" readonly class="form-control" name="pbpe_ajk_k_umur" id="pbpe_ajk_k_umur" placeholder="Umur">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Kaum: </label>
                                                    <select class="form-control" name="pbpe_ajk_kaum" id="pbpe_ajk_kaum" disabled>
                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                        @foreach($ref_kaum as $item)                                    
                                                            <option value="{{ $item->id }}">{{ $item->kaum_description }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Telefon: </label>
                                                    <input type="text" class="form-control" name="pbpe_ajk_phone" id="pbpe_ajk_phone" placeholder="No Telefon" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">Alamat: </label>
                                                    <textarea class="form-control" rows="5" name="pbpe_ajk_alamat" id="pbpe_ajk_alamat" disabled></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">Poskod: </label>
                                                    <input type="text" class="form-control" name="pbpe_ajk_poskod" id="pbpe_ajk_poskod" placeholder="Poskod" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">Pendidikan: </label>
                                                    <select class="form-control" name="pbpe_ajk_pendidikan_id" id="pbpe_ajk_pendidikan_id" disabled>
                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                        @foreach($ref_pendidikan as $item)                                    
                                                            <option value="{{ $item->id }}">{{ $item->pendidikan_description }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">Pekerjaan: </label>
                                                    <select class="form-control" name="pbpe_ajk_profession_id" id="pbpe_ajk_profession_id" disabled>
                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                        @foreach($ref_profession as $item)                                    
                                                            <option value="{{ $item->id }}">{{ $item->profession_description }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <br>
                                                <p>2. Maklumat Jawatan</p>
                                                <hr class="mt-1">
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">Jawatan: </label>
                                                    <select class="form-control" name="pbpe_ajk_jawatan_krt_id" id="pbpe_ajk_jawatan_krt_id" disabled>
                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                        @foreach($ref_jawatan_krt as $item)                                    
                                                            <option value="{{ $item->id }}">{{ $item->jawatan_description }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <b>Tarikh Lantikan Ajk: </b>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                        <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="pbpe_ajk_tarikh_mula" id="pbpe_ajk_tarikh_mula" placeholder="Tarikh Lahir" data-date-format="dd/mm/yyyy" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group">
                                                    <b>Tarikh Tamat Ajk: </b>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                        <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="pbpe_ajk_tarikh_akhir" id="pbpe_ajk_tarikh_akhir" placeholder="Tarikh Lahir" data-date-format="dd/mm/yyyy" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <br>
                                                <p>3. AJK Berkepentingan Di Kawasan RT</p>
                                                <hr class="mt-1">
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-switch">
                                                        <input type="checkbox" name="pbpe_ajk_bekepentingan"  class="custom-switch-input" value="1" disabled>
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="custom-switch-description">Ya</span>
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Kepentingan Interaksi Sosial (sila tindakan / Jika Berkaitan): </label>
                                                    <div class="custom-controls-stacked">
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="pbpe_ajk_bekepentingan_interaksi_1" value="1" disabled>
                                                            <span class="custom-control-label">(a) Memiliki perniagaan dalam kawalan</span>
                                                        </label>
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="pbpe_ajk_bekepentingan_interaksi_2" value="1" disabled>
                                                            <span class="custom-control-label">(b) Ahli keluarga tingal dalam kawasan </span>
                                                        </label>
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="pbpe_ajk_bekepentingan_interaksi_3" value="1" disabled>
                                                            <span class="custom-control-label">(c) Bekerja dalam kawasan </span>
                                                        </label>
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="pbpe_ajk_bekepentingan_interaksi_4" value="1" disabled>
                                                            <span class="custom-control-label">(d) Memegang jawatan dalam persatuan / Pertubuhan lain dalam kawasan</span>
                                                        </label>
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="pbpe_ajk_bekepentingan_interaksi_5" value="1" disabled>
                                                            <span class="custom-control-label">(e) Lain kepentingan interasi Sosial dengan komuniti dalam kawasan</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Keterangan lanjut mengenai kepentingan interaksi sosial diatas (Sila Nyatakan): </label>
                                                    <textarea class="form-control" rows="5" name="pbpe_ajk_berkepentingan_keterangan" id="pbpe_ajk_berkepentingan_keterangan" placeholder="Keterangan lanjut mengenai kepentingan interaksi sosial diatas" disabled></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                            <br>
                                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="button" class="btn btn-secondary" disabled>Seterusnya&nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@stop

@include('js.rt-sm4.j-pengesahan-borang-pendaftaran-eIDRT')