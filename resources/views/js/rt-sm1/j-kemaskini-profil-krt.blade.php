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
    url						= "{{ route('rt-sm1.get_komposisi_penduduk_table','') }}"+"/"+$('#kpk_krt_profileID').val();
	url_delete_komposisi 	= "{{ route('rt-sm1.delete_komposisi_penduduk','') }}";
	url_parlimen			= "{{ route('rt-sm1.kemaskini_profil_krt','') }}"+"/"+$('#kpk_krt_profileID').val();

	$(document).ready( function () {

		$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

		/* Maklumat KRT Yang Dimohon */
			$('#kpk_krt_nama').html("{{$profile_krt->krt_nama}}");
			$('#kpk_krt_alamat').html("{{$profile_krt->krt_alamat}}");
			$('#kpk_tarikh_memohon').html("{{$profile_krt->created_at}}");

		/* Maklumat Pemohon */
			$('#kpk_pemohon_name').val("{{$profile_krt->user_fullname}}");
			$('#kpk_pemohon_ic').val("{{$profile_krt->no_ic}}");
			$('#kpk_pemohon_alamat').val("{{$profile_krt->user_address}}");

		/* Maklumat Asas Kawasan*/
			$('#kpk1_negeri_id').val("{{$profile_krt->state_id}}");
			$('#kpk1_daerah_id').val("{{$profile_krt->daerah_id}}");
			$('#kpk1_parlimen_id').val("{{$profile_krt->parlimen_id}}");
			$('#kpk1_pbt_id').val("{{$profile_krt->pbt_id}}");
			$('#kpk1_dun_id').val("{{$profile_krt->dun_id}}");
			$('#kpk1_krt_kawasan').val("{{$profile_krt->krt_kawasan}}");
			$('#kpk1_krt_keluasan').val("{{$profile_krt->krt_keluasan}}");
			$('#kpk1_krt_ipd').val("{{$profile_krt->krt_ipd}}");
			$('#kpk1_srs_nama').val("{{$profile_krt->srs_nama}}");
			$('#kpk1_krt_balai').val("{{$profile_krt->krt_balai}}");
			$('#kpk1_krt_tabika').val("{{$profile_krt->krt_tabika}}");
			$('#kpk1_krt_taska').val("{{$profile_krt->krt_taska}}");
			$('#kpk1_krt_id').val("{{$profile_krt->id}}");

			var komposisi_penduduk_table = $('#komposisi_penduduk_table').DataTable( {
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
						button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete-komposisi_penduduk" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
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
				window.location.href = '{{route('rt-sm1.status_permohonan_penubuhan_krt')}}';
			});

	});

	/* click add komposisi penduduk */
		$(document).on('submit', '#komposisi_form', function(event){
			var info = $('.error_alert');
			event.preventDefault();

			$('#btn-save-komposisi').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn-save-komposisi').prop('disabled', true);

			var data = $("#komposisi_form").serialize();
			var action = $('#action_peranan').val();
			
			btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			url = "{{ route('rt-sm1.post_komposisi_penduduk') }}";
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
					$('#btn-save-komposisi').html(btn_text);                
					$('#btn-save-komposisi').prop('disabled', false);
					info.slideDown();
				} else {
					swal("Komposisi ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#komposisi_form').trigger("reset");
					$('#btn-save-komposisi').html(btn_text);
					$('#btn-save-komposisi').prop('disabled', false);
					$('#komposisi_penduduk_table').DataTable().ajax.reload();
				}
			});
		});

	/* click delete komposisi penduduk */
		$('body').on('click', '#delete-komposisi_penduduk', function () {
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
							// $('#peranan_form').trigger("reset");
							$('#komposisi_penduduk_table').DataTable().ajax.reload();
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

	/* click btn next */
		//my custom script
		var kemaskini_profile_krt_config = {
			routes: {
				kemaskini_profile_krt__url: "{{ route('rt-sm1.update_kemaskini_profil_krt') }}",
			}
		};

		$(document).on('submit', '#form_kpk2', function(event){    
			event.preventDefault();
			$('#btn_next').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_next').prop('disabled', true);
			var data = $("#form_kpk1").serialize();
			var action = $('#update_kemaskini_profil_krt').val();
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
				$('[name=kpk1_parlimen_id]').removeClass("is-invalid");
				$('[name=kpk1_pbt_id]').removeClass("is-invalid");
				$('[name=kpk1_dun_id]').removeClass("is-invalid");
				$('[name=kpk1_krt_kawasan]').removeClass("is-invalid");
				$('[name=kpk1_krt_keluasan]').removeClass("is-invalid");
				$('[name=kpk1_krt_ipd]').removeClass("is-invalid");
				$('[name=kpk1_krt_balai]').removeClass("is-invalid");

				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'kpk1_parlimen_id') {
							$('[name=kpk1_parlimen_id]').addClass("is-invalid");
							$('.error_kpk1_parlimen_id').html(error);
						}

						if(index == 'kpk1_pbt_id') {
							$('[name=kpk1_pbt_id]').addClass("is-invalid");
							$('.error_kpk1_pbt_id').html(error);
						}

						if(index == 'kpk1_dun_id') {
							$('[name=kpk1_dun_id]').addClass("is-invalid");
							$('.error_kpk1_dun_id').html(error);
						}

						if(index == 'kpk1_krt_kawasan') {
							$('[name=kpk1_krt_kawasan]').addClass("is-invalid");
							$('.error_kpk1_krt_kawasan').html(error);
						}

						if(index == 'kpk1_krt_keluasan') {
							$('[name=kpk1_krt_keluasan]').addClass("is-invalid");
							$('.error_kpk1_krt_keluasan').html(error);
						}

						if(index == 'kpk1_krt_ipd') {
							$('[name=kpk1_krt_ipd]').addClass("is-invalid");
							$('.error_kpk1_krt_ipd').html(error);
						}

						if(index == 'kpk1_krt_balai') {
							$('[name=kpk1_krt_balai]').addClass("is-invalid");
							$('.error_kpk1_krt_balai').html(error);
						}
					});
					$('#btn_next').html(btn_text);                
					$('#btn_next').prop('disabled', false);            
				} else {
					$('#btn_next').html(btn_text);
					$('#btn_next').prop('disabled', false); 
					window.location.href = "{{route('rt-sm1.kemaskini_profil_krt_1','')}}"+"/"+"{{$profile_krt->id}}";
				}
			});
		});
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop