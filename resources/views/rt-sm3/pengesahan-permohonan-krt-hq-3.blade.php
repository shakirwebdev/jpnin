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
                                            <p>5. Kawasan Pertanian Berdekatan / Ternakan Kawasan KRT</p>
                                            <hr class="mt-1">
                                            <div class="row clearfix">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="kawasan_pertanian_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Perkara</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Dalam Kawasan KRT</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Luar Kawasan KRT</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <br><br>
                                                        <label class="form-label">Peta kawasan yang dicadangkan : </label>
                                                        <a href="javascript:void(0)" class="mb-3">
                                                            <img src="../assets/images/gallery/1.jpg" alt="Photo by Nathan Guerrero" class="rounded">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <br><br>
                                                <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm3.pengesahan_permohonan_krt_hq_2')}}';">Kembali</button>&nbsp;
                                                <button type="submit" class="btn btn-primary" onclick="window.location.href = '{{route('rt-sm3.pengesahan_permohonan_krt_hq_4')}}';">Seterusnya</button>
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

@include('js.rt-sm3.j-semakan-permohonan-krt-ppd-3')