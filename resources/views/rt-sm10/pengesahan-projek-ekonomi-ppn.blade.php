@extends('layout.master')
@section('title', 'PENGESAHAN PERMOHONAN PROJEK EKONOMI RUKUN TETANGGA BAHARU')


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
                                                <h6><b>MAKLUMAT AM PERMOHONAN PROJEK EKONOMI RT</b></h6>
                                                <br>
                                                <div class="form-group">
                                                    <label class="form-label">Tahun : </label>
                                                    <select class="form-control" disabled="">
                                                        <option>2020</option>
                                                    </select>
                                                </div>
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT STATUS SEMAKAN</b></h6>
                                                <br><br>
                                                <div class="form-group">
                                                    <label class="form-label">Status: <span class="text-red">*</span></label>
                                                    <select class="form-control">
                                                        <option>-- Sila Pilih --</option>
                                                        <option>Disahkan</option>
                                                        <option>Ditolak</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Penerangan: <span class="text-red">*</span></label>
                                                    <textarea class="form-control" rows="4"></textarea>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group pull-right">
                                                        <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm10.senarai_pengesahan_projek_ekonomi_ppn')}}';"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                        <button type="submit" class="btn btn-primary">Hantar&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <h6><b>MAKLUMAT PROJEK EKONOMI RT</b></h6>
                                            <br>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Nama Projek Ekonomi : </label>
                                                            <input type="text" class="form-control" name="" placeholder="Nama Projek Ekonomi" value="Membangun Dewan Rakyat" disabled="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Penerangan ringkas mengenai projek : </label>
                                                            <textarea class="form-control" rows="4" disabled="">Test</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Status Pelaksanaan : <span class="text-red">*</span></label>
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="" checked disabled="">
                                                                    <span class="custom-control-label">Belum Dilaksanakan</span>
                                                                </label>
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="" disabled="">
                                                                    <span class="custom-control-label">Sedang Dilaksanakan</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Sekala Projek (semasa) : <span class="text-red">*</span></label>
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="" disabled checked>
                                                                    <span class="custom-control-label">Kecil (Pendapatan RM1000 ke bawah)</span>
                                                                </label>
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="" disabled="">
                                                                    <span class="custom-control-label">Sederhana (Pendapatan RM1000 - RM3000)</span>
                                                                </label>
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="" disabled="">
                                                                    <span class="custom-control-label">Besar (Pendapatan RM3000 ke atas)</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Sekala Projek (sasaran masa hadapan) : <span class="text-red">*</span></label>
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="" disabled checked>
                                                                    <span class="custom-control-label">Kecil (Pendapatan RM1000 ke bawah)</span>
                                                                </label>
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="" disabled>
                                                                    <span class="custom-control-label">Sederhana (Pendapatan RM1000 - RM3000)</span>
                                                                </label>
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="" disabled>
                                                                    <span class="custom-control-label">Besar (Pendapatan RM3000 ke atas)</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Jaringan kerjasama dan jenis bantuan yang diterima : <span class="text-red">*</span></label>
                                                            <textarea class="form-control" rows="4" disabled="">Test</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Peserta projek dan bilangan peserta yang terlibat : <span class="text-red">* <br>(Sila nyatakan jika AJK, Jiran Wanita, Jiran Muda, Jiran Usia Emas, Tunas Jiran, Terbuka)</span></label>
                                                            <textarea class="form-control" rows="4" disabled="">Test</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Tahun Mula Projek : </label>
                                                            <input type="text" class="form-control" name="" placeholder="Tahun Mula Projek" disabled="" value="2020">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Impak Kepada Komuniti : </label>
                                                            <input type="text" class="form-control" name="" placeholder="Impak Kepada Komuniti" disabled="" value="Test">
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
@stop

@include('js.rt-sm10.j-pengesahan-projek-ekonomi-ppn')
