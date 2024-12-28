@extends('layout.master')
@section('title', 'Permohonan Laporan Kes Mediasi')


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
    <div class="section-body mt-3" style="display:none;" id="plmmkp_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert" >
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> 
                                <span class="text-red blink" id="plmmkp_status_description" name="plmmkp_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> 
                                <span id="plmmkp_disokong_note" name="plmmkp_disokong_note"></span></span>
                                <span id="plmmkp_disokong_p_note" name="plmmkp_disokong_p_note"></span></span>
                                <span id="plmmkp_disahkan_note" name="plmmkp_disahkan_note"></span></span>
                                <span id="plmmkp_disemak_note" name="plmmkp_disemak_note"></span></span>
                                <span id="plmmkp_diluluskan_note" name="plmmkp_diluluskan_note"></span></span>.
                                <br>
                                <input type="hidden" name="plmmkp_status" id="plmmkp_status">
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
                                                <h6><b>MAKLUMAT MEDIATOR</b></h6>
                                                <br>
                                                <div class="form-group">
                                                    <label class="form-label">Nama: </label>
                                                    <input type="text" class="form-control" name="plmmkp_mkp_nama" id="plmmkp_mkp_nama" placeholder="Nama" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Kad Pengenalan: </label>
                                                    <input type="text" class="form-control" name="plmmkp_mkp_ic" id="plmmkp_mkp_ic" placeholder="No Kad Pengenalan" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Telefon: </label>
                                                    <input type="text" class="form-control" name="plmmkp_mkp_phone" id="plmmkp_mkp_phone" placeholder="No Telefon" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <form method="POST" id="form_plmmkp1">
                                                @csrf
                                                    <h6><b>MAKLUMAT PEMBANTU MEDIATOR</b></h6>
                                                    <span class="text-red" style="font-size:12px">*** Sekiranya ada</span>
                                                    <br>
                                                    <br>
                                                    <div class="form-group">
                                                        <label class="form-label">Nama: </label>
                                                        <input type="text" class="form-control" name="plmmkp1_mediasi_pembantu_nama" id="plmmkp1_mediasi_pembantu_nama" placeholder="Nama" >
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Kad Pengenalan: </label>
                                                        <input type="text" class="form-control" name="plmmkp1_mediasi_pembantu_ic" id="plmmkp1_mediasi_pembantu_ic" placeholder="XXXXXXXXXXXX" >
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Telefon: </label>
                                                        <input type="text" class="form-control" name="plmmkp1_mediasi_pembantu_phone" id="plmmkp1_mediasi_pembantu_phone" placeholder="No Telefon" >
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <h6><b>MAKLUMAT KES MEDIASI</b></h6>
                                            <br>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <form method="POST" id="form_plmmkp2">
                                                @csrf
                                                    <div class="row clearfix">
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Kluster / Bidang: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="plmmkp2_ref_mkp_kategori_id" id="plmmkp2_ref_mkp_kategori_id">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($mediasi_kluster as $item)                                    
                                                                        <option value="{{ $item->id }}">{{ $item->kluster_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_plmmkp2_ref_mkp_kategori_id invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <b>Tarikh Mediasi: <span class="text-red">*</span></b>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                    </div>
                                                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="plmmkp2_mediasi_tarikh" id="plmmkp2_mediasi_tarikh" placeholder="Tarikh Mediasi" data-date-format="dd/mm/yyyy">
                                                                </div>
                                                                <div class="error_plmmkp2_mediasi_tarikh invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Tempat Mediasi: <span class="text-red">*</span></label>
                                                                <textarea class="form-control" rows="4" name="plmmkp2_mediasi_alamat" id="plmmkp2_mediasi_alamat" placeholder="Tempat Mediasi"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <form action="#" id="form_pkkmkp3">
                                                    {{ csrf_field() }}
                                                    <div class="row clearfix">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Pihak-Pihak Terlibat: <span class="text-red">*</span></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 alert alert-danger error_alert_form_pkkmkp3" role="alert" style="display: none; padding-bottom: 0px;">
                                                            <ul></ul>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="series-frame">
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Pihak Pertama: </label>
                                                                        <input type="text" class="form-control" name="pkkmkp3_pihak_pertama" id="pkkmkp3_pihak_pertama" placeholder="Pihak Pertama">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Pihak Kedua: </label>
                                                                        <input type="text" class="form-control" name="pkkmkp3_pihak_kedua" id="pkkmkp3_pihak_kedua" placeholder="Pihak Kedua">
                                                                    </div>
                                                                    <input type="hidden" name="pkkmkp3_spk_imediator_mediasi_id" id="pkkmkp3_spk_imediator_mediasi_id">
                                                                    <input type="hidden" name="post_add_pihak_terlibat_laporan_mediasi" value="add">
                                                                    <button type="submit" class="btn btn-primary pull-right" id="btn_save">Tambah</button>
                                                                </div>
                                                            </div>
                                                            <br/><br/>
                                                            <div class="table-responsive">
                                                                <table class="table thead-dark table-bordered table-striped" id="senarai_pihak_terlibat_table" style="width: 100%" border="1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Pihak Pertama</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Pihak Kedua</font></label></th>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <form method="POST" id="form_plmmkp4">
                                                @csrf
                                                    <div class="row clearfix">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Agensi / NGO Terlibat: <span class="text-red">(sekiranya ada)</span></label>
                                                                <input type="text" class="form-control" name="plmmkp4_mediasi_ngo_terlibat" id="plmmkp4_mediasi_ngo_terlibat" placeholder="Agensi / NGO Terlibat">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Ringkasan Kes / Isu: <span class="text-red">*</span></label>
                                                                <textarea class="form-control" rows="4" name="plmmkp4_mediasi_ringkasan_kes" id="plmmkp4_mediasi_ringkasan_kes" placeholder="Ringkasan Kes / Isu"></textarea>
                                                                <div class="error_plmmkp4_mediasi_ringkasan_kes invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Peringkat Kes: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="plmmkp4_peringkat_kes_id" id="plmmkp4_peringkat_kes_id">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($peringkat_kes as $item)                                    
                                                                        <option value="{{ $item->id }}">{{ $item->peringkat_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_plmmkp4_peringkat_kes_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Status Kes: <span class="text-red">*</span></label>
                                                                <select class="form-control" id="plmmkp4_mediasi_status_kes" name="plmmkp4_mediasi_status_kes">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    <option value="Selesai">Selesai</option>
                                                                    <option value="Tidak Selesai">Tidak Selesai</option>
                                                                </select>
                                                                <div class="error_plmmkp4_mediasi_status_kes invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group" style="display:none;" id="mediasi_note_penyelesaian_kes">
                                                                <label class="form-label">Nyatakan Terma-Terma Penyelesaian Kes/Isu: <span class="text-red">*</span></label>
                                                                <textarea class="form-control" rows="4" name="plmmkp4_mediasi_note_penyelesaian_kes" id="plmmkp4_mediasi_note_penyelesaian_kes" placeholder="Nyatakan Terma-Terma Penyelesaian Kes/Isu"></textarea>
                                                                <div class="error_plmmkp4_mediasi_note_penyelesaian_kes invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group" style="display:none;" id="mediasi_note_sebab_kes_xberjaya">
                                                                <label class="form-label">Nyatakan Ulasan /  Sebab-Sebab: <span class="text-red">*</span></label>
                                                                <textarea class="form-control" rows="4" name="plmmkp4_mediasi_note_sebab_kes_xberjaya" id="plmmkp4_mediasi_note_sebab_kes_xberjaya" placeholder="Nyatakan Ulasan /  Sebab-Sebab"></textarea>
                                                                <div class="error_plmmkp4_mediasi_note_sebab_kes_xberjaya invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <form method="POST" id="form_plmmkp5">
                                            @csrf
                                                <input type="hidden" name="plmmkp5_spk_imediator_mediasi_id" id="plmmkp5_spk_imediator_mediasi_id">
                                                <input type="hidden" name="post_permohonan_laporan_mediasi_1" value="edit">
                                                <input type="hidden" name="action" id="post_permohonan_laporan_mediasi_1" value="edit">
                                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="submit" class="btn btn-primary" id="btn_submit">Hantar Permohonan Pelaporan Kes Mediasi&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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

@include('js.rt-sm23.j-permohonan-laporan-mediasi-mkp')
