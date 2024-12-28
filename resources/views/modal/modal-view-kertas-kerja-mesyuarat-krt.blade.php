<div class="modal fade" id="modal_view_kertas_kerja_mesyuarat_krt" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Paparan Pembentangan Kertas-kertas Kerja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" id="form_mvkkmk">
            @csrf
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Perkara: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="mvkkmk_kertas_kerja_perkara" id="mvkkmk_kertas_kerja_perkara" placeholder="Perkara" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tindakan Yang Diambil: <span class="text-red">*</span></label>
                                <textarea class="form-control" rows="4" name="mvkkmk_kertas_kerja_tindakan" id="mvkkmk_kertas_kerja_tindakan" disabled></textarea>
                            </div>
							<div class="form-group">
                                <label class="form-label">Tindakan Siapa: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="mvkkmk_kertas_kerja_tindakan_siapa" id="mvkkmk_kertas_kerja_tindakan_siapa" disabled>
                            </div>
							<div class="form-group">
                                <label class="form-label">Dokumen : </label>
                                <input type="text" class="form-control" name="mvkkmk_kertas_kerja_dokumen" id="mvkkmk_kertas_kerja_dokumen" disabled>
								<input type="button" id="btn_lihat" class="btn btn-secondary" data-dismiss="modal" value="Lihat">
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