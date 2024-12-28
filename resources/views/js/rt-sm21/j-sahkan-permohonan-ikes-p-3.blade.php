@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
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
			url_table_kedudukan_kes 		= "{{ route('rt-sm21.get_ikes_kedudukan','') }}"+"/"+"{{$ikes->id}}";
			url_table_dokument_kes 			= "{{ route('rt-sm21.get_dokument_kes_table','') }}"+"/"+"{{$ikes->id}}";

		/* Maklumat Kes Dalam Krt */
			if("{{$ikes->hasRT}}" == 1){
				$('#apipn3_hasRT').attr("checked", "checked");
			}
			$('#apipn3_negeri_id').val("{{$ikes->krt_state_id}}");
			$('#apipn3_daerah_id').val("{{$ikes->krt_daerah_id}}");
			$('#apipn3_krt_profile_id').val("{{$ikes->krt_profile_id}}");

		/* Maklumat Pemohon */
			$('#apipn3_user_fullname').val("{{$ikes->nama_permohon}}");
			$('#apipn3_user_no_ic').val("{{$ikes->ic_pemohon}}");
			$('#apipn3_user_no_phone').val("{{$ikes->phone_pemohon}}");
			$('#apipn3_dihantar_alamat').val("{{$ikes->dihantar_alamat}}");

		/* Maklumat Status Pengesahan */
			$('#apipn3_spk_ikes_id').val("{{$ikes->id}}");
			$('#apipn3_disahkan_note').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

			if("{{$ikes->status}}" == 6){
				$('.sahkan_status_ppd').css("display", "block");
				$('.sahkan_status_ppn').css("display", "none");
				$('.sahkan_status_bpp').css("display", "none");
			}

			if("{{$ikes->status}}" == 10){
				$('.sahkan_status_ppd').css("display", "none");
				$('.sahkan_status_ppn').css("display", "block");
				$('.sahkan_status_bpp').css("display", "none");
			}

			if("{{$ikes->status}}" == 13){
				$('.sahkan_status_ppd').css("display", "none");
				$('.sahkan_status_ppn').css("display", "none");
				$('.sahkan_status_bpp').css("display", "block");
			}

		/* Maklumat Kes Kejadian */
			$('#apipn3_ikes_keadaan_semasa').val("{{$ikes->ikes_keadaan_semasa}}");
			$('#apipn3_ikes_jangkaan_keadaan').html("{{$ikes->ikes_jangkaan_keadaan}}");
			$('#apipn3_ikes_jangkaan_keadaan').summernote({
				height: 200
			});
			$("#apipn3_ikes_jangkaan_keadaan").summernote("disable");
			
        
			var senarai_kedudukan_kes_table = $('#senarai_kedudukan_kes_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_kedudukan_kes,
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
						return full.jenis_harta;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "28%", 
					"mRender": function ( value, type, full )  {
						return full.nilai_anggaran_kerosakan;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			var senarai_gambar_ikes_table = $('#senarai_gambar_ikes_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_dokument_kes,
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
					"width": "38%", 
					"mRender": function ( value, type, full )  {
						return full.file_title;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "30%", 
					"mRender": function ( value, type, full )  {
						return full.file_catatan;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "30%", 
					"mRender": function ( value, type, full )  {
						return full.file_dokument;
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Download Fail Peta Kawasan" id="download_dokument" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-download"></i></button>';
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
                window.location.href = "{{ route('rt-sm21.sahkan_permohonan_ikes_p_2','') }}"+"/"+"{{$ikes->id}}";
            });
	});

	/* click download dokument */
		//my custom script
		var download_dokument_ikes_config = {
			routes: {
				download_dokument_ikes_url: "{{ route('rt-sm21.get_data_ikes_dokument','') }}",
			}
		};

		$('body').on('click', '#download_dokument', function () {
			var download_id = $(this).data("id");
			$.get(download_dokument_ikes_config.routes.download_dokument_ikes_url + '/' + download_id, function (data) {
				let link = document.createElement("a");
				link.download = data.file_dokument;
				link.href = "{{ asset('storage/ikes_dokument') }}"+"/"+ data.file_dokument ;
				link.click();
			});
		});

	/* click submit akuan permohonan ikes */
		//my custom script
		var sahkan_permohonan_ikes_config = {
			routes: {
				sahkan_permohonan_ikes_url: "{{ route('rt-sm21.post_pengesahan_permohonan_ikes') }}",
			}
		};

		$(document).on('submit', '#form_apipn3', function(event){    
			event.preventDefault();
			$('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_submit').prop('disabled', true);
			var data = $("#form_apipn3").serialize();
			var action = $('#post_pengesahan_permohonan_ikes').val();
			var btn_text;
			if (action == 'edit') {
				url = sahkan_permohonan_ikes_config.routes.sahkan_permohonan_ikes_url;
				type = "POST";
				btn_text = 'Hantar Status Pengesahan&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=apipn3_ikes_status]').removeClass("is-invalid");
				$('[name=apipn3_disahkan_note]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'apipn3_ikes_status') {
							$('[name=apipn3_ikes_status]').addClass("is-invalid");
							$('.error_apipn3_ikes_status').html(error);
						}

						if(index == 'apipn3_disahkan_note') {
							$('[name=apipn3_disahkan_note]').addClass("is-invalid");
							$('.error_apipn3_disahkan_note').html(error);
						}

					});
					$('#btn_submit').html(btn_text);                
					$('#btn_submit').prop('disabled', false);            
				} else {
					$('#btn_submit').html(btn_text);
					$('#btn_submit').prop('disabled', false); 
					window.location.href = "{{route('rt-sm21.senarai_sahkan_permohonan_ikes_p')}}";
				}
			});
		});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop