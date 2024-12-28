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
			url_jenis_pengesahan 			    = "{{ route('rt-sm27.get_pengesahan_penjaga_table','') }}"+"/"+"{{$tbk_student->id}}";
			url_dokument_student 			    = "{{ route('rt-sm27.get_dokument_student_table','') }}"+"/"+"{{$tbk_student->id}}";
			url_download_dokument_student 	    = "{{ route('rt-sm27.get_download_dokument_student','') }}";
            url_post_lulus_permohonan_student   = "{{ route('rt-sm27.post_lulus_permohonan_student')}}";
			
        /* Maklumat Tabika Perpaduan */
			$('#lmstpd_state_id').val("{{$tbk_student->state_id}}");
			$('#lmstpd_daerah_id').val("{{$tbk_student->daerah_id}}");
			$('#lmstpd_tabika_id').val("{{$tbk_student->tabika_id}}");

		/* Maklumat Pengesahan Guru */
			$('#lmstpd_status_pengesahan').val("{{$tbk_student->status_pengesahan}}");
			$('#lmstpd_disahkan_note').val("{{$tbk_student->disahkan_note}}");

		/* Bahagian B : Maklumat Ibu */
			$('#lmstpd_ibu_nama').val("{{$tbk_student->ibu_nama}}");
			$('#lmstpd_ibu_pekerjaan').val("{{$tbk_student->ibu_pekerjaan}}");
			$('#lmstpd_ibu_profession_id').val("{{$tbk_student->ibu_profession_id}}");
			$('#lmstpd_ibu_pendapatan').val("{{$tbk_student->ibu_pendapatan}}");
			$('#lmstpd_ibu_kerakyatan_id').val("{{$tbk_student->ibu_kerakyatan_id}}");
			$('#lmstpd_ibu_jumlah_pendapatan').val("{{$tbk_student->ibu_jumlah_pendapatan}}");
			$('#lmstpd_ibu_jumlah_pendapatan_lain').val("{{$tbk_student->ibu_jumlah_pendapatan_lain}}");
			$('#lmstpd_ibu_ic').val("{{$tbk_student->ibu_ic}}");
			$('#lmstpd_ibu_alamat_office').val("{{$tbk_student->ibu_alamat_office}}");
			$('#lmstpd_ibu_phone_office').val("{{$tbk_student->ibu_phone_office}}");
			$('#lmstpd_ibu_phone').val("{{$tbk_student->ibu_phone}}");
			$('#lmstpd_ibu_phone_rumah').val("{{$tbk_student->ibu_phone_rumah}}");
			$('#lmstpd_ibu_bil_anak').val("{{$tbk_student->ibu_bil_anak}}");
			$('#lmstpd_ibu_hubungan_student').val("{{$tbk_student->ibu_hubungan_student}}");
			$('#lmstpd_ibu_pilihan').val("{{$tbk_student->ibu_pilihan}}");
			$('#lmstpd_ibu_bil_anak_sekolah').val("{{$tbk_student->ibu_bil_anak_sekolah}}");
			$('#lmstpd_ibu_tabika_lain').val("{{$tbk_student->ibu_tabika_lain}}");
            $('#lmstpd_student_id').val("{{$tbk_student->id}}");
			$('#lmstpd_1_student_id').val("{{$tbk_student->id}}");
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

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{route('rt-sm27.lulus_mohon_student_tp_ppd','')}}"+"/"+"{{$tbk_student->id}}";
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
		$(document).on('submit', '#form_lmstpd', function(event){    
			event.preventDefault();
			$('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_submit').prop('disabled', true);
			var data = $("#form_lmstpd").serialize();
			var action = $('#post_lulus_permohonan_student').val();
			var btn_text;
			if (action == 'edit') {
				url = url_post_lulus_permohonan_student;
				type = "POST";
				btn_text = 'Hantar Status Kelulusan&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=lmstpd_student_status]').removeClass("is-invalid");
				$('[name=lmstpd_diluluskan_note]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'lmstpd_student_status') {
							$('[name=lmstpd_student_status]').addClass("is-invalid");
							$('.error_lmstpd_student_status').html(error);
						}

					});
					$('#btn_submit').html(btn_text);                
					$('#btn_submit').prop('disabled', false);            
				} else {
					$('#btn_submit').html(btn_text);
					$('#btn_submit').prop('disabled', false); 
					window.location.href = "{{route('rt-sm27.senarai_lulus_mohon_student_tp_ppd')}}";
				}
			});
		});

	

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop