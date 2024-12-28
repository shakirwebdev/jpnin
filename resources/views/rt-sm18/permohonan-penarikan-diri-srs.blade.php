@extends('layout.master')
@section('title', 'Permohonan Penarikan Diri SRS')


@section('content')
@include('modal.modal-add-penarikan-diri')
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
                    <button type="button" class="btn btn-primary" onclick="load_add_penarikan_diri();"><i class="fe fe-plus mr-2"></i>Tambah Maklumat Penarikan Diri</button>
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
                            <h3 class="card-title text-primary">Senarai Ahli Penarikan Diri Peronda SRS</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_penarikan_diri" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Bil</th>
                                                <th>Nama Peronda</th>
                                                <th>No KP</th>
                                                <th>No Kad Pengenalan SRS</th>
                                                <th>Alamat</th>
                                                <th>Tarikh Rekod</th>
                                                <th>Direkod Oleh</th>
                                                <th>Status</th>
                                                <th width="11%">Tindakan</th>
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

@include('js.rt-sm18.j-permohonan-penarikan-diri-srs')
