<div class="modal fade" id="modal_view_ts_ikes" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Paparan Tindakan Susulan Pelaporan i-Kes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" id="form_matip">
            @csrf
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Tempoh Tindakan: </label>
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="matip_tempoh_tindakan" value="1" disabled>
                                        <span class="custom-control-label">1 Minggu</span>
                                    </label><br>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="matip_tempoh_tindakan" value="2" disabled>
                                        <span class="custom-control-label">2 Minggu</span>
                                    </label><br>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="matip_tempoh_tindakan" value="3" disabled>
                                        <span class="custom-control-label">3 Minggu</span>
                                    </label><br>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="matip_tempoh_tindakan" value="4" disabled>
                                        <span class="custom-control-label">4 Minggu</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <b>Tarikh Arahan: </b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="matip_tarikh_arahan" id="matip_tarikh_arahan" placeholder="Tarikh Mula Bina Bangunan" data-date-format="dd/mm/yyyy" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jenis Premis: </label>
                                <select class="form-control" name="matip_jenis_arahan_id" id="matip_jenis_arahan_id" disabled>
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                    @foreach($jenis_tindakan as $item)                                    
                                        <option value="{{ $item->id }}">{{ $item->jenis_description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tindakan: </label>
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="matip_tindakan_kepada_ppn" value='1' disabled>
                                        <span class="custom-control-label">PPN</span>
                                    </label>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="matip_tindakan_kepada_ppd" value='1' disabled>
                                        <span class="custom-control-label">PPD</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tindakan Susulan: </label>
                                <br>
                                <div class="table-responsive">
                                    <table class="table thead-dark table-bordered table-striped" id="senarai_ts_ikes" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Bil</th>
                                                <th>Daripada</th>
                                                <th>Tarikh Tindakan</th>
                                                <th>Keterangan Tindakan</th>
                                            </tr>
                                        </thead>
                                    </table>
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