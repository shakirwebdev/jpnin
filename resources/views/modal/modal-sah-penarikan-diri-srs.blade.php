<div class="modal fade" id="modal_sah_penarikan_diri_srs" tabindex="-1" role="dialog" aria-labelledby="ModalSRSLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-xl">
            <div class="modal-header">
                <h5 class="modal-title">Pengesahan Maklumat Penarikan Diri</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" id="form_mspds">
            @csrf
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Nama SRS: <span class="text-red">*</span></label>
                                <select class="form-control" name="mspds_srs_profile_id" id="mspds_srs_profile_id" disabled>
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                    @foreach($srs_profile as $item)                                    
                                        <option value="{{ $item->id }}">{{ $item->srs_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nama Ahli: <span class="text-red">*</span></label>
                                <select class="form-control" name="mspds_ahli_peronda_id" id="mspds_ahli_peronda_id" disabled>
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                    @foreach($ahli_peronda as $item)                                    
                                        <option value="{{ $item->id }}">{{ $item->peronda_nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">No Kad Pengenalan: </label>
                                <input type="text" class="form-control" name="mspds_peronda_ic" id="mspds_peronda_ic" placeholder="No KP / No Pasport" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Alamat: </label>
                                <textarea class="form-control" rows="4" name="mspds_peronda_alamat" id="mspds_peronda_alamat" disabled="" placeholder="Alamat"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Alasan Ingin Menarik Diri: <span class="text-red">*</span></label>
                            </div>
                            <div class="form-group">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="mspds_alasan_id" value="1" disabled>
                                        <span class="custom-control-label">Tidak Berminat</span>
                                    </label>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="mspds_alasan_id" value="2" disabled>
                                        <span class="custom-control-label">Berpindah dan tidak mempunyai kepentingan dalam kawasan</span>
                                    </label>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input enable_tb" name="mspds_alasan_id" value="3" disabled>
                                        <span class="custom-control-label">Lain-lain (Sila Nyatakan)</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows="4" name="mspds_penarikan_diri_nyatakan" id="mspds_penarikan_diri_nyatakan" disabled="" placeholder="Nyatakan"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Status Pengesahan: <span class="text-red">*</span></label>
                                <select class="form-control" name="mspds_penarikan_diri_status" id="mspds_penarikan_diri_status">
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                    <option value="1" > Disahkan</option>
                                    <option value="3" > Ditolak</option>
                                </select>
                                <div class="error_mspds_penarikan_diri_status invalid-feedback text-right"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="mspds_penarikan_diri_id" id="mspds_penarikan_diri_id">
                    <input type="hidden" name="mspds_ahli_peronda_srs_id" id="mspds_ahli_peronda_srs_id">
                    <input type="hidden" name="action" id="post_sahkan_penarikan_diri_srs" value="edit">
                    <input type="hidden" name="post_sahkan_penarikan_diri_srs" value="edit">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn_save">Hantar Pengesahan Penarikan Diri&nbsp;&nbsp;<i class="fa fa-send mr-2"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

