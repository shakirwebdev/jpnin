@extends('layout.master')
@section('title', 'Permohonan Kemasukan Tabika Perpaduan')


@section('content')
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="card">
                    <form method="POST" action="{{ route('rt-sm27.post_permohonan_student_tp') }}">
                    @csrf
                        <div class="card-header">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <h3 class="card-title text-primary">
                                    Senarai Permohonan Kemasukan Tabika Perpaduan
                                    <input type="hidden" name="post_permohonan_student_tp" value="add">
                                    <button type="submit" class="btn btn-primary pull-right"><i class="fe fe-plus mr-2"></i>Permohonan Kemasukan Tabika</button>
                                </h3>
                            </div>
                        </div>
                    </form>
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-vcenter table-hover mb-0" id="list_mohon_masuk_tabika" style="width: 2300px">
                                    <thead>
                                        <tr>
                                            <th style="background-color: #113f50" ><font color="white">Bil</font></th>
                                            <th style="background-color: #113f50" ><font color="white">No Permohonan</font></th>
                                            <th style="background-color: #113f50" ><font color="white">Negeri</font></th>
                                            <th style="background-color: #113f50" ><font color="white">Daerah</font></th>
                                            <th style="background-color: #113f50" ><font color="white">Nama Tabika</font></th>
                                            <th style="background-color: #113f50" ><font color="white">Nama</font></th>
                                            <th style="background-color: #113f50" ><font color="white">No Mykid</font></th>
                                            <th style="background-color: #113f50" ><font color="white">Jantina</font></th>
                                            <th style="background-color: #113f50" ><font color="white">Alamat</font></th>
                                            <th style="background-color: #113f50" ><font color="white">Status</font></th>
                                            <th style="background-color: #113f50" ><font color="white">Tindakan</font></th>
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
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
@stop

@include('js.rt-sm27.j-senarai-permohonan-student-tp-p')