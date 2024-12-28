@extends('layout.master')
@section('title', 'Semakan Permohonan Pelaporan i-Ramal')


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
                                                <h6><b>MAKLUMAT KES DALAM KRT</b></h6>
                                                <br>
                                                <div class="form-group">
                                                    <label class="custom-switch">
                                                        <input type="checkbox" name="spmpp_hasRT" id="spmpp_hasRT" class="custom-switch-input" disabled>
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="custom-switch-description">Kejadian Kes Dalam KRT</span>
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Negeri: </label>
                                                    <select class="form-control" name="spmpp_state_id" id="spmpp_state_id" disabled>
                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                        @foreach($negeri as $item)                                    
                                                            <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Daerah: </label>
                                                    <select class="form-control" name="spmpp_daerah_id" id="spmpp_daerah_id" disabled>
                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                        @foreach($daerah as $item)                                    
                                                            <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Nama KRT: </label>
                                                    <select class="form-control" name="spmpp_krt_profile_id" id="spmpp_krt_profile_id" disabled>
                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                        @foreach($krt as $item)                                    
                                                            <option value="{{ $item->id }}">{{ $item->krt_nama }}</option>
                                                        @endforeach
                                                    </select>
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
                                                <br><br>
                                                <div class="form-group">
                                                    <label class="form-label">Nama Pemohon: </label>
                                                    <input type="text" class="form-control" name="spmpp_nama_permohon" id="spmpp_nama_permohon" placeholder="Nama Pemohon" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Kad Pengenalan: </label>
                                                    <input type="text" class="form-control" name="spmpp_ic_pemohon" id="spmpp_ic_pemohon" placeholder="No Kad Pengenalan" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Telefon: </label>
                                                    <input type="text" class="form-control" name="spmpp_phone_pemohon" id="spmpp_phone_pemohon" placeholder="No Telefonn" disabled="">
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
                                                <form action="#" id="form_spmpp" >
                                                @csrf
                                                    <div class="form-group">
                                                        <label class="form-label">Status: </label>
                                                        <select class="form-control semak_status_ppd" name="spmpp_imuhibbah_status" id="spmpp_imuhibbah_status">
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            <option value="6">Disemak</option>
                                                            <option value="7">Perlu Dikemaskini</option>
                                                        </select>
                                                        <select class="form-control semak_status_ppn" name="spmpp_imuhibbah_status" id="spmpp_imuhibbah_status">
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            <option value="10">Disemak</option>
                                                            <option value="11">Perlu Dikemaskini</option>
                                                        </select>
                                                        <div class="error_spmpp_imuhibbah_status invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Penerangan: </label>
                                                        <textarea class="form-control" rows="4" name="spmpp_disemak_note" id="spmpp_disemak_note" placeholder="Penerangan"></textarea>
                                                        <div class="error_spmpp_disemak_note invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group pull-right">
                                                            <input type="hidden" name="spmpp_spk_imuhibbah_id" id="spmpp_spk_imuhibbah_id">
                                                            <input type="hidden" name="post_semakan_permohonan_imuhibbah" value="edit">
                                                            <input type="hidden" name="action" id="post_semakan_permohonan_imuhibbah" value="edit">
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
                                            <h6><b>MAKLUMAT DARI SUMBER YANG MUNGKIN BERLAKU</b></h6>
                                            <br>
                                            <p>1. Maklumat Kes : </p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Tajuk: </label>
                                                            <input type="text" class="form-control" name="spmpp_imuhibbah_tajuk" id="spmpp_imuhibbah_tajuk" placeholder="Tajuk" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Negeri: </label>
                                                            <select class="form-control" name="spmpp1_state_id" id="spmpp1_state_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($negeri as $item)                                    
                                                                    <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Bandar: </label>
                                                            <select class="form-control" name="spmpp_bandar_id" id="spmpp_bandar_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($bandar as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->bandar_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Lokasi / Nama Jalan: </label>
                                                            <input type="text" class="form-control" name="spmpp_imuhibbah_lokasi" id="spmpp_imuhibbah_lokasi" placeholder="Lokasi / Nama Jalan" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Parlimen: </label>
                                                            <select class="form-control" name="spmpp_parlimen_id" id="spmpp_parlimen_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($parlimen as $item)                                    
                                                                    <option value="{{ $item->parlimen_id }}">{{ $item->parlimen_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">PBT: </label>
                                                            <select class="form-control" name="spmpp_pbt_id" id="spmpp_pbt_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($pbt as $item)                                    
                                                                    <option value="{{ $item->pbt_id }}">{{ $item->pbt_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Daerah: </label>
                                                            <select class="form-control" name="spmpp1_daerah_id" id="spmpp1_daerah_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($daerah as $item)                                    
                                                                    <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Taman / Kampung: </label>
                                                            <input type="text" class="form-control" name="spmpp_imuhibbah_kawasan" id="spmpp_imuhibbah_kawasan" placeholder="Taman / Kampung" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Poskod: </label>
                                                            <input type="text" class="form-control" name="spmpp_imuhibbah_poskod" id="spmpp_imuhibbah_poskod" placeholder="Poskod" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Dun: </label>
                                                            <select class="form-control" name="spmpp_dun_id" id="spmpp_dun_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($dun as $item)                                    
                                                                    <option value="{{ $item->dun_id }}">{{ $item->dun_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <b>Tarikh Laporan: </b>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                                <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="spmpp_imuhibbah_tarikh_laporan" id="spmpp_imuhibbah_tarikh_laporan" placeholder="Tarikh Laporan" data-date-format="dd/mm/yyyy" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <b>Tarikh Jangkaan Berlaku: </b>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                                <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="spmpp_imuhibbah_tarikh_j_berlaku" id="spmpp_imuhibbah_tarikh_j_berlaku" placeholder="Tarikh Berlaku" data-date-format="dd/mm/yyyy" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Laporan: </label>
                                                            <textarea class="form-control" name="spmpp_imuhibbah_laporan" id="spmpp_imuhibbah_laporan" ></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Sumber Maklumat: </label>
                                                            <textarea class="form-control" name="spmpp_imuhibbah_sumber_maklumat" id="spmpp_imuhibbah_sumber_maklumat" ></textarea>
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
                                                            <label class="form-label">Nama: </label>
                                                            <input type="text" class="form-control" name="spmpp_imuhibbah_pelapor_nama" id="spmpp_imuhibbah_pelapor_nama" placeholder="Nama" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">No Telefon: </label>
                                                            <input type="text" class="form-control" name="spmpp_imuhibbah_pelapor_no" id="spmpp_imuhibbah_pelapor_no" placeholder="No Telefon" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Jawatan: </label>
                                                            <input type="text" class="form-control" name="spmpp_imuhibbah_pelapor_jawatan" id="spmpp_imuhibbah_pelapor_jawatan" placeholder="Jawatan" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Alamat: </label>
                                                            <textarea class="form-control" id="spmpp_imuhibbah_pelapor_alamat" name="spmpp_imuhibbah_pelapor_alamat" rows="5" placeholder="Alamat" disabled></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
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
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@stop

@include('js.rt-sm22.j-semakan-permohonan-muhibbah-bpp')
