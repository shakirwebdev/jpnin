@extends('layout.master')
@section('title', 'Ahli Peronda SRS')


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
                                                    <h6><b>MAKLUMAT KAWASAN RUKUN TETANGGA</b></h6>
                                                    <br><br>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="apshq_nama_krt" name="apshq_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="apshq_alamat_krt" name="apshq_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="apshq_negeri_krt" name="apshq_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="apshq_parlimen_krt" name="apshq_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="apshq_pbt_krt" name="apshq_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="apshq_daerah_krt" name="apshq_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="apshq_dun_krt" name="apshq_dun_krt"></span></b></p>
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
                                                            <img src="" class="avatar" alt="Profile Image" id="apshq_ajk_gambar" name="apshq_ajk_gambar" width="230px"/><br><br>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Nama SRS:</b>
                                                            <select class="form-control" name="apshq_srs_profile_id" id="apshq_srs_profile_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($srs_profile as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->srs_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <b>Nama Penuh:</b>
                                                            <input type="text" class="form-control" name="apshq_peronda_nama" id="apshq_peronda_nama" placeholder="Nama Penuh" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Tarikh Lahir:</b>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                                <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="apshq_peronda_tarikh_lahir" id="apshq_peronda_tarikh_lahir" placeholder="Tarikh Lahir" data-date-format="dd/mm/yyyy" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Kaum:</b>
                                                            <select class="form-control" name="apshq_peronda_kaum" id="apshq_peronda_kaum" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($ref_kaum as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->kaum_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Jantina:</b>
                                                            <select class="form-control" name="apshq_peronda_jantina" id="apshq_peronda_jantina" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($ref_jantina as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->jantina_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Warganegara:</b>
                                                            <input type="text" class="form-control" name="apshq_peronda_warganegara" id="apshq_peronda_warganegara" placeholder="Warganegara" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Tarikh Lantikan SRS:</b>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                                <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="apshq_peronda_tarikh_lantikan" id="apshq_peronda_tarikh_lantikan" placeholder="Tarikh Lantikan SRS" data-date-format="dd/mm/yyyy" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <b>No Kad Pengenalan:</b>
                                                            <input type="text" class="form-control" name="apshq_peronda_ic" id="apshq_peronda_ic" placeholder="No Kad Pengenalan" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Alamat:</b>
                                                            <textarea class="form-control" rows="4" name="apshq_peronda_alamat" id="apshq_peronda_alamat" placeholder="Alamat" disabled></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Poskod:</b>
                                                            <input type="text" class="form-control" name="apshq_peronda_poskod" id="apshq_peronda_poskod" placeholder="Poskod" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>No Telefon:</b>
                                                            <input type="text" class="form-control" name="apshq_peronda_phone" id="apshq_peronda_phone" placeholder="No Telefon" disabled>
                                                            <div class="error_paps_peronda_phone invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Pendidikan:</label>
                                                            <div class="card-body">
                                                                <div class="table-responsive">
                                                                    <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_pendidikan_table" style="width: 100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                                <th><label class="form-label"><font color="#113f50">Peringatan</font></label></th>
                                                                                <th><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <input type="hidden" name="apshq_srs_ahli_peronda_id" id="apshq_srs_ahli_peronda_id" >
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                        <button type="button" class="btn btn-primary" id="btn_next">Seterusnya&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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

@include('js.rt-sm13.j-senarai-ahli-peronda-srs-hq-1')
