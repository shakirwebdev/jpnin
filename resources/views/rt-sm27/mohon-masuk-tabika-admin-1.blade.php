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
                                                <select class="form-control" name="" id="" disabled>
                                                    <option>PERLIS</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Daerah / Bahagian: </label>
                                                <select class="form-control" name="" id="" disabled>
                                                    <option>PERLIS</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Nama Tabika Perpaduan: </label>
                                                <select class="form-control" name="" id="" disabled>
                                                    <option>-- Sila Pilih --</option>
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
                                            <div class="row clearfix">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <label class="form-label">Maklumat Ibu</label>
                                                    <br>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Nama: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="Nama">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Pekerjaan: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="Pekerjaan">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Sektor Pekerjaan: <span class="text-red">*</span></label>
                                                        <select class="form-control" name="" id="">
                                                            <option>-- Sila Pilih --</option>
                                                            <option>Swasta</option>
                                                            <option>Kerajaan</option>
                                                            <option>Sendiri</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Pendapatan Bulanan (RM): <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="Pendapatan Bulanan">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Kerakyatan: <span class="text-red">*</span></label>
                                                        <select class="form-control" name="" id="">
                                                            <option>-- Sila Pilih --</option>
                                                            <option>Warganegara</option>
                                                            <option>Penduduk Tetap</option>
                                                            <option>Bukan Warganegara</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Jumlah Pendapatan Bulanan (RM): <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="Jumlah Pendapatan Bulanan">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Jumlah Pendapatan Lain (RM): <span class="text-red">(sekiranya ada)</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="Jumlah Pendapatan Lain">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">No Kad Pengenalan: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="No Kad Pengenalan">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Alamat Tempat Kerja: <span class="text-red">*</span></label>
                                                        <textarea class="form-control" rows="5" name="" placeholder="Alamat Tempat Kerja"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Telefon Pejabat: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="No Telefon Pejabat">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Telefon Bimbit: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="No Telefon Bimbit">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Telefon Rumah: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="No Telefon Rumah">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Bilangan Anak: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="Bilangan Anak">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Hubungan Dengan Murid: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="Hubungan Dengan Murid">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Tabika Perpaduan Adalah Pilihan yang Kebarapa ? : <span class="text-red">*</span></label>
                                                        <select class="form-control" name="" id="">
                                                            <option>-- Sila Pilih --</option>
                                                            <option>Pertama</option>
                                                            <option>Kedua</option>
                                                            <option>Ketiga</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Bilangan Anak Bersekolah: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="Bilangan Anak Bersekolah">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Tabika Lain Yang Dipohon: <span class="text-red">(jika ada)</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="Nama Tabika Lain Yang Dipohon">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Pengesahan Ibu/Bapa/Penjaga: </label>
                                                        <div class="table-responsive">
                                                            <table class="table table-hover text-nowrap mb-0">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="width45">
                                                                            <label class="custom-control custom-checkbox mb-0">
                                                                                <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
                                                                                <span class="custom-control-label">&nbsp;</span>
                                                                            </label>
                                                                        </td>
                                                                        <td>
                                                                            <span>Saya Mengesahkan Segala Maklumat Yang Dinyatakan Adalah Benar</span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="width45">
                                                                            <label class="custom-control custom-checkbox mb-0">
                                                                                <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
                                                                                <span class="custom-control-label">&nbsp;</span>
                                                                            </label>
                                                                        </td>
                                                                        <td>
                                                                            <span>Saya Akan Patuh Kepada Semua Peraturan Yang Ditetapkan Oleh Jabatan</span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="width45">
                                                                            <label class="custom-control custom-checkbox mb-0">
                                                                                <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
                                                                                <span class="custom-control-label">&nbsp;</span>
                                                                            </label>
                                                                        </td>
                                                                        <td>
                                                                            <span>Saya Bersedia Menjadi Ahli Jawatankuasa Penyelaras Tabika Perpaduan, memberi kerjasama dan sokongan sepenuhnya
                                                                                dalam setiap aktiviti yang  <br> dilaksanakan di peringkat kelas dan Jabatan.
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <span><b>Bahagian C : Maklumat Muatnaik Salinan Dokumen</b></span>
                                        <hr>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="row clearfix">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="series-frame">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Nama Dokumen : </label>
                                                                <select class="form-control" name="" id="">
                                                                    <option>-- Sila Pilih --</option>
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
                                                                <input type="file" class="form-control" name="" placeholder="Dokumen">
                                                            </div>
                                                            <button type="button" class="btn btn-primary pull-right">Tambah</button>
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
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <br>
                                        <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                        <button type="button" class="btn btn-primary">Hantar Permohonan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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

@include('js.rt-sm27.j-mohon-masuk-tabika-admin-1')