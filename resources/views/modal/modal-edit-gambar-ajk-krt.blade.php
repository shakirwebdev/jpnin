<div class="modal fade" id="modal_edit_gambar" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kemaskini Gambar Profil AJK</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="#" id="form_meg">
            {{ csrf_field() }}
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
                                <label class="form-label">Fail Gambar Profil Ajk: <span class="text-red">*</span></label>
                                <input type="file" class="form-control" name="meg_file_avatar" id="meg_file_avatar" placeholder="Fail Gambar Profil Ajk">
                                <div class="error_meg_file_avatar invalid-feedback text-right"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="meg_krt_ajk_krt_id" id="meg_krt_ajk_krt_id">
                    <input type="hidden" name="action" id="post_edit_gambar" value="edit">
                    <input type="hidden" name="post_edit_gambar" value="edit">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn_edit"><i class="fa fa-edit mr-2"></i>Kemaskini</button>
                </div>
            </form>
        </div>
    </div>
</div>