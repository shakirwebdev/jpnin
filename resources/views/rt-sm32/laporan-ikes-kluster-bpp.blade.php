@extends('layout.master')
@section('title', 'Laporan i-Kes Mengikut Kluster dan Sub Kluster')


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
                                        <select class="custom-select" id="likbpd_year" name="likbpd_year">
                                            <option value=""  selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                @for ($year = date('Y'); $year > date('Y') - 100; $year--)
                                                    <option value="{{$year}}">
                                                            {{$year}}
                                                    </option>
                                                @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Statistik i-Kes mengikut Kluster dan Sub Kluster</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="laporan_isu_semasa_ikes" style="width: 3000px">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Bil</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Kluster</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Sub Kluster</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">JAN</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">FEB</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Mac</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">APR</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">MAY</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">JUN</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">JUL</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">AUG</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">SEP</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">NOV</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">DEC</font></label></th>
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

@include('js.rt-sm32.j-laporan-ikes-kluster-bpp')