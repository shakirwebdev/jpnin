<div class="modal fade" id="modal_add_jawatankuasa_penaja_rt" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="POST" id="jawatankuasa_penaja_form">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Ahli Jawatankuasa Penaja RT</h5>
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
                            <div class="col-md-12 alert alert-danger error_alert" role="alert" style="display: none; padding-bottom: 0px;">
                                <ul></ul>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Nama: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="jpf_penaja_nama" id="jpf_penaja_nama" placeholder="Nama">
                                <div class="error_jpf_penaja_nama invalid-feedback text-right"></div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label class="form-label">No Kad Pengenalan: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="jpf_penaja_ic" id="jpf_penaja_ic" placeholder="XXXXXXXXXXXX">
                                <div class="error_jpf_penaja_ic invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jantina: <span class="text-red">*</span></label>
                                <select class="form-control" name="jpf_ref_jantinaID" id="jpf_ref_jantinaID">
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                    @foreach($ref_jantina as $item)                                    
                                        <option value="{{ $item->id }}">{{ $item->jantina_description }}</option>
                                    @endforeach
                                </select>
                                <div class="error_jpf_ref_jantinaID invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Pekerjaan: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="jpf_penaja_pekerjaan" id="jpf_penaja_pekerjaan" placeholder="Pekerjaan">
                                <div class="error_jpf_penaja_pekerjaan invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">No Telefon: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" name="jpf_penaja_no_fone" id="jpf_penaja_no_fone" placeholder="No Telefon Rumah">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <b>Tarikh Lahir: <span class="text-red">*</span>  <i class="fa fa-info-circle" data-toggle="tooltip" title="Boleh taip dengan format 01/04/1984 untuk cepatkan proses pengisian"></i></b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="jpf_penaja_birth" id="jpf_penaja_birth" placeholder="Tarikh Lahir" data-date-format="dd/mm/yyyy">
                                    <div class="error_jpf_penaja_birth invalid-feedback text-right"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Kaum: <span class="text-red">*</span></label>
                                <select class="form-control" name="jpf_ref_kaumID" id="jpf_ref_kaumID">
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                    @foreach($ref_kaum as $item)                                    
                                        <option value="{{ $item->id }}">{{ $item->kaum_description }}</option>
                                    @endforeach
                                </select>
                                <div class="error_jpf_ref_kaumID invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">No Telefon Pejabat: </label>
                                <input type="text" class="form-control" name="jpf_penaja_no_office" id="jpf_penaja_no_office" placeholder="No Telefon Pejabat">
                                <div class="error_jpf_penaja_no_office invalid-feedback text-right"></div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Alamat Rumah: <span class="text-red">*</span></label>
                                <textarea class="form-control" rows="4" name="jpf_penaja_alamat_rumah" id="jpf_penaja_alamat_rumah" placeholder="Alamat Rumah"></textarea>
                                <div class="error_jpf_penaja_alamat_rumah invalid-feedback text-right"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Alamat Pejabat: </label>
                                <textarea class="form-control" rows="4" name="jpf_penaja_alamat_pejabat" id="jpf_penaja_alamat_pejabat" placeholder="Alamat Pejabat"></textarea>
                                <div class="error_jpf_penaja_alamat_pejabat invalid-feedback text-right"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="jpf_krt_profileID" id="jpf_krt_profileID" value="{{$profile_krt->id}}">
                    <input type="hidden" name="action" id="add_jawatankuasa_penaja" value="add">
                    <input type="hidden" name="add_jawatankuasa_penaja" value="add">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn_add"><i class="fe fe-plus mr-2"></i>Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

