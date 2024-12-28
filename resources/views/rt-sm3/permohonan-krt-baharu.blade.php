@extends('layout.master')
@section('title', 'Permohonan Penubuhan KRT Baharu')


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
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="user-list" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div id="wizard" class="swMain">
                                        <ul>
                                            <li>
                                                <a href="#step-1">
                                                    <span class="stepNumber">1</span>
                                                    <span class="stepDesc">Maklumat Permohonan &nbsp;&nbsp;<span class="icon-alert" id="alert_1" style="display: none">!</span><br/>
                                                        <small>Maklumat Pemohon & Kawasan Krt</small>
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#step-2">
                                                    <span class="stepNumber">2</span>
                                                    <span class="stepDesc">Maklumat Asas Kawasan &nbsp;&nbsp;<span class="icon-alert" id="alert_2" style="display: none">!</span><br/>
                                                        <small>Latar Belakang Kawasan</small>
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#step-3">
                                                    <span class="stepNumber">3</span>
                                                    <span class="stepDesc">Maklumat Asas Kawasan &nbsp;&nbsp;<span class="icon-alert" id="alert_2" style="display: none">!</span><br/>
                                                        <small>Jenis Pertubuhan / Persatuan</small>
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#step-4">
                                                    <span class="stepNumber">4</span>
                                                    <span class="stepDesc">Maklumat Asas Kawasan &nbsp;&nbsp;<span class="icon-alert" id="alert_2" style="display: none">!</span><br/>
                                                        <small>Kemudahan Awam & Isu</small>
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#step-5">
                                                    <span class="stepNumber">5</span>
                                                    <span class="stepDesc">Maklumat Asas Kawasan &nbsp;&nbsp;<span class="icon-alert" id="alert_2" style="display: none">!</span><br/>
                                                        <small>Kawasan Pertanian & Peta Kawasan KRT</small>
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#step-6">
                                                    <span class="stepNumber">6</span>
                                                    <span class="stepDesc">JawatanKuasa Penaja RT &nbsp;&nbsp;<span class="icon-alert" id="alert_2" style="display: none">!</span><br/>
                                                        <small>Senarai JawatanKuasa Penaja Rukun Tetangga</small>
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#step-7">
                                                    <span class="stepNumber">7</span>
                                                    <span class="stepDesc">Menit Perjumpaan&nbsp;&nbsp;<span class="icon-alert" id="alert_2" style="display: none">!</span><br/>
                                                        <small>Menit Perjumpaan Bersama dengan Penduduk</small>
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                        <div id="step-1">
                                            <h2 class="StepTitle"><b>Maklumat Pemohon</b></h2>
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Nama Pemohon: <span class="text-red">*</span></label>
                                                                    <input type="text" class="form-control" name="" placeholder="Nama Pemohon">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">No Kad Pengenalan: <span class="text-red">*</span></label>
                                                                    <input type="text" class="form-control" name="" placeholder="No Kad Pengenalan">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">No Telefon: <span class="text-red">*</span></label>
                                                                    <input type="text" class="form-control" name="" placeholder="No Telefon">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Alamat Pemohon: <span class="text-red">*</span></label>
                                                                    <textarea class="form-control" id="" name="" rows="4"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h2 class="StepTitle"><b>Maklumat Permohonan Kawasan Rukun Tertangga</b></h2>
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Negeri: <span class="text-red">*</span></label>
                                                                    <select class="form-control select2">
                                                                        <option>-- Sila Pilih --</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Daerah: <span class="text-red">*</span></label>
                                                                    <select class="form-control select2">
                                                                        <option>-- Sila Pilih --</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Cadangan Nama Kawasan Rukun Tertangga (KRT): <span class="text-red">*</span></label>
                                                                    <input type="text" class="form-control" name="" placeholder="Nama Pemohon">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Cadangan Alamat Kawasan Rukun Tertangga (KRT): <span class="text-red">*</span></label>
                                                                    <textarea class="form-control" rows="4" id="" name=""></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Catatan: </label>
                                                                    <textarea class="form-control" rows="4" id="" name=""></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="step-2">
                                            <h2 class="StepTitle"><b>Maklumat Asas Kawasan : Latar Belakang Kawasan</b></h2>
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Cadangan Nama Kawasan Rukun Tertangga (KRT): <span class="text-red">*</span></label>
                                                                    <input type="text" class="form-control" name="" placeholder="Nama Kawasan Rukun Tertangga (KRT)" disabled="">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Negeri: <span class="text-red">*</span></label>
                                                                    <select class="form-control select2" disabled="">
                                                                        <option>-- Sila Pilih --</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Daerah: <span class="text-red">*</span></label>
                                                                    <select class="form-control select2" disabled="">
                                                                        <option>-- Sila Pilih --</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Perlimen: <span class="text-red">*</span></label>
                                                                    <select class="form-control select2">
                                                                        <option>-- Sila Pilih --</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Dun: <span class="text-red">*</span></label>
                                                                    <select class="form-control select2">
                                                                        <option>-- Sila Pilih --</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Pihak Berkuasa Tempatan: <span class="text-red">*</span></label>
                                                                    <input type="text" class="form-control" name="" placeholder="Nama Kawasan Rukun Tertangga (KRT)">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Balai Polis: <span class="text-red">*</span></label>
                                                                    <input type="text" class="form-control" name="" placeholder="Balai Polis">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Ibu Pejabat Polis Daerah (IPD): <span class="text-red">*</span></label>
                                                                    <input type="text" class="form-control" name="" placeholder="Ibu Pejabat Polis Daerah (IPD)">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Nama SRS <span class="text-red">(sekiranya ada)</span> :</label>
                                                                    <input type="text" class="form-control" name="" placeholder="Nama SRS">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Nama Tabika Perpaduan dalam KRT <span class="text-red">(sekiranya ada)</span> :</label>
                                                                    <input type="text" class="form-control" name="" placeholder="Nama Tabika Perpaduan dalam KRT">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Nama Taska Perpaduan dalam KRT <span class="text-red">(sekiranya ada)</span> :</label>
                                                                    <input type="text" class="form-control" name="" placeholder="Nama Taska Perpaduan dalam KRT">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Anggaran Bilangan / Isi Rumah dan Pecahan Komposisi Penduduk : <span class="text-red">*</span></label>
                                                                </div>
                                                                <div class="series-frame">
                                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Kaum: </label>
                                                                            <select class="form-control">
                                                                                <option>-- Sila Pilih --</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="form-label">Jumlah (Bil. Orang): </label>
                                                                            <input type="text" class="form-control" name="" placeholder="Kaum">
                                                                        </div>
                                                                        <button type="submit" class="btn btn-primary pull-right"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                                    </div>
                                                                </div>
                                                                <br/><br/>
                                                                <div class="table-responsive">
                                                                    <table class="table thead-dark table-bordered table-striped" id="senarai_kaum_table" style="width: 100%" border="1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                                <th><label class="form-label"><font color="#113f50">Kaum</font></label></th>
                                                                                <th width="25%"><label class="form-label"><font color="#113f50">Jumlah (Bil. Orang)</font></label></th>
                                                                                <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Sosio-Ekonomi Penduduk / Pekerjaan [Peratus {%}] : <span class="text-red">*</span></label>
                                                                    <p class="form-label" style="font-size:12px"><font style="color: #ff7f81">Sila masukan nilai <b>0</b> sekiranya KAUM tersebut tiada</font></p>
                                                                </div>
                                                                <div class="series-frame">
                                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Pekerjaan: </label>
                                                                            <select class="form-control">
                                                                                <option>-- Sila Pilih --</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="form-label">Peratus (%): </label>
                                                                            <input type="text" class="form-control" name="" placeholder="Kaum">
                                                                        </div>
                                                                        <button type="submit" class="btn btn-primary pull-right"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                                    </div>
                                                                </div>
                                                                <br/><br/>
                                                                <div class="table-responsive">
                                                                    <table class="table thead-dark table-bordered table-striped" id="sosio_ekomomi_table" style="width: 100%" border="1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                                <th><label class="form-label"><font color="#113f50">Pekerjaan</font></label></th>
                                                                                <th width="25%"><label class="form-label"><font color="#113f50">Sub Pekerjaan</font></label></th>
                                                                                <th width="25%"><label class="form-label"><font color="#113f50">Peratus (%)</font></label></th>
                                                                                <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Jenis/Kategori Rumah : Nyatakan bil. (pintu/unit) mengikut kategori rumah<span class="text-red">*</span></label>
                                                                </div>
                                                                <div class="series-frame">
                                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Jenis Rumah: </label>
                                                                            <select class="form-control">
                                                                                <option>-- Sila Pilih --</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="form-label">Bilangan Pintu/Unit : </label>
                                                                            <input type="text" class="form-control" name="" placeholder="Kaum">
                                                                        </div>
                                                                        <button type="submit" class="btn btn-primary pull-right"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                                    </div>
                                                                </div>
                                                                <br/><br/>
                                                                <div class="table-responsive">
                                                                    <table class="table thead-dark table-bordered table-striped" id="jenis_rumah_table" style="width: 100%" border="1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                                <th><label class="form-label"><font color="#113f50">Jenis Rumah</font></label></th>
                                                                                <th width="25%"><label class="form-label"><font color="#113f50">Bilangan Pintu/Unit</font></label></th>
                                                                                <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="step-3">
                                            <h2 class="StepTitle"><b>Maklumat Asas Kawasan : Jenis Pertubuhan / Persatuan Yang Terdapat Di Kawasan Ini</b></h2>
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Jenis Pertubuhan: <span class="text-red">*</span></label>
                                                                </div>
                                                                <div class="table-responsive">
                                                                    <table class="table thead-dark table-bordered table-striped" id="jenis_pertubuhan_table" style="width: 100%" border="1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                                <th><label class="form-label"><font color="#113f50">Pertubuhan</font></label></th>
                                                                                <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                                <br>
                                                                <div class="form-group">
                                                                    <label class="form-label">Parti Politik: <span class="text-red">*</span></label>
                                                                </div>
                                                                <div class="series-frame">
                                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Parti Politik: </label>
                                                                            <select class="form-control">
                                                                                <option>-- Sila Pilih --</option>
                                                                            </select>
                                                                        </div>
                                                                        <button type="submit" class="btn btn-primary pull-right"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                                    </div>
                                                                </div>
                                                                <br/><br/>
                                                                <div class="table-responsive">
                                                                    <table class="table thead-dark table-bordered table-striped" id="parti_politik_table" style="width: 100%" border="1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th width="6%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                                <th><label class="form-label"><font color="#113f50">Parti Politik</font></label></th>
                                                                                <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="step-4">
                                            <h2 class="StepTitle"><b>Maklumat Asas Kawasan : Kemudahan Awam Yang Terlibat Di Kawasan ini</b></h2>
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="series-frame">
                                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Perkara: </label>
                                                                            <select class="form-control">
                                                                                <option>-- Sila Pilih --</option>
                                                                            </select>
                                                                            <p class="form-label" style="font-size:12px"><font style="color: #ff7f81">(Sila nyatakan sekiranya pemilihan dropdown adalah "Lain-Lain" di ruangan berikut)</font></p>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="form-label">Jumlah: <span class="text-red">*</span></label>
                                                                            <input type="text" class="form-control" name="" id="">
                                                                        </div>
                                                                        <button type="submit" class="btn btn-primary pull-right"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                                    </div>
                                                                </div>
                                                                <br/><br/>
                                                                <div class="table-responsive">
                                                                    <table class="table thead-dark table-bordered table-striped" id="kemudahan_awam_table" style="width: 100%" border="1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th width="6%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                                <th><label class="form-label"><font color="#113f50">Perkara</font></label></th>
                                                                                <th><label class="form-label"><font color="#113f50">Jumlah</font></label></th>
                                                                                <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h2 class="StepTitle"><b>Maklumat Asas Kawasan : Isu-isu Yang Terdapat Di Kawasan Ini</b></h2>
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Kes Jenayah: <span class="text-red">*</span></label>
                                                                </div>
                                                                <div class="table-responsive">
                                                                    <table class="table thead-dark table-bordered table-striped" id="kes_jenayah_table" style="width: 100%" border="1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                                <th><label class="form-label"><font color="#113f50">Kes Jenayah</font></label></th>
                                                                                <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                                <br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h2 class="StepTitle"><b>Maklumat Asas Kawasan : Masalah Sosial</b></h2>
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Masalah Sosial: <span class="text-red">*</span></label>
                                                                </div>
                                                                <div class="table-responsive">
                                                                    <table class="table thead-dark table-bordered table-striped" id="masalah_sosial_table" style="width: 100%" border="1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                                <th><label class="form-label"><font color="#113f50">Masalah Sosial</font></label></th>
                                                                                <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                                <br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="step-5">
                                            <h2 class="StepTitle"><b>Maklumat Asas Kawasan : Kawasan Pertanian Berdekatan / Ternakan Kawasan KRT</b></h2>
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="series-frame">
                                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Perkara: </label>
                                                                            <select class="form-control">
                                                                                <option>-- Sila Pilih --</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="form-label">Dalam Kawasan KRT: </label>
                                                                            <textarea class="form-control" id="" name="" rows="4"></textarea>
                                                                            <p class="form-label" style="font-size:12px"><font style="color: #ff7f81">(Nyatakan anggaran hektar)</font></p>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="form-label">Luar Kawasan KRT: </label>
                                                                            <textarea class="form-control" id="" name="" rows="4"></textarea>
                                                                            <p class="form-label" style="font-size:12px"><font style="color: #ff7f81">(Dalam lingkungan 5km dari luar sempadan kawasan RT. Nyatakan anggaran hektar)</font></p>
                                                                        </div>
                                                                        <button type="submit" class="btn btn-primary pull-right"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                                    </div>
                                                                </div>
                                                                <br/><br/>
                                                                <div class="table-responsive">
                                                                    <table class="table thead-dark table-bordered table-striped" id="kawasan_pertanian_table" style="width: 100%" border="1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th width="6%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                                <th><label class="form-label"><font color="#113f50">Perkara</font></label></th>
                                                                                <th><label class="form-label"><font color="#113f50">Dalam Kawasan KRT</font></label></th>
                                                                                <th><label class="form-label"><font color="#113f50">Luar Kawasan KRT</font></label></th>
                                                                                <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h2 class="StepTitle"><b>Maklumat Asas Kawasan : Peta Kawasan Yang Dicadangkan</b></h2>
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <input type="file" class="dropify">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="step-6">
                                            <h2 class="StepTitle"><b>Senarai Jawatankuasa Rukun Tetangga</b></h2>
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="series-frame">
                                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Nama: </label>
                                                                            <input type="text" class="form-control" name="" placeholder="Nama" >
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="form-label">No Kad Pengenalan: </label>
                                                                            <input type="text" class="form-control" name="" placeholder="No Kad Pengenalan" >
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <b>Tarikh Lahir</b>
                                                                            <div class="input-group mb-3">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                                </div>
                                                                                <input type="text" name="" class="form-control" value="" placeholder="Tarikh Lahir">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="form-label">Jantina: </label>
                                                                            <select class="form-control" id="" name="">
                                                                                <option>-- Sila Pilih --</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="form-label">Kaum: </label>
                                                                            <select class="form-control" id="" name="">
                                                                                <option>-- Sila Pilih --</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="form-label">Pekerjaan: </label>
                                                                            <input type="text" class="form-control" name="" placeholder="Pekerjaan">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="form-label">Alamat Rumah: </label>
                                                                            <textarea class="form-control" id="" name="" rows="4"></textarea>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="form-label">No Telefon Rumah: </label>
                                                                            <input type="text" class="form-control" name="" placeholder="No Telefon Rumah">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="form-label">Alamat Pejabat: </label>
                                                                            <textarea class="form-control" id="" name="" rows="4"></textarea>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="form-label">No Telefon Pejabat: </label>
                                                                            <input type="text" class="form-control" name="" placeholder="No Telefon Pejabat">
                                                                        </div>
                                                                        <button type="submit" class="btn btn-primary pull-right"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                                    </div>
                                                                </div>
                                                                <br/><br/>
                                                                <div class="table-responsive">
                                                                    <table class="table thead-dark table-bordered table-striped" id="ahli_jawatankuasa_table" style="width: 100%" border="1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th width="6%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                                <th><label class="form-label"><font color="#113f50">Nama</font></label></th>
                                                                                <th><label class="form-label"><font color="#113f50">Alamat</font></label></th>
                                                                                <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="step-7">
                                            <h2 class="StepTitle"><b>Minit Perjumpaan : Minit Perjumpaan Dengan Penduduk</b></h2>
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="form-group">
                                                                    <b>Tarikh: <span class="text-red">*</span></b>
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                        </div>
                                                                        <input type="text" name="" class="form-control" value="" placeholder="Tarikh">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="form-group">
                                                                    <b>Masa: <span class="text-red">*</span></b>
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fa fa-clock-o"></i></span>
                                                                        </div>
                                                                        <input type="text" name="" class="form-control" value="" placeholder="Masa">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Tempat: <span class="text-red">*</span></label>
                                                                    <input type="text" class="form-control" name="" placeholder="Tempat">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Senarai Kehadiran: <span class="text-red">*</span></label>
                                                                </div>
                                                                <div class="series-frame">
                                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Nama: </label>
                                                                            <input type="text" class="form-control" name="" placeholder="Nama" >
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="form-label">Alamat: </label>
                                                                            <textarea class="form-control" id="" name="" rows="4"></textarea>
                                                                        </div>
                                                                        <button type="submit" class="btn btn-primary pull-right"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                                    </div>
                                                                </div>
                                                                <br/><br/>
                                                                <div class="table-responsive">
                                                                    <table class="table thead-dark table-bordered table-striped" id="nama_kehadiran_table" style="width: 100%" border="1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th width="6%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                                <th><label class="form-label"><font color="#113f50">Nama</font></label></th>
                                                                                <th><label class="form-label"><font color="#113f50">Alamat</font></label></th>
                                                                                <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                                <br>
                                                                <div class="form-group">
                                                                    <label class="form-label">Minit Perjumpaan: </label>
                                                                </div>
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label">1. Ucapan Pengurusi Majlis:</label>
                                                                        <textarea id="summernote_1" name="summernote_1" class="form-control"></textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">2. Ucapan Pemimpin Masyarakat <span class="text-red">(jika ada)</span>:</label>
                                                                        <textarea id="summernote_2" name="summernote_2" class="form-control"></textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">3. Penerangan dan Cadangan Persempadanan Kawasan Rukun Tetangga (Oleh PPD) :</label>
                                                                        <div class="table-responsive">
                                                                            <table class="table thead-dark table-bordered table-striped" id="cadangan_persempadanan_table" style="width: 100%" border="1">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                                        <th><label class="form-label"><font color="#113f50">Penerangan Dan Cadangan</font></label></th>
                                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                                    </tr>
                                                                                </thead>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">4. Sesi Soal Jawab <span class="text-red">(jika ada)</span>:</label>
                                                                        <div class="series-frame">
                                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                                <div class="form-group">
                                                                                    <label class="form-label">Soalan: </label>
                                                                                    <input type="text" class="form-control" name="" placeholder="Soalan" >
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="form-label">Jawapan: </label>
                                                                                    <input type="text" class="form-control" name="" placeholder="Soalan" >
                                                                                </div>
                                                                                <button type="submit" class="btn btn-primary pull-right"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                                            </div>
                                                                        </div>
                                                                        <br/><br/>
                                                                        <div class="table-responsive">
                                                                            <table class="table thead-dark table-bordered table-striped" id="soal_jawab_table" style="width: 100%" border="1">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th width="6%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                                        <th><label class="form-label"><font color="#113f50">Soalan</font></label></th>
                                                                                        <th><label class="form-label"><font color="#113f50">Jawapan</font></label></th>
                                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                                    </tr>
                                                                                </thead>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div class="form-group">
                                                                        <label class="form-label">5. Pelantikan Ahli Jawatankuasa Penaja :</label>
                                                                    </div>
                                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Pengurusi: </label>
                                                                            <input type="text" class="form-control" name="" placeholder="Pengurusi" >
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="form-label">Timbalan Pengurusi: </label>
                                                                            <input type="text" class="form-control" name="" placeholder="Timbalan Pengurusi" >
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="form-label">Setiausaha: </label>
                                                                            <input type="text" class="form-control" name="" placeholder="Setiausaha" >
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="form-label">Penolong Setiausaha: </label>
                                                                            <input type="text" class="form-control" name="" placeholder="Penolong Setiausaha" >
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="form-label">Bendahari: </label>
                                                                            <input type="text" class="form-control" name="" placeholder="Bendahari" >
                                                                        </div>
                                                                        <div class="series-frame">
                                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                                <div class="form-group">
                                                                                    <label class="form-label">Ahli Jawatankuasa: </label>
                                                                                    <input type="text" class="form-control" name="" placeholder="Ahli Jawatankuasa" >
                                                                                </div>
                                                                                <button type="submit" class="btn btn-primary pull-right"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                                            </div>
                                                                        </div>
                                                                        <br/><br/>
                                                                        <div class="table-responsive">
                                                                            <table class="table thead-dark table-bordered table-striped" id="ahli_jawatankuasa_krt_table" style="width: 100%" border="1">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th width="6%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                                        <th><label class="form-label"><font color="#113f50">Ahli Jawatankuasa</font></label></th>
                                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                                    </tr>
                                                                                </thead>
                                                                            </table>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="form-label">6. Hal-hal Lain :</label>
                                                                            <textarea id="summernote_3" name="summernote_3" class="form-control"></textarea>
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
                                </div>
                            </div>
                                
                            <!-- <div class="col-12">
                            <br/><br/><br/>
                                <button type="button" class="btn btn-secondary">Simpan</button>&nbsp;
                                <button type="submit" class="btn btn-primary">Hantar Minit Mesyuarat</button>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop



@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<!-- <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"> -->

<link rel="stylesheet" href="../assets/plugins/datatable/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/plugins/datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/plugins/datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/plugins/dropify/css/dropify.min.css">

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">


@stop

@include('js.rt-sm3.j-permohonan-krt-baharu')
