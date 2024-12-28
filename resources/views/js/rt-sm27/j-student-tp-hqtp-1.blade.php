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
           
			
        /* Maklumat Tabika Perpaduan */
			$('#sthq_state_id').val("{{$tbk_student->state_id}}");
			$('#sthq_daerah_id').val("{{$tbk_student->daerah_id}}");
			$('#sthq_tabika_id').val("{{$tbk_student->tabika_id}}");

		/* Bahagian B : Maklumat Ibu */
			$('#sthq_ibu_nama').val("{{$tbk_student->ibu_nama}}");
			$('#sthq_ibu_pekerjaan').val("{{$tbk_student->ibu_pekerjaan}}");
			$('#sthq_ibu_profession_id').val("{{$tbk_student->ibu_profession_id}}");
			$('#sthq_ibu_pendapatan').val("{{$tbk_student->ibu_pendapatan}}");
			$('#sthq_ibu_kerakyatan_id').val("{{$tbk_student->ibu_kerakyatan_id}}");
			$('#sthq_ibu_jumlah_pendapatan').val("{{$tbk_student->ibu_jumlah_pendapatan}}");
			$('#sthq_ibu_jumlah_pendapatan_lain').val("{{$tbk_student->ibu_jumlah_pendapatan_lain}}");
			$('#sthq_ibu_ic').val("{{$tbk_student->ibu_ic}}");
			$('#sthq_ibu_alamat_office').val("{{$tbk_student->ibu_alamat_office}}");
			$('#sthq_ibu_phone_office').val("{{$tbk_student->ibu_phone_office}}");
			$('#sthq_ibu_phone').val("{{$tbk_student->ibu_phone}}");
			$('#sthq_ibu_phone_rumah').val("{{$tbk_student->ibu_phone_rumah}}");
			$('#sthq_ibu_bil_anak').val("{{$tbk_student->ibu_bil_anak}}");
			$('#sthq_ibu_hubungan_student').val("{{$tbk_student->ibu_hubungan_student}}");
			$('#sthq_ibu_pilihan').val("{{$tbk_student->ibu_pilihan}}");
			$('#sthq_ibu_bil_anak_sekolah').val("{{$tbk_student->ibu_bil_anak_sekolah}}");
			$('#sthq_ibu_tabika_lain').val("{{$tbk_student->ibu_tabika_lain}}");
            $('#sthq_student_id').val("{{$tbk_student->id}}");
			$('#sthq_1_student_id').val("{{$tbk_student->id}}");
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
				window.location.href = "{{route('rt-sm27.student_tp_hqtp','')}}"+"/"+"{{$tbk_student->id}}";
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

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop