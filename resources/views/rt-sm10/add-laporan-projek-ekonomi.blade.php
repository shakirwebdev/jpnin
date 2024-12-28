@extends('layout.master')
@section('title', 'LAPORAN KEMAJUAN PROJEK EKONOMI RUKUN TETANGGA')


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
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <small>Isi maklumat pada borang yang disediakan dibawah, dan tekan butang HANTAR. 
                        <br>
                        Ruangan bertanda <span class="text-red">*</span> adalah ruangan mandatori dan perlu diisi..&nbsp;&nbsp;<a href="#"><i class="dropdown-icon fe fe-help-circle"></i></a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="user-list" role="tabpanel">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT AM LAPORAN PROJEK EKONOMI RT</b></h6>
                                                <br>
                                                <div class="form-group">
                                                    <label class="form-label">Negeri : </label>
                                                    <select class="form-control" disabled="">
                                                        <option>Perlis</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Daerah : </label>
                                                    <select class="form-control" disabled="">
                                                        <option>Kangar</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Nama KRT : </label>
                                                    <select class="form-control" disabled="">
                                                        <option>KRT Taman Peladang Jaya</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Nama Projek : <span class="text-red">*</span></label>
                                                    <select class="form-control" >
                                                        <option>-- Sila Pilih --</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Kategori Projek : <span class="text-red">*</span></label>
                                                    <select class="form-control" >
                                                        <option>-- Sila Pilih --</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <h6><b>MAKLUMAT LAPORAN PROJEK EKONOMI RT</b></h6>
                                            <br>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Cabaran : <span class="text-red">*</span></label>
                                                            <select class="form-control" >
                                                                <option>-- Sila Pilih --</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Tahun Mula Projek : <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="" placeholder="Tahun Mula Projek">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Peruntukan Diterima (Jabatan) : <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="" placeholder="Tahun Mula Projek">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Tarikh Kemaskini : <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="" placeholder="Tahun Mula Projek">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Peserta Projek : <span class="text-red">*</span></label>
                                                        </div>
                                                        <div class="series-frame">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Nama Perserta : </label>
                                                                    <input type="text" class="form-control" name="" placeholder="Nama Perserta">
                                                                </div> 
                                                                <div class="form-group">
                                                                    <label class="form-label">No Kad Pengenalan : <span class="text-red">*</span></label>
                                                                    <input type="text" class="form-control" name="" placeholder="No Kad Pengenalan">
                                                                </div>
                                                                <button type="submit" class="btn btn-primary pull-right">Tambah</button>
                                                            </div>
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="peserta_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Nama Perserta</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">No Kad Pengenalan</font></label></th>
                                                                        <th width="12%"><label class="form-label"><font color="#113f50"></font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                            <br><br>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Pembelanjaan Projek : <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="" placeholder="Pembelanjaan Projek">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Pendapatan Hasil Projek : <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="" placeholder="Pendapatan Hasil Projek">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Jumlah Sumbangan Kepada Tabung Rukun Tetangga (RM / %) : <span class="text-red">*</span></label>
                                                            <textarea class="form-control" rows="4"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm10.senarai_laporan_projek_ekonomi')}}';"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                            <button type="button" class="btn btn-secondary">Simpan</button>
                                            <button type="button" class="btn btn-primary">Hantar&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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
@stop

@include('js.rt-sm10.j-add-laporan-projek-ekonomi')
