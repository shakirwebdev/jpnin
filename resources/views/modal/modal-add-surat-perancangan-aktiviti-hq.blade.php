<div class="modal fade" id="modal_add_surat_perancangan_aktiviti_hq" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" id="form_maspa">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Maklumat Surat Perancangan Aktiviti KRT</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
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
                                <label class="form-label">Tahun Perancangan Aktiviti RT: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="maspa_surat_tahun" id="maspa_surat_tahun" placeholder="Tahun Perancangan Aktiviti RT">
                                <div class="error_maspa_surat_tahun invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <b>Tarikh Surat: <span class="text-red">*</span></b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="maspa_surat_tarikh" id="maspa_surat_tarikh" placeholder="Tarikh Surat" data-date-format="dd/mm/yyyy">
                                    <div class="error_maspa_surat_tarikh invalid-feedback text-right"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" id="add_surat_perancangan_aktiviti_hq" value="add">
                    <input type="hidden" name="add_surat_perancangan_aktiviti_hq" value="add">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn_save"><i class="fe fe-plus mr-2"></i>Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>