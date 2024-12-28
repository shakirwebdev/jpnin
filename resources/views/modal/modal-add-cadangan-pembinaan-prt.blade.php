<div class="modal fade" id="modal_add_cadangan_pembinaan_prt" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Cadangan Pembinaan PRT / Kompleks Perpaduan / Kabin (tiada had tahun)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="POST" id="form_macpp">
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
                                <label class="form-label">Jenis Premis: <span class="text-red">*</span></label>
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="macpp_prt_jenis_premis" value="1">
                                        <div class="custom-control-label">Kompleks Perpaduan <br><font color="red">(keluasan tanah sekurang - kurangnya 8498 m2 1 2.3 ekar)</font></div>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="macpp_prt_jenis_premis" value="2">
                                        <div class="custom-control-label">Pusat Rukun Tetangga <br><font color="red">(keluasan tanah sekurang -kurangnya 700m2 10.173 ekar)</font></div>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="macpp_prt_jenis_premis" value="3">
                                        <div class="custom-control-label">Kabin </div>
                                    </label>
                                    <div class="error_macpp_prt_jenis_premis invalid-feedback text-right"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Status Tanah Terkini: </label>
                                <select class="form-control" name="macpp_prt_status_tanah_terkini" id="macpp_prt_status_tanah_terkini">
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                    <option value="Tanah Kerajaan Persekutuan">Tanah Kerajaan Persekutuan</option>
                                    <option value="Tanah Kerajaan Negeri">Tanah Kerajaan Negeri</option>
                                    <option value="Tanah Persendirian">Tanah Persendirian</option>
                                    <option value="Tanah wakaf (perlu dapatkan surat kebenaran)">Tanah wakaf (perlu dapatkan surat kebenaran)</option>
                                    <option value="Tanah persendirian (individu) (perlu dapatkan surat kebenaran)">Tanah persendirian (individu) (perlu dapatkan surat kebenaran)</option>
                                    <option value="Tanah syarikat swasta (perlu dapatkan surat kelulusan)">Tanah syarikat swasta (perlu dapatkan surat kelulusan)</option>
                                </select>
                                <div class="error_macpp_prt_status_tanah_terkini invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Keluasan (Meter Persegi): <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="macpp_prt_keluasan" id="macpp_prt_keluasan" placeholder="Keluasan (Meter Persegi)">
                                <div class="error_macpp_prt_keluasan invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Status Tanah Untuk Cadangan Pembinaan PRT / Kompleks/ Perpaduan/ Kabin: <span class="text-red">*</span></label>
                                <select class="form-control" name="macpp_prt_status_kelulusan_tanah_kabin" id="macpp_prt_status_kelulusan_tanah_kabin">
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                    <option value="1">Lulus</option>
                                    <option value="0">Belum Lulus</option>
                                </select>
                                <div class="error_macpp_prt_status_kelulusan_tanah_kabin invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Cadangan Tahun Pembinaan (Tandakan (1)): <span class="text-red">*</span></label>
                                <select class="form-control" id="macpp_prt_cadangan_tahun" name="macpp_prt_cadangan_tahun">
                                    <option value=""  selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                    @for ($year=2022; $year <= 2050; $year++): 
                                        <option value="<?=$year;?>"><?=$year;?></option>
                                    @endfor;
                                </select>
                                <div class="error_macpp_prt_cadangan_tahun invalid-feedback text-right"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="macpp_krt_profileID" id="macpp_krt_profileID" value="{{$profile_krt->id}}">
                    <input type="hidden" name="action" id="add_cadangan_pembinaan_prt" value="add">
                    <input type="hidden" name="add_cadangan_pembinaan_prt" value="add">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn_save"><i class="fe fe-plus mr-2"></i>Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>