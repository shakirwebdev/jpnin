@extends('layout.master')
@section('title', 'Laporan Taburan Isu mengikut Kluser i-Kes')


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
                                <!-- <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Tahun</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lksrs_year" name="lksrs_year">
                                            <option value=""  selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                @for ($year = date('Y'); $year > date('Y') - 100; $year--)
                                                    <option value="{{$year}}">
                                                            {{$year}}
                                                    </option>
                                                @endfor
                                        </select>
                                    </div>
                                </div> -->
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Bulan</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lksrs_month" name="lksrs_month">
                                            <option value=""  selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            <option value="1" >Januari</option>
                                            <option value="2" >Febuari</option>
                                            <option value="3" >Mac</option>
                                            <option value="4" >April</option>
                                            <option value="5" >Mei</option>
                                            <option value="6" >Jun</option>
                                            <option value="7" >Julai</option>
                                            <option value="8" >Ogos</option>
                                            <option value="9" >September</option>
                                            <option value="10" >Oktober</option>
                                            <option value="11" >November</option>
                                            <option value="12" >Disember</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <button type="button" class="btn btn-primary pull-right" id="btn_search"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Cari</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Laporan Taburan Isu mengikut Kluser i-Kes</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                            <figure class="highcharts-figure">
                                <div id="container"></div>
                            </figure>
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

@include('js.rt-sm32.j-laporan-ikes-chart-tkpp')