@extends('layout.master')
@section('title', 'Laporan Maklumat Skuad Uniti')


@section('content')
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="Departments-list" role="tabpanel">
                <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Carian</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Senarai Negeri</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="" name="">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Senarai Daerah</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="" name="" >
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Senarai KRT</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="" name="" >
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Laporan Maklumat Skuad Uniti</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="bilangan_penduduk_mengikut_kaum" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50" rowspan="3"><label class="form-label"><font color="white">Bil</font></label></th>
                                                <th style="background-color: #113f50" rowspan="3"><label class="form-label"><font color="white">Negeri</font></label></th>
                                                <th style="background-color: #113f50" rowspan="3"><label class="form-label"><font color="white">Daerah</font></label></th>
                                                <th style="background-color: #113f50" rowspan="3"><label class="form-label"><font color="white">Skuad Uniti</font></label></th>
                                                <th style="background-color: #113f50" rowspan="3"><label class="form-label"><font color="white">Jumlah Anggota</font></label></th>
                                                <th style="background-color: #113f50" colspan="10" class="text-center"><label class="form-label"><font color="white">Kaum / Etnik</font></label></th>
                                                <th style="background-color: #113f50" colspan="5" class="text-center"><label class="form-label"><font color="white">Peringkat Umur</font></label></th>
                                            </tr>
                                            <tr>
                                                <th style="background-color: #113f50" class="text-center" colspan="2"><label class="form-label"><font color="white">MELAYU</font></label></th>
                                                <th style="background-color: #113f50" class="text-center" colspan="2"><label class="form-label"><font color="white">CINA</font></label></th>
                                                <th style="background-color: #113f50" class="text-center" colspan="2"><label class="form-label"><font color="white">INDIA</font></label></th>
                                                <th style="background-color: #113f50" class="text-center" colspan="2"><label class="form-label"><font color="white">BUMIPUTRA<br>SABAH</font></label></th>
                                                <th style="background-color: #113f50" class="text-center" colspan="2"><label class="form-label"><font color="white">BUMIPUTRA<br>SARAWAK</font></label></th>
                                                <th style="background-color: #113f50" class="text-center" rowspan="2"><label class="form-label"><font color="white">< 12</font></label></th>
                                                <th style="background-color: #113f50" class="text-center" rowspan="2"><label class="form-label"><font color="white">13 - 21</font></label></th>
                                                <th style="background-color: #113f50" class="text-center" rowspan="2"><label class="form-label"><font color="white">22 - 40</font></label></th>
                                                <th style="background-color: #113f50" class="text-center" rowspan="2"><label class="form-label"><font color="white">41 - 60</font></label></th>
                                                <th style="background-color: #113f50" class="text-center" rowspan="2"><label class="form-label"><font color="white">60 ></font></label></th>
                                            </tr>
                                            <tr>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">L</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">p</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">L</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">p</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">L</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">p</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">L</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">p</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">L</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">p</font></label></th>
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
    </div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
@stop

@include('js.rt-sm30.j-laporan-skuad-uniti-hqrt')