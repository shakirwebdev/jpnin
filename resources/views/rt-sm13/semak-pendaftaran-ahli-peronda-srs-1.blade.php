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
                                                    <select class="form-control" disabled="">
                                                        <option>-- Sila Pilih --</option>
                                                        <option>Disemak</option>
                                                        <option>Perlu Dikemaskini</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Penerangan: <span class="text-red">*</span></label>
                                                    <textarea class="form-control" rows="4" disabled=""></textarea>
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
                                                <h6><b>MAKLUMAT PEMOHON AHLI PERONDA SRS</b></h6>
                                                <br>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">Nama Penuh: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Nama Penuh" value="Mohamad Shauki Bin Sahardi" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Umur: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Umur" value="27" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Kaum: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Kaum" value="Melayu" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Jantina: <span class="text-red">*</span></label>
                                                    <select class="form-control" disabled="">
                                                        <option>Lelaki</option>
                                                        <option>Perempuan</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Warganegara: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Warganegara" value="Malaysia" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Telefon: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="No Telefon" value="012-4470470" disabled="">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">No Kad Pengenalan: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="No Kad Pengenalan" value="930508095161" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Alamat: <span class="text-red">*</span></label>
                                                    <textarea class="form-control" rows="5" disabled=""></textarea>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="form-label">Poskod: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Poskod" disabled="02000">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">Pendidikan: <span class="text-red">*</span></label>
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-vcenter table-hover mb-0" id="pendidikan_table" style="width: 100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Peringatan</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm13.semak_pendaftaran_ahli_peronda_srs')}}';"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="button" class="btn btn-primary" onclick="window.location.href = '{{route('rt-sm13.semak_pendaftaran_ahli_peronda_srs_2')}}';">Seterusnya&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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

@include('js.rt-sm13.j-semak-pendaftaran-ahli-peronda-srs-1')
