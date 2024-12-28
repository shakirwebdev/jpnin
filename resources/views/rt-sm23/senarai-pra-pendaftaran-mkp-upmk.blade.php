@extends('layout.master')
@section('title', 'Pra Pendaftaran MKP')


@section('content')
@include('modal.modal-edit-pendaftaran-mkp')
@include('modal.modal-add-pendaftaran-mkp')
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
                    <button type="button" class="btn btn-primary" onclick="load_add_pendaftran_mkp();"><i class="fe fe-plus mr-2"></i>Pra-Pendaftaran MKP</button>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-primary">Carian</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <label class="form-label">Senarai Negeri</label>
                                <div class="form-group">
                                    <select class="custom-select" id="sppmu_state_id" name="sppmu_state_id">
                                        <option value="" selected  style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        @foreach($state as $item)                                    
                                            <option value="{{ $item->state_description }}">{{ $item->state_description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <label class="form-label">Senarai Daerah</label>
                                <div class="form-group">
                                    <select class="custom-select" id="sppmu_daerah_id" name="sppmu_daerah_id" disabled>
                                            <option value="" selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
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
                <div class="tab-pane fade show active" id="Departments-list" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Senarai Pra Pendaftaran MKP</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_pra_pendaftaran_mkp" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50"><font color="white">Bil</font></th>
                                                <th style="background-color: #113f50"><font color="white">Negeri</font></th>
                                                <th style="background-color: #113f50"><font color="white">Daerah</font></th>
                                                <th style="background-color: #113f50"><font color="white">Nama Penuh</font></th>
                                                <th style="background-color: #113f50"><font color="white">No Kad Pengenalan</font></th>
                                                <th style="background-color: #113f50"><font color="white">No Telefon</font></th>
                                                <th style="background-color: #113f50"><font color="white">Tarikh</font></th>
                                                <th style="background-color: #113f50"><font color="white">Status</font></th>
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

@include('js.rt-sm23.j-senarai-pra-pendaftaran-mkp-upmk')