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
			url_jenis_pengesahan 					= "{{ route('rt-sm27.get_pengesahan_penjaga_table','') }}"+"/"+"{{$tbk_student->id}}";
			url_dokument_student 					= "{{ route('rt-sm27.get_dokument_student_table','') }}"+"/"+"{{$tbk_student->id}}";
			url_download_dokument_student 			= "{{ route('rt-sm27.get_download_dokument_student','') }}";
			url_delete_dokument_student 			= "{{ route('rt-sm27.delete_dokument_student','') }}";
			url_post_permohonan_student_tp_2_back 	= "{{ route('rt-sm27.post_permohonan_student_tp_2_back') }}";

		/* Maklumat Tabika Perpaduan */
			$('#mstpp_1_state_id').val("{{$tbk_student->state_id}}");
			$('#mstpp_1_daerah_id').val("{{$tbk_student->daerah_id}}");
			$('#mstpp_1_tabika_id').val("{{$tbk_student->tabika_id}}");

		/* Bahagian B : Maklumat Ibu */
			$('#mstpp_2_ibu_nama').val("{{$tbk_student->ibu_nama}}");
			$('#mstpp_2_ibu_pekerjaan').val("{{$tbk_student->ibu_pekerjaan}}");
			$('#mstpp_2_ibu_profession_id').val("{{$tbk_student->ibu_profession_id}}");
			$('#mstpp_2_ibu_pendapatan').val("{{$tbk_student->ibu_pendapatan}}");
			$('#mstpp_2_ibu_kerakyatan_id').val("{{$tbk_student->ibu_kerakyatan_id}}");
			$('#mstpp_2_ibu_jumlah_pendapatan').val("{{$tbk_student->ibu_jumlah_pendapatan}}");
			$('#mstpp_2_ibu_jumlah_pendapatan_lain').val("{{$tbk_student->ibu_jumlah_pendapatan_lain}}");
			$('#mstpp_2_ibu_ic').val("{{$tbk_student->ibu_ic}}");
			$('#mstpp_2_ibu_alamat_office').val("{{$tbk_student->ibu_alamat_office}}");
			$('#mstpp_2_ibu_phone_office').val("{{$tbk_student->ibu_phone_office}}");
			$('#mstpp_2_ibu_phone').val("{{$tbk_student->ibu_phone}}");
			$('#mstpp_2_ibu_phone_rumah').val("{{$tbk_student->ibu_phone_rumah}}");
			$('#mstpp_2_ibu_bil_anak').val("{{$tbk_student->ibu_bil_anak}}");
			$('#mstpp_2_ibu_hubungan_student').val("{{$tbk_student->ibu_hubungan_student}}");
			$('#mstpp_2_ibu_pilihan').val("{{$tbk_student->ibu_pilihan}}");
			$('#mstpp_2_ibu_bil_anak_sekolah').val("{{$tbk_student->ibu_bil_anak_sekolah}}");
			$('#mstpp_2_ibu_tabika_lain').val("{{$tbk_student->ibu_tabika_lain}}");
			$('#mstpp_3_student_id').val("{{$tbk_student->id}}");
			$('#mstpp_4_student_id').val("{{$tbk_student->id}}");
			$('#mstpp_5_student_id').val("{{$tbk_student->id}}");

			var senarai_pengesahan_penjaga_table = $('#senarai_pengesahan_penjaga_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_jenis_pengesahan,
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
				dom: '',
				"bFilter": true,
				"bSort": false,
				responsive: true,
				"aoColumnDefs":[{       
					"aTargets": [ 0 ],
					"border" : "0", 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						$checked 	= (full.tbk_student_pengesahan_id) ? 'checked' : '';
						$button_a 	= '<label class="custom-control custom-checkbox">' +
									'<input class="custom-control-input" type="checkbox" id="chkp_1' + full.id + '" value="' + full.id + '" onchange="getPengesahanPenjaga(&apos;' + full.id + '&apos;)" ' +
									$checked + '>' +
									'<span class="custom-control-label">&nbsp;</span></label>';
						return $button_a;
					}
				},{          
					"aTargets": [ 1 ], 
					"width": "60%", 
					"mRender": function ( value, type, full )  {
						return full.pengesahan_description;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			var senarai_muatnaik_dokumen_table = $('#senarai_muatnaik_dokumen_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_dokument_student,
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
					"width": "44%", 
					"mRender": function ( value, type, full )  {
						return full.file_title;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "44%", 
					"mRender": function ( value, type, full )  {
						return full.file_dokument;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Download Fail" id="download_dokument" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-download"></i></button>';
						button_b = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_dokument" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a + '|' + button_b;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

		/* Maklumat Note Kemaskini */
			$('#mstpp_student_status').val("{{$tbk_student->student_status}}");

			if($('#mstpp_student_status').val() == '4'){
				$("#mstpp_perlu_kemaskini").show();
				$('#mstpp_status_description').html("{{$tbk_student->status_description}}");
				$('#mstpp_disahkan_note').html("{{$tbk_student->disahkan_note}}");
			}

			if($('#mstpp_student_status').val() == '6'){
				$("#mstpp_perlu_kemaskini").show();
				$('#mstpp_status_description').html("{{$tbk_student->status_description}}");
				$('#mstpp_diluluskan_note').html("{{$tbk_student->diluluskan_note}}");
			}

		/* Button */
			
	});

	/* Get Pengesahan */
		function getPengesahanPenjaga(id) {
			//checked
			if ($('#chkp_1' + id).is(':checked')) {
				// alert('checked');
				var mstpp_3_student_id 		= $('#mstpp_3_student_id').val();
				url_add_pengesahan_penjaga 	= "{{ route('rt-sm27.post_pengesahan_penjaga') }}";
				type = "POST";
				$.ajax({
					url: url_add_pengesahan_penjaga,
					type: type,
					data: {
							"_token": "{{ csrf_token() }}",
							"mstpp_3_student_id": mstpp_3_student_id,
							"tbk_student_pengesahan_id": id
							}
				});
			}

			//unchecked
			if (!$('#chkp_1' + id).is(':checked')) {
				// alert('unchecked');
				var mstpp_3_student_id 			= $('#mstpp_3_student_id').val();
				url_delete_pengesahan_penjaga 	= "{{ route('rt-sm27.post_delete_pengesahan_penjaga','') }}";
				type = "POST";
				$.ajax({
					url: url_delete_pengesahan_penjaga,
					type: type,
					data: {
							"_token": "{{ csrf_token() }}",
							"mstpp_3_student_id": mstpp_3_student_id,
							"tbk_student_pengesahan_id": id
							}
				});
				
			}
		}

	/* Click add dokument */
		$(document).on('submit', '#form_mstpp_4', function(event){
			var info = $('.error_mstpp_4');
			event.preventDefault();

			var form_data = new FormData();
			form_data.append("mstpp_4_file_title", $("#mstpp_4_file_title").val() );
			form_data.append("mstpp_4_file_dokument",  $("#mstpp_4_file_dokument")[0].files[0]);
			form_data.append("mstpp_4_student_id", $("#mstpp_4_student_id").val() );
			form_data.append("add_tbk_student_dokument", "add" );
			console.log(form_data);
			$('#btn_save_dokument').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save_dokument').prop('disabled', true);
			btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			url = "{{ route('rt-sm27.add_tbk_student_dokument') }}";
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
					$('#btn_save_dokument').html(btn_text);                
					$('#btn_save_dokument').prop('disabled', false);
					info.slideDown();
				} else {
					swal("Fail Dokument ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_mstpp_4').trigger("reset");
					$('#btn_save_dokument').html(btn_text);
					$('#btn_save_dokument').prop('disabled', false);
					$('#senarai_muatnaik_dokumen_table').DataTable().ajax.reload();
				}
			});
		});

	/* Click download dokument */
		$('body').on('click', '#download_dokument', function () {
			var download_id = $(this).data("id");
			$.get(url_download_dokument_student + '/' + download_id, function (data) {
				let link = document.createElement("a");
				link.download = data.file_dokument;
				link.href = "{{ asset('storage/tbk_student_dokument') }}"+"/"+ data.file_dokument ;
				link.click();
			});
		});

	/* Click deleted dokument */
		$('body').on('click', '#delete_dokument', function () {
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
						url: url_delete_dokument_student +"/" + delete_id,
						success: function (data) {
							// $('#peranan_form').trigger("reset");
							$('#senarai_muatnaik_dokumen_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Fail Dokument telah dipadam dari pangkalan data", "success");
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

	/* Click button back */
		$(document).on('click', '#btn_back', function(event){    
			event.preventDefault();
			$('#btn_back').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_back').prop('disabled', true);
			var data   = $("#form_mstpp_2, #form_mstpp_5").serialize();
			var action = $('#post_permohonan_student_tp_2').val();
			var btn_text;
			if (action == 'edit') {
				url = url_post_permohonan_student_tp_2_back;
				type = "POST";
				btn_text = '<i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						
					});
					$('#btn_back').html(btn_text);                
					$('#btn_back').prop('disabled', false);            
				} else {
					$('#btn_back').html(btn_text);
					$('#btn_back').prop('disabled', false); 
					window.location.href = "{{route('rt-sm27.mohon_student_tp_p','')}}"+"/"+"{{$tbk_student->id}}";
				}
			});
		});

	/* Button Seterusnya */
		//my custom script
        var edit_permohonan_student_config = {
            routes: {
                edit_permohonan_student_url: "{{ route('rt-sm27.post_permohonan_student_tp_2') }}",
            }
        };

		$(document).on('submit', '#form_mstpp_5', function(event){    
            event.preventDefault();
            $('#btn_send').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_send').prop('disabled', true);
            var data = $("#form_mstpp_2, #form_mstpp_5").serialize();
            var action = $('#post_permohonan_student_tp_2').val();
            var btn_text;
            if (action == 'edit') {
                url = edit_permohonan_student_config.routes.edit_permohonan_student_url;
                type = "POST";
                btn_text = 'Hantar Permohonan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=mstpp_2_ibu_nama]').removeClass("is-invalid");
                $('[name=mstpp_2_ibu_pekerjaan]').removeClass("is-invalid");
                $('[name=mstpp_2_ibu_profession_id]').removeClass("is-invalid");
                $('[name=mstpp_2_ibu_pendapatan]').removeClass("is-invalid");
                $('[name=mstpp_2_ibu_kerakyatan_id]').removeClass("is-invalid");
                $('[name=mstpp_2_ibu_jumlah_pendapatan]').removeClass("is-invalid");
                $('[name=mstpp_2_ibu_jumlah_pendapatan_lain]').removeClass("is-invalid");
                $('[name=mstpp_2_ibu_ic]').removeClass("is-invalid");
                $('[name=mstpp_2_ibu_alamat_office]').removeClass("is-invalid");
                $('[name=mstpp_2_ibu_phone_office]').removeClass("is-invalid");
                $('[name=mstpp_2_ibu_phone]').removeClass("is-invalid");
                $('[name=mstpp_2_ibu_bil_anak]').removeClass("is-invalid");
                $('[name=mstpp_2_ibu_hubungan_student]').removeClass("is-invalid");
                $('[name=mstpp_2_ibu_pilihan]').removeClass("is-invalid");
                $('[name=mstpp_2_ibu_bil_anak_sekolah]').removeClass("is-invalid");
                
				if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'mstpp_2_ibu_nama') {
                            $('[name=mstpp_2_ibu_nama]').addClass("is-invalid");
                            $('.error_mstpp_2_ibu_nama').html(error);
                        }

                        if(index == 'mstpp_2_ibu_pekerjaan') {
                            $('[name=mstpp_2_ibu_pekerjaan]').addClass("is-invalid");
                            $('.error_mstpp_2_ibu_pekerjaan').html(error);
                        }

                        if(index == 'mstpp_2_ibu_profession_id') {
                            $('[name=mstpp_2_ibu_profession_id]').addClass("is-invalid");
                            $('.error_mstpp_2_ibu_profession_id').html(error);
                        }

                        if(index == 'mstpp_2_ibu_pendapatan') {
                            $('[name=mstpp_2_ibu_pendapatan]').addClass("is-invalid");
                            $('.error_mstpp_2_ibu_pendapatan').html(error);
                        }

                        if(index == 'mstpp_2_ibu_kerakyatan_id') {
                            $('[name=mstpp_2_ibu_kerakyatan_id]').addClass("is-invalid");
                            $('.error_mstpp_2_ibu_kerakyatan_id').html(error);
                        }

                        if(index == 'mstpp_2_ibu_ic') {
                            $('[name=mstpp_2_ibu_ic]').addClass("is-invalid");
                            $('.error_mstpp_2_ibu_ic').html(error);
                        }

                        if(index == 'mstpp_2_ibu_alamat_office') {
                            $('[name=mstpp_2_ibu_alamat_office]').addClass("is-invalid");
                            $('.error_mstpp_2_ibu_alamat_office').html(error);
                        }

                        if(index == 'mstpp_2_ibu_phone_office') {
                            $('[name=mstpp_2_ibu_phone_office]').addClass("is-invalid");
                            $('.error_mstpp_2_ibu_phone_office').html(error);
                        }

                        if(index == 'mstpp_2_ibu_phone') {
                            $('[name=mstpp_2_ibu_phone]').addClass("is-invalid");
                            $('.error_mstpp_2_ibu_phone').html(error);
                        }

                        if(index == 'mstpp_2_ibu_bil_anak') {
                            $('[name=mstpp_2_ibu_bil_anak]').addClass("is-invalid");
                            $('.error_mstpp_2_ibu_bil_anak').html(error);
                        }

                        if(index == 'mstpp_2_ibu_hubungan_student') {
                            $('[name=mstpp_2_ibu_hubungan_student]').addClass("is-invalid");
                            $('.error_mstpp_2_ibu_hubungan_student').html(error);
                        }

                        if(index == 'mstpp_2_ibu_pilihan') {
                            $('[name=mstpp_2_ibu_pilihan]').addClass("is-invalid");
                            $('.error_mstpp_2_ibu_pilihan').html(error);
                        }

                        if(index == 'mstpp_2_ibu_bil_anak_sekolah') {
                            $('[name=mstpp_2_ibu_bil_anak_sekolah]').addClass("is-invalid");
                            $('.error_mstpp_2_ibu_bil_anak_sekolah').html(error);
                        }

                    });
                    $('#btn_send').html(btn_text);                
                    $('#btn_send').prop('disabled', false);            
                } else {
                    $('#btn_send').html(btn_text);
                    $('#btn_send').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm27.senarai_student_tp_p')}}";
                }
            });
        });
    

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop