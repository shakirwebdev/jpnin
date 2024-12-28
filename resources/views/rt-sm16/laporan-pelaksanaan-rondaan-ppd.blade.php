@extends('layout.master')
@section('title', 'Laporan Pelaksanaan Rondaan SRS')


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
            <div class="tab-pane fade show active" id="Departments-list" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-primary">Carian</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <label class="form-label">Senarai KRT :</label>
                                    <select class="form-control" name="lprpd_krt_id" id="lprpd_krt_id">
                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        @foreach($krt_profile as $item)                                    
                                            <option value="{{ $item->id }}">{{ $item->krt_nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <label class="form-label">Senarai SRS :</label>
                                    <select class="form-control" name="lprpd_srs_id" id="lprpd_srs_id" disabled>
                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        @foreach($srs_profile as $item)                                    
                                            <option value="{{ $item->id }}">{{ $item->srs_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-primary">Senarai Pelaksanaan Rondaan SRS</h3>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_pelaksanaan_rondaan" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Bil</th>
                                            <th rowspan="2">Nama KRT</th>
                                            <th rowspan="2">Nama SRS</th>
                                            <th rowspan="2">Tahun</th>
                                            <th rowspan="2">Bulan</th>
                                            <th colspan="4" class="text-center">Minggu Pelaksanaan Rondaan</th>
                                            <th rowspan="2">Bilangan<br>Pelaksanaan</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">Minggu 1</th>
                                            <th class="text-center">Minggu 2</th>
                                            <th class="text-center">Minggu 3</th>
                                            <th class="text-center">Minggu 4</th>
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

@include('js.rt-sm16.j-laporan-pelaksanaan-rondaan-ppd')
