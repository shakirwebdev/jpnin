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
                        <h3 class="card-title text-primary">Senarai Perancangan Aktiviti RT</h3>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_aktiviti" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th style="background-color: #113f50"><font color="white">Bil</font></th>
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

@include('js.rt-sm6.j-jana-laporan-perancangan-aktiviti-krt')
