<div class="modal fade" id="modal_add_binaan_jambatan" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Binaan Jabatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" id="form_mabj">
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
                            <div class="form-group">
                                <label class="form-label">Jenis Premis: <span class="text-red">*</span></label>
                                <select class="form-control" name="mabj_binaan_jenis_premis_id" id="mabj_binaan_jenis_premis_id">
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                    @foreach($jenis_premis_binaan as $item)                                    
                                        <option value="{{ $item->id }}">{{ $item->jenis_premis_description }}</option>
                                    @endforeach
                                </select>
                                <div class="error_mabj_binaan_jenis_premis_id invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Alamat: <span class="text-red">*</span></label>
                                <textarea class="form-control" rows="4" name="mabj_binaan_alamat" id="mabj_binaan_alamat" placeholder="Alamat"></textarea>
                                <div class="error_mabj_binaan_alamat invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Status Tanah: <span class="text-red">*</span></label>
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="mabj_status_tanah_id" value="1">
                                        <span class="custom-control-label">Tanah Kerajaan Persekutuan</span>
                                    </label><br>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="mabj_status_tanah_id" value="2">
                                        <span class="custom-control-label">Tanah Kerajaan Negeri</span>
                                    </label><br>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="mabj_status_tanah_id" value="3">
                                        <span class="custom-control-label">Tanah Persendirian (milik individu)</span>
                                    </label><br>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="mabj_status_tanah_id" value="4">
                                        <span class="custom-control-label">Tanah Wakaf</span>
                                    </label>
                                </div>
                                <div class="error_mabj_status_tanah_id invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Kos Pembinaan Bangunan (RM): </label>
                                <input type="text" class="form-control" name="mabj_binaan_kos" id="mabj_binaan_kos" placeholder="Kos Pembinaan Bangunan">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Keluasan (Meter Persegi): <span class="text-red">*</span></label>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Tanah: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="mabj_binaan_keluasan_tanah" id="mabj_binaan_keluasan_tanah" placeholder="Tanah">
                                <div class="error_mabj_binaan_keluasan_tanah invalid-feedback text-right"></div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Bangunan: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="mabj_binaan_keluasan_bagunan" id="mabj_binaan_keluasan_bagunan" placeholder="Bangunan">
                                <div class="error_mabj_binaan_keluasan_bagunan invalid-feedback text-right"></div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <b>Tarikh Mula Digunakan: <span class="text-red">*</span></b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="mabj_binaan_tarikh_mula_bina" id="mabj_binaan_tarikh_mula_bina" placeholder="Tarikh Mula Bina Bangunan" data-date-format="dd/mm/yyyy">
                                    <div class="error_mabj_binaan_tarikh_mula_bina invalid-feedback text-right"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Pengguna Bangunan: <span class="text-red">*</span></label>
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="mabj_binaan_pengguna_rt" value='1'>
                                        <span class="custom-control-label">RT</span>
                                    </label>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="mabj_binaan_pengguna_srs" value='1'>
                                        <span class="custom-control-label">SRS</span>
                                    </label>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="mabj_binaan_pengguna_tabika" value='1'>
                                        <span class="custom-control-label">Tabika</span>
                                    </label>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="mabj_binaan_pengguna_taska" value='1'>
                                        <span class="custom-control-label">Taska</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Isu Bangunan Sekiranya Ada: <span class="text-red">*</span></label>
                                <textarea class="form-control" rows="4" placeholder="Isu Bangunan Sekiranya Ada" name="mabj_binaan_isu" id="mabj_binaan_isu"></textarea>
                                <div class="error_mabj_binaan_isu invalid-feedback text-right"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="mabj_krt_profileID" id="mabj_krt_profileID" value="{{$profile_krt->id}}">
                    <input type="hidden" name="action" id="add_binaan_jambatan" value="add">
                    <input type="hidden" name="add_binaan_jambatan" value="add">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn_save"><i class="fe fe-plus mr-2"></i>Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>