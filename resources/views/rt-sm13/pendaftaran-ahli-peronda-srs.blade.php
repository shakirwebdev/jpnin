@extends('layout.master')
@section('title', 'Pendaftaran Ahli Peronda SRS')


@section('content')
@include('modal.modal-add-gambar-peronda-srs')
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
    <div class="section-body mt-3" style="display:none;" id="paps_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert">
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> <span class="text-red blink" id="paps_status_description" name="paps_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> <span id="paps_disemak_note" name="paps_disemak_note"></span>.
                                <br>
                                <input type="hidden" name="paps_status" id="paps_status">
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
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <h6><b>MAKLUMAT KAWASAN RUKUN TETANGGA</b></h6>
                                                    <br><br>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="paps_nama_krt" name="paps_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="paps_alamat_krt" name="paps_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="paps_negeri_krt" name="paps_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="paps_parlimen_krt" name="paps_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="paps_pbt_krt" name="paps_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="paps_daerah_krt" name="paps_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="paps_dun_krt" name="paps_dun_krt"></span></b></p>
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
                                            <form action="#" id="form_paps" >
                                            @csrf
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <h6><b>MAKLUMAT PEMOHON AHLI PERONDA SRS</b></h6>
                                                    <br>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group text-center">
                                                            <img src="" class="avatar" alt="Profile Image" id="paps_ajk_gambar" name="paps_ajk_gambar" width="230px"/><br><br>
                                                            <button type="button" class="btn btn-primary" onclick="load_add_gambar_peronda_srs();">Kemaskini Gambar&nbsp;&nbsp;<i class="dropdown-icon fa fa-edit"></i></button>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Nama SRS: </b>
                                                            <select class="form-control" name="paps_srs_profile_id" id="paps_srs_profile_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($srs_profile as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->srs_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <b>Nama Penuh: <span class="text-red">*</span></b>
                                                            <input type="text" class="form-control" name="paps_peronda_nama" id="paps_peronda_nama" placeholder="Nama Penuh">
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Tarikh Lahir: <span class="text-red">*</span></b>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                                <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="paps_peronda_tarikh_lahir" id="paps_peronda_tarikh_lahir" placeholder="Tarikh Lahir" data-date-format="dd/mm/yyyy">
                                                            </div>
                                                            <div class="error_paps_peronda_tarikh_lahir invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Kaum: <span class="text-red">*</span></b>
                                                            <select class="form-control" name="paps_peronda_kaum" id="paps_peronda_kaum">
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($ref_kaum as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->kaum_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Jantina: <span class="text-red">*</span></b>
                                                            <select class="form-control" name="paps_peronda_jantina" id="paps_peronda_jantina">
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($ref_jantina as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->jantina_description }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="error_paps_peronda_jantina invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Warganegara: <span class="text-red">*</span></b>
                                                            <input type="text" class="form-control" name="paps_peronda_warganegara" id="paps_peronda_warganegara" placeholder="Warganegara">
                                                            <div class="error_paps_peronda_warganegara invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Agama: <span class="text-red">*</span></b>
                                                            <select class="form-control" name="paps_peronda_agama" id="paps_peronda_agama">
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($ref_agama as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->agama_description }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="error_paps_peronda_agama invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Tarikh Lantikan SRS: <span class="text-red">*</span></b>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                                <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="paps_peronda_tarikh_lantikan" id="paps_peronda_tarikh_lantikan" placeholder="Tarikh Lantikan SRS" data-date-format="dd/mm/yyyy">
                                                            </div>
                                                            <div class="error_paps_peronda_tarikh_lantikan invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <b>No Kad Pengenalan: <span class="text-red">*</span></b>
                                                            <input type="text" class="form-control" name="paps_peronda_ic" id="paps_peronda_ic" placeholder="XXXXXXXXXXXX">
                                                            <div class="error_paps_peronda_ic invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Alamat: <span class="text-red">*</span></b>
                                                            <textarea class="form-control" rows="4" name="paps_peronda_alamat" id="paps_peronda_alamat" placeholder="Alamat"></textarea>
                                                            <div class="error_paps_peronda_alamat invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Poskod: <span class="text-red">*</span></b>
                                                            <input type="text" class="form-control" name="paps_peronda_poskod" id="paps_peronda_poskod" placeholder="Poskod">
                                                            <div class="error_paps_peronda_poskod invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>No Telefon: <span class="text-red">*</span></b>
                                                            <input type="text" class="form-control" name="paps_peronda_phone" id="paps_peronda_phone" placeholder="No Telefon">
                                                            <div class="error_paps_peronda_phone invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Pendidikan: </label>
                                                            <div class="card-body">
                                                                <div class="table-responsive">
                                                                    <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_pendidikan_table" style="width: 100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                                <th><label class="form-label"><font color="#113f50">Pendidikan</font></label></th>
                                                                                <th><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <input type="hidden" name="paps_srs_ahli_peronda_id" id="paps_srs_ahli_peronda_id" >
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <input type="hidden" name="post_pendaftaran_ahli_peronda_srs" value="edit">
                                                        <input type="hidden" name="action" id="post_pendaftaran_ahli_peronda_srs" value="edit">
                                                        <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                        <button type="submit" class="btn btn-primary" id="btn_next">Seterusnya&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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

@include('js.rt-sm13.j-pendaftaran-ahli-peronda-srs')
