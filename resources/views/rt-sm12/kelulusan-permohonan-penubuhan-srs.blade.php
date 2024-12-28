@extends('layout.master')
@section('title', 'Kelulusan Permohonan Penubuhan SRS')

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
                <div class="row clearfix">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title text-primary">Carian</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <label class="form-label">Senarai Negeri :</label>
                                            <select class="form-control" name="kpps_negeri_id" id="kpps_negeri_id">
                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                @foreach($state as $item)                                    
                                                    <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <label class="form-label">Senarai Daerah :</label>
                                            <select class="form-control" name="kpps_daerah_id" id="kpps_daerah_id" disabled>
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
                                            <select class="form-control" name="kpps_krt_id" id="kpps_krt_id" disabled>
                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                @foreach($krt as $item)                                    
                                                    <option value="{{ $item->id }}">{{ $item->krt_nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title text-primary">Senarai Permohonan Penubuhan SRS</h3>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_permohonan_penubuhan_srs" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th>Bil</th>
                                                    <th>No SRS</th>
                                                    <th>Nama KRT</th>
                                                    <th>Nama SRS</th>
                                                    <th>Bilangan Peronda</th>
                                                    <th>Tarikh Permohonan</th>
                                                    <th>Status</th>
                                                    <th>Tindakan</th>
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
    </div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
@stop

@include('js.rt-sm12.j-kelulusan-permohonan-penubuhan-srs')
