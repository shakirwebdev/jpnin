<div class="modal fade" id="modal_add_gambar_peronda_srs" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Masukan Gambar Peronda SRS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="#" id="form_magps">
            {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-12">
                            <div class="mb-4">
                                <small>Isi maklumat pada borang yang disediakan dibawah, dan tekan butang KEMASKINI. 
                                <br>
                                Ruangan bertanda <span class="text-red">*</span> adalah ruangan mandatori dan perlu diisi..&nbsp;&nbsp;<a href="#"><i class="dropdown-icon fe fe-help-circle"></i></a></small>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Fail Gambar Peronda SRS: <span class="text-red">*</span></label>
                                <input type="file" class="form-control" name="magps_file_gambar_profile" id="magps_file_gambar_profile" placeholder="Fail Gambar Peronda SRS">
                                <div class="error_magps_file_gambar_profile invalid-feedback text-right"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="magps_ahli_peronda_id" id="magps_ahli_peronda_id">
                    <input type="hidden" name="action" id="post_add_gambar_peronda_srs" value="edit">
                    <input type="hidden" name="post_add_gambar_peronda_srs" value="edit">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn_add"><i class="fa fa-edit mr-2"></i>Kemaskini</button>
                </div>
            </form>
        </div>
    </div>
</div>