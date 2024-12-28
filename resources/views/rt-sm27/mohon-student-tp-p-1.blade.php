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
                                            <h6><b>MAKLUMAT TABIKA PERPADUAN</b></h6>
                                            <br>
                                            <div class="form-group">
                                                <label class="form-label">Negeri: </label>
                                                <select class="form-control" name="mstpp_1_state_id" id="mstpp_1_state_id" disabled>
                                                    <option value="" selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                    @foreach($negeri as $item)                                    
                                                        <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Daerah / Bahagian: </label>
                                                <select class="form-control" name="mstpp_1_daerah_id" id="mstpp_1_daerah_id" disabled>
                                                    <option value="" selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                     @foreach($daerah as $item)                                    
                                                        <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Nama Tabika Perpaduan: </label>
                                                <select class="form-control" name="mstpp_1_tabika_id" id="mstpp_1_tabika_id" disabled>
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
                        </div>
                        <div class="col-lg-8 col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <h6><b>MAKLUMAT PERMOHONAN</b></h6>
                                        <br>
                                        <span><b>Bahagian B : Maklumat Ibu/Bapa/Penjaga</b></span>
                                        <hr>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <form method="POST" id="form_mstpp_2">
                                            @csrf
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <label class="form-label">Maklumat Ibu</label>
                                                        <br>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Nama: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="mstpp_2_ibu_nama" id="mstpp_2_ibu_nama" placeholder="Nama">
                                                            <div class="error_mstpp_2_ibu_nama invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Pekerjaan: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="mstpp_2_ibu_pekerjaan" id="mstpp_2_ibu_pekerjaan" placeholder="Pekerjaan">
                                                            <div class="error_mstpp_2_ibu_pekerjaan invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Sektor Pekerjaan: <span class="text-red">*</span></label>
                                                            <select class="form-control" name="mstpp_2_ibu_profession_id" id="mstpp_2_ibu_profession_id">
                                                                <option value="" selected style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($ref_profession as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->profession_description }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="error_mstpp_2_ibu_profession_id invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Pendapatan Bulanan (RM): <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="mstpp_2_ibu_pendapatan" id="mstpp_2_ibu_pendapatan" placeholder="Pendapatan Bulanan">
                                                            <div class="error_mstpp_2_ibu_pendapatan invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Kerakyatan: <span class="text-red">*</span></label>
                                                            <select class="form-control" name="mstpp_2_ibu_kerakyatan_id" id="mstpp_2_ibu_kerakyatan_id">
                                                                <option value="" selected style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($ref_kerakyatan as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->warganegara_description }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="error_mstpp_2_ibu_pendapatan invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Jumlah Pendapatan Bulanan (RM): <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="mstpp_2_ibu_jumlah_pendapatan" id="mstpp_2_ibu_jumlah_pendapatan" placeholder="Jumlah Pendapatan Bulanan">
                                                            <div class="error_mstpp_2_ibu_jumlah_pendapatan invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Jumlah Pendapatan Lain (RM): <span class="text-red">(sekiranya ada)</span></label>
                                                            <input type="text" class="form-control" name="mstpp_2_ibu_jumlah_pendapatan_lain" id="mstpp_2_ibu_jumlah_pendapatan_lain" placeholder="Jumlah Pendapatan Lain">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">No Kad Pengenalan: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="mstpp_2_ibu_ic" id="mstpp_2_ibu_ic" placeholder="No Kad Pengenalan">
                                                            <div class="error_mstpp_2_ibu_ic invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Alamat Tempat Kerja: <span class="text-red">*</span></label>
                                                            <textarea class="form-control" rows="5" name="mstpp_2_ibu_alamat_office" id="mstpp_2_ibu_alamat_office" placeholder="Alamat Tempat Kerja"></textarea>
                                                            <div class="error_mstpp_2_ibu_alamat_office invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">No Telefon Pejabat: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="mstpp_2_ibu_phone_office" id="mstpp_2_ibu_phone_office" placeholder="No Telefon Pejabat">
                                                            <div class="error_mstpp_2_ibu_phone_office invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">No Telefon Bimbit: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="mstpp_2_ibu_phone" id="mstpp_2_ibu_phone" placeholder="No Telefon Bimbit">
                                                            <div class="error_mstpp_2_ibu_phone invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">No Telefon Rumah: </label>
                                                            <input type="text" class="form-control" name="mstpp_2_ibu_phone_rumah" id="mstpp_2_ibu_phone_rumah" placeholder="No Telefon Rumah">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Bilangan Anak: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="mstpp_2_ibu_bil_anak" id="mstpp_2_ibu_bil_anak" placeholder="Bilangan Anak">
                                                            <div class="error_mstpp_2_ibu_bil_anak invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Hubungan Dengan Murid: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="mstpp_2_ibu_hubungan_student" id="mstpp_2_ibu_hubungan_student" placeholder="Hubungan Dengan Murid">
                                                            <div class="error_mstpp_2_ibu_hubungan_student invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Tabika Perpaduan Adalah Pilihan yang Kebarapa ? : <span class="text-red">*</span></label>
                                                            <select class="form-control" name="mstpp_2_ibu_pilihan" id="mstpp_2_ibu_pilihan">
                                                                <option value="" disabled selected style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                <option value="1">Pertama</option>
                                                                <option value="2">Kedua</option>
                                                                <option value="3">Ketiga</option>
                                                            </select>
                                                            <div class="error_mstpp_2_ibu_pilihan invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Bilangan Anak Bersekolah: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="mstpp_2_ibu_bil_anak_sekolah" id="mstpp_2_ibu_bil_anak_sekolah" placeholder="Bilangan Anak Bersekolah">
                                                            <div class="error_mstpp_2_ibu_bil_anak_sekolah invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Nama Tabika Lain Yang Dipohon: <span class="text-red">(jika ada)</span></label>
                                                            <input type="text" class="form-control" name="mstpp_2_ibu_tabika_lain" id="mstpp_2_ibu_tabika_lain" placeholder="Nama Tabika Lain Yang Dipohon">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="row clearfix">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Pengesahan Ibu/Bapa/Penjaga: </label>
                                                        <div class="table-responsive">
                                                        <table class="table thead-dark table-bordered table-striped" id="senarai_pengesahan_penjaga_table" style="width: 100%" border="0">
                                                            <input type="hidden" name="mstpp_3_student_id" id="mstpp_3_student_id">
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <span><b>Bahagian C : Maklumat Muatnaik Salinan Dokumen</b></span>
                                        <hr>
                                        <form action="#" id="form_mstpp_4">
                                        {{ csrf_field() }}
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="col-md-12 alert alert-danger error_mstpp_4" role="alert" style="display: none; padding-bottom: 0px;">
                                                            <ul></ul>
                                                        </div>
                                                        <div class="series-frame">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Nama Dokumen : </label>
                                                                    <select class="form-control" name="mstpp_4_file_title" id="mstpp_4_file_title">
                                                                        <option value="" disabled selected style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                        <option>Slip Gaji </option>
                                                                        <option>Kad Pengenalan </option>
                                                                        <option>Bil Utiliti (Air)</option>
                                                                        <option>Bil Utiliti (Elektrik)</option>
                                                                        <option>Bil Utiliti (Internet)</option>
                                                                        <option>MyKID</option>
                                                                        <option>Sijil Lahir</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Dokumen: </label>
                                                                    <input type="file" class="form-control" name="mstpp_4_file_dokument" id="mstpp_4_file_dokument" placeholder="Dokumen">
                                                                </div>
                                                                <input type="hidden" name="mstpp_4_student_id" id="mstpp_4_student_id">
                                                                <input type="hidden" name="add_tbk_student_dokument" value="add">
                                                                <button type="submit" class="btn btn-primary pull-right" id="btn_save_dokument">Tambah</button>
                                                            </div>
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_muatnaik_dokumen_table" style="width: 100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%" style="background-color: #113f50" ><font color="white"><b>Bil</b></font></th>
                                                                        <th width="40%" style="background-color: #113f50" ><font color="white"><b>Nama Dokumen</b></font></th>
                                                                        <th width="40%" style="background-color: #113f50" ><font color="white"><b>Fail Dokumen</b></font></th>
                                                                        <th width="10%" style="background-color: #113f50" ><font color="white"><b>Tindakan</b></font></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <br>
                                        <form method="POST" id="form_mstpp_5">
                                        @csrf
                                            <input type="hidden" name="mstpp_5_student_id" id="mstpp_5_student_id">
                                            <input type="hidden" name="post_permohonan_student_tp_2" value="edit">
                                            <input type="hidden" name="action" id="post_permohonan_student_tp_2" value="edit">
                                            <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                            <button type="submit" class="btn btn-primary" id="btn_send">Hantar Permohonan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@stop

@include('js.rt-sm27.j-mohon-student-tp-p-1')