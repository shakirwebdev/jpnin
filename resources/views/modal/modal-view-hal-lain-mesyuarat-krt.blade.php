<div class="modal fade" id="modal_view_hal_lain_mesyuarat_krt" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Paparan Hal-Hal Lain</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" id="form_mvhlmk">
            @csrf
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Perkara: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="mvhlmk_hal_lain_perkara" id="mvhlmk_hal_lain_perkara" placeholder="Perkara" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tindakan Yang Diambil: <span class="text-red">*</span></label>
                                <textarea class="form-control" rows="4" name="mvhlmk_hal_lain_tindakan" id="mvhlmk_hal_lain_tindakan" disabled></textarea>
                            </div>
							<div class="form-group">
                                <label class="form-label">Tindakan Siapa: <span class="text-red">*</span></label>
                                <textarea class="form-control" rows="4" name="mvhlmk_hal_lain_tindakan_siapa" id="mvhlmk_hal_lain_tindakan_siapa" disabled></textarea>
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