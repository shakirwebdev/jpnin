@extends('layout.master')
@section('title', 'Tambah Ahli Cawangan RT')


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
                            <h3 class="card-title text-primary">Carian</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <label>Senarai Negeri</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="tacra_negeri_id" name="tacra_negeri_id">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($state as $item)                                    
                                                <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <label>Senarai Daerah</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="tacra_daerah_id" name="tacra_daerah_id" disabled>
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($daerah as $item)                                    
                                                <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <label>Senarai KRT</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="tacra_krt_id" name="tacra_krt_id" disabled>
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($krt as $item)                                    
                                                <option value="{{ $item->id }}">{{ $item->krt_nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <label>Nama Cawangan RT</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="cakka_negeri_id" name="cakka_negeri_id">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($cawangan as $item)                                    
                                                <option value="{{ $item->id }}">{{ $item->cawangan_description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Senarai Ahli Jawatankuasa Cawangan RUkun Tetangga</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_ajk_cawangan_table" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Bil</th>
                                                <th>Negeri</th>
                                                <th>Daerah</th>
                                                <th>Nama Krt</th>
                                                <th>Cawangan RT</th>
                                                <th>Nama</th>
                                                <th>No Kad Pengenalan</th>
                                                <th>Umur</th>
                                                <th>Status</th>
                                                <th>Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>      
                                        </tbody>
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

@include('js.rt-sm9.j-tambah-ajk-cawangan-rt-admin')