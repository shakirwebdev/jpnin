@extends('layout.master')
@section('title', 'Permohonan Laporan Kes Mediasi')


@section('content')
    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                &nbsp;
            </div>
        </div>
    </div>
    <div class="section-body">
        <form method="POST" action="{{ route('rt-sm23.post_permohonan_laporan_mediasi') }}">
        @csrf
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center">
                    <div>&nbsp;</div>
                    <div class="header-action">
                        <input type="hidden" name="post_permohonan_laporan_mediasi" value="add">
                        <input type="hidden" name="splm_mkp_id" id="splm_mkp_id">
                        <button type="submit" class="btn btn-primary"><i class="fe fe-plus mr-2"></i>Permohonan Laporan Kes Mediasi</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="Departments-list" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Senarai Permohonan Laporan Kes Mediasi</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_permohonan_laporan_mediasi" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">Bil</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">Kluster</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">Tarikh Mediasi</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">Tempat Mediasi</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">Nama Mediator</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">Pembantu Mediator</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">Status</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">Tindakan</font></label></th>
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

@include('js.rt-sm23.j-senarai-permohonan-laporan-mediasi')