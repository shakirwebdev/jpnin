@extends('layout.master')
@section('title', 'Jana Laporan Perancangan Aktiviti Rukun Tertangga')


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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-primary">Carian</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <label class="form-label">Senarai Negeri</label>
                                <div class="form-group">
                                    <select class="custom-select" id="jlpah_state_id" name="jlpah_state_id">
                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        @foreach($state as $item)                                    
                                            <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <label class="form-label">Senarai Daerah</label>
                                <div class="form-group">
                                    <select class="custom-select" id="jlpah_daerah_id" name="jlpah_daerah_id" disabled>
                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        @foreach($daerah as $item)                                    
                                            <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <label class="form-label">Senarai Nama KRT</label>
                                <div class="form-group">
                                    <select class="custom-select" id="jlpah_krt_id" name="jlpah_krt_id" disabled>
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
                        <h3 class="card-title text-primary">Senarai Perancangan Aktiviti RT</h3>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_aktiviti" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th style="background-color: #113f50"><font color="white">Bil</font></th>
                                            <th style="background-color: #113f50"><font color="white">Negeri</font></th>
                                            <th style="background-color: #113f50"><font color="white">Daerah</font></th>
                                            <th style="background-color: #113f50"><font color="white">Nama KRT</font></th>
                                            <th style="background-color: #113f50"><font color="white">Nama Aktiviti</font></th>
                                            <th style="background-color: #113f50"><font color="white">Agenda Kerja</font></th>
                                            <th style="background-color: #113f50"><font color="white">Bidang</font></th>
                                            <th style="background-color: #113f50"><font color="white">Tarikh Rancang</font></th>
                                            <th style="background-color: #113f50"><font color="white">Tarikh Pelaksanaan</font></th>
                                            <th style="background-color: #113f50"><font color="white">Status</font></th>
                                            <th style="background-color: #113f50"><font color="white">Tindakan</font></th>
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
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
@stop

@include('js.rt-sm6.j-jana-laporan-perancangan-aktiviti-hq')
