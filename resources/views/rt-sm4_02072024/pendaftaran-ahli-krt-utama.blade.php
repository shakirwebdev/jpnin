@extends('layout.master')
@section('title', 'Pendaftaran Ahli KRT (Jawatan Utama)')


@section('content')
    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                &nbsp;
            </div>
        </div>
    </div>
    <div class="section-body">
        <form method="POST" action="{{ route('rt-sm4.post_daftar_ahli_krt') }}">
        @csrf
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center">
                    <div>&nbsp;</div>
                    <div class="header-action">
                        <input type="hidden" name="krt_id" id="krt_id">
                        <input type="hidden" name="daftar_ajk" value="add">
                        <button type="submit" class="btn btn-primary"><i class="fe fe-plus mr-2"></i>Pendaftaran e-IDRT</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="Departments-list" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Senarai Pelantikan Ahli Jawatankuasa Kawasan Rukun Tertangga</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_ahli_krt_table" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50" ><font color="white">Bil</font></th>
                                                <th style="background-color: #113f50" ><font color="white">Nama</font></th>
                                                <th style="background-color: #113f50" ><font color="white">No Kad Pengenalan</font></th>
                                                <th style="background-color: #113f50" ><font color="white">Alamat</font></th>
                                                <th style="background-color: #113f50" ><font color="white">No Telefon</font></th>
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
    </div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
@stop

@include('js.rt-sm4.j-pendaftaran-ahli-krt-utama')

