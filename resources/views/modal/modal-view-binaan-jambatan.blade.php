<div class="modal fade" id="modal_view_binaan_jambatan" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Paparan Binaan Jabatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" id="form_mabj">
            @csrf
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Jenis Premis: </label>
                                <select class="form-control" name="mvbj_binaan_jenis_premis_id" id="mvbj_binaan_jenis_premis_id" disabled>
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                    @foreach($jenis_premis_binaan as $item)                                    
                                        <option value="{{ $item->id }}">{{ $item->jenis_premis_description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Alamat: </label>
                                <textarea class="form-control" rows="4" name="mvbj_binaan_alamat" id="mvbj_binaan_alamat" placeholder="Alamat" disabled></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Status Tanah: </label>
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="mvbj_status_tanah_id" value="1" disabled>
                                        <span class="custom-control-label">Tanah Kerajaan Persekutuan</span>
                                    </label><br>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="mvbj_status_tanah_id" value="2" disabled>
                                        <span class="custom-control-label">Tanah Kerajaan Negeri</span>
                                    </label><br>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="mvbj_status_tanah_id" value="3" disabled>
                                        <span class="custom-control-label">Tanah Persendirian (milik individu)</span>
                                    </label><br>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="mvbj_status_tanah_id" value="4" disabled>
                                        <span class="custom-control-label">Tanah Wakaf</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Kos Pembinaan Bangunan (RM):</label>
                                <input type="text" class="form-control" name="mvbj_binaan_kos" id="mvbj_binaan_kos" placeholder="Kos Pembinaan Bangunan" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Keluasan (Meter Persegi): </label>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Tanah: </label>
                                <input type="text" class="form-control" name="mvbj_binaan_keluasan_tanah" id="mvbj_binaan_keluasan_tanah" placeholder="Tanah" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Bangunan: </label>
                                <input type="text" class="form-control" name="mvbj_binaan_keluasan_bagunan" id="mvbj_binaan_keluasan_bagunan" placeholder="Bangunan" disabled>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <b>Tarikh Mula Digunakan: </b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="mvbj_binaan_tarikh_mula_bina" id="mvbj_binaan_tarikh_mula_bina" placeholder="Tarikh Mula Bina Bangunan" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Pengguna Bangunan: </label>
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="mvbj_binaan_pengguna_rt" value='1' disabled>
                                        <span class="custom-control-label">RT</span>
                                    </label>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="mvbj_binaan_pengguna_srs" value='1' disabled>
                                        <span class="custom-control-label">SRS</span>
                                    </label>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="mvbj_binaan_pengguna_tabika" value='1' disabled>
                                        <span class="custom-control-label">Tabika</span>
                                    </label>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="mvbj_binaan_pengguna_taska" value='1' disabled>
                                        <span class="custom-control-label">Taska</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Isu Bangunan Sekiranya Ada: </label>
                                <textarea class="form-control" rows="4" placeholder="Isu Bangunan Sekiranya Ada" name="mvbj_binaan_isu" id="mvbj_binaan_isu" disabled></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>