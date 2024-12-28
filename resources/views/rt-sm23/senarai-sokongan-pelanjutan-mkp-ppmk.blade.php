@extends('layout.master')
@section('title', 'Senarai Sokongan Permohonan Pelanjutan MKP')


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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-primary">Carian</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <label class="form-label">Senarai Daerah</label>
                                <div class="form-group">
                                    <select class="custom-select" id="sspmmk_daerah_id" name="sspmmk_daerah_id">
                                        <option value="" selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        @foreach($daerah as $item)                                    
                                            <option value="{{ $item->daerah_description }}">{{ $item->daerah_description }}</option>
                                        @endforeach
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
                <div class="tab-pane fade show active" id="Departments-list" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Senarai Sokongan Permohonan Pelanjutan MKP</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_status_kelayakan_lanjutan_mkp" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Bil</th>
                                                <th>Nama Pemohon</th>
                                                <th>Kad Pengenalan</th>
                                                <th>No Telefon</th>
                                                <th>Tarikh Dilantik</th>
                                                <th>Tarikh Tamat</th>
                                                <th>Status Kelayakan</th>
                                                <th>Status</th>
                                                <th width="11%">Tindakan</th>
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

@include('js.rt-sm23.j-senarai-sokongan-pelanjutan-mkp-ppmk')