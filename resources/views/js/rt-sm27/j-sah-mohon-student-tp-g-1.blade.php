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

</style>
<script type="text/javascript">  

	$(document).ready( function () {

		//my custom script
			url_jenis_pengesahan 			= "{{ route('rt-sm27.get_pengesahan_penjaga_table','') }}"+"/"+"{{$tbk_student->id}}";
			url_dokument_student 			= "{{ route('rt-sm27.get_dokument_student_table','') }}"+"/"+"{{$tbk_student->id}}";
			url_download_dokument_student 	= "{{ route('rt-sm27.get_download_dokument_student','') }}";
            url_post_sah_permohonan_student = "{{ route('rt-sm27.post_sah_permohonan_student')}}";
			
        /* Maklumat Tabika Perpaduan */
			$('#smstg_state_id').val("{{$tbk_student->state_id}}");
			$('#smstg_daerah_id').val("{{$tbk_student->daerah_id}}");
			$('#smstg_tabika_id').val("{{$tbk_student->tabika_id}}");

		/* Bahagian B : Maklumat Ibu */
			$('#smstg_ibu_nama').val("{{$tbk_student->ibu_nama}}");
			$('#smstg_ibu_pekerjaan').val("{{$tbk_student->ibu_pekerjaan}}");
			$('#smstg_ibu_profession_id').val("{{$tbk_student->ibu_profession_id}}");
			$('#smstg_ibu_pendapatan').val("{{$tbk_student->ibu_pendapatan}}");
			$('#smstg_ibu_kerakyatan_id').val("{{$tbk_student->ibu_kerakyatan_id}}");
			$('#smstg_ibu_jumlah_pendapatan').val("{{$tbk_student->ibu_jumlah_pendapatan}}");
			$('#smstg_ibu_jumlah_pendapatan_lain').val("{{$tbk_student->ibu_jumlah_pendapatan_lain}}");
			$('#smstg_ibu_ic').val("{{$tbk_student->ibu_ic}}");
			$('#smstg_ibu_alamat_office').val("{{$tbk_student->ibu_alamat_office}}");
			$('#smstg_ibu_phone_office').val("{{$tbk_student->ibu_phone_office}}");
			$('#smstg_ibu_phone').val("{{$tbk_student->ibu_phone}}");
			$('#smstg_ibu_phone_rumah').val("{{$tbk_student->ibu_phone_rumah}}");
			$('#smstg_ibu_bil_anak').val("{{$tbk_student->ibu_bil_anak}}");
			$('#smstg_ibu_hubungan_student').val("{{$tbk_student->ibu_hubungan_student}}");
			$('#smstg_ibu_pilihan').val("{{$tbk_student->ibu_pilihan}}");
			$('#smstg_ibu_bil_anak_sekolah').val("{{$tbk_student->ibu_bil_anak_sekolah}}");
			$('#smstg_ibu_tabika_lain').val("{{$tbk_student->ibu_tabika_lain}}");
            $('#smstg_student_id').val("{{$tbk_student->id}}");
			$('#smstg_1_student_id').val("{{$tbk_student->id}}");
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
									$checked + ' disabled>' +
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
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

		/* Maklumat Status Pengesahan */
			$("#smstg_student_status").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				if (value == '7') {
					$("#smstg_penerangan").hide();
					$("#smstg_sebab_ditolak").show();
				} else {
					$("#smstg_penerangan").show();
					$("#smstg_sebab_ditolak").hide();
				}
			});
			
		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{route('rt-sm27.sah_mohon_student_tp_g','')}}"+"/"+"{{$tbk_student->id}}";
			});
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

    /* click submit pengesahan */
		$(document).on('submit', '#form_smstg', function(event){    
			event.preventDefault();
			$('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_submit').prop('disabled', true);
			var data = $("#form_smstg").serialize();
			var action = $('#post_sah_permohonan_student').val();
			var btn_text;
			if (action == 'edit') {
				url = url_post_sah_permohonan_student;
				type = "POST";
				btn_text = 'Hantar Status Pengesahan&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=smstg_student_status]').removeClass("is-invalid");
				$('[name=smstg_disahkan_note]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'smstg_student_status') {
							$('[name=smstg_student_status]').addClass("is-invalid");
							$('.error_smstg_student_status').html(error);
						}

						if(index == 'smstg_disahkan_note') {
							$('[name=smstg_disahkan_note]').addClass("is-invalid");
							$('.error_smstg_disahkan_note').html(error);
						}

					});
					$('#btn_submit').html(btn_text);                
					$('#btn_submit').prop('disabled', false);            
				} else {
					$('#btn_submit').html(btn_text);
					$('#btn_submit').prop('disabled', false); 
					window.location.href = "{{route('rt-sm27.senarai_sah_mohon_student_tp_g')}}";
				}
			});
		});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop