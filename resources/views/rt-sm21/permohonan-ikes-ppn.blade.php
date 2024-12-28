@extends('layout.master')
@section('title', 'Permohonan Pelaporan i-Kes')


@section('content')
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <small>Isi maklumat pada borang yang disediakan dibawah, dan tekan butang SETERUSNYA. 
                        <br>
                        Ruangan bertanda <span class="text-red">*</span> adalah ruangan mandatori dan perlu diisi..&nbsp;&nbsp;<a href="#"><i class="dropdown-icon fe fe-help-circle"></i></a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section-body mt-3" style="display:none;" id="pipn_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert" >
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> 
                                <span class="text-red blink" id="pipn_status_description" name="pipn_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> 
                                <span id="pipn_diakui_note" name="pipn_diakui_note"></span></span>
                                <span id="pipn_disemak_note" name="pipn_disemak_note"></span></span>
                                <span id="pipn_disahkan_note" name="pipn_disahkan_note"></span></span>.
                                <br>
                                <input type="hidden" name="pipn_status" id="pipn_status">
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
                                                <form method="POST" id="form_pipn">
                                                @csrf
                                                    <h6><b>MAKLUMAT KES DALAM KRT</b></h6>
                                                    <br>
                                                    <div class="form-group">
                                                        <label class="custom-switch">
                                                            <input type="checkbox" name="pipn_hasRT" id="pipn_hasRT" class="custom-switch-input">
                                                            <span class="custom-switch-indicator"></span>
                                                            <span class="custom-switch-description">Kejadian Kes Dalam KRT</span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Negeri: <span class="text-red">*</span></label>
                                                        <select class="form-control" name="pipn_negeri_id" id="pipn_negeri_id" disabled>
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            @foreach($negeri as $item)                                    
                                                                <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="error_pipn_negeri_id invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Daerah: <span class="text-red">*</span></label>
                                                        <select class="form-control" name="pipn_daerah_id" id="pipn_daerah_id" disabled>
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            @foreach($daerah as $item)                                    
                                                                <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="error_pipn_daerah_id invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Nama KRT: <span class="text-red">*</span></label>
                                                        <select class="form-control" name="pipn_krt_profile_id" id="pipn_krt_profile_id" disabled>
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            @foreach($krt as $item)                                    
                                                                <option value="{{ $item->id }}">{{ $item->krt_nama }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="error_pipn_krt_profile_id invalid-feedback text-right"></div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <form method="POST" id="form_pipn1">
                                                @csrf
                                                    <h6><b>MAKLUMAT PEMOHON</b></h6>
                                                    <br><br>
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Pemohon: </label>
                                                        <input type="text" class="form-control" name="pipn1_user_fullname" id="pipn1_user_fullname" placeholder="Nama Pemohon" disabled="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Kad Pengenalan: </label>
                                                        <input type="text" class="form-control" name="pipn1_user_no_ic"  id="pipn1_user_no_ic" placeholder="No Kad Pengenalan" disabled="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Telefon: </label>
                                                        <input type="text" class="form-control" name="pipn1_user_no_phone" id="pipn1_user_no_phone" placeholder="No Kad Pengenalan" disabled="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Alamat Pejabat: <span class="text-red">*</span></label>
                                                        <textarea class="form-control" id="pipn1_dihantar_alamat" name="pipn1_dihantar_alamat" rows="4" ></textarea>
                                                        <div class="error_pipn1_dihantar_alamat invalid-feedback text-right"></div>
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
                                            <h6><b>MAKLUMAT KES KEJADIAN</b></h6>
                                            <br>
                                            <p>1. Maklumat Kes Kejadian : </p>
                                            <hr class="mt-1">
                                            <form method="POST" id="form_pipn2">
                                            @csrf
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="row clearfix">
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Negeri: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="pipn2_negeri_id" id="pipn2_negeri_id">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($negeri as $item)                                    
                                                                        <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_pipn2_negeri_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Bandar: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="pipn2_bandar_id" id="pipn2_bandar_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($bandar as $item)                                    
                                                                        <option value="{{ $item->id }}">{{ $item->bandar_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_pipn2_bandar_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Lokasi / Nama Jalan: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pipn2_ikes_lokasi" id="pipn2_ikes_lokasi" placeholder="Lokasi / Nama Jalan">
                                                                <div class="error_pipn2_ikes_lokasi invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Parlimen: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="pipn2_parlimen_id" id="pipn2_parlimen_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($parlimen as $item)                                    
                                                                        <option value="{{ $item->parlimen_id }}">{{ $item->parlimen_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_pipn2_parlimen_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">PBT: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="pipn2_pbt_id" id="pipn2_pbt_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($pbt as $item)                                    
                                                                        <option value="{{ $item->pbt_id }}">{{ $item->pbt_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_pipn2_pbt_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <b>Tarikh Berlaku: <span class="text-red">*</span></b>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                    </div>
                                                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="pipn2_ikes_tarikh_berlaku" id="pipn2_ikes_tarikh_berlaku" placeholder="Tarikh Berlaku" data-date-format="dd/mm/yyyy">
                                                                </div>
                                                                <div class="error_pipn2_ikes_tarikh_berlaku invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Daerah: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="pipn2_daerah_id" id="pipn2_daerah_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($daerah as $item)                                    
                                                                        <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_pipn2_daerah_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Taman / Kampung: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pipn2_ikes_kawasan" id="pipn2_ikes_kawasan" placeholder="Taman / Kampung">
                                                                <div class="error_pipn2_ikes_kawasan invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Poskod: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pipn2_ikes_poskod" id="pipn2_ikes_poskod" placeholder="Poskod">
                                                                <div class="error_pipn2_ikes_poskod invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Dun: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="pipn2_dun_id" id="pipn2_dun_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($dun as $item)                                    
                                                                        <option value="{{ $item->dun_id }}">{{ $item->dun_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_pipn2_dun_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Balai Polis Berdekatan: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pipn2_ikes_bpolis" id="pipn2_ikes_bpolis" placeholder="Balai Polis Berdekatan">
                                                                <div class="error_pipn2_ikes_bpolis invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <p>2. Maklumat Kes : </p>
                                                <hr class="mt-1">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="row clearfix">
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Peringkat Kes: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="pipn2_peringkat_kes_id" id="pipn2_peringkat_kes_id">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($peringkat_kes as $item)                                    
                                                                        <option value="{{ $item->id }}">{{ $item->peringkat_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_pipn2_peringkat_kes_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Sub Kategori: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="pipn2_sub_kategori_kes_id" id="pipn2_sub_kategori_kes_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                </select>
                                                                <div class="error_pipn2_sub_kategori_kes_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Sub-kluster: <span class="text-red">*</span></label>
                                                                <select class="select2 custom-select" id="pipn2_sub_kluster_id" name="pipn2_sub_kluster_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                </select>
                                                                <div class="error_pipn2_sub_kluster_id invalid-feedback text-right"></div>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Kategori Kes: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="pipn2_kategori_kes_id" id="pipn2_kategori_kes_id">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($kategori_kes as $item)                                    
                                                                        <option value="{{ $item->id }}">{{ $item->kategori_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_pipn2_kategori_kes_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Kluster: <span class="text-red">*</span></label>
                                                                <select class="select2 custom-select" id="pipn2_kluster_id" name="pipn2_kluster_id">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($kluster as $item)                                    
                                                                        <option value="{{ $item->id }}">{{ $item->kluster_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_pipn2_kluster_id invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Keterangan Kes: <span class="text-red">*</span></label>
                                                                <textarea class="form-control" name="pipn2_ikes_keterangan_kes" id="pipn2_ikes_keterangan_kes" ></textarea>
                                                                <div class="error_pipn2_ikes_keterangan_kes invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Tindakan/Maklumbalas Awal JPNIN: <span class="text-red">*</span></label>
                                                                <textarea class="form-control" name="pipn2_ikes_tindakan_awal" id="pipn2_ikes_tindakan_awal" ></textarea>
                                                                <div class="error_pipn2_ikes_tindakan_awal invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Sumber: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pipn2_ikes_sumber" id="pipn2_ikes_sumber" placeholder="Sumber">
                                                                <div class="error_pipn2_ikes_sumber invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <form method="POST" id="form_pipn3">
                                            @csrf
                                                <input type="hidden" name="pipn3_ikes_id" id="pipn3_ikes_id">
                                                <input type="hidden" name="post_permohonan_ikes_ppn_1" value="edit">
                                                <input type="hidden" name="action" id="post_permohonan_ikes_ppn_1" value="edit">
                                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="submit" class="btn btn-primary" id="btn_next">Seterusnya&nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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

@include('js.rt-sm21.j-permohonan-ikes-ppn')
