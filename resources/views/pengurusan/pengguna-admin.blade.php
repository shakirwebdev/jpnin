@extends('layout.master')
@section('parentPageTitle', 'HRMS')
@section('title', 'Pengurusan Pengguna')


@section('content')
@include('modal.modal-add-jpnin-admin')
<div class="section-body">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <ul class="nav nav-tabs page-header-tab">
                <li class="nav-item"><a class="nav-link active" id="Departments-tab" data-toggle="tab" href="#ref-jpnin"><i class="fa fa-list-ul"></i>&nbsp;Pengguna JPNIN</a></li>
                <li class="nav-item"><a class="nav-link" id="Departments-tab1" data-toggle="tab" href="#ref-orang-awam"><i class="fa fa-list-ul"></i>&nbsp;Pengguna Orang Awam</a></li>
                <li class="nav-item"><a class="nav-link" id="Departments-tab2" data-toggle="tab" href="#ref-eKRT"><i class="fa fa-list-ul"></i>&nbsp;Pengguna e-KRT</a></li>
                <li class="nav-item"><a class="nav-link" id="Departments-tab3" data-toggle="tab" href="#ref_srs"><i class="fa fa-list-ul"></i>&nbsp;Pengguna e-SRS</a></li>
                <li class="nav-item"><a class="nav-link" id="Departments-tab4" data-toggle="tab" href="#ref_espakat"><i class="fa fa-list-ul"></i>&nbsp;Pengguna e-Sepakat</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="section-body mt-3">
    <div class="container-fluid">
        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="ref-jpnin" role="tabpanel">
                <div class="row clearfix">
                    <div class="col-12">
                        <div class="body">
                            <form method="POST" action="{{ route('post_add_pengguna_jpnin_admin') }}">
                            @csrf
                                <div class="container-fluid">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>&nbsp;</div>
                                        <div class="header-action">
                                            <input type="hidden" name="add_pengguna_jpnin_admin" value="add">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-window-restore"></i> Tambah Pengguna JPNIN</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <br>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title text-primary">Carian</h3>
                            </div>
                            <div class="card-body">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Cari pengguna..." id="myInputTextField_UserJPNIN">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title text-primary">Senarai Pengguna JPNIN</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="user_jpnin_table" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50"><font color="white">Bil</font></th>
                                                <th style="background-color: #113f50"><font color="white">Nama Penuh</font></th>
                                                <th style="background-color: #113f50"><font color="white">No Kad Pengenalan</font></th>
                                                <th style="background-color: #113f50"><font color="white">No Telefon</font></th>
                                                <th style="background-color: #113f50"><font color="white">Tarikh Dicipta</font></th>
                                                <th style="background-color: #113f50"><font color="white">Status</font></th>
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
@stop

@include('js.pengurusan.j-pengguna-admin')