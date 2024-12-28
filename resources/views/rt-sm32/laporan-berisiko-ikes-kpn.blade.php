@extends('layout.master')
@section('title', 'Laporan Kawasan Berisiko Tinggi i-Kes')


@section('content')
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="Departments-list" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Statistik Kawasan Berisiko i-Kes (HOTSPOT)</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="laporan_ikes_hotspot" style="width: 2100px">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">Bil</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">Negeri</font></label></th>
                                                <th style="background-color: #113f50" colspan="4"><label class="form-label"><font color="white">Demonstrasi / Protes</font></label></th>
                                                <th style="background-color: #113f50" colspan="4"><label class="form-label"><font color="white">Pergaduhan / Serangan</font></label></th>
                                                <th style="background-color: #113f50" colspan="4"><label class="form-label"><font color="white">Isu</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">Jumlah Kes</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">Purata (Kes/ Bulan)</font></label></th>
                                            </tr>
                                            <tr>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S1</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S2</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S3</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S4</font></label></th>
                                                
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S1</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S2</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S3</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S4</font></label></th>

                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S1</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S2</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S3</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S4</font></label></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Statistik Kawasan Berisiko i-Kes (TENSION POINT)</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="laporan_ikes_tension" style="width: 2100px">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">Bil</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">Negeri</font></label></th>
                                                <th style="background-color: #113f50" colspan="4"><label class="form-label"><font color="white">Demonstrasi / Protes</font></label></th>
                                                <th style="background-color: #113f50" colspan="4"><label class="form-label"><font color="white">Pergaduhan / Serangan</font></label></th>
                                                <th style="background-color: #113f50" colspan="4"><label class="form-label"><font color="white">Isu</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">Jumlah Kes</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">Purata (Kes/ Bulan)</font></label></th>
                                            </tr>
                                            <tr>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S1</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S2</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S3</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S4</font></label></th>
                                                
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S1</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S2</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S3</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S4</font></label></th>

                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S1</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S2</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S3</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S4</font></label></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Statistik Kawasan Berisiko i-Kes (PAINT POINT)</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="laporan_ikes_paint" style="width: 2100px">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">Bil</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">Negeri</font></label></th>
                                                <th style="background-color: #113f50" colspan="4"><label class="form-label"><font color="white">Demonstrasi / Protes</font></label></th>
                                                <th style="background-color: #113f50" colspan="4"><label class="form-label"><font color="white">Pergaduhan / Serangan</font></label></th>
                                                <th style="background-color: #113f50" colspan="4"><label class="form-label"><font color="white">Isu</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">Jumlah Kes</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">Purata (Kes/ Bulan)</font></label></th>
                                            </tr>
                                            <tr>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S1</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S2</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S3</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S4</font></label></th>
                                                
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S1</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S2</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S3</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S4</font></label></th>

                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S1</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S2</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S3</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">S4</font></label></th>
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

@include('js.rt-sm32.j-laporan-berisiko-ikes-kpn')