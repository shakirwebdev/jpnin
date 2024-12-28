<div class="modal fade" id="modal_view_ahli_sejiwa" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Paparan Ahli Sejiwa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" id="form_mvas">
            @csrf
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Nama Penuh: </label>
                                <input type="text" class="form-control" name="mvas_ahli_sejiwa_nama" id="mvas_ahli_sejiwa_nama" placeholder="Nama Penuh" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label">No Kad Pengenalan: </label>
                                <input type="text" class="form-control" name="mvas_ahli_sejiwa_ic" id="mvas_ahli_sejiwa_ic" placeholder="No Kad Pengenalan" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Pekerjaan: </label>
                                <input type="text" class="form-control" name="mvas_ahli_sejiwa_pekerjaan" id="mvas_ahli_sejiwa_pekerjaan" placeholder="Pekerjaan" disabled>
                            </div>
                            <div class="form-group">
                                <b>Kaum: </b>
                                <select class="form-control" name="mvas_kaum_id" id="mvas_kaum_id" disabled>
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                    @foreach($ref_kaum as $item)                                    
                                        <option value="{{ $item->id }}">{{ $item->kaum_description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jawatan: </label>
                                <input type="text" class="form-control" name="mvas_ahli_sejiwa_jawatan" id="mvas_ahli_sejiwa_jawatan" placeholder="Jawatan" disabled>
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