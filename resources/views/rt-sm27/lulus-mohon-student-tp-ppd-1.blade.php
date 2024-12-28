@extends('layout.master')
@section('title', 'Kelulusan Permohonan Kemasukan Tabika Perpaduan')


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
                                                <select class="form-control" name="lmstpd_state_id" id="lmstpd_state_id" disabled>
                                                    <option value="" selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                    @foreach($negeri as $item)                                    
                                                        <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Daerah / Bahagian: </label>
                                                <select class="form-control" name="lmstpd_daerah_id" id="lmstpd_daerah_id" disabled>
                                                    <option value="" selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                     @foreach($daerah as $item)                                    
                                                        <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Nama Tabika Perpaduan: </label>
                                                <select class="form-control" name="lmstpd_tabika_id" id="lmstpd_tabika_id" disabled>
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
                                            <h6><b>MAKLUMAT PENGESAHAN GURU</b></h6>
                                            <br>
                                            <div class="form-group">
                                                <label class="form-label">Status: </label>
                                                <select class="form-control" name="lmstpd_status_pengesahan" id="lmstpd_status_pengesahan" disabled>
                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                    <option value="4">Perlu Dikemaskini</option>
                                                    <option value="5">Layak</option>
                                                    <option value="8">Dipertimbangkan</option>
                                                    <option value="7">Ditolak</option>
                                                </select>
                                            </div>
                                            <div class="form-group" >
                                                <label class="form-label">Penerangan: </label>
                                                <textarea class="form-control" rows="4"  name="lmstpd_disahkan_note" id="lmstpd_disahkan_note" disabled></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <h6><b>MAKLUMAT STATUS KELULUSAN</b></h6>
                                            <br><br>
                                            <form action="#" id="form_lmstpd">
                                            @csrf
                                                <div class="form-group">
                                                    <label class="form-label">Status: <span class="text-red">*</span></label>
                                                    <select class="form-control" name="lmstpd_student_status" id="lmstpd_student_status">
                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                        <option value="1">Berjaya</option>
                                                        <option value="9">Tidak Berjaya</option>
                                                    </select>
                                                    <div class="error_lmstpd_student_status invalid-feedback text-right"></div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group pull-right">
                                                        <input type="hidden" name="lmstpd_student_id" id="lmstpd_student_id">
                                                        <input type="hidden" name="post_lulus_permohonan_student" value="edit">
                                                        <input type="hidden" name="action" id="post_lulus_permohonan_student" value="edit">
                                                        <button type="submit" class="btn btn-primary" id="btn_submit">Hantar Status Kelulusan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
                                                    </div>
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
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <h6><b>MAKLUMAT PERMOHONAN</b></h6>
                                        <br>
                                        <span><b>Bahagian B : Maklumat Ibu/Bapa/Penjaga</b></span>
                                        <hr>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="row clearfix">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <label class="form-label">Maklumat Ibu</label>
                                                    <br>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Nama: </label>
                                                        <input type="text" class="form-control" name="lmstpd_ibu_nama" id="lmstpd_ibu_nama" placeholder="Nama" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Pekerjaan: </label>
                                                        <input type="text" class="form-control" name="lmstpd_ibu_pekerjaan" id="lmstpd_ibu_pekerjaan" placeholder="Pekerjaan" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Sektor Pekerjaan: </label>
                                                        <select class="form-control" name="lmstpd_ibu_profession_id" id="lmstpd_ibu_profession_id" disabled>
                                                            <option value="" selected style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            @foreach($ref_profession as $item)                                    
                                                                <option value="{{ $item->id }}">{{ $item->profession_description }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Pendapatan Bulanan (RM): </label>
                                                        <input type="text" class="form-control" name="lmstpd_ibu_pendapatan" id="lmstpd_ibu_pendapatan" placeholder="Pendapatan Bulanan" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Kerakyatan: </label>
                                                        <select class="form-control" name="lmstpd_ibu_kerakyatan_id" id="lmstpd_ibu_kerakyatan_id" disabled>
                                                            <option value="" selected style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            @foreach($ref_kerakyatan as $item)                                    
                                                                <option value="{{ $item->id }}">{{ $item->warganegara_description }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Jumlah Pendapatan Bulanan (RM): </label>
                                                        <input type="text" class="form-control" name="lmstpd_ibu_jumlah_pendapatan" id="lmstpd_ibu_jumlah_pendapatan" placeholder="Jumlah Pendapatan Bulanan" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Jumlah Pendapatan Lain (RM): <span class="text-red">(sekiranya ada)</span></label>
                                                        <input type="text" class="form-control" name="lmstpd_ibu_jumlah_pendapatan_lain" id="lmstpd_ibu_jumlah_pendapatan_lain" placeholder="Jumlah Pendapatan Lain" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">No Kad Pengenalan: </label>
                                                        <input type="text" class="form-control" name="lmstpd_ibu_ic" id="lmstpd_ibu_ic" placeholder="No Kad Pengenalan" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Alamat Tempat Kerja: </label>
                                                        <textarea class="form-control" rows="5" name="lmstpd_ibu_alamat_office" id="lmstpd_ibu_alamat_office" placeholder="Alamat Tempat Kerja" disabled></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Telefon Pejabat: </label>
                                                        <input type="text" class="form-control" name="lmstpd_ibu_phone_office" id="lmstpd_ibu_phone_office" placeholder="No Telefon Pejabat" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Telefon Bimbit: </label>
                                                        <input type="text" class="form-control" name="lmstpd_ibu_phone" id="lmstpd_ibu_phone" placeholder="No Telefon Bimbit" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Telefon Rumah: </label>
                                                        <input type="text" class="form-control" name="lmstpd_ibu_phone_rumah" id="lmstpd_ibu_phone_rumah" placeholder="No Telefon Rumah" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Bilangan Anak: </label>
                                                        <input type="text" class="form-control" name="lmstpd_ibu_bil_anak" id="lmstpd_ibu_bil_anak" placeholder="Bilangan Anak" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Hubungan Dengan Murid: </label>
                                                        <input type="text" class="form-control" name="lmstpd_ibu_hubungan_student" id="lmstpd_ibu_hubungan_student" placeholder="Hubungan Dengan Murid" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Tabika Perpaduan Adalah Pilihan yang Kebarapa ? : </label>
                                                        <select class="form-control" name="lmstpd_ibu_pilihan" id="lmstpd_ibu_pilihan" disabled>
                                                            <option value="" disabled selected style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            <option value="1">Pertama</option>
                                                            <option value="2">Kedua</option>
                                                            <option value="3">Ketiga</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Bilangan Anak Bersekolah:</label>
                                                        <input type="text" class="form-control" name="lmstpd_ibu_bil_anak_sekolah" id="lmstpd_ibu_bil_anak_sekolah" placeholder="Bilangan Anak Bersekolah" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Tabika Lain Yang Dipohon: <span class="text-red">(jika ada)</span></label>
                                                        <input type="text" class="form-control" name="lmstpd_ibu_tabika_lain" id="lmstpd_ibu_tabika_lain" placeholder="Nama Tabika Lain Yang Dipohon" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row clearfix">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Pengesahan Ibu/Bapa/Penjaga: </label>
                                                        <div class="table-responsive">
                                                        <table class="table thead-dark table-bordered table-striped" id="senarai_pengesahan_penjaga_table" style="width: 100%" border="0">
                                                            <input type="hidden" name="lmstpd_1_student_id" id="lmstpd_1_student_id">
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <span><b>Bahagian C : Maklumat Muatnaik Salinan Dokumen</b></span>
                                        <hr>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="row clearfix">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
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
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <br>
                                        <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                        <button type="button" class="btn btn-secondary" disabled>Seterusnya&nbsp;&nbsp;<i class="ropdown-icon fe fe-arrow-right"></i></button>
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

@include('js.rt-sm27.j-lulus-mohon-student-tp-ppd-1')