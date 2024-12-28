<div class="modal fade" id="modal_view_biro_skuad_uniti" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Paparan Biro Skuad Uniti</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" id="form_mvbsu">
            @csrf
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Nama Biro: </label>
                                <input type="text" class="form-control" name="mvbsu_biro_nama" id="mvbsu_biro_nama" placeholder="Nama Biro" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nama Penuh: </label>
                                <input type="text" class="form-control" name="mvbsu_biro_nama_penuh" id="mvbsu_biro_nama_penuh" placeholder="Nama Penuh" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label">No Kad Pengenalan: </label>
                                <input type="text" class="form-control" name="mvbsu_biro_ic" id="mvbsu_biro_ic" placeholder="No Kad Pengenalan" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label">No Telefon: </label>
                                <input type="text" class="form-control" name="mvbsu_biro_phone" id="mvbsu_biro_phone" placeholder="No Telefon" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label">E-mel: </label>
                                <input type="text" class="form-control" name="mvbsu_biro_emel" id="mvbsu_biro_emel" placeholder="E-mel" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Pekerjaan: </label>
                                <input type="text" class="form-control" name="mvbsu_biro_pekerjaan" id="mvbsu_biro_pekerjaan" placeholder="Pekerjaan" disabled>
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