@extends('layout.master')
@section('title', 'Bilangan Ajk Mengikut Jawatan')


@section('content')
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="Departments-list" role="tabpanel">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-primary">Carian</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <label class="form-label">Senarai Parlimen</label>
                                            <div class="form-group">
                                                <select class="custom-select" id="lbajpd_parlimen_id" name="lbajpd_parlimen_id" >
                                                    <option value="" selected style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                    @foreach($parlimen as $item)                                    
                                                        <option value="{{ $item->parlimen_description }}">{{ $item->parlimen_description }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <label class="form-label">Senarai Dun</label>
                                            <div class="form-group">
                                                <select class="custom-select" id="lbajpd_dun_id" name="lbajpd_dun_id" disabled>
                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-primary">Bilangan Ahli Jawatankuasa Pengurusi</h3>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-vcenter table-hover mb-0" id="bilangan_ajk_krt_pengerusi" style="width: 1500px">
                                                <thead>
                                                    <tr>
                                                        <th style="background-color: #113f50"><font color="white">Bil</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Negeri</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Daerah</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Parlimen</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Dun</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Nama KRT</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Jawatan</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Jumlah</font></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-primary">Bilangan Ahli Jawatankuasa Timbalan Pengurusi</h3>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-vcenter table-hover mb-0" id="bilangan_ajk_krt_tpengerusi" style="width: 1500px">
                                                <thead>
                                                    <tr>
                                                        <th style="background-color: #113f50"><font color="white">Bil</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Negeri</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Daerah</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Parlimen</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Dun</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Nama KRT</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Jawatan</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Jumlah</font></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-primary">Bilangan Ahli Jawatankuasa Setiausaha</h3>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-vcenter table-hover mb-0" id="bilangan_ajk_krt_setiausaha" style="width: 1500px">
                                                <thead>
                                                    <tr>
                                                        <th style="background-color: #113f50"><font color="white">Bil</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Negeri</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Daerah</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Parlimen</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Dun</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Nama KRT</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Jawatan</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Jumlah</font></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-primary">Bilangan Ahli Jawatankuasa Bendahari</h3>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-vcenter table-hover mb-0" id="bilangan_ajk_krt_bendahari" style="width: 1500px">
                                                <thead>
                                                    <tr>
                                                        <th style="background-color: #113f50"><font color="white">Bil</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Negeri</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Daerah</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Parlimen</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Dun</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Nama KRT</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Jawatan</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Jumlah</font></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-primary">Bilangan Ahli Jawatankuasa Penolong Setiausaha</h3>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-vcenter table-hover mb-0" id="bilangan_ajk_krt_psetiausaha" style="width: 1500px">
                                                <thead>
                                                    <tr>
                                                        <th style="background-color: #113f50"><font color="white">Bil</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Negeri</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Daerah</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Parlimen</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Dun</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Nama KRT</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Jawatan</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Jumlah</font></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-primary">Bilangan Ahli Jawatankuasa AJK</h3>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-vcenter table-hover mb-0" id="bilangan_ajk_krt_ajk" style="width: 1500px">
                                                <thead>
                                                    <tr>
                                                        <th style="background-color: #113f50"><font color="white">Bil</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Negeri</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Daerah</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Parlimen</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Dun</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Nama KRT</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Jawatan</font></th>
                                                        <th style="background-color: #113f50"><font color="white">Jumlah</font></th>
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
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
@stop

@include('js.rt-sm30.j-laporan-bilangan-ajk-jawatan-ppd')