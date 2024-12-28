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
		
		/* Maklumat KRT Yang Dimohon */
			$('#kpk_krt_nama').html("{{$profile_krt->krt_nama}}");
			$('#kpk_krt_alamat').html("{{$profile_krt->krt_alamat}}");
			$('#kpk_tarikh_memohon').html("{{$profile_krt->created_at}}");

		/* Maklumat Pemohon */
			$('#kpk_pemohon_name').val("{{$profile_krt->user_fullname}}");
			$('#kpk_pemohon_ic').val("{{$profile_krt->no_ic}}");
			$('#kpk_pemohon_alamat').val("{{$profile_krt->user_address}}");

		/* Maklumat Asas kawasan */
			$('#kpk1_krt_profileID').val("{{$profile_krt->id}}");
			$('#jrf_krt_profileID').val("{{$profile_krt->id}}");

			//my custom script
			url_1 			= "{{ route('rt-sm1.get_pekerjaan_table','') }}"+"/"+$('#kpk1_krt_profileID').val();
			url_2 			= "{{ route('rt-sm1.get_jenis_rumah_table','') }}"+"/"+$('#kpk1_krt_profileID').val();
			url_delete_1 	= "{{ route('rt-sm1.delete_pekerjaan_krt','') }}";
			url_delete_2 	= "{{ route('rt-sm1.delete_jenis_rumah','') }}";
        
			var pekerjaan_table = $('#pekerjaan_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_1,
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
					"mRender": function ( value, type, full )  {
						return full.pekerjaan_peratus;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete-pekerjaan" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			var jenis_rumah_table = $('#jenis_rumah_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_2,
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
					"mRender": function ( value, type, full )  {
						return full.jumlah_pintu;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete-jenis-rumah" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

		/* Maklumat Note Kemaskini */
			$('#kpk_status').val("{{$profile_krt->status}}");
            
            if($('#kpk_status').val() == '5'){
                $("#kpk_perlu_kemaskini").show();
                $('#kpk_status_description').html("{{$profile_krt->status_description}}");
                $('#kpk_disemak_note').html("{{$profile_krt->disemak_note}}");
            }

            if($('#kpk_status').val() == '7'){
                $("#kpk_perlu_kemaskini").show();
                $('#kpk_status_description').html("{{$profile_krt->status_description}}");
                $('#kpk_disahkan_note').html("{{$profile_krt->disahkan_note}}");
            }

			if($('#kpk_status').val() == '8'){
                $("#kpk_perlu_kemaskini").show();
                $('#kpk_status_description').html("{{$profile_krt->status_description}}");
                $('#kpk_diluluskan_note').html("{{$profile_krt->diluluskan_note}}");
            }

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = '{{route('rt-sm1.kemaskini_profil_krt','')}}'+'/'+"{{$profile_krt->id}}";
			});

			$('#btn_next').click(function(){
				window.location.href = '{{route('rt-sm1.kemaskini_profil_krt_2','')}}'+'/'+"{{$profile_krt->id}}";
			});
	});

	/* click add pekerjaan */
		$(document).on('submit', '#pekerjaan_form', function(event){
			var info = $('.error_alert_1');
			event.preventDefault();

			$('#btn-save-pekerjaan').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn-save-pekerjaan').prop('disabled', true);

			var data = $("#pekerjaan_form").serialize();
			btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			url = "{{ route('rt-sm1.post_pekerjaan') }}";
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
					$('#btn-save-pekerjaan').html(btn_text);                
					$('#btn-save-pekerjaan').prop('disabled', false);
					info.slideDown();
				} else {
					swal("Pekerjaan ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#pekerjaan_form').trigger("reset");
					$('#btn-save-pekerjaan').html(btn_text);
					$('#btn-save-pekerjaan').prop('disabled', false);
					$('#pekerjaan_table').DataTable().ajax.reload();
				}
			});
		});

	/* click delete pekerjaan */
		$('body').on('click', '#delete-pekerjaan', function () {
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
						url: url_delete_1 +"/" + delete_id,
						success: function (data) {
							// $('#peranan_form').trigger("reset");
							$('#pekerjaan_table').DataTable().ajax.reload();
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

	/* click add kategori rumah */
		$(document).on('submit', '#jenis_rumah_form', function(event){
			var info = $('.error_alert_2');
			event.preventDefault();

			$('#btn-save-jenis-rumah').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn-save-jenis-rumah').prop('disabled', true);

			var data = $("#jenis_rumah_form").serialize();
			btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			url = "{{ route('rt-sm1.post_jenis_rumah') }}";
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
					$('#btn-save-jenis-rumah').html(btn_text);                
					$('#btn-save-jenis-rumah').prop('disabled', false);
					info.slideDown();
				} else {
					swal("Jenis/Kategori Rumah ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#jenis_rumah_form').trigger("reset");
					$('#btn-save-jenis-rumah').html(btn_text);
					$('#btn-save-jenis-rumah').prop('disabled', false);
					$('#jenis_rumah_table').DataTable().ajax.reload();
				}
			});
		});

	/* click delete pekerjaan */
		$('body').on('click', '#delete-jenis-rumah', function () {
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
						url: url_delete_2 +"/" + delete_id,
						success: function (data) {
							// $('#peranan_form').trigger("reset");
							$('#jenis_rumah_table').DataTable().ajax.reload();
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