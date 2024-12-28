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
                                            <h6><b>MAKLUMAT STATUS PENGESAHAN</b></h6>
                                            <br><br>
                                            <div class="form-group">
                                                <label class="form-label">Status: <span class="text-red">*</span></label>
                                                <select class="form-control" >
                                                    <option>-- Sila Pilih --</option>
                                                    <option>Disahkan</option>
                                                    <option>Perlu Dikemaskini</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Penerangan: <span class="text-red">*</span></label>
                                                <textarea class="form-control" rows="4" ></textarea>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group pull-right">
                                                    <button type="submit" class="btn btn-primary">Hantar Status Pengesahan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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
                                                        <input type="text" class="form-control" name="" placeholder="Nama" value="Asnah Binti Abu" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Pekerjaan:</label>
                                                        <input type="text" class="form-control" name="" placeholder="Nama" value="Suri Rumah" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Sektor Pekerjaan: </label>
                                                        <select class="form-control" name="" id="" disabled>
                                                            <option>Sendiri</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Pendapatan Bulan (RM): </label>
                                                        <input type="text" class="form-control" name="" placeholder="Pendapatan Bulan" value="0" disabled>
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
                                                        <input type="text" class="form-control" name="" placeholder="Jumlah Pendapatan Bulanan" value="0" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Jumlah Pendapatan Lain (RM): <span class="text-red">(sekiranya ada)</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="Jumlah Pendapatan Lain" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">No Kad Pengenalan: </label>
                                                        <input type="text" class="form-control" name="" placeholder="No Kad Pengenalan" value="840507815161" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Alamat Tempat Kerja: </label>
                                                        <textarea class="form-control" rows="5" name="" placeholder="Alamat Rumah" disabled>No, 10 Lorong 5 Taman Peladang Jaya 02000 Kuala Perlis, Perlis</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Telefon Pejabat: </label>
                                                        <input type="text" class="form-control" name="" placeholder="No Telefon Pejabat"  value="0124470470" disabled>
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
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Bilangan Anak: </label>
                                                        <input type="text" class="form-control" name="" placeholder="Bilangan Anak" value="5" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Hubungan Dengan Murid: </label>
                                                        <input type="text" class="form-control" name="" placeholder="Hubungan Dengan Murid" value="Ibu" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Tabika Perpaduan Adalah Pilihan yang Kebarapa?: </label>
                                                        <div class="table-responsive">
                                                            <table class="table table-hover text-nowrap mb-0">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="width45">
                                                                            <label class="custom-control custom-checkbox mb-0">
                                                                                <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked disabled>
                                                                                <span class="custom-control-label">&nbsp;</span>
                                                                            </label>
                                                                        </td>
                                                                        <td>
                                                                            <span>Pertama</span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="width45">
                                                                            <label class="custom-control custom-checkbox mb-0">
                                                                                <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" disabled>
                                                                                <span class="custom-control-label">&nbsp;</span>
                                                                            </label>
                                                                        </td>
                                                                        <td>
                                                                            <span>Kedua</span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="width45">
                                                                            <label class="custom-control custom-checkbox mb-0">
                                                                                <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" disabled>
                                                                                <span class="custom-control-label">&nbsp;</span>
                                                                            </label>
                                                                        </td>
                                                                        <td>
                                                                            <span>Ketiga</span>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Bilangan Anak Bersekolah: </label>
                                                        <input type="text" class="form-control" name="" placeholder="Bilangan Anak Bersekolah" value="5" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Tabika Lain Yang Dipohon: <span class="text-red">(jika ada)</span></label>
                                                        <input type="text" class="form-control" name="" placeholder="Nama Tabika Lain Yang Dipohon" value="Tiada" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Pengesahan Ibu/Bapa/Penjaga: </label>
                                                        <div class="table-responsive">
                                                            <table class="table table-hover text-nowrap mb-0">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="width45">
                                                                            <label class="custom-control custom-checkbox mb-0">
                                                                                <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked disabled>
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
                                                                                <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked disabled>
                                                                                <span class="custom-control-label">&nbsp;</span>
                                                                            </label>
                                                                        </td>
                                                                        <td>
                                                                            <span>Saya Akan Patuh Kepada Semua Peraturan Yang Ditetapkan Oleh<br> Jabatan</span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="width45">
                                                                            <label class="custom-control custom-checkbox mb-0">
                                                                                <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked disabled>
                                                                                <span class="custom-control-label">&nbsp;</span>
                                                                            </label>
                                                                        </td>
                                                                        <td>
                                                                            <span>Saya Bersedia Menjadi Ahli Jawatankuasa Penyelaras Tabika<br> Perpaduan, memberi kerjasama dan sokongan<br> sepenuhnya
                                                                                dalam setiap aktiviti yang dilaksanakan di peringkat<br> kelas dan Jabatan.
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
                                                                <label class="form-label">Nama Dokumen: </label>
                                                                <input type="text" class="form-control" name="" placeholder="Nama Dokumen">
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
                                        <button type="button" class="btn btn-secondary" disabled>Seterusnya&nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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

@include('js.rt-sm27.j-sah-mohon-masuk-tabika-admin-1')