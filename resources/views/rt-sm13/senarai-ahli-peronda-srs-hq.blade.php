@extends('layout.master')
@section('title', 'Senarai Ahli Peronda SRS')


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
                            <h3 class="card-title text-primary">Carian</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                    <div class="form-group">
                                        <label class="form-label">Senarai State :</label>
                                        <select class="form-control" name="apshq_state_id" id="apshq_state_id">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($state as $item)                                    
                                                <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <div class="form-group">
                                        <label class="form-label">Senarai Daerah :</label>
                                        <select class="form-control" name="apshq_daerah_id" id="apshq_daerah_id" disabled>
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($daerah as $item)                                    
                                                <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <div class="form-group">
                                        <label class="form-label">Senarai KRT :</label>
                                        <select class="form-control" name="apshq_krt_id" id="apshq_krt_id" disabled>
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($krt_profile as $item)                                    
                                                <option value="{{ $item->id }}">{{ $item->krt_nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Senarai Pendaftaran Ahli Peronda SRS</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_ahli_peronda_srs_table" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Bil</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Nama Negeri</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Nama Daerah</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Nama KRT</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Nama SRS</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Nama</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">No Kad Pengenalan</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Umur</font></label></th>                                            
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Alamat</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Status</font></label></th>
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
@stop

@include('js.rt-sm13.j-senarai-ahli-peronda-srs-hq')

