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
                                                <select class="form-control" name="" id="" disabled>
                                                    <option>PERLIS</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Daerah: </label>
                                                <select class="form-control" name="" id="" disabled>
                                                    <option>PERLIS</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Nama Tabika Perpaduan: </label>
                                                <select class="form-control" name="" id="" disabled>
                                                    <option>Tabika Perpaduan Kuala Perlis</option>
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
                                            <h6><b>MAKLUMAT STATUS KELULUSAN</b></h6>
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
                                                    <button type="submit" class="btn btn-secondary" disabled>Hantar Status Kelulusan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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
                                                        <input type="text" class="form-control" name="" placeholder="Nama Penuh" value="Nur Aina Binti Saharudin" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Sijil Lahir: </label>
                                                        <input type="text" class="form-control" name="" placeholder="No Sijil Lahir" value="j9127341" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Agama: </label>
                                                        <select class="form-control" name="" id="" disabled>
                                                            <option>ISLAM</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Kaum: </label>
                                                        <select class="form-control" name="" id="" disabled>
                                                            <option>MELAYU</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">No Mykid: </label>
                                                        <input type="text" class="form-control" name="" placeholder="No Mykid" value="140508095161" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <b>Tarikh Lahir: </b>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                            </div>
                                                            <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="" id="" placeholder="Tarikh Lahir" data-date-format="dd/mm/yyyy" value="08/05/2014" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Jantina: </label>
                                                        <select class="form-control" name="" id="" disabled>
                                                            <option>PEREMPUAN</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Alahan / Masalah Kesihatan: <span class="text-red">(jika ada)</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="Nama Pihak Pertama" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Alamat Rumah: </label>
                                                        <textarea class="form-control" rows="4" name="" placeholder="Alamat Rumah" disabled>NO, 10 Lorong 5 Taman Peladang Jaya, 02000 Kuala Perlis, Perlis</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Jarak Rumah Ke Sekolah (KM): </label>
                                                        <input type="text" class="form-control" name="" placeholder="Jarak Rumah Ke Sekolah (KM)" value="5"  disabled>
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
                                                        <input type="text" class="form-control" name="" placeholder="Nama" value="Saharudin Bin Abas" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Pekerjaan: </label>
                                                        <input type="text" class="form-control" name="" placeholder="Nama" value="Petani" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Sektor Pekerjaan: </label>
                                                        <select class="form-control" name="" id="" disabled>
                                                            <option>Sendiri</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Pendapatan Bulan (RM): </label>
                                                        <input type="text" class="form-control" name="" placeholder="Pendapatan Bulan" value="1200" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Kerakyatan: </label>
                                                        <select class="form-control" name="" id="" disabled>
                                                            <option>Warganegara</option>
                                                            <option>Penduduk Tetap</option>
                                                            <option>Bukan Warganegara</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Jumlah Pendapatan Bulanan (RM): </label>
                                                        <input type="text" class="form-control" name="" placeholder="Jumlah Pendapatan Bulanan" value="1200" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">No Kad Pengenalan: </label>
                                                        <input type="text" class="form-control" name="" placeholder="No Kad Pengenalan" value="850508095161" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Alamat Tempat Kerja: </label>
                                                        <textarea class="form-control" rows="5" name="" placeholder="Alamat Rumah" disabled>Sawah Padi Taman Peladang Jaya</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Telefon Pejabat: </label>
                                                        <input type="text" class="form-control" name="" placeholder="No Telefon Pejabat" value="0124470470" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Telefon Bimbit: </label>
                                                        <input type="text" class="form-control" name="" placeholder="No Telefon Bimbit" value="0124470470" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Telefon Rumah: </label>
                                                        <input type="text" class="form-control" name="" placeholder="No Telefon Rumah" value="0124470470" disabled>
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
@stop

@include('js.rt-sm27.j-lulus-mohon-masuk-tabika-admin')