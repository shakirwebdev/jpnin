@extends('layout.master')
@section('title', 'Status Permohonan Penubuhan Kawasan Rukun Tetangga')

@section('content')
    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>&nbsp;</div>
                <div class="header-action">
                    <button type="button" class="btn btn-primary" onclick="window.location.href = '{{route('rt-sm1.permohonan_penubuhan_krt')}}';"><i class="fe fe-plus mr-2"></i>Permohonan Baru</button>
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
                            <h3 class="card-title text-primary">Senarai permohonan</h3>
                            <div class="card-options">
                                <form>
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" placeholder="Cari.." id="myInputTextField_Permohonan">
                                        <span class="input-group-btn ml-2"><button class="btn btn-icon" type="submit"><span class="fe fe-search"></span></button></span>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-vcenter table-hover mb-0" id="permohonan_table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Bil</th>
                                            <th>No<br>Rujukan</th>
                                            <th>Nama KRT</th>
                                            <th>Pengesahan<br>Nama</th>
                                            <th>Tarikh<br>Permohonan</th>                                            
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
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<style>    
    #permohonan_table_filter {
        display: none;
    }

    div.dataTables_processing {
        z-index: 1;
    }
</style>
@stop

@include('js.rt-sm1.j-status-permohonan-penubuhan-krt')
