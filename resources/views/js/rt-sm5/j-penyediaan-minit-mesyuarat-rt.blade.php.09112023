@include('js.modal.j-modal-add-kehadiran-mesyuarat-krt')
@include('js.modal.j-modal-view-kehadiran-mesyuarat-krt')
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
			url_get_senarai_kehadiran 			= "{{ route('rt-sm5.get_senarai_kehadiran','') }}"+"/"+"{{$krt_minit_mesyuarat->id}}";
			url_delete_kehadiran_mesyuarat 		= "{{ route('rt-sm5.delete_kehadiran','') }}";

		/* Maklumat Kawasan Krt */
			$('#pmmrt_nama_krt').html("{{$krt_profile->nama_krt}}");
			$('#pmmrt_alamat_krt').html("{{$krt_profile->alamat_krt}}");
			$('#pmmrt_negeri_krt').html("{{$krt_profile->negeri_krt}}");
			$('#pmmrt_daerah_krt').html("{{$krt_profile->daerah_krt}}");
			$('#pmmrt_parlimen_krt').html("{{$krt_profile->parlimen_krt}}");
			$('#pmmrt_dun_krt').html("{{$krt_profile->dun_krt}}");
			$('#pmmrt_pbt_krt').html("{{$krt_profile->pbt_krt}}");

		/* Maklumat Minit Mesyuarat */
			$('#pmmrt_minit_mesyuarat_id').val("{{$krt_minit_mesyuarat->id}}");
			$('#pmmrt_mesyuarat_title').val("{{$krt_minit_mesyuarat->mesyuarat_title}}");
			$('#pmmrt_mesyuarat_tarikh').val("{{$krt_minit_mesyuarat->mesyuarat_tarikh}}");
			$('#pmmrt_mesyuarat_bil').val("{{$krt_minit_mesyuarat->mesyuarat_bil}}");
			$('#pmmrt_mesyuarat_time').val("{{$krt_minit_mesyuarat->mesyuarat_time}}");
			$('#pmmrt_mesyuarat_tempat').val("{{$krt_minit_mesyuarat->mesyuarat_tempat}}");
			$('#pmmrt_mesyuarat_perutusan_pengerusi').html("{{$krt_minit_mesyuarat->mesyuarat_perutusan_pengerusi}}");
			$("#pmmrt_mesyuarat_perutusan_pengerusi").val($("<div>").html("{{$krt_minit_mesyuarat->mesyuarat_perutusan_pengerusi}}").text());
			$('#pmmrt_mesyuarat_yang_lalu').html("{{$krt_minit_mesyuarat->mesyuarat_yang_lalu}}");
		
			$('#pmmrt_mesyuarat_time').inputmask('hh:mm', { placeholder: '__:__ _m', alias: 'time24', hourFormat: '24' });

			$('#pmmrt_mesyuarat_tempat').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

			$('#pmmrt_mesyuarat_tempat').on("paste",function(e) {
                e.preventDefault();
            });

			$('#pmmrt_mesyuarat_perutusan_pengerusi').summernote({
				height: 200,
				callbacks: {
					onImageUpload: function (data) {
						data.pop();
					},
					onPaste: function (we, e, ne) {
						var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
						e.preventDefault();
						document.execCommand('insertText', false, bufferText);
					}
				},
			});
		
			$('#pmmrt_mesyuarat_yang_lalu').summernote({
				height: 200,
				callbacks: {
					onImageUpload: function (data) {
						data.pop();
					},
					onPaste: function (e) {
						e.preventDefault();
						document.execCommand('insertText', false, bufferText);
					}
				}
	// 			cleaner: {
    //   action: 'both', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
    //   icon: '<i class="note-icon"><svg xmlns="http://www.w3.org/2000/svg" id="libre-paintbrush" viewBox="0 0 14 14" width="14" height="14"><path d="m 11.821425,1 q 0.46875,0 0.82031,0.311384 0.35157,0.311384 0.35157,0.780134 0,0.421875 -0.30134,1.01116 -2.22322,4.212054 -3.11384,5.035715 -0.64956,0.609375 -1.45982,0.609375 -0.84375,0 -1.44978,-0.61942 -0.60603,-0.61942 -0.60603,-1.469866 0,-0.857143 0.61608,-1.419643 l 4.27232,-3.877232 Q 11.345985,1 11.821425,1 z m -6.08705,6.924107 q 0.26116,0.508928 0.71317,0.870536 0.45201,0.361607 1.00781,0.508928 l 0.007,0.475447 q 0.0268,1.426339 -0.86719,2.32366 Q 5.700895,13 4.261155,13 q -0.82366,0 -1.45982,-0.311384 -0.63616,-0.311384 -1.0212,-0.853795 -0.38505,-0.54241 -0.57924,-1.225446 -0.1942,-0.683036 -0.1942,-1.473214 0.0469,0.03348 0.27455,0.200893 0.22768,0.16741 0.41518,0.29799 0.1875,0.130581 0.39509,0.24442 0.20759,0.113839 0.30804,0.113839 0.27455,0 0.3683,-0.247767 0.16741,-0.441965 0.38505,-0.753349 0.21763,-0.311383 0.4654,-0.508928 0.24776,-0.197545 0.58928,-0.31808 0.34152,-0.120536 0.68974,-0.170759 0.34821,-0.05022 0.83705,-0.07031 z"/></svg></i>',
    //   keepHtml: true,
    //   keepTagContents: ['span'], //Remove tags and keep the contents
    //   badTags: ['applet', 'col', 'colgroup', 'embed', 'noframes', 'noscript', 'script', 'style', 'title', 'meta', 'link', 'head'], //Remove full tags with contents
    //   badAttributes: ['bgcolor', 'border', 'height', 'cellpadding', 'cellspacing', 'lang', 'start', 'style', 'valign', 'width', 'data-(.*?)'], //Remove attributes from remaining tags
    //   limitChars: 0, // 0|# 0 disables option
    //   limitDisplay: 'both', // none|text|html|both
    //   limitStop: false, // true/false
    //   notTimeOut: 850, //time before status message is hidden in miliseconds
    //   imagePlaceholder: 'https://via.placeholder.com/200'
    // }
			});

			var senarai_kehadiran_table = $('#senarai_kehadiran_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_get_senarai_kehadiran,
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
						return full.kehadiran_nama;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "44%", 
					"mRender": function ( value, type, full )  {
						return full.kehadiran_ic;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "6%", 
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_kehadiran_mesyuarat_krt(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
						button_b = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_kehadiran_mesyuarat" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a + button_b;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

		/* Maklumat Note Kemaskini */
			$('#pmmrt_status').val("{{$krt_minit_mesyuarat->mesyuarat_status}}");
            
            if($('#pmmrt_status').val() == '4'){
                $("#pmmrt_perlu_kemaskini").show();
                $('#pmmrt_status_description').html("{{$krt_minit_mesyuarat->status_description}}");
                $('#pmmrt_disahkan_note').html("{{$krt_minit_mesyuarat->disemak_note}}");
            }

		/* Maklumat Button */

			$('#btn_back').click(function(){
				window.location.href = '{{route('rt-sm5.senarai_minit_mesyuarat_rt')}}';
			});

	});

	/* Senarai Kehadiran */
		var add_kehadiran_mesyuarat_config = {
			routes: {
				add_kehadiran_mesyuarat_url: "{{ route('rt-sm5.add_kehadiran_mesyuarat') }}",
			}
		};
		// add Kehadiran
		$(document).on('submit', '#form_makmk', function(event){    
			event.preventDefault();
			$('#btn_save').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			
			var data = $("#form_makmk").serialize();
			var action = $('#add_kehadiran_mesyuarat').val();
			var btn_text;
			if (action == 'add') {
				url = add_kehadiran_mesyuarat_config.routes.add_kehadiran_mesyuarat_url;
				type = "POST";
				btn_text = '<i class="fe fe-plus mr-2"></i> Tambah';
			}

			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=makmk_kehadiran_nama]').removeClass("is-invalid");
				$('[name=makmk_kehadiran_ic]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'makmk_kehadiran_nama') {
							$('[name=makmk_kehadiran_nama]').addClass("is-invalid");
							$('.error_makmk_kehadiran_nama').html(error);
						}

						if(index == 'makmk_kehadiran_ic') {
							$('[name=makmk_kehadiran_ic]').addClass("is-invalid");
							$('.error_makmk_kehadiran_ic').html(error);
						}

					});
					$('#btn_save').html(btn_text);                
					$('#btn_save').prop('disabled', false);            
				} else {
					$('#modal_add_kehadiran_mesyuarat_krt').modal('hide');
					swal("Maklumat Senarai Kehadiran ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_makmk').trigger("reset");
					$('#btn_save').html(btn_text);
					$('btn_save').prop('disabled', false);
					$('#senarai_kehadiran_table').DataTable().ajax.reload();
				}
			});
		});

		// Deleted Kehadiran
		$('body').on('click', '#delete_kehadiran_mesyuarat', function () {
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
						url: url_delete_kehadiran_mesyuarat +"/" + delete_id,
						success: function (data) {
							$('#senarai_kehadiran_table').DataTable().ajax.reload();
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

		//my custom script
		var add_minit_mesyuarat_rt_config = {
			routes: {
				add_minit_mesyuarat_rt_url: "{{ route('rt-sm5.post_penyediaan_minit_mesyuarat_rt') }}",
			}
		};

		$(document).on('submit', '#form_pmmrt', function(event){    
			event.preventDefault();
			$('#btn_next').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_next').prop('disabled', true);
			var data = $("#form_pmmrt").serialize();
			var action = $('#post_penyediaan_minit_mesyuarat_rt').val();
			var btn_text;
			if (action == 'edit') {
				url = add_minit_mesyuarat_rt_config.routes.add_minit_mesyuarat_rt_url;
				type = "POST";
				btn_text = 'Seterusnya &nbsp;<i class="dropdown-icon fe fe-arrow-right"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=pmmrt_mesyuarat_title]').removeClass("is-invalid");
				$('[name=pmmrt_mesyuarat_tarikh]').removeClass("is-invalid");
				$('[name=pmmrt_mesyuarat_bil]').removeClass("is-invalid");
				$('[name=pmmrt_mesyuarat_time]').removeClass("is-invalid");
				$('[name=pmmrt_mesyuarat_tempat]').removeClass("is-invalid");
				$('[name=pmmrt_mesyuarat_perutusan_pengerusi]').removeClass("is-invalid");
				$('[name=pmmrt_mesyuarat_yang_lalu]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'pmmrt_mesyuarat_title') {
							$('[name=pmmrt_mesyuarat_title]').addClass("is-invalid");
							$('.error_pmmrt_mesyuarat_title').html(error);
						}

						if(index == 'pmmrt_mesyuarat_tarikh') {
							$('[name=pmmrt_mesyuarat_tarikh]').addClass("is-invalid");
							$('.error_pmmrt_mesyuarat_tarikh').html(error);
						}

						if(index == 'pmmrt_mesyuarat_bil') {
							$('[name=pmmrt_mesyuarat_bil]').addClass("is-invalid");
							$('.error_pmmrt_mesyuarat_bil').html(error);
						}

						if(index == 'pmmrt_mesyuarat_time') {
							$('[name=pmmrt_mesyuarat_time]').addClass("is-invalid");
							$('.error_pmmrt_mesyuarat_time').html(error);
						}

						if(index == 'pmmrt_mesyuarat_tempat') {
							$('[name=pmmrt_mesyuarat_tempat]').addClass("is-invalid");
							$('.error_pmmrt_mesyuarat_tempat').html(error);
						}

						if(index == 'pmmrt_mesyuarat_perutusan_pengerusi') {
							$('[name=pmmrt_mesyuarat_perutusan_pengerusi]').addClass("is-invalid");
							$('.error_pmmrt_mesyuarat_perutusan_pengerusi').html(error);
						}

						if(index == 'pmmrt_mesyuarat_yang_lalu') {
							$('[name=pmmrt_mesyuarat_yang_lalu]').addClass("is-invalid");
							$('.error_pmmrt_mesyuarat_yang_lalu').html(error);
						}

					});
					$('#btn_next').html(btn_text);                
					$('#btn_next').prop('disabled', false);            
				} else {
					$('#btn_next').html(btn_text);
					$('#btn_next').prop('disabled', false); 
					window.location.href = "{{route('rt-sm5.penyediaan_minit_mesyuarat_rt_1','')}}"+"/"+{{$krt_minit_mesyuarat->id}};
				}
			});
		});
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>

<script src="../assets/bundles/dataTables.bundle.js"></script>
<script src="assets/js/table/datatable.js"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

<!-- <script src="../assets/bundles/summernote.bundle.js"></script>
<script src="assets/js/page/summernote.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="{{ asset('assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
@stop