@extends('layout.master')
@section('title', 'Senarai Skuad Uniti')


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
                                            <label class="form-label">Senarai KRT: </label>
                                            <select class="form-control" name="ssukpd_krt_id" id="ssukpd_krt_id">
                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                @foreach($krt as $item)                                    
                                                    <option value="{{ $item->id }}">{{ $item->krt_nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <label class="form-label">Senarai Skuad Uniti: </label>
                                            <select class="form-control" name="ssuk_skuad_uniti_id" id="ssuk_skuad_uniti_id" disabled>
                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                @foreach($skuad_uniti as $item)                                    
                                                    <option value="{{ $item->skuad_nama }}">{{ $item->skuad_nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title text-primary">Senarai Skuad Uniti</h3>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_skuad_uniti" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th>Bil</th>
                                                    <th>Daerah</th>
                                                    <th>Nama KRT</th>
                                                    <th>Nama Skuad Uniti</th>
                                                    <th>Tarikh Penubuhan</th>
                                                    <th>Skop Perkhidmatan Skuad Uniti</th>
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

@include('js.rt-sm10.j-senarai-skuad-uniti-krt-ppd')
