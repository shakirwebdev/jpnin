<div class="modal fade" id="modal_view_cadangan_pembinaan_prt" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Paparan Cadangan Pembinaan PRT / Kompleks Perpaduan / Kabin (tiada had tahun)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label class="form-label">Jenis Premis: </label>
                            <div class="custom-controls-stacked">
                                <label class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="mvcpp_prt_jenis_premis" value="1" disabled>
                                    <div class="custom-control-label">Kompleks Perpaduan <br><font color="red">(keluasan tanah sekurang - kurangnya 8498 m2 1 2.3 ekar)</font></div>
                                </label>
                                <label class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="mvcpp_prt_jenis_premis" value="2" disabled>
                                    <div class="custom-control-label">Pusat Rukun Tetangga <br><font color="red">(keluasan tanah sekurang -kurangnya 700m2 10.173 ekar)</font></div>
                                </label>
                                <label class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="mvcpp_prt_jenis_premis" value="3" disabled>
                                    <div class="custom-control-label">Kabin </div>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status Tanah Terkini: </label>
                            <select class="form-control" name="mvcpp_prt_status_tanah_terkini" id="mvcpp_prt_status_tanah_terkini" disabled>
                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                <option value="Tanah Kerajaan Persekutuan">Tanah Kerajaan Persekutuan</option>
                                <option value="Tanah Kerajaan Negeri">Tanah Kerajaan Negeri</option>
                                <option value="Tanah Persendirian">Tanah Persendirian</option>
                                <option value="Tanah wakaf (perlu dapatkan surat kebenaran)">Tanah wakaf (perlu dapatkan surat kebenaran)</option>
                                <option value="Tanah persendirian (individu) (perlu dapatkan surat kebenaran)">Tanah persendirian (individu) (perlu dapatkan surat kebenaran)</option>
                                <option value="Tanah syarikat swasta (perlu dapatkan surat kelulusan)">Tanah syarikat swasta (perlu dapatkan surat kelulusan)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Keluasan (Meter Persegi): </label>
                            <input type="text" class="form-control" name="mvcpp_prt_keluasan" id="mvcpp_prt_keluasan" placeholder="Keluasan (Meter Persegi)" disabled>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status Kelulusan Tanah Untuk Pembinaan Kabin: </label>
                            <select class="form-control" name="mvcpp_prt_status_kelulusan_tanah_kabin" id="mvcpp_prt_status_kelulusan_tanah_kabin" disabled>
                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                <option value="1">Lulus</option>
                                <option value="0">Belum Lulus</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Cadangan Tahun Pembinaan (Tandakan (1)): </label>
                            <select class="form-control" id="mvcpp_prt_cadangan_tahun" name="mvcpp_prt_cadangan_tahun" disabled>
                                <option value=""  selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                @for ($year=2022; $year <= 2050; $year++): 
                                    <option value="<?=$year;?>"><?=$year;?></option>
                                @endfor;
                            </select>
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