<div class="modal fade" id="modal_add_markah_keaktifan_krt" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" id="form_mamkk">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Markah Penilaian Keaktifan Krt</h5>
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
                                <label class="form-label">Jumlah Markah: <span class="text-red">*</span><br><font class="text-red" style="font-size:11">(Markah penuh adalah 40%)</font></label>
                                <input type="number" class="form-control" name="mamkk_markah" id="mamkk_markah" placeholder="Jumlah Markah" min="0" max="40">
                                <div class="error_mamkk_markah invalid-feedback text-right"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="mamkk_krt_profile_id" id="mamkk_krt_profile_id">
                    <!-- <input type="text" name="mamkk_markah_1" id="mamkk_markah_1"> -->
                    <input type="hidden" name="action" id="add_markah_keaktifan_ppd" value="add">
                    <input type="hidden" name="add_markah_keaktifan_ppd" value="add">
					<input type="hidden" name="add_tahun" id="add_tahun" value="">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn_save"><i class="fe fe-plus mr-2"></i>Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>