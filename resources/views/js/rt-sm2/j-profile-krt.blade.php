@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
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

	//my custom script
    url_table_komposisi					= "{{ route('rt-sm2.get_krt_profile_komposisi_table','') }}"+"/"+"{{$profile_krt->id}}";
	url_delete_komposisi 				= "{{ route('rt-sm2.delete_krt_profile_komposisi','') }}";

	$(document).ready( function () {

		$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

		/* Maklumat AM KRT */
			$('#pk_krt_nama').html("{{$profile_krt->krt_nama}}");
			$('#pk_krt_alamat').html("{{$profile_krt->krt_alamat}}");
			$('#pk_tarikh_memohon').html("{{$profile_krt->created_at}}");

		/* Maklumat Asas Kawasan*/
			$('#pk_negeri_id').val("{{$profile_krt->state_id}}");
			$('#pk_parlimen_id').val("{{$profile_krt->parlimen_id}}");
			$('#pk_pbt_id').val("{{$profile_krt->pbt_id}}");
			$('#pk_daerah_id').val("{{$profile_krt->daerah_id}}");
			$('#pk_dun_id').val("{{$profile_krt->dun_id}}");
			$('#pk_krt_kawasan').val("{{$profile_krt->krt_kawasan}}");
			$('#pk_krt_keluasan').val("{{$profile_krt->krt_keluasan}}");
			$('#pk_krt_ipd').val("{{$profile_krt->krt_ipd}}");
			$('#pk_srs_nama').val("{{$profile_krt->srs_nama}}");
			$('#pk_krt_balai').val("{{$profile_krt->krt_balai}}");
			$('#pk_krt_tabika').val("{{$profile_krt->krt_tabika}}");
			$('#pk_krt_taska').val("{{$profile_krt->krt_taska}}");
			
			$('#pk2_krt_profileID').val("{{$profile_krt->id}}");
			var komposisi_penduduk_table = $('#komposisi_penduduk_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_komposisi,
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
					"width": "60%", 
					"mRender": function ( value, type, full )  {
						return full.kaum_description;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "28%", 
					"mRender": function ( value, type, full )  {
						return full.komposisi_jumlah;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_komposisi_penduduk" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			$('#pk3_krt_profile_id').val("{{$profile_krt->id}}");
	});

	/* click add komposisi penduduk */
		$(document).on('submit', '#form_pk2', function(event){
			var info = $('.error_alert');
			event.preventDefault();

			$('#btn_save_komposisi').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save_komposisi').prop('disabled', true);

			var data = $("#form_pk2").serialize();
			btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			url = "{{ route('rt-sm2.add_profile_krt_komposisi') }}";
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
					$('#btn_save_komposisi').html(btn_text);                
					$('#btn_save_komposisi').prop('disabled', false);
					info.slideDown();
				} else {
					swal("Komposisi Penduduk ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_pk2').trigger("reset");
					$('#btn_save_komposisi').html(btn_text);
					$('#btn_save_komposisi').prop('disabled', false);
					$('#komposisi_penduduk_table').DataTable().ajax.reload();
				}
			});
		});

	/* click delete komposisi penduduk */
		$('body').on('click', '#delete_komposisi_penduduk', function () {
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
						url: url_delete_komposisi +"/" + delete_id,
						success: function (data) {
							$('#komposisi_penduduk_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod Anggaran Bilangan / Isi Rumah dan Pecahan Komposisi Penduduk telah dipadam dari pangkalan data", "success");
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
		var kemaskini_profile_krt_config = {
			routes: {
				kemaskini_profile_krt__url: "{{ route('rt-sm2.update_profile_krt') }}",
			}
		};

		$(document).on('submit', '#form_pk3', function(event){    
			event.preventDefault();
			$('#btn_next').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_next').prop('disabled', true);
			var data   = $("#form_pk, #form_pk3").serialize();
			var action = $('#update_profile_krt').val();
			var btn_text;
			if (action == 'edit') {
				url = kemaskini_profile_krt_config.routes.kemaskini_profile_krt__url;
				type = "POST";
				btn_text = 'Seterusnya &nbsp;<i class="dropdown-icon fe fe-arrow-right"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=pk_parlimen_id]').removeClass("is-invalid");
				$('[name=pk_pbt_id]').removeClass("is-invalid");
				$('[name=pk_dun_id]').removeClass("is-invalid");
				$('[name=pk_krt_kawasan]').removeClass("is-invalid");
				$('[name=pk_krt_keluasan]').removeClass("is-invalid");
				$('[name=pk_krt_ipd]').removeClass("is-invalid");
				$('[name=pk_krt_balai]').removeClass("is-invalid");

				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'pk_parlimen_id') {
							$('[name=pk_parlimen_id]').addClass("is-invalid");
							$('.error_pk_parlimen_id').html(error);
						}

						if(index == 'pk_pbt_id') {
							$('[name=pk_pbt_id]').addClass("is-invalid");
							$('.error_pk_pbt_id').html(error);
						}

						if(index == 'pk_dun_id') {
							$('[name=pk_dun_id]').addClass("is-invalid");
							$('.error_pk_dun_id').html(error);
						}

						if(index == 'pk_krt_kawasan') {
							$('[name=pk_krt_kawasan]').addClass("is-invalid");
							$('.error_pk_krt_kawasan').html(error);
						}

						if(index == 'pk_krt_keluasan') {
							$('[name=pk_krt_keluasan]').addClass("is-invalid");
							$('.error_pk_krt_keluasan').html(error);
						}

						if(index == 'pk_krt_ipd') {
							$('[name=pk_krt_ipd]').addClass("is-invalid");
							$('.error_pk_krt_ipd').html(error);
						}

						if(index == 'pk_krt_balai') {
							$('[name=pk_krt_balai]').addClass("is-invalid");
							$('.error_pk_krt_balai').html(error);
						}
					});
					$('#btn_next').html(btn_text);                
					$('#btn_next').prop('disabled', false);            
				} else {
					$('#btn_next').html(btn_text);
					$('#btn_next').prop('disabled', false); 
					window.location.href = "{{route('rt-sm2.profile_krt_1')}}";
				}
			});
		});
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop