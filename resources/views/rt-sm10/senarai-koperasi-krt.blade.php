@extends('layout.master')
@section('title', 'Senarai Koperasi')


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
                                <h3 class="card-title text-primary">Senarai Koperasi</h3>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_koperasi" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th style="background-color: #113f50"><font color="white">Bil</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Nama KRT</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Nama Koperasi</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Jumlah Ahli Lembaga</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Jumlah Ahli Koperasi</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Status Koperasi</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Status Permohonan</font></th>
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
        </div>
    </div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
@stop

@include('js.rt-sm10.j-senarai-koperasi-krt')
