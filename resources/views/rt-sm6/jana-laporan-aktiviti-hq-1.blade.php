@extends('layout.master')
@section('title', 'Jana Laporan Aktiviti')


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
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="user-list" role="tabpanel">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-4">
                                <form method="POST" id="form_plak">
                                @csrf
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="row clearfix">
                                                        <h6><b>MAKLUMAT KAWASAN RUKUN TETANGGA</b></h6>
                                                        <br><br>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="plap_nama_krt" name="plap_nama_krt"></span></b></p>
                                                            <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="plap_alamat_krt" name="plap_alamat_krt"></span></b></p>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <p><span style="font-size:12px">Negeri</span><br><b><span id="plap_negeri_krt" name="plap_negeri_krt"></span></b></p>
                                                            <p><span style="font-size:12px">Parlimen</span><br><b><span id="plap_parlimen_krt" name="plap_parlimen_krt"></span></b></p>
                                                            <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="plap_pbt_krt" name="plap_pbt_krt"></span></b></p>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <p><span style="font-size:12px">Daerah</span><br><b><span id="plap_daerah_krt" name="plap_daerah_krt"></span></b></p>
                                                            <p><span style="font-size:12px">Dun</span><br><b><span id="plap_dun_krt" name="plap_dun_krt"></span></b></p>
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
                                                                <select class="custom-select" id="plap_state_id" name="plap_state_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($state as $item)                                    
                                                                        <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Daerah: </label>
                                                                <select class="custom-select" id="plap_daerah_id" name="plap_daerah_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($daerah as $item)                                    
                                                                        <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Tempat: </label>
                                                                <textarea class="form-control" name="plap_aktiviti_tempat" id="plap_aktiviti_tempat" rows="4" placeholder="Tempat" disabled></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="custom-controls-stacked">
                                                                    <label class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input" name="plap_aktiviti_kawasan_DL" value="1" disabled>
                                                                        <div class="custom-control-label">Kawasan Rukun Tetangga</div>
                                                                    </label>
                                                                    <label class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input" name="plap_aktiviti_kawasan_DL" value="2" disabled>
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
                                        <form method="POST" id="form_plap1">
                                            @csrf
                                                <p>1. Maklumat Asas</p>
                                                <hr class="mt-1">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Tajuk Aktiviti: </label>
                                                            <input type="text" class="form-control" name="plap1_aktiviti_tajuk" id="plap1_aktiviti_tajuk" placeholder="Tajuk Aktiviti" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Tarikh Aktiviti: </label>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                                <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="plap1_aktiviti_tarikh" id="plap1_aktiviti_tarikh" placeholder="Tarikh Aktiviti" data-date-format="dd/mm/yyyy" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Masa (24 jam): </b>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fa fa-clock-o"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control time24" name="plap1_aktiviti_masa" id="plap1_aktiviti_masa" placeholder="Masa" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Tarikh Rancang: </label>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                                <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="plap1_aktiviti_tarikh_rancang" id="plap1_aktiviti_tarikh_rancang" placeholder="Tarikh Rancang" data-date-format="dd/mm/yyyy" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Penganjur:</label>
                                                            <select class="custom-select" id="plap1_penganjur_id" name="plap1_penganjur_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($penganjur as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->penganjur_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Peringkat Pelaksanaan: </label>
                                                            <select class="custom-select" id="plap1_peringkat_id" name="plap1_peringkat_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($peringkat as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->peringkat_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Agenda Kerja: </label>
                                                            <select class="custom-select" id="plap1_agenda_id" name="plap1_agenda_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($agenda as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->agenda_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Program: </label>
                                                            <select class="custom-select" id="plap1_program_id" name="plap1_program_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($program as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->program_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Bidang: </label>
                                                            <select class="custom-select" id="plap1_bidang_id" name="plap1_bidang_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($bidang as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->bidang_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Kategori Aktiviti: </label>
                                                            <select class="custom-select" id="plap1_aktiviti_id" name="plap1_aktiviti_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($aktiviti as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->aktiviti_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Jenis Aktiviti Aktiviti: </label>
                                                            <select class="custom-select" id="plap1_sub_aktiviti_id" name="plap1_sub_aktiviti_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($sub_aktiviti as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->sub_aktiviti_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Pembelanjaan: </label>
                                                            <input type="text" class="form-control" name="plap1_aktiviti_pembelanjaan" id="plap1_aktiviti_pembelanjaan" placeholder="Pembelanjaan (RM)" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Sumber Kewangan: </label>
                                                            <select class="custom-select" id="plap1_kewangan_id" name="plap1_kewangan_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($sumber_kewangan as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->kewangan_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Kumpulan Sasar: </label>
                                                            <input type="text" class="form-control" name="plap1_aktiviti_sasar" id="plap1_aktiviti_sasar" placeholder="Kumpulan Sasar" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Perasmi: </label>
                                                            <input type="text" class="form-control" name="plap1_aktiviti_perasmi" id="plap1_aktiviti_perasmi" placeholder="Perasmi" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                        <button type="button" class="btn btn-primary" id="btn_next">Seterusnya&nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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

@include('js.rt-sm6.j-jana-laporan-aktiviti-hq-1')
