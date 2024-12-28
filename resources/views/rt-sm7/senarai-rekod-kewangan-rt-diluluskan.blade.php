@extends('layout.master')
@section('title', 'Paparan Rekod Penerimaan & Pengeluaran Kewangan')


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
                            <h3 class="card-title text-primary">Senarai Kewangan Kawasan Rukun Tertangga</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_kewangan_rt_table" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50"><font color="white"><b>Bil</b></font></th>
                                                <th style="background-color: #113f50"><font color="white"><b>Butiran</b></font></th>
                                                <th style="background-color: #113f50"><font color="white"><b>Tarikh<br> Penerimaan /Pembayaran</b></font></th>
                                                <th style="background-color: #113f50"><font color="white"><b>No Cek / No Baucer</b></font></th>
                                                <th style="background-color: #113f50"><font color="white"><b>Tarikh Cek / Tarikh Baucer</b></font></th>
                                                <th style="background-color: #113f50"><font color="white"><b>Jenis Kewangan</b></font></th>
                                                <th style="background-color: #113f50"><font color="white"><b>Status</b></font></th>
                                                <th style="background-color: #113f50"><font color="white"><b>Tindakan</b></font></th>
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

@include('js.rt-sm7.j-senarai-rekod-kewangan-rt-diluluskan')
