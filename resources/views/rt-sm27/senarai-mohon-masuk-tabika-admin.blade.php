@extends('layout.master')
@section('title', 'Permohonan Kemasukan Tabika Perpaduan')


@section('content')
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-primary">Carian</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <label class="form-label">Senarai Negeri</label>
                                <div class="form-group">
                                    <select class="custom-select" id="" name="">
                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <label class="form-label">Senarai Daerah</label>
                                <div class="form-group">
                                    <select class="custom-select" id="" name="" >
                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="card">
                    <div class="card-header">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <h3 class="card-title text-primary">
                                Senarai Permohonan Kemasukan Tabika Perpaduan
                                <button type="button" class="btn btn-primary pull-right" onclick="window.location.href = '{{route('rt-sm27.mohon_masuk_tabika_admin')}}';"><i class="fe fe-plus mr-2"></i>Permohonan</button>
                            </h3>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-vcenter table-hover mb-0" id="list_mohon_masuk_tabika" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th style="background-color: #113f50" ><font color="white">Bil</font></th>
                                            <th style="background-color: #113f50" ><font color="white">No Permohonan</font></th>
                                            <th style="background-color: #113f50" ><font color="white">Negeri</font></th>
                                            <th style="background-color: #113f50" ><font color="white">Daerah</font></th>
                                            <th style="background-color: #113f50" ><font color="white">Nama</font></th>
                                            <th style="background-color: #113f50" ><font color="white">No Mykid</font></th>
                                            <th style="background-color: #113f50" ><font color="white">Jantina</font></th>
                                            <th style="background-color: #113f50" ><font color="white">Alamat</font></th>
                                            <th style="background-color: #113f50" ><font color="white">Status</font></th>
                                            <th style="background-color: #113f50" ><font color="white">Tindakan</font></th>
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

@include('js.rt-sm27.j-senarai-mohon-masuk-tabika-admin')