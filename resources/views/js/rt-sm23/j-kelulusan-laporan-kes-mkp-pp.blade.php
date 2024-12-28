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

</style>
<script type="text/javascript">    
    
	$(document).ready( function () {

		//my custom script
			var permohonan_laporan_mediasi_mkp_config = {
				routes: {
					permohonan_laporan_mediasi_mkp_url: "/rt/sm23/kelulusan-laporan-kes-mkp-pp/{id}"
				}
			};
			url_table_pihak_terlibat		= "{{ route('rt-sm23.get_laporan_mediasi_terlibat_table','') }}"+"/"+"{{$laporan_mediasi->id}}";
			
        /* Maklumat Mediator */
			$('#klkmp_mkp_nama').val("{{$laporan_mediasi->mkp_nama}}");
			$('#klkmp_mkp_no_ic').val("{{$laporan_mediasi->mkp_no_ic}}");
			$('#klkmp_mkp_no_phone').val("{{$laporan_mediasi->mkp_no_phone}}");

		/* Maklumat Pembantu Mediator */
			$('#klkmp_mediasi_pembantu_nama').val("{{$laporan_mediasi->mediasi_pembantu_nama}}");
			$('#klkmp_mediasi_pembantu_ic').val("{{$laporan_mediasi->mediasi_pembantu_ic}}");
			$('#klkmp_mediasi_pembantu_phone').val("{{$laporan_mediasi->mediasi_pembantu_phone}}");

        /* Maklumat Status Semakan */
            $('#klkmp_imediator_mediasi_id').val("{{$laporan_mediasi->id}}");
            $('#klkmp_disahkan_note').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

		/* Maklumat Kes Mediasi */
			$('#klkmp2_mediasi_alamat').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

			var senarai_pihak_terlibat_table = $('#senarai_pihak_terlibat_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_pihak_terlibat,
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
						return full.pihak_pertama;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "44%", 
					"mRender": function ( value, type, full )  {
						return full.pihak_kedua;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});
			
            $('#klkmp_ref_mkp_kategori_id').val("{{$laporan_mediasi->ref_mkp_kategori_id}}");
			$('#klkmp_mediasi_tarikh').val("{{$laporan_mediasi->mediasi_tarikh}}");
			$('#klkmp_mediasi_alamat').val("{{$laporan_mediasi->mediasi_alamat}}");
			$('#klkmp_mediasi_ngo_terlibat').val("{{$laporan_mediasi->mediasi_ngo_terlibat}}");
			$('#klkmp_mediasi_ringkasan_kes').val("{{$laporan_mediasi->mediasi_ringkasan_kes}}");
			$('#klkmp_mediasi_status_kes').val("{{$laporan_mediasi->mediasi_status_kes}}");
			if($('#klkmp_mediasi_status_kes').val() == 'Selesai'){
				$("#mediasi_note_penyelesaian_kes").show();
				$("#mediasi_note_sebab_kes_xberjaya").hide();
			}else if($('#klkmp_mediasi_status_kes').val() == 'Tidak Selesai'){
				$("#mediasi_note_penyelesaian_kes").hide();
				$("#mediasi_note_sebab_kes_xberjaya").show();
			}
			$('#klkmp_mediasi_note_penyelesaian_kes').val("{{$laporan_mediasi->mediasi_note_penyelesaian_kes}}");
			$('#klkmp_mediasi_note_sebab_kes_xberjaya').val("{{$laporan_mediasi->mediasi_note_sebab_kes_xberjaya}}");

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{ route('rt-sm23.senarai_lulus_laporan_mediasi_pp') }}";
			});

	});

    /* click submit Kelulusan */
		//my custom script
		var lulusan_laporan_mediasi_config = {
			routes: {
				lulusan_laporan_mediasi_url: "{{ route('rt-sm23.post_lulus_laporan_mediasi_pp') }}",
			}
		};

        $(document).on('submit', '#form_klkmp', function(event){    
			event.preventDefault();
			$('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_submit').prop('disabled', true);
			var data = $("#form_klkmp").serialize();
			var action = $('#post_lulus_laporan_mediasi_pp').val();
			var btn_text;
			if (action == 'edit') {
				url = lulusan_laporan_mediasi_config.routes.lulusan_laporan_mediasi_url;
				type = "POST";
				btn_text = 'Hantar Status Kelulusan&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=klkmp_status]').removeClass("is-invalid");
				$('[name=klkmp_diluluskan_note]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'klkmp_status') {
							$('[name=klkmp_status]').addClass("is-invalid");
							$('.error_klkmp_status').html(error);
						}

						if(index == 'klkmp_diluluskan_note') {
							$('[name=klkmp_diluluskan_note]').addClass("is-invalid");
							$('.error_klkmp_diluluskan_note').html(error);
						}

					});
					$('#btn_submit').html(btn_text);                
					$('#btn_submit').prop('disabled', false);            
				} else {
					$('#btn_submit').html(btn_text);
					$('#btn_submit').prop('disabled', false); 
					window.location.href = "{{route('rt-sm23.senarai_lulus_laporan_mediasi_pp')}}";
				}
			});
		});
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="{{ asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
@stop