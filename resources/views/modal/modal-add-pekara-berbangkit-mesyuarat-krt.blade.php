<div class="modal fade" id="modal_add_pekara_berbangkit_mesyuarat_krt" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Perkara-perkara Berbangkit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" id="form_mapbmk">
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
                                <label class="form-label">Perkara: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="mapbmk_berbangkit_perkara" id="mapbmk_berbangkit_perkara" placeholder="Perkara">
                                <div class="error_mapbmk_berbangkit_perkara invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tindakan Yang Diambil: <span class="text-red">*</span></label>
                                <textarea class="form-control" rows="4" name="mapbmk_berbangkit_tindakan" id="mapbmk_berbangkit_tindakan"></textarea>
                                <div class="error_mapbmk_berbangkit_tindakan invalid-feedback text-right"></div>
                            </div>
							<div class="form-group">
                                <label class="form-label">Tindakan: <span class="text-red">*</span></label>
								<input type="text" class="form-control" name="mapbmk_berbangkit_tindakan_siapa" id="mapbmk_berbangkit_tindakan_siapa" placeholder="Tindakan siapa">
                                <div class="error_mapbmk_berbangkit_tindakan_siapa invalid-feedback text-right"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="mapbmk_krt_minit_mesyuarat_id" id="mapbmk_krt_minit_mesyuarat_id" value="{{$krt_minit_mesyuarat->id}}">
                    <input type="hidden" name="action" id="add_pekara_berbangkit_mesyuarat" value="add">
                    <input type="hidden" name="add_pekara_berbangkit_mesyuarat" value="add">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn_save"><i class="fe fe-plus mr-2"></i>Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>