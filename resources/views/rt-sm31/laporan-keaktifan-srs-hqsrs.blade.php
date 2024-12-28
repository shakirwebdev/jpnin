@extends('layout.master')
@section('title', 'Laporan Keaktifan SRS')


@section('content')
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
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Tahun</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lksrs_year" name="lksrs_year">
                                            <option value=""  selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Laporan Keaktifan SRS</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_keaktifan_srs_table" style="width: 2200px">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50" rowspan="3"><label class="form-label"><font color="white">Bil</font></label></th>
                                                <th style="background-color: #113f50" rowspan="3"><label class="form-label"><font color="white">Negeri</font></label></th>
                                                <th style="background-color: #113f50" rowspan="3"><label class="form-label"><font color="white">Daerah</font></label></th>
                                                <th style="background-color: #113f50" rowspan="3"><label class="form-label"><font color="white">Nama KRT</font></label></th>
                                                <th style="background-color: #113f50" rowspan="3"><label class="form-label"><font color="white">Nama SRS</font></label></th>
                                                <th style="background-color: #113f50" colspan="12" class="text-center"><label class="form-label"><font color="white">Bilangan Rondaan Setahun</font></label></th>
                                                <th style="background-color: #113f50" rowspan="3" class="text-center"><label class="form-label"><font color="white">Bilangan<br>Peronda</font></label></th>
                                            </tr>
                                            <tr>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">JAN</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">FEB</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">MAC</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">APR</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">MEI</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">JUN</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">JUL</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">OGS</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">SEP</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">OKT</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">NOV</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">DIS</font></label></th>
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

@include('js.rt-sm31.j-laporan-keaktifan-srs-hqsrs')