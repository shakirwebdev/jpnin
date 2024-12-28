@include('js.modal.j-modal-add-binaan-jambatan')
@include('js.modal.j-modal-view-binaan-jambatan')
@include('js.modal.j-modal-add-bagunan-tumpang')
@include('js.modal.j-modal-view-bagunan-tumpang')
@include('js.modal.j-modal-add-bagunan-sewa')
@include('js.modal.j-modal-view-bagunan-sewa')
@include('js.modal.j-modal-add-kabin-sedia-ada')
@include('js.modal.j-modal-view-kabin-sedia-ada')
@include('js.modal.j-modal-add-cadangan-pembinaan-prt')
@include('js.modal.j-modal-view-cadangan-pembinaan-prt')
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
    
	$(document).ready( function () {

		//my custom script
			url_table_senarai_binaan 			= "{{ route('rt-sm2.get_profile_krt_senarai_binaan','') }}"+"/"+"{{$profile_krt->id}}";
			url_delete_binaan 					= "{{ route('rt-sm2.delete_profile_krt_binaan','') }}";
			url_table_bagunan_tumpang			= "{{ route('rt-sm2.get_profile_krt_bagunan_tumpang','') }}"+"/"+"{{$profile_krt->id}}";
			url_delete_bagunan_tumpang 			= "{{ route('rt-sm2.delete_get_profile_bagunan_tumpang','') }}";
			url_table_bagunan_sewa				= "{{ route('rt-sm2.get_profile_krt_bagunan_sewa','') }}"+"/"+"{{$profile_krt->id}}";
			url_delete_bagunan_sewa 			= "{{ route('rt-sm2.delete_get_profile_bagunan_sewa','') }}";
			url_table_senarai_kabin 			= "{{ route('rt-sm2.get_profile_krt_senarai_kabin','') }}"+"/"+"{{$profile_krt->id}}";
			url_delete_kabin 					= "{{ route('rt-sm2.delete_profile_krt_kabin','') }}";
			url_table_cadangan_pembinaan 		= "{{ route('rt-sm2.get_profile_krt_cadangan_pembinaan','') }}"+"/"+"{{$profile_krt->id}}";
			url_delete_cadangan_pembinaan_prt   = "{{ route('rt-sm2.delete_cadangan_pembinaan_prt','') }}";

		/* Maklumat AM KRT */
			$('#pk_krt_nama').html("{{$profile_krt->krt_nama}}");
			$('#pk_krt_alamat').html("{{$profile_krt->krt_alamat}}");
			$('#pk_tarikh_memohon').html("{{$profile_krt->created_at}}");

		/* Maklumat Asas kawasan */
			
			var senarai_binaan_jambatan_table = $('#senarai_binaan_jambatan_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_senarai_binaan,
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
					"width": "20%", 
					"mRender": function ( value, type, full )  {
						return full.jenis_premis_description;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "20%", 
					"mRender": function ( value, type, full )  {
						return full.binaan_alamat;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "20%", 
					"mRender": function ( value, type, full )  {
						return full.binaan_isu;
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "6%", 
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_binaan_jambatan(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
						button_b = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_binaan" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a + "|" + button_b;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			var senarai_bagunan_tumpang_table = $('#senarai_bagunan_tumpang_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_bagunan_tumpang,
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
					"width": "38%", 
					"mRender": function ( value, type, full )  {
						return full.jenis_premis_description;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "50%", 
					"mRender": function ( value, type, full )  {
						return full.tumpang_alamat;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "6%", 
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_bagunan_tumpang(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
						button_b = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_bagunan_tumpang" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a + "|" + button_b;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			var senarai_bagunan_sewa_table = $('#senarai_bagunan_sewa_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_bagunan_sewa,
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
					"width": "38%", 
					"mRender": function ( value, type, full )  {
						return full.jenis_premis_description;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "50%", 
					"mRender": function ( value, type, full )  {
						return full.sewa_alamat;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "6%", 
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_bagunan_sewa(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
						button_b = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_bagunan_sewa" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a + "|" + button_b;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			var senarai_kabin_table = $('#senarai_kabin_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_senarai_kabin,
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
					"width": "20%", 
					"mRender": function ( value, type, full )  {
						return full.jenis_kabin;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "20%", 
					"mRender": function ( value, type, full )  {
						return full.kabin_alamat;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "20%", 
					"mRender": function ( value, type, full )  {
						return full.kabin_kos;
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "6%", 
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_kabin(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
						button_b = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_kabin" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a + "|" + button_b;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			var senarai_cadangan_pembinaan_table = $('#senarai_cadangan_pembinaan_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_cadangan_pembinaan,
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
					"width": "20%", 
					"mRender": function ( value, type, full )  {
						jenis_premis = '';
						if (full.prt_jenis_premis == '1') {
							jenis_premis = 'Kompleks Perpaduan';
						} else if (full.prt_jenis_premis == '2') {
							jenis_premis = 'Pusat Rukun Tetangga';
						}
						return jenis_premis;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "20%", 
					"mRender": function ( value, type, full )  {
						return full.prt_status_tanah_terkini;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "20%", 
					"mRender": function ( value, type, full )  {
						return full.prt_cadangan_tahun;
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "6%", 
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_cadangan_pembinaan_prt(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
						button_b = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_cadangan_pembinaan_prt" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a + "|" + button_b;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = '{{route('rt-sm2.profile_krt_5')}}';
			});

			$('#btn_next').click(function(){
				window.location.href = '{{route('rt-sm2.profile_krt_7')}}';
			});
	});

	/* Binaan Jabatan */
		//add Binaan Jabatan
		//my custom script
		var add_binaan_jambatan_config = {
			routes: {
				add_binaan_jambatan_url: "{{ route('rt-sm2.add_profile_krt_binaan_jambatan') }}",
			}
		};

		$(document).on('submit', '#form_mabj', function(event){    
			event.preventDefault();
			$('#btn_save').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save').prop('disabled', true);
			var data = $("#form_mabj").serialize();
			var action = $('#add_binaan_jambatan').val();
			var btn_text;
			if (action == 'add') {
				url = add_binaan_jambatan_config.routes.add_binaan_jambatan_url;
				type = "POST";
				btn_text = '<i class="fe fe-plus mr-2"></i> Tambah';
			}

			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=mabj_binaan_jenis_premis_id]').removeClass("is-invalid");
				$('[name=mabj_binaan_alamat]').removeClass("is-invalid");
				$('[name=mabj_status_tanah_id]').removeClass("is-invalid");
				$('[name=mabj_binaan_kos]').removeClass("is-invalid");
				$('[name=mabj_binaan_keluasan_tanah]').removeClass("is-invalid");
				$('[name=mabj_binaan_keluasan_bagunan]').removeClass("is-invalid");
				$('[name=mabj_binaan_tarikh_mula_bina]').removeClass("is-invalid");
				$('[name=mabj_binaan_isu]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'mabj_binaan_jenis_premis_id') {
							$('[name=mabj_binaan_jenis_premis_id]').addClass("is-invalid");
							$('.error_mabj_binaan_jenis_premis_id').html(error);
						}

						if(index == 'mabj_binaan_alamat') {
							$('[name=mabj_binaan_alamat]').addClass("is-invalid");
							$('.error_mabj_binaan_alamat').html(error);
						}

						if(index == 'mabj_status_tanah_id') {
							$('[name=mabj_status_tanah_id]').addClass("is-invalid");
							$('.error_mabj_status_tanah_id').html(error);
						}

						if(index == 'mabj_binaan_kos') {
							$('[name=mabj_binaan_kos]').addClass("is-invalid");
							$('.error_mabj_binaan_kos').html(error);
						}

						if(index == 'mabj_binaan_keluasan_tanah') {
							$('[name=mabj_binaan_keluasan_tanah]').addClass("is-invalid");
							$('.error_mabj_binaan_keluasan_tanah').html(error);
						}
						
						if(index == 'mabj_binaan_keluasan_bagunan') {
							$('[name=mabj_binaan_keluasan_bagunan]').addClass("is-invalid");
							$('.error_mabj_binaan_keluasan_bagunan').html(error);
						}

						if(index == 'mabj_binaan_tarikh_mula_bina') {
							$('[name=mabj_binaan_tarikh_mula_bina]').addClass("is-invalid");
							$('.error_mabj_binaan_tarikh_mula_bina').html(error);
						}

						if(index == 'mabj_binaan_isu') {
							$('[name=mabj_binaan_isu]').addClass("is-invalid");
							$('.error_mabj_binaan_isu').html(error);
						}
					});
					$('#btn_save').html(btn_text);                
					$('#btn_save').prop('disabled', false);            
				} else {
					$('#modal_add_binaan_jambatan').modal('hide');
					swal("Maklumat Bangunan Binaan Jabatan Sedia Ada ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_mabj').trigger("reset");
					$('#btn_save').html(btn_text);                
					$('#btn_save').prop('disabled', false);
					$('#senarai_binaan_jambatan_table').DataTable().ajax.reload();
				}
			});
		});

		// click delete Binaan Jabatan
		$('body').on('click', '#delete_binaan', function () {
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
						url: url_delete_binaan +"/" + delete_id,
						success: function (data) {
							$('#senarai_binaan_jambatan_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod Status Bangunan Binaan Jabatan Sedia Ada telah dipadam dari pangkalan data", "success");
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

	/* Bangunan Tumpang */
		//add Bangunan Tumpang
		//my custom script
		var add_bagunan_tumpang_config = {
			routes: {
				add_bagunan_tumpang_url: "{{ route('rt-sm2.add_profile_krt_bagunan_tumpang') }}",
			}
		};

		$(document).on('submit', '#form_mabt', function(event){    
			event.preventDefault();
			$('#btn_save').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save').prop('disabled', true);
			var data = $("#form_mabt").serialize();
			var action = $('#add_bagunan_tumpang').val();
			var btn_text;
			if (action == 'add') {
				url = add_bagunan_tumpang_config.routes.add_bagunan_tumpang_url;
				type = "POST";
				btn_text = '<i class="fe fe-plus mr-2"></i> Tambah';
			}

			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=mabt_tumpang_jenis_premis_id]').removeClass("is-invalid");
				$('[name=mabt_tumpang_alamat]').removeClass("is-invalid");
				$('[name=mabt_tumpang_status_tanah_id]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'mabt_tumpang_jenis_premis_id') {
							$('[name=mabt_tumpang_jenis_premis_id]').addClass("is-invalid");
							$('.error_mabt_tumpang_jenis_premis_id').html(error);
						}

						if(index == 'mabt_tumpang_alamat') {
							$('[name=mabt_tumpang_alamat]').addClass("is-invalid");
							$('.error_mabt_tumpang_alamat').html(error);
						}

						if(index == 'mabt_tumpang_status_tanah_id') {
							$('[name=mabt_tumpang_status_tanah_id]').addClass("is-invalid");
							$('.error_mabt_tumpang_status_tanah_id').html(error);
						}

					});
					$('#btn_save').html(btn_text);                
					$('#btn_save').prop('disabled', false);            
				} else {
					$('#form_mabt').trigger("reset");
					$('#modal_add_bagunan_tumpang').modal('hide');
					$('#senarai_bagunan_tumpang_table').DataTable().ajax.reload();
				}
			});
		});

		// click delete bagunan tumpang
		$('body').on('click', '#delete_bagunan_tumpang', function () {
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
						url: url_delete_bagunan_tumpang +"/" + delete_id,
						success: function (data) {
							$('#senarai_bagunan_tumpang_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod Status Bangunan Tumpang Sedia Ada telah dipadam dari pangkalan data", "success");
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

	/* Bangunan Sewa */
		//add Bangunan Sewa
		//my custom script
		var add_bagunan_sewa_config = {
			routes: {
				add_bagunan_sewa_url: "{{ route('rt-sm2.add_profile_krt_bagunan_sewa') }}",
			}
		};

		$(document).on('submit', '#form_mabs', function(event){    
			event.preventDefault();
			$('#btn_save').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save').prop('disabled', true);
			var data = $("#form_mabs").serialize();
			var action = $('#add_bagunan_sewa').val();
			var btn_text;
			if (action == 'add') {
				url = add_bagunan_sewa_config.routes.add_bagunan_sewa_url;
				type = "POST";
				btn_text = '<i class="fe fe-plus mr-2"></i> Tambah';
			}

			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=mabs_jenis_premis_id]').removeClass("is-invalid");
				$('[name=mabs_sewa_alamat]').removeClass("is-invalid");
				$('[name=mabs_sewa_isu]').removeClass("is-invalid");
				$('[name=mabs_sewa_bayaran]').removeClass("is-invalid");
				
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'mabs_jenis_premis_id') {
							$('[name=mabs_jenis_premis_id]').addClass("is-invalid");
							$('.error_mabs_jenis_premis_id').html(error);
						}

						if(index == 'mabs_sewa_alamat') {
							$('[name=mabs_sewa_alamat]').addClass("is-invalid");
							$('.error_mabs_sewa_alamat').html(error);
						}

						if(index == 'mabs_sewa_isu') {
							$('[name=mabs_sewa_isu]').addClass("is-invalid");
							$('.error_mabs_sewa_isu').html(error);
						}

						if(index == 'mabs_sewa_bayaran') {
							$('[name=mabs_sewa_bayaran]').addClass("is-invalid");
							$('.error_mabs_sewa_bayaran').html(error);
						}

					});
					$('#btn_save').html(btn_text);                
					$('#btn_save').prop('disabled', false);            
				} else {
					$('#form_mabs').trigger("reset");
					$('#modal_add_bagunan_sewa').modal('hide');
					$('#senarai_bagunan_sewa_table').DataTable().ajax.reload();
				}
			});
		});

		// click delete bangunan tumpang
		$('body').on('click', '#delete_bagunan_sewa', function () {
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
						url: url_delete_bagunan_sewa +"/" + delete_id,
						success: function (data) {
							$('#senarai_bagunan_sewa_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod Status Bangunan Sewa Sedia Ada telah dipadam dari pangkalan data", "success");
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

	/* Status Kabin Sedia Ada */
		//add Kabin
		//my custom script
		var add_kabin_config = {
			routes: {
				add_kabin_url: "{{ route('rt-sm2.add_profile_krt_kabin') }}",
			}
		};

		$(document).on('submit', '#form_maksa', function(event){    
			event.preventDefault();
			$('#btn_save').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save').prop('disabled', true);
			var data = $("#form_maksa").serialize();
			var action = $('#add_kabin').val();
			var btn_text;
			if (action == 'add') {
				url = add_kabin_config.routes.add_kabin_url;
				type = "POST";
				btn_text = '<i class="fe fe-plus mr-2"></i> Tambah';
			}

			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=maksa_kabin_jenis]').removeClass("is-invalid");
				$('[name=maksa_kabin_sumbangan_lain]').removeClass("is-invalid");
				$('[name=maksa_kabin_alamat]').removeClass("is-invalid");
				$('[name=maksa_kabin_status_tanah_id]').removeClass("is-invalid");
				$('[name=maksa_kabin_tarikh_bina]').removeClass("is-invalid");
				$('[name=maksa_kabin_kos]').removeClass("is-invalid");
				$('[name=maksa_kabin_pengguna_rt]').removeClass("is-invalid");
				$('[name=maksa_kabin_pengguna_srs]').removeClass("is-invalid");
				$('[name=maksa_kabin_pengguna_tabika]').removeClass("is-invalid");
				$('[name=maksa_kabin_pengguna_taska]').removeClass("is-invalid");
				$('[name=maksa_kabin_isu]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'maksa_kabin_jenis') {
							$('[name=maksa_kabin_jenis]').addClass("is-invalid");
							$('.error_maksa_kabin_jenis').html(error);
						}

						if(index == 'maksa_kabin_alamat') {
							$('[name=maksa_kabin_alamat]').addClass("is-invalid");
							$('.error_maksa_kabin_alamat').html(error);
						}

						if(index == 'maksa_kabin_status_tanah_id') {
							$('[name=maksa_kabin_status_tanah_id]').addClass("is-invalid");
							$('.error_maksa_kabin_status_tanah_id').html(error);
						}

						if(index == 'maksa_kabin_tarikh_bina') {
							$('[name=maksa_kabin_tarikh_bina]').addClass("is-invalid");
							$('.error_maksa_kabin_tarikh_bina').html(error);
						}

						if(index == 'maksa_kabin_kos') {
							$('[name=maksa_kabin_kos]').addClass("is-invalid");
							$('.error_maksa_kabin_kos').html(error);
						}
						
						if(index == 'maksa_kabin_isu') {
							$('[name=maksa_kabin_isu]').addClass("is-invalid");
							$('.error_maksa_kabin_isu').html(error);
						}

					});
					$('#btn_save').html(btn_text);                
					$('#btn_save').prop('disabled', false);            
				} else {
					$('#modal_add_kabin_sedia_ada').modal('hide');
					swal("Maklumat Kabin Sedia Ada ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_mabj').trigger("reset");
					$('#senarai_kabin_table').DataTable().ajax.reload();
				}
			});
		});

		// click delete kabin sedia ada
		$('body').on('click', '#delete_kabin', function () {
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
						url: url_delete_kabin +"/" + delete_id,
						success: function (data) {
							$('#senarai_kabin_table').DataTable().ajax.reload();
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

	/* Status Cadangan Pembinaan PRT 1 */
		//add cadangan pembinaan
		//my custom script
		var add_cadangan_pembinaan_config = {
			routes: {
				add_cadangan_pembinaan_url: "{{ route('rt-sm2.add_profile_krt_cadangan_pembinaan') }}",
			}
		};

		$(document).on('submit', '#form_macpp', function(event){    
			event.preventDefault();
			$('#btn_save').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save').prop('disabled', true);
			var data = $("#form_macpp").serialize();
			var action = $('#add_cadangan_pembinaan_prt').val();
			var btn_text;
			if (action == 'add') {
				url = add_cadangan_pembinaan_config.routes.add_cadangan_pembinaan_url;
				type = "POST";
				btn_text = '<i class="fe fe-plus mr-2"></i> Tambah';
			}

			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=macpp_prt_jenis_premis]').removeClass("is-invalid");
				$('[name=macpp_prt_status_tanah_terkini]').removeClass("is-invalid");
				$('[name=macpp_prt_keluasan]').removeClass("is-invalid");
				$('[name=macpp_prt_status_kelulusan_tanah_kabin]').removeClass("is-invalid");
				$('[name=macpp_prt_cadangan_tahun]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'macpp_prt_jenis_premis') {
							$('[name=macpp_prt_jenis_premis]').addClass("is-invalid");
							$('.error_macpp_prt_jenis_premis').html(error);
						}

						if(index == 'macpp_prt_status_tanah_terkini') {
							$('[name=macpp_prt_status_tanah_terkini]').addClass("is-invalid");
							$('.error_macpp_prt_status_tanah_terkini').html(error);
						}

						if(index == 'macpp_prt_keluasan') {
							$('[name=macpp_prt_keluasan]').addClass("is-invalid");
							$('.error_macpp_prt_keluasan').html(error);
						}

						if(index == 'macpp_prt_status_kelulusan_tanah_kabin') {
							$('[name=macpp_prt_status_kelulusan_tanah_kabin]').addClass("is-invalid");
							$('.error_macpp_prt_status_kelulusan_tanah_kabin').html(error);
						}
						
						if(index == 'macpp_prt_cadangan_tahun') {
							$('[name=macpp_prt_cadangan_tahun]').addClass("is-invalid");
							$('.error_macpp_prt_cadangan_tahun').html(error);
						}

					});
					$('#btn_save').html(btn_text);                
					$('#btn_save').prop('disabled', false);            
				} else {
					$('#modal_add_cadangan_pembinaan_prt').modal('hide');
					swal("Maklumat Cadangan Pembinaan PRT 1 Sedia Ada ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_macpp').trigger("reset");
					$('#senarai_cadangan_pembinaan_table').DataTable().ajax.reload();
				}
			});
		});

		// click delete kabin sedia ada
		$('body').on('click', '#delete_cadangan_pembinaan_prt', function () {
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
						url: url_delete_cadangan_pembinaan_prt +"/" + delete_id,
						success: function (data) {
							$('#senarai_cadangan_pembinaan_table').DataTable().ajax.reload();
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

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop