@extends('layout.master')
@section('title', 'Profil SRS')


@section('content')
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
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <h6><b>MAKLUMAT KAWASAN RUKUN TETANGGA (KRT)</b></h6>
                                                    <br><br>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="psp_1_nama_krt" name="psp_1_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="psp_1_alamat_krt" name="psp_1_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="psp_1_negeri_krt" name="psp_1_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="psp_1_parlimen_krt" name="psp_1_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="psp_1_pbt_krt" name="psp_1_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="psp_1_daerah_krt" name="psp_1_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="psp_1_dun_krt" name="psp_1_dun_krt"></span></b></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT PEMOHON</b></h6>
                                                <br>
                                                <div class="form-group">
                                                    <label class="form-label">Nama Pemohon: </label>
                                                    <input type="text" class="form-control" name="psp_1_nama_pemohon" id="psp_1_nama_pemohon" placeholder="Nama Pemohon" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Kad Pengenalan: </label>
                                                    <input type="text" class="form-control" name="psp_1_ic_pemohon" id="psp_1_ic_pemohon" placeholder="No Kad Pengenalan" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Alamat: </label>
                                                    <textarea class="form-control" id="psp_1_address_pemohon" name="psp_1_address_pemohon" rows="4" disabled=""></textarea>
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
                                            <h6><b>MAKLUMAT SKIM RONDAAN SUKARELA</b></h6>
                                            <br>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <p>1. Maklumat Asas</p>
                                            <hr class="mt-1">
                                            <div class="row clearfix">
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Cadangan Nama SRS: </label>
                                                        <input type="text" class="form-control" name="psp_1_nama_srs" id="psp_1_nama_srs" disabled="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Bilangan Peronda: </label>
                                                        <input type="text" class="form-control" name="psp_1_jumlah_peronda" id="psp_1_jumlah_peronda" disabled="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Permohonan Rondaan dan kawalan SRS meliputi: </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="custom-controls-stacked">
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input" name="psp_1_srs_kawalan" value="1" disabled>
                                                                <div class="custom-control-label">(i) Keseluruhan Kawasan Rukun Tertangga</div>
                                                            </label>
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input" name="psp_1_srs_kawalan" value="2" disabled>
                                                                <div class="custom-control-label">(ii) Sebahagian Kawasan Rukun Tertangga</div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <p>2. Maklumat Peronda</p>
                                            <hr class="mt-1">
                                            <div class="row clearfix">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Senarai Peronda: </label>
                                                    </div>
                                                    <br>
                                                    <div class="table-responsive">
                                                        <table class="table thead-dark table-bordered table-striped" id="senarai_peronda_table" style="width: 100%" border="1">
                                                            <thead>
                                                                <tr>
                                                                    <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Nama Ahli</font></label></th>
                                                                    <th width="30%"><label class="form-label"><font color="#113f50">No Kad</font></label></th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <p>3. Maklumat Peronda Sukarela</p>
                                            <hr class="mt-1">
                                            <div class="row clearfix">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Maklumat Peronda Sukarela : </label>
                                                    </div>
                                                    <br>
                                                    <div class="table-responsive">
                                                        <table class="table thead-dark table-bordered table-striped" id="senarai_peronda_sukarela_table" style="width: 100%" border="1">
                                                            <thead>
                                                                <tr>
                                                                    <th><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Nama</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">No kad Pengenalan</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Jantina</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Pekerjaan</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Alamat Kediaman</font></label></th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                            <button type="button" class="btn btn-primary" id="btn_next">Seterusnya&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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

@include('js.rt-sm12.j-profile-srs-p-1')
