@extends('layout.master')
@section('title', 'Laporan Ringkasan Peronda SRS')


@section('content')
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="Departments-list" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Carian</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Senarai Negeri</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lrphq_state_id" name="lrphq_state_id">
                                            <option value=""  selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($state as $item)                                    
                                                <option value="{{ $item->state_description }}">{{ $item->state_description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Senarai Daerah</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lrphq_daerah_id" name="lrphq_daerah_id" disabled>
                                            <option value="" selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Senarai Parlimen</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lrphq_parlimen_id" name="lrphq_parlimen_id" disabled>
                                            <option value=""  selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Senarai Dun</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lrphq_dun_id" name="lrphq_dun_id" disabled>
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Senarai KRT</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lrphq_krt_id" name="lrphq_krt_id" disabled>
                                            <option value="" selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Senarai SRS</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lrphq_srs_id" name="lrphq_srs_id" disabled>
                                            <option value="" selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Ringkasan Peronda SRS</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_peronda_srs_table" style="width: 2800px">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50" rowspan="3"><label class="form-label"><font color="white">Bil</font></label></th>
                                                <th style="background-color: #113f50" rowspan="3"><label class="form-label"><font color="white">Negeri</font></label></th>
                                                <th style="background-color: #113f50" rowspan="3"><label class="form-label"><font color="white">Daerah</font></label></th>
                                                <th style="background-color: #113f50" rowspan="3"><label class="form-label"><font color="white">Parlimen</font></label></th>
                                                <th style="background-color: #113f50" rowspan="3"><label class="form-label"><font color="white">Dun</font></label></th>
                                                <th style="background-color: #113f50" rowspan="3"><label class="form-label"><font color="white">Nama KRT</font></label></th>
                                                <th style="background-color: #113f50" rowspan="3"><label class="form-label"><font color="white">Nama SRS</font></label></th>
                                                <th style="background-color: #113f50" rowspan="3"><label class="form-label"><font color="white">Jumlah Peronda<br> Berdaftar</font></label></th>
                                                <th style="background-color: #113f50" colspan="12" class="text-center"><label class="form-label"><font color="white">Bilangan Kaum</font></label></th>
                                                <th style="background-color: #113f50" colspan="5" class="text-center"><label class="form-label"><font color="white">Umur</font></label></th>
                                            </tr>
                                            <tr>
                                                <th style="background-color: #113f50" colspan="2"><label class="form-label"><font color="white">Melayu</font></label></th>
                                                <th style="background-color: #113f50" colspan="2"><label class="form-label"><font color="white">Cina</font></label></th>
                                                <th style="background-color: #113f50" colspan="2"><label class="form-label"><font color="white">India</font></label></th>
                                                <th style="background-color: #113f50" colspan="2"><label class="form-label"><font color="white">BumiPutera<br>Sabah</font></label></th>
                                                <th style="background-color: #113f50" colspan="2"><label class="form-label"><font color="white">BumiPutera<br>Serawak</font></label></th>
                                                <th style="background-color: #113f50" colspan="2"><label class="form-label"><font color="white">Lain-Lain</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">18 - 21</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">22 - 40</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">41 - 55</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">57 - 70</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">71 Tahun Keatas</font></label></th>
                                            </tr>
                                            <tr>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">L</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">P</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">L</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">P</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">L</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">P</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">L</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">P</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">L</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">P</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">L</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">P</font></label></th>
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

@include('js.rt-sm31.j-laporan-ringkasan-peronda-srs-kp')