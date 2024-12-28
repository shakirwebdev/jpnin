@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
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
    
	$(document).ready( function () {

		//my custom script
			url_table_peta_kawasan 		= "{{ route('rt-sm12.get_profile_srs_peta_kawasan_table','') }}"+"/"+"{{$surat_penubuhan_srs->id}}";
			url_delete_peta_kawasan 	= "{{ route('rt-sm12.delete_profile_srs_peta_kawasan','') }}";

		/* Maklumat Kawasan Krt */
			$('#sppsp_2_nama_krt').html("{{$surat_penubuhan_srs->nama_krt}}");
			$('#sppsp_2_alamat_krt').html("{{$surat_penubuhan_srs->alamat_krt}}");
			$('#sppsp_2_negeri_krt').html("{{$surat_penubuhan_srs->negeri_krt}}");
			$('#sppsp_2_daerah_krt').html("{{$surat_penubuhan_srs->daerah_krt}}");
			$('#sppsp_2_parlimen_krt').html("{{$surat_penubuhan_srs->parlimen_krt}}");
			$('#sppsp_2_dun_krt').html("{{$surat_penubuhan_srs->dun_krt}}");
			$('#sppsp_2_pbt_krt').html("{{$surat_penubuhan_srs->pbt_krt}}");

		/* Maklumat Pemohon */
			$('#sppsp_2_nama_pemohon').val("{{$surat_penubuhan_srs->nama_pemohon}}");
			$('#sppsp_2_ic_pemohon').val("{{$surat_penubuhan_srs->ic_pemohon}}");
			$('#sppsp_2_address_pemohon').val("{{$surat_penubuhan_srs->address_pemohon}}");

		/* Maklumat Minit Meeting */
			url_senarai_minit_meeting_table 	= "{{ route('rt-sm12.get_senarai_minit_meeting_table','') }}"+"/"+"{{$surat_penubuhan_srs->id}}";

			var senarai_minit_meeting_table = $('#senarai_minit_meeting_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_senarai_minit_meeting_table,
				"language": {
					"paginate": {
						"previous": "Sebelumnya",
						"next": "Seterusnya",
						searchPanes: {
							emptyPanes: 'There are no panes to display. :/'
						}
					},
					"sSearch": "Carian",
					"sLengthMenu": "Paparan _MENU_ rekod",
					"lengthMenu": "Paparan _MENU_ rekod setiap laman",
					"zeroRecords": "Tiada rekod ditemui",
					"info": "Paparan laman _PAGE_ dari _PAGES_ daripada _TOTAL_ rekod",
					"infoEmpty": "",
					"infoFiltered": "(diisih dari _MAX_ keseluruhan rekod)"
				},
				dom: 'rtip',
				"bFilter": true,
				"bSort": false,
				responsive: true,
				rowCallback: function(nRow, aData, index) {
					var info = senarai_minit_meeting_table.page.info();
					$('td', nRow).eq(0).html(info.page * info.length + (index + 1));
				},
				"aoColumnDefs":[{          
					"aTargets": [ 0 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function (data, type, full, meta)  {
						return  meta.row+1;
					}
				},{          
					"aTargets": [ 1 ], 
					"width": "60%", 
					"mRender": function ( value, type, full )  {
						return full.mesyuarat_title;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "28%", 
					"mRender": function ( value, type, full )  {
						return full.keterangan;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "6%",
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Cetak Minit Mesyuarat JawatanKuasa" target="_blank" onclick="print_minit_mesyuarat(\'' + full.minit_mesyuarat_id + '\');"><i class="fa fa-print"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

		/* Maklumat Status Semakan */
			$('#sppsp_2_srs_id').val("{{$surat_penubuhan_srs->id}}");
			$('#sppsp_2_disemak_note').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

		/* Maklumat Pelan Lakar */
			$('#sppsppd2_srs_profile_id').val("{{$surat_penubuhan_srs->id}}");
			var senarai_peta_kawasan_srs_table = $('#senarai_peta_kawasan_srs_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_peta_kawasan,
				"language": {
					"paginate": {
						"previous": "Sebelumnya",
						"next": "Seterusnya",
					},
					"sSearch": "Carian",
					"sLengthMenu": "Paparan _MENU_ rekod",
					"lengthMenu": "Paparan _MENU_ rekod setiap laman",
					"zeroRecords": "Tiada rekod ditemui",
					"info": "Paparan laman _PAGE_ dari _PAGES_ daripada _TOTAL_ rekod",
					"infoEmpty": "",
					"infoFiltered": "(diisih dari _MAX_ keseluruhan rekod)"
				},
				dom: 'rtip',
				"bFilter": true,
				"bSort": false,
				responsive: true,
				"aoColumnDefs":[{          
					"aTargets": [ 0 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function (data, type, full, meta)  {
						return  meta.row+1;
					}
				},{          
					"aTargets": [ 1 ], 
					"width": "38%", 
					"mRender": function ( value, type, full )  {
						return full.file_title;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "30%", 
					"mRender": function ( value, type, full )  {
						return full.file_catatan;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "30%", 
					"mRender": function ( value, type, full )  {
						return full.file_peta;
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Download Fail Peta Kawasan" id="download_peta_kawasan" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-download"></i></button>';
						button_b = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_srs_peta_kawasan" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a + '|' + button_b;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

		/* Maklumat Note Kemaskini */
			$('#sppsp_status').val("{{$surat_penubuhan_srs->srs_status}}");
				
			if($('#sppsp_status').val() == '8'){
				$("#sppsp_perlu_kemaskini").show();
				$('#sppsp_status_description').html("{{$surat_penubuhan_srs->status_description}}");
				$('#sppsp_disahkan_note').html("{{$surat_penubuhan_srs->disahkan_note}}");
			}
		
        /* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{route('rt-sm12.semak_permohonan_penubuhan_srs_ppd_1','')}}"+"/"+{{$surat_penubuhan_srs->id}};
			});
	});

	/* click button print minit meeting */
		function print_minit_mesyuarat(id){
			window.location.href = "{{route('pdf.minit_mesyuarat','')}}"+"/"+id;
		}

	/* click add peta kawasan */
		$(document).on('submit', '#form_sppsppd2', function(event){
			var info = $('.error_form_sppsppd2');
			event.preventDefault();

			var form_data = new FormData();
			form_data.append("sppsppd2_file_title", $("#sppsppd2_file_title").val() );
			form_data.append("sppsppd2_file_catatan", $("#sppsppd2_file_catatan").val() );
			form_data.append("sppsppd2_file_peta",  $("#sppsppd2_file_peta")[0].files[0]);
			form_data.append("sppsppd2_srs_profile_id", $("#sppsppd2_srs_profile_id").val() );
			form_data.append("add_profile_srs_peta_kawasan", "add" );
			console.log(form_data);

			$('#btn_save_peta_kawasan').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save_peta_kawasan').prop('disabled', true);

			btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			url = "{{ route('rt-sm12.add_profile_srs_peta_kawasan') }}";
			type = "POST";

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$.ajax({
				url: url,
				type: type,
				data: form_data,
				contentType: false,
            	processData: false,
      			async: false,
			}).done(function(response) {            
				info.hide().find('ul').empty();
				if(response.errors){
					$.each(response.errors, function(index, error){
						info.find('ul').append('<li>'+error+'</li>');
					});
					$('#btn_save_peta_kawasan').html(btn_text);                
					$('#btn_save_peta_kawasan').prop('disabled', false);
					info.slideDown();
				} else {
					swal("Fail Peta Kawasan ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_sppsppd2').trigger("reset");
					$('#btn_save_peta_kawasan').html(btn_text);
					$('#btn_save_peta_kawasan').prop('disabled', false);
					$('#senarai_peta_kawasan_srs_table').DataTable().ajax.reload();
				}
			});
		});

	/* click download peta kawasan */
		//my custom script
		var download_peta_kawasan_config = {
			routes: {
				download_peta_kawasan_url: "{{ route('rt-sm12.get_data_srs_peta_kawasan','') }}",
			}
		};

		$('body').on('click', '#download_peta_kawasan', function () {
			var download_id = $(this).data("id");
			$.get(download_peta_kawasan_config.routes.download_peta_kawasan_url + '/' + download_id, function (data) {
				let link = document.createElement("a");
				link.download = data.file_peta;
				link.href = "{{ asset('storage/srs_peta_kawasan') }}"+"/"+ data.file_peta ;
				link.click();
			});
		});

	/* click delete peta kawasan */
		$('body').on('click', '#delete_srs_peta_kawasan', function () {
			var delete_id = $(this).data("id");
			swal({
				title: "Anda pasti?",
				text: "Anda akan memadam rekod ini dari pangkalan data!",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#dc3545",
				confirmButtonText: "Ya, sila padam!",
				cancelButtonText: "Tidak",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function (isConfirm) {
				if (isConfirm) {
					$.ajax({
						type: "GET",
						url: url_delete_peta_kawasan +"/" + delete_id,
						success: function (data) {
							// $('#peranan_form').trigger("reset");
							$('#senarai_peta_kawasan_srs_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Fail Peta Kawasan telah dipadam dari pangkalan data", "success");
						},
						error: function (data) {
							console.log('Error:', data);
						}
					});                    
				} else {
					swal("Tidak", "Proses pemadaman tidak berlaku", "error");
				}
			});
		});

	/* click button Hantar */
		//my custom script
		var semak_penubuhan_srs_config = {
			routes: {
				semak_penubuhan_action_url: "{{ route('rt-sm12.post_semak_permohonan_penubuhan_srs') }}",
			}
		};

		$(document).on('submit', '#form_sppsp_2', function(event){    
			event.preventDefault();
			$('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_submit').prop('disabled', true);
			var data = $("#form_sppsp_2").serialize();
			var action = $('#post_semak_permohonan_penubuhan_srs').val();
			var btn_text;
			if (action == 'edit') {
				url = semak_penubuhan_srs_config.routes.semak_penubuhan_action_url;
				type = "POST";
				btn_text = 'Hantar Status Semakan &nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=sppsp_2_srs_status]').removeClass("is-invalid");
				$('[name=sppsp_2_disemak_note]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'sppsp_2_srs_status') {
							$('[name=sppsp_2_srs_status]').addClass("is-invalid");
							$('.error_sppsp_2_srs_status').html(error);
						}

						if(index == 'sppsp_2_disemak_note') {
							$('[name=sppsp_2_disemak_note]').addClass("is-invalid");
							$('.error_sppsp_2_disemak_note').html(error);
						}

					});
					$('#btn_submit').html(btn_text);                
					$('#btn_submit').prop('disabled', false);            
				} else {
					$('#btn_submit').html(btn_text);
					$('#btn_submit').prop('disabled', false); 
					window.location.href = "{{route('rt-sm12.semak_permohonan_penubuhan_srs')}}";
				}
			});
		});
		


</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop