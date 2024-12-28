<div class="modal fade" id="modal_add_biro_skuad_uniti" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Biro Skuad Uniti</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" id="form_psuk3">
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
                                <label class="form-label">Nama Biro: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="psuk3_biro_nama" id="psuk3_biro_nama" placeholder="Nama Biro">
                                <div class="error_psuk3_biro_nama invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nama Penuh: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="psuk3_biro_nama_penuh" id="psuk3_biro_nama_penuh" placeholder="Nama Penuh">
                                <div class="error_psuk3_biro_nama_penuh invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">No Kad Pengenalan: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="psuk3_biro_ic" id="psuk3_biro_ic" placeholder="XXXXXXXXXXXX">
                                <div class="error_psuk3_biro_ic invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">No Telefon: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="psuk3_biro_phone" id="psuk3_biro_phone" placeholder="No Telefon">
                                <div class="error_psuk3_biro_phone invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Emel: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="psuk3_biro_emel" id="psuk3_biro_emel" placeholder="Emel">
                                <div class="error_psuk3_biro_emel invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Pekerjaan: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="psuk3_biro_pekerjaan" id="psuk3_biro_pekerjaan" placeholder="Pekerjaan">
                                <div class="error_psuk3_biro_pekerjaan invalid-feedback text-right"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="psuk3_skuad_uniti_id" id="psuk3_skuad_uniti_id" value="{{$skuad_uniti->id}}">
                    <input type="hidden" name="action" id="add_biro_skuad_uniti" value="add">
                    <input type="hidden" name="add_biro_skuad_uniti" value="add">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn_save"><i class="fe fe-plus mr-2"></i>Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>