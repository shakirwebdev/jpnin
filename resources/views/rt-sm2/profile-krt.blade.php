@extends('layout.master')
@section('title', 'Kemaskini Profil Kawasan Rukun Tetangga')


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
                        <small>Isi maklumat pada borang yang disediakan dibawah, dan tekan butang Seterusnya. 
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
                                                <h6><b>MAKLUMAT AM KRT</b></h6>
                                                <br>
                                                <p><span style="font-size:12px">Nama KRT</span><br><b><span name="pk_krt_nama" id="pk_krt_nama"></span></b></p>
                                                <br>
                                                <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span name="pk_krt_alamat" id="pk_krt_alamat"></span></b></p>
                                                <br>
                                                <p><span style="font-size:12px">Tarikh Permohonan</span><br><b><span name="pk_tarikh_memohon" id="pk_tarikh_memohon"></span></b></p>
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
                                            <br/>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <form method="POST" id="form_pk">
                                            @csrf
                                                <p>1. Latar Belakang Kawasan</p>
                                                <hr class="mt-1">
                                                <div class="row clearfix">
                                                    <br><br>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Negeri:</label>
                                                            <select class="form-control" name="pk_negeri_id" id="pk_negeri_id" disabled>
                                                                @foreach($negeri as $item)                                    
                                                                    <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Parlimen: <span class="text-red">*</span></label>
                                                            <select class="form-control" name="pk_parlimen_id" id="pk_parlimen_id">
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($parlimen as $item)                                    
                                                                    <option value="{{ $item->parlimen_id }}">{{ $item->parlimen_description }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="error_pk_parlimen_id invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Pihak Berkuasa Tempatan (PBT): <span class="text-red">*</span></label>
                                                            <select class="form-control" name="pk_pbt_id" id="pk_pbt_id">
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($pbt as $item)                                    
                                                                    <option value="{{ $item->pbt_id }}">{{ $item->pbt_description }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="error_pk_pbt_id invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Daerah: </label>
                                                            <select class="form-control" name="pk_daerah_id" id="pk_daerah_id" disabled>
                                                                @foreach($daerah as $item)                                    
                                                                    <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Dun: </label>
                                                            <select class="form-control" name="pk_dun_id" id="pk_dun_id">
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($dun as $item)                                    
                                                                    <option value="{{ $item->dun_id }}">{{ $item->dun_description }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="error_pk_dun_id invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Nama Kawasan / Tempat: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="pk_krt_kawasan" id="pk_krt_kawasan" placeholder="Nama Kawasan / Tempat">
                                                        </div>
                                                        <div class="error_pk_krt_kawasan invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Saiz Keluasan: <span class="text-red">*</span> <font size="1">(dalam Hektar)</font></label>
                                                            <input type="text" class="form-control" name="pk_krt_keluasan" id="pk_krt_keluasan" placeholder="Saiz Keluasan">
                                                            <div class="error_pk_krt_keluasan invalid-feedback text-right"></div>
                                                            <font size="2px">(1 Hektar = 2.47 Ekar)</font>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Ibu Pejabat Polis (IPD): <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="pk_krt_ipd" id="pk_krt_ipd" placeholder="Ibu Pejabat Polis (IPD)">
                                                            <div class="error_pk_krt_ipd invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Nama SRS: <span class="text-red">(sekiranya ada)</span></label>
                                                            <input type="text" class="form-control" name="pk_srs_nama" id="pk_srs_nama" placeholder="Nama SRS">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Balai Polis: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="pk_krt_balai" id="pk_krt_balai" placeholder="Balai Polis">
                                                            <div class="errorpk_krt_balai invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Nama Tabika Perpaduan dalam KRT: <span class="text-red">(sekiranya ada)</span></label>
                                                            <input type="text" class="form-control" name="pk_krt_tabika" id="pk_krt_tabika" placeholder="Nama Tabika Perpaduan dalam KRT">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Nama Taska Perpaduan dalam KRT: <span class="text-red">(sekiranya ada)</span></label>
                                                            <input type="text" class="form-control" name="pk_krt_taska" id="pk_krt_taska" placeholder="Nama Taska Perpaduan dalam KRT">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <form action="#" id="form_pk2">
                                                {{ csrf_field() }}
                                                <div class="form-group">
                                                    <label class="form-label">Anggaran Bilangan / Isi Rumah dan Pecahan Komposisi Penduduk : </label>
                                                </div>
                                                <div class="col-md-12 alert alert-danger error_form_pk2" role="alert" style="display: none; padding-bottom: 0px;">
                                                    <ul></ul>
                                                </div>
                                                <div class="series-frame">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Kaum: <span class="text-red">*</span></label>
                                                            <select class="form-control" name="pk2_komposisi_kaum" id="pk2_komposisi_kaum">
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($ref_kaum as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->kaum_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Jumlah (Bil. Orang): <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="pk2_komposisi_jumlah" id="pk2_komposisi_jumlah" placeholder="Jumlah (Bil. Orang)">
                                                        </div>
                                                        <input type="hidden" name="pk2_krt_profileID" id="pk2_krt_profileID">
                                                        <input type="hidden" name="add_profile_krt_komposisi" value="add">
                                                        <button type="submit" class="btn btn-primary pull-right" id="btn_save_komposisi"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                    </div>
                                                </div>
                                                <br/><br/>
                                                <div class="table-responsive">
                                                    <table class="table thead-dark table-bordered table-striped" id="komposisi_penduduk_table" style="width: 100%" border="1">
                                                        <thead>
                                                            <tr>
                                                                <th style="background-color: #113f50" ><font color="white">Bil</font></th>
                                                                <th style="background-color: #113f50" ><font color="white">Kaum</font></th>
                                                                <th style="background-color: #113f50" ><font color="white">Jumlah</font></th>
                                                                <th style="background-color: #113f50" ><font color="white">Tindakan</font></th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <form method="POST" id="form_pk3">
                                            @csrf
                                                <input type="hidden" name="pk3_krt_profile_id" id="pk3_krt_profile_id">
                                                <input type="hidden" name="action" id="update_profile_krt" value="edit">
                                                <input type="hidden" name="update_profile_krt" value="edit">
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
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.css') }}">

@stop

@include('js.rt-sm2.j-profile-krt')
