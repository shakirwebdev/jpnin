<div class="modal fade" id="modal_add_pendaftaran_mkp" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="POST" id="form_mapm">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Pra-Pendaftaran MKP</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-12">
                            <div class="mb-4">
                                <small>Isi maklumat pada borang yang disediakan dibawah, dan tekan butang HANTAR. 
                                <br>
                                Ruangan bertanda <span class="text-red">*</span> adalah ruangan mandatori dan perlu diisi..&nbsp;&nbsp;<a href="#"><i class="dropdown-icon fe fe-help-circle"></i></a></small>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                            <label><b>Negeri : <span class="text-red">*</span></b></label>
                                <select class="custom-select" name="mapm_state_id" id="mapm_state_id">
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">- Pilih negeri</option>
                                    @foreach($state as $item)
                                    <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                    @endforeach
                                </select>
                                <div class="error_mapm_state_id invalid-feedback text-right"></div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                            <label><b>Daerah : <span class="text-red">*</span></b></label>
                                <select class="custom-select" name="mapm_daerah_id" id="mapm_daerah_id" disabled>
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">- Pilih daerah</option>
                                    
                                </select>
                                <div class="error_mapm_daerah_id invalid-feedback text-right"></div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <b>No Kad Pengenalan : <span class="text-red">*</span></b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card-o"></i></span>
                                    </div>
                                    <input type="text" name="mapm_no_ic" id="mapm_no_ic" class="form-control" placeholder="XXXXXX-XX-XXXX">
                                    <div class="error_mapm_no_ic invalid-feedback text-right"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="hidden" name="mapm_user_id" id="mapm_user_id" class="form-control">
                                    <div class="error_mapm_user_id invalid-feedback text-left"></div>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <h3 class="card-title">Maklumat Personel</h3>
                            <hr>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <b>Nama penuh : </b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    </div>
                                    <input type="text" name="mapm_user_fullname" id="mapm_user_fullname" class="form-control" placeholder="Nama penuh anda" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <b>No Telefon : </b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                    </div>
                                    <input type="text" name="mapm_no_phone" id="mapm_no_phone" class="form-control phone-number" placeholder="Cth: 000-00000000" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <b>Alamat email : </b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-envelope-o"></i></span>
                                    </div>
                                    <input type="email" name="mapm_user_email" id="mapm_user_email" class="form-control"  placeholder="Cth: ali@email.com" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <b>Alamat : </b>
                                <div class="input-group mb-3">
                                    <textarea class="form-control" id="mapm_user_alamat" name="mapm_user_alamat" rows="4" placeholder="Alamat" disabled></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    
                    <input type="hidden" name="mapm_email" id="mapm_email">
                    <input type="hidden" name="post_add_pendaftaran_mkp" value="add">
                    <input type="hidden" name="action" id="post_add_pendaftaran_mkp" value="add">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn_submit"><i class="fa fa-send"></i>&nbsp;&nbsp;Hantar</button>
                </div>
            </form>
        </div>
    </div>
</div>
