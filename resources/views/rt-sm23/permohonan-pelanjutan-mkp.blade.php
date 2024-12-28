@extends('layout.master')
@section('title', 'Permohonan Pelanjutan Mediator Komuniti')


@section('content')
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <small>Isi maklumat pada borang yang disediakan dibawah, dan tekan butang <code style="color:#113f50">HANTAR PERMOHONAN PELANJUTAN MKP</code>. 
                        <br>
                        Ruangan bertanda <span class="text-red">*</span> adalah ruangan mandatori dan perlu diisi..&nbsp;&nbsp;<a href="#"><i class="dropdown-icon fe fe-help-circle"></i></a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section-body mt-3"  id="ppm_status_kelayakan">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert" >
                            <div class="mb-10">
                                <code><span style="font-size: 16px;"><strong>No Rujukan MKP : <span id="ppm_no_rujukan_mkp" name="ppm_no_rujukan_mkp"></span></span></strong></span></code>
                                <br><br>
                                <code><span style="font-size: 16px;"><strong>Status Kelayakan : <span class="blink" id="ppm_status_description" name="ppm_status_description"></span></span></strong></span></code>
                                <br><br>
                                <span style="display:none;" id="note_layak">
                                Maklumat ini diperoleh daripada profil Mediator Komuniti (MKP).
                                <br>
                                Sekiranya terdapat sebarang perubahan atau penambahan, sila mengemaskini maklumat dan membuat permohonan semula. 
                                </span>
                                <span style="display:none;" id="note_tidak_layak">
                                Anda tidak layak untuk membuat permohonan pelanjutan Mediator Komuniti (MKP).
                                <br>
                                Sila rujuk Pegawai Perpaduan untuk membuat permohonan pelanjutan Mediator Komuniti (MKP) secara manual. 
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section-body mt-3" style="display:none;" id="ppm_status_permohonan">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-primary alert-dismissible fade show small" role="alert" id="alert_status_permohonan">
                            <div class="mb-10">
                                <code><span style="font-size: 16px;"><strong>No Rujukan MKP : <span id="ppm_no_rujukan_mkp_1" name="ppm_no_rujukan_mkp_1"></span></span></strong></span></code>
                                <br><br>
                                <code><span style="font-size: 16px;"><strong>Status : <span class="blink" id="ppm_status_description_1" name="ppm_status_description_1"></span></span></strong></span></code>
                                <br><br>
                                <span style="display:none;" id="note_dihantar">
                                Permohonan Pelanjutan Mediator Komuniti sedang dalam proses tindakan Pegawai Perpaduan.
                                <br>
                                <br>
                                Sepanjang proses tindakan Pegawai Perpaduan ini, maklumat yang dibekalkan dikunci untuk seketika. Maklumat ini akan dapat diubah sekiranya terdapat maklumbalas daripada pihak Pegawai Perpaduan untuk dikemaskini oleh pihak MKP.
                                </span>
                                <span style="display:none;" id="note_kemaskini">
                                <code><span style="font-size: 16px;"><strong>Note:</strong></span></code>
                                <span id="ppm_disokong_note" name="ppm_disokong_note"></span></span>
                                <span id="ppm_disokong_p_note" name="ppm_disokong_p_note"></span></span>
                                <span id="ppm_disahkan_note" name="ppm_disahkan_note"></span></span>
                                <span id="ppm_disemak_note" name="ppm_disemak_note"></span></span>
                                <span id="ppm_dilulus_note" name="ppm_dilulus_note"></span></span>
                                <span id="ppm_dilantik_note" name="ppm_dilantik_note"></span></span>.
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section-body mt-3"  id="ppm_status_keaktifan">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert" >
                            <div class="mb-10">
                                <code><span style="font-size: 16px;"><strong>No Rujukan MKP : <span id="ppm_no_rujukan_mkp_2" name="ppm_no_rujukan_mkp_2"></span></span></strong></span></code>
                                <br><br>
                                 Maklumat ini Dikunci Seketika Sehingga maklumat keaktifan disemak oleh Pegawai Perpaduan.
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
                                                <form method="POST" id="form_ppm">
                                                @csrf
                                                    <h6><b>MAKLUMAT KAWASAN RUKUN TETANGGA</b></h6>
                                                    <br>
                                                    <div class="form-group">
                                                        <label class="custom-switch">
                                                            <input type="checkbox" name="ppm_hasRT" id="ppm_hasRT" class="custom-switch-input">
                                                            <span class="custom-switch-indicator"></span>
                                                            <span class="custom-switch-description">Dalam Kawasan KRT</span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Negeri: </label>
                                                        <select class="form-control" name="ppm_state_id" id="ppm_state_id" disabled>
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            @foreach($negeri as $item)                                    
                                                                <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="error_ppm_state_id invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Daerah: </label>
                                                        <select class="form-control" name="ppm_daerah_id" id="ppm_daerah_id" disabled>
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            @foreach($daerah as $item)                                    
                                                                <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="error_ppm_daerah_id invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Nama KRT: </label>
                                                        <select class="form-control" name="ppm_krt_profile_id" id="ppm_krt_profile_id" disabled></select>
                                                        <div class="error_ppm_krt_profile_id invalid-feedback text-right"></div>
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
                                                <form method="POST" id="form_ppm1">
                                                @csrf
                                                    <div class="row clearfix">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group text-center">
                                                                <img src="" class="avatar" alt="Profile Image" id="ppm1_mkp_gambar" name="ppm1_mkp_gambar" width="230px"/><br><br>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Nama Pemohon: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="ppm1_mkp_pemohon_nama" id="ppm1_mkp_pemohon_nama" placeholder="Nama Pemohon">
                                                                <div class="error_ppm1_mkp_pemohon_nama invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <b>Tarikh Lahir: <span class="text-red">*</span></b>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                    </div>
                                                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="ppm1_mkp_pemohon_tarikh_lahir" id="ppm1_mkp_pemohon_tarikh_lahir" placeholder="Tarikh Lahir" data-date-format="dd/mm/yyyy">
                                                                    <div class="error_ppm1_mkp_pemohon_tarikh_lahir invalid-feedback text-right"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Daerah: </label>
                                                                <select class="form-control" name="ppm1_mkp_pemohon_daerah_id" id="ppm1_mkp_pemohon_daerah_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($daerah as $item)                                    
                                                                        <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Dun: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="ppm1_mkp_pemohon_dun_id" id="ppm1_mkp_pemohon_dun_id">
                                                                </select>
                                                                <div class="error_ppm1_mkp_pemohon_dun_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Mukim : <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="ppm1_mkp_pemohon_mukim_id" id="ppm1_mkp_pemohon_mukim_id" placeholder="Mukim">
                                                                <div class="error_ppm1_mkp_pemohon_mukim_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Kaum: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="ppm1_mkp_pemohon_kaum_id" id="ppm1_mkp_pemohon_kaum_id">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($kaum as $item)                                    
                                                                        <option value="{{ $item->id }}">{{ $item->kaum_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_ppm1_mkp_pemohon_kaum_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Alamat Rumah: <span class="text-red">*</span></label>
                                                                <textarea class="form-control" id="ppm1_mkp_pemohon_alamat" name="ppm1_mkp_pemohon_alamat" rows="4" placeholder="Alamat Rumah"></textarea>
                                                                <div class="error_ppm1_mkp_pemohon_alamat invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">No Telefon : <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="ppm1_mkp_pemohon_no_phone" id="ppm1_mkp_pemohon_no_phone" placeholder="No Telefon">
                                                                <div class="error_ppm1_mkp_pemohon_no_phone invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Kategori MKP: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="ppm1_mkp_pemohon_kategori_id" id="ppm1_mkp_pemohon_kategori_id">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($mkp_kategori as $item)                                    
                                                                        <option value="{{ $item->id }}">{{ $item->kategori_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_ppm1_mkp_pemohon_kategori_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Kelulusan Akademik: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="ppm1_mkp_pemohon_akademik" id="ppm1_mkp_pemohon_akademik">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($pendidikan as $item)                                    
                                                                        <option value="{{ $item->id }}">{{ $item->pendidikan_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_ppm1_mkp_pemohon_akademik invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <b>Tarikh Pelantikan: <span class="text-red">*</span></b>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                    </div>
                                                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="ppm1_mkp_tarikh_dilantik" id="ppm1_mkp_tarikh_dilantik" placeholder="Tarikh Lahir" data-date-format="dd/mm/yyyy">
                                                                    <div class="error_ppm1_mkp_tarikh_dilantik invalid-feedback text-right"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">No Kad Pengenalan: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="ppm1_mkp_pemohon_ic" id="ppm1_mkp_pemohon_ic" placeholder="No Kad Pengenalan">
                                                                <div class="error_ppm1_mkp_pemohon_ic invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Negeri: </label>
                                                                <select class="form-control" name="ppm1_mkp_pemohon_state_id" id="ppm1_mkp_pemohon_state_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($negeri as $item)                                    
                                                                        <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_ppm1_mkp_pemohon_state_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Parlimen: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="ppm1_mkp_pemohon_parlimen_id" id="ppm1_mkp_pemohon_parlimen_id" disabled></select>
                                                                <div class="error_ppm1_mkp_pemohon_parlimen_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">PBT: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="ppm1_mkp_pemohon_pbt_id" id="ppm1_mkp_pemohon_pbt_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                </select>
                                                                <div class="error_ppm1_mkp_pemohon_pbt_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Jantina: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="ppm1_mkp_pemohon_jantina_id" id="ppm1_mkp_pemohon_jantina_id">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($jantina as $item)                                    
                                                                        <option value="{{ $item->id }}">{{ $item->jantina_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_ppm1_mkp_pemohon_jantina_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Emel : </label>
                                                                <input type="text" class="form-control" name="ppm1_mkp_pemohon_email" id="ppm1_mkp_pemohon_email" placeholder="Emel" disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Alamat Pejabat: <span class="text-red">*</span></label>
                                                                <textarea class="form-control" rows="4" id="ppm1_mkp_pemohon_alamat_p" name="ppm1_mkp_pemohon_alamat_p" placeholder="Alamat Pejabat"></textarea>
                                                                <div class="error_ppm1_mkp_pemohon_alamat_p invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">No Telefon Pejabat : <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="ppm1_mkp_pemohon_no_phone_p" id="ppm1_mkp_pemohon_no_phone_p" placeholder="No Telefon Pejabat">
                                                                <div class="error_ppm1_mkp_pemohon_no_phone_p invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Tahap MKP: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="ppm1_mkp_pemohon_tahap_id" id="ppm1_mkp_pemohon_tahap_id">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($mkp_tahap as $item)                                    
                                                                        <option value="{{ $item->id }}">{{ $item->tahap_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_ppm1_mkp_pemohon_tahap_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Pengkhususan (kemahiran): <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="ppm1_mkp_pemohon_khusus" id="ppm1_mkp_pemohon_khusus" placeholder="Pengkhususan">
                                                                <div class="error_ppm1_mkp_pemohon_khusus invalid-feedback text-right"></div>
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
                                                        <form action="#" id="form_ppm2">
                                                        {{ csrf_field() }}
                                                            <div class="series-frame">
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <div class="col-md-12 alert alert-danger error_alert" role="alert" style="display: none; padding-bottom: 0px;">
                                                                        <ul></ul>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Nama Kursus : </label>
                                                                        <input type="text" class="form-control" name="ppm2_kursus_nama" id="ppm2_kursus_nama" placeholder="Isu / Masalah">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Kategori Kursus: </label>
                                                                        <select class="form-control" name="ppm2_mkp_kategori_kursus_id" id="ppm2_mkp_kategori_kursus_id">
                                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                            @foreach($kategori_kursus as $item)                                    
                                                                                <option value="{{ $item->id }}">{{ $item->kursus_description }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Peringkat Kursus: </label>
                                                                        <select class="form-control" name="ppm2_mkp_peringkat_kursus_id" id="ppm2_mkp_peringkat_kursus_id">
                                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                            @foreach($peringkat_kursus as $item)                                    
                                                                                <option value="{{ $item->id }}">{{ $item->peringkat_description }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Penganjur : </label>
                                                                        <input type="text" class="form-control" name="ppm2_kursus_penganjur" id="ppm2_kursus_penganjur" placeholder="Status Pelaksana">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Dokumen : </label>
                                                                        <input type="file" class="form-control" name="ppm2_file_dokument" id="ppm2_file_dokument" placeholder="Dokumen">
                                                                    </div>
                                                                    <input type="hidden" name="ppm2_spk_imediator_id" id="ppm2_spk_imediator_id">
                                                                    <input type="hidden" name="post_imediator_kursus" value="add">
                                                                    <button type="submit" class="btn btn-primary pull-right" id="btn_submit_kursus"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <br/><br/>
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
                                            <form method="POST" id="form_ppm3">
                                            @csrf
                                                <input type="hidden" name="ppm3_spk_imediator_id" id="ppm3_spk_imediator_id">
                                                <input type="hidden" name="post_mohon_pelanjutan_mkp" value="edit">
                                                <input type="hidden" name="action" id="post_mohon_pelanjutan_mkp" value="edit">
                                                <button type="submit" class="btn btn-primary" id="btn_submit">Hantar Permohonan Pelanjutan MKP&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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

@include('js.rt-sm23.j-permohonan-pelanjutan-mkp')
