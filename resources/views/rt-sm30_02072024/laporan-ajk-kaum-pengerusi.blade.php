@extends('layout.master')
@section('title', 'Laporan Bilangan AJK Mengikut Kaum')


@section('content')
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="Departments-list" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Bilangan AJK Mengikut Kaum</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_ajk_kaum" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">Bil</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">Senarai Kaum</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">Jumlah</font></label></th>
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

@include('js.rt-sm30.j-laporan-ajk-kaum-pengerusi')