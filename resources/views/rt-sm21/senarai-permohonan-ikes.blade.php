@extends('layout.master')
@section('title', 'Permohonanan Pelaporan i-Kes')


@section('content')
    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                &nbsp;
            </div>
        </div>
    </div>
    <div class="section-body">
        <form method="POST" action="{{ route('rt-sm21.post_permohonan_ikes') }}">
        @csrf
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center">
                    <div>&nbsp;</div>
                    <div class="header-action">
                        <input type="hidden" name="post_permohonan_ikes" value="add">
                        <button type="submit" class="btn btn-primary"><i class="fe fe-plus mr-2"></i>Permohonan Pelaporan i-Kes</button>
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
                            <h3 class="card-title text-primary">Senarai Permohonan Pelaporan i-Kes</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_permohonan_pelaporan_ikes" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Bil</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Peringkat Kes</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Kategori Kes</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Kluster</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Dimohon Oleh</font></label></th>
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

@include('js.rt-sm21.j-senarai-permohonan-ikes')