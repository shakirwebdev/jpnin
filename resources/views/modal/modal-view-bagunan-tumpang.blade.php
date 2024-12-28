<div class="modal fade" id="modal_view_bagunan_tumpang" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Paparan Bangunan Tumpang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" id="form_mvbt">
            @csrf
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Jenis Premis: </label>
                                <select class="form-control" name="mvbt_tumpang_jenis_premis_id" id="mvbt_tumpang_jenis_premis_id" disabled>
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                    @foreach($jenis_premis_tumpang as $item)                                    
                                        <option value="{{ $item->id }}">{{ $item->jenis_premis_description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Alamat: </label>
                                <textarea class="form-control" rows="4" name="mvbt_tumpang_alamat" id="mvbt_tumpang_alamat" placeholder="Alamat" disabled></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Pengguna Bangunan: </label>
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="mvbt_tumpang_pengguna_rt" value='1' disabled>
                                        <span class="custom-control-label">RT</span>
                                    </label>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="mvbt_tumpang_pengguna_srs" value='1' disabled>
                                        <span class="custom-control-label">SRS</span>
                                    </label>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="mvbt_tumpang_pengguna_tabika" value='1' disabled>
                                        <span class="custom-control-label">Tabika</span>
                                    </label>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="mvbt_tumpang_pengguna_taska" value='1' disabled>
                                        <span class="custom-control-label">Taska</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Status Tanah: </label>
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="mvbt_tumpang_status_tanah_id" value="1" disabled>
                                        <span class="custom-control-label">Tanah Kerajaan Persekutuan</span>
                                    </label><br>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="mvbt_tumpang_status_tanah_id" value="2" disabled>
                                        <span class="custom-control-label">Tanah Kerajaan Negeri</span>
                                    </label><br>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="mvbt_tumpang_status_tanah_id" value="3" disabled>
                                        <span class="custom-control-label">Tanah Persendirian</span>
                                    </label><br>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="mvbt_tumpang_status_tanah_id" value="4" disabled>
                                        <span class="custom-control-label">Tanah Swasta</span>
                                    </label>
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