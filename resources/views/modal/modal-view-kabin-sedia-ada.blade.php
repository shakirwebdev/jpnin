<div class="modal fade" id="modal_view_kabin_sedia_ada" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Paparan Maklumat Kabin Sedia Ada</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label class="form-label">Jenis Kabin: </label>
                            <select class="form-control" name="mvksa_kabin_jenis" id="mvksa_kabin_jenis" disabled>
                                @foreach($kabin as $item)                                    
                                    <option value="{{ $item->id }}">{{ $item->jenis_kabin_description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nyatakan Sumbangan Lain: </label>
                            <input type="text" class="form-control" name="mvksa_kabin_sumbangan_lain" id="mvksa_kabin_sumbangan_lain" placeholder="Nyatakan Sumbangan Lain" disabled="">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Alamat: </label>
                            <textarea class="form-control" rows="4" name="mvksa_kabin_alamat" id="mvksa_kabin_alamat" placeholder="Alamat" disabled></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status Tanah: </label>
                            <div class="custom-controls-stacked">
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" name="mvksa_kabin_status_tanah_id" value="1" disabled>
                                    <span class="custom-control-label">Tanah Kerajaan Persekutuan</span>
                                </label><br>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" name="mvksa_kabin_status_tanah_id" value="2" disabled>
                                    <span class="custom-control-label">Tanah Kerajaan Negeri</span>
                                </label><br>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" name="mvksa_kabin_status_tanah_id" value="3" disabled>
                                    <span class="custom-control-label">Tanah Swasta</span>
                                </label><br>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" name="mvksa_kabin_status_tanah_id" value="4" disabled>
                                    <span class="custom-control-label">Tanah Persendirian (milik individu)</span>
                                </label><br>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" name="mvksa_kabin_status_tanah_id" value="5" disabled>
                                    <span class="custom-control-label">Tanah Wakaf</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <b>Tarikh Mula Bina Digunakan: </b>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                                <input type="text" name="mvksa_kabin_tarikh_bina" id="mvksa_kabin_tarikh_bina" class="form-control" placeholder="Tarikh Mula Bina Bangunan" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Anggaran Kos: </label>
                            <input type="text" class="form-control" name="mvksa_kabin_kos" id="mvksa_kabin_kos" placeholder="Anggaran Kos Kabin" disabled>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Pengguna Bangunan: </label>
                            <div class="custom-controls-stacked">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="mvksa_kabin_pengguna_rt" disabled>
                                    <span class="custom-control-label">RT</span>
                                </label>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="mvksa_kabin_pengguna_srs" disabled>
                                    <span class="custom-control-label">SRS</span>
                                </label>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="mvksa_kabin_pengguna_tabika" disabled>
                                    <span class="custom-control-label">Tabika</span>
                                </label>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="mvksa_kabin_pengguna_taska" disabled>
                                    <span class="custom-control-label">Taska</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Isu Bangunan Sekiranya Ada: </label>
                            <textarea class="form-control" name="mvksa_kabin_isu" id="mvksa_kabin_isu" rows="4" placeholder="Isu Bangunan Sekiranya Ada" disabled></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>