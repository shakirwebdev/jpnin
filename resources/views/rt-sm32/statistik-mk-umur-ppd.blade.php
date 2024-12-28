@extends('layout.master')
@section('title', 'Statistik Mediator Komuniti (Umur)')


@section('content')
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="Departments-list" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Bilangan Mediator Komuniti Perpaduan Mengikut Umur</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="statistik_mk_umur" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label text-center"><font color="white">Bil</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label text-center"><font color="white">Negeri</font></label></th>
                                                <th style="background-color: #113f50" colspan="5"><label class="form-label text-center"><font color="white">Purata Umur</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label text-center"><font color="white">Jumlah</font></label></th>
                                            </tr>
                                            <tr>
                                                <th style="background-color: #113f50"><label class="form-label text-center"><font color="white">20 - 30</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label text-center"><font color="white">31 - 40</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label text-center"><font color="white">41 - 50</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label text-center"><font color="white">51 - 60</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label text-center"><font color="white">60 ></font></label></th>
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

@include('js.rt-sm32.j-statistik-mk-umur-ppd')