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
		url_table_kemudahan_awam 	= "{{ route('rt-sm2.get_profile_krt_kemudahan_awam_table','') }}"+"/"+"{{$profile_krt->id}}";
		url_delete_kemudahan_awam 	= "{{ route('rt-sm2.delete_profile_krt_kemudahan_awam','') }}";
			
		/* Maklumat AM KRT */
			$('#pk_krt_nama').html("{{$profile_krt->krt_nama}}");
			$('#pk_krt_alamat').html("{{$profile_krt->krt_alamat}}");
			$('#pk_tarikh_memohon').html("{{$profile_krt->created_at}}");

		/* Maklumat Asas kawasan */
			$('#pk7_krt_profileID').val("{{$profile_krt->id}}");
			var senarai_kemudahan_awam_table = $('#senarai_kemudahan_awam_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_kemudahan_awam,
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
					"width": "70%", 
					"mRender": function ( value, type, full )  {
						return full.kemudahan_awam_description;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "18%",
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.kemudahan_awam_jumlah;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_kemudahan_awam" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
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
				window.location.href = '{{route('rt-sm2.profile_krt_2')}}';
			});

			$('#btn_next').click(function(){
				window.location.href = '{{route('rt-sm2.profile_krt_4')}}';
			});
	
	});

	/* click add kemudahan awam */
		$(document).on('submit', '#form_pk7', function(event){
			var info = $('.error_form_pk7');
			event.preventDefault();

			$('#btn_save_kemudahan_awam').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save_kemudahan_awam').prop('disabled', true);

			var data = $("#form_pk7").serialize();
			btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			url = "{{ route('rt-sm2.add_profile_krt_kemudahan_awam') }}";
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
					$('#btn_save_kemudahan_awam').html(btn_text);                
					$('#btn_save_kemudahan_awam').prop('disabled', false);
					info.slideDown();
				} else {
					swal("Kemudahan Awam ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_pk7').trigger("reset");
					$('#btn_save_kemudahan_awam').html(btn_text);
					$('#btn_save_kemudahan_awam').prop('disabled', false);
					$('#senarai_kemudahan_awam_table').DataTable().ajax.reload();
				}
			});
		});

	/* click delete kemudahan awam */
		$('body').on('click', '#delete_kemudahan_awam', function () {
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
						url: url_delete_kemudahan_awam +"/" + delete_id,
						success: function (data) {
							// $('#peranan_form').trigger("reset");
							$('#senarai_kemudahan_awam_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod Kemudahan Awam telah dipadam dari pangkalan data", "success");
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