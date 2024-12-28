<div class="modal fade" id="modal_view_jawatankuasa_penaja_rt" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="#" id="edit_jawatankuasa_penaja_form">
            {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title">Paparan Ahli Jawatankuasa Penaja RT</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="col-md-12 alert alert-danger error_alert" role="alert" style="display: none; padding-bottom: 0px;">
                                <ul></ul>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Nama: </label>
                                <input type="text" class="form-control" name="ejpf_penaja_nama" id="ejpf_penaja_nama" placeholder="Nama" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label class="form-label">No Kad Pengenalan: </label>
                                <input type="text" class="form-control" name="ejpf_penaja_ic" id="ejpf_penaja_ic" placeholder="No Kad Pengenalan" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jantina: </label>
                                <select class="form-control" name="ejpf_ref_jantinaID" id="ejpf_ref_jantinaID" disabled>
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                    @foreach($ref_jantina as $item)                                    
                                        <option value="{{ $item->id }}">{{ $item->jantina_description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Pekerjaan: </label>
                                <input type="text" class="form-control" name="ejpf_penaja_pekerjaan" id="ejpf_penaja_pekerjaan" placeholder="Pekerjaan" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label">No Telefon Rumah: </label>
                                <input type="text" class="form-control" name="ejpf_penaja_no_fone" id="ejpf_penaja_no_fone" placeholder="No Telefon Rumah" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <b>Tarikh Lahir: </b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="ejpf_penaja_birth" id="ejpf_penaja_birth" placeholder="Tarikh Lahir" data-date-format="dd/mm/yyyy" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Kaum: </label>
                                <select class="form-control" name="ejpf_ref_kaumID" id="ejpf_ref_kaumID" disabled>
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                    @foreach($ref_kaum as $item)                                    
                                        <option value="{{ $item->id }}">{{ $item->kaum_description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">No Telefon Pejabat: </label>
                                <input type="text" class="form-control" name="ejpf_penaja_no_office" id="ejpf_penaja_no_office" placeholder="No Telefon Pejabat" disabled>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">    
                            <div class="form-group">
                                <label class="form-label">Alamat Rumah: </label>
                                <textarea class="form-control" rows="4" name="ejpf_penaja_alamat_rumah" id="ejpf_penaja_alamat_rumah" placeholder="Alamat Rumah" disabled></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Alamat Pejabat: </label>
                                <textarea class="form-control" rows="4" name="ejpf_penaja_alamat_pejabat" id="ejpf_penaja_alamat_pejabat" placeholder="Alamat Pejabat" disabled></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="ejpf_krt_profileID" id="ejpf_krt_profileID" value="{{$profile_krt->id}}">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

