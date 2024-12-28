@extends('layout.master')
@section('title', 'Permohonan Kemasukan Tabika Perpaduan')


@section('content')
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
    <div class="section-body mt-3" style="display:none;" id="mstpp_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert" >
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> 
                                <span class="text-red blink" id="mstpp_status_description" name="mstpp_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> 
                                <span id="mstpp_disahkan_note" name="mstpp_disahkan_note"></span></span>
                                <span id="mstpp_diluluskan_note" name="mstpp_diluluskan_note"></span></span>.
                                <br>
                                <input type="hidden" name="mstpp_student_status" id="mstpp_student_status">
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
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="row clearfix">
                        <div class="col-lg-4 col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <form method="POST" id="form_mstpp">
                                            @csrf
                                                <h6><b>MAKLUMAT TABIKA PERPADUAN</b></h6>
                                                <br>
                                                <div class="form-group">
                                                    <label class="form-label">Negeri: <span class="text-red">*</span></label>
                                                    <select class="form-control" name="mstpp_state_id" id="mstpp_state_id">
                                                        <option value="" selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                        @foreach($negeri as $item)                                    
                                                            <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="error_mstpp_state_id invalid-feedback text-right"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Daerah / Bahagian: <span class="text-red">*</span></label>
                                                    <select class="form-control" name="mstpp_daerah_id" id="mstpp_daerah_id" disabled>
                                                        <option value="" selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                    </select>
                                                    <div class="error_mstpp_daerah_id invalid-feedback text-right"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Nama Tabika Perpaduan: <span class="text-red">*</span></label>
                                                    <select class="form-control" name="mstpp_tabika_id" id="mstpp_tabika_id" disabled>
                                                        <option value="" selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                    </select>
                                                    <div class="error_mstpp_tabika_id invalid-feedback text-right"></div>
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
                                    <form method="POST" id="form_mstpp_1">
                                    @csrf
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <h6><b>MAKLUMAT PERMOHONAN</b></h6>
                                            <br>
                                            <span><b>Bahagian A : Maklumat Murid</b></span>
                                            <hr>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Nama Penuh: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="mstpp_1_student_nama" id="mstpp_1_student_nama" placeholder="Nama Penuh">
                                                            <div class="error_mstpp_1_student_nama invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">No Sijil Lahir: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="mstpp_1_student_sijil_lahir" id="mstpp_1_student_sijil_lahir" placeholder="No Sijil Lahir">
                                                            <div class="error_mstpp_1_student_sijil_lahir invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Agama: <span class="text-red">*</span></label>
                                                            <select class="form-control" name="mstpp_1_student_agama_id" id="mstpp_1_student_agama_id">
                                                                <option value="" selected style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($ref_agama as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->agama_description }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="error_mstpp_1_student_agama_id invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Kaum: <span class="text-red">*</span></label>
                                                            <select class="form-control" name="mstpp_1_student_kaum_id" id="mstpp_1_student_kaum_id">
                                                                <option value="" selected style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($ref_kaum as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->kaum_description }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="error_mstpp_1_student_kaum_id invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">No Mykid: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="mstpp_1_student_mykid" id="mstpp_1_student_mykid" placeholder="No Mykid">
                                                            <div class="error_mstpp_1_student_mykid invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Tarikh Lahir: <span class="text-red">*</span></b>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                                <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="mstpp_1_student_tarikh_lahir" id="mstpp_1_student_tarikh_lahir" placeholder="Tarikh Lahir" data-date-format="dd/mm/yyyy">
                                                            </div>
                                                            <div class="error_mstpp_1_student_tarikh_lahir invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Jantina: <span class="text-red">*</span></label>
                                                            <select class="form-control" name="mstpp_1_student_jantina_id" id="mstpp_1_student_jantina_id">
                                                                <option value="" selected style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($ref_jantina as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->jantina_description }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="error_mstpp_1_student_jantina_id invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Alahan / Masalah Kesihatan: <span class="text-red">(jika ada)</span></label>
                                                            <input type="text" class="form-control" name="mstpp_1_student_kesihatan" id="mstpp_1_student_kesihatan" placeholder="Alahan / Masalah Kesihatan">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Alamat Rumah: <span class="text-red">*</span></label>
                                                            <textarea class="form-control" rows="4" name="mstpp_1_student_alamat" id="mstpp_1_student_alamat" placeholder="Alamat Rumah"></textarea>
                                                            <div class="error_mstpp_1_student_alamat invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Jarak Rumah Ke Sekolah (KM): <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="mstpp_1_student_jarak_rumah" id="mstpp_1_student_jarak_rumah" placeholder="Jarak Rumah Ke Sekolah (KM)">
                                                            <div class="error_mstpp_1_student_jarak_rumah invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <span><b>Bahagian B : Maklumat Ibu/Bapa/Penjaga</b></span>
                                            <hr>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <label class="form-label">Maklumat Bapa/Penjaga</label>
                                                        <br>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Nama: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="mstpp_1_bapa_nama" id="mstpp_1_bapa_nama" placeholder="Nama">
                                                            <div class="error_mstpp_1_bapa_nama invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Pekerjaan: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="mstpp_1_bapa_pekerjaan" id="mstpp_1_bapa_pekerjaan" placeholder="Pekerjaan">
                                                            <div class="error_mstpp_1_bapa_pekerjaan invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Sektor Pekerjaan: <span class="text-red">*</span></label>
                                                            <select class="form-control" name="mstpp_1_bapa_profession_id" id="mstpp_1_bapa_profession_id">
                                                                <option value="" selected style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($ref_profession as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->profession_description }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="error_mstpp_1_bapa_profession_id invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Pendapatan Bulanan (RM): <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="mstpp_1_bapa_pendapatan" id="mstpp_1_bapa_pendapatan" placeholder="Pendapatan Bulanan">
                                                            <div class="error_mstpp_1_bapa_pendapatan invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Kerakyatan: <span class="text-red">*</span></label>
                                                            <select class="form-control" name="mstpp_1_bapa_kerakyatan_id" id="mstpp_1_bapa_kerakyatan_id">
                                                                <option value="" selected style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($ref_kerakyatan as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->warganegara_description }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="error_mstpp_1_bapa_kerakyatan_id invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Jumlah Pendapatan Bulanan (RM): <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="mstpp_1_bapa_jumlah_pendapatan" id="mstpp_1_bapa_jumlah_pendapatan" placeholder="Jumlah Pendapatan Bulanan">
                                                            <div class="error_mstpp_1_bapa_jumlah_pendapatan invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">No Kad Pengenalan: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="mstpp_1_bapa_ic" id="mstpp_1_bapa_ic" placeholder="No Kad Pengenalan">
                                                            <div class="error_mstpp_1_bapa_ic invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Alamat Tempat Kerja: <span class="text-red">*</span></label>
                                                            <textarea class="form-control" rows="5" name="mstpp_1_bapa_alamat_office" id="mstpp_1_bapa_alamat_office" placeholder="Alamat Tempat Kerja"></textarea>
                                                            <div class="error_mstpp_1_bapa_alamat_office invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">No Telefon Pejabat: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="mstpp_1_bapa_phone_office" id="mstpp_1_bapa_phone_office" placeholder="No Telefon Pejabat">
                                                            <div class="error_mstpp_1_bapa_phone_office invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">No Telefon Bimbit: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="mstpp_1_bapa_phone" id="mstpp_1_bapa_phone" placeholder="No Telefon Bimbit">
                                                            <div class="error_mstpp_1_bapa_phone invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">No Telefon Rumah: </label>
                                                            <input type="text" class="form-control" name="mstpp_1_bapa_phone_rumah" id="mstpp_1_bapa_phone_rumah" placeholder="No Telefon Rumah">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <br>
                                            <input type="hidden" name="mstpp_1_student_id" id="mstpp_1_student_id">
                                            <input type="hidden" name="post_permohonan_student_tp_1" value="edit">
                                            <input type="hidden" name="action" id="post_permohonan_student_tp_1" value="edit">
                                            <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                            <button type="submit" class="btn btn-primary" id="btn_next">Seterusnya&nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
                                        </div>
                                    </form>
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

@include('js.rt-sm27.j-mohon-student-tp-p')