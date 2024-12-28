@extends('layout.master')
@section('title', 'Penyediaan Laporan Aktiviti Perpaduan')


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
    <div class="section-body mt-3" style="display:none;" id="plak_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert" >
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> <span class="text-red blink" id="plak_status_description" name="plak_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> <span id="plak_disahkan_note" name="plak_disahkan_note"></span></span>.
                                <br>
                                <input type="hidden" name="plak_status" id="plak_status">
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
                                <form method="POST" id="form_plak5">
                                @csrf
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="row clearfix">
                                                        <h6><b>MAKLUMAT KAWASAN RUKUN TETANGGA</b></h6>
                                                        <br><br>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="plak5_nama_krt" name="plak5_nama_krt"></span></b></p>
                                                            <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="plak5_alamat_krt" name="plak5_alamat_krt"></span></b></p>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <p><span style="font-size:12px">Negeri</span><br><b><span id="plak5_negeri_krt" name="plak5_negeri_krt"></span></b></p>
                                                            <p><span style="font-size:12px">Parlimen</span><br><b><span id="plak5_parlimen_krt" name="plak5_parlimen_krt"></span></b></p>
                                                            <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="plak5_pbt_krt" name="plak5_pbt_krt"></span></b></p>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <p><span style="font-size:12px">Daerah</span><br><b><span id="plak5_daerah_krt" name="plak5_daerah_krt"></span></b></p>
                                                            <p><span style="font-size:12px">Dun</span><br><b><span id="plak5_dun_krt" name="plak5_dun_krt"></span></b></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="row clearfix">
                                                        <h6><b>MAKLUMAT TEMPAT AKTIVITI PERPADUAN</b></h6>
                                                        <br><br>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Negeri: </label>
                                                                <select class="custom-select" id="plak5_state_id" name="plak5_state_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($state as $item)                                    
                                                                        <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Daerah: </label>
                                                                <select class="custom-select" id="plak5_daerah_id" name="plak5_daerah_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($daerah as $item)                                    
                                                                        <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Tempat: </label>
                                                                <textarea class="form-control" name="plak5_aktiviti_tempat" id="plak5_aktiviti_tempat" rows="4" placeholder="Tempat" disabled></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="custom-controls-stacked">
                                                                    <label class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input" name="plak5_aktiviti_kawasan_DL" value="1" disabled>
                                                                        <div class="custom-control-label">Kawasan Rukun Tetangga</div>
                                                                    </label>
                                                                    <label class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input" name="plak5_aktiviti_kawasan_DL" value="2" disabled>
                                                                        <div class="custom-control-label">Luar Kawasan Rukun Tetangga</div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                             <div class="col-lg-8 col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="#" id="form_ppak6" >
                                        @csrf
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <h6><b>MAKLUMAT AKTIVITI PERPADUAN</b></h6>
                                                <br>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">Ringkasan Program: <br><label><font color="red">(tidak lebih 100 perkataan)</font></label> </label>
                                                    <textarea id="plak6_aktiviti_ringkasan_program" name="plak6_aktiviti_ringkasan_program" class="form-control"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Kaedah Penilaian: <label><font color="red">*</font></label> </label>
                                                </div>
                                                <div class="form-group">
                                                    <div class="custom-controls-stacked">
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="plak6_aktiviti_post_mortem" value="1">
                                                            <span class="custom-control-label"><i>Post Mortem</i> : perbincangan tentang kelibihan, kekurangan dan cadangan penambahbaikan</span>
                                                        </label>
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="plak6_aktiviti_soal_selidik" value="1">
                                                            <span class="custom-control-label">Soal Slidik : Pengukuran Program Perpaduan / Penilaian kursus</span>
                                                        </label>
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="plak6_aktiviti_pemerhatian" value="1">
                                                            <span class="custom-control-label">Pemerhatian</span>
                                                        </label>
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="plak6_aktiviti_temubual" value="1">
                                                            <span class="custom-control-label">Temubual</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Kekuatan / Kelemahan Aktiviti: <br><label><font color="red">(tidak lebih 100 perkataan)</font></label> </label>
                                                    <textarea id="plak6_aktiviti_kekuatan" name="plak6_aktiviti_kekuatan" class="form-control"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Impak / Keberkesanan Aktiviti: <br><label><font color="red">(tidak lebih 100 perkataan)</font></label> </label>
                                                    <textarea id="plak6_aktiviti_keberkesanan" name="plak6_aktiviti_keberkesanan" class="form-control"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Cadangan Penambahbaikan: <br><label><font color="red">(tidak lebih 100 perkataan)</font></label> </label>
                                                    <textarea id="plak6_aktiviti_penambahbaikan" name="plak6_aktiviti_penambahbaikan" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <input type="hidden" name="plak6_aktiviti_laporan_id" id="plak6_aktiviti_laporan_id" >
                                                <input type="hidden" name="update_penyediaan_laporan_aktiviti" value="edit">
                                                <input type="hidden" name="action" id="update_penyediaan_laporan_aktiviti" value="edit">
                                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="submit" class="btn btn-primary" id="btn_sumbit">Hantar Laporan Aktiviti Perpaduan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
                                            </div>
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
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@stop

@include('js.rt-sm6.j-penyediaan-laporan-aktiviti-krt-3')
