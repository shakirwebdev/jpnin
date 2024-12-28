<div class="modal fade" id="modal_arahan_tindakan_imuhibbah" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Arahan Tindakan Pelaporan i-Ramal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" id="form_matip">
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
                                <label class="form-label">Tempoh Tindakan: <span class="text-red">*</span></label>
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="matip_tempoh_tindakan" value="1">
                                        <span class="custom-control-label">1 Minggu</span>
                                    </label><br>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="matip_tempoh_tindakan" value="2">
                                        <span class="custom-control-label">2 Minggu</span>
                                    </label><br>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="matip_tempoh_tindakan" value="3">
                                        <span class="custom-control-label">3 Minggu</span>
                                    </label><br>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="matip_tempoh_tindakan" value="4">
                                        <span class="custom-control-label">4 Minggu</span>
                                    </label>
                                </div>
                                <div class="error_matip_tempoh_tindakan invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <b>Tarikh Arahan: <span class="text-red">*</span></b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="matip_tarikh_arahan" id="matip_tarikh_arahan" placeholder="Tarikh Mula Bina Bangunan" data-date-format="dd/mm/yyyy">
                                    <div class="error_matip_tarikh_arahan invalid-feedback text-right"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jenis Premis: <span class="text-red">*</span></label>
                                <select class="form-control" name="matip_jenis_arahan_id" id="matip_jenis_arahan_id">
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                    @foreach($jenis_tindakan as $item)                                    
                                        <option value="{{ $item->id }}">{{ $item->jenis_description }}</option>
                                    @endforeach
                                </select>
                                <div class="error_matip_jenis_arahan_id invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tindakan: </label>
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="matip_tindakan_kepada_ppn" value='1'>
                                        <span class="custom-control-label">PPN</span>
                                    </label>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="matip_tindakan_kepada_ppd" value='1'>
                                        <span class="custom-control-label">PPD</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="matip_imuhibbah_id" id="matip_imuhibbah_id" >
                    <input type="hidden" name="action" id="post_add_at_imuhibbah_p" value="add">
                    <input type="hidden" name="post_add_at_imuhibbah_p" value="add">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn_submit">Hantar Arahan Tindakan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>