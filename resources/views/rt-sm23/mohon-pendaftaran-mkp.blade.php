@extends('layout.master')
@section('title', 'Pendaftaran Mediator Komuniti')


@section('content')
@include('modal.modal-gambar-mkp')
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
    <div class="section-body mt-3" style="display:none;" id="mpm_status_alert">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-primary alert-dismissible fade show small" role="alert" >
                            <div class="mb-10">
                                <code><span style="font-size: 16px;"><strong>No Rujukan : <span id="mpm_no_rujukan_mkp" name="mpm_no_rujukan_mkp"></span></span></strong></span></code>
                                <br><br>
                                <code><span style="font-size: 16px;"><strong>Status : <span class="blink" id="mpm_status_description" name="mpm_status_description"></span></span></strong></span></code>
                                <br><br>
                                Permohonan Pendaftaran Mediator Komuniti sedang dalam proses tindakan Pegawai Perpaduan.
                                <br>
                                <br>
                                Sepanjang proses tindakan Pegawai Perpaduan ini, maklumat yang dibekalkan dikunci untuk seketika. Maklumat ini akan dapat diubah sekiranya terdapat maklumbalas daripada pihak Pegawai Perpaduan untuk dikemaskini oleh pihak MKP. 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section-body mt-3" style="display:none;" id="mpm_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert" >
                            <div class="mb-10">
                                <code><span style="font-size: 16px;"><strong>No Rujukan : <span id="mpm2_no_rujukan_mkp" name="mpm2_no_rujukan_mkp"></span></span></strong></span></code>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> 
                                <span class="text-red blink" id="mpm2_status_description" name="mpm2_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> 
                                <span id="mpm_disokong_note" name="mpm_disokong_note"></span></span>
                                <span id="mpm_disokong_p_note" name="mpm_disokong_p_note"></span></span>
                                <span id="mpm_disahkan_note" name="mpm_disahkan_note"></span></span>
                                <span id="mpm_disemak_note" name="mpm_disemak_note"></span></span>
                                <span id="mpm_dilulus_note" name="mpm_dilulus_note"></span></span>
                                <span id="mpm_dilantik_note" name="mpm_dilantik_note"></span></span>.
                                <br>
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
                                                <form method="POST" id="form_mpm">
                                                @csrf
                                                    <h6><b>MAKLUMAT KAWASAN RUKUN TETANGGA</b></h6>
                                                    <br>
                                                    <div class="form-group">
                                                        <label class="custom-switch">
                                                            <input type="checkbox" name="mpm_hasRT" id="mpm_hasRT" class="custom-switch-input">
                                                            <span class="custom-switch-indicator"></span>
                                                            <span class="custom-switch-description">Dalam Kawasan KRT</span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Negeri: </label>
                                                        <select class="form-control" name="mpm_state_id" id="mpm_state_id" disabled>
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            @foreach($negeri as $item)                                    
                                                                <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="error_mpm_state_id invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Daerah: </label>
                                                        <select class="form-control" name="mpm_daerah_id" id="mpm_daerah_id" disabled>
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            @foreach($daerah as $item)                                    
                                                                <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="error_mpm_daerah_id invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Nama KRT: </label>
                                                        <select class="form-control" name="mpm_krt_profile_id" id="mpm_krt_profile_id" disabled>
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            
                                                        </select>
                                                        <div class="error_mpm_krt_profile_id invalid-feedback text-right"></div>
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
                                                <form method="POST" id="form_mpm1">
                                                @csrf
                                                    <div class="row clearfix">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group text-center">
                                                                <img src="" class="avatar" alt="Profile Image" id="mpm1_mkp_gambar" name="mpm1_mkp_gambar" width="230px"/><br><br>
                                                                <button type="button" id="btn_profile_picture" class="btn btn-primary" onclick="load_gambar_mkp();">Kemaskini Gambar&nbsp;&nbsp;<i class="dropdown-icon fa fa-edit"></i></button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Nama Pemohon: </label>
                                                                <input type="text" class="form-control" name="mpm1_mkp_pemohon_nama" id="mpm1_mkp_pemohon_nama" placeholder="Nama Pemohon" disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <b>Tarikh Lahir: <span class="text-red">*</span></b>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                    </div>
                                                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="mpm1_mkp_pemohon_tarikh_lahir" id="mpm1_mkp_pemohon_tarikh_lahir" placeholder="Tarikh Lahir" data-date-format="dd/mm/yyyy">
                                                                    <div class="error_mpm1_mkp_pemohon_tarikh_lahir invalid-feedback text-right"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Daerah: </label>
                                                                <select class="form-control" name="mpm1_mkp_pemohon_daerah_id" id="mpm1_mkp_pemohon_daerah_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($daerah as $item)                                    
                                                                        <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Dun: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="mpm1_mkp_pemohon_dun_id" id="mpm1_mkp_pemohon_dun_id">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                </select>
                                                                <div class="error_mpm1_mkp_pemohon_dun_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Mukim : <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="mpm1_mkp_pemohon_mukim_id" id="mpm1_mkp_pemohon_mukim_id" placeholder="Mukim">
                                                                <div class="error_mpm1_mkp_pemohon_mukim_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Kaum: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="mpm1_mkp_pemohon_kaum_id" id="mpm1_mkp_pemohon_kaum_id">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($kaum as $item)                                    
                                                                        <option value="{{ $item->id }}">{{ $item->kaum_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_mpm1_mkp_pemohon_kaum_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Alamat Rumah: <span class="text-red">*</span></label>
                                                                <textarea class="form-control" id="mpm1_mkp_pemohon_alamat" name="mpm1_mkp_pemohon_alamat" rows="4" placeholder="Alamat Rumah"></textarea>
                                                                <div class="error_mpm1_mkp_pemohon_alamat invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">No Telefon : </label>
                                                                <input type="text" class="form-control" name="mpm1_mkp_pemohon_no_phone" id="mpm1_mkp_pemohon_no_phone" placeholder="No Telefon" disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Kategori MKP: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="mpm1_mkp_pemohon_kategori_id" id="mpm1_mkp_pemohon_kategori_id">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($mkp_kategori as $item)                                    
                                                                        <option value="{{ $item->id }}">{{ $item->kategori_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_mpm1_mkp_pemohon_kategori_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Kelulusan Akademik: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="mpm1_mkp_pemohon_akademik" id="mpm1_mkp_pemohon_akademik">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($pendidikan as $item)                                    
                                                                        <option value="{{ $item->id }}">{{ $item->pendidikan_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_mpm1_mkp_pemohon_akademik invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <b>Tarikh Pelantikan: <span class="text-red">*</span></b>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                    </div>
                                                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="mpm1_mkp_tarikh_dilantik" id="mpm1_mkp_tarikh_dilantik" placeholder="Tarikh Lahir" data-date-format="dd/mm/yyyy">
                                                                    <div class="error_mpm1_mkp_tarikh_dilantik invalid-feedback text-right"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">No Kad Pengenalan: </label>
                                                                <input type="text" class="form-control" name="mpm1_mkp_pemohon_ic" id="mpm1_mkp_pemohon_ic" placeholder="No Kad Pengenalan" disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Negeri: </label>
                                                                <select class="form-control" name="mpm1_mkp_pemohon_state_id" id="mpm1_mkp_pemohon_state_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($negeri as $item)                                    
                                                                        <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Parlimen: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="mpm1_mkp_pemohon_parlimen_id" id="mpm1_mkp_pemohon_parlimen_id">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                   
                                                                </select>
                                                                <div class="error_mpm1_mkp_pemohon_parlimen_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">PBT: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="mpm1_mkp_pemohon_pbt_id" id="mpm1_mkp_pemohon_pbt_id">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                </select>
                                                                <div class="error_mpm1_mkp_pemohon_pbt_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Jantina: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="mpm1_mkp_pemohon_jantina_id" id="mpm1_mkp_pemohon_jantina_id">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($jantina as $item)                                    
                                                                        <option value="{{ $item->id }}">{{ $item->jantina_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_mpm1_mkp_pemohon_jantina_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Emel : </label>
                                                                <input type="text" class="form-control" name="mpm1_mkp_pemohon_email" id="mpm1_mkp_pemohon_email" placeholder="Emel" disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Alamat Pejabat: <span class="text-red">*</span></label>
                                                                <textarea class="form-control" rows="4" id="mpm1_mkp_pemohon_alamat_p" name="mpm1_mkp_pemohon_alamat_p" placeholder="Alamat Pejabat"></textarea>
                                                                <div class="error_mpm1_mkp_pemohon_alamat_p invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">No Telefon Pejabat : <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="mpm1_mkp_pemohon_no_phone_p" id="mpm1_mkp_pemohon_no_phone_p" placeholder="No Telefon Pejabat">
                                                                <div class="error_mpm1_mkp_pemohon_no_phone_p invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Tahap MKP: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="mpm1_mkp_pemohon_tahap_id" id="mpm1_mkp_pemohon_tahap_id">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($mkp_tahap as $item)                                    
                                                                        <option value="{{ $item->id }}">{{ $item->tahap_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_mpm1_mkp_pemohon_tahap_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Pengkhususan (kemahiran): <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="mpm1_mkp_pemohon_khusus" id="mpm1_mkp_pemohon_khusus" placeholder="Pengkhususan">
                                                                <div class="error_mpm1_mkp_pemohon_khusus invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <br>
                                            <p>2. Maklumat Kursus Yang Dihadiri : </p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <form action="#" id="form_mpm2">
                                                        {{ csrf_field() }}
                                                            <div class="series-frame">
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <div class="col-md-12 alert alert-danger error_alert" role="alert" style="display: none; padding-bottom: 0px;">
                                                                        <ul></ul>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Nama Kursus : </label>
                                                                        <input type="text" class="form-control" name="mpm2_kursus_nama" id="mpm2_kursus_nama" placeholder="Nama Kursus">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Kategori Kursus: </label>
                                                                        <select class="form-control" name="mpm2_mkp_kategori_kursus_id" id="mpm2_mkp_kategori_kursus_id">
                                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                            @foreach($kategori_kursus as $item)                                    
                                                                                <option value="{{ $item->id }}">{{ $item->kursus_description }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Peringkat Kursus: </label>
                                                                        <select class="form-control" name="mpm2_mkp_peringkat_kursus_id" id="mpm2_mkp_peringkat_kursus_id">
                                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                            @foreach($peringkat_kursus as $item)                                    
                                                                                <option value="{{ $item->id }}">{{ $item->peringkat_description }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Penganjur : </label>
                                                                        <input type="text" class="form-control" name="mpm2_kursus_penganjur" id="mpm2_kursus_penganjur" placeholder="Status Pelaksana">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Dokumen : </label>
                                                                        <input type="file" class="form-control" name="mpm2_file_dokument" id="mpm2_file_dokument" placeholder="Dokumen">
                                                                    </div>
                                                                    <input type="hidden" name="mpm2_spk_imediator_id" id="mpm2_spk_imediator_id">
                                                                    <input type="hidden" name="post_imediator_kursus_mkp" value="add">
                                                                    <button type="submit" class="btn btn-primary pull-right" id="btn_submit_kursus"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_kursus_mkp_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Bil</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Nama Kursus</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Kategori Kursus</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Peringkat Kursus</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Penganjur</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Dokumen</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Tindakan</font></label></th>
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
                                            <form method="POST" id="form_mpm3">
                                            @csrf
                                                <input type="hidden" name="mpm3_spk_imediator_id" id="mpm3_spk_imediator_id">
                                                <input type="hidden" name="post_mohon_mkp" value="edit">
                                                <input type="hidden" name="action" id="post_mohon_mkp" value="edit">
                                                <button type="submit" class="btn btn-primary" id="btn_submit">Hantar Permohonan MKP&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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

@include('js.rt-sm23.j-mohon-pendaftaran-mkp')
