@extends('layout.master')
@section('title', 'Laporan Aktiviti RT')


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
                                    <label class="form-label">Agenda Kerja</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="larpd_agenda_id" name="larpd_agenda_id">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($agenda as $item)                                    
                                                <option value="{{ $item->agenda_description }}">{{ $item->agenda_description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Bidang</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="larpd_bidang_id" name="larpd_bidang_id">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($bidang as $item)                                    
                                                <option value="{{ $item->bidang_description }}">{{ $item->bidang_description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Kategori Aktiviti</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="larpd_k_aktiviti_id" name="larpd_k_aktiviti_id">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($k_aktiviti as $item)                                    
                                                <option value="{{ $item->aktiviti_description }}">{{ $item->aktiviti_description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Jenis Kategori Aktiviti</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="larpd_j_aktiviti_id" name="larpd_j_aktiviti_id">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($j_aktiviti as $item)                                    
                                                <option value="{{ $item->aktiviti_description }}">{{ $item->aktiviti_description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Laporan Aktiviti RT</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="laporan_aktiviti" style="width: 3000px">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Bil</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Negeri</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Daerah</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Nama KRT</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Penganjur</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Tajuk Aktiviti</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Perasmi</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Agenda Kerja</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Bidang</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Kategori Aktiviti</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Jenis Kategori Aktiviti</font></label></th>
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

@include('js.rt-sm30.j-laporan-aktiviti-rt-ppd')