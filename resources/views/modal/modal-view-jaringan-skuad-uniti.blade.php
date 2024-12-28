<div class="modal fade" id="modal_view_jaringan_skuad_uniti" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Paparan Jaringan Kerjasama Strategik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" id="form_mvjsu">
            @csrf
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Nama Agensi: </label>
                                <input type="text" class="form-control" name="mvjsu_jaringan_agensi_nama" id="mvjsu_jaringan_agensi_nama" placeholder="Nama Agensi" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nama Pegawai: </label>
                                <input type="text" class="form-control" name="mvjsu_jaringan_nama_pegawai" id="mvjsu_jaringan_nama_pegawai" placeholder="Nama Penuh" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label">No Telefon: </label>
                                <input type="text" class="form-control" name="mvjsu_jaringan_no_telefon" id="mvjsu_jaringan_no_telefon" placeholder="No Telefon" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jenis Kerjasama Yang Dipersetujui: </label>
                                <input type="text" class="form-control" name="mvjsu_jaringan_kerjasama" id="mvjsu_jaringan_kerjasama" placeholder="Jenis Kerjasama Yang Dipersetujui" disabled>
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