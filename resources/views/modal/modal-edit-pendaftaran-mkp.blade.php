<div class="modal fade" id="modal_edit_pendaftaran_mkp" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="POST" id="form_mepm">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Kemaskini Maklumat MKP</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-12">
                            <div class="mb-4">
                                <small>Isi maklumat pada borang yang disediakan dibawah, dan tekan butang SIMPAN. 
                                <br>
                                Ruangan bertanda <span class="text-red">*</span> adalah ruangan mandatori dan perlu diisi..&nbsp;&nbsp;<a href="#"><i class="dropdown-icon fe fe-help-circle"></i></a></small>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                            <label><b>Negeri : <span class="text-red">*</span></b></label>
                                <select class="custom-select" name="mepm_state_id" id="mepm_state_id">
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">- Pilih negeri</option>
                                    @foreach($state as $item)
                                    <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                    @endforeach
                                </select>
                                <div class="error_mepm_state_id invalid-feedback text-right"></div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                            <label><b>Daerah : <span class="text-red">*</span></b></label>
                                <select class="custom-select" name="mepm_daerah_id" id="mepm_daerah_id" disabled>
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">- Pilih daerah</option>
                                    
                                </select>
                                <div class="error_mepm_daerah_id invalid-feedback text-right"></div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <h3 class="card-title">Maklumat Personel</h3>
                            <hr>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <b>Nama penuh : <span class="text-red">*</span></b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-mouse-pointer"></i></span>
                                    </div>
                                    <input type="text" name="mepm_user_fullname" id="mepm_user_fullname" class="form-control" placeholder="Nama penuh anda">
                                    <div class="error_mepm_user_fullname invalid-feedback text-right"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <b>No Kad Pengenalan</b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card-o"></i></span>
                                    </div>
                                    <input type="text" name="mepm_no_ic" id="mepm_no_ic" class="form-control" placeholder="XXXXXX-XX-XXXX" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <b>No Telefon : <span class="text-red">*</span></b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                    </div>
                                    <input type="text" name="mepm_no_phone" id="mepm_no_phone" class="form-control phone-number" placeholder="Cth: 000-00000000" >
                                    <div class="error_mepm_no_phone invalid-feedback text-right"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <b>Alamat email : <span class="text-red">*</span></b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-envelope-o"></i></span>
                                    </div>
                                    <input type="email" name="mepm_user_email" id="mepm_user_email" class="form-control"  placeholder="Cth: ali@email.com">
                                    <div class="error_mepm_user_email invalid-feedback text-right"></div>
                                </div>
                            </div>
                            <div class="form-group">
                            <label for="mepm_status_id"><b>Status</b></label>
                                <select class="custom-select" name="mepm_status_id" id="mepm_status_id">
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                    <option value="1">Aktif</option>
                                    <option value="2">Tidak Aktif</option>
                                </select>
                                <div class="error_mepm_status_id invalid-feedback text-right"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="post_edit_pendaftaran_mkp" value="edit">
                    <input type="hidden" name="action" id="post_edit_pendaftaran_mkp" value="edit">
                    <input type="hidden" name="user_profile_id" id="user_profile_id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn_save"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
