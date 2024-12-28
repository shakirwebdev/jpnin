@extends('layout.master')
@section('title', 'Pemakluman Mula Operasi Rondaan')


@section('content')
@include('modal.modal-add-pemakluman-operasi-rondaan')
@include('modal.modal-view-pemakluman-operasi-rondaan')
    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                &nbsp;
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>&nbsp;</div>
                <div class="header-action">
                    <button type="button" class="btn btn-primary" onclick="load_add_pemakluman_operasi_rondaan();"><i class="fe fe-plus mr-2"></i>Pemakluman Mula Operasi Rondaan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="Departments-list" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Senarai Pemakluman Mula Operasi Rondaan</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_pemakluman_ops_rondaan" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50"><font color="white">Bil</font></th>
                                                <th style="background-color: #113f50"><font color="white">Nama KRT</font></th>
                                                <th style="background-color: #113f50"><font color="white">Nama SRS</font></th>
                                                <th style="background-color: #113f50"><font color="white">Tarikh Mula Rondaan</font></th>
                                                <th style="background-color: #113f50"><font color="white">Tarikh Surat Pemakluman</font></th>
                                                <th style="background-color: #113f50"><font color="white">Tarikh Hantar</font></th>
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

@include('js.rt-sm14.j-pemakluman-ops-rondaan-srs')
