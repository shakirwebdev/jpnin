<!-- The Modal -->
<div class="modal" id="modal_view_dokumen" style="width:50%; height: 850px; margin-left:25%; margin-right:25%; margin-top:1%; margin-bottom:1%; ">
	<div style="width:96%; margin-left:2%; margin-right:2%; margin-top:1%; margin-bottom:1%;">
    	<div class="modal-content" style="width:100%; ">
        	<div class="modal-header" style="width:100%;">
          		<h1 class="modal-title" style="font-size:16px;"><b>Paparan Dokumen</b></h1>
          		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        	</div>
			<hr>
        	<table id="list_dokumen" class="table table-striped table-vcenter table-hover mb-0" style="width: 100%; display:none;">
			</table>
			<form action="#" id="form_mag2">
			{{ csrf_field() }}
			<div style="margin-left: 2%;">
				<table>
					<tr>
						<td width="40%"><label id="lab_senaraidok" style="display:none;">Senarai butiran dokumen: </label></td>
						<td width="60%"><select class="form-control" id="select_list_dokumen" style="display:none;" onChange="view(this.value);"></select></td>
					</tr>
				</table>
				<label id="lab_butirandok" style="display:none;">Butiran dokumen: </label>
				<input name="dok_jenis" type="text" class="form-control" id="dok_jenis" size="40" readonly="readonly" placeholder="Fail Gambar Dokumen Sokongan" style="display:none; ">
			</div>
        	<div class="modal-body" style="width:100%; height: 400px; overflow:scroll;">
          		<img src="" class="mx-auto d-block" style="width:50%; display:none;" alt="Dokumen Sokongan" id="dok_gambar" name="dok_gambar"/>
			</div>
        
        	<!-- Modal footer -->
        	<div class="modal-footer">
				<input type="hidden" name="mag_krt_ajk_krt_id" id="mag_krt_ajk_krt_id">
            	<input type="hidden" name="action" id="post_add_gambar" value="edit">
            	<input type="hidden" name="post_add_gambar" value="edit">
          		<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        	</div>
			</form>
        
      </div>
    </div>
  </div>