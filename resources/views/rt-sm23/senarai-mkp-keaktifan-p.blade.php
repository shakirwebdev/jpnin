@extends('layout.master')
@section('title', 'Senarai Keaktifan Mediator Komuniti')


@section('content')
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-primary">Carian</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-3">
                                <label class="form-label">Senarai Negeri</label>
                                <div class="form-group">
                                    <select class="custom-select" id="smkp_state_id" name="smkp_state_id">
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
                                    <select class="custom-select" id="smkp_daerah_id" name="smkp_daerah_id" disabled>
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
                <div class="tab-pane fade show active" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Senarai Keaktifan Mediator Komuniti</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_keaktifan_mkp" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Bil</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Senarai Negeri</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Senarai Daerah</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Nama Pemohon</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Kad Pengenalan</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">No Telefon</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Emel</font></label></th>
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

@include('js.rt-sm23.j-senarai-mkp-keaktifan-p')