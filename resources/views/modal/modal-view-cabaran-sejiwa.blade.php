<div class="modal fade" id="modal_view_cabaran_sejiwa" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Paparan Cabaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" id="form_mvcs">
            @csrf
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Cabaran: </label>
                                <input type="text" class="form-control" name="mvcs_cabaran_sejiwa_cabaran" id="mvcs_cabaran_sejiwa_cabaran" placeholder="Cabaran" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Cara Mengatasi: </label>
                                <input type="text" class="form-control" name="mvcs_cabaran_sejiwa_mengatasi" id="mvcs_cabaran_sejiwa_mengatasi" placeholder="Cara Mengatasi" disabled>
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