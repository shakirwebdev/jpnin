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

        //my custom script
			url 			= "{{ route('rt-sm1.get_kawasan_pertanian_table','') }}"+"/"+$('#kpf_krt_profileID').val();
			url_delete 		= "{{ route('rt-sm1.delete_kawasan_pertanian','') }}";

			var kawasan_pertanian_table = $('#kawasan_pertanian_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url,
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
						return full.pertanian_description;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "30%", 
					"mRender": function ( value, type, full )  {
						return full.kawasan_pertanian_dalam;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "30%", 
					"mRender": function ( value, type, full )  {
						return full.kawasan_pertanian_luar;
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete-kawasan-pertanian" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			$('#kpf_kawasan_pertanian_dalam').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

			$('#kpf_kawasan_pertanian_luar').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
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
    });

	/* click add kawasan pertanian */
		$(document).on('submit', '#kawasan_pertanian_form', function(event){
			var info = $('.error_alert');
			event.preventDefault();

			$('#btn-save-kawasan-pertanian').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn-save-kawasan-pertanian').prop('disabled', true);

			var data = $("#kawasan_pertanian_form").serialize();
			btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			url = "{{ route('rt-sm1.post_kawasan_pertanian') }}";
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
					$('#btn-save-kawasan-pertanian').html(btn_text);                
					$('#btn-save-kawasan-pertanian').prop('disabled', false);
					info.slideDown();
				} else {
					swal("Kawasan Pertanian ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#kawasan_pertanian_form').trigger("reset");
					$('#btn-save-kawasan-pertanian').html(btn_text);
					$('#btn-save-kawasan-pertanian').prop('disabled', false);
					$('#kawasan_pertanian_table').DataTable().ajax.reload();
				}
			});
		});

	/* click delete kawasan pertanian */
		$('body').on('click', '#delete-kawasan-pertanian', function () {
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
						url: url_delete +"/" + delete_id,
						success: function (data) {
							// $('#peranan_form').trigger("reset");
							$('#kawasan_pertanian_table').DataTable().ajax.reload();
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