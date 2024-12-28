@extends('layout.master')
@section('title', 'Jana Surat Perancangan Aktiviti KRT')


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
                            <h3 class="card-title text-primary">Senarai Jana Surat Perancangan Aktiviti KRT</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="perancangan_aktiviti_table" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50"><font color="white">Bil</font></th>
                                                <th style="background-color: #113f50"><font color="white">Tahun Perancangan Aktiviti RT</font></th>
                                                <th style="background-color: #113f50"><font color="white">Tarikh Surat Perancangan Aktiviti</font></th>
                                                <th style="background-color: #113f50"><font color="white">Tarikh Rekod</font></th>
                                                <th style="background-color: #113f50"><font color="white">Direkod Oleh</font></th>
                                                <th width="11%" style="background-color: #113f50"><font color="white">Tindakan</font></th>
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
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@stop

@include('js.rt-sm6.j-surat-perancangan-aktiviti-ppn')
