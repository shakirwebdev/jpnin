@extends('layout.master')
@section('title', 'Statistik Mediator Komuniti')


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
                <div class="tab-pane fade show active" id="user-list" role="tabpanel">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="row clearfix">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="table-responsive">
                                                                <table class="table thead-dark table-bordered table-striped" id="senarai_statistik_mkp_table" style="width: 100%" border="1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th colspan="4"><label class="form-label text-center"><font color="#113f50">Mediator Komuniti Di Seluruh Negeri</font></label></th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th><label class="form-label"><font color="#113f50">Negeri</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Pegawai</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Rukun Tetangga</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Bilangan</font></label></th>
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
                            <div class="col-lg-6 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="row clearfix">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="table-responsive">
                                                                <table class="table thead-dark table-bordered table-striped" id="senarai_statistik_jantina_table" style="width: 100%" border="1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th colspan="4"><label class="form-label text-center"><font color="#113f50">Jantina</font></label></th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th><label class="form-label"><font color="#113f50">Negeri</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Lelaki</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Perempuan</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Bilangan</font></label></th>
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
                            <div class="col-lg-12 col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="row clearfix">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="table-responsive">
                                                                <table class="table thead-dark table-bordered table-striped" id="senarai_statistik_kaum_table" style="width: 100%" border="1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th colspan="8"><label class="form-label text-center"><font color="#113f50">Kaum</font></label></th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th><label class="form-label"><font color="#113f50">Negeri</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Melayu</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Cina</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">India</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Iban</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Kadazan</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Lain-lain</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Jumlah</font></label></th>
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
                            <div class="col-lg-12 col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="row clearfix">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="table-responsive">
                                                                <table class="table thead-dark table-bordered table-striped" id="senarai_statistik_pendidikan_table" style="width: 100%" border="1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th colspan="9"><label class="form-label text-center"><font color="#113f50">Taraf Pendidikan</font></label></th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th><label class="form-label"><font color="#113f50">Negeri</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Phd</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Sarjana / Sarjana Muda</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Diploma / Stpm dan Setaraf</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Spm / Spmvm Dan Setaraf</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Pmr / Srp Dan Setaraf</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Sekolah Rendah</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Lain -Lain</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Jumlah</font></label></th>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@stop

@include('js.rt-sm23.j-statistik-mkp-admin')
