@extends('layout.master')
@section('title', 'Penyediaan Perancangan Aktiviti')


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
    <div class="section-body mt-3" style="display:none;" id="ppak_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert" >
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> <span class="text-red blink" id="ppak_status_description" name="ppak_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> <span id="ppak_disahkan_note" name="ppak_disahkan_note"></span></span>.
                                <br>
                                <input type="hidden" name="ppak_status" id="ppak_status">
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
                                <form method="POST" id="form_ppak">
                                @csrf
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="row clearfix">
                                                        <h6><b>MAKLUMAT KAWASAN RUKUN TETANGGA</b></h6>
                                                        <br><br>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="ppak_nama_krt" name="ppak_nama_krt"></span></b></p>
                                                            <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="ppak_alamat_krt" name="ppak_alamat_krt"></span></b></p>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <p><span style="font-size:12px">Negeri</span><br><b><span id="ppak_negeri_krt" name="ppak_negeri_krt"></span></b></p>
                                                            <p><span style="font-size:12px">Parlimen</span><br><b><span id="ppak_parlimen_krt" name="ppak_parlimen_krt"></span></b></p>
                                                            <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="ppak_pbt_krt" name="ppak_pbt_krt"></span></b></p>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <p><span style="font-size:12px">Daerah</span><br><b><span id="ppak_daerah_krt" name="ppak_daerah_krt"></span></b></p>
                                                            <p><span style="font-size:12px">Dun</span><br><b><span id="ppak_dun_krt" name="ppak_dun_krt"></span></b></p>
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
                                                                <label class="form-label">Negeri: <span class="text-red">*</span></label>
                                                                <select class="custom-select" id="ppak_state_id" name="ppak_state_id">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($state as $item)                                    
                                                                        <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_ppak_state_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Daerah: <span class="text-red">*</span></label>
                                                                <select class="custom-select" id="ppak_daerah_id" name="ppak_daerah_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                </select>
                                                                <div class="error_ppak_daerah_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Tempat: <span class="text-red">*</span></label>
                                                                <textarea class="form-control" name="ppak_aktiviti_tempat" id="ppak_aktiviti_tempat" rows="4" placeholder="Tempat"></textarea>
                                                                <div class="error_ppak_aktiviti_tempat invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="custom-controls-stacked">
                                                                    <label class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input" name="ppak_aktiviti_kawasan_DL" value="1" checked>
                                                                        <div class="custom-control-label">Kawasan Rukun Tetangga</div>
                                                                    </label>
                                                                    <label class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input" name="ppak_aktiviti_kawasan_DL" value="2">
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
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <h6><b>MAKLUMAT AKTIVITI RT</b></h6>
                                            <br>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <form method="POST" id="form_ppak1">
                                            @csrf
                                                <p>1. Maklumat Asas</p>
                                                <hr class="mt-1">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Tajuk Aktiviti: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="ppak1_aktiviti_tajuk" id="ppak1_aktiviti_tajuk" placeholder="Tajuk Aktiviti">
                                                            <div class="error_ppak1_aktiviti_tajuk invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Tarikh Aktiviti: <span class="text-red">*</span></label>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                                <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="ppak1_aktiviti_tarikh" id="ppak1_aktiviti_tarikh" placeholder="Tarikh Aktiviti" data-date-format="dd/mm/yyyy">
                                                                <div class="error_ppak1_aktiviti_tarikh invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Masa (24 jam) <span class="text-red">*</span></b>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fa fa-clock-o"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control time24" name="ppak1_aktiviti_masa" id="ppak1_aktiviti_masa" placeholder="Masa">
                                                                <div class="error_ppak1_aktiviti_masa invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Tarikh Rancang: <span class="text-red">*</span></label>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                                <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="ppak1_aktiviti_tarikh_rancang" id="ppak1_aktiviti_tarikh_rancang" placeholder="Tarikh Rancang" data-date-format="dd/mm/yyyy">
                                                                <div class="error_ppak1_aktiviti_tarikh_rancang invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Penganjur: <span class="text-red">*</span></label>
                                                            <select class="custom-select" id="ppak1_penganjur_id" name="ppak1_penganjur_id">
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($penganjur as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->penganjur_description }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="error_ppak1_penganjur_id invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Peringkat Pelaksanaan: <span class="text-red">*</span></label>
                                                            <select class="custom-select" id="ppak1_peringkat_id" name="ppak1_peringkat_id">
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($peringkat as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->peringkat_description }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="error_ppak1_peringkat_id invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Agenda Kerja: <span class="text-red">*</span></label>
                                                            <select class="custom-select" id="ppak1_agenda_id" name="ppak1_agenda_id">
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($agenda as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->agenda_description }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="error_ppak1_agenda_id invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Program: <span class="text-red">*</span></label>
                                                            <select class="custom-select" id="ppak1_program_id" name="ppak1_program_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            </select>
                                                            <div class="error_ppak1_program_id invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Bidang: <span class="text-red">*</span></label>
                                                            <select class="custom-select" id="ppak1_bidang_id" name="ppak1_bidang_id">
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($bidang as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->bidang_description }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="error_ppak1_bidang_id invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Kategori Aktiviti: <span class="text-red">*</span></label>
                                                            <select class="custom-select" id="ppak1_aktiviti_id" name="ppak1_aktiviti_id">
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($aktiviti as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->aktiviti_description }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="error_ppak1_aktiviti_id invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Jenis Aktiviti: <span class="text-red">*</span></label>
                                                            <select class="custom-select" id="ppak1_sub_aktiviti_id" name="ppak1_sub_aktiviti_id">
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($sub_aktiviti as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->sub_aktiviti_description }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="error_ppak1_sub_aktiviti_id invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Pembelanjaan: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="ppak1_aktiviti_pembelanjaan" id="ppak1_aktiviti_pembelanjaan" placeholder="Pembelanjaan (RM)">
                                                            <div class="error_ppak1_aktiviti_pembelanjaan invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Sumber Kewangan: <span class="text-red">*</span></label>
                                                            <select class="custom-select" id="ppak1_kewangan_id" name="ppak1_kewangan_id">
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($sumber_kewangan as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->kewangan_description }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="error_ppak1_kewangan_id invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Kumpulan Sasar: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="ppak1_aktiviti_sasar" id="ppak1_aktiviti_sasar" placeholder="Kumpulan Sasar">
                                                            <div class="error_ppak1_aktiviti_sasar invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Perasmi: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="ppak1_aktiviti_perasmi" id="ppak1_aktiviti_perasmi" placeholder="Perasmi">
                                                            <div class="error_ppak1_aktiviti_perasmi invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <input type="hidden" name="ppak1_aktiviti_perancangan_id" id="ppak1_aktiviti_perancangan_id">
                                                        <input type="hidden" name="action" id="update_penyediaan_perancangan_aktiviti" value="edit">
                                                        <input type="hidden" name="update_penyediaan_perancangan_aktiviti" value="edit">
                                                        <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                        <button type="submit" class="btn btn-primary" id="btn_next">Seterusnya&nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
                                                    </div>
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
    </div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@stop

@include('js.rt-sm6.j-penyediaan-perancangan-aktiviti-krt-1')
