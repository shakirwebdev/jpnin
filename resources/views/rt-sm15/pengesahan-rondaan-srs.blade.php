@extends('layout.master')
@section('title', 'Pengesahan Rondaan SRS')


@section('content')
@include('modal.modal-sah-keahdiran-peronda')
@include('modal.modal-jana-sah-keahdiran-peronda')
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="Departments-list" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Carian</h3>
                        </div>
                         <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <label>Negeri</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="">
                                            <option value="">-- Sila Pilih --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <label>Daerah</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="">
                                            <option value="">-- Sila Pilih --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <label>Nama SRS</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="">
                                            <option value="">-- Sila Pilih --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <label>&nbsp;</label>
                                    <br>
                                     <form>
                                        <div class="input-group">
                                            <span class="input-group-btn ml-2"><button class="btn btn-icon" type="submit"><span class="fe fe-search"></span></button></span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Senarai Perancangan Rondaan SRS</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="senari_perancangan_rondaan" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Bil</th>
                                                <th>Negeri</th>
                                                <th>Daerah</th>
                                                <th>Nama SRS</th>
                                                <th>Tarikh SRS</th>
                                                <th>Tarikh Rekod</th>
                                                <th>Direkod Oleh</th>
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

@include('js.rt-sm15.j-pengesahan-rondaan-srs')