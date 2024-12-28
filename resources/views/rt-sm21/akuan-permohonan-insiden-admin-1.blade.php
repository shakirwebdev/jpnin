@extends('layout.master')
@section('title', 'Memperakukan Permohonan Pelaporan Kes')


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
                                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked disabled>
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="custom-switch-description">Kejadian Kes Dalam KRT</span>
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Negeri: </label>
                                                    <select class="select2 custom-select" id="" name="" disabled>
                                                        <option value="">Perlis</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Daerah: </label>
                                                    <select class="select2 custom-select" id="" name="" disabled>
                                                        <option value="">Perlis</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Nama KRT: </label>
                                                    <select class="select2 custom-select" id="" name="" disabled>
                                                        <option value="">KRT Taman Peladang Jaya</option>
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
                                                    <input type="text" class="form-control" name="" placeholder="Nama Pemohon" value="Mohamad Shauki Bin Sahardi" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Kad Pengenalan: </label>
                                                    <input type="text" class="form-control" name="" placeholder="No Kad Pengenalan" value="930508-09-5161" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Alamat: </label>
                                                    <textarea class="form-control" id="" name="" rows="4" disabled="">
No, 10 Lorong 5,
Taman Peladang Jaya,
02000 Kuala Perlis, Perlis
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT STATUS MEMPERAKUI</b></h6>
                                                <br><br>
                                                <div class="form-group">
                                                    <label class="form-label">Status: <span class="text-red">*</span></label>
                                                    <select class="form-control" disabled>
                                                        <option>-- Sila Pilih --</option>
                                                        <option>Memperakui</option>
                                                        <option>Perlu Dikemaskini</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Penerangan: <span class="text-red">*</span></label>
                                                    <textarea class="form-control" rows="4" disabled></textarea>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group pull-right">
                                                        <button type="submit" class="btn btn-secondary" disabled>Hantar Status Akui&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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
                                                            <select class="select2 custom-select" id="" name="" disabled>
                                                                <option value="">Perlis</option>
                                                                <option value="">-- Sila Pilih --</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Bandar: </label>
                                                            <select class="select2 custom-select" id="" name="" disabled>
                                                                <option value="">Kuala Perlis</option>
                                                                <option value="">-- Sila Pilih --</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Parlimen: </label>
                                                            <select class="select2 custom-select" id="" name="" disabled>
                                                                <option value="">Kangar</option>
                                                                <option value="">-- Sila Pilih --</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Dun: </label>
                                                            <select class="select2 custom-select" id="" name="" disabled>
                                                                <option value="">Kuala Perlis</option>
                                                                <option value="">-- Sila Pilih --</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">PBT: </label>
                                                            <select class="select2 custom-select" id="" name="" disabled>
                                                                <option value="">Majlis Pembadaran Kangar</option>
                                                                <option value="">-- Sila Pilih --</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Balai Polis Berdekatan: </label>
                                                            <input type="text" class="form-control" name="" placeholder="Balai Polis Berdekatan" value="Balai Polis Kuala Perlis" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Tarikh Berlaku: </b>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                                <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="" id="" placeholder="Tarikh Berlaku" data-date-format="dd/mm/yyyy" value="1/1/2021" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Daerah: </label>
                                                            <select class="select2 custom-select" id="" name="" disabled>
                                                                <option value="">Perlis</option>
                                                                <option value="">-- Sila Pilih --</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Lokasi: </label>
                                                            <textarea class="form-control" id="" name="" rows="5" placeholder="Lokasi" disabled>Taman Peladang Jaya Kuala Perlis
                                                            </textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Poskod: </label>
                                                            <input type="text" class="form-control" name="" placeholder="Poskod" value="02000" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Latitud: </label>
                                                            <input type="text" class="form-control" name="" placeholder="Latitud" value="6.401191" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Longitud: </label>
                                                            <input type="text" class="form-control" name="" placeholder="Longitud" value="100.153185" disabled>
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
                                                            <label class="form-label">Bidang: </label>
                                                            <select class="select2 custom-select" id="" name="" disabled>
                                                                <option value="">Kerajaan</option>
                                                                <option value="">-- Sila Pilih --</option>
                                                                <option value="">Politik</option>
                                                                <option value="">Ekonomi</option>
                                                                <option value="">Keselamatan</option>
                                                                <option value="">Alam Sekitar</option>
                                                                <option value="">Sosial</option>
                                                                <option value="">Agama</option>
                                                                <option value="">Pendidikan</option>
                                                                <option value="">Kerajaan</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Kategori Kes: </label>
                                                            <select class="select2 custom-select" id="" name="" disabled>
                                                                <option value="">Rusuhan</option>
                                                                <option value="">-- Sila Pilih --</option>
                                                                <option value="">Keganasan</option>
                                                                <option value="">Rusuhan</option>
                                                                <option value="">Demonstrasi (Perhimpunan & Berarah -> 500)</option>
                                                                <option value="">Protes</option>
                                                                <option value="">Pergaduhan</option>
                                                                <option value="">Serangan</option>
                                                                <option value="">Isu</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Kluster: </label>
                                                            <select class="select2 custom-select" id="" name="" disabled>
                                                                <option value="">-- Sila Pilih --</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Peringkat Kes: </label>
                                                            <select class="select2 custom-select" id="" name="" disabled>
                                                                <option value="">Tempatan</option>
                                                                <option value="">-- Sila Pilih --</option>
                                                                <option value="">Nasional</option>
                                                                <option value="">Tempatan</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Sub-Kategori Kes: </label>
                                                            <select class="select2 custom-select" id="" name="" disabled>
                                                                <option value="">Protes</option>
                                                                <option value="">-- Sila Pilih --</option>
                                                                <option value="">Protes (Perhimpunan Statik/ Berarak ≤100)</option>
                                                                <option value="">Protes (Perhimpunan Statik/Berarak 101-500)</option>
                                                                <option value="">Protes</option>
                                                                <option value="">Demonstrasi (Perhimpunan & Berarak - >500)</option>
                                                                <option value="">Protes (Memorandum/ Tandatangan)</option>
                                                                <option value="">Protes (Lain-Lain)</option>
                                                                <option value="">Protes (Media Sosial)</option>
                                                                <option value="">Cat</option>
                                                                <option value="">Senjata</option>
                                                                <option value="">Tanpa Senjata</option>
                                                                <option value="">Harta Benda</option>
                                                                <option value="">Molotov</option>
                                                                <option value="">Asid</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Sub-kluster: </label>
                                                            <select class="select2 custom-select" id="" name="" disabled>
                                                                <option value="">-- Sila Pilih --</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Keterangan Kes: <span class="text-red">*</span></label>
                                                            <textarea class="form-control" name="pia_keterangan_kes" id="pia_keterangan_kes" >Test</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Tindakan: <span class="text-red">*</span></label>
                                                            <textarea class="form-control" name="pia_tindakan_kes" id="pia_tindakan_kes" >Test</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div
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

@include('js.rt-sm21.j-akuan-permohonan-insiden-admin-1')
