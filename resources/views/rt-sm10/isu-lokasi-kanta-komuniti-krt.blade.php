@extends('layout.master')
@section('title', 'Senarai Isu Dan Masalah Di Kanta Komuniti')


@section('content')
    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                &nbsp;
            </div>
        </div>
    </div>
    <div class="section-body">
        <form method="POST" action="{{ route('rt-sm10.post_lapor_isu_lokasi_kanta_komuniti') }}">
        @csrf
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center">
                    <div>&nbsp;</div>
                    <div class="header-action">
                        <input type="hidden" name="add_lapor_isu_lokasi_kanta_komuniti" value="add">
                        <button type="submit" class="btn btn-primary"><i class="fe fe-plus mr-2"></i>Lapor Isu Dan Masalah Di Lokasi Kanta Komuniti</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="row clearfix">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title text-primary">Senarai Isu Dan Masalah Di Lokasi Kanta Komuniti</h3>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_isu_lokasi_kanta_komuniti" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th style="background-color: #113f50"><font color="white">Bil</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Lokasi Kanta Komuniti</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Kluster Isu Dan Masalah</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Bilangan Yang Terlibat</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Agensi Yang Terlibat</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Status Isu / Masalah</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Statu</font>s</th>
                                                    <th style="background-color: #113f50"><font color="white">Tindakan</font></th>
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
    </div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
@stop

@include('js.rt-sm10.j-isu-lokasi-kanta-komuniti-krt')
