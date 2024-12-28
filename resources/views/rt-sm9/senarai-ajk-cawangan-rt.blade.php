@extends('layout.master')
@section('title', 'Senarai Ahli Cawangan RT')


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
                                    <label class="form-label">Senarai Nama Cawangan RT</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="sacrt_cawangan_id" name="sacrt_cawangan_id">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($cawangan as $item)                                    
                                                <option value="{{ $item->cawangan_description }}">{{ $item->cawangan_description }}</option>
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
                                                <th style="background-color: #113f50"><font color="white">Bil</font></th>
                                                <th style="background-color: #113f50"><font color="white">Cawangan RT</font></th>
                                                <th style="background-color: #113f50"><font color="white">Nama</font></th>
                                                <th style="background-color: #113f50"><font color="white">No Kad Pengenalan</font></th>
                                                <th style="background-color: #113f50"><font color="white">Umur</font></th>
                                                <th style="background-color: #113f50"><font color="white">No Telefon</font></th>
                                                <th style="background-color: #113f50"><font color="white">Alamat Email</font></th>
                                                <th style="background-color: #113f50"><font color="white">Status</font></th>
                                                <th style="background-color: #113f50"><font color="white">Tindakan</font></th>
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

@include('js.rt-sm9.j-senarai-ajk-cawangan-rt')
