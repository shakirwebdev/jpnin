@extends('layout.master')
@section('title', 'Semak Cadangan Penubuhan Kawasan Rukun Tetangga')


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
            <div class="tab-pane fade show active" id="user-list" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <form action="#" id="form_sbckb" >
                        @csrf
                            <div class="row clearfix"> 
                                <div class="col-lg-12 col-md-12 col-sm-12">                               
                                    <div class="col-12">
                                        <h6>JENIS PERMOHONAN</h6>
                                        <hr class="mt-1">
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <div class="custom-switches-stacked">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="custom-switch">
                                                            <input type="radio" name="krt-jenis" value="1" class="custom-switch-input" checked>
                                                            <span class="custom-switch-indicator"></span>
                                                            <span class="custom-switch-description">Permohonan Penubuhan Kawasan Rukun Tetangga (KRT)</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <h6>MAKLUMAT PEMOHON</h6>
                                        <hr class="mt-1">
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Nama Pemohon: </label>
                                            <input type="text" class="form-control" name="krt_nama_pemohon" id="krt_nama_pemohon" disabled="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">No Kad Pengenalan: </label>
                                            <input type="text" class="form-control" name="krt_no_ic_pemohon" id="krt_no_ic_pemohon" disabled="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">No Telefon: </label>
                                            <input type="text" class="form-control" name="krt_no_telefon_pemohon" id="krt_no_telefon_pemohon" disabled="">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Alamat Pemohon: </label>
                                            <textarea rows="4" class="form-control" name="krt_alamat_pemohon" id="krt_alamat_pemohon" disabled=""></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <h6>MAKLUMAT PERMOHONAN KAWASAN RUKUN TETANGGA</h6>
                                        <hr class="mt-1">
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="select_negeri_krt" class="form-label">Negeri: </label>
                                            <select class="custom-select" name="select_negeri_krt" id="select_negeri_krt" disabled="">
                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                @foreach($negeri as $item)                                    
                                                <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="select_daerah_krt" class="form-label">Daerah: </label>
                                            <select class="custom-select" name="select_daerah_krt" id="select_daerah_krt" disabled="">
                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                @foreach($daerah as $item)                                    
                                                <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Cadangan Nama Kawasan Rukun Tetangga (KRT): </label>
                                            <input type="text" class="form-control" name="krt_nama" id="krt_nama" disabled="">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Alamat:</label>
                                            <textarea rows="4" class="form-control" name="krt_catatan" id="krt_catatan" disabled=""></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="select_status_cadangan_krt" class="form-label">Status: <span class="text-red">*</span></label>
                                            <select class="custom-select" name="select_status_cadangan_krt" id="select_status_cadangan_krt">
                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                <option value="2">Nama KRT Disahkan</option>
                                                <option value="3">Nama KRT Ditolak</option>
                                            </select>
                                            <div class="error_select_status_cadangan_krt invalid-feedback text-right"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Penerangan: <span class="text-red">*</span></label>
                                            <textarea rows="4" class="form-control" name="krt_disemak_note" id="krt_disemak_note" placeholder="Penerangan"></textarea>
                                            <div class="error_krt_disemak_note invalid-feedback text-right"></div>
                                        </div>
                                    </div> 
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm1.semakan_cadangan_krt_baharu')}}';"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                        <input type="hidden" name="sbckb_application_id" id="sbckb_application_id">
                                        <input type="hidden" name="sbckb_krt_nama" id="sbckb_krt_nama">
                                        <input type="hidden" name="sbckb_krt_alamat" id="sbckb_krt_alamat">
                                        <input type="hidden" name="sbckb_krt_state_id" id="sbckb_krt_state_id">
                                        <input type="hidden" name="sbckb_krt_daerah_id" id="sbckb_krt_daerah_id">
                                        <input type="hidden" name="post_semak_borang_cadangan_krt_baharu" value="edit">
                                        <input type="hidden" name="action" id="post_semak_borang_cadangan_krt_baharu" value="edit">
                                        <button type="submit" class="btn btn-primary" id="btn_submit">Hantar Semakan Cadangan Penubuhan KRT&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
@stop

@include('js.rt-sm1.j-semak-borang-cadangan-krt-baharu')
