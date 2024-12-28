@include('js.modal.j-modal-add-kehadiran-mesyuarat-krt')
@include('js.modal.j-modal-view-kehadiran-mesyuarat-krt')
@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<style type="text/css">
	.series-frame {
	  /*max-width: 600px;*/
	  display: flex;
	  justify-content: space-between;
	  align-items: center;
	  box-sizing: border-box;
	  border: 2px solid #113f50;
	  /*margin: 30px;*/
	  padding: 10px;
	}
    .blink {
        animation: blinker 1.0s linear infinite;
        color: #1c87c9;
        font-weight: bold;
        font-family: sans-serif;
    }
    @keyframes blinker {
        50% {
          opacity: 0;
        }
      }
</style>
<script type="text/javascript">

		function sortOptions() {
         	var dorpdown = $('select');
         	dorpdown.html(dorpdown.find('option').sort(function (option1, option2) {
            	return $(option1).text() < $(option2).text() ? -1 : 1;
         	}));
      	}
		
		function sortTable() {
		  var table, rows, switching, i, x, y, shouldSwitch;
		  table = document.getElementById("senarai_ajk_table");
		  switching = true;
		  /*Make a loop that will continue until
		  no switching has been done:*/
		  while (switching) {
			//start by saying: no switching is done:
			switching = false;
			rows = table.rows;
			/*Loop through all table rows (except the
			first, which contains table headers):*/
			for (i = 1; i < (rows.length - 1); i++) {
			  //start by saying there should be no switching:
			  shouldSwitch = false;
			  /*Get the two elements you want to compare,
			  one from current row and one from the next:*/
			  x = rows[i].getElementsByTagName("TD")[3];
			  y = rows[i + 1].getElementsByTagName("TD")[3];
			  //check if the two rows should switch place:
			  if(x.innerHTML > y.innerHTML) {
			  //if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
				//if so, mark as a switch and break the loop:
				shouldSwitch = true;
				break;
			  }
			}
			if (shouldSwitch) {
			  /*If a switch has been marked, make the switch
			  and mark that a switch has been done:*/
			  rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
			  switching = true;
			}
		  }
		}
		
		function process(date){
			var parts = date.split("/");
			return new Date(parts[2], parts[1] - 1, parts[0]);
		}

    	$(document).ready( function () {
			
		//my custom script
			url_get_senarai_kehadiran 			= "{{ route('rt-sm5.get_senarai_kehadiran','') }}"+"/"+"{{$krt_minit_mesyuarat->id}}";
			url_delete_kehadiran_mesyuarat 		= "{{ route('rt-sm5.delete_kehadiran','') }}";
			url_delete_kehadiran_ajk_mesyuarat 		= "{{ route('rt-sm5.delete_kehadiran_ajk','') }}";
			url_add_kehadiran_ajk_mesyuarat 		= "{{ route('rt-sm5.add_kehadiran_ajk','') }}";
			url_add_kehadiran_mesyuarat 		= "{{ route('rt-sm5.add_kehadiran_mesyuarat','') }}";
			url_get_senarai_kehadiran_ajk 			= "{{ route('rt-sm5.get_senarai_kehadiran_ajk','') }}"+"/"+"{{$krt_minit_mesyuarat->id}}";
			url_get_senarai_ajk 					= "{{ route('rt-sm5.get_senarai_ajk','') }}";
			url_get_senarai_kehadiran_all			= "{{ route('rt-sm5.get_senarai_kehadiran_all','') }}"+"/"+"{{$krt_minit_mesyuarat->id}}";

		/* Maklumat Kawasan Krt */
			$('#pmmrt_nama_krt').html("{{$krt_profile->nama_krt}}");
			$('#pmmrt_alamat_krt').html("{{$krt_profile->alamat_krt}}");
			$('#pmmrt_negeri_krt').html("{{$krt_profile->negeri_krt}}");
			$('#pmmrt_daerah_krt').html("{{$krt_profile->daerah_krt}}");
			$('#pmmrt_parlimen_krt').html("{{$krt_profile->parlimen_krt}}");
			$('#pmmrt_dun_krt').html("{{$krt_profile->dun_krt}}");
			$('#pmmrt_pbt_krt').html("{{$krt_profile->pbt_krt}}");

		/* Maklumat Minit Mesyuarat */
			$('#pmmrt_minit_mesyuarat_id').val("{{$krt_minit_mesyuarat->id}}");
			$('#pmmrt_mesyuarat_title').val("{{$krt_minit_mesyuarat->mesyuarat_title}}");
			$('#pmmrt_mesyuarat_tarikh').val("{{$krt_minit_mesyuarat->mesyuarat_tarikh}}");
			$('#pmmrt_mesyuarat_bil').val("{{$krt_minit_mesyuarat->mesyuarat_bil}}");
			$('#pmmrt_mesyuarat_time').val("{{$krt_minit_mesyuarat->mesyuarat_time}}");

			var tmpt;
			tmpt = "{{$krt_minit_mesyuarat->mesyuarat_tempat1}}";
			var new_tmpt = tmpt.replace(/&lt;br \/&gt;/g, "\n");
			$('#pmmrt_mesyuarat_tempat').val(new_tmpt);

			$('#pmmrt_mesyuarat_tempat').val(new_tmpt);
			
			/*$('#pmmrt_pengerusi_mesyuarat').append($('<option>', {
                    value: "{{$krt_minit_mesyuarat->pengerusi}}",
                    text: "{{$krt_minit_mesyuarat->pengerusi}}"
            }));*/
			
			$('#pmmrt_mesyuarat_perutusan_pengerusi').html("{{$krt_minit_mesyuarat->mesyuarat_perutusan_pengerusi}}");
			$("#pmmrt_mesyuarat_perutusan_pengerusi").val($("<div>").html("{{$krt_minit_mesyuarat->mesyuarat_perutusan_pengerusi}}").text());
			$('#pmmrt_mesyuarat_yang_lalu').html("{{$krt_minit_mesyuarat->mesyuarat_yang_lalu}}");

			$('#pmmrt_mesyuarat_time').inputmask('hh:mm', { placeholder: '__:__ _m', alias: 'time24', hourFormat: '24' });

			$('#pmmrt_mesyuarat_tempat').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				/*if (keyCode === 13) {
					e.preventDefault();

					// Ajax code here

					return false;
				}*/
			});

			/*$('#pmmrt_mesyuarat_tempat').on("paste",function(e) {
                e.preventDefault();
            });*/

			$('#pmmrt_mesyuarat_perutusan_pengerusi').summernote({
				height: 200,
				callbacks: {
					onImageUpload: function (data) {
						data.pop();
					},
					onPaste: function (we, e, ne) {
						var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
						e.preventDefault();
						document.execCommand('insertText', false, bufferText);
					}
				},
			});

			$('#pmmrt_mesyuarat_yang_lalu').summernote({
				height: 200,
				callbacks: {
					onImageUpload: function (data) {
						data.pop();
					},
					onPaste: function (we, e, ne) {
						var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
						e.preventDefault();
						document.execCommand('insertText', false, bufferText);
					}
				}
			});
			
			$.fn.check_hadir_det = function(data1) { 
				var chk="tiada";
				$.each($("#senarai_kehadiran_all_table tr"),function(index){
					if(index>0)
					{
						var self=$(this).closest("tr");
						var member_0_value = self.find("td:eq(0)").text().trim();
						var member_1_value = self.find("td:eq(1)").text().trim();
						var member_2_value = self.find("td:eq(2)").text().trim();
						var member_3_value = self.find("td:eq(3)").text().trim();
						if (member_1_value == "0")
						{
							if(member_3_value == data1)
							{
								chk = "ada";
								return chk;
							}
						}
					}
				});
				return chk;
			};
			
			$.fn.check_hadir = function() { 
				var exist_pengerusi="{{$krt_minit_mesyuarat->pengerusi}}";
				var exist_pencatat="{{$krt_minit_mesyuarat->pencatat}}";
				$('#pmmrt_pengerusi_mesyuarat').empty();
				$('#pmmrt_catat_mesyuarat').empty();
				$('#senarai_kehadiran_ajk_table').DataTable().clear().draw();
				sortTable();
				$.each($("#senarai_ajk_table tr"),function(index){
					if(index>0)
					{
						var self=$(this).closest("tr");
						var member_0_value = self.find("td:eq(0)").text().trim();
						var member_1_value = self.find("td:eq(1)").text().trim();
						var member_2_value = self.find("td:eq(2)").text().trim();
						var ret=$.fn.check_hadir_det(member_0_value);
						var member_3_value = "";
						var member_4_value = "";
						if(ret == "ada")
						{
							member_3_value = '<input type="checkbox" checked class="editor-active" onclick="$.fn.tik(\'status_'+ member_0_value +'\',1,'+ member_0_value +');">';
							member_4_value = '<label id="status_'+member_0_value+'">hadir</label>';
						}else 
						{
							member_3_value = '<input type="checkbox" class="editor-active" onclick="$.fn.tik(\'status_'+ member_0_value +'\',0,'+ member_0_value +');">';
							member_4_value = '<label id="status_'+member_0_value+'">tidak</label>';
						}
						senarai_kehadiran_ajk_table.row.add([index,member_1_value,member_2_value,member_3_value,member_4_value]).draw(false);
					}
				});
				//bukan ajk
				$('#senarai_kehadiran_table').DataTable().clear().draw();
				var idx=0;
				var pengerusi_ada="tiada";
				var pencatat_ada="tiada";
				$.each($("#senarai_kehadiran_all_table tr"),function(index2){
					if(index2>0)
					{
						var self2=$(this).closest("tr");
						var member2_0_value = self2.find("td:eq(0)").text().trim();
						if (member2_0_value != 'No data available in table')
						{
							var member2_1_value = self2.find("td:eq(1)").text().trim();
							var member2_2_value = self2.find("td:eq(2)").text().trim();
							var member2_3_value = self2.find("td:eq(3)").text().trim();
							var member2_32_value = self2.find("td:eq(4)").text().trim();
							var member2_4_value = "<button type='button' class='btn btn-icon' title='Buang Kehadiran' onclick='$.fn.delete_kehadiran("+member2_0_value+");'><i class='fa fa-trash-o text-danger'></i></button>";
							if (member2_1_value == "1")
							{	
								idx = idx + 1 ;
								senarai_kehadiran_table.row.add([idx, member2_2_value, member2_3_value, member2_4_value]).draw(false);
								if(exist_pengerusi == member2_0_value)
								{
									$('#pmmrt_pengerusi_mesyuarat').append('<option selected="selected" value="'+ member2_0_value +'">'+ member2_2_value +' ('+ member2_3_value +')</option>');
									pengerusi_ada="ada";
								}else
								{
									$('#pmmrt_pengerusi_mesyuarat').append('<option value="'+ member2_0_value +'">'+ member2_2_value +' ('+ member2_3_value +')</option>');
								}
								if(exist_pencatat == member2_0_value)
								{
									$('#pmmrt_catat_mesyuarat').append('<option selected="selected" value="'+ member2_0_value +'">'+ member2_2_value +' ('+ member2_3_value +')</option>');
									pencatat_ada="ada";
								}else
								{
									$('#pmmrt_catat_mesyuarat').append('<option value="'+ member2_0_value +'">'+ member2_2_value +' ('+ member2_3_value +')</option>');
								}
							}else
							{
								if(exist_pengerusi == member2_0_value)
								{
									$('#pmmrt_pengerusi_mesyuarat').append('<option selected="selected" value="'+ member2_0_value +'">'+ member2_2_value +' ('+ member2_32_value +')</option>');
									pengerusi_ada="ada";
								}else
								{
									$('#pmmrt_pengerusi_mesyuarat').append('<option value="'+ member2_0_value +'">'+ member2_2_value +' ('+ member2_32_value +')</option>');
								}
								if(exist_pencatat == member2_0_value)
								{
									$('#pmmrt_catat_mesyuarat').append('<option selected="selected" value="'+ member2_0_value +'">'+ member2_2_value +' ('+ member2_32_value +')</option>');
									pencatat_ada="ada";
								}else
								{
									$('#pmmrt_catat_mesyuarat').append('<option value="'+ member2_0_value +'">'+ member2_2_value +' ('+ member2_32_value +')</option>');
								}
							}
						}
					}
				});
				if(exist_pengerusi.length < 2 || pengerusi_ada=="tiada")
				{
					$('#pmmrt_pengerusi_mesyuarat').append('<option selected="selected" value="">SILA PILIH</option>');
				}else
				{
					$('#pmmrt_pengerusi_mesyuarat').append('<option value="">SILA PILIH</option>');
				}
				if(exist_pencatat.length < 2 || pencatat_ada=="tiada")
				{
					$('#pmmrt_catat_mesyuarat').append('<option selected="selected" value="">SILA PILIH</option>');
				}else
				{
					$('#pmmrt_catat_mesyuarat').append('<option value="">SILA PILIH</option>');
				}
			}
			
			$.fn.tik = function(objname,val,ajkid) { 
				var ada="tiada";
				var data_ajkid,data_ajknama,data_ajkjawatan,data_mtgid,data_jenishadir;
				$objname = "#" + objname;
				if(val == "0")
				{
					$($objname).html("hadir");
					$.each($("#senarai_ajk_table tr"),function(index){
						if(index>0)
						{
							var self=$(this).closest("tr");
							var member_0_value = self.find("td:eq(0)").text().trim();
							var member_1_value = self.find("td:eq(1)").text().trim();
							var member_2_value = self.find("td:eq(2)").text().trim();
							if(member_0_value == ajkid)
							{
								ada="ada";
								data_ajkid=member_0_value;
								data_ajknama=member_1_value;
								data_ajkjawatan=member_2_value;
								data_mtgid="{{$krt_minit_mesyuarat->id}}";
								data_jenishadir=0;
							}
						}
					});
					if(ada == "ada")
					{
						$.ajax({
							type: "GET",
							url: url_add_kehadiran_ajk_mesyuarat,
							data: { ajkid: data_ajkid, ajk_nama: data_ajknama, mtg_id: data_mtgid, jenis_hadir:data_jenishadir },
							success: function (data) {
								swal("Tambah kehadiran!", "Rekod kehadiran telah ditambah ke pangkalan data", "success");
								$('#senarai_kehadiran_all_table').DataTable().destroy();
								$('#senarai_ajk_table').DataTable().destroy();
								var senarai_ajk_table = $('#senarai_ajk_table').DataTable( {
									processing: true,
									serverSide: true,
									ajax: url_get_senarai_ajk,
									paging: false,
									searching: false, 
									info: false,
									responsive: true,
									"aoColumnDefs":[{
										"aTargets": [ 0 ],
										"width": "10%",
										"mRender": function ( value, type, full )  {
											return full.ajk_id;
										}
									},{
										"aTargets": [ 1 ],
										"width": "20%",
										"mRender": function ( value, type, full )  {
											return full.ajk_nama;
										}
									},{
										"aTargets": [ 2 ],
										"width": "20%",
										"mRender": function ( value, type, full )  {
											return full.ajk_jawatan;
										}
									},{
										"aTargets": [ 3],
										"width": "20%",
										"mRender": function ( value, type, full )  {
											return full.ajk_jawatan_krt_id;
										}
									}],
									"order": [[ 3, 'asc' ]],
									initComplete: function () {
										$('[data-toggle="tooltip"]').tooltip();
									}
								});
								var senarai_kehadiran_all_table = $('#senarai_kehadiran_all_table').DataTable( {
									processing: true,
									serverSide: true,
									ajax: url_get_senarai_kehadiran_all,
									paging: false,
									searching: false, 
									info: false,
									responsive: true,
									"aoColumnDefs":[{
										"aTargets": [ 0 ],
										"width": "10%",
										"mRender": function ( value, type, full )  {
											return full.id;
										}
									},{
										"aTargets": [ 1 ],
										"width": "20%",
										"mRender": function ( value, type, full )  {
											return full.jenis_kehadiran;
										}
									},{
										"aTargets": [ 2 ],
										"width": "20%",
										"mRender": function ( value, type, full )  {
											return full.kehadiran_nama;
										}
									},{
										"aTargets": [ 3 ],
										"width": "20%",
										"mRender": function ( value, type, full )  {
											return full.kehadiran_ic;
										}
									},{
										"aTargets": [ 4 ],
										"width": "20%",
										"mRender": function ( value, type, full )  {
											return full.kehadiran_jawatan;
										}
									}],
									"order": [[ 0, 'asc' ]],
									initComplete: function () {
										$('[data-toggle="tooltip"]').tooltip();
										$.fn.check_hadir();
									}
								});
							},
							error: function (data) {
								console.log('Error:', data);
							}
						});
					}
				}else
				{
					$($objname).html("tidak");
					$.each($("#senarai_ajk_table tr"),function(index){
						if(index>0)
						{
							var self=$(this).closest("tr");
							var member_0_value = self.find("td:eq(0)").text().trim();
							var member_1_value = self.find("td:eq(1)").text().trim();
							var member_2_value = self.find("td:eq(2)").text().trim();
							if(member_0_value == ajkid)
							{
								ada="ada";
								data_ajkid=member_0_value;
								data_ajknama=member_1_value;
								data_ajkjawatan=member_2_value;
								data_mtgid="{{$krt_minit_mesyuarat->id}}";
								data_jenishadir=0;
							}
						}
					});
					if(ada == "ada")
					{
						$.ajax({
							type: "GET",
							url: url_delete_kehadiran_ajk_mesyuarat,
							data: { ajkid: data_ajkid, ajk_nama: data_ajknama, mtg_id: data_mtgid, jenis_hadir:data_jenishadir },
							success: function (data) {
								swal("Buang kehadiran!", "Rekod kehadiran telah dibuang dari pangkalan data", "success");
								$('#senarai_kehadiran_all_table').DataTable().destroy();
								$('#senarai_ajk_table').DataTable().destroy();
								var senarai_ajk_table = $('#senarai_ajk_table').DataTable( {
									processing: true,
									serverSide: true,
									ajax: url_get_senarai_ajk,
									paging: false,
									searching: false, 
									info: false,
									responsive: true,
									"aoColumnDefs":[{
										"aTargets": [ 0 ],
										"width": "10%",
										"mRender": function ( value, type, full )  {
											return full.ajk_id;
										}
									},{
										"aTargets": [ 1 ],
										"width": "20%",
										"mRender": function ( value, type, full )  {
											return full.ajk_nama;
										}
									},{
										"aTargets": [ 2 ],
										"width": "20%",
										"mRender": function ( value, type, full )  {
											return full.ajk_jawatan;
										}
									},{
										"aTargets": [ 3 ],
										"width": "20%",
										"mRender": function ( value, type, full )  {
											return full.ajk_jawatan_krt_id;
										}
									}],
									"order": [[ 3, 'asc' ]],
									initComplete: function () {
										$('[data-toggle="tooltip"]').tooltip();
									}
								});
								var senarai_kehadiran_all_table = $('#senarai_kehadiran_all_table').DataTable( {
									processing: true,
									serverSide: true,
									ajax: url_get_senarai_kehadiran_all,
									paging: false,
									searching: false, 
									info: false,
									responsive: true,
									"aoColumnDefs":[{
										"aTargets": [ 0 ],
										"width": "10%",
										"mRender": function ( value, type, full )  {
											return full.id;
										}
									},{
										"aTargets": [ 1 ],
										"width": "20%",
										"mRender": function ( value, type, full )  {
											return full.jenis_kehadiran;
										}
									},{
										"aTargets": [ 2 ],
										"width": "20%",
										"mRender": function ( value, type, full )  {
											return full.kehadiran_nama;
										}
									},{
										"aTargets": [ 3 ],
										"width": "20%",
										"mRender": function ( value, type, full )  {
											return full.kehadiran_ic;
										}
									},{
										"aTargets": [ 4 ],
										"width": "20%",
										"mRender": function ( value, type, full )  {
											return full.kehadiran_jawatan;
										}
									}],
									"order": [[ 0, 'asc' ]],
									initComplete: function () {
										$('[data-toggle="tooltip"]').tooltip();
										$.fn.check_hadir();
									}
								});
							},
							error: function (data) {
								console.log('Error:', data);
							}
						});
					}
				}
			}

			$.fn.delete_kehadiran = function(kehadiranid) { 
				$.ajax({
					type: "GET",
					url: "{{ route('rt-sm5.delete_kehadiran','') }}" + "/" + kehadiranid,
					success: function (response) {
								swal("Buang kehadiran!", "Rekod kehadiran telah dibuang dari pangkalan data", "success");
								$('#senarai_kehadiran_all_table').DataTable().destroy();
								$('#senarai_ajk_table').DataTable().destroy();
								var senarai_ajk_table = $('#senarai_ajk_table').DataTable( {
									processing: true,
									serverSide: true,
									ajax: url_get_senarai_ajk,
									paging: false,
									searching: false, 
									info: false,
									responsive: true,
									"aoColumnDefs":[{
										"aTargets": [ 0 ],
										"width": "10%",
										"mRender": function ( value, type, full )  {
											return full.ajk_id;
										}
									},{
										"aTargets": [ 1 ],
										"width": "20%",
										"mRender": function ( value, type, full )  {
											return full.ajk_nama;
										}
									},{
										"aTargets": [ 2 ],
										"width": "20%",
										"mRender": function ( value, type, full )  {
											return full.ajk_jawatan;
										}
									}],
									"order": [[ 1, 'asc' ]],
									initComplete: function () {
										$('[data-toggle="tooltip"]').tooltip();
									}
								});
								var senarai_kehadiran_all_table = $('#senarai_kehadiran_all_table').DataTable( {
									processing: true,
									serverSide: true,
									ajax: url_get_senarai_kehadiran_all,
									paging: false,
									searching: false, 
									info: false,
									responsive: true,
									"aoColumnDefs":[{
										"aTargets": [ 0 ],
										"width": "10%",
										"mRender": function ( value, type, full )  {
											return full.id;
										}
									},{
										"aTargets": [ 1 ],
										"width": "20%",
										"mRender": function ( value, type, full )  {
											return full.jenis_kehadiran;
										}
									},{
										"aTargets": [ 2 ],
										"width": "20%",
										"mRender": function ( value, type, full )  {
											return full.kehadiran_nama;
										}
									},{
										"aTargets": [ 3 ],
										"width": "20%",
										"mRender": function ( value, type, full )  {
											return full.kehadiran_ic;
										}
									},{
										"aTargets": [ 4 ],
										"width": "20%",
										"mRender": function ( value, type, full )  {
											return full.kehadiran_jawatan;
										}
									}],
									"order": [[ 0, 'asc' ]],
									initComplete: function () {
										$('[data-toggle="tooltip"]').tooltip();
										$.fn.check_hadir();
									}
								});
							},
					error: function (data) {
						console.log('Error:', data);
						}
				});
			}
			
			var senarai_ajk_table = $('#senarai_ajk_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_get_senarai_ajk,
				paging: false,
				searching: false, 
				info: false,
				responsive: true,
				"aoColumnDefs":[{
					"aTargets": [ 0 ],
					"width": "10%",
					"mRender": function ( value, type, full )  {
						return full.ajk_id;
					}
				},{
					"aTargets": [ 1 ],
					"width": "20%",
					"mRender": function ( value, type, full )  {
						return full.ajk_nama;
					}
				},{
					"aTargets": [ 2 ],
					"width": "20%",
					"mRender": function ( value, type, full )  {
						return full.ajk_jawatan;
					}
				},{
					"aTargets": [ 3 ],
					"width": "20%",
					"mRender": function ( value, type, full )  {
						return full.ajk_jawatan_krt_id;
					}
				}],
				"order": [[ 3, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});
			
			var senarai_kehadiran_all_table = $('#senarai_kehadiran_all_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_get_senarai_kehadiran_all,
				paging: false,
				searching: false, 
				info: false,
				responsive: true,
				"aoColumnDefs":[{
					"aTargets": [ 0 ],
					"width": "10%",
					"mRender": function ( value, type, full )  {
						return full.id;
					}
				},{
					"aTargets": [ 1 ],
					"width": "20%",
					"mRender": function ( value, type, full )  {
						return full.jenis_kehadiran;
					}
				},{
					"aTargets": [ 2 ],
					"width": "20%",
					"mRender": function ( value, type, full )  {
						return full.kehadiran_nama;
					}
				},{
					"aTargets": [ 3 ],
					"width": "20%",
					"mRender": function ( value, type, full )  {
						return full.kehadiran_ic;
					}
				},{
					"aTargets": [ 4 ],
					"width": "20%",
					"mRender": function ( value, type, full )  {
						return full.kehadiran_jawatan;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
					$.fn.check_hadir();
				}
			});
			
			var senarai_kehadiran_table = $('#senarai_kehadiran_table').DataTable( {
				"language": {
					"paginate": {
						"previous": "Sebelumnya",
						"next": "Seterusnya",
					},
					"sSearch": "Carian",
					"sLengthMenu": "Paparan _MENU_ rekod",
					"lengthMenu": "Paparan _MENU_ rekod setiap laman",
					//"zeroRecords": function(){ $('#count_kehadiran').val("tiada"); },
					"info": "Paparan laman _PAGE_ dari _PAGES_ daripada _TOTAL_ rekod",
					"infoEmpty": "",
					"infoFiltered": "(diisih dari _MAX_ keseluruhan rekod)"
				},
				dom: 'rtip',
				"bFilter": true,
				responsive: true,
				"columns": [
					{ "width": "5%", sClass: 'text-center', },
					{ "width": "40%" },
					{ "width": "30%" },
					{ "width": "20%", sClass: 'text-center', },
  				]
			});
			
			var senarai_kehadiran_ajk_table = $('#senarai_kehadiran_ajk_table').DataTable( {
				paging: false,
				searching: false, 
				info: false,
				pageLength: 25,
				responsive: true,
				dom: 'rtip',
				"columns": [
						{ "width": "5%", sClass: 'text-center', },
						{ "width": "40%" },
						{ "width": "30%" },
						{ "width": "20%", sClass: 'text-center', },
						{ "width": "5%", 'visible': false, },
  					]
			});
			
		/* Maklumat Note Kemaskini */
			$('#pmmrt_status').val("{{$krt_minit_mesyuarat->mesyuarat_status}}");

            if($('#pmmrt_status').val() == '4'){
                $("#pmmrt_perlu_kemaskini").show();
                $('#pmmrt_status_description').html("{{$krt_minit_mesyuarat->status_description}}");
                $('#pmmrt_disahkan_note').html("{{$krt_minit_mesyuarat->disemak_note}}");
            }

		/* Maklumat Button */

			$('#btn_back').click(function(){
				event.preventDefault();
				var data = $("#form_pmmrt").serialize();
				url = add_minit_mesyuarat_rt_config.routes.kembali_minit_mesyuarat_rt_url;
				type = "POST";
				$.ajax({
					url: url,
					type: type,
					data: data,
				}).done(function(response) {
					window.location.href = '{{route('rt-sm5.senarai_minit_mesyuarat_rt')}}';
				});
			});
			
		});

		//my custom script
		var add_minit_mesyuarat_rt_config = {
			routes: {
				add_minit_mesyuarat_rt_url: "{{ route('rt-sm5.post_penyediaan_minit_mesyuarat_rt') }}",
				kembali_minit_mesyuarat_rt_url: "{{ route('rt-sm5.kembali_penyediaan_minit_mesyuarat_rt') }}",
			}
		};

		$(document).on('submit', '#form_pmmrt', function(event){
			event.preventDefault();
			var data = $("#form_pmmrt").serialize();
			$('#btn_next').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_next').prop('disabled', true);
			var action = $('#post_penyediaan_minit_mesyuarat_rt').val();
			var btn_text;
			if (action == 'edit') {
				url = add_minit_mesyuarat_rt_config.routes.add_minit_mesyuarat_rt_url;
				type = "POST";
				btn_text = 'Seterusnya &nbsp;<i class="dropdown-icon fe fe-arrow-right"></i>';
			}
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {
				$('[name=pmmrt_mesyuarat_title]').removeClass("is-invalid");
				$('[name=pmmrt_mesyuarat_tarikh]').removeClass("is-invalid");
				$('[name=pmmrt_mesyuarat_bil]').removeClass("is-invalid");
				$('[name=pmmrt_mesyuarat_time]').removeClass("is-invalid");
				$('[name=pmmrt_mesyuarat_tempat]').removeClass("is-invalid");
				$('[name=pmmrt_pengerusi_mesyuarat]').removeClass("is-invalid");
				$('[name=pmmrt_catat_mesyuarat]').removeClass("is-invalid");
				$('[name=pmmrt_mesyuarat_perutusan_pengerusi]').removeClass("is-invalid");
				$('[name=pmmrt_mesyuarat_yang_lalu]').removeClass("is-invalid");
	
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'pmmrt_mesyuarat_title') {
							$('[name=pmmrt_mesyuarat_title]').addClass("is-invalid");
							$('.error_pmmrt_mesyuarat_title').html(error);
						}
						if(index == 'pmmrt_mesyuarat_tarikh') {
							$('[name=pmmrt_mesyuarat_tarikh]').addClass("is-invalid");
							$('.error_pmmrt_mesyuarat_tarikh').html(error);
						}
						if(index == 'pmmrt_mesyuarat_bil') {
							$('[name=pmmrt_mesyuarat_bil]').addClass("is-invalid");
							$('.error_pmmrt_mesyuarat_bil').html(error);
						}
						if(index == 'pmmrt_mesyuarat_time') {
							$('[name=pmmrt_mesyuarat_time]').addClass("is-invalid");
							$('.error_pmmrt_mesyuarat_time').html(error);
						}
						if(index == 'pmmrt_mesyuarat_tempat') {
							$('[name=pmmrt_mesyuarat_tempat]').addClass("is-invalid");
							$('.error_pmmrt_mesyuarat_tempat').html(error);
						}
						if(index == 'pmmrt_pengerusi_mesyuarat') {
							$('[name=pmmrt_pengerusi_mesyuarat]').addClass("is-invalid");
							$('.error_pmmrt_pengerusi_mesyuarat').html(error);
						}
						if(index == 'pmmrt_catat_mesyuarat') {
							$('[name=pmmrt_catat_mesyuarat]').addClass("is-invalid");
							$('.error_pmmrt_catat_mesyuarat').html(error);
						}
						if(index == 'pmmrt_mesyuarat_perutusan_pengerusi') {
							$('[name=pmmrt_mesyuarat_perutusan_pengerusi]').addClass("is-invalid");
							$('.error_pmmrt_mesyuarat_perutusan_pengerusi').html(error);
						}
						if(index == 'pmmrt_mesyuarat_yang_lalu') {
							$('[name=pmmrt_mesyuarat_yang_lalu]').addClass("is-invalid");
							$('.error_pmmrt_mesyuarat_yang_lalu').html(error);
						}
					});
					$('#btn_next').html(btn_text);
					$('#btn_next').prop('disabled', false);
				} else 
				{
					$('#btn_next').html(btn_text);
					$('#btn_next').prop('disabled', false);
					window.location.href = "{{route('rt-sm5.penyediaan_minit_mesyuarat_rt_1','')}}"+"/"+{{$krt_minit_mesyuarat->id}};
				}
			});
		});

		$(document).on('click', '#btn_save_kehadiran', function(event){
		    event.preventDefault();
			var data = $("#form_pmmrt").serialize();
			url = url_add_kehadiran_mesyuarat;
			type = "POST";
			$.ajax({
				url: url,
				type: type,
				data: data,
				error:function(x,e) {
						if (x.status==0) {
							alert('You are offline!!\n Please Check Your Network.');
						} else if(x.status==404) {
							alert('Requested URL not found.');
						} else if(x.status==500) {
							alert('Internel Server Error.');
						} else if(e=='parsererror') {
							alert('Error.\nParsing JSON Request failed.');
						} else if(e=='timeout'){
							alert('Request Time out.');
						} else {
							alert('Unknow Error.\n'+x.responseText);
						}
					}
			}).done(function(response) {
				$('[name=kehadiran_nama]').removeClass("is-invalid");
				$('[name=kehadiran_ic]').removeClass("is-invalid");
	
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'kehadiran_nama') {
							$('[name=kehadiran_nama]').addClass("is-invalid");
							$('.error_kehadiran_nama').html(error);
						}
						if(index == 'kehadiran_ic') {
							$('[name=kehadiran_ic]').addClass("is-invalid");
							$('.error_kehadiran_ic').html(error);
						}
					});
				}else
				{
					swal("Tambah kehadiran!", "Rekod kehadiran telah ditambah ke pangkalan data", "success");
					$('#kehadiran_nama').val("");
					$('#kehadiran_ic').val("");
					$('#senarai_kehadiran_all_table').DataTable().destroy();
					$('#senarai_ajk_table').DataTable().destroy();
					var senarai_ajk_table = $('#senarai_ajk_table').DataTable( {
						processing: true,
						serverSide: true,
						ajax: url_get_senarai_ajk,
						paging: false,
						searching: false, 
						info: false,
						responsive: true,
						"aoColumnDefs":[{
							"aTargets": [ 0 ],
							"width": "10%",
							"mRender": function ( value, type, full )  {
								return full.ajk_id;
							}
						},{
							"aTargets": [ 1 ],
							"width": "20%",
							"mRender": function ( value, type, full )  {
								return full.ajk_nama;
							}
						},{
							"aTargets": [ 2 ],
							"width": "20%",
							"mRender": function ( value, type, full )  {
								return full.ajk_jawatan;
							}
						},{
							"aTargets": [ 3 ],
							"width": "20%",
							"mRender": function ( value, type, full )  {
								return full.ajk_jawatan_krt_id;
							}
						}],
						"order": [[ 3, 'asc' ]],
						initComplete: function () {
							$('[data-toggle="tooltip"]').tooltip();
						}
					});
					var senarai_kehadiran_all_table = $('#senarai_kehadiran_all_table').DataTable( {
						processing: true,
						serverSide: true,
						ajax: url_get_senarai_kehadiran_all,
						paging: false,
						searching: false, 
						info: false,
						responsive: true,
						"aoColumnDefs":[{
							"aTargets": [ 0 ],
							"width": "10%",
							"mRender": function ( value, type, full )  {
								return full.id;
							}
						},{
							"aTargets": [ 1 ],
							"width": "20%",
							"mRender": function ( value, type, full )  {
								return full.jenis_kehadiran;
							}
						},{
							"aTargets": [ 2 ],
							"width": "20%",
							"mRender": function ( value, type, full )  {
								return full.kehadiran_nama;
							}
						},{
							"aTargets": [ 3 ],
							"width": "20%",
							"mRender": function ( value, type, full )  {
								return full.kehadiran_ic;
							}
						},{
							"aTargets": [ 4 ],
							"width": "20%",
							"mRender": function ( value, type, full )  {
							return full.kehadiran_jawatan;
							}
						}],
						"order": [[ 0, 'asc' ]],
						initComplete: function () {
							$('[data-toggle="tooltip"]').tooltip();
							$.fn.check_hadir();
						}
					});
				}
			});
		});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>

<script src="../assets/bundles/dataTables.bundle.js"></script>
<script src="assets/js/table/datatable.js"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

<!-- <script src="../assets/bundles/summernote.bundle.js"></script>
<script src="assets/js/page/summernote.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="{{ asset('assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
@stop
