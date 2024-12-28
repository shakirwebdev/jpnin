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
			url_table_peta_kawasan 		= "{{ route('rt-sm2.get_profile_krt_peta_kawasan_table','') }}"+"/"+"{{$profile_krt->id}}";
			url_delete_peta_kawasan 	= "{{ route('rt-sm2.delete_profile_krt_peta_kawasan','') }}";

		/* Maklumat AM KRT */
			$('#pk_krt_nama').html("{{$profile_krt->krt_nama}}");
			$('#pk_krt_alamat').html("{{$profile_krt->krt_alamat}}");
			$('#pk_tarikh_memohon').html("{{$profile_krt->created_at}}");

		/* Maklumat Asas kawasan */
			$('#pk11_krt_profile_id').val("{{$profile_krt->id}}");
			var senarai_peta_kawasan_table = $('#senarai_peta_kawasan_table').DataTable( {
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
						button_b = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_peta_kawasan" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a + '|' + button_b;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = '{{route('rt-sm2.profile_krt_6')}}';
			});

			$('#btn_next').click(function(){
				window.location.href = '{{route('rt-sm2.profile_krt_8')}}';
			});

	});

	/* click add peta kawasan */
		$(document).on('submit', '#form_pk11', function(event){
			var info = $('.error_form_pk11');
			event.preventDefault();

			var form_data = new FormData();
			form_data.append("pk11_file_title", $("#pk11_file_title").val() );
			form_data.append("pk11_file_catatan", $("#pk11_file_catatan").val() );
			form_data.append("pk11_file_peta",  $("#pk11_file_peta")[0].files[0]);
			form_data.append("pk11_krt_profile_id", $("#pk11_krt_profile_id").val() );
			form_data.append("add_profile_krt_peta_kawasan", "add" );
			console.log(form_data);

			$('#btn_save_peta_kawasan').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save_peta_kawasan').prop('disabled', true);

			btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			url = "{{ route('rt-sm2.add_profile_krt_peta_kawasan') }}";
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
					$('#form_pk11').trigger("reset");
					$('#btn_save_peta_kawasan').html(btn_text);
					$('#btn_save_peta_kawasan').prop('disabled', false);
					$('#senarai_peta_kawasan_table').DataTable().ajax.reload();
				}
			});
		});

	/* click delete peta kawasan */
		$('body').on('click', '#delete_peta_kawasan', function () {
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
							$('#senarai_peta_kawasan_table').DataTable().ajax.reload();
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

	/* click download peta kawasan */
		
		//my custom script
		var download_peta_kawasan_config = {
			routes: {
				download_peta_kawasan_url: "{{ route('rt-sm2.get_data_peta_kawasan','') }}",
			}
		};

		$('body').on('click', '#download_peta_kawasan', function () {
			var download_id = $(this).data("id");
			$.get(download_peta_kawasan_config.routes.download_peta_kawasan_url + '/' + download_id, function (data) {
				let link = document.createElement("a");
				link.download = data.file_peta;
				link.href = "{{ asset('storage/peta_kawasan') }}"+"/"+ data.file_peta ;
				link.click();
			});
		});

		$(document).on('submit', '#form_pk12', function(event){  
			  
			event.preventDefault();
			swal("Profil Kawasan Rukun Tetangga Berjaya Dikemaskini!", "Rekod dikemaskini di dalam pangkalan data", "success");
			window.location.href = "{{route('rt-sm2.profile_krt')}}";
			
		});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop