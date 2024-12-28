@extends('layout.master')
@section('title', 'Semak Permohonan Penubuhan SRS')


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
                                                <h6><b>MAKLUMAT KAWASAN RUKUN TETANGGA (KRT)</b></h6>
                                                <br>
                                                <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b>KRT Taman Peladang Jaya</b></p>
                                                <br>
                                                <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b>No 10 Lorong 5,<br>Taman Peladang Jaya,<br>02000 Kuala Perlis</b></p>
                                                <br>
                                                <p><span style="font-size:12px">Negeri</span><br><b>Perlis</b></p>
                                                <br>
                                                <p><span style="font-size:12px">Daerah</span><br><b>Kangar</b></p>
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
                                                    <input type="text" class="form-control" name="" placeholder="Nama Pemohon" value="Mohamad Shauki Bin Sahardi" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Kad Pengenalan: </label>
                                                    <input type="text" class="form-control" name="" placeholder="No Kad Pengenalan" value="930508-09-5161" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Alamat: </label>
                                                    <textarea class="form-control" id="" name="" rows="4" disabled="">
No, 10 Lorong 5,
Taman Peladang Jaya,
02000 Kuala Perlis, Perlis
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT STATUS AKUAN TERIMA PERMOHONAN</b></h6>
                                                <br><br>
                                                <div class="form-group">
                                                    <label class="form-label">Status Permohonan: <span class="text-red">*</span></label>
                                                    <select class="form-control" disabled="">
                                                        <option>-- Sila Pilih --</option>
                                                        <option>Lengkap</option>
                                                        <option>Tidak Lengkap</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Dokumen Yang Belum Diterima: <span class="text-red">*</span></label>
                                                    <div class="custom-controls-stacked">
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="" disabled="">
                                                            <span class="custom-control-label">(a) Borang SRS 01</span>
                                                        </label>
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="" disabled="">
                                                            <span class="custom-control-label">(b) Borang SRS 02</span>
                                                        </label>
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="" disabled="">
                                                            <span class="custom-control-label">(c) Plan Lakar dan Diskripsi Sempadan</span>
                                                        </label>
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="" disabled="">
                                                            <span class="custom-control-label">(d) Minit Mesyuarat JawatanKuasa</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group pull-right">
                                                        <button type="submit" class="btn btn-secondary" disabled="">Hantar&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <h6><b>MAKLUMAT SKIM RONDAAN SUKARELA YANG DICADANGKAN</b></h6>
                                                <br>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">Cadangan Nama SRS: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" value="SRS Taman Peladang Jaya" placeholder="Cadangan Nama SRS" disabled="">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">Bilangan Peronda: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" value="26" placeholder="Bilangan Peronda" disabled="">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">Senarai Peronda: <span class="text-red">*</span></label>
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
                                                <div class="form-group">
                                                    <label class="form-label">Permohonan Rondaan dan kawalan SRS meliputi: <span class="text-red">*</span></label>
                                                </div>
                                                <div class="form-group">
                                                    <div class="custom-controls-stacked">
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="" checked="" disabled="">
                                                            <span class="custom-control-label">(i) Keseluruhan Kawasan Rukun Tertangga</span>
                                                        </label>
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="" disabled="">
                                                            <span class="custom-control-label">(ii) Sebahagian Kawasan Rukun Tertangga</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label"><span class="text-red">Sila lampirkan pelan lakar dan diskripsi sempadan kawasan rondaan dan kawalan tersebut</span></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Pelan Lakar : </label>
                                                    <iframe src="https://www.andrewchoo.edu.my/wp-content/uploads/2017/07/PANDUAN-PETA-LAKAR.pdf" title="W3Schools Free Online Web Tutorials" width="100%" height="400"></iframe>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Maklumat Peronda Sukarela : <span class="text-red">(minimun 20 org) *</span></label>
                                                </div>
                                                <br>
                                                <div class="table-responsive">
                                                    <table class="table thead-dark table-bordered table-striped" id="peronda_sukarela_table" style="width: 100%" border="1">
                                                        <thead>
                                                            <tr>
                                                                <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">Nama</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">No kad Pengenalan</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">Jantina</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">Alamat Kediaman</font></label></th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm12.jana_surat_terima_permohonan_srs')}}';"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="button" class="btn btn-primary" onclick="window.location.href = '{{route('rt-sm12.surat_terima_penubuhan_srs_ppd_2')}}';">Seterusnya&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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
@stop

@include('js.rt-sm12.j-surat-terima-penubuhan-srs-ppd-1')
