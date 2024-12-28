@include('js.modal.j-modal-add-jawatankuasa-penaja-rt')
@include('js.modal.j-modal-view-jawatankuasa-penaja-rt')
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

		/* Maklumat KRT Yang Dimohon */
			$('#kpk_krt_nama').html("{{$profile_krt->krt_nama}}");
			$('#kpk_krt_alamat').html("{{$profile_krt->krt_alamat}}");
			$('#kpk_tarikh_memohon').html("{{$profile_krt->created_at}}");

		/* Maklumat Pemohon */
			$('#kpk_pemohon_name').val("{{$profile_krt->user_fullname}}");
			$('#kpk_pemohon_ic').val("{{$profile_krt->no_ic}}");
			$('#kpk_pemohon_alamat').val("{{$profile_krt->user_address}}");

		//my custom script
			url 		= "{{ route('rt-sm1.get_jawatankuasa_penaja_table','') }}"+"/"+$('#kaf_krt_profileID').val();
			url_delete 	= "{{ route('rt-sm1.delete_jawatankuasa_penaja','') }}";
			
			var senarai_jawatankuasa_penaja_table = $('#senarai_jawatankuasa_penaja_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url,
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
						return full.penaja_nama;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "28%", 
					"mRender": function ( value, type, full )  {
						return full.penaja_ic;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "20%", 
					"mRender": function ( value, type, full )  {
						return full.penaja_no_fone;
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "6%", 
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_jawatankuasa_penaja_rt(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
						button_b = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete-jawatankuasa-penaja" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a + "|" + button_b;
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

	});

	/* Jawatan Penaja RT */
	// add jawatan penaja RT

		var add_jawatan_penaja_rt_config = {
			routes: {
				add_jawatan_penaja_rt: "{{ route('rt-sm1.post_jawatankuasa_penaja') }}",
			}
		};

		$(document).on('submit', '#jawatankuasa_penaja_form', function(event){    
			event.preventDefault();
			$('#btn_add').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_add').prop('disabled', true);
			var data = $("#jawatankuasa_penaja_form").serialize();
			var action = $('#add_jawatankuasa_penaja').val();
			var btn_text;
			if (action == 'add') {
				url = add_jawatan_penaja_rt_config.routes.add_jawatan_penaja_rt;
				type = "POST";
				btn_text = 'Hantar Permohonan Profail KRT&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
			}

			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=jpf_penaja_nama]').removeClass("is-invalid");
				$('[name=jpf_penaja_ic]').removeClass("is-invalid");
				$('[name=jpf_ref_jantinaID]').removeClass("is-invalid");
				$('[name=jpf_penaja_pekerjaan]').removeClass("is-invalid");
				$('[name=jpf_penaja_no_fone]').removeClass("is-invalid");
				$('[name=jpf_penaja_birth]').removeClass("is-invalid");
				$('[name=jpf_penaja_no_office]').removeClass("is-invalid");
				$('[name=jpf_ref_kaumID]').removeClass("is-invalid");
				$('[name=jpf_penaja_alamat_rumah]').removeClass("is-invalid");
				$('[name=jpf_penaja_alamat_pejabat]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'jpf_penaja_nama') {
							$('[name=jpf_penaja_nama]').addClass("is-invalid");
							$('.error_jpf_penaja_nama').html(error);
						}

						if(index == 'jpf_penaja_ic') {
							$('[name=jpf_penaja_ic]').addClass("is-invalid");
							$('.error_jpf_penaja_ic').html(error);
						}

						if(index == 'jpf_ref_jantinaID') {
							$('[name=jpf_ref_jantinaID]').addClass("is-invalid");
							$('.error_jpf_ref_jantinaID').html(error);
						}

						if(index == 'jpf_penaja_pekerjaan') {
							$('[name=jpf_penaja_pekerjaan]').addClass("is-invalid");
							$('.error_jpf_penaja_pekerjaan').html(error);
						}
						
						if(index == 'jpf_penaja_no_fone') {
							$('[name=jpf_penaja_no_fone]').addClass("is-invalid");
							$('.error_jpf_penaja_no_fone').html(error);
						}

						if(index == 'jpf_penaja_no_office') {
							$('[name=jpf_penaja_no_office]').addClass("is-invalid");
							$('.error_jpf_penaja_no_office').html(error);
						}

						if(index == 'jpf_penaja_birth') {
							$('[name=jpf_penaja_birth]').addClass("is-invalid");
							$('.error_jpf_penaja_birth').html(error);
						}

						if(index == 'jpf_ref_kaumID') {
							$('[name=jpf_ref_kaumID]').addClass("is-invalid");
							$('.error_jpf_ref_kaumID').html(error);
						}

						if(index == 'jpf_penaja_alamat_rumah') {
							$('[name=jpf_penaja_alamat_rumah]').addClass("is-invalid");
							$('.error_jpf_penaja_alamat_rumah').html(error);
						}

						if(index == 'jpf_penaja_alamat_pejabat') {
							$('[name=jpf_penaja_alamat_pejabat]').addClass("is-invalid");
							$('.error_jpf_penaja_alamat_pejabat').html(error);
						}
					});
					$('#btn_add').html(btn_text);                
					$('#btn_add').prop('disabled', false);            
				} else {
					$('#modal_add_jawatankuasa_penaja_rt').modal('hide');
					swal("Maklumat Jawatan Kuasa Penaja ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#jawatankuasa_penaja_form').trigger("reset");
					$('#senarai_jawatankuasa_penaja_table').DataTable().ajax.reload();
					$('#btn_add').html(btn_text);                
					$('#btn_add').prop('disabled', false); 
				}
			});
		});

	// delete jawatankuasa penaja
		$('body').on('click', '#delete-jawatankuasa-penaja', function () {
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
							$('#senarai_jawatankuasa_penaja_table').DataTable().ajax.reload();
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
<script src="{{ asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
@stop