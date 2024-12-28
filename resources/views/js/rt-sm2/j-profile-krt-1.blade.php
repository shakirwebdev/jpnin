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
			url_table_pekerjaan 			= "{{ route('rt-sm2.get_krt_profile_pekerjaan_table','') }}"+"/"+"{{$profile_krt->id}}";
			url_delete_pekerjaan 			= "{{ route('rt-sm2.delete_krt_profile_pekerjaan','') }}";
			url_table_jenis_rumah 			= "{{ route('rt-sm2.get_krt_profile_jenis_rumah_table','') }}"+"/"+"{{$profile_krt->id}}";
			url_delete_jenis_rumah 			= "{{ route('rt-sm2.delete_krt_profile_jenis_rumah','') }}";

		/* Maklumat AM KRT */
			$('#pk_krt_nama').html("{{$profile_krt->krt_nama}}");
			$('#pk_krt_alamat').html("{{$profile_krt->krt_alamat}}");
			$('#pk_tarikh_memohon').html("{{$profile_krt->created_at}}");

		/* Maklumat Asas kawasan */
			$('#pk4_krt_profileID').val("{{$profile_krt->id}}");
			var senarai_pekerjaan_table = $('#senarai_pekerjaan_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_pekerjaan,
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
					"width": "60%", 
					"mRender": function ( value, type, full )  {
						return full.profession_description;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "28%",
					sClass: 'text-center', 
					"mRender": function ( value, type, full )  {
						return full.pekerjaan_peratus+'%';
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_pekerjaan" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			$('#pk5_krt_profileID').val("{{$profile_krt->id}}");
			var senarai_jenis_rumah_table = $('#senarai_jenis_rumah_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_jenis_rumah,
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
					"width": "60%", 
					"mRender": function ( value, type, full )  {
						return full.jenis_rumah_description;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "28%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.jumlah_pintu;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_jenis_rumah" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = '{{route('rt-sm2.profile_krt')}}';
			});

			$('#btn_next').click(function(){
				window.location.href = '{{route('rt-sm2.profile_krt_2')}}';
			});
			
	});

	/* click add pekerjaan */
		$(document).on('submit', '#form_pk4', function(event){
			var info = $('.error_form_pk4');
			event.preventDefault();

			$('#btn_save_pekerjaan').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save_pekerjaan').prop('disabled', true);

			var data = $("#form_pk4").serialize();
			btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			url = "{{ route('rt-sm2.add_profile_krt_pekerjaan') }}";
			type = "POST";

			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {            
				info.hide().find('ul').empty();
				if(response.errors){
					$.each(response.errors, function(index, error){
						info.find('ul').append('<li>'+error+'</li>');
					});
					$('#btn_save_pekerjaan').html(btn_text);                
					$('#btn_save_pekerjaan').prop('disabled', false);
					info.slideDown();
				} else {
					swal("Sosio-Ekonomi Penduduk / Pekerjaan ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_pk4').trigger("reset");
					$('#btn_save_pekerjaan').html(btn_text);
					$('#btn_save_pekerjaan').prop('disabled', false);
					$('#senarai_pekerjaan_table').DataTable().ajax.reload();
				}
			});
		});

	/* click delete pekerjaan */
		$('body').on('click', '#delete_pekerjaan', function () {
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
						url: url_delete_pekerjaan +"/" + delete_id,
						success: function (data) {
							// $('#peranan_form').trigger("reset");
							$('#senarai_pekerjaan_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod Sosio-Ekonomi Penduduk / Pekerjaan telah dipadam dari pangkalan data", "success");
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

	/* click add kategori rumah */
		$(document).on('submit', '#form_pk5', function(event){
			var info = $('.error_form_pk5');
			event.preventDefault();

			$('#btn_save_jenis_rumah').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save_jenis_rumah').prop('disabled', true);

			var data = $("#form_pk5").serialize();
			btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			url = "{{ route('rt-sm2.add_profile_krt_jenis_rumah') }}";
			type = "POST";

			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {            
				info.hide().find('ul').empty();
				if(response.errors){
					$.each(response.errors, function(index, error){
						info.find('ul').append('<li>'+error+'</li>');
					});
					$('#btn_save_jenis_rumah').html(btn_text);                
					$('#btn_save_jenis_rumah').prop('disabled', false);
					info.slideDown();
				} else {
					swal("Jenis/Kategori Rumah ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_pk5').trigger("reset");
					$('#btn_save_jenis_rumah').html(btn_text);
					$('#btn_save_jenis_rumah').prop('disabled', false);
					$('#senarai_jenis_rumah_table').DataTable().ajax.reload();
				}
			});
		});

	/* click delete pekerjaan */
		$('body').on('click', '#delete_jenis_rumah', function () {
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
						url: url_delete_jenis_rumah +"/" + delete_id,
						success: function (data) {
							// $('#peranan_form').trigger("reset");
							$('#senarai_jenis_rumah_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod Jenis/Kategori Rumah telah dipadam dari pangkalan data", "success");
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