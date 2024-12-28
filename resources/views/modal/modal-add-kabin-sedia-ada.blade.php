<div class="modal fade" id="modal_add_kabin_sedia_ada" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Maklumat Kabin/Bangunan Binaan Sendiri Sedia Ada</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="POST" id="form_maksa">
            @csrf
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-12">
                            <div class="mb-4">
                                <small>Isi maklumat pada borang yang disediakan dibawah, dan tekan butang TAMBAH. 
                                <br>
                                Ruangan bertanda <span class="text-red">*</span> adalah ruangan mandatori dan perlu diisi..&nbsp;&nbsp;<a href="#"><i class="dropdown-icon fe fe-help-circle"></i></a></small>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="col-md-12 alert alert-danger error_alert" role="alert" style="display: none; padding-bottom: 0px;">
                                <ul></ul>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jenis Kabin/Bangunan: <span class="text-red">*</span></label>
                                <select class="form-control" name="maksa_kabin_jenis" id="maksa_kabin_jenis">
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                    @foreach($kabin as $item)                                    
                                        <option value="{{ $item->id }}">{{ $item->jenis_kabin_description }}</option>
                                    @endforeach
                                </select>
                                <div class="error_maksa_kabin_jenis invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nyatakan Sumbangan Lain: </label>
                                <input type="text" class="form-control" name="maksa_kabin_sumbangan_lain" id="maksa_kabin_sumbangan_lain" placeholder="Nyatakan Sumbangan Lain" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Alamat: <span class="text-red">*</span></label>
                                <textarea class="form-control" rows="4" name="maksa_kabin_alamat" id="maksa_kabin_alamat" placeholder="Alamat"></textarea>
                                <div class="error_maksa_kabin_alamat invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Status Tanah: <span class="text-red">*</span></label>
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="maksa_kabin_status_tanah_id" value="1">
                                        <span class="custom-control-label">Tanah Kerajaan Persekutuan</span>
                                    </label><br>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="maksa_kabin_status_tanah_id" value="2">
                                        <span class="custom-control-label">Tanah Kerajaan Negeri</span>
                                    </label><br>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="maksa_kabin_status_tanah_id" value="3">
                                        <span class="custom-control-label">Tanah Swasta</span>
                                    </label><br>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="maksa_kabin_status_tanah_id" value="4">
                                        <span class="custom-control-label">Tanah Persendirian (milik individu)</span>
                                    </label><br>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="maksa_kabin_status_tanah_id" value="5">
                                        <span class="custom-control-label">Tanah Wakaf</span>
                                    </label>
                                </div>
                                <div class="maksa_kabin_status_tanah_id invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <b>Tarikh Mula Digunakan: <span class="text-red">*</span></b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="maksa_kabin_tarikh_bina" id="maksa_kabin_tarikh_bina" placeholder="Tarikh Mula Bina Bangunan" data-date-format="dd/mm/yyyy">
                                    <div class="error_maksa_kabin_tarikh_bina invalid-feedback text-right"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Anggaran Kos: </label>
                                <input type="text" class="form-control" name="maksa_kabin_kos" id="maksa_kabin_kos" placeholder="Anggaran Kos Kabin">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Pengguna Bangunan: <span class="text-red">*</span></label>
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="maksa_kabin_pengguna_rt" value="1">
                                        <span class="custom-control-label">RT</span>
                                    </label>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="maksa_kabin_pengguna_srs" value="1">
                                        <span class="custom-control-label">SRS</span>
                                    </label>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="maksa_kabin_pengguna_tabika" value="1">
                                        <span class="custom-control-label">Tabika</span>
                                    </label>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="maksa_kabin_pengguna_taska" value="1">
                                        <span class="custom-control-label">Taska</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Isu Bangunan Sekiranya Ada: <span class="text-red">*</span></label>
                                <textarea class="form-control" rows="4" name="maksa_kabin_isu" id="maksa_kabin_isu" placeholder="Isu Bangunan Sekiranya Ada"></textarea>
                                <div class="error_maksa_kabin_isu invalid-feedback text-right"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="maksa_krt_profileID" id="maksa_krt_profileID" value="{{$profile_krt->id}}">
                    <input type="hidden" name="action" id="add_kabin" value="add">
                    <input type="hidden" name="add_kabin" value="add">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn_save"><i class="fe fe-plus mr-2"></i>Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>