@include('js.modal.j-modal-add-pekara-berbangkit-mesyuarat-krt')
@include('js.modal.j-modal-view-pekara-berbangkit-mesyuarat-krt')
@include('js.modal.j-modal-add-kertas-kerja-mesyuarat-krt')
@include('js.modal.j-modal-view-kertas-kerja-mesyuarat-krt')
@include('js.modal.j-modal-add-hal-lain-mesyuarat-krt')
@include('js.modal.j-modal-view-hal-lain-mesyuarat-krt')
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
			url_get_senarai_perkara_berbangkit 			= "{{ route('rt-sm5.get_senarai_perkara_berbangkit','') }}"+"/"+"{{$krt_minit_mesyuarat->id}}";
			url_delete_perkara_berbangkit_mesyuarat 	= "{{ route('rt-sm5.delete_perkara_berbangkit_mesyuarat','') }}";
			url_get_senarai_kertas_kerja 				= "{{ route('rt-sm5.get_senarai_kertas_kerja','') }}"+"/"+"{{$krt_minit_mesyuarat->id}}";
			url_delete_kertas_kerja_mesyuarat 			= "{{ route('rt-sm5.delete_kertas_kerja_mesyuarat','') }}";
			url_get_senarai_hal_lain 					= "{{ route('rt-sm5.get_senarai_hal_lain','') }}"+"/"+"{{$krt_minit_mesyuarat->id}}";
			url_delete_hal_lain_mesyuarat 				= "{{ route('rt-sm5.delete_hal_lain_mesyuarat','') }}";

		/* Maklumat Kawasan Krt */
			$('#pmmrt_1_nama_krt').html("{{$krt_profile->nama_krt}}");
			$('#pmmrt_1_alamat_krt').html("{{$krt_profile->alamat_krt}}");
			$('#pmmrt_1_negeri_krt').html("{{$krt_profile->negeri_krt}}");
			$('#pmmrt_1_daerah_krt').html("{{$krt_profile->daerah_krt}}");
			$('#pmmrt_1_parlimen_krt').html("{{$krt_profile->parlimen_krt}}");
			$('#pmmrt_1_dun_krt').html("{{$krt_profile->dun_krt}}");
			$('#pmmrt_1_pbt_krt').html("{{$krt_profile->pbt_krt}}");

		/* Maklumat Minit Mesyuarat */
			$('#pmmrt_1_mesyuarat_penyata_kewangan').html("{{$krt_minit_mesyuarat->mesyuarat_penyata_kewangan}}");
			$('#pmmrt_1_mesyuarat_penutup').html("{{$krt_minit_mesyuarat->mesyuarat_penutup}}");
			$('#pmmrt_1_minit_mesyuarat_id').val("{{$krt_minit_mesyuarat->id}}");
			$('#pmmrt_1_mesyuarat_penyata_kewangan').summernote({
				height: 200,
				callbacks: {
					onImageUpload: function (data) {
						data.pop();
					},
					onPaste: function (e) {
						e.preventDefault();
						document.execCommand('insertText', false, bufferText);
					}
				}
			});

			var senarai_perkara_berbangkit_table = $('#senarai_perkara_berbangkit_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_get_senarai_perkara_berbangkit,
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
					"width": "44%", 
					"mRender": function ( value, type, full )  {
						return full.berbangkit_perkara;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "44%", 
					"mRender": function ( value, type, full )  {
						return full.berbangkit_tindakan;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "6%", 
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_pekara_berbangkit_mesyuarat_krt(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
						button_b = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_perkara_berbangkit_mesyuarat" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a + button_b;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			var senarai_kertas_kerja_table = $('#senarai_kertas_kerja_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_get_senarai_kertas_kerja,
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
					"width": "44%", 
					"mRender": function ( value, type, full )  {
						return full.kertas_kerja_perkara;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "44%", 
					"mRender": function ( value, type, full )  {
						return full.kertas_kerja_tindakan;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "6%", 
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_kertas_kerja_mesyuarat_krt(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
						button_b = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_kertas_kerja_mesyuarat" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a + button_b;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			var senarai_hal_lain_table = $('#senarai_hal_lain_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_get_senarai_hal_lain,
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
					"width": "44%", 
					"mRender": function ( value, type, full )  {
						return full.hal_lain_perkara;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "44%", 
					"mRender": function ( value, type, full )  {
						return full.hal_lain_tindakan;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "6%", 
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_hal_lain_mesyuarat_krt(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
						button_b = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_hal_lain_mesyuarat" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a + button_b;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			$('#pmmrt_1_mesyuarat_penutup').summernote({
				height: 200,
				callbacks: {
					onImageUpload: function (data) {
						data.pop();
					},
					onPaste: function (e) {
						e.preventDefault();
						document.execCommand('insertText', false, bufferText);
					}
				}
			});
			

		/* Maklumat Note Kemaskini */
			$('#pmmrt_status').val("{{$krt_minit_mesyuarat->mesyuarat_status}}");
            
            if($('#pmmrt_status').val() == '4'){
                $("#pmmrt_perlu_kemaskini").show();
                $('#pmmrt_status_description').html("{{$krt_minit_mesyuarat->status_description}}");
                $('#pmmrt_disahkan_note').html("{{$krt_minit_mesyuarat->disemak_note}}");
            }

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{route('rt-sm5.penyediaan_minit_mesyuarat_rt','')}}"+"/"+"{{$krt_minit_mesyuarat->id}}";
			});
	    
	});

	/* Senarai Pekara Berbangkit */
		var add_pekara_berbangkit_mesyuarat_config = {
			routes: {
				add_pekara_berbangkit_mesyuarat_url: "{{ route('rt-sm5.add_pekara_berbangkit_mesyuarat') }}",
			}
		};
	// add Pekara Berbangkit
		$(document).on('submit', '#form_mapbmk', function(event){    
			event.preventDefault();
			$('#btn_save').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			
			var data = $("#form_mapbmk").serialize();
			var action = $('#add_pekara_berbangkit_mesyuarat').val();
			var btn_text;
			if (action == 'add') {
				url = add_pekara_berbangkit_mesyuarat_config.routes.add_pekara_berbangkit_mesyuarat_url;
				type = "POST";
				btn_text = '<i class="fe fe-plus mr-2"></i> Tambah';
			}

			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=mapbmk_berbangkit_perkara]').removeClass("is-invalid");
				$('[name=mapbmk_berbangkit_tindakan]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'mapbmk_berbangkit_perkara') {
							$('[name=mapbmk_berbangkit_perkara]').addClass("is-invalid");
							$('.error_mapbmk_berbangkit_perkara').html(error);
						}

						if(index == 'mapbmk_berbangkit_tindakan') {
							$('[name=mapbmk_berbangkit_tindakan]').addClass("is-invalid");
							$('.error_mapbmk_berbangkit_tindakan').html(error);
						}

					});
					$('#btn_save').html(btn_text);                
					$('#btn_save').prop('disabled', false);            
				} else {
					$('#modal_add_pekara_berbangkit_mesyuarat_krt').modal('hide');
					swal("Maklumat Senarai Kehadiran ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_mapbmk').trigger("reset");
					$('#btn_save').html(btn_text);
					$('btn_save').prop('disabled', false);
					$('#senarai_perkara_berbangkit_table').DataTable().ajax.reload();
				}
			});
		});
	// Deleted Pekara Berbangkit
		$('body').on('click', '#delete_perkara_berbangkit_mesyuarat', function () {
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
						url: url_delete_perkara_berbangkit_mesyuarat +"/" + delete_id,
						success: function (data) {
							$('#senarai_perkara_berbangkit_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod peranan telah dipadam dari pangkalan data", "success");
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

	/* Senarai Kertas Kerja */
		var add_kertas_kerja_mesyuarat_config = {
			routes: {
				add_kertas_kerja_mesyuarat_url: "{{ route('rt-sm5.add_kertas_kerja_mesyuarat') }}",
			}
		};
	// add Kertas Kerja
		$(document).on('submit', '#form_makkmk', function(event){    
			event.preventDefault();
			$('#btn_save').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			
			var data = $("#form_makkmk").serialize();
			var action = $('#add_kertas_kerja_mesyuarat').val();
			var btn_text;
			if (action == 'add') {
				url = add_kertas_kerja_mesyuarat_config.routes.add_kertas_kerja_mesyuarat_url;
				type = "POST";
				btn_text = '<i class="fe fe-plus mr-2"></i> Tambah';
			}

			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=makkmk_kertas_kerja_perkara]').removeClass("is-invalid");
				$('[name=makkmk_kertas_kerja_tindakan]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'makkmk_kertas_kerja_perkara') {
							$('[name=makkmk_kertas_kerja_perkara]').addClass("is-invalid");
							$('.error_makkmk_kertas_kerja_perkara').html(error);
						}

						if(index == 'makkmk_kertas_kerja_tindakan') {
							$('[name=makkmk_kertas_kerja_tindakan]').addClass("is-invalid");
							$('.error_makkmk_kertas_kerja_tindakan').html(error);
						}

					});
					$('#btn_save').html(btn_text);                
					$('#btn_save').prop('disabled', false);            
				} else {
					$('#modal_add_kertas_kerja_mesyuarat_krt').modal('hide');
					swal("Maklumat Senarai Kehadiran ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_makkmk').trigger("reset");
					$('#btn_save').html(btn_text);
					$('btn_save').prop('disabled', false);
					$('#senarai_kertas_kerja_table').DataTable().ajax.reload();
				}
			});
		});
	// Deleted Kertas Kerja
		$('body').on('click', '#delete_kertas_kerja_mesyuarat', function () {
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
						url: url_delete_kertas_kerja_mesyuarat +"/" + delete_id,
						success: function (data) {
							$('#senarai_kertas_kerja_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod peranan telah dipadam dari pangkalan data", "success");
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

	/* Senarai Hal-Hal Lain */
		var add_hal_lain_mesyuarat_config = {
			routes: {
				add_hal_lain_mesyuarat_url: "{{ route('rt-sm5.add_hal_lain_mesyuarat') }}",
			}
		};
	// add Hal-Hal lain
		$(document).on('submit', '#form_mahlmk', function(event){    
			event.preventDefault();
			$('#btn_save').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			
			var data = $("#form_mahlmk").serialize();
			var action = $('#add_hal_lain_mesyuarat').val();
			var btn_text;
			if (action == 'add') {
				url = add_hal_lain_mesyuarat_config.routes.add_hal_lain_mesyuarat_url;
				type = "POST";
				btn_text = '<i class="fe fe-plus mr-2"></i> Tambah';
			}

			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=mahlmk_hal_lain_perkara]').removeClass("is-invalid");
				$('[name=mahlmk_hal_lain_tindakan]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'mahlmk_hal_lain_perkara') {
							$('[name=mahlmk_hal_lain_perkara]').addClass("is-invalid");
							$('.error_mahlmk_hal_lain_perkara').html(error);
						}

						if(index == 'mahlmk_hal_lain_tindakan') {
							$('[name=mahlmk_hal_lain_tindakan]').addClass("is-invalid");
							$('.error_mahlmk_hal_lain_tindakan').html(error);
						}

					});
					$('#btn_save').html(btn_text);                
					$('#btn_save').prop('disabled', false);            
				} else {
					$('#modal_add_hal_lain_mesyuarat_krt').modal('hide');
					swal("Maklumat Senarai Kehadiran ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_mahlmk').trigger("reset");
					$('#btn_save').html(btn_text);
					$('btn_save').prop('disabled', false);
					$('#senarai_hal_lain_table').DataTable().ajax.reload();
				}
			});
		});
	// Deleted Hal-Hal Lain
		$('body').on('click', '#delete_hal_lain_mesyuarat', function () {
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
						url: url_delete_hal_lain_mesyuarat +"/" + delete_id,
						success: function (data) {
							$('#senarai_hal_lain_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod peranan telah dipadam dari pangkalan data", "success");
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

	/* Hantar Minit Mesyuarat */
		var add_minit_mesyuarat_rt_1_config = {
			routes: {
				add_minit_mesyuarat_rt_1_url: "{{ route('rt-sm5.post_penyediaan_minit_mesyuarat_rt_1') }}",
			}
		};

		$(document).on('submit', '#form_pmmrt_1', function(event){    
			event.preventDefault();
			$('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_submit').prop('disabled', true);
			var data = $("#form_pmmrt_1").serialize();
			var action = $('#post_penyediaan_minit_mesyuarat_rt_1').val();
			var btn_text;
			if (action == 'edit') {
				url = add_minit_mesyuarat_rt_1_config.routes.add_minit_mesyuarat_rt_1_url;
				type = "POST";
				btn_text = 'Hantar Minit Mesyuarat&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=pmmrt_1_mesyuarat_penyata_kewangan]').removeClass("is-invalid");
				$('[name=pmmrt_1_mesyuarat_penutup]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'pmmrt_1_mesyuarat_penyata_kewangan') {
							$('[name=pmmrt_1_mesyuarat_penyata_kewangan]').addClass("is-invalid");
							$('.error_pmmrt_1_mesyuarat_penyata_kewangan').html(error);
						}

						if(index == 'pmmrt_1_mesyuarat_penutup') {
							$('[name=pmmrt_1_mesyuarat_penutup]').addClass("is-invalid");
							$('.error_pmmrt_1_mesyuarat_penutup').html(error);
						}

					});
					$('#btn_submit').html(btn_text);                
					$('#btn_submit').prop('disabled', false);            
				} else {
					$('#btn_submit').html(btn_text);
					$('#btn_submit').prop('disabled', false); 
					window.location.href = "{{route('rt-sm5.senarai_minit_mesyuarat_rt')}}";
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


<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop