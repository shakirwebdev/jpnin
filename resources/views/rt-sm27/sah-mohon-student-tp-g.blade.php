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
                                            <h6><b>MAKLUMAT TABIKA PERPADUAN</b></h6>
                                            <br>
                                            <div class="form-group">
                                                <label class="form-label">Negeri: </label>
                                                <select class="form-control" name="smstg_state_id" id="smstg_state_id" disabled>
                                                    <option value="" selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                    @foreach($negeri as $item)                                    
                                                        <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                    @endforeach
                                                </select>
                                           </div>
                                            <div class="form-group">
                                                <label class="form-label">Daerah / Bahagian: </label>
                                                <select class="form-control" name="smstg_daerah_id" id="smstg_daerah_id" disabled>
                                                    <option value="" selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                    @foreach($daerah as $item)                                    
                                                        <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Nama Tabika Perpaduan: </label>
                                                <select class="form-control" name="smstg_tabika_id" id="smstg_tabika_id" disabled>
                                                    <option value="" selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                    @foreach($tabika_profile as $item)                                    
                                                        <option value="{{ $item->id }}">{{ $item->tbk_nama }}</option>
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
                                            <h6><b>MAKLUMAT STATUS PENGESAHAN</b></h6>
                                            <br><br>
                                            <div class="form-group">
                                                <label class="form-label">Status: </label>
                                                <select class="form-control" disabled>
                                                    <option>-- Sila Pilih --</option>
                                                    <option>Disahkan</option>
                                                    <option>Perlu Dikemaskini</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Penerangan: </label>
                                                <textarea class="form-control" rows="4" disabled></textarea>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group pull-right">
                                                    <button type="submit" class="btn btn-secondary" disabled>Hantar Status Pengesahan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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
                                        <h6><b>MAKLUMAT PERMOHONAN</b></h6>
                                        <br>
                                        <span><b>Bahagian A : Maklumat Murid</b></span>
                                        <hr>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="row clearfix">
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Penuh: </label>
                                                        <input type="text" class="form-control" name="smstg_student_nama" id="smstg_student_nama" placeholder="Nama Penuh" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Sijil Lahir: </label>
                                                        <input type="text" class="form-control" name="smstg_student_sijil_lahir" id="smstg_student_sijil_lahir" placeholder="No Sijil Lahir" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Agama: </label>
                                                        <select class="form-control" name="smstg_student_agama_id" id="smstg_student_agama_id" disabled>
                                                            <option value="" selected style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            @foreach($ref_agama as $item)                                    
                                                                <option value="{{ $item->id }}">{{ $item->agama_description }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Kaum: </label>
                                                        <select class="form-control" name="smstg_student_kaum_id" id="smstg_student_kaum_id" disabled>
                                                            <option value="" selected style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            @foreach($ref_kaum as $item)                                    
                                                                <option value="{{ $item->id }}">{{ $item->kaum_description }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">No Mykid: </label>
                                                        <input type="text" class="form-control" name="smstg_student_mykid" id="smstg_student_mykid" placeholder="No Mykid" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <b>Tarikh Lahir: </b>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                            </div>
                                                            <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="smstg_student_tarikh_lahir" id="smstg_student_tarikh_lahir" placeholder="Tarikh Lahir" data-date-format="dd/mm/yyyy" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Jantina: </label>
                                                        <select class="form-control" name="smstg_student_jantina_id" id="smstg_student_jantina_id" disabled>
                                                            <option value="" selected style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            @foreach($ref_jantina as $item)                                    
                                                                <option value="{{ $item->id }}">{{ $item->jantina_description }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Alahan / Masalah Kesihatan: <span class="text-red">(jika ada)</span></label>
                                                        <input type="text" class="form-control" name="smstg_student_kesihatan" id="smstg_student_kesihatan" placeholder="Alahan / Masalah Kesihatan" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Alamat Rumah: </label>
                                                        <textarea class="form-control" rows="4" name="smstg_student_alamat" id="smstg_student_alamat" placeholder="Alamat Rumah" disabled></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Jarak Rumah Ke Sekolah (KM): </label>
                                                        <input type="text" class="form-control" name="smstg_student_jarak_rumah" id="smstg_student_jarak_rumah" placeholder="Jarak Rumah Ke Sekolah (KM)" disabled>
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
                                                        <label class="form-label">Nama: </label>
                                                        <input type="text" class="form-control" name="smstg_bapa_nama" id="smstg_bapa_nama" placeholder="Nama" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Pekerjaan: </label>
                                                        <input type="text" class="form-control" name="smstg_bapa_pekerjaan" id="smstg_bapa_pekerjaan" placeholder="Pekerjaan" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Sektor Pekerjaan: </label>
                                                        <select class="form-control" name="smstg_bapa_profession_id" id="smstg_bapa_profession_id" disabled>
                                                            <option value="" selected style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            @foreach($ref_profession as $item)                                    
                                                                <option value="{{ $item->id }}">{{ $item->profession_description }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Pendapatan Bulanan (RM): </label>
                                                        <input type="text" class="form-control" name="smstg_bapa_pendapatan" id="smstg_bapa_pendapatan" placeholder="Pendapatan Bulanan" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Kerakyatan: </label>
                                                        <select class="form-control" name="smstg_bapa_kerakyatan_id" id="smstg_bapa_kerakyatan_id" disabled>
                                                            <option value="" selected style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            @foreach($ref_kerakyatan as $item)                                    
                                                                <option value="{{ $item->id }}">{{ $item->warganegara_description }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Jumlah Pendapatan Bulanan (RM): </label>
                                                        <input type="text" class="form-control" name="smstg_bapa_jumlah_pendapatan" id="smstg_bapa_jumlah_pendapatan" placeholder="Jumlah Pendapatan Bulanan" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">No Kad Pengenalan: </label>
                                                        <input type="text" class="form-control" name="smstg_bapa_ic" id="smstg_bapa_ic" placeholder="No Kad Pengenalan" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Alamat Tempat Kerja: </label>
                                                        <textarea class="form-control" rows="5" name="smstg_bapa_alamat_office" id="smstg_bapa_alamat_office" placeholder="Alamat Tempat Kerja" disabled></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Telefon Pejabat: </label>
                                                        <input type="text" class="form-control" name="smstg_bapa_phone_office" id="smstg_bapa_phone_office" placeholder="No Telefon Pejabat" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Telefon Bimbit: </label>
                                                        <input type="text" class="form-control" name="smstg_bapa_phone" id="smstg_bapa_phone" placeholder="No Telefon Bimbit" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Telefon Rumah: </label>
                                                        <input type="text" class="form-control" name="smstg_bapa_phone_rumah" id="smstg_bapa_phone_rumah" placeholder="No Telefon Rumah" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <br>
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
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@stop

@include('js.rt-sm27.j-sah-mohon-student-tp-g')