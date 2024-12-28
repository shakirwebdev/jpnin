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
			url_table_bentuk_tindakan = "{{ route('rt-sm21.get_bentuk_tindakan_table','') }}"+"/"+"{{$ikes->id}}";
			url_table_bentuk_terlibat = "{{ route('rt-sm21.get_bentuk_terlibat_table','') }}"+"/"+"{{$ikes->id}}";

		/* Maklumat Kes Dalam Krt */
			if("{{$ikes->hasRT}}" == 1){
				$('#pipp6_hasRT').attr("checked", "checked");
			}
			$('#pipp6_negeri_id').val("{{$ikes->krt_state_id}}");
			$('#pipp6_daerah_id').val("{{$ikes->krt_daerah_id}}");
			$('#pipp6_krt_profile_id').val("{{$ikes->krt_profile_id}}");

		/* Maklumat Pemohon */
			$('#pipp6_user_fullname').val("{{$ikes->nama_permohon}}");
			$('#pipp6_user_no_ic').val("{{$ikes->ic_pemohon}}");
			$('#pipp6_user_no_phone').val("{{$ikes->phone_pemohon}}");
			$('#pipp6_dihantar_alamat').val("{{$ikes->dihantar_alamat}}");

		/* Maklumat Kes Kejadian */
			$('#pipp6_hasTindakan').on('click', function(){           
				if($(this).is(':checked')){
					$('#pipp6_hasTindakan').val(1);
				} else {
					
				}
			});
			$('#pi6_spk_ikes_id').val("{{$ikes->id}}");

			var senarai_bentuk_tindakan_table = $('#senarai_bentuk_tindakan_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_bentuk_tindakan,
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
						return full.tindakan_description;
					}
				},{       
					"aTargets": [ 2 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						$checked 	= (full.spk_ikes_tindakan_id) ? 'checked' : '';
						$button_a 	= '<label class="custom-control custom-checkbox">' +
									'<input class="custom-control-input" type="checkbox" id="chkp_1' + full.id + '" value="' + full.id + '" onchange="getIkesTindakan(&apos;' + full.id + '&apos;)" ' +
									$checked + '>' +
									'<span class="custom-control-label">&nbsp;</span></label>';
						return $button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});
        
			var senarai_pihak_terlibat_table = $('#senarai_pihak_terlibat_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_bentuk_terlibat,
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
						return full.pihak_description;
					}
				},{       
					"aTargets": [ 2 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						$checked 	= (full.spk_ikes_terlibat_id) ? 'checked' : '';
						$button_a 	= '<label class="custom-control custom-checkbox">' +
									'<input class="custom-control-input" type="checkbox" id="chkp_2' + full.id + '" value="' + full.id + '" onchange="getIkesTerlibat(&apos;' + full.id + '&apos;)" ' +
									$checked + '>' +
									'<span class="custom-control-label">&nbsp;</span></label>';
						return $button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			if("{{$ikes->hasTindakan}}" == 1){
				$('#pipp6_hasTindakan').attr("checked", "checked");
				$('#pipp6_hasTindakan').val(1);
			}

			$('#pipp6_ikes_keterangan_tindakan').val("{{$ikes->ikes_keterangan_tindakan}}");

			$('#pipp7_ikes_id').val("{{$ikes->id}}");

		/* Maklumat Note Kemaskini */
			$('#pipp6_status').val("{{$ikes->status}}");

			if($('#pipp6_status').val() == '11'){
				$("#pipp6_perlu_kemaskini").show();
				$('#pipp6_status_description').html("{{$ikes->status_description}}");
				$('#pipp6_disemak_note').html("{{$ikes->disemak_note}}");
			}

			if($('#pipp6_status').val() == '12'){
				$("#pipp6_perlu_kemaskini").show();
				$('#pipp6_status_description').html("{{$ikes->status_description}}");
				$('#pipp6_disahkan_note').html("{{$ikes->disahkan_note}}");
			}

			if($('#pipp6_status').val() == '15'){
				$("#pipp6_perlu_kemaskini").show();
				$('#pipp6_status_description').html("{{$ikes->status_description}}");
				$('#pipp6_disahkan_note').html("{{$ikes->disahkan_note}}");
			}

       	/* Button */
        	$('#btn_back').click(function(){
				window.location.href = "{{route('rt-sm21.permohonan_ikes_bpp_1','')}}"+"/"+"{{$ikes->id}}";
			});

	});

	function getIkesTindakan(id) {
		//checked
		if ($('#chkp_1' + id).is(':checked')) {
			// alert('checked');
			var pi6_spk_ikes_id 		= $('#pi6_spk_ikes_id').val();
			url_add_ikes_tindakan 		= "{{ route('rt-sm21.post_ikes_tindakan') }}";
			type = "POST";
			$.ajax({
				url: url_add_ikes_tindakan,
				type: type,
				data: {
						"_token": "{{ csrf_token() }}",
						"pi6_spk_ikes_id": pi6_spk_ikes_id,
						"spk_ikes_tindakan_id": id
						}
			});
		}

		//unchecked
		if (!$('#chkp_1' + id).is(':checked')) {
			// alert('unchecked');
            var pi6_spk_ikes_id 			= $('#pi6_spk_ikes_id').val();
			url_delete_ikes_tindakan 		= "{{ route('rt-sm21.post_delete_ikes_tindakan','') }}";
            type = "POST";
			$.ajax({
				url: url_delete_ikes_tindakan,
				type: type,
				data: {
						"_token": "{{ csrf_token() }}",
						"pi6_spk_ikes_id": pi6_spk_ikes_id,
						"spk_ikes_tindakan_id": id
						}
			});
			
		}
	}

	function getIkesTerlibat(id) {
		//checked
		if ($('#chkp_2' + id).is(':checked')) {
			// alert('checked');
			var pi6_spk_ikes_id 		= $('#pi6_spk_ikes_id').val();
			url_add_ikes_terlibat 		= "{{ route('rt-sm21.post_ikes_terlibat') }}";
			type = "POST";
			$.ajax({
				url: url_add_ikes_terlibat,
				type: type,
				data: {
						"_token": "{{ csrf_token() }}",
						"pi6_spk_ikes_id": pi6_spk_ikes_id,
						"spk_ikes_terlibat_id": id
						}
			});
		}

		//unchecked
		if (!$('#chkp_2' + id).is(':checked')) {
			// alert('unchecked');
            var pi6_spk_ikes_id 			= $('#pi6_spk_ikes_id').val();
			url_delete_ikes_terlibat 		= "{{ route('rt-sm21.post_delete_ikes_terlibat','') }}";
            type = "POST";
			$.ajax({
				url: url_delete_ikes_terlibat,
				type: type,
				data: {
						"_token": "{{ csrf_token() }}",
						"pi6_spk_ikes_id": pi6_spk_ikes_id,
						"spk_ikes_terlibat_id": id
						}
			});
			
		}
	}

	/* click btn next */
		//my custom script
		var permohonan_ikes_bpp_3_config = {
			routes: {
				permohonan_ikes_bpp_3_url: "{{ route('rt-sm21.post_permohonan_ikes_bpp_3') }}",
			}
		};

		$(document).on('submit', '#form_pipp7', function(event){    
			event.preventDefault();
			$('#btn_next').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_next').prop('disabled', true);
			var data   = $("#form_pipp6, #form_pipp7").serialize();
			var action = $('#post_permohonan_ikes_bpp_3').val();
			var btn_text;
			if (action == 'edit') {
				url = permohonan_ikes_bpp_3_config.routes.permohonan_ikes_bpp_3_url;
				type = "POST";
				btn_text = 'Seterusnya &nbsp;<i class="dropdown-icon fe fe-arrow-right"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=pipp6_hasTindakan]').removeClass("is-invalid");
				$('[name=pipp6_ikes_keterangan_tindakan]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'pipp6_ikes_keterangan_tindakan') {
							$('[name=pipp6_ikes_keterangan_tindakan]').addClass("is-invalid");
							$('.error_pipp6_ikes_keterangan_tindakan').html(error);
						}

					});
					$('#btn_next').html(btn_text);                
					$('#btn_next').prop('disabled', false);            
				} else {
					$('#btn_next').html(btn_text);
					$('#btn_next').prop('disabled', false); 
					window.location.href = "{{route('rt-sm21.permohonan_ikes_bpp_3','')}}"+"/"+"{{$ikes->id}}";
				}
			});
		});
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop