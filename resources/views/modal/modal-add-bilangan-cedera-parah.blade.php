<div class="modal fade" id="modal_add_bilangan_cedera_parah" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="POST" id="form_mabcp">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Bilangan Cedera Parah Mengikut Etnik</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
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
                                <label class="form-label">Etnik: <span class="text-red">*</span></label>
                                <select class="form-control" name="mabcp_kaum_id" id="mabcp_kaum_id">
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                    @foreach($ref_kaum as $item)                                    
                                        <option value="{{ $item->id }}">{{ $item->kaum_description }}</option>
                                    @endforeach
                                </select>
                                <div class="error_mabcp_kaum_id invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jumlah Cedera Parah: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="mabcp_jumlah_cedera_parah" id="mabcp_jumlah_cedera_parah" placeholder="Jumlah Cedera Parah">
                                <div class="error_mabcp_jumlah_cedera_parah invalid-feedback text-right"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="mabcp_ikes_id" id="mabcp_ikes_id" value="{{$ikes->id}}">
                    <input type="hidden" name="action" id="add_bilangan_cedera_parah" value="add">
                    <input type="hidden" name="add_bilangan_cedera_parah" value="add">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn_add"><i class="fe fe-plus mr-2"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>