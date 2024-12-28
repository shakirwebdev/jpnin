@extends('layout.master')
@section('title', 'Laporan Kewangan RT')


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
                <div>&nbsp;</div>
                <div class="header-action">
                    <button type="button" class="btn btn-primary" title="Cetak Laporan Kewangan RT" onclick="print_laporan_kewangan_rt();"><i class="fa fa-print mr-2"></i>Cetak Laporan Kewangan RT</button>
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
                            <h3 class="card-title text-primary">Laporan Kewangan RT</h3>
                        </div>
                         <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="row clearfix">
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label">Nama KRT: </label>
                                                <input type="text" class="form-control" name="lkr_krt_nama" id="lkr_krt_nama" placeholder="Nama KRT" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">No Akaun: </label>
                                                <input type="text" class="form-control" name="lkr_no_acc" id="lkr_no_acc" placeholder="No Akaun" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Nama Bank: </label>
                                                <input type="text" class="form-control" name="lkr_bank_nama" id="lkr_bank_nama" placeholder="Nama Bank" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label">No E-Vendor: </label>
                                                <input type="text" class="form-control" name="lkr_no_evendor" id="lkr_no_evendor" placeholder="No E-Vendor" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Daerah: </label>
                                                <input type="text" class="form-control" name="lkr_daerah" id="lkr_daerah" placeholder="Daerah" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Negeri: </label>
                                                <input type="text" class="form-control" name="lkr_negeri" id="lkr_negeri" placeholder="Negeri" disabled>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_kewangan_rt_table" style="width: 100%">
                                                        <thead>
                                                            <tr>
                                                                <th style="background-color: #113f50" rowspan="2"><font color="white"><b>Bil</b></font></th>
                                                                <th style="background-color: #113f50" rowspan="2"><font color="white"><b>Butiran</b></font></th>
                                                                <th style="background-color: #113f50" rowspan="2"><font color="white"><b>Tarikh<br> Penerimaan /Pembayaran</b></font></th>
                                                                <th style="background-color: #113f50" rowspan="2"><font color="white"><b>No Cek / No Baucer</b></font></th>
                                                                <th style="background-color: #113f50" rowspan="2"><font color="white"><b>Tarikh Cek / Tarikh Baucer</b></font></th>
                                                                <th style="background-color: #113f50" colspan="2" class="text-center"><font color="white"><b>Penerimaan</b></font></th>
                                                                <th style="background-color: #113f50" colspan="2" class="text-center"><font color="white"><b>Pembayaran</b></font></th>
                                                                <th style="background-color: #113f50" colspan="2" class="text-center"><font color="white"><b>Baki</b></font></th>
                                                            </tr>
                                                            <tr>
                                                                <th style="background-color: #113f50"><font color="white"><b>Tunai</b></font></th>
                                                                <th style="background-color: #113f50"><font color="white"><b>Bank</b></font></th>
                                                                <th style="background-color: #113f50"><font color="white"><b>Tunai</b></font></th>
                                                                <th style="background-color: #113f50"><font color="white"><b>Bank</b></font></th>
                                                                <th style="background-color: #113f50"><font color="white"><b>Tunai</b></font></th>
                                                                <th style="background-color: #113f50"><font color="white"><b>Bank</b></font></th>
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
                </div>
            </div>
        </div>
    </div>
@stop



@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
@stop

@include('js.rt-sm7.j-laporan-kewangan-rt')
