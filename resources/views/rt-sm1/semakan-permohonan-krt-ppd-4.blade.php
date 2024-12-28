@extends('layout.master')
@section('parentPageTitle', 'HRMS')
@section('title', 'Semakan Permohonan Penubuhan Kawasan Rukun Tetangga Baharu')

@section('content')
@include('modal.modal-view-binaan-jambatan')
@include('modal.modal-view-bagunan-tumpang')
@include('modal.modal-view-kabin-sedia-ada')
@include('modal.modal-view-cadangan-pembinaan-prt')
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
                        <small>Sila semak maklumat pada borang yang dihantar dibawah, dan tekan butang Seterusnya untuk paparan yang seterusnya. 
                        <br>
                        Ruangan maklumat status pengesahan <span class="text-red">*</span> adalah ruangan mandatori dan perlu diisi dan ianya dapat diisi apabila paparan tersebut adalah yang terakhir..&nbsp;&nbsp;<a href="#"><i class="dropdown-icon fe fe-help-circle"></i></a></small>
                    </div>                       
                </div>
            </div>
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="user-list" role="tabpanel">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT PERMOHONAN KRT</b></h6>
                                                <br>
                                                <p><span style="font-size:12px">Cadangan Nama KRT</span><br><b><span name="kpk_krt_nama" id="kpk_krt_nama"></span></b></p>
                                                <br>
                                                <p><span style="font-size:12px">Cadangan Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span name="kpk_krt_alamat" id="kpk_krt_alamat"></span></b></p>
                                                <br>
                                                <p><span style="font-size:12px">Tarikh Permohonan</span><br><b><span name="kpk_tarikh_memohon" id="kpk_tarikh_memohon"></span></b></p>
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
                                                    <input type="text" class="form-control" name="kpk_pemohon_name" id="kpk_pemohon_name" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Kad Pengenalan: </label>
                                                    <input type="text" class="form-control" name="kpk_pemohon_ic" id="kpk_pemohon_ic" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Alamat: </label>
                                                    <textarea class="form-control" name="kpk_pemohon_alamat" id="kpk_pemohon_alamat" rows="4" disabled=""></textarea>
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
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <h6><b>MAKLUMAT ASAS KAWASAN</b></h6>
                                            <br>
                                            <p>6. Maklumat Bangunan Operasi Rukun Tetangga</p>
                                            <hr class="mt-1">
                                            <br>
                                            <div class="row clearfix">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">1. Status Bangunan Sedia Ada: </label>
                                                        <select class="form-control" name="spkp4_krt_status_bagunan_id" id="spkp4_krt_status_bagunan_id" disabled>
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            @foreach($ref_status_bagunan as $item)                                    
                                                                <option value="{{ $item->id }}">{{ $item->status_bagunan_description }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="for_binaan" style="display:none;">
                                                        <div class="form-group">
                                                            <div class="table-responsive">
                                                                <table class="table thead-dark table-bordered table-striped" id="senarai_binaan_table" style="width: 100%" border="1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="6%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Jenis Premis</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Alamat</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Isu</font></label></th>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="for_tumpang" style="display:none;">
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_bagunan_tumpang_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Jenis Premis</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Alamat</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <br>
                                                     <div class="form-group">
                                                        <label class="form-label">2. Status Kabin Sedia Ada: </label>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table thead-dark table-bordered table-striped" id="senarai_kabin_table" style="width: 100%" border="1">
                                                            <thead>
                                                                <tr>
                                                                    <th width="6%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Jenis Kabin</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Alamat</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Anggaran Kos Kabin</font></label></th>
                                                                    <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                    <br>
                                                    <div class="form-group">
                                                        <label class="form-label">3. Cadangan Pembinaan PRT / Kompleks Perpaduan / Kabin (tiada had tahun): </label>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table thead-dark table-bordered table-striped" id="cadangan_pembinaan_table" style="width: 100%" border="1">
                                                            <thead>
                                                                <tr>
                                                                    <th width="6%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Jenis Premis</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Alamat</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Tarikh Mula Bina Bangunan</font></label></th>
                                                                    <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <br><br>
                                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>&nbsp;
                                                <button type="submit" class="btn btn-primary" id="btn_next">Seterusnya&nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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

@include('js.rt-sm1.j-semakan-permohonan-krt-ppd-4')