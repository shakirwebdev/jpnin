@extends('layout.master')
@section('title', 'Statistik Mediator Komuniti (Kaum)')


@section('content')
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="Departments-list" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Bilangan Mediator Komuniti Perpaduan Mengikut Kaum</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="statistik_mk_kaum" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label text-center"><font color="white">Bil</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label text-center"><font color="white">Negeri</font></label></th>
                                                <th style="background-color: #113f50" colspan="5"><label class="form-label text-center"><font color="white">Kaum</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label text-center"><font color="white">Jumlah</font></label></th>
                                            </tr>
                                            <tr>
                                                <th style="background-color: #113f50"><label class="form-label text-center"><font color="white">Melayu</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label text-center"><font color="white">Cina</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label text-center"><font color="white">India</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label text-center"><font color="white">B'Putra Sabah</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label text-center"><font color="white">B'Putra Serawak</font></label></th>
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
<link rel="stylesheet" href="//cdn.datatables.ne/buttons/1.10.20/css/buttons.dataTables.min.css">
@stop

@include('js.rt-sm32.j-statistik-mk-kaum-ppd')