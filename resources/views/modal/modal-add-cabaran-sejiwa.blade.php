<div class="modal fade" id="modal_add_cabaran_sejiwa" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Cabaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" id="form_psk7">
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
                                <label class="form-label">Cabaran: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="psk7_cabaran_sejiwa_cabaran" id="psk7_cabaran_sejiwa_cabaran" placeholder="Cabaran">
                                <div class="error_psk7_cabaran_sejiwa_cabaran invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Cara Mengatasi: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="psk7_cabaran_sejiwa_mengatasi" id="psk7_cabaran_sejiwa_mengatasi" placeholder="Cara Mengatasi">
                                <div class="error_psk7_cabaran_sejiwa_mengatasi invalid-feedback text-right"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="psk7_sejiwa_id" id="psk7_sejiwa_id" value="{{$sejiwa->id}}">
                    <input type="hidden" name="action" id="add_cabaran_sejiwa" value="add">
                    <input type="hidden" name="add_cabaran_sejiwa" value="add">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn_save"><i class="fe fe-plus mr-2"></i>Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>