@extends('layout.master')
@section('parentPageTitle', 'HRMS')
@section('title', 'Paparan Profil KRT')


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
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="user-list" role="tabpanel">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT PERMOHONAN KRT</b></h6>
                                                <br>
												<input type="hidden" id="act_id" name="act_id" value="{{ $profile_krt->id }}">
                                                <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><input class="form-control" type="text" id="kpk_krt_nama" name="kpk_krt_nama"><div class="error_kpk_krt_nama invalid-feedback text-right"></div><!--span name="kpk_krt_nama" id="kpk_krt_nama"></span--></b></p>
                                                <br>
                                                <p><span style="font-size:12px">Cadangan Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><textarea class="form-control" name="kpk_krt_alamat" id="kpk_krt_alamat"></textarea><div class="error_kpk_krt_alamat invalid-feedback d-block text-right"></div><!--span name="kpk_krt_alamat" id="kpk_krt_alamat"></span--></b></p>
                                                <br>
                                                <p><span style="font-size:12px">Tarikh Permohonan</span><br><b><span name="kpk_tarikh_memohon" id="kpk_tarikh_memohon"></span></b></p>
												<br>
												<p><button class="btn btn-secondary" id="btn_kemaskini" name="btn_kemaskini">Kemaskini</button></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <h6><b>MAKLUMAT ASAS KAWASAN</b></h6>
                                            <br>
                                            <p>1. Latar Belakang Kawasan</p>
                                            <hr class="mt-1">
                                            <div class="row clearfix">
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="krt_negeri_id" class="form-label">Negeri : </label>
                                                        <select class="form-control" id="krt_negeri_id" name="krt_negeri_id" disabled="">
                                                            @foreach($negeri as $item)                                    
                                                                <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="krt_parlimen_id" class="form-label">Parlimen : </label>
                                                        <select class="form-control" id="krt_parlimen_id" name="krt_parlimen_id" disabled="">
                                                            <@foreach($parlimen as $item)                                    
                                                                <option value="{{ $item->parlimen_id }}">{{ $item->parlimen_description }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="krt_pbt_id" class="form-label">Pihak Berkuasa Tempatan (PBT) : </label>
                                                        <select class="form-control" id="krt_pbt_id" name="krt_pbt_id" disabled="">
                                                            @foreach($pbt as $item)                                    
                                                                <option value="{{ $item->pbt_id }}">{{ $item->pbt_description }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="krt_daerah_id" class="form-label">Daerah : </label>
                                                        <select class="form-control" id="krt_daerah_id" name="krt_daerah_id" disabled="">
                                                            @foreach($daerah as $item)                                    
                                                                <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="krt_dun_id" class="form-label">Dun : </label>
                                                        <select class="form-control" id="krt_dun_id" name="krt_dun_id" disabled="">
                                                            @foreach($dun as $item)                                    
                                                                <option value="{{ $item->dun_id }}">{{ $item->dun_description }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Balai Polis : </label>
                                                        <input type="text" class="form-control" name="krt_balai" id="krt_balai" disabled="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Nama SRS : </label>
                                                        <input type="text" class="form-control" name="srs_nama" id="srs_nama" disabled="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Ibu Pejabat Polis Daerah (IPD) : </label>
                                                        <input type="text" class="form-control" name="krt_ipd" id="krt_ipd" disabled="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Tabika Perpaduan dalam KRT : </label>
                                                        <input type="text" class="form-control" name="krt_tabika" id="krt_tabika" disabled="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Taska Perpaduan dalam KRT : </label>
                                                        <input type="text" class="form-control" name="krt_taska" id="krt_taska" disabled="krt_taska">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Kawasan / Tempat : </label>
                                                        <input type="text" class="form-control" name="krt_kawasan" id="krt_kawasan" disabled="" >
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Saiz Keluasan <span class="text-red" style="font-size:12px">*dalam hektar</span> : </label>
                                                        <input type="text" class="form-control" name="krt_keluasan" id="krt_keluasan" disabled="">
                                                       <span class="text" style="font-size:12px">1 Hektar - 2.47 Ekar</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Angaran Bilangan / Isi Rumah dan Pecahan Komposisi Penduduk : </label>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="komposisi_penduduk_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Kaum</font></label></th>
                                                                        <th width="25%"><label class="form-label"><font color="#113f50">Jumlah (Bil. Orang)</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Sosio-Ekonomi Penduduk / Pekerjaan (Peratus {%}) : </label>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="pekerjaan_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Pekerjaan</font></label></th>
                                                                        <th width="25%"><label class="form-label"><font color="#113f50">Peratus (%)</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Jenis/Kategori Rumah : </label>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="jenis_rumah_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Jenis Rumah</font></label></th>
                                                                        <th width="25%"><label class="form-label"><font color="#113f50">Bilangan Pintu/Unit</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>&nbsp;
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
    </div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
@stop

@include('js.rt-sm2.j-profile-krt-ppn-2')