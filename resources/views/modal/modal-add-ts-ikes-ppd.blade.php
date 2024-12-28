<div class="modal fade" id="modal_add_ts_ikes_ppd" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tindakan Susulan Pelaporan i-Kes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label class="form-label">Tempoh Tindakan: </label>
                            <div class="custom-controls-stacked">
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" name="matipd_tempoh_tindakan" value="1" disabled>
                                    <span class="custom-control-label">1 Minggu</span>
                                </label><br>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" name="matipd_tempoh_tindakan" value="2" disabled>
                                    <span class="custom-control-label">2 Minggu</span>
                                </label><br>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" name="matipd_tempoh_tindakan" value="3" disabled>
                                    <span class="custom-control-label">3 Minggu</span>
                                </label><br>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" name="matipd_tempoh_tindakan" value="4" disabled>
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
                                <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="matipd_tarikh_arahan" id="matipd_tarikh_arahan" placeholder="Tarikh Mula Bina Bangunan" data-date-format="dd/mm/yyyy" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jenis Premis: </label>
                            <select class="form-control" name="matipd_jenis_arahan_id" id="matipd_jenis_arahan_id" disabled>
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
                                    <input type="checkbox" class="custom-control-input" name="matipd_tindakan_kepada_ppn" value='1' disabled>
                                    <span class="custom-control-label">PPN</span>
                                </label>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="matipd_tindakan_kepada_ppd" value='1' disabled>
                                    <span class="custom-control-label">PPD</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <form action="#" id="form_matipd">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="form-label">Tindakan Susulan : <span class="text-red">*</span></label>
                                </div>
                                <div class="col-md-12 alert alert-danger error_form_matipd" role="alert" style="display: none; padding-bottom: 0px;">
                                    <ul></ul>
                                </div>
                                <div class="series-frame">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <b>Tarikh Tindakan: </b>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="matipd_tarikh_tindakan" id="matipd_tarikh_tindakan" placeholder="Tarikh Mula Bina Bangunan" data-date-format="dd/mm/yyyy">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Keterangan Tindakan: </label>
                                            <textarea class="form-control" rows="5" name="matipd_keterangan_tindakan" id="matipd_keterangan_tindakan" placeholder="Keterangan Tindakan"></textarea>
                                        </div>
                                        <input type="hidden" name="matipd_spk_ikes_id" id="matipd_spk_ikes_id">
                                        <input type="hidden" name="post_add_ts_ikes_ppd" value="add">
                                        <button type="submit" class="btn btn-primary pull-right" id="btn_save"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                    </div>
                                </div>
                            </form>
                            <br>
                            <div class="table-responsive">
                                <table class="table thead-dark table-bordered table-striped" id="senarai_ts_ikes" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Bil</th>
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
        </div>
    </div>
</div>