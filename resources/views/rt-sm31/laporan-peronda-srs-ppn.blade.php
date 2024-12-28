@extends('layout.master')
@section('title', 'Laporan Peronda SRS')


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
                                    <label class="form-label">Senarai Daerah</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lppn_daerah_id" name="lppn_daerah_id">
                                            <option value=""  selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($daerah as $item)                                    
                                                <option value="{{ $item->daerah_description }}">{{ $item->daerah_description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Senarai KRT</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lppn_krt_id" name="lppn_krt_id" disabled>
                                            <option value=""  selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Senarai SRS</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lppn_srs_id" name="lppn_srs_id" disabled>
                                            <option value=""  selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Senarai Peronda SRS</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_ahli_peronda_table" style="width: 2500px">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Bil</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Daerah</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Nama KRT</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Nama SRS</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Nama Peronda</label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">No Kad Peronda</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Kaum</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Jantina</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Umur</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Alamat</font></label></th>
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

@include('js.rt-sm31.j-laporan-peronda-srs-ppn')