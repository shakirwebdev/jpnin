@extends('layout.master')
@section('title', 'Permohonan Pelaporan i-Ramal')


@section('content')
@include('modal.modal-add-ts-imuhibbah-ppd')
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
                            <h3 class="card-title text-primary">Senarai Permohonan Pelaporan i-Ramal</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_permohonan_muhibbah" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Bil</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Tajuk</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Tarikh Laporan</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Tarikh Jangkaan Berlaku</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Tarikh Arahan</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Arahan Tindakan Daripada</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Tindakan</font></label></th>
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

@include('js.rt-sm22.j-senarai-ts-imuhibbah-ppd')