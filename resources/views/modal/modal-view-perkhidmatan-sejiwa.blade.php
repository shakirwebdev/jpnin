<div class="modal fade" id="modal_view_perkhidmatan_sejiwa" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Paparan Perkhidmatan Sejiwa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" id="form_mvps">
            @csrf
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Keperluan/ Masalah/ Isu: </label>
                                <textarea class="form-control" id="mvps_perkhidmatan_sejiwa_keperluan" name="mvps_perkhidmatan_sejiwa_keperluan" rows="4" placeholder="Keperluan/ Masalah/ Isu" disabled></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jenis Aktiviti/ Perkhidmatan SeJiwa (Penumpuan): </label>
                                <input type="text" class="form-control" name="mvps_perkhidmatan_sejiwa_perkhidmatan" id="mvps_perkhidmatan_sejiwa_perkhidmatan" placeholder="Jenis Aktiviti/ Perkhidmatan SeJiwa (Penumpuan)" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Kerjasama (Agensi Dan Bentuk Kerjasama): </label>
                                <input type="text" class="form-control" name="mvps_perkhidmatan_sejiwa_kerjasama" id="mvps_perkhidmatan_sejiwa_kerjasama" placeholder="Kerjasama (Agensi Dan Bentuk Kerjasama)" disabled>
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