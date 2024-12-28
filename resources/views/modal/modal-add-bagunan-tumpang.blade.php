<div class="modal fade" id="modal_add_bagunan_tumpang" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Bangunan Tumpang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" id="form_mabt">
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
                                <select class="form-control" name="mabt_tumpang_jenis_premis_id" id="mabt_tumpang_jenis_premis_id">
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                    @foreach($jenis_premis_tumpang as $item)                                    
                                        <option value="{{ $item->id }}">{{ $item->jenis_premis_description }}</option>
                                    @endforeach
                                </select>
                                <div class="error_mabt_tumpang_jenis_premis_id invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Alamat: <span class="text-red">*</span></label>
                                <textarea class="form-control" rows="4" name="mabt_tumpang_alamat" id="mabt_tumpang_alamat" placeholder="Alamat"></textarea>
                                <div class="error_mabt_tumpang_alamat invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Pengguna Bangunan: <span class="text-red">*</span></label>
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="mabt_tumpang_pengguna_rt" value='1'>
                                        <span class="custom-control-label">RT</span>
                                    </label>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="mabt_tumpang_pengguna_srs" value='1'>
                                        <span class="custom-control-label">SRS</span>
                                    </label>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="mabt_tumpang_pengguna_tabika" value='1'>
                                        <span class="custom-control-label">Tabika</span>
                                    </label>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="mabt_tumpang_pengguna_taska" value='1'>
                                        <span class="custom-control-label">Taska</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Status Tanah: <span class="text-red">*</span></label>
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="mabt_tumpang_status_tanah_id" value="1">
                                        <span class="custom-control-label">Tanah Kerajaan Persekutuan</span>
                                    </label><br>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="mabt_tumpang_status_tanah_id" value="2">
                                        <span class="custom-control-label">Tanah Kerajaan Negeri</span>
                                    </label><br>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="mabt_tumpang_status_tanah_id" value="3">
                                        <span class="custom-control-label">Tanah Persendirian</span>
                                    </label><br>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="mabt_tumpang_status_tanah_id" value="4">
                                        <span class="custom-control-label">Tanah Swasta</span>
                                    </label>
                                </div>
                                <div class="error_mabt_tumpang_status_tanah_id invalid-feedback text-right"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="mabt_krt_profileID" id="mabt_krt_profileID" value="{{$profile_krt->id}}">
                    <input type="hidden" name="action" id="add_bagunan_tumpang" value="add">
                    <input type="hidden" name="add_bagunan_tumpang" value="add">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn_save"><i class="fe fe-plus mr-2"></i>Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>