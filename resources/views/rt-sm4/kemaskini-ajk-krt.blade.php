@extends('layout.master')
@section('parentPageTitle', 'HRMS')
@section('title', 'Kemaskini Ahli Jawatan Kuasa Kawasan Rukun Tetangga')


@section('content')
@include('modal.modal-edit-gambar-ajk-krt')
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
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="kak_krt_nama" name="kak_krt_nama"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="kak_krt_alamat" name="kak_krt_alamat"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="kak_krt_negeri" name="kak_krt_negeri"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="kak_krt_parlimen" name="kak_krt_parlimen"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="kak_krt_pbt" name="kak_krt_pbt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="kak_krt_daerah" name="kak_krt_daerah"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="kak_krt_dun" name="kak_krt_dun"></span></b></p>
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
                                                <h6><b>MAKLUMAT STATUS AHLI JAWATANKUASA</b></h6>
                                                <br>
                                                <form action="#" id="form_kak" >
                                                @csrf
                                                    <div class="form-group">
                                                        <label class="form-label">Status: <span class="text-red">*</span></label>
                                                        <select class="form-control" name="kak_ajk_status" id="kak_ajk_status">
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            <option value="1">Aktif</option>
                                                            <option value="2">Tidak Aktif</option>
                                                        </select>
                                                        <div class="error_kak_ajk_status invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group pull-right">
                                                            <input type="hidden" name="kak_ajk_krt_id" id="kak_ajk_krt_id">
                                                            <input type="hidden" name="post_kemaskini_ahli_krt" value="edit">
                                                            <input type="hidden" name="action" id="post_kemaskini_ahli_krt" value="edit">
                                                            <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                            <button type="submit" class="btn btn-primary" id="btn_submit">Kemaskini Ahli Jawatankuasa&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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
                                        <form action="#" id="form_kak1" >
                                        @csrf
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
                                                        <img src="" class="avatar" alt="Profile Image" id="kak_ajk_gambar" name="kak_ajk_gambar" width="230px"/><br><br>
                                                        <button type="button" class="btn btn-primary" onclick="load_edit_gambar_profile_ajk();">Kemaskini Gambar&nbsp;&nbsp;<i class="dropdown-icon fa fa-edit"></i></button>
                                                    </div>
													<div class="form-group" style="width:30%">
                                                        <label class="form-label">Penggal: </label>
                                                        <input name="kak_ajk_penggal" type="text" disabled class="form-control" id="kak_ajk_penggal" size="4">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Penuh: </label>
                                                        <input type="text" class="form-control" name="kak_ajk_nama" id="kak_ajk_nama" placeholder="Nama Penuh" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">No Kad Pengenalan: </label>
                                                        <input type="text" class="form-control" name="kak_ajk_ic" id="kak_ajk_ic" placeholder="No Kad Pengenalan" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Jantina: </label>
                                                        <select class="form-control" name="kak_ajk_jantina" id="kak_ajk_jantina" disabled>
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            @foreach($ref_jantina as $item)                                    
                                                                <option value="{{ $item->id }}">{{ $item->jantina_description }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Warganegara: </label>
                                                        <input type="text" class="form-control" name="kak_ajk_warganegara" id="kak_ajk_warganegara" placeholder="Warganegara" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Agama: <span class="text-red">*</span></label>
                                                        <select class="form-control" name="kak_ajk_agama" id="kak_ajk_agama">
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            @foreach($ref_agama as $item)                                    
                                                                <option value="{{ $item->id }}">{{ $item->agama_description }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="error_kak_ajk_agama invalid-feedback text-right"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Tarikh lahir: <span class="text-red">*</span></label>
                                                        <input type="text" readonly class="form-control" name="kak_ajk_tarikh_lahir" id="kak_ajk_tarikh_lahir" placeholder="Tarikh Lahir" data-date-format="dd/mm/yyyy">
                                                        <div class="error_kak_ajk_tarikh_lahir invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Umur: <span class="text-red">*</span></label>
														<input type="text" readonly class="form-control" name="kak_ajk_k_umur" id="kak_ajk_k_umur" placeholder="Umur">
                                                        <div class="error_kak_ajk_k_umur invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Kaum: <span class="text-red">*</span></label>
                                                        <select class="form-control" name="kak_ajk_kaum" id="kak_ajk_kaum">
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            @foreach($ref_kaum as $item)                                    
                                                                <option value="{{ $item->id }}">{{ $item->kaum_description }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="error_kak_ajk_kaum invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Telefon: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="kak_ajk_phone" id="kak_ajk_phone" placeholder="No Telefon">
                                                        <div class="error_kak_ajk_phone invalid-feedback text-right"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Alamat: <span class="text-red">*</span></label>
                                                        <textarea class="form-control" rows="5" name="kak_ajk_alamat" id="kak_ajk_alamat"></textarea>
                                                        <div class="error_kak_ajk_alamat invalid-feedback text-right"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Poskod: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="kak_ajk_poskod" id="kak_ajk_poskod" placeholder="Poskod">
                                                        <div class="error_kak_ajk_poskod invalid-feedback text-right"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Pendidikan: <span class="text-red">*</span></label>
                                                        <select class="form-control" name="kak_ajk_pendidikan_id" id="kak_ajk_pendidikan_id">
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            @foreach($ref_pendidikan as $item)                                    
                                                                <option value="{{ $item->id }}">{{ $item->pendidikan_description }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="error_kak_ajk_pendidikan_id invalid-feedback text-right"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Pekerjaan: <span class="text-red">*</span></label>
                                                        <select class="form-control" name="kak_ajk_profession_id" id="kak_ajk_profession_id">
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            @foreach($ref_profession as $item)                                    
                                                                <option value="{{ $item->id }}">{{ $item->profession_description }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="error_kak_ajk_profession_id invalid-feedback text-right"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <br>
                                                    <p>2. Maklumat Jawatan</p>
                                                    <hr class="mt-1">
                                                    <br>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Jawatan: <span class="text-red">*</span></label>
                                                        <select class="form-control" name="kak_ajk_jawatan_krt_id" id="kak_ajk_jawatan_krt_id">
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            @foreach($ref_jawatan_krt as $item)                                    
                                                                <option value="{{ $item->id }}">{{ $item->jawatan_description }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="error_kak_ajk_jawatan_krt_id invalid-feedback text-right"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <b>Tarikh Lantikan Ajk: </b>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                            </div>
                                                            <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="kak_ajk_tarikh_mula" id="kak_ajk_tarikh_mula" placeholder="Tarikh Lahir" data-date-format="dd/mm/yyyy" disabled>
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
                                                            <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="kak_ajk_tarikh_akhir" id="kak_ajk_tarikh_akhir" placeholder="Tarikh Lahir" data-date-format="dd/mm/yyyy" disabled>
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
                                                            <input type="checkbox" name="kak_ajk_bekepentingan"  class="custom-switch-input" value="1">
                                                            <span class="custom-switch-indicator"></span>
                                                            <span class="custom-switch-description">Ya</span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Kepentingan Interaksi Sosial (sila tindakan / Jika Berkaitan): </label>
                                                        <div class="custom-controls-stacked">
                                                            <label class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" name="kak_ajk_bekepentingan_interaksi_1" value="1" disabled>
                                                                <span class="custom-control-label">(a) Memiliki perniagaan dalam kawalan</span>
                                                            </label>
                                                            <label class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" name="kak_ajk_bekepentingan_interaksi_2" value="1" disabled>
                                                                <span class="custom-control-label">(b) Ahli keluarga tingal dalam kawasan </span>
                                                            </label>
                                                            <label class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" name="kak_ajk_bekepentingan_interaksi_3" value="1" disabled>
                                                                <span class="custom-control-label">(c) Bekerja dalam kawasan </span>
                                                            </label>
                                                            <label class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" name="kak_ajk_bekepentingan_interaksi_4" value="1" disabled>
                                                                <span class="custom-control-label">(d) Memegang jawatan dalam persatuan / Pertubuhan lain dalam kawasan</span>
                                                            </label>
                                                            <label class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" name="kak_ajk_bekepentingan_interaksi_5" value="1" disabled>
                                                                <span class="custom-control-label">(e) Lain kepentingan interasi Sosial dengan komuniti dalam kawasan</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Keterangan lanjut mengenai kepentingan interaksi sosial diatas (Sila Nyatakan): </label>
                                                        <textarea class="form-control" rows="5" name="kak_ajk_berkepentingan_keterangan" id="kak_ajk_berkepentingan_keterangan" placeholder="Keterangan lanjut mengenai kepentingan interaksi sosial diatas" disabled></textarea>
                                                        <div class="error_kak_ajk_berkepentingan_keterangan invalid-feedback text-right"></div>
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
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@stop

@include('js.rt-sm4.j-kemaskini-ajk-krt')