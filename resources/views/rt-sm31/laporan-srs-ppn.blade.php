@extends('layout.master')
@section('title', 'Laporan Senarai SRS')


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
                                    <label class="form-label">Senarai Daerah</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lsppn_daerah_id" name="lsppn_daerah_id">
                                            <option value="" selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($daerah as $item)                                    
                                                <option value="{{ $item->daerah_description }}">{{ $item->daerah_description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Senarai Parlimen</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lsppn_parlimen_id" name="lsppn_parlimen_id">
                                            <option value=""  selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($parlimen as $item)                                    
                                                <option value="{{ $item->parlimen_description }}">{{ $item->parlimen_description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Senarai Dun</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lsppn_dun_id" name="lsppn_dun_id" disabled>
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Senarai KRT</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lsppn_krt_id" name="lsppn_krt_id" disabled>
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Senarai SRS</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_srs_table" style="width: 2200px">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50"><font color="white">Bil</font></th>
                                                <th style="background-color: #113f50"><font color="white">Negeri</font></th>
                                                <th style="background-color: #113f50"><font color="white">Daerah</font></th>
                                                <th style="background-color: #113f50"><font color="white">Parlimen</font></th>
                                                <th style="background-color: #113f50"><font color="white">Dun</font></th>
                                                <th style="background-color: #113f50"><font color="white">Nama KRT</font></th>
                                                <th style="background-color: #113f50"><font color="white">Nama SRS</font></th>
                                                <th style="background-color: #113f50"><font color="white">No Pendaftartan SRS</font></th>
                                                <th style="background-color: #113f50"><font color="white">Tahun Ditubuhkan</font></th>
                                                <th style="background-color: #113f50"><font color="white">Bilangan Peronda</font></th>
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

@include('js.rt-sm31.j-laporan-srs-ppn')