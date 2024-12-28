@extends('layout.master')
@section('title', 'Laporan Perancangan Kekerapan Rondaan SRS')


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
                                        <label class="form-label">Senarai Daerah :</label>
                                        <select class="form-control" name="lprpn_daerah_id" id="lprpn_daerah_id">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($daerah as $item)                                    
                                                <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <div class="form-group">
                                        <label class="form-label">Senarai KRT :</label>
                                        <select class="form-control" name="lprpn_krt_id" id="lprpn_krt_id" disabled>
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
                                        <select class="form-control" name="lprpn_srs_id" id="lprpn_srs_id" disabled>
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
                            <h3 class="card-title text-primary">Senarai Perancangan Rondaan SRS</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_perancangan_rondaan" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50" rowspan="2"><font color="white">Bil</font></th>
                                                <th style="background-color: #113f50" rowspan="2"><font color="white">Daerah</font></th>
                                                <th style="background-color: #113f50" rowspan="2"><font color="white">Nama KRT</font></th>
                                                <th style="background-color: #113f50" rowspan="2"><font color="white">Nama SRS</font></th>
                                                <th style="background-color: #113f50" rowspan="2"><font color="white">Tahun</font></th>
                                                <th style="background-color: #113f50" rowspan="2"><font color="white">Bulan</font></th>
                                                <th style="background-color: #113f50" colspan="4" class="text-center"><font color="white">Minggu Perancangan Rondaan</font></th>
                                                <th style="background-color: #113f50" rowspan="2"><font color="white">Bilangan<br>Perancangan</font></th>
                                            </tr>
                                            <tr>
                                                <th style="background-color: #113f50" class="text-center"><font color="white">Minggu 1</font></th>
                                                <th style="background-color: #113f50" class="text-center"><font color="white">Minggu 2</font></th>
                                                <th style="background-color: #113f50" class="text-center"><font color="white">Minggu 3</font></th>
                                                <th style="background-color: #113f50" class="text-center"><font color="white">Minggu 4</font></th>
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

@include('js.rt-sm15.j-laporan-perancangan-rondaan-ppn')
