<div class="modal fade" id="modal_add_jaringan_skuad_uniti" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Jaringan Kerjasama Strategik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" id="form_psuk4">
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
                                <label class="form-label">Nama Agensi: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="psuk4_jaringan_agensi_nama" id="psuk4_jaringan_agensi_nama" placeholder="Nama Agensi">
                                <div class="error_psuk4_jaringan_agensi_nama invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nama Pegawai: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="psuk4_jaringan_nama_pegawai" id="psuk4_jaringan_nama_pegawai" placeholder="Nama Penuh">
                                <div class="error_psuk4_jaringan_nama_pegawai invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">No Telefon: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="psuk4_jaringan_no_telefon" id="psuk4_jaringan_no_telefon" placeholder="No Telefon">
                                <div class="error_psuk4_jaringan_no_telefon invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jenis Kerjasama Yang Dipersetujui: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="psuk4_jaringan_kerjasama" id="psuk4_jaringan_kerjasama" placeholder="Jenis Kerjasama Yang Dipersetujui">
                                <div class="error_psuk4_jaringan_kerjasama invalid-feedback text-right"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="psuk4_skuad_uniti_id" id="psuk4_skuad_uniti_id" value="{{$skuad_uniti->id}}">
                    <input type="hidden" name="action" id="add_jaringan_skuad_uniti" value="add">
                    <input type="hidden" name="add_jaringan_skuad_uniti" value="add">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn_save"><i class="fe fe-plus mr-2"></i>Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>