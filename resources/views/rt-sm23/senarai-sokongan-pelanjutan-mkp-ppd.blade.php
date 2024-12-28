@extends('layout.master')
@section('title', 'Senarai Status Kelayakan Pelanjutan MKP')


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
                            <h3 class="card-title text-primary">Senarai Status Kelayakan Pelanjutan MKP</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_status_kelayakan_lanjutan_mkp" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">Bil</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">Nama Pemohon</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">Kad Pengenalan</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">No Telefon</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">Tarikh Dilantik</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">Tarikh Tamat</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">Status Kelayakan</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">Status</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">Tindakan</font></label></th>
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

@include('js.rt-sm23.j-senarai-sokongan-pelanjutan-mkp-ppd')