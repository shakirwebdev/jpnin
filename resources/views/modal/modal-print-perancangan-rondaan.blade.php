<div class="modal fade" id="modal_print_perancangan_rondaan" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-xl">
            <div class="modal-header">
                <h5 class="modal-title">Jana Jadual Perancangan Rondaan</h5>
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
                            <label class="form-label">Negeri: </label>
                            <select class="form-control" disabled="">
                                <option>Perlis</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Daerah: </label>
                            <select class="form-control" disabled="">
                                <option>Perlis</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nama SRS: </label>
                            <input type="text" class="form-control" name="" value="SRS Taman Peladang Jaya" disabled="">
                        </div>
                        <div class="form-group">
                            <b>Tarikh Rondaan: <span class="text-red">*</span></b>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                                <input type="text" name="" class="form-control" value="10/1/2021" placeholder="Tarikh Rondaan" disabled="">
                                <div class="c_username invalid-feedback text-right"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Maklumat Ahli: <span class="text-red">*</span></label>
                            <div class="table-responsive">
                                <table class="table table-striped table-vcenter table-hover mb-0" id="ahli_srs_table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                            <th><label class="form-label"><font color="#113f50">Senarai Ahli SRS</font></label></th>
                                            <th><label class="form-label"><font color="#113f50">No. Ahli</font></label></th>
                                            <th><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td>ALI</td>
                                            <td>SRS0001</td>
                                            <td class="text-center">
                                                <label class="custom-switch">
                                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked disabled="">
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2</td>
                                            <td>KAMIL</td>
                                            <td>SRS0002</td>
                                            <td class="text-center">
                                                <label class="custom-switch">
                                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked disabled="">
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">3</td>
                                            <td>AMINAH</td>
                                            <td>SRS0002</td>
                                            <td class="text-center">
                                                <label class="custom-switch">
                                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked disabled="">
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">4</td>
                                            <td>SITI</td>
                                            <td>SRS0002</td>
                                            <td class="text-center">
                                                <label class="custom-switch">
                                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked disabled="">
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">5</td>
                                            <td>ABU</td>
                                            <td>SRS0002</td>
                                            <td class="text-center">
                                                <label class="custom-switch">
                                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked disabled="">
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description"></span>
                                                </label>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success" id="btn-save-jpnin">Jana Jadual Perancangan Rondaan&nbsp;&nbsp;<i class="fa fa-print mr-2"></i></button>
            </div>
        </div>
    </div>
</div>

