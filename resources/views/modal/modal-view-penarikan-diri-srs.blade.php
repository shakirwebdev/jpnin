<div class="modal fade" id="modal_view_penarikan_diri_srs" tabindex="-1" role="dialog" aria-labelledby="ModalSRSLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-xl">
            <div class="modal-header">
                <h5 class="modal-title">Paparan Maklumat Penarikan Diri</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" id="form_mvpds">
            @csrf
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Nama SRS: <span class="text-red">*</span></label>
                                <select class="form-control" name="mvpds_srs_profile_id" id="mvpds_srs_profile_id" disabled>
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                    @foreach($srs_profile as $item)                                    
                                        <option value="{{ $item->id }}">{{ $item->srs_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nama Ahli: <span class="text-red">*</span></label>
                                <select class="form-control" name="mvpds_ahli_peronda_id" id="mvpds_ahli_peronda_id" disabled>
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                    @foreach($ahli_peronda as $item)                                    
                                        <option value="{{ $item->id }}">{{ $item->peronda_nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">No Kad Pengenalan: </label>
                                <input type="text" class="form-control" name="mvpds_peronda_ic" id="mvpds_peronda_ic" placeholder="No KP / No Pasport" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Alamat: </label>
                                <textarea class="form-control" rows="4" name="mvpds_peronda_alamat" id="mvpds_peronda_alamat" disabled="" placeholder="Alamat"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Alasan Ingin Menarik Diri: <span class="text-red">*</span></label>
                            </div>
                            <div class="form-group">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="mvpds_alasan_id" value="1" disabled>
                                        <span class="custom-control-label">Tidak Berminat</span>
                                    </label>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="mvpds_alasan_id" value="2" disabled>
                                        <span class="custom-control-label">Berpindah dan tidak mempunyai kepentingan dalam kawasan</span>
                                    </label>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input enable_tb" name="mvpds_alasan_id" value="3" disabled>
                                        <span class="custom-control-label">Lain-lain (Sila Nyatakan)</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows="4" name="mvpds_penarikan_diri_nyatakan" id="mvpds_penarikan_diri_nyatakan" disabled="" placeholder="Nyatakan"></textarea>
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

