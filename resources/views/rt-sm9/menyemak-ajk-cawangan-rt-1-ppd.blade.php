@extends('layout.master')
@section('title', 'Menyemak Profil Ahli Jawatan Kuasa Cawangan')


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
                                <form method="POST" id="form_macr_ppd">
                                @csrf
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="row clearfix">
                                                        <h6><b>MAKLUMAT KAWASAN RUKUN TETANGGA</b></h6>
                                                        <br><br>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="macr_ppd_nama_krt" name="macr_ppd_nama_krt"></span></b></p>
                                                            <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="macr_ppd_alamat_krt" name="macr_ppd_alamat_krt"></span></b></p>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <p><span style="font-size:12px">Negeri</span><br><b><span id="macr_ppd_negeri_krt" name="macr_ppd_negeri_krt"></span></b></p>
                                                            <p><span style="font-size:12px">Parlimen</span><br><b><span id="macr_ppd_parlimen_krt" name="macr_ppd_parlimen_krt"></span></b></p>
                                                            <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="macr_ppd_pbt_krt" name="macr_ppd_pbt_krt"></span></b></p>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <p><span style="font-size:12px">Daerah</span><br><b><span id="macr_ppd_daerah_krt" name="macr_ppd_daerah_krt"></span></b></p>
                                                            <p><span style="font-size:12px">Dun</span><br><b><span id="macr_ppd_dun_krt" name="macr_ppd_dun_krt"></span></b></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h6><b>MAKLUMAT CAWANGAN RUKUN TETANGGA</b></h6>
                                                    <br><br>
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Cawangan: </label>
                                                        <div class="form-group">
                                                            <select class="custom-select" id="macr_ppd_cawangan_id" name="macr_ppd_cawangan_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($cawangan as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->cawangan_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h6><b>MAKLUMAT STATUS MENYEMAK</b></h6>
                                                    <br><br>
                                                    <div class="form-group">
                                                        <label class="form-label">Status: </label>
                                                        <select class="form-control" disabled="">
                                                            <option>-- Sila Pilih --</option>
                                                            <option>Disahkan</option>
                                                            <option>Perlu Dikemaskini</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Penerangan: </label>
                                                        <textarea class="form-control" rows="4" disabled=""></textarea>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group pull-right">
                                                            <button type="submit" class="btn btn-secondary" disabled="">Hantar Status Semakan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-8 col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <h6><b>MAKLUMAT Profil Ahli Jawatan Kuasa</b></h6>
                                            <br>
                                            <p>1. Maklumat Asas</p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <form method="POST" id="form_macr_ppd_1">
                                                @csrf
                                                    <div class="row clearfix">
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Nama Pemohon: </label>
                                                                <input type="text" class="form-control" name="macr_ppd_1_ajk_nama" id="macr_ppd_1_ajk_nama" placeholder="Nama Pemohon" disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Tarikh Lahir: </label>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                    </div>
                                                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="macr_ppd_1_ajk_tarikh_lahir" id="macr_ppd_1_ajk_tarikh_lahir" placeholder="Tarikh Lahir" data-date-format="dd/mm/yyyy" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Jantina: </label>
                                                                <div class="form-group">
                                                                    <select class="custom-select" id="macr_ppd_1_jantina_id" name="macr_ppd_1_jantina_id" disabled>
                                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                        @foreach($jantina as $item)                                    
                                                                            <option value="{{ $item->id }}">{{ $item->jantina_description }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Kaum: <span class="text-red">*</span></label>
                                                                <div class="form-group">
                                                                    <select class="custom-select" id="macr_ppd_1_kaum_id" name="macr_ppd_1_kaum_id" disabled>
                                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                        @foreach($kaum as $item)                                    
                                                                            <option value="{{ $item->id }}">{{ $item->kaum_description }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">No Kad Pengenalan: </label>
                                                                <input type="text" class="form-control" name="macr_ppd_1_ajk_ic" id="macr_ppd_1_ajk_ic" placeholder="No Kad Pengenalan" disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Umur: </label>
                                                                <input type="text" class="form-control" name="macr_ppd_1_umur" id="macr_ppd_1_umur" placeholder="Umur" disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Status Perkahwinan: </label>
                                                                <div class="form-group">
                                                                    <select class="custom-select" id="macr_ppd_1_status_perkahwinan_id" name="macr_ppd_1_status_perkahwinan_id" disabled>
                                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                        @foreach($status_perkahwinan as $item)                                    
                                                                            <option value="{{ $item->id }}">{{ $item->perkahwinan_description }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Alamat Terkini: </label>
                                                                <textarea class="form-control" name="macr_ppd_1_ajk_alamat" id="macr_ppd_1_ajk_alamat" rows="4" disabled></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Poskod: </label>
                                                                <input type="text" class="form-control" name="macr_ppd_1_ajk_poskod" id="macr_ppd_1_ajk_poskod" placeholder="Poskod" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">No Telefon: </label>
                                                                <input type="text" class="form-control" name="macr_ppd_1_ajk_phone" id="macr_ppd_1_ajk_phone" placeholder="No Telefon" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Emel: </label>
                                                                <input type="text" class="form-control" name="macr_ppd_1_ajk_email" id="macr_ppd_1_ajk_email" placeholder="Emel" disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Jawatan (dalam cawangan): </label>
                                                                <div class="form-group">
                                                                    <select class="custom-select" id="macr_ppd_1_jawatan_cawangan_id" name="macr_ppd_1_jawatan_cawangan_id" disabled>
                                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                        @foreach($jawatan_cawangan as $item)                                    
                                                                            <option value="{{ $item->id }}">{{ $item->jawatan_description }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <br>
                                            <p>2. Maklumat Akademik : </p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <form action="#" id="form_macr_ppd_2">
                                                {{ csrf_field() }}
                                                    <div class="row clearfix">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="col-md-12 alert alert-danger error_form_tacr_2" role="alert" style="display: none; padding-bottom: 0px;">
                                                                <ul></ul>
                                                            </div>
                                                            <div class="table-responsive">
                                                                <table class="table thead-dark table-bordered table-striped" id="senarai_pendidikan_table" style="width: 100%" border="1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Tahap Pendidikan</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Tahun Graduasi</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Pencapaian</font></label></th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                            <br><br>
                                                        </div>
                                                    </div>
                                                </form>
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
<link rel="stylesheet" href="../assets/plugins/datatable/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/plugins/datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/plugins/datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@stop

@include('js.rt-sm9.j-menyemak-ajk-cawangan-rt-1-ppd')
