@extends('layout.master')
@section('title', 'Kemaskini Permohonan Profail Penubuhan KRT')


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
    <div class="section-body mt-3" style="display:none;" id="kpk_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert">
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> <span class="text-red blink" id="kpk_status_description" name="kpk_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> 
                                <span id="kpk_disemak_note" name="kpk_disemak_note"></span>
                                <span id="kpk_disahkan_note" name="kpk_disahkan_note"></span>
                                <span id="kpk_diluluskan_note" name="kpk_diluluskan_note"></span>.
                                <br>
                                <input type="hidden" name="kpk_status" id="kpk_status">
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
                                                <h6><b>MAKLUMAT PERMOHONAN KRT</b></h6>
                                                <br>
                                                <p><span style="font-size:12px">Cadangan Nama KRT</span><br><b><span name="kpk_krt_nama" id="kpk_krt_nama"></span></b></p>
                                                <br>
                                                <p><span style="font-size:12px">Cadangan Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span name="kpk_krt_alamat" id="kpk_krt_alamat"></span></b></p>
                                                <br>
                                                <p><span style="font-size:12px">Tarikh Permohonan</span><br><b><span name="kpk_tarikh_memohon" id="kpk_tarikh_memohon"></span></b></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT PEMOHON</b></h6>
                                                <br>
                                                <div class="form-group">
                                                    <label class="form-label">Nama Pemohon: </label>
                                                    <input type="text" class="form-control" name="kpk_pemohon_name" id="kpk_pemohon_name" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Kad Pengenalan: </label>
                                                    <input type="text" class="form-control" name="kpk_pemohon_ic" id="kpk_pemohon_ic" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Alamat: </label>
                                                    <textarea class="form-control" name="kpk_pemohon_alamat" id="kpk_pemohon_alamat" rows="4" disabled=""></textarea>
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
                                            <div class="row clearfix">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <h6><b>MAKLUMAT ASAS KAWASAN</b></h6>
                                                </div>
                                                <br><br>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <form action="#" id="pekerjaan_form">
                                                    {{ csrf_field() }}
                                                        <div class="form-group">
                                                            <label class="form-label">Sosio-Ekonomi Penduduk / Pekerjaan [Peratus {%}] : </label>
                                                            <!-- <p class="form-label" style="font-size:12px"><font style="color: #ff7f81">Sila masukan nilai <b>0</b> sekiranya KAUM tersebut tiada</font></p> -->
                                                        </div>
                                                        <div class="col-md-12 alert alert-danger error_alert_1" role="alert" style="display: none; padding-bottom: 0px;">
                                                            <ul></ul>
                                                        </div>
                                                        <div class="series-frame">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="kpk1_profession_id">Pekerjaan: <span class="text-red">*</span></label>
                                                                    <select class="form-control" name="kpk1_profession_id" id="kpk1_profession_id">
                                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                        @foreach($profession as $item)                                    
                                                                            <option value="{{ $item->id }}">{{ $item->profession_description }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Peratus (%): <span class="text-red">*</span></label>
                                                                    <input type="text" class="form-control" name="kpk1_pekerjaan_peratus" id="kpk1_pekerjaan_peratus" placeholder="Peratus (%)">
                                                                </div>
                                                                <input type="hidden" name="kpk1_krt_profileID" id="kpk1_krt_profileID">
                                                                <input type="hidden" name="add_pekerjaan" value="add">
                                                                <button type="submit" class="btn btn-primary pull-right" id="btn-save-pekerjaan"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                            </div>
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="pekerjaan_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Pekerjaan</font></label></th>
                                                                        <!-- <th width="25%"><label class="form-label"><font color="#113f50">Sub Pekerjaan</font></label></th> -->
                                                                        <th width="25%"><label class="form-label"><font color="#113f50">Peratus (%)</font></label></th>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </form>
                                                    <form action="#" id="jenis_rumah_form">
                                                    {{ csrf_field() }}
                                                        <div class="form-group">
                                                            <label class="form-label">Jenis/Kategori Rumah : Nyatakan bil. (pintu/unit) mengikut kategori rumah</label>
                                                        </div>
                                                        <div class="col-md-12 alert alert-danger error_alert_2" role="alert" style="display: none; padding-bottom: 0px;">
                                                            <ul></ul>
                                                        </div>
                                                        <div class="series-frame">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="jrf_jenis_rumah_id">Jenis Rumah: <span class="text-red">*</span></label>
                                                                    <select class="form-control" name="jrf_jenis_rumah_id" id="jrf_jenis_rumah_id">
                                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                        @foreach($jenis_rumah as $item)                                    
                                                                            <option value="{{ $item->id }}">{{ $item->jenis_rumah_description }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Bilangan Pintu/Unit : <span class="text-red">*</span></label>
                                                                    <input type="text" class="form-control" name="jrf_jumlah_pintu" id="jrf_jumlah_pintu" placeholder="Bilangan Pintu/Unit">
                                                                </div>
                                                                <input type="hidden" name="jrf_krt_profileID" id="jrf_krt_profileID">
                                                                <input type="hidden" name="add_jenis_rumah" value="add">
                                                                <button type="submit" class="btn btn-primary pull-right" id="btn-save-jenis-rumah"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                            </div>
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="jenis_rumah_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Jenis Rumah</font></label></th>
                                                                        <th width="25%"><label class="form-label"><font color="#113f50">Bilangan Pintu/Unit</font></label></th>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <br>
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
@stop

@include('js.rt-sm1.j-kemaskini-profil-krt-1')
