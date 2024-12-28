@extends('layout.master')
@section('title', 'Senarai Keaktifan KRT')


@section('content')
@include('modal.modal-add-markah-keaktifan-krt')
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="row clearfix">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title text-primary">Senarai Keaktifan Kawasan Rukun Tetangga</h3>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_keaktifan_krt" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th>Bil</th>
                                                    <th>Nama KRT</th>
                                                    <th>No KRT</th>
                                                    <th>Bil AJK</th>
                                                    <th>Bil Mesyuarat</th>
                                                    <th>Bil Aktiviti</th>
                                                    <th>Bil Kewangan</th>
                                                    <th>Bil Cawangan</th>
                                                    <th>Bil SRS</th>
                                                    <th>Jumlah Markah</th>
                                                    <th>Status</th>
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

@include('js.rt-sm11.j-keaktifan-krt')
