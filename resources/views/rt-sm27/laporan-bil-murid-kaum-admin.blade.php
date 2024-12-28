@extends('layout.master')
@section('title', 'Laporan Bilangan Murid Tabika Perpaduan Ikut Kaum')


@section('content')
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-primary">Carian</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <label class="form-label">Tahun</label>
                                <div class="form-group">
                                    <select class="custom-select" id="" name="">
                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        
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
                <div class="card">
                    <div class="card-header">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <h3 class="card-title text-primary">
                                Senarai Bilangan Murid
                            </h3>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-vcenter table-hover mb-0" id="list_bil_murid" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th style="background-color: #113f50" rowspan="2"><font color="white">Bil</font></th>
                                            <th style="background-color: #113f50" rowspan="2"><font color="white">Negeri</font></th>
                                            <th style="background-color: #113f50" colspan="6" class="text-center"><font color="white">Kaum</font></th>
                                            <th style="background-color: #113f50" rowspan="2"><font color="white">Jumlah</font></th>
                                        </tr>
                                        <tr>
                                            <th style="background-color: #113f50"><font color="white">Melayu</font></th>
                                            <th style="background-color: #113f50"><font color="white">Cina</font></th>
                                            <th style="background-color: #113f50"><font color="white">India</font></th>
                                            <th style="background-color: #113f50"><font color="white">Iban</font></th>
                                            <th style="background-color: #113f50"><font color="white">Kadazan Dusun</font></th>
                                            <th style="background-color: #113f50"><font color="white">Lain - Lain</font></th>
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
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
@stop

@include('js.rt-sm27.j-laporan-bil-murid-kaum-admin')