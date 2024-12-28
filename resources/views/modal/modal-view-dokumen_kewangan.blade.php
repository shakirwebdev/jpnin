<!-- The Modal -->
<div class="modal" id="modal_view_dokumen_kewangan" style="width:60%; height: 650px; margin-left:25%; margin-right:25%; margin-top:1%; margin-bottom:1%; ">
	<div style="width:96%; margin-left:2%; margin-right:2%; margin-top:1%; margin-bottom:1%;">
    	<div class="modal-content" style="width:100%; ">
        	<div class="modal-header" style="width:100%;">
          		<h1 class="modal-title" style="font-size:16px;"><b>Paparan Dokumen Kewangan</b></h1>
          		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        	</div>
			<hr>
			<form action="#" id="form_mag2">
			{{ csrf_field() }}
				<div style="margin-left: 2%;">
					<table>
						<tr>
							<td width="30%"><label id="lab_senaraidok">Butiran dokumen: </label></td>
							<td width="70%"><select class="form-control" id="select_list_dokumen" onChange="tukar_imej(this.value);"></select></td>
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
          			<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        		</div>
			</form>	
    	</div>
	</div>
</div>