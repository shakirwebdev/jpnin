<div class="modal fade" id="modal_view_pemakluman_operasi_rondaan" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Paparan Pemakluman Mula Operasi Rondaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" id="form_mvpor">
            @csrf
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Nama SRS: </label>
                                <select class="form-control" name="mvpor_srs_profile_id" id="mvpor_srs_profile_id" disabled>
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                    @foreach($srs_profile as $item)                                    
                                        <option value="{{ $item->id }}">{{ $item->srs_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <b>Tarikh Mula Rondaan</b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="mvpor_ops_tarikh_mula_ronda" id="mvpor_ops_tarikh_mula_ronda" placeholder="Tarikh Mula Rondaan" data-date-format="dd/mm/yyyy" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <b>Tarikh Surat</b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="mvpor_ops_tarikh_surat" id="mvpor_ops_tarikh_surat" placeholder="Tarikh Surat" data-date-format="dd/mm/yyyy" disabled>
                                </div>
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