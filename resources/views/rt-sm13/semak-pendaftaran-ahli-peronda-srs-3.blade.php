@extends('layout.master')
@section('title', 'Semak Pendaftaran Ahli Peronda SRS')


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
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <h6><b>MAKLUMAT KAWASAN RUKUN TETANGGA (KRT)</b></h6>
                                                    <br><br>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b>KRT Taman Peladang Jaya</b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b>No 10 Lorong 5,<br>Taman Peladang Jaya,<br>02000 Kuala Perlis</b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b>Perlis</b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b>Kangar</b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b>Kuala Perlis</b></p>
                                                        <p><span style="font-size:12px">IPD</span><br><b>IPD KANGAR</b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b>Kangar</b></p>
                                                        <p><span style="font-size:12px">Mukim</span><br><b>Kuala Perlis</b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b>MPK</b></p>
                                                        <p><span style="font-size:12px">Balai Polis</span><br><b>Balai Polis Kuala Perlis</b></p>
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
                                                <h6><b>MAKLUMAT STATUS SEMAKAN</b></h6>
                                                <br><br>
                                                <div class="form-group">
                                                    <label class="form-label">Status: <span class="text-red">*</span></label>
                                                    <select class="form-control">
                                                        <option>-- Sila Pilih --</option>
                                                        <option>Disemak</option>
                                                        <option>Perlu Dikemaskini</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Penerangan: <span class="text-red">*</span></label>
                                                    <textarea class="form-control" rows="4"></textarea>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group pull-right">
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
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <h6><b>MAKLUMAT PEMOHON AHLI PERONDA SRS</b></h6>
                                                <br>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">AJK KRT: &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" disabled="">
                                                    <span class="custom-switch-indicator"></span>
                                                    </label>
                                                </div>
                                                <div class="series-frame">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <br/>
                                                            <label class="form-label">Jawatan: </label>
                                                            <input type="text" name="" class="form-control" value="" placeholder="Jawatan" disabled="">
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Tarikh Lantikan</b>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                                <input type="text" name="" class="form-control" value="" placeholder="Tarikh Lantikan" disabled="">
                                                                <div class="c_username invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Tarikh Tamat</b>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                                <input type="text" name="" class="form-control" value="" placeholder="Tarikh Tamat" disabled="">
                                                                <div class="c_username invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <br/>
                                                    </div>
                                                </div>
                                                <br/>
                                                <div class="form-group">
                                                    <label class="form-label">AJK SRS: &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" disabled="">
                                                    <span class="custom-switch-indicator"></span>
                                                    </label>
                                                </div>
                                                <div class="series-frame">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <br/>
                                                            <label class="form-label">Nama SRS: </label>
                                                            <input type="text" name="" class="form-control" value="" placeholder="Jawatan" disabled="">
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Tarikh Lantikan</b>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                                <input type="text" name="" class="form-control" value="" placeholder="Tarikh Lantikan" disabled="">
                                                                <div class="c_username invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <br/>
                                                    </div>
                                                </div>
                                                <br/>
                                                <div class="form-group">
                                                    <label class="form-label">Cawangan: &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" disabled="">
                                                    <span class="custom-switch-indicator"></span>
                                                    </label>
                                                </div>
                                                <div class="series-frame">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <br/>
                                                            <label class="form-label">Cawangan: </label>
                                                            <input type="text" name="" class="form-control" value="" placeholder="Cawangan" disabled="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Jawatan: </label>
                                                            <input type="text" name="" class="form-control" value="" placeholder="Jawatan" disabled="">
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Tarikh Lantikan</b>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                                <input type="text" name="" class="form-control" value="" placeholder="Tarikh Lantikan" disabled="">
                                                                <div class="c_username invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Tarikh Tamat</b>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                                <input type="text" name="" class="form-control" value="" placeholder="Tarikh Tamat" disabled="">
                                                                <div class="c_username invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <br/>
                                                    </div>
                                                </div>
                                                <br/>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm13.semak_pendaftaran_ahli_peronda_srs_2')}}';"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="button" class="btn btn-secondary" disabled="">Seterusnya&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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

@include('js.rt-sm13.j-pendaftaran-ahli-peronda-srs-1')
