@extends('layout.master')
@section('title', 'Sokongan Permohonan Mediator Komuniti')


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
    <div class="section-body mt-3" style="display:none;" id="pmpd_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert" >
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> 
                                <span class="text-red blink" id="pmpd_status_description" name="pmpd_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> 
                                <span id="pmpd_diakui_note" name="pmpd_diakui_note"></span></span>
                                <span id="pmpd_disemak_note" name="pmpd_disemak_note"></span></span>
                                <span id="pmpd_disahkan_note" name="pmpd_disahkan_note"></span></span>.
                                <br>
                                <input type="hidden" name="pmpd_status" id="pmpd_status">
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
                                                <h6><b>MAKLUMAT KAWASAN RUKUN TETANGGA</b></h6>
                                                <br>
                                                <div class="form-group">
                                                    <label class="custom-switch">
                                                        <input type="checkbox" name="spmmk_hasRT" id="spmmk_hasRT" class="custom-switch-input" disabled>
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="custom-switch-description">Dalam Kawasan KRT</span>
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Negeri: </label>
                                                    <select class="form-control" name="spmmk_state_id" id="spmmk_state_id" disabled>
                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                        @foreach($negeri as $item)                                    
                                                            <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Daerah: </label>
                                                    <select class="form-control" name="spmmk_daerah_id" id="spmmk_daerah_id" disabled>
                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                        @foreach($daerah as $item)                                    
                                                            <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Nama KRT: </label>
                                                    <select class="form-control" name="spmmk_krt_profile_id" id="spmmk_krt_profile_id" disabled>
                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                        @foreach($krt as $item)                                    
                                                            <option value="{{ $item->id }}">{{ $item->krt_nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT STATUS SOKONGAN</b></h6>
                                                <br><br>
                                                <form action="#" id="form_spmmk" >
                                                @csrf
                                                    <div class="form-group">
                                                        <label class="form-label">Status: </label>
                                                        <select class="form-control" name="spmmk_imediator_status" id="spmmk_imediator_status">
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            <option value="6">Disokong</option>
                                                            <option value="7">Perlu Dikemaskini</option>
                                                        </select>
                                                        <div class="error_spmmk_imediator_status invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Penerangan: </label>
                                                        <textarea class="form-control" rows="4" name="spmmk_disokong_note" id="spmmk_disokong_note" placeholder="Penerangan"></textarea>
                                                        <div class="error_spmmk_disokong_note invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group pull-right">
                                                            <input type="hidden" name="spmmk_spk_imediator_id" id="spmmk_spk_imediator_id">
                                                            <input type="hidden" name="post_sokongan_permohonan_mkp_ppmk" value="edit">
                                                            <input type="hidden" name="action" id="post_sokongan_permohonan_mkp_ppmk" value="edit">
                                                            <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                            <button type="submit" class="btn btn-primary" id="btn_submit">Hantar Status Sokongan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
                                                        </div>
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
                                            <h6><b>MAKLUMAT MEDIATOR KOMUNITI</b></h6>
                                            <br>
                                            <p>1. Maklumat Pemohon : </p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group text-center">
                                                            <img src="" class="avatar" alt="Profile Image" id="spmmk_mkp_gambar" name="spmmk_mkp_gambar" width="230px"/><br><br>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Nama Pemohon: </label>
                                                            <input type="text" class="form-control" name="spmmk_mkp_pemohon_nama" id="spmmk_mkp_pemohon_nama" placeholder="Nama Pemohon" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Tarikh Lahir: </b>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                                <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="spmmk_mkp_pemohon_tarikh_lahir" id="spmmk_mkp_pemohon_tarikh_lahir" placeholder="Tarikh Lahir" data-date-format="dd/mm/yyyy" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Daerah: </label>
                                                            <select class="form-control" name="spmmk_mkp_pemohon_daerah_id" id="spmmk_mkp_pemohon_daerah_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($daerah as $item)                                    
                                                                    <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Dun: </label>
                                                            <select class="form-control" name="spmmk_mkp_pemohon_dun_id" id="spmmk_mkp_pemohon_dun_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($dun as $item)                                    
                                                                    <option value="{{ $item->dun_id }}">{{ $item->dun_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Mukim : </label>
                                                            <input type="text" class="form-control" name="spmmk_mkp_pemohon_mukim_id" id="spmmk_mkp_pemohon_mukim_id" placeholder="Mukim" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Kaum: </label>
                                                            <select class="form-control" name="spmmk_mkp_pemohon_kaum_id" id="spmmk_mkp_pemohon_kaum_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($kaum as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->kaum_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Alamat Rumah: </label>
                                                            <textarea class="form-control" id="spmmk_mkp_pemohon_alamat" name="spmmk_mkp_pemohon_alamat" rows="4" placeholder="Alamat Rumah" disabled></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">No Telefon : </label>
                                                            <input type="text" class="form-control" name="spmmk_mkp_pemohon_no_phone" id="spmmk_mkp_pemohon_no_phone" placeholder="No Telefon" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Kategori MKP: </label>
                                                            <select class="form-control" name="spmmk_mkp_pemohon_kategori_id" id="spmmk_mkp_pemohon_kategori_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($mkp_kategori as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->kategori_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Kelulusan Akademik: </label>
                                                            <select class="form-control" name="spmmk_mkp_pemohon_akademik" id="spmmk_mkp_pemohon_akademik" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($pendidikan as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->pendidikan_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Tarikh Pelantikan: </b>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                                <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="spmmk_mkp_tarikh_dilantik" id="spmmk_mkp_tarikh_dilantik" placeholder="Tarikh Lahir" data-date-format="dd/mm/yyyy" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">No Kad Pengenalan: </label>
                                                            <input type="text" class="form-control" name="spmmk_mkp_pemohon_ic" id="spmmk_mkp_pemohon_ic" placeholder="No Kad Pengenalan" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Negeri: </label>
                                                            <select class="form-control" name="spmmk_mkp_pemohon_state_id" id="spmmk_mkp_pemohon_state_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($negeri as $item)                                    
                                                                    <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Parlimen: </label>
                                                            <select class="form-control" name="spmmk_mkp_pemohon_parlimen_id" id="spmmk_mkp_pemohon_parlimen_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($parlimen as $item)                                    
                                                                    <option value="{{ $item->parlimen_id }}">{{ $item->parlimen_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">PBT: </label>
                                                            <select class="form-control" name="spmmk_mkp_pemohon_pbt_id" id="spmmk_mkp_pemohon_pbt_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($pbt as $item)                                    
                                                                    <option value="{{ $item->pbt_id }}">{{ $item->pbt_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Jantina: </label>
                                                            <select class="form-control" name="spmmk_mkp_pemohon_jantina_id" id="spmmk_mkp_pemohon_jantina_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($jantina as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->jantina_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Emel : </label>
                                                            <input type="text" class="form-control" name="spmmk_mkp_pemohon_email" id="spmmk_mkp_pemohon_email" placeholder="Emel" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Alamat Pejabat: </label>
                                                            <textarea class="form-control" rows="4" id="spmmk_mkp_pemohon_alamat_p" name="spmmk_mkp_pemohon_alamat_p" placeholder="Alamat Pejabat" disabled></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">No Telefon Pejabat : </label>
                                                            <input type="text" class="form-control" name="spmmk_mkp_pemohon_no_phone_p" id="spmmk_mkp_pemohon_no_phone_p" placeholder="No Telefon Pejabat" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Tahap MKP: </label>
                                                            <select class="form-control" name="spmmk_mkp_pemohon_tahap_id" id="spmmk_mkp_pemohon_tahap_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($mkp_tahap as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->tahap_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Pengkhususan (kemahiran): </label>
                                                            <input type="text" class="form-control" name="spmmk_mkp_pemohon_khusus" id="spmmk_mkp_pemohon_khusus" placeholder="Pengkhususan" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <p>2. Maklumat Kursus Yang Dihadiri : </p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_kursus_mkp_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Nama Kursus</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Kategori Kursus</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Peringkat Kursus</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Penganjur</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Dokumen</font></label></th>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br><br>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            
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

@include('js.rt-sm23.j-sokongan-permohonan-mkp-ppmk')
