<div class="modal fade" id="modal_add_kedudukan_kes" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="POST" id="form_makk">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kedudukan Kes</h5>
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
                                <label class="form-label">Jenis / Nama Harta Benda yang Musnah: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="makk_jenis_harta" id="makk_jenis_harta" placeholder="Jenis / Nama Harta Benda yang Musnah">
                                <div class="error_makk_jenis_harta invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nilai Anggaran Kerosakan: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="makk_nilai_anggaran_kerosakan" id="makk_nilai_anggaran_kerosakan" placeholder="Nilai Anggaran Kerosakan">
                                <div class="error_makk_nilai_anggaran_kerosakan invalid-feedback text-right"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="makk_ikes_id" id="makk_ikes_id" value="{{$ikes->id}}">
                    <input type="hidden" name="action" id="add_kedudukan_kes" value="add">
                    <input type="hidden" name="add_kedudukan_kes" value="add">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn_add"><i class="fe fe-plus mr-2"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
