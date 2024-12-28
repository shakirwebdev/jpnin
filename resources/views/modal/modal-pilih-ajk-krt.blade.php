<div class="modal fade" id="modal_pilih_ajk" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document" style="background-color:#00FFFF; margin-left:20%;">
        <div class="modal-content" style="width:800px;">
            <div class="modal-header">
                <h5 class="modal-title">Senarai Penggal AJK</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="#" id="form_pilih">
            {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-12">
                            <div class="mb-4">
                                <small>Berikut adalah maklumat AJK yang telah wujud. 
                                <br>
                                Silih piih maklumat yang ingin digunakan</small>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <!--label class="form-label">Fail Gambar Profil Ajk: <span class="text-red">*</span></label>
                                <input type="file" class="form-control" name="mag_file_avatar" id="mag_file_avatar" placeholder="Fail Gambar Profil Ajk">
                                <div class="error_mag_file_avatar invalid-feedback text-right"></div-->
								<table id="ajk_list" border="1" style="font-size:12px;">
									<tr>
										<th width="7%">Penggal</th>
										<th width="23%">KRT</th>
										<th width="25%">Nama</th>
										<th width="25%">Alamat</th>
										<th width="10%" align="center">Gambar</th>
										<th width="10%" align="center">Tindakan</th>
									</tr>
								</table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="mag_krt_ajk_krt_id" id="mag_krt_ajk_krt_id">
                    <input type="hidden" name="action" id="post_add_gambar" value="edit">
                    <input type="hidden" name="post_add_gambar" value="edit">
                    <button id="modal_tutup" type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn_pilih"><i class="fa fa-edit mr-2"></i>Pilih</button>
                </div>
            </form>
        </div>
    </div>
</div>