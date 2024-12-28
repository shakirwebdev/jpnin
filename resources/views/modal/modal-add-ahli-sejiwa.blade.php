<div class="modal fade" id="modal_add_ahli_sejiwa" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Ahli Sejiwa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" id="form_psk4">
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
                                <label class="form-label">Nama Penuh: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="psk4_ahli_sejiwa_nama" id="psk4_ahli_sejiwa_nama" placeholder="Nama Penuh">
                                <div class="error_psk4_ahli_sejiwa_nama invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">No Kad Pengenalan: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="psk4_ahli_sejiwa_ic" id="psk4_ahli_sejiwa_ic" placeholder="XXXXXXXXXXXX">
                                <div class="error_psk4_ahli_sejiwa_ic invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Pekerjaan: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="psk4_ahli_sejiwa_pekerjaan" id="psk4_ahli_sejiwa_pekerjaan" placeholder="Pekerjaan">
                                <div class="error_psk4_ahli_sejiwa_pekerjaan invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <b>Kaum: <span class="text-red">*</span></b>
                                <select class="form-control" name="psk4_kaum_id" id="psk4_kaum_id">
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                    @foreach($ref_kaum as $item)                                    
                                        <option value="{{ $item->id }}">{{ $item->kaum_description }}</option>
                                    @endforeach
                                </select>
                                <div class="error_psk4_kaum_id invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jawatan: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="psk4_ahli_sejiwa_jawatan" id="psk4_ahli_sejiwa_jawatan" placeholder="Jawatan">
                                <div class="error_psk4_ahli_sejiwa_jawatan invalid-feedback text-right"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="psk4_sejiwa_id" id="psk4_sejiwa_id" value="{{$sejiwa->id}}">
                    <input type="hidden" name="action" id="add_ahli_sejiwa" value="add">
                    <input type="hidden" name="add_ahli_sejiwa" value="add">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn_save"><i class="fe fe-plus mr-2"></i>Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>