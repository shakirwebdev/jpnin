@extends('layout.master')
@section('title', 'Permohonan Keaktifan Mediator Komuniti')


@section('content')
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
    <div class="section-body mt-3" style="display:none;" id="mkm_status_alert">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" id="alert_status_permohonan" role="alert" >
                            <div class="mb-10">
                                <code><span style="font-size: 16px;"><strong>No Rujukan MKP : <span id="mkm_no_rujukan_mkp" name="mkm_no_rujukan_mkp"></span></span></strong></span></code>
                                <br><br>
                                <span style="display:none;" id="mkm_status_mkp">
                                <code><span style="font-size: 16px;"><strong>Status MKP : <span class="blink" id="mkm_status_mkp_description" name="mkm_status_mkp_description"></span></span></strong></code>
                                <br><br>
                                Permohonan Mediator Komuniti sedang dalam proses tindakan Pegawai Perpaduan.
                                <br>
                                Sepanjang proses permohonan Mediator Komuniti ini, Process Pengisian maklumat ini akan dikunci untuk seketika sehingga Permohonan Mediator Komuniti (MKP) dilantik oleh KP. 
                                </span>
                                <span style="display:none;" id="mkm_status_permohonan">
                                <code><span style="font-size: 16px;"><strong>Status : <span class="blink" id="mkm_status_description" name="mkm_status_description"></span></span></strong></code>
                                <br><br>
                                Permohonan Keaktifan Mediator Komuniti sedang dalam proses tindakan Pegawai Perpaduan.
                                <br>
                                <br>
                                Sepanjang proses tindakan Pegawai Perpaduan ini, maklumat yang dibekalkan dikunci untuk seketika. Maklumat ini akan dapat diubah sekiranya terdapat maklumbalas daripada pihak Pegawai Perpaduan untuk dikemaskini oleh pihak MKP. 
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section-body mt-3" style="display:none;" id="mkm_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert" >
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> 
                                <span class="text-red blink" id="mkm_status_description_1" name="mkm_status_description_1"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> 
                                <span id="mkm_disokong_note" name="mkm_disokong_note"></span></span>
                                <span id="mkm_disokong_p_note" name="mkm_disokong_p_note"></span></span>
                                <span id="mkm_disahkan_note" name="mkm_disahkan_note"></span></span>.
                                <br>
                                <input type="hidden" name="mkm_status" id="mkm_status">
                            </div>
                        </div>
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
                                                <h6><b>MAKLUMAT MKP</b></h6>
                                                <br>
                                                <div class="form-group">
                                                    <label class="form-label">Nama: </label>
                                                    <input type="text" class="form-control" name="mkm_mkp_nama" id="mkm_mkp_nama" placeholder="Nama" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Kad Pengenalan: </label>
                                                    <input type="text" class="form-control" name="mkm_mkp_no_ic" id="mkm_mkp_no_ic" placeholder="No Kad Pengenalan" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Telefon: </label>
                                                    <input type="text" class="form-control" name="mkm_mkp_no_phone" id="mkm_mkp_no_phone" placeholder="No Telefon" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Alamat Email: </label>
                                                    <input type="text" class="form-control" name="mkm_mkp_email" id="mkm_mkp_email" placeholder="Alamat Email" disabled>
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
                                            <h6><b>MAKLUMAT KRITERIA PENILAIAN KEAKTIFAN MEDIATOR</b></h6>
                                            <br>
                                            <p>1. Kes Mediasi Yang Telah Dikendalikan: <span class="pull-right"><b>Jumlah Kes : <span id="total_kes" name="total_kes"></span></b></span></p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_kes_mediasi_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Bil</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Kes Mediasi</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Status</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Peringkat</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br><br>
                                            <p>2. Aktiviti / Program Sosial / Kemasyarakatan: </p>
                                            <span class="text-red"><b>*** Sekurang-kurangnya 2 Aktiviti/Program Yang Dikendalikan</b></span>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <form action="#" id="form_pkkmkp2">
                                                        {{ csrf_field() }}
                                                            <div class="col-md-12 alert alert-danger error_alert_pkkmkp2" role="alert" style="display: none; padding-bottom: 0px;">
                                                                <ul></ul>
                                                            </div>
                                                            <div class="series-frame">
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Nama Aktiviti / Program: <span class="text-red">*</span></label>
                                                                        <input type="text" class="form-control" name="pkkmkp2_aktiviti_nama" id="pkkmkp2_aktiviti_nama" placeholder="Nama Aktiviti / Program">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <b>Tarikh: <span class="text-red">*</span></b>
                                                                        <div class="input-group mb-3">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                            </div>
                                                                            <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="pkkmkp2_aktiviti_tarikh" id="pkkmkp2_aktiviti_tarikh" placeholder="Tarikh" data-date-format="dd/mm/yyyy">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Tempat: <span class="text-red">*</span></label>
                                                                        <input type="text" class="form-control" name="pkkmkp2_aktiviti_tempat" id="pkkmkp2_aktiviti_tempat" placeholder="Tempat">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Jawatan: <span class="text-red">*</span></label>
                                                                        <input type="text" class="form-control" name="pkkmkp2_aktiviti_jawatan" id="pkkmkp2_aktiviti_jawatan" placeholder="Jawatan">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Peringkat: <span class="text-red">*</span></label>
                                                                        <select class="form-control" name="pkkmkp2_ref_peringkat_id" id="pkkmkp2_ref_peringkat_id">
                                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                            @foreach($mediasi_peringkat as $item)                                    
                                                                                <option value="{{ $item->id }}">{{ $item->peringkat_description }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <input type="hidden" name="pkkmkp2_spk_imediator_id" id="pkkmkp2_spk_imediator_id">
                                                                    <input type="hidden" name="post_add_keaktifan_aktiviti_mkp" value="add">
                                                                    <button type="submit" class="btn btn-primary pull-right" id="btn_save"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                                </div>
                                                            </div>
                                                            <br/><br/>
                                                            <div class="table-responsive">
                                                                <table class="table thead-dark table-bordered table-striped" id="senarai_aktiviti_table" style="width: 100%" border="1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="background-color: #113f50"><label class="form-label"><font color="white">Bil</font></label></th>
                                                                            <th style="background-color: #113f50"><label class="form-label"><font color="white">Nama Aktiviti</font></label></th>
                                                                            <th style="background-color: #113f50"><label class="form-label"><font color="white">Tarikh</font></label></th>
                                                                            <th style="background-color: #113f50"><label class="form-label"><font color="white">Tempat</font></label></th>
                                                                            <th style="background-color: #113f50"><label class="form-label"><font color="white">Jawatan</font></label></th>
                                                                            <th style="background-color: #113f50"><label class="form-label"><font color="white">Peringkat</font></label></th>
                                                                            <th style="background-color: #113f50"><label class="form-label"><font color="white">Tindakan</font></label></th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <br><br>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <form method="POST" id="form_pkkmkp3">
                                            @csrf
                                                <input type="hidden" name="pkkmkp3_spk_mkp_keaktifan_id" id="pkkmkp3_spk_mkp_keaktifan_id">
                                                <input type="hidden" name="post_permohonan_mkp_keaktifan_1" value="edit">
                                                <input type="hidden" name="action" id="post_permohonan_mkp_keaktifan_1" value="edit">
                                                <button type="button" class="btn btn-secondary" disabled id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="button" class="btn btn-primary" id="btn_next">Seterusnya&nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
                                            </form>
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
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@stop

@include('js.rt-sm23.j-mohon-keaktifan-mkp')
