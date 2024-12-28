@extends('layout.master')
@section('title', 'Permohonan Pelaporan i-Ramal')


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
    <div class="section-body mt-3" style="display:none;" id="pmbpp_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert" >
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> 
                                <span class="text-red blink" id="pmbpp_status_description" name="pmbpp_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> 
                                <span id="pmbpp_diakui_note" name="pmbpp_diakui_note"></span></span>
                                <span id="pmbpp_disemak_note" name="pmbpp_disemak_note"></span></span>
                                <span id="pmbpp_disahkan_note" name="pmbpp_disahkan_note"></span></span>.
                                <br>
                                <input type="hidden" name="pmbpp_status" id="pmbpp_status">
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
                                            <div class="col-12">
                                                <form method="POST" id="form_pmbpp">
                                                @csrf
                                                    <h6><b>MAKLUMAT KES DALAM KRT</b></h6>
                                                    <br>
                                                    <div class="form-group">
                                                        <label class="custom-switch">
                                                            <input type="checkbox" name="pmbpp_hasRT" id="pmbpp_hasRT" class="custom-switch-input">
                                                            <span class="custom-switch-indicator"></span>
                                                            <span class="custom-switch-description">Kejadian Kes Dalam KRT</span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Negeri: <span class="text-red">*</span></label>
                                                        <select class="form-control" name="pmbpp_state_id" id="pmbpp_state_id" disabled>
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            @foreach($negeri as $item)                                    
                                                                <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="error_pmbpp_state_id invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Daerah: <span class="text-red">*</span></label>
                                                        <select class="form-control" name="pmbpp_daerah_id" id="pmbpp_daerah_id" disabled>
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            @foreach($daerah as $item)                                    
                                                                <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="error_pmbpp_daerah_id invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Nama KRT: <span class="text-red">*</span></label>
                                                        <select class="form-control" name="pmbpp_krt_profile_id" id="pmbpp_krt_profile_id" disabled>
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            @foreach($krt as $item)                                    
                                                                <option value="{{ $item->id }}">{{ $item->krt_nama }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="error_pmbpp_krt_profile_id invalid-feedback text-right"></div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <form method="POST" id="form_pmbpp1">
                                                @csrf
                                                    <h6><b>MAKLUMAT PEMOHON</b></h6>
                                                    <br><br>
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Pemohon: </label>
                                                        <input type="text" class="form-control" name="pmbpp1_nama_permohon" id="pmbpp1_nama_permohon" placeholder="Nama Pemohon" disabled="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Kad Pengenalan: </label>
                                                        <input type="text" class="form-control" name="pmbpp1_ic_pemohon" id="pmbpp1_ic_pemohon" placeholder="No Kad Pengenalan" disabled="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Telefon: </label>
                                                        <input type="text" class="form-control" name="pmbpp1_phone_pemohon" id="pmbpp1_phone_pemohon" placeholder="No Telefonn" value="930508-09-5161" disabled="">
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
                                            <h6><b>MAKLUMAT DARI SUMBER YANG MUNGKIN BERLAKU</b></h6>
                                            <br>
                                            <p>1. Maklumat Kes : </p>
                                            <hr class="mt-1">
                                            <form method="POST" id="form_pmbpp2">
                                            @csrf
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="row clearfix">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Tajuk: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pmbpp2_imuhibbah_tajuk" id="pmbpp2_imuhibbah_tajuk" placeholder="Tajuk">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Negeri: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="pmbpp2_state_id" id="pmbpp2_state_id">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($negeri as $item)                                    
                                                                        <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_pmbpp2_state_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Bandar: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="pmbpp2_bandar_id" id="pmbpp2_bandar_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($bandar as $item)                                    
                                                                        <option value="{{ $item->id }}">{{ $item->bandar_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_pmbpp2_bandar_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Lokasi / Nama Jalan: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pmbpp2_imuhibbah_lokasi" id="pmbpp2_imuhibbah_lokasi" placeholder="Lokasi / Nama Jalan">
                                                                <div class="error_pmbpp2_imuhibbah_lokasi invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Parlimen: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="pmbpp2_parlimen_id" id="pmbpp2_parlimen_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($parlimen as $item)                                    
                                                                        <option value="{{ $item->parlimen_id }}">{{ $item->parlimen_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_pmbpp2_parlimen_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">PBT: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="pmbpp2_pbt_id" id="pmbpp2_pbt_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($pbt as $item)                                    
                                                                        <option value="{{ $item->pbt_id }}">{{ $item->pbt_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_pmbpp2_pbt_id invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Daerah: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="pmbpp2_daerah_id" id="pmbpp2_daerah_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($daerah as $item)                                    
                                                                        <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_pmbpp2_daerah_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Taman / Kampung: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pmbpp2_imuhibbah_kawasan" id="pmbpp2_imuhibbah_kawasan" placeholder="Taman / Kampung">
                                                                <div class="error_pmbpp2_imuhibbah_kawasan invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Poskod: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pmbpp2_imuhibbah_poskod" id="pmbpp2_imuhibbah_poskod" placeholder="Poskod">
                                                                <div class="error_pmbpp2_imuhibbah_poskod invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Dun: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="pmbpp2_dun_id" id="pmbpp2_dun_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($dun as $item)                                    
                                                                        <option value="{{ $item->dun_id }}">{{ $item->dun_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_pmbpp2_dun_id invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <b>Tarikh Laporan: <span class="text-red">*</span></b>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                    </div>
                                                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="pmbpp2_imuhibbah_tarikh_laporan" id="pmbpp2_imuhibbah_tarikh_laporan" placeholder="Tarikh Laporan" data-date-format="dd/mm/yyyy">
                                                                </div>
                                                                <div class="error_pmbpp2_imuhibbah_tarikh_laporan invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <b>Tarikh Jangkaan Berlaku: <span class="text-red">*</span></b>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                    </div>
                                                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="pmbpp2_imuhibbah_tarikh_j_berlaku" id="pmbpp2_imuhibbah_tarikh_j_berlaku" placeholder="Tarikh Berlaku" data-date-format="dd/mm/yyyy">
                                                                </div>
                                                                <div class="error_pmbpp2_imuhibbah_tarikh_j_berlaku invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Laporan: <span class="text-red">*</span></label>
                                                                <textarea class="form-control" name="pmbpp2_imuhibbah_laporan" id="pmbpp2_imuhibbah_laporan" ></textarea>
                                                                <div class="error_pmbpp2_imuhibbah_laporan invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Sumber Maklumat: <span class="text-red">*</span></label>
                                                                <textarea class="form-control" name="pmbpp2_imuhibbah_sumber_maklumat" id="pmbpp2_imuhibbah_sumber_maklumat" ></textarea>
                                                                <div class="error_pmbpp2_imuhibbah_sumber_maklumat invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <p>2. Butiran- Butiran Pelapor : </p>
                                                <hr class="mt-1">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="row clearfix">
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Nama: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pmbpp2_imuhibbah_pelapor_nama" id="pmbpp2_imuhibbah_pelapor_nama" placeholder="Nama">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">No Telefon: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pmbpp2_imuhibbah_pelapor_no" id="pmbpp2_imuhibbah_pelapor_no" placeholder="No Telefon" >
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Jawatan: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pmbpp2_imuhibbah_pelapor_jawatan" id="pmbpp2_imuhibbah_pelapor_jawatan" placeholder="Jawatan" >
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Alamat: <span class="text-red">*</span></label>
                                                                <textarea class="form-control" id="pmbpp2_imuhibbah_pelapor_alamat" name="pmbpp2_imuhibbah_pelapor_alamat" rows="5" placeholder="Alamat" ></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <form method="POST" id="form_pmbpp3">
                                            @csrf
                                                <input type="hidden" name="pmbpp3_imuhibbah_id" id="pmbpp3_imuhibbah_id">
                                                <input type="hidden" name="post_permohonan_imuhibbah_bpp_1" value="edit">
                                                <input type="hidden" name="action" id="post_permohonan_imuhibbah_bpp_1" value="edit">
                                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="submit" class="btn btn-primary" id="btn_submit">Hantar Permohonan i-Ramal&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@stop

@include('js.rt-sm22.j-permohonan-muhibbah-bpp')
