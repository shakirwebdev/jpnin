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
                                            <div class="row clearfix">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <h6><b>MAKLUMAT ASAS KAWASAN</b></h6>
                                                </div>
                                                <br><br>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <form action="#" id="form_pk4">
                                                    {{ csrf_field() }}
                                                        <div class="form-group">
                                                            <label class="form-label">Sosio-Ekonomi Penduduk / Pekerjaan [Peratus {%}] : </label>
                                                        </div>
                                                        <div class="col-md-12 alert alert-danger error_form_pk4" role="alert" style="display: none; padding-bottom: 0px;">
                                                            <ul></ul>
                                                        </div>
                                                        <div class="series-frame">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Pekerjaan: <span class="text-red">*</span></label>
                                                                    <select class="form-control" name="pk4_profession_id" id="pk4_profession_id">
                                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                        @foreach($profession as $item)                                    
                                                                            <option value="{{ $item->id }}">{{ $item->profession_description }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Peratus (%): <span class="text-red">*</span></label>
                                                                    <input type="text" class="form-control" name="pk4_pekerjaan_peratus" id="pk4_pekerjaan_peratus" placeholder="Peratus (%)">
                                                                </div>
                                                                <input type="hidden" name="pk4_krt_profileID" id="pk4_krt_profileID">
                                                                <input type="hidden" name="add_profile_krt_pekerjaan" value="add">
                                                                <button type="submit" class="btn btn-primary pull-right" id="btn_save_pekerjaan"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                            </div>
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_pekerjaan_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="background-color: #113f50" ><font color="white">Bil</font></th>
                                                                        <th style="background-color: #113f50" ><font color="white">Pekerjaan</font></th>
                                                                        <th style="background-color: #113f50" ><font color="white">Peratus</font></th>
                                                                        <th style="background-color: #113f50" ><font color="white">Tindakan</font></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </form>
                                                    <br>
                                                    <form action="#" id="form_pk5">
                                                    {{ csrf_field() }}
                                                        <div class="form-group">
                                                            <label class="form-label">Jenis/Kategori Rumah : Nyatakan bil. (pintu/unit) mengikut kategori rumah</label>
                                                        </div>
                                                        <div class="col-md-12 alert alert-danger error_form_pk5" role="alert" style="display: none; padding-bottom: 0px;">
                                                            <ul></ul>
                                                        </div>
                                                        <div class="series-frame">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Jenis Rumah: <span class="text-red">*</span></label>
                                                                    <select class="form-control" name="pk5_jenis_rumah_id" id="pk5_jenis_rumah_id">
                                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                        @foreach($jenis_rumah as $item)                                    
                                                                            <option value="{{ $item->id }}">{{ $item->jenis_rumah_description }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Bilangan Pintu/Unit : <span class="text-red">*</span></label>
                                                                    <input type="text" class="form-control" name="pk5_jumlah_pintu" id="pk5_jumlah_pintu" placeholder="Bilangan Pintu/Unit">
                                                                </div>
                                                                <input type="hidden" name="pk5_krt_profileID" id="pk5_krt_profileID">
                                                                <input type="hidden" name="add_profile_krt_jenis_rumah" value="add">
                                                                <button type="submit" class="btn btn-primary pull-right" id="btn_save_jenis_rumah"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                            </div>
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_jenis_rumah_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="background-color: #113f50" ><font color="white">Bil</font></th>
                                                                        <th style="background-color: #113f50" ><font color="white">Jenis Rumah</font></th>
                                                                        <th style="background-color: #113f50" ><font color="white">Bilangan Pintu/Unit</font></th>
                                                                        <th style="background-color: #113f50" ><font color="white">Tindakan</font></th>
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

@include('js.rt-sm2.j-profile-krt-1')
