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

		//my custom script
			url_table_jawatankuasa_penaja 		= "{{ route('rt-sm2.get_profile_krt_jawatankuasa_penaja_table','') }}"+"/"+"{{$profile_krt->id}}";
			url_delete_jawatankuasa_penaja 		= "{{ route('rt-sm2.delete_profile_krt_jawatankuasa_penaja','') }}";

		/* Maklumat AM KRT */
			$('#pk_krt_nama').html("{{$profile_krt->krt_nama}}");
			$('#pk_krt_alamat').html("{{$profile_krt->krt_alamat}}");
			$('#pk_tarikh_memohon').html("{{$profile_krt->created_at}}");

		/* Maklumat Asas Kewangan KRT */
		
			// $('#pk12_krt_bank_baki_cash').mask('999.999.999.999.99', {reverse: true});
			// $('#pk12_krt_bank_baki_bank').mask('000.000.000.000.000,00', {reverse: true});

			senarai_jawatankuasa_penaja_table = $('#senarai_jawatankuasa_penaja_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_jawatankuasa_penaja,
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
						button_b = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_jawatankuasa_penaja" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a + '|' + button_b;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			$('#pk13_krt_profile_id').val("{{$profile_krt->id}}");
			$('#pk12_krt_bank_nama').val("{{$profile_krt->krt_bank_nama}}");
			$('#pk12_krt_bank_no_acc').val("{{$profile_krt->krt_bank_no_acc}}");
			$('#pk12_krt_bank_no_evendor').val("{{$profile_krt->krt_bank_no_evendor}}");
			$('#pk12_krt_bank_baki_cash').val("{{$profile_krt->krt_bank_baki_cash}}");
			$('#pk12_krt_bank_baki_bank').val("{{$profile_krt->krt_bank_baki_bank}}");
			$('#pk13_krt_bank_baki_status_edit').val("{{$profile_krt->krt_bank_baki_status_edit}}");
			if($('#pk13_krt_bank_baki_status_edit').val() == 0){
				$("#pk12_krt_bank_baki_cash").prop("disabled",false);
				$("#pk12_krt_bank_baki_bank").prop("disabled",false);
				var a = $('#pk12_krt_bank_baki_cash').val();
				var b = $('#pk12_krt_bank_baki_bank').val();
				var c = parseFloat(a) + parseFloat(b);
				var d = parseFloat(c).toFixed(2);
		    }else{
				$("#pk12_krt_bank_baki_cash").prop("disabled",true);
				$("#pk12_krt_bank_baki_bank").prop("disabled",true);
				var a = $('#pk12_krt_bank_baki_cash').val();
				var b = $('#pk12_krt_bank_baki_bank').val();
				var c = parseFloat(a) + parseFloat(b);
				var d = parseFloat(c).toFixed(2);
			}

			

			var a = $('#pk12_krt_bank_baki_cash').val();
			var b = $('#pk12_krt_bank_baki_bank').val();
			var c = parseFloat(a) + parseFloat(b);
			var d = parseFloat(c).toFixed(2);
			$("#pk12_krt_bank_baki_cash").keyup(function(){
				var a = $('#pk12_krt_bank_baki_cash').val();
				var b = $('#pk12_krt_bank_baki_bank').val();
				var c = parseFloat(a) + parseFloat(b);
				var d = parseFloat(c).toFixed(2);
				$('#pk12_krt_bank_total').val(d)
			});			
			$("#pk12_krt_bank_baki_bank").keyup(function(){
				var a = $('#pk12_krt_bank_baki_cash').val();
				var b = $('#pk12_krt_bank_baki_bank').val();
				var c = parseFloat(a) + parseFloat(b);
				var d = parseFloat(c).toFixed(2);
				$('#pk12_krt_bank_total').val(d)
			});

			$('#pk12_krt_bank_total').val(d)
			

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = '{{route('rt-sm2.profile_krt_7')}}';
			});

	});

	// add jawatan penaja RT
		var add_jawatan_penaja_rt_config = {
			routes: {
				add_jawatan_penaja_rt_url: "{{ route('rt-sm2.add_profile_krt_jawatankuasa_penaja') }}",
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
				url = add_jawatan_penaja_rt_config.routes.add_jawatan_penaja_rt_url;
				type = "POST";
				btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
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
		$('body').on('click', '#delete_jawatankuasa_penaja', function () {
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
						url: url_delete_jawatankuasa_penaja +"/" + delete_id,
						success: function (data) {
							// $('#peranan_form').trigger("reset");
							$('#senarai_jawatankuasa_penaja_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod Jawatankuasa Penaja RT telah dipadam dari pangkalan data", "success");
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

	/* click btn kemaskini */
		//my custom script

		var kemaskini_profile_krt_config = {
			routes: {
				kemaskini_profile_krt__url: "{{ route('rt-sm2.update_profile_krt_8') }}",
			}
		};
	
		// $(document).on('submit', '#form_pk13', function(event){  
			  
		// 	event.preventDefault();
		// 	swal("Profil Kawasan Rukun Tetangga Berjaya Dikemaskini!", "Rekod dikemaskini di dalam pangkalan data", "success");
		// 	window.location.href = "{{route('rt-sm2.profile_krt')}}";
			
		// });

		$(document).on('submit', '#form_pk13', function(event){    
			event.preventDefault();
			$('#btn_edit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_edit').prop('disabled', true);
			var data   = $("#form_pk12, #form_pk13").serialize();
			var action = $('#update_profile_krt_8').val();
			var btn_text;
			if (action == 'edit') {
				url = kemaskini_profile_krt_config.routes.kemaskini_profile_krt__url;
				type = "POST";
				btn_text = 'Kemaskini Profil KRT &nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=pk12_krt_bank_nama]').removeClass("is-invalid");
				$('[name=pk12_krt_bank_no_acc]').removeClass("is-invalid");
				$('[name=pk12_krt_bank_no_evendor]').removeClass("is-invalid");
				$('[name=pk12_krt_bank_baki_cash]').removeClass("is-invalid");
				$('[name=pk12_krt_bank_baki_bank]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'pk12_krt_bank_nama') {
							$('[name=pk12_krt_bank_nama]').addClass("is-invalid");
							$('.error_pk12_krt_bank_nama').html(error);
						}

						if(index == 'pk12_krt_bank_no_acc') {
							$('[name=pk12_krt_bank_no_acc]').addClass("is-invalid");
							$('.error_pk12_krt_bank_no_acc').html(error);
						}

						if(index == 'pk12_krt_bank_no_evendor') {
							$('[name=pk12_krt_bank_no_evendor]').addClass("is-invalid");
							$('.error_pk12_krt_bank_no_evendor').html(error);
						}

						if(index == 'pk12_krt_bank_baki_cash') {
							$('[name=pk12_krt_bank_baki_cash]').addClass("is-invalid");
							$('.error_pk12_krt_bank_baki_cash').html(error);
						}

						if(index == 'pk12_krt_bank_baki_bank') {
							$('[name=pk12_krt_bank_baki_bank]').addClass("is-invalid");
							$('.error_pk12_krt_bank_baki_bank').html(error);
						}

					});
					$('#btn_edit').html(btn_text);                
					$('#btn_edit').prop('disabled', false);            
				} else {
					$('#btn_edit').html(btn_text);
					$('#btn_edit').prop('disabled', false); 
					event.preventDefault();
					swal("Profil Kawasan Rukun Tetangga Berjaya Dikemaskini!", "Rekod dikemaskini di dalam pangkalan data", "success");
					window.location.href = "{{route('rt-sm2.profile_krt')}}";
				}
			});
		});
	
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
@stop