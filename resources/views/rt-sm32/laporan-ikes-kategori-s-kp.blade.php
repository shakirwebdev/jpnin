@extends('layout.master')
@section('title', 'Laporan i-Kes Mengikut Negeri dan Kategori Kes')


@section('content')
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="Departments-list" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Statistik i-Kes Mengikut Negeri dan Kategori Kes</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="statistik_ikes_kategori" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label text-center"><font color="white">Bil</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label text-center"><font color="white">Negeri</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label text-center"><font color="white">Keganasan</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label text-center"><font color="white">Rusuhan</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label text-center"><font color="white">Demonstrasi</font></label></th>
                                                <th style="background-color: #113f50" colspan="5"><label class="form-label text-center"><font color="white">Protes</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label text-center"><font color="white">Pergaduhan</font></label></th>
                                                <th style="background-color: #113f50" colspan="6"><label class="form-label text-center"><font color="white">Serangan</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label text-center"><font color="white">Isu</font></label></th>
                                            </tr>
                                            <tr>
                                                <th style="background-color: #1d6c8a"><label class="form-label text-center"><font color="white">Perhimpunan Statik & Berarak (≤100)</font></label></th>
                                                <th style="background-color: #1d6c8a"><label class="form-label text-center"><font color="white">Perhimpunan Statik & Berarak (101-500)</font></label></th>
                                                <th style="background-color: #1d6c8a"><label class="form-label text-center"><font color="white">Perhimpunan Statik (>500)</font></label></th>
                                                <th style="background-color: #1d6c8a"><label class="form-label text-center"><font color="white">Memorandum/ Tandatangan</font></label></th>
                                                <th style="background-color: #1d6c8a"><label class="form-label text-center"><font color="white">Media Sosial</font></label></th>

                                                <th style="background-color: #1d6c8a"><label class="form-label text-center"><font color="white">Serangan (Asid)</font></label></th>
                                                <th style="background-color: #1d6c8a"><label class="form-label text-center"><font color="white">Serangan (Cat)</font></label></th>
                                                <th style="background-color: #1d6c8a"><label class="form-label text-center"><font color="white">Serangan (Harta Benda)</font></label></th>
                                                <th style="background-color: #1d6c8a"><label class="form-label text-center"><font color="white">Serangan (Molotov)</font></label></th>
                                                <th style="background-color: #1d6c8a"><label class="form-label text-center"><font color="white">Serangan (Senjata)</font></label></th>
                                                <th style="background-color: #1d6c8a"><label class="form-label text-center"><font color="white">Serangan (Tanpa Senjata)</font></label></th>
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

@include('js.rt-sm32.j-laporan-ikes-kategori-s-kp')