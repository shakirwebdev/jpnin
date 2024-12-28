@extends('layout.master')
@section('title', 'MENYEMAK PERANCANGAN AKTIVTI DAN PERKHIDMATAN SKUAD UNITI')


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
                                                <h6><b>MAKLUMAT AM SEJIWA</b></h6>
                                                <br>
                                                <div class="form-group">
                                                    <label class="form-label">Negeri: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Negeri" value="Perlis" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Daerah: <span class="text-red">*</span></label>
                                                    <select class="form-control" disabled="">
                                                        <option>Kangar</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Nama Cawangan Jiran Wanita: <span class="text-red">*</span></label>
                                                    <select class="form-control" disabled="">
                                                        <option>Jiran Wanita Kuala Perlis</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Pusat Operasi SeJIWA: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Pusat Operasi SeJIWA" value="Dewan Orang Ramai Taman Pelandang Jaya" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <b>Tarikh Penubuhan SeJIWA</b>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                        <input type="text" name="" class="form-control" placeholder="Tarikh Penubuhan Skuad" value="1/1/2006" disabled="">
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
                                                <h6><b>MAKLUMAT STATUS SEMAKAN PERANCANGAN</b></h6>
                                                <br><br>
                                                <div class="form-group">
                                                    <label class="form-label">Status: <span class="text-red">*</span></label>
                                                    <select class="form-control">
                                                        <option>-- Sila Pilih --</option>
                                                        <option>Disemak</option>
                                                        <option>Ditolak</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Catatan: </label>
                                                    <textarea class="form-control" id="" name="" rows="4"></textarea>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                <button type="submit" class="btn btn-secondary pull-right" disabled="">Hantar</button>
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
                                            <h6><b>MAKLUMAT PROFIL SEJIWA</b></h6>
                                            <br>
                                            <p>A. Jawatan Kuasa Utama</p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Senarai Ahli SeJIWA: <span class="text-red">(Minima : 20 Orang)</span></label>
                                                        </div>
                                                        <br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_ahli_sejiwa_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%" rowspan="2"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th colspan="3"><label class="form-label text-center"><font color="#113f50">Butiran</font></label></th>
                                                                        <th rowspan="2"><label class="form-label"><font color="#113f50">Kaum</font></label></th>
                                                                        <th rowspan="2"><label class="form-label"><font color="#113f50">Jawatan</font></label></th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th><label class="form-label"><font color="#113f50">Nama</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">No.K/P</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Pekerjaan</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <label class="form-label">Bidang / Jenis Fokus Perkhidmatan SeJiwa: <span class="text-red"><br><i>(Berdasarkan Isu/keperluan utama yang telah dikenalpasti dalam komuniti setempat)</i></span></label>
                                            </div>
                                            <br/>
                                            <div class="table-responsive">
                                                <table class="table thead-dark table-bordered table-striped" id="jenis_perkhidmatan_table" style="width: 100%" border="1">
                                                    <thead>
                                                        <tr>
                                                            <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                            <th><label class="form-label text-center"><font color="#113f50">Keperluan / Masalah / Isu</font></label></th>
                                                            <th><label class="form-label"><font color="#113f50">Jenis Aktiviti / Perkhidmatan SeJIWA (PENUMPUAN)</font></label></th>
                                                            <th><label class="form-label"><font color="#113f50">KERJASAMA (Agensi dan bentuk kerjasama)</font></label></th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <label class="form-label">Kelebihan Yang Dipunyai SeJIWA Untuk Manfaat Komuniti: <span class="text-red">*</span></label>
                                                <textarea class="form-control" id="" name="" disabled="" rows="4">Memberi kesedaran dan manfaat kepada masyarakat</textarea>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm10.menyemak_perancangan_aktivti_sejiwa')}}';"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                        <button type="button" class="btn btn-primary" onclick="window.location.href = '{{route('rt-sm10.menyemak_perancangan_aktivti_sejiwa_ppn_1')}}';">Seterusnya&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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

@include('js.rt-sm10.j-menyemak-perancangan-aktivti-sejiwa-ppn')
