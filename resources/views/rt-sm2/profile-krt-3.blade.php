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
                                            <br>
                                            <p>3. Kemudahan Awam Yang Terdapat Di Kawasan Ini</p>
                                            <hr class="mt-1">
                                            <div class="row clearfix">
                                                <br><br>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <form action="#" id="form_pk7">
                                                    {{ csrf_field() }}
                                                        <div class="form-group">
                                                            <label class="form-label">Kemudahan Awam: </label>
                                                        </div>
                                                        <div class="col-md-12 alert alert-danger error_form_pk7" role="alert" style="display: none; padding-bottom: 0px;">
                                                            <ul></ul>
                                                        </div>
                                                        <div class="series-frame">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Perkara: <span class="text-red">*</span></label>
                                                                    <select class="form-control" name="pk7_ref_kemudahan_awamID" id="pk7_ref_kemudahan_awamID">
                                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                        @foreach($kemudahan_awam as $item)                                    
                                                                            <option value="{{ $item->id }}">{{ $item->kemudahan_awam_description }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Jumlah: <span class="text-red">*</span></label>
                                                                    <input type="text" class="form-control" name="pk7_kemudahan_awam_jumlah" id="pk7_kemudahan_awam_jumlah" placeholder="Jumlah">
                                                                </div>
                                                                <input type="hidden" name="pk7_krt_profileID" id="pk7_krt_profileID">
                                                                <input type="hidden" name="add_profile_krt_kemudahan_awam" value="add">
                                                                <button type="submit" class="btn btn-primary pull-right" id="btn_save_kemudahan_awam"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                            </div>
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_kemudahan_awam_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="background-color: #113f50" ><font color="white">Bil</font></th>
                                                                        <th style="background-color: #113f50" ><font color="white">Perkara</font></th>
                                                                        <th style="background-color: #113f50" ><font color="white">Jumlah</font></th>
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
                                            <button type="button" class="btn btn-primary" id="btn_next">Seterusnya&nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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

@include('js.rt-sm2.j-profile-krt-3')
