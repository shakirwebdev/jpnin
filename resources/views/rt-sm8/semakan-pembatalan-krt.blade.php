@extends('layout.master')
@section('title', 'Semakan Pembatalan KRT')


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
                <div class="tab-pane fade show active" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Carian</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <div class="form-group">
                                        <label class="form-label">Nama KRT: </label>
                                        <select class="form-control" name="sppd_krt_profile_id" id="sppd_krt_profile_id">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($krt_profile as $item)                                    
                                                <option value="{{ $item->krt_nama }}">{{ $item->krt_nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Senarai Pemohonan Pembatalan KRT</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="senari_permohonan_pembatalan_krt" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50"><font color="white">Bil</font></th>
                                                <th style="background-color: #113f50"><font color="white">Nama KRT</font></th>
                                                <th style="background-color: #113f50"><font color="white">No Rujukan KRT</font></th>
                                                <th style="background-color: #113f50"><font color="white">Tujuan Pembatalan</font></th>
                                                <th style="background-color: #113f50"><font color="white">Tarikh Permohonan</font></th>
                                                <th style="background-color: #113f50"><font color="white">Status Permohonan</font></th>
                                                <th style="background-color: #113f50"><font color="white">Tindakan</font></th>
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

@include('js.rt-sm8.j-semakan-pembatalan-krt')
