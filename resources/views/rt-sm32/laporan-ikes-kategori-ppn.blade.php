@extends('layout.master')
@section('title', 'Laporan Bulanan i-Kes mengikut Kategori')


@section('content')
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="Departments-list" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Laporan Isu - Isu Semasa i-Kes</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="laporan_isu_semasa_ikes" style="width: 3000px">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Bil</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Negeri</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Daerah</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Parlimen</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Dun</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Bandar / Kawasan</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Lokasi</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Kluster</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Sub Kluster</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Jenis Arahan</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Tarikh Arahan</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Keterangan Tindakan</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label"><font color="white">Tarikh Tindakan</font></label></th>
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

@include('js.rt-sm32.j-laporan-ikes-kategori-ppn')