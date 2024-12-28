@extends('layout.master')
@section('title', 'Laporan Aktiviti RT')


@section('content')
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="Departments-list" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Laporan Aktiviti RT</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="laporan_aktiviti_2" style="width: 2400px">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">Bil</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">Negeri</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">Daerah</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">Nama KRT</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">Penganjur</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">Tajuk Aktiviti</font></label></th>
                                                <th style="background-color: #113f50" colspan="2" class="text-center"><label class="form-label"><font color="white">Jantina</font></label></th>
                                                <th style="background-color: #113f50" colspan="7" class="text-center"><label class="form-label"><font color="white">Umur</font></label></th>
                                            </tr>
                                            <tr>
                                                <th style="background-color: #113f50"><font color="white">Lelaki</font></th>
                                                <th style="background-color: #113f50"><font color="white">Perempuan</font></th>
                                                <th style="background-color: #113f50"><font color="white">0 - 6</font></th>
                                                <th style="background-color: #113f50"><font color="white">07 - 12</font></th>
                                                <th style="background-color: #113f50"><font color="white">13 - 17</font></th>
                                                <th style="background-color: #113f50"><font color="white">18 - 35</font></th>
                                                <th style="background-color: #113f50"><font color="white">36 - 45</font></th>
                                                <th style="background-color: #113f50"><font color="white">45 - 59</font></th>
                                                <th style="background-color: #113f50"><font color="white">60 Keatas</font></th>
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

@include('js.rt-sm30.j-laporan-aktiviti-rt-2-ppd')