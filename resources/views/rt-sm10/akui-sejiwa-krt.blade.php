@extends('layout.master')
@section('title', 'Senarai Perakui Permohonan Penubuhan Sejiwa')


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
                                            <label class="form-label">Senarai Daerah</label>
                                            <select class="custom-select" id="ask_daerah_id" name="ask_daerah_id">
                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                @foreach($daerah as $item)                                    
                                                    <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <label class="form-label">Senarai Nama KRT</label>
                                            <select class="custom-select" id="ask_krt_id" name="ask_krt_id" disabled>
                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                @foreach($krt as $item)                                    
                                                    <option value="{{ $item->krt_nama }}">{{ $item->krt_nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title text-primary">Senarai Permohonan Penubuhan Sejiwa</h3>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_permohonan_sejiwa" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th>Bil</th>
                                                    <th>Daerah</th>
                                                    <th>Nama KRT</th>
                                                    <th>Nama Sejiwa</th>
                                                    <th>Tarikh Penubuhan</th>
                                                    <th>Pusat Operasi</th>
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

@include('js.rt-sm10.j-akui-sejiwa-krt')
