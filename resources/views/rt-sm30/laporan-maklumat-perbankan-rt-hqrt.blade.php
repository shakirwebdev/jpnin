@extends('layout.master')
@section('title', 'Laporan Maklumat Perbankan RT')


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
                            <h3 class="card-title text-primary">Senarai Maklumat Perbankan RT'</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="laporan_binaan_tumpang_rt" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50" ><font color="white">Bil</font></th>
                                                <th style="background-color: #113f50" ><font color="white">Negeri</font></th>
                                                <th style="background-color: #113f50" ><font color="white">Daerah</font></th>
                                                <th style="background-color: #113f50" ><font color="white">Nama KRT</font></th>
                                                <th style="background-color: #113f50" ><font color="white">No Akaun Bank</font></th>
                                                <th style="background-color: #113f50" ><font color="white">Nama Bank</font></th>
                                                <th style="background-color: #113f50" ><font color="white">Baki Tunai</font></th>
                                                <th style="background-color: #113f50" ><font color="white">Baki Bank</font></th>
                                                <th style="background-color: #113f50" ><font color="white">Jumlah Baki</font></th>
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

@include('js.rt-sm30.j-laporan-maklumat-perbankan-rt-hqrt')