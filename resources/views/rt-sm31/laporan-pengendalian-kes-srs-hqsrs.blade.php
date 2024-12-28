@extends('layout.master')
@section('title', 'Laporan Pengendalian Kes SRS')


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
                                    <label class="form-label">Tahun</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lpksrs_year_id" name="lpksrs_year_id">
                                            <option value=""  selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @for ($year = date('Y'); $year > date('Y') - 100; $year--)
                                                <option value="{{$year}}">
                                                        {{$year}}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Senarai Negeri</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lpksrs_state_id" name="lpksrs_state_id">
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
                                        <select class="custom-select" id="lpksrs_daerah_id" name="lpksrs_daerah_id" disabled>
                                            <option value=""  selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Senarai KRT</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lpksrs_krt_id" name="lpksrs_krt_id" disabled>
                                            <option value=""  selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Senarai SRS</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lpksrs_srs_id" name="lpksrs_srs_id" disabled>
                                            <option value=""  selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Laporan Pengendalian Kes SRS</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="pengendalian_kes_srs_table" style="width: 2800px">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50" rowspan="3"><label class="form-label"><font color="white">Bil</font></label></th>
                                                <th style="background-color: #113f50" rowspan="3"><label class="form-label"><font color="white">Negeri</font></label></th>
                                                <th style="background-color: #113f50" rowspan="3"><label class="form-label"><font color="white">Daerah</font></label></th>
                                                <th style="background-color: #113f50" rowspan="3"><label class="form-label"><font color="white">Nama KRT</font></label></th>
                                                <th style="background-color: #113f50" rowspan="3"><label class="form-label"><font color="white">Nama SRS</font></label></th>
                                                <th style="background-color: #113f50" rowspan="3"><label class="form-label"><font color="white">Kategori</font></label></th>
                                                <th style="background-color: #113f50" rowspan="3"><label class="form-label"><font color="white">Jenis Kes</font></label></th>
                                                <th style="background-color: #113f50" rowspan="3"><label class="form-label"><font color="white">Jumlah Terlibat</font></label></th>
                                                <th style="background-color: #113f50" colspan="10" class="text-center"><label class="form-label"><font color="white">Bilangan Kaum Terlibat</font></label></th>
                                                <th style="background-color: #113f50" colspan="5" class="text-center"><label class="form-label"><font color="white">Umur</font></label></th>
                                                <th style="background-color: #113f50" rowspan="3" class="text-center"><label class="form-label"><font color="white">Kes Dilaporkan Kepada Agensi-Agensi<br>/ <br>Yang Dirujuk Untuk Penyelesaian</font></label></th>
                                            </tr>
                                            <tr>
                                                <th style="background-color: #113f50" class="text-center" colspan="2"><label class="form-label"><font color="white">MELAYU</font></label></th>
                                                <th style="background-color: #113f50" class="text-center" colspan="2"><label class="form-label"><font color="white">CINA</font></label></th>
                                                <th style="background-color: #113f50" class="text-center" colspan="2"><label class="form-label"><font color="white">INDIA</font></label></th>
                                                <th style="background-color: #113f50" class="text-center" colspan="2"><label class="form-label"><font color="white">BUMIPUTRA<br>SABAH</font></label></th>
                                                <th style="background-color: #113f50" class="text-center" colspan="2"><label class="form-label"><font color="white">BUMIPUTRA<br>SARAWAK</font></label></th>
                                                <th style="background-color: #113f50" class="text-center" rowspan="2"><label class="form-label"><font color="white">< 12</font></label></th>
                                                <th style="background-color: #113f50" class="text-center" rowspan="2"><label class="form-label"><font color="white">13 - 21</font></label></th>
                                                <th style="background-color: #113f50" class="text-center" rowspan="2"><label class="form-label"><font color="white">22 - 40</font></label></th>
                                                <th style="background-color: #113f50" class="text-center" rowspan="2"><label class="form-label"><font color="white">41 - 60</font></label></th>
                                                <th style="background-color: #113f50" class="text-center" rowspan="2"><label class="form-label"><font color="white">60 ></font></label></th>
                                            </tr>
                                            <tr>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">L</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">p</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">L</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">p</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">L</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">p</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">L</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">p</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">L</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">p</font></label></th>
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

@include('js.rt-sm31.j-laporan-pengendalian-kes-srs-hqsrs')