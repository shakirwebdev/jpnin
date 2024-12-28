@include('js.modal.j-modal-add-kedudukan-kes')
@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
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
			url_table_kedudukan_kes 		= "{{ route('rt-sm21.get_ikes_kedudukan','') }}"+"/"+"{{$ikes->id}}";
			url_delete_kedudukan_kes 		= "{{ route('rt-sm21.delete_kedudukan_kes','') }}";
			url_table_dokument_kes 			= "{{ route('rt-sm21.get_dokument_kes_table','') }}"+"/"+"{{$ikes->id}}";
			url_delete_dokument_kes 		= "{{ route('rt-sm21.delete_dokument_kes','') }}";

		/* Maklumat Kes Dalam Krt */
			if("{{$ikes->hasRT}}" == 1){
				$('#pipp8_hasRT').attr("checked", "checked");
			}
			$('#pipp8_negeri_id').val("{{$ikes->krt_state_id}}");
			$('#pipp8_daerah_id').val("{{$ikes->krt_daerah_id}}");
			$('#pipp8_krt_profile_id').val("{{$ikes->krt_profile_id}}");

		/* Maklumat Pemohon */
			$('#pipp8_user_fullname').val("{{$ikes->nama_permohon}}");
			$('#pipp8_user_no_ic').val("{{$ikes->ic_pemohon}}");
			$('#pipp8_user_no_phone').val("{{$ikes->phone_pemohon}}");
			$('#pipp8_dihantar_alamat').val("{{$ikes->dihantar_alamat}}");

		/* Maklumat Kes Kejadian */
			$('#pipp8_ikes_keadaan_semasa').val("{{$ikes->ikes_keadaan_semasa}}");
			$('#pipp8_ikes_jangkaan_keadaan').html("{{$ikes->ikes_jangkaan_keadaan}}");

			var senarai_kedudukan_kes_table = $('#senarai_kedudukan_kes_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_kedudukan_kes,
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
				"aoColumnDefs":[{          
					"aTargets": [ 0 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function (data, type, full, meta)  {
						return  meta.row+1;
					}
				},{          
					"aTargets": [ 1 ], 
					"width": "40%", 
					"mRender": function ( value, type, full )  {
						return full.jenis_harta;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "28%", 
					"mRender": function ( value, type, full )  {
						return full.nilai_anggaran_kerosakan;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_kedudukan_kes" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			var senarai_gambar_ikes_table = $('#senarai_gambar_ikes_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_dokument_kes,
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
						return full.file_dokument;
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Download Fail Peta Kawasan" id="download_dokument" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-download"></i></button>';
						button_b = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_dokument" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a + '|' + button_b;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			$('#pipp8_ikes_jangkaan_keadaan').summernote({
				height: 200
			});
			
			$('#pipp9_spk_ikes_id').val("{{$ikes->id}}");
        	$('#pipp10_ikes_id').val("{{$ikes->id}}");

		/* Maklumat Note Kemaskini */
			$('#pipp8_status').val("{{$ikes->status}}");

			if($('#pipp8_status').val() == '11'){
				$("#pipp8_perlu_kemaskini").show();
				$('#pipp8_status_description').html("{{$ikes->status_description}}");
				$('#pipp8_disemak_note').html("{{$ikes->disemak_note}}");
			}

			if($('#pipp8_status').val() == '12'){
				$("#pipp8_perlu_kemaskini").show();
				$('#pipp8_status_description').html("{{$ikes->status_description}}");
				$('#pipp8_disahkan_note').html("{{$ikes->disahkan_note}}");
			}

			if($('#pipp8_status').val() == '15'){
				$("#pipp8_perlu_kemaskini").show();
				$('#pipp8_status_description').html("{{$ikes->status_description}}");
				$('#pipp8_disahkan_note').html("{{$ikes->disahkan_note}}");
			}

        /* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{route('rt-sm21.permohonan_ikes_bpp_2','')}}"+"/"+"{{$ikes->id}}";
			});

	});

	// add Kedudukan Kes
		var add_kedudukan_kes_config = {
			routes: {
				add_kedudukan_kes_url: "{{ route('rt-sm21.add_kedudukan_kes') }}",
			}
		};

		$(document).on('submit', '#form_makk', function(event){    
			event.preventDefault();
			$('#btn_add').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_add').prop('disabled', true);
			var data = $("#form_makk").serialize();
			var action = $('#add_kedudukan_kes').val();
			var btn_text;
			if (action == 'add') {
				url = add_kedudukan_kes_config.routes.add_kedudukan_kes_url;
				type = "POST";
				btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			}
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=makk_jenis_harta]').removeClass("is-invalid");
				$('[name=makk_nilai_anggaran_kerosakan]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'makk_jenis_harta') {
							$('[name=makk_jenis_harta]').addClass("is-invalid");
							$('.error_makk_jenis_harta').html(error);
						}

						if(index == 'makk_nilai_anggaran_kerosakan') {
							$('[name=makk_nilai_anggaran_kerosakan]').addClass("is-invalid");
							$('.error_makk_nilai_anggaran_kerosakan').html(error);
						}

					});
					$('#btn_add').html(btn_text);                
					$('#btn_add').prop('disabled', false);            
				} else {
					$('#modal_add_kedudukan_kes').modal('hide');
					swal("Maklumat kedudukan kes ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_makk').trigger("reset");
					$('#senarai_kedudukan_kes_table').DataTable().ajax.reload();
					$('#btn_add').html(btn_text);                
					$('#btn_add').prop('disabled', false); 
				}
			});
		});

	// delete Kedudukan Kes
		$('body').on('click', '#delete_kedudukan_kes', function () {
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
						url: url_delete_kedudukan_kes +"/" + delete_id,
						success: function (data) {
							// $('#peranan_form').trigger("reset");
							$('#senarai_kedudukan_kes_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod Bilangan Yang Terlibat Mengikut Etnik telah dipadam dari pangkalan data", "success");
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

	/* click add dokument */
		$(document).on('submit', '#form_pipp9', function(event){
			var info = $('.error_form_pipp9');
			event.preventDefault();

			var form_data = new FormData();
			form_data.append("pipp9_file_title", $("#pipp9_file_title").val() );
			form_data.append("pipp9_file_catatan", $("#pipp9_file_catatan").val() );
			form_data.append("pipp9_file_dokument",  $("#pipp9_file_dokument")[0].files[0]);
			form_data.append("pipp9_spk_ikes_id", $("#pipp9_spk_ikes_id").val() );
			form_data.append("add_spk_ikes_dokument_bpp", "add" );
			console.log(form_data);
			$('#btn_save_dokument').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save_dokument').prop('disabled', true);
			btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			url = "{{ route('rt-sm21.add_spk_ikes_dokument_bpp') }}";
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
					$('#btn_save_dokument').html(btn_text);                
					$('#btn_save_dokument').prop('disabled', false);
					info.slideDown();
				} else {
					swal("Fail Dokument ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_pipp9').trigger("reset");
					$('#btn_save_dokument').html(btn_text);
					$('#btn_save_dokument').prop('disabled', false);
					$('#senarai_gambar_ikes_table').DataTable().ajax.reload();
				}
			});
		});

	/* click download dokument */
		//my custom script
		var download_dokument_ikes_bpp_config = {
			routes: {
				download_dokument_ikes_bpp_url: "{{ route('rt-sm21.get_data_ikes_dokument','') }}",
			}
		};

		$('body').on('click', '#download_dokument', function () {
			var download_id = $(this).data("id");
			$.get(download_dokument_ikes_bpp_config.routes.download_dokument_ikes_bpp_url + '/' + download_id, function (data) {
				let link = document.createElement("a");
				link.download = data.file_dokument;
				link.href = "{{ asset('storage/ikes_dokument') }}"+"/"+ data.file_dokument ;
				link.click();
			});
		});

	/* click delete dokument */
		$('body').on('click', '#delete_dokument', function () {
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
						url: url_delete_dokument_kes +"/" + delete_id,
						success: function (data) {
							// $('#peranan_form').trigger("reset");
							$('#senarai_gambar_ikes_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Fail Dokument telah dipadam dari pangkalan data", "success");
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

	/* click btn Submit */
		//my custom script
		var permohonan_ikes_bpp_4_config = {
			routes: {
				permohonan_ikes_bpp_4_url: "{{ route('rt-sm21.post_permohonan_ikes_bpp_4') }}",
			}
		};

		$(document).on('submit', '#form_pipp10', function(event){    
			event.preventDefault();
			$('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_submit').prop('disabled', true);
			var data   = $("#form_pipp8, #form_pipp10").serialize();
			var action = $('#post_permohonan_ikes_bpp_4').val();
			var btn_text;
			if (action == 'edit') {
				url = permohonan_ikes_bpp_4_config.routes.permohonan_ikes_bpp_4_url;
				type = "POST";
				btn_text = 'Hantar Permohonan Pelaporan i-Kes &nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=pipp8_ikes_keadaan_semasa]').removeClass("is-invalid");
				$('[name=pipp8_ikes_jangkaan_keadaan]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'pipp8_ikes_keadaan_semasa') {
							$('[name=pipp8_ikes_keadaan_semasa]').addClass("is-invalid");
							$('.error_pipp8_ikes_keadaan_semasa').html(error);
						}

						if(index == 'pipp8_ikes_jangkaan_keadaan') {
							$('[name=pipp8_ikes_jangkaan_keadaan]').addClass("is-invalid");
							$('.error_pipp8_ikes_jangkaan_keadaan').html(error);
						}

					});
					$('#btn_submit').html(btn_text);                
					$('#btn_submit').prop('disabled', false);            
				} else {
					$('#btn_submit').html(btn_text);
					$('#btn_submit').prop('disabled', false); 
					window.location.href = "{{route('rt-sm21.senarai_permohonan_ikes_bpp')}}";
				}
			});
		});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop