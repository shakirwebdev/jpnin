<div class="modal fade" id="modal_add_pemakluman_operasi_rondaan" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pemakluman Mula Operasi Rondaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" id="form_mapor">
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
                                <label class="form-label">Nama SRS: <span class="text-red">*</span></label>
                                <select class="form-control" name="mapor_srs_profile_id" id="mapor_srs_profile_id">
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                    @foreach($srs_profile as $item)                                    
                                        <option value="{{ $item->id }}">{{ $item->srs_name }}</option>
                                    @endforeach
                                </select>
                                <div class="error_mapor_srs_profile_id invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <b>Tarikh Mula Rondaan</b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="mapor_ops_tarikh_mula_ronda" id="mapor_ops_tarikh_mula_ronda" placeholder="Tarikh Mula Rondaan" data-date-format="dd/mm/yyyy">
                                    <div class="error_mapor_ops_tarikh_mula_ronda invalid-feedback text-right"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <b>Tarikh Surat</b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="mapor_ops_tarikh_surat" id="mapor_ops_tarikh_surat" placeholder="Tarikh Surat" data-date-format="dd/mm/yyyy">
                                    <div class="error_mapor_ops_tarikh_surat invalid-feedback text-right"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" id="add_pemakluman_ops_rondaan" value="add">
                    <input type="hidden" name="add_pemakluman_ops_rondaan" value="add">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn_save"><i class="fe fe-plus mr-2"></i>Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>