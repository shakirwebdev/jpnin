@extends('layout.master')
@section('title', 'Laporan Maklumat Asas RT')


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
                                    <label class="form-label">Senarai Daerah</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lmakpn_daerah_id" name="lmakpn_daerah_id">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($daerah as $item)                                    
                                                <option value="{{ $item->daerah_description }}">{{ $item->daerah_description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Senarai PBT</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lmakpn_pbt_id" name="lmakpn_pbt_id">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($pbt as $item)                                    
                                                <option value="{{ $item->pbt_description }}">{{ $item->pbt_description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Senarai Parlimen</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lmakpn_parlimen_id" name="lmakpn_parlimen_id">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($parlimen as $item)                                    
                                                <option value="{{ $item->parlimen_description }}">{{ $item->parlimen_description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Senarai Dun</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lmakpn_dun_id" name="lmakpn_dun_id" disabled>
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Laporan Maklumat Asas RT</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="laporan_maklumat_asas_rt" style="width: 3000px">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50"><font color="white">Bil</font></th>
                                                <th style="background-color: #113f50"><font color="white">Negeri</font></th>
                                                <th style="background-color: #113f50"><font color="white">Daerah</font></th>
                                                <th style="background-color: #113f50"><font color="white">Nama KRT</font></th>
                                                <th style="background-color: #113f50"><font color="white">Alamat</font></th>
                                                <th style="background-color: #113f50"><font color="white">Parlimen</font></th>
                                                <th style="background-color: #113f50"><font color="white">Dun</font></th>
                                                <th style="background-color: #113f50"><font color="white">PBT</font></th>
                                                <th style="background-color: #113f50"><font color="white">IPD</font></th>
                                                <th style="background-color: #113f50"><font color="white">Balai Polis</font></th>
                                                <th style="background-color: #113f50"><font color="white">Saiz Keluasan</font></th>
                                                <th style="background-color: #113f50"><font color="white">Nama SRS</font></th>
                                                <th style="background-color: #113f50"><font color="white">Nama Tabika Perpaduan</font></th>
                                                <th style="background-color: #113f50"><font color="white">Nama Taska Perpaduan</font></th>
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

@include('js.rt-sm30.j-laporan-maklumat-asas-krt-ppn')