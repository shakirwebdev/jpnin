@extends('layout.master')
@section('title', 'Laporan Kes Mediasi')


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
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT MEDIATOR</b></h6>
                                                <br>
                                                <div class="form-group">
                                                    <label class="form-label">Nama: </label>
                                                    <input type="text" class="form-control" name="lkmu_mkp_nama" id="lkmu_mkp_nama" placeholder="Nama" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Kad Pengenalan: </label>
                                                    <input type="text" class="form-control" name="lkmu_mkp_no_ic" id="lkmu_mkp_no_ic" placeholder="No Kad Pengenalan" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Telefon: </label>
                                                    <input type="text" class="form-control" name="lkmu_mkp_no_phone" id="lkmu_mkp_no_phone" placeholder="No Telefon" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT PEMBANTU MEDIATOR</b></h6>
                                                <br>
                                                <div class="form-group">
                                                    <label class="form-label">Nama: </label>
                                                    <input type="text" class="form-control" name="lkmu_mediasi_pembantu_nama" id="lkmu_mediasi_pembantu_nama" placeholder="Nama" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Kad Pengenalan: </label>
                                                    <input type="text" class="form-control" name="lkmu_mediasi_pembantu_ic" id="lkmu_mediasi_pembantu_ic" placeholder="XXXXXXXXXXXX" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Telefon: </label>
                                                    <input type="text" class="form-control" name="lkmu_mediasi_pembantu_phone" id="lkmu_mediasi_pembantu_phone" placeholder="No Telefon" disabled>
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
                                            <h6><b>MAKLUMAT KES MEDIASI</b></h6>
                                            <br>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Kluster / Bidang: </label>
                                                            <select class="form-control" name="lkmu_ref_mkp_kategori_id" id="lkmu_ref_mkp_kategori_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($mediasi_kluster as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->kluster_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <b>Tarikh Mediasi: </b>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                                <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="lkmu_mediasi_tarikh" id="lkmu_mediasi_tarikh" placeholder="Tarikh Mediasi" data-date-format="dd/mm/yyyy" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Tempat Mediasi: </label>
                                                            <textarea class="form-control" rows="4" name="lkmu_mediasi_alamat" id="lkmu_mediasi_alamat" placeholder="Tempat Mediasi" disabled></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Pihak-Pihak Terlibat: </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_pihak_terlibat_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Pihak Pertama</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Pihak Kedua</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Agensi / NGO Terlibat: </label>
                                                            <input type="text" class="form-control" name="lkmu_mediasi_ngo_terlibat" id="lkmu_mediasi_ngo_terlibat" placeholder="Agensi / NGO Terlibat" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Ringkasan Kes / Isu: </label>
                                                            <textarea class="form-control" rows="4" name="lkmu_mediasi_ringkasan_kes" id="lkmu_mediasi_ringkasan_kes" placeholder="Ringkasan Kes / Isu" disabled></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Status Kes: </label>
                                                            <select class="form-control" id="lkmu_mediasi_status_kes" name="lkmu_mediasi_status_kes" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                <option value="Berjaya">Berjaya</option>
                                                                <option value="Tidak Berjaya">Tidak Berjaya</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group" style="display:none;" id="mediasi_note_penyelesaian_kes">
                                                            <label class="form-label">Nyatakan Terma-Terma Penyelesaian Kes/Isu: </label>
                                                            <textarea class="form-control" rows="4" name="lkmu_mediasi_note_penyelesaian_kes" id="lkmu_mediasi_note_penyelesaian_kes" placeholder="Nyatakan Terma-Terma Penyelesaian Kes/Isu" disabled></textarea>
                                                        </div>
                                                        <div class="form-group" style="display:none;" id="mediasi_note_sebab_kes_xberjaya">
                                                            <label class="form-label">Nyatakan Ulasan /  Sebab-Sebab: </label>
                                                            <textarea class="form-control" rows="4" name="lkmu_mediasi_note_sebab_kes_xberjaya" id="lkmu_mediasi_note_sebab_kes_xberjaya" placeholder="Nyatakan Ulasan /  Sebab-Sebab" disabled></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
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

@include('js.rt-sm23.j-laporan-kes-mkp-upmk')