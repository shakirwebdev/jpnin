@include('js.modal.j-modal-add-bilangan-terlibat')
@include('js.modal.j-modal-add-bilangan-cedera')
@include('js.modal.j-modal-add-bilangan-cedera-parah')
@include('js.modal.j-modal-add-bilangan-kematian')
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
			url_table_bilangan_terlibat 		= "{{ route('rt-sm21.get_ikes_bilangan_terlibat','') }}"+"/"+"{{$ikes->id}}";
			url_delete_bilangan_terlibat 		= "{{ route('rt-sm21.delete_ikes_bilangan_terlibat','') }}";
			url_table_bilangan_cedera 			= "{{ route('rt-sm21.get_ikes_bilangan_cedera','') }}"+"/"+"{{$ikes->id}}";
			url_delete_bilangan_cedera_ringan 	= "{{ route('rt-sm21.delete_ikes_bilangan_cedera_ringan','') }}";
			url_table_bilangan_cedera_parah 	= "{{ route('rt-sm21.get_ikes_bilangan_cedera_parah','') }}"+"/"+"{{$ikes->id}}";
			url_delete_bilangan_cedera_parah 	= "{{ route('rt-sm21.delete_ikes_bilangan_cedera_parah','') }}";
			url_table_bilangan_kematian 		= "{{ route('rt-sm21.get_ikes_bilangan_kematian','') }}"+"/"+"{{$ikes->id}}";
			url_delete_bilangan_kematian 		= "{{ route('rt-sm21.delete_ikes_bilangan_kematian','') }}";

		/* Maklumat Kes Dalam Krt */
			if("{{$ikes->hasRT}}" == 1){
				$('#pipp4_hasRT').attr("checked", "checked");
			}
			$('#pipp4_negeri_id').val("{{$ikes->krt_state_id}}");
			$('#pipp4_daerah_id').val("{{$ikes->krt_daerah_id}}");
			$('#pipp4_krt_profile_id').val("{{$ikes->krt_profile_id}}");

		/* Maklumat Pemohon */
			$('#pipp4_user_fullname').val("{{$ikes->nama_permohon}}");
			$('#pipp4_user_no_ic').val("{{$ikes->ic_pemohon}}");
			$('#pipp4_user_no_phone').val("{{$ikes->phone_pemohon}}");
			$('#pipp4_dihantar_alamat').val("{{$ikes->dihantar_alamat}}");
		
		/* Maklumat Kes Kejadian */
			$('#pipp4_ikes_bil_terlibat').val("{{$ikes->ikes_bil_terlibat}}");
			$('#pipp4_status_etnik_id').val("{{$ikes->status_etnik_id}}");
			$('#pipp4_status_warganegara_id').val("{{$ikes->status_warganegara_id}}");

			var senarai_jumlah_terlibat_table = $('#senarai_jumlah_terlibat_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_bilangan_terlibat,
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
						return full.kaum_description;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "28%", 
					"mRender": function ( value, type, full )  {
						return full.jumlah_bilangan_terlibat;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_bilangan_terlibat" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});
        
			var senarai_jumlah_cedera_ringan_table = $('#senarai_jumlah_cedera_ringan_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_bilangan_cedera,
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
						return full.kaum_description;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "28%", 
					"mRender": function ( value, type, full )  {
						return full.jumlah_cedera_ringan;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_bilangan_cedera_ringan" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			var senarai_jumlah_cedera_parah_table = $('#senarai_jumlah_cedera_parah_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_bilangan_cedera_parah,
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
						return full.kaum_description;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "28%", 
					"mRender": function ( value, type, full )  {
						return full.jumlah_cedera_parah;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_bilangan_cedera_parah" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			var senarai_jumlah_kematian_table = $('#senarai_jumlah_kematian_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_bilangan_kematian,
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
						return full.kaum_description;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "28%", 
					"mRender": function ( value, type, full )  {
						return full.jumlah_kematian;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_bilangan_kematian" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			$('#pipp4_ikes_bil_tangkapan').val("{{$ikes->ikes_bil_tangkapan}}");

			$('#pipp5_ikes_id').val("{{$ikes->id}}");

		/* Maklumat Note Kemaskini */
			$('#pipp4_status').val("{{$ikes->status}}");

			if($('#pipp4_status').val() == '11'){
				$("#pipp4_perlu_kemaskini").show();
				$('#pipp4_status_description').html("{{$ikes->status_description}}");
				$('#pipp4_disemak_note').html("{{$ikes->disemak_note}}");
			}

			if($('#pipp4_status').val() == '12'){
				$("#pipp4_perlu_kemaskini").show();
				$('#pipp4_status_description').html("{{$ikes->status_description}}");
				$('#pipp4_disahkan_note').html("{{$ikes->disahkan_note}}");
			}

			if($('#pipp4_status').val() == '15'){
				$("#pipp4_perlu_kemaskini").show();
				$('#pipp4_status_description').html("{{$ikes->status_description}}");
				$('#pipp4_disahkan_note').html("{{$ikes->disahkan_note}}");
			}

		/* Button */
        	$('#btn_back').click(function(){
				window.location.href = "{{route('rt-sm21.permohonan_ikes_bpp','')}}"+"/"+"{{$ikes->id}}";
			});

	});

	// add Bilangan Yang Terlibat Mengikut Etnik
		var add_bilangan_terlibat_config = {
			routes: {
				add_bilangan_terlibat_url: "{{ route('rt-sm21.add_add_bilangan_terlibat') }}",
			}
		};

		$(document).on('submit', '#form_mabt', function(event){    
			event.preventDefault();
			$('#btn_add').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_add').prop('disabled', true);
			var data = $("#form_mabt").serialize();
			var action = $('#add_bilangan_terlibat').val();
			var btn_text;
			if (action == 'add') {
				url = add_bilangan_terlibat_config.routes.add_bilangan_terlibat_url;
				type = "POST";
				btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			}
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=mabt_kaum_id]').removeClass("is-invalid");
				$('[name=mabt_jumlah_terlibat]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'mabt_kaum_id') {
							$('[name=mabt_kaum_id]').addClass("is-invalid");
							$('.error_mabt_kaum_id').html(error);
						}

						if(index == 'mabt_jumlah_terlibat') {
							$('[name=mabt_jumlah_terlibat]').addClass("is-invalid");
							$('.error_mabt_jumlah_terlibat').html(error);
						}

					});
					$('#btn_add').html(btn_text);                
					$('#btn_add').prop('disabled', false);            
				} else {
					$('#modal_add_bilangan_terlibat').modal('hide');
					swal("Maklumat Bilangan Yang Terlibat Mengikut Etnik ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_mabt').trigger("reset");
					$('#senarai_jumlah_terlibat_table').DataTable().ajax.reload();
					$('#btn_add').html(btn_text);                
					$('#btn_add').prop('disabled', false); 
				}
			});
		});

	// delete Bilangan Yang Terlibat Mengikut Etnik
		$('body').on('click', '#delete_bilangan_terlibat', function () {
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
						url: url_delete_bilangan_terlibat +"/" + delete_id,
						success: function (data) {
							// $('#peranan_form').trigger("reset");
							$('#senarai_jumlah_terlibat_table').DataTable().ajax.reload();
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

	// add Bilangan Cedera Ringan Mengikut Etnik
		var add_bilangan_cedera_config = {
			routes: {
				add_bilangan_cedera_url: "{{ route('rt-sm21.add_bilangan_cedera') }}",
			}
		};

		$(document).on('submit', '#form_mabc', function(event){    
			event.preventDefault();
			$('#btn_add').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_add').prop('disabled', true);
			var data = $("#form_mabc").serialize();
			var action = $('#add_bilangan_cedera').val();
			var btn_text;
			if (action == 'add') {
				url = add_bilangan_cedera_config.routes.add_bilangan_cedera_url;
				type = "POST";
				btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			}
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=mabc_kaum_id]').removeClass("is-invalid");
				$('[name=mabc_jumlah_cedera_ringan]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'mabc_kaum_id') {
							$('[name=mabc_kaum_id]').addClass("is-invalid");
							$('.error_mabc_kaum_id').html(error);
						}

						if(index == 'mabc_jumlah_cedera_ringan') {
							$('[name=mabc_jumlah_cedera_ringan]').addClass("is-invalid");
							$('.error_mabc_jumlah_cedera_ringan').html(error);
						}

					});
					$('#btn_add').html(btn_text);                
					$('#btn_add').prop('disabled', false);            
				} else {
					$('#modal_add_bilangan_cedera').modal('hide');
					swal("Maklumat Bilangan Cedera Ringan Mengikut Etnik ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_mabc').trigger("reset");
					$('#senarai_jumlah_cedera_ringan_table').DataTable().ajax.reload();
					$('#btn_add').html(btn_text);                
					$('#btn_add').prop('disabled', false); 
				}
			});
		});

	// delete Bilangan Cedera Ringan Mengikut Etnik
		$('body').on('click', '#delete_bilangan_cedera_ringan', function () {
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
						url: url_delete_bilangan_cedera_ringan +"/" + delete_id,
						success: function (data) {
							// $('#peranan_form').trigger("reset");
							$('#senarai_jumlah_cedera_ringan_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod Bilangan Cedera Ringan Mengikut Etnik telah dipadam dari pangkalan data", "success");
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

	// add Bilangan Cedera Parah Mengikut Etnik
		var add_bilangan_cedera_parah_config = {
			routes: {
				add_bilangan_cedera_parah_url: "{{ route('rt-sm21.add_bilangan_cedera_parah') }}",
			}
		};

		$(document).on('submit', '#form_mabcp', function(event){    
			event.preventDefault();
			$('#btn_add').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_add').prop('disabled', true);
			var data = $("#form_mabcp").serialize();
			var action = $('#add_bilangan_cedera_parah').val();
			var btn_text;
			if (action == 'add') {
				url = add_bilangan_cedera_parah_config.routes.add_bilangan_cedera_parah_url;
				type = "POST";
				btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			}
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=mabcp_kaum_id]').removeClass("is-invalid");
				$('[name=mabcp_jumlah_cedera_parah]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'mabcp_kaum_id') {
							$('[name=mabcp_kaum_id]').addClass("is-invalid");
							$('.error_mabcp_kaum_id').html(error);
						}

						if(index == 'mabcp_jumlah_cedera_parah') {
							$('[name=mabcp_jumlah_cedera_parah]').addClass("is-invalid");
							$('.error_mabcp_jumlah_cedera_parah').html(error);
						}

					});
					$('#btn_add').html(btn_text);                
					$('#btn_add').prop('disabled', false);            
				} else {
					$('#modal_add_bilangan_cedera_parah').modal('hide');
					swal("Maklumat Bilangan Cedera Parah Mengikut Etnik ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_mabcp').trigger("reset");
					$('#senarai_jumlah_cedera_parah_table').DataTable().ajax.reload();
					$('#btn_add').html(btn_text);                
					$('#btn_add').prop('disabled', false); 
				}
			});
		});

	// delete Bilangan Cedera Parah Mengikut Etnik
		$('body').on('click', '#delete_bilangan_cedera_parah', function () {
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
						url: url_delete_bilangan_cedera_parah +"/" + delete_id,
						success: function (data) {
							// $('#peranan_form').trigger("reset");
							$('#senarai_jumlah_cedera_parah_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod Bilangan Cedera Parah Mengikut Etnik telah dipadam dari pangkalan data", "success");
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

	// add Bilangan Kematian Mengikut Etnik
		var add_bilangan_kematian_config = {
			routes: {
				add_bilangan_kematian_url: "{{ route('rt-sm21.add_bilangan_kematian') }}",
			}
		};

		$(document).on('submit', '#form_mabk', function(event){    
			event.preventDefault();
			$('#btn_add').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_add').prop('disabled', true);
			var data = $("#form_mabk").serialize();
			var action = $('#add_bilangan_kematian').val();
			var btn_text;
			if (action == 'add') {
				url = add_bilangan_kematian_config.routes.add_bilangan_kematian_url;
				type = "POST";
				btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			}
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=mabk_kaum_id]').removeClass("is-invalid");
				$('[name=mabk_jumlah_kematian]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'mabk_kaum_id') {
							$('[name=mabk_kaum_id]').addClass("is-invalid");
							$('.error_mabk_kaum_id').html(error);
						}

						if(index == 'mabk_jumlah_kematian') {
							$('[name=mabk_jumlah_kematian]').addClass("is-invalid");
							$('.error_mabk_jumlah_kematian').html(error);
						}

					});
					$('#btn_add').html(btn_text);                
					$('#btn_add').prop('disabled', false);            
				} else {
					$('#modal_add_bilangan_kematian').modal('hide');
					swal("Maklumat Bilangan Kematian Mengikut Etnik ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_mabk').trigger("reset");
					$('#senarai_jumlah_kematian_table').DataTable().ajax.reload();
					$('#btn_add').html(btn_text);                
					$('#btn_add').prop('disabled', false); 
				}
			});
		});

	// delete Bilangan Kematian Mengikut Etnik
		$('body').on('click', '#delete_bilangan_kematian', function () {
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
						url: url_delete_bilangan_kematian +"/" + delete_id,
						success: function (data) {
							// $('#peranan_form').trigger("reset");
							$('#senarai_jumlah_kematian_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod Bilangan Kematian Mengikut Etnik telah dipadam dari pangkalan data", "success");
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

	/* click btn next */
		//my custom script
		var permohonan_ikes_bpp_2_config = {
			routes: {
				permohonan_ikes_bpp_2_url: "{{ route('rt-sm21.post_permohonan_ikes_bpp_2') }}",
			}
		};

		$(document).on('submit', '#form_pipp5', function(event){    
			event.preventDefault();
			$('#btn_next').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_next').prop('disabled', true);
			var data   = $("#form_pipp4, #form_pipp5").serialize();
			var action = $('#post_permohonan_ikes_bpp_2').val();
			var btn_text;
			if (action == 'edit') {
				url = permohonan_ikes_bpp_2_config.routes.permohonan_ikes_bpp_2_url;
				type = "POST";
				btn_text = 'Seterusnya &nbsp;<i class="dropdown-icon fe fe-arrow-right"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=pipp4_ikes_bil_terlibat]').removeClass("is-invalid");
				$('[name=pipp4_status_etnik_id]').removeClass("is-invalid");
				$('[name=pipp4_status_warganegara_id]').removeClass("is-invalid");
				$('[name=pipp4_ikes_bil_tangkapan]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'pipp4_ikes_bil_terlibat') {
							$('[name=pipp4_ikes_bil_terlibat]').addClass("is-invalid");
							$('.error_pipp4_ikes_bil_terlibat').html(error);
						}

						if(index == 'pipp4_status_etnik_id') {
							$('[name=pipp4_status_etnik_id]').addClass("is-invalid");
							$('.error_pipp4_status_etnik_id').html(error);
						}

						if(index == 'pipp4_status_warganegara_id') {
							$('[name=pipp4_status_warganegara_id]').addClass("is-invalid");
							$('.error_pipp4_status_warganegara_id').html(error);
						}

						if(index == 'pipp4_ikes_bil_tangkapan') {
							$('[name=pipp4_ikes_bil_tangkapan]').addClass("is-invalid");
							$('.error_pipp4_ikes_bil_tangkapan').html(error);
						}

					});
					$('#btn_next').html(btn_text);                
					$('#btn_next').prop('disabled', false);            
				} else {
					$('#btn_next').html(btn_text);
					$('#btn_next').prop('disabled', false); 
					window.location.href = "{{route('rt-sm21.permohonan_ikes_bpp_2','')}}"+"/"+"{{$ikes->id}}";
				}
			});
		});
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop