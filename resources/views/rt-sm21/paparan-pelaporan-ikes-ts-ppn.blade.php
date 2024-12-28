@extends('layout.master')
@section('title', 'Paparan Pelaporan i-Kes')


@section('content')
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
                                                        <input type="checkbox" name="ppip_hasRT" id="ppip_hasRT" class="custom-switch-input" disabled>
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="custom-switch-description">Kejadian Kes Dalam KRT</span>
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Negeri: </label>
                                                    <select class="form-control" name="ppip_negeri_id" id="ppip_negeri_id" disabled>
                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                        @foreach($negeri as $item)                                    
                                                            <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Daerah: </label>
                                                    <select class="form-control" name="ppip_daerah_id" id="ppip_daerah_id" disabled>
                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                        @foreach($daerah as $item)                                    
                                                            <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Nama KRT: </label>
                                                    <select class="form-control" name="ppip_krt_profile_id" id="ppip_krt_profile_id" disabled>
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
                                                    <input type="text" class="form-control" name="ppip_user_fullname" id="ppip_user_fullname" placeholder="Nama Pemohon" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Kad Pengenalan: </label>
                                                    <input type="text" class="form-control" name="ppip_user_no_ic" id="ppip_user_no_ic" placeholder="No Kad Pengenalan" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Telefon: </label>
                                                    <input type="text" class="form-control" name="ppip_user_no_phone" id="ppip_user_no_phone" placeholder="No Telefon" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Alamat: </label>
                                                    <textarea class="form-control" id="ppip_dihantar_alamat" name="ppip_dihantar_alamat" rows="4" disabled="" placeholder="Alamat"></textarea>
                                                </div>
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
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Negeri: </label>
                                                            <select class="form-control" name="ppip1_negeri_id" id="ppip1_negeri_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($negeri as $item)                                    
                                                                    <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Bandar: </label>
                                                            <select class="form-control" name="ppip_bandar_id" id="ppip_bandar_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($bandar as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->bandar_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Lokasi / Nama Jalan: </label>
                                                            <input type="text" class="form-control" name="ppip_ikes_lokasi" id="ppip_ikes_lokasi" placeholder="Lokasi / Nama Jalan" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Parlimen: </label>
                                                            <select class="form-control" name="ppip_parlimen_id" id="ppip_parlimen_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($parlimen as $item)                                    
                                                                    <option value="{{ $item->parlimen_id }}">{{ $item->parlimen_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">PBT: </label>
                                                            <select class="form-control" name="ppip_pbt_id" id="ppip_pbt_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($pbt as $item)                                    
                                                                    <option value="{{ $item->pbt_id }}">{{ $item->pbt_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Tarikh Berlaku: </b>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                                <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="ppip_ikes_tarikh_berlaku" id="ppip_ikes_tarikh_berlaku" placeholder="Tarikh Berlaku" data-date-format="dd/mm/yyyy" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Daerah: </label>
                                                            <select class="form-control" name="ppip1_daerah_id" id="ppip1_daerah_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($daerah as $item)                                    
                                                                    <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Taman / Kampung: </label>
                                                            <input type="text" class="form-control" name="ppip_ikes_kawasan" id="ppip_ikes_kawasan" placeholder="Taman / Kampung" disabled>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="form-label">Poskod: </label>
                                                            <input type="text" class="form-control" name="ppip_ikes_poskod" id="ppip_ikes_poskod" placeholder="Poskod" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Dun: </label>
                                                            <select class="form-control" name="ppip_dun_id" id="ppip_dun_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($dun as $item)                                    
                                                                    <option value="{{ $item->dun_id }}">{{ $item->dun_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Balai Polis Berdekatan: </label>
                                                            <input type="text" class="form-control" name="ppip_ikes_bpolis" id="ppip_ikes_bpolis" placeholder="Balai Polis Berdekatan" disabled>
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
                                                            <label class="form-label">Peringkat Kes: </label>
                                                            <select class="form-control" name="ppip_peringkat_kes_id" id="ppip_peringkat_kes_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($peringkat_kes as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->peringkat_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Kluster: </label>
                                                            <select class="form-control" id="ppip_kluster_id" name="ppip_kluster_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($kluster as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->kluster_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Kategori Kes: </label>
                                                            <select class="form-control" name="ppip_kategori_kes_id" id="ppip_kategori_kes_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($kategori_kes as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->kategori_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Sub-kluster: </label>
                                                            <select class="form-control" id="ppip_sub_kluster_id" name="ppip_sub_kluster_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($sub_kluster as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->subkluster_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <?php 
                                                            $text1 = $ikes->ikes_keterangan_kes;
                                                        ?>
                                                        <div class="form-group">
                                                            <label class="form-label">Keterangan Kes: </label>
                                                            <textarea class="form-control" name="ppip_ikes_keterangan_kes" id="ppip_ikes_keterangan_kes" disabled>{{$text1}}</textarea>
                                                        </div>
                                                        <?php 
                                                            $text2 = $ikes->ikes_tindakan_awal;
                                                        ?>
                                                        <div class="form-group">
                                                            <label class="form-label">Tindakan/Maklumbalas Awal JPNIN: </label>
                                                            <textarea class="form-control" name="ppip_ikes_tindakan_awal" id="ppip_ikes_tindakan_awal" disabled>{{$text2}}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Sumber: </label>
                                                            <input type="text" class="form-control" name="ppip_ikes_sumber" id="ppip_ikes_sumber" placeholder="Sumber" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                            <button type="submit" class="btn btn-primary" id="btn_next">Seterusnya&nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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
@stop

@include('js.rt-sm21.j-paparan-pelaporan-ikes-ts-ppn')
