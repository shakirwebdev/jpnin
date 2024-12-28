<div class="modal fade" id="modal_view_kehadiran_mesyuarat_krt" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Paparan Senarai Kehadiran Mesyuarat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" id="form_mvkmk">
            @csrf
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Nama Penuh: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="mvkmk_kehadiran_nama" id="mvkmk_kehadiran_nama" placeholder="Nama" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Kad Pengenalan: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="mvkmk_kehadiran_ic" id="mvkmk_kehadiran_ic" placeholder="Kad Pengenalan" disabled>
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