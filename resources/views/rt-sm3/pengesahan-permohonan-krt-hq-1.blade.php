@extends('layout.master')
@section('parentPageTitle', 'HRMS')
@section('title', 'SEMAKAN PERMOHONAN PENUBUHAN KRT BAHARU')


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
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="user-list" role="tabpanel">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT PERMOHONAN KRT</b></h6>
                                                <br><br>
                                                <p><span style="font-size:12px">No Rujukan</span><br><b>RT0202012</b></p>
                                                <br>
                                                <p><span style="font-size:12px">Cadangan Nama KRT</span><br><b>KRT Taman Peladang Jaya</b></p>
                                                <br>
                                                <p><span style="font-size:12px">Cadangan Alamat</span><br><b>No 10 Lorong 5,<br>Taman Peladang Jaya,<br>02000 Kuala Perlis</b></p>
                                                <br>
                                                <p><span style="font-size:12px">Tarikh Permohonan</span><br><b>2020-11-02 22:45:48</b></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT PEMOHON</b></h6>
                                                <br><br>
                                                <div class="form-group">
                                                    <label class="form-label">Nama Pemohon: </label>
                                                    <input type="text" class="form-control" name="" placeholder="Nama Pemohon" value="Mohamad Shauki Bin Sahardi" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Kad Pengenalan: </label>
                                                    <input type="text" class="form-control" name="" placeholder="No Kad Pengenalan" value="930508-09-5161" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Alamat: </label>
                                                    <textarea class="form-control" id="" name="" rows="4" disabled="">
No, 10 Lorong 5,
Taman Peladang Jaya,
02000 Kuala Perlis, Perlis
                                                    </textarea>
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
                                            <h6><b>MAKLUMAT ASAS KAWASAN</b></h6>
                                            <br>
                                            <p>1. Latar Belakang Kawasan</p>
                                            <hr class="mt-1">
                                            <div class="row clearfix">
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Negeri : </label>
                                                        <select class="form-control" id="" name="" disabled="">
                                                            <option>PERLIS</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Parlimen : </label>
                                                        <select class="form-control" id="" name="" disabled="">
                                                            <option>PERLIS</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Pihak Berkuasa Tempatan (PBT) : </label>
                                                        <select class="form-control" id="" name="" disabled="">
                                                            <option>Majlis Perbandaran Kangar</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Daerah : </label>
                                                        <select class="form-control" id="" name="" disabled="">
                                                            <option>KANGAR</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Dun : </label>
                                                        <select class="form-control" id="" name="" disabled="">
                                                            <option>KUALA PERLIS</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Balai Polis : </label>
                                                        <select class="form-control" id="" name="" disabled="">
                                                            <option>Balai Polis Kuala Perlis</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Nama SRS : </label>
                                                        <input type="text" class="form-control" name="" disabled="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Ibu Pejabat Polis Daerah (IPD) : </label>
                                                        <select class="form-control" id="" name="" disabled="">
                                                            <option>Balai Polis Kuala Perlis</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Tabika Perpaduan dalam KRT : </label>
                                                        <input type="text" class="form-control" name="" disabled="" value="Tabika Perpaduan Taman Peladang Jaya">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Taska Perpaduan dalam KRT : </label>
                                                        <input type="text" class="form-control" name="" disabled="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Kawasan / Tempat : </label>
                                                        <input type="text" class="form-control" name="" value="Mukim Kuala Perlis" disabled="" >
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Saiz Keluasan <span class="text-red" style="font-size:12px">*dalam hektar</span> : </label>
                                                        <input type="text" class="form-control" name="" disabled="">
                                                       <span class="text" style="font-size:12px">1 Hektar - 2.47 Ekar</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Angaran Bilangan / Isi Rumah dan Pecahan Komposisi Penduduk : </label>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_kaum_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Kaum</font></label></th>
                                                                        <th width="25%"><label class="form-label"><font color="#113f50">Jumlah (Bil. Orang)</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Sosio-Ekonomi Penduduk / Pekerjaan (Peratus {%}) : </label>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="sesio_ekonomi_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Pekerjaan</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Sub Pekerjaan</font></label></th>
                                                                        <th width="25%"><label class="form-label"><font color="#113f50">Peratus (%)</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Jenis/Kategori Rumah : </label>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="jenis_rumah_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Jenis Rumah</font></label></th>
                                                                        <th width="25%"><label class="form-label"><font color="#113f50">Bilangan Pintu/Unit</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm3.pengesahan_permohonan_krt_hq')}}';">Kembali</button>&nbsp;
                                                <button type="submit" class="btn btn-primary" onclick="window.location.href = '{{route('rt-sm3.pengesahan_permohonan_krt_hq_2')}}';">Seterusnya</button>
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
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
@stop

@include('js.rt-sm3.j-semakan-permohonan-krt-ppd-1')