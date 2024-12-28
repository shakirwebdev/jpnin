<div class="modal fade" id="modal_add_perkhidmatan_sejiwa" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Perkhidmatan Sejiwa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" id="form_psk5">
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
                                <label class="form-label">Keperluan/ Masalah/ Isu: <span class="text-red">*</span></label>
                                <textarea class="form-control" id="psk5_perkhidmatan_sejiwa_keperluan" name="psk5_perkhidmatan_sejiwa_keperluan" rows="4" placeholder="Keperluan/ Masalah/ Isu"></textarea>
                                <div class="error_psk5_perkhidmatan_sejiwa_keperluan invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jenis Aktiviti/ Perkhidmatan SeJiwa (Penumpuan): <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="psk5_perkhidmatan_sejiwa_perkhidmatan" id="psk5_perkhidmatan_sejiwa_perkhidmatan" placeholder="Jenis Aktiviti/ Perkhidmatan SeJiwa (Penumpuan)">
                                <div class="error_psk5_perkhidmatan_sejiwa_perkhidmatan invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Kerjasama (Agensi Dan Bentuk Kerjasama): <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="psk5_perkhidmatan_sejiwa_kerjasama" id="psk5_perkhidmatan_sejiwa_kerjasama" placeholder="Kerjasama (Agensi Dan Bentuk Kerjasama)">
                                <div class="psk5_perkhidmatan_sejiwa_kerjasama invalid-feedback text-right"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="psk5_sejiwa_id" id="psk5_sejiwa_id" value="{{$sejiwa->id}}">
                    <input type="hidden" name="action" id="add_perkhidmatan_sejiwa" value="add">
                    <input type="hidden" name="add_perkhidmatan_sejiwa" value="add">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn_save"><i class="fe fe-plus mr-2"></i>Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>